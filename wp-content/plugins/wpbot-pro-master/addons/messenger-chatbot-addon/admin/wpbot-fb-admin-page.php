<?php
/*
* Messenger settings area
*/

class wbfb_Admin_Area_Controller {
	
	function __construct(){
		add_action( 'admin_menu', array($this,'wbfb_admin_menu') );
		add_action( 'admin_init', array($this, 'wpfb_register_plugin_settings') );
        add_action('admin_enqueue_scripts', array($this, 'qcld_wpfb_admin_scripts'));
		add_action('init', array($this, 'wpfb_check_fb_session'));

        add_action( 'admin_post_enable_bot', array(&$this, 'enable_bot') );
        add_action( 'admin_post_disable_bot', array(&$this, 'disable_bot') );
        add_action( 'admin_post_import_old_subscriber', array(&$this, 'import_old_subscriber') );
		add_action( 'admin_post_qc_fb_broadcast', array(&$this, 'send_broadcast'));
		add_filter( 'custom_menu_order', array( &$this, 'submenu_order' ) );
	}

	public function submenu_order( $menu_ord ) {
		global $submenu;
		
		$arr = array();
		$arr[] = $submenu['wbfb-botsetting-page'][0];
		$arr[] = $submenu['wbfb-botsetting-page'][1];
		$arr[] = $submenu['wbfb-botsetting-page'][2];
		$arr[] = $submenu['wbfb-botsetting-page'][4];
		//$arr[] = $submenu['wbfb-botsetting-page'][5];
		$arr[] = $submenu['wbfb-botsetting-page'][3];
		$submenu['wbfb-botsetting-page'] = $arr;
		return $submenu;
	}
	
