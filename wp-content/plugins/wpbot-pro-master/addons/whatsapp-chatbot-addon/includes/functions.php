<?php 

use Twilio\Rest\Client;

/**
 * Get current language
 *
 * @return string
 */
function qcld_wa_currentLanguage() {
    $lancode = get_wpbot_locale();
    return $lancode;
}

/**
 * Get Option
 *
 * @param string $key
 * 
 * @return array|string $option
 */
function qcld_wa_get_option($key) {
    $options = get_option( $key );
    
    if( $options ){
        $options = maybe_unserialize( $options );
        if( is_array( $options ) ){
            if ( isset( $options[qcld_wa_currentLanguage()] ) ) {

                return $options[qcld_wa_currentLanguage()];

            } else {
                return $options;
            }
        } else {
            return $options;
        }

    } else {
        return $options;
    }
}

/**
 * Remove all transient that are being set during conversation
 *
 * @return void
 */
function qcld_wa_clear_all_transient( $waid ) {

    qcld_wa_delete_transient( $waid . '_start_menu' );

    qcld_wa_delete_transient( $waid . '_wa_feedback' );
    qcld_wa_delete_transient( $waid . '_wa_feedback_email' );
    qcld_wa_delete_transient( $waid . '_wa_feedback_msg' );
    qcld_wa_delete_transient( $waid . '_wa_phone' );
    qcld_wa_delete_transient( $waid . '_wa_sitesearch' );
    qcld_wa_delete_transient( $waid . '_wa_subscription' );
    qcld_wa_delete_transient( $waid . '_wa_conversational_field_entry' );
    qcld_wa_delete_transient( $waid . '_wa_conversational_field_id' );
    qcld_wa_delete_transient( $waid . '_wa_conversational_form_id' );
    qcld_wa_delete_transient( $waid . '_wa_conversational_form' );
    qcld_wa_delete_transient( $waid . '_faq_menu' );
    qcld_wa_delete_transient( $waid . '_wa_faq' );
    qcld_wa_delete_transient( $waid . '_wa_str_buttons' );
    qcld_wa_delete_transient( $waid . '_wa_cf_buttons' );
    qcld_wa_delete_transient( $waid . '_wa_df_buttons' );
    qcld_wa_delete_transient( $waid . '_wa_product_search' );
    qcld_wa_delete_transient( $waid . '_wa_order_status' );
    qcld_wa_delete_transient( $waid . '_wa_order_status_email' );
    qcld_wa_delete_transient( $waid . '_wa_product_showing' );
    qcld_wa_delete_transient( $waid . '_wa_product_buttons' );
    qcld_wa_delete_transient( $waid . '_wa_order_email' );
    qcld_wa_delete_transient( $waid . '_wa_order_product' );
    

}

/**
 * Check if number
 * 
 * @since 1.0.0
 * 
 * @param string $string
 *
 * @return bool
 */
function qcld_wa_is_number( $string ) {
    return is_numeric( $string );
}

/**
 * Delete transient
 * 
 * @since 1.0.0
 *
 * @param string $key
 * @return void
 */
function qcld_wa_delete_transient( $key ) {
    delete_transient( $key );
}

/**
 * Get all menu items
 * 
 * @since 1.0.0
 *
 * @return array
 */
function qcld_wa_getmenuitems() {
    
    $cache = array();
    $cache_key = '_menu_cache_key';

    if ( isset( $cache[ $cache_key ] ) && ! empty( $cache[ $cache_key ] ) ) {
        return $cache[ $cache_key ];
    }
    
    $phonetextarray = maybe_unserialize( qcld_wa_get_option( 'qlcd_wp_chatbot_support_phone' ) );
    $phonetxt = ( qcld_wa_get_option( 'qlcd_wp_chatbot_support_phone' ) != '' ? qcld_wa_get_option( 'qlcd_wp_chatbot_support_phone' ) : 'Leave your number. We will call you back!' );

    $custom_intents_array = array_filter( maybe_unserialize( qcld_wa_get_option( 'qlcd_wp_custon_intent_label' ) ) );
    
    $all_faqs = array(
    
        ( qcld_wa_get_option( 'qlcd_wp_email_subscription' ) != '' ? qcld_wa_get_option( 'qlcd_wp_email_subscription' ) : 'Email Subscription' ),
        ( qcld_wa_get_option( 'qlcd_wp_chatbot_sys_key_support' ) != '' ? strtoupper( qcld_wa_get_option( 'qlcd_wp_chatbot_sys_key_support' ) ) : 'FAQ' ),
        ( qcld_wa_get_option( 'qlcd_wp_send_us_email' ) != '' ? qcld_wa_get_option( 'qlcd_wp_send_us_email' ) : 'Send Us Email' ),
        ( qcld_wa_get_option( 'qlcd_wp_leave_feedback' ) != '' ? qcld_wa_get_option( 'qlcd_wp_leave_feedback' ) : 'Leave a Feedback' ),
        ( qcld_wa_get_option( 'qlcd_wp_site_search' )!='' ? qcld_wa_get_option( 'qlcd_wp_site_search' ) : 'Site Search' ),
        $phonetxt
    );
    
    $all_faqs = array_merge($all_faqs, $custom_intents_array);
   
    if ( qcld_wa_get_option( 'qc_wpbot_wa_menu_order' ) && qcld_wa_get_option( 'qc_wpbot_wa_menu_order' ) != '' && qcld_wa_get_option( 'wa_disable_start_menu' ) != '1' ) {
        $startmenu = stripslashes( qcld_wa_get_option( 'qc_wpbot_wa_menu_order' ) );
        preg_match_all( "/\<\w[^<>]*?\>([^<>]+?\<\/\w+?\>)?|\<\/\w+?\>/i", $startmenu, $matches );
        $newArray = array_map( function( $v ){
            return trim( strip_tags( $v ) );
        }, $matches[0] );
        $newArray = array_filter( $newArray );
        if ( ! empty( $newArray ) ){
            $all_faqs = $newArray;
        }
    } else {
        if ( qcld_wa_get_option( 'qc_wpbot_menu_order' ) && qcld_wa_get_option( 'qc_wpbot_menu_order' ) != '' ) {
            $startmenu = stripslashes( qcld_wa_get_option( 'qc_wpbot_menu_order' ) );
            preg_match_all( "/\<\w[^<>]*?\>([^<>]+?\<\/\w+?\>)?|\<\/\w+?\>/i", $startmenu, $matches );
            $newArray = array_map( function( $v ) {
                return trim( strip_tags( $v ) );
            }, $matches[0] );
            $newArray = array_filter( $newArray );
            if ( ! empty( $newArray ) ) {
                $all_faqs = $newArray;
            }
        }
    }
    $cache[ $cache_key ] = apply_filters( 'qcld_wa_start_menu', array_unique( $all_faqs ) ) ;
    return $cache[ $cache_key ];
}

/**
 * Set Transient
 *
 * @param string $key
 * @param mixed $value
 * @return void
 */
function qcld_wa_set_transient( $key, $value ) {
    set_transient( $key, $value, 12 * HOUR_IN_SECONDS );
}

/**
 * Get transient
 *
 * @param string $transient
 * @return void
 */
function qcld_wa_get_transient( $key ) {
    return get_transient( $key );
}

/**
 * Send Messages
 *
 * @param string $content
 * @param string $to
 * @return string $message_sid
 */
function qcld_wa_send_message( $content, $to ) {

    // Your Account Sid and Auth Token from twilio.com/console
    $sid    = get_option( 'wa_account_sid' );
    $token  = get_option( 'wa_auth_token' );

    $from = 'whatsapp:' . get_option( 'wa_whatsapp_number' );

    $twilio = new Client($sid, $token);

    $message = $twilio->messages
       ->create( $to ,
           [
               "body" => $content,
               "from" => $from
           ]
       );
    
    return ($message->sid);
}

/**
 * Convert command to number
 *
 * @param array $items
 * 
 * @return string
 */
function qcld_wa_convert_command_to_number( $items ) {
    $text = '';
    if ( ! empty( $items ) ) {
        foreach ( $items as $key=>$item ) {
            $text .= ($key + 1). '. ' . $item . "\n";
        }
    }
    return $text;
}

/**
 * Show start menu
 * 
 * @since 1.0.0
 *
 * @param Qcld_WA_Request $request
 * @return void
 */
function qcld_wa_showstartmenu( Qcld_WA_Request $request ) {

    qcld_wa_clear_all_transient( $request->getWaId() );

    $msgtextoutput = 'I am here to find what you need. What are you looking for?';
    $default_msgs = qcld_wa_get_option( 'qlcd_wp_chatbot_wildcard_msg' );
    if( $default_msgs != '' ){
        $default_msgs = array_filter( maybe_unserialize( $default_msgs ) );
        if ( ! empty( $default_msgs ) ) {
            $msgtextoutput = $default_msgs[array_rand( $default_msgs )];
        }
    }

    $menu_items = qcld_wa_getmenuitems();
    
    if ( !empty( $menu_items ) ) {
        $msgtextoutput .= "\n";
        $msgtextoutput .= qcld_wa_convert_command_to_number( $menu_items );
    }

    $msgtextoutput = apply_filters( 'qcld_wa_modify_content', $msgtextoutput, $request );

    $response = qcld_wa_send_message( $msgtextoutput, $request->getFrom() );
    if ( $response ) {
        qcld_wa_set_transient( $request->getWaId() . '_start_menu', 1 );
    }
    exit;
}

