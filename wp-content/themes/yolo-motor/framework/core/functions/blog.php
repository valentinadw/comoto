<?php
/**  
 *
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 *  
 * 1. Add new Column to admin manager
 * 2. Paging blog function
 * 3. Get post thumbnail
 * 4. Get post date
 */ 

/* 1. Add new Column to admin manager */
/* 1.1. Add new column for post */ 
function yolo_add_post_columns_head($columns) {
    $columns['post-format'] = esc_html__('Format', 'yolo-motor');
    return $columns;
}
 
/* 1.2. Show new column value */
function yolo_set_post_columns_value($column, $post_id) {

    if ($column == 'post-format') {
        $post_format = get_post_format();
        switch ($post_format) {
            case false: // Standart post
                echo '<label class="post-format-icon post-format-standard"></label>';
                break;
            case 'aside':
                echo '<label class="post-format-icon post-format-aside"></label>';
                break;
            case 'image':
                echo '<label class="post-format-icon post-format-image"></label>';
                break;
            case 'gallery':
                echo '<label class="post-format-icon post-format-gallery"></label>';
                break;
            case 'video':
                echo '<label class="post-format-icon post-format-video"></label>';
                break;
            case 'audio':
                echo '<label class="post-format-icon post-format-audio"></label>';
                break;
            case 'quote':
                echo '<label class="post-format-icon post-format-quote"></label>';
                break;
            case 'link':
                echo '<label class="post-format-icon post-format-link"></label>';
                break;
            
            default:
                echo '<label class="post-format-icon post-format-standard"></label>';
                break;
        }
    }
}
/* 1.3. Add Hook */
if( is_admin() ) {
    add_filter( 'manage_posts_columns', 'yolo_add_post_columns_head' );
    add_action( 'manage_posts_custom_column', 'yolo_set_post_columns_value', 10, 2 );
}

/* 2. Paging blog function */
/* 2.1. Paging Load More */
if (!function_exists('yolo_paging_load_more')) {
	function yolo_paging_load_more() {
		global $wp_query;
		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}
		$link = get_next_posts_page_link($wp_query->max_num_pages);
		if (!empty($link)) :
			?>
			<button data-href="<?php echo esc_url($link); ?>" type="button"  data-loading-text="<span class='fa fa-spinner fa-spin'></span> <?php esc_html_e("Loading...",'yolo-motor'); ?>" class="blog-load-more motor-button style1 button-2x" autocomplete="off">
				<?php esc_html_e("Load More",'yolo-motor'); ?>
			</button>
		<?php
		endif;
	}
}

/* 2.2. Paging Infinite Scroll */
if (!function_exists('yolo_paging_infinitescroll')) {
	function yolo_paging_infinitescroll(){
		global $wp_query;
		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}
		$link = get_next_posts_page_link($wp_query->max_num_pages);
		if (!empty($link)) :
			?>
			<nav id="infinite_scroll_button">
				<a href="<?php echo esc_url($link); ?>"></a>
			</nav>
			<div id="infinite_scroll_loading" class="text-center infinite-scroll-loading"></div>
		<?php
		endif;
	}
}

/* 2.3. Paging Nav */
if ( ! function_exists( 'yolo_paging_nav' ) ) {
	function yolo_paging_nav() {
		global $wp_query, $wp_rewrite;
		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = esc_url(remove_query_arg( array_keys( $query_args ), $pagenum_link ));
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$page_links = paginate_links( array(
            'base'      => $pagenum_link,
            'format'    => $format,
            'total'     => $wp_query->max_num_pages,
            'current'   => $paged,
            'mid_size'  => 1,
            'add_args'  => array_map( 'urlencode', $query_args ),
            'prev_text' => '<i class="fa fa-angle-double-left"></i>',
            'next_text' => '<i class="fa fa-angle-double-right"></i>',
            'type'      => 'array'
		) );

		if (count($page_links) == 0) return;

		$links = "<ul class='pagination'>\n\t<li>";
		$links .= join("</li>\n\t<li>", $page_links);
		$links .= "</li>\n</ul>\n";

		return $links;
	}
}

