<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Product indexing, caching & searching features concept is taken from open source 'Advanced wp Search' Wp plugin by ILLID.
 */
include_once( 'includes/class-wpwbot-table.php' );
include_once( 'includes/class-wpwbot-search.php' );


function qcld_wpbo_search_site() {
	global $wpdb;
	$keyword = sanitize_text_field($_POST['keyword']);
	if(class_exists('qc_wpsaas')){
		qc_wpsaas::search($keyword);
	}
	elseif(qcld_wpbot_is_active_post_type_search()){
		
		qcpd_wppt_search_fnc($keyword);
	}
	

	$searchlimit = get_option('wpbot_search_result_number')!=''?get_option('wpbot_search_result_number'):5;

	$searchkeyword = qcld_wpbot_modified_keyword($keyword);

	//advance query building

	$sql = "SELECT * FROM ". $wpdb->prefix."posts where post_type in ('page', 'post') and post_status='publish' and ((post_title REGEXP '\\b".$searchkeyword."\\b') or (post_content REGEXP '\\b".$searchkeyword."\\b')) order by ID DESC";

	$limit = " Limit 0, ".$searchlimit;

	$results = $wpdb->get_results($sql.$limit);


	$total_results = $wpdb->get_results($sql);

	$new_window = get_option('wpbot_search_result_new_window');

	$msg = (get_option('qlcd_wp_chatbot_we_have_found')!=''?maybe_unserialize(get_option('qlcd_wp_chatbot_we_have_found')):'We have found results');

	if( is_array( $msg ) && isset( $msg[get_wpbot_locale()] )){
		$msg = $msg[get_wpbot_locale()];
	}

	$imagesize = (get_option('wpbot_search_image_size')!=''?get_option('wpbot_search_image_size'):'thumbnail');
	
	
	$response = array();
	$response['status'] = 'fail';
	

	if ( !empty( $results ) ) {

		

		$response['status'] = 'success';
		$response['html'] = '<div class="wpb-search-result">';
		$response['html'] .= '<p>'.str_replace(array('#result', '#keyword'),array(esc_html(count($total_results)), esc_html($_POST['keyword'])),$msg).'</p>';
		$total_post = 0;
		foreach ( $results as $result ) {
		// 	$featured_img_url = get_the_post_thumbnail_url($result->ID,$imagesize);
		// 	$response['html'] .='<div class="wpbot_card_wraper">';
		// 	$response['html'] .=	'<div class="wpbot_card_image '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.esc_url($result->guid).'" '.($new_window==1?'target="_blank"':'').'>';
		// 	if($featured_img_url!=''){
		// 		$response['html'] .=		'<img src="'.$featured_img_url.'" />';
		// 	}

		// 	$response['html'] .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
		// 	$response['html'] .=			'<h2>'.esc_html($result->post_title).'</h2>';
		// 	$response['html'] .=		'</div>';
		// 	$response['html'] .=	'</a></div>';
		// 	$response['html'] .='</div>';			
		// }
		// $response['html'] .='</div>';
				$selected_lan = sanitize_text_field($_POST['language']);
				$url_check = str_replace(site_url(), '', get_permalink($result->ID));
				$url_check = explode('/',$url_check);
				$url_check = str_replace('/', '', $url_check);
				$languages = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_msg')));
				$languages = array_keys($languages);
				if( in_array($url_check[1], $languages, true) && (count($languages) >= 2) ){
					if($url_check[1] == $selected_lan){
						$total_post = $total_post + 1;
						$responses .='<div class="wpbot_card_wraper">';
						$responses .=	'<div class="wpbot_card_image '.($result->post_type=='product'?'wp-chatbot-product':'').' '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.esc_url(get_permalink($result->ID)).'" '.($new_window==1?'target="_blank"':'').' '.($result->post_type=='product'?'wp-chatbot-pid="'.$result->ID.'"':'').'>';
						if($featured_img_url!=''){
							$responses .=		'<img src="'.esc_url_raw($featured_img_url).'" />';
						}
						$responses .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
						$responses .=			'<h2>'.esc_html($result->post_title).'</h2>';
						if($result->post_type=='product'){
							if ( class_exists( 'WooCommerce' ) ) {
								$product = wc_get_product( $result->ID );
								$responses .=			'<p class="wpbot_product_price">'.get_woocommerce_currency_symbol().$product->get_price_html().'</p>';
							}
						}
						$responses .=		'</div>';
						$responses .=	'</a></div>';
						$responses .='</div>';	
					}		
				}else{
					$total_post = $total_post + 1;
					$responses .='<div class="wpbot_card_wraper">';
					$responses .=	'<div class="wpbot_card_image '.($result->post_type=='product'?'wp-chatbot-product':'').' '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.esc_url(get_permalink($result->ID)).'" '.($new_window==1?'target="_blank"':'').' '.($result->post_type=='product'?'wp-chatbot-pid="'.$result->ID.'"':'').'>';
					if($featured_img_url!=''){
						$responses .=		'<img src="'.esc_url_raw($featured_img_url).'" />';
					}
					$responses .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
					$responses .=			'<h2>'.esc_html($result->post_title).'</h2>';
					if($result->post_type=='product'){
						if ( class_exists( 'WooCommerce' ) ) {
							$product = wc_get_product( $result->ID );
							$responses .=			'<p class="wpbot_product_price">'.get_woocommerce_currency_symbol().$product->get_price_html().'</p>';
						}
					}
					$responses .=		'</div>';
					$responses .=	'</a></div>';
					$responses .='</div>';
				}
			}
			$response['html'] .= '<p>'.$msg.'</p>';;
			$response['html'] .= $responses;
			$response['html'] .='</div>';
		if(count($total_results) > $searchlimit){
			$default_language = qcld_wpbot()->helper->default_langauge();
			$load_more = maybe_unserialize(get_option('qlcd_wp_chatbot_load_more_search'));
			$response['html'] .='<button type="button" class="wp-chatbot-loadmore2" data-keyword="'.$keyword.'" data-page="2">'.(( $load_more!='')?$load_more[$default_language]:'Load More ').' <span class="wp-chatbot-loadmore-loader"></span></button>';
		}
	}else{
		
		$args = array(
					'post_type' => array( 'post', 'page' ),
					'posts_per_page' => $searchlimit,
					'post_status'   => 'publish',
					's' => $keyword,
				);
		$results = new WP_Query($args);
		
		if( $results->have_posts() ){
			$count = 0;
			$response['status'] = 'success';
			$response['html'] = '<div class="wpb-search-result">';
			$total_post = 0;
			//$response['html'] .= '<p>'.str_replace(array('#result', '#keyword'),array(esc_html($results->found_posts), esc_html($_POST['keyword'])),$msg).'</p>';
			while( $results->have_posts() ){
				$results->the_post();
				$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),$imagesize);
				
				

				// $response['html'] .='<div class="wpbot_card_wraper">';
				// $response['html'] .=	'<div class="wpbot_card_image '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.get_permalink().'" '.($new_window==1?'target="_blank"':'').'>';
				// if($featured_img_url!=''){
				// 	$response['html'] .=		'<img src="'.$featured_img_url.'" />';
				// }
				// $response['html'] .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
				// $response['html'] .=			'<h2>'.get_the_title().'</h2>';
				// $response['html'] .=		'</div>';
				// $response['html'] .=	'</a></div>';
				// $response['html'] .='</div>';	
				$selected_lan = sanitize_text_field($_POST['language']);
				$url_check = str_replace(site_url(), '', get_permalink($result->ID));
				$url_check = explode('/',$url_check);
				$url_check = str_replace('/', '', $url_check);
				$languages = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_msg')));
				$languages = array_keys($languages);
				if( in_array($url_check[1], $languages, true) && (count($languages) >= 2) ){
					if($url_check[1] == $selected_lan){
						$total_post = $total_post + 1;
						$responses .='<div class="wpbot_card_wraper">';
						$responses .=	'<div class="wpbot_card_image '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.get_permalink().'" '.($new_window==1?'target="_blank"':'').'>';
						if($featured_img_url!=''){
							$responses .=		'<img src="'.$featured_img_url.'" />';
						}
						$responses .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
						$responses .=			'<h2>'.get_the_title().'</h2>';
						$responses .=		'</div>';
						$responses .=	'</a></div>';
						$responses .='</div>';
					}		
				}else{
					$total_post = $total_post + 1;
					$responses .='<div class="wpbot_card_wraper">';
						$responses .=	'<div class="wpbot_card_image '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.get_permalink().'" '.($new_window==1?'target="_blank"':'').'>';
						if($featured_img_url!=''){
							$responses .=		'<img src="'.$featured_img_url.'" />';
						}
						$responses .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
						$responses .=			'<h2>'.get_the_title().'</h2>';
						$responses .=		'</div>';
						$responses .=	'</a></div>';
						$responses .='</div>';
				}
						
			}
			$response['html'] .= '<p>'.$msg.'</p>';
			$response['html'] .= $responses;
			$response['html'] .='</div>';
			if($results->found_posts > $searchlimit){
				$load_more = maybe_unserialize(get_option('qlcd_wp_chatbot_load_more_search'));
			    $default_language = qcld_wpbot()->helper->default_langauge();
				$response['html'] .='<button type="button" class="wp-chatbot-loadmore2" data-search-type="default-wp-search" data-keyword="'.$keyword.'" data-page="2">'. (($load_more !='') ? $load_more[$default_language] :'Load More').'  <span class="wp-chatbot-loadmore-loader"></span></button>';
			}
			wp_reset_postdata();
		}else{
			$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_no_result'));
			
			$response['html'] = $texts;
		}
		
		/*$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_no_result'));
		$response['html'] = $texts[array_rand($texts)];*/
	}
	wp_reset_query();
	echo json_encode($response);

	die();
}

