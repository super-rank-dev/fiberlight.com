<?php

/**
 * Interface that all CDN integrations must impliment
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 QcformbuilderWP LLC
 */
interface Qcformbuilder_Forms_CDN_Contract {

	/**
	 * The URL for CDN to replace site URL with
	 *
	 * NOTE: Do NOT add protocol. start with //
	 *
	 * @since 1.5.3
	 *
	 * @return string
	 */
	public function cdn_url();

}