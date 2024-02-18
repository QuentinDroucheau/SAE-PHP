<?php

namespace models;

use view\Composant;

class Artiste{

    /**
     * @param int $id
     * @param string $nom
     * @param string|null $image
     */
    public function __construct(
        private int $id,
        private string $nom,
        private ?string $image
    ){}

    /**
     * @return int
     */
    public function getId(): int{
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom(): string{
        return $this->nom;
    }

    /**
     * @return string
     */
    public function render(): string{
        $composant = new Composant("composantArtiste");
        $composant->addParam("id", $this->getId());
        $composant->addParam("nom", $this->getNom());
        $composant->addParam("image", $this->getImage());
        return $composant->get();
    }

    /**
     * @return string
     */
    public function getImage(): string{
        return ($this->image ? "fixtures/images/" . $this->image : "../../img/default_album.png");
    }

    /**
     * @return array
     */
    public function toJsonArray(): array{
        return [
            "id" => $this->getId(),
            "nom" => $this->getNom(),
            "image" => $this->getImage(),
        ];
    }
}
