<?php

namespace models\db;

use models\Album;
use models\db\ArtisteDB;
use models\Musique;

class AlbumDB
{

    public static function getAlbum(int $id): ?Album
    {
        $db = Database::getInstance();
        $result = $db->query("SELECT album.*, artiste.*, musique.* FROM album JOIN artiste ON album.idA = artiste.idA LEFT JOIN musique ON musique.idAlbum = album.idAlbum WHERE album.idAlbum = $id");
        $album = null;

        foreach ($result as $r) {
            if (!$album) {
                $descriptionA = $r["descriptionA"] ?? '';
                $album = new Album(
                    $r["idAlbum"],
                    $r["titreAlbum"],
                    ArtisteDB::getArtiste($r["idA"]),
                    $r["imgAlbum"],
                    $r["anneeAlbum"],
                    self::getNoteAlbum($id),
                    self::getNbEcouteAlbum($r["idAlbum"]),
                    $descriptionA,
                    self::getMusiques($r["idAlbum"])
                );
            }
        }

        if (!$album) {
            return null;
        }

        return $album;
    }

    public static function getInfosCardsAlbum(string $category): array
    {
        $db = Database::getInstance();
        $conditions = '';
        switch ($category) {
            case 'Récents':
                $conditions = "ORDER BY SUBSTR(anneeAlbum, 7, 4) || SUBSTR(anneeAlbum, 4, 2) || SUBSTR(anneeAlbum, 1, 2) DESC";
                break;
            case 'Populaires':
                // a faire quand on aura le nb d'écoute
                break;
            default:
                $conditions = "ORDER BY album.idAlbum DESC";
                break;
        }

        $stmt = $db->query("SELECT * from ALBUM $conditions LIMIT 10");
        $albums = [];

        foreach ($stmt as $s) {
            $idAlbum = $s["idAlbum"];
            if (!isset($albums[$idAlbum])) {
                $descriptionA = $s["descriptionA"] ?? '';
                $album = new Album(
                    $s["idAlbum"],
                    $s["titreAlbum"],
                    ArtisteDB::getArtiste($s["idA"]),
                    $s["imgAlbum"],
                    $s["anneeAlbum"],
                    self::getNoteAlbum($s["idAlbum"]),
                    self::getNbEcouteAlbum($s["idAlbum"]),
                    $descriptionA,
                    self::getMusiques($s["idAlbum"])
                );
                $albums[$idAlbum] = $album;
            }
        }
        return array_values($albums);
    }

    public static function getAllAlbumsByCategory($category, $year = null, $genre = null, $artistId = null)
    {
        $db = Database::getInstance();
        $conditions = '';
        switch ($category) {
            case 'Récents':
                $conditions = "ORDER BY SUBSTR(anneeAlbum, 7, 4) || SUBSTR(anneeAlbum, 4, 2) || SUBSTR(anneeAlbum, 1, 2) DESC";
                break;
            case 'Populaires':
                // à faire quand on aura le nb d'écoute
                break;
            default:
                $conditions = "ORDER BY idAlbum DESC";
                break;
        }
        $yearCondition = '';
        if ($year) {
            $year = "%$year%";
            $yearCondition = "AND anneeAlbum LIKE :year";
        }
        $genreCondition = '';
        if ($genre) {
            $genreCondition = "AND idAlbum IN (SELECT idAlbum FROM musique NATURAL JOIN contient WHERE idG = :genre)";
        }
        $artistCondition = '';
        if ($artistId) {
            $artistCondition = "AND idA = :artistId";
        }
        $stmt = $db->prepare("SELECT * FROM ALBUM WHERE 1=1 $yearCondition $genreCondition $artistCondition $conditions");
        if ($year) {
            $stmt->bindParam(":year", $year);
        }
        if ($genre) {
            $stmt->bindParam(":genre", $genre);
        }
        if ($artistId) {
            $stmt->bindParam(":artistId", $artistId);
        }
        $stmt->execute();
        $albums = [];

        foreach ($stmt as $s) {
            $idAlbum = $s["idAlbum"];
            if (!isset($albums[$idAlbum])) {
                $descriptionA = $s["descriptionA"] ?? '';
                $album = new Album(
                    $s["idAlbum"],
                    $s["titreAlbum"],
                    ArtisteDB::getArtiste($s["idA"]),
                    $s["imgAlbum"],
                    $s["anneeAlbum"],
                    self::getNoteAlbum($s["idAlbum"]),
                    self::getNbEcouteAlbum($s["idAlbum"]),
                    $descriptionA,
                    self::getMusiques($s["idAlbum"])
                );
                $albums[$idAlbum] = $album;
            }
        }
        return array_values($albums);
    }


