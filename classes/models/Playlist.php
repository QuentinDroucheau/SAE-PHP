<?php

namespace models;

use models\db\CollectionMusicale;

class Playlist extends CollectionMusicale {
    private string $dateMAJ;
    private Utilisateur $auteur;

    public function __construct(
        int $id,
        string $titre,
        Utilisateur $auteur,
        string $image,
        string $datePublication,
        string $description,
        string $dateMAJ,
        array $musiques = []
    ) {
        parent::__construct($id, $titre, $auteur, $image, $datePublication, $description, $musiques);
        $this->dateMAJ = $dateMAJ;
    }

    public function getAuteur(): Utilisateur {
        return $this->auteur;
    }

    public function getDateMAJ(): string {
        return $this->dateMAJ;
    }
}