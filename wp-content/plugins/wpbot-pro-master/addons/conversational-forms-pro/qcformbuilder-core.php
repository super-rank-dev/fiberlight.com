<?php

// If this file is called directly, abort.
if ( !defined('WPINC') ) {
	die;
}

add_action( 'init', function(){
    //hack to make code splitting work.
    if( false !== strpos( $_SERVER['REQUEST_URI'], 'wp-admin/clients/') ){
        wfb_redirect(plugin_dir_url(__FILE__).str_replace( '/wp-admin/', '',$_SERVER['REQUEST_URI']));exit;
    }

});

global $wp_version;
if ( !version_compare(PHP_VERSION, '5.6.0', '>=') ) {
	function qcformbuilder_forms_php_version_nag()
	{
		?>
        <div class="notice notice-error">
            <p>
				<?php _e('Your version of PHP is incompatible with Chatbot Form Builder and can not be used.',
					'qcformbuilder-forms'); ?>
				</p>
        </div>
		<?php
	}

	add_shortcode('qcformbuilder_form', 'qcformbuilder_forms_fallback_shortcode');
	add_shortcode('qcformbuilder_form_modal', 'qcformbuilder_forms_fallback_shortcode');
	add_action('admin_notices', 'qcformbuilder_forms_php_version_nag');
} elseif ( !version_compare($wp_version, '4.7.0', '>=') ) {
	function qcformbuilder_forms_wp_version_nag()
	{
		?>
        <div class="notice notice-error">
            <p>
				<?php _e('Your version of WordPress is incompatible with Chatbot Form Builder and can not be used.',
					'qcformbuilder-forms'); ?>
            </p>
        </div>
		<?php
	}

	add_shortcode('qcformbuilder_form', 'qcformbuilder_forms_fallback_shortcode');
	add_shortcode('qcformbuilder_form_modal', 'qcformbuilder_forms_fallback_shortcode');
	add_action('admin_notices', 'qcformbuilder_forms_wp_version_nag');
} else {
	define('WFBCORE_PATH', plugin_dir_path(__FILE__));
	define('WFBCORE_URL', plugin_dir_url(__FILE__));
	define( 'WFBCORE_VER', '1.5.1' );
	define('WFBCORE_EXTEND_URL', '');
	define('WFBCORE_BASENAME', plugin_basename(__FILE__));

	/**
	 * Chatbot Form Builder DB version
	 *
	 * @since 1.3.4
	 *
	 * PLEASE keep this an integer
	 */
	define('WFB_DB', 8);

	// init internals of CF
	include_once WFBCORE_PATH . 'classes/core.php';

	add_action('init', [ 'Qcformbuilder_Forms', 'init_wfb_internal' ]);
	// table builder
	register_activation_hook(__FILE__, [ 'Qcformbuilder_Forms', 'activate_qcformbuilder_forms' ]);


	// load system
	add_action('plugins_loaded', 'qcformbuilder_forms_load', 0);
	function qcformbuilder_forms_load()
	{
		include_once WFBCORE_PATH . 'classes/autoloader.php';
		include_once WFBCORE_PATH . 'classes/widget.php';
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_DB', WFBCORE_PATH . 'classes/db');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Entry', WFBCORE_PATH . 'classes/entry');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Email', WFBCORE_PATH . 'classes/email');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Admin', WFBCORE_PATH . 'classes/admin');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Render', WFBCORE_PATH . 'classes/render');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Sync', WFBCORE_PATH . 'classes/sync');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_CSV', WFBCORE_PATH . 'classes/csv');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Processor_Interface', WFBCORE_PATH . 'processors/classes/interfaces');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_API', WFBCORE_PATH . 'classes/api');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Field', WFBCORE_PATH . 'classes/field');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Magic', WFBCORE_PATH . 'classes/magic');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Processor', WFBCORE_PATH . 'processors/classes');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Shortcode', WFBCORE_PATH . 'classes/shortcode');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_CDN', WFBCORE_PATH . 'classes/cdn');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Settings', WFBCORE_PATH . 'classes/settings');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Import', WFBCORE_PATH . 'classes/import');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms_Query', WFBCORE_PATH . 'classes/query');
		Qcformbuilder_Forms_Autoloader::add_root('Qcformbuilder_Forms', WFBCORE_PATH . 'classes');
		Qcformbuilder_Forms_Autoloader::register();


		// includes
		include_once WFBCORE_PATH . 'includes/ajax.php';
		include_once WFBCORE_PATH . 'includes/field_processors.php';
		include_once WFBCORE_PATH . 'includes/custom_field_class.php';
		include_once WFBCORE_PATH . 'includes/filter_addon_plugins.php';
		include_once WFBCORE_PATH . 'includes/compat.php';
		include_once WFBCORE_PATH . 'processors/functions.php';
		include_once WFBCORE_PATH . 'includes/functions.php';
		include_once WFBCORE_PATH . 'ui/blocks/init.php';
		include_once WFBCORE_PATH . 'vendor/autoload.php';
		include_once WFBCORE_PATH . 'includes/wfb-pro-client/wfb-pro-init.php';
		//require_once WFBCORE_PATH . 'plugin-upgrader/plugin-upgrader.php';
		

		/**
		 * Runs after all of the includes and autoload setup is done in Chatbot Form Builder core
		 *
		 * @since 1.3.5.3
		 */
		do_action('qcformbuilder_forms_includes_complete');

		/**
		 * Start cf2 system
		 *
		 * @since 1.8.0
		 */
		add_action('qcformbuilder_forms_v2_init', 'qcformbuilder_forms_v2_container_setup' );
		qcformbuilder_forms_get_v2_container();
	}

	add_action('plugins_loaded', [ 'Qcformbuilder_Forms', 'get_instance' ]);


	// Admin & Admin Ajax stuff.
	if ( is_admin() || defined('DOING_AJAX') ) {
		add_action('plugins_loaded', [ 'Qcformbuilder_Forms_Admin', 'get_instance' ]);
		add_action('plugins_loaded', [ 'Qcformbuilder_Forms_Support', 'get_instance' ]);
		include_once WFBCORE_PATH . 'includes/plugin-page-banner.php';
	}


	//@see https://github.com/QcformbuilderWP/Qcformbuilder-Forms/issues/2855
	add_filter( 'qcformbuilder_forms_pro_log_mode', '__return_false' );
	add_filter( 'qcformbuilder_forms_pro_mail_debug', '__return_false' );


}