/* 3. Get post thumbnail */
/* 3.1. Get post thumbnail */
if (!function_exists('yolo_post_thumbnail')) {
    function yolo_post_thumbnail($size = '') {
        $html   = '';
        $prefix = 'yolo_';
        $width  = '';
        $height = '';
        $yolo_image_size = yolo_get_image_size();
        if (isset($yolo_image_size[$size])) {
            $width  = $yolo_image_size[$size]['width'];
            $height = $yolo_image_size[$size]['height'];
        }

        switch(get_post_format()) {
            case 'image' :
                $args = array(
                    'size'     => $size,
                    'meta_key' => $prefix.'post_format_image'
                );
                $image = yolo_get_image($args);
                if (!$image) break;
                $html = yolo_get_image_hover($image,$size, get_permalink(), the_title_attribute('echo=0'),get_the_ID());
                break;
            case 'gallery':
                $images = get_post_meta(get_the_ID(), $prefix.'post_format_gallery');
                if (count($images) > 0) {
                    $data_plugin_options = "data-plugin-options = 1";
                    $html = "<div class='owl-carousel' $data_plugin_options>";
                    foreach ($images as $image) {
                        if (empty($width) || empty($height)) {
                            $image_src_arr = wp_get_attachment_image_src( $image, $size );
                            if ($image_src_arr) {
                                $image_src = $image_src_arr[0];
                            }
                        } else {
                            $image_src = matthewruddy_image_resize_id($image,$width,$height);
                        }

                        if (!empty($image_src)) {
                            $html .= yolo_get_image_hover($image_src,$size, get_permalink(), the_title_attribute('echo=0'),get_the_ID(),1);
                        }
                    }
                    $html .= '</div>';
                } else {
                    $args = array(
                        'size'     => $size,
                        'meta_key' => ''
                    );
                    $image = yolo_get_image($args);
                    if (!$image) break;
                    $html = yolo_get_image_hover($image,$size, get_permalink(), the_title_attribute('echo=0'),get_the_ID());
                }
                break;
            case 'video':
                $video = get_post_meta(get_the_ID(), $prefix.'post_format_video');
                if (!is_single()) {
                    $args = array(
                        'size' => $size,
                        'meta_key' => ''
                    );
                    $image = yolo_get_image($args);
                    if (!$image) {
                        if (count($video) > 0) {
                            $html .= '<div class="embed-responsive embed-responsive-16by9 embed-responsive-' . $size . '">';
                            $video = $video[0];
                            // If URL: show oEmbed HTML
                            if (filter_var($video, FILTER_VALIDATE_URL)) {
                                $args = array(
                                    'wmode' => 'transparent'
                                );
                                $html .= wp_oembed_get($video, $args);
                            } // If embed code: just display
                            else {
                                $html .= $video;
                            }
                            $html .= '</div>';
                        }
                    } else {
                        $video = $video[0];
                        if (filter_var($video, FILTER_VALIDATE_URL)) {
                            $html .= yolo_get_video_hover($image, get_permalink(), the_title_attribute('echo=0'), $video);
                        } else {
                            $html .= '<div class="embed-responsive embed-responsive-16by9 embed-responsive-' . $size . '">';
                            $html .= $video;
                            $html .= '</div>';
                        }
                    }
                } else {
                    if (count($video) > 0) {
                        $html .= '<div class="embed-responsive embed-responsive-16by9 embed-responsive-' . $size . '">';
                        $video = $video[0];
                        // If URL: show oEmbed HTML
                        if (filter_var($video, FILTER_VALIDATE_URL)) {
                            $args = array(
                                'wmode' => 'transparent'
                            );
                            $html .= wp_oembed_get($video, $args);
                        } // If embed code: just display
                        else {
                            $html .= $video;
                        }
                        $html .= '</div>';
                    }
                }
                break;
            case 'audio':
                $audio = get_post_meta(get_the_ID(), $prefix.'post_format_audio');
                if (count($audio) > 0) {
                    // @TODO: update image hover audio
                    $audio = $audio[0];
                    if (filter_var($audio, FILTER_VALIDATE_URL)) {
                        $html .= wp_oembed_get($audio);
                        $title = esc_attr(get_the_title());
                        $audio = esc_url($audio);
                        if (empty($html)) {
                            $id   = uniqid();
                            $html .= "<div data-player='$id' class='jp-jplayer' data-audio='$audio' data-title='$title'></div>";
                            $html .= yolo_jplayer($id);
                        }
                    } else {
                        $html .= $audio;
                    }
                    $html .= '<div style="clear:both;"></div>';
                }
                break;
            default:
                $args = array(
                    'size'     => $size,
                    'meta_key' => ''
                );
                $image = yolo_get_image($args);
                if (!$image) break;
                $html = yolo_get_image_hover($image,$size, get_permalink(), the_title_attribute('echo=0'),get_the_ID());
                break;
        }
        return $html;
    }
}

