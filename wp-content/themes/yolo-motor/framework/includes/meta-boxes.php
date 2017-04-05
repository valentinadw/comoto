<?php
/**
 *
 *	Meta Box Functions
 *	------------------------------------------------
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 * @see 		
*/
// global $meta_boxes;

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 * https://metabox.io/docs/registering-meta-boxes/
 * https://metabox.io/docs/filters/
 * https://metabox.io/docs/meta-box-conditional-logic/#section-the-example
 * @return void
 */
function yolo_register_meta_boxes() {
	// global $meta_boxes;
	$prefix = 'yolo_';
	/* PAGE MENU */
	$menu_list = array();
	if ( function_exists( 'yolo_get_menu_list' ) ) {
		$menu_list = yolo_get_menu_list();
	}
	/* PAGE SIDEBARS */
	$sidebar_list = array();
	if ( function_exists( 'yolo_get_sidebar_list' ) ) {
		$sidebar_list = yolo_get_sidebar_list();
	}

	// POST FORMAT: Image
	//--------------------------------------------------
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Image', 'yolo-motor' ),
		'id'         => $prefix .'meta_box_post_format_image',
		'post_types' => array('post'),
		'fields'     => array(
			array(
				'name'             => esc_html__('Image', 'yolo-motor'),
				'id'               => $prefix . 'post_format_image',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'desc'             => esc_html__( 'Select a image for post','yolo-motor' )
			),
		),
	);

	// POST FORMAT: Gallery
	//--------------------------------------------------
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Gallery', 'yolo-motor' ),
		'id'         => $prefix . 'meta_box_post_format_gallery',
		'post_types' => array('post'),
		'fields'     => array(
			array(
				'name' => esc_html__( 'Images', 'yolo-motor' ),
				'id'   => $prefix . 'post_format_gallery',
				'type' => 'image_advanced',
				'desc' => esc_html__( 'Select images gallery for post','yolo-motor' )
			),
		),
	);

	// POST FORMAT: Video
	//--------------------------------------------------
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Video', 'yolo-motor' ),
		'id'         => $prefix . 'meta_box_post_format_video',
		'post_types' => array('post'),
		'fields'     => array(
			array(
				'name' => esc_html__( 'Video URL or Embeded Code', 'yolo-motor' ),
				'id'   => $prefix . 'post_format_video',
				'type' => 'textarea',
			),
		),
	);

	// POST FORMAT: Audio
	//--------------------------------------------------
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Audio', 'yolo-motor' ),
		'id'         => $prefix . 'meta_box_post_format_audio',
		'post_types' => array('post'),
		'fields'     => array(
			array(
				'name' => esc_html__( 'Audio URL or Embeded Code', 'yolo-motor' ),
				'id'   => $prefix . 'post_format_audio',
				'type' => 'textarea',
			),
		),
	);

	// POST FORMAT: QUOTE
	//--------------------------------------------------
    $meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Quote', 'yolo-motor' ),
		'id'         => $prefix . 'meta_box_post_format_quote',
		'post_types' => array('post'),
		'fields'     => array(
            array(
                'name' => esc_html__( 'Quote', 'yolo-motor' ),
                'id'   => $prefix . 'post_format_quote',
                'type' => 'textarea',
            ),
            array(
                'name' => esc_html__( 'Author', 'yolo-motor' ),
                'id'   => $prefix . 'post_format_quote_author',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Author Url', 'yolo-motor' ),
                'id'   => $prefix . 'post_format_quote_author_url',
                'type' => 'url',
            ),
        ),
    );
    // POST FORMAT: LINK
	//--------------------------------------------------
    $meta_boxes[] = array(
		'title'      => esc_html__( 'Post Format: Link', 'yolo-motor' ),
		'id'         => $prefix . 'meta_box_post_format_link',
		'post_types' => array('post'),
		'fields'     => array(
            array(
                'name' => esc_html__( 'Url', 'yolo-motor' ),
                'id'   => $prefix . 'post_format_link_url',
                'type' => 'url',
            ),
            array(
                'name' => esc_html__( 'Text', 'yolo-motor' ),
                'id'   => $prefix . 'post_format_link_text',
                'type' => 'text',
            ),
        ),
    );

	// PAGE LAYOUT
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_layout_meta_box',
		'title'      => esc_html__( 'Page Layout', 'yolo-motor' ),
		'post_types' => array('post', 'page',  'yolo_portfolio','product'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Layout Style', 'yolo-motor' ),
				'id'      => $prefix . 'layout_style',
				'type'    => 'button_set',
				'options' => array(
					'-1'    => esc_html__( 'Default','yolo-motor' ),
					'boxed' => esc_html__( 'Boxed','yolo-motor' ),
					'wide'  => esc_html__( 'Wide','yolo-motor' ),
					'float' => esc_html__( 'Float','yolo-motor' )
				),
				'std'      => '-1',
				'multiple' => false,
			),
			array(
				'name'    => esc_html__( 'Page Layout', 'yolo-motor' ),
				'id'      => $prefix . 'page_layout',
				'type'    => 'button_set',
				'options' => array(
					'-1'              => esc_html__( 'Default','yolo-motor' ),
					'full'            => esc_html__( 'Full Width','yolo-motor' ),
					'container'       => esc_html__( 'Container','yolo-motor' ),
					'container-fluid' => esc_html__( 'Container Fluid','yolo-motor' ),
				),
				'std'      => '-1',
				'multiple' => false,
			),
			// Add to fix page background color
			array(
				'name'           => esc_html__( 'Page background color', 'yolo-motor' ),
				'id'             => $prefix . 'page_background_color',
				'desc'           => esc_html__( "Optionally set background color for the page.", 'yolo-motor' ),
				'type'           => 'color',
				'std'            => '',
			),
			array(
				'name'       => esc_html__( 'Page Sidebar', 'yolo-motor' ),
				'id'         => $prefix . 'page_sidebar',
				'type'       => 'image_set',
				'allowClear' => true,
				'options'    => array(
					'none'	  => get_template_directory_uri().'/assets/images/theme-options/sidebar-none.png',
					'left'	  => get_template_directory_uri().'/assets/images/theme-options/sidebar-left.png',
					'right'	  => get_template_directory_uri().'/assets/images/theme-options/sidebar-right.png',
					'both'	  => get_template_directory_uri().'/assets/images/theme-options/sidebar-both.png'
				),
				'std'      => '',
				'multiple' => false,

			),

			array(
				'name'           => esc_html__( 'Left Sidebar', 'yolo-motor' ),
				'id'             => $prefix . 'page_left_sidebar',
				'type'           => 'select',
				'options'        => $sidebar_list,
				'placeholder'    => esc_html__( 'Select Sidebar','yolo-motor' ),
				'std'            => '',
				'hidden' => array( $prefix . 'page_sidebar', 'not in', array('','left','both') )
			),

			array(
				'name'           => esc_html__( 'Right Sidebar', 'yolo-motor' ),
				'id'             => $prefix . 'page_right_sidebar',
				'type'           => 'select',
				'options'        => $sidebar_list,
				'placeholder'    => esc_html__( 'Select Sidebar','yolo-motor' ),
				'std'            => '',
				'hidden' => array( $prefix . 'page_sidebar', 'not in', array('','right','both') )
			),

			array(
				'name'    => esc_html__( 'Sidebar Width', 'yolo-motor' ),
				'id'      => $prefix . 'sidebar_width',
				'type'    => 'button_set',
				'options' => array(
					'-1'    => esc_html__( 'Default','yolo-motor' ),
					'small' => esc_html__( 'Small (1/4)','yolo-motor' ),
					'large' => esc_html__( 'Large (1/3)','yolo-motor' )
				),
				'std'            => '-1',
				'multiple'       => false,
				'hidden' => array( $prefix . 'page_sidebar', '=', 'none' )
			),

			array(
				'name' 	=> esc_html__( 'Page Class Extra', 'yolo-motor' ),
				'id' 	=> $prefix . 'page_class_extra',
				'type' 	=> 'text',
				'std' 	=> ''
			),
		)
	);

	// PAGE COLOR
	// $meta_boxes[] = array(
	// 	'id'         => $prefix . 'page_color_meta_box',
	// 	'title'      => esc_html__( 'Page Color', 'yolo-motor' ),
	// 	'post_types' => array('post', 'page',  'yolo_portfolio','product'),
	// 	'tab'        => true,
	// 	'fields'     => array(
	// 		array(
	// 			'name' => esc_html__( 'Customize Page Color?', 'yolo-motor' ),
	// 			'id'   => $prefix . 'enable_page_color',
	// 			'desc' => esc_html__( "Maybe you need regenerate CSS at Theme Options to make change.", 'yolo-motor' ),
	// 			'type' => 'checkbox_advanced',
	// 			'std'  => 0,
	// 		),
	// 		array(
	// 			'name'   => esc_html__( 'Primary color', 'yolo-motor' ),
	// 			'id'     => $prefix . 'primary_color',
	// 			'desc'   => esc_html__( "Optionally set a primary color for the page.", 'yolo-motor' ),
	// 			'type'   => 'color',
	// 			'std'    => '',
	// 			'hidden' => array( $prefix . 'enable_page_color', '!=', '1' )
	// 		),
	// 		array(
	// 			'name'   => esc_html__( 'Link color', 'yolo-motor' ),
	// 			'id'     => $prefix . 'link_color',
	// 			'desc'   => esc_html__( "Optionally set a link color for the page.", 'yolo-motor' ),
	// 			'type'   => 'color',
	// 			'std'    => '',
	// 			'hidden' => array( $prefix . 'enable_page_color', '!=', '1' )
	// 		),
	// 		array(
	// 			'name'   => esc_html__( 'Link color hover', 'yolo-motor' ),
	// 			'id'     => $prefix . 'link_color_hover',
	// 			'desc'   => esc_html__( "Optionally set a link color hover for the page.", 'yolo-motor' ),
	// 			'type'   => 'color',
	// 			'std'    => '',
	// 			'hidden' => array( $prefix . 'enable_page_color', '!=', '1' )
	// 		),
	// 		array(
	// 			'name'   => esc_html__( 'Link color active', 'yolo-motor' ),
	// 			'id'     => $prefix . 'link_color_active',
	// 			'desc'   => esc_html__( "Optionally set a link color active for the page.", 'yolo-motor' ),
	// 			'type'   => 'color',
	// 			'std'    => '',
	// 			'hidden' => array( $prefix . 'enable_page_color', '!=', '1' )
	// 		),

	// 		array(
	// 			'name'   => esc_html__( 'Top bar text color', 'yolo-motor' ),
	// 			'id'     => $prefix . 'top_bar_text_color',
	// 			'desc'   => esc_html__( "Set top bar text color.", 'yolo-motor' ),
	// 			'type'   => 'color',
	// 			'std'    => '#878787',
	// 			'hidden' => array( $prefix . 'enable_page_color', '!=', '1' )
	// 		),
	// 		array(
	// 			'name'   => esc_html__( 'Top bar background color', 'yolo-motor' ),
	// 			'id'     => $prefix . 'top_bar_bg_color',
	// 			'desc'   => esc_html__( "Set top bar background color.", 'yolo-motor' ),
	// 			'type'   => 'color',
	// 			'std'    => '#f9f9f9',
	// 			'hidden' => array( $prefix . 'enable_page_color', '!=', '1' )
	// 		),
	// 		array(
	// 			'name'       => esc_html__( 'Top bar background color opacity', 'yolo-motor' ),
	// 			'id'         => $prefix .'top_bar_bg_color_opacity',
	// 			'desc'       => esc_html__( 'Set the opacity level of the top bar background color', 'yolo-motor' ),
	// 			'clone'      => false,
	// 			'type'       => 'slider',
	// 			'prefix'     => '',
	// 			'std'        => '100',
	// 			'js_options' => array(
	// 				'min'  => 0,
	// 				'max'  => 100,
	// 				'step' => 1,
	// 			),
	// 			'hidden' => array( $prefix . 'enable_page_color', '!=', '1' )
	// 		),
	
	// 	)
	// );

	// PAGE TOP
	$meta_boxes[] = array(
		'id'         => $prefix . 'site_top_meta_box',
		'title'      => esc_html__( 'Page Top', 'yolo-motor' ),
		'post_types' => array('post', 'page',  'yolo_portfolio','product'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Show/Hide Top Bar', 'yolo-motor' ),
				'id'      => $prefix . 'top_bar',
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1' => esc_html__( 'Default','yolo-motor' ),
					'1'  => esc_html__( 'Show','yolo-motor' ),
					'0'  => esc_html__( 'Hide','yolo-motor' )
				),
			),
			array(
				'id'      => $prefix . 'top_bar_layout_width',
				'name'    => esc_html__( 'Top bar layout width', 'yolo-motor' ),
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1'           => esc_html__( 'Default', 'yolo-motor' ),
					'container'    => esc_html__( 'Container', 'yolo-motor' ),
					'topbar-fullwith' => esc_html__( 'Full width', 'yolo-motor' ),
				),
				'visible' => array( $prefix . 'top_bar', '!=', '0' )
			),
			array(
				'id'         => $prefix .'top_bar_layout_padding',
				'name'       => esc_html__( 'Top bar padding left/right (px)', 'yolo-motor' ),
				'clone'      => false,
				'type'       => 'slider',
				'prefix'     => '',
				'js_options' => array(
					'min'  => 0,
					'max'  => 200,
					'step' => 1,
				),
				'std'            => '100',
				'visible' => array( $prefix . 'top_bar_layout_width', '=', 'topbar-fullwith' )
			),
			array(
				'name'       => esc_html__( 'Top Bar Layout', 'yolo-motor' ),
				'id'         => $prefix . 'top_bar_layout',
				'type'       => 'image_set',
				'allowClear' => true,
				'width'      => '80px',
				'std'        => '',
				'options'    => array(
					'top-bar-1' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-1.jpg',
					'top-bar-2' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-2.jpg',
					'top-bar-3' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-3.jpg',
					'top-bar-4' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-4.jpg'
				),
				'visible' => array( $prefix . 'top_bar', '!=', '0' )
			),

			array(
				'name'           => esc_html__( 'Top Left Sidebar', 'yolo-motor' ),
				'id'             => $prefix . 'top_left_sidebar',
				'type'           => 'select',
				'options'        => $sidebar_list,
				'std'            => '',
				'placeholder'    => esc_html__( 'Select Sidebar', 'yolo-motor' ),
				'multiple'       => false,
				'hidden' => array( $prefix . 'top_bar_layout', 'not in', array('top-bar-1','top-bar-3') )
			),

			array(
				'name'           => esc_html__( 'Top Right Sidebar', 'yolo-motor' ),
				'id'             => $prefix . 'top_right_sidebar',
				'type'           => 'select',
				'options'        => $sidebar_list,
				'std'            => '',
				'placeholder'    => esc_html__( 'Select Sidebar','yolo-motor' ),
				'hidden' => array( $prefix . 'top_bar_layout', 'not in', array('top-bar-1','top-bar-2') )
			),

			array(
				'name'           => esc_html__( 'Top Center Sidebar', 'yolo-motor' ),
				'id'             => $prefix . 'top_center_sidebar',
				'type'           => 'select',
				'options'        => $sidebar_list,
				'std'            => '',
				'placeholder'    => esc_html__( 'Select Sidebar','yolo-motor' ),
				'hidden' => array( $prefix . 'top_bar_layout', '!=', 'top-bar-4' )
			),
			array (
				'name' 	=> esc_html__('Top Bar Scheme', 'yolo-motor'),
				'id' 	=> $prefix . 'top-bar-scheme-section',
				'type' 	=> 'section',
			),
			array(
				'name' => esc_html__( 'Customize Top Bar Color?', 'yolo-motor' ),
				'id'   => $prefix . 'enable_topbar_color',
				'type' => 'checkbox_advanced',
				'std'  => 0,
				'visible' => array( $prefix . 'top_bar', '!=', '0' )
			),
			array(
				'name'   => esc_html__( 'Top bar text color', 'yolo-motor' ),
				'id'     => $prefix . 'top_bar_text_color',
				'desc'   => esc_html__( "Set top bar text color.", 'yolo-motor' ),
				'type'   => 'color',
				'std'    => '',
				'hidden' => array( $prefix . 'enable_topbar_color', '!=', '1' )
			),
			array(
				'name'   => esc_html__( 'Top bar background color', 'yolo-motor' ),
				'id'     => $prefix . 'top_bar_bg_color',
				'desc'   => esc_html__( "Set top bar background color.", 'yolo-motor' ),
				'type'   => 'color',
				'std'    => '',
				'hidden' => array( $prefix . 'enable_topbar_color', '!=', '1' )
			),
			array(
				'name'       => esc_html__( 'Top bar background color opacity', 'yolo-motor' ),
				'id'         => $prefix .'top_bar_bg_color_opacity',
				'desc'       => esc_html__( 'Set the opacity level of the top bar background color', 'yolo-motor' ),
				'clone'      => false,
				'type'       => 'slider',
				'prefix'     => '',
				'std'        => '',
				'js_options' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'hidden' => array( $prefix . 'enable_topbar_color', '!=', '1' )
			),
		)
	);

	// PAGE HEADER
	//--------------------------------------------------
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_header_meta_box',
		'title'      => esc_html__( 'Page Header', 'yolo-motor' ),
		'post_types' => array('post', 'page',  'yolo_portfolio','product'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name' => esc_html__( 'Header On/Off?', 'yolo-motor' ),
				'id'   => $prefix . 'header_show_hide',
				'type' => 'checkbox_advanced',
				'desc' => esc_html__( "Switch header ON or OFF?", 'yolo-motor' ),
				'std'  => '1',
			),

			array(
				'name' => esc_html__( 'Header Customize On/Off?', 'yolo-motor' ),
				'id'   => $prefix . 'header_customize',
				'type' => 'checkbox_advanced',
				'desc' => esc_html__( "Switch header customize ON or OFF?", 'yolo-motor' ),
				'std'  => '0',
			),

			array(
				'name'       => esc_html__( 'Header Layout', 'yolo-motor' ),
				'id'         => $prefix . 'header_layout',
				'type'       => 'image_set',
				'allowClear' => true,
				'std'        => '',
				'options'    => array(
					'header-2'       => get_template_directory_uri().'/assets/images/theme-options/header_2.jpg',
					'header-1'       => get_template_directory_uri().'/assets/images/theme-options/header_1.jpg',
					'header-3'       => get_template_directory_uri().'/assets/images/theme-options/header_3.jpg',
					'header-4'       => get_template_directory_uri().'/assets/images/theme-options/header_4.jpg',
					'header-6'       => get_template_directory_uri().'/assets/images/theme-options/header_6.jpg',
					'header-8'       => get_template_directory_uri().'/assets/images/theme-options/header_8.jpg',
					'header-sidebar' => get_template_directory_uri().'/assets/images/theme-options/header_sidebar.jpg',
				),
				'hidden' => array( $prefix . 'header_customize', '!=', '1' )
			),

			array (
				'name' 	=> esc_html__('Header Scheme', 'yolo-motor'),
				'id' 	=> $prefix . 'header-scheme-section',
				'type' 	=> 'section',
				'hidden' => array( $prefix . 'show_page_title', '!=', '1' )
			),

			array(
				'id'      => $prefix . 'header_scheme',
				'name'    => esc_html__( 'Header scheme', 'yolo-motor' ),
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1'          => esc_html__( 'Default','yolo-motor' ),
					'customize'   => esc_html__( 'Customize','yolo-motor' ),
				),
				'hidden' => array( $prefix . 'header_customize', '!=', '1' )
			),
			// Header scheme childs
			array(
				'id'             => $prefix . 'header_border_color',
				'name'           => esc_html__( 'Header border color', 'yolo-motor' ),
				'desc'           => esc_html__( "Set header border color.", 'yolo-motor' ),
				'type'           => 'color',
				'std'            => '',
				'hidden' => array( $prefix . 'header_scheme', '!=', 'customize' )
			),

			array(
				'id'         => $prefix .'header_border_color_opacity',
				'name'       => esc_html__( 'Header border color opacity', 'yolo-motor' ),
				'desc'       => esc_html__( 'Set the opacity level of the header border color', 'yolo-motor' ),
				'clone'      => false,
				'type'       => 'slider',
				'prefix'     => '',
				'std'        => '100',
				'js_options' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'hidden' => array( $prefix . 'header_scheme', '!=', 'customize' )
			),

			array(
				'id'             => $prefix . 'header_text_color',
				'name'           => esc_html__( 'Header text color', 'yolo-motor' ),
				'desc'           => esc_html__( "Set header border color.", 'yolo-motor' ),
				'type'           => 'color',
				'std'            => '',
				'hidden' => array( $prefix . 'header_scheme', '!=', 'customize' )
			),

			array(
				'id'             => $prefix . 'header_background_color',
				'name'           => esc_html__( 'Header background color', 'yolo-motor' ),
				'desc'           => esc_html__( "Set header background color.", 'yolo-motor' ),
				'type'           => 'color',
				'std'            => '',
				'hidden' => array( $prefix . 'header_scheme', '!=', 'customize' )
			),

			array(
				'id'         => $prefix .'header_background_color_opacity',
				'name'       => esc_html__( 'Header background color opacity', 'yolo-motor' ),
				'desc'       => esc_html__( 'Set the opacity level of the header background color', 'yolo-motor' ),
				'clone'      => false,
				'type'       => 'slider',
				'prefix'     => '',
				'std'        => '100',
				'js_options' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'hidden' => array( $prefix . 'header_scheme', '!=', 'customize' )
			),

			array(
				'id'               => $prefix.  'header_background_image',
				'name'             => esc_html__( 'Header Background Image', 'yolo-motor' ),
				'desc'             => esc_html__( 'Set header background image', 'yolo-motor' ),
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'std'              => '',
				'hidden' => array( $prefix . 'header_scheme', '!=', 'customize' )
			),

			array(
				'id'          => $prefix.  'header_background_repeat',
				'name'        => esc_html__( 'Header Background Repeat', 'yolo-motor' ),
				'desc'        => esc_html__( 'Set header background repeat', 'yolo-motor' ),
				'type'        => 'select',
				'placeholder' => esc_html__( 'Background Repeat','yolo-motor' ),
				'std'         => '',
				'options'     => array(
					'no-repeat' => esc_html__( 'No Repeat','yolo-motor' ),
					'repeat'    => esc_html__( 'Repeat','yolo-motor' ),
					'repeat-x'  => esc_html__( 'Repeat-x','yolo-motor' ),
					'repeat-y'  => esc_html__( 'Repeat-y','yolo-motor' ),
					'inherit'   => esc_html__( 'Inherit','yolo-motor' ),
				),
				'hidden' => array( $prefix . 'header_scheme', '!=', 'customize' )
			),

			array(
				'id'          => $prefix.  'header_background_size',
				'name'        => esc_html__( 'Header Background Size', 'yolo-motor' ),
				'desc'        => esc_html__( 'Set header background size', 'yolo-motor' ),
				'type'        => 'select',
				'placeholder' => esc_html__( 'Background size','yolo-motor' ),
				'std'         => '',
				'options'     => array(
					'inherit' => esc_html__( 'Inherit','yolo-motor' ),
					'cover'   => esc_html__( 'Cover','yolo-motor' ),
					'contain' => esc_html__( 'Contain','yolo-motor' ),
				),
				'hidden' => array( $prefix . 'header_scheme', '!=', 'customize' )
			),

			array(
				'id'          => $prefix.  'header_background_attachment',
				'name'        => esc_html__( 'Header Background Attachment', 'yolo-motor' ),
				'desc'        => esc_html__( 'Set header background attachment', 'yolo-motor' ),
				'type'        => 'select',
				'placeholder' => esc_html__( 'Background attachment','yolo-motor' ),
				'std'         => '',
				'options'     => array(
					'fixed'   => esc_html__( 'Fixed','yolo-motor' ),
					'scroll'  => esc_html__( 'Scroll','yolo-motor' ),
					'inherit' => esc_html__( 'Inherit','yolo-motor' ),
				),
				'hidden' => array( $prefix . 'header_scheme', '!=', 'customize' )
			),

			array(
				'id'          => $prefix.  'header_background_position',
				'name'        => esc_html__( 'Header Background Position', 'yolo-motor' ),
				'desc'        => esc_html__( 'Set header background position', 'yolo-motor' ),
				'type'        => 'select',
				'placeholder' => esc_html__( 'Background position', 'yolo-motor' ),
				'std'         => '',
				'options'     => array(
					'left top'      => esc_html__( 'Left top', 'yolo-motor' ),
					'left center'   => esc_html__( 'Left center', 'yolo-motor' ),
					'left bottom'   => esc_html__( 'Left bottom', 'yolo-motor' ),
					'center top'    => esc_html__( 'Center top', 'yolo-motor' ),
					'center center' => esc_html__( 'Center center', 'yolo-motor' ),
					'center bottom' => esc_html__( 'Center bottom', 'yolo-motor' ),
					'right top'     => esc_html__( 'Right top', 'yolo-motor' ),
					'right center'  => esc_html__( 'Right center', 'yolo-motor' ),
					'right bottom'  => esc_html__( 'Right bottom', 'yolo-motor' ),
				),
				'hidden' => array( $prefix . 'header_scheme', '!=', 'customize' )
			),
			// End Header scheme childs
			
			array (
				'name' 	=> esc_html__('Header Navigation', 'yolo-motor'),
				'id' 	=> $prefix . 'header-navigation-section',
				'type' 	=> 'section',
				'hidden' => array( $prefix . 'show_page_title', '!=', '1' )
			), 

			array(
				'id'      => $prefix . 'header_nav_layout',
				'name'    => esc_html__( 'Header navigation layout', 'yolo-motor' ),
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1'           => esc_html__( 'Default', 'yolo-motor' ),
					'container'    => esc_html__( 'Container', 'yolo-motor' ),
					'nav-fullwith' => esc_html__( 'Full width', 'yolo-motor' ),
				),
				'hidden' => array( $prefix . 'header_customize', '!=', '1' )
			),

			array(
				'id'         => $prefix .'header_nav_layout_padding',
				'name'       => esc_html__( 'Header navigation padding left/right (px)', 'yolo-motor' ),
				'clone'      => false,
				'type'       => 'slider',
				'prefix'     => '',
				'js_options' => array(
					'min'  => 0,
					'max'  => 200,
					'step' => 1,
				),
				'std'            => '100',
				'hidden' => array( $prefix . 'header_nav_layout', '!=', 'nav-fullwith' )
			),

			array(
				'id'      => $prefix . 'header_nav_hover',
				'name'    => esc_html__( 'Header navigation hover', 'yolo-motor' ),
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1'                     => esc_html__( 'Default', 'yolo-motor' ),
					'nav-hover-primary'      => 'Primary Color',
					'nav-hover-primary-base' => 'Base Primary Color'
				),
				'hidden' => array( $prefix . 'header_customize', '!=', '1' )
			),

			array(
				'id'   => $prefix . 'header_nav_distance',
				'type' => 'text',
				'name' => esc_html__( 'Header navigation distance', 'yolo-motor' ),
				'desc' => esc_html__( 'You can set distance between navigation items. Empty value to default', 'yolo-motor' ),
				'std'  => '',
				'hidden' => array( $prefix . 'header_customize', '!=', '1' )
			),

			array(
				'id'      => $prefix . 'header_nav_scheme',
				'name'    => esc_html__( 'Header navigation scheme', 'yolo-motor' ),
				'type'    => 'button_set',
				'desc'    => esc_html__("Set header navigation scheme", 'yolo-motor'),
				'std'     => '-1',
				'options' => array(
					'-1'            => esc_html__( 'Default', 'yolo-motor' ),
					'customize'     => esc_html__( 'Customize', 'yolo-motor' )
				),
				'hidden' => array( $prefix . 'header_customize', '!=', '1' )
			),

			array(
				'name'           => esc_html__( 'Header navigation background color', 'yolo-motor' ),
				'id'             => $prefix . 'header_nav_bg_color_color',
				'desc'           => esc_html__( "Set header navigation background color.", 'yolo-motor' ),
				'type'           => 'color',
				'std'            => '',
				'hidden' => array( $prefix . 'header_nav_scheme', '!=', 'customize' )
			),

			array(
				'name'       => esc_html__( 'Overlay Opacity', 'yolo-motor' ),
				'id'         => $prefix .'header_nav_bg_color_opacity',
				'desc'       => esc_html__( 'Set the opacity level of the header navigation background color', 'yolo-motor' ),
				'clone'      => false,
				'type'       => 'slider',
				'prefix'     => '',
				'js_options' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'hidden' => array( $prefix . 'header_nav_scheme', '!=', 'customize' )
			),

			array(
				'name'           => esc_html__( 'Header navigation text color', 'yolo-motor' ),
				'id'             => $prefix . 'header_nav_text_color',
				'desc'           => esc_html__( "Set header navigation text color.", 'yolo-motor' ),
				'type'           => 'color',
				'std'            => '',
				'hidden' => array( $prefix . 'header_nav_scheme', '!=', 'customize' )
			),

			array(
				'name'    => esc_html__( 'Header Float', 'yolo-motor' ),
				'id'      => $prefix . 'header_layout_float',
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1' => esc_html__( 'Default','yolo-motor' ),
					'1'  => esc_html__( 'Enable','yolo-motor' ),
					'0'  => esc_html__( 'Disable','yolo-motor' )
				),
				'desc' => esc_html__( 'Enable/disable header float.', 'yolo-motor' ),
				'hidden' => array( $prefix . 'header_customize', '!=', '1' )
			),

			array(
				'name'    => esc_html__( 'Header Sticky', 'yolo-motor' ),
				'id'      => $prefix . 'header_sticky',
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1' => esc_html__( 'Default', 'yolo-motor' ),
					'1'  => esc_html__( 'Enable Header Sticky', 'yolo-motor' ),
					'0'  => esc_html__( 'Disable Header Sticky', 'yolo-motor' ),
				),
				'hidden' => array( $prefix . 'header_customize', '!=', '1' )
			),

			array(
				'name'    => esc_html__( 'Header sticky scheme', 'yolo-motor' ),
				'id'      => $prefix . 'header_sticky_scheme',
				'type'    => 'button_set',
				'options' => array(
					'-1'      => esc_html__( 'Default', 'yolo-motor' ),
					'inherit' => esc_html__( 'Inherit', 'yolo-motor' ),
					'gray'    => esc_html__( 'Gray', 'yolo-motor' ),
					'light'   => esc_html__( 'Light', 'yolo-motor' ),
					'dark'    => esc_html__( 'Dark', 'yolo-motor' )
				),
				'std'  => '-1',
				'hidden' => array( $prefix . 'header_customize', '!=', '1' )
			),
		)
	);

	// HEADER CUSTOMIZE
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_header_customize_meta_box',
		'title'      => esc_html__( 'Page Header Customize', 'yolo-motor' ),
		'post_types' => array('post', 'page',  'yolo_portfolio','product'),
		'tab'        => true,
		'fields'     => array(

			array (
				'name' 	=> esc_html__('Header Customize Navigation', 'yolo-motor'),
				'id' 	=> $prefix . 'header-customize-navigation-section',
				'type' 	=> 'section',
			),

			array(
				'name'  => esc_html__( 'Set header customize navigation?', 'yolo-motor' ),
				'id'    => $prefix . 'enable_header_customize_nav',
				'type'  => 'checkbox_advanced',
				'std'	=> 0,
			),

			array(
				'name'    => esc_html__( 'Header Customize Navigation', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_nav',
				'type'    => 'sorter',
				'std'     => '',
				'desc'    => esc_html__( 'Select element for header customize navigation. Drag to change element order', 'yolo-motor' ),
				'options' => array(
					'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-motor' ),
					'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-motor' ),
					'search-button'        => esc_html__( 'Search Button', 'yolo-motor' ),
					'search-box'           => esc_html__( 'Search Box', 'yolo-motor' ),
					'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-motor' ),
					'social-profile'       => esc_html__( 'Social Profile', 'yolo-motor'),
					'wishlist'             => esc_html__( 'Wishlist', 'yolo-motor' ),
					'custom-text'          => esc_html__( 'Custom Text', 'yolo-motor' ),
					'canvas-menu'          => esc_html__( 'Canvas Menu', 'yolo-motor' ),
				),
				'hidden' => array( $prefix . 'enable_header_customize_nav', '!=', '1' )
			),

			array(
				'name'    => esc_html__( 'Search button style', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_nav_search_button_style',
				'type'    => 'button_set',
				'std'     => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'yolo-motor' ),
					'round'    => esc_html__( 'Round', 'yolo-motor' ),
					'bordered' => esc_html__( 'Bordered', 'yolo-motor' ),
				),
			),
			array(
				'name'    => esc_html__( 'Shopping cart Style', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_nav_shopping_cart_style',
				'type'    => 'button_set',
				'std'     => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default','yolo-motor' ),
					'round'    => esc_html__( 'Round','yolo-motor' ),
					'bordered' => esc_html__( 'Bordered','yolo-motor' ),
				),
			),
			array(
				'name'        => esc_html__( 'Custom social profiles', 'yolo-motor' ),
				'id'          => $prefix . 'header_customize_nav_social_profile',
				'type'        => 'select_advanced',
				'placeholder' => esc_html__( 'Select social profiles', 'yolo-motor' ),
				'std'         => '',
				'multiple'    => true,
				'options'     => array(
					'twitter'    => esc_html__( 'Twitter', 'yolo-motor' ),
					'facebook'   => esc_html__( 'Facebook', 'yolo-motor' ),
					'dribbble'   => esc_html__( 'Dribbble', 'yolo-motor' ),
					'vimeo'      => esc_html__( 'Vimeo', 'yolo-motor' ),
					'tumblr'     => esc_html__( 'Tumblr', 'yolo-motor' ),
					'skype'      => esc_html__( 'Skype', 'yolo-motor' ),
					'linkedin'   => esc_html__( 'LinkedIn', 'yolo-motor' ),
					'googleplus' => esc_html__( 'Google+', 'yolo-motor' ),
					'flickr'     => esc_html__( 'Flickr', 'yolo-motor' ),
					'youtube'    => esc_html__( 'YouTube', 'yolo-motor' ),
					'pinterest'  => esc_html__( 'Pinterest', 'yolo-motor' ),
					'foursquare' => esc_html__( 'Foursquare', 'yolo-motor' ),
					'instagram'  => esc_html__( 'Instagram', 'yolo-motor' ),
					'github'     => esc_html__( 'GitHub', 'yolo-motor' ),
					'xing'       => esc_html__( 'Xing', 'yolo-motor' ),
					'behance'    => esc_html__( 'Behance', 'yolo-motor' ),
					'deviantart' => esc_html__( 'Deviantart', 'yolo-motor' ),
					'soundcloud' => esc_html__( 'SoundCloud', 'yolo-motor' ),
					'yelp'       => esc_html__( 'Yelp', 'yolo-motor' ),
					'rss'        => esc_html__( 'RSS Feed', 'yolo-motor' ),
					'email'      => esc_html__( 'Email address', 'yolo-motor' ),
				),
			),
			array(
				'name'           => esc_html__( 'Custom text content', 'yolo-motor' ),
				'id'             => $prefix . 'header_customize_nav_text',
				'type'           => 'textarea',
				'std'            => '',
				'required-field' => array($prefix . 'enable_header_customize_nav','=','1'),
			),
			array(
				'name'    => esc_html__( 'Header customize separate', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_nav_separate',
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1' => esc_html__( 'Default','yolo-motor' ),
					'0'  => esc_html__( 'Off','yolo-motor' ),
					'1'  => esc_html__( 'On','yolo-motor' ),
				),
			),

			array (
				'name' 	=> esc_html__('Header Customize Left', 'yolo-motor'),
				'id' 	=> $prefix . 'header-customize-left-section',
				'type' 	=> 'section',
			), 

			array(
				'name'  => esc_html__( 'Set header customize left?', 'yolo-motor' ),
				'id'    => $prefix . 'enable_header_customize_left',
				'type'  => 'checkbox_advanced',
				'std'	=> 0,
			),
			array(
				'name'    => esc_html__( 'Header Customize Left', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_left',
				'type'    => 'sorter',
				'std'     => '',
				'desc'    => esc_html__( 'Select element for header customize left. Drag to change element order', 'yolo-motor' ),
				'options' => array(
					'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-motor' ),
					'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-motor' ),
					'search-button'        => esc_html__( 'Search Button', 'yolo-motor' ),
					'search-box'           => esc_html__( 'Search Box', 'yolo-motor' ),
					'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-motor' ),
					'social-profile'       => esc_html__( 'Social Profile', 'yolo-motor' ),
					'wishlist'             => esc_html__( 'Wishlist', 'yolo-motor' ),
					'custom-text'          => esc_html__( 'Custom Text', 'yolo-motor' ),
					'canvas-menu'          => esc_html__( 'Canvas Menu', 'yolo-motor' ),
				),
				'hidden' => array( $prefix . 'enable_header_customize_left', '!=', '1' )
			),
			array(
				'name'    => esc_html__( 'Search button style', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_left_search_button_style',
				'type'    => 'button_set',
				'std'     => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'yolo-motor' ),
					'round'    => esc_html__( 'Round', 'yolo-motor' ),
					'bordered' => esc_html__( 'Bordered', 'yolo-motor' ),
				),
			),
			array(
				'name'    => esc_html__( 'Shopping cart Style', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_left_shopping_cart_style',
				'type'    => 'button_set',
				'std'     => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'yolo-motor' ),
					'round'    => esc_html__( 'Round', 'yolo-motor' ),
					'bordered' => esc_html__( 'Bordered', 'yolo-motor' ),
				),
			),
			array(
				'name'        => esc_html__( 'Custom social profiles left', 'yolo-motor' ),
				'id'          => $prefix . 'header_customize_left_social_profile',
				'type'        => 'select_advanced',
				'placeholder' => esc_html__( 'Select social profiles','yolo-motor' ),
				'std'         => '',
				'multiple'    => true,
				'options'     => array(
					'twitter'    => esc_html__( 'Twitter', 'yolo-motor' ),
					'facebook'   => esc_html__( 'Facebook', 'yolo-motor' ),
					'dribbble'   => esc_html__( 'Dribbble', 'yolo-motor' ),
					'vimeo'      => esc_html__( 'Vimeo', 'yolo-motor' ),
					'tumblr'     => esc_html__( 'Tumblr', 'yolo-motor' ),
					'skype'      => esc_html__( 'Skype', 'yolo-motor' ),
					'linkedin'   => esc_html__( 'LinkedIn', 'yolo-motor' ),
					'googleplus' => esc_html__( 'Google+', 'yolo-motor' ),
					'flickr'     => esc_html__( 'Flickr', 'yolo-motor' ),
					'youtube'    => esc_html__( 'YouTube', 'yolo-motor' ),
					'pinterest'  => esc_html__( 'Pinterest', 'yolo-motor' ),
					'foursquare' => esc_html__( 'Foursquare', 'yolo-motor' ),
					'instagram'  => esc_html__( 'Instagram', 'yolo-motor' ),
					'github'     => esc_html__( 'GitHub', 'yolo-motor' ),
					'xing'       => esc_html__( 'Xing', 'yolo-motor' ),
					'behance'    => esc_html__( 'Behance', 'yolo-motor' ),
					'deviantart' => esc_html__( 'Deviantart', 'yolo-motor' ),
					'soundcloud' => esc_html__( 'SoundCloud', 'yolo-motor' ),
					'yelp'       => esc_html__( 'Yelp', 'yolo-motor' ),
					'rss'        => esc_html__( 'RSS Feed', 'yolo-motor' ),
					'email'      => esc_html__( 'Email address', 'yolo-motor' ),
				),
			),
			array(
				'name'           => esc_html__( 'Custom text content left', 'yolo-motor' ),
				'id'             => $prefix . 'header_customize_left_text',
				'type'           => 'textarea',
				'std'            => '',
			),
			array(
				'name'    => esc_html__( 'Header customize separate', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_left_separate',
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1' => esc_html__( 'Default', 'yolo-motor' ),
					'0'  => esc_html__( 'Off', 'yolo-motor' ),
					'1'  => esc_html__( 'On', 'yolo-motor' ),
				),
			),
			// Header customize right
			array (
				'name' 	=> esc_html__('Header Customize Right', 'yolo-motor'),
				'id' 	=> $prefix . 'header-customize-right-section',
				'type' 	=> 'section',
			), 
			array(
				'name'  => esc_html__( 'Set header customize right?', 'yolo-motor' ),
				'id'    => $prefix . 'enable_header_customize_right',
				'type'  => 'checkbox_advanced',
				'std'	=> 0,
			),
			array(
				'name'    => esc_html__( 'Header Customize Right', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_right',
				'type'    => 'sorter',
				'std'     => '',
				'desc'    => esc_html__( 'Select element for header customize right. Drag to change element order', 'yolo-motor' ),
				'options' => array(
					'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-motor' ),
					'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-motor' ),
					'search-button'        => esc_html__( 'Search Button', 'yolo-motor' ),
					'search-box'           => esc_html__( 'Search Box', 'yolo-motor' ),
					'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-motor' ),
					'social-profile'       => esc_html__( 'Social Profile', 'yolo-motor' ),
					'wishlist'             => esc_html__( 'Wishlist', 'yolo-motor' ),
					'custom-text'          => esc_html__( 'Custom Text', 'yolo-motor' ),
					'canvas-menu'          => esc_html__( 'Canvas Menu', 'yolo-motor' ),
				),
				'hidden' => array( $prefix . 'enable_header_customize_right', '!=', '1' )
			),
			array(
				'name'    => esc_html__( 'Search button style', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_right_search_button_style',
				'type'    => 'button_set',
				'std'     => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'yolo-motor' ),
					'round'    => esc_html__( 'Round', 'yolo-motor' ),
					'bordered' => esc_html__( 'Bordered', 'yolo-motor' ),
				),
			),
			array(
				'name'    => esc_html__( 'Shopping cart Style', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_right_shopping_cart_style',
				'type'    => 'button_set',
				'std'     => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'yolo-motor' ),
					'round'    => esc_html__( 'Round', 'yolo-motor' ),
					'bordered' => esc_html__( 'Bordered', 'yolo-motor' ),
				),
			),
			array(
				'name'        => esc_html__( 'Custom social profiles right', 'yolo-motor' ),
				'id'          => $prefix . 'header_customize_right_social_profile',
				'type'        => 'select_advanced',
				'placeholder' => esc_html__( 'Select social profiles', 'yolo-motor' ),
				'std'         => '',
				'multiple'    => true,
				'options'     => array(
					'twitter'    => esc_html__( 'Twitter', 'yolo-motor' ),
					'facebook'   => esc_html__( 'Facebook', 'yolo-motor' ),
					'dribbble'   => esc_html__( 'Dribbble', 'yolo-motor' ),
					'vimeo'      => esc_html__( 'Vimeo', 'yolo-motor' ),
					'tumblr'     => esc_html__( 'Tumblr', 'yolo-motor' ),
					'skype'      => esc_html__( 'Skype', 'yolo-motor' ),
					'linkedin'   => esc_html__( 'LinkedIn', 'yolo-motor' ),
					'googleplus' => esc_html__( 'Google+', 'yolo-motor' ),
					'flickr'     => esc_html__( 'Flickr', 'yolo-motor' ),
					'youtube'    => esc_html__( 'YouTube', 'yolo-motor' ),
					'pinterest'  => esc_html__( 'Pinterest', 'yolo-motor' ),
					'foursquare' => esc_html__( 'Foursquare', 'yolo-motor' ),
					'instagram'  => esc_html__( 'Instagram', 'yolo-motor' ),
					'github'     => esc_html__( 'GitHub', 'yolo-motor' ),
					'xing'       => esc_html__( 'Xing', 'yolo-motor' ),
					'behance'    => esc_html__( 'Behance', 'yolo-motor' ),
					'deviantart' => esc_html__( 'Deviantart', 'yolo-motor' ),
					'soundcloud' => esc_html__( 'SoundCloud', 'yolo-motor' ),
					'yelp'       => esc_html__( 'Yelp', 'yolo-motor' ),
					'rss'        => esc_html__( 'RSS Feed', 'yolo-motor' ),
					'email'      => esc_html__( 'Email address', 'yolo-motor' ),
				),
			),
			array(
				'name'           => esc_html__( 'Custom text content right', 'yolo-motor' ),
				'id'             => $prefix . 'header_customize_right_text',
				'type'           => 'textarea',
				'std'            => '',
			),
			array(
				'name'    => esc_html__( 'Header customize separate', 'yolo-motor' ),
				'id'      => $prefix . 'header_customize_right_separate',
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1' => esc_html__( 'Default', 'yolo-motor' ),
					'0'  => esc_html__( 'Off', 'yolo-motor' ),
					'1'  => esc_html__( 'On', 'yolo-motor' ),
				),
			),
		)
	);

	// LOGO
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_logo_meta_box',
		'title'      => esc_html__( 'Logo', 'yolo-motor' ),
		'post_types' => array('post', 'page',  'yolo_portfolio','product'),
		'tab'        => true,
		'fields'     => array(
			array(
				'id'               => $prefix.  'custom_logo',
				'name'             => esc_html__( 'Custom Logo', 'yolo-motor' ),
				'desc'             => esc_html__( 'Upload custom logo in header.', 'yolo-motor' ),
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),

			array(
				'name' => esc_html__( 'Customize Logo Position', 'yolo-motor' ),
				'id'   => $prefix . 'enable_logo_position',
				'type' => 'checkbox_advanced',
				'std'  => 0
			),
			array(
				'id'    => $prefix.  'logo_max_height',
				'name'  => esc_html__( 'Logo max height', 'yolo-motor' ),
				'desc'  => esc_html__( 'Logo max height. Insert number only (empty to set default value)', 'yolo-motor' ),
				'type'  => 'text',
				'sdt'   => '',
				'visible' => array( $prefix . 'enable_logo_position', '!=', '0' )
			),

			array(
				'id'    => $prefix.  'logo_padding_top',
				'name'  => esc_html__( 'Logo padding top', 'yolo-motor' ),
				'desc'  => esc_html__( 'Logo padding top. Insert number only (empty to set default value)', 'yolo-motor' ),
				'type'  => 'text',
				'sdt'   => '',
				'visible' => array( $prefix . 'enable_logo_position', '!=', '0' )
			),

			array(
				'id'    => $prefix.  'logo_padding_bottom',
				'name'  => esc_html__( 'Logo padding bottom', 'yolo-motor' ),
				'desc'  => esc_html__( 'Logo padding bottom. Insert number only (empty to set default value)', 'yolo-motor' ),
				'type'  => 'text',
				'sdt'   => '',
				'visible' => array( $prefix . 'enable_logo_position', '!=', '0' )
			),

			array(
				'id'               => $prefix . 'sticky_logo',
				'name'             => esc_html__( 'Sticky Logo', 'yolo-motor' ),
				'desc'             => esc_html__( 'Upload sticky logo in header (empty to default)', 'yolo-motor' ),
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),
		)
	);

	// MENU
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_menu_meta_box',
		'title'      => esc_html__( 'Menu', 'yolo-motor' ),
		'post_types' => array('post', 'page',  'yolo_portfolio','product'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name'        => esc_html__( 'Page menu', 'yolo-motor' ),
				'id'          => $prefix . 'page_menu',
				'type'        => 'select',
				'options'     => $menu_list,
				'placeholder' => esc_html__( 'Select Menu','yolo-motor' ),
				'std'         => '',
				'multiple'    => false,
				'desc'        => esc_html__( 'Optionally you can choose to override the menu that is used on the page', 'yolo-motor' ),
			),

			array(
				'name'        => esc_html__( 'Page menu mobile', 'yolo-motor' ),
				'id'          => $prefix . 'page_menu_mobile',
				'type'        => 'select',
				'options'     => $menu_list,
				'placeholder' => esc_html__( 'Select Menu', 'yolo-motor' ),
				'std'         => '',
				'multiple'    => false,
				'desc'        => esc_html__( 'Optionally you can choose to override the menu mobile that is used on the page', 'yolo-motor' ),
			),

			// array(
			// 	'name' => esc_html__( 'Is One Page', 'yolo-motor' ),
			// 	'id'   => $prefix . 'is_one_page',
			// 	'type' => 'checkbox_advanced',
			// 	'std'  => '0',
			// 	'desc' => esc_html__( 'Set page style is One Page', 'yolo-motor' ),
			// ),
		)
	);

	// PAGE TITLE
	//--------------------------------------------------
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_title_meta_box',
		'title'      => esc_html__( 'Page Title', 'yolo-motor' ),
		'post_types' => array('post', 'page',  'yolo_portfolio','product'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Show/Hide Page Title?', 'yolo-motor' ),
				'id'      => $prefix . 'show_page_title',
				'type'    => 'button_set',
				'std'     => '-1',
				'options' => array(
					'-1' => esc_html__( 'Default', 'yolo-motor' ),
					'1'  => esc_html__( 'Show', 'yolo-motor' ),
					'0'  => esc_html__( 'Hide', 'yolo-motor' ),
				)

			),


			array(
				'name'    => esc_html__( 'Page Title Layout', 'yolo-motor' ),
				'id'      => $prefix . 'page_title_layout',
				'type'    => 'button_set',
				'options' => array(
					'-1'              => esc_html__( 'Default', 'yolo-motor' ),
					'full'            => esc_html__( 'Full Width', 'yolo-motor' ),
					'container'       => esc_html__( 'Container', 'yolo-motor' ),
					'container-fluid' => esc_html__( 'Container Fluid', 'yolo-motor' ),
				),
				'std'            => '-1',
				'multiple'       => false,
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),

			// PAGE TITLE LINE 1
			array(
				'name'           => esc_html__( 'Custom Page Title', 'yolo-motor' ),
				'id'             => $prefix . 'page_title_custom',
				'desc'           => esc_html__( "Enter a custom page title if you'd like.", 'yolo-motor' ),
				'type'           => 'text',
				'std'            => '',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),

			// PAGE TITLE LINE 2
			array(
				'name'           => esc_html__( 'Custom Page Subtitle', 'yolo-motor' ),
				'id'             => $prefix . 'page_subtitle_custom',
				'desc'           => esc_html__( "Enter a custom page title if you'd like.", 'yolo-motor' ),
				'type'           => 'text',
				'std'            => '',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),

			array (
				'name' 	=> esc_html__('Page Title Scheme', 'yolo-motor'),
				'id' 	=> $prefix . 'page-title-scheme-section',
				'type' 	=> 'section',
				'hidden' => array( $prefix . 'show_page_title', '!=', '1' )
			),

			// PAGE TITLE TEXT COLOR
			array(
				'name'           => esc_html__( 'Page Title Text Color', 'yolo-motor' ),
				'id'             => $prefix . 'page_title_text_color',
				'desc'           => esc_html__( "Optionally set a text color for the page title.", 'yolo-motor' ),
				'type'           => 'color',
				'std'            => '',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),

			// PAGE TITLE TEXT COLOR
			array(
				'name'           => esc_html__( 'Page Sub Title Text Color', 'yolo-motor' ),
				'id'             => $prefix . 'page_sub_title_text_color',
				'desc'           => esc_html__( "Optionally set a text color for the page sub title.", 'yolo-motor' ),
				'type'           => 'color',
				'std'            => '',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),


			// PAGE TITLE BACKGROUND COLOR
			array(
				'name'           => esc_html__( 'Page Title Background Color', 'yolo-motor' ),
				'id'             => $prefix . 'page_title_bg_color',
				'desc'           => esc_html__( "Optionally set a background color for the page title.", 'yolo-motor' ),
				'type'           => 'color',
				'std'            => '',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),

			array(
				'name'           => esc_html__( 'Custom Background Image?', 'yolo-motor' ),
				'id'             => $prefix . 'enable_custom_page_title_bg_image',
				'type'           => 'checkbox_advanced',
				'std'            => 0,
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),

			// BACKGROUND IMAGE
			array(
				'id'               => $prefix.  'page_title_bg_image',
				'name'             => esc_html__( 'Background Image', 'yolo-motor' ),
				'desc'             => esc_html__( 'Background Image for page title.', 'yolo-motor' ),
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'hidden' => array($prefix . 'enable_custom_page_title_bg_image','!=','1'),
			),

			// PAGE TITLE OVERLAY COLOR
			array(
				'id'             => $prefix. 'page_title_overlay_color',
				'name'           => esc_html__( 'Page Title Overlay Color', 'yolo-motor' ),
				'desc'           => esc_html__( "Set an overlay color for page title image.", 'yolo-motor' ),
				'type'           => 'color',
				'std'            => '',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),

			array(
				'name'           => esc_html__( 'Custom Overlay Opacity?', 'yolo-motor' ),
				'id'             => $prefix . 'enable_custom_overlay_opacity',
				'type'           => 'checkbox_advanced',
				'std'            => 0,
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),


			// Overlay Opacity Value
			array(
				'name'       => esc_html__( 'Overlay Opacity', 'yolo-motor' ),
				'id'         => $prefix .'page_title_overlay_opacity',
				'desc'       => esc_html__( 'Set the opacity level of the overlay. This will lighten or darken the image depening on the color selected.', 'yolo-motor' ),
				'clone'      => false,
				'type'       => 'slider',
				'prefix'     => '',
				'js_options' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'hidden' => array($prefix . 'enable_custom_overlay_opacity','!=','1'),
			),

			array (
				'name' 	=> esc_html__('Page Title Style', 'yolo-motor'),
				'id' 	=> $prefix . 'page-title-style-section',
				'type' 	=> 'section',
				'hidden' => array( $prefix . 'show_page_title', '!=', '1' )
			),

			array(
				'name'    => esc_html__( 'Page Title Text Align', 'yolo-motor' ),
				'id'      => $prefix . 'page_title_text_align',
				'desc'    => esc_html__( "Set Page Title Text Align", 'yolo-motor' ),
				'type'    => 'button_set',
				'options' => array(
					'-1'     => esc_html__( 'Default','yolo-motor' ),
					'left'   => esc_html__( 'Left','yolo-motor' ),
					'center' => esc_html__( 'Center','yolo-motor' ),
					'right'  => esc_html__( 'Right','yolo-motor' ),
				),
				'std'            => '-1',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),

			array(
				'name'    => esc_html__( 'Page Title Parallax', 'yolo-motor' ),
				'id'      => $prefix . 'page_title_parallax',
				'desc'    => esc_html__( "Enable Page Title Parallax", 'yolo-motor' ),
				'type'    => 'button_set',
				'options' => array(
					'-1' => esc_html__( 'Default', 'yolo-motor' ),
					'1'  => esc_html__( 'Enable','yolo-motor' ),
					'0'  => esc_html__( 'Disable','yolo-motor' ),
				),
				'std'            => '-1',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),

			// PAGE TITLE Height
			array(
				'name'           => esc_html__( 'Page Title Height', 'yolo-motor' ),
				'id'             => $prefix . 'page_title_height',
				'desc'           => esc_html__( "Enter a page title height value (not include unit).", 'yolo-motor' ),
				'type'           => 'number',
				'std'            => '',
				'hidden' => array( $prefix . 'show_page_title', '=', '0' )
			),

			// Breadcrumbs in Page Title
			array(
				'name'    => esc_html__( 'Breadcrumbs', 'yolo-motor' ),
				'id'      => $prefix . 'breadcrumbs_in_page_title',
				'desc'    => esc_html__( "Show/Hide Breadcrumbs", 'yolo-motor' ),
				'type'    => 'button_set',
				'options' => array(
					'-1' => esc_html__( 'Default','yolo-motor' ),
					'1'  => esc_html__( 'Show','yolo-motor' ),
					'0'  => esc_html__( 'Hide','yolo-motor' ),
				),
				'std' => '-1',
			),
			array(
				'name'  => esc_html__( 'Remove Margin Top', 'yolo-motor' ),
				'id'    => $prefix . 'page_title_remove_margin_top',
				'type'  => 'checkbox_advanced',
				'std'	=> 0,
			),
            array(
                'name'  => esc_html__( 'Remove Margin Bottom', 'yolo-motor' ),
                'id'    => $prefix . 'page_title_remove_margin_bottom',
                'type'  => 'checkbox_advanced',
                'std'	=> 0,
            ),
		)
	);

	// PAGE FOOTER
	//--------------------------------------------------
	$meta_boxes[] = array(
		'id'         => $prefix . 'page_footer_meta_box',
		'title'      => esc_html__( 'Page Footer', 'yolo-motor' ),
		'post_types' => array('post', 'page',  'yolo_portfolio','product'),
		'tab'        => true,
		'fields'     => array(
			array(
				'name' => esc_html__( 'Select Footer', 'yolo-motor' ),
				'id'   => $prefix . 'footer',
				'type' => 'footer',
				'desc' => esc_html__( 'Select footer to override footer selected in Theme Options', 'yolo-motor' ),
			),
		)
	);
	
	return $meta_boxes;
}

// Add new field type to RW Metabox. More details: https://metabox.io/docs/create-field-type/
add_action( 'admin_init', 'yolo_load_rw_custom_fields', 1 ); // Use this for back-end
add_action( 'rwmb_meta_boxes', 'yolo_load_rw_custom_fields', 1 ); // Use this for front-end @TODO: do not know now

function yolo_load_rw_custom_fields() {
	require_once get_template_directory() . '/framework/ct_plugins/meta-box/custom-fields/custom-fields.php';
}

// Hook to 'rwmb_meta_boxes' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
// add_action('admin_init', 'yolo_register_meta_boxes');
add_filter( 'rwmb_meta_boxes', 'yolo_register_meta_boxes' ); // From version 4.8.0