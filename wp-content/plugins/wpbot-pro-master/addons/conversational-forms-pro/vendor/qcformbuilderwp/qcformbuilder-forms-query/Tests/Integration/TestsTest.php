<?php


namespace qcformbuilderwp\QcformbuilderFormsQuery\Tests\Integration;

use qcformbuilderwp\QcformbuilderFormsQuery\SelectQueries;
use qcformbuilderwp\QcformbuilderFormsQuery\Select\Entry;
use qcformbuilderwp\QcformbuilderFormsQuery\Select\EntryValues;

/**
 * Class TestsTest
 *
 * Tests to ensure integration test environment is working
 * @package qcformbuilderwp\QcformbuilderFormsQuery\Tests\Integration
 */
class TestsTest extends IntegrationTestCase
{
	//Using this so we can test that CF's testing traits are available
	use \Qcformbuilder_Forms_Has_Mock_Form;

	/**
	 * Check that Chatbot Form Builder is usable
	 */
	public function testQcformbuilderFormsIsInstalled()
	{
		$this->assertTrue( defined( 'WFBCORE_VER' ) );
		$this->assertTrue( class_exists( '\Qcformbuilder_Forms' ) );
	}

	/**
	 * Make sure the trait worked
	 */
	public function testMockForm()
	{
		$this->set_mock_form();
		$this->assertTrue( is_array( $this->mock_form  ) );
	}

	/**
	 * Test that factories work for integration tests
	 *
	 * @covers HasFactories::selectQueriesFactory()
	 * @covers HasFactories::entryValuesGeneratorFactory()
	 * @covers HasFactories::entryGeneratorFactory()
	 */
	public function testFactory()
	{
		$this->assertTrue(is_a($this->selectQueriesFactory(), SelectQueries::class));
		$this->assertTrue(is_a($this->entryValuesGeneratorFactory(), EntryValues::class));
		$this->assertTrue(is_a($this->entryGeneratorFactory(), Entry::class));

	}

}