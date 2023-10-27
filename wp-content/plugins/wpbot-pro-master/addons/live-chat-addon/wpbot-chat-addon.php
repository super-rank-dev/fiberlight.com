<?php
// if(session_id() == '') {
// 	@session_start();
// }
if ( !session_id() && !headers_sent()) {
	session_start([
		'read_and_close'	=>	true,
	]);
} 

if( !defined('WBCA_PATH') )
	define( 'WBCA_PATH', plugin_dir_path(__FILE__) );
if( !defined('WBCA_URL') )
	define( 'WBCA_URL', plugin_dir_url(__FILE__ ) );
	
define( 'WBCA_VERSION', '3.1.0' );

//with trailing slash
if( !defined('WBCA') )
	define( 'WBCA', 'wbca' );
add_action( 'wp_footer', 'wbca_sound_function');
add_action( 'admin_footer', 'wbca_sound_function');
add_filter( 'login_redirect', 'wbca_login_redirect', 10, 3 );
require_once 'ajax/class-wbca-ajax.php';
require_once 'ajax/class-wbca-admin-ajax.php';
require_once 'controllers/class-wbca-database-manager.php';
require_once 'admin/class-wbca-options.php';
//require('plugin-upgrader/plugin-upgrader.php');

class wbca_Apps {
	
	 public function __construct() {
		 add_action( 'init', array( $this, 'load_wbca_admin') );
		 add_role( 'livechatuser', __( 'Live Chat User' ), array( ) );
    }
	
    public function initialize_controllers() {

        require_once 'controllers/class-wbca-activation-controller.php';
        $activation_controller = new wbca_Activation_Controller();
        $activation_controller->initialize_activation_hooks();
		//$activation_controller->execute_activation_hooks();
		
		require_once 'controllers/class-wbca-schedule-controller.php';
        $schedule_controller = new wbca_Schedule_Controller();
    }

    public function initialize_app_controllers() {
		
		require_once 'controllers/class-wbca-script-controller.php';
        $script_controller = new wbca_Script_Controller();
        $script_controller->enque_scripts();

        $ajax = new wbca_Ajax();
        $ajax->initialize();
		
		$admin = new wbca_Admin_Ajax();
        $admin->initialize();

    }
	
	public function load_wbca_admin(){
		require_once 'controllers/class-admin-area-controller.php';
		$admin_init = new wbca_Admin_Area_Controller();
	}
	

}
function livechat_delete_user( $user_id ) {
    global $wpdb;
	$prefix = $wpdb->prefix;
		$sql = "DELETE FROM {$prefix}wbca_message WHERE (user_sender = $user_id) OR (user_receiver = $user_id)";
		$wpdb->query($sql);
		$sql = "DELETE FROM {$prefix}wbca_user_personal_info WHERE USER_ID = $user_id";
		$wpdb->query($sql);
 
}
add_action( 'delete_user', 'livechat_delete_user' );
$wbca_app = new wbca_Apps();
$wbca_app->initialize_controllers();

function wbca_load_wbca(){
	$wbca_init = new wbca_Apps();
	$wbca_init->initialize_app_controllers();
}

add_action('init', 'wbca_load_wbca');

function wbca_sound_function() {
	global $current_screen;
	if(is_admin()){
		if($current_screen->base == "toplevel_page_wbca-chat-page"){
			$sound = '';
			$sound .= '<audio id="wbca_alert" autoplay="">';
			$sound .= '<source src="' . plugins_url() . '/live-chat-addon/images/alert.ogg" type="audio/ogg">';
			$sound .= '<source src="' . plugins_url() . '/live-chat-addon/images/alert.mp3" type="audio/mpeg">';
			$sound .= '</audio>';
			echo $sound;
		 }
	}
}

function wbca_login_redirect( $redirect_to, $request, $user ) {
	
	//is there a user to check?
	global $user;
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'operator', $user->roles ) ) {
			// redirect them to the default place
			return admin_url().'admin.php?page=wbca-chat-page';
			
		} else if( in_array( 'subscriber', $user->roles ) ) {
			return home_url();
		}else if(in_array( 'administrator', $user->roles )){
			return admin_url();
		}else if(in_array( 'editor', $user->roles )){
			return admin_url();
		}else{
			return $redirect_to;
		}
	} else {
		return $redirect_to;
	}	
}

