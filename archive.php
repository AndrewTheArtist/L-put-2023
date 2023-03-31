<?php
/*
Template Name: Archives
*/

get_header();

echo '<section class="alignmax a_sub_container">';
  echo '<div class=" alignmax b_sub_tcontainer">';
      echo '<h1>'.get_the_archive_title().'</h1>';
  echo '</div>';
echo '</section>';


$args = array(
  'post_type'           => 'careers',
  'post_status'         => array('publish'),
  'posts_per_page'      => -1,
  'ignore_sticky_posts' => true,
  'order'               => 'ASC',
  'orderby'             => 'menu_order'
);

$gutenberg_loop = new WP_Query( $args );
if( !is_admin() && $gutenberg_loop->have_posts()) {
  $terms = get_terms('owners', array(
      'hide_empty' => true
));


echo '<div class="container">';
  if(! empty($terms)){
    echo '<div class="team-filter__area d-flex flex-wrap">';
      echo '<button type="button" data-mixitup-control data-filter="all" class="mixitup-control-active">'. __('Kõik Karjäärid', 'ama') .'</button>';
        foreach ($terms as $term) :
          $term_slug = $term->slug;
          $term_name = $term->name;
            echo '<button type="button" data-mixitup-control data-filter=".'.$term_slug.'">'. $term_name .'</button>';
        endforeach;
    echo '</div>';
  }
  echo '<div class="careers-list">';
    while($gutenberg_loop->have_posts() ){
      $gutenberg_loop->the_post();

      $tm_groups = wp_get_post_terms(get_the_ID(), 'owners');
      $group_slugs = wp_list_pluck($tm_groups, 'slug');
      $class_names = join(' ', $group_slugs);
      $link = get_permalink(get_the_ID());
    if( $class_names ){
      echo '<div class="flex-item mix '. $class_names .'">';
    }else {
      echo '<div class="flex-item mix">';
    }
      include( locate_template('partials/list-career.php') );
    echo '</div>';
    }
      echo '</div>';
  echo '</div>';
  
echo '</div>';


}
wp_reset_postdata();

get_footer();
?>