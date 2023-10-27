<?php


namespace qcformbuilderwp\qcformbuilderforms\pro\attachments;


/**
 * Class phpmailer
 * @package qcformbuilderwp\qcformbuilderforms\pro\attachments
 */
class phpmailer extends \PHPMailer
{

	/** @inheritdoc */
	public function attachAll($disposition_type, $boundary)
	{
		return parent::attachAll($disposition_type, $boundary);
	}
}
