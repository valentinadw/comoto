/**
 * Yolo Custom Sidebar
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

jQuery(document).ready(function($) {
    "use strict";
    
    var add_sidebar_form = $('#yolo-form-add-sidebar');
    if( add_sidebar_form.length > 0 ) {
        var add_sidebar_form_new = add_sidebar_form.clone();
        add_sidebar_form.remove();
        jQuery('#widgets-right').append('<div style="clear:both;"></div>');
        add_sidebar_form = jQuery('#widgets-right').append(add_sidebar_form_new);
        
        $('#yolo-add-sidebar').bind('click', function(e) {
            e.preventDefault();
            var sidebar_name = $.trim( $(this).siblings('#sidebar_name').val() );
            if( sidebar_name != '' ){
                $(this).attr('disabled', true);
                var data = {
                    action: 'yolo_add_custom_sidebar',
                    sidebar_name: sidebar_name
                };
                
                $.ajax({
                    type : 'POST',
                    url : ajaxurl,
                    data : data,
                    success : function(response){
                        window.location.reload(true);
                    }
                });
            }
        });
    }
    
    if( $('.sidebar-yolo-custom-sidebar').length > 0 ) {
        var delete_button = '<span class="delete-sidebar fa fa-trash-o"></span>';
        $('.sidebar-yolo-custom-sidebar .sidebar-name').prepend(delete_button);
        
        $('.sidebar-yolo-custom-sidebar .delete-sidebar').bind('click', function() {
            var sidebar_name = $(this).parent().find('h2').text();
            var widget_block = $(this).parents('.widgets-holder-wrap');
            var ok = confirm('Do you want to delete this sidebar?');
            if( ok ) {
                widget_block.hide();
                var data = {
                    action: 'yolo_delete_custom_sidebar',
                    sidebar_name: sidebar_name
                };
                
                $.ajax({
                    type : 'POST',
                    url : ajaxurl,
                    data : data,
                    success : function(response) {
                        if( response != '' ) {
                            widget_block.remove();
                        }
                        else {
                            widget_block.show();
                            alert('Cant delete the sidebar. Please try again');
                        }
                    }
                });
            }
        });
    }
});