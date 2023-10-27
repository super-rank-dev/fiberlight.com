<?php


namespace qcformbuilderwp\QcformbuilderFormsQuery;

use qcformbuilderwp\QcformbuilderFormsQuery\Delete\Entry;
use qcformbuilderwp\QcformbuilderFormsQuery\Delete\EntryValues;

/**
 * Interface CreatesDeleteQueries
 *
 * Interface that all classes that query for entries MUST impliment
 */
interface CreatesDeleteQueries extends GetsResults
{
	/**
	 * Get DELETE query generator for entry values SQL
	 *
	 * @return EntryValues
	 */
	public function getEntryValueGenerator();
	/**
	 * Get DELETE query generator for entry table SQL
	 *
	 * @return Entry
	 */
	public function getEntryGenerator();
}
