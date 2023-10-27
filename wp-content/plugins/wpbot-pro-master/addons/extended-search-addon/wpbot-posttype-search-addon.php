<?php

if(!class_exists('wbpt_Admin_Area_Controller')){

defined('ABSPATH') or die("No direct script access!");
define('QCLD_wpCHATBOT_POSTTYPE_PLUGIN_URL', plugin_dir_url(__FILE__));

define('QCLD_EXTENDED_IMG_URL', QCLD_wpCHATBOT_POSTTYPE_PLUGIN_URL . "images/");

require_once 'wpbot-posttype-search-function.php';
//require('plugin-upgrader/plugin-upgrader.php');

add_action('init', 'qcpd_wpps_posttype_search_dependencies');
function qcpd_wpps_posttype_search_dependencies(){
	
	if ( !class_exists('qcld_wb_Chatbot') && !class_exists('QCLD_Woo_Chatbot')) {
		//add_action('admin_notices', 'qcpd_wpbot_pt_require_notice');
	}
}

/*
* Post Type settings area
*/
class wbpt_Admin_Area_Controller {
	
	function __construct(){
		add_action( 'admin_menu', array($this,'wppt_admin_menu') );
		add_action( 'admin_init', array($this, 'wppt_register_plugin_settings') );
		add_action( 'activated_plugin', array( $this, 'qc_wppt_activation_redirect') );
	}

	public function wppt_admin_menu(){

        if ( current_user_can( 'publish_posts' ) ){
			add_menu_page( 'Bot - Extended Search', 'Bot - Extended Search', 'manage_options', 'wbpt-posttypesetting-page', array( $this, 'wbpt_setting_page' ), 'dashicons-search', '9' );
			add_submenu_page( 'wbpt-posttypesetting-page', 'Synonyms item', 'Synonyms item', 'manage_options','synonyms-search', array($this, 'synonyms_search_callback') );
			//add_submenu_page( 'wbpt-posttypesetting-page', 'Help & License', 'Help & License', 'manage_options','extended-search-help-license', array($this, 'qcld_license_callback') );
        }
		
    }
	
	public function wppt_register_plugin_settings(){
		$get_cpt_args = array(
			'public'   => true,
			'_builtin' => false
		);
		$post_types = get_post_types( $get_cpt_args, 'object' );
		
		
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_post_types' );
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_heading_page' );
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_heading_post' );
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_number_of_result' );
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_result_orderby' );
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_result_order' );
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_wiki_search' );
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_google_search' );
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_google_api_key' );
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_google_search_id' );
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_rest_api_search' );
		register_setting( 'qc-wppt-plugin-settings-group', 'wppt_rest_api_urls' );
		foreach($post_types as $post_type){
			register_setting( 'qc-wppt-plugin-settings-group', 'wppt_heading_'.$post_type->name );
		}
		
		
	}
	
	function qc_wppt_activation_redirect( $plugin ) {
		
		if(!get_option('wppt_post_types')){
			update_option('wppt_post_types', array('product','page','post'));
		}
		
		if( $plugin == plugin_basename( __FILE__ ) ) {
			exit( wp_redirect( admin_url( 'admin.php?page=extended-search-help-license') ) );
		}
		
	}
	
	public function wbpt_setting_page(){
		$get_cpt_args = array(
			'public'   => true,
			'_builtin' => false
		);
		$post_types = get_post_types( $get_cpt_args, 'object' );
		?>
	<div class="wrap swpm-admin-menu-wrap">
		<h1>Extended Search Settings Page</h1>
	
		<h2 class="nav-tab-wrapper sld_nav_container wppt_nav_container">
			<a class="nav-tab sld_click_handle nav-tab-active" href="#general_settings">General Settings</a>
			<?php do_action('wppt_extra_settings_tab') ?>
			<a class="nav-tab sld_click_handle" href="#wikipedia_settings">Wikipedia Settings</a>
			<a class="nav-tab sld_click_handle" href="#google_settings">Google Search Settings</a>
			<a class="nav-tab sld_click_handle" href="#rest_api_settings">Search from other WP site</a>
		</h2>
		
		<form method="post" action="options.php">
			<?php settings_fields( 'qc-wppt-plugin-settings-group' ); ?>
			<?php do_settings_sections( 'qc-wppt-plugin-settings-group' ); ?>
			<?php 
				$post_type_array = !is_array(get_option('wppt_post_types'))?array():get_option('wppt_post_types');
			?>
			<div class="wppt-settings-section" id="general_settings">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Allow Bot Searching On</th>
						<td>
							<?php 
							
								foreach($post_types as $post_type){
									if($post_type->name=='product'){
									?>
									<input type="checkbox" name="wppt_post_types[]" value="<?php echo $post_type->name; ?>" <?php echo ((in_array($post_type->name, $post_type_array))?'checked="checked"':''); ?> /> <?php echo $post_type->name; ?>
									<?php
									}
								}
							
							?>
							
							<input type="checkbox" name="wppt_post_types[]" value="page" <?php echo ((in_array('page', $post_type_array))?'checked="checked"':''); ?>  /> page
							<input type="checkbox" name="wppt_post_types[]" value="post" <?php echo ((in_array('post', $post_type_array))?'checked="checked"':''); ?> /> post
							<?php 
							
								foreach($post_types as $post_type){
									if($post_type->name!='product'){
									?>
									<input type="checkbox" name="wppt_post_types[]" value="<?php echo $post_type->name; ?>" <?php echo ((in_array($post_type->name, $post_type_array))?'checked="checked"':''); ?> /> <?php echo $post_type->name; ?>
									<?php
									}
								}
							
							?>
							
							<br><br><i>Please checked the post types where Bot perform the search.</i>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Number of results to show</th>
						<td>
							<input type="text" name="wppt_number_of_result" size="100" value="<?php echo (get_option('wppt_number_of_result')!=''?esc_attr( get_option('wppt_number_of_result')):'5'); ?>"  />
							
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Result Display Orderby</th>
						<td>
							
							
							<select name="wppt_result_orderby">
								<option value="title" <?php echo (get_option('wppt_result_orderby')=='title'?'selected="selected"':''); ?>>Title</option>
								<option value="ID" <?php echo (get_option('wppt_result_orderby')=='ID'?'selected="selected"':''); ?>>ID</option>
								<option value="date" <?php echo (get_option('wppt_result_orderby')=='date'?'selected="selected"':''); ?>>Date</option>
								<option value="modified" <?php echo (get_option('wppt_result_orderby')=='modified'?'selected="selected"':''); ?>>Modified Date</option>
								<option value="rand" <?php echo (get_option('wppt_result_orderby')=='rand'?'selected="selected"':''); ?>>Random</option>
								<option value="none" <?php echo (get_option('wppt_result_orderby')=='none'?'selected="selected"':''); ?>>None</option>
							</select>
							
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Result Display Order</th>
						<td>
							
							
							<select name="wppt_result_order">
								<option value="ASC" <?php echo (get_option('wppt_result_order')=='ASC'?'selected="selected"':''); ?>>Ascending</option>
								<option value="DESC" <?php echo (get_option('wppt_result_order')=='DESC'?'selected="selected"':''); ?>>Descending</option>

							</select>
							
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Search Heading Text - page</th>
						<td>
							<input type="text" name="wppt_heading_page" size="100" value="<?php echo (get_option('wppt_heading_page')!=''?esc_attr( get_option('wppt_heading_page')):'We have found #Number Pages for the keyword #Keyword'); ?>"  />
							<br><br><i>You can change the heading text as your needs. Please #Number & #keyword for dynamic value.</i>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Search Heading Text - post</th>
						<td>
							<input type="text" name="wppt_heading_post" size="100" value="<?php echo (get_option('wppt_heading_post')!=''?esc_attr( get_option('wppt_heading_post')):'We have found #Number Posts for the keyword #Keyword'); ?>"  />
							<br><br><i>You can change the heading text as your needs. Please #Number & #keyword for dynamic value.</i>
						</td>
					</tr>
					
					<?php 
					
					 foreach($post_types as $post_type){
						
						?>
						<tr valign="top">
							<th scope="row">Search Heading Text - <?php echo $post_type->name; ?></th>
							<td>
								<input type="text" name="wppt_heading_<?php echo $post_type->name; ?>" size="100" value="<?php echo (get_option('wppt_heading_'.$post_type->name)!=''?esc_attr( get_option('wppt_heading_'.$post_type->name)):'We have found #Number '.$post_type->label.' for the keyword #Keyword'); ?>"  />
								<br><br><i>You can change the heading text as your needs. Please #Number & #keyword for dynamic value.</i>
							</td>
						</tr>
						<?php						 
					 }
					
					?>

					<?php do_action('before_wppt_table_end'); ?>
					
					
				</table>
			</div>
			<?php do_action('after_wppt_general_settings'); ?>

			<div class="wppt-settings-section" id="wikipedia_settings" style="display: none;">
				<table class="form-table">
				<tr valign="top">
						<th scope="row">Enable wikipedia search</th>
						<td>
							<input type="checkbox" name="wppt_wiki_search" value="1" <?php echo (get_option('wppt_wiki_search')==1?'checked="checked"':''); ?>  /> Enable
							<br><br><i>Enable wikipedia search if no result found.</i>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Search Heading Text - Wikipedia</th>
						<td>
							<input type="text" name="wppt_heading_wiki" size="100" value="<?php echo (get_option('wppt_heading_wiki')!=''?esc_attr( get_option('wppt_heading_wiki')):'We have found #Number Wikipedia article for the keyword #Keyword'); ?>"  />
							<br><br><i>You can change the heading text as your needs. Please keep #Number & #keyword for dynamic value.</i>
						</td>
					</tr>
				</table>
			</div>

			<div class="wppt-settings-section" id="google_settings" style="display: none;">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Enable Google Search</th>
						<td>
							
							<input type="checkbox" name="wppt_google_search" value="1" <?php echo (get_option('wppt_google_search')==1?'checked="checked"':''); ?>  /> Enable
							<br><br><i>Enable Google search if no result found.</i>
							
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Google API Key</th>
						<td>
							<input type="text" name="wppt_google_api_key" size="100" value="<?php echo (get_option('wppt_google_api_key')!=''?esc_attr( get_option('wppt_google_api_key')):''); ?>"  />
							<br><br><i>Please add google API key here. If you don't have any then create it from here: <a href="https://developers.google.com/custom-search/v1/overview" target="_blank">https://developers.google.com/custom-search/v1/overview</a></i>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row">Search Engine ID</th>
						<td>
							<input type="text" name="wppt_google_search_id" size="100" value="<?php echo (get_option('wppt_google_search_id')!=''?esc_attr( get_option('wppt_google_search_id')):''); ?>"  />
							<br><br><i>Please add google Search Engine ID here. If you don't have any then create it from here: <a href="https://cse.google.com/cse/all" target="_blank">https://cse.google.com/cse/all</a></i>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row">Search Heading Text - Google</th>
						<td>
							<input type="text" name="wppt_heading_google" size="100" value="<?php echo (get_option('wppt_heading_google')!=''?esc_attr( get_option('wppt_heading_google')):'We have found #Number results from google for the keyword #Keyword'); ?>"  />
							<br><br><i>You can change the heading text as your needs. Please keep #Number & #keyword for dynamic value.</i>
						</td>
					</tr>
				</table>
			</div>

			<div class="wppt-settings-section" id="rest_api_settings" style="display: none;">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Enable Other WP Site Search</th>
						<td>
							<input type="checkbox" name="wppt_rest_api_search" value="1" <?php echo (get_option('wppt_rest_api_search')==1?'checked="checked"':''); ?>  /> Enable
							<br><br><i>Enable wordpress Rest API Search.</i>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">Add site link here</th>
							<td >
					 			<div id="wppt_wrapper_urls">
								 	<div>
										
										<?php
										$api_urls_array = get_option('wppt_rest_api_urls');
										if(empty($api_urls_array)){
											echo '<div><input type="text" name="wppt_rest_api_urls[]" value=""/>
											<a  class="add_qcld_rest_url button" title="Add field">Add Url</a></div>';
										}else{
											foreach ($api_urls_array as $key => $value) {
												
												if($key == 0 ){
													echo '<div><input type="text" name="wppt_rest_api_urls[]" value="'.$value.'"/>
															<a  class="add_qcld_rest_url button" title="Add field">Add Url</a></div>';
												}else{
													echo '<div><input type="text" name="wppt_rest_api_urls[]" value="'.$value.'"/><a href="javascript:void(0);" class="remove_qcld_rest_url button">Remove Url</a></div>';
												}
												 
											}
										}
										?>
									</div>
								</div>
								</br><i>example: https://google.com</i>
								
							</td>
						</td>
					</tr>

				</table>
			</div>
			
			
			

			
			<?php submit_button(); ?>

		</form>

		
	</div>

	<?php
	}
	public function synonyms_search_callback(){
		?>
		<table class="form-table">
			<tr>
				<th>
					<label for="syno_words"> Main Word </label>	
				</th>
				<td>
					<input type="text" id="syno_words" name="syno_words" size="100" />
				</td>
			</tr>
			<tr>
				<th>
					<label for="syno_words"> Synonym Words </label>
				</th>
				<td>
					<input type="text" id="synonyms" name="synonyms" size="100" />
				</td>
			</tr>	
			<tr>
				<th>
					<button id="create_synonms">Create</button>
				</td>
			</tr>
		
		</table>
		<table id="syno_table"  class="cell-border stripe" style="width:100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Word</th>
					<th>Synonys</th>
					<th>Actons</th>
				</tr>
        	</thead>
		</table>
		<?php
	}
	public function qcld_license_callback(){
		
		?>
		<div id="licensing">
				<h1>Please Insert your license Key</h1>
				<?php if( get_extendedsearch_valid_license() ){ ?>
					<div class="qcld-success-notice">
						<p>Thank you, Your License is active</p>
					</div>
				<?php } ?>
				
				<?php
				
					

				$total_active_domain = 0;
                $active_domain_lists = array();
                $track_domain_request = wp_remote_get(extendedsearch_LICENSING_PRODUCT_DEV_URL."wp-json/qc-domain-tracker/v1/getdomain/?license_key=".get_extendedsearch_licensing_key(), array('timeout' => 300));
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
                                set_extendedsearch_invalid_license();
                                delete_extendedsearch_valid_license();
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
						delete_extendedsearch_update_transient();
						delete_extendedsearch_renew_transient();
						
						delete_option('_site_transient_update_plugins');
						settings_fields( 'qcld_extendedsearch_license' );
						do_settings_sections( 'qcld_extendedsearch_license' );

						// if( isset($_POST['submit']) ){
						// 	echo 'qcld_extendedsearch_buy_from_where '.$_POST['qcld_extendedsearch_buy_from_where'];
						// }
					?>
					<table class="form-table">
						

						<tr id="quantumcloud_portfolio_license_row" style="display: none">
							<th>
								<label for="qcld_extendedsearch_enter_license_key">Enter License Key:</label>
							</th>
							<td>
								<input type="<?php echo (get_extendedsearch_licensing_key()!=''?'password':'text'); ?>" id="qcld_extendedsearch_enter_license_key" name="qcld_extendedsearch_enter_license_key" class="regular-text" value="<?php echo get_extendedsearch_licensing_key(); ?>">
								<p>You can copy the license key from <a target="_blank" href='https://www.quantumcloud.com/products/account/'>your account</a></p>
							</td>
						</tr>

						<tr id="show_envato_plugin_downloader" style="display: none">
							<th>
								<label for="qcld_extendedsearch_enter_envato_key">Enter Purchase Code:</label>
							</th>
							<td colspan="4">
								<input type="<?php echo (get_extendedsearch_envato_key()!=''?'password':'text'); ?>" id="qcld_extendedsearch_enter_envato_key" name="qcld_extendedsearch_enter_envato_key" class="regular-text" value="<?php echo get_extendedsearch_envato_key(); ?>">
								<p>You can install the <a target="_blank" href="https://envato.com/market-plugin/">Envato Plugin</a> to stay up to date.</p>
							</td>
						</tr>
						
						<tr>
							<th>
								<label for="qcld_extendedsearch_enter_license_or_purchase_key">Enter License Key or Purchase Code:</label>
							</th>
							<td>
								<input type="<?php echo (get_extendedsearch_license_purchase_code()!=''?'password':'text'); ?>" id="qcld_extendedsearch_enter_license_or_purchase_key" name="qcld_extendedsearch_enter_license_or_purchase_key" class="regular-text" value="<?php echo get_extendedsearch_license_purchase_code(); ?>" required>
							</td>
						</tr>



					</table>
					<!-- //start new-update-for-codecanyon -->
					<input type="hidden" name="qcld_extendedsearch_buy_from_where" value="<?php echo get_extendedsearch_licensing_buy_from(); ?>" >
					<!-- //end new-update-for-codecanyon -->
					<?php submit_button(); ?>
				</form>
				<script type="text/javascript">
					jQuery(document).ready(function(){

						//start new-update-for-codecanyon
						jQuery('#qcld_extendedsearch_enter_license_or_purchase_key').on('focusout', function(){
							qc_extendedsearch_set_plugin_license_fields();
						});

						jQuery('#qcld_extendedsearch_enter_license_or_purchase_key').on('keypress',function (e) {
							  qc_extendedsearch_set_plugin_license_fields();
						});

						jQuery('#qc-license-form input[type="submit"]').on('click', function(){
							qc_extendedsearch_set_plugin_license_fields();
							jQuery('#qc-license-form').removeAttr('onsubmit').submit();
						});

						function qc_extendedsearch_set_plugin_license_fields(){
							var license_input = jQuery('#qcld_extendedsearch_enter_license_or_purchase_key').val();
							if( /^(\w{8})-((\w{4})-){3}(\w{12})$/.test(license_input) ){
								jQuery('input[name="qcld_extendedsearch_buy_from_where"]').val('codecanyon');
								jQuery('input[name="qcld_extendedsearch_enter_envato_key"]').val(license_input);
							}else{
								jQuery('input[name="qcld_extendedsearch_buy_from_where"]').val('quantumcloud');
								jQuery('input[name="qcld_extendedsearch_enter_license_key"]').val(license_input);
							}
						}
						//end new-update-for-codecanyon

					});
				</script>
			</div>
		<?php 
		
	}
	
}
new wbpt_Admin_Area_Controller();

register_activation_hook(QCLD_wpCHATBOT_FILE_URL, 'qcld_wpbot_pt_search_options');
if(!function_exists('qcld_wpbot_pt_search_options')){
	function qcld_wpbot_pt_search_options(){
	
		if(!get_option('wppt_post_types')) {
			update_option('wppt_post_types', array('post','page'));
		}

		if(!get_option('wppt_enable_fuzzy_search')) {
			update_option('wppt_enable_fuzzy_search', 1);
		}

		if(!get_option('wppt_enable_alt_title')) {
			update_option('wppt_enable_alt_title', 1);
		}

		if(!get_option('wppt_search_weight')) {
			update_option('wppt_search_weight', 50);
		}
		
	}
}


add_action( 'init', 'qcld_wpbot_synonymsCreateTable');
register_activation_hook( QCLD_wpCHATBOT_FILE_URL, 'qcld_wpbot_synonymsCreateTable');
if(!function_exists('qcld_wpbot_synonymsCreateTable')){
	function qcld_wpbot_synonymsCreateTable() {
	  global $wpdb;
	  $charset_collate = $wpdb->get_charset_collate();
	  $table_name = $wpdb->prefix . 'wpbot_synonyms';
	  $sql = "CREATE TABLE `$table_name` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `word` varchar(220) DEFAULT NULL,
	  `synonyms` varchar(220) DEFAULT NULL,
	  PRIMARY KEY(id)
	  )DEFAULT CHARSET=utf8;
	  ";
	  if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	  }
	}

}




