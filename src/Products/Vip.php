<?php

namespace App\Products;

use App\Traits\ProductTrait;

class Vip
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
    $demand = ProductTrait::productDemand($this->quality, $this->sellIn);
    $quality = ProductTrait::setQuality($this->name, $demand);
    $this->quality = $quality;
    $this->sellIn--;
  }
}
