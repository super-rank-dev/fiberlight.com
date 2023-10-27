<?php
/*
* Main function for handleing facebook responses.
*/
function qcpd_wpfb_get_accesstoken_from_id($page_id){
	global $wpdb;
	$table = $wpdb->prefix.'wpbot_fb_pages';
    $page = $wpdb->get_row("SELECT * FROM {$table} where 1 and page_id = '".$page_id."'");
	return $page->page_access_token;
}

function qcld_wpbot_fb_page_details($page_id){
	global $wpdb;
	$table = $wpdb->prefix.'wpbot_fb_pages';
    $page = $wpdb->get_row("SELECT * FROM {$table} where 1 and page_id = '".$page_id."'");
	return $page;
}

function qcpd_wpfb_messenger_callback(){

	if(qcld_fb_get_option('wpfb_enable_fbbot')!='on' && ( !class_exists('qcld_wb_Chatbot') || !class_exists('QCLD_Woo_Chatbot') ) ){
		return;
	}
	
	$default_instruction = strip_tags(qcld_fb_get_option('wpfb_default_instruction'));
	if( class_exists('qcld_wb_Chatbot') ){
		$ccommands = array_map('qcnestedLowercase', qc_get_formbuilder_form_commands());
		$cformid = qc_get_formbuilder_form_ids();
		$cforms = array_map('qcnestedLowercase', qc_get_formbuilder_forms());
	}
	
	
	if(isset($_GET['action']) && $_GET['action']=='fbinteractionwow'){
		if(!class_exists('QCLD_Woo_Chatbot') && class_exists('qcld_wb_Chatbot')){
			$_GET['action'] = 'fbinteraction';
		}
	}
    

	$default_instruction = strip_tags(qcld_fb_get_option('wpfb_default_instruction'));
    if(isset($_GET['action']) && $_GET['action']=='fbinteraction'){
        
        $verify_token = qcld_fb_get_option('wpfb_verify_token');
        $hub_verify_token = null;

        if(isset($_REQUEST['hub_challenge'])) {
            $challenge = $_REQUEST['hub_challenge'];
            $hub_verify_token = $_REQUEST['hub_verify_token'];
        }


        if ($hub_verify_token === $verify_token) {
            echo $challenge;exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        $sender = $input['entry'][0]['messaging'][0]['sender']['id'];
        $message = $input['entry'][0]['messaging'][0]['message']['text'];
		$pageId = $input['entry'][0]['id'];
		$access_token = qcpd_wpfb_get_accesstoken_from_id($pageId);
        /**
         * Some Basic rules to validate incoming messages
         */
        if(isset($input['entry'][0]['messaging'][0]['message']) && $message!='' && ! isset($input['entry'][0]['messaging'][0]['message']['is_echo'])){
            // Normal message response part

			//code for menu
			if(strtolower($message)=='menu' || strtolower($message)=='help' || strtolower($message)=='start' || strtolower($message)==strtolower(qcld_fb_get_option('qlcd_wp_chatbot_sys_key_help')) ){
				
				delete_option($sender.'_feedback');
				delete_option($sender.'_phone');
				delete_option($sender.'_sitesearch');
				delete_option($sender.'_subscription');
				delete_option($sender.'_conversational_field_entry');
				delete_option($sender.'_conversational_field_id');
				delete_option($sender.'_conversational_form_id');
				delete_option($sender.'_conversational_form');
				
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);
				$jsonData = qcpd_wpfb_menu($sender, $access_token);

				qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                exit;
			}
			if(strtolower($message)=='get started'){
				
				delete_option($sender.'_feedback');
				delete_option($sender.'_phone');
				delete_option($sender.'_sitesearch');
				delete_option($sender.'_subscription');
				delete_option($sender.'_conversational_field_entry');
				delete_option($sender.'_conversational_field_id');
				delete_option($sender.'_conversational_form_id');
				delete_option($sender.'_conversational_form');
				
				$userinfo = qcpd_wpfb_userinfo($sender, $access_token);
				$jsonData = '{
					"recipient":{
						"id":"'.$sender.'"
					},
					"sender_action":"typing_on"
				}';
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);
				sleep(2);
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "message":{
                        "text":"Hi '.$userinfo->last_name.', '.$default_instruction.'"
                    }
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
			}
			
            // Send feedback, Email intent handleing
            if(qcld_fb_get_option($sender.'_feedback') && qcld_fb_get_option($sender.'_feedback')==1){
                if (filter_var($message, FILTER_VALIDATE_EMAIL)) {
					update_option($sender.'_feedback_email', $message);
                    $jsonData = qcpd_wpfb_email_feedback_2($sender);
                    qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;

                  } else {

                    $jsonData = qcpd_wpfb_email_feedback_1($sender);
                    qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
                    
                  }
                
            }
			
			// Handling site search intent
            if(qcld_fb_get_option($sender.'_sitesearch') && qcld_fb_get_option($sender.'_sitesearch')==1){
                delete_option($sender.'_sitesearch');
				$sitesearchresult = qcld_wpbo_search_site_fb($message);
				if($sitesearchresult['status']=='success'){

					$searchresults = $sitesearchresult['results'];
					$jsonmsg = '';
					foreach($searchresults as $result){
						$jsonmsg .= '{
							"title":"'.$result['title'].'",
							"image_url":"'.$result['imgurl'].'",
							"default_action": {
								"type": "web_url",
								"url": "'.$result['link'].'",
								"webview_height_ratio": "tall",
							  },
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
									'.$jsonmsg.'
								]
							  }
							}
						  }
					}';
					
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				}else{
					
					
					$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
					
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				}
                
            }
			
			// Handling site search intent
            if(qcld_fb_get_option($sender.'_prodsearch') && qcld_fb_get_option($sender.'_prodsearch')==1){
                delete_option($sender.'_prodsearch');
				
				$sitesearchresult = qcpd_wpfb_psearch_fnc($message);
				
				if($sitesearchresult['status']=='success'){

					$searchresults = $sitesearchresult['results'];
					$jsonmsg = '';
					foreach($searchresults as $result){
						$jsonmsg .= '{
							"title":"'.$result['title'].'",
							"subtitle": "'.html_entity_decode($result['subtitle']).'",
							
							"image_url":"'.$result['imgurl'].'",
							"default_action": {
								"type": "web_url",
								"url": "'.$result['link'].'",
								"webview_height_ratio": "tall",
							  },
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
									'.$jsonmsg.'
								]
							  }
							}
						  }
					}';
					
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				}else{
					$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
					
				}
				
            }
			
			
			
			// Email Subscription intent handleing
            if(qcld_fb_get_option($sender.'_subscription') && qcld_fb_get_option($sender.'_subscription')==1){
				delete_option($sender.'_subscription');
                if (filter_var($message, FILTER_VALIDATE_EMAIL)) {
                    $userinfo = qcpd_wpfb_userinfo($sender, $access_token);
					$email = $message;
					$jsonData = '{
						"recipient":{
							"id":"'.$sender.'"
						},
						"sender_action":"typing_on"
					}';
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);
					$subscriptionresult = qcld_wbfb_chatbot_email_subscription($userinfo->first_name.' '.$userinfo->last_name, $email);
					sleep(2);
					$jsonData = '{
						"recipient":{
							"id":"'.$sender.'"
						},
						"message":{
							"text":"'.wpbot_fb_msg_condition($subscriptionresult['msg']).'"
						}
					}';
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
                  } else {
                    $jsonData = qcpd_wpfb_email_subscription_1($sender, $access_token);
                    qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
                  }
                
            }
            if(qcld_fb_get_option($sender.'_feedback') && qcld_fb_get_option($sender.'_feedback')==2){
				update_option($sender.'_feedback_msg', $message);
                $jsonData = qcpd_wpfb_email_feedback_3($sender, $access_token);
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
            }

            //phone intent
            if(qcld_fb_get_option($sender.'_phone') && qcld_fb_get_option($sender.'_phone')==1){
                $jsonData = qcpd_wpfb_phonenumber_2($sender);
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
            }
			//handling conversation form builder response
			if(qcld_fb_get_option($sender.'_conversational_form') && qcld_fb_get_option($sender.'_conversational_form')!=''){
				
				qcld_handle_cfb_next($message, $sender, $access_token);exit;
				
			}

            //code for faq
            if(strtolower($message)=='faq'){
                $jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);
                $jsonData = qcpd_wpfb_faq($sender);
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
            }
			
			
			//code for faq
            if(strtolower($message)==strtolower(qcld_fb_get_option('wpfb_command_live_agent'))){
				
				qcpd_wpfb_pass_thread_control($sender, $access_token);
				
				$msg = qcld_fb_get_option('wpfb_contact_admin_text');
				
                $jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);
                $jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "message":{
                        "text":"'.wpbot_fb_msg_condition($msg).'"
                    }
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
            }
			
			if(strtolower($message)==strtolower(qcld_fb_get_option('qlcd_wp_chatbot_sys_key_catalog') != '' ? qcld_fb_get_option('qlcd_wp_chatbot_sys_key_catalog') : 'catalog')){
				
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);				
				$jsonData = qcld_wpfb_product_catalog_bot($sender, $access_token);
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				
			}
			//conversational form support
			
			$get_formidby_keyword = qcfindformid($ccommands, $cforms, $cformid, strtolower($message));
			
			if(!empty($cformid) && in_array($get_formidby_keyword, $cformid)){
				
				qcld_handle_formbuilder_response($get_formidby_keyword, $sender, $access_token);
				
				exit;
			}
			
			
			
            //dialogflow part
            // sending typing_on response
            $jsonData = '{
                "recipient":{
                    "id":"'.$sender.'"
                },
                "sender_action":"typing_on"
            }';
            qcpd_wpfb_send_fb_reply($jsonData, $access_token);
            sleep(2);
			

			$st_response = qcld_wpbo_search_response_fb($message);
			
			if($st_response['status']=='success'){
				
				$jsonData = '{
					"recipient":{
						"id":"'.$sender.'"
					},
					"message":{
						"text":"'.$st_response['data'][0]['response'].'"
					}
				}';
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				
			}
			
			
			
			if( qcld_fb_get_option('enable_wp_chatbot_dailogflow') && qcld_fb_get_option('enable_wp_chatbot_dailogflow') == 1 ){
				//get reply for the msg from df
				if(qcld_fb_get_option('wp_chatbot_df_api') && qcld_fb_get_option('wp_chatbot_df_api')=='v2'){
					$jsonData = qcpd_wpfb_get_response_from_dfv2($message, $sender, $access_token);
				}else{
					$jsonData = qcpd_wpfb_get_response_from_df($message, $sender, $access_token);
				}
				//prepairing the jsondata for facebook
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
			}

			if( ! get_option( 'wpbot_fb_search_enable' ) || get_option( 'wpbot_fb_search_enable' ) !=1 ){

				//default site search
				$sitesearchresult = qcld_wpbo_search_site_fb($message);
							
				if($sitesearchresult['status']=='success'){

					$searchresults = $sitesearchresult['results'];
					$jsonmsg = '';
					foreach($searchresults as $result){
						$jsonmsg .= '{
							"title":"'.$result['title'].'",
							"image_url":"'.$result['imgurl'].'",
							"default_action": {
								"type": "web_url",
								"url": "'.$result['link'].'",
								"webview_height_ratio": "tall",
								},
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
									'.$jsonmsg.'
								]
								}
							}
							}
					}';
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);
					exit;
				}else{
					
					$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
					
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);				
					exit;
				}

			}else{

				$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));	
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);				
				exit;

			}

            
        }elseif(isset($input['entry'][0]['messaging'][0]['postback'])){
            //Postback button response handleing part.

            $postbacktitle = $input['entry'][0]['messaging'][0]['postback']['title'];
            $postbackpayload = $input['entry'][0]['messaging'][0]['postback']['payload'];
            $all_faqs = maybe_unserialize( qcld_fb_get_option('support_query'));
			//FOR faq answer payload
			
			if(strtolower($postbackpayload)=='qc-first-handshake'){
				delete_option($sender.'_feedback');
				delete_option($sender.'_phone');
				delete_option($sender.'_sitesearch');
				delete_option($sender.'_subscription');
				delete_option($sender.'_conversational_field_entry');
				delete_option($sender.'_conversational_field_id');
				delete_option($sender.'_conversational_form_id');
				delete_option($sender.'_conversational_form');
				$userinfo = qcpd_wpfb_userinfo($sender, $access_token);
				$jsonData = '{
					"recipient":{
						"id":"'.$sender.'"
					},
					"sender_action":"typing_on"
				}';
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);
				sleep(2);
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "message":{
                        "text":"Hi '.$userinfo->last_name.', '.$default_instruction.'"
                    }
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				
			}
			
			if(qcld_fb_get_option($sender.'_conversational_form') && qcld_fb_get_option($sender.'_conversational_form')!=''){
				$jsonData = '{
					"recipient":{
						"id":"'.$sender.'"
					},
					"sender_action":"typing_on"
				}';
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);
				sleep(2);
				qcld_handle_cfb_next($postbackpayload, $sender, $access_token);exit;
				
			}
			
			$get_formidby_keyword = qcfindformid($ccommands, $cforms, $cformid, strtolower($postbackpayload));
			if(!empty($cformid) && in_array($get_formidby_keyword, $cformid)){
				$jsonData = '{
					"recipient":{
						"id":"'.$sender.'"
					},
					"sender_action":"typing_on"
				}';
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);
				sleep(2);
				qcld_handle_formbuilder_response($get_formidby_keyword, $sender, $access_token);
				
				exit;
			}

            if(in_array($postbackpayload, $all_faqs)){
				
                $faqkey = array_search ($postbackpayload, $all_faqs);
                $faqans = maybe_unserialize(qcld_fb_get_option('support_ans'));

                $jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);

                $jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "message":{
                        "text":"'.wpbot_fb_msg_condition(strip_tags($faqans[$faqkey])).'"
                    }
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
            }elseif(strtolower($postbackpayload)==strtolower(qcld_fb_get_option('qlcd_wp_chatbot_sys_key_support') != '' ? qcld_fb_get_option('qlcd_wp_chatbot_sys_key_support') : 'FAQ')){
				
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);
                $jsonData = qcpd_wpfb_faq($sender);
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				
			}elseif(strtolower($postbackpayload)==strtolower(qcld_fb_get_option('qlcd_wp_site_search') != '' ? qcld_fb_get_option('qlcd_wp_site_search') : 'Site Search')){
				
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);
                $jsonData = qcpd_wpfb_site_search_1($sender, $access_token);
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				
			}elseif(strtolower($postbackpayload)== strtolower(qcld_fb_get_option('qlcd_wp_chatbot_support_phone'))){
				$jsonData = qcpd_wpfb_phonenumber_1($sender);
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
			}elseif(strtolower($postbackpayload)== strtolower(qcld_fb_get_option('qlcd_wp_send_us_email'))){
				$jsonData = qcpd_wpfb_email_feedback_1($sender);
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
			}elseif(strtolower($postbackpayload)== strtolower(qcld_fb_get_option('qlcd_wp_leave_feedback'))){
				$jsonData = qcpd_wpfb_email_feedback_1($sender);
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
			}elseif(strtolower($postbackpayload)== strtolower(qcld_fb_get_option('qlcd_wp_email_subscription'))){
				$jsonData = qcpd_wpfb_email_subscription_1($sender, $access_token);
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
			}elseif(qcld_fb_get_option('qlcd_wp_chatbot_wildcard_product') && !empty(maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_wildcard_product'))) && in_array($postbackpayload, maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_wildcard_product')))){
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);
				$msgtxt = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_product_asking'));
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "message":{
                        "text":"'.wpbot_fb_msg_condition($msgtxt[array_rand($msgtxt)]).'"
                    }
                }';
				update_option($sender.'_prodsearch', 1);
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				
			}elseif(qcld_fb_get_option('qlcd_wp_chatbot_featured_products') && !empty(maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_featured_products'))) && in_array($postbackpayload, maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_featured_products')))){
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);
				
				$sitesearchresult = qcld_wpfb_chatbot_keyword_featured();
				if($sitesearchresult['status']=='success'){

					$searchresults = $sitesearchresult['results'];
					
					$jsonmsg = '';
					foreach($searchresults as $result){
						$jsonmsg .= '{
							"title":"'.$result['title'].'",
							"subtitle": "'.html_entity_decode($result['subtitle']).'",
							
							"image_url":"'.$result['imgurl'].'",
							"default_action": {
								"type": "web_url",
								"url": "'.$result['link'].'",
								"webview_height_ratio": "tall",
							  },
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
									'.$jsonmsg.'
								]
							  }
							}
						  }
					}';
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				}else{
					$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				}
                
				
			}elseif(qcld_fb_get_option('qlcd_wp_chatbot_sale_products') && !empty(maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_sale_products'))) && in_array($postbackpayload, maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_sale_products')))){
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);
				
				$sitesearchresult = qcld_wpfb_chatbot_keyword_sale();
				
				
				if($sitesearchresult['status']=='success'){

					$searchresults = $sitesearchresult['results'];
					$jsonmsg = '';
					foreach($searchresults as $result){
						$jsonmsg .= '{
							"title":"'.$result['title'].'",
							"subtitle": "'.html_entity_decode($result['subtitle']).'",
							
							"image_url":"'.$result['imgurl'].'",
							"default_action": {
								"type": "web_url",
								"url": "'.$result['link'].'",
								"webview_height_ratio": "tall",
							  },
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
									'.$jsonmsg.'
								]
							  }
							}
						  }
					}';
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				}else{
					$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				}
				
			}elseif(qcld_fb_get_option('qlcd_wp_chatbot_wildcard_catalog') && !empty(maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_wildcard_catalog'))) && in_array($postbackpayload, maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_wildcard_catalog')))){
				
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);				
				$jsonData = qcld_wpfb_product_catalog_bot($sender, $access_token);
				qcpd_wpfb_send_fb_reply($jsonData, $access_token);
				exit;
				
			}elseif(strpos($postbackpayload, 'catalogid') !== false){
				$postbackpayload = str_replace('_catalogid', '', $postbackpayload);
				
				$jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);				
				$sitesearchresult = qcld_wp_chatbot_catalog_mca($postbackpayload);
				
				if($sitesearchresult['status']=='success'){

					$searchresults = $sitesearchresult['results'];
					$jsonmsg = '';
					foreach($searchresults as $result){
						$jsonmsg .= '{
							"title":"'.$result['title'].'",
							"subtitle": "'.html_entity_decode($result['subtitle']).'",
							
							"image_url":"'.$result['imgurl'].'",
							"default_action": {
								"type": "web_url",
								"url": "'.$result['link'].'",
								"webview_height_ratio": "tall",
							  },
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
									'.$jsonmsg.'
								]
							  }
							}
						  }
					}';
					
				}else{
					$jsonData = '{
						"recipient":{
							"id":"'.$sender.'"
						},
						"message":{
							"text":"'.wpbot_fb_msg_condition($sitesearchresult['message']).'"
						}
					}';
				}
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				
			}
			else{
				
                $postbacktitle = $input['entry'][0]['messaging'][0]['postback']['title'];
                $postbackpayload = $input['entry'][0]['messaging'][0]['postback']['payload'];
                $jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "sender_action":"typing_on"
                }';
                qcpd_wpfb_send_fb_reply($jsonData, $access_token);
                sleep(2);

				
				$st_response = qcld_wpbo_search_response_fb($postbackpayload);
				
				if($st_response['status']=='success'){
					$jsonData = '{
						"recipient":{
							"id":"'.$sender.'"
						},
						"message":{
							"text":"'.$st_response['data'][0]['response'].'"
						}
					}';
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				}else{
					$jsonData = qcpd_wpfb_get_response_from_dfv2($postbackpayload, $sender, $access_token);
					qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
				}
				
            }


        }else{
			
			$type = $input['entry'][0]['changes'][0]['field'];
			$verb = $input['entry'][0]['changes'][0]['value']['verb'];
			
			if($type=='feed' && $verb == 'add'){
				
				$fromID = $input['entry'][0]['changes'][0]['value']['from']['id'];
				$fromName = $input['entry'][0]['changes'][0]['value']['from']['name'];
				$message = $input['entry'][0]['changes'][0]['value']['message'];
				$postID = $input['entry'][0]['changes'][0]['value']['post_id'];
				$commentID = $input['entry'][0]['changes'][0]['value']['comment_id'];
				$parent_id = $input['entry'][0]['changes'][0]['value']['parent_id'];
				$postcontent = qcwp_get_fbpost_content($postID, $access_token);
				$message_tags = array();
				$message_data = wpfb_get_comment_mentions_attachment( $commentID, $access_token );
				if( ! empty( $message_data['message_tags'] ) ){
					$message_tags = $message_data['message_tags'];
				}
				$is_image = false;
				if( isset( $message_data['attachment'] ) ){
					$is_image = true;
				}
				
				$checkposts = get_posts(array(
					'numberposts'	=> -1,
					'post_type'		=> 'wpfbposts',
					'meta_key'		=> 'fb_post_id',
					'meta_value'	=> $postID
				));
				
				if(!empty($checkposts) && $fromID !== $pageId && $postID == $parent_id ){
					
					$post_id = ($checkposts[0]->ID);
					
					
					$enable_private_reply_from_df = get_post_meta( $post_id, 'enable_private_reply_from_df', true );
					$enable_comment_reply_from_df = get_post_meta( $post_id, 'enable_comment_reply_from_df', true );
					
					$comment_reply = get_post_meta( $post_id, 'comment_reply', true );
					$comment_reply_is_condition_array = get_post_meta( $post_id, 'comment_reply_is_condition', true );
					$comment_reply_condition_array = get_post_meta( $post_id, 'comment_reply_condition', true );
					$comment_condition_value_array = get_post_meta( $post_id, 'comment_condition_value', true );
					$comment_reply_text_array = get_post_meta( $post_id, 'comment_reply_text', true );
					
					$private_reply = get_post_meta( $post_id, 'private_reply', true );

					$private_reply_condition_array = get_post_meta( $post_id, 'private_reply_condition', true );
					$reply_condition_array = get_post_meta( $post_id, 'reply_condition', true );
					$condition_value_array = get_post_meta( $post_id, 'condition_value', true );
					$reply_text_array = get_post_meta( $post_id, 'reply_text', true );
					
					//private Replies
					if($enable_private_reply_from_df=='on'){
						$askingdf = qcpd_wpfb_get_response_from_df_comment($postcontent);
						
						if(isset($askingdf['intent']) && $askingdf['intent']=='fbposts'){
							$anotherask = qcpd_wpfb_get_response_from_df_comment($askingdf['message'].' '.$message);
							$reply = "Hi $fromName, ".$anotherask['message'];
						}else{
							$anotherask = qcpd_wpfb_get_response_from_df_comment($message);
							$reply = 'Hi '.$fromName.', '.$anotherask['message'];
						}

						$jsonData = '{
							"recipient":{
								"comment_id":"'.$commentID.'"
							},
							"message":{
								"text":"'.$reply.'"
							}
						}';
						qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
						
						
					}else{
						
						if($private_reply=='on'){
							$send_reply = false;
							
							if ( ! empty( $private_reply_condition_array ) ) {
								foreach( $private_reply_condition_array as $ky => $vl ) {

									$private_reply_condition = $private_reply_condition_array[$ky];
									$reply_condition = $reply_condition_array[$ky];
									$condition_value = $condition_value_array[$ky];
									$reply_text = $reply_text_array[$ky];

									if($private_reply_condition==1){
										$send_reply = qcwpfb_is_condition_valid($reply_condition, $condition_value, $message, $message_tags, $is_image);
										
									}else{
										$send_reply = true;
									}
									
									if($send_reply){
										
										$reply_text = str_replace(array('[sender_name]', '[sender_comment]'),array($fromName, $message), $reply_text);
										
										//remove html & line breaks as it does not support
										$reply_text = strip_tags( $reply_text );
										$breaks = array("\r\n", "\n", "\r");
										$reply_text = str_replace($breaks, "", $reply_text);
		
										$jsonData = '{
											"recipient":{
												"comment_id":"'.$commentID.'"
											},
											"message":{
												"text":"'.$reply_text.'"
											}
										}';
										qcpd_wpfb_send_fb_reply($jsonData, $access_token);
										
										break;
										
									}

								}
							}
							
							
						}
						
					}
					
					//Comment Reply
					if($enable_comment_reply_from_df=='on'){
						$askingdf = qcpd_wpfb_get_response_from_df_comment($postcontent);
						
						if(isset($askingdf['intent']) && $askingdf['intent']=='fbposts'){
							$anotherask = qcpd_wpfb_get_response_from_df_comment($askingdf['message'].' '.$message);
							$reply = "Hi $fromName, ".$anotherask['message'];
						}else{
							$anotherask = qcpd_wpfb_get_response_from_df_comment($message);
							$reply = 'Hi '.$fromName.', '.$anotherask['message'];
						}
						
						$postfields = "message=$reply&access_token=$access_token";
						$url = "https://graph.facebook.com/v3.3/$commentID/comments";
						$res = qcwpbot_send_response($postfields, $url);
					}else{
						
						if($comment_reply=='on'){
							$send_reply = false;

							if ( ! empty( $comment_reply_is_condition_array ) ) {
								foreach( $comment_reply_is_condition_array as $ki => $ve ){
									$comment_reply_is_condition = $comment_reply_is_condition_array[$ki];
									$comment_reply_condition = $comment_reply_condition_array[$ki];
									$comment_condition_value = $comment_condition_value_array[$ki];
									$comment_reply_text = $comment_reply_text_array[$ki];

									if($comment_reply_is_condition==1){
										$send_reply = qcwpfb_is_condition_valid($comment_reply_condition, $comment_condition_value, $message, $message_tags, $is_image);
									}else{
										$send_reply = true;
									}
									
									if($send_reply){
										$comment_reply_text = str_replace(array('[sender_name]', '[sender_comment]'),array($fromName, $message), $comment_reply_text);
										
										$postfields = "message=".$comment_reply_text."&access_token=$access_token";
										$url = "https://graph.facebook.com/v3.3/$commentID/comments";
										$res = qcwpbot_send_response($postfields, $url);
										break;
									}

								}
							}
							
						}
						
					}

				}
				
				
				/*
				$handle = fopen('test2.txt', 'w');
				fwrite($handle, $res);
				fclose($handle);
				*/
				
				
			
			}
			
			
		}
        exit;
    }
	
}


