<?php

/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if ( ! class_exists( 'Redux_Framework_options_config' ) ) {

    class Redux_Framework_options_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            if ( ! class_exists( 'YoloReduxFramework' ) ) {
                return;
            }

            $this->initSettings();
        }

        public function initSettings() {
            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }

            $this->ReduxFramework = new YoloReduxFramework( $this->sections, $this->args );
        }

        /**
         * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments( $args ) {
            $args['dev_mode'] = false;

            return $args;
        }

        /**
         * Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            $page_title_bg_url             = get_template_directory_uri() . '/assets/images/bg-page-title.png';
            $page_404_bg_url               = get_template_directory_uri() . '/assets/images/404-bg.jpg';
            $logo_under_construction       = get_template_directory_uri() . '/assets/images/logo_under_construction.png';
            $image_left_under_construction = get_template_directory_uri() . '/assets/images/image_left.png';

            // General Setting
            $this->sections[] = array(
                'title'  => esc_html__( 'General Setting', 'yolo-motor' ),
                'desc'      => esc_html__('Welcome to Motor theme options panel! Have fun customize the theme!', 'yolo-motor'),
                'icon'   => 'el el-wrench',
                'fields' => array(
                    array(
                        'id'       => 'home_preloader',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Page Preloader', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select Page Preloader. Leave empty if you don\'t want to use.', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'square-1'   => 'Square 01',
                            'square-2'   => 'Square 02',
                            'square-3'   => 'Square 03',
                            'square-4'   => 'Square 04',
                            'square-5'   => 'Square 05',
                            'square-6'   => 'Square 06',
                            'square-7'   => 'Square 07',
                            'square-8'   => 'Square 08',
                            'square-9'   => 'Square 09',
                            'round-1'    => 'Round 01',
                            'round-2'    => 'Round 02',
                            'round-3'    => 'Round 03',
                            'round-4'    => 'Round 04',
                            'round-5'    => 'Round 05',
                            'round-6'    => 'Round 06',
                            'round-7'    => 'Round 07',
                            'round-8'    => 'Round 08',
                            'round-9'    => 'Round 09',
                        ),
                        'default' => ''
                    ),


                    array(
                        'id'       => 'home_preloader_bg_color',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Preloader background color', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set Preloader background color.', 'yolo-motor' ),
                        'default'  => array(),
                        'mode'     => 'background',
                        'validate' => 'colorrgba',
                        'required' => array('home_preloader', 'not_empty_and', array('none')),
                    ),

                    array(
                        'id'       => 'home_preloader_spinner_color',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Preloader spinner color', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Pick a preloader spinner color for the Top Bar', 'yolo-motor' ),
                        'default'  => '#e8e8e8',
                        'validate' => 'color',
                        'required' => array( 'home_preloader', 'not_empty_and', array('none') ),
                    ),

                    array(
                        'id'       => 'switch_selector',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Switch Demo Options', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable/Disable Switch Demo Options at front-end', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            '1' => esc_html__( 'On', 'yolo-motor' ),
                            '0' => esc_html__( 'Off', 'yolo-motor' )
                        ),
                        'default'  => '0'
                    ),

                    array(
                        'id'       => 'smooth_scroll',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Smooth Scroll', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable/Disable Smooth Scroll', 'yolo-motor' ),
                        'default'  => false
                    ),

                    array(
                        'id'       => 'back_to_top',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Back To Top', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable/Disable Back to top button', 'yolo-motor' ),
                        'default'  => true
                    ),

                     array(
                        'id'       => 'enable_rtl_mode',
                        'type'     => 'switch',
                        'title'    => esc_html__('Enable RTL mode', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable RTL mode', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => false,
                    ),

                    array(
                        'id'       => 'layout_style',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Layout Style', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select the layout style', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'boxed' => array('title' => 'Boxed', 'img' => get_template_directory_uri().'/assets/images/theme-options/layout-boxed.png'),
                            'wide'  => array('title' => 'Wide', 'img' => get_template_directory_uri().'/assets/images/theme-options/layout-wide.png'),
                            'float' => array('title' => 'Float', 'img' => get_template_directory_uri().'/assets/images/theme-options/layout-float.png')
                        ),
                        'default'  => 'wide'
                    ),

                    array(
                        'id'       => 'body_background_mode',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Body Background Mode', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Chose Background Mode', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'background' => 'Background',
                            'pattern'    => 'Pattern'
                        ),
                        'default'  => 'background',
                        'required' => array('layout_style','=','boxed'),
                    ),

                    array(
                        'id'       => 'body_background',
                        'type'     => 'background',
                        'output'   => array( 'body' ),
                        'title'    => esc_html__( 'Body Background', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Body background (Apply for Boxed layout style).', 'yolo-motor' ),
                        'default'  => array(
                            'background-color'      => '',
                            'background-repeat'     => 'no-repeat',
                            'background-position'   => 'center center',
                            'background-attachment' => 'fixed',
                            'background-size'       => 'cover'
                        ),
                        'required'  => array(
                            array('body_background_mode', '=', array('background'))
                        ),
                    ),
                    array(
                        'id'       => 'body_background_pattern',
                        'type'     => 'image_select',
                        'title'    => esc_html__( 'Background Pattern', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Body background pattern(Apply for Boxed layout style)', 'yolo-motor' ),
                        'desc'     => '',
                        'height'   => '40px',
                        'options'  => array(
                            'pattern-1.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-1.png'),
                            'pattern-2.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-2.png'),
                            'pattern-3.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-3.png'),
                            'pattern-4.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-4.png'),
                            'pattern-5.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-5.png'),
                            'pattern-6.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-6.png'),
                            'pattern-7.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-7.png'),
                            'pattern-8.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-8.png'),
                            'pattern-9.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-9.png'),
                            'pattern-10.png' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/pattern-10.png'),
                        ),
                        'default'  => 'pattern-1.png',
                        'required' => array(
                            array('body_background_mode', '=', array('pattern'))
                        ) ,
                    ),
                    array(
                        'id'       => 'google_api_key',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Google API Key', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set google API Key for Map', 'yolo-motor' ),
                        'desc'     => '',
                    ),
                )
            );

            // Enhancement: maintenance and performance
            $this->sections[] = array(
                'title'      => esc_html__( 'Enhancement', 'yolo-motor' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => 'el-icon-eye-close',
                'fields'     => array(
                    array(
                        'id'       => 'enable_maintenance',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Coming Soon / Maintenance Mode', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable your site coming soon / maintenance mode.', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            '2' => 'On (Custom Page)',
                            '1' => 'On (Standard)',
                            '0' => 'Off',
                        ),
                        'default'  => '0'
                    ),
                    array(
                        'id'       => 'maintenance_mode_page',
                        'type'     => 'select',
                        'data'     => 'pages',
                        'required' => array('enable_maintenance', '=', '2'),
                        'title'    => esc_html__('Custom Maintenance Mode Page', 'yolo-motor'),
                        'subtitle' => esc_html__('If you would like to show a custom page instead of the standard Maintenance page, select the page that is your maintenace page, .', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => '',
                        'args'     => array()
                    ),
                    array(
                        'id'          => 'maintenance_title',
                        'type'        => 'text',
                        'placeholder' => 'Coming Soon',
                        'required'    => array('enable_maintenance', '=', '1'),
                        'title'       => esc_html__('Maintenance title', 'yolo-motor'),
                        'subtitle'    => esc_html__('Insert coming soon title.', 'yolo-motor'),
                        'default'     => 'Coming Soon',
                    ),
                    array(
                        'id'       => 'maintenance_background',
                        'type'     => 'media',
                        'url'      => true,
                        'required' => array('enable_maintenance', '=', '1'),
                        'title'    => esc_html__('Maintenance Background', 'yolo-motor'),
                        'subtitle' => esc_html__('Select maintenance background image.', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => '',
                        'args'     => array()
                    ),
                    array(
                        'id'          => 'online_time',
                        'type'        => 'datetime',
                        'placeholder' => 'Y/m/d H:i:s',
                        'required'    => array('enable_maintenance', '=', '1'),
                        'title'       => esc_html__( 'Online time', 'yolo-motor' ),
                        'subtitle'    => esc_html__( 'Your page will automatic end maintenance mode after this time.', 'yolo-motor' ),
                    ),
                    array(
                        'id'          => 'timezone',
                        'type'        => 'text',
                        'placeholder' => 'Asia/Ho_Chi_Minh',
                        'required'    => array('enable_maintenance', '=', '1'),
                        'title'       => esc_html__('Timezone', 'yolo-motor'),
                        'subtitle'    => esc_html__('You can change timezone from here. More details: http://php.net/manual/en/timezones.php', 'yolo-motor'),
                        'default'     => 'Asia/Ho_Chi_Minh',
                    ),
                    array(
                        'id'       => 'maintenance_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'required' => array('enable_maintenance', '=', '1'),
                        'width'    => '100%',
                        'title'    => esc_html__('Maintenance social profiles', 'yolo-motor'),
                        'subtitle' => esc_html__('Select social profile for maintenance page.', 'yolo-motor'),
                        'options'  => array(
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
                        'desc'    => '',
                        'default' => ''
                    ),
                    array(
                        'id'       => 'enable_minifile_html',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Enable Minifier HTML File', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable/Disable Minifier HTML File', 'yolo-motor' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'enable_minifile_js',
                        'type'     => 'switch',
                        'title'    => esc_html__('Enable Minifier JS File', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Minifier JS File', 'yolo-motor'),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'enable_minifile_css',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Enable Minifier CSS File', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable/Disable Minifier CSS File', 'yolo-motor' ),
                        'default'  => false
                    ),
                    array(
                        'id'          => 'cdn_font_awesome',
                        'type'        => 'text',
                        'placeholder' => 'Insert CDN Font Awesome link',
                        'title'       => esc_html__('CDN Font Awesome', 'yolo-motor'),
                        'subtitle'    => esc_html__('If you leave this field empty, theme will use version in theme folder.', 'yolo-motor'),
                        'default'     => '',
                    ),
                    array(
                        'id'          => 'cdn_bootstrap_css',
                        'type'        => 'text',
                        'placeholder' => 'Insert CDN Bootstrap CSS link',
                        'title'       => esc_html__('CDN Bootstrap CSS', 'yolo-motor'),
                        'subtitle'    => esc_html__('If you leave this field empty, theme will use version in theme folder.', 'yolo-motor'),
                        'default'     => '',
                    ),
                    array(
                        'id'          => 'cdn_bootstrap_js',
                        'type'        => 'text',
                        'placeholder' => 'Insert CDN Bootstrap JS link',
                        'title'       => esc_html__('CDN Bootstrap JS', 'yolo-motor'),
                        'subtitle'    => esc_html__('If you leave this field empty, theme will use version in theme folder.', 'yolo-motor'),
                        'default'     => '',
                    ),
                ),
            );

            // 404 Page error
            $this->sections[] = array(
                'title'      => esc_html__( '404 Setting', 'yolo-motor' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => 'el el-remove-circle',
                'fields'     => array(
                    array(
                        'id'        => 'page_title_404',
                        'type'      => 'text',
                        'title'     => esc_html__('Page Title 404', 'yolo-motor'),
                        'default'   => esc_html__('The page', 'yolo-motor'),
                    ),
                    array(
                        'id'        => 'sub_page_title_404',
                        'type'      => 'text',
                        'title'     => esc_html__( 'SubPage Title 404', 'yolo-motor' ),
                        'default'   => esc_html__( 'You are looking for does not exist', 'yolo-motor' ),
                    ),
                    array(
                        'id'       => 'page_404_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Background 404 page', 'yolo-motor'),
                        'subtitle' => esc_html__('Upload your background image here.', 'yolo-motor'),
                        'desc'     => '',
                        'default'  =>  array(
                            'url'  => $page_404_bg_url
                        )
                    ),
                    array(
                        'id'        => 'title_404',
                        'type'      => 'text',
                        'title'     => esc_html__('404 Heading', 'yolo-motor'),
                        'default'   => esc_html__('404 error', 'yolo-motor'),
                    ),
                    array(
                        'id'        => 'go_back_404',
                        'type'      => 'text',
                        'title'     => esc_html__('Go back label', 'yolo-motor'),
                        'default'   => esc_html__('Please return to homepage', 'yolo-motor'),
                    ),
                    array(
                        'id'        => 'go_back_url_404',
                        'type'      => 'text',
                        'title'     => esc_html__('Go back link', 'yolo-motor'),
                        'default'   => '',
                    )
                )
            );

            // Pages Setting
            $this->sections[] = array(
                'title'  => esc_html__( 'Pages Setting', 'yolo-motor' ),
                'desc'   => '',
                'icon'   => 'el el-th',
                'fields' => array(
                    array(
                        'id'       => 'page_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select Page Layout', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'yolo-motor' ),
                            'container'       => esc_html__( 'Container', 'yolo-motor' ),
                            'container-fluid' => esc_html__( 'Container Fluid', 'yolo-motor' )
                        ),
                        'default'  => 'container'
                    ),
                    // Add to fix page background color
                    array(
                        'id'       => 'page_background_color',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Page Background Color', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select page background color.', 'yolo-motor' ),
                        'default'  => '#f6f6f6',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'page_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Sidebar', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Sidebar Style', 'yolo-motor'),
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-right.png'),
                            'both'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-both.png'),
                        ),
                        'default' => 'none'
                    ),

                    array(
                        'id'       => 'page_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Sidebar Width', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Sidebar width', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array('small' => 'Small (1/4)', 'large' => 'Large (1/3)'),
                        'default'  => 'small',
                        'required' => array('page_sidebar', '=', array('left','both','right')),
                    ),

                    array(
                        'id'       => 'page_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Left Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('page_sidebar', '=', array('left','both')),
                    ),
                    array(
                        'id'       => 'page_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Right Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('page_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'     => 'section-page-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Page Title Setting', 'yolo-motor'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'show_page_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Page Title', 'yolo-motor'),
                        'subtitle' => esc_html__('Show/Hide Page Title', 'yolo-motor'),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'page_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Page Title Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select Page Title Layout', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                            'container-fluid' => 'Container Fluid'
                        ),
                        'default'  => 'full',
                        'required' => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'             => 'page_title_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Page Title Margin', 'yolo-motor'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave blank for default value.', 'yolo-motor'),
                        'desc'           => esc_html__('If you would like to override the default page title top/bottom margin, please set it here.', 'yolo-motor'),
                        'left'           => false,
                        'right'          => false,
                        'output'         => array('.page-title-margin'),
                        'default'        => array(
                            'margin-top'     => '0',
                            'margin-bottom'  => '65px',
                            'units'          => 'px',
                        ),
                        'required'  => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'page_title_text_align',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Page Title Text Align', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set Page Title Text Align', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
                        'default'  => 'center',
                        'required' => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'page_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Page Title Parallax', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable Page Title Parallax', 'yolo-motor' ),
                        'default'  => false,
                        'required' => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'        => 'page_title_height',
                        'type'      => 'dimensions',
                        'units'     => 'px',
                        'width'     =>  false,
                        'title'     => esc_html__('Page Title Height', 'yolo-motor'),
                        'desc'      => esc_html__('You can set a height for the page title here', 'yolo-motor'),
                        'required'  => array('show_page_title', '=', array('1')),
                        'output'    => array('.page-title-height'),
                        'default'   => array(
                            'height'    => '300'
                        ),
                    ),

                    array(
                        'id'       => 'page_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Page Title Background', 'yolo-motor'),
                        'subtitle' => esc_html__('Upload page title background.', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => array(
                            'url' => $page_title_bg_url
                        ),
                        'required'  => array('show_page_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_page_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Pages', 'yolo-motor'),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'page_comment',
                        'type'     => 'switch',
                        'title'    => esc_html__('Page Comment', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable page comment', 'yolo-motor'),
                        'default'  => false
                    )
                )
            );

            // Archive Setting
            $this->sections[] = array(
                'title'      => esc_html__( 'Archive Page', 'yolo-motor' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => 'el el-folder-close',
                'fields'     => array(
                    array(
                        'id'       => 'archive_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Layout', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select Archive Layout', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => esc_html__( 'Full Width', 'yolo-motor' ),
                            'container'       => esc_html__( 'Container', 'yolo-motor' ),
                            'container-fluid' => esc_html__( 'Container Fluid', 'yolo-motor'),
                            ),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'archive_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Sidebar', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Sidebar Style', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'none'     => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-none.png'),
                            'left'     => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-left.png'),
                            'right'    => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-right.png'),
                            'both'     => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-both.png'),
                        ),
                        'default'  => 'left'
                    ),

                    array(
                        'id'       => 'archive_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Sidebar Width', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set Sidebar width', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'small' => esc_html__( 'Small (1/4)', 'yolo-motor' ),
                            'large' => esc_html__( 'Large (1/3)', 'yolo-motor' ),
                        ),
                        'default'  => 'small',
                        'required' => array('archive_sidebar', '=', array('left','both','right')),
                    ),

                    array(
                        'id'       => 'archive_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Left Sidebar', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Choose the default left sidebar', 'yolo-motor' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('archive_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'archive_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Right Sidebar', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Choose the default right sidebar', 'yolo-motor' ),
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('archive_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'archive_paging_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Paging Style', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select archive paging style', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'         => esc_html__( 'Default', 'yolo-motor' ),
                            'load-more'       => esc_html__( 'Load More', 'yolo-motor' ),
                            'infinity-scroll' => esc_html__( 'Infinity Scroll', 'yolo-motor' )
                        ),
                        'default'  => 'default'
                    ),

                    array(
                        'id'       => 'archive_paging_align',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Paging Align', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select archive paging align', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'left'   => esc_html__( 'Left','yolo-motor' ),
                            'center' => esc_html__( 'Center','yolo-motor' ),
                            'right'  => esc_html__( 'Right','yolo-motor' )
                        ),
                        'default' => 'right'
                    ),

                    array(
                        'id'       => 'archive_display_type',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Type', 'yolo-motor'),
                        'subtitle' => esc_html__('Select archive display type', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'large-image'  => esc_html__('Large Image','yolo-motor'),
                            'medium-image' => esc_html__('Medium Image','yolo-motor'),
                            'grid'         => esc_html__('Grid','yolo-motor'),
                            'masonry'      => esc_html__('Masonry','yolo-motor'),
                        ),
                        'default'  => 'large-image'
                    ),

                    array(
                        'id'       => 'archive_display_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Display Columns', 'yolo-motor'),
                        'subtitle' => esc_html__('Choose the number of columns to display on archive pages.','yolo-motor'),
                        'options'  => array(
                            '2'     => '2',
                            '3'     => '3',
                            '4'     => '4',
                        ),
                        'desc'     => '',
                        'default'  => '2',
                        'required' => array('archive_display_type','=',array('grid','masonry')),
                    ),

                    array(
                        'id'     => 'section-archive-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Archive Title Setting', 'yolo-motor'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'show_archive_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Archive Title', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Archive Title', 'yolo-motor'),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'archive_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Archive Title Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select Archive Title Layout', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container', 'container-fluid' => 'Container Fluid'),
                        'default'  => 'full',
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'             => 'archive_title_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Archive Title Margin', 'yolo-motor'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'yolo-motor'),
                        'desc'           => esc_html__('If you would like to override the default archive title top/bottom margin, then you can do so here.', 'yolo-motor'),
                        'left'           => false,
                        'right'          => false,
                        'output'         => array('.archive-title-margin'),
                        'default'        => array(
                            'margin-top'     => '0',
                            'margin-bottom'  => '50px',
                            'units'          => 'px',
                        ),
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_title_text_align',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Archive Title Text Align', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set Archive Title Text Align', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
                        'default'  => 'center',
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'archive_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Archive Title Parallax', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable Archive Title Parallax', 'yolo-motor' ),
                        'default'  => false,
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'        => 'archive_title_height',
                        'type'      => 'dimensions',
                        'title'     => esc_html__('Archive Title Height', 'yolo-motor'),
                        'desc'      => esc_html__('You can set a height for the archive title here', 'yolo-motor'),
                        'required' => array('show_archive_title','=',array('1')),
                        'units' => 'px',
                        'width'    =>  false,
                        'output' => array('.archive-title-height'),
                        'default'  => array(
                            'height'  => '300'
                        ),
                    ),

                    array(
                        'id'       => 'archive_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Archive Title Background', 'yolo-motor'),
                        'subtitle' => esc_html__('Upload archive title background.', 'yolo-motor'),
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => $page_title_bg_url
                        ),
                        'required' => array('show_archive_title','=',array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_archive_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Archive', 'yolo-motor'),
                        'default'  => true
                    ),
                )
            );

            // Search Page Setting
            $this->sections[] = array(
                'title'  => esc_html__( 'Search Page', 'yolo-motor' ),
                'desc'   => '',
                'icon'   => 'el el-search',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'search_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select Search Layout', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container', 'container-fluid' => 'Container Fluid'),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'search_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Sidebar', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Sidebar Style', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-right.png'),
                            'both'  => array('title' => '', 'img' => get_template_directory_uri() . '/assets/images/theme-options/sidebar-both.png'),
                        ),
                        'default' => 'left'
                    ),

                    array(
                        'id'       => 'search_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Sidebar Width', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Sidebar width', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array('small' => 'Small (1/4)', 'large' => 'Large (1/3)'),
                        'default'  => 'small',
                        'required' => array('search_sidebar', '=', array('left','both','right')),
                    ),

                    array(
                        'id'       => 'search_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Left Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('search_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'search_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Right Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('search_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'search_paging_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Paging Style', 'yolo-motor'),
                        'subtitle' => esc_html__('Select search paging style', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array('default' => 'Default', 'load-more' => 'Load More', 'infinity-scroll' => 'Infinity Scroll'),
                        'default'  => 'default'
                    ),
                    array(
                        'id'       => 'search_paging_align',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Paging Align', 'yolo-motor'),
                        'subtitle' => esc_html__('Select search paging align', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'left'   => esc_html__('Left','yolo-motor'),
                            'center' => esc_html__('Center','yolo-motor'),
                            'right'  => esc_html__('Right','yolo-motor')
                        ),
                        'default' => 'right'
                    ),
                )
            );

            // Single Blog
            $this->sections[] = array(
                'title'      => esc_html__( 'Single Blog', 'yolo-motor' ),
                'desc'       => '',
                'icon'       => 'el el-file',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'       => 'single_blog_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select Single Blog Layout', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container', 'container-fluid' => 'Container Fluid'),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'single_blog_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Sidebar', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Sidebar Style', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-right.png'),
                            'both'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-both.png'),
                        ),
                        'default'  => 'left'
                    ),

                    array(
                        'id'       => 'single_blog_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Sidebar Width', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Sidebar width', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array('small' => 'Small (1/4)', 'large' => 'Large (1/3)'),
                        'default'  => 'small',
                        'required' => array('single_blog_sidebar', '=', array('left','both','right')),
                    ),


                    array(
                        'id'       => 'single_blog_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Left Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('single_blog_sidebar', '=', array('left','both')),
                    ),

                    array(
                        'id'       => 'single_blog_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Right Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'sidebar-1',
                        'required' => array('single_blog_sidebar', '=', array('right','both')),
                    ),

                    array(
                        'id'       => 'show_post_navigation',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Post Navigation', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Post Navigation', 'yolo-motor'),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'show_author_info',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Author Info', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Author Info', 'yolo-motor'),
                        'default'  => true
                    ),

                    array(
                        'id'     => 'section-single-blog-title-setting-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Single Blog Title Setting', 'yolo-motor'),
                        'indent' => true
                    ),
                    array(
                        'id'       => 'show_single_blog_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Single Blog Title', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Single Blog Title', 'yolo-motor'),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'single_blog_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Single Blog Title Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select Single Blog Title Layout', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                            'container-fluid' => 'Container Fluid'
                        ),
                        'default'  => 'full',
                        'required' => array('show_single_blog_title', '=', array('1')),
                    ),

                    array(
                        'id'             => 'single_blog_title_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Single Blog Title Margin', 'yolo-motor'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'yolo-motor'),
                        'desc'           => esc_html__('If you would like to override the default single blog title top/bottom margin, then you can do so here.', 'yolo-motor'),
                        'left'           => false,
                        'right'          => false,
                        'output'         => array('.single-blog-title-margin'),
                        'default'        => array(
                            'margin-top'     => '0',
                            'margin-bottom'  => '50px',
                            'units'          => 'px',
                        ),
                        'required'       => array('show_single_blog_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_blog_title_text_align',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Single Blog Title Text Align', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set Single Blog Title Text Align', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'left'   => 'Left',
                            'center' => 'Center',
                            'right'  => 'Right'
                        ),
                        'default'  => 'center',
                        'required' => array('show_single_blog_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_blog_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Single Blog Title Parallax', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable Single Blog Title Parallax', 'yolo-motor' ),
                        'default'  => false,
                        'required' => array('show_single_blog_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_blog_title_height',
                        'type'     => 'dimensions',
                        'title'    => esc_html__('Single Blog Title Height', 'yolo-motor'),
                        'desc'     => esc_html__('You can set a height for the single blog title here', 'yolo-motor'),
                        'required' => array('show_single_blog_title', '=', array('1')),
                        'units'    => 'px',
                        'width'    =>  false,
                        'output'   => array('.single-blog-title-height'),
                        'default'  => array(
                            'height'  => '300'
                        )
                    ),

                    array(
                        'id'       => 'single_blog_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Single Blog Title Background', 'yolo-motor'),
                        'subtitle' => esc_html__('Upload single blog title background.', 'yolo-motor'),
                        'desc'     => '',
                        'default'  =>  array(
                            'url' => $page_title_bg_url
                        ),
                        'required'  => array('show_single_blog_title', '=', array('1'))
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_single_blog_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs In Single Blog', 'yolo-motor'),
                        'default'  => true
                    ),
                )
            );

            // Logo
            $this->sections[] = array(
                'title'  => esc_html__( 'Logo & Favicon', 'yolo-motor' ),
                'desc'   => '',
                'icon'   => 'el el-picture',
                'fields' => array(
                    array(
                        'id'       => 'logo',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Logo', 'yolo-motor'),
                        'subtitle' => esc_html__('Upload your logo here.', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/assets/images/theme-options/logo.png'
                        )
                    ),

                    array(
                        'id'      => 'logo_height',
                        'type'    => 'dimensions',
                        'title'   => esc_html__('Logo Height', 'yolo-motor'),
                        'desc'    => esc_html__('You can set a height for the logo here', 'yolo-motor'),
                        'units'   => 'px',
                        'width'   =>  false,
                        'default' => array(
                            'Height'  => ''
                        )
                    ),

                    array(
                        'id'      => 'logo_max_height',
                        'type'    => 'dimensions',
                        'title'   => esc_html__('Logo Max Height', 'yolo-motor'),
                        'desc'    => esc_html__('You can set a max height for the logo here', 'yolo-motor'),
                        'units'   => 'px',
                        'width'   =>  false,
                        'default' => array(
                            'Height'  => ''
                        )
                    ),

                    array(
                        'id'             => 'logo_padding',
                        'type'           => 'spacing',
                        'mode'           => 'padding',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Logo Top/Bottom Padding', 'yolo-motor'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave blank for default.', 'yolo-motor'),
                        'desc'           => esc_html__('If you would like to override the default logo top/bottom padding, then you can do so here.', 'yolo-motor'),
                        'left'           => false,
                        'right'          => false,
                        'default'        => array(
                            'padding-top'    => '',
                            'padding-bottom' => '',
                            'units'          => 'px',
                        )
                    ),
                    array(
                            'id'       => 'sticky_logo',
                            'type'     => 'media',
                            'url'      => true,
                            'title'    => esc_html__('Sticky Logo', 'yolo-motor'),
                            'subtitle' => esc_html__('Upload a sticky version of your logo here', 'yolo-motor'),
                            'desc'     => '',
                            'default'  => array(
                            'url'      => get_template_directory_uri() . '/assets/images/theme-options/logo.png'
                        )
                    ),

                    array(
                        'id'       => 'custom_favicon',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Custom favicon', 'yolo-motor'),
                        'subtitle' => esc_html__('Upload a 16px x 16px Png/Gif/ico image that will represent your website favicon', 'yolo-motor'),
                        'desc'     => ''
                    ),
                )
            );

            // Header
            $this->sections[] = array(
                'title'  => esc_html__( 'Header', 'yolo-motor' ),
                'desc'   => '',
                'icon'   => 'el el-credit-card',
                'fields' => array(
                    array(
                        'id'       => 'top_bar',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show/Hide Top Bar', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Show Hide Top Bar.', 'yolo-motor' ),
                        'default'  => false
                    ),
                    array(
                        'id'      => 'top_bar_layout_width',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Top bar layout width', 'yolo-motor'),
                        'options' => array(
                            'container'    => esc_html__('Container','yolo-motor'),
                            'topbar-fullwith' => esc_html__('Full width','yolo-motor'),
                        ),
                        'default'  => 'container',
                        'required' => array('top_bar','=','1'),
                    ),
                    array(
                        'id'       => 'top_bar_layout_padding',
                        'type'     => 'slider',
                        'title'    => esc_html__('Top bar padding left/right (px)', 'yolo-motor'),
                        'default'  => '100',
                        "min"      => 0,
                        "step"     => 1,
                        "max"      => 200,
                        'required' => array('top_bar_layout_width','=','topbar-fullwith'),
                    ),
                    array(
                        'id'       => 'top_bar_layout',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Top bar Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select the top bar column layout.', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'top-bar-1' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-1.jpg'),
                            'top-bar-2' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-2.jpg'),
                            'top-bar-3' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-3.jpg'),
                            'top-bar-4' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/top-bar-layout-4.jpg'),
                        ),
                        'default'  => 'top-bar-1',
                        'required' => array('top_bar','=','1'),
                    ),
                    array(
                        'id'       => 'top_bar_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Top Left Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default top left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'top_bar_left',
                        'required' => array('top_bar','=','1'),
                    ),
                    array(
                        'id'       => 'top_bar_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Top Right Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default top right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'top_bar_right',
                        'required' => array('top_bar','=','1'),
                    ),
                    array(
                        'id'       => 'top_bar_center_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Top Center Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default top center sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'top_bar_left',
                        'required' => array('top_bar','=','1'),
                    ),

                    array(
                        'id'       => 'header_layout',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Header Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select a header layout option from the examples.', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'header-1'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_1.jpg'),
                            'header-2'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_2.jpg'),
                            'header-3'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_3.jpg'),
                            'header-4'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_4.jpg'),
                            'header-6'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_6.jpg'),
                            'header-8'       => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_8.jpg'),
                            'header-sidebar' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header_sidebar.jpg'),
                        ),
                        'default' => 'header-2'
                    ),

                    array(
                        'id'     => 'section-header-scheme',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Scheme', 'yolo-motor'),
                        'indent' => true
                    ),
                    array(
                        'id'      => 'header_scheme',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Header scheme', 'yolo-motor'),
                        'options' => array(
                            'default'   => esc_html__('Default','yolo-motor'),
                            'customize' => esc_html__('Customize','yolo-motor'),
                        ),
                        'default'  => 'default'
                    ),

                    array(
                        'id'       => 'header_background',
                        'type'     => 'background',
                        'title'    => esc_html__('Header background', 'yolo-motor'),
                        'subtitle' => esc_html__('Header background with image, color, etc.', 'yolo-motor'),
                        'default'  => array(
                            'background-color' => '#fff',
                        ),
                        'required' => array('header_scheme','=','customize'),
                    ),

                    array(
                        'id'       => 'header_background_color_opacity',
                        'type'     => 'slider',
                        'title'    => esc_html__('Header background color opacity', 'yolo-motor'),
                        'subtitle' => esc_html__('Set the opacity level of background color.', 'yolo-motor'),
                        'default'  => '100',
                        "min"      => 0,
                        "step"     => 1,
                        "max"      => 100,
                        'required' => array('header_scheme','=','customize'),
                    ),

                    array(
                        'id'       => 'header_border_color',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__('Header border Color', 'yolo-motor'),
                        'subtitle' => esc_html__('Set header border Color.', 'yolo-motor'),
                        'default'  => array(),
                        'validate' => 'colorrgba',
                        'required' => array('header_scheme','=','customize'),
                    ),
                    array(
                        'id'       => 'header_text_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Header text color', 'yolo-motor'),
                        'subtitle' => esc_html__('Set header text color', 'yolo-motor'),
                        'default'  => '#333',
                        'validate' => 'color',
                        'required' => array('header_scheme','=','customize'),
                    ),

                    array(
                        'id'     => 'section-header-nav',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Navigation', 'yolo-motor'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'header_nav_scheme',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Header navigation scheme', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set header navigation scheme', 'yolo-motor' ),
                        'default'  => 'default',
                        'options'  => array(
                            'default'       => esc_html__('Default','yolo-motor'),
                            'customize'     => esc_html__('Customize','yolo-motor')
                        )
                    ),

                    array(
                        'id'       => 'header_nav_bg_color',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Header navigation background color', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set header navigation background color', 'yolo-motor' ),
                        'default'  => array(),
                        'mode'     => 'background',
                        'validate' => 'colorrgba',
                        'default'  => array(
                            'color'     => '#f4f4f4',
                            'alpha'     => 1
                        ),
                        'options'       => array(
                            'allow_empty'   => false,
                        ),
                        'required' => array('header_nav_scheme','=','customize'),
                    ),

                    array(
                        'id'       => 'header_nav_text_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Header navigation text color', 'yolo-motor'),
                        'subtitle' => esc_html__('Set header navigation text color', 'yolo-motor'),
                        'default'  => '#222',
                        'validate' => 'color',
                        'required' => array('header_nav_scheme','=','customize'),
                    ),

                    array(
                        'id'      => 'header_nav_layout',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Header navigation layout', 'yolo-motor'),
                        'options' => array(
                            'container'    => esc_html__('Container','yolo-motor'),
                            'nav-fullwith' => esc_html__('Full width','yolo-motor'),
                        ),
                        'default'  => 'container'
                    ),

                    array(
                        'id'       => 'header_nav_layout_padding',
                        'type'     => 'slider',
                        'title'    => esc_html__('Header navigation padding left/right (px)', 'yolo-motor'),
                        'default'  => '100',
                        "min"      => 0,
                        "step"     => 1,
                        "max"      => 200,
                        'required' => array('header_nav_layout','=','nav-fullwith'),
                    ),

                    array(
                        'id'      => 'header_nav_hover',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Header navigation hover', 'yolo-motor'),
                        'options' => array(
                            'nav-hover-primary'      => esc_html__('Primary Color','yolo-motor'),
                            'nav-hover-primary-base' => esc_html__('Base Primary Color','yolo-motor'),
                        ),
                        'default'  => 'nav-hover-primary'
                    ),

                    array(
                        'id'      => 'header_nav_distance',
                        'type'    => 'dimensions',
                        'title'   => esc_html__('Header navigation distance', 'yolo-motor'),
                        'desc'    => esc_html__('You can set distance between navigation items. Empty value to default', 'yolo-motor'),
                        'units'   => 'px',
                        'height'  =>  false,
                        'default' => array(
                            'Width'  => ''
                        )
                    ),

                    array(
                        'id'       => 'header_layout_float',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Header Float', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable/Disable Header Float.', 'yolo-motor' ),
                        'default'  => false
                    ),

                    array(
                        'id'       => 'header_sticky',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show/Hide Header Sticky', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Show Hide header Sticky.', 'yolo-motor' ),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'header_sticky_scheme',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Header sticky scheme', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Choose header sticky scheme', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'inherit' => esc_html__('Inherit','yolo-motor'),
                            'gray'    => esc_html__('Gray','yolo-motor'),
                            'light'   => esc_html__('Light','yolo-motor'),
                            'dark'    => esc_html__('Dark','yolo-motor')
                        ),
                        'default'  => 'inherit'
                    ),

                    array(
                        'id'       => 'header_shopping_cart_button',
                        'type'     => 'checkbox',
                        'title'    => esc_html__('Shopping Cart Button', 'yolo-motor'),
                        'subtitle' => esc_html__('Select header shopping cart button', 'yolo-motor'),
                        'options'  => array(
                            'view-cart' => 'View Cart',
                            'checkout'  => 'Checkout',
                        ),
                        'default'  => array(
                            'view-cart' => '1',
                            'checkout'  => '1',
                        ),
                        'required' => array('header_shopping_cart','=','1'),
                    ),

                    array(
                        'id'       => 'search_box_type',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Search Box Type', 'yolo-motor'),
                        'subtitle' => esc_html__('Select search box type.', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'standard' => esc_html__('Standard','yolo-motor'),
                            'ajax'     => esc_html__('Ajax Search','yolo-motor')
                        ),
                        'default'  => 'standard'
                    ),

                    array(
                        'id'       => 'search_box_post_type',
                        'type'     => 'checkbox',
                        'title'    => esc_html__('Post type for Ajax Search', 'yolo-motor'),
                        'subtitle' => esc_html__('Select post type for ajax search', 'yolo-motor'),
                        'options'  => array(
                            'post'      => 'Post',
                            'page'      => 'Page',
                            'product'   => 'Product',
                            'service'   => 'Our Services',
                        ),
                        'default'  => array(
                            'post'      => '1',
                            'page'      => '0',
                            'product'   => '1',
                            'service'   => '1',
                        ),
                        'required' => array('search_box_type','=','ajax'),
                    ),

                    array(
                        'id'        => 'search_box_result_amount',
                        'type'      => 'text',
                        'title'     => esc_html__('Amount Of Search Result', 'yolo-motor'),
                        'subtitle'  => esc_html__('This must be numeric (no px) or empty (default: 8).', 'yolo-motor'),
                        'desc'      => esc_html__('Set mount of Search Result', 'yolo-motor'),
                        'validate'  => 'numeric',
                        'default'   => '',
                        'required' => array('search_box_type','=','ajax'),
                    ),
                )
            );

            // Header Customize
            $this->sections[] = array(
                'title'      => esc_html__( 'Header Customize', 'yolo-motor' ),
                'desc'       => '',
                'icon'       => 'el el-credit-card',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'       => 'menu_animation',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Mega Menu Animation', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select animation for mega menu', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'fadeIn'            => 'fadeIn',
                            // 'fadeInDown'        => 'fadeInDown',
                            'fadeInUp1'          => 'fadeInUp',
                            'bounceIn'          => 'bounceIn',
                            'flipInX'           => 'flipInX',
                            'bounceInRight'     => 'bounceInRight',
                            'fadeInRight'       => 'fadeInRight',
                        ),
                        'default' => 'fadeInUp'
                    ),
                    array(
                        'id'       => 'menu_add_register_link',
                        'type'     => 'menu',
                        'title'    => esc_html__( 'Add register/login popup link to menu', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select menu to add register/login popup link.', 'yolo-motor' ),
                        'default'  => ''
                    ),
                    array(
                        'id'     => 'section-header-customize-nav',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Navigation', 'yolo-motor'),
                        'indent' => true
                    ),
                    array(
                        'id'      => 'header_customize_nav',
                        'type'    => 'sorter',
                        'title'   => 'Header customize navigation',
                        'desc'    => 'Organize how you want the layout to appear on the header navigation',
                        'options' => array(
                            'enabled'  => array(
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-motor' ),
                                'canvas-menu'          => esc_html__( 'Canvas Menu','yolo-motor' ),
                            ),
                            'disabled' => array(
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-motor' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-motor' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-motor' ),
                                'search-button'        => esc_html__( 'Search Button', 'yolo-motor' ),
                                'search-box'           => esc_html__( 'Search Box', 'yolo-motor' ),
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-motor' ),
                                'custom-text'          => esc_html__( 'Custom Text', 'yolo-motor' ),
                                
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_customize_nav_search_button_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Search Button Style', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select style for search button', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'  => esc_html__('Default','yolo-motor'),
                            'round'    => esc_html__('Round','yolo-motor'),
                            'bordered' => esc_html__('Bordered','yolo-motor'),
                        ),
                        'default'  => 'default',
                    ),

                    array(
                        'id'       => 'header_customize_nav_shopping_cart_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Shopping cart Style', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select style for shopping cart', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'  => esc_html__('Default','yolo-motor'),
                            'round'    => esc_html__('Round','yolo-motor'),
                            'bordered' => esc_html__('Bordered','yolo-motor'),
                        ),
                        'default'  => 'default',
                    ),

                    array(
                        'id'       => 'header_customize_nav_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-motor'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-motor'),
                        'options'  => array(
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
                        'desc'    => '',
                        'default' => array(
                                    'twitter',
                                    'facebook',
                                    'googleplus',
                                    'skype'
                                    )
                    ),
                    array(
                        'id'       => 'header_customize_nav_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-motor'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),
                    array(
                        'id'      => 'header_customize_nav_separate',
                        'title'   => esc_html__('Header customize separate','yolo-motor'),
                        'type'    => 'button_set',
                        'options' => array(
                            '0' => esc_html__('Off','yolo-motor'),
                            '1' => esc_html__('On','yolo-motor'),
                        ),
                        'default'  => '0',
                    ),

                    array(
                        'id'     => 'section-header-customize-left',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Left', 'yolo-motor'),
                        'indent' => true
                    ),
                    array(
                        'id'      => 'header_customize_left',
                        'type'    => 'sorter',
                        'title'   => 'Header customize left',
                        'desc'    => 'Organize how you want the layout to appear on the header left',
                        'options' => array(
                            'enabled'  => array(
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-motor' ),
                            ),
                            'disabled' => array(
                                'shopping-cart'        => esc_html__( 'Shopping Cart', 'yolo-motor' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-motor' ),
                                'wishlist'             => esc_html__( 'Wishlist', 'yolo-motor' ),
                                'search-button'        => esc_html__( 'Search Button', 'yolo-motor' ),
                                'search-box'           => esc_html__( 'Search Box', 'yolo-motor' ),
                                // 'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-motor' ),
                                'social-profile'       => esc_html__( 'Social Profile', 'yolo-motor' ),
                                'custom-text'          => esc_html__( 'Custom Text','yolo-motor' ),
                                'canvas-menu'          => esc_html__( 'Canvas Menu','yolo-motor' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_customize_left_search_button_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Search Button Style', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select style for search button', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'  => esc_html__('Default','yolo-motor'),
                            'round'    => esc_html__('Round','yolo-motor'),
                            'bordered' => esc_html__('Bordered','yolo-motor'),
                        ),
                        'default'  => 'default',
                    ),
                    array(
                        'id'       => 'header_customize_left_shopping_cart_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Shopping cart Style', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select style for shopping cart', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'  => esc_html__('Default','yolo-motor'),
                            'round'    => esc_html__('Round','yolo-motor'),
                            'bordered' => esc_html__('Bordered','yolo-motor'),
                        ),
                        'default'  => 'default',
                    ),
                    array(
                        'id'       => 'header_customize_left_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-motor'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-motor'),
                        'options'  => array(
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
                        'desc'    => '',
                        'default' => array(
                                    'twitter',
                                    'facebook',
                                    'googleplus',
                                    'skype'
                                    )
                    ),
                    array(
                        'id'       => 'header_customize_left_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-motor'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),
                    array(
                        'id'    => 'header_customize_left_separate',
                        'title' => esc_html__('Header customize separate','yolo-motor'),
                        'type'  => 'button_set',
                        'options' => array(
                            '0' => esc_html__( 'Off', 'yolo-motor' ),
                            '1' => esc_html__( 'On', 'yolo-motor' ),
                        ),
                        'default'  => '0',
                    ),

                    array(
                        'id'     => 'section-header-customize-right',
                        'type'   => 'section',
                        'title'  => esc_html__('Header Customize Right', 'yolo-motor'),
                        'indent' => true
                    ),
                    array(
                        'id'      => 'header_customize_right',
                        'type'    => 'sorter',
                        'title'   => 'Header customize right',
                        'desc'    => 'Organize how you want the layout to appear on the header right',
                        'options' => array(
                            'enabled'  => array(
                                 'custom-text'    => esc_html__( 'Custom Text', 'yolo-motor' ),
                                'shopping-cart-price'  => esc_html__( 'Shopping Cart With Price', 'yolo-motor' ),
                            ),
                            'disabled' => array(
                                'search-with-category' => esc_html__( 'Search Box With Shop Category', 'yolo-motor' ),
                                'shopping-cart'  => esc_html__( 'Shopping Cart', 'yolo-motor' ),
                                'wishlist'       => esc_html__( 'Wishlist', 'yolo-motor' ),
                                'search-button'  => esc_html__( 'Search Button', 'yolo-motor' ),
                                'search-box'     => esc_html__( 'Search Box', 'yolo-motor' ),
                                'social-profile' => esc_html__( 'Social Profile', 'yolo-motor' ),
                                'canvas-menu'    => esc_html__( 'Canvas Menu','yolo-motor' ),
                            )
                        )
                    ),
                    array(
                        'id'       => 'header_customize_right_search_button_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Search Button Style', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select style for search button', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'  => esc_html__('Default','yolo-motor'),
                            'round'    => esc_html__('Round','yolo-motor'),
                            'bordered' => esc_html__('Bordered','yolo-motor'),
                        ),
                        'default'  => 'default',
                    ),
                    array(
                        'id'       => 'header_customize_right_shopping_cart_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Shopping cart Style', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Select style for shopping cart', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'default'  => esc_html__('Default','yolo-motor'),
                            'round'    => esc_html__('Round','yolo-motor'),
                            'bordered' => esc_html__('Bordered','yolo-motor'),
                        ),
                        'default'  => 'default',
                    ),
                    array(
                        'id'       => 'header_customize_right_social_profile',
                        'type'     => 'select',
                        'multi'    => true,
                        'width'    => '100%',
                        'title'    => esc_html__('Custom social profiles', 'yolo-motor'),
                        'subtitle' => esc_html__('Select social profile for custom text', 'yolo-motor'),
                        'options'  => array(
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
                        'desc'    => '',
                        'default' => array(
                                    'twitter',
                                    'facebook',
                                    'googleplus',
                                    'skype'
                                    )
                    ),
                    array(
                        'id'       => 'header_customize_right_text',
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom Text Content', 'yolo-motor'),
                        'subtitle' => esc_html__('Add Content for Custom Text', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => '<i class="fa fa-phone"></i> + (102) 35460789',
                        'options'  => array('minLines'=> 5, 'maxLines' => 60),
                    ),
                    array(
                        'id'    => 'header_customize_right_separate',
                        'title' => esc_html__('Header customize separate','yolo-motor'),
                        'type'  => 'button_set',
                        'options' => array(
                            '0' => esc_html__('Off','yolo-motor'),
                            '1' => esc_html__('On','yolo-motor'),
                        ),
                        'default'  => '0',
                    ),
                )
            );

            // Mobile Header
            $this->sections[] = array(
                'title'      => esc_html__( 'Mobile Header', 'yolo-motor' ),
                'desc'       => '',
                'subsection' => true,
                'icon'       => 'el el-th-list',
                'fields'     => array(
                    array(
                        'id'       => 'mobile_header_layout',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Header Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select header mobile layout', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'header-mobile-1' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header-mobile-layout-1.jpg'),
                            'header-mobile-4' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header-mobile-layout-4.jpg'),
                            'header-mobile-3' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header-mobile-layout-3.jpg'),
                            'header-mobile-5' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header-mobile-layout-5.jpg'),
                            'header-mobile-2' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/header-mobile-layout-2.jpg'),
                        ),
                        'default' => 'header-mobile-1'
                    ),

                    array(
                        'id'       => 'mobile_header_menu_drop',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Menu Drop Type', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set menu drop type for mobile header', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'dropdown' => esc_html__('Dropdown Menu','yolo-motor'),
                            'fly'      => esc_html__('Fly Menu','yolo-motor')
                        ),
                        'default'  => 'fly'
                    ),

                    array(
                        'id'       => 'mobile_header_logo',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Mobile Logo', 'yolo-motor'),
                        'subtitle' => esc_html__('Upload your logo here.', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/assets/images/theme-options/logo.png'
                        )
                    ),

                    array(
                        'id'      => 'logo_mobile_height',
                        'type'    => 'dimensions',
                        'title'   => esc_html__('Logo Height', 'yolo-motor'),
                        'desc'    => esc_html__('You can set a height for the logo here', 'yolo-motor'),
                        'units'   => 'px',
                        'width'   =>  false,
                        'default' => array(
                            'Height'  => ''
                        )
                    ),

                    array(
                        'id'      => 'logo_mobile_max_height',
                        'type'    => 'dimensions',
                        'title'   => esc_html__('Logo Mobile Max Height', 'yolo-motor'),
                        'desc'    => esc_html__('You can set a max height for the logo mobile here', 'yolo-motor'),
                        'units'   => 'px',
                        'width'   =>  false,
                        'default' => array(
                            'Height'  => ''
                        )
                    ),

                    array(
                        'id'      => 'logo_mobile_padding',
                        'type'    => 'dimensions',
                        'title'   => esc_html__('Logo Top/Bottom Padding', 'yolo-motor'),
                        'desc'    => esc_html__('If you would like to override the default logo top/bottom padding, then you can do so here', 'yolo-motor'),
                        'units'   => 'px',
                        'width'   =>  false,
                        'default' => array(
                            'Height'  => ''
                        )
                    ),

                    array(
                        'id'       => 'mobile_header_top_bar',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Top Bar', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable Top bar.', 'yolo-motor' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'mobile_header_stick',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Stick Mobile Header', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable Stick Mobile Header.', 'yolo-motor' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'mobile_header_search_box',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Search Box', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable Search Box.', 'yolo-motor' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'mobile_header_shopping_cart',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Shopping Cart', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable Shopping Cart', 'yolo-motor' ),
                        'default'  => true
                    ),
                )
            );

            // Footer
            $this->sections[] = array(
                'title'  => esc_html__( 'Footer', 'yolo-motor' ),
                'desc'   => '',
                'icon'   => 'el el-website',
                'fields' => array(
                    array(
                        'id'       => 'footer',
                        'type'     => 'footer',
                        'title'    => esc_html__('Select Footer Block', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Footer Block', 'yolo-motor'),
                    ),

                )
            );

            // Styling Options
            $this->sections[] = array(
                'title'  => esc_html__( 'Styling Options', 'yolo-motor' ),
                'desc'   => esc_html__( 'If you change value in this section, you must "Save & Generate CSS"', 'yolo-motor' ),
                'icon'   => 'el el-magic',
                'fields' => array(
                    array(
                        'id'       => 'primary_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Primary Color', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Primary Color', 'yolo-motor'),
                        'default'  => '#ffb535',
                        'validate' => 'color',
                    ),

                    array(
                        'id'       => 'secondary_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Secondary Color', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Secondary Color', 'yolo-motor'),
                        'default'  => '#333',
                        'validate' => 'color',
                    ),


                    array(
                        'id'       => 'text_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Text Color', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Text Color.', 'yolo-motor'),
                        'default'  => '#363738',
                        'validate' => 'color',
                    ),

                    array(
                        'id'       => 'heading_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Heading Color', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Heading Color.', 'yolo-motor'),
                        'default'  => '#333333',
                        'validate' => 'color',
                    ),

                    array(
                        'id'       => 'top_bar_bg_color',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Top Bar background color', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set Top Bar background color.', 'yolo-motor' ),
                        'default'  => array(
                            'color' => '#f9f9f9',
                            'alpha' => '1'
                        ),
                        'mode'     => 'background',
                        'validate' => 'colorrgba',
                    ),

                    array(
                        'id'       => 'top_bar_text_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Top Bar text color', 'yolo-motor'),
                        'subtitle' => esc_html__('Pick a text color for the Top Bar', 'yolo-motor'),
                        'default'  => '#878787',
                        'validate' => 'color',
                    ),

                    array(
                        'id' => 'section-sub-menu-scheme',
                        'type' => 'section',
                        'title' => esc_html__('Sub-menu Scheme', 'yolo-motor'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'menu_sub_scheme',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Sub menu scheme', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set sub menu scheme', 'yolo-motor' ),
                        'default'  => 'default',
                        'options'  => array(
                            'default'   => esc_html__('Default','yolo-motor'),
                            'customize' => esc_html__('Customize','yolo-motor')
                        )
                    ),

                    array(
                        'id'       => 'menu_sub_bg_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Sub Menu Background Color', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Sub Menu Background Color.', 'yolo-motor'),
                        'default'  => '#fff',
                        'validate' => 'color',
                        'required'  => array('menu_sub_scheme', '=', 'customize'),
                    ),

                    array(
                        'id'       => 'menu_sub_text_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Sub Menu Text Color', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Sub Menu Text Color.', 'yolo-motor'),
                        'default'  => '#363738',
                        'validate' => 'color',
                        'required'  => array('menu_sub_scheme', '=', 'customize'),
                    ),

                    array(
                        'id'     => 'section-page-title-background-color',
                        'type'   => 'section',
                        'title'  => esc_html__('Page Title Background Color', 'yolo-motor'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'page_title_bg_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Page Title Background Color', 'yolo-motor'),
                        'subtitle' => esc_html__('Pick a background color for page title.', 'yolo-motor'),
                        'default'  => '#FFFFFF',
                        'validate' => 'color'
                    ),
                    array(
                        'id'       => 'page_title_overlay_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Page Title Background Overlay Color', 'yolo-motor'),
                        'subtitle' => esc_html__('Pick a background overlay color for page title.', 'yolo-motor'),
                        'default'  => '',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'page_title_overlay_opacity',
                        'type'     => 'slider',
                        'title'    => esc_html__('Page Title Background Overlay Opacity', 'yolo-motor'),
                        'subtitle' => esc_html__('Set the opacity level of the overlay.', 'yolo-motor'),
                        'default'  => '0',
                        "min"      => 0,
                        "step"     => 1,
                        "max"      => 100
                    ),
                )
            );

            // Typography
            $this->sections[] = array(
                'icon'   => 'el el-font',
                'title'  => esc_html__('Typograhpy', 'yolo-motor'),
                'desc'   => esc_html__( 'If you change value in this section, you must "Save & Generate CSS"', 'yolo-motor' ),
                'fields' => array(
                    array(
                        'id'       => 'custom_general_font',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Use Custom fonts for body', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Turn on to use custom fonts for the theme main text.', 'yolo-motor' ),
                        'default'  => true
                    ),


                    array(
                        'id'             => 'body_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('Body Font', 'yolo-motor'),
                        'subtitle'       => esc_html__('Specify the body font properties.', 'yolo-motor'),
                        'google'         => true,
                        'line-height'    => false,
                        'color'          => false,
                        'letter-spacing' => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('body'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('body'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          => 'px', // Defaults to px
                        'default'        => array(
                            'color'       => '#444',
                            'font-size'   => '14px',
                            'font-family' => 'Varela Round',
                            'font-weight' => '400',
                            'google'      => true,
                        ),
                        'required'        => array('custom_general_font','=','1'),
                    ),

                    array(
                        'id'          => 'secondary_font',
                        'type'        => 'typography',
                        'title'       => esc_html__('Secondary Font', 'yolo-motor'),
                        'subtitle'    => esc_html__('Specify the Secondary font properties.', 'yolo-motor'),
                        'google'      => true,
                        'line-height' => false,
                        'all_styles'  => true, // Enable all Google Font style/weight variations to be added to the page
                        'color'       => false,
                        'text-align'  => false,
                        'font-style'  => false,
                        'subsets'     => true,
                        'font-size'   => true,
                        'font-weight' => true,
                        'output'      => array(''), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'    => array(''), // An array of CSS selectors to apply this font style to dynamically
                        'units'       => 'px', // Defaults to px
                        'default'     => array(
                            'font-family' => 'Montserrat',
                            'font-size'   => '14px',
                            'font-weight' => '400',
                            'google'      => true,
                        ),
                        'required'    => array('custom_general_font','=','1'),
                    ),

                    array(
                        'id'             =>'h1_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H1 Font', 'yolo-motor'),
                        'subtitle'       => esc_html__('Specify the H1 font properties.', 'yolo-motor'),
                        'google'         => true,
                        'letter-spacing' => false,
                        'color'          => false,
                        'line-height'    => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h1'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h1'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'color'       => '#444',
                            'font-size'   => '36px',
                            'font-family' => 'Montserrat',
                            'font-weight' => '400',
                        ),
                        'required'       => array('custom_general_font','=','1'),
                    ),
                    array(
                        'id'             =>'h2_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H2 Font', 'yolo-motor'),
                        'subtitle'       => esc_html__('Specify the H2 font properties.', 'yolo-motor'),
                        'google'         => true,
                        'letter-spacing' => false,
                        'color'          => false,
                        'line-height'    => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h2'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h2'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'color'       => '#444',
                            'font-size'   => '28px',
                            'font-family' => 'Montserrat',
                            'font-weight' => '400',
                        ),
                        'required'       => array('custom_general_font','=','1'),
                    ),
                    array(
                        'id'             =>'h3_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H3 Font', 'yolo-motor'),
                        'subtitle'       => esc_html__('Specify the H3 font properties.', 'yolo-motor'),
                        'google'         => true,
                        'color'          => false,
                        'line-height'    => false,
                        'letter-spacing' => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h3'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h3'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'color'       => '#444',
                            'font-size'   => '24px',
                            'font-family' => 'Montserrat',
                            'font-weight' => '400',
                        ),
                        'required'       => array('custom_general_font','=','1'),
                    ),
                    array(
                        'id'             =>'h4_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H4 Font', 'yolo-motor'),
                        'subtitle'       => esc_html__('Specify the H4 font properties.', 'yolo-motor'),
                        'google'         => true,
                        'color'          => false,
                        'line-height'    => false,
                        'letter-spacing' => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h4'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h4'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'color'       => '#444',
                            'font-size'   => '21px',
                            'font-family' => 'Montserrat',
                            'font-weight' => '400',
                        ),
                        'required' => array('custom_general_font','=','1'),
                    ),
                    array(
                        'id'             =>'h5_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H5 Font', 'yolo-motor'),
                        'subtitle'       => esc_html__('Specify the H5 font properties.', 'yolo-motor'),
                        'google'         => true,
                        'line-height'    => false,
                        'color'          => false,
                        'letter-spacing' => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h5'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h5'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'color'       => '#444',
                            'font-size'   => '18px',
                            'font-family' => 'Montserrat',
                            'font-weight' => '400',
                        ),
                        'required'       => array('custom_general_font','=','1'),
                    ),
                    array(
                        'id'             =>'h6_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('H6 Font', 'yolo-motor'),
                        'subtitle'       => esc_html__('Specify the H6 font properties.', 'yolo-motor'),
                        'google'         => true,
                        'color'          => false,
                        'line-height'    => false,
                        'letter-spacing' => false,
                        'text-align'     => false,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'output'         => array('h6'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array('h6'), // An array of CSS selectors to apply this font style to dynamically
                        'units'          =>'px', // Defaults to px
                        'default'        => array(
                            'color'       => '#444',
                            'font-size'   => '14px',
                            'font-family' => 'Montserrat',
                            'font-weight' => '400',
                        ),
                        'required'       => array('custom_general_font','=','1'),
                    ),

                    array(
                        'id'       => 'custom_menu_font',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Use Custom fonts for Menu / Header?', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Use Custom fonts for Menu / Header?', 'yolo-motor' ),
                        'default'  => true
                    ),
                    array(
                        'id'             => 'menu_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('Menu Font', 'yolo-motor'),
                        'subtitle'       => esc_html__('Specify the Menu font properties.', 'yolo-motor'),
                        'google'         => true,
                        'all_styles'     => false, // Enable all Google Font style/weight variations to be added to the page
                        'color'          => false,
                        'line-height'    => false,
                        'text-align'     => false,
                        'font-style'     => false,
                        'subsets'        => true,
                        'text-transform' => false,
                        'output'         => array(''), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array(''), // An array of CSS selectors to apply this font style to dynamically
                        'units'          => 'px', // Defaults to px
                        'default'        => array(
                            'font-family'    => 'Montserrat',
                            'font-size'      => '14px',
                            'font-weight'    => '700',
                            'text-transform' => 'none',
                        ),
                        'required'       => array('custom_menu_font','=','1'),
                    ),

                    array(
                        'id'       => 'custom_page_title_font',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Use Custom fonts for Page Title/Sub page title?', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Use Custom fonts for Page Title/Sub page title?', 'yolo-motor' ),
                        'default'  => true
                    ),
                    array(
                        'id'             => 'page_title_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('Page Title Font', 'yolo-motor'),
                        'subtitle'       => esc_html__('Specify the page title font properties.', 'yolo-motor'),
                        'google'         => true,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'line-height'    => false,
                        'color'          => true,
                        'text-align'     => false,
                        'font-style'     => true,
                        'subsets'        => false,
                        'font-size'      => true,
                        'font-weight'    => true,
                        'text-transform' => true,
                        'output'         => array('.page-title-inner h1'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array(), // An array of CSS selectors to apply this font style to dynamically
                        'units'          => 'px', // Defaults to px
                        'default'        => array(
                            'font-family'    => 'Montserrat',
                            'font-size'      => '50px',
                            'font-weight'    => '400',
                            'text-transform' => 'none',
                            'color'          => '#fff'
                        ),
                        'required'       => array('custom_page_title_font','=','1'),
                    ),

                    array(
                        'id'             => 'page_sub_title_font',
                        'type'           => 'typography',
                        'title'          => esc_html__('Page Sub Title Font', 'yolo-motor'),
                        'subtitle'       => esc_html__('Specify the page sub title font properties.', 'yolo-motor'),
                        'google'         => true,
                        'all_styles'     => true, // Enable all Google Font style/weight variations to be added to the page
                        'line-height'    => false,
                        'font-style'     => true,
                        'text-align'     => false,
                        'subsets'        => false,
                        'font-size'      => true,
                        'font-weight'    => true,
                        'text-transform' => true,
                        'output'         => array('.page-title-inner .page-sub-title'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler'       => array(), // An array of CSS selectors to apply this font style to dynamically
                        'units'          => 'px', // Defaults to px
                        'default'        => array(
                            'font-family'    => 'Montserrat',
                            'font-size'      => '14px',
                            'font-weight'    => '400italic',
                            'text-transform' => 'none',
                            'color'          => '#fff'
                        ),
                        'required'       => array('custom_page_title_font','=','1'),
                    ),


                ),
            );

            $this->sections[] = array(
                'title'  => esc_html__( 'Social Profiles', 'yolo-motor' ),
                'desc'   => '',
                'icon'   => 'el el-globe',
                'fields' => array(
                    array(
                        'id'       => 'facebook_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Facebook URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Facebook URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'twitter_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Twitter URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Twitter URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),

                    array(
                        'id'       => 'dribbble_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Dribbble URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Dribbble URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'vimeo_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Vimeo URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Vimeo URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'tumblr_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Tumblr URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Tumblr URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'skype_username',
                        'type'     => 'text',
                        'title'    => esc_html__('Skype ID', 'yolo-motor'),
                        'subtitle' => "Please enter your skype ID.",
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'linkedin_url',
                        'type'     => 'text',
                        'title'    => esc_html__('LinkedIn URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Linkedin URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'googleplus_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Google+ URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Google+ URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'flickr_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Flickr URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Flickr URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'youtube_url',
                        'type'     => 'text',
                        'title'    => esc_html__('YouTube URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Youtube URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'pinterest_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Pinterest URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Pinterest URL.",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'foursquare_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Foursquare URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Foursqaure URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'instagram_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Instagram URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Instagram URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'github_url',
                        'type'     => 'text',
                        'title'    => esc_html__('GitHub URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your GitHub URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'xing_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Xing URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Xing URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'behance_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Behance URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Behance URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'deviantart_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Deviantart URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Deviantart URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'soundcloud_url',
                        'type'     => 'text',
                        'title'    => esc_html__('SoundCloud URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your SoundCloud URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'yelp_url',
                        'type'     => 'text',
                        'title'    => esc_html__('Yelp URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your Yelp URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'rss_url',
                        'type'     => 'text',
                        'title'    => esc_html__('RSS Feed URL', 'yolo-motor'),
                        'subtitle' => "Please enter in your RSS Feed URL",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'email_address',
                        'type'     => 'text',
                        'title'    => esc_html__('Email address', 'yolo-motor'),
                        'subtitle' => "Please enter in your email address",
                        'desc'     => '',
                        'default'  => ''
                    ),
                    array(
                        'id'   =>'social-profile-divide-0',
                        'type' => 'divide'
                    ),
                    array(
                        'title'    => esc_html__('Social Share', 'yolo-motor'),
                        'id'       => 'social_sharing',
                        'type'     => 'checkbox',
                        'subtitle' => esc_html__('Show the social sharing in blog posts', 'yolo-motor'),

                        //Must provide key => value pairs for multi checkbox options
                        'options'  => array(
                            'facebook'  => 'Facebook',
                            'twitter'   => 'Twitter',
                            'google'    => 'Google',
                            'linkedin'  => 'Linkedin',
                            'tumblr'    => 'Tumblr',
                            'pinterest' => 'Pinterest'
                        ),

                        //See how default has changed? you also don't need to specify opts that are 0.
                        'default' => array(
                            'facebook'  => '1',
                            'twitter'   => '1',
                            'google'    => '1',
                            'linkedin'  => '1',
                            'tumblr'    => '1',
                            'pinterest' => '1'
                        )
                    )
                )
            );

            // Popup Configs
            $this->sections[] = array(
                'title'  => esc_html__( 'Promo Popup', 'yolo-motor' ),
                'desc'   => '',
                'icon'   => 'el el-photo',
                'fields' => array(
                    array(
                        'id'       => 'show_popup',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Popup', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Show/Hide Popup when user go to your site', 'yolo-motor' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'popup_width',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Popup Width', 'yolo-motor' ),
                        'subtitle' => "Please set with of popup (number only in px)",
                        'validate'  => 'numeric',
                        'desc'     => '',
                        'default'  => '780',
                        'required' => array('show_popup','=',array('1')),
                    ),
                    array(
                        'id'       => 'popup_height',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Popup Height', 'yolo-motor' ),
                        'subtitle' => "Please set height of popup (number only in px)",
                        'validate'  => 'numeric',
                        'desc'     => '',
                        'default'  => '350',
                        'required' => array('show_popup','=',array('1')),
                    ),
                    array(
                        'id'       => 'popup_effect',
                        'type'     => 'select',
                        'title'    => esc_html__('Popup Effect', 'yolo-motor'),
                        'subtitle' => esc_html__('Choose popup effect.','yolo-motor'),
                        'options'  => array(
                            'mfp-zoom-in'         => esc_html__( 'ZoomIn', 'yolo-motor' ),
                            'mfp-newspaper'       => esc_html__( 'Newspaper', 'yolo-motor' ),
                            'mfp-move-horizontal' => esc_html__( 'Move Horizontal', 'yolo-motor' ),
                            'mfp-move-from-top'   => esc_html__( 'Move From Top', 'yolo-motor' ),
                            'mfp-3d-unfold'       => esc_html__( '3D Unfold', 'yolo-motor' ),
                            'mfp-zoom-out'        => esc_html__( 'ZoomOut', 'yolo-motor' ),
                            'hinge'               => esc_html__( 'Hinge', 'yolo-motor' )
                        ),
                        'desc'     => '',
                        'default'  => 'mfp-zoom-in',
                        'required' => array('show_popup','=',array('1')),
                    ),
                    array(
                        'id'       => 'popup_delay',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Popup Delay', 'yolo-motor' ),
                        'subtitle' => "Please set delay of popup (caculate by miliseconds)",
                        'validate'  => 'numeric',
                        'desc'     => '',
                        'default'  => '2000',
                        'required' => array('show_popup','=',array('1')),
                    ),
                    array(
                        'id'       => 'popup_content',
                        'type'     => 'editor',
                        'title'    => esc_html__( 'Popup Content', 'yolo-motor' ),
                        'subtitle' => "Please set content of popup",
                        'desc'     => '',
                        'default'  => '',
                        'required' => array('show_popup','=',array('1')),
                    ),
                    array(
                        'id'       => 'popup_background',
                        'type'     => 'media',
                        'title'    => esc_html__( 'Popup Background', 'yolo-motor' ),
                        'url'      => true,
                        'subtitle' => "",
                        'desc'     => '',
                        'default'  => array(
                            'url'  =>  ''
                        ),
                        'required' => array('show_popup','=',array('1')),
                    ),

                )
            );

            // Woocommerce
            $this->sections[] = array(
                'title'  => esc_html__( 'Woocommerce', 'yolo-motor' ),
                'desc'   => '',
                'icon'   => 'el el-shopping-cart-sign',
                'fields' => array(
                    array(
                        'id'       => 'product_show_rating',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Rating', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Show/Hide Rating product', 'yolo-motor' ),
                        'default'  => true
                    ),


                    array(
                        'id'       => 'product_sale_flash_mode',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Sale Badge Mode', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Chose Sale Badge Mode', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'text'    => 'Text',
                            'percent' => 'Percent'
                        ),
                        'default'  => 'percent'
                    ),

                    array(
                        'id'       => 'product_show_result_count',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Result Count', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Show/Hide Result Count In Archive Product', 'yolo-motor' ),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_2')),
                    ),
                    array(
                        'id'       => 'product_show_catalog_ordering',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Catalog Ordering', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Show/Hide Catalog Ordering', 'yolo-motor' ),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_2')),
                    ),
                    array(
                        'id'       => 'product_button_tooltip',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Button Tooltip', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable/Disable Button Tooltip', 'yolo-motor' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'product_quick_view',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Quick View Button', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable/Disable Quick View', 'yolo-motor' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'product_add_to_cart',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Add To Cart Button', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable/Disable Add To Cart Button', 'yolo-motor' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'product_add_wishlist',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Add To Wishlist Button', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable/Disable Add To Wishlist Button', 'yolo-motor' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'product_add_to_compare',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Add To Compare Button', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable/Disable Add To Compare Button', 'yolo-motor' ),
                        'default'  => true
                    ),
                )
            );

            // Archive Product
            $this->sections[] = array(
                'title'  => esc_html__( 'Archive Product', 'yolo-motor' ),
                'desc'   => '',
                'icon'   => 'el el-book',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'show_page_shop_content',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Show Page Shop Content', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Shop Page Content', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array('0' => 'Off','before' => 'Show Before Archive','after' => 'Show After Archive'),
                        'default'  => '0'
                    ),
                    array(
                        'id'       => 'product_per_page',
                        'type'     => 'text',
                        'title'    => esc_html__('Products Per Page', 'yolo-motor'),
                        'desc'     => esc_html__('This must be numeric or empty (default 12).', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Products Per Page in archive product', 'yolo-motor'),
                        'validate' => 'numeric',
                        'default'  => '12',
                    ),
                    array(
                        'id'       => 'product_display_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Product Display Columns', 'yolo-motor'),
                        'subtitle' => esc_html__('Choose the number of columns to display on shop/category pages.','yolo-motor'),
                        'options'  => array(
                            '2'     => '2',
                            '3'     => '3',
                            '4'     => '4',
                            '5'     => '5'
                        ),
                        'desc'    => '',
                        'default' => '4',
                        'select2' => array('allowClear' =>  false) ,
                    ),


                    array(
                        'id'     => 'section-archive-product-layout-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Layout Options', 'yolo-motor'),
                        'indent' => true
                    ),
                    array(
                        'id'       => 'archive_product_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Archive Product Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select Archive Product Layout', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container', 'container-fluid' => 'Container Fluid'),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'archive_product_style',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Shop page style', 'yolo-motor'),
                        'subtitle' => esc_html__('Select shop page style', 'yolo-motor'),
                        'options'  => array(
                            'style_2'       => 'Woo Defaults',
                            'style_1'       => 'Ajax Filter'
                        ),
                        'default'  => 'style_1'
                    ),
                    array(
                        'id'       => 'archive_product_display',
                        'type'     => 'select',
                        'title'    => esc_html__('Select Product Style', 'yolo-motor'),
                        'subtitle' => '',
                        'options'  => array(
                            'fitRows'       => esc_html__('FitRows', 'yolo-motor'),
                            'masonry'       => esc_html__('Masonry', 'yolo-motor')
                        ),
                        'default'  => 'fitRows',
                    ),
                    array(
                        'id'       => 'show_categories',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Categories', 'yolo-motor'),
                        'subtitle' => esc_html__('Show/Hide categories', 'yolo-motor'),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_1')),
                    ),
                    array(
                        'id'       => 'show_filters',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Filters', 'yolo-motor'),
                        'subtitle' => esc_html__('Show/Hide filters', 'yolo-motor'),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_1')),
                    ),
                    array(
                        'id'       => 'show_search',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Search', 'yolo-motor'),
                        'subtitle' => esc_html__('Show/Hide search', 'yolo-motor'),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_1')),
                    ),
                    array(
                        'id'       => 'yolo_ajax_filter',
                        'type'     => 'switch',
                        'title'    => esc_html__('Ajax filter', 'yolo-motor'),
                        'subtitle' => esc_html__('Use Ajax to filter shop content (Ajax allows new content without reloading the whole page).', 'yolo-motor'),
                        'default'  => true,
                        'required' => array('archive_product_style', '=', array('style_1')),
                    ),
                    array(
                        'id'       => 'archive_product_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Archive Product Sidebar', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Archive Product Sidebar', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-right.png')
                        ),
                        'default'  => 'left',
                        'required' => array('archive_product_style', '=', array('style_2'))
                    ),
                    array(
                        'id'       => 'archive_product_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Sidebar Width', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Sidebar width', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'small' => 'Small (1/4)',
                            'large' => 'Large (1/3)'
                        ),
                        'default'  => 'small',
                        'required' => array('archive_product_sidebar', '=', array('left','both','right')),
                    ),
                    array(
                        'id'       => 'archive_product_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Product Left Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default Archive Product left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'woocommerce',
                        'required' => array('archive_product_sidebar', '=', array('left','both')),
                    ),
                    array(
                        'id'       => 'archive_product_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Archive Product Right Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default Archive Product right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'woocommerce',
                        'required' => array('archive_product_sidebar', '=', array('right','both')),
                    ),
                    array(
                        'id'     => 'section-archive-product-layout-end',
                        'type'   => 'section',
                        'indent' => false
                    ),
                    array(
                        'id'     => 'section-archive-product-title-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Page Title Options', 'yolo-motor'),
                        'indent' => true
                    ),
                    array(
                        'id'       => 'show_archive_product_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Archive Title', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Archive Product Title', 'yolo-motor'),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'archive_product_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Archive Product Title Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select Archive Product Title Layout', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                            'container-fluid' => 'Container Fluid'
                        ),
                        'default'  => 'full',
                        'required' => array('show_archive_product_title', '=', array('1')),
                    ),

                    array(
                        'id'             => 'archive_product_title_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Archive Product Title Margin', 'yolo-motor'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'yolo-motor'),
                        'desc'           => esc_html__('If you would like to override the default archive product title top/bottom margin, then you can do so here.', 'yolo-motor'),
                        'left'           => false,
                        'right'          => false,
                        'output'         => array('.archive-product-title-margin'),
                        'default'        => array(
                            'margin-top'     => '0',
                            'margin-bottom'  => '50px',
                            'units'          => 'px',
                        ),
                        'required'  => array('show_archive_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'archive_product_title_text_align',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Archive Product Title Text Align', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set Archive Product Title Text Align', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array(
                            'left'   => 'Left',
                            'center' => 'Center',
                            'right'  => 'Right'
                        ),
                        'default'  => 'center',
                        'required' => array('show_archive_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'archive_product_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Archive Product Title Parallax', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable Archive Product Title Parallax', 'yolo-motor' ),
                        'default'  => false,
                        'required' => array('show_archive_product_title', '=', array('1')),
                    ),


                    array(
                        'id'       => 'archive_product_title_height',
                        'type'     => 'dimensions',
                        'title'    => esc_html__('Archive Product Title Height', 'yolo-motor'),
                        'desc'     => esc_html__('You can set a height for the archive product title here', 'yolo-motor'),
                        'required' => array('show_archive_product_title', '=', array('1')),
                        'units'    => 'px',
                        'output'   => array('.archive-product-title-height'),
                        'width'    =>  false,
                        'default'  => array(
                            'height'  => '300'
                        )
                    ),

                    array(
                        'id'       => 'archive_product_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Archive Product Title Background', 'yolo-motor'),
                        'subtitle' => esc_html__('Upload archive product title background.', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => array(
                            'url' => $page_title_bg_url
                        ),
                        'required'  => array('show_archive_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_archive_product_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs in Archive Product', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs in Archive Product', 'yolo-motor'),
                        'default'  => true
                    ),
                )
            );

            // Single Product
            $this->sections[] = array(
                'title'      => esc_html__( 'Single Product', 'yolo-motor' ),
                'desc'       => '',
                'icon'       => 'el el-laptop',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'       => 'single_product_show_image_thumb',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Show Image Thumb', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Show/Hide Image Thumb product', 'yolo-motor' ),
                        'default'  => true
                    ),

                    array(
                        'id'     => 'section-single-product-layout-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Layout Options', 'yolo-motor'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'single_product_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Single Product Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select Single Product Layout', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'full'            => 'Full Width',
                            'container'       => 'Container',
                            'container-fluid' => 'Container Fluid'
                        ),
                        'default'  => 'container'
                    ),
                    array(
                        'id'       => 'single_product_sidebar',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Single Product Sidebar', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Single Product Sidebar', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array(
                            'none'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-none.png'),
                            'left'  => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-left.png'),
                            'right' => array('title' => '', 'img' => get_template_directory_uri().'/assets/images/theme-options/sidebar-right.png'),
                        ),
                        'default' => 'none'
                    ),
                    array(
                        'id'       => 'single_product_sidebar_width',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Single Product Sidebar Width', 'yolo-motor'),
                        'subtitle' => esc_html__('Set Sidebar width', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array('small' => 'Small (1/4)', 'large' => 'Large (1/3)'),
                        'default'  => 'small',
                        'required' => array('single_product_sidebar', '=', array('left','both','right')),
                    ),
                    array(
                        'id'       => 'single_product_left_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Single Product Left Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default Single Product left sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'woocommerce',
                        'required' => array('single_product_sidebar', '=', array('left','both')),
                    ),
                    array(
                        'id'       => 'single_product_right_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Single Product Right Sidebar', 'yolo-motor'),
                        'subtitle' => "Choose the default Single Product right sidebar",
                        'data'     => 'sidebars',
                        'desc'     => '',
                        'default'  => 'woocommerce',
                        'required' => array('single_product_sidebar', '=', array('right','both')),
                    ),


                    array(
                        'id'     => 'section-single-product-layout-end',
                        'type'   => 'section',
                        'indent' => false
                    ),


                    array(
                        'id'     => 'section-single-product-title-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Page Title Options', 'yolo-motor'),
                        'indent' => true
                    ),

                    array(
                        'id'       => 'show_single_product_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Show Single Title', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Single Product Title', 'yolo-motor'),
                        'default'  => true
                    ),

                    array(
                        'id'       => 'single_product_title_layout',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Single Product Title Layout', 'yolo-motor'),
                        'subtitle' => esc_html__('Select Single Product Title Layout', 'yolo-motor'),
                        'desc'     => '',
                        'options'  => array('full' => 'Full Width','container' => 'Container', 'container-fluid' => 'Container Fluid'),
                        'default'  => 'full',
                        'required' => array('show_single_product_title', '=', array('1')),
                    ),

                    array(
                        'id'             => 'single_product_title_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => 'px',
                        'units_extended' => 'false',
                        'title'          => esc_html__('Single Product Title Margin', 'yolo-motor'),
                        'subtitle'       => esc_html__('This must be numeric (no px). Leave balnk for default.', 'yolo-motor'),
                        'desc'           => esc_html__('If you would like to override the default single product title top/bottom margin, then you can do so here.', 'yolo-motor'),
                        'left'           => false,
                        'right'          => false,
                        'output'         => array('.single-product-title-margin'),
                        'default'            => array(
                            'margin-top'     => '0',
                            'margin-bottom'  => '70px',
                            'units'          => 'px',
                        ),
                        'required'  => array('show_single_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_product_title_text_align',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Single Product Title Text Align', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Set Single Product Title Text Align', 'yolo-motor' ),
                        'desc'     => '',
                        'options'  => array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
                        'default'  => 'center',
                        'required' => array('show_single_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_product_title_parallax',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Single Product Title Parallax', 'yolo-motor' ),
                        'subtitle' => esc_html__( 'Enable Single Product Title Parallax', 'yolo-motor' ),
                        'default'  => false,
                        'required' => array('show_single_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'single_product_title_height',
                        'type'     => 'dimensions',
                        'title'    => esc_html__('Single Product Title Height', 'yolo-motor'),
                        'subtitle' => esc_html__('This must be numeric (no px) or empty.', 'yolo-motor'),
                        'desc'     => esc_html__('You can set a height for the single product title here', 'yolo-motor'),
                        'required' => array('show_single_product_title', '=', array('1')),
                        'units'    => 'px',
                        'width'    =>  false,
                        'output'   => array('.single-product-title-height'),
                        'default'  => array(
                            'height'  => '300'
                        )
                    ),

                    array(
                        'id'       => 'single_product_title_bg_image',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Single Product Title Background', 'yolo-motor'),
                        'subtitle' => esc_html__('Upload single product title background.', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => array(
                            'url' => $page_title_bg_url
                        ),
                        'required'  => array('show_single_product_title', '=', array('1')),
                    ),

                    array(
                        'id'       => 'breadcrumbs_in_single_product_title',
                        'type'     => 'switch',
                        'title'    => esc_html__('Breadcrumbs in Single Product', 'yolo-motor'),
                        'subtitle' => esc_html__('Enable/Disable Breadcrumbs in Single Product', 'yolo-motor'),
                        'default'  => true
                    ),

                    array(
                        'id'     => 'section-single-product-title-end',
                        'type'   => 'section',
                        'indent' => false
                    ),


                    array(
                        'id'     => 'section-single-product-related-start',
                        'type'   => 'section',
                        'title'  => esc_html__('Product Related Options', 'yolo-motor'),
                        'indent' => true
                    ),
                    array(
                        'id'       => 'related_product_count',
                        'type'     => 'text',
                        'title'    => esc_html__('Related Product Total Record', 'yolo-motor'),
                        'subtitle' => esc_html__('Total Record Of Related Product.', 'yolo-motor'),
                        'validate' => 'number',
                        'default'  => '6',
                    ),

                    array(
                        'id'       => 'related_product_display_columns',
                        'type'     => 'select',
                        'title'    => esc_html__('Related Product Display Columns', 'yolo-motor'),
                        'subtitle' => esc_html__('Choose the number of columns to display on related product.','yolo-motor'),
                        'options'  => array(
                            '3'     => '3',
                            '4'     => '4',
                        ),
                        'desc'    => '',
                        'default' => '4'
                    ),

                    array(
                        'id'      => 'related_product_condition',
                        'type'    => 'checkbox',
                        'title'   => esc_html__('Related Product Condition', 'yolo-motor'),
                        'options' => array(
                            'category' => esc_html__('Same Category','yolo-motor'),
                            'tag'      => esc_html__('Same Tag','yolo-motor'),
                        ),
                        'default' => array(
                            'category' => '1',
                            'tag'      => '1',
                        ),
                    ),

                    array(
                        'id'     => 'section-single-product-related-end',
                        'type'   => 'section',
                        'indent' => false
                    ),

                )
            );

            // Custom CSS & Script
            $this->sections[] = array(
                'title'  => esc_html__( 'Custom CSS & Script', 'yolo-motor' ),
                'desc'   => esc_html__( 'If you change Custom CSS, you must "Save & Generate CSS"', 'yolo-motor' ),
                'icon'   => 'el el-edit',
                'fields' => array(
                    array(
                        'id'       => 'custom_css',
                        'type'     => 'ace_editor',
                        'mode'     => 'css',
                        'theme'    => 'monokai',
                        'title'    => esc_html__('Custom CSS', 'yolo-motor'),
                        'subtitle' => esc_html__('Add some CSS to your theme by adding it to this textarea. Please do not include any style tags.', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 10, 'maxLines' => 60)
                    ),
                    array(
                        'id'       => 'custom_js',
                        'type'     => 'ace_editor',
                        'mode'     => 'javascript',
                        'theme'    => 'chrome',
                        'title'    => esc_html__('Custom JS', 'yolo-motor'),
                        'subtitle' => esc_html__('Add some custom JavaScript to your theme by adding it to this textarea. Please do not include any script tags.', 'yolo-motor'),
                        'desc'     => '',
                        'default'  => '',
                        'options'  => array('minLines'=> 10, 'maxLines' => 60)
                    ),

                )
            );
        }

        public function setHelpTabs() {
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'           => 'yolo_motor_options',
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'       => $theme->get( 'Name' ),
                // Name that appears at the top of your panel
                'display_version'    => $theme->get( 'Version' ),
                // Version that appears at the top of your panel
                'menu_type'          => 'submenu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'     => true,
                // Show the sections below the admin menu item or not
                'menu_title'         => esc_html__( 'Theme Options', 'yolo-motor' ),
                'page_title'         => esc_html__( 'Theme Options', 'yolo-motor' ),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key'     => '',
                // Must be defined to add google fonts to the typography module

                'async_typography'   => false,
                // Use a asynchronous font on the front end or font string
                'admin_bar'          => true,
                // Show the panel pages on the admin bar
                'global_variable'    => '',
                // Set a different name for your global variable other than the opt_name
                'dev_mode'           => false,
                // Show the time the page took to load, etc
                'forced_dev_mode_off' => true,
                // To forcefully disable the dev mode
                'templates_path'     => get_template_directory().'/framework/core/templates/panel',
                // Path to the templates file for various Redux elements
                'customizer'         => true,
                // Enable basic customizer support

                // OPTIONAL -> Give you extra features
                'page_priority'      => null,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'        => 'yolo-options',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_theme_page#Parameters
                'page_permissions'   => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon'          => '',
                // Specify a custom URL to an icon
                'last_tab'           => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon'          => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug'          => '_options',
                // Page slug used to denote the panel
                'save_defaults'      => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show'       => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark'       => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time'     => 60 * MINUTE_IN_SECONDS,
                'output'             => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'         => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'           => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'        => false,
                // REMOVE

                // HINTS
                'hints'              => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'   => 'light',
                        'shadow'  => true,
                        'rounded' => false,
                        'style'   => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'mouseover',
                        ),
                        'hide' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'click mouseleave',
                        ),
                    ),
                )
            );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el el-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el el-facebook'
            );
            $args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el el-twitter'
            );
            $args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el el-linkedin'
            );

        }

    }

    // global $reduxConfig;
    $reduxConfig = new Redux_Framework_options_config();
}