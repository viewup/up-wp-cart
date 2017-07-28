<?php
/*
Plugin Name: UP WP Cart
Plugin URI: https://github.com/viewup/up-wp-cart
Description: Simple Cart for WordPress
Author: ViewUp
Author URI: http://viewup.com.br/
Version: 0.1.0
Text Domain: upcart
License: MIT
*/

/**
 * Initialize GLOBALS
 */

define( 'UPWPCART_VERSION', '0.1.0' );
define( 'UPWPCART_PLUGIN_DIR', __DIR__ );
define( 'UPWPCART_PLUGIN_URL', plugins_url(null, __FILE__) );
define( 'UPWPCART_CLASS_NAME', 'WPCart' );
define( 'UPWPCART_SESSION_NAME', 'UP_WP_CART' );
define( 'UPWPCART_COOKIE_NAME', 'upwpcart_init' );
define( 'UPWPCART_MAIN_ID', 'upwpcart_main' );
define( 'UPWPCART_JS_HANDLE', UPWPCART_MAIN_ID . '_js' );
define( 'UPWPCART_JS_VARNAME', UPWPCART_CLASS_NAME . 'Data' );

if ( ! defined( 'UPWPCART_API_DOMAIN' ) ) {
	define( 'UPWPCART_API_DOMAIN', 'up' );
}
if ( ! defined( 'UPWPCART_API_VERSION' ) ) {
	define( 'UPWPCART_API_VERSION', 'v1' );
}
if ( ! defined( 'UPWPCART_CONTENT_FILTER' ) ) {
	define( 'UPWPCART_CONTENT_FILTER', 'cart_content' );
}
if ( ! defined( 'UPWPCART_PRICE_FILTER' ) ) {
	define( 'UPWPCART_PRICE_FILTER', 'cart_price' );
}

define( 'UPWPCART_API_BASE', UPWPCART_API_DOMAIN . '/' . UPWPCART_API_VERSION );
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
 * Import Form Controller
 */
require_once UPWPCART_PLUGIN_DIR . '/form/form.php';
/**
 * Import Shortcode
 */
require_once UPWPCART_PLUGIN_DIR . '/shortcode/shortcode.php';
/**
 * Import global cart initializer
 */
require_once UPWPCART_PLUGIN_DIR . '/init.php';

/**
 * Import scripts and css of plugin
 */
require_once UPWPCART_PLUGIN_DIR . '/include/include.php';