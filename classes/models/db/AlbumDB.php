<?php

namespace models\db;

use models\Album;
use models\db\ArtisteDB;

class AlbumDB {

    /**
     * @return Album[]
     */
    public static function getAlbums(): array {
        $db = Database::getInstance();
        $albums = [];
        $result = $db->query("SELECT * FROM album");
        foreach($result as $r) {
            $albums[] = new Album($r["idAlbum"], $r["titreAlbum"], $r["anneeAlbum"], $r["imageAlbum"]);
        }
        return $albums;
    }

    /**
     * @return Album
     */
    public static function getAlbum(int $id): ?Album {
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM album WHERE idAlbum = $id");
        $r = $result->fetch();
        if($r) {
            return new Album($r["idAlbum"], $r["titreAlbum"], $r["anneeAlbum"], "");
        }
        return null;
    }

    /**
     * @param Album $album
     * @return bool
     */
    public static function addAlbum(Album $album): bool {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO album(titreAlbum, anneeAlbum) VALUES (:titre, :annee)");
        $titreAlbum = $album->getTitreAlbum();
        $stmt->bindParam(":titre", $album->getTitreAlbum());
        $annee = $album->getAnneeAlbum();
        $stmt->bindParam(":annee", $annee);
        $stmt->bindParam(":image", $album->getImageAlbum());
        return $stmt->execute();
    }

    /**
     * @return Album[]
     */
    public static function getAlbumsArtiste(int $id): array {
        $db = Database::getInstance();
        $albums = [];
        $result = $db->query("SELECT * FROM album WHERE idA = $id");
        foreach($result as $r) {
            $albums[] = new Album($r["idAlbum"], $r["titreAlbum"], $r["anneeAlbum"], "");
        }
        return $albums;
    }

    // Insertion d'un album
    public static function insererAlbum($titreAlbum, $anneeAlbum, $imgAlbum){
        $db = Database::getInstance();
        $stmt = $db->prepare('INSERT INTO album (titreAlbum, anneeAlbum, imgAlbum, idA) VALUES (:titreAlbum, :anneeAlbum, :imgAlbum, :idA)');
        $stmt->bindParam(':titreAlbum', $titreAlbum);
        $stmt->bindParam(':anneeAlbum', $anneeAlbum);
        $stmt->bindParam(':imgAlbum', $imgAlbum);

        $idA = ArtisteDB::creerIdArtiste();
        // $idA = ArtisteDB::getIdArtiste($nom);

        $stmt->bindParam(':idA', $idA);
        $stmt->execute();
        return $db->lastInsertId();
    }

    // Récupération de l'id d'un album
    public static function getIdAlbum($titreAlbum){
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT idAlbum FROM album WHERE titreAlbum = :titreAlbum');
        $stmt->bindParam(':titreAlbum', $titreAlbum);
        $stmt->execute();
        return $stmt->fetch();
    }


}