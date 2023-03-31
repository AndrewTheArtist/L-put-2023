<?php
/**
 * Location Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$blockClass = 'block-posts';
$class_name = $blockClass;
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' '. $block['className'];
}

$query_post_type = 'post';
$acf_gutenberg_method = get_field('acf_gutenberg_method');
if( $acf_gutenberg_method == 'method_latest' ){
    $acf_gutenberg_perblock = get_field('acf_gutenberg_perblock');
    $args = array(
        'post_type'      => array($query_post_type),
        'post_status'    => array('publish'),
        'posts_per_page' => $acf_gutenberg_perblock,
        'order'          => 'ASC',
        'orderby'        => 'menu_order',
        'no_found_rows'  => true
    );
} elseif( $acf_gutenberg_method == 'method_select' ){
    $acf_gutenberg_select = get_field('acf_gutenberg_select', $block['id']);
    $args = array(
        'post_type'     => array($query_post_type),
        'post_status'   => array('publish'),
        'post__in'      => $acf_gutenberg_select,
        'orderby'       => 'post__in',
        'no_found_rows' => true
    );
}
$gutenberg_loop = new WP_Query( $args );
if ( $gutenberg_loop->have_posts() ) {
    $acf_gutenberg_title = get_field('acf_gutenberg_title');
    $acf_gutenberg_btn = get_field('acf_gutenberg_btn');
    echo '<div '. $anchor .'class="ama-block '. esc_attr( $class_name ) .'">';
        echo $acf_gutenberg_title ? '<div class="block-title row is-wide"><h2 class="wp-el col-12 col-xl-10 offset-xl-1 text-uppercase" data-animate="T_FADE_DOWN">'. $acf_gutenberg_title .'</h2></div>' : '';
            $posts_count = 1;
            while ( $gutenberg_loop->have_posts() ) {
                $gutenberg_loop->the_post();
                if( $posts_count == 1 ){
                    if( has_post_thumbnail() ){
                        include( locate_template('partials/list-post-wide.php') );
                    } else {
                        include( locate_template('partials/list-post.php') );
                    }
                } else {
                    include( locate_template('partials/list-post.php') );
                }
            $posts_count++;
            }
        if( $acf_gutenberg_btn ){
            echo '<div class="block-btn is-wide text-center" data-animate="T_FADE_UP">', ama_get_btn($acf_gutenberg_btn, 'wp-block-button is-style-secondary') ,'</div>';
        }
    echo '</div>';
}
wp_reset_postdata();
?>