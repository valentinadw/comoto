<?php
/**
 * Testimonial post type
 *  
 * @package    YoloTheme/Yolo Motor
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if ( !class_exists( 'Yolo_Testimonial_Post_Type' ) ) {
    class Yolo_Testimonial_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'yolo_testimonial';

            add_action('init', array($this,'yolo_testimonial'));
            add_action('admin_init', array($this, 'yolo_register_meta_boxes'));

            if( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                // Add custom columns reference: http://code.tutsplus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
                add_filter( 'manage_yolo_testimonial_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_yolo_testimonial_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }
        }

        function remove_plugin_metaboxes() {
            remove_meta_box('mymetabox_revslider_0', 'yolo_testimonial', 'normal');
            remove_meta_box('handlediv', 'yolo_testimonial', 'normal');
            remove_meta_box('commentsdiv', 'yolo_testimonial', 'normal');
        }

        function yolo_testimonial() {
            $labels = array(
                'name'               => esc_html__( 'Testimonials', 'yolo-motor' ),
                'singular_name'      => esc_html__( 'Testimonial', 'yolo-motor' ),
                'menu_name'          => esc_html__( 'Testimonials', 'yolo-motor' ),
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display client\'s testimonials', 'yolo-motor' ),
                'supports'              => array( 'title', 'editor', 'thumbnail' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-id',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => false,
                'capability_type'       => 'post',
            );

            register_post_type( 'yolo_testimonial', $args );

            // Register a taxonomy for Testimonials Categories.
            $category_labels = array(
                'name'                          => esc_html__( 'Testimonial Categories', 'yolo-motor' ) ,
                'singular_name'                 => esc_html__( 'Testimonial Category', 'yolo-motor') ,
                'menu_name'                     => esc_html__( 'Testimonial Categories', 'yolo-motor' ) ,
                'all_items'                     => esc_html__( 'All Testimonial Categories', 'yolo-motor' ) ,
                'edit_item'                     => esc_html__( 'Edit Testimonial Category', 'yolo-motor' ) ,
                'view_item'                     => esc_html__( 'View Testimonial Category', 'yolo-motor' ) ,
                'update_item'                   => esc_html__( 'Update Testimonial Category', 'yolo-motor' ) ,
                'add_new_item'                  => esc_html__( 'Add New Testimonial Category', 'yolo-motor' ) ,
                'new_item_name'                 => esc_html__( 'New Testimonial Category Name', 'yolo-motor' ) ,
                'parent_item'                   => esc_html__( 'Parent Testimonial Category', 'yolo-motor' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Testimonial Category:', 'yolo-motor' ) ,
                'search_items'                  => esc_html__( 'Search Testimonial Categories', 'yolo-motor' ) ,
                'popular_items'                 => esc_html__( 'Popular Testimonial Categories', 'yolo-motor') ,
                'separate_items_with_commas'    => esc_html__( 'Separate Testimonial Categories with commas', 'yolo-motor' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Testimonial Categories', 'yolo-motor' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Testimonial Categories', 'yolo-motor' ) ,
                'not_found'                     => esc_html__( 'No Testimonial Categories found', 'yolo-motor' ) ,
            );

            $category_args = array(
                'labels'            => $category_labels,
                'public'            => false,
                'show_ui'           => true,
                'show_in_nav_menus' => false,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => 'testimonial_category',
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('testimonial_category', array(
                'yolo_testimonial'
            ) , $category_args);
        }

        // Add columns to Testimonial
        function add_columns($columns) {
            unset(
                $columns['cb'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Name', 'yolo-motor' )));
            $cols = array_merge($cols, array('email' => esc_html__( 'Email', 'yolo-motor' )));
            $cols = array_merge($cols, array('thumbnail' => esc_html__( 'Picture', 'yolo-motor' )));
            $cols = array_merge($cols, array('date' => esc_html__( 'Date', 'yolo-motor' )));

            return $cols;
        }

        // Set values for columns
        function set_columns_value($column, $post_id) {
            $prefix = $this->prefix;
            
            switch ($column) {
                case 'id': {
                    echo wp_kses_post($post_id);
                    break;
                }
                case 'email': {
                    echo get_post_meta($post_id, "{$prefix}_email", true);
                    break;
                }
                case 'thumbnail': {
                    echo get_the_post_thumbnail($post_id, 'thumbnail');
                    break;
                }
            }
        }

        // Register metaboxies
        function yolo_register_meta_boxes() {
            $prefix       = $this->prefix;

            $meta_boxes   = array();
            $meta_boxes[] = array(
                'id'            => "{$prefix}_meta_boxes",
                'title'         => esc_html__( 'Testimonial Information:', 'yolo-motor' ),
                'post_types'    => array( 'yolo_testimonial' ),
                'fields'        => array(
                    array(
                        'id'    => "{$prefix}_email",
                        'name'  => esc_html__( 'Email', 'yolo-motor' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_position",
                        'name'  => esc_html__( 'Position', 'yolo-motor' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_url",
                        'name'  => esc_html__( 'URL', 'yolo-motor' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_special",
                        'name'  => esc_html__( 'Special', 'yolo-motor' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'      => "{$prefix}_rating",
                        'name'  => esc_html__( 'Rating', 'yolo-motor' ),
                        'type'    => 'select',
                        'options' => array(
                            '-1'  => esc_html__( 'no rating', 'yolo-motor' ),
                            '0'   => esc_html__( '0 star', 'yolo-motor' ),
                            '0.5' => esc_html__( '0.5 star', 'yolo-motor' ),
                            '1'   => esc_html__( '1 star', 'yolo-motor' ),
                            '1.5' => esc_html__( '1.5 stars', 'yolo-motor' ),
                            '2'   => esc_html__( '2 stars', 'yolo-motor' ),
                            '2.5' => esc_html__( '2.5 stars', 'yolo-motor' ),
                            '3'   => esc_html__( '3 stars', 'yolo-motor' ),
                            '3.5' => esc_html__( '3.5 stars', 'yolo-motor' ),
                            '4'   => esc_html__( '4 stars', 'yolo-motor' ),
                            '4.5' => esc_html__( '4.5 stars', 'yolo-motor' ),
                            '5'   => esc_html__( '5 stars', 'yolo-motor' ),
                        )
                    ),
                    array(
                        'id'    => "{$prefix}_background",
                        'name'  => esc_html__( 'Background Image', 'yolo-motor' ),
                        'type'  => 'image_advanced',
                    ),
                )
            );
            
            // Use RW Metaboxies fields
            if ( class_exists('RW_Meta_Box') ) {
                foreach ($meta_boxes as $meta_box) {
                    new RW_Meta_Box($meta_box);
                }
            }
        }
    }

    new Yolo_Testimonial_Post_Type;
}