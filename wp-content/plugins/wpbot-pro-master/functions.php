<?php
/**
 * @param $type
 * Display wpwBot Icon ball
 */
if (!defined('ABSPATH')) exit; // Exit if accessed directly
add_action('wp_footer', 'qcld_wp_chatbot_load_footer_html');
function qcld_wp_chatbot_load_footer_html(){
	
    global $post;
    /**
     * Detect plugin. For frontend only.
     */
    include_once ABSPATH . 'wp-admin/includes/plugin.php';

    $pattern = get_shortcode_regex();
    $shortcodetemplate = '';
	if(is_object($post)){
		if (   preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
			&& array_key_exists( 2, $matches )
			&& in_array( 'wpwbot', $matches[2] )
		) {
			if(isset($matches[3]) && count($matches[3])==1){

				if (isset($matches[3][0]) && strpos($matches[3][0], 'template=') !== false) {
					$shortcodetemplate = str_replace('=','-', $matches[3][0]);
				}

			}

		}
	}
    
    $qcld_wb_chatbot_theme = get_option('qcld_wb_chatbot_theme');
    if($shortcodetemplate!=''){
        $qcld_wb_chatbot_theme = trim($shortcodetemplate);
        echo '<script type="text/javascript">var wpbotshortcodetemplate = "'. $qcld_wb_chatbot_theme .'"</script>';
    }

    if ((get_option('disable_wp_chatbot') != 1 && qcld_wp_chatbot_load_controlling() == true) || trim($shortcodetemplate)!='') {

        ?>
        
        <?php if (get_option('qcld_wb_chatbot_change_bg') == 1) {

            if (get_option('qcld_wb_chatbot_board_bg_path') != "") {
                $qcld_wb_chatbot_board_bg_path = get_option('qcld_wb_chatbot_board_bg_path');
            } else {
                $qcld_wb_chatbot_board_bg_path = QCLD_wpCHATBOT_IMG_URL . 'background/background.png';
            }
            ?>
            <?php

                if($qcld_wb_chatbot_theme=='template-04' || $qcld_wb_chatbot_theme=='template-01' || $qcld_wb_chatbot_theme=='template-00'){
                    $custom_css  =".wp-chatbot-container {                        
                        border-radius: 6px;
                    }
                    .wp-chatbot-content{
                        background: url(".esc_url($qcld_wb_chatbot_board_bg_path).") no-repeat top center !important;
                        background-size: cover !important;
                        border-radius: 5px 5px 0px 0px;
                    }
                    ";
                }else{
                    $custom_css  =".wp-chatbot-container {
                        background-image: url(".esc_url($qcld_wb_chatbot_board_bg_path).") !important;
                        
                    }";
                }

                echo '<style type="text/css">'.$custom_css.'</style>';
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
        if(get_option('disable_wp_chatbot_floating_icon')==1){
            $hide_class = 'wpbot_hide_floating_icon';
        }else{
            $hide_class = '';
        }
        
        $data = get_option('wbca_options');

        ?>
        <div id="wp-chatbot-chat-container" class="floatingbot_delay <?php echo esc_html($wp_chatbot_enable_rtl) .' '.esc_html($wp_chatbot_enable_mobile_screen).' '.esc_attr($hide_class); ?> qcchatbot-<?php echo esc_html($qcld_wb_chatbot_theme);?>" style="display:none">

            <div id="<?php echo ($qcld_wb_chatbot_theme=='template-07'?'wp-chatbot-integration-container-07':'wp-chatbot-integration-container'); ?>">

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
					
					
                    <?php if (get_option('enable_wp_chatbot_floating_phone') == 1 && get_option('qlcd_wp_chatbot_phone') != "") {  ?>
                        <a href="tel:<?php echo get_option('qlcd_wp_chatbot_phone'); ?>"><span
                                    class="intergration-phone"
                                    title="<?php echo esc_html__('Phone', 'wpchatbot'); ?>"> </span></a>
                    <?php } ?>
					
					<?php if (get_option('enable_wp_chatbot_floating_livechat') == 1 && get_option('enable_wp_chatbot_floating_livechat') != "") {
                        $data = get_option('wbca_options');
                        if(isset($data['disable_livechat_opration_icon']) && (!$data['disable_livechat_opration_icon']) ):
                            if( (qcld_wpbot_is_operator_online() >= 1)):
                    ?>
						<?php if(get_option('wp_custom_icon_livechat')!=''): ?>
                            <a href="#" id="wpbot_live_chat_floating_btn" title="Live Chat" style="background:url(<?php echo get_option('wp_custom_icon_livechat'); ?>)"></a>
                            

						<?php else: ?>
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

                    <?php if( $qcld_wb_chatbot_theme != 'template-05' ): ?>
                    <?php if (get_option('enable_wp_chatbot_voice_message') == 1 && (is_plugin_active( 'voice-message-addon/wpbotvoicemessage.php' ) || (in_array( "WPBot Voice Module",get_option( 'wpbot_master_addons')['active'])) ) ) { ?>
                        <a href="#" id="wpbot_voice_message_floating_btn" class="wpbd_voice_message" title="Voice Message" style="background:url('<?php echo QCLD_wpCHATBOT_PLUGIN_URL.'images/microphone.png'; ?>')" ></a>
                    <?php } ?>
                    <?php endif; ?>

                </div>
            </div>
            <?php
            
            if (class_exists('WooCommerce')){
                global $woocommerce;
                $cart_items_number = $woocommerce->cart->cart_contents_count;
            }else{
                $cart_items_number='';
            }
            
            //check extended ui is installed then load template from addon.
            if(qcld_wpbot_is_extended_ui_activate() && ($qcld_wb_chatbot_theme=='template-07' || $qcld_wb_chatbot_theme=='template-06' || $qcld_wb_chatbot_theme=='template-08')){
                
                if (file_exists(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/style.css')) {
                    wp_register_style('qcld-wp-chatbot-style', qcld_chatbot_eui_root_url . 'templates/' . $qcld_wb_chatbot_theme . '/style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                    wp_enqueue_style('qcld-wp-chatbot-style');
                }
                
                if (file_exists(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/template.php')) {
                    require_once(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/template.php');
                } else {
                    echo "<h2>" . esc_html__('No wpWBot dd Theme Found!', 'wpchatbot') . "</h2>";
                }
            }else{
                // Default template loading path
                if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/style.css')) {
                    wp_register_style('qcld-wp-chatbot-style', QCLD_wpCHATBOT_PLUGIN_URL . 'templates/' . $qcld_wb_chatbot_theme . '/style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                    wp_enqueue_style('qcld-wp-chatbot-style');
                }
                if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php')) {
                    require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php');
                } else {
                    echo "<h2>" . esc_html__('No wpWBot Theme Found!', 'wpchatbot') . "</h2>";
                }
            }

            ?>
            <?php
			
            if (get_option('disable_wp_chatbot_notification') != 1 ) {
				if(qcld_wp_chatbot_is_mobile() && get_option('disable_wp_chatbot_notification_mobile') == 1){
					
				}else{
                ?>
                 <?php 
					
                $notification_intent = qcld_wb_chatbot_func_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_notifications_intent'))); 
                
                ?>
                
                <div id="wp-chatbot-notification-container" class="wp-chatbot-notification-container " <?php echo (isset($notification_intent[0]) && $notification_intent[0]!=''?'data-intent="'.$notification_intent[0].'"':''); ?>>
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
                        <?php 
                        $host = maybe_unserialize(get_option('qlcd_wp_chatbot_host'));
                        if( $host && is_array( $host ) && array_key_exists( get_wpbot_locale(), $host ) ){
                            $host = $host[get_wpbot_locale()];
                        }
                        ?>
                        <div class="wp-chatbot-notification-widget-avatar" ><img
                                    src="<?php echo esc_url($wp_chatbot_custom_agent_path); ?>" alt=""></div>
                        <div class="wp-chatbot-notification-welcome"><?php echo qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_welcome'))) . ' <strong>' . qcld_wpb_randmom_message_handle(maybe_unserialize($host)) . '</strong>'; ?></div>
                        
                    </div>
                    <?php 
					
					$notifications = qcld_wb_chatbot_func_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_notifications'))); 
					
					?>
					
                    <div class="wp-chatbot-notification-message"><?php echo (isset($notifications[0])?$notifications[0]:''); ?></div>
                    <?php $navnotifications = (maybe_unserialize(get_option('wpbot_notification_navigations'))); ?>
                    <?php if(!empty($navnotifications) && get_option('show_intent_navigation_notification')==1){ ?>
                    <div class="wp-chatbot-notification-navigation">
                        <?php
                        
                            foreach($navnotifications as $key=>$val){
                                echo '<span class="qcwp_notification_nav">'.$val.'</span>';
                            }
                        
                        ?>
                    </div>
                    <?php } ?>
                    <?php do_action('do_kbx_custom_buddypress_suggestion'); ?>
                </div>
            <?php }} ?>
            <!--wp-chatbot-board-container-->
            <div id="wp-chatbot-ball" class="">
                <button alt="Click to Open or Close the chat window" class="wp-chatbot-ball" title="<?php echo (get_option('qlcd_wp_chatbot_chat_with_us')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_chat_with_us'))):__('Chat with Us', 'wpchatbot')); ?>" aria-label="Click to open or close the chatbot">
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

                </button>
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
		<?php if(get_option('enable_wp_chatbot_sound_initial')==1 || get_option('enable_wp_chatbot_sound_botmessage')==1): ?>
        <audio id="wp-chatbot-proactive-audio" <?php if (get_option('enable_wp_chatbot_sound_initial') == 1){
            echo "autoplay";
        } ?>>
            <source src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'pro-active.mp3'); ?>">
            </source>
        </audio>
		<?php endif; ?>
        <?php
    }else{
        ?>

        <?php 
        $script1 = "var openingHourIsFn = 1;";
        wp_add_inline_script( 'qcld-wp-chatbot-front-js', $script1 ); 
        ?>

        <?php
    }
	
	if(get_option('wp_custom_help_icon')!=''){
	?>
    
    <?php 
    $custom_css1 = ".wp-chatbot-tab-nav ul li a[data-option=\"help\"] {
        background-position: center center !important;
        background: url(".esc_url(get_option('wp_custom_help_icon')).") no-repeat !important;
        background-size: cover !important;
    }";
	echo '<style type="text/css">'.$custom_css1.'</style>';
    wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_css1 );
    ?>

	<?php
	}
	if(get_option('wp_custom_support_icon')!=''){
	?>

    <?php 
    $custom_css2 = ".wp-chatbot-tab-nav ul li a[data-option=\"support\"] {
        background-position: center center !important;
        background: url(".esc_url(get_option('wp_custom_support_icon')).") no-repeat !important;
        background-size: cover !important;
    }";
	echo '<style type="text/css">'.$custom_css2.'</style>';
    wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_css2 );
    ?>
	<?php
	}

	if(get_option('wp_custom_chat_icon')!=''){
	?>
    
    <?php 
    $custom_css3 = ".wp-chatbot-tab-nav ul li a[data-option=\"chat\"] {
        background-position: center center !important;
        background: url(".get_option('wp_custom_chat_icon').") no-repeat !important;
        background-size: cover !important;
    }";
	echo '<style type="text/css">'.$custom_css3.'</style>';
    wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_css3 );
    ?>

	<?php
    }
    
    if(get_option('wp_custom_livechat_icon')!=''){
        
	?>
    
    <?php 
    $custom_css3 = ".wp-chatbot-tab-nav ul li a[data-option=\"live-chat\"] {
        background-position: center center !important;
        background: url(".get_option('wp_custom_livechat_icon').") no-repeat !important;
        background-size: cover !important;
    }";
	echo '<style type="text/css">'.$custom_css3.'</style>';
    wp_add_inline_style( 'qcld-wp-chatbot-common-style', $custom_css3 );
    ?>

	<?php
    }

    if ( get_transient( 'bot_clear_cache' ) ) {
        echo  '<script type="text/javascript">var wpbot_clear_cache = 1 </script>';
        delete_transient( 'bot_clear_cache' );
    }
    //

    if(get_option('skip_wp_greetings_trigger_intent')==1){
		
		if ( is_user_logged_in() ) {
			
			if( get_option('wpbot_trigger_intent_loggged_in')!='' ){
				echo  '<script type="text/javascript">var clickintent = '.json_encode(maybe_unserialize(get_option('wpbot_trigger_intent_loggged_in'))).'</script>';
			}
			
		}else{
			
			if( get_option('wpbot_trigger_intent')!='' ){
				echo  '<script type="text/javascript">var clickintent = '.json_encode(maybe_unserialize(get_option('wpbot_trigger_intent'))).'</script>';
			}
			
		}
		
        
    }
?>

<!-- The Modal -->
<div id="qcwpbotModal" class="qcwpbotmodal" style="display:none">
  <!-- The Close Button -->
  <span class="qcwpbotclose">&times;</span>
  <!-- Modal Content (The Image) -->
  <img class="qcwpbotmodal-content" id="qcwpbotimg01">
</div>
<div id="bottooltip">
  <span></span>
  <div></div>
</div>
<style type="text/css">
#bottooltip{
  border-radius: 2px;
  color: black;
  display: none;
  padding: 5px 10px;
  position: fixed;
  
  background-color: white;
  -ms-filter    : "progid:DXImageTransform.Microsoft.Dropshadow(OffX=0, OffY=2, Color='#444')";
    filter        : "progid:DXImageTransform.Microsoft.Dropshadow(OffX=0, OffY=2, Color='#444')";
  -webkit-filter: drop-shadow(0px 2px 5px rgba(130,130,130,1));
    filter        : drop-shadow(0px 2px 5px rgba(130,130,130,1));
    z-index: 99;
	max-width: 150px;
}

#bottooltip > span{
  background-color: white;
  display: inline-block;
  height: 8px;
  position: absolute;
  transform: rotate(45deg);
  width: 8px;
}

#bottooltip > div{
  font-size: 12px;
}
</style>
<?php  
	
}
//wp_chatbot load control handler.
function qcld_wp_chatbot_load_controlling(){
    $wp_chatbot_load = true;
    
    if (get_option('wp_chatbot_show_home_page') == 'off' && is_home()) {
        $wp_chatbot_load = false;
    }
    
    // && 'post' == get_post_type()
    if (get_option('wp_chatbot_show_posts') == 'off' && 'page' != get_post_type()) {
        $wp_chatbot_load = false;
    }
    
    if (get_option('wp_chatbot_show_pages') == 'off') {
        
        $wp_chatbot_select_pages = maybe_unserialize(get_option('wp_chatbot_show_pages_list'));
        if (is_page() && !empty($wp_chatbot_select_pages)) {
            if (in_array(get_the_ID(), $wp_chatbot_select_pages) == true) {
                $wp_chatbot_load = true;
            } else {
                $wp_chatbot_load = false;
            }
        }
    }
    
    if (get_option('wp_chatbot_show_woocommerce') == 'off') {
        if (is_shop() || is_cart() || is_checkout() || 'product' == get_post_type()) {
            $wp_chatbot_load = false;
        }
    }

    if (get_option('wp_chatbot_show_home_page') == 'on' && is_front_page()) {
        $wp_chatbot_load = true;
    }
    
    //Opening Hours for wpwBot.
    if (get_option('enable_wp_chatbot_opening_hour') == 1) {
        if(qcld_wp_chatbot_check_opening_hours()==false){
            $wp_chatbot_load = false;
        }else{
            $wp_chatbot_load = true;
        }
    }

	if (qcld_wp_chatbot_is_mobile() && get_option('disable_wp_chatbot_on_mobile') == 1) {
        $wp_chatbot_load = false;
    }

    if (is_page()){
        $page_id = get_the_ID();
        $exclude_pages = maybe_unserialize(get_option('wp_chatbot_exclude_pages_list'));
		if(is_array( $exclude_pages ) && ! empty( $exclude_pages ) && in_array($page_id, $exclude_pages)){
			$wp_chatbot_load = false;
		}
    }
    
	// Disable in post types
	$post_list = maybe_unserialize(get_option('wp_chatbot_exclude_post_list'));
	if( is_array( $post_list ) && in_array(get_post_type(), $post_list)){
		$wp_chatbot_load = false;
    }
    
    if (is_page('wpwbot-mobile-app')) {
		$wp_chatbot_load = false;
	}
	
	//load wpwbot shortcode template and prevent default wpwbot from footer.
    if (is_page()) {
        $page_id = get_the_ID();
        $page = get_post($page_id);
		
		if (has_shortcode($page->post_content, 'wpwbot')) {
			$wp_chatbot_load = false;
		}
		if (has_shortcode($page->post_content, 'chatbot-widget')) {
			$wp_chatbot_load = false;
		}
		if (has_shortcode($page->post_content, 'wpbot-click-chat')) {
			$wp_chatbot_load = true;
		}
		if (has_shortcode($page->post_content, 'wpbot-page')) {
			$wp_chatbot_load = false;
		}
		
    }
	
	if(is_admin()){
		$wp_chatbot_load = false;
	}
	
	if(get_option('qc_display_for_loggedin_users')==1){
		if(!is_user_logged_in()){
			$wp_chatbot_load = false;
		}
	}
	
    return $wp_chatbot_load;
}
//checking Devices
function qcld_wp_chatbot_is_mobile(){
    $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
        return true;
    } else {
        return false;
    }
}
//Checking wpwbot opening hour
function qcld_wp_chatbot_check_opening_hours(){
    $curent_day=strtolower(date('l',strtotime(current_time( 'mysql' ))));
    $current_time=date('H:i',strtotime(current_time( 'mysql')));
    $is_wpwbot_open =false;
    if(get_option('wpwbot_hours')) {
        $wpwbot_times = maybe_unserialize(get_option('wpwbot_hours'));
        if (isset($wpwbot_times[$curent_day])) {
            $day_times = $wpwbot_times[$curent_day];
            if (!empty($day_times)) {
                foreach ($day_times as $day_time) {
                    if(strtotime($current_time) > strtotime($day_time[0]) && strtotime($current_time) < strtotime($day_time[1])  ){
                        $is_wpwbot_open=true;
                    }
                }
            }
        }
    }
    return $is_wpwbot_open;
}
//wpwBot shortcode.
add_shortcode('wpwbot', 'qcld_wp_chatbot_short_code');
function qcld_wp_chatbot_short_code($atts = []){
    ob_start();
    echo '';
    $content = ob_get_clean();
    return $content;
}
//shortcode for skip greetings
add_shortcode('wpbot-skip-gretting', 'qcld_wp_chatbot_skip_gretting');
function qcld_wp_chatbot_skip_gretting($atts = []){
    ob_start();
    $content = ob_get_clean();
    return $content;
}