/**
 * Email Subscription intent
 * 
 * @since 1.0.0
 * 
 * @param Qcld_WA_Request $request
 *
 * @param integer $step
 * 
 * @return null
 */
function qcld_wa_emailsubscription( Qcld_WA_Request $request, $step = 1 ) {
    global $wpdb;

    if ( $step == 1 ) {

        qcld_wa_set_transient( $request->getWaId() . '_wa_subscription', 1 );
        $texts = maybe_unserialize( qcld_wa_get_option( 'qlcd_wp_chatbot_asking_email' ) );
        $text = $texts[array_rand( $texts )];

    } elseif ( $step == 2 ) {

        qcld_wa_delete_transient( $request->getWaId() . '_wa_subscription' );
        $table              = $wpdb->prefix.'wpbot_subscription';
        $name               = $request->getProfileName();
        $email              = $request->getBody();
        $url                = '';
        $user_agent         = '';
        $response           = array();
        $response['status'] = 'fail';
        $query = $wpdb->prepare( 
            "select * from $table where 1 and email = %s", 
            $email
        );
        
        $email_exists = $wpdb->get_row( $query );
        if ( empty( $email_exists ) ) {
        
            $wpdb->query( $wpdb->prepare( " INSERT INTO $table ( date, name, email, url, user_agent ) VALUES ( %s, %s, %s, %s, %s ) ", array( date('Y-m-d H:i:s'), $name, $email, $url, $user_agent ) ) );
            $response['status'] = 'success';
            $texts              = maybe_unserialize( qcld_wa_get_option( 'qlcd_wp_email_subscription_success' ) );
            $text               = $texts[array_rand( $texts )];
        
        }else{
            $texts              = maybe_unserialize( qcld_wa_get_option( 'qlcd_wp_email_already_subscribe' ) );
            $text               = $texts[array_rand( $texts )];
        }
    }

    $text = apply_filters( 'qcld_wa_modify_content', $text, $request );

    $response = qcld_wa_send_message( $text, $request->getFrom() );
    exit;

}


/**
 * Send Us Email, Leave A Feedback intent
 * 
 * @since 1.0.0
 *
 * @param Qcld_WA_Request $request
 * 
 * @param integer $step
 * 
 * @return null
 */
function qcld_wa_sendusemail( Qcld_WA_Request $request, $step = 1 ) {

    if ( $step == 1 ) {

        qcld_wa_set_transient( $request->getWaId() . '_wa_feedback', 1 );
        $texts = maybe_unserialize( qcld_wa_get_option( 'qlcd_wp_chatbot_asking_email' ) );
        $text = $texts[array_rand( $texts )];

    } elseif ( $step == 2 ) {

        qcld_wa_set_transient( $request->getWaId() . '_wa_feedback', 2);
        $texts = maybe_unserialize( qcld_wa_get_option( 'qlcd_wp_chatbot_asking_msg' ) );
        $text = $texts[array_rand( $texts )];

    } elseif ( $step == 3 ) {

        qcld_wa_delete_transient( $request->getWaId() . '_wa_feedback' );
        $name                   = $request->getProfileName();
        $email                  = qcld_wa_get_transient( $request->getWaId() . '_wa_feedback_email' );
        $message                = qcld_wa_get_transient( $request->getWaId() . '_wa_feedback_msg' );
        $subject                = 'Feedback from WPBot by Client';

        //Extract Domain
        $url                    = get_site_url();
        $url                    = parse_url( $url );
        $domain                 = $url['host'];
        $admin_email            = qcld_wa_get_option( 'admin_email' );
        $toEmail                = qcld_wa_get_option( 'qlcd_wp_chatbot_admin_email' ) != '' ? qcld_wa_get_option( 'qlcd_wp_chatbot_admin_email' ) : $admin_email;
        $fromEmail              = "wordpress@" . $domain;
        //Starting messaging and status.
        $response['status']     = 'fail';
        $response['message']    = esc_html( str_replace( '\\', '', qcld_wa_get_option( 'qlcd_wp_chatbot_email_fail' ) ) );
    
        //build email body
        $bodyContent            = "";
        $bodyContent           .= '<p><strong>' . esc_html__( 'Feedback Details', 'wpchatbot' ) . ':</strong></p><hr>';
        $bodyContent           .= '<p>' . esc_html__( 'Name', 'wpfb' ) . ' : ' . esc_html( $name ) . '</p>';
        $bodyContent           .= '<p>' . esc_html__( 'Email', 'wpfb' ) . ' : ' . esc_html( $email ) . '</p>';
        $bodyContent           .= '<p>' . esc_html__( 'Message', 'wpfb' ) . ' : ' . esc_html( $message ) . '</p>';
        
            
        $bodyContent           .= '<p>' . esc_html__( 'Mail Generated on', 'wpchatbot' ) . ': ' . date( 'F j, Y, g:i a' ) . '</p>';
        $to                     = $toEmail;
        $body                   = $bodyContent;
    
        $headers                = array();
        $headers[]              = 'Content-Type: text/html; charset=UTF-8';
        $headers[]              = 'From: ' . esc_html( $name ) . ' <' . esc_html( $fromEmail ) . '>';
    
        wp_mail( $to, $subject, $body, $headers );
        qcld_wa_delete_transient( $request->getWaId() . '_wa_feedback_email' );
        qcld_wa_delete_transient( $request->getWaId() . '_wa_feedback_msg' );
        $text = ( qcld_wa_get_option( 'qlcd_wp_chatbot_email_sent' ) != '' ? qcld_wa_get_option( 'qlcd_wp_chatbot_email_sent' ) : 'Your email was sent successfully. Thanks!' );

    }

    $text = apply_filters( 'qcld_wa_modify_content', $text, $request );

    $response = qcld_wa_send_message( $text, $request->getFrom() );
    exit;
   
}

/**
 * Leave your number. We will call you back! - Intent
 * Multi step function
 * 
 * @since 1.0.0
 * 
 * @param Qcld_WA_Request $request
 * 
 * @param int $step [1, 2]
 * 
 * @return array
 */
function qcld_wa_callmeback( Qcld_WA_Request $request, $step = 1 ) {

    if ( $step == 1 ) {
        qcld_wa_set_transient( $request->getWaId() . '_wa_phone', 1 );
        $texts = maybe_unserialize( qcld_wa_get_option( 'qlcd_wp_chatbot_asking_phone' ) );
        $text = $texts[array_rand($texts)];
        
    } elseif ( $step == 2 ) {
        qcld_wa_delete_transient( $request->getWaId() . '_wa_phone' );
        $text = ( qcld_wa_get_option('qlcd_wp_chatbot_phone_sent' ) != '' ? qcld_wa_get_option('qlcd_wp_chatbot_phone_sent') : 'Thanks for your phone number. We will call you ASAP!' );
       
    }
    $text = apply_filters( 'qcld_wa_modify_content', $text, $request );
    $response = qcld_wa_send_message( $text, $request->getFrom() );
    exit;

}

/**
 * Handle faq responses
 * 
 * @param Qcld_WA_Request $request
 *
 * @param [type] $key
 * @param array $all_faqs
 * @return void
 */
function qcld_wa_faq( Qcld_WA_Request $request, $key, $answer = "" ) {

    $all_faqs = maybe_unserialize( qcld_wa_get_option( 'support_query' ));

    if ( $key == 'show_question' ){
        $faqjson = '';
        
        $welcomefaqs = maybe_unserialize( qcld_wa_get_option( 'qlcd_wp_chatbot_support_welcome' ) );
        $welcomefaq = $welcomefaqs[array_rand( $welcomefaqs )];

        $text = apply_filters( 'qcld_wa_modify_content', $welcomefaq, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );

        if ( $response ) {
            $faqtext = qcld_wa_convert_command_to_number( $all_faqs );

            $faqtext = apply_filters( 'qcld_wa_modify_content', $faqtext, $request );
            $response = qcld_wa_send_message( $faqtext, $request->getFrom() );
            if ( $response ) {
                qcld_wa_set_transient( $request->getWaId() . '_faq_menu', 1 );
                qcld_wa_set_transient( $request->getWaId() . '_wa_faq', 1 );
            }

        }
        
    } else {

        
        $faqkey = array_search ( $answer , $all_faqs);
        $faqans = maybe_unserialize( qcld_wa_get_option( 'support_ans' ) );

        $faqans = apply_filters( 'qcld_wa_modify_content', $faqans[$faqkey], $request );
        $response = qcld_wa_send_message( $faqans, $request->getFrom() );
        if ( $response ) {
            qcld_wa_delete_transient( $request->getWaId() . '_faq_menu' );
            qcld_wa_delete_transient( $request->getWaId() . '_wa_faq' );
        }
        exit;

    }
}

