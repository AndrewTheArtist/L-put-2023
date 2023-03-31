<?php
/**
 * Wide Map Block Template.
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
$className = 'block-map';
if ( ! empty( $block['className'] ) ) {
    $className .= ' '. $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $className .= ' align'. $block['align'];
}
if ( ! empty( $block['alignText'] ) ) {
    $className .= ' has-text-align-'. $block['alignText'];
}

// echo (get_the_ID());
$acf_map = get_field('acf_google_maps');
$lat = $acf_map['lat'];
$lng= $acf_map['lng'];
if($acf_map) {
    echo '<div class="acf-map">';
        echo '<div class="marker" data-lat="'.esc_attr($lat).'" data-lng="'.esc_attr($lng).'" ></div>';
    echo '</div>';

}

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
function initMap( $el ) {
// Find marker elements within map.
var $markers = $el.find('.marker');
// Create gerenic map.
var mapArgs = {
    zoom        : $el.data('zoom') || 10,
    mapTypeId   : google.maps.MapTypeId.ROADMAP
};
var map = new google.maps.Map( $el[0], mapArgs );

// Add markers.
map.markers = [];

$markers.each(function(){
        initMarker( $(this), map );
    });

// Center map based on markers.
centerMap( map );

// Return map instance.
return map;
}
/**
 * initMarker
 *
 * Creates a marker for the given jQuery element and map.
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @param   object The map instance.
 * @return  object The marker instance.
 */
function initMarker( $marker, map ) {
// Get position from marker.
var lat = $marker.data('lat');
var lng = $marker.data('lng');
console.log($marker.data('lat'));
var latLng = {
    lat: parseFloat( lat ),
    lng: parseFloat( lng )
};

// Create marker instance.
var marker = new google.maps.Marker({
    position : latLng,
    map: map
});

// Append to reference for later use.
map.markers.push( marker );

// If marker contains HTML, add it to an infoWindow.
if( $marker.html() ){

    // Create info window.
    var infowindow = new google.maps.InfoWindow({
        content: $marker.html()
    });

    // Show info window when marker is clicked.
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.open( map, marker );
    });
}
}
/**
 * centerMap
 *
 * Centers the map showing all markers in view.
 *
 * @date    22/10/19
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


