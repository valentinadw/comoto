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
$yolo_header_layout = yolo_get_header_layout();
$yolo_options = yolo_get_options();
$prefix = 'yolo_';
$yolo_header_customize_current = 'left';

$header_customize_class = array('header-customize header-customize-left');

$header_customize = array();
$enable_header_customize = get_post_meta(get_the_ID(),$prefix . 'enable_header_customize_left',true);
if ($enable_header_customize == '1') {
	$page_header_customize = get_post_meta(get_the_ID(),$prefix . 'header_customize_left',true);
	if (isset($page_header_customize['enable']) && !empty($page_header_customize['enable'])) {
		$header_customize = explode('||', $page_header_customize['enable']);
	}

	$header_customize_left_separate = get_post_meta(get_the_ID(),$prefix . 'header_customize_left_separate',true);
	if ($header_customize_left_separate == '1') {
		$header_customize_class[] = 'header-customize-separate';
	}
}
else {
	if (isset($yolo_options['header_customize_left']) && isset($yolo_options['header_customize_left']['enabled']) && is_array($yolo_options['header_customize_left']['enabled'])) {
		foreach ($yolo_options['header_customize_left']['enabled'] as $key => $value) {
			$header_customize[] = $key;
		}
	}
	if (isset($yolo_options['header_customize_nav_separate']) && ($yolo_options['header_customize_left_separate'] == '1')){
		$header_customize_class[] = 'header-customize-separate';
	}
}

?>
<?php if (count($header_customize) > 0): ?>
	<div class="<?php echo join(' ', $header_customize_class) ?>">
		<?php foreach ($header_customize as $key){
			switch ($key) {
				case 'search-button':
					yolo_get_template('header/search-button');
					break;
				case 'search-box':
					yolo_get_template('header/search-box');
					break;
				case 'search-with-category':
					yolo_get_template('header/search-with-category');
					break;
				case 'shopping-cart':
					if (class_exists( 'WooCommerce' )) {
						yolo_get_template('header/mini-cart');
					}
					break;
				case 'shopping-cart-price':
					if (class_exists( 'WooCommerce' )) {
						yolo_get_template('header/mini-cart-price');
					}
					break;
				case 'wishlist':
					if (class_exists( 'WooCommerce' ) && class_exists('YITH_WCWL')) {
						yolo_get_template('header/wishlist');
					}
					break;
				case 'social-profile':
					yolo_get_template('header/social-profile');
					break;
				case 'custom-text':
					yolo_get_template('header/custom-text');
					break;
				case 'canvas-menu':
					yolo_get_template('header/canvas-menu');
					break;
			}
		} ?>
	</div>
<?php endif;?>