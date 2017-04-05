<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    12/1/2016
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! class_exists('Yolo_Framework_Shortcode_SingleProduct') ) {
    class Yolo_Framework_Shortcode_SingleProduct {
        function __construct() {
            add_shortcode( 'yolo_single_product', array($this, 'yolo_single_product_shortcode') );
        }

        function yolo_single_product_shortcode($atts) {
            $atts  = vc_map_get_attributes( 'yolo_single_product', $atts );
            $product_style = $action_tooltip = $action_disable =  $id = $product_brand = $product_brand_logo = $el_class = $yolo_animation = $css_animation = $duration = $delay =  '';
            extract(shortcode_atts(array(
                'product_style'      => '',
                'action_tooltip'     => '',
                'action_disable'     => '',
                'id'                 => '',
                'product_brand'      => '',
                'product_brand_logo' => '',
                'el_class'           => '',
                'css_animation'      => '',
                'duration'           => '',
                'delay'              => '',
                'images_style'       => '',
            ), $atts));
	           
            $styles_animation = Yolo_MotorFramework_Shortcodes::yolo_get_style_animation($duration, $delay);
            
            $class            = array('shortcode-single-product-wrap');
            $class[]          = $el_class;
            $class[]          = Yolo_MotorFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $class_name       = join(' ',$class);

            ob_start();
            
            $product = new WP_Query( 
                array( 
                    'p'         => $id,
                    'post_type' => 'product'
                ) 
            );

            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));

            switch ($product_style) {
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
            <?php if( $product->have_posts() ) : ?>
            <div class="<?php echo esc_attr($class_name) ?>" <?php if(!empty($styles_animation)):?>style = "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <?php include($template_path); ?>
            </div>
            <?php else : ?>
                <div class="item-not-found"><?php echo esc_html__( 'No item found', 'yolo-motor' ) ?></div>
            <?php endif; ?>
        <?php
            $content =  ob_get_clean();
            return $content;         
        }
    }

    new Yolo_Framework_Shortcode_SingleProduct();
}
?>