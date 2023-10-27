<?php

class Qcld_bot_startmenu_helper
{
    
    /**
     * Check if WPBot plugin is installed and activate
     *
     * @return boolean
     */
    public function is_wpbot_active(){
        if( class_exists( 'qcld_wb_Chatbot' ) ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get options
     *
     * @param string $key
     * @return void
     */
    public function get_option( $key ){
        if( get_option(qcld_bot_startmenu()->settings[$key]['key']) ){
            return stripslashes( qcld_wpb_randmom_message_handle(maybe_unserialize( get_option(qcld_bot_startmenu()->settings[$key]['key']) )) );
        }else{
            return qcld_bot_startmenu()->settings[$key]['default'];
        }
        
    }

    public function render_start_menu($language){
        ?>
            <ul>
                <li>
                    <?php if(qcld_wpbot_is_active_livechat()==true): 
                        $data = get_option('wbca_options');
                        ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                            <span class="qcld-chatbot-custom-intent" data-text="<?php echo (isset($data['qlcd_wp_chatbot_sys_key_livechat']) && $data['qlcd_wp_chatbot_sys_key_livechat']!=''?$data['qlcd_wp_chatbot_sys_key_livechat']:'livechat'); ?>" ><?php echo (isset($data['qlcd_wp_livechat']) && $data['qlcd_wp_livechat']!=''?$data['qlcd_wp_livechat']:'Livechat'); ?></span>
                        </div>
                    <?php endif; ?>
                </li>
                <li>
                    <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-default wpbd_subscription"><?php 
                        $subscription = maybe_unserialize(get_option('qlcd_wp_email_subscription'));
                        
                        if( is_array( $subscription ) && isset( $subscription[$language] ) ){
                            echo $subscription[$language];
                        }else{
                            echo $subscription;
                        }
                    ?></span>
                    </div>
                </li>
                <li>
                    <?php if(get_option('enable_wp_custom_intent_livechat_button')==1 or qcld_wpbot_is_active_livechat()!==true): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                        <span class="qcld-chatbot-default wpbo_live_chat" ><?php 
                            $livechat_button_label = maybe_unserialize(get_option('qlcd_wp_livechat_button_label'));
                            if( is_array( $livechat_button_label ) && isset( $livechat_button_label[$language] ) ){
                                echo $livechat_button_label[$language];
                            }else{
                                echo $livechat_button_label;
                            }
                        
                        ?></span>
                        </div>
                    <?php endif; ?>
                </li>
                <li>
                    <?php if(get_option('disable_wp_chatbot_site_search')==''): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                        <span class="qcld-chatbot-site-search" ><?php 
                        $site_search = maybe_unserialize(get_option('qlcd_wp_site_search'));
                        if( is_array( $site_search ) && isset( $site_search[$language] ) ){
                            echo $site_search[$language];
                        }else{
                            echo $site_search;
                        }
                        ?></span>
                        </div>
                    <?php endif; ?>
                
                </li>
                <li>
                    <?php if(get_option('disable_wp_chatbot_faq')==''): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-wildcard"  data-wildcart="support"><?php 
                    $wildcard_support = maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_support'));
                    if( is_array( $wildcard_support ) && isset( $wildcard_support[$language] ) ){
                        echo $wildcard_support[$language];
                    }else{
                        echo $wildcard_support;
                    }
                    ?></span>
                    </div>
                    <?php endif; ?>
                
                </li>
                <li>
                    <?php if(get_option('disable_good_bye')==''): ?>
                    <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-default wpbd_good_bye"><?php 
                        $subscription = maybe_unserialize(get_option('qlcd_wp_good_bye'));
                        
                        if( is_array( $subscription ) && isset( $subscription[$language] ) ){
                            echo $subscription[$language];
                        }else{
                            echo ($subscription!=''?$subscription:'GoodBye');
                        }
                    ?></span>
                    </div>
                    <?php endif; ?>
                </li>
                <li>
                    <?php if(get_option('enable_wp_chatbot_messenger')=='1'): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-wildcard"  data-wildcart="messenger"><?php 
                    $wildcard_support = maybe_unserialize(get_option('qlcd_wp_chatbot_messenger_label'));
                    
                    if( is_array( $wildcard_support ) && isset( $wildcard_support[$language] ) ){
                        echo qcld_choose_random($wildcard_support[$language]);
                    }else{
                        echo qcld_choose_random($wildcard_support);
                    }
                    ?></span>
                    </div>
    
                    <?php endif; ?>
                
                </li>
    
                <li>
                    <?php if(get_option('enable_wp_chatbot_whats')=='1'): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-wildcard"  data-wildcart="whatsapp"><?php 
                        $whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_whats_label'));
                        if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
                            echo qcld_choose_random($whatsapp[$language]);
                        }else{
                            echo qcld_choose_random($whatsapp);
                        }
                    ?></span>
                    </div>
                    <?php endif; ?>
                
                </li>
    
                <li>
                    <?php if(get_option('disable_wp_chatbot_feedback')==''): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-suggest-email"><?php 
                    $send_us_email = maybe_unserialize(get_option('qlcd_wp_send_us_email'));
                    if( is_array( $send_us_email ) && isset( $send_us_email[$language] ) ){
                        echo $send_us_email[$language];
                    }else{
                        echo $send_us_email;
                    }
                    ?></span>
                    </div>
                    <?php endif; ?>
                
                </li>
    
                <li>
                    <?php if(get_option('disable_wp_leave_feedback')==''): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-suggest-email wpbd_feedback"><?php 
                    
                    $leave_feedback = maybe_unserialize(get_option('qlcd_wp_leave_feedback'));
                    if( is_array( $leave_feedback ) && isset( $leave_feedback[$language] ) ){
                        echo $leave_feedback[$language];
                    }else{
                        echo $leave_feedback;
                    }
                    ?></span>
                    </div>
                    <?php endif; ?>
                
                </li>
    
                <li>
                    <?php if(get_option('disable_wp_chatbot_call_gen')==''): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-suggest-phone" ><?php 
                        $support_phone = maybe_unserialize(get_option('qlcd_wp_chatbot_support_phone'));
                        if( is_array( $support_phone ) && isset( $support_phone[$language] ) ){
                            echo $support_phone[$language];
                        }else{
                            echo $support_phone;
                        } 
                    ?></span>
                    </div>
                    <?php endif; ?>
                
                </li>
                
                <?php if(get_option('disable_str_categories')=='' && class_exists('Qcld_str_pro')):?>
                
                <li>
                <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-wildcard wpbd_str_categories" ><?php 
                    $str_category = maybe_unserialize(get_option('qlcd_wp_str_category'));
                    if( is_array( $str_category ) && isset( $str_category[$language] ) ){
                        echo $str_category[$language];
                    }else{
                        echo ($str_category!=''?$str_category:'STR Categories');
                    } 
                    ?></span>
                    </div>
                    
                
                </li>
                
                <?php endif; ?>
    
                <?php if(get_option('disable_voice_message')=='' && (is_plugin_active( 'voice-message-addon/wpbotvoicemessage.php' ) || (in_array( "WPBot Voice Module",get_option( 'wpbot_master_addons')['active'])) )):?>
                
                    <li>  
                    <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                        <span class="qcld-chatbot-wildcard wpbd_voice_message" ><?php 
                        $str_category = maybe_unserialize(get_option('qlcd_wp_voice_message'));
                        if( is_array( $str_category ) && isset( $str_category[$language] ) ){
                            echo $str_category[$language];
                        }else{
                            echo ($str_category!=''?$str_category:'Voice Message');
                        } 
                        ?></span>
                    </div>
    
                    </li>
                <?php endif; ?>

                <?php if(function_exists('qcpd_wpwc_addon_lang_init')): ?>
    
                <li>
                    <?php if(get_option('disable_wp_chatbot_product_search')==''): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-wildcard"  data-wildcart="product"><?php 
                        $whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_product'));
                        if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
                            echo qcld_choose_random($whatsapp[$language]);
                        }elseif( is_array( $whatsapp ) && isset( $whatsapp[get_wpbot_locale()] ) ){
                            echo qcld_choose_random( $whatsapp[get_wpbot_locale()] );
                        }else{
                            echo qcld_choose_random($whatsapp);
                        }
                    ?></span>
                    </div>
                    <?php endif; ?>
                </li>

                <li>
                    <?php if(get_option('disable_wp_chatbot_catalog')==''): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-wildcard"  data-wildcart="catalog"><?php 
                        $whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_catalog'));
                        if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
                            echo qcld_choose_random($whatsapp[$language]);
                        }elseif( is_array( $whatsapp ) && isset( $whatsapp[get_wpbot_locale()] ) ){
                            echo qcld_choose_random( $whatsapp[get_wpbot_locale()] );
                        }else{
                            echo qcld_choose_random($whatsapp);
                        }
                    ?></span>
                    </div>
                    <?php endif; ?>
                </li>

