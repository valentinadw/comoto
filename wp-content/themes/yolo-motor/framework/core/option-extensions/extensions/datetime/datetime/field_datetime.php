<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys
 * @version     3.1.5
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_datetime' ) ) {

    /**
     * Main ReduxFramework_datetime class
     *
     * @since       1.0.0
     */
    class ReduxFramework_datetime extends ReduxFramework {
    
        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
        
            
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }    

            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options'           => array(),
                'stylesheet'        => '',
                'output'            => true,
                'enqueue'           => true,
                'enqueue_frontend'  => true
            );
            $this->field = wp_parse_args( $this->field, $defaults );            
        
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */

        public function render() {
            // Clone form text_field
            if ( ! empty( $this->field['data'] ) && empty( $this->field['options'] ) ) {
                if ( empty( $this->field['args'] ) ) {
                    $this->field['args'] = array();
                }

                $this->field['options'] = $this->parent->get_wordpress_data( $this->field['data'], $this->field['args'] );
                $this->field['class'] .= " hasOptions ";
            }

            if ( empty( $this->value ) && ! empty( $this->field['data'] ) && ! empty( $this->field['options'] ) ) {
                $this->value = $this->field['options'];
            }

            //if (isset($this->field['text_hint']) && is_array($this->field['text_hint'])) {
            $qtip_title = isset( $this->field['text_hint']['title'] ) ? 'qtip-title="' . $this->field['text_hint']['title'] . '" ' : '';
            $qtip_text  = isset( $this->field['text_hint']['content'] ) ? 'qtip-content="' . $this->field['text_hint']['content'] . '" ' : '';
            //}

            $readonly       = ( isset( $this->field['readonly'] ) && $this->field['readonly']) ? ' readonly="readonly"' : '';
            $autocomplete   = ( isset($this->field['autocomplete']) && $this->field['autocomplete'] == false) ? ' autocomplete="off"' : ''; 

            if ( isset( $this->field['options'] ) && ! empty( $this->field['options'] ) ) {

                $placeholder = '';
                if ( isset( $this->field['placeholder'] ) ) {
                    $placeholder = $this->field['placeholder'];
                }                    

                foreach ( $this->field['options'] as $k => $v ) {
                    if ( ! empty( $placeholder ) ) {
                        $placeholder = ( is_array( $this->field['placeholder'] ) && isset( $this->field['placeholder'][ $k ] ) ) ? ' placeholder="' . esc_attr( $this->field['placeholder'][ $k ] ) . '" ' : '';
                    }

                    echo '<div class="input_wrapper">';
                    echo '<label for="' . $this->field['id'] . '-datetime-' . $k . '">' . $v . '</label> ';
                    echo '<input ' . $qtip_title . $qtip_text . 'type="text" id="' . $this->field['id'] . '-datetime-' . $k . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '[' . $k . ']' . '" ' . $placeholder . 'value="' . esc_attr( $this->value[ $k ] ) . '" class="regular-text ' . $this->field['class'] . '"' . $readonly . $autocomplete . ' /><br />';
                    echo '</div>';
                }
                //foreach
            } else {
                $placeholder = ( isset( $this->field['placeholder'] ) && ! is_array( $this->field['placeholder'] ) ) ? ' placeholder="' . esc_attr( $this->field['placeholder'] ) . '" ' : '';
                echo '<input ' . $qtip_title . $qtip_text . 'type="text" id="' . $this->field['id'] . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '" ' . $placeholder . 'value="' . esc_attr( $this->value ) . '" class="regular-text ' . $this->field['class'] . '"' . $readonly . $autocomplete . ' />';
            }
            
        } //function
    
        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {

            // $extension = ReduxFramework_extension_datetime::getInstance();
        
            wp_enqueue_script(
                'redux-field-datetime-js',
                $this->extension_url . 'field_datetime.js', 
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-datetime-css', 
                $this->extension_url . 'field_datetime.css',
                time(),
                true
            );
        
        }
        
        /**
         * Output Function.
         *
         * Used to enqueue to the front-end
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */        
        public function output() {

            if ( $this->field['enqueue_frontend'] ) {

            }
            
        }        
        
    }
}