add_action( 'wp_ajax_wpbo_search_site',        'qcld_wpbo_search_site' );
add_action( 'wp_ajax_nopriv_wpbo_search_site', 'qcld_wpbo_search_site' );


add_action( 'wp_ajax_wpbo_search_responseby_intent',        'qc_wpbo_search_responseby_intent' );
add_action( 'wp_ajax_nopriv_wpbo_search_responseby_intent', 'qc_wpbo_search_responseby_intent' );

function qc_wpbo_search_responseby_intent(){
	global $wpdb;
	$keyword = sanitize_text_field($_POST['keyword']);
	$table = $wpdb->prefix.'wpbot_response';

	$result = $wpdb->get_row("SELECT * FROM `$table` WHERE 1 and `intent` = '".$keyword."'");
	
	$response_result = array();
	if(!empty($result)){

		if ( ! empty( $result->users_answer ) ) {
			$users_answer = maybe_unserialize( $result->users_answer );
		} else {
			$users_answer = array();
			$users_answer['answer'] = array();
			$users_answer['feedback'] = array();
			$users_answer['not_match'] = '';
			$users_answer['trigger_intent'] = '';
			$users_answer['entity_name'] = '';
			$users_answer['entity_is_required'] = 0;
			$users_answer['response_type'] = 2;
			$users_answer['prompt_message'] = '';
		}
		$users_answer['not_match'] = (get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $users_answer['not_match']):$users_answer['not_match'] );

		$response_result[] = array('id'=>$result->id, 'query'=>$result->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->response):$result->response ), 'followup'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->custom):$result->custom ), 'trigger_intent' => $result->trigger_intent, 'score'=>1, 'users_answer' => $users_answer);

	}
	if ( ! empty( $response_result ) ) {
		$status = array('status'=>'success','category'=> false, 'multiple'=>false, 'data'=>$response_result);
	} else {
		$status = array('status'=>'fail');
	}

	echo json_encode($status);

	die();

}

add_action( 'wp_ajax_wpbo_search_response_catlist',        'wpbo_search_response_catlist' );
add_action( 'wp_ajax_nopriv_wpbo_search_response_catlist', 'wpbo_search_response_catlist' );

function wpbo_search_response_catlist(){
	global $wpdb;
	$table = $wpdb->prefix.'wpbot_response_category';
	
	$status = array('status'=>'fail');
	$results = $wpdb->get_results("SELECT * FROM `$table` WHERE 1 and ( custom = '' or custom = '0' )");
	$response_result = array();
	
	if(!empty($results)){
		foreach($results as $result){
			
			$response_result[] = array('name'=>$result->name);
			
		}
	}
	
	if(!empty($response_result)){

		$status = array('status'=>'success', 'data'=>$response_result);

	}
	
	echo json_encode($status);

	die();
	
}

function get_str_categories(){
	global $wpdb;
	$categories  = array();
	
	$table = $wpdb->prefix.'wpbot_response_category';

	$results = $wpdb->get_results("SELECT * FROM `$table` WHERE 1");
	foreach($results as $result){
		$categories[] = $result->name;
	}
	return $categories;
}

add_action( 'wp_ajax_wpbo_search_response',        'qc_wpbo_search_response' );
add_action( 'wp_ajax_nopriv_wpbo_search_response', 'qc_wpbo_search_response' );

