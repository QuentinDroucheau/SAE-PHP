<?php
// 2 méthodes

namespace controller;

use models\db\AlbumDB;
use models\db\PlaylistDB;
use models\db\ArtisteDB;
use models\db\MusiqueDB;
use utils\Utils;
use view\BaseTemplate;

class ControllerHome extends Controller
{

    public function view(): void
    {
        $categories = ['Récents', 'Populaires']; // on peut ajouter d'autres catégories -> à voir condition dans albumBD
        $playlistDB = new PlaylistDB();
        $albumsByCategory = [];
        foreach ($categories as $category) {
            $albumsByCategory[$category] = AlbumDB::getInfosCardsAlbum($category);
        }

        try {
            $userId = Utils::getIdUtilisateurConnecte();
            $playlists = $playlistDB->getPlaylists($userId);
        } catch (\Exception $e) {
            $playlists = null;
        }

        $base = new BaseTemplate();
        $base->setContent("accueil");

        $albumsDetails = [];
        foreach ($albumsByCategory as $category => $lesAlbums) {
            foreach ($lesAlbums as $album) {
                // récupère l'artiste et les musiques associés à l'album
                $artiste = ArtisteDB::getArtiste($album->getAuteurId());
                $musiques = MusiqueDB::getMusiquesAlbum($album->getId());

                // ajoute l'album, l'artiste, les musiques et la catégorie associés à l'album dans un tableau
                $albumsDetails[$category][] = [
                    'album' => $album,
                    'artiste' => $artiste,
                    'musiques' => $musiques,
                ];
            }
        }
        $base->addParam("albumsDetails", $albumsDetails);
        $base->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
        $base->render();
    }
}
