<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Google_Map
 */
$image = $map_type = $map_image = $map_link = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


if($image) {
    $img_id = preg_replace('/[^\d]/', '', $image);
    $img_link = wp_get_attachment_image_src($img_id, 'thumbnail');
    $img_link = isset($img_link[0]) ? $img_link[0] : '';
} else {
    $img_link = get_template_directory_uri() . '/images/map-marker.png';
}
$width = $width == '' ? '100%' : $width;
$height = $height == '' ? '500px' : $height;
$zoom = $zoom == '' ? 9 : $zoom;
$scrollwheel = $scrollwheel == 'off' ? 'false' : 'true';

$locations = vc_param_group_parse_atts( $atts['locations'] );
$local = '';
foreach($locations as $val){
    $local = $val['latlng'];
    break;
}
$pix_map_style = 'jQuery("head").append("<style> #pix-map{width:'.esc_attr($width).';height:'.esc_attr($height).'}</style>");';
wp_add_inline_script( 'pixtheme-common', $pix_map_style );

$api_key = pixtheme_get_setting('pix-google-api');

?>


<?php if($api_key != '' && $map_type != 'img') : ?>
    
    <div class="pix-map-container">
        <div id="pix-map"></div>
    </div>
    
    <script async defer>
    
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', init);

    function init() {
        // Basic options for a simple Google Map
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: <?php echo esc_js($zoom) ?>,

            // The latitude and longitude to center the map (always required)
            center: new google.maps.LatLng(<?php echo esc_js($locations[0]['latlng']) ?>), // New York

            scrollwheel: <?php echo esc_js($scrollwheel) ?>,


            // How you would like to style the map.
            // This is where you would paste any style found on Snazzy Maps.
            styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
        };

        // Get the HTML DOM element that will contain your map
        // We are using a div with id="map" seen below in the <body>
        var mapElement = document.getElementById('pix-map');

        var locations = [];
        <?php
            foreach($locations as $val){
                $description = !isset($val['description']) ? '' : $val['description'];
                ?>
                locations.push([<?php echo esc_js($val['latlng'])?>, '<?php echo esc_js($description)?>']);
                <?php
            }
        ?>;

        // Create the Google Map using our element and options defined above
        var map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var image = '<?php echo esc_url($img_link) ?>';

        var bounds = new google.maps.LatLngBounds();
        var infowindow = new google.maps.InfoWindow();

        for (var i = 0; i < locations.length; i++) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][0], locations[i][1]),
                map: map,
                icon: image
            });

            bounds.extend(marker.position);

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][2]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
        map.fitBounds(bounds);

        var listener = google.maps.event.addListener(map, "idle", function () {
            map.setZoom(<?php echo esc_js($zoom) ?>);
            google.maps.event.removeListener(listener);
        });
    }

    </script>

<?php elseif($map_type == 'img') :
    $map_img_link = $href_before = $href_after = '';
    $href = vc_build_link( $map_link );
    $target = empty($href['target']) ? '' : 'target="'.esc_attr($href['target']).'"';
    if($map_image) {
        $map_img_id = preg_replace('/[^\d]/', '', $map_image);
        $map_img_link = wp_get_attachment_image_src($map_img_id, 'full');
        $map_img_link = $map_img_link[0];
    }
    
    if(!empty( $href['url'] )){
        $href_before = '<a ' . wp_kses_post($target) . ' href="' . esc_url($href['url']) . '">';
        $href_after = '</a>';
    }
    ?>
    <div class="pix-map-container">
        <?php echo wp_kses_post($href_before); ?>
        <div id="pix-map" style="background-image: url(<?php echo esc_url($map_img_link)?>);"></div>
        <?php echo wp_kses_post($href_after); ?>
    </div>

<?php else :
    $map_image = pixtheme_get_option('style_theme_tone', '') == '' ? 'gmap.jpg' : 'gmap-black.jpg';
    ?>
    <div class="pix-map-container">
        <div id="pix-map" style="background-image: url(<?php echo esc_url(get_template_directory_uri() . '/images/'.$map_image)?>);"></div>
    </div>
    
<?php endif; ?>