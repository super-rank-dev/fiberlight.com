<?php
/*
 * Ajax Submissions 
 */


//add_filter('qcformbuilder_forms_render_grid_structure', 'wfb_ajax_structures', 10, 2);
add_action('qcformbuilder_forms_redirect', 'wfb_ajax_redirect', 10, 4 );
add_filter('qcformbuilder_forms_render_form_classes', 'wfb_ajax_register_scripts', 10, 2);
add_action('qcformbuilder_forms_general_settings_panel', 'wfb_form_ajaxsetup');
// add ajax actions
add_action( 'wp_ajax_wfb_process_ajax_submit', 'wfb_form_process_ajax' );
add_action( 'wp_ajax_nopriv_wfb_process_ajax_submit', 'wfb_form_process_ajax' );


function wfb_form_process_ajax(){
	// hook into submision
	//_wfb_cr_pst
	global $post;
	if( !empty( $_POST['_wfb_cr_pst'] ) ){
		$post = get_post( (int) $_POST['_wfb_cr_pst'] );
	}

	Qcformbuilder_Forms::process_form_via_post();
}


function wfb_form_ajaxsetup($form){
	if( !isset( $form['custom_callback'] ) ){
		$form['custom_callback'] = null;
	}
?>
<div class="qcformbuilder-config-group">
	<fieldset>
		<legend><?php echo esc_html__( 'Ajax Submissions', 'qcformbuilder-forms'); ?></legend>
		<div class="qcformbuilder-config-field">
			<input type="checkbox" id="qcformbuilder-forms-enable_ajax" value="1" name="config[form_ajax]" class="field-config"<?php if(isset($form['form_ajax'])){ echo ' checked="checked"'; } ?>>
			<label for="qcformbuilder-forms-enable_ajax"><?php echo esc_html__( 'Enable Ajax Submissions. (No page reloads)', 'qcformbuilder-forms'); ?></label>
		</div>
	</fieldset>
</div>


<div class="qcformbuilder-config-group">
	<fieldset>
		<legend><?php esc_html_e( 'Custom Callback', 'qcformbuilder-forms'); ?></legend>
		<div class="qcformbuilder-config-field">
			<input id="qcformbuilder-forms-custom_callback" type="checkbox" onclick="jQuery('#custom_callback_panel').toggle();" value="1" name="config[has_ajax_callback]" class="field-config"<?php if(isset($form['has_ajax_callback'])){ echo ' checked="checked"'; } ?>><label for="qcformbuilder-forms-custom_callback"><?php echo esc_html__( 'Add a custom Javascript callback handlers on submission.', 'qcformbuilder-forms'); ?></label>
		</div>
	</fieldset>

</div>

<div id="custom_callback_panel" <?php if(empty($form['has_ajax_callback'])){ echo 'style="display:none;"'; } ?>>
	
	<div class="qcformbuilder-config-group">
		<fieldset>
			<legend>
				<?php esc_html_e( 'Inhibit Notices', 'qcformbuilder-forms'); ?>
			</legend>
			<div class="qcformbuilder-config-field">
				<input id="qcformbuilder-forms-inhbit_notices" type="checkbox" value="1" name="config[inhibit_notice]" class="field-config"<?php if(isset($form['inhibit_notice'])){ echo ' checked="checked"'; } ?>><label for="qcformbuilder-forms-inhbit_notices"><?php esc_html_e("Don't show default alerts (success etc.)", 'qcformbuilder-forms'); ?></label>
			</div>
		</fieldset>
	</div>


	<div class="qcformbuilder-config-group" style="width:500px;">
		<fieldset>
			<legend>
				<?php esc_html_e( 'Callback Function', 'qcformbuilder-forms'); ?>
			</legend>
			<div class="qcformbuilder-config-field">
				<input id="qcformbuilder-forms-custom_callback" type="text" value="<?php echo $form['custom_callback']; ?>" name="config[custom_callback]" class="field-config block-input" aria-describedby="qcformbuilder-forms-custom_callback-desc">
				<p class="description" id="qcformbuilder-forms-custom_callback-desc">
					<?php esc_html_e('Javascript function to call on submission. Passed an object containing form submission result.'); ?> <a href="#" onclick="jQuery('#json_callback_example').toggle();return false;"><?php esc_html_e( 'See Example', 'qcformbuilder-forms' ); ?></a>
				</p>
					<pre id="json_callback_example" style="display:none;"><?php echo htmlentities('
{    
    "data": {
        "wfb_id"		: "200", // Form Entry ID
        "my_var" 	: "custom passback variable defined in variables tab",
        "my_other" 	: "another custom passback variable",
        "get_var"	: "GET variable from embedded page",
        "more_var"	: "another GET variable",
    },
    "url"		: "redirect url. only included if redirection is needed. e.g redirect processor",
    "result"	: "Sent. Thank you, David.", // result text after magic tag render.
    "html"		: "<div class=\"alert alert-success\">Sent. Thank you, David.</div>",
    "type"		: "complete",
    "form_id"	: "CF551d804e0d72e",
    "form_name"	: "Example Form",
    "status"	: "complete"
}'); ?>
				</pre>
			</div>
		</fieldset>
	</div>




</div>

<div class="qcformbuilder-config-group">
	<fieldset>
		<legend>
			<?php echo esc_html__( 'Multiple Ajax Submissions', 'qcformbuilder-forms'); ?>
		</legend>
		<div class="qcformbuilder-config-field">
			<input for="qcformbuilder-forms-multi-ajax" type="checkbox" value="1" name="config[form_ajax_post_submission_disable]" class="field-config"<?php if(isset($form['form_ajax_post_submission_disable'])){ echo ' checked="checked"'; } ?>><label for="qcformbuilder-forms-multi-ajax"><?php esc_html_e( 'If set, form can be submitted multiple times with out a new page load.', 'qcformbuilder-forms'); ?></label>
		</div>
	</fieldset>
</div>
<?php	
}



function wfb_ajax_redirect($type, $url, $form){

	if(empty($form['form_ajax'])){
		return;
	}

	if( empty( $_POST['cfajax'] ) || empty( $_POST['action'] ) || $_POST['action'] != 'wfb_process_ajax_submit' ){
		return;
	}

	$data = Qcformbuilder_Forms::get_submission_data($form);
	
	// setup notcies
	$urlparts = parse_url($url);
	$query = array();

	if(!empty($urlparts['query'])){
		parse_str($urlparts['query'], $query);
	}

	$notices = array();
	$note_general_classes = Qcformbuilder_Forms_Render_Notices::get_note_general_classes( $form );

	// base id
	$form_id = 'qcformbuilder_form_1';

	if($type == 'complete'){
		if(isset($query['wfb_su'])){
			$notices['success']['note'] = $form['success'];
			$form_id = 'qcformbuilder_form_' . $query['wfb_su'];
		}else{
			$out['url'] = $url;
			$notices['success']['note'] = esc_html__( 'Redirecting', 'qcformbuilder-forms');
		}
	}elseif($type == 'preprocess'){
		if(isset($query['wfb_er'])){
			$data = Qcformbuilder_Forms_Transient::get_transient( $query['wfb_er'] );
			if(!empty($data['note'])){
				$notices[$data['type']]['note'] = $data['note'];
			}

		}else{
			$out['url'] = $url;
			$notices['success']['note'] = esc_html__( 'Redirecting', 'qcformbuilder-forms');
		}

	}elseif($type == 'error'){
		$data = Qcformbuilder_Forms_Transient::get_transient( $query['wfb_er'] );
		if(!empty($data['note'])){
			$notices['error']['note'] = $data['note'];
		}

	}
	// check for field erors
	if(!empty($data['fields'])){
		foreach($form['fields'] as $fieldid=>$field){
			if( isset( $data['fields'][$fieldid] ) ){

				if($urlparts['path'] == 'api'){
					$out['fields'][$field['slug']] = Qcformbuilder_Forms_Sanitize::remove_scripts($data['fields'][$fieldid]);
				}else{
					$out['fields'][$fieldid] = Qcformbuilder_Forms_Sanitize::remove_scripts($data['fields'][$fieldid]);
				}
			}
		}
	}

	$notices = Qcformbuilder_Forms_Render_Notices::prepare_notices( $notices, $form );
	$note_classes = Qcformbuilder_Forms_Render_Notices::get_note_classes( $note_general_classes, $form );

	$html = Qcformbuilder_Forms_Render_Notices::html_from_notices( $notices, $note_classes );

	if(!empty($result)){
		$out['result'] = $result;
	}

	if(!empty($query)){
		if(!empty($query['wfb_su'])){
			unset($query['wfb_su']);
		}
		if(!empty($query['wfb_ee'])){
			$out['entry'] = $query['wfb_ee'];
		}
		$out['data'] = $query;
	}
	$out['html'] = Qcformbuilder_Forms_Sanitize::remove_scripts($html);
	$out['type'] = ( isset($data['type']) ? $data['type'] : $type );
	$out['form_id'] = $form['ID'];
	$out['form_name'] = $form['name'];	
	$out['status'] = $type;

	if( ! empty( $form[ 'scroll_top' ] ) ){
		$out[ 'scroll' ] = Qcformbuilder_Forms_Render_Util::notice_element_id( $form, absint( $_POST[ '_wfb_frm_ct' ]  ) );
	}

	$out = apply_filters( 'qcformbuilder_forms_ajax_return', $out, $form);
	qcformbuilder_forms_send_json( $out );
	exit;

}

function wfb_ajax_register_scripts($classes, $form){
	if(empty($form['form_ajax'])){
		return $classes;
	}


	// enqueue scripts
	wp_enqueue_script( 'wfb-baldrick' );
	wp_enqueue_script( 'wfb-ajax' );

	$classes[] = 'cfajax-trigger';

	return $classes;
}

function wfb_ajax_setatts($atts, $form){
	global $current_form_count;

	$post_disable = 0;
	if ( isset( $form[ 'form_ajax_post_submission_disable' ] ) ) {
		$post_disable = $form[ 'form_ajax_post_submission_disable' ];
	}
	
	$resatts = array(
		'data-target'		=>	'#qcformbuilder_notices_'.$current_form_count,
		'data-template'		=>	'#cfajax_'.$form['ID'].'-tmpl',
		'data-cfajax'		=>	$form['ID'],
		'data-load-element' =>	'_parent',
		'data-load-class' 	=>	'wfb_processing',
		'data-post-disable' =>	$post_disable,
		'data-action'		=>	'wfb_process_ajax_submit',
		'data-request'		=>	wfb_ajax_api_url( $form[ 'ID' ] ),
	);
	
	if( !empty( $form['custom_callback'] ) ){
		$resatts['data-custom-callback'] = $form['custom_callback'];
	}
	if( !empty( $form['has_ajax_callback']) && !empty( $form['inhibit_notice'] ) ){
		$resatts['data-inhibitnotice'] = true;
	}

	if(!empty($form['hide_form'])){
		$resatts['data-hiderows'] = "true";
	}

	return array_merge($atts, $resatts);

}

/**
 * Get URL for API for processing a form
 *
 * @since 1.3.2
 *
 * @param string $form_id Form ID
 *
 * @return string
 */
function wfb_ajax_api_url( $form_id ) {
	
	return Qcformbuilder_Forms::get_submit_url( $form_id );

}


/**
 * Perform a redirect using the best means possible
 *
 * This is copypasted from Pods. Thanks Pods! Very GPL.
 *
 * @param string $location The path to redirect to.
 * @param int $status Optional. Status code to use. Default is 302
 *
 * @return void
 *
 * @since 1.3.4
 */
function wfb_redirect( $location, $status = 302 ) {
	if ( !headers_sent() ) {
		wp_redirect( $location, $status );
		die();
	}else {
		die( '<script type="text/javascript">'
		     . 'document.location = "' . str_replace( '&amp;', '&', esc_js( $location ) ) . '";'
		     . '</script>' );
	}

}
