<?php
/* Reference
		'label'                 => __( 'Post Type', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => false,
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite'               => false,
*/

// Register General Blocks
add_action( 'init', 'ama_blocks_type', 0 );
function ama_blocks_type(){
	$args = array(
		'supports'              => array( 'title', 'editor', 'revisions' ),
		'show_ui'               => true,
		'menu_position'         => 80,
		'menu_icon'             => 'dashicons-block-default',
		'publicly_queryable'    => false,
		'rewrite'               => false,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	ama_register_cpt('ama-blocks', __( 'General Block', 'ama'), __( 'General Blocks', 'ama'), $args);
}


add_action('init', function(){
	$common = [
		'hierarchical' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 20,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'exclude_from_search' => false,
		'capability_type' => 'page',
		'public' => false,
		'publicly_queryable' => false,
		'has_archive' => false,
		'show_in_rest' => true,
	];

	register_post_type('careers', array_merge($common, [
		'label' => __('Karjäärid', 'ama'),
		'labels' => [
			'name' => _x('Karjäärid', 'Post Type General Name', 'ama'),
			'singular_name' => _x('Karjäär', 'Post Type Singular Name', 'ama'),
		],
		'menu_icon' => 'dashicons-building',
		'supports' => ['title', 'editor', 'revisions', 'thumbnail'],
		'public' => true,
		'show_in_nav_menus' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
	]));


	register_taxonomy('owners', 'careers', [
		'hierarchical' => true,
		'labels' => [
			'name' => _x('Omanikud', 'career general name', 'ama'),
			'singular_name' => _x('Omanik', 'career singular name', 'ama'),
	],
	'show_ui' => true,
	'show_admin_column' => true,
	'update_count_callback' => '_update_post_term_count',
	'query_var' => true,
	'show_in_rest' => true,
]);

register_taxonomy('specifics', 'careers', [
	'hierarchical' => true,
	'labels' => [
		'name' => _x('Suunitlused', 'speciality name careers', 'ama'),
		'singular_name' => _x('Suunitlus', 'specific singular name', 'ama'),
],
'show_ui' => true,
'show_admin_column' => true,
'update_count_callback' => '_update_post_term_count',
'query_var' => true,
'show_in_rest' => true,
]);
});

// Register Careers
// function ama_post_type_careers(){
// 	$args = array(
// 		'labels' => array(
// 			'name' => 'Karjäärid',
// 			'singular_name' => 'Karjäär'
// 		),
// 		'hierarchical' => false,
// 		'show_ui' => true,
// 		'show_in_menu' => true,
// 		'menu_position' => 20,
// 		'show_in_admin_bar' => true,
// 		'show_in_nav_menus' => true,
// 		'can_export' => true,
// 		'exclude_from_search' => false,
// 		'capability_type' => 'page',
// 		'public' => false,
// 		'publicly_queryable' => false,
// 		'has_archive' => false,
// 		'show_in_rest' => true,
// 		'menu_icon' => 'dashicons-building',
// 		'supports' => ['title', 'editor', 'revisions', 'thumbnail'],

// 	);

// 	register_post_type('careers', $args);
// }
// add_action('init', 'ama_post_type_careers');

// function career_taxonomy(){
// 	$args = array(
// 		'labels' => array(
// 				'name' => 'Omanikud',
// 				'singular_name' => 'Omanik',
// 		),
// 		'public' => true,
// 		'hierarchical' => true
// 	);
// 	register_taxonomy('owners', array('careers'), $args);
// }
// add_action('init', 'career_taxonomy');


function ama_register_cpt($slug, $singular, $plural, $args, $labels_overwrite = array()){
	// Create labels array
	$labels = array(
		'name'                  => $plural,
		'singular_name'         => $singular,
		'menu_name'             => $plural,
		'name_admin_bar'        => $singular,
		'archives'              => $plural,
		'attributes'            => __( 'Attributes', 'ama' ),
		'parent_item_colon'     => __( 'Parent:', 'ama' ),
		'all_items'             => __( 'All', 'ama' ) . ' ' . $plural,
		'add_new_item'          => __( 'Add New', 'ama' ) . ' ' . $singular,
		'add_new'               => __( 'Add New', 'ama' ),
		'new_item'              => __( 'New', 'ama' ),
		'edit_item'             => __( 'Edit', 'ama' ),
		'update_item'           => __( 'Update', 'ama' ),
		'view_item'             => __( 'View', 'ama' ),
		'view_items'            => __( 'View', 'ama' ) . ' ' . $plural,
		'search_items'          => __( 'Search', 'ama' ),
		'not_found'             => __( 'Not found', 'ama' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'ama' ),
		'featured_image'        => __( 'Featured Image', 'ama' ),
		'set_featured_image'    => __( 'Set featured image', 'ama' ),
		'remove_featured_image' => __( 'Remove featured image', 'ama' ),
		'use_featured_image'    => __( 'Use as featured image', 'ama' ),
		'insert_into_item'      => __( 'Insert into', 'ama' ) . ' ' . $singular,
		'uploaded_to_this_item' => __( 'Uploaded to this', 'ama' ) . ' ' . $singular,
		'items_list'            => __( 'List', 'ama' ),
		'items_list_navigation' => __( 'Navigation', 'ama' ),
		'filter_items_list'     => __( 'Filter', 'ama' ),
	);
	//Overwrite labels if needed
	if (!empty($labels_overwrite)){
		foreach ($labels_overwrite as $key => $value){
			$labels[$key] = $value;
		}
	}
	// Set label args
	$args['label'] = $singular;
	$args['labels'] = $labels;
	register_post_type( $slug, $args );
}

add_filter( 'wp_nav_menu_objects', 'my_highlight_cpt_archive_and_ancestors_in_menu', 10, 2 );
function my_highlight_cpt_archive_and_ancestors_in_menu( $menu_items, $args ) {
	global $wp_query, $wp_rewrite;

	$queried_object = $wp_query->get_queried_object();

	$active_object = '';
	$active_ancestor_item_ids = array();
	$active_parent_item_ids = array();
	$active_parent_object_ids = array();
	$possible_taxonomy_ancestors = array();

	foreach ( (array) $menu_items as $key => $menu_item ) {
		if ( ( 'post_type_archive' == $menu_item->type && is_post_type_archive( array( $menu_item->object ) ) ) || ( 'post_type_archive' == $menu_item->type && is_singular( array( $menu_item->object ) ) ) ) {
			$allow_highlight = true;
			$allow_highlight = apply_filters( 'my_allow_menu_highlight', $allow_highlight, $menu_item, $queried_object, $args );

			if ( $allow_highlight ) {
				$menu_item->classes[] = 'current-menu-item';
				$menu_items[ $key ]->current = true;

				$_anc_id = (int) $menu_item->db_id;

				while ( ( $_anc_id = get_post_meta( $_anc_id, '_menu_item_menu_item_parent', true ) ) && ! in_array( $_anc_id, $active_ancestor_item_ids ) ) {
					$active_ancestor_item_ids[] = $_anc_id;
				}

				$active_parent_item_ids[]   = (int) $menu_item->menu_item_parent;
				$active_parent_object_ids[] = (int) $menu_item->post_parent;
				$active_object              = $menu_item->object;
			}
		}
	}

	$active_ancestor_item_ids = array_filter( array_unique( $active_ancestor_item_ids ) );
	$active_parent_item_ids = array_filter( array_unique( $active_parent_item_ids ) );
	$active_parent_object_ids = array_filter( array_unique( $active_parent_object_ids ) );

	foreach ( (array) $menu_items as $key => $parent_item ) {
		$classes = (array) $parent_item->classes;
		$menu_items[$key]->current_item_ancestor = false;
		$menu_items[$key]->current_item_parent = false;

		if ( isset( $parent_item->type ) && (( 'post_type' == $parent_item->type && ! empty( $queried_object->post_type ) && is_post_type_hierarchical( $queried_object->post_type ) && in_array( $parent_item->object_id, $queried_object->ancestors ) && $parent_item->object != $queried_object->ID ) || ( 'taxonomy' == $parent_item->type && isset( $possible_taxonomy_ancestors[ $parent_item->object ] ) && in_array( $parent_item->object_id, $possible_taxonomy_ancestors[ $parent_item->object ] ) && ( ! isset( $queried_object->term_id ) || $parent_item->object_id != $queried_object->term_id )))) {
			$classes[] = empty( $queried_object->taxonomy ) ? 'current-' . $queried_object->post_type . '-ancestor' : 'current-' . $queried_object->taxonomy . '-ancestor';
		}

		if ( in_array(  intval( $parent_item->db_id ), $active_ancestor_item_ids ) ) {
			$classes[] = 'current-menu-ancestor';
			$menu_items[$key]->current_item_ancestor = true;
		}
		if ( in_array( $parent_item->db_id, $active_parent_item_ids ) ) {
			$classes[] = 'current-menu-parent';
			$menu_items[$key]->current_item_parent = true;
		}
		if ( in_array( $parent_item->object_id, $active_parent_object_ids ) )
			$classes[] = 'current-' . $active_object . '-parent';

		if ( 'post_type' == $parent_item->type && 'page' == $parent_item->object ) {
			if ( in_array('current-menu-parent', $classes) )
				$classes[] = 'current_page_parent';
			if ( in_array('current-menu-ancestor', $classes) )
				$classes[] = 'current_page_ancestor';
		}

		$menu_items[$key]->classes = array_unique( $classes );
	}

	return $menu_items;
}