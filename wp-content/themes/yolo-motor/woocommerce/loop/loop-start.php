<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
global $woocommerce_loop, $yolo_woocommerce_loop;

$columns = $yolo_woocommerce_loop['columns'];
if (!isset($columns) || empty($columns)) {
    $columns = isset($woocommerce_loop['columns'])? $woocommerce_loop['columns'] : '4';
}

$archive_product_layout =  isset($woocommerce_loop['layout_type']) ? $woocommerce_loop['layout_type'] : '';
//$archive_shop_layout =
$archive_product_related =  isset($yolo_woocommerce_loop['layout']) ? $yolo_woocommerce_loop['layout'] : ''; // Use this for related product slider

$class                  = array();

if ( ($archive_product_layout == 'slider') || ( $archive_product_related == 'slider' ) ) { // Fix related products slider
    $class[]                = 'woocommerce slider clearfix';
} elseif ( $archive_product_layout == 'list' ) {
    $class[]                = 'woocommerce list product-listing clearfix';
} else {
    $class[]                = 'woocommerce product-listing clearfix';
}
$masonry                = isset($yolo_woocommerce_loop['masonry']) ? $yolo_woocommerce_loop['masonry'] : '';

if ( ($archive_product_layout != 'slider') && ($archive_product_related != 'slider') )  {
    $class[] = 'columns-' . $columns;
}

$class_names = join(' ', $class);

if ($archive_product_related == 'slider') {
    $data_plugin_options =  $columns;
}

?>
<div class="<?php echo esc_attr($class_names); ?>">
<?php if ($archive_product_related == 'slider') : ?>
<div class="owl-carousel" data-plugin-options='<?php echo wp_kses_post($data_plugin_options); ?>'>
<?php endif; ?>
