<?php

namespace models;

use models\CollectionMusicale;
use view\Template;

class Album extends CollectionMusicale {

    public function __construct(
        int $id,
        string $titreAlbum,
        int $idArtiste,
        ?string $imageAlbum,
        string $datePublication,
        string $descriptionA = ''
    ) {
        parent::__construct($id, $titreAlbum, $idArtiste, $imageAlbum, $datePublication, $descriptionA);
        $this->datePublication = $datePublication;
    }

    public function getAnneeAlbum(): \DateTime {
        return \DateTime::createFromFormat('d/m/Y', $this->datePublication);
    }

    public function render(): string{
        return Template::get("element/album", [
            "image" => $this->getImage(),
            "id" => $this->getId(),
            "titre" => $this->getTitre(),
            "idArtiste" => $this->getIdAuteur(),
            "anneeAlbum" => $this->getAnneeAlbum()->format("d/m/Y"),
            "descriptionA" => $this->getDescription()
        ]);
    }
}