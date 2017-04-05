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

// Don't print empty markup if there's nowhere to navigate.
$previous = (is_attachment()) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
$next     = get_adjacent_post(false, '', false);
if (!$next && !$previous) {
    return;
}
$yolo_options = yolo_get_options();
$show_post_navigation = $yolo_options['show_post_navigation'];
if ($show_post_navigation == 0) {
    return;
}
?>
<nav class="post-navigation" role="navigation">
    <div class="nav-links">
        <?php
        previous_post_link('<div class="nav-previous">%link</div>', _x('<div class="post-navigation-left"><i class="post-navigation-icon fa fa-angle-double-left"></i> <div class="post-navigation-label">Prev</div></div> <div class="post-navigation-content"> <div class="post-navigation-title">%title </div> </div> ', 'Previous post link', 'yolo-motor'));
        next_post_link('<div class="nav-next">%link</div>', _x('<div class="post-navigation-content"> <div class="post-navigation-title">%title</div></div> <div class="post-navigation-right"><i class="post-navigation-icon fa fa-angle-double-right"></i> <div class="post-navigation-label">Next</div></div>', 'Next post link', 'yolo-motor'));
        ?>
    </div>
    <!-- .nav-links -->
</nav><!-- .navigation -->