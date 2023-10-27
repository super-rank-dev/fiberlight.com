<?php


	add_action('admin_notices', 'qcld_wplivechat_invalid_license_notice');
	function qcld_wplivechat_invalid_license_notice(){
		if( (get_wplivechat_licensing_buy_from() != '') && (get_wplivechat_invalid_license()) ){
			if( (get_wplivechat_licensing_buy_from() == 'quantumcloud') && (get_wplivechat_licensing_key() == '') ){

			}elseif( (get_wplivechat_licensing_buy_from() == 'codecanyon') && (get_wplivechat_envato_key() == '') ){

			}else{
				$class="notice notice-error is-dismissible qc-notice-error";
				$message = "You have Entered an Invalid License Key for Livechat Addon";

				printf( '<div data-dismiss-type="qc-invalid-license" class="%1$s"><a href="'.esc_url('https://www.quantumcloud.com/products/').'" target="_blank"><img src="'.esc_url(WBCA_URL.'plugin-upgrader/images/qc-logo.jpg').'" /></a><p>%2$s</p></div>', esc_attr( $class ), $message ); 
			}
		}
	}


if( !get_wplivechat_enter_license_notice_dismiss_transient() ){
	add_action('admin_notices', 'qcld_wplivechat_license_enter_notice');
	function qcld_wplivechat_license_enter_notice(){
		if( (get_wplivechat_licensing_buy_from() != '') && (get_wplivechat_invalid_license() != 1) ){

		}else{
			$class="notice notice-error is-dismissible qc-notice-error";
			

			$message = "Hi! Please enter the license key to receive automatic updates and premium support. <a href=".wplivechat_get_licensing_url().">Please activate your copy of Livechat Addon.</a>";

			printf( '<div data-dismiss-type="qc-enter-license" class="%1$s"><a href="'.esc_url('https://www.quantumcloud.com/products/').'" target="_blank"><img src="'.esc_url(WBCA_URL.'plugin-upgrader/images/qc-logo.jpg').'" /></a><p>%2$s</p></div>', esc_attr( $class ), $message ); 
		}
	}
}

//start new-update-for-codecanyon
function wplivechat_licensing_notice_dismiss_func(){
	check_ajax_referer('wplivechat_licensing_admin_nonce', 'nonce');

	if( sanitize_text_field($_GET['dismiss_notice']) == 'qc-enter-license' ){
		if( !get_wplivechat_enter_license_notice_dismiss_transient() ){
			set_wplivechat_enter_license_notice_dismiss_transient();
		}
	}

	if( sanitize_text_field($_GET['dismiss_notice']) == 'qc-invalid-license' ){
		if( !get_wplivechat_invalid_license_notice_dismiss_transient() ){
			set_wplivechat_invalid_license_notice_dismiss_transient();
		}
	}

}
add_action('wp_ajax_wplivechat_licensing_notice_dismiss', 'wplivechat_licensing_notice_dismiss_func');
//end new-update-for-codecanyon