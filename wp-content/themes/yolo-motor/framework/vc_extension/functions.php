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

/* Required functions for VC */
add_action( 'vc_before_init', 'yolo_vcSetAsTheme' );
function yolo_vcSetAsTheme() {
    vc_set_as_theme();
}

// function yolo_remove_frontend_links() {
//     vc_disable_frontend();
// }

// add_action( 'vc_after_init', 'yolo_remove_frontend_links' );

// Set new directory for vc templates
vc_set_shortcodes_templates_dir( get_template_directory() . '/framework/vc_extension/templates');

/* Functions for display at front-end */
function yolo_get_css_animation( $css_animation ) {
    $output = '';
    if ($css_animation != '') {
        wp_enqueue_script('waypoints');
        $output = ' wpb_animate_when_almost_visible yolo-css-animation ' . $css_animation;
    }
    return $output;
}

function yolo_get_style_animation( $duration, $delay ) {
    $styles = array();
    if ( $duration != '0' && !empty($duration) ) {
        $duration = (float)trim($duration, "\n\ts");
        $styles[] = "-webkit-animation-duration: {$duration}s";
        $styles[] = "-moz-animation-duration: {$duration}s";
        $styles[] = "-ms-animation-duration: {$duration}s";
        $styles[] = "-o-animation-duration: {$duration}s";
        $styles[] = "animation-duration: {$duration}s";
    }
    if ( $delay != '0' && !empty($delay) ) {
        $delay = (float)trim($delay, "\n\ts");
        $styles[] = "opacity: 0";
        $styles[] = "-webkit-animation-delay: {$delay}s";
        $styles[] = "-moz-animation-delay: {$delay}s";
        $styles[] = "-ms-animation-delay: {$delay}s";
        $styles[] = "-o-animation-delay: {$delay}s";
        $styles[] = "animation-delay: {$delay}s";
    }
    if ( count($styles) > 1 ) {
        return 'style="' . implode(';', $styles) . '"';
    }
    return implode(';', $styles);
}

function yolo_convert_hex_to_rgba( $hex, $opacity = 1 ) {
    $hex = str_replace("#", "", $hex);
    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    $rgba = 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $opacity . ')';
    return $rgba;
}