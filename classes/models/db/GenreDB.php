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
}
