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
$header_customize_text = '';

switch ($yolo_header_customize_current) {
	case 'nav':
		$enable_header_customize = get_post_meta(get_the_ID(),$prefix . 'enable_header_customize_nav',true);
		if ($enable_header_customize == '1') {
			$header_customize_text = get_post_meta(get_the_ID(),$prefix . 'header_customize_nav_text',true);
		}
		else {
			$header_customize_text = $yolo_options['header_customize_nav_text'];
		}

		break;
	case 'left':
		$enable_header_customize = get_post_meta(get_the_ID(),$prefix . 'enable_header_customize_left',true);
		if ($enable_header_customize == '1') {
			$header_customize_text = get_post_meta(get_the_ID(),$prefix . 'header_customize_left_text',true);
		}
		else {
			$header_customize_text = $yolo_options['header_customize_left_text'];
		}
		break;
	case 'right':
		$enable_header_customize = get_post_meta(get_the_ID(),$prefix . 'enable_header_customize_right',true);
		if ($enable_header_customize == '1') {
			$header_customize_text = get_post_meta(get_the_ID(),$prefix . 'header_customize_right_text',true);
		}
		else {
			$header_customize_text = $yolo_options['header_customize_right_text'];
		}
		break;
}
?>
<?php if (!empty($header_customize_text)) : ?>
	<div class="custom-text-wrapper header-customize-item">
		<?php echo wp_kses_post($header_customize_text); ?>
	</div>
<?php endif;?>