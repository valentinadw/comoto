<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if( !function_exists('yolo_include_vc_extension') ) {
	function yolo_include_vc_extension() {
		require_once get_template_directory() . '/framework/vc_extension/functions.php';
		require_once get_template_directory() . '/framework/vc_extension/update_params.php';
	}

	yolo_include_vc_extension();
}