function qcld_wp_chatbot_shortcode_dom($atts){
    //Defaults & Set Parameters for shortcode

    extract(shortcode_atts(
        array(
            'template' => '01',
        ), $atts
    ));
    
    ?>

        <?php if(get_option('wp_chatbot_custom_css')!=""){
            
            wp_add_inline_style( 'qlcd-wp-chatbot-admin-style', get_option('wp_chatbot_custom_css') );
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
            background: url(".esc_url($qcld_wb_chatbot_board_bg_path).") no-repeat top right !important;
        }";
        wp_add_inline_style( 'qlcd-wp-chatbot-admin-style', $custom_css );
        ?>


<?php }
    
    $wp_chatbot_enable_rtl = "";
    if (get_option('enable_wp_chatbot_rtl')) {
        $wp_chatbot_enable_rtl .= "wp-chatbot-rtl";
    }
    
    ?>
    <div id="wp-chatbot-chat-container" class="<?php echo esc_html($wp_chatbot_enable_rtl); ?>">
		<div id="wp-chatbot-integration-container">
                <div class="wp-chatbot-integration-button-container">
                    <?php if (get_option('enable_wp_chatbot_skype_floating_icon') == 1) { ?>
                        <a href="skype:<?php echo esc_html(get_option('enable_wp_chatbot_skype_id')); ?>?chat"><span
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
                        <a href="tel:<?php echo esc_html(get_option('qlcd_wp_chatbot_phone')); ?>"><span
                                    class="intergration-phone"
                                    title="<?php echo esc_html__('Phone', 'wpchatbot'); ?>"> </span></a>
                    <?php } ?>
					
					<?php if (get_option('enable_wp_chatbot_floating_livechat') == 1 && get_option('enable_wp_chatbot_floating_livechat') != "") {
                            $data = get_option('wbca_options');
                            if(isset($data['disable_livechat_opration_icon']) && (!$data['disable_livechat_opration_icon']) ):
                                if(qcld_wpbot_is_operator_online() >= 1):
                            
                         ?>
						<?php if(get_option('wp_custom_icon_livechat')!=''): ?>
							<a href="#" id="wpbot_live_chat_floating_btn" title="Live Chat" style="background:url(<?php echo esc_html(get_option('wp_custom_icon_livechat')); ?>)"></a>
						<?php else: ?>
							<a href="#" id="wpbot_live_chat_floating_btn" title="Live Chat"><i class="fa fa-commenting" aria-hidden="true"></i></a>
						<?php endif; ?>
                    <?php       
                                endif;
                            endif;
                          } 
                          ?>
					
					
                    <?php if (get_option('enable_wp_chatbot_floating_link') == 1 && get_option('qlcd_wp_chatbot_weblink') != "") { ?>
                        <a href="<?php echo esc_url(get_option('qlcd_wp_chatbot_weblink')); ?>" target="_blank"><span
                                    class="intergration-weblink" title="<?php echo esc_html__('Web Link', 'wpchatbot'); ?>"></span></a>
                    <?php } ?>
                </div>
            </div>
        <?php
        
        global $woocommerce;
        $cart_items_number = $woocommerce->cart->cart_contents_count;

        $qcld_wb_chatbot_theme = 'template-' . $template;

        

        //check extended ui is installed then load template from addon.
        if(qcld_wpbot_is_extended_ui_activate() && ($qcld_wb_chatbot_theme=='template-07' || $qcld_wb_chatbot_theme=='template-06')){
            if (file_exists(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/style.css')) {
                wp_register_style('qcld-wp-chatbot-style', qcld_chatbot_eui_root_url . 'templates/' . $qcld_wb_chatbot_theme . '/style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                wp_enqueue_style('qcld-wp-chatbot-style');
            }

            if (file_exists(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/template.php')) {
                require_once(qcld_chatbot_eui_root_path . '/templates/' . $qcld_wb_chatbot_theme . '/template.php');
            } else {
                echo "<h2>" . esc_html__('No wpWBot Theme Found!', 'wpchatbot') . "</h2>";
            }
        }else{
            // Default template loading path
            if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/style.css')) {
                wp_register_style('qcld-wp-chatbot-style', QCLD_wpCHATBOT_PLUGIN_URL . 'templates/' . $qcld_wb_chatbot_theme . '/style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                wp_enqueue_style('qcld-wp-chatbot-style');
            }

            if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php')) {
                require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php');
            } else {
                echo "<h2>" . esc_html__('No wpWBot Theme Found!', 'wpchatbot') . "</h2>";
            }
        }

        ?>
        <?php if (get_option('disable_wp_chatbot') != 1): ?>
            <div id="wp-chatbot-notification-container" class="wp-chatbot-notification-container">
                <div class="wp-chatbot-notification-controller"> <span class="wp-chatbot-notification-close">X</span> </div>
                <?php
                if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') == "custom-agent.png") {
                    $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_agent_path');
                } else if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') != "custom-agent.png") {
                    $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
                } else {
                    $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
                }
                ?>
                <div class="wp-chatbot-notification-agent-profile">
                        <?php 
                        $host = maybe_unserialize(get_option('qlcd_wp_chatbot_host'));
                        if( $host && is_array( $host ) && array_key_exists( get_wpbot_locale(), $host ) ){
                            $host = $host[get_wpbot_locale()];
                        }
                        ?>
                    <div class="wp-chatbot-notification-widget-avatar"><img
                                src="<?php echo esc_html($wp_chatbot_custom_icon_path); ?>" alt=""></div>
                    <div class="wp-chatbot-notification-welcome"><?php echo qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_welcome'))) . ' <strong>' . $host . '</strong>'; ?></div>
                </div>
                <div class="wp-chatbot-notification-message"><?php echo qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_notifications'))); ?></div>
            </div>
            <!--wp-chatbot-board-container-->
            <div id="wp-chatbot-ball" class="">
                <div class="wp-chatbot-ball">
                    <div class="wp-chatbot-ball-animator wp-chatbot-ball-animation-switch"></div>
                    <?php
                    if (get_option('wp_chatbot_custom_icon_path') != "" && get_option('wp_chatbot_icon') == "custom.png") {
                        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_icon_path');
                    } else if (get_option('wp_chatbot_custom_icon_path') != "" && get_option('wp_chatbot_icon') != "custom.png") {
                        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_icon');
                    } else {
                        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom.png';
                    }
                    ?>
                    <img src="<?php echo esc_url($wp_chatbot_custom_icon_path); ?>"
                         alt="wpChatIcon"> </div>
            </div>
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
            <!--                wp-chatbot-board-container-->
        <?php endif; ?>
        <!--container-->
        <!--wp-chatbot-ball-wrapper-->
    </div>
<?php } ?>
<?php
//Create shortcode for wpwBot for pages.
add_shortcode('wpbot-page', 'qcld_wp_chatbot_page_short_code');
function qcld_wp_chatbot_page_short_code($atts = array()){

    extract( shortcode_atts(
		array(
            'intent' => '',
            'dark_design' => ''
		), $atts
    ));
    ob_start();
    qcld_wp_chatbot_page_dom($intent,$dark_design);
    $content = ob_get_clean();
    return $content;
}


function qcld_wp_chatbot_page_dom($intent,$dark_design){ ?>
    
        <?php if(get_option('wp_chatbot_custom_css')!=""){

            wp_add_inline_style( 'qcld-wp-chatbot-common-style', get_option('wp_chatbot_custom_css') );
    } ?>
    <?php
    //Get woocommerce cart
    global $woocommerce;
    $cart_items_number = isset( $woocommerce->cart->cart_contents_count ) ? $woocommerce->cart->cart_contents_count: 0;
    $qcld_wb_chatbot_theme = get_option('qcld_wb_chatbot_theme');
    $wp_chatbot_enable_rtl = "";
    echo  '<script type="text/javascript">var pclickintent = "'.$intent.'"</script>';
    if (get_option('enable_wp_chatbot_rtl') == 1) {
        $wp_chatbot_enable_rtl .= "wp-chatbot-rtl";
    }
    
    if($qcld_wb_chatbot_theme=='template-06' || $qcld_wb_chatbot_theme=='template-07' || $qcld_wb_chatbot_theme=='template-08'){
        $qcld_wb_chatbot_theme = 'template-01';
    }
	
	
	if(($dark_design !='') && ($dark_design == 'true')){
            require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/bot-on-dark/shortcode.php');
            wp_register_style('qcld-wp-chatbot-shortcode-dark-style', QCLD_wpCHATBOT_PLUGIN_URL . 'templates/bot-on-dark/shortcode.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qcld-wp-chatbot-shortcode-dark-style');
    }else{
        $f_path = QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/shortcode.php';
        $f_path = wp_normalize_path( $f_path );
		$f_path = str_replace( ['/', '\\'], DIRECTORY_SEPARATOR, $f_path );
        //wp_die($f_path);     
        if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/shortcode.php')) {
            require_once($f_path);
            wp_register_style('qcld-wp-chatbot-shortcode-style', QCLD_wpCHATBOT_PLUGIN_URL . 'templates/' . $qcld_wb_chatbot_theme . '/shortcode.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qcld-wp-chatbot-shortcode-style');
        } else {
            echo "<h2>" . esc_html__('No WPBot ShortCode Theme Found!', 'wpchatbot') . "</h2>";
        }
        
    }
    if(get_option('enable_wp_chatbot_sound_initial')==1 || get_option('enable_wp_chatbot_sound_botmessage')==1): ?>
        <audio id="wp-chatbot-proactive-audio" <?php if (get_option('enable_wp_chatbot_sound_initial') == 1){
            echo "autoplay";
        } ?>>
            <source src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'pro-active.mp3'); ?>">
            </source>
        </audio>
	<?php endif;

    ?>
    <style type="text/css">.wpbot-saas-live-chat{display:none}#wp-chatbot-shortcode-template-container .qcld-chatbot-custom-intent[data-text=<?php echo (isset($data['qlcd_wp_chatbot_sys_key_livechat']) && $data['qlcd_wp_chatbot_sys_key_livechat']!=''?$data['qlcd_wp_chatbot_sys_key_livechat']:'livechat'); ?>] {
    display: none;
    }</style>
    <?php

}
//shortcode for wpWBot mobile app
add_shortcode('wpwbot_app', 'qcld_wp_chatbot_mobile_app_short_code');
function qcld_wp_chatbot_mobile_app_short_code(){ ?>
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
    background: url(".esc_url($qcld_wb_chatbot_board_bg_path).") no-repeat top right !important;
}";
wp_add_inline_style( 'qlcd-wp-chatbot-admin-style', $custom_css );
?>

<?php }
    $wp_chatbot_enable_rtl = "";
    if (get_option('enable_wp_chatbot_rtl')) {
        $wp_chatbot_enable_rtl .= "wp-chatbot-rtl";
    }
    ?>
    <div id="wp-chatbot-chat-app-shortcode-container" class="<?php echo esc_html($wp_chatbot_enable_rtl); ?>">
        <?php
        // keep traking app template.
        $template_app = 'yes';
        //Get woocommerce cart
        global $woocommerce;
        $cart_items_number = $woocommerce->cart->cart_contents_count;
        //Handling shortcode enqeue and remove features part.
        define('wpCOMMERCE', true);
        wp_enqueue_script('jquery');
        wp_enqueue_script('woocommerce', array('jquery'));
        wp_enqueue_script('wc-cart', array('jquery', 'woocommerce'));
        wp_enqueue_script('wc-address-i18n');
        wp_enqueue_script('wc-country-select');
        wp_enqueue_script('wc-checkout', array('jquery', 'woocommerce', 'wc-address-i18n', 'wc-country-select'));
        remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
        // add the action
        if (isset($_GET['from']) && $_GET['from'] == 'app') {
            if (!isset($_COOKIE['from_app'])) {
                setcookie('from_app', 'yes', time() + 3600);
            }
        }
        $qcld_wb_chatbot_theme = get_option('qcld_wb_chatbot_theme');

        if($qcld_wb_chatbot_theme=='template-06' || $qcld_wb_chatbot_theme=='template-07'){
            $qcld_wb_chatbot_theme=='template-01';
        }

        if (file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php')) {
            require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/' . $qcld_wb_chatbot_theme . '/template.php');
        } else {
            echo "<h2>" . esc_html__('No WPBot Theme Found!', 'wpchatbot') . "</h2>";
        }
        ?>
    </div>
    <?php
}

/**
 * wpwBot Search keyword product
 */
add_action('wp_ajax_qcld_wb_chatbot_keyword', 'qcld_wb_chatbot_keyword');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_keyword', 'qcld_wb_chatbot_keyword');

function qcld_wb_chatbot_keyword(){
	global $wpdb;
	
    $searchkeyword = qcld_wpbot_modified_keyword(sanitize_text_field($_POST['keyword']));
	$total_items = (get_option('wppt_number_of_result')==''?'5':get_option('wppt_number_of_result'));
	$orderby = (get_option('wppt_result_orderby')==''?'none':get_option('wppt_result_orderby'));
	$order = (get_option('wppt_result_order')==''?'ASC':get_option('wppt_result_order'));
    $wp_chatbot_exclude_category_list = maybe_unserialize(get_option('qlcd_chatbot_exclude_category_list'));
	$product_categories = get_terms( 'product_cat', $args );
    
	$query_arg = array(
        'post_type'     => 'product',
		'post_status'   => 'publish',
		'posts_per_page'=> $total_items,
		's'             => stripslashes( $searchkeyword ),
		'paged'			=> 1,
		'orderby'		=> $orderby,
	);
	if($orderby!='none' or $orderby!='rand'){
        $query_arg['order'] = $order;
	}
    if(($wp_chatbot_exclude_category_list != false) && (count($wp_chatbot_exclude_category_list) != 0)){
        $tax_query = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $wp_chatbot_exclude_category_list,
                'operator' => 'NOT IN'
            ),
        );
        $query_arg['tax_query'] = $tax_query;
    }
	$totalresultsargs = array(
        'post_type'     => 'product',
		'post_status'   => 'publish',
		's'             => stripslashes( $searchkeyword ),
		
	);
    if(($wp_chatbot_exclude_category_list != false) && (count($wp_chatbot_exclude_category_list) != 0)){
        $totalresultsargs['tax_query'] = $tax_query;
    }
	if(get_option('wp_chatbot_exclude_stock_out_product') == 1){
		$query_arg['meta_query'] = array(
			'key'     => '_stock',
			'type'    => 'numeric',
			'value'   => 1,
			'compare' => '>'
		);
		$totalresultsargs['meta_query'] = array(
			'key'     => '_stock',
			'type'    => 'numeric',
			'value'   => 1,
			'compare' => '>'
		);
		
	}
	
	
	$totalresults = new WP_Query($totalresultsargs);
	$total_results = $totalresults->posts;
	$resultss = new WP_Query( $query_arg );
	$results = $resultss->posts;
	$newresults = array();
	foreach($results as $result){
		if (qcld_wp_chatbot_product_controlling($result->ID) == true) {
			$newresults[] = $result;
		}
	}
	$results = $newresults;

	$html = '<div class="wp-chatbot-products-area">';
	$_pf = new WC_Product_Factory();
	//repeating the products
	if (count($results) > 0) {
		$html .= '<ul class="wp-chatbot-products">';
		foreach($results as $result):
			$product = $_pf->get_product($result->ID);
			if (qcld_wp_chatbot_product_controlling($result->ID) == true) {
				$html .= '<li class="wp-chatbot-product">';
				$html .= '<a target="_blank" href="' . get_permalink($result->ID) . '"  wp-chatbot-pid= "' . $result->ID . '" title="' . esc_attr($product->get_title()) . '">';
				$html .= get_the_post_thumbnail($result->ID, 'shop_catalog') . '
				   <div class="wp-chatbot-product-summary">
				   <div class="wp-chatbot-product-table">
				   <div class="wp-chatbot-product-table-cell">
				   <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
				   <div class="price">' . ($product->get_price_html()) . '</div>';
				$html .= ' </div>
				   </div>
				   </div></a>
				   </li>';
			}
		endforeach;
		wp_reset_postdata();
		$html .= '</ul>';
		if (count($total_results) > $total_items && $total_items > 0 ) {
			$html .= '<p class="wpbot_p_align_center"><button type="button" id="wp-chatbot-loadmore" data-offset="' . esc_html($total_items) . '" data-search-type="product" data-search-term="' . esc_html($searchkeyword) . '" >' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_load_more'))) . ' <span id="wp-chatbot-loadmore-loader"></span></button> </p>';
		}
	}
	$html .= '</div>';
    
    $response = array('html' => $html, 'product_num' => count($total_results), 'per_page' => $total_items);
    echo wp_send_json($response);
    wp_die();
}
/**
 * wpwBot Categories
 */
add_action('wp_ajax_qcld_wb_chatbot_category', 'qcld_wb_chatbot_category');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_category', 'qcld_wb_chatbot_category');
function qcld_wb_chatbot_category(){
    $category_type="common";
    $wp_chatbot_exclude_category_list = maybe_unserialize(get_option('qlcd_chatbot_exclude_category_list'));
    if (get_option('wp_chatbot_show_parent_category') != "") {
        $terms = get_terms('product_cat', array('parent' => 0, 'hide_empty' => true, 'fields' => 'all','exclude' =>$wp_chatbot_exclude_category_list));

    } else {
        $terms = get_terms('product_cat', array('hide_empty' => true, 'fields' => 'all','exclude' =>$wp_chatbot_exclude_category_list));
    }
    $html = " ";
    foreach ($terms as $term) {
        $child_terms=get_terms('product_cat', array('parent' => $term->term_id, 'hide_empty' => true, 'fields' => 'all'));
        if(get_option('wp_chatbot_show_sub_category')==1 && count($child_terms) >0){
            $category_type="hasChilds";
        }
        $html .= '<span class="qcld-chatbot-product-category" data-category-type="' . esc_html($category_type) . '"  data-category-slug="' . esc_html($term->slug) . '" data-category-id="' . esc_html($term->term_id) . '">' . esc_html($term->name) . '</span>';
    }
    echo wp_send_json($html);
    wp_die();
}
/**
 * wpwBot Sub categories
 */
add_action('wp_ajax_qcld_wb_chatbot_sub_category', 'qcld_wb_chatbot_sub_category');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_sub_category', 'qcld_wb_chatbot_sub_category');
function qcld_wb_chatbot_sub_category(){
    $parent_id = stripslashes($_POST['parent_id']);
    $terms = get_terms('product_cat', array('parent' => $parent_id, 'hide_empty' => true, 'fields' => 'all'));
    $html = "";
    foreach ($terms as $term) {
        $html .= '<span class="qcld-chatbot-product-category" data-category-type="common"  data-category-slug="' . esc_html($term->slug) . '" data-category-id="' . esc_html($term->term_id) . '">' . esc_html($term->name) . '</span>';
    }
    echo wp_send_json($html);
    wp_die();
}
/**
 * wpwBot category product
 */
add_action('wp_ajax_qcld_wb_chatbot_category_products', 'qcld_wb_chatbot_category_products');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_category_products', 'qcld_wb_chatbot_category_products');
function qcld_wb_chatbot_category_products(){
    $category_id = stripslashes($_POST['category']);
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $product_orderby = get_option('qlcd_woo_chatbot_product_orderby') != '' ? get_option('qlcd_woo_chatbot_product_orderby') : 'title';
    $product_order = get_option('qlcd_woo_chatbot_product_orderby') != '' ? get_option('qlcd_woo_chatbot_product_orderby') : 'ASC';
    $wp_chatbot_exclude_category_list = maybe_unserialize(get_option('qlcd_chatbot_exclude_category_list'));
    //Merging all query together.
    $argu_params = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'orderby' => $product_orderby,
        'order' => $product_order,
        'posts_per_page' => $product_per_page,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
                'operator' => 'IN'
            )
        )
    );
    /******
     *WP Query Operation to get products.*
     *******/
    $product_query = new WP_Query($argu_params);
    $product_num = $product_query->post_count;
    //Getting total product number by string.
    $total_argu = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 100,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
              //  'category__not_in' => $wp_chatbot_exclude_category_list,
                'operator' => 'IN'
            )
        )
    );
    $total_query = new WP_Query($total_argu);
    $total_product_num = $total_query->post_count;
    $_pf = new WC_Product_Factory();
    //repeating the products
    $html = '';
    if ($product_num > 0) {
        $html .= '<div class="wp-chatbot-products-area">';
        $html .= '<ul class="wp-chatbot-products">';
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            
            $html .= '<li class="wp-chatbot-product">';
            $html .= '<a class="wp-chatbot-product-url" wp-chatbot-pid= "' . esc_html(get_the_ID()) . '" target="_blank" href="' . get_permalink(get_the_ID()) . '" title="' . esc_attr($product->get_title() ? $product->get_title() : get_the_ID()) . '">';
            $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
                <div class="wp-chatbot-product-summary">
                <div class="wp-chatbot-product-table">
                <div class="wp-chatbot-product-table-cell">
                <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
                <div class="price">' . ($product->get_price_html()) . '</div>';
            $html .= ' </div>
                </div>
                </div></a>
                </li>';
        endwhile;
        wp_reset_postdata();
        $html .= '</ul>';
        if ($total_product_num > $product_per_page && $product_per_page >0) {
            $html .= '<p class="wpbot_p_align_center"><button type="button" id="wp-chatbot-loadmore" data-offset="' . esc_html($product_per_page) . '" data-search-type="category" data-search-term="' . esc_html($category_id) . '" >' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_load_more'))) . ' <span id="wp-chatbot-loadmore-loader"></span></button> </p>';
        }
        $html .= '</div>';
    } else {
        $html = '';
    }
    $response = array('html' => $html, 'product_num' => $total_product_num, 'per_page' => $product_per_page);
    echo wp_send_json($response);
    wp_die();
}
/**
 * wpwBot latest, featured, recent product
 */
