<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    14/03/2016
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if (post_password_required()) {
    return;
}
?>
<?php if (comments_open() || get_comments_number()) : ?>
    <div class="entry-comments" id="comments">
        <?php if (have_comments()) : ?>
            <h3 class="comments-title">
                <span>
                    <?php comments_number(esc_html__('No Comments', 'yolo-motor'), esc_html__('One Comment', 'yolo-motor'), esc_html__('There are % comments', 'yolo-motor')); ?>
                </span>
            </h3>
            <div class="entry-comments-list">
                <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
                    <nav class="comment-navigation clearfix pull-right" role="navigation">
                        <?php $paginate_comments_args = array(
                            'prev_text' => '<i class="fa fa-angle-double-left"></i>',
                            'next_text' => '<i class="fa fa-angle-double-right"></i>'
                        );
                        paginate_comments_links($paginate_comments_args);
                        ?>
                    </nav>
                    <div class="clearfix"></div>
                <?php endif; ?>
                <ol class="commentlist clearfix">
                    <?php wp_list_comments(array(
                        'style'       => 'li',
                        'callback'    => 'yolo_render_comments',
                        'avatar_size' => 70,
                        'short_ping'  => true,
                    )); ?>
                </ol>
                <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
                    <nav class="comment-navigation clearfix pull-right comment-navigation-bottom" role="navigation">
                        <?php paginate_comments_links($paginate_comments_args); ?>
                    </nav>
                    <div class="clearfix"></div>
                <?php endif; ?>
            </div>
        <?php endif;?>

        <?php if (comments_open()) : ?>
            <div class="entry-comments-form">
            <!-- @TODO: user not login don't show email, name, website field -->
                <?php yolo_comment_form(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>