/**
 * Shortcode handler to be used when Chatbot Form Builder can not be loaded
 *
 * @since 1.7.0
 *
 * @return string
 */
function qcformbuilder_forms_fallback_shortcode()
{
	if ( current_user_can('edit_posts') ) {
		return esc_html__('Your version of WordPress or PHP is incompatible with Chatbot Form Builder.', 'qcformbuilder-forms');
	}

	return esc_html__('Form could not be loaded. Contact the site administrator.', 'qcformbuilder-forms');

}
if(!function_exists('qc_get_first_field')){
	function qc_get_first_field($array){
		foreach($array as $k=>$v){
			return $k;
		}
	}
}

if(!function_exists('qcld_condition_check')){
	function qcld_condition_check($form, $condition, $entry, $session){
		
		global $wpdb;
		$group = $condition['group'];
		$result = false;
		$multior = array();
		$formid = $form['ID'];
		foreach($group as $key=>$value){
			$falsecount = 0;
			$comparesult = array();
			foreach($value as $k=>$v){

				$fieldid = $v['field'];
				$compare = $v['compare'];
				$val = $v['value'];
				$fields = $form['fields'];

				$row = array();
				$all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$session.'_data' );
				if( $all_answers && ! empty( $all_answers ) ){
					foreach( $all_answers as $answer ){
						if( $answer->field_id == $fieldid ){
							$row = ($answer);
							break;
						}
					}
				}else{
					if($entry>0){
						$row = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_form_entry_values WHERE 1 and `field_id` = '".$fieldid."' and `entry_id`='".$entry."' limit 1");
					}else{
						$row = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_form_entry_values WHERE 1 and `field_id` = '".$fieldid."' order by id desc limit 1");
					}
				}

				if(!empty($row)){
					if(isset($fields[$fieldid]['type']) && $fields[$fieldid]['type']=='dropdown'){
						if($compare=='is'){
							foreach($fields[$fieldid]['config']['option'] as $ok=>$ov){
								if($ok==$val && $ov['value']==$row->value){
									$result = true;
									$comparesult[$k] = 1;
								}
							}
							
							if(!isset($comparesult[$k])){
								$result = false;
								$falsecount++;
							}
						}
						
						if($compare=='isnot'){
							
							foreach($fields[$fieldid]['config']['option'] as $ok=>$ov){
								if($ok==$val && $ov['value']!=$row->value){
									$result = true;
									$comparesult[$k] = 1;
								}
							}
							
							if(!isset($comparesult[$k])){
								$result = false;
								$falsecount++;
							}

						}

					}elseif(isset($fields[$fieldid]['type']) && $fields[$fieldid]['type']=='checkbox'){
						
						if($compare=='is'){
							
							foreach($fields[$fieldid]['config']['option'] as $ok=>$ov){
								if($ok==$val && $ov['value']==$row->value){
									$result = true;
									$comparesult[$k] = 1;
								}
							}
							
							if(!isset($comparesult[$k])){
								$result = false;
								$falsecount++;
							}

						}
						if($compare=='isnot'){
							
							foreach($fields[$fieldid]['config']['option'] as $ok=>$ov){
								if($ok==$val && $ov['value']!=$row->value){
									$result = true;
									$comparesult[$k] = 1;
								}
							}
							
							if(!isset($comparesult[$k])){
								$result = false;
								$falsecount++;
							}

						}
						
						if($compare=='contains'){
							
							foreach($fields[$fieldid]['config']['option'] as $ok=>$ov){
								
								if($ok==$val && in_array(trim($ov['value']), array_map('trim', explode(',', $row->value)))){
									$result = true;
									$comparesult[$k] = 1;
								}
							}
							
							
							if(!isset($comparesult[$k])){
								$result = false;
								$falsecount++;
							}
						}
						
						
					}else{

						if($compare=='is'){
							if($row->value==$val){
								$result = true;
							}else{
								$result = false;
								$falsecount++;
							}
						}
						if($compare=='isnot'){
							if($row->value!=$val){
								$result = true;
							}else{
								$result = false;
								$falsecount++;
							}
						}
						if($compare=='smaller'){
							if(number_format((float)$row->value, 1, '.', '') <= $val){
								$result = true;
							}else{
								$result = false;
								$falsecount++;
							}
						}
						if($compare=='greater'){
							if(number_format((float)$row->value, 1, '.', '') >= $val){
								$result = true;
							}else{
								$result = false;
								$falsecount++;
							}
							
						}
						if($compare=='contains'){

							if (strpos($row->value, $val) !== false) {
								$result = true;
							}else{
								$result = false;
								$falsecount++;
							}
						}

					}
				}
				
				

			}
			
			if($falsecount>0){
				$result = false;
			}
			
			if($result){
				$multior[$key] = 1;
			}
			
			

		}

		
		$checkor = true;
		if(empty($multior)){
			$checkor = false;
		}
		if($checkor){
			return true;
		}else{
			return false;
		}
		
		
	}
}




