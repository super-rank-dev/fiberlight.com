<?php

class wbca_Admin_Ajax {

    public $ajax_actions;
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
			"wbca_update_notification_status" => array("action" => "wbca_update_notification_status_action", "function" => "wbca_update_notification_status_function"),
			"wbca_load_admin_chat" => array("action" => "wbca_load_admin_chat_action", "function" => "wbca_load_admin_chat_function"),
			"wbca_load_all_admin_chat" => array("action" => "wbca_load_all_admin_chat_action", "function" => "wbca_load_all_admin_chat_function"),
			"wbca_admin_submit_message" => array("action" => "wbca_admin_submit_message_action", "function" => "wbca_admin_submit_message_function"),
			"wbca_admin_chat_transfer" => array("action" => "wbca_admin_chat_transfer_action", "function" => "wbca_admin_chat_transfer_function"),
			"wbca_fetch_transferred_client_msg" => array("action" => "wbca_fetch_transferred_client_msg_action", "function" => "wbca_fetch_transferred_client_msg_function"),
			"wbca_set_admin_active_chat" => array("action" => "wbca_set_admin_active_chat_action", "function" => "wbca_set_admin_active_chat_function"),
			"wbca_remove_admin_active_chat" => array("action" => "wbca_remove_admin_active_chat_action", "function" => "wbca_remove_admin_active_chat_function"),
			"wbca_load_admin_active_chat" => array("action" => "wbca_load_admin_active_chat_action", "function" => "wbca_load_admin_active_chat_function"),
			"wbca_search_content" => array("action" => "wbca_search_content_action", "function" => "wbca_search_content_function"),
			"wbca_add_search_content" => array("action" => "wbca_add_search_content_action", "function" => "wbca_add_search_content_function"),
			"wbca_edit_search_content" => array("action" => "wbca_edit_search_content_action", "function" => "wbca_edit_search_content_function"),
			"wbca_edit_search_nav" => array("action" => "wbca_edit_search_nav_action", "function" => "wbca_edit_search_nav_function"),
			"wbca_edit_nav_button" => array("action" => "wbca_edit_nav_button_action", "function" => "wbca_edit_nav_button_function"),
			"wbca_delete_search_row" => array("action" => "wbca_delete_search_row_action", "function" => "wbca_delete_search_row_function"),
			"wbca_go_operator_offline" => array("action" => "wbca_go_operator_offline_action", "function" => "wbca_go_operator_offline_function"),
			"wbca_client_chat_history" => array("action" => "wbca_client_chat_history_action", "function" => "wbca_client_chat_history"),
			"wbca_client_personal_info" => array("action" => "wbca_client_personal_info", "function" => "wbca_client_personal_info"),
			"wbca_client_session_history" => array("action" => "wbca_client_session_history", "function" => "wbca_client_session_history"),
			"wbca_load_client_admin_chat" => array("action" => "wbca_load_client_admin_chat_action", "function" => "wbca_load_client_admin_chat_function"),
			"wbca_client_department" => array("action" => "wbca_client_department","function" => "wbca_client_department"),
			"wbca_insert_department" => array("action"=>"wbca_insert_department", "function"=> "wbca_insert_department"),
			"wbca_delete_department" => array("action"=> "wbca_delete_department", "function" => "wbca_delete_department"),
			"available_department" => array("action"=> "available_department", "function" => "available_department"),
			"departmental_oparetor" => array("action"=> "departmental_oparetor", "function" => "departmental_oparetor"),
			"remove_from_department" => array("action"=> "remove_from_department", "function" => "remove_from_department"),
			"add_to_department" => array("action" => "add_to_department","function"=> "add_to_department"),
			
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
	public function wbca_client_chat_history(){
		global $wpdb;
		$client_id = sanitize_text_field($_POST['client_id']);
		$UserId = get_current_user_id();
		$read = 1;

		$Message_history = $wpdb->get_results($wpdb->prepare("SELECT id,max(has_attachment) AS has_attachment,CAST(chat_time AS date) AS date FROM {$wpdb->prefix}wbca_message WHERE user_receiver = $UserId AND user_sender = $client_id AND chat_read = 1 GROUP BY CAST(chat_time AS DATE) ORDER BY id ASC LIMIT 15;"));
		
		wp_send_json(array('success' => true, 'Message_history' => $Message_history));
		wp_die();
	}
	public function wbca_update_notification_status_function(){
		global $wpdb;
		$chatID = sanitize_text_field($_POST['chatID']);
		
		$wpdb->update(
			$wpdb->prefix."wbca_message",
			array( 'buzzer' => 1), array( 'id' => $chatID )
		);
		wp_send_json(array('success' => true, 'buzzer' => 1));
		wp_die();
	}
	public function wbca_insert_department(){
		global $wpdb;
		$department = sanitize_text_field($_POST['department_name']);
		$wpdb->insert( $wpdb->prefix.'wbca_department', array( 'department' => $department ) );
		wp_send_json(array('success' => true));
		wp_die();
	} 
	public function wbca_delete_department(){
		global $wpdb;
		$department_id = sanitize_text_field($_POST['department_id']);
		$department_table = $wpdb->prefix.'wbca_department';
		//$department_table = $wpdb->prefix.'wbca_department';
		$result = $wpdb->query( "DELETE FROM $department_table WHERE id = $department_id" );
		//$wpdb->query( "DELETE FROM $department_table WHERE id = $id" );
		wp_send_json(array('success' => true));
		wp_die();
	}
	public function departmental_oparetor(){
		global $wpdb;
		$dept_id = sanitize_text_field($_POST['dept_id']);
		$args = array(
			'role__in'    => array( 'Operator','Administrator'),
		);
		$users = get_users( $args );
		$operators = [];
		foreach ($users as $key => $user) {
			$user_id = $user->data->ID;
			$user_nickname =$user->data->user_nicename;
			$sql_usercheck = "SELECT id FROM {$wpdb->prefix}wbca_user_department WHERE user_id = $user_id AND dept_id = $dept_id;";
			$user_check = $wpdb->get_results($wpdb->prepare($sql_usercheck));
			if( sizeof($user_check) >= 1):
				array_push($operators,[$user_id,$user_nickname]);
			endif;
		}
		wp_send_json(array('success' => true, 'operators' => $operators));
		wp_die();
	}
	public function add_to_department(){
		global $wpdb;
		$operetor_id = sanitize_text_field($_POST['operetor_id']);
		$dept_id = sanitize_text_field($_POST['dept_id']);
		$dept_id = (int)$dept_id;
		$wpdb->insert( 
			$wpdb->prefix.'wbca_user_department', 
			array( 
				'user_id' => $operetor_id, 
				'dept_id' => $dept_id,
			)
		);
	}
	public function remove_from_department(){
		global $wpdb;
		$operetor_id = sanitize_text_field($_POST['operetor_id']);
		$dept_id = sanitize_text_field($_POST['dept_id']);
		$dept_id = (int)$dept_id;
		$delete = $wpdb->delete( 
			$wpdb->prefix.'wbca_user_department',
			array( 'user_id' => $operetor_id,'dept_id' => $dept_id )
			);

	}
	public function available_department(){
		global $wpdb;
		$dept_id = sanitize_text_field($_POST['dept_id']);
		$dept_id = (int)$dept_id;
		$args = array(
			'role__in'    => array( 'Operator','Administrator'),
		);
		$users = get_users( $args );
		$sql_usercheck = "SELECT user_id FROM {$wpdb->prefix}wbca_user_department WHERE dept_id = $dept_id";
		$user_check = $wpdb->get_results($wpdb->prepare($sql_usercheck));
		
		$operators = [];
		foreach ($users as $key => $user) {
			$user_id = $user->data->ID;
			$user_nickname =$user->data->user_nicename;
				$operators[$user_id] = [$user_id,$user_nickname];
		}
		foreach ($user_check as $value) {
			unset($operators[$value->user_id]);
		}
		wp_send_json(array('success' => true, 'operators' => $operators));
		wp_die();
	}
	public function wbca_client_department(){
		global $wpdb;
		$department_list = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wbca_department;"));
		wp_send_json(array('success' => true, 'department_list' => $department_list,'home_url' => home_url()));
		wp_die();
	}
	public function wbca_client_personal_info(){
		global $wpdb;
		$client_id = sanitize_text_field($_POST['client_id']);
		$table_personal_info   = $wpdb->prefix.'wbca_user_personal_info';
		$personal_info = $wpdb->get_results($wpdb->prepare("SELECT p.ipadd,p.USER_ID,p.browser,p.page_url,p.lang,p.is_phone,p.os_name,p.userAgent,p.time_zone,p.screen_resolution FROM $table_personal_info AS p LEFT JOIN {$wpdb->prefix}users AS u ON p.USER_ID = u.ID WHERE u.ID = $client_id GROUP BY p.USER_ID;"));
		wp_send_json(array('success' => true, 'Message_history' => $personal_info));
		wp_die();
	}
	public function wbca_client_session_history(){
		global $wpdb;
		$client_id = sanitize_text_field($_POST['client_id']);
		$tableuser    = $wpdb->prefix.'wpbot_user';
		$Message_history = $wpdb->get_results($wpdb->prepare("SELECT c.id,c.name,c.email,c.phone,c.date FROM {$wpdb->prefix}wpbot_user AS c LEFT JOIN {$wpdb->prefix}users AS u ON c.email = u.user_email WHERE u.ID = $client_id;"));
		wp_send_json(array('success' => true,'url' => get_admin_url(), 'session_history' => $Message_history));
		wp_die();
	}
	public function wbca_go_operator_offline_function(){
		$user_id = sanitize_text_field($_POST['user_id']);
		$online_status = sanitize_text_field($_POST['online_satuts']);
		$is_operetor_offline = '';
		if($online_status == 'online'){
			$is_operetor_offline = 'no';
		}
		if($online_status == 'offline'){
			$is_operetor_offline = 'yes';
		}
		update_user_meta( $user_id, 'wbca_login_status', strval($online_status) );
		update_user_meta( $user_id, 'wbca_operetor_offline', strval($is_operetor_offline) );
		$msg = get_user_meta( $user_id, 'wbca_login_status',true);

		wp_send_json(array('success' => true, 'online_status' => $msg));
		wp_die();
	} 
	public function wbca_delete_search_row_function() {
		header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;		
		$rowid = $_POST["search_rowid"];
		global $wpdb;
		$wpdb->show_errors = true;
		// Using where formatting.
		$result = $wpdb->delete( 
								$wpdb->prefix.'wbca_search_document',
								array( 'DOCUMENT_ID' => $rowid ), 
								array( '%d' ) 
								);
		if($result){
			$a["is_delete"] = 1;
		}else{
			$a["is_delete"] = 0;
		}
		$a["delete_id"] = $rowid;
		echo json_encode($chat);
		exit;
		return $result;
	}
	