//add_action('init', 'qcpd_wplivechat_checking_dependencies');
function qcpd_wplivechat_checking_dependencies(){

	
	if ( !class_exists('qcld_wb_Chatbot') && !class_exists('QCLD_Woo_Chatbot') && (qclivechat_is_kbxwpbot_active() != true)) {
		add_action('admin_notices', 'qcpd_wpbot_require_notice');
	}
}



function qcpd_wpbot_require_notice()
{
?>
	<div id="message" class="error">
		<p>
			Please install & activate the WPBot pro or WoowBot pro plugin to get the Livechat Addon to work.
		</p>
	</div>
<?php
}
function qcld_livechat_license_callback(){
	?>
	<div id="licensing">
		<h1>Please Insert your license Key</h1>
		<?php if( get_wplivechat_valid_license() ){ ?>
			<div class="qcld-success-notice">
				<p>Thank you, Your License is active</p>
			</div>
		<?php } ?>
		
		<?php
		
			
			$total_active_domain = 0;
                $active_domain_lists = array();
                $track_domain_request = wp_remote_get(wplivechat_LICENSING_PRODUCT_DEV_URL."wp-json/qc-domain-tracker/v1/getdomain/?license_key=".get_wplivechat_licensing_key(), array('timeout' => 300));
                if( !is_wp_error( $track_domain_request ) || wp_remote_retrieve_response_code( $track_domain_request ) === 200 ){
                    $track_domain_result = json_decode($track_domain_request['body']);
                    
                    $current_domain_url =  site_url() ;
                    $current_domain = str_replace(
                                            array( 'https://', 'http://', 'www.' ),
                                            array('', '', ''),
                                            $current_domain_url
                                        );

                    if( !empty($track_domain_result) ){
                        $max_domain_num = $track_domain_result[0]->max_domain + 1;
                        $total_domains = json_decode($track_domain_result[0]->domain, true);
                        $total_domains_num = count($total_domains);

                        foreach ($total_domains as $key => $value) {
                            if( !isset($value['status']) || $value['status'] == 'active' ){
                                $total_active_domain++;
                                $active_domain_lists[] = $value['domain_name'];
                            }
                        }

                        if($total_active_domain == $max_domain_num){
                        //if( $max_domain_num < $total_active_domain ){
                            //$first_domain_name = $total_domains[0]['domain_name'];
                            if( !in_array($current_domain, $active_domain_lists) ){
                                set_wplivechat_invalid_license();
                                delete_wplivechat_valid_license();
                    ?>
                                <div class="qcld-error-notice">
                                    <p>You have activated this key for maximum number of sites allowed by your license. Please <a href='https://www.quantumcloud.com/products/'>purchase additional license.</a></p>
                                </div>
                    <?php
                            }
                        }
                    }
                    
                }
		?>
		
		<form onsubmit="return false" id="qc-license-form" method="post" action="options.php">
			<?php
				delete_wplivechat_update_transient();
				delete_wplivechat_renew_transient();
				
				delete_option('_site_transient_update_plugins');
				settings_fields( 'qcld_wplivechat_license' );
				do_settings_sections( 'qcld_wplivechat_license' );

				// if( isset($_POST['submit']) ){
				// 	echo 'qcld_wplivechat_buy_from_where '.$_POST['qcld_wplivechat_buy_from_where'];
				// }
			?>
			<table class="form-table">
				

				<tr id="quantumcloud_portfolio_license_row" style="display: none">
					<th>
						<label for="qcld_wplivechat_enter_license_key">Enter License Key:</label>
					</th>
					<td>
						<input type="<?php echo (get_wplivechat_licensing_key()!=''?'password':'text'); ?>" id="qcld_wplivechat_enter_license_key" name="qcld_wplivechat_enter_license_key" class="regular-text" value="<?php echo get_wplivechat_licensing_key(); ?>">
						<p>You can copy the license key from <a target="_blank" href='https://www.quantumcloud.com/products/account/'>your account</a></p>
					</td>
				</tr>

				<tr id="show_envato_plugin_downloader" style="display: none">
					<th>
						<label for="qcld_wplivechat_enter_envato_key">Enter Purchase Code:</label>
					</th>
					<td colspan="4">
						<input type="<?php echo (get_wplivechat_envato_key()!=''?'password':'text'); ?>" id="qcld_wplivechat_enter_envato_key" name="qcld_wplivechat_enter_envato_key" class="regular-text" value="<?php echo get_wplivechat_envato_key(); ?>">
						<p>You can install the <a target="_blank" href="https://envato.com/market-plugin/">Envato Plugin</a> to stay up to date.</p>
					</td>
				</tr>
				
				<tr>
					<th>
						<label for="qcld_wplivechat_enter_license_or_purchase_key">Enter License Key or Purchase Code:</label>
					</th>
					<td>
						<input type="<?php echo (get_wplivechat_license_purchase_code()!=''?'password':'text'); ?>" id="qcld_wplivechat_enter_license_or_purchase_key" name="qcld_wplivechat_enter_license_or_purchase_key" class="regular-text" value="<?php echo get_wplivechat_license_purchase_code(); ?>" required>
					</td>
				</tr>



			</table>
			<!-- //start new-update-for-codecanyon -->
			<input type="hidden" name="qcld_wplivechat_buy_from_where" value="<?php echo get_wplivechat_licensing_buy_from(); ?>" >
			<!-- //end new-update-for-codecanyon -->
			<?php submit_button(); ?>
		</form>
		<script type="text/javascript">
			jQuery(document).ready(function(){

				//start new-update-for-codecanyon
				jQuery('#qcld_wplivechat_enter_license_or_purchase_key').on('focusout', function(){
					qc_wplivechat_set_plugin_license_fields();
				});

				jQuery('#qcld_wplivechat_enter_license_or_purchase_key').on('keypress',function (e) {
					  qc_wplivechat_set_plugin_license_fields();
				});

				jQuery('#qc-license-form input[type="submit"]').on('click', function(){
					qc_wplivechat_set_plugin_license_fields();
					jQuery('#qc-license-form').removeAttr('onsubmit').submit();
				});

				function qc_wplivechat_set_plugin_license_fields(){
					var license_input = jQuery('#qcld_wplivechat_enter_license_or_purchase_key').val();
					if( /^(\w{8})-((\w{4})-){3}(\w{12})$/.test(license_input) ){
						jQuery('input[name="qcld_wplivechat_buy_from_where"]').val('codecanyon');
						jQuery('input[name="qcld_wplivechat_enter_envato_key"]').val(license_input);
					}else{
						jQuery('input[name="qcld_wplivechat_buy_from_where"]').val('quantumcloud');
						jQuery('input[name="qcld_wplivechat_enter_license_key"]').val(license_input);
					}
				}
				//end new-update-for-codecanyon

			});
		</script>
	</div>
<?php 
}

