<?php


namespace qcformbuilderwp\qcformbuilderforms\pro\admin;

use qcformbuilderwp\qcformbuilderforms\pro\container;


/**
 * Class scripts
 * @package qcformbuilderwp\qcformbuilderforms\pro\admin
 */
class scripts
{

	/** @var string */
	protected $assets_url;

	/** @var string */
	protected $slug;

	/** @var string */
	protected $version;

	/**
	 * scripts constructor.
	 *
	 * @param string $assets_url Url for  assets dir
	 * @param string $slug Slug for script/css
	 * @param string $version Current version
	 */
	public function __construct($assets_url, $slug, $version)
	{
		$this->assets_url = $assets_url;
		$this->slug = $slug;
		$this->version = $version;

	}

	public function get_assets_url()
	{
		return $this->assets_url;
	}

	/**
	 * @param string $view_dir @deprecated
	 * @param null $context Default is for admin page. Pass "tab" for use in CF admin.
	 * @param bool $enqueue_admin
	 *
	 * @return string
	 */
	public function webpack($view_dir, $context = null, $enqueue_admin = true)
	{
		\Qcformbuilder_Forms_Render_Assets::maybe_register();
		if ( $enqueue_admin ) {
			wp_enqueue_style(\Qcformbuilder_Forms_Admin_Assets::slug('admin', false),
				\Qcformbuilder_Forms_Render_Assets::make_url('admin', false));
			\Qcformbuilder_Forms_Admin_Assets::set_wfb_admin(\Qcformbuilder_Forms_Render_Assets::make_slug('pro'));
		}
		\Qcformbuilder_Forms_Render_Assets::enqueue_style('pro');
		\Qcformbuilder_Forms_Render_Assets::enqueue_script('pro');
		wp_localize_script(\Qcformbuilder_Forms_Render_Assets::make_slug('pro'), 'CF_PRO_ADMIN', $this->data());
		if ( 'tab' === $context ) {
			$id = 'wfb-pro-app-tab';
		} else {
			$id = 'wfb-pro-app';
		}
		return sprintf('<div id="%s"></div>', $id);
	}

	/**
	 * Data to localize
	 *
	 * @return array
	 */
	public function data()
	{
		$pro_url = admin_url('admin.php?page=wfb-pro');

		$data = [
			'strings' => [
				'saved' => esc_html__('Settings Saved', 'qcformbuilder-forms'),
				'notSaved' => esc_html__('Settings could not be saved', 'qcformbuilder-forms'),
				'apiKeysViewText' => esc_html__('You must add your API keys to use Chatbot Form Builder Pro', 'qcformbuilder-forms'),
				'apiKeysViewLink' => esc_url($pro_url),
				'minLogLevelTitle' => esc_html__('Minimum Log Level', 'qcformbuilder-forms'),
				'minLogLevelInfo' => esc_html__('Setting a higher level than notice may affect performance, and should only be used when instructed by support.',
					'qcformbuilder-forms'),
				'whatIsCFPro' => [
					'firstParagraph' => esc_html__("Chatbot Form Builder Pro is an app + plugin that makes forms easy.",
						'qcformbuilder-forms'),
					'hTitle' => esc_html__('Benefits', 'qcformbuilder-forms'),
					'firstLi' => esc_html__('Enhanced Email Delivery', 'qcformbuilder-forms'),
					'secondLi' => esc_html__('Form To PDF', 'qcformbuilder-forms'),
					'thirdLi' => esc_html__('Priority Support.', 'qcformbuilder-forms'),
					'fourthLi' => esc_html__('Add-ons Included in Yearly Plans', 'qcformbuilder-forms'),
				],
				'freeTrial' => [
					'firstParagraph' => esc_html__('Ready to try Chatbot Form Builder Pro? Plans start at just $14.99/ month with a 7 day free trial.',
						'qcformbuilder-forms'),
					'buttonLeft' => esc_html__('View Documentation', 'qcformbuilder-forms'),
					'buttonRight' => esc_html__('Start Free Trial', 'qcformbuilder-forms'),
				],
				'notConnected' => esc_html__('Not Connected', 'qcformbuilder-forms'),
				'connected' => esc_html__('Connected', 'qcformbuilder-forms'),
				'tabNames' => [
					'account' => esc_html__('Account', 'qcformbuilder-forms'),
					'formSettings' => esc_html__('Form Settings', 'qcformbuilder-forms'),
					'settings' => esc_html__('Settings', 'qcformbuilder-forms'),
					'whatIsCFPro' => esc_html__('What is Chatbot Form Builder Pro ?', 'qcformbuilder-forms'),
					'freeTrial' => esc_html__('Free Trial', 'qcformbuilder-forms'),
				],
			],
			'api' => [
				'cf' => [
					'url' => esc_url_raw(\Qcformbuilder_Forms_API_Util::url('settings/pro')),
					'nonce' => wp_create_nonce('wp_rest'),
				],
				'cfPro' => [
					'url' => esc_url_raw(qcformbuilder_forms_pro_app_url()),
					'auth' => [],
				],
			],
			'settings' => container::get_instance()->get_settings()->toArray(),
			'logLevels' => container::get_instance()->get_settings()->log_levels(),
		];

		$data[ 'formScreen' ] = \Qcformbuilder_Forms_Admin::is_edit() ? esc_attr($_GET[ \Qcformbuilder_Forms_Admin::EDIT_KEY ]) : false;

		return $data;
	}
}
