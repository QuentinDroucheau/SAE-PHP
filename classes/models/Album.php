<?php

namespace models;

use models\CollectionMusicale;
use view\Composant;
use models\db\ArtisteDB;
use models\db\MusiqueDB;
use models\db\PlaylistDB;
use utils\Utils;

class Album extends CollectionMusicale {

    private float $note;
    private int $ecoute;
    private Artiste $auteur;

    public function __construct(
        int $id,
        string $titre,
        Artiste $auteur,
        ?string $image,
        string $datePublication,
        float $note,
        int $ecoute,
        string $descriptionA = '',
        array $musiques = []
    ) {
        parent::__construct($id, $titre, $image, $datePublication, $descriptionA, $musiques);
        $this->note = $note;
        $this->ecoute = $ecoute;
        $this->auteur = $auteur;
    }

    public function getAnneeAlbum(): \DateTime {
        return \DateTime::createFromFormat('d/m/Y', $this->getDatePublication());
    }

    public function getMusiques(): array {
        return MusiqueDB::getMusiquesAlbum($this->id);
    }

    public function getNote(): float {
        return $this->note;
    }

    public function getEcoute(): int{
        return $this->ecoute;
    }

    public function getAuteur(): Artiste {
        return $this->auteur;
    }

    public function toJsonArray(): array {
        return [
            "id" => $this->getId(),
            "titre" => $this->getTitre(),
            "image" => $this->getImage(),
            "anneeAlbum" => $this->getAnneeAlbum()->format("d/m/Y"),
            "auteurNom" => $this->getAuteur()->getNom(),
            "lesMusiques" => $this->getMusiques(),
        ];
    }

    public function render(): string{
        $composant = new Composant("album");
        $composant->addParam("id", $this->getId());
        $composant->addParam("titre", $this->getTitre());
        $composant->addParam("image", $this->getImage());
        $composant->addParam("anneeAlbum", $this->getAnneeAlbum()->format("d/m/Y"));
        $composant->addParam("auteurNom", $this->getAuteur()->getNom());
        $composant->addParam("nbMusiques", MusiqueDB::getNbMusiquesAlbum($this->getId()));
        try{
            $composant->addParam("lesPlaylists", PlaylistDB::getPlaylists(Utils::getIdUtilisateurConnecte() ?? 0));

        }
        catch(\Exception $e){
            $composant->addParam("lesPlaylists", []);
        }
        $composant->addParam("lesMusiques", $this->getMusiques());
        return $composant->get();
    }
}