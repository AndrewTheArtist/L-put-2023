<?php
/**
* The main template file
**/

use MyThemeShop\Helpers\Arr;
use RankMath\Schema\Block;

use function Nextgenthemes\ARVE\Common\ver;

get_header();
if( is_front_page() ){
    $entryID = get_option('page_on_front');
    $entryTitle = get_the_title( $entryID );
} elseif( is_home() ){
    $entryID = get_option('page_for_posts');
    $entryTitle = get_the_title( get_option('page_for_posts', true) );
} elseif( is_post_type_archive() ){
    $post_type_obj = get_post_type_object( get_post_type() );
    $entryTitle = apply_filters('post_type_archive_title', $post_type_obj->labels->name );
} else {
    $entryID = get_the_ID();
    $entryTitle = get_the_title();
}

// Some Super dimm get_header code

$className = 'element-hero';

$acf_hero_text = get_field('acf_hero_text');
$acf_hero_button = get_field('acf_hero_button');

$sliderAttr = [
    'type' => 'loop',
    'perPage' => 1,
    'arrows' => false,
    'pagination' => false,
    'width' => '100vw',
    'height' => '100vh',
    'cover' => true,
    'padplay' => false,
    'interval' => 8000
];

$sliderAttr2 = [
    'type' => 'slide',
    'perPage' => 6,
    'isNavigation' => true,
    'pagination' => false,
    'arrows' => false,
];

