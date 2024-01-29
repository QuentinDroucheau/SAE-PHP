<?php

namespace models;

class Utilisateur {
    public function __construct(
        private int $id,
        private string $pseudoU,
        private string $mdpU,
        private string $roleU
    ){}

    public function getId(): int{
        return $this->id;
    }

    public function getPseudoU(): string{
        return $this->pseudoU;
    }

    public function getMdpU(): string{
        return $this->mdpU;
    }

    public function getRoleU(): string{
        return $this->roleU;
    }
}