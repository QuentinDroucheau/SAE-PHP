<?php

namespace models;

class Contient{

    /**
     * @param int $idM
     * @param int $idG
     */
    public function __construct(
        private int $idM,
        private int $idG
    ){}

    /**
     * @return int
     */
    public function getIdM(): int{
        return $this->idM;
    }
    
    /**
     * @return int
     */
    public function getIdG(): int{
        return $this->idG;
    }
}