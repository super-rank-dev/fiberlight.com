<?php
/*
* Instagram settings area
*/
class wbig_Admin_Area_Controller {
	
	function __construct(){
		add_action( 'admin_menu', array($this,'wbig_admin_menu') );
		add_action( 'admin_init', array($this, 'wpig_register_plugin_settings') );
	}

	public function wbig_admin_menu(){

        if ( current_user_can( 'publish_posts' ) ){

			add_submenu_page( 'wbfb-botsetting-page', 'Instagram Chatbot', 'Instagram Chatbot', 'publish_posts', 'wbig-botsetting-page', array( $this, 'wbig_setting_page' ), 10 );
			
			if(class_exists('qcld_wb_Chatbot')){
				add_submenu_page( 'wbfb-botsetting-page', 'IG Menu Setup', 'IG Menu Setup', 'manage_options','instagram-chatbot-ig-menu', array($this, 'qcld_instagram_ig_menu'), 10 );
			}
		}
		
    }
	
	public function qcld_instagram_ig_menu(){
		
		
		wp_register_style('qlcd-wp-chatbot-admin-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/admin-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qlcd-wp-chatbot-admin-style');
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_script( 'jquery-ui-sortable');
		wp_register_script('qcld-wp-chatbot-qcpickertm-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.timepicker.js', array('jquery'), true);
		wp_register_script('qcld-wp-chatbot-admin-js', QCLD_wpCHATBOT_PLUGIN_URL . '/js/qcld-wp-chatbot-admin.js', array('jquery', 'jquery-ui-core','jquery-ui-sortable','wp-color-picker','qcld-wp-chatbot-qcpickertm-js'), true);
        wp_enqueue_script('qcld-wp-chatbot-admin-js');
		 wp_register_style('qcld-wp-chatbot-common-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/common-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-common-style');
		ob_start();
		?>
		<div class="swpm-admin-menu-wrap">
			<form action="" method="POST">
			<div class="qcld_instagram_menu_setup">
			
				<h2>Menu Sorting & Customization Area</h2>
				
				<p>In this section you can control the UI of the menu.<br>
	To adjust the Active Menu ordering just drag it up or down. To add a menu item in Active Menu simply drag a menu item from Available Menu and drop it to Active Menu . To remove a menu item from Active Menu simple drag the menu item and drop it to Available Menu.</p>

				<p style="color:red">* After making any changes to buttons label, You must have to remove the button from "Active Menu" and add it back from "Available Menu Items".</p>
				<div class="qc_menu_setup_area">

					<div class="qc_menu_area">
						<h3>Active menu</h3>
						
						<div class="qc_menu_area_container qc_menu_area_sort" id="qc_menu_area">

							<?php echo stripslashes(get_option('qc_wpbot_ig_menu_order')); ?>

						</div>
					</div>

					<div class="qc_menu_list_area" >
						<h3>Available Menu items</h3>
						
						<div class="qc_menu_list_container">
						<p>Predefined Intents</p>
						
						<?php 
						
							if( function_exists( 'qcld_wpbot' ) && property_exists( qcld_wpbot(), 'helper' ) && ( qcld_wpbot()->helper instanceof Qcld_WPBot_Helper ) && method_exists( qcld_wpbot()->helper,'render_start_menu' ) ):
								
						?>
							<?php qcld_wpbot()->helper->render_start_menu(get_locale()); ?>
						<?php else: 
							
							?>
						
						<ul>
							<li>
								<?php if(qcld_wpbot_is_active_livechat()==true): ?>
									<span class="qcld-chatbot-custom-intent qc_draggable_item" data-text="<?php echo (isset($data['qlcd_wp_chatbot_sys_key_livechat']) && $data['qlcd_wp_chatbot_sys_key_livechat']!=''?$data['qlcd_wp_chatbot_sys_key_livechat']:'livechat'); ?>" ><?php echo (isset($data['qlcd_wp_livechat']) && $data['qlcd_wp_livechat']!=''?$data['qlcd_wp_livechat']:'Livechat'); ?></span>
								<?php endif; ?>
							</li>
							<li>
								<span class="qcld-chatbot-default wpbd_subscription qc_draggable_item"><?php echo get_option('qlcd_wp_email_subscription'); ?></span>
							</li>
							
							<li>
								<?php if(get_option('disable_wp_chatbot_site_search')==''): ?>
									<span class="qcld-chatbot-site-search qc_draggable_item" ><?php echo get_option('qlcd_wp_site_search'); ?></span>
								<?php endif; ?>
							
							</li>
							<li>
								<?php if(get_option('disable_wp_chatbot_faq')==''): ?>
								<span class="qcld-chatbot-wildcard qc_draggable_item"  data-wildcart="support"><?php echo get_option('qlcd_wp_chatbot_wildcard_support'); ?></span>
								<?php endif; ?>
							
							</li>

							<li>
								<?php if(get_option('disable_wp_chatbot_feedback')==''): ?>
								<span class="qcld-chatbot-suggest-email qc_draggable_item"><?php echo get_option('qlcd_wp_send_us_email'); ?></span>
								<?php endif; ?>
							
							</li>

							<li>
								<?php if(get_option('disable_wp_leave_feedback')==''): ?>
								<span class="qcld-chatbot-suggest-email wpbd_feedback qc_draggable_item"><?php echo get_option('qlcd_wp_leave_feedback'); ?></span>
								<?php endif; ?>
							
							</li>

							<li>
								<?php if(get_option('disable_wp_chatbot_call_gen')==''): ?>
								<span class="qcld-chatbot-suggest-phone qc_draggable_item" ><?php echo get_option('qlcd_wp_chatbot_support_phone'); ?></span>
								<?php endif; ?>
							
							</li>

							<?php 
								if(function_exists('qcpd_wpwc_addon_lang_init')){
									do_action('qcld_wpwc_start_menu_option_woocommerce');
								}

							?>

						</ul>

						<?php 
						$ai_df = get_option('enable_wp_chatbot_dailogflow');
						$custom_intent_labels = unserialize( get_option('qlcd_wp_custon_intent_label'));
						if($ai_df==1 && isset($custom_intent_labels[0]) && trim($custom_intent_labels[0])!=''):
						?>
						<p>Custom Intents</p>
						<ul>

							<?php foreach($custom_intent_labels as $custom_intent_label): ?>
								<li>
								<span class="qcld-chatbot-custom-intent qc_draggable_item" data-text="<?php echo $custom_intent_label ?>" ><?php echo $custom_intent_label ?></span>

								</li>
							<?php endforeach; ?>
							
						</ul>
						<?php endif; ?>

						<?php
						if(class_exists('Qcformbuilder_Forms_Admin')){
							global $wpdb;

							$results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
							if(!empty($results)){
							?>
							<p>Conversational Form</p>
							<ul>
							<?php
								foreach($results as $result){
									$form = unserialize($result->config);
								?>
									<li><span class="qcld-chatbot-wildcard qcld-chatbot-form qc_draggable_item" data-form="<?php echo $form['ID']; ?>" ><?php echo $form['name']; ?></span></li>
								<?php
								}
								?>
							</ul>
							<?php
							}
						}
						?>
						<?php endif; ?>

						</div>

					</div>
				
				</div>
				
				<input class="qc_wpbot_menu_order" type="hidden" name="qc_wpbot_ig_menu_order" value='<?php echo stripslashes(get_option('qc_wpbot_ig_menu_order')); ?>' />
			
			</div>
			<div style="clear:both"></div>
			<?php submit_button(); ?>
			</form>
		
		</div>
		<style type="text/css">
		.qcld_instagram_menu_setup{width:900px}
		</style>
		<?php 
		$content = ob_get_clean();
		echo $content;
	}
	
