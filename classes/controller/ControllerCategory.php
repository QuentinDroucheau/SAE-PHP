<?php

namespace controller;

use models\db\AlbumDB;
use view\BaseTemplate;
use models\db\ArtisteDB;
use utils\Utils;
use models\db\GenreDB;

class ControllerCategory extends Controller{
  
    /**
     * affiche la vue d'une catégorie
     * @return void
     */
    public function view(): void{
        $lesPlaylists = Utils::getPlaylistsMenu();
        $category = $this->params["category"];
        $category = $_GET["category"];

        $this->template->setContent("category");
        $genres = GenreDB::getGenres();

        if($category == "artistes"){
            $artistes = ArtisteDB::getArtistes(); 
            $this->template->addParam("items", $artistes);
        }else{
            $albums = AlbumDB::getAllAlbumsByCategory($category);
        }
        
        $this->template->addParam("items", $albums);
        $this->template->addParam("playlists", $lesPlaylists);
        $this->template->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
        $this->template->addParam("category", $category);
        $this->template->addParam("genres", $genres); 
        $this->template->render();
    }

    /**
     * filtre la vue d'une catégorie
     * @return void
     */
    public function filtreView(): void{
        $genres = GenreDB::getGenres(); 
        $lesPlaylists = Utils::getPlaylistsMenu();

        $this->template->setContent("category");
        $artistes = ArtisteDB::getArtistes(); 
        $category = $this->params["category"];
        $artisteId = $this->params["artistId"];
        $genreSelec = intval($this->params["genre"]);
        $this->template->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
        $year = $this->params["year"];
        if (isset($year) || isset($genre) || isset($artistId)) {
            $albums = AlbumDB::getAllAlbumsByCategory($category, $year, $genreSelec, (int) $artisteId);
        } else {
            if($category == "artistes"){
                $this->template->addParam("items", $artistes);
            } else {
                $albums = AlbumDB::getAllAlbumsByCategory($category);
            }
        }
        $this->template->addParam("genres", $genres); 
        $this->template->addParam("selectedGenre", $genreSelec);  
        $this->template->addParam("selectedYear", $year);
        $this->template->addParam("selectedArtist", $artisteId);
        $this->template->addParam("items", $albums);
        $this->template->addParam("category", $category);
        $this->template->addParam("artistes", $artistes);
        $this->template->addParam("playlists", $lesPlaylists);
        $this->template->render();
    }
}