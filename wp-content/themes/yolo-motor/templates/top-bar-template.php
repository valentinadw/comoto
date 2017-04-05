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

$yolo_options = yolo_get_options();
$prefix = 'yolo_';

$is_show_top_bar = get_post_meta(get_the_ID(),$prefix . 'top_bar',true);

if (($is_show_top_bar == '') || ($is_show_top_bar == '-1')) {
	$is_show_top_bar = $yolo_options['top_bar'];
}
if (!$is_show_top_bar) {
	return; // NOT SHOW TOP BAR
}

$top_bar_layout_width = get_post_meta(get_the_ID(),$prefix . 'top_bar_layout_width',true);
if (($top_bar_layout_width == '') || ($top_bar_layout_width == '-1')) {
	$top_bar_layout_width = $yolo_options['top_bar_layout_width'];
}

$top_bar_layout = get_post_meta(get_the_ID(),$prefix . 'top_bar_layout',true);
if (($top_bar_layout == '') || ($top_bar_layout == '-1')) {
	$top_bar_layout = $yolo_options['top_bar_layout'];
}
// Left sidebar
$left_sidebar = get_post_meta(get_the_ID(),$prefix . 'top_left_sidebar',true);

if (($left_sidebar == '') || ($left_sidebar == '-1')) {
	$left_sidebar = $yolo_options['top_bar_left_sidebar'];
}
// Right sidebar
$right_sidebar = get_post_meta(get_the_ID(),$prefix . 'top_right_sidebar',true);

if (($right_sidebar == '') || ($right_sidebar == '-1')) {
	$right_sidebar = $yolo_options['top_bar_right_sidebar'];
}
// Center siderbar
$center_sidebar = get_post_meta(get_the_ID(),$prefix . 'top_center_sidebar',true);

if (($center_sidebar == '') || ($center_sidebar == '-1')) {
	$center_sidebar = $yolo_options['top_bar_center_sidebar'];
}

$top_bar_class = array('yolo-top-bar');
if ($yolo_options['mobile_header_top_bar'] == '0') {
	$top_bar_class[] = 'mobile-top-bar-hide';
}

$col_top_bar_left   = '';
$col_top_bar_right  = '';
$col_top_bar_center = '';

if (is_active_sidebar($left_sidebar) && is_active_sidebar($right_sidebar) ) {
	switch ($top_bar_layout) {
		case 'top-bar-1':
			$col_top_bar_left  = 'col-md-6';
			$col_top_bar_right = 'col-md-6';
			break;
		case 'top-bar-2':
			$col_top_bar_left  = 'col-md-8';
			$col_top_bar_right = 'col-md-4';
			break;
		case 'top-bar-3':
			$col_top_bar_left  = 'col-md-4';
			$col_top_bar_right = 'col-md-8';
			break;
	}

} else if (is_active_sidebar($left_sidebar) || is_active_sidebar($right_sidebar) ) {
	$col_top_bar_left  = 'col-md-12';
	$col_top_bar_right = 'col-md-12';
} else if (is_active_sidebar($center_sidebar)) {
	$col_top_bar_center = 'col-md-12';
}

if (empty($col_top_bar_left)) {
	// return; // DO NOT SHOW TOP BAR
}

?>
<div class="<?php echo join(' ', $top_bar_class); ?>">
	<div class="<?php echo $top_bar_layout_width; ?>">
		<div class="row">
			<?php if (is_active_sidebar($left_sidebar) && $top_bar_layout != 'top-bar-4') : ?>
				<div class="top-sidebar top-bar-left <?php echo esc_attr($col_top_bar_left) ?>">
					<?php dynamic_sidebar( $left_sidebar );?>
				</div>
			<?php endif; ?>
			<?php if (is_active_sidebar($right_sidebar) && $top_bar_layout != 'top-bar-4') : ?>
				<div class="top-sidebar top-bar-right <?php echo esc_attr($col_top_bar_right) ?>">
					<?php dynamic_sidebar( $right_sidebar );?>
				</div>
			<?php endif; ?>
			<?php if (is_active_sidebar($center_sidebar) && $top_bar_layout == 'top-bar-4') : ?>
				<div class="top-sidebar top-bar-center <?php echo esc_attr($col_top_bar_center) ?>">
					<?php dynamic_sidebar( $center_sidebar );?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
