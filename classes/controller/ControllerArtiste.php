<?php 
// 2 méthodes


namespace controller;

use models\db\AlbumDB;

class ControllerArtiste extends Controller{

    public function view(){
        $albums = AlbumDB::getAlbums();
        $this->render("base", [
            "header" => $this->get("element/header"),
            "menu" => $this->get("element/menu"),
            "content" => $this->get("artiste", )
        ]);
    }
}