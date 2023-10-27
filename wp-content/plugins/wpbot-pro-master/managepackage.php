<?php
add_action( 'init', 'qc_wpbot_addon_init' );
function qc_wpbot_addon_init() {
   
    // Starter package
    $addons_array = array(
        'active' => array(
            'chat-session-addon/wpbot-chat-history-addon.php' => 'Chat Session Module',
            'str-pro-addon/init.php' => 'Chatbot STR Pro Module',
            'conversational-forms-pro/qcformbuilder-core.php' => 'Conversational Form Builder Pro',
            'live-chat-addon/wpbot-chat-addon.php' => 'Live chat adddon for chat bot',
            'extended-search-addon/wpbot-posttype-search-addon.php' => 'Extended Search Module',
            //'chatbot-openai-addon/qcld-bot-openai.php' => 'WPBot Open AI Module',
        ),
        'inactive' => array(
            'bot-woocommerce/wpbot-woocommerce-addon.php' => 'Woocommerce Addon for Chatbot (Please Activate this ONLY if you have Woocommerce Installed and Active)',
            'white-label-chatbot-addon/white-label-wpbot.php' => 'white label chatbot Module',
            'chatbot-extended-ui/chatbot-extended-ui.php' => 'Chatbot Extended UI Module',
            'qc-mailing-list-integration-addon/qc-mailing-list-integration-addon.php' => 'Mailing List Integration Module',
            'messenger-chatbot-addon/wpbot-fb-messenger-addon.php' => 'Messenger ChatBot Module',
            'whatsapp-chatbot-addon/whatsapp-chatbot-addon.php' => 'WhatsApp Chatbot Module',
            'chatbot-setting-export-import/init.php' => 'Chatbot Settings Export Import',
            'bot-multilanguage/init.php' => 'WPBot Multi-Language Module',
            'voice-message-addon/wpbotvoicemessage.php' => 'WPBot Voice Module',
            'telegram-chatbot-addon/init.php' => 'WPBot Telegram Module',
            )
        );


    if ( ! get_option( 'wpbot_master_addons' ) ) {
        update_option( 'wpbot_master_addons', $addons_array );
    }
    $addons = get_option( 'wpbot_master_addons' );
    $url = admin_url('admin.php?page=wpbot-modules');
    // Handle bulk action form submit
    if ( isset($_GET['page']) && $_GET['page'] == 'wpbot-modules' && isset( $_POST['bulk_action'] ) && $_POST['bulk_action'] != '' && ! empty( $_POST['addons'] ) ) {
        $addons = $_POST['addons'];
        $action = sanitize_text_field( $_POST['bulk_action'] );
        $new_addons = qc_wpbot_addon_add_remove( $action, $addons );
        update_option( 'wpbot_master_addons', $new_addons );
        wp_safe_redirect( $url );
        exit;
    }

    if ( isset($_GET['page']) && $_GET['page'] == 'wpbot-modules' && isset( $_GET['addon_action'] ) && $_GET['addon_action'] != '' && ! empty( $_GET['addon'] ) ) {
        $addons = array( $_GET['addon'] );
        $action = sanitize_text_field( $_GET['addon_action'] );
        $new_addons = qc_wpbot_addon_add_remove( $action, $addons );
        update_option( 'wpbot_master_addons', $new_addons );
        wp_safe_redirect( $url );
        exit;
    }



}

add_action('admin_menu', 'qc_addon_chatbot_menu', 100);
function qc_addon_chatbot_menu() {
    add_submenu_page( 
        'wpbot-panel',   //or 'options.php'
        'Manage Modules',
        'Manage Modules',
        'manage_options',
        'wpbot-modules',
        'qc_addons_callback_page'
    );
}

