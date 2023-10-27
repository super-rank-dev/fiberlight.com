<?php
define('wpbotvoicemessage_LICENSING_PLUGIN_SLUG', 'voice-message-addon/wpbotvoicemessage.php');
define('wpbotvoicemessage_LICENSING_PLUGIN_NAME', 'wpbotvoicemessage');
define('wpbotvoicemessage_LICENSING__DIR', plugin_dir_path(__DIR__));
define('wpbotvoicemessage_LICENSING__URL', plugin_dir_url(__FILE__));

define('wpbotvoicemessage_LICENSING_REMOTE_PATH', 'https://www.ultrawebmedia.com/li/plugins/voice-message-addon/update.php');
define('wpbotvoicemessage_LICENSING_PRODUCT_DEV_URL', 'https://quantumcloud.com/products/');

//start new-update-for-codecanyon
define('wpbotvoicemessage_ENVATO_PLUGIN_ID', -1);
//end new-update-for-codecanyon

function get_wpbotvoicemessage_licensing_plugin_data(){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	return get_plugin_data(wpbotvoicemessage_LICENSING__DIR.'/wpbotvoicemessage.php', false);
}

//License Options
function get_wpbotvoicemessage_licensing_key(){
	return get_option('qcld_wpbotvoicemessage_enter_license_key');
}

function get_wpbotvoicemessage_envato_key(){
	return get_option('qcld_wpbotvoicemessage_enter_envato_key');
}

function get_wpbotvoicemessage_licensing_buy_from(){
	return get_option('qcld_wpbotvoicemessage_buy_from_where');
}


//Update Transients
function get_wpbotvoicemessage_update_transient(){
	return get_transient('qcld_update_wpbotvoicemessage');
}

function set_wpbotvoicemessage_update_transient($plugin_object){
	return set_transient( 'qcld_update_wpbotvoicemessage', serialize($plugin_object), 1 * DAY_IN_SECONDS  );
}

function delete_wpbotvoicemessage_update_transient(){
	return delete_transient( 'qcld_update_wpbotvoicemessage' );
}


//Renewal Transients
function get_wpbotvoicemessage_renew_transient(){
	return get_transient('qcld_renew_wpbotvoicemessage_subscription');
}

function set_wpbotvoicemessage_renew_transient($plugin_object){
	return set_transient( 'qcld_renew_wpbotvoicemessage_subscription', serialize($plugin_object), 1 * DAY_IN_SECONDS  );
}

function delete_wpbotvoicemessage_renew_transient(){
	return delete_transient( 'qcld_renew_wpbotvoicemessage_subscription' );
}


//Invalid License Options
function get_wpbotvoicemessage_invalid_license(){
	return get_option('wpbotvoicemessage_invalid_license');
}

function set_wpbotvoicemessage_invalid_license(){
	return update_option('wpbotvoicemessage_invalid_license', 1);
}

function delete_wpbotvoicemessage_invalid_license(){
	return delete_option('wpbotvoicemessage_invalid_license');
}
function wpbotvoicemessage_get_licensing_url(){
	return admin_url('edit.php?post_type=qcldwpbot_record&page=wpbotvoicemessage_license');
}

//Valid License
function get_wpbotvoicemessage_valid_license(){
	return get_option('wpbotvoicemessage_valid_license');
}
function set_wpbotvoicemessage_valid_license(){
	return update_option('wpbotvoicemessage_valid_license', 1);
}
function delete_wpbotvoicemessage_valid_license(){
	return delete_option('wpbotvoicemessage_valid_license');
}

//staging or live 
function get_wpbotvoicemessage_site_type(){
	return get_option('qcld_wpbotvoicemessage_site_type');
}



//start new-update-for-codecanyon
function get_wpbotvoicemessage_license_purchase_code(){
	return get_option('qcld_wpbotvoicemessage_enter_license_or_purchase_key');
}

function get_wpbotvoicemessage_enter_license_notice_dismiss_transient(){
	return get_transient('get_wpbotvoicemessage_enter_license_notice_dismiss_transient');
}

function set_wpbotvoicemessage_enter_license_notice_dismiss_transient(){
	return set_transient('get_wpbotvoicemessage_enter_license_notice_dismiss_transient', 1, DAY_IN_SECONDS);
}

function get_wpbotvoicemessage_invalid_license_notice_dismiss_transient(){
	return get_transient('get_wpbotvoicemessage_invalid_license_notice_dismiss_transient');
}

function set_wpbotvoicemessage_invalid_license_notice_dismiss_transient(){
	return set_transient('get_wpbotvoicemessage_invalid_license_notice_dismiss_transient', 1, DAY_IN_SECONDS);
}
//end new-update-for-codecanyon

