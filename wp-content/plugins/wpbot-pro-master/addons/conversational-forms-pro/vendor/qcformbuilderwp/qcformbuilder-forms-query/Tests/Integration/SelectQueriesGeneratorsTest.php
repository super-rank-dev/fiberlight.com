<?php


namespace qcformbuilderwp\QcformbuilderFormsQuery\Tests\Integration;


use qcformbuilderwp\QcformbuilderFormsQuery\SelectQueries;
use qcformbuilderwp\QcformbuilderFormsQuery\CreatesSelectQueries;
use qcformbuilderwp\QcformbuilderFormsQuery\Select\EntryValues;
use qcformbuilderwp\QcformbuilderFormsQuery\Tests\Traits\CanCreateEntryWithEmailField;
use qcformbuilderwp\QcformbuilderFormsQuery\Tests\Traits\HasFactories;
use qcformbuilderwp\QcformbuilderFormsQuery\Tests\Traits\UsersMockFormAsDBForm;

class SelectQueriesGeneratorsTest extends IntegrationTestCase
{
	use CanCreateEntryWithEmailField;

	/**
	 * Test reset builder allows us to create new queries on generator
	 *
	 * @covers CreatesSelectQueries::getEntryValueGenerator()
	 * @covers EntryValues::resetQuery()
	 */
	public function testReset()
	{
		$emailOne = 'one@email.com';
		$entryIdOne = $this->createEntryWithEmail($emailOne);
		$emailTwo = 'two@email.com';
		$entryIdTwo = $this->createEntryWithEmail($emailTwo);
		$entryQueries = $this->selectQueriesFactory();

		//Email one by email
		$results = $entryQueries
			->getResults(
				$entryQueries
					->getEntryValueGenerator()
					->queryByFieldValue(
						$this->getEmailFieldSlug(),
						$emailOne
					)
				->getPreparedSql()
			);
		$this->assertSame(1, count($results));

		//Email one by entry_id
		$results = $entryQueries
			->getResults(
				$entryQueries
					->getEntryValueGenerator()
					->queryByEntryId(
						$entryIdOne
					)
					->getPreparedSql()
			);
		$this->assertSame(1, count($results));

		$entryQueries
			->getEntryValueGenerator()
			->resetQuery();

		//Email two by email
		$results = $entryQueries
			->getResults(
				$entryQueries
					->getEntryValueGenerator()
					->queryByFieldValue(
						$this->getEmailFieldSlug(),
						$emailTwo
					)
					->getPreparedSql()
			);
		$this->assertSame(1, count($results));

		//Email two by entry_id
		$results = $entryQueries
			->getResults(
				$entryQueries
					->getEntryValueGenerator()
					->queryByEntryId(
						$entryIdTwo
					)
					->getPreparedSql()
			);
		$this->assertSame(1, count($results));

	}

}