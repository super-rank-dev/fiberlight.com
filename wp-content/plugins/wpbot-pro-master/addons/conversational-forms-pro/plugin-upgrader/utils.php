<?php

function qcld_convformbuilder_activate_au()
{
	$plugin_slug = convformbuilder_LICENSING_PLUGIN_SLUG;
	$get_plugin_data = get_convformbuilder_licensing_plugin_data();

	$plugin_current_version = $get_plugin_data['Version'];
	$plugin_remote_path =  convformbuilder_LICENSING_REMOTE_PATH;
	$license_key = get_convformbuilder_licensing_key();
	$buy_from = get_convformbuilder_licensing_buy_from();
	
	if( $buy_from == 'quantumcloud' ){
		$upgrader_instance = new QCLD_convformbuilder_AutoUpdate ( $plugin_current_version, $plugin_remote_path, $plugin_slug, '', $license_key );
	}
}
add_action( 'init', 'qcld_convformbuilder_activate_au' );


function qcld_convformbuilder_upgrade_completed( $upgrader_object, $options ) {
	// The path to our plugin's main file
	$plugin_slug = convformbuilder_LICENSING_PLUGIN_SLUG;
	// If an update has taken place and the updated type is plugins and the plugins element exists
	if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
		// Iterate through the plugins being updated and check if ours is there
		foreach( $options['plugins'] as $plugin ) {
			if( $plugin == $plugin_slug ) {
				delete_convformbuilder_update_transient();
				delete_convformbuilder_renew_transient();
			}
		}
	}
}
add_action( 'upgrader_process_complete', 'qcld_convformbuilder_upgrade_completed', 10, 2 );

add_action('admin_enqueue_scripts', 'qcld_convformbuilder_licensing_scripts');

function qcld_convformbuilder_licensing_scripts(){
	wp_enqueue_style('qcld_convformbuilder_licensing_style', plugin_dir_url( __FILE__ ).'/assets/css/style.css');

	//start new-update-for-codecanyon
	wp_enqueue_script('qcld_convformbuilder_licensing_script', plugin_dir_url( __FILE__ ).'/assets/js/script.js', array('jquery'), false, true );

	wp_localize_script( 'qcld_convformbuilder_licensing_script', 'convformbuilder_licensing_admin_ajax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ), 
			'nonce' => wp_create_nonce( "convformbuilder_licensing_admin_nonce" )
		)
	);
	//end new-update-for-codecanyon
}