	public function send_broadcast(){
		global $wpdb;
		if(isset($_POST['fbbroadcastsubmit'])){
			
			$broadcast = $_POST['broadcast'];
			$template = sanitize_text_field( $_POST['template'] );
			$pageId = sanitize_text_field($_POST['pageid']);
			$rdurl = esc_url_raw($_POST['pageurl']);
			$access_token = qcpd_wpfb_get_accesstoken_from_id($pageId);
			
			$jsonData = '';
			if( 'generic' === $template ) {
				$jsonData = $this->generate_generic_json();
			} elseif( 'button' === $template ) {
				$jsonData = $this->generate_button_json();
			} elseif( 'media' === $template ) {
				$jsonData = $this->generate_media_json();
			} elseif( 'product' === $template ) {
				$jsonData = $this->generate_product_json();
			}

			//Bail if not data or invalid form submit
			if( empty( $jsonData ) ){
				wp_redirect($rdurl.'&status=failed');exit;
			}
			$tableuser    = $wpdb->prefix.'wpbot_fb_subscribers';
			$allsubscribers = $wpdb->get_results("select * from $tableuser where 1 and page_id = '$pageId'");

			foreach($allsubscribers as $subscriber):
				$subscriber_name = $subscriber->name;
				
				//Apply variables
				$jsonData = str_replace( array( '#subscriber_id', '#name' ), array( $subscriber->subscriber_id, $subscriber_name ), $jsonData );
				
				//sending broadcast message to all subscribers
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);
				
			endforeach;
			$broadcast['template'] = $template;
			// Adding broadcast record to database
			$tablebroadcast = $wpdb->prefix.'wpbot_fb_broadcasts';
			$wpdb->insert(
				$tablebroadcast,
				array(
					'date'  => current_time( 'mysql' ),
					'page_id'   => $pageId,
					'message'   => serialize($broadcast),
				)
			);
			
			//after complete all operation redirect to previous page
			wp_redirect($rdurl.'&status=success');

		}
	}

	public function generate_generic_json() {
		//bail if form is not submitted.
		if( ! isset( $_POST['broadcast'] ) || empty( $_POST['broadcast'] ) ) {
			return '';
		}

		$broadcast = $_POST['broadcast'];
		$buttons = '';
		if(isset($broadcast['buttons']) and !empty($broadcast['buttons'])){
			foreach($broadcast['buttons'] as $key => $button){
				$buttons .= '{
						"type":"web_url",
						"url":"'.esc_url_raw($button['link']).'",
						"title":"'.sanitize_text_field($button['title']).'"
					},';
			}
		}
		$jsonData = '{
			"recipient": {
			  "id": "#subscriber_id"
			},
			"message":{
				  "attachment":{
					"type":"template",
					"payload":{
					  "template_type":"generic",
					  "elements":[
						  {
							"title":"'.sanitize_text_field( $broadcast['title'] ).'",
							"image_url":"'.esc_url_raw( $broadcast['image'] ).'",
							"subtitle":"'.sanitize_text_field($broadcast['subtitle']).'",
							"buttons":[
							  '.$buttons.'              
							]      
						  }
					  ]
					}
				  }
			  }
			
		}';
		return $jsonData;
	}

	public function generate_button_json() {
		//bail if form is not submitted.
		if( ! isset( $_POST['broadcast'] ) || empty( $_POST['broadcast'] ) ) {
			return '';
		}

		$broadcast = $_POST['broadcast'];
		$buttons = '';
		if(isset($broadcast['buttons']) and !empty($broadcast['buttons'])){
			foreach($broadcast['buttons'] as $key => $button){
				$buttons .= '{
						"type":"web_url",
						"url":"'.esc_url_raw($button['link']).'",
						"title":"'.sanitize_text_field($button['title']).'"
					},';
			}
		}
		$jsonData = '{
			"recipient": {
			  "id": "#subscriber_id"
			},
			"message":{
				  "attachment":{
					"type":"template",
					"payload":{
					  "template_type":"button",
					  "text":"'.sanitize_text_field( $broadcast['title'] ).'",
					  "buttons":[
						'.$buttons.'
					  ]
					}
				  }
			  }
			
		}';
		return $jsonData;
	}

	public function generate_media_json() {
		//bail if form is not submitted.
		if( ! isset( $_POST['broadcast'] ) || empty( $_POST['broadcast'] ) ) {
			return '';
		}

		$broadcast = $_POST['broadcast'];
		$jsonData = '"recipient":{
			"id":"#subscriber_id"
		  },
		  "message":{
			"attachment": {
			  "type": "template",
			  "payload": {
				 "template_type": "media",
				 "elements": [
					{
					   "media_type": "image",
					   "url": "'.esc_url_raw( $broadcast['image'] ).'",
					   "buttons": [
						  {
							 "type": "web_url",
							 "url": "'.sanitize_text_field( $broadcast['button']['link'] ).'",
							 "title": "'.sanitize_text_field( $broadcast['button']['title'] ).'",
						  }
					   ]
					}
				 ]
			  }
			}    
		  }';

		return $jsonData;
	}

	public function generate_product_json() {
		//bail if form is not submitted.
		if( ! isset( $_POST['broadcast'] ) || empty( $_POST['broadcast'] ) ) {
			return '';
		}

		$broadcast = $_POST['broadcast'];
		$jsonData = '{
			"recipient":{
				"id":"#subscriber_id"
			},
			"message":{
				"attachment":{
					"type":"template",
					"payload":{
						"template_type":"generic",
						"elements":[
							{
								"title":"'.sanitize_text_field( $broadcast['title'] ).'",
								"subtitle": "'.sanitize_text_field( $broadcast['price'] ).'",
								
								"image_url":"'.esc_url_raw( $broadcast['image'] ).'",
								"default_action": {
									"type": "web_url",
									"url": "'.esc_url_raw( $broadcast['link'] ).'",
									"webview_height_ratio": "tall",
								}
							}
						]
					}
				}
			}
		}';
		return $jsonData;
	}
	
	public function import_old_subscriber(){
		
		global $wpdb;
		$table = $wpdb->prefix.'wpbot_fb_subscribers';
		
		$pageid = sanitize_text_field($_GET['pageid']);
		$access_token = qcpd_wpfb_get_accesstoken_from_id($pageid);

		$url = "https://graph.facebook.com/v3.3/$pageid/conversations?access_token=$access_token&limit=500&fields=participants,message_count,unread_count,is_subscribed,snippet,id,updated_time,link";
		$res = qcwp_curl_fb_get($url);
		$results = json_decode($res, true);
		
		if(isset($results['data']))
		{
			foreach($results['data'] as $thread_info)
			{
				$participant_data = array();
				foreach($thread_info['participants']['data'] as $participant_info){
					$user_id = $participant_info['id'];
					if($user_id!=$pageid){
						$participant_data = array(
							'page_id'   => $pageid,
							'subscriber_id'   => $user_id,
							'name'   => $participant_info['name'],
						);
					}
				}

				$participant_data['is_subscribed'] = $thread_info['is_subscribed'];
				$format = array('%d','%d', '%s', '%d');

				$subscriber_exists = $wpdb->get_row("select * from $table where 1 and page_id = '".$participant_data['page_id']."' and subscriber_id = '". $participant_data['subscriber_id'] ."'");

				if ( ! empty( $subscriber_exists ) ) {
					$where = array( 'id' => $subscriber_exists->id );
                	$whereformat = array( '%d' );
					$wpdb->update( $table, $participant_data, $where, $format, $whereformat );
				} else {
					$wpdb->insert( $table, $participant_data, $format );
				}
				

			}
		}
		wp_redirect(admin_url('admin.php?page=wpbot-fb-private-replies&sub=subscriber&fbpage='.$pageid));exit;

	}
	
	public function enable_bot(){
		
		$pageid = sanitize_text_field($_GET['pageid']);
		$access_token = qcpd_wpfb_get_accesstoken_from_id($pageid);
		
		$params = array("messages", "messaging_optins", "messaging_postbacks", "messaging_referrals", "message_deliveries", "message_reads", "feed");

		$postfields = "subscribed_fields=".implode(',', $params)."&access_token=$access_token";
		$url = "https://graph.facebook.com/v11.0/$pageid/subscribed_apps";
		
		$res = qcwpbot_send_response($postfields, $url);
		$res = json_decode($res, true);
		
		if(isset($res['success']) && $res['success']=='1'){
			update_option('bot_'.$pageid, 'on');
		}
		ob_start();
		qcpd_wpfb_get_started_button($access_token);
		ob_end_clean();

		wp_redirect(admin_url('admin.php?page=wpbot-fb-private-replies&success=bot_enabled'));exit;
		
	}
	public function disable_bot(){
		
		$pageid = sanitize_text_field($_GET['pageid']);
		$access_token = qcpd_wpfb_get_accesstoken_from_id($pageid);
		$url = "https://graph.facebook.com/v11.0/$pageid/subscribed_apps?access_token=$access_token";
		$res = qcwpbot_delete_response($url);
		$res = json_decode($res, true);
		
		if(isset($res['success']) && $res['success']=='1'){
			update_option('bot_'.$pageid, 'off');
		}
		wp_redirect(admin_url('admin.php?page=wpbot-fb-private-replies&success=bot_disabled'));exit;
		
	}
	
	public function wpfb_check_fb_session(){

		if( isset( $_GET['pages_data'] ) && $_GET['pages_data'] != '' ){
			$pages = $_GET['pages_data'];
			$pages = preg_replace('/\\\\/', '', $pages);
			$pages = json_decode( $pages, true );
			foreach($pages as $page){				
				wpfb_insert_into_database($page);
			}
			wp_redirect( admin_url('admin.php?page=wpbot-fb-private-replies') );
		}

		if(isset($_GET['page']) && $_GET['page']=='wpbot-fb-private-replies'){
			
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			
			if(get_option('wpfb_app_id')!='' && get_option('wpfb_app_secret')!=''){
				
				$fb = new Facebook\Facebook([
					'app_id' => get_option('wpfb_app_id'),
					'app_secret' => get_option('wpfb_app_secret'),
					'default_graph_version' => 'v4.0',
				 ]);
				 
				$helper = $fb->getRedirectLoginHelper();
				
				$_SESSION['FBRLH_state']=$_GET['state'];
				try {
					if (isset($_SESSION['facebook_access_token'])) {
						$accessToken = $_SESSION['facebook_access_token'];
					} else {
						
						$accessToken = $helper->getAccessToken();
						
					}
				} catch(Facebook\Exceptions\FacebookResponseException $e) {
					// When Graph returns an error
					echo 'Graph returned an error: ' . $e->getMessage();

					exit;
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
					// When validation fails or other local issues
					echo 'Facebook SDK returned an error: ' . $e->getMessage();
					exit;
				}
				
				if (isset($accessToken)) {
					
					if (isset($_SESSION['facebook_access_token'])) {
						$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
					} else {
						// getting short-lived access token
						$_SESSION['facebook_access_token'] = (string) $accessToken;

						// OAuth 2.0 client handler
						$oAuth2Client = $fb->getOAuth2Client();

						// Exchanges a short-lived access token for a long-lived one
						$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

						$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

						// setting default access token to be used in script
						$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
						update_option('wpfb_user_access_token', $_SESSION['facebook_access_token']);
					}
					unset($_SESSION['facebook_access_token']);
					
					
					if(get_option('wpfb_user_access_token')!=''){
		
						$user_access_token = get_option('wpfb_user_access_token');
							
						$url2 = "https://graph.facebook.com/v3.3/me/accounts?fields=cover,emails,picture,id,name,url,username,access_token&limit=400&access_token=$user_access_token";
						$pages = qcwpfb_get_fbpost_content($url2);

						if(isset($pages['data']) && !empty($pages['data'])){
							
							foreach($pages['data'] as $page){
								
								wpfb_insert_into_database($page);
								
							}

						}
							
						
						add_action('wpbot_fb_success_msg', array($this, 'account_import_success_message') );
					}
					
				}
				
				if(isset($_GET['success']) && $_GET['success']=='bot_enabled'){
					add_action('wpbot_fb_bot_enable_success_msg', array($this, 'bot_enabled_success_message') );
				}
				if(isset($_GET['success']) && $_GET['success']=='bot_disabled'){
					add_action('wpbot_fb_bot_disable_success_msg', array($this, 'bot_disabled_success_message') );
				}
				
			}
			
			if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['fbpage']) && $_GET['fbpage']!=''){
				global $wpdb;
				$table    = $wpdb->prefix.'wpbot_fb_pages';
				$fbpage = sanitize_text_field($_GET['fbpage']);
				
				$allposts = get_posts(array(
					'numberposts'	=> -1,
					'post_type'		=> 'wpfbposts',
					'meta_key'		=> 'fb_page_id',
					'meta_value'	=> $fbpage
				));
				foreach($allposts as $post){
					wp_delete_post($post->ID);
				}
				
				$wpdb->delete(
					$table,
					array( 'page_id' => $fbpage ),
					array( '%s' )
				);
				delete_option('bot_'.$pageid);
				
				add_action('wpbot_fb_page_delete_msg', array($this, 'page_delete_success_message') );
				
			}
			
		}
	}
	
	public function account_import_success_message(){
		?>
		<div id="message" class="updated notice is-dismissible rlrsssl-success">
                <p>Facebook pages imported successfully!</p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
		<?php
	}
	
	public function page_delete_success_message(){
		?>
		<div id="message" class="updated notice is-dismissible rlrsssl-success">
                <p>Facebook page has been deleted successfully!</p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
		<?php
	}
	
	public function bot_enabled_success_message(){
		?>
		<div id="message" class="updated notice is-dismissible rlrsssl-success">
                <p>Bot has been enabled successfully!</p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
		<?php
	}
	public function bot_disabled_success_message(){
		?>
		<div id="message" class="updated notice is-dismissible rlrsssl-success">
                <p>Bot has been disabled successfully!</p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
		<?php
	}
	
	public function qcld_wpfb_admin_scripts(){
		wp_enqueue_media();

		wp_register_script('qcld-wpfb-chatbot-datetime-jquery', WBFB_URL . '/assets/js/jquery.datetimepicker.full.min.js', array('jquery'));
        wp_enqueue_script('qcld-wpfb-chatbot-datetime-jquery');
		
		wp_register_style('qcld-wpfb-chatbot-datetime-style', WBFB_URL . '/assets/css/jquery.datetimepicker.min.css');
        wp_enqueue_style('qcld-wpfb-chatbot-datetime-style');

		wp_enqueue_script('qcfb-wpfb-chatbot-adminapi-js', WBFB_URL . '/assets/js/admin_script.js', array('jquery'), time());
        wp_enqueue_script('qcfb-wpfb-chatbot-adminapi-js');

		ob_start();
		include WBFB_PATH . 'admin/template/js/private-reply-condition-html.php';
		$content = ob_get_contents();
		ob_end_clean();

		ob_start();
		include WBFB_PATH . 'admin/template/js/comment-reply-condition-html.php';
		$comment_content = ob_get_contents();
		ob_end_clean();
		
		wp_localize_script( 'qcfb-wpfb-chatbot-adminapi-js', 'object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'ajax_nonce' => wp_create_nonce('wpbotfbreload123pages'), 'private_repeater_html' => $content, 'comment_repeater_html' => $comment_content ) );
		wp_enqueue_style('qc_messenger_chatbot_admin_styles', WBFB_URL . '/assets/css/style.css');	
		wp_enqueue_style('qc_messenger_chatbot_admin_fonts_styles', WBFB_URL . '/assets/css/font-awesome.min.css');	
	}
	public function wbfb_admin_menu(){

        if ( current_user_can( 'publish_posts' ) ){
			
			
			add_menu_page( 'Bot - Messenger', 'Bot - Messenger', 'publish_posts', 'wbfb-botsetting-page', array( $this, 'wbfb_setting_page' ), 'dashicons-facebook', '9' );
			
			add_submenu_page( 'wbfb-botsetting-page', 'Manage FB Pages', 'Manage FB Pages', 'manage_options','wpbot-fb-private-replies', array($this, 'fb_private_replies'), 5 );

			if(class_exists('qcld_wb_Chatbot')){
				add_submenu_page( 'wbfb-botsetting-page', 'FB Menu Setup', 'FB Menu Setup', 'manage_options','messenger-chatbot-fb-menu', array($this, 'qcld_messenger_fb_menu'), 5 );
			}
			
			//add_submenu_page( 'wbfb-botsetting-page', 'Help & License', 'Help & License', 'manage_options','messenger-chatbot-help-license', array($this, 'qcld_license_callback'), 15 );
        }
		
    }

	public function qcld_messenger_fb_menu(){
		
		
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
			<div class="qcld_messenger_menu_setup">
			
				<h2>Menu Sorting & Customization Area</h2>
				
				<p>In this section you can control the UI of the menu.<br>
	To adjust the Active Menu ordering just drag it up or down. To add a menu item in Active Menu simply drag a menu item from Available Menu and drop it to Active Menu . To remove a menu item from Active Menu simple drag the menu item and drop it to Available Menu.</p>

				<p style="color:red">* After making any changes to buttons label, You must have to remove the button from "Active Menu" and add it back from "Available Menu Items".</p>
				<div class="qc_menu_setup_area">

					<div class="qc_menu_area">
						<h3>Active menu</h3>
						
						<div class="qc_menu_area_container qc_menu_area_sort" id="qc_menu_area">

							<?php echo stripslashes(get_option('qc_wpbot_fb_menu_order')); ?>

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
				
				<input class="qc_wpbot_menu_order" type="hidden" name="qc_wpbot_fb_menu_order" value='<?php echo stripslashes(get_option('qc_wpbot_fb_menu_order')); ?>' />
			
			</div>
			<div style="clear:both"></div>
			<?php submit_button(); ?>
			</form>
		
		</div>
		<style type="text/css">
		.qcld_messenger_menu_setup{width:900px}
		</style>
		<?php 
		$content = ob_get_clean();
		echo $content;
	}
	
	public function wpfb_register_plugin_settings(){
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_enable_fbbot' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_enable_built_in_app' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_verify_token' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_app_id' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_app_secret' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_user_access_token' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_page_access_token' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_default_instruction' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_default_no_match' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_command_live_agent' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_contact_admin_text' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_remove_image' );
		register_setting( 'qc-wpfb-plugin-settings-group', 'wpfb_remove_video' );

		if(isset($_POST['qc_wpbot_fb_menu_order'])){
			update_option('qc_wpbot_fb_menu_order', $_POST['qc_wpbot_fb_menu_order']);
		}
		
	}
	public function fb_private_replies(){
		global $wpdb;
		$table = $wpdb->prefix.'wpbot_fb_pages';

		if(get_option('wpfb_app_id')!='' && get_option('wpfb_app_secret')!=''){
			
			$fb = new Facebook\Facebook([
				'app_id' => get_option('wpfb_app_id'),
				'app_secret' => get_option('wpfb_app_secret'),
				'default_graph_version' => 'v4.0',
			 ]);

			$helper = $fb->getRedirectLoginHelper();

			//$permissions = ['email','manage_pages','publish_pages','pages_show_list','pages_messaging','public_profile','read_insights']; // 
			$permissions = ['email','pages_read_engagement','pages_manage_engagement','pages_show_list','pages_messaging','public_profile', 'pages_manage_metadata']; // 
			$loginUrl = $helper->getLoginUrl(admin_url('admin.php?page=wpbot-fb-private-replies'), $permissions);

		}else{
			$loginUrl = '';
		}
		
		if ( get_option('wpfb_enable_built_in_app') == 'on' ) {
			$loginUrl = WBFB_API_URL . "?site_url=".site_url()."&qc_connector=1";
		}

		if(isset($_GET['sub']) && $_GET['sub']=='subscriber' && isset($_GET['fbpage']) && $_GET['fbpage']!=''){
			
			include_once WBFB_PATH.'/admin/subscribers.php';
			
		}elseif(isset($_GET['sub']) && $_GET['sub']=='broadcast' && isset($_GET['fbpage']) && $_GET['fbpage']!=''){
			
			include_once WBFB_PATH.'/admin/broadcast.php';
			
		}elseif(isset($_GET['sub']) && $_GET['sub']=='broadcast_report' && isset($_GET['fbpage']) && $_GET['fbpage']!=''){
			
			include_once WBFB_PATH.'/admin/broadcast.php';
			
		}else{
		
		?>
		<?php do_action('wpbot_fb_success_msg'); ?>
		<?php do_action('wpbot_fb_page_delete_msg'); ?>
		<?php do_action('wpbot_fb_bot_enable_success_msg'); ?>
		<?php do_action('wpbot_fb_bot_disable_success_msg'); ?>
		<div class="wrap swpm-admin-menu-wrap">
			<h1><?php echo esc_html__('Manage FB Pages', 'wpfb'); ?></h1>
			<div class="wpfb_pages_header">
				<a href="<?php echo esc_url($loginUrl); ?>" class="button button-primary" ><i class="fa fa-facebook-official" aria-hidden="true"></i> &nbsp;Login with Facebook</a>
				<!--<button class="button button-primary" id="wpfb_reload_pages">Reload Pages</button>-->
				<span class="wpfb_pages_loading" style="display:none"> Loading... </span>
				
			</div>
			
					
				<?php 
					$pages = $wpdb->get_results("SELECT * FROM {$table} where 1 ");
					if(!empty($pages)){
						?>
						<div class="wpfb_pages_content_area">
						<h2>Your Facebook pages</h2>
							<table class="form-table">
						<?php
						foreach($pages as $page){
							?>

							<tr valign="top">
								<th scope="row" class="wpfb_page_name"><span><?php echo esc_html($page->page_name); ?></span></th>
								<td>
									<?php if(get_option('bot_'.$page->page_id)=='on'): ?>
										<a class="button-primary" href="<?php echo admin_url( 'admin-post.php?action=disable_bot&pageid='.$page->page_id ); ?>" title="The bot is enabled currently. Click to disable bot."><i class="fa fa-minus-square" aria-hidden="true"></i> Disable Bot</a>
									<?php else: ?>
										<a class="button-primary" href="<?php echo admin_url( 'admin-post.php?action=enable_bot&pageid='.$page->page_id ); ?>" title="The bot is not enabled now. Click to enable bot."> <i class="fa fa-check" aria-hidden="true"></i> Enable Bot</a>
									<?php endif; ?>
									
									<a href="<?php echo admin_url('admin.php?page=wpbot-fb-private-replies&sub=subscriber&fbpage='.$page->page_id) ?>" class="button button-primary"><i class="fa fa-users" aria-hidden="true"></i> Manage Subscribers</a>
									
									<a href="<?php echo admin_url('admin.php?page=wpbot-fb-private-replies&sub=broadcast&fbpage='.$page->page_id) ?>" class="button button-primary"><i class="fa fa-bullhorn" aria-hidden="true"></i> Manage Broadcasts</a>
									
									<a href="<?php echo admin_url('edit.php?post_type=wpfbposts&fbpage='.$page->page_id.'&filter_action=Filter&paged=1') ?>" class="button button-primary"><i class="fa fa-reply-all" aria-hidden="true"></i> Manage Posts Reply</a>
									<a href="<?php echo admin_url('admin.php?page=wpbot-fb-private-replies&action=delete&fbpage='.$page->page_id) ?>" class="button button-primary" onclick="return confirm('Are you sure you want to delete this page?');"><i class="fa fa-trash" aria-hidden="true"></i> Delete Page</a>
									
								</td>
							</tr>
							
							<?php
						}
						?>
							</table>
						</div>
						<?php
					}else{
						?>
						<p><?php echo esc_html('You do not have any facebook pages to manage. Please login with facebook to import your pages.'); ?></p>
						<?php
					}

				?>
		</div>
		<?php
		}
	}
	public function wbfb_setting_page(){
		
		?>
	<div class="wrap swpm-admin-menu-wrap">
		<h1><?php echo esc_html__('Facebook Bot Settings Page', 'wpfb'); ?></h1>
	
		<h2 class="nav-tab-wrapper sld_nav_container">
			<a class="nav-tab sld_click_handle nav-tab-active" href="#general_settings"><?php echo esc_html__('General Settings', 'wpfb'); ?></a>
		</h2>
		
		<h2 class="qcfb_msg_heading" ><?php echo esc_html__('You can follow the step by step instructions for setting up FaceBook App and other settings in our KnowledgeBase.', 'wpfb'); ?> <a href="<?php echo esc_url('https://dev.quantumcloud.com/wpbot-pro/facebook-app-setup-for-messenger-chatbot-addon/'); ?>" class="button button-primary" target="_blank"><?php echo esc_html__('View KnowledgeBase', 'wpfb'); ?></a></h2>
		
		<form method="post" action="options.php">
			<?php settings_fields( 'qc-wpfb-plugin-settings-group' ); ?>
			<?php do_settings_sections( 'qc-wpfb-plugin-settings-group' ); ?>
			<div id="general_settings">
				<table class="form-table">

					<!--<tr valign="top">
						<th scope="row"><?php echo esc_html__('Use built-in Facebook App', 'wpfb'); ?></th>
						<td>
							<input type="checkbox" name="wpfb_enable_built_in_app" value="on" <?php echo (esc_attr( get_option('wpfb_enable_built_in_app') )=='on'?'checked="checked"':''); ?> />
							<i><?php echo esc_html__('Turn ON to use build-in Facebook App and skip all FB App settings', 'wpfb'); ?></i>
						</td>
					</tr>-->

					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Enable Facebook Bot', 'wpfb'); ?></th>
						<td>
							<input type="checkbox" name="wpfb_enable_fbbot" value="on" <?php echo (esc_attr( get_option('wpfb_enable_fbbot') )=='on'?'checked="checked"':''); ?> />
							<i><?php echo esc_html__('Turn ON to enable facebook bot on top of WPBot.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					<tr valign="top" class="qcld_app_setting" <?php echo (get_option('wpfb_enable_built_in_app')=='on'?'style="display:none"':''); ?>>
						<th scope="row"><?php echo esc_html__('Facebook App ID', 'wpfb'); ?></th>
						<td>
							<input type="text" name="wpfb_app_id" size="100" value="<?php echo esc_attr( get_option('wpfb_app_id') ); ?>"  />
							<i><?php echo esc_html__('Please add your App ID from Facebook App Dashboard.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					<tr valign="top" class="qcld_app_setting" <?php echo (get_option('wpfb_enable_built_in_app')=='on'?'style="display:none"':''); ?>>
						<th scope="row"><?php echo esc_html__('Facebook App Secret', 'wpfb'); ?></th>
						<td>
							<input type="text" name="wpfb_app_secret" size="100" value="<?php echo esc_attr( get_option('wpfb_app_secret') ); ?>"  />
							<i><?php echo esc_html__('Please add your App Secret from Facebook App Dashboard.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					<tr valign="top" style="display:none">
						<th scope="row"><?php echo esc_html__('User Access Token', 'wpfb'); ?></th>
						<td>
							<input type="text" name="wpfb_user_access_token" size="100" value="<?php echo esc_attr( get_option('wpfb_user_access_token') ); ?>"  />
							<i><?php echo esc_html__('Please add a User Access Token which you can find in your Facebook App Dashboard.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					<tr valign="top" style="display:none">
						<th scope="row"><?php echo esc_html__('Page Access Token', 'wpfb'); ?></th>
						<td>
							<input type="text" name="wpfb_page_access_token" size="100" value="<?php echo esc_attr( get_option('wpfb_page_access_token') ); ?>"  />
							<i><?php echo esc_html__('Please add a Page Access Token which you can find in Messenger Settings page in Access Tokens section.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					<tr valign="top" class="qcld_app_setting" <?php echo (get_option('wpfb_enable_built_in_app')=='on'?'style="display:none"':''); ?>>
						<th scope="row"><?php echo esc_html__('Facebook Verify Token', 'wpfb'); ?></th>
						<td>
							<input type="text" name="wpfb_verify_token" size="100" value="<?php echo esc_attr( get_option('wpfb_verify_token') ); ?>"  />
							<i><?php echo esc_html__('Please add a verify token and also you have to put the same token in facebook messenger app settings. The token could be anything random unique character. Ex: sdf343sdfaewrf2343234ff.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					
					<tr valign="top" class="qcld_app_setting" <?php echo (get_option('wpfb_enable_built_in_app')=='on'?'style="display:none"':''); ?>>
						<th scope="row"><?php echo esc_html__('Facebook OAuth Redirect URIs', 'wpfb'); ?></th>
						<td>
							
							<input type="text" name="wpfb_oauth_redirect_url" size="100" value="<?php echo esc_url(admin_url('admin.php?page=wpbot-fb-private-replies')); ?>" readonly />
							<i><?php echo esc_html__('Please copy the url and paste it to the Valid OAuth Redirect URIs field in Facebook Login > Settings from facebook developer dashboard.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					<?php if(qcpdmca_is_wpbot_active()): ?>
					<tr valign="top" class="qcld_app_setting" <?php echo (get_option('wpfb_enable_built_in_app')=='on'?'style="display:none"':''); ?>>
						<th scope="row"><?php echo esc_html__('Callback URL', 'wpfb'); ?> <?php echo esc_html(mca_wpbot_text()); ?></th>
						<td>
							
							<input type="text" name="wpfb_callback_url" size="100" value="<?php echo esc_url(get_site_url().'/?action=fbinteraction'); ?>" readonly />
							<i><?php echo esc_html__('Please copy the url and add it to the Callback URL field in Webhooks section in Facebook App.', 'wpfb'); ?></i>
						</td>
					</tr>
					
					<?php endif; ?>
					
					<?php if(qcpdmca_is_woowbot_active()): ?>
					<tr valign="top" class="qcld_app_setting" <?php echo (get_option('wpfb_enable_built_in_app')=='on'?'style="display:none"':''); ?>>
						<th scope="row"><?php echo esc_html__('Callback URL', 'wpfb'); ?> <?php echo esc_html(mca_woowbot_text()); ?></th>
						<td>
							
							<input type="text" name="wpfb_callback_url_wow" size="100" value="<?php echo esc_url(get_site_url().'/?action=fbinteractionwow'); ?>" readonly />
							<i><?php echo esc_html__('Please copy the url and add it to the Callback URL field in Webhooks section in Facebook App.', 'wpfb'); ?></i>
						</td>
					</tr>
					<?php endif; ?>
					
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Default Instruction Message', 'wpfb'); ?></th>
						<td>
							
							<input type="text" name="wpfb_default_instruction" size="100" value="<?php echo (get_option('wpfb_default_instruction')!=''?get_option('wpfb_default_instruction'):esc_html__('For main menu type Start and hit enter. Or type anything related to our services.', 'wpfb')); ?>"  />
							
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Default No Match Reply', 'wpfb'); ?></th>
						<td>
							
							<input type="text" name="wpfb_default_no_match" size="100" value="<?php echo (get_option('wpfb_default_no_match')!=''?get_option('wpfb_default_no_match'):esc_html__('Sorry, nothing matched your query. Please select from Start menu below.', 'wpfb')); ?>"  />
							
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row" class="qcfb_text_color_red"><?php echo esc_html__('Handover Protocol', 'wpfb'); ?></th>
						<td>
							
							
							<p class="qcfb_text_color_red">
							
							<?php
							 
							 
							 $allowed_tags = array(
								'b' => array()
								
							 );
							 echo wp_kses( 'Handover Protocol allows you to respond to customer messages as the page admin - taking over from the ChatBot. Once set up you can take over the conversation from the ChatBot by replying from your Inbox. In order to use Handover Protocol, you have to go to your <b>page settings > Messenger Platform > General Settings</b> and selete the "<b>Response Method</b>" as "<b>Responses are partially automated, with some support by people</b>". After that click on the "<b>Configure</b>" button of App Settings then choose your "<b>Facebook App</b>" as "<b>Responses are partially automated, with some support by people</b>" and choose "<b>Page Inbox</b>" as "<b>Secondary Receiver for Handover Protocol</b>". That\'s it.', $allowed_tags ); ?>
							
							
							</p>
							<br>
							<span><img class="qcfb_example_image_1" src="<?php echo esc_url(WBFB_URL.'assets/images/messenger_handover1.jpg'); ?>" />
							<img class="qcfb_example_image_2" src="<?php echo esc_url(WBFB_URL.'assets/images/messenger_handover2.jpg'); ?>" />
							</span>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Command for customer service with live agents', 'wpfb'); ?></th>
						<td>
							
							<input type="text" name="wpfb_command_live_agent" size="100" value="<?php echo (get_option('wpfb_command_live_agent')!=''?get_option('wpfb_command_live_agent'):' Livechat'); ?>"  />
							
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
							
							<input type="text" name="wpfb_contact_admin_text" size="100" value="<?php echo (get_option('wpfb_contact_admin_text')!=''?get_option('wpfb_contact_admin_text'):esc_html__('You are contacting admin of this page. Please type your question below.', 'wpfb')); ?>"  />
							
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Remove Image URL from Reply', 'wpfb'); ?></th>
						<td>
							<input type="checkbox" name="wpfb_remove_image" value="on" <?php echo (esc_attr( get_option('wpfb_remove_image') )=='on'?'checked="checked"':''); ?> />
							<i><?php echo esc_html__('Turn ON to remove image url from reply.', 'wpfb'); ?></i>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php echo esc_html__('Remove youtube URL from Reply', 'wpfb'); ?></th>
						<td>
							<input type="checkbox" name="wpfb_remove_video" value="on" <?php echo (esc_attr( get_option('wpfb_remove_video') )=='on'?'checked="checked"':''); ?> />
							<i><?php echo esc_html__('Turn ON to remove youtube url from reply.', 'wpfb'); ?></i>
						</td>
					</tr>

				</table>
			</div>
			
			
			

			
			<?php submit_button(); ?>

		</form>
		
	</div>

	<?php
	}
	
	public function qcld_license_callback(){
		wp_enqueue_style('qcfb-wp-chatbot-license-style', WBFB_URL . '/assets/css/style.css');
		wp_enqueue_script('qcfb-wp-chatbot-license-js', WBFB_URL . '/assets/js/license.js', array('jquery'));
           
		?>
		<div id="licensing">
				<h1><?php echo esc_html__('Please Insert your license Key', 'wpfb'); ?></h1>
				<?php if( get_messengerchatbot_valid_license() ){ ?>
					<div class="qcld-success-notice">
						<p><?php echo esc_html__('Thank you, Your License is active', 'wpfb'); ?></p>
					</div>
				<?php } ?>
				
				<?php
				
					$track_domain_request = wp_remote_get(messengerchatbot_LICENSING_PRODUCT_DEV_URL."wp-json/qc-domain-tracker/v1/getdomain/?license_key=".get_messengerchatbot_licensing_key());
					if( !is_wp_error( $track_domain_request ) || wp_remote_retrieve_response_code( $track_domain_request ) === 200 ){
						$track_domain_result = json_decode($track_domain_request['body']);
						
						$max_domain_num = $track_domain_result[0]->max_domain + 1;
						$total_domains = @json_decode($track_domain_result[0]->domain, true);
						if(!empty($total_domains)){
						$total_domains_num = count($total_domains);

						if( $max_domain_num <= $total_domains_num){
					?>
							<div class="qcld-error-notice">
								<p>
								<?php
								 
								 
								 $allowed_tags = array(
									'a' => array(
										'href' => array(),
										'title' => array()
									)
								 );
								 echo wp_kses( 'You have activated this key for maximum number of sites allowed by your license. Please <a href="https://www.quantumcloud.com/products/">purchase additional license.</a>', $allowed_tags ); ?>

								</p>
							</div>
					<?php
						}
						}
						
					}
				?>
				
				<form onsubmit="return false" id="qc-license-form" method="post" action="options.php">
					<?php
						delete_messengerchatbot_update_transient();
						delete_messengerchatbot_renew_transient();
						
						delete_option('_site_transient_update_plugins');
						settings_fields( 'qcld_messengerchatbot_license' );
						do_settings_sections( 'qcld_messengerchatbot_license' );

					?>
					<table class="form-table">
						

						<tr id="quantumcloud_portfolio_license_row" class="qcfb_display_none">
							<th>
								<label for="qcld_messengerchatbot_enter_license_key"><?php echo esc_html__('Enter License Key:', 'wpfb'); ?></label>
							</th>
							<td>
								<input type="<?php echo (get_messengerchatbot_licensing_key()!=''?'password':'text'); ?>" id="qcld_messengerchatbot_enter_license_key" name="qcld_messengerchatbot_enter_license_key" class="regular-text" value="<?php echo get_messengerchatbot_licensing_key(); ?>">
								<p>
								<?php

								 $allowed_tags = array(
									'a' => array(
										'href' => array(),
										'title' => array()
									)
								 );
								 echo wp_kses( 'You can copy the license key from <a target="_blank" href="https://www.quantumcloud.com/products/account/">your account</a>', $allowed_tags ); ?>
								
								
								</p>
							</td>
						</tr>

						<tr id="show_envato_plugin_downloader" class="qcfb_display_none">
							<th>
								<label for="qcld_messengerchatbot_enter_envato_key"><?php echo esc_html__('Enter Purchase Code:', 'wpfb'); ?></label>
							</th>
							<td colspan="4">
								<input type="<?php echo (get_messengerchatbot_envato_key()!=''?'password':'text'); ?>" id="qcld_messengerchatbot_enter_envato_key" name="qcld_messengerchatbot_enter_envato_key" class="regular-text" value="<?php echo get_messengerchatbot_envato_key(); ?>">
								<p>
								<?php

								 $allowed_tags = array(
									'a' => array(
										'href' => array(),
										'title' => array()
									)
								 );
								 echo wp_kses( 'You can install the <a target="_blank" href="https://envato.com/market-plugin/">Envato Plugin</a> to stay up to date.', $allowed_tags ); ?>
								
								</p>
							</td>
						</tr>
						
						<tr>
							<th>
								<label for="qcld_messengerchatbot_enter_license_or_purchase_key"><?php echo esc_html__('Enter License Key or Purchase Code:', 'wpfb'); ?></label>
							</th>
							<td>
								<input type="<?php echo (get_messengerchatbot_license_purchase_code()!=''?'password':'text'); ?>" id="qcld_messengerchatbot_enter_license_or_purchase_key" name="qcld_messengerchatbot_enter_license_or_purchase_key" class="regular-text" value="<?php echo get_messengerchatbot_license_purchase_code(); ?>" required>
							</td>
						</tr>

					</table>
					<!-- //start new-update-for-codecanyon -->
					<input type="hidden" name="qcld_messengerchatbot_buy_from_where" value="<?php echo get_messengerchatbot_licensing_buy_from(); ?>" >
					<!-- //end new-update-for-codecanyon -->
					<?php submit_button(); ?>
				</form>
				
			</div>
		<?php 
		
	}
	
}
new wbfb_Admin_Area_Controller();