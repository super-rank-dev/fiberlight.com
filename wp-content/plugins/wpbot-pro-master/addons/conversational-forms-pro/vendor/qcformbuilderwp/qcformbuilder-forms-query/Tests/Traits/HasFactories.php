<?php


namespace qcformbuilderwp\QcformbuilderFormsQuery\Tests\Traits;

use qcformbuilderwp\QcformbuilderContainers\Service\Container;
use qcformbuilderwp\QcformbuilderFormsQuery\DeleteQueries;
use qcformbuilderwp\QcformbuilderFormsQuery\Features\FeatureContainer;
use qcformbuilderwp\QcformbuilderFormsQuery\SelectQueries;
use qcformbuilderwp\QcformbuilderFormsQuery\Tests\Unit\Features\QueriesTest;

trait HasFactories
{

	/**
	 * @return \qcformbuilderwp\QcformbuilderFormsQuery\Select\Entry
	 */
	protected function entryGeneratorFactory()
	{
		return new \qcformbuilderwp\QcformbuilderFormsQuery\Select\Entry(
			$this->mySqlBuilderFactory(),
			$this->entryTableName()
		);
	}

	/**
	 * @return \qcformbuilderwp\QcformbuilderFormsQuery\Delete\Entry
	 */
	protected function entryDeleteGeneratorFactory()
	{
		return new \qcformbuilderwp\QcformbuilderFormsQuery\Delete\Entry(
			$this->mySqlBuilderFactory(),
			$this->entryTableName()
		);
	}


	/**
	 * @return \qcformbuilderwp\QcformbuilderFormsQuery\Select\EntryValues
	 */
	protected function entryValuesGeneratorFactory()
	{
		return new \qcformbuilderwp\QcformbuilderFormsQuery\Select\EntryValues(
			$this->mySqlBuilderFactory(),
			$this->entryValueTableName()
		);
	}
	/**
	 * @return \qcformbuilderwp\QcformbuilderFormsQuery\Delete\EntryValues
	 */
	protected function entryValuesDeleteGeneratorFactory()
	{
		return new \qcformbuilderwp\QcformbuilderFormsQuery\Delete\EntryValues(
			$this->mySqlBuilderFactory(),
			$this->entryValueTableName()
		);
	}



	/**
	 * @return \qcformbuilderwp\QcformbuilderFormsQuery\MySqlBuilder
	 */
	protected function mySqlBuilderFactory()
	{
		return new \qcformbuilderwp\QcformbuilderFormsQuery\MySqlBuilder();
	}


	/**
	 * @return SelectQueries
	 */
	protected function selectQueriesFactory()
	{

		return new SelectQueries(
			$this->entryGeneratorFactory(),
			$this->entryValuesGeneratorFactory(),
			$this->getWPDB()
		);
	}

	/**
	 * @return DeleteQueries
	 */
	protected function deleteQueriesFactory()
	{

		return new DeleteQueries(
			$this->entryDeleteGeneratorFactory(),
			$this->entryValuesDeleteGeneratorFactory(),
			$this->getWPDB()
		);
	}

	/**
	 * @return \qcformbuilderwp\QcformbuilderFormsQuery\Features\Queries
	 */
	protected function featureQueriesFactory()
	{
		return new \qcformbuilderwp\QcformbuilderFormsQuery\Features\Queries(
			$this->selectQueriesFactory(),
			$this->deleteQueriesFactory()
		);
	}

	/**
	 * @return FeatureContainer
	 */
	protected function containerFactory()
	{
		return new FeatureContainer(
			new Container(),
			$this->getWPDB()
		);
	}

	/**
	 * Gets a WPDB instance
	 *
	 * @return \wpdb
	 */
	protected function getWPDB()
	{
		global $wpdb;
		if (! class_exists('\WP_User')) {
			include_once dirname(dirname(__FILE__)) . '/Mock/wpdb.php';
		}

		if (! $wpdb) {
			$wpdb = new \wpdb('', '', '', '');
		}
		return $wpdb;
	}

	/**
	 * @return string
	 */
	protected function entryValueTableName(): string
	{
		return "{$this->getWPDB()->prefix}wfb_form_entry_values";
	}

	/**
	 * @return string
	 */
	protected function entryTableName(): string
	{
		return "{$this->getWPDB()->prefix}wfb_form_entries";
	}
}
