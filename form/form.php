<?php
/**
 * Plugin form controller
 * Controls when POST and GET request are made to this plugin
 *
 * TODO: ADD query vars on redirect
 * @example add_filter('query_vars', 'add_queryvars');
 */


/**
 * Detects the POST request and calls the action
 */
function upwpcart_form_controller() {
	// item action
	if ( isset( $_POST['upwpcart-item'] ) ) {
		upwpcart_item_controller();
	}

	// redirect action
	if ( isset( $_POST['upwpcart-redirect'] ) ) {
		upwpcart_redirect_controller();
	}
}

add_action( 'get_header', 'upwpcart_form_controller' );

/**
 * Do the item actions
 */
function upwpcart_item_controller() {
	/* @var $cart WPCart */
	global $cart;
	$item   = (int) $_POST['upwpcart-item'];
	$action = $_POST['upwpcart-action'];
	$amount = (int) $_POST['upwpcart-amount'];

	if ( ! $cart || ! $item || ! $action ) {
		return;
	}

	if ( ! $amount ) {
		$amount = 1;
	}

	switch ( $action ) {
		case  'update':
			$cart->update( $item, $amount );
			break;
		case  'remove':
			$cart->remove( $item );
			break;
		case  'add':
		default:
			$action = 'add';
			$cart->add( $item, $amount );
	}
}

/**
 * Controls de redirection
 * TODO: uses the filter redirect to pass query strings and actions
 */
function upwpcart_redirect_controller() {

	$redirect     = $_POST['upwpcart-redirect'];
	$redirect_url = $redirect;

	// detect if is a page
	if ( is_numeric( $redirect ) ) {
		$redirect_url = get_permalink( $redirect_url );
	}


	// filter to change url or deny re redirect
	$redirect_url = apply_filters( 'upwpcart_redirect', $redirect_url );
	// makes the redirect
	if ( $redirect_url ) {
		wp_redirect( $redirect_url );
		exit;
	}
}

