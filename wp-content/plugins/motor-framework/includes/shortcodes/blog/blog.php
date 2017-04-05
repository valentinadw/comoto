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

if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if ( ! class_exists('Yolo_Framework_Shortcode_Blog') ) {
    class Yolo_Framework_Shortcode_Blog {
        function __construct() {
            add_shortcode('yolo_blog', array($this, 'yolo_blog_shortcode' ));
        }

        function yolo_blog_shortcode($atts) {
            global $excerpt_length,$padding;

            $atts = vc_map_get_attributes( 'yolo_blog', $atts );
            $type = $columns = $category = $max_items  = $paging_style =  $posts_per_page = $paging_align =  $orderby = $order  = $meta_key  =   $el_class = $yolo_animation = $css_animation = $duration = $delay = $styles_animation = '';
            extract(shortcode_atts(array(
                'type'           => 'large-image',
                'columns'        => '2',
                'padding'        => '',
                'category'       => '',
                'max_items'      => '',
                'paging_style'   => 'all',
                'posts_per_page' => '',
                'paging_align'   => 'right',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'meta_key'       => '',
                'hide_author'    => '',
                'hide_category'  => '',
                'hide_date'      => '',
                'hide_comment'   => '',
                'hide_readmore'  => '',
                'excerpt_length' => '20',
                'el_class'       => '',
                'css_animation'  => '',
                'duration'       => '',
                'delay'          => ''
            ), $atts));
            if (is_front_page()) {
                $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
            } else {
                $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
            }
            $args = array(
                'post_type'           => 'post',
                'paged'               => $paged,
                'ignore_sticky_posts' => true,
                'posts_per_page'      => $max_items > 0 ? $max_items : $posts_per_page,
                'orderby'             => $orderby,
                'order'               => $order,
                'meta_key'            => $orderby == 'meta_key' ? $meta_key : '',
            );

            if ($paging_style == 'all' && $max_items == -1) {
                $args['nopaging'] = true;
            }

            if (!empty($category)) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' 		=> 'category',
                        'terms' 		=>  explode(',',$category),
                        'field' 		=> 'slug',
                        'operator' 		=> 'IN'
                    )
                );
            }

            query_posts($args);

            $class             = array('shortcode-blog-wrap');
            $class[]           = $el_class;
            $class[]           = Yolo_MotorFramework_Shortcodes::yolo_get_css_animation($css_animation);
            $class_name        = join(' ',$class);
            $styles_animation  = Yolo_MotorFramework_Shortcodes::yolo_get_style_animation($duration,$delay);
            if($hide_readmore){$class_name.=' hide_readmore';}
            if($hide_author){$class_name.=' hide_author';}
            if($hide_date){$class_name.=' hide_date';}
            if($hide_comment){$class_name.=' hide_comment';}
            $blog_wrap_class   = array('blog-wrap');
            
            $blog_wrap_class[] = $type;
            
            $blog_class        = array('blog-inner','clearfix');
            $blog_class[]      = 'blog-style-' . $type;
            $blog_class[]      = 'blog-paging-' . $paging_style;

            if ( in_array($type, array('grid','masonry')) ) {
                $blog_class[] = 'blog-col-'.$columns;
            }

            $blog_paging_class   = array('blog-paging-wrapper');
            $blog_paging_class[] = 'blog-paging-'.$paging_style;

            if ($paging_style == 'default') {
                $blog_paging_class[] = 'text-' . $paging_align;
            }

            global $yolo_archive_loop;
            switch ($type) {
                case 'large-image':
                    $yolo_archive_loop['image-size'] = 'blog-large-image-full-width';
                    break;
                case 'medium-image':
                    $yolo_archive_loop['image-size'] = 'blog-medium-image';
                    break;
                case 'grid':
                    $yolo_archive_loop['image-size'] = 'blog-grid';
                    break;
            }

            $yolo_archive_loop['style'] = $type;
            ob_start();
            ?>
            <div class="<?php echo esc_attr($class_name) ?>" <?php if(!empty($styles_animation)):?>style = "<?php echo esc_attr($styles_animation);?>"<?php endif;?>>
                <div class="<?php echo join(' ',$blog_wrap_class); ?>">
                    <div class="<?php echo join(' ',$blog_class); ?>">
                        <?php
                        if ( have_posts() ) :
                            // Start the Loop.
                            while ( have_posts() ) : the_post();
                                /*
                                 * Include the post format-specific template for the content. If you want to
                                 * use this in a child theme, then include a file called called content-___.php
                                 * (where ___ is the post format) and that will be used instead.
                                 */
                                yolo_get_template( 'archive/content' , get_post_format() );
                            endwhile;
                            yolo_archive_loop_reset();
                        else :
                            // If no content, include the "No posts found" template.
                            yolo_get_template( 'archive/content-none');
                        endif;
                        ?>
                    </div>

                    <?php
                    global $wp_query;
                    if ( $wp_query->max_num_pages > 1 && $max_items == -1 ) :
                        ?>
                        <div class="<?php echo join(' ',$blog_paging_class); ?>">
                            <?php
                            switch($paging_style) {
                                case 'load-more':
                                    yolo_paging_load_more();
                                    break;
                                case 'infinity-scroll':
                                    yolo_paging_infinitescroll();
                                    break;
                                default:
                                    echo yolo_paging_nav();
                                    break;
                            }
                            ?>
                        </div>
                    <?php endif;?>

                </div>
            </div>
            <?php
            wp_reset_query();
            $content =  ob_get_clean();
            return $content;
        }
    }

    new Yolo_Framework_Shortcode_Blog();
}
