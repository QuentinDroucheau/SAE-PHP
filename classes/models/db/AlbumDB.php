<?php

namespace models\db;

use models\Album;
use models\db\ArtisteDB;
use models\Musique;

class AlbumDB{

    /**
     * @param int $id
     * @return Album|null
     */
    public static function getAlbum(int $id): ?Album{
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

    /**
     * @param string $id
     * @return string|null
     */
    public static function getAlbumName(string $id): ?string{
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT titreAlbum FROM album WHERE idAlbum = :idAlbum');
        $stmt->bindParam(':idAlbum', $id);
        $stmt->execute();
        while($r = $stmt->fetch()){
            return $r["titreAlbum"];
        }
        return null;
    }

    /**
     * @param string $category
     * @return Album[]
     */
    public static function getInfosCardsAlbum(string $category): array{
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

    /**
     * @param string $category
     * @param string|null $year
     * @param string|null $genre
     * @param string|null $artistId
     * @return Album[]
     */
    public static function getAllAlbumsByCategory(string $category, ?string $year = null, ?string $genre = null, ?int $artistId = null): array{
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


    /**
     * ajoute un album
     * @param string $titreAlbum
     * @param string $anneeAlbum
     * @param string $imgAlbum
     * @param string $descriptionA
     * @param int $idA
     */
    public static function insererAlbum(string $titreAlbum, string $anneeAlbum, string $imgAlbum, string $descriptionA, int $idA): string|false{
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

    /**
     * @param string $titreAlbum
     * @return mixed
     */
    public static function getIdAlbumByTitle(string $titreAlbum): mixed{
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT idAlbum FROM album WHERE titreAlbum = :titreAlbum');
        $stmt->bindParam(':titreAlbum', $titreAlbum);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * @param int $idArtiste
     * @return Album[]
     */
    public static function getAlbumsArtiste(string $idArtiste){
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

    /**
     * @return ?int
     */
    public static function getIdAlbum(): ?int{
        $db = Database::getInstance();
        $stmt = $db->query('SELECT MAX(idAlbum) FROM album');
        $result = $stmt->fetchColumn();
        return $result;
    }

    /**
     * @param int $idAlbum
     */
    public static function getImageAlbum(int $idAlbum): ?string{
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT imgAlbum FROM album WHERE idAlbum = :idAlbum');
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * @return Album[]
     */
    public static function getAlbums(){
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
     * @param int $idAlbum
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
                MusiqueDB::getNbEcoute($r["idM"]),
                self::getAlbumName($r["idAlbum"])
            );
            $musiques[] = $musique;
        }
        return $musiques;
    }

    /**
     * @param int $idAlbum
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
     * @param int $idAlbum
     * @return int
     */
    public static function getNbEcouteAlbum(int $idAlbum): int
    {
        $db = Database::getInstance();
        $result = $db->query("SELECT IFNULL(COUNT(*), 0) FROM ecouter natural join musique WHERE idAlbum = $idAlbum");
        $r = $result->fetch();
        return $r[0];
    }

    /**
     * @param int $idAlbum
     * @return void
     */
    public static function supprimerAlbum(int $idAlbum): void{
        $db = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM album WHERE idAlbum = :idAlbum');
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
    }

    /**
     * @param string $search
     */
    public static function searchAlbums(string $search): mixed{
        $db = Database::getInstance();
        $search = '%' . $search . '%';
        $stmt = $db->prepare("SELECT * FROM album WHERE titreAlbum LIKE :search");
        $stmt->bindParam(":search", $search);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
