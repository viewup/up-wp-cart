<?php
/**
 * Render HTML email
 */

// <HEADER>

/**
 * Render basic table style
 *
 * @param string $html
 *
 * @return string
 */
function upcart_mail_html_style( $html = '' ) {
	$style = "<style>
		.upwpc-table {
		    width: 100%;
	        border-collapse: collapse;
    		border-spacing: 0;
		}
		.upwpc-table thead,
		.upwpc-table tfoot, 
	 	.upwpc-table {
		    border-width: 1px;
		    border-style: solid;
		}
		.upwpc-table th {
		    text-align: center;
		}
		
		.upwpc-table th, 
		.upwpc-table td {
		    border-left-width: 1px;
		    border-left-style: solid;
		    border-color: inherit;
		    padding: 4px;
		    box-sizing: border-box;
		}
		" . apply_filters( 'cart_email_html_style', '' ) . "
	</style>";

	return $html . $style;

}

// Open table
function upcart_mail_html_header_table( $html ) {

	$html .= '<table class="upwpc-table">';

	return $html;
}

// Render thead, calls thead filter
function upcart_mail_html_header_thead( $html, $cart ) {
	$html .= '<thead><tr>';
	$html .= apply_filters( 'cart_email_html_thead', '', $cart );
	$html .= '</tr></thead>';

	return $html;
}

add_filter( 'cart_email_html_header', 'upcart_mail_html_style', 20 );
add_filter( 'cart_email_html_header', 'upcart_mail_html_header_table', 25 );
add_filter( 'cart_email_html_header', 'upcart_mail_html_header_thead', 30, 2 );
// </HEADER>


// <BODY>
/**
 * render the product list, call the product list filter
 *
 * @param string $html
 * @param WPCart $cart
 *
 * @return string
 */
function upcart_mail_html_body_list( $html, $cart ) {
	$html .= '<tbody>';
	foreach ( $cart->get()->items as $item ) {
		$html .= '<tr>';
		$html .= apply_filters( 'cart_email_html_item_row', '', $item, $cart );
		$html .= '</tr>';
	}

	$html .= '</tbody>';

	return $html;
}

add_filter( 'cart_email_html_body', 'upcart_mail_html_body_list', 20, 2 );
// </BODY>

// <FOOTER>
// Renders the table tfoot,
function upcart_mail_html_footer_tfoot( $html, $cart ) {
	$html .= '<tfoot><tr>';

	$html .= apply_filters( 'cart_email_html_tfoot', '', $cart );

	$html .= '</tr></tfoot>';

	return $html;
}

// Closes the table
function upcart_mail_html_footer_table( $html ) {
	$html .= '</table>';

	return $html;
}

add_filter( 'cart_email_html_footer', 'upcart_mail_html_footer_tfoot', 20, 2 );
add_filter( 'cart_email_html_footer', 'upcart_mail_html_footer_table', 25 );
// </FOOTER>

// <THEAD>
function upcart_mail_html_thead_title( $html ) {
	$html .= '<th class="upwpc-product">';
	$html .= __( "Product", UPWPCART_PLUGIN_DOMAIN );
	$html .= '</th>';

	return $html;
}

function upcart_mail_html_thead_amount( $html ) {
	$html .= '<th class="upwpc-amount">';
	$html .= __( "Quantity", UPWPCART_PLUGIN_DOMAIN );
	$html .= '</th>';

	return $html;
}

function upcart_mail_html_thead_price( $html ) {
	$html .= '<th class="upwpc-price">';
	$html .= __( "Price", UPWPCART_PLUGIN_DOMAIN );
	$html .= '</th>';

	return $html;
}

add_filter( 'cart_email_html_thead', 'upcart_mail_html_thead_title', 20 );
add_filter( 'cart_email_html_thead', 'upcart_mail_html_thead_amount', 25 );
add_filter( 'cart_email_html_thead', 'upcart_mail_html_thead_price', 30 );
// </THEAD>

// <ITEM>
function upcart_mail_html_row_item_title( $html, $item ) {
	$html .= '<td class="upwpc-product">';
	$html .= apply_filters( 'cart_email_item_title', '', $item );
	$html .= '</td>';

	return $html;
}

function upcart_mail_html_row_item_amount( $html, $item ) {
	$html .= '<td class="upwpc-amount">';
	$html .= $item->amount;
	$html .= '</td>';

	return $html;
}

function upcart_mail_html_row_item_price( $html, $item ) {
	$html .= '<td class="upwpc-price">';
	$html .= apply_filters( 'upcart_format_price', $item->price, $item );
	$html .= '</td>';

	return $html;
}

function upcart_email_item_title( $html = '', $item ) {
	return apply_filters( 'upcart_format_item_title', $html, $item );
}

add_filter( 'cart_email_html_item_row', 'upcart_mail_html_row_item_title', 20, 2 );
add_filter( 'cart_email_html_item_row', 'upcart_mail_html_row_item_amount', 25, 2 );
add_filter( 'cart_email_html_item_row', 'upcart_mail_html_row_item_price', 30, 2 );

add_filter( 'cart_email_item_title', 'upcart_email_item_title', 20, 2 );
// </ITEM>


// <TFOOT> content
// renders the total label
function upcart_mail_html_tfoot_total_label( $html, $cart ) {
	$colspan = apply_filters( 'upcart_mail_html_total_colspan', 1, $cart );
	$html    .= '<td colspan="' . $colspan . '">';
	$html    .= __( "Total", UPWPCART_PLUGIN_DOMAIN );
	$html    .= '</td>';

	return $html;
}

/**
 * renders the total cell
 *
 * @param string $html
 * @param WPCart $cart
 *
 * @return string
 */
function upcart_mail_html_tfoot_total_value( $html, $cart ) {
	$html .= '<td>';
	$html .= apply_filters( 'upcart_format_price', $cart->get()->total );
	$html .= '</td>';

	return $html;
}

add_filter( 'cart_email_html_tfoot', 'upcart_mail_html_tfoot_total_label', 20, 2 );
add_filter( 'cart_email_html_tfoot', 'upcart_mail_html_tfoot_total_value', 25, 2 );

// increments the colspan
add_filter( 'upcart_mail_html_total_colspan', 'upcart_helper_increment', 20 );
// </TFOOT> content


// helpers
function upcart_helper_increment( $value = 0 ) {
	return $value + 1;

}