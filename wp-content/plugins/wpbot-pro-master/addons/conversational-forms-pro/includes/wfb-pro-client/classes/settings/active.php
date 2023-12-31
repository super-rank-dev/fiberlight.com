<?php

namespace qcformbuilderwp\qcformbuilderforms\pro\settings;

use qcformbuilderwp\qcformbuilderforms\pro\container;


/**
 * Class active
 * @package qcformbuilderwp\qcformbuilderforms\pro\settings
 */
class active
{

	/**
	 * Check if CF Pro API is active for this site or not
	 *
	 * @since 0.2.0
	 *
	 * @return bool
	 */
	public static function get_status()
	{
		$active = container::get_instance()->get_settings()->get_api_keys()->get_public();
		if ( $active ) {
			$active = container::get_instance()->get_settings()->get_api_keys()->get_secret();
		}
		/**
		 * Override active status
		 *
		 * @since 0.2.0
		 *
		 * @param bool $status
		 */
		return (bool) apply_filters('qcformbuilder_forms_pro_is_active', $active);

	}

}
