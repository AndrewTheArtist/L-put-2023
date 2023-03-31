<?php
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'menu_title'	=> __('Theme Settings', 'ama'),
		'menu_slug' 	=> 'theme-general-settings',
		'redirect'		=> true
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> __('General', 'ama'),
		'menu_title'	=> __('General Settings', 'ama'),
		'menu_slug'		=> 'acf-options-general-settings',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Header', 'ama'),
		'menu_title'	=> __('Header Settings', 'ama'),
		'menu_slug'		=> 'acf-options-header-settings',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Footer', 'ama'),
		'menu_title'	=> __('Footer Settings', 'ama'),
		'menu_slug'		=> 'acf-options-footer-settings',
		'parent_slug'	=> 'theme-general-settings',
	));
}