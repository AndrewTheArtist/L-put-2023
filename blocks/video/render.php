<?php
/**
 * Custom Video Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

use Psr\Log\Test\TestLogger;
use RankMath\Analytics\Workflow\Console;

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'block-video';
if ( ! empty( $block['className'] ) ) {
    $className .= ' '. $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $className .= ' align'. $block['align'];
}
if ( ! empty( $block['alignText'] ) ) {
    $className .= ' has-text-align-'. $block['alignText'];
}

$acf_media_video = get_field('acf_media_video');
$attr = array(
    'preload' => 'metadata',
    'autoplay' => true,
    'height' => 360,
);
$content = '';

echo wp_video_shortcode($attr, $content);