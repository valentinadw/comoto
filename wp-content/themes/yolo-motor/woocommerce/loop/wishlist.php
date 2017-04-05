<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 28/12/2015
 * Time: 10:30 AM
 */

$yolo_options = yolo_get_options();
$product_add_wishlist = $yolo_options['product_add_wishlist'];
if ($product_add_wishlist == 0) {
    return;
}

if (in_array('yith-woocommerce-wishlist/init.php', apply_filters('active_plugins', get_option('active_plugins'))) && (get_option( 'yith_wcwl_enabled' ) == 'yes')) {
	echo do_shortcode('[yith_wcwl_add_to_wishlist]');
}