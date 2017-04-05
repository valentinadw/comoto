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

/* Custom Sidebar functions */
add_action( 'sidebar_admin_page', 'yolo_custom_sidebar_form' );
function yolo_custom_sidebar_form() {
?>
	<form action="<?php echo admin_url( 'widgets.php' ); ?>" method="post" id="yolo-form-add-sidebar">
        <input type="text" name="sidebar_name" id="sidebar_name" placeholder="<?php esc_html_e( 'Custom Sidebar Name', 'yolo-motor' ); ?>" />
        <button class="button-primary" id="yolo-add-sidebar"><?php esc_html_e( 'Add Sidebar', 'yolo-motor' ); ?></button>
    </form>
<?php
}

function yolo_get_custom_sidebars() {
	$option_name = 'yolo_custom_sidebars';
    return get_option($option_name);
}

add_action('wp_ajax_yolo_add_custom_sidebar', 'yolo_add_custom_sidebar');
function yolo_add_custom_sidebar() {
	if( isset($_POST['sidebar_name']) ) {
		$option_name = 'yolo_custom_sidebars';
		if( !get_option($option_name) || get_option($option_name) == '' ) {
			delete_option($option_name);
		}
		$sidebar_name = $_POST['sidebar_name'];
		if( get_option($option_name) ) {
			$custom_sidebars = yolo_get_custom_sidebars();
			if( !in_array($sidebar_name, $custom_sidebars) ) {
				$custom_sidebars[] = $sidebar_name;
			}
			$result1 = update_option($option_name, $custom_sidebars);
		}
		else{
			$custom_sidebars[] = $sidebar_name;
			$result2 = add_option($option_name, $custom_sidebars);
		}
		
		if( $result1 ) {
			die('Updated');
		}
		elseif( $result2 ) {
			die('Added');
		}
		else {
			die('Error');
		}
	}
	die('');
}

add_action('wp_ajax_yolo_delete_custom_sidebar', 'yolo_delete_custom_sidebar');
function yolo_delete_custom_sidebar() {
	if( isset($_POST['sidebar_name']) ) {
		$option_name = 'yolo_custom_sidebars';
		$del_sidebar = trim($_POST['sidebar_name']);
		$custom_sidebars = yolo_get_custom_sidebars();
		foreach( $custom_sidebars as $key => $value ) {
			if( $value == $del_sidebar ) {
				unset($custom_sidebars[$key]);
				break;
			}
		}
		$custom_sidebars = array_values($custom_sidebars);
		update_option($option_name, $custom_sidebars);
		die('Deleted');
	}
	die('');
}


// Functions to generate CSS file

