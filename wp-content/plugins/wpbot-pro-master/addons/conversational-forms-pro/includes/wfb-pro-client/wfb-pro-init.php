<?php

/**
 * Start Chatbot Form Builder Pro API client
 *
 * NOTE: This file is included directly and MUST be PHP5.2 compatible. Hence why boostrap-wfb-pro.php is a separate, non-PHP 5.2 compatible file.
 */
add_action('qcformbuilder_forms_includes_complete', 'qcformbuilder_forms_pro_client_init', 1);
remove_action('qcformbuilder_forms_includes_complete', 'qcformbuilder_forms_pro_init', 2);

/**
 * Initialize Chatbot Form Builder Pro API client if possible
 *
 * @since 1.5.8
 */
function qcformbuilder_forms_pro_client_init()
{
	if ( !version_compare(PHP_VERSION, '5.6.0', '>=') ) {
		$admin = new Qcformbuilder_Forms_Admin_Pro();
		$admin->add_hooks();
		define('CF_PRO_NOT_LOADED', true);
	} else {
		if ( !defined('CF_PRO_VER') ) {
			define('CF_PRO_LOADED', true);
			/**
			 * Define Plugin basename for updater
			 *
			 * @since 0.2.0
			 */
			define('CF_PRO_BASENAME', plugin_basename(__FILE__));

			/**
			 * Chatbot Form Builder Pro Client Version
			 */
			define('CF_PRO_VER', WFBCORE_VER);

			include_once dirname(__FILE__) . '/bootstrap-wfb-pro.php';

			register_activation_hook(__FILE__, 'qcformbuilder_forms_pro_activation_hook_callback');

		}

	}

}
