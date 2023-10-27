<?php


namespace qcformbuilderwp\QcformbuilderFormsQuery\Tests\Integration\Features;


use qcformbuilderwp\QcformbuilderFormsQuery\Features\FeatureContainer;
use qcformbuilderwp\QcformbuilderFormsQuery\Tests\Integration\IntegrationTestCase;

class FeatureContainerTest extends IntegrationTestCase
{

	/**
	 * Test the table names
	 *
	 * @covers FeatureContainer::getQueries()
	 * @covers FeatureContainer::bindServices()
	 */
	public function testTableNames()
	{
		$container = $this->containerFactory();

		//Select entry
		$this->assertEquals( $this->entryTableName(),
			$container
				->getQueries()
				->entrySelect()
				->getTableName()
		);

		//Select entry value
		$this->assertEquals( $this->entryValueTableName(),
			$container
				->getQueries()
				->entryValuesSelect()
				->getTableName()
		);

		//Delete entry
		$this->assertEquals( $this->entryTableName(),
			$container
				->getQueries()
				->entryDelete()
				->getTableName()
		);

		//Delete entry values
		$this->assertEquals( $this->entryValueTableName(),
			$container
				->getQueries()
				->entryValueDelete()
				->getTableName()
		);
	}
}