<?php

namespace models;

use models\CollectionMusicale;

class Playlist extends CollectionMusicale {
    private string $dateMAJ;

    public function __construct(
        int $id,
        string $titre,
        int $utilisateurId,
        string $image,
        string $datePublication,
        string $description,
        string $dateMAJ,
    ) {
        parent::__construct($id, $titre, $utilisateurId, $image, $datePublication, $description);
        $this->dateMAJ = $dateMAJ;
    }

    public function getDateMAJ(): string {
        return $this->dateMAJ;
    }

}