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
            $artistes[] = new Artiste($r["idA"], $r["nomA"], $r["imgArtiste"]);
        }
        return $artistes;
    }


    public static function getArtistesLimit(): array{
        $db = Database::getInstance();
        $artistes = [];
        $result = $db->query("SELECT * FROM artiste LIMIT 10");
        foreach($result as $r){
            $artistes[] = new Artiste($r["idA"], $r["nomA"], $r["imgArtiste"]);
        }
        return $artistes;
    }


    /**
     * @param Artiste $artiste
     * @return bool
     */
    public static function addArtiste(Artiste $artiste): bool{
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO artiste(nomA, imgArtiste) VALUES (:nom, :image)");
        $stmt->bindParam(":nom", $artiste->getNom());
        $stmt->bindParam(":image", $artiste->getImage());
        return $stmt->execute();
    }

    /**
     * @param int $id
     * @return Artiste
     */
    public static function getArtiste(int $id): Artiste{
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM artiste WHERE idA = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return new Artiste($result["idA"], $result["nomA"], $result["imgArtiste"]);
    }

    public static function creerIdArtiste(){
        $db = Database::getInstance();
        $stmt = $db->query('SELECT MAX(idA) FROM artiste');
        $result = $stmt->fetch();
        return $result[0] + 1;
    }

    public static function getIdArtiste($nom){
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT idA FROM artiste WHERE nomA = :nom");
        $stmt->bindParam(":nom", $nom);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result[0];
    }

    public static function getNomArtisteById(int $id){
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT nomA FROM artiste WHERE idA = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result[0];
    }
}