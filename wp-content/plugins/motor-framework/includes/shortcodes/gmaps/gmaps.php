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

if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! class_exists('Yolo_Framework_Shortcode_Gmaps') ) {
    class Yolo_Framework_Shortcode_Gmaps {
        function __construct() {
            add_shortcode( 'yolo_gmaps', array($this, 'yolo_gmaps_shortcode') );
        }

        function yolo_gmaps_front_scripts() {
        }

        function yolo_gmaps_shortcode($atts) {
            $this->yolo_gmaps_front_scripts();

            $atts  = vc_map_get_attributes( 'yolo_gmaps', $atts );
            $layout_type = $info_title = $info_image = $height = $lat = $lng = $zoom
            = $image = $expand_map = $light_map = $el_class = $yolo_animation = $css_animation = $duration = $delay =  '';
            extract(shortcode_atts(array(
                'layout_type'   => 'show_map',
                'info_title'    => 'My address',
                'info_image'    => '',
                'height'        => '400px',
                'lat'           => '40.843292',
                'lng'           => '-73.864512',
                'zoom'          => '14',
                'image'         => '', // Maker
                'expand_map'    => 'false',
                'light_map'     => 'basic',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
            ), $atts));
	        $yolo_options = yolo_get_options();
            $api_key = $yolo_options['google_api_key'];
            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_MotorFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_MotorFramework_Shortcodes::yolo_get_style_animation($duration, $delay);

            $styles_map = array(
                'basic'         => '[{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"visibility":"simplified"}]}]',
                'light_green'   => '[{"stylers":[{"hue":"#baf4c4"},{"saturation":10}]},{"featureType":"water","stylers":[{"color":"#effefd"}]},{"featureType":"all","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]}]',
                'shades_grey'   => '[{"featureType":"all","elementType":"geometry","stylers":[{"color":"#282727"}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]',
                'ultra_light'   => '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]',
            );

            ob_start();
            
            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));

            switch ($layout_type) {
                case 'show_map':
                    $template_path = $plugin_path . '/templates/show_map.php';
                    break;
                case 'toggle_button':
                    $template_path = $plugin_path . '/templates/toggle_button.php';
                    break;
                default:
                    $template_path = $plugin_path . '/templates/show_map.php';
            }

            ?>
            <?php if( ($lat != '') && ($lng != '') ) : ?>
            <div class="<?php echo esc_attr($yolo_animation); ?>" <?php if(!empty($styles_animation)):?>style = "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <?php include($template_path); ?>
            </div>
            <?php else : ?>
                <div class="gmaps-not-select"><?php echo esc_html__( 'Please select GMaps!', 'yolo-motor' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }
    }

    new Yolo_Framework_Shortcode_Gmaps();
}
?>