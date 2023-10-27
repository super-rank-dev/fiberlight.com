<div id="wp-chatbot-shortcode-template-container"
     class="<?php echo esc_html($wp_chatbot_enable_rtl);?> wp-chatbot-shortcode-template-container chatbot-shortcode-template-02 page_design_dark">
  <div class="wp-chatbot-product-container">
    <div class="wp-chatbot-product-details">
      <div class="wp-chatbot-product-image-col">
        <div id="wp-chatbot-product-image"></div>
      </div>
      
      <!--wp-chatbot-product-image-col-->
      <div class="wp-chatbot-product-info-col">
        <div id="wp-chatbot-product-title" class="wp-chatbot-product-title"></div>
        <div id="wp-chatbot-product-price" class="wp-chatbot-product-price"></div>
        <div id="wp-chatbot-product-description" class="wp-chatbot-product-description"></div>
        <div id="wp-chatbot-product-quantity" class="wp-chatbot-product-quantity"></div>
        <div id="wp-chatbot-product-variable" class="wp-chatbot-product-variable"></div>
        <div id="wp-chatbot-product-cart-button" class="wp-chatbot-product-cart-button"></div>
      </div>
      <!--wp-chatbot-product-info-col--> 
      <a class="wp-chatbot-product-close"></a> </div>
    <!--            wp-chatbot-product-details--> 
  </div>
  <div class="chatbot-shortcode-row"> 
    <div class="wpbot-saas-live-chat">
    
    </div>
    <!--wp-chatbot-sidebar-->
    <div class="wp-chatbot-container">
      <div class="wp-chatbot-header">
        <h3>
          <?php if (get_option('qlcd_wp_chatbot_host') != '') {
                        $welcomes = qcld_wpb_randmom_message_handle(qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_welcome'))));
                        $host = qcld_wpb_randmom_message_handle(qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_host'))));
                        
                        echo $welcomes . ' ' . $host;
                    } ?>
        </h3>
      </div>
      <div class="lineanimation">
        <svg width="350" height="350" viewBox="0 0 308 309" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <defs>
            <circle id="a" cx="150" cy="150" r="150"/>
            <linearGradient x1="50%" y1="0%" x2="50%" y2="62.304%" id="c">
              <stop stop-color="#09DFF3" offset="0%"/>
              <stop stop-color="#44BEFF" offset="100%"/>
            </linearGradient>
          </defs>
          <g>
            <path id="l1" d="M0 130 L300 130"/>
            <path id="l2" d="M0 150 L300 150"/>
            <path id="l3" d="M0 170 L300 170"/>
            <path id="l4" d="M0 190 L300 190"/>
          </g>
        </svg>
      </div>
      <div class="animation">
        <div class="backgroundLight">
          <div class="square"></div>
          <div class="satelliteCircle1"></div>
          <div class="satelliteCircle2"></div>
          <div class="satelliteRectangles"></div>
          <div class="circleGradient"></div>
          <div class="cross1"></div>
          <div class="cross2"></div>
          <div class="centerCircle"></div>
          <div class="circle1"></div>
          <div class="circle2"></div>
          <div class="bigCircle"></div>
          <div class="dashCircle1"></div>
          <div class="dashCircle2"></div>
          <div class="dashCircle3"></div>
          <div class="thinCircle"></div>
        </div>
      </div>
      
      <!--wp-chatbot-header-->
      <div class="wp-chatbot-ball-inner  wp-chatbot-content">
        <div class="wp-chatbot-messages-wrapper">
          <ul id="wp-chatbot-messages-container" class="wp-chatbot-messages-container">
          </ul>
        </div>
        <!--wp-chatbot-messages-wrapper--> 
      </div>
      <!--wp-chatbot-ball-inner-->
      <div class="wp-chatbot-footer">
        <div id="wp-chatbot-editor-area" class="wp-chatbot-editor-area">
          <input id="wp-chatbot-editor" class="wp-chatbot-editor" required="" placeholder="<?php echo qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_send_a_msg'))); ?>"
                          >
          <button type="button" id="wp-chatbot-send-message" class="wp-chatbot-button"><?php echo esc_html__('send', 'wpchatbot'); ?></button>
        </div>
        <!--wp-chatbot-editor-container--> 
      </div>
      <!--wp-chatbot-footer--> 
    </div>
    <!--wp-chatbot-container--> 
  </div>
  <!--    chatbot-shortcode-row--> 
</div>
<!--wp-chatbot-ball-container-->