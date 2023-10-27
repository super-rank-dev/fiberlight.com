'use strict'
jQuery(document).ready(function(){
	jQuery('#qcld_mailing_list_enter_license_or_purchase_key').on('focusout', function(){
		qc_mailing_list_set_plugin_license_fields();
	});

	jQuery('#qcld_mailing_list_enter_license_or_purchase_key').on('keypress',function (e) {
		  qc_mailing_list_set_plugin_license_fields();
	});

	jQuery('#qc-license-form input[type="submit"]').on('click', function(){
		qc_mailing_list_set_plugin_license_fields();
		jQuery('#qc-license-form').removeAttr('onsubmit').submit();
	});

	function qc_mailing_list_set_plugin_license_fields(){
	    var license_input = jQuery('#qcld_mailing_list_enter_license_or_purchase_key').val();
	    if( /^(\w{8})-((\w{4})-){3}(\w{12})$/.test(license_input) ){
	        jQuery('input[name="qcld_mailing_list_buy_from_where"]').val('codecanyon');
	        jQuery('input[name="qcld_mailing_list_enter_envato_key"]').val(license_input);
	    }else{
	        jQuery('input[name="qcld_mailing_list_buy_from_where"]').val('quantumcloud');
	        jQuery('input[name="qcld_mailing_list_enter_license_key"]').val(license_input);
	    }
	}

});