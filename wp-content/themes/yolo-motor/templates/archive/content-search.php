<?php
/**
 * The default template for displaying content
 *
 * Used for search.
 *
 * @package WordPress
 */
global $post;
$class   = array();
$class[] = "clearfix";
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
	<div class="entry-content-wrap">
		<h3 class="entry-title p-font">
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h3>
		<?php
            $thumbnail = yolo_post_thumbnail($size);
            if (!empty($thumbnail)) : ?>
                <div class="entry-thumbnail-wrap">
                    <?php echo wp_kses_post($thumbnail); ?>
                </div>
            <?php endif; ?>
		<div class="entry-post-meta-wrap">
			<?php yolo_post_meta(); ?>
		</div>
		<?php //if ($post->post_type == 'post'): ?>
		<div class="entry-excerpt">
			<?php the_excerpt(); ?>
		</div>
		<?php //else: ?>
			<a class="motor-button style2 button-1x" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php esc_html_e( 'View more', 'yolo-motor' ) ?></a>
		<?php //endif; ?>
	</div>
</article>


