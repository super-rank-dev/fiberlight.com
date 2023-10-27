<?php

class Qcld_startmenu_menu{

    /**
     * Constructor
     * 
     * @since 1.0.0
     * 
     * @return null
     */
    public function __construct(){

        if ((!empty($_GET["page"])) && ($_GET["page"] == "chatbot-menu")) {
            add_action('admin_init', array( $this, 'save_options' ));
        }
    }

    /**
     * Render chatbot menu admin settings page
     *
     * @since 1.0.0
     * 
     * @return void
     */
    public static function menu(){
        global $startmenu_settings;
        $action = admin_url('admin.php?page=chatbot-menu');
        include_once QCLD_STRTMENU_PLUGIN_DIR_PATH . 'includes/admin/templates/settings.php';
    }

    /**
     * Save options
     *
     * @return void
     */
    public function save_options(){
        if (isset($_POST['submit'])) {
            if( !empty( qcld_bot_startmenu()->settings ) ){
                foreach( qcld_bot_startmenu()->settings as $setting=>$options ){
                    if( isset( $_POST[$setting] ) ){
                        $qlcd_wp_chatbot_viewed_products= maybe_serialize( $_POST[$setting] );
                        update_option( $setting, $qlcd_wp_chatbot_viewed_products );
                    }else{
                        update_option( $setting, '' );
                    }
                }
            }
            
        }
    }
}

new Qcld_startmenu_menu();