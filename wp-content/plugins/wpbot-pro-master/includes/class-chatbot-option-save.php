<?php

class Qcld_Chatbot_Option_Save
{
    public function __construct() {
        add_action('admin_init', array($this, 'save_options'));
        add_action('admin_init', array($this, 'retarget_options_save'));
        add_action('admin_init', array($this, 'stopwords_options_save'));
        add_action('admin_init', array($this, 'language_options_save'));
        add_action('wp_ajax_qcld_wb_chatboot_delete_all_options', array( $this, 'qcld_wb_chatboot_delete_all_options' ) );
    }

    /**
     * Save option value for WPBot
     *
     * @return void
     */
    public function save_options() {
        if ((empty($_GET["page"])) || ($_GET["page"] !== "wpbot")) {
            return;
        }

        if (isset($_POST['_wpnonce']) && $_POST['_wpnonce']) {
            wp_verify_nonce($_POST['_wpnonce'], 'wp_chatbot');
            // Check if the form is submitted or not
            if (isset($_POST['submit'])) {
                //wpwboticon position settings.
                if (isset($_POST["wp_chatbot_position_x"])) {
                    $wp_chatbot_position_x = stripslashes(qcld_sanitize_field($_POST["wp_chatbot_position_x"]));
                    update_option('wp_chatbot_position_x', $wp_chatbot_position_x);
                }
                if (isset($_POST["wp_chatbot_position_y"])) {
                    $wp_chatbot_position_y = stripslashes(qcld_sanitize_field($_POST["wp_chatbot_position_y"]));
                    update_option('wp_chatbot_position_y', $wp_chatbot_position_y);
                }

                if (isset($_POST["wp_chatbot_position_in"])) {
                    $wp_chatbot_position_in = stripslashes(qcld_sanitize_field($_POST["wp_chatbot_position_in"]));
                    update_option('wp_chatbot_position_in', $wp_chatbot_position_in);
                }
                //wpwboticon position settings on phone.
                if (isset($_POST["wp_chatbot_position_x"])) {
                    $wp_chatbot_position_mp_x = stripslashes(qcld_sanitize_field($_POST["wp_chatbot_position_mp_x"]));
                    update_option('wp_chatbot_position_mp_x', $wp_chatbot_position_mp_x);
                }
                if (isset($_POST["wp_chatbot_position_mp_y"])) {
                    $wp_chatbot_position_mp_y = stripslashes(qcld_sanitize_field($_POST["wp_chatbot_position_mp_y"]));
                    update_option('wp_chatbot_position_mp_y', $wp_chatbot_position_mp_y);
                }

                if (isset($_POST["wp_chatbot_position_mp_in"])) {
                    $wp_chatbot_position_mp_in = stripslashes(qcld_sanitize_field($_POST["wp_chatbot_position_mp_in"]));
                    update_option('wp_chatbot_position_mp_in', $wp_chatbot_position_mp_in);
                }

                
                //product search options
                if(isset($_POST['qlcd_wp_chatbot_search_option'])){
                    $qlcd_wp_chatbot_search_option = $_POST['qlcd_wp_chatbot_search_option'];
                    update_option('qlcd_wp_chatbot_search_option', qcld_sanitize_field($qlcd_wp_chatbot_search_option));
                }


                if(isset( $_POST["enable_wp_chatbot_custom_color"])) {
                    $enable_wp_chatbot_custom_color = $_POST["enable_wp_chatbot_custom_color"];
                }else{ $enable_wp_chatbot_custom_color='';}
                update_option('enable_wp_chatbot_custom_color', qcld_sanitize_field($enable_wp_chatbot_custom_color));

                if( isset( $_POST["enable_chat_bar_position_right"] ) ){
					$enable_chat_bar_position_right = qcld_sanitize_field(@$_POST["enable_chat_bar_position_right"]);
					update_option('enable_chat_bar_position_right', ($enable_chat_bar_position_right));
				}else{
                    update_option('enable_chat_bar_position_right', 0);
                }
                
                if( isset( $_POST["enable_floating_icon"] ) ){
					$enable_floating_icon = qcld_sanitize_field(@$_POST["enable_floating_icon"]);
					update_option('enable_floating_icon', ($enable_floating_icon));
				}else{
                    update_option('enable_floating_icon', 0);
                }

                if( isset( $_POST["enable_chat_bar_position_bottom"] ) ){
					$enable_chat_bar_position_bottom = qcld_sanitize_field(@$_POST["enable_chat_bar_position_bottom"]);
					update_option('enable_chat_bar_position_bottom', ($enable_chat_bar_position_bottom));
				}else{
                    update_option('enable_chat_bar_position_bottom', 0);
                }
                
                if( isset( $_POST["disable_chat_bar_right_notification"] ) ){
					$disable_chat_bar_right_notification = qcld_sanitize_field(@$_POST["disable_chat_bar_right_notification"]);
					update_option('disable_chat_bar_right_notification', ($disable_chat_bar_right_notification));
				}else{
                    update_option('disable_chat_bar_right_notification', 0);
                }
                
                if( isset( $_POST["disable_chat_bar_bottom_notification"] ) ){
					$disable_chat_bar_bottom_notification = qcld_sanitize_field(@$_POST["disable_chat_bar_bottom_notification"]);
					update_option('disable_chat_bar_bottom_notification', ($disable_chat_bar_bottom_notification));
				}else{
                    update_option('disable_chat_bar_bottom_notification', 0);
                }

               $wp_chatbot_text_color = @$_POST["wp_chatbot_text_color"];
                update_option('wp_chatbot_text_color', qcld_sanitize_field($wp_chatbot_text_color));
                
                $wp_chatbot_floatingiconbg_color = @$_POST["wp_chatbot_floatingiconbg_color"];
                update_option('wp_chatbot_floatingiconbg_color', qcld_sanitize_field($wp_chatbot_floatingiconbg_color));

                $wp_chatbot_link_color = @$_POST["wp_chatbot_link_color"];
                update_option('wp_chatbot_link_color', qcld_sanitize_field($wp_chatbot_link_color));

                $wp_chatbot_link_hover_color = @$_POST["wp_chatbot_link_hover_color"];
                update_option('wp_chatbot_link_hover_color', qcld_sanitize_field($wp_chatbot_link_hover_color));

                $wp_chatbot_bot_msg_bg_color = @$_POST["wp_chatbot_bot_msg_bg_color"];
                update_option('wp_chatbot_bot_msg_bg_color', qcld_sanitize_field($wp_chatbot_bot_msg_bg_color));

                $wp_chatbot_bot_msg_text_color = @$_POST["wp_chatbot_bot_msg_text_color"];
                update_option('wp_chatbot_bot_msg_text_color', qcld_sanitize_field($wp_chatbot_bot_msg_text_color));

                $wp_chatbot_user_msg_bg_color = @$_POST["wp_chatbot_user_msg_bg_color"];
                update_option('wp_chatbot_user_msg_bg_color', qcld_sanitize_field($wp_chatbot_user_msg_bg_color));

                $wp_chatbot_user_msg_text_color = @$_POST["wp_chatbot_user_msg_text_color"];
                update_option('wp_chatbot_user_msg_text_color', qcld_sanitize_field($wp_chatbot_user_msg_text_color));


				$wp_chatbot_buttons_bg_color = @$_POST["wp_chatbot_buttons_bg_color"];
                update_option('wp_chatbot_buttons_bg_color', qcld_sanitize_field($wp_chatbot_buttons_bg_color));

                $wp_chatbot_buttons_text_color = @$_POST["wp_chatbot_buttons_text_color"];
                update_option('wp_chatbot_buttons_text_color', qcld_sanitize_field($wp_chatbot_buttons_text_color));

                $wp_chatbot_buttons_bg_color_hover = @$_POST["wp_chatbot_buttons_bg_color_hover"];
                update_option('wp_chatbot_buttons_bg_color_hover', qcld_sanitize_field($wp_chatbot_buttons_bg_color_hover));

                $wp_chatbot_buttons_text_color_hover = @$_POST["wp_chatbot_buttons_text_color_hover"];
                update_option('wp_chatbot_buttons_text_color_hover', qcld_sanitize_field($wp_chatbot_buttons_text_color_hover));


                $wp_chatbot_theme_secondary_color = @$_POST["wp_chatbot_theme_secondary_color"];
                update_option('wp_chatbot_theme_secondary_color', qcld_sanitize_field($wp_chatbot_theme_secondary_color));

                $wp_chatbot_theme_primary_color = @$_POST["wp_chatbot_theme_primary_color"];
                update_option('wp_chatbot_theme_primary_color', qcld_sanitize_field($wp_chatbot_theme_primary_color));

                $wp_chatbot_header_background_color = @$_POST["wp_chatbot_header_background_color"];
                update_option('wp_chatbot_header_background_color', qcld_sanitize_field($wp_chatbot_header_background_color));

                $wp_chatbot_font_size = @$_POST["wp_chatbot_font_size"];
                update_option('wp_chatbot_font_size', qcld_sanitize_field($wp_chatbot_font_size));
                $wp_chat_bot_font_family = @$_POST["wp_chat_bot_font_family"];
                update_option('wp_chat_bot_font_family', $wp_chat_bot_font_family);
                $wp_chat_user_font_family = @$_POST["wp_chat_user_font_family"];
                update_option('wp_chat_user_font_family', $wp_chat_user_font_family);
                $wp_chatbot_user_font = @$_POST['wp_chatbot_user_font'];
                update_option('wp_chatbot_user_font', $wp_chatbot_user_font);
                $wp_chatbot_bot_font = @$_POST['wp_chatbot_bot_font'];
                update_option('wp_chatbot_bot_font', $wp_chatbot_bot_font);
                //Enable /disable wpwbot
				
               if(isset( $_POST["disable_wp_chatbot"])){
                   $disable_wp_chatbot = qcld_sanitize_field($_POST["disable_wp_chatbot"]);
               }else{ $disable_wp_chatbot='';}
                update_option('disable_wp_chatbot', stripslashes($disable_wp_chatbot));

                if(isset( $_POST["disable_wp_chatbot_floating_icon"])){
                    $disable_wp_chatbot_floating_icon = qcld_sanitize_field($_POST["disable_wp_chatbot_floating_icon"]);
                }else{ $disable_wp_chatbot_floating_icon='';}
                 update_option('disable_wp_chatbot_floating_icon', stripslashes($disable_wp_chatbot_floating_icon));
                 if(isset( $_POST["delay_wp_chatbot_floating_icon"])){
                    $disable_wp_chatbot_floating_icon = qcld_sanitize_field($_POST["delay_wp_chatbot_floating_icon"]);
                }else{ $disable_wp_chatbot_floating_icon='';}
                 update_option('delay_wp_chatbot_floating_icon', stripslashes($disable_wp_chatbot_floating_icon));
                 
                if(isset( $_POST["delay_wp_chatbot_window_open"])){
                    $delay_wp_chatbot_window_open = qcld_sanitize_field($_POST["delay_wp_chatbot_window_open"]);
                }else{ $delay_wp_chatbot_window_open='';}
                 update_option('delay_wp_chatbot_window_open', stripslashes($delay_wp_chatbot_window_open));
                
                 
                if(isset( $_POST["delay_floating_notification_box"])){
                    $delay_floating_notification_box = qcld_sanitize_field($_POST["delay_floating_notification_box"]);
                }else{ $delay_floating_notification_box='';}
                 update_option('delay_floating_notification_box', stripslashes($delay_floating_notification_box));

				if(isset( $_POST["skip_wp_greetings"])){
                   $skip_wp_greetings = qcld_sanitize_field($_POST["skip_wp_greetings"]);
               }else{ $skip_wp_greetings='';}
                update_option('skip_wp_greetings', stripslashes($skip_wp_greetings));

                if(isset( $_POST["skip_wp_greetings_trigger_intent"])){
                    $skip_wp_greetings_trigger_intent = qcld_sanitize_field($_POST["skip_wp_greetings_trigger_intent"]);
                }else{ $skip_wp_greetings_trigger_intent='';}
                 update_option('skip_wp_greetings_trigger_intent', stripslashes($skip_wp_greetings_trigger_intent));

                if(isset( $_POST["qcld_disable_start_menu"])){
                   $qcld_disable_start_menu = qcld_sanitize_field($_POST["qcld_disable_start_menu"]);
               }else{ $qcld_disable_start_menu='';}
                update_option('qcld_disable_start_menu', stripslashes($qcld_disable_start_menu));
                if(isset( $_POST["qcld_replace_start_menu"])){
                    $qcld_replace_start_menu = qcld_sanitize_field($_POST["qcld_replace_start_menu"]);
                }else{ $qcld_replace_start_menu='';}
                 update_option('qcld_replace_start_menu', stripslashes($qcld_replace_start_menu));
                 
                 if(isset( $_POST["qcld_disable_repited_startmenu"])){
                    $qcld_disable_repited_startmenu = qcld_sanitize_field($_POST["qcld_disable_repited_startmenu"]);
                }else{ $qcld_disable_repited_startmenu='';}
                 update_option('qcld_disable_repited_startmenu', stripslashes($qcld_disable_repited_startmenu));
                 
                if(isset( $_POST["show_menu_after_greetings"])){
                    $show_menu_after_greetings = qcld_sanitize_field($_POST["show_menu_after_greetings"]);
                }else{ $show_menu_after_greetings='';}
                 update_option('show_menu_after_greetings', stripslashes($show_menu_after_greetings));

                 if(isset( $_POST["show_intent_navigation_notification"])){
                    $show_intent_navigation_notification = qcld_sanitize_field($_POST["show_intent_navigation_notification"]);
                }else{ $show_intent_navigation_notification='';}
                 update_option('show_intent_navigation_notification', stripslashes($show_intent_navigation_notification));

                if(isset( $_POST["disable_first_msg"])){
                    $disable_first_msg = qcld_sanitize_field($_POST["disable_first_msg"]);
                }else{ $disable_first_msg='';}
                 update_option('disable_first_msg', stripslashes($disable_first_msg));
                 
                 if(isset( $_POST["enable_reset_close_button"])){
                    $enable_reset_close_button = qcld_sanitize_field($_POST["enable_reset_close_button"]);
                }else{ $enable_reset_close_button='';}
                 update_option('enable_reset_close_button', stripslashes($enable_reset_close_button));

                 if(isset( $_POST["qc_auto_hide_floating_button"])){
                    $qc_auto_hide_floating_button = qcld_sanitize_field($_POST["qc_auto_hide_floating_button"]);
                }else{ $qc_auto_hide_floating_button='';}
                 update_option('qc_auto_hide_floating_button', stripslashes($qc_auto_hide_floating_button));

                 if(isset( $_POST["qlcd_wp_chatbot_reset_lan"])){
                    $qlcd_wp_chatbot_reset_lan = qcld_sanitize_field($_POST["qlcd_wp_chatbot_reset_lan"]);
                }else{ $qlcd_wp_chatbot_reset_lan='';}
                 update_option('qlcd_wp_chatbot_reset_lan', stripslashes($qlcd_wp_chatbot_reset_lan));

                 if(isset( $_POST["qlcd_wp_chatbot_close_lan"])){
                    $qlcd_wp_chatbot_close_lan = qcld_sanitize_field($_POST["qlcd_wp_chatbot_close_lan"]);
                }else{ $qlcd_wp_chatbot_close_lan='';}
                 update_option('qlcd_wp_chatbot_close_lan', stripslashes($qlcd_wp_chatbot_close_lan));
                
                 
                 
				if(isset( $_POST["ask_email_wp_greetings"])){
                   $ask_email_wp_greetings = qcld_sanitize_field($_POST["ask_email_wp_greetings"]);
               }else{ $ask_email_wp_greetings='';}
                update_option('ask_email_wp_greetings', stripslashes($ask_email_wp_greetings));
				
				if(isset( $_POST["ask_name_confirmation"])){
                   $ask_name_confirmation = qcld_sanitize_field($_POST["ask_name_confirmation"]);
               }else{ $ask_name_confirmation='';}
                update_option('ask_name_confirmation', stripslashes($ask_name_confirmation));

                if(isset( $_POST["ask_phone_wp_greetings"])){
                    $ask_phone_wp_greetings = qcld_sanitize_field($_POST["ask_phone_wp_greetings"]);
                }else{ $ask_phone_wp_greetings='';}
                 update_option('ask_phone_wp_greetings', stripslashes($ask_phone_wp_greetings));
                 
                 if(isset( $_POST["disable_phone_validity"])){
                    $disable_phone_validity = qcld_sanitize_field($_POST["disable_phone_validity"]);
                }else{ $disable_phone_validity='';}
                 update_option('disable_phone_validity', stripslashes($disable_phone_validity));

                if(isset( $_POST["qc_email_subscription_offer"])){
                    $qc_email_subscription_offer = qcld_sanitize_field($_POST["qc_email_subscription_offer"]);
                }else{ $qc_email_subscription_offer='';}
                 update_option('qc_email_subscription_offer', stripslashes($qc_email_subscription_offer));

                 if(isset( $_POST["qc_site_search_priority"])){
                    $qc_site_search_priority = qcld_sanitize_field($_POST["qc_site_search_priority"]);
                }else{ $qc_site_search_priority='';}
                 update_option('qc_site_search_priority', stripslashes($qc_site_search_priority));


                if(isset( $_POST["wpbot_support_mail_to_crm_contact"])){
                   $wpbot_support_mail_to_crm_contact = qcld_sanitize_field($_POST["wpbot_support_mail_to_crm_contact"]);
               }else{ $wpbot_support_mail_to_crm_contact='';}
                update_option('wpbot_support_mail_to_crm_contact', stripslashes($wpbot_support_mail_to_crm_contact));

                if(isset( $_POST["enable_wp_chatbot_open_initial"])){
                    $enable_wp_chatbot_open_initial = qcld_sanitize_field($_POST["enable_wp_chatbot_open_initial"]);
                }else{ $enable_wp_chatbot_open_initial='';}
                 update_option('enable_wp_chatbot_open_initial', stripslashes($enable_wp_chatbot_open_initial));

                 if(isset( $_POST["wp_keep_chat_window_open"])){
                    $wp_keep_chat_window_open = qcld_sanitize_field($_POST["wp_keep_chat_window_open"]);
                }else{ $wp_keep_chat_window_open='';}
                 update_option('wp_keep_chat_window_open', stripslashes($wp_keep_chat_window_open));
                 
				
                if(isset( $_POST["disable_wp_chatbot_on_mobile"])) {
                    $disable_wp_chatbot_on_mobile = qcld_sanitize_field($_POST["disable_wp_chatbot_on_mobile"]);
                }else{ $disable_wp_chatbot_on_mobile='';}
                update_option('disable_wp_chatbot_on_mobile', stripslashes($disable_wp_chatbot_on_mobile));

                if(isset( $_POST["disable_auto_focus_message_area"])) {
                    $disable_auto_focus_message_area = qcld_sanitize_field($_POST["disable_auto_focus_message_area"]);
                }else{ $disable_auto_focus_message_area='';}
                update_option('disable_auto_focus_message_area', stripslashes($disable_auto_focus_message_area));

				
				if(isset( $_POST["disable_livechat_operator_offline"])) {
                    $disable_livechat_operator_offline = qcld_sanitize_field($_POST["disable_livechat_operator_offline"]);
                }else{ $disable_livechat_operator_offline='';}
                update_option('disable_livechat_operator_offline', stripslashes($disable_livechat_operator_offline));
                
				
                if(isset( $_POST["disable_wp_chatbot_notification"])) {
                    $disable_wp_chatbot_notification = qcld_sanitize_field($_POST["disable_wp_chatbot_notification"]);
                }else{ $disable_wp_chatbot_notification='0';}
                update_option('disable_wp_chatbot_notification', stripslashes($disable_wp_chatbot_notification));
				
				if(isset( $_POST["disable_wp_chatbot_notification_mobile"])) {
                    $disable_wp_chatbot_notification_mobile = qcld_sanitize_field($_POST["disable_wp_chatbot_notification_mobile"]);
                }else{ $disable_wp_chatbot_notification_mobile='0';}
                update_option('disable_wp_chatbot_notification_mobile', stripslashes($disable_wp_chatbot_notification_mobile));

                if(isset( $_POST["wp_chatbot_exclude_post_list"])) {
                    $wp_chatbot_exclude_post_list = $_POST["wp_chatbot_exclude_post_list"];
                }else{ $wp_chatbot_exclude_post_list='';}
                update_option('wp_chatbot_exclude_post_list', serialize($wp_chatbot_exclude_post_list));

                if(isset( $_POST["wp_chatbot_exclude_pages_list"])) {
                    $wp_chatbot_exclude_pages_list = $_POST["wp_chatbot_exclude_pages_list"];
                }else{ $wp_chatbot_exclude_pages_list='';}
                update_option('wp_chatbot_exclude_pages_list', serialize($wp_chatbot_exclude_pages_list));

                if(isset( $_POST["wpbot_click_chat_text"])) {
                    $wpbot_click_chat_text = qcld_sanitize_field($_POST["wpbot_click_chat_text"]);
                }else{ $wpbot_click_chat_text='0';}
                update_option('wpbot_click_chat_text', stripslashes($wpbot_click_chat_text));

                if(isset( $_POST["qc_wpbot_menu_order"])) {
                    $qc_wpbot_menu_order = ($_POST["qc_wpbot_menu_order"]);
                }else{ $qc_wpbot_menu_order='';}
                update_option('qc_wpbot_menu_order', ($qc_wpbot_menu_order));
                

                if(isset( $_POST["enable_wp_chatbot_rtl"])) {
                    $enable_wp_chatbot_rtl = qcld_sanitize_field($_POST["enable_wp_chatbot_rtl"]);
                }else{ $enable_wp_chatbot_rtl='';}
                update_option('enable_wp_chatbot_rtl', stripslashes($enable_wp_chatbot_rtl));

                if(isset( $_POST["enable_wp_chatbot_disable_allicon"])) {
                    $enable_wp_chatbot_disable_allicon = qcld_sanitize_field($_POST["enable_wp_chatbot_disable_allicon"]);
                }else{ $enable_wp_chatbot_disable_allicon='';}
                update_option('enable_wp_chatbot_disable_allicon', stripslashes($enable_wp_chatbot_disable_allicon));

                if(isset( $_POST["enable_wp_chatbot_disable_helpicon"])) {
                    $enable_wp_chatbot_disable_helpicon = qcld_sanitize_field($_POST["enable_wp_chatbot_disable_helpicon"]);
                }else{ $enable_wp_chatbot_disable_helpicon='';}
                update_option('enable_wp_chatbot_disable_helpicon', stripslashes($enable_wp_chatbot_disable_helpicon));

                if(isset( $_POST["enable_wp_chatbot_disable_supporticon"])) {
                    $enable_wp_chatbot_disable_supporticon = qcld_sanitize_field($_POST["enable_wp_chatbot_disable_supporticon"]);
                }else{ $enable_wp_chatbot_disable_supporticon='';}
                update_option('enable_wp_chatbot_disable_supporticon', stripslashes($enable_wp_chatbot_disable_supporticon));

                if(isset( $_POST["enable_wp_chatbot_disable_chaticon"])) {
                    $enable_wp_chatbot_disable_chaticon = qcld_sanitize_field($_POST["enable_wp_chatbot_disable_chaticon"]);
                }else{ $enable_wp_chatbot_disable_chaticon='';}
                update_option('enable_wp_chatbot_disable_chaticon', stripslashes($enable_wp_chatbot_disable_chaticon));

               if(isset( $_POST["enable_wp_chatbot_mobile_full_screen"])) {
                    $enable_wp_chatbot_mobile_full_screen = qcld_sanitize_field($_POST["enable_wp_chatbot_mobile_full_screen"]);
                }else{ $enable_wp_chatbot_mobile_full_screen='';}
                update_option('enable_wp_chatbot_mobile_full_screen', stripslashes($enable_wp_chatbot_mobile_full_screen));

                if(isset( $_POST["chatbot_content_max_height"])) {
                    $chatbot_content_max_height = sanitize_text_field($_POST["chatbot_content_max_height"]);
                }else{ $chatbot_content_max_height='564';}
                update_option('chatbot_content_max_height', wp_unslash($chatbot_content_max_height));
                
                if(isset( $_POST["enable_wp_chatbot_gdpr_compliance"])) {
                    $enable_wp_chatbot_gdpr_compliance = qcld_sanitize_field($_POST["enable_wp_chatbot_gdpr_compliance"]);
                }else{ $enable_wp_chatbot_gdpr_compliance='';}
                update_option('enable_wp_chatbot_gdpr_compliance', stripslashes($enable_wp_chatbot_gdpr_compliance));

                if(isset( $_POST["wpbot_search_result_new_window"])) {
                    $wpbot_search_result_new_window = qcld_sanitize_field($_POST["wpbot_search_result_new_window"]);
                }else{ $wpbot_search_result_new_window='';}
                update_option('wpbot_search_result_new_window', stripslashes($wpbot_search_result_new_window));

                if(isset( $_POST["wpbot_card_response_same_window"])) {
                    $wpbot_card_response_same_window = qcld_sanitize_field($_POST["wpbot_card_response_same_window"]);
                }else{ $wpbot_card_response_same_window='';}
                update_option('wpbot_card_response_same_window', stripslashes($wpbot_card_response_same_window));

				if(isset( $_POST["disable_youtube_parse"])) {
                    $disable_youtube_parse = qcld_sanitize_field($_POST["disable_youtube_parse"]);
                }else{ $disable_youtube_parse='';}
                update_option('disable_youtube_parse', stripslashes($disable_youtube_parse)); 
                

                if(isset( $_POST["wpbot_search_image_size"])) {
                    $wpbot_search_image_size = qcld_sanitize_field($_POST["wpbot_search_image_size"]);
                }else{ $wpbot_search_image_size='';}
                update_option('wpbot_search_image_size', stripslashes($wpbot_search_image_size));

                

                if(isset( $_POST["wpbot_disable_repeatative"])) {
                    $wpbot_disable_repeatative = qcld_sanitize_field($_POST["wpbot_disable_repeatative"]);
                }else{ $wpbot_disable_repeatative='';}
                update_option('wpbot_disable_repeatative', stripslashes($wpbot_disable_repeatative));
				
				if(isset( $_POST["qc_display_for_loggedin_users"])) {
                    $qc_display_for_loggedin_users = qcld_sanitize_field($_POST["qc_display_for_loggedin_users"]);
                }else{ $qc_display_for_loggedin_users='';}
                update_option('qc_display_for_loggedin_users', stripslashes($qc_display_for_loggedin_users));

                if(isset( $_POST["wpbot_preloading_time"])) {
                    $wpbot_preloading_time = qcld_sanitize_field($_POST["wpbot_preloading_time"]);
                }else{ $wpbot_preloading_time='';}
                update_option('wpbot_preloading_time', stripslashes($wpbot_preloading_time));

                

                if(isset( $_POST["wpbot_search_result_number"])) {
                    $wpbot_search_result_number = qcld_sanitize_field($_POST["wpbot_search_result_number"]);
                }else{ $wpbot_search_result_number='';}
                update_option('wpbot_search_result_number', stripslashes($wpbot_search_result_number));

                if(isset( $_POST["wpbot_gdpr_text"])) {

                    $wpbot_gdpr_text = ($_POST["wpbot_gdpr_text"]);

                }else{ $wpbot_gdpr_text='';}
                
                update_option('wpbot_gdpr_text', stripslashes_deep($wpbot_gdpr_text));

                if(isset( $_POST["no_result_attempt_message"])) {

                    $no_result_attempt_message = ($_POST["no_result_attempt_message"]);

                }else{ $no_result_attempt_message='';}
                
                update_option('no_result_attempt_message', stripslashes_deep($no_result_attempt_message));

                
				
				if(isset( $_POST["no_result_attempt_count"])) {
                    $no_result_attempt_count = qcld_sanitize_field($_POST["no_result_attempt_count"]);
                }else{ $no_result_attempt_count='';}
                update_option('no_result_attempt_count', stripslashes($no_result_attempt_count));

                if(isset( $_POST["disable_wp_chatbot_icon_animation"])) {
                    $disable_wp_chatbot_icon_animation = qcld_sanitize_field($_POST["disable_wp_chatbot_icon_animation"]);
                }else{ $disable_wp_chatbot_icon_animation='';}
                update_option('disable_wp_chatbot_icon_animation', stripslashes($disable_wp_chatbot_icon_animation));
       
                if(isset( $_POST["enable_extended_header_animation"])) {
                    $enable_extended_header_animation = qcld_sanitize_field($_POST["enable_extended_header_animation"]);
                }else{ $enable_extended_header_animation='';}
                update_option('enable_extended_header_animation', stripslashes($enable_extended_header_animation));

                if(isset( $_POST["disable_wp_agent_icon_animation"])) {
                    $disable_wp_agent_icon_animation = qcld_sanitize_field($_POST["disable_wp_agent_icon_animation"]);
                }else{ $disable_wp_agent_icon_animation='';}
                update_option('disable_wp_agent_icon_animation', stripslashes($disable_wp_agent_icon_animation));

                if(isset( $_POST["disable_wp_chatbot_history"])) {
                    $disable_wp_chatbot_history = qcld_sanitize_field($_POST["disable_wp_chatbot_history"]);
                }else{ $disable_wp_chatbot_history='';}
                update_option('disable_wp_chatbot_history', stripslashes($disable_wp_chatbot_history));
				
				if(isset( $_POST["always_scroll_to_bottom"])) {
                    $always_scroll_to_bottom = qcld_sanitize_field($_POST["always_scroll_to_bottom"]);
                }else{ $always_scroll_to_bottom='';}
                update_option('always_scroll_to_bottom', stripslashes($always_scroll_to_bottom));

                

                

                if(isset( $_POST["wpbot_notification_navigations"])) {
                    $wpbot_notification_navigations = $_POST["wpbot_notification_navigations"];
                }else{ $wpbot_notification_navigations='';}
                update_option('wpbot_notification_navigations', serialize($wpbot_notification_navigations));

                //Product per page settings.
                if (isset($_POST["qlcd_wp_chatbot_ppp"])) {
                    $qlcd_wp_chatbot_ppp = qcld_sanitize_field($_POST["qlcd_wp_chatbot_ppp"]);
                    update_option('qlcd_wp_chatbot_ppp', intval($qlcd_wp_chatbot_ppp));
                }
                
                if (isset($_POST["qlcd_wp_chatbot_order_user"])) {
                    $qlcd_wp_chatbot_order_user = qcld_sanitize_field($_POST["qlcd_wp_chatbot_order_user"]);
                    update_option('qlcd_wp_chatbot_order_user', qcld_sanitize_field($qlcd_wp_chatbot_order_user));
                }
                //wpwBot Load control
                $wp_chatbot_show_home_page = sanitize_key((@$_POST["wp_chatbot_show_home_page"]));
                update_option('wp_chatbot_show_home_page', $wp_chatbot_show_home_page);
                $wp_chatbot_show_posts = sanitize_key((@$_POST["wp_chatbot_show_posts"]));
                update_option('wp_chatbot_show_posts', $wp_chatbot_show_posts);
                $wp_chatbot_show_pages = sanitize_key((@$_POST["wp_chatbot_show_pages"]));
                update_option('wp_chatbot_show_pages', $wp_chatbot_show_pages);
                if(isset( $_POST["wp_chatbot_show_pages_list"])) {
                    $wp_chatbot_show_pages_list = $_POST["wp_chatbot_show_pages_list"];
                }else{ $wp_chatbot_show_pages_list='';}
                update_option('wp_chatbot_show_pages_list', serialize($wp_chatbot_show_pages_list));
                $wp_chatbot_show_woocommerce = sanitize_key(isset($_POST["wp_chatbot_show_woocommerce"])?$_POST["wp_chatbot_show_woocommerce"]:'');
                update_option('wp_chatbot_show_woocommerce', $wp_chatbot_show_woocommerce);
                //Stop Words Settings
                
                //wpwbot icon settings.
                $wp_chatbot_icon = $_POST['wp_chatbot_icon'] ? $_POST['wp_chatbot_icon'] : 'icon-3.png';
                update_option('wp_chatbot_icon', qcld_sanitize_field($wp_chatbot_icon));
                // upload custom wpwbot icon path
                 $wp_chatbot_custom_icon_path = @$_POST['wp_chatbot_custom_icon_path'];
                 update_option('wp_chatbot_custom_icon_path', qcld_sanitize_field($wp_chatbot_custom_icon_path));
                 //Agent image
                //wpwbot icon settings.
                $wp_chatbot_icon = $_POST['wp_chatbot_agent_image'] ? $_POST['wp_chatbot_agent_image'] : 'agent-0.png';
                 update_option('wp_chatbot_agent_image', qcld_sanitize_field($wp_chatbot_icon));
                // upload custom wpwbot icon
                $wp_chatbot_custom_agent_path = @$_POST['wp_chatbot_custom_agent_path'];
                update_option('wp_chatbot_custom_agent_path', qcld_sanitize_field($wp_chatbot_custom_agent_path));
                //Theming
                $qcld_wb_chatbot_theme = $_POST['qcld_wb_chatbot_theme'] ? $_POST['qcld_wb_chatbot_theme'] : 'template-00';
                 update_option('qcld_wb_chatbot_theme', qcld_sanitize_field($qcld_wb_chatbot_theme));
                //Theme custom background option
                if(isset( $_POST["qcld_wb_chatbot_change_bg"])) {
                    $qcld_wb_chatbot_change_bg = qcld_sanitize_field($_POST["qcld_wb_chatbot_change_bg"]);
                }else{$qcld_wb_chatbot_change_bg='';}
                update_option('qcld_wb_chatbot_change_bg', stripslashes($qcld_wb_chatbot_change_bg));
                $qcld_wb_chatbot_board_bg_path = qcld_sanitize_field(@$_POST["qcld_wb_chatbot_board_bg_path"]);
                update_option('qcld_wb_chatbot_board_bg_path', stripslashes($qcld_wb_chatbot_board_bg_path));
                //To override style use custom css.
                $wp_chatbot_custom_css = qcld_sanitize_field(@$_POST["wp_chatbot_custom_css"]);
                update_option('wp_chatbot_custom_css', stripslashes($wp_chatbot_custom_css));
                /****Language center settings.   ****/

				if(isset($_POST["qlcd_wp_chatbot_tag_search_intent"])){
					$qlcd_wp_chatbot_tag_search_intent = $_POST["qlcd_wp_chatbot_tag_search_intent"];
					update_option('qlcd_wp_chatbot_tag_search_intent', serialize($qlcd_wp_chatbot_tag_search_intent));
				}

				$qlcd_wp_chatbot_sys_key_livechat = isset($_POST["qlcd_wp_chatbot_sys_key_livechat"])?$_POST["qlcd_wp_chatbot_sys_key_livechat"]:'';
                update_option('qlcd_wp_chatbot_sys_key_livechat', ($qlcd_wp_chatbot_sys_key_livechat));
                
                $qlcd_wp_chatbot_wildcard_support = @$_POST["qlcd_wp_chatbot_wildcard_support"];
                update_option('qlcd_wp_chatbot_wildcard_support', ($qlcd_wp_chatbot_wildcard_support));
                $qlcd_wp_chatbot_messenger_label = @$_POST["qlcd_wp_chatbot_messenger_label"];
                update_option('qlcd_wp_chatbot_messenger_label', serialize($qlcd_wp_chatbot_messenger_label));
                //Products search .
                
                $qlcd_wp_chatbot_support_phone= $_POST["qlcd_wp_chatbot_support_phone"];
                update_option('qlcd_wp_chatbot_support_phone', ($qlcd_wp_chatbot_support_phone));
                
            
                $qlcd_wp_chatbot_admin_email = $_POST["qlcd_wp_chatbot_admin_email"];
                update_option('qlcd_wp_chatbot_admin_email', qcld_sanitize_field($qlcd_wp_chatbot_admin_email));

                $qlcd_wp_chatbot_from_email = $_POST["qlcd_wp_chatbot_from_email"];
                update_option('qlcd_wp_chatbot_from_email', qcld_sanitize_field($qlcd_wp_chatbot_from_email));
				
				$qlcd_wp_chatbot_from_name = $_POST["qlcd_wp_chatbot_from_name"];
                update_option('qlcd_wp_chatbot_from_name', qcld_sanitize_field($qlcd_wp_chatbot_from_name));

                $qlcd_wp_chatbot_reply_to_email = $_POST["qlcd_wp_chatbot_reply_to_email"];
                update_option('qlcd_wp_chatbot_reply_to_email', qcld_sanitize_field($qlcd_wp_chatbot_reply_to_email));

				$qlcd_wp_site_search = $_POST["qlcd_wp_site_search"];
                update_option('qlcd_wp_site_search', ($qlcd_wp_site_search));
				
				$qlcd_wp_livechat = isset($_POST["qlcd_wp_livechat"])?$_POST["qlcd_wp_livechat"]:'';
                update_option('qlcd_wp_livechat', qcld_sanitize_field($qlcd_wp_livechat));
				
				$qlcd_wp_email_subscription = $_POST["qlcd_wp_email_subscription"];
                update_option('qlcd_wp_email_subscription', ($qlcd_wp_email_subscription));
				
                if(class_exists('Qcld_str_pro')){
                    $qlcd_wp_str_category = $_POST["qlcd_wp_str_category"];
                    update_option('qlcd_wp_str_category', ($qlcd_wp_str_category));
                }
                
                if((is_plugin_active( 'voice-message-addon/wpbotvoicemessage.php' ) || (in_array( "WPBot Voice Module",get_option( 'wpbot_master_addons')['active'])) )){
                    $qlcd_wp_voice_message = $_POST["qlcd_wp_voice_message"];
                    update_option('qlcd_wp_voice_message', ($qlcd_wp_voice_message));
                }
                
                if(isset($_POST["qlcd_open_ticket_label"])){
                    $qlcd_open_ticket_label = $_POST["qlcd_open_ticket_label"];
                    update_option('qlcd_open_ticket_label', ($qlcd_open_ticket_label));
                }
                
                $qlcd_wp_send_us_email = stripslashes_deep($_POST["qlcd_wp_send_us_email"]);
                update_option('qlcd_wp_send_us_email', ($qlcd_wp_send_us_email));

                $qlcd_wp_send_us_email = stripslashes_deep($_POST["qlcd_wp_good_bye"]);
                update_option('qlcd_wp_good_bye', ($qlcd_wp_send_us_email));
                
                $qlcd_wp_leave_feedback = stripslashes_deep($_POST["qlcd_wp_leave_feedback"]);
                update_option('qlcd_wp_leave_feedback', ($qlcd_wp_leave_feedback));
				
                
                //Notifications messages building.
                $qlcd_wp_chatbot_notification_interval = stripslashes($_POST["qlcd_wp_chatbot_notification_interval"]);
                update_option('qlcd_wp_chatbot_notification_interval', qcld_sanitize_field($qlcd_wp_chatbot_notification_interval));

                $qlcd_wp_chatbot_notifications = $_POST["qlcd_wp_chatbot_notifications"];
                update_option('qlcd_wp_chatbot_notifications', serialize($qlcd_wp_chatbot_notifications));

                $qlcd_wp_chatbot_notifications_intent = @$_POST["qlcd_wp_chatbot_notifications_intent"];
                update_option('qlcd_wp_chatbot_notifications_intent', serialize($qlcd_wp_chatbot_notifications_intent));
                

                //Support building part.
                $support_query = $_POST["support_query"];
                update_option('support_query', serialize($support_query));
                $support_ans = $_POST["support_ans"];
                update_option('support_ans', serialize($support_ans));
				
				$custom_intent = $_POST["qlcd_wp_custon_intent"];
                update_option('qlcd_wp_custon_intent', serialize($custom_intent));
				$custom_intent_label = $_POST["qlcd_wp_custon_intent_label"];
                update_option('qlcd_wp_custon_intent_label', serialize($custom_intent_label));
                if(isset($_POST["qlcd_wp_custon_intent_checkbox"]) && is_array($_POST["qlcd_wp_custon_intent_checkbox"])){
                    foreach($_POST["qlcd_wp_custon_intent_checkbox"] as $key=>$val){
                        if($val==''){
                            $_POST["qlcd_wp_custon_intent_checkbox"][$key] = 1;
                        }
                    }
                }
				if( isset( $_POST["qlcd_wp_custon_intent_checkbox"] ) ){
					$custom_intent_email = @$_POST["qlcd_wp_custon_intent_checkbox"];
					update_option('qlcd_wp_custon_intent_checkbox', serialize($custom_intent_email));
                  
				}
                

                $qlcd_wp_custon_menu = $_POST["qlcd_wp_custon_menu"];
                update_option('qlcd_wp_custon_menu', serialize($qlcd_wp_custon_menu));

				$qlcd_wp_custon_menu_link = $_POST["qlcd_wp_custon_menu_link"];
                update_option('qlcd_wp_custon_menu_link', serialize($qlcd_wp_custon_menu_link));

                if(isset($_POST["qlcd_wp_custon_menu_checkbox"]) && is_array($_POST["qlcd_wp_custon_menu_checkbox"])){
                    foreach($_POST["qlcd_wp_custon_menu_checkbox"] as $key=>$val){
                        if($val==''){
                            $_POST["qlcd_wp_custon_menu_checkbox"][$key] = 0;
                        }
                    }
                }
				
				if(isset($_POST["qlcd_wp_custon_menu_type"])){
					foreach($_POST["qlcd_wp_custon_menu_type"] as $k=>$v){
						if(!isset($_POST["qlcd_wp_custon_menu_checkbox"][$k])){
							$_POST["qlcd_wp_custon_menu_checkbox"][$k] = 0;
						}
					}
				}
				
				$qlcd_wp_custon_menu_target = @$_POST["qlcd_wp_custon_menu_checkbox"];
                update_option('qlcd_wp_custon_menu_checkbox', serialize($qlcd_wp_custon_menu_target));
				
				$qlcd_wp_custon_menu_type = @$_POST["qlcd_wp_custon_menu_type"];
                update_option('qlcd_wp_custon_menu_type', serialize($qlcd_wp_custon_menu_type));
				
                //Create Mobile app pages.
                if(isset( $_POST["wp_chatbot_app_pages"])) {
                    $wp_chatbot_app_pages = qcld_sanitize_field($_POST["wp_chatbot_app_pages"]);
                }else{ $wp_chatbot_app_pages='';}
                update_option('wp_chatbot_app_pages', stripslashes($wp_chatbot_app_pages));
                //Messenger Options
                if(isset( $_POST["enable_wp_chatbot_messenger"])) {
                    $enable_wp_chatbot_messenger = qcld_sanitize_field($_POST["enable_wp_chatbot_messenger"]);
                }else{ $enable_wp_chatbot_messenger='';}
                update_option('enable_wp_chatbot_messenger', stripslashes($enable_wp_chatbot_messenger));
                if(isset( $_POST["enable_wp_chatbot_messenger_floating_icon"])) {
                    $enable_wp_chatbot_messenger_floating_icon = qcld_sanitize_field($_POST["enable_wp_chatbot_messenger_floating_icon"]);
                }else{ $enable_wp_chatbot_messenger_floating_icon='';}
                update_option('enable_wp_chatbot_messenger_floating_icon', stripslashes($enable_wp_chatbot_messenger_floating_icon));
                $qlcd_wp_chatbot_fb_app_id = $_POST["qlcd_wp_chatbot_fb_app_id"];
                update_option('qlcd_wp_chatbot_fb_app_id', qcld_sanitize_field($qlcd_wp_chatbot_fb_app_id));
                $qlcd_wp_chatbot_fb_page_id = $_POST["qlcd_wp_chatbot_fb_page_id"];
                update_option('qlcd_wp_chatbot_fb_page_id', qcld_sanitize_field($qlcd_wp_chatbot_fb_page_id));
                $qlcd_wp_chatbot_fb_color= $_POST["qlcd_wp_chatbot_fb_color"];
                update_option('qlcd_wp_chatbot_fb_color', stripslashes($qlcd_wp_chatbot_fb_color));
                $qlcd_wp_chatbot_fb_in_msg = $_POST["qlcd_wp_chatbot_fb_in_msg"];
                update_option('qlcd_wp_chatbot_fb_in_msg', qcld_sanitize_field($qlcd_wp_chatbot_fb_in_msg));
                $qlcd_wp_chatbot_fb_out_msg = $_POST["qlcd_wp_chatbot_fb_out_msg"];
                update_option('qlcd_wp_chatbot_fb_out_msg', qcld_sanitize_field($qlcd_wp_chatbot_fb_out_msg));
                //Skype option
                if(isset( $_POST["enable_wp_chatbot_skype_floating_icon"])) {
                $enable_wp_chatbot_skype_floating_icon = $_POST["enable_wp_chatbot_skype_floating_icon"];
                }else{ $enable_wp_chatbot_skype_floating_icon='';}
                update_option('enable_wp_chatbot_skype_floating_icon', qcld_sanitize_field($enable_wp_chatbot_skype_floating_icon));
                if(isset( $_POST["enable_wp_chatbot_skype_id"])) {
                    $enable_wp_chatbot_skype_id = $_POST["enable_wp_chatbot_skype_id"];
                }else{ $enable_wp_chatbot_skype_id='';}
                update_option('enable_wp_chatbot_skype_id', qcld_sanitize_field($enable_wp_chatbot_skype_id));
                //WhatsApp
                if(isset( $_POST["enable_wp_chatbot_whats"])) {
                    $enable_wp_chatbot_whats= $_POST["enable_wp_chatbot_whats"];
                }else{ $enable_wp_chatbot_whats='';}
                update_option('enable_wp_chatbot_whats', qcld_sanitize_field($enable_wp_chatbot_whats));
                $qlcd_wp_chatbot_whats_label = $_POST["qlcd_wp_chatbot_whats_label"];
                update_option('qlcd_wp_chatbot_whats_label', serialize($qlcd_wp_chatbot_whats_label));
                if(isset( $_POST["enable_wp_chatbot_floating_whats"])) {
                    $enable_wp_chatbot_floating_whats= $_POST["enable_wp_chatbot_floating_whats"];
                }else{ $enable_wp_chatbot_floating_whats='';}
                update_option('enable_wp_chatbot_floating_whats', qcld_sanitize_field($enable_wp_chatbot_floating_whats));
                $qlcd_wp_chatbot_whats_num = $_POST["qlcd_wp_chatbot_whats_num"];
                update_option('qlcd_wp_chatbot_whats_num', qcld_sanitize_field($qlcd_wp_chatbot_whats_num));
               //Viber
                if(isset( $_POST["enable_wp_chatbot_floating_viber"])) {
                    $enable_wp_chatbot_floating_viber = $_POST["enable_wp_chatbot_floating_viber"];
                }else{ $enable_wp_chatbot_floating_viber='';}
                update_option('enable_wp_chatbot_floating_viber', qcld_sanitize_field($enable_wp_chatbot_floating_viber));
                $qlcd_wp_chatbot_viber_acc = $_POST["qlcd_wp_chatbot_viber_acc"];
                update_option('qlcd_wp_chatbot_viber_acc', qcld_sanitize_field($qlcd_wp_chatbot_viber_acc));
                //Others integration
                if(isset( $_POST["enable_wp_chatbot_floating_phone"])) {
                    $enable_wp_chatbot_floating_phone = $_POST["enable_wp_chatbot_floating_phone"];
                }else{ $enable_wp_chatbot_floating_phone='';}
                update_option('enable_wp_chatbot_floating_phone', qcld_sanitize_field($enable_wp_chatbot_floating_phone));
				
				if(isset( $_POST["enable_wp_chatbot_floating_livechat"])) {
                    $enable_wp_chatbot_floating_livechat = $_POST["enable_wp_chatbot_floating_livechat"];
                }else{ $enable_wp_chatbot_floating_livechat='';}
                update_option('enable_wp_chatbot_floating_livechat', qcld_sanitize_field($enable_wp_chatbot_floating_livechat));
				
				if(isset( $_POST["enable_wp_custom_intent_livechat_button"])) {
                    $enable_wp_custom_intent_livechat_button = $_POST["enable_wp_custom_intent_livechat_button"];
                }else{ $enable_wp_custom_intent_livechat_button='';}
                update_option('enable_wp_custom_intent_livechat_button', qcld_sanitize_field($enable_wp_custom_intent_livechat_button));
				
				
                $qlcd_wp_chatbot_phone = $_POST["qlcd_wp_chatbot_phone"];
                update_option('qlcd_wp_chatbot_phone', qcld_sanitize_field($qlcd_wp_chatbot_phone));
				
				$qlcd_wp_chatbot_livechatlink = (isset($_POST["qlcd_wp_chatbot_livechatlink"])?$_POST["qlcd_wp_chatbot_livechatlink"]:'');
                update_option('qlcd_wp_chatbot_livechatlink', qcld_sanitize_field($qlcd_wp_chatbot_livechatlink));
				
				$qlcd_wp_livechat_button_label = (isset($_POST["qlcd_wp_livechat_button_label"])?$_POST["qlcd_wp_livechat_button_label"]:'');
                update_option('qlcd_wp_livechat_button_label', qcld_sanitize_field($qlcd_wp_livechat_button_label));
				
				$wp_custom_icon_livechat = $_POST["wp_custom_icon_livechat"];
                update_option('wp_custom_icon_livechat', qcld_sanitize_field($wp_custom_icon_livechat));
                
				if( isset( $_POST["enable_wp_chatbot_voice_message"] ) ){
					$enable_wp_chatbot_voice_message = @$_POST["enable_wp_chatbot_voice_message"];
					update_option('enable_wp_chatbot_voice_message', qcld_sanitize_field($enable_wp_chatbot_voice_message));
				}
                
				
				$wp_custom_help_icon = $_POST["wp_custom_help_icon"];
                update_option('wp_custom_help_icon', qcld_sanitize_field($wp_custom_help_icon));

                $wp_custom_client_icon = $_POST["wp_custom_client_icon"];
                update_option('wp_custom_client_icon', qcld_sanitize_field($wp_custom_client_icon));
				
				$wp_custom_support_icon = $_POST["wp_custom_support_icon"];
                update_option('wp_custom_support_icon', qcld_sanitize_field($wp_custom_support_icon));
				
				$wp_custom_chat_icon = $_POST["wp_custom_chat_icon"];
                update_option('wp_custom_chat_icon', qcld_sanitize_field($wp_custom_chat_icon));
                
                $wp_custom_livechat_icon = $_POST["wp_custom_livechat_icon"];
                update_option('wp_custom_livechat_icon', qcld_sanitize_field($wp_custom_livechat_icon));

                $wp_custom_typing_icon = $_POST["wp_custom_typing_icon"];
                update_option('wp_custom_typing_icon', qcld_sanitize_field($wp_custom_typing_icon));
                

                if(isset( $_POST["enable_wp_chatbot_floating_link"])) {
                    $enable_wp_chatbot_floating_link = $_POST["enable_wp_chatbot_floating_link"];
                }else{ $enable_wp_chatbot_floating_link='';}
                update_option('enable_wp_chatbot_floating_link', qcld_sanitize_field($enable_wp_chatbot_floating_link));
                $qlcd_wp_chatbot_weblink = $_POST["qlcd_wp_chatbot_weblink"];
                update_option('qlcd_wp_chatbot_weblink', qcld_sanitize_field($qlcd_wp_chatbot_weblink));

                //Re Targetting.
                
                if(isset( $_POST["wp_chatbot_exit_intent_bargain_msg"])) {
                    $wp_chatbot_exit_intent_bargain_msg = qcld_sanitize_field($_POST["wp_chatbot_exit_intent_bargain_msg"]);
                }else{ $wp_chatbot_exit_intent_bargain_msg='';}
                update_option('wp_chatbot_exit_intent_bargain_msg', qcld_sanitize_field($wp_chatbot_exit_intent_bargain_msg));


                if(isset( $_POST["enable_wp_chatbot_sound_initial"])) {
                    $enable_wp_chatbot_sound_initial = $_POST["enable_wp_chatbot_sound_initial"];
                }else{ $enable_wp_chatbot_sound_initial='';}
                update_option('enable_wp_chatbot_sound_initial', qcld_sanitize_field($enable_wp_chatbot_sound_initial));


                if(isset( $_POST["enable_wp_chatbot_sound_botmessage"])) {
                    $enable_wp_chatbot_sound_botmessage = $_POST["enable_wp_chatbot_sound_botmessage"];
                }else{ $enable_wp_chatbot_sound_botmessage='';}
                update_option('enable_wp_chatbot_sound_botmessage', qcld_sanitize_field($enable_wp_chatbot_sound_botmessage));

                if(isset( $_POST["disable_wp_chatbot_call_gen"])) {
                    $disable_wp_chatbot_call_gen = $_POST["disable_wp_chatbot_call_gen"];
                }else{ $disable_wp_chatbot_call_gen='';}
                update_option('disable_wp_chatbot_call_gen', qcld_sanitize_field($disable_wp_chatbot_call_gen));

                if(isset( $_POST["disable_wp_chatbot_call_sup"])) {
                    $disable_wp_chatbot_call_sup = $_POST["disable_wp_chatbot_call_sup"];
                }else{ $disable_wp_chatbot_call_sup='';}
                update_option('disable_wp_chatbot_call_sup', qcld_sanitize_field($disable_wp_chatbot_call_sup));

                if(isset( $_POST["disable_wp_chatbot_feedback"])) {
                    $disable_wp_chatbot_feedback = $_POST["disable_wp_chatbot_feedback"];
                }else{ $disable_wp_chatbot_feedback='';}
                update_option('disable_wp_chatbot_feedback', qcld_sanitize_field($disable_wp_chatbot_feedback));

                if(isset( $_POST["disable_good_bye"])) {
                    $disable_wp_chatbot_feedback = $_POST["disable_good_bye"];
                }else{ $disable_wp_chatbot_feedback='';}
                update_option('disable_good_bye', qcld_sanitize_field($disable_wp_chatbot_feedback));
				
				if(isset( $_POST["disable_wp_leave_feedback"])) {
                    $disable_wp_leave_feedback = $_POST["disable_wp_leave_feedback"];
                }else{ $disable_wp_leave_feedback='';}
                update_option('disable_wp_leave_feedback', qcld_sanitize_field($disable_wp_leave_feedback));
				
				if(isset( $_POST["disable_wp_chatbot_site_search"])) {
                    $disable_wp_chatbot_site_search = $_POST["disable_wp_chatbot_site_search"];
                }else{ $disable_wp_chatbot_site_search='';}
                update_option('disable_wp_chatbot_site_search', qcld_sanitize_field($disable_wp_chatbot_site_search));
				
				if(isset( $_POST["disable_wp_chatbot_faq"])) {
                    $disable_wp_chatbot_faq = $_POST["disable_wp_chatbot_faq"];
                }else{ $disable_wp_chatbot_faq='';}
                update_option('disable_wp_chatbot_faq', qcld_sanitize_field($disable_wp_chatbot_faq));
				
				if(isset( $_POST["disable_email_subscription"])) {
                    $disable_email_subscription = $_POST["disable_email_subscription"];
                }else{ $disable_email_subscription='';}
                update_option('disable_email_subscription', qcld_sanitize_field($disable_email_subscription));
                
                if(isset( $_POST["disable_voice_message"])) {
                    $disable_voice_message = $_POST["disable_voice_message"];
                }else{ $disable_voice_message='';}
                update_option('disable_voice_message', qcld_sanitize_field($disable_voice_message));
				
				if(class_exists('Qcld_str_pro')){
					if(isset( $_POST["disable_str_categories"])) {
						$disable_str_categories = $_POST["disable_str_categories"];
					}else{ $disable_str_categories='';}
					update_option('disable_str_categories', qcld_sanitize_field($disable_str_categories));
				}

				if(isset( $_POST["disable_open_ticket"])) {
                    $disable_open_ticket = $_POST["disable_open_ticket"];
                }else{ $disable_open_ticket='';}
                update_option('disable_open_ticket', qcld_sanitize_field($disable_open_ticket));
				
				if(isset( $_POST["disable_livechat"])) {
                    $disable_livechat = $_POST["disable_livechat"];
                }else{ $disable_livechat='';}
                update_option('disable_livechat', qcld_sanitize_field($disable_livechat));

                if(isset( $_POST["disable_livechat_opration_icon"])) {
                    $disable_livechat_opration_icon = $_POST["disable_livechat_opration_icon"];
                }else{ $disable_livechat_opration_icon='';}
                update_option('disable_livechat_opration_icon', qcld_sanitize_field($disable_livechat_opration_icon));

                

                if(isset( $_POST["enable_wp_chatbot_opening_hour"])) {
                    $enable_wp_chatbot_opening_hour = $_POST["enable_wp_chatbot_opening_hour"];
                }else{ $enable_wp_chatbot_opening_hour='';}
                update_option('enable_wp_chatbot_opening_hour', qcld_sanitize_field($enable_wp_chatbot_opening_hour));

                $wpwbot_hours= $_POST["wpwbot_hours"];
                update_option('wpwbot_hours', serialize($wpwbot_hours));

                if(isset( $_POST["enable_wp_chatbot_dailogflow"])) {
                    $enable_wp_chatbot_dailogflow = $_POST["enable_wp_chatbot_dailogflow"];
                }else{ $enable_wp_chatbot_dailogflow='';}
                update_option('enable_wp_chatbot_dailogflow', qcld_sanitize_field($enable_wp_chatbot_dailogflow));

                if(isset( $_POST["wpbot_trigger_intent"])) {
                    $wpbot_trigger_intent = $_POST["wpbot_trigger_intent"];
                }else{ $wpbot_trigger_intent='';}
                update_option('wpbot_trigger_intent', ($wpbot_trigger_intent));
				
				if(isset( $_POST["wpbot_trigger_intent_loggged_in"])) {
                    $wpbot_trigger_intent_loggged_in = $_POST["wpbot_trigger_intent_loggged_in"];
                }else{ $wpbot_trigger_intent_loggged_in='';}
                update_option('wpbot_trigger_intent_loggged_in', ($wpbot_trigger_intent_loggged_in));

                if(isset( $_POST["enable_authentication_webhook"])) {
                    $enable_authentication_webhook = $_POST["enable_authentication_webhook"];
                }else{ $enable_authentication_webhook='';}
                update_option('enable_authentication_webhook', qcld_sanitize_field($enable_authentication_webhook));

                if(isset( $_POST["qcld_auth_username"])) {
                    $qcld_auth_username = $_POST["qcld_auth_username"];
                }else{ $qcld_auth_username='';}
                update_option('qcld_auth_username', qcld_sanitize_field($qcld_auth_username));

                if(isset( $_POST["qcld_auth_password"])) {
                    $qcld_auth_password = $_POST["qcld_auth_password"];
                }else{ $qcld_auth_password='';}
                update_option('qcld_auth_password', qcld_sanitize_field($qcld_auth_password));


                $qlcd_wp_chatbot_dialogflow_client_token= isset($_POST["qlcd_wp_chatbot_dialogflow_client_token"])?$_POST["qlcd_wp_chatbot_dialogflow_client_token"]:'';
                update_option('qlcd_wp_chatbot_dialogflow_client_token', qcld_sanitize_field($qlcd_wp_chatbot_dialogflow_client_token));

                $qlcd_wp_chatbot_dialogflow_project_id= $_POST["qlcd_wp_chatbot_dialogflow_project_id"];
                update_option('qlcd_wp_chatbot_dialogflow_project_id', qcld_sanitize_field($qlcd_wp_chatbot_dialogflow_project_id));
                
                if( isset( $_POST["qlcd_wp_chatbot_dialogflow_cx"] ) ){
                    $qlcd_wp_chatbot_dialogflow_cx= $_POST["qlcd_wp_chatbot_dialogflow_cx"];
                }else{
                    $qlcd_wp_chatbot_dialogflow_cx= '';
                }
                update_option('qlcd_wp_chatbot_dialogflow_cx', ($qlcd_wp_chatbot_dialogflow_cx));

                $wp_chatbot_df_api= @$_POST["wp_chatbot_df_api"];
                update_option('wp_chatbot_df_api', qcld_sanitize_field($wp_chatbot_df_api));

                
               
                $qlcd_wp_chatbot_dialogflow_project_key= $_POST["qlcd_wp_chatbot_dialogflow_project_key"];
                update_option('qlcd_wp_chatbot_dialogflow_project_key', stripslashes_deep($qlcd_wp_chatbot_dialogflow_project_key));

                $qlcd_wp_chatbot_dialogflow_defualt_reply= $_POST["qlcd_wp_chatbot_dialogflow_defualt_reply"];
                update_option('qlcd_wp_chatbot_dialogflow_defualt_reply', qcld_sanitize_field($qlcd_wp_chatbot_dialogflow_defualt_reply));
				
				$qlcd_wp_chatbot_dialogflow_agent_language= $_POST["qlcd_wp_chatbot_dialogflow_agent_language"];
                update_option('qlcd_wp_chatbot_dialogflow_agent_language', qcld_sanitize_field($qlcd_wp_chatbot_dialogflow_agent_language));

                set_transient( 'bot_clear_cache', 1, DAY_IN_SECONDS );

            }
            wp_enqueue_script( 'wp_chatbot_bot-front', QCLD_wpCHATBOT_PLUGIN_URL . 'js/sweetalert.js', array('jquery'), '', true);
            $script = "
            function callsweetalert(){
                Swal.fire({
                    title: 'Your settings are saved.',
                        html: '<p style=font-size:14px>Please clear your browser <b>cache</b> and <b>cookies</b> both and reload the front end before testing. Alternatively, you can launch a new browser window in <b>Incognito</b>/Private mode (Ctrl+Shift+N in chrome) to test.</p>',
                        width: 450,
                        icon: 'success',
                        confirmButtonText: 'Got it',
                        confirmButtonWidth: 100,
                        confirmButtonClass: 'btn btn-lg'     
                    })
                }
                callsweetalert();
                ";

            wp_add_inline_script( 'wp_chatbot_bot-front', $script );
        }

    }

