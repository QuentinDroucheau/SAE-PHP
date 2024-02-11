<?php 
// 2 méthodes

namespace controller;
use models\db\AlbumDB;
use models\db\PlaylistDB;
use utils\Utils;
use view\BaseTemplate;

class ControllerHome extends Controller{
    
    public function view(): void{
        $categories = ['Récents', 'Populaires']; // on peut ajouter d'autres catégories -> à voir condition dans albumBD
        $playlistDB = new PlaylistDB();
        $albumsByCategory = [];
        foreach ($categories as $category) {
            $albumsByCategory[$category] = AlbumDB::getInfosCardsAlbum($category);
        }

        try{
            $userId = Utils::getIdUtilisateurConnecte();
            $playlists = $playlistDB->getPlaylists($userId);

        } catch (\Exception $e) {
            $playlists = null;
        }
        
        $base = new BaseTemplate();
        $base->setContent("accueil");
        $base->addParam("albumsByCategory", $albumsByCategory);
        $base->render();
    }
}