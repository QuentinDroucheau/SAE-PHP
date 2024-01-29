<?php

namespace models;

class Album{


  public function __construct(
    private int $id,
    private string $titreAlbum,
    private int $anneeAlbum,
    private string $imageAlbum
  ){}
  public function getId(): int{
    return $this->id;
  }

  public function getTitreAlbum(): string{
    return $this->titreAlbum;
  }

  public function getAnneeAlbum(): int{
    return $this->anneeAlbum;
  }

  public function getImageAlbum(): string{
    return $this->imageAlbum;
  }
}
