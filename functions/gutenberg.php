<?php
function ama_guten_block_editor_assets() {
    wp_enqueue_style('variables-style', get_stylesheet_directory_uri() . '/theme/css/variables.css');
    wp_enqueue_style('ama-editor-style', get_stylesheet_directory_uri() . '/theme/css/editor-style.css');
	
    wp_enqueue_script(
        'ama-editor-js',
        get_stylesheet_directory_uri() . '/theme/js/editor-js.js', [], '1.0',
        array( 'wp-blocks' )
    );
}
add_action('enqueue_block_editor_assets', 'ama_guten_block_editor_assets');

/* =============================================================================
   disable gutenberg
   ========================================================================== */
function ama_disable_editor( $id = false ){
	$excluded_templates = array(
		'page-templates/tpl-redirect.php'
	);

	$excluded_ids = array(
		get_option( 'page_for_posts' )
	);

	if( empty( $id ) )
		return false;

	$id = intval( $id );
	$template = get_page_template_slug( $id );

	return in_array( $id, $excluded_ids ) || in_array( $template, $excluded_templates );
}
function ama_disable_gutenberg( $can_edit, $post_type ) {

	if( ! ( is_admin() && !empty( $_GET['post'] ) ) )
		return $can_edit;

	if( ama_disable_editor( $_GET['post'] ) )
		$can_edit = false;

	return $can_edit;

}
add_filter( 'gutenberg_can_edit_post_type', 'ama_disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'ama_disable_gutenberg', 10, 2 );

/* =============================================================================
   disable classic editor
   ========================================================================== */
function ama_disable_classic_editor() {
	$screen = get_current_screen();
	if( 'page' !== $screen->id || ! isset( $_GET['post']) )
		return;

	if( ama_disable_editor( $_GET['post'] ) ) {
		remove_post_type_support( 'page', 'editor' );
	}
}
add_action( 'admin_head', 'ama_disable_classic_editor' );

/* =============================================================================
   disable block patterns
   ========================================================================== */
remove_theme_support( 'core-block-patterns' );

/* =============================================================================
	disable colors
	========================================================================== */
function ama_disable_gutenberg_color_settings() {
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'editor-color-palette' );
	add_theme_support( 'editor-gradient-presets', [] );
	add_theme_support( 'disable-custom-gradients' );
}
add_action( 'after_setup_theme', 'ama_disable_gutenberg_color_settings' );

/* =============================================================================
   add custom colors
   ========================================================================== */
add_action( 'after_setup_theme', 'ama_add_custom_gutenberg_color_palette' );
function ama_add_custom_gutenberg_color_palette() {
	add_theme_support(
		'editor-color-palette',
		[
			[
				'name'  => esc_html__( 'Primary', 'ama' ),
				'slug'  => 'primary',
				'color' => 'var(--ama-primary-color)',
			],
			[
				'name'  => esc_html__( 'Secondary', 'ama' ),
				'slug'  => 'secondary',
				'color' => 'var(--ama-secondary-color)',
			],
			[
				'name'  => esc_html__( 'Third', 'ama' ),
				'slug'  => 'third',
				'color' => 'gray',
			],
		]
	);
}

/* =============================================================================
   buttons
   ========================================================================== */
add_action( 'init', 'ama_register_block_styles' );
function ama_register_block_styles() {
	register_block_style( 'core/button', [
		'name' => 'secondary',
		'label' => __( 'Secondary', 'ama' )
	]);
	register_block_style( 'core/button', [
		'name' => 'secondary-outline',
		'label' => __( 'Secondary Outline', 'ama' )
	]);
	register_block_style( 'ama/cards', [
		'name' => 'numbered',
		'label' => __( 'Numbered', 'ama' )
	]);
	register_block_style( 'ama/txtmedia', [
		'name' => 'narrow-media',
		'label' => __( 'Narrow Media', 'ama' )
	]);
}

/* =============================================================================
   disabled wp-container class
   ========================================================================== */
remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );
remove_filter( 'render_block', 'gutenberg_render_layout_support_flag', 10, 2 );

/* =============================================================================
   allowed blocks
   ========================================================================== */
add_filter( 'allowed_block_types_all', 'theme_allowed_block_types' );
function theme_allowed_block_types($allowed_blocks) {
	$blocks = array(
		'core/image',
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/list-item',
		'core/buttons',
		'core/button',
		'core/shortcode',
		'core/columns',
		'core/column',
		'core/block',
		'core/separator',
		'core/html',
		'core/embed',
		'core/spacer',
		'core/table',
		'core/quote',
		'core-embed/youtube',
		'core-embed/vimeo',
		'core/file',
		'core/site-title',
		'core/site-tagline',
		'core/post-title',
		'rank-math/howto-block',
		'rank-math/faq-block',
		'contact-form-7/contact-form-selector',
		'nextgenthemes/arve-block',
		'ama/cards',
		'ama/icon',
		'ama/posts',
		'ama/stats',
		'ama/txtmedia',
		'ama/staff',
		'ama/txtmedia-wide',
		'ama/cmethods',
		'ama/video',
		'ama/map',
		'pb/accordion-item'
	);

	return $blocks;
}