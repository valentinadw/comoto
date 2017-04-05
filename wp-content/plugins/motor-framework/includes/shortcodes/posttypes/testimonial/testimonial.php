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

if ( ! class_exists('Yolo_Framework_Shortcode_Testimonial') ) {
    class Yolo_Framework_Shortcode_Testimonial {
        function __construct() {
            add_shortcode('yolo_testimonial', array($this, 'yolo_testimonial_shortcode' ));
        }

        function yolo_testimonial_front_scripts() {
            wp_enqueue_style('slider-pro', plugins_url() . '/motor-framework/includes/shortcodes/posttypes/testimonial/assets/css/slider-pro.min.css', array(),false);
            wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.carousel.min.css', array(),false);
            wp_enqueue_script('slider-pro', plugins_url() . '/motor-framework/includes/shortcodes/posttypes/testimonial/assets/js/jquery.sliderPro.min.js', false, true);
            wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.carousel.min.js', false, true);
        }

        function yolo_testimonial_shortcode($atts) {
            $this->yolo_testimonial_front_scripts();

            $layout_type = $data_source = $category = $testimonial_ids = $order  = $autoplay  = $slide_duration = $el_class = $yolo_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'layout_type'     => 'carousel',
                'data_source'     => '',
                'category'        => '',
                'testimonial_ids' => '',
                'order'           => 'DESC',
                'autoplay'        => 'true',
                'slide_duration'  => '1000',
                'el_class'        => '',
                'css_animation'   => '',
                'duration'        => '',
                'delay'           => '',
                'excerpt_length'  => '20',
            ), $atts));

            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_MotorFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_MotorFramework_Shortcodes::yolo_get_style_animation($duration, $delay);
            $yolo_options = yolo_get_options();

            $args = array(
                'orderby'        => 'post__in',
                'post__in'       => explode(",", $testimonial_ids),
                'posts_per_page' => -1, // Unlimited testimonial
                'post_type'      => 'yolo_testimonial',
                'post_status'    => 'publish');

            if ($data_source == '') {
                $args = array(
                    'posts_per_page'       => -1, // Unlimited testimonial
                    'orderby'              => 'post_date',
                    'order'                => $order,
                    'post_type'            => 'yolo_testimonial',
                    'post_status'          => 'publish');
                if(!empty($category)){
                    $args['tax_query'] = array(
                      'relation' => 'AND',
                      array(
                        'taxonomy' => 'testimonial_category',
                        'field'    => 'slug',
                        'terms'    => explode(',', $category),
                      ),
                    );
                }
            }
            ob_start();

            $testimonials = new WP_Query($args);

            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));

            switch ($layout_type) {
                case 'carousel':
                    $template_path = $plugin_path . '/templates/carousel.php';
                    break;
                case 'carousel_2':
                    $template_path = $plugin_path . '/templates/carousel_2.php';
                    break;
                case 'slider_pro':
                    $template_path = $plugin_path . '/templates/slider_pro.php';
                    break;
                case 'slider_pro_2':
                    $template_path = $plugin_path . '/templates/slider_pro_2.php';
                    break;
                default:
                    $template_path = $plugin_path . '/templates/slider_pro.php';
            }
        ?>  
        <?php if( $testimonials->have_posts() ) : ?>
            <div class="<?php echo esc_attr($yolo_animation); ?>" <?php if(!empty($styles_animation)):?>style = "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
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

    new Yolo_Framework_Shortcode_Testimonial();
}