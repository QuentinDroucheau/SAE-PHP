<?php

namespace controller;

use models\db\AlbumDB;
use view\BaseTemplate;
use models\db\ArtisteDB;
use models\db\GenreDB as DbGenreDB;
use utils\Utils;
use models\db\GenreDB;

class ControllerCategory extends Controller
{
  public function view(): void
  {
    $lesPlaylists = Utils::getPlaylistsMenu();
    $category = $this->params["category"];
    $category = $_GET["category"];
    $base = new BaseTemplate();
    $base->setContent("category");
    $genres = GenreDB::getGenres();  
    if($category == "artistes"){
      $artistes = ArtisteDB::getArtistes(); 
      $base->addParam("items", $artistes);
    } else {
      $albums = AlbumDB::getAllAlbumsByCategory($category);

    }
    
    $base->addParam("items", $albums);
    $base->addParam("playlists", $lesPlaylists);
    $base->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
    $base->addParam("category", $category);
    $base->addParam("genres", $genres); 
    $base->render();
  }


public function filtreView(){
    $genres = GenreDB::getGenres(); 
    $lesPlaylists = Utils::getPlaylistsMenu();
    $base = new BaseTemplate();
    $base->setContent("category");
    $category = $this->params["category"];
    $year = $this->params["year"];
    if (isset($year) && !empty($year)) {
        $albums = AlbumDB::getAllAlbumsByCategory($category, $year);
    } else {
        if($category == "artistes"){
            $artistes = ArtisteDB::getArtistes(); 
            $base->addParam("items", $artistes);
        } else {
            $albums = AlbumDB::getAllAlbumsByCategory($year);
        }
    }
    $base->addParam("genres", $genres); 
    $base->addParam("items", $albums);
    $base->addParam("category", $category);
    $base->addParam("playlists", $lesPlaylists);
    $base->render();
}
}