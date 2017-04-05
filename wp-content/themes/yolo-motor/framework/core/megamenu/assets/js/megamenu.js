/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
var MegaMenu = MegaMenu || {};
(function($){
	"use strict";
	MegaMenu = {
		initialize: function() {
			MegaMenu.event();
		},
		event: function() {
			MegaMenu.menu_event();
			MegaMenu.window_scroll(); // Use this for vertical header
			MegaMenu.tabs_position(5);
			MegaMenu.windowLoad();
		},
		windowLoad: function() {
			$(window).load(function(){
				// Process header sidebar
				var topbar_height = $('.yolo-top-bar').height();
				if( $('#wpadminbar').length != 0 ) {
					var admin_bar_height =  $('#wpadminbar').height();
					topbar_height += admin_bar_height;
				}
				$('#yolo-header.header-sidebar').css('top', topbar_height);
			});
		},
		window_scroll: function(){
			$(window).on('scroll',function(event){
			});
		},
		tabs_position: function(number_retry) {
			$('.navbar-nav').each(function() { // If use multi mega menu
				$('.menu_style_tab', this).each(function() {
					var $this = $(this);
					var tab_left_width = $(this).parent().outerWidth();

					$('.menu_style_tab').each(function() {
						$(this).hover(function() {
							if ($('> ul > li.active', $(this)).length == 0) {
								// Add class active for first child
								$('> ul > li:first-child', $(this)).addClass('active');

								// Process tab height first tab
								var tab_height = 0; // the height of the highest element (after the function runs)
								var t_elem;  // the highest element (after the function runs)

								$('*','.menu_style_tab > ul > li.active').each(function () {
								    var $this = $(this);

								    if ( $this.outerHeight() > tab_height ) {
								        t_elem = this;
								        tab_height = $this.outerHeight();
								    }
								    $('.menu_style_tab > ul').css('min-height', tab_height + 'px');
								});
							} else { // Case hover to other tab different first tab then hover again to .menu_style_tab
								// Process tab height other tab
								var tab_height = 0; // the height of the highest element (after the function runs)
								var t_elem;  // the highest element (after the function runs)

								$('*','.menu_style_tab > ul > li.active').each(function () {
								    var $this = $(this);

								    if ( $this.outerHeight() > tab_height ) {
								        t_elem = this;
								        tab_height = $this.outerHeight();
								    }
								    $('.menu_style_tab > ul').css('min-height', tab_height + 'px');
								});
							}
							// console.log(tab_height);
						});
					});

					// Left for menu content
					$('> li', this).each(function(){
						$('> ul', this).css('left', tab_left_width + 'px');
					});

					// Process when hover tab
					$('.menu_style_tab > ul > li').each(function(){
						$(this).hover(function() {
							$('li').removeClass('active');

							$(this).addClass('active');

							// Tab height when hover
							$('li.active').each(function(){
								MegaMenu.tab_position($(this));
							});
						});
					});

				});
			});
		},
		tab_position: function($tab) {
			var tab_height = 0;
			var t_elem;
			// Height of tab when hover
			if ($('*', $tab).length != 0) {
				$('*','.menu_style_tab > ul > li.active').each(function () {
				    var $this = $(this);
				    if ( $this.outerHeight() > tab_height ) {
				        t_elem = this;
				        tab_height = $this.outerHeight();
				    }
				    $('.menu_style_tab > ul').css('min-height', tab_height + 'px');
				    // $('.menu_style_tab > ul').animate({'min-height':tab_height+'px'}, 300);
				});
			}
		},
		menu_event: function() {
			MegaMenu.process_menu_mobile_click();
		},
		process_menu_mobile_click: function() {
			$('.yolo-mobile-header-nav li.menu-item .menu-caret, header.header-left li.menu-item .menu-caret').click(function(event) {
				$(this).toggleClass('active');
				
				if ($('> ul.sub-menu', $(this).parent()).length == 0) {
					return;
				}
				if ($( event.target ).closest($('> ul.sub-menu', $(this).parent())).length > 0 ) {
					return;
				}
				event.preventDefault();
				$($(this).parent()).toggleClass('sub-menu-open');
				$('> ul.sub-menu', $(this).parent()).slideToggle();
			});
		}

	}
	$(document).ready(function(){
		MegaMenu.initialize();
	});
})(jQuery);