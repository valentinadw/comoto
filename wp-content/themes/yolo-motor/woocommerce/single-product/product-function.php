<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 28/12/2015
 * Time: 11:25 AM
 */
?>

<?php if  ((in_array('yith-woocommerce-compare/init.php', apply_filters('active_plugins', get_option('active_plugins')))) || (in_array('yith-woocommerce-wishlist/init.php', apply_filters('active_plugins', get_option('active_plugins'))) && (get_option( 'yith_wcwl_enabled' ) == 'yes'))) :  ?>
	<div class="single-product-function">
		<?php if (in_array('yith-woocommerce-wishlist/init.php', apply_filters('active_plugins', get_option('active_plugins'))) && (get_option( 'yith_wcwl_enabled' ) == 'yes')) {
			echo do_shortcode('[yith_wcwl_add_to_wishlist]');
		} ?>

		<?php if (in_array('yith-woocommerce-compare/init.php', apply_filters('active_plugins', get_option('active_plugins')))): ?>
			<a title="<?php esc_html_e('Compare', 'yolo-motor') ?>" href="<?php the_permalink(); ?>?action=yith-woocompare-add-product&amp;id=<?php the_ID(); ?>"
			   class="compare" data-product_id="<?php the_ID(); ?>"><i class="fa fa-signal"></i> <?php esc_html_e('Compare', 'yolo-motor') ?></a>
		<?php endif; ?>
	</div>
<?php endif; ?>



