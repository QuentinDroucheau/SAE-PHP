<?php

namespace models;

use models\db\CollectionMusicale;
use view\Template;

class Album extends CollectionMusicale {

    public function __construct(
        int $id,
        string $titreAlbum,
        Artiste $artiste,
        ?string $imageAlbum,
        string $datePublication,
        array $musiques = [],
        string $description = ''
    ) {
        parent::__construct($id, $titreAlbum, $artiste, $imageAlbum, $datePublication, $description, $musiques);
        $this->datePublication = $datePublication;
    }

    public function getAnneeAlbum(): \DateTime {
        return \DateTime::createFromFormat('d/m/Y', $this->datePublication);
    }

    public function getMusiques(): array {
        return $this->musiques;
    }

    public function render(): string{
        return Template::get("element/album", [
            "image" => $this->getImage(),
            "id" => $this->getId(),
            "titre" => $this->getTitre(),
            "musiques" => $this->getMusiques(),
            "auteurNom" => $this->getAuteur()->getNom(),
            "anneeAlbum" => $this->getAnneeAlbum()->format("d/m/Y")
        ]);
    }
}