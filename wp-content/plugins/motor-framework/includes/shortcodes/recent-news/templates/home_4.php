<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 30/1/2016
 * Time: 2:10 PM
 */

?>
<div class="recent-news-container row">
    <?php //var_dump($recent_news); ?>
    <?php while( $recent_news->have_posts() ) : $recent_news->the_post(); ?>
      <article class="col-xs-12 col-sm- 12 col-md-<?php echo (12/$columns) ;?>">
        <div class="post-thumbnail">
          <div class="post-image">
            <img src="<?php the_post_thumbnail('medium'); ?>" alt ="<?php the_title();?>">  
            <a class="post-link" href="<?php the_permalink() ?>"></a>
          </div>
          <div class="overlay-bg">
          </div>
          <div class="post-meta">
            <p class="post-date"><?php echo get_the_date( 'd', get_the_ID() );?></p>
            <p class="post-month"><?php echo get_the_date( 'M', get_the_ID() );?></p>
          </div>
          <div class="post-content">
            <h4 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
            <div class="post-info">
              <span class="post-author"><i class="fa fa-pencil-square-o"></i><?php echo get_the_author(); ?> </span>
              <span class="post-count-comments"><i class="fa fa-comments"></i><?php echo get_comments_number( get_the_ID() ) . ' ' . esc_html__( 'Comments', 'yolo-motor' ); ?></span>
            </div>
            <p class="post-excerpt"><?php echo ($excerpt_length != '') ? yolo_limit_words_pg(get_the_excerpt(), $excerpt_length) : get_the_excerpt(); ?></p>
            <a href="<?php the_permalink();?>" class="btn-readmore"><span class="span-text"><?php echo esc_html__('Read more', 'yolo-motor');?></span></a>
          </div> 
        </div>   
        
      </article>
    <?php endwhile; ?>
</div>    


