<?php

/**
 * Interface all REST API routes should use
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
interface Qcformbuilder_Forms_API_Route {

	/**
	 * Add the routes for this set of endpoints
	 *
	 * @since 1.4.4
	 *
	 * @param string $namespace API namespace
	 *
	 * @return void
	 */
	public function add_routes( $namespace );

}