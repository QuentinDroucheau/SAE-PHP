<?php

namespace models;

class Contient {
  public function __construct(
      private int $idM,
      private int $idG
  ){}

  public function getIdM(): int{
      return $this->idM;
  }
  
  public function getIdG(): int {
    return $this->idG;
  }
}