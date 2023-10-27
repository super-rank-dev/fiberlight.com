<?php 

add_action('wp_ajax_qcwpfb_reload_pages_action', 'qcwpfb_reload_pages_action');
add_action('wp_ajax_nopriv_qcwpfb_reload_pages_action', 'qcwpfb_reload_pages_action');
function qcwpfb_reload_pages_action(){
	check_ajax_referer( 'wpbotfbreload123pages', 'security' );
	
	$result = array();
	
	if(get_option('wpfb_user_access_token')!=''){
		
		$user_access_token = get_option('wpfb_user_access_token');
		
			$url2 = "https://graph.facebook.com/v3.3/me/accounts?fields=cover,emails,picture,id,name,url,username,access_token&limit=400&access_token=$user_access_token";
			$pages = qcwpfb_get_fbpost_content($url2);

			if(isset($pages['data']) && !empty($pages['data'])){
				
				foreach($pages['data'] as $page){
					
					wpfb_insert_into_database($page);
					
				}
				
				$result['status'] = 'success';
				$result['content'] = wpfb_pages_list();
			}
			


	}else{
		$result['status'] = 'failed';
		$result['reasone'] = 'No User Access Token.';
	}
	
	echo json_encode($result);
	die(1);
}


add_action('wp_ajax_qcwpfb_load_profile_link', 'qcwpfb_load_profile_link');

function qcwpfb_load_profile_link() {
	check_ajax_referer( 'wpbotfbreload123pages', 'security' );

	$pageid = sanitize_text_field( $_POST['pageid'] );
	$profile_id = sanitize_text_field( $_POST['profile_id'] );
	$access_token = qcpd_wpfb_get_accesstoken_from_id($pageid);

	

	die(1);
}


add_action('wp_ajax_qcwpfb_reload_posts_action', 'qcwpfb_reload_posts_action');
add_action('wp_ajax_nopriv_qcwpfb_reload_posts_action', 'qcwpfb_reload_posts_action');
function qcwpfb_reload_posts_action(){
	check_ajax_referer( 'wpbotfbreload123pages', 'security' );
	$result = array();
	$pages = wpfb_get_all_pages();
	
	foreach($pages as $page){
		$posts = wpfb_get_all_posts($page);
		if(isset($posts['data'])){
			wpfb_insert_posts($posts['data'], $page->page_id);
			$result['status'] = 'success';
		}else{
			$result['status'] = 'failed';
			$result['reason'] = 'Unable to retrive fb posts.';
			break;
		}
	}		
	echo json_encode($result);
	die(1);
}

//add_action('init', 'wpfb_testing_fnc');
function wpfb_testing_fnc(){
	/*
	$checkposts = get_posts(array(
		'numberposts'	=> -1,
		'post_type'		=> 'wpfbposts',
		'meta_key'		=> 'fb_post_id',
		'meta_value'	=> '1367135746767914_1368064530008369'
	));
	
	if(!empty($checkposts)){
		
		$post_id = ($checkposts[0]->ID);
		
		$enable_private_reply_from_df = get_post_meta( $post_id, 'enable_private_reply_from_df', true );
		$enable_comment_reply_from_df = get_post_meta( $post_id, 'enable_comment_reply_from_df', true );
		
		$comment_reply = get_post_meta( $post_id, 'comment_reply', true );
		$comment_reply_is_condition = get_post_meta( $post_id, 'comment_reply_is_condition', true );
		$comment_reply_condition = get_post_meta( $post_id, 'comment_reply_condition', true );
		$comment_condition_value = get_post_meta( $post_id, 'comment_condition_value', true );
		$comment_reply_text = get_post_meta( $post_id, 'comment_reply_text', true );
		
		$private_reply = get_post_meta( $post_id, 'private_reply', true );
		$private_reply_condition = get_post_meta( $post_id, 'private_reply_condition', true );
		$reply_condition = get_post_meta( $post_id, 'reply_condition', true );
		$condition_value = get_post_meta( $post_id, 'condition_value', true );
		$reply_text = get_post_meta( $post_id, 'reply_text', true );
		

		
	}
	*/
	
	/*
	$jsonData = '{    
	  "messages": [
		{
		  "attachment":{
			"type":"template",
			"payload":{
			  "template_type":"generic",
			  "elements":[
				 {
				  "title":"Welcome to Our Marketplace!",
				  "image_url":"https://www.quantumcloud.com/products/wp-content/uploads/2019/05/messenger-chatbot.png",
				  "subtitle":"Fresh fruits and vegetables. Yum.",
				  "buttons":[
					{
					  "type":"web_url",
					  "url":"https://www.quantumcloud.com",
					  "title":"View Website"
					}              
				  ]      
				}
			  ]
			}       
		  }
		}
	  ]
	}';
	$data = qcpd_wpfb_fb_broadcast_message_creative($jsonData, 'EAAEv9wJsuZBcBAGn5RNd2p7ZCGZCJK0DagZAOCzKVN4evRYwpmEZCSqRj1aZC0kAZA3crjd5QRcAse1KXOw4EaMYXQPI2lc6u7clo5ZCFfHflZAEriE8UOwMJUICMTveH6JdTZAcWgXt1UcMM3ZB8xKaaMuTOonRb21HAmE83Y6FzUqURryR5G791SKSDHxwbfq8D0ZD');
	
	*/
	
	
	/*
	$jsonData = '{    
	  "message_creative_id": 559928398106459,
	  "notification_type": "REGULAR",
	  "messaging_type": "MESSAGE_TAG",
	  "tag": "NON_PROMOTIONAL_SUBSCRIPTION"
	}';
	$data = qcpd_wpfb_fb_broadcast_message($jsonData, 'EAAEv9wJsuZBcBAFlZBXd19LsfRp2A189aCmQCnZCgvux8ti08S6ckQKM429mW2ZBVOcqaqwbdbP7QUzINNHnpf7ZCusYhtHFsdXSa4eEJo0at1dveXcMqzIIKSsJD58zLDE5OTQLstPCJX82sMwR4j9qvoHGbD6odlozOAuLLc3s4Hrix5Bc1');
	print_r($data);exit;
	*/
	$jsonData = '{    
	  "messaging_type": "MESSAGE_TAG",
	  "tag": "ACCOUNT_UPDATE",
	  "recipient": {
		"id": "2560014117412934"
	  },
	  "message":{
			"attachment":{
			  "type":"template",
			  "payload":{
				"template_type":"generic",
				"elements":[
					{
					  "title":"Welcome to Our Marketplace!",
					  "image_url":"https://www.quantumcloud.com/products/wp-content/uploads/2019/05/messenger-chatbot.png",
					  "subtitle":"Fresh fruits and vegetables. Yum.",
					  "buttons":[
						{
						  "type":"web_url",
						  "url":"https://www.quantumcloud.com",
						  "title":"View Website"
						}              
					  ]      
					}
				]
			  }
			}
		}
	  
	}';
	$data = qcpd_wpfb_fb_send_api($jsonData, 'EAAEv9wJsuZBcBAFlZBXd19LsfRp2A189aCmQCnZCgvux8ti08S6ckQKM429mW2ZBVOcqaqwbdbP7QUzINNHnpf7ZCusYhtHFsdXSa4eEJo0at1dveXcMqzIIKSsJD58zLDE5OTQLstPCJX82sMwR4j9qvoHGbD6odlozOAuLLc3s4Hrix5Bc1');
	print_r($data);exit;
}