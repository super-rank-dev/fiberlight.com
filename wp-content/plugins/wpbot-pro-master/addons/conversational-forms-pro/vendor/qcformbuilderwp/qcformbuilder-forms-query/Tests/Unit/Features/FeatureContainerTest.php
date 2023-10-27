<?php


namespace qcformbuilderwp\QcformbuilderFormsQuery\Tests\Unit\Features;

use qcformbuilderwp\QcformbuilderContainers\Service\Container as TheServiceContainer;
use qcformbuilderwp\QcformbuilderFormsQuery\Features\DoesQueries;
use qcformbuilderwp\QcformbuilderFormsQuery\Features\FeatureContainer;
use qcformbuilderwp\QcformbuilderFormsQuery\Features\Queries;
use qcformbuilderwp\QcformbuilderFormsQuery\MySqlBuilder;
use qcformbuilderwp\QcformbuilderFormsQuery\Tests\Unit\TestCase;
use NilPortugues\Sql\QueryBuilder\Builder\BuilderInterface;

class FeatureContainerTest extends TestCase
{

	/**
	 * Test getting the main MySQL Builder
	 *
	 * @covers FeatureContainer::getBuilder()
	 * @covers FeatureContainer::bindServices()
	 */
	public function testGetBuilder()
	{
		$serviceContainer = new TheServiceContainer();
		$container = new FeatureContainer($serviceContainer, $this->getWPDB());
		$this->assertTrue(is_object($serviceContainer->make(MySqlBuilder::class)));
		$this->assertTrue(is_object($container->getBuilder()));

		$this->assertTrue(
			is_a(
				$container->getBuilder(),
				BuilderInterface::class
			)
		);

		$this->assertEquals(
			$serviceContainer->make(MySqlBuilder::class),
			$container->getBuilder()
		);
	}

	/**
	 * Test getting the main query builder
	 *
	 * @covers FeatureContainer::bindServices()
	 * @covers FeatureContainer::getQueries()
	 */
	public function testGetQueries()
	{
		$serviceContainer = new TheServiceContainer();
		$container = new FeatureContainer($serviceContainer, $this->getWPDB());

		$this->assertTrue(
			is_a(
				$container->getQueries(),
				Queries::class
			)
		);

		$this->assertEquals(
			$serviceContainer->make(Queries::class),
			$container->getQueries()
		);
	}

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
		$this->assertEquals(
			$this->entryTableName(),
			$container
				->getQueries()
				->entrySelect()
				->getTableName()
		);

		//Select entry value
		$this->assertEquals(
			$this->entryValueTableName(),
			$container
				->getQueries()
				->entryValuesSelect()
				->getTableName()
		);

		//Delete entry
		$this->assertEquals(
			$this->entryTableName(),
			$container
				->getQueries()
				->entryDelete()
				->getTableName()
		);

		//Delete entry values
		$this->assertEquals(
			$this->entryValueTableName(),
			$container
				->getQueries()
				->entryValueDelete()
				->getTableName()
		);
	}
}
