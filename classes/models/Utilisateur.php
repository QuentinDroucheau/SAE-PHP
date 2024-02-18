<?php

namespace models;

class Utilisateur {

    public const ROLE_ADMIN = "admin";
    public const ROLE_USER = "user";
    public const ROLE_ARTISTE = "artiste";
    
    /**
     * @param int $id
     * @param string $pseudoU
     * @param string $mdpU
     * @param string $roleU
     */
    public function __construct(
        private int $id,
        private string $pseudoU,
        private string $mdpU,
        private string $roleU
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
    public function getPseudoU(): string{
        return $this->pseudoU;
    }

    /**
     * @return string
     */
    public function getMdpU(): string{
        return $this->mdpU;
    }

    /**
     * @return string
     */
    public function getRoleU(): string{
        return $this->roleU;
    }

    /**
     * @param string $roleU
     */
    public function setMdpU(string $mdpU){
        $this->mdpU = $mdpU;
    }
}