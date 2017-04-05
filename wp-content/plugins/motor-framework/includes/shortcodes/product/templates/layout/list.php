<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 20/2/2016
 * Time: 3:25 PM
 */

?>
<div class="<?php echo join(' ',$product_wrap_class); ?>">
    <div id="yolo-products-list" class="products-list <?php echo join(' ',$product_class); ?>">
        <?php woocommerce_product_loop_start(); ?>
        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
            <?php include($product_path); // From product-list.php file ?>
        <?php endwhile; // end of the loop. ?>
        <?php woocommerce_product_loop_end(); ?>
    </div>
</div>
<?php if ( $products->max_num_pages > 1 ) : ?>
<div class="<?php echo join(' ', $product_paging_class); ?>">
    <?php
    switch($paging_style) {
        case 'load-more':
            yolo_paging_load_more_product($products);
            break;
        case 'infinity-scroll':
            yolo_paging_infinitescroll_product($products);
            break;
        default:
            echo yolo_paging_nav_product($products);
            break;
    }
    ?>
</div>
<?php endif; ?>