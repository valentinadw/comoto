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

	$yolo_options = yolo_get_options();

	$prefix = 'yolo_';

	$data_search_type = 'standard';
	if (isset($yolo_options['search_box_type']) && ($yolo_options['search_box_type'] == 'ajax')) {
		$data_search_type = 'ajax';
	}
	$search_box_type = 'standard';
	$search_box_submit = 'submit';
	if (isset($yolo_options['search_box_type'])) {
		$search_box_type = $yolo_options['search_box_type'];
	}
	if ($search_box_type == 'ajax') {
		$search_box_submit = 'button';
	}
?>
<div class="search-box-wrapper header-customize-item" data-hint-message="<?php esc_html_e( 'Enter keyword to search', 'yolo-motor' ); ?>">
	<form method="get" action="<?php echo esc_url(site_url()); ?>" class="search-type-<?php echo esc_attr($search_box_type) ?> search-box">
		<input type="text" name="s" placeholder="<?php esc_html_e( 'Search', 'yolo-motor' ); ?>"/>
		<input type="hidden" name="post_type" value="product">
		<button type="<?php echo esc_attr($search_box_submit) ?>"><i class="wicon fa fa-search"></i></button>
	</form>
</div>