// GET CUSTOM CSS VARIABLE FONT
//--------------------------------------------------
if (!function_exists('yolo_custom_css_variable_font')) {
	function yolo_custom_css_variable_font() {
		$yolo_options = yolo_get_options();

		$fonts = (object)array();

		// Menu Font
		$fonts->menu_font_family = 'Montserrat';
		$fonts->menu_font_weight = '400';
		$fonts->menu_font_size   = '14px';
		if ( isset($yolo_options['menu_font']) && ! empty($yolo_options['menu_font']) && !empty($yolo_options['menu_font']['font-family']) && ($yolo_options['custom_menu_font'] == 1 ) ) {
			$fonts->menu_font_family = $yolo_options['menu_font']['font-family'];
			$fonts->menu_font_weight = $yolo_options['menu_font']['font-weight'];
			$fonts->menu_font_size   = $yolo_options['menu_font']['font-size'];
		}

		// General Font
		$fonts->primary_font_family = 'Montserrat';
		$fonts->primary_font_weight = '400';
		$fonts->primary_font_size   = '14px';
		if ( isset($yolo_options['body_font']) && ! empty($yolo_options['body_font']) && !empty($yolo_options['body_font']['font-family']) && ($yolo_options['custom_general_font'] == 1 ) ) {
			$fonts->primary_font_family = $yolo_options['body_font']['font-family'];
			$fonts->primary_font_weight = $yolo_options['body_font']['font-weight'];
			$fonts->primary_font_size   = $yolo_options['body_font']['font-size'];
		}
		// Secondary Font
		$fonts->secondary_font_family = 'Montserrat';
		$fonts->secondary_font_weight = '400';
		$fonts->secondary_font_size   = '14px';
		if ( isset($yolo_options['secondary_font']) && ! empty($yolo_options['secondary_font']) && !empty($yolo_options['secondary_font']['font-family']) && ($yolo_options['custom_general_font'] == 1 ) ) {
			$fonts->secondary_font_family = $yolo_options['secondary_font']['font-family'];
			$fonts->secondary_font_weight = $yolo_options['secondary_font']['font-weight'];
			$fonts->secondary_font_size   = $yolo_options['secondary_font']['font-size'];
		}

		// Heading Font
		$fonts->h1_font_family = 'Montserrat';
		$fonts->h1_font_weight = '400';
		$fonts->h1_font_size   = '36px';
		if ( isset($yolo_options['h1_font']) && ! empty($yolo_options['h1_font']) && !empty($yolo_options['h1_font']['font-family']) && ($yolo_options['custom_general_font'] == 1 ) ) {
			$fonts->h1_font_family = $yolo_options['h1_font']['font-family'];
			$fonts->h1_font_weight = $yolo_options['h1_font']['font-weight'];
			$fonts->h1_font_size   = $yolo_options['h1_font']['font-size'];
		}
		$fonts->h2_font_family = 'Montserrat';
		$fonts->h2_font_weight = '400';
		$fonts->h2_font_size   = '30px';
		if ( isset($yolo_options['h2_font']) && ! empty($yolo_options['h2_font']) && !empty($yolo_options['h2_font']['font-family']) && ($yolo_options['custom_general_font'] == 1 ) ) {
			$fonts->h2_font_family = $yolo_options['h2_font']['font-family'];
			$fonts->h2_font_weight = $yolo_options['h2_font']['font-weight'];
			$fonts->h2_font_size   = $yolo_options['h2_font']['font-size'];
		}
		$fonts->h3_font_family = 'Montserrat';
		$fonts->h3_font_weight = '400';
		$fonts->h3_font_size   = '24px';
		if ( isset($yolo_options['h3_font']) && ! empty($yolo_options['h3_font']) && !empty($yolo_options['h3_font']['font-family']) && ($yolo_options['custom_general_font'] == 1 ) ) {
			$fonts->h3_font_family = $yolo_options['h3_font']['font-family'];
			$fonts->h3_font_weight = $yolo_options['h3_font']['font-weight'];
			$fonts->h3_font_size   = $yolo_options['h3_font']['font-size'];
		}
		$fonts->h4_font_family = 'Montserrat';
		$fonts->h4_font_weight = '400';
		$fonts->h4_font_size   = '18px';
		if ( isset($yolo_options['h4_font']) && ! empty($yolo_options['h4_font']) && !empty($yolo_options['h4_font']['font-family']) && ($yolo_options['custom_general_font'] == 1 ) ) {
			$fonts->h4_font_family = $yolo_options['h4_font']['font-family'];
			$fonts->h4_font_weight = $yolo_options['h4_font']['font-weight'];
			$fonts->h4_font_size   = $yolo_options['h4_font']['font-size'];
		}
		$fonts->h5_font_family = 'Montserrat';
		$fonts->h5_font_weight = '400';
		$fonts->h5_font_size   = '16px';
		if ( isset($yolo_options['h5_font']) && ! empty($yolo_options['h5_font']) && !empty($yolo_options['h5_font']['font-family']) && ($yolo_options['custom_general_font'] == 1 ) ) {
			$fonts->h5_font_family = $yolo_options['h5_font']['font-family'];
			$fonts->h5_font_weight = $yolo_options['h5_font']['font-weight'];
			$fonts->h5_font_size   = $yolo_options['h5_font']['font-size'];
		}
		$fonts->h6_font_family = 'Montserrat';
		$fonts->h6_font_weight = '400';
		$fonts->h6_font_size   = '14px';
		if ( isset($yolo_options['h6_font']) && ! empty($yolo_options['h6_font']) && !empty($yolo_options['h6_font']['font-family']) && ($yolo_options['custom_general_font'] == 1 ) ) {
			$fonts->h6_font_family = $yolo_options['h6_font']['font-family'];
			$fonts->h6_font_weight = $yolo_options['h6_font']['font-weight'];
			$fonts->h6_font_size   = $yolo_options['h6_font']['font-size'];
		}

		// Page Title Font
		$fonts->page_title_font_family = 'Montserrat';
		$fonts->page_title_font_weight = '400';
		$fonts->page_title_font_size   = '36px';
		if ( isset($yolo_options['page_title_font']) && ! empty($yolo_options['page_title_font']) && !empty($yolo_options['page_title_font']['font-family']) && ($yolo_options['custom_page_title_font'] == 1 ) ) {
			$fonts->page_title_font_family = $yolo_options['page_title_font']['font-family'];
			$fonts->page_title_font_weight = $yolo_options['page_title_font']['font-weight'];
			$fonts->page_title_font_size   = $yolo_options['page_title_font']['font-size'];
		}
		$fonts->page_sub_title_font_family = 'Montserrat';
		$fonts->page_sub_title_font_weight = '400';
		$fonts->page_sub_title_font_size   = '14px';
		if ( isset($yolo_options['page_sub_title_font']) && ! empty($yolo_options['page_sub_title_font']) && !empty($yolo_options['page_sub_title_font']['font-family']) && ($yolo_options['custom_page_title_font'] == 1 ) ) {
			$fonts->page_sub_title_font_family = $yolo_options['page_sub_title_font']['font-family'];
			$fonts->page_sub_title_font_weight = $yolo_options['page_sub_title_font']['font-weight'];
			$fonts->page_sub_title_font_size   = $yolo_options['page_sub_title_font']['font-size'];
		}

		return $fonts;
	}
}

