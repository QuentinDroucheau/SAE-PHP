<?php

namespace models\db;

use models\Playlist;
use models\Musique;
use models\Utilisateur;

class PlaylistDB {
    // public static function addPlaylist(Playlist $playlist): bool {
    //     $db = Database::getInstance();
    //     $stmt = $db->prepare("INSERT INTO playlist(titrePlaylist, datePlaylist, imgPlaylist, description, idU) VALUES (:titre, :date, :imagePl, :description, :idU)");
    //     $titrePlaylist = $playlist->getTitre();
    //     $stmt->bindParam(":titre", $titrePlaylist);
    //     $date = $playlist->getDatePublication();
    //     $stmt->bindParam(":date", $date);
    //     $imgPlaylist = $playlist->getImage();
    //     $stmt->bindParam(":imagePl", $imgPlaylist);
    //     $description = $playlist->getDescription();
    //     $stmt->bindParam(":description", $description);
    //     $idU = $playlist->getIdAuteur();
    //     $stmt->bindParam(":idU", $idU);
    //     return $stmt->execute();
    // }

    public static function insererPlaylist(string $titre, string $descriptionP, int $auteur, string $dateMaj, string $image): bool {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO playlist(nomP, anneeP, imgP, descriptionP, imgP, idU, dateMAJ) VALUES (:titre, NOW(), :imagePl, :description, :idU, :dateMaj)");
        $stmt->bindParam(":titre", $titre);
        $stmt->bindParam(":imagePl", $image);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":idU", $auteur);
        $stmt->bindParam(":dateMaj", $dateMaj);
        return $stmt->execute();
    }

    public static function getPlaylists(int $userId): array {
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM playlist WHERE idU = $userId");
        $playlists = [];
        foreach ($result as $r) {
            $playlists[] = new Playlist(
                $r["idP"],
                $r["nomP"],
                $r["idU"],
                $r["imgPlaylist"],
                $r["anneeP"],
                $r["descriptionP"],
                $r["dateMajP"]
            );
        }
        return $playlists;
    }
}