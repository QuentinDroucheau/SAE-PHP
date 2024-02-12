<?php
namespace controller;

use models\Artiste;
use models\db\PlaylistDB;
use utils\Utils;


class ControllerPublier extends Controller
{ 
  public function view(): void
  {
  }


  public function publierPlaylist() : void {
    $playlistDB = new PlaylistDB();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $titre = $_POST['titre'];
      $description = $_POST['description'];
      $auteur = Utils::getIdUtilisateurConnecte();
      $dateMaj = date('Y-m-d');
      $image = "";
      $playlistDB->insererPlaylist($titre, $description, $auteur, $dateMaj, $image);
    }
  }
}