<?php

namespace App\Products;

class Tumi
{

  public $name;
  public $quality;
  public $sellIn;

  public function __construct($name, $quality, $sellIn)
  {
    $this->name = $name;
    $this->quality = $quality;
    $this->sellIn = $sellIn;
  }

  /**
   * el deal para este producto es un poco diferente, es un producto legendario y su valor de calidad es 80
   * si alguien por alguna razon le pone un valor negativo o superior a 80, el valor se sobreescribira.
   *
   * @return void
   */
  public function deal()
  {
    if ($this->quality > 80 || $this->quality < 1) {
      $this->quality = 80;
    } else {
      $this->quality = $this->quality;;
    }
  }
}
