<?php

class wbca_Ajax {

    public $ajax_actions;
	public $operator_online = array();
	public $department_operator = array();
	public $operator_busy = array();
	public $operator_offline = array();
    /*
     * Configuring and intializing ajax files and actions
     *
     * @param  -
     * @return -
     */

    public function __construct() {

    }

    public function initialize() {
        $this->configure_actions();
    }

    /*
     * Confire the application specific AJAX actions array and
     * load the AJAX actions bases on supplied parameters
     *
     * @param  -
     * @return -
     */

    public function configure_actions() {

        $this->ajax_actions = array(
			"wbca_load_wbca_window" => array("action" => "wbca_load_wbca_window_action", "function" => "wbca_load_wbca_window_function"),
			"wbca_register_user" => array("action" => "wbca_register_user_action", "function" => "wbca_register_user_function"),
			"wbca_offline_message" => array("action" => "wbca_offline_message_action", "function" => "wbca_offline_message_function"),
			
			"wbca_load_client_chat" => array("action" => "wbca_load_client_chat_action", "function" => "wbca_load_client_chat_function"),
			"wbca_load_allchat" => array("action" => "wbca_load_allchat_action", "function" => "wbca_load_allchat_function"),
			"wbca_submit_client_message" => array("action" => "wbca_submit_client_message_action", "function" => "wbca_submit_client_message_function"),
			"wbca_set_active_chat" => array("action" => "wbca_set_active_chat_action", "function" => "wbca_set_active_chat_function"),
			"wbca_remove_active_chat" => array("action" => "wbca_remove_active_chat_action", "function" => "wbca_remove_active_chat_function"),
			"wbca_load_active_chat" => array("action" => "wbca_load_active_chat_action", "function" => "wbca_load_active_chat_function"),
			"wbca_livechatfile_upload" => array("action" => "wbca_livechatfile_upload_action", "function" => "wbca_livechatfile_upload"),
        );

        /*
         * Add the AJAX actions into WordPress
         */
        foreach ($this->ajax_actions as $custom_key => $custom_action) {

            if (isset($custom_action["logged"]) && $custom_action["logged"]) {
                // Actions for users who are logged in
                add_action("wp_ajax_" . $custom_action['action'], array($this, $custom_action["function"]));
            } else if (isset($custom_action["logged"]) && !$custom_action["logged"]) {
                // Actions for users who are not logged in
                add_action("wp_ajax_nopriv_" . $custom_action['action'], array($this, $custom_action["function"]));
            } else {
                // Actions for users who are logged in and not logged in
                add_action("wp_ajax_nopriv_" . $custom_action['action'], array($this, $custom_action["function"]));
                add_action("wp_ajax_" . $custom_action['action'], array($this, $custom_action["function"]));
            }
        }
    }
	/*
     * is_operator_online functions for checking user online or offline
     * @param  -
     * @return -
     */
	 
	public function is_operator_online(){
			global $wpdb;
			$operator = array();
			
			$users = $this->get_users();
			$data = get_option('wbca_options');
			$blogtime = strtotime(current_time( 'mysql' ));
			foreach ( $users as $user ) {
				$meta = strtotime(get_user_meta($user->ID, 'wbca_login_time', true));
				$user_status = get_user_meta($user->ID, 'wbca_login_status', true);
				$interval  = abs($blogtime - $meta);
				$minutes   = round($interval / 60);
				if($minutes <= 5 && $user_status=='online' ){
					array_push($operator, $user->ID);
				}

			}
			if(!empty($operator)){
				return true;
			}else {
				if(isset($data['always_allow_livechat']) && $data['always_allow_livechat']==true){
					return true;
				}else{
					return false;
				}
				
			}
	}	
	
	/*
     * is_this_operator_online functions for checking user online or offline
     * @param  -
     * @return -
     */
	
	public function is_this_operator_online($opid){
		global $wpdb;
		$operator = array();
		$user = get_user_by( 'ID', $opid );
		$blogtime = strtotime(current_time( 'mysql' ));
		$meta = strtotime(get_user_meta($user->ID, 'wbca_login_time', true));
		$user_status = get_user_meta($user->ID, 'wbca_login_status', true);
		
		$interval  = abs($blogtime - $meta);
		$minutes   = round($interval / 60);
		if($minutes <= 5 && $user_status=='online'){
			return true;
		}else {
			return false;
		}

	}

	public function get_users(){
		global $wpdb;
		$data = get_option('wbca_options');
		
		if($data['admin_able_to_chat']=='1'){
			$roles = array('operator', 'administrator');
		}else{
			$roles = array('operator');
		}
		
		
		$users = array();
		foreach($roles as $role){

			$current_user_role = get_users( array('role'=> $role));
			$users = array_merge($current_user_role, $users);
		}
		return $users;
	}
	/*
	*
	*
	*/
	public function check_department_operator($did){
		global $wpdb;
		foreach ($this->operator_online as $key => $value) {
			$sql = "SELECT user_id FROM {$wpdb->prefix}wbca_user_department WHERE user_id = $value AND dept_id = $did";
			$user_ids = $wpdb->get_results($sql);
			if(sizeof($user_ids) >= 1){
				array_push($this->department_operator,$user_ids[0]->user_id);
			}
		}
	}
	/*
     * all_operator_online functions for checking user online or offline
     * @param  -
     * @return -
     */
	
