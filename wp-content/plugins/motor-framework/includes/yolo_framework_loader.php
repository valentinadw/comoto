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

if (!class_exists('Yolo_MotorFramework_Loader')) {
	class Yolo_MotorFramework_Loader {

		/**
		 * The array of actions registered with WordPress.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
		 */
		protected $actions;

		/**
		 * The array of filters registered with WordPress.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
		 */
		protected $filters;

		/**
		 * Initialize the collections used to maintain the actions and filters.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			$this->actions = array();
			$this->filters = array();
		}

		public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
			$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
		}

		public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
			$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
		}

		private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

			$hooks[] = array(
				'hook'          => $hook,
				'component'     => $component,
				'callback'      => $callback,
				'priority'      => $priority,
				'accepted_args' => $accepted_args
			);

			return $hooks;
		}

		public function run() {
			foreach ( $this->filters as $hook ) {
				add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
			}

			foreach ( $this->actions as $hook ) {
				add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
			}
		}
	}
}