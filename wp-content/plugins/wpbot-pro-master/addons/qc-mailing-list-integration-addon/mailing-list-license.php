<?php
// Exit if accessed directly
if (!defined('ABSPATH')){
	exit; 
}

/**
 * Help & License Submenu
 */
if( !class_exists('QC_mailing_list_Help_License_Sub_Menu') ){

	class QC_mailing_list_Help_License_Sub_Menu
	{
		
		function __construct()
		{
			add_action('admin_menu', array($this, 'help_license_submenu') );
		}

		function help_license_submenu(){
			add_submenu_page( 
		        'qc-mailing-list-integration',
		        esc_html__('Help', 'qc-mailing-list-integration'),
		        esc_html__('Help', 'qc-mailing-list-integration'),
		        'manage_options',
		        'qc-mailing-list-help-license',
		        array($this, 'qcld_mailing_list_help_license_callback')
		    );
		}

		function qcld_mailing_list_help_license_callback(){
?>
			<div id="wrap">
				<div id="qcld_ml_mailchimp_section" class="qcld_ml_section_box qcld_ml_bg_white qcwbmc_mt_35 qcld_ml_py_20 qcld_ml_px_15 qcld_pd_20">
					<h2 class="qcld_ml_box_title"><?php esc_html_e('Mailchimp API Key', 'qc-mailing-list-integration'); ?></h2>
					<div class="qcld-mailing_list-section-block qcwbmc_mt_20 qcld_ml_font_size_16">
						<p>
							<?php esc_html_e('Visit', 'qc-mailing-list-integration'); ?>
							<a href='<?php echo esc_url("https://mailchimp.com/help/about-api-keys/#Find_or_Generate_Your_API_Key"); ?>' target='_blank'><?php esc_html_e('this link', 'qc-mailing-list-integration'); ?></a>
							<?php esc_html_e('to know how to get mailchimp API Key.', 'qc-mailing-list-integration'); ?>
						</p>
					</div>
				</div>

				<div id="qcld_ml_zapier_section" class="qcld_ml_section_box qcld_ml_bg_white qcwbmc_mt_35 qcld_ml_py_20 qcld_ml_px_15 qcld_pd_20">
					<h2 class="qcld_ml_box_title"><?php esc_html_e('Zapier Webhook Integration', 'qc-mailing-list-integration'); ?></h2>
					<div class="qcld-mailing_list-section-block qcwbmc_mt_20 qcld_ml_font_size_16">
						<ul>
							<li>
								<span><?php esc_html_e('Go to your Zap', 'qc-mailing-list-integration'); ?></span>
							</li>
							<li>
								<span><?php esc_html_e('Click on the "Choose App" field and Search for the', 'qc-mailing-list-integration'); ?> <strong><?php esc_html_e('"Webhooks by Zapier"', 'qc-mailing-list-integration'); ?></strong> <?php esc_html_e('app and Select it', 'qc-mailing-list-integration'); ?></span>
								<div class="qcld_mlimg_box">
									<img src="<?php echo esc_url(QCLD_MAILING_LIST_INTEGRATION_ADDON_URL.'/admin/assets/images/setup-zap-app.png'); ?>" alt="" width="663" height="472">
								</div>
							</li>
							<li>
								<span><?php esc_html_e('Click on the', 'qc-mailing-list-integration'); ?> <strong><?php esc_html_e('"Choose Trigger Event"', 'qc-mailing-list-integration'); ?></strong> <?php esc_html_e('field and select the "Catch Hook"', 'qc-mailing-list-integration'); ?></span>
								<div class="qcld_mlimg_box">
									<img src="<?php echo esc_url(QCLD_MAILING_LIST_INTEGRATION_ADDON_URL.'/admin/assets/images/setup-zap-app-catch.png'); ?>" alt="" width="661" height="464">
								</div>
							</li>
							<li>
								<span><?php esc_html_e('Go to Next Step by Click the', 'qc-mailing-list-integration'); ?> <strong><?php esc_html_e('"Continue"', 'qc-mailing-list-integration'); ?></strong> <?php esc_html_e('button and copy the Webhook Url from', 'qc-mailing-list-integration'); ?> <strong><?php esc_html_e('"Custom Webhook URL"', 'qc-mailing-list-integration'); ?></strong> <?php esc_html_e('field', 'qc-mailing-list-integration'); ?></span>
							</li>
						</ul>
					</div>
				</div>
			</div>
<?php
		}
	}
}