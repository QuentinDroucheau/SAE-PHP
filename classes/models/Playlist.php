<?php

namespace models;

use models\CollectionMusicale;

class Playlist extends CollectionMusicale {
    private string $dateMAJ;

    public function __construct(
        int $id,
        string $titre,
        int $auteurId,
        string $image,
        string $datePublication,
        string $description,
        string $dateMAJ,
    ) {
        parent::__construct($id, $titre, $auteurId, $image, $datePublication, $description);
        $this->dateMAJ = $dateMAJ;
    }

    public function getIdAuteur(): int {
        return $this->auteurId;
    }

    public function getDateMAJ(): string {
        return $this->dateMAJ;
    }

}