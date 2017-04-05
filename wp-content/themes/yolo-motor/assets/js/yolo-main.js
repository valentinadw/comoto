/**
 * 
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

var YOLO = YOLO || {};
(function ($) {
    "use strict";

    var $window = $(window),
        $body = $('body'),
        isRTL = $body.data('rtl') ? true : false,
        deviceAgent = navigator.userAgent.toLowerCase(),
        isMobile = deviceAgent.match(/(iphone|ipod|android|iemobile)/),
        isMobileAlt = deviceAgent.match(/(iphone|ipod|ipad|android|iemobile)/),
        isAppleDevice = deviceAgent.match(/(iphone|ipod|ipad)/),
        isIEMobile = deviceAgent.match(/(iemobile)/);


    YOLO.common = {
        init: function () {
            YOLO.common.owlCarousel();
            YOLO.common.stellar();
            YOLO.common.prettyPhoto();
            YOLO.common.magicLine();
            YOLO.common.tooltip();
            YOLO.common.popup();
        },
        owlCarousel: function () {
            $('div.owl-carousel:not(.manual)').each(function () {
                var slider = $(this);

                var defaults = {
                    // Most important owl features
                      rtl:"<?php echo isset($yolo_options['enable_rtl_mode']) ? $yolo_options['enable_rtl_mode'] : false; ?>",
                      items : 4,
                      margin: 0,
                      loop: true,
                      center: false,
                      mouseDrag: true,
                      touchDrag: true,
                      pullDrag: true,
                      freeDrag: false,
                      stagePadding: 0,
                      merge: false,
                      mergeFit: true,
                      autoWidth: false,

                      startPosition: 0,
                      URLhashListener: false,
                      nav: true,
                      navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
                      rewind: true,
                      navElement: 'div',
                      slideBy: 1,
                      dots: true,
                      dotsEach: false,
                      lazyLoad: false,
                      lazyContent: false,

                      autoplay: false,
                      autoplayTimeout: 2000,
                      autoplayHoverPause: true,
                      smartSpeed: 250,
                      fluidSpeed: false,
                      autoplaySpeed: false,
                      navSpeed: false,
                      dotsSpeed: false,
                      dragEndSpeed: false,
                      responsive: {
                        0: {
                            items: 1
                        },
                        500: {
                            items: 2
                        },
                        991: {
                            items: 4
                        },
                        1200: {
                            items: 4
                        },
                        1300: {
                            items: 4
                        }
                      },
                      responsiveRefreshRate: 200,
                      responsiveBaseElement: window,
                      video: false,
                      videoHeight: false,
                      videoWidth: false,
                      animateOut: false,
                      animateIn: false,
                      fallbackEasing: 'swing',

                      info: false,

                      nestedItemSelector: false,
                      itemElement: 'div',
                      stageElement: 'div',

                      navContainer: false,
                      dotsContainer: false
                };

                var columns = slider.data("plugin-options");
                var config = {
                    item: columns,
                    pagination : false,
                    navigation : true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        500: {
                            items: 2
                        },
                        991: {
                            items: columns
                        },
                        1200: {
                            items: columns
                        },
                        1300: {
                            items: columns
                        }
                      },

                }
                var configs = $.extend(defaults, config);
                var fucStr_afterInit = config.afterInit;
                // Initialize Slider
                slider.owlCarousel(configs);
            });
        },
        isDesktop: function () {
            var responsive_breakpoint = 991;

            return window.matchMedia('(min-width: ' + (responsive_breakpoint + 1) + 'px)').matches;
        },
        stellar : function() {
            $.stellar({
                horizontalScrolling: false,
                scrollProperty: 'scroll',
                positionProperty: 'position'
            });
        },
        prettyPhoto : function() {
            $("a[data-rel^='prettyPhoto']").prettyPhoto({
                hook:'data-rel',
                social_tools:'',
                animation_speed:'normal',
                theme:'light_square'
            });
        },
        magicLine : function(){
            $('.magic-line-container').each(function() {
                var activeItem = $('li.active',this);
                YOLO.common.magicLineSetPosition(activeItem);
                $('li',this).hover(function(){
                    if(!$(this).hasClass('none-magic-line')){
                        YOLO.common.magicLineSetPosition(this);
                    }

                },function(){
                    if(!$(this).hasClass('none-magic-line')){
                        YOLO.common.magicLineReturnActive(this);
                    }
                });
            });
        },
        magicLineSetPosition : function(item) {
            if(item!=null && item!='undefined') {
                var left = 0;
                if($(item).position()!=null)
                    left = $(item).position().left;
                var marginLeft = $(item).css('margin-left');
                var marginRight = $(item).css('margin-right');

                var topMagicLine = $('.top.magic-line', $(item).parent());
                var bottomMagicLine = $('.bottom.magic-line', $(item).parent());
                if(topMagicLine!=null && topMagicLine != 'undefined'){
                    $(topMagicLine).css('left',left);
                    $(topMagicLine).css('width',$(item).width());
                    $(topMagicLine).css('margin-left',marginLeft);
                    $(topMagicLine).css('margin-right',marginRight);
                }
                if(bottomMagicLine!=null && bottomMagicLine != 'undefined'){
                    $(bottomMagicLine).css('left',left);
                    $(bottomMagicLine).css('width',$(item).width());
                    $(bottomMagicLine).css('margin-left',marginLeft);
                    $(bottomMagicLine).css('margin-right',marginRight);
                }
            }
        },
        magicLineReturnActive : function(current_item) {
            if(!$(current_item).hasClass('active')){
                var activeItem = $('li.active',$(current_item).parent());
                YOLO.common.magicLineSetPosition(activeItem);
            }
        },
        showLoading : function() {
            $body.addClass('overflow-hidden');
            if ($('.loading-wrapper').length == 0) {
                $body.append('<div class="loading-wrapper"><span class="spinner-double-section-far"></span></div>');
            }
        },
        hideLoading : function() {
            $('.loading-wrapper').fadeOut(function () {
                $('.loading-wrapper').remove();
                $('body').removeClass('overflow-hidden');
            });
        },
        popup : function() {
            // Reference: http://stackoverflow.com/questions/1458724/how-to-set-unset-cookie-with-jquery
            var et_popup_closed = $.cookie('yolo_popup_closed');
            var popup_effect    = $('.yolo-popup').data('effect');
            var popup_delay     = $('.yolo-popup').data('delay');

            setTimeout(function() {
                $('.yolo-popup').magnificPopup({
                    items: {
                      src: '#yolo-popup',
                      type: 'inline'
                    },
                    removalDelay: 500, //delay removal by X to allow out-animation
                    callbacks: {
                        beforeOpen: function() {
                            // this.st.mainClass = 'mfp-zoom-in';
                            this.st.mainClass = popup_effect;
                        },
                        beforeClose: function() {
                        if($('#showagain:checked').val() == 'do-not-show')
                            $.cookie('yolo_popup_closed', 'do-not-show', { expires: 1, path: '/' } );
                        },
                    }
                    // (optionally) other options
                });

                if(et_popup_closed != 'do-not-show' && $('.yolo-popup').length > 0 && $('body').hasClass('open-popup')) {
                    $('.yolo-popup').magnificPopup('open');
                }  
            }, popup_delay);

        },
        tooltip : function () {
            if ($().tooltip && !isMobileAlt) {
                // $('[data-toggle="tooltip"]').tooltip();
                
                $('.product-item-wrap.button-has-tooltip').each(function() {
                    // if( $(this).hasClass('button-has-tooltip') ) {
                        // @TODO: need change tooltip when added to cart,...
                        $(this).find('.yith-wcwl-wishlistexistsbrowse,.yith-wcwl-add-button,.yith-wcwl-wishlistaddedbrowse', '.product-actions').tooltip({
                            title: yolo_framework_constant.product_wishList
                        });
                        $(this).find('.yith-wcwl-wishlistexistsbrowse.show,.yith-wcwl-add-button.show,.yith-wcwl-wishlistaddedbrowse.show', '.product-actions').tooltip({
                            title: yolo_framework_constant.product_wishList_added
                        });

                        $(this).find('.compare,.add_to_compare').tooltip({
                            title: yolo_framework_constant.product_compare
                        });

                        // $(this).find('.add_to_cart_button,.ajax_add_to_cart,.added_to_cart wc-forward', '.product-actions').tooltip();
                        $(this).find('[data-toggle="tooltip"]').tooltip();

                        $(this).find('.product-quick-view', '.product-actions').tooltip({
                            title: yolo_framework_constant.product_quickview
                        });
                    // }

                });        
            }
        },
	    isIE: function() {
		    var ua = window.navigator.userAgent;
		    var msie = ua.indexOf("MSIE ");

		    if (msie || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
			    return true;
		    }
		    return false;
	    }
    };


    YOLO.page = {
        init: function () {
            YOLO.page.setOverlayVC();
            YOLO.page.events();
            YOLO.page.backToTop();
            YOLO.page.vc_tabs_title();

            YOLO.page.setUnderConstruction();
        },
        events : function() {
            $('.wpb_map_wraper').on('click', YOLO.page.onMapClickHandler);
        },
        windowLoad : function() {
            if ($body.hasClass('yolo-site-preload')) {
                YOLO.page.pageIn();
            }
	        YOLO.page.setPositionPageTitle();
        },
        windowResized: function() {
            YOLO.page.setPositionPageTitle();
            YOLO.page.setUnderConstruction();
        },
        setPositionPageTitle : function() {
            if (!YOLO.common.isDesktop()) {
                return;
            }

            var sectionTitle = $('.yolo-page-title-wrap');
            if( $('header.yolo-main-header').hasClass('header-float')){
                if(sectionTitle!=null && typeof sectionTitle!='undefined'){
                    var headerHeight = $('header.yolo-main-header').outerHeight();
                    if ($('.yolo-top-bar').length) {
                        headerHeight += $('.yolo-top-bar').outerHeight();
                    }
                    var buffer = ($(sectionTitle).outerHeight() - headerHeight - $('.block-center-inner', sectionTitle).outerHeight()) / 2;

                    $(sectionTitle).css('padding-top',headerHeight + buffer);
                    $(sectionTitle).css('padding-bottom',buffer);

                    var pageTitleInner = $('.page-title-inner', sectionTitle);
                    $(pageTitleInner).css('transition','all 0.5s');
                    $(pageTitleInner).css('-webkit-transition','all 0.5s ease-in-out');
                    $(pageTitleInner).css('-moz-transition','all 0.5s ease-in-out');
                    $(pageTitleInner).css('-o-transition','all 0.5s ease-in-out');
                    $(pageTitleInner).css('-ms-transition','all 0.5s ease-in-out');
                }
            }
        },

        setOverlayVC : function() {
            $('[data-overlay-image]').each(function() {
                var $selector =$(this);
                setTimeout(function() {
                    var overlay_image = $selector.data('overlay-image');
                    var overlay_opacity = $selector.data('overlay-opacity');
                    var html = '<div class="overlay-bg-vc" style="background-image: url('+ overlay_image +') ;background-repeat:repeat; opacity:'+overlay_opacity+'"></div>';
                    $selector.prepend(html);
                }, 100);
            });
            $('[data-overlay-color]').each(function() {
                var $selector =$(this);
                setTimeout(function() {
                    var overlay_color = $selector.data('overlay-color');
                    var html = '<div class="overlay-bg-vc" style="background-color: '+ overlay_color +'"></div>';
                    $selector.prepend(html);
                }, 100);
            });
        },
        backToTop : function() {
            var $backToTop = $('.back-to-top');
            if ($backToTop.length > 0) {
                $backToTop.click(function(event) {
                    event.preventDefault();
                    $('html,body').animate({scrollTop: '0px'},800);
                });
                $window.on('scroll', function (event) {
                    var scrollPosition = $window.scrollTop();
                    var windowHeight = $window.height() / 2;
                    if (scrollPosition > windowHeight) {
                        $backToTop.addClass('in');
                    }
                    else {
                        $backToTop.removeClass('in');
                    }
                });
            }
        },
        onMapClickHandler : function() {
            var that = $(this);

            // Disable the click handler until the user leaves the map area
            that.off('click', YOLO.page.onMapClickHandler);

            // Enable scrolling zoom
            that.find('iframe').css("pointer-events", "auto");

            // Handle the mouse leave event
            that.on('mouseleave', YOLO.page.onMapMouseleaveHandler);
        },
        onMapMouseleaveHandler : function() {
            var that = $(this);

            that.on('click', YOLO.page.onMapClickHandler);
            that.off('mouseleave', YOLO.page.onMapMouseleaveHandler);
            that.find('iframe').css("pointer-events", "none");
        },
        vc_tabs_title: function () {
            if ($('.vc_tta-style-tab_style1').length) {
                $('.vc_tta-style-tab_style1').each(function () {
                    var $parrent = $(this).prev();
                    if ($parrent.prop("tagName").toLowerCase() == 'h2') {
                        $('.vc_tta-tabs-container', this).prepend($parrent);
                    }
                })
            }
        },
        pageIn : function() {
            setTimeout(function() {
                $('#yolo-site-preload').fadeOut(300);
            }, 300);
        },
        setUnderConstruction: function() {
            var $under_wrap = $('body.under-construction, body.coming-soon');
            if(typeof $under_wrap !='undefined'){
                var $content = $('.content',$under_wrap[0] );
                if($(window).width() > 768){
                    var $wpb_wrapper = $('.wpb_wrapper',$content);
                    var $height = $wpb_wrapper.outerHeight();
                    var $wpadminbar = $('#wpadminbar');
                    var $windowHeight = $(window).height();

                    if($windowHeight > $wpb_wrapper.outerHeight()){
                        $content.css('height',$windowHeight);
                    }else{
                        $content.css('height','auto');
                    }
                    if($wpadminbar.length > 0 ){
                        $windowHeight = $windowHeight - $wpadminbar.outerHeight();
                    }
                    var $padding = $windowHeight - $height;

                    if($padding>0){
                        $content.css('padding-top', $padding/2 + 'px');
                        $content.css('padding-bottom', $padding/2 + 'px');
                    }

                }else{
                    $content.css('height','auto');
                }
            }

        }
    };

    YOLO.blog = {
        init: function () {
            YOLO.blog.jPlayerSetup();
            YOLO.blog.infiniteScroll();
            YOLO.blog.loadMore();
            YOLO.blog.gridLayout();
            setInterval(YOLO.blog.gridLayout,300);
            YOLO.blog.masonryLayout();
            setInterval(YOLO.blog.masonryLayout,300);
        },
        windowResized : function() {
            YOLO.blog.processWidthAudioPlayer();
        },
        jPlayerSetup : function() {
            $('.jp-jplayer').each(function () {
                var $this = $(this),
                    url            = $this.data('audio'),
                    title          = $this.data('title'),
                    type           = url.substr(url.lastIndexOf('.') + 1),
                    player         = '#' + $this.data('player'),
                    audio          = {};
                    audio[type]    = url;
                    audio['title'] = title;
                    $this.jPlayer({
                        ready: function () {
                            $this.jPlayer('setMedia', audio);
                    },
                    swfPath: '../plugins/jquery.jPlayer',
                    cssSelectorAncestor: player
                });
            });
            YOLO.blog.processWidthAudioPlayer();
        },
        processWidthAudioPlayer : function() {
            setTimeout(function () {
                $('.jp-audio .jp-type-playlist').each(function () {
                    var _width = $(this).outerWidth() - $('.jp-play-pause', this).outerWidth() - parseInt($('.jp-play-pause', this).css('margin-left').replace('px',''),10) - parseInt($('.jp-progress', this).css('margin-left').replace('px',''),10) - $('.jp-volume', this).outerWidth() - parseInt($('.jp-volume', this).css('margin-left').replace('px',''),10) - 15;
                    $('.jp-progress', this).width(_width);
                });
            }, 100);
        },
        infiniteScroll : function() {
            var contentWrapper = '.blog-inner';
            $('.blog-inner').infinitescroll({
                navSelector: "#infinite_scroll_button",
                nextSelector: "#infinite_scroll_button a",
                itemSelector: "article",
                loading: {
                    'selector': '#infinite_scroll_loading',
                    'img': yolo_framework_theme_url + '/assets/images/ajax-loader.gif',
                    'msgText': 'Loading...',
                    'finishedMsg': ''
                }
            }, function (newElements, data, url) {
                var $newElems = $(newElements).css({
                    opacity: 0
                });
                $newElems.imagesLoaded(function () {
                    YOLO.common.owlCarousel();
                    YOLO.blog.jPlayerSetup();
                    YOLO.common.prettyPhoto();
                    $newElems.animate({
                        opacity: 1
                    });


                    if (($(contentWrapper).hasClass('blog-style-masonry'))  || ($(contentWrapper).hasClass('blog-style-grid'))) {
                        $(contentWrapper).isotope('appended', $newElems);
                        setTimeout(function() {
                            $(contentWrapper).isotope('layout');
                        }, 400);
                    }


                });

            });
        },
        loadMore : function() {
            $('.blog-load-more').on('click', function (event) {
                event.preventDefault();
                var $this = $(this).button('loading');
                var link = $(this).attr('data-href');
                var contentWrapper = '.blog-inner';
                var element = 'article';

                $.get(link, function (data) {
                    var next_href = $('.blog-load-more', data).attr('data-href');
                    var $newElems = $(element, data).css({
                        opacity: 0
                    });

                    $(contentWrapper).append($newElems);
                    $newElems.imagesLoaded(function () {
                        YOLO.common.owlCarousel();
                        YOLO.blog.jPlayerSetup();
                        YOLO.common.prettyPhoto();

                        $newElems.animate({
                            opacity: 1
                        });

                        if (($(contentWrapper).hasClass('blog-style-masonry'))  || ($(contentWrapper).hasClass('blog-style-grid'))) {
                            $(contentWrapper).isotope('appended', $newElems);
                            setTimeout(function() {
                                $(contentWrapper).isotope('layout');
                            }, 400);
                        }

                    });


                    if (typeof(next_href) == 'undefined') {
                        $this.parent().remove();
                    } else {
                        $this.button('reset');
                        $this.attr('data-href', next_href);
                    }

                });
            });
        },
        gridLayout : function() {
            var $blog_grid = $('.blog-style-grid');
            $blog_grid.imagesLoaded( function() {
                $blog_grid.isotope({
                    itemSelector : 'article',
                    layoutMode: "fitRows",
                    isOriginLeft: !isRTL
                });
                setTimeout(function () {
                    $blog_grid.isotope('layout');
                }, 500);
            });
        },
        masonryLayout : function() {
            var $blog_masonry = $('.blog-style-masonry');
            $blog_masonry.imagesLoaded( function() {
                $blog_masonry.isotope({
                    itemSelector : 'article',
                    layoutMode: "masonry",
                    isOriginLeft: !isRTL
                });

                setTimeout(function () {
                    $blog_masonry.isotope('layout');
                }, 500);
            });
        },
    };

    YOLO.woocommerce = {
        init: function () {
            YOLO.woocommerce.setCartScrollBar();
            YOLO.woocommerce.addCartQuantity();
            YOLO.woocommerce.addToCart();
            YOLO.woocommerce.quickView();
            YOLO.woocommerce.compare();
            YOLO.woocommerce.updateShippingMethod();
            YOLO.woocommerce.addToWishlist();

            YOLO.woocommerce.masonryInit();
            // YOLO.woocommerce.gridLayout();
            // setInterval(YOLO.woocommerce.gridLayout,300);
            YOLO.woocommerce.masonryLayout();
            // setInterval(YOLO.woocommerce.masonryLayout,300);
            YOLO.woocommerce.loadMore();
            YOLO.woocommerce.infiniteScroll();
            // YOLO.woocommerce.productsCreative();

            YOLO.woocommerce.paymentMethod();
        },
        windowResized : function () {
            YOLO.woocommerce.setCartScrollBar();
        },
        windowLoad : function() {
            YOLO.woocommerce.setCartScrollBar();
        },
        setCartScrollBar: function () {
            if(!($('body').hasClass('rtl'))){
                setTimeout(function () {
                    var $adminBar = $('#wpadminbar');
                    var $adminBarHeight = $adminBar.outerHeight();
                    var $site_top = $('.site-top').outerHeight();
                    var $shopping_cart_wrapper = $('.shopping-cart-wrapper').outerHeight();

                    var $windowHeight = $window.height();
                    var $divCartWrapperHeight = 417;
                    var $bufferBottom = 40;
                    var $maxCartHeight = 325;
                    var $heightScroll = '125px';
                    var $max_item_product = 3;
                    
                    if ($windowHeight - $adminBarHeight - $site_top - $shopping_cart_wrapper - $bufferBottom < $divCartWrapperHeight) {
                        $maxCartHeight = 200;
                        $heightScroll = '100px';
                        $max_item_product = 2;
                    }

                    $('.scrollbar-inner').scrollbar();
                    $('ul.cart_list.product_list_widget').parent().css('max-height', $maxCartHeight);

                    if ($("ul.cart_list.product_list_widget li").length > $max_item_product) {
                        $('ul.cart_list.product_list_widget .scroll-y').css('height', $heightScroll);

                    }
                }, 1000);
            }
        },
        addCartQuantity: function () {
            $(document).off('click', '.quantity .btn-number').on('click', '.quantity .btn-number', function (event) {
                event.preventDefault();
                var type = $(this).data('type'),
                    input = $('input', $(this).parent()),
                    current_value = parseFloat(input.val()),
                    max  = parseFloat(input.attr('max')),
                    min = parseFloat(input.attr('min')),
                    step = parseFloat(input.attr('step')),
                    stepLength = 0;
                if (input.attr('step').indexOf('.') > 0) {
                    stepLength = input.attr('step').split('.')[1].length;
                }

                if (isNaN(max)) {
                    max = 100;
                }
                if (isNaN(min)) {
                    min = 0;
                }
                if (isNaN(step)) {
                    step = 1;
                    stepLength = 0;
                }

                if (!isNaN(current_value)) {
                    if (type == 'minus') {
                        if (current_value > min) {
                            current_value = (current_value - step).toFixed(stepLength);
                            input.val(current_value).change();
                        }

                        if (parseFloat(input.val()) <= min) {
                            input.val(min).change();
                            $(this).attr('disabled', true);
                        }
                    }

                    if (type == 'plus') {
                        if (current_value < max) {
                            current_value = (current_value + step).toFixed(stepLength);
                            input.val(current_value).change();
                        }
                        if (parseFloat(input.val()) >= max) {
                            input.val(max).change();
                            $(this).attr('disabled', true);
                        }
                    }
                } else {
                    input.val(min);
                }
            });


            $('input', '.quantity').focusin(function () {
                $(this).data('oldValue', $(this).val());
            });

            $('input', '.quantity').on('change', function () {
                var input = $(this),
                    max = parseFloat(input.attr('max')),
                    min = parseFloat(input.attr('min')),
                    current_value = parseFloat(input.val()),
                    step = parseFloat(input.attr('step'));

                if (isNaN(max)) {
                    max = 100;
                }
                if (isNaN(min)) {
                    min = 0;
                }

                if (isNaN(step)) {
                    step = 1;
                }


                var btn_add_to_cart = $('.add_to_cart_button', $(this).parent().parent().parent());
                if (current_value >= min) {
                    $(".btn-number[data-type='minus']", $(this).parent()).removeAttr('disabled');
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', current_value);
                    }

                } else {
                    alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));

                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', $(this).data('oldValue'));
                    }
                }

                if (current_value <= max) {
                    $(".btn-number[data-type='plus']", $(this).parent()).removeAttr('disabled');
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', current_value);
                    }
                } else {
                    alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', $(this).data('oldValue'));
                    }
                }

            });
        },
        addToCart: function () {
            $(document).on('click', '.add_to_cart_button', function () {

                var button = $(this),
                    buttonWrap = button.parent();

                if (!button.hasClass('single_add_to_cart_button') && button.is( '.product_type_simple' )) {
   
                    button.addClass("added-spinner");
                    button.find('i').attr('class', 'fa fa-spinner fa-spin');
                    var productWrap = buttonWrap.parent().parent().parent().parent();
                    if (typeof(productWrap) == 'undefined') {
                        return;
                    }
                    productWrap.addClass('active');
                }

            });


            $body.bind("added_to_cart", function (event, fragments, cart_hash, $thisbutton) {
                YOLO.woocommerce.setCartScrollBar();
                var is_single_product = $thisbutton.hasClass('single_add_to_cart_button');

                if (is_single_product) return;

                var button         = $thisbutton,
                    buttonWrap     = button.parent(),
                    buttonViewCart = buttonWrap.find('.added_to_cart'),
                    addedTitle     = buttonViewCart.text(),
                    productWrap    = buttonWrap.parent().parent().parent().parent();

                button.remove();

                buttonViewCart.html('<i class="fa fa-check"></i>');

                setTimeout(function () {
                    $('.product-item-wrap.button-has-tooltip .added_to_cart').each(function() {
                        buttonWrap.tooltip('hide').attr('title', addedTitle).tooltip('fixTitle');
                        // $(this).parent().find('[data-toggle="tooltip"]').tooltip('hide').attr('title', addedTitle).tooltip('fixTitle');
                    });
                }, 500);

                setTimeout(function () {
                    productWrap.removeClass('active');
                }, 700);


            });
        },
        compare: function () {
            $('a.add_to_compare').on('click', function (event) {

                event.preventDefault();
                var button = $(this),
                    buttonWrap = button.parent();
                    // button.addClass("added-spinner");
                    // button.find('i').css('z-index', '2');
                    button.find('i').attr('class', 'fa fa-spinner fa-spin');

                var productWrap = buttonWrap.parent().parent().parent().parent();

                if (typeof(productWrap) == 'undefined') {
                    return;
                }
                productWrap.addClass('active');
            });
        },
        quickView : function() {
            var is_click_quick_view = false;
            $('.product-quick-view').on('click', function (event) {
                event.preventDefault();
                if (is_click_quick_view) return;
                is_click_quick_view = true;
                var product_id = $(this).data('product_id'),
                    popupWrapper = '#popup-product-quick-view-wrapper',
                    $icon = $(this).find('i'),
                    iconClass = $icon.attr('class'),
                    productWrap = $(this).parent().parent().parent().parent(),
                    button = $(this);
                productWrap.addClass('active');
                button.addClass('active');
                $icon.attr('class','fa fa-spinner fa-spin');
                $.ajax({
                    url: yolo_framework_ajax_url,
                    data: {
                        action: 'product_quick_view',
                        id: product_id
                    },
                    success: function (html) {
                        productWrap.removeClass('active');
                        button.removeClass('active');
                        $icon.attr('class',iconClass);
                        if ($(popupWrapper).length) {
                            $(popupWrapper).remove();
                        }
                        $('body').append(html);
                        YOLO.woocommerce.addCartQuantity();
                        // YOLO.common.tooltip();
                        $(popupWrapper).modal();
                        is_click_quick_view = false;
                    },
                    error: function (html) {
                        alert(2);
                        YOLO.common.hideLoading();
  
                        is_click_quick_view = false;
                    }
                });

            });
        },
        updateShippingMethod : function() {
            $body.bind('updated_shipping_method',function(){
                $('select.country_to_state, input.country_to_state').change();
            });
        },
        addToWishlist : function() {
            $(document).on('click', '.add_to_wishlist', function () {
                var button = $(this),
                    buttonWrap = button.parent().parent();

                if (!buttonWrap.parent().hasClass('single-product-function')) {
                    button.addClass("added-spinner");
                    button.find('i').attr('class', 'fa fa-spinner fa-spin');

                    var productWrap = buttonWrap.parent().parent().parent().parent();
                    if (typeof(productWrap) == 'undefined') {
                        return;
                    }
                    productWrap.addClass('active');
                }

            });

            $body.bind("added_to_wishlist", function (event, fragments, cart_hash, $thisbutton) {
                var button = $('.added-spinner.add_to_wishlist'),
                    buttonWrap = button.parent().parent();
                if (!buttonWrap.parent().hasClass('single-product-function')) {
                    var productWrap = buttonWrap.parent().parent().parent().parent();
                    if (typeof(productWrap) == 'undefined') {
                        return;
                    }
                    setTimeout(function () {
                        productWrap.removeClass('active');
                        button.removeClass('added-spinner');
                    }, 700);
                }
                // Add to update wishlist
                YOLO.woocommerce.updateWishlist();
            });
            // Add to update wishlist on wishlist page
            $('#yith-wcwl-form table tbody tr td a.remove, #yith-wcwl-form table tbody tr td a.add_to_cart_button').live('click',function(){
                var old_num_product = $('#yith-wcwl-form table tbody tr[id^="yith-wcwl-row"]').length;
                var count = 1;
                var time_interval = setInterval(function(){
                    count++;
                    var new_num_product = $('#yith-wcwl-form table tbody tr[id^="yith-wcwl-row"]').length;
                    if( old_num_product != new_num_product || count == 20 ){
                        clearInterval(time_interval);
                        YOLO.woocommerce.updateWishlist();
                    }
                },500);
            });
        },
        updateWishlist: function() {
            if( typeof yolo_framework_ajax_url == 'undefined' ){
                return;
            }
                
            var wishlist_wrapper = jQuery('.my-wishlist-wrapper');
            if( wishlist_wrapper.length == 0 ){
                return;
            }
            
            wishlist_wrapper.addClass('loading');
            
            jQuery.ajax({
                type : 'POST',
                url : yolo_framework_ajax_url,
                data : {action : 'update_woocommerce_wishlist'},
                success : function(response) {
                    var first_icon = wishlist_wrapper.children('i.fa:first');
                    wishlist_wrapper.html(response);
                    if( first_icon.length > 0 ){
                        wishlist_wrapper.prepend(first_icon);
                    }
                    wishlist_wrapper.removeClass('loading');
                }
            });

            setTimeout(function () {
                // $('.product-item-wrap.button-has-tooltip yith-wcwl-wishlistexistsbrowse a').not('add_to_wishlist').each(function() {

                //     $(this).find('.yith-wcwl-wishlistexistsbrowse,.yith-wcwl-add-button,.yith-wcwl-wishlistaddedbrowse', '.product-actions').tooltip({
                //             title: yolo_framework_constant.product_wishList
                //         });
                //     // $(this).parent().find('[data-toggle="tooltip"]').tooltip('hide').attr('title', addedTitle).tooltip('fixTitle');
                // });
                $('.product-item-wrap.button-has-tooltip').each(function() {
                    $(this).find('.yith-wcwl-wishlistexistsbrowse.hide,.yith-wcwl-add-button.hide,.yith-wcwl-wishlistaddedbrowse.hide', '.product-actions').tooltip({
                        title: yolo_framework_constant.product_wishList_added
                    });
                });   
            }, 500);

            // $('.product-item-wrap.button-has-tooltip').each(function() {
            //     $(this).find('.yith-wcwl-wishlistexistsbrowse.hide,.yith-wcwl-add-button.hide,.yith-wcwl-wishlistaddedbrowse.hide', '.product-actions').tooltip({
            //         title: yolo_framework_constant.product_wishList_added
            //     });
            // });        
        },
        masonryInit: function () {

            var default_filter = [];
            
            
            var array_filter = []; // Push filter to an array to process when don't have filter

            if(!($('.shortcode-product-wrap').hasClass('creative'))){
                $('.shortcode-product-wrap').each(function(index, value) {
                        // Process filter each shortcode
                        $(this).find('.product-filters ul li').first().find('a').addClass('selected');
                        // default_filter[index] = $(this).find('.product-filters ul li').first().find('a').attr('data-option-value');
                        default_filter = $(this).find('.product-filters ul li').first().find('a').attr('data-option-value');
                        var self = $(this);
                        var $container = $(this).find('.product-listing'); // parent element of .item
                        var $filter = $(this).find('.product-filters a');
                        var masonry_options = {
                            'gutter' : 0
                        };
                        
                        array_filter[index] = $filter;

                        // Add to process product layout style
                        var shortcode_inner = '.shortcode-product-wrap .product-inner';
                        var layoutMode = 'fitRows';
                        if ( ($(shortcode_inner).hasClass('product-style-masonry')) ) {
                            var layoutMode = 'masonry';
                        }

                        for( var i = 0; i < array_filter.length; i++ ) {
                            if( array_filter[i].length == 0 ) {
                                default_filter = '';
                            }
                            $container.isotope({
                                itemSelector : '.product-item-wrap', // .item
                                transitionDuration : '0.8s',
                                masonry : masonry_options,
                                layoutMode : layoutMode,
                                filter: default_filter
                                // filter: default_filter[i]
                            });   
                        }                  

                        imagesLoaded(self,function(){
                            $container.isotope('layout');
                        });

                        $(window).resize(function(){
                            $container.isotope('layout');
                        });

                        $filter.click(function(e){
                            e.stopPropagation();
                            e.preventDefault();
                            var $this = jQuery(this);
                            // don't proceed if already selected
                            if ($this.hasClass('selected')) {
                                return false;
                            }
                            var filters = $this.closest('ul');
                            filters.find('.selected').removeClass('selected');
                            $this.addClass('selected');

                            var options = {
                                    layoutMode : 'fitRows',
                                    transitionDuration : '0.8s',
                                    'masonry' : {
                                        'gutter' : 0
                                    }
                                },
                                key = filters.attr('data-option-key'),
                                value = $this.attr('data-option-value');

                            value = value === 'false' ? false : value;
                            options[key] = value;

                            $container.isotope(options);

                        });
                });
            }

            $(window).resize(function () {
                YOLO.woocommerce.reinitFilter();
            });
            YOLO.woocommerce.reinitFilter();
        },
        loadMore : function() {
            $('.product-load-more').on('click', function (event) {
                event.preventDefault();
                var $this = $(this).button('loading');
                var link = $(this).attr('data-href');
                var shortcode_inner = '.shortcode-product-wrap .product-inner';
                var contentWrapper = '.product-listing'; // parent element of .item
                var element = '.product-item-wrap'; // .item

                $.get(link, function (data) {
                    var next_href = $('.product-load-more', data).attr('data-href');
                    var $newElems = $(element, data).css({
                        opacity: 0
                    });

                    $(contentWrapper).append($newElems);
                    $newElems.imagesLoaded(function () {
                        $newElems.animate({
                            opacity: 1
                        });

                        if (($(shortcode_inner).hasClass('product-style-masonry'))  || ($(shortcode_inner).hasClass('product-style-grid')) || ($(shortcode_inner).hasClass('product-style-list'))) {
                            $(contentWrapper).isotope('appended', $newElems);
                            setTimeout(function() {
                                $(contentWrapper).isotope('layout');
                            }, 400);
                        }
                        // Re run actions
                        YOLO.common.tooltip();
                        YOLO.woocommerce.compare();
                        YOLO.woocommerce.quickView();
                    });


                    if (typeof(next_href) == 'undefined') {
                        $this.parent().remove();
                    } else {
                        $this.button('reset');
                        $this.attr('data-href', next_href);
                    }

                });
            });
        },
        infiniteScroll : function() {
            var shortcode_inner = '.shortcode-product-wrap .product-inner';
            var contentWrapper = '.product-listing'; // parent element of .item
            $('.product-listing').infinitescroll({
                navSelector: "#infinite_scroll_button",
                nextSelector: "#infinite_scroll_button a",
                itemSelector: ".product-item-wrap", // .item
                loading: {
                    'selector': '#infinite_scroll_loading',
                    'img': yolo_framework_theme_url + '/assets/images/ajax-loader.gif',
                    'msgText': 'Loading...',
                    'finishedMsg': ''
                }
            }, function (newElements, data, url) {
                var $newElems = $(newElements).css({
                    opacity: 0
                });
                $newElems.imagesLoaded(function () {
                    $newElems.animate({
                        opacity: 1
                    });


                    if (($(shortcode_inner).hasClass('product-style-masonry'))  || ($(shortcode_inner).hasClass('product-style-grid')) || ($(shortcode_inner).hasClass('product-style-list'))) {
                        $(contentWrapper).isotope('appended', $newElems);
                        setTimeout(function() {
                            $(contentWrapper).isotope('layout');
                        }, 400);
                        // Re run actions
                        YOLO.common.tooltip();
                        YOLO.woocommerce.compare();
                        YOLO.woocommerce.quickView();
                    } 
                });

            });
        },
        sorting : function() {
            // Do something to sorting products
        },
        gridLayout : function() {
            var $product_grid = $('.product-listing'); // parent element of .item
            if( $product_grid.parent().hasClass('product-style-grid') ) {
                $product_grid.imagesLoaded( function() {
                    $product_grid.isotope({
                        itemSelector: '.product-item-wrap', // .item
                        layoutMode: "fitRows",
                        isOriginLeft: !isRTL
                    });
                    setTimeout(function () {
                        $product_grid.isotope('layout');
                    }, 500);
                });
            }    
        },
        masonryLayout : function() {
            var $product_masonry = $('.archive-product-wrap .product-listing'); // parent element of .item
            var product_style = $('.site-content-archive-product').data('product-style');
                $product_masonry.imagesLoaded( function() {
                    $product_masonry.isotope({
                        itemSelector: '.product-item-wrap', // .item
                        layoutMode: product_style,
                        isOriginLeft: !isRTL
                    });

                    setTimeout(function () {
                        $product_masonry.isotope('layout');
                    }, 500);
                });
        },
        
        reinitFilter: function () {
            $('.product-creative').each(function () {
                var $col = $(this).attr('data-columns');
                var $item_per_page = 6;
                if($col=='2')
                    $item_per_page = 5;
                var $windowSize = $(window).width();

                if (600 <= $windowSize && $windowSize <= 1023) {
                    $item_per_page = 2;
                }
                if ($windowSize < 600) {
                    $item_per_page = 1;
                }
                var $total_product = $('.iso-filter', $(this)).attr('data-total-product');
                var $total_page = 0;
                $total_product = parseInt($total_product);
                if ($total_product % $item_per_page > 0)
                    $total_page = Math.floor($total_product / $item_per_page) + 1;
                else
                    $total_page = Math.floor($total_product / $item_per_page);

                $('.iso-filter', $(this)).attr('data-total-pages', $total_page);
                var $product_wrap = $('.product-listing', $(this));
                var $index = 1;
                var $page_class = '';
                $('.product-item-wrap', $product_wrap).each(function () {
                    $(this).removeClass(function (index, css) {
                        return (css.match(/\bpage-\S+/g) || []).join(' ');
                    });
                    if ($index % $item_per_page > 0) {
                        $page_class = 'page-' + (Math.floor($index / $item_per_page) + 1);
                    } else {
                        $page_class = 'page-' + Math.floor($index / $item_per_page);
                    }
                    $(this).addClass($page_class);
                    $index++;
                });
                var $filter_value = '.page-1';
                $product_wrap.isotope({ filter: $filter_value });
                $('.iso-filter', $(this)).attr('data-page', 1);
            })
        },
        paymentMethod : function() {
            var $orderReview = $( '#order_review' );
            $orderReview.on( 'click', 'input[name=payment_method]', function() {
                $('.payment_box_title').removeClass('active');
                $(this).parent().addClass('active');
            });
        }
    };

	YOLO.search = {
		up: function($wrapper) {
			var $item = $('li.selected', $wrapper);
			if ($('li', $wrapper).length < 2) return;
			var $prev = $item.prev();
			$item.removeClass('selected');
			if ($prev.length) {
				$prev.addClass('selected');
			}
			else {
				$('li:last', $wrapper).addClass('selected');
				$prev = $('li:last', $wrapper);
			}
			var $ajaxSearchResult = $(' > ul', $wrapper);

			if ($prev.position().top < $ajaxSearchResult.scrollTop()) {
				$ajaxSearchResult.scrollTop($prev.position().top);
			}
			else if ($prev.position().top + $prev.outerHeight() > $ajaxSearchResult.scrollTop() + $ajaxSearchResult.height()) {
				$ajaxSearchResult.scrollTop($prev.position().top - $ajaxSearchResult.height() + $prev.outerHeight());
			}
		},
		down: function ($wrapper) {
			var $item = $('li.selected', $wrapper);
			if ($('li', $wrapper).length < 2) return;
			var $next = $item.next();
			$item.removeClass('selected');
			if ($next.length) {
				$next.addClass('selected');
			}
			else {
				$('li:first', $wrapper).addClass('selected');
				$next = $('li:first', $wrapper);
			}
			var $ajaxSearchResult = $('> ul', $wrapper);

			if ($next.position().top < $ajaxSearchResult.scrollTop()) {
				$ajaxSearchResult.scrollTop($next.position().top);
			}
			else if ($next.position().top + $next.outerHeight() > $ajaxSearchResult.scrollTop() + $ajaxSearchResult.height()) {
				$ajaxSearchResult.scrollTop($next.position().top - $ajaxSearchResult.height() + $next.outerHeight());
			}
		}
	};

    YOLO.header = {
        timeOutSearch: null,
        init: function () {
            YOLO.header.stickyHeader();
            YOLO.header.menuOnePage();
            YOLO.header.menuMobile();
            YOLO.header.events();
            YOLO.header.search();
	        YOLO.header.searchAjaxForm();
	        YOLO.header.headerLeftPosition();
            YOLO.header.searchCategory();
	        YOLO.header.canvasMenu();
        },
        events: function() {
            // Anchors Position
            $("a[data-hash]").on("click", function (e) {
                e.preventDefault();
                YOLO.page.anchorsPosition(this);
                return false;
            });
        },
        windowResized : function(){
            YOLO.header.stickyHeader();
	        YOLO.header.headerNavSpacing();
            if (YOLO.common.isDesktop()) {
                $('.toggle-icon-wrapper[data-drop]').removeClass('in');
            }
            var $adminBar = $('#wpadminbar');

            if ($adminBar.length > 0) {
                $body.attr('data-offset', $adminBar.outerHeight() + 1);
            }
            if ($adminBar.length > 0) {
                $body.attr('data-offset', $adminBar.outerHeight() + 1);
            }
	        YOLO.header.headerMobileFlyPosition();
	        YOLO.header.headerMobilePosition();
        },
	    windowLoad: function() {
		    YOLO.header.headerNavSpacing(1);
		    YOLO.header.headerLeftScrollBar();
		    YOLO.header.headerMobileFlyPosition();
		    YOLO.header.headerMobilePosition();
		    YOLO.header.fixStickyLogoSize();
	    },
	    fixStickyLogoSize: function() {
			// if IE
		    if (YOLO.common.isIE()) {
			    var $logo = $("header .logo-sticky img");
			    if ($logo.length == 0) {
				    return;
			    }
			    var logo_url = $logo.attr('src');
			    if (logo_url.length - logo_url.lastIndexOf('.svg') != 4) {
				    return;
			    }
			    $.get(logo_url, function(svgxml){
				    /* now with access to the source of the SVG, lookup the values you want... */
				    var attrs = svgxml.documentElement.attributes;

				    var pic_real_width = attrs.width.value;   // Note: $(this).width() will not
				    var pic_real_height = attrs.height.value; // work for in memory images.

				    if (typeof (pic_real_width) == "string") {
					    pic_real_width = pic_real_width.replace('px','');
					    pic_real_width = parseInt(pic_real_width, 10);
				    }
				    if (typeof (pic_real_height) == "string") {
					    pic_real_height = pic_real_height.replace('px','');
					    pic_real_height = parseInt(pic_real_height, 10);
				    }

				    if (pic_real_height > 0) {
					    $logo.css('width', (pic_real_width * 30 / pic_real_height) +  'px');
				    }
			    }, "xml");

			}
	    },
		headerMobileFlyPosition: function() {
			var top = 0;
			if (($('#wpadminbar').length > 0) && ($('#wpadminbar').css('position') == 'fixed')) {
				top = $('#wpadminbar').outerHeight();
			}
			if (top > 0) {
				$('.yolo-mobile-header-nav.menu-drop-fly').css('top',top + 'px');
			}
			else {
				$('.yolo-mobile-header-nav.menu-drop-fly').css('top','');
			}
		},
	    headerMobilePosition: function() {
		    var top = 0;
		    if (($('#wpadminbar').length > 0) && ($('#wpadminbar').css('position') == 'fixed')) {
			    top = $('#wpadminbar').outerHeight();
		    }
		    if (top > 0) {
			    $('.yolo-mobile-header-nav.menu-drop-fly').css('top',top + 'px');
		    }
		    else {
			    $('.yolo-mobile-header-nav.menu-drop-fly').css('top','');
		    }
	    },
	    headerLeftPosition: function() {
			var top = 0;
		    if ($('#wpadminbar').length > 0) {
			    top = $('#wpadminbar').outerHeight();
		    }
			if (top > 0) {
				$('header.header-left').css('top',top + 'px');
			}
	    },
        stickyHeader : function() {
            var topSpacing = 0,
                $adminBar = $('#wpadminbar');

            if (($adminBar.length > 0) && ($adminBar.css('position') =='fixed')) {
                topSpacing = $adminBar.outerHeight();
            }

            $('.header-sticky, .header-mobile-sticky').unstick();
	        var topSticky = topSpacing;
            if (YOLO.common.isDesktop()) {
	            topSpacing = -$(window).height() + 65;
                $('.header-sticky').sticky({
	                topSpacing:topSpacing,
	                topSticky: topSticky
                });
            }
            else {
                $('.header-mobile-sticky').sticky({topSpacing:topSpacing, topSticky: topSticky});
            }
        },
        menuOnePage : function() {
            $('.menu-one-page').onePageNav({
                currentClass: 'menu-current',
                changeHash: false,
                scrollSpeed: 750,
                scrollThreshold: 0.5,
                filter: '',
                easing: 'swing'
            });
        },
        anchorsPosition : function(obj, time) {
            var target = $(obj).attr("href");
            if ($(target).length > 0) {
                var _scrollTop = $(target).offset().top,
                    $adminBar = $('#wpadminbar');
                if ($adminBar.length > 0) {
                    _scrollTop -= $adminBar.outerHeight();
                }
                $("html,body").animate({scrollTop: _scrollTop}, time, 'swing', function () {

                });
            }
        },
        menuMobile : function() {
            $('.toggle-mobile-menu[data-ref]').click(function(event) {
                event.preventDefault();
                var $this = $(this);
                var data_drop = $this.data('ref');
                $this.toggleClass('in');
                switch ($this.data('drop-type')) {
                    case 'dropdown':
                        $('#' + data_drop).slideToggle();
                        break;
                    case 'fly':
                        $('body').toggleClass('menu-mobile-in');
                        $('#' + data_drop).toggleClass('in');
                        break;
                }

            });

            $('.toggle-icon-wrapper[data-ref]:not(.toggle-mobile-menu)').click(function(event) {
                event.preventDefault();
                var $this = $(this);
                var data_ref = $this.data('ref');
                $this.toggleClass('in');
                $('#' + data_ref).toggleClass('in');
            });

            $('.yolo-mobile-menu-overlay').click(function() {
                $body.removeClass('menu-mobile-in');
                $('#yolo-nav-mobile-menu').removeClass('in');
                $('.toggle-icon-wrapper[data-ref]').removeClass('in');
            });
        },
        canvasMenu: function () {
            $('nav.yolo-canvas-menu-wrapper').perfectScrollbar({
                wheelSpeed: 0.5,
                suppressScrollX: true
            });

            $(document).on('click', function(event) {
                if (($(event.target).closest('nav.yolo-canvas-menu-wrapper').length == 0)
                    && ($(event.target).closest('.canvas-menu-toggle')).length == 0) {
                    $('nav.yolo-canvas-menu-wrapper').removeClass('in');
                }
            });

            $('.canvas-menu-toggle').on('click', function (event) {
                event.preventDefault();
                $('nav.yolo-canvas-menu-wrapper').toggleClass('in');
            });
            $('.yolo-canvas-menu-close').on('click', function (event) {
                event.preventDefault();
                $('nav.yolo-canvas-menu-wrapper').removeClass('in');
            });
        },
        search : function() {
            var $search_popup = $('#yolo_search_popup_wrapper');
            if (($search_popup.length > 0) && ($('header .icon-search-menu').data('search-type') == 'standard')) {
                var dlg_search = new DialogFx( $search_popup[0] );
                $('header .icon-search-menu').click(dlg_search.toggle.bind(dlg_search));

            }

            $('header .icon-search-menu').click(function (event) {
                event.preventDefault();
                if ($(this).data('search-type') == 'ajax') {
                    YOLO.header.searchPopupOpen();
                }
                else {
                    $('#yolo_search_popup_wrapper input[type="text"]').focus();
                }
            });

            $('.yolo-dismiss-modal, .modal-backdrop', '#yolo-modal-search').click(function(){
                YOLO.header.searchPopupClose();
            });
            $('.yolo-search-wrapper button > i.ajax-search-icon').click(function(){
                s_search();
            });

            // Search Ajax
            $('#search-ajax', '#yolo-modal-search').on('keyup', function(event){
                if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
                    return;
                }

                var keys = ["Control", "Alt", "Shift"];
                if (keys.indexOf(event.key) != -1) return;
                switch (event.which) {
                    case 27:	// ESC
                        YOLO.header.searchPopupClose();
                        break;
                    case 38:	// UP
                        s_up();
                        break;
                    case 40:	// DOWN
                        s_down();
                        break;
                    case 13:	//ENTER
                        var $item = $('li.selected a', '#yolo-modal-search');
                        if ($item.length == 0) {
                            event.preventDefault();
                            return false;
                        }
                        s_enter();
                        break;
                    default:
                        clearTimeout(YOLO.header.timeOutSearch);
                        YOLO.header.timeOutSearch = setTimeout(s_search, 500);
                        break;
                }
            });

            function s_up(){
                var $item = $('li.selected', '#yolo-modal-search');
                if ($('li', '#yolo-modal-search').length < 2) return;
                var $prev = $item.prev();
                $item.removeClass('selected');
                if ($prev.length) {
                    $prev.addClass('selected');
                }
                else {
                    $('li:last', '#yolo-modal-search').addClass('selected');
                    $prev = $('li:last', '#yolo-modal-search');
                }
                if ($prev.position().top < $('#yolo-modal-search .ajax-search-result').scrollTop()) {
                    $('#yolo-modal-search .ajax-search-result').scrollTop($prev.position().top);
                }
                else if ($prev.position().top + $prev.outerHeight() > $('#yolo-modal-search .ajax-search-result').scrollTop() + $('#yolo-modal-search .ajax-search-result').height()) {
                    $('#yolo-modal-search .ajax-search-result').scrollTop($prev.position().top - $('#yolo-modal-search .ajax-search-result').height() + $prev.outerHeight());
                }
            }
            function s_down() {
                var $item = $('li.selected', '#yolo-modal-search');
                if ($('li', '#yolo-modal-search').length < 2) return;
                var $next = $item.next();
                $item.removeClass('selected');
                if ($next.length) {
                    $next.addClass('selected');
                }
                else {
                    $('li:first', '#yolo-modal-search').addClass('selected');
                    $next = $('li:first', '#yolo-modal-search');
                }
                if ($next.position().top < $('#yolo-modal-search .ajax-search-result').scrollTop()) {
                    $('#yolo-modal-search .ajax-search-result').scrollTop($next.position().top);
                }
                else if ($next.position().top + $next.outerHeight() > $('#yolo-modal-search .ajax-search-result').scrollTop() + $('#yolo-modal-search .ajax-search-result').height()) {
                    $('#yolo-modal-search .ajax-search-result').scrollTop($next.position().top - $('#yolo-modal-search .ajax-search-result').height() + $next.outerHeight());
                }
            }
            function s_enter() {
                var $item = $('li.selected a', '#yolo-modal-search');
                if ($item.length > 0) {
                    window.location = $item.attr('href');
                }
            }
            function s_search() {
                var keyword = $('input[type="search"]', '#yolo-modal-search').val();
                if (keyword.length < 3) {
                    $('.ajax-search-result', '#yolo-modal-search').html('');
                    return;
                }
                $('.ajax-search-icon', '#yolo-modal-search').addClass('fa-spinner fa-spin');
                $('.ajax-search-icon', '#yolo-modal-search').removeClass('fa-search');
                $.ajax({
                    type   : 'POST',
                    data   : 'action=result_search&keyword=' + keyword,
                    url    : yolo_framework_ajax_url,
                    success: function (data) {
                        $('.ajax-search-icon', '#yolo-modal-search').removeClass('fa-spinner fa-spin');
                        $('.ajax-search-icon', '#yolo-modal-search').addClass('fa-search');
                        var html = '';
	                    var html_view_more = '';
                        if (data) {
                            var items = $.parseJSON(data);
                            if (items.length) {
                                html +='<ul>';
                                if (items[0]['id'] == -1) {
                                    html += '<li>' + items[0]['title']  + '</li>';
                                }
                                else {
                                    $.each(items, function (index) {
	                                    if (this['id'] == -2) {
		                                    html_view_more = '<div class="search-view-more">' + this['title'] + '</div>';
	                                    }
	                                    else {
		                                    if (index == 0) {
			                                    html += '<li class="selected">';
		                                    }
		                                    else {
			                                    html += '<li>';
		                                    }
		                                    if (this['title'] == null || this['title'] == '') {
			                                    html += '<a href="' + this['guid'] + '">' + this['date'] + '</a>';
		                                    }
		                                    else {
			                                    html += '<a href="' + this['guid'] + '">' + this['title'] + '</a>';
			                                    html += '<span>' + this['date'] + ' </span>';
		                                    }
		                                    html += '</li>';
	                                    }
                                    });
                                }


                                html +='</ul>';
                            }
                            else {
                                html = '';
                            }
                        }
                        $('.ajax-search-result', '#yolo-modal-search').html(html + html_view_more);
                        $('#yolo-modal-search .ajax-search-result').scrollTop(0);
                    },
                    error : function(data) {
	                    $('.ajax-search-icon', '#yolo-modal-search').removeClass('fa-spinner fa-spin');
	                    $('.ajax-search-icon', '#yolo-modal-search').addClass('fa-search');
                    }
                });
            }
        },
        searchPopupOpen : function() {
            if (!$('#yolo-modal-search').hasClass('in')) {
	            $('body').addClass('overflow-hidden');
                $('#yolo-modal-search').show();
                setTimeout(function () {
                    $('#yolo-modal-search').addClass('in');
                }, 300);

                if ($('#search-ajax', '#yolo-modal-search').length > 0) {
                    $('#search-ajax', '#yolo-modal-search').focus();
                    $('#search-ajax', '#yolo-modal-search').val('');
                }
                else {
                    $('#search-standard', '#yolo-modal-search').focus();
                    $('#search-standard', '#yolo-modal-search').val('');
                }

                $('.ajax-search-result', '#yolo-modal-search').html('');
            }
        },
        searchPopupClose : function() {
            if ($('#yolo-modal-search').hasClass('in')) {
                $('#yolo-modal-search').removeClass('in');
                setTimeout(function () {
                    $('#yolo-modal-search').hide();
	                $('body').removeClass('overflow-hidden');
                }, 300);
            }
        },
	    searchAjaxForm: function() {
		    var $wrapper = $('header.yolo-main-header .search-box-wrapper');
		    var $form_wrapper = $('header.yolo-main-header .search-box-wrapper form.search-type-ajax');
		    $($window).click(function(event){
			    if ($(event.target).closest('header.yolo-main-header .search-box-wrapper').length == 0) {
				    $('.ajax-search-result', $wrapper).remove();
				    $('> input[type="text"]', $form_wrapper).val('');
			    }
		    });
		    $form_wrapper.submit(function() {
			    return false;
		    });

		    $('> input[type="text"]', $form_wrapper).on('keyup', function(event) {
			    if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
				    return;
			    }

			    var keys = ["Control", "Alt", "Shift"];
			    if (keys.indexOf(event.key) != -1) return;
			    switch (event.which) {
				    case 27:	// ESC
					    remove_search_result();
					    break;
				    case 38:	// UP
					    YOLO.search.up($wrapper);
					    break;
				    case 40:	// DOWN
					    YOLO.search.down($wrapper);

					    break;
				    case 13:	//ENTER
					    s_enter();
					    break;
				    default:
					    clearTimeout(YOLO.header.timeOutSearch);
					    YOLO.header.timeOutSearch = setTimeout(s_search, 500);
					    break;
			    }
			    function remove_search_result() {
					$('.ajax-search-result', $wrapper).remove();
				    $('> input[type="text"]', $form_wrapper).val('');
			    }

			    function s_enter() {
				    var $item = $('li.selected a', $wrapper);

				    if ($item.length > 0) {
					    window.location = $item.attr('href');
				    }
			    }
			    function s_search() {
				    var keyword = $('input[type="text"]', $form_wrapper).val();
				    if (keyword.length < 3) {
					    if ($('.ajax-search-result', $form_wrapper).length == 0) {
						    $($form_wrapper).append('<div class="ajax-search-result"></div>');
					    }
					    var hint_message = $wrapper.attr('data-hint-message');

					    $('.ajax-search-result', $wrapper).html('<ul><li class="no-result">' + hint_message + '</li></ul>');
					    return;
				    }
				    $('button > i', $form_wrapper).addClass('fa-spinner fa-spin');
				    $('button > i', $form_wrapper).removeClass('fa-search');
				    $.ajax({
					    type   : 'POST',
					    data   : 'action=result_search&keyword=' + keyword,
					    url    : yolo_framework_ajax_url,
					    success: function (data) {
						    $('button > i', $wrapper).removeClass('fa-spinner fa-spin');
						    $('button > i', $wrapper).addClass('fa-search');
						    var html = '';
						    var html_view_more = '';
						    if (data) {
							    var items = $.parseJSON(data);
							    if (items.length) {
								    html +='<ul>';
								    if (items[0]['id'] == -1) {
									    html += '<li class="no-result">' + items[0]['title']  + '</li>';
								    }
								    else {
									    $.each(items, function (index) {
										    if (this['id'] == -2) {
											    html_view_more = '<div class="search-view-more">' + this['title'] + '</div>';
										    }
										    else {
											    if (index == 0) {
												    html += '<li class="selected">';
											    }
											    else {
												    html += '<li>';
											    }
											    if (this['title'] == null || this['title'] == '') {
												    html += '<a href="' + this['guid'] + '">' + this['date'] + '</a>';
											    }
											    else {
												    html += '<a href="' + this['guid'] + '">' + this['title'] + '</a>';
											    }
											    html += '</li>';
										    }
									    });
								    }
								    html +='</ul>';
							    }
							    else {
								    html = '';
							    }
						    }
						    if ($('.ajax-search-result', $form_wrapper).length == 0) {
							    $($form_wrapper).append('<div class="ajax-search-result"></div>');
						    }

						    $('.ajax-search-result', $wrapper).html(html + html_view_more);
						    $('.ajax-search-result ul', $wrapper).scrollTop(0);
					    },
					    error : function(data) {
						    $('button > i', $wrapper).removeClass('fa-spinner fa-spin');
						    $('button > i', $wrapper).addClass('fa-search');
					    }
				    });
			    }


		    });
	    },

	    headerNavSpacing: function(retryAmount) {
		    if (typeof (retryAmount) == "undefined") {
			    retryAmount = 0;
		    }

		    if (!YOLO.common.isDesktop()) {
		        return;
		    }
		    var $container = $('header.yolo-main-header .yolo-header-nav-wrapper > .container');

		    $('ul.main-menu > li, .header-customize', $container).css('margin-left','');

		    var navContainerWidth = $container.width();
		    var navItemWidth = 0;
		    var navItemCount = 0;
		    var marginLeft = 0;
		    var totalMarginLeft = 0;

			$('ul.main-menu > li, .header-customize,.header-left .header-logo,.header-left .logo-sticky', $container).each(function() {
				var $this = $(this);
				if ($this.is(':visible')) {
					marginLeft = parseInt($this.css('margin-left').replace('px','') , 10);
					navItemWidth += $this.outerWidth() + marginLeft + 1;
					totalMarginLeft += marginLeft;
					if (marginLeft > 0) {
						navItemCount++;
					}
				}

			});

		    if ($('.header-customize', $container).length > 0) {
			    marginLeft = parseInt($('.header-customize', $container).css('margin-left').replace('px','') , 10);
			    totalMarginLeft += marginLeft;
			    navItemWidth += marginLeft;
			    if (marginLeft > 0) {
				    navItemCount++;
			    }
		    }

		    navItemWidth += 50;


		    if ((navItemCount > 0) && (navItemWidth > navContainerWidth)) {
				var newMarginLeft = (totalMarginLeft - (navItemWidth - navContainerWidth)) / (1.0 * navItemCount);
			    if (marginLeft < 5) {
				    marginLeft = 5;
			    }
			    $('ul.main-menu > li.menu-item + li, .header-customize', $container).css('margin-left', newMarginLeft + 'px');
			    if ($('ul.main-menu > li.logo-sticky', $container).is(':visible')) {
				    $('ul.main-menu > li.logo-sticky + li', $container).css('margin-left', newMarginLeft + 'px');
			    }
		    }
		    YOLO.header.changeStickyWrapperSize(2);

		    if (retryAmount > 0) {
			    setTimeout(function() {
				    YOLO.header.headerNavSpacing(retryAmount - 1);
			    }, 100);
		    }
	    },
	    changeStickyWrapperSize: function(count) {
		    var $sticky_wrapper = $('header.yolo-main-header .yolo-sticky-wrapper');
		    if ($sticky_wrapper.length > 0) {
			    $sticky_wrapper.height($(' > .header-sticky',$sticky_wrapper).outerHeight());
		    }

		    if (count > 0) {
			    setTimeout(function() {
				    YOLO.header.changeStickyWrapperSize(count - 1);
			    }, 100);
		    }
	    },
	    headerLeftScrollBar: function () {
		    $('header.header-left').perfectScrollbar({
			    wheelSpeed: 0.5,
			    suppressScrollX: true
		    });
	    },
	    searchCategory: function () {
		    $('.search-with-category').each(function() {
			    var $wrapperLeft = $('.form-search-left', this);
			    var $wrapper = $(this);
			    $(document).on('click', function(event) {
				    if ($(event.target).closest('.form-search-left', $wrapper).length === 0) {
					    $(' > ul', $wrapperLeft).slideUp();
				    }
				    if (($(event.target).closest('.form-search-right,.ajax-search-result', $wrapper).length === 0)) {
					    $('.ajax-search-result', $wrapper).remove();
					    $('input', $wrapper).val('');
				    }
			    });

			    var sHtml = '<li><span data-id="-1" data-value="' + $('> span', $wrapperLeft).text() + '">[' + $('> span', $wrapperLeft).text() + ']</span></li>';
			    $('> ul', $wrapperLeft).prepend(sHtml);

			    // Select Category
			    $('> span', $wrapperLeft).on('click', function() {
				    $('> ul', $(this).parent()).slideToggle();
			    });

			    // Category Click
			    $('li > span', $wrapperLeft).on('click', function() {
				    var $this = $(this);
				    var id = $this.attr('data-id');
				    var text = '';
				    if (typeof ($this.attr('data-value')) != "undefined") {
					    text = $this.attr('data-value');
				    }
				    else {
					    text = $this.text();
				    }

				    var $cate_current = $('> span', $wrapperLeft);
				    $cate_current.text(text);
				    $cate_current.attr('data-id', id);
				    $(' > ul', $wrapperLeft).slideUp();
			    });

			    // Search process
			    //--------------------------------------------------------------------------------------
			    var $inputSearch = $('input', $wrapper);
			    $inputSearch.on('keyup', function(event){
				    var s_timeOut_search = null;
				    if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
					    return;
				    }

				    var keys = ["Control", "Alt", "Shift"];
				    if (keys.indexOf(event.key) != -1) return;
				    switch (event.which) {
					    case 37:
					    case 39:
						    break;
					    case 27:	// ESC
						    $('.ajax-search-result', $wrapper).remove();
						    $(this).val('');
						    break;
					    case 38:	// UP
						    YOLO.search.up($('.ajax-search-result', $wrapper));
						    break;
					    case 40:	// DOWN
						    YOLO.search.down($('.ajax-search-result', $wrapper));
						    break;
					    case 13:	//ENTER
						    var $item = $('.ajax-search-result li.selected a', $wrapper);
						    if ($item.length == 0) {
							    event.preventDefault();
							    return false;
						    }

						    window.location = $item.attr('href');

						    event.preventDefault();
						    return false;
					    default:
						    clearTimeout(s_timeOut_search);
						    s_timeOut_search = setTimeout(function() {
							    s_search($wrapper);
						    }, 500);
						    break;
				    }
			    });
		    });

		    function s_search($wrapper) {
			    var keyword = $('input[type="text"]', $wrapper).val();
			    if (keyword.length < 3) {
				    if ($('.ajax-search-result', $wrapper).length == 0) {
					    $($wrapper).append('<div class="ajax-search-result"></div>');
				    }
				    var hint_message = $wrapper.attr('data-hint-message');

				    $('.ajax-search-result', $wrapper).html('<ul><li class="no-result">' + hint_message + '</li></ul>');
				    return;
			    }
			    $('button > i', $wrapper).addClass('fa-spinner fa-spin');
			    $('button > i', $wrapper).removeClass('fa-search');
			    $.ajax({
				    type   : 'POST',
				    data   : 'action=result_search_product&keyword=' + keyword + '&cate_id=' + $('.form-search-left > span', $wrapper).attr('data-id'),
				    url    : yolo_framework_ajax_url,
				    success: function (data) {
					    $('button > i', $wrapper).removeClass('fa-spinner fa-spin');
					    $('button > i', $wrapper).addClass('fa-search');
					    var html = '';
					    var sHtmlViewMore = '';
					    if (data) {
						    var items = $.parseJSON(data);
						    if (items.length) {
							    html +='<ul>';
							    if (items[0]['id'] == -1) {
								    html += '<li class="no-result">' + items[0]['title']  + '</li>';
							    }
							    else {
								    $.each(items, function (index) {
									    if (this['id'] == -2) {
										    sHtmlViewMore = '<div class="search-view-more">' + this['title'] + '</div>';
									    }
									    else {
										    if (index == 0) {
											    html += '<li class="selected">';
										    }
										    else {
											    html += '<li>';
										    }
										    html += '<a href="' + this['guid'] + '">';
										    html += this['thumb'];
										    html += this['title'] + '</a>';
										    html += '<div class="price">' + this['price'] + '</div>';
										    html += '</li>';
									    }

								    });
							    }
							    html +='</ul>';
						    }
						    else {
							    html = '';
						    }
					    }
					    if ($('.ajax-search-result', $wrapper).length == 0) {
						    $($wrapper).append('<div class="ajax-search-result"></div>');
					    }

					    $('.ajax-search-result', $wrapper).html(html + sHtmlViewMore);

					    $('.ajax-search-result li', $wrapper).hover(function () {
						    $('.ajax-search-result li', $wrapper).removeClass('selected');
						    $(this).addClass('selected');
					    });

					    $('.ajax-search-result ul', $wrapper).scrollTop(0);

				    },
				    error : function(data) {
					    $('button > i', $wrapper).removeClass('fa-spinner fa-spin');
					    $('button > i', $wrapper).addClass('fa-search');
				    }
			    });
		    }
	    }
    };

    YOLO.footer = {
        init: function () {
            YOLO.footer.scrollUp();
        },

        scrollUp:function(){
            var $scrollUp = $('.a-scroll-up','.map-scroll-up');
            if ($scrollUp.length > 0) {
                $scrollUp.click(function(event) {
                    event.preventDefault();
                    $('html,body').animate({scrollTop: '0px'},800);
                });
            }
        }
    };

    YOLO.onReady = {
        init: function () {
            YOLO.common.init();
            YOLO.header.init();
            YOLO.page.init();
            YOLO.blog.init();
            YOLO.woocommerce.init();
            YOLO.footer.init();
        }
    };

    YOLO.onLoad = {
        init: function () {
	        YOLO.header.windowLoad();
	        YOLO.page.windowLoad();
	        YOLO.woocommerce.windowLoad();
        }
    };

    YOLO.onResize = {
        init: function () {
            YOLO.page.windowResized();
            YOLO.woocommerce.windowResized();
            YOLO.header.windowResized();
            YOLO.blog.windowResized();
        }
    };

	YOLO.onScroll = {
		init: function () {

		}
	};

    $(window).resize(YOLO.onResize.init);
	$(window).scroll(YOLO.onScroll.init);
    $(document).ready(YOLO.onReady.init);
    $(window).load(YOLO.onLoad.init);
})(jQuery);