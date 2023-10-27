<?php


function qcld_wpbotml_activate_au()
{
	$plugin_slug = wpbotml_LICENSING_PLUGIN_SLUG;
	$get_plugin_data = get_wpbotml_licensing_plugin_data();

	$plugin_current_version = $get_plugin_data['Version'];
	$plugin_remote_path =  wpbotml_LICENSING_REMOTE_PATH;
	$license_key = get_wpbotml_licensing_key();
	$buy_from = get_wpbotml_licensing_buy_from();
	//6076-qcldpl-4784-1553173833
	//error_log($buy_from.' buy_from');
	if( $buy_from == 'quantumcloud' ){
		$upgrader_instance = new QCLD_wpbotml_AutoUpdate ( $plugin_current_version, $plugin_remote_path, $plugin_slug, '', $license_key );
	}
}
add_action( 'init', 'qcld_wpbotml_activate_au' );


function qcld_wpbotml_upgrade_completed( $upgrader_object, $options ) {
	// The path to our plugin's main file
	$plugin_slug = wpbotml_LICENSING_PLUGIN_SLUG;
	// If an update has taken place and the updated type is plugins and the plugins element exists
	if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
		// Iterate through the plugins being updated and check if ours is there
		foreach( $options['plugins'] as $plugin ) {
			if( $plugin == $plugin_slug ) {
				delete_wpbotml_update_transient();
				delete_wpbotml_renew_transient();
			}
		}
	}
}
add_action( 'upgrader_process_complete', 'qcld_wpbotml_upgrade_completed', 10, 2 );

add_action('admin_enqueue_scripts', 'qcld_wpbotml_licensing_scripts');

function qcld_wpbotml_licensing_scripts(){
	wp_enqueue_style('qcld_wpbotml_licensing_style', plugin_dir_url( __FILE__ ).'/assets/css/style.css');

	//start new-update-for-codecanyon
	wp_enqueue_script('qcld_wpbotml_licensing_script', plugin_dir_url( __FILE__ ).'/assets/js/script.js', array('jquery'), false, true );

	wp_localize_script( 'qcld_wpbotml_licensing_script', 'wpbotml_licensing_admin_ajax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ), 
			'nonce' => wp_create_nonce( "wpbotml_licensing_admin_nonce" )
		)
	);
	//end new-update-for-codecanyon
}