function qc_wpbo_search_response(){
	global $wpdb;
	$keyword = (sanitize_text_field($_POST['keyword']));
	$language = (sanitize_text_field($_POST['language']));
	
	if (isset($_POST['strid'])) {
		$strid = (sanitize_text_field($_POST['strid']));
	}
	$table = $wpdb->prefix.'wpbot_response';
	$cattable = $wpdb->prefix.'wpbot_response_category';
	
	$response_result = array();

	$status = array('status'=>'fail', 'multiple'=>false);

	$check_qmark = substr($keyword, -1);
	if($check_qmark == '?'){
		$keyword = trim( substr_replace($keyword ,"", -1) );
	}else{
		$keyword = trim( $keyword );
	}
	if(isset($_POST['strid']) && empty($response_result)){
		$results = $wpdb->get_results("SELECT * FROM `$table` WHERE `ID` = ".$strid);	
		if(!empty($results)){
			foreach($results as $result){
				
				if ( ! empty( $result->users_answer ) ) {
					$users_answer = maybe_unserialize( $result->users_answer );
				} else {
					$users_answer = array();
					$users_answer['answer'] = array();
					$users_answer['feedback'] = array();
					$users_answer['not_match'] = '';
					$users_answer['trigger_intent'] = '';
					$users_answer['entity_name'] = '';
					$users_answer['entity_is_required'] = 0;
					$users_answer['response_type'] = 2;
					$users_answer['prompt_message'] = '';
				}
				$users_answer['not_match'] = (get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $users_answer['not_match']):$users_answer['not_match'] );
				$response_result[] = array('id'=>$result->id, 'query'=>$result->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->response):$result->response ), 'followup'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->custom):$result->custom ), 'trigger_intent' => $result->trigger_intent, 'score'=>1, 'users_answer' => $users_answer);
			}
		}
	}

	if(empty($response_result) && class_exists('Qcld_str_pro')){
		$categories = get_str_categories();

		if(in_array($keyword, $categories)){
			$get_category =  $wpdb->get_row("SELECT * FROM `$cattable` WHERE 1 and `name` = '".$keyword."'");
			if ( ! empty( $get_category ) ) {
				$get_sub_cats = $wpdb->get_results("SELECT * FROM `$cattable` WHERE 1 and `custom` = '".$get_category->id."' ");

				if ( ! empty( $get_sub_cats ) ) {
					foreach ( $get_sub_cats as $sub_cat ) {
						$response_result[] = array('query'=>$sub_cat->name, 'response'=>'', 'followup'=>'', 'trigger_intent' => '', 'score'=>1);
					}
				}
			}

			$results = $wpdb->get_results("SELECT * FROM `$table` WHERE 1 and `category` like '%".$keyword."%' and lang='".$language."' and `hidden` = 0");

			if(!empty($results)){
				foreach($results as $result){
					if ( ! empty( $result->users_answer ) ) {
						$users_answer = maybe_unserialize( $result->users_answer );
					} else {
						$users_answer = array();
						$users_answer['answer'] = array();
						$users_answer['feedback'] = array();
						$users_answer['not_match'] = '';
						$users_answer['trigger_intent'] = '';
						$users_answer['entity_name'] = '';
						$users_answer['entity_is_required'] = 0;
						$users_answer['response_type'] = 2;
						$users_answer['prompt_message'] = '';
					}
					$users_answer['not_match'] = (get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $users_answer['not_match']):$users_answer['not_match'] );

					$response_result[] = array('id'=>$result->id, 'query'=>$result->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->response):$result->response ), 'followup'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->custom):$result->custom ), 'trigger_intent' => $result->trigger_intent, 'score'=>1, 'users_answer' => $users_answer);
					
				}
				if( count($response_result)>1 ){
					$status = array('status'=>'success','category'=> true, 'multiple'=>true, 'data'=>$response_result);
				}else{
					$status = array('status'=>'success', 'category'=> true, 'multiple'=>false, 'data'=>$response_result);
				}
				
				echo json_encode($status);

				die();
			}

			if ( ! empty( $response_result ) ) {
				$status = array('status'=>'success','category'=> true, 'multiple'=>true, 'data'=>$response_result);
				echo json_encode($status);
				die();
			}

		}
		
	}

	if(class_exists('Qcld_str_pro')){
		if(get_option('qc_bot_str_remove_stopwords') && get_option('qc_bot_str_remove_stopwords')==1){
			$keyword = qc_strpro_remove_stopwords($keyword);
		}
	}

	if(empty($response_result)){
		$results = $wpdb->get_results("SELECT * FROM `$table` WHERE 1 and `query` = '".$keyword."' and lang='".$language."'  and `hidden` = 0");
		if(!empty($results)){
			foreach($results as $result){
				
				if ( ! empty( $result->users_answer ) ) {
					$users_answer = maybe_unserialize( $result->users_answer );
				} else {
					$users_answer = array();
					$users_answer['answer'] = array();
					$users_answer['feedback'] = array();
					$users_answer['not_match'] = '';
					$users_answer['trigger_intent'] = '';
					$users_answer['entity_name'] = '';
					$users_answer['entity_is_required'] = 0;
					$users_answer['response_type'] = 2;
					$users_answer['prompt_message'] = '';
				}
				$users_answer['not_match'] = (get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $users_answer['not_match']):$users_answer['not_match'] );

				$response_result[] = array('id'=>$result->id, 'query'=>$result->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->response):$result->response ), 'followup'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->custom):$result->custom ), 'trigger_intent' => $result->trigger_intent, 'score'=>1, 'users_answer' => $users_answer);
				
				
			}
		}
	}
	if( empty( $response_result ) ){
		$results = $wpdb->get_results("SELECT * FROM `$table` WHERE 1 and ( CONCAT(',', keyword, ',') like '%,". $keyword .",%' or CONCAT(',', keyword, ',') like '%, ". $keyword .",%' or CONCAT(',', keyword, ',') like '%". $keyword .",%' or CONCAT(',', keyword, ',') like '%, ". $keyword ."%' or CONCAT(',', keyword, ',') like '%,". $keyword ."%' ) and lang = '".$language."' and `hidden` = 0 ");
		if(!empty($results)){
			foreach($results as $result){
				
				if ( ! empty( $result->users_answer ) ) {
					$users_answer = maybe_unserialize( $result->users_answer );
				} else {
					$users_answer = array();
					$users_answer['answer'] = array();
					$users_answer['feedback'] = array();
					$users_answer['not_match'] = '';
					$users_answer['trigger_intent'] = '';
					$users_answer['entity_name'] = '';
					$users_answer['entity_is_required'] = 0;
					$users_answer['response_type'] = 2;
					$users_answer['prompt_message'] = '';
				}
				$users_answer['not_match'] = (get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $users_answer['not_match']):$users_answer['not_match'] );

				$response_result[] = array('id'=>$result->id, 'query'=>$result->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->response):$result->response ), 'followup'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->custom):$result->custom ), 'trigger_intent' => $result->trigger_intent, 'score'=>1, 'users_answer' => $users_answer);
				
				
			}
		}
	}
	
	// ****************** for bracket problem ******************//
	if( empty( $response_result ) ){
		$results = $wpdb->get_results("SELECT * FROM `$table` WHERE 1 and keyword like '%". $keyword ."%' or  response like '%". $keyword ."%' or query like '%". $keyword ."%' and lang = '".$language."' and `hidden` = 0");
		if(!empty($results)){
			foreach($results as $result){
				
				if ( ! empty( $result->users_answer ) ) {
					$users_answer = maybe_unserialize( $result->users_answer );
				} else {
					$users_answer = array();
					$users_answer['answer'] = array();
					$users_answer['feedback'] = array();
					$users_answer['not_match'] = '';
					$users_answer['trigger_intent'] = '';
					$users_answer['entity_name'] = '';
					$users_answer['entity_is_required'] = 0;
					$users_answer['response_type'] = 2;
					$users_answer['prompt_message'] = '';
				}
				$users_answer['not_match'] = (get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $users_answer['not_match']):$users_answer['not_match'] );

				$response_result[] = array('id'=>$result->id, 'query'=>$result->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->response):$result->response ), 'followup'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->custom):$result->custom ), 'trigger_intent' => $result->trigger_intent, 'score'=>1, 'users_answer' => $users_answer);
				
			}
		}
		
	}
	
	if( empty( $response_result ) ){
		$results = $wpdb->get_results("SELECT * FROM `$table` WHERE `query` REGEXP '".$keyword."' and lang='".$language."' and `hidden` = 0");
		$weight = get_option('qc_bot_str_weight')!=''?get_option('qc_bot_str_weight'):'0.4';
	
		if(!empty($results)){
			foreach($results as $result){
			
				if ( ! empty( $result->users_answer ) ) {
					$users_answer = maybe_unserialize( $result->users_answer );
				} else {
					$users_answer = array();
					$users_answer['answer'] = array();
					$users_answer['feedback'] = array();
					$users_answer['not_match'] = '';
					$users_answer['trigger_intent'] = '';
					$users_answer['entity_name'] = '';
					$users_answer['entity_is_required'] = 0;
					$users_answer['response_type'] = 2;
					$users_answer['prompt_message'] = '';
				}
				$users_answer['not_match'] = (get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $users_answer['not_match']):$users_answer['not_match'] );

				$response_result[] = array('id'=>$result->id, 'query'=>$result->query, 'response'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->response):$result->response ), 'followup'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->custom):$result->custom ), 'trigger_intent' => $result->trigger_intent, 'score'=>1, 'users_answer' => $users_answer);
				
			}
		}
	}
	
	if(empty($response_result)){
		$keyword = qc_strpro_remove_stopwords($keyword);
		$fields = get_option('qc_bot_str_fields');
		if($fields && !empty($fields) && class_exists('Qcld_str_pro')){
			$qfields = implode(', ', $fields);
		}else{
			$qfields = '`query`,`keyword`,`response`';
		}
		$sql_nl = "SELECT `id`, `query`, `response`, `custom`, `trigger_intent`, MATCH($qfields) AGAINST('".$keyword."' IN NATURAL LANGUAGE MODE) as score FROM $table WHERE MATCH($qfields) AGAINST('".$keyword."' IN NATURAL LANGUAGE MODE) and lang='".$language."' and `hidden` = 0 order by score desc limit 15";
		$results = $wpdb->get_results($sql_nl);
		// var_dump($sql_nl);
		// var_dump($results);wp_die();

		$weight = get_option('qc_bot_str_weight')!=''?get_option('qc_bot_str_weight'):'0.4';
		//$weight = 0;
		if(!empty($results)){
			foreach($results as $result){
				if($result->score >= $weight){

					if ( ! empty( $result->users_answer ) ) {
						$users_answer = maybe_unserialize( $result->users_answer );
					} else {
						$users_answer = array();
						$users_answer['answer'] = array();
						$users_answer['feedback'] = array();
						$users_answer['not_match'] = '';
						$users_answer['trigger_intent'] = '';
						$users_answer['entity_name'] = '';
						$users_answer['entity_is_required'] = 0;
						$users_answer['response_type'] = 2;
						$users_answer['prompt_message'] = '';
					}

					$users_answer['not_match'] = (get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $users_answer['not_match']):$users_answer['not_match'] );
					
					$response_result[] = array( 'id'=>$result->id,'query'=>$result->query, 'response'=> (get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->response):$result->response ), 'followup'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->custom):$result->custom ), 'trigger_intent' => $result->trigger_intent, 'score'=>$result->score, 'users_answer' => $users_answer);
					
				}
			}

			if( empty($response_result) ){
				if(!empty($results)){
					foreach($results as $result){
	
						$score_array = str_split( $result->score );
						$score_int = 0;
						foreach( $score_array as $score ) {
							
							if( $score != '.' && $score != '0' ){
								$score_int = (int)$score;
								break;
							}
						}
						$main_score = $result->score;
						if( $score_int > 0 ){
							$main_score = '0.'.$score_int;
						}
						if($main_score >= $weight){
							$response_result[] = array( 'query'=>$result->query, 'response'=> (get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->response):$result->response ), 'followup'=>(get_option('qc_bot_str_allow_shortcode') && get_option('qc_bot_str_allow_shortcode')==1?apply_filters('the_content', $result->custom):$result->custom ), 'trigger_intent' => $result->trigger_intent, 'score'=>$result->score);
							if ( ! empty( $result->users_answer ) ) {
								$response_result[]['users_answer'] = maybe_unserialize( $result->users_answer );
							} else {
								$users_answer_build = array();
								$users_answer_build['answer'] = array();
								$users_answer_build['feedback'] = array();
								$users_answer_build['not_match'] = '';
								$users_answer_build['trigger_intent'] = '';
								$users_answer_build['entity_name'] = '';
								$users_answer_build['entity_is_required'] = 0;
								$users_answer['response_type'] = 2;
								$users_answer_build['prompt_message'] = '';
								$response_result[]['users_answer'] = $users_answer_build;
							}
						}
					}
				}
			}
		}
	}
	if(!empty($response_result)){
		if(count($response_result)>1){
			$status = array('status'=>'success', 'multiple'=>true, 'data'=>$response_result);
		}else{
			$status = array('status'=>'success', 'multiple'=>false, 'data'=>$response_result);
		}
	}
	
	echo json_encode($status);

	die();

}

