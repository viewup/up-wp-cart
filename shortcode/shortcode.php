<?php
/**
 * Shortcodes handler
 *
 * TODO: use shortcode_atts. Not using because it removes props
 */

// CONTROLS
/**
 * Render the amount input [wpcart_amount]
 *
 * @param array $props
 * @param string $children
 * @param string $tag - the tag used
 *
 * @return string - rendered button
 */
function upwpcart_shortcode_input( $props = array(), $children = '', $tag = '' ) {
	global $post;
	/* @var $cart WPCart */
	global $cart;
	global $cart_item_id;
	if ( ! $cart_item_id ) {
		$cart_item_id = $post->ID;
	}

	$cart_item = $cart->getItem( $cart_item_id );

	$props = upwpcart_shortcode_atts( array(
		'class' => '',
		'type'  => 'number'
	), $props, $tag );


	$props['class'] = "upwp-cart-item-amount " . $props['class'];
	$props['name']  = 'upwpcart-amount';
	if ( $cart_item && ! isset( $props['force-value'] ) ) {
		$props['value'] = $cart_item->amount;
	}

	$attr = apply_filters( 'upcart_html_attr', $props, $tag );

	return "<input {$attr} data-upwp-cart-amount />";
}

/**
 * Render the action button shortcode EX: [wpcart_ACTION]
 *
 * Examples: [wpcart_add], [wpcart_update], [wpcart_remove]
 *
 * @param array $props
 * @param string $children
 * @param string $tag - the tag used
 *
 * @return string - rendered button
 */
function upwpcart_shortcode_button( $props = array(), $children = '', $tag = '' ) {

	$action       = str_replace( 'wpcart_', '', $tag );
	$defaultLabel = '';

	switch ( $action ) {
		case  'update':
			$defaultLabel = __( 'Update', UPWPCART_PLUGIN_DOMAIN );
			break;
		case  'remove':
			$defaultLabel = __( 'Remove', UPWPCART_PLUGIN_DOMAIN );
			break;
		case  'add':
		default:
			$action       = 'add';
			$defaultLabel = __( 'Add to Cart', UPWPCART_PLUGIN_DOMAIN );
	}

	$props = upwpcart_shortcode_atts( array(
		'class' => '',
		'label' => $children
	), $props, $tag );

	$props['class'] = "upwp-cart-item-{$action} " . $props['class'];
	$props['type']  = 'submit';
	$props['name']  = 'upwpcart-action';
	$props['value'] = $action;
	$label          = $props['label'] ? $props['label'] : $props['title'];
	if ( ! $label ) {
		$label = $defaultLabel;
	}
	unset( $props['label'] );

	$attr = apply_filters( 'upcart_html_attr', $props, $tag );

	return "<button {$attr} data-upwp-cart-{$action}>{$label}</button>";
}


/**
 * Render the item title [wpcart_title id="ID"]
 *
 * @param array $props
 * @param string $children
 * @param string $tag
 *
 * @return string
 */
function upwpcart_shortcode_item_title( $props = array(), $children = '', $tag = '' ) {
	/* @var $cart WPCart */
	global $cart;
	global $cart_item_id;
	global $post;

	$state  = upwpcart_shortcode_atts( array(
		'class' => '',
		'id'    => $cart_item_id
	), $props, $tag );
	$render = '';
	$item   = $cart->getItem( (int) $state['id'] );
	if ( ! $item ) {
		$item = new WPCartItem( $post->ID );
	}
	$title          = apply_filters( 'upcart_format_item_title', $children, $item );
	$state['class'] .= ' upwpcart-item-title';

	unset( $state['id'] );

	$attr = apply_filters( 'upcart_html_attr', $state, $tag );

	$render .= "<h3 {$attr} data-upwp-cart-item-title>";
	$render .= $title;
	$render .= "</h3>";

	return do_shortcode( $render );
}

/**
 * Render the item price [wpcart_price id="ID"]
 *
 * @param array $props
 * @param string $children
 * @param string $tag
 *
 * @return string
 */
