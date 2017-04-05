<?php
/**
 *
 *    Plugin Name: Yolo Motor Framework
 *    Plugin URI: http://yolotheme.com
 *    Description: The Yolo Motor Framework plugin.
 *    Version: 1.1.0
 *    Author: YoloTheme
 *    Author URI: http://yolotheme.com
 *
 *    Text Domain: yolo-motor
 *    Domain Path: /languages/
 *
 * @package Yolo Motor Framework
 * @category Core Plugin
 * @author YoloTheme
 *
 **/

if (!defined('ABSPATH')) {
	exit; // Exit if access directly
}
/*================================================
YOLO LIMIT WORDS SHORTCODE
================================================== */


if( ! function_exists('yolo_limit_words_pg') ) {
    function yolo_limit_words_pg($string, $word_limit) {
        $words = preg_split('/\s+/', $string);

        return implode(" ",array_splice($words,0,$word_limit));
    }
}

if( !function_exists('yolo_get_options_pg') ) {
    function yolo_get_options_pg() {
        if ( is_plugin_active('redux-framework/redux-framework.php') ){
            $yolo_options = get_option('yolo_motor_options');
            return $yolo_options;
        }
    }
}
if ( ! class_exists( 'Yolo_MotorFramework' ) ) {
    class Yolo_MotorFramework {
    	protected $loader;

    	protected $prefix;

    	protected $version;

        function __construct() {
        	$this->version = '1.0.0';
        	$this->prefix = 'motor-framework';
        	$this->define_constants();
            $this->include_files();
            $this->define_hook();
        }

        function define_constants() {
        	if( !defined( 'PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR' ) ) {
        		define( 'PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR', plugin_dir_path(__FILE__) );
        	}
            if( !defined( 'PLUGIN_YOLO_MOTOR_FRAMEWORK_URL' ) ) {
                define( 'PLUGIN_YOLO_MOTOR_FRAMEWORK_URL', plugin_dir_url( __FILE__ ) );
            }
            if( !defined( 'PLUGIN_YOLO_MOTOR_FRAMEWORK_FILE' ) ) {
                define( 'PLUGIN_YOLO_MOTOR_FRAMEWORK_FILE', __FILE__ );
            }
        	if( !defined( 'PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME' ) ) {
        		define( 'PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME', 'motor-framework' );
        	}
        	if( !defined( 'YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY' ) ) {
        		define( 'YOLO_MOTOR_FRAMEWORK_SHORTCODE_CATEGORY', esc_html__( 'Motor Shortcodes', 'yolo-motor' ) );
        	}
        }

        function include_files() {
        	require_once( 'includes/yolo_framework_loader.php' );
        	$this->loader = new Yolo_MotorFramework_Loader();

            if ( !class_exists('WPAlchemy_MetaBox') ) {
                include_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/MetaBox.php' );
            }

        	require_once( 'admin/yolo_framework_admin.php' );
            require_once( 'includes/posttypes/posttypes.php' );
            require_once( 'includes/shortcodes/shortcodes.php' );
            require_once( 'includes/widgets/widgets.php' );
            require_once( 'includes/term-meta/index.php' ); // Add term meta to product attributes
            require_once( 'includes/importer/yolo-setup-install.php' );
        }

        public function load_plugin_textdomain() {
            load_plugin_textdomain( 'yolo-motor', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'  );
		}

		private function define_hook() {
			/*set locale*/
			$this->loader->add_action( 'plugins_loaded', $this, 'load_plugin_textdomain' );

			/*admin*/
			$plugin_admin = new Yolo_MotorFramework_Admin( $this->get_prefix(), $this->get_version() );

			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		}

		public function get_version() {
			return $this->version;
		}

		public function get_prefix() {
			return $this->prefix;
		}

		public function run() {
			$this->loader->run();
		}

    }

    // Run Yolo_MotorFramework
    if( !function_exists( 'init_yolo_motor_framework' ) ) {
    	function init_yolo_motor_framework() {
    		$yoloMotorFramework = new Yolo_MotorFramework();
    		$yoloMotorFramework->run();
    	}
    }

    init_yolo_motor_framework();
}

/*================================================
YOLO GET POST META USE FOR PLUGIN
================================================== */
if ( !function_exists( 'yolo_get_post_meta' ) ) {
    function yolo_get_post_meta( $id, $key = "", $single = false ) {

        $GLOBALS['yolo_post_meta'] = isset( $GLOBALS['yolo_post_meta'] ) ? $GLOBALS['yolo_post_meta'] : array();
        if ( ! isset( $id ) ) {
            return;
        }
        if ( ! is_array( $id ) ) {
            if ( ! isset( $GLOBALS['yolo_post_meta'][ $id ] ) ) {
                $GLOBALS['yolo_post_meta'][ $id ] = get_post_meta( $id );
            }
            if ( ! empty( $key ) && isset( $GLOBALS['yolo_post_meta'][ $id ][ $key ] ) && ! empty( $GLOBALS['yolo_post_meta'][ $id ][ $key ] ) ) {
                if ( $single ) {
                    return maybe_unserialize( $GLOBALS['yolo_post_meta'][ $id ][ $key ][0] );
                } else {
                    return array_map( 'maybe_unserialize', $GLOBALS['yolo_post_meta'][ $id ][ $key ] );
                }
            }

            if ( $single ) {
                return '';
            } else {
                return array();
            }

        }

        return get_post_meta( $id, $key, $single );
    }
}