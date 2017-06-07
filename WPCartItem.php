<?php

/**
 * Cart Item class
 */

// fallback to cart content filter (eg: the plugin inserted on theme directly)

if ( ! defined( 'CART_CONTENT_FILTER' ) ) {
	define( 'CART_CONTENT_FILTER', 'cart_content' );
}
if ( ! defined( 'CART_PRICE_FILTER' ) ) {
	define( 'CART_PRICE_FILTER', 'cart_price' );
}


/**
 * Class WPCartItem
 */
class WPCartItem {
	public $ID = 0;
	public $amount = 1;
	public $price = 0;
	public $total = 0;
	public $content = null;

	/**
	 * WPCartItem constructor.
	 *
	 * @param int $ID
	 * @param int [$price]
	 * @param int [$amount]
	 */
	public function __construct( $ID, $amount = 1, $price = 0 ) {
		$this->ID = $ID;
		if ( ! is_numeric( $price ) ) {
			$price = 0;
		}
		$this->content = apply_filters( CART_CONTENT_FILTER, $this->ID, $price );
		$this->price   = apply_filters( CART_PRICE_FILTER, $this->ID, $price, $this->content );
		$this->update( $amount );
	}

	/**
	 * Update cart's item
	 *
	 * @param int [$amount=null]
	 *
	 * @return $this
	 */
	public function update( $amount = null ) {
		// if invalid amount
		if ( ! is_numeric( $amount ) ) {
			$amount = $this->amount;
		}

		// if lower than 0
		if ( $amount < 0 ) {
			$amount = 0;
		}

		$this->amount = $amount;
		$this->total  = $this->price * $this->amount;

		return $this;
	}
}