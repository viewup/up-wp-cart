<?php
/**
 * Register the settings sections
 */


function upcart_settings_sections() {

	// register a new section in the "reading" page
	add_settings_section(
		'upcart_settings_section',
		__( 'General Settings' ),
		'upcart_settings_section_cb',
		UPWPCART_SETTINGS_PAGE
	);

}

add_action( 'admin_init', 'upcart_settings_sections' );

/**
 * callback functions
 */

// section content cb
function upcart_settings_section_cb() {
	echo '<p>' . __( 'TIP: install Advanced Custom Fields to configure the pricing', UPWPCART_PLUGIN_DOMAIN ) . '</p>';
}