// Fuzzy Wuzzy
require_once( plugin_dir_path( __FILE__ ) . '/libs/vendor/autoload.php');

function wppt_fuse_fields(){
	$wppt_search_weight = get_option('wppt_search_weight') ? get_option('wppt_search_weight') : 50;
?>
	<div style="display: none;" class="wppt-settings-section" id="fuzzy-settings">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Enable Fuzzy Search</th>
				<td>
					<input type="checkbox" name="wppt_enable_fuzzy_search" value="1 " <?php checked( get_option('wppt_enable_fuzzy_search'), 1 ); ?>>
					<br />
					<a href="#" class="wppt_generate_fuzzy_data button button-primary">Index Post titles and alternative titles</a>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">Enable alternative titles for better search results</th>
				<td>
					<input type="checkbox" name="wppt_enable_alt_title" value="1 " <?php checked( get_option('wppt_enable_alt_title'), 1 ); ?>>
					(You can add variations of your main post title from each post edit page that users can possibly search for)
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">Search Weight</th>
				<td>
					<input type="text" name="wppt_search_weight" value="<?php echo $wppt_search_weight; ?>">
					(Enter Values between 0 to 100. 0 means to return only exact match results and 100 means to return all result with complete missmatch)
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">Schedule to Generate New Data</th>
				<td>
					<?php
						$wppt_fuzzy_data_generator_interval = get_option('wppt_fuzzy_data_generator_interval') ? get_option('wppt_fuzzy_data_generator_interval') : 1;
						$wppt_fuzzy_data_generator_interval_type = get_option('wppt_fuzzy_data_generator_interval_type');
					?>
					<input type="text" name="wppt_fuzzy_data_generator_interval" value="<?php echo $wppt_fuzzy_data_generator_interval; ?>">
					<select name="wppt_fuzzy_data_generator_interval_type" id="">
						<option <?php selected( $wppt_fuzzy_data_generator_interval_type, 'd'); ?> value="d">Days</option>
						<option <?php selected( $wppt_fuzzy_data_generator_interval_type, 'h'); ?> value="h">Hours</option>
						<option <?php selected( $wppt_fuzzy_data_generator_interval_type, 'm'); ?> value="m">Minutes</option>
						<option <?php selected( $wppt_fuzzy_data_generator_interval_type, 's'); ?> value="s">Seconds</option>
					</select>
				</td>
			</tr>
		</table>
	</div>
<?php
}
add_action('after_wppt_general_settings', 'wppt_fuse_fields');

