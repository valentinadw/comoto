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

$header_class = array('yolo-main-header', 'header-4', 'header-desktop-wrapper');
$header_nav_wrapper = array('yolo-header-nav-wrapper');
// @TODO: need process page_enable_header_customize from header.php
$header_customize = get_post_meta(get_the_ID(),$prefix.'header_customize',true);
if($header_customize == 1){
	$header_layout_float = get_post_meta(get_the_ID(), $prefix . 'header_layout_float',true);
	if (($header_layout_float == '') || ($header_layout_float == '-1')) {
		$header_layout_float = $yolo_options['header_layout_float'];
	}
	if ($header_layout_float == '1') {
		$header_class[] = 'header-float';
	}
	$header_sticky = get_post_meta(get_the_ID(), $prefix . 'header_sticky',true);
	if (($header_sticky == '') || ($header_sticky == '-1')) {
		$header_sticky = $yolo_options['header_sticky'];
	}
	if ($header_sticky == '1') {
		$header_nav_wrapper[] = 'header-sticky';

		$header_sticky_scheme = get_post_meta(get_the_ID(), $prefix . 'header_sticky_scheme',true);
		if (($header_sticky_scheme == '') || ($header_sticky_scheme == '-1')) {
			$header_sticky_scheme = isset($yolo_options['header_sticky_scheme']) ? $yolo_options['header_sticky_scheme'] : 'inherit';
		}
		$header_nav_wrapper[] = 'sticky-scheme-' . $header_sticky_scheme;
	}

	$header_nav_hover = get_post_meta(get_the_ID(), $prefix . 'header_nav_hover',true);
	if (($header_nav_hover == '') || ($header_nav_hover == '-1')) {
		$header_nav_hover = isset($yolo_options['header_nav_hover']) && !empty($yolo_options['header_nav_hover'])
			? $yolo_options['header_nav_hover'] : 'nav-hover-primary';
	}
	$header_nav_wrapper[] = $header_nav_hover;
	$page_menu = get_post_meta(get_the_ID(), $prefix . 'page_menu',true);
	$header_nav_layout = get_post_meta(get_the_ID(), $prefix . 'header_nav_layout',true);
	if (($header_nav_layout == '-1') || ($header_nav_layout == '')) {
		$header_nav_layout = isset($yolo_options['header_nav_layout']) ? $yolo_options['header_nav_layout'] : '';
	}
	if ($header_nav_layout == 'nav-fullwith') {
		$header_nav_wrapper[] = $header_nav_layout;
	}
}else{
	$header_layout_float = $yolo_options['header_layout_float'];
	if ($header_layout_float == '1') {
		$header_class[] = 'header-float';
	}
	$header_sticky = $yolo_options['header_sticky'];
	if ($header_sticky == '1') {
		$header_nav_wrapper[] = 'header-sticky';
		$header_sticky_scheme = isset($yolo_options['header_sticky_scheme']) ? $yolo_options['header_sticky_scheme'] : 'inherit';
		$header_nav_wrapper[] = 'sticky-scheme-' . $header_sticky_scheme;
	}
	
	$header_nav_wrapper[] = isset($yolo_options['header_nav_hover']) && !empty($yolo_options['header_nav_hover'])? $yolo_options['header_nav_hover'] : 'nav-hover-primary';
	$header_nav_layout 	  = isset($yolo_options['header_nav_layout']) ? $yolo_options['header_nav_layout'] : '';
	if ($header_nav_layout == 'nav-fullwith') {
		$header_nav_wrapper[] = $header_nav_layout;
	}
}
?>
<header id="yolo-header" class="<?php echo join(' ', $header_class) ?>">
	<div class="yolo-header-nav-above text-left">
		<div class="container">
			<div class="fl">
				<?php yolo_get_template('header/header-logo' ); ?>
			</div>
			<div class="fr">
				<?php yolo_get_template('header/header-customize-right' ); ?>
			</div>
		</div>
	</div>
	<div class="<?php echo join(' ', $header_nav_wrapper) ?>">
		<div class="container">
			<div class="yolo-header-wrapper">
				<div class="header-left">
					<?php if (has_nav_menu('primary')) : ?>
						<div id="primary-menu" class="menu-wrapper">
							<?php
							$arg_menu = array(
								'menu_id'        => 'main-menu',
								'container'      => '',
								'theme_location' => 'primary',
								'menu_class'     => 'yolo-main-menu nav-collapse navbar-nav',
								'fallback_cb'    => 'please_set_menu',
								'walker'         => new Yolo_MegaMenu_Walker()
							);
							if (!empty($page_menu)) {
								$arg_menu['menu'] = $page_menu;
							}
							wp_nav_menu( $arg_menu );
							?>
						</div>
					<?php endif; ?>
				</div>
				<div class="header-right">
					<?php yolo_get_template('header/header-customize-nav' ); ?>
				</div>
			</div>
		</div>
	</div>
</header>