<?php
/**
 *  
 * @package    YoloTheme/Yolo Motor
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 *
 * 1. Autocomplete ProductID functions
 * 2. Add shortcode param
 * 2.1. Add shortcode param datetimepicker
*/

/*
* 1. Autocomplete ProductID functions
*/
function productIdAutocompleteSuggester( $query ) {
    global $wpdb;
    $product_id = (int) $query;
    $post_meta_infos = $wpdb->get_results(
        $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
            FROM {$wpdb->posts} AS a
            LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
            WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )",
            $product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A
        );

    $results = array();
    if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
        foreach ( $post_meta_infos as $value ) {
            $data = array();
            $data['value'] = $value['id'];
            $data['label'] = __( 'Id', 'js_composer' ) . ': ' .
            $value['id'] .
            ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . __( 'Title', 'js_composer' ) . ': ' .
                $value['title'] : '' ) .
            ( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . __( 'Sku', 'js_composer' ) . ': ' .
                $value['sku'] : '' );
            $results[] = $data;
        }
    }

    return $results;
}

function productIdAutocompleteRender( $query ) {
    $query = trim( $query['value'] ); // get value from requested
    if ( ! empty( $query ) ) {
        // get product
        $product_object = wc_get_product( (int) $query );
        if ( is_object( $product_object ) ) {
            $product_sku = $product_object->get_sku();
            $product_title = $product_object->get_title();
            $product_id = $product_object->id;

            $product_sku_display = '';
            if ( ! empty( $product_sku ) ) {
                $product_sku_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $product_sku;
            }

            $product_title_display = '';
            if ( ! empty( $product_title ) ) {
                $product_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $product_title;
            }

            $product_id_display = __( 'Id', 'js_composer' ) . ': ' . $product_id;

            $data = array();
            $data['value'] = $product_id;
            $data['label'] = $product_id_display . $product_title_display . $product_sku_display;

            return ! empty( $data ) ? $data : false;
        }

        return false;
    }

    return false;
}

function productIdDefaultValue( $current_value, $param_settings, $map_settings, $atts ) {
    $value = trim( $current_value );
    if ( strlen( trim( $current_value ) ) === 0 && isset( $atts['sku'] ) && strlen( $atts['sku'] ) > 0 ) {
        $value = productIdDefaultValueFromSkuToId( $atts['sku'] );
    }

    return $value;
    }

    function productIdDefaultValueFromSkuToId( $query ) {
    $result = productIdAutocompleteSuggesterExactSku( $query );

    return isset( $result['value'] ) ? $result['value'] : false;
    }

    function productIdAutocompleteSuggesterExactSku( $query ) {
    global $wpdb;
    $query = trim( $query );
    $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", stripslashes( $query ) ) );
    $product_data = get_post( $product_id );
    if ( 'product' !== $product_data->post_type ) {
        return '';
    }

    $product_object = wc_get_product( $product_data );
    if ( is_object( $product_object ) ) {

        $product_sku = $product_object->get_sku();
        $product_title = $product_object->get_title();
        $product_id = $product_object->id;

        $product_sku_display = '';
        if ( ! empty( $product_sku ) ) {
            $product_sku_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $product_sku;
        }

        $product_title_display = '';
        if ( ! empty( $product_title ) ) {
            $product_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $product_title;
        }

        $product_id_display = __( 'Id', 'js_composer' ) . ': ' . $product_id;

        $data = array();
        $data['value'] = $product_id;
        $data['label'] = $product_id_display . $product_title_display . $product_sku_display;

        return ! empty( $data ) ? $data : false;
    }

    return false;
}
/* 2. Add shortcode param 
* More details here: https://wpbakery.atlassian.net/wiki/display/VC/Create+New+Param+Type
*/
/* 2.1. Add shortcode param datetime picker */
if ( ! function_exists( 'yolo_render_multi_select' ) ) :
    function yolo_render_multi_select( $param_name ) {
        $output .= '<script type="text/javascript">
                    jQuery(document).ready(function($){
                        $("#' . $param_name . '_select2").select2();
                        var order = $("#' . $param_name . '").val();
                        if(order != undefined){
                            if (order != "") {
                                order = order.split(",");
                                var choices = [];
                                for (var i = 0; i < order.length; i++) {
                                    var option = $("#' . $param_name . '_select2 option[value="+ order[i]  + "]");
                                    if (option.length > 0) {
                                        choices[i] = {id:order[i], text:option[0].label, element: option};
                                    }
                                }
                                $("#' . $param_name . '_select2").select2("data", choices);
                            }
                        }

                        $("#' . $param_name . '_select2").on("select2-selecting", function(e) {
                            var ids = $("#' . $param_name . '").val();
                            if (ids != "") {
                                ids +=",";
                            }
                            ids += e.val;
                            $("#' . $param_name . '").val(ids);
                        }).on("select2-removed", function(e) {
                              var ids = $("#' . $param_name . '").val();
                              var arr_ids = ids.split(",");
                              var newIds = "";
                              for(var i = 0 ; i < arr_ids.length; i++) {
                                if (arr_ids[i] != e.val){
                                    if (newIds != "") {
                                        newIds +=",";
                                    }
                                    newIds += arr_ids[i];
                                }
                              }
                              $("#' . $param_name . '").val(newIds);
                         });

                        $("#' . $param_name . '_select_all").click(function(){
                            if($("#' . $param_name . '_select_all").is(":checked") ){
                                $("#' . $param_name . '_select2 > option").prop("selected","selected");
                                $("#' . $param_name . '_select2").trigger("change");
                                var arr_ids =  $("#' . $param_name . '_select2").select2("val");
                                var ids = "";
                                for (var i = 0; i < arr_ids.length; i++ ) {
                                    if (ids != "") {
                                        ids +=",";
                                    }
                                    ids += arr_ids[i];
                                }
                                $("#' . $param_name . '").val(ids);

                            }else{
                                $("#' . $param_name . '_select2 > option").removeAttr("selected");
                                $("#' . $param_name . '_select2").trigger("change");
                                $("#' . $param_name . '").val("");
                            }
                        });
                    });
                    </script>
                    <style>
                        .multi-select {
                          width: 100%;
                        }
                        .select2-drop {
                            z-index: 100000;
                        }
                    </style>';
        echo $output;
    }