function upwpcart_shortcode_item_price( $props = array(), $children = '', $tag = '' ) {
	/* @var $cart WPCart */
	global $post;
	global $cart;
	global $cart_item_id;
	$state  = upwpcart_shortcode_atts( array(
		'class' => '',
		'id'    => $cart_item_id
	), $props, $tag );
	$render = '';
	$item   = $cart->getItem( (int) $state['id'] );
	if ( ! $item ) {
		$item = new WPCartItem( $post->ID );
	}
	$price          = $item->price;
	$state['class'] .= ' upwpcart-item-price';

	unset( $state['id'] );

	$attr = apply_filters( 'upcart_html_attr', $state, $tag );

	$render .= "<span {$attr} data-upwp-cart-item-price=\"$price\">";
	$render .= apply_filters( 'upcart_format_price', $price, $item );
	$render .= "</span>";

	return do_shortcode( $render );
}

/**
 * Render the total price [wpcart_total]
 *
 * @param array $props
 * @param string $children
 * @param string $tag
 *
 * @return string
 */
function upwpcart_shortcode_total_price( $props = array(), $children = '', $tag = '' ) {
	/* @var $cart WPCart */
	global $cart;
	$state          = upwpcart_shortcode_atts( array(
		'class' => '',
	), $props, $tag );
	$render         = '';
	$price          = $cart->getTotal();
	$state['class'] .= ' upwpcart-total-price';

	$attr = apply_filters( 'upcart_html_attr', $state, $tag );

	$render .= "<span {$attr} data-upwp-cart-total-price=\"$price\">";
	$render .= trim( $children . ' ' . apply_filters( 'upcart_format_price', $price ) );
	$render .= "</span>";

	return do_shortcode( $render );
}

// DATA
/**
 * Renders the item shortcode [wpcart_item id="1"]
 *
 * @param array $props
 * @param string $children
 * @param string $tag
 *
 * @return string - Rendered form with children
 */
function upwpcart_shortcode_item( $props = array(), $children = '', $tag = '' ) {
	global $post;
	global $cart_item_id;
	global $wp;

	if ( ! $cart_item_id ) {
		$cart_item_id = $post->ID;
	}

	$props    = upwpcart_shortcode_atts( array(
		'id'    => $cart_item_id,
		'class' => ''
	), $props, $tag );
	$redirect = get_option( 'upcart_redirect' );

	if ( ! $redirect ) {
		// sets the current url as redirect if none
		$redirect = home_url( add_query_arg( array(), $wp->request ) );
	}

	$cart_item_id    = (int) $props['id'];
	$props['method'] = 'post';
	$props['action'] = '';
	$props['class']  = 'upwp-cart-item-form ' . $props['class'];
	$props['id']     = 'wpcart_item_' . $cart_item_id;
	$attr            = apply_filters( 'upcart_html_attr', $props, $tag );


	// customize controls
	if ( isset( $props['in-cart'] ) ) {
		$children .= "[wpcart_title][wpcart_price][wpcart_amount][wpcart_update][wpcart_remove]";
		unset( $props['in-cart'] );
	}
	if ( isset( $props['add'] ) ) {
		$children .= "[wpcart_add]";
		unset( $props['add'] );
	}
	if ( isset( $props['update'] ) || isset( $props['amount'] ) ) {
		$children .= "[wpcart_amount]";
		unset( $props['amount'] );
	}
	if ( isset( $props['update'] ) ) {
		$children .= "[wpcart_update]";
		unset( $props['update'] );
	}
	if ( isset( $props['remove'] ) ) {
		$children .= "[wpcart_remove]";
		unset( $props['remove'] );
	}

	// default controls
	if ( ! $children ) {
		$children = "[wpcart_price][wpcart_add]";
	}

	$content = "<form {$attr} data-upwp-cart-item=\"{$cart_item_id}\">";
	$content .= "<input type=\"hidden\" name=\"upwpcart-item\" value=\"{$cart_item_id}\" />";
	$content .= "<input type=\"hidden\" name=\"upwpcart-redirect\" value=\"{$redirect}\" />";
	$content .= do_shortcode( $children );
	$content .= "</form>";

	$cart_item_id = null;

	return $content;
}

/**
 * Render cart shortcode [wpcart_cart]
 *
 * Render a basic cart that can be modified by another plugins, themes and by the user
 *
 * @param array $props
 * @param string $children
 * @param string $tag
 *
 * @return string
 */
