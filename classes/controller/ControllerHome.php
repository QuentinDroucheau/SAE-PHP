<?php
// 2 méthodes

namespace controller;

use models\db\AlbumDB;
use models\db\PlaylistDB;
use models\db\ArtisteDB;
use models\db\MusiqueDB;
use models\db\UtilisateurDB;
use utils\Utils;
use view\BaseTemplate;

class ControllerHome extends Controller
{

    public function view(): void
    {
        $test = AlbumDB::searchAlbums("We");
        $artistes = ArtisteDB::getArtistesLimit();
        $categories = ['Récents', 'Populaires']; // on peut ajouter d'autres catégories -> à voir condition dans albumBD
        $albumsByCategory = [];
        foreach ($categories as $category) {
            $albumsByCategory[$category] = AlbumDB::getInfosCardsAlbum($category);
        }
        $lesPlaylists = Utils::getPlaylistsMenu();
        $params = ['playlists' => $lesPlaylists];
        $base = new BaseTemplate($params);
        $base->setContent("accueil");

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

        $base->addParam("albumsDetails", $albumsDetails);
        $base->addParam("albumsDetailsJson", json_encode($albumsDetailsJson));
        $base->addParam("lesPlaylists", $lesPlaylists);
        $base->addParam("artistes", $artistes);
        $base->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "Connexion" : $c->getPseudoU());
        $base->addParam("test", $test); // test
        $base->render();
    }

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
                $result = MusiqueDB::insererSonsPlaylists($songIds, $playlistId);
                if ($result === "Les chansons ont été insérées avec succès dans la playlist.") {
                    echo json_encode(['status' => 'success', 'message' => $result]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => $result]);
                }
            } catch (\Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'An error occurred while adding songs to the playlist: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data received.']);
        }
        
    }
}
