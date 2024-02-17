<?php 

namespace controller;

use models\db\PlaylistDB;

class ControllerPlaylist extends Controller{

    public function ajaxAddMusiqueInPlaylist(){
        $idMusique = $this->params["musique"];
        $idPlaylist = $this->params["playlist"];

        echo json_encode([
            "success" => PlaylistDB::addMusiqueInPlaylist($idMusique, $idPlaylist)
        ]);
        die();
    }
}