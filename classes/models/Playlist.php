<?php

namespace models;

use models\db\CollectionMusicale;

class Playlist extends CollectionMusicale {
    private string $dateMAJ;
    private int $idU;

    public function __construct(
        int $id,
        string $titre,
        $auteur,
        string $image,
        string $datePublication,
        string $description,
        array $musiques = []
    ) {
        parent::__construct($id, $titre, $auteur, $image, $datePublication, $description, $musiques);
    }

    public function getIdU(): int {
        return $this->idU;
    }

    public function getDateMAJ(): string {
        return $this->dateMAJ;
    }
}