<?php 

namespace models;

class Note{

    /**
     * @param Utilisateur $utilisateur
     * @param Album $album
     * @param int $note
     * @param string $critique
     */
    public function __construct(
        private Utilisateur $utilisateur,
        private Album $album,
        private int $note,
        private string $critique
    )
    {}

    /**
     * @return Utilisateur
     */
    public function getUtilisateur(): Utilisateur{
        return $this->utilisateur;
    }

    /**
     * @return Album
     */
    public function getAlbum(): Album{
        return $this->album;
    }

    /**
     * @return int
     */
    public function getNote(): int{
        return $this->note;
    }

    /**
     * @return string
     */
    public function getCritique(): string{
        return $this->critique;
    }
}