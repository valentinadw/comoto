<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    235/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

?>
<?php if (!is_front_page()) : ?>
	<?php yolo_get_breadcrumb(); ?>
<?php else: ?>
	<ul class="breadcrumbs">
		<li><a property="v:url" href="<?php echo home_url('/') ?>" class="home"><?php esc_html_e( 'Home','yolo-motor' );?> </a></li>
		<li><span><?php esc_html_e( 'Blog', 'yolo-motor' ); ?></span></li>
	</ul>
<?php endif; ?>