    public function wbca_load_admin_chat_function() {
		header("Content-Type: application/json");
		$data = get_option('wbca_options');
		$chat = array();
		$a = &$chat;
		$a["wbca_clientinfo"] = array();		
		$a["wbca_chatinfo"] = array();
		$a["wbca_searchinfo"] = array();
		$a["wbca_activeclient"] = $_SESSION["AdminStoredChat"];
		$a["wbca_all_activesession"] = array(); 
        $chatAray = array();
	
		global $wpdb;
		$wpdb->show_errors = true;
		
		$UserId = get_current_user_id();
		
		$userdata=get_user_by('ID', $UserId);

		if(in_array('administrator', $userdata->roles)){
			if(isset($data['admin_able_to_chat']) && $data['admin_able_to_chat']==true){
				$wpdb->update(
			        $wpdb->prefix."wbca_message",
			        array(
				        'user_receiver'  => $UserId,
			        ),
                    array('user_receiver'=>0),
                    array(
                        '%d',
                    ),
                    array('%d')
		        );
			}
		}elseif(in_array('operator', $userdata->roles)){
			$wpdb->update(
				$wpdb->prefix."wbca_message",
				array(
					'user_receiver'  => $UserId,
				),
				array('user_receiver'=>0),
				array(
					'%d',
				),
				array('%d')
			);
		}
		
		$read = 0;
		$blogtime = current_time( 'mysql' );
		//AND DATE_ADD( im.chat_time, INTERVAL 5 MINUTE ) >= '%s'
		$clientQuery = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT u.display_name, u.user_email, u.user_login, im.user_sender 
														FROM $wpdb->users u, {$wpdb->prefix}wbca_message im 
														WHERE u.ID = im.user_sender 
														AND im.user_receiver = '%d' 
														AND im.chat_read = '%d' 
														
														ORDER BY im.id DESC 
														LIMIT 15", $UserId, $read));
		if(count($clientQuery) > 0) {
			foreach($clientQuery as $clientInfo) {
				$ClientId = $clientInfo->user_sender;
				$string = stripslashes(htmlspecialchars($clientInfo->display_name));
				$ClientName = (strlen($string) > 18) ? substr($string,0,16).'..' : $string;
				$ClientEmail = $clientInfo->user_email;
				$ClientUserName = $clientInfo->user_login;

				$getAvater = str_replace('&','&amp;',get_avatar($ClientId));
				if(trim($getAvater)!=''){
					$doc = new DOMDocument();
					$doc->loadHTML($getAvater);
					$xpath = new DOMXPath($doc);
					
					$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
				} else {
					$src = esc_url( get_avatar_url( $ClientId ) );
				}
				

				$a["wbca_clientinfo"][$ClientId] = array("clientname" => $ClientName, 
														"clientemail" => $ClientEmail, 
														"clientusername"=> $ClientUserName,
														"avatar"=> $src
														);
							
				$MessageSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wbca_message WHERE user_receiver = '%d' AND user_sender = '%d' AND chat_read = '%d' ORDER BY id ASC LIMIT 15", $UserId, $ClientId, $read));
			
				foreach($MessageSQL as $Row) {
					$chatID = $Row->id;
					$chatAray[] = $Row->id;
					$senderID = $Row->user_sender;
					$receiverID = $Row->user_receiver;
					$buzzer = $Row->buzzer;
					$chat_time = $Row->chat_time;
					$message = stripslashes($Row->message);

					$a["wbca_chatinfo"][$chatID] = array("senderid" => $senderID, 
														"receiverid" => $receiverID, 
														"message"=> $message,
														"buzzer" => $buzzer,
														"chat_time"=> $chat_time
														);
					
					$words = array();
					$words = str_word_count(strip_tags( $message ), 1);//$this->explode_items(strip_tags( $message ), ' ', false);
					
					$stop_words = array();
					$stop_word = array("a","by","I","she","us","about","could","if","so","was","also","do","in","that","we","am","for","is","the","were","an","from","it","their","what","and","had","let","them","when","any","has","me","then","where","are","ave","mine","there","which","as","he","my","these","while","at","her","of","they","why","be","him","on","this","with","been","his","or","through","you","being","hers","over","to","your","but","how","put","too");
					
					for($x = 0; $x < count($stop_word); $x++) {
						$stop_words[$stop_word[$x]] = true;
					}
				
					$words_removed = array();
					
					foreach ($words as $index => $word){
						if (isset($stop_words[strtolower($word)])){
							$words_removed[] = $word;
							unset($words[$index]); 
						}
					}
					// begin processing query
					if (count($words) > 0){
						// spell check the query words
						$spell_error = false;
						$suggest_words = array();
						$join = '';
						$where = '';
						$prefix = $wpdb->prefix;	
						$query = 'SELECT DISTINCT D.DOCUMENT_ID, D.DOCUMENT_TITLE, D.DESCRIPTION FROM '.$prefix.'wbca_search_document D ';
						foreach ($words as $index => $word){
							$cleared_word = strip_tags(strtolower($word));
							$join .= sprintf( 'JOIN '.$prefix.'wbca_search_index I%d ON D.DOCUMENT_ID = I%d.DOCUMENT_ID 
												JOIN '.$prefix.'wbca_search_term T%d ON I%d.TERM_ID = T%d.TERM_ID ', $index, $index, $index, $index, $index);
						
							$where .= sprintf('T%d.TERM_VALUE = "%s" AND ', $index, $cleared_word);
						}
						$query .= $join . 'WHERE ' . $where;
									
						// trimmed 4 characters o remove trailing ' AND'
						$query = substr($query, 0, strlen($query) - 4);
						$query .= ' LIMIT 10';
						$result = $wpdb->get_results($query);
						
						if(count($result) > 0) {
							foreach ($result as $row){
								$a["wbca_searchinfo"][$senderID] = array("chatid" => $chatID, 
														"docid" => $row->DOCUMENT_ID, 
														"doctitle"=> $row->DOCUMENT_TITLE,
														"docdesc"=> $row->DESCRIPTION
														);
							}
						}
					}
				}
			}
		}else{
			// $is_operetor_offline = get_user_meta( $UserId, 'wbca_operetor_offline');
			// if($is_operetor_offline == 'no'){
			// 	update_user_meta( $UserId, 'wbca_login_status', 'online' );
			// }
		}

		if(!empty($chatAray)) {
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
		$blogtime = current_time( 'mysql' ); 
		update_user_meta( $UserId, 'wbca_login_time', $blogtime );
		$all_operator = $wpdb->get_results($wpdb->prepare("SELECT um.user_id FROM {$wpdb->prefix}usermeta As um WHERE um.meta_key= 'wbca_login_status' AND um.meta_value = 'online'"));
		update_user_meta( $UserId, 'current_chat_seesion', $_SESSION["AdminStoredChat"] );
		
		foreach ($all_operator as $key => $value) {
			$user_info = get_userdata( $value->user_id );
			$oparetor_session = get_user_meta( $value->user_id, 'current_chat_seesion');
			$a["wbca_all_activesession"][$user_info->user_login]= $oparetor_session;
		
		}
		echo json_encode($chat);
		exit;
		
    }
	
	public function wbca_fetch_transferred_client_msg_function(){
		
		$chat = array();
		$a = &$chat;
		$wbca_clientid = $_POST["wbca_clientid"];
		$wbca_chatid = $_POST["wbca_chatid"];
		
		$a["wbca_msg_row"] = array();
		
        $chatAray = array();
	
		global $wpdb;
		$wpdb->show_errors = true;
		
		$UserId = get_current_user_id();
		
		$MessageSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wbca_message WHERE user_sender = '%d' AND id != '%d' ORDER BY id DESC LIMIT 5", $wbca_clientid, $wbca_chatid));
		
		if(!empty($MessageSQL)){
			foreach($MessageSQL as $Row) {
				$chatID = $Row->id;
				$chatAray[] = $Row->id;
				$senderID = $Row->user_sender;
				$receiverID = $Row->user_receiver;
				$chat_time = $Row->chat_time;
				$message = stripslashes($Row->message);

				$a["wbca_msg_row"][$chatID] = array("senderid" => $senderID, 
													"receiverid" => $receiverID, 
													"message"=> $message,
													"chat_time"=> $chat_time
													);
			}
			$a["is_result"] = 1;
		}else{
			$a["is_result"] = 0;
		}
		$a["wbca_chatid"] = $wbca_chatid;
		
		echo json_encode($chat);
		exit;
		
	}
	
 	/*
     * wbca_load_all_admin_chat functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    public function wbca_load_all_admin_chat_function() {

        header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;		
		$a["allmessages"] = array();
		
		global $wpdb;
		$wpdb->show_errors = true;
		
		$UserId = get_current_user_id();
		
		$senderID = $_POST["senderID"];
				
		$MessageSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wbca_message WHERE (user_receiver = '%d' AND user_sender = '%d') or (user_receiver = '%d' AND user_sender = '%d') ORDER BY id DESC LIMIT 15", $UserId, $senderID, $senderID, $UserId));
		
		$Cached = array();
		
		foreach($MessageSQL as $Row) {
			$userMessage = $Row->user_sender == $UserId;
			if($Row->user_sender == $senderID){
				$chatID = $Row->id;
			}
			
			$getAvater = get_avatar($userMessage ? $UserId : $senderID);
			$doc = new DOMDocument();
			$doc->loadHTML($getAvater);
			$xpath = new DOMXPath($doc);
			$src = str_replace('&','&amp;',$xpath->evaluate("string(//img/@src)")); # "/images/image.jpg"
	
			if($userMessage){
				$msg = '<div class="wbca_admin_message_row wbca_message_row wbca-clear"><div class="wbcaMessage rightMessage ui floating message"><div data-chatid="'.$Row->id.'" class="wbcaContent wbcaMessageLocation-'.$senderID.'">'.stripslashes($Row->message).'</div></div></div><div class="date-user">'.$Row->chat_time.'</div>';
			}else{
				$msg = '<div class="wbca_client_message_row wbca_message_row wbca-clear"><div class="wbcaMessage leftMessage ui floating message"><div data-chatid="'.$Row->id.'" class="wbcaContent wbcaMessageLocation-'.$senderID.'"><span class="wbca_msg_span">'.stripslashes($Row->message).'</span></div></div></div><div class="date-operator">'.$Row->chat_time.'</div>';
			}
			array_push($Cached, $msg);
			
			$wpdb->update( $wpdb->prefix.'wbca_message', array( 'chat_read' => 1),array( 'id' => $chatID ));
		}
		
		for($i = count($Cached); $i > -1; $i--){
			$a["allmessages"][$senderID] .= $Cached[$i];
		}
		
		echo json_encode($chat);
		exit;
    }	
	public function wbca_load_client_admin_chat_function(){
		header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;		
		$a["allmessages"] = array();
		
		global $wpdb;
		$wpdb->show_errors = true;
		
		$UserId = get_current_user_id();
		
		$senderID = sanitize_text_field($_POST["senderID"]);
		
		$date = sanitize_text_field($_POST['chat_date']);
				
		$MessageSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wbca_message WHERE (chat_time BETWEEN '$date 00:00:01' and '$date 23:59:59') AND ((user_receiver = $UserId AND user_sender = $senderID ) OR (user_receiver =  $senderID AND user_sender = $UserId)) ORDER BY id DESC LIMIT 15"));

		
		$Cached = array();
		
		foreach($MessageSQL as $Row) {
			$userMessage = $Row->user_sender == $UserId;
			if($Row->user_sender == $senderID){
				$chatID = $Row->id;
			}
			
			$getAvater = get_avatar($userMessage ? $UserId : $senderID);
			$doc = new DOMDocument();
			$doc->loadHTML($getAvater);
			$xpath = new DOMXPath($doc);
			$src = str_replace('&','&amp;',$xpath->evaluate("string(//img/@src)")); # "/images/image.jpg"
	
			if($userMessage){
				$msg = '<div class="wbca_admin_message_row wbca_message_row wbca-clear"><div class="wbcaMessage rightMessage ui floating message"><div data-chatid="'.$Row->id.'" class="wbcaContent wbcaMessageLocation-'.$senderID.'">'.stripslashes($Row->message).'</div></div></div><div class="date-user">'.$Row->chat_time.'</div>';
			}else{
				$msg = '<div class="wbca_client_message_row wbca_message_row wbca-clear"><div class="wbcaMessage leftMessage ui floating message"><div data-chatid="'.$Row->id.'" class="wbcaContent wbcaMessageLocation-'.$senderID.'"><span class="wbca_msg_span">'.stripslashes($Row->message).'</span></div></div></div><div class="date-operator">'.$Row->chat_time.'</div>';
			}
			array_push($Cached, $msg);
			
			$wpdb->update( $wpdb->prefix.'wbca_message', array( 'chat_read' => 1),array( 'id' => $chatID ));
		}
		
		for($i = count($Cached); $i > -1; $i--){
			$a["allmessages"][$senderID] .= $Cached[$i];
		}
		
		echo json_encode($chat);
		exit;
	}
		
	
	 /*
     * wbca_admin_submit_message functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    public function wbca_admin_submit_message_function() {

        header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;
		
		global $wpdb;
		$wpdb->show_errors = true;
		
		$message = $_POST["messagecontent"];
		$clientid = $_POST["clientid"];
		$question = $_POST["question"];
		$userid = $_POST["userid"];
		if(!empty($userid)){
			$UserId =$userid;
		}else{
			$UserId = get_current_user_id();
		}
		
		$blogtime = current_time( 'mysql' );
		$read = 0;
			
		$result = $wpdb->insert( 
			$wpdb->prefix.'wbca_message', 
			array( 
				'user_sender' => $UserId, 
				'user_receiver' => $clientid,
				'message' => $message,
				'chat_read' => $read,
				'chat_time' => $blogtime,
			), 
			array( 
				'%d', 
				'%d',
				'%s',
				'%d',
				'%s',
			) 
		);
		if($result){
			$a["is_submit"] = 1;
			$a["is_insert"] = false;
		}else{
			$a["is_submit"] = 0;
		}
		
		echo json_encode($chat);
        exit;
    }

	 /*
     * wbca_admin_chat_transfer functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    public function wbca_admin_chat_transfer_function() {

        header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;
		
		global $wpdb;
		$wpdb->show_errors = true;
		
		$message = $_POST["wbca_message"];
		$clientid = $_POST["wbca_clientid"];
		$operatorid = $_POST["wbca_operatorid"];
		$UserId = get_current_user_id();
		$blogtime = current_time( 'mysql' );
		$read = 0;
		$transfer = 1;
		$result = $wpdb->insert( 
			$wpdb->prefix.'wbca_message', 
			array( 
				'user_sender' => $clientid, 
				'user_receiver' => $operatorid,
				'message' => $message,
				'chat_read' => $read,
				'chat_time' => $blogtime,
				'wbca_transferred' => $transfer,
			), 
			array( 
				'%d', 
				'%d',
				'%s',
				'%d',
				'%s',
				'%d'
			) 
		);
		$a["wbca_clientid"] = $clientid;
		if($result){
			$a["wbca_submit"] = 1;
		}else{
			$a["wbca_submit"] = 0;
		}
		
		echo json_encode($chat);
        exit;
    }

    /*
     * wbca_set_admin_active_chat function functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    public function wbca_set_admin_active_chat_function() {
        header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;

		$ClientID = $_POST["ac_clientid"];
		$ClientName = $_POST["ac_clientname"];
		$ClientEmail = $_POST["ac_clientemail"];
		$avatar = $_POST["ac_avatar"];
		
		if(!isset($_SESSION["AdminStoredChat"])){
			$_SESSION["AdminStoredChat"] = array();
		}
		
		$_SESSION["AdminStoredChat"][$ClientID] = array("WINDOWID" => $ClientID, "USERNAME" => $ClientName, "CLIENTEMAIL" => $ClientEmail, "AVATAR" => $avatar);

		echo json_encode($chat);
        exit;
    }

    /*
     * wbca_remove_admin_active_chat function functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    public function wbca_remove_admin_active_chat_function() {
		header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;
		
		$ClientID = $_POST["rm_clientid"];
		
		if(!isset($_SESSION["AdminStoredChat"]))
			$_SESSION["AdminStoredChat"] = array();
		
		if(array_key_exists($ClientID, $_SESSION["AdminStoredChat"]))
			unset($_SESSION["AdminStoredChat"][$ClientID]);
		
		$a["cacheData"] = $_SESSION["AdminStoredChat"];
		
		echo json_encode($chat);
        
        exit;
    }

    /*
     * wbca_load_admin_active_chat function functions for handling AJAX request
     *
     * @param  -
     * @return -
     */

    public function wbca_load_admin_active_chat_function() {
		header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;
			 	
		if(!isset($_SESSION["AdminStoredChat"]))
			$_SESSION["AdminStoredChat"] = array();
		
		$a["AdminStoredChat"] = $_SESSION["AdminStoredChat"];
		
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
	
	// convert a list of items (separated by newlines by default) into an array
	// omitting blank lines and optionally duplicates
	public function explode_items($text, $separator = "\n", $preserve = true){
		$items = array();
		foreach (explode($separator, $text) as $value){
			$tmp = trim($value);
			if ($preserve){
				 $items[] = $tmp;
			}else{
				if (!empty($tmp)){
					$items[$tmp] = true;
				}
			}
		}
	
		if ($preserve){
			return $items;
		}else{
			return array_keys($items);
		}
	}
	// stop word generator
	public function stop_words(){
		$stop_words = array();
		$word = array("a","by","I","she","us","about","could","if","so","was","also","do","in","that","we","am","for","is","the","were","an","from","it","their","what","and","had","let","them","when","any","has","me","then","where","are","ave","mine","there","which","as","he","my","these","while","at","her","of","they","why","be","him","on","this","with","been","his","or","through","you","being","hers","over","to","your","but","how","put","too");
		
		for($x = 0; $x < count($word); $x++) {
			$stop_words[$word[$x]] = true;
		}
		return $stop_words;
	}
	
	/*
	 * wbca_search_content_function
	 *
	*/
	
	public function wbca_search_content_function(){
		header("Content-Type: application/json");
		$chat = array();
		$a = &$chat;
		global $wpdb;
		$wpdb->show_errors = true;
		$wbca_search = $_POST["wbca_search_query"];
		$client_id = $_POST["wbca_search_id"];
		$words = array();
		
		if(isset($wbca_search)){
			
			$words = str_word_count(strip_tags( $wbca_search ), 1);
			//$this->explode_items(strip_tags( $wbca_search ), ' ', false);
		
			$stop_words = array();

			$stop_word = array("a","by","I","she","us","about","could","if","so","was","also","do","in","that","we","am","for","is","the","were","an","from","it","their","what","and","had","let","them","when","any","has","me","then","where","are","ave","mine","there","which","as","he","my","these","while","at","her","of","they","why","be","him","on","this","with","been","his","or","through","you","being","hers","over","to","your","but","how","put","too");
			
			for($x = 0; $x < count($stop_word); $x++) {
				$stop_words[$stop_word[$x]] = true;
			}
		
			$words_removed = array();
			
			foreach ($words as $index => $word){
				if (isset($stop_words[strtolower($word)])){
					$words_removed[] = $word;
					unset($words[$index]); 
				}
			}
		}
		// begin processing query
		if (count($words) > 0){
			// spell check the query words
			$spell_error = false;
			$suggest_words = array();
			if(function_exists('pspell_new')){
				$ps = pspell_new('en');
				foreach ($words as $index => $word){
					if (!pspell_check($ps, $word)){
						if ($s = pspell_suggest($ps, $word)){
							if (strtolower($s[0]) != strtolower($word)) {
								// (ignore capitalization-related spelling errors)
								$spell_error = true;
								$suggest_words[$index] = $s[0];
							}
						}
					}
				}
			}
			// formulate the search query using provided terms and submit it
			$join = '';
			$where = '';
			$prefix = $wpdb->prefix;	
																	
			$query = 'SELECT DISTINCT D.DOCUMENT_ID, D.DOCUMENT_TITLE, D.DESCRIPTION FROM '.$prefix.'wbca_search_document D ';
			
			foreach ($words as $index => $word){
				$cleared_word = strip_tags(strtolower($word));
				$join .= sprintf( 'JOIN '.$prefix.'wbca_search_index I%d ON D.DOCUMENT_ID = I%d.DOCUMENT_ID 
									JOIN '.$prefix.'wbca_search_term T%d ON I%d.TERM_ID = T%d.TERM_ID ', $index, $index, $index, $index, $index);
			
				$where .= sprintf('T%d.TERM_VALUE = "%s" AND ', $index, $cleared_word);
			}
			$query .= $join . 'WHERE ' . $where;
						
			// trimmed 4 characters o remove trailing ' AND'
			$query = substr($query, 0, strlen($query) - 4);
			
			$query .= 'LIMIT 10';
			
			
			$result = $wpdb->get_results($query);
			
			$total = $wpdb->num_rows;
			
			$a["total_search_result"] = $total. ' match'.(($total > 1) ? 's' : '').' found.';
					
			// show suggested query if a possible misspelling was found
			$a["wbca_mispelled_data"] = '';
			if ($spell_error){
				foreach ($words as $index => $word){
					if (isset($suggest_words[$index])){
						$words[$index] = $suggest_words[$index]; 
					}
				}
				$a["wbca_mispelled_data"] .= '<p>Did you mean <a data-event="wbca_search_mispelled" data-clientid="'.$client_id.'" href="">' . 
					htmlspecialchars(join(' ', $words)) . '</a>?</p>';
			}
						
			$a["wbca_search_data"] = '<ul class="wbca_auto_chat_row">';
			if(count($result) > 0) {
				foreach ($result as $row){
					$a["wbca_search_data"] .= '<li id="docid_'.$row->DOCUMENT_ID.'">';
						$a["wbca_search_data"] .= '<div class="wbca-clear" data-titleid="'.$row->DOCUMENT_ID.'">';
						$a["wbca_search_data"] .= '<b class="wbca_auto_title" data-clientid="'.$client_id.'" data-titleid="'.$row->DOCUMENT_ID.'" data-event="send-to-chat-form">'.htmlspecialchars($row->DOCUMENT_TITLE).'</b>';
						$a["wbca_search_data"] .= '<button class="expand-wbca-edit-desc" data-event="expand-wbca-edit-desc"><span>&or;</span></button>';
						$a["wbca_search_data"] .= '</div>';
						$a["wbca_search_data"] .= '<div class="wbca_edit_desc" id="descid_'.$row->DOCUMENT_ID.'" data-desc-state="0">';
						$a["wbca_search_data"] .= $row->DESCRIPTION;
						$a["wbca_search_data"] .= '</div>';
					$a["wbca_search_data"] .= '</li>';
				}
			}
			$a["wbca_search_data"] .= '</ul>';

		}

		$a["wbca_search_id"] = $client_id;
		if($result){
			$a["is_search_found"] = 1;
		}else{
			$a["is_search_found"] = 0;
		}

		echo json_encode($chat);
        exit;

	}
	
	/*
	 * wbca_edit_search_nav_function
	 *
	*/
	
	public function wbca_edit_search_nav_function(){
		header("Content-Type: application/json");
		$chat = array();
		$a = &$chat;
		global $wpdb;
		$wpdb->show_errors = true;
		$wbca_search = $_POST["wbca_edit_nav_query"];
		$words = array();
		
		if(isset($wbca_search)){
			
			$words = str_word_count(strip_tags( $wbca_search ), 1);//$this->explode_items(strip_tags( $wbca_search ), ' ', false);
		
			$stop_words = array();

			$stop_word = array("a","by","I","she","us","about","could","if","so","was","also","do","in","that","we","am","for","is","the","were","an","from","it","their","what","and","had","let","them","when","any","has","me","then","where","are","ave","mine","there","which","as","he","my","these","while","at","her","of","they","why","be","him","on","this","with","been","his","or","through","you","being","hers","over","to","your","but","how","put","too");
			
			for($x = 0; $x < count($stop_word); $x++) {
				$stop_words[$stop_word[$x]] = true;
			}
		
			$words_removed = array();
			
			foreach ($words as $index => $word){
				if (isset($stop_words[strtolower($word)])){
					$words_removed[] = $word;
					unset($words[$index]); 
				}
			}
		}
		// begin processing query
		if (count($words) > 0){
			// spell check the query words
			$spell_error = false;
			$suggest_words = array();
			if(function_exists('pspell_new')){
				$ps = pspell_new('en');
				foreach ($words as $index => $word){
					if (!pspell_check($ps, $word)){
						if ($s = pspell_suggest($ps, $word)){
							if (strtolower($s[0]) != strtolower($word)) {
								// (ignore capitalization-related spelling errors)
								$spell_error = true;
								$suggest_words[$index] = $s[0];
							}
						}
					}
				}
			}
			// formulate the search query using provided terms and submit it
			$join = '';
			$where = '';
			$prefix = $wpdb->prefix;	
																	
			$query = 'SELECT DISTINCT D.DOCUMENT_ID, D.DOCUMENT_TITLE, D.DESCRIPTION FROM '.$prefix.'wbca_search_document D ';
			
			foreach ($words as $index => $word){
				$cleared_word = strip_tags(strtolower($word));
				$join .= sprintf( 'JOIN '.$prefix.'wbca_search_index I%d ON D.DOCUMENT_ID = I%d.DOCUMENT_ID 
									JOIN '.$prefix.'wbca_search_term T%d ON I%d.TERM_ID = T%d.TERM_ID ', $index, $index, $index, $index, $index);
			
				$where .= sprintf('T%d.TERM_VALUE = "%s" AND ', $index, $cleared_word);
			}
			$query .= $join . 'WHERE ' . $where;
						
			// trimmed 4 characters o remove trailing ' AND'
			$query = substr($query, 0, strlen($query) - 4);
			
			$query .= 'LIMIT 10';
			
			
			$result = $wpdb->get_results($query);
			
			$total = $wpdb->num_rows;
			
			$a["total_search_result"] = $total. ' match'.(($total > 1) ? 's' : '').' found.';
					
			// show suggested query if a possible misspelling was found
			$a["wbca_mispelled_data"] = '';
			if ($spell_error){
				foreach ($words as $index => $word){
					if (isset($suggest_words[$index])){
						$words[$index] = $suggest_words[$index]; 
					}
				}
				$a["wbca_mispelled_data"] .= '<p>Did you mean <a data-event="wbca_search_mispelled" data-clientid="'.$client_id.'" href="">' . 
					htmlspecialchars(join(' ', $words)) . '</a>?</p>';
			}
						
			$a["wbca_search_data"] = '<ul id="wbca_edit_chat_row">';
			if(count($result) > 0) {
				foreach ($result as $row){
					$a["wbca_search_data"] .= '<li id="docid_'.$row->DOCUMENT_ID.'">';
						$a["wbca_search_data"] .= '<div class="wbca-clear" data-titleid="'.$row->DOCUMENT_ID.'">';
						$a["wbca_search_data"] .= '<b class="wbca_edit_title" data-event="send-to-edit-form">'.htmlspecialchars($row->DOCUMENT_TITLE).'</b>';
						$a["wbca_search_data"] .= '<button class="wbca-delete-chat-row" data-event="wbca-delete-chat-row"><span>&times;</span></button>';
						$a["wbca_search_data"] .= '<button class="expand-wbca-edit-desc" data-event="expand-wbca-edit-desc"><span>&or;</span></button>';
						$a["wbca_search_data"] .= '</div>';
						$a["wbca_search_data"] .= '<div class="wbca_edit_desc" id="descid_'.$row->DOCUMENT_ID.'" data-desc-state="0">';
						$a["wbca_search_data"] .= $row->DESCRIPTION;
						$a["wbca_search_data"] .= '</div>';
					$a["wbca_search_data"] .= '</li>';
				}
			}
			$a["wbca_search_data"] .= '</ul>';

		}

		if($result){
			$a["is_search_found"] = 1;
		}else{
			$a["is_search_found"] = 0;
		}

		echo json_encode($chat);
        exit;

	}

	/*
	 * wbca_edit_search_nav_function
	 *
	*/
	
	public function wbca_edit_nav_button_function(){
		header("Content-Type: application/json");
		$chat = array();
		$a = &$chat;
		global $wpdb;
		$wpdb->show_errors = true;
		$direction = $_POST["wbca_edit_nav_dir"];
		$page_id = (int)$_POST["wbca_edit_page_id"];
		
		// begin processing query
		if (isset($page_id)){
			// formulate the search query using provided terms and submit it
			$join = '';
			$where = '';
			$prefix = $wpdb->prefix;	
			
			$result = $wpdb->get_results('SELECT * FROM '.$prefix.'wbca_search_document ORDER BY DOCUMENT_ID ASC LIMIT '. ( ( $page_id - 1 ) * 10 ) .', 10');
														
			$a["wbca_nav_data"] = '<ul id="wbca_edit_chat_row">';
			if(count($result) > 0) {
				foreach ($result as $row){
					$a["wbca_nav_data"] .= '<li id="docid_'.$row->DOCUMENT_ID.'">';
						$a["wbca_nav_data"] .= '<div class="wbca-clear" data-titleid="'.$row->DOCUMENT_ID.'">';
						$a["wbca_nav_data"] .= '<b class="wbca_edit_title" data-event="send-to-edit-form">'.htmlspecialchars($row->DOCUMENT_TITLE).'</b>';
						$a["wbca_nav_data"] .= '<button class="wbca-delete-chat-row" data-event="wbca-delete-chat-row"><span>&times;</span></button>';
						$a["wbca_nav_data"] .= '<button class="expand-wbca-edit-desc" data-event="expand-wbca-edit-desc"><span>&or;</span></button>';
						$a["wbca_nav_data"] .= '</div>';
						$a["wbca_nav_data"] .= '<div class="wbca_edit_desc" id="descid_'.$row->DOCUMENT_ID.'" data-desc-state="0">';
						$a["wbca_nav_data"] .= $row->DESCRIPTION;
						$a["wbca_nav_data"] .= '</div>';
					$a["wbca_nav_data"] .= '</li>';
				}
			}
			$a["wbca_nav_data"] .= '</ul>';

		}

		if($result){
			$a["is_row_found"] = 1;
		}else{
			$a["is_row_found"] = 0;
		}
		$a["wbca_direction"] = $direction;
		$a["wbca_page_id"] = $page_id;

		echo json_encode($chat);
        exit;

	}	
	
	/*
	 * wbca_add_search_content_function
	 *
	*/
	
	public function wbca_add_search_content_function() {
		
		header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;
		
		global $wpdb;
		$wpdb->show_errors = true;
				
		$question = $_POST["wbca_search_question"];
		$answer = $_POST["wbca_search_answer"];
		
		$UserId = get_current_user_id();
		$result ='';
		$prefix = $wpdb->prefix;
		
		//$sql = $wpdb->prepare("INSERT INTO {$wpdb->prefix}wbca_search_document (DOCUMENT_TITLE, DESCRIPTION) values (%s, %s)", $question, $answer);
		//$result = $wpdb->query($sql);
		if(isset($answer)){
			$result = $wpdb->insert( 
				$wpdb->prefix.'wbca_search_document', 
				array( 
					'DOCUMENT_TITLE' => $question, 
					'DESCRIPTION' => $answer
				), 
				array( 
					'%s', 
					'%s'
				) 
			);
			
			$doc_id = $wpdb->insert_id;			
			
			// strip HTML tags out from the content
			$title = strip_tags($question);
			
			$stop_words = array();
	
			$stop_word = array("a","by","I","she","us","about","could","if","so","was","also","do","in","that","we","am","for","is","the","were","an","from","it","their","what","and","had","let","them","when","any","has","me","then","where","are","ave","mine","there","which","as","he","my","these","while","at","her","of","they","why","be","him","on","this","with","been","his","or","through","you","being","hers","over","to","your","but","how","put","too");
			
			for($x = 0; $x < count($stop_word); $x++) {
				$stop_words[$stop_word[$x]] = true;
			}
			// break content into individual words
			foreach (str_word_count($title, 1) as $index => $word){
				// words should be stored as lowercase for comparisons 
				$use_word = strtolower($word);
		
				// skip word if it appears in the stop words list
				if (isset($stop_words[$use_word])) continue;
							
				$termQuery = $wpdb->get_results('SELECT TERM_ID FROM '.$prefix.'wbca_search_term WHERE TERM_VALUE = "'.$use_word.'"');
				$word_id = '';
				if(count($termQuery) > 0) {
					foreach($termQuery as $term_id) {
						$word_id = $term_id->TERM_ID;
					}
				}else{
					$term_result = $wpdb->insert( 
						$wpdb->prefix.'wbca_search_term', 
						array( 
							'TERM_VALUE' => $use_word, 
						), 
						array( 
							'%s', 
						) 
					);
					$word_id = $wpdb->insert_id;
					
				}
				
				//$wpdb->flush();
				
				$index_result = $wpdb->insert( 
					$wpdb->prefix.'wbca_search_index', 
					array( 
						'TERM_ID' => $word_id, 
						'DOCUMENT_ID' => $doc_id,
						'OFSET' => $index, 
					), 
					array( 
						'%d', 
						'%d',
						'%d',
					) 
				);	
			}
		}else{
			$a["is_search_added"] = 0;
		}
		if($result){
			$a["is_search_added"] = 1;
		}else{
			$a["is_search_added"] = 0;
		}
		
		echo json_encode($chat);
        exit;

    }

	/*
	 * wbca_insert_search_content
	 *
	*/
	
	public function wbca_insert_search_content($question, $answer) {
				
		global $wpdb;
		$wpdb->show_errors = true;
				
		$UserId = get_current_user_id();
		$result ='';
		$prefix = $wpdb->prefix;
		
		if(!empty($question)){
			$result = $wpdb->insert( 
				$wpdb->prefix.'wbca_search_document', 
				array( 
					'DOCUMENT_TITLE' => $question, 
					'DESCRIPTION' => $answer,
				), 
				array( 
					'%s', 
					'%s',
				) 
			);
			
			$doc_id = $wpdb->insert_id;			
			
			// strip HTML tags out from the content
			$title = strip_tags($question);
			
			$stop_words = array();

			$stop_word = array("a","by","I","i","she","us","about","could","if","so","was","also","do","in","that","we","am","for","is","the","were","an","from","it","their","what","and","had","let","them","when","any","has","me","then","where","are","ave","mine","there","which","as","he","my","these","while","at","her","of","they","why","be","him","on","this","with","been","his","or","through","you","being","hers","over","to","your","but","how","put","too");
			
			for($x = 0; $x < count($stop_word); $x++) {
				$stop_words[$stop_word[$x]] = true;
			}
			// break content into individual words
			foreach (str_word_count($title, 1) as $index => $word){
				// words should be stored as lowercase for comparisons 
				$use_word = strtolower($word);
		
				// skip word if it appears in the stop words list
				if (isset($stop_words[$use_word])) continue;
							
				$termQuery = $wpdb->get_results('SELECT TERM_ID FROM '.$prefix.'wbca_search_term WHERE TERM_VALUE = "'.$use_word.'"');
				$word_id = '';
				if(count($termQuery) > 0) {
					foreach($termQuery as $term_id) {
						$word_id = $term_id->TERM_ID;
					}
				}else{
					$term_result = $wpdb->insert( 
						$wpdb->prefix.'wbca_search_term', 
						array( 
							'TERM_VALUE' => $use_word, 
						), 
						array( 
							'%s', 
						) 
					);
					$word_id = $wpdb->insert_id;
					
				}
								
				$index_result = $wpdb->insert( 
					$wpdb->prefix.'wbca_search_index', 
					array( 
						'TERM_ID' => $word_id, 
						'DOCUMENT_ID' => $doc_id,
						'OFSET' => $index, 
					), 
					array( 
						'%d', 
						'%d',
						'%d',
					) 
				);	
			}
			return true;
		}else{
			return false;
		}
		

    }
		
	public function wbca_edit_search_content_function() {
		
		header("Content-Type: application/json");
		
		$chat = array();
		$a = &$chat;
		
		global $wpdb;
		$wpdb->show_errors = true;
		
		$wbca_edit_search = $_POST["wbca_edit_search"];
		
		$question = $_POST["wbca_edit_search_question"];
		$answer = $_POST["wbca_edit_search_answer"];
		$docid = $_POST["wbca_edit_doc_id"];
		$UserId = get_current_user_id();
		$result ='';
		$prefix = $wpdb->prefix;
		$doc_id = '';
		if(isset($wbca_edit_search)){
			
			$delete = $wpdb->delete( 
								$wpdb->prefix.'wbca_search_document',
								array( 'DOCUMENT_ID' => $docid ), 
								array( '%d' ) 
								);
			
			$result = $wpdb->insert( 
				$wpdb->prefix.'wbca_search_document', 
				array( 
					'DOCUMENT_TITLE' => $question, 
					'DESCRIPTION' => $answer,
				), 
				array( 
					'%s', 
					'%s',
				) 
			);
			$doc_id = $wpdb->insert_id;	
			
			// strip HTML tags out from the content
			$title = strip_tags($question);
			
			$stop_words = array();

			$stop_word = array("a","by","I","she","us","about","could","if","so","was","also","do","in","that","we","am","for","is","the","were","an","from","it","their","what","and","had","let","them","when","any","has","me","then","where","are","ave","mine","there","which","as","he","my","these","while","at","her","of","they","why","be","him","on","this","with","been","his","or","through","you","being","hers","over","to","your","but","how","put","too");
			
			for($x = 0; $x < count($stop_word); $x++) {
				$stop_words[$stop_word[$x]] = true;
			}
			// break content into individual words
			foreach (str_word_count($title, 1) as $index => $word){
				// words should be stored as lowercase for comparisons 
				$use_word = strtolower($word);
		
				// skip word if it appears in the stop words list
				if (isset($stop_words[$use_word])) continue;
							
				$termQuery = $wpdb->get_results('SELECT TERM_ID FROM '.$prefix.'wbca_search_term WHERE TERM_VALUE = "'.$use_word.'"');
				$word_id = '';
				if(count($termQuery) > 0) {
					foreach($termQuery as $term_id) {
						$word_id = $term_id->TERM_ID;
					}
				}else{
					$term_result = $wpdb->insert( 
						$wpdb->prefix.'wbca_search_term', 
						array( 
							'TERM_VALUE' => $use_word, 
						), 
						array( 
							'%s', 
						) 
					);
					$word_id = $wpdb->insert_id;
					
				}
				
				//$wpdb->flush();
				
				$index_result = $wpdb->insert( 
					$wpdb->prefix.'wbca_search_index', 
					array( 
						'TERM_ID' => $word_id, 
						'DOCUMENT_ID' => $doc_id,
						'OFSET' => $index, 
					), 
					array( 
						'%d', 
						'%d',
						'%d',
					) 
				);	
			}
		}else{
			$a["is_search_updated"] = 0;
		}
		
		if($result){
			$a["is_search_updated"] = 1;
		}else{
			$a["is_search_updated"] = 0;
		}
		$a["old_row_id"] = $docid;
		$a["new_row_id"] = $doc_id;
		
		echo json_encode($chat);
        exit;

    }
	
}

?>
