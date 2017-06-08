<?php
/**
 * The default filters
 */


/**
 * The default cart content filter
 *
 * it returns the post object on the default format
 *
 * @param int|WP_Post|null $id The post ID or object
 *
 * @return WP_Post|null The post object or null
 */
function upcart_default_cart_content_filter( $id ) {
	$post = get_post( $id );

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

function upcart_default_format_price( $price = 0 ) {
	// get currency option
	$currency = get_option( 'upcart_currency' );
	// replace . for ,
	$price = str_replace( '.', ',', (string) $price );
	// add currency
	$price = $currency . ' ' . $price;

	return $price;
}

// sets the default filters
add_filter( UPWPCART_CONTENT_FILTER, 'upcart_default_cart_content_filter' );
add_filter( UPWPCART_PRICE_FILTER, 'upcart_default_cart_price_filter', 10, 2 );
add_filter( 'upcart_format_price', 'upcart_default_format_price', 10, 2 );