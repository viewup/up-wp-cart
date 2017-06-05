<?php

/**
 * Created by PhpStorm.
 * User: viewup
 * Date: 05/06/17
 * Time: 3:53 PM
 */

/**
 * Class WPCartItem
 */
class WPCartItem
{
    public $ID = 0;
    public $content = null;
    public $ammount = 1;
    public $price = 0;
    public $total = 0;

    public function __construct($ID, $price = 0, $ammount = 1)
    {
        $this->ID = $ID;
        if (!is_numeric($price))
            $price = 0;
        $this->price = $price;
        $this->update($ammount);
    }

    /**
     * Atualiza item de carrinho
     * @param int [$ammount=null]
     * @return $this
     */
    public function update($ammount = null)
    {
        if ($ammount = null)
            $ammount = $this->ammount;
        $this->ammount = $ammount;
        $this->total = $this->price * $this->ammount;
        return $this;
    }
}