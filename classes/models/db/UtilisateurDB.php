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
     * @param string $pseudo
     * @return ?Utilisateur
     */
    public static function getUtilisateurByPseudo(string $pseudo): ?Utilisateur{
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM utilisateur WHERE pseudoU = '$pseudo'");
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

    /**
     * @return Utilisateur[]
     */
    public static function getUtilisateurs(): array{
        $db = Database::getInstance();
        $stmt = $db->query('SELECT * FROM utilisateur');
        $utilisateurs = [];
        while ($row = $stmt->fetch()) {
            $utilisateur = new Utilisateur($row["idU"], $row["pseudoU"], $row["mdpU"], $row["roleU"]);
            $utilisateurs[] = $utilisateur;
        }
        return $utilisateurs;
    }

    /**
     * @param int $id
     */
    public static function supprimerUtilisateur(int $id): void{
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM utilisateur WHERE idU = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    /**
     * @param string $pseudo
     * @param string $password
     * @param string $role
     * @return ?Utilisateur
     */
    public static function addUtilisateur(string $pseudo, string $password, string $role): ?Utilisateur{
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO utilisateur (pseudoU, mdpU, roleU) VALUES (:pseudo, :mdp, :role)");
        $stmt->bindParam(":pseudo", $pseudo);
        $stmt->bindParam(":mdp", $password);
        $stmt->bindParam(":role", $role);
        $stmt->execute();
        return self::getUtilisateurByPseudo($pseudo);
    }
}