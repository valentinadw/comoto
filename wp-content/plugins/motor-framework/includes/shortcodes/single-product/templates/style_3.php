<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 30/1/2016
 * Time: 10:50 AM
 */

global $woocommerce_loop,$yolo_woocommerce_loop;
$yolo_options = yolo_get_options_pg();
// Extra post classes
$classes = array();
$classes[] = 'product-item-wrap';
$classes[] = $layout_type;
?>

<?php while ($product->have_posts()) : $product->the_post(); ?>
    <div <?php post_class( $classes ); ?>>
	    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	    <div class="product-item-inner">
	    	<div class="product-info"> 
	            <?php
	            /**
	             * woocommerce_after_shop_loop_item_title hook
	             *
	             * @hooked woocommerce_template_loop_rating - 5
	             * @hooked woocommerce_template_loop_price - 10
	             * @hooked woocommerce_template_loop_product_title - 15
	             */
	            // Remove action to change position
	            remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5);
	            remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10);
	            remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_product_title',15);

	            // Add action to get position needed
    			add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_product_title',5);
	            add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_single_excerpt', 10);
	            add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price', 15);

	            do_action( 'woocommerce_after_shop_loop_item_title' );

	            remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_single_excerpt', 10);
	            // Remove action don't change effect to other shortcode and resort
	            remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',15);
	            remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_product_title',5);

				add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5);
	            add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10);
	            add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_product_title',15);	            
	            ?>
	            <div class="product-actions">
	                <?php
	                /**
	                 * yolo_woocommerce_product_action hook
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
	    </div>
	</div>
<?php endwhile; ?>