function wppt_extra_settings_tab(){
?>
	<a class="nav-tab sld_click_handle" href="#fuzzy-settings">Fuzzy Matching</a>
<?php
}
add_action('wppt_extra_settings_tab', 'wppt_extra_settings_tab');

function wppt_fuzzy_data_generator_event(){
	$wppt_fuzzy_data_generator_interval = get_option('wppt_fuzzy_data_generator_interval') ? get_option('wppt_fuzzy_data_generator_interval') : 1;
	$wppt_fuzzy_data_generator_interval_type = get_option('wppt_fuzzy_data_generator_interval_type') ? get_option('wppt_fuzzy_data_generator_interval_type') : 'd';
	$interval = $wppt_fuzzy_data_generator_interval.$wppt_fuzzy_data_generator_interval_type;
	if ( ! wp_next_scheduled( 'wppt_fuzzy_data_generator_event_hook' ) && get_option('wppt_fuzzy_data_generator_interval') && get_option('wppt_fuzzy_data_generator_interval_type') ) {
		wp_schedule_event( time(), $interval, 'wppt_fuzzy_data_generator_event_hook' );
	}
}
add_action('plugins_loaded', 'wppt_fuzzy_data_generator_event');

function wppt_fuzzy_data_generator_event_function(){
	generate_wppt_file();
}
add_action('wppt_fuzzy_data_generator_event_hook', 'wppt_fuzzy_data_generator_event_function');

