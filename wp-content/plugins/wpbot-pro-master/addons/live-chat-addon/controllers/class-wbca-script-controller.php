<?php

class wbca_Script_Controller{

    public function enque_scripts(){
        add_action('wp_enqueue_scripts', array($this, 'include_scripts_styles'));
		add_action('wp_head', array($this, 'include_custom_styles'));
		add_action('admin_head', array($this, 'include_admin_custom_styles'));
        add_action('admin_enqueue_scripts', array($this, 'include_admin_scripts_styles'));
    }

    /*
     * Include AJAX plugin specific scripts and pass the neccessary data.
     *
     * @param  -
     * @return -
     */

    public function include_scripts_styles(){
        global $post;
		
		$data = get_option('wbca_options');
    	$chatRate = (isset($data['wbca_chat_refresh_rate'])?$data['wbca_chat_refresh_rate']:'6000');
		$full_height = (isset($data['wbca_mobile_full_height'])?$data['wbca_mobile_full_height']:'');
		$chat_style = !empty($data['wbca_chat_bytton_style'])?$data['wbca_chat_bytton_style']:'style_1';
		if ( !class_exists('qcld_wb_Chatbot') && !class_exists('QCLD_Woo_Chatbot') && (qclivechat_is_kbxwpbot_active() != true)) {
			$bot_enable = false;
		}else{
			$bot_enable = true;
		}
		if($bot_enable == true){
			if(function_exists('qcld_get_lc_language')){
				$chat_type = !empty( qcld_get_lc_language( 'wbca_lg_chat_type' ) )? qcld_get_lc_language( 'wbca_lg_chat_type' ): 'Type your question below and hit enter.';
				$welcome = !empty(qcld_get_lc_language( 'wbca_lg_chat_welcome' ))?qcld_get_lc_language( 'wbca_lg_chat_welcome' ):'You are now chatting with';
				$no_operator = !empty(qcld_get_lc_language( 'wbca_lg_please_wait' ))?qcld_get_lc_language( 'wbca_lg_please_wait' ):'Please wait. Someone will be with your shortly';
				$operator_gone_offline = !empty(qcld_get_lc_language( 'wbca_operator_gone_offline' ))?qcld_get_lc_language( 'wbca_operator_gone_offline' ):'Please wait. Someone will be with your shortly';
			}else{
				$chat_type = 'Type your question below and hit enter.';
				$welcome = 'You are now chatting with';
				$no_operator = 'Please wait. Someone will be with your shortly';
			}
		}
		
		if (get_option('wp_chatbot_show_pages') == 'off') {
			$wp_chatbot_select_pages = maybe_unserialize(get_option('wp_chatbot_show_pages_list'));
			foreach($wp_chatbot_select_pages AS $id){
				$int_id = intval($id);
				if( is_page($int_id)){
					wp_register_script('wbca_ajax', plugins_url('js/wbca-ajax.js', dirname(__FILE__)), array("jquery"), WBCA_VERSION);
					wp_enqueue_script('wbca_ajax');
				}
			}
			
		}
		if((get_option('wp_chatbot_show_pages') == 'on') || (get_option('wp_chatbot_show_pages') == false)){
			wp_register_script('wbca_ajax', plugins_url('js/wbca-ajax.js', dirname(__FILE__)), array("jquery"), WBCA_VERSION);
			wp_enqueue_script('wbca_ajax');
		}
       
		if($bot_enable == false){
			$chat_type = 'Type your question below and hit enter.';
			$welcome = 'You are now chatting with';
			$no_operator = 'Please wait. Someone will be with your shortly';
			wp_register_script('livechat_front', plugins_url('js/livechat_front.js', dirname(__FILE__)), array("jquery"), WBCA_VERSION);
        	wp_enqueue_script('livechat_front');
		}
        $nonce = wp_create_nonce("unique_key");

        $ajax = new wbca_AJAX();
        $ajax->initialize();
		$doc = new DOMDocument();
        $getAvater = str_replace('&','&amp;',get_avatar(get_current_user_id()));
		if(trim($getAvater)!=''){
			$doc = new DOMDocument();
			@$doc->loadHTML($getAvater);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)");
		}else{
			$src = esc_url( get_avatar_url( get_current_user_id() ) );
		}
		// $doc = new DOMDocument();
		// @$doc->loadHTML($getAvater);
		// $xpath = new DOMXPath($doc);
		// $src = $xpath->evaluate("string(//img/@src)");
		
		$mainClass = '';
		if(qclivechat_is_wpbot_active()){
			$mainClass = 'wpbot-saas-live-chat';
		}
		$mainClass = 'wpbot-saas-live-chat';
		if(qclivechat_is_kbxwpbot_active()){
			$mainClass = 'wpbot-saas-live-chat';
		}

