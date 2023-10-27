<?php
/*
Plugin Name: Super Socializer
Plugin URI: https://super-socializer-wordpress.heateor.com
Description: A complete 360 degree solution to provide all the social features like Social Login, Social Commenting, Social Sharing, Social Media follow and more
Version: 7.13.59
Author: Team Heateor
Author URI: https://www.heateor.com
Text Domain: super-socializer
Domain Path: /languages
License: GPL2+
*/
defined('ABSPATH') or die("Cheating........Uh!!");
define('THE_CHAMP_SS_VERSION', '7.13.59');

// attributes to allow in the HTML of the social share and social media follow icons
$heateorSsDefaultAttribs = array(
    'id' => array(),
    'class' => array(),
    'title' => array(),
    'style' => array(),
    'data' => array(),
    'focusable' => array(),
    'width' => array(),
    'height' => array(),
    'opacity' => array(),
    'data-super-socializer-href' => array(),
    'data-super-socializer-no-counts' => array(),
    'data-heateor-ss-offset' => array(),
    'data-heateor-ss-st-count' => array()
);

// tags to allow in the HTML of the social share and social media follow icons
$heateorSsAllowedTags = array(
    'div'           => array_merge($heateorSsDefaultAttribs, array(
        'data-href' => array(),
        'data-layout' => array(),
        'data-action' => array(),
        'data-show-faces' => array(),
        'data-share' => array(),
        'onClick' => array(),
        'onclick' => array(),
        'alt' => array(),
    ) ),
    'span'          => array_merge($heateorSsDefaultAttribs, array(
        'onClick' => array(),
        'onclick' => array(),
    ) ),
    'p'             => $heateorSsDefaultAttribs,
    'a'             => array_merge($heateorSsDefaultAttribs, array(
        'href' => array( 'Javascript:void(0)', 'javascript:void(0)'),
        'onClick' => array(),
        'onclick' => array(),
        'target' => array( '_blank', '_top'),
        'rel' => array(),
        'data-url' => array(),
        'data-counturl' => array(),
        'data-text' => array(),
        'data-via' => array(),
        'data-lang' => array(),
    ) ),
    'svg'           => array_merge($heateorSsDefaultAttribs, array(
        'viewBox' => array(),
        'viewbox' => array(),
        'aria-hidden' => array(),
        'xmlns' => array(),
        'xml:space' => array(),
        'version' => array(),
        'xmlns:xlink' => array(),
    ) ),
    'script'           => array_merge($heateorSsDefaultAttribs, array(
        'src' => array(),
        'type' => array(),
        'data-url' => array(),
        'data-counter' => array(),
        'async' => array(),
    ) ),
    'u'             => $heateorSsDefaultAttribs,
    'input'         => array_merge($heateorSsDefaultAttribs, array(
        'type'  => array(),
        'value' => array(),
        'onclick' => array(),
        'onClick' => array(),
    ) ),
    'i'             => array_merge($heateorSsDefaultAttribs, array(
        'alt'     => array(),
        'onclick' => array(),
        'onClick' => array(),
    ) ),
    'ss'            => $heateorSsDefaultAttribs,
    'q'             => $heateorSsDefaultAttribs,
    'label'         => $heateorSsDefaultAttribs,
    'b'             => $heateorSsDefaultAttribs,
    'ul'            => $heateorSsDefaultAttribs,
    'ol'            => $heateorSsDefaultAttribs,
    'li'             => array_merge($heateorSsDefaultAttribs, array(
        'alt'     => array(),
        'onclick' => array(),
        'onClick' => array(),
    ) ),
    'br'            => $heateorSsDefaultAttribs,
    'hr'            => $heateorSsDefaultAttribs,
    'strong'        => $heateorSsDefaultAttribs,
    'blockquote'    => $heateorSsDefaultAttribs,
    'del'           => $heateorSsDefaultAttribs,
    'strike'        => $heateorSsDefaultAttribs,
    'em'            => $heateorSsDefaultAttribs,
    'code'          => $heateorSsDefaultAttribs,
    'table'         => $heateorSsDefaultAttribs,
    'tr'            => $heateorSsDefaultAttribs,
    'td'            => array_merge($heateorSsDefaultAttribs, array(
        'colspan' => array(),
    ) ),
    'tbody'         => $heateorSsDefaultAttribs,
    'path'          => array_merge($heateorSsDefaultAttribs, array(
        'stroke-width' => array(),
        'stroke'  => array(),
        'fill' => array(),
        'd' => array()
    ) ),
    'circle'        => array_merge($heateorSsDefaultAttribs, array(
        'stroke-width' => array(),
        'stroke'  => array(),
        'fill' => array(),
        'cx' => array(),
        'cy' => array(),
        'r' => array()
    ) ),
    'polygon'        => array_merge($heateorSsDefaultAttribs, array(
        'stroke-width' => array(),
        'stroke'  => array(),
        'fill' => array(),
        'points' => array()
    ) ),
    'g'          => array_merge($heateorSsDefaultAttribs, array(
        'stroke-width' => array(),
        'stroke'  => array(),
        'stroke-linecap' => array(),
        'stroke-miterlimit' => array(),
        'fill' => array(),
        'fill' => array(),
        'fill' => array(),
        'fill' => array(),
    ) ),
    'style'          => array_merge($heateorSsDefaultAttribs, array(
        'type' => array(),
    ) )
);

require 'helper.php';

$theChampLoginOptions = get_option('the_champ_login');
if(the_champ_social_login_enabled()){
	if(isset($theChampLoginOptions['providers']) && in_array('x', $theChampLoginOptions['providers']) && !class_exists('Abraham\TwitterOAuth\Config')){
		require 'library/Twitter/src/Config.php';
		require 'library/Twitter/src/Response.php';
		require 'library/Twitter/src/SignatureMethod.php';
		require 'library/Twitter/src/HmacSha1.php';
		require 'library/Twitter/src/Consumer.php';
		require 'library/Twitter/src/Util.php';
		require 'library/Twitter/src/Request.php';
		require 'library/Twitter/src/TwitterOAuthException.php';
		require 'library/Twitter/src/Token.php';
		require 'library/Twitter/src/Util/JsonDecoder.php';
		require 'library/Twitter/src/TwitterOAuth.php';
	}
	if(isset($theChampLoginOptions['providers']) && in_array('steam', $theChampLoginOptions['providers']) && !interface_exists('SteamLoginInterface')){
		require 'library/SteamLogin/SteamLogin.php';
		$theChampSteamLogin = new SteamLogin();
	}
}

$theChampFacebookOptions = get_option('the_champ_facebook');
$theChampSharingOptions = get_option('the_champ_sharing');
$theChampCounterOptions = get_option('the_champ_counter');
$theChampGeneralOptions = get_option('the_champ_general');

$theChampIsBpActive = false;

// include social login functions
require 'inc/social_login.php';

// include social sharing functions
if(the_champ_social_sharing_enabled() || the_champ_social_counter_enabled()){
	require 'inc/social_sharing_networks.php';
	require 'inc/social_sharing.php';
}
//include widget class
require 'inc/widget.php';
//include shortcode
require 'inc/shortcode.php';

/**
 * Check if cURL is enabled
 */
function heateor_ss_is_curl_loaded(){
    return extension_loaded( 'curl');
}

/**
 * Hook the plugin function on 'init' event.
 */
function the_champ_init(){
	global $theChampSharingOptions;
	add_action('wp_enqueue_scripts', 'the_champ_load_event');
	add_action('wp_enqueue_scripts', 'the_champ_frontend_scripts');
	add_action('wp_enqueue_scripts', 'the_champ_frontend_styles');
	add_action('login_enqueue_scripts', 'the_champ_load_event');
	add_action('login_enqueue_scripts', 'the_champ_frontend_scripts');
	add_action('login_enqueue_scripts', 'the_champ_frontend_styles');
	add_action('parse_request', 'the_champ_connect');
	load_plugin_textdomain('super-socializer', false, dirname(plugin_basename(__FILE__)).'/languages/');
	if(heateor_ss_is_plugin_active('woocommerce/woocommerce.php')){
		add_action('the_champ_user_successfully_created', 'the_champ_sync_woocom_profile', 10, 3);
	}
	if(isset($theChampSharingOptions['amp_enable']) && function_exists('is_amp_endpoint')){
		// Standard and Transitional modes
		add_action('wp_print_styles', 'the_champ_frontend_amp_css');

		//  Reader mode
		add_action('amp_post_template_css', 'the_champ_frontend_amp_css');
	}
}
add_action('init', 'the_champ_init');

/**
 * Sync social profile data with WooCommerce billing and shipping address
 */
function the_champ_sync_woocom_profile($userId, $userdata, $profileData){
	$billingFirstName = get_user_meta($userId, 'billing_first_name', true);
	$billingLastName = get_user_meta($userId, 'billing_last_name', true);
	$billingEmail = get_user_meta($userId, 'billing_email', true);
	
	$shippingFirstName = get_user_meta($userId, 'shipping_first_name', true);
	$shippingLastName = get_user_meta($userId, 'shipping_last_name', true);
	$shippingEmail = get_user_meta($userId, 'shipping_email', true);

	// create username, firstname and lastname
	$usernameFirstnameLastname = explode('|tc|', the_champ_create_username($profileData));
	$username = $usernameFirstnameLastname[0];
	$firstName = $usernameFirstnameLastname[1];
	$lastName = $usernameFirstnameLastname[2];
	

	if($firstName || $username){
		if(!$billingFirstName){
			update_user_meta($userId, 'billing_first_name', $firstName ? $firstName : $username);
		}
		if(!$shippingFirstName){
			update_user_meta($userId, 'shipping_first_name', $firstName ? $firstName : $username);
		}
	}
	if($lastName){
		if(!$billingLastName){
			update_user_meta($userId, 'billing_last_name', $lastName);
		}
		if(!$shippingLastName){
			update_user_meta($userId, 'shipping_last_name', $lastName);
		}
	}
	if(!empty($profileData['email'])){
		if(!$billingEmail){
			update_user_meta($userId, 'billing_email', $profileData['email']);
		}
		if(!$shippingEmail){
			update_user_meta($userId, 'shipping_email', $profileData['email']);
		}
	}
}

function the_champ_load_event(){
	?>
	<script type="text/javascript">function theChampLoadEvent(e){var t=window.onload;if(typeof window.onload!="function"){window.onload=e}else{window.onload=function(){t();e()}}}</script>
	<?php
}

/**
 * Check querystring variables
 */
