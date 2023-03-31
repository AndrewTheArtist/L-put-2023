<?php
$itemClass = 'career';
$itemID = get_the_ID();
$itemName = get_the_title();


$career_list = wp_get_post_terms($itemID, 'owners', array(
  'orderby'  => 'term_order',
  'order'    => 'ASC',
));

echo '<a class="career-view_single" href="'.get_permalink(get_the_ID()).'"><div class="'.$itemClass.'">';
  echo '<p class="fw-bold has-theme-primary-color">'. $itemName .'</p>';
  if(!empty($career_list)){
    $career_names = array();
    foreach($career_list as $name){
      $career_names[] = $name->name;
    }
    $career_output = join(' / ', $career_names);
    echo $career_output;
  }
echo '</div></a>';