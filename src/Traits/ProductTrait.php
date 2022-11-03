<?php

namespace App\Traits;

use App\Naming\ProductName;

trait ProductTrait
{
  /**
   * esta funcion se encarga de definir la degradacion del producto, la mayoria tienen un valor normal
   * pero el producto café altocusco es bastante delicado, por lo que se degrada 2 veces mas rápido
   *
   * @return void
   */
  public static function setDegradation($name, $quality, $sellIn)
  {

    if ($name == ProductName::ALTOCUSCO) {
      if ($sellIn <= 0) {
        $quality -= 4;
      } else {
        $quality -= 2;
      }
    } else {
      if ($sellIn <= 0) {
        $quality -= 2;
      } else {
        $quality--;
      }
    }
    return $quality;
  }

  /**
   * esta funcion se encarga de definir la calidad del producto despues de haberse hecho todas las operaciones
   * para cada caso, para la mayoria caen en el mismo valor, pero para productos pisco y vip, su maxima calidad
   * sera de 50.
   *
   * @return void
   */
  public static function setQuality($name, $quality)
  {
    if (($name == ProductName::PISCO || $name == ProductName::VIP) && $quality > 50) {
      $quality = 50;
    }
    if ($quality < 0) {

      $quality = 0;
    }
    return $quality;
  }

  /**
   * definimos la calidad del producto vip que vale mas cada que pasan los dias antes de su fecha de venta
   * despues de eso el producto ya no vale nada, es decir su calidad baja a 0
   *
   * @return void
   */
  public static function productDemand($quality, $sellIn)
  {
    if ($sellIn <= 0) {
      $quality = 0;
    } else if ($sellIn <= 5) {
      $quality += 3;
    } else if ($sellIn <= 10) {
      $quality += 2;
    } else {
      $quality++;
    }
    return $quality;
  }

  /**
   * se encarga de definir la calidad del producto llamado pisco
   *
   * @return void
   */
  public static function piscoProductDemand($name, $quality, $sellIn)
  {
    if (($sellIn < 0) && ($name == ProductName::VIP)) {
      $quality = 0;
    } else if ($sellIn < 5) {
      $quality += 2;
    } else {
      $quality++;
    }
    return $quality;
  }
}
