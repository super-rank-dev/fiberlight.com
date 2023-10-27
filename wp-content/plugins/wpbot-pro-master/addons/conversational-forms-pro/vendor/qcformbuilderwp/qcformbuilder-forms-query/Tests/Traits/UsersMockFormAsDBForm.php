<?php


namespace qcformbuilderwp\QcformbuilderFormsQuery\Tests\Traits;

trait UsersMockFormAsDBForm
{

	use \Qcformbuilder_Forms_Has_Data, HasFactories;
	/** @inheritdoc */
	protected $mock_form_id;
	/** @inheritdoc */
	protected $mock_form;
	/** @inheritdoc */

	public function setUp()
	{
		global $wpdb;
		$tables = new \Qcformbuilder_Forms_DB_Tables($wpdb);
		$tables->add_if_needed();
		$this->set_mock_form();
		$this->mock_form_id = \Qcformbuilder_Forms_Forms::import_form($this->mock_form);
		$this->mock_form = \Qcformbuilder_Forms_Forms::get_form($this->mock_form_id);
		parent::setUp();
	}
}
