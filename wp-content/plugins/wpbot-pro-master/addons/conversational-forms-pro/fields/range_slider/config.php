<?php
/*<div class="qcformbuilder-config-group">
	<label for="{{_id}}_pollyfill"><?php _e('Polyfill', 'qcformbuilder-forms'); ?></label>
	<div class="qcformbuilder-config-field">
		<label><input id="{{_id}}_pollyfill_check" type="checkbox" class="field-config" name="{{_name}}[pollyfill]" value="1" {{#if pollyfill}}checked="checked"{{/if}}><?php esc_html_e('Use only on old browsers.','qcformbuilder-forms'); ?></label>
	</div>
</div>*/
?>
<div class="qcformbuilder-config-group">
	<label for="{{_id}}_default">
       <?php esc_html_e('Default', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_default" type="text" class="block-input field-config" name="{{_name}}[default]" value="{{default}}" style="width:70px;">
	</div>
</div>
<div id="{{_id}}_style">
	<div class="qcformbuilder-config-group">
		<label for="{{_id}}_trackcolor">
           <?php esc_html_e('Track', 'qcformbuilder-forms'); ?>
        </label>
		<div class="qcformbuilder-config-field">
			<input id="{{_id}}_trackcolor" type="text" class="color-field field-config" name="{{_name}}[trackcolor]" value="{{trackcolor}}">
		</div>
	</div>
	<div class="qcformbuilder-config-group">
		<label for="{{_id}}_color">
           <?php esc_html_e('Highlight', 'qcformbuilder-forms'); ?>
        </label>
		<div class="qcformbuilder-config-field">
			<input id="{{_id}}_color" type="text" class="color-field field-config" name="{{_name}}[color]" value="{{color}}">
		</div>
	</div>
	<div class="qcformbuilder-config-group">
		<label for="{{_id}}_handle">
           <?php esc_html_e('Handle', 'qcformbuilder-forms'); ?>
        </label>
		<div class="qcformbuilder-config-field">
			<input id="{{_id}}_handle" type="text" class="color-field field-config" name="{{_name}}[handle]" value="{{handle}}">
		</div>
	</div>
	<div class="qcformbuilder-config-group">
		<label for="{{_id}}_handleborder">
           <?php esc_html_e('Border', 'qcformbuilder-forms'); ?>
        </label>
		<div class="qcformbuilder-config-field">
			<input id="{{_id}}_handleborder" type="text" class="color-field field-config" name="{{_name}}[handleborder]" value="{{handleborder}}">
		</div>
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="{{_id}}_step">
       <?php esc_html_e('Steps', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_step" type="number" class="block-input field-config" name="{{_name}}[step]" value="{{step}}" style="width:70px;">
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="{{_id}}_min">
       <?php esc_html_e('Minimum', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_min" type="number" class="block-input field-config" name="{{_name}}[min]" value="{{min}}" style="width:70px;">
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="{{_id}}_max">
       <?php esc_html_e('Maximum', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_max" type="number" class="block-input field-config" name="{{_name}}[max]" value="{{max}}" style="width:70px;">
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="{{_id}}_showval">
       <?php esc_html_e('Show Value', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_showval" type="checkbox" class="field-config" name="{{_name}}[showval]" value="1" {{#if showval}}checked="checked"{{/if}}>
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="{{_id}}_prefix">
       <?php esc_html_e('Prefix', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_prefix" type="text" class="block-input field-config" name="{{_name}}[prefix]" value="{{prefix}}" style="width:70px;">
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="{{_id}}_suffix">
       <?php esc_html_e('Suffix', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_suffix" type="text" class="block-input field-config" name="{{_name}}[suffix]" value="{{suffix}}" style="width:70px;">
	</div>
</div>
{{#script}}
jQuery(function($){
	//jQuery('#{{_id}}_trackcolor').miniColors();
	//jQuery('#{{_id}}_color').miniColors();
	//jQuery('#{{_id}}_handle').miniColors();
	//jQuery('#{{_id}}_handleborder').miniColors();

	/*jQuery('#{{_id}}_pollyfill_check').on('change', function(){

		var clicked = jQuery(this);
		if(clicked.prop('checked')){
			jQuery('#{{_id}}_style').hide();
		}else{
			jQuery('#{{_id}}_style').show();
		}
	});
	jQuery('#{{_id}}_pollyfill_check').trigger('change');*/
});
{{/script}}




