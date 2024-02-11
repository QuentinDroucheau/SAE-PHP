<?php

namespace models;
use models\Musique;

class CollectionMusicale {
    protected int $id;
    protected string $titre;
    protected $auteur;
    protected string $datePublication;
    protected ?string $image;
    protected string $description;

    public function __construct(int $id, string $titre, int $idArtiste, ?string $images, string $datePublication, string $description) {
      $this->id = $id;
      $this->titre = $titre;
      $this->auteur = $idArtiste;
      $this->image = $images;
      $this->datePublication = $datePublication;
      $this->description = $description;
  }

    public function getId(): int {
        return $this->id;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getIdAuteur(): int {
        return $this->auteur;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setTitre(string $titre): void {
        $this->titre = $titre;
    }

    public function setIdAuteur(int $idArtiste): void {
        $this->auteur = $idArtiste;
    }

    public function getImage(): string{
      return ($this->image ? "fixtures/images/" . $this->image : "../../img/default_album.png");
  }

    public function getAnnee() : string{
      return $this->datePublication;
    }

    public function getDescription() : string{
      return $this->description;
    }
}