function wppt_cron_schedules($schedules){
    $wppt_fuzzy_data_generator_interval = get_option('wppt_fuzzy_data_generator_interval') ? get_option('wppt_fuzzy_data_generator_interval') : 1;
	$wppt_fuzzy_data_generator_interval_type = get_option('wppt_fuzzy_data_generator_interval_type') ? get_option('wppt_fuzzy_data_generator_interval_type') : 'd';
	$interval = $wppt_fuzzy_data_generator_interval.$wppt_fuzzy_data_generator_interval_type;

	if(!isset($schedules[$interval])){
		if( $wppt_fuzzy_data_generator_interval_type == 's' ){
	        $schedules[$interval] = array(
	            'interval' => $wppt_fuzzy_data_generator_interval,
	            'display' => __( 'Every'.$interval.' Seconds' ),
	        );
		}elseif( $wppt_fuzzy_data_generator_interval_type == 'm' ){
	        $schedules[$interval] = array(
	            'interval' => $wppt_fuzzy_data_generator_interval * 60,
	            'display' => __( 'Every'.$interval.' Minutes' ),
	        );
		}elseif( $wppt_fuzzy_data_generator_interval_type == 'h' ){
	        $schedules[$interval] = array(
	            'interval' => $wppt_fuzzy_data_generator_interval * 60 * 60,
	            'display' => __( 'Every'.$interval.' Hours' ),
	        );
		}elseif( $wppt_fuzzy_data_generator_interval_type == 'd' ){
	        $schedules[$interval] = array(
	            'interval' => $wppt_fuzzy_data_generator_interval *60 * 60 * 24,
	            'display' => __( 'Every'.$interval.' Days' ),
	        );
		}
    }
	return $schedules;
}
add_filter('cron_schedules','wppt_cron_schedules');


