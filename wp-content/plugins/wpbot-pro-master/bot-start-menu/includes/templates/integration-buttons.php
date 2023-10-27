<div class="wp-chatbot-start-content-single">
    <div class="wp-chatbot-integration-button-container">
        <?php if (get_option('enable_wp_chatbot_skype_floating_icon') == 1) { ?>
            <a href="skype:<?php echo get_option('enable_wp_chatbot_skype_id'); ?>?chat"><span
                        class="inetegration-skype-btn" title="<?php echo esc_html__('Skype', 'wpchatbot'); ?>"> </span></a>
        <?php } ?>
        <?php if (get_option('enable_wp_chatbot_whats') == 1) { ?>
            <a href="<?php echo esc_url('https://api.whatsapp.com/send?phone=' . get_option('qlcd_wp_chatbot_whats_num')); ?>"
                target="_blank"><span class="intergration-whats"
                                        title="<?php echo esc_html__('WhatsApp', 'wpchatbot'); ?>"></span></a>
        <?php } ?>
        <?php if (get_option('enable_wp_chatbot_floating_viber') == 1) { ?>
            <a href="<?php echo esc_url('https://live.viber.com/#/' . get_option('qlcd_wp_chatbot_viber_acc')); ?>"
                target="_blank"><span class="intergration-viber"
                                        title="<?php echo esc_html__('Viber', 'wpchatbot'); ?>"></span></a>
        <?php } ?>
        
        
        <?php if (get_option('enable_wp_chatbot_floating_phone') == 1 && get_option('qlcd_wp_chatbot_phone') != "") { ?>
            <a href="tel:<?php echo get_option('qlcd_wp_chatbot_phone'); ?>"><span
                        class="intergration-phone"
                        title="<?php echo esc_html__('Phone', 'wpchatbot'); ?>"> </span></a>
        <?php } ?>
        
        <?php 
        
        if (get_option('enable_wp_chatbot_floating_livechat') == 1 && get_option('enable_wp_chatbot_floating_livechat') != "" && (is_plugin_active('live-chat-addon/wpbot-chat-addon.php') == 1)) { 
            $data = get_option('wbca_options');
            if(isset($data['disable_livechat_opration_icon']) && (!$data['disable_livechat_opration_icon']) ):
                if(qcld_wpbot_is_operator_online() >= 1 ):
            ?>
            <?php if(get_option('wp_custom_icon_livechat')!=''): ?>
                <a href="#" id="start_wpbot_live_chat_floating_btn" title="Live Chat" style="background:url(<?php echo get_option('wp_custom_icon_livechat'); ?>)"></a>
            <?php else: ?>
                <a href="#" id="start_wpbot_live_chat_floating_btn" title="Live Chat"><i class="fa fa-commenting" aria-hidden="true"></i></a>
            <?php endif; ?>
        <?php 
                endif;
            endif; 
            } ?>
        
        
        <?php if (get_option('enable_wp_chatbot_floating_link') == 1 && get_option('qlcd_wp_chatbot_weblink') != "") { ?>
            <a href="<?php echo esc_url(get_option('qlcd_wp_chatbot_weblink')); ?>" target="_blank"><span
                        class="intergration-weblink" title="<?php echo esc_html__('Web Link', 'wpchatbot'); ?>"></span></a>
        <?php } ?>

        <?php if (get_option('enable_wp_chatbot_voice_message') == 1 && (is_plugin_active( 'voice-message-addon/wpbotvoicemessage.php' ) || (in_array( "WPBot Voice Module",get_option( 'wpbot_master_addons')['active'])) ) ) { ?>
                        <a href="#" title="Voice Message" ><span
                        class="wpbd_voice_message" title="<?php echo esc_html__('Voice Message', 'wpchatbot'); ?>" style="background-image:url('<?php echo QCLD_wpCHATBOT_PLUGIN_URL.'images/microphone.png'; ?>');background-position: 5px 4px;"></span></a>
                    <?php } ?>

        
    </div>
</div>