/**
 * Site Search function
 * 
 * @since 1.0.0
 *
 * @param Qcld_WA_Request $request
 * @param integer $step
 * @return void
 */
function qcld_wa_sitesearch( Qcld_WA_Request $request, $step = 1 ) {

    if ( $step == 1 ) {

        qcld_wa_set_transient( $request->getWaId() . '_wa_sitesearch', 1 );
        $texts  = maybe_unserialize( qcld_wa_get_option( 'qlcd_wp_chatbot_search_keyword' ) );
        $text   = $texts[array_rand( $texts )];

    } elseif ( $step == 2 ) {

        qcld_wa_delete_transient( $request->getWaId() . '_wa_sitesearch' );
        $sitesearchresult = qcld_wpbo_search_site_fb( $request->getBody() );

        if ( $sitesearchresult['status'] == 'success' ) {

            $results = $sitesearchresult['results'];
            $text = qcld_wa_site_search_result( $results );

            $text = apply_filters( 'qcld_wa_modify_content', $text, $request );
            $response = qcld_wa_send_message( $text, $request->getFrom() );
            if ( $response ) {
                qcld_wa_delete_transient( $request->getWaId() . '_faq_menu' );
                qcld_wa_delete_transient( $request->getWaId() . '_wa_faq' );
            }

        } else {

            $text = qcld_wa_get_option( 'qlcd_wp_chatbot_dialogflow_defualt_reply' );

            $text = apply_filters( 'qcld_wa_modify_content', $text, $request );
            $response = qcld_wa_send_message( $text, $request->getFrom() );
            exit;

        }

    }

    $text = apply_filters( 'qcld_wa_modify_content', $text, $request );
    $response = qcld_wa_send_message( $text, $request->getFrom() );
    exit;

}

/**
 * format site search result for whatsapp
 * 
 * @since 1.0.0
 *
 * @param array $results
 * 
 * @return string
 */
function qcld_wa_site_search_result( $results ) {
    $text = '';
    foreach ( $results as $result ) {
        $text .= $result['title'].' - ' . $result['link']."\n";
    }
    return $text;
}


/**
 * str to lower recursively
 * 
 * @since 1.0.0
 *
 * @param string $value
 * @return string
 */
function qc_wa_nestedLowercase($value) {
    if (is_array($value)) {
        return array_map('qc_wa_nestedLowercase', $value);
    }
    return strtolower($value);
}


/**
 * find conversational form ID
 *
 * @param [type] $ccommands
 * @param [type] $cforms
 * @param [type] $cformid
 * @param [type] $message
 * @return void
 */
function qc_wa_findformid( $ccommands, $cforms, $cformid, $message ) {
	
	$gformid = 'None';
	
	if(!empty($ccommands)){
		
		foreach($ccommands as $key=>$val){
			
			if (in_array($message, $val)){
				return $cformid[$key];
			}
			
		}
		
	}
	if(!empty($cforms)){
		
		foreach($cforms as $key=>$val){
			if($val==$message){
				return $cformid[$key];
			}
		}
		
	}
	return $gformid;
}

/**
 * Get form first field by id
 *
 * @param int $formid
 * @param int $chatid
 * @return void
 */
function qcwpbot_wa_get_form($formid, $sender){
    global $wpdb;

    $formid = sanitize_text_field($formid);
    $session = sanitize_text_field($sender);

    $result = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_forms where form_id='".$formid."' and type='primary'");

    $form = maybe_unserialize($result->config);
    qcbot_conv_cookies_data_delete( $formid.'_'.$session.'_data' );
    qcbot_conv_cookies( $formid.'_'.$session, json_encode( $result ) );
    $fields = $form['fields'];
    //print_r($form['layout_grid']['fields']);exit;
    if(isset($form['layout_grid']['fields']) && !empty($form['layout_grid']['fields'])){
        
        $firstfield = qc_get_first_field($form['layout_grid']['fields']);
        $field = $fields[$firstfield];
        return $field;
    }
    
}

/**
 * Handle form builder response
 * 
 * @param Qcld_WA_Request $request
 * 
 * @param int $formid
 *
 * @return void
 */
function qcld_wa_handle_formbuilder_response( Qcld_WA_Request $request, $get_formidby_keyword ) {
    
    qcld_wa_set_transient( $request->getWaId() . '_wa_conversational_form', 'active' );
    qcld_wa_set_transient( $request->getWaId() . '_wa_conversational_form_id', $get_formidby_keyword);
    
    $formresponse = qcwpbot_wa_get_form( $get_formidby_keyword, $request->getWaId() );
    
    $fieldid = $formresponse['ID'];
    $formtype = $formresponse['type'];
    $formlabel = $formresponse['label'];
    qcld_wa_set_transient( $request->getWaId() . '_wa_conversational_field_id', $fieldid );
    qcld_wa_set_transient( $request->getWaId() . '_wa_conversational_field_entry', 0 );
    
    if($formtype=='dropdown' || $formtype=='checkbox'){
        
        $fieldoptions = $formresponse['config']['option'];
        $all_faqs = array();
        foreach($fieldoptions as $fieldoption){
            $all_faqs[] = $fieldoption['value'];
        }

        $formlabel .= "\n";
        $formlabel .= qcld_wa_convert_command_to_number( $all_faqs );
        qcld_wa_set_transient( $request->getWaId() . '_wa_cf_buttons', $all_faqs );
        $text = apply_filters( 'qcld_wa_modify_content', $formlabel, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );
        exit;

    }elseif($formtype=='html'){

        $formlabel = $formresponse['config']['default'];

        $text = apply_filters( 'qcld_wa_modify_content', $formlabel, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );
        if ( $response ) {
            qcld_wa_handle_cfb_next( $request, '' );
        }
        
    }else{

        $text = apply_filters( 'qcld_wa_modify_content', $formlabel, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );
        exit;
        
    }

}


/**
 * Handle next field
 * 
 * @param Qcld_WA_Request $request
 *
 * @param string $answer
 * 
 * @return void
 */
function qcld_wa_handle_cfb_next( Qcld_WA_Request $request, $answer='' ) {
	
	$formid = qcld_wa_get_transient( $request->getWaId() . '_wa_conversational_form_id' );
	$fieldid = qcld_wa_get_transient( $request->getWaId() . '_wa_conversational_field_id' );
	$entry = qcld_wa_get_transient( $request->getWaId() . '_wa_conversational_field_entry' );
	
	$formresponse = qcwpbot_capture_form_value_wa( $request, $formid, $fieldid, $answer, $entry );
	
	if( $answer != '' ){
		$ccommands = array_map( 'qc_wa_nestedLowercase', qc_get_formbuilder_form_commands() );
		$cformid = qc_get_formbuilder_form_ids();
		$cforms = array_map('qc_wa_nestedLowercase', qc_get_formbuilder_forms());
		$get_formidby_keyword = qc_wa_findformid($ccommands, $cforms, $cformid, strtolower($answer));
		if(!empty($cformid) && in_array($get_formidby_keyword, $cformid)){
			qcld_wa_delete_transient( $request->getWaId() . '_wa_conversational_field_entry' );
			qcld_wa_delete_transient( $request->getWaId() . '_wa_conversational_field_id' );
			qcld_wa_delete_transient( $request->getWaId() . '_wa_conversational_form_id' );
			qcld_wa_delete_transient( $request->getWaId() . '_wa_conversational_form' );
            qcld_wa_handle_formbuilder_response( $request, $get_formidby_keyword );
			exit;
		}
	}

	if($formresponse['status']=='incomplete'){

		qcld_wa_set_transient( $request->getWaId() . '_wa_conversational_field_entry', $formresponse['entry']);
		qcld_wa_set_transient( $request->getWaId() . '_wa_conversational_field_id', $formresponse['ID']);
		
		$formtype = $formresponse['type'];
		$formlabel = $formresponse['label'];
		
		if($formtype=='dropdown' || $formtype=='checkbox'){			
			$fieldoptions = $formresponse['config']['option'];
			$all_faqs = array();
			foreach($fieldoptions as $fieldoption){
				$all_faqs[] = $fieldoption['value'];
			}
			
			$formlabel .= "\n";
            $formlabel .= qcld_wa_convert_command_to_number( $all_faqs );
            qcld_wa_set_transient( $request->getWaId() . '_wa_cf_buttons', $all_faqs );
            $text = apply_filters( 'qcld_wa_modify_content', $formlabel, $request );
            $response = qcld_wa_send_message( $text, $request->getFrom() );
            exit;
			
		}elseif($formtype=='html'){

			$formlabel = $formresponse['config']['default'];
			$text = apply_filters( 'qcld_wa_modify_content', $formlabel, $request );
            $response = qcld_wa_send_message( $text, $request->getFrom() );
            if ( $response ) {
                qcld_wa_handle_cfb_next( $request, '' );
            }
			
		}elseif($formtype=='calculation'){
			
			$formlabel = $formresponse['calresult'];

			$text = apply_filters( 'qcld_wa_modify_content', $formlabel, $request );
            $response = qcld_wa_send_message( $text, $request->getFrom() );
            if ( $response ) {
                qcld_wa_handle_cfb_next( $request, $formresponse['calvalue'] );
            }
			
		}elseif($formtype=='hidden'){

            qcld_wa_handle_cfb_next( $request, $formresponse['config']['default'] );

			
		}else{
			
            $text = apply_filters( 'qcld_wa_modify_content', $formlabel, $request );
            $response = qcld_wa_send_message( $text, $request->getFrom() );
            exit;
		}
		
		
	}else{
		qcld_wa_delete_transient( $request->getWaId() . '_wa_conversational_field_entry');
		qcld_wa_delete_transient( $request->getWaId() . '_wa_conversational_field_id');
		qcld_wa_delete_transient( $request->getWaId() . '_wa_conversational_form_id');
		qcld_wa_delete_transient( $request->getWaId() . '_wa_conversational_form');
		exit;
	}
	
}