    /**
     * Retargeting Option save
     *
     * @return void
     */
    function retarget_options_save(){
        if ((empty($_GET["page"])) || ($_GET['page'] !== 'retarget-settings')) {
            return;
        }
        if (isset($_POST['_wpnonce']) && $_POST['_wpnonce']) {
            wp_verify_nonce($_POST['_wpnonce'], 'wp_chatbot');
            // Check if the form is submitted or not
            if (isset($_POST['submit'])) {

                $qlcd_wp_chatbot_ret_greet = $_POST["qlcd_wp_chatbot_ret_greet"];
                update_option('qlcd_wp_chatbot_ret_greet', ($qlcd_wp_chatbot_ret_greet));

                if(isset( $_POST["enable_wp_chatbot_exit_intent"])) {
                    $enable_wp_chatbot_exit_intent = $_POST["enable_wp_chatbot_exit_intent"];
                }else{ $enable_wp_chatbot_exit_intent='';}
                update_option('enable_wp_chatbot_exit_intent', qcld_sanitize_field($enable_wp_chatbot_exit_intent));

                $wp_chatbot_exit_intent_msg = ($_POST["wp_chatbot_exit_intent_msg"]);
                update_option('wp_chatbot_exit_intent_msg', stripslashes_deep($wp_chatbot_exit_intent_msg));

				$trigger_url_exit = isset($_POST["trigger_url_exit"]) ? qcld_sanitize_field($_POST["trigger_url_exit"]) : '';
                update_option('wp_chatbot_trigger_url_exit', stripslashes_deep($trigger_url_exit));
                $trigger_exit_url_id = [];
                foreach ( explode(",",$trigger_url_exit) as $key => $url) {
                    $url_id = url_to_postid($url);
                    array_push($trigger_exit_url_id,$url_id);
                }
                $trigger_url_exit_id = implode(',', $trigger_exit_url_id);
                update_option('trigger_url_exit_id', stripslashes_deep($trigger_url_exit_id));

				$wp_chatbot_exit_intent_custom = qcld_sanitize_field($_POST["wp_chatbot_exit_intent_custom"]);
                update_option('wp_chatbot_exit_intent_custom', stripslashes($wp_chatbot_exit_intent_custom));

                
                if(isset( $_POST["wp_chatbot_exit_intent_bargain_pro_single_page"])) {
                    $wp_chatbot_exit_intent_bargain_pro_single_page = $_POST["wp_chatbot_exit_intent_bargain_pro_single_page"];
                }else{ $wp_chatbot_exit_intent_bargain_pro_single_page='';}
                update_option('wp_chatbot_exit_intent_bargain_pro_single_page', qcld_sanitize_field($wp_chatbot_exit_intent_bargain_pro_single_page));

                if( isset( $_POST["wp_chatbot_exit_intent_email"] ) ){
					$wp_chatbot_exit_intent_email = qcld_sanitize_field(@$_POST["wp_chatbot_exit_intent_email"]);
					update_option('wp_chatbot_exit_intent_email', stripslashes($wp_chatbot_exit_intent_email));
				}
				

                if(isset( $_POST["wp_chatbot_exit_intent_once"])) {
                    $wp_chatbot_exit_intent_once = qcld_sanitize_field($_POST["wp_chatbot_exit_intent_once"]);
                }else{ $wp_chatbot_exit_intent_once='';}
                update_option('wp_chatbot_exit_intent_once', qcld_sanitize_field($wp_chatbot_exit_intent_once));

                $wp_chatbot_proactive_bg_color = $_POST["wp_chatbot_proactive_bg_color"];
                update_option('wp_chatbot_proactive_bg_color', qcld_sanitize_field($wp_chatbot_proactive_bg_color));

                if(isset( $_POST["enable_wp_chatbot_ret_sound"])) {
                    $enable_wp_chatbot_ret_sound = $_POST["enable_wp_chatbot_ret_sound"];
                }else{ $enable_wp_chatbot_ret_sound='';}
                update_option('enable_wp_chatbot_ret_sound', qcld_sanitize_field($enable_wp_chatbot_ret_sound));

                if(isset( $_POST["enable_wp_chatbot_meta_title"])) {
                    $enable_wp_chatbot_meta_title = $_POST["enable_wp_chatbot_meta_title"];
                }else{ $enable_wp_chatbot_meta_title='';}
                update_option('enable_wp_chatbot_meta_title', qcld_sanitize_field($enable_wp_chatbot_meta_title));

                $qlcd_wp_chatbot_meta_label = $_POST["qlcd_wp_chatbot_meta_label"];
                update_option('qlcd_wp_chatbot_meta_label', ($qlcd_wp_chatbot_meta_label));

                $wp_chatbot_exitintent_show_pages = sanitize_key(@$_POST["wp_chatbot_exitintent_show_pages"]);
                update_option('wp_chatbot_exitintent_show_pages', ($wp_chatbot_exitintent_show_pages));


                if(isset( $_POST["wp_chatbot_exitintent_show_pages_list"])) {
                    $wp_chatbot_exitintent_show_pages_list = $_POST["wp_chatbot_exitintent_show_pages_list"];
                }else{ $wp_chatbot_exitintent_show_pages_list='';}
                update_option('wp_chatbot_exitintent_show_pages_list', serialize($wp_chatbot_exitintent_show_pages_list));
                
                $qcld_exit_pagewise = serialize(@$_POST['qcld_exit_pagewise']);
                update_option('qcld_exit_pagewise', $qcld_exit_pagewise);


                if(isset( $_POST["enable_wp_chatbot_scroll_open"])) {
                    $enable_wp_chatbot_scroll_open = qcld_sanitize_field($_POST["enable_wp_chatbot_scroll_open"]);
                }else{ $enable_wp_chatbot_scroll_open='';}
                update_option('enable_wp_chatbot_scroll_open', qcld_sanitize_field($enable_wp_chatbot_scroll_open));

                $wp_chatbot_scroll_open_msg= qcld_sanitize_field($_POST["wp_chatbot_scroll_open_msg"]);
                update_option('wp_chatbot_scroll_open_msg', stripslashes_deep($wp_chatbot_scroll_open_msg));
                $trigger_url_scroll = isset($_POST["trigger_url_scroll"]) ? qcld_sanitize_field($_POST["trigger_url_scroll"]) : '';
                update_option('wp_chatbot_trigger_url_scroll', stripslashes_deep($trigger_url_scroll));
                $trigger_scroll_url_id = [];
                foreach ( explode(",",$trigger_url_scroll) as $key => $url) {
                    $url_id = url_to_postid($url);
                    array_push($trigger_scroll_url_id,$url_id);
                }
                $trigger_scroll_url_id = implode(',', $trigger_scroll_url_id);
                update_option('trigger_scroll_url_id', stripslashes_deep($trigger_scroll_url_id));

                $wp_chatbot_scroll_open_msg= qcld_sanitize_field($_POST["wp_chatbot_scroll_open_msg"]);
                update_option('wp_chatbot_scroll_open_msg', stripslashes_deep($wp_chatbot_scroll_open_msg));
                
				$wp_chatbot_scroll_open_custom= qcld_sanitize_field($_POST["wp_chatbot_scroll_open_custom"]);
                update_option('wp_chatbot_scroll_open_custom', stripslashes($wp_chatbot_scroll_open_custom));
				
				if( isset( $_POST["wp_chatbot_scroll_open_email"] ) ){
					$wp_chatbot_scroll_open_email= qcld_sanitize_field(@$_POST["wp_chatbot_scroll_open_email"]);
					update_option('wp_chatbot_scroll_open_email', stripslashes($wp_chatbot_scroll_open_email));
				}
				

                $wp_chatbot_scroll_percent= qcld_sanitize_field($_POST["wp_chatbot_scroll_percent"]);
                update_option('wp_chatbot_scroll_percent', stripslashes($wp_chatbot_scroll_percent));

                if(isset( $_POST["wp_chatbot_scroll_once"])) {
                    $wp_chatbot_scroll_once = $_POST["wp_chatbot_scroll_once"];
                }else{ $wp_chatbot_scroll_once='';}
                update_option('wp_chatbot_scroll_once', qcld_sanitize_field($wp_chatbot_scroll_once));


                $qcld_scroll_pagewise = serialize(@$_POST['qcld_scroll_pagewise']);
                update_option('qcld_scroll_pagewise', $qcld_scroll_pagewise);

                $wp_chatbot_scrollintent_show_pages = sanitize_key(@$_POST["wp_chatbot_scrollintent_show_pages"]);
                update_option('wp_chatbot_scrollintent_show_pages', ($wp_chatbot_scrollintent_show_pages));

                if(isset( $_POST["wp_chatbot_scrollintent_show_pages_list"])) {
                    $wp_chatbot_scrollintent_show_pages_list = $_POST["wp_chatbot_scrollintent_show_pages_list"];
                }else{ $wp_chatbot_scrollintent_show_pages_list='';}
                update_option('wp_chatbot_scrollintent_show_pages_list', serialize($wp_chatbot_scrollintent_show_pages_list));

                $wp_chatbot_autointent_show_pages = sanitize_key(@$_POST["wp_chatbot_autointent_show_pages"]);
                update_option('wp_chatbot_autointent_show_pages', ($wp_chatbot_autointent_show_pages));

                $trigger_url_autotime = isset($_POST["trigger_url_autotime"]) ? qcld_sanitize_field($_POST["trigger_url_autotime"]) : '';
                update_option('wp_chatbot_trigger_url_autotime', stripslashes_deep($trigger_url_autotime));
                $trigger_url_auto_id = [];
                foreach ( explode(",",$trigger_url_autotime) as $key => $url) {
                    $url_id = url_to_postid($url);
                    array_push($trigger_url_auto_id,$url_id);
                }
                $trigger_url_auto_id = implode(',', $trigger_url_auto_id);
                update_option('trigger_url_auto_id', stripslashes_deep($trigger_url_auto_id));

                if(isset( $_POST["enable_wp_chatbot_auto_open"])) {
                    $enable_wp_chatbot_auto_open = $_POST["enable_wp_chatbot_auto_open"];
                }else{ $enable_wp_chatbot_auto_open='';}
                update_option('enable_wp_chatbot_auto_open', qcld_sanitize_field($enable_wp_chatbot_auto_open));

                $wp_chatbot_auto_open_msg = qcld_sanitize_field($_POST["wp_chatbot_auto_open_msg"]);
                update_option('wp_chatbot_auto_open_msg', stripslashes_deep($wp_chatbot_auto_open_msg));
				
				$wp_chatbot_auto_open_custom = qcld_sanitize_field($_POST["wp_chatbot_auto_open_custom"]);
                update_option('wp_chatbot_auto_open_custom', stripslashes($wp_chatbot_auto_open_custom));
				
				if( isset( $_POST["wp_chatbot_auto_open_email"] ) ){
					$wp_chatbot_auto_open_email = qcld_sanitize_field(@$_POST["wp_chatbot_auto_open_email"]);
					update_option('wp_chatbot_auto_open_email', stripslashes($wp_chatbot_auto_open_email));
                }
				

                $wp_chatbot_auto_open_time = qcld_sanitize_field($_POST["wp_chatbot_auto_open_time"]);
                update_option('wp_chatbot_auto_open_time', stripslashes($wp_chatbot_auto_open_time));
                
                if(isset( $_POST["wp_chatbot_auto_open_once"])) {
                    $wp_chatbot_auto_open_once = $_POST["wp_chatbot_auto_open_once"];
                }else{ $wp_chatbot_auto_open_once='';}
                update_option('wp_chatbot_auto_open_once', qcld_sanitize_field($wp_chatbot_auto_open_once));

                $qcld_auto_pagewise = serialize(@$_POST['qcld_auto_pagewise']);
                update_option('qcld_auto_pagewise', $qcld_auto_pagewise);

                if(isset( $_POST["wp_chatbot_autointent_show_pages_list"])) {
                    $wp_chatbot_autointent_show_pages_list = $_POST["wp_chatbot_autointent_show_pages_list"];
                }else{ $wp_chatbot_autointent_show_pages_list='';}
                update_option('wp_chatbot_autointent_show_pages_list', serialize($wp_chatbot_autointent_show_pages_list));

                //to complate checkout
                if(isset( $_POST["enable_wp_chatbot_ret_user_show"])) {
                    $enable_wp_chatbot_ret_user_show = $_POST["enable_wp_chatbot_ret_user_show"];
                }else{ $enable_wp_chatbot_ret_user_show='';}
                update_option('enable_wp_chatbot_ret_user_show', qcld_sanitize_field($enable_wp_chatbot_ret_user_show));

                if(isset( $_POST["enable_wp_chatbot_inactive_time_show"])) {
                    $enable_wp_chatbot_inactive_time_show = $_POST["enable_wp_chatbot_inactive_time_show"];
                }else{ $enable_wp_chatbot_inactive_time_show='';}
                update_option('enable_wp_chatbot_inactive_time_show', qcld_sanitize_field($enable_wp_chatbot_inactive_time_show));

				if( isset( $_POST["wp_chatbot_inactive_time"] ) ){
					$wp_chatbot_inactive_time = @$_POST["wp_chatbot_inactive_time"];
					update_option('wp_chatbot_inactive_time', qcld_sanitize_field($wp_chatbot_inactive_time));
				}
                
				if( isset( $_POST["wp_chatbot_checkout_msg"] ) ){
					$wp_chatbot_checkout_msg = @$_POST["wp_chatbot_checkout_msg"];
					update_option('wp_chatbot_checkout_msg', stripslashes_deep($wp_chatbot_checkout_msg));
				}
                



                if(isset( $_POST["wp_chatbot_inactive_once"])) {
                    $wp_chatbot_inactive_once = $_POST["wp_chatbot_inactive_once"];
                }else{ $wp_chatbot_inactive_once='';}
                update_option('wp_chatbot_inactive_once', qcld_sanitize_field($wp_chatbot_inactive_once));

                set_transient( 'bot_clear_cache', 1, DAY_IN_SECONDS );
            }
        }
    }

