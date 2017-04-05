<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php wp_link_pages(array(
		'before'      => '<div class="yolo-page-links"><span class="yolo-page-links-title">' . esc_html__( 'Pages:', 'yolo-motor' ) . '</span>',
		'after'       => '</div>',
		'link_before' => '<span class="yolo-page-link">',
		'link_after'  => '</span>',
	)); ?>

</div>