<?php 

namespace controller;

use models\db\AlbumDB;
use models\db\ArtisteDB;
use models\db\GenreDB;
use models\db\MusiqueDB;
use utils\Utils;

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

            // Récuperer l'utilisateur connecté
            // $artiste = Utils::getConnexion();

            // recupere lid de l'artiste
            // $idArtiste = $artiste->getId();

            $idA = 444;


            // insert de l'album
            

            $titreAlbum = $_POST['titre'];
            $dateAlbum = date('Y-m-d');
            $descriptionA = $_POST['description'];

            if (isset($_FILES['image'])) {
                $image = $this->traiterImage();
                $imagePath = str_replace('fixtures/images/', '', $image);
            }
            else {
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


            // Insertion des musiques
        
            // if (!empty($_FILES['audio'])) {
            //     $musiqueDB = new MusiqueDB();
            //     $albumId = $albumDB->getIdAlbum($titreAlbum);
            //     echo "<script>alert('AlbumID: $albumId');</script>";

            //     foreach ($_FILES['audio']['tmp_name'] as $key => $tmpName) {
            //         $uploadFile = $this->traiterFichierAudio($tmpName, $_FILES['audio']['name'][$key]);
            //         $nomMusique = $_POST['nomM'][$key];
            //         $musiqueDB->insererMusique($nomMusique, $uploadFile, $albumId);
            //         // Ajout de cette ligne pour déboguer
            //         echo "<script>alert('UploadFile: $uploadFile, NomMusique: $nomMusique, AlbumID: $albumId');</script>";

            //     }
            // }
            // else {
            //     echo "<script>alert('Aucun fichier audio n'a été téléchargé.');</script>";
            // }

            echo 
            "<script>
            alert('L\'album a bien été ajouté');
            window.location.href='/publier'; 
            </script>";
            //
        }
    }

    private function traiterImage() {
        // Taille maximale autorisée en octets (2 Mo)
        $maxFileSize = 2 * 1024 * 1024;
        $uploadDir = 'fixtures/images/';
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


    // // Fonction pour traiter les fichiers audio
    // private function traiterFichierAudio($tmpName, $originalName)
    // {
    //     $uploadDir = 'musiques/';
    //     $uploadFile = $uploadDir . basename($originalName);

    //     // Vérifier si le fichier a été correctement uploadé
    //     if (move_uploaded_file($tmpName, $uploadFile)) {
    //         return $uploadFile;
    //     } else {
    //         // Gestion d'erreur si l'upload échoue
    //         echo "<script>alert('Erreur lors du téléchargement du fichier audio.');</script>";
    //     }
    // }
}