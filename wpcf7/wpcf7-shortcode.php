<?php
/**
 * handler for the field registration and shortcode
 */

// Creates field
add_action( 'wpcf7_init', 'upcart_wpcf7_add_shortcode' );

function upcart_wpcf7_add_shortcode() {
	wpcf7_add_shortcode( array( 'cart', 'cart*' ), 'upcart_wpcf7_shortcode_handler', array( 'name-attr' => true ) );
}

// Field Shortcode
function upcart_wpcf7_shortcode_handler( $tag ) {
	$tag = new WPCF7_FormTag( $tag );

	$validation_error = wpcf7_get_validation_error( $tag->name );


	$atts = array(
		'id'    => $tag->get_id_option(),
		'type'  => 'hidden',
		'name'  => $tag->name,
		'value' => WPCART_WPCF7_MAIL_CONTENT,
	);
	if ( $tag->is_required() ) {
		$atts['aria-required'] = 'true';
	}

	$input = sprintf(
		'<span class="wpcf7-form-control-wrap %1$s"><input %2$s /></span>',
		sanitize_html_class( $tag->name ),
		wpcf7_format_atts( $atts ) );

	return $input;

}