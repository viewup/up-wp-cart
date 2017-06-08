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
 * Default Filters
 */
require_once UPWPCART_PLUGIN_DIR . "/default-filters.php";
/**
 * Import API Rest
 */
require_once UPWPCART_PLUGIN_DIR . '/WPCartAPI.php';
/**
 * Import admin page configs
 */
require_once UPWPCART_PLUGIN_DIR . '/admin/admin.php';
/**
 * Import WPCF7 Integration
 */
require_once UPWPCART_PLUGIN_DIR . '/wpcf7/wpcf7.php';


/**
 * Initialize global CART
 */
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
 * Initialize REST API
 */
function upcart_rest_api_init() {
	global $cartApi;
	global $cart;
	if ( ! $cartApi ) {
		$cartApi = new WPCartAPI( $cart );
	}
	$cartApi->register_routes();
}

add_action( 'rest_api_init', 'upcart_rest_api_init' );
add_action( 'init', 'upcart_init' );