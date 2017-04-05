<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 28/12/2015
 * Time: 4:35 PM
 */
if ( ! WC()->cart->coupons_enabled() && ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) ) {
	return;
}
?>
<h3 class="check-out-title"><?php esc_html_e( 'Returning customers?','yolo-motor' ) ?></h3>
