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

    public static function getUserFollowedArtists(int $idU): array {
        $db = Database::getInstance();
        $artistes = [];
        $query = $db->prepare("SELECT artiste.idA, artiste.nomA, artiste.imgArtiste FROM abonnement JOIN artiste ON abonnement.idA = artiste.idA WHERE abonnement.idU = :idU");
        $query->execute([':idU' => $idU]);
        $result = $query->fetchAll();
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
     * @return ?Artiste
     */
    public static function getArtiste(int $id): ?Artiste{
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM artiste WHERE idA=$id");
        foreach($result as $r){
            return new Artiste($r["idA"], $r["nomA"], $r["imgArtiste"]);
        }
        return null;
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

    public static function getArtisteAlbum($idAlbum) {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT artiste.nomA FROM album JOIN artiste ON album.idA = artiste.idA WHERE album.idAlbum = :idAlbum');
        $stmt->bindParam(':idAlbum', $idAlbum);
        $stmt->execute();
        $result = $stmt->fetch();
        return isset($result['nomA']) ? $result['nomA'] : null;
    }
    
    public static function getIdArtisteByNom($nom){
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT idA FROM artiste WHERE nomA = :nomA');
        $stmt->bindParam(':nomA', $nom);
        $stmt->execute();
        $result = $stmt->fetch();
        return isset($result['idA']) ? $result['idA'] : null;
    }

    public static function getAllNomArtiste(){
        $db = Database::getInstance();
        $stmt = $db->query('SELECT nomA FROM artiste');
        $result = $stmt->fetchAll();
        $allNomArtiste = [];
        foreach($result as $r){
            $allNomArtiste[] = $r['nomA'];
        }
        return $allNomArtiste;
    }

    public static function insererArtiste($nom, $image){
        $db = Database::getInstance();
        $stmt = $db->prepare('INSERT INTO artiste(nomA, imgArtiste) VALUES (:nom, :image)');
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':image', $image);
        $stmt->execute();
    }

    public static function supprimerArtiste($id){
        $db = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM artiste WHERE idA = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public static function searchArtistes($search){
        $db = Database::getInstance();
        $search = '%' . $search . '%';
        $stmt = $db->prepare('SELECT * FROM artiste WHERE nomA LIKE :search');
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
    
}