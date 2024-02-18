<?php

namespace models;

class Genre{

    /**
     * @param int $id
     * @param string $nomG
     */
    public function __construct(
        private int $id,
        private string $nomG
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
    public function getNom(): string {
        return $this->nomG;
    }
}