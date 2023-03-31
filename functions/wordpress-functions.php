<?php
add_action('admin_bar_menu', 'remove_wp_logo', 999);
	function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node('wp-logo');
}
/*custom login logo*/
function custom_login_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'custom_login_url' );

add_action('admin_head', 'remove_content_editor');
function remove_content_editor(){
    if((int) get_option('page_on_front')==get_the_ID()){
        remove_post_type_support('page', 'editor');
    }
}

function ama_custom_admincss() {
	wp_enqueue_style('admin_styles' , get_template_directory_uri().'/theme/css/ama-admin-style.css');
}
add_action('admin_head', 'ama_custom_admincss');

function ama_login_style() {
echo '<style type="text/css">
body.login{display: -webkit-flex; display: flex; -webkit-flex-direction: column; flex-direction: column; -webkit-flex-wrap: wrap; flex-wrap: wrap; -webkit-justify-content: center; justify-content: center; -webkit-align-content: center; align-content: center; -webkit-align-items: center; align-items: center; min-height: 100vh}
body.login #login{width: 100%!important; max-width: 320px!important; background-color: #fff; padding: 1.875rem 1.25rem 1.25rem; border-radius: 10px; box-shadow: 0 0 25px rgba(0, 0, 0, .05)}
body.login #login + .wpml-login-ls{display: none!important}
body.login form{border: none!important; box-shadow: none!important}
body.login form .forgetmenot{margin-top: 5px}
body.login form .forgetmenot label{margin-bottom: 0}
body.login form + *{margin-top: 0!important}
</style>';
}
add_action('login_head', 'ama_login_style');

