/* global confirm, redux, redux_change */

jQuery(document).ready(function($) {
    if( $('#online_time').length != 0 ) {
        $('#online_time').datetimepicker({
            format:'Y/m/d H:i:s',
            minDate: '0'
        });
    };
});
