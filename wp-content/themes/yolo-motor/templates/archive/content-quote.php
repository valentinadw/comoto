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

$prefix = 'yolo_';
global $padding;
$quote_content = get_post_meta(get_the_ID(),$prefix.'post_format_quote',true);
$quote_author = get_post_meta(get_the_ID(),$prefix.'post_format_quote_author',true);
$quote_author_url = get_post_meta(get_the_ID(),$prefix.'post_format_quote_author_url',true);
$class = array();
$class[]= "clearfix";
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?> <?php if($padding):?>style = "<?php echo 'padding: 15px';?>"<?php endif;?>>
    <div class = "post-item">
        <i class="post-format-icon fa fa-quote-right p-color-bg"></i>
        <div class="entry-content-wrap">
            <h3 class="entry-title p-font">
                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h3>
            <div class="entry-post-meta-wrap">
                <?php yolo_post_meta(); ?>
            </div>
            <div class="entry-content-quote s-font">
                <?php if (empty($quote_content) || empty($quote_author) || empty($quote_author_url)) : ?>
                    <?php the_content(); ?>
                <?php else : ?>
                    <blockquote>
                        <p><?php echo esc_html($quote_content); ?></p>
                        <cite><a href="<?php echo esc_url($quote_author_url) ?>" title="<?php echo esc_attr($quote_author); ?>"><?php echo esc_html($quote_author); ?></a></cite>
                    </blockquote>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>
