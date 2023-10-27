<div id="wp-chatbot-shortcode-template-container"
         class="chatbot-theme-shortcode-container wp-chatbot-shortcode-template-container">
         <div class="wpbot-saas-live-chat">
    
        </div>
         <div class="wp-chatbot-container">
            <div class="wp-chatbot-ball-inner wp-chatbot-content">
                <div class="wp-chatbot-messages-wrapper">
                    <ul id="wp-chatbot-messages-container" class="wp-chatbot-messages-container">
                    </ul>
                </div>
                <?php do_action('wpbot_voice_record_wrapper'); ?>
                <!--wp-chatbot-messages-wrapper-->
            </div>
            <!--wp-chatbot-ball-inner-->
            <div class="wp-chatbot-footer">
                <div id="wp-chatbot-editor-area" class="wp-chatbot-editor-area">
                    <input id="wp-chatbot-editor" class="wp-chatbot-editor" required=""
                           placeholder="<?php _e('Send a message', 'assistent'); ?>"
                    >
                    <?php do_action('wpbot_voice_icon'); ?>
                    <button type="button" id="wp-chatbot-send-message"
                            class="wp-chatbot-button"><?php _e('send', 'assistent'); ?></button>
                </div>
                <!--wp-chatbot-editor-container-->
            </div>
            <!--wp-chatbot-footer-->
        </div>
         <!--wp-chatbot-editor-container-->
         <?php if(get_option('enable_wp_chatbot_disable_allicon')!='1'): ?>
                <div class="wp-chatbot-tab-nav" style="background: rgba(70, 70, 70, 0.5);">
                    <ul>
                    <?php if(get_option('enable_wp_chatbot_disable_helpicon')!='1'): ?>
                        <li><a class="wp-chatbot-operation-option" data-option="help" href="" title="<?php echo (get_option('qlcd_wp_chatbot_help')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_help'))):__('Help', 'wpchatbot')); ?>"></a></li>
                    <?php endif; ?>
                    <?php if(get_option('enable_wp_chatbot_disable_supporticon')!='1'): ?>
                        <li><a class="wp-chatbot-operation-option" data-option="support" href="" title="<?php echo (get_option('qlcd_wp_chatbot_support')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_support'))):__('Support', 'wpchatbot')); ?>"></a></li>
                    <?php endif; ?>
                    
						<?php $data = get_option('wbca_options'); ?>
						<?php if(qcld_wpbot_is_active_livechat()==true): ?>
                            <?php if(isset($data['disable_livechat_opration_icon']) && (!$data['disable_livechat_opration_icon']) ): ?>
                                    <?php if(qcld_wpbot_is_operator_online() >= 1 && isset($data['disable_livechat_operator_offline']) && ($data['disable_livechat_operator_offline'])):?>
                                        <li><a class="wp-chatbot-operation-option" data-option="live-chat"  href="" title="<?php echo esc_html__('Livechat', 'wpchatbot'); ?>"></a></li>
                                        <?php else: ?>
                                            <?php  if(isset($data['disable_livechat_operator_offline']) && (!$data['disable_livechat_operator_offline'])): ?>
                                                <li><a class="wp-chatbot-operation-option" data-option="live-chat"  href="" title="<?php echo esc_html__('Livechat', 'wpchatbot'); ?>"></a></li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
						<?php endif; ?>
					
                        <?php 
                            if(function_exists('qcpd_wpwc_addon_lang_init') && !empty($cart_items_number)){
                                do_action('qcld_wpwc_template_bottom_icon_woocommerce', $cart_items_number);
                            }

                        ?>

                    <?php if(get_option('enable_wp_chatbot_disable_chaticon')!='1'): ?>
                        <li class="wp-chatbot-operation-active"><a class="wp-chatbot-operation-option" data-option="chat" href="" title="<?php echo (get_option('qlcd_wp_chatbot_skip_conversation')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_skip_conversation'))):'Click this button to skip the conversation'); ?>"></a></li>
                     <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <!--wp-chatbot-container-->
    </div>
    <!--wp-chatbot-ball-container-->
    <?php
    echo  '<script type="text/javascript">var wclickintent = "'.$intent.'"</script>';
    echo '<style type="text/css"> .chatbot-theme-shortcode-container{max-width: '.$width.' !important;} </style>';
 
    
    ?>

    <style type="text/css">.wpbot-saas-live-chat{display:none}#wp-chatbot-shortcode-template-container .qcld-chatbot-custom-intent[data-text=<?php echo (isset($data['qlcd_wp_chatbot_sys_key_livechat']) && $data['qlcd_wp_chatbot_sys_key_livechat']!=''?$data['qlcd_wp_chatbot_sys_key_livechat']:'livechat'); ?>] {
    display: none;
    }</style>