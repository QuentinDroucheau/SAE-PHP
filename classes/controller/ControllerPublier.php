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

            $description = $_POST['description'];

            // Récuperer l'utilisateur connecté
            $artiste = Utils::getConnexion();

            // insert de l'album

            $titreAlbum = $_POST['titre'];

            $dateAlbum = date('Y');

            if (isset($_FILES['image'])) {
                $image = $this->traiterImage();
                $imagePath = str_replace('fixtures/images/', '', $image);
                echo "<script>alert('Image: $image');</script>";
            }
            else {
                echo "<script>alert('Aucune image n'a été téléchargée.');</script>";
                $imagePath = 'default.jpg';
            }

            $albumDB = new AlbumDB();
            echo "<script>alert('Titre: $titreAlbum, Artiste: $artiste, Image: $imagePath, Date: $dateAlbum, Description: $description');</script>";
            $albumDB->insererAlbum($titreAlbum, $artiste, $imagePath, $dateAlbum, $description, $musiques = []);


            // Insertion des nouveaux genres
            
            $selectedGenres = $_POST['genre'];

            // Faites quelque chose avec les genres récupérés
            if (!empty($selectedGenres)) {
                $genreDB = new GenreDB();
                // Traitement des genres ici
                foreach ($selectedGenres as $selectedGenre) {
                    $trimmedGenre = trim($selectedGenre);
                    if (!empty($trimmedGenre)) {
                        // Vérifiez si le genre existe déjà
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

    private function traiterImage()
    {
        $uploadDir = 'fixtures/images/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        // Vérifier si le fichier existe déjà
        if (file_exists($uploadFile)) {
            echo "<script>alert('Le fichier existe déjà.');</script>";
            return $uploadFile; // Si le fichier existe, retourner le chemin existant
        }

        // Obtenir l'extension du fichier
        $imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        // Liste des extensions d'images autorisées
        $extensionsAutorisees = ['jpg', 'jpeg', 'png'];

        // Vérifier si l'extension est autorisée
        if (in_array(strtolower($imageExtension), $extensionsAutorisees)) {
            // Essayer de télécharger le fichier
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                return $uploadFile;
            } else {
                // Gestion d'erreur si l'upload échoue
                echo "<script>alert('Erreur lors du téléchargement de l'image.');</script>";
            }
        } else {
            // Extension non autorisée
            echo "<script>alert('Type d'image non autorisé. Les types autorisés sont : " . implode(', ', $extensionsAutorisees) . "');</script>";
        }
        return false; // Ajoutez cette ligne pour indiquer que le téléchargement a échoué
    }




    // Fonction pour traiter les fichiers audio
    private function traiterFichierAudio($tmpName, $originalName)
    {
        $uploadDir = 'musiques/';
        $uploadFile = $uploadDir . basename($originalName);

        // Vérifier si le fichier a été correctement uploadé
        if (move_uploaded_file($tmpName, $uploadFile)) {
            return $uploadFile;
        } else {
            // Gestion d'erreur si l'upload échoue
            echo "<script>alert('Erreur lors du téléchargement du fichier audio.');</script>";
        }
    }
}