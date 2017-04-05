<?php
/**
 * Yolo Theme Framework includes
 *
 * The $yolo_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed.
 *
 * Please note that missing files will produce a fatal error.
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
if ( !class_exists( 'Yolo_Install_Plugin' ) ) :
    class Yolo_Install_Plugin {
        /**
         * Variable to hold required / recommended plugins.
         *
         * @var  array
         */
        public static $plugins;
        /**
         * Get purchase code
         *
         * @package     Motor/Plugins
         * @author      KENT <tuanlv@vietbrain.com>
         * @version     1.0
         */

        public function __construct(){
            require_once get_template_directory() . '/framework/includes/yolo-dash/tgmpa/class-tgm-plugin-activation.php';
            add_action( 'tgmpa_register', array(&$this,'yolo_register_required_plugins') );
            add_action( 'admin_init', array(&$this,'yolo_updater_plugin_load') );
            add_filter( 'upgrader_pre_download', array(&$this,'yolo_upgrader_pre_download'), 10, 3 );
            add_action( 'vc_after_init', array(&$this,'yolo_enable_vc_auto_theme_update') );
        }
        public function yolo_get_purchase() {

                $theme_options = get_option( 'yolo-motor-license-settings' );

                if( $theme_options && isset( $theme_options['license_key'] ) ) {
                    return $theme_options['license_key'];
                }

                return false;

        }


        /**
         * Check plugin active
         *
         * @package     Motor/Plugins
         * @author      KENT <tuanlv@vietbrain.com>
         * @version     1.0
         */

        
        public static function yolo_is_plugin_active( $plugin ) {

            include_once ABSPATH . 'wp-admin/includes/plugin.php';
            return is_plugin_active( $plugin );

        }



        /**
         * Register the required plugins for this theme.
         *
         * In this example, we register two plugins - one included with the TGMPA library
         * and one from the .org repo.
         *
         * The variable passed to tgmpa_register_plugins() should be an array of plugin
         * arrays.
         *
         * This function is hooked into tgmpa_init, which is fired within the
         * TGM_Plugin_Activation class constructor.
         */
        public function yolo_register_required_plugins() {

            if ( !current_user_can( 'install_plugins' ) ) {
                return;
            }
            /*
             * Array of plugin arrays. Required keys are name and slug.
             * If the source is NOT from the .org repo, then source is also required.
             */
            if ( ! isset( self::$plugins ) ) {
                self::$plugins = array(

                    array(
                        'name'               => 'Motor Framework', // The plugin name
                        'slug'               => 'motor-framework', // The plugin slug (typically the folder name)
                        'source'             => esc_url( 'http://update.yolotheme.com/download/motor-framework.zip' ), // The plugin source
                        'required'           => true, // If false, the plugin is only 'recommended' instead of required
                        'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                        'version'            => '',
                        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                        'external_url'       => '', // If set, overrides default API URL and points to an external URL
                    ),
                    array(
                        'name'               => 'Revolution Slider', // The plugin name
                        'slug'               => 'revslider', // The plugin slug (typically the folder name)
                        'source'             => esc_url( 'http://update.yolotheme.com/download/revslider.zip' ), // The plugin source
                        'required'           => true, // If false, the plugin is only 'recommended' instead of required
                        'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                        'version'            => '',
                        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                        'external_url'       => '', // If set, overrides default API URL and points to an external URL
                    ),
                    array(
                        'name'               => 'Visual Composer', // The plugin name
                        'slug'               => 'js_composer', // The plugin slug (typically the folder name)
                        'source'             => esc_url( 'http://update.yolotheme.com/download/js_composer.zip' ), // The plugin source
                        'required'           => true, // If false, the plugin is only 'recommended' instead of required
                        'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                        'version'            => '',
                        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                        'external_url'       => '', // If set, overrides default API URL and points to an external URL
                    ),
                    array(
                        'name'               => 'WP Modal Login', // The plugin name
                        'source'             => esc_url( 'http://update.yolotheme.com/download/wp-modal-login.zip' ),
                        'slug'               => 'wp-modal-login', // The plugin slug (typically the folder name)
                        'required'           => false, // If false, the plugin is only 'recommended' instead of required
                        'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                        'version'            => '',
                        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                        'external_url'       => '', // If set, overrides default API URL and points to an external URL
                    ),
                    array(
                        'name'               => 'Redux Framework', // The plugin name
                        'slug'               => 'redux-framework', // The plugin slug (typically the folder name)
                        'required'           => true, // If false, the plugin is only 'recommended' instead of required
                    ),
                    array(
                        'name'               => 'Meta Box', // The plugin name
                        'slug'               => 'meta-box', // The plugin slug (typically the folder name)
                        'required'           => true, // If false, the plugin is only 'recommended' instead of required
                    ),
                    array(
                        'name'               => 'WooCommerce', // The plugin name
                        'slug'               => 'woocommerce', // The plugin slug (typically the folder name)
                        'required'           => false, // If false, the plugin is only 'recommended' instead of required
                    ),
                    array(
                        'name'               => 'YITH WooCommerce Wishlist', // The plugin name
                        'slug'               => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
                        'required'           => false, // If false, the plugin is only 'recommended' instead of required
                    ),
                    array(
                        'name'               => 'YITH Woocommerce Compare', // The plugin name
                        'slug'               => 'yith-woocommerce-compare', // The plugin slug (typically the folder name)
                        'required'           => false, // If false, the plugin is only 'recommended' instead of required
                    ),
                    array(
                        'name'               => 'Contact Form 7', // The plugin name
                        'slug'               => 'contact-form-7', // The plugin slug (typically the folder name)
                        'required'           => false, // If false, the plugin is only 'recommended' instead of required
                    ),       
                    array(
                        'name'               => 'WP Instagram Widget', // The plugin name
                        'slug'               => 'wp-instagram-widget', // The plugin slug (typically the folder name)
                        'required'           => false, // If false, the plugin is only 'recommended' instead of required
                    ),
                );
            }

            /*
             * Array of configuration settings. Amend each line as needed.
             * If you want the default strings to be available under your own theme domain,
             * leave the strings uncommented.
             * Some of the strings are added into a sprintf, so see the comments at the
             * end of each line for what each argument will be.
             */

            // Change this to your theme text domain, used for internationalising strings
            $config = array(
                'domain'       => 'yolo-motor',
                'id'           => 'g_theme_id',                 // Unique ID for hashing notices for multiple instances of TGMPA.
                'default_path' => '',                      // Default absolute path to pre-packaged plugins.
                'menu'         => 'install-required-plugins', // Menu slug.
                'parent_slug'  => 'themes.php',            // Parent menu slug.
                'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
                'has_notices'  => true,                    // Show admin notices or not.
                'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
                'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => false,                   // Automatically activate plugins after installation or not.
                'message'      => '',                      // Message to output right before the plugins table.
                'strings'      => array(
                    'page_title'                      => esc_html( 'Install Required Plugins', 'yolo-motor' ),
                    'menu_title'                      => esc_html( 'Install Plugins', 'yolo-motor' ),
                    'installing'                      => esc_html( 'Installing Plugin: %s', 'yolo-motor' ), // %s = plugin name.
                    'oops'                            => esc_html( 'Something went wrong with the plugin API.', 'yolo-motor' ),
                    'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'yolo-motor' ), // %1$s = plugin name(s).
                    'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'yolo-motor' ), // %1$s = plugin name(s).
                    'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'yolo-motor' ), // %1$s = plugin name(s).
                    'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'yolo-motor' ), // %1$s = plugin name(s).
                    'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'yolo-motor' ), // %1$s = plugin name(s).
                    'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'yolo-motor' ), // %1$s = plugin name(s).
                    'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'yolo-motor' ), // %1$s = plugin name(s).
                    'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'yolo-motor' ), // %1$s = plugin name(s).
                    'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'yolo-motor' ),
                    'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'yolo-motor' ),
                    'return'                          => esc_html( 'Return to Required Plugins Installer', 'yolo-motor' ),
                    'plugin_activated'                => esc_html( 'Plugin activated successfully.', 'yolo-motor' ),
                    'complete'                        => esc_html( 'All plugins installed and activated successfully. %s', 'yolo-motor' ), // %s = dashboard link.
                    'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
                )
            );

            tgmpa(self::$plugins, $config );

        }
        /**
         * Send request update plugin
         *
         * @package     Motor/Plugins
         * @author      KENT <tuanlv@vietbrain.com>
         * @version     1.0
         */
        // if ( ! function_exists( 'yolo_updater_plugin_load' ) ) :
        
        public function yolo_updater_plugin_load() {

            if ( !current_user_can( 'update_plugins' ) ) {
                return;
            }

            if ( !$this->yolo_get_purchase() ) {
                return;
            }
            
            if ( ! class_exists( 'TGM_Updater' ) ) {
                require_once get_template_directory() . '/framework/includes/yolo-dash/tgmpa/class-tgm-updater.php';
            }

            /**
             * Check version plugin Visual Composer
             */
            if( self::yolo_is_plugin_active( 'js_composer/js_composer.php' ) ) {
                
                $plugin_data = get_plugin_data(trailingslashit(WP_PLUGIN_DIR).'js_composer/js_composer.php');

                $data_plugin_update = array(
                    'plugin_name' => esc_html__( 'WPBakery Visual Composer', 'yolo-motor' ),
                    'plugin_slug' => 'js_composer',
                    'plugin_path' => 'js_composer/js_composer.php',
                    'plugin_url'  => trailingslashit( WP_PLUGIN_URL ) . 'yolo-motor',
                    'remote_url'  => esc_url( 'http://update.yolotheme.com/plugins/js_composer.json' ),
                    'version'     => $plugin_data['Version'],
                    'key'         => ''
                );

                $tgm_updater = new TGM_Updater( $data_plugin_update );

            }
            /**
             * Check version plugin Yolo Motor Framework
             */
            if( self::yolo_is_plugin_active( 'motor-framework/motor-framework.php' ) ) {
                
                $plugin_data = get_plugin_data(trailingslashit(WP_PLUGIN_DIR).'motor-framework/motor-framework.php');
                
                $data_plugin_update = array(
                    'plugin_name' => esc_html__( 'Motor Framework', 'yolo-motor' ),
                    'plugin_slug' => 'motor-framework',
                    'plugin_path' => 'motor-framework/motor-framework.php',
                    'plugin_url'  => trailingslashit( WP_PLUGIN_URL ) . 'motor-framework',
                    'remote_url'  => esc_url( 'http://update.yolotheme.com/plugins/motor-framework.json' ),
                    'version'     => $plugin_data['Version'],
                    'key'         => ''
                );

                $tgm_updater = new TGM_Updater( $data_plugin_update );

            }
            /**
             * Check version plugin Revolution Slider
             */
            if( self::yolo_is_plugin_active( 'revslider/revslider.php' ) ) {
                
                $plugin_data = get_plugin_data(trailingslashit(WP_PLUGIN_DIR).'revslider/revslider.php');
                $data_plugin_update = array(
                    'plugin_name' => esc_html__( 'Revolution Slider', 'yolo-motor' ),
                    'plugin_slug' => 'revslider',
                    'plugin_path' => 'revslider/revslider.php',
                    'plugin_url'  => trailingslashit( WP_PLUGIN_URL ) . 'revslider',
                    'remote_url'  => esc_url( 'http://update.yolotheme.com/plugins/revslider.json' ),
                    'version'     => $plugin_data['Version'],
                    'key'         => ''
                );

                $tgm_updater = new TGM_Updater( $data_plugin_update );

            }
        }

        // endif;
        /**
         * Send request validate to server
         *
         * @package     Motor/Plugins
         * @author      KENT <tuanlv@vietbrain.com>
         * @version     1.0
         */
       
        public function yolo_upgrader_pre_download( $reply, $package, $upgrader ) {

            if( strpos( $package, 'yolotheme.com' ) !== false ) {

                if( ! $this->yolo_get_purchase() ) {
                    return new WP_Error( 
                        'yolo_purchase_empty', 
                        sprintf(
                            wp_kses(
                                __( 'Purchase code verification failed. <a href="%s">Enter Purchase Code</a>', 'yolo-motor'), 
                                array( 'a' => array( 'href' => array() ), 'Motor' )
                            ),
                            esc_url( admin_url( 'admin.php?page=yolo-options#verify' ) ) 
                        )
                    );
                }

                $data_request = wp_remote_get(
                    add_query_arg(
                        array(
                            'code'           => $this->yolo_get_purchase(), 
                            'site_url'       => get_site_url(), 
                            'package'        => 'yolo-motor',
                            'install-plugin' => true
                        ), 
                        'http://update.yolotheme.com'
                    ), 
                    array( 'timeout' => 60 )
                );
                
                if( is_wp_error( $data_request ) ) {
                    return new WP_Error(
                        'yolo_connection_failed', 
                        esc_html__( 'Some troubles with connecting to YoloTheme server.', 'yolo-motor' )
                    );
                }
                $rp_data = json_decode( $data_request['body'], true );

                if( !( is_array( $rp_data ) && isset( $rp_data['status'] ) && $rp_data['status'] ) ) {
                    return new WP_Error(
                        'yolo_strater_purchase_error', 
                        sprintf(
                            wp_kses(
                                __( 'Purchase code verification failed. <a href="%s">Enter Purchase Code</a>', 'yolo-motor'), 
                                array( 'a' => array( 'href' => array() ) )
                            ), 
                            esc_url( admin_url( 'admin.php?page=yolo-options#verify' ) )
                        )
                    );
                }
            }

            return $reply;

        }

        

    /**
     * Remove notice update visual composer
     *
     * @package     Motor/Plugins
     * @author      KENT <tuanlv@vietbrain.com>
     * @version     1.0
     */

        
        public function yolo_enable_vc_auto_theme_update() {

            if( function_exists('vc_updater') ) {
                $vc_updater = vc_updater();
                remove_filter( 'upgrader_pre_download', array( $vc_updater, 'preUpgradeFilter' ), 10 );
                if( function_exists( 'vc_license' ) ) {
                    if( !vc_license()->isActivated() ) {
                        remove_filter( 'pre_set_site_transient_update_plugins', array( $vc_updater->updateManager(), 'check_update' ), 10 );
                    }
                }
                remove_filter( 'admin_notices', array( vc_license(), 'adminNoticeLicenseActivation' ) );
            }

        }
    }
    new Yolo_Install_Plugin;
endif;