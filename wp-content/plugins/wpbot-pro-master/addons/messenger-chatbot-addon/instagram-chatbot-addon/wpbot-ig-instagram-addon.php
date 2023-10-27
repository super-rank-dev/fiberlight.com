<?php

defined('ABSPATH') or die("No direct script access!");

if( !defined('WBIG_PATH') )
	define( 'WBIG_PATH', plugin_dir_path(__FILE__) );
if( !defined('WBIG_URL') )
	define( 'WBIG_URL', plugin_dir_url(__FILE__ ) );

require_once 'wpbot-ig-instagram-functions.php';
require_once 'admin/wpbot-ig-admin-page.php';

function qcpd_wpig_require_notice()
{
?>
	<div id="message" class="error">
		<p>
			<?php echo esc_html__('Please install & activate the Chatbot Pro plugin and configure the Artificial Intelligence properly to get theInstagram Instagram Addon to work.', 'wpfb'); ?>
		</p>
	</div>
<?php
}

function qcpd_wpig_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'admin.php?page=instagram-chatbot-help-license') ) );
    }
}
add_action( 'activated_plugin', 'qcpd_wpig_activation_redirect' );

/**
 *
 * Function to load translation files.
 *
 */
function qcpd_wpig_addon_lang_init() {
    load_plugin_textdomain( 'wpfb', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'qcpd_wpig_addon_lang_init');

//Let's go
add_action('init', 'qcpd_wpig_instagram_callback');

function qcpd_wpig_is_kbxwpbot_active(){
	if ( defined( 'KBX_WP_CHATBOT' ) && (KBX_WP_CHATBOT == '1') ) {
		return true;
	}else{
		return false;
	}
}

//form builder support functions
if(!function_exists('qcwpbot_get_form_fb')){
	function qcwpbot_get_form_fb($formid, $sender){
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
}
if(!function_exists('qc_get_details_by_fieldid')){
	function qc_get_details_by_fieldid($form, $fieldid){

		$fields = $form['fields'];
		if(isset($fields[$fieldid])){
			return $fields[$fieldid];
		}else{
			return array();
		}

	}
}

if(!function_exists('qc_check_field_variables_ig')){
	function qc_check_field_variables_ig($form, $field, $variables, $entry, $session){
		global $wpdb;
		$formid = $form['ID'];
		if(isset($variables['keys'])){
			
			if($field['type']=='html'){

				foreach($variables['keys'] as $key=>$val){
					if (strpos($field['config']['default'], '%'.$val.'%') !== false) {
		
						$repval = trim(str_replace('%','', $variables['values'][$key]));
		
						//$result = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_form_entry_values where entry_id='".$entry."' and slug='".$repval."'");

						$result = array();
						$all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$session.'_data' );
						if( $all_answers && ! empty( $all_answers ) ){
							foreach( $all_answers as $answer ){
								if( $answer->slug == $repval ){
									$result = ($answer);
									break;
								}
							}
						}


						if(!empty($result)){
							$field['config']['default'] = str_replace('%'.$val.'%', $result->value, $field['config']['default']);
						}
					}
				}

			}else{
				foreach($variables['keys'] as $key=>$val){
					if (strpos($field['label'], '%'.$val.'%') !== false) {
						
						$repval = trim(str_replace('%','', $variables['values'][$key]));
		
						//$result = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_form_entry_values where entry_id='".$entry."' and slug='".$repval."'");
						
						$result = array();
						$all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$session.'_data' );
						
						if( $all_answers && ! empty( $all_answers ) ){
							
							foreach( $all_answers as $answer ){
								
								if( $answer->slug == $repval ){
									
									$result = $answer;
									break;
								}
							}
							
						}

						if(!empty($result)){
							$field['label'] = str_replace('%'.$val.'%', $result->value, $field['label']);
						}
					}
				}
			}



		}

		return $field;

	}
}

