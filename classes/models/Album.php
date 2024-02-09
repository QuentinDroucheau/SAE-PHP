<?php

namespace models;

use models\db\CollectionMusicale;
use view\Composant;
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
        $composant = new Composant("album");
        $composant->addParam("image", $this->getImage());
        $composant->addParam("id", $this->getId());
        $composant->addParam("titre", $this->getTitre());
        $composant->addParam("musiques", $this->getMusiques());
        $composant->addParam("auteurNom", $this->getAuteur()->getNom());
        $composant->addParam("anneeAlbum", $this->getAnneeAlbum()->format("d/m/Y"));
        return $composant->get();
    }
}