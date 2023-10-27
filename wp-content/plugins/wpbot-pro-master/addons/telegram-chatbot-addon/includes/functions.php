<?php

/**
 * Return STR Categories
 *
 * @return array $categories
 */
function wpbo_tg_search_response_catlist(){
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
 * Find response by category
 *
 * @return void
 */
function wpbot_tg_find_response_by_category( $keyword, $language ) {
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
 * Find Response by Keyword
 *
 * @return void
 */
function wpbot_tg_find_response_by_keyword( $keyword, $language ) {

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
 * find conversational form ID
 *
 * @param [type] $ccommands
 * @param [type] $cforms
 * @param [type] $cformid
 * @param [type] $message
 * @return void
 */
function qc_tg_findformid( $ccommands, $cforms, $cformid, $message ) {
	
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
 * str to lower recursively
 *
 * @param string $value
 * @return string
 */
function qc_tg_nestedLowercase($value) {
    if (is_array($value)) {
        return array_map('qc_tg_nestedLowercase', $value);
    }
    return strtolower($value);
}

/**
 * Get form first field by id
 *
 * @param int $formid
 * @param int $chatid
 * @return void
 */
function qcwpbot_tg_get_form($formid, $sender){
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


function qc_get_details_by_fieldid_tg($form, $fieldid){

    $fields = $form['fields'];
    if(isset($fields[$fieldid])){
        return $fields[$fieldid];
    }else{
        return array();
    }

}


function qcwpbot_capture_form_value_tg($formid, $fieldid, $answer, $entry, $helper){
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
    

    $result = qcbot_conv_cookies_get( $formid.'_'.$helper->request->chatID );
    if( ! $result || empty( $result ) ){
        $result = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_forms where form_id='".$formid."' and type='primary'");
    }
    $form = unserialize($result->config);
    
    $processors = (isset($form['processors'])?$form['processors']:array());
    
    $mailer = (isset($form['mailer'])?$form['mailer']:array());
    
    $variables = isset($form['variables'])?$form['variables']:array();

    $fieldetails = qc_get_details_by_fieldid_tg($form, $fieldid);
    
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
            qcbot_conv_cookies_data_set( $formid.'_'.$helper->request->chatID.'_data', $data );
        }else{
            $data[] = array(
                'entry_id'  => $entry,
                'field_id'   => $fieldid,
                'slug'	=> (isset($fieldetails['slug'])?$fieldetails['slug']:''),
                'value'	=> stripslashes($answer)
            );
            qcbot_conv_cookies_data_set( $formid.'_'.$helper->request->chatID.'_data', $data );
        }
        
    }
    $fields = $form['fields'];
    $conditions = array();
    if(isset($form['conditional_groups']['conditions'])){
        $conditions = $form['conditional_groups']['conditions'];
    }
    
    
    if(isset($form['layout_grid']['fields']) && !empty($form['layout_grid']['fields'])){
        
        $nextfield = qc_get_next_field($form, $fieldid, $entry, $helper->request->chatID);
        
        if($nextfield!='none' && $nextfield!='' && !empty($fields[$nextfield])){
            
            $field = $fields[$nextfield];
            $field = qc_check_field_variables($form, $field, $variables, $entry, $helper->request->chatID);
            $field['entry'] = $entry;
            $field['status'] = 'incomplete';
            if($field['type']=='calculation'){
                $field = qc_formbuilder_do_calculation($field, $entry, $form, $helper->request->chatID);
            }else if( $field['type']=='html' ){
                $field['config']['default'] =  $field['config']['default'];
            }
            
            return $field;

        }else{
            
            if(isset($mailer['on_insert']) && $mailer['on_insert']==1){
                $answers = qc_form_answer($form, $fields, $entry, $helper->request->chatID);
                if( !empty( $answers ) ){
                    qcld_wb_chatbot_send_form_query($answers, $mailer, $formid , $helper->request->chatID);
                }
                
            }
            
            if(!empty($processors) && isset($processors[qc_array_key_first($processors)]['runtimes'])){
                $entrydetails = qc_form_entry_details($form, $fields, $entry, $helper->request->chatID);
                qcld_wb_chatbot_send_autoresponse($entrydetails, $processors, $formid, $helper->request->chatID);
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

            $all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$helper->request->chatID.'_data' );
            
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
            $answers = qc_form_answer($form, $fields, $entry, $helper->request->chatID);
            qcld_wb_chatbot_send_form_query($answers, $mailer, $formid, $helper->request->chatID);
        }

        if(!empty($processors) && isset($processors[qc_array_key_first($processors)]['runtimes'])){
            $entrydetails = qc_form_entry_details($form, $fields, $entry, $helper->request->chatID);
            qcld_wb_chatbot_send_autoresponse($entrydetails, $processors, $formid, $helper->request->chatID);
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
        $all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$helper->request->chatID.'_data' );
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
        qcbot_conv_cookies_data_delete( $formid.'_'.$helper->request->chatID.'_data' );
        qcbot_conv_cookies_data_delete( $formid.'_'.$helper->request->chatID );
        
        return array('status'=>'complete');
    }
    
    die();
}


/**
 * Handle next field
 *
 * @param string $answer
 * @param object $helper
 * @return void
 */
function qcld_tg_handle_cfb_next( $answer, $helper ) {
	
	$formid = $helper->get_transient( '_tg_conversational_form_id' );
	$fieldid = $helper->get_transient( '_tg_conversational_field_id' );
	$entry = $helper->get_transient( '_tg_conversational_field_entry' );
	
	$formresponse = qcwpbot_capture_form_value_tg( $formid, $fieldid, $answer, $entry, $helper );
	
	if( $answer != '' ){
		$ccommands = array_map( 'qc_tg_nestedLowercase', qc_get_formbuilder_form_commands() );
		$cformid = qc_get_formbuilder_form_ids();
		$cforms = array_map('qc_tg_nestedLowercase', qc_get_formbuilder_forms());
		$get_formidby_keyword = qc_tg_findformid($ccommands, $cforms, $cformid, strtolower($answer));
		if(!empty($cformid) && in_array($get_formidby_keyword, $cformid)){
			$helper->delete_transient( '_tg_conversational_field_entry' );
			$helper->delete_transient( '_tg_conversational_field_id' );
			$helper->delete_transient( '_tg_conversational_form_id' );
			$helper->delete_transient( '_tg_conversational_form' );
            $helper->handle_formbuilder_response( $get_formidby_keyword );
			exit;
		}
	}

	if($formresponse['status']=='incomplete'){

		$helper->set_transient( '_tg_conversational_field_entry', $formresponse['entry']);
		$helper->set_transient( '_tg_conversational_field_id', $formresponse['ID']);
		
		$formtype = $formresponse['type'];
		$formlabel = $formresponse['label'];
		
		if($formtype=='dropdown' || $formtype=='checkbox'){			
			$fieldoptions = $formresponse['config']['option'];
			$all_faqs = array();
			foreach($fieldoptions as $fieldoption){
				$all_faqs[] = $fieldoption['value'];
			}
			
			$encodedKeyboard = $helper->buttons( $all_faqs );
            // text message only
            $parameters = array(
                'chat_id' => $helper->request->chatID,
                'reply_markup' => $encodedKeyboard,
                'text' => $formlabel,
                "parse_mode" => "html"
            );
            $helper->send( 'sendMessage', $parameters );
            exit;
			
			
		}elseif($formtype=='html'){
			$formlabel = $formresponse['config']['default'];
			$parameters = array(
                "chat_id" => $helper->request->chatID,
                "text" => $formlabel,
                "parse_mode" => "html"
            );
            $helper->send( 'sendMessage', $parameters );
            qcld_tg_handle_cfb_next( '', $helper );

			
			
		}elseif($formtype=='calculation'){
			
			$formlabel = $formresponse['calresult'];
			$parameters = array(
                "chat_id" => $helper->request->chatID,
                "text" => $formlabel,
                "parse_mode" => "html"
            );
            $helper->send( 'sendMessage', $parameters );
            qcld_tg_handle_cfb_next( $formresponse['calvalue'], $helper );
			
		}elseif($formtype=='hidden'){
            qcld_tg_handle_cfb_next( $formresponse['config']['default'], $helper );
			
		}else{
			
            $parameters = array(
                "chat_id" => $helper->request->chatID,
                "text" => $formlabel,
                "parse_mode" => "html"
            );
            $helper->send( 'sendMessage', $parameters );
			exit;
		}
		
		
	}else{
		$helper->delete_transient( '_tg_conversational_field_entry');
		$helper->delete_transient( '_tg_conversational_field_id');
		$helper->delete_transient( '_tg_conversational_form_id');
		$helper->delete_transient( '_tg_conversational_form');
		exit;
	}
	
}

function qcpd_remove_tg_stopwords($query, $stopwords){
	return preg_replace('/\b('.implode('|',$stopwords).')\b/','',$query);
}

function qc_df_v2_api_tg($query, $helper ){
	
	$session_id = 'asd2342sde';
    $language = $helper->get_option('qlcd_wp_chatbot_dialogflow_agent_language');
    //project ID
    $project_ID = $helper->get_option('qlcd_wp_chatbot_dialogflow_project_id');
    // Service Account Key json file
    $JsonFileContents = $helper->get_option('qlcd_wp_chatbot_dialogflow_project_key');
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
