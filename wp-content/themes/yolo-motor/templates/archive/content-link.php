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

global $padding;
$prefix = 'yolo_';
$url = get_post_meta(get_the_ID(),$prefix.'post_format_link_url',true);
$text = get_post_meta(get_the_ID(),$prefix.'post_format_link_text',true);
$class = array();
$class[]= "clearfix";
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?> <?php if($padding):?>style = "<?php echo 'padding: 15px';endif;?> ">
    <div class = "post-item">
        <i class="post-format-icon fa fa-link p-color-bg"></i>
        <div class="entry-content-wrap">
            <h3 class="entry-title p-font">
                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h3>
            <div class="entry-post-meta-wrap">
                <?php yolo_post_meta(); ?>
            </div>
            <div class="entry-content-link s-font">
                <?php if (empty($url) || empty($text)) : ?>
                    <?php the_content(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url($url); ?>" rel="bookmark">
                        <?php echo esc_html($text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>