function qcld_wpbo_search_site_pagination2() {
	global $wpdb;
	$keyword = sanitize_text_field($_POST['keyword']);
	$page = sanitize_text_field($_POST['page']);
	$page = ($page-1);
	if(qcld_wpbot_is_active_post_type_search()){
		qcpd_wppt_search_fnc($keyword);
	}

	$searchlimit = get_option('wpbot_search_result_number')!=''?get_option('wpbot_search_result_number'):5;

	$sql = "SELECT * FROM ". $wpdb->prefix."posts where post_type in ('page', 'post') and post_status='publish' and ((post_title REGEXP '\\b".$keyword."\\b') or (post_content REGEXP '\\b".$keyword."\\b')) order by ID DESC";


	$limit = " Limit ".($searchlimit*$page).", ".$searchlimit;

	
	$results = $wpdb->get_results($sql.$limit);


	$total_results = $wpdb->get_results($sql);

	$new_window = get_option('wpbot_search_result_new_window');
	

	$msg = (get_option('qlcd_wp_chatbot_we_have_found')!=''?get_option('qlcd_wp_chatbot_we_have_found'):'We have found these results');
	$imagesize = (get_option('wpbot_search_image_size')!=''?get_option('wpbot_search_image_size'):'thumbnail');

	$response = array();
	$response['status'] = 'fail';
	
	if ( !empty( $results ) ) {

		

		$response['status'] = 'success';
		$response['html'] = '<div class="wpb-search-result">';
		
		foreach ( $results as $result ) {
			$featured_img_url = get_the_post_thumbnail_url($result->ID,$imagesize);
			


			$response['html'] .='<div class="wpbot_card_wraper">';
			$response['html'] .=	'<div class="wpbot_card_image '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.esc_url($result->guid).'" '.($new_window==1?'target="_blank"':'').'>';
			if($featured_img_url!=''){
				$response['html'] .=		'<img src="'.$featured_img_url.'" />';
			}
			$response['html'] .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
			$response['html'] .=			'<h2>'.esc_html($result->post_title).'</h2>';
			$response['html'] .=		'</div>';
			$response['html'] .=	'</a></div>';
			$response['html'] .='</div>';			
		}
		$response['html'] .='</div>';
		if(count($total_results) > ($searchlimit*($page + 1))){
			$load_more = maybe_unserialize(get_option('qlcd_wp_chatbot_load_more_search'));
			$default_language = qcld_wpbot()->helper->default_langauge();
			$response['html'] .='<button type="button" class="wp-chatbot-loadmore2" data-keyword="'.$keyword.'" data-page="'.($page+1).'">'.($load_more!=''?$load_more[$default_language]:'Load More').' <span class="wp-chatbot-loadmore-loader"></span></button>';
		}
	}else{
		$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_no_result'));
		$response['html'] = $texts[array_rand($texts)];
	}
	wp_reset_query();
	echo json_encode($response);

	die();
}

