<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop,$yolo_woocommerce_loop;
$yolo_options = yolo_get_options();

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Extra post classes
$classes = array();
$classes[] = 'product-item-wrap';

$product_button_tooltip = $yolo_options['product_button_tooltip']? $yolo_options['product_button_tooltip']: true;
if ( $product_button_tooltip ) {
    $classes[] = 'button-has-tooltip';
} else {
    $classes[] = 'button-no-tooltip';
}

?>
<div <?php post_class( $classes ); ?>>
    <?php //do_action( 'woocommerce_before_shop_loop_item' ); ?>
    <div class="product-item-inner">
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
            do_action( 'woocommerce_before_shop_loop_item_title' );
            ?>
			
        </div>
        <div class="product-info">
            <?php
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             * @hooked woocommerce_template_loop_product_title - 15
             */
            do_action( 'woocommerce_after_shop_loop_item_title' );
            ?>
        </div>
        <div class="product-actions">
            <?php
            /**
             * yolo_woocommerce_product_actions hook
             *
             * @hooked yolo_woocomerce_template_loop_compare - 5
             * @hooked yolo_woocomerce_template_loop_wishlist - 10
             * @hooked woocommerce_template_loop_add_to_cart - 20
             * @hooked yolo_woocomerce_template_loop_quick_view - 25
             */
            do_action( 'yolo_woocommerce_product_actions' );
            ?>
        </div>
    </div>
</div>

