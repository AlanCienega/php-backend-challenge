<?php

namespace App\Products;

use App\Traits\ProductTrait;

class Pisco
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

  public function deal()
  {
    $demand = ProductTrait::piscoProductDemand($this->name, $this->quality, $this->sellIn);
    $quality = ProductTrait::setQuality($this->name, $demand);
    $this->quality = $quality;
    $this->sellIn--;
  }
}
