<?php
/**
 * TablePress DataTables Counter Column.
 *
 * @package TablePress
 * @subpackage DataTables
 * @author Tobias Bäthge
 * @since 2.0.0
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Class that contains the logic for the DataTables Counter Column feature for TablePress.
 *
 * @author Tobias Bäthge
 * @since 2.0.0
 */
class TablePress_Module_DataTables_Counter_Column {
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
		add_filter( 'tablepress_datatables_command', array( __CLASS__, 'extend_datatables_command' ), 10, 5 );
	}

	/**
	 * Adds options related to DataTables Counter Column to the table template.
	 *
	 * @since 2.0.0
	 *
	 * @param array $table Current table template.
	 * @return array Extended table template.
	 */
	public static function add_option_to_table_template( array $table ) {
		$table['options']['datatables_counter_column'] = false;
		return $table;
	}

	/**
	 * Registers "Edit" screen elements for the "DataTables Counter Column" feature.
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
			add_meta_box( 'tablepress_edit-datatables-counter-column', __( 'Counter Column', 'tablepress' ), array( __CLASS__, 'postbox_datatables_counter_column' ), null, 'normal', 'low' );

			TablePress_Modules_Helper::enqueue_script( 'datatables-counter-column' );
			add_filter( 'tablepress_admin_page_script_dependencies', array( __CLASS__, 'add_script_dependencies' ), 10, 2 );
		}
		return $data;
	}

	/**
	 * Adds DataTables Counter Column script as a dependency for the "Edit" script, so that hooks are added before they are executed.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $dependencies List of the dependencies that the $name script relies on.
	 * @param string $name         Name of the JS script, without extension.
	 * @return array Modified list of the dependencies that the $name script relies on.
	 */
	public static function add_script_dependencies( array $dependencies, $name ) {
		if ( 'edit' === $name ) {
			$dependencies[] = 'tablepress-datatables-counter-column';
		}
		return $dependencies;
	}

	/**
	 * Prints the content of the "DataTables Counter Column" post meta box.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data Data for this screen.
	 * @param array $box  Information about the meta box.
	 */
	public static function postbox_datatables_counter_column( array $data, array $box ) {
		$help_box_content = '';
		self::print_help_box_markup( $help_box_content );
		?>
		<p id="notice-datatables-counter-column-requirements"><em><?php printf( __( 'This feature is only available when the “%1$s”, “%2$s”, and “%3$s” or “%4$s” checkboxes in the “%5$s” and “%6$s” sections are checked.', 'tablepress' ), __( 'Table Head Row', 'tablepress' ), __( 'Enable Visitor Features', 'tablepress' ), __( 'Sorting', 'tablepress' ), __( 'Search/Filtering', 'tablepress' ), __( 'Table Options', 'tablepress' ), __( 'Table Features for Site Visitors', 'tablepress' ) ); ?></em></p>
		<p><label for="option-datatables_counter_column"><input type="checkbox" name="datatables_counter_column" id="option-datatables_counter_column" /> <?php _e( 'Make the first column a counter or index column.', 'tablepress' ); ?></label></p>
		<p class="description"><?php _e( 'If your table’s first column contains regular data, you should insert a new first column for this.', 'tablepress' ); ?></p>
		<?php
	}

	/**
	 * Adds parameters for the DataTables Counter Column feature to the [table /] Shortcode.
	 *
	 * By using null as the default value, the table options's value will be used (if set).
	 *
	 * @since 2.0.0
	 *
	 * @param array $default_atts Default attributes for the TablePress [table /] Shortcode.
	 * @return array Extended attributes for the Shortcode.
	 */
	public static function add_shortcode_parameters( array $default_atts ) {
		$default_atts['datatables_counter_column'] = null;
		return $default_atts;
	}

	/**
	 * Passes the DataTables Counter Column configuration from Shortcode parameters to JavaScript arguments.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $js_options     Current JS options.
	 * @param string $table_id       Table ID.
	 * @param array  $render_options Render Options.
	 * @return array Modified JS options.
	 */
	public static function pass_render_options_to_js_options( array $js_options, $table_id, array $render_options ) {
		$js_options['datatables_counter_column'] = $render_options['datatables_counter_column'];
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
		if ( $js_options['datatables_counter_column'] ) {
			$column_defs = '{ "searchable": false, "orderable": false, "targets": [ 0 ] }';
			// Prepend a columnDefs definition to the "columnDefs" value, if one is already set, otherwise use the default.
			if ( isset( $parameters['columnDefs'] ) ) {
				$parameters['columnDefs'] = str_replace( '"columnDefs": [', "\"columnDefs\": [ {$column_defs}, ", $parameters['columnDefs'] );
			} else {
				$parameters['columnDefs'] = "\"columnDefs\": [ {$column_defs} ]";
			}
		}
		return $parameters;
	}

	/**
	 * Modifies the full DataTables command.
	 *
	 * @since 2.0.0
	 *
	 * @param string $command    The JS command for the DataTables JS library.
	 * @param string $html_id    The ID of the table HTML element.
	 * @param string $parameters The parameters for the DataTables JS library.
	 * @param string $table_id   The current table ID.
	 * @param array  $js_options The options for the JS library.
	 * @return string Modified DataTables command.
	 */
	public static function extend_datatables_command( $command, $html_id, $parameters, $table_id, array $js_options ) {
		if ( ! $js_options['datatables_counter_column'] ) {
			return $command;
		}

		$name = str_replace( '-', '_', "DT-{$html_id}" );
		$command = <<<JS
const {$name} = {$command};
{$name}.on( 'order.dt search.dt', function () {
	let i = 1;
	{$name}.cells( null, 0, { search: 'applied', order: 'applied' } ).every( function ( cell ) {
		this.data( i++ );
	} );
} ).draw();
JS;
		return $command;
	}

} // class TablePress_Module_DataTables_Counter_Column
