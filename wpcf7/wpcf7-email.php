<?php
/**
 * Email rendering handler
 */

add_filter( 'wpcf7_mail_components', 'upcart_wpcf7_format', 50, 2 );

function upcart_wpcf7_format( $mail_params, $form = null ) {
	var_dump( $form );
	die;

	$html = upcart_mail_render();

	return $mail_params;
}

function upcart_mail_render( $html = true ) {
	global $cart;
	if ( $html ) {
		return apply_filters( 'cart_email_html', $cart );
	}

	return apply_filters( 'cart_email_text', $cart );

}

/**
 * Renders the email with HTML
 *
 * @param WPCart $cart
 *
 * @return string
 */
function upcart_mail_html( $cart ) {
	$header = apply_filters( 'cart_email_html_header', '', $cart );
	$body   = apply_filters( 'cart_email_html_body', '', $cart );
	$footer = apply_filters( 'cart_email_html_footer', '', $cart );

	return $header . $body . $footer;
}

add_filter( 'cart_email_html', 'upcart_mail_html' );

/**
 * * Renders the email without HTML
 *
 * @param WPCart $cart
 *
 * @return string
 */
function upcart_mail_text( $cart ) {
	$header = apply_filters( 'cart_email_text_header', '', $cart );
	$body   = apply_filters( 'cart_email_text_body', '', $cart );
	$footer = apply_filters( 'cart_email_text_footer', '', $cart );

	return $header . $body . $footer;
}

add_filter( 'cart_email_text', 'upcart_mail_text' );
// FIXME MODELO
function upcart_mail_html_MODEL( $html, $cart ) {
	$html .= '';

	return $html;
}

// FIXME !MODELO

function upcart_mail_html_header_table( $html ) {
	$html .= '<table>';

	return $html;
}

function upcart_mail_html_header_thead( $html, $cart ) {
	$html .= '<thead><tr>';
	$html .= apply_filters( 'cart_email_html_thead', '', $cart );
	$html .= '</tr></thead>';

	return $html;
}


function upcart_mail_html_body_list( $html, $cart ) {
	$html .= '<tbody>';
	foreach ( $cart->items as $item ) {
		$html .= '<tr>';
		$html .= apply_filters( 'cart_email_html_item_row', '', $item, $cart );
		$html .= '</tr>';
	}

	$html .= '</tbody>';

	return $html;
}

function upcart_mail_html_footer_tfoot( $html, $cart ) {
	$html .= '<tfoot><tr>';

	$html .= apply_filters( 'cart_email_html_tfoot', '', $cart );

	$html .= '</tr></tfoot>';

	return $html;
}

function upcart_mail_html_footer_table( $html ) {
	$html .= '</table>';

	return $html;
}

add_filter( 'cart_email_html_header', 'upcart_mail_html_header_table', 20 );
add_filter( 'cart_email_html_header', 'upcart_mail_html_header_thead', 25, 2 );

add_filter( 'cart_email_html_body', 'upcart_mail_html_body_list', 20, 2 );

add_filter( 'cart_email_html_footer', 'upcart_mail_html_footer_tfoot', 20, 2 );
add_filter( 'cart_email_html_footer', 'upcart_mail_html_footer_table', 25 );

// THEAD
function upcart_mail_html_thead_title( $html ) {
	$html .= '<th>';
	$html .= __( "Product" );
	$html .= '</th>';

	return $html;
}

function upcart_mail_html_thead_amount( $html ) {
	$html .= '<th>';
	$html .= __( "Quantity" );
	$html .= '</th>';

	return $html;
}

function upcart_mail_html_thead_price( $html ) {
	$html .= '<th>';
	$html .= __( "Price" );
	$html .= '</th>';

	return $html;
}

add_filter( 'cart_email_html_thead', 'upcart_mail_html_thead_title', 20 );
add_filter( 'cart_email_html_thead', 'upcart_mail_html_thead_amount', 25 );
add_filter( 'cart_email_html_thead', 'upcart_mail_html_thead_price', 30 );
// /THEAD

// ROW


function upcart_mail_html_row_item_title( $html, $item ) {
	$html .= '<td>';
	$html .= $item->content->title;
	$html .= '</td>';

	return $html;
}

add_filter( 'cart_email_html_item_row', 'upcart_mail_html_row_item_title', 20, 2 );

// /ROW