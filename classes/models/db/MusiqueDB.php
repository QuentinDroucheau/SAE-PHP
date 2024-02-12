<?php 

namespace models\db;

use models\Musique;

class MusiqueDB{

    /**
     * @return Musique[]
     */
    public static function getMusiques(): array{
        $db = Database::getInstance();
        $musiques = [];
        $result = $db->query("SELECT * FROM musique");
        foreach($result as $r){
            $musiques[] = new Musique($r["idM"], $r["nomM"], $r["lienM"]);
        }
        return $musiques;
    }

    /**
     * @return Musique
     */
    public static function getMusique(int $id): ?Musique{
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM musique WHERE idM = $id");
        $r = $result->fetch();
        if($r){
            return new Musique($r["idM"], $r["nomM"], $r["lienM"]);
        }
        return null;
    }

    /**
     * @param Musique $musique
     * @return bool
     */
    public static function addMusique(Musique $musique): bool{
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO musique(nomM, lienM) VALUES (:nom, :lien)");
        $stmt->bindParam(":nom", $musique->getNom());
        $stmt->bindParam(":lien", $musique->getLien());
        return $stmt->execute();
    }

    /**
     * @return Musique[]
     */
    public static function getMusiquesAlbum(int $id): array{
        $db = Database::getInstance();
        $musiques = [];
        $result = $db->query("SELECT * FROM musique WHERE idAlbum = $id");
        foreach($result as $r){
            $musiques[] = new Musique($r["idM"], $r["nomM"], $r["lienM"]);
        }
        return $musiques;
    }

    /**
     * @return Musique[]
     */
    public static function getMusiquesArtiste(int $id): array{
        $db = Database::getInstance();
        $musiques = [];
        $result = $db->query("SELECT * FROM musique NATURAL JOIN album NATURAL JOIN artiste WHERE idA = $id");
        foreach($result as $r){
            $musiques[] = new Musique($r["idM"], $r["nomM"], $r["lienM"]);
        }
        return $musiques;
    }

    /**
     * @return Musique
     */
    public static function getIdM(string $nomM): int{
        $db = Database::getInstance();
        $result = $db->query("SELECT idM FROM musique WHERE nomM = '$nomM'");
        $r = $result->fetch();
        if($r){
            return $r["idM"];
        }
        return null;
    }

    public function insererMusique($nomM, $lienM, $idAlbum){
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO musique(nomM, lienM, idAlbum) VALUES (:nomM, :lienM, :idAlbum)");
        $stmt->bindParam(":nomM", $nomM);
        $stmt->bindParam(":lienM", $lienM);
        $stmt->bindParam(":idAlbum", $idAlbum);
        $stmt->execute();
        return $db->lastInsertId();
    }

}