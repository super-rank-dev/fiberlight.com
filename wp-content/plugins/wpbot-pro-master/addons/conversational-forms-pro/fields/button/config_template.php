<div class="qcformbuilder-config-group">
	<label for="buttontype_{{_id}}">
        <?php esc_html_e('Type', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<select id="buttontype_{{_id}}" class="block-input field-config field-button-type" name="{{_name}}[type]">
            <option value="submit" {{#is type value="submit"}}selected="selected"{{/is}}>
                <?php esc_html_e('Submit', 'qcformbuilder-forms'); ?>
            </option>
            <option value="button" {{#is type value="button"}}selected="selected"{{/is}}>
                <?php esc_html_e('Button', 'qcformbuilder-forms'); ?>
            </option>
            <option value="next" {{#is type value="next"}}selected="selected"{{/is}}>
                <?php esc_html_e('Next Page', 'qcformbuilder-forms'); ?>
            </option>
            <option value="prev" {{#is type value="prev"}}selected="selected"{{/is}}>
                <?php esc_html_e('Previous Page', 'qcformbuilder-forms'); ?>
            </option>
            <option value="reset" {{#is type value="reset"}}selected="selected"{{/is}}>
                <?php esc_html_e('Reset', 'qcformbuilder-forms'); ?>
            </option>
		</select>
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="{{_id}}_label">
        <?php esc_html_e('Class', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_label" type="text" class="block-input field-config" name="{{_name}}[class]" value="{{class}}" />
	</div>
</div>
<div class="qcformbuilder-config-group">
	<div class="qcformbuilder-config-field">
		<label for="{{_id}}_label">
            <input id="{{_id}}_label" type="checkbox" class="field-config" name="{{_name}}[label_space]" value="1" {{#if label_space}}checked="checked"{{/if}} />
            <?php esc_html_e('Add Label Space', 'qcformbuilder-forms'); ?>
        </label>
	</div>
</div>
<div id="event{{_id}}" style="display:{{#is type value="button"}}block{{else}}none{{/is}};">
	
	<div class="qcformbuilder-config-group">
		<label for="{{_id}}_target">
            <?php esc_html_e('Click Target', 'qcformbuilder-forms'); ?>
        </label>
		<div class="qcformbuilder-config-field">
			<input id="{{_id}}_target" type="text" class="block-input field-config" name="{{_name}}[target]" value="{{target}}" />
			<p class="description"><?php _e('Selector or callback function to push form values on click.', 'qcformbuilder-forms'); ?></p>
		</div>
	</div>


</div>
{{#script}}
jQuery(function($){
	
	$('#buttontype_{{_id}}').on('change', function(){

		if( this.value === 'button' ){
			$('#event{{_id}}').show();
		}else{
			$('#event{{_id}}').hide();
		}

	});

});
{{/script}}