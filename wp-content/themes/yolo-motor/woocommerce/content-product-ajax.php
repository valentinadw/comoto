<?php
/**
     * @hooked - yolo_shop_page_content - 5
     **/

$yolo_options = yolo_get_options();

$load_more = isset($_POST['pagination']) ? isset($_POST['pagination']) : '';
?>

<?php if ( $load_more != 'load_more' ): ?>
    <div class="sidebar woocommerce-sidebar yolo-ajax-filter clearfix">
        <?php dynamic_sidebar( 'woocommerce_filter' ); ?>
    </div>
    <div class="clearfix"></div>
    <?php wc_get_template_part( 'content', 'product_reset' );?>
<?php endif;?>

<?php if ( have_posts() ) : ?>

    <?php
    /**
     * woocommerce_before_shop_loop hook
     *
     * @hooked woocommerce_result_count - 20
     * @hooked woocommerce_catalog_ordering - 30
     */
    do_action( 'woocommerce_before_shop_loop' );
    ?>


    <?php if ( $load_more != 'load_more') { woocommerce_product_loop_start(); } ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <?php wc_get_template_part( 'content', 'product' ); ?>

    <?php endwhile; // end of the loop. ?>

    <?php if ( $load_more != 'load_more'){ woocommerce_product_loop_end(); } ?>

    <?php
    /**
     * woocommerce_after_shop_loop hook
     *
     * @hooked woocommerce_pagination - 10
     */
    do_action( 'woocommerce_after_shop_loop' );
    ?>
<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

    <?php wc_get_template( 'loop/no-products-found.php' ); ?>

<?php endif; ?>
<script type = "text/javascript">
    ;(function($){
        "use strict";
        function close_accordion_section() {
            $('.yolo-ajax-filter .widget-title').removeClass('active');
            $('.yolo-ajax-filter .widget ul,.yolo-ajax-filter .tagcloud').slideUp(300).removeClass('open');
        }
        function filter_toggles(){
            $('.yolo-ajax-filter .widget-title').click(function(e) {
                // Grab current anchor value
                e.preventDefault();
                if ($(window).width() < 992) {
                    $(this).parents('.yolo-ajax-filter').addClass('filter-toggle');
                    if($('.yolo-ajax-filter').hasClass('filter-toggle')){
                        var currentAttrValue = $(this).parent().attr('id');
                        if($(this).is('.active')) {
                            close_accordion_section();
                        }else {
                            close_accordion_section();

                            // Add active class to section title
                            $(this).addClass('active');
                            // Open up the hidden content panel
                            $('.yolo-ajax-filter ' + '#' + currentAttrValue + ' ul').slideDown(300).addClass('open');
                            $('.yolo-ajax-filter ' + '#' + currentAttrValue + ' .tagcloud').slideDown(300).addClass('open'); 
                        }
                    }
                }else{
                    $('.yolo-ajax-filter').removeClass('filter-toggle');
                    $('.yolo-ajax-filter .widget ul,.yolo-ajax-filter .tagcloud').css({"display": "block"});
                }
                $(window).on('resize', function() {
                    if ($(window).width() < 992) {
                        $('.yolo-ajax-filter').addClass('filter-toggle');
                        if($('.yolo-ajax-filter').hasClass('filter-toggle')){
                            var currentAttrValue = $(this).parent().attr('id');
                            if($(this).is('.active')) {
                                close_accordion_section();
                            }else {
                                close_accordion_section();

                                // Add active class to section title
                                $(this).addClass('active');
                                // Open up the hidden content panel
                                $('.yolo-ajax-filter ' + '#' + currentAttrValue + ' ul').slideDown(300).addClass('open');
                                $('.yolo-ajax-filter ' + '#' + currentAttrValue + ' .tagcloud').slideDown(300).addClass('open');
                            }
                        }
                    }else{
                        $('.yolo-ajax-filter').removeClass('filter-toggle');
                        $('.yolo-ajax-filter .widget ul,.yolo-ajax-filter .tagcloud').css({"display": "block"});
                    }
                });
            });
        }
        jQuery(document).ready(function($) {
            filter_toggles();
        });
    })(jQuery);
</script>