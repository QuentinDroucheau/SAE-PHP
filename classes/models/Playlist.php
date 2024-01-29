<?php
class Playlist {
    public function __construct(
        private int $id,
        private string $nomP,
        private string $imgPlaylist,
        private string $descriptionP,
        private int $idU
    ){}

    public function getId(): int{
        return $this->id;
    }

    public function getNomP(): string{
        return $this->nomP;
    }

    public function getImgPlaylist(): string{
        return $this->imgPlaylist;
    }

    public function getDescriptionP(): string{
        return $this->descriptionP;
    }

    public function getIdU(): int{
        return $this->idU;
    }
}