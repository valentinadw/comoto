<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

// global $yolo_header_layout;
$yolo_header_layout = yolo_get_header_layout();
$yolo_options = yolo_get_options();

$prefix = 'yolo_';
/* ------------CUSTOM LOGO---------------*/
$logo_meta = get_post_meta(get_the_ID(),$prefix . 'custom_logo', true);
$logo_url = '';
if (!empty($logo_meta)) {
	$logo_url = wp_get_attachment_url($logo_meta);
}elseif(isset($yolo_options['logo']['url']) && !empty($yolo_options['logo']['url'])){
	$logo_url = $yolo_options['logo']['url'];
}

if ($logo_url == '') {
	$logo_url = get_template_directory_uri() . '/assets/images/theme-options/logo.png';
}
/*---------------STICKY LOGO---------------------*/
$logo_sticky = '';
if (!in_array($yolo_header_layout, array('header-2', 'header-4', 'header-6'))) {
	$logo_sticky_meta = get_post_meta(get_the_ID(),$prefix . 'sticky_logo', true);
	if( !empty($logo_sticky_meta) ) {
		$logo_sticky = wp_get_attachment_url($logo_sticky_meta);
	}else 
		if(isset($yolo_options['sticky_logo']) && isset($yolo_options['sticky_logo']['url'])) {
			$logo_sticky = $yolo_options['sticky_logo']['url'];
		}else{
			$logo_sticky = $logo_url;
		}
}
$header_logo_class = array('header-logo');
if (!empty($logo_sticky) && ($logo_sticky != $logo_url)) {
	$header_logo_class[] = 'has-logo-sticky';
}

// Logo Height
$logo_height = get_post_meta(get_the_ID(),$prefix . 'logo_height',true);
if ($logo_height == '') {
	if (isset($yolo_options['logo_height']) && isset($yolo_options['logo_height']['height']) && ! empty($yolo_options['logo_height']['height'])) {
		$logo_height = $yolo_options['logo_height']['height'];
	}
}
$logo_height = str_replace('px' , '', $logo_height);
if ($logo_height != '') {
	$logo_height .= 'px';
}
?>
<div class="<?php echo join(' ', $header_logo_class) ?>">
	<a  href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>">
		<img <?php echo ($logo_height == '' ? '' : 'style="height:' . esc_attr($logo_height) .'"') ?> src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" />
	</a>
</div>
<?php if (!empty($logo_sticky) && ($logo_sticky != $logo_url)) : ?>
	<div class="logo-sticky">
		<a  href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>">
			<img src="<?php echo esc_url($logo_sticky); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" />
		</a>
	</div>
<?php endif;?>