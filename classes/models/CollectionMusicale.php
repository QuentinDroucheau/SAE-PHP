<?php

namespace models;
use models\Musique;

class CollectionMusicale {
    protected int $id;
    protected string $titre;
    protected int $idArtiste; // Artiste pour Album, auteurPlaylist pour Playlist
    protected string $datePublication;
    protected ?string $image;
    protected string $description;

    public function __construct(int $id, string $titre, int $idArtiste, ?string $images, string $datePublication, string $description) {
      $this->id = $id;
      $this->titre = $titre;
      $this->idArtiste = $idArtiste;
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
        return $this->idArtiste;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setTitre(string $titre): void {
        $this->titre = $titre;
    }

    public function setIdAuteur(int $idArtiste): void {
        $this->idArtiste = $idArtiste;
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