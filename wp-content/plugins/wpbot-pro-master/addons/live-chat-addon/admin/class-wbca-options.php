<?php

if ( ! class_exists( 'wbcaOptions' ) ) {
	class wbcaOptions {
			
		function __construct() {
			$this->create_wbca_Options();
		}
		
		public function create_wbca_Options() {
			require_once(WBCA_PATH . "admin/admin-page-class.php");
			/**
			* configure your admin page
			*/
			
			if(qcld_live_is_active_white_label() && get_option('wpwl_word_wpbot')!=''){
				$menutxt = get_option('wpwl_word_wpbot');
			}else{
				if(qclivechat_is_woowbot_active()){
					$menutxt = 'Bot';
				}else{
					$menutxt = 'Bot';
				}
				
			}
		
			$config = array(
				'menu'           => array('top'=>'wbca-chat-page'),             //sub page to settings page
				'page_title'     => __($menutxt.' - Livechat Options',WBCA),       //The name of this page 
				'capability'     => 'edit_posts',         // The capability needed to view the page 
				'option_group'   => 'wbca_options',       //the name of the option to create in the database
				'id'             => 'wbca_admin_page',   // meta box id, unique per page
				'fields'         => array(),    // list of fields (can be added by field arrays)
				'local_images'   => false,   // Use local or hosted images (meta box images for add/remove)
				'use_with_theme' => false //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			);  
			
			/**
			* instantiate your admin page
			*/
			$options_panel = new IL_Admin_Page_Class($config);
			$options_panel->OpenTabs_container('');
			
			/**
			* define your admin page tabs listing
			*/
			$options_panel->TabsListing(array(
			'links' => array(
			  'options_2' =>  __('General Options',WBCA),
			  'options_3' => __('Database Options',WBCA),
			  'options_4' => __('Emails & Alerts',WBCA),
			  'options_6' =>  __('Language Center',WBCA),
			  'options_7' =>  __('Settings Import & Export',WBCA),
			)
			));
			
			
			/**
			* Open admin page Second tab
			*/
			$options_panel->OpenTab('options_2');
			/**
			* Add fields to your admin page 2nd tab
			* 
			* Fancy options:
			*  typography field
			*  image uploader
			*  Pluploader
			*  date picker
			*  time picker
			*  color picker
			*/
			//title
			$options_panel->Title(__('General Options',WBCA));
			$options_panel->addText('wbca_chat_refresh_rate',
			array(
			  'name'     => __('Chat message refresh rate ',WBCA),
			  'std'      => 6000,
			  'desc'     => __("Value is in millisecond (1000 ms = 1 sec). Default: 6000 ",WBCA),
			  'validate' => array(
				  'numeric' => array('param' => '','message' => __("must be numeric value",WBCA))
			  )
			)
			);
					
			$options_panel->addCheckbox('disable_sound_notification',array('name'=> __('Disable Sound Notification on backend',WBCA), 'std' => true, 'desc' => __('Disable Sound Notification on backend',WBCA)));
			
			$options_panel->addCheckbox('admin_able_to_chat',array('name'=> __('Allow Admin to Do Chat as Operator',WBCA), 'std' => false, 'desc' => __('Enable this to allow admin to do chat as operator',WBCA)));
			$options_panel->addCheckbox('admin_enble_fileupload',array('name'=> __('Enable the file upload',WBCA), 'std' => false, 'desc' => __('Enable the file upload',WBCA)));
			
			$options_panel->addText('allowed_file_format',
				array(
				'name'     => __('Allowed file format',WBCA),
				'std'      => 'image/jpeg,image/jpg,application/pdf,application/zip',
				'desc'     => __("Add file type with comma separeted value",WBCA),
			));
			
			$options_panel->addCheckbox('always_allow_livechat',array('name'=> __('Always Allow Live Chat',WBCA), 'std' => false, 'desc' => 'When this is enabled, users will be able to start live chat session any time and email alerts will be sent to the admins for new Live Chat requests'));
			$options_panel->Title (__('These options will work if the chatbot is installed',WBCA));
		
			$options_panel->addCheckbox('disable_livechat_operator_offline',array('name'=> __('Disable Livechat Options from the ChatBot when Operator is Offline',WBCA), 'std' => false, 'desc' => 'This options apply only if you have the WPBot Pro installed'));
		
			$options_panel->addCheckbox('show_livechat_window_first',array('name'=> __('Open Live Chat Window First If Operator is Online',WBCA), 'std' => false, 'desc' => 'Please turn on the option if you want to open the livechat window first when user click on the WPBot icon.<br> This feature will only work when operator is online.'));
			$options_panel->addCheckbox('disable_livechat',array('name'=> __('Disable Livechat Button on '.$menutxt.' Start Menu',WBCA), 'std' => false, 'desc' => 'This options apply only if you have the WPBot Pro installed'));
			$options_panel->addCheckbox('disable_livechat_opration_icon',array('name'=> __('Disable Livechat Operation Icon',WBCA), 'std' => false, 'desc' => 'This options apply only if you have the WPBot Pro installed'));
			$options_panel->addText('qlcd_wp_livechat', array('name'=> __('Livechat Predefined Intent Button Title','apc'), 'std'=> 'Livechat', 'desc' => __('Default Value: Livechat <br> This options apply only if you have the WPBot Pro installed','apc')));
			$options_panel->addText('qlcd_wp_chatbot_sys_key_livechat', array('name'=> __('Livechat System Command','apc'), 'std'=> 'livechat', 'desc' => __('Default Value: livechat<br> This options apply only if you have the WPBot Pro installed','apc')));
			/**
			* Close second tab
			*/ 
			$options_panel->CloseTab();
			$options_panel->OpenTab('options_3');
			$options_panel->Title(__("Database Options",WBCA));
			$options_panel->addCheckbox('enable_chat_cleanup',array('name'=> __('Delete database chat history? ',WBCA), 'std' => false, 'desc' => __('Enable this to delete chat history from database',WBCA)));
			$options_panel->addRadio(
				'chat_cleanup_interval',
				array(
					'hourly'=>'Once hourly',
					'twicedaily'=>'Twice daily',
					'daily'=>'Once daily',
					'weekly'=>'Once weekly',
					'monthly'=>'Once Monthly',
					'yearly'=>'Once Yearly',
				),
				array(
					'name'=> __('Database cleanup interval',WBCA),
					'std'=> array('monthly'), 
					'desc' => __('Select Chat cleanup interval from database',WBCA)
				)
			);
			$options_panel->CloseTab();
			$options_panel->OpenTab('options_4');
			$options_panel->Title(__("Email Options",WBCA));
			$options_panel->addCheckbox('enable_wbca_email',array('name'=> __('Enable Custom Email Instead of Admin Email','apc'), 'std' => false, 'desc' => __('By default emails will be sent to the WordPress Administration email. Enable if you want to use the below email addresses','apc')));
			$options_panel->addCheckbox('disable_notice_wbca_email',array('name'=> __('Disable New Live Chat Notice','apc'), 'std' => false, 'desc' => __('Disable New Live Chat Notice.','apc')));
			$options_panel->addText('wbca_email_address', array('name'=> __('Query Email Address','apc'), 'std'=> '', 'desc' => __('Emails will be Sent to this Address from Live Chat Queries when operator is offline','apc')));
			$options_panel->addText('wbca_email_alerts', array('name'=> __('Email Alerts','apc'), 'std'=> '', 'desc' => __('Add comma separated email addresses where ALL new chat session requests will be sent.','apc')));
			$options_panel->addText('wbca_email_notification_subject', array('name'=> __('New Chat Session Notification Email Subject','apc'), 'std'=> '#clientname started a new chat session', 'desc' => __('Variables<br>Client Name: #clientname<br> The new chat session notification email will be sent to the operator & site admin.','apc')));
			$options_panel->addWysiwyg('wbca_email_notification_content', array('name'=> __('New Chat Session Notification Email Body','apc'), 'std'=> 'Hi,
#clientname started a new chat session with you. Please go to <a href="#livechat_dashboard_url">Livechat Dashboard</a> and find him/her.
Thanks.', 'desc' => __('Variables<br>Client Name: #clientname<br>Livechat Dashboard Url: #livechat_dashboard_url<br> The new chat session notification email will be sent to the operator & site admin.','apc')));
			/**
			* Close 4th tab
			*/
			
			$options_panel->CloseTab();

			/**
			* Open admin page 6th tab
			* field Translation
			*/
			$options_panel->OpenTab('options_6');
			$options_panel->addText('wbca_lg_ochat', array('name'=> __('Chat','apc'), 'std'=> 'Chat', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_online', array('name'=> __('Live Chat - Online','apc'), 'std'=> 'Live Chat - Online', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_offline', array('name'=> __('Live Chat - Offline','apc'), 'std'=> 'Live Chat - Offline', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_we_are_here', array('name'=> __('We are here to help you. Please fill up the form and start chatting.','apc'), 'std'=> 'We are here to help you. Please fill up the form and start chatting.', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_chat', array('name'=> __('Start Chat','apc'), 'std'=> 'Start Chat', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_sendq', array('name'=> __('Operators offline. Please send your query','apc'), 'std'=> 'Operators offline. Please send your query', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_subject', array('name'=> __('Subject','apc'), 'std'=> 'Subject', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_msg', array('name'=> __('Type Message','apc'), 'std'=> 'Type Message', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_send', array('name'=> __('Send','apc'), 'std'=> 'Send', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_fname', array('name'=> __('Full name','apc'), 'std'=> 'Full name', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_email', array('name'=> __('Email','apc'), 'std'=> 'Email', 'desc' => __('','apc')));
			$options_panel->addText('wbca_msg_success', array('name'=> __('Success! We will get back to you soon.','apc'), 'std'=> 'Success! We will get back to you soon.', 'desc' => __('','apc')));
			$options_panel->addText('wbca_msg_failed', array('name'=> __('Sending failed! Please try again later.','apc'), 'std'=> 'Sending failed! Please try again later.', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_chat_type', array('name'=> __('Type your question below and hit enter.','apc'), 'std'=> 'Type your question below and hit enter.', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_chat_welcome', array('name'=> __('You are now chatting with','apc'), 'std'=> 'You are now chatting with', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_please_wait', array('name'=> __('Please wait. Someone will be with your shortly','apc'), 'std'=> 'Please wait. Someone will be with your shortly', 'desc' => __('','apc')));
			//$options_panel->addText('wbca_lg_sendq', array('name'=> __('Operators offline. Please send your query','apc'), 'std'=> 'Operators offline. Please send your query', 'desc' => __('','apc')));
			$options_panel->addText('wbca_lg_operator_offline', array('name'=> __('All operator is Offline','apc'), 'std'=> 'All operator is Offline', 'desc' => __('','apc')));
			$options_panel->addText('wbca_operator_gone_offline', array('name'=> __('The operator has gone offline','apc'), 'std'=> 'The operator has gone offline', 'desc' => __('','apc')));
			$options_panel->addText('wbca_operator_gone_online', array('name'=> __('The operator has gone online','apc'), 'std'=> 'The operator has gone online', 'desc' => __('','apc')));
			
			$options_panel->CloseTab();
			
			$options_panel->OpenTab('options_7');
			
			$options_panel->Title(__("Settings Import & Export",WBCA));
			
			$options_panel->addImportExport();
			
			$options_panel->CloseTab();
			$options_panel->CloseTab();
			

		}
	
	}
	new wbcaOptions();
}

function qcld_live_is_active_white_label(){
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	if ( is_plugin_active( 'white-label-chatbot-addon/white-label-wpbot.php' ) ){
		return true;
	}else{
		return false;
	}
	
}

?>