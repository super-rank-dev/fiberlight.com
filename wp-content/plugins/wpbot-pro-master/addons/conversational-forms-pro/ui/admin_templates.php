<script type="text/html" id="bulk-actions-active-tmpl">
	<option selected="selected" value="">
		<?php esc_html_e( 'Bulk Actions', 'qcformbuilder-forms' ); ?>
	</option>
	<option value="export">
		<?php esc_html_e( 'Export Selected', 'qcformbuilder-forms' ); ?>
	</option>
	<?php if( current_user_can( Qcformbuilder_Forms::get_manage_cap( 'manage' ) ) ){ ?>
		<option value="trash"><?php esc_html_e( 'Move to Trash', 'qcformbuilder-forms' ); ?></option><?php } ?>
</script>

<script type="text/html" id="wfb-export-template">
		<input type="hidden" name="export-form" value="{{formid}}">
		<input type="hidden" name="cal_del" value="{{nonce}}">

		<div class="qcformbuilder-config-group">
			<label for="wfb-export-format">
				<?php echo esc_html__( 'Export Type', 'qcformbuilder-forms' ); ?>
			</label>
			<div class="qcformbuilder-config-field">
				<select class="form-export-type" name="format" id="wfb-export-format" style="width: 230px;">
					<option value="json"><?php esc_html_e('Backup / Importable (json)' , 'qcformbuilder-forms' ); ?></option>
				</select>
			</div>
		</div>

		<p class="description" id="json_export_option">
			<?php esc_html_e( 'This gives you a .json file that can be imported into Chatbot Form Builder.', 'qcformbuilder-forms' ); ?>
		</p>
		<div style="display:none;" id="php_export_options">
			<div class="qcformbuilder-config-group">
				<label for="wfb-export-form-id">
					<?php echo esc_html__( 'Form ID', 'qcformbuilder-forms' ); ?>
				</label>
				<div class="qcformbuilder-config-field">
					<input type="text" id="wfb-export-form-id" class="block-input field-config" data-format="slug" name="form_id" value="{{formslug}}" required="required">
				</div>
			</div>

			<div class="qcformbuilder-config-group">
				<label for="wfb-export-pin-menu">
					<?php echo esc_html__( 'Create sub-menu entry viewer', 'qcformbuilder-forms' ); ?>
				</label>
				<div class="qcformbuilder-config-field">
					<label><input type="checkbox" name="pin_menu" id="wfb-export-pin-menu" value="1">
						<?php esc_html_e( 'Creates a sub-menu item of the Chatbot Form Builder menu and a page to show entries for this form.', 'qcformbuilder-forms' ); ?>
					</label>
				</div>
			</div>

			<div class="qcformbuilder-config-group">
				<label for="wfb-export-convert-ids">
					<?php echo esc_html__( 'Field Slugs', 'qcformbuilder-forms' ); ?>
				</label>
				<div class="qcformbuilder-config-field">
					<label>
						<input type="checkbox" name="convert_slugs" value="1" id="wfb-export-convert-ids">
						<?php esc_html_e( "Convert Field ID's to use field slugs", 'qcformbuilder-forms' ); ?>
					</label>
				</div>
			</div>

			<hr>
			<p class="description">
				<?php esc_html_e('This gives you a hardcoded .php file that can be included in projects. It includes the correct filter for the ID specific form allowing you to easily use the form by simply including the file.', 'qcformbuilder-forms'); ?>
			</p>
			<p class="description">
				<?php esc_html_e('This is not a backup and cannot be imported.', 'qcformbuilder-forms'); ?>
			</p>

		</div>

		{{#script}}
		jQuery( function( $ ){
			$(document).on('change', '.form-export-type', function(){
				if( this.value === 'php' ){
					$('#json_export_option').slideUp(100);
					$('#php_export_options').slideDown(100);
				}else{
					$('#php_export_options').slideUp(100);
					$('#json_export_option').slideDown(100);
				}
			})
		});

		{{/script}}
</div>

</script>
<script type="text/html" id="bulk-actions-trash-tmpl">
	<option selected="selected" value="">
		<?php esc_html_e( 'Bulk Actions', 'qcformbuilder-forms' ); ?>
	</option>
	<option value="export">
		<?php esc_html_e( 'Export Selected', 'qcformbuilder-forms' ); ?>
	</option>
	<?php if( current_user_can( 'delete_others_posts' ) ){ ?>
		<option value="active">
			<?php esc_html_e( 'Restore', 'qcformbuilder-forms' ); ?>
		</option>
	<option value="delete"><?php esc_html_e( 'Delete Permanently', 'qcformbuilder-forms' ); ?></option><?php } ?>
</script>
<script type="text/html" id="import-form-tmpl">
	<form class="new-form-form" action="admin.php?page=qcformbuilder-forms&import=true" enctype="multipart/form-data" method="POST">
		<?php
		wp_nonce_field( 'wfb-import', 'cfimporter' );
		do_action('qcformbuilder_forms_import_form_template_start');
		?>
		<div class="qcformbuilder-config-group">
			<label for="wfb-new-form-name">
				<?php esc_html_e( 'Form Name', 'qcformbuilder-forms' ); ?>
			</label>
			<div class="qcformbuilder-config-field">
				<input
                    id="wfb-new-form-name"
                    type="text"
                    class="new-form-name block-input field-config"
                    autocomplete="off"
                    name="name"
                    value=""
                    required="required"
                />
			</div>
		</div>
		<div class="qcformbuilder-config-group">
			<label for="wfb-wfb-new-form-file">
				<?php esc_html_e( 'Form File', 'qcformbuilder-forms' ); ?>
			</label>
			<div class="qcformbuilder-config-field">
				<input
                    type="file"
                    id="wfb-new-form-file"
                    class="new-form-name"
                    name="import_file"
                    required="required"
                    style="width: 230px;"
                />
			</div>
		</div>

        <div class="qcformbuilder-config-group">
            <label for="wfb-new-form-trusted">
                <?php esc_html_e( 'Trusted Source', 'qcformbuilder-forms' ); ?>
            </label>
            <div class="qcformbuilder-config-field">
                <input
                    type="checkbox"
                    id="wfb-new-form-trusted"
                    name="import_trusted"
                    aria-describedby="wfb-new-form-trusted-desc"
                />
                <p 
                    id="wfb-new-form-trusted-desc"
                    class="description"
                >
                    <?php esc_html_e( 'Is this file from a trusted source?','qcformbuilder-forms' ); ?>

                </p>
            </div>
        </div>
		
		<div class="baldrick-modal-footer" style="display: block; clear: both; position: relative; height: 24px; width: 100%; margin: 0px -12px;">

			<button type="submit" class="button" style="float:right;">
                <?php esc_html_e( 'Import Form', 'qcformbuilder-forms' ); ?>
            </button>

		</div>

		
		<?php
			/**
			 * Runs at bottom of new form template
			 *
			 * @since unknown
			 */
			do_action('qcformbuilder_forms_import_form_template_end');
		?>
	</form>
</script>
<script type="text/html" id="front-settings-tmpl">
	<?php

	$style_includes = Qcformbuilder_Forms_Render_Assets::get_style_includes();
	if(empty($style_includes)){
		$style_includes = array(
			'alert'	=>	true,
			'form'	=>	true,
			'grid'	=>	true,
		);
		update_option( '_qcformbuilder_forms_styleincludes', $style_includes);
	}


	?>
	<div class="qcformbuilder-settings-group">
		<div class="qcformbuilder-settings">
			<a href="https://quantumcloud.com/doc/global-email-general-settings/?utm_source=wp-admin&utm_medium=general-settings&utm_content=alert" target="_blank" class="dashicons dashicons-editor-help" style="float:right;" data-toggle="tooltip" data-placement="bottom"  title="<?php esc_attr_e( 'Learn more about General and Email Settings.', 'qcformbuilder-forms'  ); ?>"></a>
			<strong>
				<?php esc_html_e( 'Alert Styles' , 'qcformbuilder-forms' ); ?>
			</strong>
			<p class="description">
				<?php esc_html_e( 'Includes Bootstrap 3 styles on the frontend for form alert notices', 'qcformbuilder-forms' ); ?>
			</p>
			<div class="clear"></div>
		</div>
		<div class="qcformbuilder-setting">
			<div class="switch setting_toggle_alert <?php if(!empty($style_includes['alert'])){ ?>active<?php } ?>">
				<div data-action="save_wfb_setting" data-load-element="_parent" data-load-class="load" data-set="alert" data-callback="update_setting_toggle" class="ajax-trigger box-wrapper"></div>
				<div class="box"><span class="spinner"></span></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>	

	<div class="qcformbuilder-settings-group">
		<div class="qcformbuilder-settings">
			<a href="https://quantumcloud.com/doc/global-email-general-settings/?utm_source=wp-admin&utm_medium=general-settings&utm_content=form" target="_blank" class="dashicons dashicons-editor-help" style="float:right;" data-toggle="tooltip" data-placement="bottom"  title="<?php esc_attr_e( 'Learn more about General and Email Settings.', 'qcformbuilder-forms'  ); ?>"></a>
			<strong>
				<?php esc_html_e( 'Form Styles' , 'qcformbuilder-forms' ); ?>
			</strong>
			<p class="description">
				<?php esc_html_e( 'Includes Bootstrap 3 styles on the frontend for form fields and buttons', 'qcformbuilder-forms' ); ?>
			</p>
			<div class="clear"></div>
		</div>
		<div class="qcformbuilder-setting">
			<div class="switch setting_toggle_form <?php if(!empty($style_includes['form'])){ ?>active<?php } ?>">
				<div data-action="save_wfb_setting" data-load-element="_parent" data-load-class="load" data-set="form" data-callback="update_setting_toggle" class="ajax-trigger box-wrapper"></div>
				<div class="box"><span class="spinner"></span></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>	

	<div class="qcformbuilder-settings-group">
		<div class="qcformbuilder-settings">
			<a href="https://quantumcloud.com/doc/global-email-general-settings/?utm_source=wp-admin&utm_medium=general-settings&utm_content=grid" target="_blank" class="dashicons dashicons-editor-help" style="float:right;" data-toggle="tooltip" data-placement="bottom"  title="<?php esc_attr_e( 'Learn more about General and Email Settings.', 'qcformbuilder-forms'  ); ?>"></a>
			<strong>
				<?php esc_html_e( 'Grid Structures' , 'qcformbuilder-forms' ); ?>
			</strong>
			<p class="description">
				<?php esc_html_e( 'Includes Bootstrap 3 styles on the frontend for form grid layouts', 'qcformbuilder-forms' ); ?>
			</p>
			<div class="clear"></div>
		</div>
		<div class="qcformbuilder-setting">
			<div class="switch setting_toggle_grid <?php if(!empty($style_includes['grid'])){ ?>active<?php } ?>">
				<div data-action="save_wfb_setting" data-load-element="_parent" data-load-class="load" data-set="grid" data-callback="update_setting_toggle" class="ajax-trigger box-wrapper"></div>
				<div class="box"><span class="spinner"></span></div>
			</div>

		</div>
		<div class="clear"></div>
	</div>

	<div class="qcformbuilder-settings-group">
		<div class="qcformbuilder-settings">
			<a href="https://quantumcloud.com/doc/improving-qcformbuilder-performance-free-cdn?utm_source=wp-admin&utm_medium=general-settings&utm_content=cdn_enable" target="_blank" class="dashicons dashicons-editor-help" style="float:right;" data-toggle="tooltip" data-placement="bottom"  title="<?php esc_attr_e( 'Learn more about the free CDN and usage sharing.', 'qcformbuilder-forms'  ); ?>"></a>
			<strong>
				<?php esc_html_e( 'Enable Free CDN' , 'qcformbuilder-forms' ); ?>
			</strong>
			<p class="description">
				<?php esc_html_e( 'Some usage data will be shared with CDN providers.', 'qcformbuilder-forms' ); ?>

			</p>

			<div class="clear"></div>
		</div>
		<div class="qcformbuilder-setting">
			<div class="switch setting_toggle_cdn_enable <?php if( Qcformbuilder_Forms::settings()->get_cdn()->enabled() ){ ?>active<?php } ?>">
				<div data-action="save_wfb_setting" data-load-element="_parent" data-load-class="load" data-set="cdn_enable" data-callback="update_setting_toggle" class="ajax-trigger box-wrapper"></div>
				<div class="box"><span class="spinner"></span></div>
			</div>

		</div>
		<div class="clear"></div>
	</div>


</script>
<script type="text/html" id="new-form-tmpl">
		{{#if clone}}
		<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'wfb_create_form' ) ); ?>">
		<?php
		do_action('qcformbuilder_forms_clone_form_template_start');
		?>
		{{else}}
		<?php
		do_action('qcformbuilder_forms_new_form_template_start');
		?>
		{{/if}}
		{{#if clone}}
		<div class="qcformbuilder-config-group">
			<label for="wfb-clone-form-name">
				<?php esc_html_e( 'Form Name', 'qcformbuilder-forms' ); ?>
			</label>
			<div class="qcformbuilder-config-field">
				<input type="text" id="wfb-clone-form-name" class="new-form-name block-input field-config" name="name" value="" required="required">
			</div>
		</div>
		<input type="hidden" name="clone" value="{{clone}}">
		<?php
		do_action('qcformbuilder_forms_clone_form_template_end');
		?>
		{{else}}
		<?php
		do_action('qcformbuilder_forms_new_form_template_end');
		?>
		{{/if}}
		{{#script}}
		jQuery('.new-form-name').focus();
		{{/script}}
</script>

<?php 
$forms = Qcformbuilder_Forms_Forms::get_forms( true );
foreach ( $forms as $form_id => $form_conf ) { ?>

<script type="text/html" id="cfajax_<?php echo esc_attr( $form_id ); ?>-tmpl">
	{{#script}}
		var view = jQuery('.current-view'),
			toggles = jQuery('.status_toggles.button-primary');

		
		if( view.length ){
			view.trigger('click');
			setTimeout( function(){
				toggles.trigger('click');
			}, 500 );
		}else{
			jQuery('#view_entry_baldrickModalCloser,#edit_entry_baldrickModalCloser').trigger('click');	
			toggles.trigger('click');			
		}
	{{/script}}
</script>

<?php } ?>








