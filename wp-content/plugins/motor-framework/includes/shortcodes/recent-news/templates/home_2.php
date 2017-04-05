<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 28/1/2016
 * Time: 5:05 PM
 */

$i               = 0;
$posts_current   = 0;
$posts_per_slide = $rows * $posts_per_row;
$recent_news_id  = uniqid();
?>
<div class="recent-news-container">
  <div id="recent-news-control-<?php echo $recent_news_id; ?>" class="recent-news-control">
    <div class="nav_prev"><i class="fa fa-chevron-left"></i></div>
    <div class="nav_next"><i class="fa fa-chevron-right"></i></div>
  </div>
  <ul id="recent-news-list-<?php echo $recent_news_id; ?>" class="recent-news-list owl-carousel owl-theme">
    <?php while( $recent_news->have_posts() ) : $recent_news->the_post(); ?>
      <?php if( $posts_current % $posts_per_slide == 0 ) : ?>
      <li class="recent-news-item"><!-- Slide item -->
      <?php endif; ?>

        <?php if( $i % $posts_per_row == 0 ) : ?>
          <div class="row"><!-- Slide row -->
        <?php endif; ?>
            <article class="col-xs-12 col-sm-12 col-md-<?php echo (12/$posts_per_row); ?>">
              <div class="post-thumbnail">
                <?php the_post_thumbnail('medium'); ?>
                <div class="post-meta">
                  <p class="yl-date"><?php echo get_the_date( 'd', get_the_ID() );?></p>
                  <p class="yl-month"><?php echo get_the_date( 'M', get_the_ID() );?></p>
                </div>
              </div>
              <div class="post-information">
                <h3 class="post-blog-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                <div class="info-meta">
                  <span class="post-count-comments"><i class="fa fa-comments"></i><?php echo get_comments_number( get_the_ID() ); ?></span>
                  <span class="post-author"><i class="fa fa-pencil"></i><?php echo get_the_author(); ?> </span>
                </div>
                <p class="post-blog-excerpt"><?php echo ($excerpt_length != '') ? yolo_limit_words_pg(get_the_excerpt(), $excerpt_length) : get_the_excerpt(); ?></p>
                <div class="polygon"></div>
              </div>
            </article>
        <?php if( (($i + $posts_per_row - 1) % $posts_per_row == 0) || ($i == $recent_news->post_count )) : ?>
          </div>
        <?php endif; ?>

      <?php if( (($posts_current + $posts_per_slide + 1) % $posts_per_slide == 0) || ($posts_current == $recent_news->post_count ) ) : ?>
      </li>
      <?php endif; ?>

      <?php 
        $posts_current++; 
        $i++;
      ?>
    <?php endwhile; ?>
  </ul>
</div>
<script>
  jQuery(document).ready(function($){
    var owl = $('#recent-news-list-<?php echo $recent_news_id; ?>');
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
    $('#recent-news-control-<?php echo $recent_news_id; ?>').find(".nav_next").click(function(){
      owl.trigger('next.owl.carousel');
    });
     $('#recent-news-control-<?php echo $recent_news_id; ?>').find(".nav_prev").click(function(){
      owl.trigger('prev.owl.carousel');
    });
  });
</script>    


