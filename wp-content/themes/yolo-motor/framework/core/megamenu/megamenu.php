<?php
/*
Plugin Name: MegaMenu - The Ultimate WordPress Mega Menu
Plugin URI: http://www.yolotheme.com
Description: Easily create beautiful, flexible, responsive mega menus
Author: YoloTheme
Author URI: http://www.yolotheme.com
Version: 1.0.0.0
*/

// See the tutorial from here: http://www.wpexplorer.com/adding-custom-attributes-to-wordpress-menus/
class Yolo_Mega_Menu {
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {

		// Load enqueue script Yolo Mega Menu
		add_action( 'admin_enqueue_scripts', array( $this, 'yolo_mega_menu_enqueue_script_admin' ) ); // back-end
		add_action( 'wp_enqueue_scripts', array( $this, 'yolo_mega_menu_enqueue_script' ) ); // front-end
		
		// add custom menu fields to menu
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'yolo_mega_memu_setup_item' ) );

		// save menu custom fields
		add_action( 'wp_update_nav_menu_item', array( $this, 'yolo_mega_menu_save_fields' ), 10, 3 );

		// Edit menu walker to show form
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'yolo_mega_menu_edit_walker' ), 10, 2 );

		// Edit menu argument (process menu mobile)
		add_filter( 'wp_nav_menu_args', array($this, 'replace_walker_to_yolo_mega_menu') );

		// Save menu and build css
		// add_action( 'wp_update_nav_menu', array( $this, 'megamenu_generate_css_file' ) ); // @TODO: use in future

	}

	/**
	 * Enqueue script for Yolo Mega Menu
	 * @access public
	 * @since  1.0
	 * @name yolo_mega_menu_enqueue_script
	 */
	public function yolo_mega_menu_enqueue_script_admin( $hook ) {

		if ( $hook != 'nav-menus.php' ) {
			return;
		}

		// Enqueue style for Mega Menu admin
		wp_register_style( 'yolo-megamenu-admin', get_template_directory_uri() . '/framework/core/megamenu/assets/css/megamenu-admin.css' );
		wp_enqueue_style( 'yolo-megamenu-admin' );

		wp_register_script( 'yolo-megamenu-admin-js', get_template_directory_uri() . '/framework/core/megamenu/assets/js/megamenu-admin.js', array( 'wp-color-picker' ), false, true );
		wp_enqueue_script( 'yolo-megamenu-admin-js' );

		// Use this for select image from library
		wp_register_script( 'yolo-megamenu-media-init-js', get_template_directory_uri() . '/framework/core/megamenu/assets/js/media-init.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'yolo-megamenu-media-init-js' );

		wp_register_style( 'yolo-megamenu-awesome', get_template_directory_uri() . '/assets/plugins/fonts-awesome/css/font-awesome.min.css' ); // @TODO: wrong path
		wp_enqueue_style( 'yolo-megamenu-awesome' );

	}

	public function yolo_mega_menu_enqueue_script() {
		wp_register_style( 'yolo-megamenu-animate', get_template_directory_uri() . '/framework/core/megamenu/assets/css/animate.css' );
		wp_enqueue_style( 'yolo-megamenu' );
		wp_enqueue_style( 'yolo-megamenu-animate' );

		// wp_register_script( 'yolo-megamenu-js', get_template_directory_uri() . '/framework/core/megamenu/assets/js/megamenu.js' );
		// wp_enqueue_script( 'yolo-megamenu-js' );

	}

	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access      public
	 * @since       1.0
	 * @return      void
	*/

	public function yolo_mega_memu_setup_item( $menu_item ) {
		// Set item mega menu
		$menu_item->megamenu                  = get_post_meta( $menu_item->ID, '_menu_item_megamenu', true );
		
		// Set item style
		$menu_item->megamenu_style            = get_post_meta( $menu_item->ID, '_menu_item_megamenu_style', true );
		
		// Set item width
		$menu_item->megamenu_width            = get_post_meta( $menu_item->ID, '_menu_item_megamenu_width', true );
		
		// Set item columns
		$menu_item->megamenu_col              = get_post_meta( $menu_item->ID, '_menu_item_megamenu_col', true );

		// Set item columns
		$menu_item->megamenu_col_tab          = get_post_meta( $menu_item->ID, '_menu_item_megamenu_col_tab', true );
		
		// Set item sublabel (as HOT, NEW)
		$menu_item->megamenu_sublabel         = get_post_meta( $menu_item->ID, '_menu_item_megamenu_sublabel', true );
		
		// Set item sublabel color
		$menu_item->megamenu_sublabel_color   = get_post_meta( $menu_item->ID, '_menu_item_megamenu_sublabel_color', true );
		
		// Set item background image
		$menu_item->megamenu_background_image = get_post_meta( $menu_item->ID, '_menu_item_megamenu_background_image', true );
		
		// Set item hedding
		$menu_item->megamenu_heading          = get_post_meta( $menu_item->ID, '_menu_item_megamenu_heading', true );
		
		// Set item icon
		$menu_item->megamenu_icon             = get_post_meta( $menu_item->ID, '_menu_item_megamenu_icon', true );
		
		// Set item icon color
		$menu_item->megamenu_icon_color       = get_post_meta( $menu_item->ID, '_menu_item_megamenu_icon_color', true );
		
		// Set item icon size
		$menu_item->megamenu_icon_size        = get_post_meta( $menu_item->ID, '_menu_item_megamenu_icon_size', true );
		
		// Set item icon alignment
		$menu_item->megamenu_icon_alignment   = get_post_meta( $menu_item->ID, '_menu_item_megamenu_icon_alignment', true );
		
		// Set item widget
		$menu_item->megamenu_widgetarea       = get_post_meta( $menu_item->ID, '_menu_item_megamenu_widgetarea', true );
		
		return $menu_item;

	} 

	/**
	 * Save menu custom fields
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	public function yolo_mega_menu_save_fields( $menu_id, $menu_item_db_id, $args ) {
		// Process Enable megamenu
		if(isset($_REQUEST['menu-item-megamenu'][$menu_item_db_id]) && $_REQUEST['menu-item-megamenu'][$menu_item_db_id] !== '') {
	        $megamenu_value = $_REQUEST['menu-item-megamenu'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu', $megamenu_value  );
		} else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu'  );
		}

		// Process megamenu style
		if(isset($_REQUEST['menu-item-megamenu_style'][$menu_item_db_id]) && $_REQUEST['menu-item-megamenu_style'][$menu_item_db_id] !== '') {
	        $megamenu_style_value = $_REQUEST['menu-item-megamenu_style'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_style', $megamenu_style_value  );
		} else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_style' );
		}

		// Process megamenu width
		if ( isset($_REQUEST['menu-item-megamenu_width']) && is_array( $_REQUEST['menu-item-megamenu_width']) ) {
        	$megamenu_width_value = $_REQUEST['menu-item-megamenu_width'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_width', $megamenu_width_value );
	    } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_width' );
		}

		// Process megamenu columns
		if ( isset($_REQUEST['menu-item-megamenu_columns']) && is_array( $_REQUEST['menu-item-megamenu_columns']) ) {
	        $megamenu_col_value = $_REQUEST['menu-item-megamenu_columns'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_col', $megamenu_col_value );
	    } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_col' );
		}

		// Process megamenu columns for tabs
		if ( isset($_REQUEST['menu-item-megamenu_columns_tab']) && is_array( $_REQUEST['menu-item-megamenu_columns_tab']) ) {
	        $megamenu_col_tab_value = $_REQUEST['menu-item-megamenu_columns_tab'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_col_tab', $megamenu_col_tab_value );
	    } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_col_tab' );
		}

		// Process megamenu sublabel
		if ( isset($_REQUEST['menu-item-megamenu_sublabel']) && is_array( $_REQUEST['menu-item-megamenu_sublabel']) ) {
	        $megamenu_sublabel_value = $_REQUEST['menu-item-megamenu_sublabel'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_sublabel', $megamenu_sublabel_value );
	    } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_sublabel' );
		}

		// Process megamenu sublabel color
		if ( isset($_REQUEST['menu-item-megamenu_sublabel_color']) && is_array( $_REQUEST['menu-item-megamenu_sublabel_color']) ) {
	        $megamenu_sublabel_color_value = $_REQUEST['menu-item-megamenu_sublabel_color'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_sublabel_color', $megamenu_sublabel_color_value );
	    } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_sublabel_color' );
		}

		// Process megamenu background image
		if ( isset($_REQUEST['menu-item-megamenu_background_image']) && is_array( $_REQUEST['menu-item-megamenu_background_image']) ) {
	        $megamenu_background_image_value = $_REQUEST['menu-item-megamenu_background_image'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_background_image', $megamenu_background_image_value );
	    } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_background_image' );
		}

		// Process Hide Mega menu heading
		if ( isset($_REQUEST['menu-item-megamenu_heading']) && is_array( $_REQUEST['menu-item-megamenu_heading']) ) {
	        $megamenu_heading_value = @$_REQUEST['menu-item-megamenu_heading'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_heading', $megamenu_heading_value );
	    } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_heading' );
	    }

		// Process Hide Mega menu icon
		if ( isset($_REQUEST['menu-item-megamenu_icon']) && is_array( $_REQUEST['menu-item-megamenu_icon']) ) {
	        $megamenu_icon_value = @$_REQUEST['menu-item-megamenu_icon'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_icon', $megamenu_icon_value );
	    } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_icon'  );
		}

		// Process Hide Mega menu icon color
		if ( isset($_REQUEST['menu-item-megamenu_icon_color']) && is_array( $_REQUEST['menu-item-megamenu_icon_color']) ) {
	        $megamenu_icon_color_value = @$_REQUEST['menu-item-megamenu_icon_color'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_icon_color', $megamenu_icon_color_value );
	   } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_icon_color'  );
	    }

		// Process Hide Mega menu icon size
		if ( isset($_REQUEST['menu-item-megamenu_icon_size']) && is_array( $_REQUEST['menu-item-megamenu_icon_size']) ) {
	        $megamenu_icon_size_value = @$_REQUEST['menu-item-megamenu_icon_size'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_icon_size', $megamenu_icon_size_value );
	    } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_icon_color'  );
	    }

		// Process Hide Mega menu icon alignment
		if ( isset($_REQUEST['menu-item-megamenu_icon_alignment']) && is_array( $_REQUEST['menu-item-megamenu_icon_alignment']) ) {
	        $megamenu_icon_alignment_value = @$_REQUEST['menu-item-megamenu_icon_alignment'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_icon_alignment', $megamenu_icon_alignment_value );
	    } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_icon_alignment'  );
		}

		// Process Mega Menu Widget Area
		if ( isset($_REQUEST['menu-item-megamenu_widgetarea']) && is_array( $_REQUEST['menu-item-megamenu_widgetarea']) ) {
	        $megamenu_widgetarea_value = $_REQUEST['menu-item-megamenu_widgetarea'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_widgetarea', $megamenu_widgetarea_value );
	    } else {
			delete_post_meta ( $menu_item_db_id, '_menu_item_megamenu_widgetarea'  );
		}

	}
	
	/**
	 * Define new Walker edit
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function yolo_mega_menu_edit_walker($walker,$menu_id) {
	    return 'Walker_Nav_Menu_Edit_Custom';
	}

	/**
	 * Reaplace walker args to yolo_menga_menu
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	public function replace_walker_to_yolo_mega_menu($args) {
		if( $args['menu_class'] == 'yolo-nav-mobile-menu' ) {
			$args['is_mobile_menu'] = true;
		}

		return $args;
	}

	/**
	 * Generate menu css
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function megamenu_generate_css_file($option_key) {

		require_once get_template_directory() . '/framework/core/megamenu/inc/generate-less/Less.php';

		try {
			$regex = array(
				"`^([\t\s]+)`ism"                       => '',
				"`^\/\*(.+?)\*\/`ism"                   => "",
				"`([\n\A;]+)\/\*(.+?)\*\/`ism"          => "$1",
				"`([\n\A;\s]+)//(.+?)[\n\r]`ism"        => "$1\n",
				"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism" => "\n"
			);
			$css = '';

			$css .= '@responsive_breakpoint:'. $responsive_breakpoint . 'px;';
			$css .= '@animation_duration:' . $animation_duration . ';';

			WP_Filesystem();
			global $wp_filesystem;
			$options = array( 'compress'=>true );
			$parser = new Less_Parser($options);
			$parser->parse($css);
			$parser->parseFile(get_template_directory() . '/framework/core/megamenu/assets/css/style.less');
			$css = $parser->getCss();
			$css   = preg_replace( array_keys( $regex ), $regex, $css );
			$wp_filesystem->put_contents( get_template_directory() .   '/framework/core/megamenu/assets/css/style' . $option_key . '.css', $css, FS_CHMOD_FILE);
		}
		catch (Exception $e) {
			?>
			<div class="error">
				<?php echo esc_html__('Caught exception:','yolo-motor') . esc_html($e->getMessage()) ?>
			</div>
			<?php
		}
	}

}

// instantiate plugin's class
$GLOBALS['yolo_mega_memu'] = new Yolo_Mega_Menu();

function please_set_menu(){
	$sentence = '<ul><li><a href="">'.	esc_html__( "No menu assigned","yolo-motor" ).'</a></li></ul>';
	
	echo !empty( $sentence ) ? $sentence : ''; 	
}

require_once get_template_directory() . '/framework/core/megamenu/edit_custom_walker.php';
require_once get_template_directory() . '/framework/core/megamenu/custom_walker.php';