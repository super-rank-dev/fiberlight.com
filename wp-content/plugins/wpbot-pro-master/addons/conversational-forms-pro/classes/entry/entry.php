<?php

/**
 * Object representation of an entry (basic info, no values) - wfb_form_entries
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Entry_Entry extends Qcformbuilder_Forms_Entry_Object {

	/** @var  string */
	protected $id;

	/** @var  string */
	protected $form_id;

	/** @var  string */
	protected $user_id;

	/** @var  string */
	protected $datestamp;

	/** @var  string */
	protected $status;

}