// GET CUSTOM CSS VARIABLE LOGO
//--------------------------------------------------
if (!function_exists('yolo_custom_css_variable_logo')) {
	function yolo_custom_css_variable_logo($page_id = 0) {
		$yolo_options = yolo_get_options();
		$prefix = 'yolo_';

		$logo = (object)array();

		// GET logo_max_height, logo_padding
		$yolo_header_layout = '';
		if (!empty($page_id)) {
			$yolo_header_layout = get_post_meta($page_id,$prefix . 'header_layout', true);
		}

		if (($yolo_header_layout == '') || ($yolo_header_layout == '-1')) {
			$yolo_header_layout = $yolo_options['header_layout'];
		}

		$logo->logo_max_height     = '140px';
		$logo->logo_padding_top    = '10px';
		$logo->logo_padding_bottom = '10px';
		$logo->main_menu_height    = '80px';

		// Change default logo height here
		$logo_matrix = array(
			'header-1' => array(140, 10, 10, 80),
			'header-2' => array(140, 0, 0, 80),
			'header-3' => array(140, 0, 0, 80),
			'header-4' => array(140, 20, 20, 80),
			'header-6' => array(140, 20, 20, 70),
			'header-8' => array(140, 20, 20, 70),
			'header-sidebar' => array(140, 20, 20, 'auto'),
		);
		if (isset($logo_matrix[$yolo_header_layout])) {
			$logo->logo_max_height     = $logo_matrix[$yolo_header_layout][0] . 'px';
			$logo->logo_padding_top    = $logo_matrix[$yolo_header_layout][1] . 'px';
			$logo->logo_padding_bottom = $logo_matrix[$yolo_header_layout][2] . 'px';
			if (isset($logo_matrix[$yolo_header_layout][3])) {
				$logo->main_menu_height = $logo_matrix[$yolo_header_layout][3] . 'px';
			}
		}
		// Get logo max height
		if (!empty($page_id)) {
			$logo->logo_max_height = get_post_meta($page_id,$prefix . 'logo_max_height', true);

			if (($logo->logo_max_height === '') || ($logo->logo_max_height == '-1')) {
				if (isset($yolo_options['logo_max_height']) && isset($yolo_options['logo_max_height']['height']) && ! empty($yolo_options['logo_max_height']['height']) && ($yolo_options['logo_max_height']['height'] != 'px')) {
					$logo->logo_max_height = $yolo_options['logo_max_height']['height'];
				}
				else {
					$logo->logo_max_height = $logo_matrix[$yolo_header_layout][0] . 'px';
				}
			}
			else {
				$logo->logo_max_height .= 'px';
			}
		}
		else {
			if (isset($yolo_options['logo_max_height']) && isset($yolo_options['logo_max_height']['height']) && ! empty($yolo_options['logo_max_height']['height']) && ($yolo_options['logo_max_height']['height'] != 'px')) {
				$logo->logo_max_height = $yolo_options['logo_max_height']['height'];
			}
		}

		// Get logo padding
		if (!empty($page_id)) {
			$enable_logo_position = get_post_meta( $page_id, $prefix.'enable_logo_position', true );
			$logo->logo_max_height = get_post_meta($page_id,$prefix . 'logo_max_height', true);
			$logo->logo_padding_top = get_post_meta($page_id,$prefix . 'logo_padding_top', true);
			$logo->logo_padding_bottom = get_post_meta($page_id,$prefix . 'logo_padding_bottom', true);
			$logo->logo_padding_right = get_post_meta($page_id,$prefix . 'logo_padding_right', true);
			$logo->logo_padding_left = get_post_meta($page_id,$prefix . 'logo_padding_left', true);
			if($enable_logo_position == 1){
				// Logo Max Height
				if (($logo->logo_max_height == '')) {
					if (isset($yolo_options['logo_max_height']) && isset($yolo_options['logo_max_height']['height']) && ! empty($yolo_options['logo_max_height']['height']) && ($yolo_options['logo_max_height']['height'] != 'px')) {
						$logo->logo_max_height = $yolo_options['logo_max_height']['height'];
					}
					else {
						$logo->logo_max_height = $logo_matrix[$yolo_header_layout][3] . 'px';
					}
				}
				else {
					$logo->logo_max_height .= 'px';
				}
				// Logo Padding Top
				if (($logo->logo_padding_top == '')) {
					if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
						&& isset($yolo_options['logo_padding']['padding-top']) && !empty($yolo_options['logo_padding']['padding-top'])) {
						$logo->logo_padding_top = $yolo_options['logo_padding']['padding-top'];
					}
					else {
						$logo->logo_padding_top = $logo_matrix[$yolo_header_layout][0] . 'px';
					}
				}
				else {
					$logo->logo_padding_top .= 'px';
				}
				// Logo Padding Bottom
				if (($logo->logo_padding_bottom === '')) {
					if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
						&& isset($yolo_options['logo_padding']['padding-bottom']) && !empty($yolo_options['logo_padding']['padding-bottom'])) {
						$logo->logo_padding_bottom = $yolo_options['logo_padding']['padding-bottom'];
					}
					else {
						$logo->logo_padding_bottom = $logo_matrix[$yolo_header_layout][1] . 'px';
					}
				}
				else {
					$logo->logo_padding_bottom .= 'px';
				}
				// Logo Padding Left
				if (($logo->logo_padding_left == '')) {
					if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
						&& isset($yolo_options['logo_padding']['padding-left']) && !empty($yolo_options['logo_padding']['padding-left'])) {
						$logo->logo_padding_left = $yolo_options['logo_padding']['padding-left'];
					}
					else {
						$logo->logo_padding_left = $logo_matrix[$yolo_header_layout][3] . 'px';
					}
				}
				else {
					$logo->logo_padding_left .= 'px';
				}
				// Logo Padding Right
				if (($logo->logo_padding_right == '')) {
					if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
						&& isset($yolo_options['logo_padding']['padding-right']) && !empty($yolo_options['logo_padding']['padding-right'])) {
						$logo->logo_padding_right = $yolo_options['logo_padding']['padding-right'];
					}
					else {
						$logo->logo_padding_right = $logo_matrix[$yolo_header_layout][2] . 'px';
					}
				}
				else {
					$logo->logo_padding_right .= 'px';
				}
			}else{
				if (isset($yolo_options['logo_max_height']) && isset($yolo_options['logo_max_height']['height']) && ! empty($yolo_options['logo_max_height']['height']) && ($yolo_options['logo_max_height']['height'] != 'px')) {
						$logo->logo_max_height = $yolo_options['logo_max_height']['height'];
				}else {
					$logo->logo_max_height = $logo_matrix[$yolo_header_layout][3] . 'px';
				}
				if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
						&& isset($yolo_options['logo_padding']['padding-top']) && !empty($yolo_options['logo_padding']['padding-top'])) {
						$logo->logo_padding_top = $yolo_options['logo_padding']['padding-top'];
				}else {
					$logo->logo_padding_top = $logo_matrix[$yolo_header_layout][0] . 'px';
				}
				if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
						&& isset($yolo_options['logo_padding']['padding-bottom']) && !empty($yolo_options['logo_padding']['padding-bottom'])) {
						$logo->logo_padding_bottom = $yolo_options['logo_padding']['padding-bottom'];
				}else {
					$logo->logo_padding_bottom = $logo_matrix[$yolo_header_layout][1] . 'px';
				}
				if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
						&& isset($yolo_options['logo_padding']['padding-left']) && !empty($yolo_options['logo_padding']['padding-left'])) {
						$logo->logo_padding_left = $yolo_options['logo_padding']['padding-left'];
				}else {
					$logo->logo_padding_left = $logo_matrix[$yolo_header_layout][3] . 'px';
				}
				if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
						&& isset($yolo_options['logo_padding']['padding-right']) && !empty($yolo_options['logo_padding']['padding-right'])) {
						$logo->logo_padding_right = $yolo_options['logo_padding']['padding-right'];
				}else {
					$logo->logo_padding_right = $logo_matrix[$yolo_header_layout][2] . 'px';
				}
			}
		}else {
			if (isset($yolo_options['logo_max_height']) && isset($yolo_options['logo_max_height']['height']) && ! empty($yolo_options['logo_max_height']['height']) && ($yolo_options['logo_max_height']['height'] != 'px')) {
				$logo->logo_max_height = $yolo_options['logo_max_height']['height'];
			}
			if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
				&& isset($yolo_options['logo_padding']['padding-top']) && !empty($yolo_options['logo_padding']['padding-top'])) {
				$logo->logo_padding_top = $yolo_options['logo_padding']['padding-top'];
			}
			if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
				&& isset($yolo_options['logo_padding']['padding-bottom']) && !empty($yolo_options['logo_padding']['padding-bottom'])) {
				$logo->logo_padding_bottom = $yolo_options['logo_padding']['padding-bottom'];
			}
			if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
				&& isset($yolo_options['logo_padding']['padding-left']) && !empty($yolo_options['logo_padding']['padding-left'])) {
				$logo->logo_padding_left = $yolo_options['logo_padding']['padding-left'];
			}
			if (isset($yolo_options['logo_padding']) && is_array($yolo_options['logo_padding'])
				&& isset($yolo_options['logo_padding']['padding-right']) && !empty($yolo_options['logo_padding']['padding-right'])) {
				$logo->logo_padding_right = $yolo_options['logo_padding']['padding-right'];
			}
		}
		return $logo;
	}
}

