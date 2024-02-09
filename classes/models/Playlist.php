<?php

namespace models;

use models\CollectionMusicale;

class Playlist extends CollectionMusicale {
    private string $dateMAJ;
    private int $idUtilisateur;

    public function __construct(
        int $id,
        string $titre,
        int $idUtilisateur,
        string $image,
        string $datePublication,
        string $description,
        string $dateMAJ,
    ) {
        parent::__construct($id, $titre, $idUtilisateur, $image, $datePublication, $description);
        $this->dateMAJ = $dateMAJ;
    }

    public function getIdUtilisateur(): int {
        return $this->idUtilisateur;
    }

    public function getDateMAJ(): string {
        return $this->dateMAJ;
    }
}