<?php
$itemClass = 'post-item';
$itemID = get_the_ID();
$itemName = get_the_title();
$itemDesc = get_the_excerpt();
$itemLink = get_the_permalink();
$thumbsize = 'thumbnail';
echo '<article id="post-'. $itemID .'" class="'. $itemClass .' position-relative h-100">';
    echo '<a href="'. $itemLink. '" class="'. $itemClass .'__thumb d-block position-relative">';
        if ( has_post_thumbnail() ) {
            the_post_thumbnail( $thumbsize );
        } else {
            $acf_fallback_thumbnail = get_field('acf_fallback_thumbnail', 'option');
            if( $acf_fallback_thumbnail ){
                echo ama_get_fallback( $acf_fallback_thumbnail, $thumbsize );
            }
        }
    echo '</a>';
    echo '<p class="has-medium-font-size font-weight-bold"><a href="'. $itemLink. '">'. $itemName .'</a></p>';
    echo $itemDesc ? '<p>'. $itemDesc .'</p>' : '';
    echo '<a href="'. $itemLink. '" class="rm-link">', _e('Read more', 'ama') ,'<svg xmlns="http://www.w3.org/2000/svg" width="7.811" height="14.121" viewBox="0 0 7.811 14.121"><path d="M10378-14993l6,6-6,6" transform="translate(-10376.939 14994.061)" fill="none" stroke="#f5793b" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg></a>';
echo '</article>';
?>