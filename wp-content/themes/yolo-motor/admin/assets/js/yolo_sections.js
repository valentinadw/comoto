(function($){
    $(document).ready(function(){
        var yolo_html_section = '';
        yolo_html_section  = '<div id="yolo-theme-sections" class="popup-overlay" style="display: none;">';
        yolo_html_section +=    '<div class="popup">';
        yolo_html_section +=        '<div class="popup-head">';
        yolo_html_section +=            '<h3 class="poptit">Install Graphsign Theme Sections</h3>';
        yolo_html_section +=            '<a class="alignright btn btn_normal popclose" href="#">';
        yolo_html_section +=                '<i class="fa fa-times"></i> Close';
        yolo_html_section +=            '</a>';
        yolo_html_section +=        '</div>';
        yolo_html_section +=        '<div class="yolo-loading">';
        yolo_html_section +=            '<i class="fa fa-spinner fa-spin"></i><p class="text-loading">Loading sections from server</p>';
        yolo_html_section +=        '</div>';
        yolo_html_section +=        '<select class="yolo-selection"></select>';
        yolo_html_section +=        '<div class="popup-body scroll">';
        yolo_html_section +=            '<div id="sectionsStore">';
        yolo_html_section +=            '</div>';
        yolo_html_section +=        '</div>';
        yolo_html_section +=    '</div>';
        yolo_html_section += '</div>';

        $('.vc_welcome-visible-ne').append('<a href="#" id="yolo-button-sections" title="Click to install sections of theme"></a>');
        $('body').append( yolo_html_section );
        $('#yolo-theme-sections .popclose').click(function(e){
            $('#yolo-theme-sections').animate({opacity:0},function(){
                $('#yolo-theme-sections').css({display:'none'});
            });
            e.preventDefault();
        });
        $('#yolo-theme-sections').click(function(e){
            if( e.target ){
                if( e.target.id == 'yolo-theme-sections' ){
                    $('#yolo-theme-sections .popclose').click();
                }
            }
        });

        $('#yolo-button-sections').click(function(e){
            $('#yolo-theme-sections').css({display:'block', opacity: 0}).animate({opacity:1});
            if( $('#yolo-theme-sections').data('sections-loaded') != true ){
                $('#yolo-theme-sections').attr('data-sections-loaded', 'true');
                $('#yolo-theme-sections .popup .yolo-loading').fadeIn();
                sections.loadFromServer();
            }
        });
    });

})(jQuery);

var sections = {

    loadFromServer : function( group_id ){
        group_id = group_id != undefined ? group_id : 'yolo_h1';

        jQuery.post( ajaxurl, {
            'action': 'yolo_ajax_get_sections',
            'group_id': group_id
        }, function (result) {
            var $ = jQuery;

            $('.yolo-selection').show();
            var result_decode = $.parseJSON( result );
            $('.yolo-selection').append(result_decode.yolo_sections);
            if( group_id == 'yolo_h1' ){
                $('#yolo-theme-sections .popup .yolo-loading').fadeOut();
                $('#yolo-theme-sections .popup-body #sectionsStore').html( result_decode.yolo_contents );
            }else{
                $('#sectionsStore').append( result_decode.yolo_contents );
            }
            $('#sectionsStore .installSection').unbind('click').bind( 'click', function(){
                this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Installing ';
                this.disabled = true;
                $(this).addClass('installing');

                var rel = $(this).attr('rel');

                jQuery.post( ajaxurl, {
                    'action': 'yolo_ajax_get_sections',
                    'install': rel
                }, function (result) {
                    sections.install( result );
                });

            });

            $('.yolo-selection').change(function(){
                $('.sc-layout').fadeOut();
                if ( $('#sectionsStore .sc-layout').hasClass( $(this).val() ) ) {
                    $('.sc-layout' + '.' + $(this).val() ).fadeIn();
                } else {
                    $('#yolo-theme-sections .popup .yolo-loading').fadeIn();
                    jQuery.post( ajaxurl, {
                        'action': 'yolo_ajax_get_sections',
                        'group_id': $(this).val()
                    }, function (result) {
                        $('#yolo-theme-sections .popup .yolo-loading').fadeOut();
                        var content_section = $.parseJSON(result);
                        $('.popup-body #sectionsStore').append(content_section.yolo_contents);

                        $('#sectionsStore .installSection').unbind('click').bind( 'click', function(){
                            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Installing ';
                            this.disabled = true;
                            $(this).addClass('installing');
                            var rel = $(this).attr('rel');
                            jQuery.post( ajaxurl, {
                                'action': 'yolo_ajax_get_sections',
                                'install': rel
                            }, function (result) {
                                sections.install(( result ) );
                            });

                        });
                    });
                }
            });
        });
    },

    install : function( data ){
        var $ = jQuery;
        $('#sectionsStore .installing').each(function(){
            $(this).attr({disabled:false}).html('<i class="fa fa-cloud-download"></i> Install').removeClass('installing');
        });

        var scrollTop = jQuery('body').scrollTop();

        /* Re init VC with new data added */
        vc.storage.setContent( vc.storage.getContent() + data.trim() );
        vc.storage.checksum = false;
        vc.app.show();
        /* End of re-init */

        $('#yolo-theme-sections').hide();

        setTimeout(function(){
            jQuery('body').animate({ scrollTop : (scrollTop+150)});
        }, 800);

    }
}
