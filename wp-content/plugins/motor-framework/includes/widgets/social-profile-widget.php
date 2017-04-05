<?php
/**
 *  
 * @package    YoloTheme/Yolo Motor
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

class Yolo_Social_Profile extends  Yolo_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-social-profile';
        $this->widget_description = esc_html__( "Social profile widget", 'yolo-motor' );
        $this->widget_id          = 'yolo-social-profile';
        $this->widget_name        = esc_html__( 'Yolo: Social Profile', 'yolo-motor' );
        $this->settings           = array(
            'label' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Label','yolo-motor' )
            ),
	        'type'  => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => esc_html__( 'Type', 'yolo-motor' ),
                'options' => array(
                    'social-icon-no-border' => esc_html__( 'No Border', 'yolo-motor' ),
                    'social-icon-bordered'  => esc_html__( 'Bordered', 'yolo-motor' )
                )
            ),
            'icons' => array(
				'type'    => 'multi-select',
				'label'   => esc_html__( 'Select social profiles', 'yolo-motor' ),
				'std'     => '',
				'options' => array(
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
	            )
            )
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
		$label        = empty( $instance['label'] ) ? '' : apply_filters( 'widget_label', $instance['label'] );
		$type         = empty( $instance['type'] ) ? '' : apply_filters( 'widget_type', $instance['type'] );
		$icons        = empty( $instance['icons'] ) ? '' : apply_filters( 'widget_icons', $instance['icons'] );
		$widget_id    = $args['widget_id'];
		$social_icons = yolo_get_social_icon($icons,'social-profile ' . $type );
	    echo wp_kses_post( $before_widget );
	    ?>
	    <?php if (!empty($label)) : ?>
		    <span><?php echo wp_kses_post($label); ?></span>
		<?php endif; ?>
		    <?php echo wp_kses_post( $social_icons ); ?>
	    <?php
	    echo wp_kses_post( $after_widget );
    }
}
if ( ! function_exists('yolo_register_social_profile') ) {
    function yolo_register_social_profile() {
        register_widget('Yolo_Social_Profile');
    }

    add_action('widgets_init', 'yolo_register_social_profile', 1);
}