/* Send reply to Facebook */
function qcpd_wpfb_send_fb_reply($jsonData, $access_token){
	
	$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;
	$jsonDataEncoded = $jsonData;
	/*
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($ch);
	*/
	
	$data = wp_remote_post($url, array(
		'headers'   => array('Content-Type' => 'application/json; charset=utf-8'),
		'body'      => $jsonDataEncoded,
		'method'    => 'POST'
	));
	return $data;
}

/*
* Get Userinfo
*/
function qcpd_wpfb_userinfo($sender, $access_token){
	return json_decode(wp_remote_fopen('https://graph.facebook.com/'.$sender.'?fields=first_name,last_name,profile_pic&access_token='.$access_token));
}

/* Get reply from dialogflow */
function qcpd_wpfb_get_response_from_df($query, $sender, $access_token){
	if($query!=''){
		$sessionid = 'qcpd_wpfb_df_session_id';
		$postData = array('query' => array($query), 'lang' => qcld_fb_get_option('qlcd_wp_chatbot_dialogflow_agent_language'), 'sessionId' => $sessionid);
		$jsonData = json_encode($postData);
		$v = date('Ymd');
		$ch = curl_init('https://api.api.ai/v1/query?v=v1');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '.qcld_fb_get_option('qlcd_wp_chatbot_dialogflow_client_token')));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);        
		curl_close($ch);

        $result = json_decode($result);
        $intent = $result->result->metadata->intentName;
        if($intent=='Default Fallback Intent'){
            //site search code. Checking if any result exists or not.
            $sitesearchresult = qcld_wpbo_search_site_fb($query);
            if($sitesearchresult['status']=='success'){

                $searchresults = $sitesearchresult['results'];
                $jsonmsg = '';
                foreach($searchresults as $result){
                    $jsonmsg .= '{
                        "title":"'.$result['title'].'",
                        "image_url":"'.$result['imgurl'].'",
                        "default_action": {
                            "type": "web_url",
                            "url": "'.$result['link'].'",
                            "webview_height_ratio": "tall",
                          },
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
                                '.$jsonmsg.'
                            ]
                          }
                        }
                      }
                }';
                return $jsonData;
            }else{
				
				
                $jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
                return $jsonData;
            }


        }elseif($intent=='faq'){
            //code for faq intent df
            return qcpd_wpfb_faq($sender);
        }elseif($intent=='email'){
            //feedback, send email intent
            return qcpd_wpfb_email_feedback_1($sender);
        }elseif($intent=='phone'){
            return qcpd_wpfb_phonenumber_1($sender);
        }elseif($intent=='email subscription'){
			return qcpd_wpfb_email_subscription_1($sender, $access_token);
		}elseif(is_object($result->result->fulfillment) && property_exists($result->result->fulfillment, 'messages')){
            //text reponse dialogflow
			if($result->result->fulfillment->messages[0]->type==0){

				if(strip_tags($result->result->fulfillment->messages[0]->speech)!=''){
					$jsonData = '{
						"recipient":{
							"id":"'.$sender.'"
						},
						"message":{
							"text":"'.wpbot_fb_msg_condition(strip_tags($result->result->fulfillment->messages[0]->speech)).'"
						}
					}';
					return $jsonData;
				}else{
					$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
					return $jsonData;
				}
				
                
            }elseif($result->result->fulfillment->messages[0]->type==2){
                //Quick Reply dialogflow
                $title = strip_tags($result->result->fulfillment->messages[0]->title);
                $replies = $result->result->fulfillment->messages[0]->replies;
                $replyjson = '';
                foreach($replies as $reply){
                    $replyjson .= '{
                        "type":"postback",
                        "title":"'.$reply.'",
                        "payload":"'.$reply.'"
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
                            "template_type":"button",
                            "text":"'.$title.'",
                            "buttons":[
                                '.$replyjson.'
                            ]
                          }
                        }
                    }
                }';
                return $jsonData;

            }elseif($result->result->fulfillment->messages[0]->type==1){
                //card response dialogflow
                $jsonmsg = '';
                foreach($result->result->fulfillment->messages as $message){
                    if($message->type==1){
                        $buttons = $message->buttons;
                        $jsonbtn = '';
                        foreach($buttons as $button){
                            $jsonbtn .= '{
                                "type":"web_url",
                                "url":"'.$button->postback.'",
                                "title":"'.$button->text.'"
                            },';
                            
                        }
                        $jsonmsg .= '{
                            "title":"'.$message->title.'",
                            "image_url":"'.$message->imageUrl.'",
                            "subtitle":"'.$message->subtitle.'",
                            
                            "buttons":[
                                '.$jsonbtn.'            
                            ]      
                        },';
                    }
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
                                '.$jsonmsg.'
                            ]
                          }
                        }
                      }
                }';
                return $jsonData;
            }
					
        }

	}
}


