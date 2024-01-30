<?php

namespace models;

class Genre {
  public function __construct(
      private int $id,
      private string $nomG
  ){}

  public function getId(): int{
      return $this->id;
  }
}