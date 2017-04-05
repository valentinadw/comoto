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

// Include Redux theme options
if( !function_exists( 'yolo_include_theme_options' ) ) {
	function yolo_include_theme_options() {
		// Use this to override Redux Framework
		if (file_exists( get_template_directory().'/framework/core/yolo_reduxframework.php')) {
		    require_once get_template_directory() . '/framework/core/yolo_reduxframework.php';
		}

		// Load the theme/plugin options
		if ( file_exists( get_template_directory().'/framework/includes/options-config.php' ) ) {
		    require_once get_template_directory().'/framework/includes/options-config.php';
		}
	}
	
	yolo_include_theme_options();
}

// Include footer id
if( !function_exists('yolo_include_footer_id') ) {
		function yolo_include_footer_id() {
			global $yolo_footer_id;

			$prefix    = 'yolo_';
			$yolo_footer_id = get_post_meta(get_the_ID(),$prefix . 'footer',true);
		}
}

if( !function_exists( 'yolo_include_library' ) ) {
	function yolo_include_library() {
		require_once get_template_directory() . '/framework/includes/yolo-dash/register-require-plugin.php'; // Required plugin for theme
		require_once get_template_directory() . '/framework/includes/theme-setup.php'; // add_theme_support(),...
		require_once get_template_directory() . '/framework/includes/sidebar.php';  // Add sidebar for theme
		require_once get_template_directory() . '/framework/includes/admin-enqueue.php';
		require_once get_template_directory() . '/framework/includes/theme-functions.php'; // Include functions as add custom sidebar, generate css from options,..
		require_once get_template_directory() . '/framework/includes/theme-action.php'; // @TODO: use for ajax search, demo panel
		require_once get_template_directory() . '/framework/includes/theme-filter.php';
		require_once get_template_directory() . '/framework/includes/frontend-enqueue.php';
		require_once get_template_directory() . '/framework/includes/tax-meta.php'; // Add metabox for taxonomy, custom posttype,... Source: https://github.com/bainternet/My-Meta-Box/

		// Load widget custom class (add field css class to widget)
		if (file_exists( get_template_directory() . '/framework/includes/widget-custom-class.php')) {
			require_once get_template_directory() . '/framework/includes/widget-custom-class.php';
		}
	}

	yolo_include_library();
}