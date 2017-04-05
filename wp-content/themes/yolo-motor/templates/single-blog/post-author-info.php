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

$yolo_options = yolo_get_options();
$show_author_info = $yolo_options['show_author_info'];
if ($show_author_info == 0) {
    return;
}
$author_description = get_the_author_meta('description');
if (empty($author_description)) return;
?>
<div class="author-info clearfix">
    <div class="author-avatar">
        <?php
        $author_avatar_size = apply_filters( 'yolo_framework_author_avatar_size', 70 );
        echo get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size );
        ?>
        <h3 class="author-title"><?php the_author_posts_link(); ?></h3>
    </div>
    <div class="author-description">
        <p class="author-bio"><?php the_author_meta( 'description' ); ?></p>
    </div>
</div>