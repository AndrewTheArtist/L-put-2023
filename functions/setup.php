<?php
function ama_setup() {	
	load_theme_textdomain( 'ama' );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	));
	add_theme_support( 'title-tag' );
	
	add_theme_support('post-thumbnails');

	add_image_size( 'hero-xxl', 1800, 860, true );
	add_image_size( 'img-600', 600, 600, true );
	add_image_size( 'img-400', 400, 400, true );
}
add_action('init', 'ama_setup');

// Retina
function ama_get_attachment_image(...$args){
    $_tmp = $args;
    $_2x = $args;

    if (empty($_2x[1]) || !is_array($_2x[1])) {
        return fly_get_attachment_image(...$args);
    }

    foreach ($_2x[1] as $key => $size) {
        $_2x[1][$key] = $size * 2;
    }

    $i2x = fly_get_attachment_image_src(...$_2x)['src'];

    $_ = function ($attr) use ($i2x) {
        $attr['srcset'] = "{$attr['src']} 1x, $i2x 2x";
        return $attr;
    };

    add_filter('fly_get_attachment_image_attributes', $_);
    $i1x = fly_get_attachment_image(...$_tmp);
    remove_filter('fly_get_attachment_image_attributes', $_);

    return $i1x;
}

function widgets_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'widgets_theme_support' );

function remove_default_image_sizes( $sizes ) {
	/* Default WordPress */
	unset( $sizes['medium']);
	unset( $sizes['medium_large']);
	unset( $sizes['1536x1536']);
	unset( $sizes['2048x2048']);

	/* With WooCommerce */
	unset( $sizes['woocommerce_thumbnail'] );
	unset( $sizes['woocommerce_single'] );
	unset( $sizes['woocommerce_gallery_thumbnail'] );
	unset( $sizes['shop_thumbnail']);
	unset( $sizes['shop_catalog']);
	unset( $sizes['shop_single']);

	return $sizes;
}  
add_filter( 'intermediate_image_sizes_advanced', 'remove_default_image_sizes' );

if (! isset($content_width))
	$content_width = 1170;

function wpcodex_add_excerpt_support_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'wpcodex_add_excerpt_support_for_pages' );

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function ama_excerpt_readmore() {
	return '...';
}
add_filter('excerpt_more', 'ama_excerpt_readmore');

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Modify body classes
add_filter( 'body_class', 'ama_body_class', 10, 2 );
function ama_body_class( $wp_classes, $extra_classes ) {
    // List of the only WP generated classes allowed
    $whitelist = array( 'home', 'error404', 'archive', 'single-product', 'logged-in,', 'admin-bar', 'woocommerce-account', 'woocommerce', 'woocommerce-cart', 'woocommerce-checkout', 'woocommerce-login' );
    // Filter the body classes
    $wp_classes = array_intersect( $wp_classes, $whitelist );

    // Add the extra classes back untouched
    return array_merge( $wp_classes, (array) $extra_classes );
}