if(!function_exists('qcwpbot_capture_form_value_ig')){
	function qcwpbot_capture_form_value_ig($formid, $fieldid, $answer, $entry, $sender){
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

		$result = qcbot_conv_cookies_get( $formid.'_'.$sender );
		if( ! $result || empty( $result ) ){
			$result = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_forms where form_id='".$formid."' and type='primary'");
		}
		$form = unserialize($result->config);
		
		
		$processors = (isset($form['processors'])?$form['processors']:array());
		
		$mailer = (isset($form['mailer'])?$form['mailer']:array());
		
		$variables = isset($form['variables'])?$form['variables']:array();

		$fieldetails = qc_get_details_by_fieldid($form, $fieldid);

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
				qcbot_conv_cookies_data_set( $formid.'_'.$sender.'_data', $data );
			}else{
				$data[] = array(
					'entry_id'  => $entry,
					'field_id'   => $fieldid,
					'slug'	=> (isset($fieldetails['slug'])?$fieldetails['slug']:''),
					'value'	=> stripslashes($answer)
				);
				qcbot_conv_cookies_data_set( $formid.'_'.$sender.'_data', $data );
			}
			
		}

		$fields = $form['fields'];
		$conditions = array();
		if(isset($form['conditional_groups']['conditions'])){
			$conditions = $form['conditional_groups']['conditions'];
		}

		
		if(isset($form['layout_grid']['fields']) && !empty($form['layout_grid']['fields'])){
			
			$nextfield = qc_get_next_field($form, $fieldid, $entry, $sender);
			

			if($nextfield!='none' && $nextfield!='' && !empty($fields[$nextfield])){
				
				$field = $fields[$nextfield];
				$field = qc_check_field_variables_ig($form, $field, $variables, $entry, $sender);
				$field['entry'] = $entry;
				$field['status'] = 'incomplete';
				if($field['type']=='calculation'){
					$field = qc_formbuilder_do_calculation($field, $entry, $form, $sender);
				}else if( $field['type']=='html' ){
					$field['config']['default'] =  $field['config']['default'];
				}
				
				return $field;

			}else{
				
				if(isset($mailer['on_insert']) && $mailer['on_insert']==1){
					$answers = qc_form_answer($form, $fields, $entry, $sender);
					if( !empty( $answers ) ){
						qcld_wb_chatbot_send_form_query($answers, $mailer, $formid, $sender);
					}
					
				}
				
				if(!empty($processors) && isset($processors[qc_array_key_first($processors)]['runtimes'])){
					$entrydetails = qc_form_entry_details($form, $fields, $entry, $sender);
					qcld_wb_chatbot_send_autoresponse($entrydetails, $processors, $formid, $sender);
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

				$all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$sender.'_data' );
				
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
				$answers = qc_form_answer($form, $fields, $entry, $sender);
				qcld_wb_chatbot_send_form_query($answers, $mailer, $formid, $sender);
			}

			if(!empty($processors) && isset($processors[qc_array_key_first($processors)]['runtimes'])){
				$entrydetails = qc_form_entry_details($form, $fields, $entry, $sender);
				qcld_wb_chatbot_send_autoresponse($entrydetails, $processors, $formid, $sender);
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
			$all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$sender.'_data' );
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
			qcbot_conv_cookies_data_delete( $formid.'_'.$sender.'_data' );
			qcbot_conv_cookies_data_delete( $formid.'_'.$sender );
			
			return array('status'=>'complete');
		}
		
		die();
	}
}

function qcld_handle_formbuilder_response_ig($get_formidby_keyword, $sender, $access_token){
	
	$jsonData = '{
		"recipient":{
			"id":"'.$sender.'"
		},
		"sender_action":"typing_on"
	}';
	qcpd_wpig_send_ig_reply($jsonData, $access_token);
	sleep(2);
	
	update_option($sender.'_conversational_form', 'active');
	update_option($sender.'_conversational_form_id', $get_formidby_keyword);
	
	$formresponse = qcwpbot_get_form_fb($get_formidby_keyword, $sender);
	
	$fieldid = $formresponse['ID'];
	$formtype = $formresponse['type'];
	$formlabel = $formresponse['label'];
	update_option($sender.'_conversational_field_id', $fieldid);
	update_option($sender.'_conversational_field_entry', 0);
	
	if($formtype=='dropdown' || $formtype=='checkbox'){
		
		$fieldoptions = $formresponse['config']['option'];
		$all_faqs = array();
		foreach($fieldoptions as $fieldoption){
			$all_faqs[] = $fieldoption['value'];
		}
		
		$multiarray = array();
		while(!empty($all_faqs)){
			if(count($all_faqs)>3){
				$multiarray[] = array_slice($all_faqs, 0, 3);
				unset($all_faqs[0]);
				unset($all_faqs[1]);
				unset($all_faqs[2]);
				$all_faqs = array_values($all_faqs);
			}else{
				$multiarray[] = $all_faqs;
				unset($all_faqs);
				$all_faqs = array();
			}
		}

		$elementjson = '';
		foreach($multiarray as $element){
			$buttonjson = '';
			foreach($element as $button){
				$buttonjson .= '{
					"type":"postback",
					"title":"'.$button.'",
					"payload":"'.$button.'"
				},';
			}
			$elementjson .= '{
				"title": "'.$formlabel.'",
				"buttons": [
				  '.$buttonjson.'
				]
			  },';
			
		}
		
		$jsonData = '{
			"recipient":{
				"id":"'.$sender.'"
			},
			"message":{
				"attachment":{
				  "type":"template",
				  "payload":{
					"template_type":"generic",
					"elements":[
						'.$elementjson.'
					]
				  }
				}
			  }
		}';
		qcpd_wpig_send_ig_reply($jsonData, $access_token);exit;
		
	}elseif($formtype=='html'){
		$formlabel = $formresponse['config']['default'];
		$jsonData = '{
			"recipient":{
				"id":"'.$sender.'"
			},
			"message":{
				"text":"'.$formlabel.'"
			}
		}';
		qcpd_wpig_send_ig_reply($jsonData, $access_token);
		qcld_handle_cfb_next_ig('', $sender, $access_token);
		
	}else{
		$jsonData = '{
			"recipient":{
				"id":"'.$sender.'"
			},
			"message":{
				"text":"'.$formlabel.'"
			}
		}';
		qcpd_wpig_send_ig_reply($jsonData, $access_token);
		
	}
}

