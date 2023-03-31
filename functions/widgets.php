<?php
function ama_widgets_init() {
	register_sidebar( array(
		'name'            => __( 'Sidebar', 'ama' ),
		'id'              => 'sidebar-widget-area',
		'description'     => __( 'The sidebar widget area', 'ama' ),
		'before_widget'   => '<div id="%1$s" class="%2$s">',
		'after_widget'    => '</div>',
		'before_title'    => '<p class="widget-title">',
		'after_title'     => '</p>',
	));
}
add_action( 'widgets_init', 'ama_widgets_init' );

function ama_get_dynamic_sidebar($id){
    ob_start();
    dynamic_sidebar( $id );
    $dynamic_sidebar = ob_get_contents();
    ob_clean();
    return $dynamic_sidebar;
}