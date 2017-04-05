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

add_action('yolo_after_page_wrapper','yolo_add_canvas_menu_region');
function yolo_add_canvas_menu_region() {
	?>
	<nav class="yolo-canvas-menu-wrapper dark">
		<a href="#" class="yolo-canvas-menu-close"><i class="fa fa-close"></i></a>
		<div class="yolo-canvas-menu-inner sidebar">
			<?php if (is_active_sidebar('canvas-menu')) { dynamic_sidebar('canvas-menu'); } ?>
		</div>
	</nav>
	<?php
}
?>
<div class="header-customize-item canvas-menu-toggle-wrapper">
	<a class="canvas-menu-toggle" href="#"><i class="fa fa-bars"></i></a>
</div>