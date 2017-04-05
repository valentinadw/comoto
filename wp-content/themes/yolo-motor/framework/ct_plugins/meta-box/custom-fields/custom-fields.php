<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if(!function_exists('custom_fields_enqueue_scripts')) {
    function custom_fields_enqueue_scripts() {
        wp_enqueue_style( 'rwmb-custom-fields', get_template_directory_uri(). '/framework/ct_plugins/meta-box/custom-fields/assets/css/custom-fields.css', array() );

        wp_enqueue_script( 'rwmb-button-set', get_template_directory_uri(). '/framework/ct_plugins/meta-box/custom-fields/assets/js/custom-fields.js', array('jquery-ui-sortable'),null, true );
    }
    
    add_action( 'admin_enqueue_scripts', 'custom_fields_enqueue_scripts' );
}

//button_set_field
if ( ! class_exists( 'RWMB_Button_Set_Field' ) )
{
	class RWMB_Button_Set_Field extends RWMB_Field
	{
		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$html = '<div class="rwmb-button-set">';

			if (isset($field['options']) && is_array($field['options']) && !array_key_exists($meta, $field['options']) && isset($field['std'])) {
				$meta = $field['std'];
			}

			$html .= sprintf(
				'<input type="hidden" class="rwmb-hidden" name="%s" id="%s" value="%s" />',
				$field['field_name'],
				$field['id'],
				$meta
			);

			$html .= sprintf('<div class="rwmb-button-set-inner%s"%s>',
				isset($field['allowClear']) && $field['allowClear'] == true ? ' allow-clear' : '',
				(isset($field['allowClear']) && $field['allowClear'] == true) && isset($field['clearValue']) ? ' data-clear-value="' . $field['clearValue'] . '"' : '');

			foreach ( $field['options'] as $value => $label )
			{
				$html .= sprintf(
					'<label%s data-value="%s"><span>%s</span></label>',
					$meta == $value ? ' class="selected"' : '',
					$value,
					$label
				);
			}
			$html .= '</div>';

			$html .= '</div>';
			return $html;
		}

	}
}

//checkbox_advanced_field
if ( ! class_exists( 'RWMB_Checkbox_Advanced_Field' ) )
{
	class RWMB_Checkbox_Advanced_Field extends RWMB_Input_Field
	{
		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$html = sprintf(
				'<input type="checkbox" class="rwmb-checkbox" name="%s" id="%s" value="1" %s>',
				$field['field_name'],
				$field['id'],
				checked( ! empty( $meta ), 1, false )
			);

			$html .= sprintf('<label for="%s" data-on="ON" data-off="OFF"></label>',
				$field['id']
				);

			return $html;
		}

		/**
		 * Set the value of checkbox to 1 or 0 instead of 'checked' and empty string
		 * This prevents using default value once the checkbox has been unchecked
		 *
		 * @link https://github.com/rilwis/meta-box/issues/6
		 *
		 * @param mixed $new
		 * @param mixed $old
		 * @param int   $post_id
		 * @param array $field
		 *
		 * @return int
		 */
		static function value( $new, $old, $post_id, $field )
		{
			return empty( $new ) ? 0 : 1;
		}

		/**
		 * Output the field value
		 * Display 'Yes' or 'No' instead of '1' and '0'
		 *
		 * Note: we don't echo the field value directly. We return the output HTML of field, which will be used in
		 * rwmb_the_field function later.
		 *
		 * @use self::get_value()
		 * @see rwmb_the_field()
		 *
		 * @param  array    $field   Field parameters
		 * @param  array    $args    Additional arguments. Rarely used. See specific fields for details
		 * @param  int|null $post_id Post ID. null for current post. Optional.
		 *
		 * @return string HTML output of the field
		 */
		static function the_value( $field, $args = array(), $post_id = null )
		{
			$value = self::get_value( $field, $args, $post_id );

			return $value ? esc_html__( 'Yes', 'yolo-motor' ) : esc_html__( 'No', 'yolo-motor' );
		}
	}
}

