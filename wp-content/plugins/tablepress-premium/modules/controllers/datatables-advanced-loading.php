<?php
/**
 * TablePress DataTables Advanced Loading.
 *
 * @package TablePress
 * @subpackage DataTables
 * @author Tobias Bäthge
 * @since 2.0.0
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Class that contains the logic for the DataTables Advanced Loading feature.
 *
 * @author Tobias Bäthge
 * @since 2.0.0
 */
class TablePress_Module_DataTables_Advanced_Loading {
	use TablePress_Module; // Use properties and methods from trait.

	/**
	 * Registers necessary plugin filter hooks.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		if ( is_admin() ) {
			add_filter( 'tablepress_view_data', array( __CLASS__, 'add_edit_screen_elements' ), 10, 2 );
		}

		add_filter( 'tablepress_table_template', array( __CLASS__, 'add_option_to_table_template' ) );
		add_filter( 'tablepress_shortcode_table_default_shortcode_atts', array( __CLASS__, 'add_shortcode_parameters' ) );
		add_filter( 'tablepress_table_js_options', array( __CLASS__, 'pass_render_options_to_js_options' ), 10, 3 );
		add_filter( 'tablepress_datatables_parameters', array( __CLASS__, 'set_datatables_parameters' ), 10, 4 );
		add_filter( 'tablepress_table_render_data', array( __CLASS__, 'shorten_rendered_table' ), 10, 3 );
		add_filter( 'tablepress_table_output', array( __CLASS__, 'add_data_as_json_array' ), 10, 3 );
	}

	/**
	 * Adds options related to DataTables Advanced Loading to the table template.
	 *
	 * @since 2.0.0
	 *
	 * @param array $table Current table template.
	 * @return array Extended table template.
	 */
	public static function add_option_to_table_template( array $table ) {
		$table['options']['datatables_advanced_loading'] = false;
		$table['options']['datatables_advanced_loading_html_rows'] = 10;
		return $table;
	}

	/**
	 * Registers "Edit" screen elements for the "DataTables Advanced Loading" feature.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $data   Data for this screen.
	 * @param string $action Action for this screen.
	 * @return array Modified data for this screen.
	 */
	public static function add_edit_screen_elements( array $data, $action ) {
		if ( 'edit' === $action ) {
			// Add a meta box below the default meta boxes, by using the "low" priority.
			add_meta_box( 'tablepress_edit-datatables-advanced-loading', __( 'Advanced Loading', 'tablepress' ), array( __CLASS__, 'postbox_datatables_advanced_loading' ), null, 'normal', 'low' );

			TablePress_Modules_Helper::enqueue_script( 'datatables-advanced-loading' );
			add_filter( 'tablepress_admin_page_script_dependencies', array( __CLASS__, 'add_script_dependencies' ), 10, 2 );
		}
		return $data;
	}

	/**
	 * Adds DataTables Advanced Loading script as a dependency for the "Edit" script, so that hooks are added before they are executed.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $dependencies List of the dependencies that the $name script relies on.
	 * @param string $name         Name of the JS script, without extension.
	 * @return array Modified list of the dependencies that the $name script relies on.
	 */
	public static function add_script_dependencies( array $dependencies, $name ) {
		if ( 'edit' === $name ) {
			$dependencies[] = 'tablepress-datatables-advanced-loading';
		}
		return $dependencies;
	}

	/**
	 * Prints the content of the "DataTables Advanced Loading" post meta box.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data Data for this screen.
	 * @param array $box  Information about the meta box.
	 */
	public static function postbox_datatables_advanced_loading( array $data, array $box ) {
		$help_box_content = '';
		self::print_help_box_markup( $help_box_content );
		?>
		<p id="notice-datatables-advanced-loading-requirements"><em><?php printf( __( 'This feature is only available when the “%1$s” and “%2$s” checkboxes in the “%3$s” and “%4$s” sections are checked.', 'tablepress' ), __( 'Table Head Row', 'tablepress' ), __( 'Enable Visitor Features', 'tablepress' ), __( 'Table Options', 'tablepress' ), __( 'Table Features for Site Visitors', 'tablepress' ) ); ?></em></p>
		<p id="notice-datatables-advanced-loading-conflict-datatables-serverside-processing"><em><?php printf( __( 'This feature is only available when the “%1$s” feature is turned off.', 'tablepress' ), __( 'Server-side Processing', 'tablepress' ) ); ?></em></p>
		<p><label for="option-datatables_advanced_loading"><input type="checkbox" name="datatables_advanced_loading" id="option-datatables_advanced_loading" /> <?php _e( 'Load the table from a JavaScript array.', 'tablepress' ); ?></label></p>
		<details id="tablepress-datatables_advanced_loading-advanced-settings">
			<summary><?php _e( 'Advanced settings', 'tablepress' ); ?></summary>
			<div>
				<label for="option-datatables_advanced_loading_html_rows"><?php printf( __( 'Show %s rows as HTML.', 'tablepress' ), '<input type="number" name="datatables_advanced_loading_html_rows" id="option-datatables_advanced_loading_html_rows" class="small-text" min="1" max="99999" required />' ); ?></label>
			</div>
		</details>
		<?php
	}

