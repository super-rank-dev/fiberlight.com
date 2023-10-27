<?php
printf( '<div class="error"><p>%1s</p></div>',
	__( 'This file type is discontinued and no longer supported. Please switch to the new advanced file field.', 'qcformbuilder-forms' )
);
?>
<div class="qcformbuilder-config-group">
	<label role="presentation"></label>
	<div class="qcformbuilder-config-field">
		<label for="{{_id}}_attach"><input id="{{_id}}_attach" type="checkbox" class="field-config" name="{{_name}}[attach]" value="1" {{#if attach}}checked="checked"{{/if}}>
            <?php echo esc_html__('Attach to Mailer', 'qcformbuilder-forms'); ?>
        </label>
	</div>
</div>

<div class="qcformbuilder-config-group">
	<label role="presentation"></label>
	<div class="qcformbuilder-config-field">
		<label for="{{_id}}_allow_multiple"><input id="{{_id}}_allow_multiple" type="checkbox" class="field-config" name="{{_name}}[multi_upload]" value="1" {{#if multi_upload}}checked="checked"{{/if}}>
            <?php echo esc_html__('Allow Multiple', 'qcformbuilder-forms'); ?>
        </label>
	</div>
</div>

<div class="qcformbuilder-config-group">
	<label role="presentation"></label>
	<div class="qcformbuilder-config-field">
		<label for="{{_id}}_media_library"><input id="{{_id}}_media_library" type="checkbox" class="field-config" name="{{_name}}[media_lib]" value="1" {{#if media_lib}}checked="checked"{{/if}}>
            <?php echo esc_html__('Add to Media Library', 'qcformbuilder-forms'); ?>
        </label>
	</div>
</div>


<div class="qcformbuilder-config-group" id="{{_id}}_allow_multiple_text_wrap">
	<label for="{{_id}}_allow_multiple_text">
        <?php echo esc_html__('Button Text', 'qcformbuilder-forms'); ?>
    </label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_allow_multiple_text" type="text" class="field-config" name="{{_name}}[multi_upload_text]" value="{{#if multi_upload_text}}{{multi_upload_text}}{{/if}}">
	</div>
</div>

<div class="qcformbuilder-config-group">
	<label for="{{_id}}_allowed"><?php echo esc_html__('Allowed Types', 'qcformbuilder-forms'); ?></label>
	<div class="qcformbuilder-config-field">
		<input id="{{_id}}_allowed" type="text" class="field-config" name="{{_name}}[allowed]" value="{{allowed}}">
		<p class="description"><?php echo esc_html__('Comma separated eg. jpg,pdf,txt', 'qcformbuilder-forms'); ?></p>
	</div>
</div>


{{#script}}
	jQuery(function($){

		$('#{{_id}}_allow_multiple').change(function(){

			if( $(this).prop('checked') ){
				$('#{{_id}}_allow_multiple_text_wrap').show();
			}else{
				$('#{{_id}}_allow_multiple_text_wrap').hide();
			}
		});

		$('#{{_id}}_allow_multiple').trigger('change');
	});
{{/script}}