add_action('wp_ajax_qcld_wb_chatbot_featured_products', 'qcld_wb_chatbot_featured_products');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_featured_products', 'qcld_wb_chatbot_featured_products');
function qcld_wb_chatbot_featured_products(){
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $product_orderby = get_option('qlcd_woo_chatbot_product_orderby') != '' ? get_option('qlcd_woo_chatbot_product_orderby') : 'title';
    $product_order = get_option('qlcd_woo_chatbot_product_order') != '' ? get_option('qlcd_woo_chatbot_product_order') : 'ASC';
    //get featured products query.
    $argu_params = array('post_status' => 'publish',
        'posts_per_page' => $product_per_page,
        'post_type' => 'product',
        'post_status' => 'publish',
        'tax_query' => array(array('taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured'))
    );
    /******
     *WP Query Operation to get products.*
     *******/
    $product_query = new WP_Query($argu_params);
    $product_num = $product_query->post_count;
    //Getting total product number by string.
    $total_argu = array('post_status' => 'publish',
        'posts_per_page' => 100,
        'post_type' => 'product',
        'post_status' => 'publish',
        'tax_query' => array(array('taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured',),)
    );
    $total_query = new WP_Query($total_argu);
    $total_product_num = $total_query->post_count;
    $html = '<div class="wp-chatbot-products-area">';
    $_pf = new WC_Product_Factory();
    //repeating the products
    if ($product_num > 0) {
        
        $html .= '<ul class="wp-chatbot-products">';
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            $html .= '<li class="wp-chatbot-product">';
            $html .= '<a class="wp-chatbot-product-url" wp-chatbot-pid= "' . get_the_ID() . '" target="_blank" href="' . get_permalink(get_the_ID()) . '" title="' . esc_attr($product->get_title() ? $product->get_title() : get_the_ID()) . '">';
            $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
                <div class="wp-chatbot-product-summary">
                <div class="wp-chatbot-product-table">
                <div class="wp-chatbot-product-table-cell">
                <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
                <div class="price">' . ($product->get_price_html()) . '</div>';
            $html .= ' </div>
                </div>
                </div></a>
                </li>';
        endwhile;
        wp_reset_postdata();
        $html .= '</ul>';
        if ($total_product_num > $product_per_page) {
            $html .= '<p class="wpbot_p_align_center"><button type="button" id="wp-chatbot-loadmore" data-offset="' . esc_html($product_per_page) . '" data-search-type="product" data-search-term="featured" >' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_load_more'))) . ' <span id="wp-chatbot-loadmore-loader"></span></button> </p>';
        }
    }
    $html .= '</div>';
    $response = array('html' => $html, 'product_num' => $total_product_num, 'per_page' => $product_per_page);
    echo wp_send_json($response);
    wp_die();
}
//Product display controll
function qcld_wp_chatbot_product_controlling($product_id){
    $display_product = true;
    //Controlling Out of Stock product display from back end.
    $_pf = new WC_Product_Factory();
    $product = $_pf->get_product($product_id);
    if (! $product->managing_stock() && ! $product->is_in_stock() && ! $product->backorders_allowed() && get_option('wp_chatbot_exclude_stock_out_product') == 1) {
        $display_product = false;
    }
    return $display_product;
}
//Get Sale products
add_action('wp_ajax_qcld_wb_chatbot_sale_products', 'qcld_wb_chatbot_sale_products');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_sale_products', 'qcld_wb_chatbot_sale_products');
function qcld_wb_chatbot_sale_products(){
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $product_orderby = get_option('qlcd_woo_chatbot_product_orderby') != '' ? get_option('qlcd_woo_chatbot_product_orderby') : 'title';
    $product_order = get_option('qlcd_woo_chatbot_product_order') != '' ? get_option('qlcd_woo_chatbot_product_order') : 'ASC';
    //get sale products query.
    $argu_params = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $product_per_page,
        'meta_query' => array(
            'relation' => 'OR',
            array( // Simple products type
                'key' => '_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            ),
            array( // Variable products type
                'key' => '_min_variation_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            )
        )
    );
    /******
     *WP Query Operation to get products.*
     *******/
    $product_query = new WP_Query($argu_params);
    $product_num = $product_query->post_count;
    //Getting total product number by string.
    $total_argu = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 100,
        'meta_query' => array(
            'relation' => 'OR',
            array( // Simple products type
                'key' => '_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            ),
            array( // Variable products type
                'key' => '_min_variation_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            )
        )
    );
    $total_query = new WP_Query($total_argu);
    $total_product_num = $total_query->post_count;
    $html = '<div class="wp-chatbot-products-area">';
    $_pf = new WC_Product_Factory();
    //repeating the products
    if ($product_num > 0) {
        
        $html .= '<ul class="wp-chatbot-products">';
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            $html .= '<li class="wp-chatbot-product">';
            $html .= '<a class="wp-chatbot-product-url" wp-chatbot-pid= "' . get_the_ID() . '" target="_blank" href="' . get_permalink(get_the_ID()) . '" title="' . esc_attr($product->get_title() ? $product->get_title() : get_the_ID()) . '">';
            $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
                <div class="wp-chatbot-product-summary">
                <div class="wp-chatbot-product-table">
                <div class="wp-chatbot-product-table-cell">
                <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
                <div class="price">' . ($product->get_price_html()) . '</div>';
            $html .= ' </div>
                </div>
                </div></a>
                </li>';
        endwhile;
        wp_reset_postdata();
        $html .= '</ul>';
        if ($total_product_num > $product_per_page) {
            $html .= '<p class="wpbot_p_align_center"><button type="button" id="wp-chatbot-loadmore" data-offset="' . esc_html($product_per_page) . '" data-search-type="product" data-search-term="sale" >' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_load_more'))) . ' <span id="wp-chatbot-loadmore-loader"></span></button> </p>';
        }
    }
    $html .= '</div>';
    $response = array('html' => $html, 'product_num' => $total_product_num, 'per_page' => $product_per_page);
    echo wp_send_json($response);
    wp_die();
}

function qcld_wpbot_load_additional_validation_required(){
    
    $date = date('Y-m-d', strtotime(get_option('qcwp_install_date'). ' + 2 days'));
    if(qcld_wpbot_is_active_white_label() && get_option('wpwl_brand_logo')!=''){
        
        echo '<p class="wpqcld_chk_seft"><a target="_blank" href="#"><img src="'.get_option('wpwl_brand_logo').'"></a></p>';

    }else{
        if($date < date('Y-m-d')){
            echo get_option('_qopced_wgjsuelsdfj_');
        }
    }
    

}

//load more
add_action('wp_ajax_qcld_wb_chatbot_load_more', 'qcld_wb_chatbot_load_more');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_load_more', 'qcld_wb_chatbot_load_more');
function qcld_wb_chatbot_load_more(){
    $offset = stripslashes($_POST['offset']);
    $search_type = stripslashes($_POST['search_type']);
    $search_term = stripslashes($_POST['search_term']);
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $product_orderby = get_option('qlcd_woo_chatbot_product_orderby') != '' ? get_option('qlcd_woo_chatbot_product_orderby') : 'title';
    $product_order = get_option('qlcd_woo_chatbot_product_order') != '' ? get_option('qlcd_woo_chatbot_product_order') : 'ASC';
    $next_offset = intval($product_per_page + $offset);
    if ($search_type == 'product' && $search_term != 'featured' && $search_term != 'sale' && get_option('qlcd_wp_chatbot_search_option') == 'advanced') {
        //if have multiple ids then explode else have single need to array push
        if (strpos($search_term, ',') !== false) {
            $product_ids = explode(',', $search_term);
        } else {
            $product_ids = array($search_term);
        }
        $result = wpwBot_Search::factory()->get_load_more_products($product_ids);
        $products = $result['products'];
        $product_num = count($result['products']);
        $total_product_num = $result['total_products'];
        $more_product_ids = implode(",", $result['more_ids']);
        $_pf = new WC_Product_Factory();
        //repeating the products
        $html = '';
        if ($product_num > 0) {
            foreach ($products as $product) {
				
				if (qcld_wp_chatbot_product_controlling($product->get_id()) == true) {
					$html .= '<li class="wp-chatbot-product">';
					$html .= '<a target="_blank" href="' . esc_url(get_permalink($product->get_id())) . '" wp-chatbot-pid= "' . esc_html($product->get_id()) . '"  title="' . esc_attr($product->get_title()) . '">';
					$html .= get_the_post_thumbnail($product->get_id(), 'shop_catalog') . '
				   <div class="wp-chatbot-product-summary">
				   <div class="wp-chatbot-product-table">
				   <div class="wp-chatbot-product-table-cell">
				   <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
				   <div class="price">' . ($product->get_price_html()) . '</div>';
					$html .= ' </div></div></div></a></li>';
				}
            }
        }
        $response = array('html' => $html, 'product_num' => $total_product_num, 'search_term' => $more_product_ids, 'offset' => $next_offset, 'per_page' => $product_per_page);
    } else {
        if ($search_type == 'product' && $search_term != 'featured' && $search_term != 'sale') {  //For Standard search
            $argu_params = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => $product_per_page,
                'offset' => $offset,
                'orderby' => $product_orderby,
                'order' => $product_order,
                's' => $search_term,
            );
            if(get_option('wp_chatbot_exclude_stock_out_product') == 1){
				$argu_params['meta_query'] = array(
					'key'     => '_stock',
					'type'    => 'numeric',
					'value'   => 1,
					'compare' => '>'
				);
			}
        } else if ($search_type == 'category') {
            $argu_params = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => $product_per_page,
                'orderby' => $product_orderby,
                'order' => $product_order,
                'offset' => $offset,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $search_term,
                        'operator' => 'IN'
                    )
                )
            );
        } else if ($search_type == 'product' && $search_term == 'featured') {
            $argu_params = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => $product_per_page,
                'orderby' => $product_orderby,
                'order' => $product_order,
                'offset' => $offset,
                'meta_query' => array('key' => '_featured', 'value' => 'yes')
            );
        } else if ($search_type == 'product' && $search_term == 'sale') {
            $argu_params = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => $product_per_page,
                'orderby' => $product_orderby,
                'order' => $product_order,
                'offset' => $offset,
                'meta_query' => array(
                    'relation' => 'OR',
                    array( // Simple products type
                        'key' => '_sale_price',
                        'value' => 0,
                        'compare' => '>',
                        'type' => 'numeric'
                    ),
                    array( // Variable products type
                        'key' => '_min_variation_sale_price',
                        'value' => 0,
                        'compare' => '>',
                        'type' => 'numeric'
                    )
                )
            );
        }
        $product_query = new WP_Query($argu_params);
        $product_num = $product_query->post_count;
        $_pf = new WC_Product_Factory();
        //repeating the products
        $html = '';
        if ($product_num > 0) {
            while ($product_query->have_posts()) : $product_query->the_post();
                $product = $_pf->get_product(get_the_ID());
				if (qcld_wp_chatbot_product_controlling(get_the_ID()) == true) {
					$html .= '<li class="wp-chatbot-product">';
					$html .= '<a target="_blank" href="' . esc_url(get_permalink(get_the_ID())) . '"  wp-chatbot-pid= "' . esc_html(get_the_ID()) . '" title="' . esc_attr($product->get_title() ? $product->get_title() : get_the_ID()) . '">';
					$html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
					   <div class="wp-chatbot-product-summary">
					   <div class="wp-chatbot-product-table">
					   <div class="wp-chatbot-product-table-cell">
					   <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
					   <div class="price">' . ($product->get_price_html()) . '</div>';
					$html .= ' </div>
					   </div>
					   </div></a>
					   </li>';
				}
            endwhile;
            wp_reset_postdata();
        } else {
            $html .= '';
        }
        $response = array('html' => $html, 'product_num' => $product_num, 'search_term' => $search_term, 'offset' => $next_offset, 'per_page' => $product_per_page);
    }
    echo wp_send_json($response);
    wp_die();
}
//product details
add_action('wp_ajax_qcld_wb_chatbot_product_details', 'qcld_wb_chatbot_product_details');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_product_details', 'qcld_wb_chatbot_product_details');
function qcld_wb_chatbot_product_details(){
    $product_id = stripslashes($_POST['wp_chatbot_pid']);
    //Tracking product view from chat board
    qcld_wp_chatbot_view_track_product_by_id($product_id);
    //woocommerce product factory
    $wc_pf = new WC_Product_Factory();
    $product = $wc_pf->get_product($product_id);
    $product_type = $wc_pf->get_product_type($product_id);
    $product_title = '<h2 id="wp-chatbot-product-title" ><a target="_blank" href="' . get_permalink($product->get_id()) . '">' . esc_html($product->get_title()) . '</a></h2>';
    $product_desc = apply_filters('the_excerpt', $product->get_description());
    $gallery_ids = $product->get_gallery_image_ids();
    //images processing..
    $product_feature_image_id = get_post_thumbnail_id($product_id);
    $product_feature_image = wp_get_attachment_image_src($product_feature_image_id, 'full');
    $product_feature_thumb = wp_get_attachment_image_src($product_feature_image_id, 'shop_thumbnail');

    $product_image = '<div class="wp-chatbot-product-image-large">
                     <a href="' . esc_url($product_feature_image[0]) . '" id="wp-chatbot-product-image-large-path"><img id="wp-chatbot-product-image-large-src" src="' . esc_url($product_feature_image[0]) . '" alt="Large Image" title="Zoom Image" /></a>
                      </div>';
    $product_image .= '<div class="wp-chatbot-product-image-thumbs"><ul> 
                      <li class="wp-chatbot-product-active-image-thumbs"><a href="' . esc_url($product_feature_image[0]) . '" class="wp-chatbot-product-image-thumbs-path"><img  class="wp-chatbot-product-image-thumbs-src" src="' . esc_url($product_feature_thumb[0]) . '" alt="Thumb Image" /></a></li>';
    if (!empty($gallery_ids)) {
        foreach ($gallery_ids as $gallery_id) {
            $gallery_image = wp_get_attachment_image_src($gallery_id, 'full');
            $gallery_thumb = wp_get_attachment_image_src($gallery_id, 'shop_thumbnail');
            $product_image .= '<li><a href="' . esc_url($gallery_image[0]) . '" class="wp-chatbot-product-image-thumbs-path"><img class="wp-chatbot-product-image-thumbs-src" src="' . esc_url($gallery_thumb[0]) . '" alt="Thumb Image" /></a></li>';
        }
    }
    $product_image .= '</ul></div>';
    $product_price = '<p class="wp-chatbot-product-price" id="wp-chatbot-product-price">' . ($product->get_price_html()) . '</p>';
    $product_sku = '<p class="wp-chatbot-product-sku"> ' . esc_html__('SKU', 'wpchatbot') . ' : ' . esc_html($product->get_sku()) . '</p>';
    
    //Handle variable product start
    $variations = "";
    $add_cart_button = "";
    $product_quantity = "";
    if ($product->is_in_stock()) {
        if ($product_type == "variable") {
            //Getting product variation number based details
            $variations_data = array();
            foreach ($product->get_children() as $child_id) {
                $all_cfs = get_post_custom($child_id);
                $products = wc_get_product( $child_id );
                array_push($variations_data, array('variation_id' => $child_id, 'variation_data' => $all_cfs, 'variation_price' => $products->get_price_html()));
            }
            $variations_data = json_encode($variations_data);
            $attributes = $product->get_attributes();
            //Handling Variant & Non Variant products
            $var_attrs = $product->get_variation_attributes();
            $varation_names = array();
            if (!empty($var_attrs)) {
                foreach ($var_attrs as $key => $value) {
                    array_push($varation_names, $key);
                }
            }
            $debug = $varation_names;
            foreach ($attributes as $attribute) {

                $title = wc_attribute_label($attribute['name']);
                $name = $attribute['name'];
                if ($attribute['is_taxonomy']) {
                    $values = wc_get_product_terms($product->get_id(), $attribute['name'], array('fields' => 'slugs'));
                } else {
                    $values = array_map('trim', explode(WC_DELIMITER, $attribute['value']));
                }
                natsort($values);
                if (!in_array($name, $varation_names)) {
                    $variations .= '<p><label for="' . sanitize_title($name) . '">' . esc_html($title) . '</label> ' . ucfirst(implode(",", $values)) . '</p>';
                } else {
                    $variations .= '<div class="wp-chatbot-variable-' . sanitize_title($name) . '">';
                    $variations .= '<label for="' . sanitize_title($name) . '">' . esc_html($title) . '</label>';
                    $variations .= '<select id="' . esc_attr(sanitize_title($name)) . '" name="attribute_' . sanitize_title($name) . '" data-attribute_name="attribute_' . sanitize_title($name) . '" class="each_attribute">';
                    $variations .= '<option value="">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_choose_option'))) . '</option>';
                    foreach ($values as $value) {
                        if (isset($_REQUEST['attribute_' . sanitize_title($name)])) {
                            $selected_value = $_REQUEST['attribute_' . sanitize_title($name)];
                        } else {
                            $selected_value = '';
                        }
                        $variations .= '<option value="' . esc_attr(strtolower($value)) . '"' . selected($selected_value, $value, false) . '>' . apply_filters('woocommerce_variation_option_name', $value) . '</option>';
                    }
                    $variations .= '</select></div>';
                }
            }
            $add_cart_button .= '<span class="spinner "></span><input type="button"  id="wp-chatbot-variation-add-to-cart" wp-chatbot-product-id="' . esc_html($product_id) . '" value="' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_add_to_cart'))) . '" variation_id="" />';
            $add_cart_button .= "<input type='hidden'   id='wp-chatbot-variation-data'  data-product-variation='" . esc_html($variations_data) . "' />";
        } elseif( $product_type == "external" ){
			$add_cart_button .= "<a href='". $product->get_product_url() ."' target='_blank' class='qcld_external_buy_button'>". $product->get_button_text() ."</a>";
		} else {
            $add_cart_button .= '<span class="spinner "></span><input type="button" id="wp-chatbot-add-cart-button" wp-chatbot-product-id="' . esc_html($product_id) . '" value="' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_add_to_cart'))) . '" />';
        }
        //Handle variable product end.
        if( $product_type !='external' ){
            $product_quantity .= '<label for="">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_quantity'))) . '</label> <input type="number" id="vPQuantity" value="1" />';
        }
    }
    
    $response = array('title' => $product_title, 'description' => $product_desc, 'image' => $product_image, 'price' => $product_price, 'sku' => $product_sku, 'quantity' => $product_quantity, 'buttton' => $add_cart_button, 'variation' => $variations, 'type' => $product_type, 'debug' => $debug);
    echo wp_send_json($response);
    wp_die();
}
//Add to cart for variable product.
add_action('wp_ajax_variable_add_to_cart', 'qcld_wb_chatbot_variable_add_to_cart');
add_action('wp_ajax_nopriv_variable_add_to_cart', 'qcld_wb_chatbot_variable_add_to_cart');
function qcld_wb_chatbot_variable_add_to_cart(){
    $product_id = stripslashes($_POST['p_id']);
    $quantity = stripslashes($_POST['quantity']);
    $variations_id = stripslashes($_POST['variations_id']);
    $attrs = stripslashes($_POST['attributes']);
    
    $attributes = array();
    if ( ! empty( $attrs ) ){
        foreach ($attrs as $attr) {
            $single = explode("#", $attr);
            if (isset($single[0])) {
                $a_name = explode("_", $single[0]);
            }
            $attributes[$a_name[2]] = $single[1];
        }
    }
    global $woocommerce;
    $result = $woocommerce->cart->add_to_cart($product_id, $quantity, $variations_id, $attributes, null);
    if ($result != false) {
        echo wp_send_json('variable');
    } else {
        echo wp_send_json('error');
    }
    wp_die();
}
//Add to cart for simple product.
add_action('wp_ajax_qcld_wb_chatbot_add_to_cart', 'qcld_wb_chatbot_add_to_cart');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_add_to_cart', 'qcld_wb_chatbot_add_to_cart');
function qcld_wb_chatbot_add_to_cart(){
    $product_id = stripslashes($_POST['product_id']);
    $product_quantity = stripslashes($_POST['quantity']);
    global $woocommerce;
    $result = $woocommerce->cart->add_to_cart($product_id, $product_quantity);
    if ($result != false) {
        echo wp_send_json('simple');
    } else {
        echo wp_send_json('error');
    }
    wp_die();
}

