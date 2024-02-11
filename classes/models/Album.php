<?php

namespace models;

use models\CollectionMusicale;
use view\Template;
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
        string $description = ''
    ) {
        parent::__construct($id, $titre, $idArtiste, $image, $datePublication, $description);
    }

    public function getAnneeAlbum(): \DateTime {
        return \DateTime::createFromFormat('d/m/Y', $this->getDatePublication());
    }
    
    public function render(): string {
        $composant = new Composant("album");
        $composant->addParam("image", $this->getImage());
        $composant->addParam("id", $this->getId());
        $composant->addParam("titre", $this->getTitre());
        $composant->addParam("auteurNom", ArtisteDB::getArtiste($this->getAuteurId())->getNom());
        $composant->addParam("anneeAlbum", $this->getAnneeAlbum()->format("d/m/Y"));
        $composant->addParam("nbMusiques", MusiqueDB::getNbMusiquesAlbum($this->getId()));
        return $composant->get();
    }
}