add_action( 'activated_plugin', 'qc_wplivechat_activation_redirect' );
function qc_wplivechat_activation_redirect($plugin){
	if( $plugin == plugin_basename( __FILE__ ) ) {
		exit( wp_redirect( admin_url( 'admin.php?page=qc-wplive-chat-help-license') ) );
	}
}

add_action( 'admin_menu' , 'qclc_remove_submenu', 20 );
function qclc_remove_submenu(){
	global $menu;
	
	foreach($menu as $key=>$value){
		if($value[2]=='wbca_admin_page'){
			unset($menu[$key]);
		}
	
	}
	return ($menu);
}
add_action( 'admin_menu' , 'qclc_add_submenu', 30 );
function qclc_add_submenu(){
	// $user = wp_get_current_user();
	// if($user->caps["administrator"] == true)
	global $submenu;
	if( isset( $submenu['wbca-chat-page'] ) ){
		foreach($submenu['wbca-chat-page'] as $key=>$value){
			if($value[0]=='Live Chat Options'){
				unset($submenu['wbca-chat-page'][$key]);
				$submenu['wbca-chat-page'][2] = array( 'Live Chat Options', 'publish_posts' , admin_url('admin.php?page=wbca_admin_page') );
				ksort($submenu['wbca-chat-page']);
			}
		}
	}
	return $submenu;
}



