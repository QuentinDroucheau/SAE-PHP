<?php 

namespace models\db;

use models\Utilisateur;

class UtilisateurDB{

    /**
     * @param string $pseudo
     * @param string $password
     * @return ?Utilisateur
     */
    public static function getUtilisateurByPassword(string $pseudo, string $password): ?Utilisateur{
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM utilisateur WHERE pseudoU = '$pseudo' AND mdpU = '$password'");
        foreach($result as $r){
            return new Utilisateur($r["idU"], $r["pseudoU"], $r["mdpU"], $r["mailU"]);
        }
        return null;
    }
}