function qc_wpbot_addon_add_remove( $action, $addons ) {
        $current_addons = get_option( 'wpbot_master_addons' );
        $active_addons = $current_addons['active'];
        $inactive_addons = $current_addons['inactive'];

        if ( $action == 'inactive' ) {
            foreach( $addons as $path ) {
                $name = '';
                if(($path == 'voice-addon/init.php') || ($path == 'voice-message-addon/wpbotvoicemessage.php')){
                    $path =  'voice-message-addon/wpbotvoicemessage.php';
                    $name = 'WPBot Voice Module';
                }
                if ( array_key_exists( $path, $active_addons ) ) {
                    $name = $active_addons[$path];
                    unset( $active_addons[$path] );
                }
                if ( ! array_key_exists( $path, $inactive_addons ) ) {
                    $inactive_addons[$path] = $name;
                    if(($path == 'voice-addon/init.php') || ($path == 'voice-message-addon/wpbotvoicemessage.php')){
                        $active_addons[$path] = 'WPBot Voice Module';
                    }
                }
            }

        } else {
            foreach( $addons as $path ) {
                
                $name = '';
                if(($path == 'voice-addon/init.php') || ($path == 'voice-message-addon/wpbotvoicemessage.php')){
                    $path =  'voice-message-addon/wpbotvoicemessage.php';
                    $name = 'WPBot Voice Module';
                }
                if ( array_key_exists( $path, $inactive_addons ) ) {
                    $name = $inactive_addons[$path];
                    unset( $inactive_addons[$path] );
                }
                if ( ! array_key_exists( $path, $active_addons ) ) {
                    $active_addons[$path] = $name;
                    if(($path == 'voice-addon/init.php') || ($path == 'voice-message-addon/wpbotvoicemessage.php')){
                        $active_addons[$path] = 'WPBot Voice Module';
                    }
                }
            }
        }
        return $new_addons = array(
            'active' => $active_addons,
            'inactive' => $inactive_addons
        );
}

