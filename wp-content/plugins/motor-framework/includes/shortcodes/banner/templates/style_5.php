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

$image_src = wp_get_attachment_url($image);
?>
<div class="banner-shortcode-wrap <?php echo $layout_type; ?>">
    <div class="banner-content">
        <?php if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
            <a href="<?php echo esc_url($url['url']); ?>">
        <?php endif; ?>
            <?php if( $title != '' ) : ?>
                <h3 class="banner-title"><?php echo $title; ?></h3>
            <?php endif; ?>
            <?php if( $image_src != '' ) : ?>
                <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo $title; ?>">
            <?php endif; ?>
        <?php if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
            </a>
        <?php endif; ?>
    </div>
</div>