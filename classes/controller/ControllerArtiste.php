<?php 
// 2 méthodes


namespace controller;

use models\db\AlbumDB;
use models\db\MusiqueDB;

class ControllerArtiste extends Controller{

    public function view(){
        $albums = AlbumDB::getAlbumsArtiste($this->params["id"]);
        $musiquesAlbums = MusiqueDB::getMusiquesAlbum($this->params["id"]);
        $musiquesArtiste = MusiqueDB::getMusiquesArtiste($this->params["id"]);
        $this->render("base", [
            "header" => $this->get("element/header"),
            "menu" => $this->get("element/menu"),
            "content" => $this->get("artiste",[ 
                "albums" => $albums,
                "musiquesAlbum" => $musiquesAlbums,
                "musiquesArtiste" => $musiquesArtiste
                ]),
        ]);
    }
}
