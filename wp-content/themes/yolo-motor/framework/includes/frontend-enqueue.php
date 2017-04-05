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

/*================================================
LOAD CSS
================================================== */
if (!function_exists('yolo_javascript_detection')) {
	function yolo_javascript_detection() {
		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
	}
	add_action( 'wp_head', 'yolo_javascript_detection', 0 );
}

if (!function_exists('yolo_enqueue_styles')) {
	function yolo_enqueue_styles() {
		$yolo_options = yolo_get_options();
		$min_suffix = (isset($yolo_options['enable_minifile_css']) && $yolo_options['enable_minifile_css'] == 1) ? '.min' :  '';

		/* Bootstrap */
		$url_bootstrap = get_template_directory_uri() . '/assets/plugins/bootstrap/css/bootstrap.min.css';
		if (isset($yolo_options['cdn_bootstrap_css']) && !empty($yolo_options['cdn_bootstrap_css'])) {
			$url_bootstrap = $yolo_options['cdn_bootstrap_css'];
		}
		wp_enqueue_style('bootstrap', $url_bootstrap, array());

		/* Font-awesome */
		$url_font_awesome = get_template_directory_uri() . '/assets/plugins/fonts-awesome/css/font-awesome.min.css';
		if (isset($yolo_options['cdn_font_awesome']) && !empty($yolo_options['cdn_font_awesome'])) {
			$url_font_awesome = $yolo_options['cdn_font_awesome'];
		}
		wp_enqueue_style('font-awesome', $url_font_awesome, array());
		wp_enqueue_style('font-awesome-animation', get_template_directory_uri() . '/assets/plugins/fonts-awesome/css/font-awesome-animation.min.css', array());

		/* pe-icon-7-stroke */
		wp_enqueue_style('pe-icon-7-stroke', get_template_directory_uri() . '/assets/plugins/pe-icon-7-stroke/css/styles'.$min_suffix.'.css', array());

		/* owl-carousel */
		wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.carousel'.$min_suffix.'.css', array());
		wp_enqueue_style('owl-carousel-theme', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.theme'.$min_suffix.'.css', array());
		wp_enqueue_style('owl-carousel-transitions', get_template_directory_uri() . '/assets/plugins/owl-carousel/owl.transitions'.$min_suffix.'.css', array());

		/* prettyPhoto */
		wp_enqueue_style('prettyPhoto', get_template_directory_uri() . '/assets/plugins/prettyPhoto/css/prettyPhoto'.$min_suffix.'.css', array());
		
		/* Magnific Popup */
		if ( isset($yolo_options['show_popup']) && ($yolo_options['show_popup'] != false )) {
			wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/plugins/magnificPopup/css/magnific-popup'.$min_suffix.'.css', array());
		}

		/* peffect_scrollbar */
		wp_enqueue_style('peffect-scrollbar', get_template_directory_uri() . '/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.min.css', array());
		wp_enqueue_style('scrollbar', get_template_directory_uri() . '/assets/plugins/scrollbar/css/jquery.scrollbar.css', array());

		/* JPlayer */
		wp_enqueue_script( 'jplayer-js', get_template_directory_uri() . '/assets/plugins/jquery.jPlayer/jquery.jplayer.min.js', array( 'jquery' ), '', true );
		wp_enqueue_style( 'jplayer-css', get_template_directory_uri() . '/assets/plugins/jquery.jPlayer/skin/yolo/skin'.$min_suffix.'.css', array(), true );

		/* Theme CSS */
		wp_enqueue_style('yolo-framework-style', get_template_directory_uri() . '/style.css', array(), null);

		/* add url link file custom-style.css  */
		wp_enqueue_style('yolo-custom-style', get_template_directory_uri() . '/assets/css/custom-style.css', array(), null);
			
		/* VC Customize */ 
        wp_enqueue_style('yolo-framework-vc-customize-css', get_template_directory_uri() . '/assets/vc-extend/css/vc-customize'.$min_suffix.'.css');

        /* RTL CSS */
		$enable_rtl_mode = '0';
		if (isset($yolo_options['enable_rtl_mode'])) {
			$enable_rtl_mode =  $yolo_options['enable_rtl_mode'];
		}

		if (is_rtl() || $enable_rtl_mode == '1' || isset($_GET['RTL'])) {
			wp_enqueue_style('yolo-framework-rtl', get_template_directory_uri() . '/assets/css/rtl.css', array(), null);
		}
	}

	add_action('wp_enqueue_scripts', 'yolo_enqueue_styles', 11);
}

/*================================================
LOAD JS
================================================== */
if (!function_exists('yolo_enqueue_script')) {
	function yolo_enqueue_script() {

		$yolo_options = yolo_get_options();
		$min_suffix = (isset($yolo_options['enable_minifile_js']) && $yolo_options['enable_minifile_js'] == 1) ? '.min' :  '';

		/* Bootstrap */
		$url_bootstrap = get_template_directory_uri() . '/assets/plugins/bootstrap/js/bootstrap.min.js';
		if (isset($yolo_options['cdn_bootstrap_js']) && !empty($yolo_options['cdn_bootstrap_js'])) {
			$url_bootstrap = $yolo_options['cdn_bootstrap_js'];
		}
		wp_enqueue_script('bootstrap', $url_bootstrap, array('jquery'), false, true);

		/* Comments */
		if (is_single()) {
			wp_enqueue_script('comment-reply');
		}
		/* Mega menu js */
		wp_enqueue_script( 'yolo-megamenu-js', get_template_directory_uri() . '/framework/core/megamenu/assets/js/megamenu.js' , array(), false, true );

		/* Plugins as sticky, onepage, carousel,... */
		wp_enqueue_script('yolo-framework-plugins', get_template_directory_uri() . '/assets/js/yolo-plugin'.$min_suffix.'.js', array(), false, true);
		
		/* SmoothScroll */
		$user_agent = getenv("HTTP_USER_AGENT");
		if(strpos($user_agent, "Windows") !== FALSE) {
			$os = "Windows";
		}
		if( isset($os) && $os == 'Windows' ) {
			if ( isset($yolo_options['smooth_scroll']) && ($yolo_options['smooth_scroll'] == 1)) {
				wp_enqueue_script('smoothscroll', get_template_directory_uri() . '/assets/plugins/smoothscroll/SmoothScroll' . $min_suffix . '.js', array(), false, true);
			}
		}

		/* Magfinic popup */
		wp_enqueue_script('magnificPopup', get_template_directory_uri() . '/assets/plugins/magnificPopup/js/jquery.magnific-popup'.$min_suffix.'.js', array(), false, true);

		/* Switch-selector */
		if ( isset($yolo_options['switch_selector']) && ($yolo_options['switch_selector'] == 1)) {
			wp_enqueue_script('yolo-framework-switch-selector', get_template_directory_uri() . '/assets/js/yolo-switch-style-selector' . $min_suffix . '.js', array(), false, true);
		}

		/* Shop filters */
		wp_register_script('yolo-shop-filters', get_template_directory_uri() . '/assets/js/yolo-shop-filters' . $min_suffix . '.js', array(), false, true);

		/* Custom add-to-cart-variation */
		wp_enqueue_script( 'wc-add-to-cart-variation' ); // Use this to fix add-to-cart-variation at home page
		wp_enqueue_script('yolo_add_to_cart_variation', get_template_directory_uri() . '/assets/js/yolo-add-to-cart-variation' . $min_suffix . '.js', array(), false, true);

		wp_enqueue_script('yolo-framework-app', get_template_directory_uri() . '/assets/js/yolo-main' . $min_suffix . '.js', array(), false, true);

		wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/assets/plugins/jquery-cookie/jquery.cookie.min.js', array(), false, true);

		/* Localize the script with new data */
		$translation_array = array(
			'product_compare'        => esc_html__( 'Compare', 'yolo-motor' ),
			'product_wishList'       => esc_html__( 'WishList', 'yolo-motor' ),
			'product_wishList_added' => esc_html__( 'Browse WishList', 'yolo-motor' ),
			'product_quickview'      => esc_html__( 'Quick View', 'yolo-motor' ),
			'product_addtocart'      => esc_html__( 'Add To Cart', 'yolo-motor' )
		);
		wp_localize_script('yolo-framework-app', 'yolo_framework_constant', $translation_array);

		wp_localize_script('yolo-framework-app', 'yolo_framework_ajax_url', get_site_url() . '/wp-admin/admin-ajax.php?activate-multi=true');
		wp_localize_script('yolo-framework-app', 'yolo_framework_theme_url', get_template_directory_uri());
		wp_localize_script('yolo-framework-app', 'yolo_framework_site_url', site_url());
		
	}

	add_action('wp_enqueue_scripts', 'yolo_enqueue_script');
}

/* CUSTOM CSS OUTPUT
	================================================== */
if(!function_exists('yolo_enqueue_custom_css')){
    function yolo_enqueue_custom_css() {
        $yolo_options = yolo_get_options();

        $custom_css = $yolo_options['custom_css'];
        if ( $custom_css ) {
	        echo '<style id="yolo_custom_style" type="text/css"></style>';
            echo sprintf('<style type="text/css">%s %s</style>',"\n",$custom_css);
        }
    }
    add_action( 'wp_head', 'yolo_enqueue_custom_css' );
}

/* CUSTOM JS OUTPUT
	================================================== */
if(!function_exists('yolo_enqueue_custom_script')) {
    function yolo_enqueue_custom_script() {
        $yolo_options = yolo_get_options();

        $custom_js = $yolo_options['custom_js'];
        if ( $custom_js ) {
            echo sprintf('<script type="text/javascript">%s</script>',$custom_js);
        }
    }
    add_action( 'wp_footer', 'yolo_enqueue_custom_script' );
}
