<?php
if(!class_exists('Yolo_Setup_Install')){
	Class Yolo_Setup_Install{
		private $theme_logo;
		private $theme_title;
		private $product_id;
		private $support_url;
		private $theme_name;
		private $is_yolo_framework;
		public function __construct(){
			if(is_admin()){
				$this->theme_logo       	= get_template_directory_uri() . '/assets/images/logo.png';
				$this->theme_title      	= esc_html__( 'Thank you for purchasing Motor Theme!', 'yolo-motor' );
				$this->product_id       	= 'yolo-motor';
				$this->support_url      	= 'https://yolotheme.com/forums/';
				$this->theme_name       	= 'Motor';
				$this->is_yolo_framework	= self::yolo_is_plugin_active( 'motor-framework/motor-framework.php' );
				add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_script' ) );
				add_action( 'wp_ajax_yolo_check_purchase_code', array( &$this, 'yolo_check_purchase_code' ) );
				add_action( 'admin_menu', array( &$this, 'yolo_admin_menu' ), 9 );
			}
		}
		public function enqueue_script() {
	    	wp_enqueue_style( 'yolo-theme-option', get_template_directory_uri() . '/framework/includes/yolo-dash/assets/theme-option.css' );

	    	wp_enqueue_script( 'yolo-theme-option', get_template_directory_uri() . '/framework/includes/yolo-dash/assets/theme-option.js', array( 'jquery' ), null, true );

	    	wp_localize_script( 'yolo-theme-option', 'Yolo_Theme_Option', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'security' => wp_create_nonce( 'yolo-theme-option' ),
	        ) );

	    }
		/**
		 * Creates a new top level menu section.
		 *
		 * @return  void
		 */
		public function yolo_admin_menu() {
			global $submenu,$pagenow;
			if ( current_user_can( 'edit_theme_options' ) ) {
				$menu = 'add_menu_' . 'page';
				// Add Yolo root menu item.
				$menu(
					esc_html__( 'Motor', 'yolo-motor' ),
					esc_html__( 'Motor', 'yolo-motor' ),
					'manage_options',
					'yolo-options',
					array( $this, 'yolo_html' ),
					get_template_directory_uri() . '/assets/images/favicon.ico',
					2
				);

				// Add Yolo submenu items.
				$sub_menu = 'add_submenu_' . 'page';
				$sub_menu(
					'yolo-options',
					esc_html__( 'Yolo Dashboard', 'yolo-motor' ),
					esc_html__( 'Dashboard', 'yolo-motor' ),
					'manage_options',
					'yolo-options',
					array( $this, 'yolo_html' )
				);
				// Sort submenu
				if( isset( $submenu['yolo-options'][0][2] ) && $submenu['yolo-options'][0][2] == 'edit.php?post_type=yolo_footer' ) {
					$header = $submenu['yolo-options'][0];
					$welcome = $submenu['yolo-options'][1];

					$submenu['yolo-options'][0] = $welcome;
					$submenu['yolo-options'][1] = $header;
				}
			}
			// Redirect to Yolo welcome page after activating theme.
			if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) && $_GET['activated'] == 'true' ) {
				// Add do action
				// do_action( 'yolo_activate' );

				// Redirect
				wp_redirect( admin_url ( 'admin.php?page=yolo-options#verify' ) );
			}
		}
		public static function yolo_is_plugin_active( $plugin ) {

            include_once ABSPATH . 'wp-admin/includes/plugin.php';
            return is_plugin_active( $plugin );

        }
		/**
		 * Render HTML of intro tab.
		 *
		 * @return  string
		 */
		public function yolo_html() {
			$settings_field_name = $this->yolo_get_field_name();
			$theme_options       = get_option( $settings_field_name );

			$subscribe  = 'http://eepurl.com/cadHAP';
			$twitter    = 'https://twitter.com/YoloTheme';
			$facebook   = 'https://www.facebook.com/Yolotheme/';
			$dribbble   = 'https://dribbble.com/yolotheme';
			$support    = 'https://yolotheme.com/forums/forum/product-support/motor/';
			$docs       = 'http://docs.yolotheme.com/motor/';
			$changelog  = 'https://themeforest.net/item/motor-vehikal-motorcycle-online-store-wordpress-theme/15895102#item-description__change-logs';
			?>
			<div class="wrap yolo-wrap">
				<h1 class="intro-title">
					<?php esc_html_e( 'Yolo Theme', 'yolo-motor' ); ?>
				</h1>
				<div class="welcome-panel">
					<div class="welcome-panel-content">
						<h1><?php esc_html_e( 'Welcome to Yolo Theme!', 'yolo-motor' ); ?></h1>
						<p class="about-description"><?php esc_html_e( 'We\'ve assembled some links to get you started', 'yolo-motor' ); ?></p>
						<div class = "theme-setup">
							<div class="yolo-support-active">
								<div class="welcome-panel-column">
									<h3 class = "get-start"><?php esc_html_e( 'Get start', 'yolo-motor' ); ?></h3>
									<a href="<?php echo ( admin_url( 'admin.php?page=_options' ) ); ?>" class="wr-scroll-animated button button-primary button-hero"><?php esc_html_e( 'Customize Your Site', 'yolo-motor' ); ?></a>
									<p class="small-text"><?php esc_html_e( 'or', 'yolo-motor' ); ?>, <a href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>"><?php esc_html_e( 'change your theme completely', 'yolo-motor' ); ?></a></p>
									
								</div>
								<div class="welcome-panel-column">
									<h3><?php esc_html_e( 'Keep in Touch', 'yolo-motor' ); ?></h3>
									<ul>
										<li><a target="_blank" href="<?php echo esc_url( admin_url( 'edit.php?post_type=yolo_footer' ) ); ?>" class="welcome-icon welcome-widgets-menus"><?php esc_html_e( 'View Footer Blocks', 'yolo-motor' ); ?></a></li>
										<li><a target="_blank" href="<?php echo esc_url( $docs ); ?>" class="welcome-icon dashicons-media-document"><?php esc_html_e( 'Read Documentation', 'yolo-motor' ); ?></a></li>
										<li><a target="_blank" href="<?php echo esc_url( $support ); ?>" class="welcome-icon dashicons-editor-help"><?php esc_html_e( 'Request Support', 'yolo-motor' ); ?></a></li>
										<li><a href="<?php echo esc_url( home_url( '/' ) );?>" class="welcome-icon welcome-view-site"><?php esc_html_e( 'View Your Site', 'yolo-motor' ) ?></a></li>
									</ul>
								</div>
								<div class="welcome-panel-column">
									<h3><?php esc_html_e( 'Keep in Touch', 'yolo-motor' ); ?></h3>
									<ul>
										<li><a target="_blank" href="<?php echo esc_url( $subscribe ); ?>" class="welcome-icon dashicons-email-alt"><?php esc_html_e( 'Newsletter', 'yolo-motor' ); ?></a></li>
										<li><a target="_blank" href="<?php echo esc_url( $twitter ); ?>" class="welcome-icon dashicons-twitter"><?php esc_html_e( 'Twitter', 'yolo-motor' ); ?></a></li>
										<li><a target="_blank" href="<?php echo esc_url( $dribbble ); ?>" class="welcome-icon dashicons-dribbble"><?php esc_html_e( 'Dribbble', 'yolo-motor' ); ?></a></li>
										<li><a target="_blank" href="<?php echo esc_url( $facebook ); ?>" class="welcome-icon dashicons-facebook"><?php esc_html_e( 'Facebook', 'yolo-motor' ); ?></a></li>
									</ul>
								</div>
							</div>
							<?php //$this->general_options();?>
						</div>
					</div><!-- .welcome-panel-content -->
				</div><!-- .welcome-panel -->
				<div class="welcome-panel">
					<div class="welcome-panel-content">
						<div class="welcome-panel-column-container">
							<div id="tabs-container" role="tabpanel">
								<h2 class="nav-tab-wrapper">
									<?php if ( $theme_options['license_key'] ) : ?>
										<a class="nav-tab yolo-nav" href="#verify"><?php esc_html_e( 'Purchase Code Verify', 'yolo-motor' ); ?></a>
										<a class="nav-tab yolo-nav" href="#plugin"><?php esc_html_e( 'Install Plugin', 'yolo-motor' ); ?></a>
										<a class="nav-tab yolo-nav" href="#demo"><?php esc_html_e( 'Import Data', 'yolo-motor' ); ?></a>
										<a class="nav-tab yolo-nav" href="#support"><?php esc_html_e( 'Document and Support', 'yolo-motor' ); ?></a>
										
									<?php else:?>
										<a class="nav-tab yolo-nav" href="#verify"><?php esc_html_e( 'Purchase Code Verify', 'yolo-motor' ); ?></a>
										<a class="nav-tab yolo-disabled" href="#" title = "<?php echo esc_attr('Please enter Purchase Code to install plugin and import data');?>"><?php esc_html_e( 'Install Plugin', 'yolo-motor' ); ?></a>
										<a class="nav-tab yolo-disabled" href="#" title = "<?php echo esc_attr('Please enter Purchase Code to install plugin and import data');?>"><?php esc_html_e( 'Import Data', 'yolo-motor' ); ?></a>
										<a class="nav-tab yolo-nav" href="#support"><?php esc_html_e( 'Document and Support', 'yolo-motor' ); ?></a>
									<?php endif;?>
								</h2>
								<div class="tab-content">
									<?php
										$this->yolo_purchase_form();
										$this->yolo_install_plugin_html();
										$this->yolo_import_data();
										$this->yolo_support();
									?>
								</div><!-- .tab-content -->
							</div>
						</div>
					</div><!-- .welcome-panel-content -->
				</div><!-- .welcome-panel -->
			</div><!-- wrap -->
			<?php
		}
		/**
		 * Render HTML of registration tab.
		 *
		 * @return  string
		 */
		public function yolo_purchase_form() {
			$settings_field_name = $this->yolo_get_field_name();
			$theme_options       = get_option( $settings_field_name );
			?>
			<div id="verify" class="tab-pane" role="tabpanel">
				<div class="yolo-purchase-code-active">
					<p class="yolo-notice">
							<?php echo sprintf( esc_html__( 'Input the ThemeForest purchase code to be able to download, update and fully access to %s', 'yolo-motor' ), esc_html( $this->theme_name ) ); ?>
					</p>
					<form method="post" id = "yolo-purchase-code">
						<label><?php esc_html_e( 'ThemeForest Purchase Code:', 'yolo-motor' ); ?></label>
	                    <input type='text' name='purchase_code' value='<?php echo esc_attr( $theme_options['license_key'] ); ?>' placeholder = "<?php echo esc_attr_e('Enter Purchase Code *, eg. abcd-efgh-ikml-1234','yolo-motor')?>">
		                <div class="get_license_key">
		                	<a target="_blank" href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" class="welcome-icon dashicons-editor-help"><?php esc_html_e( 'How to get License key?', 'yolo-motor' ); ?></a>
						</div>
						<div style="clear:both"></div>
						<button id="yolo-active-code" type="submit">
							<?php echo esc_html__( 'Validated', 'yolo-motor' ); ?>
						</button>
					</form>
				</div>
			</div>
			<?php
		}
		/**
		 * Render HTML of install plugin.
		 *
		 * @return  string
		 */
		public function yolo_install_plugin_html() {
			$license_key = get_option($this->product_id . '-license-settings');
			$tgmpa = TGM_Plugin_Activation::get_instance();
		?>
			<div id="plugin" class="tab-pane" role="tabpanel">
				<?php if ( $tgmpa->is_tgmpa_complete() === false ) :?>
					<div class="yolo-install-plugin">
						<p><?php echo wp_kses_post( '', 'yolo-motor' ); ?></p>
						<?php
							if ( $license_key ) {
								echo sprintf( '<a class="button button-primary install-all-plugin" href="%s">' . esc_html__( 'Install All Plugins', 'yolo-motor' ) . '</a>', admin_url( 'themes.php?page=install-required-plugins&plugin_status=install' ) );
							}?>
					</div>
				<?php else:?>
					<h4 class = "plugin-active"><?php echo esc_html__('You installed Successfull!','yolo-motor');?></h4>
				<?php endif; ?>
			</div> 
			<?php
		}
		/**
		 * Render HTML of import data demo.
		 *
		 * @return  string
		 */
		public function yolo_import_data() {
			
			?>
			<div id="demo" class="tab-pane" role="tabpanel">
				<?php
					if($this->is_yolo_framework):
				?>
					<div class="yolo-demo-active">
						<?php 
						Yolo_Notice_Install::yolo_import_demo_options();
						?>
					</div>
				<?php else:?>
					<h4 class = "note-message">
						<?php echo sprintf(wp_kses(__('Please <a href = "%s">Install</a> and <a href = "%s">Active</a> Motor Framework','yolo-motor'),yolo_allowed_tags()),esc_url('themes.php?page=install-required-plugins&plugin_status=install'),esc_url('themes.php?page=install-required-plugins&plugin_status=activate'))?>
					</h4>
				<?php endif;?>
			</div>
			<?php
		}
		/**
		 * Render HTML of Document and Support.
		 *
		 * @return  string
		 */
		public function yolo_support() {
			$subscribe  = 'http://eepurl.com/cadHAP';
			$twitter    = 'https://twitter.com/YoloTheme';
			$facebook   = 'https://www.facebook.com/Yolotheme/';
			$dribbble   = 'https://dribbble.com/yolotheme';
			$support    = 'https://yolotheme.com/forums/forum/product-support/motor/';
			$docs       = 'http://docs.yolotheme.com/motor/';
			$changelog  = 'https://themeforest.net/item/motor-vehikal-motorcycle-online-store-wordpress-theme/15895102#item-description__change-logs';
			?>
			<div id="support" class="tab-pane" role="tabpanel">
				<div class="yolo-support-active">
					<div class="welcome-panel-column">
						<h3><?php esc_html_e( 'Get start', 'yolo-motor' ); ?></h3>
						<ul>
							<li><a target="_blank" href="<?php echo esc_url( $docs ); ?>" class="welcome-icon dashicons-media-document"><?php esc_html_e( 'Read Documentation', 'yolo-motor' ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( $support ); ?>" class="welcome-icon dashicons-editor-help"><?php esc_html_e( 'Request Support', 'yolo-motor' ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( $changelog ); ?>" class="welcome-icon dashicons-backup"><?php esc_html_e( 'View Changelog Details', 'yolo-motor' ); ?></a></li>
						</ul>
					</div>
					<div class="welcome-panel-column">
						<h3><?php esc_html_e( 'Keep in Touch', 'yolo-motor' ); ?></h3>
						<ul>
							<li><a target="_blank" href="<?php echo esc_url( $subscribe ); ?>" class="welcome-icon dashicons-email-alt"><?php esc_html_e( 'Newsletter', 'yolo-motor' ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( $twitter ); ?>" class="welcome-icon dashicons-twitter"><?php esc_html_e( 'Twitter', 'yolo-motor' ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( $facebook ); ?>" class="welcome-icon dashicons-facebook"><?php esc_html_e( 'Facebook', 'yolo-motor' ); ?></a></li>
						</ul>
					</div>
				</div>
			</div>
			<?php
		}
		public function yolo_check_purchase_code() {
			if ( isset( $_POST['purchase_code'] ) && !empty( $_POST['purchase_code'] ) ) {
				$purchase_code = !empty( $_POST['purchase_code'] ) ? esc_attr( $_POST['purchase_code'] ) : '';
				unset( $_POST['action'] );
				$data_request = wp_remote_get(
					add_query_arg(
						array(
							'purchase_code' => esc_attr( $purchase_code ), 
							'site_url'      => get_site_url(),
						), 
						'http://update.yolotheme.com/verify_code'
					), 
					array( 'timeout' => 60 )
				);
				if( is_wp_error( $data_request ) ) {

					delete_option( $this->yolo_get_field_name() );

					$response['status']  = 'error';
					$response['message'] = esc_html__( 'Some troubles with connecting to YoloTheme server.', 'yolo-motor' );
					wp_send_json( $response );

				}

				$rp_data = json_decode( $data_request['body'], true );
				if( !is_array( $rp_data ) || empty( $rp_data ) || $rp_data['status'] !== 'success' ) {
					
					delete_option( $this->yolo_get_field_name() );
					
					$response['status']  = 'error';
					$response['message'] = esc_html__( 'Purchase code verification failed.', 'yolo-motor' );
					wp_send_json( $response );

				} else {

					$value_license = array(
						'license_key' => esc_attr( $purchase_code ),
						'site_url'       => esc_attr( str_replace( 'http://', '', home_url() ) ),
					);

					update_option( $this->yolo_get_field_name(), $value_license );

					$response['status']  = 'success';
					$response['message'] = esc_html__( 'Purchase code is activated', 'yolo-motor' );
					wp_send_json( $response );

				}

			}

			$response['status']  = 'error';
			$response['message'] = esc_html__( 'Please enter purchase code.', 'yolo-motor' );
			wp_send_json( $response );

		}

		/**
		 * Show message json
		 *
		 * @author  KENT <tuanlv@vietbrain.com>
		 * @version 1.0
		 */
		public function message() {

		}

		/**
		 * Setting fields
		 */
		public function yolo_get_field_name() {
            return $this->product_id . '-license-settings';
        }
		
	}
	new Yolo_Setup_Install;
}