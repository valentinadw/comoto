(function ( $ ) {
	'use strict';
	function p(){
		if ( $('#yolo-purchase-code').length > 0 ) {
			$('#yolo-purchase-code').submit(function(event) {
				event.preventDefault();
				
				var form_purchase_code = $(this),
					data_purchase_code = form_purchase_code.serializeArray();
					data_purchase_code.push(
						{
							'name': 'action',
							'value': 'yolo_check_purchase_code'	
						}
					);
				
				$.ajax({
					url: Yolo_Theme_Option.ajax_url,
					type: 'POST',
					dataType: 'html',
					data: data_purchase_code,
					beforeSend: function() {
						$('#yolo-active-code').append('<span class="dashicons dashicons-update yolo-spin-icon"></span>');
					},
					success: function( res_purchase_code ) {
						res_purchase_code = $.parseJSON( res_purchase_code );
						
						$('#yolo-active-code').find('.dashicons-update').remove();

						if ( res_purchase_code.status === 'success' ) {
							$('body').append('<div class="yolo-notice-fixed success">' + res_purchase_code.message + '</div>');
                            location.reload();
						} else {
							$('body').append('<div class="yolo-notice-fixed warning">' + res_purchase_code.message + '</div>');
                            location.reload();
						}

						setTimeout(function(){
							$('body').find('.yolo-notice-fixed').remove();
						}, 5000);

					}
				})

			});

		}
	}

	function e() {
        var i = $("#tabs-container .yolo-nav"),
            k = $("#tabs-container .tab-pane"),
            h = $(".trigger-tab"),
            j = window.location.hash;
        i.click(function(l) {
            l.preventDefault();
            $(this).addClass("active").siblings().removeClass("active");
            k.removeClass("active").filter($(l.target).attr("href")).addClass("active");
            history.pushState({}, "", $(l.target).attr("href"))
        });
        h.on("click", function(l) {
            l.preventDefault();
            i.filter('[href="' + $(l.target).attr("href") + '"]').trigger("click")
        });
        if (j) {
            i.removeClass("active").filter('[href="' + j + '"]').addClass("active");
            k.removeClass("active").filter(j).addClass("active")
        } else {
            i.eq(0).addClass("active").siblings().removeClass("active");
            k.removeClass("active").filter(i.eq(0).attr("href")).addClass("active")
        }
    }

    function b() {
    	alert('111');
        var h;
        $("#plugin").on("click", ".install-plugin, .uninstall-plugin", function(j) {
            j.preventDefault();
            if ($(this).attr("disabled")) {
                return
            }
            var l = $(this).hasClass("install-plugin") ? "install" : "uninstall";
            var i = $.trim($(this).prev().text().replace(/[\s\t\r\n]{2,99}/g, " "));
            if (confirm(Yolo_Theme_Option["confirm_" + l + "_plugin"].replace("%PLUGIN%", i))) {
                $(this).hide().after('<span class="spinner is-active"></span>');
                var k = $.proxy(function() {
                    if ("install" == l) {
                        switch (h) {
                            case "js_composer":
                                return setTimeout(k, 1000);
                                break
                        }
                        h = $(this).attr("data-plugin")
                    }
                    $.ajax({
                        context: this,
                        url: Yolo_Theme_Option[l + "_plugin_url"],
                        type: "POST",
                        dataType: "json",
                        data: {
                            plugin: $(this).attr("data-plugin"),
                            nonce: Yolo_Theme_Option[l + "_plugin_nonce"]
                        },
                        complete: function(m) {
                        	console.log(m);
                            if (!m.responseJSON && (m.responseJSON = m.responseText.match(/\{"success":.+\}/))) {
                                m.responseJSON = $.parseJSON(m.responseJSON[0])
                            }
                            if (!m.responseJSON || !m.responseJSON.success) {
                                if (m.responseJSON && m.responseJSON.data) {
                                    alert(m.responseJSON.data)
                                } else {
                                    alert(m.responseText ? m.responseText : Yolo_Theme_Option.unknown_error)
                                }
                                "install" == l && (h = null)
                            } else {
                                $(this).removeClass(l + "-plugin").addClass((l == "install" ? "uninstall" : "install") + "-plugin");
                                $(this).text(Yolo_Theme_Option[l == "install" ? "uninstall" : "install"]);
                                if ("install" == l) {
                                    switch (h) {
                                        case "js_composer":
                                            $.ajax({
                                                url: Yolo_Theme_Option.ajax_url.replace("admin-ajax.php", "index.php"),
                                                complete: function() {
                                                    h = null
                                                }
                                            });
                                            break;
                                        default:
                                            h = null;
                                            break
                                    }
                                }
                            }
                            $(this).show().next().remove()
                        }
                    })
                }, this);
                k()
            }
        })
    }
	jQuery(document).ready(function($) {
		p();
		e();
		// b();
	});
})( jQuery );