//footer_field
if ( !class_exists( 'RWMB_Footer_Field' ) ) {
	class RWMB_Footer_Field extends RWMB_Field {

		/**
		 * Get field HTML
		 *
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $meta, $field ) {		
			$html = sprintf('<select class="rwmb-footer" name="%s" id="%s">',
				$field['field_name'],
				$field['id']
				);

			$html .= self::options_html( $field, $meta );
			$html .= '</select>';

			return $html;
		}

		/**
		 * Creates html for options
		 *
		 * @param array $field
		 * @param mixed $meta
		 *
		 * @return array
		 */
		static function options_html( $field, $meta )
		{	
			$field['options'] = self::get_footer_posts();

			$html = '';
			$html .= '<option value="">'. esc_html__( 'Default', 'yolo-motor' ) .'</option>';
			$option = '<option value="%s"%s>%s</option>';

			foreach ( $field['options'] as $value => $label ) {
				$html .= sprintf(
					$option,
					$value,
					selected( in_array( $value, (array) $meta ), true, false ),
					$label
				);
			}

			return $html;
		}

		// Get Footer Block to render
		static function get_footer_posts() {
            $args = array(
                'posts_per_page'   => -1,
                'post_type'        => 'yolo_footer',
                'post_status'      => 'publish',
            );
            $posts_array = get_posts( $args );
            foreach ( $posts_array as $k => $v ) {
                $footer[$v->ID] = $v->post_title;
            }

            return $footer;
		}
	}
}

//image_set_field
if ( ! class_exists( 'RWMB_Image_Set_Field' ) )
{
	class RWMB_Image_Set_Field extends RWMB_Field
	{

		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$html = sprintf('<div class="rwmb-image-set">');
			$html .= sprintf(
				'<input type="hidden" class="rwmb-hidden" name="%s" id="%s" value="%s" />',
				$field['field_name'],
				$field['id'],
				$meta
			);

			$style = '';
			if (isset($field['width'])) {
				$style .= 'width:' . $field['width'] . ';';
			}
			if (isset($field['height'])) {
				$style .= 'height:' . $field['height'] . ';';
			}

			$html .= sprintf('<div class="rwmb-image-set-inner%s"%s>',
				isset($field['allowClear']) && $field['allowClear'] == true ? ' allow-clear' : '',
				(isset($field['allowClear']) && $field['allowClear'] == true) && isset($field['clearValue']) ? ' data-clear-value="' . $field['clearValue'] . '"' : '');
			foreach ( $field['options'] as $value => $src )
			{
				$html .= sprintf(
					'<label%s data-value="%s"><img%s src="%s"/></label>',
					$meta == $value ? ' class="selected"' : '',
					$value,
					$style == '' ? '' : ' style="' . $style . '"',
					$src
				);
			}

			$html .= '</div>';

			$html .= '</div>';
			return $html;
		}

	}
}

//section_field
if ( ! class_exists( 'RWMB_Section_Field' ) )
{
	class RWMB_Section_Field extends RWMB_Field
	{
		/**
		 * Show begin HTML markup for fields
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function begin_html( $meta, $field )
		{
			return '<div class="rwmb-section"><span>' . $field['name'] . '</span>';
		}

		/**
		 * Show end HTML markup for fields
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function end_html( $meta, $field )
		{
			return '</div>';
		}
	}
}

//sorter_field
if ( ! class_exists( 'RWMB_Sorter_Field' ) )
{
	class RWMB_Sorter_Field extends RWMB_Field
	{
		
		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$meta_arr = array();
			if (isset($meta['enable'])) {
				$meta_arr = explode('||', $meta['enable']);
			}
			$html = sprintf('<div class="rwmb-sorter">');
			$html .= sprintf(
				'<input type="hidden" class="rwmb-hidden" name="%s[enable]" value="%s" data-enable="true"/>',
				$field['field_name'],
				isset($meta['enable']) ? $meta['enable'] : ''
			);
			$html .= sprintf(
				'<input type="hidden" class="rwmb-hidden" name="%s[sort]" value="%s" data-sort="true"/>',
				$field['field_name'],
				isset($meta['sort']) ? $meta['sort'] : ''
			);
			$options = array();
			if (isset($meta['sort'])) {
				$meta_sort_arr = explode('||', $meta['sort']);
				foreach ($meta_sort_arr as $key) {
					if (isset($field['options']) && isset($field['options'][$key])) {
						$options[$key] = $field['options'][$key];
					}
				}
			}
			foreach ( $field['options'] as $key => $value )
			{
				$options[$key] = $value;
			}

			$html .= sprintf('<ul class="rwmb-sorter-inner">');
			foreach ( $options as $key => $value )
			{
				$html .= '<li>';
				$html .= sprintf('<span>%s</span>', $value);
				$html .= sprintf(
					'<input type="checkbox" class="rwmb-checkbox" id="%s" value="%s"%s>',
					$field['id'] . '_' . $key,
					$key,
					in_array($key, $meta_arr) ? ' checked="checked"' : ''
				);

				$html .= sprintf('<label for="%s" data-on="ON" data-off="OFF"></label>',
					$field['id'] . '_' . $key
				);
				$html .= '</li>';
			}

			$html .= '</ul>';

			$html .= '</div>';
			return $html;
		}


	}
}