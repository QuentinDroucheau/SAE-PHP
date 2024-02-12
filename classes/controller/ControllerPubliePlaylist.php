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
    $playlistDB = new PlaylistDB();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $titre = $_POST['titre'];
      $description = $_POST['description'];
      $auteur = Utils::getIdUtilisateurConnecte();
      $dateMaj = date('Y-m-d');
      $anneeP = date('Y-m-d');
      if (isset($_FILES['image'])) {
        $image = Utils::traiterImage();
        $imagePath = str_replace('fixtures/images/', '', $image);
      } else {
        $imagePath = 'default.jpg';
      }
      $playlistDB->insererPlaylist($titre, $description, $auteur, $dateMaj, $image, $anneeP);
    }
  }
}
