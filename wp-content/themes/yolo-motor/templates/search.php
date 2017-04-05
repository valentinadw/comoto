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

	$layout_style = isset($yolo_options['search_layout']) ? $yolo_options['search_layout'] : 'container';
	$sidebar = isset($yolo_options['search_sidebar']) ? $yolo_options['search_sidebar'] : 'left' ;
	$archive_paging_style = isset($yolo_options['search_paging_style']) ? $yolo_options['search_paging_style'] : 'default';
	$archive_paging_align = isset($yolo_options['search_paging_align']) ? $yolo_options['search_paging_align'] : 'right';
	$sidebar_width = isset($yolo_options['search_sidebar_width']) ? $yolo_options['search_sidebar_width'] : 'small';
	$left_sidebar = isset($yolo_options['search_left_sidebar']) ? $yolo_options['search_left_sidebar'] : '';
	$right_sidebar = isset($yolo_options['search_right_sidebar']) ? $yolo_options['search_right_sidebar'] : '';

	$sidebar_col = 'col-md-3';
	if ($sidebar_width == 'large') {
		$sidebar_col = 'col-md-4';
	}

	$content_col_number = 12;
	if (is_active_sidebar( $left_sidebar ) && (($sidebar == 'both') || ($sidebar == 'left'))) {
		if ($sidebar_width == 'large') {
			$content_col_number -= 4;
		}
		else {
			$content_col_number -= 3;
		}
	}
	if (is_active_sidebar( $right_sidebar ) && (($sidebar == 'both') || ($sidebar == 'right'))) {
		if ($sidebar_width == 'large') {
			$content_col_number -= 4;
		}
		else {
			$content_col_number -= 3;
		}
	}

	$content_col = 'col-md-' . $content_col_number;
	if (($content_col_number == 12) && ($layout_style == 'full')) {
		$content_col = '';
	}

	$archive_display_type = 'large-image';

	$blog_wrap_class= array('blog-wrap');

	$blog_wrap_class[] = 'layout-' . $layout_style;
	$blog_wrap_class[] = $archive_display_type;

	$blog_class = array('blog-inner','clearfix');
	$blog_class[] = 'blog-style-' . $archive_display_type;
	$blog_class[] = 'blog-style-search';
	$blog_class[] = 'blog-paging-'.$archive_paging_style;

	$blog_paging_class = array('blog-paging-wrapper');
	$blog_paging_class[] = 'blog-paging-' . $archive_paging_style;
	$blog_paging_class[] = 'text-' . $archive_paging_align;
?>
<?php
/**
 * @hooked - yolo_archive_heading - 5
 **/
do_action('yolo_before_archive');
?>
<main class="site-content-archive">
	<?php if ($layout_style != 'full'): ?>
		<div class="<?php echo esc_attr($layout_style) ?> clearfix">
	<?php endif;?>
			<?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
				<div class="row clearfix">
			<?php endif;?>

					<?php if (is_active_sidebar( $left_sidebar ) && (($sidebar == 'left') || ($sidebar == 'both'))): ?>
						<div class="sidebar left-sidebar <?php echo esc_attr($sidebar_col) ?> col-sm-12 col-xs-12 sidebar-<?php echo esc_attr($sidebar_width); ?>">
							<?php dynamic_sidebar( $left_sidebar );?>
						</div>
					<?php endif;?>

					<div class="site-content-archive-inner <?php echo esc_attr($content_col) ?>">
						<div class="<?php echo join(' ',$blog_wrap_class); ?>">
							<div class="<?php echo join(' ',$blog_class); ?>">
								<?php
								if ( have_posts() ) :
									// Start the Loop.
									while ( have_posts() ) : the_post();
										/*
										 * Include the post format-specific template for the content. If you want to
										 * use this in a child theme, then include a file called called content-___.php
										 * (where ___ is the post format) and that will be used instead.
										 */
										yolo_get_template( 'archive/content-search');
									endwhile;
									yolo_archive_loop_reset();
								else :
									// If no content, include the "No posts found" template.
									yolo_get_template( 'archive/content-none');
								endif;
								?>
							</div>
							<?php
							global $wp_query;
							if ( $wp_query->max_num_pages > 1 ) :
								?>
								<div class="<?php echo join(' ',$blog_paging_class); ?>">
									<?php
									switch($archive_paging_style) {
										case 'load-more':
											yolo_paging_load_more();
											break;
										case 'infinity-scroll':
											yolo_paging_infinitescroll();
											break;
										default:
											echo yolo_paging_nav();
											break;
									}
									?>
								</div>
							<?php endif;?>
						</div>
					</div>
					<?php if (is_active_sidebar( $right_sidebar ) && (($sidebar == 'right') || ($sidebar == 'both'))): ?>
						<div class="sidebar right-sidebar <?php echo esc_attr($sidebar_col) ?> col-sm-12 col-xs-12 sidebar-<?php echo esc_attr($sidebar_width); ?>">
							<?php dynamic_sidebar( $right_sidebar );?>
						</div>
					<?php endif;?>

			<?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
				</div>
			<?php endif;?>
	<?php if ($layout_style != 'full'): ?>
		</div>
	<?php endif;?>
</main>
