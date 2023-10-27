&nbsp;

<div id="newfield-tool" class="button button-primary button-small layout-new-form-field" title="<?php esc_attr_e( 'Drag this box onto the layout grid where you want the field to appear', 'qcformbuilder-forms'); ?>">
	<i class="icon-edit" style="display:none;"></i>
	<i class="dashicons dashicons-admin-page" style="display:none;"></i>
	<i class="dashicons dashicons-menu" style="display:none;"></i>
	<span id="new-form-element" class="layout_field_name"><span class="dashicons dashicons-move" style="margin: 1px 0px 0px -5px;"></span>
		<?php esc_html_e( 'Add Field', 'qcformbuilder-forms' ); ?>
	</span>
	<div class="drag-handle">
		<div class="field_preview"></div>
	</div><input value="" type="hidden" class="field-location">	
</div>

<?php
/*
<button class="button button-small compact-mode" style="margin-top:-3px; margin-left:10px;" type="button"><?php _e('Compact', 'qcformbuilder-forms'); ?></button>
*/
?>
<span id="dismiss-add-element" class="ajax-trigger" data-action="wfb_dismiss_pointer" data-pointer="add_element" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wfb_dismiss_pointer' ) ); ?>"></span>
<?php
$haspointer = get_user_meta( get_current_user_id() , 'wfb_pointer_add_element' );
if(empty($haspointer)){ ?>
<script>
	

</script>
<?php } ?>
<script>
	jQuery(document).on('click','.compact-mode', function(){

		var form = jQuery('.qcformbuilder-forms-options-form'),
			clicked = jQuery(this);

		if(form.hasClass('mini-mode')){
			form.removeClass('mini-mode');
			clicked.removeClass('button-primary');
		}else{
			form.addClass('mini-mode');
			clicked.addClass('button-primary');
		}

	});
</script>