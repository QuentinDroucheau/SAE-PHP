<?php 

namespace controller;

use models\db\AlbumDB;
use models\db\ArtisteDB;
use models\db\GenreDB;

class ControllerPublier extends Controller{

    public function view(){
        $artistes = ArtisteDB::getArtistes();
        $genres = GenreDB::getGenres();

        $this->render("base", [
            "header" => $this->get("element/header"),
            "menu" => $this->get("element/menu"),
            "content" => $this->get("publier",[
                "artistes" => $artistes,
                "genres" => $genres
            ]),
        ]);
    }

    public function publierContenue(){
    // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // ????? c'est pour faire quoi ?

            $description = $_POST['description'];

            // insert de l'album

            $titreAlbum = $_POST['titre'];
            $dateAlbum = date('Y');
            if (isset($_FILES['image'])) {
                $image = $this->traiterImage();
                $imagePath = str_replace('fixtures/images/', '', $image);
            }
            $albumDB = new AlbumDB();
            $albumDB->insererAlbum($titreAlbum, $dateAlbum, $imagePath);
            
            $selectedGenres = $_POST['genre'];

            // Faites quelque chose avec les genres récupérés
            if (!empty($selectedGenres)) {
                // Traitement des genres ici
                foreach ($selectedGenres as $selectedGenre) {
                    // Faites ce que vous devez faire avec chaque genre
                    echo "<script>alert('$selectedGenre');</script>";
                }
            } else {
                echo "<script>alert('Aucun genre sélectionné');</script>";
            }

            // Traitement des fichiers audio
            // $fichiersAudio = $this->traiterFichiersAudio();


            // Insérer les genres associés à ce contenu dans la base de données
            // $genreDB = new GenreDB();
            // foreach ($genres as $genre) {
            //     $genreDB->insererGenre($genre);
            // }

            echo 
            "<script>
            alert('L\'album a bien été ajouté'); 
            window.location.href='/publier';
            </script>";
        }
    }

    // Fonction pour traiter l'image
    private function traiterImage()
    {
        $uploadDir = 'fixtures/images/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        // Vérifier si le fichier a été correctement uploadé
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            return $uploadFile;
        } else {
            // Gestion d'erreur si l'upload échoue
            echo 
            "<script>
            alert('Erreur lors du téléchargement du fichier.'); 
            window.location.href='/publier';
            </script>";
        }
    }

    // Fonction pour traiter les fichiers audio
    private function traiterFichiersAudio(){
        $fichiersAudio = [];
        $uploadDir = 'audio/';
        foreach ($_FILES['audio']['tmp_name'] as $key => $tmpName) {
            $uploadFile = $uploadDir . basename($_FILES['audio']['name'][$key]);
            if (move_uploaded_file($tmpName, $uploadFile)) {
                $fichiersAudio[] = $uploadFile;
            } else {
                // Gestion d'erreur si l'upload échoue
                die('Erreur lors du téléchargement du fichier.');
            }
        }
        return $fichiersAudio;
    }
}