function upwpcart_shortcode_cart( $props = array(), $children = '', $tag = '' ) {
	global $cart;

	$state = upwpcart_shortcode_atts( array(
		'id'    => 'upwpcart-cart-' . $cart->getID(),
		'class' => ''
	), $props, $tag );

	$attr           = upwpcart_shortcode_atts( $state );
	$render         = '';
	$state['class'] = trim( $state['class'] . ' upwpcart-cart' );

	$render .= "<div {$attr} data-upwpcart-cart>";
	$render .= $children;
	$render .= '<ul>';

	$render .= '[wpcart_cart_items]';

	$render .= '</ul>';

	$render .= '[wpcart_total]';
	$render .= __( "Total", UPWPCART_PLUGIN_DOMAIN ) . ':';
	$render .= '[/wpcart_total]';
	$render .= '</div>';

	return do_shortcode( $render );
}

/**
 * Render cart items shortcode [wpcart_cart_items]
 *
 * this plugin get all the cart items and render correspondig cartitem shortcode
 *
 * @param array $props
 * @param string $children
 * @param string $tag
 *
 * @return string
 */
function upwpcart_shortcode_cart_items( $props = array(), $children = '', $tag = '' ) {
	/* @var $cart WPCart */
	global $cart;
	global $cart_item_id;

	$items  = $cart->get()->items;
	$render = '';

	foreach ( $items as $item ) {
		/* @var $item WPCartItem */
		$cart_item_id = $item->ID;
		$render       .= "[wpcart_cart_item id='{$cart_item_id}']";
	}

	return do_shortcode( $render );
}

/**
 * Render cart list item [wpcart_cart_item]
 *
 * Render a cart list item , that can be modified by plugins, themes and the user
 *
 * @param array $props
 * @param string $children
 * @param string $tag
 *
 * @return string
 */
function upwpcart_shortcode_cart_item( $props = array(), $children = '', $tag = '' ) {
	global $cart;
	global $cart_item_id;
	$state       = upwpcart_shortcode_atts( array(
		'id'    => $cart_item_id,
		'class' => ''
	), $props );
	$render      = '';
	$id          = $state['id'];
	$state['id'] = "upwpcart-cart-item-{$id}";

	$attr = apply_filters( 'upcart_html_attr', $state, $tag );

	$render .= "<li {$attr} data-upwp-cart-list-item>";
	$render .= "[wpcart_item id='{$id}' in-cart]";
	$render .= "</li>";

	return do_shortcode( $render );
}


// controls
add_shortcode( 'wpcart_amount', 'upwpcart_shortcode_input' );
add_shortcode( 'wpcart_add', 'upwpcart_shortcode_button' );
add_shortcode( 'wpcart_update', 'upwpcart_shortcode_button' );
add_shortcode( 'wpcart_remove', 'upwpcart_shortcode_button' );
add_shortcode( 'wpcart_title', 'upwpcart_shortcode_item_title' );
add_shortcode( 'wpcart_price', 'upwpcart_shortcode_item_price' );
add_shortcode( 'wpcart_total', 'upwpcart_shortcode_total_price' );

// data
add_shortcode( 'wpcart_item', 'upwpcart_shortcode_item' );
add_shortcode( 'wpcart_cart', 'upwpcart_shortcode_cart' );
add_shortcode( 'wpcart', 'upwpcart_shortcode_cart' );
add_shortcode( 'wpcart_cart_items', 'upwpcart_shortcode_cart_items' );
add_shortcode( 'wpcart_cart_item', 'upwpcart_shortcode_cart_item' );


// Helpers

/**
 * Modified version of shortcode_atts
 *
 * @param array $default
 * @param array $props
 * @param string $shortcode
 *
 * @return array
 */
function upwpcart_shortcode_atts( $default = array(), $props = array(), $shortcode = '' ) {
	if ( ! is_array( $default ) ) {
		$default = array();
	}
	if ( ! is_array( $props ) ) {
		$props = array();
	}

	foreach ( $props as $key => $prop ) {
		if ( is_numeric( $key ) ) {
			$props[ $prop ] = true;
		}
	}
	$state = array_merge( $default, $props );

	if ( $shortcode ) {
		$state = apply_filters( "shortcode_atts_{$shortcode}", $state, $default, $props, $shortcode );
	}

	return $state;
}