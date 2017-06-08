<?php
/**
 * Email rendering handler
 */

/**
 * Modify the email content and adds the cart content
 *
 * it detects if HTML is allowed and pass it to the upcart_mail_render()
 * TODO: detect if HTML is allowed
 *
 * @param $mail_params
 * @param null $form
 *
 * @return mixed
 */
function upcart_wpcf7_format( $mail_params, $form = null ) {

	$email = $mail_params['body'];

	// check if the form has the cart hook
	if ( substr_count( $email, WPCART_WPCF7_MAIL_CONTENT ) == 0 ) {
		return $mail_params;
	}


	// TODO: check if HTML is allowed before send
	$html = upcart_mail_render( $form->get_properties()['mail']['use_html'] );

	// modify the email hook with the content
	$email = str_replace( WPCART_WPCF7_MAIL_CONTENT, $html, $email );

	$mail_params['body'] = $email;

	return $mail_params;
}

add_filter( 'wpcf7_mail_components', 'upcart_wpcf7_format', 50, 2 );


/**
 * Handle the email rendering
 *
 * it calls the correct filter to render the email
 *
 * @param bool $html - if renders HTML or Plain TEXT
 *
 * @return string - Email Content
 */
function upcart_mail_render( $html = true ) {
	/* @var $cart WPCart */
	global $cart;
	if ( $html ) {
		return apply_filters( 'cart_email_html', '', $cart );
	}

	$content = apply_filters( 'cart_email_text', '', $cart );

	// TODO: add option to choose empty cart after render
	$cart->clean();

	return $content;
}

require_once __DIR__ . '/wpcf7-email-render.php';