/**
 * Capture form value
 *
 * @param Qcld_WA_Request $request
 * @param string $formid
 * @param int $fieldid
 * @param mixed $answer
 * @param int $entry
 * 
 * @return void
 */
function qcwpbot_capture_form_value_wa(Qcld_WA_Request $request, $formid, $fieldid, $answer, $entry ){
    global $wpdb;

    $formid = sanitize_text_field($formid);
    $fieldid = sanitize_text_field($fieldid);
    $answer = $answer;
    $entry = sanitize_text_field($entry);


    /*
    if($entry==0){
        $wpdb->insert(
            $wpdb->prefix."wfb_form_entries",
            array(
                'datestamp'  => current_time( 'mysql' ),
                'user_id'   => 0,
                'form_id'	=> $formid,
                'status'	=> 'active'
            )
        );

        $entry = $wpdb->insert_id;
    }
    */
    

    $result = qcbot_conv_cookies_get( $formid . '_' . $request->getWaId() );
    if( ! $result || empty( $result ) ){
        $result = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_forms where form_id='".$formid."' and type='primary'");
    }
    $form = unserialize($result->config);
    
    $processors = (isset($form['processors'])?$form['processors']:array());
    
    $mailer = (isset($form['mailer'])?$form['mailer']:array());
    
    $variables = isset($form['variables'])?$form['variables']:array();

    $fieldetails = qc_get_details_by_fieldid_wa($form, $fieldid);
    
    if($answer!=''){
        $data = array();
        if($fieldetails['type']=='file'){
            
            $answers = explode(',', $answer);
            
            foreach($answers as $answer){
                $data[] = array(
                    'entry_id'  => $entry,
                    'field_id'   => $fieldid,
                    'slug'	=> (isset($fieldetails['slug'])?$fieldetails['slug']:''),
                    'value'	=> stripslashes($answer)
                );
            }
            qcbot_conv_cookies_data_set( $formid.'_'.$request->getWaId().'_data', $data );
        }else{
            $data[] = array(
                'entry_id'  => $entry,
                'field_id'   => $fieldid,
                'slug'	=> (isset($fieldetails['slug'])?$fieldetails['slug']:''),
                'value'	=> stripslashes($answer)
            );
            qcbot_conv_cookies_data_set( $formid.'_'.$request->getWaId().'_data', $data );
        }
        
    }
    $fields = $form['fields'];
    $conditions = array();
    if(isset($form['conditional_groups']['conditions'])){
        $conditions = $form['conditional_groups']['conditions'];
    }
    
    
    if(isset($form['layout_grid']['fields']) && !empty($form['layout_grid']['fields'])){
        
        $nextfield = qc_get_next_field($form, $fieldid, $entry, $request->getWaId());
        
        if($nextfield!='none' && $nextfield!='' && !empty($fields[$nextfield])){
            
            $field = $fields[$nextfield];
            $field = qc_check_field_variables($form, $field, $variables, $entry, $request->getWaId());
            $field['entry'] = $entry;
            $field['status'] = 'incomplete';
            if($field['type']=='calculation'){
                $field = qc_formbuilder_do_calculation($field, $entry, $form, $request->getWaId());
            }else if( $field['type']=='html' ){
                $field['config']['default'] =  $field['config']['default'];
            }
            
            return $field;

        }else{
            
            if(isset($mailer['on_insert']) && $mailer['on_insert']==1){
                $answers = qc_form_answer($form, $fields, $entry, $request->getWaId());
                if( !empty( $answers ) ){
                    qcld_wb_chatbot_send_form_query($answers, $mailer, $formid , $request->getWaId());
                }
                
            }
            
            if(!empty($processors) && isset($processors[qc_array_key_first($processors)]['runtimes'])){
                $entrydetails = qc_form_entry_details($form, $fields, $entry, $request->getWaId());
                qcld_wb_chatbot_send_autoresponse($entrydetails, $processors, $formid, $request->getWaId());
            }
            
            $wpdb->insert(
                $wpdb->prefix."wfb_form_entries",
                array(
                    'datestamp'  => current_time( 'mysql', 1 ),
                    'user_id'   => 0,
                    'form_id'	=> $formid,
                    'status'	=> 'active'
                )
            );

            $entry = $wpdb->insert_id;

            $all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$request->getWaId().'_data' );
            
            if( $all_answers && ! empty( $all_answers ) ){
                foreach( $all_answers as $answer ){
                    
                    $table      = $wpdb->prefix . 'wfb_form_entry_values';
                    $valuecheck = $wpdb->get_results( "SELECT * FROM `$table` WHERE 1 and `entry_id` = '" . $entry . "' and `field_id` = '" . $answer->field_id . "'" );
                    if( empty( $valuecheck ) ){
                        $wpdb->insert(
                            $table,
                            array(
                                'entry_id' => $entry,
                                'field_id' => $answer->field_id,
                                'slug'     => ( $answer->slug ),
                                'value'    => stripslashes( $answer->value ),
                            )
                        );
                    }else{
                        $data = array('value'=> stripslashes( $answer->value ));
                        $where = array('entry_id'=>$entry, 'field_id'=> $answer->field_id);
                        $whereformat = array('%d', '%s');
                        $format = array('%s');
                        $wpdb->update( $table, $data, $where, $format, $whereformat );
                        
                    }

                }
            }
            
            return array('status'=>'complete');
        }
        
    }else{

        if(isset($mailer['on_insert']) && $mailer['on_insert']==1){
            $answers = qc_form_answer($form, $fields, $entry, $request->getWaId());
            qcld_wb_chatbot_send_form_query($answers, $mailer, $formid, $request->getWaId());
        }

        if(!empty($processors) && isset($processors[qc_array_key_first($processors)]['runtimes'])){
            $entrydetails = qc_form_entry_details($form, $fields, $entry, $request->getWaId());
            qcld_wb_chatbot_send_autoresponse($entrydetails, $processors, $formid, $request->getWaId());
        }
        
        $wpdb->insert(
            $wpdb->prefix."wfb_form_entries",
            array(
                'datestamp'  => current_time( 'mysql', 1 ),
                'user_id'   => 0,
                'form_id'	=> $formid,
                'status'	=> 'active'
            )
        );

        $entry = $wpdb->insert_id;
        $all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$request->getWaId().'_data' );
        if( $all_answers && ! empty( $all_answers ) ){
            foreach( $all_answers as $answer ){
                
                $wpdb->insert(
                    $wpdb->prefix."wfb_form_entry_values",
                    array(
                        'entry_id'  => $entry,
                        'field_id'   => $answer->field_id,
                        'slug'	=> ($answer->slug),
                        'value'	=> stripslashes($answer->value)
                    )
                );

            }
        }
        qcbot_conv_cookies_data_delete( $formid.'_'.$request->getWaId().'_data' );
        qcbot_conv_cookies_data_delete( $formid.'_'.$request->getWaId() );
        
        return array('status'=>'complete');
    }
    
    die();
}

/**
 * Get field details by field id
 *
 * @param [type] $form
 * @param [type] $fieldid
 * @return void
 */
function qc_get_details_by_fieldid_wa($form, $fieldid){

    $fields = $form['fields'];
    if(isset($fields[$fieldid])){
        return $fields[$fieldid];
    }else{
        return array();
    }

}

/**
 * find STR responses
 *
 * @param Qcld_WA_Request $request
 * 
 * @return void
 */
