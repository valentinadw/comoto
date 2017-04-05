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
$clients = (array) vc_param_group_parse_atts( $clients );
$clients_id = uniqid();
$yolo_options = yolo_get_options();

?>
<div class="<?php echo $layout_type; ?> clients-shortcode-wrap">
    <div id="clients-list-<?php echo $clients_id; ?>" class="clients-list owl-carousel owl-theme">
        <?php foreach( $clients as $client ) : 
            $image_src = wp_get_attachment_url($client['logo']);
        ?>
    	<div class="client-item">
        <a href="<?php echo esc_url($client['url']); ?>">
            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo $client['name']; ?>">
        </a>
        </div>
        <?php endforeach; ?>
    </div>
    <div id="clients-control-<?php echo $clients_id; ?>" class="clients-control">
        <div class="clients-nav nav_prev"><i class="fa fa-chevron-left"></i></div>
        <div class="clients-nav nav_next"><i class="fa fa-chevron-right"></i></div>
    </div>
</div>
<script>
  jQuery(document).ready(function($){
    var owl = $('#clients-list-<?php echo $clients_id; ?>');
    owl.owlCarousel({
        items : <?php echo $logo_per_slide; ?>,
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
                items: <?php echo $logo_per_slide; ?>
            },
            1200: {
                items: <?php echo $logo_per_slide; ?>
            },
            1300: {
                items: <?php echo $logo_per_slide; ?>
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
    $('#clients-control-<?php echo $clients_id; ?>').find(".nav_next").click(function(){
        owl.trigger('next.owl.carousel');
    });
    $('#clients-control-<?php echo $clients_id; ?>').find(".nav_prev").click(function(){
        owl.trigger('prev.owl.carousel');
    });
  });
</script>