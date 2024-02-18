<?php 

namespace controller;

use models\db\PlaylistDB;
use utils\Utils;
use view\BaseTemplate;

class ControllerPlaylist extends Controller{

    /**
     * affiche la vue d'une playlist
     * @return void
     */
    public function view(): void{
        $playlistId = $this->params["id"];
        $p = PlaylistDB::getPlaylist($playlistId);

        $this->template->setContent("playlist");
        $this->template->addParam("idPlaylist", $playlistId);
        $this->template->addParam("title", "Playlist");
        $this->template->addParam("playlist", $p);
        $this->template->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
        $this->template->addParam("musiques", PlaylistDB::getMusiques($playlistId));

        if(!is_null(Utils::getConnexion())){
            $this->template->addParam("playlists", PlaylistDB::getPlaylists(Utils::getConnexion()->getId()));
        }else{
            $this->template->addParam("playlists", []);
        }

        $this->template->render();
    }

    /**
     * @return void
     */
    public function ajaxAddMusiqueInPlaylist(): void{
        $idMusique = $this->params["musique"];
        $idPlaylist = $this->params["playlist"];

        echo json_encode([
            "success" => PlaylistDB::addMusiqueInPlaylist($idMusique, $idPlaylist)
        ]);
        die();
    }

    /**
     * @return void
     */
    public function ajaxRemoveMusiqueInPlaylist(){
        $idMusique = $this->params["musique"];
        $idPlaylist = $this->params["playlist"];

        echo json_encode([
            "success" => PlaylistDB::removeMusiqueInPlaylist($idMusique, $idPlaylist)
        ]);
        die();
    }

    /**
     * @return void
     */
    public function ajaxUpdatePlaylist(){
        $idPlaylist = $this->params["id"];
        $titre = $this->params["titre"];
        $description = $this->params["description"];

        echo json_encode([
            "success" => PlaylistDB::updatePlaylist($idPlaylist, $titre, $description)
        ]);
        die();
    }
}