if(!function_exists('qc_get_next_field')){
	function qc_get_next_field($form, $fieldid, $entry, $session){
		global $wpdb;

		$conditions = array();
		if(isset($form['conditional_groups']['conditions'])){
			$conditions = $form['conditional_groups']['conditions'];
		}
		
		
		
		$fields = $form['fields'];
		$trigger = 0;
		foreach($form['layout_grid']['fields'] as $k=>$v){
			if($trigger==1){
				
				if(trim($fields[$k]['conditions']['type'])!=''){

					$condition = trim($fields[$k]['conditions']['type']);
					if(qcld_condition_check($form, $conditions[$condition], $entry, $session )==true){
						return $k;
					}else{
						return qc_get_next_field($form, $k, $entry, $session);
					}

				}else{
					return $k;
				}

			}
			if($k==$fieldid){
				$trigger = 1;
			}

		}
		if($trigger==0){
			return 'none';
		}
	}
}


add_action( 'wp_ajax_wpbot_get_form',        'wpbot_get_form' );
add_action( 'wp_ajax_nopriv_wpbot_get_form', 'wpbot_get_form' );
if(!function_exists('wpbot_get_form')){
	function wpbot_get_form(){
		global $wpdb;

		$formid = sanitize_text_field($_POST['formid']);
		if(isset($_POST['session'])){
			$session = sanitize_text_field($_POST['session']);
		}else{
			$session = '';
		}
		$result = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_forms where form_id='".$formid."' and type='primary'");

		$form = unserialize($result->config);
		qcbot_conv_cookies_data_delete( $formid.'_'.$session.'_data' );
		if( $formid!='' && $session!='' ){
			qcbot_conv_cookies( $formid.'_'.$session, json_encode( $result ) );
		}
		$fields = $form['fields'];
		//print_r($form['layout_grid']['fields']);exit;
		if(isset($form['layout_grid']['fields']) && !empty($form['layout_grid']['fields'])){
			
			$firstfield = qc_get_first_field($form['layout_grid']['fields']);
			$field = $fields[$firstfield];
			if( $field['type']=='html' ){
				$field['config']['default'] =  apply_filters( 'the_content', $field['config']['default'] );
				qcbot_conv_cookies_data_set($formid.'_'.$session.'_conversation', array( 'Bot::'.$field['config']['default'] ));
			}else{
				qcbot_conv_cookies_data_set($formid.'_'.$session.'_conversation', array( 'Bot::'.$field['label'] ));
			}
			echo json_encode($field);
		}
		
		die();
	}
}

if (!function_exists('qc_array_key_first')) {
    function qc_array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}
