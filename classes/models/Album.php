<?php

namespace models;

class Album{


  public function __construct(
    private int $id,
    private string $titreAlbum,
    private string $anneeAlbum,
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

  public function getAnneeAlbum(): \DateTime {
    return \DateTime::createFromFormat('d/m/Y', $this->anneeAlbum);
}

  public function getImageAlbum(): string{
    return ($this->imageAlbum ? "fixtures/images/" . $this->imageAlbum : "../../img/default_album.png");
}
}