                <li>
                    <?php if(get_option('disable_wp_chatbot_featured_product')==''): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-wildcard"  data-wildcart="featured"><?php 
                        $whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_featured_products'));
                        if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
                            echo qcld_choose_random($whatsapp[$language]);
                        }elseif( is_array( $whatsapp ) && isset( $whatsapp[get_wpbot_locale()] ) ){
                            echo qcld_choose_random( $whatsapp[get_wpbot_locale()] );
                        }else{
                            echo qcld_choose_random($whatsapp);
                        }
                    ?></span>
                    </div>
                    <?php endif; ?>
                </li>

                <li>
                    <?php if(get_option('disable_wp_chatbot_sale_product')==''): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-wildcard"  data-wildcart="sale"><?php 
                        $whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_sale_products'));
                        if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
                            echo qcld_choose_random($whatsapp[$language]);
                        }elseif( is_array( $whatsapp ) && isset( $whatsapp[get_wpbot_locale()] ) ){
                            echo qcld_choose_random( $whatsapp[get_wpbot_locale()] );
                        }else{
                            echo qcld_choose_random($whatsapp);
                        }
                    ?></span>
                    </div>
                    <?php endif; ?>
                </li>

                <li>
                    <?php if(get_option('disable_wp_chatbot_order_status')==''): ?>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-wildcard"  data-wildcart="order"><?php 
                        $whatsapp = maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_order'));
                        if( is_array( $whatsapp ) && isset( $whatsapp[$language] ) ){
                            echo qcld_choose_random($whatsapp[$language]);
                        }elseif( is_array( $whatsapp ) && isset( $whatsapp[get_wpbot_locale()] ) ){
                            echo qcld_choose_random( $whatsapp[get_wpbot_locale()] );
                        }else{
                            echo qcld_choose_random($whatsapp);
                        }
                    ?></span>
                    </div>
                    <?php endif; ?>
                </li>
                <?php endif; ?>
    
            </ul>
    
            <?php 
            $ai_df = get_option('enable_wp_chatbot_dailogflow');
            $custom_intent_labels = maybe_unserialize( get_option('qlcd_wp_custon_intent_label'));
            if($ai_df==1 && isset($custom_intent_labels[0]) && trim($custom_intent_labels[0])!=''):
            ?>
            <p>Custom Intents</p>
            <ul>
    
                <?php foreach($custom_intent_labels as $custom_intent_label): ?>
                    <li>
                    <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-custom-intent" data-text="<?php echo $custom_intent_label ?>" ><?php echo $custom_intent_label ?></span>
                    </div>
                    </li>
                <?php endforeach; ?>
                
            </ul>
            <?php endif; ?>
    
            <?php 
            $qlcd_wp_custon_menu = maybe_unserialize( get_option('qlcd_wp_custon_menu'));
            $qlcd_wp_custon_menu_link = maybe_unserialize( get_option('qlcd_wp_custon_menu_link'));
            $qlcd_wp_custon_menu_link_type = maybe_unserialize( get_option('qlcd_wp_custon_menu_type'));
            $qlcd_wp_custon_menu_checkbox = maybe_unserialize( get_option('qlcd_wp_custon_menu_checkbox'));
    
            if(isset($qlcd_wp_custon_menu[0]) && trim($qlcd_wp_custon_menu[0])!=''):
            ?>
            <p>Custom Button</p>
            <ul>
    
                <?php foreach($qlcd_wp_custon_menu as $key=>$value): ?>
                    <li>
                    <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-wildcard qcld-chatbot-buttonlink" data-link="<?php echo (isset($qlcd_wp_custon_menu_link[$key])?$qlcd_wp_custon_menu_link[$key]:''); ?>" data-target="<?php echo (isset($qlcd_wp_custon_menu_checkbox[$key])?$qlcd_wp_custon_menu_checkbox[$key]:'') ?>" data-type="<?php echo isset($qlcd_wp_custon_menu_link_type[$key])?$qlcd_wp_custon_menu_link_type[$key]:'link'; ?>" ><?php echo $value ?></span>
                    </div>
                    </li>
                <?php endforeach; ?>
                
            </ul>
            <?php endif; ?>
            
            <?php if(class_exists('Qcld_kbx_support')): ?>
            <p>KBX Support Ticket Button</p>
            <ul>
    
        <?php 
        if(get_option('qcld_support_page_id') && get_option('qcld_support_page_id')!=''){
        $kbx_page_id = get_option('qcld_support_page_id');
        }else{
        $kbx_page_id = get_page_by_title('Support Ticket for KBX');
        }
        if($kbx_page_id!=''){
        $support_page = get_post( $kbx_page_id ); 
        $support_page_url = get_permalink($kbx_page_id);
        ?>
                    <li>
                    <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                    <span class="qcld-chatbot-wildcard qcld-chatbot-buttonlink" data-link="<?php echo ($support_page_url); ?>" data-target="<?php echo (1); ?>" ><?php 
                    
                    $ticket_label = get_option('qlcd_open_ticket_label');
                    if( is_array( $ticket_label ) && isset( $ticket_label[$language] ) ){
                        echo $ticket_label[$language];
                    }else{
                        echo ($ticket_label==''?$ticket_label:'Open a Ticket');
                    } 
                    ?></span>
                    </div>
    
                    </li>
                
        <?php } ?>                                                    
            </ul>
            <?php endif; ?>
    
            
            <?php
            if(class_exists('Qcformbuilder_Forms_Admin')){
                global $wpdb;
    
                $results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_forms where 1 and type='primary'");
                if(!empty($results)){
                ?>
                <p>Conversational Form</p>
                <ul>
                <?php
                    foreach($results as $result){
                        $form = maybe_unserialize($result->config);
                    ?>
                    
                        <li>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                            <span class="qcld-chatbot-wildcard qcld-chatbot-form" data-form="<?php echo $form['ID']; ?>" ><?php echo $form['name']; ?></span>
                        </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <?php
                }
            }
            ?>
    
            <?php
                $results = qc_wpbot_simple_response_intent();
                global $wpdb;
    
                if(!empty($results)){
                ?>
                <p>Simple Text Response Intent</p>
                <ul>
                <?php
                    foreach($results as $result){
                        
                    ?>
                        <li>
                        <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                        <span class="qcld-chatbot-wildcard qcld_simple_txt_response" ><?php echo $result; ?></span>
                        </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <?php
                }
            
            ?>
              <?php 
            $table = $wpdb->prefix.'wpbot_response_category';
            $categories = $wpdb->get_results("select * from $table where 1 and custom=''");
            if ( ! empty( $categories ) && class_exists('Qcld_str_pro') ) {
                ?>
                <p>Simple Text Response Categories</p>
                <ul>
                    <?php 
                    foreach( $categories as $category ) {
                        ?>
                        <li><div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item"><span class="qcld-chatbot-wildcard qcld_simple_txt_response" ><?php echo $category->name; ?></span></div></li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
            <?php

                $cx = false;
                $alanguage = get_option('qlcd_wp_chatbot_dialogflow_agent_language');
                if( $alanguage && is_array( $alanguage ) && array_key_exists( $language, $alanguage ) ){
                    $alanguage = $alanguage[$language];
                    $cx = true;
                }
                //project ID
                $project_ID = get_option('qlcd_wp_chatbot_dialogflow_project_id');
                if( $project_ID && is_array( $project_ID ) && array_key_exists( $language, $project_ID ) && $cx ){
                    $project_ID = $project_ID[$language];
                }else{
                    $cx = false;
                }
                // Service Account Key json file
                $JsonFileContents = get_option('qlcd_wp_chatbot_dialogflow_project_key');
                if( $JsonFileContents && is_array( $JsonFileContents ) && array_key_exists( $language, $JsonFileContents ) && $cx ){
                    $JsonFileContents = $JsonFileContents[$language];
                }else{
                    $cx = false;
                }

                $dialogflow_cx = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_cx' ));
                if( $dialogflow_cx && is_array( $dialogflow_cx ) && array_key_exists( $language, $dialogflow_cx ) && $cx ){
                    $dialogflow_cx = $dialogflow_cx[$language];
                }else{
                    $cx = false;
                }

                if( $cx ){
                ?>
                <p>Dialogflow CX</p>
                <ul>
                <?php
                    $agents = qcld_wpbot_df_cx_agent(true, $language);
                    if( is_array( $agents ) && isset($agents['agents']) ){
                        foreach($agents['agents'] as $agent){
                            
                        ?>
                            <li>
                                <div class="wp-chatbot-start-content-single qcld_new_start_button qc_draggable_item">
                                    <span class="qcld-chatbot-wildcard qcld_wpbot_df_cx_agent" data-agent-name="<?php echo esc_attr( $agent['name'] ); ?>" data-agent-diaplay-name="<?php echo esc_attr( $agent['displayName'] ); ?>" data-agent-defaultlanguagecode="<?php echo esc_attr( $agent['defaultLanguageCode'] ); ?>" data-agent-timezone="<?php echo esc_attr( $agent['timeZone'] ); ?>" ><?php echo esc_html( $agent['displayName'] ); ?></span>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                    <?php
                    }
                }
            

            ?>


        <?php
    }
    
}
