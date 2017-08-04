<?php

function upwpcart_enqueue_scripts() {

	// Script Register
	wp_register_script(
		'up-wp-cart',
		plugins_url( UPWPCART_PLUGIN_DIR, '/js/up-wp-cart.js' ),
		array( 'jquery' ),
		'1.0.0',
		true
	);

	// ADD api url
	wp_localize_script( 'up-wp-cart', 'upwpCartArgs', [
		'api' => get_rest_url( null, '/' . UPWPCART_API_BASE . '/' . UPWPCART_API_ROUTE . '/' ),
	] );

	// ADD script
	wp_enqueue_script( 'up-wp-cart' );

}

add_action( 'wp_enqueue_scripts', 'upwpcart_enqueue_scripts', 5 );