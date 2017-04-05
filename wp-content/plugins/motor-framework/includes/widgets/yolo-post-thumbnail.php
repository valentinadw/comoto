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

class Yolo_Post_Thumbnail_Widget extends Yolo_Widget {

	public function __construct() {
		$this->widget_cssclass    = 'widget-post-thumbnail';
		$this->widget_description = esc_html__( "Widget post with thumbnail.", 'yolo-motor' );
		$this->widget_id          = 'yolo_widget_post_thumbnail';
		$this->widget_name        = esc_html__( 'Post Thumbnail', 'yolo-motor' );
		$this->cached = false;
		$categories = array();
		$categories = get_categories( array(
				'orderby' => 'NAME',
				'order' => 'ASC'
		));
		$categories_options = array();
		foreach ($categories as $category) {
			$categories_options[$category->term_id] = $category->name;
		}
		$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'std'	=>'',
					'label' => esc_html__( 'Title', 'yolo-motor' )
				),
				'style' => array(
					'type' => 'select',
					'std'  => '',
					'label'=> esc_html__('Style', 'yolo-motor'),
					'options' => array(
							'full_width'   => esc_html__( 'Full-width', 'yolo-motor' ),
							'size-thumbnail'   => esc_html__( 'Thumbnail', 'yolo-motor' ),
							'date'   => esc_html__( 'Date', 'yolo-motor' )
					)
				),
				'posts_per_page' => array(
					'type'  => 'number',
					'step'  => 1,
					'min'   => 1,
					'max'   => '',
					'std'   => 5,
					'label' => esc_html__( 'Number of posts to show', 'yolo-motor' )
				),
				'orderby' => array(
					'type'  => 'select',
					'std'   => 'date',
					'label' => esc_html__( 'Order by', 'yolo-motor' ),
					'options' => array(
							'latest'   => esc_html__( 'Latest', 'yolo-motor' ),
							'popular'   => esc_html__( 'Popular', 'yolo-motor' ),
							'comment'  => esc_html__( 'Most Commented', 'yolo-motor' ),
					)
				),
				'categories' => array(
						'type'  => 'select',
						'std'   => '',
						'multiple'=> '1',
						'label'=>esc_html__('Categories','yolo-motor'),
						'desc' => esc_html__( 'Select a category or leave blank for all', 'yolo-motor' ),
						'options' => $categories_options,
				),
				'hide_author' => array(
						'type'  => 'checkbox',
						'std'   => 0,
						'label' => esc_html__( 'Hide author in post meta info', 'yolo-motor' )
				),
				'hide_date' => array(
						'type'  => 'checkbox',
						'std'   => 0,
						'label' => esc_html__( 'Hide date in post meta info', 'yolo-motor' )
				),
				'hide_comment' => array(
						'type'  => 'checkbox',
						'std'   => 0,
						'label' => esc_html__( 'Hide comment in post meta info', 'yolo-motor' )
				),
		);
		parent::__construct();
	}
	
	public function widget($args, $instance){
		ob_start();
		extract( $args );
		$title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$posts_per_page      = absint( $instance['posts_per_page'] );
		$orderby     = sanitize_title( $instance['orderby'] );
		$hide_date = isset($instance['hide_date']) && $instance['hide_date'] === '1' ? true : false;
		$hide_author = isset($instance['hide_author']) && $instance['hide_author'] === '1' ? true : false;
		$hide_comment = isset($instance['hide_comment']) && $instance['hide_comment'] === '1' ? true : false;
		$categories  = $instance['categories'];
		if(!empty($categories)){
			$categories = str_replace('||',',',$categories);
		}
		$style = $instance['style'];
		$query_args  = array(
				'posts_per_page' => $posts_per_page,
				'post_status' 	 => 'publish',
				'ignore_sticky_posts' => 1,
				'orderby' => 'date',
				"meta_key" => "_thumbnail_id",
				'order' => 'DESC',
		);
		if($orderby == 'comment'){
			$query_args['orderby'] = 'comment_count';
		}
		if($orderby == 'popular') {
			$query_args['orderby'] = 'meta_value_num';
		}
		if(!empty($categories)){
			$query_args['cat'] = $categories;
		}
		$r = new WP_Query($query_args);
		if($r->have_posts()):
			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;
				echo '<ul class="posts-thumbnail-list '.$style.'">';
				while ($r->have_posts()): 
					$r->the_post();
					global $post;
					$time = get_the_date('d F');
					$time = explode(' ', $time);
					echo '<li class="clearfix">';
					if($style == 'date'):
						echo '<div class="posts-date">';
						echo '<time datetime="'.get_the_date('c').'">';
							echo '<span class="day">'.$time[0].'</span>';
							echo '<span class="month">'.$time[1].'</span>';
						echo '</time>';	
						echo '</div>';
						else:
						echo '<div class="posts-thumbnail-image">';
						echo '<a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(null,'yolo-thumbnail-square', array('title' => strip_tags(get_the_title()))).'</a>';
						echo '</div>';
					endif;
					echo '<div class="posts-thumbnail-content">';
						echo '<h4><a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'">'.get_the_title().'</a></h4>';
						echo '<div class="posts-thumbnail-meta">';
						if(!$hide_author)
							echo '<span class="author vcard">'.get_the_author().'</span>';
						if(!$hide_date)
							echo '<time datetime="'.get_the_date('c').'">'.get_the_date('M, Y').'</time>';
						
						if(!$hide_date && !$hide_comment)
							echo ' ';

						// if ($style =="full_width") {
						// 	echo '<i class="fa fa-user"></i><span class="author vcard">'.get_the_author().'</span>';
						// }
						
						if(!$hide_comment){
							$output = '';
							$number = get_comments_number($post->ID);
							if ( $number > 1 ) {
								$output = str_replace( '%', number_format_i18n( $number ), ( false === false ) ? esc_html__( '%', 'yolo-motor' ) : false );
							} elseif ( $number == 0 ) {
								$output = ( false === false ) ? esc_html__( '0', 'yolo-motor' ) : false;
							} else { // must be one
								$output = ( false === false ) ? esc_html__( '1', 'yolo-motor' ) : false;
							}
							echo '<span class="comment-count"><i class="fa fa-comments-o"></i><a href="'.esc_url(get_comments_link()).'">'.$output.'</a></span>';	
						}
						echo '</div>';
					echo '</div>';
					echo '</li>';
				endwhile;
				echo  '</ul>';
			echo $after_widget;
		endif;
		$content = ob_get_clean();
		wp_reset_postdata();
		echo $content;
	}
	
}
if (!function_exists('yolo_register_widget_post_thumbnail')) {
	function yolo_register_widget_post_thumbnail() {
		register_widget('Yolo_Post_Thumbnail_Widget');
	}
	add_action('widgets_init', 'yolo_register_widget_post_thumbnail');
}

