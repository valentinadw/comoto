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

$yolo_options = yolo_get_options();
$prefix = 'yolo_';

$header_class = array('yolo-mobile-header');

// Get header mobile layout

$mobile_header_layout = 'header-mobile-1';
if (isset($yolo_options['mobile_header_layout']) && !empty($yolo_options['mobile_header_layout'])) {
	$mobile_header_layout = $yolo_options['mobile_header_layout'];
}

$header_class[] = $mobile_header_layout;

// Get logo url for mobile

if (isset($yolo_options['mobile_header_logo']['url']) && !empty($yolo_options['mobile_header_logo']['url'])) {
	$logo_url = $yolo_options['mobile_header_logo']['url'];
}
else if (isset($yolo_options['logo']['url']) && !empty($yolo_options['logo']['url'])) {
	$logo_url = $yolo_options['logo']['url'];
}

// Get search & mini-cart for header mobile
$mobile_header_shopping_cart = $yolo_options['mobile_header_shopping_cart'];


$mobile_header_search_box = $yolo_options['mobile_header_search_box'];


$mobile_header_menu_drop = 'dropdown';
if (isset($yolo_options['mobile_header_menu_drop']) && !empty($yolo_options['mobile_header_menu_drop'])) {
	$mobile_header_menu_drop = $yolo_options['mobile_header_menu_drop'];
}

$header_container_wrapper_class = array('yolo-header-container-wrapper', 'menu-drop-' . $mobile_header_menu_drop);


$mobile_header_stick = isset($yolo_options['mobile_header_stick']) ? $yolo_options['mobile_header_stick'] : '0';

if ($mobile_header_stick == '1') {
	$header_container_wrapper_class[] = 'header-mobile-sticky';
}

$page_menu = get_post_meta(get_the_ID(),$prefix . 'page_menu_mobile',true);
if (empty($page_menu)) {
	$page_menu = get_post_meta(get_the_ID(),$prefix . 'page_menu',true);
}

$theme_location = 'primary';
if (wp_is_mobile() || has_nav_menu( 'mobile' )) {
	$theme_location = 'mobile';
}

$header_mobile_nav = array('yolo-mobile-header-nav' , 'menu-drop-' . $mobile_header_menu_drop);

$logo_mobile_height = '';
if (isset($yolo_options['logo_mobile_height']) && isset($yolo_options['logo_mobile_height']['height']) && ! empty($yolo_options['logo_mobile_height']['height'])) {
	$logo_mobile_height = $yolo_options['logo_mobile_height']['height'];
	if ($logo_mobile_height == 'px') {
		$logo_mobile_height = '';
	}
}

?>
<header id="yolo-mobile-header" class="<?php echo join(' ', $header_class) ?>">
	<?php if ($mobile_header_layout == 'header-mobile-2'): ?>
		<div class="header-mobile-before">
			<a  href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>">
				<img <?php echo ($logo_mobile_height == '' ? '' : 'style="height:' . esc_attr($logo_mobile_height) .'"') ?> src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" />
			</a>
		</div>
	<?php endif;?>
	<div class="<?php echo join(' ', $header_container_wrapper_class); ?>">
		<div class="container yolo-mobile-header-wrapper">
			<div class="yolo-mobile-header-inner">
				<div class="toggle-icon-wrapper toggle-mobile-menu" data-ref="yolo-nav-mobile-menu" data-drop-type="<?php echo esc_attr($mobile_header_menu_drop); ?>">
					<div class="toggle-icon"> <span></span></div>
				</div>
				<div class="header-customize">
					<?php if ($mobile_header_search_box == '1'): ?>
						<?php yolo_get_template('header/search-button-mobile'); ?>
					<?php endif; ?>
					<?php if (($mobile_header_shopping_cart == '1') && class_exists( 'WooCommerce' )): ?>
						<?php yolo_get_template('header/mini-cart'); ?>
					<?php endif; ?>
				</div>
				<?php if ($mobile_header_layout != 'header-mobile-2'): ?>
					<div class="header-logo-mobile">
						<a  href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>">
							<img <?php echo ($logo_mobile_height == '' ? '' : 'style="height:' . esc_attr($logo_mobile_height) .'"') ?> src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" />
						</a>
					</div>
				<?php endif;?>
			</div>
			<div id="yolo-nav-mobile-menu" class="<?php echo join(' ', $header_mobile_nav) ?>">
				<?php echo apply_filters('yolo_before_menu_mobile_filter',''); ?>
				<?php if (has_nav_menu($theme_location)) : ?>
					<?php
					$args = array(
						'container'      => '',
						'theme_location' => $theme_location,
						'menu_class'     => 'yolo-nav-mobile-menu', // Note: if edit this class must edit in function: replace_walker_to_yolo_mega_menu()
						'walker'         => new Yolo_MegaMenu_Walker()
					);
					if (!empty($page_menu)) {
						$args['menu'] = $page_menu;
					}
					wp_nav_menu( $args );
					?>
				<?php endif; ?>
				<?php echo apply_filters('yolo_after_menu_mobile_filter',''); ?>

			</div>
			<?php if ($mobile_header_menu_drop == 'fly'): ?>
				<div class="yolo-mobile-menu-overlay"></div>
			<?php endif;?>
		</div>
	</div>
</header>