/* 3.2 Get post image */ 
if (!function_exists('yolo_get_image')) {
    function yolo_get_image($args) {
        $default = apply_filters(
            'yolo_get_image_default_args',
            array(
                'post_id'  => get_the_ID(),
                'size'     => '',
                'width'    => '',
                'height'   => '',
                'attr'     => '',
                'meta_key' => '',
                'scan'     => false,
                'default'  => ''
            )
        );

        $args   = wp_parse_args( $args, $default );
        $size   = $args['size'];
        
        $width  = '';
        $height = '';

        $yolo_image_size = yolo_get_image_size();
        if (isset($yolo_image_size[$size])) {
            $width  = $yolo_image_size[$size]['width'];
            $height = $yolo_image_size[$size]['height'];
        }

        if ( ! $args['post_id'] ) {
            $args['post_id'] = get_the_ID();
        }

        // Get image from cache
        $key         = md5( serialize( $args ) );
        $image_cache = wp_cache_get( $args['post_id'], 'yolo_get_image' );

        if ( ! is_array( $image_cache ) ) {
            $image_cache = array();
        }

        if ( empty( $image_cache[$key] ) ) {
            $image_src = '';

            // Get post thumbnail
            if (has_post_thumbnail($args['post_id'])) {
                $post_thumbnail_id   = get_post_thumbnail_id($args['post_id']);
                if (empty($width) || empty($height)) {
                    $image_src_arr = wp_get_attachment_image_src( $post_thumbnail_id, $size );
                    if ($image_src_arr) {
                        $image_src = $image_src_arr[0];
                    }
                } else {
                    $image_src = matthewruddy_image_resize_id($post_thumbnail_id,$width,$height);
                }
            }

            // Get the first image in the custom field
            if ((!isset($image_src) || empty($image_src))  && $args['meta_key']) {
                $post_thumbnail_id = get_post_meta( $args['post_id'], $args['meta_key'], true );
                if ( $post_thumbnail_id ) {
                    if (empty($width) || empty($height)) {
                        $image_src_arr = wp_get_attachment_image_src( $post_thumbnail_id, $size );
                        if ($image_src_arr) {
                            $image_src = $image_src_arr[0];
                        }
                    } else {
                        $image_src = matthewruddy_image_resize_id($post_thumbnail_id,$width,$height);
                    }
                }
            }

            // Get the first image in the post content
            if ((!isset($image_src) || empty($image_src)) && ($args['scan'])) {
                preg_match( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $args['post_id'] ), $matches );
                if ( ! empty( $matches ) ){
                    $image_src  = $matches[1];
                }
            }

            // Use default when nothing found
            if ( (!isset($image_src) || empty($image_src)) && ! empty( $args['default'] ) ){
                if ( is_array( $args['default'] ) ){
                    $image_src  = @$args['src'];
                } else {
                    $image_src = $args['default'];
                }
            }

            if (!isset($image_src) || empty($image_src)) {
                return false;
            }

            $image_cache[$key] = $image_src;
            wp_cache_set( $args['post_id'], $image_cache, 'yolo_get_image' );
        } else {
            $image_src = $image_cache[$key];
        }
        $image_src = apply_filters( 'yolo_get_image', $image_src, $args );

        return $image_src;
    }
}

