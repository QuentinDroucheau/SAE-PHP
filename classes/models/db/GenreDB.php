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

    public function insererGenre($nomGenre) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO genre(idG, nomG) VALUES (:idG, :nomGenre)");
        $idG = GenreDB::creerIdArtiste();
        $stmt->bindParam(":idG", $idG);
        $stmt->bindParam(":nomGenre", $nomGenre);
        $stmt->execute();
    }

    
    public function genreExiste($nomGenre) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM genre WHERE nomG = :nomGenre");
        $stmt->bindParam(":nomGenre", $nomGenre);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public static function creerIdArtiste(){
        $db = Database::getInstance();
        $stmt = $db->query('SELECT MAX(idG) FROM genre');
        $result = $stmt->fetch();
        return $result[0] + 1;
    }
    
}
