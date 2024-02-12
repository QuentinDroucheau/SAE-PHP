<?php

namespace models;

use models\CollectionMusicale;
use view\Composant;
use models\db\ArtisteDB;
use models\db\MusiqueDB;
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

    public function getMusiques(): array {
        return MusiqueDB::getMusiquesAlbum($this->id);
    }

    public function render(): string{
        $composant = new Composant("album");
        $composant->addParam("id", $this->getId());
        $composant->addParam("titre", $this->getTitre());
        $composant->addParam("image", $this->getImage());
        $composant->addParam("anneeAlbum", $this->getAnneeAlbum()->format("d/m/Y"));
        $composant->addParam("musiques", $this->getMusiques());
        $composant->addParam("auteurNom", ArtisteDB::getArtiste($this->getAuteurId())->getNom());
        return $composant->get();
    }
}