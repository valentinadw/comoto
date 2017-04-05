<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    25/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 */
global $yolo_archive_loop;
$yolo_options = yolo_get_options();

if (isset($yolo_archive_loop['image-size'])) {
    $size = $yolo_archive_loop['image-size'];
} else {
    $size = 'full';
}

$class = array();
$class[]= "clearfix";

?>
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
    <div class="entry-post-meta-wrap">
        <?php yolo_single_post_meta(); ?>
    </div>
    
    <?php
    $thumbnail = yolo_post_thumbnail($size);
    if (!empty($thumbnail)) : ?>
        <div class="entry-thumbnail-wrap">
            <?php echo wp_kses_post($thumbnail); ?>
        </div>
    <?php endif; ?>
    <div class="entry-content-wrap">
        <div class="entry-content clearfix">
            <?php the_content(); ?>
        </div>

        <?php
        /**
         * @hooked - yolo_link_pages - 5
         * @hooked - yolo_post_tags - 10
         * @hooked - yolo_share - 15
         *
         **/
        do_action('yolo_after_single_post_content');
        ?>

    </div>
    <?php
    /**
     * @hooked - yolo_post_nav - 20
     * @hooked - yolo_post_author_info - 25
     *
     **/
    ?>
</article>
<?php do_action('yolo_after_single_post');?>
