<?php

class wbca_Admin_Area_Controller {
	private $plugin_name;
	private $plugin_version;
	
	function __construct(){
		add_action( 'admin_menu', array($this,'wbca_admin_menu') );
		add_action('qcbot_show_languages_livechat', array($this, 'render_tab'));
		add_action('qcbot_show_livechat_lan_fields', array($this, 'render_fields'));
		add_action('wp_ajax_settings_stand_alone',array($this,'settings_stand_alone'));
	}

	public function render_tab(){
		?>
		<li><a data-toggle="tab" href="#wp-chatbot-lng-live-chat"><?php echo esc_html__('Live Chat', 'wpchatbot'); ?></a></li>
		<?php
	}

	public function render_fields(){
		?>
		<div id="wp-chatbot-lng-live-chat" class="tab-pane fade">
			<div class="top-section">
				<div class="row">
					<div class="col-xs-12" id="wp-chatbot-language-section">
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Chat', 'wpchatbot'), 'wbca_lg_ochat', 'Chat', '');
							?>
						</div>
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Live Chat - Online', 'wpchatbot'), 'wbca_lg_online', 'Live Chat - Online', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Live Chat - Offline', 'wpchatbot'), 'wbca_lg_offline', 'Live Chat - Offline', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('We are here to help you. Please fill up the form and start chatting.', 'wpchatbot'), 'wbca_lg_we_are_here', 'We are here to help you. Please fill up the form and start chatting.', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Start Chat', 'wpchatbot'), 'wbca_lg_chat', 'Start Chat', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Operators offline. Please send your query', 'wpchatbot'), 'wbca_lg_sendq', 'Operators offline. Please send your query', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Subject', 'wpchatbot'), 'wbca_lg_subject', 'Subject', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Type Message', 'wpchatbot'), 'wbca_lg_msg', 'Type Message', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Send', 'wpchatbot'), 'wbca_lg_send', 'Send', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Full name', 'wpchatbot'), 'wbca_lg_fname', 'Full name', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Email', 'wpchatbot'), 'wbca_lg_email', 'Email', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Success! We will get back to you soon.', 'wpchatbot'), 'wbca_msg_success', 'Success! We will get back to you soon.', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Sending failed! Please try again later.', 'wpchatbot'), 'wbca_msg_failed', 'Sending failed! Please try again later.', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Type your question below and hit enter.', 'wpchatbot'), 'wbca_lg_chat_type', 'Type your question below and hit enter.', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('You are now chatting with', 'wpchatbot'), 'wbca_lg_chat_welcome', 'You are now chatting with', '');
							?>
						</div>
						
						<div class="form-group">
							<?php 
								qcld_wpbot()->helper->render_language_field(esc_html__('Please wait. Someone will be with your shortly', 'wpchatbot'), 'wbca_lg_please_wait', 'Please wait. Someone will be with your shortly', '');
							?>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	public function settings_stand_alone(){
		$enable_livechat_salone = isset($_POST['enable_livechat_salone'])? $_POST['enable_livechat_salone']:null;
		$enable_floating = isset($_POST['enable_floating'])?$_POST['enable_floating']:null;
		$enable_right = isset($_POST['enable_right'])?$_POST['enable_right']:null;
		$enable_bottom = isset($_POST['enable_bottom'])?$_POST['enable_bottom']:null;
		$img_url = isset($_POST['img_url'])?$_POST['img_url']:null;
		$position_right = isset($_POST['position_right'])?$_POST['position_right']:null;
		$position_bottom = isset($_POST['position_bottom'])?$_POST['position_bottom']:null;
		update_option('enable_livechat_salone', $enable_livechat_salone);
		update_option('enable_floating',$enable_floating);
		update_option('enable_right',$enable_right);
		update_option('enable_bottom',$enable_bottom);
		update_option('wp_chatbot_custom_icon_path',$img_url);
		update_option('position_right',$position_right);
		update_option('position_bottom',$position_bottom);
		wp_send_json(array('success' => true));
		wp_die();
	}
	public function wbca_admin_menu(){
		$this->wbca_plugin_info();
		
		if(qcld_live_is_active_white_label() && get_option('wpwl_word_wpbot')!=''){
			$menutxt = get_option('wpwl_word_wpbot');
		}else{
			if(qclivechat_is_woowbot_active()){
				$menutxt = 'Bot';
			}else{
				$menutxt = 'Bot';
			}
		}
		
        if ( current_user_can( 'read' ) ){
          $page = add_menu_page( $menutxt.' - Live Chat', $menutxt.' - Live Chat', 'read', 'wbca-chat-page', array( $this, 'wbca_chat_page' ), 'dashicons-info', '7' );
		  //add_submenu_page( 'wbca-chat-page', 'wbca - Add QA', 'Add QA', 'publish_posts', 'wbca-add-qa-page', array( $this, 'wbca_add_qa_page' ) );
		  //add_submenu_page( 'wbca-chat-page', 'wbca - Update QA', 'Edit QA', 'publish_posts', 'wbca-edit-qa-page', array( $this, 'wbca_edit_qa_page' ) );
		  
		  add_submenu_page( 'wbca-chat-page', 'Chat History', 'Chat History', 'read', 'wbca-chat-history', array( $this, 'wbca_chat_history' ) );
		  
		  add_submenu_page( 'wbca-chat-page', 'Live Chat Options', 'Live Chat Options', 'manage_options', 'wbca-chat-options', array( $this, 'wbca_chat_options' ) );
		  add_submenu_page( 'wbca-chat-page', 'Settings', 'Settings', 'manage_options', 'wbca_livechat_settings', array( $this, 'wbca_livechat_settings' ) );
		  add_submenu_page( 'wbca-chat-page', 'Departments', 'Departments', 'manage_options', 'wbca_livechat_department_section', array( $this, 'wbca_livechat_department_section' ) );
		//  add_submenu_page( 'wbca-chat-page', 'Help & License', 'Help & License', 'manage_options','qc-wplive-chat-help-license', 'qcld_livechat_license_callback' );
		  add_submenu_page( 'wbca-chat-page', null, null, 'manage_options','qcld_operator_manage', array($this, 'qcld_operator_manage') );
		  
        }
		
    }
	public function qcld_operator_manage(){
		require_once WBCA_PATH .'/admin/templates/operator_manage.php';
	}
	public function wbca_livechat_settings(){
		require_once WBCA_PATH .'/admin/templates/settings.php';
	}
	public function wbca_livechat_department_section(){
		require_once WBCA_PATH .'/admin/templates/department.php';
	}
	public function wbca_chat_options(){
		
		echo '';
	}
	
	public function wbca_chat_page(){
		$html = '';
		
		$getAvater = get_avatar(get_current_user_id());
		if(trim($getAvater)!=''){
			$doc = new DOMDocument();
			@$doc->loadHTML($getAvater);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)");
		}else{
			
			$src = esc_url( get_avatar_url( get_current_user_id() ) );
		}
		
		$user_id = get_current_user_id();
		$user = get_userdata( $user_id );
		$name = $user->display_name;
		$status = 'offline';
		if((get_user_meta($user_id, 'wbca_login_status', true)) != ''){
			$status = get_user_meta($user_id, 'wbca_login_status', true);
		}
	
		if($status == 'online'){
			$go_online_text =  'Please go offline if you are not attending the Live chat';
			$online_button_text = 'offline';
			$teal = 'teal';
		}
		if(($status == 'offline') || ($status == 'busy')) {
			$go_online_text = 'Please go online if you want to attend the Live chat';
			$online_button_text = 'online';
			$teal = ''; 
		}
		
		$alloperator = '';
		$online_button_text1 = ($online_button_text != '') ?  $online_button_text : 'online'; 
		
		$data = get_option('wbca_options');
    
		if(@$data['admin_able_to_chat']=='1'){
			$roles = array('operator', 'administrator');
		}else{
			$roles = array('operator');
		}

		$users = array();
		foreach($roles as $role){
			$current_user_role = get_users( array('role'=> $role));
			$users = array_merge($current_user_role, $users);
		}
		$blogtime = strtotime(current_time( 'mysql' ));
		foreach ( $users as $usr ) {
            $meta = strtotime(get_user_meta($usr->ID, 'wbca_login_time', true));
            $user_status = get_user_meta($usr->ID, 'wbca_login_status', true);
            $interval  = abs($blogtime - $meta);
			$minutes   = round($interval / 60);
            if($minutes <= 5 && $user_status=='online'){
				if($user_id != $usr->ID){
					$alloperator .= '<li data-operatorid="'.$usr->ID.'" data-operatorname="' . $usr->display_name . '">&nbsp;</li>';
					$alloperator .= '
					<div class="item" data-operatorid="'.$usr->ID.'" data-operatorname="' . $usr->display_name . '">
						<img class="ui avatar image" src="/images/avatar2/small/lena.png">
						<div class="content">
						&nbsp;
						</div>
				  	</div>
				  ';
				}

            }
    
        }
		$sound = '';
		$sound .= '<audio id="wbca_alert" autoplay="">';
		$sound .= '<source src="' . plugins_url() . '/live-chat-addon/images/alert.ogg" type="audio/ogg">';
		$sound .= '<source src="' . plugins_url() . '/live-chat-addon/images/alert.mp3" type="audio/mpeg">';
		$sound .= '</audio>';
		$html .=  $sound;
		$html .= '<div class="wbca-admin-wrap">';
			$html .= '<div class="wbca-admin-head">';
				$html .= '<div class="wbca-admin-head-left">';
					$html .= '<img class="wbca-operator-image" src="'.$src.'">';
					$html .= '<span class="wbca-operator-name">'.$name.'</span>';
				$html .= '</div>';
				$html .= '<div class="wbca-admin-head-right">';
					$html .= '<a class="button-online" data-user="'.$user_id.'" data-online='.$online_button_text.'> Go '. $online_button_text1 .'</a></br></br><p>'.$go_online_text.'</p>';
				$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="wbca-admin-body wbca-clear">';
				$html .= '<div id="wbca-tabs-wrap">';
					$html .= '<ul id="wbca-chat-tabs">';
						$html .= '<li data-event="dashboard-client-tabs" class="wbca-current wbca_dashboard">Dashboard</li>';
						$html .= '<li data-event="" class="qct_no_client_msg">No active client. All active clients will be listed here.</li>';
					$html .= '</ul>';
				$html .= '</div>';
				$html .= '<div id="wbca-content-wrap">';
					$html .= '<div class="wbca-chat-box wbca-visible">';
						$html .='<div id="wpca_active_client">0 active Client currently!</div>';
						$html .= '<div class="wbca-dashbord">';
							$html .= '<div class="wbca-chat-items">';
							$html .= '<div style="padding-right:5px;">';
							$html .= '</div>';
							$html .= '<div class="wbca-search-items">';
							$html .= '<div style="padding-left:5px;">';
							$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
		
		require_once WBCA_PATH .'/admin/templates/livechat-window.php';
    	echo $html;
    }
	
	public function wbca_add_qa_page(){
		$html = '';
		
		$getAvater = get_avatar(get_current_user_id());
		if(trim($getAvater)!=''){
			$doc = new DOMDocument();
			$doc->loadHTML($getAvater);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)");
		} else {
			$src = esc_url( get_avatar_url( get_current_user_id() ) );
		}
		
		
		$user = get_userdata( get_current_user_id() );
		$name = $user->display_name;
		
		$html .= '<div class="wbca-admin-wrap">';
			$html .= '<div class="wbca-admin-head">';
				$html .= '<div class="wbca-admin-head-left">';
					$html .= '<img class="wbca-operator-image" src="'.$src.'">';
					$html .= '<span class="wbca-operator-name">'.$name.'</span>';
				$html .= '</div>';
				$html .= '<div class="wbca-admin-head-right">';
					$html .= '<span class="wbca-info">'.$this->plugin_name.'</span>';
					$html .= '<span class="wbca-info">v-'.$this->plugin_version.'</span>';
				$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="wbca-admin-body wbca-clear">';
				$html .= '<div id="wbca-add-content-wrap">';
					$html .= '<form id="wbca_add_search_form" action="" method="post">
								<div class="wbca_search_msg"></div>
							  <div>
							  	<!--[if IE ]>
								   <span>Type question</span><br/>
								<![endif]-->
								<input type="text" id="wbca_search_question" name="wbca_search_question" value="" placeholder="'.__('Type question', WBCA).'">
							  </div>
							  <div>
							  	<!--[if IE ]>
								   <span>Type answer</span><br/>
								<![endif]-->
								<textarea id="wbca_search_answer" name="wbca_search_answer" value="" placeholder="'.__('Type answer', WBCA).'"></textarea>
							  </div>
							  <div>
								<button class="wbca_button" type="submit" data-event="wbca_add_search" id="wbca_add_search" name="wbca_add_search">'.__('Submit',WBCA).'</button>
							  </div>
							</form>';
				$html .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
    	echo $html;
       	   
    }
	
	public function wbca_chat_history(){
		global $wpdb;
		$wpdb->show_errors = true;	
		$prefix = $wpdb->prefix;
		$user = wp_get_current_user();
		$has_attachment_exist  = $wpdb->get_results("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$wpdb->dbname."' AND TABLE_NAME = '".$prefix."wbca_message' AND COLUMN_NAME = 'has_attachment'");
		if(count($has_attachment_exist) == 0 ){
			$wpdb->get_results("ALTER TABLE ".$prefix."wbca_message ADD has_attachment tinyint(1)");
		}
		if(isset($_GET['clientid']) && $_GET['clientid']!=''){
		$client = get_user_by( "ID", $_GET['clientid'] );
		$chatid = $wpdb->get_var('SELECT `id` FROM `'.$prefix.'wbca_message` WHERE 1 and (`user_sender` = '.$client->ID.' or `user_receiver` = '.$client->ID.') limit 1');
		?>	
		<div class="sld_menu_title" style="text-align:left;">
			<table class="form-table">
				<tbody>
				<tr><th style="padding: 5px;" scope="row">Chat ID</th><td style="padding: 5px;"><?php echo $chatid ?></td></tr>
				<tr><th style="padding: 5px;" scope="row">Client Name</th><td style="padding: 5px;"><?php echo $client->display_name ?></td></tr>
				<tr><th style="padding: 5px;" scope="row">Client Email</th><td style="padding: 5px;"><?php echo $client->user_email ?></td></tr>
				</tbody>
			</table>
		</div>
		
		<?php 
		
		$result = $wpdb->get_results('SELECT * FROM `'.$prefix.'wbca_message` WHERE 1 and (`user_sender` = '.$client->ID.' or `user_receiver` = '.$client->ID.') order by `chat_time` asc');
		
			if(!empty($result)):
		?>
			<div class="qchero_sliders_list_wrapper">
			<div class="qchero_slider_table_area" style="max-width: 650px;">
			<div class="sld_payment_table">
		<?php
			foreach($result as $row){
			$user_sender = get_user_by( "ID", $row->user_sender );
		?>
				<div class="sld_payment_row" style="padding:8px;display:block;<?php echo ($row->user_sender==$client->ID?'text-align:right':'') ?>">
					<div class="wbca_chat_msg">
						<?php echo stripslashes($row->message); ?>
					</div>
					<div class="wbca_chat_msg_bottom">
					From <b><?php echo $user_sender->display_name; ?></b> on <?php echo $row->chat_time ?>
					</div>
				</div>
			
		<?php
			}
		?>
			</div>
			</div>
			</div>
		<?php
			endif;
		}else{
		
		
		
		
		$where ='';
		if( isset( $_GET['wbca_chat_id'] ) && $_GET['wbca_chat_id'] !== '' ){
			$where .= ' and m.id = '.$_GET['wbca_chat_id'];
		}
		
		if( isset( $_GET['wbca_date_from'] ) && $_GET['wbca_date_from'] !== '' ){
			$where .= " and m.chat_time >= '".$_GET['wbca_date_from']."'";
		}

		if( isset( $_GET['wbca_date_to'] ) && $_GET['wbca_date_to'] !== '' ){
			$where .= " and m.chat_time <= '".$_GET['wbca_date_to']."'";
		}

		if(current_user_can('administrator')){
			$sql = 'SELECT m.`id`, max(`has_attachment`) AS `has_attachment`, m.`user_sender`, m.`user_receiver`, m.`message`, m.`chat_read`, m.`wbca_transferred`, m.`chat_time` FROM `'.$prefix.'wbca_message` as m, '.$prefix.'usermeta as um WHERE 1 and um.user_id = m.user_sender and um.`meta_value` like "%livechatuser%" '.$where.' group by m.`user_sender` order by m.`chat_time` desc';

		}else{
			$sql = 'SELECT m.`id`,max(`has_attachment`) AS `has_attachment`, m.`user_sender`, m.`user_receiver`, m.`message`, m.`chat_read`, m.`wbca_transferred`, m.`chat_time` FROM `'.$prefix.'wbca_message` as m, '.$prefix.'usermeta as um WHERE 1 and um.user_id = m.user_sender and um.`meta_value` like "%livechatuser%" and `user_receiver` = '.$user->ID.' '.$where.' group by m.`user_sender` order by m.`chat_time` desc';

		}
		
		$total = count($wpdb->get_results( $sql ));
		
		$items_per_page = 30;
		$page             = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$offset         = ( $page * $items_per_page ) - $items_per_page;
		$sql .=" LIMIT ${offset}, ${items_per_page}";
		
		$result = $wpdb->get_results($sql);
		?>
		<div class="qchero_sliders_list_wrapper">
			<div class="sld_menu_title">
				<h2 style="font-size: 26px;text-align:center"><?php echo __('All Clients', 'qc-opd') ?></h2>
			</div>
			<div class="sld_menu_title">
				<form method="GET" action=" <?php echo admin_url('admin.php?page=wbca-chat-history'); ?> " style="width: 100%;text-align: left;">
					<label for="wbca_chat_id">Chat ID</label>
					<input type="number" id="wbca_chat_id" name="wbca_chat_id" value="<?php echo (isset( $_GET['wbca_chat_id'] ) && $_GET['wbca_chat_id'] !== '' ? $_GET['wbca_chat_id'] : '' ); ?>" />
					<label for="wbca_date_from">From Date</label>
					<input type="text" id="wbca_date_from" name="wbca_date_from" value="<?php echo (isset( $_GET['wbca_date_from'] ) && $_GET['wbca_date_from'] !== ''? $_GET['wbca_date_from'] : '' ); ?>" />
					<label for="wbca_date_from">To Date</label>
					<input type="text" id="wbca_date_to" name="wbca_date_to" value="<?php echo (isset( $_GET['wbca_date_to'] ) && $_GET['wbca_date_to'] !== ''? $_GET['wbca_date_to'] : '' ); ?>" />
					<input type="hidden" name="page" value="wbca-chat-history" />
					<input type="submit" value="Filter" />
				</form>
			</div>
			<?php 
			
				$totalPage         = ceil($total / $items_per_page);
				
				$customPagHTML = '';
				if($totalPage > 0){
					$customPagHTML     =  '<div><span class="wpbot_pagination">Page '.esc_html($page).' of '.esc_html($totalPage).'</span>'.paginate_links( array(
					'base' => add_query_arg( 'cpage', '%#%' ),
					'format' => '',
					'prev_text'    => __('« prev'),
					'next_text'    => __('next »'),
					'total' => esc_html($totalPage),
					'current' => esc_html($page),
					
					)).'</div>';
					?>
					
					<div class="sld_menu_title" style="text-align: left;">
						<?php echo $customPagHTML; ?>
					</div>
					
					<?php
				}
			
			?>
			
			<?php if(!empty($result)): ?>
			<a class="wbca_history_delete button-primary">Delete </a>
			<div class="qchero_slider_table_area">
				<div class="sld_payment_table">
					<div class="sld_payment_row header">
						<div class="sld_payment_cell">
							<input type="checkbox" id="wpbot_checked_all" class="wpbot_sessions_checkbox">
						</div>
						<div class="sld_payment_cell">
							<?php _e( 'ID', 'qc-opd' ) ?>
						</div>

						<div class="sld_payment_cell">
							<?php _e( 'Date', 'qc-opd' ) ?>
						</div>
						<div class="sld_payment_cell">
							<?php _e( 'Client Name', 'qc-opd' ) ?>
						</div>
						<div class="sld_payment_cell">
							<?php _e( 'Operator Name', 'qc-opd' ); ?>
						</div>
						<div class="sld_payment_cell">
							<?php _e( 'Action', 'qc-opd' ); ?>
						</div>
						
					</div>
			<?php
			foreach($result as $row){
				$user_sender = get_user_by( "ID", $row->user_sender );
				$user_receiver = get_user_by( "ID", $row->user_receiver );
				$url = admin_url( 'admin.php?page=wbca-chat-history&clientid='.$row->user_sender );
			?>
				<div class="sld_payment_row">
					<div class="sld_payment_cell">
						<input type="checkbox" name="wpbot_history_checkbox[]" class="wpbot_sessions_checkbox" value="<?php echo $row->user_sender; ?>">
					</div>
					<div class="sld_payment_cell">
						<?php echo $row->id; ?>
					</div>
					<div class="sld_payment_cell">
						<?php echo date('m/d/Y', strtotime($row->chat_time)); ?>
					</div>
					<div class="sld_payment_cell">
						<div class="sld_responsive_head"><?php echo __('Client Name', 'qc-opd') ?></div>
						<?php 
						if ( ! empty( $user_sender ) ) {
							echo $user_sender->first_name . ' ' . $user_sender->last_name;
						}
						?>
					</div>
					<div class="sld_payment_cell">
						<div class="sld_responsive_head"><?php echo __('Operator Name', 'qc-opd') ?></div>
						<?php 
						if ( ! empty( $user_receiver ) ) {
							echo $user_receiver->first_name . ' ' . $user_receiver->last_name;
						}
						?>
					</div>
					<div class="sld_payment_cell">

						<a href="<?php echo $url; ?>" class="button-primary"><?php if($row->has_attachment ==1 ){
								echo '<span class="dashicons dashicons-paperclip" style="line-height:30px"></span>';
							}
							?>
						View Chat</a>
					</div>
					
				</div>
			<?php
			}
			?>

			</div>

		</div>
		<?php endif; ?>
		</div>
		<style>
			.sld_payment_row {
				display: flex !important;
				justify-content: space-between !important;
				align-items: center !important;
				flex-direction: row !important;
				text-align: left !important;
					padding: 12px 0 !important;
			}
			.sld_payment_cell {
				padding: 0 50px !important;
				color:#555 !important;
			}
			.sld_responsive_head {
				display: inline !important;
			}
			.sld_payment_row.header {
				background: #fff;
			}
			.sld_payment_row:nth-child(odd){
				
			}
			.sld_payment_row:nth-child(even){
				background:#dfdbdb;
			}
		</style>
		<script>
			jQuery(document).ready(function($) {
				$("#wbca_date_from").datepicker({ dateFormat: 'yy-mm-dd' });
				$("#wbca_date_to").datepicker({ dateFormat: 'yy-mm-dd' });
			});
		</script>
		<?php
		}
	}
	
	public function wbca_edit_qa_page(){
		global $wpdb;
		$wpdb->show_errors = true;			
		$html = '';
		$row = '';
		$getAvater = get_avatar(get_current_user_id());
		if(trim($getAvater)!=''){
			$doc = new DOMDocument();
			$doc->loadHTML($getAvater);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)");
		} else {
			$src = esc_url( get_avatar_url( get_current_user_id() ) );
		}
		
		
		$user = get_userdata( get_current_user_id() );
		$name = $user->display_name;
		
		$prefix = $wpdb->prefix;
		$result = $wpdb->get_results('SELECT * FROM '.$prefix.'wbca_search_document ORDER BY DOCUMENT_ID ASC LIMIT 10');
		
		if(!empty($result)){
			$row .= '<ul id="wbca_edit_chat_row">';
			foreach ($result as $docs){
				$row .= '<li id="docid_'.$docs->DOCUMENT_ID.'">';
					$row .= '<div class="wbca-clear" data-titleid="'.$docs->DOCUMENT_ID.'">';
					$row .= '<b class="wbca_edit_title" data-event="send-to-edit-form">'.$docs->DOCUMENT_TITLE.'</b>';
					$row .= '<button class="wbca-delete-chat-row" data-event="wbca-delete-chat-row"><span>&times;</span></button>';
					$row .= '<button class="expand-wbca-edit-desc" data-event="expand-wbca-edit-desc"><span>&or;</span></button>';
					$row .= '</div>';
					$row .= '<div class="wbca_edit_desc" id="descid_'.$docs->DOCUMENT_ID.'" data-desc-state="0">';
					$row .= $docs->DESCRIPTION;
					$row .= '</div>';
				$row .= '</li>';
			}
			$row .= '</ul>';
		}
		
		$html .= '<div class="wbca-admin-wrap">';
			$html .= '<div class="wbca-admin-head">';
				$html .= '<div class="wbca-admin-head-left">';
					$html .= '<img class="wbca-operator-image" src="'.$src.'">';
					$html .= '<span class="wbca-operator-name">'.$name.'</span>';
				$html .= '</div>';
				$html .= '<div class="wbca-admin-head-right">';
					$html .= '<span class="wbca-info">'.$this->plugin_name.'</span>';
					$html .= '<span class="wbca-info">v-'.$this->plugin_version.'</span>';
				$html .= '</div>';
			$html .= '</div>';
			$html .= '<div class="wbca-admin-body wbca-clear">';
				$html .= '<div class="wbca-chat-items">';
					$html .= '<form id="wbca_edit_form" action="" method="post">
								<div class="wbca_search_msg"></div>
							  <div>
							  	<!--[if IE ]>
								   <span>Type question</span><br/>
								<![endif]-->
								<input type="text" id="wbca_edit_search_question" required name="wbca_edit_search_question" value="" placeholder="'.__('Type question',WBCA).'">
							  </div>
							  <div>
							  	<!--[if IE ]>
								   <span>Type answer</span><br/>
								<![endif]-->
								<textarea id="wbca_edit_search_answer" value="" required name="wbca_edit_search_answer" placeholder="'.__('Type answer',WBCA).'"></textarea>
							  </div>
							  <div>
									<button class="wbca_button" type="submit" data-event="wbca_edit_form_button" id="wbca_edit_form_button" data-wbca-searchid="" name="wbca_edit_form_button">'.__('Edit',WBCA).'</button>
							  </div>
							</form>';
				$html .= '</div>';
				$html .= '<div class="wbca-search-items">';
					$html .= '<form id="wbca_edit_search_form" method="post" action="">';
					  $html .= '<input type="text" placeholder="Search..." name="wbca_edit_search_query" value=""/>';
					  $html .= '<button class="wbca_button" type="submit" data-event="wbca_edit_search_nav" id="wbca_edit_search_button" name="wbca_edit_search_nav">Search</button>';
					$html .= '</form>';
					$html .= '<div id="wbca_edit_row_container">';
					$html .= $row;
					$html .= '</div>';
					$html .= '<div id="wbca_edit_row_footer">';
					if(!empty($result) && count($result) >= 10){
						$html .= '<button class="wbca_button" data-event="wbca_edit_button_nav" id="wbca_edit_nav_back" data-pageid="0" data-direction="back" title="Back">&lsaquo;</button>';
						$html .= '<button class="wbca_button" data-event="wbca_edit_button_nav" id="wbca_edit_nav_next" data-pageid="2" data-direction="next" title="Next">&rsaquo;</button>';
					}
					$html .= '</div>';
				$html .= '</div>';
			$html .= '</div>';
		$html .= '</div>';
    	echo $html;
       	   
    }
	public function wbca_plugin_info(){	 
		$plugin_data = get_plugin_data( WBCA_PATH.'wpbot-chat-addon.php', false, false );
		$this->plugin_name = $plugin_data['Name'];
		$this->plugin_version = $plugin_data['Version'];
	}
}


?>