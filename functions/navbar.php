<?php
/*
Navigation
*/
register_nav_menus( array(
	'primary' => __( 'Primary', 'ama' ),
));

class AMA_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output = preg_replace( "/(.*)(\<li.*?class\=\")([^\"]*)(\".*?)$/", "$1$2$3 has-submenu$4", $output );

        if ( $this->has_children ) {
            $output .= '<span class="sub-menu-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8"><path d="M5.25,7.25A.725.725,0,0,1,4.7,6.98L-.521.826a1.044,1.044,0,0,1,0-1.305.7.7,0,0,1,1.107,0l4.664,5.5L9.914-.48a.7.7,0,0,1,1.107,0,1.044,1.044,0,0,1,0,1.305L5.8,6.98A.725.725,0,0,1,5.25,7.25Z" transform="translate(0.75 0.75)" fill="currentColor"/></svg></span>';
        }

        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }
}

/* nav menu ID and class removal */
add_filter('nav_menu_item_id', '__return_false');
function remove_css_id_filter($var) {
    $excluded_classes = [
        'current-menu-item', 'current-menu-parent', 'current-menu-ancestor',
        'current_page_item', 'current_page_parent', 'current_page_ancestor',
        'current-product-item', 'current-product-parent', 'current-product-ancestor',
        'menu-item-has-children'
    ];

    return is_array($var) ? array_intersect($var, $excluded_classes) : '';
} 
add_filter( 'page_css_class', 'remove_css_id_filter', 100, 1);
add_filter( 'nav_menu_item_id', 'remove_css_id_filter', 100, 1);
add_filter( 'nav_menu_css_class', 'remove_css_id_filter', 100, 1);