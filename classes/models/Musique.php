<?php 

namespace models;

use models\db\MusiqueDB;

class Musique{

    /**
     * @param int $id
     * @param string $nom
     * @param string $lien
     * @param int $ecoute
     * @param string $albumName
     */
    public function __construct(
        private int $id, 
        private string $nom,
        private string $lien,
        private int $ecoute, 
        private string $albumName
    ){}

    /**
     * @return int
     */
    public function getId(): int{
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom(): string{
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getAlbumName(): string {
        return $this->albumName;
    }

    /**
     * @return string
     */
    public function getLien(): string{
        $lien = "public/images/" . $this->lien;
        if(file_exists($lien)){
            return $lien;
        }
        return "../../img/default_album.png";
    }

    /**
     * @return int
     */
    public function getEcoute(): int{
        return $this->ecoute;
    }

    /**
     * @return array
     */
    public function toJsonArray(): array {
        return [
            "id" => $this->getId(),
            "nom" => $this->getNom(),
            "lien" => $this->getLien(),
        ];
    }

    /**
     * @param int $id
     * @return string
     */
    public function getArtisteMusique(int $id): string{
        // Utilisez la méthode appropriée de MusiqueDB pour obtenir les musiques de l'artiste
        return MusiqueDB::getArtisteMusique($id);
    }
}