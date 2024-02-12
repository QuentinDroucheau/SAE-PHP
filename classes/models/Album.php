<?php

namespace models;

use models\CollectionMusicale;
use view\Composant;
use models\db\ArtisteDB;
use models\db\MusiqueDB;

class Album extends CollectionMusicale {


    public function __construct(
        int $id,
        string $titre,
        int $idArtiste,
        ?string $image,
        string $datePublication,
        string $descriptionA = ''
    ) {
        parent::__construct($id, $titre, $idArtiste, $image, $datePublication, $descriptionA);
    }

    public function getAnneeAlbum(): \DateTime {
        return \DateTime::createFromFormat('d/m/Y', $this->getDatePublication());
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
        $composant->addParam("auteurNom", ArtisteDB::getArtiste($this->getAuteurId())->getNom());
        $composant->addParam("nbMusiques", MusiqueDB::getNbMusiquesAlbum($this->getId()));
        return $composant->get();
    }
}