function qcld_wa_findstrresponses( Qcld_WA_Request $request, $message ) {

    $responses = wpbot_wa_find_response_by_keyword( $message, qcld_wa_currentLanguage() );

    if ( $responses['status'] == 'success' ) {
        $data = $responses['data'];
        if ( $responses['multiple'] ) {
            //multiple

            $responses = array();
            foreach ( $data as $response ) {
                $responses[] = $response['query'];
            }

            $formlabel = esc_html__( 'Please choose from below', 'wpbot-wa' ) . "\n";
            $formlabel .= qcld_wa_convert_command_to_number( $responses );
            qcld_wa_set_transient( $request->getWaId() . '_wa_str_buttons', $responses );
            $text = apply_filters( 'qcld_wa_modify_content', $formlabel, $request );
            $response = qcld_wa_send_message( $text, $request->getFrom() );
            exit;

        } else {
            //single
            $text = apply_filters( 'qcld_wa_modify_content', $data[0]['response'], $request );
            $response = qcld_wa_send_message( $text, $request->getFrom() );

            if( $response && $data[0]['followup'] != '' ){

                $text = apply_filters( 'qcld_wa_modify_content', $data[0]['followup'], $request );
                $response = qcld_wa_send_message( $text, $request->getFrom() );

            }
            exit;
        }
    }
    
}

/**
 * Find Response by Keyword
 * 
 * @param string $keyword
 * 
 * @param string $language
 *
 * @return array
 */
function wpbot_wa_find_response_by_keyword( $keyword, $language ) {

    global $wpdb;
	$table = $wpdb->prefix.'wpbot_response';
	

	$response_result = array();

	$status = array( 'status' => 'fail', 'multiple' => false );
	

	if ( empty( $response_result ) ) {
		$results = $wpdb->get_results( "SELECT `query`, `response`, `custom` FROM `$table` WHERE 1 and `query` = '".$keyword."' and lang='".$language."'" );
		if ( ! empty( $results ) ) {
			foreach ( $results as $result ) {
				
				$response_result[] = array( 'query' => $result->query, 'response' => $result->response, 'followup' => $result->custom, 'score' => 1 );
				
			}
		}
	}
	

	if ( empty( $response_result ) ) {

		$results = $wpdb->get_results( "SELECT * FROM `$table` WHERE 1 and ( CONCAT(',', keyword, ',') like '%,". $keyword .",%' or CONCAT(',', keyword, ',') like '%, ". $keyword .",%' or CONCAT(',', keyword, ',') like '%". $keyword .",%' or CONCAT(',', keyword, ',') like '%, ". $keyword ."%' or CONCAT(',', keyword, ',') like '%,". $keyword ."%' ) and lang = '".$language."' " );
		if ( ! empty( $results ) ) {
			foreach ( $results as $result ) {
				
				$response_result[] = array( 'query' => $result->query, 'response'=> $result->response, 'followup' => $result->custom, 'score' => 1 );
				
			}
		}
	}
	
	if ( empty( $response_result ) ) {
		$results = $wpdb->get_results( "SELECT * FROM `$table` WHERE `query` REGEXP '".$keyword."' and lang='".$language."'" );
		$weight = get_option( 'qc_bot_str_weight' ) != '' ? get_option( 'qc_bot_str_weight' ) : '0.4';
		
		if ( ! empty( $results ) ) {
			foreach ( $results as $result ) {
			
				$response_result[] = array( 'query' => $result->query, 'response' => $result->response, 'followup' => $result->custom, 'score' => 1 );
				
			}
		}
	}

	if ( class_exists( 'Qcld_str_pro' ) ) {
		if ( get_option( 'qc_bot_str_remove_stopwords' ) && get_option( 'qc_bot_str_remove_stopwords' ) == 1 ) {
			$keyword = qc_strpro_remove_stopwords( $keyword );
		}
	}
	
	
	if ( empty( $response_result ) ) {
		$keyword = qc_strpro_remove_stopwords( $keyword );
		$fields = get_option( 'qc_bot_str_fields' );
		if ( $fields && ! empty( $fields ) && class_exists( 'Qcld_str_pro' ) ) {
			$qfields = implode( ', ', $fields );
		} else {
			$qfields = '`query`,`keyword`';
		}

		$results = $wpdb->get_results( "SELECT `query`, `response`, `custom`, MATCH($qfields) AGAINST('".$keyword."' IN NATURAL LANGUAGE MODE) as score FROM $table WHERE MATCH($qfields) AGAINST('".$keyword."' IN NATURAL LANGUAGE MODE) and lang='".$language."' order by score desc limit 15" );

		$weight = get_option( 'qc_bot_str_weight' ) != '' ? get_option( 'qc_bot_str_weight' ) : '0.4';
		//$weight = 0;
		if ( ! empty( $results ) ) {
			foreach ( $results as $result ) {
				if ( $result->score >= $weight ) {
					$response_result[] = array( 'query' => $result->query, 'response' => $result->response, 'followup' => $result->custom, 'score' => $result->score );
				}
			}

			if ( empty( $response_result ) ) {
				if ( ! empty( $results ) ) {
					foreach ( $results as $result ) {
	
						$score_array = str_split( $result->score );
						$score_int = 0;
						foreach ( $score_array as $score ) {
							
							if ( $score != '.' && $score != '0' ) {
								$score_int = (int)$score;
								break;
							}
						}
						$main_score = $result->score;
						if ( $score_int > 0 ) {
							$main_score = '0.'.$score_int;
						}
						if ( $main_score >= $weight ) {
							$response_result[] = array( 'query' => $result->query, 'response' => $result->response, 'followup' => $result->custom, 'score' => $result->score);
						}
					}
				}
	
			}


		}
		
	}


	if ( ! empty( $response_result ) ) {

		if ( count( $response_result ) > 1 ) {
			$status = array( 'status' => 'success', 'multiple' => true, 'data' => $response_result );
		} else {
			$status = array( 'status' => 'success', 'multiple' => false, 'data' => $response_result );
		}

	}
	
    return $status;
}

/**
 * STR Categories
 * 
 * @param Qcld_WA_Request $request
 *
 * @return array
 */
function qcld_wa_strcategories( Qcld_WA_Request $request ) {
    
    $categories = wpbo_wa_search_response_catlist();

    if ( $categories['status'] == 'success' ) {

        $data = $categories['data'];
        if( ! empty( $data ) ) {

            $categories = array();
            foreach ( $data as $category ) {
                $categories[] = $category['name'];
            }

            $text = esc_html__( 'Please choose from below', 'wpbot-wa' ) . "\n";
            $text .= qcld_wa_convert_command_to_number( $categories );
            qcld_wa_set_transient( $request->getWaId() . '_wa_str_buttons', $categories );
            
            


        } else {
            $texts = qcld_wa_get_option( 'qlcd_wp_chatbot_no_result' );
            $text = $texts[array_rand( $texts )];
        }

    } else {

        $texts = qcld_wa_get_option( 'qlcd_wp_chatbot_no_result' );
        $text = $texts[array_rand( $texts )];

    }

    $text = apply_filters( 'qcld_wa_modify_content', $text, $request );
    $response = qcld_wa_send_message( $text, $request->getFrom() );
    exit;

}

/**
 * Return STR Categories
 *
 * @return array $categories
 */
function wpbo_wa_search_response_catlist(){
	global $wpdb;
	$table = $wpdb->prefix.'wpbot_response_category';
	
	$status = array('status'=>'fail');
	$results = $wpdb->get_results("SELECT * FROM `$table` WHERE 1");
	$response_result = array();
	
	if(!empty($results)){
		foreach($results as $result){
			
			$response_result[] = array('name'=>$result->name);
			
		}
	}
	
	if(!empty($response_result)){

		$status = array('status'=>'success', 'data'=>$response_result);

	}
	
	return $status;
	
}

/**
 * STR response by category 
 * 
 * @param Qcld_WA_Request $request
 *
 * @return void
 */
function qcld_wa_strcategory( Qcld_WA_Request $request, $message ) {

    $responses = wpbot_wa_find_response_by_category( $message, qcld_wa_currentLanguage() );

    if ( $responses['status'] == 'success' ) {
        
        $data = $responses['data'];
        if( ! empty( $data ) ) {

            $responses = array();
            foreach ( $data as $response ) {
                $responses[] = $response['query'];
            }

            $text = esc_html__( 'Please choose from below', 'wpbot-wa' ) . "\n";
            $text .= qcld_wa_convert_command_to_number( $responses );
            qcld_wa_set_transient( $request->getWaId() . '_wa_str_buttons', $responses );
            

        } else {
            $texts = qcld_wa_get_option( 'qlcd_wp_chatbot_no_result' );
            $text = $texts[array_rand( $texts )];
        }

    } else {
        $texts = qcld_wa_get_option( 'qlcd_wp_chatbot_no_result' );
        $text = $texts[array_rand( $texts )];
    }

    $text = apply_filters( 'qcld_wa_modify_content', $text, $request );
    $response = qcld_wa_send_message( $text, $request->getFrom() );
    exit;
    
}