/* Get reply from dialogflow wowbot */
function qcpd_wpfb_get_response_from_dfwow($query, $sender, $access_token){
	if($query!=''){
		

		$sessionid = 'qcpd_wpfb_df_session_id_wowbot124512';
		$postData = array('query' => array($query), 'lang' => qcld_fb_get_option('qlcd_woo_chatbot_dialogflow_agent_language'), 'sessionId' => $sessionid);
		$jsonData = json_encode($postData);
		$v = date('Ymd');
		$ch = curl_init('https://api.api.ai/v1/query?v=v1');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '.qcld_fb_get_option('qlcd_woo_chatbot_dialogflow_client_token')));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);        
		curl_close($ch);

        $result = json_decode($result);
		
        $intent = $result->result->metadata->intentName;
        if($intent=='Default Fallback Intent' or $result->result->score ==0){
			
            //site search code. Checking if any result exists or not.
            $sitesearchresult = qcld_woo_chatbot_keyword_mca($query);
			
            if($sitesearchresult['status']=='success'){

                $searchresults = $sitesearchresult['results'];
                $jsonmsg = '';
                foreach($searchresults as $result){
                    $jsonmsg .= '{
                        "title":"'.$result['title'].'",
						"subtitle": "'.html_entity_decode($result['subtitle']).'",
						
                        "image_url":"'.$result['imgurl'].'",
                        "default_action": {
                            "type": "web_url",
                            "url": "'.$result['link'].'",
                            "webview_height_ratio": "tall",
                          },
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
                                '.$jsonmsg.'
                            ]
                          }
                        }
                      }
                }';
                return $jsonData;
            }else{
                $jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "message":{
                        "text":"'.wpbot_fb_msg_condition($sitesearchresult['message']).'"
                    }
                }';
                return $jsonData;
            }


        }elseif($intent=='featured'){
			
			$sitesearchresult = qcld_woo_chatbot_keyword_featured_mca();
			
            if($sitesearchresult['status']=='success'){

                $searchresults = $sitesearchresult['results'];
                $jsonmsg = '';
                foreach($searchresults as $result){
                    $jsonmsg .= '{
                        "title":"'.$result['title'].'",
						"subtitle": "'.html_entity_decode($result['subtitle']).'",
						
                        "image_url":"'.$result['imgurl'].'",
                        "default_action": {
                            "type": "web_url",
                            "url": "'.$result['link'].'",
                            "webview_height_ratio": "tall",
                          },
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
                                '.$jsonmsg.'
                            ]
                          }
                        }
                      }
                }';
                return $jsonData;
            }else{
                $jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "message":{
                        "text":"'.wpbot_fb_msg_condition($sitesearchresult['message']).'"
                    }
                }';
                return $jsonData;
            }
			
		}elseif($intent=='sale'){
			$sitesearchresult = qcld_woo_chatbot_keyword_sale_mca();
			
            if($sitesearchresult['status']=='success'){

                $searchresults = $sitesearchresult['results'];
                $jsonmsg = '';
                foreach($searchresults as $result){
                    $jsonmsg .= '{
                        "title":"'.$result['title'].'",
						"subtitle": "'.html_entity_decode($result['subtitle']).'",
						
                        "image_url":"'.$result['imgurl'].'",
                        "default_action": {
                            "type": "web_url",
                            "url": "'.$result['link'].'",
                            "webview_height_ratio": "tall",
                          },
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
                                '.$jsonmsg.'
                            ]
                          }
                        }
                      }
                }';
                return $jsonData;
            }else{
                $jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "message":{
                        "text":"'.wpbot_fb_msg_condition($sitesearchresult['message']).'"
                    }
                }';
                return $jsonData;
            }
		}elseif($intent=='support'){
            //code for faq intent df
            return qcpd_wpfb_support($sender);
        }elseif($intent=='feedback'){
            //feedback, send email intent
            return qcpd_wpfb_email_feedback_1_woo($sender);
        }elseif($intent=='phone'){
            return qcpd_wpfb_phonenumber_1_woo($sender);
        }elseif($intent=='email subscription'){
			return qcpd_wpfb_email_subscription_1_woo($sender, $access_token);
		}elseif($intent=='catalog'){

			return qcld_wpfb_product_catalog_wow($sender, $access_token);

		}elseif(property_exists($result->result->fulfillment, 'messages')){
			
            //text reponse dialogflow
			if($result->result->fulfillment->messages[0]->type==0){
                $jsonData = '{
                    "recipient":{
                        "id":"'.$sender.'"
                    },
                    "message":{
                        "text":"'.wpbot_fb_msg_condition(strip_tags($result->result->fulfillment->messages[0]->speech)).'"
                    }
                }';
                return $jsonData;
            }elseif($result->result->fulfillment->messages[0]->type==2){
                //Quick Reply dialogflow
                $title = strip_tags($result->result->fulfillment->messages[0]->title);
                $replies = $result->result->fulfillment->messages[0]->replies;
                $replyjson = '';
                foreach($replies as $reply){
                    $replyjson .= '{
                        "type":"postback",
                        "title":"'.$reply.'",
                        "payload":"'.$reply.'"
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
                            "template_type":"button",
                            "text":"'.$title.'",
                            "buttons":[
                                '.$replyjson.'
                            ]
                          }
                        }
                    }
                }';
                return $jsonData;

            }elseif($result->result->fulfillment->messages[0]->type==1){
                //card response dialogflow
                $jsonmsg = '';
                foreach($result->result->fulfillment->messages as $message){
                    if($message->type==1){
                        $buttons = $message->buttons;
                        $jsonbtn = '';
                        foreach($buttons as $button){
                            $jsonbtn .= '{
                                "type":"web_url",
                                "url":"'.$button->postback.'",
                                "title":"'.$button->text.'"
                            },';
                            
                        }
                        $jsonmsg .= '{
                            "title":"'.$message->title.'",
                            "image_url":"'.$message->imageUrl.'",
                            "subtitle":"'.$message->subtitle.'",
                            
                            "buttons":[
                                '.$jsonbtn.'            
                            ]      
                        },';
                    }
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
                                '.$jsonmsg.'
                            ]
                          }
                        }
                      }
                }';
                return $jsonData;
            }
					
        }

	}
}


