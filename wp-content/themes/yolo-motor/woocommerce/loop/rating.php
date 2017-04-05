<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$yolo_options = yolo_get_options();

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
	return;

$product_show_rating = isset($yolo_options['product_show_rating'])? $yolo_options['product_show_rating']: true;
if ($product_show_rating == 0) {
    return;
}
?>

<?php if ( $rating_html = $product->get_rating_html() ) : ?>
	<?php echo $rating_html; ?>
<?php endif; ?>