//add_action('admin_menu', 'wpbotvoicemessage_license_page');
function wpbotvoicemessage_license_page(){
	add_submenu_page(
        'edit.php?post_type=qcldwpbot_record',
        __( 'Help & License', 'textdomain' ),
        __( 'Help & License', 'textdomain' ),
        'manage_options',
        'wpbotvoicemessage_license',
        'wpbotvoicemessage_license_callback'
    );
}
function wpbotvoicemessage_license_callback(){
?>
	<h1>Please Insert your license Key</h1>
	<div class="qcld-wpbotvoicemessage-section-block">

		<?php
			$total_active_domain = 0;
			$active_domain_lists = array();
			$track_domain_request = wp_remote_get(wpbotvoicemessage_LICENSING_PRODUCT_DEV_URL."wp-json/qc-domain-tracker/v1/getdomain/?license_key=".get_wpbotvoicemessage_licensing_key(), array('timeout' => 300));
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
							set_wpbotvoicemessage_invalid_license();
								delete_wpbotvoicemessage_valid_license();
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

		<?php if( get_wpbotvoicemessage_valid_license() ){ ?>
			<div class="qcld-success-notice">
				<p>Thank you, Your License is active. <?php if( get_wpbotvoicemessage_licensing_buy_from() == 'codecanyon' ){ ?>Please <a href="https://envato.com/market-plugin/">Download</a> the Envato Market Plugin to Get Auto Updates During Your Support Period. <?php } ?></p>
			</div>
		<?php } ?>
		
		<form onsubmit="return false" id="qc-license-form" method="post" action="options.php">
			<?php
				delete_wpbotvoicemessage_update_transient();
				delete_wpbotvoicemessage_renew_transient();
				
				delete_option('_site_transient_update_plugins');
				settings_fields( 'qcld_wpbotvoicemessage_license' );
				do_settings_sections( 'qcld_wpbotvoicemessage_license' );

				// if( isset($_POST['submit']) ){
				// 	echo 'qcld_wpbotvoicemessage_buy_from_where '.$_POST['qcld_wpbotvoicemessage_buy_from_where'];
				// }
			?>
			<table class="form-table">

				<tr id="quantumcloud_portfolio_license_row" style="display: none">
					<th>
						<label for="qcld_wpbotvoicemessage_enter_license_key">Enter License Key:</label>
					</th>
					<td>
						<input type="<?php echo (get_wpbotvoicemessage_licensing_key()!=''?'password':'text'); ?>" id="qcld_wpbotvoicemessage_enter_license_key" name="qcld_wpbotvoicemessage_enter_license_key" class="regular-text" value="<?php echo get_wpbotvoicemessage_licensing_key(); ?>">
						<p>You can copy the license key from <a target="_blank" href='https://www.quantumcloud.com/products/account/'>your account</a></p>
					</td>
				</tr>

				<tr id="show_envato_plugin_downloader" style="display: none">
					<th>
						<label for="qcld_wpbotvoicemessage_enter_envato_key">Enter Purchase Code:</label>
					</th>
					<td colspan="4">
						<input type="<?php echo (get_wpbotvoicemessage_envato_key()!=''?'password':'text'); ?>" id="qcld_wpbotvoicemessage_enter_envato_key" name="qcld_wpbotvoicemessage_enter_envato_key" class="regular-text" value="<?php echo get_wpbotvoicemessage_envato_key(); ?>">
						<p>You can install the <a target="_blank" href="https://envato.com/market-plugin/">Envato Plugin</a> to stay up to date.</p>
					</td>
				</tr>

			<!-- //start new-update-for-codecanyon -->
                <tr>
                    <th>
                        <label for="qcld_wpbotvoicemessage_enter_license_or_purchase_key">Enter License Key or Purchase Code:</label>
                    </th>
                    <td>
                        <input type="<?php echo (get_wpbotvoicemessage_license_purchase_code()!=''?'password':'text'); ?>" id="qcld_wpbotvoicemessage_enter_license_or_purchase_key" name="qcld_wpbotvoicemessage_enter_license_or_purchase_key" class="regular-text" value="<?php echo get_wpbotvoicemessage_license_purchase_code(); ?>" required>
                    </td>
                </tr>
            <!-- //end new-update-for-codecanyon -->

			</table>

			<!-- //start new-update-for-codecanyon -->
            <input type="hidden" name="qcld_wpbotvoicemessage_buy_from_where" value="<?php echo get_wpbotvoicemessage_licensing_buy_from(); ?>" >
            <!-- //end new-update-for-codecanyon -->
			<?php submit_button(); ?>
		</form>
	</div>

	<script type="text/javascript">
        jQuery(document).ready(function(){

            //start new-update-for-codecanyon
            jQuery('#qcld_wpbotvoicemessage_enter_license_or_purchase_key').on('focusout', function(){
            	qc_wpbotvoicemessage_set_plugin_license_fields();
            });

            jQuery('#qcld_wpbotvoicemessage_enter_license_or_purchase_key').on('keypress',function (e) {
            	  qc_wpbotvoicemessage_set_plugin_license_fields();
			});

			jQuery('#qc-license-form input[type="submit"]').on('click', function(){
				qc_wpbotvoicemessage_set_plugin_license_fields();
				jQuery('#qc-license-form').removeAttr('onsubmit').submit();
			});

            function qc_wpbotvoicemessage_set_plugin_license_fields(){
                var license_input = jQuery('#qcld_wpbotvoicemessage_enter_license_or_purchase_key').val();
                if( /^(\w{8})-((\w{4})-){3}(\w{12})$/.test(license_input) ){
                    jQuery('input[name="qcld_wpbotvoicemessage_buy_from_where"]').val('codecanyon');
                    jQuery('input[name="qcld_wpbotvoicemessage_enter_envato_key"]').val(license_input);
                }else{
                    jQuery('input[name="qcld_wpbotvoicemessage_buy_from_where"]').val('quantumcloud');
                    jQuery('input[name="qcld_wpbotvoicemessage_enter_license_key"]').val(license_input);
                }
            }
            //end new-update-for-codecanyon

        });
    </script>
<?php
}
