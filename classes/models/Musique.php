<?php 

namespace models;

use models\db\MusiqueDB;

class Musique{

    public function __construct(
        private int $id, 
        private string $nom,
        private string $lien,
        private int $ecoute
    ){}

    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getLien(){
        $lien = "fixtures/images/" . $this->lien;
        if(file_exists($lien)){
            return $lien;
        }
        return "../../img/default_album.png";
    }

    public function getEcoute(){
        return $this->ecoute;
    }

    public function toJsonArray(): array {
        return [
            "id" => $this->getId(),
            "nom" => $this->getNom(),
            "lien" => $this->getLien(),
        ];
    }

    public function getArtisteMusique(int $id)
    {
        // Utilisez la méthode appropriée de MusiqueDB pour obtenir les musiques de l'artiste
        return MusiqueDB::getArtisteMusique($id);
    }
}