endif;
if ( ! function_exists( 'yolo_shortcode_param_datetime' ) ) :
    function yolo_shortcode_param_datetime( $settings, $value ) {
        // Load datetimepicker library from admin
        $html[] = '<div class="yolo_datetime_param">';
        $html[] = '     <input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" id="datetimepicker"/>';
        $html[] = '</div>';

        return implode( "\n", $html );
    }

    vc_add_shortcode_param( 'yolo_datetime', 'yolo_shortcode_param_datetime', plugins_url() . '/motor-framework/admin/assets/js/admin.js' );
endif;

if ( ! function_exists( 'yolo_number_settings_field' ) ) :
    function yolo_number_settings_field( $settings, $value ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type       = isset($settings['type']) ? $settings['type'] : '';
        $min        = isset($settings['min']) ? $settings['min'] : '';
        $max        = isset($settings['max']) ? $settings['max'] : '';
        $suffix     = isset($settings['suffix']) ? $settings['suffix'] : '';
        $class      = isset($settings['class']) ? $settings['class'] : '';
        $output     = '<input type="number" min="' . esc_attr($min) . '" max="' . esc_attr($max) . '" class="wpb_vc_param_value ' . esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) . '" name="' . esc_attr($param_name) . '" value="' . esc_attr($value) . '" style="max-width:100px; margin-right: 10px;" />' . esc_attr($suffix);
        
        return $output;
    }

    vc_add_shortcode_param('number', 'yolo_number_settings_field');
endif;  

if ( ! function_exists( 'yolo_icon_text_settings_field' ) ) :
    function yolo_icon_text_settings_field( $settings, $value ) {
        return '<div class="vc-text-icon">'
        . '<input  name="' . $settings['param_name'] . '" style="width:80%;" class="wpb_vc_param_value wpb-textinput widefat input-icon ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" type="text" value="' . esc_attr($value) . '"/>'
        . '<input title="' . esc_html__('Click to browse icon', 'yolo-motor') . '" style="width:20%; height:34px;" class="browse-icon button-secondary" type="button" value="' . esc_html__('Browse Icon', 'yolo-motor') . '" >'
        . '<span class="icon-preview"><i class="' . esc_attr($value) . '"></i></span>'
        . '</div>';
    }

    vc_add_shortcode_param('icon_text', 'yolo_icon_text_settings_field');
endif; 

