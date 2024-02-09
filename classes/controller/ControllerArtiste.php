<?php 

namespace controller;

use models\db\AlbumDB;
use models\db\MusiqueDB;
use models\db\ArtisteDB;
use models\db\GenreDB;
use view\BaseTemplate;

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

        $base = new BaseTemplate();
        $base->setContent("artiste");
        $base->addParam("albums", $albums);
        $base->addParam("musiquesArtiste", $musiquesArtiste);
        $base->addParam("artiste", $artiste);
        $base->addParam("genres", $genres);
        $base->render();
    }
}
