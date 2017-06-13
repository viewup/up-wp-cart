<?php
/**
 * Register and render the tag generator for cart
 */

add_action( 'wpcf7_admin_init', 'upcart_wpcf7_add_tag_generator', 25 );

// register the tag generator
function upcart_wpcf7_add_tag_generator() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add( 'cart', __( 'cart' ), 'upcart_wpcf7_tag_generator' );
}

// render the tag generator
function upcart_wpcf7_tag_generator( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() );

	$description = __( "Generate a form-tag for the UP Cart plugin, renders a table. For more details, see %s." );

	$desc_link = wpcf7_link( __( 'https://github.com/viewup/up-wp-cart' ), __( 'Cart on WPCF7' ) );

	?>
	<div class="control-box">
		<fieldset>
			<legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>

			<table class="form-table">
				<tbody>
				<tr>
					<th scope="row"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></legend>
							<label><input type="checkbox"
							              name="required"/> <?php echo esc_html( __( 'Required field', 'contact-form-7' ) ); ?>
							</label>
						</fieldset>
					</td>
				</tr>

				<tr>
					<th scope="row"><label
							for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?></label>
					</th>
					<td><input type="text" name="name" class="tg-name oneline"
					           id="<?php echo esc_attr( $args['content'] . '-name' ); ?>"/></td>
				</tr>

				<tr>
					<th scope="row"><label
							for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'contact-form-7' ) ); ?></label>
					</th>
					<td><input type="text" name="id" class="idvalue oneline option"
					           id="<?php echo esc_attr( $args['content'] . '-id' ); ?>"/></td>
				</tr>

				</tbody>
			</table>
		</fieldset>
	</div>

	<div class="insert-box">
		<input type="text" name="cart" class="tag code" readonly="readonly" onfocus="this.select()"/>

		<div class="submitbox">
			<input type="button" class="button button-primary insert-tag"
			       value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>"/>
		</div>

		<br class="clear"/>

		<p class="description mail-tag"><label
				for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'contact-form-7' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?>
				<input type="text" class="mail-tag code hidden" readonly="readonly"
				       id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"/></label></p>
	</div>
	<?php
}