if(is_front_page()){ 
// Slider View Build
$acf_hero_repeater = get_field('acf_hero_repeater', 'option');
if($acf_hero_repeater){
    echo '<div class="alignmax bound-splide position-relative">';
        echo '<div class="acf-block-element element-hero alignmax hero-xxl splide primary__splide" data-splide='.json_encode($sliderAttr).'>';
            echo '<div class="splide__track alignmax">';
                echo '<ul class="splide__list alignmax ">';
                foreach($acf_hero_repeater as $repeater){
                    $image = $repeater['acf_repeater_slide'];
                    echo '<div class="l-hero__lg alignmax splide__slide">'.wp_get_attachment_image($image, 'full').'</div>';
                    $image_option = $repeater['acf_repeater_nav_color'];
                    }
                    
                
                echo '</ul>';
            echo '</div>';
        echo '</div>';
        echo '<div class="container position-relative">';
            echo '<div class="hero__title position-absolute">';
                echo '<h1>'.$acf_hero_text.'</h1>';
                echo '<div class="wp-block-button"><a href="'.$acf_hero_button['url'].'" class="wp-block-button__link wp-element-button hero-button">'.$acf_hero_button['title'].'</a></div>';
            echo '</div>';
        echo '</div>';
        
        echo '<div class="secondary__splide splide" data-splide='.json_encode($sliderAttr2).'>';
            echo '<div class="splide__track" style="padding-top:1.5rem;">';
                echo '<ul class="splide__list logical-list">';
                foreach($acf_hero_repeater as $repeater){
                    $text = $repeater['acf_repeater_slide_text'];
                    echo '<div class="splide__slide second-hero_slide"><p>'.$text.'</p></div>';
                }
                echo '</ul>';
            echo '</div>';
        echo '</div>';
        echo '<div class="position-absolute bg_svg-container">';
            echo '<svg class="hero-svg" xmlns="http://www.w3.org/2000/svg" width="900" height="1000" viewBox="0 0 520 360"><path id="k-white" d="M388.612,332.688,431.07,284.43c49.777,46.791,77.172,82.548,90.617,153.86,48.038-42.611,78.1-94.608,96.844-143.449,7.015,17.486,26.2,54.43,34.532,66.63C629.529,401.047,597.908,465.3,530.036,509.944c80.912-.2,115.727,13.085,210.671,66.589L675.646,610.14c-59.663-31.174-83.965-31.877-143.224-36.2-18.479,73.563-40.7,151.991-90.091,232.489l-61.624-35.837c80.65-96.4,137.057-308.183,7.9-437.9Z" transform="translate(-380.707 -284.43)" fill="'.$svg_fill.'" fill-rule="evenodd"/></svg>';
        echo '</div>';
    echo '</div>';
} else{
    echo '<h1 style="color:#fff;">No Images</h1>';
}


// Career Pin Icons
    echo '<section class="container row block_none_binary">';
        echo '<div class="none_binary_sm_sub_cnt col-sm-2">';
            echo '<p class="above_map_title">'.__('Karjäärid').'</p>';
            echo '<div class="d-grid">';
            echo '<span><svg enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#EE1C25"><path  d="m12 0c-4.962 0-9 4.066-9 9.065 0 7.103 8.154 14.437 8.501 14.745.143.127.321.19.499.19s.356-.063.499-.189c.347-.309 8.501-7.643 8.501-14.746 0-4.999-4.038-9.065-9-9.065zm0 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"/></svg><p class="filter-text-custom">Kiviluks karjäär</P></span>';
            echo '<span><svg enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="m12 0c-4.962 0-9 4.066-9 9.065 0 7.103 8.154 14.437 8.501 14.745.143.127.321.19.499.19s.356-.063.499-.189c.347-.309 8.501-7.643 8.501-14.746 0-4.999-4.038-9.065-9-9.065zm0 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"/></svg>Kivikandur karjäär</span>';
            echo '</div>';

        echo '</div>';

        // Careers List Start
        echo '<div class=" d-grid col-sm-10">';
            $argsLuks = array('post_type' => 'careers','tax_query' => array(array('taxonomy' => 'owners', 'field' => 'slug', 'terms' => array('karjaar-kiviluks'))));
            $argsKandur = array('post_type' => 'careers','tax_query' => array(array('taxonomy' => 'owners', 'field' => 'slug', 'terms' => array('karjaar-kivikandur'))));
        
            $queryLuks = new WP_Query($argsLuks);
            $queryKandur = new WP_Query($argsKandur);
            // echo $argsLuks['tax_query'][0]['terms'][0];
            if($queryLuks->have_posts()){
                echo '<div class="d-flex list_sub_content_above">';
                while($queryLuks->have_posts()){
                    $queryLuks->the_post();
                    echo '<p><a href="'.get_permalink().'">'.get_the_title().' ► </a></p>';
                }
                echo '</div>';
            }
            if($queryKandur->have_posts()){
                echo '<div class="d-flex list_sub_content_below">';
                while($queryKandur->have_posts()){
                    $queryKandur->the_post();
                    echo '<p><a href="'.get_permalink().'">'.get_the_title().' ► </a></p>';
                }
                echo '</div>';
            }
            wp_reset_postdata();
        echo '</div>';
    echo '</section>';


// Filter Seciton Start
    echo '<section id="index_map_filter" class="container container_career_filter">';
    $args = get_terms(['taxonomy' => 'specifics', 'hide_empty'=> false]);
        foreach($args as $arg){
            echo '<a class="career_filter_button" href="#" data-filter_id="' . $arg->term_id . '"><p>'.$arg->name.'</p></a>';
        }
    echo '</section>';   


// Map section Start 

    $postQuery = new WP_Query( array( 'post_type' => 'careers', 'post_status'=> array('publish'), 'posts_per_page' => 100, 'order'=> 'menu_order' ));
    if($postQuery->have_posts()) :  
        while($postQuery->have_posts()):
        $postQuery->the_post();
        $the_ID = get_the_ID();
        $blocks = parse_blocks($post->post_content);

        $specifics = [];

        $terms = wp_get_post_terms($the_ID, 'specifics');

        if($terms) {
            foreach($terms as $term) $specifics[] = $term->term_id;
        }


        foreach($blocks as $block){
            if('ama/map' === $block['blockName']){
                $lng = floatval(($block['attrs']['data']['acf_google_maps']['lng']));
                $lat = floatval(($block['attrs']['data']['acf_google_maps']['lat']));
                $title =  get_the_title();
                $link = get_permalink();
                
            }
            $Oterms = get_the_terms($the_ID, 'owners');
            foreach ($Oterms as $Oterm){
                $Oterm_name = $Oterm->name;  
            }
            if(str_contains($Oterm_name, 'Kivikandur')){
                // Class passing to jQuery
                $category_name = 'marker_kivikandur';
                // Class passing to jQuery
                $name = get_field('acf_name_kandur', 'option');
                $number = get_field('acf_number_kandur', 'option');
                $email = get_field('acf_email_kandur', 'option');
            }
            if(str_contains($Oterm_name, 'Kiviluks')){
                // Class passing to jQuery
                $category_name = 'marker_kiviluks';
                // Class passing to jQuery
                $name = get_field('acf_name_luks', 'option');
                $number = get_field('acf_number_luks', 'option');
                $email = get_field('acf_email_luks', 'option');
            }
        }
        
        $output_map[$the_ID]['map'] = '<div class="'.$category_name.' info_window" data-specifics="' . implode('|', $specifics) . '" data-lat="'.esc_attr($lat).'" data-lng="'.esc_attr($lng).'">
        <h3>'.$title.'</h3>
        <p class="map_single_term">('.$Oterm_name.')</p>
        <div class="container_contact_pin_map">
            <p>'.$name.'</p>
            <p><a id="secondary_link" href="tel:'.$number.'">'.$number.'</a></p>
            <p><a id="secondary_link" href="mailto:'.$email.'">'.$email.'</a></p>
        </div>

        <p class="map_container_bottom_link"><a id="secondary_link" href="'.$link.'" >'.__('Vaata hindu ja detaile ►').'</a></p>
        
        </div>';

        endwhile;
    endif;
    wp_reset_postdata();
    echo '<div class="alignmax google_map">';
        echo '<div class="acf-map" data-filter="index_map_filter">';
            foreach ($output_map as $map_marker):
                echo ($map_marker['map']);
            endforeach;
        echo '</div>';
    echo '</div>';


}

