<?php
/**
 * Shortcodes handler
 *
 * TODO: use shortcode_atts. Not using because it removes props
 */

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
	if ( ! $cart_item_id ) {
		$cart_item_id = $post->ID;
	}


	$props = upwpcart_shortcode_atts( array(
		'id'    => $cart_item_id,
		'class' => ''
	), $props, $tag );

	$cart_item_id    = (int) $props['id'];
	$props['method'] = 'post';
	$props['action'] = '';
	$props['class']  = 'upwp-cart-item-form ' . $props['class'];
	$props['id']     = 'wpcart_item_' . $cart_item_id;
	$attr            = apply_filters( 'upcart_html_attr', $props, $tag );

	if ( ! $children ) {
		$children = "[wpcart_amount][wpcart_add]";
	}

	$content = "<form {$attr} data-upwp-cart-item=\"{$cart_item_id}\">";
	$content .= "<input type=\"hidden\" name=\"upwpcart-item\" value=\"{$cart_item_id}\" />";
	$content .= do_shortcode( $children );
	$content .= "</form>";

	$cart_item_id = null;

	return $content;
}


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

add_shortcode( 'wpcart_item', 'upwpcart_shortcode_item' );
add_shortcode( 'wpcart_amount', 'upwpcart_shortcode_input' );
add_shortcode( 'wpcart_add', 'upwpcart_shortcode_button' );
add_shortcode( 'wpcart_update', 'upwpcart_shortcode_button' );
add_shortcode( 'wpcart_remove', 'upwpcart_shortcode_button' );


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
	$state = array_merge( $default, $props );

	if ( $shortcode ) {
		$state = apply_filters( "shortcode_atts_{$shortcode}", $state, $default, $props, $shortcode );
	}

	return $state;
}