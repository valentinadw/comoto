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
?>
<div id="yolo-testimonial" class="yolo-testimonial slider-pro-2">
    <div class="sp-slides">
        <?php while( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
        <?php 
            $thumbnail_url  = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); 
            $background_id  = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_background' )['0'];
            $background_url = wp_get_attachment_url( $background_id );
            $testimonial_position = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_position' );
            $testimonial_special = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_special' );
        ?>
        <div class="sp-slide">
            <div class="testimonial-top" style="background:url('<?php echo $background_url; ?>');">
                <!-- <i class="fa fa-quote-left"></i> -->
                <div class="testimonial-top-overlay">
                    <div class="testimonial-top-content row">
                        <div class="testimonial-image col-md-6 col-sm-12 col-xs-12">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <div class="testimonial-content col-md-6 col-sm-12 col-xs-12">
                            <div class="testimonial-content"><?php echo ($excerpt_length != '') ? yolo_limit_words_pg(get_the_excerpt(), $excerpt_length) : get_the_excerpt(); ?></div>
                            <div class="testimonial-meta">
                                <h3><?php the_title(); ?></h3>
                                <?php if( !empty( $testimonial_position ) ) : ?>
                                <span><?php echo esc_html($testimonial_position['0']); ?></span>
                                <?php endif; ?>
                                <?php if( !empty( $testimonial_special ) ) : ?>
                                <span><?php echo esc_html($testimonial_special['0']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <div class="rowssss">
        <div class="col-md-6 col-sm-12 col-xs-12"></div>
        <div class="sp-thumbnails">
            <?php while( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
            <?php 
                $thumbnail_url  = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); 
                $background_id  = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_background' )['0'];
                $background_url = wp_get_attachment_url( $background_id );
            ?>
            <div class="sp-thumbnail" style="background:url('<?php echo $background_url; ?>');">
                <div class="testimonial-thumbnail">
                    <?php the_post_thumbnail(); ?>
                    <div class="testimonial-overlay">
                        <i class="fa fa-quote-left"></i>
                    </div>
                </div> 
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <div class="testimonial-control">
        <div class="testimonial-nav nav_prev"><i class="fa fa-chevron-left"></i></div>
        <div class="testimonial-nav nav_next"><i class="fa fa-chevron-right"></i></div>
    </div>
</div>
<script>
    jQuery( document ).ready(function( $ ) {
        $( '#yolo-testimonial' ).sliderPro({
            width: '100%',
            height: 500,
            // orientation: 'horizontal',
            autoplay: <?php echo $autoplay; ?>,
            slideAnimationDuration: <?php echo $slide_duration; ?>,
            fade: true,
            fadeDuration: 500,
            loop: true,
            arrows: false,
            buttons: false,
            // thumbnailsPosition: 'right',
            thumbnailPointer: true,
            thumbnailWidth: 75,
            thumbnailHeight: 100,
            breakpoints: {
                800: {
                    thumbnailsPosition: 'bottom',
                    thumbnailWidth: 75,
                    thumbnailHeight: 75
                },
                500: {
                    thumbnailsPosition: 'bottom',
                    thumbnailWidth: 75,
                    thumbnailHeight: 75
                }
            }
        });
        // Custom Navigation Events
        $('.testimonial-control').find(".nav_next").click(function(){
            $( '#yolo-testimonial' ).sliderPro( 'nextSlide' );
        });
         $('.testimonial-control').find(".nav_prev").click(function(){
            $( '#yolo-testimonial' ).sliderPro( 'previousSlide' );
        });
    });
</script>