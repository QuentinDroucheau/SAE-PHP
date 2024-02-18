<?php
class Abonnement{

    /**
     * @param int $idU
     * @param int $idA
     */
    public function __construct(
        private int $idU,
        private int $idA
    ){}

    /**
     * @return int
     */
    public function getIdU(): int{
        return $this->idU;
    }

    /**
     * @return int
     */
    public function getIdA(): int{
        return $this->idA;
    }
}