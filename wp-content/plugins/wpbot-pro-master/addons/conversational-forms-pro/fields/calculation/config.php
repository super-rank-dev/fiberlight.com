

<div class="qcformbuilder-config-group">
	<label for="{{_id}}_before"><?php echo __('Before', 'qcformbuilder-forms'); ?></label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_before" type="text" class="input-block field-config" name="{{_name}}[before]" value="{{before}}">
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="{{_id}}_after"><?php echo __('After', 'qcformbuilder-forms'); ?></label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_after" type="text" class="input-block field-config" name="{{_name}}[after]" value="{{after}}">
	</div>
</div>




<!--
<div class="qcformbuilder-config-group">
	<div class="qcformbuilder-config-field">
		<label><input id="{{_id}}_manual" type="checkbox" class="field-config" name="{{_name}}[manual]" value="1" {{#if manual}}checked="checked"{{/if}}> <?php echo __('Manual Formula', 'qcformbuilder-forms'); ?></label>
	</div>
</div>-->
<div id="{{_id}}_autobox">
	<div class="qcformbuilder-config-group qcformbuilder-config-group-full">
		<button type="button" class="button block-button add-operator-group ajax-trigger" 
		data-template="#calculator-group-tmpl" 
		data-target="#{{_id}}_operator_groups" 
		data-target-insert="append" 
		data-name="{{_name}}" 
		data-id="{{_id}}"
		data-request="calc_add_group"
		data-callback="init_calc_group"
		><?php echo __('Add Operator Group', 'qcformbuilder-forms'); ?></button>
	</div>
	<br>
	<div id="{{_id}}_operator_groups" class="calculation-groups-wrap"></div>
	<input type="hidden" class="block-input field-config calculation-formular" name="{{_name}}[formular]" id="{{_id}}_formular" value="{{formular}}">
	<input type="hidden" class="block-input field-config ajax-trigger" data-request="build_calc_structure" data-callback="{{_id}}_build_formula" data-init="{{_id}}_build_formula" data-event="none" data-autoload="true" data-type="json" data-template="#calculator-group-tmpl" data-target="#{{_id}}_operator_groups" name="{{_name}}[config]" id="{{_id}}_config" value="{{#if config/group}}{{json config}}{{else}}{{config}}{{/if}}">
</div>
<div id="{{_id}}_manualbox" style="display:none;">
	<textarea name="{{_name}}[manual_formula]" class="field-config block-input">{{manual_formula}}</textarea>
	<p class="description"><?php echo __('Use %field_slug% as field value variables', 'qcformbuilder-forms'); ?></p>
</div>
<br><br><br>
{{#script}}
//<script>


function {{_id}}_build_formula(obj){
	build_calculations_formular('{{_id}}', obj);
	rebind_field_bindings();
};

jQuery('#{{_id}}_operator_groups').on('change', 'select', function(e){
	{{_id}}_build_formula();
});
jQuery('body').on('change', '#{{_id}}_fixed', function(e){

	var checked = jQuery(this);

	if(checked.prop('checked')){
		jQuery('#{{_id}}_thousand_separator').show();
	}else{
		jQuery('#{{_id}}_thousand_separator').hide();
	}	

});
jQuery('body').on('change', '#{{_id}}_manual', function(e){
	var checked = jQuery(this);

	if(checked.prop('checked')){
		jQuery('#{{_id}}_autobox').hide();
		jQuery('#{{_id}}_manualbox').show();
	}else{
		jQuery('#{{_id}}_autobox').show();
		jQuery('#{{_id}}_manualbox').hide();
	}
});

jQuery('#{{_id}}_manual,#{{_id}}_fixed').trigger('change');

{{/script}}