function qcpd_wpfb_faq($sender){
    $faqjson = '';
    $all_faqs = maybe_unserialize( qcld_fb_get_option('support_query'));
	
	$welcomefaqs = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_support_welcome'));
	$welcomefaq = $welcomefaqs[array_rand($welcomefaqs)];
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
			"title": "'.$welcomefaq.'",
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
	
    return $jsonData;
}

function qcpd_wpfb_menu_global($sender, $access_token, $title){
	
	$faqjson = '';
 
	 $msgtextoutput = 'I am here to find what you need. What are you looking for?';
	 $default_msgs = qcld_fb_get_option('qlcd_wp_chatbot_wildcard_msg');
	 if($default_msgs!=''){
		 $default_msgs = array_filter(maybe_unserialize($default_msgs));
		 if(!empty($default_msgs)){
			 $msgtextoutput = $default_msgs[array_rand($default_msgs)];
			 $userinfo = qcpd_wpfb_userinfo($sender, $access_token);
			 $msgtextoutput = str_replace('%%username%%', $userinfo->last_name, $msgtextoutput);
		 }
	 }
	 
	 $phonetextarray = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_support_phone'));
	 $phonetxt = (qcld_fb_get_option('qlcd_wp_chatbot_support_phone') != '' ? qcld_fb_get_option('qlcd_wp_chatbot_support_phone') : 'Leave your number. We will call you back!');
	 
	 
	 $custom_intents_array = array_filter(maybe_unserialize( qcld_fb_get_option('qlcd_wp_custon_intent_label')));
	 
	 $all_faqs = array(
	 
		 (qcld_fb_get_option('qlcd_wp_email_subscription') != '' ? qcld_fb_get_option('qlcd_wp_email_subscription') : 'Email Subscription'),
		 (qcld_fb_get_option('qlcd_wp_chatbot_sys_key_support') != '' ? strtoupper(qcld_fb_get_option('qlcd_wp_chatbot_sys_key_support')) : 'FAQ'),
		 (qcld_fb_get_option('qlcd_wp_send_us_email') != '' ? qcld_fb_get_option('qlcd_wp_send_us_email') : 'Send Us Email'),
		 (qcld_fb_get_option('qlcd_wp_leave_feedback') != '' ? qcld_fb_get_option('qlcd_wp_leave_feedback') : 'Leave a Feedback'),
		 (qcld_fb_get_option('qlcd_wp_site_search')!=''?qcld_fb_get_option('qlcd_wp_site_search'):'Site Search'),
		 $phonetxt
	 );
	 
	 $all_faqs = array_merge($all_faqs, $custom_intents_array);
	 
	 
	 if(qcld_fb_get_option('qc_wpbot_fb_menu_order') && qcld_fb_get_option('qc_wpbot_fb_menu_order')!=''){
		 $startmenu = stripslashes(qcld_fb_get_option('qc_wpbot_fb_menu_order'));
		 preg_match_all("/\<\w[^<>]*?\>([^<>]+?\<\/\w+?\>)?|\<\/\w+?\>/i", $startmenu, $matches);
		 $newArray = array_map(function($v){
			 return trim(strip_tags($v));
		 }, $matches[0]);
		 $newArray = array_filter($newArray);
		 if(!empty($newArray)){
			 $all_faqs = $newArray;
		 }
	 }else{
		 if(qcld_fb_get_option('qc_wpbot_menu_order') && qcld_fb_get_option('qc_wpbot_menu_order')!=''){
			 $startmenu = stripslashes(qcld_fb_get_option('qc_wpbot_menu_order'));
			 preg_match_all("/\<\w[^<>]*?\>([^<>]+?\<\/\w+?\>)?|\<\/\w+?\>/i", $startmenu, $matches);
			 $newArray = array_map(function($v){
				 return trim(strip_tags($v));
			 }, $matches[0]);
			 $newArray = array_filter($newArray);
			 if(!empty($newArray)){
				 $all_faqs = $newArray;
			 }
		 }
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
			 if(!empty($all_faqs)){
				 $multiarray[] = $all_faqs;
				 unset($all_faqs);
				 $all_faqs = array();
			 }
			 
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
			 "title": "'.$title.'",
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
 
	 return $jsonData;
 }

function qcpd_wpfb_menu_global_wow($sender, $access_token, $title){
	
    $faqjson = '';
	
	$msgtext = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_wildcard_msg'));
	$userinfo = qcpd_wpfb_userinfo($sender, $access_token);
	
	$msgtextoutput = 'I am here to find what you need. What are you looking for?';
	
	$phonetextarray = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_support_phone'));
	$phonetxt = $phonetextarray[array_rand($phonetextarray)];
	if($phonetxt==''){
		$phonetxt = 'Leave your number. We will call you back!';
	}
	$sendfeedbackarray = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_feedback_label'));
	$sendfeedback = $sendfeedbackarray[array_rand($sendfeedbackarray)];
	
	$productarray = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_wildcard_product'));
	$product = $productarray[array_rand($productarray)];
	$featuredarray = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_featured_products'));
	$featured = $featuredarray[array_rand($featuredarray)];
	
	$salearray = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_sale_products'));
	$sale = $salearray[array_rand($salearray)];
	
	$custom_intents_array = array_filter(maybe_unserialize( qcld_fb_get_option('custom_intent_labels')));
	
    $all_faqs = array(
	
		(qcld_fb_get_option('qlcd_woo_email_subscription') != '' ? qcld_fb_get_option('qlcd_woo_email_subscription') : 'Email Subscription'),
		(qcld_fb_get_option('qlcd_woo_chatbot_sys_key_support') != '' ? ucfirst(qcld_fb_get_option('qlcd_woo_chatbot_sys_key_support')) : 'Support'),
		(qcld_fb_get_option('qlcd_woo_send_us_email') != '' ? qcld_fb_get_option('qlcd_woo_send_us_email') : 'Send Us Email'),
		$phonetxt,
		$sendfeedback,
		$product,
		$featured,
		$sale

	);
	
	if(!empty($custom_intents_array)){
		$all_faqs = array_merge($all_faqs, $custom_intents_array);
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
			"title": "'.$title.'",
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
	
	
    return $jsonData;
}
function qcpd_wpfb_menu_wow($sender, $access_token){
	$faqjson = '';
	
	$msgtext = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_wildcard_msg'));
	$userinfo = qcpd_wpfb_userinfo($sender, $access_token);
	
	$msgtextoutput = 'I am here to find what you need. What are you looking for?';
	
	$phonetextarray = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_support_phone'));
	$phonetxt = $phonetextarray[array_rand($phonetextarray)];
	if($phonetxt==''){
		$phonetxt = 'Leave your number. We will call you back!';
	}
	$sendfeedbackarray = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_feedback_label'));
	$sendfeedback = $sendfeedbackarray[array_rand($sendfeedbackarray)];
	
	$productarray = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_wildcard_product'));
	$product = $productarray[array_rand($productarray)];
	$featuredarray = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_featured_products'));
	$featured = $featuredarray[array_rand($featuredarray)];
	
	$salearray = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_sale_products'));
	$sale = $salearray[array_rand($salearray)];
	
	$custom_intents_array = array_filter(maybe_unserialize( qcld_fb_get_option('custom_intent_labels')));
	
    $all_faqs = array(
	
		(qcld_fb_get_option('qlcd_woo_email_subscription') != '' ? qcld_fb_get_option('qlcd_woo_email_subscription') : 'Email Subscription'),
		(qcld_fb_get_option('qlcd_woo_chatbot_sys_key_support') != '' ? ucfirst(qcld_fb_get_option('qlcd_woo_chatbot_sys_key_support')) : 'Support'),
		(qcld_fb_get_option('qlcd_woo_send_us_email') != '' ? qcld_fb_get_option('qlcd_woo_send_us_email') : 'Send Us Email'),
		$product,
		(qcld_fb_get_option('qlcd_woo_chatbot_sys_key_catalog') != '' ? ucfirst(qcld_fb_get_option('qlcd_woo_chatbot_sys_key_catalog')) : 'Catalog'),
		$featured,
		$sale,
		$phonetxt,
		$sendfeedback,
		

	);
	
	if(!empty($custom_intents_array)){
		$all_faqs = array_merge($all_faqs, $custom_intents_array);
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
			"title": "'.$msgtextoutput.'",
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
	

	
    return $jsonData;
}

function qcld_wpfb_product_catalog_wow($sender, $access_token){
	
	$msgtxt = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_product_suggest'));
	$message = $msgtxt[array_rand($msgtxt)];
	
	$terms =  get_terms( array('taxonomy' => 'product_cat','hide_empty' => true));
	$all_faqs = array();
	foreach ($terms as $term) {
        
        
		$all_faqs[] = array(
			'name'=> $term->name,
			'id'=> $term->term_id.'_catalogid'
		);
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
				"title":"'.$button['name'].'",
				"payload":"'.$button['id'].'"
			},';
		}
		$elementjson .= '{
			"title": "'.$message.'",
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
	 return $jsonData;
	
}

function qcpd_wpfb_menu($sender, $access_token){
	
    $faqjson = '';

	$msgtextoutput = 'I am here to find what you need. What are you looking for?';
	$default_msgs = qcld_fb_get_option('qlcd_wp_chatbot_wildcard_msg');
	if($default_msgs!=''){
		$default_msgs = array_filter(maybe_unserialize($default_msgs));
		if(!empty($default_msgs)){
			$msgtextoutput = $default_msgs[array_rand($default_msgs)];
			$userinfo = qcpd_wpfb_userinfo($sender, $access_token);
			$msgtextoutput = str_replace('%%username%%', $userinfo->last_name, $msgtextoutput);
		}
	}
	$msgtextoutput = wpbot_fb_msg_condition( $msgtextoutput );	
	$phonetextarray = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_support_phone'));
	$phonetxt = (qcld_fb_get_option('qlcd_wp_chatbot_support_phone') != '' ? qcld_fb_get_option('qlcd_wp_chatbot_support_phone') : 'Leave your number. We will call you back!');
	
	
	$custom_intents_array = array_filter(maybe_unserialize( qcld_fb_get_option('qlcd_wp_custon_intent_label')));
	
    $all_faqs = array(
	
		(qcld_fb_get_option('qlcd_wp_email_subscription') != '' ? qcld_fb_get_option('qlcd_wp_email_subscription') : 'Email Subscription'),
		(qcld_fb_get_option('qlcd_wp_chatbot_sys_key_support') != '' ? strtoupper(qcld_fb_get_option('qlcd_wp_chatbot_sys_key_support')) : 'FAQ'),
		(qcld_fb_get_option('qlcd_wp_send_us_email') != '' ? qcld_fb_get_option('qlcd_wp_send_us_email') : 'Send Us Email'),
		(qcld_fb_get_option('qlcd_wp_leave_feedback') != '' ? qcld_fb_get_option('qlcd_wp_leave_feedback') : 'Leave a Feedback'),
		(qcld_fb_get_option('qlcd_wp_site_search')!=''?qcld_fb_get_option('qlcd_wp_site_search'):'Site Search'),
		$phonetxt
	);
	
	$all_faqs = array_merge($all_faqs, $custom_intents_array);
	
	
	if(qcld_fb_get_option('qc_wpbot_fb_menu_order') && qcld_fb_get_option('qc_wpbot_fb_menu_order')!=''){
		$startmenu = stripslashes(qcld_fb_get_option('qc_wpbot_fb_menu_order'));
		preg_match_all("/\<\w[^<>]*?\>([^<>]+?\<\/\w+?\>)?|\<\/\w+?\>/i", $startmenu, $matches);
		$newArray = array_map(function($v){
			return trim(strip_tags($v));
		}, $matches[0]);
		$newArray = array_filter($newArray);
		if(!empty($newArray)){
			$all_faqs = $newArray;
		}
	}else{
		if(qcld_fb_get_option('qc_wpbot_menu_order') && qcld_fb_get_option('qc_wpbot_menu_order')!=''){
			$startmenu = stripslashes(qcld_fb_get_option('qc_wpbot_menu_order'));
			preg_match_all("/\<\w[^<>]*?\>([^<>]+?\<\/\w+?\>)?|\<\/\w+?\>/i", $startmenu, $matches);
			$newArray = array_map(function($v){
				return trim(strip_tags($v));
			}, $matches[0]);
			$newArray = array_filter($newArray);
			if(!empty($newArray)){
				$all_faqs = $newArray;
			}
		}
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
			if(!empty($all_faqs)){
				$multiarray[] = $all_faqs;
				unset($all_faqs);
				$all_faqs = array();
			}
			
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
			"title": "'.strip_tags( $msgtextoutput ).'",
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

    return $jsonData;
}
//for wowbot support
function qcpd_wpfb_support($sender){
    $faqjson = '';
    $all_faqs = maybe_unserialize( qcld_fb_get_option('support_query'));
	
	$all_faqs = array_merge($all_faqs);
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
			"title": "Welcome to Support Section",
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
    return $jsonData;
}


function qcpd_wpfb_email_feedback_1($sender){
    
    update_option($sender.'_feedback', 1);
    $texts = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_asking_email'));
    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"'.wpbot_fb_msg_condition($texts[array_rand($texts)]).'"
        }
    }';
    return $jsonData;
}

function qcpd_wpfb_site_search_1($sender, $access_token){
    
    update_option($sender.'_sitesearch', 1);
	
	$userinfo = qcpd_wpfb_userinfo($sender, $access_token);
	$texts = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_search_keyword'));
	$msgtextoutput = str_replace('#name',$userinfo->last_name, $texts[array_rand($texts)]);
	
    
    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"'.wpbot_fb_msg_condition($msgtextoutput).'"
        }
    }';
    return $jsonData;
}

