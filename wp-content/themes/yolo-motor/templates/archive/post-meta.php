<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    23/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
?>
<ul class="entry-meta">
    <li class="entry-meta-author">
        <i class="fa fa-pencil-square-o p-color"></i> <?php printf('<a href="%1$s">%2$s</a>',esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),esc_html( get_the_author() )); ?>
    </li>

     <li class="entry-meta-date">
         <i class="fa fa-clock-o p-color"></i> <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"> <?php echo  get_the_date(get_option('date_format'));?> </a>
     </li>

    <?php if (has_category()) : ?>
        <li class="entry-meta-category">
            <i class="fa fa-folder-open p-color"></i> <?php echo get_the_category_list(', '); ?>
        </li>
    <?php endif; ?>

    <?php if ( comments_open() || get_comments_number() ) : ?>
        <li class="entry-meta-comment">
            <?php comments_popup_link( wp_kses_post(__('<i class="fa fa-comments-o p-color"></i> 0 Comment','yolo-motor')),wp_kses_post(__('<i class="fa fa-comments-o p-color"></i> 1 Comment','yolo-motor')), wp_kses_post(__('<i class="fa fa-comments-o p-color"></i> % Comments','yolo-motor'))); ?>
        </li>
    <?php endif; ?>
</ul>