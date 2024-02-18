<?php

namespace models\db;

use models\Album;
use models\Playlist;
use models\db\MusiqueDB;
use models\Musique;
use models\Note;
use models\Utilisateur;

class PlaylistDB
{
    public static function insererPlaylist(string $titre, string $descriptionP, int $auteur, string $dateMaj, string $image, string $anneeP): ?string
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO playlist(nomP, descriptionP, idU, dateMajP, imgPlaylist, anneeP) VALUES (:titre, :descriptionP, :idU, :dateMaj, :imagePl, :anneeP)");
        $stmt->bindParam(":titre", $titre);
        $stmt->bindParam(":descriptionP", $descriptionP);
        $stmt->bindParam(":idU", $auteur);
        $stmt->bindParam(":dateMaj", $dateMaj);
        $stmt->bindParam(":imagePl", $image);
        $stmt->bindParam(":anneeP", $anneeP);
        $stmt->execute();
        $id = $db->lastInsertId();
        $nbMusique = MusiqueDB::getNbMusiquesPlaylist($id);
        return json_encode([
            'success' => true,
            'message' => 'Playlist publiée avec succès',
            'playlistId' => $id,
            'titre' => $titre,
            'image' => $image,
            'auteurNom' => $auteur,
            'dateMaj' => $dateMaj,
            'nbMusiques' => $nbMusique,
        ]);
    }

    public static function addMusiqueInPlaylist(int $idMusique, int $idPlaylist): bool{
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO composer(idM, idP, dateAjout) VALUES (:idM, :idP, :dateAjout)");
        $stmt->bindParam(":idM", $idMusique);
        $stmt->bindParam(":idP", $idPlaylist);
        $time = time();
        $stmt->bindParam(":dateAjout", $time);
        return $stmt->execute();
    }

    public static function removeMusiqueInPlaylist(int $idMusique, int $idPlaylist): bool{
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM composer WHERE idM = :idM AND idP = :idP");
        $stmt->bindParam(":idM", $idMusique);
        $stmt->bindParam(":idP", $idPlaylist);
        return $stmt->execute();
    }

    public static function getPlaylists(int $userId): array
    {
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM playlist WHERE idU = $userId");
        $playlists = [];
        foreach ($result as $r) {
            $playlists[] = new Playlist(
                $r["idP"],
                $r["nomP"],
                UtilisateurDB::getUtilisateurById($r["idU"]),
                $r["imgPlaylist"],
                $r["anneeP"],
                $r["descriptionP"],
                $r["dateMajP"]
            );
        }
        return $playlists;
    }

    public static function getPlaylist(int $playlistId): ?Playlist
    {
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM playlist WHERE idP = $playlistId");
        $r = $result->fetch();
        return new Playlist(
            $r["idP"],
            $r["nomP"],
            UtilisateurDB::getUtilisateurById($r["idU"]),
            $r["imgPlaylist"],
            $r["anneeP"],
            $r["descriptionP"],
            $r["dateMajP"]
        );
    }

    public static function searchPlaylists($search){
        $db = Database::getInstance();
        $search = '%' . $search . '%';
        $stmt = $db->prepare("SELECT * FROM playlist WHERE nomP LIKE :search");
        $stmt->bindParam(":search", $search);
        $stmt->execute();
        $playlists = [];
        while ($row = $stmt->fetch()) {
            $playlist = new Playlist(
                $row["idP"],
                $row["nomP"],
                UtilisateurDB::getUtilisateurById($row["idU"]),
                $row["imgPlaylist"],
                $row["anneeP"],
                $row["descriptionP"],
                $row["dateMajP"]
            );
            $playlists[] = $playlist;
        }
        return $playlists;
    }

    public static function effacerPlaylist(int $playlistId): ?string
{
    $db = Database::getInstance();

    $stmt = $db->prepare("DELETE FROM composer WHERE idP = :idP");
    $stmt->bindParam(":idP", $playlistId);
    $stmt->execute();
    $stmt = $db->prepare("DELETE FROM playlist WHERE idP = :idP");
    $stmt->bindParam(":idP", $playlistId);
    $stmt->execute();
    return json_encode([
        'success' => true,
        'message' => 'Playlist et les sons associés ont été effacés avec succès',
    ]);
}

    /**
     * @param int $playlistId
     * @return Musique[]
     */
    public static function getMusiques(int $playlistId): array{
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM composer NATURAL JOIN musique natural join album WHERE idP = $playlistId");
        $musiques = [];
        foreach($result as $r){
            $musiques[] = new Musique(
                $r["idM"],
                $r["nomM"],
                $r["lienM"],
                MusiqueDB::getNbEcoute($r["idM"]),
                $r["titreAlbum"]
            );
        }
        return $musiques;
    }
}
