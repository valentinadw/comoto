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

?>
<div class="my-wishlist header-customize-item">
	<div class="widget_shopping_wishlist_content">
		<?php if( class_exists('YITH_WCWL') ): ?>
		<div class="my-wishlist-wrapper"><?php echo yolo_woocommerce_wishlist(); ?></div>
		<?php endif; ?>
	</div>
</div>