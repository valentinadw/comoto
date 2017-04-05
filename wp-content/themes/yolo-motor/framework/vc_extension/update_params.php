<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 ** 
 * Add param to exits shortcode
 * 1. vc_row
 * 2. vc_row_inner
 * 3. vc_column
 */

function yolo_add_vc_param() {
    if (function_exists('vc_add_param')) {
        $add_css_animation = array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('CSS Animation', 'yolo-motor'),
            'param_name'  => 'css_animation',
            'value'       => array(
                esc_html__('No', 'yolo-motor')                   => '', 
                esc_html__('Fade In', 'yolo-motor')              => 'wpb_fadeIn', 
                esc_html__('Fade Top to Bottom', 'yolo-motor')   => 'wpb_fadeInDown', 
                esc_html__('Fade Bottom to Top', 'yolo-motor')   => 'wpb_fadeInUp', 
                esc_html__('Fade Left to Right', 'yolo-motor')   => 'wpb_fadeInLeft', 
                esc_html__('Fade Right to Left', 'yolo-motor')   => 'wpb_fadeInRight', 
                esc_html__('Bounce In', 'yolo-motor')            => 'wpb_bounceIn', 
                esc_html__('Bounce Top to Bottom', 'yolo-motor') => 'wpb_bounceInDown', 
                esc_html__('Bounce Bottom to Top', 'yolo-motor') => 'wpb_bounceInUp', 
                esc_html__('Bounce Left to Right', 'yolo-motor') => 'wpb_bounceInLeft', 
                esc_html__('Bounce Right to Left', 'yolo-motor') => 'wpb_bounceInRight', 
                esc_html__('Zoom In', 'yolo-motor')              => 'wpb_zoomIn', 
                esc_html__('Flip Vertical', 'yolo-motor')        => 'wpb_flipInX', 
                esc_html__('Flip Horizontal', 'yolo-motor')      => 'wpb_flipInY', 
                esc_html__('Bounce', 'yolo-motor')               => 'wpb_bounce', 
                esc_html__('Flash', 'yolo-motor')                => 'wpb_flash', 
                esc_html__('Shake', 'yolo-motor')                => 'wpb_shake', 
                esc_html__('Pulse', 'yolo-motor')                => 'wpb_pulse', 
                esc_html__('Swing', 'yolo-motor')                => 'wpb_swing', 
                esc_html__('Rubber band', 'yolo-motor')          => 'wpb_rubberBand', 
                esc_html__('Wobble', 'yolo-motor')               => 'wpb_wobble', 
                esc_html__('Tada', 'yolo-motor')                 => 'wpb_tada'
            ),
            'description' => esc_html__('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'yolo-motor'),
            'group'       => esc_html__('Yolo Options', 'yolo-motor')
        );

        $add_duration_animation = array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Animation Duration', 'yolo-motor'),
            'param_name'  => 'duration',
            'value'       => '',
            'description' => esc_html__('Duration in seconds. You can use decimal points in the value. Use this field to specify the amount of time the animation plays. <em>The default value depends on the animation, leave blank to use the default.</em>', 'yolo-motor'),
            'dependency'  => Array(
                'element' => 'css_animation', 
                'value'   => array(
                    'wpb_fadeIn', 
                    'wpb_fadeInDown', 
                    'wpb_fadeInUp', 
                    'wpb_fadeInLeft', 
                    'wpb_fadeInRight', 
                    'wpb_bounceIn', 
                    'wpb_bounceInDown', 
                    'wpb_bounceInUp', 
                    'wpb_bounceInLeft', 
                    'wpb_bounceInRight', 
                    'wpb_zoomIn', 
                    'wpb_flipInX', 
                    'wpb_flipInY', 
                    'wpb_bounce', 
                    'wpb_flash', 
                    'wpb_shake', 
                    'wpb_pulse', 
                    'wpb_swing', 
                    'wpb_rubberBand',
                    'wpb_wobble', 
                    'wpb_tada'
                )
            ),
            'group'       => esc_html__('Yolo Options', 'yolo-motor')
        );

        $add_delay_animation = array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Animation Delay', 'yolo-motor'),
            'param_name'  => 'delay',
            'value'       => '',
            'description' => esc_html__('Delay in seconds. You can use decimal points in the value. Use this field to delay the animation for a few seconds, this is helpful if you want to chain different effects one after another above the fold.', 'yolo-motor'),
            'dependency'  => Array(
                'element' => 'css_animation', 
                'value'   => array(
                    'wpb_fadeIn', 
                    'wpb_fadeInDown', 
                    'wpb_fadeInUp', 
                    'wpb_fadeInLeft', 
                    'wpb_fadeInRight', 
                    'wpb_bounceIn', 
                    'wpb_bounceInDown', 
                    'wpb_bounceInUp', 
                    'wpb_bounceInLeft', 
                    'wpb_bounceInRight', 
                    'wpb_zoomIn', 
                    'wpb_flipInX', 
                    'wpb_flipInY', 
                    'wpb_bounce', 
                    'wpb_flash', 
                    'wpb_shake', 
                    'wpb_pulse', 
                    'wpb_swing', 
                    'wpb_rubberBand', 
                    'wpb_wobble', 
                    'wpb_tada'
                )
            ),
            'group'       => esc_html__('Yolo Options', 'yolo-motor')
        );

        $add_params_row = array(
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Layout', 'yolo-motor'),
                'param_name' => 'layout',
                'value'      => array(
                    esc_html__('Container', 'yolo-motor')       => 'boxed',
                    esc_html__('Full Width', 'yolo-motor')      => 'wide',
                    esc_html__('Container Fluid', 'yolo-motor') => 'container-fluid',
                ),
                'group'       => esc_html__('Yolo Options', 'yolo-motor')
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__('Show background overlay', 'yolo-motor'),
                'param_name'  => 'overlay_set',
                'description' => esc_html__('Hide or Show overlay on background images.', 'yolo-motor'),
                'value'       => array(
                    esc_html__('Hide, please', 'yolo-motor')       => 'hide_overlay',
                    esc_html__('Show Overlay Color', 'yolo-motor') => 'show_overlay_color',
                    esc_html__('Show Overlay Image', 'yolo-motor') => 'show_overlay_image',
                ),
                'group'       => esc_html__('Yolo Options', 'yolo-motor')
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__('Image Overlay:', 'yolo-motor'),
                'param_name'  => 'overlay_image',
                'value'       => '',
                'description' => esc_html__('Upload image overlay.', 'yolo-motor'),
                'dependency'  => Array(
                    'element' => 'overlay_set', 
                    'value'   => array('show_overlay_image')
                ),
                'group'       => esc_html__('Yolo Options', 'yolo-motor')
            ),
            array(
                'type'        => 'colorpicker',
                'heading'     => esc_html__('Overlay color', 'yolo-motor'),
                'param_name'  => 'overlay_color',
                'description' => esc_html__('Select color for background overlay.', 'yolo-motor'),
                'value'       => '',
                'dependency'  => Array(
                    'element' => 'overlay_set', 
                    'value'   => array('show_overlay_color')
                ),
                'group'       => esc_html__('Yolo Options', 'yolo-motor')
            ),
            array(
                'type'        => 'number',
                'class'       => '',
                'heading'     => esc_html__('Overlay opacity', 'yolo-motor'),
                'param_name'  => 'overlay_opacity',
                'value'       => '50',
                'min'         => '1',
                'max'         => '100',
                'suffix'      => '%',
                'description' => esc_html__('Select opacity for overlay.', 'yolo-motor'),
                'dependency'  => Array(
                    'element' => 'overlay_set', 
                    'value'   => array('show_overlay_color', 'show_overlay_image')
                ),
                'group'       => esc_html__('Yolo Options', 'yolo-motor')
            ),
            $add_css_animation,
            $add_duration_animation,
            $add_delay_animation,
        );

        $add_params_row_inner = array(
            $add_css_animation,
            $add_duration_animation,
            $add_delay_animation,
        );

        $add_params_column = array(
            $add_css_animation,
            $add_duration_animation,
            $add_delay_animation,
        );

        // 1. Add new parameters for row
        foreach( $add_params_row as $param_row ) {
            vc_add_param('vc_row', $param_row);
        }
        // 2. Add new parameters for row_inner
        foreach( $add_params_row_inner as $param_row_inner ) {
            vc_add_param('vc_row_inner', $param_row_inner);
        }

        // 3. Add new parameters for column
        foreach( $add_params_column as $param_column ) {
            vc_add_param('vc_column', $param_column);
        }
     
    }
}

yolo_add_vc_param();
