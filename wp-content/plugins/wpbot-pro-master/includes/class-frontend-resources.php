<?php 

/**
 * Class Qcld_WPBot_Frontend_resources
 */
class Qcld_WPBot_Frontend_resources
{
    public function __construct() {
        add_action( 'wp', array( $this, 'load' ) );
    }

    function load() {
        global $post;
        if($post != ''){
            $post_content = $post->post_content; 
        }else{
            $post_content = '';
        }
        if ( 
            ( ! is_admin() && get_option('disable_wp_chatbot') != 1 && qcld_wp_chatbot_load_controlling() == true)
            || is_page( 'wpwbot-mobile-app' )
            || has_shortcode( $post_content, 'chatbot-widget' )
            || has_shortcode( $post_content, 'wpbot-click-chat' )
            || has_shortcode( $post_content, 'wpbot-page' )
            || has_shortcode( $post_content, 'wpwbot' )
            ) {
            add_action('wp_enqueue_scripts', array($this, 'qcld_wb_chatbot_frontend_scripts'));
        }
        
    }

    /**
     * Frontend scripts and styles
     *
     * @return void
     */
    public function qcld_wb_chatbot_frontend_scripts()
    {
        
        global $woocommerce, $wp_scripts, $post, $current_user;
		
        $display_name = '';
        $display_email = '';
        $user_image = get_option('wp_custom_client_icon');
        $user_id = 0;
        $user_image = get_option('wp_custom_client_icon');
		if ( is_user_logged_in() ) { 
            $display_name = $current_user->display_name;
            $display_email = $current_user->user_email;
            $user_image = esc_url( get_avatar_url( $current_user->ID ) );
            $user_id = $current_user->ID;
		}
		
		$flag = false;
		if(is_object($post)){
			if(strpos($post->post_content, '[wpbot-skip-gretting]' ) !== false){
				$flag = true;
			}
		}
        
        $data = get_option('wbca_options');
		
		$i_understand_text = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_i_understand')));
		if(empty($i_understand_text)){
			$i_understand_text = array('I understand that your name is %%username%%. Is that correct?');
		}
		
		$ticket_url = '';
		if(class_exists('Qcld_kbx_support')){
			if(get_option('qcld_support_page_id') && get_option('qcld_support_page_id')!=''){
				$kbx_page_id = get_option('qcld_support_page_id');
			}else{
				$kbx_page_id = get_page_by_title('Support Ticket for KBX');
			}
			$ticket_url = get_permalink($kbx_page_id);
		}
		
        $wp_chatbot_obj = array(
            'wp_chatbot_position_x' => ( get_option('wp_chatbot_position_x') ? get_option('wp_chatbot_position_x') : 50 ),
            'wp_chatbot_position_y' => ( get_option('wp_chatbot_position_y') ? get_option('wp_chatbot_position_y') : 50 ),
            'wp_chatbot_position_mp_x' => ( get_option('wp_chatbot_position_mp_x') ? get_option('wp_chatbot_position_mp_x') : 20  ),
            'wp_chatbot_position_mp_y' => (get_option('wp_chatbot_position_mp_y') ? get_option('wp_chatbot_position_mp_y') : 20 ),
            'enable_floating_icon' => get_option('enable_floating_icon'),
            'wp_chatbot_position_in' => get_option('wp_chatbot_position_in'),
            'wp_chatbot_position_mp_in' => get_option('wp_chatbot_position_mp_in'),
            'disable_icon_animation' => get_option('disable_wp_chatbot_icon_animation'),
            'delay_wp_chatbot_floating_icon' => get_option('delay_wp_chatbot_floating_icon'),
            'delay_chat_window_open' => get_option('delay_wp_chatbot_window_open'),
            'disable_wp_chatbot_history' => get_option('disable_wp_chatbot_history'),
            'delay_floating_notification_box' => get_option('delay_floating_notification_box'),
            'disable_wp_chatbot_notification' => get_option('disable_wp_chatbot_notification'),
            'always_scroll_to_bottom' => get_option('always_scroll_to_bottom'),
            'disable_featured_product' => get_option('disable_wp_chatbot_featured_product'),
            'disable_product_search' => get_option('disable_wp_chatbot_product_search'),
            'disable_catalog' => get_option('disable_wp_chatbot_catalog'),
            'skip_wp_greetings' => ($flag==true?1:get_option('skip_wp_greetings')),
            'qcld_disable_start_menu' => get_option('qcld_disable_start_menu'),
            'priority_openai_all' => get_option('qcld_priority_openai_all'),
            'qcld_replace_start_menu' => get_option('qcld_replace_start_menu'),
            'qcld_disable_repited_startmenu' => get_option('qcld_disable_repited_startmenu'),
            'show_menu_after_greetings'=> (get_option('show_menu_after_greetings')!=''?get_option('show_menu_after_greetings'):0),
            'disable_first_msg' => get_option('disable_first_msg'),
            'ask_email_wp_greetings' => get_option('ask_email_wp_greetings'),
            'ask_name_confirmation' => get_option('ask_name_confirmation'),
            'ask_phone_wp_greetings' => get_option('ask_phone_wp_greetings'),
            'enable_wp_chatbot_open_initial' => get_option('enable_wp_chatbot_open_initial'),
            'wp_keep_chat_window_open'  => get_option('wp_keep_chat_window_open'),
            'disable_order_status' => get_option('disable_wp_chatbot_order_status'),
            'disable_sale_product' => get_option('disable_wp_chatbot_sale_product'),
            'open_product_detail' => get_option('wp_chatbot_open_product_detail'),
            'order_user' => get_option('qlcd_wp_chatbot_order_user'),
            'ajax_url' => admin_url('admin-ajax.php'),
            'image_path' => QCLD_wpCHATBOT_IMG_URL,
            'client_image'=> $user_image,
            'yes' => stripslashes_deep( maybe_unserialize(get_option('qlcd_wp_chatbot_yes'))),
            'no' => stripslashes_deep( maybe_unserialize(get_option('qlcd_wp_chatbot_no'))),
            'or' => stripslashes_deep( maybe_unserialize(get_option('qlcd_wp_chatbot_or'))),
            'host' => stripslashes_deep( maybe_unserialize(get_option('qlcd_wp_chatbot_host'))),
            'agent' => stripslashes_deep(maybe_unserialize(get_option('qlcd_wp_chatbot_agent'))),
            'agent_image' => get_option('wp_chatbot_agent_image'),
            'agent_image_path' => qcld_wpbot()->helper->qcld_wb_chatbot_agent_icon(),
            'shopper_demo_name' => stripslashes_deep( maybe_unserialize(get_option('qlcd_wp_chatbot_shopper_demo_name'))),
            'shopper_call_you' => stripslashes_deep( maybe_unserialize(get_option('qlcd_wp_chatbot_shopper_call_you'))),
            'agent_join' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_agent_join'))),
            'welcome' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_welcome'))),
            'welcome_back' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_welcome_back'))),
            'hi_there' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_hi_there'))),
            'asking_name' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_asking_name'))),
            'asking_emailaddress' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_asking_emailaddress'))),
            'got_email' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_got_email'))),
            'email_ignore' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_email_ignore'))),

            'asking_phone_gt' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_asking_phone_gt'))),
            'got_phone' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_got_phone'))),
            'phone_ignore' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_phone_ignore'))),
            'i_understand' => $i_understand_text,
            'i_am' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_i_am'))),
            'name_greeting' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_name_greeting'))),
            'wildcard_msg' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_msg'))),
            'empty_filter_msg' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_empty_filter_msg'))),
            'do_you_want_to_subscribe' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('do_you_want_to_subscribe'))),
			'chatbot_file_upload_succ' => (get_option('qlcd_wp_chatbot_file_upload_succ') != '' ? get_option('qlcd_wp_chatbot_file_upload_succ') : 'File has been uploaded successfully!'),
            'qlcd_wp_chatbot_good_bye_text' => (get_option('qlcd_wp_chatbot_good_bye_text') != '' ? qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_good_bye_text'))) : 'Ok Bye, See you soon!'),
            'qlcd_wp_chatbot_transcript_emailed' => (get_option('qlcd_wp_chatbot_transcript_emailed') != '' ? qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_transcript_emailed'))) : 'Do you want the chat transcript to be emailed?'),
            
			
			'chatbot_file_upload_fail' => (get_option('qlcd_wp_chatbot_file_upload_fail') != '' ? get_option('qlcd_wp_chatbot_file_upload_fail') : 'Failed to upload the file.'),
			
            'do_you_want_to_unsubscribe' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('do_you_want_to_unsubscribe'))),
            'we_do_not_have_your_email' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('we_do_not_have_your_email'))),
            'you_have_successfully_unsubscribe' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('you_have_successfully_unsubscribe'))),
            'is_typing' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_is_typing'))),
            'send_a_msg' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_send_a_msg'))),
            'viewed_products' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_viewed_products'))),
            'shopping_cart' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_shopping_cart'))),
            'cart_updating' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_updating'))),
            'cart_removing' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_removing'))),
            'sys_key_help' => maybe_unserialize(get_option('qlcd_wp_chatbot_sys_key_help')),
            'sys_key_product' => maybe_unserialize(get_option('qlcd_wp_chatbot_sys_key_product')),
            'auto_hide_floating_button' => get_option('qc_auto_hide_floating_button'),
            
            'sys_key_catalog' => maybe_unserialize(get_option('qlcd_wp_chatbot_sys_key_catalog')),
            'sys_key_order' => maybe_unserialize(get_option('qlcd_wp_chatbot_sys_key_order')),
            'sys_key_support' => maybe_unserialize(get_option('qlcd_wp_chatbot_sys_key_support')),
            'sys_key_reset' => maybe_unserialize(get_option('qlcd_wp_chatbot_sys_key_reset')),
            'sys_goodbye_key' => maybe_unserialize(get_option('qlcd_wp_chatbot_sys_goodbye_keywords')),
            'wbca_lg_operator_offline' => (isset($data['wbca_lg_operator_offline']) ? $data['wbca_lg_operator_offline'] : 'all operator is offline'),
            'sys_key_livechat' => (isset($data['qlcd_wp_chatbot_sys_key_livechat']) && $data['qlcd_wp_chatbot_sys_key_livechat']!=''?$data['qlcd_wp_chatbot_sys_key_livechat']:'livechat'),
            'help_welcome' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_help_welcome'))),
            'tag_search_intent' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_tag_search_intent'))),
            'back_to_start' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_back_to_start'))),
            'help_msg' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_help_msg'))),
            'reset' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_reset'))),
            'wildcard_product' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_product'))),
            'wildcard_catalog' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_catalog'))),
            'featured_products' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_featured_products'))),
            'sale_products' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_sale_products'))),
            'wildcard_order' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_order'))),
            'wildcard_support' => get_option('qlcd_wp_chatbot_wildcard_support'),
            'product_asking' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_product_asking'))),
            'product_suggest' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_product_suggest'))),
            'product_infinite' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_product_infinite'))),
            'product_success' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(@maybe_unserialize(get_option('qlcd_wp_chatbot_product_success'))),
            'product_fail' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(@maybe_unserialize(get_option('qlcd_wp_chatbot_product_fail'))),
            'support_welcome' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_support_welcome'))),
			'typing_animation' => (get_option('wp_custom_typing_icon')?get_option('wp_custom_typing_icon'):''),
            'site_search' => get_option('qlcd_wp_site_search'),
            'wppt_post_types' => get_option('wppt_post_types'),
            'livechat_label' => (isset($data['qlcd_wp_livechat']) && $data['qlcd_wp_livechat']!=''?$data['qlcd_wp_livechat']:'Livechat'),
            'email_subscription' => get_option('qlcd_wp_email_subscription'),
            'str_categories' => (get_option('qlcd_wp_str_category')?get_option('qlcd_wp_str_category'):'STR Categories'),
            'open_a_ticket' => maybe_unserialize(get_option('qlcd_open_ticket_label')),
            'ticket_url' => $ticket_url,
            'unsubscribe' => maybe_unserialize(get_option('qlcd_wp_email_unsubscription')),
            'send_us_email' => maybe_unserialize(get_option('qlcd_wp_send_us_email')),
            'leave_feedback' => maybe_unserialize(get_option('qlcd_wp_leave_feedback')),
            'good_bye' => maybe_unserialize(get_option('qlcd_wp_good_bye')),
            'livechat' => maybe_unserialize(get_option('enable_wp_custom_intent_livechat_button')),
			
            'go_back_tooltip' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_go_back_tooltip'))),
            'support_email' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_support_email'))),
            'support_option_again' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_support_option_again'))),
            'asking_email' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_asking_email'))),
            'asking_search_keyword' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_search_keyword'))),
            'asking_msg' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_asking_msg'))),
            'support_phone' => get_option('qlcd_wp_chatbot_support_phone'),
            'asking_phone' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_asking_phone'))),
            'thank_for_phone' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_thank_for_phone'))),
            'support_query' =>qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize( get_option('support_query'))),
			
            'custom_intent' =>qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize( get_option('qlcd_wp_custon_intent'))),
            'custom_intent_label' =>qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize( get_option('qlcd_wp_custon_intent_label'))),
            'custom_intent_email' =>qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize( get_option('qlcd_wp_custon_intent_checkbox'))),

            'custom_menu' =>qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize( get_option('qlcd_wp_custon_menu'))),
            'custom_menu_link' =>qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize( get_option('qlcd_wp_custon_menu_link'))),
            'custom_menu_target' =>qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize( get_option('qlcd_wp_custon_menu_checkbox'))),
			
			'custom_menu_type' =>qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize( get_option('qlcd_wp_custon_menu_type'))),
			'custom_menu_linktype' =>qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize( get_option('qlcd_wp_custon_menu_type'))),

            'simple_response_intent' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(qc_wpbot_simple_response_intent()),
			
            'support_ans' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('support_ans'))),
            'notification_interval' => get_option('qlcd_wp_chatbot_notification_interval'),
            'notifications' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_notifications'))),
            'exitintentpagewise' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qcld_exit_pagewise'))),
            
            'notification_intents' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_notifications_intent'))),  
            
            'order_welcome' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_order_welcome'))),
            'order_username_asking' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_order_username_asking'))),
            'order_username_password' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_order_username_password'))),
            'order_user' => $display_name,
            'order_email' => $display_email,
            'order_login' => is_user_logged_in(),
            'order_nonce' => wp_create_nonce("wpwbot-order-nonce"),
            'order_email_support' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_order_email_support'))),
            'email_fail' => stripslashes_deep(  get_option('qlcd_wp_chatbot_email_fail')),
            'invalid_email' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_invalid_email'))),
            'stop_words' => qcld_wpbot()->helper->qcld_get_stopwords(),
            
            'enable_messenger' => get_option('enable_wp_chatbot_messenger'),
            'messenger_label' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_messenger_label'))),
            'fb_page_id' => get_option('qlcd_wp_chatbot_fb_page_id'),
            'enable_skype' => get_option('enable_wp_chatbot_skype'),
            'enable_whats' => get_option('enable_wp_chatbot_whats'),
            'whats_label' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_whats_label'))),
            'whats_num' => get_option('qlcd_wp_chatbot_whats_num'),
            'ret_greet' => get_option('qlcd_wp_chatbot_ret_greet'),
            'enable_exit_intent' => get_option('enable_wp_chatbot_exit_intent'),
            'exit_intent_msg' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('wp_chatbot_exit_intent_msg'))),
            'exit_intent_custom_intent' => stripslashes_deep(  get_option('wp_chatbot_exit_intent_custom')),
            'exit_intent_bargain_pro_single_page' => get_option('wp_chatbot_exit_intent_bargain_pro_single_page'),
            'exit_intent_bargain_is_product_page' => ( function_exists('is_product') ? is_product() : false ),
            'exit_intent_bargain_msg' => stripslashes_deep(  get_option('wp_chatbot_exit_intent_bargain_msg')),
            'exit_intent_email' => stripslashes_deep(  get_option('wp_chatbot_exit_intent_email')),
            'exit_intent_once' => get_option('wp_chatbot_exit_intent_once'),
            'enable_scroll_open' => get_option('enable_wp_chatbot_scroll_open'),
            'scroll_open_msg' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('wp_chatbot_scroll_open_msg'))),
            'scroll_open_custom_intent' => stripslashes_deep(  get_option('wp_chatbot_scroll_open_custom')),
            'scroll_open_email' => stripslashes_deep(  get_option('wp_chatbot_scroll_open_email')),
            'scroll_open_percent' => get_option('wp_chatbot_scroll_percent'),
            'scroll_open_once' => get_option('wp_chatbot_scroll_once'),
            'enable_auto_open' => get_option('enable_wp_chatbot_auto_open'),
            'auto_open_msg' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('wp_chatbot_auto_open_msg'))),
            'auto_open_custom_intent' => stripslashes_deep( get_option('wp_chatbot_auto_open_custom')),
            'auto_open_email' => stripslashes_deep(  get_option('wp_chatbot_auto_open_email')),
            'auto_open_time' => get_option('wp_chatbot_auto_open_time'),
            'auto_open_once' => get_option('wp_chatbot_auto_open_once'),
            'proactive_bg_color' => get_option('wp_chatbot_proactive_bg_color'),
            'disable_feedback' => get_option('disable_wp_chatbot_feedback'),
            'disable_leave_feedback' => get_option('disable_wp_leave_feedback'),
            'disable_good_bye' => get_option('disable_good_bye'),
            'disable_sitesearch' => get_option('disable_wp_chatbot_site_search'),
            'no_result' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_no_result'))),
            'did_you_mean' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_did_you_mean'))),
			'email_subscription_success' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_email_subscription_success'))),
			'email_already_subscribe' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_email_already_subscribe'))),
            'disable_faq' => get_option('disable_wp_chatbot_faq'),
            'disable_email_subscription' => get_option('disable_email_subscription'),
            'disable_voice_message' => get_option('disable_voice_message'),
            'disable_str_categories' => (!class_exists('Qcld_str_pro')?1:get_option('disable_str_categories')),
            'disable_open_ticket' => get_option('disable_open_ticket'),
            'disable_livechat' => (isset($data['disable_livechat'])?$data['disable_livechat']:''),
            'feedback_label' =>qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_feedback_label'))),
            'enable_meta_title' =>get_option('enable_wp_chatbot_meta_title'),
            'meta_label' =>stripslashes_deep(  get_option('qlcd_wp_chatbot_meta_label')),
            'phone_number' => get_option('qlcd_wp_chatbot_phone'),
            'livechatlink' => get_option('qlcd_wp_chatbot_livechatlink'),
            'livechat_button_label' => get_option('qlcd_wp_livechat_button_label'),
            'loading' => stripslashes_deep( maybe_unserialize(get_option('qlcd_wp_chatbot_loading_search'))),
            'call_gen' => get_option('disable_wp_chatbot_call_gen'),
            'call_sup' => get_option('disable_wp_chatbot_call_sup'),
            'enable_ret_sound' => get_option('enable_wp_chatbot_ret_sound'),
            'enable_ret_user_show' => get_option('enable_wp_chatbot_ret_user_show'),
            'enable_inactive_time_show' => get_option('enable_wp_chatbot_inactive_time_show'),
            'ret_inactive_user_once' => get_option('wp_chatbot_inactive_once'),
            'mobile_full_screen' => get_option('enable_wp_chatbot_mobile_full_screen'),
            'chatbot_content' => get_option('chatbot_content_max_height'),
            'enable_gdpr' => get_option('enable_wp_chatbot_gdpr_compliance'),
            'wpbot_search_result_number' => get_option('wpbot_search_result_number'),
            'gdpr_text' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('wpbot_gdpr_text'))),
            'no_result_attempt_message' => get_option( 'no_result_attempt_message' ),
			'no_result_attempt_count' => get_option('no_result_attempt_count'),
            'inactive_time' => get_option('wp_chatbot_inactive_time'),
            'checkout_msg' => stripslashes_deep(  get_option('wp_chatbot_checkout_msg')),
            'ai_df_enable' => get_option('enable_wp_chatbot_dailogflow'),
            'df_api_version' => (get_option('wp_chatbot_df_api')==''?'v1':get_option('wp_chatbot_df_api')),
            'ai_df_token' => get_option('qlcd_wp_chatbot_dialogflow_client_token'),
            'df_defualt_reply' => stripslashes_deep(  get_option('qlcd_wp_chatbot_dialogflow_defualt_reply')),
            'df_agent_lan' => get_option('qlcd_wp_chatbot_dialogflow_agent_language'),
            'df_project_id' => get_option('qlcd_wp_chatbot_dialogflow_project_id'),
            'df_project_key' => get_option('qlcd_wp_chatbot_dialogflow_project_key'),
            'sound_bot_message' => get_option('enable_wp_chatbot_sound_botmessage'),
			'clear_cache'	=> ($flag==true?1:0),
			'template'	=> get_option('qcld_wb_chatbot_theme'),
			'is_operator_online'=> qcld_wpbot_is_operator_online(),
			'disable_livechat_operator_offline'=> (isset($data['disable_livechat_operator_offline'])?$data['disable_livechat_operator_offline']:''),
			'is_livechat_active'=> qcld_wpbot_is_active_livechat(),
            'imgurl' => QCLD_wpCHATBOT_IMG_URL,
            'hello'=> get_option('qlcd_wp_chatbot_hello'),
            'ajax_nonce'=> wp_create_nonce('qcsecretbotnonceval123qc'),
            'exitintent_all_page' => get_option('wp_chatbot_exitintent_show_pages'),
            'exitintent_pages' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('wp_chatbot_exitintent_show_pages_list'))),
            'exit_pagewise' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qcld_exit_pagewise'))),
            'trigger_url_exit' => get_option('trigger_url_exit_id'),
            'trigger_url_scroll' => get_option('trigger_url_scroll_id'),
            'trigger_url_auto' => get_option('trigger_url_auto_id'),
            'scrollintent_pages' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('wp_chatbot_scrollintent_show_pages_list'))),
            'scrollintent_all_page' => get_option('wp_chatbot_scrollintent_show_pages'),
            'scroll_pagewise' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qcld_scroll_pagewise'))),

            'autointent_pages' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('wp_chatbot_autointent_show_pages_list'))),
            'autointent_all_page' => get_option('wp_chatbot_autointent_show_pages'),
            'auto_pagewise' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qcld_auto_pagewise'))),

            'notification_navigation' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('wpbot_notification_navigations'))),
            'current_pageid' => (is_object($post)?$post->ID:''),
            'disable_repeatative'  => get_option('wpbot_disable_repeatative'),
            'botpreloadingtime' => (get_option('wpbot_preloading_time')?get_option('wpbot_preloading_time'):0),
            'start_menu'    => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qc_wpbot_menu_order'))),
            'forms' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(qc_get_formbuilder_forms()),
            'form_commands'=> qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(qc_get_formbuilder_form_commands()),
            'form_ids'  => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(qc_get_formbuilder_form_ids()),
            'is_formbuilder_active' => qc_is_formbuilder_active(),
            'is_chatsession_active' => qc_is_chatsession_active(),
            'open_livechat_window_first' => (isset($data['show_livechat_window_first'])?$data['show_livechat_window_first']:''),
            'livechat_autopopulation' =>(isset($data['disable_livechat_autopopulation_userdata'])? 1 : 0),
            'is_chat_session_active' => qcld_wpbot_is_active_chat_history(),
            'disable_auto_focus' => get_option('disable_auto_focus_message_area'),
            'open_ai_enable' => (get_option('ai_enabled')=='1'? get_option('ai_enabled') : '0'),
            'woocommerce' => (function_exists('qcpd_wpwc_addon_lang_init')?true:false),
            //bargain bot
            'your_offer_price'  => (get_option('qcld_minimum_accept_price_heading_text')!=''?get_option('qcld_minimum_accept_price_heading_text'):'Please, tell me what is your offer price.'),
            'your_offer_price_again'  => (get_option('qcld_minimum_accept_price_heading_text_again')!=''?get_option('qcld_minimum_accept_price_heading_text_again'):'It seems like you have not provided any offer amount. Please give me a number!'),
            'your_low_price_alert' => (get_option('qcld_minimum_accept_price_low_alert_text_two')!=''?get_option('qcld_minimum_accept_price_low_alert_text_two'):'Your offered price {offer price} is too low for us.'),
            'your_too_low_price_alert' => (get_option('qcld_minimum_accept_price_too_low_alert_text')!=''?get_option('qcld_minimum_accept_price_too_low_alert_text'):'The best we can do for you is {minimum amount}. Do you accept?'),
            'map_talk_to_boss' => (get_option('qcld_minimum_accept_price_talk_to_boss')!=''?get_option('qcld_minimum_accept_price_talk_to_boss'):'Please tell me your final price. I will talk to my boss.'),
            'map_get_email_address' => (get_option('qcld_minimum_accept_price_get_email_address')!=''?get_option('qcld_minimum_accept_price_get_email_address'):'Please tell me your email address so I can get back to you.'),
            'map_thanks_test' => (get_option('qcld_minimum_accept_price_thanks_test')!=''?get_option('qcld_minimum_accept_price_thanks_test'):'Thank you.'),
            'map_acceptable_price' => (get_option('qcld_minimum_accept_price_acceptable_price')!=''?get_option('qcld_minimum_accept_price_acceptable_price'):'Your offered price {offer price} is acceptable.'),
            'map_checkout_now_button_text' => (get_option('qcld_minimum_accept_modal_checkout_now_button_text')!=''?get_option('qcld_minimum_accept_modal_checkout_now_button_text'):'Checkout Now'),
            'map_get_checkout_url' => (function_exists('wc_get_checkout_url')?wc_get_checkout_url():''),
            'map_get_ajax_nonce' => (wp_create_nonce( 'woo-minimum-acceptable-price')),
            'currency_symbol' => (function_exists('get_woocommerce_currency_symbol')?get_woocommerce_currency_symbol():''),
            'order_status_without_login' => (get_option('wp_chatbot_order_status_without_login')?get_option('wp_chatbot_order_status_without_login'):0),
            'order_email_asking' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_order_email'))),
            'order_id_asking' => qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_order_id'))),
            'is_woowbot' => (function_exists('qcpd_wpwc_checking_dependencies')?1:0),
            'df_cardlink_open' => get_option('wpbot_card_response_same_window') == 1 ? 1 : 0,
            'qc_site_search_priority' => get_option('qc_site_search_priority')  == 1 ? 1 : 0,
			'is_mobile'	=> qcld_wp_chatbot_is_mobile(),
            'disable_youtube_parse' => get_option('disable_youtube_parse'),
            'language'              => ( get_option( 'wpbotml_Default_language' ) && class_exists( 'Qcld_Wpbot_Multilanguage' ) && get_option( 'wpbotml_Default_language' ) != '' ? get_option( 'wpbotml_Default_language' ) : $this->get_default_langauge() ),
            'default_language'      => ( get_option( 'wpbotml_Default_language' ) && class_exists( 'Qcld_Wpbot_Multilanguage' ) && get_option( 'wpbotml_Default_language' ) != '' ? get_option( 'wpbotml_Default_language' ) : $this->get_default_langauge() ),
            'start_menu_installed' => (get_option( 'enable_extended_interface' )==1?true:false),
            'qcld_bargain_allowed_times' => get_option('qcld_minimum_accept_bargain_allowed_times'),
            'voice_addon' => (function_exists('qcld_wpbotva') ? true : false),
            'bot_read'  => (get_option('stt_allow_read')=='on'?true:false),
            'stt_service' => get_option( 'stt_service' ),
            'entities'  => Qcld_WPBot_Helper::entities(),
            'current_user_id'  => $user_id,
        );

        global $wp;
        //check if url based langauge enabled
        if( class_exists( 'Qcld_Wpbot_Multilanguage' ) && get_option( 'wpbotml_url_urls' ) != '' ){

            $urlss = get_option( 'wpbotml_url_urls' );
            
            if( !empty($urlss) ){
                foreach( $urlss as $lancode=>$urls ){
                    $urls = explode( PHP_EOL, $urls );
                    $urls = array_filter($urls);
                    if( ! empty( $urls ) ){
                        foreach( $urls as $url ){
                            $url = trim($url);
                            if( isset( $wp->request ) && ( rtrim( $url, "/" ) == rtrim( home_url( $wp->request ), "/" ) || strpos( home_url( $wp->request ) , $url) !== false ) ){
                                $wp_chatbot_obj['language'] = $lancode;
                                $wp_chatbot_obj['default_language'] = $lancode;
                            }
                        }
                    }
                }
            }
        }

		
        wp_register_script('qcld-wp-chatbot-slimsqccrl-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.slimscroll.min.js', array('jquery'), QCLD_wpCHATBOT_VERSION, true);

       // wp_register_style('qcld-wp-chatbot-widget-css', plugins_url(basename(plugin_dir_path(__FILE__)) . '/css/widget_area_css.css', basename(__FILE__)), '', QCLD_wpCHATBOT_VERSION, 'screen');


        wp_register_style('qcld-wp-chatbot-widget-css', QCLD_wpCHATBOT_PLUGIN_URL . 'css/widget_area_css.css', '', QCLD_wpCHATBOT_VERSION, 'screen');


        wp_enqueue_script('qcld-wp-chatbot-slimsqccrl-js');

        wp_register_script('qcld-wp-chatbot-qcquery-cake', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.cookie.js', array('jquery'), QCLD_wpCHATBOT_VERSION, true);
        wp_enqueue_script('qcld-wp-chatbot-qcquery-cake');
        

        wp_register_script('qcld-wp-chatbot-magnifict-qcpopup', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.magnific-popup.min.js', array('jquery'), QCLD_wpCHATBOT_VERSION, true);
        wp_enqueue_script('qcld-wp-chatbot-magnifict-qcpopup');

        wp_register_script('qcld-wp-chatbot-datetime-jquery', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.datetimepicker.full.min.js', array('jquery'), QCLD_wpCHATBOT_VERSION, true);
        wp_enqueue_script('qcld-wp-chatbot-datetime-jquery');


        wp_register_script('qcld-wp-chatbot-plugin', QCLD_wpCHATBOT_PLUGIN_URL . 'js/qcld-wp-chatbot-plugin.js', array('jquery', 'qcld-wp-chatbot-qcquery-cake','qcld-wp-chatbot-magnifict-qcpopup'), QCLD_wpCHATBOT_VERSION, true);
        wp_enqueue_script('qcld-wp-chatbot-plugin');
        wp_register_script('qcld-wp-chatbot-front-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/qcld-wp-chatbot-front.js', array('jquery', 'qcld-wp-chatbot-qcquery-cake'), QCLD_wpCHATBOT_VERSION, true);
        wp_enqueue_script('qcld-wp-chatbot-front-js');
        wp_localize_script('qcld-wp-chatbot-front-js', 'wp_chatbot_obj', $wp_chatbot_obj);

        wp_localize_script('qcld-wp-chatbot-frontend', 'wp_chatbot_obj', $wp_chatbot_obj);

        wp_register_style('qcld-wp-chatbot-common-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/common-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-common-style');

        wp_register_style('qcld-wp-chatbot-datetime-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/jquery.datetimepicker.min.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-datetime-style');
        $user_font = get_option('wp_chat_user_font_family') != '' ? get_option('wp_chat_user_font_family') : '';
        if($user_font != '' ){
            $user_font_family = str_replace('\\', '',$user_font);
            $user_font_family = json_decode($user_font_family);
            $user_font_name = str_replace(' ', '+', $user_font_family->fontFamily);
            $user_font_name = str_replace("'","",$user_font_name );
            if(get_option('enable_wp_chatbot_custom_color')==1){  
                $user_enqueue_font = 'https://fonts.googleapis.com/css2?family='.$user_font_name;
                wp_enqueue_style( 'qcld-chatbot-user-google-fonts', $user_enqueue_font, false );
                wp_enqueue_style( 'qcld-chatbot-user-google-fonts');
            }
        }
        $bot_font = get_option('wp_chat_bot_font_family') != '' ? get_option('wp_chat_bot_font_family') : '';
        if($bot_font != '' ){
            $bot_font_family = str_replace('\\', '',$bot_font);
            $bot_font_family = json_decode($bot_font_family);
            $bot_font_name =  $bot_font_family->fontFamily;
            $bot_font_name = str_replace(' ', '+', $bot_font_family->fontFamily);
            $bot_font_name = str_replace("'","",$bot_font_name );
            if(get_option('enable_wp_chatbot_custom_color')==1){  
                $bot_enqueue_font = 'https://fonts.googleapis.com/css2?family='.$bot_font_name;
                wp_enqueue_style( 'qcld-chatbot-bot-google-fonts', $bot_enqueue_font, false );
                wp_enqueue_style( 'qcld-chatbot-bot-google-fonts');
            }
        }
        $custom_colors = '';
        if((get_option('enable_wp_chatbot_custom_color')==1)){
            $header_bg_color = get_option('wp_chatbot_header_background_color') != '' ? get_option('wp_chatbot_header_background_color') : '';
            if($header_bg_color != ''){
                $custom_colors .="#wp-chatbot-board-container > .wp-chatbot-header{
                    background-color: ".$header_bg_color.";
                }";
            }
        }
        if((get_option('enable_wp_chatbot_custom_color')==1) && ($bot_font != '' )){ 
            $custom_colors .="
            #wp-chatbot-messages-container > li.wp-chatbot-msg > .wp-chatbot-paragraph,
                #wp-chatbot-messages-container > li.wp-chatbot-msg > span{
                    font-family: ".$bot_font_family->fontFamily.";
                    font-weight: ".$bot_font_family->fontWeight.";
                    font-style: ".$bot_font_family->fontStyle.";
                }
                ";
        }
        if((get_option('enable_wp_chatbot_custom_color')==1) && ($user_font != '' )){
            $custom_colors .=" 
                #wp-chatbot-messages-container > li.wp-chat-user-msg > .wp-chatbot-paragraph{
                    font-family: ".$user_font_family->fontFamily.";
                    font-weight: ".$user_font_family->fontWeight.";
                    font-style: ".$user_font_family->fontStyle.";
                }
                ";
        }
        $font_size = get_option('wp_chatbot_font_size');
        if((get_option('enable_wp_chatbot_custom_color')==1) && (!empty($font_size) || ($font_size != 0) )){ 
            $custom_colors .="
            #wp-chatbot-messages-container > li.wp-chatbot-msg > .wp-chatbot-paragraph,
                #wp-chatbot-messages-container > li.wp-chatbot-msg > span{
                    font-size: ".$font_size."px;
                }
                ";
        }
        if(get_option('enable_wp_chatbot_custom_color')==1){            
            $custom_colors .="
                #wp-chatbot-chat-container, .wp-chatbot-product-description, .wp-chatbot-product-description p,.wp-chatbot-product-quantity label, .wp-chatbot-product-variable label {
                    color: ". get_option('wp_chatbot_text_color')." !important;
                }
                #wp-chatbot-chat-container a {
                    color: ". get_option('wp_chatbot_link_color')." !important;
                }
                #wp-chatbot-chat-container a:hover {
                    color: ". get_option('wp_chatbot_link_hover_color')." !important;
                }
                
                ul.wp-chatbot-messages-container > li.wp-chatbot-msg .wp-chatbot-paragraph,
                .wp-chatbot-agent-profile .wp-chatbot-bubble {
                    color: ". get_option('wp_chatbot_bot_msg_text_color')." !important;
                    background-color: ". get_option('wp_chatbot_bot_msg_bg_color')." !important;
                    word-break: break-word;
                }
                span.qcld-chatbot-product-category,div.qcld_new_start_button,div.qcld_new_start_button span,div.qcld_new_start_button .qcld-chatbot-site-search, div.qcld_new_start_button .qcld-chatbot-custom-intent, span.qcld-chatbot-support-items, span.qcld-chatbot-wildcard, span.qcld-chatbot-suggest-email, span.qcld-chatbot-reset-btn, #woo-chatbot-loadmore, .wp-chatbot-shortcode-template-container span.qcld-chatbot-product-category, .wp-chatbot-shortcode-template-container span.qcld-chatbot-support-items, .wp-chatbot-shortcode-template-container span.qcld-chatbot-wildcard, .wp-chatbot-shortcode-template-container span.wp-chatbot-card-button, .wp-chatbot-shortcode-template-container span.qcld-chatbot-suggest-email, span.qcld-chatbot-suggest-phone, .wp-chatbot-shortcode-template-container span.qcld-chatbot-reset-btn, .wp-chatbot-shortcode-template-container #wp-chatbot-loadmore, .wp-chatbot-ball-cart-items, .wpbd_subscription, .qcld-chatbot-site-search, .qcld_subscribe_confirm, .qcld-chat-common, .qcld-chatbot-custom-intent {
                    color: ". get_option('wp_chatbot_buttons_text_color') ." !important;
                    background-color: ". get_option('wp_chatbot_buttons_bg_color') ." !important;
                    background-image: none !important;
                }

                span.qcld-chatbot-product-category:hover, span.qcld-chatbot-support-items:hover, span.qcld-chatbot-wildcard:hover, span.qcld-chatbot-suggest-email:hover, span.qcld-chatbot-reset-btn:hover, #woo-chatbot-loadmore:hover, .wp-chatbot-shortcode-template-container:hover span.qcld-chatbot-product-category:hover, .wp-chatbot-shortcode-template-container:hover span.qcld-chatbot-support-items:hover, .wp-chatbot-shortcode-template-container:hover span.qcld-chatbot-wildcard:hover, .wp-chatbot-shortcode-template-container:hover span.wp-chatbot-card-button:hover, .wp-chatbot-shortcode-template-container:hover span.qcld-chatbot-suggest-email:hover, span.qcld-chatbot-suggest-phone:hover, .wp-chatbot-shortcode-template-container:hover span.qcld-chatbot-reset-btn:hover, .wp-chatbot-shortcode-template-container:hover #wp-chatbot-loadmore:hover, .wp-chatbot-ball-cart-items:hover, .wpbd_subscription:hover, .qcld-chatbot-site-search:hover, .qcld_subscribe_confirm:hover, .qcld-chat-common:hover, .qcld-chatbot-custom-intent:hover {
                    color: ". get_option('wp_chatbot_buttons_text_color_hover') ." !important;
                    background-color: ". get_option('wp_chatbot_buttons_bg_color_hover') ." !important;
                background-image: none !important;
                }

                li.wp-chat-user-msg .wp-chatbot-paragraph {
                    color: ". get_option('wp_chatbot_user_msg_text_color')." !important;
                    background-color: ". get_option('wp_chatbot_user_msg_bg_color')." !important;
                }
                ul.wp-chatbot-messages-container > li.wp-chatbot-msg > .wp-chatbot-paragraph:before,
                .wp-chatbot-bubble:before {
                    border-right: 10px solid ". get_option('wp_chatbot_bot_msg_bg_color')." !important;

                }
                ul.wp-chatbot-messages-container > li.wp-chat-user-msg > .wp-chatbot-paragraph:before {
                    border-left: 10px solid ". get_option('wp_chatbot_user_msg_bg_color')." !important;
                }
            ";

        }

        if(get_option('wp_chatbot_custom_css')!="") {
            $custom_colors .= get_option('wp_chatbot_custom_css');
        }
        
        if(get_option('wp_chatbot_floatingiconbg_color')!="") {
            $custom_colors .= ".wp-chatbot-ball{
                background: ". get_option('wp_chatbot_floatingiconbg_color')." !important;
            }
            .wp-chatbot-ball:hover, .wp-chatbot-ball:focus{
                background: ".get_option('wp_chatbot_floatingiconbg_color')." !important;
            }
            .qc_wpbot_floating_main{
                background-color: ". get_option('wp_chatbot_floatingiconbg_color')." !important;
            }
            .qc_wpbot_floating_main:hover, .qc_wpbot_floating_main:focus{
                background-color: ". get_option('wp_chatbot_floatingiconbg_color')." !important;
            }
            ";
        }

        if(get_option('disable_wp_agent_icon_animation')==1){
            $custom_colors .="ul.wp-chatbot-messages-container > li:before{display:none !important}";
        }
        if( get_option('enable_floating_icon') != 1 ){
            $custom_colors .= "div#wp-chatbot-chat-container > #wp-chatbot-notification-container { display: none; } #wp-chatbot-chat-container > #wp-chatbot-ball{ display: none !important; }";
        }
        if((get_option('chatbot_content_max_height') != '')){
            $custom_colors .=" #wp-chatbot-ball-container,#wp-chatbot-board-container,.wp-chatbot-start-screen,.slimScrollDiv,.wp-chatbot-start-container, {
                max-height: ".get_option('chatbot_content_max_height')."px !important;
            }";
            $custom_colors .="
            .wp-chatbot-content {
                max-height: ".(get_option('chatbot_content_max_height') -50 )."px !important;
            }";
        }
        wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_colors );


        wp_register_style('qcld-wp-chatbot-magnifict-qcpopup-css', QCLD_wpCHATBOT_PLUGIN_URL . 'css/magnific-popup.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qcld-wp-chatbot-magnifict-qcpopup-css');
        $qcld_wb_chatbot_theme = get_option('qcld_wb_chatbot_theme');

        //Loading shortcode style
		
		wp_register_style('qlcd-wp-chatbot-font-awe', QCLD_wpCHATBOT_PLUGIN_URL . 'css/font-awesome.min.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qlcd-wp-chatbot-font-awe');

        wp_register_style('qlcd-wp-chatbot-ani-mate', QCLD_wpCHATBOT_PLUGIN_URL . 'css/animate.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qlcd-wp-chatbot-ani-mate');
		
		if($qcld_wb_chatbot_theme=='template-06' || $qcld_wb_chatbot_theme=='template-07'){
			$qcld_wb_chatbot_theme = 'template-01';
		}
		
        if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/shortcode.css')) {
            // wp_register_style('qcld-wp-chatbot-shortcode-style', QCLD_wpCHATBOT_PLUGIN_URL . 'templates/' . $qcld_wb_chatbot_theme . '/shortcode.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            // wp_enqueue_style('qcld-wp-chatbot-shortcode-style');
        }
    }

    public function get_default_langauge(){
        $languages = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_msg')));
		$languages = array_keys($languages);
        $lang = get_locale();
        if( !empty( $languages ) && is_array( $languages ) ){
            if( in_array( $lang, $languages ) ){
                return $lang;
            }else{
                return $languages[0];
            }
        }else{
            return $languages[0];
        }
		
    }
}

new Qcld_WPBot_Frontend_resources();
