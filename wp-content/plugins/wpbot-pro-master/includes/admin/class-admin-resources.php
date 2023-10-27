<?php

/**
 * Class Qcld_WPBot_Admin_Resources
 */
class Qcld_WPBot_Admin_Resources {

    public function __construct() {

        if (is_admin() && !empty($_GET["page"]) && ($_GET["page"] == "wpbot")) {
            add_action('admin_enqueue_scripts', array($this, 'qcld_wb_chatbot_admin_scripts'));
        }

        if (is_admin() && !empty($_GET["page"]) && ($_GET["page"] == "email-subscription" || $_GET["page"] == "wbca-chat-history" || $_GET["page"] == "wbcs-botsessions-page"  || $_GET["page"] == "wbcs-botsessions-notansweredpage" || $_GET["page"] == "chatbot-crawl-page-list" || $_GET["page"] == "stop-word" || $_GET["page"] == "wpbot-panel" || $_GET["page"] == "wpbot-modules" || $_GET["page"] == "retarget-settings" || $_GET["page"] == "wpwc-settings-page" || $_GET["page"] == "language-center" || $_GET["page"] == "wpbot_openAi" || $_GET["page"] == "chatbot-menu" )) {
            add_action('admin_enqueue_scripts', array($this, 'qcld_wb_chatbot_admin_scripts'));
        }
    }

    /**
     * Include admin scripts
     */
    public function qcld_wb_chatbot_admin_scripts($hook)
    {
        global $woocommerce, $wp_scripts;
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        if (((!empty($_GET["page"])) && ($_GET["page"] == "wpbot")) || ($hook == "widgets.php") || ($_GET["page"] == "stop-word") || ($_GET["page"] == "wpbot-panel") || ($_GET["page"] == "retarget-settings") || ($_GET["page"] == "language-center") || ($_GET["page"] == "wpwc-settings-page") || ($_GET["page"] == "chatbot-menu") || ($_GET["page"] == "wpbot_openAi") ) {

            //dokan pro compatibility issue fixed.
            wp_deregister_script( 'dokan-vue-bootstrap' );
            
            wp_enqueue_script('jquery');
            
            wp_register_style('qlcd-wp-chatbot-admin-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/admin-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qlcd-wp-chatbot-admin-style');
            wp_register_style('qlcd-wp-chatbot-font-awe', QCLD_wpCHATBOT_PLUGIN_URL . 'css/font-awesome.min.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qlcd-wp-chatbot-font-awe');
            wp_register_style('qlcd-wp-chatbot-tabs-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/wp-chatbot-tabs.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qlcd-wp-chatbot-tabs-style');
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script( 'jquery-ui-draggable' );
            wp_enqueue_script( 'jquery-ui-droppable' );
            wp_enqueue_style( 'wp-color-picker');
            wp_enqueue_script( 'wp-color-picker');
            wp_enqueue_script( 'jquery-ui-sortable');
            wp_register_script('qcld-wp-chatbot-qcFWTabs', QCLD_wpCHATBOT_PLUGIN_URL . 'js/cbpFWTabs.js', array(), true);
            wp_enqueue_script('qcld-wp-chatbot-qcFWTabs');
            wp_register_script('qcld-wp-chatbot-modernizrqc-custc', QCLD_wpCHATBOT_PLUGIN_URL . 'js/modernizr.custom.js', array(), true);

           
            $date = date('Y-m-d', strtotime(get_option('qcwp_install_date'). ' + 7 days'));
            if($date < date('Y-m-d')){
                $wp_chatbot_obj = array(
                    'wp_qc_img_check'=> true
                );
            }else{
                $wp_chatbot_obj = array(
                    'wp_qc_img_check'=> false
                );
            }
            
            wp_enqueue_script('qcld-wp-chatbot-modernizrqc-custc');
            wp_localize_script('qcld-wp-chatbot-modernizrqc-custc', 'wp_chatbot_obj', $wp_chatbot_obj);

            if ( $_GET["page"] !== "wpbot-modules" ) {
                wp_register_script('qcld-wp-chatbot-bootcampqc-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/bootstrap.js', array('jquery'), true);
                wp_enqueue_script('qcld-wp-chatbot-bootcampqc-js');
    
                wp_register_style('qcld-wp-chatbot-bootcampqc-css', QCLD_wpCHATBOT_PLUGIN_URL . 'css/bootstrap.min.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
                wp_enqueue_style('qcld-wp-chatbot-bootcampqc-css');
            }

            wp_register_style('jquery.fontpicker.min.css', QCLD_wpCHATBOT_PLUGIN_URL . 'css/jquery.fontpicker.min.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('jquery.fontpicker.min.css');
            //jquery time picker
            wp_register_script('qcld-wp-chatbot-qcpickertm-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/jquery.timepicker.js', array('jquery'), true);
            wp_enqueue_script('qcld-wp-chatbot-qcpickertm-js');
            wp_register_script('qcld-wp-fontpicker-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/fontpicker.js',array('jquery'), true);
            wp_enqueue_script('qcld-wp-fontpicker-js');
            wp_register_style('qcld-wp-chatbot-qcpickertm-css', QCLD_wpCHATBOT_PLUGIN_URL . 'css/jquery.timepicker.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
            wp_enqueue_style('qcld-wp-chatbot-qcpickertm-css');
            // wp_register_script('qcld-wp-sweetalert-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/sweetalert.min.js', array('jquery'),QCLD_wpCHATBOT_VERSION, true);
            // wp_enqueue_script('qcld-wp-sweetalert-js');
            wp_register_script('qcld-wp-chatbot-admin-js', QCLD_wpCHATBOT_PLUGIN_URL . 'js/qcld-wp-chatbot-admin.js', array('jquery', 'jquery-ui-core','jquery-ui-sortable','wp-color-picker','qcld-wp-chatbot-qcpickertm-js'),QCLD_wpCHATBOT_VERSION, true);
            wp_enqueue_script('qcld-wp-chatbot-admin-js');
            wp_localize_script('qcld-wp-chatbot-admin-js', 'ajax_object',
                array('ajax_url' => admin_url('admin-ajax.php'),'ajax_nonce' => wp_create_nonce('wp_chatbot'),'image_path' => QCLD_wpCHATBOT_IMG_URL, 'intents' => qc_get_all_intents(), 'pages'=>get_pages()));
            // WordPress  Media library
            wp_enqueue_media();
        }
		
		wp_register_style('qlcd-wp-chatbot-admin-style', QCLD_wpCHATBOT_PLUGIN_URL . 'css/admin-style.css', '', QCLD_wpCHATBOT_VERSION, 'screen');
        wp_enqueue_style('qlcd-wp-chatbot-admin-style');
		
    }

}

new Qcld_WPBot_Admin_Resources();