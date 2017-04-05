<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    25/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
$yolo_options = yolo_get_options();
global $post;
$prefix = 'yolo_';
$show_page_title =  get_post_meta(get_the_ID(),$prefix.'show_page_title',true);
if (($show_page_title == -1) || ($show_page_title == '')) {

    $show_page_title = $yolo_options['show_page_title'];

    if (is_singular('product')) {
        $show_page_title = $yolo_options['show_single_product_title'];
    }

    else if (is_singular('yolo_portfolio')) {
        $show_page_title = $yolo_options['show_portfolio_title'];
    }

    else if (is_singular('post')) {
        $show_page_title = $yolo_options['show_single_blog_title'];
    }
    if($show_page_title == ''){
        $show_page_title = true;
    }
}


$page_title = get_post_meta(get_the_ID(),$prefix.'page_title_custom',true);
if ($page_title == '') {
    $page_title = get_the_title();
}

if(is_404()) {
    $page_title = $yolo_options['page_title_404'];
}
$page_sub_title = get_post_meta(get_the_ID(),$prefix.'page_subtitle_custom',true);
if(is_404()) {
    $page_sub_title = $yolo_options['sub_page_title_404'];
}

$page_title_text_color = get_post_meta(get_the_ID(),$prefix.'page_title_text_color', true);


$page_title_bg_color = get_post_meta(get_the_ID(),$prefix.'page_title_bg_color', true);


$enable_custom_page_title_bg_image = get_post_meta(get_the_ID(),$prefix.'enable_custom_page_title_bg_image',true);
$page_title_bg_image_url = '';
if ($enable_custom_page_title_bg_image == '1') {
    $page_title_bg_image = get_post_meta(get_the_ID(),$prefix.'page_title_bg_image', true);
    if ($page_title_bg_image) {
        $page_title_bg_image = wp_get_attachment_url($page_title_bg_image);
        $page_title_bg_image_url = $page_title_bg_image;
    }
} else {
    $page_title_bg_image = $yolo_options['page_title_bg_image'];
    if (is_singular('product')) {
        $page_title_bg_image = $yolo_options['single_product_title_bg_image'];
    }

    else if (is_singular('yolo_portfolio')) {
        $page_title_bg_image = $yolo_options['portfolio_title_bg_image'];
    }


    else if (is_singular('post')) {
        $page_title_bg_image = $yolo_options['single_blog_title_bg_image'];
    }
    if(is_404()){
        $page_title_bg_image = $yolo_options['page_404_bg_image'];
    }
    if (isset($page_title_bg_image) && $page_title_bg_image['url'] != '') {
        $page_title_bg_image_url = $page_title_bg_image['url'];
    }else{
        $page_title_bg_image_url = get_template_directory_uri() . '/assets/images/bg-page-title.png';
    }
}



$page_title_overlay_color = get_post_meta(get_the_ID(),$prefix.'page_title_overlay_color', true);
$page_title_overlay_opacity = '';
$enable_custom_overlay_opacity = get_post_meta(get_the_ID(),$prefix.'enable_custom_overlay_opacity', true);
if ($enable_custom_overlay_opacity == 1) {
    $page_title_overlay_opacity = get_post_meta(get_the_ID(),$prefix.'page_title_overlay_opacity',true) / 100;
}

$page_title_height = get_post_meta(get_the_ID(),$prefix.'page_title_height',true);

$breadcrumbs_in_page_title = get_post_meta(get_the_ID(),$prefix.'breadcrumbs_in_page_title',true);
if (($breadcrumbs_in_page_title == -1) || ($breadcrumbs_in_page_title == '')  ) {
    $breadcrumbs_in_page_title = $yolo_options['breadcrumbs_in_page_title'];

    if (is_singular('product')) {
        $breadcrumbs_in_page_title = $yolo_options['breadcrumbs_in_single_product_title'];

    }

    else if (is_singular('yolo_portfolio')) {
        $breadcrumbs_in_page_title = $yolo_options['breadcrumbs_in_portfolio_title'];
    }

    else if (is_singular('post')) {
        $breadcrumbs_in_page_title = $yolo_options['breadcrumbs_in_single_blog_title'];
    }
}
if(is_404()){
    $breadcrumbs_in_page_title = 0;
}

$page_title_warp_class = array('yolo-page-title-wrap');
$section_page_title_class = array('yolo-page-title-section');

if (is_singular('product')) {
    $page_title_warp_class[] = 'single-product-title-height';
    $section_page_title_class[] = 'single-product-title-margin';
}

else if (is_singular('yolo_portfolio')) {
    $page_title_warp_class[] = 'portfolio-title-height';
    $section_page_title_class[] = 'portfolio-title-margin';
}

else if (is_singular('post')) {
    $page_title_warp_class[] = 'single-blog-title-height';
    $section_page_title_class[] = 'single-blog-title-margin';
} else {
    $page_title_warp_class[] = 'page-title-height';
    $section_page_title_class[] = 'page-title-margin';
}


$breadcrumb_class = array('yolo-breadcrumb-wrap s-color');

$custom_styles = array();

if ($page_title_bg_image_url != '') {
    $page_title_warp_class[] = 'page-title-wrap-bg';
    $custom_styles[] = 'background-image: url(' . $page_title_bg_image_url . ')';
}

if ($page_title_bg_color != '') {
    $custom_styles[] = 'background-color:' . $page_title_bg_color;
}

$custom_text_color_styles = array();
if($page_title_text_color != '') {
    $custom_text_color_styles[] = 'color:' . $page_title_text_color;
}


