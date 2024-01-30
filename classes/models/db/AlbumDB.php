<?php

namespace models\db;

use models\Album;

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
}