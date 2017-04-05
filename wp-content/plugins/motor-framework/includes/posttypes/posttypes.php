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

if( ! class_exists( 'Yolo_MotorFramework_Posttypes' ) ) {
	class Yolo_MotorFramework_Posttypes {
		static $instance;

		public static function init() {
			if( !isset(self::$instance) ) {
				self::$instance = new Yolo_MotorFramework_Posttypes;
				add_action( 'init', array(self::$instance, 'includes'), 0 );
			}

			return self::$instance;
		}

		public function includes() {
			require_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/posttypes/footer.php');
			require_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/posttypes/teammember.php');
			require_once( PLUGIN_YOLO_MOTOR_FRAMEWORK_DIR . 'includes/posttypes/testimonial.php');
		}
	}

	if ( ! function_exists('init_yolo_motor_framework_posttypes') ) {
        function init_yolo_motor_framework_posttypes() {
            return Yolo_MotorFramework_Posttypes::init();
        }

        init_yolo_motor_framework_posttypes();
    }
}
