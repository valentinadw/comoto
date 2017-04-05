<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    25/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 */

/*================================================
FOOTER BLOCK
================================================== */
if (!function_exists('yolo_footer_style')) {
    function yolo_footer_style() {
        yolo_get_template('footer/footer-style');
    }
    add_action('wp_head','yolo_footer_style',10);
}
if (!function_exists('yolo_footer_content')) {
    function yolo_footer_content() {
        yolo_get_template('footer/footer-content');
    }
    add_action('yolo_main_wrapper_footer','yolo_footer_content',10);
}
/* ================================================
GET FOOTER LIST
================================================== */
if ( !function_exists( 'yolo_get_footer_list' ) ){
    function yolo_get_footer_list() {
        $args = array(
            'posts_per_page'   => -1,
            'post_type'        => 'yolo_footer',
            'post_status'      => 'publish',
        );
        $posts_array = get_posts( $args );
        foreach ( $posts_array as $k => $v ) {
            $footer[$v->ID] = $v->post_title;
        }

        return $footer;
    }
}


/*================================================
BACK TO TOP
================================================== */
if (!function_exists('yolo_back_to_top')) {
    function yolo_back_to_top() {
        $yolo_options = yolo_get_options();
        
        $back_to_top = $yolo_options['back_to_top'];
        if ($back_to_top == 1) {
            yolo_get_template('back-to-top');
        }
    }
    add_action('yolo_after_page_wrapper','yolo_back_to_top',5);
}