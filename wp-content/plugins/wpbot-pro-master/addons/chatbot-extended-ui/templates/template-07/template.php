<?php if(get_option('enable_wp_chatbot_custom_color')==1 && get_option('wp_chatbot_theme_primary_color') && get_option('wp_chatbot_theme_primary_color')!=''): ?>
<style>
.wp-bot-header {
    background: <?php echo get_option('wp_chatbot_theme_primary_color') ?> !important;
}
</style>
<?php endif; ?>
<?php if(get_option('enable_wp_chatbot_custom_color')==1 && get_option('wp_chatbot_theme_secondary_color') && get_option('wp_chatbot_theme_secondary_color')!=''): ?>
<style>
button.wp-chatbot-button {

	background-color: <?php echo get_option('wp_chatbot_theme_secondary_color') ?> !important;
}
</style>

<?php endif; ?>
<div id="wp-chatbot-ball-container" class="wp-chatbot-template-01">
  <?php do_action('render_start_menu'); ?>
  <div class="wpbot-saas-live-chat"> </div>
  <div class="wp-chatbot-container">
    <?php 
            if(function_exists('qcpd_wpwc_addon_lang_init')){
                do_action('qcld_wpwc_product_details_woocommerce');
            }
			if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') == "custom-agent.png") {
				$wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_agent_path');
			} else if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') != "custom-agent.png") {
				$wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
			} else {
				$wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
			}
        ?>
    <div id="wp-chatbot-board-container" class="wp-chatbot-board-container">
      <div class="wp-bot-header">
        <div class="wp-bot-header-title"><span><img src="<?php echo $wp_chatbot_custom_icon_path; ?>" /></span><span class="wp-bot-header-title-text"><?php echo (get_option('qlcd_wp_chatbot_chat_with_us')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_chat_with_us'))):'Chat with us!') ?></span></div>
        <div class="wp-bot-burger-menu-icon">
          <div class="menu__container">
            
			
			<div id="menuTrigger" class="menu__burger"> <span class="bars"></span> <span class="bars"></span> <span class="bars"></span> <span class="bars"></span> </div>
			
			
            <div id="menuItems" class="menu__items">

              <div class="wp-chatbot-template-07-integration-buttons">

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

              <?php if (get_option('enable_wp_chatbot_floating_livechat') == 1 && get_option('enable_wp_chatbot_floating_livechat') != "") { ?>
              <?php if(get_option('wp_custom_icon_livechat')!=''): ?>
                          <a href="#" id="wpbot_live_chat_floating_btn" title="Live Chat" style="background:url(<?php echo get_option('wp_custom_icon_livechat'); ?>)"></a>
                          

              <?php else: ?>
              <a href="#" id="wpbot_live_chat_floating_btn" title="Live Chat"><i class="fa fa-commenting" aria-hidden="true"></i></a>
              <?php endif; ?>
                  <?php } ?>


                  <?php if (get_option('enable_wp_chatbot_floating_link') == 1 && get_option('qlcd_wp_chatbot_weblink') != "") { ?>
                      <a href="<?php echo esc_url(get_option('qlcd_wp_chatbot_weblink')); ?>" target="_blank"><span
                                  class="intergration-weblink" title="<?php echo esc_html__('Web Link', 'wpchatbot'); ?>"></span></a>
                  <?php } ?>
              </div>
              </div>

            </div>
          </div>
        </div>
        <div class="wp-bot-header-close-icon">
           
          <div class="wp-chatbot-header">
          <?php do_action('render_back_to_menu_button'); ?>
          <?php if ( qcld_wpbot_is_active_chat_history() === true ): ?>
          <div id="wp-chatbot-email-transcript" title="<?php echo( esc_html__( 'Send me the transcript via email.' ) ); ?>"><i class="fa fa-envelope" aria-hidden="true"></i></div>
          <?php endif; ?>
          <div id="wp-chatbot-desktop-close"><i class="fa fa-times" aria-hidden="true"></i></div>
            <div id="wp-chatbot-desktop-reload"><i class="fa fa-refresh" aria-hidden="true"></i></div>
            <?php 
                if( function_exists( 'qcld_wpbotml' ) && count( qcld_wpbotml()->languages ) > 1){
                    do_action('ml_render_lan_dropdown');
                }
            ?>
          </div>
          
        </div>
      </div>
      <div class="wp-chatbot-ball-inner wp-chatbot-content"> 
        
        <!-- only show on Mobile app -->
        <?php if(isset($template_app) && $template_app=='yes'){?>
        <div class="wp-chatbot-cart-checkout-wrapper">
          <div id="wp-chatbot-cart-short-code"> </div>
          <div id="wp-chatbot-checkout-short-code"> </div>
        </div>
        <?php } ?>
        <div class="wp-chatbot-messages-wrapper">
          <ul id="wp-chatbot-messages-container" class="wp-chatbot-messages-container">
          </ul>
        </div>
      </div>
      <div class="wp-chatbot-footer">
        <div id="wp-chatbot-editor-container" class="wp-chatbot-editor-container">
          <input id="wp-chatbot-editor" class="wp-chatbot-editor" required placeholder="<?php echo qcld_wpb_randmom_message_handle(unserialize(get_option('qlcd_wp_chatbot_send_a_msg'))); ?>"
                           >
          <button type="button" id="wp-chatbot-send-message" class="wp-chatbot-button"><?php echo esc_html__('send', 'wpchatbot'); ?></button>
        </div>
        <!--wp-chatbot-editor-container-->
        <?php if(get_option('enable_wp_chatbot_disable_allicon')!='1'): ?>
        <div class="wp-chatbot-tab-nav">
          <ul>
            <?php if(get_option('enable_wp_chatbot_disable_helpicon')!='1'): ?>
            <li><a class="wp-chatbot-operation-option" data-option="help" href="" title="<?php echo esc_html__('Help', 'wpchatbot'); ?>"></a></li>
            <?php endif; ?>
            <?php if(get_option('enable_wp_chatbot_disable_supporticon')!='1'): ?>
            <li><a class="wp-chatbot-operation-option" data-option="support"  href="" title="<?php echo esc_html__('Support', 'wpchatbot'); ?>"></a></li>
            <?php endif; ?>
            <?php $data = get_option('wbca_options'); ?>
            <?php if(qcld_wpbot_is_active_livechat()==true): ?>
            <?php if(isset($data['disable_livechat_operator_offline']) && $data['disable_livechat_operator_offline'] == true): ?>
            <?php if(qcld_wpbot_is_operator_online() == 1 && isset($data['disable_livechat_opration_icon']) && $data['disable_livechat_opration_icon']!='1'): ?>
            <li><a class="wp-chatbot-operation-option" data-option="live-chat"  href="" title="<?php echo esc_html__('Livechat', 'wpchatbot'); ?>"></a></li>
            <?php endif; ?>
            <?php else: ?>
            <?php if(isset($data['disable_livechat_opration_icon']) && $data['disable_livechat_opration_icon']!='1'): ?>
            <li><a class="wp-chatbot-operation-option" data-option="live-chat"  href="" title="<?php echo esc_html__('Livechat', 'wpchatbot'); ?>"></a></li>
            <?php endif; ?>
            <?php endif; ?>
            <?php endif; ?>
            <?php 
                            if(function_exists('qcpd_wpwc_addon_lang_init')){
                                do_action('qcld_wpwc_template_bottom_icon_woocommerce', $cart_items_number);
                            }

                        ?>
            <?php if(get_option('enable_wp_chatbot_disable_chaticon')!='1'): ?>
            <li class="wp-chatbot-operation-active"><a class="wp-chatbot-operation-option" data-option="chat" href="" title="<?php echo (get_option('qlcd_wp_chatbot_skip_conversation')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_skip_conversation'))):'Click this button to skip the conversation'); ?>"></a></li>
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
<script>

jQuery(document).ready(function($){
  $("#wp-chatbot-ball").on('click', function(){
    $(".wp-chatbot-container").animate({left: '-340px'});
	
  });
  
  jQuery(document).on('click', 'body', function(e){
	  if(e.target.id!='menuTrigger'){
			jQuery('#menuTrigger').removeClass('active');
			jQuery('#menuItems').removeClass('active');
	  }
  })
  
});


const menuTrigger = document.getElementById("menuTrigger");
const menuItems = document.getElementById("menuItems");

menuTrigger.addEventListener('click', () => {
  menuTrigger.classList.toggle('active');
  menuItems.classList.toggle('active');
})

</script>