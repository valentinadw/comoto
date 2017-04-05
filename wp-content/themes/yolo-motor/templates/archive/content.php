<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 */
global $yolo_archive_loop,$excerpt_length,$post,$padding;
$size = 'full';
if (isset($yolo_archive_loop['image-size'])) {
    $size = $yolo_archive_loop['image-size'];
}
$date    = get_the_date('d M');
$date    = explode(' ',$date);
$class   = array();
$class[] = "clearfix";
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?> <?php if($padding){ echo 'style="padding: 0 15px 30px 15px;"'; } ?>>
    <div class="post-item">
        <div class="entry-wrap">
            <?php
            $thumbnail = yolo_post_thumbnail($size);
            if (!empty($thumbnail)) : ?>
                <div class="entry-thumbnail-wrap">
                    <?php echo wp_kses_post($thumbnail); ?>
                    <div class="date-overlay">
                        <span class="day"><?php echo $date['0'];?></span>
                        <span class="month"><?php echo $date['1'];?></span>
                    </div>
                </div>
            <?php endif; ?>
            <div class="entry-content-wrap">
                <div class="entry-detail">
                    <h3 class="entry-title p-font">
                        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <div class="entry-post-meta-wrap">
                        <?php yolo_post_meta(); ?>
                    </div>
                    <div class="entry-excerpt">
                        <?php
                            if( $excerpt_length ) {
                                $excerpt = $post->post_excerpt;
                                if(empty($excerpt))
                                    $excerpt = $post->post_content;
                                    $excerpt = strip_shortcodes($excerpt);
                                    $excerpt = wp_trim_words($excerpt,$excerpt_length,'...');
                                    echo '<p>'.esc_html($excerpt).'</p>';
                            } else {
                                the_excerpt();
                            }
                            
                        ?>
                    </div>
                    <a href="<?php the_permalink();?>" class="btn-readmore"><i class="fa fa-long-arrow-right"></i><span class="span-text"><?php echo esc_html__( 'Read more', 'yolo-motor' );?></span></a>
                </div>
            </div>
        </div>
    </div>
</article>