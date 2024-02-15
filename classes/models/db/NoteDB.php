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
                UtilisateurDB::getUtilisateurById($r['idUtilisateur']),
                AlbumDB::getAlbum($r['idAlbum']),
                $r['note'],
                $r['critique']
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
        $db->query("INSERT INTO noter (idUtilisateur, idAlbum, note, critique) VALUES ($idUtilisateur, $idAlbum, $note, '$critique')");
    }
}