function qcld_handle_cfb_next_ig($answer, $sender, $access_token){
	
	$formid = get_option($sender.'_conversational_form_id');
	$fieldid = get_option($sender.'_conversational_field_id');
	$entry = get_option($sender.'_conversational_field_entry');
	
	$formresponse = qcwpbot_capture_form_value_ig($formid, $fieldid, $answer, $entry, $sender);
	
	if( $answer != '' ){
		$ccommands = array_map('qcnestedLowercase_ig', qc_get_formbuilder_form_commands());
		$cformid = qc_get_formbuilder_form_ids();
		$cforms = array_map('qcnestedLowercase_ig', qc_get_formbuilder_forms());
		$get_formidby_keyword = qcfindformid_ig($ccommands, $cforms, $cformid, strtolower($answer));
		if(!empty($cformid) && in_array($get_formidby_keyword, $cformid)){
			delete_option($sender.'_conversational_field_entry');
			delete_option($sender.'_conversational_field_id');
			delete_option($sender.'_conversational_form_id');
			delete_option($sender.'_conversational_form');
			qcld_handle_formbuilder_response_ig($get_formidby_keyword, $sender, $access_token);
			exit;
		}
	}

	if($formresponse['status']=='incomplete'){
		update_option($sender.'_conversational_field_entry', $formresponse['entry']);
		update_option($sender.'_conversational_field_id', $formresponse['ID']);
		
		$formtype = $formresponse['type'];
		$formlabel = $formresponse['label'];
		
		
		if($formtype=='dropdown' || $formtype=='checkbox'){			
			$fieldoptions = $formresponse['config']['option'];
			$all_faqs = array();
			foreach($fieldoptions as $fieldoption){
				$all_faqs[] = $fieldoption['value'];
			}
			
			$multiarray = array();
			while(!empty($all_faqs)){
				if(count($all_faqs)>3){
					$multiarray[] = array_slice($all_faqs, 0, 3);
					unset($all_faqs[0]);
					unset($all_faqs[1]);
					unset($all_faqs[2]);
					$all_faqs = array_values($all_faqs);
				}else{
					$multiarray[] = $all_faqs;
					unset($all_faqs);
					$all_faqs = array();
				}
			}

			$elementjson = '';
			foreach($multiarray as $element){
				$buttonjson = '';
				foreach($element as $button){
					$buttonjson .= '{
						"type":"postback",
						"title":"'.$button.'",
						"payload":"'.$button.'"
					},';
				}
				$elementjson .= '{
					"title": "'.$formlabel.'",
					"buttons": [
					  '.$buttonjson.'
					]
				  },';
				
			}
			
			$jsonData = '{
				"recipient":{
					"id":"'.$sender.'"
				},
				"message":{
					"attachment":{
					  "type":"template",
					  "payload":{
						"template_type":"generic",
						"elements":[
							'.$elementjson.'
						]
					  }
					}
				  }
			}';
			qcpd_wpig_send_ig_reply($jsonData, $access_token);exit;
			
			
		}elseif($formtype=='html'){
			$formlabel = $formresponse['config']['default'];
			$jsonData = '{
				"recipient":{
					"id":"'.$sender.'"
				},
				"message":{
					"text":"'.$formlabel.'"
				}
			}';
			qcpd_wpig_send_ig_reply($jsonData, $access_token);
			qcld_handle_cfb_next_ig('', $sender, $access_token);
			
		}elseif($formtype=='calculation'){
			
			$formlabel = $formresponse['calresult'];
			$jsonData = '{
				"recipient":{
					"id":"'.$sender.'"
				},
				"message":{
					"text":"'.$formlabel.'"
				}
			}';
			qcpd_wpig_send_ig_reply($jsonData, $access_token);
			qcld_handle_cfb_next_ig($formresponse['calvalue'], $sender, $access_token);
			
		}elseif($formtype=='hidden'){
			qcld_handle_cfb_next_ig($formresponse['config']['default'], $sender, $access_token);
			
		}else{
			$jsonData = '{
				"recipient":{
					"id":"'.$sender.'"
				},
				"message":{
					"text":"'.$formlabel.'"
				}
			}';
			qcpd_wpig_send_ig_reply($jsonData, $access_token);exit;
		}
		
		
	}else{
		delete_option($sender.'_conversational_field_entry');
		delete_option($sender.'_conversational_field_id');
		delete_option($sender.'_conversational_form_id');
		delete_option($sender.'_conversational_form');
		exit;
	}
	
}