if(is_front_page()){ 
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzHNLvMwhMnECwjBdusDSlVw-JIv68d9Q"></script>
<script type="text/javascript">
(function( $ ) {

/**
 * initMap
 *
 * Renders a Google Map onto the selected jQuery element
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @return  object The map instance.
 */

var path = 'm16 0c-6.616 0-12 5.421-12 12.087 0 9.471 10.872 19.249 11.335 19.66.191 .169.428 .253.665 .253s.475-.084.665-.252c.463-.412 11.335-10.191 11.335-19.661 0-6.665-5.384-12.087-12-12.087zm0 18.667c-3.676 0-6.667-2.991-6.667-6.667s2.991-6.667 6.667-6.667 6.667 2.991 6.667 6.667-2.991 6.667-6.667 6.667z';

function initMap( $el ) {
    var marker;
    var infowindow = new google.maps.InfoWindow();

    // Find marker elements within map.
    var $markersKandur = $el.find('.marker_kivikandur');
    var $markersLuks = $el.find('.marker_kiviluks');

    var filter_block;
    if($el.data('filter')) {
        var block = $('#' + $el.data('filter'));
        if(block.length) filter_block = block;
    }

    // Create gerenic map.
    var mapArgs = {
        zoom        : $el.data('zoom'),
        mapTypeId   : google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map( $el[0], mapArgs );

    // Add markers.
    map.markers = [];

    var icon = {
        path: path,
        fillColor:"#000", 
        fillOpacity: 1  
    };

    $markersKandur.each(function(){
        marker = initMarker( $(this), map ,icon );
        if(marker) map.markers.push(marker);
    });

    icon = {
        path: path,
        fillColor:"#EE1C25", 
        fillOpacity: 1,
        strokeWeight: 1,
        strokeColor: "#EE1C25",
    };

    $markersLuks.each(function(){
        marker = initMarker( $(this), map,icon );
        if(marker) map.markers.push(marker); 
    });

    // Center map based on markers. 
    centerMap( map ); 

    for(var i=0; i<map.markers.length; i++) {
        marker = map.markers[i];
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.close();

            marker = this;
            var position = marker.getPosition();
            infowindow.setPosition(position);
            infowindow.setContent(marker['content']);
            infowindow.open({
                map: map
            });
        });
    }
    
    if(filter_block) {
        var filter_buttons = filter_block.find('.career_filter_button');
        var selected = [], index;

        var filter = function() {
            var show = false;
            if(!selected.length) show = true;

            for(var i=0; i<map.markers.length; i++) {
                var show_ = false;
                marker = map.markers[i];

                if(show) {
                    marker.setMap(map);
                    continue;
                }

                for(var j=0; j<selected.length; j++) {
                    var key = '' + selected[j];
                    if(marker['specifics'].indexOf(key) !== -1) {
                        show_ = true;
                        break;
                    }
                }

                if(show_) {
                    marker.setMap(map);   
                } else {
                    marker.setMap(null);
                }

            }
        }

        var filter_active = function(e) {
            e.preventDefault();

            var el = $(this);
            var id = +el.data('filter_id');

            if(el.hasClass('active')) {
                el.removeClass('active');
                index = selected.indexOf(id);
                if(index !== -1) selected.splice(index, 1);
            } else {
                el.addClass('active');
                selected.push(id);
            }

            filter();
        }

        filter_block.find('.career_filter_button').on('click', filter_active);
    }
    // Return map instance.
    return map;
}

/**
 * initMarkerKandur
 * @date    11/30/2022
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @param   object The map instance.
 * @return  object The marker instance.
 */
function initMarker( $marker, map, icon ) {

    // Get position from marker.
    var lat = $marker.data('lat');
    var lng = $marker.data('lng');

    var latLng = {
        lat: parseFloat( lat ),
        lng: parseFloat( lng ), 
    };

    
    // Create marker instance 1.
    var marker = new google.maps.Marker({
        position : latLng,
        map: map, 
        icon: icon
    });

    marker['specifics'] = [];

    var specifics = '' + $marker.data('specifics');

    if(specifics) marker['specifics'] = specifics.split('|');
 
    marker['content'] = '';

    // Append to reference for later use.
    // If marker contains HTML, add it to an infoWindow.
    if( $marker.html() ){
        marker['content'] = $marker.html();
    }
   
    return marker;
}

/**
 * centerMap
 *
 * Centers the map showing all markers in view.
 *
 * @date    11/30/22
 * @since   5.8.6
 *
 * @param   object The map instance.
 * @return  void
 */
function centerMap( map ) {

    // Create map boundaries from all map markers.
    var bounds = new google.maps.LatLngBounds();
    map.markers.forEach(function( marker ){
        bounds.extend({
            lat: marker.position.lat(),
            lng: marker.position.lng()
        });
    });

    // Case: Single marker.
    if( map.markers.length == 1 ){
        map.setCenter( bounds.getCenter() );

    // Case: Multiple markers.
    } else{
        map.fitBounds( bounds );
    }
}

// Render maps on page load.
$(document).ready(function(){
    $('.acf-map').each(function(){
        var map = initMap( $(this) );
    });
});

})(jQuery);
</script>
<?php } ?>


