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
// Load the embedded Redux Framework - use this to override redux core
if (file_exists( WP_PLUGIN_DIR.'/redux-framework/ReduxCore/framework.php')) {
    require_once WP_PLUGIN_DIR.'/redux-framework/ReduxCore/framework.php';
}

// Use this to load custom fields,...
require_once get_template_directory() . '/framework/core/option-extensions/loader.php';

if( !class_exists( 'YoloReduxFramework' ) && class_exists( 'ReduxFramework' ) ) { // Fixed for bug if not install redux framework
    class YoloReduxFramework extends ReduxFramework {

        public function ajax_save() {
            if ( ! wp_verify_nonce( $_REQUEST['nonce'], "redux_ajax_nonce" . $this->args['opt_name'] ) ) {
                echo json_encode( array(
                    'status' => esc_html__( 'Invalid security credential.  Please reload the page and try again.', 'yolo-motor' ),
                    'action' => ''
                ) );

                die();
            }

            if ( ! current_user_can( $this->args['page_permissions'] ) ) {
                echo json_encode( array(
                    'status' => esc_html__( 'Invalid user capability.  Please reload the page and try again.', 'yolo-motor' ),
                    'action' => ''
                ) );

                die();
            }

            $redux = ReduxFrameworkInstances::get_instance( $_POST['opt_name'] );
            // Added by GDragon
            $is_generate_less_to_css = false;

            if ( ! empty ( $_POST['data'] ) && ! empty ( $redux->args['opt_name'] ) ) {

                $values = array();

                $_POST['data'] = stripslashes( $_POST['data'] );
                parse_str( $_POST['data'], $values );

                $values = $values[ $redux->args['opt_name'] ];


                if ( function_exists( 'get_magic_quotes_gpc' ) && get_magic_quotes_gpc() ) {
                    $values = array_map( 'stripslashes_deep', $values );
                }

                if ( ! empty ( $values ) ) {

                    try {
                        if ( isset ( $redux->validation_ran ) ) {
                            unset ( $redux->validation_ran );
                        }
                        $redux->set_options( $redux->_validate_options( $values ) );

                        // Added by GDragon
                        if (isset($values['lesscss']) && !empty($values['lesscss'])) {
                            $is_generate_less_to_css = true;
                        }

                        $do_reload = false;
                        if ( isset( $this->reload_fields ) && ! empty( $this->reload_fields ) ) {
                            if ( ! empty( $this->transients['changed_values'] ) ) {
                                foreach ( $this->reload_fields as $idx => $val ) {
                                    if ( array_key_exists( $val, $this->transients['changed_values'] ) ) {
                                        $do_reload = true;
                                    }
                                }
                            }
                        }

                        if ( $do_reload || ( isset ( $values['defaults'] ) && ! empty ( $values['defaults'] ) ) || ( isset ( $values['defaults-section'] ) && ! empty ( $values['defaults-section'] ) ) ) {
                            echo json_encode( array( 'status' => 'success', 'action' => 'reload' ) );
                            die ();
                        }

                        require_once WP_PLUGIN_DIR.'/redux-framework/ReduxCore/core/enqueue.php';
                        $enqueue = new reduxCoreEnqueue ( $redux );
                        $enqueue->get_warnings_and_errors_array();

                        $return_array = array(
                            'status'   => 'success',
                            'options'  => $redux->options,
                            'errors'   => isset ( $redux->localize_data['errors'] ) ? $redux->localize_data['errors'] : null,
                            'warnings' => isset ( $redux->localize_data['warnings'] ) ? $redux->localize_data['warnings'] : null,
                        );

                    } catch ( Exception $e ) {
                        $return_array = array( 'status' => $e->getMessage() );
                    }
                } else {
                    echo json_encode( array( 'status' => esc_html__( 'Your panel has no fields. Nothing to save.', 'yolo-motor' ) ) );
                }
            }
            if ( isset ( $this->transients['run_compiler'] ) && $this->transients['run_compiler'] ) {

                $this->no_output = true;
                $this->_enqueue_output();

                try {
                    /**
                     * action 'redux-compiler-{opt_name}'
                     *
                     * @deprecated
                     *
                     * @param array  options
                     * @param string CSS that get sent to the compiler hook
                     */
                    do_action( "redux-compiler-{$this->args['opt_name']}", $this->options, $this->compilerCSS, $this->transients['changed_values'] ); // REMOVE

                    /**
                     * action 'redux/options/{opt_name}/compiler'
                     *
                     * @param array  options
                     * @param string CSS that get sent to the compiler hook
                     */
                    do_action( "redux/options/{$this->args['opt_name']}/compiler", $this->options, $this->compilerCSS, $this->transients['changed_values'] );

                    /**
                     * action 'redux/options/{opt_name}/compiler/advanced'
                     *
                     * @param array  options
                     * @param string CSS that get sent to the compiler hook, which sends the full Redux object
                     */
                    do_action( "redux/options/{$this->args['opt_name']}/compiler/advanced", $this );
                } catch ( Exception $e ) {
                    $return_array = array( 'status' => $e->getMessage() );
                }

                unset ( $this->transients['run_compiler'] );
                $this->set_transients();
            }
            if ( isset( $return_array ) ) {
                if ( $return_array['status'] == "success" ) {
                    require_once WP_PLUGIN_DIR.'/redux-framework/ReduxCore/core/panel.php';
                    $panel = new reduxCorePanel ( $redux );
                    ob_start();
                    $panel->notification_bar();
                    $notification_bar = ob_get_contents();
                    ob_end_clean();
                    $return_array['notification_bar'] = $notification_bar;
                }

                echo json_encode( apply_filters( "redux/options/{$this->args['opt_name']}/ajax_save/response", $return_array ) );
            }

            // Added by GDragon
            if ($is_generate_less_to_css) {
                // Save & Generate LESS to CSS
                require_once get_template_directory() . '/framework/core/functions/generate-less.php';
                $gen_css = yolo_generate_less();
                if ($gen_css['status'] == 'error') {
                    $error = array( 'status' => $gen_css['message'] );
                    ob_clean();
                    echo json_encode( $error );
                }
            }

            die ();

        }
    }

    do_action( 'redux/init', YoloReduxFramework::init() );
}

