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
  $genres = GenreDB::getGenres();  

  if($category == "artistes"){
    $this->viewArtists();
  } else {
    $base->setContent("category");
    $albums = AlbumDB::getAllAlbumsByCategory($category);
    $base->addParam("items", $albums);
    $base->addParam("playlists", $lesPlaylists);
    $base->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
    $base->addParam("category", $category);
    $base->addParam("genres", $genres); 
    $base->render();
  }
}


public function filtreView(){
    $genres = GenreDB::getGenres(); 
    $lesPlaylists = Utils::getPlaylistsMenu();
    $base = new BaseTemplate();
    $base->setContent("category");
    $artistes = ArtisteDB::getArtistes(); 
    $category = $this->params["category"];
    $artisteId = $this->params["artistId"];
    $genreSelec = intval($this->params["genre"]);
    $base->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
    $year = $this->params["year"];
    if (isset($year) || isset($genre) || isset($artistId)) {
        $albums = AlbumDB::getAllAlbumsByCategory($category, $year, $genreSelec, $artisteId);
    } else {
        if($category == "artistes"){
            $base->addParam("items", $artistes);
        } else {
            $albums = AlbumDB::getAllAlbumsByCategory($category);
        }
    }
    $base->addParam("genres", $genres); 
    $base->addParam("selectedGenre", $genreSelec);  
    $base->addParam("selectedYear", $year);
    $base->addParam("selectedArtist", $artisteId);
    $base->addParam("items", $albums);
    $base->addParam("category", $category);
    $base->addParam("artistes", $artistes);
    $base->addParam("playlists", $lesPlaylists);
    $base->render();
}

public function viewArtists(): void
{
  $category = $this->params["category"];
  $lesPlaylists = Utils::getPlaylistsMenu();
  $base = new BaseTemplate();
  $base->setContent("artisteCategory");
  $artistes = ArtisteDB::getArtistes(); 
  $base->addParam("items", $artistes);
  $base->addParam("playlists", $lesPlaylists);
  $base->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
  $base->addParam("category", $category);
  $base->render();
}
}