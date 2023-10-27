<?php
/**
 * Settings for Chatbot Form Builder emails
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
?>
<div id="wfb-email-settings-ui" aria-hidden="true" style="visibility: hidden;">
	<div style="margin:20px;">
		<div class="qcformbuilder-forms-clippy-zone-inner-wrap" style="background: white">
			<div class="qcformbuilder-forms-clippy"
			     style="background-color:white;border-left: 4px solid #dc3232;">
				<h2 style="margin-left: 12px">
					<?php esc_html_e( 'Deprecated Functionality', 'qcformbuilder-forms' ); ?>
				</h2>
				<p style="margin-left: 12px">
					<?php esc_html_e( 'SendGrid integration was our first attempt to improve email in Chatbot Form Builder. But we decided to create something easier and provides more value to you -- our users. We call it Chatbot Form Builder Pro.', 'qcformbuilder-forms' ); ?>
				</p>
				<a href="https://quantumcloud.com/pro?utm-source=wp-admin&utm_campaign=email-settings&utm_term=email-setting"
				   target="_blank" class="bt-btn btn btn-green" style="width: 80%;margin-left:5%;">
					<?php esc_html_e( 'Learn More', 'qcformbuilder-forms' ); ?>
				</a>
			</div>
		</div>
	</div>
	<div class="wfb-emails-field-group qcformbuilder-config-group" id="wfb-emails-api-wrap">
		<label for="wfb-emails-api" id="wfb-emails-api-label">
			<?php esc_html_e( 'Email System', 'qcformbuilder-forms' ); ?>
		</label>
		<div class="wfb-emails-field">
			<select class="wfb-email-settings" id="wfb-emails-api" aria-labelledby="wfb-emails-api-label" aria-describedby="wfb-emails-api-desc">
				<option value="wp" <?php if ( 'wp'  == Qcformbuilder_Forms_Email_Settings::get_method() ) : echo 'selected'; endif; ?> >
					<?php esc_html_e( 'WordPress', 'qcformbuilder-forms' ); ?>
				</option>
				<option value="sendgrid" <?php if ( 'sendgrid'  == Qcformbuilder_Forms_Email_Settings::get_method() ) : echo 'selected'; endif; ?> >
					<?php esc_html_e( 'SendGrid', 'qcformbuilder-forms' ); ?>
				</option>
				<option value="qcformbuilder" <?php if ( 'qcformbuilder'  == Qcformbuilder_Forms_Email_Settings::get_method() ) : echo 'selected'; endif; ?> disabled >
					<?php esc_html_e( 'Qcformbuilder (coming soon)', 'qcformbuilder-forms' ); ?>
				</option>
			</select>
		</div>
		<p class="description" id="wfb-emails-api-desc" style="max-width: 440px; margin-bottom: 12px;">
			<?php esc_html_e( 'By default Chatbot Form Builder uses WordPress to send emails. You can choose to use another method to increase reliability of emails and reduce server load.', 'qcformbuilder-forms' ); ?>
		</p>
	</div>
	<div class="wfb-emails-field-group qcformbuilder-config-group" id="wfb-emails-sendgrid-key-wrap">
		<label for="wfb-emails-sendgrid-key" id="wfb-emails-sendgrid-key-label">
			<?php esc_html_e( 'SendGrid API Key', 'qcformbuilder-forms' ); ?>
		</label>
		<div class="wfb-emails-field-group">
			<input type="text" class="wfb-email-settings" id="wfb-emails-sendgrid-key" name="wfb-emails-sendgrid-key" value="<?php echo esc_attr( Qcformbuilder_Forms_Email_Settings::get_key( 'sendgrid' ) ); ?>">
		</div>
		<p class="description" id="wfb-emails-sendgrid-key-desc" style="max-width: 440px; margin-bottom: 12px;">
		<?php printf( '<span>%s</span> <span><a href="%s" target="_blank" rel="nofollow" title="%s">%s</a></span>',
					esc_html__( 'SendGrid API Key', 'qcformbuilder-forms' ),
					'https://QcformbuilderWP.com/docs/configure-sendgrid',
					esc_attr__( 'Documentation for configuring SendGrid API', 'qcformbuilder-forms' ),
					esc_html__( 'Learn More', 'qcformbuilder-forms' )
				);
		?></p>

	</div>
	<?php echo Qcformbuilder_Forms_Email_Settings::nonce_field(); ?>
	<br><br>
	<div class="field-group">
		<button type="button" id="wfb-email-settings-save" class="button button-primary">
			<?php esc_html_e( 'Save Email Settings', 'qcformbuilder-forms' ); ?>
		</button>
		<span class="spinner" style="float:none;" id="wfb-email-spinner" aria-hidden="true"></span>
	</div>
</div>
