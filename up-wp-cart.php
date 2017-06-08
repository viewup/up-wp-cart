<?php
/*
Plugin Name: UP WP Cart
Plugin URI: https://github.com/viewup/up-wp-cart
Description: Simple Cart for WordPress
Author: ViewUp
Author URI: http://viewup.com.br/
Version: 0.1.0
Text Domain: up-wp-cart
License: MIT
*/

/**
 * Initialize GLOBALS
 */

define( 'UPWPCART_VERSION', '0.1.0' );
define( 'UPWPCART_PLUGIN_DIR', __DIR__ );
define( 'UPWPCART_CLASS_NAME', 'WPCart' );
define( 'UPWPCART_SESSION_NAME', 'UP_WP_CART' );

if ( ! defined( 'UP_API_BASE' ) ) {
	define( 'UP_API_BASE', 'up' );
}
if ( ! defined( 'UP_API_VERSION' ) ) {
	define( 'UP_API_VERSION', 'v1' );
}
if ( ! defined( 'UPWPCART_CONTENT_FILTER' ) ) {
	define( 'UPWPCART_CONTENT_FILTER', 'cart_content' );
}
if ( ! defined( 'UPWPCART_PRICE_FILTER' ) ) {
	define( 'UPWPCART_PRICE_FILTER', 'cart_price' );
}

define( 'UPWPCART_API_BASE', UP_API_BASE . '/' . UP_API_VERSION );
define( 'UPWPCART_API_ROUTE', 'cart' );


/**
 * Import class
 */
require_once UPWPCART_PLUGIN_DIR . "/WPCart.php";


/**
 * The default cart content filter
 *
 * it's modified version of defaults WP_API get_post
 *
 * @param int|WP_Post $id The post ID or object
 *
 * @return WP_Post|null The post object or null
 */
function upcart_default_cart_content_filter( $id ) {
	$post_obj = get_post( $id );
	$post     = apply_filters( 'rest_the_post', $post_obj, $id );

	return $post;
}

/**
 * The default cart price filter
 *
 * @param int $id the item ID
 * @param float|int $price The default price
 *
 * @return mixed
 */
function upcart_default_cart_price_filter( $id, $price = 0 ) {
	$price_meta = get_option( 'upcart_meta' );
	$newPrice   = get_post_meta( $id, $price_meta, true );

	// parse the value to float, fixing ','
	if ( is_string( $newPrice ) ) {
		$newPrice = floatval( str_replace( ',', '.', $newPrice ) );
	}

	// replaces invalid value
	if ( ! $newPrice || ! is_numeric( $newPrice ) ) {
		$newPrice = $price;
	}

	return $newPrice;
}

// sets the default filters
add_filter( UPWPCART_CONTENT_FILTER, 'upcart_default_cart_content_filter' );
add_filter( UPWPCART_PRICE_FILTER, 'upcart_default_cart_price_filter', 10, 2 );


add_action( 'init', 'upcart_init' );

function upcart_init() {
	if ( ! class_exists( UPWPCART_CLASS_NAME ) ) {
		return;
	}

	global $cart;

	/**
	 * Start session
	 *
	 * The cart must stay on the session to persists.
	 */
	if ( ! session_id() ) {
		session_start();
	}
	$cart = $_SESSION[ UPWPCART_SESSION_NAME ];
	if ( ! $cart ) {
		$cart = new WPCart();
	}

	$_SESSION[ UPWPCART_SESSION_NAME ] = $cart;

}

/**
 * Import API Rest
 */
require_once UPWPCART_PLUGIN_DIR . '/WPCartAPI.php';


/**
 * Initialize REST API
 */
add_action( 'rest_api_init', 'upcart_rest_api_init' );

function upcart_rest_api_init() {
	global $cartApi;
	global $cart;
	if ( ! $cartApi ) {
		$cartApi = new WPCartAPI( $cart );
	}
	$cartApi->register_routes();
}

/*
 * import admin page configs
 */
require_once UPWPCART_PLUGIN_DIR . '/admin/admin.php';
