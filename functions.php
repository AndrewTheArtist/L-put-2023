<?php
/*
All the functions are in the PHP pages in the `functions/` folder.
*/
require_once locate_template('/functions/cleanup.php');
require_once locate_template('/functions/setup.php');
require_once locate_template('/functions/enqueues.php');
require_once locate_template('/functions/navbar.php');
require_once locate_template('/functions/widgets.php');
require_once locate_template('/functions/gutenberg.php');
require_once locate_template('/functions/custom-post-type.php');
require_once locate_template('/functions/acf-options.php');
require_once locate_template('/functions/acf-blocks.php');
require_once locate_template('/functions/wp_bootstrap_pagination.php');
require_once locate_template('/functions/disable-comments.php');
require_once locate_template('/functions/duplicate-posts.php');
require_once locate_template('/functions/category-settings.php');
require_once locate_template('/functions/wordpress-functions.php');
require_once locate_template('/functions/hooks.php');

if ( main_is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
    require_once locate_template('/functions/wpml.php');
}
