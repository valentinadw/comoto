<!DOCTYPE html>
<!-- Open HTML -->
<html <?php language_attributes(); ?>>
	<!-- Open Head -->
	<head>
		<?php  
		// @TODO: Process options here as add class boxed, class site loading, ...
			$yolo_options = yolo_get_options();
			$yolo_footer_id = yolo_include_footer_id(); // Use this to fix get footer_id in footer block
			
			// $prefix    = 'yolo_';
			// $footer_id = get_post_meta(get_the_ID(),$prefix . 'footer',true);
		?>
		<?php wp_head(); ?>
	</head>
	<!-- Close Head -->
	<body <?php body_class(); ?>>
		<?php 
			/*
			*	@hooked - yolo_site_loading - 5;
			*	@hooked - yolo_popup_window - 10;
			*/
			do_action( 'yolo_before_page_wrapper' );
		?>
		<!-- Open yolo wrapper -->
		<div id="yolo-wrapper">
			<?php 
				/*
				*	@hooked - yolo_page_above_header - 5
				*	@hooked - yolo_page_top_bar - 10
				*	@hooked - yolo_page_header - 15
				*/
				do_action( 'yolo_before_page_wrapper_content' );
			?>
			<!-- Open Yolo Content Wrapper -->
			<div id="yolo-content-wrapper" class="clearfix">
			<?php 
				/*
				*	@hooked - yolo_main
				*/
				do_action( 'yolo_main_wrapper_content_start' );
			?>