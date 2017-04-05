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
$prefix = 'yolo_';
$layout_style = get_post_meta(get_the_ID(),$prefix.'page_layout',true);
if (($layout_style == '') || ($layout_style == '-1')) {
	$layout_style = isset($yolo_options['page_layout'])? $yolo_options['page_layout'] : 'container';
}
// Add page_background options
$page_background_color = get_post_meta(get_the_ID(),$prefix.'page_background_color',true);
if ($page_background_color == '') {
	$page_background_color = $yolo_options['page_background_color'];
}
$sidebar = get_post_meta(get_the_ID(),$prefix.'page_sidebar',true);
if (($sidebar == '') || ($sidebar == '-1')) {
	$sidebar = isset($yolo_options['page_sidebar']) ? $yolo_options['page_sidebar'] :'right';
}
$left_sidebar = get_post_meta(get_the_ID(),$prefix.'page_left_sidebar',true);
if (($left_sidebar == '') || ($left_sidebar == '-1')) {
	$left_sidebar = isset($yolo_options['page_left_sidebar']) ? $yolo_options['page_left_sidebar'] : 'sidebar-1';

}
$right_sidebar = get_post_meta(get_the_ID(),$prefix.'page_right_sidebar',true);
if (($right_sidebar == '') || ($right_sidebar == '-1')) {
	$right_sidebar = isset($yolo_options['page_right_sidebar'])? $yolo_options['page_right_sidebar'] : 'sidebar-1';
}
$sidebar_width = get_post_meta(get_the_ID(),$prefix.'sidebar_width',true);
if (($sidebar_width == '') || ($sidebar_width == '-1')) {
	$sidebar_width = isset($yolo_options['page_sidebar_width'])? $yolo_options['page_sidebar_width']: 'small';
}
$page_comment = isset($yolo_options['page_comment']) ? $yolo_options['page_comment'] : (comments_open() || get_comments_number());
// Calculate sidebar column & content column
$sidebar_col = 'col-md-3';
if ($sidebar_width == 'large') {
	$sidebar_col = 'col-md-4';
}

$content_col_number = 12;
if (is_active_sidebar($left_sidebar) && (($sidebar == 'both') || ($sidebar == 'left'))) {
	if ($sidebar_width == 'large') {
		$content_col_number -= 4;
	} else {
		$content_col_number -= 3;
	}
}
if (is_active_sidebar($right_sidebar) && (($sidebar == 'both') || ($sidebar == 'right'))) {
	if ($sidebar_width == 'large') {
		$content_col_number -= 4;
	} else {
		$content_col_number -= 3;
	}
}

$content_col = 'col-md-' . $content_col_number;
if (($content_col_number == 12) && ($layout_style == 'full')) {
	$content_col = '';
}

$main_class = array('yolo-site-content-page');

if ($content_col_number < 12) {
    $main_class[] = 'has-sidebar';
}
?>
<?php
/**
 * @hooked - yolo_page_heading - 5
 **/
do_action('yolo_before_page');
?>
<main class="<?php echo join(' ',$main_class); ?>" style="<?php if( $page_background_color != "" ) : ?>background: <?php echo $page_background_color; ?>; <?php endif; ?>">
	<?php if ($layout_style != 'full') : ?>
	<div class="<?php echo esc_attr($layout_style) ?> clearfix">
	<?php endif;?>
		<?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
		<div class="row clearfix">
		<?php endif;?>
			<?php if (is_active_sidebar( $left_sidebar ) && (($sidebar == 'left') || ($sidebar == 'both'))): ?>
				<div class="<?php echo esc_attr($sidebar_col) ?> col-sm-12 col-xs-12">
					<div class="sidebar left-sidebar sidebar-<?php echo esc_attr($sidebar_width); ?>">
						<?php dynamic_sidebar( $left_sidebar );?>
					</div>
				</div>
			<?php endif;?>
			<div class="yolo-site-content-page-inner <?php echo esc_attr($content_col); ?>">
				<div class="page-content">
                    <?php
                    // Start the Loop.
                    while (have_posts()) : the_post();
                        // Include the page content template.
                        yolo_get_template('content', 'page');
                    endwhile;
                    ?>
				</div>
                <?php if ($page_comment == 1) {
                    comments_template();
                } 
                ?>
			</div>
			<?php if (is_active_sidebar( $right_sidebar ) && (($sidebar == 'right') || ($sidebar == 'both'))) : ?>
				<div class="<?php echo esc_attr($sidebar_col) ?> col-sm-12 col-xs-12">
					<div class="sidebar right-sidebar sidebar-<?php echo esc_attr($sidebar_width); ?>">
						<?php dynamic_sidebar( $right_sidebar );?>
					</div>
				</div>
			<?php endif;?>
		<?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
		</div>
		<?php endif;?>
	<?php if ($layout_style != 'full') : ?>
	</div>
	<?php endif;?>
</main>