<?php 

namespace models;

class Musique{

    public function __construct(
        private int $id, 
        private string $nom,
        private int $lien
    ){}

    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getLien(){
        return $this->lien;
    }
}