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
<?php if (is_home() && current_user_can('publish_posts')) : ?>

    <p><?php printf(wp_kses_post(__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'yolo-motor' )), admin_url('post-new.php')); ?></p>

<?php elseif (is_search()) : ?>

    <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'yolo-motor' ); ?></p>
    <?php get_search_form(); ?>

<?php
else : ?>
    <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'yolo-motor' ); ?></p>
    <?php get_search_form(); ?>
<?php endif; ?>