function qc_fnc_get_ip_address(){

    if (!empty($_SERVER['HTTP_CLIENT_IP']))   
    {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
    {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from remote address
    else
    {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;

}

//Support part
add_action('wp_ajax_qcld_wb_chatbot_support_email', 'qcld_wb_chatbot_support_email');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_support_email', 'qcld_wb_chatbot_support_email');
function qcld_wb_chatbot_support_email(){
    $name = trim(sanitize_text_field($_POST['name']));
    $email = sanitize_email($_POST['email']);
    $message = sanitize_text_field($_POST['message']);
    $refurl = esc_url_raw($_POST['url']);
    $subject = (get_option('qlcd_wp_chatbot_email_sub')!=''?maybe_unserialize(get_option('qlcd_wp_chatbot_email_sub')):'Support Request from WPBOT');

    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $ip_address = qc_fnc_get_ip_address();


    if( is_array( $subject ) && isset( $subject[get_wpbot_locale()] )){
		$subject = $subject[get_wpbot_locale()];
	}
    
    //Extract Domain
    $url = get_site_url();
    $url = parse_url($url);
    $domain = $url['host'];
    
    $admin_email = get_option('admin_email');
    $toEmail = get_option('qlcd_wp_chatbot_admin_email') != '' ? get_option('qlcd_wp_chatbot_admin_email') : $admin_email;
    $fromEmail = "wordpress@" . $domain;

    if(get_option('qlcd_wp_chatbot_from_email') && get_option('qlcd_wp_chatbot_from_email')!=''){
        $fromEmail = get_option('qlcd_wp_chatbot_from_email');
    }

    $replyto = $fromEmail;

    if(get_option('qlcd_wp_chatbot_reply_to_email') && get_option('qlcd_wp_chatbot_reply_to_email')!=''){
        $replyto = get_option('qlcd_wp_chatbot_reply_to_email');
    }

    //Starting messaging and status.
    $response['status'] = 'fail';

	$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_email_fail'));
	if( is_array( $texts ) && isset( $texts[get_wpbot_locale()] )){
		$texts = $texts[get_wpbot_locale()];
	}
	$response['message'] = esc_html(str_replace('\\', '',$texts));

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $response['message'] = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_invalid_email')));
        $response['status'] = 'fail';
    } else {
        //build email body
        $bodyContent = "";
        $bodyContent .= '<p><strong>' . esc_html__('Support Request Details', 'wpchatbot') . ':</strong></p><hr>';
        $bodyContent .= '<p>' . esc_html__('Name', 'wpchatbot') . ' : ' . esc_html($name) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Email', 'wpchatbot') . ' : ' . esc_html($email) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Subject', 'wpchatbot') . ' : ' . esc_html($subject) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Message', 'wpchatbot') . ' : ' . esc_html($message) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Page URL', 'wpchatbot') . ' : ' . ($refurl) . '</p>';
        $bodyContent .= '<p>' . esc_html__('User Agent', 'wpchatbot') . ' : ' . ($user_agent) . '</p>';
        $bodyContent .= '<p>' . esc_html__('IP Address', 'wpchatbot') . ' : ' . ($ip_address) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Mail Generated on', 'wpchatbot') . ': ' . current_time('F j, Y, g:i a') . '</p>';
        $to = $toEmail;
        $body = $bodyContent;
        $headers = array();
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'From: ' . esc_html($name) . ' <' . esc_html($fromEmail) . '>';
        $headers[] = 'Reply-To: ' . esc_html($name) . ' <' . esc_html($email) . '>';
        $result = wp_mail($to, $subject, $body, $headers);
        $support_email_to_crm_contact = get_option('wpbot_support_mail_to_crm_contact');
        if($support_email_to_crm_contact){
            do_action( 'qcld_mailing_list_subscription_success', $name, $email );
        }
        if ($result) {
            $response['status'] = 'success';
            $texts = maybe_unserialize(get_option('qlcd_wp_chatbot_email_sent'));
			if( is_array( $texts ) && isset( $texts[get_wpbot_locale()] )){
				$texts = $texts[get_wpbot_locale()];
			}
			$response['message'] = esc_html(str_replace('\\', '',$texts));
        }
    }
    
    echo json_encode($response);
    die();
}

add_action('wp_ajax_qcld_wb_chatqcld_wb_chatbot_phone_validate', 'qcld_wb_chatbot_phone_validate');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_phone_validate', 'qcld_wb_chatbot_phone_validate');


function qcld_wb_chatbot_phone_validate(){
    $name = trim(sanitize_text_field($_POST['name']));
    $phone =sanitize_text_field($_POST['phone']);

    $matches = array();
    // returns all results in array $matches
    preg_match_all('/[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}| [0-9]{15}|[0-9]{14}|[0-9]{13}|[0-9]{12}|[0-9]{11}|[0-9]{10}|[0-9]{9}|[0-9]{8}|[0-9]{7}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}/', $phone, $matches);
    $matches = $matches[0];
    if(empty($matches) && get_option('disable_phone_validity')!=1){
        $response['status'] = 'invalid';
    }else{
        $response['status'] = 'success';

    }
    echo json_encode($response);
    die();

}

//Support Phone
add_action('wp_ajax_qcld_wb_chatbot_support_phone', 'qcld_wb_chatbot_support_phone');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_support_phone', 'qcld_wb_chatbot_support_phone');
function qcld_wb_chatbot_support_phone(){
    
    $name = trim(sanitize_text_field($_POST['name']));
    $phone =sanitize_text_field($_POST['phone']);

    $matches = array();
    // returns all results in array $matches
    preg_match_all('/[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}| [0-9]{15}|[0-9]{14}|[0-9]{13}|[0-9]{12}|[0-9]{11}|[0-9]{10}|[0-9]{9}|[0-9]{8}|[0-9]{7}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}/', $phone, $matches);
	
	
    $matches = $matches[0];
    if(empty($matches)){
        $response['status'] = 'invalid';
        $response['message'] = str_replace('\\', '',qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_valid_phone_number'))));

        
        echo json_encode($response);
    }else{
        $phone = $matches[0];

        $subject = (get_option('qlcd_wp_chatbot_callback_email_sub')!=''?maybe_unserialize(get_option('qlcd_wp_chatbot_callback_email_sub')):'WPBot Support Mail Request for Callback');

        if( is_array( $subject ) && isset( $subject[get_wpbot_locale()] )){
            $subject = $subject[get_wpbot_locale()];
        }
        
        //Extract Domain
        $url = get_site_url();
        $url = parse_url($url);
        $domain = $url['host'];
        
        $admin_email = get_option('admin_email');
        $toEmail = get_option('qlcd_wp_chatbot_admin_email') != '' ? get_option('qlcd_wp_chatbot_admin_email') : $admin_email;
        $fromEmail = "wordpress@" . $domain;

        if(get_option('qlcd_wp_chatbot_from_email') && get_option('qlcd_wp_chatbot_from_email')!=''){
            $fromEmail = get_option('qlcd_wp_chatbot_from_email');
        }
    
        $replyto = $fromEmail;
    
        if(get_option('qlcd_wp_chatbot_reply_to_email') && get_option('qlcd_wp_chatbot_reply_to_email')!=''){
            $replyto = get_option('qlcd_wp_chatbot_reply_to_email');
        }

        //Starting messaging and status.
        $response['status'] = 'fail';
        $response['message'] = str_replace('\\', '',get_option('qlcd_wp_chatbot_phone_fail'));
            //build email body
            $bodyContent = "";
            $bodyContent .= '<p><strong>' . esc_html__('Support Request Details', 'wpchatbot') . ':</strong></p><hr>';
            $bodyContent .= '<p>' . esc_html__('Name', 'wpchatbot') . ' : ' . esc_html($name) . '</p>';
            $bodyContent .= '<p>' . esc_html__('Phone', 'wpchatbot') . ' : ' . esc_html($phone) . '</p>';
            $bodyContent .= '<p>' . esc_html__('Subject', 'wpchatbot') . ' : ' . esc_html($subject) . '</p>';
            $bodyContent .= '<p>' . esc_html__('Message', 'wpchatbot') . ' : ' . esc_html__(' Call me at ', 'wpchatbot'). esc_html($phone) . '</p>';
            $bodyContent .= '<p>' . esc_html__('Mail Generated on', 'wpchatbot') . ': ' . current_time('F j, Y, g:i a') . '</p>';
            $to = $toEmail;
            $body = $bodyContent;
            $headers = array();
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: ' . esc_html($name) . ' <' . esc_html($fromEmail) . '>';
            $headers[] = 'Reply-To: ' . esc_html($name) . ' <' . esc_html($replyto) . '>';
            $result = wp_mail($to, $subject, $body, $headers);
            if ($result) {
                $response['status'] = 'success';
                $response['message'] = str_replace('\\', '',get_option('qlcd_wp_chatbot_phone_sent'));
            }
        ob_clean();
        echo json_encode($response);
    }
    die();
}
// Order Status part.
add_action('wp_ajax_qcld_wb_chatbot_check_user', 'qcld_wb_chatbot_check_user');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_check_user', 'qcld_wb_chatbot_check_user');
function qcld_wb_chatbot_check_user(){
    global $woocommerce;
    $user_name = trim(sanitize_text_field($_POST['user_name']));
    $response = array();
    $response['message'] = "";
    if (username_exists($user_name)) {
        if (get_option('qlcd_wp_chatbot_order_user') == 'login') {
            $response['status'] = "success";
            $response['message'] .= qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_order_username_thanks')));
            $response['html'] .= '<p>' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_order_username_password'))) . '</p>';
        } else if (get_option('qlcd_wp_chatbot_order_user') == 'not_login') {
            $response = qcld_wpbot_get_order_by_username($user_name);
        }
    } else {
        $response['status'] = "fail";
        $response['message'] .= '<strong>' . esc_html($user_name) . '</strong> ' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_order_username_not_exist')));
    }
    echo wp_send_json($response);
    die();
}
add_action('wp_ajax_qcld_wpbot_current_language', 'qcld_wpbot_current_language');
add_action('wp_ajax_nopriv_qcld_wpbot_current_language', 'qcld_wpbot_current_language');
function qcld_wpbot_current_language(){
   $language = sanitize_text_field($_POST['language']);
   setcookie('qcld_wpbot_language', $language, time() + 3600);
   return $language;
}
function qcld_wpb_randmom_message_handle($items=array()){
    if(!empty($items)){
        if(!empty( $_COOKIE["qcld_wpbot_language"] )){
            $default_language =$_COOKIE["qcld_wpbot_language"];
        }else{
            $default_language = qcld_wpbot()->helper->default_langauge();
        }
        if( isset( $items[$default_language] ) && is_array( $items[$default_language] ) && count( $items[$default_language] ) > 1 ){
            return $items[$default_language][rand(0, count($items) - 1)];
        }elseif( isset( $items[$default_language] ) && is_array( $items[$default_language] ) && count( $items[$default_language] ) == 1 ){
            return $items[$default_language][0];
        }elseif( isset( $items[$default_language] ) && ! is_array( $items[$default_language] ) ){
            return $items[$default_language];
        }
        if( isset( $items[get_wpbot_locale()] ) && is_array( $items[get_wpbot_locale()] ) && count( $items[get_wpbot_locale()] ) > 1 ){
            return $items[get_wpbot_locale()][rand(0, count($items) - 1)];
        }elseif( isset( $items[get_wpbot_locale()] ) && is_array( $items[get_wpbot_locale()] ) && count( $items[get_wpbot_locale()] ) == 1 ){
            return $items[get_wpbot_locale()][0];
        }elseif( isset( $items[get_wpbot_locale()] ) && ! is_array( $items[get_wpbot_locale()] ) ){
            return $items[get_wpbot_locale()];
        }
        return '';
    }else{
        return '';
    }
}
function qcld_wb_chatbot_func_str_replace($messages = array()){
    $messages = stripslashes_deep($messages);
    if( isset( $messages[get_wpbot_locale()] ) ){
        return $messages[get_wpbot_locale()];
    }else{
        return $messages;
    }
}
add_action('wp_ajax_qcld_wb_chatbot_login_user', 'qcld_wb_chatbot_login_user');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_login_user', 'qcld_wb_chatbot_login_user');
function qcld_wb_chatbot_login_user(){
    // First check the nonce, if it fails the function will break
    check_ajax_referer('wpwbot-order-nonce', 'security');
    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = trim(sanitize_text_field($_POST['user_name']));
    $info['user_password'] = trim(sanitize_text_field($_POST['user_pass']));
    $info['remember'] = true;
    $user_signon = wp_signon($info, false);
    $response = array();
    if (is_wp_error($user_signon)) {
        $response['status'] = "fail";
        $response['message'] = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_order_password_incorrect')));
    } else {
        $response = qcld_wpbot_get_order_by_username($info['user_login']);
        $response['status'] = "success";
    }
    echo wp_send_json($response);
    die();
}


function get_private_order_notes( $order_id){
    global $wpdb;

    $table_perfixed = $wpdb->prefix . 'comments';
    $results = $wpdb->get_results("
        SELECT *
        FROM $table_perfixed
        WHERE  `comment_post_ID` = $order_id
        AND  `comment_type` LIKE  'order_note'
    ");

    foreach($results as $note){
        $order_note[]  = array(
            'note_id'      => $note->comment_ID,
            'note_date'    => $note->comment_date,
            'note_author'  => $note->comment_author,
            'note_content' => $note->comment_content,
        );
    }
    return $order_note;
}
add_action('wp_ajax_qcld_wb_chatbot_order_status_check', 'qcld_wb_chatbot_order_status_check');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_order_status_check', 'qcld_wb_chatbot_order_status_check');
function qcld_wb_chatbot_order_status_check(){
    // First check the nonce, if it fails the function will break
    check_ajax_referer('wpwbot-order-nonce', 'security');
    // Nonce is checked, get the POST data and sign user on
    $order_email = trim(sanitize_email($_POST['order_email']));
    $order_id = trim(sanitize_text_field($_POST['order_id']));
    $response = array();
    //func
    $response['status'] .= "success";
    
    // The query arguments
    $customer_orders = get_posts(array(
        'numberposts' => -1,
        'meta_key' => '_billing_email',
        'meta_value' => $order_email,
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'posts_per_page' => 10,
        'orderby' => 'date',
        'post__in' => array($order_id)
    ));
    
    $response['order_num'] = count($customer_orders);
    $order_html = '';
    if ($response['order_num'] > 0) {
        $response['message'] .= qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_order_found')));
        $order_date = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_order_date')));
        $order_item = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_order_date')));
        $order_status = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_order')));
        $order_id = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_order_id_text')));
        $order_html .= '<div class="wp-chatbot-orders-container">';
        foreach ($customer_orders as $order) {
            //Formatting order summery
           
            if (isset($_COOKIE['from_app']) && $_COOKIE['from_app'] == 'yes') {
                $thanks_page_id = get_option('wp_chatbot_app_order_thankyou');
                $thanks_parmanlink = esc_url(get_permalink($thanks_page_id));
                $order_url = '<a href="' . esc_url($thanks_parmanlink . '?order_id=' . $order->ID) . '" >' . ($order->ID) . '</a>';
            } else {
                $order_url = '<a href="' . esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . '/view-order/' . $order->ID) . '" target="_blank" >' . $order->ID . '</a>';
            }
			
			$order_html .= '<div class="wp-chatbot-orders-single-container">';
			
			$order_html .= '<div class="wp-chatbot-orders-single">';
			$order_html .= '<div class="order-id">'.$order_id.'</div>';
			$order_html .= '<div class="order-id"> ' . ($order_url) . '</div>';
			$order_html .= '</div>';
			
			$order_html .= '<div class="wp-chatbot-orders-single">';
			$order_html .= '<div class="order-id">'.$order_date.'</div>';
			$order_html .= '<div class="order-id"> ' . (date("m/d/Y", strtotime($order->post_date))) . '</div>';
			$order_html .= '</div>';
			
			$order_html .= '<div class="wp-chatbot-orders-single">';
			$order_html .= '<div class="order-id">'.$order_item.'</div>';
			$order_html .= '<div class="order-id">';
			$singleOrder = new WC_Order($order->ID);
            $items = $singleOrder->get_items();
            foreach ($items as $item) {
                $order_html .= '<p>' . ($item["name"]) . ' X ' . ($item["qty"]) . '</p>';
            }
			$order_html .= '</div>';
			$order_html .= '</div>';
			
			$order_html .= '<div class="wp-chatbot-orders-single">';
			$order_html .= '<div class="order-id">'.$order_status.'</div>';
			$order_html .= '<div class="order-id"> ' . (strtoupper(end(explode("-", $order->post_status)))) . '</div>';
			$order_html .= '</div>';
			
            $customernote = $singleOrder->get_customer_note();
            if(!empty($customernote)){
                $order_html .= '<div class="qc_order_note">';
                    $order_html .= '<h2>Customer Notes</h2>';
                    $order_html .= '<div class="wp-chatbot-orders-note"><p>'.($customernote).'</p></div>';
                $order_html .= '</div>';
            }
            $order_notes = get_private_order_notes( $order->ID );
            if(!empty($order_notes)){
                $order_html .= '<div class="qc_order_note">';
                    $order_html .= '<h2>Order Notes</h2>';
                    foreach($order_notes as $cnote){
                        $order_html .= '<div class="wp-chatbot-orders-note"><p>'.($cnote['note_content']).'</p><small>'. ($cnote['note_author']).'</small></div>';
                    }

                $order_html .= '</div>';
            }
			$order_html .= '</div>';
        }
        $order_html .= '</div>';
    } else {
        $response['message'] .= get_option('qlcd_wp_chatbot_sorry') . '!';
        $order_html .= '<p>' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_order_not_found'))) . '</p>';
    }
    $response['html'] = $order_html;
    
    //func-end

    echo wp_send_json($response);
    die();
}

add_action('wp_ajax_qcld_wb_chatbot_loged_in_user_orders', 'qcld_wb_chatbot_loged_in_user_orders');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_loged_in_user_orders', 'qcld_wb_chatbot_loged_in_user_orders');
function qcld_wb_chatbot_loged_in_user_orders(){
    $current_user = wp_get_current_user();
    $user_name = $current_user->user_login;
    $response = qcld_wpbot_get_order_by_username($user_name);
    echo wp_send_json($response);
    die();
}
/*
* Loading secure data
*/

function qldf_botwp_content($action){

    if(file_exists(QCLD_wpCHATBOT_PLUGIN_DIR_PATH. '/languages/' .$action.'.txt')){

		$myfile = fopen(QCLD_wpCHATBOT_PLUGIN_DIR_PATH. '/languages/' .$action.'.txt', "r");
		$data = '';
		if( $myfile ){
			$data = fread($myfile,filesize(QCLD_wpCHATBOT_PLUGIN_DIR_PATH. '/languages/' .$action.'.txt'));
		}
		fclose($myfile);
		if( $data != '' ){
			if($action=='themedata'){
				$actionurl = QCLD_theme_BANNER_LANDING;
			}
			if($action=='customservicedata'){
				$actionurl = QCLD_wpCHATBOT_ACTION;
			}
			if($action=='logodata'){
				$actionurl = 'https://www.quantumcloud.com/products/';
			}

			return '<p class="'.QCLD_wpCHATBOT_ACTION_hook.'"><a target="_blank" href="'.$actionurl.'"><img src="'.$data.'" /></a></p>';
		}
		return '';
    }else{
        return '';
    }
}

function qcld_wpbot_get_order_by_username($user_name){
    global $post;
    $response = array();
    $response['status'] .= "success";
    $user = get_user_by('login', $user_name);
    // The query arguments
    $customer_orders = get_posts(array(
        'numberposts' => -1,
        'meta_key' => '_customer_user',
        'meta_value' => $user->ID,
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'posts_per_page' => 10,
        'orderby' => 'date',
    ));
    $response['order_num'] = count($customer_orders);
    $order_html = '';
    if ($response['order_num'] > 0) {
        $response['message'] .= qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_order_found')));
        foreach ($customer_orders as $order) {
			
			if( $order->post_status == 'wc-completed' ) {
				continue;
			}
        //Formatting order summery
            if (isset($_COOKIE['from_app']) && $_COOKIE['from_app'] == 'yes') {
                $thanks_page_id = get_option('wp_chatbot_app_order_thankyou');
                $thanks_parmanlink = esc_url(get_permalink($thanks_page_id));
                $order_url = '<a href="' . esc_url($thanks_parmanlink . '?order_id=' . $order->ID) . '" >' . ($order->ID) . '</a>';
            } else {
                $order_url = '<a href="' . esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . '/view-order/' . $order->ID) . '" target="_blank" >' . $order->ID . '</a>';
            }
			
			$order_html .= '<div class="wp-chatbot-orders-single-container">';
			
			$order_html .= '<div class="wp-chatbot-orders-single">';
			$order_html .= '<div class="order-id"> Order ID </div>';
			$order_html .= '<div class="order-id"> ' . ($order_url) . '</div>';
			$order_html .= '</div>';
			
			$order_html .= '<div class="wp-chatbot-orders-single">';
			$order_html .= '<div class="order-id"> Order Date </div>';
			$order_html .= '<div class="order-id"> ' . (date("m/d/Y", strtotime($order->post_date))) . '</div>';
			$order_html .= '</div>';
			
			$order_html .= '<div class="wp-chatbot-orders-single">';
			$order_html .= '<div class="order-id"> Order item </div>';
			$order_html .= '<div class="order-id">';
			$singleOrder = new WC_Order($order->ID);
            $items = $singleOrder->get_items();
            foreach ($items as $item) {
                $order_html .= '<p>' . ($item["name"]) . ' X ' . ($item["qty"]) . '</p>';
            }
			$order_html .= '</div>';
			$order_html .= '</div>';
			
			$order_html .= '<div class="wp-chatbot-orders-single">';
			$order_html .= '<div class="order-id"> Order Status </div>';
			$order_html .= '<div class="order-id"> ' . (strtoupper(end(explode("-", $order->post_status)))) . '</div>';
			$order_html .= '</div>';
			
            $customernote = $singleOrder->get_customer_order_notes();
            if(!empty($customernote)){
                $order_html .= '<div class="qc_order_note">';
                    $order_html .= '<h2>Order Notes</h2>';
                    foreach($customernote as $cnote){
                        $order_html .= '<p>'.($cnote->comment_content).'</p>';
                    }

                $order_html .= '</div>';
            }
			$order_html .= '</div>';
        }
        $order_html .= '</div>';
    } else {
        $response['message'] .= get_option('qlcd_wp_chatbot_sorry') . '! <strong>' . ($user_name) . '</strong>';
        $order_html .= '<p>' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_order_not_found'))) . '</p>';
    }
    $response['html'] = $order_html;
    return $response;
}
//Recently viewed products

