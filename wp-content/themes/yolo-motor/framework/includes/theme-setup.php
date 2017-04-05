<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    21/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if (!function_exists('yolo_theme_setup')) {
    function yolo_theme_setup() {
    	require_once get_template_directory().'/framework/includes/yolo-dash/yolo-setup-install.php';
    	require_once get_template_directory().'/framework/includes/yolo-dash/yolo-check-version.php';
    	if ( is_admin() ) {     
            $license_manager = new Yolo_Check_Version(
                'yolo-motor',
                'Yolo Motor',
                'http://update.yolotheme.com/api/license-manager/v1',
                'theme',
                '',
                false
            );
        }
        if ( ! isset( $content_width ) ) $content_width = 1170;

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Declare WooCommerce support
        add_theme_support( 'woocommerce' );

        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'yolo-motor' ),
			'mobile'  => esc_html__( 'Mobile Menu', 'yolo-motor' ),
        ) );

        // Enable support for Post Formats.
        add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio', 'quote', 'link', 'aside' ) );

        global $wp_version;

        if (version_compare($wp_version,'4.1','>=')){
            add_theme_support( "title-tag" );
        }

        if ( version_compare( $wp_version, '3.4', '>=' ) ) {
            add_theme_support( "custom-header");
            add_theme_support( "custom-background");
        }

        // Enable support for HTML5 markup.
        add_theme_support( 'html5', array(
            'comment-list',
            'search-form',
            'comment-form',
            'gallery',
        ) );

        $language_path = get_template_directory() . '/languages';
        load_theme_textdomain( 'yolo-motor', $language_path );

	    add_editor_style( array( '/assets/css/editor-style.css' ));
    }
    add_action( 'after_setup_theme', 'yolo_theme_setup');
}

// SET SESSION START
if (!function_exists('yolo_start_session')) {
    function yolo_start_session() {
        if(!isset($_SESSION)) {
            session_start();
        }
    }
    add_action('init', 'yolo_start_session', 1);
}

// if (!function_exists('yolo_theme_activation')) {
//     function yolo_theme_activation () {
//         // set frontpage to display_posts
//         update_option('show_on_front', 'posts');

//         // flush rewrite rules
//         flush_rewrite_rules();

//         do_action('yolo_theme_activation');

//         if(class_exists('TGM_Plugin_Activation')){
// 			$tgmpa                       = TGM_Plugin_Activation::$instance;
// 			$is_redirect_require_install = false;
//             foreach($tgmpa->plugins as $p){
//                 $path =  ABSPATH . 'wp-content/plugins/'.$p['slug'];
//                 if(!is_dir($path)){
//                     $is_redirect_require_install = true;
//                     break;
//                 }
//             }
//             if($is_redirect_require_install)
//                 header( 'Location: '.admin_url().'themes.php?page=install-required-plugins' ) ;
//         }
//     }
//     add_action('after_switch_theme', 'yolo_theme_activation');
// }