add_action( 'wp_ajax_wpbo_search_site_pagination2',        'qcld_wpbo_search_site_pagination2' );
add_action( 'wp_ajax_nopriv_wpbo_search_site_pagination2', 'qcld_wpbo_search_site_pagination2' );

function wpbo_default_search_pagination2(){
	$keyword = sanitize_text_field($_POST['keyword']);
	$page = sanitize_text_field($_POST['page']);

	$searchlimit = get_option('wpbot_search_result_number')!=''?get_option('wpbot_search_result_number'):5;
	$msg = (get_option('qlcd_wp_chatbot_we_have_found')!=''?get_option('qlcd_wp_chatbot_we_have_found'):'We have found these results');
	$imagesize = (get_option('wpbot_search_image_size')!=''?get_option('wpbot_search_image_size'):'thumbnail');
	$new_window = get_option('wpbot_search_result_new_window');

	$args = array(
				'post_type' => array( 'post', 'page' ),
				'posts_per_page' => $searchlimit,
				'post_status'   => 'publish',
				's' => $keyword,
				'paged' => $page
			);
	$results = new WP_Query($args);

	$response = array();
	$response['status'] = 'fail';

	if( $results->have_posts() ){
		$count = 0;
		$response['status'] = 'success';
		$default_language = qcld_wpbot()->helper->default_langauge();
		$total_found = str_replace(array('#result', '#keyword'),array(esc_html($results->found_posts), esc_html($_POST['keyword'])),$msg);
		$response['html'] = '<div class="wpb-search-result">';
		$response['html'] .= '<p>'.$total_found[$default_language].'</p>';
		while( $results->have_posts() ){
			$results->the_post();
			$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),$imagesize);
			


			$response['html'] .='<div class="wpbot_card_wraper">';
			$response['html'] .=	'<div class="wpbot_card_image '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.get_permalink().'" '.($new_window==1?'target="_blank"':'').'>';
			if($featured_img_url!=''){
				$response['html'] .=		'<img src="'.$featured_img_url.'" />';
			}
			$response['html'] .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
			$response['html'] .=			'<h2>'.get_the_title().'</h2>';
			$response['html'] .=		'</div>';
			$response['html'] .=	'</a></div>';
			$response['html'] .='</div>';			
		}
		$response['html'] .='</div>';
		if( $page < ($results->max_num_pages) ){
			$load_more = maybe_unserialize(get_option('qlcd_wp_chatbot_load_more_search'));
			$default_language = qcld_wpbot()->helper->default_langauge();
			$response['html'] .='<button type="button" class="wp-chatbot-loadmore2" data-search-type="default-wp-search" data-keyword="'.$keyword.'" data-page="'.($page+1).'">'. (( $load_more !='')? $load_more[$default_language] :'Load More ').' <span class="wp-chatbot-loadmore-loader"></span></button>';
		}
		wp_reset_postdata();
	}else{
		$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_no_result'));
		$response['html'] = $texts[array_rand($texts)];
	}

	echo json_encode($response);

	die();
}
add_action( 'wp_ajax_wpbo_default_search_pagination2',        'wpbo_default_search_pagination2' );
add_action( 'wp_ajax_nopriv_wpbo_default_search_pagination2', 'wpbo_default_search_pagination2' );

