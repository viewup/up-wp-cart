<?php
/**
 * Register messages
 */

add_filter( 'wpcf7_messages', 'upcart_wpcf7_messages', 50 );
function upcart_wpcf7_messages( $messages ) {
	return array_merge( $messages, array(
		'empty_cart' => array(
			'description' => __( "Empty cart" ),
			'default'     => __( "The cart is empty" )
		),
	) );
}