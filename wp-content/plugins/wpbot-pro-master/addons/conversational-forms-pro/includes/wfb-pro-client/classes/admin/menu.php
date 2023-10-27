<?php


namespace qcformbuilderwp\qcformbuilderforms\pro\admin;


/**
 * Class menu
 * @package qcformbuilderwp\qcformbuilderforms\pro\admin
 */
class menu
{

	protected $view_dir;

	/**
	 * @var scripts
	 */
	protected $scripts;

	protected $slug;

	public function __construct($view_dir, $slug, scripts $scripts)
	{
		$this->view_dir = $view_dir;
		$this->slug = $slug;
		$this->scripts = $scripts;
	}

	/**
	 * Create admin page view
	 *
	 * @since 0.1.0
	 */
	public function display()
	{
		add_submenu_page(
			\Qcformbuilder_Forms::PLUGIN_SLUG,
			__('Chatbot Form Builder Pro', 'qcformbuilder-forms'),
			'<span class="qcformbuilder-forms-menu-dashicon"><span class="dashicons dashicons-star-filled"></span>' . __('Chatbot Form Builder Pro',
				'qcformbuilder-forms') . '</span>',
			'manage_options',
			$this->slug,
			[ $this, 'render' ]
		);
	}

	/**
	 * Redner admin page view
	 *
	 * @since 0.1.0
	 */
	public function render()
	{
		echo $this->scripts->webpack($this->view_dir);

	}

}
