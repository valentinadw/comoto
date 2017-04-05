<?php
/**
 * Product Loop End
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
global $yolo_woocommerce_loop;
$archive_product_related =  isset($yolo_woocommerce_loop['layout']) ? $yolo_woocommerce_loop['layout'] : '';
?>
<?php if ($archive_product_related == 'slider') : ?>
	</div>
<?php endif; ?>
</div>
<?php yolo_woocommerce_reset_loop(); ?>