function qcpd_wpfb_email_feedback_1_woo($sender){
    
    update_option($sender.'_feedback', 1);
    $texts = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_asking_email'));
    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"'.wpbot_fb_msg_condition($texts[array_rand($texts)]).'"
        }
    }';
    return $jsonData;
}
function qcpd_wpfb_email_feedback_2($sender){
    update_option($sender.'_feedback', 2);
    $texts = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_asking_msg'));
    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"'.wpbot_fb_msg_condition($texts[array_rand($texts)]).'"
        }
    }';
    return $jsonData;
}
function qcpd_wpfb_email_feedback_2_woo($sender){
    update_option($sender.'_feedback', 2);
    $texts = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_asking_msg'));
    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"'.wpbot_fb_msg_condition($texts[array_rand($texts)]).'"
        }
    }';
    return $jsonData;
}
function qcpd_wpfb_email_feedback_3($sender, $access_token){
    delete_option($sender.'_feedback');
	
	$userinfo = qcpd_wpfb_userinfo($sender, $access_token);
	
	$name = $userinfo->last_name;
	$email = qcld_fb_get_option($sender.'_feedback_email');
	$message = qcld_fb_get_option($sender.'_feedback_msg');

    $subject = 'Feedback from WPBot by Client';
    //Extract Domain
    $url = get_site_url();
    $url = parse_url($url);
    $domain = $url['host'];
    
    $admin_email = qcld_fb_get_option('admin_email');
    $toEmail = qcld_fb_get_option('qlcd_wp_chatbot_admin_email') != '' ? qcld_fb_get_option('qlcd_wp_chatbot_admin_email') : $admin_email;
    $fromEmail = "wordpress@" . $domain;
    //Starting messaging and status.
    $response['status'] = 'fail';
    $response['message'] = esc_html(str_replace('\\', '',qcld_fb_get_option('qlcd_wp_chatbot_email_fail')));

	//build email body
	$bodyContent = "";
	$bodyContent .= '<p><strong>' . esc_html__('Feedback Details', 'wpchatbot') . ':</strong></p><hr>';
	
	$bodyContent .= '<p>' . esc_html__('Name', 'wpfb') . ' : ' . esc_html($name) . '</p>';
	$bodyContent .= '<p>' . esc_html__('Email', 'wpfb') . ' : ' . esc_html($email) . '</p>';
	$bodyContent .= '<p>' . esc_html__('Message', 'wpfb') . ' : ' . esc_html($message) . '</p>';
	
		
	$bodyContent .= '<p>' . esc_html__('Mail Generated on', 'wpchatbot') . ': ' . date('F j, Y, g:i a') . '</p>';
	$to = $toEmail;
	$body = $bodyContent;

	$headers = array();
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	$headers[] = 'From: ' . esc_html($name) . ' <' . esc_html($fromEmail) . '>';

	wp_mail($to, $subject, $body, $headers);
	delete_option($sender.'_feedback_email');
	delete_option($sender.'_feedback_msg');
    $text = (qcld_fb_get_option('qlcd_wp_chatbot_email_sent') != '' ? qcld_fb_get_option('qlcd_wp_chatbot_email_sent') : 'Your email was sent successfully. Thanks!');

    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"'.wpbot_fb_msg_condition($text).'"
        }
    }';
    return $jsonData;
}
function qcpd_wpfb_email_feedback_3_woo($sender, $access_token){
	
    delete_option($sender.'_feedback');
	$userinfo = qcpd_wpfb_userinfo($sender, $access_token);
	
	$name = $userinfo->last_name;
	$email = qcld_fb_get_option($sender.'_feedback_email');
	$message = qcld_fb_get_option($sender.'_feedback_msg');

    $subject = 'Feedback from WoowBot by Client';
    //Extract Domain
    $url = get_site_url();
    $url = parse_url($url);
    $domain = $url['host'];
    
    $admin_email = qcld_fb_get_option('admin_email');
    $toEmail = qcld_fb_get_option('qlcd_woo_chatbot_admin_email') != '' ? qcld_fb_get_option('qlcd_woo_chatbot_admin_email') : $admin_email;
    $fromEmail = "wordpress@" . $domain;
    //Starting messaging and status.
    $response['status'] = 'fail';
    $response['message'] = esc_html(str_replace('\\', '',qcld_fb_get_option('qlcd_woo_chatbot_email_fail')));

	//build email body
	$bodyContent = "";
	$bodyContent .= '<p><strong>' . esc_html__('Feedback Details', 'wpchatbot') . ':</strong></p><hr>';
	
	$bodyContent .= '<p>' . esc_html__('Name', 'wpfb') . ' : ' . esc_html($name) . '</p>';
	$bodyContent .= '<p>' . esc_html__('Email', 'wpfb') . ' : ' . esc_html($email) . '</p>';
	$bodyContent .= '<p>' . esc_html__('Message', 'wpfb') . ' : ' . esc_html($message) . '</p>';
	
		
	$bodyContent .= '<p>' . esc_html__('Mail Generated on', 'wpchatbot') . ': ' . date('F j, Y, g:i a') . '</p>';
	$to = $toEmail;
	$body = $bodyContent;

	$headers = array();
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	$headers[] = 'From: ' . esc_html($name) . ' <' . esc_html($fromEmail) . '>';

	wp_mail($to, $subject, $body, $headers);
	delete_option($sender.'_feedback_email');
	delete_option($sender.'_feedback_msg');
	
    $text = (qcld_fb_get_option('qlcd_woo_chatbot_email_sent') != '' ? qcld_fb_get_option('qlcd_woo_chatbot_email_sent') : 'Your email was sent successfully.Thanks!');

    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"'.wpbot_fb_msg_condition($text).'"
        }
    }';
    return $jsonData;
}

