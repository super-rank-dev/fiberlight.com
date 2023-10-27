<?php
/**
 * TablePress Automatic Periodic Table Import.
 *
 * @package TablePress
 * @subpackage Automatic Periodic Table Import
 * @author Tobias Bäthge
 * @since 2.0.0
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Class that contains the logic for the Automatic Periodic Table Import feature for TablePress.
 *
 * @author Tobias Bäthge
 * @since 2.0.0
 */
class TablePress_Module_Automatic_Periodic_Table_Import {
	use TablePress_Module; // Use properties and methods from trait.

	/**
	 * Automatic Periodic Table Import configuration.
	 *
	 * @var array
	 * @since 2.0.0
	 */
	protected static $auto_import_config = array();

	/**
	 * Constructor.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		self::init_automatic_periodic_table_import();

		if ( is_admin() ) {
			self::init_admin();
		}
	}

	/**
	 * Loads the import configuration, i.e. the list of tables that are to be imported.
	 *
	 * @since 2.0.0
	 */
	public static function load_configuration() {
		$params = array(
			'option_name'   => 'tablepress_auto_import_config',
			'default_value' => array(),
		);
		self::$auto_import_config = TablePress::load_class( 'TablePress_WP_Option', 'class-wp_option.php', 'classes', $params );
	}

	/**
	 * Inits the Automatic Periodic Table Import module.
	 *
	 * @since 2.0.0
	 */
	public static function init_automatic_periodic_table_import() {
		add_filter( 'cron_schedules', array( __CLASS__, 'cron_add_quarterhourly' ) );
		add_action( 'tablepress_table_auto_import_hook', array( __CLASS__, 'perform_automatic_import' ) );
	}

	/**
	 * Adds "quarterhourly" as a new possible interval for cron hooks, as WP doesn't have it by default.
	 *
	 * @since 2.0.0
	 *
	 * @param array $schedules Current WP Cron schedules.
	 * @return array Extended WP Cron schedules.
	 */
	public static function cron_add_quarterhourly( $schedules ) {
		$schedules['quarterhourly'] = array(
			'interval' => 15 * MINUTE_IN_SECONDS,
			'display'  => __( 'Once every 15 minutes', 'tablepress' ),
		);
		return $schedules;
	}

	/**
	 * Loops through the list of tables, imports them from their given source, and replaces the existing data with the new data.
	 *
	 * @since 2.0.0
	 */
	public static function perform_automatic_import() {
		self::load_configuration();
		$configuration = self::$auto_import_config->get();

		// Nothing to do if there are no tables to be imported automatically.
		if ( empty( $configuration['tables'] ) ) {
			return;
		}

		$importer = TablePress::load_class( 'TablePress_Import', 'class-import.php', 'classes' );

		// For each table that shall be updated, and that exists, run the update function.
		foreach ( $configuration['tables'] as $table_id => $import_config ) {
			if ( ! $import_config['active'] ) {
				continue;
			}

			if ( ! TablePress::$model_table->table_exists( $table_id ) ) {
				continue;
			}

			$import_config['legacy_import'] = false;

			// Configure replacement of the given table.
			$import_config['type'] = 'replace';
			$import_config['existing_table'] = $table_id;

			// Store the import URL or server path in either 'url' or 'server'.
			$import_config[ $import_config['source'] ] = $import_config['location'];
			unset( $import_config['location'] );

			$import = $importer->run( $import_config );

			if ( is_wp_error( $import ) ) {
				$success = false;
				$error = TablePress::get_wp_error_string( $import );
			} elseif ( 0 < count( $import['errors'] ) ) {
				$success = false;
				$wp_error_strings = array();
				foreach ( $import['errors'] as $file ) {
					$wp_error_strings[] = TablePress::get_wp_error_string( $file['error'] );
				}
				$error = implode( ', ', $wp_error_strings );
			} else {
				$success = true;
				$error = '';
			}

			$import_message = $success ? __( 'Success', 'tablepress' ) : sprintf( '<strong>%s</strong>', __( 'Failed', 'tablepress' ) );
			$import_message .= ' @ ' . current_time( 'mysql' );
			if ( '' !== $error ) {
				$import_message .= " <em>{$error}</em>";
			}

			$configuration['tables'][ $table_id ]['last_import'] = $import_message;

			// Update the last import information in the configuration after every table, so that at least partial data is saved in case of an error.
			self::$auto_import_config->update( $configuration );
		}
	}

	/**
	 * Initializes the admin screens of the Automatic Periodic Table Import module.
	 *
	 * @since 2.0.0
	 */
	public static function init_admin() {
		if ( current_user_can( 'tablepress_import_tables' ) ) {
			add_filter( 'tablepress_load_file_full_path', array( __CLASS__, 'change_import_view_full_path' ), 10, 3 );
			add_filter( 'tablepress_load_class_name', array( __CLASS__, 'change_view_import_class_name' ) );
			add_filter( 'tablepress_view_data', array( __CLASS__, 'add_automatic_periodic_table_import_view_data' ), 10, 2 );
			add_action( 'wp_ajax_tablepress_import', array( __CLASS__, 'handle_ajax_action_automatic_periodic_import' ) );
		}
	}

