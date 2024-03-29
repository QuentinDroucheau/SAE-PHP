<?php 

namespace utils;

use models\Utilisateur;
use models\db\PlaylistDB;

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

    /**
     * @return int id de l'utilisateur connecté
     */
    public static function getIdUtilisateurConnecte(): int{
        if(!self::isConnected())
            throw new \Exception("Utilisateur non connecté");
        return self::getConnexion()->getId();
    }

    /**
     * @return string|bool
     */
    public static function traiterImage(): string|bool{
        // Taille maximale autorisée en octets (2 Mo)
        $maxFileSize = 2 * 1024 * 1024;
        $uploadDir = 'public/images/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
    
        if (file_exists($uploadFile)) {
            return $uploadFile;
        }
        if ($_FILES['image']['size'] > $maxFileSize) {
            return false;
        }
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            return $uploadFile;
        }
        return false;
    }

    /**
     * @param string $date
     * @param string $format
     * @return string
     */
    public static function convertirDateFormat(string $date, string $format = 'd/m/Y'): string{
        $dateObj = new \DateTime($date);
        return $dateObj->format($format);
    }

    /**
     * @return array
     */
    public static function getPlaylistsMenu(){
        try{
            $userId = self::getIdUtilisateurConnecte();
            $lesPlaylists = PlaylistDB::getPlaylists($userId);
        }catch(\Exception $e){
            $lesPlaylists = [];
        }
        return $lesPlaylists;
    }
}