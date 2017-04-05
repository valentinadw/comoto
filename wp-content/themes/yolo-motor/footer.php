			<?php 
				/*
				* @hooked - yolo....
				*/
				do_action( 'yolo_main_wrapper_content_end' );
			?>
			</div>
			<!-- Close wrapper content -->

			<footer id="yolo-footer-wrapper">
				<?php
				global $yolo_footer_id;
				$yolo_options = yolo_get_options();
				if( $yolo_footer_id == '' &&  isset($yolo_options) && isset( $yolo_options['footer'])) {
					$yolo_footer_id = $yolo_options['footer'];
				}
				if ( $yolo_footer_id ):
				$content_post = get_post($yolo_footer_id);
				?>
				<div class="yolo-footer-wrapper <?php echo $content_post->post_name; ?>">
					<?php
						/*
						* @hooked - yolo_footer_content - 10
						*/
						do_action( 'yolo_main_wrapper_footer' );
					?>
				</div>
				<?php endif;?>
			</footer>
		</div>
		<!-- Close wrapper -->
		<?php
			/*
			* @hooked - yolo_back_to_top - 5
			*/
			do_action( 'yolo_after_page_wrapper' );
		?>
	<?php wp_footer(); ?>
	</body>
</html>