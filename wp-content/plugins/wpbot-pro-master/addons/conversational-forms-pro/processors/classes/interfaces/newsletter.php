<?php

/**
 * Interface that newsletter add-ons should implement
 *
 * @package   Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
interface Qcformbuilder_Forms_Processor_Interface_Newsletter extends Qcformbuilder_Forms_Processor_Interface_Process {

	/**
	 * Add a subscriber to a list
	 *
	 * @since 1.3.5.3
	 *
	 * @param array $subscriber_data Data for new subscriber
	 * @param string $list_name Name of list
	 *
	 * @return mixed
	 */
	public function subscribe( array $subscriber_data, $list_name );

}
