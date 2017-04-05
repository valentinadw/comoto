<?php
/**
 * Theme functions for YOLO Framework.
 * This file include the framework functions, it should remain intact between themes.
 * For theme specified functions, see file functions-<theme name>.php
 *
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
// define( 'YOLO_SCRIPT_DEBUG', true); // use for developer only - delete or comment when finish
// ini_set('xdebug.max_nesting_level', 500); // Fix xdebug Fatal error: Maximum function nesting level of '100' reached, aborting! (need change in php.ini and delete here)

function yolo_enqueue_parent_styles() {

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'yolo_enqueue_parent_styles', 9999 );