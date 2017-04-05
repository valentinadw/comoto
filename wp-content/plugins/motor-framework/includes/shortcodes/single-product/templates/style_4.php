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

$image_src = wp_get_attachment_url($product_brand_logo);
?>

<?php while ($product->have_posts()) : $product->the_post(); ?>
    <div <?php post_class( $classes ); ?>>
	    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	    <div class="product-item-inner">
	        <div class="product-thumb">
	        	<?php if( $image_src != "" ) : ?>
				    <img src="<?php echo esc_url($image_src); ?>" class="product-brand-logo" alt="<?php echo $product_brand; ?>">
				<?php endif; ?>
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
	        	<?php if( $product_brand != "" ) : ?>
				    <h2 class="product-brand"><?php echo esc_html__($product_brand); ?></h2>
				<?php endif; ?>
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
	        </div>

	    </div>
	</div>
<?php endwhile; ?>