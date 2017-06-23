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
 * The default item title filter
 *
 * @param string $html
 * @param WPCartItem|null $item
 *
 * @return string
 */
function upcart_default_cart_item_title_filter( $html = '', $item = null ) {
	if ( ! $item ) {
		return $html;
	}

	return trim( $html . ' ' . $item->content->post_title );
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
	$price_meta = get_option( 'upcart_meta' , 'price');
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

/**
 * The default price filter
 *
 * @param float|int $price
 *
 * @return string
 */
function upcart_default_format_price( $price = 0, $item = null ) {
	// get currency option
	$currency = get_option( 'upcart_currency');
	// format number
	$price = number_format( (float) $price, 2, ',', '.' );
	// add currency
	$price = $currency . ' ' . $price;

	return $price;
}

/**
 * The default HTML attributes formatter
 *
 * @param array $props
 *
 * @return string
 */
function upcart_default_html_attr_formatter( $props = array() ) {
	// returns if already formatted or invalid
	if ( ! is_array( $props ) ) {
		return $props;
	}
	$attr = '';
	foreach ( $props as $name => $value ) {
		$attr .= ' ' . $name . '="' . esc_attr( $value ) . '"';
	}

	// remove whitespace
	return trim( $attr );
}

/**
 * Renders the auto display on post excerpt
 *
 * @param string $content
 *
 * @return string
 */
function upcart_default_auto_display_excerpt( $content = '' ) {

	global $post;
	$autoDisplay     = (bool) get_option( 'upcart_auto_display' );
	$autoDisplayPost = get_option( 'upcart_post_type' );

	if ( $autoDisplay && $post->post_type == $autoDisplayPost ) {
		$content .= do_shortcode( '[wpcart_item]' );
	}

	return $content;

}

/**
 * Renders the auto display on post content
 *
 * @param string $content
 *
 * @return string
 */
function upcart_default_auto_display_content( $content = '' ) {
	if ( is_single() || ! is_search() ) {
		$content = upcart_default_auto_display_excerpt( $content );
	}

	return $content;
}

// sets the default filters
add_filter( UPWPCART_CONTENT_FILTER, 'upcart_default_cart_content_filter' );
add_filter( UPWPCART_PRICE_FILTER, 'upcart_default_cart_price_filter', 10, 2 );
add_filter( 'upcart_html_attr', 'upcart_default_html_attr_formatter' );
add_filter( 'upcart_format_price', 'upcart_default_format_price', 10, 2 );
add_filter( 'upcart_format_item_title', 'upcart_default_cart_item_title_filter', 10, 2 );

add_filter( 'the_content', 'upcart_default_auto_display_content', 20 );
add_filter( 'the_excerpt', 'upcart_default_auto_display_excerpt', 20 );

