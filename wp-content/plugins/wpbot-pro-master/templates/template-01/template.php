<?php if(get_option('enable_wp_chatbot_custom_color')==1 &&  get_option('wp_chatbot_theme_primary_color') && get_option('wp_chatbot_theme_primary_color')!=''): ?>
<style>
.wp-chatbot-tab-nav {
    background-color: <?php echo get_option('wp_chatbot_theme_primary_color') ?> !important;
}
</style>
<?php endif; ?>
<?php if(get_option('enable_wp_chatbot_custom_color')==1 &&  get_option('wp_chatbot_theme_secondary_color') && get_option('wp_chatbot_theme_secondary_color')!=''): ?>
<style>

</style>
<?php endif; ?>
<div id="wp-chatbot-ball-container" class="wp-chatbot-template-01" aria-haspopup aria-live="polite" aria-expanded="false">

    <?php do_action('render_start_menu'); ?>
	<div class="wpbot-saas-live-chat">
  
	</div>
    <div class="wp-chatbot-container">
        <?php 
            if(function_exists('qcpd_wpwc_addon_lang_init')){
                do_action('qcld_wpwc_product_details_woocommerce');
            }

        ?>
        <div id="wp-chatbot-board-container" class="wp-chatbot-board-container">
        
            <div class="wp-chatbot-header">
                <?php do_action('render_back_to_menu_button'); ?>
                <div id="wp-chatbot-desktop-reload" title="<?php echo(get_option('qlcd_wp_chatbot_reset_lan') != '' ? get_option('qlcd_wp_chatbot_reset_lan') : 'Reset'); ?>"><i class="fa fa-refresh" aria-hidden="true"></i></div>

                <div id="wp-chatbot-desktop-close" title="<?php echo(get_option('qlcd_wp_chatbot_close_lan') != '' ? get_option('qlcd_wp_chatbot_close_lan') : 'Close'); ?>"><i class="fa fa-times" aria-hidden="true"></i></div>
                <?php if ( qcld_wpbot_is_active_chat_history() === true ): ?>
                <div id="wp-chatbot-email-transcript" title="<?php echo( esc_html__( 'Send me the transcript via email.' ) ); ?>"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                <?php endif; ?>

                <?php 
                    if( function_exists( 'qcld_wpbotml' ) && count( qcld_wpbotml()->languages ) > 1){
                        do_action('ml_render_lan_dropdown');
                    }
                ?>

            </div>
            
            <div class="wp-chatbot-ball-inner wp-chatbot-content">
                <!-- only show on Mobile app -->
                <?php if(isset($template_app) && $template_app=='yes'){?>
                    <div class="wp-chatbot-cart-checkout-wrapper">
                        <div id="wp-chatbot-cart-short-code">
                        </div>
                        <div id="wp-chatbot-checkout-short-code">
                        </div>
                    </div>
                <?php } ?>
                <div class="wp-chatbot-messages-wrapper">
                    <ul id="wp-chatbot-messages-container" class="wp-chatbot-messages-container">
                    </ul>
                </div>
                <?php do_action('wpbot_voice_record_wrapper'); ?>
            </div>
            <div class="wp-chatbot-footer">
                <div id="wp-chatbot-editor-container" class="wp-chatbot-editor-container">
                <label for="wp-chatbot-editor">Type your Message</label>   
                    <input id="wp-chatbot-editor" class="wp-chatbot-editor" required placeholder="<?php echo qcld_wpb_randmom_message_handle(@maybe_unserialize(get_option('qlcd_wp_chatbot_send_a_msg'))); ?>" />
                    <?php do_action('wpbot_voice_icon'); ?>
                    <button type="button" id="wp-chatbot-send-message" class="wp-chatbot-button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </div>
                <!--wp-chatbot-editor-container-->
                <?php if(get_option('enable_wp_chatbot_disable_allicon')!='1'): ?>
                <div class="wp-chatbot-tab-nav">

					<ul>
                        <?php if(get_option('enable_wp_chatbot_disable_helpicon')!='1'): ?>
                        <li><a class="wp-chatbot-operation-option" data-option="help" href="" title="<?php echo (get_option('qlcd_wp_chatbot_help')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_help'))):__('Help', 'wpchatbot')); ?>" ></a></li>
                        <?php endif; ?>
                        <?php if(get_option('enable_wp_chatbot_disable_supporticon')!='1'): ?>
						 <li><a class="wp-chatbot-operation-option" data-option="support"  href="" title="<?php echo (get_option('qlcd_wp_chatbot_support')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_support'))):__('Help', 'wpchatbot')); ?>" ></a></li>
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
                            if(function_exists('qcpd_wpwc_addon_lang_init')){
                                do_action('qcld_wpwc_template_bottom_icon_woocommerce', $cart_items_number);
                            }

                        ?>

                        <?php if(get_option('enable_wp_chatbot_disable_chaticon')!='1'): ?>
                        <li class="wp-chatbot-operation-active"><a class="wp-chatbot-operation-option" data-option="chat" href="" title="<?php echo (get_option('qlcd_wp_chatbot_skip_conversation')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_skip_conversation'))):'Click this button to skip the conversation'); ?>" ></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!--wp-chatbot-tab-nav-->
            </div>
            <!--wp-chatbot-footer-->
        </div>
<!--        wp-chatbot-board-container-->
    </div>
</div>
