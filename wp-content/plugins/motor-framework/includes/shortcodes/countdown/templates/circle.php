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

$time_id = uniqid();
?>
<div class="countdown-shortcode-wrap">
	<div id="countdown-content-<?php echo $time_id;?>" class="countdown-content" data-date="<?php echo esc_html( $datetime );?>"></div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
    	// More details here: https://github.com/wimbarelds/TimeCircles
        var $time_id = '<?php echo $time_id?>';
        var days    = "<?php echo esc_html__( 'Days', 'yolo-motor' ); ?>";
        var hours   = "<?php echo esc_html__( 'Hours', 'yolo-motor' ); ?>";
        var minutes = "<?php echo esc_html__( 'Minutes', 'yolo-motor' ); ?>";
        var seconds = "<?php echo esc_html__( 'Seconds', 'yolo-motor' ); ?>";

        $("#countdown-content-" + $time_id).TimeCircles({
            direction: "Counter-clockwise",
            fg_width: 0.005,
            circle_bg_color: "#ffffff",
            count_past_zero: false,
            time: {
	            Days: {
	                show: true,
	                text: days,
	                color: "#3b3b3b"
	            },
	            Hours: {
	                show: true,
	                text: hours,
	                color: "#3b3b3b"
	            },
	            Minutes: {
	                show: true,
	                text: minutes,
	                color: "#3b3b3b"
	            },
	            Seconds: {
	                show: true,
	                text: seconds,
	                color: "#3b3b3b"
	            }
	        }
        });
        $(window).resize(function(){
			$("#countdown-content-" + $time_id).TimeCircles().rebuild();
		});
    });
</script>
