<?php

class Qcld_Tg_Request {

    /**
     * Chat ID
     *
     * @var string
     */
    public $chatID = null;

    /**
     * Message
     *
     * @var string
     */
    public $message = null;

    /**
     * First Name
     *
     * @var [type]
     */
    public $first_name = null;

    /**
     * last Name
     */
    public $last_name = null;

    /**
     * Language Code
     *
     * @var [type]
     */
    public $language_code = null;

    /**
     * Is button clicked
     *
     * @var boolean
     */
    public $buttonclick = false;

    /**
     * Click event
     *
     * @var string
     */
    public $event = null;

    /**
     * Construction
     * 
     * @since 0.0.9
     * @param null
     * @return null
     */
    public function __construct(){

        $update = file_get_contents('php://input');
        $update = json_decode($update, true);
        if( isset( $update['callback_query'] ) ){

            $this->buttonclick = true;
            $this->chatID = isset( $update['callback_query']["from"]["id"] ) ? $update['callback_query']["from"]["id"] : null;
            $this->first_name = isset( $update['callback_query']["from"]["first_name"] )? $update['callback_query']["from"]["first_name"] : null;
            $this->last_name = isset( $update['callback_query']["from"]["last_name"] ) ? $update['callback_query']["from"]["last_name"] : null;
            $this->language_code = isset( $update['callback_query']["from"]["language_code"] ) ? $update['callback_query']["from"]["language_code"] : null;
            $this->message = isset( $update['callback_query']["data"] ) ? $update['callback_query']["data"] : null;
            $this->event = isset( $update['callback_query']["data"] ) ? $update['callback_query']["data"] : null;

        }else{

            $this->chatID = isset( $update["message"]["from"]["id"] ) ? $update["message"]["from"]["id"] : null;
            $this->first_name = isset( $update["message"]["from"]["first_name"] ) ? $update["message"]["from"]["first_name"] : null;
            $this->last_name = isset( $update["message"]["from"]["last_name"] ) ? $update["message"]["from"]["last_name"] : null;
            $this->language_code = isset( $update["message"]["from"]["language_code"] ) ? $update["message"]["from"]["language_code"] : null;
            $this->message = isset( $update["message"]["text"] ) ? $update["message"]["text"] : null;

        }
        
    }

}