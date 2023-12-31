<div class="qcformbuilder-config-group">
	<label for="{{_id}}_orientation">
        <?php esc_html_e('Orientation', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<select id="{{_id}}_orientation" name="{{_name}}[orientation]" class="block-input field-config">
		<option value="horizontal" {{#is orientation value="horizontal"}}selected="selected"{{/is}}><?php esc_html_e('Horizontal', 'qcformbuilder-forms'); ?></option>
		<option value="justified" {{#is orientation value="justified"}}selected="selected"{{/is}}><?php esc_html_e('Justified', 'qcformbuilder-forms'); ?></option>
		<option value="vertical" {{#is orientation value="vertical"}}selected="selected"{{/is}}><?php esc_html_e('Vertical', 'qcformbuilder-forms'); ?></option>
		</select>
	</div>
</div>

<div class="qcformbuilder-config-group">
	<label for="{{_id}}_activeclass">
        <?php esc_html_e('Active Class', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_activeclass"type="text" value="{{#if selected_class}}{{selected_class}}{{else}}btn-success{{/if}}" name="{{_name}}[selected_class]" class="block-input field-config">
	</div>
</div>

<div class="qcformbuilder-config-group">
	<label for="{{_id}}_inactiveclass">
        <?php esc_html_e('Inactive Class', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_inactiveclass"type="text" value="{{#if default_class}}{{default_class}}{{else}}btn-default{{/if}}" name="{{_name}}[default_class]" class="block-input field-config">
	</div>
</div>

<div class="qcformbuilder-config-group">
	<label for="{{_id}}_default_option">
		<?php esc_html_e( 'Default Option', 'qcformbuilder-forms' ); ?>
	</label>
	<div class="qcformbuilder-config-field">
		<input type="text" id="{{_id}}_default_option" class="block-input field-config magic-tag-enabled" name="{{_name}}[default_option]" value="{{default_option}}" aria-describedby="{{_id}}_default_option-description"  />
		<p class="description" id="{{_id}}_default_option-description">
			<?php esc_html_e( 'Overwrite default option - useful for setting default with magic tags.', 'qcformbuilder-forms' ); ?>
		</p>
	</div>
</div>