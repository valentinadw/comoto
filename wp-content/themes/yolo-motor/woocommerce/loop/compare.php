<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 28/12/2015
 * Time: 10:25 AM
 */

global $action_tooltip;
$yolo_options = yolo_get_options();
$product_add_to_compare = $yolo_options['product_add_to_compare'];
if ($product_add_to_compare == 0) {
    return;
}

?>
<?php if ( in_array('yith-woocommerce-compare/init.php', apply_filters('active_plugins', get_option('active_plugins'))) ) : ?>
	<a data-toggle="" data-placement="top" title="<?php esc_html_e( 'Compare', 'yolo-motor' ) ?>" href="<?php the_permalink(); ?>?action=yith-woocompare-add-product&amp;id=<?php the_ID(); ?>"
	   class="compare add_to_compare" data-product_id="<?php the_ID(); ?>"><i class="fa fa-signal"></i><?php esc_html_e( 'Compare', 'yolo-motor' ); ?> </a>
<?php endif; ?>
