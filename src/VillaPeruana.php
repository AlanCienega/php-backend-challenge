<?php

namespace App;

class VillaPeruana
{
    public $name;
    public $quality;
    public $sellIn;

    public const NORMAL = "normal";
    public const PISCO = "Pisco Peruano";
    public const TUMI =  "Tumi de Oro Moche";
    public const VIP = "Ticket VIP al concierto de Pick Floid";
    public const ALTOCUSCO = "Café Altocusco";

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
     * esta funcion es la encargada de simular el paso de un dia en Vila Peruana
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
            case VillaPeruana::NORMAL;
                $this->degradation();
                $this->setQuality();
                $this->sellIn--;
                break;
            case VillaPeruana::PISCO;
                $this->piscoProductDemand();
                $this->setQuality();
                $this->sellIn--;
                break;
            case VillaPeruana::TUMI;
                break;
            case VillaPeruana::VIP;
                $this->productDemand();
                $this->setQuality();
                $this->sellIn--;
                break;
            case VillaPeruana::ALTOCUSCO;
                $this->degradation();
                $this->setQuality();
                $this->sellIn--;
                break;
        }
    }

    /**
     * esta funcion se encarga de definir la degradacion del producto, la mayoria tienen un valor normal
     * pero el producto café altocusco es bastante delicado, por lo que se degrada 2 veces mas rápido
     *
     * @return void
     */
    public function degradation()
    {
        if ($this->name == VillaPeruana::ALTOCUSCO) {
            if ($this->sellIn <= 0) {
                $this->quality -= 4;
            } else {
                $this->quality -= 2;
            }
        } else {
            if ($this->sellIn <= 0) {
                $this->quality -= 2;
            } else {
                $this->quality--;
            }
        }
    }

    /**
     * definimos la calidad del producto vip que vale mas cada que pasan los dias antes de su fecha de venta
     * despues de eso el producto ya no vale nada, es decir su calidad baja a 0
     *
     * @return void
     */
    public function productDemand()
    {
        if ($this->sellIn <= 0) {
            $this->quality = 0;
        } else if ($this->sellIn <= 5) {
            $this->quality += 3;
        } else if ($this->sellIn <= 10) {
            $this->quality += 2;
        } else {
            $this->quality++;
        }
    }
    /**
     * se encarga de definir la calidad del producto llamado pisco
     *
     * @return void
     */
    public function piscoProductDemand()
    {
        if (($this->sellIn < 0) && ($this->name == VillaPeruana::VIP)) {
            $this->quality = 0;
        } else if ($this->sellIn < 5) {
            $this->quality += 2;
        } else {
            $this->quality++;
        }
    }

    /**
     * esta funcion se encarga de definir la calidad del producto despues de haberse hecho todas las operaciones
     * para cada caso, para la mayoria caen en el mismo valor, pero para productos pisco y vip, su maxima calidad
     * sera de 50.
     *
     * @return void
     */
    function setQuality()
    {
        if (($this->name == VillaPeruana::PISCO || $this->name == VillaPeruana::VIP) && $this->quality > 50) {
            $this->quality = 50;
        }
        if ($this->quality < 0) {
            $this->quality = 0;
        }
    }
}