// GET CUSTOM CSS VARIABLE HEADER
//--------------------------------------------------
if (!function_exists('yolo_custom_css_variable_header')) {
	function yolo_custom_css_variable_header($page_id = 0) {
		$yolo_options = yolo_get_options();
		$prefix = 'yolo_';

		$header = (object)array();

		$header->header_nav_bg_color_color   = '#f4f4f4';
		$header->header_nav_bg_color_opacity = 1;
		$header->header_nav_text_color       = '#fff';
		// Header scheme
		$header_scheme = get_post_meta($page_id,$prefix . 'header_scheme', true);
		
		$is_set_header_background_css =  false;

		if ((!empty($page_id)) && ($header_scheme != '-1') && ($header_scheme != '')) {
			switch($header_scheme) {
				case 'default':
					$header->header_border_color = '#eee';
					$header_background_color     = '#fff';
					$header->header_text_color   = '#3f3f3f';
					break;
				case 'customize':

				$header_background_color         = get_post_meta($page_id,$prefix . 'header_background_color', true);
				$header_background_image         = get_post_meta($page_id,$prefix . 'header_background_image', true);
				$header_background_repeat        = get_post_meta($page_id,$prefix . 'header_background_repeat', true);
				$header_background_position      = get_post_meta($page_id,$prefix . 'header_background_position', true);
				$header_background_size          = get_post_meta($page_id,$prefix . 'header_background_size', true);
				$header_background_attachment    = get_post_meta($page_id,$prefix . 'header_background_attachment', true);
				$header_background_color_opacity = get_post_meta($page_id,$prefix . 'header_background_color_opacity', true);


				$header_background_image_id      = get_post_meta($page_id,$prefix . 'header_background_image', true);
				if (is_array($header_background_image)  && !empty($header_background_image)) {
					$header_background_image = $header_background_image[$header_background_image_id];
				}

				if (($header_background_color !== '' ) && ($header_background_color_opacity !== '')) {
					$header_background_color = yolo_hex2rgba($header_background_color, $header_background_color_opacity / 100.0);
				}

				$is_set_header_background_css =  true;
				$header_border_color          = get_post_meta($page_id,$prefix . 'header_border_color', true);
				$header_border_color_opacity  = get_post_meta($page_id,$prefix . 'header_border_color_opacity', true);
				$header->header_border_color  = '#eee';
				if (($header_border_color_opacity !== '') && ($header_border_color !== '')) {
					$header->header_border_color = yolo_hex2rgba($header_border_color, $header_border_color_opacity * 1.0/100);
				}
				$header->header_text_color = get_post_meta($page_id,$prefix . 'header_text_color', true);
				if ($header->header_text_color === '') {
					$header->header_text_color = '#3f3f3f';
				}

			}
		} else {
			$header_scheme = isset($yolo_options['header_scheme']) ? $yolo_options['header_scheme'] : '';
			switch($header_scheme) {
				case 'default':
					$header->header_border_color = '#eee';
					$header_background_color     = '#fff';
					$header->header_text_color   = '#3f3f3f';
					break;
				case 'customize':

				$header_background = isset($yolo_options['header_background']) ? $yolo_options['header_background'] : array();
				$header_background_color_opacity = isset($yolo_options['header_background_color_opacity']) ? $yolo_options['header_background_color_opacity'] : 100;

				if ($header_background) {
					$is_set_header_background_css =  true;

					$header_background_color = isset($header_background['background-color']) ?
						yolo_hex2rgba($header_background['background-color'], $header_background_color_opacity/ 100.0) : 'transparent';
					$header_background_image = isset($header_background['background-image']) && !empty($header_background['background-image']) ?
						$header_background['background-image'] : '';
					$header_background_repeat = isset($header_background['background-repeat']) && !empty($header_background['background-repeat']) ?
						$header_background['background-repeat'] : '';
					$header_background_position = isset($header_background['background-position']) && !empty($header_background['background-position']) ?
						$header_background['background-position'] : '';
					$header_background_size = isset($header_background['background-size']) && !empty($header_background['background-size']) ?
						$header_background['background-size'] : '';
					$header_background_attachment = isset($header_background['background-attachment']) && !empty($header_background['background-attachment']) ?
						$header_background['background-attachment'] : '';
				}

				$header_border_color = isset($yolo_options['header_border_color']) ? $yolo_options['header_border_color'] : array();
				$header->header_border_color = '#eee';
				if ($header_border_color) {
					if (isset($header_border_color['alpha']) && !empty($header_border_color['alpha'])) {
						$header->header_border_color = $header_border_color['alpha'];
					}
					if (isset($header_border_color['color']) && !empty($header_border_color['color'])) {
						$header->header_border_color =$header_border_color['color'];
					}
				}

				$header->header_text_color = isset($yolo_options['header_text_color']) && !empty($yolo_options['header_text_color']) ? $yolo_options['header_text_color'] : '#3f3f3f';
			}
		}
		if(!empty($header_background_color)){
			$header->header_background_color = $header_background_color;
		}else{
			$header->header_background_color = yolo_hex2rgba('#fff',1);
		}
		$header->header_background_css = '.yolo-main-header {}';
		if ($is_set_header_background_css) {
			$header->header_background_css = sprintf('.yolo-main-header{%s%s%s%s%s}',
				!empty($header_background_image) ?
					'background-image:url(' . $header_background_image . ');' : 'background-image:none;',
				!empty($header_background_repeat) ?
					'background-repeat:' . $header_background_repeat . ';' : '',
				!empty($header_background_position) ?
					'background-position:' . $header_background_position . ';' : '',
				!empty($header_background_size) ?
					'background-size:' . $header_background_size . ';' : '',
				!empty($header_background_attachment) ?
					'background-attachment:' . $header_background_attachment . ';' : ''
			);
		}

		// Set header nav scheme (section header)
		$header_nav_scheme = get_post_meta($page_id,$prefix . 'header_nav_scheme', true);

		if ((!empty($page_id)) && ($header_nav_scheme != '-1') && ($header_nav_scheme != '')) {
			switch ($header_nav_scheme) {
				case 'default':
					$header->header_nav_bg_color_color   = '#fff';
					$header->header_nav_bg_color_opacity = '1';
					$header->header_nav_text_color       = '#333';
					break;
				default:
					if (get_post_meta($page_id,$prefix . 'header_nav_bg_color_color', true) != '') {
						$header->header_nav_bg_color_color = get_post_meta($page_id,$prefix . 'header_nav_bg_color_color', true);
					}
					$header->header_nav_bg_color_opacity = get_post_meta($page_id,$prefix . 'header_nav_bg_color_opacity', true);

					if (($header->header_nav_bg_color_opacity == '')) {
						$header->header_nav_bg_color_opacity = 1;
					}
					else {
						$header->header_nav_bg_color_opacity = $header->header_nav_bg_color_opacity/100.0;
					}

					$header->header_nav_text_color = get_post_meta($page_id,$prefix . 'header_nav_text_color', true);
					if (($header->header_nav_text_color == '')) {
						$header->header_nav_text_color = '#222';
					}
					break;
			}
		}
		else {
			$header_nav_scheme = isset($yolo_options['header_nav_scheme']) ? $yolo_options['header_nav_scheme'] : '';
			switch ($header_nav_scheme) {
				case 'default':
					$header->header_nav_bg_color_color   = '#fff';
					$header->header_nav_bg_color_opacity = '1';
					$header->header_nav_text_color       = '#191919';
					break;
				default:
					$header_nav_bg_color = isset($yolo_options['header_nav_bg_color']) ? $yolo_options['header_nav_bg_color'] : array();

					if ($header_nav_bg_color) {
						if (isset($header_nav_bg_color['alpha'])) {
							$header->header_nav_bg_color_opacity = $header_nav_bg_color['alpha'];
						}
						if (isset($header_nav_bg_color['color'])) {
							$header->header_nav_bg_color_color = $header_nav_bg_color['color'];
						}
					}
					if (isset($yolo_options['header_nav_text_color']) ) {
						$header->header_nav_text_color = $yolo_options['header_nav_text_color'];
					}
					break;
			}
		}

		$header->header_nav_bg_color = yolo_hex2rgba($header->header_nav_bg_color_color, $header->header_nav_bg_color_opacity);

		// Set top bar layout
		$header->top_bar_layout_padding = '100';
		if ((!empty($page_id))) {
			$header_nav_layout = get_post_meta($page_id,$prefix . 'top_bar_layout_width', true);
			if (($header_nav_layout == '-1') || ($header_nav_layout === '')) {
				$header->top_bar_layout_padding = isset($yolo_options['top_bar_layout_padding']) ? $yolo_options['top_bar_layout_padding'] : '100';
			}
			else if ($header_nav_layout == 'topbar-fullwith') {
				$header->top_bar_layout_padding = get_post_meta($page_id,$prefix . 'top_bar_layout_padding',true);
				if ($header->top_bar_layout_padding == '') {
					$header->top_bar_layout_padding = '100';
				}
			}

		}
		else {
			$header->top_bar_layout_padding = isset($yolo_options['top_bar_layout_padding']) ? $yolo_options['top_bar_layout_padding'] : '100';
			if ($header->top_bar_layout_padding == '') {
				$header->top_bar_layout_padding = '100';
			}
		}
		$header->top_bar_layout_padding .= 'px';

		// Set header nav layout
		$header->header_nav_layout_padding = '100';
		if ((!empty($page_id))) {
			$header_nav_layout = get_post_meta($page_id,$prefix . 'header_nav_layout', true);
			if (($header_nav_layout == '-1') || ($header_nav_layout === '')) {
				$header->header_nav_layout_padding = isset($yolo_options['header_nav_layout_padding']) ? $yolo_options['header_nav_layout_padding'] : '100';
			}
			else if ($header_nav_layout == 'nav-fullwith') {
				$header->header_nav_layout_padding = get_post_meta($page_id,$prefix . 'header_nav_layout_padding',true);
				if ($header->header_nav_layout_padding == '') {
					$header->header_nav_layout_padding = '100';
				}
			}

		}
		else {
			$header->header_nav_layout_padding = isset($yolo_options['header_nav_layout_padding']) ? $yolo_options['header_nav_layout_padding'] : '100';
			if ($header->header_nav_layout_padding == '') {
				$header->header_nav_layout_padding = '100';
			}
		}
		$header->header_nav_layout_padding .= 'px';


		// Set header navigation distance
		$header->header_nav_distance = get_post_meta($page_id,$prefix . 'header_nav_distance',true);
		if ($header->header_nav_distance == '') {
			if (isset($yolo_options['header_nav_distance']) && isset($yolo_options['header_nav_distance']['width']) && ($yolo_options['header_nav_distance']['width'] != 'px')) {
				$header->header_nav_distance = $yolo_options['header_nav_distance']['width'];
			}
		}
		else {
			$header->header_nav_distance = str_replace('px','', $header->header_nav_distance) . 'px';
		}
		if ($header->header_nav_distance == '') {
			$header->header_nav_distance = '45px';
		}

		// Sub menu
		$menu_sub_scheme = isset($yolo_options['menu_sub_scheme']) ? $yolo_options['menu_sub_scheme'] : 'light';
		$header->menu_sub_bg_color = '#F8F8F8';
		$header->menu_sub_text_color = '#222';
		switch ($menu_sub_scheme) {
			case 'default':
				$header->menu_sub_bg_color = '#fff';
				$header->menu_sub_text_color = '#333';
				break;
			default:
				if (isset($yolo_options['menu_sub_bg_color']) && ! empty($yolo_options['menu_sub_bg_color'])) {
					$header->menu_sub_bg_color = $yolo_options['menu_sub_bg_color'];
				}
				if (isset($yolo_options['menu_sub_text_color']) && ! empty($yolo_options['menu_sub_text_color'])) {
					$header->menu_sub_text_color = $yolo_options['menu_sub_text_color'];
				}

				break;
		}

		return $header;
	}
}

