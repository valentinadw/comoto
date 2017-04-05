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
<div id="yolo-testimonial" class="yolo-testimonial slider-pro">
    <div class="sp-slides">
        <?php while( $testimonials->have_posts() ) : $testimonials->the_post(); 
            $testimonial_position = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_position' );
            $testimonial_special = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_special' );
        ?>
        <div class="sp-slide">
            <div class="testimonial-content"><?php echo ($excerpt_length != '') ? yolo_limit_words_pg(get_the_excerpt(), $excerpt_length) : get_the_excerpt(); ?> <hr> </div>
            <div class="testimonial-info">
                <?php the_post_thumbnail(); ?>
                <div class="testimonial-meta">
                    <h3><?php the_title(); ?></h3>
                    <?php if( !empty( $testimonial_position ) ) : ?>
                        <p><?php echo esc_html($testimonial_position['0']); ?></p>
                    <?php endif; ?>

                    <?php if( !empty( $testimonial_special ) ) : ?>
                    <p><?php echo esc_html($testimonial_special['0']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <div class="sp-thumbnails">
        <?php while( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
        <?php 
            $thumbnail_url  = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); 
            $background_id  = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_background' )['0'];
            $background_url = wp_get_attachment_url( $background_id );
            $testimonial_position = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_position' );
            $testimonial_special = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_special' );
        ?>
        <div class="sp-thumbnail-outter sp-thumbnail">
            <div class="sp-thumbnail-inner" <?php if(!empty($background_url)):?>style="background:url('<?php echo esc_url($background_url); ?>');"<?php endif;?>>
                <div class="testimonial-info">
                    <?php the_post_thumbnail(); ?>
                    <div class="testimonial-meta">
                        <h3><?php the_title(); ?></h3>
                        <?php if( !empty( $testimonial_position ) ) : ?>
                        <p><?php echo esc_html($testimonial_position['0']); ?></p>
                        <?php endif; ?>
                        <?php if( !empty( $testimonial_special ) ) : ?>
                        <p><?php echo esc_html($testimonial_special['0']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="testimonial-overlay">
                    <i class="fa fa-quote-left"></i>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <div class="testimonial-control">
        <div class="nav_prev"><i class="fa fa-chevron-left"></i></div>
        <div class="nav_next"><i class="fa fa-chevron-right"></i></div>
    </div>
</div>
<script>
    jQuery( document ).ready(function( $ ) {
        $( '#yolo-testimonial' ).sliderPro({
            width: 600,
            height: 510,
            orientation: 'horizontal',
            autoplay: <?php echo $autoplay; ?>,
            slideAnimationDuration: <?php echo $slide_duration; ?>,
            loop: true,
            arrows: false,
            buttons: false,
            thumbnailsPosition: 'right',
            thumbnailPointer: true,
            thumbnailWidth: 600,
            thumbnailHeight: 170,
            breakpoints: {
                800: {
                    thumbnailsPosition: 'bottom',
                    thumbnailWidth: 270,
                    thumbnailHeight: 100
                },
                500: {
                    thumbnailsPosition: 'bottom',
                    thumbnailWidth: 120,
                    thumbnailHeight: 50
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