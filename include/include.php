<!--function my_assets() {

}-->
<?php

add_action( 'wp_enqueue_scripts', function(){

    wp_enqueue_script( 
        'up-wp-cart', 
        UPWPCART_PLUGIN_URL . '/include/js/up-wp-cart.js', 
        array('jquery') 
    );
    // wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array( 'reset' ) );
	// wp_enqueue_style( 'reset', get_stylesheet_directory_uri() . '/reset.css' );

	// wp_enqueue_script( 'owl-carousel', get_stylesheet_directory_uri() . '/owl.carousel.js', array( 'jquery' ) );
	// wp_enqueue_script( 'theme-scripts', get_stylesheet_directory_uri() . '/website-scripts.js', array( 'owl-carousel', 'jquery' ), '1.0', true );
});