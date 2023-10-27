<?php 
defined('ABSPATH') or die("Cheating........Uh!!");
/**
 * Widget for Social Login
 */
class TheChampLoginWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct(){ 
		parent::__construct(
			'TheChampLogin', //unique id 
			__('Super Socializer - Login'), //title displayed at admin panel
			array( 
				'description' => __('Let your website users login/register via their favorite Social ID Provider, such as Facebook, Twitter, Google, Linkedin and many more', 'super-socializer')) 
			); 
	}
	
	/** This is rendered widget content */ 
	public function widget($args, $instance){
		// if social login is disabled, return
		if(!the_champ_social_login_enabled()){
			return;
		}
		extract($args); 
		if($instance['hide_for_logged_in']==1 && is_user_logged_in()) return;
		echo $before_widget;
		if(!empty($instance['before_widget_content'])){ 
			echo '<div>' . esc_html($instance['before_widget_content']) . '</div>';
		}
		if(!is_user_logged_in()){
			if(!empty($instance['title'])){ 
				$title = apply_filters('widget_title', $instance['title']); 
				echo $before_title . esc_html($title) . $after_title;
			}
			global $heateorSsAllowedTags;
			echo wp_kses(the_champ_login_button(true), $heateorSsAllowedTags);
		}else{
			if(!empty($instance['title_after'])){ 
				$title = apply_filters('widget_title', $instance['title_after']); 
				echo $before_title . esc_html($title) . $after_title;
			}
			global $theChampLoginOptions, $user_ID;
			$userInfo = get_userdata($user_ID);
			echo "<div style='height:80px;width:180px'><div style='width:63px;float:left;'>";
			echo @get_avatar($user_ID, 60, '', '');
			echo "</div><div style='float:left; margin-left:10px'>";
			echo esc_html(str_replace('-', ' ', $userInfo->user_login));
			do_action('the_champ_login_widget_hook', $userInfo->user_login);
			echo '<br/><a href="' . wp_logout_url(esc_url(home_url())) . '">' .__('Log Out', 'super-socializer') . '</a></div></div>';
		}
		echo '<div style="clear:both"></div>';
		if(!empty($instance['after_widget_content'])){ 
			echo '<div>' . esc_html($instance['after_widget_content']) . '</div>';
		}
		echo $after_widget; 
	}  

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update($new_instance, $old_instance){ 
		$instance = $old_instance; 
		$instance['title'] = strip_tags($new_instance['title']); 
		$instance['title_after'] = strip_tags($new_instance['title_after']); 
		$instance['before_widget_content'] = $new_instance['before_widget_content']; 
		$instance['after_widget_content'] = $new_instance['after_widget_content']; 
		$instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];  

		return $instance; 
	}  

	/** Widget options in admin panel */ 
	public function form($instance){ 
		/* Set up default widget settings. */ 
		$defaults = array('title' => __('Login with your Social Account', 'super-socializer'), 'title_after' => '', 'before_widget_content' => '', 'after_widget_content' => '');  

		foreach($instance as $key => $value){  
			if(is_string($value)){
				$instance[ $key ] = esc_attr($value);  
			}
		}

		$instance = wp_parse_args((array)$instance, $defaults ); 
		?> 
		<p> 
			<p><strong>Note:</strong> <?php _e('Make sure Social Login is enabled at "Super Socializer > Social Login" page.', 'super-socializer') ?></p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title (before login):', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('title_after')); ?>"><?php _e('Title (after login):', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('title_after')); ?>" name="<?php echo esc_attr($this->get_field_name('title_after')); ?>" type="text" value="<?php echo esc_attr($instance['title_after']); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('before_widget_content')); ?>"><?php _e('Before widget content:', 'super-socializer'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('before_widget_content')); ?>" name="<?php echo esc_attr($this->get_field_name('before_widget_content')); ?>" type="text" value="<?php echo esc_attr($instance['before_widget_content']); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('after_widget_content')); ?>"><?php _e('After widget content:', 'super-socializer'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('after_widget_content')); ?>" name="<?php echo esc_attr($this->get_field_name('after_widget_content')); ?>" type="text" value="<?php echo esc_attr($instance['after_widget_content']); ?>" /> 
			<br /><br />
			<label for="<?php echo esc_attr($this->get_field_id('hide_for_logged_in')); ?>"><?php _e('Hide for logged in users:', 'super-socializer'); ?></label> 
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('hide_for_logged_in')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_for_logged_in')); ?>" type="text" value="1" <?php if(isset($instance['hide_for_logged_in']) && $instance['hide_for_logged_in']==1) echo 'checked="checked"'; ?> /> 
		</p> 
<?php 
  } 
} 
add_action('widgets_init', function(){ return register_widget("TheChampLoginWidget" ); } ); 

/**
 * Widget for Social Sharing (Standard widget)
 */
class TheChampSharingWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct(){ 
		parent::__construct(
			'TheChampHorizontalSharing', //unique id 
			'Super Socializer - Sharing (Standard Widget)', //title displayed at admin panel 
			//Additional parameters 
			array(
				'description' => __('Standard sharing widget. Let your website users share content on popular Social networks like Facebook, Twitter, Tumblr, Whatsapp and many more', 'super-socializer')) 
			); 
	}  

	/** This is rendered widget content */ 
	public function widget($args, $instance){ 
		// return if sharing is disabled
		if(!the_champ_social_sharing_enabled() || !the_champ_horizontal_sharing_enabled()){
			return;
		}
		extract($args );
		if($instance['hide_for_logged_in']==1 && is_user_logged_in()) return;
		
		global $theChampSharingOptions, $post;
		if(NULL === $post){
			$postId = 0;
		}else{
			$postId = $post->ID;
		}
		$customUrl = apply_filters('heateor_ss_custom_share_url', '', $post);
		if($customUrl){
			$sharingUrl = $customUrl;
			$postId = 0;
		}elseif(isset($instance['target_url'])){
			if($instance['target_url'] == 'default'){
				$sharingUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
				if(is_home()){
					$sharingUrl = esc_url_raw(home_url());
					$postId = 0;
				}elseif(!is_singular()){
					$sharingUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
					$postId = 0;
				}elseif(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']){
					$sharingUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
				}elseif(get_permalink($post->ID)){
					$sharingUrl = get_permalink($post->ID);
				}
			}elseif($instance['target_url'] == 'homepage'){
				$sharingUrl = esc_url(home_url());
				$postId = 0;
			}elseif($instance['target_url'] == 'custom'){
				$sharingUrl = isset($instance['target_url_custom']) ? trim($instance['target_url_custom']) : get_permalink($post->ID);
				$postId = 0;
			}
		}else{
			$sharingUrl = get_permalink($post->ID);
		}
		$shareCountUrl = $sharingUrl;
		if(isset($instance['target_url']) && $instance['target_url'] == 'default' && is_singular()){
			$shareCountUrl = get_permalink($post->ID);
		}
		$customPostUrl = heateor_ss_apply_target_share_url_filter($sharingUrl, 'horizontal', !is_singular() ? true : false);

		if($customPostUrl != $sharingUrl){
			$sharingUrl = $customPostUrl;
			$shareCountUrl = $sharingUrl;
		}

		$shareCountTransientId = heateor_ss_get_share_count_transient_id($sharingUrl);
		$cachedShareCount = heateor_ss_get_cached_share_count($shareCountTransientId);

		global $heateorSsAllowedTags;
		echo wp_kses("<div class='the_champ_sharing_container the_champ_horizontal_sharing' " . (the_champ_is_amp_page() ? '' : 'data-super-socializer-href="' . (isset($shareCountUrl) && $shareCountUrl ? $shareCountUrl : $sharingUrl) . '"') . ($cachedShareCount === false || the_champ_is_amp_page() ? "" : "data-super-socializer-no-counts='1' ") .">", $heateorSsAllowedTags );
		
		echo $before_widget;
		
		if(!empty($instance['title'])){ 
			$title = apply_filters('widget_title', $instance['title']); 
			echo $before_title . esc_html($title) . $after_title;
		}

		if(!empty($instance['before_widget_content'])){ 
			echo '<div>' . esc_html($instance['before_widget_content']) . '</div>'; 
		}
		if(isset($theChampSharingOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
			$sharingUrl = wp_get_shortlink();
			// if bit.ly integration enabled, generate bit.ly short url
		}elseif(isset($theChampSharingOptions['bitly_enable']) && isset($theChampSharingOptions['bitly_access_token']) && $theChampSharingOptions['bitly_access_token'] != ''){
			$shortUrl = the_champ_generate_sharing_bitly_url($sharingUrl, $postId);
			if($shortUrl){
				$sharingUrl = $shortUrl;
			}
		}
		echo the_champ_prepare_sharing_html($sharingUrl, $shareCountUrl, 'horizontal', isset($instance['show_counts']), isset($instance['total_shares']), $shareCountTransientId, !is_singular() ? true : false);

		if(!empty($instance['after_widget_content'])){ 
			echo '<div>' . esc_html($instance['after_widget_content']) . '</div>'; 
		}
		
		echo '</div>';
		if((isset($instance['show_counts']) || isset($instance['total_shares'])) && $cachedShareCount == false){
			echo '<script>theChampLoadEvent(
		function(){
			// sharing counts
			theChampCallAjax(function(){
				theChampGetSharingCounts();
			});
		}
	);</script>';
		}
		echo $after_widget;
	}  

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update($new_instance, $old_instance){ 
		$instance = $old_instance; 
		$instance['title'] = strip_tags($new_instance['title']); 
		$instance['show_counts'] = $new_instance['show_counts'];
		$instance['total_shares'] = $new_instance['total_shares']; 
		$instance['target_url'] = $new_instance['target_url'];
		$instance['target_url_custom'] = $new_instance['target_url_custom'];  
		$instance['before_widget_content'] = $new_instance['before_widget_content']; 
		$instance['after_widget_content'] = $new_instance['after_widget_content']; 
		$instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];  

		return $instance; 
	}  

	/** Widget edit form at admin panel */ 
	public function form($instance){ 
		/* Set up default widget settings. */ 
		$defaults = array('title' => 'Share the joy', 'show_counts' => '', 'total_shares' => '', 'target_url' => 'default', 'target_url_custom' => '', 'before_widget_content' => '', 'after_widget_content' => '', 'hide_for_logged_in' => '');

		foreach($instance as $key => $value){  
			if(is_string($value)){
				$instance[ $key ] = esc_attr($value);  
			}
		}
		
		$instance = wp_parse_args((array)$instance, $defaults );
		?> 
		<script type="text/javascript">
			function theChampToggleHorSharingTargetUrl(val){
				if(val == 'custom'){
					jQuery('.theChampHorSharingTargetUrl').css('display', 'block');
				}else{
					jQuery('.theChampHorSharingTargetUrl').css('display', 'none');
				}
			}
		</script>
		<p> 
			<p><strong><?php _e('Note', 'super-socializer'); ?>:</strong><?php _e('Make sure "Standard Social Sharing" is enabled at "Super Socializer > Social Sharing" page.', 'super-socializer') ?></p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /> <br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('show_counts')); ?>"><?php _e('Show individual share counts:', 'super-socializer'); ?></label> 
			<input id="<?php echo esc_attr($this->get_field_id('show_counts')); ?>" name="<?php echo esc_attr($this->get_field_name('show_counts')); ?>" type="checkbox" value="1" <?php echo isset($instance['show_counts']) && $instance['show_counts'] == 1 ? 'checked' : ''; ?> /><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('total_shares')); ?>"><?php _e('Show total shares:', 'super-socializer'); ?></label> 
			<input id="<?php echo esc_attr($this->get_field_id('total_shares')); ?>" name="<?php echo esc_attr($this->get_field_name('total_shares')); ?>" type="checkbox" value="1" <?php echo isset($instance['total_shares']) && $instance['total_shares'] == 1 ? 'checked' : ''; ?> /><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('target_url')); ?>"><?php _e('Target Url:', 'super-socializer'); ?></label> 
			<select style="width: 95%" onchange="theChampToggleHorSharingTargetUrl(this.value)" class="widefat" id="<?php echo esc_attr($this->get_field_id('target_url')); ?>" name="<?php echo esc_attr($this->get_field_name('target_url')); ?>">
				<option value="">--<?php _e('Select', 'super-socializer') ?>--</option>
				<option value="default" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'default' ? 'selected' : '' ; ?>><?php _e('Url of the webpage where icons are located (default)', 'super-socializer') ?></option>
				<option value="homepage" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'homepage' ? 'selected' : '' ; ?>><?php _e('Url of the homepage of your website', 'super-socializer') ?></option>
				<option value="custom" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'custom' ? 'selected' : '' ; ?>><?php _e('Custom Url', 'super-socializer') ?></option>
			</select>
			<input placeholder="<?php _e('Custom URL', 'super-socializer') ?>" style="margin-top: 5px; <?php echo !isset($instance['target_url']) || $instance['target_url'] != 'custom' ? 'display: none' : '' ; ?>" class="widefat theChampHorSharingTargetUrl" id="<?php echo esc_attr($this->get_field_id('target_url_custom')); ?>" name="<?php echo esc_attr($this->get_field_name('target_url_custom')); ?>" type="text" value="<?php echo isset($instance['target_url_custom']) ? esc_attr($instance['target_url_custom']) : ''; ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('before_widget_content')); ?>"><?php _e('Before widget content:', 'super-socializer'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('before_widget_content')); ?>" name="<?php echo esc_attr($this->get_field_name('before_widget_content')); ?>" type="text" value="<?php echo esc_attr($instance['before_widget_content']); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('after_widget_content')); ?>"><?php _e('After widget content:', 'super-socializer'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('after_widget_content')); ?>" name="<?php echo esc_attr($this->get_field_name('after_widget_content')); ?>" type="text" value="<?php echo esc_attr($instance['after_widget_content']); ?>" /> 
			<br /><br /><label for="<?php echo esc_attr($this->get_field_id('hide_for_logged_in')); ?>"><?php _e('Hide for logged in users:', 'super-socializer'); ?></label> 
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('hide_for_logged_in')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_for_logged_in')); ?>" type="text" value="1" <?php if(isset($instance['hide_for_logged_in'])  && $instance['hide_for_logged_in']==1) echo 'checked="checked"'; ?> /> 
		</p> 
	<?php 
    } 
} 
add_action('widgets_init', function(){ return register_widget("TheChampSharingWidget" ); } );

/**
 * Widget for Social Sharing (Floating widget)
 */
class TheChampVerticalSharingWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct(){ 
		parent::__construct(
			'TheChampVerticalSharing', //unique id 
			'Super Socializer - Sharing (Floating Widget)', //title displayed at admin panel 
			//Additional parameters 
			array(
				'description' => __('Floating sharing widget. Let your website users share content on popular Social networks like Facebook, Twitter, Tumblr, Whatsapp and many more', 'super-socializer')) 
			); 
	}  

	/** This is rendered widget content */ 
	public function widget($args, $instance){ 
		// return if sharing is disabled
		if(!the_champ_social_sharing_enabled() || the_champ_is_amp_page() || !the_champ_vertical_sharing_enabled()){
			return;
		}
		extract($args );
		if($instance['hide_for_logged_in']==1 && is_user_logged_in()) return;
		
		global $theChampSharingOptions, $post;
		if(NULL === $post){
			$postId = 0;
		}else{
			$postId = $post->ID;
		}
		$customUrl = apply_filters('heateor_ss_custom_share_url', '', $post);
		if($customUrl){
			$sharingUrl = $customUrl;
			$postId = 0;
		}elseif(isset($instance['target_url'])){
			if($instance['target_url'] == 'default'){
				$sharingUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
				if(is_home()){
					$sharingUrl = esc_url(home_url());
					$postId = 0;
				}elseif(!is_singular()){
					$sharingUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
					$postId = 0;
				}elseif(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']){
					$sharingUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
				}elseif(get_permalink($post->ID)){
					$sharingUrl = get_permalink($post->ID);
				}
			}elseif($instance['target_url'] == 'homepage'){
				$sharingUrl = esc_url(home_url());
				$postId = 0;
			}elseif($instance['target_url'] == 'custom'){
				$sharingUrl = isset($instance['target_url_custom']) ? trim($instance['target_url_custom']) : get_permalink($post->ID);
				$postId = 0;
			}
		}else{
			$sharingUrl = get_permalink($post->ID);
		}

		$shareCountUrl = $sharingUrl;
		if(isset($instance['target_url']) && $instance['target_url'] == 'default' && is_singular()){
			$shareCountUrl = get_permalink($post->ID);
		}
		$customPostUrl = heateor_ss_apply_target_share_url_filter($sharingUrl, 'vertical', false);
		if($customPostUrl != $sharingUrl){
			$sharingUrl = $customPostUrl;
			$shareCountUrl = $sharingUrl;
		}

		$ssOffset = 0;
		if(isset($instance['alignment']) && isset($instance[$instance['alignment'] . '_offset'])){
			$ssOffset = $instance[$instance['alignment'] . '_offset'];
		}

		$shareCountTransientId = heateor_ss_get_share_count_transient_id($sharingUrl);
		$cachedShareCount = heateor_ss_get_cached_share_count($shareCountTransientId);

		global $heateorSsAllowedTags;
		echo wp_kses("<div class='the_champ_sharing_container the_champ_vertical_sharing" . (isset($theChampSharingOptions['hide_mobile_sharing']) ? ' the_champ_hide_sharing' : '') . (isset($theChampSharingOptions['bottom_mobile_sharing']) ? ' the_champ_bottom_sharing' : '') . "' " . (the_champ_is_amp_page() ? "" : "data-heateor-ss-offset='". $ssOffset ."' " ) . "style='width:" . ((isset($theChampSharingOptions['vertical_sharing_size']) ? $theChampSharingOptions['vertical_sharing_size'] : 35) + 4) . "px;".(isset($instance['alignment']) && $instance['alignment'] != '' && isset($instance[$instance['alignment'].'_offset']) ? $instance['alignment'].': '. ($instance[$instance['alignment'].'_offset'] == '' ? 0 : $instance[$instance['alignment'].'_offset']) . 'px;' : '') . (isset($instance['top_offset']) ? 'top: '. ($instance['top_offset'] == '' ? 0 : $instance['top_offset']) . 'px;' : '') . (isset($instance['vertical_bg']) && $instance['vertical_bg'] != '' ? 'background-color: '.$instance['vertical_bg'] . ';' : '-webkit-box-shadow:none;box-shadow:none;') . "' " . (the_champ_is_amp_page() ? '' : 'data-super-socializer-href="' . (isset($shareCountUrl) && $shareCountUrl ? $shareCountUrl : $sharingUrl) . '"') . ($cachedShareCount === false || the_champ_is_amp_page() ? "" : "data-super-socializer-no-counts='1' ") .">", $heateorSsAllowedTags);
		
		if(isset($theChampSharingOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
			$sharingUrl = wp_get_shortlink();
			// if bit.ly integration enabled, generate bit.ly short url
		}elseif(isset($theChampSharingOptions['bitly_enable']) && isset($theChampSharingOptions['bitly_access_token']) && $theChampSharingOptions['bitly_access_token'] != ''){
			$shortUrl = the_champ_generate_sharing_bitly_url($sharingUrl, $postId);
			if($shortUrl){
				$sharingUrl = $shortUrl;
			}
		}
		//echo $before_widget;
		echo the_champ_prepare_sharing_html($sharingUrl, $shareCountUrl, 'vertical', isset($instance['show_counts']), isset($instance['total_shares']), $shareCountTransientId);
		echo '</div>';
		if((isset($instance['show_counts']) || isset($instance['total_shares'])) && $cachedShareCount == false){
			echo '<script>theChampLoadEvent(
		function(){
			// sharing counts
			theChampCallAjax(function(){
				theChampGetSharingCounts();
			});
		}
	);</script>';
		}
		//echo $after_widget;
	}  

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update($new_instance, $old_instance){ 
		$instance = $old_instance; 
		$instance['target_url'] = $new_instance['target_url'];
		$instance['show_counts'] = $new_instance['show_counts']; 
		$instance['total_shares'] = $new_instance['total_shares']; 
		$instance['target_url_custom'] = $new_instance['target_url_custom'];
		$instance['alignment'] = $new_instance['alignment'];
		$instance['left_offset'] = $new_instance['left_offset'];
		$instance['right_offset'] = $new_instance['right_offset'];
		$instance['top_offset'] = $new_instance['top_offset'];
		$instance['vertical_bg'] = $new_instance['vertical_bg'];
		$instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];  

		return $instance; 
	}  

	/** Widget edit form at admin panel */ 
	public function form($instance){ 
		/* Set up default widget settings. */ 
		$defaults = array('alignment' => 'left', 'show_counts' => '', 'total_shares' => '', 'left_offset' => '40', 'right_offset' => '0', 'target_url' => 'default', 'target_url_custom' => '', 'top_offset' => '100', 'vertical_bg' => '', 'hide_for_logged_in' => '');

		foreach($instance as $key => $value){  
			if(is_string($value)){
				$instance[ $key ] = esc_attr($value);  
			}
		}
		
		$instance = wp_parse_args((array)$instance, $defaults ); 
		?> 
		<p> 
			<script>
			function theChampToggleSharingOffset(alignment){
				if(alignment == 'left'){
					jQuery('.theChampSharingLeftOffset').css('display', 'block');
					jQuery('.theChampSharingRightOffset').css('display', 'none');
				}else{
					jQuery('.theChampSharingLeftOffset').css('display', 'none');
					jQuery('.theChampSharingRightOffset').css('display', 'block');
				}
			}
			function theChampToggleVerticalSharingTargetUrl(val){
				if(val == 'custom'){
					jQuery('.theChampVerticalSharingTargetUrl').css('display', 'block');
				}else{
					jQuery('.theChampVerticalSharingTargetUrl').css('display', 'none');
				}
			}
			</script>
			<p><strong>Note:</strong> <?php _e('Make sure "Floating Social Sharing" is enabled at "Super Socializer > Social Sharing" page.', 'super-socializer') ?></p>
			<label for="<?php echo esc_attr($this->get_field_id('show_counts')); ?>"><?php _e('Show individual share counts:', 'super-socializer'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('show_counts')); ?>" name="<?php echo esc_attr($this->get_field_name('show_counts')); ?>" type="checkbox" value="1" <?php echo isset($instance['show_counts']) && $instance['show_counts'] == 1 ? 'checked' : ''; ?> /><br/><br/> 
			<label for="<?php echo esc_attr($this->get_field_id('total_shares')); ?>"><?php _e('Show total shares:', 'super-socializer'); ?></label> 
			<input id="<?php echo esc_attr($this->get_field_id('total_shares')); ?>" name="<?php echo esc_attr($this->get_field_name('total_shares')); ?>" type="checkbox" value="1" <?php echo isset($instance['total_shares']) && $instance['total_shares'] == 1 ? 'checked' : ''; ?> /><br/> <br/>
			<label for="<?php echo esc_attr($this->get_field_id('target_url')); ?>"><?php _e('Target Url:', 'super-socializer'); ?></label> 
			<select style="width: 95%" onchange="theChampToggleVerticalSharingTargetUrl(this.value)" class="widefat" id="<?php echo esc_attr($this->get_field_id('target_url')); ?>" name="<?php echo esc_attr($this->get_field_name('target_url')); ?>">
				<option value="">--<?php _e('Select', 'super-socializer') ?>--</option>
				<option value="default" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'default' ? 'selected' : '' ; ?>><?php _e('Url of the webpage where icons are located (default)', 'super-socializer') ?></option>
				<option value="homepage" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'homepage' ? 'selected' : '' ; ?>><?php _e('Url of the homepage of your website', 'super-socializer ') ?></option>
				<option value="custom" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'custom' ? 'selected' : '' ; ?>><?php _e('Custom Url', 'super-socializer') ?></option>
			</select>
			<input placeholder="<?php _e('Custom URL', 'super-socializer') ?>" style="width:95%; margin-top: 5px; <?php echo !isset($instance['target_url']) || $instance['target_url'] != 'custom' ? 'display: none' : '' ; ?>" class="widefat theChampVerticalSharingTargetUrl" id="<?php echo esc_attr($this->get_field_id('target_url_custom')); ?>" name="<?php echo esc_attr($this->get_field_name('target_url_custom')); ?>" type="text" value="<?php echo isset($instance['target_url_custom']) ? esc_attr($instance['target_url_custom']) : ''; ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('alignment')); ?>"><?php _e('Alignment', 'super-socializer'); ?></label> 
			<select onchange="theChampToggleSharingOffset(this.value)" style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('alignment')); ?>" name="<?php echo esc_attr($this->get_field_name('alignment')); ?>">
				<option value="left" <?php echo $instance['alignment'] == 'left' ? 'selected' : ''; ?>><?php _e('Left', 'super-socializer') ?></option>
				<option value="right" <?php echo $instance['alignment'] == 'right' ? 'selected' : ''; ?>><?php _e('Right', 'super-socializer') ?></option>
			</select>
			<div class="theChampSharingLeftOffset" <?php echo $instance['alignment'] == 'right' ? 'style="display: none"' : ''; ?>>
				<label for="<?php echo esc_attr($this->get_field_id('left_offset')); ?>"><?php _e('Left Offset', 'super-socializer'); ?></label> 
				<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('left_offset')); ?>" name="<?php echo esc_attr($this->get_field_name('left_offset')); ?>" type="text" value="<?php echo esc_attr($instance['left_offset']); ?>" />px<br/>
			</div>
			<div class="theChampSharingRightOffset" <?php echo $instance['alignment'] == 'left' ? 'style="display: none"' : ''; ?>>
				<label for="<?php echo esc_attr($this->get_field_id('right_offset')); ?>"><?php _e('Right Offset', 'super-socializer'); ?></label> 
				<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('right_offset')); ?>" name="<?php echo esc_attr($this->get_field_name('right_offset')); ?>" type="text" value="<?php echo esc_attr($instance['right_offset']); ?>" />px<br/>
			</div>
			<label for="<?php echo esc_attr($this->get_field_id('top_offset')); ?>"><?php _e('Top Offset', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('top_offset')); ?>" name="<?php echo esc_attr($this->get_field_name('top_offset')); ?>" type="text" value="<?php echo esc_attr($instance['top_offset']); ?>" />px<br/>
			
			<label for="<?php echo esc_attr($this->get_field_id('vertical_bg')); ?>"><?php _e('Background Color', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('vertical_bg')); ?>" name="<?php echo esc_attr($this->get_field_name('vertical_bg')); ?>" type="text" value="<?php echo esc_attr($instance['vertical_bg']); ?>" />
			
			<br /><br /><label for="<?php echo esc_attr($this->get_field_id('hide_for_logged_in')); ?>"><?php _e('Hide for logged in users:', 'super-socializer'); ?></label> 
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('hide_for_logged_in')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_for_logged_in')); ?>" type="text" value="1" <?php if(isset($instance['hide_for_logged_in'])  && $instance['hide_for_logged_in']==1) echo 'checked="checked"'; ?> /> 
		</p> 
	<?php 
    } 
}
add_action('widgets_init', function(){ return register_widget("TheChampVerticalSharingWidget" ); } );

/**
 * Widget for Social Counter (Standard widget)
 */
class TheChampCounterWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct(){ 
		parent::__construct(
			'TheChampHorizontalCounter', //unique id 
			'Super Socializer - Like Buttons (Standard Widget)', //title displayed at admin panel 
			//Additional parameters 
			array(
				'description' => __('Standard like buttons widget. Let your website users share/like content on popular Social networks like Facebook, Twitter, Pinterest and many more', 'super-socializer')
			)
		); 
	}  

	/** This is rendered widget content */ 
	public function widget($args, $instance){ 
		// return if sharing is disabled
		if(!the_champ_social_counter_enabled() || !the_champ_horizontal_counter_enabled()){
			return;
		}
		extract($args );
		if($instance['hide_for_logged_in']==1 && is_user_logged_in()) return;
		
		global $theChampCounterOptions, $post;
		$postId = $post->ID;
		$customUrl = apply_filters('heateor_ss_custom_share_url', '', $post);
		if($customUrl){
			$sharingUrl = $customUrl;
			$postId = 0;
		}elseif(isset($instance['target_url'])){
			if($instance['target_url'] == 'default'){
				$counterUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
				if(is_home()){
					$counterUrl = esc_url(home_url());
					$postId = 0;
				}elseif(!is_singular()){
					$counterUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
					$postId = 0;
				}elseif(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']){
					$counterUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
				}elseif(get_permalink($post->ID)){
					$counterUrl = get_permalink($post->ID);
				}
			}elseif($instance['target_url'] == 'homepage'){
				$counterUrl = esc_url(home_url());
				$postId = 0;
			}elseif($instance['target_url'] == 'custom'){
				$counterUrl = isset($instance['target_url_custom']) ? trim($instance['target_url_custom']) : get_permalink($post->ID);
				$postId = 0;
			}
		}else{
			$counterUrl = get_permalink($post->ID);
		}

		$counterUrl = heateor_ss_apply_target_like_button_url_filter($counterUrl, 'horizontal', !is_singular() ? true : false);
		echo "<div class='the_champ_counter_container the_champ_horizontal_counter'>";
		
		echo $before_widget;
		
		if(!empty($instance['title'])){ 
			$title = apply_filters('widget_title', $instance['title']); 
			echo $before_title . esc_html($title) . $after_title;
		}

		if(!empty($instance['before_widget_content'])){ 
			echo '<div>' . esc_html($instance['before_widget_content']) . '</div>'; 
		}
		// if bit.ly integration enabled, generate bit.ly short url
		$shortUrl = $counterUrl;
		if(isset($theChampCounterOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
			$shortUrl = wp_get_shortlink();
			// if bit.ly integration enabled, generate bit.ly short url
		}elseif(isset($theChampCounterOptions['bitly_enable']) && isset($theChampCounterOptions['bitly_access_token']) && $theChampCounterOptions['bitly_access_token'] != ''){
			$tempShortUrl = the_champ_generate_counter_bitly_url($counterUrl, $postId);
			if($tempShortUrl){
				$shortUrl = $tempShortUrl;
			}
		}
		echo the_champ_prepare_counter_html($counterUrl, 'horizontal', $shortUrl, !is_singular() ? true : false);

		if(!empty($instance['after_widget_content'])){ 
			echo '<div>' . esc_html($instance['after_widget_content']) . '</div>'; 
		}
		
		echo "</div>";
		echo $after_widget;
	}  

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update($new_instance, $old_instance){ 
		$instance = $old_instance; 
		$instance['title'] = strip_tags($new_instance['title']); 
		$instance['target_url'] = strip_tags($new_instance['target_url']); 
		$instance['target_url_custom'] = strip_tags($new_instance['target_url_custom']); 
		$instance['before_widget_content'] = $new_instance['before_widget_content']; 
		$instance['after_widget_content'] = $new_instance['after_widget_content']; 
		$instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];  

		return $instance; 
	}  

	/** Widget edit form at admin panel */ 
	public function form($instance){ 
		/* Set up default widget settings. */ 
		$defaults = array('title' => 'Share the joy', 'before_widget_content' => '', 'after_widget_content' => '', 'target_url_custom' => '', 'target_url' => 'default');

		foreach($instance as $key => $value){  
			if(is_string($value)){
				$instance[ $key ] = esc_attr($value);  
			}
		}
		
		$instance = wp_parse_args((array)$instance, $defaults ); 
		?> 
		<script type="text/javascript">
			function theChampToggleHorCounterTargetUrl(val){
				if(val == 'custom'){
					jQuery('.theChampHorCounterTargetUrl').css('display', 'block');
				}else{
					jQuery('.theChampHorCounterTargetUrl').css('display', 'none');
				}
			}
		</script>
		<p> 
			<p><strong>Note:</strong> <?php _e('Make sure "Standard Like Buttons" are enabled from "Super Socializer > Like Buttons" page.', 'super-socializer') ?></p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('target_url')); ?>"><?php _e('Target Url:', 'super-socializer'); ?></label> 
			<select style="width: 95%" onchange="theChampToggleHorCounterTargetUrl(this.value)" class="widefat" id="<?php echo esc_attr($this->get_field_id('target_url')); ?>" name="<?php echo esc_attr($this->get_field_name('target_url')); ?>">
				<option value="">--<?php _e('Select', 'super-socializer') ?>--</option>
				<option value="default" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'default' ? 'selected' : '' ; ?>><?php _e('Url of the webpage where icons are located (default)', 'super-socializer') ?></option>
				<option value="homepage" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'homepage' ? 'selected' : '' ; ?>><?php _e('Url of the homepage of your website', 'super-socializer') ?></option>
				<option value="custom" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'custom' ? 'selected' : '' ; ?>><?php _e('Custom Url', 'super-socializer') ?></option>
			</select>
			<input placeholder="<?php _e('Custom URL', 'super-socializer') ?>" style="width:95%; margin-top: 5px; <?php echo !isset($instance['target_url']) || $instance['target_url'] != 'custom' ? 'display: none' : '' ; ?>" class="widefat theChampHorCounterTargetUrl" id="<?php echo esc_attr($this->get_field_id('target_url_custom')); ?>" name="<?php echo esc_attr($this->get_field_name('target_url_custom')); ?>" type="text" value="<?php echo isset($instance['target_url_custom']) ? esc_attr($instance['target_url_custom']) : ''; ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('before_widget_content')); ?>"><?php _e('Before widget content:', 'super-socializer'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('before_widget_content')); ?>" name="<?php echo esc_attr($this->get_field_name('before_widget_content')); ?>" type="text" value="<?php echo esc_attr($instance['before_widget_content']); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('after_widget_content')); ?>"><?php _e('After widget content:', 'super-socializer'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('after_widget_content')); ?>" name="<?php echo esc_attr($this->get_field_name('after_widget_content')); ?>" type="text" value="<?php echo esc_attr($instance['after_widget_content']); ?>" /> 
			<br /><br /><label for="<?php echo esc_attr($this->get_field_id('hide_for_logged_in')); ?>"><?php _e('Hide for logged in users:', 'super-socializer'); ?></label> 
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('hide_for_logged_in')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_for_logged_in')); ?>" type="text" value="1" <?php if(isset($instance['hide_for_logged_in'])  && $instance['hide_for_logged_in']==1) echo 'checked="checked"'; ?> /> 
		</p> 
	<?php 
    } 
} 
add_action('widgets_init', function(){ return register_widget("TheChampCounterWidget" ); } );

/**
 * Widget for Social Counter (Floating widget)
 */
class TheChampVerticalCounterWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct(){ 
		parent::__construct(
			'TheChampVerticalCounter', //unique id 
			'Super Socializer - Like Buttons (Floating Widget)', //title displayed at admin panel 
			//Additional parameters 
			array(
				'description' => __('Floating like buttons widget. Let your website users share/like content on popular Social networks like Facebook, Twitter, Pinterest and many more', 'super-socializer')) 
			); 
	}  

	/** This is rendered widget content */ 
	public function widget($args, $instance){ 
		// return if counter is disabled
		if(!the_champ_social_counter_enabled() || !the_champ_vertical_counter_enabled()){
			return;
		}
		extract($args );
		if($instance['hide_for_logged_in']==1 && is_user_logged_in()) return;
		
		global $theChampCounterOptions, $post;
		$postId = $post->ID;
		$customUrl = apply_filters('heateor_ss_custom_share_url', '', $post);
		if($customUrl){
			$sharingUrl = $customUrl;
			$postId = 0;
		}elseif(isset($instance['target_url'])){
			if($instance['target_url'] == 'default'){
				$counterUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
				if(is_home()){
					$counterUrl = esc_url(home_url());
					$postId = 0;
				}elseif(!is_singular()){
					$counterUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
					$postId = 0;
				}elseif(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']){
					$counterUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
				}elseif(get_permalink($post->ID)){
					$counterUrl = get_permalink($post->ID);
				}
			}elseif($instance['target_url'] == 'homepage'){
				$counterUrl = esc_url(home_url());
				$postId = 0;
			}elseif($instance['target_url'] == 'custom'){
				$counterUrl = isset($instance['target_url_custom']) ? trim($instance['target_url_custom']) : get_permalink($post->ID);
				$postId = 0;
			}
		}else{
			$counterUrl = get_permalink($post->ID);
		}

		$counterUrl = heateor_ss_apply_target_like_button_url_filter($counterUrl, 'vertical', false);

		$ssOffset = 0;
		if(isset($instance['alignment']) && isset($instance[$instance['alignment'] . '_offset'])){
			$ssOffset = $instance[$instance['alignment'] . '_offset'];
		}
		global $heateorSsAllowedTags;
		echo wp_kses("<div class='the_champ_counter_container the_champ_vertical_counter" . (isset($theChampCounterOptions['hide_mobile_likeb']) ? ' the_champ_hide_sharing' : '') . "' " . (the_champ_is_amp_page() ? "" : "data-heateor-ss-offset='". $ssOffset ."' " ) . "style='".(isset($instance['alignment']) && $instance['alignment'] != '' && isset($instance[$instance['alignment'].'_offset']) ? $instance['alignment'].': '. ($instance[$instance['alignment'].'_offset'] == '' ? 0 : $instance[$instance['alignment'].'_offset']) .'px;' : '').(isset($instance['top_offset']) ? 'top: '. ($instance['top_offset'] == '' ? 0 : $instance['top_offset']) .'px;' : '') . (isset($instance['vertical_bg']) && $instance['vertical_bg'] != '' ? 'background-color: '.$instance['vertical_bg'] . ';' : '-webkit-box-shadow:none;box-shadow:none;') . "' >", $heateorSsAllowedTags);
		// if bit.ly integration enabled, generate bit.ly short url
		$shortUrl = $counterUrl;
		if(isset($theChampCounterOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
			$shortUrl = wp_get_shortlink();
			// if bit.ly integration enabled, generate bit.ly short url
		}elseif(isset($theChampCounterOptions['bitly_enable']) && isset($theChampCounterOptions['bitly_access_token']) && $theChampCounterOptions['bitly_access_token'] != ''){
			$tempShortUrl = the_champ_generate_counter_bitly_url($counterUrl, $postId);
			if($tempShortUrl){
				$shortUrl = $tempShortUrl;
			}
		}
		//echo $before_widget;
		echo the_champ_prepare_counter_html($counterUrl, 'vertical', $shortUrl);
		echo "</div>";
		//echo $after_widget;
	}  

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update($new_instance, $old_instance){ 
		$instance = $old_instance; 
		$instance['target_url'] = strip_tags($new_instance['target_url']); 
		$instance['target_url_custom'] = strip_tags($new_instance['target_url_custom']); 
		$instance['alignment'] = $new_instance['alignment'];
		$instance['left_offset'] = $new_instance['left_offset'];
		$instance['right_offset'] = $new_instance['right_offset'];
		$instance['top_offset'] = $new_instance['top_offset'];
		$instance['vertical_bg'] = $new_instance['vertical_bg'];
		$instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];

		return $instance; 
	}  

	/** Widget edit form at admin panel */ 
	public function form($instance){ 
		/* Set up default widget settings. */ 
		$defaults = array('alignment' => 'left', 'left_offset' => '40', 'right_offset' => '0', 'top_offset' => '100', 'vertical_bg' => '', 'target_url' => 'default', 'target_url_custom' => '');

		foreach($instance as $key => $value){  
			if(is_string($value)){
				$instance[ $key ] = esc_attr($value);  
			}
		}
		
		$instance = wp_parse_args((array)$instance, $defaults ); 
		?> 
		<p> 
			<script>
			function theChampToggleCounterOffset(alignment){
				if(alignment == 'left'){
					jQuery('.theChampCounterLeftOffset').css('display', 'block');
					jQuery('.theChampCounterRightOffset').css('display', 'none');
				}else{
					jQuery('.theChampCounterLeftOffset').css('display', 'none');
					jQuery('.theChampCounterRightOffset').css('display', 'block');
				}
			}
			function theChampToggleVerticalCounterTargetUrl(val){
				if(val == 'custom'){
					jQuery('.theChampVerticalCounterTargetUrl').css('display', 'block');
				}else{
					jQuery('.theChampVerticalCounterTargetUrl').css('display', 'none');
				}
			}
			</script>
		<p> 
			<p><strong>Note:</strong> <?php _e('Make sure "Floating Like Buttons" are enabled from "Super Socializer > Like Buttons" page.', 'super-socializer') ?></p>
			<label for="<?php echo esc_attr($this->get_field_id('target_url')); ?>"><?php _e('Target Url:', 'super-socializer'); ?></label> 
			<select style="width: 95%" onchange="theChampToggleVerticalCounterTargetUrl(this.value)" class="widefat" id="<?php echo esc_attr($this->get_field_id('target_url')); ?>" name="<?php echo esc_attr($this->get_field_name('target_url')); ?>">
				<option value="">--<?php _e('Select', 'super-socializer') ?>--</option>
				<option value="default" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'default' ? 'selected' : '' ; ?>><?php _e('Url of the webpage where icons are located (default)', 'super-socializer'); ?></option>
				<option value="homepage" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'homepage' ? 'selected' : '' ; ?>><?php _e('Url of the homepage of your website', 'super-socializer'); ?></option>
				<option value="custom" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'custom' ? 'selected' : '' ; ?>><?php _e('Custom Url', 'super-socializer'); ?></option>
			</select>
			<input placeholder="<?php _e('Custom URL', 'super-socializer') ?>" style="width:95%; margin-top: 5px; <?php echo !isset($instance['target_url']) || $instance['target_url'] != 'custom' ? 'display: none' : '' ; ?>" class="widefat theChampVerticalCounterTargetUrl" id="<?php echo esc_attr($this->get_field_id('target_url_custom')); ?>" name="<?php echo esc_attr($this->get_field_name('target_url_custom')); ?>" type="text" value="<?php echo isset($instance['target_url_custom']) ? $instance['target_url_custom'] : ''; ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('alignment')); ?>"><?php _e('Alignment', 'super-socializer'); ?></label> 
			<select style="width: 95%" onchange="theChampToggleCounterOffset(this.value)" class="widefat" id="<?php echo esc_attr($this->get_field_id('alignment')); ?>" name="<?php echo esc_attr($this->get_field_name('alignment')); ?>">
				<option value="left" <?php echo $instance['alignment'] == 'left' ? 'selected' : ''; ?>><?php _e('Left', 'super-socializer') ?></option>
				<option value="right" <?php echo $instance['alignment'] == 'right' ? 'selected' : ''; ?>><?php _e('Right', 'super-socializer') ?></option>
			</select>
			<div class="theChampCounterLeftOffset" <?php echo $instance['alignment'] == 'right' ? 'style="display: none"' : ''; ?>>
				<label for="<?php echo esc_attr($this->get_field_id('left_offset')); ?>"><?php _e('Left Offset', 'super-socializer'); ?></label> 
				<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('left_offset')); ?>" name="<?php echo esc_attr($this->get_field_name('left_offset')); ?>" type="text" value="<?php echo esc_attr($instance['left_offset']); ?>" />px<br/>
			</div>
			<div class="theChampCounterRightOffset" <?php echo $instance['alignment'] == 'left' ? 'style="display: none"' : ''; ?>>
				<label for="<?php echo esc_attr($this->get_field_id('right_offset')); ?>"><?php _e('Right Offset', 'super-socializer'); ?></label> 
				<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('right_offset')); ?>" name="<?php echo esc_attr($this->get_field_name('right_offset')); ?>" type="text" value="<?php echo esc_attr($instance['right_offset']); ?>" />px<br/>
			</div>
			<label for="<?php echo esc_attr($this->get_field_id('top_offset')); ?>"><?php _e('Top Offset', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('top_offset')); ?>" name="<?php echo esc_attr($this->get_field_name('top_offset')); ?>" type="text" value="<?php echo esc_attr($instance['top_offset']); ?>" />px<br/>
			
			<label for="<?php echo esc_attr($this->get_field_id('vertical_bg')); ?>"><?php _e('Background Color', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('vertical_bg')); ?>" name="<?php echo esc_attr($this->get_field_name('vertical_bg')); ?>" type="text" value="<?php echo esc_attr($instance['vertical_bg']); ?>" />
			
			<br /><br /><label for="<?php echo esc_attr($this->get_field_id('hide_for_logged_in')); ?>"><?php _e('Hide for logged in users:', 'super-socializer'); ?></label> 
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('hide_for_logged_in')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_for_logged_in')); ?>" type="text" value="1" <?php if(isset($instance['hide_for_logged_in'])  && $instance['hide_for_logged_in']==1) echo 'checked="checked"'; ?> />
		</p> 
	<?php 
    } 
} 
add_action('widgets_init', function(){ return register_widget("TheChampVerticalCounterWidget" ); } );

