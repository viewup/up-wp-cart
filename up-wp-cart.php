<?php
/*
Plugin Name: UP WP Cart
Plugin URI: https://github.com/viewup/up-wp-cart
Description: Simple Cart for WordPress
Author: ViewUp
Author URI: http://viewup.com.br/
Version: 0.1.0
Text Domain: upwpcart
License: MIT
*/

/**
 * Initialize GLOBALS
 */

define('UPWPCART_VERSION', '0.1.0');
define('UPWPCART_PLUGIN_DIR', __DIR__);
define('UPWPCART_CLASS_NAME', 'WPCart');
define('UPWPCART_SESSION_NAME', 'UP_WP_CART');

/**
 * Import class
 */
require_once UPWPCART_PLUGIN_DIR . "/WPCart.php";


if (class_exists(UPWPCART_CLASS_NAME)) {
    global $cart;
    $cart = $_SESSION[UPWPCART_SESSION_NAME];
    if (!$cart)
        $cart = new WPCart();

    $_SESSION[UPWPCART_SESSION_NAME] = $cart;
}

//var_dump($_SESSION[UPWPCART_SESSION_NAME]);die;