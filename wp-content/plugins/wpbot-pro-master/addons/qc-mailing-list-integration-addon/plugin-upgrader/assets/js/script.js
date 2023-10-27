'use strict';
jQuery(document).ready(function(){
	jQuery('.qc-notice-error.is-dismissible .notice-dismiss').on('click', function(){
		var notice_type = jQuery(this).parents('.qc-notice-error.is-dismissible').attr('data-dismiss-type');
		jQuery.ajax({
			url: mailing_list_licensing_admin_ajax.ajax_url,
			data: {
				action: 'mailing_list_licensing_notice_dismiss',
		        nonce: mailing_list_licensing_admin_ajax.nonce,
		        dismiss_notice: notice_type
			},
			success: function(){ }
		})
	});
});