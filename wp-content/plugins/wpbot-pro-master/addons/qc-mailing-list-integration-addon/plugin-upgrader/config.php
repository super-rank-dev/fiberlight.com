<?php
define('mailing_list_LICENSING_PLUGIN_SLUG', 'qc-mailing-list-integration-addon/qc-mailing-list-integration-addon.php');
define('mailing_list_LICENSING_PLUGIN_NAME', 'qc-mailing-list-integration-addon');
define('mailing_list_LICENSING__DIR', plugin_dir_path(__DIR__));

define('mailing_list_LICENSING_REMOTE_PATH', 'https://www.ultrawebmedia.com/li/plugins/qc-mailing-list-integration-addon/update.php');
define('mailing_list_LICENSING_PRODUCT_DEV_URL', 'https://quantumcloud.com/products/');

define('mailing_list_ENVATO_PLUGIN_ID', -1);


function get_mailing_list_licensing_plugin_data(){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	return get_plugin_data(mailing_list_LICENSING__DIR.'/qc-mailing-list-integration-addon.php', false);
}

//License Options
function get_mailing_list_licensing_key(){
	return get_option('qcld_mailing_list_enter_license_key');
}

function get_mailing_list_envato_key(){
	return get_option('qcld_mailing_list_enter_envato_key');
}

function get_mailing_list_licensing_buy_from(){
	return get_option('qcld_mailing_list_buy_from_where');
}


//Update Transients
function get_mailing_list_update_transient(){
	return get_transient('qcld_update_mailing_list');
}

function set_mailing_list_update_transient($plugin_object){
	return set_transient( 'qcld_update_mailing_list', serialize($plugin_object), 1 * DAY_IN_SECONDS  );
}

function delete_mailing_list_update_transient(){
	return delete_transient( 'qcld_update_mailing_list' );
}


//Renewal Transients
function get_mailing_list_renew_transient(){
	return get_transient('qcld_renew_mailing_list_subscription');
}

function set_mailing_list_renew_transient($plugin_object){
	return set_transient( 'qcld_renew_mailing_list_subscription', serialize($plugin_object), 1 * DAY_IN_SECONDS  );
}

function delete_mailing_list_renew_transient(){
	return delete_transient( 'qcld_renew_mailing_list_subscription' );
}


//Invalid License Options
function get_mailing_list_invalid_license(){
	return get_option('mailing_list_invalid_license');
}

function set_mailing_list_invalid_license(){
	return update_option('mailing_list_invalid_license', 1);
}

function delete_mailing_list_invalid_license(){
	return delete_option('mailing_list_invalid_license');
}
function mailing_list_get_licensing_url(){
	return admin_url('admin.php?page=qc-mailing-list-help-license');
}

//Valid License
function get_mailing_list_valid_license(){
	return get_option('mailing_list_valid_license');
}
function set_mailing_list_valid_license(){
	return update_option('mailing_list_valid_license', 1);
}
function delete_mailing_list_valid_license(){
	return delete_option('mailing_list_valid_license');
}

//staging or live 
function get_mailing_list_site_type(){
	return get_option('qcld_mailing_list_site_type');
}



//start new-update-for-codecanyon
function get_mailing_list_license_purchase_code(){
	return get_option('qcld_mailing_list_enter_license_or_purchase_key');
}

function get_mailing_list_enter_license_notice_dismiss_transient(){
	return get_transient('get_mailing_list_enter_license_notice_dismiss_transient');
}

function set_mailing_list_enter_license_notice_dismiss_transient(){
	return set_transient('get_mailing_list_enter_license_notice_dismiss_transient', 1, DAY_IN_SECONDS);
}

function get_mailing_list_invalid_license_notice_dismiss_transient(){
	return get_transient('get_mailing_list_invalid_license_notice_dismiss_transient');
}

function set_mailing_list_invalid_license_notice_dismiss_transient(){
	return set_transient('get_mailing_list_invalid_license_notice_dismiss_transient', 1, DAY_IN_SECONDS);
}
//end new-update-for-codecanyon