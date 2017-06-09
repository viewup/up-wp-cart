<?php
/**
 * Handles the global $cart init, SESSIONS and COOKIES
 */

/**
 * Initialize global CART and SESSION
 */
function upcart_init() {
	if ( ! class_exists( UPWPCART_CLASS_NAME ) ) {
		return;
	}

	global $cart;

	/**
	 * Start session
	 *
	 * The cart must stay on the session to persists.
	 */
	if ( isset( $_COOKIE[ UPWPCART_COOKIE_NAME ] ) ) {
		upwpcart_start_session();
		$cart = $_SESSION[ UPWPCART_SESSION_NAME ];
		if ( ! $cart ) {
			$cart = upwpcart_new_main_cart();

			$_SESSION[ UPWPCART_SESSION_NAME ] = $cart;
		}
	} else {
		$cart = upwpcart_new_main_cart();
	}
}

/**
 * Initialize REST API
 */
function upcart_rest_api_init() {
	global $cartApi;
	global $cart;
	if ( ! $cartApi ) {
		$cartApi = new WPCartAPI( $cart );
	}
	$cartApi->register_routes();
//	var_dump($cartApi);die;
}

/**
 * Detect the main cart update and updates COOKIE
 *
 * @param WPCart $cart
 */
function upcart_cookie_update( $cart ) {
	// checks if is the main cart instance
	if ( $cart->getID() != UPWPCART_MAIN_ID ) {
		return;
	}

	// checks if the cart is empty or has data
	if ( $cart->isEmpty() ) {
		// unset cookie if empty
		unset( $_COOKIE[ UPWPCART_COOKIE_NAME ] );
		setcookie( UPWPCART_COOKIE_NAME, null, - 3600 );

	} else {
		setcookie( UPWPCART_COOKIE_NAME );
	}
}


add_action( 'rest_api_init', 'upcart_rest_api_init' );
add_action( 'init', 'upcart_init' );
add_action( 'upwpcart_update', 'upcart_cookie_update' );


// HELPERS
/**
 * Initialize session
 * @return bool if is initialized or was already initialized
 */
function upwpcart_start_session() {
	if ( ! session_id() ) {
		session_start();

		return true;
	}

	return false;
}

/**
 * get a new main instance of cart (with ID and configs)
 * @return WPCart
 */
function upwpcart_new_main_cart() {
	return new WPCart( array(
		'ID' => UPWPCART_MAIN_ID
	) );
}