    /**
     * StopWords option save
     *
     * @return void
     */
    public function stopwords_options_save() {
        if (isset($_POST["qlcd_wp_chatbot_stop_words_name"])) {
            $qlcd_wp_chatbot_stop_words_name = $_POST["qlcd_wp_chatbot_stop_words_name"];
            update_option('qlcd_wp_chatbot_stop_words_name', qcld_sanitize_field($qlcd_wp_chatbot_stop_words_name));
            set_transient( 'bot_clear_cache', 1, DAY_IN_SECONDS );
        }
        if (isset($_POST["qlcd_wp_chatbot_stop_words"])) {
            $qlcd_wp_chatbot_stop_words = $_POST["qlcd_wp_chatbot_stop_words"];
            update_option('qlcd_wp_chatbot_stop_words', qcld_sanitize_field($qlcd_wp_chatbot_stop_words));
            add_action( 'admin_notices', array( $this, 'stopwords_render_notice' ) );
            set_transient( 'bot_clear_cache', 1, DAY_IN_SECONDS );
        }
        
    }

    /**
     * Render Stopwords success message
     *
     * @return void
     */
    public function stopwords_render_notice() {
    ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Stop Words has been saved successfully', 'wpchatbot' ); ?></p>
        </div>
    <?php
    }
    
