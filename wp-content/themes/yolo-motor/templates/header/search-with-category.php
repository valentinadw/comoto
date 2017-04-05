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

	$yolo_options = yolo_get_options();

	$prefix = 'yolo_';

	$categories       = get_categories(array( 'taxonomy' => 'product_cat' ));
	$category_content = yolo_categories_binder($categories, '0');
?>
<div class="search-with-category header-customize-item" data-hint-message="<?php esc_html_e( 'Introduzca un carácter para buscar', 'yolo-motor' ) ?>">
	<div class="search-with-category-inner search-box">
		<div class="form-search-left">
			<span data-id="-1"><?php esc_html_e( 'Categorias', 'yolo-motor' ); ?></span>
			<?php if (!empty($category_content)) : ?>
				<?php echo wp_kses_post($category_content) ?>
			<?php endif; ?>
		</div>
		<div class="form-search-right">
			<input type="text" name="s"/>
			<button type="button"><i class="wicon fa fa-search"></i></button>
		</div>
	</div>
</div>