	public function all_operator_online(){
			global $wpdb;
			$operator = array();
			
			$users = $this->get_users();
			$blogtime = strtotime(current_time( 'mysql' ));
			if(!empty($users)){
				foreach ( $users as $user ) {
					$meta = strtotime(get_user_meta($user->ID, 'wbca_login_time', true));
					$status = get_user_meta($user->ID, 'wbca_login_status', true);
					$blogtime = strtotime(current_time( 'mysql' ));

					$interval  = abs($blogtime - $meta);
					$minutes   = round($interval / 60);

					if( $status == 'online' && $minutes <= 10 ){
						$this->operator_online[] = $user->ID;
					}else if($status == 'busy'){
						$this->operator_busy[] = $user->ID;
					}else if($status == 'offline'){
						$this->operator_offline[] = $user->ID;
					}
				}
				return true;
			}else{
				return false;
			}				
	}

    /*
     * wbca_load_wbca_window function for handling AJAX request
     *
     * @param  -
     * @return -
     */

    public function wbca_load_wbca_window_function() {
		global $wpdb;
		header("Content-Type: application/json");
		
		$chat = array();
		$htm = '';
		$a = &$chat;
		$a["wbca_window"] = '';
		$a["wbca_session"] = 0;
		$a["title"] = '';
		$close_chat = '';
		
		$data = get_option('wbca_options');
		if(function_exists('qcld_get_lc_language')){
			$only_chat = !empty(qcld_get_lc_language( 'wbca_lg_ochat' ))?qcld_get_lc_language( 'wbca_lg_ochat' ):'Chat';
			$start_chat = !empty(qcld_get_lc_language( 'wbca_lg_chat' ))?qcld_get_lc_language( 'wbca_lg_chat' ):'Start chat';
			$type_msg = !empty(qcld_get_lc_language( 'wbca_lg_msg' ))?qcld_get_lc_language( 'wbca_lg_msg' ):'Type Message';
			$we_are = !empty(qcld_get_lc_language( 'wbca_lg_we_are_here' ))?qcld_get_lc_language( 'wbca_lg_we_are_here' ):'We are here to help you. Please fill up the form and start chatting.';
			
			
			$tt = '';
			if($this->is_operator_online()){
				$title = !empty(qcld_get_lc_language( 'wbca_lg_online' ))?qcld_get_lc_language( 'wbca_lg_online' ):'Live Chat - Online';
				$tt = 'Online';
			}else{
				$title = !empty(qcld_get_lc_language( 'wbca_lg_offline' ))?qcld_get_lc_language( 'wbca_lg_offline' ):'Live Chat - Offline';
				$tt = 'Offline';
			}
			
			$send_query = !empty(qcld_get_lc_language( 'wbca_lg_sendq' ))?qcld_get_lc_language( 'wbca_lg_sendq' ):'Operators offline. Please send your query';
			
			$subject = !empty(qcld_get_lc_language( 'wbca_lg_subject' ))?qcld_get_lc_language( 'wbca_lg_subject' ):'Subject';
			$msg = !empty(qcld_get_lc_language( 'wbca_lg_msg' ))?qcld_get_lc_language( 'wbca_lg_msg' ):'Type Message';
			$send = !empty(qcld_get_lc_language( 'wbca_lg_send' ))?qcld_get_lc_language( 'wbca_lg_send' ):'Send';
					
			$userid = get_current_user_id();
			if($userid > 0){
				$user_info = get_userdata($userid);	
				$useremail = $user_info->user_email;
				$username = $user_info->display_name;
				$name_value = !empty($username)? $username:'';
				$email_value = !empty($useremail)? $useremail:'';
				$fullname = !empty(qcld_get_lc_language( 'wbca_lg_fname' ))?qcld_get_lc_language( 'wbca_lg_fname' ):'Full name';
				$email = !empty(qcld_get_lc_language( 'wbca_lg_email' ))?qcld_get_lc_language( 'wbca_lg_email' ):'Email';
				$department = 'Department';
				$operator = 'Operator';
			}else{
				$name_value = !empty($username)? $username:'';
				$email_value = !empty($useremail)? $useremail:'';
				$fullname = !empty(qcld_get_lc_language( 'wbca_lg_fname' ))?qcld_get_lc_language( 'wbca_lg_fname' ):'Full name';
				$email = !empty(qcld_get_lc_language( 'wbca_lg_email' ))?qcld_get_lc_language( 'wbca_lg_email' ):'Email';
				
			}
		}else{
			$only_chat = 'Chat';
			$start_chat = 'Start chat';
			$type_msg = 'Type Message';
			$we_are = 'We are here to help you. Please fill up the form and start chatting.';
			
			
			$tt = '';
			if($this->is_operator_online()){
				$title = 'Live Chat - Online';
				$tt = 'Online';
			}else{
				$title ='Live Chat - Offline';
				$tt = 'Offline';
			}
			
			$send_query = 'Operators offline. Please send your query';
			
			$subject ='Subject';
			$msg = 'Type Message';
			$send ='Send';
					
			$userid = get_current_user_id();
			if($userid > 0){
				$user_info = get_userdata($userid);	
				$useremail = $user_info->user_email;
				$username = $user_info->display_name;
				$name_value = !empty($username)? $username:'';
				$email_value = !empty($useremail)? $useremail:'';
				$fullname = 'Full name';
				$email = 'Email';
				$department = 'Department';
				$operator = 'Operator';
			}else{
				$name_value = !empty($username)? $username:'';
				$email_value = !empty($useremail)? $useremail:'';
				$fullname = 'Full name';
				$email = 'Email';
				
			}
		}
		$deparment_lists = $wpdb->get_results('SELECT d.department FROM '.$wpdb->prefix.'wbca_department AS d LEFT JOIN '.$wpdb->prefix.'wbca_user_department AS ud ON ud.dept_id = d.id LEFT JOIN '.$wpdb->prefix.'usermeta AS um ON um.user_id = ud.user_id WHERE um.meta_key = "wbca_login_status" AND um.meta_value = "online" AND ud.dept_id IS NOT NULL GROUP BY department');
		$deparment_list = '';
		foreach ($deparment_lists as $value) {
			$deparment_list .= '<option value="'.$value->id.'">'.$value->department.'</option>';
		}
		if($this->is_operator_online()){
			$user_id = '';
			if(isset($_SESSION["ClientChatStored"])){
				foreach($_SESSION["ClientChatStored"] as $sessionid){
					$user_id = $sessionid['CLIENTID'];
				}
			}
			if($user_id > 0){
				$department_chosen = get_user_meta($user_id, 'department_chosen');
				$a["wbca_session"] = 1;
				$close_chat = '<!--<span class="chatCloseIcon" data-clientid="'.$user_id.'" data-event="close-chat-window">&times;</span>-->';
				$data = get_option('wbca_options');
				if($data["admin_enble_fileupload"]){
					$htm .= '<div class="wbca_chat_wrap" data-clientid="'.$user_id.'">
						<div id="wbca_chat_body" data-clientid="'.$user_id.'" data-departmet="'.$department_chosen.'" data-location="wbca-body-'.$user_id.'">
						</div>
						<div id="wbca_chat_footer">
							<div class="wbca_float_left_footer">
								<input type="text" id="input_wbca_editor" data-event="submit-client-chat" placeholder="'.$start_chat.'" data-clientid="'.$user_id.'" />
							</div>
							<div class="wbca_float_right_footer">
								<input type="file" id="qclivechat_file" data-clientid="'.$user_id.'"  data-departmet="'.$department_chosen.'" />
								<label for="qclivechat_file" class="btn-upload"><img src="'. WBCA_URL .'/images/upload-icon.png" /></label>
								<a href="#" class="btn-send-message"><span class="chatIcon wbca_chat"><span></a>
							</div>
						</div>
					</div>';
				}else{
					$htm .= '<div class="wbca_chat_wrap" data-clientid="'.$user_id.'">
						<div id="wbca_chat_body" data-clientid="'.$user_id.'" data-departmet="'.$department_chosen.'" data-location="wbca-body-'.$user_id.'">
						</div>
						<div id="wbca_chat_footer">
							<div class="wbca_float_left_footer">
								<input type="text" id="input_wbca_editor" data-event="submit-client-chat" placeholder="'.$start_chat.'" data-clientid="'.$user_id.'" />
							</div>
							<div class="wbca_float_right_footer">
								<label for="qclivechat_file" class="btn-upload"><img src="'. WBCA_URL .'/images/upload-icon.png" /></label>
								<a href="#" class="btn-send-message"><span class="chatIcon wbca_chat"><span></a>
							</div>
						</div>
					</div>';
				}
				
			}else{
				if(!empty($deparment_list)){
					$htm .= '<div class="wbca_signup_wrap">
					<form id="wbca_signup_form" action="" method="post">
						<div class="wbca_header_txt">
							<p>'.$we_are.'</p>
						</div>
					  <div>
						<!--[if IE ]>
						   <span>'.$fullname.'</span><br/>
						<![endif]-->
						<input type="text" id="wbca_signup_fullname" name="wbca_signup_fullname" class="inputbox" required placeholder="'.$fullname.'" value="'.$name_value.'">
					  </div>
					  <div>
						<!--[if IE ]>
						   <span>'.$email.'</span><br/>
						<![endif]-->
						<input type="text" id="wbca_signup_email" name="wbca_signup_email" class="inputbox" required placeholder="'.$email.'" value="'.$email_value.'">
					  </div>
					  <div>
						   <select class="livechat-select-department">'.$deparment_list.'</select>
					  </div>
					  <div>
							<button class="button button--ujarak" type="submit" data-event="wbca-signup-submit" id="wbca_signup_submit">'.$start_chat.'</button>
					  </div>
					</form></div>';
				}else{

				
					$htm .= '<div class="wbca_signup_wrap">
						<form id="wbca_signup_form" action="" method="post">
							<div class="wbca_header_txt">
								<p>'.$we_are.'</p>
							</div>
						<div>
							<!--[if IE ]>
							<span>'.$fullname.'</span><br/>
							<![endif]-->
							<input type="text" id="wbca_signup_fullname" name="wbca_signup_fullname" class="inputbox" required placeholder="'.$fullname.'" value="'.$name_value.'">
						</div>
						<div>
							<!--[if IE ]>
							<span>'.$email.'</span><br/>
							<![endif]-->
							<input type="text" id="wbca_signup_email" name="wbca_signup_email" class="inputbox" required placeholder="'.$email.'" value="'.$email_value.'">
						</div>
						
						<div>
								<button class="button button--ujarak" type="submit" data-event="wbca-signup-submit" id="wbca_signup_submit">'.$start_chat.'</button>
						</div>
						</form></div>';
				}
			}
			
		}else{
			$support_button = '';
			$ticket_url = '';
			if(class_exists('Qcld_kbx_support')){
				if(get_option('qcld_support_page_id') && get_option('qcld_support_page_id')!=''){
					$kbx_page_id = get_option('qcld_support_page_id');
				}else{
					$kbx_page_id = get_page_by_title('Support Ticket for KBX');
				}
				$ticket_url = get_permalink($kbx_page_id);
				
				$support_button = '<a href="'.$ticket_url.'" class="" style="color: unset !important;"><button class="button button--ujarak" type="button" style="display: inline;" >Open a Ticket</button></a>';
			}
			
			$htm .= '<div class="wbca_message_wrap">
			<p>'.$send_query.'</p><br/>
			<form id="wbca_message_form" action="" method="post">
			  <div>
				<!--[if IE ]>
				   <span>'.$fullname.'</span><br/>
				<![endif]-->
				<input type="text" id="wbca_message_fullname" name="wbca_message_fullname" class="inputbox" required placeholder="'.$fullname.'">
			  </div>
			  <div>
				<!--[if IE ]>
				   <span>'.$email.'</span><br/>
				<![endif]-->
				<input type="text" id="wbca_message_email" name="wbca_message_email" class="inputbox" required placeholder="'.$email.'">
			  </div>
			  <div>
				<!--[if IE ]>
				   <span>Type message</span><br/>
				<![endif]-->
				<textarea id="wbca_message" value="" required name="wbca_message" placeholder="'.$msg.'"></textarea>
			  </div>
			  <div>
					<button class="button button--ujarak" type="submit" data-event="offline-message" id="wbca_message_submit" style="display: inline-block;">'.$send.'</button>
					'.$support_button.'
					
			  </div>
			  <div id="wbca_msg_notify" class="wbca_center"></div>
			</form></div>';
		}		
		
		$a["wbca_window"] .= '<div id="wbcaChatWindow" data-window-state="0">
								<div class="wbcaTitle" data-event="">
									<div class="wpchat_header_left"><span id="wpbot_back_to_home"><i class="fa fa-angle-left" aria-hidden="true"></i></span></div>
									<div class="wpchat_header_right"><span class="chatIcon wbca_chat">&nbsp;</span><span class="chat-member">'.$title.'</span>'.$close_chat.'</div>
								</div>
								<div class="wbcaBodyHolder" data-window-state="0" data-identifier="-1">									
									<div class="wbcaBody">
										'.$htm.'
									</div>
								</div>
							</div>
							
							';
		$a['title'] = $tt;
	
		echo json_encode($chat);
		exit;
    }

