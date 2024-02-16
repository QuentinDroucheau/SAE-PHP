<?php 

namespace controller;

use models\db\AlbumDB;
use models\db\MusiqueDB;
use models\db\ArtisteDB;
use models\db\GenreDB;
use models\db\UtilisateurDB;
use models\db\PlaylistDB;
use view\BaseTemplate;
use utils\Utils;

class ControllerAdmin extends Controller{

    public function view(){
        $albums = AlbumDB::getAlbums();
        $artistes = ArtisteDB::getArtistes();
        $genres = GenreDB::getGenres();
        $musiques = MusiqueDB::getMusiques();
        $utilisateurs = UtilisateurDB::getUtilisateurs();try {
            $userId = Utils::getIdUtilisateurConnecte();
            $lesPlaylists = PlaylistDB::getPlaylists($userId);
        } catch (\Exception $e) {
            $lesPlaylists = null;
        }
        
        $base = new BaseTemplate();
        $base->setContent("admin");
        $base->addParam("albums", $albums);
        $base->addParam("artistes", $artistes);
        $base->addParam("genres", $genres);
        $base->addParam("musiques", $musiques);
        $base->addParam("playlists", $lesPlaylists);
        $base->addParam("utilisateurs", $utilisateurs);
        $base->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
        $base->render();
    }
}
