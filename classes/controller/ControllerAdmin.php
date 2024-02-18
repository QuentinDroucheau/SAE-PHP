<?php 

namespace controller;

use models\db\AlbumDB;
use models\db\MusiqueDB;
use models\db\ArtisteDB;
use models\db\ContientDB;
use models\db\GenreDB;
use models\db\UtilisateurDB;
use models\db\PlaylistDB;
use utils\Utils;

class ControllerAdmin extends Controller{

    /**
     * affiche la page admin
     * @return void
     */
    public function view(): void{
        $albums = AlbumDB::getAlbums();
        $artistes = ArtisteDB::getArtistes();
        $genres = GenreDB::getGenres();
        $musiques = MusiqueDB::getMusiques();
        $utilisateurs = UtilisateurDB::getUtilisateurs();

        $connexion = Utils::getConnexion();
        if(is_null($connexion)){
            $playlists = [];
        }else{
            $playlists = PlaylistDB::getPlaylists($connexion->getId());
        }
        
        $this->template->setContent("admin");
        $this->template->addParam("albums", $albums);
        $this->template->addParam("artistes", $artistes);
        $this->template->addParam("genres", $genres);
        $this->template->addParam("musiques", $musiques);
        $this->template->addParam("playlists", $playlists);
        $this->template->addParam("utilisateurs", $utilisateurs);
        $this->template->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "" : $c->getPseudoU());
        $this->template->render();
    }

    /**
     * supprime un album, une musique, un artiste, un genre ou un utilisateur
     * @return void
     */
    public function supprimer(): void{
        $id = $this->params["id"];
        $type = $this->params["type"];

        switch($type){
            case "album":
                AlbumDB::supprimerAlbum($id);
                $Musiques = MusiqueDB::getMusiquesAlbum($id);
                foreach($Musiques as $musique){
                    ContientDB::supprimerRelation($musique->getId());
                }
                MusiqueDB::supprimerAllMusiqueAlbum($id);
            break;
            case "musique":
                MusiqueDB::supprimerMusique($id);
            break;
            case "artiste":
                // Récupérer tous les albums associés à l'artiste
                $albums = AlbumDB::getAlbumsArtiste($id);
        
                // Supprimer chaque album et les musiques associées
                foreach($albums as $album){
                    $albumId = $album->getId();
        
                    // Supprimer les musiques de l'album
                    $musiques = MusiqueDB::getMusiquesAlbum($albumId);
                    foreach($musiques as $musique){
                        ContientDB::supprimerRelation($musique->getId());
                    }
                    MusiqueDB::supprimerAllMusiqueAlbum($albumId);
        
                    // Supprimer l'album
                    AlbumDB::supprimerAlbum($albumId);
                }
        
                // Supprimer l'artiste
                ArtisteDB::supprimerArtiste($id);
            break;
            case "genre":
                GenreDB::supprimerGenre($id);
            break;
            case "utilisateur":
                UtilisateurDB::supprimerUtilisateur($id);
            break;
        }
        $this->view();
    }
}
