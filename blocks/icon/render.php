<?php
/**
 * Grid | Slide | Text Gallery Block Template.
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
$className = 'block-icon';
if ( ! empty( $block['className'] ) ) {
    $className .= ' '. $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $className .= ' align'. $block['align'];
}
if ( ! empty( $block['alignText'] ) ) {
    $className .= ' has-text-align-'. $block['alignText'];
}

$sliderAttr = [
  'type' => 'slide',
  'perPage' => 4,
  'pagination' => true, 
  'arrows' => true,
  'autoplay' => false,
  'breakpoints' => [1024 => ['perPage' => 3], 726 =>['perPage' => 2], 425 => ['perPage' => 1]],
];


$acf_grid_slider_option = get_field('acf_grid_slider_option');
$acf_logos_grid_slide = get_field('acf_logos_grid_slide');

  if($acf_grid_slider_option == 'grid'):
      echo '<div class="d-grid block-view__grid ">';
          if($acf_logos_grid_slide) :
            foreach ($acf_logos_grid_slide as $logo):
              $img = get_post_meta($logo);
              $attached_url = $img['_wp_attachment_image_alt']['0'];
              echo'<li><a href="'.$attached_url.'">'.wp_get_attachment_image($logo, 'full').'</a></li>';
            endforeach;
          endif;
      echo '</div>';
  endif;
  if($acf_grid_slider_option == 'slider'):
    $acf_slider_layout = get_field('acf_slider_layout');
    if(!empty($acf_slider_layout)){
      $container = 'wide-slider-option ';
      $img_size = 'large';
    } else{
      $container = 'container ';
      $img_size = 'medium';
    };

    echo '<section class="acf-block-element '. esc_attr($className).' container">';
      echo '<div class="'.esc_attr($container).' splide" data-splide='.json_encode($sliderAttr).'>';
        echo '<div class="splide__track">';
        echo '<ul class="splide__list c_icon_block_slist">';
            foreach ($acf_logos_grid_slide as $logo) :
                echo '<li class="splide__slide cstm_img_size">'.wp_get_attachment_image($logo, ''.esc_attr($img_size).'').'</li>';
            endforeach;
            echo '</ul>';
        echo '</div>';    
      echo '</div>';
    echo '</section>';
    endif;

    if($acf_grid_slider_option == 'text'):
      $items = array();
        echo '<div class="a_icon_block--text container d-grid">';
            foreach ($acf_logos_grid_slide as $logo) :
              $title = get_the_title($logo);
              $img = get_post_meta($logo);
              $attached_url = $img['_wp_attachment_image_alt']['0'];
              echo '<a href="'.$attached_url.'">'.$title.'</a>';
            endforeach;

              foreach ($items as $item) :
              endforeach;
        echo '</div>';    
    endif;




