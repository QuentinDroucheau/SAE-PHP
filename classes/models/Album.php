<?php

namespace models;

use models\db\CollectionMusicale;

class Album extends CollectionMusicale {

    public function __construct(
        int $id,
        string $titreAlbum,
        Artiste $artiste,
        ?string $imageAlbum,
        string $datePublication,
        array $musiques = [],
        string $description = ''
    ) {
        parent::__construct($id, $titreAlbum, $artiste, $imageAlbum, $datePublication, $description, $musiques);
        $this->datePublication = $datePublication;
    }

    public function getAnneeAlbum(): \DateTime {
        return \DateTime::createFromFormat('d/m/Y', $this->datePublication);
    }

    public function getMusiques(): array {
        return $this->musiques;
    }

    public function render(): string {
        $output = '<div class="main-album">';
        $output .= '<img class="img-album" src="' . $this->getImage() . '" alt="">';
        $output .= '<section class="infos-card">';
        $output .= '<div class="top-infos-card">';
        $output .= '<h3>' . $this->getTitre() . '</h3>';
        $output .= '<p>' . (count($this->getMusiques()) == 1 ? 'Single' : count($this->getMusiques()) . ' Titres') . '</p>';
        $output .= '</div>';
        $output .= '<div class="bottom-infos-card">';
        $output .= '<div class="bottom-infos-card-artist">';
        $output .= '<img src="../img/icone_artist.svg" alt="icone de l\'artiste"/>';
        $output .= '<p>' . $this->getAuteur()->getNom() . '</p>';
        $output .= '</div>';
        $output .= '<p>' . $this->getAnneeAlbum()->format('d/m/Y') . '</p>';
        $output .= '</div>';
        $output .= '</section>';
        $output .= '</div>';
        return $output;
    }
}