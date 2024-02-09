<?php 

namespace controller;

use models\db\AlbumDB;
use models\db\MusiqueDB;
use models\db\ArtisteDB;
use models\db\GenreDB;

class ControllerArtiste extends Controller{

    public function view(){
        $albums = AlbumDB::getAlbumsArtiste($this->params["id"]);
        $musiquesArtiste = MusiqueDB::getMusiquesArtiste($this->params["id"]);
        $idArtiste = $this->params["id"];
        $artiste = ArtisteDB::getArtiste($idArtiste);

        $genres = [];
        for ($i = 0; $i < count($musiquesArtiste); $i++) {
            $currentGenres = GenreDB::getGenresMusique($musiquesArtiste[$i]->getId());
            $genres = array_merge($genres, $currentGenres);
        }

        $this->render("base", [
            "header" => $this->get("element/header"),
            "menu" => $this->get("element/menu"),
            "content" => $this->get("artiste",[ 
                "albums" => $albums,
                "musiquesArtiste" => $musiquesArtiste,
                "artiste" => $artiste,
                "genres" => $genres
            ]),
        ]);
    }
}