// GET CUSTOM CSS VARIABLE
//--------------------------------------------------
if (!function_exists('yolo_custom_css_variable')) {
	function yolo_custom_css_variable($page_id = 0) {
		$yolo_options = yolo_get_options();
		if (isset($_REQUEST['current_page_id'])) {
			$page_id = $_REQUEST['current_page_id'];
		}
		$prefix = 'yolo_';

		// Set default color for page
		$top_bar_bg_color   = '#F9F9F9';
		$top_bar_text_color = '#878787';
		$top_bar_bg_color_opacity = 100;
		$primary_color      = '#ffb535';
		$enable_topbar_color = (!empty($page_id) && ($page_id !== 0)) ? get_post_meta($page_id,$prefix . 'enable_topbar_color',true) : '0';
		
		if ($enable_topbar_color == '1') { // Use metaboxes settings			
			$top_bar_text_color       = get_post_meta($page_id,$prefix . 'top_bar_text_color', true);
			$top_bar_bg_color         = get_post_meta($page_id,$prefix . 'top_bar_bg_color', true);
			$top_bar_bg_color_opacity = get_post_meta($page_id,$prefix . 'top_bar_bg_color_opacity', true);
			$top_bar_bg_color         = yolo_hex2rgba( $top_bar_bg_color, $top_bar_bg_color_opacity/100.00 );
		}
		else { // Use Theme options settings
			if (isset($yolo_options['top_bar_bg_color']) && ! empty($yolo_options['top_bar_bg_color'])) {
				if (isset($yolo_options['top_bar_bg_color']['rgba'])) {
					$top_bar_bg_color = $yolo_options['top_bar_bg_color']['rgba'];
				}
				elseif (isset($yolo_options['top_bar_bg_color']['color'])) {
					$top_bar_bg_color = $yolo_options['top_bar_bg_color']['color'];
				}
			}

			if (isset($yolo_options['top_bar_text_color']) && ! empty($yolo_options['top_bar_text_color'])) {
				$top_bar_text_color = $yolo_options['top_bar_text_color'];
			}
			if (isset($yolo_options['primary_color']) && ! empty($yolo_options['primary_color'])) {
				$primary_color = $yolo_options['primary_color'];
			}
		}

		// Set to default value if variables empty
		if (empty($top_bar_bg_color)) {
			$top_bar_bg_color = '#F9F9F9';
		}
		if (empty($top_bar_text_color)) {
			$top_bar_text_color = '#878787';
		}
		if (empty($primary_color)) {
			$primary_color = '#ffb535';
		}

		$secondary_color = '#333333';
		if (isset($yolo_options['secondary_color']) && ! empty($yolo_options['secondary_color'])) {
			$secondary_color = $yolo_options['secondary_color'];
		}

		$text_color = '#363738';
		if (isset($yolo_options['text_color']) && ! empty($yolo_options['text_color'])) {
			$text_color = $yolo_options['text_color'];
		}

		$heading_color = '#333333';
		if (isset($yolo_options['heading_color']) && ! empty($yolo_options['heading_color'])) {
			$heading_color = $yolo_options['heading_color'];
		}
		// Page Title
		//-------------------

		$page_title_bg_color = '#fff';
		if (isset($yolo_options['page_title_bg_color']) && ! empty($yolo_options['page_title_bg_color'])) {
			$page_title_bg_color = $yolo_options['page_title_bg_color'];
		}

		$page_title_overlay_color = '#000';
		if (isset($yolo_options['page_title_overlay_color']) && ! empty($yolo_options['page_title_overlay_color'])) {
			$page_title_overlay_color = $yolo_options['page_title_overlay_color'];
		}
		$page_title_overlay_opacity = '0';
		if (isset($yolo_options['page_title_overlay_opacity']) && ! empty($yolo_options['page_title_overlay_opacity'])) {
			$page_title_overlay_opacity = $yolo_options['page_title_overlay_opacity']/100;
		}
		// Mobile menu
		$logo_mobile_max_height  = '40px';
		$logo_mobile_padding     = '15px';
		$main_menu_mobile_height = '70px';

		$logo_mobile_matrix = array(
			'header-mobile-1' => array(70, 15),
			'header-mobile-2' => array(120, 25, 50),
			'header-mobile-3' => array(70, 15),
			'header-mobile-4' => array(70, 15),
			'header-mobile-5' => array(70, 15),
		);

		// GET logo_max_height, logo_padding
		$mobile_header_layout = isset($yolo_options['mobile_header_layout']) ? $yolo_options['mobile_header_layout'] : 'header-mobile-2';
		if (isset($logo_mobile_matrix[$mobile_header_layout])) {
			$logo_mobile_max_height = $logo_mobile_matrix[$mobile_header_layout][0] . 'px';
			$logo_mobile_padding    = $logo_mobile_matrix[$mobile_header_layout][1] . 'px';
			if (isset($logo_mobile_matrix[$mobile_header_layout][2])) {
				$main_menu_mobile_height = $logo_mobile_matrix[$mobile_header_layout][2] . 'px';
			}
			else {
				$main_menu_mobile_height = ($logo_mobile_matrix[$mobile_header_layout][0] + $logo_mobile_matrix[$mobile_header_layout][1] * 2) . 'px';
			}
		}

		if (isset($yolo_options['logo_mobile_max_height']) && isset($yolo_options['logo_mobile_max_height']['height']) && ! empty($yolo_options['logo_mobile_max_height']['height']) && ($yolo_options['logo_mobile_max_height']['height'] != 'px')) {
			$logo_mobile_max_height = $yolo_options['logo_mobile_max_height']['height'];
		}

		if (isset($yolo_options['logo_mobile_padding']) && isset($yolo_options['logo_mobile_padding']['height']) && ! empty($yolo_options['logo_mobile_padding']['height']) && ($yolo_options['logo_mobile_padding']['height'] != 'px')) {
			$logo_mobile_padding = $yolo_options['logo_mobile_padding']['height'];
		}

		$fonts  = yolo_custom_css_variable_font();
		$logo   = yolo_custom_css_variable_logo($page_id);
		$header = yolo_custom_css_variable_header($page_id);
		ob_start();

		echo "@top_bar_bg_color:		$top_bar_bg_color;", PHP_EOL;
		echo "@top_bar_text_color:		$top_bar_text_color;", PHP_EOL;
		echo "@primary_color:			$primary_color;", PHP_EOL;
		echo "@secondary_color:			$secondary_color;", PHP_EOL;
		echo "@text_color:				$text_color;", PHP_EOL;
		echo "@heading_color:			$heading_color;", PHP_EOL;

		echo "@menu_font:				'$fonts->menu_font_family';", PHP_EOL;
		echo "@menu_font_weight:		$fonts->menu_font_weight;", PHP_EOL;
		echo "@menu_font_size:			$fonts->menu_font_size;", PHP_EOL;
		echo "@secondary_font:			'$fonts->secondary_font_family';", PHP_EOL;
		echo "@secondary_font_weight:	$fonts->secondary_font_weight;", PHP_EOL;
		echo "@secondary_font_size:		$fonts->secondary_font_size;", PHP_EOL;
		echo "@primary_font:			'$fonts->primary_font_family';", PHP_EOL;
		echo "@primary_font_weight:		$fonts->primary_font_weight;", PHP_EOL;
		echo "@primary_font_size:		$fonts->primary_font_size;", PHP_EOL;

		echo "@page_title_bg_color:			$page_title_bg_color;", PHP_EOL;
		echo "@page_title_overlay_color:	$page_title_overlay_color;", PHP_EOL;
		echo "@page_title_overlay_opacity:	$page_title_overlay_opacity;", PHP_EOL;

		echo "@logo_max_height:			$logo->logo_max_height;", PHP_EOL;
		echo "@logo_padding_top:		$logo->logo_padding_top;", PHP_EOL;
		echo "@logo_padding_bottom:		$logo->logo_padding_bottom;", PHP_EOL;
		echo "@main_menu_height:		$logo->main_menu_height;", PHP_EOL;

		echo "@logo_mobile_max_height:	$logo_mobile_max_height;", PHP_EOL;
		echo "@logo_mobile_padding:		$logo_mobile_padding;", PHP_EOL;
		echo "@main_menu_mobile_height:	$main_menu_mobile_height;", PHP_EOL;

		echo "@top_bar_layout_padding:		$header->top_bar_layout_padding;", PHP_EOL;
		echo "@header_nav_layout_padding:	$header->header_nav_layout_padding;", PHP_EOL;
		echo "@header_nav_distance:			$header->header_nav_distance;", PHP_EOL;
		echo "@header_nav_text_color:		$header->header_nav_text_color;", PHP_EOL;
		echo "@menu_sub_bg_color:			$header->menu_sub_bg_color;", PHP_EOL;
		echo "@menu_sub_text_color:			$header->menu_sub_text_color;", PHP_EOL;

		echo "@header_text_color: 		$header->header_text_color;", PHP_EOL;
		echo "@header_border_color: 	$header->header_border_color;", PHP_EOL;
		echo "@header_nav_bg_color: 	$header->header_nav_bg_color;", PHP_EOL;
		echo "@header_background_color: $header->header_background_color;", PHP_EOL;

		echo '@theme_url:"'. get_template_directory_uri() . '";', PHP_EOL;

		echo sprintf('%s', $header->header_background_css), PHP_EOL;

		return ob_get_clean();
	}
}

