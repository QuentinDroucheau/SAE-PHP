<?php

namespace models;
use models\Musique;

class CollectionMusicale {
  protected int $id;
  protected string $titre;
  protected ?string $image;
  protected string $datePublication;
  protected string $description;
  protected array $musiques;

  public function __construct(int $id, string $titre, ?string $image, string $datePublication, string $description, array $musiques) {
      $this->id = $id;
      $this->titre = $titre;
      $this->image = $image;
      $this->datePublication = $datePublication;
      $this->description = $description;
      $this->musiques = $musiques;
  }

  public function getId(): int {
      return $this->id;
  }

  public function getTitre(): string {
      return $this->titre;
  }

  public function getImage(): string{
    $lien = $this->image ? "fixtures/images/" . $this->image : "../../img/default_album.png";
    if(file_exists($lien)){
        return $lien;
    }
    return "../../img/default_album.png";
  }

  public function getDatePublication(): string {
      return $this->datePublication;
  }

  public function getDescription(): string {
      return $this->description;
  }

  public function getMusiques(): array{
    return $this->musiques;
  }
}