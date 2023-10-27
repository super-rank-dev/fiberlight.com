<?php
define('whitelabel_LICENSING_PLUGIN_SLUG', 'white-label-chatbot-addon/white-label-wpbot.php');
define('whitelabel_LICENSING_PLUGIN_NAME', 'white-label-chatbot-addon');
define('whitelabel_LICENSING__DIR', plugin_dir_path(__DIR__));

define('whitelabel_LICENSING_REMOTE_PATH', 'https://www.ultrawebmedia.com/li/plugins/white-label-chatbot-addon/update.php');
define('whitelabel_LICENSING_PRODUCT_DEV_URL', 'https://quantumcloud.com/products/');

//start new-update-for-codecanyon
define('whitelabel_ENVATO_PLUGIN_ID', -1);
//end new-update-for-codecanyon

function get_whitelabel_licensing_plugin_data(){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	return get_plugin_data(whitelabel_LICENSING__DIR.'/white-label-wpbot.php', false);
}

//License Options
function get_whitelabel_licensing_key(){
	return get_option('qcld_whitelabel_enter_license_key');
}

function get_whitelabel_envato_key(){
	return get_option('qcld_whitelabel_enter_envato_key');
}

function get_whitelabel_licensing_buy_from(){
	return get_option('qcld_whitelabel_buy_from_where');
}


//Update Transients
function get_whitelabel_update_transient(){
	return get_transient('qcld_update_whitelabel');
}

function set_whitelabel_update_transient($plugin_object){
	return set_transient( 'qcld_update_whitelabel', serialize($plugin_object), 1 * DAY_IN_SECONDS  );
}

function delete_whitelabel_update_transient(){
	return delete_transient( 'qcld_update_whitelabel' );
}


//Renewal Transients
function get_whitelabel_renew_transient(){
	return get_transient('qcld_renew_whitelabel_subscription');
}

function set_whitelabel_renew_transient($plugin_object){
	return set_transient( 'qcld_renew_whitelabel_subscription', serialize($plugin_object), 1 * DAY_IN_SECONDS  );
}

function delete_whitelabel_renew_transient(){
	return delete_transient( 'qcld_renew_whitelabel_subscription' );
}


//Invalid License Options
function get_whitelabel_invalid_license(){
	return get_option('whitelabel_invalid_license');
}

function set_whitelabel_invalid_license(){
	return update_option('whitelabel_invalid_license', 1);
}

function delete_whitelabel_invalid_license(){
	return delete_option('whitelabel_invalid_license');
}
function whitelabel_get_licensing_url(){
	return admin_url('admin.php?page=whitelabelwpbot&tab=license');
}

//Valid License
function get_whitelabel_valid_license(){
	return get_option('whitelabel_valid_license');
}
function set_whitelabel_valid_license(){
	return update_option('whitelabel_valid_license', 1);
}
function delete_whitelabel_valid_license(){
	return delete_option('whitelabel_valid_license');
}

//staging or live 
function get_whitelabel_site_type(){
	return get_option('qcld_whitelabel_site_type');
}



//start new-update-for-codecanyon
function get_whitelabel_license_purchase_code(){
	return get_option('qcld_whitelabel_enter_license_or_purchase_key');
}

function get_whitelabel_enter_license_notice_dismiss_transient(){
	return get_transient('get_whitelabel_enter_license_notice_dismiss_transient');
}

function set_whitelabel_enter_license_notice_dismiss_transient(){
	return set_transient('get_whitelabel_enter_license_notice_dismiss_transient', 1, DAY_IN_SECONDS);
}

function get_whitelabel_invalid_license_notice_dismiss_transient(){
	return get_transient('get_whitelabel_invalid_license_notice_dismiss_transient');
}

function set_whitelabel_invalid_license_notice_dismiss_transient(){
	return set_transient('get_whitelabel_invalid_license_notice_dismiss_transient', 1, DAY_IN_SECONDS);
}
//end new-update-for-codecanyon