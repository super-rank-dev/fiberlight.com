<?php 
/* WPBot Post Type Search addon - Search function */

function qcpd_wppt_search_fnc($keyword){
	global $wpdb;
	

	$get_cpt_args = array(
		'public'   => true,
		'_builtin' => false
	);
	$post_types = get_post_types( $get_cpt_args, 'object' );	
	$enable_post_types = get_option('wppt_post_types');	
	$total_items = (get_option('wppt_number_of_result')==''?'5':get_option('wppt_number_of_result'));
	
	$orderby = (get_option('wppt_result_orderby')==''?'none':get_option('wppt_result_orderby'));
	$order = (get_option('wppt_result_order')==''?'ASC':get_option('wppt_result_order'));
	$thumb = (get_option('wpbot_search_image_size')?get_option('wpbot_search_image_size'):'thumbnail');
	//order by setup

	//$keywords = sysnonims_origin($keyword);
	// if(!empty($keywords)){
	// 	$keyword = $keywords;
	// }
	
	// if(empty($keywords)){
	// 	$keyword = $keyword;
	// }
	$searchkeyword = qcld_wpbot_modified_keyword($keyword);
	
	$new_window = get_option('wpbot_search_result_new_window');
	
	$load_more = maybe_unserialize(get_option('qlcd_wp_chatbot_load_more'));
	
	if( is_array( $load_more ) && isset( $load_more[get_locale()] )){
		$load_more = $load_more[get_locale()];
	}
	if( is_array( $load_more ) ){
		$load_more = $load_more[array_rand($load_more)];
	}
	
	//Product will get priority first
	if(in_array('product', $enable_post_types)){
		unset($enable_post_types[array_search ('product', $enable_post_types)]);
		array_unshift($enable_post_types, "product");
	}
	
	$response = array();
	$response['status'] = 'fail';
	$response['html'] = '';
	
	
	foreach($enable_post_types as $enable_post_type){
		if(class_exists('SitePress')){
			global $sitepress;
			$selected_lan = sanitize_text_field($_POST['language']);
			$selected_lan = explode('_',$selected_lan);
			$sitepress->switch_lang($selected_lan[0], true);
		}

		$query_arg = array(
			'post_type'     => $enable_post_type,
			'post_status'   => 'publish',
			'posts_per_page'=> $total_items,
			's'             => stripslashes( $keyword ),
			'paged'			=> 1,
			'orderby'		=> $orderby,
			'suppress_filters' => true
		);
		if($orderby!='none' or $orderby!='rand'){
			$query_arg['order'] = $order;
		}			
		$totalresults = new WP_Query( array(
			'post_type'     => $enable_post_type,
			'post_status'   => 'publish',
			's'             => stripslashes( $keyword ),
			
		) );
		$total_results = $totalresults->posts;
		$resultss = new WP_Query( $query_arg );
		$results = $resultss->posts;
		$fuzzy_response = false;
		if(empty($total_results)){

			$fuzzy_response = wppt_fuzzy_search($searchkeyword, $enable_post_type, $total_items);

		}
		if($enable_post_type=='product'){
			$newresults = array();
			foreach($results as $result){
				if (qcld_wp_chatbot_product_controlling($result->ID) == true) {
					$newresults[] = $result;
				}
			}
			$results = $newresults;
			$total_results = $newresults;
		}
		
		

		$msg = get_option('wppt_heading_'.$enable_post_type);
		if( ! $msg || $msg == '' ){
			$selected_lan = sanitize_text_field($_POST['language']);
			$msg = (get_option('qlcd_wp_chatbot_we_have_found')!=''? maybe_unserialize(get_option('qlcd_wp_chatbot_we_have_found')):'We have found the following results');
			$msg = $msg[$selected_lan];
			if( is_array( $msg ) && isset( $msg[get_locale()] )){
				$msg = $msg[get_locale()];
			}

		}
		
		if ( $fuzzy_response == false && !empty( $results ) ) {
			
			$response['status'] = 'success';
			$response['html'] .= '<div class="wpb-search-result">';
			$total_post = 0;
			$responses = '';
			foreach ( $results as $result ) {
				
				if($result->post_type=='product'){
					if ( !class_exists( 'WooCommerce' ) ) {
						continue;
					}
				}
				$selected_lan = sanitize_text_field($_POST['language']);
				$url_check = str_replace(site_url(), '', get_permalink($result->ID));
				
				$url_check = explode('/',$url_check);
				$url_check = str_replace('/', '', $url_check);
				$languages = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_msg')));
				$languages = array_keys($languages);

				
				if( in_array($url_check[1], $languages, true) && (count($languages) >= 2) ){
					if($url_check[1] == $selected_lan){
						$responses = '';
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
					$responses .=	'<div class="wpbot_card_image '.($result->post_type=='product'?'wp-chatbot-product':'').' '.('wpbot_card_image_saas').'"><a href="'.esc_url(get_permalink($result->ID)).'" '.($new_window==1?'target="_blank"':'').' '.($result->post_type=='product'?'wp-chatbot-pid="'.$result->ID.'"':'').'>';
					if(isset($featured_img_url)){
						$responses .=		'<img src="'.esc_url_raw($featured_img_url).'" />';
					}
					$responses .=		'<div class="wpbot_card_caption wpbot_card_caption_saas">';
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
			//var_dump($total_post);
			//$response['html'] .= '<p>'.$msg.'</p>';
			$response['html'] .= $responses;
			$response['html'] .='</div>';
			
			if(count($total_results) > $total_items){
				$load_more = maybe_unserialize(get_option('qlcd_wp_chatbot_load_more'));
				$load_more = $load_more[array_rand($load_more)];
				$response['status'] = 'success';
				$response['html'] .='<button type="button" class="wp-chatbot-loadmore" data-post_type="'.$result->post_type.'" data-keyword="'.$keyword.'" data-page="1">'.$load_more[0].'<span class="wp-chatbot-loadmore-loader"></span></button>';
			}
			
		}elseif( $fuzzy_response ){
			$response['status'] = 'success';
			$response['html'] .= $fuzzy_response['html'];
		}
		wp_reset_query();
		
	}
	
	if (get_option('wppt_rest_api_search') ==1 ){
		$rest_api_urls =  get_option('wppt_rest_api_urls');
		$count_rap = 0;
		foreach ($rest_api_urls as $k => $url) {
			$keyword = preg_replace('/ /', '%20', $keyword);
			$data_url =($url .'/wp-json/qcld-rest/v1/search/'.$keyword);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $data_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_AUTOREFERER, true); 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_VERBOSE, 1);
			$output = curl_exec($curl);
			
			curl_close($curl);
			$api_response = json_decode($output,true);
			if($api_response['code'] != 'empty_category'){
				if(isset($api_response) && count($api_response) >= 1 ){
					$response['status'] = 'success';
					$response['html'] .= '<div class="wpb-search-result">';
					foreach ($api_response as $key => $value) {
						if(!empty($value['title']) &&  !is_string($value)){
							$count_rap = $count_rap + 1;
							$response['html'] .=	'<a href="'.esc_url( $value['url']).'" target="_blank" style="padding: 0 !important;">';
							$response['html'] .='			<div class="'.esc_url( $url).'"><div class="wpbot_restapi_list">';
							$response['html'] .=						esc_html($value['title'] );
							$response['html'] .=						'<div >';
							$response['html'] .=					'<p>'.esc_html( $value['content']).'</p>';
							$response['html'] .=				'<p>'.esc_url( $url).'</p>';
							$response['html'] .=			'</div>';
							$response['html'] .=		'</div></div>';	
							$response['html'] .=	'</a>';
						}
					}
					$response['html'] .= '</div>';
				}
				
			}
		
			
		}	
	//	$response['html'] .= $api_response['message'];
		if($count_rap > 0){
			$response['html'] .= '</br>';
			$response['html'] .= '<span class="qcld-chatbot-site-search ui-draggable ui-draggable-handle qc_draggable_item_remove ui-sortable-handle">' . esc_html('Search Again') . '</span>';
		}
		echo json_encode($response);
		wp_die();
	}
	if($response['status']!='success' && get_option('wppt_wiki_search')==1 ){
		$data = wp_remote_get('https://en.wikipedia.org/w/api.php?origin=*&action=opensearch&search='.$keyword.'&limit='.$total_items.'&namespace=0&format=json');
		$api_response = json_decode( wp_remote_retrieve_body( $data ), true );
		if( ! isset( $api_response['error'] ) ){
			$titles = $api_response[1];
			$urls = $api_response[3];
			$response['status'] = 'success';
			$response['html'] .= '<div class="wpb-search-result">';

			
			$msg = get_option('wppt_heading_wiki');
			if( ! $msg || $msg == '' ){

				$msg = 'We have found #Number Wikipedia article for the keyword #Keyword';

				if( is_array( $msg ) && isset( $msg[get_locale()] )){
					$msg = $msg[get_locale()];
				}

			}

			$response['html'] .= '<p>'.str_replace(array('#Number', '#result' , '#Keyword', '#keyword'),array(esc_html(count($titles)), esc_html(count($titles)), esc_html($_POST['keyword']), esc_html($_POST['keyword'])),$msg).'</p>';
			
			for( $i=0;$i < count( $titles ); $i++ ){
			//foreach ( $results as $result ) {

				$response['html'] .='<div class="wpbot_wiki_list" style="color:#000">';
				$response['html'] .=	'<a href="'.esc_url($urls[$i]).'" target="_blank">';
				$response['html'] .=	esc_html($titles[$i]);
				$response['html'] .=	'</a>';
				$response['html'] .='</div>';				
			}
			$response['html'] .='</div>';

		}
		
	}

	if($response['status']!='success' && get_option('wppt_google_search')==1 && get_option('wppt_google_api_key') !='' && get_option('wppt_google_search_id') != '' ){
		$data = wp_remote_get('https://www.googleapis.com/customsearch/v1?key='.get_option('wppt_google_api_key').'&cx='.get_option('wppt_google_search_id').'&q='.$keyword);
		$api_response = json_decode( wp_remote_retrieve_body( $data ), true );

		if( ! isset( $api_response['error'] ) && isset( $api_response['items'] ) && count( $api_response['items'] ) > 0 ){
			$results = $api_response['items'];
			$response['status'] = 'success';
			$response['html'] .= '<div class="wpb-search-result">';
			
			$msg = get_option('wppt_heading_google');
			if( ! $msg || $msg == '' ){

				$msg = 'We have found #Number results from google for the keyword #Keyword';

				if( is_array( $msg ) && isset( $msg[get_locale()] )){
					$msg = $msg[get_locale()];
				}

			}

			$response['html'] .= '<p>'.str_replace(array('#Number', '#result' , '#Keyword', '#keyword'),array(esc_html(count($results)), esc_html(count($results)), esc_html($_POST['keyword']), esc_html($_POST['keyword'])),$msg).'</p>';
			
			foreach( $results as $result ){
			//foreach ( $results as $result ) {

				$response['html'] .='<div class="wpbot_google_list" style="color:#000">';
				$response['html'] .=	'<a href="'.esc_url( $result['link'] ).'" target="_blank">';
				$response['html'] .=	esc_html( $result['title'] );
				$response['html'] .=	'</a>';
				$response['html'] .=	'<p>'. $result['snippet'] .'</p>';
				$response['html'] .='</div>';				
			}
			$response['html'] .='</div>';

		}
		
	}

	if($response['status']!='success'){
		$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_no_result'));
		$selected_lan = sanitize_text_field($_POST['language']);
		$texts =  str_replace( "\'", "'", $texts[$selected_lan][0]); 
		$response['html'] = [$texts];
		
	}
	echo json_encode($response);
	die();
	
}

function sysnonims_origin($keyword){
	global $wpdb;
	$vari_arry = explode(" ",$keyword);
	$all = [];
	foreach ($vari_arry as $key => $value) {
		$sql = "SELECT word FROM `{$wpdb->prefix}wpbot_synonyms` WHERE `synonyms` LIKE '%{$value}%'" ;
		$result = $wpdb->get_results($sql);
		if(!empty($result)){
			$all[] = $result[0]->word;
		}
	}
	$keywords = implode("%20",$all);
	return $keywords;
}
//WoowBot extended search

add_action('wp_ajax_qcld_woo_chatbot_keyword_extended', 'qcld_woo_chatbot_keyword_extended');
add_action('wp_ajax_nopriv_qcld_woo_chatbot_keyword_extended', 'qcld_woo_chatbot_keyword_extended');
function qcld_woo_chatbot_keyword_extended(){
	global $wpdb;
	
	$get_cpt_args = array(
		'public'   => true,
		'_builtin' => false
	);
	
	$keyword = sanitize_text_field($_POST['keyword']);
	
	$load_more = maybe_unserialize(get_option('qlcd_wp_chatbot_load_more'));

	if( is_array( $load_more ) && isset( $load_more[get_locale()] )){
		$load_more = $load_more[get_locale()];
	}
	if( is_array( $load_more ) ){
		$load_more = $load_more[array_rand($load_more)];
	}


	$post_types = get_post_types( $get_cpt_args, 'object' );	
	$enable_post_types = get_option('wppt_post_types');

	$total_items = (get_option('wppt_number_of_result')==''?'5':get_option('wppt_number_of_result'));
	
	$orderby = (get_option('wppt_result_orderby')==''?'none':get_option('wppt_result_orderby'));
	$order = (get_option('wppt_result_order')==''?'ASC':get_option('wppt_result_order'));
	$thumb = (get_option('wpbot_search_image_size')?get_option('wpbot_search_image_size'):'thumbnail');
	//order by setup

	$searchkeyword = qcld_woowbot_modified_keyword($keyword);
	$new_window = get_option('wpbot_search_result_new_window');
	
	//Product will get priority first
	if(in_array('product', $enable_post_types)){
		unset($enable_post_types[array_search ('product', $enable_post_types)]);
		//array_unshift($enable_post_types, "product");
	}
	$response = array();
	$response['status'] = 'fail';
	$response['html'] = '';

	foreach($enable_post_types as $enable_post_type){
		
		
		$sql = "SELECT * FROM ". $wpdb->prefix."posts where post_type in ('".$enable_post_type."') and post_status='publish' and ((post_title REGEXP '\\b".$searchkeyword."\\b'))";
		
		$total_results = $wpdb->get_results($sql);
		$fuzzy_response = false;

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
			$fuzzy_response = wppt_fuzzy_search($searchkeyword, $enable_post_type, $total_items);
			
			if( $fuzzy_response == false ){
				$query_arg = array(
					'post_type'     => $enable_post_type,
					'post_status'   => 'publish',
					'posts_per_page'=> $total_items,
					's'             => stripslashes( $keyword ),
					'paged'			=> 1,
					'orderby'		=> $orderby,
				);
				if($orderby!='none' or $orderby!='rand'){
					$query_arg['order'] = $order;
				}			
				$totalresults = new WP_Query( array(
					'post_type'     => $enable_post_type,
					'post_status'   => 'publish',
					's'             => stripslashes( $keyword ),
					
				) );
				$total_results = $totalresults->posts;
				$resultss = new WP_Query( $query_arg );
				$results = $resultss->posts;
			}
		}
		
		
		if($enable_post_type=='product'){
			$newresults = array();
			foreach($results as $result){
				if (qcld_wp_chatbot_product_controlling($result->ID) == true) {
					$newresults[] = $result;
				}
			}
			$results = $newresults;
			$total_results = $newresults;
		}
		

		$msg = get_option('wppt_heading_'.$enable_post_type);
		
		if ( $fuzzy_response == false && !empty( $results ) ) {
			$response['status'] = 'success';
			$response['html'] .= '<div class="wpb-search-result">';
			$response['html'] .= '<p>'.str_replace(array('#Number', '#Keyword'),array(esc_html(count($total_results)), esc_html($_POST['keyword'])),$msg).'</p>';
			foreach ( $results as $result ) {
				
				if($result->post_type=='product'){
					if ( !class_exists( 'WooCommerce' ) ) {
						continue;
					}
				}

				$featured_img_url = get_the_post_thumbnail_url($result->ID, $thumb);
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
			$response['html'] .= '<p>'.$msg.'</p>';
			$response['html'] .= $responses;
			$response['html'] .='</div>';
			
			if(count($total_results) > $total_items){
				$response['status'] = 'success';
				$response['html'] .='<button type="button" class="wp-chatbot-loadmore" data-post_type="'.$result->post_type.'" data-keyword="'.$keyword.'" data-page="1">'.$load_more[0].'<span class="wp-chatbot-loadmore-loader"></span></button>';
			}
			
		}elseif( $fuzzy_response ){
			$response['status'] = 'success';
			$response['html'] .= $fuzzy_response['html'];
		}
		wp_reset_query();
		
	}
	
	if($response['status']!='success'){
		$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_no_result'));
		$selected_lan = sanitize_text_field($_POST['language']);
		$texts =  str_replace( "\'", "'", $texts[$selected_lan][0]); 
		$response['html'] = [$texts];
		
	}
	echo json_encode($response);
	die();
	
}


function wpbo_search_site_pagination(){
	global $wpdb;
	
	$keyword = sanitize_text_field($_POST['keyword']);
	$post_type = sanitize_text_field($_POST['type']);
	$page = sanitize_text_field($_POST['page']);
	$enable_post_types = get_option('wppt_post_types');
	$load_more = maybe_unserialize(get_option('qlcd_wp_chatbot_load_more'));

	if( is_array( $load_more ) && isset( $load_more[get_locale()] )){
		$load_more = $load_more[get_locale()];
	}
	if( is_array( $load_more ) ){
		$load_more = $load_more[array_rand($load_more)];
	}
	
	$orderby = (get_option('wppt_result_orderby')==''?'none':get_option('wppt_result_orderby'));
	$order = (get_option('wppt_result_order')==''?'ASC':get_option('wppt_result_order'));
	$thumb = (get_option('wpbot_search_image_size')?get_option('wpbot_search_image_size'):'thumbnail');
	//order by setup
	$new_window = get_option('wpbot_search_result_new_window');
	
	$total_items = get_option('wppt_number_of_result');

	$searchkeyword = qcld_wpbot_modified_keyword($keyword);

	$response = array();
	$response['status'] = 'fail';
	$response['html'] = '';

	$sql = "SELECT * FROM ". $wpdb->prefix."posts where post_type in ('".$post_type."') and post_status='publish' and ((post_title REGEXP '\\b".$searchkeyword."\\b'))";
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
		
		if($orderby!='none' or $orderby!='rand'){
			$sql .= " order by $orderby $order";
		}
		$limit = " Limit ".($total_items*$page).", $total_items";
		
		$results = $wpdb->get_results($sql.$limit);
	}else{
		if(class_exists('SitePress')){
			global $sitepress;
			$selected_lan = sanitize_text_field($_POST['language']);
			$selected_lan = explode('_',$selected_lan);
			$sitepress->switch_lang($selected_lan[0], true);
		}
		$query_arg = array(
			'post_type'     => $post_type,
			'post_status'   => 'publish',
			'posts_per_page'=> $total_items,
			's'             => stripslashes( $keyword ),
			'paged'			=> ($page+1),
			'orderby'		=> $orderby,
			'suppress_filters' => true
		);
		if($orderby!='none' or $orderby!='rand'){
			$query_arg['order'] = $order;
		}
			
		$totalresults = new WP_Query( array(
			'post_type'     => $post_type,
			'post_status'   => 'publish',
			's'             => stripslashes( $keyword ),
			
		) );
		$resultss = new WP_Query( $query_arg );
		$total_results = $totalresults->posts;
		$resultss = new WP_Query( $query_arg );
		$results = $resultss->posts;
	}
	
	if($enable_post_type=='product'){
		$newresults = array();
		foreach($results as $result){
			if (qcld_wp_chatbot_product_controlling($result->ID) == true) {
				$newresults[] = $result;
			}
		}
		$results = $newresults;
		$total_results = $newresults;
	}
	
		
		$msg = get_option('wppt_heading_'.$enable_post_type);
		

		if ( !empty( $results ) ) {
			$response['status'] = 'success';
			$response['html'] .= '<div class="wpb-search-result">';
			foreach ( $results as $result ) {
				
				if($result->post_type=='product'){
					if ( !class_exists( 'WooCommerce' ) ) {
						continue;
					}
				}

				$featured_img_url = get_the_post_thumbnail_url($result->ID, $thumb);
				


				$response['html'] .='<div class="wpbot_card_wraper">';
				$response['html'] .=	'<div class="wpbot_card_image '.($result->post_type=='product'?'wp-chatbot-product':'').' '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.esc_url(get_permalink($result->ID)).'" '.($new_window==1?'target="_blank"':'').' '.($result->post_type=='product'?'wp-chatbot-pid="'.$result->ID.'"':'').'>';
				if($featured_img_url!=''){
					$response['html'] .=		'<img src="'.esc_url_raw($featured_img_url).'" />';
				}
				
				$response['html'] .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
				$response['html'] .=			'<h2>'.esc_html($result->post_title).'</h2>';
				if($result->post_type=='product'){
					if ( class_exists( 'WooCommerce' ) ) {
						$product = wc_get_product( $result->ID );
						$response['html'] .=			'<p class="wpbot_product_price">'.get_woocommerce_currency_symbol().$product->get_price_html().'</p>';
					}
					
				}
				$response['html'] .=		'</div>';
				$response['html'] .=	'</a></div>';
				$response['html'] .='</div>';			
			}
			$response['html'] .='</div>';
			
			if(count($total_results) > ($total_items*($page+1))){
				$response['html'] .='<button type="button" class="wp-chatbot-loadmore" data-post_type="'.$result->post_type.'" data-keyword="'.$keyword.'" data-page="'.($page+1).'">'.$load_more[0].'<span class="wp-chatbot-loadmore-loader"></span></button>';
			}
			
		}
		wp_reset_query();
		
	
	
	if($response['status']!='success'){
		$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_no_result'));
		$selected_lan = sanitize_text_field($_POST['language']);
		$texts =  str_replace( "\'", "'", $texts[$selected_lan][0]); 
		$response['html'] = [$texts];
		
	}
	echo json_encode($response);
	die();
}


