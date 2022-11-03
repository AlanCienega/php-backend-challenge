<?php

namespace App;

use App\Naming\ProductName;
use App\Products\Altocusco;
use App\Products\Normal;
use App\Products\Pisco;
use App\Products\Vip;

class VillaPeruana
{
    public $name;
    public $quality;
    public $sellIn;

    /**
     * lo de siempre, se encarga de que pasemos estos datos a fuerza
     *
     * @param  mixed $name
     * @param  mixed $quality
     * @param  mixed $sellIn
     * @return void
     */
    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    /**
     * clase of
     * para pasarle los argumentos y poderlos usar libremente
     *
     * @param  mixed $name
     * @param  mixed $quality
     * @param  mixed $sellIn
     * @return void
     */
    public static function of($name, $quality, $sellIn)
    {
        return new static($name, $quality, $sellIn);
    }

    /**
     * esta funcion es la encargada de simular el paso de un dia en Villa Peruana
     * 
     * Al final de cada día, los valores se disminuyen en ambos valores.
     * Cuando la fecha de venta ya paso, es decir es menor a -1, los productos se degradan
     * dos veces mas rapido, es decir en 2.
     * Nos debemos asegurar que el quality nunca sea negativo. (lo dejare en 0)
     * Los productos "Pisco Peruano", en realidad, incrementan en Quality mientras más viejos están
     * El Quality de un producto nunca es mayor a 50 (aunque se trate del pisco peruano)
     * Los productos "Tumi", siendo un producto legendario, nunca debe ser vendido o bajaría su Quality.
     * Los "Tickets VIP", así como "Pisco Peruano", incrementan su Quality conforme su SellIn se acerca a 0,
     * el Quality incrementa en 2 cuando faltan 10 días o menos y en 3 cuando faltan 5 días o menos,
     * pero el Quality disminuye a 0 después del concierto.
     * 
     * Los productos de "Café" se degradan en Quality el doble que los productos normales, eso quiere decir que
     * vamos a degradarlo en 2 por cada dia que pase si es antes de su fecha de venta, y e 4 despues
     * ya que el producto normal se degrada en 2.
     * 
     *  un producto nunca puede incrementar su Quality mayor a 50, sin embargo "Tumi" es un producto legendario 
     * y como tal su Quality es 80 y nunca cambia.
     *
     * @return void
     */
    public function tick()
    {
        switch ($this->name) {
            case ProductName::NORMAL;
                $normal = new Normal($this->name, $this->quality, $this->sellIn);
                $normal->deal();

                $this->quality = $normal->quality;
                $this->sellIn = $normal->sellIn;
                break;
            case ProductName::PISCO;
                $pisco = new Pisco($this->name, $this->quality, $this->sellIn);
                $pisco->deal();

                $this->quality = $pisco->quality;
                $this->sellIn = $pisco->sellIn;
                break;
            case ProductName::TUMI;
                break;
            case ProductName::VIP;
                $vip = new Vip($this->name, $this->quality, $this->sellIn);
                $vip->deal();

                $this->quality = $vip->quality;
                $this->sellIn = $vip->sellIn;
                break;
            case ProductName::ALTOCUSCO;
                $normal = new Altocusco($this->name, $this->quality, $this->sellIn);
                $normal->deal();

                $this->quality = $normal->quality;
                $this->sellIn = $normal->sellIn;
                break;
        }
    }
}