/*=====================================
    Type: Multi Select (multi-select)
=====================================*/
if ( ! function_exists( 'yolo_multi_select_settings_field_shortcode_param' ) ) :
    function yolo_multi_select_settings_field_shortcode_param( $settings, $value ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $param_option = isset($settings['options']) ? $settings['options'] : '';
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $text_val => $val) {
                if (is_numeric($text_val) && (is_string($val) || is_numeric($val))) {
                    $text_val = $val;
                }
                $output .= '<option id="' . $val . '" value="' . $val . '">' . htmlspecialchars($text_val) . '</option>';
            }
        }
        $output .= '</select><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'yolo-starter' );
       $output .= yolo_render_multi_select( $param_name );
        return $output;
    }

    vc_add_shortcode_param('multi-select', 'yolo_multi_select_settings_field_shortcode_param');
endif;

if ( ! function_exists( 'yolo_tags_settings_field_shortcode_param' ) ) :
    function yolo_tags_settings_field_shortcode_param( $settings, $value ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $output     =   '<input  name="' . $settings['param_name']
                        . '" class="wpb_vc_param_value wpb-textinput '
                        . $settings['param_name'] . ' ' . $settings['type']
                        . '" type="hidden" value="' . $value . '"/>';
        $output     .= '<input type="text" name="' . $param_name . '_tagsinput" id="' . $param_name . '_tagsinput" value="' . $value . '" data-role="tagsinput"/>';
        $output     .= '<script type="text/javascript">
                            jQuery(document).ready(function($){
                                $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();

                                $("#' . $param_name . '_tagsinput").on("itemAdded", function(event) {
                                     $("input[name=' . $param_name . ']").val($(this).val());
                                });

                                $("#' . $param_name . '_tagsinput").on("itemRemoved", function(event) {
                                     $("input[name=' . $param_name . ']").val($(this).val());
                                });
                            });
                        </script>';
        return $output;
    }

    vc_add_shortcode_param('tags', 'yolo_tags_settings_field_shortcode_param');
endif;
/*======================================
    Type: Blog Category(blog-cat)
=======================================*/
if ( ! function_exists( 'yolo_blog_cat_settings_field_shortcode_param' ) ) :
    function yolo_blog_cat_settings_field_shortcode_param( $settings, $value ) {
        $param_option='';
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $get_value = get_categories();
        if ($get_value != '' && is_array($get_value)) {
            foreach ($get_value as $cat) {
                $param_option[$cat->name] = $cat->slug;
            }
        }
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $text_val => $val) {
                $output .= '<option id="' . $val . '" value="' . $val . '">' . htmlspecialchars($text_val) . '</option>';
            }
        }
        $output .= '</select><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'yolo-starter' );
        $output .= yolo_render_multi_select( $param_name );
        return $output;
    }

    vc_add_shortcode_param('blog-cat', 'yolo_blog_cat_settings_field_shortcode_param');
endif; 
/*=======================================
    Product Single (woo-single-select)
==========================================*/
if ( ! function_exists( 'yolo_woo_single_settings_field_shortcode_param' ) ) :
    function yolo_woo_single_settings_field_shortcode_param( $settings, $value ) {
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'product',
            'post_status'    => 'publish'
        );
        $post_array   = get_posts($args);
        foreach ($post_array as $post) :
            $param_option[$post->post_title] = $post->ID;
        endforeach;
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="single-select">';
        if ($param_option != '' && is_array($param_option)) {
            $output .= '<option value="">'. esc_html_e('Select a product', 'yolo-motor') .'</option>';
            foreach ($param_option as $text_val => $val) {
                if (is_numeric($text_val) && (is_string($val) || is_numeric($val))) {
                    $text_val = $val;
                }
                if( $val == $value ) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $output .= '<option id="' . $val . '" value="' . $val . '"'. $selected .'>' . htmlspecialchars($text_val) . '</option>';
            }
        }

        $output .= '</select>';
        $output .= '<script type="text/javascript">
                    jQuery(document).ready(function($){
                        $("#' . $param_name . '_select2").select2({
                            placeholder: "Select a product"
                        });
                        $( "select[name=\'' . $param_name . '_select2\']" ).click( function() {
                            var selected_value = $(this).find("option:selected").val();
                            $( "input[name=\'' . $param_name . '\']" ).val( selected_value );
                        });
                    });
                    </script>
                    <style>
                        .multi-select {
                          width: 100%;
                        }
                        .select2-drop {
                            z-index: 100000;
                        }
                    </style>';
        return $output;
    }

    vc_add_shortcode_param('woo-single-select', 'yolo_woo_single_settings_field_shortcode_param');
