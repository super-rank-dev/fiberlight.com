jQuery(function ($) {
	"use strict";
    //Add to cart tracker
    $(document).on('click','.add_to_cart_button , '+con_tracker_obj.cart_selector,function (e) {
        var action_reference=0;
        if($(this).is('#woo-chatbot-add-cart-button')){
            action_reference=1;
        }else{
            action_reference=5;
        }
        con_tracker_insert(1,action_reference);

    });
    //Go to checkout tracker
    $(document).on('click','.checkout-button, '+con_tracker_obj.checkout_selector , function (e) {
        var action_reference=0;
        if($(this).is('.woo-chatbot-checkout-link')){
            action_reference=1;
        }else{
            action_reference=5;
        }
        con_tracker_insert(2,action_reference);

    });

    function con_tracker_insert(action_for,action_reference) {
        var data = {
            'action': 'qcld_con_tracker_insert',
            'action_for': action_for,
            'action_reference': action_reference,
        };
        $.ajax({
            type: "POST",
            url: con_tracker_obj.ajax_url,
            data: data,
        })
    }
});