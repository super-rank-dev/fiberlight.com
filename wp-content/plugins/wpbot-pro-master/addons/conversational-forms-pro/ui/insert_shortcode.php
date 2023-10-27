<div class="qcformbuilder-backdrop qcformbuilder-forms-insert-modal" style="display: none;"></div>
<form id="qcformbuilderf_forms_shortcode_modal" class="qcformbuilder-modal-wrap qcformbuilder-forms-insert-modal" style="display: none; width: 700px; max-height: 500px; margin-left: -350px;">
	<div class="qcformbuilder-modal-title" id="qcformbuilderf_forms_shortcode_modalTitle" style="display: block;">
		<a href="#close" class="qcformbuilder-modal-closer" data-dismiss="modal" aria-hidden="true" id="qcformbuilderf_forms_shortcode_modalCloser">×</a>
		<h3 class="modal-label" id="qcformbuilderf_forms_shortcode_modalLable"><?php echo __('Insert Qcformbuilder Form', 'qcformbuilder-forms'); ?></h3>
	</div>
	<div class="qcformbuilder-modal-body none" id="qcformbuilderf_forms_shortcode_modalBody" style="width: 70%;">
		<div class="modal-body modal-forms-list">
		<?php

			$forms = Qcformbuilder_Forms_Forms::get_forms( true );
			if(!empty($forms)){
				foreach($forms as $form_id=>$form){

					echo '<div class="modal-list-item"><label><input name="insert_form_id" autocomplete="off" class="selected-form-shortcode" value="' . $form_id . '" type="radio">' . $form['name'];
					if(!empty($form['description'])){
						echo '<p style="margin-left: 20px;" class="description"> '.$form['description'] .' </p>';
					}
					echo ' </label></div>';

				}
			}else{
				echo '<p>' . __('You don\'t have any forms to insert.', 'qcformbuilder-forms') .'</p>';
			}

		?>
		</div>
	</div>
	<div class="qcformbuilder-modal-body none" id="qcformbuilderf_forms_shortcode_modalBody_options" style="left: 70%;">
		<div class="modal-body modal-shortcode-options">
			<h4><?php esc_html_e('Options', 'qcformbuilder-forms'); ?></h4>
			<label><input type="checkbox" value="1" class="set_wfb_option set_wfb_modal"> <?php esc_html_e('Set as Modal', 'qcformbuilder-forms'); ?></label>
			<div class="modal-forms-setup" style="display:none;">
				<label><?php esc_html_e('Open Modal Trigger Type', 'qcformbuilder-forms'); ?></label>
				<select name="modal_button_type" class="modal_trigger_type" style="width: 100%;">
					<option value="link"><?php esc_html_e('Link', 'qcformbuilder-forms'); ?></option>
					<option value="button"><?php esc_html_e('Button', 'qcformbuilder-forms'); ?></option>					
				</select>
				<label><?php esc_html_e('Open Modal Text', 'qcformbuilder-forms'); ?></label>
				<input type="text" name="modal_button_text" class="modal_trigger" style="width: 100%;">
				<label><?php esc_html_e('Modal Width', 'qcformbuilder-forms'); ?></label>
				<input type="number" name="modal_width" class="modal_width" style="width: 60px;">px

			</div>

		</div>

	</div>
	<div class="qcformbuilder-modal-footer" id="qcformbuilderf_forms_shortcode_modalFooter" style="display: block;">
	<?php if(!empty($forms)){ ?>		
		<button class="button qcformbuilder-form-shortcode-insert" style="float:right;"><?php esc_html_e('Insert Form', 'qcformbuilder-forms'); ?></button>
	<?php }else{ ?>
		<button class="button qcformbuilder-modal-closer"><?php echo __('Close', 'qcformbuilder-forms'); ?></button>
	<?php } ?>
	</div>
</form>
