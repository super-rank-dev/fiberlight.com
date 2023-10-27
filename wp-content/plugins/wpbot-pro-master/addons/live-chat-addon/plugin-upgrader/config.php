<?php
define('wplivechat_LICENSING_PLUGIN_SLUG', 'live-chat-addon/wpbot-chat-addon.php');
define('wplivechat_LICENSING_PLUGIN_NAME', 'live-chat-addon');
define('wplivechat_LICENSING__DIR', plugin_dir_path(__DIR__));

define('wplivechat_LICENSING_REMOTE_PATH', 'https://www.ultrawebmedia.com/li/plugins/live-chat-addon/update.php');
define('wplivechat_LICENSING_PRODUCT_DEV_URL', 'https://quantumcloud.com/products/');

//start new-update-for-codecanyon
define('wplivechat_ENVATO_PLUGIN_ID', -1);
//end new-update-for-codecanyon

function get_wplivechat_licensing_plugin_data(){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	return get_plugin_data(wplivechat_LICENSING__DIR.'/wpbot-chat-addon.php', false);
}

//License Options
function get_wplivechat_licensing_key(){
	return get_option('qcld_wplivechat_enter_license_key');
}

function get_wplivechat_envato_key(){
	return get_option('qcld_wplivechat_enter_envato_key');
}

function get_wplivechat_licensing_buy_from(){
	return get_option('qcld_wplivechat_buy_from_where');
}


//Update Transients
function get_wplivechat_update_transient(){
	return get_transient('qcld_update_wplivechat');
}

function set_wplivechat_update_transient($plugin_object){
	return set_transient( 'qcld_update_wplivechat', serialize($plugin_object), 1 * DAY_IN_SECONDS  );
}

function delete_wplivechat_update_transient(){
	return delete_transient( 'qcld_update_wplivechat' );
}


//Renewal Transients
function get_wplivechat_renew_transient(){
	return get_transient('qcld_renew_wplivechat_subscription');
}

function set_wplivechat_renew_transient($plugin_object){
	return set_transient( 'qcld_renew_wplivechat_subscription', serialize($plugin_object), 1 * DAY_IN_SECONDS  );
}

function delete_wplivechat_renew_transient(){
	return delete_transient( 'qcld_renew_wplivechat_subscription' );
}


//Invalid License Options
function get_wplivechat_invalid_license(){
	return get_option('wplivechat_invalid_license');
}

function set_wplivechat_invalid_license(){
	return update_option('wplivechat_invalid_license', 1);
}

function delete_wplivechat_invalid_license(){
	return delete_option('wplivechat_invalid_license');
}
function wplivechat_get_licensing_url(){
	return admin_url('admin.php?page=qc-wplive-chat-help-license');
}

//Valid License
function get_wplivechat_valid_license(){
	return get_option('wplivechat_valid_license');
}
function set_wplivechat_valid_license(){
	return update_option('wplivechat_valid_license', 1);
}
function delete_wplivechat_valid_license(){
	return delete_option('wplivechat_valid_license');
}

//staging or live 
function get_wplivechat_site_type(){
	return get_option('qcld_wplivechat_site_type');
}



//start new-update-for-codecanyon
function get_wplivechat_license_purchase_code(){
	return get_option('qcld_wplivechat_enter_license_or_purchase_key');
}

function get_wplivechat_enter_license_notice_dismiss_transient(){
	return get_transient('get_wplivechat_enter_license_notice_dismiss_transient');
}

function set_wplivechat_enter_license_notice_dismiss_transient(){
	return set_transient('get_wplivechat_enter_license_notice_dismiss_transient', 1, DAY_IN_SECONDS);
}

function get_wplivechat_invalid_license_notice_dismiss_transient(){
	return get_transient('get_wplivechat_invalid_license_notice_dismiss_transient');
}

function set_wplivechat_invalid_license_notice_dismiss_transient(){
	return set_transient('get_wplivechat_invalid_license_notice_dismiss_transient', 1, DAY_IN_SECONDS);
}
//end new-update-for-codecanyon