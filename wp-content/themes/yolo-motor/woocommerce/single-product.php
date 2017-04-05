<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $yolo_woocommerce_loop;
$yolo_options = yolo_get_options();
$prefix = 'yolo_';


$layout_style = get_post_meta(get_the_ID(),$prefix.'page_layout',true);
if (($layout_style == '') || ($layout_style == '-1')) {
    $layout_style = isset($yolo_options['single_product_layout']) ? $yolo_options['single_product_layout'] : 'container';
}
$sidebar = get_post_meta(get_the_ID(),$prefix.'page_sidebar',true);
if (($sidebar == '') || ($sidebar == '-1')) {
    $sidebar = $yolo_options['single_product_sidebar'];
}
$left_sidebar = get_post_meta(get_the_ID(),$prefix.'page_left_sidebar',true);
if (($left_sidebar == '') || ($left_sidebar == '-1')) {
    $left_sidebar = $yolo_options['single_product_left_sidebar'];
}
$right_sidebar = get_post_meta(get_the_ID(),$prefix.'page_right_sidebar',true);
if (($right_sidebar == '') || ($right_sidebar == '-1')) {
    $right_sidebar = $yolo_options['single_product_right_sidebar'];
}
$sidebar_width = get_post_meta(get_the_ID(),$prefix.'sidebar_width',true);
if (($sidebar_width == '') || ($sidebar_width == '-1')) {
    $sidebar_width = $yolo_options['single_product_sidebar_width'];
}
// Calculate sidebar column & content column
$sidebar_col = 'col-md-3';
if ($sidebar_width == 'large') {
    $sidebar_col = 'col-md-4';
}

$content_col_number = 12;
if (is_active_sidebar($left_sidebar) && (($sidebar == 'both') || ($sidebar == 'left'))) {
    if ($sidebar_width == 'large') {
        $content_col_number -= 4;
    } else {
        $content_col_number -= 3;
    }
}
if (is_active_sidebar($right_sidebar) && (($sidebar == 'both') || ($sidebar == 'right'))) {
    if ($sidebar_width == 'large') {
        $content_col_number -= 4;
    } else {
        $content_col_number -= 3;
    }
}

$content_col = 'col-md-' . $content_col_number;
if (($content_col_number == 12) && ($layout_style == 'full')) {
    $content_col = '';
}
$main_class = array('single-product-wrap');
if ($content_col_number < 12) {
    $main_class[] = 'has-sidebar';
}
get_header( 'shop' ); ?>

<?php
/**
 * @hooked - yolo_page_heading - 5
 **/
do_action('yolo_before_page');

?>
<main class="<?php echo join(' ',$main_class) ?>">

    <div class="<?php echo esc_attr($layout_style) ?> clearfix">

        <?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
        <div class="row clearfix">
        <?php endif;?>

            <?php if (is_active_sidebar( $left_sidebar ) && (($sidebar == 'left') || ($sidebar == 'both'))) : ?>
                <div class="sidebar woocommerce-sidebar <?php echo esc_attr($sidebar_col) ?> hidden-sm hidden-xs">
                    <?php dynamic_sidebar( $left_sidebar ); ?>
                </div>
            <?php endif; ?>

            <div class="site-content-single-product <?php echo esc_attr($content_col) ?>">
                <div class="single-product-inner">
                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php wc_get_template_part( 'content', 'single-product' ); ?>

                    <?php endwhile; // end of the loop. ?>
                </div>
            </div>


            <?php if ( is_active_sidebar( $right_sidebar ) && (($sidebar == 'right') || ($sidebar == 'both')) ) : ?>
                <div class="sidebar woocommerce-sidebar <?php echo esc_attr($sidebar_col) ?> hidden-sm hidden-xs">
                    <?php dynamic_sidebar( $right_sidebar );?>
                </div>
            <?php endif; ?>

        <?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
        </div>
        <?php endif;?>

    </div>

    <?php
        /**
         * woocommerce_after_single_product_summary hook
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

        do_action( 'woocommerce_after_single_product_summary' );

        add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
    ?>

</main>
<?php get_footer( 'shop' ); ?>
