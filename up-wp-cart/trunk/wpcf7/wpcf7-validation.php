<?php
/**
 * Handle the field validation
 */

add_filter( 'wpcf7_validate_cart*', 'upcart_wpcf7_shortcode_validation', 20, 2 );

/**
 * Validates the required cart field, returns invalid if empty cart
 *
 * @param $result
 * @param $tag
 *
 * @return mixed
 */
function upcart_wpcf7_shortcode_validation( $result, $tag ) {
	/* @var $cart WPCart */
	global $cart;
	$tag = new WPCF7_FormTag( $tag );
	if ( $cart && $cart->isEmpty() ) {
		$result->invalidate( $tag, wpcf7_get_message( 'empty_cart' ) );
	}

	return $result;
}