<?php 
// Light get more dimm when it more further away
if( is_home() ){
    if( is_home() ){
        $post = get_post( $entryID );
        $the_content = apply_filters('the_content', $post->post_content);
        if ( !empty($the_content) ) {
            echo $the_content;
        }
    }

    if ( have_posts() ) :
        echo '<div class="ama-block block-posts">';
            while ( have_posts() ) : the_post();
                    include( locate_template('partials/list-post.php') );
            endwhile;

            if ( function_exists('wp_bootstrap_pagination')) wp_bootstrap_pagination();
        echo '</div>';
    endif;
    
} elseif( is_post_type_archive() ) {
    if ( have_posts() ) :
        echo '<div class="ama-block block-posts">';
            while ( have_posts() ) : the_post();
                    include( locate_template('partials/list-post.php') );
            endwhile;

            if ( function_exists('wp_bootstrap_pagination')) wp_bootstrap_pagination();
        echo '</div>';
    endif;

} else {
    if ( have_posts() ) :
        while ( have_posts()) : the_post();
            if(!is_front_page()){
                echo '<section class="alignmax a_sub_container">';
                    echo '<div class=" alignmax b_sub_tcontainer">';
                        echo '<h1>'.get_the_title(get_the_ID()).'</h1>';
                    echo '</div>';
                echo '</section>';
            }
            the_content();
        endwhile;
    endif;

}

get_footer();

