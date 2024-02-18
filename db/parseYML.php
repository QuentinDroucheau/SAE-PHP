<?php

require_once 'db/Spyc.php';

 function parseYAML($yamlContent) {
     return Spyc::YAMLLoadString($yamlContent);
 }

try {
    $sql = file_get_contents("db/table.sql");
    $db = new \PDO("sqlite:db/database.sqlite3");
    $db->exec($sql);
    $db = null;

    // Charger le fichier YAML
    $yamlContent = file_get_contents('db/extrait.yml');
    $data = parseYAML($yamlContent);

    // Connexion à la base de données SQLite
    $db = new PDO('sqlite:db/database.sqlite3');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare('INSERT INTO utilisateur (pseudoU, mdpU, mailU, roleU) VALUES (:pseudoU, :mdpU, :mailU, :roleU)');
    $pseudo = "quentin";
    $mdp = "motdepasse";
    $mail = "quentin@gmail.com";
    $role = "user";

    $stmt->bindParam(':pseudoU', $pseudo);
    $stmt->bindParam(':mdpU', $mdp);
    $stmt->bindParam(':mailU', $mail);
    $stmt->bindParam(':roleU', $role);
    $stmt->execute();

    $stmt = $db->prepare('INSERT INTO utilisateur (pseudoU, mdpU, mailU, roleU) VALUES (:pseudoU, :mdpU, :mailU, :roleU)');
    $pseudo = "kev";
    $mdp = "adm";
    $mail = "kevin@gmail.com";
    $role = "user";

    $stmt->bindParam(':pseudoU', $pseudo);
    $stmt->bindParam(':mdpU', $mdp);
    $stmt->bindParam(':mailU', $mail);
    $stmt->bindParam(':roleU', $role);
    $stmt->execute();

   // Boucle sur les données YAML et insertion dans la base de données
    foreach ($data as $album) {
        // Vérifier si l'artiste existe
        $stmt = $db->prepare('SELECT idA FROM artiste WHERE nomA = :nomA');
        $stmt->bindParam(':nomA', $album['nomA']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            // Si l'artiste n'existe pas, l'ajouter
            $stmt = $db->prepare('INSERT INTO artiste (nomA) VALUES (:nomA)');
            $stmt->bindParam(':nomA', $album['nomA']);
            $stmt->execute();
            $idA = $db->lastInsertId();
        } else {
            // Si l'artiste existe, récupérer son id
            $idA = $result['idA'];
        }

        $stmt = $db->prepare('INSERT INTO album (idAlbum, anneeAlbum, titreAlbum, imgAlbum, descriptionA, idA) VALUES (:idAlbum, :anneeAlbum, :titreAlbum, :imgAlbum, :descriptionA, :idA)');
        $stmt->bindParam(':idAlbum', $album['idAlbum']);
        $stmt->bindParam(':anneeAlbum', $album['anneeAlbum']);
        $stmt->bindParam(':titreAlbum', $album['titreAlbum']);
        $stmt->bindParam(':imgAlbum', $album['imgAlbum']);
        $stmt->bindParam(':descriptionA', $album['descriptionA']);
        $stmt->bindParam(':idA', $idA);
        $stmt->execute();

        foreach ($album['musiques'] as $musique) {
                // Vérifier si le genre existe
                if (is_array($musique) && array_key_exists('nomG', $musique)) {
                    $stmt = $db->prepare('SELECT idG FROM genre WHERE nomG = :nomG');
                    $stmt->bindParam(':nomG', $musique['nomG']);
                    $stmt->execute();
                    $resultGenre = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$resultGenre) {
                        // Si le genre n'existe pas, l'ajouter
                        $stmt = $db->prepare('INSERT INTO genre (nomG) VALUES (:nomG)');
                        $stmt->bindParam(':nomG', $musique['nomG']);
                        $stmt->execute();
                        $idG = $db->lastInsertId();
                    } else {
                        // Si le genre existe, récupérer son ID
                        $idG = $resultGenre['idG'];
                    }

                    // Insérer la relation entre la musique et le genre
                    $stmt = $db->prepare('INSERT INTO contient (idM, idG) VALUES (:idM, :idG)');
                    $stmt->bindParam(':idM', $musique['idM']);
                    $stmt->bindParam(':idG', $idG);
                    $stmt->execute();
                    
                    $stmt = $db->prepare('INSERT INTO musique (idM, nomM, lienM, idAlbum) VALUES (:idM, :nomM, :lienM, :idAlbum)');
                    $stmt->bindParam(':idM', $musique['idM']);
                    $stmt->bindParam(':nomM', $musique['nomM']);
                    $stmt->bindParam(':lienM', $musique['lienM']);
                    $stmt->bindParam(':idAlbum', $album['idAlbum']);
                    $stmt->execute();
                }
            }
        }

    echo 'Base de données créée avec succès.';
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
