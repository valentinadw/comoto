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

$yolo_options = yolo_get_options();
$sharing_facebook  = isset($yolo_options['social_sharing']['facebook']) ? $yolo_options['social_sharing']['facebook'] : 0;
$sharing_twitter   = isset($yolo_options['social_sharing']['twitter']) ? $yolo_options['social_sharing']['twitter'] : 0;
$sharing_google    = isset($yolo_options['social_sharing']['google']) ? $yolo_options['social_sharing']['google'] : 0;
$sharing_linkedin  = isset($yolo_options['social_sharing']['linkedin']) ? $yolo_options['social_sharing']['linkedin'] : 0;
$sharing_tumblr    = isset($yolo_options['social_sharing']['tumblr']) ? $yolo_options['social_sharing']['tumblr'] : 0;
$sharing_pinterest = isset($yolo_options['social_sharing']['pinterest']) ? $yolo_options['social_sharing']['pinterest'] : 0;


if (($sharing_facebook == 1) || ($sharing_twitter == 1) || ($sharing_linkedin == 1) || ($sharing_tumblr == 1) || ($sharing_google == 1) || ($sharing_pinterest == 1)) :
?>
    <div class="social-share-wrap">
        <label><i class="fa fa-share-alt"></i><?php esc_html_e("Share:",'yolo-motor'); ?></label>
        <ul class="social-share">
            <?php if ($sharing_facebook == 1) : ?>
                <li>
                    <a onclick="window.open('https://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo esc_attr(urlencode(get_permalink()));?>','sharer', 'toolbar=0,status=0,width=620,height=280');"  href="javascript:;">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($sharing_twitter == 1) :  ?>
                <li>
                    <a onclick="popUp=window.open('http://twitter.com/home?status=<?php echo esc_attr(urlencode(get_the_title())); ?> <?php echo esc_attr(urlencode(get_permalink())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;"  href="javascript:;">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($sharing_google == 1) :  ?>
                <li>
                    <a  href="javascript:;" onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo esc_attr(urlencode(get_permalink())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;">
                        <i class="fa fa-google-plus"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($sharing_linkedin == 1):?>
                <li>
                    <a  onclick="popUp=window.open('http://linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_attr(urlencode(get_permalink())); ?>&amp;title=<?php echo esc_attr(urlencode(get_the_title())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;">
                        <i class="fa fa-linkedin"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($sharing_tumblr == 1) :  ?>
                <li>
                    <a onclick="popUp=window.open('http://www.tumblr.com/share/link?url=<?php echo esc_attr(urlencode(get_permalink())); ?>&amp;name=<?php echo esc_attr(urlencode(get_the_title())); ?>&amp;description=<?php echo esc_attr(urlencode(get_the_excerpt())); ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;">
                        <i class="fa fa-tumblr"></i>
                    </a>
                </li>

            <?php endif; ?>

            <?php if ($sharing_pinterest == 1) :  ?>
                <li>
                    <a onclick="popUp=window.open('http://pinterest.com/pin/create/button/?url=<?php echo esc_attr(urlencode(get_permalink())); ?>&amp;description=<?php echo esc_attr(urlencode(get_the_title())); ?>&amp;media=<?php $arrImages = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); echo has_post_thumbnail() ? esc_attr($arrImages[0])  : "" ; ?>','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;">
                    <i class="fa fa-pinterest"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif;