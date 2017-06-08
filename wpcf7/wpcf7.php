<?php
/**
 * Integration with Contact Form 7
 */

define( 'WPCART_WPCF7_MAIL_CONTENT', 'WPCART_WPCF7_MAIL_CONTENT' );

// Field register and shortcode
require_once __DIR__ . "/wpcf7-shortcode.php";

// Messages register
require_once __DIR__ . "/wpcf7-messages.php";

// Field validation
require_once __DIR__ . "/wpcf7-validation.php";

// Tag generator
require_once __DIR__ . "/wpcf7-tag-generator.php";


// Email rendering
//require_once __DIR__ . "/wpcf7-email.php";