    /**
     * Delete all options
     *
     * @return void
     */
    public function qcld_wb_chatboot_delete_all_options(){
        
        require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/admin/settings-fields.php' );
        
        foreach( $wpbot_languages as $key ){
            delete_option( $key );
        }

        delete_option('disable_first_msg');
        delete_option('enable_reset_close_button');
        delete_option('qc_auto_hide_floating_button');
        
        delete_option('qlcd_wp_chatbot_close_lan');
        delete_option('qlcd_wp_chatbot_reset_lan');

        
        delete_option('ask_email_wp_greetings');
        delete_option('ask_name_confirmation');
        delete_option('ask_phone_wp_greetings');
        delete_option('disable_phone_validity');
        delete_option('qc_email_subscription_offer');
        delete_option('enable_wp_chatbot_open_initial');
        delete_option('wp_keep_chat_window_open');
        
        delete_option('disable_wp_chatbot_icon_animation');
        delete_option('disable_wp_agent_icon_animation');
        delete_option('enable_extended_header_animation');
        delete_option('always_scroll_to_bottom');
        delete_option('disable_wp_chatbot_history');
        delete_option('disable_wp_chatbot_on_mobile');
        delete_option('disable_auto_focus_message_area');
        
        delete_option('disable_livechat_operator_offline');
        delete_option('disable_wp_chatbot_product_search');
        delete_option('disable_wp_chatbot_catalog');
        delete_option('disable_wp_chatbot_order_status');
        delete_option('disable_wp_chatbot_notification');
        delete_option('disable_wp_chatbot_notification_mobile');
        delete_option('wp_chatbot_exclude_post_list');
        delete_option('wp_chatbot_exclude_pages_list');
        delete_option('wpbot_click_chat_text');
        delete_option('qc_wpbot_menu_order');
        
        delete_option('enable_wp_chatbot_rtl');
        delete_option('enable_wp_chatbot_mobile_full_screen');
        delete_option('chatbot_content_max_height');
        delete_option('enable_wp_chatbot_gdpr_compliance');
        delete_option('wpbot_search_result_new_window');
        delete_option('wpbot_card_response_same_window');
        delete_option('wpbot_search_image_size');

        delete_option('enable_wp_chatbot_disable_producticon');
        delete_option('enable_wp_chatbot_disable_carticon');
        
        
        delete_option( 'wp_chatbot_bot_msg_bg_color');
        delete_option( 'wp_chatbot_bot_msg_text_color');
        delete_option( 'wp_chatbot_user_msg_bg_color');
        delete_option( 'wp_chatbot_user_msg_text_color');
        delete_option( 'wp_chatbot_buttons_bg_color');
        delete_option( 'wp_chatbot_buttons_text_color');

        delete_option( 'wp_chatbot_buttons_bg_color_hover');
        delete_option( 'wp_chatbot_buttons_text_color_hover');
        
        delete_option( 'wp_chatbot_theme_secondary_color');
        delete_option( 'wp_chatbot_theme_primary_color');
        delete_option('wp_chatbot_header_background_color');
        delete_option('wp_chatbot_font_size');
        delete_option('wp_chat_user_font_family');
        delete_option('wp_chat_bot_font_family');
        delete_option('wp_chatbot_bot_font');
        delete_option('wp_chatbot_user_font');

        delete_option( 'enable_wp_chatbot_custom_color');
        delete_option( 'wp_chatbot_text_color');
        delete_option( 'wp_chatbot_floatingiconbg_color');
        delete_option( 'wp_chatbot_link_color');
        delete_option( 'wp_chatbot_link_hover_color');

        delete_option('wpbot_disable_repeatative');
        delete_option('qc_display_for_loggedin_users');
        delete_option('wpbot_preloading_time');
        
        
        delete_option('wpbot_search_result_number');
        delete_option('enable_wp_chatbot_disable_allicon');
        delete_option('enable_wp_chatbot_disable_helpicon');

        delete_option('enable_wp_chatbot_disable_supporticon');
        delete_option('enable_wp_chatbot_disable_chaticon');
        delete_option('qlcd_wp_chatbot_cart_total');
        delete_option('wpbot_gdpr_text');
        delete_option('no_result_attempt_message');
        
        delete_option('no_result_attempt_count');
        delete_option('disable_wp_chatbot_cart_item_number');
        delete_option('disable_wp_chatbot_featured_product');
        delete_option('disable_wp_chatbot_sale_product');
        delete_option('wp_chatbot_open_product_detail');

        delete_option('wp_chatbot_exitintent_show_pages');
        delete_option('wp_chatbot_exitintent_show_pages_list');
        delete_option('wpbot_notification_navigations');
        
        delete_option('qlcd_wp_chatbot_ppp');
        delete_option('wp_chatbot_show_parent_category');
        delete_option('wp_chatbot_show_sub_category');
        delete_option('wp_chatbot_exclude_stock_out_product');
        delete_option('wp_chatbot_show_home_page');
        delete_option('wp_chatbot_show_posts');
        delete_option('wp_chatbot_show_pages');
        delete_option('wp_chatbot_show_pages_list');
        delete_option('wp_chatbot_show_woocommerce');
        delete_option('qlcd_wp_chatbot_stop_words_name');
        delete_option('qlcd_wp_chatbot_stop_words');
        delete_option('qlcd_wp_chatbot_order_user');
        delete_option('wp_chatbot_icon');
        delete_option('wp_chatbot_agent_image');
        delete_option('qcld_wb_chatbot_theme');
        delete_option('qcld_wb_chatbot_change_bg');
        delete_option('wp_chatbot_custom_css');
        delete_option('qlcd_wp_chatbot_host');
        delete_option('qlcd_wp_chatbot_agent');
        delete_option('qlcd_wp_chatbot_yes');
        delete_option('qlcd_wp_chatbot_no');
        delete_option('qlcd_wp_chatbot_no_result');
        delete_option('qlcd_wp_chatbot_did_you_mean');
        delete_option('enable_floating_icon');

        delete_option('enable_chat_bar_position_right');
        delete_option('enable_chat_bar_position_bottom');
        delete_option('disable_chat_bar_right_notification');
        delete_option('disable_chat_bar_bottom_notification');
        
        delete_option('qlcd_wp_email_subscription_success');
        delete_option('qlcd_wp_email_already_subscribe');
        delete_option('qlcd_wp_email_subscription_offer_subject');    
        delete_option('qlcd_wp_email_subscription_offer');    
        delete_option('qlcd_wp_chatbot_or');
        delete_option('qlcd_wp_custon_intent');
        delete_option('qlcd_wp_custon_intent_label');
        delete_option('qlcd_wp_custon_intent_checkbox');

        delete_option('qlcd_wp_custon_menu');
        delete_option('qlcd_wp_custon_menu_link');
        delete_option('qlcd_wp_custon_menu_checkbox');

        
        delete_option('qlcd_wp_chatbot_sorry');
        delete_option('qlcd_wp_chatbot_hello');
        delete_option('qlcd_wp_chatbot_chat_with_us');    
        delete_option('qlcd_wp_chatbot_help');    
        delete_option('qlcd_wp_chatbot_support');    
        delete_option('qlcd_wp_chatbot_agent_join');
        delete_option('qlcd_wp_chatbot_welcome');
        delete_option('qlcd_wp_chatbot_back_to_start');
        delete_option('qlcd_wp_chatbot_hi_there');
        delete_option('qlcd_wp_chatbot_welcome_back');
        delete_option('qlcd_wp_chatbot_asking_name');
        delete_option('qlcd_wp_chatbot_asking_emailaddress');
        delete_option('qlcd_wp_chatbot_got_email');
        delete_option('qlcd_wp_chatbot_email_ignore');
        delete_option('qlcd_wp_chatbot_asking_phone_gt');
        delete_option('qlcd_wp_chatbot_got_phone');
        delete_option('qlcd_wp_chatbot_phone_ignore');    
        delete_option('qlcd_wp_i_understand');    
        delete_option('We have got your email. Thank you!');
        delete_option('qlcd_wp_chatbot_name_greeting');
        delete_option('qlcd_wp_chatbot_i_am');
        delete_option('qlcd_wp_chatbot_wildcard_msg');
        delete_option('qlcd_wp_chatbot_empty_filter_msg');
        delete_option('do_you_want_to_subscribe');
        delete_option('qlcd_wp_chatbot_ext_not_allowed');
        delete_option('qlcd_wp_chatbot_file_size_excd');
        delete_option('qlcd_wp_chatbot_file_upload_fail');
        delete_option('qlcd_wp_chatbot_file_upload_succ');
        delete_option('qlcd_wp_chatbot_good_bye_text');
        delete_option('qlcd_wp_chatbot_transcript_emailed');
        delete_option('do_you_want_to_unsubscribe');
        delete_option('we_do_not_have_your_email');
        delete_option('you_have_successfully_unsubscribe');
        delete_option('qlcd_wp_chatbot_wildcard_product');
        delete_option('qlcd_wp_chatbot_wildcard_catalog');
        delete_option('qlcd_wp_chatbot_featured_products');
        delete_option('qlcd_wp_chatbot_sale_products');
        delete_option('qlcd_wp_chatbot_wildcard_support');
        delete_option('qlcd_wp_chatbot_messenger_label');
        delete_option('qlcd_wp_chatbot_product_success');
        delete_option('qlcd_wp_chatbot_product_fail');
        delete_option('qlcd_wp_chatbot_product_asking');
        delete_option('qlcd_wp_chatbot_product_suggest');
        delete_option('qlcd_wp_chatbot_product_infinite');
        delete_option('qlcd_wp_chatbot_load_more');
        delete_option('qlcd_wp_chatbot_wildcard_order');
        delete_option('qlcd_wp_chatbot_order_welcome');
        delete_option('qlcd_wp_chatbot_order_username_asking');
        delete_option('qlcd_wp_chatbot_order_username_password');
        delete_option('qlcd_wp_chatbot_support_welcome');
        delete_option('qlcd_wp_chatbot_go_back_tooltip');
        delete_option('qlcd_wp_chatbot_support_email');
        delete_option('qlcd_wp_chatbot_asking_email');
        delete_option('qlcd_wp_chatbot_valid_phone_number');
        delete_option('qlcd_wp_chatbot_search_keyword');
        delete_option('qlcd_wp_chatbot_asking_msg');
        delete_option('qlcd_wp_chatbot_admin_email');
        delete_option('qlcd_wp_chatbot_from_email');
        delete_option('qlcd_wp_chatbot_from_name');
        delete_option('qlcd_wp_chatbot_reply_to_email');
        delete_option('qlcd_wp_chatbot_email_sub');
        delete_option('qlcd_wp_chatbot_callback_email_sub');
        delete_option('qlcd_wp_chatbot_we_have_found');
        delete_option('qlcd_wp_chatbot_email_sent');
        delete_option('qlcd_wp_site_search');
        delete_option('qlcd_wp_livechat');
        delete_option('qlcd_wp_email_subscription');
        delete_option('qlcd_wp_str_category');
        delete_option('qlcd_wp_voice_message');
        delete_option('qlcd_open_ticket_label');
        delete_option('qlcd_wp_send_us_email');
        delete_option('qlcd_wp_good_bye');
        delete_option('qlcd_wp_leave_feedback');
        delete_option('qlcd_wp_chatbot_support_phone');
        delete_option('qlcd_wp_chatbot_asking_phone');
        delete_option('qlcd_wp_chatbot_thank_for_phone');
        delete_option('qlcd_wp_chatbot_sys_key_help');
        delete_option('qlcd_wp_chatbot_sys_key_product');
        delete_option('qlcd_wp_chatbot_sys_key_catalog');
        delete_option('qlcd_wp_chatbot_sys_key_order');
        delete_option('qlcd_wp_chatbot_sys_key_support');
        delete_option('qlcd_wp_chatbot_sys_key_reset');
        delete_option('qlcd_wp_chatbot_sys_goodbye_keywords');

        
        delete_option('qlcd_wp_chatbot_sys_key_livechat');
        delete_option('qlcd_wp_chatbot_order_username_not_exist');
        delete_option('qlcd_wp_chatbot_order_username_thanks');
        delete_option('qlcd_wp_chatbot_order_password_incorrect');
        delete_option('qlcd_wp_chatbot_order_not_found');
        delete_option('qlcd_wp_chatbot_order_found');
        delete_option('qlcd_wp_chatbot_order_email_support');
        delete_option('qlcd_wp_chatbot_support_option_again');
        delete_option('qlcd_wp_chatbot_invalid_email');
        delete_option('qlcd_wp_chatbot_shopping_cart');
        delete_option('qlcd_wp_chatbot_add_to_cart');
        delete_option('qlcd_wp_chatbot_cart_link');
        delete_option('qlcd_wp_chatbot_checkout_link');
        delete_option('qlcd_wp_chatbot_cart_welcome');
        delete_option('qlcd_wp_chatbot_featured_product_welcome');
        delete_option('qlcd_wp_chatbot_viewed_product_welcome');
        delete_option('qlcd_wp_chatbot_latest_product_welcome');
        delete_option('qlcd_wp_chatbot_cart_title');
        delete_option('qlcd_wp_chatbot_cart_quantity');
        delete_option('qlcd_wp_chatbot_cart_price');
        delete_option('qlcd_wp_chatbot_no_cart_items');
        delete_option('qlcd_wp_chatbot_cart_updating');
        delete_option('qlcd_wp_chatbot_cart_removing');
        delete_option('qlcd_wp_chatbot_email_fail');
        delete_option('support_query');
        delete_option('support_ans');
        delete_option('qlcd_wp_chatbot_notification_interval');
        delete_option('qlcd_wp_chatbot_notifications');
        delete_option('qcld_exit_pagewise');
        
        delete_option('qlcd_wp_chatbot_notifications_intent');
        
        delete_option( 'qlcd_wp_chatbot_search_option');
        delete_option( 'wp_chatbot_index_count');
        delete_option( 'wp_chatbot_app_pages');
        //messenger option
        delete_option( 'enable_wp_chatbot_messenger');
        delete_option( 'enable_wp_chatbot_messenger_floating_icon');
        delete_option( 'qlcd_wp_chatbot_fb_app_id');
        delete_option( 'qlcd_wp_chatbot_fb_page_id');
        delete_option( 'qlcd_wp_chatbot_fb_color');
        delete_option( 'qlcd_wp_chatbot_fb_in_msg');
        delete_option( 'qlcd_wp_chatbot_fb_out_msg');
        //skype option
        delete_option( 'enable_wp_chatbot_skype_floating_icon');
        delete_option( 'enable_wp_chatbot_skype_id');
        //whats app
        delete_option( 'enable_wp_chatbot_whats');
        delete_option( 'qlcd_wp_chatbot_whats_label');
        delete_option( 'enable_wp_chatbot_floating_whats');
        delete_option( 'qlcd_wp_chatbot_whats_num');
        // Viber
        delete_option( 'enable_wp_chatbot_floating_viber');
        delete_option( 'qlcd_wp_chatbot_viber_acc');
        //Integration others
        delete_option( 'enable_wp_chatbot_floating_phone');
        delete_option( 'enable_wp_chatbot_floating_livechat');
        delete_option( 'enable_wp_custom_intent_livechat_button');
        delete_option( 'qlcd_wp_chatbot_phone');
        delete_option( 'qlcd_wp_chatbot_livechatlink');
        delete_option( 'qlcd_wp_livechat_button_label');
        delete_option( 'wp_custom_icon_livechat');
        delete_option( 'enable_wp_chatbot_voice_message');
        delete_option( 'wp_custom_help_icon');
        delete_option( 'wp_custom_client_icon');
        delete_option( 'wp_custom_support_icon');
        delete_option( 'wp_custom_chat_icon');
        delete_option( 'wp_custom_typing_icon');
        
        delete_option( 'enable_wp_chatbot_floating_link');
        delete_option( 'qlcd_wp_chatbot_weblink');
        //Re Targetting
        delete_option( 'qlcd_wp_chatbot_ret_greet');
        delete_option( 'enable_wp_chatbot_exit_intent');
        delete_option( 'wp_chatbot_exit_intent_msg');
        delete_option( 'wp_chatbot_exit_intent_custom');
        delete_option( 'wp_chatbot_exit_intent_bargain_pro_single_page');
        
        delete_option( 'wp_chatbot_exit_intent_email');
        delete_option( 'wp_chatbot_exit_intent_once');

        delete_option( 'enable_wp_chatbot_scroll_open');
        delete_option( 'wp_chatbot_scroll_open_msg');
        delete_option( 'wp_chatbot_exit_intent_bargain_msg');
        
        delete_option( 'wp_chatbot_scroll_open_custom');
        delete_option( 'wp_chatbot_scroll_open_email');
        delete_option( 'wp_chatbot_scroll_percent');
        delete_option( 'wp_chatbot_scroll_once');

        delete_option( 'enable_wp_chatbot_auto_open');
        delete_option( 'enable_wp_chatbot_ret_sound');
        delete_option( 'enable_wp_chatbot_sound_initial');
        delete_option( 'enable_wp_chatbot_sound_botmessage');
        delete_option( 'disable_wp_chatbot_feedback');
        delete_option( 'disable_wp_leave_feedback');
        delete_option( 'disable_wp_chatbot_site_search');
        delete_option( 'disable_wp_chatbot_faq');
        delete_option( 'disable_email_subscription');
        delete_option( 'disable_good_bye');
        delete_option( 'disable_voice_message');
        delete_option( 'disable_str_categories');
        delete_option( 'disable_open_ticket');
        delete_option( 'disable_livechat');
        delete_option( 'disable_livechat_opration_icon');
        delete_option( 'qlcd_wp_chatbot_feedback_label');
        delete_option( 'enable_wp_chatbot_meta_title');
        delete_option( 'qlcd_wp_chatbot_meta_label');
        delete_option( 'wp_chatbot_auto_open_msg');
        delete_option( 'wp_chatbot_auto_open_custom');
        delete_option( 'wp_chatbot_auto_open_email');
        delete_option( 'wp_chatbot_auto_open_time');
        delete_option( 'wp_chatbot_auto_open_once');
        delete_option( 'wp_chatbot_inactive_once');
        delete_option( 'wp_chatbot_proactive_bg_color');
        delete_option( 'qlcd_wp_chatbot_phone_sent');
        delete_option( 'qlcd_wp_chatbot_phone_fail');
        delete_option( 'qlcd_wp_chatbot_skip_conversation');
        delete_option( 'qlcd_wp_chatbot_load_more_search');
        delete_option( 'qlcd_wp_chatbot_loading_search');
        delete_option( 'qlcd_wp_chatbot_conversation_details');
        delete_option( 'disable_wp_chatbot_call_gen');
        delete_option( 'disable_wp_chatbot_call_sup');
        delete_option( 'disable_youtube_parse');

        delete_option( 'enable_wp_chatbot_ret_user_show');
        delete_option( 'enable_wp_chatbot_inactive_time_show');
        delete_option( 'wp_chatbot_inactive_time');
        delete_option( 'wp_chatbot_checkout_msg');
        delete_option( 'qlcd_wp_chatbot_shopper_demo_name');
        delete_option( 'qlcd_wp_chatbot_shopper_call_you');
        delete_option( 'qlcd_wp_chatbot_is_typing');
        delete_option( 'qlcd_wp_chatbot_send_a_msg');
        delete_option( 'qlcd_wp_chatbot_choose_option');
        delete_option( 'qlcd_wp_chatbot_viewed_products');
        delete_option( 'qlcd_wp_chatbot_help_welcome');
        delete_option( 'qlcd_wp_chatbot_tag_search_intent');
        delete_option( 'qlcd_wp_chatbot_help_msg');
        delete_option( 'qlcd_wp_chatbot_reset');
        delete_option( 'enable_wp_chatbot_opening_hour');
        delete_option( 'wpwbot_hours');
        delete_option( 'enable_wp_chatbot_dailogflow');
        delete_option( 'wpbot_trigger_intent');
        
        
        delete_option('trigger_url_exit');
        delete_option('trigger_url_exit_id');
        delete_option('trigger_url_scroll');
        delete_option('trigger_scroll_url_id');
        delete_option('trigger_url_autotime');
        delete_option('trigger_url_auto_id');

        delete_option( 'wpbot_trigger_intent_loggged_in');
        delete_option( 'enable_authentication_webhook');
        delete_option( 'qcld_auth_username');
        delete_option( 'qcld_auth_password');

        delete_option( 'qlcd_wp_chatbot_dialogflow_client_token');
        delete_option( 'qlcd_wp_chatbot_dialogflow_project_id');
        delete_option( 'qlcd_wp_chatbot_dialogflow_cx');
        delete_option( 'wp_chatbot_df_api');    
        delete_option( 'qlcd_wp_chatbot_dialogflow_project_key');
        delete_option( '$qlcd_wp_chatbot_dialogflow_defualt_reply');
        delete_option( '$qlcd_wp_chatbot_dialogflow_agent_language');

        
        Qcld_WPBot_Install::install();
        $html='Reset all options to default successfully.';
        wp_send_json($html);
    }

