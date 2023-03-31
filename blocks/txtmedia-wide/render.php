<?php
/**
 * Text + Media Wide Block Template.
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
$blockClass = 'block-txtmedia-wide';
$class_name = $blockClass;
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' '. $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align'. $block['align'];
}
if ( ! empty( $block['alignText'] ) ) {
    $class_name .= ' has-text-align-'. $block['alignText'];
}

$allowed_blocks = array(
    'core/paragraph',
    'core/heading',
    'core/list',
    'core/list-item',
    'core/buttons',
    'core/button',
    'ama/social-media',
    'acf/icon',
    'ama/cmethods'
);

if( $block['className'] == 'is-style-narrow' ){
    $img_size = 'img-400';
} else {
    $img_size = 'img-620';
}

$acf_gutenberg_order_wide = get_field('acf_gutenberg_order_wide');
if ( !empty( $acf_gutenberg_order_wide ) ) {
    $class_name_order_wide .= ' reverse-order-wide';
}

$acf_gutenberg_gradient_wide = get_field('acf_gutenberg_gradient_wide');
if (!empty($acf_gutenberg_gradient_wide)){
    $test_var = 'gradient-gb';
}

$acf_gutenberg_dark_wide = get_field('acf_gutenberg_dark_wide');
if (!empty($acf_gutenberg_dark_wide) && empty($acf_gutenberg_gradient_wide)){
    $test_var = 'dark-bg';
}



$acf_gutenberg_type_wide = get_field('acf_gutenberg_type_wide');
echo '<div class="ama-block acf-block-element alignmax ' .esc_attr( $class_name ) .' bg-light '.$test_var.'">';
    echo '<div class="'. $blockClass .'__content '.$class_name_order_wide.'" data-animate="'. (!$acf_gutenberg_order_wide ? 'T_FADE_RIGHT' : 'T_FADE_LEFT') .'"><InnerBlocks allowedBlocks="'. esc_attr( wp_json_encode( $allowed_blocks ) ) .'" /></div>';
    echo '<div class="'. $blockClass .'__media" data-animate="'. (!$acf_gutenberg_order_wide ? 'T_FADE_LEFT' : 'T_FADE_RIGHT') .'">';
        if( $acf_gutenberg_type_wide == 'type-images' ){
            $acf_gutenberg_images_wide = get_field('acf_gutenberg_images_wide');
            if( $acf_gutenberg_images_wide ){
                $img_counter = count($acf_gutenberg_images_wide);
                $arrow_class = $img_counter > 1 ? '' : ' hide-arrows';
                $sliderAttr = [
                    'type' => 'fade',
                    'pagination' => false
                ];
                echo '<div id="mega-wide-slide" class="splide" data-splide='. json_encode( $sliderAttr ) .'><div class="splide__track"><ul class="splide__list">';
                    foreach( $acf_gutenberg_images_wide as $gutenberg_image ):
                        $url = wp_get_attachment_image_url($gutenberg_image, 'large');
                        echo '<li class="splide__slide"><a href="'. $url .'" data-fancybox="txtmedia-'. esc_attr($block['id']) .'">'. wp_get_attachment_image( $gutenberg_image, $img_size ) .'</a></li>';
                    endforeach;
                echo '</ul></div>'. ama_splide_arrows($arrow_class) .'</div>';
            } else {
                $acf_general_txtmedia = get_field('acf_general_txtmedia', 'option');
                echo wp_get_attachment_image( $acf_general_txtmedia, $img_size );
            }
        } elseif( $acf_gutenberg_type_wide == 'type-video' ){
            $acf_gutenberg_video_wide = get_field('acf_gutenberg_video_wide');
            if( $acf_gutenberg_video_wide ){
                echo '<div class="video-container"><video autoplay muted playsinline loop><source src="'. $acf_gutenberg_video_wide['url'] .'" type="'. $acf_gutenberg_video_wide['mime_type'] .'"></video></div>';
            } else {
                $acf_general_txtmedia = get_field('acf_general_txtmedia', 'option');
                echo wp_get_attachment_image( $acf_general_txtmedia, $img_size );
            }
        } elseif($acf_gutenberg_type_wide == 'type-iframe'){
            $acf_gutenberg_iframe_wide = get_field('acf_gutenberg_iframe_wide');
            echo $acf_gutenberg_iframe_wide;
        }
    echo '</div>';    
    echo $block_bg_stencil;
echo '</div>';