/* 3.3 Get image hover */ 
if (!function_exists('yolo_get_image_hover')) {
    function yolo_get_image_hover($image,$size, $url, $title, $post_id,$gallery = 0) {
        $attachment_id  = yolo_get_attachment_id_from_url($image);
        $image_full_arr = wp_get_attachment_image_src($attachment_id,'full');
        $image_full     = $image;
        if (isset($image_full_arr)) {
            $image_full = $image_full_arr[0];
        }

        $width  = '';
        $height = '';

	    $yolo_image_size = yolo_get_image_size();
	    if (isset($yolo_image_size[$size])) {
            $width  = $yolo_image_size[$size]['width'];
            $height = $yolo_image_size[$size]['height'];
	    } else {
		    global $_wp_additional_image_sizes;
		    if ( in_array( $size, array( 'thumbnail', 'medium', 'large' ) ) ) {
                $width  = get_option( $size . '_size_w' );
                $height = get_option( $size . '_size_h' );
		    } elseif ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
                $width  = $_wp_additional_image_sizes[ $size ]['width'];
                $height = $_wp_additional_image_sizes[ $size ]['height'];
		    }
	    }

        $prettyPhoto = 'prettyPhoto';
        if ($gallery == 1) {
            $prettyPhoto='prettyPhoto[blog_'.$post_id.']';
        }

	    if (empty($width) || empty($height)) { // href="%1$s"
		    return sprintf('<div class="entry-thumbnail">
                                <a title="%2$s" class="entry-thumbnail_overlay">
                                    <img class="img-responsive" src="%3$s" alt="%2$s"/>
                                </a>
                                <a data-rel="%5$s" href="%4$s" class="prettyPhoto"><i class="fa fa-arrows-alt"></i></a>
                            </div>',
			    $url,
			    $title,
			    $image,
			    $image_full,
			    $prettyPhoto
		    );
	    } else { //href="%1$s"
		    return sprintf('<div class="entry-thumbnail">
                                <a title="%2$s" class="entry-thumbnail_overlay">
                                    <img width="%6$s" height="%7$s" class="img-responsive" src="%3$s" alt="%2$s"/>
                                </a>
                                <a data-rel="%5$s" href="%4$s" class="prettyPhoto"><i class="fa fa-arrows-alt"></i></a>
                            </div>',
			    $url,
			    $title,
			    $image,
			    $image_full,
			    $prettyPhoto,
			    $width,
			    $height
		    );
	    }

    }
}

/* 3.4 Get video hover */ 
if (!function_exists('yolo_get_video_hover')) {
    function yolo_get_video_hover($image, $url, $title, $video_url) {
        return sprintf('<div class="entry-thumbnail">
                            <a class="entry-thumbnail_overlay" href="%1$s" title="%2$s">
                                <img class="img-responsive" src="%3$s" alt="%2$s"/>
                            </a>
                            <a data-rel="prettyPhoto" href="%4$s" class="prettyPhoto"><i class="fa fa-play-circle-o"></i></a>
                        </div>',
            $url,
            $title,
            $image,
            $video_url
        );
    }
}

/* 3.4 Get attachment ID form URL */ 
if (!function_exists('yolo_get_attachment_id_from_url')) {
    function yolo_get_attachment_id_from_url($attachment_url = '') {
        global $wpdb;
        $attachment_id = false;

        // If there is no url, return.
        if ( '' == $attachment_url )
            return;

        // Get the upload directory paths
        $upload_dir_paths = wp_upload_dir();

        // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
        if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

            // Remove the upload path base directory from the attachment URL
            $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

            // Finally, run a custom database query to get the attachment ID from the modified attachment URL
            $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

        }
        return $attachment_id;
    }
}

