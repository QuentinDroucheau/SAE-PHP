<?php

namespace models\db;

use models\Album;
use models\Artiste;
use models\Musique;


class AlbumDB {

    // /**
    //  * @return Album[]
    //  */
    // public static function getAlbums(): array {
    //     $db = Database::getInstance();
    //     $albums = [];
    //     $result = $db->query("SELECT * FROM album");
    //     foreach($result as $r) {
    //     $albums[] = new Album($r["idAlbum"], $r["titreAlbum"], $r["anneeAlbum"], "image");
    //     }
    //     return $albums;
    // }
    
        /**
         * @param Album $album
         * @return bool
         */
        public static function addAlbum(Album $album): bool {
            $db = Database::getInstance();
            $stmt = $db->prepare("INSERT INTO album(titreAlbum, anneeAlbum, imgAlbum) VALUES (:titre, :annee, :imageAl)");
            $titreAlbum = $album->getTitreAlbum();
            $stmt->bindParam(":titre", $titreAlbum);
            $annee = $album->getAnneeAlbum();
            $stmt->bindParam(":annee", $annee);
            $imgAlbum = $album->getImageAlbum();
            $stmt->bindParam(":imageAl", $imgAlbum);
            return $stmt->execute();
        }
    /**
     * @return Album
     */
    public static function getAlbum(int $id): ?Album {
        $db = Database::getInstance();
        $result = $db->query("SELECT album.*, artiste.*, musique.* FROM album JOIN artiste ON album.idA = artiste.idA LEFT JOIN musique ON musique.idAlbum = album.idAlbum WHERE album.idAlbum = $id");
        $album = null;
        foreach ($result as $r) {
            if (!$album) {
                $artiste = new Artiste($r["idA"], $r["nomA"]);
                $album = new Album($r["idAlbum"], $r["titreAlbum"], $r["anneeAlbum"], $r["imgAlbum"], $artiste, []);
            }
    
            if ($r["idM"]) {
                $album->musiques[] = new Musique($r["idM"], $r["nomM"],"lien");
            }
        }
    
        return $album;
    }
    
    public static function getInfosCardsAlbum(string $category): array {
        $db = Database::getInstance();
        $conditions = '';
        switch ($category) {
            case 'recents':
                $conditions = 'ORDER BY album.anneeAlbum DESC';
                break;
            case 'populaires':
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
                $artiste = new Artiste($s["idA"], $s["nomA"]);
                $album = new Album($s["idAlbum"], $s["titreAlbum"], $s["anneeAlbum"], $s["imgAlbum"], $artiste, []);
                $albums[$idAlbum] = $album;
            }

            if ($s["idM"]) {
                $albums[$idAlbum]->musiques[] = new Musique($s["idM"], $s["nomM"], "lien");
            }
        }

        return array_values($albums);
    }
}