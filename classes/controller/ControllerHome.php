<?php 
// 2 méthodes

namespace controller;
use models\db\AlbumDB;
use models\db\PlaylistDB;
use utils\Utils;

class ControllerHome extends Controller{
    
    public function view(): void{
        $categories = ['Récents', 'Populaires']; // on peut ajouter d'autres catégories -> à voir condition dans albumBD
        $playlistDB = new PlaylistDB();
        $playlists = $playlistDB->getPlaylists(Utils::getIdUtilisateurConnecte());
        $albumsByCategory = [];
        foreach ($categories as $category) {
            $albumsByCategory[$category] = AlbumDB::getInfosCardsAlbum($category);
        }
        $this->render("base", [
            "header" => $this->get("element/header"),
            "content" => $this->get("accueil", [
                "albumsByCategory" => $albumsByCategory
            ], $playlists),
            "menu" => $this->get("element/menu"),
        ]);
    }

    public function add(): void{
        $this->render("test", []);
    }
}