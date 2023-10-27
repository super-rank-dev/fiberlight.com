<?php

class Qcld_Tg_Response
{

    /**
     * Request
     *
     * @var object Qcld_Tg_Request
     */
    public $request = '';

    /**
     * Helper class
     *
     * @var object
     */
    public $helper = '';

    function __construct( Qcld_Tg_Request $request ) {
        $this->request = $request;
        $this->helper = new WPBot_Telegram_Helper( $this->request );
        $this->parse_request();
    }

    private function parse_request() {

        if ( $this->request->chatID !== null && $this->request->message !==null ) {

            //handle message
            $message = $this->request->message;

            //start menu
            if ( strtolower( $message ) == 'menu' || strtolower( $message ) == 'help' || strtolower( $message ) == 'start' || strtolower( $message ) == '/start' || strtolower( $message ) == strtolower( $this->helper->get_option( 'qlcd_wp_chatbot_sys_key_help' ) ) ) {
                $this->helper->clear_all_transient();
                $parameters = $this->helper->menu();
                $this->helper->send( 'sendMessage', $parameters );
                exit;
            }

            //check if language code
            
            if ( function_exists( 'qcld_wpbotml' ) ) {
                $all_lan = qcld_wpbotml()->helper->languages();
                if ( isset( $all_lan[$message] ) ) {
                    $this->helper->set_transient( '_tg_lang', $message );
                    $this->helper->clear_all_transient();
                    $parameters = $this->helper->menu();
                    $this->helper->send( 'sendMessage', $parameters );
                    exit;
                }
            }

            //Language switch
            if ( strtolower( $message ) == strtolower( $this->helper->get_option( 'tg_language_command' ) ) && function_exists( 'qcld_wpbotml' ) ) {
                $parameters = $this->helper->languages();
                $this->helper->send( 'sendMessage', $parameters );
                exit;
            }

            //faq response
            $all_faqs = maybe_unserialize( $this->helper->get_option('support_query') );
            if ( in_array( $this->request->event, $all_faqs ) ) {
                $parameters = $this->helper->faq( 'show_answer', $all_faqs );
                $this->helper->send( 'sendMessage', $parameters );
                exit;
            }

            // Send feedback, Email intent handleing step 2
            if ( $this->helper->get_transient( '_tg_feedback' ) && $this->helper->get_transient( '_tg_feedback' ) == 1 ) {
                if ( filter_var( $message, FILTER_VALIDATE_EMAIL ) ) {
                    $this->helper->set_transient( '_tg_feedback_email', $message );
                    $parameters = $this->helper->sendUsEmail( 2 );
                    $this->helper->send( 'sendMessage', $parameters );
                    exit;
                } else {
                    $parameters = $this->helper->sendUsEmail();
                    $this->helper->send( 'sendMessage', $parameters );
                    exit;
                }
            }

            // Send feedback, Email intent handleing step 3
            if( $this->helper->get_transient( '_tg_feedback' ) && $this->helper->get_transient( '_tg_feedback' ) == 2 ) {
                $this->helper->set_transient( '_tg_feedback_msg', $message );
                $parameters = $this->helper->sendUsEmail( 3 );
                $this->helper->send( 'sendMessage', $parameters );
                exit;
            }

            //phone intent second option
            if ( $this->helper->get_transient( '_tg_phone' ) && $this->helper->get_transient( '_tg_phone' ) == 1 ) {
                $parameters = $this->helper->callmeback( 2 );
                $this->helper->send( 'sendMessage', $parameters );
                exit;
            }

            // Email Subscription intent handleing
            if ( $this->helper->get_transient( '_tg_subscription' ) && $this->helper->get_transient( '_tg_subscription' ) == 1 ) {
                if ( filter_var( $message, FILTER_VALIDATE_EMAIL ) ) {
                    $parameters = $this->helper->emailSubscription( 2 );
                    $this->helper->send( 'sendMessage', $parameters );
                    exit;
                } else {
                    $parameters = $this->helper->emailSubscription();
                    $this->helper->send( 'sendMessage', $parameters );
                    exit;
                }
                
            }

            // Handling site search intent
            if ( $this->helper->get_transient( '_tg_sitesearch' ) && $this->helper->get_transient( '_tg_sitesearch' ) == 1 ) {

                $parameters = $this->helper->siteSearch( 2 );
                $this->helper->send( 'sendMessage', $parameters );
                exit;
                
            }

            //handle conversationl form
            if($this->helper->get_transient( '_tg_conversational_form') && $this->helper->get_transient( '_tg_conversational_form')!=''){
				qcld_tg_handle_cfb_next($message, $this->helper);exit;
			}

            //Handle Phone callback
            if ( strtolower( $message ) == strtolower( $this->helper->get_option( 'qlcd_wp_chatbot_support_phone' ) ) ) {
                $parameters = $this->helper->callmeback();
                $this->helper->send( 'sendMessage', $parameters );
                exit;
            }

            //code for faq
            if ( strtolower( $message ) == strtolower( $this->helper->get_option( 'qlcd_wp_chatbot_wildcard_support' ) ) || strtolower( $message ) == strtolower( $this->helper->get_option( 'qlcd_wp_chatbot_sys_key_support' ) ) ) {
                $parameters = $this->helper->faq( 'show_question' );
                $this->helper->send( 'sendMessage', $parameters );
                exit;
            }

            // Send Us email intent trigger when button click
            if ( strtolower( $message ) == strtolower( $this->helper->get_option( 'qlcd_wp_send_us_email' ) ) || strtolower( $message ) == strtolower( $this->helper->get_option( 'qlcd_wp_leave_feedback' ) ) ) {
                $parameters = $this->helper->sendUsEmail();
                $this->helper->send( 'sendMessage', $parameters );
                exit;
            }

            // Email subscription intent
            if ( strtolower( $message ) == strtolower( $this->helper->get_option( 'qlcd_wp_email_subscription' ) ) ) {
				$parameters = $this->helper->emailSubscription();
                $this->helper->send( 'sendMessage', $parameters );
                exit;
            }

            //Site search intent
            if ( strtolower( $message ) == strtolower( $this->helper->get_option( 'qlcd_wp_site_search' ) != '' ? $this->helper->get_option( 'qlcd_wp_site_search' ) : 'Site Search' ) ) {
				
                $parameters = $this->helper->siteSearch();
                $this->helper->send( 'sendMessage', $parameters );
                exit;

            }

            //STR Categories intent
            if ( strtolower( $message ) == strtolower( $this->helper->get_option( 'qlcd_wp_str_category' ) != '' ? $this->helper->get_option( 'qlcd_wp_str_category' ) : 'STR Categories' ) ) {
				
                $parameters = $this->helper->strCategories();
                $this->helper->send( 'sendMessage', $parameters );
                exit;

            }

            //STR Category if matched
            if ( in_array( strtolower( $message ), array_map( 'strtolower', get_str_categories() ) ) ) {
                $parameters = $this->helper->strCategory();
                $this->helper->send( 'sendMessage', $parameters );
                exit;
            }

            //Find STR Responses and send
            $this->helper->findStrResponses();
            //Find inopen AI
            if($this->helper->get_option( 'ai_enabled' ) == 1){
                $prompts = "Q:". strtolower( $message ) ."\nA:";
                $max_tokens =  (int)get_option( 'openai_max_tokens');
                $temp = (float)get_option( 'openai_temperature');
                $frequency_penalty = (float)get_option( 'frequency_penalty');
                $presence_penalty = (float)get_option( 'presence_penalty');
                $request_body = [
                    "prompt" => $prompts ,
                    "model" => 'text-davinci-003',
                    "max_tokens" => $max_tokens,
                    "temperature" =>  $temp,
                    "top_p" => 1,
                    "presence_penalty" => $presence_penalty,
                    "frequency_penalty"=> $frequency_penalty,
                    "best_of"=> 1,
                    "stream" => false,
                ];
                $postFields = json_encode($request_body);
                $url = "https://api.openai.com/v1/completions";
                $apt_key = "Authorization: Bearer ". $this->helper->get_option('open_ai_api_key');
            
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                
                $headers = array(
                "Content-Type: application/json",
                $apt_key ,
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                $response = curl_exec($curl);
                curl_close($curl);
                $mess = json_decode($response);
                $responses = $mess->choices[0]->text;
                $parameters = array(
                    'chat_id' => $this->request->chatID,
                //    'reply_markup' => $encodedKeyboard,
                    'text' => $responses,
                    "parseMode" => "html"
                );
                $this->helper->send( 'sendMessage', $parameters );
            }
            //Conversational form builder
            if ( class_exists('qcld_wb_Chatbot') ) {
                $ccommands = array_map( 'qc_tg_nestedLowercase', qc_get_formbuilder_form_commands() );
                $cformid = qc_get_formbuilder_form_ids();
                $cforms = array_map( 'qc_tg_nestedLowercase', qc_get_formbuilder_forms() );
                $get_formidby_keyword = qc_tg_findformid( $ccommands, $cforms, $cformid, strtolower( $message ) );
                if ( ! empty( $cformid ) && in_array( $get_formidby_keyword, $cformid ) ) {
                    
                    $this->helper->handle_formbuilder_response( $get_formidby_keyword );
                    
                    exit;
                }
            }

            if( $this->helper->get_option( 'enable_wp_chatbot_dailogflow' ) && $this->helper->get_option( 'enable_wp_chatbot_dailogflow' ) == 1 && $this->helper->get_option( 'wp_chatbot_df_api' ) && $this->helper->get_option( 'wp_chatbot_df_api' )=='v2' ){
				//get reply for the msg from df
				$this->helper->handle_dialogflow();
				
			}

        }
    }

    
}
