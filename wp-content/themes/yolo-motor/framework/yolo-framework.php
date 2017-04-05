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

// Check Visual Composer is active before load vc
function yolo_check_vc_status() {
    include_once ABSPATH.'wp-admin/includes/plugin.php';
    if( is_plugin_active('js_composer/js_composer.php') ) {
        return true;
    } else {
        return false;
    }
}

// Check RW Metabox is active before load RWM
function yolo_check_rwm_status() {
    include_once ABSPATH.'wp-admin/includes/plugin.php';
    if( is_plugin_active('meta-box/meta-box.php') ) {
        return true;
    } else {
        return false;
    }
}

if( !function_exists( 'yolo_framework' ) ) {
	function yolo_framework() {
		// Load include libraries
		if (file_exists( get_template_directory() . '/framework/includes/_init.php')) {
		    require_once get_template_directory() . '/framework/includes/_init.php';
		}

		// Load core functions
		if (file_exists( get_template_directory() . '/framework/core/_init.php')) {
		    require_once get_template_directory() . '/framework/core/_init.php';
		}
		
		// Load metaboxes class
		if ( true == yolo_check_rwm_status() ) {
		    require_once WP_PLUGIN_DIR.'/meta-box/meta-box.php';
		    require_once get_template_directory() . '/framework/ct_plugins/meta-box/yolo-meta-box-conditional-logic.php';
		    require_once get_template_directory() . '/framework/includes/meta-boxes.php'; // Add metaboxes for post, page,... Source: https://metabox.io/
		}

		// Load VC extension
		if( true == yolo_check_vc_status() ) {
			require_once get_template_directory() . '/framework/vc_extension/_init.php';
		}
	}

	yolo_framework();
}