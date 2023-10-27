<?php

$btnType = $field['config']['type'];
$btn_action = null;

$attrs = array(
	'class' => $field[ 'config' ][ 'class' ],
	'type' => $btnType,
	'name' => $field_name,
	'id' => $field_id,
	'value' => $field[ 'label' ],
	'data-field' => $field_base_id,
);



if($field['config']['type'] == 'next' || $field['config']['type'] == 'prev'){
	$btnType = 'button';
	$attrs[ 'data-page' ] = $field['config']['type'];
	$field[ 'config' ][ 'class' ] = $field[ 'config' ][ 'class' ] . ' wfb-page-btn wfb-page-btn-' . $field[ 'config' ][ 'type' ];
}elseif( 'button' == $field['config']['type' ] ){
	$btnType = 'button';
	if( !empty( $field['config']['target'] ) ){
		$field['config']['class'] .= ' wfb-form-trigger';
		$attrs[ 'data-target' ] =  esc_attr( $field['config']['target'] );
	}

}elseif( 'reset' == $field['config']['type'] ){
	$btnType = 'reset';
}else{
	$btnType = 'submit';
}

if ( ! empty( $field[ 'config' ][ 'class' ] )  ) {
	$attrs[ 'class' ] = $field[ 'config' ][ 'class' ];
}

$attrs[ 'type' ] = $btnType;


$attr_string_button =  qcformbuilder_forms_field_attributes( $attrs, $field, $form );

$attrs = array(
	'class' => 'button_trigger_' . Qcformbuilder_Forms_Render_Util::get_current_form_count(),
	'type' => 'hidden',
	'name' => $field_name,
	'id' => $field_id . '_btn',
	'value' => $field_value,
	'data-field' => $field_base_id,
);
$attr_string_hidden_field =  qcformbuilder_forms_implode_field_attributes( qcformbuilder_forms_escape_field_attributes_array( $attrs ) );


?>
<?php echo $wrapper_before; ?>
<?php if ( ! empty( $field[ 'config' ][ 'label_space' ] ) ) { ?>
	<label class="control-label">&nbsp;</label>
<?php } ?>
<?php echo $field_before; ?>
	<input  <?php echo $attr_string_button . ' ' . $field_structure[ 'aria' ]; ?>>
<?php echo $field_after; ?>
<?php echo $wrapper_after; ?>
	<input <?php echo $attr_string_hidden_field; ?> />
<?php
ob_start();
?>
<script>	
	window.addEventListener("load", function(){

		jQuery(document).on('click dblclick', '#<?php echo $field_id; ?>', function( e ){
			jQuery('#<?php echo $field_id; ?>_btn').val( e.type ).trigger('change');
		});

	});
</script>
<?php
	$script_template = ob_get_clean();
	Qcformbuilder_Forms_Render_Util::add_inline_data( $script_template, $form );
