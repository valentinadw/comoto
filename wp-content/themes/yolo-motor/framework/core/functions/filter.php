<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    16/1/2016
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

/*================================================
FILTER SEARCH FORM
================================================== */
if (!function_exists('yolo_search_form')) {
    function yolo_search_form($form) {
        $form = '<form role="search" class="search-form" method="get" id="searchform" action="' . home_url('/') . '">
	                <input type="text" value="' . get_search_query() . '" name="s" id="s"  placeholder="' . esc_html__( "Search Here...", 'yolo-motor' ) . '">
	                <button type="submit"><i class="fa fa-search"></i></button>
	     		</form>';
        return $form;
    }
    add_filter('get_search_form', 'yolo_search_form');
}

/*================================================
FILTER TAG FORMAT
================================================== */
if (!function_exists('yolo_tag_cloud')) {
    function yolo_tag_cloud($tag_string) {
        return preg_replace("/style='font-size:.+pt;'/", '', $tag_string);
    }
    add_filter('wp_generate_tag_cloud', 'yolo_tag_cloud', 10, 3);
}

/* CUSTOM PAGE TEMPLATE
================================================== */
if (!function_exists('yolo_page_template_custom')) {
	function yolo_page_template_custom($template ) {
		if (isset($_REQUEST['yolo-custom-page']) && !empty($_REQUEST['yolo-custom-page'])) {
			global $yolo_is_do_action_custom_page;
			if (!isset($yolo_is_do_action_custom_page) || $yolo_is_do_action_custom_page !== '1') {
				$yolo_is_do_action_custom_page = '1';
				do_action('yolo-custom-page/'.$_REQUEST['yolo-custom-page']);
				return;
			}
		}
		return $template;

	}
	add_filter( "page_template", "yolo_page_template_custom" );
}

if (!function_exists('yolo_style_loader_tag')) {
	function yolo_style_loader_tag($html, $handle ) {
		return str_replace( " href='", " property='stylesheet' href='", $html );
	}
	add_filter( 'style_loader_tag', 'yolo_style_loader_tag', 10, 2);
}