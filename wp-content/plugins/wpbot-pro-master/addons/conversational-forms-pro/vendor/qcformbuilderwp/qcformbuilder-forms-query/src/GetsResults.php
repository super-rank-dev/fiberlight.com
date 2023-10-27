<?php


namespace qcformbuilderwp\QcformbuilderFormsQuery;

interface GetsResults
{
	/**
	 * @param $sql
	 * @return \stdClass[]
	 */
	public function getResults($sql);
}
