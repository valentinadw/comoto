<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

global $yolo_woocommerce_loop;
$yolo_options = yolo_get_options();
$related_product_display_columns = isset($yolo_options['related_product_display_columns']) ? $yolo_options['related_product_display_columns'] : '4';

$yolo_woocommerce_loop['rating'] = 0;
$yolo_woocommerce_loop['columns'] = $related_product_display_columns;
$yolo_woocommerce_loop['layout'] = 'slider';
if ( $products->have_posts() ) : ?>

	<div class="related products">
		<div class="container">
			<h4 class="widget-title"><span><?php esc_html_e( 'Related Products', 'yolo-motor' ); ?></span></h4>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

	                <?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
		</div>

	</div>

<?php endif;

wp_reset_postdata();
