<?php

/**
 * Cart Class
 *
 * User: viewup
 * Date: 05/06/17
 * Time: 3:43 PM
 */

// Require item
require_once __DIR__ . '/WPCartItem.php';

/**
 * Class WPCart
 */
class WPCart {
	// Array of items
	private $items = array();

	// Total price
	private $total = 0;

	/**
	 * WPCart constructor.
	 *
	 * @param array $options cart options
	 */
	function __construct( $options = array() ) {
		// TODO: import old JSON cart
	}

	/**
	 * @return object cart object
	 */
	public function get() {
		return (object) array(
			'items' => $this->items,
			'total' => $this->total,
		);
	}

	/**
	 * ADD item
	 * @param int $id
	 * @param int $amount
	 *
	 * @return WPCart
	 */
	public function add( $id, $amount = 1 ) {
		// check if item is already on the array
		$item = $this->getItem( $id );
		if ( $item ) {
			return $this->update( $item->ID, $amount + $item->amount );
		}

		// Create new item if new
		$item = new WPCartItem( $id, $amount );

		// Add item to the items array
		array_push( $this->items, $item );

		return $this->updateCart();
	}

	/**
	 * REMOVE item
	 * @param int $id
	 *
	 * @return WPCart
	 */
	public function remove( $id ) {
		// Gets the item position
		$itemPos = $this->getItemPos( $id );

		// removes the item from the array, if exists
		if ( $itemPos >= 0 ) {
			array_splice( $this->items, $itemPos, 1 );
		}

		return $this->updateCart();
	}

	/**
	 * UPDATE item
	 * @param int $id
	 * @param int $amount
	 *
	 * @return WPCart
	 */
	public function update( $id, $amount = 0 ) {
		// get the item by ID
		$item = $this->getItem( $id );

		// if exists, update the item total
		if ( $item ) {
			$item->update( $amount );
		}
		if ( $item && ! $item->amount ) {
			return $this->remove( $id );
		}

		return $this->updateCart();
	}

	/**
	 * CLEAN cart
	 * @return WPCart
	 */
	public function clean() {
		// clear the items array
		$this->items = array();

		return $this->updateCart();

	}

	/**
	 * Get item by ID
	 *
	 * @param $id
	 *
	 * @return WPCartItem|null
	 */
	public function getItem( $id ) {
		// get the item by position
		$item = $this->items[ $this->getItemPos( $id ) ];

		// if no item, return NULL
		if ( ! $item ) {
			$item = null;
		}

		return $item;
	}

	/**
	 * Get item position by ID
	 *
	 * @param $id
	 *
	 * @return int
	 */
	private function getItemPos( $id ) {
		// try to find the item with the mathing ID
		foreach ( $this->items as $pos => $item ) {
			/* @var $item WPCartItem */
			if ( $item->ID == $id ) {
				return $pos;
			}
		}

		// if not found, returns '-1'
		return - 1;
	}

	/**
	 * UPDATE cart info
	 * @return WPCart
	 */
	private function updateCart() {
		return $this->calculateTotal();
	}

	/**
	 * UPDATE cart total
	 * @return $this
	 */
	private function calculateTotal() {
		// starts with 0
		$total = 0;

		foreach ( $this->items as $item ) {
			/* @var $item WPCartItem */
			// increments with the item total
			$total += $item->total;
		}

		// Replace the total with new value
		$this->total = $total;

		return $this;
	}
}