    /**
     * Language Center option save
     *
     * @return void
     */
    public function language_options_save() {
        if ((empty($_GET["page"])) || ($_GET['page'] !== 'language-center')) {
            return;
        }
        if (isset($_POST['_wpnonce']) && $_POST['_wpnonce']) {
            wp_verify_nonce($_POST['_wpnonce'], 'wp_chatbot');
            // Check if the form is submitted or not
            if (isset($_POST['submit'])) {

                $qlcd_wp_chatbot_host = str_replace('\\', '', $_POST["qlcd_wp_chatbot_host"]);
                update_option('qlcd_wp_chatbot_host', qcld_sanitize_field($qlcd_wp_chatbot_host));

                $qlcd_wp_chatbot_agent = @$_POST["qlcd_wp_chatbot_agent"];
                update_option('qlcd_wp_chatbot_agent', qcld_sanitize_field($qlcd_wp_chatbot_agent));

                $qlcd_wp_chatbot_shopper_demo_name = @$_POST["qlcd_wp_chatbot_shopper_demo_name"];
                update_option('qlcd_wp_chatbot_shopper_demo_name', qcld_sanitize_field($qlcd_wp_chatbot_shopper_demo_name));

                $qlcd_wp_chatbot_shopper_call_you = @$_POST["qlcd_wp_chatbot_shopper_call_you"];
                update_option('qlcd_wp_chatbot_shopper_call_you', qcld_sanitize_field($qlcd_wp_chatbot_shopper_call_you));
                
                $qlcd_wp_chatbot_yes = @$_POST["qlcd_wp_chatbot_yes"];
                update_option('qlcd_wp_chatbot_yes', qcld_sanitize_field($qlcd_wp_chatbot_yes));

                $qlcd_wp_chatbot_no = $_POST["qlcd_wp_chatbot_no"];
                update_option('qlcd_wp_chatbot_no', qcld_sanitize_field($qlcd_wp_chatbot_no));
                
                $qlcd_wp_chatbot_or = $_POST["qlcd_wp_chatbot_or"];
                update_option('qlcd_wp_chatbot_or', qcld_sanitize_field($qlcd_wp_chatbot_or));

                $qlcd_wp_chatbot_sorry = $_POST["qlcd_wp_chatbot_sorry"];
                update_option('qlcd_wp_chatbot_sorry', qcld_sanitize_field($qlcd_wp_chatbot_sorry));

                $qlcd_wp_chatbot_hello = $_POST["qlcd_wp_chatbot_hello"];
                update_option('qlcd_wp_chatbot_hello', qcld_sanitize_field($qlcd_wp_chatbot_hello));

                $qlcd_wp_chatbot_chat_with_us = $_POST["qlcd_wp_chatbot_chat_with_us"];
                update_option('qlcd_wp_chatbot_chat_with_us', qcld_sanitize_field($qlcd_wp_chatbot_chat_with_us));
                
                $qlcd_wp_chatbot_help = $_POST["qlcd_wp_chatbot_help"];
                update_option('qlcd_wp_chatbot_help', qcld_sanitize_field($qlcd_wp_chatbot_help));
                
                $qlcd_wp_chatbot_support = $_POST["qlcd_wp_chatbot_support"];
                update_option('qlcd_wp_chatbot_support', qcld_sanitize_field($qlcd_wp_chatbot_support));

                $qlcd_wp_chatbot_agent_join = $_POST["qlcd_wp_chatbot_agent_join"];
                update_option('qlcd_wp_chatbot_agent_join', serialize($qlcd_wp_chatbot_agent_join));
                //Greeting.
                $qlcd_wp_chatbot_welcome = $_POST["qlcd_wp_chatbot_welcome"];
                update_option('qlcd_wp_chatbot_welcome', serialize($qlcd_wp_chatbot_welcome));

                $qlcd_wp_chatbot_back_to_start = $_POST["qlcd_wp_chatbot_back_to_start"];
                update_option('qlcd_wp_chatbot_back_to_start', serialize($qlcd_wp_chatbot_back_to_start));

                $qlcd_wp_chatbot_welcome_back = $_POST["qlcd_wp_chatbot_welcome_back"];
                update_option('qlcd_wp_chatbot_welcome_back', serialize($qlcd_wp_chatbot_welcome_back));

                $qlcd_wp_chatbot_hi_there = $_POST["qlcd_wp_chatbot_hi_there"];
                update_option('qlcd_wp_chatbot_hi_there', serialize($qlcd_wp_chatbot_hi_there));
                
                $qlcd_wp_chatbot_asking_name = $_POST["qlcd_wp_chatbot_asking_name"];
                update_option('qlcd_wp_chatbot_asking_name', serialize($qlcd_wp_chatbot_asking_name));
				
				$qlcd_wp_chatbot_asking_emailaddress = $_POST["qlcd_wp_chatbot_asking_emailaddress"];
                update_option('qlcd_wp_chatbot_asking_emailaddress', serialize($qlcd_wp_chatbot_asking_emailaddress));

				$qlcd_wp_chatbot_got_email = $_POST["qlcd_wp_chatbot_got_email"];
                update_option('qlcd_wp_chatbot_got_email', serialize($qlcd_wp_chatbot_got_email));

                $qlcd_wp_chatbot_email_ignore = $_POST["qlcd_wp_chatbot_email_ignore"];
                update_option('qlcd_wp_chatbot_email_ignore', serialize($qlcd_wp_chatbot_email_ignore));


                $qlcd_wp_chatbot_asking_phone_gt = $_POST["qlcd_wp_chatbot_asking_phone_gt"];
                update_option('qlcd_wp_chatbot_asking_phone_gt', serialize($qlcd_wp_chatbot_asking_phone_gt));

				$qlcd_wp_chatbot_got_phone = $_POST["qlcd_wp_chatbot_got_phone"];
                update_option('qlcd_wp_chatbot_got_phone', serialize($qlcd_wp_chatbot_got_phone));
				
				$qlcd_wp_chatbot_phone_ignore = $_POST["qlcd_wp_chatbot_phone_ignore"];
                update_option('qlcd_wp_chatbot_phone_ignore', serialize($qlcd_wp_chatbot_phone_ignore));

                $qlcd_wp_i_understand = $_POST["qlcd_wp_i_understand"];
                update_option('qlcd_wp_i_understand', serialize($qlcd_wp_i_understand));

                $qlcd_wp_chatbot_i_am = $_POST["qlcd_wp_chatbot_i_am"];
                update_option('qlcd_wp_chatbot_i_am', serialize($qlcd_wp_chatbot_i_am));

                $qlcd_wp_chatbot_name_greeting = $_POST["qlcd_wp_chatbot_name_greeting"];
                update_option('qlcd_wp_chatbot_name_greeting', serialize($qlcd_wp_chatbot_name_greeting));

                $qlcd_wp_chatbot_wildcard_msg = $_POST["qlcd_wp_chatbot_wildcard_msg"];
                update_option('qlcd_wp_chatbot_wildcard_msg', serialize($qlcd_wp_chatbot_wildcard_msg));

                $qlcd_wp_chatbot_empty_filter_msg = $_POST["qlcd_wp_chatbot_empty_filter_msg"];
                update_option('qlcd_wp_chatbot_empty_filter_msg', serialize($qlcd_wp_chatbot_empty_filter_msg));

                $qlcd_wp_chatbot_is_typing = $_POST["qlcd_wp_chatbot_is_typing"];
                update_option('qlcd_wp_chatbot_is_typing', serialize($qlcd_wp_chatbot_is_typing));

                $qlcd_wp_chatbot_send_a_msg= $_POST["qlcd_wp_chatbot_send_a_msg"];
                update_option('qlcd_wp_chatbot_send_a_msg', serialize($qlcd_wp_chatbot_send_a_msg));

                $qlcd_wp_chatbot_choose_option= $_POST["qlcd_wp_chatbot_choose_option"];
                update_option('qlcd_wp_chatbot_choose_option', serialize($qlcd_wp_chatbot_choose_option));

                $qlcd_wp_chatbot_email_sub = $_POST["qlcd_wp_chatbot_email_sub"];
                update_option('qlcd_wp_chatbot_email_sub', qcld_sanitize_field($qlcd_wp_chatbot_email_sub));

                $qlcd_wp_chatbot_callback_email_sub = $_POST["qlcd_wp_chatbot_callback_email_sub"];
                update_option('qlcd_wp_chatbot_callback_email_sub', qcld_sanitize_field($qlcd_wp_chatbot_callback_email_sub));

                $qlcd_wp_chatbot_we_have_found = $_POST["qlcd_wp_chatbot_we_have_found"];
                update_option('qlcd_wp_chatbot_we_have_found', qcld_sanitize_field($qlcd_wp_chatbot_we_have_found));

                $qlcd_wp_chatbot_no_result = $_POST["qlcd_wp_chatbot_no_result"];
                update_option('qlcd_wp_chatbot_no_result', serialize($qlcd_wp_chatbot_no_result));

                $qlcd_wp_chatbot_did_you_mean = $_POST["qlcd_wp_chatbot_did_you_mean"];
                update_option('qlcd_wp_chatbot_did_you_mean', serialize($qlcd_wp_chatbot_did_you_mean));

                $qlcd_wp_chatbot_email_sent = $_POST["qlcd_wp_chatbot_email_sent"];
                update_option('qlcd_wp_chatbot_email_sent', qcld_sanitize_field($qlcd_wp_chatbot_email_sent));

                //livechat option save
                if( qcld_wpbot_is_active_livechat() ){
                    if(isset($_POST["wbca_lg_ochat"])){
                        $wbca_lg_ochat = $_POST["wbca_lg_ochat"];
                        update_option('wbca_lg_ochat', qcld_sanitize_field($wbca_lg_ochat));
                    }
                    if(isset($_POST["wbca_lg_online"])){
                        $wbca_lg_online = $_POST["wbca_lg_online"];
                        update_option('wbca_lg_online', qcld_sanitize_field($wbca_lg_online));
                    }
                    if(isset($_POST["wbca_lg_offline"])){
                        $wbca_lg_offline = $_POST["wbca_lg_offline"];
                        update_option('wbca_lg_offline', qcld_sanitize_field($wbca_lg_offline));

                    }
                    if(isset($_POST["wbca_lg_we_are_here"])){
                        $wbca_lg_we_are_here = $_POST["wbca_lg_we_are_here"];
                        update_option('wbca_lg_we_are_here', qcld_sanitize_field($wbca_lg_we_are_here));
                    }
                    if(isset($_POST["wbca_lg_chat"])){
                        $wbca_lg_chat = $_POST["wbca_lg_chat"];
                        update_option('wbca_lg_chat', qcld_sanitize_field($wbca_lg_chat));
                    }
                    if(isset($_POST["wbca_lg_sendq"])){
                        $wbca_lg_sendq = $_POST["wbca_lg_sendq"];
                        update_option('wbca_lg_sendq', qcld_sanitize_field($wbca_lg_sendq));
                    }
                    if(isset($_POST["wbca_lg_subject"])){
                        $wbca_lg_subject = $_POST["wbca_lg_subject"];
                        update_option('wbca_lg_subject', qcld_sanitize_field($wbca_lg_subject));
                    }
                    if(isset($_POST["wbca_lg_msg"])){
                        $wbca_lg_msg = $_POST["wbca_lg_msg"];
                        update_option('wbca_lg_msg', qcld_sanitize_field($wbca_lg_msg));
                    }
                    if(isset($_POST["wbca_lg_send"])){
                        $wbca_lg_send = $_POST["wbca_lg_send"];
                        update_option('wbca_lg_send', qcld_sanitize_field($wbca_lg_send));
                    }
                    if(isset($_POST["wbca_lg_fname"])){
                        $wbca_lg_fname = $_POST["wbca_lg_fname"];
                        update_option('wbca_lg_fname', qcld_sanitize_field($wbca_lg_fname));
                    }
                    if(isset($_POST["wbca_lg_email"])){
                        $wbca_lg_email = $_POST["wbca_lg_email"];
                        update_option('wbca_lg_email', qcld_sanitize_field($wbca_lg_email));
                    }
                    if(isset($_POST["wbca_msg_success"])){
                        $wbca_msg_success = $_POST["wbca_msg_success"];
                        update_option('wbca_msg_success', qcld_sanitize_field($wbca_msg_success));
                    }
                    if(isset($_POST["wbca_msg_failed"])){
                        $wbca_msg_failed = $_POST["wbca_msg_failed"];
                        update_option('wbca_msg_failed', qcld_sanitize_field($wbca_msg_failed));
                    }
                    if(isset($_POST["wbca_lg_chat_type"])){
                        $wbca_lg_chat_type = $_POST["wbca_lg_chat_type"];
                        update_option('wbca_lg_chat_type', qcld_sanitize_field($wbca_lg_chat_type));
                    }
                    if(isset($_POST["wbca_lg_chat_welcome"])){
                        $wbca_lg_chat_welcome = $_POST["wbca_lg_chat_welcome"];
                        update_option('wbca_lg_chat_welcome', qcld_sanitize_field($wbca_lg_chat_welcome));
                    }
                    if(isset($_POST["wbca_lg_please_wait"])){
                        $wbca_lg_please_wait = $_POST["wbca_lg_please_wait"];
                        update_option('wbca_lg_please_wait', qcld_sanitize_field($wbca_lg_please_wait));
                    }
                    if(isset($_POST["wbca_lg_operator_offline"])){
                        $wbca_lg_operator_offline = $_POST["wbca_lg_operator_offline"];
                        update_option('wbca_lg_operator_offline', qcld_sanitize_field($wbca_lg_operator_offline));
                    }
                }
                
                


                $qlcd_wp_chatbot_email_fail = stripslashes_deep($_POST["qlcd_wp_chatbot_email_fail"]);
                update_option('qlcd_wp_chatbot_email_fail', qcld_sanitize_field($qlcd_wp_chatbot_email_fail));

                $qlcd_wp_chatbot_phone_sent = $_POST["qlcd_wp_chatbot_phone_sent"];
                update_option('qlcd_wp_chatbot_phone_sent', qcld_sanitize_field($qlcd_wp_chatbot_phone_sent));

                $qlcd_wp_chatbot_phone_fail = $_POST["qlcd_wp_chatbot_phone_fail"];
                update_option('qlcd_wp_chatbot_phone_fail', qcld_sanitize_field($qlcd_wp_chatbot_phone_fail));
				
				$qlcd_wp_chatbot_skip_conversation = $_POST["qlcd_wp_chatbot_skip_conversation"];
                update_option('qlcd_wp_chatbot_skip_conversation', qcld_sanitize_field($qlcd_wp_chatbot_skip_conversation));
				
				$qlcd_wp_chatbot_load_more_search = $_POST["qlcd_wp_chatbot_load_more_search"];
                update_option('qlcd_wp_chatbot_load_more_search', qcld_sanitize_field($qlcd_wp_chatbot_load_more_search));

                $qlcd_wp_chatbot_loading_search = $_POST["qlcd_wp_chatbot_loading_search"];
                update_option('qlcd_wp_chatbot_loading_search', qcld_sanitize_field($qlcd_wp_chatbot_loading_search));

                $qlcd_wp_chatbot_conversation_details = $_POST["qlcd_wp_chatbot_conversation_details"];
                update_option('qlcd_wp_chatbot_conversation_details', qcld_sanitize_field($qlcd_wp_chatbot_conversation_details));

                $qlcd_wp_chatbot_go_back_tooltip = $_POST["qlcd_wp_chatbot_go_back_tooltip"];
                update_option('qlcd_wp_chatbot_go_back_tooltip', serialize($qlcd_wp_chatbot_go_back_tooltip));

                $qlcd_wp_chatbot_support_email = $_POST["qlcd_wp_chatbot_support_email"];
                update_option('qlcd_wp_chatbot_support_email', serialize($qlcd_wp_chatbot_support_email));

                $qlcd_wp_chatbot_asking_email = $_POST["qlcd_wp_chatbot_asking_email"];
                update_option('qlcd_wp_chatbot_asking_email', serialize($qlcd_wp_chatbot_asking_email));

                $qlcd_wp_chatbot_valid_phone_number = $_POST["qlcd_wp_chatbot_valid_phone_number"];
                update_option('qlcd_wp_chatbot_valid_phone_number', serialize($qlcd_wp_chatbot_valid_phone_number));
				
				$qlcd_wp_chatbot_search_keyword = $_POST["qlcd_wp_chatbot_search_keyword"];
                update_option('qlcd_wp_chatbot_search_keyword', serialize($qlcd_wp_chatbot_search_keyword));

                $qlcd_wp_chatbot_invalid_email = $_POST["qlcd_wp_chatbot_invalid_email"];
                update_option('qlcd_wp_chatbot_invalid_email', serialize($qlcd_wp_chatbot_invalid_email));

                $qlcd_wp_chatbot_asking_msg = $_POST["qlcd_wp_chatbot_asking_msg"];
                update_option('qlcd_wp_chatbot_asking_msg', serialize($qlcd_wp_chatbot_asking_msg));

                $qlcd_wp_chatbot_feedback_label = $_POST["qlcd_wp_chatbot_feedback_label"];
                update_option('qlcd_wp_chatbot_feedback_label', serialize($qlcd_wp_chatbot_feedback_label));

                $qlcd_wp_chatbot_asking_phone= $_POST["qlcd_wp_chatbot_asking_phone"];
                update_option('qlcd_wp_chatbot_asking_phone', serialize($qlcd_wp_chatbot_asking_phone));

                $qlcd_wp_chatbot_thank_for_phone= $_POST["qlcd_wp_chatbot_thank_for_phone"];
                update_option('qlcd_wp_chatbot_thank_for_phone', serialize($qlcd_wp_chatbot_thank_for_phone));

                $qlcd_wp_chatbot_support_option_again = $_POST["qlcd_wp_chatbot_support_option_again"];
                update_option('qlcd_wp_chatbot_support_option_again', serialize($qlcd_wp_chatbot_support_option_again));

                $qlcd_wp_chatbot_support_welcome = $_POST["qlcd_wp_chatbot_support_welcome"];
                update_option('qlcd_wp_chatbot_support_welcome', serialize($qlcd_wp_chatbot_support_welcome));

                if(isset($_POST["qlcd_wp_chatbot_file_upload_succ"])){
					$qlcd_wp_chatbot_file_upload_succ = $_POST["qlcd_wp_chatbot_file_upload_succ"];
					update_option('qlcd_wp_chatbot_file_upload_succ', ($qlcd_wp_chatbot_file_upload_succ));
                }
                if(isset($_POST["qlcd_wp_chatbot_good_bye_text"])){
					$qlcd_wp_chatbot_good_bye_text = $_POST["qlcd_wp_chatbot_good_bye_text"];
					update_option('qlcd_wp_chatbot_good_bye_text', ($qlcd_wp_chatbot_good_bye_text));
                }
                if(isset($_POST["qlcd_wp_chatbot_transcript_emailed"])){
					$qlcd_wp_chatbot_transcript_emailed = $_POST["qlcd_wp_chatbot_transcript_emailed"];
					update_option('qlcd_wp_chatbot_transcript_emailed', ($qlcd_wp_chatbot_transcript_emailed));
                }

                
                
                
                if(isset($_POST["qlcd_wp_chatbot_file_upload_fail"])){
					$qlcd_wp_chatbot_file_upload_fail = $_POST["qlcd_wp_chatbot_file_upload_fail"];
					update_option('qlcd_wp_chatbot_file_upload_fail', ($qlcd_wp_chatbot_file_upload_fail));
				}
				
				if(isset($_POST["qlcd_wp_chatbot_file_size_excd"])){
					$qlcd_wp_chatbot_file_size_excd = $_POST["qlcd_wp_chatbot_file_size_excd"];
					update_option('qlcd_wp_chatbot_file_size_excd', ($qlcd_wp_chatbot_file_size_excd));
				}
				
				if(isset($_POST["qlcd_wp_chatbot_ext_not_allowed"])){
					$qlcd_wp_chatbot_ext_not_allowed = $_POST["qlcd_wp_chatbot_ext_not_allowed"];
					update_option('qlcd_wp_chatbot_ext_not_allowed', ($qlcd_wp_chatbot_ext_not_allowed));
                }
                
                $do_you_want_to_subscribe = $_POST["do_you_want_to_subscribe"];
                update_option('do_you_want_to_subscribe', serialize($do_you_want_to_subscribe));

                $qlcd_wp_email_subscription_success = $_POST["qlcd_wp_email_subscription_success"];
                update_option('qlcd_wp_email_subscription_success', serialize($qlcd_wp_email_subscription_success));

                $qlcd_wp_email_already_subscribe = $_POST["qlcd_wp_email_already_subscribe"];
                update_option('qlcd_wp_email_already_subscribe', serialize($qlcd_wp_email_already_subscribe));

                $qlcd_wp_email_subscription_offer_subject = $_POST["qlcd_wp_email_subscription_offer_subject"];
                update_option('qlcd_wp_email_subscription_offer_subject', serialize($qlcd_wp_email_subscription_offer_subject));

                $qlcd_wp_email_subscription_offer = $_POST["qlcd_wp_email_subscription_offer"];
                update_option('qlcd_wp_email_subscription_offer', serialize($qlcd_wp_email_subscription_offer));

                $qlcd_wp_email_unsubscription = stripslashes_deep($_POST["qlcd_wp_email_unsubscription"]);
                update_option('qlcd_wp_email_unsubscription', qcld_sanitize_field($qlcd_wp_email_unsubscription));

                $do_you_want_to_unsubscribe = $_POST["do_you_want_to_unsubscribe"];
                update_option('do_you_want_to_unsubscribe', serialize($do_you_want_to_unsubscribe));

                $you_have_successfully_unsubscribe = $_POST["you_have_successfully_unsubscribe"];
                update_option('you_have_successfully_unsubscribe', serialize($you_have_successfully_unsubscribe));

                $we_do_not_have_your_email = $_POST["we_do_not_have_your_email"];
                update_option('we_do_not_have_your_email', serialize($we_do_not_have_your_email));

                $qlcd_wp_chatbot_sys_key_help = $_POST["qlcd_wp_chatbot_sys_key_help"];
                update_option('qlcd_wp_chatbot_sys_key_help', qcld_sanitize_field($qlcd_wp_chatbot_sys_key_help));

                $qlcd_wp_chatbot_sys_key_support = @$_POST["qlcd_wp_chatbot_sys_key_support"];
                update_option('qlcd_wp_chatbot_sys_key_support', qcld_sanitize_field($qlcd_wp_chatbot_sys_key_support));

                $qlcd_wp_chatbot_sys_key_reset = @$_POST["qlcd_wp_chatbot_sys_key_reset"];
                update_option('qlcd_wp_chatbot_sys_key_reset', qcld_sanitize_field($qlcd_wp_chatbot_sys_key_reset));

                $qlcd_wp_chatbot_sys_goodbye_keywords = @$_POST["qlcd_wp_chatbot_sys_goodbye_keywords"];
                update_option('qlcd_wp_chatbot_sys_goodbye_keywords', qcld_sanitize_field($qlcd_wp_chatbot_sys_goodbye_keywords));

                
                $qlcd_wp_chatbot_help_welcome = $_POST["qlcd_wp_chatbot_help_welcome"];
                update_option('qlcd_wp_chatbot_help_welcome', serialize($qlcd_wp_chatbot_help_welcome));

                $qlcd_wp_chatbot_help_msg = $_POST["qlcd_wp_chatbot_help_msg"];
                update_option('qlcd_wp_chatbot_help_msg', serialize($qlcd_wp_chatbot_help_msg));

                $qlcd_wp_chatbot_reset = $_POST["qlcd_wp_chatbot_reset"];
                update_option('qlcd_wp_chatbot_reset', serialize($qlcd_wp_chatbot_reset));

                set_transient( 'bot_clear_cache', 1, DAY_IN_SECONDS );
            }
        }
    }
}

new Qcld_Chatbot_Option_Save();
