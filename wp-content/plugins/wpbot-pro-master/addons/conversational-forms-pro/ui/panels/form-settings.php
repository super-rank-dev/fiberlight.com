<?php
/**
 * Form Settings panel
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
?>
<div style="display: none;" class="qcformbuilder-editor-body qcformbuilder-config-editor-panel " id="settings-panel">
	<h3>
		<?php esc_html_e( 'Form Settings', 'qcformbuilder-forms' ); ?>
	</h3>

	<input type="hidden" name="config[wfb_version]" value="<?php echo esc_attr( WFBCORE_VER ); ?>">

	<div class="qcformbuilder-config-group">
		<label for="wfb-form-name">
			<?php esc_html_e( 'Form Name', 'qcformbuilder-forms' ); ?>
		</label>
		<div class="qcformbuilder-config-field">
			<input id="wfb-form-name"type="text" class="field-config required" name="config[name]" value="<?php echo $element[ 'name' ]; ?>" style="width:500px;" required="required">
		</div>
	</div>
	
	<div class="qcformbuilder-config-group">
		<label for="wfb-chatbot-command">
			<?php esc_html_e( 'ChatBot Command', 'qcformbuilder-forms' ); ?>
		</label>
		<div class="qcformbuilder-config-field">
			<input id="wfb-chatbot-command"type="text" class="field-config required" name="config[command]" value="<?php echo $element[ 'command' ]; ?>" style="width:500px;" ><i>You can add multiple comma seperated command keywork. Ex: test1,test2,test3 etc</i>
		</div>
	</div>


</div>