/* 3.5 Get JPlayer */ 
if (!function_exists('yolo_jplayer')) {
    function yolo_jplayer($id = 'jp_container_1') {
        ob_start();
        ?>
        <div id="<?php echo esc_attr($id); ?>" class="jp-audio">
            <div class="jp-type-playlist">
                <div class="jp-gui jp-interface">
                    <ul class="jp-controls jp-play-pause">
                        <li><a href="javascript:;" class="jp-play" tabindex="1"><i class="fa fa-play-circle-o"></i> <?php esc_html_e('play', 'yolo-motor'); ?></a></li>
                        <li><a href="javascript:;" class="jp-pause" tabindex="1"><i class="fa fa-pause"></i> <?php esc_html_e('pause', 'yolo-motor'); ?></a></li>
                    </ul>

                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                    </div>

                    <ul class="jp-controls jp-volume">
                        <li>
                            <a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><i class="fa fa-volume-up"></i> <?php esc_html_e('mute', 'yolo-motor'); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><i class="fa fa-volume-off"></i><?php esc_html_e('unmute', 'yolo-motor'); ?></a>
                        </li>
                        <li>
                            <div class="jp-volume-bar">
                                <div class="jp-volume-bar-value"></div>
                            </div>
                        </li>
                    </ul>

                    <div class="jp-time-holder">
                        <div class="jp-current-time"></div>
                        <div class="jp-duration"></div>
                    </div>
                    <ul class="jp-toggles">
                        <li>
                            <a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle"><?php esc_html_e('shuffle', 'yolo-motor'); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off"><?php esc_html_e('shuffle off', 'yolo-motor'); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><?php esc_html_e('repeat', 'yolo-motor'); ?></a>
                        </li>
                        <li>
                            <a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><?php esc_html_e('repeat off', 'yolo-motor'); ?></a>
                        </li>
                    </ul>
                </div>

                <div class="jp-no-solution">
                    <?php printf(esc_html__('<span>Update Required</span> To play the media you will need to either update your browser to a recent version or update your <a href="%s" target="_blank">Flash plugin</a>.', 'yolo-motor'), 'http://get.adobe.com/flashplayer/'); ?>
                </div>
            </div>
        </div>
        <?php
        $content = ob_get_clean();

        return $content;
    }
}

/* 4 Get Post Date */ 
if (!function_exists('yolo_post_date')) {
    function yolo_post_date() {
        ob_start();
        ?>
        <div class="entry-date">
            <div class="entry-date-inner">
                <div class="day">
                    <?php echo get_the_time('d'); ?>
                </div>
                <div class="month">
                    <?php echo get_the_date('M'); ?>
                </div>
            </div>
        </div>
    <?php
        $content = ob_get_clean();
        echo wp_kses_post($content);
    }
}

/* 5. Get Archive Post Meta */
if (!function_exists('yolo_post_meta')) {
    function yolo_post_meta() {
        yolo_get_template('archive/post-meta');
    }
}

/* 6. Get single Post Meta */
if (!function_exists('yolo_single_post_meta')) {
    function yolo_single_post_meta() {
        yolo_get_template('single-blog/post-meta');
    }
}

/* 7. Archive Loop reset */
if (!function_exists('yolo_archive_loop_reset')) {
    function yolo_archive_loop_reset() {
        global $yolo_archive_loop;
        $yolo_archive_loop['image-size'] = '';
        $yolo_archive_loop['style']      = '';
    }
}

/* 8. Post naviagation */
if (!function_exists('yolo_post_nav')) {
    function yolo_post_nav() {
        yolo_get_template('single-blog/post-nav');
    }
    add_action('yolo_after_single_post','yolo_post_nav',20);
}

/* 9. Link pages */
if (!function_exists('yolo_link_pages')) {
    function yolo_link_pages() {
        wp_link_pages(array(
            'before'      => '<div class="yolo-page-links"><span class="yolo-page-links-title">' . esc_html__('Pages:', 'yolo-motor') . '</span>',
            'after'       => '</div>',
            'link_before' => '<span class="yolo-page-link">',
            'link_after'  => '</span>',
        ));
    }
    add_action('yolo_after_single_post_content','yolo_link_pages',5);
}

/* 10. Post tags */
if (!function_exists('yolo_post_tags')) {
    function yolo_post_tags() {
        yolo_get_template('single-blog/post-tags');
    }
    add_action('yolo_after_single_post_content','yolo_post_tags',10);
}

/* 11. Share */
if (!function_exists('yolo_share')) {
    function yolo_share() {
        yolo_get_template('social-share');
    }
    add_action('yolo_after_single_post_content','yolo_share',15);
}

/* 12. Author Info */
if (!function_exists('yolo_post_author_info')) {
    function yolo_post_author_info() {
        yolo_get_template('single-blog/post-author-info');
    }
    add_action('yolo_after_single_post','yolo_post_author_info',25);
}

