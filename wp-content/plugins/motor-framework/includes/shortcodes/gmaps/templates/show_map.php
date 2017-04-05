<?php
/**
 *  
 * @package    YoloTheme/Yolo Motor
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

$mapid = 'yolo-gmaps-' . uniqid();
if(!empty($api_key)):
?>
<div class="<?php echo $layout_type; ?> gmaps-shortcode-wrap">
    <div class="frame-map">
        <div id="<?php echo esc_attr($mapid);?>" style="height: <?php echo esc_attr($height);?>"></div>
    </div>
</div>
<script type="text/javascript">
    var map;
    var style_layout    = '<?php echo esc_html($layout_type);?>';
    var mapid           = '<?php echo esc_js($mapid);?>';
    var info_window     =   '<div class="map-info">'+
                                '<div class="info-image">'+
                                    '<img src="<?php echo wp_get_attachment_url( $info_image );?>" alt="">'+
                                '</div>'+
                                '<div class="info-address">'+
                                    '<p>'+
                                        '<?php echo esc_js($info_title); ?>'+
                                    '</p>'+
                                '</div>'+
                            '</div>';
    var zoom            = parseInt('<?php echo esc_js($zoom);?>');
    var imageurl        = '<?php echo wp_get_attachment_url( $image );?>';

    function initMap() {
        var latlng = new google.maps.LatLng(<?php echo esc_js($lat." , ".$lng) ?>);
        map = new google.maps.Map(document.getElementById(mapid), {
            center: latlng,
            zoom: zoom,
            scrollwheel: false,
            styles: <?php echo $styles_map[$light_map];?>
        });
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: '<?php echo esc_js($info_title); ?>',
            icon: imageurl
        });
        var infowindow = new google.maps.InfoWindow({
            content: info_window
        });
        if ( info_window != '') {
            infowindow.open(map, marker);
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
        }
        // Responsive
        google.maps.event.addDomListener(window, 'resize', function() {
            center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center); 
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc_html($api_key);?>&callback=initMap"
  type="text/javascript"></script>
  <?php else:
    echo '<p class = "message">'.esc_html('Please add Google API Key for Maps Jvascript API').'</p>';
    endif;
  ?>