    // Insertion d'un album
    public static function insererAlbum($titreAlbum, $anneeAlbum, $imgAlbum, $descriptionA, $idA)
    {
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
    public static function getIdAlbumByTitle($titreAlbum)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT idAlbum FROM album WHERE titreAlbum = :titreAlbum');
        $stmt->bindParam(':titreAlbum', $titreAlbum);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Récupération des albums d'un artiste
    public static function getAlbumsArtiste($idArtiste)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM album WHERE idA = :idA');
        $stmt->bindParam(':idA', $idArtiste);
        $stmt->execute();

        $albums = [];
        while ($row = $stmt->fetch()) {
            $descriptionA = $row["descriptionA"] ?? '';
            $album = new Album(
                $row["idAlbum"],
                $row["titreAlbum"],
                ArtisteDB::getArtiste($row["idA"]),
                $row["imgAlbum"],
                $row["anneeAlbum"],
                self::getNoteAlbum($row["idAlbum"]),
                self::getNbEcouteAlbum($row["idAlbum"]),
                $descriptionA,
                self::getMusiques($row["idAlbum"])
            );
            $albums[] = $album;
        }

        return $albums;
    }

    public static function getIdAlbum()
    {
        $db = Database::getInstance();
        $stmt = $db->query('SELECT MAX(idAlbum) FROM album');
        $result = $stmt->fetchColumn();
        return $result;
    }

    public static function getImageAlbum($idAlbum)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT imgAlbum FROM album WHERE idAlbum = :idAlbum');
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getAlbums()
    {
        $db = Database::getInstance();
        $stmt = $db->query('SELECT * FROM album');
        $albums = [];
        while ($row = $stmt->fetch()) {
            $descriptionA = $row["descriptionA"] ?? '';
            $album = new Album(
                $row["idAlbum"],
                $row["titreAlbum"],
                ArtisteDB::getArtiste($row["idA"]),
                $row["imgAlbum"],
                $row["anneeAlbum"],
                self::getNoteAlbum($row["idAlbum"]),
                self::getNbEcouteAlbum($row["idAlbum"]),
                $descriptionA,
                self::getMusiques($row["idAlbum"])
            );

            $albums[] = $album;
        }
        return $albums;
    }


    /**
     * @return Musique[]
     */
    public static function getMusiques(int $idAlbum): array
    {
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM musique WHERE idAlbum = $idAlbum");
        $musiques = [];
        foreach ($result as $r) {
            $musique = new Musique(
                $r["idM"],
                $r["nomM"],
                $r["lienM"],
                MusiqueDB::getNbEcoute($r["idM"])
            );
            $musiques[] = $musique;
        }
        return $musiques;
    }

    /**
     * @return float
     */
    public static function getNoteAlbum(int $idAlbum): float
    {
        $db = Database::getInstance();
        $result = $db->query("SELECT IFNULL(AVG(note), 0) FROM noter WHERE idAlbum = $idAlbum");
        $r = $result->fetch();
        return $r[0];
    }

    /**
     * @return int
     */
    public static function getNbEcouteAlbum(int $idAlbum): int
    {
        $db = Database::getInstance();
        $result = $db->query("SELECT IFNULL(COUNT(*), 0) FROM ecouter natural join musique WHERE idAlbum = $idAlbum");
        $r = $result->fetch();
        return $r[0];
    }

    public static function searchAlbums($search)
    {
        $db = Database::getInstance();
        $search = '%' . $search . '%';
        $stmt = $db->prepare("SELECT * FROM album WHERE titreAlbum LIKE :search");
        $stmt->bindParam(":search", $search);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