add_action( 'wp_ajax_wpbo_search_site_pagination',        'wpbo_search_site_pagination' );
add_action( 'wp_ajax_nopriv_wpbo_search_site_pagination', 'wpbo_search_site_pagination' );




function wppt_fuzzy_search( $searchkeyword, $enable_post_type, $total_items ){
	
	
	
	$enable_fuzzy_search = get_option('wppt_enable_fuzzy_search');
	$total_items = (get_option('wppt_number_of_result')==''?'5':get_option('wppt_number_of_result'));
	$wppt_search_weight = get_option('wppt_search_weight') ? get_option('wppt_search_weight') : 50;
	$new_window = get_option('wpbot_search_result_new_window');
	$thumb = (get_option('wpbot_search_image_size')?get_option('wpbot_search_image_size'):'thumbnail');
	
	$load_more = maybe_unserialize(get_option('qlcd_wp_chatbot_load_more'));

	if( is_array( $load_more ) && isset( $load_more[get_locale()] )){
		$load_more = $load_more[get_locale()];
	}
	if( is_array( $load_more ) ){
		$load_more = $load_more[array_rand($load_more)];
	}
	
	if( floatval($wppt_search_weight) >=0 && floatval($wppt_search_weight)<=100 ){
		$wppt_search_weight = $wppt_search_weight/100;
	}else{
		$wppt_search_weight = 0.5;
	}


	if( ( strlen($searchkeyword) >=3 ) && isset($enable_fuzzy_search) && ($enable_fuzzy_search == 1) ){
		global $wpdb;
		$response['status'] = 'fail';
		$response['html'] = '';
		$wppt_file_name = wp_upload_dir()['basedir'] . '/wppt/wppt-data.txt';
		$wppt_file_content = array();
		if( file_exists($wppt_file_name) ){
			$wppt_file_content = json_decode( file_get_contents($wppt_file_name), true );
		}
		
		//foreach ($enable_post_types as $enable_post_type) {
			$msg = get_option('wppt_heading_'.$enable_post_type);
			$results_ID = array();
			$results = array();
			$current_post_type_array = array_filter($wppt_file_content, function($elem) use ($enable_post_type){
				return $elem['post_type'] == $enable_post_type;
			});
			$wppt_enable_alt_title = get_option('wppt_enable_alt_title');
			if( $wppt_enable_alt_title == 1 ){
				$fuse = new \Fuse\Fuse($current_post_type_array,
					[
					  "keys" => [
					  	[
					      "name" => 'title',
					      "weight" => $wppt_search_weight
					    ],
					    [
					      "name" => 'alt_title',
					      "weight" => $wppt_search_weight
					    ]
					  ],
					  'threshold' => $wppt_search_weight,
					  'includeScore' => true,
					  'minMatchCharLength' => 3,
					]
				);
			}else{
				$fuse = new \Fuse\Fuse($current_post_type_array,
					[
					  "keys" => [
					  	[
					      "name" => 'title',
					      "weight" => $wppt_search_weight
					    ]
					  ],
					  'threshold' => $wppt_search_weight,
					  'includeScore' => true,
					  'minMatchCharLength' => 3,
					]
				);
			}

			$fuse_result = $fuse->search($searchkeyword);

			foreach ($fuse_result as $key => $value) {
				array_push($results_ID, $value['item']['ID']);
			}

			// $sql_search = "SELECT ID FROM ". $wpdb->prefix."posts where post_type in ('".$enable_post_type."') and post_status='publish' and ((post_content REGEXP '[[:<:]]".$searchkeyword."[[:>:]]') or (post_excerpt REGEXP '[[:<:]]".$searchkeyword."[[:>:]]') )";
		
			// $total_results = $wpdb->get_results($sql_search);

			// foreach ($total_results as $value) {
			// 	array_push($results_ID, $value->ID);
			// }

			$results_ID = array_unique($results_ID);

			if(!empty($results_ID)){
				$args = array(
					'post_type'     => $enable_post_type,
					'post_status'   => 'publish',
					'posts_per_page' => $total_items,
					'post__in' => $results_ID,
					'orderby' => 'post__in'
				);
				$resultss = new WP_Query( $args );
				$results = $resultss->posts;

				$total_results = $results_ID;
			}

			if ( !empty( $results ) ) {
				$response['status'] = 'success';
				$response['html'] .= '<div class="wpb-search-result wpb-fuzzy-matching-results">';
				$response['html'] .= '<p>'.str_replace(array('#Number', '#Keyword'),array(esc_html(count($total_results)), esc_html($_POST['keyword'])),$msg).'</p>';
				foreach ( $results as $result ) {
					
					if($result->post_type=='product'){
						if ( !class_exists( 'WooCommerce' ) ) {
							continue;
						}
					}
					$featured_img_url = get_the_post_thumbnail_url($result->ID, $thumb);
					$selected_lan = sanitize_text_field($_POST['language']);
					$url_check = str_replace(site_url(), '', get_permalink($result->ID));
					$url_check = explode('/',$url_check);
					$url_check = str_replace('/', '', $url_check);
					$languages = qcld_wpbot()->helper->qcld_wb_chatbot_str_replace(maybe_unserialize(get_option('qlcd_wp_chatbot_wildcard_msg')));
					$languages = array_keys($languages);
					$total_post = 0;
					$responses = '';
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
				//$response['html'] .= '<p>'.$msg.'</p>';
				$response['html'] .= $responses;
				$response['html'] .='</div>';
				
				if(count($total_results) > $total_items){
					$response['html'] .='<button type="button" class="wp-chatbot-fuse-loadmore" data-post_type="'.$result->post_type.'" data-keyword="'.$searchkeyword.'" data-page="1">'.$load_more[0].'<span class="wp-chatbot-loadmore-loader"></span></button>';
				}
				
			}
			wp_reset_query();
		//}

		if($response['status'] == 'success'){
			return $response;
		}else{
			return false;
		}
	}
} 


function wpbo_fuse_search_site_pagination(){
	$keyword = $_POST['keyword'];
	$searchkeyword = qcld_wpbot_modified_keyword($keyword);

	$page = $_POST['page'];
	$type = $_POST['type'];
	
	$load_more = maybe_unserialize(get_option('qlcd_wp_chatbot_load_more'));

	if( is_array( $load_more ) && isset( $load_more[get_locale()] )){
		$load_more = $load_more[get_locale()];
	}
	if( is_array( $load_more ) ){
		$load_more = $load_more[array_rand($load_more)];
	}
	
	$total_items = (get_option('wppt_number_of_result')==''?'5':get_option('wppt_number_of_result'));
	$enable_fuzzy_search = get_option('wppt_enable_fuzzy_search');
	$wppt_search_weight = get_option('wppt_search_weight') ? get_option('wppt_search_weight') : 50;
	$new_window = get_option('wpbot_search_result_new_window');
	$thumb = (get_option('wpbot_search_image_size')?get_option('wpbot_search_image_size'):'thumbnail');
	if( floatval($wppt_search_weight) >=0 && floatval($wppt_search_weight)<=100 ){
		$wppt_search_weight = $wppt_search_weight/100;
	}else{
		$wppt_search_weight = 0.5;
	}

	$enable_post_types = array($type);
	$offset = $page * $total_items;

	if( isset($enable_fuzzy_search) && ($enable_fuzzy_search == 1) ){
		global $wpdb;
		$response['status'] = 'fail';
		$response['html'] = '';
		$wppt_file_name = wp_upload_dir()['basedir'] . '/wppt/wppt-data.txt';
		$wppt_file_content = array();
		if( file_exists($wppt_file_name) ){
			$wppt_file_content = json_decode( file_get_contents($wppt_file_name), true );
		}
		
		foreach ($enable_post_types as $enable_post_type) {
			$msg = get_option('wppt_heading_'.$enable_post_type);
			$results_ID = array();
			$results = array();
			$current_post_type_array = array_filter($wppt_file_content, function($elem) use ($enable_post_type){
				return $elem['post_type'] == $enable_post_type;
			});

			$wppt_enable_alt_title = get_option('wppt_enable_alt_title');
			if( $wppt_enable_alt_title == 1 ){
				$fuse = new \Fuse\Fuse($current_post_type_array,
					[
					  "keys" => [
					  	[
					      "name" => 'title',
					      "weight" => $wppt_search_weight
					    ],
					    [
					      "name" => 'alt_title',
					      "weight" => $wppt_search_weight
					    ]
					  ],
					  'threshold' => $wppt_search_weight,
					  'includeScore' => true,
					  'minMatchCharLength' => 3,
					]
				);
			}else{
				$fuse = new \Fuse\Fuse($current_post_type_array,
					[
					  "keys" => [
					  	[
					      "name" => 'title',
					      "weight" => $wppt_search_weight
					    ]
					  ],
					  'threshold' => $wppt_search_weight,
					  'includeScore' => true,
					  'minMatchCharLength' => 3,
					]
				);
			}

			$fuse_result = $fuse->search($searchkeyword);

			foreach ($fuse_result as $key => $value) {
				array_push($results_ID, $value['item']['ID']);
			}

			// $sql_search = "SELECT ID FROM ". $wpdb->prefix."posts where post_type in ('".$enable_post_type."') and post_status='publish' and ((post_content REGEXP '[[:<:]]".$searchkeyword."[[:>:]]') or (post_excerpt REGEXP '[[:<:]]".$searchkeyword."[[:>:]]') )";
		
			// $total_results = $wpdb->get_results($sql_search);

			// foreach ($total_results as $value) {
			// 	array_push($results_ID, $value->ID);
			// }

			$results_ID = array_unique($results_ID);

			if(!empty($results_ID)){
				$args = array(
					'post_type'     => $enable_post_type,
					'post_status'   => 'publish',
					'offset'	=> $offset,
					'posts_per_page' => $total_items,
					'post__in' => $results_ID,
					'orderby' => 'post__in'
				);
				$resultss = new WP_Query( $args );
				$results = $resultss->posts;

				$total_results = $results_ID;
			}

			if ( !empty( $results ) ) {
				$response['status'] = 'success';
				$response['html'] .= '<div class="wpb-search-result wpb-fuzzy-matching-results">';
				$response['html'] .= '<p>'.str_replace(array('#Number', '#Keyword'),array(esc_html(count($total_results)), esc_html($_POST['keyword'])),$msg).'</p>';
				foreach ( $results as $result ) {
					
					if($result->post_type=='product'){
						if ( !class_exists( 'WooCommerce' ) ) {
							continue;
						}
					}

					$featured_img_url = get_the_post_thumbnail_url($result->ID, $thumb);
					


					$response['html'] .='<div class="wpbot_card_wraper">';
					$response['html'] .=	'<div class="wpbot_card_image '.($result->post_type=='product'?'wp-chatbot-product':'').' '.($featured_img_url==''?'wpbot_card_image_saas':'').'"><a href="'.esc_url(get_permalink($result->ID)).'" '.($new_window==1?'target="_blank"':'').' '.($result->post_type=='product'?'wp-chatbot-pid="'.$result->ID.'"':'').'>';
					if($featured_img_url!=''){
						$response['html'] .=		'<img src="'.esc_url_raw($featured_img_url).'" />';
					}
					$response['html'] .=		'<div class="wpbot_card_caption '.($featured_img_url==''?'wpbot_card_caption_saas':'').'">';
					$response['html'] .=			'<h2>'.esc_html($result->post_title).'</h2>';
					if($result->post_type=='product'){
						if ( class_exists( 'WooCommerce' ) ) {
							$product = wc_get_product( $result->ID );
							$response['html'] .=			'<p class="wpbot_product_price">'.get_woocommerce_currency_symbol().$product->get_price_html().'</p>';
						}
						
					}
					$response['html'] .=		'</div>';
					$response['html'] .=	'</a></div>';
					$response['html'] .='</div>';			
				}
				$response['html'] .='</div>';
				
				if(count($total_results) > ($total_items*($page+1))){
					$response['html'] .='<button type="button" class="wp-chatbot-fuse-loadmore" data-post_type="'.$result->post_type.'" data-keyword="'.$searchkeyword.'" data-page="'.($page+1).'">'.$load_more[0].'<span class="wp-chatbot-loadmore-loader"></span></button>';
				}
				
			}
			wp_reset_query();
		}

		if($response['status'] == 'success'){
			echo json_encode($response);
			die();
		}

		if($response['status']!='success'){
			$texts = maybe_unserialize(get_option('qlcd_wp_chatbot_no_result'));
			$selected_lan = sanitize_text_field($_POST['language']);
			$texts =  str_replace( "\'", "'", $texts[$selected_lan][0]); 
			$response['html'] = [$texts];
			
		}

		echo json_encode($response);
		die();
	}

}
add_action( 'wp_ajax_wpbo_fuse_search_site_pagination',        'wpbo_fuse_search_site_pagination' );
add_action( 'wp_ajax_nopriv_wpbo_fuse_search_site_pagination', 'wpbo_fuse_search_site_pagination' );





