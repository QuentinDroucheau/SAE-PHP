<?php
namespace controller;
use models\db\ArtisteDB;
use models\db\AlbumDB;
use models\db\MusiqueDB;

class ControllerHeader extends Controller{

  public function view(): void
  {
  }

  public function search(): void{
    $search = $this->params["search"];
    $artistes = ArtisteDB::searchArtistes($search);
    $albums = AlbumDB::searchAlbums($search);
    $musiques = MusiqueDB::searchMusiques($search);
    $result = $artistes;
    echo json_encode($result);
    die();
  }
}