function wppt_fuse_register_settings(){
	register_setting( 'qc-wppt-plugin-settings-group', 'wppt_enable_fuzzy_search' );
	register_setting( 'qc-wppt-plugin-settings-group', 'wppt_enable_alt_title' );
	register_setting( 'qc-wppt-plugin-settings-group', 'wppt_fuzzy_data_generator_interval' );
	register_setting( 'qc-wppt-plugin-settings-group', 'wppt_fuzzy_data_generator_interval_type' );
	register_setting( 'qc-wppt-plugin-settings-group', 'wppt_search_weight' );
}
add_action( 'admin_init', 'wppt_fuse_register_settings');


function wppt_fuse_script(){
	wp_enqueue_style('wppt_admin_css', plugin_dir_url(__FILE__) . '/css/admin.css', array(), '1.0.0', 'all');
	wp_enqueue_style('wppt_data_table', plugin_dir_url(__FILE__) . '/css/jquery-datatable.css', array(), '1.0.0', 'all');

	wp_enqueue_script('wppt_data_table', plugin_dir_url(__FILE__) . '/js/jquery-dataTable.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script('wppt_fuse_js', plugin_dir_url(__FILE__) . '/js/admin.js', array('jquery'), '1.0.0', true);
	wp_localize_script( 'wppt_fuse_js', 'wppt_fuse_admin_obj', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	) );
}
add_action('admin_enqueue_scripts', 'wppt_fuse_script');

