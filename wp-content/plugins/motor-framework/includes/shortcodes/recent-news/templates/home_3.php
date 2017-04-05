<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 29/1/2016
 * Time: 1:40 PM
 */

?>
<div class="recent-news-container">
  <div id="recent-news-list" class="slick-slider">
    <?php while( $recent_news->have_posts() ) : $recent_news->the_post(); ?>
      <div class="recent-news-item">
        <div class="post-thumbnail">
          <a href="<?php the_permalink() ?>"><?php the_post_thumbnail('medium'); ?></a>
        </div>
        <div class="post-information">
          <h3 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
          <p class="post-excerpt"><?php echo ($excerpt_length != '') ? yolo_limit_words_pg(get_the_excerpt(), $excerpt_length) : get_the_excerpt(); ?></p>
          <div class="post-meta">
            <span class="post-count-comments"><i class="fa fa-comments"></i><?php echo get_comments_number( get_the_ID() ) . ' ' . esc_html__( 'Comments', 'yolo-motor' ); ?></span>
            <span class="post-author"><i class="fa fa-pencil"></i><?php echo get_the_author(); ?></span>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
  <div class="recent-news-control">
    <div class="news-nav nav-prev"><i class="fa fa-chevron-left"></i></div>
    <div class="news-nav nav-next"><i class="fa fa-chevron-right"></i></div>
  </div>
</div>
<script>
  jQuery(document).ready(function($){
    var recent_news = $('.slick-slider');
    recent_news.slick({
      <?php if($yolo_options['enable_rtl_mode'] == 1) : ?> rtl : true, <?php endif;?>
      centerMode: true,
      centerPadding: '375px',
      slidesToShow: 2,
      slidesToScroll: 1,
      // variableWidth: true, // slidesToShow doesn't work, must use css to have width
      autoplay: <?php echo $autoplay; ?>,
      autoplaySpeed: <?php echo $slide_duration; ?>,
      prevArrow: ".recent-news-control .nav-prev",
      nextArrow: ".recent-news-control .nav-next",
      responsive: [
        {
          breakpoint: 1500,
          settings: {
            centerPadding: '100px',
            slidesToShow: 2
          }
        },
        {
          breakpoint: 1130,
          settings: {
            centerPadding: '200px',
            slidesToShow: 1
          }
        },
        {
          breakpoint: 850,
          settings: {
            centerPadding: '150px',
            slidesToShow: 1
          }
        },
        {
          breakpoint: 768,
          settings: {
            centerPadding: '100px',
            slidesToShow: 1
          }
        },
        {
          breakpoint: 500,
          settings: {
            centerPadding: '100px',
            slidesToShow: 1
          }
        },
        {
          breakpoint: 479,
          settings: {
            centerPadding: '0',
            slidesToShow: 1
          }
        },
      ]
    });
  });
</script>    


