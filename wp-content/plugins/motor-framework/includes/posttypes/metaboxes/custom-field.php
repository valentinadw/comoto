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
<div class="portfolio-custom-field">
    <?php
    while( $mb->have_fields_and_multi('portfolio_custom_fields',array('length' => 1)) ) : ?>
        <?php $mb->the_group_open(); ?>

        <?php $mb->the_field('custom-field-title'); ?>
        <label><?php esc_html_e( 'Title', 'yolo-motor' ) ; ?></label>
        <input class="form-control" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>

        <?php $mb->the_field('custom-field-description'); ?>
        <label><?php esc_html_e( 'Description', 'yolo-motor' ); ?></label>
        <textarea name="<?php $mb->the_name(); ?>" class="form-control" rows="3"><?php echo wp_kses_post($mb->the_value()); ?></textarea>
        <a href="#" class="dodelete button"><?php esc_html_e( 'Remove', 'yolo-motor' ); ?></a>
        <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
    <div style="clear: both;"></div>
    <p>
        <a href="#" class="docopy-portfolio_custom_fields button"><?php esc_html_e( 'Add custom field', 'yolo-motor' ); ?></a>
        <a href="#" class="dodelete-portfolio_custom_fields button"><?php esc_html_e( 'Remove All', 'yolo-motor' ); ?></a>
    </p>
</div>