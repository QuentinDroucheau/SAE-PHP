<?php

namespace models;

use models\CollectionMusicale;
use view\Composant;
use models\db\ArtisteDB;
use models\db\MusiqueDB;
use view\Template;

class Album extends CollectionMusicale {

    private int $idArtiste;

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

    public function getIdArtiste(): int {
        return $this->idArtiste;
    }

    public function getArtiste(): Artiste {
        return ArtisteDB::getArtiste($this->idArtiste);
    }

    public function getMusiques(): array {
        return MusiqueDB::getMusiquesAlbum($this->id);
    }

    public function render(): string{
        // return Template::get("element/album", [
        //     "image" => $this->getImage(),
        //     "id" => $this->getId(),
        //     "titre" => $this->getTitre(),
        //     "idArtiste" => $this->getIdArtiste(),
        //     "anneeAlbum" => $this->getAnneeAlbum()->format("d/m/Y"),
        //     "descriptionA" => $this->getDescription()
        // ]);

        $composant = new Composant("album");
        $composant->addParam("image", $this->getImage());
        $composant->addParam("id", $this->getId());
        $composant->addParam("titre", $this->getTitre());
        $composant->addParam("musiques", $this->getMusiques());
        $composant->addParam("auteurNom", $this->getArtiste()->getNom());
        $composant->addParam("anneeAlbum", $this->getAnneeAlbum()->format("d/m/Y"));
        return $composant->get();
    }
}