function qcld_wpbo_search_response_ig($keyword){
	global $wpdb;
	$keyword = sanitize_text_field($keyword);
	$table = $wpdb->prefix.'wpbot_response';
	
	$response_result = array();

	$status = array('status'=>'fail', 'multiple'=>false);
	
	$results = $wpdb->get_row("SELECT `query`, `response` FROM `$table` WHERE 1 and `intent` = '".$keyword."'");

	if(!empty($results)){
		$response_result[] = array('query'=>$results->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?$results->response:$results->response ), 'score'=>1);
	}
	
	

	if(empty($response_result)){
		$results = $wpdb->get_results("SELECT `query`, `response` FROM `$table` WHERE 1 and `query` = '".$keyword."'");
		if(!empty($results)){
			foreach($results as $result){
				
				$response_result[] = array('query'=>$result->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?$result->response:$result->response ), 'score'=>1);
				
			}
		}
	}
	
	if(class_exists('Qcld_str_pro')){
		if(get_option('qc_bot_str_remove_stopwords') && get_option('qc_bot_str_remove_stopwords')==1){
			$keyword = qc_strpro_remove_stopwords($keyword);
		}
	}
	
	
	if(empty($response_result)){

		$fields = get_option('qc_bot_str_fields');
		if($fields && is_array( $fields ) && !empty($fields) && class_exists('Qcld_str_pro')){
			$qfields = implode(', ', $fields);
		}else{
			$qfields = '`query`,`keyword`,`response`';
		}
		
		$results = $wpdb->get_results("SELECT `query`, `response`, MATCH($qfields) AGAINST('".$keyword."' IN NATURAL LANGUAGE MODE) as score FROM $table WHERE MATCH($qfields) AGAINST('".$keyword."' IN NATURAL LANGUAGE MODE) order by score desc limit 15");

		$weight = get_option('qc_bot_str_weight')!=''?get_option('qc_bot_str_weight'):'0.4';
		//$weight = 0;
		if(!empty($results)){
			foreach($results as $result){
				if($result->score >= $weight){
					$response_result[] = array('query'=>$result->query, 'response'=> (get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?$result->response:$result->response ), 'score'=>$result->score);
				}
			}
		}
	}
	
	//like search
	if(empty($response_result)){
		$results = $wpdb->get_results("SELECT * FROM `$table` WHERE `query` REGEXP '".$keyword."'");

		$weight = get_option('qc_bot_str_weight')!=''?get_option('qc_bot_str_weight'):'0.4';
		//$weight = 0;
		if(!empty($results)){
			foreach($results as $result){
				if(1 >= $weight){
					$response_result[] = array('query'=>$result->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?$result->response:$result->response ), 'score'=>1);
				}
			}
		}
	}

/*
	if(empty( $response_result ) && class_exists('Qcld_str_pro') && in_array('keyword', get_option('qc_bot_str_fields')) ){
		$results = $wpdb->get_results("SELECT * FROM `$table` WHERE FIND_IN_SET('".$keyword."', keyword)");

		$weight = get_option('qc_bot_str_weight')!=''?get_option('qc_bot_str_weight'):'0.4';
		//$weight = 0;
		if(!empty($results)){
			foreach($results as $result){
				if(1 >= $weight){
					$response_result[] = array('query'=>$result->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?$result->response:$result->response ), 'score'=>1);
				}
			}
		}
	}elseif( empty( $response_result ) && ! class_exists('Qcld_str_pro') ){
		$results = $wpdb->get_results("SELECT * FROM `$table` WHERE FIND_IN_SET('".$keyword."', keyword)");

		$weight = get_option('qc_bot_str_weight')!=''?get_option('qc_bot_str_weight'):'0.4';
		//$weight = 0;
		if(!empty($results)){
			foreach($results as $result){
				if(1 >= $weight){
					$response_result[] = array('query'=>$result->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?$result->response:$result->response ), 'score'=>1);
				}
			}
		}
	}
*/

	if(!empty($response_result)){

		if(count($response_result)>1){
			$status = array('status'=>'success', 'multiple'=>true, 'data'=>$response_result);
		}else{
			$status = array('status'=>'success', 'multiple'=>false, 'data'=>$response_result);
		}

	}
	return $status;

}