// Add to the allowed tags array and hook into WP comments
if (!function_exists('yolo_allowed_tags')) {
	function yolo_allowed_tags() {
		global $allowedposttags;

		$allowedposttags['a']['href']             	   = true;
		$allowedposttags['a']['title']                 = true;
		$allowedposttags['a']['data-quantity']         = true;
		$allowedposttags['a']['data-product_sku']      = true;
		$allowedposttags['a']['rel']                   = true;
		$allowedposttags['a']['data-rel']              = true;
		$allowedposttags['a']['data-product-type']     = true;
		$allowedposttags['a']['data-product-id']       = true;
		$allowedposttags['a']['data-toggle']           = true;
		$allowedposttags['div']['data-plugin-options'] = true;
		$allowedposttags['div']['class']         	   = true;
		$allowedposttags['div']['style']               = true;
		$allowedposttags['div']['data-title']          = true;
		$allowedposttags['textarea']['placeholder']    = true;

		$allowedposttags['h1']['class']    = true;
		$allowedposttags['h1']['style']    = true;
		$allowedposttags['h2']['class']    = true;
		$allowedposttags['h2']['style']    = true;
		$allowedposttags['h3']['class']    = true;
		$allowedposttags['h3']['style']    = true;
		$allowedposttags['h4']['class']    = true;
		$allowedposttags['h4']['style']    = true;
		$allowedposttags['h5']['class']    = true;
		$allowedposttags['h5']['style']    = true;

		$allowedposttags['p']['class']    	= true;
		$allowedposttags['p']['style']    	= true;
		$allowedposttags['span']['class']   = true;
		$allowedposttags['span']['style']   = true;
		$allowedposttags['strong']['class'] = true;
		$allowedposttags['strong']['style'] = true;
		$allowedposttags['b']['class']    	= true;
		$allowedposttags['b']['style']    	= true;
		$allowedposttags['i']['class']    	= true;
		$allowedposttags['i']['style']    	= true;
		$allowedposttags['ul']['class']    	= true;
		$allowedposttags['ul']['style']    	= true;
		$allowedposttags['li']['class']    	= true;
		$allowedposttags['li']['style']    	= true;
		$allowedposttags['img']['class']    = true;
		$allowedposttags['img']['style']    = true;
		$allowedposttags['img']['src']    	= true;
		$allowedposttags['img']['alt']    	= true;
		
		$allowedposttags['iframe']['align']            = true;
		$allowedposttags['iframe']['frameborder']      = true;
		$allowedposttags['iframe']['height']           = true;
		$allowedposttags['iframe']['longdesc']         = true;
		$allowedposttags['iframe']['marginheight']     = true;
		$allowedposttags['iframe']['marginwidth']      = true;
		$allowedposttags['iframe']['name']             = true;
		$allowedposttags['iframe']['sandbox']          = true;
		$allowedposttags['iframe']['scrolling']        = true;
		$allowedposttags['iframe']['seamless']         = true;
		$allowedposttags['iframe']['src']              = true;
		$allowedposttags['iframe']['srcdoc']           = true;
		$allowedposttags['iframe']['width']            = true;
		$allowedposttags['iframe']['defer']            = true;
		
		$allowedposttags['input']['accept']            = true;
		$allowedposttags['input']['align']             = true;
		$allowedposttags['input']['alt']               = true;
		$allowedposttags['input']['autocomplete']      = true;
		$allowedposttags['input']['autofocus']         = true;
		$allowedposttags['input']['checked']           = true;
		$allowedposttags['input']['class']             = true;
		$allowedposttags['input']['disabled']          = true;
		$allowedposttags['input']['form']              = true;
		$allowedposttags['input']['formaction']        = true;
		$allowedposttags['input']['formenctype']       = true;
		$allowedposttags['input']['formmethod']        = true;
		$allowedposttags['input']['formnovalidate']    = true;
		$allowedposttags['input']['formtarget']        = true;
		$allowedposttags['input']['height']            = true;
		$allowedposttags['input']['list']              = true;
		$allowedposttags['input']['max']               = true;
		$allowedposttags['input']['maxlength']         = true;
		$allowedposttags['input']['min']               = true;
		$allowedposttags['input']['multiple']          = true;
		$allowedposttags['input']['name']              = true;
		$allowedposttags['input']['pattern']           = true;
		$allowedposttags['input']['placeholder']       = true;
		$allowedposttags['input']['readonly']          = true;
		$allowedposttags['input']['required']          = true;
		$allowedposttags['input']['size']              = true;
		$allowedposttags['input']['src']               = true;
		$allowedposttags['input']['step']              = true;
		$allowedposttags['input']['type']              = true;
		$allowedposttags['input']['value']             = true;
		$allowedposttags['input']['width']             = true;
		$allowedposttags['input']['accesskey']         = true;
		$allowedposttags['input']['class']             = true;
		$allowedposttags['input']['contenteditable']   = true;
		$allowedposttags['input']['contextmenu']       = true;
		$allowedposttags['input']['dir']               = true;
		$allowedposttags['input']['draggable']         = true;
		$allowedposttags['input']['dropzone']          = true;
		$allowedposttags['input']['hidden']            = true;
		$allowedposttags['input']['id']                = true;
		$allowedposttags['input']['lang']              = true;
		$allowedposttags['input']['spellcheck']        = true;
		$allowedposttags['input']['style']             = true;
		$allowedposttags['input']['tabindex']          = true;
		$allowedposttags['input']['title']             = true;
		$allowedposttags['input']['translate']         = true;
		
		$allowedposttags['span']['data-id']            = true;

	}
	add_action('init', 'yolo_allowed_tags', 10);
}

