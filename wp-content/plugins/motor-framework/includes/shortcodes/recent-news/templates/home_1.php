<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 26/1/2016
 * Time: 5:40 PM
 */

?>
<div class="recent-news-container">
    <?php while( $recent_news->have_posts() ) : $recent_news->the_post(); ?>
      <div class="recent-news-item">
        <div class="post-thumbnail">
          <div class="post-img" style="background-image: url('<?php the_post_thumbnail_url( 'medium' ); ?>');"></div>
          <div class="post-meta">
            <p class="post-date"><?php echo get_the_date( 'd', get_the_ID() );?></p>
            <p class="post-month"><?php echo get_the_date( 'M', get_the_ID() );?></p>
          </div>
        </div>
        <div class="overlay-bg"></div>
        <div class="post-content">
          <h4 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
          <p class="post-blog-excerpt"><?php echo ($excerpt_length != '') ? yolo_limit_words_pg(get_the_excerpt(), $excerpt_length) : get_the_excerpt(); ?></p>
          <a href="<?php the_permalink();?>" class="btn-readmore"><span class="span-text"><?php echo esc_html__('Read more', 'yolo-motor');?></span></a>
        </div>
      </div>
    <?php endwhile; ?>
</div>    