function qcpd_wpfb_phonenumber_1($sender){
    update_option($sender.'_phone', 1);

    $texts = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_asking_phone'));

    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"'.wpbot_fb_msg_condition($texts[array_rand($texts)]).'"
        }
    }';
    return $jsonData;
}
function qcpd_wpfb_phonenumber_1_woo($sender){
    update_option($sender.'_phone', 1);

    $texts = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_asking_phone'));

    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"'.wpbot_fb_msg_condition($texts[array_rand($texts)]).'"
        }
    }';
    return $jsonData;
}

function qcpd_wpfb_phonenumber_2($sender){
    delete_option($sender.'_phone');
    $text = (qcld_fb_get_option('qlcd_wp_chatbot_phone_sent') != '' ? qcld_fb_get_option('qlcd_wp_chatbot_phone_sent') : 'Thanks for your phone number. We will call you ASAP!');
    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"'.wpbot_fb_msg_condition($text).'"
        }
    }';
    return $jsonData;
}
function qcpd_wpfb_phonenumber_2_woo($sender){
    delete_option($sender.'_phone');
    $text = (qcld_fb_get_option('qlcd_woo_chatbot_phone_sent') != '' ? qcld_fb_get_option('qlcd_woo_chatbot_phone_sent') : 'Thanks for your phone number. We will call you ASAP!');
    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"'.wpbot_fb_msg_condition($text).'"
        }
    }';
    return $jsonData;
}

function qcpd_wpfb_email_subscription_1($sender, $access_token){
    
    update_option($sender.'_subscription', 1);
    $texts = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_asking_email'));
	$userinfo = qcpd_wpfb_userinfo($sender, $access_token);
    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"Hello '.$userinfo->last_name.', '.wpbot_fb_msg_condition($texts[array_rand($texts)]).'"
        }
    }';
    return $jsonData;
}

function qcpd_wpfb_email_subscription_1_woo($sender, $access_token){
    
    update_option($sender.'_subscription', 1);
    $texts = maybe_unserialize(qcld_fb_get_option('qlcd_woo_chatbot_asking_email'));
	$userinfo = qcpd_wpfb_userinfo($sender, $access_token);
    $jsonData = '{
        "recipient":{
            "id":"'.$sender.'"
        },
        "message":{
            "text":"Hello '.$userinfo->last_name.', '.wpbot_fb_msg_condition($texts[array_rand($texts)]).'"
        }
    }';
    return $jsonData;
}


function qcld_wbfb_chatbot_email_subscription($name, $email) {
	
	global $wpdb;
	$table    = $wpdb->prefix.'wpbot_subscription';
	
	$name = $name;
	$email = $email;
	$url = '';
	$user_agent = '';
	
	$response = array();
	$response['status'] = 'fail';
	
	$query = $wpdb->prepare( 
	  "select * from $table where 1 and email = %s", 
	  $email
	);
	
	$email_exists = $wpdb->get_row($query);
	if(empty($email_exists)){
	
		$wpdb->query( $wpdb->prepare( " INSERT INTO $table ( date, name, email, url, user_agent ) VALUES ( %s, %s, %s, %s, %s ) ", array( date('Y-m-d H:i:s'), $name, $email, $url, $user_agent ) ) );
		
		$response['status'] = 'success';
		
		$texts = maybe_unserialize(qcld_fb_get_option('qlcd_wp_email_subscription_success'));
		$response['msg'] = $texts[array_rand($texts)];
	
	}else{
		$texts = maybe_unserialize(qcld_fb_get_option('qlcd_wp_email_already_subscribe'));
		$response['msg'] = $texts[array_rand($texts)];
	}
	
	return $response;
}
function qcld_wbfb_chatbot_email_subscription_woo($name, $email) {
	
	global $wpdb;
	$table    = $wpdb->prefix.'woobot_subscription';
	
	$name = $name;
	$email = $email;
	$url = '';
	$user_agent = '';
	
	$response = array();
	$response['status'] = 'fail';
	
	$query = $wpdb->prepare( 
	  "select * from $table where 1 and email = %s", 
	  $email
	);
	
	$email_exists = $wpdb->get_row($query);
	if(empty($email_exists)){
	
		$wpdb->query( $wpdb->prepare( " INSERT INTO $table ( date, name, email, url, user_agent ) VALUES ( %s, %s, %s, %s, %s ) ", array( date('Y-m-d H:i:s'), $name, $email, $url, $user_agent ) ) );
		
		$response['status'] = 'success';
		
		$texts = maybe_unserialize(qcld_fb_get_option('qlcd_woo_email_subscription_success'));
		$response['msg'] = $texts[array_rand($texts)];
	
	}else{
		$texts = maybe_unserialize(qcld_fb_get_option('qlcd_woo_email_already_subscribe'));
		$response['msg'] = $texts[array_rand($texts)];
	}
	
	return $response;
}