/**
 * Widget for Social Media follow icons
 */
class TheChampFollowWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct(){ 
		parent::__construct(
			'TheChampFollow', //unique id 
			__('Super Socializer - Follow Icons', 'super-socializer'), //title displayed at admin panel
			array( 
				'description' => __('These icons link to your Social Media accounts', 'super-socializer')) 
			); 
	}
	
	/** This is rendered widget content */ 
	public function widget($args, $instance){
		if(the_champ_is_amp_page()){
			return;
		}
		extract($args ); 
		echo $before_widget;
		if(!empty($instance['before_widget_content'])){ 
			echo '<div>' . esc_html($instance['before_widget_content']) . '</div>';
		}
		$check_theme = '';
		if(!isset($instance['custom_color']) || $instance['custom_color'] == ''){
			$check_theme = '';
		} elseif($instance['custom_color'] == 'standard'){
			$check_theme = 'standard_';
		} elseif($instance['custom_color'] == 'floating'){
			$check_theme = 'floating_';
		}
		$style = '';
		if(isset($instance['type']) && $instance['type'] == 'floating'){
			$style = 'position:fixed;top:' . (isset($instance['top_offset']) ? intval($instance['top_offset']) : 100 ) . 'px;' . (isset($instance['alignment']) && $instance['alignment'] == 'left' ? 'left' : 'right') . ':' . (isset($instance['alignment_value']) ? intval($instance['alignment_value']) : 100 ) . 'px;width:' . (isset($instance['size']) ? intval($instance['size']) : 32 ) . 'px;';
		}
		global $heateorSsAllowedTags;
		echo wp_kses('<div style="' . $style . '" class="heateor_ss_' . $check_theme . 'follow_icons_container' . (isset($instance['bottom_mobile_sharing']) ? ' heateor_ss_bottom_follow' : '') . '">', $heateorSsAllowedTags);
		if(!empty($instance['title'])){ 
			$title = apply_filters('widget_title', $instance['title']); 
			echo $before_title . esc_html($title) . $after_title;
		}
		echo wp_kses($this->follow_icons($instance), $heateorSsAllowedTags);
		echo '<div style="clear:both"></div>';
		echo '</div>';
		if(!empty($instance['after_widget_content'])){ 
			echo '<div>' . esc_html($instance['after_widget_content']) . '</div>';
		}
		echo $after_widget; 
	}  

	/** Render follow icons */
	private function follow_icons($instance){
		$logoColor = '#fff';
		$html = '';
		if(isset($instance['type']) && $instance['type'] == 'standard'){
			if(isset($instance['hor_alignment']) && $instance['hor_alignment'] == "center"){
				$html .= '<style>div.heateor_ss_follow_ul{width:100%;text-align:center;}.widget_thechampfollow div.heateor_ss_follow_ul a{float:none!important;display:inline-block;}.widget_thechampfollow .widget-title{text-align:center;}</style>';
			}elseif(isset($instance['hor_alignment']) && $instance['hor_alignment'] == "right"){
				$html .= '<style>.widget_thechampfollow .widget-title{text-align:right;}</style>';
			}
		}
		if(isset($instance['hide_mobile_sharing']) && $instance['vertical_screen_width'] != ''){
			$html .= '<style>@media screen and (max-width:' . $instance['vertical_screen_width'] . 'px){.the_champ_floating_follow_icons_container{display:none!important}}</style>';
		}
		global $theChampSharingOptions;
		if(isset($instance['custom_color']) && $instance['custom_color'] == 'standard'){
			if($theChampSharingOptions['horizontal_font_color_default']){
				$logoColor = $theChampSharingOptions['horizontal_font_color_default'];
			}
			if($theChampSharingOptions['horizontal_font_color_hover']){
				$html .= "<style>.widget_thechampfollow span.the_champ_svg svg:hover path:not(.the_champ_no_fill),.widget_thechampfollow span.the_champ_svg svg:hover ellipse, .widget_thechampfollow span.the_champ_svg svg:hover circle,.widget_thechampfollow span.the_champ_svg svg:hover polygon{
			        fill: " . $theChampSharingOptions['horizontal_font_color_hover'] . ";
			    }
			    .widget_thechampfollow span.the_champ_svg svg:hover span.the_champ_s_digg path{
			    	stroke: " . $theChampSharingOptions['horizontal_font_color_hover'] . ";
			    }
			    .widget_thechampfollow span.the_champ_svg svg:hover span.the_champ_s_whatsapp path.the_champ_no_fill{
			    	fill: " . $theChampSharingOptions['horizontal_font_color_hover'] . "!important;
			    }</style>";
			}	
		} elseif(isset($instance['custom_color']) && $instance['custom_color'] == 'floating'){ 
			if($theChampSharingOptions['vertical_font_color_default']){
				$logoColor = $theChampSharingOptions['vertical_font_color_default'];
			}
			if($theChampSharingOptions['vertical_font_color_hover']){
				$html .= "<style>.widget_thechampfollow span.the_champ_svg svg:hover path:not(.the_champ_no_fill),.widget_thechampfollow span.the_champ_svg svg:hover ellipse, .widget_thechampfollow span.the_champ_svg svg:hover circle,.widget_thechampfollow span.the_champ_svg svg:hover polygon{
			        fill:". $theChampSharingOptions['vertical_font_color_hover'] .";
			    }
			    .widget_thechampfollow span.the_champ_svg svg:hover span.the_champ_s_digg path{
			    	stroke:" . $theChampSharingOptions['vertical_font_color_hover'] . ";
			    }
			    .widget_thechampfollow span.the_champ_svg svg:hover span.the_champ_s_whatsapp path.the_champ_no_fill{
			    	fill:" . $theChampSharingOptions['vertical_font_color_hover'] . "!important;
			    }</style>";
			}
		}
		$bottom_sharing_alignment = ! isset($instance['bottom_sharing_alignment']) || $instance['bottom_sharing_alignment'] == 'left' ? 'left' : 'right';
		$bottom_sharing_alignment_inverse = $bottom_sharing_alignment == 'left' ? 'right' : 'left';
		$bottom_sharing_responsive_css = '';
		if(isset($instance['type']) && $instance['type'] == 'floating' && isset($instance['bottom_sharing_position_radio']) && $instance['bottom_sharing_position_radio'] == 'responsive'){
			$vertical_sharing_icon_height = $theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_height'] : $theChampSharingOptions['vertical_sharing_size'];
			$num_sharing_icons = isset($theChampSharingOptions['vertical_re_providers']) ? count($theChampSharingOptions['vertical_re_providers']) : 0;
			$bottom_sharing_responsive_css = 'div.the_champ_bottom_follow{width:100%!important;left:0!important;}div.the_champ_bottom_follow a{width:' . (100/($num_sharing_icons )) . '%!important;}div.the_champ_bottom_follow .the_champ_svg{width:100%!important;}';
		}
		if(isset($instance['type']) && $instance['type'] == 'floating' && isset($instance['bottom_mobile_sharing']) && $instance['horizontal_screen_width'] != '' && isset($instance['bottom_sharing_position_radio']) && $instance['bottom_sharing_position_radio'] == 'responsive'){
			$bottom_sharing_position = isset($instance['bottom_sharing_position']) ? $instance['bottom_sharing_position'] : '0';
			$html .= '<style>div.the_champ_mobile_footer{display:none;}@media screen and (max-width:' . (isset($instance['horizontal_screen_width']) ? intval($instance['horizontal_screen_width']) : 786 ) . 'px){' . $bottom_sharing_responsive_css . 'div.the_champ_mobile_footer{display:block;height:' . ($theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_height'] : $theChampSharingOptions['vertical_sharing_size']) . 'px;}.the_champ_bottom_follow{padding:0!important;' . (isset($instance['bottom_sharing_position_radio']) && $instance['bottom_sharing_position_radio'] == 'nonresponsive' ? $bottom_sharing_alignment . ':' . $bottom_sharing_position . 'px!important;' . $bottom_sharing_alignment_inverse . ':auto!important;' : '') . 'display:block!important;width:auto!important;bottom:' . (isset($theChampSharingOptions['vertical_total_shares']) ? '-10' : '-2') . 'px!important;top:auto!important;}}</style>';
		}

		$iconStyle = 'width:' . $instance['size'] . 'px;height:' . $instance['size'] . 'px;' . ($instance['icon_shape'] == 'round' ? 'border-radius:999px;' : '');
		$html .= '<div class="heateor_ss_follow_ul" ' . (isset($instance['hor_alignment']) && $instance['hor_alignment'] == 'right' ? ' style="float:right"' : '') . '>';
		if(isset($instance['facebook']) && $instance['facebook']){
			$html .= '<a aria-label="Facebook" class="the_champ_facebook" href="'. $instance['facebook'] .'" title="Facebook" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#3c589a;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="-5 -5 42 42"><path d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z" fill="'. $logoColor .'"></path></svg></span></a>';
		}
		if(isset($instance['twitter']) && $instance['twitter']){
			$html .= '<a aria-label="Twitter" class="the_champ_twitter" href="'. $instance['twitter'] .'" title="Twitter" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#55acee;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="-4 -4 39 39"><path d="M28 8.557a9.913 9.913 0 0 1-2.828.775 4.93 4.93 0 0 0 2.166-2.725 9.738 9.738 0 0 1-3.13 1.194 4.92 4.92 0 0 0-3.593-1.55 4.924 4.924 0 0 0-4.794 6.049c-4.09-.21-7.72-2.17-10.15-5.15a4.942 4.942 0 0 0-.665 2.477c0 1.71.87 3.214 2.19 4.1a4.968 4.968 0 0 1-2.23-.616v.06c0 2.39 1.7 4.38 3.952 4.83-.414.115-.85.174-1.297.174-.318 0-.626-.03-.928-.086a4.935 4.935 0 0 0 4.6 3.42 9.893 9.893 0 0 1-6.114 2.107c-.398 0-.79-.023-1.175-.068a13.953 13.953 0 0 0 7.55 2.213c9.056 0 14.01-7.507 14.01-14.013 0-.213-.005-.426-.015-.637.96-.695 1.795-1.56 2.455-2.55z" fill="'. $logoColor .'"></path></svg></span></a>';
		}
		if(isset($instance['instagram']) && $instance['instagram']){
			$html .= '<a aria-label="Instagram" class="the_champ_instagram" href="'. $instance['instagram'] .'" title="Instagram" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#53beee;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" height="100%" width="100%" version="1.1" viewBox="-10 -10 148 148" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><g><path d="M86,112H42c-14.336,0-26-11.663-26-26V42c0-14.337,11.664-26,26-26h44c14.337,0,26,11.663,26,26v44    C112,100.337,100.337,112,86,112z M42,24c-9.925,0-18,8.074-18,18v44c0,9.925,8.075,18,18,18h44c9.926,0,18-8.075,18-18V42    c0-9.926-8.074-18-18-18H42z" fill="'. $logoColor .'"></path></g><g><path d="M64,88c-13.234,0-24-10.767-24-24c0-13.234,10.766-24,24-24s24,10.766,24,24C88,77.233,77.234,88,64,88z M64,48c-8.822,0-16,7.178-16,16s7.178,16,16,16c8.822,0,16-7.178,16-16S72.822,48,64,48z" fill="'. $logoColor .'"></path></g><g><circle cx="89.5" cy="38.5" fill="'. $logoColor .'" r="5.5"></circle></g></g></svg></span></a>';
		}
		if(isset($instance['parler']) && $instance['parler']){
			$html .= '<a aria-label="Parler" class="the_champ_parler" href="'. $instance['parler'] .'" title="Parler" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#892E5E;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg version="1.1" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-213 20 900 500" style="enable-background:new 0 0 500 500;" xml:space="preserve"><g><path fill="'. $logoColor .'" d="M200,300v-50.3h100.1c27.5,0,49.9-22.3,49.9-49.9v0c0-27.5-22.3-49.9-49.9-49.9H0v0C0,67.2,67.2,0,150,0l150,0 c110.5,0,200,89.5,200,200v0c0,110.5-89.5,200-200,200h0C244.8,400,200,355.2,200,300z M150,350V200h0C67.2,200,0,267.2,0,350v150 h0C82.8,500,150,432.8,150,350z"/></g></svg></span></a>';
		}
		if(isset($instance['gab']) && $instance['gab']){
			$html .= '<a aria-label="Gab" class="the_champ_gab" href="'. $instance['gab'] .'" title="Gab" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#25CC80;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" style="%inner_style%" version="1.1" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="-14.5 3.5 46 30" xml:space="preserve"><g><path fill="'. $logoColor .'" d="M13.8,7.6h-2.4v0.7V9l-0.4-0.3C10.2,7.8,9,7.2,7.7,7.2c-0.2,0-0.4,0-0.4,0c-0.1,0-0.3,0-0.5,0 c-5.6,0.3-8.7,7.2-5.4,12.1c2.3,3.4,7.1,4.1,9.7,1.5l0.3-0.3l0,0.7c0,1-0.1,1.5-0.4,2.2c-1,2.4-4.1,3-6.8,1.3 c-0.2-0.1-0.4-0.2-0.4-0.2c-0.1,0.1-1.9,3.5-1.9,3.6c0,0.1,0.5,0.4,0.8,0.6c2.2,1.4,5.6,1.7,8.3,0.8c2.7-0.9,4.5-3.2,5-6.4 c0.2-1.1,0.2-0.8,0.2-8.4l0-7.1H13.8z M9.7,17.6c-2.2,1.2-4.9-0.4-4.9-2.9C4.8,12.6,7,11,9,11.6C11.8,12.4,12.3,16.1,9.7,17.6z"></path></g></svg></span></a>';
		}
		if(isset($instance['gettr']) && $instance['gettr']){
			$html .= '<a aria-label="Gettr" class="the_champ_gettr" href="'. $instance['gettr'] .'" title="Gettr" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#E50000;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" width="100%" height="100%" viewBox="-8 -5 50 50" xmlns="http://www.w3.org/2000/svg"><path d="M24.528 7.9125C24.1467 8.22187 23.7874 8.3875 23.2655 8.39688C23.7249 7.94688 24.1405 7.43125 24.478 6.875C24.8155 6.31875 25.0717 5.71875 25.2624 5.09375C23.6436 6.32187 21.1561 6.64062 18.9186 7.55312C16.753 8.42812 14.8186 9.85312 14.5655 11.7312C14.3874 13.0781 15.0686 14.6531 16.0249 16.0063C16.1311 15.6469 16.303 15.2781 16.553 15.0125C17.0467 14.4906 17.853 14.3594 18.628 14.2344C19.7999 14.0469 20.8936 13.875 21.8561 13.3156C22.5342 12.9219 23.1436 12.3313 23.528 11.6281C23.7467 11.2344 23.8936 10.8031 23.9811 10.3656C23.7311 10.6 23.3405 10.7531 23.0155 10.6844C23.8186 9.9 24.3374 9.00625 24.528 7.9125Z" fill="'. $logoColor .'"/><path d="M16.0221 17.6094H8.7002V18.2969C8.7002 18.2969 12.1314 18.4781 12.6877 21.0938H16.0189H19.3502C19.9064 18.4781 23.3377 18.2969 23.3377 18.2969V17.6094H16.0221Z" fill="'. $logoColor .'"/><path d="M19.2221 21.6846C19.0033 21.6439 18.8002 21.7658 18.7627 21.9596L18.3689 24.4533C18.3658 24.4721 18.3627 24.4908 18.3627 24.5096H17.6346L17.9564 22.0721C17.9752 21.8752 17.8127 21.7033 17.5971 21.6814C17.3783 21.6596 17.1846 21.8033 17.1689 21.9971L17.0189 24.5064C17.0189 24.5096 17.0189 24.5096 17.0189 24.5127H16.3314L16.4221 22.0377C16.4221 21.8533 16.2627 21.7002 16.0658 21.6846C16.0533 21.6846 16.0408 21.6814 16.0252 21.6814C16.0127 21.6814 15.9971 21.6814 15.9846 21.6846C15.8377 21.6971 15.7127 21.7814 15.6596 21.9033C15.6377 21.9471 15.6283 21.9939 15.6283 22.0439L15.7189 24.5189H15.0314C15.0314 24.5158 15.0314 24.5158 15.0314 24.5127L14.8752 22.0002C14.8564 21.8033 14.6658 21.6627 14.4471 21.6846C14.2283 21.7064 14.0658 21.8814 14.0877 22.0752L14.4096 24.5127H13.6814C13.6783 24.4939 13.6752 24.4752 13.6752 24.4564L13.2814 21.9627C13.2439 21.7689 13.0377 21.6471 12.8221 21.6877C12.6033 21.7283 12.4627 21.9221 12.5002 22.1158L13.0564 24.5158H13.3846C13.4814 25.0502 13.5439 25.4252 13.5783 25.6283H14.1283C14.2314 26.6533 15.2189 36.1221 15.2189 36.1221C15.2189 36.1221 15.2846 36.9252 16.0221 36.9252C16.7564 36.9252 16.8252 36.1221 16.8252 36.1221C16.9908 34.7971 17.8064 26.5814 17.9158 25.6283H18.4689C18.5033 25.4252 18.5658 25.0502 18.6627 24.5158H18.9908L19.5471 22.1158C19.5814 21.9189 19.4377 21.7252 19.2221 21.6846Z" fill="'. $logoColor .'"/></svg></span></a>';
		}
		if(isset($instance['pinterest']) && $instance['pinterest']){
			$html .= '<a aria-label="Pinterest" class="the_champ_pinterest" href="'. $instance['pinterest'] .'" title="Pinterest" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#cc2329;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="-2 -2 35 35"><path fill="'. $logoColor .'" d="M16.539 4.5c-6.277 0-9.442 4.5-9.442 8.253 0 2.272.86 4.293 2.705 5.046.303.125.574.005.662-.33.061-.231.205-.816.27-1.06.088-.331.053-.447-.191-.736-.532-.627-.873-1.439-.873-2.591 0-3.338 2.498-6.327 6.505-6.327 3.548 0 5.497 2.168 5.497 5.062 0 3.81-1.686 7.025-4.188 7.025-1.382 0-2.416-1.142-2.085-2.545.397-1.674 1.166-3.48 1.166-4.689 0-1.081-.581-1.983-1.782-1.983-1.413 0-2.548 1.462-2.548 3.419 0 1.247.421 2.091.421 2.091l-1.699 7.199c-.505 2.137-.076 4.755-.039 5.019.021.158.223.196.314.077.13-.17 1.813-2.247 2.384-4.324.162-.587.929-3.631.929-3.631.46.876 1.801 1.646 3.227 1.646 4.247 0 7.128-3.871 7.128-9.053.003-3.918-3.317-7.568-8.361-7.568z"/></svg></span></a>';
		}
		if(isset($instance['behance']) && $instance['behance']){
			$html .= '<a aria-label="Behance" class="the_champ_behance" href="'. $instance['behance'] .'" title="Behance" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#053eff;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 36 36"><path d="M3.862 8.136h5.66c1.377 0 3.19 0 4.13.566a3.705 3.705 0 0 1 1.837 3.26c0 1.66-.88 2.905-2.32 3.494v.042c1.924.397 2.97 1.838 2.97 3.76 0 2.297-1.636 4.483-4.743 4.483H3.86V8.14zm2.078 6.71h4.152c2.36 0 3.322-.856 3.322-2.493 0-2.16-1.53-2.468-3.322-2.468H5.94v4.96zm0 7.144h5.2c1.792 0 2.93-1.09 2.93-2.797 0-2.03-1.64-2.598-3.388-2.598H5.94v5.395zm22.017-1.833C27.453 22.65 25.663 24 23.127 24c-3.607 0-5.31-2.49-5.422-5.944 0-3.386 2.23-5.878 5.31-5.878 4 0 5.225 3.74 5.116 6.47h-8.455c-.067 1.966 1.05 3.716 3.52 3.716 1.53 0 2.6-.742 2.928-2.206h1.838zm-1.793-3.15c-.088-1.77-1.42-3.19-3.256-3.19-1.946 0-3.106 1.466-3.236 3.19h6.492zM20.614 8h4.935v1.68h-4.94z" fill="'. $logoColor .'"></path></svg></span></a>';
		}
		if(isset($instance['flickr']) && $instance['flickr']){
			$html .= '<a aria-label="Flickr" class="the_champ_flickr" href="'. $instance['flickr'] .'" title="Flickr" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#ff0084;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 36 36"><g fill="'. $logoColor .'"><circle cx="23" cy="16" r="6"></circle><circle cx="9" cy="16" r="6"></circle></g></svg></span></a>';
		}
		if(isset($instance['foursquare']) && $instance['foursquare']){
			$html .= '<a aria-label="Foursquare" class="the_champ_foursquare" href="'. $instance['foursquare'] .'" title="Foursquare" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#f94877;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="-4 -4 40 40"><path fill="'. $logoColor .'" d="M21.516 3H7.586C5.66 3 5 4.358 5 5.383v21.995c0 1.097.65 1.407.958 1.53.31.126 1.105.206 1.676-.36l6.72-7.455c.105-.12.49-.284.552-.284h4.184c1.79 0 1.81-1.45 1.997-2.206.157-.63 1.946-9.57 2.58-12.395.523-2.32-.104-3.21-2.15-3.21zM20.2 9.682c-.07.33-.368.66-.75.693h-5.44c-.61-.034-1.108.422-1.108 1.032v.665c0 .61.5 1.24 1.108 1.24h4.607c.43 0 .794.276.7.737-.093.46-.573 2.82-.627 3.07-.052.254-.282.764-.716.764h-3.62c-.682 0-1.36-.008-1.816.56-.458.573-4.534 5.293-4.534 5.293V6.403c0-.438.31-.746.715-.74h11.274c.41-.006.915.41.834 1L20.2 9.68z"></path></svg></span></a>';
		}
		if(isset($instance['github']) && $instance['github']){
			$html .= '<a aria-label="Github" class="the_champ_github" href="'. $instance['github'] .'" title="Github" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#2a2a2a;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 36 36"><path fill="'. $logoColor .'" d="M16 3.32c-7.182 0-13 5.82-13 13 0 5.754 3.72 10.612 8.89 12.335.65.114.893-.276.893-.617 0-.31-.016-1.333-.016-2.42-3.266.6-4.11-.797-4.37-1.53-.147-.373-.78-1.527-1.334-1.835-.455-.244-1.105-.845-.016-.86 1.024-.017 1.755.942 2 1.332 1.17 1.966 3.038 1.414 3.785 1.073.114-.845.455-1.414.83-1.74-2.893-.324-5.916-1.445-5.916-6.418 0-1.414.504-2.584 1.333-3.494-.13-.325-.59-1.657.13-3.445 0 0 1.085-.34 3.57 1.337 1.04-.293 2.146-.44 3.25-.44s2.21.147 3.25.44c2.49-1.69 3.58-1.337 3.58-1.337.714 1.79.26 3.12.13 3.446.828.91 1.332 2.064 1.332 3.494 0 4.99-3.04 6.094-5.93 6.42.47.405.876 1.185.876 2.404 0 1.74-.016 3.136-.016 3.575 0 .34.244.743.894.613C25.28 26.933 29 22.053 29 16.32c0-7.182-5.817-13-13-13z"></path></svg></span></a>';
		}
		if(isset($instance['linkedin']) && $instance['linkedin']){
			$html .= '<a aria-label="Linkedin" class="the_champ_linkedin" href="'. $instance['linkedin'] .'" title="Linkedin" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#0077b5;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 32 32"><path d="M6.227 12.61h4.19v13.48h-4.19V12.61zm2.095-6.7a2.43 2.43 0 0 1 0 4.86c-1.344 0-2.428-1.09-2.428-2.43s1.084-2.43 2.428-2.43m4.72 6.7h4.02v1.84h.058c.56-1.058 1.927-2.176 3.965-2.176 4.238 0 5.02 2.792 5.02 6.42v7.395h-4.183v-6.56c0-1.564-.03-3.574-2.178-3.574-2.18 0-2.514 1.7-2.514 3.46v6.668h-4.187V12.61z" fill="'. $logoColor .'"></path></svg></span></a>';
		}
		if(isset($instance['linkedin_company']) && $instance['linkedin_company']){
			$html .= '<a aria-label="Linkedin Company" class="the_champ_linkedin_company" href="'. $instance['linkedin_company'] .'" title="linkedinCompany" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#0077b5;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 32 32"><path d="M6.227 12.61h4.19v13.48h-4.19V12.61zm2.095-6.7a2.43 2.43 0 0 1 0 4.86c-1.344 0-2.428-1.09-2.428-2.43s1.084-2.43 2.428-2.43m4.72 6.7h4.02v1.84h.058c.56-1.058 1.927-2.176 3.965-2.176 4.238 0 5.02 2.792 5.02 6.42v7.395h-4.183v-6.56c0-1.564-.03-3.574-2.178-3.574-2.18 0-2.514 1.7-2.514 3.46v6.668h-4.187V12.61z" fill="'. $logoColor .'"></path></svg></span></a>';
		}
		if(isset($instance['medium']) && $instance['medium']){
			$html .= '<a aria-label="Medium" class="the_champ_medium" href="'. $instance['medium'] .'" title="medium" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#2a2a2a;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 36 36"><path d="M7.8 11a.8.8 0 0 0-.27-.7l-2-2.42v-.41h6.23L16.57 18l4.24-10.53h5.94v.36L25 9.47a.5.5 0 0 0-.19.48v12.1a.5.5 0 0 0 .19.48l1.68 1.64v.36h-8.4v-.36L20 22.49c.18-.17.18-.22.18-.49v-9.77l-4.82 12.26h-.65L9.09 12.23v8.22a1.09 1.09 0 0 0 .31.94l2.25 2.74v.36h-6.4v-.36l2.26-2.74a1.09 1.09 0 0 0 .29-.94z" fill="'. $logoColor .'"></path></svg></span></a>';
		}
		if(isset($instance['mewe']) && $instance['mewe']){
			$html .= '<a aria-label="Mewe" class="the_champ_mewe" href="'. $instance['mewe'] .'" title="Mewe" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#007da1;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="-3 -3 38 38"><g fill="'. $logoColor .'"><path d="M9.636 10.427a1.22 1.22 0 1 1-2.44 0 1.22 1.22 0 1 1 2.44 0zM15.574 10.431a1.22 1.22 0 0 1-2.438 0 1.22 1.22 0 1 1 2.438 0zM22.592 10.431a1.221 1.221 0 1 1-2.443 0 1.221 1.221 0 0 1 2.443 0zM29.605 10.431a1.221 1.221 0 1 1-2.442 0 1.221 1.221 0 0 1 2.442 0zM3.605 13.772c0-.471.374-.859.859-.859h.18c.374 0 .624.194.789.457l2.935 4.597 2.95-4.611c.18-.291.43-.443.774-.443h.18c.485 0 .859.387.859.859v8.113a.843.843 0 0 1-.859.845.857.857 0 0 1-.845-.845V16.07l-2.366 3.559c-.18.276-.402.443-.72.443-.304 0-.526-.167-.706-.443l-2.354-3.53V21.9c0 .471-.374.83-.845.83a.815.815 0 0 1-.83-.83v-8.128h-.001zM14.396 14.055a.9.9 0 0 1-.069-.333c0-.471.402-.83.872-.83.415 0 .735.263.845.624l2.23 6.66 2.187-6.632c.139-.402.428-.678.859-.678h.124c.428 0 .735.278.859.678l2.187 6.632 2.23-6.675c.126-.346.415-.609.83-.609.457 0 .845.361.845.817a.96.96 0 0 1-.083.346l-2.867 8.032c-.152.43-.471.706-.887.706h-.165c-.415 0-.721-.263-.872-.706l-2.161-6.328-2.16 6.328c-.152.443-.47.706-.887.706h-.165c-.415 0-.72-.263-.887-.706l-2.865-8.032z"></path></g></svg></span></a>';
		}
		if(isset($instance['odnoklassniki']) && $instance['odnoklassniki']){
			$html .= '<a aria-label="Odnoklassniki" class="the_champ_odnoklassniki" href="'. $instance['odnoklassniki'] .'" title="Odnoklassniki" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#f2720c;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 32 32"><path fill="'. $logoColor .'" d="M16 16.16a6.579 6.579 0 0 1-6.58-6.58A6.578 6.578 0 0 1 16 3a6.58 6.58 0 1 1 .002 13.16zm0-9.817a3.235 3.235 0 0 0-3.236 3.237 3.234 3.234 0 0 0 3.237 3.236 3.236 3.236 0 1 0 .004-6.473zm7.586 10.62c.647 1.3-.084 1.93-1.735 2.99-1.395.9-3.313 1.238-4.564 1.368l1.048 1.05 3.877 3.88c.59.59.59 1.543 0 2.133l-.177.18c-.59.59-1.544.59-2.134 0l-3.88-3.88-3.877 3.88c-.59.59-1.543.59-2.135 0l-.176-.18a1.505 1.505 0 0 1 0-2.132l3.88-3.877 1.042-1.046c-1.25-.127-3.19-.465-4.6-1.37-1.65-1.062-2.38-1.69-1.733-2.99.37-.747 1.4-1.367 2.768-.29C13.035 18.13 16 18.13 16 18.13s2.968 0 4.818-1.456c1.368-1.077 2.4-.457 2.768.29z"></path></svg></span></a>';
		}
		if(isset($instance['telegram']) && $instance['telegram']){
			$html .= '<a aria-label="Telegram" class="the_champ_telegram" href="'. $instance['telegram'] .'" title="Telegram" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#3da5f1;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 32 32"><path fill="'. $logoColor .'" d="M25.515 6.896L6.027 14.41c-1.33.534-1.322 1.276-.243 1.606l5 1.56 1.72 5.66c.226.625.115.873.77.873.506 0 .73-.235 1.012-.51l2.43-2.363 5.056 3.734c.93.514 1.602.25 1.834-.863l3.32-15.638c.338-1.363-.52-1.98-1.41-1.577z"></path></svg></span></a>';
		}
		if(isset($instance['tumblr']) && $instance['tumblr']){
			$html .= '<a aria-label="Tumblr" class="the_champ_tumblr" href="'. $instance['tumblr'] .'" title="Tumblr" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#29435d;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="-2 -2 36 36"><path fill="'. $logoColor .'" d="M20.775 21.962c-.37.177-1.08.33-1.61.345-1.598.043-1.907-1.122-1.92-1.968v-6.217h4.007V11.1H17.26V6.02h-2.925s-.132.044-.144.15c-.17 1.556-.895 4.287-3.923 5.378v2.578h2.02v6.522c0 2.232 1.647 5.404 5.994 5.33 1.467-.025 3.096-.64 3.456-1.17l-.96-2.846z"/></svg></span></a>';
		}
		if(isset($instance['vimeo']) && $instance['vimeo']){
			$html .= '<a aria-label="Vimeo" class="the_champ_vimeo" href="'. $instance['vimeo'] .'" title="Vimeo" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#1ab7ea;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 36 36"><path fill="'. $logoColor .'" d="M26.926 10.627c-.103 2.25-1.675 5.332-4.716 9.245C19.066 23.957 16.406 26 14.23 26c-1.348 0-2.49-1.244-3.42-3.732l-1.867-6.844C8.25 12.937 7.51 11.69 6.715 11.69c-.173 0-.778.365-1.815 1.09l-1.088-1.4a300.012 300.012 0 0 0 3.374-3.01c1.522-1.315 2.666-2.007 3.427-2.076 1.8-.173 2.907 1.057 3.322 3.69.45 2.84.76 4.608.935 5.3.52 2.356 1.09 3.534 1.713 3.534.483 0 1.21-.764 2.18-2.294.97-1.528 1.488-2.692 1.558-3.49.14-1.32-.38-1.98-1.553-1.98-.554 0-1.125.126-1.712.378 1.137-3.722 3.308-5.53 6.513-5.426 2.378.068 3.498 1.61 3.36 4.62z"></path></svg></span></a>';
		}
		if(isset($instance['threads'] ) && $instance['threads']){
			$html .= '<a aria-label="Threads" class="the_champ_threads" href="'. $instance['threads'] .'" title="Threads" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#2a2a2a;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="' . $logoColor . '" d="M22.067 15.123a8.398 8.398 0 0 0-.315-.142c-.185-3.414-2.05-5.368-5.182-5.388h-.042c-1.873 0-3.431.8-4.39 2.255l1.722 1.181c.716-1.087 1.84-1.318 2.669-1.318h.028c1.031.006 1.81.306 2.313.89.367.426.612 1.015.733 1.757a13.165 13.165 0 0 0-2.96-.143c-2.977.172-4.892 1.909-4.763 4.322.065 1.224.675 2.277 1.717 2.964.88.582 2.015.866 3.194.802 1.558-.085 2.78-.68 3.632-1.766.647-.825 1.056-1.894 1.237-3.241.742.448 1.292 1.037 1.596 1.745.516 1.205.546 3.184-1.068 4.797-1.415 1.414-3.116 2.025-5.686 2.044-2.851-.02-5.008-.935-6.41-2.717-1.313-1.67-1.991-4.08-2.016-7.165.025-3.085.703-5.496 2.016-7.165 1.402-1.782 3.558-2.696 6.41-2.718 2.872.022 5.065.94 6.521 2.731.714.879 1.252 1.983 1.607 3.27l2.018-.538c-.43-1.585-1.107-2.95-2.027-4.083C22.755 5.2 20.025 4.024 16.509 4h-.014c-3.51.024-6.209 1.205-8.022 3.51C6.86 9.56 6.028 12.414 6 15.992v.016c.028 3.578.86 6.431 2.473 8.482 1.813 2.305 4.512 3.486 8.022 3.51h.014c3.12-.022 5.319-.838 7.13-2.649 2.371-2.368 2.3-5.336 1.518-7.158-.56-1.307-1.629-2.369-3.09-3.07Zm-5.387 5.065c-1.305.074-2.66-.512-2.727-1.766-.05-.93.662-1.969 2.807-2.092.246-.015.487-.021.724-.021.78 0 1.508.075 2.171.22-.247 3.088-1.697 3.59-2.975 3.66Z"></path></svg></span></a>';
		}
		if(isset($instance['x'] ) && $instance['x']){
			$html .= '<a aria-label="X" class="the_champ_x" href="'. $instance['x'] .'" title="X" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#2a2a2a;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg width="100%" height="100%" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="' . $logoColor . '" d="M21.751 7h3.067l-6.7 7.658L26 25.078h-6.172l-4.833-6.32-5.531 6.32h-3.07l7.167-8.19L6 7h6.328l4.37 5.777L21.75 7Zm-1.076 16.242h1.7L11.404 8.74H9.58l11.094 14.503Z"></path></svg></span></a>';
		}
		if(isset($instance['tiktok'] ) && $instance['tiktok']){
			$html .= '<a aria-label="Tiktok" class="the_champ_tiktok" href="'. $instance['tiktok'] .'" title="TikTok" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#2a2a2a;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M23.34 8.81A5.752 5.752 0 0 1 20.72 4h-4.13v16.54c-.08 1.85-1.6 3.34-3.47 3.34a3.48 3.48 0 0 1-3.47-3.47c0-1.91 1.56-3.47 3.47-3.47.36 0 .7.06 1.02.16v-4.21c-.34-.05-.68-.07-1.02-.07-4.19 0-7.59 3.41-7.59 7.59 0 2.57 1.28 4.84 3.24 6.22 1.23.87 2.73 1.38 4.35 1.38 4.19 0 7.59-3.41 7.59-7.59v-8.4a9.829 9.829 0 0 0 5.74 1.85V9.74a5.7 5.7 0 0 1-3.13-.93Z" fill="' . $logoColor . '"></path></svg></span></a>';
		}
		if(isset($instance['vkontakte']) && $instance['vkontakte']){
			$html .= '<a aria-label="Vkontakte" class="the_champ_vkontakte" href="'. $instance['vkontakte'] .'" title="Vkontakte" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#0077FF;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" height="100%" width="100%" viewBox="0.75 12.5 46 22" xmlns="http://www.w3.org/2000/svg"><path d="M25.54 34.58c-10.94 0-17.18-7.5-17.44-19.98h5.48c.18 9.16 4.22 13.04 7.42 13.84V14.6h5.16v7.9c3.16-.34 6.48-3.94 7.6-7.9h5.16c-.86 4.88-4.46 8.48-7.02 9.96 2.56 1.2 6.66 4.34 8.22 10.02h-5.68c-1.22-3.8-4.26-6.74-8.28-7.14v7.14z" fill="'. $logoColor .'"></path></svg></span></a>';
		}
		if(isset($instance['whatsapp']) && $instance['whatsapp']){
			$html .= '<a aria-label="Whatsapp" class="the_champ_whatsapp" href="'. $instance['whatsapp'] .'" title="Whatsapp" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#55eb4c;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="-5 -5 40 40"><path id="arc1" stroke="'. $logoColor .'" stroke-width="2" fill="none" d="M 11.579798566743314 24.396926207859085 A 10 10 0 1 0 6.808479557110079 20.73576436351046"></path><path d="M 7 19 l -1 6 l 6 -1" stroke="'. $logoColor .'" stroke-width="2" fill="none"></path><path d="M 10 10 q -1 8 8 11 c 5 -1 0 -6 -1 -3 q -4 -3 -5 -5 c 4 -2 -1 -5 -1 -4" fill="'. $logoColor .'"></path></svg></span></a>';
		}
		if(isset($instance['xing']) && $instance['xing']){
			$html .= '<a aria-label="Yelp" class="the_champ_xing" href="'. $instance['xing'] .'" title="Xing" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#00797d;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="-6 -6 42 42"><path d="M 6 9 h 5 l 4 4 l -5 7 h -5 l 5 -7 z m 15 -4 h 5 l -9 13 l 4 8 h -5 l -4 -8 z" fill="'. $logoColor .'"></path></svg></span></a>';
		}
		if(isset($instance['youtube']) && $instance['youtube']){
			$html .= '<a aria-label="Youtube" class="the_champ_facebook" href="'. $instance['facebook'] .'" title="Facebook" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:red;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 32 32"><path fill="'. $logoColor .'" d="M26.78 11.6s-.215-1.515-.875-2.183c-.837-.876-1.774-.88-2.204-.932-3.075-.222-7.693-.222-7.693-.222h-.01s-4.618 0-7.697.222c-.43.05-1.368.056-2.205.932-.66.668-.874 2.184-.874 2.184S5 13.386 5 15.166v1.67c0 1.78.22 3.56.22 3.56s.215 1.516.874 2.184c.837.875 1.936.85 2.426.94 1.76.17 7.48.22 7.48.22s4.623-.007 7.7-.23c.43-.05 1.37-.056 2.205-.932.66-.668.875-2.184.875-2.184s.22-1.78.22-3.56v-1.67c0-1.78-.22-3.56-.22-3.56zm-13.052 7.254v-6.18l5.944 3.1-5.944 3.08z"></path></svg></span></a>';
		}
		if(isset($instance['youtube_channel']) && $instance['youtube_channel']){
			$html .= '<a aria-label="Youtube Channel" class="the_champ_youtube_channel" href="'. $instance['youtube_channel'] .'" title="Youtubechannel" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:red;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 32 32"><path fill="'. $logoColor .'" d="M26.78 11.6s-.215-1.515-.875-2.183c-.837-.876-1.774-.88-2.204-.932-3.075-.222-7.693-.222-7.693-.222h-.01s-4.618 0-7.697.222c-.43.05-1.368.056-2.205.932-.66.668-.874 2.184-.874 2.184S5 13.386 5 15.166v1.67c0 1.78.22 3.56.22 3.56s.215 1.516.874 2.184c.837.875 1.936.85 2.426.94 1.76.17 7.48.22 7.48.22s4.623-.007 7.7-.23c.43-.05 1.37-.056 2.205-.932.66-.668.875-2.184.875-2.184s.22-1.78.22-3.56v-1.67c0-1.78-.22-3.56-.22-3.56zm-13.052 7.254v-6.18l5.944 3.1-5.944 3.08z"></path></svg></span></a>';
		}
		if(isset($instance['rss_feed']) && $instance['rss_feed']){
			$html .= '<a aria-label="RSS Feed" class="the_champ_rss_feed" href="'. $instance['rss_feed'] .'" title="RSS Feed" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#e3702d;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="-4 -4 40 40"><g fill="'. $logoColor .'"><ellipse cx="7.952" cy="24.056" rx="2.952" ry="2.944"></ellipse><path d="M5.153 16.625c2.73 0 5.295 1.064 7.22 2.996a10.2 10.2 0 0 1 2.996 7.255h4.2c0-7.962-6.47-14.44-14.42-14.44v4.193zm.007-7.432c9.724 0 17.636 7.932 17.636 17.682H27C27 14.812 17.203 5 5.16 5v4.193z"></path></g></svg></span></a>';
		}
		if(isset($instance['google_maps'] ) && $instance['google_maps']){
			$html .= '<a aria-label="Google Maps" class="the_champ_google_maps" href="'. $instance['google_maps'] .'" title="Google Maps" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#34a853;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="' . $logoColor . '" fill-rule="evenodd" d="M10.714 8.619C11.789 7.329 13.683 6 16.293 6c1.26 0 2.21.33 2.22.333l.004-.002c1.802.582 3.343 1.805 4.276 3.607l-.002.001c.017.03.824 1.423.824 3.423 0 2.16-.835 3.708-.835 3.708-.583 1.207-1.774 2.69-2.25 3.282-.08.1-.14.174-.173.218-.863 1.082-1.74 2.209-2.447 3.476-.36.657-.588 1.352-.879 2.262-.14.418-.321.689-.72.689-.367 0-.538-.16-.727-.692-.307-.964-.483-1.507-.904-2.307a21.213 21.213 0 0 0-1.65-2.44v-.003a37.276 37.276 0 0 0-.907-1.158c-.873-1.086-1.832-2.28-2.403-3.587 0 0-.72-1.414-.72-3.461 0-1.935.75-3.627 1.714-4.73Zm3.441 2.903.002.002-.014.017c-.093.114-.628.81-.628 1.786a2.781 2.781 0 0 0 2.791 2.794c1.06 0 1.756-.585 2.025-.86l.126-.144.052-.065c.15-.203.59-.866.59-1.746 0-1.594-1.339-2.786-2.786-2.786-1.368 0-2.154 1-2.154 1v-.002l-.004.004Z" clip-rule="evenodd"></path></svg></span></a>';
		}
		if(isset($instance['google_news'] ) && $instance['google_news']){
			$html .= '<a aria-label="Google News" class="the_champ_google_news" href="'. $instance['google_news'] .'" title="Google News" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#4285F4;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg viewBox="35 45 80 80" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><path fill="'. $logoColor .'" d="M99.6,77.8H78.2v-5.6h21.4c0.6,0,1.1,0.5,1.1,1.1v3.4C100.7,77.3,100.2,77.8,99.6,77.8z"></path><path fill="'. $logoColor .'" d="M99.6,99.2H78.2v-5.6h21.4c0.6,0,1.1,0.5,1.1,1.1v3.4C100.7,98.7,100.2,99.2,99.6,99.2z"></path><path fill="'. $logoColor .'" d="M103,88.5H78.2v-5.6H103c0.6,0,1.1,0.5,1.1,1.1v3.4C104.1,88,103.6,88.5,103,88.5z"></path><path fill="'. $logoColor .'" d="M59.1,83.4v5.1h7.3c-0.6,3.1-3.3,5.3-7.3,5.3c-4.4,0-8-3.7-8-8.2c0-4.4,3.6-8.2,8-8.2c2,0,3.8,0.7,5.2,2v0 l3.9-3.9c-2.3-2.2-5.4-3.5-9-3.5c-7.5,0-13.5,6-13.5,13.5c0,7.5,6,13.5,13.5,13.5C66.9,99.2,72,93.7,72,86c0-0.9-0.1-1.7-0.2-2.6 H59.1z"></path></svg></span></a>';
		}
		if(isset($instance['yelp']) && $instance['yelp']){
			$html .= '<a aria-label="Yelp" class="the_champ_yelp" href="'. $instance['yelp'] .'" title="Yelp" rel="nofollow noopener" target="_blank" style="font-size:32px!important;box-shadow:none;display:inline-block;vertical-align:middle;"><span style="background-color:#ff1a1a;display:inline-block;opacity:1;float:left;font-size:32px;box-shadow:none;display:inline-block;font-size:16px;padding:0 4px;vertical-align:middle;background-repeat:repeat;overflow:hidden;padding:0;cursor:pointer;'. $iconStyle .'" class="the_champ_svg"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="' . $logoColor . '" d="m12.281 19.143 1.105-.256a1.1 1.1 0 0 0 .109-.029 1.22 1.22 0 0 0 .872-1.452l-.005-.02a1.216 1.216 0 0 0-.187-.411 1.537 1.537 0 0 0-.451-.387 4.174 4.174 0 0 0-.642-.297l-1.211-.442c-.68-.253-1.36-.5-2.047-.74-.445-.158-.822-.297-1.15-.399-.061-.019-.13-.038-.185-.057-.396-.122-.675-.172-.91-.173a1.084 1.084 0 0 0-.46.083 1.173 1.173 0 0 0-.398.283c-.056.063-.108.13-.157.198a2.342 2.342 0 0 0-.232.464A6.289 6.289 0 0 0 6 17.572c.004.634.021 1.448.37 2 .084.142.197.265.33.36.25.171.5.194.762.213.39.028.768-.068 1.145-.155l3.671-.848h.003Zm12.329-5.868a6.276 6.276 0 0 0-1.2-1.71 2.374 2.374 0 0 0-.412-.315 2.352 2.352 0 0 0-.226-.109 1.169 1.169 0 0 0-.482-.08c-.157.01-.311.053-.45.127-.21.105-.439.273-.742.555-.042.042-.095.089-.142.133-.25.235-.529.525-.86.863-.512.517-1.016 1.037-1.517 1.563l-.896.93c-.164.17-.313.353-.446.548-.114.164-.194.35-.237.545a1.22 1.22 0 0 0 .01.452l.005.02a1.218 1.218 0 0 0 1.419.923.992.992 0 0 0 .11-.021l4.779-1.104c.376-.087.758-.167 1.097-.363.226-.132.442-.262.59-.525a1.18 1.18 0 0 0 .14-.469c.074-.65-.266-1.39-.54-1.963Zm-8.551 2.01c.346-.435.345-1.084.376-1.614.104-1.77.214-3.542.3-5.314.034-.671.106-1.333.067-2.01-.033-.557-.037-1.198-.39-1.656-.621-.807-1.947-.74-2.852-.616-.277.039-.555.09-.83.157-.275.066-.548.138-.815.223-.868.285-2.088.807-2.295 1.807-.116.565.16 1.144.374 1.66.26.625.614 1.189.937 1.778.855 1.554 1.725 3.099 2.593 4.645.259.462.541 1.047 1.043 1.286.033.014.066.027.101.038a1.213 1.213 0 0 0 1.312-.302c.027-.026.054-.054.079-.082Zm-.415 4.741a1.106 1.106 0 0 0-1.23-.415 1.134 1.134 0 0 0-.153.064 1.468 1.468 0 0 0-.217.135c-.2.148-.367.34-.52.532-.038.049-.074.114-.12.156l-.768 1.057c-.436.592-.866 1.186-1.292 1.79-.278.389-.518.718-.708 1.009-.036.054-.073.115-.108.164-.227.352-.356.61-.422.838a1.08 1.08 0 0 0-.046.472c.02.166.076.325.163.468.046.07.096.14.149.206a2.325 2.325 0 0 0 .386.356c.53.37 1.111.634 1.722.84a6.09 6.09 0 0 0 1.572.3 2.403 2.403 0 0 0 .523-.041c.083-.02.165-.044.245-.072.156-.058.298-.149.417-.265.113-.113.2-.25.254-.4.09-.22.148-.502.186-.92.003-.059.012-.13.018-.195.03-.346.044-.753.066-1.232.038-.735.067-1.468.09-2.202l.05-1.306c.011-.3.002-.634-.081-.934a1.397 1.397 0 0 0-.176-.405Zm8.676 2.044c-.161-.176-.388-.352-.747-.568-.052-.03-.112-.068-.168-.101-.299-.18-.658-.369-1.078-.597-.645-.354-1.291-.7-1.943-1.042l-1.151-.61c-.06-.018-.12-.061-.177-.088a2.864 2.864 0 0 0-.7-.25 1.5 1.5 0 0 0-.254-.027c-.055 0-.11.003-.164.01a1.107 1.107 0 0 0-.923.914c-.018.146-.012.294.016.439.056.306.193.61.334.875l.615 1.152c.343.65.689 1.297 1.044 1.94.229.421.42.78.598 1.079.034.056.072.116.101.168.217.358.392.584.569.746a1.104 1.104 0 0 0 .895.302 2.37 2.37 0 0 0 .25-.044 2.384 2.384 0 0 0 .49-.193 6.104 6.104 0 0 0 1.28-.96c.46-.452.867-.945 1.183-1.51.044-.08.082-.162.114-.248.03-.079.055-.16.077-.24a2.46 2.46 0 0 0 .043-.252 1.19 1.19 0 0 0-.057-.491 1.093 1.093 0 0 0-.248-.404Z"></path></svg></span></a>';
		}
		$html = apply_filters('the_champ_follow_icons', $html, $instance, $iconStyle);
		$html .= '</div>';

		return $html;

	}

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update($new_instance, $old_instance){ 
		$instance = $old_instance; 
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['size'] = intval($new_instance['size']);
		$instance['custom_color'] =  $new_instance['custom_color'] ;
		$instance['icon_shape'] = $new_instance['icon_shape'];
		$instance['alignment'] = $new_instance['alignment'];
		$instance['hor_alignment'] = $new_instance['hor_alignment'];
		$instance['type'] = $new_instance['type'];
		$instance['facebook'] = $new_instance['facebook'];
		$instance['twitter'] = $new_instance['twitter'];
		$instance['parler'] = $new_instance['parler'];
		$instance['instagram'] = $new_instance['instagram'];
		$instance['pinterest'] = $new_instance['pinterest'];
		$instance['behance'] = $new_instance['behance'];
		$instance['flickr'] = $new_instance['flickr'];
		$instance['foursquare'] = $new_instance['foursquare'];
		$instance['github'] = $new_instance['github'];
		$instance['linkedin'] = $new_instance['linkedin'];
		$instance['linkedin_company'] = $new_instance['linkedin_company'];
		$instance['medium'] = $new_instance['medium'];
		$instance['mewe'] = $new_instance['mewe'];
		$instance['odnoklassniki'] = $new_instance['odnoklassniki'];
		$instance['snapchat'] = $new_instance['snapchat'];
		$instance['telegram'] = $new_instance['telegram'];
		$instance['tumblr'] = $new_instance['tumblr'];
		$instance['vimeo'] = $new_instance['vimeo'];
		$instance['vkontakte'] = $new_instance['vkontakte'];
		$instance['xing'] = $new_instance['xing'];
		$instance['youtube'] = $new_instance['youtube'];
		$instance['youtube_channel'] = $new_instance['youtube_channel'];
		$instance['rss_feed'] = $new_instance['rss_feed'];
		$instance['gab'] = $new_instance['gab'];
		$instance['gettr'] = $new_instance['gettr'];
		$instance['threads'] = $new_instance['threads'];
		$instance['tiktok'] = $new_instance['tiktok'];
		$instance['x'] = $new_instance['x'];
		$instance['google_maps'] = $new_instance['google_maps'];
		$instance['google_news'] = $new_instance['google_news'];
		$instance['yelp'] = $new_instance['yelp'];
		$instance['before_widget_content'] = $new_instance['before_widget_content']; 
		$instance['after_widget_content'] = $new_instance['after_widget_content'];

		return $instance; 
	}  

	/** Widget options in admin panel */ 
	public function form($instance){ 
		/* Set up default widget settings. */ 
		$defaults = array('alignment' => 'left', 'hor_alignment' => 'left', 'title' => '', 'type' => 'standard', 'alignment' => 'right', 'size' => '32', 'icon_shape' => 'round', 'custom_color' => '', 'facebook' => '', 'threads' => '', 'twitter' => '', 'tiktok' => '', 'instagram' => '', 'gettr' => '', 'x' => '', 'gab' => '', 'parler' => '', 'pinterest' => '', 'behance' => '', 'flickr' => '', 'foursquare' => '', 'github' => '', 'gitlab' => '', 'linkedin' => '', 'linkedin_company' => '', 'medium' => '', 'mewe' => '', 'odnoklassniki' => '', 'telegram' => '', 'tumblr' => '', 'vimeo' => '', 'vkontakte' => '', 'google_maps' => '', 'yelp' => '', 'whatsapp' => '', 'xing' => '', 'youtube' => '', 'youtube_channel' => '', 'rss_feed' => '', 'google_news' => '', 'before_widget_content' => '', 'after_widget_content' => '', 'top_offset' => '200', 'alignment_value' => '0', 'mobile_sharing' => '1', 'bottom_mobile_sharing' => '1', 'vertical_screen_width' => '783', 'horizontal_screen_width' => '783', 'bottom_sharing_alignment' => 'left', 'bottom_sharing_position_radio' => 'responsive', 'bottom_sharing_position' => '0');  

		foreach($instance as $key => $value){  
			if(is_string($value)){
				$instance[ $key ] = esc_attr($value);  
			}
		}

		$instance = wp_parse_args((array)$instance, $defaults); 
		?> 
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('before_widget_content')); ?>"><?php _e('Before widget content:', 'super-socializer'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('before_widget_content')); ?>" name="<?php echo esc_attr($this->get_field_name('before_widget_content')); ?>" type="text" value="<?php echo esc_attr($instance['before_widget_content']); ?>" /><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('hor_alignment')); ?>"><?php _e('Alignment', 'super-socializer'); ?></label><br/>
			<select style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('hor_alignment')); ?>" name="<?php echo esc_attr($this->get_field_name('hor_alignment')); ?>">
				<option value="" <?php echo ! isset($instance['hor_alignment'] ) || $instance['hor_alignment'] == 'left' ? 'selected' : '' ; ?>><?php _e('Left', 'super-socializer'); ?></option>
				<option value="center" <?php echo isset($instance['hor_alignment'] ) && $instance['hor_alignment'] == 'center' ? 'selected' : '' ; ?>><?php _e('Center', 'super-socializer'); ?></option>
				<option value="right" <?php echo isset($instance['hor_alignment'] ) && $instance['hor_alignment'] == 'right' ? 'selected' : '' ; ?>><?php _e('Right', 'super-socializer'); ?></option>
			</select><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('mode_standard')); ?>"><?php _e('Type:', 'super-socializer') ?></label><br>
			<input id="<?php echo esc_attr($this->get_field_id('mode_standard')); ?>" type="radio" onclick="jQuery('.heateorSsFloatingAlignment').css('display', 'none');" name="<?php echo esc_attr($this->get_field_name('type')); ?>" value="standard" <?php if(!isset($instance['type']) || $instance['type'] == 'standard'){
				echo "checked";
			} ?>><label for="<?php echo esc_attr($this->get_field_id('mode_standard')); ?>"> <?php _e('Standard', 'super-socializer') ?></label><br>
 			<input id="<?php echo esc_attr($this->get_field_id('mode_floating')); ?>" type="radio" name="<?php echo esc_attr($this->get_field_name('type')); ?>" onclick="jQuery('.heateorSsFloatingAlignment').css('display', 'block');" value="floating" <?php if(isset($instance['type']) && $instance['type'] == 'floating'){
				echo "checked";
			}?>><label for="<?php echo esc_attr($this->get_field_id('mode_floating')); ?>"> <?php _e('Floating', 'super-socializer') ?></label><br><br>

			<div class="heateorSsFloatingAlignment"
				<?php echo isset($instance['type']) && $instance['type'] == 'standard' ? "style='display:none'" : "style='display:block'" ?>>
				<label for="<?php echo esc_attr($this->get_field_id('top_offset')); ?>">
				<?php _e('Top offset:', 'super-socializer') ?>
				</label>
				<input id="<?php echo esc_attr($this->get_field_id('top_offset')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('top_offset')); ?>" value="<?php echo isset($instance['top_offset']) ? esc_attr($instance['top_offset']) : ''; ?>"/>px<br><br>
				<label for="<?php echo esc_attr($this->get_field_id('floating_left')); ?>">
				<?php _e('Alignment:', 'super-socializer') ?>
				</label>
				<input id="<?php echo esc_attr($this->get_field_id('floating_left')); ?>" type="radio" name="<?php echo esc_attr($this->get_field_name('alignment')); ?>" value="left" 
				<?php if(! isset($instance['alignment']) || $instance['alignment'] == 'left'){
				echo 'checked';
				} ?>>
				<label for="<?php echo esc_attr($this->get_field_id('floating_left')); ?>"> 
				<?php _e('Left', 'super-socializer') ?>
				</label>
				<input id="<?php echo esc_attr($this->get_field_id('floating_right')); ?>" type="radio" name="<?php echo esc_attr($this->get_field_name('alignment')); ?>" value="right"
				<?php if($instance['alignment'] == 'right'){
				echo 'checked';
				} ?> />
				<label for="<?php echo esc_attr($this->get_field_id('floating_right')); ?>" > 
				<?php _e('Right', 'super-socializer') ?>
				</label>
				<br>
				<br>
				<label id="<?php echo esc_attr($this->get_field_id('alignment_value_label')); ?>" for="<?php echo esc_attr($this->get_field_id('alignment_value')); ?>"><?php _e('Offset', 'super-socializer'); ?></label>
				<br>
				<input id='<?php echo esc_attr($this->get_field_id('alignment_value')); ?>' type="text" name="<?php echo esc_attr($this->get_field_name('alignment_value')); ?>" value="<?php echo isset($instance['alignment_value']) ? esc_attr($instance['alignment_value']) : ''; ?>" />px<br><br>
				<input id="<?php echo esc_attr($this->get_field_id('mobile_sharing')); ?>" name="<?php echo esc_attr($this->get_field_name('mobile_sharing')); ?>" type="checkbox" <?php echo isset($instance['mobile_sharing']) ? 'checked="checked"' : ''; ?> value="1" />
				<label><?php echo sprintf(__('Display vertical interface only when screen is wider than %s pixels', 'super-socializer'), '<input style="width:46px" name="' . esc_attr($this->get_field_name('vertical_screen_width')) . '" type="text" value="' . (isset($instance['vertical_screen_width']) ? esc_attr($instance['vertical_screen_width']) : '') . '" />') ?></label>
				<br><br>
				<input id="<?php echo esc_attr($this->get_field_id('mobile_sharing_bottom')); ?>" name="<?php echo esc_attr($this->get_field_name('bottom_mobile_sharing')); ?>" type="checkbox" <?php echo isset($instance['bottom_mobile_sharing']) ? 'checked="checked"' : '';?> value="1" />

				<label><?php echo sprintf(__('Stick vertical floating interface horizontally at bottom only when screen is narrower than %s pixels', 'super-socializer'), '<input style="width:46px" name="' . esc_attr($this->get_field_name('horizontal_screen_width')) . '" type="text" value="' . (isset($instance['horizontal_screen_width']) ? $instance['horizontal_screen_width'] : '') . '" />') ?></label>

				<br><br>

				<input type="radio" id="<?php echo esc_attr($this->get_field_id('bottom_sharing_position_radio_nonresponsive')); ?>" <?php echo isset($instance['bottom_sharing_position_radio']) && $instance['bottom_sharing_position_radio'] == 'nonresponsive' ? 'checked' : ''; ?> name="<?php echo esc_attr($this->get_field_name('bottom_sharing_position_radio')); ?>" value="nonresponsive" />

				<label for="<?php echo esc_attr($this->get_field_id('bottom_sharing_position_radio_nonresponsive')); ?>"><?php echo sprintf(__('%s pixels from %s', 'super-socializer'), '<input id="'. esc_attr($this->get_field_id('mobile_sharing_position')) . '" style="width:46px" name="'.$this->get_field_name('bottom_sharing_position').'" type="text" value="' . (isset($instance['bottom_sharing_position']) ? $instance['bottom_sharing_position'] : '') . '" />', '<select style="width:63px" name="' . esc_attr($this->get_field_name('bottom_sharing_alignment')) . '"><option value="right" ' . (! isset($instance['bottom_sharing_alignment']) || $instance['bottom_sharing_alignment'] == 'right' ? 'selected' : '') . '>' . __('right', 'super-socializer') . '</option><option value="left" ' . (isset($instance['bottom_sharing_alignment']) && $instance['bottom_sharing_alignment'] == 'left' ? 'selected' : '') . '>' . __('left', 'super-socializer') . '</option></select>') ?></label>
				<br/>

				<input type="radio" id="<?php echo esc_attr($this->get_field_id('bottom_sharing_position_radio_responsive')); ?>" <?php echo ! isset($instance['bottom_sharing_position_radio']) || $instance['bottom_sharing_position_radio'] == 'responsive' ? 'checked' : ''; ?> name="<?php echo esc_attr($this->get_field_name('bottom_sharing_position_radio')); ?>" value="responsive" /><label for="<?php echo esc_attr($this->get_field_id('bottom_sharing_position_radio_responsive')); ?>"><?php _e('Auto-adjust according to the screen-width (responsive)', 'super-socializer'); ?></label>
				<br>
				<br>
			</div>
			<label for="<?php echo esc_attr($this->get_field_id('size')); ?>"><?php _e('Size of icons', 'super-socializer'); ?></label> 
			<input style="width: 82%" class="widefat" id="<?php echo esc_attr($this->get_field_id('size')); ?>" name="<?php echo esc_attr($this->get_field_name('size')); ?>" type="text" value="<?php echo esc_attr($instance['size']); ?>" />pixels<br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('icon_shape')); ?>"><?php _e('Icon Shape', 'super-socializer'); ?></label> 
			<select style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('icon_shape')); ?>" name="<?php echo esc_attr($this->get_field_name('icon_shape')); ?>">
				<option value="round" <?php echo !isset($instance['icon_shape']) || $instance['icon_shape'] == 'round' ? 'selected' : '' ; ?>><?php _e('Round', 'super-socializer'); ?></option>
				<option value="square" <?php echo isset($instance['icon_shape']) && $instance['icon_shape'] == 'square' ? 'selected' : '' ; ?>><?php _e('Square', 'super-socializer'); ?></option>
			</select><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('custom_color')); ?>"><?php _e('Apply icon color and background color from Theme Selection section:', 'super-socializer'); ?></label> 
			<select style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('custom_color')); ?>" name="<?php echo esc_attr($this->get_field_name('custom_color')); ?>">
				<option value="" <?php echo ! isset($instance['custom_color']) || $instance['custom_color'] == '' ? 'selected' : '' ; ?>><?php _e('No', 'super-socializer'); ?></option>
				<option value="standard" <?php echo isset($instance['custom_color']) && $instance['custom_color'] == 'standard' ? 'selected' : '' ; ?>><?php _e('Yes, Standard Interface Theme', 'super-socializer'); ?></option>
				<option value="floating" <?php echo isset($instance['custom_color']) && $instance['custom_color'] == 'floating' ? 'selected' : '' ; ?>><?php _e('Yes, Floating Interface Theme', 'super-socializer'); ?></option>
			</select><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('facebook')); ?>"><?php _e('Facebook URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" type="text" value="<?php echo esc_attr($instance['facebook']); ?>" /><br/>
			<span>https://www.facebook.com/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php _e('Twitter URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" type="text" value="<?php echo esc_attr($instance['twitter']); ?>" /><br/>
			<span>https://twitter.com/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('parler')); ?>"><?php _e('Parler URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('parler')); ?>" name="<?php echo esc_attr($this->get_field_name('parler')); ?>" type="text" value="<?php echo esc_attr($instance['parler']); ?>" /><br/>
			<span>https://parler.com/profile/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('instagram')); ?>"><?php _e('Instagram URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram')); ?>" type="text" value="<?php echo esc_attr($instance['instagram']); ?>" /><br/>
			<span>https://www.instagram.com/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('pinterest')); ?>"><?php _e('Pinterest URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('pinterest')); ?>" name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>" type="text" value="<?php echo esc_attr($instance['pinterest']); ?>" /><br/>
			<span>https://www.pinterest.com/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('behance')); ?>"><?php _e('Behance URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('behance')); ?>" name="<?php echo esc_attr($this->get_field_name('behance')); ?>" type="text" value="<?php echo esc_attr($instance['behance']); ?>" /><br/>
			<span>https://www.behance.net/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('flickr')); ?>"><?php _e('Flickr URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr')); ?>" name="<?php echo esc_attr($this->get_field_name('flickr')); ?>" type="text" value="<?php echo esc_attr($instance['flickr']); ?>" /><br/>
			<span>https://www.flickr.com/photos/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('foursquare')); ?>"><?php _e('Foursquare URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('foursquare')); ?>" name="<?php echo esc_attr($this->get_field_name('foursquare')); ?>" type="text" value="<?php echo esc_attr($instance['foursquare']); ?>" /><br/>
			<span>https://foursquare.com/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('github')); ?>"><?php _e('Github URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('github')); ?>" name="<?php echo esc_attr($this->get_field_name('github')); ?>" type="text" value="<?php echo esc_attr($instance['github']); ?>" /><br/>
			<span>https://github.com/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"><?php _e('LinkedIn URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" type="text" value="<?php echo esc_attr($instance['linkedin']); ?>" /><br/>
			<span>https://www.linkedin.com/in/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('linkedin_company')); ?>"><?php _e('LinkedIn Company URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin_company')); ?>" name="<?php echo esc_attr($this->get_field_name('linkedin_company')); ?>" type="text" value="<?php echo esc_attr($instance['linkedin_company']); ?>" /><br/>
			<span>https://www.linkedin.com/company/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('medium')); ?>"><?php _e('Medium URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('medium')); ?>" name="<?php echo esc_attr($this->get_field_name('medium')); ?>" type="text" value="<?php echo esc_attr($instance['medium']); ?>" /><br/>
			<span>https://medium.com/@ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('mewe')); ?>"><?php _e('MeWe URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('mewe')); ?>" name="<?php echo esc_attr($this->get_field_name('mewe')); ?>" type="text" value="<?php echo esc_attr($instance['mewe']); ?>" /><br/>
			<span>https://mewe.com/profile/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('odnoklassniki'));	 ?>"><?php _e('Odnoklassniki URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('odnoklassniki')); ?>" name="<?php echo esc_attr($this->get_field_name('odnoklassniki')); ?>" type="text" value="<?php echo esc_attr($instance['odnoklassniki']); ?>" /><br/>
			<span>https://ok.ru/profile/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('snapchat')); ?>"><?php _e('Snapchat URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('snapchat')); ?>" name="<?php echo esc_attr($this->get_field_name('snapchat')); ?>" type="text" value="<?php echo esc_attr($instance['snapchat']); ?>" /><br/>
			<span>https://www.snapchat.com/add/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('telegram')); ?>"><?php _e('Telegram URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('telegram')); ?>" name="<?php echo esc_attr($this->get_field_name('telegram')); ?>" type="text" value="<?php echo esc_attr($instance['telegram']); ?>" /><br/>
			<span>https://t.me/username</span><br/><br/>
			<label for="<?php echo $this->get_field_id('threads'); ?>"><?php _e('Threads URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id('threads'); ?>" name="<?php echo $this->get_field_name('threads'); ?>" type="text" value="<?php echo $instance['threads']; ?>" /><br/>
			<span>https://www.threads.net/@ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id('tiktok'); ?>"><?php _e('TikTok URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id('tiktok'); ?>" name="<?php echo $this->get_field_name('tiktok'); ?>" type="text" value="<?php echo $instance['tiktok']; ?>" /><br/>
			<span>https://www.tiktok.com/@ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('tumblr')); ?>"><?php _e('Tumblr URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('tumblr')); ?>" name="<?php echo esc_attr($this->get_field_name('tumblr')); ?>" type="text" value="<?php echo esc_attr($instance['tumblr']); ?>" /><br/>
			<span>https://ID.tumblr.com</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('vimeo')); ?>"><?php _e('Vimeo URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('vimeo')); ?>" name="<?php echo esc_attr($this->get_field_name('vimeo')); ?>" type="text" value="<?php echo esc_attr($instance['vimeo']); ?>" /><br/>
			<span>https://vimeo.com/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('vkontakte')); ?>"><?php _e('Vkontakte URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('vkontakte')); ?>" name="<?php echo esc_attr($this->get_field_name('vkontakte')); ?>" type="text" value="<?php echo esc_attr($instance['vkontakte']); ?>" /><br/>
			<span>https://vk.com/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('whatsapp')); ?>"><?php _e('Whatsapp URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('whatsapp')); ?>" name="<?php echo esc_attr($this->get_field_name('whatsapp')); ?>" type="text" value="<?php echo esc_attr($instance['whatsapp'] ); ?>" /><br/>
			<span>https://wa.me/PHONE_NUMBER</span><br/><br/>
			<label for="<?php echo $this->get_field_id('x'); ?>"><?php _e('X URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id('x'); ?>" name="<?php echo $this->get_field_name('x'); ?>" type="text" value="<?php echo $instance['x']; ?>" /><br/>
			<span>https://x.com/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('xing')); ?>"><?php _e('Xing URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('xing')); ?>" name="<?php echo esc_attr($this->get_field_name('xing')); ?>" type="text" value="<?php echo esc_attr($instance['xing']); ?>" /><br/>
			<span>https://www.xing.com/profile/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('youtube')); ?>"><?php _e('Youtube URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('youtube')); ?>" name="<?php echo esc_attr($this->get_field_name('youtube')); ?>" type="text" value="<?php echo esc_attr($instance['youtube']); ?>" /><br/>
			<span>https://www.youtube.com/user/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('youtube_channel')); ?>"><?php _e('Youtube Channel URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('youtube_channel')); ?>" name="<?php echo esc_attr($this->get_field_name('youtube_channel')); ?>" type="text" value="<?php echo esc_attr($instance['youtube_channel']); ?>" /><br/>
			<span>https://www.youtube.com/channel/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('rss_feed')); ?>"><?php _e('RSS Feed URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('rss_feed')); ?>" name="<?php echo esc_attr($this->get_field_name('rss_feed')); ?>" type="text" value="<?php echo esc_attr($instance['rss_feed']); ?>" /><br/>
			<span>http://www.example.com/feed/</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('gab')); ?>"><?php _e('Gab.com URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('gab')); ?>" name="<?php echo esc_attr($this->get_field_name('gab')); ?>" type="text" value="<?php echo esc_attr($instance['gab']); ?>" /><br/>
			<span>https://gab.com/ID</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('gettr')); ?>"><?php _e('Gettr.com URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('gettr')); ?>" name="<?php echo esc_attr($this->get_field_name('gettr')); ?>" type="text" value="<?php echo esc_attr($instance['gettr']); ?>" /><br/>
			<span>https://www.gettr.com/user/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id('google_maps'); ?>"><?php _e('Google Maps URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id('google_maps'); ?>" name="<?php echo $this->get_field_name('google_maps'); ?>" type="text" value="<?php echo $instance['google_maps']; ?>" /><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('google_news')); ?>"><?php _e('Google News URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('google_news')); ?>" name="<?php echo esc_attr($this->get_field_name('google_news')); ?>" type="text" value="<?php echo esc_attr($instance['google_news'] ); ?>" /><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('yelp')); ?>"><?php _e('Yelp URL:', 'super-socializer'); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo esc_attr($this->get_field_id('yelp')); ?>" name="<?php echo esc_attr($this->get_field_name('yelp')); ?>" type="text" value="<?php echo esc_attr($instance['yelp'] ); ?>" /><br/>
			<span>https://www.yelp.com/biz/catskill-momos-delhi</span><br/><br/>
			<label for="<?php echo esc_attr($this->get_field_id('after_widget_content')); ?>"><?php _e('After widget content:', 'super-socializer'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('after_widget_content')); ?>" name="<?php echo esc_attr($this->get_field_name('after_widget_content')); ?>" type="text" value="<?php echo esc_attr($instance['after_widget_content']); ?>" /> 
		</p> 
<?php 
  } 
} 
add_action('widgets_init', function(){ return register_widget("TheChampFollowWidget" ); } ); 