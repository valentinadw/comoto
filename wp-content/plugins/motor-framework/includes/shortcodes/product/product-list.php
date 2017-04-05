<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    22/1/2016
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! class_exists('Yolo_Framework_Shortcode_Products_List') ) {
    class Yolo_Framework_Shortcode_Products_List {
        function __construct() {
            add_shortcode('yolo_products_list', array($this, 'yolo_products_list_shortcode' ));
        }

        function yolo_products_list_shortcode($atts) {
            global $woocommerce_loop, $woocommerce;      

            $atts  = vc_map_get_attributes( 'yolo_products_list', $atts );
            $data_source = $category = $product_ids = $product_style = $action_tooltip = $action_disable = $paging_style = $per_page = $paging_align = $orderby = $order = $el_class = $css_animation = $duration = $delay =  '';
            extract(shortcode_atts(array(
                'data_source'        => '',
                'category'           => '',
                'product_ids'        => '',
                'product_style'      => 'style_1',
                'action_tooltip'     => '',
                'action_disable'     => '',
                'per_page'           => '4',
                'paging_style'       => 'default', // page number
                'paging_align'       => 'center',
                'orderby'            => 'date',
                'order'              => 'asc',
                'el_class'           => '',
                'css_animation'      => '',
                'duration'           => '',
                'delay'              => ''
            ), $atts));

            if (is_front_page()) {
                $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
            } else {
                $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
            }

            $class                  = array('shortcode-product-wrap');
            $class[]                = 'list';
            $class[]                = $el_class;
            $class[]                = Yolo_MotorFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $class_name             = join(' ',$class);
            $styles_animation       = Yolo_MotorFramework_Shortcodes::yolo_get_style_animation($duration,$delay);
            $product_wrap_class     = array('product-wrap');
            $woocommerce_loop['columns'] = '1'; // Use in loop template
            $woocommerce_loop['layout_type'] = 'list'; // Use in loop template
            
            $product_class          = array('product-inner','clearfix');
            $product_class[]        = 'product-style-list';
            $product_class[]        = 'product-paging-' . $paging_style;
            
            $product_paging_class   = array('product-paging-wrapper');
            $product_paging_class[] = 'product-paging-'.$paging_style;
            $product_paging_class[] = 'text-' . $paging_align;
            
            // Get products
            $args = array(
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                'order'               => $order,
                'posts_per_page'      => $per_page,
                'paged'               => $paged
            );

            if ( ! empty($category) ) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms'    => array_map('sanitize_title', explode(',', $category)),
                        'field'    => 'slug',
                        'operator' => 'IN'
                    )
                );
            }

            // If data_source = product_IDs
            if ( $data_source == 'product_list_id' ) {
                 $args = array(
                    'post_type'      => 'product',
                    'post_status'    => 'publish',
                    'order'          => $order,
                    'posts_per_page' => $per_page,
                    'post__in'       => explode( ',' , $product_ids ),
                );
            }
            switch ( $orderby ) {
                case 'title':
                    $args['orderby']  = 'title';
                    break;
                case '_featured':
                    $args['meta_key']  = '_featured';
                    break;
                case 'rating' :
                    // Sorting handled later though a hook
                    add_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
                    break;
                case 'date' :
                    $args['orderby']  = 'date';
                    break;
                case 'rand' :
                    $args['orderby']  = 'rand';
                    break;
                case 'price':
                    $args['meta_key'] = '_price';
                    $args['orderby'] = 'meta_value_num';
                    break;
                default :
                     $ordering_args = $woocommerce->query->get_catalog_ordering_args($orderby, $order);
                     $args['orderby'] = $ordering_args['orderby'];
                break;
            }
            ob_start();

            $products = new WP_Query($args);

            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));

            $template_path = $plugin_path . '/templates/layout/list.php';
            $product_path  = $plugin_path . '/templates/product-style/list_style_1.php';
            switch ($product_style) {
                case 'style_1':
                    $product_path = $plugin_path . '/templates/product-style/list_style_1.php';
                    break;
                case 'style_2':
                    $product_path = $plugin_path . '/templates/product-style/list_style_2.php';
                    break;
                default:
                    $product_path = $plugin_path . '/templates/product-style/list_style_1.php';
            }

            ?>

            <?php if ($products->have_posts()) : ?>
                <div class="<?php echo esc_attr($class_name) ?>" <?php if(!empty($styles_animation)):?>style = "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                    <?php include($template_path); ?>
                </div>
            <?php else : ?>
                <div class="item-not-found"><?php echo esc_html__( 'No item found', 'yolo-motor' ) ?></div>
            <?php endif; ?>

            <?php
            wp_reset_query();
            
            $content =  ob_get_clean();
            
            return $content;
        }
    }

    new Yolo_Framework_Shortcode_Products_List();
}