/* 13. Render Comments */
if (!function_exists('yolo_render_comments')) {
    function yolo_render_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
            <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
                <?php echo get_avatar($comment, $args['avatar_size']); ?>
                <div class="comment-text">
                    <div class="author">
                        <span class="author-name"><?php printf(esc_html__('%s', 'yolo-motor'), get_comment_author_link()) ?></span>
                        <span class="comment-meta-date">
                           <span class="time">
                                <?php echo sprintf(esc_html__('%1$s ago', 'yolo-motor') , esc_html(yolo_relative_time(get_comment_date('U')))); ?>
                            </span>
                        </span>
                    </div>
                    <div class="text">
                        <?php comment_text(); ?>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em><?php esc_html_e('Your comment is awaiting moderation.', 'yolo-motor') ?></em>
                        <?php endif; ?>
                    </div>
                    <div class="comment-meta">
                        <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                        <?php edit_comment_link(esc_html__('Edit', 'yolo-motor'), '', '') ?>
                    </div>
                </div>
            </div>
    <?php
    }
}

/* 13. Comments Form */
if (!function_exists('yolo_comment_form')) {
    function yolo_comment_form( $args = array(), $post_id = null ) {
        global $id;
        $user = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';

        if ( null === $post_id ) {
            $post_id = $id;
        }
        else {
            $id = $post_id;
        }

        if ( comments_open( $post_id ) ) :
        ?>
        <div id="respond-wrap">
            <?php
                $commenter = wp_get_current_commenter();
                $req       = get_option( 'require_name_email' );
                $aria_req  = ( $req ? " aria-required='true'" : '' );
                $fields    =  array(
                    'author'        => '<div class="yolo-row"><p class="comment-form-author  yolo-sm-6"><input id="author" name="author" type="text" placeholder="' . esc_html__( 'Enter Your Name*', 'yolo-motor' ) . '" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
                    'email'         => '<p class="comment-form-email yolo-sm-6"><input id="email" name="email" type="text" placeholder="' . esc_html__( 'Enter Your Email*', 'yolo-motor' ) . '" class="form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
                    'comment_field' => '<div class="yolo-sm-12"><p class="comment-form-comment"><textarea class="form-control" placeholder="' . esc_html__( 'Enter Your Comment', 'yolo-motor' ) . '" id="comment" name="comment" cols="40" rows="6" aria-required="true"></textarea></p></div></div>'
                );
                $comments_args = array(
                        'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
                        'logged_in_as'         => '<p class="logged-in-as">' . sprintf( wp_kses(__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'yolo-motor' ), yolo_allowed_tags()), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
                        'title_reply'          => sprintf('<span>%s</span>', esc_html__( 'Leave your thought', 'yolo-motor' )),
                        'title_reply_to'       => sprintf('<span>%s</span>', esc_html__( 'Leave a reply to %s', 'yolo-motor' )),
                        'cancel_reply_link'    => esc_html__( 'Click here to cancel the reply', 'yolo-motor' ),
                        'comment_notes_before' => '',
                        'comment_notes_after'  => '',
                        'label_submit'         => esc_html__( 'Post Comments', 'yolo-motor' ),
                        'comment_field'        => '',
                        'must_log_in'          => ''
                );
                if(is_user_logged_in()) {
                    $comments_args['comment_field'] = '<p class="comment-form-comment"><textarea class="form-control" placeholder="' . esc_html__( 'Enter Your Comment', 'yolo-motor' ) . '" id="comment" name="comment" cols="40" rows="6" aria-required="true"></textarea></p>';
                }
                comment_form($comments_args);
            ?>
        </div>

        <?php
        endif;
    }
}
if (!function_exists('yolo_relative_time')) {
    function yolo_relative_time($a='') {
       return human_time_diff($a, current_time( 'timestamp' ));
    }
}
/* 14. Replaces the excerpt "more" text by a link */
if (!function_exists('yolo_excerpt_more')) {
    function yolo_excerpt_more($more) {
        global $post;
        return '...';
    }
    add_filter('excerpt_more', 'yolo_excerpt_more');
}

/* 15. Image size */
if (!function_exists('yolo_get_image_size')) {
    function yolo_get_image_size() {
        $yolo_image_size = array(
            'blog-large-image-full-width' => array(
                'width'  => 1170,
                'height' => 780
            ),
            'blog-large-image-sidebar' => array(
                'width'  => 870,
                'height' => 580
            ),
            'blog-medium-image' => array(
                'width'  => 400,
                'height' => 267
            ),
            'blog-grid' => array(
                'width'  => 420,
                'height' => 280
            ),
            'blog-related' => array(
                'width'  => 380,
                'height' => 235
            )
        );

        return $yolo_image_size;
    }
}