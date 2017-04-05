<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
get_header();
?>
    <?php
    $yolo_options = yolo_get_options();
    ?>
        <div id="yolo-wrapper">
            <div class="page404" style="background: url(<?php echo $yolo_options['page_404_bg_image']['url']; ?>);">
                <div class=" content-wrap">
                    <div class="page404-title">
                        <h2 class="p-title"><?php echo wp_kses_post($yolo_options['page_title_404']); ?></h2>
                        <h4  class="p-description p-font"><?php echo wp_kses_post($yolo_options['sub_page_title_404']); ?></h4>
                        <div class="p-title-hr">
                            <div class="hr-icon"><i class="fa fa-square-o"></i></div>
                        </div>
                    </div>
                    <div class="page404-content">
                        <p class="404-content"><?php echo wp_kses_post($yolo_options['title_404']); ?></p>
                    </div>
                    <div class="return">
                        <?php
                        $go_back_link = $yolo_options['go_back_url_404'];
                        if($go_back_link == '' )
                            $go_back_link = get_home_url();
                        ?>
                        <a href="<?php echo esc_url($go_back_link) ?>"><?php echo wp_kses_post($yolo_options['go_back_404']); ?></a>
                    </div>
                </div>
            </div>
        </div>
<?php get_footer();?>


