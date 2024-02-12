<?php

namespace models;

use models\CollectionMusicale;
use models\db\UtilisateurDB;
use models\db\MusiqueDB;
use view\Composant;

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

    public function getDateMAJ(): \DateTime {
        return \DateTime::createFromFormat('d/m/Y', $this->dateMAJ);
    }

    public function render(): string{
        $composant = new Composant("album");
        $composant->addParam("id", $this->getId());
        $composant->addParam("titre", $this->getTitre());
        $composant->addParam("image", $this->getImage());
        $composant->addParam("anneeAlbum", $this->getDateMAJ()->format("d/m/Y"));
        $composant->addParam("auteurNom", UtilisateurDB::getUtilisateurById($this->getAuteurId())->getPseudoU());
        $composant->addParam("nbMusiques", MusiqueDB::getNbMusiquesAlbum($this->getId()));
        return $composant->get();
    }

}