/*=====Common functions===========*/

/* WPBot MCA white label Addon check */
function qcld_woowbot_mca_is_active_white_label(){
	
	if(function_exists('qcpd_wpwl_white_label_dependencies')){
		return true;
	}else{
		return false;
	}

}

/* WPBot MCA white label Addon check */
function qcld_wpbot_mca_is_active_white_label(){
	
	if(function_exists('qcpd_wpwl_white_label_dependencies')){
		return true;
	}else{
		return false;
	}
	
}


function mca_wpbot_text(){

    if(qcld_wpbot_mca_is_active_white_label() && qcld_fb_get_option('wpwl_word_wpbot')!=''){
        return qcld_fb_get_option('wpwl_word_wpbot');
    }else{
        return 'WPBot';
    }

}

function mca_woowbot_text(){

    if(qcld_woowbot_mca_is_active_white_label() && qcld_fb_get_option('wpwo_word_wpbot')!=''){
        return qcld_fb_get_option('wpwo_word_wpbot');
    }else{
        return 'WoowBot';
    }

}

function qcpdmca_is_woowbot_active(){
	
	if(class_exists('QCLD_Woo_Chatbot')){
		return true;
	}else{
		return false;
	}

}

function qcpdmca_is_wpbot_active(){
	
	if(class_exists('qcld_wb_Chatbot')){
		return true;
	}else{
		return false;
	}
	
}


/* Send request for Get Started Button */
function qcpd_wpfb_get_started_button($access_token){
	$jsonData = '{ 
	  "get_started":{
		"payload":"qc-first-handshake"
	  }
	}';
	$url = 'https://graph.facebook.com/v2.6/me/messenger_profile?access_token='.$access_token;
	$ch = curl_init($url);
	$jsonDataEncoded = $jsonData;
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($ch);
	return $result;
}
/* Send request for Pass Thread control */
function qcpd_wpfb_pass_thread_control($sender, $access_token){
	$jsonData = '{
		"recipient":{
			"id":"'.$sender.'"
		},
		"target_app_id":"263902037430900"
	}';
	qcpd_wpfb_send_fb_reply($jsonData, $access_token);
	$url = 'https://graph.facebook.com/v2.6/me/pass_thread_control?access_token='.$access_token;
	/*
	$ch = curl_init($url);
	
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($ch);
	*/
	$jsonDataEncoded = $jsonData;
	$result = wp_remote_post($url, array(
		'headers'   => array(
						'Content-Type' => 'application/json; charset=utf-8'
					),
		'body'      => $jsonDataEncoded,
		'method'    => 'POST'
	));
}

function qcwpbot_send_response($postfields, $url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIfYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36");
	$res = curl_exec($ch);
	curl_close($ch);
	return $res;
}

function qcwpbot_delete_response($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_SSL_VERIfYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36");
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $result;
}

function qcpd_wpfb_get_response_from_df_comment($query=''){
	if($query!=''){

		$result = qc_df_v2_api($query);

        $result = json_decode($result, true);
		if(isset($result['queryResult']) && !empty($result['queryResult'])){
		
			$intent = $result['queryResult']['intent']['displayName'];
			$intent = $result->result->metadata->intentName;

			$message = $result->result->fulfillment->messages[0]->speech;

			if(isset($result['queryResult']['fulfillmentMessages']) && !empty($result['queryResult']['fulfillmentMessages'])){
				
				$dfmessages = $result['queryResult']['fulfillmentMessages'];
				foreach($dfmessages as $key => $message){
					
					if(isset($message['text'])){
						//text response
						$message = wpbot_fb_msg_condition(strip_tags($message['text']['text'][0]));
						
					}
					
				}

			}
			if( $message != '' ){
				return array(
					'intent'=> $intent,
					'message'=> $message
				);
			}
			
		}
	}
}

function qcwp_get_fbpost_content($postid, $access_token){
	
	$ch = curl_init();
	//curl_setopt($ch, CURLOPT_SSL_VERIfYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v3.3/$postid?access_token=$access_token");
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36");
	$res = curl_exec($ch);
	curl_close($ch);
	$res = json_decode($res, true);
	
	return $res['message'];
	
}

function qcwp_curl_fb_get($url){
	$ch = curl_init();
	//curl_setopt($ch, CURLOPT_SSL_VERIfYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36");
	$res = curl_exec($ch);
	curl_close($ch);
	return $res;
	
}

function wpbot_fb_msg_condition($text){
	if(qcld_fb_get_option('wpfb_remove_image') && qcld_fb_get_option('wpfb_remove_image')=='on'){
		
		$pattern = '~(http.*\.)(jpe?g|png|[tg]iff?|svg|gif)~i';
		preg_match_all($pattern,$text,$matches);
		if(!empty($matches) && !empty($matches[0])){
			foreach($matches[0] as $image){
				$text = str_replace($image, '', $text);
			}
		}


		
	}
	if(qcld_fb_get_option('wpfb_remove_video') && qcld_fb_get_option('wpfb_remove_video')=='on'){
		preg_match('~(?:https?://)?(?:www.)?(?:youtube.com|youtu.be)/(?:watch\?v=)?([^\s]+)~', $str, $match);
		if(!empty($match)){
			foreach($match as $youtube){
				$text = str_replace($youtube, '', $text);
			}
		}
	}
	$text = trim(preg_replace('/\s\s+/', ' ', $text));
	return $text;
}


/* broadcast create message creative */
function qcpd_wpfb_fb_broadcast_message_creative($jsonData, $access_token){
	
	$url = 'https://graph.facebook.com/v4.0/me/message_creatives?access_token='.$access_token;
	$ch = curl_init($url);
	$jsonDataEncoded = $jsonData;
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($ch);
}

/*broadcast a message to everyone that currently has an open conversation with your Page*/
function qcpd_wpfb_fb_broadcast_message($jsonData, $access_token){
	
	$url = 'https://graph.facebook.com/v5.0/me/broadcast_messages?access_token='.$access_token;
	$ch = curl_init($url);
	$jsonDataEncoded = $jsonData;
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($ch);
}

/*broadcast a message using send api*/
function qcpd_wpfb_fb_send_api($jsonData, $access_token){
	
	$url = 'https://graph.facebook.com/v5.0/me/messages?access_token='.$access_token;
	$ch = curl_init($url);
	$jsonDataEncoded = $jsonData;
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($ch);
	return $result;
}

function qcld_fb_get_option($key){
	$options = get_option( $key );
	if( $options ){

		$options = maybe_unserialize( $options );
		if( is_array( $options ) ){
			if( isset( $options[get_locale()] ) ){

				return $options[get_locale()];

			}else{
				return $options;
			}
		}else{
			return $options;
		}

	}else{
		return $options;
	}
}

/* WPBot Product Search function */
function qcpd_wpfb_psearch_fnc($keyword){
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

function qcld_wpfb_product_catalog_bot($sender, $access_token){
	
	$msgtxt = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_product_suggest'));
	$message = $msgtxt[array_rand($msgtxt)];
	
	$terms =  get_terms( array('taxonomy' => 'product_cat','hide_empty' => true));
	$all_faqs = array();
	foreach ($terms as $term) {

		$all_faqs[] = array(
			'name'=> $term->name,
			'id'=> $term->term_id.'_catalogid'
		);
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
				"title":"'.$button['name'].'",
				"payload":"'.$button['id'].'"
			},';
		}
		$elementjson .= '{
			"title": "'.strip_tags($message).'",
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
	 return $jsonData;
	
}

function qcnestedLowercase($value) {
    if (is_array($value)) {
        return array_map('qcnestedLowercase', $value);
    }
    return strtolower($value);
}

