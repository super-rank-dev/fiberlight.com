<?php




//add_action('qcformbuilder_forms_field_settings_template', 'wfb_custom_field_classes');
add_filter('qcformbuilder_forms_render_field_classes', 'wfb_apply_field_classes', 10, 3);


function wfb_apply_field_classes($classes, $field, $form){
	
	if(!empty($field['config']['custom_class'])){
		$classes['control_wrapper'][] = $field['config']['custom_class'];
	}
	return $classes;
}

function wfb_custom_field_classes(){
?>
<div class="qcformbuilder-config-group customclass-field">
	<label><?php echo __('Custom Class', 'qcformbuilder-forms'); ?> </label>
	<div class="qcformbuilder-config-field">
		<input type="text" class="block-input field-config" name="{{_name}}[custom_class]" value="{{custom_class}}">
	</div>
</div>
<?php
}


//add_filter('qcformbuilder_forms_get_field_types', 'wfb_live_gravatar_field');

function wfb_live_gravatar_field($fieldtypes){

	$fieldtypes['live_gravatar'] = array(
		"field"			=>	"Gravatar",
		"file"			=>	WFBCORE_PATH . "fields/gravatar/field.php",
		"category"		=>	__( 'Special' , 'qcformbuilder-forms' ),
		"description" 	=> 'A live gravatar preview',
		'icon'          => WFBCORE_URL . 'assets/build/images/user.svg',
		"setup"			=>	array(
			"template"	=>	WFBCORE_PATH . "fields/gravatar/config.php",
			"preview"	=>	WFBCORE_PATH . "fields/gravatar/preview.php",
			"not_supported"	=>	array(
				'entry_list',
				'custom_class'
			)
		)
	);
	return $fieldtypes;
}


add_action( 'wp_ajax_wfb_live_gravatar_get_gravatar', 		'wfb_live_gravatar_get_gravatar' );
add_action( 'wp_ajax_nopriv_wfb_live_gravatar_get_gravatar', 'wfb_live_gravatar_get_gravatar' );


function wfb_live_gravatar_get_gravatar(){
	$defaults = array(
		'email'	=> '',
		'generator' => 'mystery',
		'size' => 100
	);
	$defaults = array_merge( $defaults, $_POST );
	echo get_avatar( Qcformbuilder_Forms::do_magic_tags( $defaults['email'] ), (int) $defaults['size'], $defaults['generator']);
	exit;
}

// field specific stuff.
add_filter( 'qcformbuilder_forms_render_field_classes_type-file', 'qcformbuilder_forms_file_field_class' );
function qcformbuilder_forms_file_field_class($classes){
	$classes['field_wrapper'][] = "file-prevent-overflow";
	return $classes;
}
add_filter( 'qcformbuilder_forms_render_field_classes_type-toggle_switch', 'qcformbuilder_forms_toggle_switch_field_class' );
function qcformbuilder_forms_toggle_switch_field_class($classes){
	$classes['control_wrapper'][] = "wfb-toggle-switch";
	return $classes;
}
add_filter( 'qcformbuilder_forms_render_field_classes_type-color_picker', 'qcformbuilder_forms_color_picker_field_class' );
function qcformbuilder_forms_color_picker_field_class($classes){
	$classes['field_wrapper'][] = "input-group";
	$classes['control_wrapper'][] = "minicolor-picker";
	return $classes;
}
