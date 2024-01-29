<?php
class Abonnement {
    public function __construct(
        private int $idU,
        private int $idA
    ){}

    public function getIdU(): int{
        return $this->idU;
    }

    public function getIdA(): int{
        return $this->idA;
    }
}