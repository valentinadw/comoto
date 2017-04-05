<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 27/1/2016
 * Time: 9:30 AM
 */

global $woocommerce_loop,$yolo_woocommerce_loop;
$yolo_options = yolo_get_options_pg();
// Extra post classes
$classes = array();
$classes[] = $layout_type;

?>
<?php if( $product_brand != "" ) : ?>
    <h2 class="product-brand"><?php echo esc_html__($product_brand); ?></h2>
<?php endif; ?>
<?php while ($product->have_posts()) : $product->the_post(); ?>
    <div <?php post_class(); ?>>
    	<?php wc_get_template_part( 'content', 'product' ); ?>
	</div>
<?php endwhile; ?>