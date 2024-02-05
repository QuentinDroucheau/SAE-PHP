<?php 

namespace controller;

use models\db\ArtisteDB;
use models\db\GenreDB;

class ControllerPublier extends Controller{

    public function view(){
        $artistes = ArtisteDB::getArtistes();
        $genres = GenreDB::getGenres();

        $this->render("base", [
            "header" => $this->get("element/header"),
            "menu" => $this->get("element/menu"),
            "content" => $this->get("publier",[
                "artistes" => $artistes,
                "genres" => $genres
            ]),
        ]);
    }

    public function publierContenue(){
    }
}
