<?php

/**
 * WhatsApp Webhook Class
 * 
 * @since 1.0.0
 */
class Wpbot_WA_Webhook {

    /**
     * Namespace for rest API
     * 
     * @since 1.0.0
     *
     * @var string
     */
    public static $namespace = 'wpbot/v2';

    /**
     * Route for REST API
     * 
     * @since 1.0.0
     *
     * @var string
     */
    public static $route = '/whatsapp/';

    /**
     * Construction
     * 
     * @since 0.0.9
     * 
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
        
        register_rest_route( Wpbot_WA_Webhook::$namespace, Wpbot_WA_Webhook::$route, array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_request' ),
        ) );
        
    }

    /**
     * Handling webhook request
     * callback of wpbot/v2/telegram route
     * 
     * @since 1.0.0
     * 
     * @return null
     */
    public function handle_request(){

        //handle request
        $request = new Qcld_WA_Request();
        //return response
        new Qcld_WA_Response( $request );
    }
}

new Wpbot_WA_Webhook();