function qcld_wb_chatbot_email_subscription() {
	
	global $wpdb;
	$table    = $wpdb->prefix.'wpbot_subscription';
	
	$name = sanitize_text_field($_POST['name']);
	$email = sanitize_email($_POST['email']);
	$url = esc_url_raw($_POST['url']);
	$user_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT']);
	
	if(isset($_POST['phone']) && $_POST['phone']!=''){

		$phone = sanitize_text_field($_POST['phone']);
		if($email!=''){

			$email_exists = $wpdb->get_row("select * from $table where 1 and email = '".$email."'");
			if(!empty($email_exists)){
				$wpdb->update(
					$table,
					array(
						'phone' => $phone,
					),
					array('email'=>$email),
					array(
						'%s',
					),
					array('%s')
				);
			}else{
				$wpdb->insert(
					$table,
					array(
						'date'  => current_time( 'mysql' ),
						'name'   => $name,
						'email'   => $email,
						'phone'   => $phone,
						'url'   => $url,
						'user_agent' => $user_agent
					)
				);
			}
		}else{
			$wpdb->insert(
				$table,
				array(
					'date'  => current_time( 'mysql' ),
					'name'   => $name,
					'email'   => $email,
					'phone'   => $phone,
					'url'   => $url,
					'user_agent' => $user_agent
				)
			);
		}
		$response['status'] = 'success';
		echo json_encode($response);
		die();
		
	}else{

		$response = array();
		$response['status'] = 'fail';
		
		$email_exists = $wpdb->get_row("select * from $table where 1 and email = '".$email."'");
		if(empty($email_exists)){
		
			$wpdb->insert(
				$table,
				array(
					'date'  => current_time( 'mysql' ),
					'name'   => $name,
					'email'   => $email,
					'url'   => $url,
					'user_agent' => $user_agent
				)
			);
			$response['status'] = 'success';
			$texts = maybe_unserialize(get_option('qlcd_wp_email_subscription_success'));
			if( is_array( $texts ) && isset( $texts[get_wpbot_locale()] )){
				$texts = $texts[get_wpbot_locale()];
			}
			$response['msg'] = $texts[array_rand($texts)];
		
		}else{
			$texts = maybe_unserialize(get_option('qlcd_wp_email_already_subscribe'));

			if( is_array( $texts ) && isset( $texts[get_wpbot_locale()] )){
				$texts = $texts[get_wpbot_locale()];
			}

			$response['msg'] = $texts[array_rand($texts)];
		}
		
		
		do_action( 'qcld_mailing_list_subscription_success', $name, $email );
		

		if(get_option('qc_email_subscription_offer')==1){

			$response['status'] = 'success';

			if(get_option('qlcd_wp_email_subscription_offer_subject')){
				$offertextss = maybe_unserialize(get_option('qlcd_wp_email_subscription_offer_subject'));
				if( is_array( $offertextss ) && isset( $offertextss[get_wpbot_locale()] )){
					$offertextss = $offertextss[get_wpbot_locale()];
				}
				$subject = str_replace('%%username%%', $name, $offertextss[array_rand($offertextss)]);

			}else{
				$subject = 'Email subscription offer';
			}

			
			//Extract Domain
			$url = get_site_url();
			$url = parse_url($url);
			$domain = $url['host'];
			$toEmail = $email;
			$fromEmail = "wordpress@" . $domain;
			$fromname = (get_option('qlcd_wp_chatbot_from_name')?get_option('qlcd_wp_chatbot_from_name'):'Wordpress');

			if(get_option('qlcd_wp_chatbot_from_email') && get_option('qlcd_wp_chatbot_from_email')!=''){
				$fromEmail = get_option('qlcd_wp_chatbot_from_email');
			}

			$replyto = $fromEmail;

			if(get_option('qlcd_wp_chatbot_reply_to_email') && get_option('qlcd_wp_chatbot_reply_to_email')!=''){
				$replyto = get_option('qlcd_wp_chatbot_reply_to_email');
			}

			//Starting messaging and status.
			$offertexts = maybe_unserialize(get_option('qlcd_wp_email_subscription_offer'));
			if( is_array( $offertexts ) && isset( $offertexts[get_wpbot_locale()] )){
				$offertexts = $offertexts[get_wpbot_locale()];
			}
			//build email body
			$bodyContent = "";
			$bodyContent .= '<p><strong>' . esc_html__('Offer Details', 'wpchatbot') . ':</strong></p><hr>';
			$bodyContent .= '<p>' . str_replace('%%username%%', $name, $offertexts[array_rand($offertexts)]) . '</p>';
			$bodyContent .= '<p>' . esc_html__('Mail Generated on', 'wpchatbot') . ': ' . current_time('F j, Y, g:i a') . '</p>';
			$to = $toEmail;
			$body = $bodyContent;
		
			$headers = array();
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$headers[] = 'From: '.$fromname.' <'.$fromEmail.'>';
			$headers[] = 'Reply-To: '.$fromname.' <'. ($replyto) .'>';
			wp_mail($to, $subject, $body, $headers);
			$response['email'] = 'Send! to '.$to.' from '.$fromEmail;

		}
		
		echo json_encode($response);

		die();
	}
}

add_action( 'wp_ajax_qcld_wb_chatbot_email_subscription',        'qcld_wb_chatbot_email_subscription' );
add_action( 'wp_ajax_nopriv_qcld_wb_chatbot_email_subscription', 'qcld_wb_chatbot_email_subscription' );

add_action( 'wp_ajax_wpbo_failed_response',        'wpbo_failed_response' );
add_action( 'wp_ajax_nopriv_wpbo_failed_response', 'wpbo_failed_response' );

function wpbo_failed_response(){
	global $wpdb;
	$table    = $wpdb->prefix.'wpbot_failed_response';
	$keyword = sanitize_text_field($_POST['keyword']);

	$email_exists = $wpdb->get_row("select * from $table where 1 and `query` = '".$keyword."'");
	if(!empty($email_exists)){
		$wpdb->update(
			$table,
			array(
				'count' => (int)($email_exists->count + 1),
			),
			array('id'=>$email_exists->id),
			array(
				'%d',
			),
			array('%d')
		);
	}else{
		
		$wpdb->insert(
			$table,
			array(
				'query'   => $keyword,
				'count'   => 1,

			)
		);
	}
	die(0);

}


function qcld_wb_chatbot_email_unsubscription() {
	
	global $wpdb;
	$table    = $wpdb->prefix.'wpbot_subscription';
	$email = sanitize_email($_POST['email']);
	$response = array();
	$response['status'] = 'fail';
	$email_exists = $wpdb->get_row("select * from $table where 1 and email = '".$email."'");
	if(empty($email_exists)){
		$response['status'] = 'fail';
	}else{
		do_action('qcld_mailing_list_unsubscription_by_user', $email);
		$wpdb->delete(
            $table,
            array( 'email' => $email ),
            array( '%s' )
		);
		$response['status'] = 'success';
	}
	echo json_encode($response);
	die();
}

add_action( 'wp_ajax_qcld_wb_chatbot_email_unsubscription',        'qcld_wb_chatbot_email_unsubscription' );
add_action( 'wp_ajax_nopriv_qcld_wb_chatbot_email_unsubscription', 'qcld_wb_chatbot_email_unsubscription' );

