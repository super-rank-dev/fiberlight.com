<?php 

function qcwpfb_get_fbpost_content($url){
	$ch = curl_init();
	//curl_setopt($ch, CURLOPT_SSL_VERIfYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36");
	$res = curl_exec($ch);
	curl_close($ch);
	$res = json_decode($res, true);
	return $res;
}

function wpfb_insert_into_database($page){
	global $wpdb;
	$table = $wpdb->prefix.'wpbot_fb_pages';
	$page_access_token = $page['access_token'];
	$page_id = $page['id'];
	$page_name = $page['name'];
	$picture = $page['picture']['data']['url'];
	$cover = $page['cover']['source'];
	
    $checkid = $wpdb->get_row("SELECT * FROM {$table} where 1 and page_id = '".$page_id."'");
	if(empty($checkid)){


		$wpdb->insert(
			$table,
			array(
				'page_name'  => $page_name,
				'page_id'   => $page_id,
				'page_access_token'   => $page_access_token,
				'picture'=> $picture,
				'cover'	=> $cover
			)
		);

	}else{
		$wpdb->update(
			$table,
			array(
				'page_name'  => $page_name,
				'page_id'=> $page_id,
				'page_access_token' => $page_access_token,
				'picture'=> $picture,
				'cover'	=> $cover
			),
			array('page_id'=>$page_id),
			array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
			),
			array('%s')
		);
		
	}
}
function wpfb_get_all_posts($page){
	$url = "https://graph.facebook.com/v3.3/".$page->page_id."/posts?access_token=".$page->page_access_token;
	return qcwpfb_get_fbpost_content($url);
}
function wpfb_get_comment_mentions_attachment( $comment_ID, $access_token ){
	$url = "https://graph.facebook.com/v12.0/".$comment_ID."?fields=message_tags,attachment&access_token=".$access_token;
	return qcwpfb_get_fbpost_content($url);
}
function wpfb_pages_list(){
	global $wpdb;
	$table = $wpdb->prefix.'wpbot_fb_pages';
	$pages = $wpdb->get_results("SELECT * FROM {$table} where 1 ");
	$data = '';
	if(!empty($pages)){
		foreach($pages as $page){			
			$data .='<a href="'.admin_url('edit.php?post_type=wpfbposts&fbpage='.$page->page_id.'&filter_action=Filter&paged=1').'" class="wpfb_page_box">'.$page->page_name.'</a>';			
		}
	}
	return $data;
}
function wpfb_get_all_pages(){
	global $wpdb;
	$table = $wpdb->prefix.'wpbot_fb_pages';
	return $wpdb->get_results("SELECT * FROM {$table} where 1 ");
}
function wpfb_insert_posts($posts, $pageid){
	
	foreach($posts as $post){
		
		$title = @$post['message'];
		$date = ( $post['created_time'] );
		$post_id = $post['id'];
		if($title!=''){
			$checkposts = get_posts(array(
				'numberposts'	=> -1,
				'post_type'		=> 'wpfbposts',
				'meta_key'		=> 'fb_post_id',
				'meta_value'	=> $post_id
			));
			
			if(empty($checkposts)){
				$my_cptpost_args = array(
					'post_title'    => $title,
					'post_date'		=> $date,
					'post_status'   => 'publish',
					'post_type' => 'wpfbposts'
				);
				$cp_id = wp_insert_post( $my_cptpost_args, $wp_error);
				add_post_meta( $cp_id, 'fb_post_id', $post_id, true );
				add_post_meta( $cp_id, 'fb_page_id', $pageid, true );
				
			}
		}

	}
}

function qcwpfb_is_condition_valid($reply_condition, $condition_value, $message, $message_tags=array(), $is_image=false){

	if($message!='' && !empty($reply_condition) && !empty($condition_value)){

		$is_valid = false;
		foreach($reply_condition as $key=>$val){
			// is equale to
			if($val==1){
				if( strtolower( $condition_value[$key] ) == strtolower( trim($message) )){
					$is_valid = true;
				}
			}
			//contains
			if($val==2){
				if (strpos( strtolower( $message ), strtolower( $condition_value[$key] )) !== false) {
					$is_valid = true;
				}
			}
			//match any
			if( $val == 3 ){
				$keywords = array_map( 'trim', explode( ',', strtolower( $condition_value[$key] ) ) );
				if(preg_match('"'. implode('|', $keywords) .'"', $message) === 1) {
					$is_valid = true;
				}
			}

			//match all
			if( $val == 4 ){
				$keywords = array_map( 'trim', explode( ',', strtolower( $condition_value[$key] ) ) );
				if( ! empty( $keywords ) ){
					$match_all = true;
					foreach( $keywords as $keyword ){
						if(preg_match( '('.$keyword.')', $message) !== 1) {
							$match_all = false;
						}
					}
					if( $match_all ) {
						$is_valid = true;
					}
				}
			}

			// if tagged people more then
			if ( $val == 5 ) {
				if( count( $message_tags ) >= (int)$condition_value[$key] ){
					$is_valid = true;
				}
			}

			// Is image
			if ( $val == 6 ) {
				if( $is_image ){
					$is_valid = true;
				}
			}
		}
		return $is_valid;
	}else{
		return false;
	}
}