// GET CUSTOM CSS
//--------------------------------------------------
if (!function_exists('yolo_custom_css')) {
	function yolo_custom_css() {
		$yolo_options = yolo_get_options();
		$custom_css           = '';
		$background_image_css = '';

		$body_background_mode = $yolo_options['body_background_mode'];
		
		if ($body_background_mode == 'background') {
			$background_image_url = isset($yolo_options['body_background']['background-image']) ? $yolo_options['body_background']['background-image'] : '';
			$background_color     = isset($yolo_options['body_background']['background-color']) ? $yolo_options['body_background']['background-color'] : '';

			if (!empty($background_color)) {
				$background_image_css .= 'background-color:' . $background_color . ';';
			}

			if (!empty($background_image_url)) {
				$background_repeat     = isset($yolo_options['body_background']['background-repeat']) ? $yolo_options['body_background']['background-repeat'] : '';
				$background_position   = isset($yolo_options['body_background']['background-position']) ? $yolo_options['body_background']['background-position'] : '';
				$background_size       = isset($yolo_options['body_background']['background-size']) ? $yolo_options['body_background']['background-size'] : '';
				$background_attachment = isset($yolo_options['body_background']['background-attachment']) ? $yolo_options['body_background']['background-attachment'] : '';
				
				$background_image_css  .= 'background-image: url("'. $background_image_url .'");';


				if (!empty($background_repeat)) {
					$background_image_css .= 'background-repeat: '. $background_repeat .';';
				}

				if (!empty($background_position)) {
					$background_image_css .= 'background-position: '. $background_position .';';
				}

				if (!empty($background_size)) {
					$background_image_css .= 'background-size: '. $background_size .';';
				}

				if (!empty($background_attachment)) {
					$background_image_css .= 'background-attachment: '. $background_attachment .';';
				}
			}

		}

		if ($body_background_mode == 'pattern') {
			$background_image_url =  get_template_directory_uri() . '/assets/images/theme-options/' . $yolo_options['body_background_pattern'];
			$background_image_css .= 'background-image: url("'. $background_image_url .'");';
			$background_image_css .= 'background-repeat: repeat;';
			$background_image_css .= 'background-position: center center;';
			$background_image_css .= 'background-size: auto;';
			$background_image_css .= 'background-attachment: scroll;';
		}

		if (!empty($background_image_css)) {
			$custom_css.= 'body{'.$background_image_css.'}';
		}



		if (isset($yolo_options['custom_css'])) {
			$custom_css .=  $yolo_options['custom_css'];
		}

		$custom_css = str_replace( "\r\n", '', $custom_css );
		$custom_css = str_replace( "\n", '', $custom_css );
		$custom_css = str_replace( "\t", '', $custom_css );

		return $custom_css;
	}
}