	/**
	 * Adds parameters for the DataTables Advanced Loading feature to the [table /] Shortcode.
	 *
	 * By using null as the default value, the table options's value will be used (if set).
	 *
	 * @since 2.0.0
	 *
	 * @param array $default_atts Default attributes for the TablePress [table /] Shortcode.
	 * @return array Extended attributes for the Shortcode.
	 */
	public static function add_shortcode_parameters( array $default_atts ) {
		$default_atts['datatables_advanced_loading'] = null;
		$default_atts['datatables_advanced_loading_html_rows'] = null;
		return $default_atts;
	}

	/**
	 * Passes the DataTables Advanced Loading configuration from Shortcode parameters to JavaScript arguments.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $js_options     Current JS options.
	 * @param string $table_id       Table ID.
	 * @param array  $render_options Render Options.
	 * @return array Modified JS options.
	 */
	public static function pass_render_options_to_js_options( array $js_options, $table_id, array $render_options ) {
		$js_options['datatables_advanced_loading'] = $render_options['datatables_advanced_loading'];
		return $js_options;
	}

	/**
	 * Evaluates JS parameters and converts them to DataTables parameters.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $parameters DataTables parameters.
	 * @param string $table_id   Table ID.
	 * @param string $html_id    HTML ID of the table.
	 * @param array  $js_options JS options for DataTables.
	 * @return array Extended DataTables parameters.
	 */
	public static function set_datatables_parameters( array $parameters, $table_id, $html_id, array $js_options ) {
		if ( ! empty( $js_options['datatables_advanced_loading'] ) ) {
			$parameters['data'] = "\"data\":window.tp_DT_data['{$html_id}']";
			$parameters['deferRender'] = '"deferRender":true';
		}

		return $parameters;
	}

	/**
	 * Attaches the full render data to a shortened copy of the render data.
	 *
	 * The shortened version will be rendered as HTML while the full data will be printed as JSON.
	 *
	 * @since 2.0.0
	 *
	 * @param array $table          The table.
	 * @param array $orig_table     The unmodified table.
	 * @param array $render_options Render options.
	 * @return array The modified table.
	 */
	public static function shorten_rendered_table( array $table, array $orig_table, array $render_options ) {
		if ( empty( $render_options['datatables_advanced_loading'] ) ) {
			return $table;
		}

		if ( empty( $render_options['datatables_advanced_loading_html_rows'] ) ) {
			$render_options['datatables_advanced_loading_html_rows'] = 10;
		}

		// Store a copy of the full data, which will be printed as JS.
		$table['full_render_data'] = $table['data'];

		// Cut out a limited number of body rows for HTML rendering.
		$length = max( 1, absint( $render_options['datatables_advanced_loading_html_rows'] ) ); // Require at least one tbody row.
		if ( $render_options['table_head'] ) {
			++$length;
		}
		$table['data'] = array_slice( $table['data'], 0, $length );
		$last_row_idx = count( $table['full_render_data'] ) - 1;
		if ( $render_options['table_foot'] && $length <= $last_row_idx ) {
			$table['data'][] = $table['full_render_data'][ $last_row_idx ];
		}

		return $table;
	}

	/**
	 * Appends a JSON array with the full table render data to the shortened table HTML output.
	 *
	 * @since 2.0.0
	 *
	 * @param string $output         Table output.
	 * @param array  $table          Table.
	 * @param array  $render_options Render options.
	 * @return string Modified table output.
	 */
	public static function add_data_as_json_array( $output, array $table, array $render_options ) {
		if ( empty( $render_options['datatables_advanced_loading'] ) ) {
			return $output;
		}

		$render_data = $table['full_render_data'];

		// Remove first and last rows, if table head and/or footer row is shown, as those will not be replaced by DataTables.
		if ( $render_options['table_head'] ) {
			array_shift( $render_data );
		}
		if ( $render_options['table_foot'] ) {
			array_pop( $render_data );
		}

		// Print the data inside a `JSON.parse()` call in JS for speed gains, with necessary escaping of `</script>`, `'`, and `\`.
		$json_data = wp_json_encode( $render_data, TABLEPRESS_JSON_OPTIONS );
		$json_data = str_replace( array( '</script>', '\\', "'" ), array( '<\/script>', '\\\\', "\'" ), $json_data );

		$js_output = <<<JS
<script>
window.tp_DT_data=window.tp_DT_data||{};
window.tp_DT_data['{$render_options['html_id']}']=JSON.parse('{$json_data}');
</script>
JS;
		$js_output = apply_filters( 'tablepress_datatables_advanced_loading_output', $js_output, $json_data, $render_data, $table, $render_options );

		return $output . $js_output;
	}

} // class TablePress_Module_DataTables_Advanced_Loading
