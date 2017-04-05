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
<div class="countdown-shortcode-wrap clearfix">
	<div class="countdown-content"></div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        // More details here: http://hilios.github.io/jQuery.countdown/
        var days    = "<?php echo esc_html__( 'Días', 'yolo-motor' ); ?>";
        var hours   = "<?php echo esc_html__( 'Horas', 'yolo-motor' ); ?>";
        var minutes = "<?php echo esc_html__( 'Minutos', 'yolo-motor' ); ?>";
        var seconds = "<?php echo esc_html__( 'Segundos', 'yolo-motor' ); ?>";
        $(".countdown-content").countdown("<?php echo $datetime;?>", function(event) {
            $(this).html(
                event.strftime('<ul class="list-time"><li class="cd-days"><p class="countdown-number">%D</p> <p>' + days + '</p></li> <li class="cd-hours"><p class="countdown-number">%H</p><p>' + hours + '</p></li> <li class="cd-minutes"><p class="countdown-number">%M</p><p>' + minutes + '</p></li> <li  class="cd-seconds"> <p class="countdown-number">%S</p><p>' + seconds + '</p></li></ul>')
            );
        });
    });
</script>
