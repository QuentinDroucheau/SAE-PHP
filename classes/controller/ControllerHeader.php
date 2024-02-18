<?php

namespace controller;
use models\db\ArtisteDB;
use models\db\AlbumDB;
use models\db\MusiqueDB;

class ControllerHeader extends Controller{

    /**
     * recherche des artistes, albums et musiques
     */
    public function search(): void{
        $search = $this->params["search"];
        $artistes = ArtisteDB::searchArtistes($search);
        $albums = AlbumDB::searchAlbums($search);
        $musiques = MusiqueDB::searchMusiques($search);
        $result = [
            "artistes" => $artistes,
            "albums" => $albums,
            "musiques" => $musiques
        ];
        echo json_encode($result);
        die();
    }
}