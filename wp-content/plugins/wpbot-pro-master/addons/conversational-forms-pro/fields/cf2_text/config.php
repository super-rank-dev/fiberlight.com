<!--<div class="qcformbuilder-config-group">
	<label for="{{_id}}_placeholder">
		<?php esc_html_e('Placeholder', 'qcformbuilder-forms'); ?></label>
	<div class="qcformbuilder-config-field">
		<input type="text" id="{{_id}}_placeholder" class="block-input field-config" name="{{_name}}[placeholder]" value="{{placeholder}}">
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="{{_id}}_default">
		<?php esc_html_e('Default'); ?>
	</label>
	<div class="qcformbuilder-config-field">
		<input type="text" id="{{_id}}_default" class="block-input field-config magic-tag-enabled" name="{{_name}}[default]" value="{{default}}">
	</div>
</div>-->

<!--<div class="qcformbuilder-config-group">
	<label for="{{_id}}-type_override">
		<?php esc_html_e( 'HTML5 Type', 'qcformbuilder-forms'); ?>
	</label>
	<div class="qcformbuilder-config-field">
		<select class="field-config {{_id}}_type_override" name="{{_name}}[type_override]" id="{{_id}}-type_override" aria-describedby="{{_id}}-type_override-description">
			<option {{#is type_override value="text"}}selected="selected"{{/is}}value="text">text</option>
			<option {{#is type_override value="date"}}selected="selected"{{/is}}value="date">date</option>
			<option {{#is type_override value="month"}}selected="selected"{{/is}}value="month">month</option>
			<option {{#is type_override value="number"}}selected="selected"{{/is}}value="number">number</option>
			<option {{#is type_override value="search"}}selected="selected"{{/is}}value="search">search</option>
			<option {{#is type_override value="tel"}}selected="selected"{{/is}}value="tel">tel</option>
			<option {{#is type_override value="time"}}selected="selected"{{/is}}value="time">time</option>
			<option {{#is type_override value="url"}}selected="selected"{{/is}}value="url">url</option>
			<option {{#is type_override value="week"}}selected="selected"{{/is}}value="week">week</option>
		</select>
		<p class="description" id="{{_id}}-type_override-description">
			<?php esc_html_e('Change the field type.','qcformbuilder-forms');?>
		</p>
	</div>
</div>-->
<!--
<div class="qcformbuilder-config-group">
	<label><?php _e('Masked Input', 'qcformbuilder-forms'); ?></label>
	<div class="qcformbuilder-config-field">
		<label><input type="checkbox" class="field-config {{_id}}_masked" name="{{_name}}[masked]" value="1" {{#if masked}}checked="checked"{{/if}}> <?php _e('Enable input mask', 'qcformbuilder-forms'); ?></label>
	</div>
</div>
<div id="{{_id}}_maskwrap">
	<div class="qcformbuilder-config-group">
		<label><?php _e('Mask', 'qcformbuilder-forms'); ?></label>
		<div class="qcformbuilder-config-field">		
			<input type="text" id="{{_id}}_mask" class="block-input field-config" name="{{_name}}[mask]" value="{{mask}}">
		</div>
	</div>
	<div class="qcformbuilder-config-group">
		<p class="description">e.g (aaa-99-999-a9-9*)</p>
		<ul>
			<li>9 : <?php _e('numeric', 'qcformbuilder-forms'); ?></li>
			<li>a : <?php _e('alphabetical', 'qcformbuilder-forms'); ?></li>
			<li>* : <?php _e('alphanumeric', 'qcformbuilder-forms'); ?></li>
			<li>[9 | a | *] : <?php _e('optional', 'qcformbuilder-forms'); ?></li>
			<li>{int | * | +} : <?php _e('length', 'qcformbuilder-forms'); ?></li>
		</ul>
		<p class="description"><?php _e('Any length character only', 'qcformbuilder-forms'); ?>: [a{*}]</p>
		<p class="description"><?php _e('Any length number only', 'qcformbuilder-forms'); ?>: [9{*}]</p>
		<p class="description"><?php _e('email', 'qcformbuilder-forms'); ?>: *{+}@*{2,}.*{2,}[.[a{2,}][.[a{2,}]]]</p>

	</div>
</div>
-->
<?php
