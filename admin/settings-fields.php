<?php
/**
 * Register the settings fields
 */


function upcart_settings_fields() {

	// Register setting fields

	// register the meta field
	add_settings_field(
		'upcart_field_meta',
		__( 'Price Meta', UPWPCART_PLUGIN_DOMAIN ),
		'upcart_field_meta_cb',
		UPWPCART_SETTINGS_PAGE,
		'upcart_settings_section'
	);

	// register the post_type field
	add_settings_field(
		'upcart_field_post_type',
		"Post - " . __( "Type" ),
		'upcart_field_post_type_cb',
		UPWPCART_SETTINGS_PAGE,
		'upcart_settings_section'
	);

	// register the currency field
	add_settings_field(
		'upcart_field_currency',
		__( "Currency" ),
		'upcart_field_currency_cb',
		UPWPCART_SETTINGS_PAGE,
		'upcart_settings_section'
	);

	// register the redirect field
	add_settings_field(
		'upcart_field_redirect',
		__( "Redirect page" ),
		'upcart_field_redirect_cb',
		UPWPCART_SETTINGS_PAGE,
		'upcart_settings_section'
	);
}

add_action( 'admin_init', 'upcart_settings_fields' );

/**
 * callback functions
 */

// Meta Field render
function upcart_field_meta_cb() {
	// get the value of the setting we've registered with register_setting()
	$setting = get_option( 'upcart_meta' );
	// output the field
	?>
    <input type="text" name="upcart_meta" value="<?= esc_attr( $setting ); ?>" placeholder="price">
    <p class="description">
		<?php esc_html_e( 'The meta field or custom field name that defines the product price', UPWPCART_PLUGIN_DOMAIN ); ?>
        .
    </p>
    <p class="description">
        <span><?php esc_html_e( 'Default' ); ?>:</span>
        <strong>price</strong>
    </p>
	<?php
}

// Post type Field render
function upcart_field_post_type_cb() {
	// get the value of the setting
	$setting    = get_option( 'upcart_post_type' );
	$post_types = get_post_types( array( 'public' => true ), 'objects' );
	// output the field
	?>
    <select name="upcart_post_type" value="<?= esc_attr( $setting ); ?>">
		<?php foreach ( $post_types as $value => $type ): ?>
            <option value="<?php echo $value ?>" <?php echo $setting == $value ? 'selected' : '' ?>><?php echo $type->label ?></option>
		<?php endforeach ?>
    </select>
    <p class="description">
		<?php esc_html_e( 'The post type to be treated as a product', UPWPCART_PLUGIN_DOMAIN ); ?>.
    </p>
    <p class="description">
        <span><?php esc_html_e( 'Default' ); ?>:</span>
        <strong><?php echo $post_types['post']->label ?></strong>
    </p>
	<?php
}

// Post type Field render
function upcart_field_currency_cb() {
	// get the value of the setting
	$setting = get_option( 'upcart_currency' );
	// output the field
	?>
    <input type="text" name="upcart_currency" value="<?= esc_attr( $setting ); ?>" placeholder="$">
    <p class="description">
		<?php esc_html_e( 'The currency symbol of the price', UPWPCART_PLUGIN_DOMAIN ); ?>
        .
    </p>
    <p class="description">
        <span><?php esc_html_e( 'Default' ); ?>:</span>
        <strong>$</strong>
    </p>
	<?php
}

// Post type Field render
function upcart_field_redirect_cb() {
	// get the value of the setting
	$setting = get_option( 'upcart_redirect' );
	$pages   = get_pages();
	// output the field
	?>
    <select name="upcart_redirect" value="<?= esc_attr( $setting ); ?>">
		<?php
		$default_label = __( "The same page", UPWPCART_PLUGIN_DOMAIN );
		echo "<option value=\"\">{$default_label}</option>";
		foreach ( $pages as $value => $page ) {
			/* @var $page WP_Post */
			$selected = $setting == (string) $page->ID ? 'selected' : '';
			echo "<option value=\"{$page->ID}\" {$selected} >{$page->post_title}</option>";
		}
		?>
    </select>
    <p class="description">
		<?php esc_html_e( 'The page to redirect after a cart iteraction.', UPWPCART_PLUGIN_DOMAIN ); ?>.
    </p>
    <p class="description">
        <span><?php esc_html_e( 'Default' ); ?>:</span>
        <strong><?php esc_html_e( 'The current page', UPWPCART_PLUGIN_DOMAIN ); ?></strong>
    </p>
	<?php
}