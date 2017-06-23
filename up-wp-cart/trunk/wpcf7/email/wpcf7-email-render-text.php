<?php
/**
 * TEXT email render
 */

// <HEADER>
function upcart_mail_text_header_content( $html ) {

	return $html . upcart_mail_text_divider();

}

add_filter( 'cart_email_text_header', 'upcart_mail_text_header_content', 20 );

// </HEADER>

// <BODY>
function upcart_mail_text_body_items( $html, $cart ) {
	foreach ( $cart->get()->items as $item ) {
		$html .= apply_filters( 'cart_email_text_item', '', $item, $cart );
	}

	return $html;

}

add_filter( 'cart_email_text_body', 'upcart_mail_text_body_items', 20, 2 );

// </BODY>

// <FOOTER>
/**
 * ADD total price
 *
 * @param string $html
 * @param WPCart $cart
 *
 * @return string
 */
function upcart_mail_text_footer_content( $html, $cart ) {
	$html .= "Total" . ': ';
	$html .= apply_filters( 'upcart_format_price', $cart->get()->total );
	$html .= "\n";

	return $html;
}

function upcart_mail_text_footer_divider( $html ) {
	return upcart_mail_text_divider( $html, false );
}


add_filter( 'cart_email_text_footer', 'upcart_mail_text_footer_content', 20, 2 );
add_filter( 'cart_email_text_footer', 'upcart_mail_text_footer_divider', 25 );

// </FOOTER>


// <ITEM>
function upcart_mail_text_item_title( $html, $item ) {
	$html .= __( "Product", UPWPCART_PLUGIN_DOMAIN ) . ': ';
	$html .= apply_filters( 'cart_email_item_title', '', $item );
	$html .= "\n";

	return $html;
}

function upcart_mail_text_item_amount( $html, $item ) {
	$html .= __( "Quantity", UPWPCART_PLUGIN_DOMAIN ) . ': ';
	$html .= $item->amount;
	$html .= "\n";

	return $html;
}

function upcart_mail_text_item_value( $html, $item ) {
	$html .= __( "Price", UPWPCART_PLUGIN_DOMAIN ) . ': ';
	$html .= apply_filters( 'upcart_format_price', $item->price, $item );
	$html .= "\n";

	return $html;
}

function upcart_mail_text_item_divider( $html ) {
	return upcart_mail_text_divider( $html, false );
}

add_filter( 'cart_email_text_item', 'upcart_mail_text_item_title', 20, 2 );
add_filter( 'cart_email_text_item', 'upcart_mail_text_item_amount', 25, 2 );
add_filter( 'cart_email_text_item', 'upcart_mail_text_item_value', 30, 2 );
add_filter( 'cart_email_text_item', 'upcart_mail_text_item_divider', 35 );
// </ITEM>


// helpers
// divider
function upcart_mail_text_divider( $html = '', $before = true, $after = true ) {
	if ( $before ) {
		$html .= "\n";
	}
	$html .= "-----------------";
	if ( $after ) {
		$html .= "\n";
	}

	return $html;

}