<?php

namespace models\db;

use models\Album;
use models\db\ArtisteDB;
use models\Artiste;
use models\Musique;

class AlbumDB {
    public static function addAlbum(Album $album): bool {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO album(titreAlbum, anneeAlbum, imgAlbum, description) VALUES (:titre, :annee, :imageAl, :description)");
        $titreAlbum = $album->getTitre();
        $stmt->bindParam(":titre", $titreAlbum);
        $annee = $album->getAnnee();
        $stmt->bindParam(":annee", $annee);
        $imgAlbum = $album->getImage();
        $stmt->bindParam(":imageAl", $imgAlbum);
        $description = $album->getDescription();
        $stmt->bindParam(":description", $description);
        return $stmt->execute();
    }

    public static function getAlbum(int $id): ?Album {
        $db = Database::getInstance();
        $result = $db->query("SELECT album.*, artiste.*, musique.* FROM album JOIN artiste ON album.idA = artiste.idA LEFT JOIN musique ON musique.idAlbum = album.idAlbum WHERE album.idAlbum = $id");
        $album = null;
        foreach ($result as $r) {
            if (!$album) {
                $artiste = new Artiste($r["idA"], $r["nomA"]);
                $description = $r["description"] ?? '';
                $album = new Album($r["idAlbum"], $r["titreAlbum"], $artiste, $r["imgAlbum"], $r["anneeAlbum"], [], $description);

            }
    
            if ($r["idM"]) {
                $album->addMusique(new Musique($r["idM"], $r["nomM"],"lien"));
            }
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
                $artiste = new Artiste($s["idA"], $s["nomA"]);
                $description = $s["description"] ?? '';
                $album = new Album($s["idAlbum"], $s["titreAlbum"], $artiste, $s["imgAlbum"], $s["anneeAlbum"], [], $description);
                $albums[$idAlbum] = $album;
            }
    
            if ($s["idM"]) {
                $musique = new Musique($s["idM"], $s["nomM"], "lien");
                $albums[$idAlbum]->addMusique($musique);
            }
        }
    
        return array_values($albums);
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