/**
 * Find response by category
 *
 * @return void
 */
function wpbot_wa_find_response_by_category( $keyword, $language ) {
    global $wpdb;
	$table      = $wpdb->prefix.'wpbot_response';
    $status = array('status'=>'fail');
    $results    = $wpdb->get_results("SELECT `query`, `response`, `custom` FROM `$table` WHERE 1 and `category` like '%".$keyword."%' and lang='".$language."'");
    $response_result = array();
    if ( ! empty( $results ) ) {
        foreach ( $results as $result ) {
            $response_result[] = array( 'query' => $result->query );
        }
        $status = array( 'status' => 'success', 'data' => $response_result );
    }
    return $status;
}

/**
 * Remove stop words from string
 *
 * @param string $query
 * 
 * @param array $stopwords
 * @return string
 */
function qcpd_remove_wa_stopwords($query, $stopwords){
	return preg_replace('/\b('.implode('|',$stopwords).')\b/','',$query);
}

/**
 * Handle dialogflow responses
 * 
 * @param Qcld_WA_Request $request
 * 
 * @param string $message
 *
 * @return void
 */
function qcld_wa_handle_dialogflow( Qcld_WA_Request $request, $message ) {

    $query = $message;
    
    if($query!=''){

        $result = qc_df_v2_api_wa( $query );

        $result = json_decode( $result, true);
        if(isset($result['queryResult']) && !empty($result['queryResult'])){
        
            $intent = $result['queryResult']['intent']['displayName'];
            if($intent=='Default Fallback Intent'){
                
                //remove stop words
                
                if(qcld_wa_get_option('qlcd_wp_chatbot_stop_words') && qcld_wa_get_option('qlcd_wp_chatbot_stop_words')!=''){
                    
                    $stopwords = explode(',',qcld_wa_get_option('qlcd_wp_chatbot_stop_words'));
                    $query = qcpd_remove_wa_stopwords($query, $stopwords);
                    
                }
                
                //site search code. Checking if any result exists or not.
                $sitesearchresult = qcld_wpbo_search_site_fb($query);

                if($sitesearchresult['status']=='success'){

                    $results = $sitesearchresult['results'];
                    $text = qcld_wa_site_search_result( $results );

                    $text = apply_filters( 'qcld_wa_modify_content', $text, $request );
                    $response = qcld_wa_send_message( $text, $request->getFrom() );
                    exit;
                    
                }else{
                    
                    $text = apply_filters( 'qcld_wa_modify_content', qcld_wa_get_option('qlcd_wp_chatbot_dialogflow_defualt_reply'), $request );
                    $response = qcld_wa_send_message( $text, $request->getFrom() );
                    if ( $response ) {
                        qcld_wa_showstartmenu( $request );
                    }
                    exit;

                }


            }elseif($intent=='faq'){

                qcld_wa_faq( $request, 'show_question' );

            }elseif($intent=='email'){

                qcld_wa_sendusemail( $request );

            }elseif($intent=='phone'){

                qcld_wa_callmeback( $request );

            }elseif($intent=='email subscription'){
                
                qcld_wa_emailsubscription( $request );

            }elseif(isset($result['queryResult']['fulfillmentMessages']) && !empty($result['queryResult']['fulfillmentMessages'])){
                
                $dfmessages = $result['queryResult']['fulfillmentMessages'];
                foreach($dfmessages as $key => $message){
                    
                    if(isset($message['text'])){
                        //text response

                        $text = apply_filters( 'qcld_wa_modify_content', $message['text']['text'][0], $request );
                        $response = qcld_wa_send_message( $text, $request->getFrom() );
                        exit;
                        
                    }elseif(isset($message['quickReplies'])){
                        //quick replies
                        
                        $title = strip_tags($message['quickReplies']['title']);
                        $replies = $message['quickReplies']['quickReplies'];

                        $title .= "\n";
                        $title .= qcld_wa_convert_command_to_number( $replies );
                        qcld_wa_set_transient( $request->getWaId() . '_wa_df_buttons', $replies );

                        $text = apply_filters( 'qcld_wa_modify_content', $title, $request );
                        $response = qcld_wa_send_message( $text, $request->getFrom() );
                        exit;
                        
                    }elseif(isset($message['card'])){
                        
                        $text = apply_filters( 'qcld_wa_modify_content', 'Sorry, Card response not supported yet.', $request );
                        $response = qcld_wa_send_message( $text, $request->getFrom() );
                        exit;
                        
                    }
                    
                }

            }
        }else{

            $text = apply_filters( 'qcld_wa_modify_content', qcld_wa_get_option('qlcd_wp_chatbot_dialogflow_defualt_reply'), $request );
            $response = qcld_wa_send_message( $text, $request->getFrom() );
            if ( $response ) {
                qcld_wa_showstartmenu( $request );
            }
            exit;
            
        }

    }

}
function qcld_wa_handle_openai( Qcld_WA_Request $request, $message ) {
    $query = $message;
    
    if($query!=''){
        //Find inopen AI
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
        $text = $mess->choices[0]->text;
        $this->helper->send( 'sendMessage', $parameters );
        $response = qcld_wa_send_message( $text, $request->getFrom() );
        exit;
                        
    }
}
/**
 * display products to whatsapp
 *
 * @param Qcld_WA_Request $request
 * @param array $sitesearchresult
 * @param string $message
 * 
 * @return void
 */
function qcld_wa_display_products( Qcld_WA_Request $request, $sitesearchresult, $message ) {
    if ( isset( $sitesearchresult['status'] ) && $sitesearchresult['status'] == 'success' ) {
        qcld_wa_delete_transient( $request->getWaId() . '_wa_product_search' );
        
        $reply_text = qcld_wa_get_option('qlcd_wp_chatbot_product_success');
        $reply_text = $reply_text[array_rand( $reply_text )];
        $text = apply_filters( 'qcld_wa_modify_content', $reply_text . ' ' . $message, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );

        //Response content
        $response_content = '';
        $product_buttons = array();
        foreach ( $sitesearchresult['results'] as $key => $product ) {
            $link = apply_filters( 'qcld_wa_modify_url', $product['link'], $request );
            $title = apply_filters( 'qcld_wa_modify_content', $product['title'], $request );

            $product_buttons[] = $title . ' - ' . $link;
            $response_content .= $title . "\n";
            $response_content .= $link . "\n";
            $response_content .= 'Price - '. html_entity_decode( $product['subtitle'] ) . "\n";
            $response_content .= 'To order, Press '. ( $key + 1 ) . "\n";
            $response_content .= "\n";
        }

        $text = apply_filters( 'qcld_wa_modify_content', $response_content, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );
        qcld_wa_set_transient( $request->getWaId() . '_wa_product_showing', 1 );
        qcld_wa_set_transient( $request->getWaId() . '_wa_product_buttons', $product_buttons );
        exit;

    } else {

        $reply_text = qcld_wa_get_option('qlcd_wp_chatbot_product_fail');
        $reply_text = $reply_text[array_rand( $reply_text )];
        $text = apply_filters( 'qcld_wa_modify_content', $reply_text, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );
        exit;
        
    }
}

/**
 * Product search function
 *
 * @param Qcld_WA_Request $request
 * @param string $message
 * @param integer $step
 * @return void
 */
function qcld_wa_product_search( Qcld_WA_Request $request, $message, $step = 1 ) {

    if ( $step === 1 ) {
        
        qcld_wa_set_transient( $request->getWaId() . '_wa_product_search', 1 );
        $reply_text = qcld_wa_get_option('qlcd_wp_chatbot_product_asking');
        $reply_text = $reply_text[array_rand( $reply_text )];
        $text = apply_filters( 'qcld_wa_modify_content', $reply_text, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );
        exit;

    } elseif ( $step === 2 ) {
        
        $sitesearchresult = qcld_wa_psearch_fnc($message);
        qcld_wa_display_products( $request, $sitesearchresult, $message );
    }
    
}

/**
 * Sale products
 *
 * @param Qcld_WA_Request $request
 * @param string $message
 * @return void
 */
function qcld_wa_sale_products( Qcld_WA_Request $request, $message ) {
    $searchresults = qcld_wa_sales_product();
    qcld_wa_display_products( $request, $searchresults, $message );
}

