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

if (!class_exists('Yolo_MotorFramework_Shortcodes')) {
    class Yolo_MotorFramework_Shortcodes
    {
        private static $instance;

        public static function init() {
            if (!isset(self::$instance)) {
                self::$instance = new Yolo_MotorFramework_Shortcodes;
                add_action('init', array(self::$instance, 'includes'), 0);
                add_action('init', array(self::$instance, 'register_vc_map'), 15); // Need to change piority from 10 to 15 because can cause invalid taxonomy
            }
            return self::$instance;
        }

        public function includes() {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            if (!is_plugin_active('js_composer/js_composer.php')) {
                return;
            }
            $yolo_options = yolo_get_options_pg();

            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/functions.php' ); // Include functions for fields type

            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/single-product/single-product.php' );
            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/product/product-masonry.php' );
            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/product/product-slider.php' );
            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/product/product-list.php' );
            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/countdown/countdown.php' );

            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/blog/blog.php' );

            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/banner/banner.php' );
            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/clients/clients.php' );
            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/icon-box/icon-box.php' );
            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/gmaps/gmaps.php' );
            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/recent-news/recent-news.php' );

            // Yolo Posttypes Shortcodes
            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/posttypes/testimonial/testimonial.php' );

            include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/shortcodes/posttypes/teammember/teammember.php' );
        }

        public static function yolo_get_css_animation($css_animation) {
            $output = '';
            if ($css_animation != '') {
                wp_enqueue_script('waypoints');
                $output = ' wpb_animate_when_almost_visible yolo-css-animation ' . $css_animation;
            }
            return $output;
        }

        public static function yolo_get_style_animation($duration, $delay) {
            $styles = array();
            if ($duration != '0' && !empty($duration)) {
                $duration = (float)trim($duration, "\n\ts");
                $styles[] = "-webkit-animation-duration: {$duration}s";
                $styles[] = "-moz-animation-duration: {$duration}s";
                $styles[] = "-ms-animation-duration: {$duration}s";
                $styles[] = "-o-animation-duration: {$duration}s";
                $styles[] = "animation-duration: {$duration}s";
            }
            if ($delay != '0' && !empty($delay)) {
                $delay = (float)trim($delay, "\n\ts");
                $styles[] = "opacity: 0";
                $styles[] = "-webkit-animation-delay: {$delay}s";
                $styles[] = "-moz-animation-delay: {$delay}s";
                $styles[] = "-ms-animation-delay: {$delay}s";
                $styles[] = "-o-animation-delay: {$delay}s";
                $styles[] = "animation-delay: {$delay}s";
            }
            return implode(';', $styles);
        }

        public static function substr($str, $txt_len, $end_txt = '...') {
            if (empty($str)) return '';
            if (strlen($str) <= $txt_len) return $str;

            $i = $txt_len;
            while ($str[$i] != ' ') {
                $i--;
                if ($i == -1) break;
            }
            while ($str[$i] == ' ') {
                $i--;
                if ($i == -1) break;
            }

            return substr($str, 0, $i + 1) . $end_txt;
        }

        /*
        * SHORTCODES MAP TABLE
        * 2. YOLO SINGLE PRODUCT
        * 3. YOLO PRODUCTS MASONRY FILTER, GRID AND SLIDER
        * 4. YOLO PRODUCTS SLIDER
        * 5. YOLO PRODUCTS LIST
        * 6. YOLO PRODUCTS CREATIVE
        * 7. YOLO BLOG
        * 8. YOLO PORTFOLIO
        * 9. YOLO TESTIMONIAL
        * 10. YOLO RECENT NEWS
        * 11. YOLO COUNTDOWN
        * 12. YOLO BANNER
        * 13. YOLO CLIENTS
        * 14. YOLO ICON BOX
        * 15. YOLO TEAM MEMBER
        * 16. YOLO GOOGLE MAPS
        * 17.
        */
        public function register_vc_map() {

            $yolo_options = yolo_get_options_pg();

            if (function_exists('vc_map')) {

                // Declare new params for shortcodes
                $add_css_animation = array(
                    'type'       => 'dropdown',
                    'heading'    => esc_html__( 'CSS Animation', 'yolo-motor' ),
                    'param_name' => 'css_animation',
                    'value'      => array(
                        esc_html__( 'No', 'yolo-motor' )                   => '', 
                        esc_html__( 'Fade In', 'yolo-motor' )              => 'wpb_fadeIn', 
                        esc_html__( 'Fade Top to Bottom', 'yolo-motor' )   => 'wpb_fadeInDown', 
                        esc_html__( 'Fade Bottom to Top', 'yolo-motor' )   => 'wpb_fadeInUp', 
                        esc_html__( 'Fade Left to Right', 'yolo-motor' )   => 'wpb_fadeInLeft', 
                        esc_html__( 'Fade Right to Left', 'yolo-motor' )   => 'wpb_fadeInRight', 
                        esc_html__( 'Bounce In', 'yolo-motor' )            => 'wpb_bounceIn', 
                        esc_html__( 'Bounce Top to Bottom', 'yolo-motor' ) => 'wpb_bounceInDown', 
                        esc_html__( 'Bounce Bottom to Top', 'yolo-motor' ) => 'wpb_bounceInUp', 
                        esc_html__( 'Bounce Left to Right', 'yolo-motor' ) => 'wpb_bounceInLeft', 
                        esc_html__( 'Bounce Right to Left', 'yolo-motor' ) => 'wpb_bounceInRight', 
                        esc_html__( 'Zoom In', 'yolo-motor' )              => 'wpb_zoomIn', 
                        esc_html__( 'Flip Vertical', 'yolo-motor' )        => 'wpb_flipInX', 
                        esc_html__( 'Flip Horizontal', 'yolo-motor' )      => 'wpb_flipInY', 
                        esc_html__( 'Bounce', 'yolo-motor' )               => 'wpb_bounce', 
                        esc_html__( 'Flash', 'yolo-motor' )                => 'wpb_flash', 
                        esc_html__( 'Shake', 'yolo-motor' )                => 'wpb_shake', 
                        esc_html__( 'Pulse', 'yolo-motor' )                => 'wpb_pulse', 
                        esc_html__( 'Swing', 'yolo-motor' )                => 'wpb_swing', 
                        esc_html__( 'Rubber band', 'yolo-motor' )          => 'wpb_rubberBand', 
                        esc_html__( 'Wobble', 'yolo-motor' )               => 'wpb_wobble', 
                        esc_html__( 'Tada', 'yolo-motor' )                 => 'wpb_tada'),
                    'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'yolo-motor' ),
                    'group'       => esc_html__( 'Animation Settings', 'yolo-motor' )
                );

                $add_duration_animation = array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Animation Duration', 'yolo-motor' ),
                    'param_name'  => 'duration',
                    'value'       => '',
                    'description' => esc_html__( 'Duration in seconds. You can use decimal points in the value. Use this field to specify the amount of time the animation plays. <em>The default value depends on the animation, leave blank to use the default.</em>', 'yolo-motor' ),
                    'dependency'  => array(
                        'element' => 'css_animation', 
                        'value'   => array(
                            'wpb_fadeIn', 
                            'wpb_fadeInDown', 
                            'wpb_fadeInUp', 
                            'wpb_fadeInLeft', 
                            'wpb_fadeInRight', 
                            'wpb_bounceIn', 
                            'wpb_bounceInDown', 
                            'wpb_bounceInUp', 
                            'wpb_bounceInLeft', 
                            'wpb_bounceInRight', 
                            'wpb_zoomIn', 
                            'wpb_flipInX', 
                            'wpb_flipInY', 
                            'wpb_bounce', 
                            'wpb_flash', 
                            'wpb_shake', 
                            'wpb_pulse', 
                            'wpb_swing', 
                            'wpb_rubberBand', 
                            'wpb_wobble', 
                            'wpb_tada'
                        )
                    ),
                    'group'      => esc_html__( 'Animation Settings', 'yolo-motor' )
                );

                $add_delay_animation = array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Animation Delay', 'yolo-motor' ),
                    'param_name'  => 'delay',
                    'value'       => '',
                    'description' => esc_html__( 'Delay in seconds. You can use decimal points in the value. Use this field to delay the animation for a few seconds, this is helpful if you want to chain different effects one after another above the fold.', 'yolo-motor' ),
                    'dependency'  => array(
                        'element' => 'css_animation', 
                        'value' => array(
                            'wpb_fadeIn', 
                            'wpb_fadeInDown', 
                            'wpb_fadeInUp', 
                            'wpb_fadeInLeft', 
                            'wpb_fadeInRight', 
                            'wpb_bounceIn', 
                            'wpb_bounceInDown', 
                            'wpb_bounceInUp', 
                            'wpb_bounceInLeft', 
                            'wpb_bounceInRight', 
                            'wpb_zoomIn', 
                            'wpb_flipInX', 
                            'wpb_flipInY', 
                            'wpb_bounce', 
                            'wpb_flash', 
                            'wpb_shake', 
                            'wpb_pulse', 
                            'wpb_swing', 
                            'wpb_rubberBand', 
                            'wpb_wobble', 
                            'wpb_tada'
                        )
                    ),
                    'group'       => esc_html__( 'Animation Settings', 'yolo-motor' )
                );

                $add_el_class = array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Extra class name', 'yolo-motor' ),
                    'param_name'  => 'el_class',
                    'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yolo-motor' ),
                );

                $custom_colors = array(
                    esc_html__( 'Informational', 'yolo-motor' )         => 'info',
                    esc_html__( 'Warning', 'yolo-motor' )               => 'warning',
                    esc_html__( 'Success', 'yolo-motor' )               => 'success',
                    esc_html__( 'Error', 'yolo-motor' )                 => "danger",
                    esc_html__( 'Informational Classic', 'yolo-motor' ) => 'alert-info',
                    esc_html__( 'Warning Classic', 'yolo-motor' )       => 'alert-warning',
                    esc_html__( 'Success Classic', 'yolo-motor' )       => 'alert-success',
                    esc_html__( 'Error Classic', 'yolo-motor' )         => "alert-danger",
                );
                //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
                /*-------------------------------------Yolo Single--------------------------------------------*/
                add_filter( 'vc_autocomplete_yolo_single_product_id_callback', 'productIdAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
                add_filter( 'vc_autocomplete_yolo_single_product_id_render', 'productIdAutocompleteRender', 10, 1 ); // Render exact product. Must return an array (label,value)
                //For param: ID default value filter
                add_filter( 'vc_form_fields_render_field_yolo_single_product_id_param_value', 'productIdDefaultValue', 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
                /* -------------------------------------Yolo Product------------------------------------------*/
                add_filter( 'vc_autocomplete_yolo_products_product_ids_callback', 'productIdAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
                add_filter( 'vc_autocomplete_yolo_products_product_ids_render', 'productIdAutocompleteRender', 10, 1 ); // Render exact product. Must return an array (label,value)
                //For param: ID default value filter
                add_filter( 'vc_form_fields_render_field_yolo_products_product_ids_param_value', 'productIdDefaultValue', 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
                 /* -------------------------------------Yolo Product Slider------------------------------------------*/
                add_filter( 'vc_autocomplete_yolo_products_slider_product_ids_callback', 'productIdAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
                add_filter( 'vc_autocomplete_yolo_products_slider_product_ids_render', 'productIdAutocompleteRender', 10, 1 ); // Render exact product. Must return an array (label,value)
                //For param: ID default value filter
                add_filter( 'vc_form_fields_render_field_yolo_products_slider_product_ids_param_value', 'productIdDefaultValue', 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
                 /* -------------------------------------Yolo Product List------------------------------------------*/
                add_filter( 'vc_autocomplete_yolo_products_list_product_ids_callback', 'productIdAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
                add_filter( 'vc_autocomplete_yolo_products_list_product_ids_render', 'productIdAutocompleteRender', 10, 1 ); // Render exact product. Must return an array (label,value)
                //For param: ID default value filter
                add_filter( 'vc_form_fields_render_field_yolo_products_list_product_ids_param_value', 'productIdDefaultValue', 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
                // REGISTER VC_MAP SHORTCODES

                /* A. WOOCOMMERCE SHORTCODE */
                if (class_exists('WooCommerce')) {
                    /* 2. YOLO SINGLE PRODUCT */
                    /* Need some function from function.php for autocomplete field type */
                    // Actions disable
                    $action_disable              = array();
                    $action_disable['Wishlist']  = 'wishlist'; 
                    $action_disable['AddToCart'] = 'addtocart'; 
                    $action_disable['Compare']   = 'compare'; 
                    $action_disable['QuickView'] = 'quickview';
                    vc_map(
                        array(
                            "name"        =>  esc_html__( "Yolo Single Product", "yolo-motor" ),
                            "base"        =>  "yolo_single_product",
                            "category"    =>  YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                            "icon"        =>  "fa fa-shopping-cart",
                            'description' => esc_html__( 'Display single WooCommerce product', 'yolo-motor' ),
                            "params"      =>  array(
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Layout Style', 'yolo-motor' ),
                                    'param_name' => 'product_style',
                                    'value'      => array(
                                        esc_html__( 'Style 1', 'yolo-motor' ) => 'style_1',
                                        esc_html__( 'Style 2', 'yolo-motor' ) => 'style_2',
                                        esc_html__( 'Style 3', 'yolo-motor' ) => 'style_3',
                                        esc_html__( 'Style 4', 'yolo-motor' ) => 'style_4'
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Action Button Tooltip', 'yolo-motor' ),
                                    'param_name' => 'action_tooltip',
                                    'value'      => array(
                                        esc_html__( 'Yes', 'yolo-motor') => 'true', 
                                        esc_html__( 'No', 'yolo-motor')  => 'false'
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                  array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Images Style', 'yolo-motor' ),
                                    'param_name' => 'images_style',
                                    'value'      => array(
                                        esc_html__( 'Images Left', 'yolo-motor' )   => 'style_left',
                                        esc_html__( 'Images Right', 'yolo-motor' )  => 'style_right',
                                    ),
                                    'std'              => 'style_left',
                                    'dependency'  => array(
                                        'element' => 'product_style',
                                        'value'   => array('style_2')
                                    ),
                                ),
                                array(
                                    'type'        => 'multi-select',
                                    'heading'     => esc_html__( 'Disable Action Button', 'yolo-motor' ),
                                    'param_name'  => 'action_disable',
                                    'admin_label' => true,
                                    'options'     => $action_disable,
                                ),
                                array(
                                    "type"          => "autocomplete",
                                    "holder"        => "div",
                                    "class"         => "hide_in_vc_editor",
                                    "admin_label"   => true,
                                    "heading"       => esc_html__( "Select single product by search name", 'yolo-motor' ),
                                    "param_name"    => "id",
                                ),
                                array(
                                    'param_name'    => 'product_brand',
                                    'holder'        => 'div',
                                    'heading'       => esc_html__( 'Product Brand', 'yolo-motor' ),
                                    'description'   => '',
                                    'type'          =>  'textfield',
                                    'dependency' => array(
                                        'element' => 'product_style',
                                        'value'   => array('style_1', 'style_4')
                                    ),
                                ),
                                array(
                                    'param_name'    => 'product_brand_logo',
                                    'heading'       => esc_html__( 'Choose Product Brand\'s Logo', 'yolo-motor' ),
                                    'description'   => '',
                                    'type'          => 'attach_image',
                                    'admin_label'   => true,
                                    'dependency' => array(
                                        'element' => 'product_style',
                                        'value'   => array('style_4')
                                    ),
                                ),
                                $add_css_animation,
                                $add_duration_animation,
                                $add_delay_animation,
                                $add_el_class
                            )
                        )
                    );
                    /* 3. YOLO PRODUCTS MASONRY FILTER, GRID */
                    vc_map(
                        array(
                            'base'        => 'yolo_products',
                            'name'        => esc_html__( 'Yolo Products', 'yolo-motor' ),
                            'icon'        => 'fa fa-shopping-cart',
                            'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                            'description' => esc_html__( 'Display products as grid or masonry layout', 'yolo-motor' ),
                            'params'      => array(
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Products Style', 'yolo-motor' ),
                                    'param_name' => 'layout_type',
                                    'value'      => array(
                                        esc_html__( 'Grid', 'yolo-motor' )    => 'grid',
                                        esc_html__( 'Masonry', 'yolo-motor' ) => 'masonry',
                                    ),
                                    'std'              => 'grid',
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    'type'        => 'dropdown',
                                    'heading'     => esc_html__( 'Columns', 'yolo-motor' ),
                                    'param_name'  => 'columns',
                                    'admin_label' => true,
                                    'value'       => array( 2, 3, 4, 5 ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                    'dependency'  => array(
                                        'element' => 'layout_type',
                                        'value'   => array('grid', 'masonry')
                                    ),
                                ),
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Single Product Style', 'yolo-motor' ),
                                    'param_name' => 'product_style',
                                    'value'      => array(
                                        esc_html__( 'Style 1', 'yolo-motor' ) => 'style_1',
                                        esc_html__( 'Style 2', 'yolo-motor' ) => 'style_2',
                                        esc_html__( 'Style 3', 'yolo-motor' ) => 'style_3',
                                        esc_html__( 'Style 4', 'yolo-motor' ) => 'style_4',
                                        esc_html__( 'Style 5', 'yolo-motor' ) => 'style_5',
                                    ),
                                    'std'              => 'style_1',
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                    'dependency'       => array(
                                        'element' => 'layout_type',
                                        'value'   => array('grid', 'masonry')
                                    ),
                                ),
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Action Button Tooltip', 'yolo-motor' ),
                                    'param_name' => 'action_tooltip',
                                    'value'      => array(
                                        esc_html__( 'Yes', 'yolo-motor') => 'true', 
                                        esc_html__( 'No', 'yolo-motor')  => 'false'
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    'type'        => 'multi-select',
                                    'heading'     => esc_html__( 'Disable Action Button', 'yolo-motor' ),
                                    'param_name'  => 'action_disable',
                                    'admin_label' => true,
                                    'options'     => $action_disable
                                    ),
                                array(
                                    'type'        => 'dropdown',
                                    'heading'     => esc_html__( 'Source', 'yolo-motor' ),
                                    'param_name'  => 'data_source',
                                    'admin_label' => true,
                                    'value'       => array(
                                        esc_html__( 'From Category', 'yolo-motor' )    => 'product_cat',
                                        esc_html__( 'From Product IDs', 'yolo-motor' ) => 'product_list_id'
                                    )
                                ),
                                array(
                                    'type'        => 'product-category',
                                    'heading'     => esc_html__( 'Select Category', 'yolo-motor' ),
                                    'param_name'  => 'category',
                                    'admin_label' => true,
                                    'dependency'  => array(
                                        'element' => 'data_source',
                                        'value'   => array('product_cat')
                                    ),
                                ),
                                array(
                                    'type'        => 'autocomplete',
                                    'settings' => array(
                                        'multiple' => true,
                                        // 'sortable' => true,
                                        // 'unique_values' => true,
                                        // In UI show results except selected. NB! You should manually check values in backend
                                    ),
                                    'heading'    => esc_html__( 'Select Product', 'yolo-motor' ),
                                    'param_name' => 'product_ids',
                                    'dependency' => array(
                                        'element' => 'data_source', 
                                        'value'   => array('product_list_id')
                                    )
                                ),
                                array(
                                    "type"       => "dropdown",
                                    "heading"    => esc_html__( "Filter style", 'yolo-motor' ),
                                    "param_name" => "filter_style",
                                    "value"      => array(
                                        esc_html__( 'None', 'yolo-motor' )    => '',
                                        esc_html__( 'Style 1', 'yolo-motor' ) => 'style_1',
                                        esc_html__( 'Style 2', 'yolo-motor' ) => 'style_2',
                                        esc_html__( 'Style 3', 'yolo-motor' ) => 'style_3',
                                        esc_html__( 'Style 4', 'yolo-motor' ) => 'style_4',
                                        esc_html__( 'Style 5', 'yolo-motor' ) => 'style_5',
                                        esc_html__( 'Style 6', 'yolo-motor' ) => 'style_6',
                                    ),
                                    'dependency' => array(
                                        'element' => 'data_source', 
                                        'value'   => array('product_cat')
                                    )
                                ),
                                array(
                                    "type"        => "dropdown",
                                    "heading"     => esc_html__( "Show/hide \"All\" in filter", 'yolo-motor' ),
                                    "param_name"  => "show_all_filter",
                                    'description' => '',
                                    "value"       => array(
                                        esc_html__( 'Hide', 'yolo-motor' ) => 'hide',
                                        esc_html__( 'Show', 'yolo-motor' ) => 'show'
                                    ),
                                    'dependency'    => array(
                                        'element'   => 'filter_style',
                                        'not_empty' => true,
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    "type"       => "dropdown",
                                    "heading"    => esc_html__( "Filter alignment", 'yolo-motor' ),
                                    "param_name" => "filter_align",
                                    "value"      => array(
                                        esc_html__( 'Center', 'yolo-motor' ) => 'center',
                                        esc_html__( 'Left', 'yolo-motor' )   => 'left',
                                        esc_html__( 'Right', 'yolo-motor' )  => 'right'
                                    ),
                                    'dependency'    => array(
                                        'element'   => 'filter_style',
                                        'not_empty' => true,
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    "type"       => "dropdown",
                                    "class"      => "",
                                    "heading"    => esc_html__( "Show/hide Sorting product", 'yolo-motor' ),
                                    "param_name" => "sorting",
                                    "value"      => array(
                                        esc_html__( 'Hide', 'yolo-motor' ) => 'false', 
                                        esc_html__( 'Show', 'yolo-motor' ) => 'true'
                                    ),
                                ),
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Pagination', 'yolo-motor' ),
                                    'param_name' => 'paging_style',
                                    'value'      => array(
                                        esc_html__( 'Page Number', 'yolo-motor' )        => 'default',
                                        esc_html__( 'Load More Button', 'yolo-motor' )   => 'load-more',
                                        esc_html__( 'Infinite Scrolling', 'yolo-motor' ) => 'infinity-scroll',
                                        // esc_html__( 'Show all', 'yolo-motor' )           => 'all',
                                        esc_html__( 'None', 'yolo-motor' )                 => 'none'
                                    ),
                                    'dependency'    => array(
                                        'element'   => 'show_all_filter',
                                        'value'     => array( 'show' )
                                    ),
                                    'description' => esc_html__( 'Choose pagination type.', 'yolo-motor' ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    "type"       => "dropdown",
                                    "heading"    => esc_html__( "Paging alignment", 'yolo-motor' ),
                                    "param_name" => "paging_align",
                                    "value"      => array(
                                        esc_html__( 'Center', 'yolo-motor' ) => 'center',
                                        esc_html__( 'Left', 'yolo-motor' )   => 'left',
                                        esc_html__( 'Right', 'yolo-motor' )  => 'right'
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                                    'dependency'    => array(
                                        'element'   => 'show_all_filter',
                                        'value'     => array( 'show' )
                                    ),
                                ),
                                array(
                                    "type"        => "textfield",
                                    "heading"     => esc_html__( "Product Per Category", 'yolo-motor' ),
                                    "param_name"  => "per_category",
                                    "admin_label" => true,
                                    "value"       => 4 ,
                                    'dependency'    => array(
                                        'element'   => 'show_all_filter',
                                        'value'     => array( 'hide' )
                                    ),
                                ),
                                array(
                                    "type"        => "textfield",
                                    "heading"     => esc_html__( "Products Per Page", 'yolo-motor' ),
                                    "param_name"  => "per_page",
                                    "admin_label" => true,
                                    "value"       => 12 ,
                                    'dependency'  => array(
                                        'element'   => 'show_all_filter',
                                        'value'     => array( 'show' )
                                    ),
                                ),
                                
                                array(
                                    "type"       => "dropdown",
                                    "heading"    => esc_html__( "Products Ordering", 'yolo-motor' ),
                                    "param_name" => "orderby",
                                    "value"      => array(
                                        esc_html__( 'Publish Date', 'yolo-motor' ) => 'date',
                                        esc_html__( 'Random', 'yolo-motor' )       => 'rand',
                                        esc_html__( 'Alphabetic', 'yolo-motor' )   => 'title',
                                        esc_html__( 'Featured', 'yolo-motor' )   => '_featured',
                                        esc_html__( 'Rate', 'yolo-motor' )         => 'rating',
                                        esc_html__( 'Price', 'yolo-motor' )        => 'price'
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    "type"       => "dropdown",
                                    "class"      => "",
                                    "heading"    => esc_html__( "Sorting", 'yolo-motor' ),
                                    "param_name" => "order",
                                    "value"      => array(
                                        esc_html__( 'Ascending', 'yolo-motor' )  => 'asc',
                                        esc_html__( 'Descending', 'yolo-motor' ) => 'desc' 
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                                ),
                                $add_css_animation,
                                $add_duration_animation,
                                $add_delay_animation,
                                $add_el_class
                            )
                        )
                    );
                    
                    /* 4. YOLO PRODUCTS SLIDER */
                    vc_map(
                        array(
                            'base'        => 'yolo_products_slider',
                            'name'        => esc_html__( 'Yolo Products Slider', 'yolo-motor' ),
                            'icon'        => 'fa fa-shopping-cart',
                            'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                            'description' => esc_html__( 'Display products as carousel slider', 'yolo-motor' ),
                            'params'      => array(
                                array(
                                    'type'        => 'dropdown',
                                    'heading'     => esc_html__( 'Source', 'yolo-motor' ),
                                    'param_name'  => 'data_source',
                                    'admin_label' => true,
                                    'value'       => array(
                                        esc_html__( 'From Category', 'yolo-motor' )    => 'product_cat',
                                        esc_html__( 'From Product IDs', 'yolo-motor' ) => 'product_list_id'
                                    )
                                ),
                                array(
                                    'type'        => 'product-category',
                                    'heading'     => esc_html__( 'Select Category', 'yolo-motor' ),
                                    'param_name'  => 'category',
                                    'admin_label' => true,
                                    'dependency'  => array(
                                        'element' => 'data_source',
                                        'value'   => array('product_cat')
                                    ),
                                ),
                                array(
                                    'type'        => 'autocomplete',
                                    'settings' => array(
                                        'multiple' => true,
                                        // 'sortable' => true,
                                        // 'unique_values' => true,
                                        // In UI show results except selected. NB! You should manually check values in backend
                                    ),
                                    'heading'    => esc_html__( 'Select Product', 'yolo-motor' ),
                                    'param_name' => 'product_ids',
                                    'dependency' => array(
                                        'element' => 'data_source', 
                                        'value'   => array('product_list_id')
                                    )
                                ),
                                array(
                                    'type'        => 'dropdown',
                                    'heading'     => esc_html__( 'Products per slide', 'yolo-motor' ),
                                    'param_name'  => 'products_per_slide',
                                    'admin_label' => true,
                                    'value'       => array( 2, 3, 4, 5, 6 ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'AutoPlay', 'yolo-motor' ),
                                    'param_name' => 'autoplay',
                                    'value'      => array(
                                        esc_html__( 'Yes', 'yolo-motor') => 'true', 
                                        esc_html__( 'No', 'yolo-motor')  => 'false'
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    'type'             => 'textfield',
                                    'heading'          => esc_html__( 'Slide Duration (ms)', 'yolo-motor' ),
                                    'param_name'       => 'slide_duration',
                                    'std'             => '1000',
                                    'admin_label'      => true,
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Single Product Style', 'yolo-motor' ),
                                    'param_name' => 'product_style',
                                    'value'      => array(
                                        esc_html__( 'Style 1', 'yolo-motor' ) => 'style_1',
                                        esc_html__( 'Style 2', 'yolo-motor' ) => 'style_2',
                                        esc_html__( 'Style 3', 'yolo-motor' ) => 'style_3',
                                        esc_html__( 'Style 4', 'yolo-motor' ) => 'style_4',
                                        esc_html__( 'Style 5', 'yolo-motor' ) => 'style_5',
                                    ),
                                    'std'              => 'style_1',
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Action Button Tooltip', 'yolo-motor' ),
                                    'param_name' => 'action_tooltip',
                                    'value'      => array(
                                        esc_html__( 'Yes', 'yolo-motor') => 'true', 
                                        esc_html__( 'No', 'yolo-motor')  => 'false'
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    'type'        => 'multi-select',
                                    'heading'     => esc_html__( 'Disable Action Button', 'yolo-motor' ),
                                    'param_name'  => 'action_disable',
                                    'admin_label' => true,
                                    'options'     => $action_disable,
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    "type"        => "textfield",
                                    "heading"     => esc_html__( "Number of Products", 'yolo-motor' ),
                                    "description" => esc_html__( '-1 is show all products', 'yolo-motor' ),
                                    "param_name"  => "per_page",
                                    "admin_label" => true,
                                    "value"       => 12,
                                ),
                                array(
                                    "type"       => "dropdown",
                                    "heading"    => esc_html__( "Products Ordering", 'yolo-motor' ),
                                    "param_name" => "orderby",
                                    "value"      => array(
                                        esc_html__( 'Publish Date', 'yolo-motor' ) => 'date',
                                        esc_html__( 'Random', 'yolo-motor' )       => 'rand',
                                        esc_html__( 'Alphabetic', 'yolo-motor' )   => 'title',
                                        esc_html__( 'Popularity', 'yolo-motor' )   => 'popularity',
                                        esc_html__( 'Rate', 'yolo-motor' )         => 'rating',
                                        esc_html__( 'Price', 'yolo-motor' )        => 'price' 
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    "type"       => "dropdown",
                                    "class"      => "",
                                    "heading"    => esc_html__( "Sorting", 'yolo-motor' ),
                                    "param_name" => "order",
                                    "value"      => array(
                                        esc_html__( 'Ascending', 'yolo-motor' )  => 'asc',
                                        esc_html__( 'Descending', 'yolo-motor' ) => 'desc' 
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                                ),
                                $add_css_animation,
                                $add_duration_animation,
                                $add_delay_animation,
                                $add_el_class
                            )
                        )
                    );

                    /* 5. YOLO PRODUCTS LIST */
                    vc_map(
                        array(
                            'base'        => 'yolo_products_list',
                            'name'        => esc_html__( 'Yolo Products List', 'yolo-motor' ),
                            'icon'        => 'fa fa-shopping-cart',
                            'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                            'description' => esc_html__( 'Display products as list', 'yolo-motor' ),
                            'params'      => array(
                                array(
                                    'type'        => 'dropdown',
                                    'heading'     => esc_html__( 'Source', 'yolo-motor' ),
                                    'param_name'  => 'data_source',
                                    'admin_label' => true,
                                    'value'       => array(
                                        esc_html__( 'From Category', 'yolo-motor' )    => 'product_cat',
                                        esc_html__( 'From Product IDs', 'yolo-motor' ) => 'product_list_id'
                                    )
                                ),
                                array(
                                    'type'        => 'product-category',
                                    'heading'     => esc_html__( 'Select Category', 'yolo-motor' ),
                                    'param_name'  => 'category',
                                    'admin_label' => true,
                                    'dependency'  => array(
                                        'element' => 'data_source',
                                        'value'   => array('product_cat')
                                    ),
                                ),
                                array(
                                    'type'        => 'autocomplete',
                                    'settings' => array(
                                        'multiple' => true,
                                        // 'sortable' => true,
                                        // 'unique_values' => true,
                                        // In UI show results except selected. NB! You should manually check values in backend
                                    ),
                                    'heading'    => esc_html__( 'Select Product', 'yolo-motor' ),
                                    'param_name' => 'product_ids',
                                    'dependency' => array(
                                        'element' => 'data_source', 
                                        'value'   => array('product_list_id')
                                    )
                                ),
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Single Product Style', 'yolo-motor' ),
                                    'param_name' => 'product_style',
                                    'value'      => array(
                                        esc_html__( 'Style 1', 'yolo-motor' ) => 'style_1',
                                        esc_html__( 'Style 2', 'yolo-motor' ) => 'style_2',
                                    ),
                                    'std'              => 'style_1',
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Action Button Tooltip', 'yolo-motor' ),
                                    'param_name' => 'action_tooltip',
                                    'value'      => array(
                                        esc_html__( 'Yes', 'yolo-motor') => 'true', 
                                        esc_html__( 'No', 'yolo-motor')  => 'false'
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    'type'        => 'multi-select',
                                    'heading'     => esc_html__( 'Disable Action Button', 'yolo-motor' ),
                                    'param_name'  => 'action_disable',
                                    'admin_label' => true,
                                    'options'     => $action_disable,
                                ),
                                array(
                                    'type'       => 'dropdown',
                                    'heading'    => esc_html__( 'Pagination', 'yolo-motor' ),
                                    'param_name' => 'paging_style',
                                    'value'      => array(
                                        esc_html__( 'Page Number', 'yolo-motor' )        => 'default',
                                        esc_html__( 'Load More Button', 'yolo-motor' )   => 'load-more',
                                        esc_html__( 'Infinite Scrolling', 'yolo-motor' ) => 'infinity-scroll',
                                    ),
                                    'description' => esc_html__( 'Choose pagination type.', 'yolo-motor' ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    "type"       => "dropdown",
                                    "heading"    => esc_html__( "Paging alignment", 'yolo-motor' ),
                                    "param_name" => "paging_align",
                                    "value"      => array(
                                        esc_html__( 'Center', 'yolo-motor' ) => 'center',
                                        esc_html__( 'Left', 'yolo-motor' )   => 'left',
                                        esc_html__( 'Right', 'yolo-motor' )  => 'right'
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                                ),
                                array(
                                    "type"        => "textfield",
                                    "heading"     => esc_html__( "Products Per Page", 'yolo-motor' ),
                                    "param_name"  => "per_page",
                                    "admin_label" => true,
                                    "value"       => 12 ,
                                ),
                                
                                array(
                                    "type"       => "dropdown",
                                    "heading"    => esc_html__( "Products Ordering", 'yolo-motor' ),
                                    "param_name" => "orderby",
                                    "value"      => array(
                                        esc_html__( 'Publish Date', 'yolo-motor' ) => 'date',
                                        esc_html__( 'Random', 'yolo-motor' )       => 'rand',
                                        esc_html__( 'Alphabetic', 'yolo-motor' )   => 'title',
                                        esc_html__( 'Popularity', 'yolo-motor' )   => 'popularity',
                                        esc_html__( 'Rate', 'yolo-motor' )         => 'rating',
                                        esc_html__( 'Price', 'yolo-motor' )        => 'price' 
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                ),
                                array(
                                    "type"       => "dropdown",
                                    "class"      => "",
                                    "heading"    => esc_html__( "Sorting", 'yolo-motor' ),
                                    "param_name" => "order",
                                    "value"      => array(
                                        esc_html__( 'Ascending', 'yolo-motor' )  => 'asc',
                                        esc_html__( 'Descending', 'yolo-motor' ) => 'desc' 
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                                ),
                                $add_css_animation,
                                $add_duration_animation,
                                $add_delay_animation,
                                $add_el_class
                            )
                        )
                    );               
                }

                /* 6. YOLO PRODUCTS CREATIVE */
                /* B. OTHER SHORTCODE */
                /* 7. YOLO BLOG */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Blog', 'yolo-motor' ),
                        'base'        => 'yolo_blog',
                        'icon'        => 'fa fa-file-text',
                        'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => esc_html__( 'Display post as list, grid', 'yolo-motor' ),
                        'params'      => array(
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Blog Style', 'yolo-motor' ),
                                'param_name' => 'type',
                                'value'      => array(
                                    esc_html__( 'List (Larger Image)', 'yolo-motor' ) => 'large-image',
                                    esc_html__( 'List (Medium Image)', 'yolo-motor' ) => 'medium-image',
                                    esc_html__( 'Grid', 'yolo-motor' )                => 'grid',
                                    esc_html__( 'Masonry', 'yolo-motor' )             => 'masonry'
                                ),
                                'std'              => 'large-image',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                "type"       => "dropdown",
                                "heading"    => esc_html__( "Columns", 'yolo-motor' ),
                                "param_name" => "columns",
                                "value"      => array(
                                    esc_html__( '2 columns', 'yolo-motor' ) => 2,
                                    esc_html__( '3 columns', 'yolo-motor' ) => 3,
                                    esc_html__( '4 columns', 'yolo-motor' ) => 4,
                                ),
                                'dependency'  => array(
                                    'element' => 'type',
                                    'value'   => array('grid', 'masonry')
                                ),
                                'std'              => 2,
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                "type"       => "checkbox",
                                "heading"    => esc_html__( "Padding", 'yolo-motor' ),
                                "param_name" => "padding",
                                'dependency'  => array(
                                    'element' => 'type',
                                    'value'   => array('grid', 'masonry')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'       => 'blog-cat',
                                'heading'    => esc_html__( 'Narrow Category', 'yolo-motor' ),
                                'param_name' => 'category'
                            ),
                            array(
                                "type"        => "textfield",
                                "heading"     => esc_html__( "Total items", 'yolo-motor' ),
                                "param_name"  => "max_items",
                                "value"       => -1,
                                "description" => esc_html__( 'Set max limit for items or enter -1 to display all.', 'yolo-motor' )
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Navigation Type', 'yolo-motor' ),
                                'param_name' => 'paging_style',
                                'value'      => array(
                                    esc_html__( 'Show all', 'yolo-motor' )        => 'all',
                                    esc_html__( 'Default', 'yolo-motor' )         => 'default',
                                    esc_html__( 'Load More', 'yolo-motor' )       => 'load-more',
                                    esc_html__( 'Infinity Scroll', 'yolo-motor' ) => 'infinity-scroll',
                                ),
                                'std'              => 'all',
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                                'dependency'       => array(
                                    'element' => 'max_items',
                                    'value'   => array('-1')
                                ),
                            ),

                            array(
                                "type"        => "textfield",
                                "heading"     => esc_html__( "Posts per page", 'yolo-motor' ),
                                "param_name"  => "posts_per_page",
                                "value"       => get_option('posts_per_page'),
                                'dependency'  => array(
                                    'element' => 'paging_style',
                                    'value'   => array('default', 'load-more', 'infinity-scroll'),
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),

                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Navigation Align', 'yolo-motor' ),
                                'param_name' => 'paging_align',
                                'value'      => array(
                                    esc_html__( 'Left', 'yolo-motor' )   => 'left',
                                    esc_html__( 'Center', 'yolo-motor' ) => 'center',
                                    esc_html__( 'Right', 'yolo-motor' )  => 'right',
                                ),
                                'std'        => 'right',
                                'dependency' => array(
                                    'element' => 'paging_style',
                                    'value'   => array('default'),
                                ),
                            ),
                            array(
                                "type"        => "checkbox",
                                "heading"     => esc_html__( "Hide Author", 'yolo-motor' ),
                                "param_name"  => "hide_author",
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                "type"        => "checkbox",
                                "heading"     => esc_html__( "Hide Date", 'yolo-motor' ),
                                "param_name"  => "hide_date",
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                "type"        => "checkbox",
                                "heading"     => esc_html__( "Hide Category", 'yolo-motor' ),
                                "param_name"  => "hide_category",
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                "type"        => "checkbox",
                                "heading"     => esc_html__( "Hide Comment", 'yolo-motor' ),
                                "param_name"  => "hide_comment",
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                "type"        => "checkbox",
                                "heading"     => esc_html__( "Hide Read More", 'yolo-motor' ),
                                "param_name"  => "hide_readmore",
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                "type"        => "textfield",
                                "heading"     => esc_html__( "Excerpt length", 'yolo-motor' ),
                                "param_name"  => "excerpt_length",
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                                'std'              => '20'
                            ),
                            // Data settings  
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__('Order by', 'yolo-motor'),
                                'param_name' => 'orderby',
                                'value'      => array(
                                    esc_html__( 'Date', 'yolo-motor' )                  => 'date',
                                    esc_html__( 'Order by post ID', 'yolo-motor' )      => 'ID',
                                    esc_html__( 'Author', 'yolo-motor' )                => 'author',
                                    esc_html__( 'Title', 'yolo-motor' )                 => 'title',
                                    esc_html__( 'Last modified date', 'yolo-motor' )    => 'modified',
                                    esc_html__( 'Post/page parent ID', 'yolo-motor' )   => 'parent',
                                    esc_html__( 'Number of comments', 'yolo-motor' )    => 'comment_count',
                                    esc_html__( 'Menu order/Page Order', 'yolo-motor' ) => 'menu_order',
                                    esc_html__( 'Meta value', 'yolo-motor' )            => 'meta_value',
                                    esc_html__( 'Meta value number', 'yolo-motor' )     => 'meta_value_num',
                                    esc_html__( 'Random order', 'yolo-motor' )          => 'rand',
                                ),
                                'description'        => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'yolo-motor' ),
                                'group'              => esc_html__( 'Data Settings', 'yolo-motor' ),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                            ),

                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Sorting', 'yolo-motor' ),
                                'param_name' => 'order',
                                'group'      => esc_html__( 'Data Settings', 'yolo-motor' ),
                                'value'      => array(
                                    esc_html__( 'Descending', 'yolo-motor' ) => 'DESC',
                                    esc_html__( 'Ascending', 'yolo-motor' )  => 'ASC',
                                ),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                                'description'        => esc_html__( 'Select sorting order.', 'yolo-motor' ),
                            ),

                            array(
                                'type'               => 'textfield',
                                'heading'            => esc_html__( 'Meta key', 'yolo-motor' ),
                                'param_name'         => 'meta_key',
                                'description'        => esc_html__( 'Input meta key for grid ordering.', 'yolo-motor' ),
                                'group'              => esc_html__( 'Data Settings', 'yolo-motor' ),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                                'dependency'         => array(
                                    'element' => 'orderby',
                                    'value'   => array('meta_value', 'meta_value_num'),
                                ),
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                // POSTTYPES SHORTCODE
                /* 8. YOLO PORTFOLIO */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Portfolio', 'yolo-motor' ),
                        'base'        => 'yolo_portfolio',
                        'icon'        => 'fa fa-th-large',
                        'description' => esc_html__( 'Display Portfolio projects', 'yolo-motor' ),
                        'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Layout Style', 'yolo-motor' ),
                                'param_name' => 'layout_type',
                                'value'      => array(
                                    esc_html__( 'Grid', 'yolo-motor' )         => 'grid',
                                    esc_html__( 'Masonry', 'yolo-motor' )      => 'masonry'
                                ),
                                'std'              => 'grid',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Columns', 'yolo-motor' ),
                                'param_name' => 'column',
                                'value'      => array(
                                    esc_html__( '2 columns', 'yolo-motor' ) => '2',
                                    esc_html__( '3 columns', 'yolo-motor' ) => '3',
                                    esc_html__( '4 columns', 'yolo-motor' ) => '4',
                                    esc_html__( '5 columns', 'yolo-motor' ) => '5',
                                    esc_html__( '6 columns', 'yolo-motor' ) => '6',
                                ),
                                // 'description' => esc_html__( 'How much columns grid', 'yolo-motor' ),
                                'dependency'  => array(
                                    'element' => 'layout_type',
                                    'value'   => array('grid', 'masonry')
                                ),
                                'std'              => '4',
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Source', 'yolo-motor' ),
                                'param_name'  => 'data_source',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'From Category', 'yolo-motor' )      => '',
                                    esc_html__( 'From Portfolio IDs', 'yolo-motor' ) => 'list_id')
                            ),
                            array(
                                'type'        => 'portfolio-cat',
                                'heading'     => esc_html__( 'Portfolio Category', 'yolo-motor' ),
                                'param_name'  => 'category',
                                'admin_label' => true,
                                'dependency'  => array(
                                    'element' => 'data_source', 
                                    'value'   => array('')
                                ),
                            ),
                            array(
                                'type'       => 'portfolio-single',
                                'heading'    => esc_html__( 'Select Portfolio', 'yolo-motor' ),
                                'param_name' => 'portfolio_ids',
                                'dependency' => array(
                                    'element' => 'data_source', 
                                    'value'   => array('list_id')
                                )
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Show Category', 'yolo-motor' ),
                                'param_name'  => 'show_category',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'None', 'yolo-motor' )           => '',
                                    esc_html__( 'Show in left', 'yolo-motor' )   => 'left',
                                    esc_html__( 'Show in center', 'yolo-motor' ) => 'center',
                                    esc_html__( 'Show in right', 'yolo-motor' )  => 'right'
                                ),
                                'std'         => '',
                                'dependency' => array(
                                    'element' => 'layout_type',
                                    'value'   => array(
                                        'grid',
                                        'masonry',
                                    )
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Show Paging', 'yolo-motor' ),
                                'param_name' => 'show_pagging',
                                'value' => array(
                                    esc_html__( 'None', 'yolo-motor' )      => '', 
                                    esc_html__( 'Load more', 'yolo-motor' ) => '1'
                                ),
                                'dependency' => array(
                                    'element' => 'layout_type', 
                                    'value'   => array('grid', 'masonry')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'       => 'textfield',
                                'heading'    => esc_html__( 'Number of item (or number of item per page if choose show paging)', 'yolo-motor' ),
                                'param_name' => 'item',
                                'value'      => '4',
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Order Post Date By', 'yolo-motor' ),
                                'param_name' => 'order',
                                'value'      => array(
                                    esc_html__('Descending', 'yolo-motor') => 'DESC', 
                                    esc_html__('Ascending', 'yolo-motor')  => 'ASC'
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Padding', 'yolo-motor' ),
                                'param_name' => 'padding',
                                'value'      => array(
                                    esc_html__( 'No padding', 'yolo-motor' ) => '', 
                                    esc_html__( '5 px', 'yolo-motor' )       => 'col-padding-5', 
                                    esc_html__( '10 px', 'yolo-motor' )      => 'col-padding-10', 
                                    esc_html__( '15 px', 'yolo-motor' )      => 'col-padding-15',
                                    esc_html__( '20 px', 'yolo-motor' )      => 'col-padding-20',
                                ),
                                'dependency' => array(
                                    'element' => 'layout_type',
                                    'value'   => array('grid', 'masonry')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),

                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Image Resize', 'yolo-motor' ),
                                'param_name' => 'image_size',
                                'value'      => array(
                                    esc_html__( 'None', 'yolo-motor' ) => '', 
                                    '600x600'                          => '600x600', 
                                    '600x400'                          => '600x400', 
                                    '600x300'                          => '600x300',
                                ),
                                'dependency' => array(
                                    'element' => 'layout_type', 
                                    'value'   => array('grid')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Overlay Style', 'yolo-motor' ),
                                'param_name'  => 'overlay_style',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'Icon', 'yolo-motor' )                                         => 'icon',
                                    esc_html__( 'Icon View', 'yolo-motor' )                                    => 'icon-view',
                                    esc_html__( 'Title', 'yolo-motor' )                                        => 'title',
                                    esc_html__( 'Title and Category', 'yolo-motor' )                           => 'title-category',
                                    esc_html__( 'Title, Category and Link button', 'yolo-motor' )              => 'title-category-link',
                                    esc_html__( 'Title, Excerpt', 'yolo-motor' )                               => 'title-excerpt',
                                    esc_html__( 'Title, Excerpt, Link button and Align center', 'yolo-motor' ) => 'title-excerpt-link',
                                ),
                                'dependency' => array(
                                    'element' => 'layout_type', 
                                    'value'   => array(
                                        'grid', 'masonry'
                                    )
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Portfolio Details', 'yolo-motor' ),
                                'param_name' => 'portfolio_details',
                                'value'      => array(
                                    esc_html__( 'Lightbox', 'yolo-motor' )    => 'lightbox', 
                                    esc_html__( 'Single Post', 'yolo-motor' ) => 'single',
                                ),
                                'std'        => 'lightbox',
                                'dependency' => array(
                                    'element' => 'layout_type',
                                    'value'   => array('grid', 'masonry')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Lightbox Style', 'yolo-motor' ),
                                'param_name' => 'lightbox_style',
                                'value'      => array(
                                    esc_html__( 'Image Only', 'yolo-motor' )        => 'image',
                                    esc_html__( 'Image and Content', 'yolo-motor' ) => 'image_content', 
                                ),
                                'dependency' => array(
                                    'element' => 'portfolio_details',
                                    'value'   => array('lightbox')
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 9. YOLO TESTIMONIAL */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Testimonial', 'yolo-motor' ),
                        'base'        => 'yolo_testimonial',
                        'icon'        => 'fa fa-comments',
                        'description' => esc_html__( 'Display client testimonials', 'yolo-motor' ),
                        'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Layout Style', 'yolo-motor' ),
                                'param_name' => 'layout_type',
                                'value'      => array(
                                    esc_html__( 'Carousel', 'yolo-motor' )   => 'carousel',
                                    esc_html__( 'Carousel 2', 'yolo-motor' ) => 'carousel_2',
                                    esc_html__( 'Slider Pro', 'yolo-motor' ) => 'slider_pro',
                                    esc_html__( 'Slider Pro 2', 'yolo-motor' ) => 'slider_pro_2'
                                ),
                            ),
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Source', 'yolo-motor' ),
                                'param_name'  => 'data_source',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'From Category', 'yolo-motor' )        => '',
                                    esc_html__( 'From Testimonial IDs', 'yolo-motor' ) => 'list_id'
                                )
                            ),
                            array(
                                'type'        => 'testimonial-cat',
                                'heading'     => esc_html__( 'Testimonial Category', 'yolo-motor' ),
                                'param_name'  => 'category',
                                'admin_label' => true,
                                'dependency'  => array(
                                    'element' => 'data_source', 
                                    'value'   => array('')
                                ),
                            ),
                            array(
                                'type'       => 'testimonial-single',
                                'heading'    => esc_html__( 'Select Testimonial', 'yolo-motor' ),
                                'param_name' => 'testimonial_ids',
                                'dependency' => array(
                                    'element' => 'data_source', 
                                    'value'   => array('list_id')
                                )
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Order Post Date By', 'yolo-motor' ),
                                'param_name' => 'order',
                                'value'      => array(
                                    esc_html__('Descending', 'yolo-motor') => 'DESC', 
                                    esc_html__('Ascending', 'yolo-motor')  => 'ASC'
                                )
                            ),
                            array(
                                "type"        => "textfield",
                                "heading"     => esc_html__( "Excerpt length", 'yolo-motor' ),
                                "param_name"  => "excerpt_length",
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                                'std'              => '20'
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'AutoPlay', 'yolo-motor' ),
                                'param_name' => 'autoplay',
                                'value'      => array(
                                    esc_html__( 'Yes', 'yolo-motor') => 'true', 
                                    esc_html__( 'No', 'yolo-motor')  => 'false'
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                            ),
                            array(
                                "type"             => "textfield",
                                "heading"          => esc_html__( "Slide Duration (ms)", 'yolo-motor' ),
                                "param_name"       => "slide_duration",
                                'std'             => '1000',
                                "admin_label"      => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 10. YOLO RECENT NEWS */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Recent News', 'yolo-motor' ),
                        'base'        => 'yolo_recent_news',
                        'icon'        => 'fa fa-bookmark',
                        'description' => esc_html__( 'Display latest post or selected post', 'yolo-motor' ),
                        'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'param_name'  => 'layout_type',
                                'heading'     => esc_html__( 'Choose layout', 'yolo-motor' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Home V1', 'yolo-motor' )   => 'home_1',
                                    esc_html__( 'Home V2', 'yolo-motor' )   => 'home_2',
                                    esc_html__( 'Home V3', 'yolo-motor' )   => 'home_3',
                                    esc_html__( 'Home V4', 'yolo-motor' )   => 'home_4',
                                    esc_html__( 'Home V6', 'yolo-motor' )   => 'home_6'
                                )
                            ),
                            array(
                                'type'        => 'blog-cat',
                                'heading'     => esc_html__( 'Select Categories', 'yolo-motor' ),
                                'param_name'  => 'category',
                                'admin_label' => true
                            ),
                            array(
                                'param_name'  => 'columns', 
                                'heading'     => esc_html__( 'Number of Columns', 'yolo-motor' ), 
                                'type'        => 'dropdown', 
                                'admin_label' => true, 
                                'value'       => array(
                                    esc_html__( '2', 'yolo-motor' ) => '2',
                                    esc_html__( '3', 'yolo-motor' ) => '3', 
                                    esc_html__( '4', 'yolo-motor' ) => '4' 
                                ),
                                'dependency' => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_4', 'home_6' )
                                )
                            ),
                            array(
                                'param_name'  => 'rows',
                                'heading'     => esc_html__( 'Number of Rows', 'yolo-motor' ),
                                'type'        => 'dropdown',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( '1', 'yolo-motor' ) => '1',
                                    esc_html__( '2', 'yolo-motor' ) => '2'
                                ),
                                'dependency'  => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_2' )
                                )
                            ),
                            array(
                                'param_name'  => 'posts_per_row',
                                'heading'     => esc_html__( 'Posts per row', 'yolo-motor' ),
                                'type'        => 'dropdown',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( '1', 'yolo-motor' ) => '1',
                                    esc_html__( '2', 'yolo-motor' ) => '2'
                                ),
                                'dependency'  => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_2' )
                                )
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'AutoPlay', 'yolo-motor' ),
                                'param_name' => 'autoplay',
                                'value'      => array(
                                    esc_html__( 'Yes', 'yolo-motor') => 'true', 
                                    esc_html__( 'No', 'yolo-motor')  => 'false'
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'dependency'  => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_2', 'home_3' )
                                )
                            ),
                            array(
                                'type'             => 'textfield',
                                'heading'          => esc_html__( 'Slide Duration (ms)', 'yolo-motor' ),
                                'param_name'       => 'slide_duration',
                                'std'              => '1000',
                                'admin_label'      => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'dependency'  => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_2', 'home_3' )
                                )
                            ),
                            array( 
                                'param_name'  => 'posts_per_page', 
                                'heading'     => esc_html__( 'Posts per page', 'yolo-motor' ), 
                                'type'        => 'textfield', 
                                'admin_label' => true,
                                'dependency'  => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_1', 'home_2', 'home_3', 'home_4', 'home_6' )
                                )
                            ),
                            array(
                                'param_name'  => 'posts_number',
                                'heading'     => esc_html__( 'Posts number', 'yolo-motor' ),
                                'type'        => 'textfield',
                                'admin_label' => true,
                                'dependency'    => array(
                                    'element'   => 'layout_type',
                                    'value'     => array( 'home_4' )
                                )
                            ),
                            array(
                                'param_name'  => 'excerpt_length',
                                'heading'     => esc_html__( 'Excerpt Length', 'yolo-motor' ),
                                'description' => esc_html__( 'Insert number of words to show in excerpt.', 'yolo-motor' ),
                                'type'        => 'textfield',
                                'value'       => '',
                                'admin_label' => true,
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 11. YOLO COUNTDOWN */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Countdown', 'yolo-motor' ),
                        'base'        => 'yolo_countdown',
                        'icon'        => 'fa fa-clock-o',
                        'description' => esc_html__( 'Display Countdown timer', 'yolo-motor' ),
                        'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'param_name'  => 'datetime',
                                'type'        => 'yolo_datetime',
                                'heading'     => esc_html__( 'Select Datetime', 'yolo-motor' ),
                                'admin_label' => true,
                                'value'       => ''
                            ),
                            array(
                                'param_name'  => 'layout_type',
                                'heading'     => esc_html__( 'Choose layout', 'yolo-motor' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Number', 'yolo-motor' )   => 'number',
                                    esc_html__( 'Circle', 'yolo-motor' )   => 'circle'
                                )
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 12. YOLO BANNER */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Banner', 'yolo-motor' ),
                        'base'        => 'yolo_banner',
                        'icon'        => 'fa fa-windows',
                        'description' => esc_html__( 'Display banner', 'yolo-motor' ),
                        'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Layout Style', 'yolo-motor' ),
                                'param_name' => 'layout_type',
                                'value'      => array(
                                    esc_html__( 'Style 1', 'yolo-motor' ) => 'style_1',
                                    esc_html__( 'Style 2', 'yolo-motor' ) => 'style_2',
                                    esc_html__( 'Style 3', 'yolo-motor' ) => 'style_3',
                                    // esc_html__( 'Style 4', 'yolo-motor' ) => 'style_4',
                                    esc_html__( 'Style 5', 'yolo-motor' ) => 'style_5',
                                    esc_html__( 'Style 6', 'yolo-motor' ) => 'style_6',
                                    esc_html__( 'Style 7', 'yolo-motor' ) => 'style_7',
                                    esc_html__( 'Style 8', 'yolo-motor' ) => 'style_8'
                                ),
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__( 'Title', 'yolo-motor' ),
                                'param_name'  => 'title',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                             array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Title Style', 'yolo-motor' ),
                                'param_name' => 'title_type',
                                'value'      => array(
                                    esc_html__( 'Top', 'yolo-motor' )    => 'title_top',
                                    esc_html__( 'Bottom', 'yolo-motor' ) => 'title_bottom'
                                ),
                                'dependency' => array(
                                    'element' => 'layout_type',
                                    'value'   => array('style_1','style_3',),
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                             array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Shadow Style', 'yolo-motor' ),
                                'param_name' => 'title_align',
                                'std'        => 'align_center',
                                'value'      => array(
                                    esc_html__( 'Left', 'yolo-motor' )  => 'align_left',
                                    esc_html__( 'Right', 'yolo-motor' ) => 'align_right',
                                    esc_html__( 'Center', 'yolo-motor' ) => 'align_center'
                                ),
                                'dependency' => array(
                                    'element' => 'layout_type',
                                    'value'   => 'style_3',
                                ),
                            ),
                            array(
                                'type'        => 'vc_link',
                                'heading'     => esc_html__( 'Link', 'yolo-motor' ),
                                'param_name'  => 'link',
                                'admin_label' => true,
                                  'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'type'        => 'attach_image',
                                'heading'     => esc_html__( 'Banner\'s Image', 'yolo-motor' ),
                                'param_name'  => 'image',
                                'admin_label' => true,
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__( 'Label', 'yolo-motor' ),
                                'param_name'  => 'label',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                             array(
                                'type'        => 'colorpicker',
                                'heading'     => esc_html__( 'Background color label', 'yolo-motor' ),
                                'param_name'  => 'bg_lable_color',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__( 'Price', 'yolo-motor' ),
                                'param_name'  => 'price',
                                'admin_label' => true,
                                 'dependency' => array(
                                    'element' => 'layout_type',
                                    'value'   => array('style_2'),
                                ),
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Shadow Style', 'yolo-motor' ),
                                'param_name' => 'shadow_type',
                                'value'      => array(
                                    esc_html__( 'Left', 'yolo-motor' )  => 'shadow_left',
                                    esc_html__( 'Right', 'yolo-motor' ) => 'shadow_right'
                                ),
                                'dependency' => array(
                                    'element' => 'layout_type',
                                    'value'   => 'style_8',
                                ),
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 13. YOLO CLIENTS */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Clients', 'yolo-motor' ),
                        'base'        => 'yolo_clients',
                        'icon'        => 'fa fa-users',
                        'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => esc_html__( 'Display client logos', 'yolo-motor' ),
                        'params'      => array(
                            array(
                                'type'        => 'param_group',
                                'heading'     => esc_html__( 'Clients', 'yolo-motor' ),
                                'param_name'  => 'clients',
                                'description' => esc_html__( 'Enter values for client - name, image and url.', 'yolo-motor' ),
                                'value'       => urlencode( json_encode( array(
                                    array(
                                        'name' => esc_html__( 'Themeforest', 'yolo-motor' ),
                                        'logo' => '',
                                        'url'  => '',
                                    ),
                                    array(
                                        'name'  => esc_html__( 'Codecanyon', 'yolo-motor' ),
                                        'value' => '',
                                        'url'   => '',
                                    ),
                                    array(
                                        'name'  => esc_html__( 'Photodune', 'yolo-motor' ),
                                        'value' => '',
                                        'url'   => '',
                                    ),
                                ) ) ),
                                'params' => array(
                                    array(
                                        'type'        => 'textfield',
                                        'heading'     => esc_html__( 'Name', 'yolo-motor' ),
                                        'param_name'  => 'name',
                                        'description' => esc_html__( 'Enter name of client.', 'yolo-motor' ),
                                        'admin_label' => true,
                                    ),
                                    array(
                                        'type'        => 'attach_image',
                                        'heading'     => esc_html__( 'Image', 'yolo-motor' ),
                                        'param_name'  => 'logo',
                                        'description' => esc_html__( 'Please select client\' logo.', 'yolo-motor' ),
                                        'admin_label' => true,
                                    ),
                                    array(
                                        'type'        => 'textfield',
                                        'heading'     => esc_html__( 'Url', 'yolo-motor' ),
                                        'param_name'  => 'url',
                                        'description' => esc_html__( 'Please insert client\' link.', 'yolo-motor' ),
                                        'admin_label' => true,
                                    ),
                                ),
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'AutoPlay', 'yolo-motor' ),
                                'param_name' => 'autoplay',
                                'value'      => array(
                                    esc_html__( 'Yes', 'yolo-motor') => 'true', 
                                    esc_html__( 'No', 'yolo-motor')  => 'false'
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'type'             => 'textfield',
                                'heading'          => esc_html__( 'Slide Duration (ms)', 'yolo-motor' ),
                                'param_name'       => 'slide_duration',
                                'std'              => '1000',
                                'admin_label'      => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array(
                                'param_name'  => 'layout_type',
                                'heading'     => esc_html__( 'Choose layout', 'yolo-motor' ),
                                'description' => '',
                                'type'        => 'dropdown',
                                'value'       => array(
                                    esc_html__( 'Style 1', 'yolo-motor' )   => 'style_1',
                                    esc_html__( 'Style 2', 'yolo-motor' )   => 'style_2',
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            array( 
                                'param_name'  => 'logo_per_slide', 
                                'heading'     => esc_html__( 'Logo per slide', 'yolo-motor' ), 
                                'type'        => 'textfield',
                                'value'       => '5',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        ),
                    )
                );

                /* 14. YOLO ICON BOX */          
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Icon Box', 'yolo-motor' ),
                        'base'        => 'yolo_icon_box',
                        'icon'        => 'fa fa-info',
                        'description' => esc_html__( 'Display Icon box from libraries', 'yolo-motor' ),
                        'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Layout Style', 'yolo-motor' ),
                                'param_name' => 'layout_type',
                                'value'      => array(
                                    esc_html__( 'Style 1', 'yolo-motor' ) => 'style_1',
                                    esc_html__( 'Style 2', 'yolo-motor' ) => 'style_2',
                                    esc_html__( 'Style 3', 'yolo-motor' ) => 'style_3',
                                    esc_html__( 'Style 4', 'yolo-motor' ) => 'style_4'
                                ),
                            ),
                            array(
                                'type'    => 'dropdown',
                                'heading' => esc_html__( 'Icon library', 'yolo-motor' ),
                                'value'   => array(
                                    esc_html__( 'Font Awesome', 'yolo-motor' ) => 'fontawesome',
                                    esc_html__( 'Open Iconic', 'yolo-motor' )  => 'openiconic',
                                    esc_html__( 'Typicons', 'yolo-motor' )     => 'typicons',
                                    esc_html__( 'Entypo', 'yolo-motor' )       => 'entypo',
                                    esc_html__( 'Linecons', 'yolo-motor' )     => 'linecons',
                                ),
                                'admin_label' => true,
                                'param_name'  => 'type',
                                'description' => esc_html__( 'Select icon library.', 'yolo-motor' ),
                            ),
                            array(
                                'type'       => 'iconpicker',
                                'heading'    => esc_html__( 'Icon', 'yolo-motor' ),
                                'param_name' => 'icon_fontawesome',
                                'value'      => 'fa fa-adjust', // default value to backend editor admin_label
                                'settings'   => array(
                                    'emptyIcon'    => false,
                                    // default true, display an "EMPTY" icon?
                                    'iconsPerPage' => 4000,
                                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                                ),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => 'fontawesome',
                                ),
                                'description' => esc_html__( 'Select icon from library.', 'yolo-motor' ),
                            ),
                            array(
                                'type'       => 'iconpicker',
                                'heading'    => esc_html__( 'Icon', 'yolo-motor' ),
                                'param_name' => 'icon_openiconic',
                                'value'      => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                                'settings'   => array(
                                    'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                    'type'         => 'openiconic',
                                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                ),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => 'openiconic',
                                ),
                                'description' => esc_html__( 'Select icon from library.', 'yolo-motor' ),
                            ),
                            array(
                                'type'       => 'iconpicker',
                                'heading'    => esc_html__( 'Icon', 'yolo-motor' ),
                                'param_name' => 'icon_typicons',
                                'value'      => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                                'settings'   => array(
                                    'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                    'type'         => 'typicons',
                                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                ),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => 'typicons',
                                ),
                                'description' => esc_html__( 'Select icon from library.', 'yolo-motor' ),
                            ),
                            array(
                                'type'       => 'iconpicker',
                                'heading'    => esc_html__( 'Icon', 'yolo-motor' ),
                                'param_name' => 'icon_entypo',
                                'value'      => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                                'settings'   => array(
                                    'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                    'type'         => 'entypo',
                                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                ),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => 'entypo',
                                ),
                            ),
                            array(
                                'type'       => 'iconpicker',
                                'heading'    => esc_html__( 'Icon', 'yolo-motor' ),
                                'param_name' => 'icon_linecons',
                                'value'      => 'vc_li vc_li-heart', // default value to backend editor admin_label
                                'settings'   => array(
                                    'emptyIcon'    => false, // default true, display an "EMPTY" icon?
                                    'type'         => 'linecons',
                                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                                ),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value'   => 'linecons',
                                ),
                                'description' => esc_html__( 'Select icon from library.', 'yolo-motor' ),
                            ),
                            array(
                                'type'               => 'dropdown',
                                'heading'            => esc_html__( 'Icon color', 'yolo-motor' ),
                                'param_name'         => 'color',
                                'value'              => array_merge( getVcShared( 'colors' ), array( esc_html__( 'Custom color', 'yolo-motor' ) => 'custom' ) ),
                                'description'        => esc_html__( 'Select icon color.', 'yolo-motor' ),
                                'param_holder_class' => 'vc_colored-dropdown',
                            ),
                            array(
                                'type'        => 'colorpicker',
                                'heading'     => esc_html__( 'Custom color', 'yolo-motor' ),
                                'param_name'  => 'custom_color',
                                'description' => esc_html__( 'Select custom icon color.', 'yolo-motor' ),
                                'dependency'  => array(
                                    'element' => 'color',
                                    'value'   => 'custom',
                                ),
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__( 'Title', 'yolo-motor' ),
                                'param_name'  => 'title',
                                'admin_label' => true
                            ),
                            array(
                                'type'        => 'vc_link',
                                'heading'     => esc_html__( 'Link', 'yolo-motor' ),
                                'param_name'  => 'link',
                                'admin_label' => true
                            ),
                            array(
                                'type'        => 'textarea',
                                'heading'     => esc_html__( 'Description', 'yolo-motor' ),
                                'param_name'  => 'description',
                                'admin_label' => true,
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 15. YOLO TEAM MEMBER */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Team Member', 'yolo-motor' ),
                        'base'        => 'yolo_teammember',
                        'icon'        => 'fa fa-users',
                        'description' => esc_html__( 'Display our team member', 'yolo-motor' ),
                        'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type'        => 'dropdown',
                                'heading'     => esc_html__( 'Source', 'yolo-motor' ),
                                'param_name'  => 'data_source',
                                'admin_label' => true,
                                'value'       => array(
                                    esc_html__( 'From Category', 'yolo-motor' )   => '',
                                    esc_html__( 'From Member IDs', 'yolo-motor' ) => 'list_id'
                                )
                            ),
                            array(
                                'type'        => 'team-cat',
                                'heading'     => esc_html__( 'Teammember Category', 'yolo-motor' ),
                                'param_name'  => 'category',
                                'admin_label' => true,
                                'dependency'  => array(
                                    'element' => 'data_source', 
                                    'value'   => array('')
                                ),
                            ),
                            array(
                                'type'       => 'team-single',
                                'heading'    => esc_html__( 'Select Teammember', 'yolo-motor' ),
                                'param_name' => 'member_ids',
                                'dependency' => array(
                                    'element' => 'data_source', 
                                    'value'   => array('list_id')
                                )
                            ),
                            array(
                                'type'             => 'dropdown',
                                'heading'          => esc_html__( 'Layout Style', 'yolo-motor' ),
                                'param_name'       => 'layout_type',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'value'            => array(
                                    esc_html__( 'Carousel', 'yolo-motor' )   => 'carousel'
                                ),
                            ),
                            array( 
                                'param_name'       => 'member_per_slide', 
                                'heading'          => esc_html__( 'Members per slide', 'yolo-motor' ), 
                                'type'             => 'textfield',
                                'value'            => '3',
                                'admin_label'      => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                                'dependency'       => array(
                                    'element' => 'layout_type', 
                                    'value'   => array('carousel')
                                )
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'Order Post Date By', 'yolo-motor' ),
                                'param_name' => 'order',
                                'value'      => array(
                                    esc_html__('Descending', 'yolo-motor') => 'DESC', 
                                    esc_html__('Ascending', 'yolo-motor')  => 'ASC'
                                )
                            ),
                            array(
                                'type'       => 'dropdown',
                                'heading'    => esc_html__( 'AutoPlay', 'yolo-motor' ),
                                'param_name' => 'autoplay',
                                'value'      => array(
                                    esc_html__( 'Yes', 'yolo-motor') => 'true', 
                                    esc_html__( 'No', 'yolo-motor')  => 'false'
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                            ),
                            array(
                                "type"             => "textfield",
                                "heading"          => esc_html__( "Slide Duration (ms)", 'yolo-motor' ),
                                "param_name"       => "slide_duration",
                                'std'             => '1000',
                                "admin_label"      => true,
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding', 
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );

                /* 16. YOLO GOOGLE MAPS */
                vc_map(
                    array(
                        'name'        => esc_html__( 'Yolo Google Maps', 'yolo-motor' ),
                        'base'        => 'yolo_gmaps',
                        'icon'        => 'fa fa-map-marker',
                        'description' => esc_html__( 'Display Google Maps with information', 'yolo-motor' ),
                        'category'    => YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                "type"       => "dropdown",
                                "class"      => "",
                                "heading"    => esc_html__("Choose style layout",'yolo-motor'),
                                "param_name" => "layout_type",
                                "value"      => array(
                                    esc_html__( 'Show Map', 'yolo-motor' )      => 'show_map',
                                    esc_html__( 'Toggle Button', 'yolo-motor' ) => 'toggle_button'
                                )
                            ),
                            array(
                                "type"       => "dropdown",
                                "class"      => "",
                                "heading"    => esc_html__("Choose style map",'yolo-motor'),
                                "param_name" => "light_map",
                                "value"      => array(
                                    esc_html__( 'Basic', 'yolo-motor' )          => 'basic',
                                    esc_html__( 'Light green', 'yolo-motor' )    => 'light_green',
                                    esc_html__( 'Shades of Grey', 'yolo-motor' ) => 'shades_grey',
                                    esc_html__( 'Ultra Light', 'yolo-motor' )    => 'ultra_light',
                                )
                             ),
                            array(
                                "type"        => "textarea",
                                "class"       => "",
                                "heading"     => esc_html__( "Info window title", 'yolo-motor' ),
                                "param_name"  => "info_title",
                                "value"       => esc_html__( "My address", 'yolo-motor' ),
                                "description" => ""
                            ),
                            array(
                                "type"        => "attach_image",
                                "class"       => "",
                                "heading"     => esc_html__( "Info window image", 'yolo-motor' ),
                                "param_name"  => "info_image",
                                "value"       => esc_html__( "My address", 'yolo-motor' ),
                                "description" => ""
                            ),
                            array(
                                "type"        => "textfield",
                                "class"       => "",
                                "heading"     => esc_html__( "Map height", 'yolo-motor' ),
                                "param_name"  => "height",
                                "value"       => esc_html__( "400px", 'yolo-motor' ),
                                "description" => esc_html__( "Example: 500px", 'yolo-motor' )
                            ),
                            array(
                                "type"        => "textfield",
                                "class"       => "",
                                "heading"     => esc_html__( "Latitude",'yolo-motor' ),
                                "param_name"  => "lat",
                                "value"       => esc_html__( "40.843292",'yolo-motor' ),
                                "description" => esc_html__( "Get longtitude from here: https://www.google.com/maps",'yolo-motor' )
                            ),
                            array(
                                "type"        => "textfield",
                                "class"       => "",
                                "heading"     => esc_html__( "Longitude", 'yolo-motor' ),
                                "param_name"  => "lng",
                                "value"       => esc_html__( "-73.864512", 'yolo-motor' ),
                                "description" => esc_html__( "Get longtitude from here: https://www.google.com/maps", 'yolo-motor' )
                            ),
                            array(
                                "type"        => "textfield",
                                "class"       => "",
                                "heading"     => esc_html__( "Zoom", 'yolo-motor' ),
                                "param_name"  => "zoom",
                                "value"       => esc_html__( "12", 'yolo-motor' ),
                                "description" => esc_html__( "Example : 20 for a close view, 5 for a far view",'yolo-motor' )
                            ),
                            array(
                                'type'        => 'attach_image',
                                'heading'     => esc_html__( 'Image to replace marker', 'yolo-motor' ),
                                'param_name'  => 'image',
                                'value'       => '',
                                'description' => esc_html__( 'Select the image to replace the original map marker (optional).', 'yolo-motor' )
                            ),
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );
               
                /* 17. YOLO */
            }
        }
    }

    if ( ! function_exists('init_yolo_framework_shortcodes') ) {
        function init_yolo_framework_shortcodes() {
            return Yolo_MotorFramework_Shortcodes::init();
        }

        init_yolo_framework_shortcodes();
    }
}