    /*
     * Register new application user from frontend
     *
     * @param  -
     * @return void
     */

    public function wbca_register_user_function() {
		header("Content-Type: application/json");
		$message = array();
		$a = &$message;
		$a["wbca_chatbox"] = '';
		
		$data = get_option('wbca_options');		
		$start_chat = !empty(qcld_get_lc_language( 'wbca_lg_chat' )) ? qcld_get_lc_language( 'wbca_lg_chat' ) : 'Start Chat';
		
		
		$user_email = ( isset ( $_POST['wbca_signup_email'] ) ? $_POST['wbca_signup_email']: '' );
		$department_chosen = ( isset ( $_POST['selected_department'] ) ? $_POST['selected_department']: '' );
		$display_name = ( isset ( $_POST['wbca_signup_fullname'] ) ? $_POST['wbca_signup_fullname']: '' );
		$user_type  = 'livechatuser';
		$split_name = explode(" ",$display_name);
		if(count($split_name) >= 3){
			$first_name = $split_name[0].' '.$split_name[1];
			$last_name = '';
			for($i = 2; $i < count($split_name); $i++) {
				$last_name = $split_name[i];
			}
		}else if(count($split_name) == 2){
			$first_name = $split_name[0];
			$last_name =$split_name[1];
		}else{
			$first_name = $split_name[0];
			$last_name ='';
		}
		$sanitized_user_login = sanitize_user($user_login);

		if (email_exists($user_email)){
			
			$user = get_user_by( 'email', $user_email );
			$user_id = $user->ID;	
					
		}else{
			$user_pass = wp_generate_password();
			$user_id = wp_insert_user(array('user_login' => $user_email,
						'user_email' => $user_email,
						'display_name' => $display_name,
						'role' => $user_type,
						'first_name' => $first_name,
						'last_name' => $last_name,
						'user_pass' => $user_pass));


			if (!$user_id) {
				// do nothing
			}else {
				$activation_code = $this->random_string();

				update_user_meta($user_id, 'activation_code', $activation_code);
				update_user_meta($user_id, 'department_chosen', $department_chosen);
				update_user_meta($user_id, 'activation_status', "active");
				update_user_meta( $user_id, 'show_admin_bar_front', 'false' );
				//wp_new_user_notification($user_id, $user_pass, $activation_code);
				
				$subject = 'Welcome message from '.get_option('blogname');
				
				$body = 'Welcome ' .$first_name. ','.'\n\n';
				$body .= 'You have recently get supported from our website. We have created an account for you. Please find the below credential.'.'\n\n';
				$body .= 'Username: ' .$user_email. ','.'\n';
				$body .= 'Email: ' .$user_email. ','.'\n';
				$body .= 'Password: ' .$user_pass. ','.'\n\n';
				$body .= get_option('blogname').'\n\n';
				
				$admin_email = get_option('admin_email');
				$site_name = get_option('blogname');
				$headers = 'From: '.$site_name.' <'.$admin_email.'>' . "\r\n" . 'Reply-To: ' . $admin_email;
				//wp_mail($user_email, $subject, $body, $headers);
				
			}
		}
		$data = get_option('wbca_options');
		if($data["admin_enble_fileupload"]){
			$a["wbca_chatbox"] .= '<div class="wbca_chat_wrap" data-clientid="'.$user_id.'">
							<div id="wbca_chat_body" data-clientid="'.$user_id.'" data-departmet="'.$department_chosen.'" data-location="wbca-body-'.$user_id.'">
							</div>
							<div id="wbca_chat_footer">
								<div class="wbca_float_left_footer">
									<input type="text" id="input_wbca_editor" data-event="submit-client-chat" placeholder="'.$start_chat.'" data-clientid="'.$user_id.'" />
								</div>
								<div class="wbca_float_right_footer">
									<input type="file" id="qclivechat_file" data-clientid="'.$user_id.'"  data-departmet="'.$department_chosen.'"/>
									<label for="qclivechat_file" class="btn-upload"><img src="'. WBCA_URL .'/images/upload-icon.png" /></label>
									<a href="#" class="btn-send-message"><span class="chatIcon wbca_chat"><span></a>
								</div>
							</div>
						</div>';
		}else{
			$a["wbca_chatbox"] .= '<div class="wbca_chat_wrap" data-clientid="'.$user_id.'">
							<div id="wbca_chat_body" data-clientid="'.$user_id.'" data-departmet="'.$department_chosen.'" data-location="wbca-body-'.$user_id.'">
							</div>
							<div id="wbca_chat_footer">
								<div class="wbca_float_left_footer">
									<input type="text" id="input_wbca_editor" data-event="submit-client-chat" placeholder="'.$start_chat.'" data-clientid="'.$user_id.'" />
								</div>
								<div class="wbca_float_right_footer">
									<span class="chatIcon wbca_chat"><span>
								</div>
							</div>
						</div>';
		}
		$a["wbca_username"] = $user_email;
		$a["wbca_userid"] = $user_id;
		$a["department_chosen"] = $department_chosen;
		echo json_encode($message);
		exit;
    }
	
