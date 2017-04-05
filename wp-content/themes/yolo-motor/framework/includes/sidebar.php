<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 *   Purpose: Register sidebar and custom sidebar via AJAX
 *   Files: theme-functions.php, yolo_sidebar.js, admin_style.css
*/
if (!function_exists('yolo_register_sidebar')) {
    function yolo_register_sidebar() {
        register_sidebar( 
            array(
                'name'          => esc_html__( "Sidebar 1",'yolo-motor' ),
                'id'            => 'sidebar-1',
                'description'   => esc_html__( "Widget Area 1",'yolo-motor' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( "Sidebar 2",'yolo-motor' ),
                'id'            => 'sidebar-2',
                'description'   => esc_html__( "Widget Area 2",'yolo-motor' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ) 
        );
	    register_sidebar( 
            array(
    		    'name'          => esc_html__( "Top Bar Left",'yolo-motor' ),
    		    'id'            => 'top_bar_left',
    		    'description'   => esc_html__( "Top Bar Left",'yolo-motor' ),
    		    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		    'after_widget'  => '</aside>',
    		    'before_title'  => '<h4 class="widget-title"><span>',
    		    'after_title'   => '</span></h4>',
    	    ) 
        );
	    register_sidebar( 
            array(
    		    'name'          => esc_html__( "Top Bar Right",'yolo-motor' ),
    		    'id'            => 'top_bar_right',
    		    'description'   => esc_html__( "Top Bar Right",'yolo-motor' ),
    		    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		    'after_widget'  => '</aside>',
    		    'before_title'  => '<h4 class="widget-title"><span>',
    		    'after_title'   => '</span></h4>',
    	    ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( "Woocommerce",'yolo-motor' ),
                'id'            => 'woocommerce',
                'description'   => esc_html__( "Woocommerce",'yolo-motor' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( "Woocommerce Shop Filter",'yolo-motor' ),
                'id'            => 'woocommerce_filter',
                'description'   => esc_html__( "Woocommerce Shop filter",'yolo-motor' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ) 
        );
        register_sidebar(
            array(
                'name'          => esc_html__("Off Canvas Menu",'yolo-motor'),
                'id'            => 'canvas-menu',
                'description'   => esc_html__("Canvas Menu Widget Area",'yolo-motor'),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ) 
        );

        // Add custom sidebar using ajax
        $custom_sidebars = yolo_get_custom_sidebars();
        if( is_array($custom_sidebars) && !empty($custom_sidebars) ){
            foreach( $custom_sidebars as $name ){
                $yolo_custom_sidebars[] = array(
                                    'name'          => ''.$name.'',
                                    'id'            => sanitize_title($name),
                                    'description'   => '',
                                    'class'         => 'yolo-custom-sidebar',
                                    'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
                                    'after_widget'  => '</section>',
                                    'before_title'  => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
                                    'after_title'   => '</h3></div>',
                                );
            }
            foreach( $yolo_custom_sidebars as $custom_sidebar ) {
                register_sidebar($custom_sidebar);
            }
        }

    }
    add_action( 'widgets_init', 'yolo_register_sidebar' );
}
