<?php 
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    14/3/2016
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

$post_format = get_post_format();
switch ($post_format) {
	case false: // Standart post
		echo '<i class="fa fa-file p-color"></i>';
		break;
	case 'aside':
		echo '<i class="fa fa-file-text p-color"></i>';
		break;
	case 'image':
		echo '<i class="fa fa-file-image-o p-color"></i>';
		break;
	case 'gallery':
		echo '<i class="fa fa-file-image-o p-color"></i>';
		break;
	case 'video':
		echo '<i class="fa fa-file-video-o p-color"></i>';
		break;
	case 'audio':
		echo '<i class="fa fa-music p-color"></i>';
		break;
	case 'quote':
		echo '<i class="fa fa-quote-left p-color"></i>';
		break;
	case 'link':
		echo '<i class="fa fa-link p-color"></i>';
		break;
	
	default:
		echo '<i class="fa fa-file p-color"></i>';
		break;
}

?>