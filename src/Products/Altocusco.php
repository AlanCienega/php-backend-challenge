<?php

namespace App\Products;

use App\Traits\ProductTrait;

class Altocusco
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
    $normal_downgrade = ProductTrait::setDegradation($this->name, $this->quality, $this->sellIn);
    $total_downgrade = ProductTrait::setQuality($this->name, $normal_downgrade, $this->sellIn);
    $this->quality = $total_downgrade;
    $this->sellIn--;
  }
}