function the_champ_connect(){
	global $theChampLoginOptions;

	// verify email
	if((isset($_GET['SuperSocializerKey']) && ($verificationKey = sanitize_text_field($_GET['SuperSocializerKey'])) != '') || (isset($_GET['supersocializerkey']) && ($verificationKey = sanitize_text_field($_GET['supersocializerkey'])) != '')){
		$users = get_users('meta_key=thechamp_key&meta_value='.$verificationKey);
		if(count($users) > 0 && isset($users[0]->ID)){
			delete_user_meta($users[0]->ID, 'thechamp_key');
			wp_redirect(esc_url(home_url()).'?SuperSocializerVerified=1');
			die;
		}
	}

	// return if social login is disabled
	if(!isset($theChampLoginOptions['enable'])){
		return;
	}

	if(isset($_GET['SuperSocializerAuth'])){
		if(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Vkontakte'){
			if(isset($theChampLoginOptions['providers']) && in_array('vkontakte', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['vk_key']) && $theChampLoginOptions['vk_key'] != '' && isset($theChampLoginOptions['vk_secure_key']) && $theChampLoginOptions['vk_secure_key'] != ''){
				if(function_exists('session_start')){
					if(session_status() == PHP_SESSION_NONE){
						session_start();
					}
				}
				require 'library/Vkontakte/Vkontakte.php';
				$heateorSsVkontakte = new Vkontakte(array(
				    'client_id' => $theChampLoginOptions['vk_key'],
				    'client_secret' => $theChampLoginOptions['vk_secure_key'],
				    'redirect_uri' => home_url()
				));
				$heateorSsVkontakte->setScope(array('email'));

				$_SESSION['super_socializer_vkontakte_redirect'] = isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url();
				wp_redirect($heateorSsVkontakte->getLoginUrl());
				die;
			}
			// Instagram 
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Instagram'){
			if(isset($theChampLoginOptions['providers']) && in_array('instagram', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['insta_id']) && $theChampLoginOptions['insta_id'] != '' && isset($theChampLoginOptions['insta_app_secret']) && $theChampLoginOptions['insta_app_secret'] != ''){
				$instagramLoginState = mt_rand();
				// save referrer url in state
				update_user_meta($instagramLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				wp_redirect("https://api.instagram.com/oauth/authorize?client_id=".$theChampLoginOptions['insta_id']."&scope=user_profile,user_media&response_type=code&language=en-us&state=".$instagramLoginState."&redirect_uri=".urlencode(home_url()."/SuperSocializerAuth/Instagram"));
				die;
			}
			// Steam auth
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Linkedin'){
			if(isset($theChampLoginOptions['li_key']) && $theChampLoginOptions['li_key'] != '' && isset($theChampLoginOptions['li_secret']) && $theChampLoginOptions['li_secret'] != ''){
				if(!isset($_GET['code']) && !isset($_GET['state'])){
					$linkedinAuthState = mt_rand();
					// save referrer url in state
					update_user_meta($linkedinAuthState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url() );
	                if(isset($_GET['heateorMSEnabled'])){
	                	update_user_meta($linkedinAuthState, 'heateor_ss_linkedin_mc_sub', 1);
	                }
				    if($theChampLoginOptions['linkedin_login_type'] == 'oauth'){
	                	$linkedinScope = 'r_liteprofile,r_emailaddress';
	                }else{
	                	$linkedinScope = 'openid,profile,email';
	                }
				    wp_redirect('https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id='.$theChampLoginOptions['li_key'].'&redirect_uri='.urlencode(home_url().'/?SuperSocializerAuth=Linkedin').'&state='. $linkedinAuthState .'&scope='.$linkedinScope);
				    die;
				}
				if(isset($_GET['code']) && isset($_GET['state']) && get_user_meta(sanitize_text_field($_GET['state']), 'super_socializer_redirect_to', true) !== false){
				    $url = 'https://www.linkedin.com/oauth/v2/accessToken';
					$data_access_token = array(
						'grant_type' => 'authorization_code',
						'code' => sanitize_text_field($_GET['code']),
						'redirect_uri' => home_url().'/?SuperSocializerAuth=Linkedin',
						'client_id' => $theChampLoginOptions['li_key'],
						'client_secret' => $theChampLoginOptions['li_secret']
					);
					$response = wp_remote_post($url, array(
						'method' => 'POST',
						'timeout' => 15,
						'redirection' => 5,
						'httpversion' => '1.0',
						'sslverify' => false,
						'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
						'body' => http_build_query($data_access_token)
					    )
					);
					if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
						$body = json_decode(wp_remote_retrieve_body($response));
						if(is_object($body) && isset($body->access_token)){
							if($theChampLoginOptions['linkedin_login_type'] == 'oauth'){
								// fetch profile data
								$firstLastName = wp_remote_get('https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams))', array(
										'method' => 'GET',
										'timeout' => 15,
										'headers' => array('Authorization' => "Bearer ".$body->access_token),
								    )
								);
								$email = wp_remote_get('https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))', array(
										'method' => 'GET',
										'timeout' => 15,
										'headers' => array('Authorization' => "Bearer ".$body->access_token),
								    )
								);
								if(!is_wp_error($firstLastName) && isset($firstLastName['response']['code']) && 200 === $firstLastName['response']['code'] && !is_wp_error($email) && isset($email['response']['code']) && 200 === $email['response']['code']){
									$firstLastNameBody = json_decode(wp_remote_retrieve_body($firstLastName));
									$emailBody = json_decode(wp_remote_retrieve_body($email));
									if(is_object($firstLastNameBody) && isset($firstLastNameBody->id) && $firstLastNameBody->id && is_object($emailBody) && isset($emailBody->elements)){
										$firstLastNameBody = json_decode(json_encode($firstLastNameBody), true);
										$emailBody = json_decode(json_encode($emailBody), true);
										$firstName = isset($firstLastNameBody['firstName']) && isset($firstLastNameBody['firstName']['localized']) && isset($firstLastNameBody['firstName']['preferredLocale']) && isset($firstLastNameBody['firstName']['preferredLocale']['language']) && isset($firstLastNameBody['firstName']['preferredLocale']['country']) ? $firstLastNameBody['firstName']['localized'][$firstLastNameBody['firstName']['preferredLocale']['language'].'_'.$firstLastNameBody['firstName']['preferredLocale']['country']] : '';
										$lastName = isset($firstLastNameBody['lastName']) && isset($firstLastNameBody['lastName']['localized']) && isset($firstLastNameBody['lastName']['preferredLocale']) && isset($firstLastNameBody['lastName']['preferredLocale']['language']) && isset($firstLastNameBody['lastName']['preferredLocale']['country']) ? $firstLastNameBody['lastName']['localized'][$firstLastNameBody['lastName']['preferredLocale']['language'].'_'.$firstLastNameBody['lastName']['preferredLocale']['country']] : '';
										$smallAvatar = isset($firstLastNameBody['profilePicture']) && isset($firstLastNameBody['profilePicture']['displayImage~']) && isset($firstLastNameBody['profilePicture']['displayImage~']['elements']) && is_array($firstLastNameBody['profilePicture']['displayImage~']['elements']) && isset($firstLastNameBody['profilePicture']['displayImage~']['elements'][0]['identifiers']) && is_array($firstLastNameBody['profilePicture']['displayImage~']['elements'][0]['identifiers'][0]) && isset($firstLastNameBody['profilePicture']['displayImage~']['elements'][0]['identifiers'][0]['identifier']) ? $firstLastNameBody['profilePicture']['displayImage~']['elements'][0]['identifiers'][0]['identifier'] : '';
										$largeAvatar = isset($firstLastNameBody['profilePicture']) && isset($firstLastNameBody['profilePicture']['displayImage~']) && isset($firstLastNameBody['profilePicture']['displayImage~']['elements']) && is_array($firstLastNameBody['profilePicture']['displayImage~']['elements']) && isset($firstLastNameBody['profilePicture']['displayImage~']['elements'][3]['identifiers']) && is_array($firstLastNameBody['profilePicture']['displayImage~']['elements'][3]['identifiers'][0]) && isset($firstLastNameBody['profilePicture']['displayImage~']['elements'][3]['identifiers'][0]['identifier']) ? $firstLastNameBody['profilePicture']['displayImage~']['elements'][3]['identifiers'][0]['identifier'] : '';
				                     	$emailAddress = isset($emailBody['elements']) && is_array($emailBody['elements']) && isset($emailBody['elements'][0]['handle~']) && isset($emailBody['elements'][0]['handle~']['emailAddress']) ? $emailBody['elements'][0]['handle~']['emailAddress'] : '';
				                     	$user = array(
				                     		'firstName' => $firstName,
				                     		'lastName' => $lastName,
				                     		'email' => $emailAddress,
				                     		'id' => $firstLastNameBody['id'],
				                     		'smallAvatar' => $smallAvatar,
				                     		'largeAvatar' => $largeAvatar
				                     	);
									}
								}
							}else{
								$profileData = wp_remote_get('https://api.linkedin.com/v2/userinfo', array(
										'method' => 'GET',
										'timeout' => 15,
										'headers' => array('Authorization' => "Bearer " . $body->access_token),
								    )
								);
								$user = '';
								if(!is_wp_error($profileData) && isset($profileData['response']['code']) && 200 === $profileData['response']['code']){
									$profileDataBody = json_decode(wp_remote_retrieve_body($profileData));
									if(is_object($profileDataBody) && isset($profileDataBody->sub) && $profileDataBody->sub){
										$user = $profileDataBody;
									}
								}
							}
			                     	
							$profileData = the_champ_sanitize_profile_data($user, 'linkedin');
							$linkedinAuthState = sanitize_text_field($_GET['state']);
							if(get_user_meta($linkedinAuthState, 'heateor_ss_linkedin_mc_sub', true)){
								$profileData['mc_subscribe'] = 1;
								delete_user_meta($linkedinAuthState, 'heateor_ss_linkedin_mc_sub');
							}
							$linkedinRedirectUrl = get_user_meta($linkedinAuthState, 'super_socializer_redirect_to', true);
							$response = the_champ_user_auth($profileData, 'linkedin', $linkedinRedirectUrl);
							if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
								$redirectTo = the_champ_get_login_redirection_url($linkedinRedirectUrl, true);
							}elseif(isset($response['message']) && $response['message'] == 'linked'){
								$redirectTo = $linkedinRedirectUrl.(strpos($linkedinRedirectUrl, '?') !== false ? '&' : '?').'linked=1';
							}elseif(isset($response['message']) && $response['message'] == 'not linked'){
								$redirectTo = $linkedinRedirectUrl.(strpos($linkedinRedirectUrl, '?') !== false ? '&' : '?').'linked=0';
							}elseif(isset($response['url']) && $response['url'] != ''){
								$redirectTo = $response['url'];
							}else{
								$redirectTo = the_champ_get_login_redirection_url($linkedinRedirectUrl);
							}
							the_champ_close_login_popup($redirectTo);
						}
					}
				}
			}
			// line
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Line'){ 
			if(isset($theChampLoginOptions['providers']) && in_array('line', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['line_channel_id']) && $theChampLoginOptions['line_channel_id'] != '' && isset($theChampLoginOptions['line_channel_secret']) && $theChampLoginOptions['line_channel_secret'] != ''){
				if(!isset($_GET['code'])){
					$lineLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($lineLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://access.line.me/oauth2/v2.1/authorize?client_id=".$theChampLoginOptions['line_channel_id']."&response_type=code&scope=profile%20openid%20email&state=". $lineLoginState ."&redirect_uri=".urlencode(home_url()."/SuperSocializerAuth/Line"));
				die;
			}
			// mail.ru
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Mailru'){
			if(isset($theChampLoginOptions['providers']) && in_array('mailru', $theChampLoginOptions['providers']) && $theChampLoginOptions['mailru_client_id'] && $theChampLoginOptions['mailru_client_secret']){
				if(!heateor_ss_is_curl_loaded()){
					_e('Enable CURL at your website server to use Mail.ru Social Login.', 'super-socializer');
			    	die;
				}
				if(!isset($_GET['code'])){
					$mailruLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($mailruLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://oauth.mail.ru/login?client_id=". $theChampLoginOptions['mailru_client_id'] ."&scope=userinfo&state=". $mailruLoginState ."&response_type=code&redirect_uri=". home_url() ."/SuperSocializerAuth/Mailru");
				die;
			}
			// yahoo
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Yahoo'){
			if(isset($theChampLoginOptions['providers']) && in_array('yahoo', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['yahoo_channel_id']) && $theChampLoginOptions['yahoo_channel_id'] != '' && isset($theChampLoginOptions['yahoo_channel_secret']) && $theChampLoginOptions['yahoo_channel_secret'] != ''){
				if(!isset($_GET['code'])){
					$yahooLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($yahooLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://api.login.yahoo.com/oauth2/request_auth?client_id=".$theChampLoginOptions['yahoo_channel_id']."&response_type=code&language=en-us&state=".$yahooLoginState."&redirect_uri=".home_url()."/SuperSocializerAuth/Yahoo");
				die;
			}
			// Discord
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Discord'){
			if(isset($theChampLoginOptions['providers']) && in_array('discord', $theChampLoginOptions['providers']) && $theChampLoginOptions['discord_channel_id'] && $theChampLoginOptions['discord_channel_secret']){
				if(!isset($_GET['code'])){
					$discordLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($discordLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://discord.com/oauth2/authorize/request_auth?client_id=".$theChampLoginOptions['discord_channel_id']."&response_type=code&state=".$discordLoginState."&scope=identify%20email&redirect_uri=".home_url()."/SuperSocializerAuth/Discord");
				die;
			}
			// Wordpress
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Wordpress'){
			if(isset($theChampLoginOptions['providers']) && in_array('wordpress', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['wordpress_client_id']) && $theChampLoginOptions['wordpress_client_id'] != '' && isset($theChampLoginOptions['wordpress_client_secret']) && $theChampLoginOptions['wordpress_client_secret'] != ''){
				if(!isset($_GET['code'])){
					$wordpressLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($wordpressLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://public-api.wordpress.com/oauth2/authorize?client_id=".$theChampLoginOptions['wordpress_client_id']."&scope=auth&response_type=code&state=".$wordpressLoginState."&redirect_uri=".home_url()."/SuperSocializerAuth/Wordpress");
				die;
			}
			// windows live
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Live'){
			if(isset($theChampLoginOptions['providers']) && in_array('microsoft', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['live_channel_id']) && $theChampLoginOptions['live_channel_id'] != '' && isset($theChampLoginOptions['live_channel_secret']) && $theChampLoginOptions['live_channel_secret'] != ''){
				$liveLoginState = mt_rand();
				// save referrer url in state
				update_user_meta($liveLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				wp_redirect("https://login.live.com/oauth20_authorize.srf?client_id=".$theChampLoginOptions['live_channel_id']."&scope=wl.emails,wl.basic&response_type=code&state=".$liveLoginState."&redirect_uri=".home_url()."/SuperSocializerAuth/Live");
				die;
			}
			// twitch
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Twitch'){ 
			if(isset($theChampLoginOptions['providers']) && in_array('twitch', $theChampLoginOptions['providers']) && $theChampLoginOptions['twitch_client_id'] && $theChampLoginOptions['twitch_client_secret']){
				if(!isset($_GET['code'])){
					$twitchLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($twitchLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://id.twitch.tv/oauth2/authorize?client_id=".$theChampLoginOptions['twitch_client_id']."&scope=user:read:email&response_type=code&state=".$twitchLoginState."&redirect_uri=".urlencode(home_url()."/SuperSocializerAuth/Twitch"));
				die;
			}
			// reddit
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Reddit'){
		    if(isset($theChampLoginOptions['providers']) && in_array('reddit', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['reddit_client_id']) && $theChampLoginOptions['reddit_client_id'] != '' && isset($theChampLoginOptions['reddit_client_secret']) && $theChampLoginOptions['reddit_client_secret'] != ''){
		        $redditLoginState = mt_rand();
				// save referrer url in state
				update_user_meta($redditLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
		        wp_redirect("https://ssl.reddit.com/api/v1/authorize?client_id=" . $theChampLoginOptions['reddit_client_id'] . "&scope=identity&state=" . $redditLoginState . "&duration=temporary&response_type=code&redirect_uri=" . home_url() . "/SuperSocializerAuth/Reddit");
		        die;
		    }
		    //disqus
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Disqus'){
		    if(isset($theChampLoginOptions['providers']) && in_array('disqus', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['disqus_public_key']) && $theChampLoginOptions['disqus_public_key'] != '' && isset($theChampLoginOptions['disqus_secret_key']) && $theChampLoginOptions['disqus_secret_key'] != ''){
		        $disqusLoginState = mt_rand();
				// save referrer url in state
				update_user_meta($disqusLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
		        wp_redirect("https://disqus.com/api/oauth/2.0/authorize/?client_id=" . $theChampLoginOptions['disqus_public_key'] . "&scope=read,email&response_type=code&state=". $disqusLoginState ."&redirect_uri=" . home_url() . "/SuperSocializerAuth/Disqus");
		        die;
		    }
		    // dropbox
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Dropbox'){
		    if(isset($theChampLoginOptions['providers']) && in_array('dropbox', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['dropbox_app_key']) && $theChampLoginOptions['dropbox_app_key'] != '' && isset($theChampLoginOptions['dropbox_app_secret']) && $theChampLoginOptions['dropbox_app_secret'] != ''){
		    	$dropboxLoginState = mt_rand();
				// save referrer url in state
				update_user_meta($dropboxLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
		        wp_redirect("https://www.dropbox.com/1/oauth2/authorize?client_id=" . $theChampLoginOptions['dropbox_app_key'] . "&scope=account_info.read&state=" . $dropboxLoginState . "&response_type=code&redirect_uri=" . home_url() . "/SuperSocializerAuth/Dropbox");
		        die;
		    }
		    // foursquare
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Foursquare'){
		    if(isset($theChampLoginOptions['providers']) && in_array('foursquare', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['foursquare_client_id']) && $theChampLoginOptions['foursquare_client_id'] != '' && isset($theChampLoginOptions['foursquare_client_secret']) && $theChampLoginOptions['foursquare_client_secret'] != ''){
		        $foursquareLoginState = mt_rand();
				// save referrer url in state
				update_user_meta($foursquareLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
		        wp_redirect("https://foursquare.com/oauth2/authenticate/?client_id=" . $theChampLoginOptions['foursquare_client_id'] . "&response_type=code&state=". $foursquareLoginState ."&redirect_uri=" . home_url() . "/SuperSocializerAuth/Foursquare");
		        die;
		    }
		    // odnoklassniki
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Odnoklassniki'){ 
			if(isset($theChampLoginOptions['providers']) && in_array('odnoklassniki', $theChampLoginOptions['providers']) && $theChampLoginOptions['odnoklassniki_client_id'] && $theChampLoginOptions['odnoklassniki_client_secret']){
				if(!isset($_GET['code'])){
					$odnoklassnikiLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($odnoklassnikiLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://connect.ok.ru/oauth/authorize?client_id=" . $theChampLoginOptions['odnoklassniki_client_id'] . "&scope=GET_EMAIL%20PHOTO_CONTENT&response_type=code&state=" . $odnoklassnikiLoginState . "&redirect_uri=" . urlencode(home_url()."/SuperSocializerAuth/Odnoklassniki"));
				die;
			}
			// Dribbble
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Dribbble'){ 
			if(isset($theChampLoginOptions['providers']) && in_array('dribbble', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['dribbble_client_id']) && $theChampLoginOptions['dribbble_client_id'] != '' && isset($theChampLoginOptions['dribbble_client_secret']) && $theChampLoginOptions['dribbble_client_secret'] != ''){
				if(!isset($_GET['code'])){
					$dribbbleLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($dribbbleLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://dribbble.com/oauth/authorize?client_id=".$theChampLoginOptions['dribbble_client_id']."&scope=public&state=". $dribbbleLoginState ."&redirect_uri=".urlencode(home_url()."/SuperSocializerAuth/Dribbble"));
				die;
			}
			// Spotify
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Spotify'){
			if(isset($theChampLoginOptions['providers']) && in_array('spotify', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['spotify_client_id']) && $theChampLoginOptions['spotify_client_id'] != '' && isset($theChampLoginOptions['spotify_client_secret']) && $theChampLoginOptions['spotify_client_secret'] != ''){
				if(!isset($_GET['code'])){
					$spotifyLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($spotifyLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://accounts.spotify.com/authorize?client_id=".$theChampLoginOptions['spotify_client_id']."&scope=user-read-email&response_type=code&state=". $spotifyLoginState ."&redirect_uri=".home_url()."/SuperSocializerAuth/Spotify");
				die;
			}
			// kakao
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Kakao'){
			if(isset($theChampLoginOptions['providers']) && in_array('kakao', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['kakao_client_id']) && $theChampLoginOptions['kakao_client_id'] != '' && isset($theChampLoginOptions['kakao_client_secret']) && $theChampLoginOptions['kakao_client_secret'] != ''){
				if(!isset($_GET['code'])){
					$kakaoLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($kakaoLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://kauth.kakao.com/oauth/authorize?client_id=".$theChampLoginOptions['kakao_client_id']."&response_type=code&state=". $kakaoLoginState ."&redirect_uri=".home_url()."/SuperSocializerAuth/Kakao");
				die;
			}
			// yandex
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Yandex'){ 
			if(isset($theChampLoginOptions['providers']) && in_array('yandex', $theChampLoginOptions['providers']) && $theChampLoginOptions['yandex_client_id'] && $theChampLoginOptions['yandex_client_secret']){
				if(!isset($_GET['code'])){
					$yandexLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($yandexLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://oauth.yandex.ru/authorize?client_id=" . $theChampLoginOptions['yandex_client_id'] . "&response_type=code&state=" . $yandexLoginState . "&redirect_uri=".urlencode(home_url() . "/SuperSocializerAuth/Yandex"));
				die;
			}
			// Github
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Github'){
			if(isset($theChampLoginOptions['providers']) && in_array('github', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['github_client_id']) && $theChampLoginOptions['github_client_id'] != '' && isset($theChampLoginOptions['github_client_secret']) && $theChampLoginOptions['github_client_secret'] != ''){
				if(!isset($_GET['code'])){
					$githubLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($githubLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://github.com/login/oauth/authorize?client_id=".$theChampLoginOptions['github_client_id']."&scope=read:user user:email&state=". $githubLoginState ."&response_type=code&redirect_uri=".home_url()."/SuperSocializerAuth/Github");
				die;
			}
			// amazon
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Amazon'){ 
			if(isset($theChampLoginOptions['providers']) && in_array('amazon', $theChampLoginOptions['providers']) && $theChampLoginOptions['amazon_client_id'] && $theChampLoginOptions['amazon_client_secret']){
		        if(!isset($_GET['code'])){
					$amazonLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($amazonLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://www.amazon.com/ap/oa?client_id=".$theChampLoginOptions['amazon_client_id']."&response_type=code&scope=profile&state=".$amazonLoginState."&redirect_uri=".urlencode(home_url()."/SuperSocializerAuth/Amazon"));
				die;
			}
			// Stack Overflow
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Stackoverflow'){ 
			if(isset($theChampLoginOptions['providers']) && in_array('stackoverflow', $theChampLoginOptions['providers']) && $theChampLoginOptions['stackoverflow_client_id'] && $theChampLoginOptions['stackoverflow_client_secret'] && $theChampLoginOptions['stackoverflow_key']){
				if(!isset($_GET['code'])){
					$stackoverflowLoginState = mt_rand();
					// save referrer url in state
					update_user_meta($stackoverflowLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				}
				wp_redirect("https://stackexchange.com/oauth?client_id=".$theChampLoginOptions['stackoverflow_client_id']."&response_type=code&scope=private_info&state=".$stackoverflowLoginState."&redirect_uri=".urlencode(home_url()."/SuperSocializerAuth/Stackoverflow"));
				die;
			}
			// Google
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Google'){
		    if(isset($theChampLoginOptions['providers']) && (in_array('google', $theChampLoginOptions['providers']) || in_array('youtube', $theChampLoginOptions['providers'])) && isset($theChampLoginOptions['google_key']) && $theChampLoginOptions['google_key'] != '' && isset($theChampLoginOptions['google_secret']) && $theChampLoginOptions['google_secret'] != ''){
		        $googleLoginState = mt_rand();
	            // save referrer url in state
	            update_user_meta($googleLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
	            update_user_meta($googleLoginState, 'super_socializer_temp_network', 'Google');
		        wp_redirect("https://accounts.google.com/o/oauth2/auth?client_id=" . $theChampLoginOptions['google_key'] . "&scope=https://www.googleapis.com/auth/userinfo.email%20https://www.googleapis.com/auth/userinfo.profile&state=". $googleLoginState ."&response_type=code&prompt=select_account&redirect_uri=" . home_url());
		        die;
		    }
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Youtube'){
		    if(isset($theChampLoginOptions['providers']) && in_array('youtube', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['youtube_key']) && $theChampLoginOptions['youtube_key'] != '' && isset($theChampLoginOptions['google_key']) && $theChampLoginOptions['google_key'] != '' && isset($theChampLoginOptions['google_secret']) && $theChampLoginOptions['google_secret'] != ''){
		        $youtubeLoginState = mt_rand();
	            // save referrer url in state
	            update_user_meta($youtubeLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
	            update_user_meta($youtubeLoginState, 'super_socializer_temp_network', 'Youtube');
	            wp_redirect("https://accounts.google.com/o/oauth2/auth?client_id=" . $theChampLoginOptions['google_key'] . "&scope=https://www.googleapis.com/auth/userinfo.email%20https://www.googleapis.com/auth/youtube.readonly&state=". $youtubeLoginState ."&response_type=code&prompt=select_account&redirect_uri=" . home_url());
		        die;
		    }
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Twitter' && !isset($_REQUEST['oauth_token'])){
			if(isset($theChampLoginOptions['twitter_key']) && $theChampLoginOptions['twitter_key'] != '' && isset($theChampLoginOptions['twitter_secret']) && $theChampLoginOptions['twitter_secret'] != ''){
				if(!function_exists('curl_init')){
					?>
					<div style="width: 500px; margin: 0 auto">
					<?php _e('cURL is not enabled at your website server. Please contact your website server administrator to enable it.', 'super-socializer') ?>
					</div>
					<?php
					die;
				}
				/* Build TwitterOAuth object with client credentials. */
				$connection = new Abraham\TwitterOAuth\TwitterOAuth($theChampLoginOptions['twitter_key'], $theChampLoginOptions['twitter_secret']);
				$requestToken = $connection->oauth('oauth/request_token', ['oauth_callback' => esc_url(home_url())]);
				if(isset($requestToken->code) && $requestToken->code == 32){
				    $twitterLoginState = mt_rand();
				    // save referrer url in state
	                update_user_meta($twitterLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
				    wp_redirect("https://twitter.com/i/oauth2/authorize?response_type=code&client_id=". $theChampLoginOptions['twitter_key'] ."&redirect_uri=". urlencode(esc_url(home_url()) ."/SuperSocializerAuth/Twitter") ."&scope=tweet.read%20users.read&state=". $twitterLoginState ."&code_challenge=challenge&code_challenge_method=plain");
			        die;
				}elseif($connection->getLastHttpCode() == 200){
					// generate unique ID
					$uniqueId = mt_rand();
					// save oauth token and secret in db temporarily
					update_user_meta($uniqueId, 'thechamp_twitter_oauthtoken', $requestToken['oauth_token']);
					update_user_meta($uniqueId, 'thechamp_twitter_oauthtokensecret', $requestToken['oauth_token_secret']);
					if(isset($_GET['heateorMSEnabled'])){
						update_user_meta($uniqueId, 'thechamp_mc_subscribe', '1');
					}
					if(isset($_GET['super_socializer_redirect_to']) && heateor_ss_validate_url($_GET['super_socializer_redirect_to']) !== false){
						update_user_meta($uniqueId, 'thechamp_twitter_redirect', esc_url_raw($_GET['super_socializer_redirect_to']));
					}
					wp_redirect($connection->url('oauth/authorize', ['oauth_token' => $requestToken['oauth_token']]));
					die;
				}else{
					?>
					<div style="width: 500px; margin: 0 auto">
						<ol>
						<li><?php echo sprintf(__('Enter exactly the following url in <strong>Website</strong> option in your Twitter app (see step 3 %s)', 'super-socializer'), '<a target="_blank" href="http://support.heateor.com/how-to-get-twitter-api-key-and-secret/">here</a>') ?><br/>
						<?php echo esc_url(home_url()) ?>
						</li>
						<li><?php echo sprintf(__('Enter exactly the following url in <strong>Callback URLs</strong> option in your Twitter app (see step 3 %s)', 'super-socializer'), '<a target="_blank" href="http://support.heateor.com/how-to-get-twitter-api-key-and-secret/">here</a>') ?><br/>
						<?php echo esc_url(home_url()); ?>
						</li>
						<li><?php _e('Make sure cURL is enabled at your website server. You may need to contact the server administrator of your website to verify this', 'super-socializer') ?></li>
						</ol>
					</div>
					<?php
					die;
				}
			}
			// Facebook
		}elseif(sanitize_text_field($_GET['SuperSocializerAuth']) == 'Facebook'){
		    if(isset($theChampLoginOptions['providers']) && in_array('facebook', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['fb_key']) && $theChampLoginOptions['fb_key'] != '' && isset($theChampLoginOptions['fb_secret']) && $theChampLoginOptions['fb_secret'] != ''){
		        if(!isset($_GET['code'])){
		            $facebookLoginState = mt_rand();
		            // save referrer url in state
		            update_user_meta($facebookLoginState, 'super_socializer_redirect_to', isset($_GET['super_socializer_redirect_to']) ? esc_url_raw($_GET['super_socializer_redirect_to']) : home_url());
		            wp_redirect("https://www.facebook.com/v16.0/dialog/oauth?scope=email&client_id=" . $theChampLoginOptions['fb_key'] . "&state=" . $facebookLoginState . "&redirect_uri=" . home_url() . "/?SuperSocializerAuth=Facebook");
		            die;
		        }elseif(isset($_GET['code']) && isset($_GET['state']) && get_user_meta(sanitize_text_field($_GET['state']), 'super_socializer_redirect_to', true) !== false){
		            $postData = array(
		                'code' => sanitize_text_field($_GET['code']),
		                'redirect_uri' => home_url() . "/?SuperSocializerAuth=Facebook",
		                'client_id' => $theChampLoginOptions['fb_key'],
		                'client_secret' => $theChampLoginOptions['fb_secret']
		            );
		            $response  = wp_remote_post("https://graph.facebook.com/v16.0/oauth/access_token", array(
		                'method' => 'POST',
		                'timeout' => 15,
		                'redirection' => 5,
		                'httpversion' => '1.0',
		                'sslverify' => false,
		                'headers' => array(
		                    'Content-Type' => 'application/x-www-form-urlencoded'
		                ),
		                'body' => http_build_query($postData)
		            ));
		            if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
		                $body     = json_decode(wp_remote_retrieve_body($response));
		                if(!empty($body->access_token)){
			                $response = wp_remote_get("https://graph.facebook.com/me?fields=id,name,about,link,email,first_name,last_name,picture.width(60).height(60).as(picture_small),picture.width(320).height(320).as(picture_large)&access_token=" . $body->access_token, array(
			                    'timeout' => 15
			                ));
			                if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
			                    $profileData = json_decode(wp_remote_retrieve_body($response));
			                    if(is_object($profileData) && isset($profileData->id)){
			                        $profileData           = the_champ_sanitize_profile_data($profileData, 'facebook');
			                        $facebookLoginState    = sanitize_text_field($_GET['state']);
			                        $facebook_redirect_url = get_user_meta($facebookLoginState, 'super_socializer_redirect_to', true);
			                        delete_user_meta($facebookLoginState, 'super_socializer_redirect_to');
			                        $response = the_champ_user_auth($profileData, 'faceboook', $facebook_redirect_url);
			                        if($response == 'show form'){
			                            return;
			                        }
			                        if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
			                            $redirectTo = the_champ_get_login_redirection_url($facebook_redirect_url, true);
			                        }elseif(isset($response['message']) && $response['message'] == 'linked'){
			                            $redirectTo = $facebook_redirect_url . (strpos($facebook_redirect_url, '?') !== false ? '&' : '?') . 'linked=1';
			                        }elseif(isset($response['message']) && $response['message'] == 'not linked'){
			                            $redirectTo = $facebook_redirect_url . (strpos($facebook_redirect_url, '?') !== false ? '&' : '?') . 'linked=0';
			                        }elseif(isset($response['url']) && $response['url'] != ''){
			                            $redirectTo = $response['url'];
			                        }else{
			                            $redirectTo = the_champ_get_login_redirection_url($facebook_redirect_url);
			                        }
			                        the_champ_close_login_popup($redirectTo);
			                    }
			                }
			            }
		            }
		        }
		    }
		}
	}elseif(isset($_GET['SuperSocializerSteamAuth']) && trim($_GET['SuperSocializerSteamAuth']) != '' && isset($theChampLoginOptions['steam_api_key']) && $theChampLoginOptions['steam_api_key'] != ''){
		global $theChampSteamLogin;
		$theChampSteamId = $theChampSteamLogin->validate();
    	$result = wp_remote_get("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$theChampLoginOptions['steam_api_key']."&steamids=".$theChampSteamId."/?xml=1",  array('timeout' => 15));
    	if(!is_wp_error($result) && isset($result['response']['code']) && 200 === $result['response']['code']){
			$data = json_decode(wp_remote_retrieve_body($result));
		    if($data && isset($data->response) && isset($data->response->players) && is_array($data->response->players)){
				$steamProfileData = $data->response->players;
				if(isset($steamProfileData[0]) && isset($steamProfileData[0]->steamid)){
					$steamProfileData = apply_filters('heateor_ss_steam_login_filter', $steamProfileData, $theChampLoginOptions);
					$steamRedirect = heateor_ss_validate_url($_GET['SuperSocializerSteamAuth']) !== false ? esc_url(trim($_GET['SuperSocializerSteamAuth'])) : '';
					$profileData = the_champ_sanitize_profile_data($steamProfileData[0], 'steam');
					if(strpos($steamRedirect, 'heateorMSEnabled') !== false){
						$profileData['mc_subscribe'] = 1;
					}
					$response = the_champ_user_auth($profileData, 'steam', $steamRedirect);
					if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
						$redirectTo = the_champ_get_login_redirection_url($steamRedirect, true);
					}elseif(isset($response['message']) && $response['message'] == 'linked'){
						$redirectTo = $steamRedirect.(strpos($steamRedirect, '?') !== false ? '&' : '?').'linked=1';
					}elseif(isset($response['message']) && $response['message'] == 'not linked'){
						$redirectTo = $steamRedirect.(strpos($steamRedirect, '?') !== false ? '&' : '?').'linked=0';
					}elseif(isset($response['url']) && $response['url'] != ''){
						$redirectTo = $response['url'];
					}else{
						$redirectTo = the_champ_get_login_redirection_url($steamRedirect);
					}
					the_champ_close_login_popup($redirectTo);
				}
		    }
		}
		die;
	}

	if(isset($_GET['code']) && isset($_GET['state']) && get_user_meta(sanitize_text_field($_GET['state']), 'super_socializer_redirect_to', true) !== false){
		if(remove_query_arg(array('code', 'state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Instagram'){
		 	$postData = array(
			 	'client_id' => $theChampLoginOptions['insta_id'],
				'client_secret' => $theChampLoginOptions['insta_app_secret'],
			 	'grant_type'  => 'authorization_code',
			 	'redirect_uri'  =>  home_url().'/SuperSocializerAuth/Instagram',
			  	'code' => sanitize_text_field($_GET['code'])
			);
			$response = wp_remote_post("https://api.instagram.com/oauth/access_token", array(
					'method' => 'POST',
					'timeout' => 15,
					'redirection' => 5,
					'httpversion' => '1.0',
					'sslverify' => false,
					'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
					'body' => http_build_query($postData)
			    )
			);

			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				if(isset($body->access_token)){
					$authorization = "Bearer ".$body->access_token;
					$response = wp_remote_get('https://graph.instagram.com/'.$body->user_id.'?fields=account_type,id,username&access_token='.$body->access_token,  array('timeout' => 15));
						
					if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
						$profileData = json_decode(wp_remote_retrieve_body($response ));
				
						if(is_object($profileData) && isset($profileData->id)){
							$profileData = the_champ_sanitize_profile_data($profileData, 'instagram');
							$instagramLoginState = sanitize_text_field($_GET['state']);
							$instagramRedirectUrl = get_user_meta($instagramLoginState, 'super_socializer_redirect_to', true);
							$response = the_champ_user_auth($profileData, 'instagram', $instagramRedirectUrl);
							if($response == 'show form'){
								return;
							}
							delete_user_meta($instagramLoginState, 'super_socializer_redirect_to', true);
							if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
								$redirectTo = the_champ_get_login_redirection_url($instagramRedirectUrl, true);
							}elseif(isset($response['message']) && $response['message'] == 'linked'){
								$redirectTo = $instagramRedirectUrl.(strpos($instagramRedirectUrl, '?') !== false ? '&' : '?').'linked=1';
							}elseif(isset($response['message']) && $response['message'] == 'not linked'){
								$redirectTo = $instagramRedirectUrl.(strpos($instagramRedirectUrl, '?') !== false ? '&' : '?').'linked=0';
							}elseif(isset($response['url']) && $response['url'] != ''){
								$redirectTo = $response['url'];
							}else{
								$redirectTo = the_champ_get_login_redirection_url($instagramRedirectUrl);
							}
							the_champ_close_login_popup($redirectTo);
						}				
					}
				}
	 		}
		}elseif(remove_query_arg(array('code','scope', 'state'), strtok(the_champ_get_http().$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'?')) == home_url().'/SuperSocializerAuth/Line'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Line",
				'client_id' => $theChampLoginOptions['line_channel_id'],
				'client_secret' => $theChampLoginOptions['line_channel_secret']
			);
			$response = wp_remote_post("https://api.line.me/oauth2/v2.1/token", array(
					'method' => 'POST',
					'timeout' => 15,
					'redirection' => 5,
					'httpversion' => '1.0',
					'sslverify' => false,
					'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
					'body' => http_build_query($postData)
			    )
			);
			
			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				if(is_object($body) && isset($body->id_token) && $body->id_token){
					$response = wp_remote_post("https://api.line.me/oauth2/v2.1/verify", array(
	    					'method' => 'POST',
	    					'timeout' => 15,
	    					'redirection' => 5,
	    					'httpversion' => '1.0',
	    					'sslverify' => false,
	    					'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
	    					'body' => http_build_query( array(
	    					    'id_token'  => $body->id_token,
	    					    'client_id' => $theChampLoginOptions['line_channel_id']
	    					 ) )
	    			    )
	    			);

					if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
						$profileData = json_decode(wp_remote_retrieve_body($response));
						if(is_object($profileData) && isset($profileData->sub) && $profileData->sub){
							$profileData      = the_champ_sanitize_profile_data($profileData, 'line');
							$lineLoginState   = sanitize_text_field($_GET['state']);
							$lineRedirectUrl  = get_user_meta($lineLoginState, 'super_socializer_redirect_to', true);
							$response = the_champ_user_auth($profileData, 'line', $lineRedirectUrl);
							if($response == 'show form'){
								return;
							}
							if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
								$redirectTo = the_champ_get_login_redirection_url($lineRedirectUrl, true);
							}elseif(isset($response['message']) && $response['message'] == 'linked'){
								$redirectTo = $lineRedirectUrl . (strpos($lineRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
							}elseif(isset($response['message']) && $response['message'] == 'not linked'){
								$redirectTo = $lineRedirectUrl . (strpos($lineRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
							}elseif(isset($response['url']) && $response['url'] != ''){
								$redirectTo = $response['url'];
							}else{
								$redirectTo = the_champ_get_login_redirection_url($lineRedirectUrl);
							}
							the_champ_close_login_popup($redirectTo);
						}			
					}
				}
	 		}
		}elseif(remove_query_arg(array('code', 'state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Mailru'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Mailru"
			);
			$serviceUrl = 'https://oauth.mail.ru/token';
			$auth = base64_encode($theChampLoginOptions['mailru_client_id']. ":" .$theChampLoginOptions['mailru_client_secret']);
			$response = wp_remote_post($serviceUrl, array(
					'method' => 'POST',
					'timeout' => 15,
					'redirection' => 5,
					'httpversion' => '1.0',
					'sslverify' => false,
					'headers' => array(
						'Content-Type' => "application/x-www-form-urlencoded",
						'User-Agent' => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36",
						'Authorization' => "Basic $auth"
					),
					'body' => $postData
			    )
			);
			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				if(is_object($body) && isset($body->access_token)){
					$serviceUrl = 'https://oauth.mail.ru/userinfo?access_token=' .$body->access_token;

					$response = wp_remote_get($serviceUrl, array('timeout' => 15, 'headers' => array(
						'Content-Type' => 'application/x-www-form-urlencoded',
						'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36',
						'Authorization' => "Bearer ". $body->access_token
					)));
					if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
						$profileData = json_decode(wp_remote_retrieve_body($response));
						
						if(is_object($profileData) && isset($profileData->id)){
							$profileData        = the_champ_sanitize_profile_data($profileData, 'mailru');
							$mailruLoginState   = sanitize_text_field($_GET['state']);
							$mailruRedirectUrl  = get_user_meta($mailruLoginState, 'super_socializer_redirect_to', true);
							$response = the_champ_user_auth($profileData, 'mailru', $mailruRedirectUrl);
							if($response == 'show form'){
								return;
							}
							if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
								$redirectTo = the_champ_get_login_redirection_url($mailruRedirectUrl, true);
							}elseif(isset($response['message']) && $response['message'] == 'linked'){
								$redirectTo = $mailruRedirectUrl . (strpos($mailruRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
							}elseif(isset($response['message']) && $response['message'] == 'not linked'){
								$redirectTo = $mailruRedirectUrl . (strpos($mailruRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
							}elseif(isset($response['url']) && $response['url'] != ''){
								$redirectTo = $response['url'];
							}else{
								$redirectTo = the_champ_get_login_redirection_url($mailruRedirectUrl);
							}
							the_champ_close_login_popup($redirectTo);
						}
					}
				}
			}
		}elseif(remove_query_arg(array('code', 'state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Yahoo'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Yahoo",
				'client_id' => $theChampLoginOptions['yahoo_channel_id'],
				'client_secret' => $theChampLoginOptions['yahoo_channel_secret']
			);
			$response = wp_remote_post("https://api.login.yahoo.com/oauth2/get_token", array(
				'method' => 'POST',
				'timeout' => 15,
				'redirection' => 5,
				'httpversion' => '1.0',
				'sslverify' => false,
				'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
				'body' => http_build_query($postData)
			    )
			);

			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				$authorization = "Bearer ".$body->access_token;

				$response = wp_remote_get("https://api.login.yahoo.com/openid/v1/userinfo",  array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json' , 'Authorization' => $authorization )));
					
				if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
					$profileData = json_decode(wp_remote_retrieve_body($response));
					
					if(is_object($profileData) && isset($profileData->sub)){
						$profileData = the_champ_sanitize_profile_data($profileData, 'yahoo');
						$yahooLoginState  = sanitize_text_field($_GET['state']);
						$yahooRedirectUrl = get_user_meta($yahooLoginState, 'super_socializer_redirect_to', true);
						$response = the_champ_user_auth($profileData, 'yahoo', $yahooRedirectUrl);
						if($response == 'show form'){
							return;
						}
						delete_user_meta($yahooLoginState, 'super_socializer_redirect_to', true);
						if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
							$redirectTo = the_champ_get_login_redirection_url($yahooRedirectUrl, true);
						}elseif(isset($response['message']) && $response['message'] == 'linked'){
							$redirectTo = $yahooRedirectUrl . (strpos($yahooRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
						}elseif(isset($response['message']) && $response['message'] == 'not linked'){
							$redirectTo = $yahooRedirectUrl . (strpos($yahooRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
						}elseif(isset($response['url']) && $response['url'] != ''){
							$redirectTo = $response['url'];
						}else{
							$redirectTo = the_champ_get_login_redirection_url($yahooRedirectUrl);
						}
						the_champ_close_login_popup($redirectTo);
					}
				}
	 		}
		}elseif(remove_query_arg(array('code', 'scope', 'state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Discord'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Discord",
				'client_id' => $theChampLoginOptions['discord_channel_id'],
				'client_secret' => $theChampLoginOptions['discord_channel_secret'],
				'scope' => 'identify%20email'
			);
			$response = wp_remote_post("https://discord.com/api/oauth2/token", array(
					'method' => 'POST',
					'timeout' => 15,
					'redirection' => 5,
					'httpversion' => '1.0',
					'sslverify' => false,
					'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
					'body' => http_build_query($postData)
			    )
			);
			
			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				$authorization = "Bearer ".$body->access_token;

				$response = wp_remote_get("https://discordapp.com/api/users/@me",  array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json' , 'Authorization' => $authorization )));
					
				if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
					$profileData = json_decode(wp_remote_retrieve_body($response));
					if(is_object($profileData) && isset($profileData->id) && isset($profileData->verified) && $profileData->verified == 1){
						$profileData = the_champ_sanitize_profile_data($profileData, 'discord');
						$discordLoginState  = sanitize_text_field($_GET['state']);
						$discordRedirectUrl = get_user_meta($discordLoginState, 'super_socializer_redirect_to', true);
						$response = the_champ_user_auth($profileData, 'discord', $discordRedirectUrl);
						if($response == 'show form'){
							return;
						}
						delete_user_meta($discordLoginState, 'super_socializer_redirect_to', true);
						if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
							$redirectTo = the_champ_get_login_redirection_url($discordRedirectUrl, true);
						}elseif(isset($response['message']) && $response['message'] == 'linked'){
							$redirectTo = $discordRedirectUrl . (strpos($discordRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
						}elseif(isset($response['message']) && $response['message'] == 'not linked'){
							$redirectTo = $discordRedirectUrl . (strpos($discordRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
						}elseif(isset($response['url']) && $response['url'] != ''){
							$redirectTo = $response['url'];
						}else{
							$redirectTo = the_champ_get_login_redirection_url($discordRedirectUrl);
						}
						the_champ_close_login_popup($redirectTo);
					}
				}
	 		}
		}elseif(remove_query_arg(array('code','state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Wordpress'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Wordpress",
				'client_id' => $theChampLoginOptions['wordpress_client_id'],
				'client_secret' => $theChampLoginOptions['wordpress_client_secret']
			);
			$response = wp_remote_post("https://public-api.wordpress.com/oauth2/token", array(
				'method' => 'POST',
				'timeout' => 15,
				'redirection' => 5,
				'httpversion' => '1.0',
				'sslverify' => false,
				'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
				'body' => http_build_query($postData)
			    )
			);
			
			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				$authorization = "Bearer ".$body->access_token;

				$response = wp_remote_get("https://public-api.wordpress.com/rest/v1/me/", array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json', 'Authorization' => $authorization )));
					
				if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
					$profileData = json_decode(wp_remote_retrieve_body($response));
					if(is_object($profileData) && isset($profileData->ID)){	
						$profileData = the_champ_sanitize_profile_data($profileData, 'wordpress');
						$wordpressLoginState  = sanitize_text_field($_GET['state']);
						$wordpressRedirectUrl = get_user_meta($wordpressLoginState, 'super_socializer_redirect_to', true);
						$response = the_champ_user_auth($profileData, 'wordpress', $wordpressRedirectUrl);
						if($response == 'show form'){
							return;
						}
						delete_user_meta($wordpressLoginState, 'super_socializer_redirect_to', true);
						if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
							$redirectTo = the_champ_get_login_redirection_url($wordpressRedirectUrl, true);
						}elseif(isset($response['message']) && $response['message'] == 'linked'){
							$redirectTo = $wordpressRedirectUrl.(strpos($wordpressRedirectUrl, '?') !== false ? '&' : '?').'linked=1';
						}elseif(isset($response['message']) && $response['message'] == 'not linked'){
							$redirectTo = $wordpressRedirectUrl.(strpos($wordpressRedirectUrl, '?') !== false ? '&' : '?').'linked=0';
						}elseif(isset($response['url']) && $response['url'] != ''){
							$redirectTo = $response['url'];
						}else{
							$redirectTo = the_champ_get_login_redirection_url($wordpressRedirectUrl);
						}
						the_champ_close_login_popup($redirectTo);
					}
								
				}
	 		}
		}elseif(remove_query_arg(array('code', 'state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Live'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Live",
				'client_id' => $theChampLoginOptions['live_channel_id'],
				'client_secret' => $theChampLoginOptions['live_channel_secret']
			);
			$response = wp_remote_post("https://login.live.com/oauth20_token.srf", array(
				'method' => 'POST',
				'timeout' => 15,
				'redirection' => 5,
				'httpversion' => '1.0',
				'sslverify' => false,
				'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
				'body' => http_build_query($postData)
			    )
			);
			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));

				$response = wp_remote_get("https://apis.live.net/v5.0/me?access_token=".$body->access_token,  array('timeout' => 15));
					
				if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
					$profileData = json_decode(wp_remote_retrieve_body($response ));
					if(is_object($profileData) && isset($profileData->id)){	
						$profileData = the_champ_sanitize_profile_data($profileData, 'microsoft');
						$liveLoginState = sanitize_text_field($_GET['state']);
						$liveRedirectUrl = get_user_meta($liveLoginState, 'super_socializer_redirect_to', true);
						$response = the_champ_user_auth($profileData, 'microsoft', $liveRedirectUrl);
						if($response == 'show form'){
							return;
						}
						delete_user_meta($liveLoginState, 'super_socializer_redirect_to');
						if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
							$redirectTo = the_champ_get_login_redirection_url($liveRedirectUrl, true);
						}elseif(isset($response['message']) && $response['message'] == 'linked'){
							$redirectTo = $liveRedirectUrl.(strpos($liveRedirectUrl, '?') !== false ? '&' : '?').'linked=1';
						}elseif(isset($response['message']) && $response['message'] == 'not linked'){
							$redirectTo = $liveRedirectUrl.(strpos($liveRedirectUrl, '?') !== false ? '&' : '?').'linked=0';
						}elseif(isset($response['url']) && $response['url'] != ''){
							$redirectTo = $response['url'];
						}else{
							$redirectTo = the_champ_get_login_redirection_url($liveRedirectUrl);
						}
						the_champ_close_login_popup($redirectTo);
					}
								
				}
	 		}
		}elseif(remove_query_arg(array('code', 'scope', 'state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Twitch'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Twitch",
				'client_id' => $theChampLoginOptions['twitch_client_id'],
				'client_secret' => $theChampLoginOptions['twitch_client_secret']
			);
			$response = wp_remote_post("https://id.twitch.tv/oauth2/token", array(
				'method' => 'POST',
				'timeout' => 15,
				'redirection' => 5,
				'httpversion' => '1.0',
				'sslverify' => false,
				'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
				'body' => http_build_query($postData)
			    )
			);
			
			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				$authorization = "Bearer ".$body->access_token;

				$response = wp_remote_get("https://api.twitch.tv/helix/users",  array('timeout' => 15, 'headers' =>  array('Content-Type' => 'application/json' ,'Authorization' => 'Bearer ' . $body->access_token , 'Client-Id' => $theChampLoginOptions['twitch_client_id'])
				));
				if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
					$profileData = json_decode(wp_remote_retrieve_body($response ));
					if(is_object($profileData) && isset($profileData->data) && is_array($profileData->data) && isset($profileData->data[0]) && isset($profileData->data[0]->id)){	
						$profileData = the_champ_sanitize_profile_data($profileData->data[0], 'twitch');
						$twitchLoginState = sanitize_text_field($_GET['state']);
						$twitchRedirectUrl = get_user_meta($twitchLoginState, 'super_socializer_redirect_to', true);
						$response = the_champ_user_auth($profileData, 'twitch', $twitchRedirectUrl);
						if($response == 'show form'){
							return;
						}
						delete_user_meta($twitchLoginState, 'super_socializer_redirect_to', true);
						if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
							$redirectTo = the_champ_get_login_redirection_url($twitchRedirectUrl, true);
						}elseif(isset($response['message']) && $response['message'] == 'linked'){
							$redirectTo = $twitchRedirectUrl . (strpos($twitchRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
						}elseif(isset($response['message']) && $response['message'] == 'not linked'){
							$redirectTo = $twitchRedirectUrl . (strpos($twitchRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
						}elseif(isset($response['url']) && $response['url'] != ''){
							$redirectTo = $response['url'];
						}else{
							$redirectTo = the_champ_get_login_redirection_url($twitchRedirectUrl);
						}
						the_champ_close_login_popup($redirectTo);
					}			
				}
	 		}
		}elseif(remove_query_arg(array(
		    'code',
		    'state',
		    'scope'
		), esc_url_raw(the_champ_get_http() . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"])) == home_url() . '/SuperSocializerAuth/Reddit'){
		    $postData = array(
		        'grant_type' => 'authorization_code',
		        'code' => sanitize_text_field($_GET['code']),
		        'redirect_uri' => home_url() . "/SuperSocializerAuth/Reddit",
		        'client_id' => $theChampLoginOptions['reddit_client_id'],
		        'client_secret' => $theChampLoginOptions['reddit_client_secret']
		    );
		    $response  = wp_remote_post("https://www.reddit.com/api/v1/access_token", array(
		        'timeout' => 15,
		        'redirection' => 5,
		        'httpversion' => '1.0',
		        'sslverify' => false,
		        'headers' => array(
		            'Content-Type' => 'application/x-www-form-urlencoded',
		            'Authorization' => 'Basic ' . base64_encode($theChampLoginOptions['reddit_client_id'] . ':' . $theChampLoginOptions['reddit_client_secret'])
		        ),
		        'body' => http_build_query($postData)
		    ));
		    if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
		        $body     = json_decode(wp_remote_retrieve_body($response));
		        $response = wp_remote_get("https://oauth.reddit.com/api/v1/me", array(
		            'timeout' => 15,
		            'headers' => array(
		                'Authorization' => "Bearer " . $body->access_token
		            )
		        ));
		        if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
		            $profileData = json_decode(wp_remote_retrieve_body($response));
		            if(is_object($profileData) && isset($profileData->id) && isset($profileData->verified) && $profileData->verified == 1){
		                $profileData         = the_champ_sanitize_profile_data($profileData, 'reddit');
		                $redditLoginState = sanitize_text_field($_GET['state']);
						$redditRedirectUrl = get_user_meta($redditLoginState, 'super_socializer_redirect_to', true);
		                $response = the_champ_user_auth($profileData, 'reddit', $redditRedirectUrl);
		                if($response == 'show form'){
		                    return;
		                }
		                if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
		                    $redirectTo = the_champ_get_login_redirection_url($redditRedirectUrl, true);
		                }elseif(isset($response['message']) && $response['message'] == 'linked'){
		                    $redirectTo = $redditRedirectUrl . (strpos($redditRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
		                }elseif(isset($response['message']) && $response['message'] == 'not linked'){
		                    $redirectTo = $redditRedirectUrl . (strpos($redditRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
		                }elseif(isset($response['url']) && $response['url'] != ''){
		                    $redirectTo = $response['url'];
		                } else {
		                    $redirectTo = the_champ_get_login_redirection_url($redditRedirectUrl);
		                }
		                the_champ_close_login_popup($redirectTo);
		            }
		        }
		    }
		}elseif(remove_query_arg(array(
		    'code',
		    'scope',
		    'state'
		), esc_url_raw(the_champ_get_http() . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"])) == home_url() . '/SuperSocializerAuth/Disqus'){
		    $postData = array(
		        'grant_type' => 'authorization_code',
		        'code' => sanitize_text_field($_GET['code']),
		        'redirect_uri' => home_url() . "/SuperSocializerAuth/Disqus",
		        'client_id' => $theChampLoginOptions['disqus_public_key'],
		        'client_secret' => $theChampLoginOptions['disqus_secret_key']
		    );
		    $response  = wp_remote_post("https://disqus.com/api/oauth/2.0/access_token/", array(
		        'timeout' => 15,
		        'redirection' => 5,
		        'httpversion' => '1.0',
		        'sslverify' => false,
		        'headers' => array(
		            'Content-Type' => 'application/x-www-form-urlencoded',
		            'Authorization' => 'Basic ' . base64_encode($theChampLoginOptions['disqus_public_key'] . ':' . $theChampLoginOptions['disqus_secret_key'])
		        ),
		        'body' => http_build_query($postData)
		    ));
		    if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
		        $body     = json_decode(wp_remote_retrieve_body($response));
		        $response = wp_remote_get("https://disqus.com/api/3.0/users/details.json?api_key=" . $theChampLoginOptions['disqus_public_key'], array(
		            'timeout' => 15,
		            'headers' => array(
		                'Authorization' => "Bearer " . $body->access_token
		            )
		        ));
		        if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
		            $profileData = json_decode(wp_remote_retrieve_body($response));
		            if(is_object($profileData) && isset($profileData->response->id)){
		                $profileData         = the_champ_sanitize_profile_data($profileData, 'disqus');
		                $disqusLoginState    = sanitize_text_field($_GET['state']);
						$disqusRedirectUrl   = get_user_meta($disqusLoginState, 'super_socializer_redirect_to', true);
		                $response = the_champ_user_auth($profileData, 'disqus', $disqusRedirectUrl);
		                if($response == 'show form'){
		                    return;
		                }
		                delete_user_meta($disqusLoginState, 'super_socializer_redirect_to', true);
		                if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
		                    $redirectTo = the_champ_get_login_redirection_url($disqusRedirectUrl, true);
		                }elseif(isset($response['message']) && $response['message'] == 'linked'){
		                    $redirectTo = $disqusRedirectUrl . (strpos($disqusRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
		                }elseif(isset($response['message']) && $response['message'] == 'not linked'){
		                    $redirectTo = $disqusRedirectUrl . (strpos($disqusRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
		                }elseif(isset($response['url']) && $response['url'] != ''){
		                    $redirectTo = $response['url'];
		                } else {
		                    $redirectTo = the_champ_get_login_redirection_url($disqusRedirectUrl);
		                }
		                the_champ_close_login_popup($redirectTo);
		            }
		        }
		    }
		}elseif(remove_query_arg(array(
		    'code',
		    'scope',
		    'state'
		), esc_url_raw(the_champ_get_http() . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"])) == home_url() . '/SuperSocializerAuth/Dropbox'){
		    $postData = array(
		        'grant_type' => 'authorization_code',
		        'code' => sanitize_text_field($_GET['code']),
		        'redirect_uri' => home_url() . "/SuperSocializerAuth/Dropbox"
		    );
		    $response  = wp_remote_post("https://api.dropbox.com/1/oauth2/token", array(
		        'method' => 'POST',
		        'timeout' => 15,
		        'redirection' => 5,
		        'httpversion' => '1.0',
		        'sslverify' => false,
		        'headers' => array(
		            'Content-Type' => 'application/x-www-form-urlencoded',
		            'Authorization' => 'Basic ' . base64_encode($theChampLoginOptions['dropbox_app_key'] . ':' . $theChampLoginOptions['dropbox_app_secret'])
		        ),
		        'body' => http_build_query($postData)
		    ));
		    if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
		        $body     = json_decode(wp_remote_retrieve_body($response));
		        $response = wp_remote_post("https://api.dropbox.com/2/users/get_current_account", array(
		            'timeout' => 15,
		            'headers' => array(
		                'content-type' => 'application/json',
		                'Authorization' => "Bearer " . $body->access_token
		            ),
		            'body' => "null"
		        ));
		        if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
		            $profileData = json_decode(wp_remote_retrieve_body($response));
		            if(is_object($profileData) && isset($profileData->account_id)){
		                $profileData         = the_champ_sanitize_profile_data($profileData, 'dropbox');
		                $dropboxLoginState   = sanitize_text_field($_GET['state']);
						$dropboxRedirectUrl  = get_user_meta($dropboxLoginState, 'super_socializer_redirect_to', true);
		                $response = the_champ_user_auth($profileData, 'dropbox', $dropboxRedirectUrl);
		                if($response == 'show form'){
		                    return;
		                }
		                delete_user_meta($dropboxLoginState, 'super_socializer_redirect_to', true);
		                if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
		                    $redirectTo = the_champ_get_login_redirection_url($dropboxRedirectUrl, true);
		                }elseif(isset($response['message']) && $response['message'] == 'linked'){
		                    $redirectTo = $dropboxRedirectUrl . (strpos($dropboxRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
		                }elseif(isset($response['message']) && $response['message'] == 'not linked'){
		                    $redirectTo = $dropboxRedirectUrl . (strpos($dropboxRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
		                }elseif(isset($response['url']) && $response['url'] != ''){
		                    $redirectTo = $response['url'];
		                } else {
		                    $redirectTo = the_champ_get_login_redirection_url($dropboxRedirectUrl);
		                }
		                the_champ_close_login_popup($redirectTo);
		            }
		        }
		    }
		}elseif(remove_query_arg(array(
		    'code', 'state'
		), esc_url_raw(the_champ_get_http() . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"])) == home_url() . '/SuperSocializerAuth/Foursquare'){
		    $postData = array(
		        'grant_type' => 'authorization_code',
		        'code' => sanitize_text_field($_GET['code']),
		        'redirect_uri' => home_url() . "/SuperSocializerAuth/Foursquare",
		        'client_id' => $theChampLoginOptions['foursquare_client_id'],
		        'client_secret' => $theChampLoginOptions['foursquare_client_secret']
		    );
		    $response  = wp_remote_post("https://foursquare.com/oauth2/access_token", array(
		        'timeout' => 15,
		        'redirection' => 5,
		        'httpversion' => '1.0',
		        'sslverify' => false,
		        'headers' => array(
		            'Content-Type' => 'application/x-www-form-urlencoded',
		            'Authorization' => 'Basic ' . base64_encode($theChampLoginOptions['foursquare_client_id'] . ':' . $theChampLoginOptions['foursquare_client_secret'])
		        ),
		        'body' => http_build_query($postData)
		    ));
		    
		    if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
		        $body     = json_decode(wp_remote_retrieve_body($response));
		        $response = wp_remote_get("https://api.foursquare.com/v2/users/self?oauth_token=" . $body->access_token . "&v=" . rand(), array(
		            'timeout' => 15,
		            'headers' => array(
		                'Authorization' => "Bearer " . $body->access_token
		            )
		        ));
		        if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
		            $profileData = json_decode(wp_remote_retrieve_body($response));
		            if(is_object($profileData) && isset($profileData->response->user->id)){
		                $profileData           = the_champ_sanitize_profile_data($profileData, 'foursquare');
		                $foursquareLoginState   = sanitize_text_field($_GET['state']);
						$foursquareRedirectUrl  = get_user_meta($foursquareLoginState, 'super_socializer_redirect_to', true);
		                $response = the_champ_user_auth($profileData, 'foursquare', $foursquareRedirectUrl);
		                if($response == 'show form'){
		                    return;
		                }
		                if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
		                    $redirectTo = the_champ_get_login_redirection_url($foursquareRedirectUrl, true);
		                }elseif(isset($response['message']) && $response['message'] == 'linked'){
		                    $redirectTo = $foursquareRedirectUrl . (strpos($foursquareRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
		                }elseif(isset($response['message']) && $response['message'] == 'not linked'){
		                    $redirectTo = $foursquareRedirectUrl . (strpos($foursquareRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
		                }elseif(isset($response['url']) && $response['url'] != ''){
		                    $redirectTo = $response['url'];
		                } else {
		                    $redirectTo = the_champ_get_login_redirection_url($foursquareRedirectUrl);
		                }
		                the_champ_close_login_popup($redirectTo);
		            }
		        }
		    }
		}elseif(remove_query_arg(array('code', 'scope', 'state'), esc_url_raw(the_champ_get_http() . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"])) == home_url() . '/SuperSocializerAuth/Odnoklassniki'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Odnoklassniki",
				'client_id' => $theChampLoginOptions['odnoklassniki_client_id'],
				'client_secret' => $theChampLoginOptions['odnoklassniki_client_secret']
			);
			$response = wp_remote_post("https://api.ok.ru/oauth/token.do", array(
					'method' => 'POST',
					'timeout' => 15,
					'redirection' => 5,
					'httpversion' => '1.0',
					'sslverify' => false,
					'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
					'body' => http_build_query($postData)
			    )
			);

			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				$authorization = "Bearer " . $body->access_token;

				$response = wp_remote_get("https://api.ok.ru/fb.do?application_key=" . $theChampLoginOptions['odnoklassniki_public_key'] . "&format=json&method=users.getCurrentUser&sig=" . mt_rand() . "&access_token=" . $body->access_token,  array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json' , 'Authorization' => $authorization)));

				if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
					$profileData = json_decode(wp_remote_retrieve_body($response));
			
					if(is_object($profileData) && isset($profileData->uid)){
						$profileData               = the_champ_sanitize_profile_data($profileData, 'odnoklassniki');
						$odnoklassnikiLoginState   = sanitize_text_field($_GET['state']);
						$odnoklassnikiRedirectUrl  = get_user_meta($odnoklassnikiLoginState, 'super_socializer_redirect_to', true);
						$response = the_champ_user_auth($profileData, 'odnoklassniki', $odnoklassnikiRedirectUrl);
						if($response == 'show form'){
							return;
						}
						if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
							$redirectTo = the_champ_get_login_redirection_url($odnoklassnikiRedirectUrl, true);
						}elseif(isset($response['message']) && $response['message'] == 'linked'){
							$redirectTo = $odnoklassnikiRedirectUrl . (strpos($odnoklassnikiRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
						}elseif(isset($response['message']) && $response['message'] == 'not linked'){
							$redirectTo = $odnoklassnikiRedirectUrl . (strpos($odnoklassnikiRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
						}elseif(isset($response['url']) && $response['url'] != ''){
							$redirectTo = $response['url'];
						}else{
							$redirectTo = the_champ_get_login_redirection_url($odnoklassnikiRedirectUrl);
						}
						the_champ_close_login_popup($redirectTo);
					}			
				}
	 		}
		}elseif(remove_query_arg(array('code','scope', 'state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Dribbble'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Dribbble",
				'client_id' => $theChampLoginOptions['dribbble_client_id'],
				'client_secret' => $theChampLoginOptions['dribbble_client_secret']
			);
			$response = wp_remote_post("https://dribbble.com/oauth/token", array(
				'method' => 'POST',
				'timeout' => 15,
				'redirection' => 5,
				'httpversion' => '1.0',
				'sslverify' => false,
				'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
				'body' => http_build_query($postData)
			    )
			);
			
			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				$authorization = "Bearer ".$body->access_token;

				$response = wp_remote_get("https://api.dribbble.com/v2/user?access_token",  array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json' , 'Authorization' => $authorization )));

				if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
					$profileData = json_decode(wp_remote_retrieve_body($response));
					if(is_object($profileData) && isset($profileData->id)){
						$profileData          = the_champ_sanitize_profile_data($profileData, 'dribbble');
						$dribbbleLoginState   = sanitize_text_field($_GET['state']);
						$dribbbleRedirectUrl  = get_user_meta($dribbbleLoginState, 'super_socializer_redirect_to', true);
						$response = the_champ_user_auth($profileData, 'dribbble', $dribbbleRedirectUrl);
						if($response == 'show form'){
							return;
						}
						if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
							$redirectTo = the_champ_get_login_redirection_url($dribbbleRedirectUrl, true);
						}elseif(isset($response['message']) && $response['message'] == 'linked'){
							$redirectTo = $dribbbleRedirectUrl . (strpos($dribbbleRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
						}elseif(isset($response['message']) && $response['message'] == 'not linked'){
							$redirectTo = $dribbbleRedirectUrl . (strpos($dribbbleRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
						}elseif(isset($response['url']) && $response['url'] != ''){
							$redirectTo = $response['url'];
						}else{
							$redirectTo = the_champ_get_login_redirection_url($dribbbleRedirectUrl);
						}
						the_champ_close_login_popup($redirectTo);
					}			
				}
	 		}
		}elseif(remove_query_arg(array('code', 'state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Yandex'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'state' => sanitize_text_field($_GET['state']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Yandex",
				'client_id' => $theChampLoginOptions['yandex_client_id'],
				'client_secret' => $theChampLoginOptions['yandex_client_secret']
			);
			$response = wp_remote_post("https://oauth.yandex.com/token", array(
				'method' => 'POST',
				'timeout' => 15,
				'redirection' => 5,
				'httpversion' => '1.0',
				'sslverify' => false,
				'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
				'body' => http_build_query($postData)
			    )
			);
			
			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				$authorization = "Bearer ".$body->access_token;

				$response = wp_remote_get("https://login.yandex.ru/info",  array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json' , 'Authorization' => $authorization )));

				if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
					$profileData = json_decode(wp_remote_retrieve_body($response));
					if(is_object($profileData) && isset($profileData->id)){
						$profileData          = the_champ_sanitize_profile_data($profileData, 'yandex');
						$yandexLoginState   = sanitize_text_field($_GET['state']);
						$yandexRedirectUrl  = get_user_meta($yandexLoginState, 'super_socializer_redirect_to', true);
						$response = the_champ_user_auth($profileData, 'yandex', $yandexRedirectUrl);
						if($response == 'show form'){
							return;
						}
						if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
							$redirectTo = the_champ_get_login_redirection_url($yandexRedirectUrl, true);
						}elseif(isset($response['message']) && $response['message'] == 'linked'){
							$redirectTo = $yandexRedirectUrl . (strpos($yandexRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
						}elseif(isset($response['message']) && $response['message'] == 'not linked'){
							$redirectTo = $yandexRedirectUrl . (strpos($yandexRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
						}elseif(isset($response['url']) && $response['url'] != ''){
							$redirectTo = $response['url'];
						}else{
							$redirectTo = the_champ_get_login_redirection_url($yandexRedirectUrl);
						}
						the_champ_close_login_popup($redirectTo);
					}			
				}
	 		}
		}elseif(remove_query_arg(array('code', 'state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Spotify'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Spotify",
				'client_id' => $theChampLoginOptions['spotify_client_id'],
				'client_secret' => $theChampLoginOptions['spotify_client_secret']
			);
			$response = wp_remote_post("https://accounts.spotify.com/api/token", array(
				'method' => 'POST',
				'timeout' => 15,
				'redirection' => 5,
				'httpversion' => '1.0',
				'sslverify' => false,
				'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
				'body' => http_build_query($postData)
			    )
			);
			
			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				if(isset($body->access_token)){
					$authorization = "Bearer ".$body->access_token;
					$response = wp_remote_get('https://api.spotify.com/v1/me',  array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json' , 'Authorization' => $authorization)));
					if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
						$profileData = json_decode(wp_remote_retrieve_body($response));
						if(is_object($profileData) && isset($profileData->id)){	
							$profileData         = the_champ_sanitize_profile_data($profileData, 'spotify');
							$spotifyLoginState   = sanitize_text_field($_GET['state']);
							$spotifyRedirectUrl  = get_user_meta($spotifyLoginState, 'super_socializer_redirect_to', true);
							$response = the_champ_user_auth($profileData, 'spotify', $spotifyRedirectUrl);
							if($response == 'show form'){
								return;
							}
							if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
								$redirectTo = the_champ_get_login_redirection_url($liveRedirectUrl, true);
							}elseif(isset($response['message']) && $response['message'] == 'linked'){
								$redirectTo = $spotifyRedirectUrl . (strpos($spotifyRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
							}elseif(isset($response['message']) && $response['message'] == 'not linked'){
								$redirectTo = $spotifyRedirectUrl . (strpos($spotifyRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
							}elseif(isset($response['url']) && $response['url'] != ''){
								$redirectTo = $response['url'];
							}else{
								$redirectTo = the_champ_get_login_redirection_url($spotifyRedirectUrl);
							}
							the_champ_close_login_popup($redirectTo);
						}
					}
		 		}
			}
		}elseif(remove_query_arg(array('code','state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Kakao'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Kakao",
				'client_id' => $theChampLoginOptions['kakao_client_id'],
				'client_secret' => $theChampLoginOptions['kakao_client_secret']
			);
			$response = wp_remote_post("https://kauth.kakao.com/oauth/token", array(
				'method' => 'POST',
				'timeout' => 15,
				'redirection' => 5,
				'httpversion' => '1.0',
				'sslverify' => false,
				'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
				'body' => http_build_query($postData)
			    )
			);
			
			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				if(isset($body->access_token)){
					$authorization = "Bearer ".$body->access_token;
					$response = wp_remote_get('https://kapi.kakao.com/v2/user/me',  array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json' , 'Authorization' => $authorization)));
					if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
						$profileData = json_decode(wp_remote_retrieve_body($response));
						if(is_object($profileData) && isset($profileData->id)){	
							$profileData         = the_champ_sanitize_profile_data($profileData, 'kakao');
							$kakaoLoginState     = sanitize_text_field($_GET['state']);
							$kakaoRedirectUrl    = get_user_meta($kakaoLoginState, 'super_socializer_redirect_to', true);
							$response = the_champ_user_auth($profileData, 'kakao', $kakaoRedirectUrl);
							if($response == 'show form'){
								return;
							}
							if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
								$redirectTo = the_champ_get_login_redirection_url($kakaoRedirectUrl, true);
							}elseif(isset($response['message']) && $response['message'] == 'linked'){
								$redirectTo = $kakaoRedirectUrl . (strpos($kakaoRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
							}elseif(isset($response['message']) && $response['message'] == 'not linked'){
								$redirectTo = $kakaoRedirectUrl . (strpos($kakaoRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
							}elseif(isset($response['url']) && $response['url'] != ''){
								$redirectTo = $response['url'];
							}else{
								$redirectTo = the_champ_get_login_redirection_url($kakaoRedirectUrl);
							}
							the_champ_close_login_popup($redirectTo);
						}		
					}
		 		}
			}
		}elseif(remove_query_arg(array('code','state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Github'){
		 	$postData = array(
				'state' => 'state',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Github",
				'client_id' => $theChampLoginOptions['github_client_id'],
				'client_secret' => $theChampLoginOptions['github_client_secret']
			);
			$response = wp_remote_post("https://github.com/login/oauth/access_token", array(
				'method' => 'POST',
				'timeout' => 15,
				'redirection' => 5,
				'httpversion' => '1.0',
				'sslverify' => false,
				'headers' => array('Content-Type' => 'application/x-www-form-urlencoded', 'Authorization' => 'Basic ' . base64_encode($theChampLoginOptions['github_client_id'] . ':' . $theChampLoginOptions['github_client_secret'])),
				'body' => $postData
			    )
			);

			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = wp_remote_retrieve_body($response);
				$bodyParts = explode('&', $body);
				$accessTokenParts = explode('=', $bodyParts[0]);
				
				if(count($accessTokenParts) == 2){
					$authorization = "token ".$accessTokenParts[1];
					$response = wp_remote_get('https://api.github.com/user',  array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json' , 'Authorization' => $authorization)));
					if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
						$profileData = json_decode(wp_remote_retrieve_body($response));
						if(is_object($profileData) && isset($profileData->id)){
							$emailsResponse = wp_remote_get('https://api.github.com/user/public_emails',  array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json' , 'Authorization' => $authorization)));
							if(!is_wp_error($emailsResponse) && isset($emailsResponse['response']['code']) && 200 === $emailsResponse['response']['code']){
								$emails = json_decode(wp_remote_retrieve_body($emailsResponse ));
								if(is_array($emails)){
									foreach($emails as $email){
										if(isset($email->primary) && isset($email->verified) && $email->primary == 'true' && $email->verified == 'true' && !empty($email->email)){
											$profileData = (array)$profileData;
											$profileData['email'] = $email->email;
											$profileData = (object)$profileData;
											break;
										}
									}
								}
							}
							$profileData         = the_champ_sanitize_profile_data($profileData, 'github');
							$githubLoginState    = sanitize_text_field($_GET['state']);
							$githubRedirectUrl   = get_user_meta($githubLoginState, 'super_socializer_redirect_to', true);
							$response = the_champ_user_auth($profileData, 'github', $githubRedirectUrl);
							if($response == 'show form'){
								return;
							}
							if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
								$redirectTo = the_champ_get_login_redirection_url($githubRedirectUrl, true);
							}elseif(isset($response['message']) && $response['message'] == 'linked'){
								$redirectTo = $githubRedirectUrl . (strpos($githubRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
							}elseif(isset($response['message']) && $response['message'] == 'not linked'){
								$redirectTo = $githubRedirectUrl . (strpos($githublRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
							}elseif(isset($response['url']) && $response['url'] != ''){
								$redirectTo = $response['url'];
							}else{
								$redirectTo = the_champ_get_login_redirection_url($githubRedirectUrl);
							}
							the_champ_close_login_popup($redirectTo);
						}			
					}
		 		}
			}
		}elseif(remove_query_arg(array('code','scope', 'state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Amazon'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Amazon",
				'client_id' => $theChampLoginOptions['amazon_client_id'],
				'client_secret' => $theChampLoginOptions['amazon_client_secret']
			);
			$response = wp_remote_post("https://api.amazon.com/auth/o2/token", array(
				'method' => 'POST',
				'timeout' => 15,
				'redirection' => 5,
				'httpversion' => '1.0',
				'sslverify' => false,
				'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
				'body' => http_build_query($postData)
			    )
			);
			
			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
				$body = json_decode(wp_remote_retrieve_body($response));
				$authorization = "Bearer ".$body->access_token;
				$response = wp_remote_get("https://api.amazon.com/user/profile",  array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json' , 'Authorization' => $authorization )));
				if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
					
					$profileData = json_decode(wp_remote_retrieve_body($response));
					if(is_object($profileData) && isset($profileData->user_id)){
						$profileData        = the_champ_sanitize_profile_data($profileData, 'amazon');
						$amazonLoginState   = sanitize_text_field($_GET['state']);
						$amazonRedirectUrl  = get_user_meta($amazonLoginState, 'super_socializer_redirect_to', true);
						$response = the_champ_user_auth($profileData, 'amazon', $amazonRedirectUrl);
						if($response == 'show form'){
							return;
						}
						if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
							$redirectTo = the_champ_get_login_redirection_url($amazonRedirectUrl, true);
						}elseif(isset($response['message']) && $response['message'] == 'linked'){
							$redirectTo = $amazonRedirectUrl . (strpos($amazonRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
						}elseif(isset($response['message']) && $response['message'] == 'not linked'){
							$redirectTo = $amazonRedirectUrl . (strpos($amazonRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
						}elseif(isset($response['url']) && $response['url'] != ''){
							$redirectTo = $response['url'];
						}else{
							$redirectTo = the_champ_get_login_redirection_url($amazonRedirectUrl);
						}
						the_champ_close_login_popup($redirectTo);
					}			
				}
	 		}
		}elseif(remove_query_arg(array('code','state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Twitter'){
            $postData = array(
    			'grant_type' => 'authorization_code',
    			'code' => sanitize_text_field($_GET['code']),
    			'redirect_uri' => home_url()."/SuperSocializerAuth/Twitter",
    			'client_id' => $theChampLoginOptions['twitter_key'],
    			'code_verifier' => 'challenge'
    		);
    		$auth = base64_encode($theChampLoginOptions['twitter_key']. ":" .$theChampLoginOptions['twitter_secret']);
    		$response = wp_remote_post("https://api.twitter.com/2/oauth2/token", array(
        			'method' => 'POST',
        			'timeout' => 15,
        			'redirection' => 5,
        			'httpversion' => '1.0',
        			'sslverify' => false,
        			'headers' => array(
        			    'Content-Type' => 'application/x-www-form-urlencoded',
    					'User-Agent' => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36",
    					'Authorization' => "Basic $auth"
        			),
        			'body' => http_build_query($postData)
    		    )
    		);
    		if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
    			$body = json_decode(wp_remote_retrieve_body($response));
    			$authorization = "Bearer ".$body->access_token;
    			$response = wp_remote_get("https://api.twitter.com/2/users/me?user.fields=profile_image_url,url,description",  array('timeout' => 15, 'headers' =>  array('Accept' => 'application/json' , 'Authorization' => $authorization )));
    			if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
    				$profileData = json_decode(wp_remote_retrieve_body($response));
    				if(is_object($profileData) && isset($profileData->data) && isset($profileData->data->id)){
    					$profileData         = the_champ_sanitize_profile_data($profileData->data, 'twitter');
    					$twitterLoginState   = sanitize_text_field($_GET['state']);
    					$twitterRedirectUrl  = get_user_meta($twitterLoginState, 'super_socializer_redirect_to', true);
    					$response 			 = the_champ_user_auth($profileData, 'twitter', $twitterRedirectUrl);
    					if($response == 'show form'){
    						return;
    					}
    					if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
    						$redirectTo = the_champ_get_login_redirection_url($twitterRedirectUrl, true);
    					}elseif(isset($response['message']) && $response['message'] == 'linked'){
    						$redirectTo = $twitterRedirectUrl . (strpos($twitterRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
    					}elseif(isset($response['message']) && $response['message'] == 'not linked'){
    						$redirectTo = $twitterRedirectUrl . (strpos($twitterRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
    					}elseif(isset($response['url']) && $response['url'] != ''){
    						$redirectTo = $response['url'];
    					}else{
    						$redirectTo = the_champ_get_login_redirection_url($twitterRedirectUrl);
    					}
    					the_champ_close_login_popup($redirectTo);
    				}			
    			}
     		}
    	}elseif(remove_query_arg(array('code','scope','state'), esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])) == home_url().'/SuperSocializerAuth/Stackoverflow'){
		 	$postData = array(
				'grant_type' => 'authorization_code',
				'code' => sanitize_text_field($_GET['code']),
				'redirect_uri' => home_url()."/SuperSocializerAuth/Stackoverflow",
				'client_id' => $theChampLoginOptions['stackoverflow_client_id'],
				'client_secret' => $theChampLoginOptions['stackoverflow_client_secret']
			);
			$response = wp_remote_post("https://stackexchange.com/oauth/access_token", array(
		        'method' => 'POST',
		        'timeout' => 15,
		        'redirection' => 5,
		        'httpversion' => '1.0',
		        'sslverify' => false,
		        'headers' => array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => 'Basic ' .base64_encode($theChampLoginOptions['stackoverflow_client_id']. ':' .$theChampLoginOptions['stackoverflow_client_secret']) 
				),
		        'body' => http_build_query($postData) 
		    ));
		    
		    if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
		        $body     =  wp_remote_retrieve_body($response);
		        $k 		  = explode('&', $body);
		        $r  	  = explode('=', $k[0]);
		        $response = wp_remote_get("https://api.stackexchange.com/2.2/me?site=stackoverflow&access_token=".$r[1]."&key=".$theChampLoginOptions['stackoverflow_key'], array(
		            'timeout' => 15,
		            'headers' => array('content-type' =>'application/json')
		        ));
				if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
					$profileData = json_decode(wp_remote_retrieve_body($response));
					if(is_object($profileData) && isset($profileData->items[0]->account_id)){
						$profileData                      = the_champ_sanitize_profile_data($profileData->items[0], 'stackoverflow');
						$stackoverflowLoginState          = sanitize_text_field($_GET['state']);
						$stackoverflowRedirectUrl         = get_user_meta($stackoverflowLoginState, 'super_socializer_redirect_to', true);
						$response = the_champ_user_auth($profileData, 'stackoverflow', $stackoverflowRedirectUrl);
						if($response == 'show form'){
							return;
						}
						if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
							$redirectTo = the_champ_get_login_redirection_url($stackoverflowRedirectUrl, true);
						}elseif(isset($response['message']) && $response['message'] == 'linked'){
							$redirectTo = $stackoverflowRedirectUrl . (strpos($stackoverflowRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
						}elseif(isset($response['message']) && $response['message'] == 'not linked'){
							$redirectTo = $stackoverflowRedirectUrl . (strpos($stackoverflowRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
						}elseif(isset($response['url']) && $response['url'] != ''){
							$redirectTo = $response['url'];
						}else{
							$redirectTo = the_champ_get_login_redirection_url($stackoverflowRedirectUrl);
						}
						the_champ_close_login_popup($redirectTo);
					}			
				}
			}
		}
	
		// Google
        $postData = array(
            'grant_type' => 'authorization_code',
            'code' => sanitize_text_field($_GET['code']),
            'redirect_uri' => home_url(),
            'client_id' => $theChampLoginOptions['google_key'],
            'client_secret' => $theChampLoginOptions['google_secret']
        );
        $response  = wp_remote_post("https://accounts.google.com/o/oauth2/token", array(
            'method' => 'POST',
            'timeout' => 15,
            'redirection' => 5,
            'httpversion' => '1.0',
            'sslverify' => false,
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded'
            ),
            'body' => http_build_query($postData)
        ));
        if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
            $body = json_decode(wp_remote_retrieve_body($response));
            if(isset($body->access_token)){
            	$googleLoginState = sanitize_text_field($_GET['state']);
            	$network          = get_user_meta($googleLoginState, 'super_socializer_temp_network', true);
            	if($network == 'Google'){
            		$api = 'https://www.googleapis.com/oauth2/v3/userinfo';
            	}else{
            		$api = 'https://youtube.googleapis.com/youtube/v3/channels?part=snippet%2CcontentDetails%2Cstatistics&mine=true&key='. $theChampLoginOptions['youtube_key'];
            	}
                $authorization = "Bearer " . $body->access_token;
                $response      = wp_remote_get($api, array(
                    'timeout' => 15,
                    'headers' => array(
                        'Accept' => 'application/json',
                        'Authorization' => $authorization
                    )
                ));
                if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
                    $profileData = json_decode(wp_remote_retrieve_body($response));
                    if($network == 'Youtube'){
		                $authorization = "Bearer " . $body->access_token;
		                $response      = wp_remote_get('https://www.googleapis.com/oauth2/v3/userinfo', array(
		                    'timeout' => 15,
		                    'headers' => array(
		                        'Accept' => 'application/json',
		                        'Authorization' => $authorization
		                    )
		                ));
		                if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
		                    $emailProfileData = json_decode(wp_remote_retrieve_body($response));
		                    if(is_object($emailProfileData) && isset($emailProfileData->email_verified) && $emailProfileData->email_verified == 1 && isset($emailProfileData->email)){
		                    	$profileData = (array) $profileData;
		                    	$profileData['email'] = $emailProfileData->email;
		                    	$profileData = (object) $profileData;
		                    }
		                }
                    }
                    if(is_object($profileData) && (($network == 'Google' && isset($profileData->sub)) || ($network == 'Youtube' && isset($profileData->etag) || (isset($profileData->items) && is_array($profileData->items) && isset($profileData->items[0]) && isset($profileData->items[0]->id))))){
                        $profileData           = the_champ_sanitize_profile_data($profileData, strtolower($network));
	                    $googleRedirectUrl     = get_user_meta($googleLoginState, 'super_socializer_redirect_to', true);
                        $response 			   = the_champ_user_auth($profileData, strtolower($network), $googleRedirectUrl);
                        if($response == 'show form'){
                            return;
                        }
                        if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
                            $redirectTo = the_champ_get_login_redirection_url($googleRedirectUrl, true);
                        }elseif(isset($response['message']) && $response['message'] == 'linked'){
                            $redirectTo = $googleRedirectUrl . (strpos($googleRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
                        }elseif(isset($response['message']) && $response['message'] == 'not linked'){
                            $redirectTo = $googleRedirectUrl . (strpos($googleRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
                        }elseif(isset($response['url']) && $response['url'] != ''){
                            $redirectTo = $response['url'];
                        }else{
                            $redirectTo = the_champ_get_login_redirection_url($googleRedirectUrl);
                        }
                        the_champ_close_login_popup($redirectTo);
                    }
                }
            }
        }
    }

	if(isset($_GET['code']) && !isset($_GET['SuperSocializerAuth'])){
		if(function_exists('session_start')){
			if(session_status() == PHP_SESSION_NONE){
				session_start();
			}
		}
		require 'library/Vkontakte/Vkontakte.php';
		$heateorSsVkontakte = new Vkontakte(array(
		    'client_id' => $theChampLoginOptions['vk_key'],
		    'client_secret' => $theChampLoginOptions['vk_secure_key'],
		    'redirect_uri' => home_url()
		));
		$heateorSsVkontakte->setScope(array('email'));
		if(isset($heateorSsVkontakte)){
			$heateorSsVkontakte->authenticate($_GET['code']);
			$userId = $heateorSsVkontakte->getUserId();
			$email = $heateorSsVkontakte->getUserEmail();
			if($userId){
				$users = $heateorSsVkontakte->api('users.get', array(
				    'user_id' => $userId,
				    'fields' => array('first_name','last_name','nickname','screen_name','photo_rec','photo_big')
				));
				if(isset($users[0]) && isset($users[0]["id"]) && $users[0]["id"]){
					$profileData = the_champ_sanitize_profile_data($users[0], 'vkontakte');
					$profileData['email'] = '';
					if($email){
						$profileData['email'] = sanitize_email($email);
					}
					if(isset($_GET['heateorMSEnabled'])){
						$profileData['mc_subscribe'] = 1;
					}
					if(function_exists('session_start')){
						if(session_status() == PHP_SESSION_NONE){
							session_start();
						}
					}
					$vkontakteRedirectUrl = isset($_SESSION['super_socializer_vkontakte_redirect'])  && $_SESSION['super_socializer_vkontakte_redirect'] ? esc_url(trim($_SESSION['super_socializer_vkontakte_redirect'])) : home_url();
					$response = the_champ_user_auth($profileData, 'vkontakte', $vkontakteRedirectUrl);
					if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
						$redirectTo = the_champ_get_login_redirection_url($vkontakteRedirectUrl, true);
					}elseif(isset($response['message']) && $response['message'] == 'linked'){
						$redirectTo = $vkontakteRedirectUrl.(strpos($vkontakteRedirectUrl, '?') !== false ? '&' : '?').'linked=1';
					}elseif(isset($response['message']) && $response['message'] == 'not linked'){
						$redirectTo = $vkontakteRedirectUrl.(strpos($vkontakteRedirectUrl, '?') !== false ? '&' : '?').'linked=0';
					}elseif(isset($response['url']) && $response['url'] != ''){
						$redirectTo = $response['url'];
					}else{
						$redirectTo = the_champ_get_login_redirection_url($vkontakteRedirectUrl);
					}
					the_champ_close_login_popup($redirectTo);
				}
			}
		}
	}
	// twitter authentication
	if(isset($_REQUEST['oauth_token']) && isset($_REQUEST['oauth_verifier'])){
		global $wpdb;
		$uniqueId = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'thechamp_twitter_oauthtoken' and meta_value = %s", sanitize_text_field($_REQUEST['oauth_token'])));
		$oauthTokenSecret = get_user_meta($uniqueId, 'thechamp_twitter_oauthtokensecret', true);
		// twitter redirect url
		$twitterRedirectUrl = get_user_meta($uniqueId, 'thechamp_twitter_redirect', true);
		if(empty($uniqueId) || $oauthTokenSecret == ''){
			// invalid request
			wp_redirect(esc_url(home_url()));
			die;
		}
		$connection = new Abraham\TwitterOAuth\TwitterOAuth($theChampLoginOptions['twitter_key'], $theChampLoginOptions['twitter_secret'], $_REQUEST['oauth_token'], $oauthTokenSecret);
		/* Request access tokens from twitter */
		$accessToken = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
		/* Create a TwitterOauth object with consumer/user tokens. */
		$connection = new Abraham\TwitterOAuth\TwitterOAuth($theChampLoginOptions['twitter_key'], $theChampLoginOptions['twitter_secret'], $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
		$content = $connection->get('account/verify_credentials', array('include_email' => 'true'));
		// delete temporary data
		delete_user_meta($uniqueId, 'thechamp_twitter_oauthtokensecret');
		delete_user_meta($uniqueId, 'thechamp_twitter_oauthtoken');
		delete_user_meta($uniqueId, 'thechamp_twitter_redirect');
		if(is_object($content) && isset($content->id)){
			$profileData = the_champ_sanitize_profile_data($content, 'twitter');
			if(get_user_meta($uniqueId, 'thechamp_mc_subscribe', true) != ''){
				$profileData['mc_subscribe'] = 1;
			}
			delete_user_meta($uniqueId, 'thechamp_mc_subscribe');
			$response = the_champ_user_auth($profileData, 'twitter', $twitterRedirectUrl);
			if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
				$redirectTo = the_champ_get_login_redirection_url($twitterRedirectUrl, true);
			}elseif(isset($response['message']) && $response['message'] == 'linked'){
				$redirectTo = $twitterRedirectUrl.(strpos($twitterRedirectUrl, '?') !== false ? '&' : '?').'linked=1';
			}elseif(isset($response['message']) && $response['message'] == 'not linked'){
				$redirectTo = $twitterRedirectUrl.(strpos($twitterRedirectUrl, '?') !== false ? '&' : '?').'linked=0';
			}elseif(isset($response['url']) && $response['url'] != ''){
				$redirectTo = $response['url'];
			}else{
				$redirectTo = the_champ_get_login_redirection_url($twitterRedirectUrl);
			}
			the_champ_close_login_popup($redirectTo);
		}
	}
}

/**
 * Close Social Login popup
 */
function the_champ_close_login_popup($redirectionUrl){
	global $theChampLoginOptions;
	if(isset($theChampLoginOptions['same_tab_login'])){
		wp_redirect($redirectionUrl);
		die;
		return;
	}
	?>
	<script>
	if(window.opener){
		window.opener.location.href="<?php echo esc_url_raw($redirectionUrl); ?>";
		window.close();
	}else{
		window.location.href="<?php echo esc_url_raw($redirectionUrl); ?>";
	}
	</script>
	<?php
	die;
}

/**
 * Validate url
 */
function the_champ_validate_url($url){
	$expression = "/^(http:\/\/|https:\/\/|ftp:\/\/|ftps:\/\/|)?[a-z0-9_\-]+[a-z0-9_\-\.]+\.[a-z]{2,4}(\/+[a-z0-9_\.\-\/]*)?$/i";
    return (bool)preg_match($expression, $url);
}

/**
 * Get http/https protocol at the website
 */
function the_champ_get_http(){
	if(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
		return "https://";
	}else{
		return "http://";
	}
}

/**
 * Return valid redirection url
 */
function the_champ_get_valid_url($url){
	$decodedUrl = urldecode($url);
	if(esc_url_raw(remove_query_arg(array('ss_message', 'SuperSocializerVerified', 'SuperSocializerUnverified', 'wp_lang', 'loggedout', 'heateor_ua', 'hum'), $decodedUrl)) == wp_login_url() || $decodedUrl == home_url().'/wp-login.php?action=register'){ 
		$url = esc_url(home_url()).'/';
	}elseif(isset($_GET['redirect_to'])){
		$redirectTo = esc_url($_GET['redirect_to']);
		if(urldecode($redirectTo) == admin_url()){
			$url = esc_url(home_url()).'/';
		}elseif(the_champ_validate_url(urldecode($redirectTo)) && (strpos(urldecode($redirectTo), 'http://') !== false || strpos(urldecode($redirectTo), 'https://') !== false)){
			$url = $redirectTo;
		}else{
			$url = esc_url(home_url()).'/';
		}
	}
	return $url;
}

/**
 * Return webpage url to redirect after login
 */
function the_champ_get_login_redirection_url($twitterRedirect = '', $register = false){
	global $theChampLoginOptions, $user_ID;
	if($register){
		$option = 'register';
	}else{
		$option = 'login';
	}
	$redirectionUrl = esc_url(home_url());
	if(isset($theChampLoginOptions[$option.'_redirection'])){
		if($theChampLoginOptions[$option.'_redirection'] == 'same'){
			$http = the_champ_get_http();
			if($twitterRedirect != ''){
				$url = $twitterRedirect;
			}else{
				$url = esc_url_raw($http.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
			}
			$redirectionUrl = the_champ_get_valid_url($url);
		}elseif($theChampLoginOptions[$option.'_redirection'] == 'homepage'){
			$redirectionUrl = esc_url(home_url());
		}elseif($theChampLoginOptions[$option.'_redirection'] == 'account'){
			$redirectionUrl = admin_url();
		}elseif($theChampLoginOptions[$option.'_redirection'] == 'custom' && $theChampLoginOptions[$option.'_redirection_url'] != ''){
			$redirectionUrl = esc_url($theChampLoginOptions[$option.'_redirection_url']);
		}elseif($theChampLoginOptions[$option.'_redirection'] == 'bp_profile' && $user_ID != 0){
			$redirectionUrl = function_exists('bp_core_get_user_domain') ? bp_core_get_user_domain($user_ID) : admin_url();
		}
	}
	$redirectionUrl = apply_filters('heateor_ss_login_redirection_url_filter', $redirectionUrl, $theChampLoginOptions, $user_ID, $twitterRedirect, $register);

	return $redirectionUrl;
}

/**
 * The javascript to load at front end
 */
function the_champ_frontend_scripts(){
	global $theChampFacebookOptions, $theChampLoginOptions, $theChampSharingOptions, $theChampGeneralOptions;
	$inFooter = isset($theChampGeneralOptions['footer_script']) ? true : false;
	$combinedScript = isset($theChampGeneralOptions['combined_script']) ? true : false;
	?>
	<script type="text/javascript">var theChampDefaultLang = '<?php echo esc_js(get_locale()); ?>', theChampCloseIconPath = '<?php echo plugins_url('images/close.png', __FILE__) ?>';</script>
	<?php
	if(!$combinedScript){
		wp_enqueue_script('the_champ_ss_general_scripts', plugins_url('js/front/social_login/general.js', __FILE__), false, THE_CHAMP_SS_VERSION, $inFooter);
	}
	$websiteUrl = esc_url(home_url());
	$fbKey = isset($theChampLoginOptions["fb_key"]) && $theChampLoginOptions["fb_key"] != "" ? $theChampLoginOptions["fb_key"] : "";
	$userVerified = false;
	$emailPopup = false;
	$moreSharePopupPlaceholderSearch = __('Search', 'super-socializer');
	?>
	<script>var theChampSiteUrl = '<?php echo esc_js(strtok($websiteUrl, "?")); ?>', theChampVerified = <?php echo esc_js(intval($userVerified)) ?>, theChampEmailPopup = <?php echo esc_js(intval($emailPopup)); ?>, heateorSsMoreSharePopupSearchText = '<?php echo esc_js(htmlspecialchars($moreSharePopupPlaceholderSearch, ENT_QUOTES)); ?>';</script>
	<?php
	// scripts used for common Social Login functionality
	if(the_champ_social_login_enabled() && !is_user_logged_in()){
		$loadingImagePath = plugins_url('images/ajax_loader.gif', __FILE__);
		$theChampAjaxUrl = get_admin_url().'admin-ajax.php';
		$redirectionUrl = the_champ_get_login_redirection_url();
		$regRedirectionUrl = the_champ_get_login_redirection_url('', true);
		?>
		<script>var theChampLoadingImgPath = '<?php echo esc_js($loadingImagePath) ?>'; var theChampAjaxUrl = '<?php echo esc_js($theChampAjaxUrl) ?>'; var theChampRedirectionUrl = '<?php echo esc_url_raw($redirectionUrl) ?>'; var theChampRegRedirectionUrl = '<?php echo esc_url_raw($regRedirectionUrl) ?>'; </script>
		<?php
		$ajaxUrl = 'admin-ajax.php';
		$notification = '';
		if(isset($_GET['SuperSocializerVerified']) || isset($_GET['SuperSocializerUnverified'])){
			$userVerified = true;
			$ajaxUrl = add_query_arg( 
				array(
					'height' => 60,
					'width' => 300,
					'action' => 'the_champ_notify',
					'message' => isset($_GET['SuperSocializerUnverified']) ? __('Please verify your email address to login.', 'super-socializer') : __('Your email has been verified. Now you can login to your account', 'super-socializer')
				), 
				'admin-ajax.php'
			);
			$notification = __('Notification', 'super-socializer');
		}
		
		$emailAjaxUrl = 'admin-ajax.php';
		$emailPopupTitle = '';
		$emailPopupErrorMessage = '';
		$emailPopupUniqueId = '';
		$emailPopupVerifyMessage = '';
		if(isset($_GET['SuperSocializerEmail']) && isset($_GET['par']) && trim($_GET['par']) != ''){
			$emailPopup = true;
			$emailAjaxUrl = add_query_arg( 
				array(
					'height' => isset($theChampLoginOptions['popup_height']) && $theChampLoginOptions['popup_height'] != '' ? esc_attr($theChampLoginOptions['popup_height']) : 210,
					'width' => 300,
					'action' => 'the_champ_ask_email'
				), 
				'admin-ajax.php'
			);
			$emailPopupTitle = __('Email required', 'super-socializer');
			$emailPopupErrorMessage = isset($theChampLoginOptions["email_error_message"]) ? $theChampLoginOptions["email_error_message"] : "";
			$emailPopupUniqueId = isset($_GET['par']) ? sanitize_text_field($_GET['par']) : '';
			$emailPopupVerifyMessage = __('Please check your email inbox to complete the registration.', 'super-socializer');
		}
		global $theChampSteamLogin;
		$twitterRedirect = urlencode(the_champ_get_valid_url(esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])));
		$currentPageUrl = urldecode($twitterRedirect);
		?>
		<script> var theChampFBKey = '<?php echo esc_js($fbKey) ?>', theChampSameTabLogin = '<?php echo isset($theChampLoginOptions["same_tab_login"]) ? 1 : 0; ?>', theChampVerified = <?php echo intval($userVerified) ?>; var theChampAjaxUrl = '<?php echo esc_js(admin_url().$ajaxUrl) ?>'; var theChampPopupTitle = '<?php echo esc_js($notification); ?>'; var theChampEmailPopup = <?php echo intval($emailPopup); ?>; var theChampEmailAjaxUrl = '<?php echo admin_url().$emailAjaxUrl; ?>'; var theChampEmailPopupTitle = '<?php echo esc_js($emailPopupTitle); ?>'; var theChampEmailPopupErrorMsg = '<?php echo esc_js(htmlspecialchars($emailPopupErrorMessage, ENT_QUOTES)); ?>'; var theChampEmailPopupUniqueId = '<?php echo esc_js($emailPopupUniqueId); ?>'; var theChampEmailPopupVerifyMessage = '<?php echo esc_js($emailPopupVerifyMessage); ?>'; var theChampSteamAuthUrl = "<?php echo $theChampSteamLogin ? esc_url_raw($theChampSteamLogin->url( esc_url(home_url()).'?SuperSocializerSteamAuth='.$twitterRedirect )) : ''; ?>"; var theChampCurrentPageUrl = '<?php echo esc_js($twitterRedirect) ?>'; <?php echo isset($theChampLoginOptions['disable_reg']) && isset($theChampLoginOptions['disable_reg_redirect']) && $theChampLoginOptions['disable_reg_redirect'] != '' ? 'var theChampDisableRegRedirect = "'.esc_url_raw($theChampLoginOptions['disable_reg_redirect']).'";' : ''; ?> var heateorMSEnabled = 0, theChampTwitterAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Twitter&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampLineAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Line&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampLiveAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Live&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampFacebookAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Facebook&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampYahooAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Yahoo&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampGoogleAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Google&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampYoutubeAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Youtube&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampVkontakteAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Vkontakte&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampLinkedinAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Linkedin&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampInstagramAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Instagram&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampWordpressAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Wordpress&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampDribbbleAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Dribbble&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampGithubAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Github&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampSpotifyAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Spotify&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampKakaoAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Kakao&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampTwitchAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Twitch&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampRedditAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Reddit&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampDisqusAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Disqus&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampDropboxAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Dropbox&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampFoursquareAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Foursquare&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampAmazonAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Amazon&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampStackoverflowAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Stackoverflow&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampDiscordAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Discord&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampMailruAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Mailru&super_socializer_redirect_to=" + theChampCurrentPageUrl, theChampYandexAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Yandex&super_socializer_redirect_to=" + theChampCurrentPageUrl; theChampOdnoklassnikiAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Odnoklassniki&super_socializer_redirect_to=" + theChampCurrentPageUrl;</script>
		<?php
		if(!$combinedScript){
			wp_enqueue_script('the_champ_sl_common', plugins_url('js/front/social_login/common.js', __FILE__), array('jquery'), THE_CHAMP_SS_VERSION, $inFooter);
		}
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
	}
	// Facebook scripts
	if(the_champ_facebook_plugin_enabled()){
		?>
		<script> var theChampFBKey = '<?php echo esc_js($fbKey) ?>', theChampFBLang = '<?php echo (isset($theChampFacebookOptions["comment_lang"]) && $theChampFacebookOptions["comment_lang"] != '') ? esc_js($theChampFacebookOptions["comment_lang"]) : esc_js(get_locale()) ?>', theChampFbLikeMycred = <?php echo defined('HEATEOR_SOCIAL_SHARE_MYCRED_INTEGRATION_VERSION') && the_champ_facebook_like_rec_enabled() ? 1 : 0 ?>, theChampSsga = <?php echo defined('HEATEOR_SHARING_GOOGLE_ANALYTICS_VERSION') ? 1 : 0 ?>, theChampCommentNotification = <?php echo (defined('HEATEOR_FB_COM_NOT_VERSION') && version_compare('1.1.4', HEATEOR_FB_COM_NOT_VERSION) > 0) || function_exists('heateor_ss_check_querystring') || function_exists('the_champ_check_querystring') ? 1 : 0; ?>, theChampHeateorFcmRecentComments = <?php echo defined('HEATEOR_FB_COM_MOD_VERSION') && HEATEOR_FB_COM_MOD_VERSION == '1.1.4' ? 1 : 0 ?>, theChampFbIosLogin = <?php echo !is_user_logged_in() && isset($_GET['code']) && sanitize_text_field($_GET['code']) != '' ? 1 : 0; ?>; </script>
		<?php
		add_action('wp_footer', 'the_champ_fb_root_div');
		if(!$combinedScript){
			wp_enqueue_script('the_champ_fb_sdk', plugins_url('js/front/facebook/sdk.js', __FILE__), false, THE_CHAMP_SS_VERSION, $inFooter);
		}
	}
	
	// Social commenting
	if(the_champ_social_commenting_enabled()){
		global $post;
		if($post){
			$postMeta = get_post_meta($post->ID, '_the_champ_meta', true);
			if(isset($theChampFacebookOptions['enable_'.$post->post_type]) && !(isset($postMeta) && isset($postMeta['fb_comments']) && $postMeta['fb_comments'] == 1)){
				if(isset($theChampFacebookOptions['urlToComment']) && $theChampFacebookOptions['urlToComment'] != ''){
					$commentUrl = $theChampFacebookOptions['urlToComment'];
				}elseif(isset($post->ID) && $post->ID){
					$commentUrl = get_permalink($post->ID);
				}else{
					$commentUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
				}

				$commentingTabsOrder = ($theChampFacebookOptions['commenting_order'] != '' ? $theChampFacebookOptions['commenting_order'] : 'wordpress,facebook,disqus');
				$commentingTabsOrder = explode(',', str_replace('facebook', 'fb', $commentingTabsOrder));
				$enabledTabs = array();
				foreach($commentingTabsOrder as $tab){
					$tab = trim($tab);
					if($tab == 'wordpress'){
						$enabledTabs[] = 'wordpress';
					}elseif(isset($theChampFacebookOptions['enable_'. $tab .'comments'])){
						$enabledTabs[] = $tab;
					}
				}
				$labels = array();
				$labels['wordpress'] = $theChampFacebookOptions['label_wordpress_comments'] != '' ? htmlspecialchars($theChampFacebookOptions['label_wordpress_comments'], ENT_QUOTES) : 'Default Comments';
				$commentsCount = wp_count_comments($post->ID);
				$labels['wordpress'] .= ' ('. ($commentsCount && isset($commentsCount-> approved) ? $commentsCount-> approved : '') .')';
				$labels['fb'] = $theChampFacebookOptions['label_facebook_comments'] != '' ? htmlspecialchars($theChampFacebookOptions['label_facebook_comments'], ENT_QUOTES) : 'Facebook Comments';
				$labels['disqus'] = $theChampFacebookOptions['label_disqus_comments'] != '' ? htmlspecialchars($theChampFacebookOptions['label_disqus_comments'], ENT_QUOTES) : 'Disqus Comments';
				global $heateor_fcm_options;
				if(defined('HEATEOR_FB_COM_MOD_VERSION') && version_compare('1.2.4', HEATEOR_FB_COM_MOD_VERSION) < 0 && isset($heateor_fcm_options['gdpr_enable'])){
					?>
					<script type="text/javascript">var theChampFacebookCommentsOptinText = '<?php echo html_entity_decode(esc_js(str_replace($heateor_fcm_options['ppu_placeholder'], '<a href="'. $heateor_fcm_options['privacy_policy_url'] .'" target="_blank">'. $heateor_fcm_options['ppu_placeholder'] .'</a>', wp_strip_all_tags($heateor_fcm_options['privacy_policy_optin_text'])))) ?>';</script>
					<?php
				}
				global $heateor_fcn_options;
				if(defined('HEATEOR_FB_COM_NOT_VERSION') && version_compare('1.1.6', HEATEOR_FB_COM_NOT_VERSION) < 0 && isset($heateor_fcn_options['gdpr_enable'])){
					?>
					<script type="text/javascript">var theChampFacebookCommentsNotifierOptinText = '<?php echo html_entity_decode(esc_js(str_replace($heateor_fcn_options['ppu_placeholder'], '<a href="'. $heateor_fcn_options['privacy_policy_url'] .'" target="_blank">'. $heateor_fcn_options['ppu_placeholder'] .'</a>', wp_strip_all_tags($heateor_fcn_options['privacy_policy_optin_text'])))) ?>';</script>
					<?php
				}
				?>
				<script type="text/javascript">var theChampFBCommentUrl = '<?php echo esc_js($commentUrl) ?>'; var theChampFBCommentColor = '<?php echo (isset($theChampFacebookOptions['comment_color']) && $theChampFacebookOptions['comment_color'] != '') ? esc_js($theChampFacebookOptions["comment_color"]) : ''; ?>'; var theChampFBCommentNumPosts = '<?php echo (isset($theChampFacebookOptions['comment_numposts']) && $theChampFacebookOptions['comment_numposts'] != '') ? esc_js($theChampFacebookOptions["comment_numposts"]) : ''; ?>'; var theChampFBCommentWidth = '<?php echo (isset($theChampFacebookOptions['comment_width']) && $theChampFacebookOptions['comment_width'] != '') ? esc_js($theChampFacebookOptions["comment_width"]) : '100%'; ?>'; var theChampFBCommentOrderby = '<?php echo (isset($theChampFacebookOptions['comment_orderby']) && $theChampFacebookOptions['comment_orderby'] != '') ? esc_js($theChampFacebookOptions["comment_orderby"]) : ''; ?>'; var theChampCommentingTabs = "<?php echo isset($theChampFacebookOptions['commenting_order']) ? esc_js($theChampFacebookOptions['commenting_order']) : ''; ?>", theChampGpCommentsUrl = '<?php echo isset($theChampFacebookOptions['gpcomments_url']) && $theChampFacebookOptions['gpcomments_url'] != '' ? esc_js($theChampFacebookOptions['gpcomments_url']) : esc_js($commentUrl); ?>', theChampDisqusShortname = '<?php echo isset($theChampFacebookOptions['dq_shortname']) ? esc_js($theChampFacebookOptions['dq_shortname']) : ''; ?>', theChampScEnabledTabs = '<?php echo esc_js(implode(',', $enabledTabs)) ?>', theChampScLabel = '<?php echo $theChampFacebookOptions['commenting_label'] != '' ? esc_js(htmlspecialchars(wp_specialchars_decode($theChampFacebookOptions['commenting_label'], ENT_QUOTES), ENT_QUOTES)) : __('Leave a reply', 'super-socializer'); ?>', theChampScTabLabels = <?php echo json_encode($labels) ?>, theChampGpCommentsWidth = <?php echo isset($theChampFacebookOptions['gpcomments_width']) && $theChampFacebookOptions['gpcomments_width'] != '' ? esc_js($theChampFacebookOptions['gpcomments_width']) : 0; ?>, theChampCommentingId = '<?php echo isset($theChampFacebookOptions['commenting_id']) && $theChampFacebookOptions['commenting_id'] != '' ? esc_js($theChampFacebookOptions['commenting_id']) : 'respond' ?>'</script>
				<?php
				if(!$combinedScript){
					wp_enqueue_script('the_champ_fb_commenting', plugins_url('js/front/facebook/commenting.js', __FILE__), false, THE_CHAMP_SS_VERSION, $inFooter);
				}
			}
		}
	}
	// sharing script
	if(the_champ_social_sharing_enabled() || (the_champ_social_counter_enabled() && the_champ_vertical_social_counter_enabled())){
		global $theChampSharingOptions, $theChampCounterOptions, $theChampLoginOptions, $post;
		$fb_key = '595489497242932';
		if(isset($theChampLoginOptions['fb_key']) && $theChampLoginOptions['fb_key']){
			$fb_key = $theChampLoginOptions['fb_key'];
		}
		?>
		<script> var theChampSharingAjaxUrl = '<?php echo get_admin_url() ?>admin-ajax.php', heateorSsFbMessengerAPI = '<?php echo heateor_ss_check_if_mobile() ? "fb-messenger://share/?link=%encoded_post_url%" : "https://www.facebook.com/dialog/send?app_id=". esc_js($fb_key) ."&display=popup&link=%encoded_post_url%&redirect_uri=%encoded_post_url%"; ?>',heateorSsWhatsappShareAPI = '<?php echo esc_js(heateor_ss_whatsapp_share_api()); ?>', heateorSsUrlCountFetched = [], heateorSsSharesText = '<?php echo esc_js(htmlspecialchars(__('Shares', 'super-socializer'), ENT_QUOTES)); ?>', heateorSsShareText = '<?php echo esc_js(htmlspecialchars(__('Share', 'super-socializer'), ENT_QUOTES)); ?>', theChampPluginIconPath = '<?php echo plugins_url('images/logo.png', __FILE__) ?>', theChampSaveSharesLocally = <?php echo defined('HEATEOR_SOCIAL_SHARES_TRACKER_VERSION') ? 1 : 0; ?>, theChampHorizontalSharingCountEnable = <?php echo isset($theChampSharingOptions['enable']) && isset($theChampSharingOptions['hor_enable']) && (isset($theChampSharingOptions['horizontal_counts']) || isset($theChampSharingOptions['horizontal_total_shares'])) ? 1 : 0 ?>, theChampVerticalSharingCountEnable = <?php echo isset($theChampSharingOptions['enable']) && isset($theChampSharingOptions['vertical_enable']) && (isset($theChampSharingOptions['vertical_counts']) || isset($theChampSharingOptions['vertical_total_shares'])) ? 1 : 0 ?>, theChampSharingOffset = <?php echo (isset($theChampSharingOptions['alignment']) && $theChampSharingOptions['alignment'] != '' && isset($theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset']) && $theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset'] != '' ? esc_js($theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset']) : 0) ?>, theChampCounterOffset = <?php echo (isset($theChampCounterOptions['alignment']) && $theChampCounterOptions['alignment'] != '' && isset($theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset']) && $theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset'] != '' ? esc_js($theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset']) : 0) ?>, theChampMobileStickySharingEnabled = <?php echo isset($theChampSharingOptions['vertical_enable']) && isset($theChampSharingOptions['bottom_mobile_sharing']) && $theChampSharingOptions['horizontal_screen_width'] != '' ? 1 : 0; ?>, heateorSsCopyLinkMessage = "<?php echo esc_js(htmlspecialchars(__('Link copied.', 'super-socializer'), ENT_QUOTES)); ?>";
		<?php
		if(isset($theChampSharingOptions['horizontal_re_providers']) && (isset($theChampSharingOptions['horizontal_more']) || in_array('Copy_Link', $theChampSharingOptions['horizontal_re_providers']))){
			$postId = 0;
			$postUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
			if(isset($theChampSharingOptions['horizontal_target_url'])){
				if($theChampSharingOptions['horizontal_target_url'] == 'default'){
					if($post){
						$postUrl = get_permalink($post->ID);
						$postId = $post->ID;
					}
				}elseif($theChampSharingOptions['horizontal_target_url'] == 'home'){
					$postUrl = esc_url(home_url());
					$postId = 0;
				}elseif($theChampSharingOptions['horizontal_target_url'] == 'custom'){
					$postUrl = isset($theChampSharingOptions['horizontal_target_url_custom']) ? trim($theChampSharingOptions['horizontal_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				if($post){
					$postUrl = get_permalink($post->ID);
					$postId = $post->ID;
				}
			}
			$postUrl = heateor_ss_apply_target_share_url_filter($postUrl, 'horizontal', false);
			$sharingShortUrl = the_champ_generate_social_sharing_short_url($postUrl, $postId);
			echo 'var heateorSsHorSharingShortUrl = "'. esc_js($sharingShortUrl) .'";';
		}
		if(isset($theChampSharingOptions['vertical_re_providers']) && (isset($theChampSharingOptions['vertical_more']) || in_array('Copy_Link', $theChampSharingOptions['vertical_re_providers']))){
			$postId = 0;
			$postUrl = esc_url_raw(the_champ_get_http().$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
			if(isset($theChampSharingOptions['vertical_target_url'])){
				if($theChampSharingOptions['vertical_target_url'] == 'default'){
					if($post){
						$postUrl = get_permalink($post->ID);
						$postId = $post->ID;
					}
				}elseif($theChampSharingOptions['vertical_target_url'] == 'home'){
					$postUrl = esc_url(home_url());
					$postId = 0;
				}elseif($theChampSharingOptions['vertical_target_url'] == 'custom'){
					$postUrl = isset($theChampSharingOptions['vertical_target_url_custom']) ? trim($theChampSharingOptions['vertical_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				if($post){
					$postUrl = get_permalink($post->ID);
					$postId = $post->ID;
				}
			}
			$postUrl = heateor_ss_apply_target_share_url_filter($postUrl, 'vertical', false);
			$sharingShortUrl = the_champ_generate_social_sharing_short_url($postUrl, $postId);
			echo 'var heateorSsVerticalSharingShortUrl = "'. esc_js($sharingShortUrl) .'";';
		}
		if(isset($theChampSharingOptions['horizontal_counts']) && isset($theChampSharingOptions['horizontal_counter_position'])){
			echo in_array($theChampSharingOptions['horizontal_counter_position'], array('inner_left', 'inner_right')) ? 'var theChampReduceHorizontalSvgWidth = true;' : '';
			echo in_array($theChampSharingOptions['horizontal_counter_position'], array('inner_top', 'inner_bottom')) ? 'var theChampReduceHorizontalSvgHeight = true;' : '';
		}
		if(isset($theChampSharingOptions['vertical_counts'])){
			echo isset($theChampSharingOptions['vertical_counter_position']) && in_array($theChampSharingOptions['vertical_counter_position'], array('inner_left', 'inner_right')) ? 'var theChampReduceVerticalSvgWidth = true;' : '';
			echo !isset($theChampSharingOptions['vertical_counter_position']) || in_array($theChampSharingOptions['vertical_counter_position'], array('inner_top', 'inner_bottom')) ? 'var theChampReduceVerticalSvgHeight = true;' : '';
		}
		?>
		</script>
		<?php
		if(!$combinedScript){
			wp_enqueue_script('the_champ_share_counts', plugins_url('js/front/sharing/sharing.js', __FILE__), array('jquery'), THE_CHAMP_SS_VERSION, $inFooter);
		}
	}

	if($combinedScript){
		wp_enqueue_script('the_champ_combined_script', plugins_url('js/front/combined.js', __FILE__), array('jquery'), THE_CHAMP_SS_VERSION, $inFooter);
	}
}

/**
 * Stylesheets to load at front end
 */
function the_champ_frontend_styles(){
	global $theChampSharingOptions, $theChampGeneralOptions, $theChampLoginOptions, $theChampCounterOptions;
	?>
	<style type="text/css">
			<?php
		if ( isset($theChampSharingOptions['plain_instagram_bg'] ) ){
			?>
			.the_champ_button_instagram span.the_champ_svg{background-color:#527fa4}
			<?php
		} else {
			?>
			.the_champ_button_instagram span.the_champ_svg,a.the_champ_instagram span.the_champ_svg{background:radial-gradient(circle at 30% 107%,#fdf497 0,#fdf497 5%,#fd5949 45%,#d6249f 60%,#285aeb 90%)}
			<?php
		} 
		?>
		.the_champ_horizontal_sharing .the_champ_svg,.heateor_ss_standard_follow_icons_container .the_champ_svg{
		<?php if($theChampSharingOptions['horizontal_bg_color_default'] != ''){ ?>
			background-color:<?php echo esc_html($theChampSharingOptions['horizontal_bg_color_default']) ?>!important;background:<?php echo esc_html($theChampSharingOptions['horizontal_bg_color_default']) ?>!important;
		<?php  } ?>
			color: <?php echo $theChampSharingOptions['horizontal_font_color_default'] ? esc_html($theChampSharingOptions['horizontal_font_color_default']) : '#fff' ?>;
		<?php
		$border_width = 0;
		if($theChampSharingOptions['horizontal_border_width_default'] != ''){
			$border_width = $theChampSharingOptions['horizontal_border_width_default'];
		}elseif($theChampSharingOptions['horizontal_border_width_hover'] != ''){
			$border_width = $theChampSharingOptions['horizontal_border_width_hover'];
		}
		?>
		border-width: <?php echo esc_html($border_width) ?>px;
		border-style: solid;
		border-color: <?php echo $theChampSharingOptions['horizontal_border_color_default'] != '' ? esc_html($theChampSharingOptions['horizontal_border_color_default']) : 'transparent'; ?>;
	}
	<?php if($theChampSharingOptions['horizontal_font_color_default'] == ''){ ?>
	.the_champ_horizontal_sharing .theChampTCBackground{
		color:#666;
	}
	<?php } ?>
	.the_champ_horizontal_sharing span.the_champ_svg:hover,.heateor_ss_standard_follow_icons_container span.the_champ_svg:hover{
		<?php if($theChampSharingOptions['horizontal_bg_color_hover'] != ''){ ?>
			background-color:<?php echo esc_html($theChampSharingOptions['horizontal_bg_color_hover']) ?>!important;background:<?php echo esc_html($theChampSharingOptions['horizontal_bg_color_hover']) ?>;
		<?php }
		 ?>
		border-color: <?php echo $theChampSharingOptions['horizontal_border_color_hover'] != '' ? esc_html($theChampSharingOptions['horizontal_border_color_hover']) : 'transparent'; ?>;
	}
	<?php 
	if($theChampSharingOptions['horizontal_font_color_hover'] != ''){ ?> div.the_champ_horizontal_sharing span.the_champ_svg svg:hover path:not(.the_champ_no_fill),div.the_champ_horizontal_sharing span.the_champ_svg svg:hover ellipse, div.the_champ_horizontal_sharing span.the_champ_svg svg:hover circle, div.the_champ_horizontal_sharing span.the_champ_svg svg:hover polygon, div.the_champ_horizontal_sharing span.the_champ_svg svg:hover rect:not(.the_champ_no_fill){
		        fill: <?php echo esc_html($theChampSharingOptions['horizontal_font_color_hover']) ?>;
		    }
		    div.the_champ_horizontal_sharing span.the_champ_svg svg:hover path.the_champ_svg_stroke, div.the_champ_horizontal_sharing span.the_champ_svg svg:hover rect.the_champ_svg_stroke{
		    	stroke: <?php echo esc_html($theChampSharingOptions['horizontal_font_color_hover']) ?>;
		    }
		<?php } ?>
	.the_champ_vertical_sharing span.the_champ_svg,.heateor_ss_floating_follow_icons_container span.the_champ_svg{
		<?php if($theChampSharingOptions['vertical_bg_color_default'] != ''){ ?>
			background-color: <?php echo esc_html($theChampSharingOptions['vertical_bg_color_default']) ?>!important;background:<?php echo esc_html($theChampSharingOptions['vertical_bg_color_default']) ?>!important;
		<?php } ?>
			color: <?php echo $theChampSharingOptions['vertical_font_color_default'] ? esc_html($theChampSharingOptions['vertical_font_color_default']) : '#fff' ?>;
		<?php
		$verticalBorderWidth = 0;
		if($theChampSharingOptions['vertical_border_width_default'] != ''){
			$verticalBorderWidth = $theChampSharingOptions['vertical_border_width_default'];
		}elseif($theChampSharingOptions['vertical_border_width_hover'] != ''){
			$verticalBorderWidth = $theChampSharingOptions['vertical_border_width_hover'];
		}
		?>
		border-width: <?php echo esc_html($verticalBorderWidth) ?>px;
		border-style: solid;
		border-color: <?php echo $theChampSharingOptions['vertical_border_color_default'] != '' ? esc_html($theChampSharingOptions['vertical_border_color_default']) : 'transparent'; ?>;
	}
	<?php if($theChampSharingOptions['horizontal_font_color_default'] == ''){ ?>
	.the_champ_vertical_sharing .theChampTCBackground{
		color:#666;
	}
	<?php } 
	 if ($theChampSharingOptions['vertical_font_color_hover'] != ''){ ?>
		    div.the_champ_vertical_sharing span.the_champ_svg svg:hover path:not(.the_champ_no_fill),div.the_champ_vertical_sharing span.the_champ_svg svg:hover ellipse, div.the_champ_vertical_sharing span.the_champ_svg svg:hover circle, div.the_champ_vertical_sharing span.the_champ_svg svg:hover polygon{
		        fill:<?php echo esc_html($theChampSharingOptions['vertical_font_color_hover']) ?>;
		    }
		    div.the_champ_vertical_sharing span.the_champ_svg svg:hover path.the_champ_svg_stroke{
		    	stroke:<?php echo esc_html($theChampSharingOptions['vertical_font_color_hover']) ?>;
		    }
		<?php } ?>
	.the_champ_vertical_sharing span.the_champ_svg:hover,.heateor_ss_floating_follow_icons_container span.the_champ_svg:hover{
			<?php if ($theChampSharingOptions['vertical_bg_color_hover'] != ''){ ?>
				background-color: <?php echo esc_html($theChampSharingOptions['vertical_bg_color_hover']) ?>!important;
				background: <?php echo esc_html($theChampSharingOptions['vertical_bg_color_hover']) ?>!important;
			<?php }
			?>
			border-color: <?php echo $theChampSharingOptions['vertical_border_color_hover'] != '' ? esc_html($theChampSharingOptions['vertical_border_color_hover']) : 'transparent'; ?>;
		}
	<?php
	if(isset($theChampSharingOptions['horizontal_counts'])){
		$svg_height = $theChampSharingOptions['horizontal_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['horizontal_sharing_height'] : $theChampSharingOptions['horizontal_sharing_size'];
		if(isset($theChampSharingOptions['horizontal_counter_position']) && in_array($theChampSharingOptions['horizontal_counter_position'], array('inner_top', 'inner_bottom'))){
			$line_height_percent = $theChampSharingOptions['horizontal_counter_position'] == 'inner_top' ? 38 : 19;
			?>
			div.the_champ_horizontal_sharing svg{height:70%;margin-top:<?php echo esc_html($svg_height)*15/100 ?>px}div.the_champ_horizontal_sharing .the_champ_square_count{line-height:<?php echo esc_html($svg_height*$line_height_percent)/100 ?>px;}
			<?php
		}elseif(isset($theChampSharingOptions['horizontal_counter_position']) && in_array($theChampSharingOptions['horizontal_counter_position'], array('inner_left', 'inner_right'))){ ?>
			div.the_champ_horizontal_sharing svg{width:50%;margin:auto;}div.the_champ_horizontal_sharing .the_champ_square_count{float:left;width:50%;line-height:<?php echo esc_html($svg_height); ?>px;}
			<?php
		}elseif(isset($theChampSharingOptions['horizontal_counter_position']) && in_array($theChampSharingOptions['horizontal_counter_position'], array('left', 'right'))){ ?>
			div.the_champ_horizontal_sharing .the_champ_square_count{float:<?php echo esc_html($theChampSharingOptions['horizontal_counter_position']) ?>;margin:0 8px;line-height:<?php echo esc_html($svg_height + 2 * $border_width); ?>px;}
			<?php
		}elseif(!isset($theChampSharingOptions['horizontal_counter_position']) || $theChampSharingOptions['horizontal_counter_position'] == 'top'){ ?>
			div.the_champ_horizontal_sharing .the_champ_square_count{display: block}
			<?php
		}
	}
	if(isset($theChampSharingOptions['vertical_counts'])){
		$vertical_svg_height = $theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_height'] : $theChampSharingOptions['vertical_sharing_size'];
		$vertical_svg_width = $theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_width'] : $theChampSharingOptions['vertical_sharing_size'];
		if((isset($theChampSharingOptions['vertical_counter_position']) && in_array($theChampSharingOptions['vertical_counter_position'], array('inner_top', 'inner_bottom'))) || !isset($theChampSharingOptions['vertical_counter_position'])){
			$vertical_line_height_percent = !isset($theChampSharingOptions['vertical_counter_position']) || $theChampSharingOptions['vertical_counter_position'] == 'inner_top' ? 38 : 19;
			?>
			div.the_champ_vertical_sharing svg{height:70%;margin-top:<?php echo esc_html($vertical_svg_height)*15/100 ?>px}div.the_champ_vertical_sharing .the_champ_square_count{line-height:<?php echo esc_html($vertical_svg_height*$vertical_line_height_percent)/100; ?>px;}
			<?php
		}elseif(isset($theChampSharingOptions['vertical_counter_position']) && in_array($theChampSharingOptions['vertical_counter_position'], array('inner_left', 'inner_right'))){ ?>
			div.the_champ_vertical_sharing svg{width:50%;margin:auto;}div.the_champ_vertical_sharing .the_champ_square_count{float:left;width:50%;line-height:<?php echo esc_html($vertical_svg_height); ?>px;}
			<?php
		}elseif(isset($theChampSharingOptions['vertical_counter_position']) && in_array($theChampSharingOptions['vertical_counter_position'], array('left', 'right'))){ ?>
			div.the_champ_vertical_sharing .the_champ_square_count{float:<?php echo esc_html($theChampSharingOptions['vertical_counter_position']) ?>;margin:0 8px;line-height:<?php echo esc_html($vertical_svg_height); ?>px; <?php echo $theChampSharingOptions['vertical_counter_position'] == 'left' ? 'min-width:' . esc_html($vertical_svg_width)*30/100 . 'px;display: block' : '';?>}
			<?php
		}elseif(isset($theChampSharingOptions['vertical_counter_position']) && $theChampSharingOptions['vertical_counter_position'] == 'top'){?>
			div.the_champ_vertical_sharing .the_champ_square_count{display: block}
			<?php
		}
	}
	echo isset($theChampSharingOptions['hide_mobile_sharing']) && $theChampSharingOptions['vertical_screen_width'] != '' ? '@media screen and (max-width:'.esc_html($theChampSharingOptions['vertical_screen_width']).'px){.the_champ_vertical_sharing{display:none!important}}' : '';
	$bottom_sharing_postion_inverse = $theChampSharingOptions['bottom_sharing_alignment'] == 'left' ? 'right' : 'left';
	$bottom_sharing_responsive_css = '';
	$num_sharing_icons = isset($theChampSharingOptions['vertical_re_providers']) ? count($theChampSharingOptions['vertical_re_providers']) : 0;
	if(isset($theChampSharingOptions['vertical_enable']) && $theChampSharingOptions['bottom_sharing_position_radio'] == 'responsive' && $num_sharing_icons > 0){
		$vertical_sharing_icon_height = $theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_height'] : $theChampSharingOptions['vertical_sharing_size'];
		$total_share_count_enabled = isset($theChampSharingOptions['vertical_total_shares']) ? 1 : 0;
		$more_icon_enabled = isset($theChampSharingOptions['vertical_more']) ? 1 : 0;
		$bottom_sharing_responsive_css = 'div.the_champ_bottom_sharing{width:100%!important;left:0!important;}div.the_champ_bottom_sharing a{width:'.(100/($num_sharing_icons+$total_share_count_enabled+$more_icon_enabled)).'% !important;margin:0!important;padding:0!important;}div.the_champ_bottom_sharing .the_champ_svg{width:100%!important;}div.the_champ_bottom_sharing div.theChampTotalShareCount{font-size:.7em!important;line-height:'.($vertical_sharing_icon_height*70/100 ).'px!important}div.the_champ_bottom_sharing div.theChampTotalShareText{font-size:.5em!important;line-height:0px!important}';
	}
	echo isset($theChampSharingOptions['vertical_enable']) && isset($theChampSharingOptions['bottom_mobile_sharing']) && $theChampSharingOptions['horizontal_screen_width'] != '' ? esc_html('div.heateor_ss_mobile_footer{display:none;}@media screen and (max-width:'.$theChampSharingOptions['horizontal_screen_width'].'px){div.the_champ_bottom_sharing div.the_champ_sharing_ul .theChampTCBackground{width:100%!important;background-color:white}'.$bottom_sharing_responsive_css.'div.heateor_ss_mobile_footer{display:block;height:'.($theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_height'] : $theChampSharingOptions['vertical_sharing_size']).'px;}.the_champ_bottom_sharing{padding:0!important;'.($theChampSharingOptions['bottom_sharing_position_radio'] == 'nonresponsive' && $theChampSharingOptions['bottom_sharing_position'] != '' ? $theChampSharingOptions['bottom_sharing_alignment'].':'.$theChampSharingOptions['bottom_sharing_position'].'px!important;'.$bottom_sharing_postion_inverse.':auto!important;' : '').'display:block!important;width: auto!important;bottom:'.(isset($theChampSharingOptions['vertical_total_shares']) ? '-10' : '-2').'px!important;top: auto!important;}.the_champ_bottom_sharing .the_champ_square_count{line-height: inherit;}.the_champ_bottom_sharing .theChampSharingArrow{display:none;}.the_champ_bottom_sharing .theChampTCBackground{margin-right: 1.1em !important}}') : '';
	echo isset($theChampSharingOptions['hide_slider']) ? 'div.theChampSharingArrow{display:none}' : '';
	if(isset($theChampSharingOptions['hor_enable']) && $theChampSharingOptions['hor_sharing_alignment'] == "center"){
		echo 'div.the_champ_sharing_title{text-align:center}div.the_champ_sharing_ul{width:100%;text-align:center;}div.the_champ_horizontal_sharing div.the_champ_sharing_ul a{float:none;display:inline-block;}';
	}
	if(isset($theChampCounterOptions['hor_enable']) && isset($theChampCounterOptions['hor_counter_alignment']) && $theChampCounterOptions['hor_counter_alignment'] == "center"){
		echo 'div.the_champ_counter_title{text-align:center}ul.the_champ_sharing_ul{width:100%;text-align:center;}div.the_champ_horizontal_counter ul.the_champ_sharing_ul li{float:none!important;display:inline-block;}';
	}
	if(isset($theChampLoginOptions['center_align'])){
		echo 'div.the_champ_social_login_title,div.the_champ_login_container{text-align:center}ul.the_champ_login_ul{width:100%;text-align:center;}div.the_champ_login_container ul.the_champ_login_ul li{float:none!important;display:inline-block;}';
	}?></style>
	<?php
	wp_enqueue_style('the_champ_frontend_css', plugins_url('css/front.css', __FILE__ ), false, THE_CHAMP_SS_VERSION);
	wp_add_inline_style('the_champ_frontend_css', $theChampGeneralOptions['custom_css']);
}

/**
 * Create plugin menu in admin.
 */	
function the_champ_create_admin_menu(){
	$page = add_menu_page('Super Socializer by Heateor', 'Super Socializer', 'manage_options', 'heateor-ss-general-options', 'the_champ_general_options_page', plugins_url('images/logo.png', __FILE__));
	// general options page
	$generalOptionsPage = add_submenu_page('heateor-ss-general-options', __( "Super Socializer - General Options", 'super-socializer'), __( "General Options", 'super-socializer'), 'manage_options', 'heateor-ss-general-options', 'the_champ_general_options_page');
	// facebook page
	$facebookPage = add_submenu_page('heateor-ss-general-options', 'Super Socializer - Social Commenting', 'Social Commenting', 'manage_options', 'heateor-social-commenting', 'the_champ_facebook_page');
	// social login page
	$loginPage = add_submenu_page('heateor-ss-general-options', 'Super Socializer - Social Login', 'Social Login', 'manage_options', 'heateor-social-login', 'the_champ_social_login_page');
	// social sharing page
	$sharingPage = add_submenu_page('heateor-ss-general-options', 'Super Socializer - Social Sharing', 'Social Sharing', 'manage_options', 'heateor-social-sharing', 'the_champ_social_sharing_page');
	// like buttons page
	$counterPage = add_submenu_page('heateor-ss-general-options', 'Super Socializer - Like Buttons', 'Like Buttons', 'manage_options', 'heateor-like-buttons', 'the_champ_like_buttons_page');
	add_action('admin_print_scripts-'.$page, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-'.$page, 'the_champ_admin_style');
	add_action('admin_print_scripts-'.$page, 'the_champ_fb_sdk_script');
	add_action('admin_print_scripts-'.$generalOptionsPage, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-'.$generalOptionsPage, 'the_champ_fb_sdk_script');
	add_action('admin_print_styles-'.$generalOptionsPage, 'the_champ_admin_style');
	add_action('admin_print_scripts-'.$facebookPage, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-'.$facebookPage, 'the_champ_fb_sdk_script');
	add_action('admin_print_styles-'.$facebookPage, 'the_champ_admin_style');
	add_action('admin_print_scripts-'.$loginPage, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-'.$loginPage, 'the_champ_fb_sdk_script');
	add_action('admin_print_styles-'.$loginPage, 'the_champ_admin_style');
	add_action('admin_print_scripts-'.$sharingPage, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-'.$sharingPage, 'the_champ_fb_sdk_script');
	add_action('admin_print_scripts-'.$sharingPage, 'the_champ_admin_sharing_scripts');
	add_action('admin_print_styles-'.$sharingPage, 'the_champ_admin_style');
	add_action('admin_print_styles-'.$sharingPage, 'the_champ_admin_sharing_style');
	add_action('admin_print_scripts-'.$counterPage, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-'.$counterPage, 'the_champ_fb_sdk_script');
	add_action('admin_print_scripts-'.$counterPage, 'the_champ_admin_counter_scripts');
	add_action('admin_print_styles-'.$counterPage, 'the_champ_admin_style');
}
add_action('admin_menu', 'the_champ_create_admin_menu');

/** 
 * Auto-approve comments made by social login users
 */ 
function the_champ_auto_approve_comment($approved){
	global $theChampLoginOptions; 
	if(empty($approved)){
		if(isset($theChampLoginOptions['autoApproveComment'])){ 
			$userId = get_current_user_id(); 
			$commentUser = get_user_meta($userId, 'thechamp_current_id', true); 
			if($commentUser !== false){ 
				$approved = 1; 
			}  
		} 
	} 
	return $approved;
}
add_action('pre_comment_approved', 'the_champ_auto_approve_comment');

/**
 * Place "fb-root" div in website footer
 */
function the_champ_fb_root_div(){
	?>
	<div id="fb-root"></div>
	<?php
}

/**
 * Show Social Avatar options at profile page
 */
function the_champ_show_avatar_option($user){
	global $user_ID, $theChampLoginOptions;
	if(isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['gdpr_enable'])){
		$gdpr_consent = get_user_meta($user_ID, 'thechamp_gdpr_consent', true);
		?>
		<h3><?php _e('GDPR', 'super-socializer') ?></h3>
		<table class="form-table">
			<tr>
	            <th><label for="heateor_ss_gdpr_consent"><?php _e('I agree to my personal data being stored and used as per Privacy Policy and Terms and Conditions', 'super-socializer') ?></label></th>
	        	<td><input id="heateor_ss_gdpr_consent" style="margin-right:5px" type="radio" name="heateor_ss_gdpr_consent" value="yes" <?php echo $gdpr_consent === false || $gdpr_consent == 'yes' ? 'checked' : '' ?> /></td>
	        </tr>
	        <tr>
	            <th><label for="heateor_ss_revoke_gdpr_consent"><?php _e('I revoke my consent to store and use my personal data. Kindly delete my personal data saved in this website.', 'super-socializer') ?></label></th>
	        	<td><input id="heateor_ss_revoke_gdpr_consent" style="margin-right:5px" type="radio" name="heateor_ss_gdpr_consent" value="no" <?php echo $gdpr_consent == 'no' ? 'checked' : '' ?> /></td>
	        </tr>
	    </table>
		<?php
	}
	if(isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['avatar'])){
		$dontUpdateAvatar = get_user_meta($user_ID, 'thechamp_dontupdate_avatar', true);
		?>
		<h3><?php _e('Social Avatar', 'super-socializer') ?></h3>
		<table class="form-table">
	        <tr>
	            <th><label for="ss_small_avatar"><?php _e('Small Avatar Url', 'super-socializer') ?></label></th>
	            <td><input id="ss_small_avatar" type="text" name="the_champ_small_avatar" value="<?php echo esc_attr(get_user_meta($user->ID, 'thechamp_avatar', true )); ?>" class="regular-text" /></td>
	        </tr>
	        <tr>
	            <th><label for="ss_large_avatar"><?php _e('Large Avatar Url', 'super-socializer') ?></label></th>
	            <td><input id="ss_large_avatar" type="text" name="the_champ_large_avatar" value="<?php echo esc_attr(get_user_meta($user->ID, 'thechamp_large_avatar', true )); ?>" class="regular-text" /></td>
	        </tr>
	        <tr>
	            <th><label for="ss_dontupdate_avatar_1"><?php _e('Do not fetch and update social avatar from my profile, next time I Social Login', 'super-socializer') ?></label></th>
	            <td><input id="ss_dontupdate_avatar_1" style="margin-right:5px" type="radio" name="ss_dontupdate_avatar" value="1" <?php echo $dontUpdateAvatar ? 'checked' : '' ?> /></td>
	        </tr>
	        <tr>
	            <th><label for="ss_dontupdate_avatar_0"><?php _e('Update social avatar, next time I Social Login', 'super-socializer') ?></label></th>
	            <td><input id="ss_dontupdate_avatar_0" style="margin-right:5px" type="radio" name="ss_dontupdate_avatar" value="0" <?php echo !$dontUpdateAvatar ? 'checked' : '' ?> /></td>
	        </tr>
	    </table>
		<?php
	}
}
add_action('edit_user_profile', 'the_champ_show_avatar_option');
add_action('show_user_profile', 'the_champ_show_avatar_option');

/**
 * Save social avatar options from profile page
 */
function the_champ_save_avatar($user_id){ 	
 	if(!current_user_can('edit_user', $user_id )){
 		return false;
 	}
 	if(isset($_POST['heateor_ss_gdpr_consent']) && $_POST['heateor_ss_gdpr_consent'] == 'no'){
		global $wpdb;
		// delete user's social avatar saved in the website locally
		$avatar_path = ABSPATH.'wp-content/uploads/heateor/'. get_user_meta($user_id, 'thechamp_social_id', true) .'.jpeg';
		$large_avatar_path = ABSPATH.'wp-content/uploads/heateor/'. get_user_meta($user_id, 'thechamp_social_id', true) .'_large.jpeg';
		if(file_exists($avatar_path)){
			unlink($avatar_path);
		}
		if(file_exists($large_avatar_path)){
			unlink($large_avatar_path);
		}
		// delete personal data from the user meta 
		$wpdb->query($wpdb->prepare('DELETE FROM '.$wpdb->prefix.'usermeta WHERE user_id = %d and meta_key LIKE "thechamp%"', $user_id));
 	}
 	if((!isset($_POST['heateor_ss_gdpr_consent']) || $_POST['heateor_ss_gdpr_consent'] == 'yes') && isset($_POST['the_champ_small_avatar'])){
 		update_user_meta($user_id, 'thechamp_avatar', esc_url(trim($_POST['the_champ_small_avatar'])));
 	}
 	if((!isset($_POST['heateor_ss_gdpr_consent']) || $_POST['heateor_ss_gdpr_consent'] == 'yes') && isset($_POST['the_champ_large_avatar'])){
 		update_user_meta($user_id, 'thechamp_large_avatar', esc_url_raw($_POST['the_champ_large_avatar']));
 	}
	if(isset($_POST['ss_dontupdate_avatar'])){
		update_user_meta($user_id, 'thechamp_dontupdate_avatar', intval($_POST['ss_dontupdate_avatar']));
	}
	if(isset($_POST['heateor_ss_gdpr_consent'])){
	    update_user_meta($user_id, 'thechamp_gdpr_consent', $_POST['heateor_ss_gdpr_consent'] == 'yes' ? 'yes' : 'no');
    }
}
add_action('personal_options_update', 'the_champ_save_avatar');
add_action('edit_user_profile_update', 'the_champ_save_avatar');

if(!function_exists('array_replace')){
	/**
	 * Custom 'array_replace' function for PHP version < 5.3
	 */
	function array_replace(){
		$args = func_get_args();
		$numArgs = func_num_args();
		$res = array();
		for($i = 0; $i < $numArgs; $i++){
			if(is_array($args[$i])){
				foreach($args[$i] as $key => $val){
					$res[$key] = $val;
				}
			}else{
				trigger_error(__FUNCTION__ .'(): Argument #'.($i+1).' is not an array', E_USER_WARNING);
				return NULL;
			}
		}
		return $res;
	}
}

/**
 * Replace a value in array
 */
function the_champ_replace_array_value($array, $value, $replacement){
	return array_replace($array,
	    array_fill_keys(
	        array_keys($array, $value),
	        $replacement
	    )
	);
}

/**
 * Default options when plugin is installed
 */
function the_champ_save_default_options(){
	// general options
	add_option('the_champ_general', array(
		'footer_script' => '1',
		'delete_options' => '1',
		'combined_script' => '1',
		'custom_css' => ''
	));

	// login options
	add_option('the_champ_login', array(
		'title' => __('Login with your Social ID', 'super-socializer'),
		'email_error_message' => __('Email you entered is already registered or invalid', 'super-socializer'),
		'avatar' => 1,
		'twitch_client_id' => '',
		'twitch_client_secret' => '',
		'email_required' => 1,
		'password_email' => 1,
		'new_user_admin_email' => 1,
		'email_popup_text' => __('Please enter a valid email address. You might be required to verify it', 'super-socializer'),
		'enableAtLogin' => 1,
		'enableAtRegister' => 1,
		'enableAtComment' => 1,
		'username_separator' => 'dash',
		'scl_title' => __('Link your social account to login to your account at this website', 'super-socializer'),
		'link_account' => 1,
		'gdpr_placement' => 'above',
		'privacy_policy_url' => '',
		'privacy_policy_optin_text' => 'I have read and agree to Terms and Conditions of website and agree to my personal data being stored and used as per Privacy Policy',
		'ppu_placeholder' => 'Privacy Policy',
		'tc_placeholder' => 'Terms and Conditions',
		'tc_url' => '',
		'insta_app_secret' => '',
		'reddit_client_id' => '',
		'reddit_client_secret' => '',
		'disqus_public_key' => '',
		'disqus_secret_key' => '',
		'foursquare_client_id' => '',
		'foursquare_client_secret' => '',
		'dropbox_app_key' => '',
		'dropbox_app_secret' => '',
		'discord_channel_id' => '',
		'discord_channel_secret' => '',
		'amazon_client_id' => '',
		'amazon_client_secret' => '',
		'stackoverflow_client_id' => '',
		'stackoverflow_client_secret' => '',
		'stackoverflow_key' => '',
		'mailru_client_secret' => '',
		'mailru_client_id' => '',
		'odnoklassniki_client_secret' => '',
		'odnoklassniki_client_id' => '',
		'odnoklassniki_public_key' => '',
		'yandex_client_id' => '',
		'yandex_client_secret' => '',
		'youtube_key' => '',
		'same_tab_login' => '1',
		'allow_cyrillic' => array(),
		'disable_sl_admin' => '1',
		'linkedin_login_type' => 'oauth'
	));
	
	// social commenting options
	add_option('the_champ_facebook', array(
		'enable_commenting' => '1',
		'enable_fbcomments' => '1',
		'enable_page' => '1',
		'enable_post' => '1',
		'comment_lang' => get_locale(),
		'commenting_order' => 'wordpress,facebook,disqus',
		'commenting_label' => 'Leave a reply',
		'label_wordpress_comments' => 'Default Comments',
		'label_facebook_comments' => 'Facebook Comments',
		'label_disqus_comments' => 'Disqus Comments',
	));
	
	// sharing options
	add_option('the_champ_sharing', array(
		'enable' => '1',
		'amp_enable' => '1',
		'horizontal_sharing_shape' => 'round',
		'horizontal_sharing_size' => '35',
		'horizontal_sharing_width' => '70',
		'horizontal_sharing_height' => '35',
		'horizontal_border_radius' => '',
		'horizontal_font_color_default' => '',
		'horizontal_sharing_replace_color' => '#fff',
		'horizontal_font_color_hover' => '',
		'horizontal_sharing_replace_color_hover' => '#fff',
		'horizontal_bg_color_default' => '',
		'horizontal_bg_color_hover' => '',
		'horizontal_border_width_default' => '',
		'horizontal_border_color_default' => '',
		'horizontal_border_width_hover' => '',
		'horizontal_border_color_hover' => '',
		'vertical_sharing_shape' => 'square',
		'vertical_sharing_size' => '40',
		'vertical_sharing_width' => '80',
		'vertical_sharing_height' => '40',
		'vertical_border_radius' => '',
		'vertical_font_color_default' => '',
		'vertical_sharing_replace_color' => '#fff',
		'vertical_font_color_hover' => '',
		'vertical_sharing_replace_color_hover' => '#fff',
		'vertical_bg_color_default' => '',
		'vertical_bg_color_hover' => '',
		'vertical_border_width_default' => '',
		'vertical_border_color_default' => '',
		'vertical_border_width_hover' => '',
		'vertical_border_color_hover' => '',
		'hor_enable' => '1',
		'horizontal_target_url' => 'default',
		'horizontal_target_url_custom' => '',
		'title' => 'Spread the love',
		'instagram_username' => '',
		'vertical_youtube_username' => '',
		'youtube_username' => '',
		'vertical_rutube_url' => '',
		'rutube_url' => '',
		'comment_container_id' => 'respond',
		'horizontal_re_providers' => array('facebook', 'X', 'linkedin', 'pinterest', 'reddit', 'whatsapp'),
		'hor_sharing_alignment' => 'left',
		'top' => '1',
		'post' => '1',
		'page' => '1',
		'horizontal_more' => '1',
		'vertical_enable' => '1',
		'vertical_target_url' => 'default',
		'vertical_target_url_custom' => '',
		'vertical_instagram_username' => '',
		'vertical_comment_container_id' => 'respond',
		'vertical_re_providers' => array('facebook', 'X', 'linkedin', 'pinterest', 'reddit', 'whatsapp'),
		'vertical_bg' => '',
		'alignment' => 'left',
		'left_offset' => '-10',
		'right_offset' => '-10',
		'top_offset' => '100',
		'vertical_post' => '1',
		'vertical_page' => '1',
		'vertical_home' => '1',
		'vertical_more' => '1',
		'hide_mobile_sharing' => '1',
		'vertical_screen_width' => '783',
		'bottom_mobile_sharing' => '1',
		'horizontal_screen_width' => '783',
		'bottom_sharing_position' => '0',
		'bottom_sharing_alignment' => 'left',
		'bottom_sharing_position_radio' => 'responsive',
		'bitly_access_token' => '',
		'share_count_cache_refresh_count' => '10',
		'share_count_cache_refresh_unit' => 'minutes',
		'language' => get_locale(),
		'twitter_username' => '',
		'fb_key' => '',
		'fb_secret' => '',
		'google_news_url' => '',
       	'vertical_google_news_url' => ''
	));

	// counter options
	add_option('the_champ_counter', array(
		'left_offset' => '-10',
		'right_offset' => '-10',
		'top_offset' => '100',
		'alignment' => 'left',
		'bitly_access_token' => ''
	));

	add_option('the_champ_ss_version', THE_CHAMP_SS_VERSION);
}

/**
 * Plugin activation function
 */
function the_champ_activate_plugin($networkWide){
	global $wpdb;
	if(function_exists('is_multisite') && is_multisite()){
		//check if it is network activation if so run the activation function for each id
		if($networkWide){
			$oldBlog =  $wpdb->blogid;
			//Get all blog ids
			$blogIds =  $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

			foreach($blogIds as $blogId){
				switch_to_blog($blogId);
				the_champ_save_default_options();
			}
			switch_to_blog($oldBlog);
			return;
		}
	}
	the_champ_save_default_options();
	set_transient('heateor-ss-admin-notice-on-activation', true, 5 );
}
register_activation_hook(__FILE__, 'the_champ_activate_plugin');

/**
 * Save default options for the new subsite created
 */
function the_champ_new_subsite_default_options($blogId, $userId, $domain, $path, $siteId, $meta){
    if(is_plugin_active_for_network('super-socializer/super_socializer.php')){ 
        switch_to_blog($blogId);
        the_champ_save_default_options();
        restore_current_blog();
    }
}
add_action('wpmu_new_blog', 'the_champ_new_subsite_default_options', 10, 6);

/**
 * Set flag in database if Twitcount notification has been read
 */
function heateor_ss_twitcount_notification_read(){
	if(current_user_can('administrator') && check_ajax_referer('heateor_ss_twitcount_notification_nonce', 'nonce') !== false){
		update_option('heateor_ss_twitcount_notification_read', '1');
		die;
	}
}
add_action('wp_ajax_heateor_ss_twitcount_notification_read', 'heateor_ss_twitcount_notification_read');

/**
 * Set flag in database if GDPR notification has been read
 */
function heateor_ss_gdpr_notification_read(){
	if(current_user_can('administrator') && check_ajax_referer('heateor_ss_gdpr_notification_nonce', 'nonce') !== false){
		update_option('heateor_ss_gdpr_notification_read', '1');
		die;
	}
}
add_action('wp_ajax_heateor_ss_gdpr_notification_read', 'heateor_ss_gdpr_notification_read');

/**
 * Set flag in database if Facebook redirection notification has been read
 */
function heateor_ss_fb_redirection_notification_read(){
	if(current_user_can('administrator') && check_ajax_referer('heateor_ss_fb_redirection_notification_nonce', 'nonce') !== false){
		update_option('heateor_ss_fb_redirection_notification_read', '1');
		die;
	}
}
add_action('wp_ajax_heateor_ss_fb_redirection_notification_read', 'heateor_ss_fb_redirection_notification_read');

/**
 * Set flag in database if Twitter callback notification has been read
 */
function heateor_ss_twitter_callback_notification_read(){
	if(current_user_can('administrator') && check_ajax_referer('heateor_ss_twitter_callback_notification_nonce', 'nonce') !== false){
		update_option('heateor_ss_twitter_callback_notification_read', '1');
		die;
	}
}
add_action('wp_ajax_heateor_ss_twitter_callback_notification_read', 'heateor_ss_twitter_callback_notification_read');

/**
 * Set flag in database if Linkedin redirect url notification has been read
 */
function heateor_ss_linkedin_redirect_url_notification_read(){
	if(current_user_can('administrator') && check_ajax_referer('heateor_ss_linkedin_redirect_url_notification_nonce', 'nonce') !== false){
		update_option('heateor_ss_linkedin_redirect_url_notification_read', '1');
		die;
	}
}
add_action('wp_ajax_heateor_ss_linkedin_redirect_url_notification_read', 'heateor_ss_linkedin_redirect_url_notification_read');

/**
 * Set flag in database if FB share count notification has been read
 */
function heateor_ss_fb_count_notification_read(){
	if(current_user_can('administrator') && check_ajax_referer('heateor_ss_fb_count_notification_nonce', 'nonce') !== false){
		update_option('heateor_ss_fb_count_notification_read', '1');
		die;
	}
}
add_action('wp_ajax_heateor_ss_fb_count_notification_read', 'heateor_ss_fb_count_notification_read');

/**
 * Set flag in database if new Twitter callback notification has been read
 */
function heateor_ss_twitter_new_callback_notification_read(){
	if(current_user_can('administrator') && check_ajax_referer('heateor_ss_twitter_new_callback_notification_nonce', 'nonce') !== false){
		update_option('heateor_ss_twitter_new_callback_notification_read', '1');
		die;
	}
}
add_action('wp_ajax_heateor_ss_twitter_new_callback_notification_read', 'heateor_ss_twitter_new_callback_notification_read');

/**
 * Set flag in database if Linkedin redirection notification has been read
 */
function heateor_ss_linkedin_redirection_notification_read(){
	if(current_user_can('administrator') && check_ajax_referer('heateor_ss_linkedin_redirection_notification_nonce', 'nonce') !== false){
		update_option('heateor_ss_linkedin_redirection_notification_read', '1');
		die;
	}
}
add_action('wp_ajax_heateor_ss_linkedin_redirection_notification_read', 'heateor_ss_linkedin_redirection_notification_read');

/**
 * Set flag in database if Google redirection notification has been read
 */
function heateor_ss_google_redirection_notification_read(){
	if(current_user_can('administrator') && check_ajax_referer('heateor_ss_google_redirection_notification_nonce', 'nonce') !== false){
		update_option('heateor_ss_google_redirection_notification_read', '1');
		die;
	}
}
add_action('wp_ajax_heateor_ss_google_redirection_notification_read', 'heateor_ss_google_redirection_notification_read');

/**
 * Show notification related to add-on update
 */
function the_champ_addon_update_notification(){
	if(current_user_can('manage_options')){
		global $theChampLoginOptions, $theChampSharingOptions, $theChampCounterOptions;
		if(get_transient('heateor-ss-admin-notice-on-activation')){ ?>
	        <div class="notice notice-success is-dismissible">
	            <p><strong><?php printf(__('Thanks for installing Super Socializer plugin', 'super-socializer'), 'http://support.heateor.com/super-socializer-configuration'); ?></strong></p>
	            <p>
					<a href="http://support.heateor.com/super-socializer-configuration" target="_blank" class="button button-primary"><?php _e('Configure the Plugin', 'super-socializer'); ?></a>
				</p>
	        </div> <?php
	        // Delete transient, only display this notice once
	        delete_transient('heateor-ss-admin-notice-on-activation');
	    }

		if(defined('HEATEOR_FB_COM_MOD_VERSION') && version_compare('1.2.5', HEATEOR_FB_COM_MOD_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Facebook Comments Moderation</h3>
				<p><?php _e('Update "Facebook Comments Moderation" add-on for compatibility with current version of Super Socializer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		if(defined('HEATEOR_SOCIAL_SHARES_TRACKER_VERSION') && version_compare('1.1', HEATEOR_SOCIAL_SHARES_TRACKER_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Social Shares Tracker</h3>
				<p><?php _e('Update "Social Shares Tracker" add-on to version 1.1 or above for compatibility with the current version of Super Socializer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		if(defined('HEATEOR_SHARING_GOOGLE_ANALYTICS_VERSION') && version_compare('1.1.8', HEATEOR_SHARING_GOOGLE_ANALYTICS_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Social Sharing Analytics</h3>
				<p><?php _e('Update "Social Sharing Analytics" add-on to version 1.1.8 or above for compatibility with the current version of Super Socializer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		if(defined('HEATEOR_FB_COM_NOT_VERSION') && version_compare('1.1.7', HEATEOR_FB_COM_NOT_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Facebook Comments Notifier</h3>
				<p><?php _e('Update "Facebook Comments Notifier" add-on for compatibility with current version of Super Socializer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		if(defined('HEATEOR_SOCIAL_LOGIN_BUTTONS_VERSION') && version_compare('1.2.14', HEATEOR_SOCIAL_LOGIN_BUTTONS_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Social Login Buttons</h3>
				<p><?php _e('Update "Social Login Buttons" add-on to version 1.2.14 or above for compatibility with the current version of Super Socializer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		if(defined('HEATEOR_SOCIAL_SHARE_MYCRED_INTEGRATION_VERSION') && version_compare('1.3.13', HEATEOR_SOCIAL_SHARE_MYCRED_INTEGRATION_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Social Share - myCRED Integration</h3>
				<p><?php _e('Update "Social Share myCRED Integration" add-on to version 1.3.13 or above for compatibility with the current version of Super Socializer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		if(defined('HEATEOR_SOCIAL_LOGIN_MYCRED_INTEGRATION_VERSION') && version_compare('1.2.1', HEATEOR_SOCIAL_LOGIN_MYCRED_INTEGRATION_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Social Login - myCRED Integration</h3>
				<p><?php _e('Update "Social Login myCRED Integration" add-on for maximum compatibility with current version of Super Socializer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		$currentVersion = get_option('the_champ_ss_version');

		if(version_compare('7.10.5', $currentVersion) < 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) && in_array('steam', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['steam_api_key']) || $theChampLoginOptions['steam_api_key'] == '')){
			?>
			<div class="error">
				<h3>Super Socializer</h3>
				<p><?php echo sprintf(__('To continue using Steam login save Steam API key <a href="%s">here</a>', 'super-socializer'), 'admin.php?page=heateor-social-login'); ?></p>
			</div>
			<?php
		}

		if(version_compare('7.12.46', $currentVersion) > 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) && in_array('instagram', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['insta_id']) || $theChampLoginOptions['insta_id'] == '' || !isset($theChampLoginOptions['insta_app_secret']) || $theChampLoginOptions['insta_app_secret'] == '')){
			?>
			<div class="error">
				<h3>Super Socializer</h3>
				<p><?php echo sprintf(__('To continue using Instagram login create a new Instagram App as described <a href="%s" target="_blank">here</a> and save Instagram App ID and Instagram App Secret <a href="%s">here</a>', 'super-socializer'), 'http://support.heateor.com/how-to-get-instagram-client-id/', 'admin.php?page=heateor-social-login'); ?></p>
			</div>
			<?php
		}

		if(version_compare('7.12.46', $currentVersion) > 0 && isset($theChampSharingOptions['bitly_enable']) && !$theChampSharingOptions['bitly_access_token']){
			?>
			<div class="error">
				<h3>Super Socializer</h3>
				<p><?php echo sprintf(__('To continue using bitly url shortener, login to your bit.ly account and navigate to <strong>Profile Settings > Generic Access Token</strong> (top-right corner), authenticate to generate access token and save it <a href="%s">here</a>. More details at the <a href="%s" target="_blank">link</a>', 'super-socializer'), 'admin.php?page=heateor-social-sharing#tabs-4', 'https://support.sendible.com/hc/en-us/articles/360021876751-How-To-Access-Your-Bit-ly-Key'); ?></p>
			</div>
			<?php
		}

		if(version_compare('7.12.46', $currentVersion) > 0 && isset($theChampCounterOptions['bitly_enable']) && !$theChampCounterOptions['bitly_access_token']){
			?>
			<div class="error">
				<h3>Super Socializer</h3>
				<p><?php echo sprintf(__('To continue using bitly url shortener, login to your bit.ly account and navigate to <strong>Profile Settings > Generic Access Token</strong> (top-right corner), authenticate to generate access token and save it <a href="%s">here</a>. More details at the <a href="%s" target="_blank">link</a>', 'super-socializer'), 'admin.php?page=heateor-like-buttons#tabs-3', 'https://support.sendible.com/hc/en-us/articles/360021876751-How-To-Access-Your-Bit-ly-Key'); ?></p>
			</div>
			<?php
		}

		if(version_compare('7.11', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) &&
			(
				(in_array('facebook', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['fb_secret']) || $theChampLoginOptions['fb_secret'] == '')) || 
				(in_array('linkedin', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['li_secret']) || $theChampLoginOptions['li_secret'] == '')) || 
				(in_array('google', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['google_secret']) || $theChampLoginOptions['google_secret'] == '')) ||
				(in_array('vkontakte', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['vk_secure_key']) || $theChampLoginOptions['vk_secure_key'] == ''))
			)
		){
			?>
			<div class="error">
				<h3>Super Socializer</h3>
				<p><?php echo sprintf(__('To continue using Social Login, save the secret keys <a href="%s">here</a>', 'super-socializer'), 'admin.php?page=heateor-social-login'); ?></p>
			</div>
			<?php
		}

		if(version_compare('7.11', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) && is_array($theChampLoginOptions['providers']) && in_array('facebook', $theChampLoginOptions['providers'])){
			if(!get_option('heateor_ss_fb_redirection_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsFbRedirectionNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							nonce: '<?php echo wp_create_nonce('heateor_ss_fb_redirection_notification_nonce') ?>',
							action: 'heateor_ss_fb_redirection_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_fb_redirection_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_fb_redirection_notification" class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('Add %s in "Valid OAuth redirect URIs" option in your Facebook app settings for Facebook login to work. For more details, check step 9 <a href="%s" target="_blank">here</a>', 'super-socializer'), home_url().'/?SuperSocializerAuth=Facebook', 'http://support.heateor.com/how-to-get-facebook-app-id/'); ?><input type="button" onclick="heateorSsFbRedirectionNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}
		}

		if(version_compare('7.11.14', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) && is_array($theChampLoginOptions['providers']) && in_array('twitter', $theChampLoginOptions['providers'])){
			if(!get_option('heateor_ss_twitter_callback_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsTwitterCbNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							nonce: '<?php echo wp_create_nonce('heateor_ss_twitter_callback_notification_nonce') ?>',
							action: 'heateor_ss_twitter_callback_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_twitter_callback_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_twitter_callback_notification" class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('Add %s in "Callback URLs" option in your Twitter app settings for Twitter login to work. For more details, check step 4 <a href="%s" target="_blank">here</a>', 'super-socializer'), home_url(), 'http://support.heateor.com/how-to-get-twitter-api-key-and-secret/'); ?><input type="button" onclick="heateorSsTwitterCbNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}
		}

		if(version_compare('7.11', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) && is_array($theChampLoginOptions['providers']) && in_array('linkedin', $theChampLoginOptions['providers'])){
			if(!get_option('heateor_ss_linkedin_redirection_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsLinkedinRedirectionNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							nonce: '<?php echo wp_create_nonce('heateor_ss_linkedin_redirection_notification_nonce') ?>',
							action: 'heateor_ss_linkedin_redirection_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_linkedin_redirection_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_linkedin_redirection_notification" class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('Add %s in "Authorized Redirect URLs" option in your Linkedin app settings for Linkedin login to work. For more details, check step 4 <a href="%s" target="_blank">here</a>', 'super-socializer'), home_url(), 'http://support.heateor.com/how-to-get-linkedin-api-key/'); ?><input type="button" onclick="heateorSsLinkedinRedirectionNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}
		}

		if(version_compare('7.11', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) && is_array($theChampLoginOptions['providers']) && in_array('google', $theChampLoginOptions['providers']) && home_url() != the_champ_get_http().$_SERVER['HTTP_HOST']){
			if(!get_option('heateor_ss_google_redirection_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsGoogleRedirectionNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							nonce: '<?php echo wp_create_nonce('heateor_ss_google_redirection_notification_nonce') ?>',
							action: 'heateor_ss_google_redirection_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_google_redirection_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_google_redirection_notification" class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('Add %s in "Authorized redirect URIs" option in your Google client settings for Google login to work. For more details, check step 11 <a href="%s" target="_blank">here</a>', 'super-socializer'), home_url(), 'http://support.heateor.com/how-to-get-google-plus-client-id/'); ?><input type="button" onclick="heateorSsGoogleRedirectionNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}
		}

		if(version_compare('7.11.12', $currentVersion) <= 0){
			if(isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['gdpr_enable']) && $theChampLoginOptions['privacy_policy_url'] == ''){
				?>
				<div class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('Save the url of privacy policy page of your website <a href="%s">here</a>', 'super-socializer'), 'admin.php?page=heateor-social-login#tabs-3'); ?></p>
				</div>
				<?php
			}
			if(!get_option('heateor_ss_gdpr_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsGDPRNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							nonce: '<?php echo wp_create_nonce('heateor_ss_gdpr_notification_nonce') ?>',
							action: 'heateor_ss_gdpr_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_gdpr_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_gdpr_notification" class="notice notice-warning">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('This plugin is GDPR compliant. You need to update the privacy policy of your website regarding the personal data this plugin saves, as mentioned <a href="%s" target="_blank">here</a>', 'super-socializer'), 'http://support.heateor.com/gdpr-and-our-plugins'); ?><input type="button" onclick="heateorSsGDPRNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}

		}

		if(version_compare('7.12.1', $currentVersion) <= 0){
			global $theChampSharingOptions;
			if(isset($theChampSharingOptions['enable']) && ((isset($theChampSharingOptions['hor_enable']) && isset($theChampSharingOptions['horizontal_re_providers']) && in_array('twitter', $theChampSharingOptions['horizontal_re_providers']) && (isset($theChampSharingOptions['horizontal_counts']) || isset($theChampSharingOptions['horizontal_total_shares']))) || (isset($theChampSharingOptions['vertical_enable']) && isset($theChampSharingOptions['vertical_re_providers']) && in_array('twitter', $theChampSharingOptions['vertical_re_providers']) && (isset($theChampSharingOptions['vertical_counts']) || isset($theChampSharingOptions['vertical_total_shares']))))){
				if(!get_option('heateor_ss_twitcount_notification_read')){
					?>
					<script type="text/javascript">
					function heateorSsTwitcountNotificationRead(){
						jQuery.ajax({
							type: 'GET',
							url: '<?php echo get_admin_url() ?>admin-ajax.php',
							data: {
								nonce: '<?php echo wp_create_nonce('heateor_ss_twitcount_notification_nonce') ?>',
								action: 'heateor_ss_twitcount_notification_read'
							},
							success: function(data, textStatus, XMLHttpRequest){
								jQuery('#heateor_ss_twitcount_notification').fadeOut();
							}
						});
					}
					</script>
					<div id="heateor_ss_twitcount_notification" class="notice notice-warning">
						<h3>Super Socializer</h3>
						<p><?php echo sprintf( __('Now plugin supports a new service Twitcount.com to show Twitter shares. To continue showing the Twitter shares, click "Give me my Twitter counts back" button at <a href="%s" target="_blank">their website</a> and register your website %s with them. No need to copy-paste any code from their website.', 'super-socializer'), 'http://twitcount.com', home_url()); ?><input type="button" onclick="heateorSsTwitcountNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
					</div>
					<?php
				}
			}

		}

		if(version_compare('7.12.2', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) && is_array($theChampLoginOptions['providers']) && in_array('twitter', $theChampLoginOptions['providers'])){
			if(!get_option('heateor_ss_twitter_new_callback_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsTwitterNewCbNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							nonce: '<?php echo wp_create_nonce('heateor_ss_twitter_new_callback_notification_nonce') ?>',
							action: 'heateor_ss_twitter_new_callback_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_twitter_new_callback_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_twitter_new_callback_notification" class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('Replace url saved in "Callback URLs" option in your Twitter app settings from %s for Twitter login to work. For more details, check step 4 <a href="%s" target="_blank">here</a>', 'super-socializer'), home_url(), 'http://support.heateor.com/how-to-get-twitter-api-key-and-secret/'); ?><input type="button" onclick="heateorSsTwitterNewCbNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}
		}

		if(version_compare('7.12.17', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) && is_array($theChampLoginOptions['providers']) && in_array('linkedin', $theChampLoginOptions['providers'])){
			if(!get_option('heateor_ss_linkedin_redirect_url_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsLinkedinNewRuNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							nonce: '<?php echo wp_create_nonce('heateor_ss_linkedin_redirect_url_notification_nonce') ?>',
							action: 'heateor_ss_linkedin_redirect_url_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_linkedin_redirect_url_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_linkedin_redirect_url_notification" class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('If you cannot get Linkedin login to work after updating the plugin, replace url saved in "Redirect URLs" option in your Linkedin app settings with %s. For more details, check step 6 <a href="%s" target="_blank">here</a>', 'super-socializer'), home_url().'/?SuperSocializerAuth=Linkedin', 'http://support.heateor.com/how-to-get-linkedin-api-key/'); ?><input type="button" onclick="heateorSsLinkedinNewRuNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Dismiss', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}
		}

		if(version_compare('7.12.22', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) && is_array($theChampLoginOptions['providers']) && in_array('linkedin', $theChampLoginOptions['providers'])){
			if(!(isset($theChampLoginOptions['enable']) && $theChampLoginOptions['fb_key'] && $theChampLoginOptions['fb_secret'] && in_array('facebook', $theChampLoginOptions['providers'])) && ((isset($theChampSharingOptions['horizontal_re_providers']) && in_array('facebook', $theChampSharingOptions['horizontal_re_providers']) && (isset($theChampSharingOptions['horizontal_counts']) || isset($theChampSharingOptions['horizontal_total_shares']))) || (isset($theChampSharingOptions['vertical_re_providers']) && in_array('facebook', $theChampSharingOptions['vertical_re_providers']) && (isset($theChampSharingOptions['vertical_counts']) || isset($theChampSharingOptions['vertical_total_shares'])))) && !get_option('heateor_ss_fb_count_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsFBCountNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							nonce: '<?php echo wp_create_nonce('heateor_ss_fb_count_notification_nonce') ?>',
							action: 'heateor_ss_fb_count_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_fb_count_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_fb_count_notification" class="error">
					<h3>Super Socializer</h3>
					<p>
						<?php echo sprintf(__("After the recent changes introduced in the Facebook graph API, it's not possible to track Facebook shares using it. <a href='%s' target='_blank'>Social Shares Tracker</a> add-on allows you to track shares not just for Facebook but for all the social networks", 'super-socializer'), 'https://www.heateor.com/social-shares-tracker/'); ?>
						<p><input type="button" onclick="heateorSsFBCountNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Dismiss', 'super-socializer') ?>" /></p>
					</p>
				</div>
				<?php
			}
		}
	}
}
add_action('admin_notices', 'the_champ_addon_update_notification');

/**
 * Update options based on plugin version check
 */
function the_champ_update_db_check(){
	$currentVersion = get_option('the_champ_ss_version');

	if($currentVersion && $currentVersion != THE_CHAMP_SS_VERSION){
		if(version_compare("7.13.58", $currentVersion) > 0){
			global $theChampLoginOptions, $theChampSharingOptions;
			if(isset($theChampLoginOptions['providers']) && is_array($theChampLoginOptions['providers']) && count($theChampLoginOptions['providers']) > 0){
				$theChampLoginOptions['providers'] = the_champ_replace_array_value($theChampLoginOptions['providers'], 'twitter', 'x');
			}
			if(!isset($theChampSharingOptions['linkedin_login_type'])){
				$theChampLoginOptions['linkedin_login_type'] = 'oauth';
			}
			update_option('the_champ_login', $theChampLoginOptions);
			if(!isset($theChampSharingOptions['google_news_url'])){
				$theChampSharingOptions['google_news_url'] = '';
			}
			if(!isset($theChampSharingOptions['vertical_google_news_url'])){
				$theChampSharingOptions['vertical_google_news_url'] = '';
			}
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		if(version_compare("7.13.40", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['youtube_key'] = '';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.13.37", $currentVersion) > 0){
			global $theChampSharingOptions, $theChampLoginOptions;
			$theChampSharingOptions['rutube_url'] = '';
			$theChampSharingOptions['vertical_rutube_url'] = '';
			update_option('the_champ_sharing', $theChampSharingOptions);
			$theChampLoginOptions['allow_cyrillic'] = array('cyrillic', 'arabic');
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.13.36", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['odnoklassniki_client_id'] = '';
			$theChampLoginOptions['odnoklassniki_client_secret'] = '';
			$theChampLoginOptions['odnoklassniki_public_key'] = '';
			$theChampLoginOptions['yandex_client_id'] = '';
			$theChampLoginOptions['yandex_client_secret'] = '';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.13.34", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['username_separator'] = 'dash';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.13.31", $currentVersion) > 0){
			global $theChampSharingOptions;
			$theChampSharingOptions['youtube_username'] = '';
			$theChampSharingOptions['vertical_youtube_username'] = '';
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		if(version_compare("7.13.28", $currentVersion) > 0){
			global $theChampSharingOptions;
			$networksToRemove = array('DZone', 'CiteULike', 'Wanelo');
			if($theChampSharingOptions['vertical_re_providers']){
				$theChampSharingOptions['vertical_re_providers'] = array_diff($theChampSharingOptions['vertical_re_providers'], $networksToRemove);
				$theChampSharingOptions['vertical_re_providers'] = array_unique(str_replace('parler', 'Parler', $theChampSharingOptions['vertical_re_providers']));
			}
			if($theChampSharingOptions['horizontal_re_providers']){
				$theChampSharingOptions['horizontal_re_providers'] = array_diff($theChampSharingOptions['horizontal_re_providers'], $networksToRemove);
				$theChampSharingOptions['horizontal_re_providers'] = array_unique(str_replace('parler', 'Parler', $theChampSharingOptions['horizontal_re_providers']));

			}
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		if(version_compare("7.13.19", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['mailru_client_id'] = '';
			$theChampLoginOptions['mailru_client_secret'] = '';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.13.16", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['stackoverflow_client_id'] = '';
			$theChampLoginOptions['stackoverflow_client_secret'] = '';
			$theChampLoginOptions['stackoverflow_key'] = '';
			$theChampLoginOptions['amazon_client_id'] = '';
			$theChampLoginOptions['amazon_client_secret'] = '';
			$theChampLoginOptions['discord_channel_id'] = '';
			$theChampLoginOptions['discord_channel_secret'] = '';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.13.12", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['reddit_client_id'] = '';
			$theChampLoginOptions['reddit_client_secret'] = '';
			$theChampLoginOptions['disqus_public_key'] = '';
			$theChampLoginOptions['disqus_secret_key'] = '';
			$theChampLoginOptions['foursquare_client_id'] = '';
			$theChampLoginOptions['foursquare_client_secret'] = '';
			$theChampLoginOptions['dropbox_app_key'] = '';
			$theChampLoginOptions['dropbox_app_secret'] = '';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.13.7", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['twitch_client_id'] = '';
			$theChampLoginOptions['twitch_client_secret'] = '';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.12.45", $currentVersion) > 0){
			global $theChampLoginOptions,$theChampSharingOptions,$theChampCounterOptions;
			$theChampSharingOptions['bitly_access_token'] = '';
			update_option('the_champ_sharing', $theChampSharingOptions);
			$theChampCounterOptions['bitly_access_token'] = '';
			update_option('the_champ_counter', $theChampCounterOptions);
			$theChampLoginOptions['insta_id'] = '';
			$theChampLoginOptions['insta_app_secret'] = '';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.12.39", $currentVersion) > 0){
			global $theChampLoginOptions;
			$networksToRemove = array('twitch', 'xing', 'liveJournal');
			if(isset($theChampLoginOptions['providers']) && count($theChampLoginOptions['providers']) > 0){
				$theChampLoginOptions['providers'] = array_diff($theChampLoginOptions['providers'], $networksToRemove);
			}
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.12.32", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['tc_placeholder'] = 'Terms and Conditions';
			$theChampLoginOptions['tc_url'] = '';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.12.25", $currentVersion) > 0){
			global $theChampSharingOptions;
			if(!$theChampSharingOptions['fb_key'] && !$theChampSharingOptions['fb_secret'] && $theChampSharingOptions['vertical_fb_key'] && $theChampSharingOptions['vertical_fb_secret']){
				$theChampSharingOptions['fb_key'] = $theChampSharingOptions['vertical_fb_key'];
				$theChampSharingOptions['fb_secret'] = $theChampSharingOptions['vertical_fb_secret'];
			}
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		if(version_compare("7.12.22", $currentVersion) > 0){
			global $theChampSharingOptions;
			$theChampSharingOptions['fb_key'] = '';
			$theChampSharingOptions['fb_secret'] = '';
			$theChampSharingOptions['vertical_fb_key'] = '';
			$theChampSharingOptions['vertical_fb_secret'] = '';
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		if(version_compare("7.12.19", $currentVersion) > 0){
			global $theChampSharingOptions;
			$networksToRemove = array('google_plus', 'google_plusone', 'google_plus_share');
			if($theChampSharingOptions['vertical_re_providers']){
				$theChampSharingOptions['vertical_re_providers'] = array_diff($theChampSharingOptions['vertical_re_providers'], $networksToRemove);
			}
			if($theChampSharingOptions['horizontal_re_providers']){
				$theChampSharingOptions['horizontal_re_providers'] = array_diff($theChampSharingOptions['horizontal_re_providers'], $networksToRemove);
			}
			update_option('the_champ_sharing', $theChampSharingOptions);

			global $theChampCounterOptions;
			$networksToRemove = array('google_plus', 'google_plusone', 'google_plus_share');
			if($theChampCounterOptions['vertical_providers']){
				$theChampCounterOptions['vertical_providers'] = array_diff($theChampCounterOptions['vertical_providers'], $networksToRemove);
			}
			if($theChampCounterOptions['horizontal_providers']){
				$theChampCounterOptions['horizontal_providers'] = array_diff($theChampCounterOptions['horizontal_providers'], $networksToRemove);
			}
			update_option('the_champ_counter', $theChampCounterOptions);

			global $theChampFacebookOptions;
			$theChampFacebookOptions['commenting_order'] = str_replace(',googleplus', '', $theChampFacebookOptions['commenting_order']);
			$theChampFacebookOptions['commenting_order'] = str_replace('googleplus,', '', $theChampFacebookOptions['commenting_order']);
			update_option('the_champ_facebook', $theChampFacebookOptions);
		}

		if(version_compare("7.12.7", $currentVersion) > 0){
			global $theChampSharingOptions;
			$networksToRemove = array('yahoo', 'Yahoo_Messenger', 'delicious', 'Polyvore', 'Oknotizie', 'Baidu', 'diHITT', 'Netlog', 'NewsVine', 'NUjij', 'Segnalo', 'Stumpedia', 'YouMob');
			if($theChampSharingOptions['vertical_re_providers']){
				$theChampSharingOptions['vertical_re_providers'] = array_diff($theChampSharingOptions['vertical_re_providers'], $networksToRemove);
			}
			if($theChampSharingOptions['horizontal_re_providers']){
				$theChampSharingOptions['horizontal_re_providers'] = array_diff($theChampSharingOptions['horizontal_re_providers'], $networksToRemove);
			}
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		if(version_compare("7.12.5", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['gdpr_placement'] = 'above';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.12.1", $currentVersion) > 0){
			global $theChampSharingOptions;
			$theChampSharingOptions['tweet_count_service'] = 'opensharecount';
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		if(version_compare("7.12", $currentVersion) > 0){
			global $theChampSharingOptions, $theChampCounterOptions, $theChampLoginOptions;

			$theChampLoginOptions['scl_title'] = __('Link your social account to login to your account at this website', 'super-socializer');
			update_option('the_champ_login', $theChampLoginOptions);

			if(isset($theChampSharingOptions['horizontal_re_providers'])){
				foreach($theChampSharingOptions['horizontal_re_providers'] as $key => $social_network){
					if($social_network == 'stumbleupon_badge'){
						unset($theChampSharingOptions['horizontal_re_providers'][$key]);
					}elseif($social_network == 'stumbleupon'){
						$theChampSharingOptions['horizontal_re_providers'][$key] = 'mix';
					}
				}
			}
			if(isset($theChampSharingOptions['vertical_re_providers'])){
				foreach($theChampSharingOptions['vertical_re_providers'] as $key => $social_network){
					if($social_network == 'stumbleupon_badge'){
						unset($theChampSharingOptions['vertical_re_providers'][$key]);
					}elseif($social_network == 'stumbleupon'){
						$theChampSharingOptions['vertical_re_providers'][$key] = 'mix';
					}
				}
			}
			update_option('the_champ_sharing', $theChampSharingOptions);

			if(isset($theChampCounterOptions['horizontal_providers'])){
				foreach($theChampCounterOptions['horizontal_providers'] as $key => $social_network){
					if($social_network == 'stumbleupon_badge'){
						unset($theChampCounterOptions['horizontal_providers'][$key]);
					}
				}
			}
			if(isset($theChampCounterOptions['vertical_providers'])){
				foreach($theChampCounterOptions['vertical_providers'] as $key => $social_network){
					if($social_network == 'stumbleupon_badge'){
						unset($theChampCounterOptions['vertical_providers'][$key]);
					}
				}
			}
			update_option('the_champ_counter', $theChampCounterOptions);
		}

		if(version_compare("7.11.13", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['gdpr_enable'] = 1;
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.11.12", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['privacy_policy_optin_text'] = 'I agree to my personal data being stored and used as per Privacy Policy';
			$theChampLoginOptions['ppu_placeholder'] = 'Privacy Policy';
			$theChampLoginOptions['privacy_policy_url'] = '';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.9", $currentVersion) > 0){
			global $theChampSharingOptions;
			$theChampSharingOptions['comment_container_id'] = 'respond';
			$theChampSharingOptions['vertical_comment_container_id'] = 'respond';
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		if(version_compare("7.8.22", $currentVersion) > 0){
			global $theChampSharingOptions;
			$theChampSharingOptions['bottom_sharing_position_radio'] = 'responsive';
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		if(version_compare("7.8.14", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['link_account'] = '1';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.8.13", $currentVersion) > 0){
			global $theChampGeneralOptions;
			$theChampGeneralOptions['browser_msg_enable'] = '1';
			$theChampGeneralOptions['browser_msg'] = __('Your browser is blocking some features of this website. Please follow the instructions at {support_url} to unblock these.', 'super-socializer');
			update_option('the_champ_general', $theChampGeneralOptions);
		}

		if(version_compare("7.7", $currentVersion) > 0){
			global $theChampSharingOptions;
			$theChampSharingOptions['instagram_username'] = '';
			$theChampSharingOptions['vertical_instagram_username'] = '';
			update_option('the_champ_sharing', $theChampSharingOptions);
		}
		
		if(version_compare("7.6", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['new_user_admin_email'] = '1';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("6.0", $currentVersion) > 0){
			global $theChampFacebookOptions;
			$theChampFacebookOptions['enable_post'] = '1';
			$theChampFacebookOptions['enable_page'] = '1';
			update_option('the_champ_facebook', $theChampFacebookOptions);
		}

		if(version_compare('7.0', $currentVersion) > 0){
			global $theChampSharingOptions, $theChampLoginOptions, $theChampGeneralOptions;
			
			$theChampSharingOptions['horizontal_re_providers'] = the_champ_replace_array_value($theChampSharingOptions['horizontal_re_providers'], 'google', 'google_plus');
			$theChampSharingOptions['vertical_re_providers'] = the_champ_replace_array_value($theChampSharingOptions['vertical_re_providers'], 'google', 'google_plus');

			// general options
			if(isset($theChampLoginOptions['footer_script'])){
				$theChampGeneralOptions['footer_script'] = '1';
			}
			if(isset($theChampSharingOptions['delete_options'])){
				$theChampGeneralOptions['delete_options'] = '1';
			}

			$theChampSharingOptions['horizontal_sharing_width'] = '70';
			$theChampSharingOptions['horizontal_sharing_height'] = '35';
			$theChampSharingOptions['horizontal_sharing_height'] = '35';
			$theChampSharingOptions['horizontal_border_radius'] = '';
		    $theChampSharingOptions['horizontal_font_color_default'] = '';
		    $theChampSharingOptions['horizontal_sharing_replace_color'] = '#fff';
		    $theChampSharingOptions['horizontal_font_color_hover'] = '';
		    $theChampSharingOptions['horizontal_sharing_replace_color_hover'] = '#fff';
		    $theChampSharingOptions['horizontal_bg_color_default'] = '';
		    $theChampSharingOptions['horizontal_bg_color_hover'] = '';
		    $theChampSharingOptions['horizontal_border_width_default'] = '';
		    $theChampSharingOptions['horizontal_border_color_default'] = '';
		    $theChampSharingOptions['horizontal_border_width_hover'] = '';
		    $theChampSharingOptions['horizontal_border_color_hover'] = '';
		    $theChampSharingOptions['vertical_sharing_width'] = '80';
			$theChampSharingOptions['vertical_sharing_height'] = '40';
			$theChampSharingOptions['vertical_border_radius'] = '';
			$theChampSharingOptions['vertical_font_color_default'] = '';
			$theChampSharingOptions['vertical_sharing_replace_color'] = '#fff';
			$theChampSharingOptions['vertical_font_color_hover'] = '';
			$theChampSharingOptions['vertical_sharing_replace_color_hover'] = '#fff';
			$theChampSharingOptions['vertical_bg_color_default'] = '';
			$theChampSharingOptions['vertical_bg_color_hover'] = '';
			$theChampSharingOptions['vertical_border_width_default'] = '';
			$theChampSharingOptions['vertical_border_color_default'] = '';
			$theChampSharingOptions['vertical_border_width_hover'] = '';
			$theChampSharingOptions['vertical_border_color_hover'] = '';
			$theChampSharingOptions['vertical_screen_width'] = '783';
			$theChampSharingOptions['horizontal_screen_width'] = '783';
			$theChampSharingOptions['bottom_sharing_position'] = '0';
			$theChampSharingOptions['bottom_sharing_alignment'] = 'left';
			$theChampSharingOptions['buffer_username'] = '';
			$theChampSharingOptions['language'] = get_locale();
			$theChampSharingOptions['tweet_count_service'] = 'newsharecounts';

			if(isset($theChampSharingOptions['horizontal_counts'])){
				$theChampSharingOptions['horizontal_counter_position'] = 'top';
			}
			if(isset($theChampSharingOptions['vertical_counts'])){
				if(!isset($theChampSharingOptions['vertical_sharing_shape']) || $theChampSharingOptions['vertical_sharing_shape'] == 'square'){
					$theChampSharingOptions['vertical_counter_position'] = 'inner_top';
				}elseif($theChampSharingOptions['vertical_sharing_shape'] == 'round'){
					$theChampSharingOptions['vertical_counter_position'] = 'top';
				}
			}

			update_option('the_champ_sharing', $theChampSharingOptions);
			update_option('the_champ_general', $theChampGeneralOptions);
		}

		if(version_compare('7.2', $currentVersion) > 0){
			$theChampSharingOptions['share_count_cache_refresh_count'] = '10';
			$theChampSharingOptions['share_count_cache_refresh_unit'] = 'minutes';
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		update_option('the_champ_ss_version', THE_CHAMP_SS_VERSION);
	}
}
add_action('plugins_loaded', 'the_champ_update_db_check');

/**
 * CSS to load at front end for AMP
 */
function the_champ_frontend_amp_css(){
	
	if(!the_champ_is_amp_page()){
		return;
	}

	global $theChampSharingOptions;
	
	$css = '';

	if(current_action() == 'wp_print_styles'){
		$css .= '<style type="text/css">';
	}

	// background color of amp icons
	$css .= 'a.the_champ_amp{padding:0 4px;}div.the_champ_horizontal_sharing a amp-img{display:inline-block;margin:0 4px;}.the_champ_amp_parler img{background-color:#892E5E}.the_champ_amp_instagram img{background-color:#624E47}.the_champ_amp_yummly img{background-color:#E16120}.the_champ_amp_buffer img{background-color:#000}.the_champ_amp_teams img{background-color:#5059c9}.the_champ_amp_google_translate img{background-color:#528ff5}.the_champ_amp_rss img{background-color:#e3702d}.the_champ_amp_x img{background-color:#2a2a2a}.the_champ_amp_facebook img{background-color:#3C589A}.the_champ_amp_digg img{background-color:#006094}.the_champ_amp_email img{background-color:#649A3F}.the_champ_amp_float_it img{background-color:#53BEEE}.the_champ_amp_google img{background-color:#dd4b39}.the_champ_amp_google_plus img{background-color:#dd4b39}.the_champ_amp_linkedin img{background-color:#0077B5}.the_champ_amp_pinterest img{background-color:#CC2329}.the_champ_amp_print img{background-color:#FD6500}.the_champ_amp_reddit img{background-color:#FF5700}.the_champ_amp_stocktwits img{background-color: #40576F}.the_champ_amp_mix img{background-color:#ff8226}.the_champ_amp_tumblr img{background-color:#29435D}.the_champ_amp_twitter img{background-color:#55acee}.the_champ_amp_vkontakte img{background-color:#0077FF}.the_champ_amp_yahoo img{background-color:#8F03CC}.the_champ_amp_xing img{background-color:#00797D}.the_champ_amp_mastodon img{background-color:#2b90d9}.the_champ_amp_instagram img{background-color:#527FA4}.the_champ_amp_whatsapp img{background-color:#55EB4C}.the_champ_amp_aim img{background-color: #10ff00}.the_champ_amp_amazon_wish_list img{background-color: #ffe000}.the_champ_amp_aol_mail img{background-color: #2A2A2A}.the_champ_amp_app_net img{background-color: #5D5D5D}.the_champ_amp_balatarin img{background-color: #fff}.the_champ_amp_bibsonomy img{background-color: #000}.the_champ_amp_bitty_browser img{background-color: #EFEFEF}.the_champ_amp_blinklist img{background-color: #3D3C3B}.the_champ_amp_blogger_post img{background-color: #FDA352}.the_champ_amp_blogmarks img{background-color: #535353}.the_champ_amp_bookmarks_fr img{background-color: #E8EAD4}.the_champ_amp_box_net img{background-color: #1A74B0}.the_champ_amp_buddymarks img{background-color: #ffd400}.the_champ_amp_care2_news img{background-color: #6EB43F}.the_champ_amp_citeulike img{background-color: #2781CD}.the_champ_amp_comment img{background-color: #444}.the_champ_amp_diary_ru img{background-color: #E8D8C6}.the_champ_amp_diaspora img{background-color: #2E3436}.the_champ_amp_diigo img{background-color: #4A8BCA}.the_champ_amp_douban img{background-color: #497700}.the_champ_amp_draugiem img{background-color: #ffad66}.the_champ_amp_dzone img{background-color: #fff088}.the_champ_amp_evernote img{background-color: #8BE056}.the_champ_amp_facebook_messenger img{background-color: #0084FF}.the_champ_amp_fark img{background-color: #555}.the_champ_amp_fintel img{background-color:#087515}.the_champ_amp_flipboard img{background-color: #CC0000}.the_champ_amp_folkd img{background-color: #0F70B2}.the_champ_amp_google_classroom img{background-color: #FFC112}.the_champ_amp_google_bookmarks img{background-color: #CB0909}.the_champ_amp_google_gmail img{background-color: #E5E5E5}.the_champ_amp_hacker_news img{background-color: #F60}.the_champ_amp_hatena img{background-color: #00A6DB}.the_champ_amp_instapaper img{background-color: #EDEDED}.the_champ_amp_jamespot img{background-color: #FF9E2C}.the_champ_amp_kakao img{background-color: #FCB700}.the_champ_amp_kik img{background-color: #2A2A2A}.the_champ_amp_kindle_it img{background-color: #2A2A2A}.the_champ_amp_known img{background-color: #fff101}.the_champ_amp_line img{background-color: #00C300}.the_champ_amp_livejournal img{background-color: #EDEDED}.the_champ_amp_mail_ru img{background-color: #356FAC}.the_champ_amp_mendeley img{background-color: #A70805}.the_champ_amp_meneame img{background-color: #FF7D12}.the_champ_amp_mewe img{background-color: #007da1}.the_champ_amp_mixi img{background-color: #EDEDED}.the_champ_amp_myspace img{background-color: #2A2A2A}.the_champ_amp_netvouz img{background-color: #c0ff00}.the_champ_amp_odnoklassniki img{background-color: #F2720C}.the_champ_amp_outlook_com img{background-color: #0072C6}.the_champ_amp_papaly img{background-color: #3AC0F6}.the_champ_amp_pinboard img{background-color: #1341DE}.the_champ_amp_plurk img{background-color: #CF682F}.the_champ_amp_pocket img{background-color: #ee4056}.the_champ_amp_printfriendly img{background-color: #61D1D5}.the_champ_amp_protopage_bookmarks img{background-color: #413FFF}.the_champ_amp_pusha img{background-color: #0072B8}.the_champ_amp_qzone img{background-color: #2B82D9}.the_champ_amp_refind img{background-color: #1492ef}.the_champ_amp_rediff_mypage img{background-color: #D20000}.the_champ_amp_renren img{background-color: #005EAC}.the_champ_amp_sina_weibo img{background-color: #ff0}.the_champ_amp_sitejot img{background-color: #ffc800}.the_champ_amp_skype img{background-color: #00AFF0}.the_champ_amp_sms img{background-color: #6ebe45}.the_champ_amp_slashdot img{background-color: #004242}.the_champ_amp_svejo img{background-color: #fa7aa3}.the_champ_amp_symbaloo_feeds img{background-color: #6DA8F7}.the_champ_amp_telegram img{background-color: #3DA5f1}.the_champ_amp_trello img{background-color: #1189CE}.the_champ_amp_tuenti img{background-color: #0075C9}.the_champ_amp_twiddla img{background-color: #EDEDED}.the_champ_amp_typepad_post img{background-color: #2A2A2A}.the_champ_amp_viadeo img{background-color: #2A2A2A}.the_champ_amp_viber img{background-color: #8B628F}.the_champ_amp_wanelo img{background-color: #fff}.the_champ_amp_webnews img{background-color: #CC2512}.the_champ_amp_wordpress img{background-color: #464646}.the_champ_amp_wykop img{background-color: #367DA9}.the_champ_amp_yahoo_mail img{background-color: #400090}.the_champ_amp_yahoo_messenger img{background-color: #400090}.the_champ_amp_yoolink img{background-color: #A2C538}.the_champ_amp_threema img{background-color: #2A2A2A}.the_champ_amp_youmob img{background-color: #3B599D}.the_champ_amp_youtube img{background-color:red}.the_champ_amp_rutube img{background-color:#14191f}.the_champ_amp_gentlereader img{background-color: #46aecf}.the_champ_amp_goodreads img{background-color:#ce6f2d}.the_champ_amp_gab img{background-color:#25CC80}.the_champ_amp_gettr img{background-color:#E50000}';

	// css for horizontal sharing bar
	if($theChampSharingOptions['horizontal_sharing_shape'] == 'round'){
		$css .= '.the_champ_amp amp-img{border-radius:999px;}';
	}elseif($theChampSharingOptions['horizontal_border_radius'] != ''){
		$css .= '.the_champ_amp amp-img{border-radius:'.$theChampSharingOptions['horizontal_border_radius'].'px;}';
	}

	if(current_action() == 'wp_print_styles'){
		$css .= '</style>';
	}

	echo $css;
}