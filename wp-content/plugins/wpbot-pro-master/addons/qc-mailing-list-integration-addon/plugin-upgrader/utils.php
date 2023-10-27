<?php

function qcld_mailing_list_activate_au()
{
	$plugin_slug = mailing_list_LICENSING_PLUGIN_SLUG;
	$get_plugin_data = get_mailing_list_licensing_plugin_data();

	$plugin_current_version = $get_plugin_data['Version'];
	$plugin_remote_path =  mailing_list_LICENSING_REMOTE_PATH;
	$license_key = get_mailing_list_licensing_key();
	$buy_from = get_mailing_list_licensing_buy_from();
	if( $buy_from == 'quantumcloud' ){
		$upgrader_instance = new QCLD_mailing_list_AutoUpdate ( $plugin_current_version, $plugin_remote_path, $plugin_slug, '', $license_key );
	}
}
add_action( 'init', 'qcld_mailing_list_activate_au' );


function qcld_mailing_list_upgrade_completed( $upgrader_object, $options ) {
	// The path to our plugin's main file
	$plugin_slug = mailing_list_LICENSING_PLUGIN_SLUG;
	// If an update has taken place and the updated type is plugins and the plugins element exists
	if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
		// Iterate through the plugins being updated and check if ours is there
		foreach( $options['plugins'] as $plugin ) {
			if( $plugin == $plugin_slug ) {
				delete_mailing_list_update_transient();
				delete_mailing_list_renew_transient();
			}
		}
	}
}
add_action( 'upgrader_process_complete', 'qcld_mailing_list_upgrade_completed', 10, 2 );

add_action('admin_enqueue_scripts', 'qcld_mailing_list_licensing_scripts');

function qcld_mailing_list_licensing_scripts(){
	wp_enqueue_style('qcld_mailing_list_licensing_style', plugin_dir_url( __FILE__ ).'/assets/css/style.css');

	wp_enqueue_script('qcld_mailing_list_licensing_script', plugin_dir_url( __FILE__ ).'/assets/js/script.js', array('jquery'), false, true );

	wp_localize_script( 'qcld_mailing_list_licensing_script', 'mailing_list_licensing_admin_ajax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ), 
			'nonce' => wp_create_nonce( "mailing_list_licensing_admin_nonce" )
		)
	);
}