<?php

namespace qcformbuilderwp\QcformbuilderFormsQueries;

use qcformbuilderwp\QcformbuilderContainers\Service\Container;
use qcformbuilderwp\QcformbuilderFormsQuery\Features\FeatureContainer;

/**
 * The QcformbuilderFormsQueries
 *
 * Acts as static accessor for feature container
 *
 * @return FeatureContainer
 */
function QcformbuilderFormsQueries()
{
	static $QcformbuilderFormsQueries;
	if (! $QcformbuilderFormsQueries) {
		global $wpdb;
		$QcformbuilderFormsQueries = new FeatureContainer(
			new Container(),
			$wpdb
		);
	}

	return $QcformbuilderFormsQueries;
}
