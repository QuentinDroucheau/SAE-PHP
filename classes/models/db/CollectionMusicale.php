<?php

namespace models\db;
use models\Musique;

class CollectionMusicale {
    protected int $id;
    protected string $titre;
    protected $auteur; // Artiste pour Album, auteurPlaylist pour Playlist
    protected string $datePublication;
    protected ?string $image;
    protected string $description;
    protected array $musiques = [];

    public function __construct(int $id, string $titre, $auteur, ?string $images, string $datePublication, string $description, array $musiques = []) {
      $this->id = $id;
      $this->titre = $titre;
      $this->musiques = $musiques;
      $this->auteur = $auteur;
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

    public function getMusiques(): array {
        return $this->musiques;
    }

    public function getAuteur() {
        return $this->auteur;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setTitre(string $titre): void {
        $this->titre = $titre;
    }

    public function setMusiques(array $musiques): void {
        $this->musiques = $musiques;
    }

    public function setAuteur($auteur): void {
        $this->auteur = $auteur;
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

    public function addMusique(Musique $musique): void {
      $this->musiques[] = $musique;
  }
}