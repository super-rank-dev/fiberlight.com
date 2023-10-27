<div class="qcformbuilder-config-group">
	<label for="wfb-autoresponder-send-name-{{_id}}">
		<?php esc_html_e('From Name', 'qcformbuilder-forms'); ?>
	</label>
	<div class="qcformbuilder-config-field">
		<input
            id="wfb-autoresponder-send-name-{{_id}}"
            type="text" class="block-input field-config magic-tag-enabled required" name="{{_name}}[sender_name]" value="{{sender_name}}"
        />
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="wfb-autoresponder-from-email-{{_id}}">
        <?php esc_html_e('From Email', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input
            id="wfb-autoresponder-from-email-{{_id}}"
            type="text" class="block-input field-config magic-tag-enabled qcformbuilder-field-bind required" name="{{_name}}[sender_email]" value="{{sender_email}}"
        />
	</div>
</div>






<div class="qcformbuilder-config-group">
	<label for="wfb-autoresponder-subject-{{_id}}">
		<?php esc_html_e('Email Subject', 'qcformbuilder-forms'); ?>
	</label>
	<div class="qcformbuilder-config-field">
		<input
            id="wfb-autoresponder-subject-{{_id}}"
            type="text" class="block-input field-config magic-tag-enabled qcformbuilder-field-bind required" name="{{_name}}[subject]" value="{{subject}}"
        />
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="wfb-autoresponder-to-name-{{_id}}">
		<?php esc_html_e('Recipient Name', 'qcformbuilder-forms'); ?>
	</label>
	<div class="qcformbuilder-config-field">
		<input
            id="wfb-autoresponder-to-name-{{_id}}"
            type="text" class="block-input field-config magic-tag-enabled qcformbuilder-field-bind required" name="{{_name}}[recipient_name]" value="{{recipient_name}}"
        />
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="wfb-autoresponder-to-email-{{_id}}">
		<?php esc_html_e('Recipient Email', 'qcformbuilder-forms'); ?>
	</label>
	<div class="qcformbuilder-config-field">
		<input
            id="wfb-autoresponder-to-email-{{_id}}"
            type="text" class="block-input field-config magic-tag-enabled qcformbuilder-field-bind required" name="{{_name}}[recipient_email]" value="{{recipient_email}}"
        />
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="wfb-autoresponder-message-{{_id}}">
		<?php esc_html_e('Message', 'qcformbuilder-forms'); ?>
	</label>
	<div class="qcformbuilder-config-field">
		<textarea
            id="wfb-autoresponder-message-{{_id}}"
            rows="6" class="block-input field-config required magic-tag-enabled" name="{{_name}}[message]">{{#if message}}{{message}}{{else}}Hi %recipient_name%.
Thanks for your email.
We'll get back to you as soon as possible!
{{/if}}</textarea>
	</div>
</div>
<div class="qcformbuilder-config-group">
	<label for="wfb-autoresponder-message-{{_id}}">
		<?php esc_html_e('Enable Condition', 'qcformbuilder-forms'); ?>
	</label>
	<div class="qcformbuilder-config-field">
		<input type="checkbox" name="{{_name}}[enable_condition]" {{#if enable_condition}}checked="checked"{{/if}} value="1" />
	</div>
</div>

<div class="qcformbuilder-config-group qc_preprocessor_condition">
	If <input class="magic-tag-enabled" type="text" value="{{condition_field}}" name="{{_name}}[condition_field]"/> <select name="{{_name}}[condition]">
		<option value="is" {{#is condition value="is"}}selected="selected"{{/is}} >is</option>
		<option value="contain" {{#is condition value="contain"}}selected="selected"{{/is}}>Contain</option>
	</select>
	<input type="text" value="{{condition_value}}" name="{{_name}}[condition_value]" size="5" />
</div>



