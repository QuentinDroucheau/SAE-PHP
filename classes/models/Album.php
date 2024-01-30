<?php

namespace models;

class Album{


  public function __construct(
    private int $id,
    private string $titreAlbum,
    private int $anneeAlbum,
    private ?string $imageAlbum, // certains albums n'ont pas d'image
    public Artiste $artiste,
    public array $musiques = []
    



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
    return ($this->imageAlbum ? "fixtures//images/" . $this->imageAlbum : "../../img/default_album.png");
}
}
