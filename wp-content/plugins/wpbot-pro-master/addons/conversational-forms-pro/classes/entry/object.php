<?php
/**
 * Base class for object representations of database rows
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
abstract class Qcformbuilder_Forms_Entry_Object extends Qcformbuilder_Forms_Object {


	/**
	 * @inheritdoc
	 */
	protected function get_prefix(){
		return 'entry';
	}

}
