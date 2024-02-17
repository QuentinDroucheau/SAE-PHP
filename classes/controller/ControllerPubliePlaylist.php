<?php

namespace controller;

use models\Artiste;
use models\db\PlaylistDB;
use utils\Utils;


class ControllerPubliePlaylist extends Controller
{
  public function view(): void
  {
  }


  public function publierPlaylist(): void
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $titre = $_POST['titre'];
      $description = $_POST['description'];
      $auteur = Utils::getIdUtilisateurConnecte();
      $dateMaj = date('d/m/Y');
      $anneeP = date('d/m/Y');
      if (isset($_FILES['image'])) {
        $image = Utils::traiterImage();
        $imagePath = str_replace('fixtures/images/', '', $image);
      } else {
        $imagePath = 'default.jpg';
      }
      $response = PlaylistDB::insererPlaylist($titre, $description, $auteur, $dateMaj, $imagePath, $anneeP);
      header('Content-Type: application/json');
      echo $response;
      exit;
    }
  }

  public function effacerPlaylist(): void
  {
    $playlistDB = new PlaylistDB();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $playlistId = $_POST['playlistId'];
      $response = $playlistDB->effacerPlaylist($playlistId);
      header('Content-Type: application/json');
      echo $response;
      exit;
    }
  }
}
