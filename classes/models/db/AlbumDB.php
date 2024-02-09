<?php

namespace models\db;

use models\Album;
use models\db\ArtisteDB;
use models\Artiste;
use models\Musique;

class AlbumDB {

    public static function getAlbum(int $id): ?Album {
        $db = Database::getInstance();
        $result = $db->query("SELECT album.*, artiste.*, musique.* FROM album JOIN artiste ON album.idA = artiste.idA LEFT JOIN musique ON musique.idAlbum = album.idAlbum WHERE album.idAlbum = $id");
        $album = null;

        foreach ($result as $r) {
            if (!$album) {
                $descriptionA = $r["descriptionA"] ?? '';
                $album = new Album($r["idAlbum"], $r["titreAlbum"], $r["idA"], $r["imgAlbum"], $r["anneeAlbum"], $descriptionA);
            }
        }

        if (!$album) {
            return null;
        }

        return $album;
    }

    public static function getInfosCardsAlbum(string $category): array {
        $db = Database::getInstance();
        $conditions = '';
        switch ($category) {
            case 'Récents':
                $conditions = 'ORDER BY album.anneeAlbum DESC';
                break;
            case 'Populaires':
                // a faire quand on aura le nb d'écoute
                break;
            default:
                $conditions = "ORDER BY album.idAlbum DESC";
                break;
        }
    
        $stmt = $db->query("SELECT album.*, artiste.*, musique.* FROM album JOIN artiste ON album.idA = artiste.idA LEFT JOIN musique ON musique.idAlbum = album.idAlbum $conditions");
        $albums = [];
    
        foreach ($stmt as $s) {
            $idAlbum = $s["idAlbum"];
            if (!isset($albums[$idAlbum])) {
                $descriptionA = $s["descriptionA"] ?? '';
                $album = new Album($s["idAlbum"], $s["titreAlbum"], $s["idA"], $s["imgAlbum"], $s["anneeAlbum"], $descriptionA);
                $albums[$idAlbum] = $album;
            }
        }
        return array_values($albums);
    }

    // Insertion d'un album
    public static function insererAlbum($titreAlbum, $anneeAlbum, $imgAlbum, $descriptionA, $idA){
        $db = Database::getInstance();
        
        $stmt = $db->prepare('INSERT INTO album (titreAlbum, anneeAlbum, imgAlbum, descriptionA, idA) VALUES (:titreAlbum, :anneeAlbum, :imgAlbum, :descriptionA, :idA)');
        $stmt->bindParam(':titreAlbum', $titreAlbum);
        $stmt->bindParam(':anneeAlbum', $anneeAlbum);
        $stmt->bindParam(':imgAlbum', $imgAlbum);
        $stmt->bindParam(':descriptionA', $descriptionA);
        $stmt->bindParam(':idA', $idA);

        $stmt->execute();
        return $db->lastInsertId();
    }

    // Récupération de l'id d'un album
    public static function getIdAlbumByTitle($titreAlbum){
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT idAlbum FROM album WHERE titreAlbum = :titreAlbum');
        $stmt->bindParam(':titreAlbum', $titreAlbum);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Récupération des albums d'un artiste
    public static function getAlbumsArtiste($idArtiste){
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM album WHERE idA = :idA');
        $stmt->bindParam(':idA', $idArtiste);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getIdAlbum() {
        $db = Database::getInstance();
        $stmt = $db->query('SELECT MAX(idAlbum) FROM album');
        $result = $stmt->fetchColumn();
        return $result;
    }

    public static function getImageAlbum($idAlbum) {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT imgAlbum FROM album WHERE idAlbum = :idAlbum');
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
        return $stmt->fetch();
    }


}