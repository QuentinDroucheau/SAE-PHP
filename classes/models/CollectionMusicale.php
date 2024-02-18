<?php

namespace models;

class CollectionMusicale{
    protected int $id;
    protected string $titre;
    protected ?string $image;
    protected string $datePublication;
    protected string $description;
    protected array $musiques;

    /**
     * @param int $id
     * @param string $titre
     * @param string|null $image
     * @param string $datePublication
     * @param string $description
     * @param array $musiques
     */
    public function __construct(int $id, string $titre, ?string $image, string $datePublication, string $description, array $musiques) {
        $this->id = $id;
        $this->titre = $titre;
        $this->image = $image;
        $this->datePublication = $datePublication;
        $this->description = $description;
        $this->musiques = $musiques;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitre(): string {
        return $this->titre;
    }

    /**
     * @return string
     */
    public function getImage(): string{
        $lien = $this->image ? "fixtures/images/" . $this->image : "../../img/default_album.png";
        if(file_exists($lien)){
            return $lien;
        }
        return "../../img/default_album.png";
    }

    /**
     * @return string
     */
    public function getDatePublication(): string {
        return $this->datePublication;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return Musique[]
     */
    public function getMusiques(): array{
        return $this->musiques;
    }
}