<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    28/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

$yolo_options = yolo_get_options();
$show_page_title = isset($yolo_options['show_archive_product_title']) ? true: $yolo_options['show_archive_product_title'];
$product_show_result_count = $yolo_options['product_show_result_count'];
$product_show_catalog_ordering = $yolo_options['product_show_catalog_ordering'];

$prefix = 'yolo_';

$page_sub_title = strip_tags(term_description());

//archive
$page_title_bg_image = '';
$page_title_height   = '';
$page_title_bg_image_url = '';
$cat                 = get_queried_object();
if ($cat && property_exists( $cat, 'term_id' )) {
    $page_title_bg_image = get_tax_meta($cat,$prefix.'page_title_background');
    $page_title_height   = get_tax_meta($cat,$prefix.'page_title_height');
}

if(!$page_title_bg_image || $page_title_bg_image == '') {
    $page_title_bg_image = $yolo_options['archive_product_title_bg_image'];
}

if (isset($page_title_bg_image) && $page_title_bg_image['url'] != '') {
    $page_title_bg_image_url = $page_title_bg_image['url'];
}else{
    $page_title_bg_image_url = get_template_directory_uri() . '/assets/images/bg-page-title.png';
}


$breadcrumbs_in_page_title     = $yolo_options['breadcrumbs_in_archive_product_title'];

$breadcrumb_class              = array('yolo-breadcrumb-wrap breadcrumb-archive-product-wrap');

$page_title_warp_class   = array();
$page_title_warp_class[] = 'yolo-page-title-wrap archive-product-title-height';

$custom_styles = array();

if ($page_title_bg_image_url != '') {
    $page_title_warp_class[] = 'page-title-wrap-bg';
    $custom_styles[]         = 'background-image: url(' . $page_title_bg_image_url . ');';
}

if (($page_title_height != '') && ($page_title_height > 0)) {
    $custom_styles[] = 'height:' . $page_title_height . 'px';
}

$custom_style = '';
if ($custom_styles) {
    $custom_style = 'style="'. join(';',$custom_styles).'"';
}

$page_title_parallax = $yolo_options['archive_product_title_parallax'];

if (!empty($page_title_bg_image_url) && ($page_title_parallax == '1')) {
    $custom_style            .= ' data-stellar-background-ratio="0.5"';
    $page_title_warp_class[] = 'page-title-parallax';
}

$page_title_text_align = $yolo_options['archive_product_title_text_align'];
if (!isset($page_title_text_align) || empty($page_title_text_align)) {
    $page_title_text_align = 'left';
}
$page_title_warp_class[] = 'page-title-' . $page_title_text_align;


$section_page_title_class = array('yolo-page-title-section archive-product-title-margin');
$page_title_layout        = $yolo_options['archive_product_title_layout'];
if (in_array($page_title_layout,array('container','container-fluid'))) {
    $section_page_title_class[] = $page_title_layout;
}
?>
<?php if (($show_page_title == 1) || ($breadcrumbs_in_page_title == 1)) :
     ?>
    <div class="<?php echo join(' ',$section_page_title_class) ?>">
        <?php if ($show_page_title == 1) : ?>
            <section class="<?php echo join(' ',$page_title_warp_class); ?>" <?php echo wp_kses_post($custom_style); ?>>
                <div class="yolo-page-title-overlay"></div>
                <div class="container">
                    <div class="page-title-inner block-center">
                        <div class="block-center-inner">
                            <h1><?php woocommerce_page_title(); ?></h1>
                            <?php if ($page_sub_title != '') : ?>
                                <span class="page-sub-title"><?php echo esc_html($page_sub_title) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php if ($breadcrumbs_in_page_title == 1 || $product_show_result_count == 1 || $product_show_catalog_ordering == 1) : ?>
            <section class="<?php echo join(' ',$breadcrumb_class); ?>">
                <div class="container">
                    <?php yolo_the_breadcrumb(); ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
<?php endif; ?>


