<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 29/1/2016
 * Time: 3:35 PM
 */

global $woocommerce_loop,$yolo_woocommerce_loop;
$yolo_options = yolo_get_options_pg();
$classes                = array();
$classes[]              = 'product-item-wrap';
$action_disable_array   = explode(',', $action_disable);
$product_button_tooltip = $yolo_options['product_button_tooltip'];

if ( ($product_button_tooltip == "1" && $action_tooltip == 'true') || ($action_tooltip == 'true') ) {
    $classes[] = 'button-has-tooltip';
} else {
    $classes[] = 'button-no-tooltip';
}
$classes[] = 'product-' . $product_style;

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
            <div class="product-actions">
                <?php
                /**
                 * yolo_woocommerce_product_action hook
                 *
                 * @hooked yolo_woocomerce_template_loop_wishlist - 5
                 * @hooked yolo_woocomerce_template_loop_compare - 10
                 * @hooked woocommerce_template_loop_add_to_cart - 20
                 * @hooked yolo_woocomerce_template_loop_quick_view - 25
                 */
                // Disable action button by remove action
                foreach($action_disable_array as $key=>$value ) {
                    switch($value) {
                        case 'wishlist': 
                            remove_action( 'yolo_woocommerce_product_actions', 'yolo_woocomerce_template_loop_wishlist', 5 );
                            break;
                        case 'compare': 
                            remove_action( 'yolo_woocommerce_product_actions', 'yolo_woocomerce_template_loop_compare', 10 );
                            break;
                        case 'addtocart': 
                            remove_action( 'yolo_woocommerce_product_actions', 'woocommerce_template_loop_add_to_cart', 20 );
                            break;
                        case 'quickview': 
                            remove_action( 'yolo_woocommerce_product_actions', 'yolo_woocomerce_template_loop_quick_view', 25 );
                            break;
                        default:
                            break;
                    }
                }
                do_action( 'yolo_woocommerce_product_actions' );
                // Return to default action
                add_action( 'yolo_woocommerce_product_actions', 'yolo_woocomerce_template_loop_wishlist', 5 );
                add_action( 'yolo_woocommerce_product_actions', 'yolo_woocomerce_template_loop_compare', 10 );
                add_action( 'yolo_woocommerce_product_actions', 'woocommerce_template_loop_add_to_cart', 20 );
                add_action( 'yolo_woocommerce_product_actions', 'yolo_woocomerce_template_loop_quick_view', 25 );

                ?>
            </div>
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

    </div>
</div>