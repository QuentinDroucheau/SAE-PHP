<?php

namespace models\db;

use models\Genre;

class GenreDB {

    
    /**
     * @return Genre[]
     */
    public static function getGenres(): array {
        $db = Database::getInstance();
        $genres = [];
        $result = $db->query("SELECT * FROM genre");
        foreach ($result as $r) {
            $genres[] = new Genre($r["idG"], $r["nomG"]);
        }
        return $genres;
    }

    /**
     * @return Genre[]
     */
    public static function getGenresMusique($idM): array {
        $db = Database::getInstance();
        $genres = [];
        $result = $db->query("SELECT * FROM genre NATURAL JOIN contient WHERE idM = $idM");
        foreach ($result as $r) {
            $genres[] = new Genre($r["idG"], $r["nomG"]);
        }
        return $genres;
    }

    /**
     * @return string
     * @return void
     */
    public function insererGenre(string $nomGenre): void{
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO genre(idG, nomG) VALUES (:idG, :nomGenre)");
        $idG = GenreDB::creerIdGenre();
        $stmt->bindParam(":idG", $idG);
        $stmt->bindParam(":nomGenre", $nomGenre);
        $stmt->execute();
    }

    /**
     * @return string
     * @return bool
     */
    public function genreExiste(string $nomGenre): bool{
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM genre WHERE nomG = :nomGenre");
        $stmt->bindParam(":nomGenre", $nomGenre);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? true : false;
    }

    /**
     * @return int
     */
    public static function creerIdGenre(): int{
        $db = Database::getInstance();
        $stmt = $db->query('SELECT MAX(idG) FROM genre');
        $result = $stmt->fetch();
        return $result[0] + 1;
    }

    /**
     * @param int $idG
     * @return Genre
     */
    public function getGenre(int $idG): Genre{
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM genre WHERE idG = :idG");
        $stmt->bindParam(":idG", $idG);
        $stmt->execute();
        $result = $stmt->fetch();
        return new Genre($result["idG"], $result["nomG"]);
    }

    /**
     * @param string $nomG
     * @return Genre
     */
    public function getGenreByName(string $nomG): Genre{
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM genre WHERE nomG = :nomG");
        $stmt->bindParam(":nomG", $nomG);
        $stmt->execute();
        $result = $stmt->fetch();
        return new Genre($result["idG"], $result["nomG"]);
    }

    /**
     * @param int $idG
     * @return void
     */
    public static function supprimerGenre($idG): void{
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM genre WHERE idG = :idG");
        $stmt->bindParam(":idG", $idG);
        $stmt->execute();
    }
}
