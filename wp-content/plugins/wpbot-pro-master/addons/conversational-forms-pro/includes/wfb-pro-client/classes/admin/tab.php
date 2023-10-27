<?php


namespace qcformbuilderwp\qcformbuilderforms\pro\admin;


/**
 * Class tab
 * @package qcformbuilderwp\qcformbuilderforms\pro\admin
 */
class tab
{
	/**
	 * Path to index.html
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $template_path;

	/**
	 * tab constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param $template_path
	 */
	public function __construct($template_path)
	{
		$this->template_path = $template_path;
	}

	/**
	 * Add pro tab to admin
	 *
	 * @since 1.0.0
	 *
	 * @uses "qcformbuilder_forms_get_panel_extensions" filter
	 *
	 * @param array $panels
	 *
	 * @return array
	 */
	public function add_tab(array $panels = [])
	{
		$panels[ 'form_layout' ][ 'tabs' ][ 'wfb-pro' ] = [
			'name' => __('Pro', 'qcformbuilder-forms'),
			'label' => __('Chatbot Form Builder Pro Settings For This Form', 'qcformbuilder-forms'),
			'location' => 'lower',
			'actions' => [],
			'side_panel' => null,
			'canvas' => $this->template_path,
		];

		return $panels;
	}


}