function qcld_wpcfb_file_upload() {
	
	global $wpdb;
	
	
	
	$upload_dir   = wp_upload_dir();
	$path = $upload_dir['path'];
	$url = $upload_dir['url'];
	$status = array('status'=>'failed');
	$extensions = array();
	$mar_file_size = '';
	

	
	if(isset($_FILES['cfb_file']) && isset($_POST['formid']) && isset($_POST['fieldid'])){
		$formid = $_POST['formid'];
		$fieldid = $_POST['fieldid'];
		
		$result = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_forms where form_id='".$formid."' and type='primary'");
		$form = maybe_unserialize($result->config);
		
		$fieldetails = qc_get_details_by_fieldid($form, $fieldid);
		
		if(isset($fieldetails['config'])){
			
			if(isset($fieldetails['config']['allowed']) && $fieldetails['config']['allowed']!=''){
				$extensions = explode(',', strtolower($fieldetails['config']['allowed']));
			}
			if(isset($fieldetails['config']['max_upload']) && $fieldetails['config']['max_upload']!=''){
				$mar_file_size = $fieldetails['config']['max_upload'];
			}
		}
		
		$errors= array();
		for($i=0;$i<sizeof($_FILES['cfb_file']['name']);$i++){
		
			$file_name = $_FILES['cfb_file']['name'][$i];
			$file_size =$_FILES['cfb_file']['size'][$i];
			$file_tmp =$_FILES['cfb_file']['tmp_name'][$i];
			$file_type=$_FILES['cfb_file']['type'][$i];
			
			
			$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			
			if(!empty($extensions)){
				if(in_array($ext, $extensions)=== false){
					$errors[]=(get_option('qlcd_wp_chatbot_ext_not_allowed') != '' ? get_option('qlcd_wp_chatbot_ext_not_allowed') : 'Extension not allowed, please choose a valid file.');
				}
			}

			
			if($mar_file_size!=''){
				if($file_size > $mar_file_size){ //max 2mb
					$errors[]=(get_option('qlcd_wp_chatbot_file_size_excd') != '' ? get_option('qlcd_wp_chatbot_file_size_excd') : 'Max file upload size exceed.');
				}
			}
			
			if(empty($errors)==true){
				if(move_uploaded_file($file_tmp, $path."/".$file_name)){
					$status['status'] = 'success';
					$status['url'][] = $url.'/'.$file_name;
					
				}else{
					$errors[] = (get_option('qlcd_wp_chatbot_file_upload_fail') != '' ? get_option('qlcd_wp_chatbot_file_upload_fail') : 'Failed to upload the file.');
				}
			 
			}
		
		}
		
		if(!empty($errors)){
			$status['errors'] = $errors;
			$status['status'] = 'failed';
			
		}
		
	}else{
		$status['errors'] = array((get_option('qlcd_wp_chatbot_file_upload_fail') != '' ? get_option('qlcd_wp_chatbot_file_upload_fail') : 'Failed to upload the file.'));
	}
	
	echo json_encode($status);
	
	die();
}

add_action( 'wp_ajax_qcld_wpcfb_file_upload', 'qcld_wpcfb_file_upload' );
add_action( 'wp_ajax_nopriv_qcld_wpcfb_file_upload', 'qcld_wpcfb_file_upload' );

function qcld_wb_chatbot_send_query() {

	$name = trim(sanitize_text_field($_POST['name']));
	$email = sanitize_email($_POST['email']);
	$data = $_POST['data'];

    $subject = 'Query details from WPWBot by Client';
    //Extract Domain
    $url = get_site_url();
    $url = parse_url($url);
    $domain = $url['host'];
    
    $admin_email = get_option('admin_email');
    $toEmail = get_option('qlcd_wp_chatbot_admin_email') != '' ? get_option('qlcd_wp_chatbot_admin_email') : $admin_email;
	$fromEmail = "wordpress@" . $domain;
	
	if(get_option('qlcd_wp_chatbot_from_email') && get_option('qlcd_wp_chatbot_from_email')!=''){
		$fromEmail = get_option('qlcd_wp_chatbot_from_email');
	}
	
	$replyto = $fromEmail;

	if(get_option('qlcd_wp_chatbot_reply_to_email') && get_option('qlcd_wp_chatbot_reply_to_email')!=''){
		$replyto = get_option('qlcd_wp_chatbot_reply_to_email');
	}

    //Starting messaging and status.
    $response['status'] = 'fail';
    $response['message'] = esc_html(str_replace('\\', '',get_option('qlcd_wp_chatbot_email_fail')));

	//build email body
	$bodyContent = "";
	$bodyContent .= '<p><strong>' . esc_html__('Query Details', 'wpchatbot') . ':</strong></p><hr>';
	
	$bodyContent .= '<p>' . esc_html__('Name', 'wpchatbot') . ' : ' . esc_html($name) . '</p>';
	$bodyContent .= '<p>' . esc_html__('Email', 'wpchatbot') . ' : ' . esc_html($email) . '</p>';
	foreach($data as $key=>$val){
		if(!is_array($val)){
			$bodyContent .= '<p>'.esc_html($key).': ' . esc_html($val) . '</p>';
		}else{
			foreach($val as $k=>$v){
				$bodyContent .= '<p>'.esc_html($k).': ' . esc_html($v) . '</p>';
			}
			
		}
		
	}
		
	$bodyContent .= '<p>' . esc_html__('Mail Generated on', 'wpchatbot') . ': ' . current_time('F j, Y, g:i a') . '</p>';
	$to = $toEmail;
	$body = $bodyContent;

	$headers = array();
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	$headers[] = 'From: ' . esc_html($name) . ' <' . esc_html($fromEmail) . '>';
	$headers[] = 'Reply-To: '. esc_html($replyto) .'';

	$result = wp_mail($to, $subject, $body, $headers);
	if ($result) {
		$response['status'] = 'success';

		$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_email_sent'));
		if( is_array( $texts ) && isset( $texts[get_wpbot_locale()] )){
			$texts = $texts[get_wpbot_locale()];
		}

		$response['message'] = esc_html(str_replace('\\', '',$texts));
	}
    
    ob_clean();
    echo json_encode($response);
    die();

}

add_action( 'wp_ajax_qcld_wb_chatbot_send_query',        'qcld_wb_chatbot_send_query' );
add_action( 'wp_ajax_nopriv_qcld_wb_chatbot_send_query', 'qcld_wb_chatbot_send_query' );

