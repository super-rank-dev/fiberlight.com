jQuery(document).ready(function(){
	
	jQuery('.qc-notice-error.is-dismissible .notice-dismiss').on('click', function(){
		var notice_type = jQuery(this).parents('.qc-notice-error.is-dismissible').attr('data-dismiss-type');
		console.log(notice_type);
		jQuery.ajax({
			url: wplivechat_licensing_admin_ajax.ajax_url,
			data: {
				action: 'wplivechat_licensing_notice_dismiss',
		        nonce: wplivechat_licensing_admin_ajax.nonce,
		        dismiss_notice: notice_type
			},
			success: function(){ }
		})
	});
});
jQuery(document).ready(function($){
	"use strict";
	$('#wpbot_checked_all').on('click', function(){
		if($(this).is(':checked')){
			$('.wpbot_sessions_checkbox').prop('checked', true);
		}else{
			$('.wpbot_sessions_checkbox').prop('checked', false);
		}
	})
	$('.wbca_history_delete').on('click',function(){
		var wpbot_history_checkbox = $("input[name='wpbot_history_checkbox[]']:checked").map(function () {
			return this.value;
		}).get();
		console.log(wpbot_history_checkbox)
		jQuery.ajax({
            type : "post",
            dataType : "json",
            url: ajaxurl,
            data : {
				action: "wbca_delete_history", 
				delete_history_id: wpbot_history_checkbox
			},
            success: function(response) {
				location.reload();
            }
        });
	})

})