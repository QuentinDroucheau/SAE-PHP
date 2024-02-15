<?php 

namespace utils;

use models\Utilisateur;

class Utils{

    /**
     * @param Utilisateur $user qui se connecte 
     * @return void
     */
    public static function login(Utilisateur $user): void{
        $_SESSION["utilisateur"] = serialize($user);
    }

    /**
     * @return Utilisateur connecté, null sinon
     */
    public static function getConnexion(): ?Utilisateur{
        return isset($_SESSION["utilisateur"]) ? unserialize($_SESSION["utilisateur"]) : null;
    }

    /**
     * @return void
     */
    public static function logout(): void{
        unset($_SESSION["utilisateur"]);
    }

    /**
     * @return bool indique si l'utilisateur est connecté
     */
    public static function isConnected(): bool{
        return isset($_SESSION["utilisateur"]);
    }

    public static function getIdUtilisateurConnecte(): int{
        if(!self::isConnected())
            throw new \Exception("Utilisateur non connecté");
        return self::getConnexion()->getId();
    }   
}