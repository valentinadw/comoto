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

$icon_shopping_cart_class = array('shopping-cart-wrapper', 'header-customize-item', 'no-price');
if ($yolo_options['mobile_header_shopping_cart'] == '0') {
	$icon_shopping_cart_class[] = 'mobile-hide-shopping-cart';
}

$header_customize_nav_shopping_cart_style = 'default';
switch ($yolo_header_customize_current) {
	case 'nav':
		$enable_header_customize_nav = get_post_meta(get_the_ID(),$prefix . 'enable_header_customize_nav',true);
		if ($enable_header_customize_nav == '1') {
			$header_customize_nav_shopping_cart_style = get_post_meta(get_the_ID(),$prefix . 'header_customize_nav_shopping_cart_style',true);
		}
		else {
			$header_customize_nav_shopping_cart_style = isset($yolo_options['header_customize_nav_shopping_cart_style']) && !empty($yolo_options['header_customize_nav_shopping_cart_style'])
				? $yolo_options['header_customize_nav_shopping_cart_style'] : 'default';
		}

		break;
	case 'left':
		$enable_header_customize_left = get_post_meta(get_the_ID(),$prefix . 'enable_header_customize_left',true);
		if ($enable_header_customize_left == '1') {
			$header_customize_nav_shopping_cart_style = get_post_meta(get_the_ID(),$prefix . 'header_customize_left_shopping_cart_style',true);
		}
		else {
			$header_customize_nav_shopping_cart_style = isset($yolo_options['header_customize_left_shopping_cart_style']) && !empty($yolo_options['header_customize_left_shopping_cart_style'])
				? $yolo_options['header_customize_left_shopping_cart_style'] : 'default';
		}
		break;
	case 'right':
		$enable_header_customize_right = get_post_meta(get_the_ID(),$prefix . 'enable_header_customize_right',true);
		if ($enable_header_customize_right == '1') {
			$header_customize_nav_shopping_cart_style = get_post_meta(get_the_ID(),$prefix . 'header_customize_right_shopping_cart_style',true);
		}
		else {
			$header_customize_nav_shopping_cart_style = isset($yolo_options['header_customize_right_shopping_cart_style']) && !empty($yolo_options['header_customize_right_shopping_cart_style'])
				? $yolo_options['header_customize_right_shopping_cart_style'] : 'default';
		}
		break;
}
$icon_shopping_cart_class[] = 'style-' . esc_attr($header_customize_nav_shopping_cart_style);
?>
<div class="<?php echo join(' ', $icon_shopping_cart_class); ?>">
	<div class="widget_shopping_cart_content">
		<?php get_template_part('woocommerce/cart/mini-cart'); ?>
	</div>
</div>