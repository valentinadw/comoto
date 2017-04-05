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

// Load the conditional logic and assets
require_once get_template_directory() . '/framework/ct_plugins/meta-box/conditional-logic/class-conditional-logic.php';
new Yolo_MB_Conditional_Logic;