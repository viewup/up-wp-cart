<?php

/**
 * Cart Class
 *
 * User: viewup
 * Date: 05/06/17
 * Time: 3:43 PM
 */

define('DEFAULT_PRICE_META', 'price');
define('DEFAULT_POST_TYPE', 'post');

require_once __DIR__ . '/WPCartItem.php';

/**
 * Class WPCart
 */
class WPCart
{
    // Array of items
    private $items = array();
    // Total price
    private $total = 0;

    private $price_meta = DEFAULT_PRICE_META;
    private $post_type = DEFAULT_POST_TYPE;

    function __construct($options = array())
    {
        if ($options['price_meta'])
            $this->price_meta = $options['price_meta'];
        if ($options['post_type'])
            $this->post_type = $options['post_type'];
    }

    public function get()
    {
        return (object)array(
            'items' => $this->items,
            'total' => $this->total,
        );
    }

    public function add($id, $amount = 1)
    {
        // check if item is already on the array
        $item = $this->getItem($id);
        if ($item)
            return $this->update($item->ID, $amount);

        // gets the product price
        $price = floatval(get_post_meta($id, $this->price_meta));

        // Create new item if new
        $item = new WPCartItem($id, $price, $amount);

        // Add item to the items array
        array_push($this->items, $item);

        return $this->updateCart();
    }

    public function remove($id)
    {
        // Gets the item position
        $itemPos = $this->getItemPos($id);

        // removes the item from the array, if exists
        if ($itemPos >= 0)
            array_splice($this->items, $itemPos, $itemPos);

        return $this->updateCart();
    }

    public function update($id, $amount = 0)
    {
        // get the item by ID
        $item = $this->getItem($id);

        // if exists, update the item total
        if ($item)
            $item->update($amount);

        return $this->updateCart();
    }

    public function clean()
    {
        // clear the items array
        $this->items = array();

        return $this->updateCart();

    }

    /**
     * Get item by ID
     * @param $id
     * @return WPCartItem|null
     */
    public function getItem($id)
    {
        // get the item by position
        $item = $this->items[$this->getItemPos($id)];

        // if no item, return NULL
        if (!$item) $item = null;

        return $item;
    }

    /**
     * Get item position by ID
     * @param $id
     * @return int
     */
    private function getItemPos($id)
    {
        // try to find the item with the mathing ID
        foreach ($this->items as $pos => $item) {
            /* @var $item WPCartItem */
            if ($item->ID == $id)
                return $pos;
        }

        // if not found, returns '-1'
        return -1;
    }

    private function updateCart()
    {
        return $this->calculateTotal();
    }

    private function calculateTotal()
    {
        // starts with 0
        $total = 0;

        foreach ($this->items as $item) {
            /* @var $item WPCartItem */
            // increments with the item total
            $total += $item->total;
        }

        // Replace the total with new value
        $this->total = $total;

        return $this;
    }
}
