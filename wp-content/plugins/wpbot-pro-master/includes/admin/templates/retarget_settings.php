<?php 
$allIntents = qc_get_all_intents();
$wp_chatbot_pages = get_pages();
wp_enqueue_style('qcld-wp-chatbot-common-style', QCLD_wpCHATBOT_PLUGIN_URL . '/css/common-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
?>
<div class="wrap">
    <h1 class="wpbot_header_h1"><?php echo esc_html__('WPBot', 'wpchatbot'); ?> </h1>
</div>
<div class="wp-chatbot-wrap">
    <form action="" method="POST">
    <div class="wpbot_dashboard_header container"><h1><?php echo wpbot_text(); ?> Retargeting</h1></div>
    <div class="wpbot_addons_section container">
        <div class="wpbot_single_addon_wrapper2">
            
                    <section id="section-flip-8">
                            <div class="wp-chatbot-language-center-summmery">
                                <p><?php echo esc_html__('On Site Retargeting  ', 'wpchatbot'); ?> </p>
                            </div>

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#wp-chatbot-retarget-general"><?php echo esc_html__('General Settings', 'wpchatbot'); ?></a></li>
                                <li ><a data-toggle="tab" href="#wp-chatbot-tab-exit"><?php echo esc_html__('Exit Intent', 'wpchatbot'); ?></a></li>
                                <li ><a data-toggle="tab" href="#wp-chatbot-tab-scroll"><?php echo esc_html__('Scroll Intent', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-tab-autointent"><?php echo esc_html__('Auto After "X" Seconds', 'wpchatbot'); ?></a></li>
                                <li><a data-toggle="tab" href="#wp-chatbot-tab-checkout"><?php echo esc_html__('Complete Checkout', 'wpchatbot'); ?></a></li>
                            </ul>


                            <div class="tab-content">
                                <div id="wp-chatbot-retarget-general" class="tab-pane fade in active">

                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12">
                                            
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group interaction-re-target">
                                                            <?php 
                                                                qcld_wpbot()->helper->render_language_field(esc_html__('Hello (When available, we will use user name)', 'wpchatbot'), 'qlcd_wp_chatbot_ret_greet', 'Hello', '');
                                                            ?>
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="cxsc-settings-blocks">
                                                    <div class="form-group">
                                                        <h4 class="qc-opt-title"><?php echo esc_html__('Retargeting message container background color.', 'wpchatbot'); ?></h4>
                                                        <input id="wp_chatbot_proactive_bg_color" type="hidden" name="wp_chatbot_proactive_bg_color" value="<?php echo(get_option('wp_chatbot_proactive_bg_color') != '' ? get_option('wp_chatbot_proactive_bg_color') : '#ffffff'); ?>"/>
                                                    </div>
                                                </div>

                                                <div class="cxsc-settings-blocks">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Retargeting Sound', 'wpchatbot'); ?></h4>
                                                    <div class="form-group">
                                                        <input value="1" id="enable_wp_chatbot_ret_sound" type="checkbox"
                                                            name="enable_wp_chatbot_ret_sound" <?php echo(get_option('enable_wp_chatbot_ret_sound') == 1 ? 'checked' : ''); ?>>
                                                        <label for="enable_wp_chatbot_ret_sound"><?php echo esc_html__('Enable to play sound on Exit-Intent, Scroll Opening etc', 'wpchatbot'); ?> </label>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="cxsc-settings-blocks">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('Window Focus Title', 'wpchatbot'); ?></h4>

                                                    <div class="form-group">
                                                        <input value="1" id="enable_wp_chatbot_meta_title" type="checkbox"
                                                            name="enable_wp_chatbot_meta_title" <?php echo(get_option('enable_wp_chatbot_meta_title') == 1 ? 'checked' : ''); ?>>
                                                        <label for="enable_wp_chatbot_meta_title"><?php echo esc_html__('Focus window with a short message appended to page title', 'wpchatbot'); ?> </label>
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        
                                                            <?php 
                                                                qcld_wpbot()->helper->render_language_field(esc_html__('Custom Meta Title', 'wpchatbot'), 'qlcd_wp_chatbot_meta_label', '***New Message', '');
                                                            ?>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>


                                <div id="wp-chatbot-tab-exit" class="tab-pane">

                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12">
                                            
                                                <div class="wp-chatbot-language-center-summmery" style="margin-top: 20px;">
                                                    <p><?php echo esc_html__('User Exit Intent', 'wpchatbot'); ?></p>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                    <h4 class="qc-opt-title"><?php echo esc_html__('User Exit Intent', 'wpchatbot'); ?> (<?php echo esc_html__('Show Message when mouse pointer moves out of browser viewport', 'wpchatbot'); ?>)</h4>
                                                    <div class="form-group">
                                                    <input value="1" id="enable_wp_chatbot_exit_intent" type="checkbox"
                                                        name="enable_wp_chatbot_exit_intent" <?php echo(get_option('enable_wp_chatbot_exit_intent') == 1 ? 'checked' : ''); ?>>
                                                    <label for="enable_wp_chatbot_exit_intent"><?php echo esc_html__('Enable to show On Exit-Intent Message', 'wpchatbot'); ?> </label>
                                                    </div>
                                                </div>
                                                
                                                <?php if(class_exists('Qcld_Bargain_Admin_Area_Controller'))://if bargain bot activate then ?>
                                                <br>
                                                <div class="cxsc-settings-blocks">
                                                    <div class="form-group">
                                                        <input value="1" id="wp_chatbot_exit_intent_bargain_pro_single_page" type="checkbox"
                                                            name="wp_chatbot_exit_intent_bargain_pro_single_page" <?php echo(get_option('wp_chatbot_exit_intent_bargain_pro_single_page') == 1 ? 'checked' : ''); ?>>
                                                        <label for="wp_chatbot_exit_intent_bargain_pro_single_page">
                                                            <?php _e('Trigger bargain bot on Exit Intent for product single pages', 'woochatbot'); ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php endif; ?>

                                                <br>
                                                <div class="cxsc-settings-blocks">
                                                    <div class="form-group">
                                                        <input value="1" id="wp_chatbot_exit_intent_once" type="checkbox"
                                                            name="wp_chatbot_exit_intent_once" <?php echo(get_option('wp_chatbot_exit_intent_once') == 1 ? 'checked' : ''); ?>>
                                                        <label for="wp_chatbot_exit_intent_once"><?php echo esc_html__('Show only once per visit.', 'wpchatbot'); ?> </label>
                                                    </div>
                                                </div>

                                                <br>
                                                
                                                <div class="row">
                                                    <div class="col-md-3"> <span class="qc-opt-title-font">
                                                    <?php _e('Trigger on  pages', 'wpchatbot'); ?>
                                                    </span>
                                                    </div>
                                                    <div class="col-md-9">
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-exitintent-show-pages" type="radio"
                                                                                            name="wp_chatbot_exitintent_show_pages"
                                                                                            value="on" <?php echo(get_option('wp_chatbot_exitintent_show_pages') == 'on' ? 'checked' : ''); ?>>
                                                        <?php _e('All Pages', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-exitintent-show-pages" type="radio"
                                                                                            name="wp_chatbot_exitintent_show_pages"
                                                                                            value="off" <?php echo(get_option('wp_chatbot_exitintent_show_pages') == 'off' ? 'checked' : ''); ?>>
                                                        <?php _e('Selected Pages Only ', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-exitintent-show-pages" type="radio"
                                                                                            name="wp_chatbot_exitintent_show_pages"
                                                                                            value="pagewise" <?php echo(get_option('wp_chatbot_exitintent_show_pages') == 'pagewise' ? 'checked' : ''); ?>>
                                                        <?php _e('Page Wise ', 'wpchatbot'); ?>
                                                    </label>
                                                    <div id="wp-chatbot-exitintent-show-pages-list">
                                                        <ul class="checkbox-list">
                                                        <?php
                                                        
                                                        $wp_chatbot_select_pages = maybe_unserialize(get_option('wp_chatbot_exitintent_show_pages_list'));
                                                        foreach ($wp_chatbot_pages as $wp_chatbot_page) {
                                                            ?>
                                                        <li>
                                                            <input id="wp_chatbot_exitintent_show_page_<?php echo $wp_chatbot_page->ID; ?>"
                                                                    type="checkbox"
                                                                    name="wp_chatbot_exitintent_show_pages_list[]"
                                                                    value="<?php echo $wp_chatbot_page->ID; ?>" <?php if (!empty($wp_chatbot_select_pages) && in_array($wp_chatbot_page->ID, $wp_chatbot_select_pages) == true) {
                                                                echo 'checked';
                                                            } ?> >
                                                            <label for="wp_chatbot_exitintent_show_page_<?php echo $wp_chatbot_page->ID; ?>"> <?php echo $wp_chatbot_page->post_title; ?></label>
                                                        </li>
                                                        <?php } ?>
                                                        </ul>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="trigger_url_exit">
                                                            <?php _e('Trigger on URLs (Add multiple with comma separated)', 'wpchatbot'); ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <textarea id="trigger_url_exit" name="trigger_url_exit" rows="4" ><?php echo(get_option('wp_chatbot_trigger_url_exit') != '' ? get_option('wp_chatbot_trigger_url_exit') : ''); ?></textarea>
                                                    </div>
                                                </div>             
                                                <div class="qcbot_exit_intent_legacy_container" <?php echo (get_option('wp_chatbot_exitintent_show_pages')=='pagewise'?'style="display:none"':''); ?>>

                                                    <div class="cxsc-settings-blocks" class="wp_chatbot_exit_intent_body">

                                                        <?php 
                                                            qcld_wpbot()->helper->render_retmsg_field(esc_html__('Your Message', 'wpchatbot'), 'wp_chatbot_exit_intent_msg');
                                                        ?>

                                                    </div>
                                                    <br>

                                                    <?php if(class_exists('Qcld_Bargain_Admin_Area_Controller'))://if bargain bot activate then ?>
                                                    <div class="cxsc-settings-blocks" class="wp_chatbot_exit_intent_body">
                                                        <h4 class="qc-opt-title">
                                                            <?php _e('Your Bargain Message', 'woochatbot'); ?>
                                                        </h4>
                                                        <?php $exit_intent_bargain_settings = array('textarea_name' =>
                                                                                            'wp_chatbot_exit_intent_bargain_msg',
                                                                                            'textarea_rows' => 20,
                                                                                            'editor_height' => 100,
                                                                                            'disabled' => 'disabled',
                                                                                            'media_buttons' => false,
                                                                                            'tinymce' => array(
                                                                                                'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                                                        );
                                                                                        wp_editor(html_entity_decode(stripcslashes(get_option('wp_chatbot_exit_intent_bargain_msg'))), 'wp_chatbot_exit_intent_bargain_msg', $exit_intent_bargain_settings); ?>
                                                    </div>
                                                    <?php endif; ?>

                                                    <div class="cxsc-settings-blocks">
                                                        <h4><?php echo esc_html__('Trigger a Custom Intent Instead', 'wpchatbot'); ?></h4>
                                                        <div class="form-group">
                                                            <label for="qlcd_wp_chatbot_meta_label">You can trigger a custom intent to start a conversation instead of your message. Intent Name - Must match EXACTLY as what you Added in DialogFlow. Also the intent name must be added in training phrases.</label><br><br>
                                                            <input type="text" class="form-control qc-opt-dcs-font"
                                                                name="wp_chatbot_exit_intent_custom"
                                                                value="<?php echo(get_option('wp_chatbot_exit_intent_custom') != '' ? get_option('wp_chatbot_exit_intent_custom') : ''); ?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="cxsc-settings-blocks">
                                                        <h4><?php echo esc_html__('Trigger Email Subscription Intent Instead', 'wpchatbot'); ?></h4>
                                                        <div class="form-group">
                                                            <input id="wp_chatbot_exit_intent_email_ckeckbox" type="checkbox"
                                                                name="wp_chatbot_exit_intent_email_ckeckbox" <?php echo( (get_option('wp_chatbot_exit_intent_email') == '1') ? 'checked' : ''); ?>>
                                                            <label for="wp_chatbot_exit_intent_email_ckeckbox"><?php echo esc_html__('Trigger Email Subscription Intent', 'wpchatbot'); ?> </label>
                                                        </div>
                                                        <input id="wp_chatbot_exit_intent_email" type="hidden"
                                                                name="wp_chatbot_exit_intent_email" value="<?php echo( (get_option('wp_chatbot_exit_intent_email') == '1') ? '1' : '0'); ?>">
                                                    </div>

                                                </div><!-- Legacy Container end-->

                                                <div class="qcbot_exit_dynamic_container" <?php echo (get_option('wp_chatbot_exitintent_show_pages')=='pagewise'?'style="display:block"':''); ?>>

                                                    <div class="qcld_exit_repeatable_wraper">

                                                        <?php  
                                                        $qcld_exit_pagewise = (get_option('qcld_exit_pagewise')!=''?maybe_unserialize(get_option('qcld_exit_pagewise')):array());
                                                        if(!empty($qcld_exit_pagewise)){
                                                            
                                                            $exitpage = $qcld_exit_pagewise['page'];
                                                            $exitmessage = $qcld_exit_pagewise['message'];
                                                            $exitintent = $qcld_exit_pagewise['intent'];

                                                        ?>

                                                            <?php for($e=0;$e<sizeof($exitpage);$e++){ ?>
                                                                
                                                                <div class="qcld_exitintent_message_single">
                                                    
                                                                <?php 
                                                                    if($e>0){
                                                                        echo '<button type="button" class="btn btn-danger btn-sm wp-chatbot-exitmessage-remove pull-right"><i class="fa fa-times" aria-hidden="true"></i></button>';
                                                                    }    
                                                                ?>

                                                                    <div class="cxsc-settings-blocks">
                                                                        <h4><?php echo esc_html__('Please select a Page', 'wpchatbot'); ?></h4>
                                                                        
                                                                        <select name="qcld_exit_pagewise[page][]">
                                                                            <?php 
                                                                                
                                                                                foreach($wp_chatbot_pages as $wp_chatbot_page){
                                                                                    ?>
                                                                                        <option value="<?php echo $wp_chatbot_page->ID; ?>" <?php echo ($exitpage[$e]==$wp_chatbot_page->ID?'selected="selected"':''); ?>><?php echo $wp_chatbot_page->post_title; ?></option>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        
                                                                    </div>

                                                                    <div class="cxsc-settings-blocks" class="wp_chatbot_exit_intent_body">
                                                                        <h4 class="qc-opt-title"><?php echo esc_html__('Your Message', 'wpchatbot'); ?> </h4>
                                                                        <?php $exit_intent_settings = array('textarea_name' =>
                                                                            'qcld_exit_pagewise[message][]',
                                                                            'textarea_rows' => 20,
                                                                            'editor_height' => 100,
                                                                            'disabled' => 'disabled',
                                                                            'media_buttons' => false,
                                                                            'tinymce'       => array(
                                                                                'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                                        );
                                                                        wp_editor($exitmessage[$e], 'qcld_exit_pagewise_message_'.$e, $exit_intent_settings); 
                                                                        
                                                                        
                                                                        ?>
                                                                    </div>

                                                                    
                                                                    <div class="cxsc-settings-blocks">
                                                                        <h4 class="qc-opt-title">Trigger Email Subscription Intent Instead</h4>     
                                                                        <select name="qcld_exit_pagewise[intent][]">

                                                                            <?php 
                                                                                foreach($allIntents as $key => $value){
                                                                                    ?>
                                                                                    <optgroup label="<?php echo $key ?>">
                                                                                        <option value="" >None</option>
                                                                                        <?php foreach($value as $val){ ?>

                                                                                            <option value="<?php echo $val; ?>" <?php echo ($exitintent[$e]==$val?'selected="selected"':''); ?>><?php echo $val; ?></option>

                                                                                        <?php } ?>
                                                                                    </optgroup>
                                                                                    <?php
                                                                                }
                                                                            ?>

                                                                        </select>                                                   
                                                                    </div>
                                                                </div>

                                                            <?php } ?>

                                                        <?php 
                                                        }else{
                                                        ?>

                                                        <div class="qcld_exitintent_message_single">
                                                    
                                                            <div class="cxsc-settings-blocks">
                                                                <h4><?php echo esc_html__('Please select a Page', 'wpchatbot'); ?></h4>
                                                                
                                                                <select name="qcld_exit_pagewise[page][]">
                                                                    <?php 
                                                                        
                                                                        foreach($wp_chatbot_pages as $wp_chatbot_page){
                                                                            ?>
                                                                                <option value="<?php echo $wp_chatbot_page->ID; ?>"><?php echo $wp_chatbot_page->post_title; ?></option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                
                                                            </div>

                                                            <div class="cxsc-settings-blocks" class="wp_chatbot_exit_intent_body">
                                                                <h4 class="qc-opt-title"><?php echo esc_html__('Your Message', 'wpchatbot'); ?> </h4>
                                                                <?php $exit_intent_settings = array('textarea_name' =>
                                                                    'qcld_exit_pagewise[message][]',
                                                                    'textarea_rows' => 20,
                                                                    'editor_height' => 100,
                                                                    'disabled' => 'disabled',
                                                                    'media_buttons' => false,
                                                                    'tinymce'       => array(
                                                                        'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                                );
                                                                wp_editor('', 'qcld_exit_pagewise_message_0', $exit_intent_settings); 
                                                                
                                                                
                                                                ?>
                                                            </div>

                                                            
                                                            <div class="cxsc-settings-blocks">
                                                                <h4 class="qc-opt-title">Trigger Email Subscription Intent Instead</h4>     
                                                                <select name="qcld_exit_pagewise[intent][]">

                                                                    <?php 
                                                                        foreach($allIntents as $key => $value){
                                                                            ?>
                                                                            <optgroup label="<?php echo $key ?>">
                                                                                <option value="" >None</option>
                                                                                <?php foreach($value as $val){ ?>

                                                                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>

                                                                                <?php } ?>
                                                                            </optgroup>
                                                                            <?php
                                                                        }
                                                                    ?>

                                                                </select>                                                   
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div><!-- Repeatable wraper -->

                                                    <div class="row">
                                                        <div class="col-sm-6 text-left"></div>
                                                        <div class="col-sm-6 text-right">
                                                            <button class="btn btn-success btn-sm" type="button"
                                                                    id="add-more-exitintent-message">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__('Add', 'wpchatbot'); ?>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div><!--Dynamic Container-->

                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div id="wp-chatbot-tab-scroll" class="tab-pane ">

                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12">
                                            
                                                <div class="wp-chatbot-language-center-summmery" style="margin-top: 20px;">
                                                    <p><?php echo esc_html__('User Scroll Down Intent', 'wpchatbot'); ?></p>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                    <div class="form-group">
                                                        <input value="1" id="enable_wp_chatbot_scroll_open" type="checkbox"
                                                            name="enable_wp_chatbot_scroll_open" <?php echo(get_option('enable_wp_chatbot_scroll_open') == 1 ? 'checked' : ''); ?>>
                                                        <label for="enable_wp_chatbot_scroll_open"><?php echo esc_html__('Enable to show message once user scrolls down a page', 'wpchatbot'); ?> </label>
                                                    </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                    <span class="qc-opt-dcs-font"> <?php echo esc_html__('WPBot will be shown after scrolling down ', 'wpchatbot'); ?></span>
                                                    <input type="number"  name="wp_chatbot_scroll_percent" value="<?php echo(get_option('wp_chatbot_scroll_percent') != '' ? get_option('wp_chatbot_scroll_percent') : 50); ?>">
                                                    <span class="qc-opt-dcs-font"> <?php echo esc_html__('percent', 'wpchatbot'); ?></span>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                    <div class="form-group">
                                                        <input value="1" id="wp_chatbot_scroll_once" type="checkbox"
                                                            name="wp_chatbot_scroll_once" <?php echo(get_option('wp_chatbot_scroll_once') == 1 ? 'checked' : ''); ?>>
                                                        <label for="wp_chatbot_scroll_once"><?php echo esc_html__('Show only once per visit.', 'wpchatbot'); ?> </label>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="row">
                                                    <div class="col-md-3"> <span class="qc-opt-title-font">
                                                    <?php _e('Trigger on  pages', 'wpchatbot'); ?>
                                                    </span>
                                                    </div>
                                                    <div class="col-md-9">
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-scrollintent-show-pages" type="radio"
                                                                                            name="wp_chatbot_scrollintent_show_pages"
                                                                                            value="on" <?php echo(get_option('wp_chatbot_scrollintent_show_pages') == 'on' ? 'checked' : ''); ?>>
                                                        <?php _e('All Pages', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-scrollintent-show-pages" type="radio"
                                                                                            name="wp_chatbot_scrollintent_show_pages"
                                                                                            value="off" <?php echo(get_option('wp_chatbot_scrollintent_show_pages') == 'off' ? 'checked' : ''); ?>>
                                                        <?php _e('Selected Pages Only ', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-scrollintent-show-pages" type="radio"
                                                                                            name="wp_chatbot_scrollintent_show_pages"
                                                                                            value="pagewise" <?php echo(get_option('wp_chatbot_scrollintent_show_pages') == 'pagewise' ? 'checked' : ''); ?>>
                                                        <?php _e('Page Wise ', 'wpchatbot'); ?>
                                                    </label>
                                                    <div id="wp-chatbot-scrollintent-show-pages-list">
                                                        <ul class="checkbox-list">
                                                        <?php
                                                        
                                                        $wp_chatbot_select_pages = maybe_unserialize(get_option('wp_chatbot_scrollintent_show_pages_list'));
                                                        foreach ($wp_chatbot_pages as $wp_chatbot_page) {
                                                            ?>
                                                        <li>
                                                            <input id="wp_chatbot_scrollintent_show_page_<?php echo $wp_chatbot_page->ID; ?>"
                                                                    type="checkbox"
                                                                    name="wp_chatbot_scrollintent_show_pages_list[]"
                                                                    value="<?php echo $wp_chatbot_page->ID; ?>" <?php if (!empty($wp_chatbot_select_pages) && in_array($wp_chatbot_page->ID, $wp_chatbot_select_pages) == true) {
                                                                echo 'checked';
                                                            } ?> >
                                                            <label for="wp_chatbot_scrollintent_show_page_<?php echo $wp_chatbot_page->ID; ?>"> <?php echo $wp_chatbot_page->post_title; ?></label>
                                                        </li>
                                                        <?php } ?>
                                                        </ul>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="trigger_url_scroll">
                                                            <?php _e('Trigger on URLs (Add multiple with comma separated)', 'wpchatbot'); ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <textarea id="trigger_url_scroll" name="trigger_url_scroll" rows="4" ><?php echo(get_option('wp_chatbot_trigger_url_scroll') != '' ? get_option('wp_chatbot_trigger_url_scroll') : ''); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="qcbot_scroll_intent_legacy_container" <?php echo (get_option('wp_chatbot_scrollintent_show_pages')=='pagewise'?'style="display:none"':''); ?>>
                                                    <div class="cxsc-settings-blocks" id="wp_chatbot_scroll_open_body">
                                                        <?php 
                                                            qcld_wpbot()->helper->render_retmsg_field(esc_html__('Your Message', 'wpchatbot'), 'wp_chatbot_scroll_open_msg');
                                                        ?>
                                                    </div>

                                                    <div class="cxsc-settings-blocks">
                                                        <h4><?php echo esc_html__('Trigger a Custom Intent Instead', 'wpchatbot'); ?></h4>
                                                        <div class="form-group">
                                                            <label for="qlcd_wp_chatbot_meta_label">You can trigger a custom intent to start a conversation instead of your message. Intent Name - Must match EXACTLY as what you Added in DialogFlow. Also the intent name must be added in training phrases.</label><br><br>
                                                            <input type="text" class="form-control qc-opt-dcs-font"
                                                                name="wp_chatbot_scroll_open_custom"
                                                                value="<?php echo(get_option('wp_chatbot_scroll_open_custom') != '' ? get_option('wp_chatbot_scroll_open_custom') : ''); ?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="cxsc-settings-blocks">
                                                        <h4><?php echo esc_html__('Trigger Email Subscription Intent Instead', 'wpchatbot'); ?></h4>
                                                        <div class="form-group">
                                                            <input id="wp_chatbot_scroll_open_email_checked" type="checkbox"
                                                            name="wp_chatbot_scroll_open_email_checked" <?php echo(get_option('wp_chatbot_scroll_open_email') == 1 ? 'checked' : ''); ?>>
                                                            <label for="wp_chatbot_scroll_open_email_checked"><?php echo esc_html__('Trigger Email Subscription Intent', 'wpchatbot'); ?> </label>
                                                            <input id="wp_chatbot_scroll_open_email" type="hidden"
                                                            name="wp_chatbot_scroll_open_email" value="<?php echo(get_option('wp_chatbot_scroll_open_email') == 1 ? '1' : '0'); ?>">
                                                        </div>
                                                    </div>
                                                </div> <!-- legacy-->

                                                <div class="qcbot_scroll_dynamic_container" <?php echo (get_option('wp_chatbot_scrollintent_show_pages')=='pagewise'?'style="display:block"':''); ?>>

                                                    <div class="qcld_scroll_repeatable_wraper">

                                                        <?php  
                                                        $qcld_exit_pagewise = (get_option('qcld_scroll_pagewise')!=''?maybe_unserialize(get_option('qcld_scroll_pagewise')):array());
                                                        if(!empty($qcld_exit_pagewise)){
                                                            
                                                            $exitpage = $qcld_exit_pagewise['page'];
                                                            $exitmessage = $qcld_exit_pagewise['message'];
                                                            $exitintent = $qcld_exit_pagewise['intent'];

                                                        ?>

                                                            <?php for($e=0;$e<sizeof($exitpage);$e++){ ?>


                                                                <div class="qcld_scrollintent_message_single">

                                                                <?php 
                                                                    if($e>0){
                                                                        echo '<button type="button" class="btn btn-danger btn-sm wp-chatbot-scrollmessage-remove pull-right"><i class="fa fa-times" aria-hidden="true"></i></button>';
                                                                    }    
                                                                ?>
                                                                    <div class="cxsc-settings-blocks">
                                                                        <h4><?php echo esc_html__('Please select a Page', 'wpchatbot'); ?></h4>
                                                                        
                                                                        <select name="qcld_scroll_pagewise[page][]">
                                                                            <?php 
                                                                                
                                                                                foreach($wp_chatbot_pages as $wp_chatbot_page){
                                                                                    ?>
                                                                                        <option value="<?php echo $wp_chatbot_page->ID; ?>" <?php echo ($exitpage[$e]==$wp_chatbot_page->ID?'selected="selected"':''); ?>><?php echo $wp_chatbot_page->post_title; ?></option>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        
                                                                    </div>

                                                                    <div class="cxsc-settings-blocks" class="wp_chatbot_exit_intent_body">
                                                                        <h4 class="qc-opt-title"><?php echo esc_html__('Your Message', 'wpchatbot'); ?> </h4>
                                                                        <?php $exit_intent_settings = array('textarea_name' =>
                                                                            'qcld_scroll_pagewise[message][]',
                                                                            'textarea_rows' => 20,
                                                                            'editor_height' => 100,
                                                                            'disabled' => 'disabled',
                                                                            'media_buttons' => false,
                                                                            'tinymce'       => array(
                                                                                'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                                        );
                                                                        wp_editor($exitmessage[$e], 'qcld_scroll_pagewise_message_'.$e, $exit_intent_settings); 
                                                                        
                                                                        
                                                                        ?>
                                                                    </div>

                                                                    
                                                                    <div class="cxsc-settings-blocks">
                                                                        <h4 class="qc-opt-title">Trigger Email Subscription Intent Instead</h4>     
                                                                        <select name="qcld_scroll_pagewise[intent][]">

                                                                            <?php 
                                                                                foreach($allIntents as $key => $value){
                                                                                    ?>
                                                                                    <optgroup label="<?php echo $key ?>">
                                                                                        <option value="" >None</option>
                                                                                        <?php foreach($value as $val){ ?>

                                                                                            <option value="<?php echo $val; ?>" <?php echo ($exitintent[$e]==$val?'selected="selected"':''); ?>><?php echo $val; ?></option>

                                                                                        <?php } ?>
                                                                                    </optgroup>
                                                                                    <?php
                                                                                }
                                                                            ?>

                                                                        </select>                                                   
                                                                    </div>
                                                                </div>

                                                            <?php } ?>

                                                        <?php 
                                                        }else{
                                                        ?>

                                                        <div class="qcld_scrollintent_message_single">

                                                            <div class="cxsc-settings-blocks">
                                                                <h4><?php echo esc_html__('Please select a Page', 'wpchatbot'); ?></h4>
                                                                
                                                                <select name="qcld_scroll_pagewise[page][]">
                                                                    <?php 
                                                                        
                                                                        foreach($wp_chatbot_pages as $wp_chatbot_page){
                                                                            ?>
                                                                                <option value="<?php echo $wp_chatbot_page->ID; ?>"><?php echo $wp_chatbot_page->post_title; ?></option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                
                                                            </div>

                                                            <div class="cxsc-settings-blocks" class="wp_chatbot_exit_intent_body">
                                                                <h4 class="qc-opt-title"><?php echo esc_html__('Your Message', 'wpchatbot'); ?> </h4>
                                                                <?php $exit_intent_settings = array('textarea_name' =>
                                                                    'qcld_scroll_pagewise[message][]',
                                                                    'textarea_rows' => 20,
                                                                    'editor_height' => 100,
                                                                    'disabled' => 'disabled',
                                                                    'media_buttons' => false,
                                                                    'tinymce'       => array(
                                                                        'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                                );
                                                                wp_editor('', 'qcld_scroll_pagewise_message_0', $exit_intent_settings); 
                                                                
                                                                
                                                                ?>
                                                            </div>

                                                            
                                                            <div class="cxsc-settings-blocks">
                                                                <h4 class="qc-opt-title">Trigger Email Subscription Intent Instead</h4>     
                                                                <select name="qcld_scroll_pagewise[intent][]">

                                                                    <?php 
                                                                        foreach($allIntents as $key => $value){
                                                                            ?>
                                                                            <optgroup label="<?php echo $key ?>">
                                                                                <option value="" >None</option>
                                                                                <?php foreach($value as $val){ ?>

                                                                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>

                                                                                <?php } ?>
                                                                            </optgroup>
                                                                            <?php
                                                                        }
                                                                    ?>

                                                                </select>                                                   
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div><!-- Repeatable wraper -->

                                                    <div class="row">
                                                        <div class="col-sm-6 text-left"></div>
                                                        <div class="col-sm-6 text-right">
                                                            <button class="btn btn-success btn-sm" type="button"
                                                                    id="add-more-scrollintent-message">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__('Add', 'wpchatbot'); ?>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div><!--Dynamic Container-->

                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div id="wp-chatbot-tab-autointent" class="tab-pane">

                                    <div class="top-section">
                                        <div class="row">
                                            <div class="col-xs-12">
                                            
                                                <div class="wp-chatbot-language-center-summmery" style="margin-top: 20px;">
                                                    <p><?php echo esc_html__('Show Message After "X" Seconds', 'wpchatbot'); ?></p>
                                                </div>

                                                <div class="cxsc-settings-blocks">
                                                    <div class="form-group">
                                                        <input value="1" id="enable_wp_chatbot_auto_open" type="checkbox"
                                                            name="enable_wp_chatbot_auto_open" <?php echo(get_option('enable_wp_chatbot_auto_open') == 1 ? 'checked' : ''); ?>>
                                                        <label for="enable_wp_chatbot_auto_open"><?php echo esc_html__('Show message after X seconds', 'wpchatbot'); ?> </label>
                                                    </div>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                    <span class="qc-opt-dcs-font"> <?php echo esc_html__('WPBot will be opened automatically after ', 'wpchatbot'); ?></span>
                                                    <input type="number"  name="wp_chatbot_auto_open_time" value="<?php echo(get_option('wp_chatbot_auto_open_time') != '' ? get_option('wp_chatbot_auto_open_time') : 300); ?>">
                                                    <span class="qc-opt-dcs-font"> <?php echo esc_html__('seconds', 'wpchatbot'); ?></span>
                                                </div>
                                                <div class="cxsc-settings-blocks">
                                                    <div class="form-group">
                                                        <input value="1" id="wp_chatbot_auto_open_once" type="checkbox"
                                                                name="wp_chatbot_auto_open_once" <?php echo(get_option('wp_chatbot_auto_open_once') == 1 ? 'checked' : ''); ?>>
                                                        <label for="wp_chatbot_auto_open_once"><?php echo esc_html__('Show only once per visit.', 'wpchatbot'); ?> </label>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="row">
                                                    <div class="col-md-3"> <span class="qc-opt-title-font">
                                                    <?php _e('Trigger on  pages', 'wpchatbot'); ?>
                                                    </span>
                                                    </div>
                                                    <div class="col-md-9">
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-autointent-show-pages" type="radio"
                                                                                            name="wp_chatbot_autointent_show_pages"
                                                                                            value="on" <?php echo(get_option('wp_chatbot_autointent_show_pages') == 'on' ? 'checked' : ''); ?>>
                                                        <?php _e('All Pages', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-autointent-show-pages" type="radio"
                                                                                            name="wp_chatbot_autointent_show_pages"
                                                                                            value="off" <?php echo(get_option('wp_chatbot_autointent_show_pages') == 'off' ? 'checked' : ''); ?>>
                                                        <?php _e('Selected Pages Only ', 'wpchatbot'); ?>
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input class="wp-chatbot-autointent-show-pages" type="radio"
                                                                                            name="wp_chatbot_autointent_show_pages"
                                                                                            value="pagewise" <?php echo(get_option('wp_chatbot_autointent_show_pages') == 'pagewise' ? 'checked' : ''); ?>>
                                                        <?php _e('Page Wise ', 'wpchatbot'); ?>
                                                    </label>
                                                    <div id="wp-chatbot-autointent-show-pages-list">
                                                        <ul class="checkbox-list">
                                                        <?php
                                                        
                                                        $wp_chatbot_select_pages = maybe_unserialize(get_option('wp_chatbot_autointent_show_pages_list'));
                                                        foreach ($wp_chatbot_pages as $wp_chatbot_page) {
                                                            ?>
                                                        <li>
                                                            <input id="wp_chatbot_autointent_show_page_<?php echo $wp_chatbot_page->ID; ?>"
                                                                    type="checkbox"
                                                                    name="wp_chatbot_autointent_show_pages_list[]"
                                                                    value="<?php echo $wp_chatbot_page->ID; ?>" <?php if (!empty($wp_chatbot_select_pages) && in_array($wp_chatbot_page->ID, $wp_chatbot_select_pages) == true) {
                                                                echo 'checked';
                                                            } ?> >
                                                            <label for="wp_chatbot_autointent_show_page_<?php echo $wp_chatbot_page->ID; ?>"> <?php echo $wp_chatbot_page->post_title; ?></label>
                                                        </li>
                                                        <?php } ?>
                                                        </ul>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="trigger_url_autotime">
                                                            <?php _e('Trigger on URLs (Add multiple with comma separated)', 'wpchatbot'); ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <textarea id="trigger_url_autotime" name="trigger_url_autotime" rows="4" ><?php echo(get_option('wp_chatbot_trigger_url_autotime') != '' ? get_option('wp_chatbot_trigger_url_autotime') : ''); ?></textarea>
                                                    </div>
                                                </div>   
                                                <div class="qcbot_auto_intent_legacy_container" <?php echo (get_option('wp_chatbot_autointent_show_pages')=='pagewise'?'style="display:none"':''); ?>>
                                                    <div class="cxsc-settings-blocks" id="wp_chatbot_auto_open_body">

                                                        <?php 
                                                            qcld_wpbot()->helper->render_retmsg_field(esc_html__('Your Message', 'wpchatbot'), 'wp_chatbot_auto_open_msg');
                                                        ?>
                                                    </div>
                                                    <br>
                                                    <div class="cxsc-settings-blocks">
                                                        <h4><?php echo esc_html__('Trigger a Custom Intent Instead', 'wpchatbot'); ?></h4>
                                                        <div class="form-group">
                                                            <label for="qlcd_wp_chatbot_meta_label">You can trigger a custom intent to start a conversation instead of your message. Intent Name - Must match EXACTLY as what you Added in DialogFlow. Also the intent name must be added in training phrases.</label><br><br>
                                                            <input type="text" class="form-control qc-opt-dcs-font"
                                                                name="wp_chatbot_auto_open_custom"
                                                                value="<?php echo(get_option('wp_chatbot_auto_open_custom') != '' ? get_option('wp_chatbot_auto_open_custom') : ''); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="cxsc-settings-blocks">
                                                        <h4><?php echo esc_html__('Trigger Email Subscription Intent Instead', 'wpchatbot'); ?></h4>
                                                        <div class="form-group">
                                                            <input id="wp_chatbot_auto_open_email_checked" type="checkbox"
                                                                name="wp_chatbot_auto_open_email_checked" <?php echo(get_option('wp_chatbot_auto_open_email') == 1 ? 'checked' : ''); ?>>
                                                            <label for="wp_chatbot_auto_open_email_checked"><?php echo esc_html__('Trigger Email Subscription Intent', 'wpchatbot'); ?> </label>
                                                            <input id="wp_chatbot_auto_open_email" type="hidden"
                                                                name="wp_chatbot_auto_open_email" value="<?php echo(get_option('wp_chatbot_auto_open_email') == 1 ? '1' : '0'); ?>">
                                                        </div>
                                                    </div>
                                                </div> <!--legacy-->

                                                <div class="qcbot_auto_dynamic_container" <?php echo (get_option('wp_chatbot_autointent_show_pages')=='pagewise'?'style="display:block"':''); ?>>

                                                    <div class="qcld_auto_repeatable_wraper">

                                                        <?php  
                                                        $qcld_exit_pagewise = (get_option('qcld_auto_pagewise')!=''?maybe_unserialize(get_option('qcld_auto_pagewise')):array());
                                                        if(!empty($qcld_exit_pagewise)){
                                                            
                                                            $exitpage = $qcld_exit_pagewise['page'];
                                                            $exitmessage = $qcld_exit_pagewise['message'];
                                                            $exitintent = $qcld_exit_pagewise['intent'];

                                                        ?>

                                                            <?php for($e=0;$e<sizeof($exitpage);$e++){ ?>


                                                                <div class="qcld_autointent_message_single">

                                                                <?php 
                                                                    if($e>0){
                                                                        echo '<button type="button" class="btn btn-danger btn-sm wp-chatbot-automessage-remove pull-right"><i class="fa fa-times" aria-hidden="true"></i></button>';
                                                                    }    
                                                                ?>
                                                                    <div class="cxsc-settings-blocks">
                                                                        <h4><?php echo esc_html__('Please select a Page', 'wpchatbot'); ?></h4>
                                                                        
                                                                        <select name="qcld_auto_pagewise[page][]">
                                                                            <?php 
                                                                                
                                                                                foreach($wp_chatbot_pages as $wp_chatbot_page){
                                                                                    ?>
                                                                                        <option value="<?php echo $wp_chatbot_page->ID; ?>" <?php echo ($exitpage[$e]==$wp_chatbot_page->ID?'selected="selected"':''); ?>><?php echo $wp_chatbot_page->post_title; ?></option>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        
                                                                    </div>

                                                                    <div class="cxsc-settings-blocks" class="wp_chatbot_auto_intent_body">
                                                                        <h4 class="qc-opt-title"><?php echo esc_html__('Your Message', 'wpchatbot'); ?> </h4>
                                                                        <?php $exit_intent_settings = array('textarea_name' =>
                                                                            'qcld_auto_pagewise[message][]',
                                                                            'textarea_rows' => 20,
                                                                            'editor_height' => 100,
                                                                            'disabled' => 'disabled',
                                                                            'media_buttons' => false,
                                                                            'tinymce'       => array(
                                                                                'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                                        );
                                                                        wp_editor($exitmessage[$e], 'qcld_auto_pagewise_message_'.$e, $exit_intent_settings); 
                                                                        
                                                                        
                                                                        ?>
                                                                    </div>

                                                                    
                                                                    <div class="cxsc-settings-blocks">
                                                                        <h4 class="qc-opt-title">Trigger an Intent Instead</h4>     
                                                                        <select name="qcld_auto_pagewise[intent][]">

                                                                            <?php 
                                                                                foreach($allIntents as $key => $value){
                                                                                    ?>
                                                                                    <optgroup label="<?php echo $key ?>">
                                                                                        <option value="" >None</option>
                                                                                        <?php foreach($value as $val){ ?>

                                                                                            <option value="<?php echo $val; ?>" <?php echo ($exitintent[$e]==$val?'selected="selected"':''); ?>><?php echo $val; ?></option>

                                                                                        <?php } ?>
                                                                                    </optgroup>
                                                                                    <?php
                                                                                }
                                                                            ?>

                                                                        </select>                                                   
                                                                    </div>
                                                                </div>

                                                            <?php } ?>

                                                        <?php 
                                                        }else{
                                                        ?>

                                                        <div class="qcld_scrollintent_message_single">

                                                            <div class="cxsc-settings-blocks">
                                                                <h4><?php echo esc_html__('Please select a Page', 'wpchatbot'); ?></h4>
                                                                
                                                                <select name="qcld_auto_pagewise[page][]">
                                                                    <?php 
                                                                     
                                                                        foreach($wp_chatbot_pages as $wp_chatbot_page){
                                                                            ?>
                                                                                <option value="<?php echo $wp_chatbot_page->ID; ?>"><?php echo $wp_chatbot_page->post_title; ?></option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                
                                                            </div>

                                                            <div class="cxsc-settings-blocks" class="wp_chatbot_exit_intent_body">
                                                                <h4 class="qc-opt-title"><?php echo esc_html__('Your Message', 'wpchatbot'); ?> </h4>
                                                                <?php $exit_intent_settings = array('textarea_name' =>
                                                                    'qcld_auto_pagewise[message][]',
                                                                    'textarea_rows' => 20,
                                                                    'editor_height' => 100,
                                                                    'disabled' => 'disabled',
                                                                    'media_buttons' => false,
                                                                    'tinymce'       => array(
                                                                        'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                                                );
                                                                wp_editor('', 'qcld_auto_pagewise_message_0', $exit_intent_settings); 
                                                                
                                                                
                                                                ?>
                                                            </div>

                                                            
                                                            <div class="cxsc-settings-blocks">
                                                                <h4 class="qc-opt-title">Trigger an Intent Instead</h4>     
                                                                <select name="qcld_auto_pagewise[intent][]">

                                                                    <?php 
                                                                        foreach($allIntents as $key => $value){
                                                                            ?>
                                                                            <optgroup label="<?php echo $key ?>">
                                                                                <option value="" >None</option>
                                                                                <?php foreach($value as $val){ ?>

                                                                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>

                                                                                <?php } ?>
                                                                            </optgroup>
                                                                            <?php
                                                                        }
                                                                    ?>

                                                                </select>                                                   
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div><!-- Repeatable wraper -->

                                                    <div class="row">
                                                        <div class="col-sm-6 text-left"></div>
                                                        <div class="col-sm-6 text-right">
                                                            <button class="btn btn-success btn-sm" type="button"
                                                                    id="add-more-autointent-message">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__('Add', 'wpchatbot'); ?>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div><!--Dynamic Container-->

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div id="wp-chatbot-tab-checkout" class="tab-pane">

                                    <div class="top-section">
                                        <div class="row">
                                    <!--Cart Retargating-->
                                    <?php 
                                        if(function_exists('qcpd_wpwc_addon_lang_init')){

                                            do_action('qcld_wpwc_cart_ret_option_woocommerce');
                                        }

                                    ?> 									  
                                    <!--Cart Retargating-->
                                    </div>
                                    </div>

                                </div>

                            </div>


                            
            </section>
            

            
           
            
        </div>

        <div class="wp-chatbot-admin-footer">
                    <div class="row">
                        <div class="text-left col-sm-3 col-sm-offset-3">
                            
                        </div>
                        <div class="text-right col-sm-6">
                            <input type="submit" class="btn btn-primary submit-button" name="submit" id="submit" value="Save Settings">
                        </div>
                    </div>
                    <!--                    row-->
                </div>
        

    </div>
    <?php wp_nonce_field('wp_chatbot'); ?>
    </form>
</div>
<div id="wpbot-load-qcbot" title="Launch the chatbot for testing" class="qc_wpbot_floating_main qc_right_position" style="display: block;" >
    <div class="qc_bot_floating_content"> <img alt="Launch the chatbot for testing" src="<?php echo esc_url(QCLD_wpCHATBOT_IMG_URL.'/icon-0.png'); ?>" alt="WPBot"><p>Test Your Changes</p> </div>
</div>
<div id="wpbot-qcbot-myModal" class="wpbot-giphy-modal" style="z-index: 99999;padding-top: 0;">
    <?php $page = get_page_by_title('wpwBot Mobile App'); ?>
    <!-- Modal content -->
    <div class="wpbot-giphy-modal-content" style="height: 95%;
    overflow: auto;
    box-shadow: 2px 5px 15px 5px #0707075e;
    border-radius: 5px;
    max-width: 1600px;">
    <span class="wpbot-qcbot-close">&times;</span>
    To test in the front end, after making any changes, please type reset and hit enter in the ChatBot to start testing from the beginning or open a new Incognito window (Ctrl+Shit+N in Chrome).
    <iframe id="qcwpbot_ifram_qcbot" src="about:blank" data-src="<?php echo home_url().'/'.$page->post_name; ?>" height="100%" width="100%" style="border:none;height: calc(100% - 46px);"></iframe>
    </div>

</div>

<script type="text/javascript">

// Get the modal
var modal1 = document.getElementById("wpbot-qcbot-myModal");

// Get the button that opens the modal
var btn1 = document.getElementById("wpbot-load-qcbot");

var giphyifram1 = document.getElementById('qcwpbot_ifram_qcbot');

// Get the <span> element that closes the modal
var span1 = document.getElementsByClassName("wpbot-qcbot-close")[0];

// When the user clicks the button, open the modal 
btn1.onclick = function() {
  modal1.style.display = "block";
  giphyifram1.setAttribute('src', giphyifram1.getAttribute('data-src'));
}

// When the user clicks on <span> (x), close the modal
span1.onclick = function() {
  modal1.style.display = "none";
  giphyifram1.setAttribute('src', 'about:blank');
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal1) {
    modal1.style.display = "none";
    giphyifram1.setAttribute('src', 'about:blank');
  }
}

</script>
