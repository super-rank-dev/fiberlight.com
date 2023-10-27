jQuery(document).ready(function(){
	"use strict";
	//start new-update-for-codecanyon
	jQuery('#qcld_messengerchatbot_enter_license_or_purchase_key').on('focusout', function(){
		qc_messengerchatbot_set_plugin_license_fields();
	});

	jQuery('#qcld_messengerchatbot_enter_license_or_purchase_key').on('keypress',function (e) {
		  qc_messengerchatbot_set_plugin_license_fields();
	});

	jQuery('#qc-license-form input[type="submit"]').on('click', function(){
		qc_messengerchatbot_set_plugin_license_fields();
		jQuery('#qc-license-form').removeAttr('onsubmit').submit();
	});

	function qc_messengerchatbot_set_plugin_license_fields(){
		var license_input = jQuery('#qcld_messengerchatbot_enter_license_or_purchase_key').val();
		if( /^(\w{8})-((\w{4})-){3}(\w{12})$/.test(license_input) ){
			jQuery('input[name="qcld_messengerchatbot_buy_from_where"]').val('codecanyon');
			jQuery('input[name="qcld_messengerchatbot_enter_envato_key"]').val(license_input);
		}else{
			jQuery('input[name="qcld_messengerchatbot_buy_from_where"]').val('quantumcloud');
			jQuery('input[name="qcld_messengerchatbot_enter_license_key"]').val(license_input);
		}
	}
	//end new-update-for-codecanyon

});