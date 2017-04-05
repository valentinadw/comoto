<?php
/**
 * Display notices in admin.
 *  
 * @package    YoloTheme/Yolo Motor
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------
 * Create functions notice_html_install
 * ------------------------------------------------------- */
class Yolo_Notice_Install {

	private $product_id           = 'yolo-motor';
	
	private $install_option_group = 'yolo_option_install_group';
	
	private $install_option_name  = 'yolo_option_install_name';
	
	private $install_section_id   = 'yolo_option_section_id';
	
	private $option_metabox       = array();

    public function __construct() {
    	add_action( 'plugins_loaded', array( $this, 'my__construct' ) );
			
    }
    public function my__construct() {

		if ( current_user_can( 'manage_options' ) ) {
			if ( isset( $_GET['page'] ) == 'yolo-options' ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'load_enqueue_script_setup' ) );
			}
			require dirname( __FILE__ ) . '/yolo-import.php';

		}
	}

	public function load_enqueue_script_setup() {

		wp_enqueue_script( 'setup-install-demo', plugins_url( PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME.'/admin/assets/js/min/yolo.setup.install.demo.js') );

		wp_enqueue_style( 'setup-style', plugins_url( PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME.'/admin/assets/css/yolo-setup.css') );

		wp_localize_script( 'setup-install-demo', 'yoloSetupDemo', 
			array( 
				'ajax_url'      => admin_url( 'admin-ajax.php' ),
				'notice'        => esc_html__( 'Do you want to continue this action?', 'yolo' ),
				'warning'       => esc_html__( 'Please waiting, not exit page.', 'yolo' ),
				'ajax_nonce'    => wp_create_nonce( 'install-demo' ),
				'img_ajax_load' => plugins_url( PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME.'/admin/assets') . '/images/ajax-loader.gif'
			) 
		);
	}
	// -- Tools options
	public static function yolo_import_demo_options() {
		$list_demo = array(
			array(
                'name' => esc_html__( 'Motor', 'yolo-motor' ),
                'img'  => plugins_url( PLUGIN_YOLO_MOTOR_FRAMEWORK_NAME.'/') . 'includes/importer/data-demo/motor/screenshot.png',
                'file' => 'motor'
            ),
		);

		?>	<!-- <table class="widefat" cellspacing="0" style="width: 99%;">
				<thead>
					<tr>
						<th colspan="1" data-export-label="<?php echo esc_html__( 'Settings', 'yolo-motor' ); ?>">
							<label class="hide_main">
								<?php echo esc_html__( 'Settings', 'yolo-motor' ); ?>
							</label>
						</th>
					</tr>
				</thead>
				<tbody id="yolo_main_select">
					<tr>
						<td>
							<input type='checkbox' data-id='import_post' id='import_post' value='1' checked /> <?php echo esc_html__( 'Import Post', 'yolo-motor' ); ?>
						</td>
					</tr>
					<tr>
						<td>
							<input type='checkbox' data-id='import_nav' id='import_nav' value='1' checked /> <?php echo esc_html__( 'Import Widget', 'yolo-motor' ); ?>
						</td>
					</tr>
					<tr>
						<td>
							<input type='checkbox' data-id='import_comment' id='import_comment' value='1' checked /> <?php echo esc_html__( 'Import Option', 'yolo-motor' ); ?>
						</td>
					</tr>
					<tr>
						<td>
							<input type='checkbox' data-id='import_revslider' id='import_revslider' value='1' checked /> <?php _e( 'Import Revslider', 'yolo-motor' ); ?>
						</td>
					</tr>
				</tbody>
			</table> -->
			<div id="yolo_tools">

				<!-- [ MAIN ] -->
				<div id="process_import"></div>
				<div class="theme-browser rendered" style="margin-top: 20px;">
					<div class="themes">
						<?php foreach ($list_demo as $id => $demo) : ?>
							<div class="theme" tabindex="0">
								<div class="theme-screenshot">
									<img src="<?php echo esc_attr( $demo['img'] ); ?>" alt="" />
								</div>
								<span class="more-details" id="install_<?php echo esc_attr( $demo['file'] ); ?>"><?php esc_html_e( 'Install ' .$demo['name'], 'yolo-motor' ); ?></span>
								<h3 class="theme-name" id="yolo-<?php echo esc_attr( $demo['file'] ); ?>-name"><?php echo esc_html( $demo['name'] ); ?></h3>
								<div class="yolo-load-ajax"></div>
								<div class="theme-actions">
									<button class="install-demo button button-secondary button-primary activate"
									data-name="<?php echo esc_attr( $demo['file'] ); ?>"
									data-import-post="true"
									data-import-nav="true"
									data-import-comment="true"
									data-import-revslider = "true"
									><?php esc_html_e( 'Install Demo', 'yolo-motor' ); ?></button>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<br class="clear">
				</div>
			
			</div><!-- /#yolo_tools -->


		<?php
	}
}
new Yolo_Notice_Install;
