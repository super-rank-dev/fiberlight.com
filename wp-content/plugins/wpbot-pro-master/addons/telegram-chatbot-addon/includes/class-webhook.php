<?php

/**
 * Telegram Webhook Class
 */
class WpbotTelegram_Webhook {

    /**
     * Namespace for rest API
     *
     * @var string
     */
    public static $namespace = 'wpbot/v2';

    /**
     * Route for REST API
     *
     * @var string
     */
    public static $route = '/telegram/';

    /**
     * Construction
     * 
     * @since 0.0.9
     * @param null
     * @return null
     */
    public function __construct(){
        add_action( 'rest_api_init', array( $this, 'register_rest' ));
    }

    /**
     * Register rest route for telegram
     * Callback - rest_api_init
     * 
     * @since 0.0.9
     * 
     * @param null
     * 
     * @return null
     */
    public function register_rest(){
        
        register_rest_route( WpbotTelegram_Webhook::$namespace, WpbotTelegram_Webhook::$route, array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_request' ),
        ) );
        
    }

    /**
     * Handling webhook request
     * callback of wpbot/v2/telegram route
     */
    public function handle_request(){

        //handle request
        $request = new Qcld_Tg_Request();
        //return response
        new Qcld_Tg_Response( $request );
    }
}

new WpbotTelegram_Webhook();