function wppt_generate_fuzzy_data_func(){
	generate_wppt_file();
	wp_die();
}
add_action('wp_ajax_wppt_generate_fuzzy_data', 'wppt_generate_fuzzy_data_func');
function qcld_create_wpbot_synonymsearch(){
	global $wpdb;
	$table = $wpdb->prefix . 'wpbot_synonyms';
	$word = sanitize_text_field($_POST['word']);
    $synonyms =sanitize_text_field($_POST['synonyms']);
	
	$create = $wpdb->insert(
		$table,
		array(
			'word'   => $word,
			'synonyms'   => $synonyms,
		)
	);
	$response['status'] = 'success';
	$response['id'] = $create;
	echo json_encode($response);
	wp_die();
}
add_action('wp_ajax_qcld_create_wpbot_synonymsearch','qcld_create_wpbot_synonymsearch');
function qcld_fetch_wpbot_synonymsearch(){
	global $wpdb;
	$table = $wpdb->prefix . "wpbot_synonyms";
	$sql = "SELECT * FROM $table";
	$results = $wpdb->get_results($sql);
	for ($i = 0; $i < sizeof($results); $i++) {
		$results[$i]->action = '<a id="delete_synonyms" class="button" data-id="' . $results[$i]->id . '">Delete</a>';
	
	}
	$dataLength = count($wpdb->get_results($sql));

	$output = array(
			"draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
			"recordsTotal" => !is_null($dataLength) ? intval($dataLength) : 0,
			"recordsFiltered" => !is_null($dataLength) ? intval($dataLength) : 0,
			"data" => $results,
			   );

	wp_send_json($output);
}
add_action('wp_ajax_qcld_fetch_wpbot_synonymsearch','qcld_fetch_wpbot_synonymsearch');
function qcld_delete_wpbot_synonymsearch(){
	global $wpdb;
	$table = $wpdb->prefix . 'wpbot_synonyms';
	$id = sanitize_text_field($_POST['id']);
	$wpdb->delete(
		$table,
		array( 'id' => $id ),
		array( '%s' )
	);
	$response['status'] = 'success';
	$response['id'] = $id;
	echo json_encode($response);wp_die();
}
add_action('wp_ajax_qcld_delete_wpbot_synonymsearch','qcld_delete_wpbot_synonymsearch');
function qcld_create_wpbot(){
	global $wpdb;
	
	$sql = "SELECT * FROM ". $wpdb->prefix."wpbot_synonyms";
	$results = $wpdb->get_results($sql);
	$teacher_name = [];
	foreach ($results as $key => $value) {
		$name = array(word => $value->word, synonyms => $value->synonyms);
		array_push($teacher_name, $name);
	};
	wp_send_json(array('success' => true,'teacher_name' => $teacher_name));
	wp_die();

}
function generate_wppt_file(){
	global $wpdb;
	$allowed_post_types = get_option('wppt_post_types') ? get_option('wppt_post_types') : array('post', 'page');
	$uploads_dir = trailingslashit( wp_upload_dir()['basedir'] ) . 'wppt';
	if(wp_mkdir_p( $uploads_dir )){
		$wppt_data = fopen( $uploads_dir."/wppt-data.txt", "w" );
		$sql = $wpdb->get_results( 
                    $wpdb->prepare(
                    	"SELECT ID, post_type, post_title FROM $wpdb->posts WHERE post_status =%s",
                    	'publish'
                    ) 
                );
		$data = [];
		$new_data = [];

		foreach ($sql as $key) {
			
			$new_data['ID'] = $key->ID;
			$new_data['post_type'] = $key->post_type;
			$new_data['title'] = $key->post_title;
			$alt_title = unserialize(get_post_meta( $key->ID, 'kpm_more_queries', true));

			if( $alt_title ){
				$new_data['alt_title'] = $alt_title;
			}else{
				$new_data['alt_title'] = [];
			}
			array_push($data, $new_data);
		}
		if(fwrite($wppt_data, json_encode($data))){
			echo 'generate_file';
		}
		fclose($wppt_data);
	}else{
		echo 'file_not_create';
	}
}

