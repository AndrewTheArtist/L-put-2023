<?php
/**
 * Cards Block Template.
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
$blockClass = 'block-cards';
$class_name = $blockClass;
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' '. $block['className'];
}

if( have_rows('acf_gutenberg_content') ):
    $acf_gutenberg_columns = get_field('acf_gutenberg_columns');
    echo '<div '. $anchor .'class="ama-block '. esc_attr( $class_name ) .'" data-block-columns="'. $acf_gutenberg_columns .'">';
        while( have_rows('acf_gutenberg_content') ) : the_row();
            $acf_repeater_title = get_sub_field('acf_repeater_title');
            $acf_repeater_content = get_sub_field('acf_repeater_content');
            echo '<div class="'. $blockClass .'__item classic-editor" data-animate="T_FADE_ZOOM">';
                echo $acf_repeater_title ? '<p class="has-medium-font-size fw-semibold">'. $acf_repeater_title .'</p>' : '';
                echo $acf_repeater_content ? $acf_repeater_content : '';
            echo '</div>';
        endwhile;
    echo '</div>';
endif;
?>