	public function wbca_offline_message_function(){
		header("Content-Type: application/json");
		if(isset($_POST['wbca_message'])) {
			$message = array();
			$a = &$message;
			$a["wbca_msg"] = '';
			$a["error"] = false;	
			$errors = false;
						
			$input_name = $_POST['wbca_message_fullname'];
			$input_email = $_POST['wbca_message_email'];
			$input_message = $_POST['wbca_message'];
					
			//If there is no error, send the email
			$data = get_option('wbca_options');
			$msg_success = ( isset ( $_POST['wbca_msg_success'] )? $_POST['wbca_msg_success']: 'Success! We will get back to you soon.' );
			$msg_failed = ( isset ( $_POST['wbca_msg_failed'] )? $_POST['wbca_msg_failed']: 'Sending failed! Please try again later.' );
			
			if($data['enable_wbca_email']){
				$emailTo = $data['wbca_email_address'];
				if($data['wbca_email_address']==''){
					$emailTo = get_option('admin_email');
				}
			}else{
				$emailTo = get_option('admin_email');
			}
			
			$url = get_site_url();
			$url = parse_url($url);
			$domain = $url['host'];
			$fromEmail = "wordpress@" . $domain;
			
			$subject = 'New message from '.$input_name;
			$body = $input_message;
			$headers = 'From: '.$input_name.' <'.$fromEmail.'>' . "\r\n" . 'Reply-To: ' . $input_email;
			if(wp_mail($emailTo, $subject, $body, $headers)){
				$a["wbca_msg"] .= '<span class="wbca_success">'.$msg_success.'</span>';
				$a["error"] = false;
			}else{
				$a["wbca_msg"] .= '<span class="wbca_error">'.$msg_failed.'</span>';
				$a["error"] = true;
			}
							
			echo json_encode($message);
			exit;
		
		}
	}	

