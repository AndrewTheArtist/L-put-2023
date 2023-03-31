<?php
/**
* The category template file
**/
get_header();

$entryID = get_queried_object();
$entryTitle = single_cat_title('', false);

echo '<h1 class="entry-header">'. $entryTitle .'</h1>';

if ( have_posts() ) :
    echo '<div class="ama-block block-posts">';
        while ( have_posts() ) : the_post();
            include( locate_template('partials/list-post.php') );
        endwhile;

        if ( function_exists('wp_bootstrap_pagination')) wp_bootstrap_pagination();
    echo '</div>';
endif;


get_footer();