// UNREGISTER CUSTOM POST TYPES
//--------------------------------------------------
if (!function_exists('yolo_unregister_post_type')) {
	function yolo_unregister_post_type( $post_type, $slug = '' ) {
		global $wp_post_types;
		$yolo_options = yolo_get_options();
		if ( isset( $yolo_options['cpt-disable'] ) ) {
			$cpt_disable = $yolo_options['cpt-disable'];
			if ( ! empty( $cpt_disable ) ) {
				foreach ( $cpt_disable as $post_type => $cpt ) {
					if ( $cpt == 1 && isset( $wp_post_types[ $post_type ] ) ) {
						unset( $wp_post_types[ $post_type ] );
					}
				}
			}
		}
	}
	add_action( 'init', 'yolo_unregister_post_type', 20 );
}

/* ajax */
if( !function_exists( 'yolo_ajax_get_sections' ) ) :
	function yolo_ajax_get_sections(){
		$yolo_option = get_option('yolo-graphsign-license-settings');
		$purchase_code = '';
		$install = '';
		if ( isset( $yolo_option ) && $yolo_option['license_key'] ) {
			$purchase_code = $yolo_option['license_key'];
		}
		if ( !empty( $_POST['install']) ) {
			$install .= '&install='.$_POST['install'];
		}
		if( !empty( $_POST['group_id'] ) ){
			$install .= '&group_id='.$_POST['group_id'];
		}

//		$URL = 'http://api.yolotheme.com/graphsign/yolo_sections.php?purchase_code='.$purchase_code.$install;
		$URL = 'http://dev.yolotheme.com/wordpress/api/motor/yolo_sections.php?purchase_code='.$purchase_code.$install;
		$data = wp_remote_fopen($URL);
		echo $data;
		exit;
	}

endif;

add_action( 'wp_ajax_yolo_ajax_get_sections', 'yolo_ajax_get_sections' );
add_action( 'wp_ajax_nopriv_yolo_ajax_get_sections', 'yolo_ajax_get_sections' );