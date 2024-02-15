<?php 

namespace models\db;

use models\Note;

class NoteDB{

    /**
     * @param int $idAlbum id de l'album
     * @return array
     */
    public static function getNotes(int $idAlbum): array{
        $db = Database::getInstance();
        $result = $db->query("SELECT * FROM noter WHERE idAlbum = $idAlbum");
        $notes = [];
        foreach($result as $r){
            $notes[] = new Note(
                UtilisateurDB::getUtilisateurById($r['idU']),
                AlbumDB::getAlbum($r['idAlbum']),
                $r['note'],
                $r['critique'],
                $r['date']
            );
        }
        return $notes;
    }

    /**
     * @param int $idAlbum id de l'album
     * @param int $idUtilisateur id de l'utilisateur
     * @param int $note note
     * @param string $critique critique
     */
    public static function addCritique(int $idAlbum, int $idUtilisateur, int $note, string $critique): void{
        $db = Database::getInstance();

        $stmt = $db->prepare("INSERT INTO noter(idU, idAlbum, note, critique, date) VALUES (:idU, :idAlbum, :note, :critique, :date)");
        $stmt->bindParam(":idU", $idUtilisateur);
        $stmt->bindParam(":idAlbum", $idAlbum);
        $stmt->bindParam(":note", $note);
        $stmt->bindParam(":critique", $critique);
        $date = time();
        $stmt->bindParam(":date", $date);
        $stmt->execute();
    }

    /**
     * @param int $idAlbum id de l'album
     * @param int $idUtilisateur id de l'utilisateur
     * @return bool
     */
    public static function hasCritique(int $idAlbum, int $idUtilisateur): bool{
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM noter WHERE idU = :idU AND idAlbum = :idAlbum");
        $stmt->bindParam(":idU", $idUtilisateur);
        $stmt->bindParam(":idAlbum", $idAlbum);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }
}