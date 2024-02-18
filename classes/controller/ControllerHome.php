<?php

namespace controller;

use models\db\AlbumDB;
use models\db\ArtisteDB;
use models\db\MusiqueDB;
use utils\Utils;
use view\BaseTemplate;

class ControllerHome extends Controller
{

    /**
     * affiche la page d'accueil
     * @return void
     */
    public function view(): void
    {
        $artistes = ArtisteDB::getArtistesLimit();
        $categories = ['Récents', 'Découvrir des albums...',"Sorties que vous suivez"]; // on peut ajouter d'autres catégories -> à voir condition dans albumBD
        if(Utils::getConnexion() !== null){
            $categories[] = 'Sorties que vous suivez';
        }
        $albumsByCategory = [];
        try{
            $idUtilisateur = Utils::getIdUtilisateurConnecte();
        }
        catch(\Exception $e){
            $idUtilisateur = null;
        }
        foreach ($categories as $category) {
            $albumsByCategory[$category] = AlbumDB::getInfosCardsAlbum($category, $idUtilisateur);
        }

        $lesPlaylists = Utils::getPlaylistsMenu();

        $this->template->addParam("playlists", $lesPlaylists);
        $this->template->setContent("accueil");

        $albumsDetails = [];
        $albumsDetailsJson = [];
        // MusiqueDB::insererSonsPlaylists([1, 2, 3], 1); fonctionnel pour l'ajax ensuite

        foreach ($albumsByCategory as $category => $lesAlbums) {
            foreach ($lesAlbums as $album) {
                // récupère l'artiste et les musiques associés à l'album
                $artiste = $album->getAuteur();
                $musiques = MusiqueDB::getMusiquesAlbum($album->getId());

                // ajoute l'album, l'artiste, les musiques et la catégorie associés à l'album dans un tableau
                $albumsDetails[$category][] = [
                    'album' => $album,
                    'artiste' => $artiste,
                    'musiques' => $musiques,
                ];

                $musiquesJson = [];
                foreach ($musiques as $musique) {
                    $musiquesJson[] = $musique->toJsonArray();
                }

                // ajoute l'album, l'artiste, les musiques et la catégorie associés à l'album dans un tableau JSON
                $albumsDetailsJson[$category][] = [
                    'album' => $album->toJsonArray(),
                    'musiques' => $musiquesJson,

                ];
            }
        }
        $utilisateur = Utils::getConnexion();
        $artistesSuivis = [];
        if ($utilisateur) {
            $artistesSuivis = ArtisteDB::getUserFollowedArtists($utilisateur->getId());
        }

        $this->template->addParam("artistesSuivis", $artistesSuivis);
        $this->template->addParam("albumsDetails", $albumsDetails);
        $this->template->addParam("albumsDetailsJson", json_encode($albumsDetailsJson));
        $this->template->addParam("lesPlaylists", $lesPlaylists);
        $this->template->addParam("artistes", $artistes);
        $this->template->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
        $this->template->render();
    }

    /**
     * @return void
     */
    public function publiersSonsPlaylist(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $songIds = $_POST['songIds'] ?? null;
            if ($songIds === null) {
                echo json_encode(['status' => 'error', 'message' => 'DataIDS NULL .']);
                return;
            }
            $playlistId = $_POST['playlistId'] ?? null;
            if ($playlistId === null) {
                echo json_encode(['status' => 'error', 'message' => 'PlaylistID NULL .']);
                return;
            }
            try {
                $songIds = json_decode($songIds, true);
                $result = MusiqueDB::insererSonsPlaylists($songIds, $playlistId);
                echo json_encode($result);
            } catch (\Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'An error occurred while adding songs to the playlist: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data received.']);
        }
    }
}
