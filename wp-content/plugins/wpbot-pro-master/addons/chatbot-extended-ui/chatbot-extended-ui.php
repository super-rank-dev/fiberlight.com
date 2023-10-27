<?php

defined('ABSPATH') or die("No direct script access!");
define('qcld_chatbot_eui_root_url', plugin_dir_url(__FILE__));
define('qcld_chatbot_eui_root_path', plugin_dir_path(__FILE__));

add_action('init', 'qcpd_wpeui_dependencies');
function qcpd_wpeui_dependencies(){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	if ( !class_exists('qcld_wb_Chatbot') && !class_exists('QCLD_Woo_Chatbot') && (function_exists('qcwpcs_is_kbxwpbot_active') && qcwpcs_is_kbxwpbot_active() != true) ) {
		add_action('admin_notices', 'qcld_chatbot_eui_require_notice');
	} 
}
function qcld_chatbot_eui_require_notice()
{
?>
	<div id="message" class="error">
		<p>
			<?php echo esc_html('Please install & activate the WPBot pro or WoowBot WooCommerce Chatbot Pro plugin to get the Chatbot Extended UI work properly.') ?>
		</p>
	</div>
<?php
}

//add_action( 'admin_menu', 'qcwp_chatbot_extendedui_menu_fnc' );

function qcwp_chatbot_extendedui_menu_fnc(){

	add_menu_page( 'Bot - Extended UI', 'Bot - Extended UI', 'publish_posts', 'chatbot-extendedui-page', 'qcld_chatbot_extendedui_license_callback', 'dashicons-menu', '9' );
		
}


function qcld_chatbot_extendedui_license_callback(){
	//
		chatextendedui_display_license_section();
	?>
	
	
	<div class="qcld-wpbot-help-section">
            <h1>Welcome to the Chatbot Extended UI Addon! You are awesome, by the way <img draggable="false" class="emoji" alt="ðŸ™‚" src="https://s.w.org/images/core/emoji/11/svg/1f642.svg"></h1>

            <div class="qcld-wpbot-section-block">
                <h2>How to Use?</h2>
                <p>Please go to <b>Chatbot Pro > Settings > Icons & Themes</b> page and select <b>Theme Six</b> or <b>Theme Seven</b> for extended ui and hit Save button. That's all.</p>
            </div>
	</div>
	
	<?php
}

//plugin activate redirect codecanyon

function qc_chatbot_extendedui_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url('admin.php?page=chatbot-extendedui-page') ) );
    }
}
add_action( 'activated_plugin', 'qc_chatbot_extendedui_activation_redirect' );
