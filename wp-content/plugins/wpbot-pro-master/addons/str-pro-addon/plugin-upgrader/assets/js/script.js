jQuery(document).ready(function(){
	jQuery('.qc-notice-error.is-dismissible .notice-dismiss').on('click', function(){
		var notice_type = jQuery(this).parents('.qc-notice-error.is-dismissible').attr('data-dismiss-type');
		console.log(notice_type);
		jQuery.ajax({
			url: str_licensing_admin_ajax.ajax_url,
			data: {
				action: 'str_licensing_notice_dismiss',
		        nonce: str_licensing_admin_ajax.nonce,
		        dismiss_notice: notice_type
			},
			success: function(){ }
		})
	});
});