function qc_wpbot_theme_validation_fnc(){

    if(!qcld_wpbot_is_active_white_label()):

        $date = date('Y-m-d', strtotime(get_option('qcwp_install_date'). ' + 7 days'));
        if($date < date('Y-m-d')){
            echo get_option('_qopced_wgjegdsetheme_');
        }

    endif;

}


//keeping id in cookies as
function qcld_wp_chatbot_track_product_view(){
    if (!is_singular('product')) {
        return;
    }
    global $post;
    qcld_wp_chatbot_view_track_product_by_id($post->ID);
}
function qcld_wp_chatbot_view_track_product_by_id($post_id){
    if (empty($_COOKIE['wp_chatbot_woocommerce_recently_viewed']))
        $viewed_products = array();
    else
        $viewed_products = (array)explode('|', $_COOKIE['wp_chatbot_woocommerce_recently_viewed']);
    if (!in_array($post_id, $viewed_products)) {
        $viewed_products[] = $post_id;
    }
    if (sizeof($viewed_products) > 15) {
        array_shift($viewed_products);
    }
    // Store for session only
    if(function_exists('wc_setcookie')){
        wc_setcookie('wp_chatbot_woocommerce_recently_viewed', implode('|', $viewed_products));
    }
    
}
add_action('template_redirect', 'qcld_wp_chatbot_track_product_view', 20);
//recent view product ajax
add_action('wp_ajax_qcld_wb_chatbot_recently_viewed_products', 'qcld_wb_chatbot_recently_viewed_products');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_recently_viewed_products', 'qcld_wb_chatbot_recently_viewed_products');
function qcld_wb_chatbot_recently_viewed_products(){
    // Get wpCommerce Global
    $_pf = new WC_Product_Factory();
    //show post per page.
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_latest_product_welcome')));
    // Get recently viewed product cookies data
    $viewed_products = !empty($_COOKIE['wp_chatbot_woocommerce_recently_viewed']) ? (array)explode('|', $_COOKIE['wp_chatbot_woocommerce_recently_viewed']) : array();
    $viewed_products = array_filter(array_map('absint', $viewed_products));
    //get featured products if has.
    $featured_products = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => $product_per_page, 'post_type' => 'product', 'tax_query' => array(array('taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured'))));
    //Getting recently vieew products.
    if (!empty($viewed_products)) {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_viewed_product_welcome')));
        $product_query = new WP_Query(array(
            'posts_per_page' => $product_per_page,
            'no_found_rows' => 1,
            'post_status' => 'publish',
            'post_type' => 'product',
            'post__in' => $viewed_products,
        ));
        //Getting featured products
    } else if ($featured_products->post_count > 0) {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_featured_product_welcome')));
        $product_query = $featured_products;
    } else {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_latest_product_welcome')));
        //Getting recent products
        $product_query = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => $product_per_page, 'post_type' => 'product', 'orderby' => 'date', 'order' => 'DESC'));
    }
    
    if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') == "custom-agent.png") {
        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_agent_path');
    } else if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') != "custom-agent.png") {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
    } else {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
    }
    $html = '<div class="wp-chatbot-agent-profile">
            <div class="wp-chatbot-widget-avatar"><img src="' . esc_url($wp_chatbot_custom_icon_path) . '" alt=""></div>
            <div class="wp-chatbot-widget-agent">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_agent'))) . '</div>
            <div class="wp-chatbot-bubble">' . esc_html($wp_chatbot_product_title) . '</div>
            </div>';
    if ($product_query->post_count > 0) {
        $html .= '<div class="wp-chatbot-products-area">';
        $html .= '<ul class="wp-chatbot-products">';
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            $html .= '<li class="wp-chatbot-product">';
            $html .= '<a target="_blank" href="' . get_permalink(get_the_ID()) . '" wp-chatbot-pid= "' . get_the_ID() . '" title="' . esc_attr($product->post->post_title ? $product->post->post_title : get_the_ID()) . '">';
            $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
       <div class="wp-chatbot-product-summary">
       <div class="wp-chatbot-product-table">
       <div class="wp-chatbot-product-table-cell">
       <h3 class="wp-chatbot-product-title">' . esc_html($product->post->post_title) . '</h3>
       <div class="price">' . ($product->get_price_html()) . '</div>';
            $html .= ' </div>
       </div>
       </div></a>
       </li>';
        endwhile;
        wp_reset_query();
        wp_reset_postdata();
        $html .= '</ul></div>';
    } else {
        $html .= '<div class="wp-chatbot-products-area">';
        $html .= '<p class="wpbot_p_align_center">You have no products !';
        $html .= '</div>';
    }
    echo wp_send_json($html);
    die();
}
//Recently viewed product shortcode
add_shortcode('wpwbot_products', 'qcld_wb_chatbot_recently_viewed_shortcode');
function qcld_wb_chatbot_recently_viewed_shortcode(){
    // Get wpCommerce Global
    $_pf = new WC_Product_Factory();
    $product_per_page = get_option('qlcd_wp_chatbot_ppp') != '' ? get_option('qlcd_wp_chatbot_ppp') : 10;
    $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_latest_product_welcome')));
    // Get recently viewed product cookies data
    $viewed_products = !empty($_COOKIE['wp_chatbot_woocommerce_recently_viewed']) ? (array)explode('|', $_COOKIE['wp_chatbot_woocommerce_recently_viewed']) : array();
    $viewed_products = array_filter(array_map('absint', $viewed_products));
    //get featured products if has.
    $featured_products = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => $product_per_page, 'post_type' => 'product', 'tax_query' => array(array('taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured'))));
    //Getting recently vieew products.
    if (!empty($viewed_products)) {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_viewed_product_welcome')));
        $product_query = new WP_Query(array(
            'posts_per_page' => $product_per_page,
            'no_found_rows' => 1,
            'post_status' => 'publish',
            'post_type' => 'product',
            'post__in' => $viewed_products,
        ));
        //implementing featured products
    } else if ($featured_products->post_count > 0) {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_featured_product_welcome')));
        $product_query = $featured_products;
    } else {
        $wp_chatbot_product_title = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_latest_product_welcome')));
        //Getting recent products
        $product_query = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => $product_per_page, 'post_type' => 'product', 'orderby' => 'date', 'order' => 'DESC'));
    }
    
    if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') == "custom-agent.png") {
        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_agent_path');
    } else if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') != "custom-agent.png") {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
    } else {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
    }
    $html = '<div class="wp-chatbot-agent-profile">
            <div class="wp-chatbot-widget-avatar"><img src="' . esc_url($wp_chatbot_custom_icon_path) . '" alt=""></div>
            <div class="wp-chatbot-widget-agent">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_agent'))) . '</div>
            <div class="wp-chatbot-bubble">' . esc_html($wp_chatbot_product_title) . '</div>
            </div>';
    if ($product_query->post_count > 0) {
        $html .= '<div class="wp-chatbot-products-area">';
        $html .= '<ul class="wp-chatbot-products">';
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            $html .= '<li class="wp-chatbot-product">';
            $html .= '<a target="_blank" href="' . get_permalink(get_the_ID()) . '" wp-chatbot-pid= "' . get_the_ID() . '" title="' . esc_attr($product->post->post_title ? $product->post->post_title : get_the_ID()) . '">';
            $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
       <div class="wp-chatbot-product-summary">
       <div class="wp-chatbot-product-table">
       <div class="wp-chatbot-product-table-cell">
       <h3 class="wp-chatbot-product-title">' . esc_html($product->post->post_title) . '</h3>
       <div class="price">' . esc_html($product->get_price_html()) . '</div>';
            $html .= ' </div>
       </div>
       </div></a>
       </li>';
        endwhile;
        wp_reset_query();
        wp_reset_postdata();
        $html .= '</ul></div>';
    } else {
        $html .= '<div class="wp-chatbot-products-area">';
        $html .= '<p class="wpbot_p_align_center">' . esc_html__('You have no products', 'wpchatbot') . ' !';
        $html .= '</div>';
    }
    return $html;
}
//Show cart for wp chatbot
add_action('wp_ajax_qcld_wb_chatbot_show_cart', 'qcld_wb_chatbot_show_cart');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_show_cart', 'qcld_wb_chatbot_show_cart');
function qcld_wb_chatbot_show_cart(){
    global $woocommerce;
    
    $cart_url = wc_get_cart_url();
    $checkout_url = wc_get_checkout_url();
    $language = ( isset( $_POST['language'] ) ? sanitize_text_field( $_POST['language'] ) : get_wpbot_locale() );
    $items = $woocommerce->cart->get_cart();
    $itemCount = $woocommerce->cart->cart_contents_count;
    $cart_title = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_shopping_cart')));
    $no_cart_item_msg = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_no_cart_items')));
    
    if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') == "custom-agent.png") {
        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_agent_path');
    } else if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') != "custom-agent.png") {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
    } else {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
    }
    $html = '<div class="wp-chatbot-agent-profile">
            <div class="wp-chatbot-widget-avatar"><img src="' . esc_url($wp_chatbot_custom_icon_path) . '" alt=""></div>
            <div class="wp-chatbot-widget-agent">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_agent'))) . '</div>
            <div class="wp-chatbot-bubble">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_welcome'))) . '</div>
            </div>';
    if ($itemCount >= 1) {
        $html .= '<div class ="wp-chatbot-cart-container">';
        $html .= '<div class="wp-chatbot-cart-header"><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_title'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_quantity'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_price'))) . '</div><div class="qcld-wp-chatbot-cell"></div></div>';
        $html .= '<div class ="wp-chatbot-cart-body">';
        foreach ($items as $item => $values) {
            $cart_item= apply_filters('woocommerce_cart_item_product', $values['data'], $values, $item);
            //product image
            $getProductDetail = wc_get_product($values['product_id']);
			
			$attrs = array();
            if( isset( $values['variation_id'] ) && $values['variation_id'] != '' ){
                $variation            = wc_get_product( $values['variation_id'] );
                if($variation){
                    $variation_attributes = $variation->get_attributes();
                    if( ! empty( $variation_attributes ) ){
                        foreach( $variation_attributes as $attributekey => $attribute_value ){
                            if( $attribute_value !='' ){
                                $attrs[] = $attribute_value;
                            }
                        }
                    }
                }
            }

            $extra_title = ( !empty( $attrs ) ? ' - '.implode(', ', $attrs) : '' );
			
            $price = get_post_meta($values['product_id'], '_price', true);
            $html .= '<div class="wp-chatbot-cart-single">
                        <div class="qcld-wp-chatbot-cell"> <h3 class="wp-chatbot-title">' . esc_html($cart_item->get_title() . $extra_title ) . '</h3></div>';
            $html .= '<div class="qcld-wp-chatbot-cell">';
            $html .= '<input class="qcld-wp-chatbot-cart-item-qnty" data-cart-item="' . esc_html($item) . '" type="number" min="1" value="' . esc_html($values['quantity']) . '"></div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span class="wp-chatbot-cart-price">' . apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($cart_item), $values, $item) . '</span> </div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span data-cart-item="' . esc_html($item) . '" class="wp-chatbot-remove-cart-item">X</span></div> </div>';
        }
        $html .= ' </div>';//End of cart body
        $html .= '<div class="wp-chatbot-cart-single">
                            <div class="qcld-wp-chatbot-cell"></div>
                            <div class="qcld-wp-chatbot-cell"><strong>Total</strong></div>
                            <div class="qcld-wp-chatbot-cell"><strong>' . $woocommerce->cart->get_total() . '</strong></div>
                        </div>';
        $html .= '<div class="wp-chatbot-cart-footer"><div class="qcld-wp-chatbot-cart-page"><a class="wp-chatbot-cart-link" href="' . esc_url($cart_url) . '"  >' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_link'))) . '</a></div><div class="qcld-wp-chatbot-checkout"><a class="wp-chatbot-checkout-link" href="' . esc_url($checkout_url) . '"  >' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_checkout_link'))) . '</a></div></div>';
        $html .= ' </div>';

        $continue_shopping = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_continue_shopping')));
        
        if(! empty( $continue_shopping[ $language ] ) ){
            $continue_shopping = $continue_shopping[ $language ][array_rand($continue_shopping[ $language ])];
        }else{
            $continue_shopping = __('Continue Shopping', 'wpchatbot');
        }
        $html .= '<span class="qcld-chatbot-default qcld_continue_shopping">'. $continue_shopping .'</span>';
        
    } else {
        $html .= '<div class="wp-chatbot-cart-container">';
        $html .= '<div><p class="wpbot_p_align_center">' . esc_html($no_cart_item_msg) . '</p></div>';
        $html .= '</div>';

        $continue_shopping = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_continue_shopping')));

        if(! empty( $continue_shopping[ $language ] ) ){
            $continue_shopping = $continue_shopping[ $language ][array_rand($continue_shopping[ $language ])];
        }else{
            $continue_shopping = __('Continue Shopping', 'wpchatbot');
        }

        $html .= '<span class="qcld-chatbot-default qcld_continue_shopping">'. $continue_shopping .'</span>';
    }
    $response = array('html' => $html, 'items' => $itemCount);
    echo wp_send_json($response);
    wp_die();
}
//cart onley for wp chatbot
add_action('wp_ajax_qcld_wb_chatbot_only_cart', 'qcld_wb_chatbot_only_cart');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_only_cart', 'qcld_wb_chatbot_only_cart');
function qcld_wb_chatbot_only_cart(){
    global $woocommerce;
    
    $cart_url = wc_get_cart_url();
    $checkout_url = wc_get_checkout_url();
   
    $items = $woocommerce->cart->get_cart();
    $itemCount = $woocommerce->cart->cart_contents_count;
    $no_cart_item_msg = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_no_cart_items')));

    $html = '';
    if ($itemCount >= 1) {
        $html .= '<div class ="wp-chatbot-cart-container">';
        $html .= '<div class="wp-chatbot-cart-header"><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_title'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_quantity'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_price'))) . '</div><div class="qcld-wp-chatbot-cell"></div></div>';
        $html .= '<div class ="wp-chatbot-cart-body">';
        foreach ($items as $item => $values) {
            $cart_item= apply_filters('woocommerce_cart_item_product', $values['data'], $values, $item);
            //product image
            $getProductDetail = wc_get_product($values['product_id']);
            $price = get_post_meta($values['product_id'], '_price', true);
            $html .= '<div class="wp-chatbot-cart-single">
                        <div class="qcld-wp-chatbot-cell"> <h3 class="wp-chatbot-title">' . esc_html($cart_item->get_title()) . '</h3></div>';
            $html .= '<div class="qcld-wp-chatbot-cell">';
            $html .= '<input class="qcld-wp-chatbot-cart-item-qnty" data-cart-item="' . esc_html($item) . '" type="number" min="1" value="' . esc_html($values['quantity']) . '"></div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span class="wp-chatbot-cart-price">' . apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($cart_item), $values, $item) . '</span> </div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span data-cart-item="' . esc_html($item) . '" class="wp-chatbot-remove-cart-item">X</span></div> </div>';
        }
        $html .= ' </div>';//End of cart body
        $html .= '<div class="wp-chatbot-cart-single">
                            <div class="qcld-wp-chatbot-cell"></div>
                            <div class="qcld-wp-chatbot-cell"><strong>Total</strong></div>
                            <div class="qcld-wp-chatbot-cell"><strong>' . ($woocommerce->cart->get_cart_total()) . '</strong></div>
                        </div>';
        $html .= '<div class="wp-chatbot-cart-footer"><div class="qcld-wp-chatbot-cart-page"><a class="wp-chatbot-cart-link" href="' . $cart_url . '"  >' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_link'))) . '</a></div><div class="qcld-wp-chatbot-checkout"><a class="wp-chatbot-checkout-link" href="' . esc_url($checkout_url) . '" >' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_checkout_link'))) . '</a></div></div>';
        $html .= ' </div>';
    } else {
        $html .= '<div class="wp-chatbot-cart-container">';
        $html .= '<div><p class="wpbot_p_align_center">' . $no_cart_item_msg . '</p></div>';
        $html .= '</div>';
    }
    $response = array('html' => $html, 'items' => $itemCount);
    echo wp_send_json($response);
    wp_die();
}

add_shortcode('wpbot-click-chat', 'qcld_wp_chatbot_chat_link');

function qcld_wp_chatbot_chat_link($atts = array()){
    extract( shortcode_atts(
		array(
            'text' => 'Click to Chat',
            'bot_visibility' => 'show',
            'intent' => '',
            'display_as'=> 'link',
            'bgcolor'=>'',
            'textcolor'=> ''
		), $atts
    ));
    
    $addclass = '';
    if($display_as =='button'){
        $addclass = 'qc_click_to_button';
    }

    $html =  '<span class="qc_wpbot_chat_link '.$addclass.'" data-intent="'.$intent.'">'.$text.'</span>';

    $html .='<style type="text/css">';
    if($bot_visibility=='hide'){
        $html .= '#wp-chatbot-chat-container{display:none}.fb_dialog{display:none !important}';        
    }
    if($bgcolor!=''){
        $html .= '.qc_wpbot_chat_link{background-color: '.$bgcolor.' !important}';        
    }
    if($textcolor!=''){
        $html .= '.qc_wpbot_chat_link{color: '.$textcolor.' !important}';        
    }
    $html .='</style>';
    return $html;
}

