<?php
/**
 * Add settings page and menu
 */

/**
 * ADD menu
 */
function upcart_settings_page() {
	// add top level menu page
	add_menu_page(
		'UP Cart',
		'UP Cart',
		'manage_options',
		UPWPCART_SETTINGS_PAGE,
		'upcart_options_page_html',
		'dashicons-cart'
	);
}

add_action( 'admin_menu', 'upcart_settings_page' );

function upcart_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	upcart_show_messages();
	?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
			<?php
			// render security fields
			settings_fields( UPWPCART_PLUGIN_DOMAIN );
			// render sections for this page
			do_settings_sections( UPWPCART_SETTINGS_PAGE );
			// render submit button
			submit_button();
			?>
        </form>
    </div>
	<?php
}

function upcart_show_messages() {
	// success messages
	if ( isset( $_GET['settings-updated'] ) ) {
		add_settings_error( 'upcart_messages', 'upcart_message', __( 'Settings saved.' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'upcart_messages' );
}