function qcfindformid($ccommands, $cforms, $cformid, $message){
	
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

function qcpd_remove_fb_stopwords($query, $stopwords){
	return preg_replace('/\b('.implode('|',$stopwords).')\b/','',$query);
}

/* Get reply from dialogflow V2 */
function qcpd_wpfb_get_response_from_dfv2($query, $sender, $access_token){
	if($query!=''){

		$result = qc_df_v2_api($query);

        $result = json_decode($result, true);
		
		if(isset($result['queryResult']) && !empty($result['queryResult'])){
		
			$intent = $result['queryResult']['intent']['displayName'];
			if($intent=='Default Fallback Intent'){
				
				//remove stop words
				
				if(qcld_fb_get_option('qlcd_wp_chatbot_stop_words') && qcld_fb_get_option('qlcd_wp_chatbot_stop_words')!=''){
					
					$stopwords = explode(',',qcld_fb_get_option('qlcd_wp_chatbot_stop_words'));
					$query = qcpd_remove_fb_stopwords($query, $stopwords);
					
				}
				
				
				//site search code. Checking if any result exists or not.
				$sitesearchresult = qcld_wpb_search_for_fb($query);
				
				
				
				if($sitesearchresult['status']=='success'){

					$searchresults = $sitesearchresult['results'];
					
					$jsonmsg = '';
					foreach($searchresults as $result){
						$jsonmsg .= '{
							"title":"'.$result['title'].'",
							"subtitle":"'.(isset($result['subtitle'])?html_entity_decode($result['subtitle']):'').'",
							"image_url":"'.str_replace('http://devel3', 'https://006f4eff.ngrok.io/',$result['imgurl']).'",
							"default_action": {
								"type": "web_url",
								"url": "'.str_replace('http://devel3', 'https://006f4eff.ngrok.io/',$result['link']).'",
								"webview_height_ratio": "tall",
							  },
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
									'.$jsonmsg.'
								]
							  }
							}
						  }
					}';
					return $jsonData;
				}else{
					
					
					$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
					return $jsonData;
				}


			}elseif($intent=='faq'){
				//code for faq intent df
				return qcpd_wpfb_faq($sender);
			}elseif($intent=='product'){
				
				if(isset($result['queryResult']['parameters']['products']) && $result['queryResult']['parameters']['products']!=''){
					$query = $result['queryResult']['parameters']['products'];
				}
				
				//site search code. Checking if any result exists or not.
				$sitesearchresult = qcpd_wpfb_psearch_fnc($query);
				
				if($sitesearchresult['status']=='success'){

					$searchresults = $sitesearchresult['results'];
					$jsonmsg = '';
					foreach($searchresults as $result){
						$jsonmsg .= '{
							"title":"'.$result['title'].'",
							"subtitle": "'.html_entity_decode($result['subtitle']).'",
							
							"image_url":"'.$result['imgurl'].'",
							"default_action": {
								"type": "web_url",
								"url": "'.$result['link'].'",
								"webview_height_ratio": "tall",
							  },
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
									'.$jsonmsg.'
								]
							  }
							}
						  }
					}';
					return $jsonData;
				}else{
					
					$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
					return $jsonData;
					
				}
				
				
				
			}elseif($intent=='featured'){
				
				
				$sitesearchresult = qcld_wpfb_chatbot_keyword_featured();
				
				if($sitesearchresult['status']=='success'){

					$searchresults = $sitesearchresult['results'];
					$jsonmsg = '';
					foreach($searchresults as $result){
						$jsonmsg .= '{
							"title":"'.$result['title'].'",
							"subtitle": "'.html_entity_decode($result['subtitle']).'",
							
							"image_url":"'.$result['imgurl'].'",
							"default_action": {
								"type": "web_url",
								"url": "'.$result['link'].'",
								"webview_height_ratio": "tall",
							  },
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
									'.$jsonmsg.'
								]
							  }
							}
						  }
					}';
					return $jsonData;
				}else{
					$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
					return $jsonData;
				}
				
			}elseif($intent=='sale'){
				
				$sitesearchresult = qcld_wpfb_chatbot_keyword_sale();
				
				if($sitesearchresult['status']=='success'){

					$searchresults = $sitesearchresult['results'];
					$jsonmsg = '';
					foreach($searchresults as $result){
						$jsonmsg .= '{
							"title":"'.$result['title'].'",
							"subtitle": "'.html_entity_decode($result['subtitle']).'",
							
							"image_url":"'.$result['imgurl'].'",
							"default_action": {
								"type": "web_url",
								"url": "'.$result['link'].'",
								"webview_height_ratio": "tall",
							  },
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
									'.$jsonmsg.'
								]
							  }
							}
						  }
					}';
					return $jsonData;
				}else{
					$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
					return $jsonData;
				}
			}elseif($intent=='email'){
				//feedback, send email intent
				return qcpd_wpfb_email_feedback_1($sender);
			}elseif($intent=='phone'){
				return qcpd_wpfb_phonenumber_1($sender);
			}elseif($intent=='email subscription'){
				return qcpd_wpfb_email_subscription_1($sender, $access_token);
			}elseif(isset($result['queryResult']['fulfillmentMessages']) && !empty($result['queryResult']['fulfillmentMessages'])){
				
				$dfmessages = $result['queryResult']['fulfillmentMessages'];
				foreach($dfmessages as $key => $message){
					
					if(isset($message['text'])){
						//text response
						
						$jsonData = '{
							"recipient":{
								"id":"'.$sender.'"
							},
							"message":{
								"text":"'.wpbot_fb_msg_condition(strip_tags($message['text']['text'][0])).'"
							}
						}';
						return $jsonData;
						
					}elseif(isset($message['quickReplies'])){
						//quick replies
						
						$title = strip_tags($message['quickReplies']['title']);
						$replies = $message['quickReplies']['quickReplies'];
						$replyjson = '';
						foreach($replies as $reply){
							$replyjson .= '{
								"type":"postback",
								"title":"'.$reply.'",
								"payload":"'.$reply.'"
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
									"template_type":"button",
									"text":"'.$title.'",
									"buttons":[
										'.$replyjson.'
									]
								  }
								}
							}
						}';
						return $jsonData;
					}elseif(isset($message['card'])){
						$jsonmsg = '';
						foreach($result['queryResult']['fulfillmentMessages'] as $msg){
							if(isset($msg['card'])){
								$buttons = $msg['card']['buttons'];
								$jsonbtn = '';
								foreach($buttons as $button){
									$jsonbtn .= '{
										"type":"web_url",
										"url":"'.$button['postback'].'",
										"title":"'.$button['text'].'"
									},';
									
								}
								$jsonmsg .= '{
									"title":"'.$msg['card']['title'].'",
									"image_url":"'.$msg['card']['imageUri'].'",
									"subtitle":"'.$msg['card']['subtitle'].'",
									
									"buttons":[
										'.$jsonbtn.'            
									]      
								},';
							}
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
										'.$jsonmsg.'
									]
								  }
								}
							  }
						}';
						return $jsonData;
						
					}
					
				}

			}
		}else{

			$jsonData = qcpd_wpfb_menu_global($sender, $access_token, strip_tags(qcld_fb_get_option('wpfb_default_no_match')));
			qcpd_wpfb_send_fb_reply($jsonData, $access_token);exit;
			
		}

	}
}

function qc_df_v2_api($query){
	
	$session_id = 'asd2342sde';
    $language = qcld_fb_get_option('qlcd_wp_chatbot_dialogflow_agent_language');
    //project ID
    $project_ID = qcld_fb_get_option('qlcd_wp_chatbot_dialogflow_project_id');
    // Service Account Key json file
    $JsonFileContents = qcld_fb_get_option('qlcd_wp_chatbot_dialogflow_project_key');
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


function qcld_wpb_search_for_fb($keyword) {
	
	$keyword = sanitize_text_field($keyword);
	$enable_post_types = qcld_fb_get_option('wppt_post_types');
	$postypes = array( 'post', 'page' );
	if(!empty($enable_post_types) && is_array($enable_post_types)){
		$postypes = $enable_post_types;
	}
	$results = new WP_Query( array(
		'post_type'     => $postypes,
		'post_status'   => 'publish',
		'posts_per_page'=> 10,
		's'             => stripslashes( $keyword ),
	) );
	$msg = (qcld_fb_get_option('qlcd_wp_chatbot_we_have_found')!=''?qcld_fb_get_option('qlcd_wp_chatbot_we_have_found'):'We have found #result results for #keyword');
	
	$response = array();
	$response['status'] = 'fail';
	if( class_exists( 'WC_Product_Factory' ) ){
		$_pf = new WC_Product_Factory();
	}
	if ( !empty( $results->posts ) ) {

		$response['status'] = 'success';
		$response['results'] = array();
		foreach ( $results->posts as $result ) {
			
			$featured_img_url = get_the_post_thumbnail_url($result->ID,'full');
			if($featured_img_url==''){
				$featured_img_url = QCLD_wpCHATBOT_IMG_URL.'wp_placeholder.png';
			}
			
			if($result->post_type=='product'){
				$product = $_pf->get_product($result->ID);
				
				$response['results'][] = array(
					'imgurl'=>qc_wpbot_url_validator($featured_img_url),
					'link'=>qc_wpbot_url_validator(get_permalink($result->ID)),
					'title'=>$result->post_title,
					'subtitle'=> get_woocommerce_currency_symbol().wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) )
				);
			}else{
				$response['results'][] = array(
					'imgurl'=>qc_wpbot_url_validator($featured_img_url),
					'link'=>qc_wpbot_url_validator(get_permalink($result->ID)),
					'title'=>$result->post_title
				);
			}

		}
		
	}else{
		$texts = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_no_result'));
		$response['message'] = $texts[array_rand($texts)];
	}
	wp_reset_query();
	return $response;
	die();
}

/* featured product */
function qcld_wpfb_chatbot_keyword_featured()
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

/* Sale Product */
function qcld_wpfb_chatbot_keyword_sale()
{
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

function qcld_wp_chatbot_catalog_mca($catid)
{
    
    $product_per_page = (qcld_fb_get_option('wppt_number_of_result')==''?'10':qcld_fb_get_option('wppt_number_of_result'));
	
	$response = array();
	$response['status'] = 'fail';
	
	$product_orderby = (qcld_fb_get_option('wppt_result_orderby')==''?'none':qcld_fb_get_option('wppt_result_orderby'));
	$product_order = (qcld_fb_get_option('wppt_result_order')==''?'ASC':qcld_fb_get_option('wppt_result_order'));
		
        
        //Merging all query together.
        $argu_params = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby' => $product_orderby,
			'order' => $product_order,
			'posts_per_page' => $product_per_page,
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'term_id',
					'terms' => $catid,
					'operator' => 'IN'
				)
			)
		);
        /******
         *WP Query Operation to get products.*
         *******/
        $product_query = new WP_Query($argu_params);
        $product_num = $product_query->post_count;
        //Getting total product number by string.
        
       
        $_pf = new WC_Product_Factory();
        //repeating the products
        if ($product_num > 0) {
			
			$response['status'] = 'success';
			$response['results'] = array();
			
            
            while ($product_query->have_posts()) : $product_query->the_post();
                $product = $_pf->get_product(get_the_ID());
                if ($product->is_visible()) {

					$response['results'][] = array(
						'imgurl'=>get_the_post_thumbnail_url(get_the_ID(), 'full'),
						'link'=>get_permalink(get_the_ID()),
						'title'=>$product->get_title(),
						'subtitle'=> get_woocommerce_currency_symbol().wc_get_price_to_display( $product, array( 'price' => $product->get_price() ) )
					);
					
                }
            endwhile;
            wp_reset_postdata();
            

        }else{
			$texts = maybe_unserialize(qcld_fb_get_option('qlcd_wp_chatbot_product_fail'));
			$response['message'] = $texts[array_rand($texts)];
		}

    return $response;
    wp_die();
}