	public function wpig_register_plugin_settings(){
		register_setting( 'qc-wpig-plugin-settings-group', 'wpig_enable_fbbot' );
		register_setting( 'qc-wpig-plugin-settings-group', 'wpig_verify_token' );
		register_setting( 'qc-wpig-plugin-settings-group', 'wpig_page_access_token' );
		register_setting( 'qc-wpig-plugin-settings-group', 'wpig_default_instruction' );
		register_setting( 'qc-wpig-plugin-settings-group', 'wpig_default_no_match' );
		register_setting( 'qc-wpig-plugin-settings-group', 'wpig_command_live_agent' );
		register_setting( 'qc-wpig-plugin-settings-group', 'wpig_contact_admin_text' );
		register_setting( 'qc-wpig-plugin-settings-group', 'wpig_remove_image' );
		register_setting( 'qc-wpig-plugin-settings-group', 'wpig_remove_video' );
		register_setting( 'qc-wpig-plugin-settings-group', 'wpbot_ig_search_enable' );
		
		if(isset($_POST['qc_wpbot_ig_menu_order'])){
			update_option('qc_wpbot_ig_menu_order', $_POST['qc_wpbot_ig_menu_order']);
		}
		
	}
	
	public function wbig_setting_page(){
		wp_enqueue_style('qc_instagram_chatbot_admin_styles', WBIG_URL . '/assets/css/style.css');
		?>
	<div class="wrap swpm-admin-menu-wrap">
		<h1><?php echo esc_html__('Instagram Chatbot Settings Page', 'wpfb'); ?></h1>
	
		<h2 class="nav-tab-wrapper sld_nav_container">
			<a class="nav-tab sld_click_handle nav-tab-active" href="#general_settings"><?php echo esc_html__('General Settings', 'wpfb'); ?></a>
		</h2>
		
		<h2 class="qcfb_msg_heading" ><?php echo esc_html__('You can follow the step by step instructions for setting up FaceBook App and other settings in our KnowledgeBase.', 'wpfb'); ?> <a href="<?php echo esc_url('https://dev.quantumcloud.com/wpbot-pro/instagram-chatbot-addon-setup/'); ?>" class="button button-primary" target="_blank"><?php echo esc_html__('View KnowledgeBase', 'wpfb'); ?></a></h2>
		
		<form method="post" action="options.php">
			<?php settings_fields( 'qc-wpig-plugin-settings-group' ); ?>
			<?php do_settings_sections( 'qc-wpig-plugin-settings-group' ); ?>
			<div id="general_settings">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Enable Instagram Bot', 'wpfb'); ?></th>
						<td>
							<input type="checkbox" name="wpig_enable_fbbot" value="on" <?php echo (esc_attr( get_option('wpig_enable_fbbot') )=='on'?'checked="checked"':''); ?> />
							<i><?php echo esc_html__('Turn ON to enable instagram bot on top of WPBot.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Instagram Verify Token', 'wpfb'); ?></th>
						<td>
							<input type="text" name="wpig_verify_token" size="100" value="<?php echo esc_attr( get_option('wpig_verify_token') ); ?>"  />
							<i><?php echo esc_html__('Please add a verify token and also you have to put the same token in facebook app settings. The token could be anything random unique character. Ex: sdf343sdfaewrf2343234ff.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Page Access Token', 'wpfb'); ?></th>
						<td>
							<input type="text" name="wpig_page_access_token" size="100" value="<?php echo esc_attr( get_option('wpig_page_access_token') ); ?>"  />
							<i><?php echo esc_html__('Please add a Page Access Token which you can find in Facebook App.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					<?php if(qcpdmca_is_wpbot_active_ig()): ?>
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Callback URL', 'wpfb'); ?> </th>
						<td>
							
							<input type="text" name="wpig_callback_url" size="100" value="<?php echo esc_url(get_site_url().'/?action=iginteraction'); ?>" readonly />
							<i><?php echo esc_html__('Please copy the url and add it to the Callback URL field in Webhooks section in Facebook App.', 'wpfb'); ?></i>
						</td>
					</tr>
					<?php endif; ?>
					
					<?php if(qcpdmca_is_woowbot_active_ig()): ?>
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Callback URL', 'wpfb'); ?> <?php echo esc_html(mca_woowbot_text_ig()); ?></th>
						<td>
							
							<input type="text" name="wpig_callback_url_wow" size="100" value="<?php echo esc_url(get_site_url().'/?action=iginteractionwow'); ?>" readonly />
							<i><?php echo esc_html__('Please copy the url and add it to the Callback URL field in Webhooks section in Facebook App.', 'wpfb'); ?></i>
						</td>
					</tr>
					<?php endif; ?>
					
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Default Instruction Message', 'wpfb'); ?></th>
						<td>
							
							<input type="text" name="wpig_default_instruction" size="100" value="<?php echo (get_option('wpig_default_instruction')!=''?get_option('wpig_default_instruction'):esc_html__('For main menu type Start and hit enter. Or type anything related to our services.', 'wpfb')); ?>"  />
							
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Default No Match Reply', 'wpfb'); ?></th>
						<td>
							
							<input type="text" name="wpig_default_no_match" size="100" value="<?php echo (get_option('wpig_default_no_match')!=''?get_option('wpig_default_no_match'):esc_html__('Sorry, nothing matched your query. Please select from Start menu below.', 'wpfb')); ?>"  />
							
						</td>
					</tr>
					
					<!--<tr valign="top">
						<th scope="row" class="qcfb_text_color_red"><?php echo esc_html__('Handover Protocol', 'wpfb'); ?></th>
						<td>
							
							
							<p class="qcfb_text_color_red">
							
							<?php
							 
							 
							 $allowed_tags = array(
								'b' => array()
								
							 );
							 echo wp_kses( 'Handover Protocol allows you to respond to customer messages as the page admin - taking over from the ChatBot. Once set up you can take over the conversation from the ChatBot by replying from your Inbox. In order to use Handover Protocol, you have to go to your <b>page settings > Instagram Platform > General Settings</b> and selete the "<b>Response Method</b>" as "<b>Responses are partially automated, with some support by people</b>". After that click on the "<b>Configure</b>" button of App Settings then choose your "<b>Facebook App</b>" as "<b>Responses are partially automated, with some support by people</b>" and choose "<b>Page Inbox</b>" as "<b>Secondary Receiver for Handover Protocol</b>". That\'s it.', $allowed_tags ); ?>
							
							
							</p>
							<br>
							<span><img class="qcfb_example_image_1" src="<?php echo esc_url(WBIG_URL.'assets/images/instagram_handover1.jpg'); ?>" />
							<img class="qcfb_example_image_2" src="<?php echo esc_url(WBIG_URL.'assets/images/instagram_handover2.jpg'); ?>" />
							</span>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Command for customer service with live agents', 'wpfb'); ?></th>
						<td>
							
							<input type="text" name="wpig_command_live_agent" size="100" value="<?php echo (get_option('wpig_command_live_agent')!=''?get_option('wpig_command_live_agent'):' Livechat'); ?>"  />
							
							<p class="qcfb_text_color_red">
							<?php
							 
							 
							 $allowed_tags = array(
								'b' => array()
								
							 );
							 echo wp_kses( 'When user type the command "<b>Livechat</b>" the bot will pass the thread control to page inbox so admin can reply to the users message. When page admin done with the conversation then page admin need to "Mark as Done" the conversation in order to take the thread control back to the bot.', $allowed_tags ); ?>
							
							</p>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('You are contacting admin of this page.', 'wpfb'); ?></th>
						<td>
							
							<input type="text" name="wpig_contact_admin_text" size="100" value="<?php echo (get_option('wpig_contact_admin_text')!=''?get_option('wpig_contact_admin_text'):esc_html__('You are contacting admin of this page. Please type your question below.', 'wpfb')); ?>"  />
							
						</td>
					</tr>-->
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Remove Image URL from Reply', 'wpfb'); ?></th>
						<td>
							<input type="checkbox" name="wpig_remove_image" value="on" <?php echo (esc_attr( get_option('wpig_remove_image') )=='on'?'checked="checked"':''); ?> />
							<i><?php echo esc_html__('Turn ON to remove image url from reply.', 'wpfb'); ?></i>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Remove youtube URL from Reply', 'wpfb'); ?></th>
						<td>
							<input type="checkbox" name="wpig_remove_video" value="on" <?php echo (esc_attr( get_option('wpig_remove_video') )=='on'?'checked="checked"':''); ?> />
							<i><?php echo esc_html__('Turn ON to remove youtube url from reply.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Disable Site Search for Instagram', 'wpfb'); ?></th>
						<td>
							<input type="checkbox" name="wpbot_ig_search_enable" value="1" <?php echo (esc_attr( get_option('wpbot_ig_search_enable') )=='1'?'checked="checked"':''); ?> />
							<i><?php echo esc_html__('Disable site search for instagram.', 'wpfb'); ?></i>
						</td>
					</tr>

				</table>
			</div>
			
			
			

			
			<?php submit_button(); ?>

		</form>
		
	</div>

	<?php
	}
	
}
new wbig_Admin_Area_Controller();