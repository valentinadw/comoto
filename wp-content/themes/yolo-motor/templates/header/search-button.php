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

	global $yolo_header_customize_current;
	$yolo_options = yolo_get_options();

	$prefix = 'yolo_';

	$data_search_type = 'standard';
	if (isset($yolo_options['search_box_type']) && ($yolo_options['search_box_type'] == 'ajax')) {
		$data_search_type = 'ajax';
	}
	$search_box_type = 'standard';
	$search_box_submit = 'submit';
	if (isset($yolo_options['search_box_type'])) {
		$search_box_type = $yolo_options['search_box_type'];
	}
	if ($search_box_type == 'ajax') {
		$search_box_submit = 'button';
	}

	$header_customize_nav_search_button_style = 'default';
	switch ($yolo_header_customize_current) {
		case 'nav':
			$enable_header_customize_nav = get_post_meta(get_the_ID(),$prefix . 'enable_header_customize_nav',true);
			if ($enable_header_customize_nav == '1') {
				$header_customize_nav_search_button_style = get_post_meta(get_the_ID(),$prefix . 'header_customize_nav_search_button_style',true);
			}
			else {
				$header_customize_nav_search_button_style = isset($yolo_options['header_customize_nav_search_button_style']) && !empty($yolo_options['header_customize_nav_search_button_style'])
					? $yolo_options['header_customize_nav_search_button_style'] : 'default';
			}

			break;
		case 'left':
			$enable_header_customize_left = get_post_meta(get_the_ID(),$prefix . 'enable_header_customize_left',true);
			if ($enable_header_customize_left == '1') {
				$header_customize_nav_search_button_style = get_post_meta(get_the_ID(),$prefix . 'header_customize_left_search_button_style',true);
			}
			else {
				$header_customize_nav_search_button_style = isset($yolo_options['header_customize_left_search_button_style']) && !empty($yolo_options['header_customize_left_search_button_style'])
					? $yolo_options['header_customize_left_search_button_style'] : 'default';
			}
			break;
		case 'right':
			$enable_header_customize_right = get_post_meta(get_the_ID(),$prefix . 'enable_header_customize_right',true);
			if ($enable_header_customize_right == '1') {
				$header_customize_nav_search_button_style = get_post_meta(get_the_ID(),$prefix . 'header_customize_right_search_button_style',true);
			}
			else {
				$header_customize_nav_search_button_style = isset($yolo_options['header_customize_right_search_button_style']) && !empty($yolo_options['header_customize_right_search_button_style'])
					? $yolo_options['header_customize_right_search_button_style'] : 'default';
			}
			break;
	}

	$search_button_wrapper_class = array(
		'search-button-wrapper',
		'header-customize-item',
		'style-' . esc_attr($header_customize_nav_search_button_style)
	);
?>
<div class="<?php echo join(' ', $search_button_wrapper_class) ?>">
	<a class="icon-search-menu" href="#" data-search-type="<?php echo esc_attr($data_search_type) ?>"><i class="wicon fa fa-search"></i></a>
</div>