<?php
/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/

class Yolo_MegaMenu_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		// Menu item animate
		$yolo_options = yolo_get_options();
		
    	$sub_menu_animate = 'animated ' . $yolo_options['menu_animation'];

		$indent = str_repeat("\t", $depth);
		// Don't animate on mobile menu
    	if (property_exists( $args, 'is_mobile_menu' ) && $args->is_mobile_menu == true) {
			$output .= "\n$indent<ul class=\"sub-menu\">\n";
		} else {
			$output .= "\n$indent<ul class=\"sub-menu " . $sub_menu_animate . "\">\n";
		}
	}

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    
       	global $wp_query;
		$indent      = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$heading     = '';
		$widget      = '';
		$class_names = $value = '';

       	$classes = empty( $item->classes ) ? array() : (array) $item->classes;	   
		      
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );

		$megamenu = ! empty( $item->megamenu ) ? 'yolo-menu yolo_megamenu' : 'yolo-menu';

		// Sub menu style
		if( ! empty( $item->megamenu ) ) {
			if ( isset($item->megamenu_style) && !empty($item->megamenu_style) ) {
				$sub_menu_style = $item->megamenu_style;
			}

			if( $sub_menu_style == 'menu_style_column' || $sub_menu_style == 'menu_style_tab' ) {
				$sub_menu_style .= ' mega-col-'. esc_attr( $item->megamenu_col );
				if( ! empty( $item->megamenu_width ) ) {
					$sub_menu_style .= ' mega-fullwidth';
				}
			}	
		} else {
			$sub_menu_style = 'menu_style_dropdown';
		}
		
		// if( $depth != 1 ) {
		// 	$sub_menu_style = '';
		// } else {
		// 	$sub_menu_style = $sub_menu_style;
		// }
		if( $item->megamenu_background_image != '' ) {
			$this->add_menu_style($item->ID, $item->megamenu_background_image);
		}
	   
		if( !empty ( $item->megamenu_heading ) ) {
           $heading = 'yolo_heading';
		}

		// Process menu-mobile-id
		$menu_id_prefix = '';
		if (property_exists( $args, 'is_mobile_menu' ) && $args->is_mobile_menu == true) {
			$menu_id_prefix = 'mobile-';
		}
		$menu_depth = "level-" . $depth;

	   	if( $item->megamenu_widgetarea && is_active_sidebar( $item->megamenu_widgetarea ))
		   $widget = 'yolo_widget_area';
		
		$class_names = ' class="'. $megamenu .' ' . $sub_menu_style .' '. $heading .' '. $widget .' '. esc_attr( $class_names ) .' '. $menu_depth .' "';

        $output .= $indent . '<li id="menu-item-'. $menu_id_prefix . $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$prepend     = '';
		$append      = '';
		$description = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

		if( $depth != 0 ) {
			$description = $append = $prepend = "";
		}
		// Set tag style default empty
		$style = "";

		// Megamenu icon
		if ( !empty ( $item->megamenu_icon_color ) ) {
			$style .= "color: {$item->megamenu_icon_color};";
		}
		
		// Check size icon
		if ( !empty ( $item->megamenu_icon_size ) ) 
			$style .= "font-size: {$item->megamenu_icon_size}px;";
		
		// Check alignment icon
		$icon_class = "";
		if ( !empty ( $item->megamenu_icon_alignment ) ) 
			$icon_class .= $item->megamenu_icon_alignment;

		// Megamenu icon
		if( !empty ( $item->megamenu_icon ) ) {
			$prepend .= '<i class="fa ' . esc_attr( $item->megamenu_icon ). " " . $icon_class .'" style="' . $style . '"></i>';
		}
		
		// Megamenu sub label
		if( !empty ( $item->megamenu_sublabel ) ) {
			$prepend .= '<span class="yolo_sub_label ' . esc_attr( $item->megamenu_sublabel ) .'" style="background: ' . $item->megamenu_sublabel_color . '">' . $item->megamenu_sublabel . '</span>';
		}

		// Set default
		$item_output = '';	

		// ---
	   	if( $item->megamenu_widgetarea && is_active_sidebar( $item->megamenu_widgetarea ) ) :
	   		// Add this only for tab style
	   		if( isset($args->before) ) :
        	    $item_output = $args->before; 
	   		endif;
        	
        	$item_output .= '<a'. $attributes .'>';
			
			if( isset($args->link_before) ) {
        		$item_output .= $args->link_before. apply_filters( 'the_title', $item->title, $item->ID ). $prepend . $append;
			}

			if( isset($args->link_after) ) {
        		$item_output .= $description.$args->link_after;
	  		}
	   				
        	$item_output .= '</a>';

        	// With widget don't have caret :)

	   		if( isset($args->before) ) {
        		$item_output .= $args->after;
	   		}
	   		// End add for tab style

			$item_output .= '<div class="yolo_megamenu_widget_area '. $item->megamenu_col_tab .'">';
			ob_start();
				dynamic_sidebar( $item->megamenu_widgetarea );
			$item_output .= ob_get_clean() . '</div>';
		else :
   
	   		if( isset($args->before) ) {
        	    $item_output = $args->before; 
	   		}
        	
        	$item_output .= '<a'. $attributes .'>';
			
			if( isset($args->link_before) ) {
        		$item_output .= $args->link_before. apply_filters( 'the_title', $item->title, $item->ID ). $prepend . $append;
			}

			if( isset($args->link_after) ) {
        		$item_output .= $description.$args->link_after;
	  		}
	   				
        	$item_output .= '</a>';

        	// Add caret click on mobile
			if( $args->walker->has_children ) {
				$item_output .= '<b class="menu-caret"></b>';
			}

	   		if( isset($args->before) ) {
        		$item_output .= $args->after;
	   		}
	   
		endif;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
    }

    public function add_menu_style($id, $background) {
	    // background image
		$yolo_options = yolo_get_options();
		$enable_rtl_mode =  $yolo_options['enable_rtl_mode'];
		if (is_rtl() || $enable_rtl_mode == '1' || isset($_GET['RTL'])) {
			$style_background = '<style type=\"text/css\" scoped>' . '#menu-item-'. $id  .' > .sub-menu { background-image: url('. $background . '); background-position: 0% 50%; background-repeat: no-repeat;}' . '</style>';	
		}else{
			$style_background = '<style type=\"text/css\" scoped>' . '#menu-item-'. $id  .' > .sub-menu { background-image: url('. $background . '); background-position: 100% 100%; background-repeat: no-repeat;}' . '</style>';
		}		

		echo '<script>jQuery(document).ready(function($){
			$("head").append("'. $style_background .'");
		});</script>';
	}
	
}