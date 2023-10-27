(function($){
    $( document ).ready(function() {
        var widowH1 = screen.height - 50;
   
        $('.wpbot-saas-live-chat').width( '370px' );
      
        $('#wp-chatbot-chat-container').hide();
        jQuery('body').on('click','.live-chat',function(){

            $('#wp-chatbot-chat-container').toggle();
        })
		
    $(window).resize(function() {
        $('.wpbot-saas-live-chat').height($(window).height() - 130);
    });

    $(window).resize(function() {
        $('.wbcaBody').height($(window).height() - 130);
    });

    $(window).resize(function() {
        $('#wbca_chat_body').height($(window).height() - 193);
    });
    $(window).trigger('resize');		
            
            
        });
    $(document).on('click','.floting_live_chat',function(){
        $( ".floting_live_chat" ).addClass( "floting_live_chat_animation" )
        setTimeout(()=>{ $( ".floting_live_chat" ).removeClass( "floting_live_chat_animation" )
        }, 2000 )
    })
    setTimeout( () =>{
        jQuery("#wbca_chat_footer").on("click", ".wbca_float_right_footer", function () {
          $("#input_wbca_editor").keypress()
        });	
    },5000);
            
})(jQuery)