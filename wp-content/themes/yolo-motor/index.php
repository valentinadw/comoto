<?php
/**
 * The main template file
 *
 * @package    YoloTheme
 * @version    1.0.0
 * @created    23/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if (isset($_REQUEST['yolo-custom-page']) && !empty($_REQUEST['yolo-custom-page'])) {
	global $yolo_is_do_action_custom_page;
	if (!isset($yolo_is_do_action_custom_page) || $yolo_is_do_action_custom_page !== '1') {
		$yolo_is_do_action_custom_page = '1';
		do_action('yolo-custom-page/'.$_REQUEST['yolo-custom-page']);
	}
} else {
	get_header();
		yolo_get_template( 'archive' ); // More details can see from here: http://wphierarchy.com/
	get_footer();
	
	// global $reduxConfig; // Show all theme options
}
?>