/* Sale Product */
function qcld_wa_sales_product() {

    $product_per_page = (qcld_fb_get_option('wppt_number_of_result')==''?'5':qcld_fb_get_option('wppt_number_of_result'));
	$product_orderby = (qcld_fb_get_option('wppt_result_orderby')==''?'title':qcld_fb_get_option('wppt_result_orderby'));
	$product_order = (qcld_fb_get_option('wppt_result_order')==''?'ASC':qcld_fb_get_option('wppt_result_order'));
    //get sale products query.
    $argu_params = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'posts_per_page' => $product_per_page,
        'orderby' => $product_orderby,
        'order' => $product_order,
        //'offset' => $offset,
        'meta_query' => WC()->query->get_meta_query(),
        'post__in' => array_merge(array(0), wc_get_product_ids_on_sale())
    );
	
	$response = array();
	$response['status'] = 'fail';
	
    /******
     *WP Query Operation to get products.*
     *******/
    $product_query = new WP_Query($argu_params);
    $product_num = $product_query->post_count;
    //Getting total product number by string.
    $total_argu = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 100,
        'meta_query' => WC()->query->get_meta_query(),
        'post__in' => array_merge(array(0), wc_get_product_ids_on_sale())
    );
    $total_query = new WP_Query($total_argu);
    $total_product_num = $total_query->post_count;
    
    $_pf = new WC_Product_Factory();
    //repeating the products
    if ($product_num > 0) {
        
        $response['status'] = 'success';
		$response['results'] = array();
		
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            if ($product->is_visible()) { // Display if visible

				$response['results'][] = array(
					'imgurl'=>get_the_post_thumbnail_url(get_the_ID(), 'full'),
					'link'=>get_permalink(get_the_ID()),
					'title'=>$product->get_title(),
					'subtitle'=>get_woocommerce_currency_symbol().wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) )
				);
				
            }
        endwhile;
        wp_reset_postdata();
        
    }else{
		
		$response['message'] = '';
	}
    
	return $response;
    wp_die();
}

/**
 * Featured Products
 *
 * @param Qcld_WA_Request $request
 * @param string $message
 * @return void
 */
function qcld_wa_featured_products( Qcld_WA_Request $request, $message ) {

    $sitesearchresult = qcld_wa_chatbot_keyword_featured();
    qcld_wa_display_products( $request, $sitesearchresult, $message );

}

/**
 * Find all featured products
 *
 * @return void
 */
function qcld_wa_chatbot_keyword_featured()
{
	
	$product_per_page = (qcld_fb_get_option('wppt_number_of_result')==''?'5':qcld_fb_get_option('wppt_number_of_result'));
	$product_orderby = (qcld_fb_get_option('wppt_result_orderby')==''?'title':qcld_fb_get_option('wppt_result_orderby'));
	$product_order = (qcld_fb_get_option('wppt_result_order')==''?'ASC':qcld_fb_get_option('wppt_result_order'));

    //get featured products query.
    $argu_params = array(
        'posts_per_page' => $product_per_page,
        'post_type' => 'product',
        'post_status' => 'publish',
        'tax_query' => array(array('taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured'))
    );
    /******
     *WP Query Operation to get products.*
     *******/
    $product_query = new WP_Query($argu_params);
    $product_num = $product_query->post_count;
    //Getting total product number by string.
    $total_argu = array(
        'posts_per_page' => 100,
        'post_type' => 'product',
        'post_status' => 'publish',
        'tax_query' => array(array('taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured',),)
    );
    $total_query = new WP_Query($total_argu);
    $total_product_num = $total_query->post_count;
	
    $response = array();
	$response['status'] = 'fail';
	
    $_pf = new WC_Product_Factory();
    //repeating the products
    if ($product_num > 0) {
        $response['status'] = 'success';
		$response['results'] = array();
       
        while ($product_query->have_posts()) : $product_query->the_post();
            $product = $_pf->get_product(get_the_ID());
            if ($product->is_visible()) { // Display if visible
                
				$response['results'][] = array(
					'imgurl'=>get_the_post_thumbnail_url(get_the_ID(), 'full'),
					'link'=>get_permalink(get_the_ID()),
					'title'=>$product->get_title(),
					'subtitle'=>get_woocommerce_currency_symbol().wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) )
				);
				
            }
        endwhile;
        wp_reset_postdata();
        
        
    }else{
		
		$response['message'] = '';
	}
	
	return $response;
    wp_die();
    
}

/**
 * Order status
 *
 * @param Qcld_WA_Request $request
 * @param string $message
 * @param integer $step
 * @return void
 */
function qcld_wa_order_status( Qcld_WA_Request $request, $message, $step = 1 ) {

    if ( $step === 1 ) {

        //qlcd_wp_chatbot_order_welcome
        $reply_text = qcld_wa_get_option('qlcd_wp_chatbot_order_welcome');
        $reply_text = $reply_text[array_rand( $reply_text )];
        $text = apply_filters( 'qcld_wa_modify_content', $reply_text, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );

        $reply_text = qcld_wa_get_option('qlcd_wp_chatbot_order_email');
        $reply_text = $reply_text[array_rand( $reply_text )];
        $text = apply_filters( 'qcld_wa_modify_content', $reply_text, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );
        qcld_wa_set_transient( $request->getWaId() . '_wa_order_status', 1 );
        exit;

    } elseif ( $step === 2 ) {

        qcld_wa_set_transient( $request->getWaId() . '_wa_order_status', 2 );
        qcld_wa_set_transient( $request->getWaId() . '_wa_order_status_email', $message );

        $reply_text = qcld_wa_get_option('qlcd_wp_chatbot_order_id');
        $reply_text = $reply_text[array_rand( $reply_text )];
        $text = apply_filters( 'qcld_wa_modify_content', $reply_text, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );
        exit;

    } elseif ( $step === 3 ) {

        $order_id = $message;
        $email = qcld_wa_get_transient( $request->getWaId() . '_wa_order_status_email' );

        qcld_wa_delete_transient( $request->getWaId() . '_wa_order_status' );
        qcld_wa_delete_transient( $request->getWaId() . '_wa_order_status_email' );

        if ( $order_id != '' && $email != '' ) {
            $results = qcld_wa_find_orders( $email, $order_id );

            if ( isset( $results['status'] ) && $results['status'] == 'success' ) {

                
                $reply_text = qcld_wa_get_option('qlcd_wp_chatbot_order_found');
                $reply_text = $reply_text[array_rand( $reply_text )];
                $text = apply_filters( 'qcld_wa_modify_content', $reply_text, $request );
                $response = qcld_wa_send_message( $text, $request->getFrom() );

                $orders = $results['orders'];
                $response_content = '';

                foreach ( $orders as $order ) {
                    $response_content .= 'Order ID: ' . $order->ID . "\n" ;
                    $response_content .= 'Order Date: ' . (date("m/d/Y", strtotime($order->post_date))) . "\n" ;

                    //order items
                    
                    $singleOrder = new WC_Order($order->ID);
                    $items = $singleOrder->get_items();
                    if ( !empty( $items ) ) {
                        $response_content .= 'Order Items:'. "\n";
                        $items_content = '';
                        foreach ($items as $item) {
                            $response_content .= ' -' . ($item["name"]) . ' X ' . ($item["qty"]) . "\n";
                        }
                    }

                    //Order Notes
                    $customernote = $singleOrder->get_customer_order_notes();
                    if(!empty($customernote)){
                        $response_content .= 'Order Notes:'."\n";
                        foreach($customernote as $cnote){
                            $response_content .= ' -'.($cnote->comment_content). "\n";
                        }
                    }

                    $response_content .= 'Order Status: ' . (strtoupper(end(explode("-", $order->post_status)))) . "\n" ;
                    $response_content .= "\n";
                }

                $text = apply_filters( 'qcld_wa_modify_content', $response_content, $request );
                $response = qcld_wa_send_message( $text, $request->getFrom() );
                exit;

            } else {

                $reply_text = qcld_wa_get_option('qlcd_wp_chatbot_order_not_found');
                $reply_text = $reply_text[array_rand( $reply_text )];
                $text = apply_filters( 'qcld_wa_modify_content', $reply_text, $request );
                $response = qcld_wa_send_message( $text, $request->getFrom() );
                exit;     

            }

        } else {

            $reply_text = qcld_wa_get_option('qlcd_wp_chatbot_order_not_found');
            $reply_text = $reply_text[array_rand( $reply_text )];
            $text = apply_filters( 'qcld_wa_modify_content', $reply_text, $request );
            $response = qcld_wa_send_message( $text, $request->getFrom() );
            exit;

        }
        //

    }

}

/**
 * product order
 *
 * @param Qcld_WA_Request $request
 * @param string $message
 * @param integer $step
 * @return void
 */
function qcld_wa_product_order( Qcld_WA_Request $request, $message, $step = 1 ) {

    if ( $step === 1 ) {

        // ask email address
        if ( ! qcld_wa_get_transient( $request->getWaId() . '_wa_order_email' ) ) {
            qcld_wa_set_transient( $request->getWaId() . '_wa_order_email', 1 );
            qcld_wa_set_transient( $request->getWaId() . '_wa_order_product', $message );
        }
        $texts = maybe_unserialize( qcld_wa_get_option( 'qlcd_wp_chatbot_asking_email' ) );
        $text = $texts[array_rand( $texts )];
        $text = apply_filters( 'qcld_wa_modify_content', $text, $request );
        $response = qcld_wa_send_message( $text, $request->getFrom() );
        exit;

    } elseif ( $step === 2 ) {

        $result = qcld_wa_send_order_to_admin( $request, $message, qcld_wa_get_transient( $request->getWaId() . '_wa_order_product' ) );

        if ( isset( $result['status'] ) == 'success' ) {

            $text = apply_filters( 'qcld_wa_modify_content', esc_html__( 'Thank you for your order request. We will get in touch with you soon!' ), $request );
            $response = qcld_wa_send_message( $text, $request->getFrom() );
            if ( $response ) {
                qcld_wa_delete_transient( $request->getWaId() . '_wa_order_email' );
                qcld_wa_delete_transient( $request->getWaId() . '_wa_order_product' );
            }
            exit;
        }
    }

}

