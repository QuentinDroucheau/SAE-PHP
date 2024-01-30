<?php 
// 2 méthodes

namespace controller;
use models\db\AlbumDB;


class ControllerHome extends Controller{
    
    public function view(): void{
        $lesAlbums = AlbumDB::getInfosCardsAlbum();
        $this->render("base", [
            "header" => $this->get("element/header"),
            "content" => $this->get("test3", ["lesAlbums" => $lesAlbums]),
            "menu" => $this->get("element/menu"),
        ]);
    }

    public function add(): void{
        $this->render("test", []);
    }
}