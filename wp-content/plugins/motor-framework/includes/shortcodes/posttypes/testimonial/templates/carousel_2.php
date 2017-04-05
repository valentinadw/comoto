<?php
/**
 *  
 * @package    YoloTheme/Yolo Motor
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

$testimonial_id = uniqid();
?>
<div id="yolo-testimonial" class="yolo-testimonial testimonial-carousel-2">
    <ul id="testimonial-list-<?php echo $testimonial_id; ?>" class="testimonials testimonial-list owl-carousel owl-theme">
        <?php while( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
        <li class="testimonial-item">
            <h3 class="testimonial-title"><?php the_title(); ?></h3>
            <h4 class="testimonial-position"><?php echo yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_position' )['0']; ?></h4>
            <p class="testimonial-special"><?php echo yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_special' )['0']; ?></p>
            <p class="testimonial-content"><?php echo ($excerpt_length != '') ? yolo_limit_words_pg(get_the_excerpt(), $excerpt_length) : get_the_excerpt(); ?> </p>
        </li>
        <?php endwhile; ?>
    </ul>
    <div id="testimonial-control-<?php echo $testimonial_id; ?>" class="testimonial-control">
        <div class="testimonial-nav nav_prev"><i class="fa fa-chevron-left"></i></div>
        <div class="testimonial-nav nav_next"><i class="fa fa-chevron-right"></i></div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        var owl = $('#testimonial-list-<?php echo $testimonial_id; ?>');
        owl.owlCarousel({
            items : 1,
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
            dots: true,
            dotsEach: false,
            lazyLoad: false,
            lazyContent: false,

            autoplay: <?php echo $autoplay; ?>,
            autoplayTimeout: <?php echo $slide_duration; ?>,
            autoplayHoverPause: true,
            
            smartSpeed: 1000,
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
                    items: 1
                },
                991: {
                    items: 1
                },
                1200: {
                    items: 1
                },
                1300: {
                    items: 1
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
        $('#testimonial-control-<?php echo $testimonial_id; ?>').find(".nav_next").click(function(){
            owl.trigger('next.owl.carousel');
        });
        $('#testimonial-control-<?php echo $testimonial_id; ?>').find(".nav_prev").click(function(){
            owl.trigger('prev.owl.carousel');
        });
    });
</script>