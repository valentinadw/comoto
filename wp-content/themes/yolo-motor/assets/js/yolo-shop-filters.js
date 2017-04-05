/** 
 * For Shop filter AJAX
 * 
 * @package    YoloTheme
 * @version    1.0.0
 * @created    15/3/2016
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

(function($) {

	'use strict';

	/* Click filter or search */
	$(document).on('click', '.yolo-filter-search .yolo-filter', function(e){
		e.preventDefault();
		$('.yolo-search-field').slideUp(function(){
			$('.yolo-filter-search .yolo-search, .yolo-search-field').removeClass('active');
			if ( $('.woocommerce-sidebar').hasClass('active') ) {
				$('.woocommerce-sidebar').removeClass('active');
				$('.woocommerce-sidebar').slideUp();
			} else {
				$('.woocommerce-sidebar').addClass('active');
				$('.woocommerce-sidebar').slideDown();
			}
		});
		if( $(this).hasClass('active') ) {
			$(this).removeClass('active');
		}else {
			$(this).addClass('active');
		}

	});
	$(document).on('click', '.yolo-filter-search .yolo-search', function(e){
		e.preventDefault();
		$('.yolo-filter-categories > li').removeClass('current-cat');
		$('.woocommerce-sidebar').slideUp(function () {
			$('.yolo-filter-search .yolo-filter, .woocommerce-sidebar').removeClass('active');
			if ( $('.yolo-search-field').hasClass('active') ) {
				$('.yolo-search-field').removeClass('active');
				$('.yolo-search-field').slideUp();
			} else {
				$('.yolo-search-field').addClass('active');
				$('.woocommerce-sidebar').removeClass('active');
				$('.yolo-search-field').slideDown();
			}
		});
		if ( $(this).hasClass('active') ) {
			$(this).removeClass('active');
		} else {
			$(this).addClass('active');
		}
	});
	/* End */

	/* filter */
	if ( typeof(yolo_ajax_filter) != "undefined" && yolo_ajax_filter && typeof(yolo_style) != "undefined" && yolo_style == 'style_1' ) {
		$(document).on('click', '.yolo-filter-categories li a, aside ul li a, .tagcloud a,.yolo-product-category > a,.yolo-shop-results-bar a', function(e){
			e.preventDefault();
			$('.archive-product-wrap').removeClass('yolo-loaded-product');
			$('.archive-product-wrap').addClass('yolo-loading-product');
			$('.yolo-filter-search .yolo-search').removeClass('active');
			$('.archive-product-wrap .woocommerce-no-products').css('opacity', '0');
				// $('.yolo-ajax-filter').slideUp();
			$('.yolo-search-field').slideUp();			
			$('.woocommerce-pagination .yolo-shop-loadmore').addClass('yolo-hide-loadmore');
			$('.tagcloud > a').removeClass('current-tag');
			if ( $(this).closest('.yolo-filter-categories').length > 0 ) {
				$('.yolo-filter-categories li').removeClass('current-cat');
				$(this).parent().addClass('current-cat');
			}else{
				$('.yolo-filter-categories li').removeClass('current-cat');
			}
			window.history.pushState({},'',$(this).attr('href'));
			e.preventDefault();
			$('.product-listing, .woocommerce-no-products').before('<div class="yolo-spinner"><i class="fa fa-spinner fa-spin"></i></div>');
			var url = $(this).attr('href');
			url = url.replace(/\/?(\?|#|$)/, "/$1");
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					shop_load: 'full'
				},
				success: function(data){
					$('.yolo-spinner').remove();
					$('.archive-product-wrap').removeClass('yolo-loading-product');
					$('.archive-product-wrap').html(data);
					$('.archive-product-wrap').addClass('yolo-loaded-product');
					$('.woocommerce-pagination .yolo-shop-loadmore').addClass('yolo-show-loadmore');
					if ( $('.yolo-filter-search .yolo-filter').hasClass('active') ) {
						$('.woocommerce-sidebar').addClass('yolo-show');
					}
					$('.tagcloud > a').each( function(){
						if ( $(this).attr('href') == window.location.href ) {
							$(this).addClass('current-tag');
						}
					});
					YOLO.woocommerce.init();
					YOLO.common.init();
					setTimeout(function(){ $('.archive-product-wrap').removeClass('yolo-loaded-product'); $('.woocommerce-pagination .yolo-shop-loadmore').removeClass('yolo-show-loadmore'); }, 200);
				}
			})
		});
		/* end filter */

		/* Search: click = press enter if have button/input type=submit tag inside form */
		$(document).on('click', '.yolo-search-field button[type="submit"]', function (e) {
			$('.woocommerce-pagination .yolo-shop-loadmore').css('opacity','0');
			e.preventDefault();
			var keyword_search = $('.yolo-search-field .search-field').val();
			keyword_search = keyword_search.trim();
			if ( keyword_search.length ) {
				e.preventDefault();
				if ( $('.product-listing').length ) {
					$('.product-listing').html('<div class="yolo-spinner"><i class="fa fa-spinner fa-spin"></i></div>');
				} else if ( $('.woocommerce-no-products').length ) {
					$('.woocommerce-no-products').html('<div class="yolo-spinner"><i class="fa fa-spinner fa-spin"></i></div>');
				}
				var url = $(this).parent().attr('action') + '/?s=' + keyword_search + '&post_type=product';
				$.ajax({
					url: url,
					type: 'POST',
					data: {
						shop_load: 'full'
					},
					success: function(data){
						$('.yolo-filter-categories > li').removeClass('current-cat');
						$('.yolo-spinner').html();
						$('.archive-product-wrap').html(data);
						if ( $('.yolo-filter-search .yolo-search').hasClass('active') ) {
							$('.yolo-search-field .search-field').val(keyword_search);
						}
						YOLO.woocommerce.init();
						YOLO.common.init();
					}
				});
				$('.search-message').html('');
			} else {
				$('.search-message').html(yolo_framework_constant.enter_keyword);
			}
		});
		/* End search */

		/* Load more*/
		$(document).on('click', '.yolo-shop-loadmore', function(e){
			e.preventDefault();
			var link 			= $(this).data('link');
			var current_page 	= $(this).data('page');
			var totalpage		= $(this).data('totalpage');
			if ( totalpage < current_page ) {
				$('.woocommerce-pagination').html('<div class="yolo-show-all">' + yolo_all_products + '</div>').addClass('yolo-all-product');
			} else {
				$(this).attr('href', link.replace('%#%', current_page));
				$(this).data('page', current_page + 1 );
				$('.woocommerce-pagination .yolo-shop-loadmore').text('').append('<i class="fa fa-spinner fa-spin"></i>');
				$.ajax({
					url: $(this).attr('href'),
					type: 'POST',
					data: {
						shop_load: 'full',
						pagination: 'load_more'
					},
					success: function(data){
						$('.woocommerce-pagination .yolo-shop-loadmore').text('Load more');
						var $newItems = $(data);
						$('.product-listing').isotope();
						$('.product-listing').append( $newItems ).isotope( 'appended', $newItems );
						imagesLoaded($('.product-listing'), function(){
							$('.product-listing').isotope('layout');
						});
						YOLO.woocommerce.init();
						YOLO.common.init();
					}
				});
			}
		});
		function mobile_cat_filter(){
			$('.yolo-filter-categories-mobile').click(function(){
				if ($(window).width() < 992) {
					$(this).toggleClass('active');
					$(this).parent().find('.yolo-filter-categories').slideToggle(300);
				}else{
					$('.yolo-filter-categories').css({"display": "block"});
					$('.yolo-filter-categories-mobile').removeClass('active');
				}
			});
			$('.yolo-filter-categories-mobile').click(function(){
				$(window).on('resize', function() {
					if ($(window).width() < 992) {
						$(this).toggleClass('active');
						$(this).parent().find('.yolo-filter-categories').slideToggle(300);
					}else{
						$('.yolo-filter-categories').css({"display": "block"});
						$('.yolo-filter-categories-mobile').removeClass('active');
					}
				});
			});
		}
		function close_accordion_section() {
			$('.yolo-ajax-filter .widget-title').removeClass('active');
			$('.yolo-ajax-filter .widget ul,.yolo-ajax-filter .tagcloud').slideUp(300).removeClass('open');
		}
		function filter_toggles(){
			$('.yolo-ajax-filter .widget-title').click(function(e) {
				// Grab current anchor value
				e.preventDefault();
				if ($(window).width() < 992) {
					$(this).parents('.yolo-ajax-filter').addClass('filter-toggle');
					if($('.yolo-ajax-filter').hasClass('filter-toggle')){
						var currentAttrValue = $(this).parent().attr('id');
						if($(this).is('.active')) {
							close_accordion_section();
						}else {
							close_accordion_section();

							// Add active class to section title
							$(this).addClass('active');
							// Open up the hidden content panel
							$('.yolo-ajax-filter ' + '#' + currentAttrValue + ' ul').slideDown(300).addClass('open');
							$('.yolo-ajax-filter ' + '#' + currentAttrValue + ' .tagcloud').slideDown(300).addClass('open'); 
						}
					}
				}else{
					$('.yolo-ajax-filter').removeClass('filter-toggle');
	                $('.yolo-ajax-filter .widget ul,.yolo-ajax-filter .tagcloud').css({"display": "block"});
				}
				$(window).on('resize', function() {
					if ($(window).width() < 992) {
						$('.yolo-ajax-filter').addClass('filter-toggle');
	                    if($('.yolo-ajax-filter').hasClass('filter-toggle')){
							var currentAttrValue = $(this).parent().attr('id');
							if($(this).is('.active')) {
								close_accordion_section();
							}else {
								close_accordion_section();

								// Add active class to section title
								$(this).addClass('active');
								// Open up the hidden content panel
								$('.yolo-ajax-filter ' + '#' + currentAttrValue + ' ul').slideDown(300).addClass('open');
								$('.yolo-ajax-filter ' + '#' + currentAttrValue + ' .tagcloud').slideDown(300).addClass('open');
							}
						}
					}else{
						$('.yolo-ajax-filter').removeClass('filter-toggle');
	                    $('.yolo-ajax-filter .widget ul,.yolo-ajax-filter .tagcloud').css({"display": "block"});
					}
				});
			});
		}
		filter_toggles();
		mobile_cat_filter();
	}
		/* End load more*/


	/* Add class for current tag */
	if ( $('.tagcloud').length == 1 ) {
		$('.tagcloud > a').each( function(){
			if ( $(this).attr('href') == window.location.href ) {
				$(this).addClass('current-tag');
			}
		});
	}

	/* Show filter search if url has '?s' */
	$(document).ready(function(){
		if ( window.location.href.search('s=') != -1 ){
			$('.yolo-filter-search .yolo-search').addClass('active');
		}
	});

})(jQuery);