function wppt__deactivate(){
	if ( wp_next_scheduled( 'wppt_fuzzy_data_generator_event_hook' ) ){
		wp_clear_scheduled_hook('wppt_fuzzy_data_generator_event_hook');
	}	
}
register_deactivation_hook( __FILE__, 'wppt__deactivate' );

function wppt_add_alt_title_box()
{
	$get_cpt_args = array(
		'public'   => true,
		'_builtin' => false
	);
	$post_types = get_post_types( $get_cpt_args );
	
    $screens = ['post', 'page'];
    foreach ($post_types as $post_type) {
    	array_push($screens, $post_type);
    }
	if (($key = array_search('kbx_knowledgebase', $screens)) !== false) {
	    unset($screens[$key]);
	}

    foreach ($screens as $screen) {
        add_meta_box(
            'wppt_alt_title_box',           // Unique ID
            'Alternative Title',  // Box title
            'wppt_alt_title_box',  // Content callback, must be of type callable
            $screen                   // Post type
        );
    }
}
add_action('add_meta_boxes', 'wppt_add_alt_title_box');

function wppt_alt_title_box( $object ){
	$outline = '';
	$kpm_more_queries = unserialize(get_post_meta( $object->ID, 'kpm_more_queries', true ));
	$outline .= '<div id="kbx-more-queries-container"><label  style="width:150px; display:inline-block;">'. esc_html__('Alternative Titles or Questions that this Article also Answers', 'kbx-qc') .'</label>';
    if(isset($kpm_more_queries) && !empty($kpm_more_queries)){
            $kpm_more_counter=1;
            foreach ($kpm_more_queries as $kpm_more_query){
                $outline .= '<div style="display:inline-block" class="kbx-more-query"><input type="text" name="kpm_more_queries[]"  class="kpm_more_queries" value="'. esc_attr($kpm_more_query) .'" style="width:300px;"/> <button type="button" class="danger kbx-more-query-remove"> X </button></div>';
                }
     }else{
        $outline .= '<div style="display: inline-block" class="kbx-more-query"><input type="text" name="kpm_more_queries[]"  class="kpm_more_queries" style="width:300px;"/> <button class="danger kbx-more-query-remove"> X </button></div>';
    }
    $outline .= '</div><div style="margin-left:151px;margin-top:5px"> <button type="button" id="kbx-more-query-add">+ More</button> </div>';

    $outline.='<script>';
        $outline.='
        jQuery(\'#kbx-more-query-add\').click(function (e) {
            var query=\'<div style="margin-left:150px;" class="kbx-more-query"><input type="text" name="kpm_more_queries[]"  class="kpm_more_queries" style="width:300px;"/> <button type="button" class="danger kbx-more-query-remove"> X </button></div>\';
            jQuery(\'#kbx-more-queries-container\').append(query);
        });
        jQuery(document).on(\'click\',\'.kbx-more-query-remove\',function (e) {
        if (confirm(\'Are you sure you want to remove this?\')) {
            jQuery(this).parent().remove();
        } 
    })
    	</script>
        ';
    echo $outline;
}

function wppt_save_alt_title_meta_box($post_id, $post, $update)
{

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $get_cpt_args = array(
		'public'   => true,
		'_builtin' => false
	);
	$post_types = get_post_types( $get_cpt_args );
	
    $screens = ['post', 'page'];
    foreach ($post_types as $post_type) {
    	array_push($screens, $post_type);
    }
	if (($key = array_search('kbx_knowledgebase', $screens)) !== false) {
	    unset($screens[$key]);
	}

    if( !in_array( $post->post_type, $screens) ){
        return $post_id;
    }

    if(isset($_POST["kpm_more_queries"])){
        $more_queries = serialize( $_POST["kpm_more_queries"] );
        update_post_meta($post_id, "kpm_more_queries", $more_queries);
    }
}

add_action("save_post", "wppt_save_alt_title_meta_box", 10, 3);
}