//Cart show Shortcode
add_shortcode('wpwbot_cart', 'qcld_wb_chatbot_cart_shortcode');
function qcld_wb_chatbot_cart_shortcode(){
    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    $itemCount = $woocommerce->cart->cart_contents_count;
    $cart_title = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_shopping_cart')));
    $no_cart_item_msg = qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_no_cart_items')));
    
    if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') == "custom-agent.png") {
        $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_agent_path');
    } else if (get_option('wp_chatbot_custom_agent_path') != "" && get_option('wp_chatbot_agent_image') != "custom-agent.png") {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_agent_image');
    } else {
        $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom-agent.png';
    }
    $html = '<div class="wp-chatbot-agent-profile">
            <div class="wp-chatbot-widget-avatar"><img src="' . esc_url($wp_chatbot_custom_icon_path) . '" alt=""></div>
            <div class="wp-chatbot-widget-agent">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_agent'))) . '</div>
            <div class="wp-chatbot-bubble">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_welcome'))) . '</div>
            </div>';
    if ($itemCount >= 1) {
        $html .= '<div class ="wp-chatbot-cart-container">';
        $html .= '<div class="wp-chatbot-cart-header"><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_title'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_quantity'))) . '</div><div class="qcld-wp-chatbot-cell">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_price'))) . '</div> <div class="qcld-wp-chatbot-cell"></div> </div>';
        $html .= '<div class ="wp-chatbot-cart-body">';
        foreach ($items as $item => $values) {
            $cart_item = apply_filters('woocommerce_cart_item_product', $values['data'], $values, $item);
            //product image
            $getProductDetail = wc_get_product($values['product_id']);
            $price = get_post_meta($values['product_id'], '_price', true);
            $html .= '<div class="wp-chatbot-cart-single">
                        <div class="qcld-wp-chatbot-cell"> <h3 class="wp-chatbot-title">' . esc_html($cart_item->get_title()) . '</h3></div>';
            $html .= '<div class="qcld-wp-chatbot-cell">';
            $html .= '<input class="qcld-wp-chatbot-cart-item-qnty" data-cart-item="' . esc_html($item) . '" type="number" min="1" value="' . esc_html($values['quantity']) . '"></div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span class="wp-chatbot-cart-price">' . apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($cart_item), $values, $item) . '</span> </div>';
            $html .= '<div class="qcld-wp-chatbot-cell"><span data-cart-item="' . esc_html($item) . '" class="wp-chatbot-remove-cart-item">X</span></div> </div>';
        }
        $html .= ' </div>';//End of cart body
        $html .= '<div class="wp-chatbot-cart-single">
                            <div class="qcld-wp-chatbot-cell"></div>
                            <div class="qcld-wp-chatbot-cell"><strong>Total</strong></div>
                            <div class="qcld-wp-chatbot-cell"><strong>' . esc_html($woocommerce->cart->get_cart_total()) . '</strong></div>
                        </div>';
        $html .= '<div class="wp-chatbot-cart-footer"><div class="qcld-wp-chatbot-cart-page"><a href="' . site_url() . '/cart" target="_blank" >' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_cart_link'))) . '</a></div><div class="qcld-wp-chatbot-checkout"><a href="' . site_url() . '/checkout" target="_blank">' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_checkout_link'))) . '</a></div></div>';
        $html .= ' </div>';
    } else {
        $html .= '<div class="wp-chatbot-cart-container">';
        $html .= '<div><p class="wpbot_p_align_center">' . esc_html($no_cart_item_msg) . '</p></div>';
        $html .= '</div>';
    }
    
    return $html;
}
//Updating the cart items.
add_action('wp_ajax_qcld_wb_chatbot_update_cart_item_number', 'qcld_wb_chatbot_update_cart_item_number');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_update_cart_item_number', 'qcld_wb_chatbot_update_cart_item_number');
function qcld_wb_chatbot_update_cart_item_number(){
    //getting cart items n
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $qnty = sanitize_text_field($_POST['qnty']);
    global $woocommerce;
    $result = $woocommerce->cart->set_quantity($cart_item_key, $qnty);
    echo wp_send_json($result);
    wp_die();
}
//Show item after removing from cart page.
add_action('wp_ajax_qcld_wb_chatbot_cart_item_remove', 'qcld_wb_chatbot_cart_item_remove');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_cart_item_remove', 'qcld_wb_chatbot_cart_item_remove');
function qcld_wb_chatbot_cart_item_remove(){
    //getting cart items n
    $cart_item_key = sanitize_text_field($_POST['cart_item']);
    global $woocommerce;
    $result = $woocommerce->cart->remove_cart_item($cart_item_key);
    echo wp_send_json($result);
    wp_die();
}
//Show cart page by shortcode.
add_action('wp_ajax_qcld_wb_chatbot_cart_page', 'qcld_wb_chatbot_cart_page');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_cart_page', 'qcld_wb_chatbot_cart_page');
function qcld_wb_chatbot_cart_page(){
    global $woocommerce;
    $itemCount = $woocommerce->cart->cart_contents_count;
    $html = "";
    if ($itemCount < 0) {
        $html .= qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_no_cart_items')));
    } else {
        $html .= do_shortcode("[woocommerce_cart]");
    }
    echo wp_send_json($html);
    wp_die();
}
//Show checkout page by shortcode.
add_action('wp_ajax_qcld_wb_chatbot_checkout_page', 'qcld_wb_chatbot_checkout_page');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_checkout_page', 'qcld_wb_chatbot_checkout_page');
function qcld_wb_chatbot_checkout_page(){
    global $woocommerce;
    $itemCount = $woocommerce->cart->cart_contents_count;
    $html = "";
    if ($itemCount < 0) {
        $status = 'no';
        $html .= qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_no_cart_items')));
    } else {
        $status = 'yes';
        $checkout_page_id = get_option('wp_chatbot_app_checkout');
        $checkout_parmanlink = esc_url(get_permalink($checkout_page_id));
        $html .= $checkout_parmanlink;
    }
    $response = array('status' => $status, 'html' => $html);
    echo wp_send_json($response);
    wp_die();
}
//User login on Checkout page.
add_action('wp_ajax_qcld_wb_chatbot_checkout_user_login', 'qcld_wb_chatbot_checkout_user_login');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_checkout_user_login', 'qcld_wb_chatbot_checkout_user_login');
function qcld_wb_chatbot_checkout_user_login(){
    // Nonce is checked, get the POST data and sign user on
    $info = array();
    
    $info['user_login'] = trim(sanitize_text_field($_POST['user_name']));
    $info['user_password'] = trim(sanitize_text_field($_POST['user_pass']));
    $info['remember'] = true;
    $user_signon = wp_signon($info, false);
    $response = array();
    if (is_wp_error($user_signon)) {
        
        $response = "no";
    } else {
        $response = "yes";
    }
    echo wp_send_json($response);
    die();
}

//User session count
add_action('wp_ajax_qcld_wb_chatbot_session_count', 'qcld_wb_chatbot_session_count');
add_action('wp_ajax_nopriv_qcld_wb_chatbot_session_count', 'qcld_wb_chatbot_session_count');
function qcld_wb_chatbot_session_count(){
    // Nonce is checked, get the POST data and sign user on
    global $wpdb;
    $wpdb->show_errors = true;
    $tableuser    = $wpdb->prefix.'wpbot_sessions';
    $response = array();
    

    $session_exists = $wpdb->get_row("select * from $tableuser where 1 and id = '1'");
		if(empty($session_exists)){
			$wpdb->insert(
				$tableuser,
				array(
					'session'   => 1,
				)
			);
		}else{

			$session_id = $session_exists->id;
			$wpdb->update(
				$tableuser,
				array(
					'session'=>($session_exists->session+1),
				),
				array('id'=>$session_id),
				array(
					'%d',
				),
				array('%d')
			);
		}
	
    echo wp_send_json($response);
    die();
}


// Load template for App Order Thank You page url
function qcld_wp_chatbot_load_app_template($template){
    if (is_page('wpwbot-mobile-app')) {
        return dirname(__FILE__) . '/templates/app-templates/app.php';
    }
    return $template;
}
add_filter('template_include', 'qcld_wp_chatbot_load_app_template', 99);
// Load template for App Order Thank You page url
function qcld_wp_chatbot_load_app_order_thankyou_template($template){
    if (is_page('wpwbot-app-order-thankyou')) {
        return dirname(__FILE__) . '/templates/app-templates/app-order-thankyou.php';
    }
    return $template;
}
add_filter('template_include', 'qcld_wp_chatbot_load_app_order_thankyou_template', 99);
// Load template for App checkout
function qcld_wp_chatbot_load_app_checkout_template($template){
    if (is_page('wpwbot-app-checkout')) {
        return dirname(__FILE__) . '/templates/app-templates/app-checkout.php';
    }
    return $template;
}
add_filter('template_include', 'qcld_wp_chatbot_load_app_checkout_template', 99);
// Create embed page when plugin install or activate

add_action('init', 'qcld_wp_chatbot_create_app_checkout_thankyou_page');
function qcld_wp_chatbot_create_app_checkout_thankyou_page(){

    
    //Keep tracking from App by cookies
    if (isset($_GET['from']) && $_GET['from'] == 'app') {
        if (!isset($_COOKIE['from_app'])) {
            setcookie('from_app', 'yes', (time() + 3600), '/');
        }
    }
}
/***
 * Override order Thank page for mobile app
 */
add_action('woocommerce_thankyou', 'qcld_wb_chatbot__redirect_after_purchase', 10, 1);
function qcld_wb_chatbot__redirect_after_purchase($order_get_id){
    if (isset($_COOKIE['from_app']) && $_COOKIE['from_app'] == 'yes') {
        global $wp;
        if (is_checkout() && !empty($wp->query_vars['order-received'])) {
            $thanks_page_id = get_option('wp_chatbot_app_order_thankyou');
            $thanks_parmanlink = esc_url(get_permalink($thanks_page_id));
            wp_redirect($thanks_parmanlink . '?order_id=' . $order_get_id);
            exit;
        }
    } else {
        remove_action('woocommerce_thankyou', 'qcld_wb_chatbot__redirect_after_purchase');
        //do_action('woocommerce_thankyou', $order_get_id);
    }
}

/* is operator online */

function wpbot_get_users(){
	
    static $cache = array();
    $cache_key = 'bot_users_cache';

    if ( isset( $cache[$cache_key] ) ) {
        return $cache[$cache_key];
    }

    $data = get_option('wbca_options');
    
    if(@$data['admin_able_to_chat']=='1'){
        $roles = array('operator', 'administrator');
    }else{
        $roles = array('operator');
    }
    
    
    $users = array();
    foreach($roles as $role){
        $current_user_role = get_users( array('role'=> $role));
        $users = array_merge($current_user_role, $users);
    }
    $cache[$cache_key] = $users;
    return $users;
}




function qcld_wpbot_is_operator_online(){

    global $wpdb;
    $operator = array();
    
    if(qcld_wpbot_is_active_livechat()){

        $users = wpbot_get_users();
        $data = get_option('wbca_options');
        $blogtime = strtotime(current_time( 'mysql' ));
        foreach ( $users as $user ) {
            $meta = strtotime(get_user_meta($user->ID, 'wbca_login_time', true));
            $user_status = get_user_meta($user->ID, 'wbca_login_status', true);
            $interval  = abs($blogtime - $meta);
            $minutes   = round($interval / 60);
            if($minutes <= 5 && $user_status=='online'){
                array_push($operator, $user->ID);
            }
    
        }

        if(!empty($operator)){
            return 1;
        }else {
            if(isset($data['always_allow_livechat']) && $data['always_allow_livechat']==true){
                return 1;
            }else{
                return 0;
            }
            
        }

    }else{

        return 0;

    }



}

/* livechat addon check */
function qcld_wpbot_is_active_livechat(){
    if((class_exists('wbca_Apps') )){

        return true;
    }else{
        return false;
    }
	
}

/* Extended ui check */

function qcld_wpbot_is_extended_ui_activate(){
    if(function_exists('qcpd_wpeui_dependencies')){
        return true;
    }else{
        return false;
    }
}


/* WPBot Chat History Addon check */
function qcld_wpbot_is_active_chat_history(){

    if(function_exists('qcwp_chat_session_menu_fnc')){
        return true;
    }else{
        return false;
    }

}

/* WPBot Post Type Search Addon check */
function qcld_wpbot_is_active_post_type_search(){

    if(class_exists('wbpt_Admin_Area_Controller')){
        return true;
    }else{
        return false;
    }    
	
}

/* WPBot white label Addon check */
function qcld_wpbot_is_active_white_label(){
	if(class_exists('wbwl_Admin_Area_Controller')){
        return true;
    }else{
        return false;
    }  

}