function qcld_wpbd_download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}
function qcld_wpbd_array2csv(array &$array)
{
   if (count($array) == 0) {
     return null;
   }

   ob_start();

   $df = fopen("php://output", 'w');

   $titles = array('Name', 'Email');

   fputcsv($df, $titles);

   foreach ($array as $row) {
      fputcsv($df, $row);
   }

   fclose($df);

   return ob_get_clean();
}
add_action( 'admin_post_wpbprint.csv', 'qcld_wpb_export_email_csv' );
function qcld_wpb_export_email_csv(){
	global $wpdb;
	$table    = $wpdb->prefix.'wpbot_subscription';
	
    if ( ! current_user_can( 'manage_options' ) )
        return;

	$emails = $wpdb->get_results("select * from $table where 1");
	$childArray = array();
	foreach($emails as $email){
		$innerArray = array();
		$innerArray[0] = $email->name;
		$innerArray[1] = $email->email;
		array_push($childArray, $innerArray);
	}
	qcld_wpbd_download_send_headers("wpb_email_lists_" . current_time('Y-m-d') . ".csv");

	$result = qcld_wpbd_array2csv($childArray);

	print $result;
}

//site search for facebook.

function qcld_wpbo_search_site_fb($keyword) {
	
	$keyword = sanitize_text_field($keyword);

	$enable_post_types = get_option('wppt_post_types');	
	$posttypes = array( 'post', 'page' );
	if( $enable_post_types && is_array( $enable_post_types ) && ! empty( $enable_post_types ) ){
		$posttypes = $enable_post_types;
	}

	//Product will get priority first
	if(in_array('product', $posttypes)){
		unset($posttypes[array_search ('product', $posttypes)]);
		array_unshift($posttypes, "product");
	}

	$results = new WP_Query( array(
		'post_type'     => $posttypes,
		'post_status'   => 'publish',
		'posts_per_page'=> 10,
		's'             => stripslashes( $keyword ),
	) );

	$msg = (get_option('qlcd_wp_chatbot_we_have_found')!=''?get_option('qlcd_wp_chatbot_we_have_found'):'We have found these results');
	

	$response = array();
	$response['status'] = 'fail';
	
	if ( !empty( $results->posts ) ) {
		$keyword = qc_strpro_remove_stopwords( $keyword );
		if ( $keyword != '' ) {
			$results = new WP_Query( array(
				'post_type'     => $posttypes,
				'post_status'   => 'publish',
				'posts_per_page'=> 10,
				's'             => stripslashes( $keyword ),
			) );
		}
	}

	if ( !empty( $results->posts ) ) {

		$response['status'] = 'success';
		$response['results'] = array();
		foreach ( $results->posts as $result ) {
			$featured_img_url = get_the_post_thumbnail_url($result->ID,'thumbnail');
			if($featured_img_url==''){
				$featured_img_url = QCLD_wpCHATBOT_IMG_URL.'wp_placeholder.png';
			}
			$response['results'][] = array(
				'imgurl'=>qc_wpbot_url_validator($featured_img_url),
				'link'=>qc_wpbot_url_validator(get_permalink($result->ID)),
				'title'=>$result->post_title
			);
		}
		
	}else{
		$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_no_result'));
		$response['message'] = $texts[array_rand($texts)];
	}
	wp_reset_query();
	return $response;

	die();
}

function qc_wpbot_url_validator($url){
	return $url;
}


function qc_wpbot_input_validation($data) {
	$data = html_entity_decode($data);
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
  }

function qc_strpro_remove_stopwords($keyword){
	
	if(get_option('qlcd_wp_chatbot_stop_words') && get_option('qlcd_wp_chatbot_stop_words')!=''){

		$commonWords = explode(',', strtolower(get_option('qlcd_wp_chatbot_stop_words')));
		return trim(preg_replace('!\s+!', ' ', preg_replace('/\b('.implode('|',$commonWords).')\b/','',strtolower($keyword))));

	}else{
		return $keyword;
	}
	
 
	
}

add_action( 'wp_ajax_qcld_wb_chatbot_search_product_by_tag',        'qcld_wb_chatbot_search_product_by_tag' );
add_action( 'wp_ajax_nopriv_qcld_wb_chatbot_search_product_by_tag', 'qcld_wb_chatbot_search_product_by_tag' );

if(!function_exists('qcld_wb_chatbot_search_product_by_tag')){
	function qcld_wb_chatbot_search_product_by_tag(){
		$tags = $_POST['tags'];
		$paged = (isset($_POST['paged'])?sanitize_text_field($_POST['paged']):1);
		$original_tags = $tags;
		$tags = str_replace(',', '+', $tags);
		$total_items = (get_option('wppt_number_of_result')==''?'5':get_option('wppt_number_of_result'));
		$args = array(
			'post_type'     => 'product',
			'post_status'   => 'publish',
			'posts_per_page' => $total_items,
			'product_tag'	=> $tags,
			'paged'			=> $paged,
		);
		$resultss = new WP_Query( $args );
		$results = $resultss->posts;
		
		$args2 = array(
			'post_type'     => 'product',
			'post_status'   => 'publish',
			'posts_per_page' => -1,
			'product_tag'	=> $tags
		);
		$totalresults = new WP_Query( $args2 );
		$total_results = $totalresults->post_count;
		
		
		
		$html = '<div class="wp-chatbot-products-area">';
		$_pf = new WC_Product_Factory();
		//repeating the products
		if (count($results) > 0) {
			$html .= '<ul class="wp-chatbot-products">';
			foreach($results as $result):
				$product = $_pf->get_product($result->ID);
				if (qcld_wp_chatbot_product_controlling($result->ID) == true) {
					$html .= '<li class="wp-chatbot-product">';
					$html .= '<a target="_blank" href="' . get_permalink($result->ID) . '"  wp-chatbot-pid= "' . $result->ID . '" title="' . esc_attr($product->get_title()) . '">';
					$html .= get_the_post_thumbnail($result->ID, 'shop_catalog') . '
					   <div class="wp-chatbot-product-summary">
					   <div class="wp-chatbot-product-table">
					   <div class="wp-chatbot-product-table-cell">
					   <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
					   <div class="price">' . ($product->get_price_html()) . '</div>';
					$html .= ' </div>
					   </div>
					   </div></a>
					   </li>';
				}
			endforeach;
			wp_reset_postdata();
			$html .= '</ul>';
			
			if ($total_results > ($total_items * $paged)  ) {
				$html .= '<p class="wpbot_p_align_center"><button type="button" id="wp-chatbot-loadmore" data-offset="' . esc_html($paged+1) . '" data-search-type="product" data-search-tag="' . esc_html($original_tags) . '" >' . qcld_wpb_randmom_message_handle(maybe_unserialize(get_option('qlcd_wp_chatbot_load_more'))) . ' <span id="wp-chatbot-loadmore-loader"></span></button> </p>';
			}
		}
		$html .= '</div>';
		
		$response = array('html' => $html, 'product_num' => $total_results, 'per_page' => $total_items, 'tags'=> $original_tags);
		echo wp_send_json($response);
		
		die(0);
	}
}