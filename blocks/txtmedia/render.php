<?php
/**
 * Text + Media Block Template.
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
$blockClass = 'block-txtmedia';
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
$svg_view = 'block';
$acf_gutenberg_order = get_field('acf_gutenberg_order');
if ( ! empty( $acf_gutenberg_order ) ) {
    $class_name .= ' reverse-order';
    $svg_position = ' svg-right';
}
else{
    $svg_position = ' svg-left';
    
}

$acf_gutenberg_gradient = get_field('acf_gutenberg_gradient');
if (!empty($acf_gutenberg_gradient)){
    $bg_var = ' gradient-gb';
    $svg_fill = '#fff';
}else{
    $svg_fill = '#F5F5F5';
}

$acf_gutenberg_dark = get_field('acf_gutenberg_dark');
if (!empty($acf_gutenberg_dark) && empty($acf_gutenberg_gradient)){
    $bg_var = 'dark-bg';
    $svg_view = 'none';
}
  


$acf_gutenberg_k = get_field('acf_gutenberg_k');
if(!empty($acf_gutenberg_k)){
    $svg_view = 'block';
}else{
    $svg_view = 'none';
}
$acf_gutenberg_type = get_field('acf_gutenberg_type');
echo '<div class="acf-block-element element-bgcolor alignmax bg-light '.$bg_var.'">';
    echo '<div '. $anchor .'class="ama-block '. esc_attr( $class_name ) .'">';
        echo '<div class="'. $blockClass .'__content" data-animate="'. (!$acf_gutenberg_order ? 'T_FADE_RIGHT' : 'T_FADE_LEFT') .'"><InnerBlocks allowedBlocks="'. esc_attr( wp_json_encode( $allowed_blocks ) ) .'" /></div>';
        echo '<div class="'. $blockClass .'__media" data-animate="'. (!$acf_gutenberg_order ? 'T_FADE_LEFT' : 'T_FADE_RIGHT') .'">';
            if( $acf_gutenberg_type == 'type-images' ){
                $acf_gutenberg_images = get_field('acf_gutenberg_images');
                if( $acf_gutenberg_images ){
                    $img_counter = count($acf_gutenberg_images);
                    $arrow_class = $img_counter > 1 ? '' : ' hide-arrows';
                    $sliderAttr = [
                        'type' => 'fade',
                        'pagination' => false
                    ];
                    echo '<div class="splide" data-splide='. json_encode( $sliderAttr ) .'><div class="splide__track"><ul class="splide__list">';
                        foreach( $acf_gutenberg_images as $gutenberg_image ):
                            $url = wp_get_attachment_image_url($gutenberg_image, 'large');
                            echo '<li class="splide__slide txt-media__image"><a href="'. $url .'" data-fancybox="txtmedia-'. esc_attr($block['id']) .'">'. wp_get_attachment_image( $gutenberg_image, $img_size ) .'</a></li>';
                        endforeach;
                    echo '</ul></div>'. ama_splide_arrows($arrow_class) .'</div>';
                } else {
                    $acf_general_txtmedia = get_field('acf_general_txtmedia', 'option');
                    echo wp_get_attachment_image( $acf_general_txtmedia, $img_size );
                }
            } elseif( $acf_gutenberg_type == 'type-video' ){
                $acf_gutenberg_video = get_field('acf_gutenberg_video');
                if( $acf_gutenberg_video ){
                    echo '<div class="video-container"><video autoplay muted playsinline loop><source src="'. $acf_gutenberg_video['url'] .'" type="'. $acf_gutenberg_video['mime_type'] .'"></video></div>';
                } else {
                    $acf_general_txtmedia = get_field('acf_general_txtmedia', 'option');
                    echo wp_get_attachment_image( $acf_general_txtmedia, $img_size );
                }
            } elseif($acf_gutenberg_type == 'type-iframe'){
                $acf_gutenberg_iframe = get_field('acf_gutenberg_iframe');
                echo $acf_gutenberg_iframe;
            }
        echo '</div>';

    echo '</div>';

    echo '<div class="position-absolute bg_svg-container">';
        echo '<svg class="'.$svg_position.'" style="display:'.$svg_view.';" xmlns="http://www.w3.org/2000/svg" width="360" height="522"><path id="k-white" d="M388.612,332.688,431.07,284.43c49.777,46.791,77.172,82.548,90.617,153.86,48.038-42.611,78.1-94.608,96.844-143.449,7.015,17.486,26.2,54.43,34.532,66.63C629.529,401.047,597.908,465.3,530.036,509.944c80.912-.2,115.727,13.085,210.671,66.589L675.646,610.14c-59.663-31.174-83.965-31.877-143.224-36.2-18.479,73.563-40.7,151.991-90.091,232.489l-61.624-35.837c80.65-96.4,137.057-308.183,7.9-437.9Z" transform="translate(-380.707 -284.43)" fill="'.$svg_fill.'" fill-rule="evenodd"/></svg>';
    echo '</div>';
echo '</div>';
?>