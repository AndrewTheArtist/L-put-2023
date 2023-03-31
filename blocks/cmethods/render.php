<?php
/**
 * Contact Methods Block Template.
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
$className = 'block-cmethods';
if ( ! empty( $block['className'] ) ) {
    $className .= ' '. $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $className .= ' align'. $block['align'];
}
if ( ! empty( $block['alignText'] ) ) {
    $className .= ' has-text-align-'. $block['alignText'];
}

$acf_contacts_repeater = get_field('acf_contacts_repeater', $block['id']);
if( !is_admin() && $acf_contacts_repeater ){
    echo '<div id="'. esc_attr($id) .'" class="wp-el '. esc_attr($className) .'">';
        echo ama_get_contact_methods($acf_contacts_repeater, '', true);
    echo '</div>';
}