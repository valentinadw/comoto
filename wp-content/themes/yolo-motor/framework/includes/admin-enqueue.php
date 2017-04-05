<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if (!function_exists('yolo_admin_enqueue_scripts')) {

	function yolo_admin_enqueue_scripts() {
		// Enqueue Script
		wp_enqueue_script( 'admin-app-js', get_template_directory_uri() . '/admin/assets/js/yolo_admin.js',array(), '1.0.0', true );

		wp_enqueue_script('datetimepicker', get_template_directory_uri() . '/admin/assets/js/datetimepicker/jquery.datetimepicker.js', array(), false, true);
		wp_enqueue_script( 'admin-yolo-color-picker-init.js', get_template_directory_uri() . '/admin/assets/js/yolo-color-picker-init.js',array(), '1.0.0', true );

		/* yolo_sections.js: install demo */
		wp_enqueue_script( 'admin-install-sections', get_template_directory_uri() . '/admin/assets/js/yolo_sections.js',array(), '1.0.0', true );

		/* datetimepicker */
		wp_enqueue_script('datetimepicker', get_template_directory_uri() . '/admin/assets/js/jquery.datetimepicker.js', array(), false, true);


		if ( true == yolo_check_rwm_status() ) { // Check metabox plugin load before load js for tab
			// global $meta_boxes;
			$meta_boxes = yolo_register_meta_boxes();
			$meta_box_id = '';
			foreach ($meta_boxes as $box) {
				if (!isset($box['tab'])) {
					continue;
				}
				if (!empty($meta_box_id)) {
					$meta_box_id .= ',';
				}
				$meta_box_id .= '#' . $box['id'];
			}

			wp_localize_script( 'admin-app-js' , 'meta_box_ids' , $meta_box_id);
		}

		// Enqueue CSS
		wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/admin/assets/css/admin.css', false, '1.0.0' );
		wp_enqueue_style( 'admin-install-sections', get_template_directory_uri() . '/admin/assets/css/yolo_sections.css', false, '1.0.0' );

		/* datetimepicker */
		wp_enqueue_style('datetimepicker', get_template_directory_uri() . '/admin/assets/css/jquery.datetimepicker.css', array());

		/* Font-Awesome */
		$url_font_awesome = get_template_directory_uri() . '/assets/plugins/fonts-awesome/css/font-awesome.min.css';
		wp_enqueue_style('font-awesome', $url_font_awesome, array());
	}
	add_action( 'admin_enqueue_scripts', 'yolo_admin_enqueue_scripts' );
}


/*================================================
GET CURRENT PAGE URL @TODO: need move to other file. It support for load sidebar script
================================================== */
if (!function_exists('yolo_current_page_url')) {
    function yolo_current_page_url() {
		$pageURL = 'http';
        if ( isset( $_SERVER["HTTPS"] ) ) {
            if ( $_SERVER["HTTPS"] == "on" ) {
                $pageURL .= "s";
            }
        }
        $pageURL .= "://";
        if ( $_SERVER["SERVER_PORT"] != "80" ) {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }

        return $pageURL;
    }
}

// Sidebar script to add custom sidebar
if( !function_exists( 'yolo_sidebar_script' ) ) {
	$current_page = yolo_current_page_url();
	$page_parts   = pathinfo($current_page);
	$basename     = $page_parts['basename'];
	if( $basename == 'widgets.php') {
		function yolo_sidebar_script() {
			wp_enqueue_script( 'yolo_sidebar', get_template_directory_uri() . '/admin/assets/js/yolo_sidebar.js',array(), '1.0.0', true );
		}

		add_action( 'admin_enqueue_scripts', 'yolo_sidebar_script' );
	}
	
}

