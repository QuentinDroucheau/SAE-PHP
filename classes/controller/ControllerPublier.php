<?php

namespace controller;

use models\db\AlbumDB;
use models\db\ArtisteDB;
use models\db\GenreDB;
use models\db\MusiqueDB;
use models\db\ContientDB;
use utils\Utils;

class ControllerPublier extends Controller{

    /**
     * @return void
     */
    public function view(): void{
        $artistes = ArtisteDB::getArtistes();
        $genres = GenreDB::getGenres();

        // Récupérer l'utilisateur connecté
        $utilisateur = Utils::getConnexion();
        $nomUtilisateur = $utilisateur->getPseudoU();
        $allNomArtiste = ArtisteDB::getAllNomArtiste();

        if (!in_array($nomUtilisateur, $allNomArtiste)) {
            $artisteDB = new ArtisteDB();
            $artisteDB->insererArtiste($nomUtilisateur, 'img/default_profil.webp');
        }
        $idA = ArtisteDB::getIdArtiste($nomUtilisateur);
        $albums = AlbumDB::getAlbumsArtiste($idA);

        $this->template->setContent("publier");
        $this->template->addParam("artistes", $artistes);
        $this->template->addParam("genres", $genres);
        $this->template->addParam("albums", $albums);
        $this->template->addParam("utilisateur", is_null($c = Utils::getConnexion()) ? "" : $c->getPseudoU());
        $lesPlaylists = Utils::getPlaylistsMenu();
        $this->template->addParam("playlists", $lesPlaylists);
        $this->template->render();
    }

    /**
     * @return void
     */
    public function publierContenue(): void{
        // Vérifier si le formulaire a été soumis
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if ($_POST['action'] === 'supprimerAlbum') {
                $idAlbum = $_POST['idAlbum'];
                $albumDB = new AlbumDB();
                $musiqueDB = new MusiqueDB();
                $contientDB = new ContientDB();
    
                try {
                    $albumDB->supprimerAlbum($idAlbum);
                    $Musiques = $musiqueDB->getMusiquesAlbum($idAlbum);
                    foreach ($Musiques as $musique) {
                        $contientDB->supprimerRelation($musique->getId());
                    }
                    $musiqueDB->supprimerAllMusiqueAlbum($idAlbum);
                    echo "<script>alert('L\'album et ses musiques associées ont bien été supprimés.');</script>";
                } catch (\Exception $e) {
                    echo "<script>alert('Erreur lors de la suppression de l\'album et des musiques.');</script>";
                }

            }

            else {

                // Récupérer l'utilisateur connecté
                $utilisateur = Utils::getConnexion();
                $nomUtilisateur = $utilisateur->getPseudoU();

                $allNomArtiste = ArtisteDB::getAllNomArtiste();

                // Vérifier si l'artiste === nom utilisateur, sinon ajouter l'artiste
                if (!in_array($nomUtilisateur, $allNomArtiste)) {
                    $artisteDB = new ArtisteDB();
                    $artisteDB->insererArtiste($nomUtilisateur, 'img/default_profil.webp');
                }
                $idA = ArtisteDB::getIdArtiste($nomUtilisateur);

                // Récupérer l'id de l'artiste (à ajuster selon votre logique)
                // $idA = 444;

                // Insertion de l'album
                $titreAlbum = $_POST['titre'];
                $dateAlbum = date('d/m/Y');
                $descriptionA = $_POST['description'];

                if (isset($_FILES['image'])) {
                    $image = $this->traiterImage();
                    $imagePath = str_replace('public/images/', '', $image);
                } else {
                    $imagePath = 'default.jpg';
                }

                $albumDB = new AlbumDB();
                $albumDB->insererAlbum($titreAlbum, $dateAlbum, $imagePath, $descriptionA, $idA);

                // Insertion des genres
                $selectedGenres = $_POST['genre'];

                if (!empty($selectedGenres)) {
                    $genreDB = new GenreDB();
                    foreach ($selectedGenres as $selectedGenre) {
                        $trimmedGenre = trim($selectedGenre);
                        if (!empty($trimmedGenre)) {
                            if (!$genreDB->genreExiste($trimmedGenre)) {
                                $genreDB->insererGenre($trimmedGenre);
                                echo "<script>alert('Le genre $trimmedGenre a été ajouté.');</script>";
                            }
                        }
                    }
                }

                // Traitement des musiques
                $musiquesListe = json_decode($_POST['musiquesListe'], true);

                if (!empty($musiquesListe) && !empty($selectedGenres)) {
                    $musiqueDB = new MusiqueDB();
                    $contientDB = new ContientDB();

                    foreach ($musiquesListe as $musique) {
                        $nomMusique = $musique['nomMusique'];
                        $lienMusique = $musique['audioPath'];
                        $idAlbum = $albumDB->getIdAlbum();

                        $idMusique = $musiqueDB->insererMusique($nomMusique, $lienMusique, $idAlbum);

                        $genre = $musique['genreMusique'];
                        $idGenre = $genreDB->getGenreByName($genre)->getId();
                        $contientDB->insererContient($idMusique, $idGenre);

                        echo "<script>alert('La musique : $nomMusique avec le genre : $genre a été ajoutée.');</script>";
                    }
                }
                echo "<script>alert('L\'album a bien été ajouté.');</script>";
            }
            echo "<script>window.location.href='/publier';</script>";
        }
    }

    /**
     * @return bool|string
     */
    private function traiterImage(): string|bool{
        // Taille maximale autorisée en octets (2 Mo)
        $maxFileSize = 2 * 1024 * 1024;
        $uploadDir = 'public/images/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        if (file_exists($uploadFile)) {
            return $uploadFile;
        }
        if ($_FILES['image']['size'] > $maxFileSize) {
            return false;
        }
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            return $uploadFile;
        }
        return false;
    }
}
