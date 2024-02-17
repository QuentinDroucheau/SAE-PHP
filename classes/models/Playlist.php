<?php

namespace models;

use models\CollectionMusicale;
use models\db\UtilisateurDB;
use models\db\MusiqueDB;
use view\Composant;

class Playlist extends CollectionMusicale
{
    private string $dateMAJ;
    private Utilisateur $auteur;

    public function __construct(
        int $id,
        string $titre,
        Utilisateur $auteur,
        string $image,
        string $datePublication,
        string $description,
        string $dateMAJ,
        array $musiques = []
    ) {
        parent::__construct($id, $titre, $image, $datePublication, $description, $musiques);
        $this->dateMAJ = $dateMAJ;
        $this->auteur = $auteur;
    }

    public function getDateMAJ(): \DateTime
    {
        return \DateTime::createFromFormat('d/m/Y', $this->dateMAJ);
    }

    public function getDateAjoutMusique(int $id): string{
        $time = MusiqueDB::getDateAjoutMusique($id, $this->getId());
        $date = date("d/m/Y", $time);
        return $date;
    }

    public function render(): string
    {
        $composant = new Composant("playlist");
        $composant->addParam("id", $this->getId());
        $composant->addParam("titre", $this->getTitre());
        $composant->addParam("image", $this->getImage());
        $composant->addParam("dateMaj", $this->getDateMAJ()->format("d/m/Y"));
        $composant->addParam("auteurNom", $this->getAuteur()->getPseudoU());
        $composant->addParam("nbMusiques", MusiqueDB::getNbMusiquesPlaylist($this->getId()));
        return $composant->get();
    }

    public function getAuteur(): Utilisateur {
        return $this->auteur;
    }

}