/**
 * Send order email to admin
 *
 * @param Qcld_WA_Request $request
 * @param string $email
 * @param string $product
 * @return array
 */
function qcld_wa_send_order_to_admin( Qcld_WA_Request $request, $email, $product ) {

    $name                   = $request->getProfileName();
    $message                = qcld_wa_get_transient( $request->getWaId() . '_wa_feedback_msg' );
    $subject                = 'Product order request from WhatsApp by ' . $name;

    //Extract Domain
    $url                    = get_site_url();
    $url                    = parse_url( $url );
    $domain                 = $url['host'];
    $admin_email            = qcld_wa_get_option( 'admin_email' );
    $toEmail                = qcld_wa_get_option( 'qlcd_wp_chatbot_admin_email' ) != '' ? qcld_wa_get_option( 'qlcd_wp_chatbot_admin_email' ) : $admin_email;
    $fromEmail              = "wordpress@" . $domain;
    //Starting messaging and status.
    $response['status']     = 'fail';
    $response['message']    = esc_html( str_replace( '\\', '', qcld_wa_get_option( 'qlcd_wp_chatbot_email_fail' ) ) );

    //build email body
    $bodyContent            = "";
    $bodyContent           .= '<p><strong>' . esc_html__( 'Order Details', 'wpbot-wa' ) . ':</strong></p><hr>';
    $bodyContent           .= '<p>' . esc_html__( 'Name', 'wpbot-wa' ) . ' : ' . esc_html( $name ) . '</p>';
    $bodyContent           .= '<p>' . esc_html__( 'Email', 'wpbot-wa' ) . ' : ' . esc_html( $email ) . '</p>';
    $bodyContent           .= '<p>' . esc_html__( 'Phone', 'wpbot-wa' ) . ' : ' . esc_html( $request->getWaId() ) . '</p>';
    $bodyContent           .= '<p>' . esc_html__( 'Product', 'wpbot-wa' ) . ' : ' . esc_html( $product ) . '</p>';
    $bodyContent           .= '<p>' . esc_html__( 'Mail Generated on', 'wpchatbot' ) . ': ' . date( 'F j, Y, g:i a' ) . '</p>';
    $to                     = $toEmail;
    $body                   = $bodyContent;

    $headers                = array();
    $headers[]              = 'Content-Type: text/html; charset=UTF-8';
    $headers[]              = 'From: ' . esc_html( $name ) . ' <' . esc_html( $fromEmail ) . '>';

    wp_mail( $to, $subject, $body, $headers );
    $text = ( qcld_wa_get_option( 'qlcd_wp_chatbot_email_sent' ) != '' ? qcld_wa_get_option( 'qlcd_wp_chatbot_email_sent' ) : 'Your email was sent successfully. Thanks!' );
    
    $response['message'] = $text;
    $response['status']  = 'success';

    return $response;
}

/**
 * Find orders by email and order id
 *
 * @param string $email
 * @param string $order_id
 * @return array
 */
function qcld_wa_find_orders( $email, $order_id ) {

    $response = array();
    $response['status'] = 'failed';

    // The query arguments
    $customer_orders = get_posts(array(
        'numberposts' => -1,
        'meta_key' => '_billing_email',
        'meta_value' => $email,
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'posts_per_page' => 10,
        'orderby' => 'date',
        'post__in' => array($order_id)
    ));

    $response['order_num'] = count($customer_orders);
    if ( $response['order_num'] > 0 ) {
        $response['status'] = 'success';
        $response['orders'] = $customer_orders;
    }

    return $response;
}

/**
 * Dialogflow API
 *
 * @param [type] $query
 * @param [type] $helper
 * @return string
 */
function qc_df_v2_api_wa( $query ){
	
	$session_id = 'asd2342sde';
    $language = qcld_wa_get_option('qlcd_wp_chatbot_dialogflow_agent_language');
    //project ID
    $project_ID = qcld_wa_get_option('qlcd_wp_chatbot_dialogflow_project_id');
    // Service Account Key json file
    $JsonFileContents = qcld_wa_get_option('qlcd_wp_chatbot_dialogflow_project_key');
    if($project_ID==''){
        return json_encode(array('error'=>'Project ID is empty'));
    }
    if($JsonFileContents==''){
        return json_encode(array('error'=>'Key is empty'));
    }
    if( $query==''){
        return json_encode(array('error'=>'Query text is not added!'));
    }
    $query = sanitize_text_field($query);
    if(isset($_POST['sessionid']) && $_POST['sessionid']!=''){
        $session_id = sanitize_text_field($_POST['sessionid']);
    }
    

    if(file_exists(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php')){

        require(QCLD_wpCHATBOT_GC_DIRNAME.'/autoload.php');

        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes (['https://www.googleapis.com/auth/dialogflow']);
        // Convert to array 
        $array = json_decode($JsonFileContents, true);
        $client->setAuthConfig($array);

        try {
            $httpClient = $client->authorize();
            $apiUrl = "https://dialogflow.googleapis.com/v2/projects/{$project_ID}/agent/sessions/{$session_id}:detectIntent";

            $response = $httpClient->request('POST', $apiUrl, [
                'json' => ['queryInput' => ['text' => ['text' => $query, 'languageCode' => $language]],
                    'queryParams' => ['timeZone' => '']]
            ]);
            
            $contents = $response->getBody()->getContents();
            return $contents;

        }catch(Exception $e) {
            return json_encode(array('error'=>$e->getMessage()));
        }

    }else{
        return json_encode(array('error'=>'API client not found'));
    }
	
}

/* WPBot Product Search function */
function qcld_wa_psearch_fnc($keyword){
	global $wpdb;
	
	$total_items = (qcld_fb_get_option('wppt_number_of_result')==''?'5':qcld_fb_get_option('wppt_number_of_result'));
	$orderby = (qcld_fb_get_option('wppt_result_orderby')==''?'none':qcld_fb_get_option('wppt_result_orderby'));
	$order = (qcld_fb_get_option('wppt_result_order')==''?'ASC':qcld_fb_get_option('wppt_result_order'));
	$thumb = (qcld_fb_get_option('wpbot_search_image_size')?qcld_fb_get_option('wpbot_search_image_size'):'thumbnail');
	//order by setup

	$searchkeyword = ($keyword);

	$response = array();
	$response['status'] = 'fail';


		$sql = "SELECT * FROM ". $wpdb->prefix."posts where post_type in ('product') and post_status='publish' and ((post_title REGEXP '[[:<:]]".$searchkeyword."[[:>:]]'))";
		$total_results = $wpdb->get_results($sql);

		if(!empty($total_results)){
			if($orderby=='title'){
				$orderby = 'post_title';
			}
			if($orderby=='date'){
				$orderby = 'post_date';
			}
			if($orderby=='modified'){
				$orderby = 'post_modified';
			}
			
			if($orderby!='none' and $orderby!='rand'){
				$sql .= " order by $orderby $order";
			}
			$limit = " Limit 0, $total_items";		
			$results = $wpdb->get_results($sql.$limit);
		}else{
			$query_arg = array(
				'post_type'     => 'product',
				'post_status'   => 'publish',
				'posts_per_page'=> $total_items,
				's'             => stripslashes( $keyword ),
				'paged'			=> 1,
				'orderby'		=> $orderby,
			);
			if($orderby!='none' or $orderby!='rand'){
				$query_arg['order'] = $order;
			}			

			$resultss = new WP_Query( $query_arg );
			$results = $resultss->posts;
			
		}

		$newresults = array();
		foreach($results as $result){
			if (qcld_wp_chatbot_product_controlling($result->ID) == true) {
				$newresults[] = $result;
			}
		}
		$results = $newresults;
		$_pf = new WC_Product_Factory();
		
		if (!empty( $results ) ) {
			$response['status'] = 'success';
			$response['results'] = array();
			
			foreach ( $results as $result ) {
				
				$product = $_pf->get_product($result->ID);
				
				$response['results'][] = array(
					'imgurl'=>get_the_post_thumbnail_url($result->ID, 'full'),
					'link'=>get_permalink($result->ID),
					'title'=>$product->get_title(),
					'subtitle'=> get_woocommerce_currency_symbol().wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) )
				);

			}

		}
		wp_reset_query();
		
	
	return $response;
    wp_die();
	
}