    /*
     * wbca_load_client_chat functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    function wbca_load_client_chat_function() {
		header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;		
		$a["wbca_client_chat"] = array();
		
        $chatAray = array();
	
		global $wpdb;
		$wpdb->show_errors = true;
		if( isset( $_POST['wbca_clientID'] ) && $_POST['wbca_clientID'] != ''){
			$UserId = $_POST['wbca_clientID'];
		}else{
			$UserId = 0;
		}
		$blogtime = current_time( 'mysql' );
		$Read = 0;
		$transfer = 1;
		$msgQuery = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT u.display_name, im.id AS cid, im.user_sender, im.user_receiver, im.message, im.chat_time  
												FROM $wpdb->users u, {$wpdb->prefix}wbca_message im 
												WHERE u.ID = im.user_sender 
												AND im.user_receiver = '%d' 
												AND im.chat_read = '%d'
												AND im.wbca_transferred != '%d'
												AND DATE_ADD( im.chat_time, INTERVAL 5 MINUTE ) >= '%s'
												ORDER BY im.id ASC 
												LIMIT 15", $UserId, $Read, $transfer, $blogtime));
		if(!empty($msgQuery)) {
			foreach($msgQuery as $Row) {
				$chatID = $Row->cid;
				$chatAray[] = $Row->cid;
				$operatorID = $Row->user_sender;
				$operatorName = $Row->display_name;
				$clientID = $Row->user_receiver;
				$chat_time = $Row->chat_time;
				$message = stripslashes($Row->message);
				$getAvater = str_replace('&','&amp;',get_avatar($operatorID));
				if(trim($getAvater)!=''){
					$doc = new DOMDocument();
					$doc->loadHTML($getAvater);
					$xpath = new DOMXPath($doc);
					
					$src = $xpath->evaluate("string(//img/@src)"); #"/images/image.jpg"
				} else {
					$src = esc_url( get_avatar_url( $operatorID ) );
				}
				

				$a["wbca_client_chat"][$chatID] = array("operatorid" => $operatorID, 
														"operatorname" => $operatorName, 
														"clientid"=> $clientID,
														"message"=> $message,
														"chat_time"=> $chat_time,
														"avatar"=> $src
														);
			}
		}
	//	var_dump($this->is_operator_online());wp_die();
		if($this->is_operator_online()){
			$a["is_operator_online"] = 1;
		}else{
			$a["is_operator_online"] = 0;
		}
		if(count($chatAray) > 0) {
			foreach($chatAray as $key=>$id){
				$wpdb->update( 
					$wpdb->prefix.'wbca_message',
					array( 'chat_read' => 1),
					array( 'id' => $id ),
					array( '%d'),
					array( '%d')
				);
			}
		}
		
		update_user_meta( $UserId, 'wbca_login_time', $blogtime );
		
		echo json_encode($chat);
		exit;
    }
	
 	/*
     * wbca_load_allchat functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    function wbca_load_allchat_function() {

        header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;		
		$a["allmessages"] = array();
		
		global $wpdb;
		$wpdb->show_errors = true;
		if($_POST["cc_clientid"] != ''){
			$clientID = $_POST["cc_clientid"];
		}else{
			$clientID = '';
		}
		
		$MessageSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wbca_message WHERE (user_receiver = '%d' or user_sender = '%d')  ORDER BY id DESC LIMIT 15", $clientID, $clientID));
		
		$Cached = array();
		
		foreach($MessageSQL as $Row) {
			$userMessage = $Row->user_sender == $clientID;
			
			if(!$userMessage){
				$chatID = $Row->id;
			}
			$personalID = $userMessage ? $clientID : $Row->user_sender;
			$getAvater = str_replace('&','&amp;',get_avatar($userMessage ? $clientID : $Row->user_sender));
			if(trim($getAvater)!=''){
				$doc = new DOMDocument();
				$doc->loadHTML($getAvater);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
			} else {
				$src = esc_url( get_avatar_url( $userMessage ? $clientID : $Row->user_sender ) );
			}
			$user_icon_src = WBCA_URL . 'images/client.png';
			
			if($userMessage){
				$msg = '<div class="wbca_client_message_row wbca_message_row wbca-clear"><div class="wbca_image rightImage"><img src="'.$user_icon_src.'" /></div><div class="wbcaMessage rightMessage ui floating blue message"><div class="wbcaContent">'.stripslashes($Row->message).'</div><div class="ui list right aligned"><span class="item">'. $Row->chat_time .'</span></div></div></div>';
			}else{
				$msg = '<div class="wbca_admin_message_row wbca_message_row wbca-clear" data-operatorid="'.$personalID.'"><div class="wbca_image leftImage"><img src="'.$src.'" /></div><div class="wbcaMessage leftMessage ui floating violet message"><div data-wbca-chatid="'.$Row->id.'" class="wbcaContent">'.stripslashes($Row->message).'</div><div class="ui list right aligned"><span>'. $Row->chat_time .'</span></div></div></div>';
			}			
	
			array_push($Cached, $msg);
			if(!$userMessage){
				if($chatID != ''){
					$wpdb->update( $wpdb->prefix.'wbca_message', array( 'chat_read' => 1),array( 'id' => $chatID ));
				}
			}
			
			
		}
		
		for($i = count($Cached); $i > -1; $i--){
			$a["allmessages"][$clientID] .= $Cached[$i];
		}
		
		echo json_encode($chat);
		exit;
    }	

	public function wbca_notification_email($clientid, $operatorid){
	
		$data = get_option('wbca_options');
		//admin email
		if($data['enable_wbca_email']){
			$admin_email = $data['wbca_email_address'];
			
			// if($data['wbca_email_address']==''){
			// 	$admin_email = get_option('admin_email');
			// }
		}else{
			$admin_email = get_option('admin_email');
		}
		
		$client = get_user_by( 'ID', $clientid );
		$operator = get_user_by( 'ID', $operatorid );
		
		$dashboard_url = admin_url().'admin.php?page=wbca-chat-page';
		
		$subject = (isset($data['wbca_email_notification_subject'])?$data['wbca_email_notification_subject']:'#clientname started a new chat session');
		$content = (isset($data['wbca_email_notification_content'])?apply_filters('the_content', htmlspecialchars_decode(stripslashes($data['wbca_email_notification_content']))):'Hi,<br><br>#clientname started a new chat session with you. Please go to <a href="#livechat_dashboard_url">Livechat Dashboard</a> and find him/her.<br>Thanks.');
		
		$subject = str_replace(array('#clientname'),array($client->display_name), $subject);
		
		$body = str_replace(array('#clientname', '#livechat_dashboard_url'),array($client->display_name, $dashboard_url), $content);
		$site_name = get_option('blogname');
		    //Extract Domain
		$url = get_site_url();
		$url = parse_url($url);
		$domain = $url['host'];
		$fromEmail = "wordpress@" . $domain;

		$headers = array('Content-Type: text/html; charset=UTF-8');
		$headers[] = 'From: '.$site_name.' <'.$fromEmail.'>';
		
		if($operatorid==0){
			
			if(isset($data['wbca_email_alerts']) && $data['wbca_email_alerts']!=''){
				
				$emails = explode(',', $data['wbca_email_alerts']);
				$toemail = $emails[0];
				if(!empty($emails)){
					$headers = array('Content-Type: text/html; charset=UTF-8');
					foreach($emails as $email){
						@wp_mail($email, $subject, $body, $headers);
					}
				}
				
			}
			
		}else{
			$headers[] = 'Cc: Site Admin <'.$admin_email.'>';
			@wp_mail($operator->user_email, $subject, $body, $headers);
		}
		
		
		//@wp_mail($admin_email, $subject, $body, $headers);
		
		return null;
	}
	
	 /*
     * wbca_submit_client_message functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    public function wbca_submit_client_message_function() {
		
        header("Content-Type: application/json");
		$data = get_option('wbca_options');
		$chat = array();
		$a = &$chat;
		
		global $wpdb;
		$wpdb->show_errors = true;
		
		$message = $_POST["messageContent"];
		$opid = $_POST["receiverUserId"];
		$UserId = $_POST["senderUserId"];
		$departmentId = $_POST["departmentId"];
		$a["opid"] = $opid;
		
		$check_department_operator = $this->check_department_operator($departmentId);
		if($opid == 'none' && $this->all_operator_online()){
			if(!empty($this->operator_online)){
				if(sizeof($this->department_operator) >= 1){
					$operatorID = $this->department_operator[array_rand($this->operator_online)];
				}else{
					
					$operatorID = $this->operator_online[array_rand($this->operator_online)];
				}
			}else if(!empty($this->operator_busy)){
				$operatorID = $this->operator_busy[array_rand($this->operator_busy)];
			}
			if(!$data['disable_notice_wbca_email']){
			
				if($operatorID!='' && empty((get_user_meta( $UserId, 'notification_mail_send')))){
					$this->wbca_notification_email($UserId, $operatorID);
					update_user_meta( $UserId, 'notification_mail_send', 'true' );
				}
			}
		}else{
			$operatorID = $_POST["receiverUserId"]; // operator is receiver
		}
		if(isset($data['always_allow_livechat']) && $data['always_allow_livechat']==true){
			if($operatorID==''){
				$operatorID	= 0;
				$this->wbca_notification_email($UserId, $operatorID);
			}
		}
		$Read = 0;
		$blogtime = current_time( 'mysql' );
		$affected_row = $wpdb->insert( 
			$wpdb->prefix.'wbca_message', 
			array( 
				'user_sender' => $UserId, 
				'user_receiver' => $operatorID,
				'message' => $message,
				'chat_read' => $Read,
				'chat_time' => $blogtime,
			), 
			array( 
				'%d', 
				'%d',
				'%s',
				'%d',
				'%d',
				'%s',
			) 
		);
		$a["opid"] = $operatorID;
		$a["operator_info"] = '';
		if($opid == 'none' && $affected_row){
			$avatar = str_replace('&','&amp;',get_avatar($operatorID, 'thumbnail'));
			$user = get_userdata($operatorID );
			$a["operator_info"] = array("operatorid" => $operatorID, 
										"operatorname" => $user->display_name, 
										"operatorbio" => $user->description,
										"avatar"=> $avatar
										);
		}
		
		if($affected_row){
			$a["is_submit"] = 1;
			$a["operator_id"] = $operatorID;
		}else{
			$a["is_submit"] = 0;
		}
		
		echo json_encode($chat);
        exit;
    }
	
	public function wbca_livechatfile_upload(){
		$data = get_option('wbca_options');
		$type_chek = explode('/',$_FILES['file']['type']);
		if (in_array($_FILES['file']['type'], explode(',',$data["allowed_file_format"]))) {
			$upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));
			header("Content-Type: application/json");
			$data = get_option('wbca_options');
			$chat = array();
			$a = &$chat;
			global $wpdb;
			$wpdb->show_errors = true;
			if($_FILES['file']['type'] == 'application/pdf'){
				$message =  '<iframe src="'.$upload["url"].'" width="90%" height="auto"></iframe></br></br><a style="display:block" href="'.$upload["url"].'" target="_blank">View PDF</a>';
			}
			if($type_chek[0] == 'image'){
				$message = '<a href="'.$upload["url"].'" target="_blank" download><img src="'.$upload["url"].'" width="250"/></a>';
			}else{
				$message =  '<a style="display:block" href="'.$upload["url"].'" target="_blank" download>'.$_FILES['file']['name'].'</a>';
			}
			$opid = $_POST["receiverUserId"];
			$UserId = $_POST["senderUserId"];
			$a["opid"] = $opid;
			$check_department_operator = $this->check_department_operator($departmentId);
			if($opid == 'none' && $this->all_operator_online()){
				if(!empty($this->operator_online)){
					if(sizeof($this->department_operator) >= 1){
						$operatorID = $this->department_operator[array_rand($this->operator_online)];
					}else{
						$operatorID = $this->operator_online[array_rand($this->operator_online)];
					}
				}else if(!empty($this->operator_busy)){
					$operatorID = $this->operator_busy[array_rand($this->operator_busy)];
				}
				if(!$data['disable_notice_wbca_email']){
				
					if($operatorID!='' && empty((get_user_meta( $UserId, 'notification_mail_send')))){
						$this->wbca_notification_email($UserId, $operatorID);
						update_user_meta( $UserId, 'notification_mail_send', 'true' );
					}
				}
			}else{
				$operatorID = $_POST["receiverUserId"]; // operator is receiver
			}
			if(isset($data['always_allow_livechat']) && $data['always_allow_livechat']==true){
				if($operatorID==''){
					$operatorID	= 0;
					$this->wbca_notification_email($UserId, $operatorID);
				}
			}
			$Read = 0;
			$blogtime = current_time( 'mysql' );
			$affected_row = $wpdb->insert( 
				$wpdb->prefix.'wbca_message', 
				array( 
					'user_sender' => $UserId, 
					'user_receiver' => $operatorID,
					'message' => addslashes($message),
					'has_attachment' => 1,
					'chat_read' => $Read,
					'chat_time' => $blogtime,
				), 
				array( 
					'%d', 
					'%d',
					'%s',
					'%d',
					'%d',
					'%s',
				) 
			);
			
			$a["operator_info"] = '';
			if($opid == 'none' && $affected_row){
				$avatar = str_replace('&','&amp;',get_avatar($operatorID, 'thumbnail'));
				$user = get_userdata($operatorID );
				$a["operator_info"] = array("operatorid" => $operatorID, 
											"operatorname" => $user->display_name, 
											"operatorbio" => $user->description,
											"avatar"=> $avatar
											);
			}
			
			if($affected_row){
				$a["is_submit"] = 1;
					$a["operator_id"] = $operatorID;
			}else{
				$a["is_submit"] = 0;
			}
			$a["message"] = $message;
			$a["date"] = $blogtime;
			echo json_encode($chat);
		}else{
			$chat = array();
			$a = &$chat;
			$blogtime = current_time( 'mysql' );
			$a["message"] = 'file not supported';
			$a["date"] = $blogtime;
			echo json_encode($chat);
		}
		wp_die();
	}
    /*
     * wbca_set_active_chat function functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    function wbca_set_active_chat_function() {
		global $wpdb;
        header("Content-Type: application/json");
		
		 $lang = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		
		 
		 $user_ag = $_SERVER['HTTP_USER_AGENT'];
		 if(preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis',$user_ag)){
			 $is_phone = 'yes';
		 }else{
			 $is_phone = 'no';
		 }
		 $browserName = $_POST["browserName"];
		 $location = $_POST["location"];
		 $ClientID = $_POST["cw_clientid"];
		 $time_zone = $_POST["tz"];
		 $userAgent = $_POST["userAgent"];
		 $screen_resolution = $_POST["screen_resolution"];
		 $OSName = $_POST["OSName"];
		 $IP = $_SERVER['REMOTE_ADDR'];
		 $MAC = exec('getmac');
		 $MAC = strtok($MAC, ' ');
		 $sql = "SELECT * FROM {$wpdb->prefix}wbca_user_personal_info where USER_ID = ".$ClientID;
		 $pdata = $wpdb->get_row($sql);
		 if(!empty($pdata)){
			$wpdb->update( 
				$wpdb->prefix.'wbca_user_personal_info', 
				array(
					'USER_ID' => $ClientID,
					'macadd' => $MAC,
					'ipadd' => $IP, 
					'browser' => $browserName,
					'is_phone' => $is_phone,
					'page_url' => $location,
					'lang' => $lang[0],
					'os_name' => $OSName,
					'userAgent' => $userAgent,
					'time_zone' => $time_zone,
					'screen_resolution' => $screen_resolution,

				),
				array('USER_ID' => $ClientID)
			);
		}else{
			$wpdb->insert( 
				$wpdb->prefix.'wbca_user_personal_info', 
				array(
					'USER_ID' => $ClientID,
					'macadd' => $MAC,
					'ipadd' => $IP, 
					'browser' => $browserName,
					'is_phone' => $is_phone,
					'page_url' => $location,
					'lang' => $lang[0],
					'os_name' => $OSName,
					'userAgent' => $userAgent,
					'time_zone' => $time_zone,
					'screen_resolution' => $screen_resolution,
				)
			);
		}
		$chat = array();
		$a = &$chat;
		
		$ClientID = $_POST["cw_clientid"];
		
		if(!isset($_SESSION["ClientChatStored"]))
			$_SESSION["ClientChatStored"] = array();
		
		$_SESSION["ClientChatStored"][$ClientID] = array("CLIENTID" => $ClientID);
		
		echo json_encode($chat);
        exit;
    }

    /*
     * wbca_remove_active_chat function functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    function wbca_remove_active_chat_function() {
		
		header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;
		
		
		$ClientID = $_POST["cr_clientid"];
		
		if(!isset($_SESSION["ClientChatStored"]))
			$_SESSION["ClientChatStored"] = array();
		
		if(array_key_exists($ClientID, $_SESSION["ClientChatStored"]))
			unset($_SESSION["ClientChatStored"][$ClientID]);
		
		$a["cacheData"] =$_SESSION["ClientChatStored"];
		
		echo json_encode($chat);
        
        exit;
    }

    /*
     * wbca_load_active_chat function functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    function wbca_load_active_chat_function() {
		
		header("Content-Type: application/json");
		$chat = array();
		$a = &$chat;
				
		if(!isset($_SESSION["ClientChatStored"]))
			$_SESSION["ClientChatStored"] = array();
		
		$a["ClientChatStored"] = $_SESSION["ClientChatStored"];
				
		echo json_encode($chat);
        
        exit;
    }
	
	/*
     * Generate random string for activation code
     *
     * @param  -
     * @return string
     */

    public function random_string() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstr = '';
        for ($i = 0; $i < 15; $i++) {
            $randstr .= $characters[rand(0, strlen($characters))];
        }
        return $randstr;
    }
	
}



?>
