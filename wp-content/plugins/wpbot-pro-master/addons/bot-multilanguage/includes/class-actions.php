<?php

class WPBotML_Actions {
    
    public function __construct(){
        add_action( 'ml_render_language_fields', array( $this, 'render_language_field' ),10, 4 );
        add_action( 'ml_render_intent_selection_fields', array( $this, 'render_intent_field' ),10, 2 );
        add_action( 'ml_render_dynamic_multi_option', array( $this, 'render_dynamic_multi_option' ),10, 3 );
        add_action( 'ml_render_notifications', array( $this, 'render_notifications' ) );
        add_action( 'ml_render_faqs', array( $this, 'render_faqs' ) );
        add_action( 'ml_render_retmsg', array( $this, 'render_retmsg' ),10, 2 );
        add_action( 'ml_render_start_menu', array( $this, 'render_start_menu' ) );
        add_action( 'ml_render_lan_dropdown', array( $this, 'render_lan_dropdown' ) );
        add_action( 'ml_render_dialogflow', array( $this, 'render_lan_dialogflow' ) );
        //add_action( 'init', array( $this, 'init' ) );
    }

    public function init(){
        global $wp;
        echo home_url( $wp->request );EXIT;
    }

    public function render_language_field( $title, $key, $default, $class='' ){
        $languages = qcld_wpbotml()->languages;
        foreach( $languages as $language ){

            $option_val = get_option($key);
            if( $option_val && is_array( $option_val ) && array_key_exists( $language, $option_val ) ){
                $value = $option_val[$language];
            }else{
                $value = $default;
            }

        ?>

        <h4 class="qc-opt-title"><?php echo $title; ?> - <?php echo qcld_wpbotml()->lanName( $language ); ?>  </h4>
            <div class="cxsc-settings-blocks">
                <input class="form-control qc-opt-dcs-font" style="width: 100%;" value='<?php echo $value; ?>' id="<?php echo esc_attr($key) ?>" type="text" name="<?php echo esc_attr($key) ?>[<?php echo $language; ?>]" />
            </div>

        <?php
        }
    }
    
