<?php
function ama_enqueues() {
	
    $variablespath = get_stylesheet_directory() . '/theme/css/variables.css';
    wp_enqueue_style(
        'variables',
        get_stylesheet_directory_uri() . '/theme/css/variables.css',
        array(),
        filemtime( $variablespath )
    );

	wp_register_style('bootstrap', get_template_directory_uri() . '/theme/css/bootstrap.css', false, null);
	wp_enqueue_style('bootstrap');

	wp_register_style('splide', get_template_directory_uri() . '/theme/js/splide/splide-core.min.css', false, null);
	wp_enqueue_style('splide');

    if ( main_is_plugin_active( 'woocommerce/woocommerce.php' ) || class_exists( 'WooCommerce' ) ) {
        wp_register_style('ama-woocommerce', get_template_directory_uri() . '/theme/css/ama-woocommerce.css', false, null);
        wp_enqueue_style('ama-woocommerce');
    }

    $themecsspath = get_stylesheet_directory() . '/theme/css/theme.css';
    wp_enqueue_style(
        'ama',
        get_stylesheet_directory_uri() . '/theme/css/theme.css',
        array(),
        filemtime( $themecsspath )
    );

	/* Scripts */	
	wp_enqueue_script( 'jquery' );

	wp_register_script('bootstrap.bundle.min', get_template_directory_uri() . '/theme/js/bootstrap.bundle.min.js', false, null, true);
	wp_enqueue_script('bootstrap.bundle.min');

	wp_register_script('splide.min', get_template_directory_uri() . '/theme/js/splide/splide.min.js', false, null, true);
	wp_enqueue_script('splide.min');

	wp_register_script('mixitup.min', get_template_directory_uri() . '/theme/js/mixitup.min.js', false, null, true);
	wp_enqueue_script('mixitup.min');

	wp_register_script('ama', get_template_directory_uri() . '/theme/js/functions.js', false, null, true);
	wp_enqueue_script('ama');

    

    if ( main_is_plugin_active( 'woocommerce/woocommerce.php' ) || class_exists( 'WooCommerce' ) ) {
        wp_register_script('ama-woocommerce', get_template_directory_uri() . '/theme/js/ama-woocommerce.js', false, null, true);
        wp_enqueue_script('ama-woocommerce');
    }

}
add_action('wp_enqueue_scripts', 'ama_enqueues', 100);

function mind_defer_scripts( $tag, $handle, $src ) {
    $defer = array(
        'admin-bar',
        'arve-main',
        'page-scroll-to-id-plugin-script',
        'rank-math',
        'bootstrap.bundle.min',
        'swiper-bundle.min',
        'ama',
        'ari-fancybox',
    );
    if ( in_array( $handle, $defer ) ) {
        return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
    }
    return $tag;
} 
add_filter( 'script_loader_tag', 'mind_defer_scripts', 10, 3 );



// Maps // Maps // Maps // Maps // Maps // 

function careerMapKey($api){
    $api['key'] = 'AIzaSyC7RGE6OyBWl0BWdS5z7TxoWPq0rEpjBqs';
    return $api;
}
add_filter('acf/fields/google_map/api', 'careerMapKey');

