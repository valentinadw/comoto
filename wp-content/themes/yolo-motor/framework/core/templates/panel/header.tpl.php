<?php
    /**
     * The template for the panel header area.
     * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
     *
     * @author      Redux Framework
     * @package     ReduxFramework/Templates
     * @version:    3.5.4.18
     */

    $tip_title = esc_html__( 'Developer Mode Enabled', 'yolo-motor' );

    if ( $this->parent->dev_mode_forced ) {
        $is_debug     = false;
        $is_localhost = false;

        $debug_bit = '';
        if ( Redux_Helpers::isWpDebug() ) {
            $is_debug  = true;
            $debug_bit = esc_html__( 'WP_DEBUG is enabled', 'yolo-motor' );
        }

        $localhost_bit = '';
        if ( Redux_Helpers::isLocalHost() ) {
            $is_localhost  = true;
            $localhost_bit = esc_html__( 'you are working in a localhost environment', 'yolo-motor' );
        }

        $conjunction_bit = '';
        if ( $is_localhost && $is_debug ) {
            $conjunction_bit = ' ' . esc_html__( 'and', 'yolo-motor' ) . ' ';
        }

        $tip_msg = esc_html__( 'This has been automatically enabled because', 'yolo-motor' ) . ' ' . $debug_bit . $conjunction_bit . $localhost_bit . '.';
    } else {
        $tip_msg = esc_html__( 'If you are not a developer, your theme/plugin author shipped with developer mode enabled. Contact them directly to fix it.', 'yolo-motor' );
    }

    ?>
    <div id="redux-header">
        <?php if ( ! empty( $this->parent->args['display_name'] ) ) { ?>
        <div class="display_header">
              
            <!-- <?php if ( isset( $this->parent->args['dev_mode'] ) && $this->parent->args['dev_mode'] ) { ?>
                            <div class="redux-dev-mode-notice-container redux-dev-qtip" qtip-title="<?php echo $tip_title; ?>" qtip-content="<?php echo $tip_msg; ?>">
                <span class="redux-dev-mode-notice"><?php esc_html_e( 'Developer Mode Enabled', 'yolo-motor' ); ?></span>
                            </div>
                        <?php } ?> -->
            <h2 class="to_logo"></h2>
            <div id="redux-sticky">
                <div id="info_bar">

                    <a href="javascript:void(0);"
                    class="expand_options<?php echo ( $this->parent->args['open_expanded'] ) ? ' expanded' : ''; ?>"<?php echo $this->parent->args['hide_expand'] ? ' style="display: none;"' : '' ?>><?php esc_html_e( 'Expand', 'yolo-motor' ); ?></a>

                    <div class="redux-action_bar">
                        <span class="spinner"></span>
                        <?php submit_button( esc_attr__( 'Save & Generate CSS', 'yolo-motor' ), 'primary redux_generate', $this->parent->args['opt_name'] . '[lesscss]', false ); ?>
                        <?php if ( false === $this->parent->args['hide_save'] ) { ?>
                        <?php submit_button( esc_html__( 'Save Changes', 'yolo-motor' ), 'primary', 'redux_save', false  ); ?>
                        <?php } ?>
                        <?php if ( false === $this->parent->args['hide_reset'] ) : ?>
                            <?php submit_button( esc_html__( 'Reset Section', 'yolo-motor' ), 'secondary reset_btn', $this->parent->args['opt_name'] . '[defaults-section]', false ); ?>
                            <?php submit_button( esc_html__( 'Reset All', 'yolo-motor' ), 'secondary reset_all_btn', $this->parent->args['opt_name'] . '[defaults]', false ); ?>
                        <?php endif; ?>
                    </div>
                    <div class="redux-ajax-loading" alt="<?php esc_html_e( 'Working...', 'yolo-motor' ) ?>">&nbsp;</div>
                    <div class="clear"></div>
                </div>

                <!-- Notification bar -->
                <div id="redux_notification_bar">
                    <?php $this->notification_bar(); ?>
                </div>


            </div>

    <?php if ( ! empty( $this->parent->args['display_version'] ) ) { ?>
    <span><?php echo wp_kses_post( $this->parent->args['display_version'] ); ?></span>
    <?php } ?>

</div>
<?php } ?>

<div class="clear"></div>
</div>