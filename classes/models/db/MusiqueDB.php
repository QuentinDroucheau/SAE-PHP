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
        $result = $db->query("SELECT * FROM musique NATURAL JOIN album");
        foreach($result as $r){
            $musiques[] = new Musique($r["idM"], $r["nomM"], $r["lienM"], self::getNbEcoute($r["idM"]), $r["titreAlbum"]);
        }
        return $musiques;
    }

    /**
     * @param int $id
     * @return Musique
     */
    public static function getMusique(int $id): ?Musique{
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM musique NATURAL JOIN album WHERE idM = $id");
        $r = $result->fetch();
        if($r){
            return new Musique($r["idM"], $r["nomM"], $r["lienM"], self::getNbEcoute($id), $r["titreAlbum"]);
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
     * @param int $id
     * @return Musique[]
     */
    public static function getMusiquesAlbum(int $id): array{
        $db = Database::getInstance();
        $musiques = [];
        $result = $db->query("SELECT * FROM musique NATURAL JOIN album WHERE idAlbum = $id");
        foreach($result as $r){
            $musiques[] = new Musique($r["idM"], $r["nomM"], $r["lienM"], self::getNbEcoute($r["idM"]), $r["titreAlbum"]);
        }
        return $musiques;
    }

    /**
     * @param int $id
     * @return Musique[]
     */
    public static function getMusiquesArtiste(int $id): array{
        $db = Database::getInstance();
        $musiques = [];
        $result = $db->query("SELECT * FROM musique NATURAL JOIN album NATURAL JOIN artiste WHERE idA = $id");
        foreach($result as $r){
            $musiques[] = new Musique($r["idM"], $r["nomM"], $r["lienM"], 
                self::getNbEcoute($r["idM"]), $r["titreAlbum"]);
        }
        return $musiques;
    }

    /**
     * @param string $nomM
     * @return int
     */
    public static function getIdM(string $nomM): int{
        $db = Database::getInstance();
        $result = $db->query("SELECT idM FROM musique WHERE nomM = '$nomM'");
        $r = $result->fetch();
        if ($r) {
            return $r["idM"];
        }
        return null;
    }

    /**
     * @param string $nomM
     * @param string $lienM
     * @param int $idAlbum
     */
    public function insererMusique(string $nomM, string $lienM, int $idAlbum){
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO musique(nomM, lienM, idAlbum) VALUES (:nomM, :lienM, :idAlbum)");
        $stmt->bindParam(":nomM", $nomM);
        $stmt->bindParam(":lienM", $lienM);
        $stmt->bindParam(":idAlbum", $idAlbum);
        $stmt->execute();
        return $db->lastInsertId();
    }

    /**
     * @param int $idAlbum
     * @return int
     */
    public static function getNbMusiquesAlbum(int $idAlbum): int{
        $db = Database::getInstance();
        $result = $db->query("SELECT COUNT(*) FROM musique WHERE idAlbum = $idAlbum");
        $r = $result->fetch();
        return $r[0];
    }

    /**
     * @param int $idPlaylist
     * @return int
     */
    public static function getNbMusiquesPlaylist(int $idPlaylist): int{
        $db = Database::getInstance();
        $result = $db->query("SELECT COUNT(*) FROM musique m 
                              JOIN composer c ON m.idM = c.idM 
                              WHERE c.idP = $idPlaylist");
        $r = $result->fetch();
        return $r[0];
    }

    /**
     * @param int $idPlaylist
     * @return Musique[]
     */
    public static function getMusiquesPlaylist(int $idPlaylist): array{
        $db = Database::getInstance();
        $musiques = [];
        $result = $db->query("SELECT * FROM musique m 
                              JOIN composer c ON m.idM = c.idM NATURAL JOIN album
                              WHERE c.idP = $idPlaylist");
        foreach ($result as $r) {
            $musiques[] = new Musique($r["idM"], $r["nomM"], $r["lienM"], self::getNbEcoute($r["idM"]), $r["titreAlbum"]);
        }
        return $musiques;
    }

    /**
     * @param int $idAlbum
     * @return Musique[]
     */
    public static function getMusiqueAlbum(int $idAlbum): array{
        $db = Database::getInstance();
        $musiques = [];
        $result = $db->query("SELECT * FROM musique NATURAL JOIN album WHERE idAlbum = $idAlbum");
        foreach ($result as $r) {
            $musiques[] = new Musique($r["idM"], $r["nomM"], $r["lienM"], self::getNbEcoute($r["idM"]), $r["titreAlbum"]);
        }
        return $musiques;
    }

    /**
     * @param array $songIds
     * @param int $playlistId
     * @return string
     */
    public static function insererSonsPlaylists(array $songIds, int $playlistId): string{
        $db = Database::getInstance();
        foreach ($songIds as $songId) {
            try {
                $stmt = $db->prepare("INSERT INTO composer(idM, idP, dateAjout) VALUES (:songId, :playlistId, '22/03/2023')");
                $stmt->bindParam(":songId", $songId);
                $stmt->bindParam(":playlistId", $playlistId);
                $stmt->execute();
            } catch (\Exception $e) {
                return "Erreur lors de l'insertion de la chanson dans la playlist : " . $e->getMessage();
            }
        }
        return "Les chansons ont été insérées avec succès dans la playlist.";
    }

    /**
     * @param int $idM id de la musique
     * @return int nombre d'écoute
     */
    public static function getNbEcoute(int $idM): int{
        $db = Database::getInstance();
        $result = $db->query("SELECT count(*) FROM ecouter WHERE idM = $idM");
        $r = $result->fetch();
        return $r[0];
    }

    /**
     * @param int $idAlbum
     * @return void
     */
    public static function supprimerAllMusiqueAlbum(int $idAlbum): void{
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM musique WHERE idAlbum = :idAlbum");
        $stmt->bindParam(":idAlbum", $idAlbum);
        $stmt->execute();
    }

    /**
     * @param int $idM
     * @return void
     */
    public static function supprimerMusique(int $idM): void{
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM musique WHERE idM = :idM");
        $stmt->bindParam(":idM", $idM);
        $stmt->execute();
    }

    /**
     * @param int $idM
     * @return string
     */
    public static function getArtisteMusique(int $idM): string{
        $db = Database::getInstance();
        $result = $db->query("SELECT nomA FROM artiste NATURAL JOIN album NATURAL JOIN musique WHERE idM = $idM");
        $r = $result->fetch();
        return $r["nomA"];
    }

    /**
     * @param int $idM
     * @param int $idP
     * @return string
     */
    public static function getDateAjoutMusique(int $idM, int $idP): string{
        $db = Database::getInstance();
        $result = $db->query("SELECT dateAjout FROM composer WHERE idM = $idM AND idP = $idP");
        $r = $result->fetch();
        return $r["dateAjout"];
    }

    /**
     * @param string $search
     * @return array
     */
    public static function searchMusiques(string $search): array{
        $db = Database::getInstance();
        $search = '%' . $search . '%';
        $stmt = $db->prepare("SELECT * FROM musique WHERE nomM LIKE :search");
        $stmt->bindParam(":search", $search);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
