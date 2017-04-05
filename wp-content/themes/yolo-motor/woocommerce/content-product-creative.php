<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.4.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $yolo_woocommerce_loop;
$yolo_options = yolo_get_options();

// Ensure visibility
if (!$product || !$product->is_visible())
    return;


// Extra post classes
$classes        = array();
$classes[]      = 'product-item-wrap';
$product_rating = $yolo_woocommerce_loop['rating'];
if ($product_rating == '') {
    $product_rating = $yolo_options['product_show_rating'];
}

if ($product_rating == 0) {
    $classes[] = 'rating-visible';
}


$product_quick_view = $yolo_options['product_quick_view'];
if ($product_quick_view == 0) {
    $classes[] = 'quick-view-visible';
}

$matrix = array(
    '2' => array(
        array(2, 1, 1.5),
        array(1, 1, 1)
    ),
    '3' => array(
        array(2, 1, 1),
        array(2, 1, 1)
    )
);
global $yolo_woocommerce_loop;
$index     = $yolo_woocommerce_loop['post_index'];
$columns   = $yolo_woocommerce_loop['columns'];
$index_row = floor(($index - 1) / 3) % 2;
$index_col = ($index - 1) % 3;

if($columns==2){
    if($index_row==1 && $index_col==2) {
        $yolo_woocommerce_loop['post_index'] = 1;
        $index_row                           = 0;
        $index_col                           = 0;
    }
}

$item_style = '';
$page_class = 'page-' . (floor($index / 6) + ($index % 6 > 0 ? 1 : 0));
if ($columns == 2) {
    $pages = 'page-' . (floor($index / 5) + ($index % 5 > 0 ? 1 : 0));
}

$item_style   = $matrix[$columns][$index_row][$index_col] == 2 ? 'double-size' : '';
$layout_style =  $matrix[$columns][$index_row][$index_col] == 1.5 ? $layout_style = 'layout-style-2col' : '';
if ($columns == 2) {
    $classes[] = $matrix[$columns][$index_row][$index_col] == 2 ? 'col-md-8 col-sm-6 col-xs-6' : 'col-md-4 col-sm-6 col-xs-6';
} else {
    $classes[] = $matrix[$columns][$index_row][$index_col] == 2 ? 'col-md-6 col-sm-6 col-xs-6' : 'col-md-3 col-sm-6 col-xs-6';
}
$classes[] = $layout_style;
$classes[] = $page_class;

?>
<div <?php post_class($classes); ?> >
    <?php do_action('woocommerce_before_shop_loop_item'); ?>
    <div class="product-item-inner <?php echo esc_attr($item_style) ?>">
        <div class="product-thumb">
            <?php
            /**
             * woocommerce_before_shop_loop_item_title hook
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             * @hooked yolo_woocomerce_template_loop_link - 20
             *
             */
            remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_creative_thumbnail', 10);
            do_action('woocommerce_before_shop_loop_item_title', $yolo_woocommerce_loop['post_index']);
            ?>
            <div class="product-actions">
                <?php
                /**
                 * yolo_woocommerce_product_action hook
                 *
                 * @hooked yolo_woocomerce_template_loop_compare - 5
                 * @hooked yolo_woocomerce_template_loop_wishlist - 10
                 * @hooked yolo_woocomerce_template_loop_quick_view - 15
                 * @hooked woocommerce_template_loop_add_to_cart - 20
                 */
                do_action('yolo_woocommerce_product_actions');
                ?>
            </div>
        </div>
        <div class="product-info">
            <?php
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_product_title - 6
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action('woocommerce_after_shop_loop_item_title');
            ?>
        </div>
    </div>
</div>

