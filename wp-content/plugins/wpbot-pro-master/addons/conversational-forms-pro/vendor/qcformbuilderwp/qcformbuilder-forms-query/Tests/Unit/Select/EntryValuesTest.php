<?php


namespace qcformbuilderwp\QcformbuilderFormsQuery\Tests\Unit\Select;

use qcformbuilderwp\QcformbuilderFormsQuery\Tests\Unit\TestCase;

class EntryValuesTest extends TestCase
{

	/**
	 * Test query by field where field value equals a value
	 *
	 * @covers \qcformbuilderwp\QcformbuilderFormsQuery\Select\EntryValues::queryByFieldValue()
	 */
	public function testQueryByFieldValueEquals()
	{
		$expectedSql = "SELECT `{$this->entryValueTableName()}`.* FROM `{$this->entryValueTableName()}` WHERE (`{$this->entryValueTableName()}`.`value` = 'josh@qcformbuilderwp.com') AND (`{$this->entryValueTableName()}`.`slug` = 'email_address')";

		$entryValues = $this->entryValuesGeneratorFactory();
		$generator = $entryValues->queryByFieldValue('email_address', 'josh@qcformbuilderwp.com');
		$this->assertTrue($this->isAEntryValues($generator));

		$actualSql = $entryValues->getPreparedSql();
		$this->assertEquals($expectedSql, $actualSql);
	}

	/**
	 * Test query by field where field value does not equals a value
	 *
	 * @covers \qcformbuilderwp\QcformbuilderFormsQuery\Select\EntryValues::queryByFieldValue()
	 */
	public function testQueryByFieldValueNotEquals()
	{
		$expectedSql = "SELECT `{$this->entryValueTableName()}`.* FROM `{$this->entryValueTableName()}` WHERE (`{$this->entryValueTableName()}`.`value` <> 'josh@qcformbuilderwp.com') AND (`{$this->entryValueTableName()}`.`slug` = 'email_address')";
		$entryValues = $this->entryValuesGeneratorFactory();
		$generator =$entryValues->queryByFieldValue('email_address', 'josh@qcformbuilderwp.com', 'notEquals');
		$this->assertTrue($this->isAEntryValues($generator));

		$actualSql = $entryValues->getPreparedSql();
		$this->assertEquals($expectedSql, $actualSql);
	}

	/**
	 * Test query by field where field value is like a value
	 *
	 * @cover \qcformbuilderwp\QcformbuilderFormsQuery\Select\EntryValues::$isLike
	 * @covers \qcformbuilderwp\QcformbuilderFormsQuery\Select\EntryValues::queryByFieldValue()
	 */
	public function testQueryByFieldValueLike()
	{
		$expectedSql = "SELECT `{$this->entryValueTableName()}`.* FROM `{$this->entryValueTableName()}` WHERE (`{$this->entryValueTableName()}`.`value` LIKE '\%josh@qcformbuilderwp.com\%')";
		
		$entryValues = $this->entryValuesGeneratorFactory();
		$generator = $entryValues->queryByFieldValue('email_address', 'josh@qcformbuilderwp.com', 'like');
		$this->assertTrue($this->isAEntryValues($generator));

		$actualSql = $entryValues->getPreparedSql();
		$this->assertEquals($expectedSql, $actualSql);
	}

	/**
	 * Test query by entry id
	 *
	 * @covers \qcformbuilderwp\QcformbuilderFormsQuery\Select\EntryValues::queryByFieldValue()
	 */
	public function testQueryByEntryId()
	{
		$expectedSql = "SELECT `{$this->entryValueTableName()}`.* FROM `{$this->entryValueTableName()}` WHERE (`{$this->entryValueTableName()}`.`entry_id` = 42)";
		$entryValues = $this->entryValuesGeneratorFactory();
		$generator = $entryValues->queryByEntryId(42);
		$this->assertTrue($this->isAEntryValues($generator));

		$actualSql = $entryValues->getPreparedSql();
		$this->assertEquals($expectedSql, $actualSql);
	}

	/**
	 * @param $generator
	 * @return bool
	 */
	protected function isAEntryValues($generator)
	{
		return is_a($generator, '\qcformbuilderwp\QcformbuilderFormsQuery\Select\EntryValues');
	}
}
