<?php

namespace models\db;

use models\Contient;

class ContientDB {

    public function insererContient($idM, $idG) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO contient(idM, idG) VALUES (:idM, :idG)");
        $stmt->bindParam(":idM", $idM);
        $stmt->bindParam(":idG", $idG);
        $stmt->execute();
        return $db->lastInsertId();
    }

}
