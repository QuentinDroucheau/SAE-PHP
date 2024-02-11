<?php

namespace models;

use models\CollectionMusicale;

class Playlist extends CollectionMusicale {
    private string $dateMAJ;
    private int $idArtiste;

    public function __construct(
        int $id,
        string $titre,
        int $idArtiste,
        string $image,
        string $datePublication,
        string $description,
        string $dateMAJ,
    ) {
        parent::__construct($id, $titre, $idArtiste, $image, $datePublication, $description);
        $this->dateMAJ = $dateMAJ;
    }

    public function getAuteur(): int {
        return $this->idArtiste;
    }

    public function getDateMAJ(): string {
        return $this->dateMAJ;
    }
}