		if(qclivechat_is_woowbot_active()){
			$mainClass = 'woo-saas-live-chat';
		}
		if($bot_enable == true){
			$config_array = array(
				'ajaxURL' => admin_url('admin-ajax.php'),
				'ajaxActions' => $ajax->ajax_actions,
				'ajaxNonce' => $nonce,
				'siteURL' => site_url(),
				'pluginsURL' => plugins_url(),
				'templateURL' => plugins_url('template/', dirname(__FILE__)),
				'chatRate' => $chatRate,
				'fullHeight' => $full_height,
				'chatStyle' => $chat_style,
				'chatType' => $chat_type,
				'welcome' => $welcome,
				'no_operator'=> $no_operator,
				'mainContainer'=> $mainClass,
				'wbcaUrl' => WBCA_URL,
			);
		}else{
			$config_array = array(
				'ajaxURL' => admin_url('admin-ajax.php'),
				'ajaxActions' => $ajax->ajax_actions,
				'ajaxNonce' => $nonce,
				'siteURL' => site_url(),
				'pluginsURL' => plugins_url(),
				'templateURL' => plugins_url('template/', dirname(__FILE__)),
				'chatRate' => $chatRate,
				'fullHeight' => $full_height,
				'chatStyle' => $chat_style,
				'chatType' => $chat_type,
				'welcome' => $welcome,
				'no_operator'=> $no_operator,
				'mainContainer'=> $mainClass,
				'wbcaUrl' => WBCA_URL,
			);
		}
        wp_localize_script('wbca_ajax', 'wbca_conf', $config_array);
		
