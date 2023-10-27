jQuery(document).ready(function($){
    jQuery('#wpbotml_languages').select2();
    

    jQuery(document).on( 'click', '.sld_click_handle', function( e ) {
        e.preventDefault();
        var obj = $(this);
        $('.sld_click_handle').each(function(){
            if ( $(this).hasClass('nav-tab-active') ) {
                $(this).removeClass( 'nav-tab-active' );
                $( $(this).attr('href') ).hide();
            }
        })
        obj.addClass( 'nav-tab-active' );
        var id = obj.attr('href');
        $( id ).show();
    } )
})
