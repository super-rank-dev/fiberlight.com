<?php

/**
 * Creates an email preview
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Email_Preview extends Qcformbuilder_Forms_Email_Save {

	/**
	 * @inheritdoc
	 */
	public function jsonSerialize() {
		return array(
			'headers' => $this->headers(),
			'message' => $this->body(),
			'content-type' => $this->content_type()

		);

	}
	
}