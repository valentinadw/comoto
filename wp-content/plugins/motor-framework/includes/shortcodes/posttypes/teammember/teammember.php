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

if ( ! class_exists('Yolo_Framework_Shortcode_Teammember') ) {
    class Yolo_Framework_Shortcode_Teammember {
        function __construct() {
            add_shortcode('yolo_teammember', array($this, 'yolo_teammember_shortcode' ));
        }

        function yolo_teammember_front_scripts() {
            wp_enqueue_style('teammember-style', plugins_url() . '/motor-framework/includes/shortcodes/posttypes/teammember/assets/css/style.css', array(),null);
            wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.carousel.min.css', array(),false);
            wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.carousel.min.js', false, true);
        }

        function yolo_teammember_shortcode($atts) {
            $this->yolo_teammember_front_scripts();
            $layout_type = $data_source = $category = $member_ids = $member_per_slide = $order  = $autoplay  = $slide_duration = $el_class = $yolo_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'layout_type'      => 'carousel',
                'data_source'      => '',
                'category'         => '',
                'member_ids'       => '',
                'member_per_slide' => '3',
                'order'            => 'DESC',
                'autoplay'         => 'true',
                'slide_duration'   => '1000',
                'el_class'         => '',
                'css_animation'    => '',
                'duration'         => '',
                'delay'            => '',
            ), $atts));

            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_MotorFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_MotorFramework_Shortcodes::yolo_get_style_animation($duration, $delay);

            $args = array(
                'orderby'        => 'post__in',
                'post__in'       => explode(",", $member_ids),
                'posts_per_page' => -1, // Unlimited member
                'post_type'      => 'yolo_teammember',
                'post_status'    => 'publish');

            if ($data_source == '') {
                $args = array(
                    'posts_per_page' => -1, // Unlimited member
                    'orderby'        => 'post_date',
                    'order'          => $order,
                    'post_type'      => 'yolo_teammember',
                    'team_category'  => strtolower($category),
                    'post_status'    => 'publish'
                );
                if(!empty($category)){
                    $args['tax_query'] = array(
                      'relation' => 'AND',
                      array(
                        'taxonomy' => 'team_category',
                        'field'    => 'slug',
                        'terms'    => explode(',', $category),
                      ),
                    ); 
                }
            }
            ob_start();

            $teammembers = new WP_Query($args);

            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));

            switch ($layout_type) {
                case 'carousel':
                    $template_path = $plugin_path . '/templates/carousel.php';
                    break;
                default:
                    $template_path = $plugin_path . '/templates/carousel.php';
            }
        ?>  
        <?php if( $teammembers->have_posts() ) : ?>
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

    new Yolo_Framework_Shortcode_Teammember();
}