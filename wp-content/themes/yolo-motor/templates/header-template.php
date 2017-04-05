<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    25/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

// global $yolo_header_layout;
$yolo_header_layout = yolo_get_header_layout();
$yolo_options = yolo_get_options();
if($yolo_header_layout == ''){
	$yolo_header_layout = 'header-2';
}
$prefix = 'yolo_';

$mobile_header_search_box = $yolo_options['mobile_header_search_box'];

// SHOW HEADER
$header_show_hide = '1';
if (!is_search()) {
	$header_show_hide = get_post_meta(get_the_ID(),$prefix . 'header_show_hide',true); // From metaboxes
}
if (($header_show_hide == '')) {
	$header_show_hide = '1';
}
?>
<?php if (($header_show_hide == '1')): ?>
	<?php yolo_get_template('header/header-mobile-template' ); ?>
	<?php yolo_get_template('header/' . $yolo_header_layout ); ?> <!-- From theme/header.php -->
	<?php if ((isset($header_search_box) && $header_search_box == '1') || ($mobile_header_search_box == '1')) : ?>
		<?php yolo_get_template('header/search','popup'); ?>
	<?php endif; ?>
<?php endif; ?>