<?php 

namespace models\db;

use models\Artiste;

class ArtisteDB{

    /**
     * @return Artiste[]
     */
    public static function getArtistes(): array{
        $db = Database::getInstance();
        $artistes = [];
        $result = $db->query("SELECT * FROM artiste");
        foreach($result as $r){
            $artistes[] = new Artiste($r["idA"], $r["nomA"]);
        }
        return $artistes;
    }

    /**
     * @param Artiste $artiste
     * @return bool
     */
    public static function addArtiste(Artiste $artiste): bool{
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO artiste(nomA) VALUES (:nom)");
        $stmt->bindParam(":nom", $artiste->getNom());
        return $stmt->execute();
    }
}