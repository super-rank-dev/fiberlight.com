<?php 
/*
* @package Dialogflow Webhook by QuantumCloud 
* @Since 9.3.8
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
* Callback function for Webhook
* @Since 9.3.8
* You can write your script inside this callback function.
*/
function qcld_wpbot_dfwebhookcallback($request){

    // Authentication check
   if(qcld_validate_authorization_header()){

        //get all incoming requests
        $req = $request->get_params();
        //Intent name
        $intent = $req['queryResult']['intent']['displayName'];
        //parameters
        $parameters = $req['queryResult']['parameters'];

        //Start custom code section.
        // Write your fulfillment response in this block
        //==========================

        $json_reponse = '
        {
            "fulfillmentText": "This is from webhook_test response from webhook",
            "fulfillmentMessages": [
                {
                    "text": {
                        "text": [
                            "This is from webhook_test response from webhook"
                        ]
                    }
                }
            ]
        }';
        
        echo $json_reponse;

        //End custom code section
        //================

    // Please do not edit the below code.
   }else {
        wp_send_json(array('success' => false,
        'message' => 'Authorization failed.'));
    }

}