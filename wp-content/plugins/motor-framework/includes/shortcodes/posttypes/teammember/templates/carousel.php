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
$team_id = uniqid();
$yolo_options = yolo_get_options();
?>
<div class="yolo-team-fix">
    <div class="yolo-team-wrap">
    </div>
</div>

<div id="yolo-teammember" class="yolo-teammember teammember-carousel">
    <ul id="teammember-list-<?php echo $team_id; ?>" class="teammembers teammember-list owl-carousel owl-theme">
        <?php while( $teammembers->have_posts() ) : $teammembers->the_post(); 
            $teammember_url = yolo_get_post_meta( get_the_ID(), 'yolo_teammember_url' );
            $teammember_position = yolo_get_post_meta( get_the_ID(), 'yolo_teammember_position');
        ?>
            <li class="teammember-item">
                <div class="teammember-background">
                    <?php the_post_thumbnail('full')?>
                    
                </div>
                <div class="teammember-content" data-option-id="<?php echo get_the_ID(); ?> ">
                    <div class="teammember-image">
                        <?php the_post_thumbnail('full')?>
                    </div>
                    <div class="teammember-meta">
                        <h3 class="teammember-title"><?php the_title(); ?></h3>
                        <?php if( !empty($teammember_position) ) : ?>
                        <p class="teammember-position"><?php echo esc_html($teammember_position['0']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
    <div id="teammember-control-<?php echo $team_id; ?>" class="teammember-control">
        <div class="teammember-nav nav_prev"><i class="fa fa-chevron-left"></i></div>
        <div class="teammember-nav nav_next"><i class="fa fa-chevron-right"></i></div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        var owl = $('#teammember-list-<?php echo $team_id; ?>');
        owl.owlCarousel({
            items : <?php echo $member_per_slide; ?>,
            margin: 30,
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
                    items: <?php echo $member_per_slide; ?>
                },
                1200: {
                    items: <?php echo $member_per_slide; ?>
                },
                1300: {
                    items: <?php echo $member_per_slide; ?>
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
        $('#teammember-control-<?php echo $team_id; ?>').find(".nav_next").click(function() {
            owl.trigger('next.owl.carousel');
        });
        $('#teammember-control-<?php echo $team_id; ?>').find(".nav_prev").click(function() {
            owl.trigger('prev.owl.carousel');
        });
        /*Popup callback*/
        jQuery('.teammember-content').click(function(){
            var $id = $(this).attr('data-option-id');
            jQuery('.yolo-team-fix').addClass('db');

            jQuery.ajax({
               url: yolo_framework_ajax_url,
               type: 'POST',
               data: ({
                    action: 'yolo_team_detail',
                    id:     $id
                }),
               success: function(data){
                    console.log(data);
                    if(data){
                        jQuery('.yolo-team-fix').addClass('bk-noimage');
                        jQuery('.yolo-team-wrap').html(data);
                        jQuery('.yolo-team-wrap').animate({
                            'top': '50%',
                            opacity: 1
                        },350,function(){

                        });

                        jQuery('.team-remove').click(function(){

                            jQuery('.yolo-team-wrap').animate({
                                'top': '80%',
                                opacity: 0
                            },350,function(){
                                jQuery('.yolo-team-fix').removeClass('bk-noimage');
                                jQuery('.yolo-team-fix').removeClass('db');
                            });

                        });
                    }
                }
            });

        });
    });
</script>