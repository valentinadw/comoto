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

	// global $yolo_header_layout;
	$yolo_header_layout = yolo_get_header_layout();
	$yolo_options = yolo_get_options();

	$prefix = 'yolo_';

	$data_search_type = 'standard';
	if (isset($yolo_options['search_box_type']) && ($yolo_options['search_box_type'] == 'ajax')) {
		$data_search_type = 'ajax';
	}
?>
<div class="search-button-wrapper header-customize-item">
	<a class="icon-search-menu" href="#" data-search-type="<?php echo esc_attr($data_search_type) ?>"><i class="wicon fa fa-search"></i></a>
</div>