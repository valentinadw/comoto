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
 
/*---------------------------------------------------
/* YOLO COMMENT FIELDS
/*---------------------------------------------------*/
if (!function_exists('yolo_comment_fields')) {
    function yolo_comment_fields($fields) {
		$commenter = wp_get_current_commenter();
		$req       = get_option('require_name_email');
		$aria_req  = ($req ? " aria-required='true'" : '');
		$html5     = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';

        $fields = array(
            'author' => '<div class="form-group col-md-12">' .
                '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" placeholder="'.esc_html__('Name*','yolo-motor').'" ' . $aria_req . '>' .
                '</div>',
            'email' => '<div class="form-group col-md-12">' .
                '<input id="email" name="email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="'.esc_html__('Email*','yolo-motor').'" ' . $aria_req . '>' .
                '</div>'
        );

        return $fields;
    }
    add_filter('yolo_comment_fields','yolo_comment_fields');
}

/*---------------------------------------------------
/* COMMENT FORMS ARGS
/*---------------------------------------------------*/
if (!function_exists('yolo_comment_form_args')) {
    function yolo_comment_form_args($comment_form_args) {
		$commenter = wp_get_current_commenter();
		$req       = get_option('require_name_email');
		$aria_req  = ($req ? " aria-required='true'" : '');
		$html5     = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';

        $comment_form_args['comment_field'] = '<div class="form-group col-md-12">' .
            '<textarea rows="6" id="comment" name="comment"  placeholder="'.esc_html__('Message*','yolo-motor') .'" '. $aria_req .'></textarea>' .
            '</div>';

        $comment_form_args['class_submit'] = 'motor-button style1 button-2x';
        $comment_form_args['label_submit'] = esc_html__('Send us now', 'yolo-motor');
        return $comment_form_args;
    }
    add_filter('yolo_comment_form_args','yolo_comment_form_args');
}

/*---------------------------------------------------
/* SET ONE PAGE MENU
/*---------------------------------------------------*/
if (!function_exists('yolo_main_menu_one_page_filter')) {
	function yolo_main_menu_one_page_filter($args) {
		if (isset($args['theme_location']) && ($args['theme_location'] != 'primary') && ($args['theme_location'] != 'mobile')) {
			return $args;
		}
		$prefix      = 'yolo_';
		$is_one_page = get_post_meta(get_the_ID(),$prefix . 'is_one_page',true);
		if ($is_one_page == '1') {
			$args['menu_class'] .= ' menu-one-page';
		}
		return $args;
	}
	add_filter('wp_nav_menu_args','yolo_main_menu_one_page_filter', 20);
}

/*---------------------------------------------------
/* HEADER CUSTOMIZE
/*---------------------------------------------------*/
if (!function_exists('yolo_header_customize_filter')) {
	add_filter('yolo_header_customize_filter','yolo_header_customize_filter');
	function yolo_header_customize_filter($args) {
		// global $yolo_header_layout;
		$yolo_header_layout = yolo_get_header_layout();
		$yolo_options = yolo_get_options();

		$prefix = 'yolo_';

		$enable_header_customize = get_post_meta(get_the_ID(),$prefix . 'header_customize',true);

		$header_customize = array();
		if ($enable_header_customize == '1') {
			$page_header_customize = get_post_meta(get_the_ID(),$prefix . 'header_customize',true);
			if (isset($page_header_customize['enable']) && !empty($page_header_customize['enable'])) {
				$header_customize = explode('||', $page_header_customize['enable']);
			}
		}
		else {
			if (isset($yolo_options['header_customize']) && isset($yolo_options['header_customize']['enabled']) && is_array($yolo_options['header_customize']['enabled'])) {
				foreach ($yolo_options['header_customize']['enabled'] as $key => $value) {
					$header_customize[] = $key;
				}
			}
		}
		$header_customize_class = array('header-customize');

		ob_start();
		if (count($header_customize) > 0) {
			?>
			<div class="<?php echo join(' ', $header_customize_class) ?>">
				<?php foreach ($header_customize as $key){
					switch ($key) {
						case 'search':
							yolo_get_template('header/search-button');
							break;
						case 'shopping-cart':
							if (class_exists( 'WooCommerce' )) {
								yolo_get_template('header/mini-cart');
							}
							break;
						case 'social-profile':
							yolo_get_template('header/social-profile');
							break;
						case 'custom-text':
							yolo_get_template('header/custom-text');
							break;
					}
				} ?>
			</div>
		<?php
		}

		return ob_get_clean();
	}
}

/*---------------------------------------------------
/* THEME URL REWRITE (FOR DEV)
/*---------------------------------------------------*/
if (!function_exists('yolo_less_css_url_rewrite')) {
	function yolo_less_css_url_rewrite() {
		add_rewrite_rule( 'wp-content/themes/motor/yolo-less-css', 'index.php', 'top' );
		flush_rewrite_rules();
	}
	add_action( 'init', 'yolo_less_css_url_rewrite');
}
function add_query_vars_filter( $vars ){
	$vars[] = "yolo-custom-page";
	return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

/*---------------------------------------------------
/* ADD SEARCH FORM TO BEFORE MEGA-MENU
/*---------------------------------------------------*/
if (!function_exists('yolo_search_form_before_menu_mobile')) {
	function yolo_search_form_before_menu_mobile($params) {
		ob_start();
		?>
		<form class="yolo-search-form-mobile-menu"  method="get" action="<?php echo esc_url(site_url()); ?>">
			<input type="text" name="s" placeholder="<?php esc_html_e('Search...','yolo-motor'); ?>">
			<button type="submit"><i class="fa fa-search"></i></button>
		</form>
		<?php
		$params .= ob_get_clean();

		return $params;
	}
	add_filter('yolo_before_menu_mobile_filter','yolo_search_form_before_menu_mobile', 10);
}

/* STICKY LOGO */ 
if (!function_exists('yolo_sticky_logo')) {
	function yolo_sticky_logo($agrs){
		// global $yolo_header_layout;
		$yolo_header_layout = yolo_get_header_layout();
		$yolo_options = yolo_get_options();
		if (in_array($yolo_header_layout, array('header-7','header-8'))) { // logo in navigation
			return $agrs;
		}

		$prefix = 'yolo_';

		$logo_sticky_meta_id = get_post_meta(get_the_ID(),$prefix . 'sticky_logo',true);
		$logo_sticky_meta = get_post_meta(get_the_ID(),$prefix . 'sticky_logo', true);

		$logo_sticky = '';
		if ($logo_sticky_meta !== array() && isset($logo_sticky_meta[$logo_sticky_meta_id]) && isset($logo_sticky_meta[$logo_sticky_meta_id]['full_url'])) {
			$logo_sticky = $logo_sticky_meta[$logo_sticky_meta_id]['full_url'];
		}
		if (empty($logo_sticky)) {
			if (isset($yolo_options['sticky_logo']) && isset($yolo_options['sticky_logo']['url'])) {
				$logo_sticky = $yolo_options['sticky_logo']['url'];
			}
			else if (isset($yolo_options['logo']) && isset($yolo_options['logo']['url'])) {
				$logo_sticky = $yolo_options['logo']['url'];
			}
		}

		if (!empty($logo_sticky)) {
			ob_start();
			?>
				<li class="logo-sticky">
					<a  href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>">
						<img src="<?php echo esc_url($logo_sticky); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" />
					</a>
				</li>
			<?php

			$agrs .= ob_get_clean();
		}

		return $agrs;
	}
	add_filter('megamenu_primary_filter_before', 'yolo_sticky_logo');
}