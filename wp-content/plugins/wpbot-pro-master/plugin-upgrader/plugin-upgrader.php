<?php

require_once(plugin_dir_path(__FILE__).'/config.php');

require_once(plugin_dir_path(__FILE__).'/classes/plugin-upgrader.php');

require_once(plugin_dir_path(__FILE__).'/admin/license-settings-page.php');

require_once(plugin_dir_path(__FILE__).'/admin/admin-notices.php');

require_once(plugin_dir_path(__FILE__).'/utils.php');


new QCLD_wpbotpro_License_Settings_page();