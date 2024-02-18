<?php

namespace controller;

use models\db\AlbumDB;
use models\db\MusiqueDB;
use models\db\ArtisteDB;
use models\db\GenreDB;
use view\BaseTemplate;
use utils\Utils;
use models\db\AbonnementDB;

class ControllerArtiste extends Controller
{

    /**
     * affiche la vue d'un artiste
     * @return void
     */
    public function view(): void
    {
        $lesPlaylists = Utils::getPlaylistsMenu();
        $albums = AlbumDB::getAlbumsArtiste($this->params["id"]);
        $allAlbums = AlbumDB::getAlbums();
        $musiquesArtiste = MusiqueDB::getMusiquesArtiste($this->params["id"]);
        $idArtiste = $this->params["id"];
        $artiste = ArtisteDB::getArtiste($idArtiste);

        $genres = [];
        for ($i = 0; $i < count($musiquesArtiste); $i++) {
            $currentGenres = GenreDB::getGenresMusique($musiquesArtiste[$i]->getId());
            $genres = array_merge($genres, $currentGenres);
        }
        $nbFollowers = AbonnementDB::getFollowersCount($idArtiste);
        $artisteSimilaires = [];
        foreach ($allAlbums as $album) {
            try {
                $musiquesAlbum = MusiqueDB::getMusiquesAlbum($album->getId());
                $genresMusiques = [];
                foreach ($musiquesAlbum as $musique) {
                    $genresMusiques = array_merge($genresMusiques, GenreDB::getGenresMusique($musique->getId()));
                }

                $genreNames = array_map(function ($genre) {
                    return $genre->getNom();
                }, $genres);

                $artistName = ArtisteDB::getArtisteAlbum($album->getId());
                $artistId = ArtisteDB::getIdArtisteByNom($artistName);

                if ($artistId != $idArtiste && !in_array(['nomA' => $artistName, 'idA' => $artistId], $artisteSimilaires, true)) {
                    $albumGenres = array_map(function ($genre) {
                        return $genre->getNom();
                    }, $genresMusiques);

                    if (array_intersect($albumGenres, $genreNames)) {
                        $artisteSimilaires[] = [
                            'nomA' => $artistName,
                            'idA' => $artistId
                        ];
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        $estFollow = AbonnementDB::isUserFollowing(Utils::getConnexion()?->getId(), $idArtiste);
        $this->template->addParam("estFollow", $estFollow);
        $this->template->setContent("artiste");
        $this->template->addParam("nbFollowers", $nbFollowers);
        $this->template->addParam("playlists", $lesPlaylists);
        $this->template->addParam("albums", $albums);
        $this->template->addParam("musiquesArtiste", $musiquesArtiste);
        $this->template->addParam("artiste", $artiste);
        $this->template->addParam("genres", $genres);
        $this->template->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "" : $c->getPseudoU());
        $this->template->addParam("artisteSimilaires", $artisteSimilaires);
        $this->template->render();
    }


    public function follow(): void
    {
        $idArtiste = $_POST['artistId'] ?? null;
        $idUser = Utils::getConnexion()?->getId();
        if (is_null($idUser)) {
            echo json_encode(["success" => false]);
            die();
        } else {
            if (AbonnementDB::isUserFollowing($idUser, $idArtiste)) {
                AbonnementDB::unfollowUser($idUser, $idArtiste);
                echo json_encode(["success" => true, "action" => "unfollowed", "followers" => AbonnementDB::getFollowersCount($idArtiste)]);
            } else {
                AbonnementDB::followUser($idUser, $idArtiste);
                echo json_encode(["success" => true, "action" => "followed", "followers" => AbonnementDB::getFollowersCount($idArtiste)]);
            }
            die();
        }
        echo json_encode(["success" => true]);
    }

}