endif;
/*=======================================================
    Type: Product Category (product-category)
 ==========================================================*/
if ( ! function_exists( 'yolo_product_cat_settings_field_shortcode_param' ) ) :
    function yolo_product_cat_settings_field_shortcode_param( $settings, $value ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $get_value = get_terms('product_cat');
        if ($get_value != '' && is_array($get_value)) {
            foreach ($get_value as $cat) {
                $param_option[$cat->name] = $cat->slug;
            }
        }
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $text_val => $val) {
                $output .= '<option id="' . $val . '" value="' . $val . '">' . htmlspecialchars($text_val) . '</option>';
            }
        }
        $output .= '</select><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'yolo-starter' );
        $output .= yolo_render_multi_select($param_name);
        return $output;
    }

    vc_add_shortcode_param('product-category', 'yolo_product_cat_settings_field_shortcode_param');
endif;
/*===============================================
    Type: woo-single-multi 
=================================================*/
if ( ! function_exists( 'yolo_woo_single_multi_settings_field_shortcode_param' ) ) :
    function yolo_woo_single_multi_settings_field_shortcode_param( $settings, $value ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'product',
            'post_status'    => 'publish'
        );
        $param_option = array();
        $post_array   = get_posts($args);
        foreach ($post_array as $post) :
            $param_option[$post->post_title] = $post->ID;
        endforeach;
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $key=>$val) {
                $output .= '<option id="' . $val. '" value="' . $val . '">' . htmlspecialchars($key) . '</option>';
            }
        }
        $output .= '</select><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'yolo-starter' );
        $output .= yolo_render_multi_select($param_name);
        return $output;
    }

    vc_add_shortcode_param('woo-single-multi', 'yolo_woo_single_multi_settings_field_shortcode_param');
endif;
/*=========================================
    Type: Porfolio Category
===========================================*/
if ( ! function_exists( 'yolo_portfolio_cat_settings_field_shortcode_param' ) ) :
    function yolo_portfolio_cat_settings_field_shortcode_param( $settings, $value ) {
        $param_option = '';
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $get_value = get_terms('portfolio_category');
        if ($get_value != '' && is_array($get_value)) {
            foreach ($get_value as $cat) {
                $param_option[$cat->name] = $cat->slug;
            }
        }
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $text_val => $val) {
                $output .= '<option id="' . $val . '" value="' . $val . '">' . htmlspecialchars($text_val) . '</option>';
            }
        }
        $output .= '</select><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'yolo-starter' );
        $output .= yolo_render_multi_select($param_name);
        return $output;
    }

    vc_add_shortcode_param('portfolio-cat', 'yolo_portfolio_cat_settings_field_shortcode_param');
endif;
/*=========================================
    Type: Porfolio Tag
===========================================*/
if ( ! function_exists( 'yolo_portfolio_tag_settings_field_shortcode_param' ) ) :
    function yolo_portfolio_tag_settings_field_shortcode_param( $settings, $value ) {
        $param_option = '';
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $get_value = get_terms('portfolio_tag');
        if ($get_value != '' && is_array($get_value)) {
            foreach ($get_value as $cat) {
                $param_option[$cat->name] = $cat->slug;
            }
        }
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $text_val => $val) {
                $output .= '<option id="' . $val . '" value="' . $val . '">' . htmlspecialchars($text_val) . '</option>';
            }
        }
        $output .= '</select><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'yolo-starter' );
        $output .= yolo_render_multi_select($param_name);
        return $output;
    }

    vc_add_shortcode_param('portfolio-tag', 'yolo_portfolio_tag_settings_field_shortcode_param');
endif;
/*=====================================
    Type: Portfolio Single
======================================*/
if ( ! function_exists( 'yolo_portfolio_single_settings_field_shortcode_param' ) ) :
    function yolo_portfolio_single_settings_field_shortcode_param( $settings, $value ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        // $param_option = isset($settings['options']) ? $settings['options'] : '';
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'yolo_portfolio',
            'post_status'    => 'publish'
        );
        $param_option = array();
        $post_array   = get_posts($args);
        foreach ($post_array as $post) :
            $param_option[$post->post_title] = $post->ID;
        endforeach;
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $key=>$val) {
                $output .= '<option id="' . $val. '" value="' . $val . '">' . htmlspecialchars($key) . '</option>';
            }
        }

        $output .= '</select><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'yolo-starter' );
        $output .= yolo_render_multi_select($param_name);
        return $output;
    }

    vc_add_shortcode_param('portfolio-single', 'yolo_portfolio_single_settings_field_shortcode_param');
