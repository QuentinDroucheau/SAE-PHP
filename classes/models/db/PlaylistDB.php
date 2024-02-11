<?php

namespace models\db;

use models\Playlist;
use models\Musique;
use models\Utilisateur;

class PlaylistDB {
    public static function addPlaylist(Playlist $playlist): bool {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO playlist(titrePlaylist, datePlaylist, imgPlaylist, description, idU) VALUES (:titre, :date, :imagePl, :description, :idU)");
        $titrePlaylist = $playlist->getTitre();
        $stmt->bindParam(":titre", $titrePlaylist);
        $date = $playlist->getDatePublication();
        $stmt->bindParam(":date", $date);
        $imgPlaylist = $playlist->getImage();
        $stmt->bindParam(":imagePl", $imgPlaylist);
        $description = $playlist->getDescription();
        $stmt->bindParam(":description", $description);
        $idU = $playlist->getIdAuteur();
        $stmt->bindParam(":idU", $idU);
        return $stmt->execute();
    }

    public static function getPlaylists(int $id): ?Playlist {
        $db = Database::getInstance();
        $result = $db->query("SELECT playlist.*, musique.*, utilisateur.* FROM playlist LEFT JOIN musique ON musique.idPlaylist = playlist.idPlaylist LEFT JOIN utilisateur ON utilisateur.idU = playlist.idU WHERE playlist.idPlaylist = $id");
        $playlist = null;
        foreach ($result as $r) {
            if (!$playlist) {
                $auteur = new Utilisateur($r["idU"], $r["pseudoU"], $r["mdpU"], $r["roleU"]);
                $description = $r["description"] ?? '';
                $playlist = new Playlist($r["idPlaylist"], $r["titrePlaylist"], $auteur->getId(), $r["imgPlaylist"], $r["datePlaylist"], $description, $r["dateMAJ"]);

            }
        }
    
        return $playlist;
    }
}