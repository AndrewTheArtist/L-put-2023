<?php
/**
 * Staff List Block Template.
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
$className = 'block-staff';
if ( ! empty( $block['className'] ) ) {
    $className .= ' '. $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $className .= ' align'. $block['align'];
}
if ( ! empty( $block['alignText'] ) ) {
    $className .= ' has-text-align-'. $block['alignText'];
}

$acf_staff_picture_check = get_field('acf_staff_picture_check');
$acf_repeater_staff = get_field('acf_repeater_staff');


echo '<section id=" '. esc_attr($id) .'"  class="acf-block-element '. esc_attr($className). ' container">';
  echo '<div class="staff__container d-grid justify-content-center pt-2">';
        if(have_rows('acf_repeater_staff')):
          while(have_rows('acf_repeater_staff')) : the_row();
            echo '<div class="staff_box-single d-flex justify-content-center ">';
            $acf_staff_name = get_sub_field('acf_staff_name');
            $acf_staff_occupation = get_sub_field('acf_staff_occupation');
            $acf_staff_phone = get_sub_field('acf_staff_phone');
            $acf_staff_mail = get_sub_field('acf_staff_mail');

          	  if($acf_staff_picture_check):
                $acf_staff_image = get_sub_field('acf_staff_image');
                $img_size = 'img-290';
                echo '<div class="staff-profile_picture">'.wp_get_attachment_image($acf_staff_image, $img_size).'</div>';
              endif;
              echo '<h4>'.$acf_staff_name.'</h4>';
              echo '<p>'.$acf_staff_occupation.'</p>';
              if($acf_staff_phone && $acf_staff_mail):
                $phone_url = $acf_staff_phone['url'];
                $mail_url = $acf_staff_mail['url'];
                $phone_title = $acf_staff_phone['title'];
                $mail_title = $acf_staff_mail['title'];
              echo '<div class="d-flex flex-column contacts_singe-staff">';
                echo '<a href= "'.$phone_url.'" >'.$phone_title.'</a>';
                echo '<a href= "'.$mail_url.'" >'.$mail_title.'</a>';
              echo '</div>';
              endif;
            echo '</div>';
          endwhile;
        endif;
  echo '</div>';
echo '</section>';