function qclivechat_is_woowbot_active(){
	if(class_exists('QCLD_Woo_Chatbot')){
		return true;
	}else{
		return false;
	}
}

function qclivechat_is_wpbot_active(){
	if(class_exists('qcld_wb_Chatbot')){
		return true;
	}else{
		return false;
	}
}

function qclivechat_is_kbxwpbot_active(){
	if ( defined( 'KBX_WP_CHATBOT' ) && (KBX_WP_CHATBOT == '1') ) {
		return true;
	}else{
		return false;
	}
}
//if ( !class_exists('qcld_wb_Chatbot') && !class_exists('QCLD_Woo_Chatbot') && (qclivechat_is_kbxwpbot_active() != true)) {
	function qcld_get_lc_language( $key ){
		$data = get_option('wbca_options');
		if( function_exists( 'get_wpbot_locale' ) ){
			$texts = maybe_unserialize(get_option($key));
			if( is_array( $texts ) && isset( $texts[get_wpbot_locale()] )){
				$texts = $texts[get_wpbot_locale()];
			}
			return $texts;
		}else{
			return $data[$key];
		}
		
	}
//}
add_action('wp_footer', 'qcld_livechat_footer_floating_html');

function qcld_livechat_footer_floating_html(){
	if ( !class_exists('qcld_wb_Chatbot') && !class_exists('QCLD_Woo_Chatbot') && (qclivechat_is_kbxwpbot_active() != true)) {
		$bot_enable = false;
	}else{
		$bot_enable = true;
	}
	$position_bottom = !empty(get_option('position_bottom')) ? get_option('position_bottom') : 50;
	$position_right = !empty(get_option('position_right')) ? get_option('position_right') : 50;
	if(($bot_enable == false) && (get_option('enable_floating') == 'true' )){
		global $post;
		$po_wbca_right = ( + 80);
		echo '<style>.live-chat{position: fixed;width:65px;right:'.$position_right.'px;bottom:'.$position_bottom.'px }.live-chat img{border-radius:50%;}
		.wpbot-saas-live-chat{position: fixed;right:'.$position_right.'px;bottom:'.$po_wbca_right.'px }</style>
		<div id="wp-chatbot-chat-container" class="floatingbot_delay"><div class="wpbot-saas-live-chat" style="height:715px"></div></div>
		<div class="live-chat floting_live_chat"><img src="'. get_option('wp_chatbot_custom_icon_path') .'"/></div>';
	}
	if(($bot_enable == false) && (get_option('enable_right') == 'true' )){
		global $post;
		$po_wbca_right = ($position_bottom + 80);
		echo '<style>.live-chat{position: fixed;width:15px;right:0px;bottom:25px;position: fixed;height: 225px;border-radius: 0;overflow-wrap: break-word;padding: 15px; }.wpbot-saas-live-chat{position: fixed;right:'.$position_right.'px;bottom:'.$po_wbca_right.'px }</style>
		<div id="wp-chatbot-chat-container" class="floatingbot_delay"><div class="wpbot-saas-live-chat" style="height:715px"></div></div>
		<div class="live-chat fr_live_chat">L i v e C h a t</div>';
			
	}
	if(($bot_enable == false) && (get_option('enable_bottom') == 'true' )){
		global $post;
		$po_wbca_right = ($position_bottom + 80);
		echo '<style>.live-chat{position: fixed;width:200px;right:10px;bottom:5px;position: fixed;height: 25px;border-radius: 0;overflow-wrap: break-word;padding: 15px; }.wpbot-saas-live-chat{position: fixed;right:'.$position_right.'px;bottom:100px }</style>
		<div id="wp-chatbot-chat-container" class="floatingbot_delay"><div class="wpbot-saas-live-chat" style="height:715px"></div></div>
		<div class="live-chat fb_live_chat">Live Chat</div>';
		
	}
}