if (($page_title_height != '') && ($page_title_height > 0)) {
    $custom_styles[] = 'height:' . $page_title_height . 'px';
}


$custom_style= '';
if ($custom_styles) {
    $custom_style = 'style="'. join(';',$custom_styles).'"';
}



$page_title_parallax = get_post_meta(get_the_ID(),$prefix.'page_title_parallax',true);
if (!isset($page_title_parallax) || ($page_title_parallax == '') || ($page_title_parallax == '-1')) {
    $page_title_parallax = $yolo_options['page_title_parallax'];

    if (is_singular('product')) {
        $page_title_parallax = $yolo_options['single_product_title_parallax'];

    }

    else if (is_singular('yolo_portfolio')) {
        $page_title_parallax = $yolo_options['portfolio_title_parallax'];
    }

    else if (is_singular('post')) {
        $page_title_parallax = $yolo_options['single_blog_title_parallax'];
    }
}

if (!empty($page_title_bg_image_url) && ($page_title_parallax == '1')) {
    $custom_style.= ' data-stellar-background-ratio="0.5"';
    $page_title_warp_class[] = 'page-title-parallax';
}

$page_title_text_align = get_post_meta(get_the_ID(),$prefix . 'page_title_text_align',true);
if(!isset($page_title_text_align) || ($page_title_text_align == '') || ($page_title_text_align == '-1')) {
    $page_title_text_align = $yolo_options['page_title_text_align'];

    if (is_singular('product')) {
        $page_title_text_align = $yolo_options['single_product_title_text_align'];

    }

    else if (is_singular('yolo_portfolio')) {
        $page_title_text_align = $yolo_options['portfolio_title_text_align'];
    }

    else if (is_singular('post')) {
        $page_title_text_align = $yolo_options['single_blog_title_text_align'];
    }
}
if (!isset($page_title_text_align) || empty($page_title_text_align)) {
    $page_title_text_align = 'left';
}

$page_title_warp_class[] = 'page-title-' . $page_title_text_align;


$custom_overlay_styles = array();
if ($page_title_overlay_color != '') {
    $custom_overlay_styles[] = 'background-color:' . $page_title_overlay_color;
}

if ($page_title_overlay_opacity != '') {
    $custom_overlay_styles[] = 'opacity:' . $page_title_overlay_opacity;
}
$custom_overlay_style= '';
if ($custom_overlay_styles) {
    $custom_overlay_style = 'style="'. join(';',$custom_overlay_styles).'"';
}

$custom_text_color_style = '';
if ($custom_text_color_styles) {
    $custom_text_color_style = 'style="'. join(';',$custom_text_color_styles).'"';
}




$page_sub_title_text_color = get_post_meta(get_the_ID(),$prefix.'page_sub_title_text_color', true);
$custom_text_sub_title_color_styles = array();
if($page_sub_title_text_color != '') {
    $custom_text_sub_title_color_styles[] = 'color:' . $page_sub_title_text_color;
}
$custom_text_sub_title_color_style = '';
if ($custom_text_sub_title_color_styles) {
    $custom_text_sub_title_color_style = 'style="'. join(';',$custom_text_sub_title_color_styles).'"';
}

$page_title_layout = get_post_meta(get_the_ID(),$prefix.'page_title_layout',true);
if(!isset($page_title_layout) || ($page_title_layout == '') || ($page_title_layout == '-1')) {
    $page_title_layout = $yolo_options['page_title_layout'];

    if (is_singular('product')) {
        $page_title_layout = $yolo_options['single_product_title_layout'];

    }

    else if (is_singular('yolo_portfolio')) {
        $page_title_layout = $yolo_options['portfolio_title_layout'];
    }

    else if (is_singular('post')) {
        $page_title_layout = $yolo_options['single_blog_title_layout'];
    }

}


if (in_array($page_title_layout,array('container','container-fluid'))) {
    $section_page_title_class[] = $page_title_layout;
}

$page_title_remove_margin_top = get_post_meta(get_the_ID(),$prefix.'page_title_remove_margin_top',true);
if ($page_title_remove_margin_top == '1') {
    $section_page_title_class[] = 'page-title-no-margin-top';
}

$page_title_remove_margin_bottom = get_post_meta(get_the_ID(),$prefix.'page_title_remove_margin_bottom',true);
if ($page_title_remove_margin_bottom == '1') {
    $section_page_title_class[] = 'page-title-no-margin-bottom';
}

?>

<?php if (($show_page_title == 1) || ($breadcrumbs_in_page_title == 1)) : ?>
    <div class="<?php echo join(' ',$section_page_title_class) ?>">
    <?php if ($show_page_title == 1) : ?>
        <section  class="<?php echo join(' ', $page_title_warp_class); ?>" <?php echo wp_kses_post($custom_style); ?>>
            <div class="yolo-page-title-overlay" <?php echo wp_kses_post($custom_overlay_style);?>></div>
            <div class="container">
                <div class="page-title-inner block-center">
                    <div class="block-center-inner">
                        <h1 <?php echo wp_kses_post($custom_text_color_style); ?>><?php echo esc_html($page_title); ?></h1>
                        <?php if ($page_sub_title != '') : ?>
                            <span <?php echo wp_kses_post($custom_text_sub_title_color_style); ?> class="page-sub-title"><?php echo esc_html($page_sub_title) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if ($breadcrumbs_in_page_title == 1) : ?>
        <section class="<?php echo join(' ',$breadcrumb_class) ?>">
            <div class="container">
                <?php yolo_the_breadcrumb(); ?>
            </div>
        </section>
    <?php endif; ?>
    </div>
<?php endif; ?>
