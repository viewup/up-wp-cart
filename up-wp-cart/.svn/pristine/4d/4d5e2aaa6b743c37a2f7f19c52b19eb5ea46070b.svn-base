<?php
/**
 * Handle the default email rendering
 *
 * WordPress's filters is very used here.
 * The reason is to allow plugin and themes to modify the default table easily
 * to modify, just add your filter and change the priority to inser before or after the area
 *
 * The default filters here starts with priority 20, and increments 5 if needs another
 *
 * each filter starts with a empty string, that will be modified by another filters.
 */


/**
 * Renders the email with HTML
 *
 * @param string $html
 * @param WPCart $cart
 *
 * @return string HTML
 */
function upcart_mail_html( $html, $cart ) {
	$header = apply_filters( 'cart_email_html_header', '', $cart );
	$body   = apply_filters( 'cart_email_html_body', '', $cart );
	$footer = apply_filters( 'cart_email_html_footer', '', $cart );

	return $html . $header . $body . $footer;
}

/**
 * Renders the email ith plain TEXT (\n allowed)
 *
 * @param string $html
 * @param WPCart $cart
 *
 * @return string plain TEXT
 */
function upcart_mail_text( $html, $cart ) {
	$header = apply_filters( 'cart_email_text_header', '', $cart );
	$body   = apply_filters( 'cart_email_text_body', '', $cart );
	$footer = apply_filters( 'cart_email_text_footer', '', $cart );

	return $html . $header . $body . $footer;
}

add_filter( 'cart_email_html', 'upcart_mail_html', 10, 2 );
add_filter( 'cart_email_text', 'upcart_mail_text', 10, 2 );

// HTML render
require_once __DIR__ . '/wpcf7-email-render-html.php';

// TEXT render
require_once __DIR__ . '/wpcf7-email-render-text.php';

