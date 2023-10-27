<?php
define('convformbuilder_LICENSING_PLUGIN_SLUG', 'conversational-forms-pro/qcformbuilder-core.php');
define('convformbuilder_LICENSING_PLUGIN_NAME', 'conversational-forms-pro');
define('convformbuilder_LICENSING__DIR', plugin_dir_path(__DIR__));

define('convformbuilder_LICENSING_REMOTE_PATH', 'https://www.ultrawebmedia.com/li/plugins/conversational-form-builder/update.php');
define('convformbuilder_LICENSING_PRODUCT_DEV_URL', 'https://quantumcloud.com/products/');

//start new-update-for-codecanyon
define('convformbuilder_ENVATO_PLUGIN_ID', -1);
//end new-update-for-codecanyon

function get_convformbuilder_licensing_plugin_data(){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	return get_plugin_data(convformbuilder_LICENSING__DIR.'/qcformbuilder-core.php', false);
}

//License Options
function get_convformbuilder_licensing_key(){
	return get_option('qcld_convformbuilder_enter_license_key');
}

function get_convformbuilder_envato_key(){
	return get_option('qcld_convformbuilder_enter_envato_key');
}

function get_convformbuilder_licensing_buy_from(){
	return get_option('qcld_convformbuilder_buy_from_where');
}


//Update Transients
function get_convformbuilder_update_transient(){
	return get_transient('qcld_update_convformbuilder');
}

function set_convformbuilder_update_transient($plugin_object){
	return set_transient( 'qcld_update_convformbuilder', serialize($plugin_object), 1 * DAY_IN_SECONDS  );
}

function delete_convformbuilder_update_transient(){
	return delete_transient( 'qcld_update_convformbuilder' );
}


//Renewal Transients
function get_convformbuilder_renew_transient(){
	return get_transient('qcld_renew_convformbuilder_subscription');
}

function set_convformbuilder_renew_transient($plugin_object){
	return set_transient( 'qcld_renew_convformbuilder_subscription', serialize($plugin_object), 1 * DAY_IN_SECONDS  );
}

function delete_convformbuilder_renew_transient(){
	return delete_transient( 'qcld_renew_convformbuilder_subscription' );
}


//Invalid License Options
function get_convformbuilder_invalid_license(){
	return get_option('convformbuilder_invalid_license');
}

function set_convformbuilder_invalid_license(){
	return update_option('convformbuilder_invalid_license', 1);
}

function delete_convformbuilder_invalid_license(){
	return delete_option('convformbuilder_invalid_license');
}
function convformbuilder_get_licensing_url(){
	return admin_url('admin.php?page=cfb_licensing');
}

//Valid License
function get_convformbuilder_valid_license(){
	return get_option('convformbuilder_valid_license');
}
function set_convformbuilder_valid_license(){
	return update_option('convformbuilder_valid_license', 1);
}
function delete_convformbuilder_valid_license(){
	return delete_option('convformbuilder_valid_license');
}

//staging or live 
function get_convformbuilder_site_type(){
	return get_option('qcld_convformbuilder_site_type');
}



//start new-update-for-codecanyon
function get_convformbuilder_license_purchase_code(){
	return get_option('qcld_convformbuilder_enter_license_or_purchase_key');
}

function get_convformbuilder_enter_license_notice_dismiss_transient(){
	return get_transient('get_convformbuilder_enter_license_notice_dismiss_transient');
}

function set_convformbuilder_enter_license_notice_dismiss_transient(){
	return set_transient('get_convformbuilder_enter_license_notice_dismiss_transient', 1, DAY_IN_SECONDS);
}

function get_convformbuilder_invalid_license_notice_dismiss_transient(){
	return get_transient('get_convformbuilder_invalid_license_notice_dismiss_transient');
}

function set_convformbuilder_invalid_license_notice_dismiss_transient(){
	return set_transient('get_convformbuilder_invalid_license_notice_dismiss_transient', 1, DAY_IN_SECONDS);
}
//end new-update-for-codecanyon