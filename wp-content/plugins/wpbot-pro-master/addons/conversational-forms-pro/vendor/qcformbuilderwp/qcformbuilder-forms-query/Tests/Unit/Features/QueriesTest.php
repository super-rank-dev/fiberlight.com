<?php
namespace qcformbuilderwp\QcformbuilderFormsQuery\Tests\Unit\Features;

use qcformbuilderwp\QcformbuilderFormsQuery\Delete\Entry;
use qcformbuilderwp\QcformbuilderFormsQuery\Delete\EntryValues;
use qcformbuilderwp\QcformbuilderFormsQuery\Tests\Unit\TestCase;

class QueriesTest extends TestCase
{
	/**
	 * Test getting entry delete SQL generator
	 *
	 * @covers Queries::entryDelete()
	 */
	public function testGetDeleteEntryGenerator()
	{
		$queries = $this->featureQueriesFactory();
		$this->assertTrue(is_a($queries->entryDelete(), Entry::class));
	}

	/**
	 * Test getting entry delete values SQL generator
	 *
	 * @covers Queries::entryValueDelete()
	 */
	public function testGetDeleteEntryValueGenerator()
	{
		$queries = $this->featureQueriesFactory();
		$this->assertTrue(is_a($queries->entryValueDelete(), EntryValues::class));
	}
	/**
	 * Test getting entry select SQL generator
	 *
	 * @covers Queries::entrySelect()
	 */
	public function testGetSelectEntryGenerator()
	{
		$queries = $this->featureQueriesFactory();
		$this->assertTrue(is_a($queries->entrySelect(), \qcformbuilderwp\QcformbuilderFormsQuery\Select\Entry::class));
	}

	/**
	 * Test getting entry values  select SQL generator
	 *
	 * @covers Queries::entryValuesSelect()
	 */
	public function testGetSelectEntryValueGenerator()
	{
		$queries = $this->featureQueriesFactory();
		$this->assertTrue(is_a($queries->entryValuesSelect(), \qcformbuilderwp\QcformbuilderFormsQuery\Select\EntryValues::class));
	}
}
