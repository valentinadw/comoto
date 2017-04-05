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

?>

<div class="<?php echo $layout_type; ?> icon-box-shortcode-wrap">
    <div class="icon-box-container">
    <?php if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
        <a href="<?php echo esc_attr( $url['url'] ) ?>" title="<?php echo esc_attr( $url['title'] ); ?>" target="<?php echo ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) ?>">
    <?php endif; ?>
        <div class="icon-wrap">
            <div class="content-icon">
               <span class="<?php echo $iconClass; ?>" style="color:<?php echo $icon_color; ?>"></span>
            </div>
        </div>

    <?php if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
        </a>
    <?php endif; ?>
        <h2 class="icon-title">
            <?php if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
                <a href="<?php echo esc_attr( $url['url'] ) ?>" title="<?php echo esc_attr( $url['title'] ); ?>" target="<?php echo ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) ?>">
            <?php endif; ?>
            <?php echo $title; ?>
            <?php if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
                </a>
            <?php endif; ?>
        </h2>
        <div class="icon-description"><p><?php echo $description; ?></p></div>
    </div>
</div>