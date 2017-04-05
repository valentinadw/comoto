<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    26/1/2016
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! class_exists('Yolo_Framework_Shortcode_Recent_News') ) {
    class Yolo_Framework_Shortcode_Recent_News {
        function __construct() {
            add_shortcode('yolo_recent_news', array($this, 'yolo_recent_news_shortcode' ));
        }

        function yolo_recent_news_front_scripts() {
            wp_enqueue_style('slick', plugins_url() . '/motor-framework/includes/shortcodes/recent-news/assets/css/slick.css', array(),false);
            wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.carousel.min.css', array(),false);
            wp_enqueue_script('slick', plugins_url() . '/motor-framework/includes/shortcodes/recent-news/assets/js/slick.min.js', false, true);
            wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.carousel.min.js', false, true);
        }

        function yolo_recent_news_shortcode($atts) {
            $this->yolo_recent_news_front_scripts();

            $layout_type = $category = $columns = $rows = $posts_per_row = $autoplay = $slide_duration = $excerpt_length
             = $el_class = $yolo_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'layout_type'    => 'home_1',
                'category'       => '',
                'columns'        => '2',
                'rows'           => '1',
                'posts_per_row'  => '1',
                'autoplay'       => 'true',
                'slide_duration' => '1000',
                'posts_per_page' => '',
                'posts_number'   => '',
                'excerpt_length' => '',
                'el_class'       => '',
                'css_animation'  => '',
                'duration'       => '',
                'delay'          => '',
            ), $atts));

            $yolo_animation   .= ' ' . esc_attr($el_class);
            $yolo_animation   .= Yolo_MotorFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $styles_animation = Yolo_MotorFramework_Shortcodes::yolo_get_style_animation($duration, $delay);
            $yolo_options = yolo_get_options();

            $args = array(
                'posts_per_page' => $posts_per_page,
                'orderby'        => 'post_date',
                'order'          => 'DESC',
                'post_status'    => 'publish'
            );
            if(!empty($category)){
                $args['tax_query'] = array(
                  'relation' => 'AND',
                  array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $category),
                  ),
                ); 
            }

            $recent_news = new WP_Query($args);

            ob_start();

            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));

            switch ($layout_type) {
                case 'home_1':
                    $template_path = $plugin_path . '/templates/home_1.php';
                    break;
                case 'home_2':
                    $template_path = $plugin_path . '/templates/home_2.php';
                    break;
                case 'home_3':
                    $template_path = $plugin_path . '/templates/home_3.php';
                    break;
                case 'home_4':
                    $template_path = $plugin_path . '/templates/home_4.php';
                    break;
                case 'home_6':
                    $template_path = $plugin_path . '/templates/home_6.php';
                    break;
                default:
                    $template_path = $plugin_path . '/templates/home_1.php';
            }
            
        ?>  
        <?php if( $recent_news->have_posts() ) : ?>
            <div class="recent-news-<?php echo $layout_type . esc_attr($yolo_animation); ?>" <?php if(!empty($styles_animation)):?>style = "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
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

    new Yolo_Framework_Shortcode_Recent_News();
}