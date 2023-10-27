<?php $allIntents = qc_get_all_intents(); ?>
<?php 
wp_enqueue_style('qcld-wp-chatbot-common-style', QCLD_wpCHATBOT_PLUGIN_URL . '/css/common-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
?>
<div class="wrap">
    <h1 class="wpbot_header_h1"><?php echo esc_html__('WPBot', 'wpchatbot'); ?> </h1>
</div>
<div class="wp-chatbot-wrap">
    <form action="" method="POST">
    <div class="wpbot_dashboard_header container"><h1><?php echo wpbot_text(); ?> Language Center</h1>
    <p>**Please do not delete or leave any language field empty. All fields are <b>required</b>. You can change the language to your own.**</p>
    </div>
    <div class="wpbot_addons_section container">
    
        <div class="wpbot_single_addon_wrapper2">
        
        <section id="section-flip-5">
            <div class="wp-chatbot-language-center-summmery">
                
            </div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#wp-chatbot-lng-general"><?php echo esc_html__('General', 'wpchatbot'); ?></a></li>
                
                
                <li><a data-toggle="tab" href="#wp-chatbot-lng-support"><?php echo esc_html__('FAQ', 'wpchatbot'); ?></a></li>
                <li><a data-toggle="tab" href="#wp-chatbot-lng-subscription"><?php echo esc_html__('Email Subscription', 'wpchatbot'); ?></a></li>
                <?php // do_action('qcbot_show_languages_livechat'); ?>
                <?php if(function_exists('qcformbuilder_forms_fallback_shortcode')): ?>
                <li><a data-toggle="tab" href="#wp-chatbot-file-upload"><?php echo esc_html__('File Upload', 'wpchatbot'); ?></a></li>
                <?php endif; ?>
                <li><a data-toggle="tab" href="#wp-chatbot-good-bye"><?php echo esc_html__('GoodBye', 'wpchatbot'); ?></a></li>
                
                <li><a data-toggle="tab" href="#wp-chatbot-lng-reserve-keyword"><?php echo esc_html__('ChatBot Keywords', 'wpchatbot'); ?></a></li>
            </ul>
            <div class="tab-content">
                <div id="wp-chatbot-lng-general" class="tab-pane fade in active">
                    <div class="top-section">
                        <div class="row">
                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                <h5><strong style="font-weight:bold;">1.</strong> You can use this variable for user name: %%username%%</h5>
                                <h5><strong style="font-weight:bold;">2.</strong> Insert full link to an image to show in the chatbot responses like https://www.quantumcloud.com/wp/sad.jpg</h5>
                                <h5><strong style="font-weight:bold;">3.</strong> Insert full link to an youtube video to show in the chatbot responses like https://www.youtube.com/watch?v=gIGqgLEK1BI</h5>
                                <h5 ><strong style="font-weight:bold;">4.</strong> After making changes in the language center or settings, please type reset and hit enter in the ChatBot to start testing from the beginning or open a new Incognito window (Ctrl+Shit+N in chrome).</h5>
                                <h5 style="line-height: 20px;"><strong style="font-weight:bold;">5.</strong> You could use &lt;br&gt; tag for line break.</h5>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Your Company or Website Name', 'wpchatbot'), 'qlcd_wp_chatbot_host', 'Our Store', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Agent name', 'wpchatbot'), 'qlcd_wp_chatbot_agent', 'Carrie', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('User demo name', 'wpchatbot'), 'qlcd_wp_chatbot_shopper_demo_name', 'Amigo', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Ok, I will just call you', 'wpchatbot'), 'qlcd_wp_chatbot_shopper_call_you', 'Ok, I will just call you', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('YES', 'wpchatbot'), 'qlcd_wp_chatbot_yes', 'YES', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('NO', 'wpchatbot'), 'qlcd_wp_chatbot_no', 'NO', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('OR', 'wpchatbot'), 'qlcd_wp_chatbot_or', 'OR', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Sorry', 'wpchatbot'), 'qlcd_wp_chatbot_sorry', 'Sorry', '');
                                    ?>
                                </div>

                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Hello', 'wpchatbot'), 'qlcd_wp_chatbot_hello', 'Hello', '');
                                    ?>
                                </div>

                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Chat with us!', 'wpchatbot'), 'qlcd_wp_chatbot_chat_with_us', 'Chat with us!', '');
                                    ?>
                                </div>

                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Help', 'wpchatbot'), 'qlcd_wp_chatbot_help', 'Help', '');
                                    ?>
                                </div>

                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Support', 'wpchatbot'), 'qlcd_wp_chatbot_support', 'Support', '');
                                    ?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    $agent_join_options = maybe_unserialize(get_option('qlcd_wp_chatbot_agent_join'));
                                    $agent_join_option = 'qlcd_wp_chatbot_agent_join';
                                    $agent_join_text = esc_html__('has joined the conversation', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($agent_join_options, $agent_join_option, $agent_join_text);
                                    ?>
                                </div>
                            </div>
                            <!--col-xs-12-->
                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                <h4 class="text-success"><?php echo esc_html__(' Message setting for Greetings: ', 'wpchatbot'); ?></h4>
                                <div class="form-group">
                                    <?php
                                    $welcome_to_options = maybe_unserialize(get_option('qlcd_wp_chatbot_welcome'));
                                    $welcome_to_option = 'qlcd_wp_chatbot_welcome';
                                    $welcome_to_text = esc_html__('Welcome to', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($welcome_to_options, $welcome_to_option, $welcome_to_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $welcome_back_options = maybe_unserialize(get_option('qlcd_wp_chatbot_welcome_back'));
                                    $welcome_back_option = 'qlcd_wp_chatbot_welcome_back';
                                    $welcome_back_text = esc_html__('Welcome back', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($welcome_back_options, $welcome_back_option, $welcome_back_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $back_to_start_options = maybe_unserialize(get_option('qlcd_wp_chatbot_back_to_start'));
                                    $back_to_start_option = 'qlcd_wp_chatbot_back_to_start';
                                    $back_to_start_text = esc_html__('Back to Start', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($back_to_start_options, $back_to_start_option, $back_to_start_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $hi_there_options = maybe_unserialize(get_option('qlcd_wp_chatbot_hi_there'));
                                    $hi_there_option = 'qlcd_wp_chatbot_hi_there';
                                    $hi_there_text = esc_html__('Hi There!', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($hi_there_options, $hi_there_option, $hi_there_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $asking_name_options = maybe_unserialize(get_option('qlcd_wp_chatbot_asking_name'));
                                    $asking_name_option = 'qlcd_wp_chatbot_asking_name';
                                    $asking_name_text = esc_html__('May I know your name?', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_name_options, $asking_name_option, $asking_name_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $asking_email_options = maybe_unserialize(get_option('qlcd_wp_chatbot_asking_emailaddress'));
                                    $asking_email_option = 'qlcd_wp_chatbot_asking_emailaddress';
                                    $asking_email_text = esc_html__('May I know your email?', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $asking_email_options = maybe_unserialize(get_option('qlcd_wp_chatbot_got_email'));
                                    $asking_email_option = 'qlcd_wp_chatbot_got_email';
                                    $asking_email_text = esc_html__('Thanks for sharing your email!', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                    ?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    $asking_email_options = maybe_unserialize(get_option('qlcd_wp_chatbot_email_ignore'));
                                    $asking_email_option = 'qlcd_wp_chatbot_email_ignore';
                                    $asking_email_text = esc_html__('No problem if you do not want to share your email address!', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                    ?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    $asking_email_options = maybe_unserialize(get_option('qlcd_wp_chatbot_asking_phone_gt'));
                                    $asking_email_option = 'qlcd_wp_chatbot_asking_phone_gt';
                                    $asking_email_text = esc_html__('May I know your phone number?', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $asking_email_options = maybe_unserialize(get_option('qlcd_wp_chatbot_got_phone'));
                                    $asking_email_option = 'qlcd_wp_chatbot_got_phone';
                                    $asking_email_text = esc_html__('Thanks for sharing your phone number!', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                    ?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    $asking_email_options = maybe_unserialize(get_option('qlcd_wp_chatbot_phone_ignore'));
                                    $asking_email_option = 'qlcd_wp_chatbot_phone_ignore';
                                    $asking_email_text = esc_html__('No problem if you do not want to share your phone number', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                    ?>
                                </div>
                                
                                <div class="form-group">
                                    <?php
                                    $asking_email_options = maybe_unserialize(get_option('qlcd_wp_i_understand'));
                                    $asking_email_option = 'qlcd_wp_i_understand';
                                    $asking_email_text = esc_html__('I understand that your name is %%username%%. Is that correct?', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                    ?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    $i_am_options = maybe_unserialize(get_option('qlcd_wp_chatbot_i_am'));
                                    $i_am_option = 'qlcd_wp_chatbot_i_am';
                                    $i_am_text = esc_html__('I am', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($i_am_options, $i_am_option, $i_am_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $name_greeting_options = maybe_unserialize(get_option('qlcd_wp_chatbot_name_greeting'));
                                    $name_greeting_option = 'qlcd_wp_chatbot_name_greeting';
                                    $name_greeting_text = esc_html__('Nice to meet you', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($name_greeting_options, $name_greeting_option, $name_greeting_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $wildcard_msg_options = maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_msg'));
                                    $wildcard_msg_option = 'qlcd_wp_chatbot_wildcard_msg';
                                    $wildcard_msg_text = esc_html__('Hi %%username%%. I am here to find what you need. What are you looking for?', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wildcard_msg_options, $wildcard_msg_option, $wildcard_msg_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $empty_filter_msgs = maybe_unserialize(get_option('qlcd_wp_chatbot_empty_filter_msg'));
                                    $empty_filter_msg = 'qlcd_wp_chatbot_empty_filter_msg';
                                    $empty_filter_msg_text = esc_html__('Sorry, I did not understand that', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($empty_filter_msgs, $empty_filter_msg, $empty_filter_msg_text);
                                    ?>
                                </div>
                                
                                <h4 class="text-success"> <?php echo esc_html__('Message setting for Editor Box ', 'wpchatbot'); ?></h4>
                                <div class="form-group">
                                    <?php
                                    $is_typing_options = maybe_unserialize(get_option('qlcd_wp_chatbot_is_typing'));
                                    $is_typing_option = 'qlcd_wp_chatbot_is_typing';
                                    $is_typing_text = esc_html__('is typing...', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($is_typing_options, $is_typing_option, $is_typing_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $send_a_msg_options = maybe_unserialize(get_option('qlcd_wp_chatbot_send_a_msg'));
                                    $send_a_msg_option = 'qlcd_wp_chatbot_send_a_msg';
                                    $send_a_msg_text =esc_html__('Send a message', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($send_a_msg_options, $send_a_msg_option, $send_a_msg_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $choose_option_options = maybe_unserialize(get_option('qlcd_wp_chatbot_choose_option'));
                                    $choose_option_option = 'qlcd_wp_chatbot_choose_option';
                                    $choose_option_text = esc_html__('Choose an option', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($choose_option_options, $choose_option_option, $choose_option_text);
                                    ?>
                                </div>
                                
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Support Mail Subject', 'wpchatbot'), 'qlcd_wp_chatbot_email_sub', 'Support Request from WPBOT', '');
                                    ?>
                                </div>

                                <div class="form-group">

                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Callback Email Subject', 'wpchatbot'), 'qlcd_wp_chatbot_callback_email_sub', 'WPBot Support Mail Request for Callback', '');
                                    ?>
                                </div>

                                <div class="form-group">
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('We have found these results', 'wpchatbot'), 'qlcd_wp_chatbot_we_have_found', 'We have found these results', '');
                                    ?>
                                </div>

                                
                                <div class="form-group">
                                    <?php
                                    $wp_chatbot_no_results = maybe_unserialize(get_option('qlcd_wp_chatbot_no_result'));
                                    $wp_chatbot_no_result = 'qlcd_wp_chatbot_no_result';
                                    $wp_chatbot_no_result_text = esc_html__('Sorry, No result found!', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                    ?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    $qlcd_wp_chatbot_did_you_mean = maybe_unserialize(get_option('qlcd_wp_chatbot_did_you_mean'));
                                    
                                    $qlcd_wp_chatbot_did_you_means = 'qlcd_wp_chatbot_did_you_mean';
                                    $wp_chatbot_no_result_text = esc_html__('Did you mean?', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($qlcd_wp_chatbot_did_you_mean, $qlcd_wp_chatbot_did_you_means, $wp_chatbot_no_result_text);
                                    ?>
                                </div>
                                
                                
                                
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Your email was sent successfully.Thanks!', 'wpchatbot'), 'qlcd_wp_chatbot_email_sent', 'Your email was sent successfully.Thanks!', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                   
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Sorry! I could not send your mail! Please contact the webmaster.', 'wpchatbot'), 'qlcd_wp_chatbot_email_fail', 'Sorry! fail to send email', '');
                                    ?>
                                </div>
                                
                                
                                <div class="form-group">
                                   
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Thank you for the Phone number. We will call back ASAP.', 'wpchatbot'), 'qlcd_wp_chatbot_phone_sent', 'Thank you for the Phone number. We will call back ASAP.', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Sorry! I could not collect phone number! Please contact the webmaster.', 'wpchatbot'), 'qlcd_wp_chatbot_phone_fail', 'Sorry! I could not collect phone number!', '');
                                    ?>
                                </div>
                                
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Click this button to skip the conversation', 'wpchatbot'), 'qlcd_wp_chatbot_skip_conversation', 'Click this button to skip the conversation', '');
                                    ?>
                                </div>
                                
                                <div class="form-group">
                                    
                                    <?php 
                                    
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Load More', 'wpchatbot'), 'qlcd_wp_chatbot_load_more_search', 'Load More', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Loading...', 'wpchatbot'), 'qlcd_wp_chatbot_loading_search', 'Loading...', '');
                                        // $loading_options = maybe_unserialize(get_option('qlcd_wp_chatbot_loading_search'));
                                        // $loading_option = 'qlcd_wp_chatbot_loading_search';
                                        // $loading_text = esc_html__('Loading', 'wpchatbot');
                                        // qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($loading_options, $loading_option, $loading_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Conversation Details', 'wpchatbot'), 'qlcd_wp_chatbot_conversation_details', 'Conversation Details', '');
                                    ?>
                                </div>
                                
                                
                                <div class="form-group">
                                    <?php
                                    $go_back_tooltip_options = maybe_unserialize(get_option('qlcd_wp_chatbot_go_back_tooltip'));
                                    $go_back_tooltip_option = 'qlcd_wp_chatbot_go_back_tooltip';
                                    $go_back_tooltip_text = esc_html__('click to go back.', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($go_back_tooltip_options, $go_back_tooltip_option, $go_back_tooltip_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $support_email_options = maybe_unserialize(get_option('qlcd_wp_chatbot_support_email'));
                                    $support_email_option = 'qlcd_wp_chatbot_support_email';
                                    $support_email_text = esc_html__('Click me if you want to send us a email.', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($support_email_options, $support_email_option, $support_email_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $asking_email_options = maybe_unserialize(get_option('qlcd_wp_chatbot_asking_email'));
                                    $asking_email_option = 'qlcd_wp_chatbot_asking_email';
                                    $asking_email_text = esc_html__('Please provide your email address', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $asking_email_options = maybe_unserialize(get_option('qlcd_wp_chatbot_valid_phone_number'));
                                    $asking_email_option = 'qlcd_wp_chatbot_valid_phone_number';
                                    $asking_email_text = esc_html__('Please provide a valid phone number', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_email_options, $asking_email_option, $asking_email_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $search_keyword = maybe_unserialize(get_option('qlcd_wp_chatbot_search_keyword'));
                                    $search_keyword_option = 'qlcd_wp_chatbot_search_keyword';
                                    $search_keyword_text = esc_html__('Hello #name!, Please enter your keyword for searching', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($search_keyword, $search_keyword_option, $search_keyword_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $invalid_email_options = maybe_unserialize(get_option('qlcd_wp_chatbot_invalid_email'));
                                    $invalid_email_option = 'qlcd_wp_chatbot_invalid_email';
                                    $invalid_email_text = esc_html__('Sorry, Email address is not valid! Please provide a valid email.', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($invalid_email_options, $invalid_email_option, $invalid_email_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $asking_msg_options = maybe_unserialize(get_option('qlcd_wp_chatbot_asking_msg'));
                                    $asking_msg_option = 'qlcd_wp_chatbot_asking_msg';
                                    $asking_msg_text = esc_html__('Thank you for email address. Please write your message now.', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_msg_options, $asking_msg_option, $asking_msg_text);
                                    ?>
                                </div>
                                
                                <div class="form-group">
                                    <?php
                                    $feedback_label_options = maybe_unserialize(get_option('qlcd_wp_chatbot_feedback_label'));
                                    $feedback_label_option = 'qlcd_wp_chatbot_feedback_label';
                                    $feedback_label_text = esc_html__('Send Feedback!', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($feedback_label_options, $feedback_label_option, $feedback_label_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $asking_phone_options = maybe_unserialize(get_option('qlcd_wp_chatbot_asking_phone'));
                                    $asking_phone_option = 'qlcd_wp_chatbot_asking_phone';
                                    $asking_phone_text = esc_html__('Please provide your Phone number', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($asking_phone_options, $asking_phone_option, $asking_phone_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $thanks_phone_options = maybe_unserialize(get_option('qlcd_wp_chatbot_thank_for_phone'));
                                    $thanks_phone_option = 'qlcd_wp_chatbot_thank_for_phone';
                                    $thanks_phone_text = esc_html__('Thank you for Phone number', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($thanks_phone_options, $thanks_phone_option, $thanks_phone_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $support_option_again_options = maybe_unserialize(get_option('qlcd_wp_chatbot_support_option_again'));
                                    $support_option_again_option = 'qlcd_wp_chatbot_support_option_again';
                                    $support_option_again_text = esc_html__('You may choose an option from below.', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($support_option_again_options, $support_option_again_option, $support_option_again_text);
                                    ?>
                                </div>

                                

                            </div>
                        </div>

                        


                    </div>
                </div>
                
                
                
                <div id="wp-chatbot-lng-support" class="tab-pane fade">
                    <div class="top-section">
                        <div class="row">

                        

                            <div class="col-xs-12" id="wp-chatbot-language-section">
                            <p style="color:red">* If you do change any predefined & custom intent button label then please go to <b>Start Menu</b> tab and remove the intent from <b>Menu Area</b> and add it back from <b>Menu List</b> then hit the Save button.</p>
                                
                                <div class="form-group">
                                    <?php
                                    $support_welcome_options = maybe_unserialize(get_option('qlcd_wp_chatbot_support_welcome'));
                                    $support_welcome_option = 'qlcd_wp_chatbot_support_welcome';
                                    $support_welcome_text = esc_html__('Welcome to FAQ Section', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($support_welcome_options, $support_welcome_option, $support_welcome_text);
                                    ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(function_exists('qcformbuilder_forms_fallback_shortcode')): ?>
                <div id="wp-chatbot-file-upload" class="tab-pane fade">
                    <div class="top-section">
                        <div class="row">

                            <div class="col-xs-12" id="wp-chatbot-language-section">
                            
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('File has been uploaded successfully!', 'wpchatbot'), 'qlcd_wp_chatbot_file_upload_succ', 'File has been uploaded successfully!', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Failed to upload the file.', 'wpchatbot'), 'qlcd_wp_chatbot_file_upload_fail', 'Failed to upload the file.', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                   
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Max file upload size exceed.', 'wpchatbot'), 'qlcd_wp_chatbot_file_size_excd', 'Max file upload size exceed.', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Extension not allowed, please choose a valid file.', 'wpchatbot'), 'qlcd_wp_chatbot_ext_not_allowed', 'Extension not allowed, please choose a valid file.', '');
                                    ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div id="wp-chatbot-good-bye" class="tab-pane fade">
                    <div class="top-section">
                        <div class="row">

                            <div class="col-xs-12" id="wp-chatbot-language-section">
                            
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Ok Bye, See you soon!', 'wpchatbot'), 'qlcd_wp_chatbot_good_bye_text', 'Ok Bye, See you soon!', '');
                                    ?>
                                </div>
                                
                            </div>

                            <div class="col-xs-12" id="wp-chatbot-language-section">
                            
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Do you want the chat transcript to be emailed?', 'wpchatbot'), 'qlcd_wp_chatbot_transcript_emailed', 'Do you want the chat transcript to be emailed?', '');
                                    ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div id="wp-chatbot-lng-subscription" class="tab-pane fade">
                    <div class="top-section">
                        <div class="row">
                            <div class="col-xs-12" id="wp-chatbot-language-section">

                            <p style="color:red">* If you do change any predefined & custom intent button label then please go to <b>Start Menu</b> tab and remove the intent from <b>Menu Area</b> and add it back from <b>Menu List</b> then hit the Save button.</p>

                                
                                
                            </div>
                            <div class="col-xs-12" id="wp-chatbot-language-section">
                                <div class="form-group">
                                    <?php
                                    $wp_chatbot_no_results = maybe_unserialize(get_option('do_you_want_to_subscribe'));
                                    $wp_chatbot_no_result = 'do_you_want_to_subscribe';
                                    $wp_chatbot_no_result_text = esc_html__('Do you want to subscribe to our newsletter?', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $wp_chatbot_no_results = maybe_unserialize(get_option('qlcd_wp_email_subscription_success'));
                                    $wp_chatbot_no_result = 'qlcd_wp_email_subscription_success';
                                    $wp_chatbot_no_result_text = esc_html__('You have successfully subscribed to our newsletter. Thank you!', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $wp_chatbot_no_results = maybe_unserialize(get_option('qlcd_wp_email_already_subscribe'));
                                    $wp_chatbot_no_result = 'qlcd_wp_email_already_subscribe';
                                    $wp_chatbot_no_result_text = esc_html__('You have already subscribed to our newsletter.', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                    ?>
                                </div>
                                
                                
                                    
                                <div class="form-group">
                                    <?php
                                    $wp_chatbot_no_results = maybe_unserialize(get_option('qlcd_wp_email_subscription_offer_subject'));
                                    $wp_chatbot_no_result = 'qlcd_wp_email_subscription_offer_subject';
                                    $wp_chatbot_no_result_text = esc_html__('Email Subscription Offer Subject', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                    ?>

                                </div>

                                <div class="form-group">
                                    <?php
                                    $wp_chatbot_no_results = maybe_unserialize(get_option('qlcd_wp_email_subscription_offer'));
                                    $wp_chatbot_no_result = 'qlcd_wp_email_subscription_offer';
                                    $wp_chatbot_no_result_text = esc_html__('Email Subscription Offer Content.', 'wpchatbot');
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                    ?>
                                    <p>If email subscription offer is enabled from General Settings, It will be sent to subscriber's email when subscription done.</p>
                                    <br>
                                </div>
                                
                                <div class="col-xs-12" id="wp-chatbot-language-section">
                                    <div class="form-group">
                                        <?php 
                                            qcld_wpbot()->helper->render_language_field(esc_html__('Unsubscribe', 'wpchatbot'), 'qlcd_wp_email_unsubscription', 'Unsubscribe', '');
                                        ?>
                                    </div>
                                    
                                </div>

                                <div class="col-xs-12" id="wp-chatbot-language-section">
                                    <div class="form-group">
                                        <?php
                                        $wp_chatbot_no_results = maybe_unserialize(get_option('do_you_want_to_unsubscribe'));
                                        $wp_chatbot_no_result = 'do_you_want_to_unsubscribe';
                                        $wp_chatbot_no_result_text = esc_html__('Do you want to unsubscribe from our newsletter?', 'wpchatbot');
                                        qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                        ?>
                                    </div>
                                </div>

                                <div class="col-xs-12" id="wp-chatbot-language-section">
                                    <div class="form-group">
                                        <?php
                                        $wp_chatbot_no_results = maybe_unserialize(get_option('you_have_successfully_unsubscribe'));
                                        $wp_chatbot_no_result = 'you_have_successfully_unsubscribe';
                                        $wp_chatbot_no_result_text = esc_html__('You have successfully unsubscribed from our newsletter!', 'wpchatbot');
                                        qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                        ?>
                                    </div>
                                </div>

                                <div class="col-xs-12" id="wp-chatbot-language-section">
                                    <div class="form-group">
                                        <?php
                                        $wp_chatbot_no_results = maybe_unserialize(get_option('we_do_not_have_your_email'));
                                        $wp_chatbot_no_result = 'we_do_not_have_your_email';
                                        $wp_chatbot_no_result_text = esc_html__('We do not have your email in the ChatBot database.', 'wpchatbot');
                                        qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($wp_chatbot_no_results, $wp_chatbot_no_result, $wp_chatbot_no_result_text);
                                        ?>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>

                <?php // do_action('qcbot_show_livechat_lan_fields'); ?>
                
                <div id="wp-chatbot-lng-reserve-keyword" class="tab-pane fade">
                    <div class="top-section">
                        <div class="row">
                            <div class="col-xs-12" id="wp-chatbot-language-section">
                            <p style="color:red">* If you do change any predefined & custom intent button label then please go to <b>Start Menu</b> tab and remove the intent from <b>Menu Area</b> and add it back from <b>Menu List</b> then hit the Save button.</p>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Start Keyword', 'wpchatbot'), 'qlcd_wp_chatbot_sys_key_help', 'start', '');
                                    ?>
                                </div>

                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('FAQ Keyword', 'wpchatbot'), 'qlcd_wp_chatbot_sys_key_support', 'faq', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('Converstion History Clear Keyword', 'wpchatbot'), 'qlcd_wp_chatbot_sys_key_reset', 'reset', '');
                                    ?>
                                </div>
                                <div class="form-group">
                                    
                                    <?php 
                                        qcld_wpbot()->helper->render_language_field(esc_html__('GoodBye Keywords', 'wpchatbot'), 'qlcd_wp_chatbot_sys_goodbye_keywords', 'goodbye, bye, see you soon, bye-bye, adieu, quit, stop chat, abort, stop, abort, so long', '');
                                    ?>
                                </div>
                                
                                <div class="form-group">
                                    <?php
                                    $help_welcome_options = maybe_unserialize(get_option('qlcd_wp_chatbot_help_welcome'));
                                    $help_welcome_option = 'qlcd_wp_chatbot_help_welcome';
                                    $help_welcome_text = 'Welcome to Help Section';
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($help_welcome_options, $help_welcome_option, $help_welcome_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $help_msg_options = maybe_unserialize(get_option('qlcd_wp_chatbot_help_msg'));
                                    $help_msg_option = 'qlcd_wp_chatbot_help_msg';
                                    $help_msg_text = '<h3>Type and Hit Enter</h3>  1. <b>start</b> Get back to the main menu. <br> 2. <b>faq</b> for  FAQ. <br> 3. <b>reset</b> To clear chat history and start from the beginning.  4. <b>livechat</b>  To navigating into the livechat window. 5. <b>unsubscribe</b> to remove your email from our newsletter.';
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($help_msg_options, $help_msg_option, $help_msg_text);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $reset_options = maybe_unserialize(get_option('qlcd_wp_chatbot_reset'));
                                    $reset_option = 'qlcd_wp_chatbot_reset';
                                    $reset_text = 'Do you want to clear our chat history and start over?';
                                    qcld_wpbot()->helper->qcld_wb_chatbot_dynamic_multi_option($reset_options, $reset_option, $reset_text);
                                    ?>
                                </div>
                            </div>
                            <!--                                            col-xs-12-->
                        </div>
                        <!--                                        row-->
                    </div>
                    <!--                                    top-section-->
                </div>
                
            </div>
            <!--                            tab-content-->
        </section>

        </div>
        <footer class="wp-chatbot-admin-footer">
                    <div class="row">
                        <div class="text-left col-sm-3 col-sm-offset-3">
                            
                        </div>
                        <div class="text-right col-sm-6">
                            <input type="submit" class="btn btn-primary submit-button" name="submit" id="submit" value="Save Settings">
                        </div>
                    </div>
                    <!--                    row-->
                </footer>
    </div>
    <?php wp_nonce_field('wp_chatbot'); ?>
    </form>

<div class="wpbot-fabs" >
  <a id="wpbot-upload" target="_blank" class="wpbot-fab" title="Copy Image Link from Gallery"><i class="fa fa-upload" aria-hidden="true"></i></a>
  <a id="wpbot-giphy" target="_blank" class="wpbot-fab" title="Copy Giphy Image Link"><i class="fa fa-grav" aria-hidden="true"></i></a>
  <a id="wpbot-prime" class="wpbot-fab"><i class="fa fa-picture-o" aria-hidden="true" title="Paste a full Image or Youtube URL inside the ChatBot responses to display them to your users"></i></a>
</div>

<div id="wpbot-load-qcbot" title="Launch the chatbot for testing" class="qc_wpbot_floating_main qc_right_position" style="display: block;" >
    <div class="qc_bot_floating_content"> <img alt="Launch the chatbot for testing" src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-0.png'); ?>" alt="WPBot"><p>Test Your Changes</p> </div>
</div>


<div id="wpbot-giphy-myModal" class="wpbot-giphy-modal">

<!-- Modal content -->
<div class="wpbot-giphy-modal-content">
  <span class="wpbot-giphy-close">&times;</span>
  <iframe id="qcwpbot_ifram_giphy" src="about:blank" data-src="https://giphy.com/" height="100%" width="100%" style="border:none;min-height: 500px;"></iframe>
</div>

</div>

<div id="wpbot-qcbot-myModal" class="wpbot-giphy-modal" style="z-index: 99999;padding-top: 0;">
    <?php $page = get_page_by_title('wpwBot Mobile App'); ?>
    <!-- Modal content -->
    <div class="wpbot-giphy-modal-content" style="height: 95%;
    overflow: auto;
    box-shadow: 2px 5px 15px 5px #0707075e;
    border-radius: 5px;
    max-width: 1600px;">
    <span class="wpbot-qcbot-close">&times;</span>
    To test in the front end, after making any changes, please type reset and hit enter in the ChatBot to start testing from the beginning or open a new Incognito window (Ctrl+Shit+N in Chrome).
    <iframe id="qcwpbot_ifram_qcbot" src="about:blank" data-src="<?php echo home_url().'/'.$page->post_name; ?>" height="100%" width="100%" style="border:none;height: calc(100% - 46px);"></iframe>
    </div>

</div>

<script type="text/javascript">

jQuery(document).ready(function($){
// toggleFab();

//Fab click
$('#wpbot-prime').click(function() {
  toggleFab();
});

//Toggle chat and links
function toggleFab() {
  $('.wpbot-prime').toggleClass('wpbot-is-active');
  $('#wpbot-prime').toggleClass('wpbot-is-float');
  $('.wpbot-fab').toggleClass('wpbot-is-visible');
  
}

// Ripple effect
var target, ink, d, x, y;
$(".wpbot-fab").click(function(e) {
  target = $(this);
  //create .ink element if it doesn't exist
  if (target.find(".wpbot-ink").length == 0)
    target.prepend("<span class='wpbot-ink'></span>");

  ink = target.find(".wpbot-ink");
  //incase of quick double clicks stop the previous animation
  ink.removeClass("wpbot-animate");

  //set size of .ink
  if (!ink.height() && !ink.width()) {
    //use parent's width or height whichever is larger for the diameter to make a circle which can cover the entire element.
    d = Math.max(target.outerWidth(), target.outerHeight());
    ink.css({
      height: d,
      width: d
    });
  }

  //get click coordinates
  //logic = click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center;
  x = e.pageX - target.offset().left - ink.width() / 2;
  y = e.pageY - target.offset().top - ink.height() / 2;

  //set the position and add class .animate
  ink.css({
    top: y + 'px',
    left: x + 'px'
  }).addClass("wpbot-animate");
});

})

// Get the modal
var modal = document.getElementById("wpbot-giphy-myModal");

// Get the button that opens the modal
var btn = document.getElementById("wpbot-giphy");

var giphyifram = document.getElementById('qcwpbot_ifram_giphy');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("wpbot-qcbot-close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
  giphyifram.setAttribute('src', giphyifram.getAttribute('data-src'));
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  giphyifram.setAttribute('src', 'about:blank');
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    giphyifram.setAttribute('src', 'about:blank');
  }
}

// code for test bot

// Get the modal
var modal1 = document.getElementById("wpbot-qcbot-myModal");

// Get the button that opens the modal
var btn1 = document.getElementById("wpbot-load-qcbot");

var giphyifram1 = document.getElementById('qcwpbot_ifram_qcbot');

// Get the <span> element that closes the modal
var span1 = document.getElementsByClassName("wpbot-qcbot-close")[0];

// When the user clicks the button, open the modal 
btn1.onclick = function() {
  modal1.style.display = "block";
  giphyifram1.setAttribute('src', giphyifram1.getAttribute('data-src'));
}

// When the user clicks on <span> (x), close the modal
span1.onclick = function() {
  modal1.style.display = "none";
  giphyifram1.setAttribute('src', 'about:blank');
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal1) {
    modal1.style.display = "none";
    giphyifram1.setAttribute('src', 'about:blank');
  }
}

</script>

</div>