	/**
	 * Loads the Automatic Periodic Table Import view class when the TablePress Import view class is loaded.
	 *
	 * @since 2.0.0
	 *
	 * @param string $full_path Full path of the class file.
	 * @param string $file      File name of the class file.
	 * @param string $folder    Folder name of the class file.
	 * @return string Modified full path.
	 */
	public static function change_import_view_full_path( $full_path, $file, $folder ) {
		if ( 'view-import.php' === $file ) {
			require_once $full_path; // Load desired file first, as we inherit from it in the new $full_path file.
			$full_path = TABLEPRESS_ABSPATH . 'modules/views/view-automatic_periodic_table_import.php';
		}
		return $full_path;
	}

	/**
	 * Changes Import View class name, to load extended view.
	 *
	 * @since 2.0.0
	 *
	 * @param string $class_name Name of the class that shall be loaded.
	 * @return string Changed class name.
	 */
	public static function change_view_import_class_name( $class_name ) {
		if ( 'TablePress_Import_View' === $class_name ) {
			$class_name = 'TablePress_Automatic_Periodic_Table_Import_View';
		}
		return $class_name;
	}

	/**
	 * Adds the view data for the Automatic Periodic Table Import view.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $data   Data for this screen.
	 * @param string $action Action for this screen.
	 * @return array Modified data for this screen.
	 */
	public static function add_automatic_periodic_table_import_view_data( array $data, $action ) {
		if ( 'import' !== $action ) {
			return $data;
		}

		self::load_configuration();

		$data['cron_schedules'] = wp_get_schedules();
		$data['auto_import_schedule'] = self::$auto_import_config->get( 'schedule', 'daily' );
		$data['auto_import_tables'] = self::$auto_import_config->get( 'tables', array() );

		return $data;
	}

	/**
	 * Saves the Automatic Periodic Table Import configuration.
	 *
	 * @since 2.0.0
	 */
	public static function handle_ajax_action_automatic_periodic_import() {
		if ( empty( $_POST['tablepress'] ) ) {
			wp_die( '-1' );
		}

		// Check if the submitted nonce matches the generated nonce we created earlier, dies -1 on failure.
		TablePress::check_nonce( 'import', false, '_ajax_nonce', true );

		// Ignore the request if the current user doesn't have sufficient permissions.
		if ( ! current_user_can( 'tablepress_import_tables' ) ) {
			wp_die( '-1' );
		}

		$auto_import_config = wp_unslash( $_POST['tablepress'] );
		$auto_import_config = (array) json_decode( $auto_import_config, true );

		// Check if JSON could be decoded.
		if ( is_null( $auto_import_config ) ) {
			wp_die( '-1' );
		}

		if ( ! isset( $auto_import_config['schedule'], $auto_import_config['tables'] ) || ! is_array( $auto_import_config['tables'] ) ) {
			wp_die( '-1' );
		}

		// Check if the schedule is valid.
		$schedules = wp_get_schedules();
		$schedule = isset( $schedules[ $auto_import_config['schedule'] ] ) ? $auto_import_config['schedule'] : 'daily';

		$configuration = array(
			'schedule' => $schedule,
			'tables'   => array(),
		);

		foreach ( $auto_import_config['tables'] as $table_id => $table ) {
			$table_id = (string) $table_id;
			$table['active'] = ( isset( $table['active'] ) && $table['active'] );
			if ( ! isset( $table['source'] ) ) {
				$table['source'] = 'url';
			}
			if ( ! isset( $table['location'] ) ) {
				$table['location'] = 'https://';
			}
			$table['last_import'] = '-';

			// Only save things for tables that have changes and not just the default settings.
			if ( $table['active'] || 'url' !== $table['source'] || 'https://' !== $table['location'] ) {
				$configuration['tables'][ $table_id ] = $table;
			}
		}

		self::load_configuration();
		self::$auto_import_config->update( $configuration );

		wp_clear_scheduled_hook( 'tablepress_table_auto_import_hook' );
		if ( ! wp_next_scheduled( 'tablepress_table_auto_import_hook' ) ) {
			wp_schedule_event( time(), $schedule, 'tablepress_table_auto_import_hook' );
		}

		$response = array(
			'success' => true,
			'message' => 'success_save',
		);
		// Buffer all outputs, to prevent errors/warnings being printed that make the JSON invalid.
		$output_buffer = ob_get_clean();
		if ( ! empty( $output_buffer ) ) {
			$response['output_buffer'] = $output_buffer;
		}

		// Send the response.
		wp_send_json( $response );
	}

} // class TablePress_Module_Automatic_Periodic_Table_Import
