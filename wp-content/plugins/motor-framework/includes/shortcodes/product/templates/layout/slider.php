<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 29/1/2016
 * Time: 3:35 PM
 */
$slider_id = uniqid();
$yolo_options = yolo_get_options();
?>
<div class="<?php echo join(' ',$product_wrap_class); ?>">
    <div id="products-slider-<?php echo $slider_id; ?>" class="products-slider <?php echo join(' ',$product_class); ?> <?php if($products_per_slide=='6') echo 'slider_home4'; ?>">
        <?php //woocommerce_product_loop_start(); ?>
        <div class="woocommerce slider owl-carousel">
        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
            <?php include($product_path); // From products.php file ?>
        <?php endwhile; // end of the loop. ?>
        </div>
        <?php // woocommerce_product_loop_end(); ?>
    </div>
    <div id="products-slider-control-<?php echo $slider_id; ?>" class="products-slider-control">
	    <div class="products-nav nav-prev"><i class="fa fa-chevron-left"></i></div>
	    <div class="products-nav nav-next"><i class="fa fa-chevron-right"></i></div>
  	</div>
</div>
<script>
    jQuery(document).ready(function($){
        var owl = $('#products-slider-<?php echo $slider_id; ?> .woocommerce');
        owl.owlCarousel({
            items : <?php echo $products_per_slide; ?>,
            margin: 0,
            <?php if($yolo_options['enable_rtl_mode'] == 1) : ?> rtl : true, <?php endif;?>
            loop: true,
            center: false,
            mouseDrag: true,
            touchDrag: true,
            pullDrag: true,
            freeDrag: false,
            stagePadding: 0,
            merge: false,
            mergeFit: true,
            autoWidth: false,

            startPosition: 0,
            URLhashListener: false,
            nav: false,
            navText: ['next','prev'],
            rewind: true,
            navElement: 'div',
            slideBy: 1,
            dots: false,
            dotsEach: false,
            lazyLoad: false,
            lazyContent: false,

            autoplay: <?php echo $autoplay; ?>,
            autoplayTimeout: <?php echo $slide_duration; ?>,
            autoplayHoverPause: true,
            smartSpeed: 250,
            fluidSpeed: false,
            autoplaySpeed: false,
            navSpeed: false,
            dotsSpeed: false,
            dragEndSpeed: false,
            responsive: {
                0: {
                    items: 1
                },
                500: {
                    items: 2
                },
                991: {
                    items: <?php echo $products_per_slide; ?>
                },
                1200: {
                    items: <?php echo $products_per_slide; ?>
                },
                1300: {
                    items: <?php echo $products_per_slide; ?>
                }
            },
            responsiveRefreshRate: 200,
            responsiveBaseElement: window,
            video: false,
            videoHeight: false,
            videoWidth: false,
            animateOut: false,
            animateIn: false,
            fallbackEasing: 'swing',

            info: false,

            nestedItemSelector: false,
            itemElement: 'div',
            stageElement: 'div',

            navContainer: false,
            dotsContainer: false
        });
        // Custom Navigation Events
        $('#products-slider-control-<?php echo $slider_id; ?>').find(".nav-next").click(function() {
            owl.trigger('next.owl.carousel');
        });
        $('#products-slider-control-<?php echo $slider_id; ?>').find(".nav-prev").click(function() {
            owl.trigger('prev.owl.carousel');
        });
    });
</script>