function wpbot_License_page_callback_func(){
    ob_start();
    wp_enqueue_script('qcld-wp-chatbot-license-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/license.js?tes', array('jquery'), true);
    wp_enqueue_style('qcld-wp-chatbot-help-page-css', QCLD_wpCHATBOT_PLUGIN_URL . 'css/help-page.css');
            
    wp_enqueue_style('qlcd-wp-chatbot-font-awe', QCLD_wpCHATBOT_PLUGIN_URL . 'css/font-awesome.min.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
           
    ?>

<div class="wrap swpm-admin-menu-wrap">
		
        <?php //wpbotpro_display_license_section(); ?>

        <h2 class="nav-tab-wrapper sld_nav_container wppt_nav_container">
            <a class="nav-tab sld_click_handle nav-tab-active" href="#general_help"><?php echo esc_html('Help'); ?></a>
            <a class="nav-tab sld_click_handle" href="#general_debugging"><?php echo esc_html('Debugging'); ?></a>
            <a class="nav-tab sld_click_handle" href="#general_nutshell"><?php echo esc_html('WPBot Nutshell'); ?></a>
            <a class="nav-tab sld_click_handle" href="#general_interactions"><?php echo esc_html('WPBot Interactions'); ?></a>
        </h2>

        <div class="qcld-wpbot-help-section wppt-settings-section" id="general_help">
            <h1>Welcome to the <?php echo wpbot_text(); ?><?php echo esc_html('Pro! You are awesome, by the way'); ?>  <img draggable="false" class="emoji" alt="ðŸ™‚" src="https://s.w.org/images/core/emoji/11/svg/1f642.svg"></h1>

            <div class="qcld-wpbot-section-block">
                <h2>Tutorials</h2>
                <p>You will find some helpful video tutorials and the ChatBot workflow on this <a href="https://dev.quantumcloud.com/wpbot-pro/chatbot-workflow/" target="_blank">page</a>.</p>
            </div>

            <div class="qcld-wpbot-section-block">
                <h2><?php echo esc_html('Simple Text Responses'); ?></h2>
                <p><?php echo esc_html('Create simple text responses easily for your chatbot. The ChatBot will use advanced search algorithm for natural language phrase matching with user input. You can also adjust the Phrase matching accuracy for better user experience.'); ?></p>
            </div>

            <div class="qcld-wpbot-section-block">
                <h2><?php echo esc_html('Keyboard Shortcut'); ?></h2>
                <p><strong style="font-weight:bold;">1.</strong>Press <strong>ctrl+b</strong><?php echo esc_html(' to open and close chatbot window in frontend.'); ?> </p>
				<p><strong style="font-weight:bold;">2.</strong> Press <strong>ESC</strong><?php echo esc_html(' to close chatbot window.'); ?> </p>
            </div>

            <div class="qcld-wpbot-section-block">
                <h2><?php echo esc_html('Shortcode for Widget'); ?></h2>
                <p><b><?php echo esc_html('[chatbot-widget]'); ?></b></p>
                    <p><?php echo esc_html('If you want to add the Bot as like widget then please add the above shortcode anywhere in the page. It will display like widget.'); ?> <br><b>Please Note -</b> The WPBot bot icon would not load on that page you have added the above shortcode.</p>
                <p><?php echo esc_html('Available Parameter: width, intent'); ?></p>
                <p><b>width</b><?php echo esc_html(': This parameter allow you to specify the widget width. Default value: 400px. You can also use percentage instead of pixel'); ?><br>
                <?php echo esc_html('Ex: [chatbot-widget width="400px"]'); ?>
                </p>
                <p><b>intent</b><?php echo esc_html(': This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents. Available Values: Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback, Request Callback,'); ?> <?php echo qc_dynamic_intent(); ?>
                <br><?php echo esc_html('Ex: [chatbot-widget intent="Request Callback"]'); ?>
                </p>
            </div>
            <div class="qcld-wpbot-section-block">
                <h2>Shortcode for Click to Chat</h2>
                <p><b>[wpbot-click-chat text="Click to Chat"]</b></p>
                <p><b>Available Parameters: text, bot_visibility, intent, display_as, bgcolor, textcolor</b></p>
                <p><b>text</b>: This is for the button text. Value for this option would be a text that will be automatically linked to open the ChatBot.<br>Ex: [wpbot-click-chat text="Click to Chat"]</p>
                <p><b>bot_visibility</b>: This is show or hide bot floating icon. Available values: show, hide. Default value is "show".<br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide"]</p>
                <p><b>intent</b>: This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents. Available Values: Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback, Request Callback, <?php echo qc_dynamic_intent(); ?>
                <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription"]
                </p>
                <p><b>display_as</b>: This parameter can control the appearence. Available values: button, link. Default value is "link".<br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" display_as="button"]</p>
                <p><b>bgcolor</b>: You can set the background color by using this parameter. <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription" display_as="button" bgcolor="#3389a9"]</p>
                <p><b>textcolor</b>: You can set the text color by using this parameter. <br>Ex: [wpbot-click-chat text="Click to Chat" bot_visibility="hide" intent="Email Subscription" display_as="button" bgcolor="#3389a9" textcolor="#fff"]</p>
            </div>
            <div class="qcld-wpbot-section-block">
                <h2>Show Bot on a Page</h2>
                <b>[wpbot-page]</b> <?php echo esc_html__('on any page to display Bot on that page.', 'wpchatbot'); ?> </p>
                <p>Available Parameter: intent</p>
                <p><b>intent</b>: This parameter allow you to trigger specific intent. It does support all pre-defined & custom intents. Available Values: Faq, Email Subscription, Site Search, Send Us Email, Leave A Feedback, Request Callback, <?php echo qc_dynamic_intent(); ?>
                <br>Ex: [wpbot-page intent="Send Us Email"]
                </p>
            </div>
                
            <div class="qcld-wpbot-section-block">
                <h2>Language Settings</h2>
                <p><strong style="font-weight:bold;">1.</strong> You can use this variable for user name: %%username%%</p>
                <p><strong style="font-weight:bold;">2.</strong> Insert full link to an image to show in the chatbot responses like https://www.quantumcloud.com/wp/sad.jpg</p>
                <p><strong style="font-weight:bold;">3.</strong> Insert full link to an youtube video to show in the chatbot responses like https://www.youtube.com/watch?v=gIGqgLEK1BI</p>
                <p><strong style="font-weight:bold;">4.</strong> After making changes in the language center or settings, please type reset and hit enter in the ChatBot to start testing from the beginning or open a new Incognito window (Ctrl+Shit+N in chrome).</p>
                <p><strong style="font-weight:bold;">5.</strong> You could use &lt;br&gt; tag in Language Center & Dialogflow Responses for line break.</p>
            </div>
            
            

            <div class="qcld-wpbot-section-block">
                <h2>Dialogflow KnowledgeBase Beta Feature</h2>
                <p>The Chatbot shamelessly supports Dialogflow KnowledgeBase beta feature.</p>
                <p>All you have to do is Enable the Beta Features and APIs.
                    <br>
                    <br>
                    <img style="width: 80%;" src="<?php echo QCLD_wpCHATBOT_IMG_URL . 'enable_beta_features_apis.png' ?>" />
                    <br>
                </p>
                <p>Then you need to create KnowledgeBase in Dialogflow.
                    <br>
                    <br>
                    <img style="width: 80%;" src="<?php echo QCLD_wpCHATBOT_IMG_URL . 'create-knowledgebase.png' ?>" />
                    <br>
                </p>
            </div>

            

		</div>
        <div class="qcld-wpbot-help-section wppt-settings-section" style="display:none" id="general_debugging">


            <div class="qcld-wpbot-section-block">
                <h2 style="font-size:20px">Problem: I changed language and/or some settings but do not see the changes.</h2>
                <p>WPBot saves a lot of information in the browser's local storage. After making any language or settings change you must clear browser cache and cookies both and reload the page for testing. An easier alternative is to always launch a new browser window in Incognito mode (Ctrl+Shift+N in chrome) and test there. Also, you need to purge cache plugin and CDN caching if you have any.</p>
            </div>
            <div class="qcld-wpbot-section-block">
                <h2 style="font-size:20px">Problem: I cannot connect to the DialogFlow</h2>
                <p>To Debug: 1. Make sure that you have created the Google Project and the Service account as an Owner<br>
                2. Make sure that you have connected to the correct Dialogflow agen<br>
                3. Follow the steps in this tutorial correctly: <a href="https://dev.quantumcloud.com/wpbot-pro/dialogflow-integration/" target="_blank">https://dev.quantumcloud.com/wpbot-pro/dialogflow-integration/</a><br>
                4. Make sure that the Google Client Package is Installed on Your Website.<br>
                5. Make sure to download and import the sample DialogFlow agent to your agent<br>
                6. Test the ChatBot in the browser Incognito mode</p>
            </div>
            <div class="qcld-wpbot-section-block">
                <h2 style="font-size:20px">Problem: I am not getting emails from the ChatBot</h2>
                <p>The WPBot ChatBot uses the WordPress' default email function. If you are not getting emails from the ChatBot's email feature, it is likely that no emails are getting through from your WordPress site or they are ending up in the Spam box. Try using an SMTP mailer plugin. Also, try changing the to and from email addresses in the ChatBot's general settings area.</p>
            </div>
            <div class="qcld-wpbot-section-block">
                <h2 style="font-size:20px">Problem: Simple text responses are not working or getting an error</h2>
                <p>WPBot requires mysql version 5.6+ for the simple text responses to work. If your server has a version below that, you might see some PHP error or the Simple Text Responses will not work at all. Please request your hosting support to update the mysql version on your server.</p>
            </div>
            <div class="qcld-wpbot-section-block">
                <h2 style="font-size:20px">Problem: I changed language or some other settings but do not see them when testing</h2>
                <p>Please clear the browser cache and <strong>cookies</strong> to see any change you have made. Alternatively, you can open a fresh browser window in incognito mode (Ctrl+Shift+N in chrome) to test your changes. Also, you may need to purge any cache plugin and CDN caching.</p>
            </div>

            <div class="qcld-wpbot-section-block">
                <h2 style="font-size:20px">Problem: The ChatBot is NOT working in the front end.</h2>
                <p>The most common reason for this is if the theme is coded incorrectly and jQuery is loaded from external source. jQuery is included with WordPress core and according to WordPress standard, jQuery must be included using wp_enqueue_script. <a href="https://developer.wordpress.org/reference/functions/wp_enqueue_script/" target="_blank">https://developer.wordpress.org/reference/functions/wp_enqueue_script/</a> . Please make sure if that is the case in your theme.<br>
                    Also go to Simple Text Responses and press the Re-Index button.</br>
                    After that try purging any cache and test the chatbot in Incognito mode<br>

                    Please contact us if you need [further help](<a href="https://www.quantumcloud.com/resources/free-support/" target="_blank">https://www.quantumcloud.com/resources/free-support/</a>). We take all user feedback sriously.

                </p>
            </div>

            <div class="qcld-wpbot-section-block">
                <h2 style="font-size:20px">Problem: The ChatBot is stuck on typing or loading</h2>
                <p>This usually happens if you enabled DialogFlow but did not complete the set up. Please make sure that you have carefully followed all the steps for DialogFlow integration in the Settings->DialogFlow section.<br>
                This can also happen if there is any empty language fields or Simple Text Responses database needs updating because of mysql version changes. Try saving both the Language Center and Simple Text Responses and test again.<br>
                Also go to Simple Text Responses and press the Re-Index button.</br>
                After that remember to test in a browser Incognito mode to avoid cache and cookies. </p>
            </div>

            <div class="qcld-wpbot-section-block">
                <h2 style="font-size:20px">Problem: How do I add new conversations to the ChatBot?</h2>
                <p>Please check the plugin's Help Section for details on this</p>
            </div>
            
            <div class="qcld-wpbot-section-block">
                <h2 style="font-size:20px">Problem: How do I add Line Breaks?</h2>
                <p>Please use the &lt;br&gt; tag for line breaks.</p>
            </div>
            
            <div class="qcld-wpbot-section-block">
                <h2 style="font-size:20px">Problem: Are HTML tags supported? </h2>
                <p>Yes, common HTML tags link link href, strong, br etc. are supported.</p>
            </div>
            
            <div class="qcld-wpbot-section-block">
                <h2 style="font-size:20px">Problem: I want to add images, GIFs, Videos</h2>
                <p>Images, GIFs and Youtube Videos are supprted in the pro version. Pro version also includes a handy giphy floating search feature for easy embed in the language center.</p>
            </div>

        </div>
        
        
        <div class="qcld-wpbot-help-section wppt-settings-section" style="display:none" id="general_nutshell">
        <h2 style="margin-top: 10px;"><?php echo esc_html('WPBot – In a Nutshell'); ?></h2>
                      <h3 style=" color: #222; margin: 0; padding: 0 0 12px 0; font-size: 16px; font-weight: bold;"><?php echo esc_html__('This is by no means a comprehensive list of WPBot features. But knowing these core terms will help you understand how WPBot was designed to work.', 'wpbot'); ?></h3>
                      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="qcld-wpbot-section-block">
                            <h4 class="panel-title"><?php esc_html_e('Intents', 'wpbot'); ?></h4>
                            <p>
                                 <?php echo esc_html_e(' Intent is all about what the user wants to get out of the interaction. Whenever a user types something or clicks a button, the ChatBot will try to understand what the user wants and fulfill the request with appropriate responses.'); ?></br></br>
                                  <?php echo esc_html_e('You have to create possible Intent Responses using different features of the WPBot so the bot can respond accordingly. You can create Responses for various Intents using:'); ?><b>
                                  <?php echo esc_html_e('Simple Text Responses, Conversational form builder, FAQ, Site Search, Send an eMail, Newsletter Subscription, DialogFlow, OpenAI etc.'); ?></b></br></br>
                                  <?php echo esc_html_e('Please check this article for'); ?> <span class="nav-tab-wrapper wppt_nav_container wpbotflattabbutton">
                                    <a class="nav-tab sld_click_handle" href="#general_interactions">WPBot Interactions</a>
                                </span> <?php echo esc_html_e('on how you can create Intents and Responses.'); ?>
                                        
                            </p>
                        </div>
                        <div class="qcld-wpbot-section-block">
                            <h4><?php esc_html_e('Start Menu', 'wpbot'); ?></h4>
                            <p>
                                <?php echo esc_html_e('While using a ChatBot, users can get lost or not know how to Interact with the Bot. That is why we have a Start menu to always give the user'); ?> <b><?php echo esc_html_e('options to do more'); ?></b>. <?php echo esc_html_e('From ChatBot->Settings->Start Menu you can drag Available Menu Items (Intents) to the Active Menu Items area.'); ?></br></br>
                                  <?php echo esc_html_e('Besides the built-in Intents, you can also create custom Intents for your Start Menu using'); ?> <b><?php echo esc_html_e('Simple Text Responses'); ?></b> and <b><?php echo esc_html_e('Conversational form builder'); ?></b>. <?php echo esc_html_e('You can create almost any kind of response with the combinations of the two.'); ?></br></br>
                                  <?php echo esc_html_e('We recommend enabling'); ?><b><?php echo esc_html_e(' Show Start Menu After Greetings '); ?></b><?php echo esc_html_e('from ChatBot Pro->Settings->General settings.'); ?>

                            </p>
                        </div>
                        <div class="qcld-wpbot-section-block">
                            <h4><?php esc_html_e('Settings', 'wpbot'); ?></h4>
                            <p>
                                <?php echo esc_html_e('Head over to ChatBot Pro->Settings->General and make sure to Enable the Floating Icon. As soon as you do that, the ChatBot can start working for your users. Make sure to drag some items to the Active Menu area under the Start Menu.'); ?></br></br>
                                <?php echo esc_html_e('The ChatBot settings area is full of options. Do not be intimidated by that. You do not need to use all the options – just what you need. Head over to the Settings->'); ?><b><?php echo esc_html_e('Icons and Themes'); ?></b> <?php echo esc_html_e('for options to customize your ChatBot. You will also find options to embed the ChatBot on a page, click to chat, FAQ builder etc. under the Setting options.'); ?>
                           
                            </p>
                        </div>
                        <div class="qcld-wpbot-section-block">
                              <h4><?php esc_html_e('Language Center', 'wpbot'); ?></h4>
                            <p>
                              <?php echo esc_html_e('You can use the ChatBot in'); ?> <b><?php echo esc_html_e('ANY language'); ?></b>. <?php echo esc_html_e('Just translate the texts used by the ChatBot from the WordPress dashboard ChatBot Pro->'); ?><b><?php echo esc_html_e('Language Center. Multi language'); ?></b> <?php echo esc_html_e('module is available in the Master License..'); ?>
                            </p>
                        </div>
                        <div class="qcld-wpbot-section-block">
                              <h4> <?php esc_html_e('Simple Text Responses', 'wpbot'); ?></h4>
                            </div>
                            <p>
                                  <?php echo esc_html_e('You can use ChatBot Pro->Simple Text Responses to create'); ?> <b><?php echo esc_html_e('text-based responses'); ?></b> <?php echo esc_html_e('that users may ask your ChatBot. Just define the questions, answers, and some keywords and you are done. This is a much simpler'); ?>  <b><?php echo esc_html_e('alternative '); ?></b> <?php echo esc_html_e('to DialogFlow or OpenAI.'); ?>
                            </p>
                        </div>
                        <div class="qcld-wpbot-section-block">
                              <h4>
                                <?php esc_html_e('Conversational Forms', 'wpbot'); ?>
                              </h4>
                              <p>
                                    <?php echo esc_html_e('Use conversational forms to collect information from the users. This is also great for Button driven workflow. Create conditional conversations and forms for a native WordPress ChatBot experience. Build Standard Forms, Dynamic Forms with'); ?> <b> <?php echo esc_html_e('conditional fields, Calculators, Appointment booking'); ?></b> <?php echo esc_html_e('etc.'); ?>
                                </p>
                        </div>
                        <div class="qcld-wpbot-section-block">
                            <h4 class="panel-title">
                              <?php esc_html_e('OpenAI or DialogFlow', 'wpbot'); ?>
                            </h4>
                            <p> 
                                  <?php echo esc_html_e('If you need a bot that can understand natural language better, use either OpenAI or DialogFlow. Between the two'); ?> <b> <?php echo esc_html_e('DialogFlow'); ?></b> <?php echo esc_html_e('is better if you want to'); ?> <b> <?php echo esc_html_e('provide customer support'); ?></b>. <?php echo esc_html_e('OpenAI is better at generic questions and training OpenAI also requires a large dataset. But you do not have to use either 3rd party service. Using OpenAI or DialogFlow requires some patience and'); ?> <b> <?php echo esc_html_e('effort'); ?></b>. <?php echo esc_html_e('You may very well achieve what you need using '); ?><b> <?php echo esc_html_e('Simple Text Responses'); ?></b> <?php echo esc_html_e('and/or'); ?> <b> <?php echo esc_html_e('Conversational form builder'); ?></b> <?php echo esc_html_e('instead.'); ?>
                            
                            </p>
                        </div>
                        <div class="qcld-wpbot-section-block">
                            <h4 >
                                <?php esc_html_e('Getting Help', 'wpbot'); ?>  
                            </h4>
                            <p>
                                    <?php echo esc_html_e('We have built-in Help section under each module. Please check them out and you will get many answers to the questions you may have. If you cannot find the answer to something particular, just '); ?><a href="<?php echo esc_url('https://www.wpbot.pro/free-support/'); ?>"><?php echo esc_html_e('contact us.'); ?></a>  <b><?php echo esc_html_e('Pro version '); ?></b><?php echo esc_html_e('users can open a support ticket from'); ?> <a href="<?php echo esc_url('https://qc.ticksy.com/'); ?>"><?php echo esc_html_e('here'); ?></a>.<?php echo esc_html_e('We are '); ?><b><?php echo esc_html_e('friendly '); ?></b><?php echo esc_html_e('and always here to help.'); ?>
                            </p>
                        </div>
                      <div style="clear:both"></div>
        </div>
        <div class="qcld-wpbot-help-section wppt-settings-section" style="display:none" id="general_interactions">
            <div class="qcld-wpbot-section-block">
                        <div class="content form-container qcbot_help_secion" style="padding: 10px;">
                        <!-- new Section -->
                            <h2 style="margin-top: 10px;">WPBot Interactions</h2>
                            <h3 style=" color: #222; margin: 0; padding: 0 0 12px 0; font-size: 16px; font-weight: bold;">You can create user interactions in the following ways:</h3>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Predefined intents - Built-in ChatBot Features
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    Predefined intents can work without integration to DialogFlow API and AI. These are readily available as soon as you install the plugin and can be turned on or off individually.
                                    <div class="section-container">
                                        <div class="wpb_column vc_column_container vc_col-sm-6">
                                        <div class="vc_column-inner ">
                                            <div class="wpb_wrapper">
                                            <div class="to-icon-box  left txt-left">
                                                <div class="to-icon-txt fa-4x-txt ">
                                                <h3>
                                                    <span>// </span>Simple Text Responses
                                                </h3>
                                                <p>Create unlimited text responses from your WordPress backend. The ChatBot uses advanced search algorithm for natural language phrase matching with user input. </p>
                                                </div>
                                            </div>
                                            <div class="to-icon-box  left txt-left">
                                                <div class="to-icon-txt fa-4x-txt ">
                                                <h3>
                                                    <span>// </span>Send eMail, Call Me Back &amp; Feedback Collection
                                                </h3>
                                                <p>Users can send a email to the site admin directly from the Chat window for customer support. The Call Me Back feature lets you get call requests from your customers which will be emailed to you. You can also use WPBot to collect Feedback from your customers regarding anything! You can disable/enable these features from the Start Menu. </p>
                                                </div>
                                            </div>
                                            <div class="to-icon-box  left txt-left">
                                                <div class="to-icon-txt fa-4x-txt ">
                                                <h3>
                                                    <span>// </span>Advanced Site Search <span class="qc_wpbot_pro">PRO</span>
                                                </h3>
                                                <p>If no matching text response is found WPBot will conduct an advanced website search and try to match user queries with your website contents and show results. </p>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="wpb_column vc_column_container vc_col-sm-6">
                                        <div class="vc_column-inner ">
                                            <div class="wpb_wrapper">
                                            <div class="to-icon-box  left txt-left">
                                                <div class="to-icon-txt fa-4x-txt ">
                                                <h3>
                                                    <span>// </span>Frequently Asked Questions
                                                </h3>
                                                <p>Create a set of Frequently Asked Questions or FAQ so users can quickly find answers to the most common questions they have.</p>
                                                </div>
                                            </div>
                                            <div class="to-icon-box  left txt-left">
                                                <div class="to-icon-txt fa-4x-txt ">
                                                <h3>
                                                    <span>// </span>Ask for name, email, phone number etc.
                                                </h3>
                                                <p>Asking for the name is the default workflow. In the pro version, you can also ask for an email and phone number if you want to or skip the Greetings part altogether and load any intent of your choice.</p>
                                                </div>
                                            </div>
                                            <div class="to-icon-box  left txt-left">
                                                <div class="to-icon-txt fa-4x-txt ">
                                                <h3>
                                                    <span>// </span>Newsletter Subscription <span class="qc_wpbot_pro">PRO</span>
                                                </h3>
                                                <p>WPBot can prompt User for eMail subscription. Link this with your Retargeting ChatBot window popup and a special offer. People can register their email address that you can later export as CSV! <strong>GDPR compliant</strong> with unsubscribe option from the ChatBot! </p>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="">
                                    <div class="" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Menu Driven - Created with Conversational Form Builder Addon
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="">
                                        <p>Extend the Start Menu with the <strong>powerful Conversational Forms</strong>&nbsp; Addon for WPBot. It extends WPBot’s functionality and adds the ability to create <strong>conditional conversations</strong> and/or <strong>forms</strong> for the WPBot. It is a visual, <strong> drag and drop</strong> form builder that is easy to use and very flexible. Supports conditional logic and use of variables to build all types of forms or just <strong>menu driven</strong>
                                        <strong>conversations </strong>with if else logic <strong>. </strong>Conversations or forms can be <strong>eMailed</strong> to you and <strong>saved in the database</strong>.
                                        </p>
                                        <h4>Conversational Form Builder Free or Pro version works with the WPBot Free or Pro versions.</h4>
                                        <a class="FormBuilder" href="https://wordpress.org/plugins/conversational-forms/" target="_blank">Download Free Version</a>
                                        <a class="FormBuilder" href="https://www.quantumcloud.com/products/conversations-and-form-builder/" target="_blank">Grab the Pro version</a>
                                        <h4>What Can You Do with it?</h4>
                                        <p>Conversation Forms allows you to create a wide variety of forms, that might include:</p>
                                        <ul>
                                        <li>Create menu or button driven conversations</li>
                                        <li>Conditional <strong>Menu Driven Conversations</strong>
                                            <span class="qc_wpbot_pro" style="font-size: 9px;">PRO</span>
                                        </li>
                                        <li>Standard Contact Forms</li>
                                        <li>Dynamic, <strong>conditional Forms</strong> – where fields can change based on the user selections <span class="qc_wpbot_pro" style="font-size: 9px;">PRO</span>
                                        </li>
                                        <li>Job <strong>Application Forms</strong>
                                        </li>
                                        <li>
                                            <strong>Lead Capture</strong> Forms
                                        </li>
                                        <li>Various types of <strong>Calculators</strong>
                                            <span class="qc_wpbot_pro" style="font-size: 9px;">PRO</span>
                                        </li>
                                        <li>Feedback <strong>Survey</strong> Forms etc. </li>
                                        </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="qcld-wpbot-section-block">
                            <div class="" role="tab" id="headingThree">
                                <h4 class="">
                                    DialogFlow ES and CX
                                </h4>
                            </div>
                            <div class="row">
                                <div class="wpb_column">
                                    <div class="wpb_wrapper">
                                        <h2 style="font-size: 20px;">DialogFlow Essential</h2> Intents created in Dialogflow give you the power to build a truly human like, intelligent and comprehensive chatbot. Build any type of Intents and Responses (including rich message responses) directly in DialogFlow and train the bot accordingly. When you create custom intents and responses in DialogFlow, WPBot will <strong>automatically</strong> display them when user inputs match with your Custom Intents along with the responses you created. You can also build Rich responses by enabling Facebook messenger Response option. <p></p>
                                        <p style="text-align: left;">In addition you can also Enable <strong>Advanced Chained Question and Answers</strong> using follow up Intents, Contexts, Entities etc. and then have resulting answers from your users emailed to you. This feature lets you create a a series of questions in DialogFlow that will be asked by the bot and based on the user inputs a response will be displayed. <span class="qc_wpbot_pro" style="font-size: 9px;">PRO</span>
                                        </p>
                                        <p style="text-align: left;">WPBot also supports Rich responses using Facebook Messenger integration. This allows you to display Image, <strong>Cards</strong>, Quick Text Reply or Custom PayLoad inside the ChatBot window. You can also insert an <strong>image</strong> or <strong>youtube video</strong> link inside the DialogFlow responses and they will be automatically rendered by the WPBot! <span class="qc_wpbot_pro" style="font-size: 9px;">PRO</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="wpb_column">
                                    <div class="wpb_wrapper">
                                            <h2 style="font-size: 20px;">DialogFlow CX <span class="qc_wpbot_pro">PRO</span>
                                            </h2>
                                            <p>WPBot supports <strong>visual workflow builder</strong> Dialogflow CX. It provides a new way of designing agents, taking a state machine approach to agent design. This gives you clear and explicit control over a conversation, a better end-user experience, and a better development <strong>workflow</strong>. </p>
                                            <ul>
                                                <li>
                                                <strong>Console visualization</strong>: A new <strong>visual builder</strong> makes building and maintaining agents easier. Conversation paths are graphed as a state machine model, which makes conversations easier to design, enhance, and maintain.
                                                </li>
                                                <li>
                                                <strong>Intuitive and powerful conversation control</strong>: Conversation states and state transitions are first-class types that provide explicit and powerful control over conversation paths. You can clearly define a series of steps that you want the end-user to go through.
                                                </li>
                                                <li>
                                                <strong>Flows for agent partitions</strong>: With flows, you can partition your agent into smaller conversation topics. Different team members can own different flows, which makes large and complex agents easy to build.
                                                </li>
                                                <img style="width:100%" src="http://devel1/wpbot/wp-content/plugins/chatbot/images/dialogflow-cx-1024x676.jpg" alt="Dialogflow CX">
                                            </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- end new Section -->
                        </div>
                        </div>  
                        </div>
                        </div>          
                    </div>        
        </div>
<script type="text/javascript">
jQuery(document).ready(function($){
    jQuery('.wppt_nav_container .nav-tab').on('click', function(e){
        e.preventDefault();
        var section_id = jQuery(this).attr('href');
        jQuery('.wppt_nav_container .nav-tab').removeClass('nav-tab-active');
        jQuery(this).addClass('nav-tab-active');
        jQuery('.wppt-settings-section').hide();
        jQuery('.wppt-settings-section').each(function(){
            jQuery(section_id).show();
        });
    });
})
</script>

    <?php
    $content = ob_get_clean();
    echo $content;
}



/*
 *
 * Widget Shortcode
 */

function qc_wpbot_theme_chatbot_shortcode($atts = array())
{

    // Attributes
    extract( shortcode_atts(
        array(
            'width' => '400px',
            'intent'=> '',
            'hud_design' => ''
		), $atts
	));
    if(get_option('enable_wp_chatbot_sound_initial')==1 || get_option('enable_wp_chatbot_sound_botmessage')==1): ?>
        <audio id="wp-chatbot-proactive-audio" <?php if (get_option('enable_wp_chatbot_sound_initial') == 1){
            echo "autoplay";
        } ?>>
            <source src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'pro-active.mp3'); ?>">
            </source>
        </audio>
    <?php endif;
    wp_enqueue_style('qcld-wp-chatbot-widget-css');
    ob_start();
    if(($hud_design !='') && !is_admin()){
        if($hud_design == 'lite'){
            require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/hud-lite/shortcode.php');
            wp_register_style('qcld-wp-chatbot-shortcode-hudlite-style', QCLD_wpCHATBOT_PLUGIN_URL . 'templates/hud-lite/shortcode.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qcld-wp-chatbot-shortcode-hudlite-style');
        }
        if($hud_design == 'dark'){
            require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/hud-dark/shortcode.php');
            wp_register_style('qcld-wp-chatbot-shortcode-huddark-style', QCLD_wpCHATBOT_PLUGIN_URL . 'templates/hud-dark/shortcode.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qcld-wp-chatbot-shortcode-huddark-style');
        }

    }else{
        require_once(QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '/templates/widget/shortcode.php');
    }
}
add_shortcode('chatbot-widget', 'qc_wpbot_theme_chatbot_shortcode');
function qcld_wpbot_field_valudation_df(){

    //checking date
    if(!qcld_wpbot_is_active_white_label()){
        $date = date('Y-m-d', strtotime(get_option('qcwp_install_date'). ' + 7 days'));
        if($date < date('Y-m-d')){
            echo get_option('_qopced_wgjegdselsdfj_');
        }
    }
   
    
}

function wpbot_menu_text(){

    if(qcld_wpbot_is_active_white_label() && get_option('wpwl_word_wpbot_pro')!=''){
        return get_option('wpwl_word_wpbot_pro');
    }else{
        return 'Chatbot Pro';
    }

}

function wpbot_text(){

    if(qcld_wpbot_is_active_white_label() && get_option('wpwl_word_wpbot')!=''){
        return get_option('wpwl_word_wpbot');
    }else{
        return 'Chatbot';
    }

}

add_action('init', 'qcwp_email_subscription_delete');
function qcwp_email_subscription_delete(){

    global $wpdb;
    $table             = $wpdb->prefix.'wpbot_subscription';
    if(isset($_POST['wpbot_email_subscription_remove']) && !empty($_POST['emails'])){
        $emails = $_POST['emails'];
        foreach($emails as $id){
            do_action( 'qcld_mailing_list_unsubscription_by_admin', $id, $table );
            $wpdb->delete(
				"$table",
				array( 'id' => $id ),
				array( '%d' )
			);
        }
        wp_redirect(admin_url( 'admin.php?page=email-subscription&msg=success'));exit;
    }

}

function qcld_wpbot_modified_keyword($keyword){
    $keyword = rtrim($keyword, '!');
    $pattern = '/[?\/]/';
    $strings = preg_split( $pattern, $keyword );
    $strings = array_filter(array_map('trim', $strings));
    $keyword = rtrim($strings[0], '!');
    return htmlspecialchars_decode($keyword);
}

function qcld_choose_random($array){
    if( is_array( $array ) ) {
        return $array[array_rand($array)];
    }else {
        return $array;
    }
    
}

if(!function_exists('qc_get_formbuilder_forms')){
    function qc_get_formbuilder_forms(){
        global $wpdb;
        $forms = array();
        if(class_exists('Qcformbuilder_Forms_Admin')){
            $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
            if(!empty($results)){
                foreach($results as $result){
                    $form = maybe_unserialize($result->config);
                    if(isset($form['name'])){
                        $forms[] = trim($form['name']);
                    }
                }
                return $forms;
            }else{
                return array();   
            }
        }else{
            return array();
        }
    }
}
if(!function_exists('qc_get_formbuilder_form_commands')){
    function qc_get_formbuilder_form_commands(){
        global $wpdb;
        $command = array();
        if(class_exists('Qcformbuilder_Forms_Admin')){
            $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
            if(!empty($results)){
                foreach($results as $result){
                    $form = maybe_unserialize($result->config);
                    
                    if(isset($form['command'])){
                        $command[] = array_map('trim', explode(',', strtolower($form['command'])));
                    } 
                    
                }
                return $command;
            }else{
                return array();   
            }
        }else{
            return array();
        }
    }
}
if(!function_exists('qc_get_formbuilder_form_ids')){
    function qc_get_formbuilder_form_ids(){
        global $wpdb;
        $forms = array();
        if(class_exists('Qcformbuilder_Forms_Admin')){
            $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
            if(isset($results)){
                foreach($results as $result){
                    $form = maybe_unserialize($result->config);
                    if(!empty($form['ID'])){
                        $forms[] = trim($form['ID']);
                    }
                }
                return $forms;
            }else{
                return array();   
            }
        }else{
            return array();
        }
    }
}

function qc_is_formbuilder_active(){

    if(class_exists('Qcformbuilder_Forms_Admin')){
        return true;
    }else{
        return false;
    }

}

function qc_is_chatsession_active() {
    if ( function_exists( 'qcwp_chat_session_menu_fnc' ) ) {
        return true;
    } else {
        return false;
    }
}

function qc_dynamic_intent(){
    global $wpdb;
    $intents = array();
 
    $ai_df = get_option('enable_wp_chatbot_dailogflow');
    $custom_intent_labels = maybe_unserialize( get_option('qlcd_wp_custon_intent_label'));
    if($ai_df==1 && isset($custom_intent_labels[0]) && trim($custom_intent_labels[0])!=''):

        foreach($custom_intent_labels as $custom_intent_label):
            $intents[] = $custom_intent_label;
        endforeach;
        
    endif;

    

    if(class_exists('Qcformbuilder_Forms_Admin')){
        

        $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
        if(!empty($results)){

            foreach($results as $result){
                $form = maybe_unserialize($result->config);
                $intents[] = $form['name'];
            }

        }
    }
    
    if(!empty($intents)){
        return implode(", ", $intents);
    }else{
        return '';
    }

}

function qc_get_all_intents($language = ''){
    if($language == ''){
        $language = get_wpbot_locale();
    }
    $array = array();

    $array['predefined'] = array();

    $support_wildcard = get_option('qlcd_wp_chatbot_wildcard_support');
    if( $support_wildcard && isset( $support_wildcard[$language] ) ){
        $support_wildcard = $support_wildcard[$language];
    }else{
        $support_wildcard = 'Faq';
    }
    $array['predefined'][] = $support_wildcard;

    $support_wildcard = get_option('qlcd_wp_email_subscription');
    if( $support_wildcard && isset( $support_wildcard[$language] ) ){
        $support_wildcard = $support_wildcard[$language];
    }else{
        $support_wildcard = 'Email Subscription';
    }
    $array['predefined'][] = $support_wildcard;

    $support_wildcard = get_option('qlcd_wp_site_search');
    if( $support_wildcard && isset( $support_wildcard[$language] ) ){
        $support_wildcard = $support_wildcard[$language];
    }else{
        $support_wildcard = 'Site Search';
    }
    $array['predefined'][] = $support_wildcard;

    $support_wildcard = get_option('qlcd_wp_send_us_email');
    if( $support_wildcard && isset( $support_wildcard[$language] ) ){
        $support_wildcard = $support_wildcard[$language];
    }else{
        $support_wildcard = 'Send Us Email';
    }
    $array['predefined'][] = $support_wildcard;
    
    $support_wildcard = get_option('qlcd_wp_leave_feedback');
    if( $support_wildcard && isset( $support_wildcard[$language] ) ){
        $support_wildcard = $support_wildcard[$language];
    }else{
        $support_wildcard = 'Leave A Feedback';
    }
    $array['predefined'][] = $support_wildcard;

    $support_wildcard = get_option('qlcd_wp_good_bye');
    if( $support_wildcard && isset( $support_wildcard[$language] ) ){
        $support_wildcard = $support_wildcard[$language];
    }else{
        $support_wildcard = 'GoodBye';
    }
    $array['predefined'][] = $support_wildcard;
    
    if(function_exists('qcpd_wpwc_addon_lang_init')){

        $array['woocommerce'] = array();

        $chatbot_wildcard = maybe_unserialize( get_option('qlcd_wp_chatbot_wildcard_product') );
        if( $chatbot_wildcard && isset( $chatbot_wildcard[$language] ) ){
            $chatbot_wildcard = qcld_choose_random( $chatbot_wildcard[$language] );
        }else{
            $chatbot_wildcard = qcld_choose_random( $chatbot_wildcard[get_wpbot_locale()] );
        }
        $array['woocommerce'][] = $chatbot_wildcard;

        $chatbot_wildcard = maybe_unserialize( get_option('qlcd_wp_chatbot_wildcard_catalog') );
        if( $chatbot_wildcard && isset( $chatbot_wildcard[$language] ) ){
            $chatbot_wildcard = qcld_choose_random( $chatbot_wildcard[$language] );
        }else{
            $chatbot_wildcard = qcld_choose_random( $chatbot_wildcard[get_wpbot_locale()] );
        }
        $array['woocommerce'][] = $chatbot_wildcard;

        $chatbot_wildcard = maybe_unserialize( get_option('qlcd_wp_chatbot_featured_products') );
        if( $chatbot_wildcard && isset( $chatbot_wildcard[$language] ) ){
            $chatbot_wildcard = qcld_choose_random( $chatbot_wildcard[$language] );
        }else{
            $chatbot_wildcard = qcld_choose_random( $chatbot_wildcard[get_wpbot_locale()] );
        }
        $array['woocommerce'][] = $chatbot_wildcard;
        
        $chatbot_wildcard = maybe_unserialize( get_option('qlcd_wp_chatbot_sale_products') );
        if( $chatbot_wildcard && isset( $chatbot_wildcard[$language] ) ){
            $chatbot_wildcard = qcld_choose_random( $chatbot_wildcard[$language] );
        }else{
            $chatbot_wildcard = qcld_choose_random( $chatbot_wildcard[get_wpbot_locale()] );
        }
        $array['woocommerce'][] = $chatbot_wildcard;
        
        $chatbot_wildcard = maybe_unserialize( get_option('qlcd_wp_chatbot_wildcard_order') );
        if( $chatbot_wildcard && isset( $chatbot_wildcard[$language] ) ){
            $chatbot_wildcard = qcld_choose_random( $chatbot_wildcard[$language] );
        }else{
            $chatbot_wildcard = qcld_choose_random( $chatbot_wildcard[get_wpbot_locale()] );
        }
        $array['woocommerce'][] = $chatbot_wildcard;

    }
    
    $custom = qc_dynamic_intent();
    if($custom!=''){
        $array['custom'] = explode(',', $custom);
    }

    $str_intent = qc_wpbot_simple_response_intent();
    if(!empty($str_intent)){
        $array['Simple Text Response Intent'] = $str_intent;
    }

    return $array;

}

/**
 * Get Option value for WPBot
 *
 * @param string $key
 * 
 * @return bool|array|string
 */
if ( ! function_exists( 'qcld_wpbot_get_option' ) ){
    function qcld_wpbot_get_option( $key ){
        $wpbot_options = get_option( 'qcld_wpbot_options' );
        if( isset( $wpbot_options[$key] ) ){
            return $wpbot_options[$key];
        } else {
            return false;
        }
    }
}

/**
 * Update option value for WPBot
 *
 * @param string $key
 * @param array|string $value
 * 
 * @return void
 */
if ( ! function_exists( 'qcld_wpbot_update_option' ) ){
    function qcld_wpbot_update_option( $key, $value ) {
        $wpbot_options = get_option( 'qcld_wpbot_options' );
        $wpbot_options[$key] = $value;
        update_option( 'qcld_wpbot_options', $wpbot_options );
    }
}

/**
 * Delete Option for WPBot
 *
 * @param string $key
 * 
 * @return void
 */
if ( ! function_exists( 'qcld_wpbot_delete_option' ) ){
    function qcld_wpbot_delete_option( $key ) {
        $wpbot_options = get_option( 'qcld_wpbot_options' );
        if( isset( $wpbot_options[$key] ) ){
            unset( $wpbot_options[$key] );
        }
        update_option( 'qcld_wpbot_options', $wpbot_options );
    }
}

/**
 * Check if table column is set
 * 
 * @param string $table_name
 * @param string $column_name
 * 
 * @return bool
 */
if(!function_exists('qcwp_isset_table_column')) {
	function qcwp_isset_table_column($table_name, $column_name)
	{
		global $wpdb;
		$columns = $wpdb->get_results("SHOW COLUMNS FROM  " . $table_name, ARRAY_A);
		foreach ($columns as $column) {
			if ($column['Field'] == $column_name) {
				return true;
			}
		}
	}
}

/**
 * Validate Authorization header for the webhook.
 */
function qcld_validate_authorization_header() {
 
    $headers = apache_request_headers();
    if(get_option('enable_authentication_webhook') == 1){
        $username = get_option('qcld_auth_username');
        $password = get_option('qcld_auth_password');
        if ( isset( $headers['Authorization'] ) ) {
            $wc_header = 'Basic ' . base64_encode( $username . ':' . $password );
            if ( $headers['Authorization'] == $wc_header ) {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }else{
        return true;
    }
    
}

function qc_wpbot_simple_response_intent(){
    global $wpdb;
    $table = $wpdb->prefix.'wpbot_response';
    $results = $wpdb->get_results("SELECT `intent` FROM `$table` WHERE 1 and `intent` !=''");
    $response = array();
    if(!empty($results)){
        foreach($results as $result){
            $response[] = $result->intent;
        }
    }
    return $response;
}

function qc_mysql_remove_existing_indexes(){
    global $wpdb;
    $table = $wpdb->prefix.'wpbot_response';
    
    $results = $wpdb->get_results("SHOW INDEX FROM $table");
    $indexes = array();
    foreach($results as $result){
        
        if("PRIMARY" != $result->Key_name && !in_array($result->Key_name, $indexes)){
            $wpdb->query("ALTER TABLE $table DROP INDEX `".$result->Key_name."`;");
            $indexes[] = $result->Key_name;
        }
        
    }
}

function qc_mysql_reindex() {
    global $wpdb;
    $table = $wpdb->prefix.'wpbot_response';
    $fields = get_option('qc_bot_str_fields');
    if($fields && !empty($fields) && class_exists('Qcld_str_pro')){
        $qfields = implode(', ', $fields);
    }else{
        //$qfields = '`query`,`keyword`,`response`';
        $qfields = '`query`,`keyword`,`response`';
    }

    $wpdb->query("ALTER TABLE $table ADD FULLTEXT($qfields)");
}

/**
 * WPBot update option during installation
 *
 * @param string $key
 * @param string $value
 * @return void
 */

 function qcldwpbot_update_option( $key, $value ){
    include QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'includes/admin/settings-fields.php';

    if (is_array( $wpbot_languages ) && in_array($key, $wpbot_languages) ){
        $value = maybe_unserialize( $value );
        $value = serialize( array( get_wpbot_locale() => $value ) );
        update_option( $key, $value );
    }else{
        update_option( $key, $value );
    }
 }

 /**
  * Sanitize fields
  * @param $data
  * @return void
  */
function qcld_sanitize_field( $data ){
    if( is_array( $data ) ){
        return $data;
    }else{
        return sanitize_text_field($data);
    }
}

function get_wpbot_locale(){
    
    global $wp;
    //check if url based langauge enabled
    if( class_exists( 'Qcld_Wpbot_Multilanguage' ) && !empty( get_option( 'wpbotml_url_urls' ) ) ){

        $urlss = get_option( 'wpbotml_url_urls' );

        if( !empty($urlss) ){
            foreach( $urlss as $lancode=>$urls ){
                $urls = explode( PHP_EOL, $urls );
                $urls = array_filter($urls);
                if( ! empty( $urls ) ){
                    foreach( $urls as $url ){
                        $url = trim($url);
                        if( isset( $wp->request ) && ( rtrim( $url, "/" ) == rtrim( home_url( $wp->request ), "/" ) || strpos( home_url( $wp->request ) , $url) !== false ) ){
                            return $lancode;
                        }
                    }
                }
            }
        }
    }

    if( get_option( 'wpbotml_Default_language' ) && class_exists( 'Qcld_Wpbot_Multilanguage' ) && get_option( 'wpbotml_Default_language' ) != '' ){
        return get_option( 'wpbotml_Default_language' );
    }

    return get_locale();
}

add_filter('pre_update_option', 'qcld_check_for_language_chnage', 100, 3);
function qcld_check_for_language_chnage( $value, $option, $old_value ){
    if( $option == 'WPLANG' ){    
        if( ($old_value) !== $value ){
            $oldlangkey = ( ($old_value) == '' ? 'en_US' : ($old_value) );
            $newlangkey = ( $value == '' ? 'en_US' : $value );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/admin/settings-fields.php" );
            foreach( $wpbot_languages as $key ){
                if( $lanoption = get_option( $key ) ){
                    $lanoption = maybe_unserialize( $lanoption );
                    if( is_array( $lanoption ) && array_key_exists( $oldlangkey , $lanoption ) && ! array_key_exists( $newlangkey , $lanoption ) ){
                        $lanoption[$newlangkey] = $lanoption[$oldlangkey];
                        $lanoption = maybe_serialize( $lanoption );
                        update_option( $key, $lanoption );
                    }
        
                }
        
            }

        }
    }
    
    if( $option == 'wpbotml_languages' ){
        $old_value = maybe_unserialize( $old_value );
        $value = maybe_unserialize($value);
        if(!empty($old_value)){
            $result = array_diff( $value, $old_value );
        }
        if( !empty( $result ) ){
            $default = get_locale();
            $oldlangkey = ( $default == '' ? 'en_US' : $default );
            foreach( $result as $newlangkey ){
                require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/admin/settings-fields.php" );
                foreach( $wpbot_languages as $key ){
                    if( $lanoption = get_option( $key ) ){
                        $lanoption = maybe_unserialize( $lanoption );
                        if( is_array( $lanoption ) && array_key_exists( $oldlangkey , $lanoption ) && ! array_key_exists( $newlangkey , $lanoption ) ){
                            $lanoption[$newlangkey] = $lanoption[$oldlangkey];
                            $lanoption = maybe_serialize( $lanoption );
                            update_option( $key, $lanoption );
                        }
            
                    }
            
                }
            }
        }
    }
    if( $option == 'wpbotml_Default_language' ){
        if( $old_value !== $value ){
            $oldlangkey = ( $old_value == '' ? 'en_US' : $old_value );
            $newlangkey = ( $value == '' ? 'en_US' : $value );
            require_once( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . "includes/admin/settings-fields.php" );
            foreach( $wpbot_languages as $key ){
                if( $lanoption = get_option( $key ) ){
                    $lanoption = maybe_unserialize( $lanoption );
                    if( is_array( $lanoption ) && array_key_exists( $oldlangkey , $lanoption ) && ! array_key_exists( $newlangkey , $lanoption ) ){
                        $lanoption[$newlangkey] = $lanoption[$oldlangkey];
                        $lanoption = maybe_serialize( $lanoption );
                        update_option( $key, $lanoption );
                    }
        
                }
        
            }

        }
    }
    return $value;
}


//add meta to stop zoom in iphone
// function wpbot_add_meta_tags_iphone() {
//     echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0"/>';
// }
// add_action('wp_head', 'wpbot_add_meta_tags_iphone');