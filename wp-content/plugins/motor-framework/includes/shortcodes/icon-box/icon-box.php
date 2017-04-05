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

if ( ! class_exists('Yolo_Framework_Shortcode_Icon_Box') ) {
    class Yolo_Framework_Shortcode_Icon_Box {
        function __construct() {
            add_shortcode( 'yolo_icon_box', array($this, 'yolo_icon_box_shortcode') );
        }

        function yolo_icon_box_front_scripts() {

        }

        function yolo_icon_box_shortcode($atts) {
            $this->yolo_icon_box_front_scripts();

            $atts  = vc_map_get_attributes( 'yolo_icon_box', $atts );
            $type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons
            = $color = $custom_color = $title = $link = $description = $layout_type = $el_class = $yolo_animation = $css_animation = $duration = $delay =  '';
            extract(shortcode_atts(array(
                'type'             => '',
                'icon_fontawesome' => '',
                'icon_openiconic'  => '',
                'icon_typicons'    => '',
                'icon_entypo'      => '',
                'icon_linecons'    => '',
                'color'            => '',
                'custom_color'     => '',
                'title'            => '',
                'link'             => '',
                'description'      => '',
                'layout_type'      => 'style_1',
                'el_class'         => '',
                'css_animation'    => '',
                'duration'         => '',
                'delay'            => '',
            ), $atts));
	           
            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_MotorFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_MotorFramework_Shortcodes::yolo_get_style_animation($duration, $delay);

            // Enqueue needed icon font.
            vc_icon_element_fonts_enqueue( $type );
            $url = vc_build_link( $link );
            $iconClass = isset( ${'icon_' . $type} ) ? esc_attr( ${'icon_' . $type} ) : 'fa fa-adjust';
            $icon_color = $color;
            if( 'custom' === $color ) {
                $icon_color = esc_attr( $custom_color );
            }

            ob_start();
            
            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));

            switch ($layout_type) {
                case 'style_1':
                    $template_path = $plugin_path . '/templates/style_1.php';
                    break;
                case 'style_2':
                    $template_path = $plugin_path . '/templates/style_2.php';
                    break;
                case 'style_3':
                    $template_path = $plugin_path . '/templates/style_3.php';
                    break;
                case 'style_4':
                    $template_path = $plugin_path . '/templates/style_4.php';
                    break;
                default:
                    $template_path = $plugin_path . '/templates/style_1.php';
            }

            ?>
            <?php if( $iconClass != '' ) : ?>
            <div class="<?php echo esc_attr($yolo_animation); ?>" <?php if(!empty($styles_animation)):?>style = "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <?php include($template_path); ?>
            </div>
            <?php else : ?>
                <div class="icon-box-not-select"><?php echo esc_html__( 'Please select Icon Box!', 'yolo-motor' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }
    }

    new Yolo_Framework_Shortcode_Icon_Box();
}
?>