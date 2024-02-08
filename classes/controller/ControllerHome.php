<?php 
// 2 méthodes

namespace controller;
use models\db\AlbumDB;
use view\BaseTemplate;

class ControllerHome extends Controller{
    
    public function view(): void{
        $categories = ['recents', 'populaires']; // on peut ajouter d'autres catégories -> à voir condition dans albumBD
        $albumsByCategory = [];
        foreach ($categories as $category) {
            $albumsByCategory[$category] = AlbumDB::getInfosCardsAlbum($category);
        }

        $base = new BaseTemplate();
        $base->setContent("accueil");
        $base->addParam("albumsByCategory", $albumsByCategory);
        $base->render();
    }
}