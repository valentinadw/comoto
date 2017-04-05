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

if ( ! class_exists('Yolo_Framework_Shortcode_Banner') ) {
    class Yolo_Framework_Shortcode_Banner {
        function __construct() {
            add_shortcode( 'yolo_banner', array($this, 'yolo_banner_shortcode') );
        }

        function yolo_banner_front_scripts() {
        }

        function yolo_banner_shortcode($atts) {
            $this->yolo_banner_front_scripts();

            $atts  = vc_map_get_attributes( 'yolo_banner', $atts );
            $title = $link = $image = $label = $layout_type = $title_type = $shadow_type = $el_class = $yolo_animation = $css_animation = $duration = $delay =  '';
            extract(shortcode_atts(array(
                'title'         => '',
                'link'          => '',
                'image'         => '',
                'label'         => '',
                'layout_type'   => '',
                'title_type'    => '',
                'shadow_type'   => '',
                'el_class'      => '',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
                'bg_lable_color'=> '',
                'price'         => '',
                'title_align'   => '',
            ), $atts));
	           
            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_MotorFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_MotorFramework_Shortcodes::yolo_get_style_animation($duration, $delay);
            $url              = vc_build_link( $link );

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
                case 'style_5':
                    $template_path = $plugin_path . '/templates/style_5.php';
                    break;
                case 'style_6':
                    $template_path = $plugin_path . '/templates/style_6.php';
                    break;
                case 'style_7':
                    $template_path = $plugin_path . '/templates/style_7.php';
                    break;
                case 'style_8':
                    $template_path = $plugin_path . '/templates/style_8.php';
                    break;
                default:
                    $template_path = $plugin_path . '/templates/style_1.php';
            }

            ?>
            <?php if( $image != '' ) : ?>
            <div class="<?php echo esc_attr($yolo_animation); ?>" <?php if(!empty($styles_animation)):?>style = "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <?php include($template_path); ?>
            </div>
            <?php else : ?>
                <div class="banner-not-select"><?php echo esc_html__( 'Please select image for banner!', 'yolo-motor' ); ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }
    }

    new Yolo_Framework_Shortcode_Banner();
}
?>