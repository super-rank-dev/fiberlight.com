<?php if(get_option('enable_wp_chatbot_custom_color')==1 &&  get_option('wp_chatbot_theme_primary_color') && get_option('wp_chatbot_theme_primary_color')!=''): ?>

<?php endif; ?>
<?php if(get_option('enable_wp_chatbot_custom_color')==1 &&  get_option('wp_chatbot_theme_secondary_color') && get_option('wp_chatbot_theme_secondary_color')!=''): ?>

<?php endif; ?>
<div id="wp-chatbot-ball-container"  class=" wp-chatbot-<?php echo esc_html($qcld_wb_chatbot_theme);?>" aria-haspopup aria-live="polite" aria-expanded="false">
    <div class="wpbot-saas-live-chat" >
  
    </div>
    <div class="wp-chatbot-container">
        <?php 
            if(function_exists('qcpd_wpwc_addon_lang_init')){
                do_action('qcld_wpwc_product_details_woocommerce');
            }

        ?>
        <!--        wp-chatbot-product-container-->
        <div id="wp-chatbot-board-container" class="wp-chatbot-board-container">

            
                <?php 
                    if( function_exists( 'qcld_wpbotml' ) && count( qcld_wpbotml()->languages ) > 1){
                        ?>
                        <div class="wp-chatbot-header">
                        <?php
                        do_action('ml_render_lan_dropdown');
                        ?>
                        </div>
                        <?php
                    }
                ?>
            
            <!--wp-chatbot-header-->
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
                    <input id="wp-chatbot-editor" class="wp-chatbot-editor" required placeholder="<?php echo qcld_wpb_randmom_message_handle(@maybe_unserialize(get_option('qlcd_wp_chatbot_send_a_msg'))); ?>"
                           >
                           <?php do_action('wpbot_voice_icon'); ?>
                    <button type="button" id="wp-chatbot-send-message" class="wp-chatbot-button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </div>
                <!--wp-chatbot-editor-container-->
                <div class="wp-chatbot-tab-nav">

					<ul>
						<li class="wp-chatbot-operation-active">
							<a class="wp-chatbot-operation-option wp-chatbot-tpl-4-chat-trigger" data-option="chat" href="">CHAT</a>
						</li>
                        <?php if(get_option('enable_wp_chatbot_disable_helpicon')!='1'): ?>
                        <li><a class="wp-chatbot-operation-option" data-option="help" href="" title="<?php echo (get_option('qlcd_wp_chatbot_help')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_help'))):__('Help', 'wpchatbot')); ?>"></a></li>
                        <?php endif; ?>
                        
                        <?php if(get_option('enable_wp_chatbot_disable_supporticon')!='1'): ?>
                        <li><a class="wp-chatbot-operation-option" data-option="support"  href="" title="<?php echo (get_option('qlcd_wp_chatbot_support')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_support'))):__('Support', 'wpchatbot')); ?>"></a></li>
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
                    </ul>
                </div>
                <!--wp-chatbot-tab-nav-->
            </div>
            <!--wp-chatbot-footer-->
        </div>
        <!--        wp-chatbot-board-container-->
    </div>
</div>


<?php 
$script = "jQuery(document).ready(function () {

    jQuery('body').on('click', function (event) {
        if (jQuery(event.target).hasClass('wp-chatbot-tpl-4-chat-trigger') || jQuery(event.target).hasClass('wp-chatbot-editor')) {
            if (jQuery(event.target).hasClass('wp-chatbot-tpl-4-chat-trigger')){ event.preventDefault();}
            jQuery('.wp-chatbot-tab-nav').hide();
            jQuery('.slimScrollDiv').show();
            
        } else {
            jQuery('.wp-chatbot-tab-nav').show();
            jQuery('.slimScrollDiv').show();
        }
    });

    jQuery('body').on('click', '.wp-chatbot-tab-nav ul li a', function (event) {
        jQuery('.slimScrollDiv').show();
    });


    jQuery(document).on('click', '#wp-chatbot-ball', function () {

        if(jQuery(this).hasClass('chat_active')){
            jQuery('#wp-chatbot-chat-container').css({
                    'transform': 'translateX(274px)'
            })
            jQuery(this).removeClass('chat_active');
        }else{
            jQuery('#wp-chatbot-chat-container').css({
                'transform': 'translateX(0px)'
            })
            jQuery(this).addClass('chat_active');
        }
        setTimeout(function(){
            wp_fbicon_position();
            jQuery('.slimScrollDiv').show();
        },1000)
        
    })

    setTimeout(function () {
        if(jQuery('#wp-chatbot-ball').length>0){
        
            var pos = jQuery('#wp-chatbot-ball').offset();
            
            jQuery('.fb_dialog').css({
                'left': parseInt(parseInt(pos.left) - 30) + 'px',
                'top': parseInt(parseInt(pos.top) + 10) + 'px',
                'visibility': 'visible'
            });

            jQuery('.fb_dialog_content iframe').css({
				'left': parseInt(parseInt(pos.left) - 30) + 'px',
                'top': parseInt(parseInt(pos.top) + 10) + 'px',
			});
            
        }
    }, 3030);

});

function wp_fbicon_position(){
    if(jQuery('#wp-chatbot-ball').length>0){
        
        var pos = jQuery('#wp-chatbot-ball').offset();
        
        jQuery('.fb_dialog').css({
            'left': parseInt(parseInt(pos.left) - 30) + 'px',
            'top': parseInt(parseInt(pos.top) + 10) + 'px',
            'visibility': 'visible'
        });

        jQuery('.fb_dialog_content iframe').css({
				'left': parseInt(parseInt(pos.left) - 30) + 'px',
                'top': parseInt(parseInt(pos.top) + 10) + 'px',
			});
        
    }

}
";
wp_add_inline_script( 'qcld-wp-chatbot-front-js', $script ); 
?>