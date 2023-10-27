<div class="qcformbuilder-config-group">
	<label><?php echo __('URL', 'qcformbuilder-forms'); ?> </label>
	<div class="qcformbuilder-config-field">
		<input type="text" class="block-input field-config magic-tag-enabled required" name="{{_name}}[url]" value="{{url}}">
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label><?php echo __('Redirect Message', 'qcformbuilder-forms'); ?> </label>
	<div class="qcformbuilder-config-field">
		<input type="text" class="block-input field-config magic-tag-enabled required" name="{{_name}}[message]" value="{{#if message}}{{message}}{{else}}<?php _e('Redirecting', 'qcformbuilder-forms'); ?>{{/if}}">
		<p class="description"><?php _e('Message text shown when redirecting in Ajax mode.', 'qcformbuilder-forms'); ?></p>
	</div>
</div>