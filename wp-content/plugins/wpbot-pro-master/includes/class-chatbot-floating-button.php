<?php

class Wpbot_floating_button
{
    //constructor
    public function __construct(){
        add_action('qcld_wpbot_floating_button', array( $this, 'floating_button' ) );
    }

    /**
     * Get Bot Floating image
     * 
     * @return string image url
     *
     */
    public function get_bot_image(){
        if (get_option('wp_chatbot_icon') == "custom.png") {
            $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_icon_path');
        } else if (get_option('wp_chatbot_icon') != "custom.png") {
            $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . get_option('wp_chatbot_icon');
        } else {
            $wp_chatbot_custom_icon_path = QCLD_wpCHATBOT_IMG_URL . 'custom.png';
        }
        return $wp_chatbot_custom_icon_path;
    }

    public function floating_button(){
        
        $image_url = $this->get_bot_image();
        $text = (get_option('qlcd_wp_chatbot_chat_with_us')?qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_chat_with_us'))):__('Chat with Us', 'wpchatbot'));
        $alt_text = __('WPBot', 'wpchatbot');
        $chat_bar_is_enabled = apply_filters( 'is_chat_bar_enable', 1, 0 );
        
        $chat_bar_position_right = apply_filters( 'chat_bar_position_right', get_option('enable_chat_bar_position_right'), 0 );

        if( $chat_bar_position_right == 1 ){
            $chat_bar_right_notification = apply_filters( 'chat_bar_notification_right', get_option('disable_chat_bar_right_notification'), 0 );
            
            $this->render_buttons($image_url, $text, $alt_text, $chat_bar_is_enabled, 'right', $chat_bar_right_notification);
        }
        
        $chat_bar_position_bottom = apply_filters( 'chat_bar_position_bottom', get_option('enable_chat_bar_position_bottom'), 0 );

        if( $chat_bar_position_bottom == 1 ){
            
            $chat_bar_bottom_notification = apply_filters( 'chat_bar_notification_bottom', get_option('disable_chat_bar_bottom_notification'), 0 );
            
            $this->render_buttons($image_url, $text, $alt_text, $chat_bar_is_enabled, 'bottom', $chat_bar_bottom_notification);
        }
        
    }

    public function render_buttons( $image_url, $text, $alt_text, $chat_bar_is_enabled, $chat_bar_position, $notification ){

        if( $chat_bar_position == 'right' ){
            $position_class = 'qc_floating_right_notification';
            $button_position = 'qc_right_position';
        }elseif( $chat_bar_position == 'bottom' ){
            $position_class = 'qc_floating_bottom_notification';
            $button_position = 'qc_bottom_position';
        }
        if( !$position_class ){
            return;
        }
        $content = sprintf('<img src="%s" alt="%s" /><p>%s</p>', $image_url, $alt_text, $text );
        $content_html = sprintf("<div class='qc_bot_floating_content'> %s </div>", $content);

        ob_start();
        
        if (get_option('disable_wp_chatbot_notification') != 1 && $notification != 1 ) {
            if(qcld_wp_chatbot_is_mobile() && get_option('disable_wp_chatbot_notification_mobile') == 1){
                
            }else{
            
                
            $notification_intent = qcld_wb_chatbot_func_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_notifications_intent'))); 
            
            ?>
            
            <div id="wp-chatbot-notification-container" class="wp-chatbot-notification-container <?php echo $position_class ?>" <?php echo (isset($notification_intent[0]) && $notification_intent[0]!=''?'data-intent="'.$notification_intent[0].'"':''); ?>>
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
                    <div class="wp-chatbot-notification-welcome"><?php echo qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_welcome'))) . ' <strong>' . $host . '</strong>'; ?></div>
                    
                </div>
                <?php 
                
                $notifications = qcld_wb_chatbot_func_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_notifications'))); 
                
                ?>
                
                <div class="wp-chatbot-notification-message"><?php echo ($notifications[0]); ?></div>
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
        <?php }}

        $notification_content = ob_get_clean();
        $content_html = $content_html . $notification_content;

        $html = sprintf("<div class='qc_wpbot_floating_main %s'> %s </div>", $button_position , $content_html);
        
        //echo get_option('enable_chat_bar');exit;
        if( $chat_bar_is_enabled && $chat_bar_is_enabled == 1 ){
            //echo '<style>#wp-chatbot-ball{display:none !important}</style>';
            echo $html;
        }
    }

}

new Wpbot_floating_button();
