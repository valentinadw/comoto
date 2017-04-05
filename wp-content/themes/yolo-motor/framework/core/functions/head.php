<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    21/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
/*================================================
HEAD META
================================================== */
if (!function_exists('yolo_head_meta')) {
	function yolo_head_meta() {
		yolo_get_template('head-meta');
	}
	add_action('wp_head','yolo_head_meta',0);
}

/*================================================
SOCIAL META @TODO: do not use now - use for SEO
================================================== */
if (!function_exists('yolo_add_opengraph_doctype')) {
	function yolo_add_opengraph_doctype($output) {
		$yolo_options = yolo_get_options();
		
		$enable_social_meta = false;
		if (isset($yolo_options['enable_social_meta'])) {
			$enable_social_meta = $yolo_options['enable_social_meta'];
		}
		if (!$enable_social_meta) {
			return$output;
		}
		return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';

	}
	add_filter( 'language_attributes', 'yolo_add_opengraph_doctype' );
}

if (!function_exists('yolo_social_meta')) {
	function yolo_social_meta() {
		yolo_get_template('social-meta');
	}
	add_action( 'wp_head', 'yolo_social_meta', 5 );
}

