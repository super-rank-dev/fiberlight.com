'use strict';
jQuery(document).ready(function(){
	var api_key = jQuery('#qc_mailing_list_mailchimp_api_key').val();
	var selected_list_id = qcld_mailing_list_mailchimp_admin_ajax_object.selected_list_id;
	
	jQuery('#qcwbmc_subscription_mailchimp_authenticate').on('click', function(e){
		e.preventDefault();
		var api_key = jQuery('#qc_mailing_list_mailchimp_api_key').val();
		var post_id = qcld_mailing_list_mailchimp_admin_ajax_object.post_id;
		jQuery.ajax({
			url: qcld_mailing_list_mailchimp_admin_ajax_object.ajax_url,
			type: 'POST',
			data: {
				action: 'qcwbmc_subscription_mailchimp_get_lists',
				api_key: api_key,
				post_id: post_id,
				ajax_nonce: qcld_mailing_list_mailchimp_admin_ajax_object.mailchimp_ajax_nonce,
			},
			beforeSend: function(xhr){
				jQuery('body').after('<div class="qcwbes_spinner_bg"></div>');
				jQuery('#wpbody-content .wrap').before('<div class="qcwbes_spinner spinner qcwbes_visible"></div>');
			},
			success: function(result){
				var list_return_text = '';
					console.log(result);
				if( !result.lists ){
					alert('It seems that no Lists found for this API Key');
				}else{
					if( result.lists.length > 0){
						list_return_text += '<div class="qcwbes_left"><label for="qcwbmc_subscription_lists_select">Select a List :</label></div>';
						list_return_text += '<div class="qcwbes_right"><select id="qcwbmc_subscription_lists_select" name="qc_mailing_list_mailchimp_list_id">';
						for( var i=0; i < result.lists.length; i++ ){
							var current_list = result.lists[i];
							if( selected_list_id == current_list.id ){
								list_return_text += '<option value="'+current_list.id+'" selected="true">'+current_list.name+'</option>';	
							}else{
								list_return_text += '<option value="'+current_list.id+'">'+current_list.name+'</option>';
							}
						}
						list_return_text += '</select></div>';
						jQuery('#qc_mailing_list_mailchimp_api_key').addClass('qcwbmc_disable').attr('readonly', 'readonly');
					}else{
						alert('It seems that no Lists found for this API Key');
					}
				}

				jQuery('.qcwbmc_subscription_ajax_lists_result').empty().html(list_return_text);
			},
			error: function(xhr,status,error){
				alert('There is a HTTP Error to retrieve Lists from Mailchimp');
			},
			complete: function(xhr,status){
				jQuery('.qcwbes_spinner_bg').remove();
				jQuery('.qcwbes_spinner').remove();
			}
		});
	});

	jQuery('#qcwbmc_subscription_mailchimp_unauthenticate').on('click', function(e){
		e.preventDefault();
		jQuery('#qc_mailing_list_mailchimp_api_key').removeClass('qcwbmc_disable').removeAttr('readonly').val('');
		jQuery('.qcwbmc_subscription_ajax_lists_result').empty();

	});

	if(api_key){
		jQuery(document).find('#qcwbmc_subscription_mailchimp_authenticate').trigger('click');
	}
});

