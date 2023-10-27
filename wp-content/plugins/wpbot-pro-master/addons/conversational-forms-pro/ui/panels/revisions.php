<?php
if( Qcformbuilder_Forms_Admin::is_revision_edit() ){
	printf( '<div class="notice"><p>%s</p></div>', esc_html__( 'Currently Viewing A Revision', 'qcformbuilder-forms' ) );
}

?>
<div id="qcformbuilder-forms-revisions"></div>
<span id="qcformbuilder-forms-revisions-spinner" class="spinner"></span>
<script type="text/html" id="tmpl--revisions">
	<div id="qcformbuilder-forms-revisions-list">
		{{#if revisions}}
		<fieldset>
			<legend>
				<?php esc_html_e( 'Choose Revision To Edit', 'qcformbuilder-forms' ); ?>
			</legend>

		{{#each revisions}}

				<div class="qcformbuilder-config-group">
					<label for="restore-{{id}}">
						<?php esc_html_e( 'Edit Revision:', 'qcformbuilder-forms' ); ?> {{id}}
					</label>
					<input type="radio" name="qcformbuilder-forms-revision" value="{{id}}" id="restore-{{id}}" data-edit="{{edit}}" />
				</div>

		{{/each}}
		</fieldset>

		<a href="#" id="qcformbuilder-forms-revision-go" class="button" class="notice notice-error" style="display: none;" aria-hidden="true" role="button">
			<?php esc_html_e( 'View Selected Revision', 'qcformbuilder-forms' ); ?>
		</a>
		{{else}}
		<?php esc_html_e( 'No Saved Revisions', 'qcformbuilder-forms' ); ?>
		{{/if}}
	</div>

</script>