endif;
/*=========================================
    Type: Testimonial Category
===========================================*/
if ( ! function_exists( 'yolo_testimonial_cat_settings_field_shortcode_param' ) ) :
    function yolo_testimonial_cat_settings_field_shortcode_param( $settings, $value ) {
        $param_option = '';
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $get_value = get_terms('testimonial_category');
        if ($get_value != '' && is_array($get_value)) {
            foreach ($get_value as $cat) {
                $param_option[$cat->name] = $cat->slug;
            }
        }
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $text_val => $val) {
                $output .= '<option id="' . $val . '" value="' . $val . '">' . htmlspecialchars($text_val) . '</option>';
            }
        }
        $output .= '</select><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'yolo-starter' );
        $output .= yolo_render_multi_select($param_name);
        return $output;
    }

    vc_add_shortcode_param('testimonial-cat', 'yolo_testimonial_cat_settings_field_shortcode_param');
endif;
/*=====================================
    Type: Testimonial Single
======================================*/
if ( ! function_exists( 'yolo_testimonial_single_settings_field_shortcode_param' ) ) :
    function yolo_testimonial_single_settings_field_shortcode_param( $settings, $value ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'yolo_testimonial',
            'post_status'    => 'publish'
        );
        $param_option = array();
        $post_array   = get_posts($args);
        foreach ($post_array as $post) :
            $param_option[$post->post_title] = $post->ID;
        endforeach;
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $key=>$val) {
                $output .= '<option id="' . $val. '" value="' . $val . '">' . htmlspecialchars($key) . '</option>';
            }
        }

        $output .= '</select><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'yolo-starter' );
        $output .= yolo_render_multi_select($param_name);
        return $output;
    }

    vc_add_shortcode_param('testimonial-single', 'yolo_testimonial_single_settings_field_shortcode_param');
endif;
/*=========================================
    Type: Team member Category
===========================================*/
if ( ! function_exists( 'yolo_team_cat_settings_field_shortcode_param' ) ) :
    function yolo_team_cat_settings_field_shortcode_param( $settings, $value ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $get_value = get_terms('team_category');
        if ($get_value != '' && is_array($get_value)) {
            foreach ($get_value as $cat) {
                $param_option[$cat->name] = $cat->slug;
            }
        }
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $text_val => $val) {
                $output .= '<option id="' . $val . '" value="' . $val . '">' . htmlspecialchars($text_val) . '</option>';
            }
        }
        $output .= '</select><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'yolo-starter' );
        $output .= yolo_render_multi_select($param_name);
        return $output;
    }

    vc_add_shortcode_param('team-cat', 'yolo_team_cat_settings_field_shortcode_param');
endif;
/*=====================================
    Type: Team Single
======================================*/
if ( ! function_exists( 'yolo_team_single_settings_field_shortcode_param' ) ) :
    function yolo_team_single_settings_field_shortcode_param( $settings, $value ) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'yolo_teammember',
            'post_status'    => 'publish'
        );
        $param_option = array();
        $post_array   = get_posts($args);
        foreach ($post_array as $post) :
            $param_option[$post->post_title] = $post->ID;
        endforeach;
        $output = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . '" value="' . $value . '"/>';
        $output .= '<select multiple id="' . $param_name . '_select2" name="' . $param_name . '_select2" class="multi-select">';
        if ($param_option != '' && is_array($param_option)) {
            foreach ($param_option as $key=>$val) {
                $output .= '<option id="' . $val. '" value="' . $val . '">' . htmlspecialchars($key) . '</option>';
            }
        }
        $output .= '</select><input type="checkbox" id="' . $param_name . '_select_all" >' . esc_html__( 'Select All', 'yolo-starter' );
        $output .= yolo_render_multi_select($param_name);
        return $output;
    }

    vc_add_shortcode_param('team-single', 'yolo_team_single_settings_field_shortcode_param');
endif;
