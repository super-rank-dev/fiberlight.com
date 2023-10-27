<?php

/**
 * Telegram Menu Class
 */
class WpbotTelegram_Menu {

    /**
     * Constructor
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct(){
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_init', array($this, 'register_plugin_settings') );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );
        add_action( 'admin_post_qc_tg_connect', array($this, 'connect') );
        
    }

    
    function enqueue_script(){

        wp_enqueue_script('jquery');
    
        // please create also an empty JS file in your theme directory and include it too
        wp_enqueue_script('wpbotml-admin-script', QCLD_TELEGRAM_PLUGIN_URL . 'js/admin-script.js', array( 'jquery', ), qcld_telegram()->version ); 
    
    }

    /**
     * Callback function for admin_menu hook
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function admin_menu(){
        add_menu_page( 'Bot - Telegram', 'Bot - Telegram', 'manage_options', 'wpbottelegram-settings-page', array( $this, 'render_settings' ), 'dashicons-networking', '9' );

        if(class_exists('qcld_wb_Chatbot') && get_option( 'tg_disable_start_menu' ) != '1' ){
            add_submenu_page( 'wpbottelegram-settings-page', 'Menu Setup', 'Menu Setup', 'manage_options','qcld-chatbot-tg-menu', array($this, 'menu_setup') );
        }

    }


    function menu_setup(){
        include 'templates/menu.php';
    }

    /**
     * Register settings field
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function register_plugin_settings(){
        register_setting( 'qc-wpbottelegram-settings-group', 'tg_access_token' );
        register_setting( 'qc-wpbottelegram-settings-group', 'tg_language_command' );
        register_setting( 'qc-wpbottelegram-settings-group', 'tg_choose_language' );
        register_setting( 'qc-wpbottelegram-settings-group', 'tg_disable_start_menu' );
        
        
        if(isset($_POST['qc_wpbot_tg_menu_order'])){
			update_option('qc_wpbot_tg_menu_order', $_POST['qc_wpbot_tg_menu_order']);
		}

    }

    /**
     * Render settings page
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function render_settings(){
        include 'templates/settings.php';
    }

    public function webhookURL() {
        //return 'https://5154-192-140-253-97.ngrok.io/wpbot-pro/wp-json/wpbot/v2/telegram';
        return home_url().'/wp-json/'.WpbotTelegram_Webhook::$namespace.WpbotTelegram_Webhook::$route;
    }
    /**
     * Check Webhook URL is connected with telegram or not
     *
     * @return void
     */
    public function tg_status(){
        if( get_option( 'tg_access_token' ) && get_option( 'tg_access_token' ) != '' ){
            $response = wp_remote_get( 'https://api.telegram.org/bot'.get_option( 'tg_access_token' ).'/getWebhookInfo' );
            $response = wp_remote_retrieve_body($response);
            $response = json_decode( $response );
            if( $response->ok == 1 && $response->result->url == $this->webhookURL() ){
                echo 'Connected!';
            }else{
                echo 'Not Connected'.' <a href="'.admin_url( 'admin-post.php?action=qc_tg_connect' ).'" >Click to Connect</a>';
            }
        }else{
            echo 'Not Connected'.' <a href="'.admin_url( 'admin-post.php?action=qc_tg_connect' ).'" >Click to Connect</a>';
        }
    }

    /**
     * Connect webhook to telegram
     *
     * @return void
     */
    public function connect(){
        $url = $this->webhookURL();
        $response = wp_remote_get( 'https://api.telegram.org/bot'.get_option( 'tg_access_token' ).'/setWebhook?url='.$url );
        $response = wp_remote_retrieve_body($response);
        $response = json_decode( $response );
        wp_redirect( admin_url( 'admin.php?page=wpbottelegram-settings-page' ) );
        
    }

    public function render_lang_field(){

        $default = 'Choose a language from below';
        $key = 'tg_choose_language';
        if( function_exists( 'qcld_wpbotml' ) ){
            
            $languages = qcld_wpbotml()->languages;
            foreach( $languages as $language ){
    
                $option_val = get_option($key);
                if( $option_val && is_array( $option_val ) && array_key_exists( $language, $option_val ) ){
                    $value = $option_val[$language];
                }else{
                    $value = $default;
                }
    
            ?>

            <tr valign="top">
                <th scope="row">Choose a language - <?php echo qcld_wpbotml()->lanName( $language ); ?></th>
                <td>
                    <input type="text" name="tg_choose_language[<?php echo $language; ?>]" value="<?php echo $value; ?>" />
                    <i>Choose a language from below - <?php echo qcld_wpbotml()->lanName( $language ); ?></i>
                </td>
            </tr>
    
            <?php
            }

        } else {

            $option_val = get_option($key);
            if( $option_val && is_array( $option_val ) && array_key_exists( get_wpbot_locale(), $option_val ) ){
                $value = $option_val[get_wpbot_locale()];
            }else{
                $value = $default;
            }

            ?>

            <tr valign="top">
                <th scope="row">Choose a language</th>
                <td>
                    <input type="text" name="tg_choose_language[<?php echo get_wpbot_locale(); ?>]" value="<?php echo $value; ?>" />
                    <i>Choose a language from below.</i>
                </td>
            </tr>

            <?php
        }

    }

}

new WpbotTelegram_Menu();
