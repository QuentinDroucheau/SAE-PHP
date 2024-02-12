<?php

namespace models;
use models\Musique;

class CollectionMusicale {
  protected int $id;
  protected string $titre;
  protected int $auteurId;
  protected ?string $image;
  protected string $datePublication;
  protected string $description;

  public function __construct(int $id, string $titre, int $auteurId, ?string $image, string $datePublication, string $description) {
      $this->id = $id;
      $this->titre = $titre;
      $this->auteurId = $auteurId;
      $this->image = $image;
      $this->datePublication = $datePublication;
      $this->description = $description;
  }

  public function getId(): int {
      return $this->id;
  }

  public function getTitre(): string {
      return $this->titre;
  }

  public function getAuteurId(): int {
      return $this->auteurId;
  }

  public function setAuteurId(int $auteurId): void {
      $this->auteurId = $auteurId;
  }

  public function getImage(): string {
      return ($this->image ? "fixtures/images/" . $this->image : "../../img/default_album.png");
    }

  public function getDatePublication(): string {
      return $this->datePublication;
  }

  public function getDescription(): string {
      return $this->description;
  }
}