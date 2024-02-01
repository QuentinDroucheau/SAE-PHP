<?php 
// 2 méthodes

namespace controller;
use models\db\AlbumDB;
class ControllerHome extends Controller{
    
    public function view(): void{
        $categories = ['recents', 'populaires']; // on peut ajouter d'autres catégories -> à voir condition dans albumBD
        $albumsByCategory = [];
        foreach ($categories as $category) {
            $albumsByCategory[$category] = AlbumDB::getInfosCardsAlbum($category);
        }
        $this->render("base", [
            "header" => $this->get("element/header"),
            "content" => $this->get("accueil", [
                "albumsByCategory" => $albumsByCategory
            ]),
            "menu" => $this->get("element/menu"),
        ]);
    }

    public function add(): void{
        $this->render("test", []);
    }
}