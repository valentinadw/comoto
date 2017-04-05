<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 28/12/2015
 * Time: 10:35 AM
 */
$yolo_options = yolo_get_options();
$product_quick_view = isset($yolo_options['product_quick_view'])? $yolo_options['product_quick_view']: true;
if ($product_quick_view == 0) {
    return;
}

?>
<a data-toggle="" data-placement="top" title="<?php esc_html_e( 'Quick view', 'yolo-motor' ) ?>" class="product-quick-view" data-product_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>"><i class="fa fa-search"></i><?php esc_html_e( 'Quick view', 'yolo-motor' ) ?></a>