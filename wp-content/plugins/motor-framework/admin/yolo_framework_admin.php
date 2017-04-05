<?php
/**
 *  
 * @package    YoloTheme/Yolo Motor
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if (!class_exists('Yolo_MotorFramework_Admin')) {
	class Yolo_MotorFramework_Admin {

		private $prefix;

		private $version;

		public function __construct( $prefix, $version ) {
			$this->prefix  = $prefix;
			$this->version = $version;
		}

		/**
		 * Register the stylesheets for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles() {

            $pages = isset($_GET['page']) ? $_GET['page'] : '';
            if ($pages == '_options') return;

			wp_enqueue_style( $this->prefix.'-admin', plugins_url( PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME.'/admin/assets/css/admin.css'), array(), $this->version, 'all' );
			wp_enqueue_style( $this->prefix.'-select2', plugins_url( PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME.'/admin/assets/plugins/jquery.select2/select2.css'), array(), $this->version, 'all' );
			wp_enqueue_style( 'datetimepicker', plugins_url( PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME.'/admin/assets/plugins/datetimepicker/jquery.datetimepicker.css'), array(), $this->version, 'all' );
		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( $this->prefix .'-admin', plugins_url( PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME.'/admin/assets/js/admin.js'), array( 'jquery' ), $this->version, false );

			wp_enqueue_script( 'select2', plugins_url( PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME.'/admin/assets/plugins/jquery.select2/select2.min.js'), array( 'jquery' ), $this->version, false );
			
			wp_enqueue_script( 'datetimepicker', plugins_url( PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME.'/admin/assets/plugins/datetimepicker/jquery.datetimepicker.js'), array( 'jquery' ), $this->version, false );

			wp_localize_script( $this->prefix .'admin' , 'yolo_framework_meta' , array(
				'ajax_url' => admin_url( 'admin-ajax.php?activate-multi=true' )
			) );
		}

	}
}