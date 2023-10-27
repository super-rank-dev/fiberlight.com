<?php
wp_head();
?>
<style type="text/css">
body{
    background: transparent;
}
.wbcaTitle{
    height: 30px;
}
#wpadminbar{display:none}
#wp-chatbot-chat-container{right: 15px !important;
    bottom: 15px !important;}
</style>


        <?php if(get_option('wp_chatbot_custom_css')!=""){

        wp_add_inline_style( 'qcld-wp-chatbot-common-style', get_option('wp_chatbot_custom_css') );
        } ?>

        <?php if (get_option('qcld_wb_chatbot_change_bg') == 1) {
            if (get_option('qcld_wb_chatbot_board_bg_path') != "") {
                $qcld_wb_chatbot_board_bg_path = get_option('qcld_wb_chatbot_board_bg_path');
            } else {
                $qcld_wb_chatbot_board_bg_path = QCLD_wpCHATBOT_IMG_URL . 'background/background.png';
            }
            ?>

            <?php 
            $custom_css = ".wp-chatbot-container {
                background-image: url(". esc_url($qcld_wb_chatbot_board_bg_path).") !important;
            }";
            wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_css );
            ?>

        <?php }
        $wp_chatbot_enable_rtl = "";
        if (get_option('enable_wp_chatbot_rtl')) {
            $wp_chatbot_enable_rtl .= "wp-chatbot-rtl";
        }
        $wp_chatbot_enable_mobile_screen = "";
        if (get_option('enable_wp_chatbot_mobile_full_screen')==1 ) {
            $wp_chatbot_enable_mobile_screen .= "wp-chatbot-mobile-full-screen";
        }
        ?>
        <div id="wp-chatbot-chat-container" class="<?php echo esc_html($wp_chatbot_enable_rtl) .' '.esc_html($wp_chatbot_enable_mobile_screen); ?>">
            <div id="wp-chatbot-integration-container">
                <div class="wp-chatbot-integration-button-container">
                    <?php if (get_option('enable_wp_chatbot_skype_floating_icon') == 1) { ?>
                        <a href="skype:<?php echo get_option('enable_wp_chatbot_skype_id'); ?>?chat"><span
                                    class="inetegration-skype-btn" title="<?php echo esc_html__('Skype', 'wpchatbot'); ?>"> </span></a>
                    <?php } ?>
                    <?php if (get_option('enable_wp_chatbot_floating_whats') == 1) { ?>
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
					
					<?php if (get_option('enable_wp_chatbot_floating_livechat') == 1 && get_option('enable_wp_chatbot_floating_livechat') != "") { 
                         ?>
						<?php if(get_option('wp_custom_icon_livechat')!=''):
                        
                                if(isset($data['disable_livechat_opration_icon']) && (!$data['disable_livechat_opration_icon']) ):
                                    if(qcld_wpbot_is_operator_online() >= 1 ):
                             ?> 
                            <a href="#" id="wpbot_live_chat_floating_btn" title="Live Chat" style="background:url(<?php echo get_option('wp_custom_icon_livechat'); ?>)" ></a>
                            
                            <?php
                                $custom_css  ="#wpbot_live_chat_floating_btn {
                                    background:url(".get_option('wp_custom_icon_livechat').");
                                }";
                                wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_css );
                            ?>

						<?php       endif;
                                endif;
                            else: 
                                if(isset($data['disable_livechat_opration_icon']) && (!$data['disable_livechat_opration_icon']) ):
                                    if(qcld_wpbot_is_operator_online() >= 1 && isset($data['disable_livechat_operator_offline']) && ($data['disable_livechat_operator_offline'])):
                                  
                            ?>

							<a href="#" id="wpbot_live_chat_floating_btn" title="Live Chat"><i class="fa fa-commenting" aria-hidden="true"></i></a>
						<?php
                                    endif;
                                endif;
                            endif; 
                        ?>
                    <?php } ?>
					
					
                    <?php if (get_option('enable_wp_chatbot_floating_link') == 1 && get_option('qlcd_wp_chatbot_weblink') != "") { ?>
                        <a href="<?php echo esc_url(get_option('qlcd_wp_chatbot_weblink')); ?>" target="_blank"><span
                                    class="intergration-weblink" title="<?php echo esc_html__('Web Link', 'wpchatbot'); ?>"></span></a>
                    <?php } ?>
                </div>
            </div>
            <?php
            
            global $woocommerce;
            
            $qcld_wb_chatbot_theme = get_option('qcld_wb_chatbot_theme');
            if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/template-01/style.css')) {
                wp_register_style('qcld-wp-chatbot-style', QCLD_wpCHATBOT_PLUGIN_URL . 'templates/template-01/style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                wp_enqueue_style('qcld-wp-chatbot-style');



            }
            if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/template-01/template.php')) {
                require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/template-01/template.php');
                echo '<script type="text/javascript">var iframe_exists = "yes";</script>';
                echo '<style type="text/css">#wp-chatbot-chat-container span.qcld-chatbot-custom-intent[data-text=staff], #wp-chatbot-chat-container span.qcld-chatbot-custom-intent[data-text=livechat] {display: none;}.wp-chatbot-board-container{width: 370px !imporant;}</style>';
            } else {
                echo "<h2>" . esc_html__('No wpWBot Theme Found!', 'wpchatbot') . "</h2>";
            }
            ?>
            <?php
				
            if (get_option('disable_wp_chatbot_notification') != 1) {
                ?>
                <div id="wp-chatbot-notification-container" class="wp-chatbot-notification-container">
                    <div class="wp-chatbot-notification-controller"> <span class="wp-chatbot-notification-close">
      <?php echo esc_html__('X', 'wpchatbot'); ?>
      </span></div>
                    <?php
                    $testingTip="";
                    if (get_option('wp_chatbot_agent_image') == "custom-agent.png") {
                        $wp_chatbot_custom_agent_path = get_option('wp_chatbot_custom_agent_path');
                    } else if (get_option('wp_chatbot_agent_image') != "custom-agent.png") {
                        $wp_chatbot_custom_agent_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
                    } else {
                        $wp_chatbot_custom_agent_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
                    }
                    ?>
                    <div class="wp-chatbot-notification-agent-profile">
                        <div class="wp-chatbot-notification-widget-avatar" ><img
                                    src="<?php echo esc_url($wp_chatbot_custom_agent_path); ?>" alt=""></div>
                        <div class="wp-chatbot-notification-welcome"><?php echo qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_welcome'))) . ' <strong>' . get_option('qlcd_wp_chatbot_host') . '</strong>'; ?></div>
                    </div>
                    <?php 
					
					$notifications = qcld_wb_chatbot_func_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_notifications'))); 
					
					?>
					
                    <div class="wp-chatbot-notification-message"><?php echo esc_html($notifications[0]); ?></div>
                </div>
            <?php } ?>

            <?php 
            if (class_exists('WooCommerce')){
                global $woocommerce;
                $cart_items_number = $woocommerce->cart->cart_contents_count;
            }else{
                $cart_items_number='';
            }
            ?>
            <!--wp-chatbot-board-container-->
            <div id="wp-chatbot-ball" class="">
                <div class="wp-chatbot-ball">
                    <div class="wp-chatbot-ball-animator wp-chatbot-ball-animation-switch"></div>
                    <?php
                    if (get_option('wp_chatbot_icon') == "custom.png") {
                        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_icon_path');
                    } else if (get_option('wp_chatbot_icon') != "custom.png") {
                        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_icon');
                    } else {
                        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom.png';
                    }
                    ?>
                    <img src="<?php echo esc_url($wp_chatbot_custom_icon_path); ?>"
                         alt="wpChatIcon" qcld_agent="<?php echo esc_url($wp_chatbot_custom_icon_path); ?>">

                    <?php 
                        if(function_exists('qcpd_wpwc_addon_lang_init')){
                            do_action('qcld_wpwc_cart_item_number_woocommerce', $cart_items_number);
                        }

                    ?>
                    
                </div>
            </div>
            <?php do_action('qcld_wpbot_floating_button'); ?>
            <?php
            $fb_app_id = get_option('qlcd_wp_chatbot_fb_app_id');
            $fb_page_id = get_option('qlcd_wp_chatbot_fb_page_id');
            $fb_mgs_color = get_option('qlcd_wp_chatbot_fb_color') != '' ? get_option('qlcd_wp_chatbot_fb_color') : '#0084ff';
            $fb_mgs_in = get_option('qlcd_wp_chatbot_fb_in_msg') != '' ? get_option('qlcd_wp_chatbot_fb_in_msg') : 'You are welcome';
            $fb_mgs_out = get_option('qlcd_wp_chatbot_fb_out_msg') != '' ? get_option('qlcd_wp_chatbot_fb_out_msg') : 'You are not logged in';
            if (get_option('enable_wp_chatbot_messenger') == 1 && get_option('enable_wp_chatbot_messenger_floating_icon') == 1) {
                ?>
                <!--                wp-chatbot-board-container-->


                <?php 
                $script = "window.fbAsyncInit = function () {
                    FB.init({
                        appId: '".esc_html($fb_app_id)."',
                        autoLogAppEvents: true,
                        xfbml: true,
                        version: 'v2.12'
                    });
                };
                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = '".esc_url('https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js')."';
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
                ";
                wp_add_inline_script( 'qcld-wp-chatbot-front-js', $script ); 
                ?>


                <div class="fb-customerchat"
                     page_id="<?php echo esc_attr($fb_page_id); ?>"
                     greeting_dialog_display="hide"
                     theme_color="<?php echo esc_attr($fb_mgs_color); ?>"
                     logged_in_greeting="<?php echo esc_attr($fb_mgs_in); ?>"
                     logged_out_greeting="<?php echo esc_attr($fb_mgs_out); ?>"></div>
                <?php
            }
            ?>
            <!--container-->
            <!--wp-chatbot-ball-wrapper-->
        </div>
        <audio id="wp-chatbot-proactive-audio" <?php if (get_option('enable_wp_chatbot_sound_initial') == 1) {
            echo "autoplay";
        } ?>>
            <source src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'pro-active.mp3'); ?>">
            </source>
        </audio>

<?php 
$script1 = "var insideIframe = true";
wp_add_inline_script( 'qcld-wp-chatbot-front-js', $script1 ); 
?>

<style type="text/css">
html{
background: unset !important;
background-color: unset !important;
}
#moove_gdpr_cookie_info_bar.moove-gdpr-dark-scheme{
    display: none !important;
}
</style>

<?php
wp_footer();
?>