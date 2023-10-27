<?php

defined('ABSPATH') or die("No direct script access!");
define('QCLD_wLCHATBOT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('QCLD_wLCHATBOT_PLUGIN_DIR', plugin_dir_path(__FILE__));
//require('plugin-upgrader/plugin-upgrader.php');

add_action('init', 'qcpd_wpwl_white_label_dependencies');
function qcpd_wpwl_white_label_dependencies(){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');

	if ( !class_exists('qcld_wb_Chatbot') && !class_exists('QCLD_Woo_Chatbot')) {
		add_action('admin_notices', 'qcpd_wpbot_wl_require_notice');
	}
	
}


function qcpd_wpbot_wl_require_notice()
{
?>
	<div id="message" class="error">
		<p>
			Please install & activate the WPBot pro plugin to get the WPBot Chat Session Addon to work properly.
		</p>
	</div>
<?php
}

register_activation_hook(__FILE__, 'qcld_wb_chatbotwl_sessions_defualt_options');
function qcld_wb_chatbotwl_sessions_defualt_options(){
	global $wpdb;

}

/*
* Messenger settings area
*/
class wbwl_Admin_Area_Controller {
	
	function __construct(){
		add_action( 'admin_menu', array($this,'wbfb_admin_menu') );
		add_action( 'admin_init', array($this, 'wpfb_register_plugin_settings') );
	}

	public function wbfb_admin_menu(){

        if ( current_user_can( 'publish_posts' ) ){
			add_menu_page( 'White Label WPBot', 'White Label WPBot', 'publish_posts', 'whitelabelwpbot', array( $this, 'wbfb_setting_page' ), 'dashicons-info', '9' );
        }

		
    }
	
	public function wpfb_register_plugin_settings(){
		register_setting( 'qc-wpwl-plugin-settings-group', 'wpwl_brand_logo' );
		register_setting( 'qc-wpwl-plugin-settings-group', 'wpwo_brand_logo' );
		register_setting( 'qc-wpwl-plugin-settings-group', 'wpwl_word_wpbot' );
		register_setting( 'qc-wpwl-plugin-settings-group', 'wpwo_word_wpbot' );
		register_setting( 'qc-wpwl-plugin-settings-group', 'wpwl_word_wpbot_pro' );
		register_setting( 'qc-wpwl-plugin-settings-group', 'wpwo_word_wpbot_pro' );

		
	}
	
	public function wbfb_setting_page(){
		wp_enqueue_media();
		wp_register_script('qcld-wp-chatbot-wl', QCLD_wLCHATBOT_PLUGIN_URL . '/js/white-label-image-uploader.js', array('jquery'), true);
        wp_enqueue_script('qcld-wp-chatbot-wl');
		$baseUrl = admin_url('admin.php?page=whitelabelwpbot');
		if(isset($_GET['tab']) && $_GET['tab']!=''){
			$tab = sanitize_text_field($_GET['tab']);
		}else{
			$tab = 'general';
		}
		
		
		?>
	<style>
		.full_content{
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.hide-inmenu{
			background: #f6f7f7;
    		padding: 15px 20px;
		}
		.hide_header{
			color: #e74c3c
		}
		a.btn-hide-inmenu {
			background: #e74c3c;
			color: #fff;
			padding: 12px;
			margin:auto !important;
			justify-content: center;
			text-align:center;
			display: block;
			max-width: 271px;
		}
	</style>
	<div class="full_content">
		<div class="wrap swpm-admin-menu-wrap">
			<h1>White Label WPBot</h1>
		
			<h2 class="nav-tab-wrapper sld_nav_container">
				<a class="nav-tab whitelabel_click_handle <?php echo ($tab=='general'?'nav-tab-active':''); ?>" href="<?php echo esc_url($baseUrl.'&tab=general'); ?>">General Settings</a>
				
			</h2>
			
				<?php if($tab=='general'): ?>
				<div id="general_settings">
				
				<form method="post" action="options.php">
				<br />
				<h1>Setting for WPBot Pro</h1>
				<hr />
				
				<?php settings_fields( 'qc-wpwl-plugin-settings-group' ); ?>
				<?php do_settings_sections( 'qc-wpwl-plugin-settings-group' ); ?>
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Upload Your Brand Logo</th>
							<td>
								<button id="wl_brand_image">Upload Brand Image</button>
								<div class="wl_brand_image_container">
								<?php if(get_option('wpwl_brand_logo')!=''): ?>
									<img class="true_pre_image" src="<?php echo esc_attr(get_option('wpwl_brand_logo')); ?>" style="max-width:200px;display:block;margin-top:10px;" /><button id="wl_remove_image">Remove</button>
								<?php endif; ?>
								</div>
								<input type="hidden" id="wpwl_brand_logo" name="wpwl_brand_logo" size="100" value="<?php echo esc_attr( get_option('wpwl_brand_logo') ); ?>"  />
								<i>Please upload your brand logo with will display in WPBot Control Panel right top corner under The Pro Version text. </i>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Change the word - WPBot</th>
							<td>
								
								<input type="text" id="wpwl_word_wpbot" name="wpwl_word_wpbot" size="100" value="<?php echo esc_attr( (get_option('wpwl_word_wpbot')!=''?get_option('wpwl_word_wpbot'):'WPBot') ); ?>"  />
								<i>Please change the word WPBot.</i>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Change The Menu Text - WPBot Pro</th>
							<td>
								
								<input type="text" id="wpwl_word_wpbot_pro" name="wpwl_word_wpbot_pro" size="100" value="<?php echo esc_attr( (get_option('wpwl_word_wpbot_pro')!=''?get_option('wpwl_word_wpbot_pro'):'WPBot Pro') ); ?>"  />
								<i>Please change the menu text WPBot Pro.</i>
							</td>
						</tr>
						
						
					</table>
					<br />
					<h1>Setting for WoowBot Pro</h1>
					<hr />
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Upload Your Brand Logo</th>
							<td>
								<button id="wo_brand_image">Upload Brand Image</button>
								<div class="wo_brand_image_container">
								<?php if(get_option('wpwo_brand_logo')!=''): ?>
									<img class="true_pre_image" src="<?php echo esc_attr(get_option('wpwo_brand_logo')); ?>" style="max-width:200px;display:block;margin-top:10px;" /><button id="wo_remove_image">Remove</button>
								<?php endif; ?>
								</div>
								<input type="hidden" id="wpwo_brand_logo" name="wpwo_brand_logo" size="100" value="<?php echo esc_attr( get_option('wpwo_brand_logo') ); ?>"  />
								<i>Please upload your brand logo it will display in WoowBot Control Panel right top corner under The Pro Version text. </i>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Change the word - WoowBot</th>
							<td>
								
								<input type="text" id="wpwo_word_wpbot" name="wpwo_word_wpbot" size="100" value="<?php echo esc_attr( (get_option('wpwo_word_wpbot')!=''?get_option('wpwo_word_wpbot'):'WoowBot') ); ?>"  />
								<i>Please change the word WoowBot.</i>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Change The Menu Text - WoowBot Pro</th>
							<td>
								
								<input type="text" id="wpwo_word_wpbot_pro" name="wpwo_word_wpbot_pro" size="100" value="<?php echo esc_attr( (get_option('wpwo_word_wpbot_pro')!=''?get_option('wpwo_word_wpbot_pro'):'WoowBot Pro') ); ?>"  />
								<i>Please change the menu text WoowBot Pro.</i>
							</td>
						</tr>
						
						
					</table>
					<?php submit_button(); ?>
					</form>
				</div>
			
				<?php endif; ?>
				
				<?php if($tab=='license'): ?>
				<div id="licensing">
					<h1>Please Insert your license Key</h1>
					<?php if( get_whitelabel_valid_license() ){ ?>
						<div class="qcld-success-notice">
							<p>Thank you, Your License is active</p>
						</div>
					<?php } ?>
					
					<?php
					
						$track_domain_request = wp_remote_get(whitelabel_LICENSING_PRODUCT_DEV_URL."wp-json/qc-domain-tracker/v1/getdomain/?license_key=".get_whitelabel_licensing_key());
						if( !is_wp_error( $track_domain_request ) || wp_remote_retrieve_response_code( $track_domain_request ) === 200 ){
							$track_domain_result = json_decode($track_domain_request['body']);
							
							$max_domain_num = $track_domain_result[0]->max_domain + 1;
							$total_domains = @json_decode($track_domain_result[0]->domain, true);
							if(!empty($total_domains)){
							$total_domains_num = count($total_domains);

							if( $max_domain_num <= $total_domains_num){
						?>
								<div class="qcld-error-notice">
									<p>You have activated this key for maximum number of sites allowed by your license. Please <a href='https://www.quantumcloud.com/products/'>purchase additional license.</a></p>
								</div>
						<?php
							}
							}
							
						}
					?>
					
					<form onsubmit="return false" id="qc-license-form" method="post" action="options.php">
						<?php
							delete_whitelabel_update_transient();
							delete_whitelabel_renew_transient();
							
							delete_option('_site_transient_update_plugins');
							settings_fields( 'qcld_whitelabel_license' );
							do_settings_sections( 'qcld_whitelabel_license' );

							// if( isset($_POST['submit']) ){
							// 	echo 'qcld_whitelabel_buy_from_where '.$_POST['qcld_whitelabel_buy_from_where'];
							// }
						?>
						<table class="form-table">
							

							<tr id="quantumcloud_portfolio_license_row" style="display: none">
								<th>
									<label for="qcld_whitelabel_enter_license_key">Enter License Key:</label>
								</th>
								<td>
									<input type="<?php echo (get_whitelabel_licensing_key()!=''?'password':'text'); ?>" id="qcld_whitelabel_enter_license_key" name="qcld_whitelabel_enter_license_key" class="regular-text" value="<?php echo get_whitelabel_licensing_key(); ?>">
									<p>You can copy the license key from <a target="_blank" href='https://www.quantumcloud.com/products/account/'>your account</a></p>
								</td>
							</tr>

							<tr id="show_envato_plugin_downloader" style="display: none">
								<th>
									<label for="qcld_whitelabel_enter_envato_key">Enter Purchase Code:</label>
								</th>
								<td colspan="4">
									<input type="<?php echo (get_whitelabel_envato_key()!=''?'password':'text'); ?>" id="qcld_whitelabel_enter_envato_key" name="qcld_whitelabel_enter_envato_key" class="regular-text" value="<?php echo get_whitelabel_envato_key(); ?>">
									<p>You can install the <a target="_blank" href="https://envato.com/market-plugin/">Envato Plugin</a> to stay up to date.</p>
								</td>
							</tr>
							
							<tr>
								<th>
									<label for="qcld_whitelabel_enter_license_or_purchase_key">Enter License Key or Purchase Code:</label>
								</th>
								<td>
									<input type="<?php echo (get_whitelabel_license_purchase_code()!=''?'password':'text'); ?>" id="qcld_whitelabel_enter_license_or_purchase_key" name="qcld_whitelabel_enter_license_or_purchase_key" class="regular-text" value="<?php echo get_whitelabel_license_purchase_code(); ?>" required>
								</td>
							</tr>

						</table>
						<!-- //start new-update-for-codecanyon -->
						<input type="hidden" name="qcld_whitelabel_buy_from_where" value="<?php echo get_whitelabel_licensing_buy_from(); ?>" >
						<!-- //end new-update-for-codecanyon -->
						<?php submit_button(); ?>
					</form>
					<script type="text/javascript">
						jQuery(document).ready(function(){

							//start new-update-for-codecanyon
							jQuery('#qcld_whitelabel_enter_license_or_purchase_key').on('focusout', function(){
								qc_whitelabel_set_plugin_license_fields();
							});

							jQuery('#qcld_whitelabel_enter_license_or_purchase_key').on('keypress',function (e) {
								qc_whitelabel_set_plugin_license_fields();
							});

							jQuery('#qc-license-form input[type="submit"]').on('click', function(){
								qc_whitelabel_set_plugin_license_fields();
								jQuery('#qc-license-form').removeAttr('onsubmit').submit();
							});

							function qc_whitelabel_set_plugin_license_fields(){
								var license_input = jQuery('#qcld_whitelabel_enter_license_or_purchase_key').val();
								if( /^(\w{8})-((\w{4})-){3}(\w{12})$/.test(license_input) ){
									jQuery('input[name="qcld_whitelabel_buy_from_where"]').val('codecanyon');
									jQuery('input[name="qcld_whitelabel_enter_envato_key"]').val(license_input);
								}else{
									jQuery('input[name="qcld_whitelabel_buy_from_where"]').val('quantumcloud');
									jQuery('input[name="qcld_whitelabel_enter_license_key"]').val(license_input);
								}
							}
							//end new-update-for-codecanyon

						});
					</script>
				</div>
				<?php endif; ?>
		</div>
		<div class="hide-inmenu">
				<h3>You can access the White Label Menu anytime following this URL:</h3>
				<h3> The url is: <?php echo get_home_url() .'/wp-admin/admin.php?page=whitelabelwpbot';?></h3>
				<h3 class="hide_header">Please save this URL and Press the button below to Hide this from the WordPress menu.</h3>	
				<form method="post" action="options.php">
				<?php 
					if (get_option('wpwl_hide_frommenu') =='show'){
						$hide_status = 'hide';
					}else{
						$hide_status = 'show';
					}
				 ?>
					<a class="btn-hide-inmenu" value="<?php echo $hide_status; ?>"> Hide from WP Menu</a>
				</form>
		<div>
	</div>

	<?php
	}
	
}

new wbwl_Admin_Area_Controller();
if(get_option('wpwl_hide_frommenu') == 'show'){
	add_action( 'admin_menu' , 'qcwl_remove_submenu', 20 );
	function qcwl_remove_submenu(){
		global $menu;
		foreach($menu as $key=>$value){
			if($value[0]=='White Label WPBot'){
				unset($menu[$key]);
			}
		}
		return ($menu);
	}
}

//plugin activate redirect codecanyon

function qc_whitelabel_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url('admin.php?page=whitelabelwpbot&tab=license') ) );
    }
}
add_action( 'activated_plugin', 'qc_whitelabel_activation_redirect' );
function hide_from_menu_item(){
	$menu_status = sanitize_text_field($_POST['menu_status']);
	update_option('wpwl_hide_frommenu',$menu_status);
	wp_die();
}
add_action('wp_ajax_hide_from_menu_item','hide_from_menu_item');