function qc_addons_callback_page() {
    wp_register_style('qlcd-wp-chatbot-admin-style-email', QCLD_wpCHATBOT_PLUGIN_URL.'/css/email_subscription.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
    wp_enqueue_style('qlcd-wp-chatbot-admin-style-email');

    wp_register_script('qcld-wp-chatbot-email-subscription-js', QCLD_wpCHATBOT_PLUGIN_URL.'/js/email_subscription.js', array('jquery'), true);
        wp_enqueue_script('qcld-wp-chatbot-email-subscription-js');


?>
<div class="wrap">
    <h1 class="wpbot_header_h1"><?php echo esc_html__('WPBot', 'wpchatbot'); ?> </h1>
</div>
<div class="wp-chatbot-wrap">
    <div class="wpbot_dashboard_header container"><h1 style="color: #fff"><?php echo wpbot_text(); ?> Modules</h1></div>
    <div class="wpbot_addons_section container">
        <div class="wpbot_single_addon_wrapper">
            <?php 
            $addons = get_option( 'wpbot_master_addons' );
            $url = admin_url('admin.php?page=wpbot-modules');
            ?>
            <div class="qchero_sliders_list_wrapper">
                
                <form id="wpcs_form_sessions" action="<?php echo $url; ?>" method="POST" style="width:100%">

                    <select name="bulk_action" >
                        <option value="">Bulk Action</option>
                        <option value="active">Activate</option>
                        <option value="inactive">Deactivate</option>
                    </select>
                    <button class="button-primary" id="wpbot_submit_email_form">Apply</button>

                    <div class="qchero_slider_table_area">
                        <div class="sld_payment_table">
                            <div class="sld_payment_row header">
                                
                                <div class="sld_payment_cell" style="width: 40px">
                                    <input type="checkbox" id="wpbot_checked_all" />
                                </div>

                                <div class="sld_payment_cell">
                                    <?php echo esc_html__( 'Name', 'qc-opd' ) ?>
                                </div>
                                
                            </div>

                            <?php
                            foreach($addons as $key => $chatbot_addons){
                                if ( ! empty( $chatbot_addons ) ) {
                                    foreach( $chatbot_addons as $path => $name ) {
                                        if($path == 'voice-addon/init.php'){
                                            $path =  'voice-message-addon/wpbotvoicemessage.php';
                                            $name = 'WPBot Voice Module';
                                        }
                            ?>
                            <div class="sld_payment_row <?php echo ( $key == 'active' ? 'activated' : '' ); ?> ">

                                <div class="sld_payment_cell" style="width: 40px">
                                    
                                    <input type="checkbox" name="addons[]" class="wpbot_email_checkbox" <?php echo ( $key == 'active' ? 'checked="checked"' : '' ); ?> value="<?php echo esc_attr( $path ) ?>" />
                                </div>
                                
                                <div class="sld_payment_cell">
                                    <div class="sld_responsive_head"><?php echo esc_html__('Name', 'qc-opd') ?></div>
                                    <?php echo esc_html( $name ); ?><br>
                                    <?php if ( $key == 'active' ) {
                                        $deactivate_url = add_query_arg( array(
                                            'addon_action' => 'inactive',
                                            'addon' => $path,
                                        ), $url );
                                        echo '<span><a href=" '. esc_url_raw( $deactivate_url ) .' ">Deactivate</a></span>';
                                    } else {
                                        $deactivate_url = add_query_arg( array(
                                            'addon_action' => 'active',
                                            'addon' => $path,
                                        ), $url );
                                        echo '<span><a href=" '. esc_url_raw( $deactivate_url ) .' ">Activate</a></span>';
                                    } 
                                    ?>
                                    
                                </div>
                                
                            </div>
                            <?php
                               }
                            }
                            }
                            ?>

                        </div>
                    </div>
                </form>
            </div>
            <div style="clear:both"></div>
        </div>

    </div>
</div>
<style>
    .container {
        width: 1170px;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }
    .sld_payment_row:nth-of-type(odd) {
        background: #fff;
    }
    .sld_payment_row.header {
        background: #0073aa;
    }
    .sld_payment_table {
        border-collapse: collapse;
    }
    .sld_payment_row {
        border-bottom: 1px solid #adadad;
    }
    .sld_payment_row.activated {
        background: #bee0ffa3;
    }
</style>
<?php
}

$current_addons = get_option( 'wpbot_master_addons' );
if ( isset( $current_addons['active'] ) && is_array( $current_addons['active'] ) && ! empty( $current_addons['active'] ) ) {
    foreach( $current_addons['active'] as $path => $name ) {
        $addon_path = QCLD_wpCHATBOT_PLUGIN_DIR_PATH . 'addons/' . $path;
        if ( file_exists( $addon_path ) ) {
            require_once $addon_path;
        }
    }
}
add_action( 'init', 'qc_package_do_stuff_on_activation' );
function qc_package_do_stuff_on_activation() {
    
    if ( get_option( 'wpbot_plugin_activated' ) ) {
        
        //For Chat session addon.
        if ( function_exists( 'qcld_wb_chatboot_sessions_defualt_options' ) ) {
            qcld_wb_chatboot_sessions_defualt_options();
        }

        // For STR
        if ( function_exists( 'qcld_str_pro_defualt_options' ) ) {
            qcld_str_pro_defualt_options( is_multisite() );
        }
        // for extendend site search 
        if(function_exists('qcld_wpbot_synonymsCreateTable')){
            qcld_wpbot_synonymsCreateTable();
        } 
        // Form builder
        if ( class_exists( 'Qcformbuilder_Forms' ) ) {
            Qcformbuilder_Forms::activate_qcformbuilder_forms();
        }
        // For livechat addon
        if ( class_exists( 'wbca_Apps' ) ) {
            $wbca_app = new wbca_Apps();
            $wbca_app->initialize_controllers();
        
        }
        // For  addon
        if ( class_exists( 'wbca_Database_Manager' ) ) {

            $database_manager = new wbca_Database_Manager();
           $database_manager->create_custom_tables();
        }
        // For Messenger addon
        if ( function_exists( 'qcld_wbfb_messenger_defualt_options' ) ) {
            qcld_wbfb_messenger_defualt_options();
        }
        delete_option( 'wpbot_plugin_activated' );
        // voice addon
       

    }

}

