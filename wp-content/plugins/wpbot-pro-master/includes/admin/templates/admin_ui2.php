<?php 
global $wpdb;
$table    = $wpdb->prefix.'wpbot_subscription';
$sql1 = "SELECT count(*) FROM $table where 1";
$total_user_data = $wpdb->get_var( $sql1 );

$tableuser    = $wpdb->prefix.'wpbot_sessions';
$session_exists = $wpdb->get_row("select * from $tableuser where 1 and id = '1'");

if(!empty($session_exists)){
    $total_session = $session_exists->session;
}else{
    $total_session = 0;
}

?>
<div class="wrap">
    <h1 class="wpbot_header_h1"><?php echo esc_html__('WPBot', 'wpchatbot'); ?> </h1>
</div>

<div class="wp-chatbot-wrap">
    <div class="wpbot_dashboard_header container"><h1><?php echo wpbot_text(); ?> Dashboard</h1></div>
    <div class="wpbot_addons_section container">
        <?php 
            $plugin_data = get_plugin_data( QCLD_wpCHATBOT_PLUGIN_DIR_PATH . '\qcld-wpwbot.php' );
            $plugin_name = $plugin_data['Name'];
            if($plugin_name == "WPBot Pro Wordpress Chatbot"){
        ?>
        <div class="wpbot_single_addon_wrapper">
            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/icon-0.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title"><?php echo wpbot_text(); ?> Pro</div>
                        <div class="wpbot_addon_details">
                            <span class="wp_addon_installed">Installed</span>
                            <p>Wordpress Chatbot by QuantumCloud</p>
                            <a class="button button-secondary" href="<?php echo esc_url(admin_url('admin.php?page=wpbot')); ?>" >Settings</a>
                        </div>            
                    </div>

                </div>

            </div>
        
            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/woo-addon-256.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Bot - Woocommerce Addon</div>
                        <div class="wpbot_addon_details">
                        <?php if(function_exists('qcpd_wpwc_checking_dependencies')){
                                echo '<span class="wp_addon_installed">Installed</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                        
                            <p>WooCommerce ChatBot</p>
                            <?php if(function_exists('qcpd_wpwc_addon_lang_init')){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('admin.php?page=wpwc-settings-page')); ?>" >Settings</a>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                        </div>            
                    </div>
                </div>
            </div>

            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/WPBot-LiveChat.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Bot - Live Chat</div>
                        <div class="wpbot_addon_details">
                        
                            <?php if(qcld_wpbot_is_active_livechat()){
                                echo '<span class="wp_addon_installed">Installed</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                        
                            <p>Human Chat integrated with <?php echo wpbot_text(); ?></p>
                            
                            <?php if(qcld_wpbot_is_active_livechat()){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('admin.php?page=wbca-chat-page')); ?>" >Settings</a>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                        </div>            
                    </div>

                </div>

            </div>

            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/conversational-forns.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Bot - Conversational Form</div>
                        <div class="wpbot_addon_details">

                            <?php if(function_exists('qc_formbuilder_do_calculation')){
                                $cfb = 'Pro';
                            }else{
                                $cfb = 'Free';
                            } ?>

                            <?php if(function_exists('qcformbuilder_forms_load')){
                                echo '<span class="wp_addon_installed">Installed '.$cfb.'</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                            <p>Conversational form builder AddOn</p>
                            <?php if(function_exists('qcformbuilder_forms_load')){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('admin.php?page=qcformbuilder-forms')); ?>" >Settings</a>
                                <?php if($cfb=='Free'): ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Upgrade to Pro</a>
                                <?php endif; ?>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                        </div>            
                    </div>

                </div>

            </div>

            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/custom-post-type-addon-logo.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Bot - Extended Search</div>
                        <div class="wpbot_addon_details">
                            <?php if(qcld_wpbot_is_active_post_type_search()){
                                echo '<span class="wp_addon_installed">Installed</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                            <p>Extend Bot’s search power</p>
                            <?php if(qcld_wpbot_is_active_post_type_search()){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('admin.php?page=wbpt-posttypesetting-page')); ?>" >Settings</a>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                        </div>            
                    </div>
                </div>
            </div>

            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/messenger-chatbot.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Bot - Messenger</div>
                        <div class="wpbot_addon_details">
                            <?php if(function_exists('qcpd_wpfb_messenger_callback')){
                                echo '<span class="wp_addon_installed">Installed</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                            <p>Messenger Chatbot</p>
                            <?php if(function_exists('qcpd_wpfb_messenger_callback')){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('admin.php?page=wbfb-botsetting-page')); ?>" >Settings</a>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                        </div>            
                    </div>
                </div>
            </div>

            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/chatbot-sesssion-save.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Bot - Session Save</div>
                        <div class="wpbot_addon_details">
                            <?php if(qcld_wpbot_is_active_chat_history()){
                                echo '<span class="wp_addon_installed">Installed</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                        
                            <p>This AddOn saves the user chat sessions</p>
                            <?php if(qcld_wpbot_is_active_chat_history()){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('admin.php?page=wbcs-botsessions-page')); ?>" >Settings</a>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                        </div>            
                    </div>
                </div>
            </div>

            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/white-label.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Bot - White Label</div>
                        <div class="wpbot_addon_details">
                            <?php if(qcld_wpbot_is_active_white_label()){
                                echo '<span class="wp_addon_installed">Installed</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                            <p>Replace the branding with yours</p>
                            <?php if(qcld_wpbot_is_active_white_label()){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('admin.php?page=whitelabelwpbot')); ?>" >Settings</a>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                            
                            
                        </div>            
                    </div>
                </div>
            </div>

            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/mailing-list-integrationt%20(1).png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Bot - Mailing List Integration</div>
                        <div class="wpbot_addon_details">
                        <?php if(class_exists('QCLD_MAILING_LIST_INTEGRATION_ADDON')){
                                echo '<span class="wp_addon_installed">Installed</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                        
                            <p>Connect Bot with Mailchimp and Zapier</p>
                            <?php if(class_exists('QCLD_MAILING_LIST_INTEGRATION_ADDON')){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('edit.php?post_type=qc_mlist_mailchimp')); ?>" >Settings</a>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                        </div>            
                    </div>
                </div>
            </div>

            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/templates-addon-2.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Bot - Extended UI</div>
                        <div class="wpbot_addon_details">
                        <?php if(function_exists('qcpd_wpeui_dependencies')){
                                echo '<span class="wp_addon_installed">Installed</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                        
                            <p>Extend your chatbot UI</p>
                            <?php if(function_exists('qcpd_wpeui_dependencies')){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('admin.php?page=chatbot-extendedui-page')); ?>" >Settings</a>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                        </div>            
                    </div>
                </div>
            </div>
			
			<div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/simple-text-responses.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Chatbot STR Pro Addon</div>
                        <div class="wpbot_addon_details">
                        <?php if(function_exists('qcld_str_pro_dependency')){
                                echo '<span class="wp_addon_installed">Installed</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                        
                            <p>Addon plugin that extends feature of STR</p>
                            <?php if(function_exists('qcld_str_pro_dependency')){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('admin.php?page=simple-text-response')); ?>" >Settings</a>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                        </div>            
                    </div>
                </div>
            </div>

            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/muli-lamguage.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Multi Language Addon</div>
                        <div class="wpbot_addon_details">
                        <?php if(class_exists('Qcld_Wpbot_Multilanguage')){
                                echo '<span class="wp_addon_installed">Installed</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                        
                            <p>Add multiple language for your ChatBot</p>
                            <?php if(class_exists('Qcld_Wpbot_Multilanguage')){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('admin.php?page=wpbotml-settings-page')); ?>" >Settings</a>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                        </div>            
                    </div>
                </div>
            </div>

            <div class="wpbot_single_addon">
                <div class="wpbot_single_content">
                    <div class="wpbot_addon_image">
                        <img src="<?php echo esc_url(QCLD_wpCHATBOT_PLUGIN_URL.'images/voice-message.png'); ?>" title="" />
                    </div>
                    <div class="wpbot_addon_content">
                        <div class="wpbot_addon_title">Voice Message Addon</div>
                        <div class="wpbot_addon_details">
                        <?php if( is_plugin_active( 'voice-message-addon/wpbotvoicemessage.php' ) ){
                                echo '<span class="wp_addon_installed">Installed</span>';
                            }else{
                                echo '<span class="wp_addon_notinstalled">Not Installed</span>';
                            } ?>
                        
                            <p>Voice Message Addon for your ChatBot</p>
                            <?php if( is_plugin_active( 'voice-message-addon/wpbotvoicemessage.php' ) ){
                                ?>
                                <a class="button button-secondary" href="<?php echo esc_url(admin_url('edit.php?post_type=qcldcontacter_record&page=qcld_wpvm_vmwbmdp_contacter_settings')); ?>" >Settings</a>
                                <?php
                            }else{
                                ?>
                                <a class="button button-secondary" href="https://www.quantumcloud.com/products/chatbot-addons/" target="_blank" >Get It Now</a>
                                <?php
                            } ?>
                        </div>            
                    </div>
                </div>
            </div>

            
            <div style="clear:both"></div>
            
        </div>
        <?php }else { ?>
            <div class="panel">
                <div class="panel-body">
                <?php echo esc_html__('Please go to the ', 'wpchatbot'); ?><a href="<?php echo esc_attr__(admin_url('admin.php?page=wpbot-modules'), 'wpchatbot');?>"><?php echo esc_html__('manage modules ', 'wpchatbot'); ?></a><?php echo esc_html__('page to activate your required modules.', 'wpchatbot'); ?>
                </div>
            </div>
        <?php } ?>
        <div class="wpbot_statistics_area">
                <h2><?php echo wpbot_text(); ?> Statistics</h2>
                <div class="wpbot_report">
                    <p><span class="wpbot_report_key">User Data Collected</span>:<span class="wpbot_report_value"><a href="<?php echo esc_url( admin_url( 'admin.php?page=email-subscription') ) ?>"><?php echo esc_html($total_user_data); ?></a></span></p>
                    <p><span class="wpbot_report_key">Total ChatBot Sessions</span>:<span class="wpbot_report_value"><?php echo esc_html($total_session); ?></span></p>

                </div>
        </div>

    </div>
</div>
