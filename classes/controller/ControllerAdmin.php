<?php 

namespace controller;

use models\Contient;
use models\db\AlbumDB;
use models\db\MusiqueDB;
use models\db\ArtisteDB;
use models\db\ContientDB;
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

    public function supprimer(){
        $id = $_REQUEST["id"];
        $type = $_REQUEST["type"];
        if($type == "album"){
            AlbumDB::supprimerAlbum($id);
            $Musiques = MusiqueDB::getMusiquesAlbum($id);
            foreach ($Musiques as $musique) {
                ContientDB::supprimerRelation($musique->getId());
            }
            MusiqueDB::supprimerAllMusiqueAlbum($id);
        }
        else if($type == "musique"){
            MusiqueDB::supprimerMusique($id);

        }
        else if($type == "artiste"){
            // Récupérer tous les albums associés à l'artiste
            $albums = AlbumDB::getAlbumsArtiste($id);
    
            // Supprimer chaque album et les musiques associées
            foreach ($albums as $album) {
                $albumId = $album->getId();
    
                // Supprimer les musiques de l'album
                $musiques = MusiqueDB::getMusiquesAlbum($albumId);
                foreach ($musiques as $musique) {
                    ContientDB::supprimerRelation($musique->getId());
                }
                MusiqueDB::supprimerAllMusiqueAlbum($albumId);
    
                // Supprimer l'album
                AlbumDB::supprimerAlbum($albumId);
            }
    
            // Supprimer l'artiste
            ArtisteDB::supprimerArtiste($id);
        }
        else if($type == "genre"){
            GenreDB::supprimerGenre($id);
        }
        else if($type == "utilisateur"){
            UtilisateurDB::supprimerUtilisateur($id);
        }
        $this->view();
    }
}
