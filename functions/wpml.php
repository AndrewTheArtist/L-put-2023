<?php
define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);

global $sitepress;
remove_action( 'wp_head', array( $sitepress, 'meta_generator_tag' ) );

add_filter( 'wpml_custom_field_original_data', 'disable_original_lang_data' );
function disable_original_lang_data(){
	return;
}

add_filter( 'login_display_language_dropdown', '__return_false' );

if ( main_is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
    add_action('ama_theme_header', 'theme_header_ls', 50 );
    function theme_header_ls() {
        echo do_action('wpml_add_language_selector');
    }
}