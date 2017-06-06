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
    public $amount = 1;
    public $price = 0;
    public $total = 0;

    public function __construct($ID, $price = 0, $amount = 1)
    {
        $this->ID = $ID;
        if (!is_numeric($price))
            $price = 0;
        $this->price = $price;
        $this->update($amount);
    }

    /**
     * Atualiza item de carrinho
     * @param int [$amount=null]
     * @return $this
     */
    public function update($amount = null)
    {
        if ($amount = null)
            $amount = $this->amount;
        $this->amount = $amount;
        $this->total = $this->price * $this->amount;
        return $this;
    }
}