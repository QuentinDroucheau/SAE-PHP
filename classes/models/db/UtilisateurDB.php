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
            return new Utilisateur($r["idU"], $r["pseudoU"], $r["mdpU"], $r["roleU"]);
        }
        return null;
    }

    /**
     * @param int $id
     * @return ?Utilisateur
     */
    public static function getUtilisateurById(int $id): ?Utilisateur{
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM utilisateur WHERE idU = '$id'");
        foreach($result as $r){
            return new Utilisateur($r["idU"], $r["pseudoU"], $r["mdpU"], $r["roleU"]);
        }
        return null;
    }

    /**
     * @param Utilisateur $utilisateur
     * @return ?Utilisateur
     */
    public static function update(Utilisateur $utilisateur): Utilisateur{
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE utilisateur SET pseudoU = :pseudo, mdpU = :mdp, roleU = :role WHERE idU = :id");
        $pseudo = $utilisateur->getPseudoU();
        $stmt->bindParam(":pseudo", $pseudo);
        $mdp = $utilisateur->getMdpU();
        $stmt->bindParam(":mdp", $mdp);
        $role = $utilisateur->getRoleU();
        $stmt->bindParam(":role", $role);
        $id = $utilisateur->getId();
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return self::getUtilisateurById($utilisateur->getId());
    }

    public static function getUtilisateurs() {
        $db = Database::getInstance();
        $stmt = $db->query('SELECT * FROM utilisateur');
        $utilisateurs = [];
        while ($row = $stmt->fetch()) {
            $utilisateur = new Utilisateur($row["idU"], $row["pseudoU"], $row["mdpU"], $row["roleU"]);
            $utilisateurs[] = $utilisateur;
        }
        return $utilisateurs;
    }
}