<?php
/* style.css version must be updated if new blocks are added */ 

namespace ama\Blocks;

/**
 * Load Blocks
 */
function load_blocks() {
	$theme  = wp_get_theme();
	$blocks = get_blocks();
	foreach( $blocks as $block ) {
		if ( file_exists( get_template_directory() . '/blocks/' . $block . '/block.json' ) ) {
			register_block_type( get_template_directory() . '/blocks/' . $block . '/block.json' );
			wp_register_style( 'block-' . $block, get_template_directory_uri() . '/blocks/' . $block . '/style.css', null, $theme->get( 'Version' ) );

			if ( file_exists( get_template_directory() . '/blocks/' . $block . '/init.php' ) ) {
				include_once get_template_directory() . '/blocks/' . $block . '/init.php';
			}
		}
	}
}
add_action( 'init', __NAMESPACE__ . '\load_blocks', 5 );

/**
 * Load ACF field groups for blocks
 */
function load_acf_field_group( $paths ) {
	$blocks = get_blocks();
	foreach( $blocks as $block ) {
		$paths[] = get_template_directory() . '/blocks/' . $block;
	}
	return $paths;
}
add_filter( 'acf/settings/load_json', __NAMESPACE__ . '\load_acf_field_group' );

/**
 * Get Blocks
 */
function get_blocks() {
	$theme   = wp_get_theme();
	$blocks  = get_option( 'ama_blocks' );
	$version = get_option( 'ama_blocks_version' );
	if ( empty( $blocks ) || version_compare( $theme->get( 'Version' ), $version ) || ( function_exists( 'wp_get_environment_type' ) && 'production' !== wp_get_environment_type() ) ) {
		$blocks = scandir( get_template_directory() . '/blocks/' );
		$blocks = array_values( array_diff( $blocks, array( '..', '.', '.DS_Store', '_base-block' ) ) );

		update_option( 'ama_blocks', $blocks );
		update_option( 'ama_blocks_version', $theme->get( 'Version' ) );
	}
	return $blocks;
}

/**
 * Block categories
 *
 * @since 1.0.0
 */
function block_categories( $categories ) {

	// Check to see if we already have a AMA category
	$include = true;
	foreach( $categories as $category ) {
		if( 'ama' === $category['slug'] ) {
			$include = false;
		}
	}

	if( $include ) {
		$categories = array_merge(
			$categories,
			[
				[
					'slug'  => 'ama',
					'title' => __( 'AMA', 'ama' ),
				]
			]
		);
	}

	return $categories;
}
add_filter( 'block_categories_all', __NAMESPACE__ . '\block_categories' );

/* =============================================================================
   check first block
   ========================================================================== */
function sg_first_block_is($block_handle) {
    $post = get_post();
    if(has_blocks($post->post_content)) {
        $blocks = parse_blocks($post->post_content);

        if($blocks[0]['blockName'] === $block_handle) {
            return true;
        }else {
            return false;
        }
    }
}
function sg_get_first_block_id(){
    $post = get_post(); 
    if( has_blocks( $post->post_content) ){
        $blocks = parse_blocks($post->post_content);
        $first_block_attrs = $blocks[0]['attrs'];
        if( array_key_exists('id', $first_block_attrs) ){
            return $first_block_attrs['id'];
        }
    }
}
// sg_first_block_is('core/paragraph')  && $block['id'] === sg_get_first_block_id()

// Get Footer Menu
register_nav_menus( array(
	'secondary' => __( 'Footer Menu', 'generatepress' ),
) );