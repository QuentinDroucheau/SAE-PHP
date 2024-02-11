<?php

namespace models;

use models\db\CollectionMusicale;
use view\Template;
use view\Composant;

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