<?php

add_action( 'wp_enqueue_scripts', function(){

    wp_enqueue_script( 
        UPWPCART_JS_HANDLE,
        UPWPCART_PLUGIN_URL . '/include/js/up-wp-cart.js', 
        array('jquery') 
    );

    wp_localize_script( UPWPCART_JS_HANDLE, UPWPCART_JS_VARNAME, [
        'UPWPCART_API_BASE' => UPWPCART_API_BASE,
        'UPWPCART_API_ROUTE' => UPWPCART_API_ROUTE,
        'homeUrl' => get_home_url()
    ]);

    // wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array( 'reset' ) );
	// wp_enqueue_style( 'reset', get_stylesheet_directory_uri() . '/reset.css' );
});