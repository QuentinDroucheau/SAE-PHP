<?php 

namespace controller;

use models\db\PlaylistDB;
use utils\Utils;
use view\BaseTemplate;

class ControllerPlaylist extends Controller{

    public function view(): void{
        $playlistId = $this->params["id"];
        $p = PlaylistDB::getPlaylist($playlistId);

        $base = new BaseTemplate();
        $base->setContent("playlist");
        $base->addParam("idPlaylist", $playlistId);
        $base->addParam("title", "Playlist");
        $base->addParam("playlist", $p);
        $base->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
        $base->addParam("musiques", PlaylistDB::getMusiques($playlistId));

        if(!is_null(Utils::getConnexion())){
            $base->addParam("playlists", PlaylistDB::getPlaylists(Utils::getConnexion()->getId()));
        }else{
            $base->addParam("playlists", []);
        }

        $base->render();
    }

    public function ajaxAddMusiqueInPlaylist(){
        $idMusique = $this->params["musique"];
        $idPlaylist = $this->params["playlist"];

        echo json_encode([
            "success" => PlaylistDB::addMusiqueInPlaylist($idMusique, $idPlaylist)
        ]);
        die();
    }

    public function ajaxRemoveMusiqueInPlaylist(){
        $idMusique = $this->params["musique"];
        $idPlaylist = $this->params["playlist"];

        echo json_encode([
            "success" => PlaylistDB::removeMusiqueInPlaylist($idMusique, $idPlaylist)
        ]);
        die();
    }
}