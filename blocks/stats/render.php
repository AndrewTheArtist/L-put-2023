<?php
/**
 * Stats Block Template.
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
$blockClass = 'block-stats';
$class_name = $blockClass;
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' '. $block['className'];
}

if( have_rows('acf_gutenberg_content') ):
    echo '<div '. $anchor .'class="ama-block '. esc_attr( $class_name ) .' overflow-hidden"><div class="d-flex flex-wrap justify-content-center">';
        while( have_rows('acf_gutenberg_content') ) : the_row();
            $acf_repeater_value = get_sub_field('acf_repeater_value');
            $acf_repeater_label = get_sub_field('acf_repeater_label');
            echo '<div class="'. $blockClass .'__item" data-animate="T_FADE_ZOOM">';
                echo $acf_repeater_value ? '<p class="font-supravitally has-theme-primary-color">'. $acf_repeater_value .'</p>' : '';
                echo $acf_repeater_label ? '<p class="fw-semibold">'. $acf_repeater_label .'</p>' : '';
            echo '</div>';
        endwhile;
    echo '</div></div>';
endif;
?>