function qc_cv_fnc_get_ip_address(){

    if (!empty($_SERVER['HTTP_CLIENT_IP']))   
    {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
    {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from remote address
    else
    {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;

}

add_action( 'wp_ajax_wpbot_capture_form_value',        'wpbot_capture_form_value' );
add_action( 'wp_ajax_nopriv_wpbot_capture_form_value', 'wpbot_capture_form_value' );
if(!function_exists('wpbot_capture_form_value')){
	function wpbot_capture_form_value(){
		global $wpdb;

		$formid = sanitize_text_field($_POST['formid']);
		$fieldid = sanitize_text_field($_POST['fieldid']);
		$answer = (isset($_POST['answer'])?$_POST['answer']:'');
		$entry = (isset( $_POST['entry'] ) ? sanitize_text_field($_POST['entry']): '');
		$session = (isset( $_POST['session'] ) ? sanitize_text_field($_POST['session']) : '' );

		

/* 		if($entry==0){
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
		} */

		$result = qcbot_conv_cookies_get( $formid.'_'.$session );
		if( ! $result || empty( $result ) ){
			$result = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_forms where form_id='".$formid."' and type='primary'");
		}

		$form = unserialize($result->config);
		
		$processors = (isset($form['processors'])?$form['processors']:array());

		$mailer = (isset($form['mailer'])?$form['mailer']:array());
		
		$variables = ( isset( $form['variables'] ) ? $form['variables'] : '' ) ;

		$fieldetails = qc_get_details_by_fieldid($form, $fieldid);

		if($answer!=''){
			qcbot_conv_cookies_data_set($formid.'_'.$session.'_conversation', array( 'User::'.$answer ));
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
				if( $formid !='' && $session!='' ){
					qcbot_conv_cookies_data_set( $formid.'_'.$session.'_data', $data );
				}
				
			}else{
				$data[] = array(
					'entry_id'  => $entry,
					'field_id'   => $fieldid,
					'slug'	=> (isset($fieldetails['slug'])?$fieldetails['slug']:''),
					'value'	=> stripslashes($answer)
				);

				if( $formid !='' && $session!='' ){
					qcbot_conv_cookies_data_set( $formid.'_'.$session.'_data', $data );
				}
			}
			
		}

		$fields = $form['fields'];
		$conditions = array();
		if(isset($form['conditional_groups']['conditions'])){
			$conditions = $form['conditional_groups']['conditions'];
		}

		
		if(isset($form['layout_grid']['fields']) && !empty($form['layout_grid']['fields'])){
			
			$nextfield = qc_get_next_field($form, $fieldid, $entry, $session);

			if($nextfield!='none' && $nextfield!='' && !empty($fields[$nextfield])){

				$field = $fields[$nextfield];
				$field = qc_check_field_variables($form, $field, $variables, $entry, $session);
				$field['entry'] = $entry;
				$field['status'] = 'incomplete';
				if($field['type']=='calculation'){
					$field = qc_formbuilder_do_calculation($field, $entry, $form, $session);
				//	var_dump($field);wp_die();
				}else if( $field['type']=='html' ){
					$field['config']['default'] =  apply_filters( 'the_content', $field['config']['default'] );
					qcbot_conv_cookies_data_set($formid.'_'.$session.'_conversation', array( 'Bot::'.$field['config']['default'] ));
				}else{
					qcbot_conv_cookies_data_set($formid.'_'.$session.'_conversation', array( 'Bot::'.$field['label'] ));
				}
				
				echo json_encode($field);

			}else{

				if(isset($mailer['on_insert']) && $mailer['on_insert']==1){
					$answers = qc_form_answer($form, $fields, $entry, $session);
					qcld_wb_chatbot_send_form_query($answers, $mailer, $formid, $session);
					
				}
				
				if(!empty($processors) && isset($processors[qc_array_key_first($processors)]['runtimes'])){
					$entrydetails = qc_form_entry_details($form, $fields, $entry, $session);
					qcld_wb_chatbot_send_autoresponse($entrydetails, $processors, $formid, $session);
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

				$all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$session.'_data' );

				
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

				qcbot_conv_cookies_data_delete( $formid.'_'.$session.'_data' );
				qcbot_conv_cookies_data_delete( $formid.'_'.$session );
				qcbot_conv_cookies_data_delete($formid.'_'.$session.'_conversation');
				echo json_encode(array('status'=>'complete'));
			}
			
		}else{

			if(isset($mailer['on_insert']) && $mailer['on_insert']==1){
				$answers = qc_form_answer($form, $fields, $entry, $session);
				qcld_wb_chatbot_send_form_query($answers, $mailer, $formid, $session);
			}

			if(!empty($processors) && isset($processors[qc_array_key_first($processors)]['runtimes'])){
				$entrydetails = qc_form_entry_details($form, $fields, $entry, $session);
				qcld_wb_chatbot_send_autoresponse($entrydetails, $processors, $formid, $session);
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
			$all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$session.'_data' );
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
			
			qcbot_conv_cookies_data_delete( $formid.'_'.$session.'_data' );
			qcbot_conv_cookies_data_delete( $formid.'_'.$session );
			qcbot_conv_cookies_data_delete($formid.'_'.$session.'_conversation');
			
			echo json_encode(array('status'=>'complete'));
		}
		
		die();
	}
}
if(!function_exists('qc_check_field_variables')){
	function qc_check_field_variables($form, $field, $variables, $entry, $session){
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


if(!function_exists('qc_formbuilder_do_calculation')){
	function qc_formbuilder_do_calculation($field, $entry, $form, $session){
		global $wpdb;
		
		$formid = $form['ID'];
		$calfieldids = array();
		$calgroups = $field['config']['config']['group'];
		$formular = $field['config']['formular'];
		foreach($calgroups as $calgroup){
			
			if(isset($calgroup['lines']) && !empty($calgroup['lines'])){
				
				foreach($calgroup['lines'] as $line){
					if(isset($line['field']) && $line['field']!=''){
						$calfieldids[] = $line['field'];
					}					
				}
				
			}
			
		}
	
		
		if(!empty($calfieldids)){
			
			//$fieldquery = "('".implode("', '", $calfieldids)."')";				
			//$results = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."wfb_form_entry_values where entry_id='".$entry."' and field_id in ".$fieldquery);

			$results = array();
			$all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$session.'_data' );
			if( $all_answers && ! empty( $all_answers ) ){
				if( !empty( $calfieldids ) ){
					foreach( $calfieldids as $calfieldid ){
						foreach( $all_answers as $answer ){
							if( $answer->field_id == $calfieldid ){
								$results[] = ($answer);
							}
						}
					}
				}
				
			}
			
			
			$keyvalue = array();
			if(!empty($results)){
				foreach($results as $result){
					$fieldetails = qc_get_details_by_fieldid($form, $result->field_id);
					
					$iscal_value = qc_is_cal_value($result->value, $fieldetails);
					
					if($iscal_value>0){
						$keyvalue[$result->field_id] = $iscal_value;
					}else{
						$keyvalue[$result->field_id] = $result->value;
					}
					
				}
				//var_dump($fieldetails);
				$formulafields = array_keys($keyvalue);
				$formulavalue = array_values($keyvalue);
				$formular = preg_replace('/\s+/', '', str_replace($formulafields, $formulavalue, $formular));
				$Cal = new QCField_calculate();
				$calresult = $Cal->calculate($formular);
				$cal_val = "print (".$calresult.");";
				$field['calbefore'] = $field['config']['before'];
				$field['calafter'] = $field['config']['after'];
				$field['calresult'] = $calresult;
				$field['calvalue'] = $calresult;

				return $field;
				
			}else{
				$field['calresult'] = $field['config']['before'].' 0 '.$field['config']['after'];
				$field['calvalue'] = 0;
				return $field;
			}
			
		}else{
			
			$field['calresult'] = $field['config']['before'].' 0 '.$field['config']['after'];
			$field['calvalue'] = 0;
			return $field;
			
		}
		
	}
}

function qc_is_cal_value($value, $fieldetails){
	
	$returnval = 0;
	
	if($fieldetails['type']=='dropdown'){
		
		$options = $fieldetails['config']['option'];
		
		
		foreach($options as $option){
			
			if($option['value']==$value && isset($option['calc_value']) && $option['calc_value']!=''){
				$returnval = $option['calc_value'];
			}
		}
		
	}elseif($fieldetails['type']=='checkbox'){
		
		$value = explode(',', $value);
		
		
		
		$options = $fieldetails['config']['option'];
		foreach($options as $option){
			if(in_array($option['value'], $value) && isset($option['calc_value']) && $option['calc_value']!=''){
				$returnval += $option['calc_value'];
			}
		}
		
		
		
	}
	
	
	return $returnval;
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
if(!function_exists('qc_form_answer')){
	function qc_form_answer($form, $fields, $entry, $session){
		global $wpdb;
		$data = array();
		$formid = $form['ID'];
		foreach($fields as $key=>$field){
			$fieldid = $field['ID'];
			$question = $field['label'];
			//$result = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_form_entry_values where entry_id='".$entry."' and field_id='".$fieldid."'");

			$result = array();
			$all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$session.'_data' );
			if( $all_answers && ! empty( $all_answers ) ){
				foreach( $all_answers as $answer ){
					if( $answer->field_id == $fieldid ){
						$result = ($answer);
						break;
					}
				}
			}

			$answer = '';
			if(!empty($result)){
				$answer = $result->value;
			}
			if($answer!=''){
				$data[] = array(
					'question'=>$question,
					'answer' => $answer,
					'type'	=> $field['type']
				);
			}
		}
		return $data;
	}
}
if(!function_exists('qc_form_entry_details')){
	function qc_form_entry_details($form, $fields, $entry, $session){
		global $wpdb;
		$data = array();
		$formid = $form['ID'];
		foreach($fields as $key=>$field){
			$fieldid = $field['ID'];
			$question = '%'.$field['slug'].'%';

			//$result = $wpdb->get_row("SELECT * FROM ". $wpdb->prefix."wfb_form_entry_values where entry_id='".$entry."' and field_id='".$fieldid."'");

			$result = array();
			$all_answers = qcbot_conv_cookies_data_get( $formid.'_'.$session.'_data' );
			if( $all_answers && ! empty( $all_answers ) ){
				foreach( $all_answers as $answer ){
					if( $answer->field_id == $fieldid ){
						$result = ($answer);
						break;
					}
				}
			}

			$answer = '';
			if(!empty($result)){
				$answer = $result->value;
			}
			if($answer!=''){
				$data[$question] = $answer;
			}
		}
		return $data;
	}
}

if(!function_exists('qcld_wb_chatbot_send_form_query')){
	function qcld_wb_chatbot_send_form_query($datas, $mailer, $formid, $session) {

		$addition_name = trim(sanitize_text_field($_POST['name']));
		$addition_email = sanitize_email($_POST['email']);
		$addition_refurl = esc_url_raw($_POST['url']);
		$addition_user_agent = $_SERVER['HTTP_USER_AGENT'];
    	$addition_ip_address = qc_cv_fnc_get_ip_address();
		
		$subject = (isset($mailer['email_subject']) && $mailer['email_subject']!=''?$mailer['email_subject']:'Conversational form data from Chatbot');
		//Extract Domain
		$url = get_site_url();
		$url = parse_url($url);
		$domain = $url['host'];
		
		$admin_email = get_option('admin_email');
		$toEmail = get_option('qlcd_wp_chatbot_admin_email') != '' ? get_option('qlcd_wp_chatbot_admin_email') : $admin_email;
		$fromEmail = "wordpress@" . $domain;
		if(isset($mailer['sender_email']) && $mailer['sender_email']!=''){
			$fromEmail = $mailer['sender_email'];
		}
		
		$name = 'Conversational Form';
		
		if(isset($mailer['sender_name']) && $mailer['sender_name']!=''){
			$name = $mailer['sender_name'];
		}

		
		
		$bodyContent = "";
		$conversation_details_text = (get_option('qlcd_wp_chatbot_conversation_details')!=''?maybe_unserialize(get_option('qlcd_wp_chatbot_conversation_details')):'Conversation Details');

		if( is_array( $conversation_details_text ) && isset( $conversation_details_text[get_locale()] )){
			$conversation_details_text = $conversation_details_text[get_locale()];
		}


		$bodyContent .= '<p><strong>' . $conversation_details_text . ':</strong></p><hr>';
		
		$hasAttachment = false;
		$attachments = array();
		
		
		foreach($datas as $data){
			
			if(isset($data['question'])){
				$bodyContent .= '<p>'.esc_html($data['question']).': ' . esc_html($data['answer']) . '</p>';
			}
			if(isset($data['type']) && $data['type']=='file'){
				$hasAttachment = true;
				$image_path = @explode('wp-content/', $data['answer'])[1];
				if(file_exists(WP_CONTENT_DIR.'/'.$image_path)){
					$attachments[] = WP_CONTENT_DIR.'/'.$image_path;
				}
				
			}

		}
		$bodyContent .= '<p><strong>Additional Information Collected by Chatbot:</strong></p><hr>';
		$bodyContent .= '<p>' . esc_html__('Name', 'wpchatbot') . ' : ' . esc_html($addition_name) . '</p>';
        $bodyContent .= '<p>' . esc_html__('Email', 'wpchatbot') . ' : ' . esc_html($addition_email) . '</p>';
		$bodyContent .= '<p>' . esc_html__('Page URL', 'wpchatbot') . ' : ' . ($addition_refurl) . '</p>';
        $bodyContent .= '<p>' . esc_html__('User Agent', 'wpchatbot') . ' : ' . ($addition_user_agent) . '</p>';
        $bodyContent .= '<p>' . esc_html__('IP Address', 'wpchatbot') . ' : ' . ($addition_ip_address) . '</p>';
		
		$conversationdata = qcbot_conv_cookies_data_get( $formid.'_'.$session.'_conversation' );
		krsort($conversationdata);
		$body = apply_filters( 'qc_conv_mail_content_filter', $bodyContent, $conversationdata, $conversation_details_text );


		if(isset($mailer['recipients']) && $mailer['recipients']!=''){
			
			$recipients = explode(',', $mailer['recipients']);
			foreach($recipients as $toEmail){
				
			//build email body

				$headers = array();
				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				$headers[] = 'From: ' . esc_html($name) . ' <' . esc_html($fromEmail) . '>';
				if($hasAttachment){
					@wp_mail(trim($toEmail), $subject, $body, $headers, $attachments);
				}else{
					@wp_mail(trim($toEmail), $subject, $body, $headers);
				}
				
			}
			
		}else{
			$headers = array();
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$headers[] = 'From: ' . esc_html($name) . ' <' . esc_html($fromEmail) . '>';
			if($hasAttachment){
				@wp_mail(trim($toEmail), $subject, $body, $headers, $attachments);
			}else{
				@wp_mail(trim($toEmail), $subject, $body, $headers);
			}
					
		}

		
	}
}

if(!function_exists('qcld_wb_chatbot_send_autoresponse')){
	
	function qcld_wb_chatbot_send_autoresponse($entrydetails, $processors, $formid, $session){

		foreach ( $processors as $key => $processor ) {

			if( ! isset( $processor['runtimes'] ) ){
				continue;
			}

			$config = $processor['config'];
		
			$url = get_site_url();
			$url = parse_url($url);
			$domain = $url['host'];
			
			$sender_name = (isset($entrydetails[$config['sender_name']])?$entrydetails[$config['sender_name']]:$config['sender_name']);
			
			$sender_email = (isset($config['sender_email'])?$config['sender_email']:"wordpress@".$domain);
			
			$subject = (isset($entrydetails[$config['subject']])?$entrydetails[$config['subject']]:$config['subject']);
			$subject = str_replace(array_keys($entrydetails), array_values($entrydetails), $subject);
			$recipient_name = (isset($entrydetails[$config['recipient_name']])?$entrydetails[$config['recipient_name']]:$config['recipient_name']);
			$recipient_email = (isset($entrydetails[$config['recipient_email']])?$entrydetails[$config['recipient_email']]:$config['recipient_email']);
			$message = str_replace(array_keys($entrydetails), array_values($entrydetails), $config['message']);
			$message = str_replace( '%recipient_name%', $recipient_name, $message );
			$headers = array();
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$headers[] = 'From: ' . esc_html($sender_name) . ' <' . esc_html($sender_email) . '>';

			$conversationdata = qcbot_conv_cookies_data_get( $formid.'_'.$session.'_conversation' );
			krsort($conversationdata);
			$message = apply_filters( 'qc_conv_autoresponder_content_filter', $message, $conversationdata );

			if(isset($config['enable_condition']) && $config['enable_condition']==1){
				
				if(isset($config['condition_field']) && $config['condition_field']!=''){
					
					$condition_field = isset($entrydetails[$config['condition_field']])?$entrydetails[$config['condition_field']]:'';
					$con_status = false;
					if($config['condition']=='contain'){
						
						if (strpos($condition_field, $config['condition_value']) !== false) {
							$con_status = true;
						}
						
					}elseif($config['condition']=='is'){
						if($condition_field==$config['condition_value']){
							$con_status = true;
						}
					}
					
					if($con_status==true){
						@wp_mail(trim($recipient_email), $subject, $message, $headers);
					}
					
				}
				
			}else{
				@wp_mail(trim($recipient_email), $subject, $message, $headers);
			}
		}
		
	}
	
}


if(!class_exists('QCField_calculate')){
	class QCField_calculate {
		const PATTERN = '/(?:\-?\d+(?:\.?\d+)?[\+\-\*\/])+\-?\d+(?:\.?\d+)?/';

		const PARENTHESIS_DEPTH = 10;

		public function calculate($input){
			
			if(strpos($input, '+') != null || strpos($input, '-') != null || strpos($input, '/') != null || strpos($input, '*') != null){
				//  Remove white spaces and invalid math chars
				$input = str_replace(',', '.', $input);
				$input = preg_replace('[^0-9\.\+\-\*\/\(\)]', '', $input);
				
				//  Calculate each of the parenthesis from the top
				$i = 0;
				while(strpos($input, '(') || strpos($input, ')')){
					$input = preg_replace_callback('/\(([^\(\)]+)\)/', 'self::callback', $input);
					

					$i++;
					if($i > self::PARENTHESIS_DEPTH){
						break;
					}
				}
				
				//  Calculate the result
				if(preg_match(self::PATTERN, $input, $match)){
					return $match[0];
				}
				// To handle the special case of expressions surrounded by global parenthesis like "(1+1)"
				if(is_numeric($input)){
					return $input;
				}

				return 0;
			}

			return $input;
		}

		// private function compute($input){
		// //	

		// 	return $input;
		// 	// eval($math_string);

		// }

		private function callback($input){
			
			if(is_numeric($input[1])){
				return $input[1];
			}
			elseif(preg_match(self::PATTERN, $input[1], $match)){
				//var_dump($match[0]);wp_die();
				return $match[0];
			}

			return 0;
		}
	}
}

function qc_phoneMask_scripts_function() {
  wp_enqueue_script( 'qcmaskphone', WFBCORE_URL . 'assets/js/jquery.mask.js', array('jquery'), false, true );
}
add_action('wp_enqueue_scripts','qc_phoneMask_scripts_function');

add_action('admin_enqueue_scripts', 'qcld_conversation_admin_scripts');

function qcld_conversation_admin_scripts(){
	if(isset($_GET['page']) && $_GET['page']=='qcformbuilder-forms'){
		
		wp_register_style('qcld-wp-conversation-admin-css', WFBCORE_URL . 'assets/build/css/admin.min.css', '', 1.0, 'screen');
		wp_enqueue_style('qcld-wp-conversation-admin-css');
		
		wp_register_style('qcld-wp-conversation-processoredit-css', WFBCORE_URL . 'assets/build/css/processors-edit.min.css', '', 1.0, 'screen');
		wp_enqueue_style('qcld-wp-conversation-processoredit-css');
		
		wp_register_style('qcld-wp-conversation-editorgrid-css', WFBCORE_URL . 'assets/build/css/editor-grid.min.css', '', 1.0, 'screen');
		wp_enqueue_style('qcld-wp-conversation-editorgrid-css');
	}
}

/**
 * Set cookie for formbuilder
 *
 * @param string $form_id
 * 
 * @param object $data
 * 
 * @return null
 */
function qcbot_conv_cookies( $form_id, $data ) {
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once (ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
	}
	$cache_dir = WFBCORE_PATH.'cache/';
	$dir = $wp_filesystem->find_folder($cache_dir);
	$file = trailingslashit($dir) . $form_id.".txt";
	if( file_exists( $file ) ){
		unlink( $file );
	}
    $wp_filesystem->put_contents($file, $data, FS_CHMOD_FILE);
}

function qcbot_conv_cookies_data_set( $form_id, $data ){
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once (ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
	}
	$cache_dir = WFBCORE_PATH.'cache/';
	$dir = $wp_filesystem->find_folder($cache_dir);
	$file = trailingslashit($dir) . $form_id.".txt";

	$existing_data = qcbot_conv_cookies_data_get( $form_id );
	if( $existing_data && ! empty( $existing_data ) && is_array( $existing_data ) ){
		$data = array_merge( $data, $existing_data );
	}
	if( file_exists( $file ) ){
		unlink( $file );
	}
    $wp_filesystem->put_contents($file, json_encode($data), FS_CHMOD_FILE);
}

function qcbot_conv_cookies_data_get( $form_id ){
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once (ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
	}
	$cache_dir = WFBCORE_PATH.'cache/';
	$file = trailingslashit($cache_dir) . $form_id.".txt";
	if($wp_filesystem->exists($file))
    {
      $text = $wp_filesystem->get_contents($file);
      if(!$text)
      {
        return false;
      }
      else
      {
        return json_decode( $text );
      }
    } 
    else
    {
      return false;      
    } 
}

function qcbot_conv_cookies_data_delete( $form_id ){
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once (ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
	}
	$cache_dir = WFBCORE_PATH.'cache/';
	$dir = $wp_filesystem->find_folder($cache_dir);
	$file = trailingslashit($dir) . $form_id.".txt";
	if( file_exists( $file ) ){
		unlink( $file );
	}
	return true;
}

/**
 * Get cookie for formbuilder
 *
 * @param string $form_id
 * @return object|bool
 */
function qcbot_conv_cookies_get( $form_id ){
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once (ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
	}
	$cache_dir = WFBCORE_PATH.'cache/';
	$file = trailingslashit($cache_dir) . $form_id.".txt";
	if($wp_filesystem->exists($file))
    {
      $text = $wp_filesystem->get_contents($file);
      if(!$text)
      {
        return false;
      }
      else
      {
        return json_decode( $text );
      }
    } 
    else
    {
      return false;      
    } 
	
}

/**
 * Delete cookie for formbuilder
 *
 * @param string $form_id
 * @return object|bool
 */
function qcbot_conv_cookies_delete( $form_id ){
	if( isset( $_COOKIE[ 'conv_form_'.$form_id ] ) ){
		setcookie('conv_form_'.$form_id, "", time()-3600);
		unset( $_COOKIE[ 'conv_form_'.$form_id ] );
		return true;
	}else{
		return false;
	}
}

function qcld_conv_array_to_object($array) {
	$obj = new stdClass;
	foreach($array as $k => $v) {
	   if(strlen($k)) {
		  if(is_array($v)) {
			 $obj->{$k} = qcld_conv_array_to_object($v); //RECURSION
		  } else {
			 $obj->{$k} = $v;
		  }
	   }
	}
	return $obj;
  }



