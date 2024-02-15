<?php

namespace models;

use view\Composant;

class Artiste
{

    public function __construct(
        private int $id,
        private string $nom,
        private ?string $image
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function render(): string
    {
        $composant = new Composant("composantArtiste");
        $composant->addParam("id", $this->getId());
        $composant->addParam("nom", $this->getNom());
        $composant->addParam("image", $this->getImage());
        return $composant->get();
    }

    public function getImage(): string
    {
        return ($this->image ? "fixtures/images/" . $this->image : "../../img/default_album.png");
    }
}