        wp_register_style('user_styles', plugins_url('css/wbca-style.css', dirname(__FILE__)));
        wp_enqueue_style('user_styles');
		wp_register_style('client_common_styles', plugins_url('css/wbca-common.css', dirname(__FILE__)));
        wp_enqueue_style('client_common_styles');


    }

    public function colourchanger($hex, $percent) {
		// Work out if hash given
		$hash = '';
		if (stristr($hex,'#')) {
			$hex = str_replace('#','',$hex);
			$hash = '#';
		}
		/// HEX TO RGB
		$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
		for ($i=0; $i<3; $i++) {
			// See if brighter or darker
			if ($percent > 0) {
				// Lighter
				$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
			} else {
				// Darker
				$positivePercent = $percent - ($percent*2);
				$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
			}
			// In case rounding up causes us to go to 256
			if ($rgb[$i] > 255) {
				$rgb[$i] = 255;
			}
		}
		//// RBG to Hex
		$hex = '';
		for($i=0; $i < 3; $i++) {
			// Convert the decimal digit to hex
			$hexDigit = dechex($rgb[$i]);
			// Add a leading zero if necessary
			if(strlen($hexDigit) == 1) {
			$hexDigit = "0" . $hexDigit;
			}
			// Append to the hex string
			$hex .= $hexDigit;
		}
		return $hash.$hex;
	}
	//$colour = '#ae64fe';
	//$brightness = 0.5; // lighter
	//$brightness = 0.3; // more lighter
	//$brightness = 0.1; // close to white
	//$newColour = colourchanger($colour,$brightness);
	//$colour = '#ae64fe';
	//$brightness = -0.5; // 50% darker
	//$brightness = -0.3; // more darker
	//$brightness = -0.1; // more darker close to black
	//$newColour = colourchanger($colour,$brightness);
	public function hex2rgba($hex,$opc) {
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = 'rgba('.$r.','.$g.','.$b.','.$opc.')';
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
	}
	public function include_custom_styles(){
		
		$data = get_option('wbca_options');
		$ispPrimaryColor = !empty($data['wbca_title_bg_color']) && $data['wbca_title_bg_color'] != '#'?$data['wbca_title_bg_color']:'#1e88e5';
		$wbcaTitleBg = !empty($data['wbca_title_bg_color']) && $data['wbca_title_bg_color'] != '#'?'background-color:' .$data['wbca_title_bg_color'].';':'#1e88e5';
		$wbcaTitleBdr = 'border-bottom:1px solid '.$this->colourchanger($wbcaTitleBg, -0.6).';';
		$wbcaTitleColor = !empty($data['wbca_title_color']) && $data['wbca_title_color'] != '#'?'color:' .$data['wbca_title_color'].';':'';
		
		$wbcaBodyBgc = !empty($data['wbca_body_bg_color']) && $data['wbca_body_bg_color'] != '#'?'border:0;background-color:'.$data['wbca_body_bg_color'].';':'';		
		
		$wbcaBodyBgp = !empty($data['wbca_bg_pattern']) && $data['wbca_bg_pattern']!='none'? 'border:0;background: url('.WBCA_URL . 'images/bg/'.$data['wbca_bg_pattern'].'.png) repeat;':'';
		$wbcaBodyBgi = !empty($data['wbca_bg_image'])? 'border:0;background: url('.$data['wbca_bg_image']['src'].') no-repeat center center;':'';
		
		if($wbcaBodyBgi){
			$wbcaBodyBg = $wbcaBodyBgi;
		}else if($wbcaBodyBgp){
			$wbcaBodyBg = $wbcaBodyBgp; 
		}else{
			$wbcaBodyBg = $wbcaBodyBgc;
		}

		$wbcaStartChatBg = !empty($data['wbca_start_chat_bg_color']) && $data['wbca_start_chat_bg_color'] != '#'?'background-color:' .$data['wbca_start_chat_bg_color'].';':'';
		
		$wbca_placeholder_text = !empty($data['wbca_placeholder_text_color']) && $data['wbca_placeholder_text_color'] != '#'?'
		#wbcaChatWindow input::-webkit-input-placeholder, 
		.wbca-admin-wrap input::-webkit-input-placeholder,
		#wbcaChatWindow textarea::-webkit-input-placeholder, 
		.wbca-admin-wrap textarea::-webkit-input-placeholder {
		   color: '.$data['wbca_placeholder_text_color'].';
		}
		#wbcaChatWindow input:-moz-placeholder, 
		.wbca-admin-wrap input:-moz-placeholder,
		#wbcaChatWindow textarea:-moz-placeholder, 
		.wbca-admin-wrap textarea:-moz-placeholder{
		   color: '.$data['wbca_placeholder_text_color'].';  
		}
		#wbcaChatWindow input::-moz-placeholder, 
		.wbca-admin-wrap input::-moz-placeholder,
		#wbcaChatWindow textarea::-moz-placeholder, 
		.wbca-admin-wrap textarea::-moz-placeholder{
		   color: '.$data['wbca_placeholder_text_color'].';  
		}
		#wbcaChatWindow input:-ms-input-placeholder, 
		.wbca-admin-wrap input:-ms-input-placeholder,
		#wbcaChatWindow textarea:-ms-input-placeholder, 
		.wbca-admin-wrap textarea:-ms-input-placeholder{  
		   color: '.$data['wbca_placeholder_text_color'].';  
		}
		':'';
		$wbca_form_bdr = !empty($data['wbca_form_bdr_color']) && $data['wbca_form_bdr_color'] != '#'?'border-color:' .$data['wbca_form_bdr_color'].';':'';
		$wbca_form_bgt = (isset($data['enable_wbca_form_trans_bg'])?'background-color:transparent;':'');
		$wbca_form_bg = !empty($data['wbca_form_bg_color']) && $data['wbca_form_bg_color'] != '#'?'background-color:' .$data['wbca_form_bg_color'].';':'';
		$wbca_trans_form_bg = '
		.wbcaBody button.button{'.$wbca_form_bdr.'}
		.wbcaBody input[type="text"], 
		.wbcaBody input[type="password"],
		.wbcaFooter textarea,
		.wbcaBody textarea,
		#wbca_add_search_form input[type="text"],
		#wbca_add_search_form textarea,
		#wbca_edit_form input[type="text"],
		#wbca_edit_form textarea {'
		   .$wbca_form_bdr.$wbca_form_bgt.$wbca_form_bg.
		'}';
		
		$wbcaStartChatBdr = !empty($data['wbca_start_chat_bdr_color']) && $data['wbca_start_chat_bdr_color'] != '#'?'border-color:' .$data['wbca_start_chat_bdr_color'].';':'';
		
		$wbcaChatBg = (isset($data['wbca_chat_bg_color']) && !empty($data['wbca_chat_bg_color']) && $data['wbca_chat_bg_color'] != '#'?$data['wbca_chat_bg_color']:'#f1f1f1');
		$wbcaChatBdrBottom = $wbcaChatBg != ''?'border-bottom-color:' .$this->colourchanger($wbcaChatBg, -.6).';':'';
		$wbcaChatBdr = !empty($data['wbca_chat_border_color']) && $data['wbca_chat_border_color'] != '#'?'border: 1px solid ' .$data['wbca_chat_border_color'].';':'';
		$wbcaChatText = !empty($data['wbca_chat_text_color']) && $data['wbca_chat_text_color'] != '#'?'color:' .$data['wbca_chat_text_color'].';':'';
		
		if(isset($data['enable_wbca_chat_bg_opacity'])){
			
			$wbcaChatBgc = 'background-color:' .$this->hex2rgba($wbcaChatBg, $data['wbca_chat_bg_opacity']).';';
			
			$wbcaChatTip ='
			.leftMessage:after{border-color:rgba(255, 255, 255,0);border-right-color:'.$this->hex2rgba($wbcaChatBg,$data['wbca_chat_bg_opacity']-.2).';}
			.leftMessage:before{border-color:rgba(218, 222, 225,0);border-right-color:'.$this->hex2rgba($wbcaChatBg,$data['wbca_chat_bg_opacity']-.2).';}
			.rightMessage:after{border-color:rgba(255, 255, 255,0);border-left-color:'.$this->hex2rgba($wbcaChatBg,$data['wbca_chat_bg_opacity']-.2).';}
			.rightMessage:before{border-color:rgba(218, 222, 225,0);border-left-color:'.$this->hex2rgba($wbcaChatBg,$data['wbca_chat_bg_opacity']-.2).';}
			';
		}else{
			$wbcaChatBgc = 'background-color:' .$wbcaChatBg.';';
			
			$wbcaChatTip = '
			.leftMessage:after{border-color: rgba(255, 255, 255, 0);border-right-color: '.$wbcaChatBg.';}
			.leftMessage:before{border-color: rgba(218, 222, 225, 0);border-right-color: '.$wbcaChatBg.';}
			.rightMessage:after{border-color: rgba(255, 255, 255, 0);border-left-color: '.$wbcaChatBg.';}
			.rightMessage:before{border-color: rgba(218, 222, 225, 0);border-left-color: '.$wbcaChatBg.';}
			';
		}
		$wbca_button = !empty($data['wbca_button']) && $data['wbca_button'] != '#'?"
		.wbca_button {
			-moz-box-shadow:inset 0px 1px 0px 0px " .$this->colourchanger($data['wbca_button'], .4).";
			-webkit-box-shadow:inset 0px 1px 0px 0px " .$this->colourchanger($data['wbca_button'], .4).";
			box-shadow:inset 0px 1px 0px 0px " .$this->colourchanger($data['wbca_button'], .4).";
			background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, " .$data['wbca_button']."), color-stop(1, " .$this->colourchanger($data['wbca_button'], -.7)."));
			background:-moz-linear-gradient(top, " .$data['wbca_button']." 5%, " .$this->colourchanger($data['wbca_button'], -.7)." 100%);
			background:-webkit-linear-gradient(top, " .$data['wbca_button']." 5%, " .$this->colourchanger($data['wbca_button'], -.7)." 100%);
			background:-o-linear-gradient(top, " .$data['wbca_button']." 5%, " .$this->colourchanger($data['wbca_button'], -.7)." 100%);
			background:-ms-linear-gradient(top, " .$data['wbca_button']." 5%, " .$this->colourchanger($data['wbca_button'], -.7)." 100%);
			background:linear-gradient(to bottom, " .$data['wbca_button']." 5%, " .$this->colourchanger($data['wbca_button'], -.7)." 100%);
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='" .$data['wbca_button']."', endColorstr='" .$this->colourchanger($data['wbca_button'], -.7)."',GradientType=0);
			background-color:" .$data['wbca_button'].";
			text-shadow: 0px 1px 0px " .$this->colourchanger($data['wbca_button'], -.3).";
		}
		.wbca_button:hover{
			background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, " .$this->colourchanger($data['wbca_button'], -.7)."), color-stop(1, " .$data['wbca_button']."));
			background:-moz-linear-gradient(top, " .$this->colourchanger($data['wbca_button'], -.7)." 5%, " .$data['wbca_button']." 100%);
			background:-webkit-linear-gradient(top, " .$this->colourchanger($data['wbca_button'], -.7)." 5%, " .$data['wbca_button']." 100%);
			background:-o-linear-gradient(top, " .$this->colourchanger($data['wbca_button'], -.7)." 5%, " .$data['wbca_button']." 100%);
			background:-ms-linear-gradient(top, " .$this->colourchanger($data['wbca_button'], -.7)." 5%, " .$data['wbca_button']." 100%);
			background:linear-gradient(to bottom, " .$this->colourchanger($data['wbca_button'], -.7)." 5%, " .$data['wbca_button']." 100%);
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='" .$this->colourchanger($data['wbca_button'], -.7)."', endColorstr='" .$data['wbca_button']."',GradientType=0);
			background-color:" .$this->colourchanger($data['wbca_button'], -.7).";
		}
		":"";
		$wbca_button_text = !empty($data['wbca_button_text']) && $data['wbca_button_text'] != '#'?"
		button.wbca_button {
			color:" .$data['wbca_button_text'].";
		}
		":"";
		$wbca_mobile_button = !empty($data['wbca_mobile_chat_bg_color']) && $data['wbca_mobile_chat_bg_color'] != '#'?"
		span.wbca_mobile_ChatIcon.wbca_chat {
			background: " .$this->hex2rgba($data['wbca_mobile_chat_bg_color'], $data['wbca_mobile_chat_bg_opacity'])." url(".WBCA_URL . "images/wbca_chat.png) no-repeat 9px center;
		}
		span.wbca_mobile_ChatIcon.wbca_email{
			background: " .$this->hex2rgba($data['wbca_mobile_chat_bg_color'], $data['wbca_mobile_chat_bg_opacity'])." url(".WBCA_URL . "images/wbca_email.png) no-repeat 9px center;
		}
		":"";
		//$wbcaBodybgi = $data['wbca_chat_bg_pattern']!='none'? ' url('.WBCA_URL . 'images/bg/'.$data['wbca_chat_bg_pattern'].'.png) repeat':'';
		$position = (isset($data['wbca_chat_bytton_position']) && $data['wbca_chat_bytton_position'] == 'Left')?'
		@media (min-width: 768px){
			body #wbcaChatWindow,
			body span.wbca_mobile_ChatIcon.wbca_chat{
				left:0;
				right:auto;
			}
		}':'';
		
		$fullwidth = '
		@media only screen 
		  and (min-device-width: 320px) 
		  and (max-device-width: 480px)
		  and (-webkit-min-device-pixel-ratio: 2),
		  only screen 
		  and (min-device-width: 320px) 
		  and (max-device-width: 568px)
		  and (-webkit-min-device-pixel-ratio: 2),
		  only screen 
		  and (min-device-width: 375px) 
		  and (max-device-width: 667px) 
		  and (-webkit-min-device-pixel-ratio: 2),
		  only screen 
		  and (min-device-width: 414px) 
		  and (max-device-width: 736px) 
		  and (-webkit-min-device-pixel-ratio: 3),
		  only screen
		  and (max-width: 767px){';
			 if(isset($data['wbca_mobile_full_width'])){
				$fullwidth .= '#wbcaChatWindow {width: 100%;}';
			 }
			 if(isset($data['wbca_remove_chat_text'])){
				$fullwidth .= 'span.wbca_mobile_ChatIcon.wbca_chat {background-position: center center;} .wbca_mobile_Chat{display:none;}';
			 }
			$fullwidth .= '.wbcaBodyHolder, body span.wbca_mobile_ChatIcon.wbca_chat{display:block;}';
			
		$fullwidth .= '}';
		
		if(isset($data['wbca_chat_bytton_style']) && $data['wbca_chat_bytton_style'] == 'style_2'){
			$wbca_chat = '
				.wbcaBodyHolder,
				span.wbca_mobile_ChatIcon.wbca_chat{
					display:none;
				}
			';
		}else{
			$wbca_chat = '
				#wbcaChatWindow{
					
				}
			';
		}
		
		echo "<style type=\"text/css\">
			
			.wbcaTitle { ".$wbcaTitleBg.$wbcaTitleColor.$wbcaTitleBdr." } 
			.wbcaBody .button--ujarak::before{background:".$ispPrimaryColor.";}
			.wbcaBody .button--ujarak:hover{border-color:".$ispPrimaryColor.";}
			.wbcaBodyHolder{".$wbcaBodyBg."} 
			.wbcaBody #wbca_chat_footer input[type=\"text\"]{".$wbcaStartChatBg.$wbcaStartChatBdr."} 
			.wbcaMessage{".$wbcaChatBgc.$wbcaChatBdrBottom.$wbcaChatText.$wbcaChatBdr.";} 
			".$wbca_chat.$wbcaChatTip.$fullwidth.$wbca_placeholder_text.$wbca_button.$wbca_trans_form_bg.$wbca_button_text.$wbca_mobile_button.$position."</style>"; 
    }
	
	public function include_admin_custom_styles(){
		
		$data = get_option('wbca_options');
		$adminTitleBg = !empty($data['wbca_adm_title_bg_color']) && $data['wbca_adm_title_bg_color'] != '#'?'background-color:' .$data['wbca_adm_title_bg_color'].';':'';
		$adminTitleBdr = $adminTitleBg != ''?'border-bottom:1px solid '.$this->colourchanger($data['wbca_adm_title_bg_color'], -0.6).';':'';
		$adminTitleText = !empty($data['wbca_adm_title_color']) && $data['wbca_adm_title_color'] != '#'?'color:' .$data['wbca_adm_title_color'].';':'';
		
		$adminTabBg = !empty($data['wbca_adm_tab_bg_color']) && $data['wbca_adm_tab_bg_color'] != '#'?'background-color:' .$data['wbca_adm_tab_bg_color'].';':'';
		$adminTabRowBg = !empty($data['wbca_adm_tab_row_color']) && $data['wbca_adm_tab_row_color'] != '#'?'background-color:' .$data['wbca_adm_tab_row_color'].';':'';
		$adminTabRowActive = !empty($data['wbca_adm_tab_row_color_active']) && $data['wbca_adm_tab_row_color_active'] != '#'?'background-color:' .$data['wbca_adm_tab_row_color_active'].';':'';
		
		$adminTabBdr = !empty($data['wbca_adm_tab_bdr_color']) && $data['wbca_adm_tab_bdr_color'] != '#'?'border-bottom:1px solid '.$data['wbca_adm_tab_bdr_color'].';':'';
		
		$adminTabColor = !empty($data['wbca_adm_tab_text_color']) && $data['wbca_adm_tab_text_color'] != '#'?'color:' .$data['wbca_adm_tab_text_color'].';':'';
		$adminTabColorActive = !empty($data['wbca_adm_tab_text_color_active']) && $data['wbca_adm_tab_text_color_active'] != '#'?'color:' .$data['wbca_adm_tab_text_color_active'].';':'';
		
		$adminBodyBgc = !empty($data['wbca_adm_body_bg_color']) && $data['wbca_adm_body_bg_color'] != '#'?'background-color:'.$data['wbca_adm_body_bg_color'].';':'';		
						
		$adminBodyBgp = !empty($data['wbca_adm_bg_pattern']) && $data['wbca_adm_bg_pattern']!='none'? 'background: url('.WBCA_URL . 'images/bg/'.$data['wbca_adm_bg_pattern'].'.png) repeat;':'';
		$adminBodyBgi = !empty($data['wbca_adm_bg_image']['src'])? 'background: url('.$data['wbca_adm_bg_image']['src'].') no-repeat center center;':'';
		
		if($adminBodyBgi){
			$adminBodyBg = $adminBodyBgi;
		}else if($adminBodyBgp){
			$adminBodyBg = $adminBodyBgp; 
		}else{
			$adminBodyBg = $adminBodyBgc;
		}
		
		$adminStartChatBg = !empty($data['wbca_adm_start_chat_bg_color']) && $data['wbca_adm_start_chat_bg_color'] != '#'?'background-color:' .$data['wbca_adm_start_chat_bg_color'].';':'';
		
		$wbca_placeholder_text = !empty($data['wbca_placeholder_text_color']) && $data['wbca_placeholder_text_color'] != '#'?'
		#wbcaChatWindow input::-webkit-input-placeholder, 
		.wbca-admin-wrap input::-webkit-input-placeholder,
		#wbcaChatWindow textarea::-webkit-input-placeholder, 
		.wbca-admin-wrap textarea::-webkit-input-placeholder {
		   color: '.$data['wbca_placeholder_text_color'].';
		}
		#wbcaChatWindow input:-moz-placeholder, 
		.wbca-admin-wrap input:-moz-placeholder,
		#wbcaChatWindow textarea:-moz-placeholder, 
		.wbca-admin-wrap textarea:-moz-placeholder{
		   color: '.$data['wbca_placeholder_text_color'].';  
		}
		#wbcaChatWindow input::-moz-placeholder, 
		.wbca-admin-wrap input::-moz-placeholder,
		#wbcaChatWindow textarea::-moz-placeholder, 
		.wbca-admin-wrap textarea::-moz-placeholder{
		   color: '.$data['wbca_placeholder_text_color'].';  
		}
		#wbcaChatWindow input:-ms-input-placeholder, 
		.wbca-admin-wrap input:-ms-input-placeholder,
		#wbcaChatWindow textarea:-ms-input-placeholder, 
		.wbca-admin-wrap textarea:-ms-input-placeholder{  
		   color: '.$data['wbca_placeholder_text_color'].';  
		}
		':'';
		
		$wbca_trans_form_bg = isset($data['enable_wbca_form_trans_bg'])?'
		.wbcaBody input[type="text"], 
		.wbcaBody input[type="password"],
		.wbcaFooter textarea,
		.wbcaBody textarea,
		#wbca_add_search_form input[type="text"],
		#wbca_add_search_form textarea,
		#wbca_edit_form input[type="text"],
		#wbca_edit_form textarea {
		   background-color:transparent;
		}
		':'';
		
		$wbca_button = !empty($data['wbca_button']) && $data['wbca_button'] != '#'?"
		.wbca_button {
			-moz-box-shadow:inset 0px 1px 0px 0px " .$this->colourchanger($data['wbca_button'], .4).";
			-webkit-box-shadow:inset 0px 1px 0px 0px " .$this->colourchanger($data['wbca_button'], .4).";
			box-shadow:inset 0px 1px 0px 0px " .$this->colourchanger($data['wbca_button'], .4).";
			background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, " .$data['wbca_button']."), color-stop(1, " .$this->colourchanger($data['wbca_button'], -.7)."));
			background:-moz-linear-gradient(top, " .$data['wbca_button']." 5%, " .$this->colourchanger($data['wbca_button'], -.7)." 100%);
			background:-webkit-linear-gradient(top, " .$data['wbca_button']." 5%, " .$this->colourchanger($data['wbca_button'], -.7)." 100%);
			background:-o-linear-gradient(top, " .$data['wbca_button']." 5%, " .$this->colourchanger($data['wbca_button'], -.7)." 100%);
			background:-ms-linear-gradient(top, " .$data['wbca_button']." 5%, " .$this->colourchanger($data['wbca_button'], -.7)." 100%);
			background:linear-gradient(to bottom, " .$data['wbca_button']." 5%, " .$this->colourchanger($data['wbca_button'], -.7)." 100%);
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='" .$data['wbca_button']."', endColorstr='" .$this->colourchanger($data['wbca_button'], -.7)."',GradientType=0);
			background-color:" .$data['wbca_button'].";
			text-shadow: 0px 1px 0px " .$this->colourchanger($data['wbca_button'], -.3).";
		}
		.wbca_button:hover{
			background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, " .$this->colourchanger($data['wbca_button'], -.7)."), color-stop(1, " .$data['wbca_button']."));
			background:-moz-linear-gradient(top, " .$this->colourchanger($data['wbca_button'], -.7)." 5%, " .$data['wbca_button']." 100%);
			background:-webkit-linear-gradient(top, " .$this->colourchanger($data['wbca_button'], -.7)." 5%, " .$data['wbca_button']." 100%);
			background:-o-linear-gradient(top, " .$this->colourchanger($data['wbca_button'], -.7)." 5%, " .$data['wbca_button']." 100%);
			background:-ms-linear-gradient(top, " .$this->colourchanger($data['wbca_button'], -.7)." 5%, " .$data['wbca_button']." 100%);
			background:linear-gradient(to bottom, " .$this->colourchanger($data['wbca_button'], -.7)." 5%, " .$data['wbca_button']." 100%);
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='" .$this->colourchanger($data['wbca_button'], -.7)."', endColorstr='" .$data['wbca_button']."',GradientType=0);
			background-color:" .$this->colourchanger($data['wbca_button'], -.7).";
		}
		":"";
		$wbca_button_text = !empty($data['wbca_button_text']) && $data['wbca_button_text'] != '#'?"
		button.wbca_button {
			color:" .$data['wbca_button_text'].";
		}
		":"";
		$adminStartChatBdr = !empty($data['wbca_adm_start_chat_bdr_color']) && $data['wbca_adm_start_chat_bdr_color'] != '#'?'border-color:' .$data['wbca_adm_start_chat_bdr_color'].';':'';
		
		$adminChatBg = !empty($data['wbca_adm_chat_bg_color']) && $data['wbca_adm_chat_bg_color'] != '#'?'background-color:' .$data['wbca_adm_chat_bg_color'].';':'';
		$adminChatBdrBottom = $adminChatBg != ''?'border-bottom-color:' .$this->colourchanger($data['wbca_adm_chat_bg_color'], -.6).';':'';
		$adminChatBdr = !empty($data['wbca_adm_chat_border_color']) && $data['wbca_adm_chat_border_color'] != '#'?'border: 1px solid ' .$data['wbca_adm_chat_border_color'].';':'';
		$adminChatText = !empty($data['wbca_adm_chat_text_color']) && $data['wbca_adm_chat_text_color'] != '#'?'color:' .$data['wbca_adm_chat_text_color'].';':'';
		$adminChatBgc = '';
		$adminChatTip = '';
		if(isset($data['enable_wbca_adm_chat_bg_opacity']) && !empty($data['wbca_adm_chat_bg_color']) && $data['wbca_adm_chat_bg_color'] != '#'){
			
			$adminChatBgc = 'background-color:' .$this->hex2rgba($data['wbca_adm_chat_bg_color'], $data['wbca_adm_chat_bg_opacity']).';';
			
			$adminChatTip ='
			.leftMessage:after{border-color:rgba(255, 255, 255,0);border-right-color:'.$this->hex2rgba($data['wbca_adm_chat_bg_color'],$data['wbca_adm_chat_bg_opacity']-.2).';}
			.leftMessage:before{border-color:rgba(218, 222, 225,0);border-right-color:'.$this->hex2rgba($data['wbca_adm_chat_bg_color'],$data['wbca_adm_chat_bg_opacity']-.2).';}
			.rightMessage:after{border-color:rgba(255, 255, 255,0);border-left-color:'.$this->hex2rgba($data['wbca_adm_chat_bg_color'],$data['wbca_adm_chat_bg_opacity']-.2).';}
			.rightMessage:before{border-color:rgba(218, 222, 225,0);border-left-color:'.$this->hex2rgba($data['wbca_adm_chat_bg_color'],$data['wbca_adm_chat_bg_opacity']-.2).';}
			';
		}else if(!empty($data['wbca_adm_chat_bg_color']) && $data['wbca_adm_chat_bg_color'] != '#'){
			$adminChatBgc = 'background-color:' .$data['wbca_adm_chat_bg_color'].';';
			
			$adminChatTip = '
			.leftMessage:after{border-color: rgba(255, 255, 255, 0);border-right-color: '.$data['wbca_adm_chat_bg_color'].';}
			.leftMessage:before{border-color: rgba(218, 222, 225, 0);border-right-color: '.$data['wbca_adm_chat_bg_color'].';}
			.rightMessage:after{border-color: rgba(255, 255, 255, 0);border-left-color: '.$data['wbca_adm_chat_bg_color'].';}
			.rightMessage:before{border-color: rgba(218, 222, 225, 0);border-left-color: '.$data['wbca_adm_chat_bg_color'].';}
			';
		}		
		$adminTabBdrFirst = !empty($data['wbca_adm_tab_bdr_color']) && $data['wbca_adm_tab_bdr_color'] != '#'?'border-top:1px solid '.$data['wbca_adm_tab_bdr_color']:'';
		$adminBodyTextColor = !empty($data['wbca_adm_body_text_color']) && $data['wbca_adm_body_text_color'] != '#'?'color:'.$data['wbca_adm_body_text_color']:'';
		echo "<style type=\"text/css\">
			.wbca-admin-head { ".$adminTitleBg.$adminTitleText.$adminTitleBdr." } 
			#wbca-tabs-wrap{".$adminTabBg."} 
			#wbca-chat-tabs li{".$adminTabRowBg.$adminTabColor.$adminTabBdr."}
			#wbca-chat-tabs li:first-child{".$adminTabBdrFirst."}
			#wbca-chat-tabs li.wbca-current, #wbca-chat-tabs li:hover{".$adminTabRowActive.$adminTabColorActive."}
			#wbca-content-wrap{".$adminBodyTextColor."}
			.wbca-admin-body{".$adminBodyBg."} 
			.wbcaFooter textarea{".$adminStartChatBg.$adminStartChatBdr."} 
			.wbcaMessage{".$adminChatBgc.$adminChatBdrBottom.$adminChatText.$adminChatBdr.";} 
			".$adminChatTip.$wbca_placeholder_text.$wbca_button.$wbca_trans_form_bg.$wbca_button_text."</style>"; 
    }
	
    public function include_admin_scripts_styles($hook){
		global $pagenow, $typenow;
		$data = get_option('wbca_options');
		if($data['disable_sound_notification']){
			$wp_livechat_obj = 1;
		}else{
			$wp_livechat_obj = 0;
		}
		if ( 'toplevel_page_wbca-chat-page' == $hook || 'toplevel_page_wbca-add-qa-page' == $hook || 'bot-live-chat_page_wbca_livechat_department_section' == $hook || 'toplevel_page_wbca-edit-qa-page' == $hook || $hook =='bot-live-chat_page_qcld_operator_manage') {
			wp_register_script('wbca_alert', plugins_url('js/wbca_alert.js', dirname(__FILE__)), array("jquery"), WBCA_VERSION);
			wp_enqueue_script('wbca_alert');
			wp_register_script('wbca_common', plugins_url('js/wbca-common.js', dirname(__FILE__)), array("jquery"), WBCA_VERSION);
			wp_enqueue_script('wbca_common');
			wp_localize_script('wbca_common', 'wp_livechat_obj', $wp_livechat_obj);
			wp_register_script('wbca_admin', plugins_url('js/wbca-admin.js', dirname(__FILE__)), array("jquery"), WBCA_VERSION);
			wp_enqueue_script('wbca_admin');
			wp_register_script('qcld-wp-livechat-query',plugins_url('js/jquery.cookie.js', dirname(__FILE__)),array("jquery"), WBCA_VERSION);
			wp_enqueue_script('qcld-wp-livechat-query');
			wp_register_script( 'wbca_fonmentic', plugins_url('js/fomentic.js', dirname(__FILE__)));
			wp_enqueue_script( 'wbca_fonmentic' );
			$nonce = wp_create_nonce("unique_key");
	
			$admin = new wbca_Admin_AJAX();
			$admin->initialize();
			
			$data = get_option('wbca_options');
			$chatRate = !empty($data['wbca_chat_refresh_rate']) ? $data['wbca_chat_refresh_rate'] : 6000;
			$getAvater = get_avatar(get_current_user_id());
			
			if(trim($getAvater)!=''){
				$doc = new DOMDocument();
				@$doc->loadHTML($getAvater);
				$xpath = new DOMXPath($doc);
				$src = $xpath->evaluate("string(//img/@src)");
			}else{
				$src = esc_url( get_avatar_url( get_current_user_id() ) );
			}
			
			$config_array = array(
				'ajaxURL' => admin_url('admin-ajax.php'),
				'ajaxActions' => $admin->ajax_actions,
				'ajaxNonce' => $nonce,
				'siteURL' => site_url(),
				'pluginsURL' => plugins_url(),
				'templateURL' => plugins_url('template/', dirname(__FILE__)),
				'avatar' => $src,
				'chatRate' => $chatRate
			);
	
			wp_localize_script('wbca_admin', 'wbca_admin_conf', $config_array);
			wp_register_style( 'wbca_alert_css', plugins_url('css/wbca-alert.css', dirname(__FILE__)));
			wp_enqueue_style( 'wbca_alert_css' );
			wp_register_style( 'wbca_admin_css', plugins_url('css/wbca-admin.css', dirname(__FILE__)));
			wp_enqueue_style( 'wbca_admin_css' );
			wp_register_style( 'admin_common_styles', plugins_url('css/wbca-common.css', dirname(__FILE__)));
			wp_enqueue_style( 'admin_common_styles' );
			wp_register_style( 'wbca_fonmentic', plugins_url('admin/css/fomentic.css', dirname(__FILE__)));
			wp_enqueue_style( 'wbca_fonmentic' );

		}
		if( isset($_GET['page']) && ($_GET['page'] =='wbca_livechat_settings' ||  $_GET['page'] =='wbca_livechat_department_section' ||  $_GET['page'] =='qcld_operator_manage')){
			//wp_enqueue_script( 'jquery-ui-datepicker' );

			// You need styling for the datepicker. For simplicity I've linked to the jQuery UI CSS on a CDN.
			wp_enqueue_media();
			wp_register_style( 'qcld_livechat_fomentic',WBCA_URL. '/admin/css/fomentic.css' );
			wp_enqueue_style( 'qcld_livechat_fomentic' ); 
			wp_register_script( 'livechatsettings', WBCA_URL. 'admin/js/livechatsettings.js' );
			wp_enqueue_script( 'livechatsettings' );   
		}
		if( isset($_GET['page']) && $_GET['page'] =='wbca-chat-history' ){
			wp_enqueue_script( 'jquery-ui-datepicker' );

			// You need styling for the datepicker. For simplicity I've linked to the jQuery UI CSS on a CDN.
			wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' );
			wp_enqueue_style( 'jquery-ui' );  
		}

    }


}

?>