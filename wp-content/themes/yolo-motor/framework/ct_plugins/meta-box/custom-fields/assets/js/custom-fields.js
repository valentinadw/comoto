(function($) {
	'use strict';
	function update_sorter_value($item_ul) {
		var value_enable = '';
		var value_all = '';
		$(' > li > input', $item_ul).each(function() {
			value_all += '||' + $(this).val();
			if ($(this).is( ':checked' )) {
				value_enable += '||' + $(this).val();
			}
		});
		if (value_enable != '') {
			value_enable = value_enable.substring(2);
		}
		if (value_all != '') {
			value_all = value_all.substring(2);
		}
		$('> input[data-enable]', $item_ul.parent()).val(value_enable);
		$('> input[data-sort]', $item_ul.parent()).val(value_all);
	};

	$(".rwmb-sorter-inner > li > input").change(function () {
		update_sorter_value($(this).parent().parent());
	});
	$( ".rwmb-sorter-inner" ).sortable({
		placeholder: "ui-sortable-placeholder",
		update: function( event, ui ) {
			var $item_ul = $(event.target);
			update_sorter_value($item_ul);
		}
	});

	$('.rwmb-button-set label').click(function() {
		var $wrapper = $(this).parent().parent();
		var $parent = $(this).parent();


		var old_val = $('input[type="hidden"]', $wrapper).val();
		var new_val = $(this).attr('data-value');

		if (old_val == new_val) {
			if ($parent.hasClass('allow-clear')) {
				if ($(this).hasClass('selected')) {
					$(this).removeClass('selected');
					var clear_value = '';
					if (typeof ($parent.attr('data-clear-value') != "undefined")) {
						clear_value = $parent.attr('data-clear-value');
					}

					$('input[type="hidden"]', $wrapper).val(clear_value);
					$('input[type="hidden"]', $wrapper).trigger('change');
				}
				else {
					$(this).addClass('selected');
					$('input[type="hidden"]', $wrapper).val(new_val);
					$('input[type="hidden"]', $wrapper).trigger('change');
				}
			}
			return;
		}

		$('input[type="hidden"]', $wrapper).val(new_val);
		$('label', $wrapper).removeClass('selected');
		$(this).addClass('selected');
		$('input[type="hidden"]', $wrapper).trigger('change');
	});

	$('.rwmb-footer').select2();

	$('.rwmb-image-set label').click(function() {
		var $wrapper = $(this).parent().parent();
		var $parent = $(this).parent();

		var old_val = $('input[type="hidden"]', $wrapper).val();
		var new_val = $(this).attr('data-value');

		if (old_val == new_val) {
			if ($parent.hasClass('allow-clear')) {
				if ($(this).hasClass('selected')) {
					$(this).removeClass('selected');
					var clear_value = '';
					if (typeof ($parent.attr('data-clear-value') != "undefined")) {
						clear_value = $parent.attr('data-clear-value');
					}

					$('input[type="hidden"]', $wrapper).val(clear_value);
					$('input[type="hidden"]', $wrapper).trigger('change');
				}
				else {
					$(this).addClass('selected');
					$('input[type="hidden"]', $wrapper).val(new_val);
					$('input[type="hidden"]', $wrapper).trigger('change');
				}
			}
			return;
		}

		$('input[type="hidden"]', $wrapper).val(new_val);
		$('label', $wrapper).removeClass('selected');
		$(this).addClass('selected');
		$('input[type="hidden"]', $wrapper).trigger('change');
	});
})(jQuery);