add_action('acf/input/admin_head', 'ama_admin_head');
function ama_admin_head() { ?>
    <style type="text/css">
        .editor-styles-wrapper .acf-image-uploader p,
        .editor-styles-wrapper .acf-field .acf-label label{margin: 0!important}
        .editor-styles-wrapper .acf-block-body .acf-fields>.acf-field{padding: 10px!important}
        .wp-core-ui .acf-block-body select{max-width: 100%!important}
        .editor-styles-wrapper .acf-link .link-wrap,
        .editor-styles-wrapper .acf-fields.-left>.acf-field>.acf-input{padding: 0!important}
        .editor-styles-wrapper .acf-fields.-left>.acf-field>.acf-label{padding-left: 0!important}
        .editor-styles-wrapper .acf-fields.-left>.acf-field>.acf-label label{
            display: -webkit-flex!important;
            display: flex!important;
            -webkit-flex-direction: row;
            flex-direction: row;
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
            -webkit-justify-content: flex-start;
            justify-content: flex-start;
            -webkit-align-content: center;
            align-content: center;
            -webkit-align-items: center;
            align-items: center;
            min-height: 30px!important
        }
        
        #edittag{max-width: 100%}
        #edittag #icl_tax_category_lang{max-width: 800px}
        #edittag #icl_tax_category_lang select{max-width: 100%}
        #edittag #icl_translations_table tr:nth-child(odd){background-color: rgba(0, 0, 0, 0.05)}
        #edittag #icl_translations_table tr:nth-child(even){background-color: rgba(0, 0, 0, 0.025)}
        #edittag #icl_translations_table tr td{padding: 5px 10px}
        
        #icl_div > .inside > strong,
        #icl_div > .inside > br,
        #icl_translation_priority_dropdown{display:none}
        #icl_translate_options{margin-bottom:10px}
        #icl_div > .inside > label{display:block}
        #icl_div > .inside > * + label{margin-top:5px}

        #icl_document_language_dropdown{margin: 0 0 10px 0; float: none!important}
        #icl_document_language_dropdown p{margin: 0 0 5px 0}

        .postbox > .inside > p{margin: 0}
        .postbox > .inside > * + p{margin-top: 10px}
        .postbox > .inside > p + *{margin-top: 5px}
        .postbox > .inside > select{display: block; width: 100%}

		@media (min-width: 1024px){			
			.acf-fields.-sidebar{padding-left: 200px!important}
			.acf-fields.-sidebar:before,
            .acf-fields.-sidebar > .acf-tab-wrap.-left > .acf-tab-group{width: 180px!important}
            
            .acf-fields.-left>.acf-field>.acf-label,
            .acf-fields.-left>.acf-field:before{width: 12%!important}
            .acf-fields.-left>.acf-field>.acf-input{width: 88%!important}
		}
		@media (max-width: 1023px){
			.acf-repeater{overflow-x: scroll}
        }
        
        .acf-button-group{flex-wrap: wrap!important}
        .acf-fields>.acf-field.acf-field-group{padding:0;border:none}
        .acf-fields>.acf-field.acf-field-group .acf-label{display:none!important}
        .acf-fields>.acf-field.acf-field-group .acf-table{border-left:none;border-bottom:none;border-right:none}
        .acf-fields>.acf-field{min-height: auto!important}

        .edit-post-layout__metaboxes:not(:empty) .edit-post-meta-boxes-area{margin: 0}
        .wpseo-metabox-content{max-width: 100%}

        .acf-link.-value .link-wrap{display: inline-flex; align-items: center}
        i.acf-icon:not(.acf-icon-plus):not(.acf-icon-trash):not(.acf-icon-help){background-color: transparent; color: currentColor; text-indent: unset}
        .acf-input .acf-icon{position: relative}
        * + i.acf-icon,
        .acf-icon + .acf-icon{margin-left: .25rem}
            .acf-icon::before{display: block; position: absolute; top: 50%!important; left: 50%!important; transform: translateX(-50%) translateY(-50%)}
        .acf-field-list .acf-sortable-handle{width: 24px; height: 24px; padding: 0!important}
            .acf-field-list .acf-sortable-handle::before{left: -10px!important; transform: translateX(0) translateY(-50%)!important}

        .acf-tab i.acf-icon{background-color: currentColor!important}
        

        .ui-dialog{z-index: 1001}
        .ui-dialog #arve-sc-dialog{max-height: 80vh!important; overflow-x: hidden; overflow-y: auto}

        #acf-field-group-fields .li-field-order{align-items: center}
            .acf-field-object .li-field-label:before{top: 50%; margin-top: -9px}
            
        .post-type-acf-field-group .acf-field-object .handle li{padding-top: 5px; padding-bottom: 5px}
        .post-type-acf-field-group .acf-field-object .handle li,
        .post-type-acf-field-group .acf-field-object .handle li.li-field-label{align-content: center!important}
        
        .post-type-acf-field-group .acf-field-object .handle li.li-field-type{align-items: center}
        .post-type-acf-field-group .acf-field-object .handle li.li-field-type .field-type-icon{top: 0}

        .post-type-acf-field-group .acf-input-sub .acf-field-object .acf-sortable-handle{width: 24px; height: 24px; font-size: 13px}

        .post-type-acf-field-group .notice{margin-bottom: 20px!important}

a.acf-icon{text-decoration: none!important}
    </style>
<?php }

add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
    wp_redirect( home_url() );
    exit();
}

add_action( 'wp_enqueue_scripts', 'bs_dequeue_dashicons' );
function bs_dequeue_dashicons() {
    if ( !is_user_logged_in() ) {
        wp_deregister_style( 'dashicons' );
    }
}

function ama_customize_register( $wp_customize ) {
    $wp_customize->remove_panel( 'nav_menus');
    $wp_customize->remove_panel( 'widgets');
}
add_action( 'customize_register', 'ama_customize_register',50 );

/* Function which remove Plugin Update Notices */
function disable_plugin_updates( $value ) {
    unset( $value->response['acfml/wpml-acf.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );

// Disable WordPress image compression
add_filter( 'wp_editor_set_quality', function( $arg ) {
    return 100;
});