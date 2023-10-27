<div class="qcwbmc_subscription_meta">
	<div class="qcwbes_left">
		<label for="qc_mailing_list_mailchimp_api_key"><?php esc_html_e('Mailchimp API Key :', 'qc-mailing-list-integration'); ?></label><br>
	</div>

	<div class="qcwbes_right">
		<input type="text" class="qcwbes_width_quarter_half" id="qc_mailing_list_mailchimp_api_key" name="qc_mailing_list_mailchimp_api_key" value="<?php echo esc_attr($mailchimp_api_key); ?>">
		<div class="qcwbes_button_groups qcwbes_pt_20">
			<a id="qcwbmc_subscription_mailchimp_authenticate" class="button button-primary" href='#'><?php esc_html_e('Authenticate', 'qc-mailing-list-integration'); ?></a>
			<a id="qcwbmc_subscription_mailchimp_unauthenticate" class="button button-secondary qcwbmc_ml_10" href='#'><?php esc_html_e('Change Account', 'qc-mailing-list-integration'); ?></a>
		</div>
	</div>
</div>

<div class="qcwbmc_subscription_meta qcwbmc_subscription_ajax_lists_result">
	<div class="qcwbes_left"><label><?php esc_html_e('Select a List :', 'qc-mailing-list-integration'); ?></label></div>
	<div class="qcwbes_right"><span class='qcwbmc_text_bold'><?php esc_html_e('No Lists to Show', 'qc-mailing-list-integration'); ?></label></div>
</div>