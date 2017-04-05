/*!
 * Variations Plugin Theme
 */

// ================================================================
// WooCommerce Variation Change
// ================================================================

!(function ($) {
    $('.variations_form .variations ul.variable-items-wrapper').each(function (i, el) {

        var select = $(this).prev('select');
        var li = $(this).find('li');
        $(this).on('click', 'li:not(.selected)', function () {
            var value = $(this).data('value');
            li.removeClass('selected');
            // console.log(value);
            select.val('').trigger('change'); // Add to fix VM15713:1 Uncaught TypeError: Cannot read property 'length' of null
            select.val(value).trigger('change');
            // console.log(select);
            $(this).addClass('selected');
        });

        $(this).on('click', 'li.selected', function () {
            li.removeClass('selected');
            select.val('').trigger('change');
            select.trigger('click');
            select.trigger('focusin');
            select.trigger('touchstart');
        });
    });

    $('.variations_form .variations').each(function (i, el) {
        $(this).on('click', '.reset_variations',function() {
            $('.variations_form .variations').find('li').removeClass('selected');
        });
    });
}(jQuery));