<?php

namespace models;

use models\CollectionMusicale;
use models\db\MusiqueDB;
use view\Composant;

class Playlist extends CollectionMusicale{

    private string $dateMAJ;
    private Utilisateur $auteur;

    /**
     * @param int $id
     * @param string $titre
     * @param Utilisateur $auteur
     * @param string $image
     * @param string $datePublication
     * @param string $description
     * @param string $dateMAJ
     * @param array $musiques = []
     */
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

    /**
     * @return \DateTime
     */
    public function getDateMAJ(): \DateTime{
        return \DateTime::createFromFormat('d/m/Y', $this->dateMAJ);
    }

    /**
     * @param int $id
     * @return string
     */
    public function getDateAjoutMusique(int $id): string{
        $time = MusiqueDB::getDateAjoutMusique($id, $this->getId());
        $date = date("d/m/Y", $time);
        return $date;
    }

    /**
     * @return string
     */
    public function render(): string{
        $composant = new Composant("playlist");
        $composant->addParam("id", $this->getId());
        $composant->addParam("titre", $this->getTitre());
        $composant->addParam("image", $this->getImage());
        $composant->addParam("dateMaj", $this->getDateMAJ()->format("d/m/Y"));
        $composant->addParam("auteurNom", $this->getAuteur()->getPseudoU());
        $composant->addParam("nbMusiques", MusiqueDB::getNbMusiquesPlaylist($this->getId()));
        return $composant->get();
    }

    /**
     * @return Utilisateur
     */
    public function getAuteur(): Utilisateur {
        return $this->auteur;
    }

    /**
     * @return string
     */
    public function getImage(): string {
        return ($this->image ? "fixtures/images/" . $this->image : "../../img/default_playlist.png");
    }
}
