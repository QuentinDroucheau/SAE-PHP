<?php

namespace models\db;

class ContientDB{

    /**
     * @param int $idM
     * @param int $idG
     */
    public static function insererContient(int $idM, int $idG){
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO contient(idM, idG) VALUES (:idM, :idG)");
        $stmt->bindParam(":idM", $idM);
        $stmt->bindParam(":idG", $idG);
        $stmt->execute();
        return $db->lastInsertId();
    }

    /**
     * @param int $idM
     * @return void
     */
    public static function supprimerRelation(int $idM): void{
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM contient WHERE idM = :idM");
        $stmt->bindParam(":idM", $idM);
        $stmt->execute();
    }
}
