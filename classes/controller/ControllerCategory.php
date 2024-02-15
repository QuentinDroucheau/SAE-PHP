<?php

namespace controller;

use models\db\AlbumDB;
use view\BaseTemplate;
use models\db\ArtisteDB;

class ControllerCategory extends Controller
{
  public function view(): void
  {
    $category = $this->params["category"];
    $base = new BaseTemplate();
    $base->setContent("category");
    $base->addParam("category", $category);
  
    if($category == "artistes"){
      $artistes = ArtisteDB::getArtistes(); 
      $base->addParam("items", $artistes);
    } else {
      $albums = AlbumDB::getAllAlbumsByCategory($category);
      $base->addParam("items", $albums);
    }
  
    $base->render();
  }
}