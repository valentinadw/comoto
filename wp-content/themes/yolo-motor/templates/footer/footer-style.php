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
	$yolo_options = yolo_get_options();
	$prefix = 'yolo_';

	$post_id   = get_the_ID();
	global $yolo_footer_id;

	if( $yolo_footer_id == '' && isset($yolo_options['footer'])) {
		$yolo_footer_id = $yolo_options['footer'];
	}
	if ( $yolo_footer_id && $post_id != $yolo_footer_id ) {
	   $shortcodes_custom_css = get_post_meta( $yolo_footer_id, '_wpb_shortcodes_custom_css', true );
	   if ( ! empty( $shortcodes_custom_css ) ) {
	       $shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
	       echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
	       echo $shortcodes_custom_css;
	       echo '</style>';
	   }
	}
?>