    public function render_intent_field( $title, $settings_key ){
        $languages = qcld_wpbotml()->languages;
        foreach( $languages as $language ){

            $option_val = get_option($settings_key);
            if( $option_val && is_array( $option_val ) && array_key_exists( $language, $option_val ) ){
                $value = $option_val[$language];
            }else{
                $value = '';
            }

        ?>
        <div class="col-xs-12">
            <h4 class="qc-opt-title"><?php echo $title; ?> - <?php echo qcld_wpbotml()->lanName( $language ); ?> </h4>
            <div class="cxsc-settings-blocks">
                <select name="<?php echo esc_attr($settings_key) ?>[<?php echo $language; ?>]">
                    <?php 
                        $intents = qc_get_all_intents();

                        

                        foreach($intents as $key=>$values){
                        ?>
                        <optgroup label="<?php echo ucfirst($key); ?>">
                            <?php 
                                foreach($values as $val){
                                ?>
                                    <option value="<?php echo trim($val); ?>" <?php echo ($value==trim($val)?'selected="selected"':''); ?>><?php echo trim($val); ?></option>
                                <?php
                                }
                            ?>
                        </optgroup>
                        <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <?php
        }
    }

    public function render_dynamic_multi_option( $options, $option_name, $option_text ){

        $languages = qcld_wpbotml()->languages;
        foreach( $languages as $language ){
?>

        <h4 class="qc-opt-title"><?php echo esc_html__($option_text, 'wpchatbot'); ?> - <?php echo qcld_wpbotml()->lanName( $language ); ?></h4>
        <div class="wp-chatbot-lng-items">
            <?php
            if (is_array($options) && count($options) > 0 && isset( $options[ $language ] )) {
                foreach ($options[ $language ] as $key => $value) {
                    ?>
                    <div class="row" class="wp-chatbot-lng-item">
                        <div class="col-xs-10">
                            <textarea type="text"
                                   class="form-control qc-opt-dcs-font"
                                   name="<?php echo esc_html($option_name); ?>[<?php echo $language; ?>][]"
                                   ><?php echo esc_html(str_replace('\\', '', $value)); ?></textarea>
                        </div>
                        <div class="col-xs-2">
                            <button type="button" class="btn btn-danger btn-sm wp-chatbot-lng-item-remove">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>
                    </div>
                    <?php
                }
            } else { ?>
                <div class="row" class="wp-chatbot-lng-item">
                    <div class="col-xs-10">
                        <textarea type="text"
                               class="form-control qc-opt-dcs-font"
                               name="<?php echo esc_html($option_name); ?>[<?php echo $language; ?>][]"
                               ><?php echo esc_html($option_text); ?></textarea>
                    </div>
                    <div class="col-xs-2">
                        <span class="wp-chatbot-lng-item-remove"><?php echo esc_html__('X', 'wpchatbot'); ?></span>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-sm-2 col-sm-offset-10">
                <button type="button" class="btn btn-success btn-sm wp-chatbot-lng-item-add"> <span class="glyphicon glyphicon-plus"></span> </button>
            </div>
        </div>

<?php
        }

    }

    public function render_notifications(){
        $languages = qcld_wpbotml()->languages;
        $allnotifications = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_notifications')));
        $allintents = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(unserialize(get_option('qlcd_wp_chatbot_notifications_intent')));
        foreach( $languages as $language ){
            $notifications = ( isset( $allnotifications[$language] ) ? $allnotifications[$language] : $allnotifications[get_locale()] );
            $intents = ( isset( $allintents[$language] ) ? $allintents[$language] : $allintents[get_locale()] );

            $allIntents = qc_get_all_intents( $language );
        ?>

        <div class="notification-lan-container">
            <h3>Notification Content - <?php echo qcld_wpbotml()->lanName( $language ); ?></h3>
            <hr>
            <div class="notification-block-inner">
            <?php
            if (!empty($notifications)) {
                $chatbot_notif_counter=0;
                foreach ($notifications as $notification) {
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="button"
                                    class="btn btn-danger btn-sm wp-chatbot-remove-notification pull-right">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                            <div class="cxsc-settings-blocks" style="margin-top:26px">
                                <?php wp_editor(html_entity_decode(stripcslashes($notification)), 'qlcd_wp_chatbot_notifications_'.$language.'_'.esc_html($chatbot_notif_counter), array('textarea_name' =>
                                    'qlcd_wp_chatbot_notifications['.$language.'][]',
                                    'textarea_rows' => 20,
                                    'editor_height' => 100,
                                    'disabled' => 'disabled',
                                    'media_buttons' => false,
                                    'tinymce'       => array(
                                        'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                                )); ?>
                            </div>
                            <div class="cxsc-settings-blocks">
                                <h4 class="qc-opt-title">Select an Intent for Click Action</h4>     
                                <select name="qlcd_wp_chatbot_notifications_intent[<?php echo $language; ?>][]">

                                    <?php 
                                        foreach($allIntents as $key => $value){
                                            ?>
                                            <optgroup label="<?php echo $key ?>">
                                                <option value="" >None</option>
                                                <?php foreach($value as $val){ ?>

                                                    <option value="<?php echo $val; ?>" <?php echo (isset($intents[$chatbot_notif_counter])&&$intents[$chatbot_notif_counter]==$val?'selected="selected"':''); ?>><?php echo $val; ?></option>

                                                <?php } ?>
                                            </optgroup>
                                            <?php
                                        }
                                    ?>

                                </select>                                                   
                            </div>

                        </div>
                        
                    </div>
                    
                    <?php
                    $chatbot_notif_counter++;
                }
                
            } else {
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="button"
                                class="btn btn-danger btn-sm wp-chatbot-remove-notification pull-right">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                        <div class="cxsc-settings-blocks">
                            <?php wp_editor(html_entity_decode(stripcslashes('')), 'qlcd_wp_chatbot_notifications_'.$language.'_0', array('textarea_name' =>
                                'qlcd_wp_chatbot_notifications['.$language.'][]',
                                'textarea_rows' => 20,
                                'editor_height' => 100,
                                'disabled' => 'disabled',
                                'media_buttons' => false,
                                'tinymce'       => array(
                                    'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                            )); ?>
                        </div>
                        <div class="cxsc-settings-blocks">
                            <h4 class="qc-opt-title">Select an Intent for Click Action</h4>     
                            <select name="qlcd_wp_chatbot_notifications_intent[<?php echo $language; ?>][]">

                                <?php 
                                    foreach($allIntents as $key => $value){
                                        ?>
                                        <optgroup label="<?php echo $key ?>">
                                            <option value="" >None</option>
                                            <?php foreach($value as $val){ ?>

                                                <option value="<?php echo $val; ?>" ><?php echo $val; ?></option>

                                            <?php } ?>
                                        </optgroup>
                                        <?php
                                    }
                                ?>

                            </select>                                                   
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            </div>
            <div class="row">
                <div class="col-sm-6 text-left"></div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-success btn-sm add-more-notification-message" type="button"
                             data-language="<?php echo $language; ?>">
                        <i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__('Add', 'wpchatbot'); ?>
                    </button>
                </div>
            </div>
        </div>


        <?php
        }
    }

    public function render_faqs(){
        $languages = qcld_wpbotml()->languages;
        $allsupport_quereis=qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(unserialize( get_option('support_query')));
        $allsupport_ans=qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(unserialize( get_option('support_ans')));
        foreach( $languages as $language ) {

            $support_quereis = ( isset( $allsupport_quereis[$language] ) ? $allsupport_quereis[$language] : $allsupport_quereis[get_locale()] );
            $support_ans = ( isset( $allsupport_ans[ $language ] ) ? $allsupport_ans[ $language ] : $allsupport_ans[ get_locale() ] );

        ?>

    <h4 class="qc-opt-title"><?php echo esc_html__('Build FAQ Query and Answers', 'wpchatbot'); ?> - <?php echo qcld_wpbotml()->lanName( $language ); ?></h4>
    <div class="block-inner ui-sortable" id="wp-chatbot-support-builder_<?php echo $language; ?>">
        <?php
        if (count($support_ans) >= 1) {
            
            $query_ans_counter=0;
            foreach (array_combine($support_quereis, $support_ans) as $query => $ans) {
                ?>
                <div class="row">
                    <span class="pull-right">  </span>
                    <div class="col-xs-12">
                        <button type="button"
                                class="btn btn-danger btn-sm wp-chatbot-remove-support pull-right">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                        <span  class="wp-chatbot-support-cross pull-right" >
                            <i  class="fa fa-crosshairs" aria-hidden="true"></i>
                        </span>
                        <div class="cxsc-settings-blocks">
                            <p class="qc-opt-dcs-font"><?php echo esc_html__('FAQ query ', 'wpchatbot'); ?></p>
                            <input type="text" class="form-control" name="support_query[<?php echo $language; ?>][]"
                                    placeholder="<?php echo esc_html__('FAQ query ', 'wpchatbot'); ?>" value="<?php echo esc_html($query) ?>">
                            <br>
                            <p class="qc-opt-dcs-font"><?php echo esc_html__('FAQ answer', 'wpchatbot'); ?></p>
                            <?php wp_editor(html_entity_decode(stripcslashes($ans)), 'support_ans_'.$language.'_'.esc_html($query_ans_counter), array('textarea_name' =>
                            'support_ans['. $language .'][]',
                            'textarea_rows' => 20,
                            'editor_height' => 100,
                            'disabled' => 'disabled',
                            'media_buttons' => false,
                            'tinymce'       => array(
                            'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                            )); ?>
                        </div>
                    </div>
                </div>
                <?php
                $query_ans_counter++;
            }
            
        } else {
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <button type="button"
                            class="btn btn-danger btn-sm wp-chatbot-remove-support pull-right">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <span  class="wp-chatbot-support-cross pull-right" >
                            <i  class="fa fa-crosshairs" aria-hidden="true"></i>
                        </span>
                    <div class="cxsc-settings-blocks">
                        <p class="qc-opt-dcs-font"><?php echo esc_html__('FAQ query', 'wpchatbot'); ?> </p>
                        <input type="text" class="form-control" name="support_query[ <?php echo $language; ?> ][]"
                                placeholder="<?php echo esc_html__('FAQ query ', 'wpchatbot'); ?>">
                        <br>
                        <p class="qc-opt-dcs-font"><strong><?php echo esc_html__('FAQ answer', 'wpchatbot'); ?></strong></p>
                        <?php wp_editor(html_entity_decode(stripcslashes('')), 'support_ans_'.$language.'_0', array('textarea_name' =>
                            'support_ans['. $language .'][]',
                            'textarea_rows' => 20,
                            'editor_height' => 100,
                            'disabled' => 'disabled',
                            'media_buttons' => false,
                            'tinymce'       => array(
                                'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
                        )); ?>
                    </div>
                    <br>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="row">
        <div class="col-sm-6 text-left"></div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-success btn-sm add-more-support-query" type="button"
                     data-language="<?php echo $language; ?>" ><i
                        class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__('Add More Questions and Answers', 'wpchatbot'); ?>
            </button>
        </div>
    </div>

        <?php
        }
    }

    public function render_retmsg( $title, $key ){
        $languages = qcld_wpbotml()->languages;
        foreach( $languages as $language ) {
?>
    <h4 class="qc-opt-title"><?php echo $title; ?> - <?php echo qcld_wpbotml()->lanName( $language ); ?></h4>
    <?php 
    $finalkey = $key.'['.$language.']';
    $exit_intent_settings = array('textarea_name' =>
        $finalkey,
        'textarea_rows' => 20,
        'editor_height' => 100,
        'disabled' => 'disabled',
        'media_buttons' => false,
        'tinymce'       => array(
            'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink',)
    );
    
    $ret_intent_message = maybe_unserialize( get_option($key) );

    if( is_array( $ret_intent_message ) && isset( $ret_intent_message[$language] )){
        $ret_intent_message = $ret_intent_message[$language];
    } elseif( is_array( $ret_intent_message ) && isset( $ret_intent_message[get_locale()] )){
        $ret_intent_message = $ret_intent_message[get_locale()];
    }
    wp_editor(html_entity_decode(stripslashes( $ret_intent_message )), $key.'_'.$language, $exit_intent_settings); 
    
        }
    }

    public function render_start_menu(){

        $languages = qcld_wpbotml()->languages;
        ?>
        <div class="qcld_multilan_manu_area">
            <select class="qcld_wpbot_start_lan_select">
                <?php 
                    foreach( $languages as $language ){
                        echo '<option value="'.$language.'">'.qcld_wpbotml()->lanName( $language ).'</option>';
                    }
                ?>
            </select>
        <?php
        $cnt = 0;
        foreach( $languages as $language ) {
            $cnt++;
        ?>
            <div class="qcld_wpbot_startmenu_area qcld_startarea_<?php echo $language ?>" <?php echo ( ( $cnt != 1 )?'style="display:none"':'' ); ?>>
                <?php 
                    $menu_order = maybe_unserialize( get_option('qc_wpbot_menu_order') );
                    if( $menu_order && isset( $menu_order[$language] )){
                        $menu_order = $menu_order[$language];
                    }else{
                        $menu_order = $menu_order[get_locale()];
                    }
                ?>
                <h2>Menu Sorting & Customization Area - <?php echo qcld_wpbotml()->lanName( $language ); ?></h2>
                <p style="color:red">*After making changes in the settings, please clear browser cache and cookies before reloading the page or open a new Incognito window (Ctrl+Shit+N in chrome).</p>
                <p>In this section you can control the UI of the menu.<br>
To adjust the Active Menu ordering just drag it up or down. To add a menu item in Active Menu simply drag a menu item from Available Menu and drop it to Active Menu . To remove a menu item from Active Menu simple drag the menu item and drop it to Available Menu.</p>

                <p style="color:red">* After making any changes to buttons label, You must have to remove the button from "Menu Area" and add it back from "Menu list".</p>
                <div class="qc_menu_setup_area">

                    <div class="qc_menu_area">
                        <h3>Active menu</h3>
                        
                        <div class="qc_menu_area_container qc_menu_area_sort" id="qc_menu_area">

                            <?php echo stripslashes($menu_order); ?>

                        </div>
                    </div>

                    <div class="qc_menu_list_area" >
                        <h3>Available Menu items</h3>
                        
                        <div class="qc_menu_list_container">
                            <p>Predefined Intents</p>
                        
                            <?php qcld_wpbot()->helper->render_start_menu($language); ?>

                        </div>

                    </div>

                    
                
                </div>
                
                <input class="qc_wpbot_menu_order" type="hidden" name="qc_wpbot_menu_order[<?php echo $language; ?>]" value='<?php echo stripslashes($menu_order); ?>' />
            </div>
        <?php
        }
        ?>
        </div>
        <?php
    }

    public function render_lan_dropdown(){
    ?>
        <select id="wpbot_language">
            <?php 
            $languages = qcld_wpbotml()->languages;
            $default_language = get_option( 'wpbotml_Default_language' );
            foreach( $languages as $language ){
                echo '<option value="'.$language.'" '.($default_language==$language?'selected="selected"':'').' >'.qcld_wpbotml()->lanName( $language ).'</option>';
            }
            ?>
        </select>
    <?php
    }

    public function render_lan_dialogflow(){
        $languages = qcld_wpbotml()->languages;
        ?>
        <div class="qcld_multilan_manu_area" style="margin-bottom: 50px;border-bottom: 1px solid;">
            <select class="qcld_wpbot_start_lan_select" style="margin-bottom: 24px;">
                <?php 
                    foreach( $languages as $language ){
                        echo '<option value="'.$language.'">'.qcld_wpbotml()->lanName( $language ).'</option>';
                    }
                ?>
            </select>
        <?php
        $cnt = 0;
        foreach( $languages as $language ) {
            $cnt++;

            $project_id = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_project_id' ));
            if( $project_id && is_array( $project_id ) && array_key_exists( $language, $project_id ) ){
                $project_id = $project_id[$language];
            }else{
                $project_id = '';
            }

            $private_key = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_project_key' ));
            if( $private_key && is_array( $private_key ) && array_key_exists( $language, $private_key ) ){
                $private_key = $private_key[$language];
            }else{
                $private_key = '';
            }

            $default_reply = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_defualt_reply' ));
            if( $default_reply && is_array( $default_reply ) && array_key_exists( $language, $default_reply ) ){
                $default_reply = $default_reply[$language];
            }else{
                $default_reply = '';
            }

            $dialogflow_cx = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_cx' ));
            if( $dialogflow_cx && is_array( $dialogflow_cx ) && array_key_exists( $language, $dialogflow_cx ) ){
                $dialogflow_cx = $dialogflow_cx[$language];
            }else{
                $dialogflow_cx = '';
            }

            $agent_language = maybe_unserialize(get_option( 'qlcd_wp_chatbot_dialogflow_agent_language' ));
            if( $agent_language && is_array( $agent_language ) && array_key_exists( $language, $agent_language ) ){
                $agent_language = $agent_language[$language];
            }else{
                $agent_language = '';
            }
        ?>
        <div class="qcld_wpbot_startmenu_area qcld_startarea_<?php echo $language ?>" <?php echo ( ( $cnt != 1 )?'style="display:none"':'' ); ?>>
            <!-- Dialogflow V2 Configuration -->
            <div class="form-group">
                <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow Project ID', 'wpchatbot'); ?></h4>
                <p>You can follow the <a href="https://www.youtube.com/watch?v=qY-EHFY2wH8" target="_blank">tutorial</a> to get the Project ID. </p>
                <input type="text" class="form-control qc-opt-dcs-font"
                        name="qlcd_wp_chatbot_dialogflow_project_id[<?php echo $language; ?>]"
                        value="<?php echo $project_id; ?>" placeholder="<?php echo esc_html__('DialogFlow Project ID', 'wpchatbot'); ?>">
            </div>


            <?php 
            $placeholderPrivatekey = '{
                "type": "service_account",
                "project_id": "PLACEYOUROWNID",
                "private_key_id": "31e300128..........c48",
                "private_key": "-----BEGIN PRIVATE KEY-----\nTHIS IS A DEMO PRIVATE KEY to SHOW HOW IT SHOULD LOOK. Replace with ACTUAL KEY.+OdT09MGEdAjlgSF2HMDA3fl8Ey4dmTxRfAN9No6G3Ugs3BrpZHfY\nSviWzS4JQ0GkCubcJc0DzJ8AqG6xX7E3SfKpdtKEn1eYV7sfQL3C2lm2lTj6nWdt\nxrkhJVHn61kxfPAWChnkdPa5EbMNFnV5mN5rhwaOxR+tEjW9nWBjVFG0NMnOMWF4\nsu6QJVjQMtI99jPBCid1r4XV/sPABSXh8dscWdMinGhZfuCjF4sOGHUUaw+VDGb6\nZpPOh65nw5fsdOHETsb4BN/LW72Khux+870Ig4jkuLIN3PnSF9QfwO8U2qTG5sZK\nn5nxhT9zAgMBAAECggEAX1NSWRGnrcVsu6n1jn9xUpzvxyy+CJe1Z1DvHo1tmHNS\n0Q8OI/Y........THIS IS A DEMO PRIVATE KEY to SHOW HOW IT SHOULD LOOK. Replace with your own key......................................paqQKBgQCJ\nvNCZIHpLGVqwiw4SVYgZW2i+VsZ78sOw0SuuhjZNmOlGjpalbQCjKs9l5dSz5t5D\nVleJVyriFaXyvVty/iF6orqTgv0EhcLO2RI9KSrTpbOXcIkgeunAhRM3oloxSndt\n98H3f1xRvTLIm1enERLkOyGHmm7nWFV0BQWD+CxeCwKBgDtBGn+uBgNgZjSaLnkJ\noemAoIBN6aD4+QWduPldRgTilH6ABQ26SL+t4sa9jbAtkMuD/hWOMLBqmz98tfCC\ndy6cPghea+b0S7lj/wmUaDA1Vmz7luCLm+lO+fe3K6WIlEhAP/9MXVH90Sj6CllF\nAn4stWzIKHrRKA3lIvgJv+9W\n-----END PRIVATE KEY-----\n",
                "client_email": "dialogflow-evysjn@wpbotpro.iam.gserviceaccount.com",
                "client_id": "1026.....032997",
                "auth_uri": "https://accounts.google.com/o/oauth2/auth",
                "token_uri": "https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
                "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/dialogflow-evysjn%40wpbotpro.iam.gserviceaccount.com"
            }';
            ?>

            <div class="form-group">
                <h4 class="qc-opt-title"><?php echo esc_html__('Private Key', 'wpchatbot'); ?></h4>
                <p>Put your google service account's private key JSON string here. You can follow the <a href="https://www.youtube.com/watch?v=qY-EHFY2wH8" target="_blank">tutorial</a> to get private key JSON file. </p>
                <textarea class="form-control" rows="20" name="qlcd_wp_chatbot_dialogflow_project_key[<?php echo $language; ?>]" placeholder='<?php echo $placeholderPrivatekey; ?>'><?php echo $private_key; ?></textarea>
            </div>

            <!-- End Dialogflow V2 Configuration -->
            

            <div class="form-group">
                <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow Defualt reply', 'wpchatbot'); ?></h4>
                <input type="text" class="form-control qc-opt-dcs-font"
                        name="qlcd_wp_chatbot_dialogflow_defualt_reply[<?php echo $language; ?>]"
                        value="<?php echo $default_reply; ?>" placeholder="<?php echo esc_html__('DialogFlow defualt reply', 'wpchatbot'); ?>">
            </div>
            
            <div class="form-group">
                <h4 class="qc-opt-title"><?php echo esc_html__('DialogFlow Agent Language (Ex: en)', 'wpchatbot'); ?></h4>
                <input type="text" class="form-control qc-opt-dcs-font"
                        name="qlcd_wp_chatbot_dialogflow_agent_language[<?php echo $language; ?>]"
                        value="<?php echo $agent_language; ?>" placeholder="<?php echo esc_html__('DialogFlow Agent Language', 'wpchatbot'); ?>">
            </div>

            

            <div class="form-group">
                <h4 class="qc-opt-title"><?php echo esc_html__('Enable Dialogflow CX', 'wpchatbot'); ?> </h4>
                <div class="cxsc-settings-blocks">
                    <input value="1" id="enable_wp_chatbot_dailogflow_cx" type="checkbox"
                            name="qlcd_wp_chatbot_dialogflow_cx[<?php echo $language; ?>]" <?php echo($dialogflow_cx == 1 ? 'checked' : ''); ?>>
                    <label for="enable_wp_chatbot_dailogflow_cx"><?php echo esc_html__('Enable Dialogflow CX', 'wpchatbot'); ?> </label>
                </div>
            </div>
            <br>
            <div class="form-group">
                <h4 class="qc-opt-title"><?php echo esc_html__('Please Click the Button Below to Test Dialogflow Connection.', 'wpchatbot'); ?> </h4>
                <p style="color:red"><?php echo esc_html__('*Save settings before pressing Test Dialogflow Connection', 'wpchatbot'); ?><br><?php echo esc_html__('*You must have owner permission for the service account your are using in Dialogflow agent.', 'wpchatbot'); ?></p>
                <div class="cxsc-settings-blocks">
                <button class="btn btn-primary qc_wpbot_df_status" data-language="<?php echo $language; ?>" >Test Dialogflow Connection</button>
                    <div class="qcwp_df_status"></div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        </div>
        <?php
    }
}

new WPBotML_Actions();
