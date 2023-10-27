<?php
/**
 * TablePress DataTables FixedHeader and FixedColumns.
 *
 * @package TablePress
 * @subpackage DataTables
 * @author Tobias Bäthge
 * @since 2.0.0
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Class that contains the logic for the DataTables FixedHeader and FixedColumns feature for TablePress.
 *
 * @author Tobias Bäthge
 * @since 2.0.0
 */
class TablePress_Module_DataTables_FixedHeader_FixedColumns {
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
		add_filter( 'tablepress_table_render_options', array( __CLASS__, 'process_table_render_options' ), 10, 2 );
		add_filter( 'tablepress_table_js_options', array( __CLASS__, 'pass_render_options_to_js_options' ), 10, 3 );
		add_filter( 'tablepress_datatables_parameters', array( __CLASS__, 'set_datatables_parameters' ), 10, 4 );
	}

	/**
	 * Adds options related to DataTables FixedHeader and FixedColumns to the table template.
	 *
	 * @since 2.0.0
	 *
	 * @param array $table Current table template.
	 * @return array Extended table template.
	 */
	public static function add_option_to_table_template( array $table ) {
		$table['options']['datatables_fixedheader'] = '';
		$table['options']['datatables_fixedheader_offsettop'] = 0;
		$table['options']['datatables_fixedcolumns'] = '';
		$table['options']['datatables_fixedcolumns_left_columns'] = 0;
		$table['options']['datatables_fixedcolumns_right_columns'] = 0;
		return $table;
	}

	/**
	 * Registers "Edit" screen elements for the "DataTables FixedHeader and FixedColumns" feature.
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
			add_meta_box( 'tablepress_edit-datatables-fixedheader-fixedcolumns', __( 'Fixed Rows and Fixed Columns', 'tablepress' ), array( __CLASS__, 'postbox_datatables_fixedheader_fixedcolumns' ), null, 'normal', 'low' );

			TablePress_Modules_Helper::enqueue_style( 'modules-common' );
			TablePress_Modules_Helper::enqueue_style( 'datatables-fixedheader-fixedcolumns', array( 'tablepress-modules-common' ) );
			TablePress_Modules_Helper::enqueue_script( 'datatables-fixedheader-fixedcolumns' );

			add_filter( 'tablepress_admin_page_script_dependencies', array( __CLASS__, 'add_script_dependencies' ), 10, 2 );
		}
		return $data;
	}

	/**
	 * Adds DataTables FixedHeader and FixedColumns script as a dependency for the "Edit" script, so that hooks are added before they are executed.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $dependencies List of the dependencies that the $name script relies on.
	 * @param string $name         Name of the JS script, without extension.
	 * @return array Modified list of the dependencies that the $name script relies on.
	 */
	public static function add_script_dependencies( array $dependencies, $name ) {
		if ( 'edit' === $name ) {
			$dependencies[] = 'tablepress-datatables-fixedheader-fixedcolumns';
		}
		return $dependencies;
	}

	/**
	 * Prints the content of the "DataTables Button" post meta box.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data Data for this screen.
	 * @param array $box  Information about the meta box.
	 */
	public static function postbox_datatables_fixedheader_fixedcolumns( array $data, array $box ) {
		$help_box_content = '';
		self::print_help_box_markup( $help_box_content );
		?>
		<p id="notice-datatables-fixedheader-fixedcolumns-requirements"><em><?php printf( __( 'This feature is only available when the “%1$s” and “%2$s” checkboxes in the “%3$s” and “%4$s” sections are checked.', 'tablepress' ), __( 'Table Head Row', 'tablepress' ), __( 'Enable Visitor Features', 'tablepress' ), __( 'Table Options', 'tablepress' ), __( 'Table Features for Site Visitors', 'tablepress' ) ); ?></em></p>
		<table class="tablepress-postbox-table fixed">
			<tr>
				<th class="column-1 top-align" scope="row"><?php _e( 'Fixed Rows', 'tablepress' ); ?>:</th>
				<td class="column-2">
					<div>
						<p class="description"><?php _e( 'Choose the rows that shall be fixed at the screen edges when scrolling:', 'tablepress' ); ?></p>
					</div>
					<div id="tablepress-datatables_fixedheader-wrapper" class="input-field-box-wrapper" data-option-name="datatables_fixedheader">
						<div class="input-field-box">
							<input type="checkbox" value="top" id="option-datatables_fixedheader-top" class="control-input" />
							<label for="option-datatables_fixedheader-top">
								<span class="box-title"><?php _e( 'Head Row', 'tablepress' ); ?></span>
							</label>
						</div>
						<div class="input-field-box">
							<input type="checkbox" value="bottom" id="option-datatables_fixedheader-bottom" class="control-input" />
							<label for="option-datatables_fixedheader-bottom">
								<span class="box-title"><?php _e( 'Foot Row', 'tablepress' ); ?></span>
							</label>
						</div>
					</div>
					<details id="tablepress-datatables_fixedheader-advanced-settings">
						<summary><?php _e( 'Advanced settings', 'tablepress' ); ?></summary>
						<div>
							<label for="option-datatables_fixedheader_offsettop"><?php printf( __( 'Fix the Head Row at %s pixels from the top edge.', 'tablepress' ), '<input type="number" name="datatables_fixedheader_offsettop" id="option-datatables_fixedheader_offsettop" class="small-text" min="0" max="1000" required />' ); ?></label>
						</div>
					</details>
				</td>
			</tr>
			<tr>
				<th class="column-1 top-align" scope="row"><?php _e( 'Fixed Columns', 'tablepress' ); ?>:</th>
				<td class="column-2">
					<div>
						<p class="description"><?php _e( 'Choose the columns that shall be fixed at the screen edges when scrolling:', 'tablepress' ); ?></p>
					</div>
					<div id="tablepress-datatables_fixedcolumns-wrapper" class="input-field-box-wrapper" data-option-name="datatables_fixedcolumns">
						<div class="input-field-box">
							<input type="checkbox" value="left" id="option-datatables_fixedcolumns-left" class="control-input" />
							<label for="option-datatables_fixedcolumns-left">
								<span class="box-title"><?php _e( 'First column', 'tablepress' ); ?></span>
							</label>
						</div>
						<div class="input-field-box">
							<input type="checkbox" value="right" id="option-datatables_fixedcolumns-right" class="control-input" />
							<label for="option-datatables_fixedcolumns-right">
								<span class="box-title"><?php _e( 'Last column', 'tablepress' ); ?></span>
							</label>
						</div>
					</div>
					<details id="tablepress-datatables_fixedcolumns-advanced-settings">
						<summary><?php _e( 'Advanced settings', 'tablepress' ); ?></summary>
						<div>
							<p><label for="option-datatables_fixedcolumns_left_columns"><?php printf( __( 'Fix the first %s columns from the left.', 'tablepress' ), '<input type="number" name="datatables_fixedcolumns_left_columns" id="option-datatables_fixedcolumns_left_columns" class="small-text" min="0" max="100" required />' ); ?></label></p>
							<p><label for="option-datatables_fixedcolumns_right_columns"><?php printf( __( 'Fix the last %s columns from the right.', 'tablepress' ), '<input type="number" name="datatables_fixedcolumns_right_columns" id="option-datatables_fixedcolumns_right_columns" class="small-text" min="0" max="100" required />' ); ?></label></p>
						</div>
					</details>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Adds parameters for the DataTables FixedHeader and FixedColumns feature to the [table /] Shortcode.
	 *
	 * By using null as the default value, the table options's value will be used (if set).
	 *
	 * @since 2.0.0
	 *
	 * @param array $default_atts Default attributes for the TablePress [table /] Shortcode.
	 * @return array Extended attributes for the Shortcode.
	 */
	public static function add_shortcode_parameters( array $default_atts ) {
		$default_atts['datatables_fixedheader'] = null;
		$default_atts['datatables_fixedheader_offsettop'] = null;
		$default_atts['datatables_fixedcolumns'] = null;
		$default_atts['datatables_fixedcolumns_left_columns'] = null;
		$default_atts['datatables_fixedcolumns_right_columns'] = null;
		return $default_atts;
	}


	/**
	 * Evaluates the responsiveness parameter and turns it off for certain values if the FixedColumns feature is used.
	 *
	 * @since 2.0.0
	 *
	 * @param array $render_options Render Options.
	 * @param array $table          Table.
	 * @return array Modified Render Options.
	 */
	public static function process_table_render_options( array $render_options, array $table ) {
		$render_options['datatables_fixedcolumns'] = strtolower( $render_options['datatables_fixedcolumns'] );
		$render_options['datatables_fixedcolumns_left_columns'] = absint( $render_options['datatables_fixedcolumns_left_columns'] );
		$render_options['datatables_fixedcolumns_right_columns'] = absint( $render_options['datatables_fixedcolumns_right_columns'] );

		if ( '' !== $render_options['datatables_fixedcolumns'] || $render_options['datatables_fixedcolumns_left_columns'] > 0 || $render_options['datatables_fixedcolumns_right_columns'] > 0 ) {
			// Potentially unset the responsiveness mode if FixedColumns is used with this table.
			if ( isset( $render_options['responsive'] ) && in_array( $render_options['responsive'], array( 'flip', 'scroll' ), true ) ) {
				$render_options['responsive'] = '';
			}
		}

		return $render_options;
	}

	/**
	 * Passes the DataTables FixedHeader and FixedColumns configuration from Shortcode parameters to JavaScript arguments.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $js_options     Current JS options.
	 * @param string $table_id       Table ID.
	 * @param array  $render_options Render Options.
	 * @return array Modified JS options.
	 */
	public static function pass_render_options_to_js_options( array $js_options, $table_id, array $render_options ) {
		$js_options['datatables_fixedheader'] = strtolower( $render_options['datatables_fixedheader'] );
		$js_options['datatables_fixedheader_offsettop'] = absint( $render_options['datatables_fixedheader_offsettop'] );

		// Change parameters and register files if the header or footer are fixed.
		if ( '' !== $js_options['datatables_fixedheader'] ) {
			// Convert the "both" shortcut to "top" and "bottom".
			$js_options['datatables_fixedheader'] = str_replace( 'both', 'top,bottom', $js_options['datatables_fixedheader'] );

			// Register the JS files.
			$js_url = plugins_url( 'modules/js/datatables.fixedheader.min.js', TABLEPRESS__FILE__ );
			wp_enqueue_script( 'tablepress-datatables-fixedheader', $js_url, array( 'tablepress-datatables' ), TablePress::version, true );

			// Add the common filter that adds JS for all calls on the page.
			if ( ! has_filter( 'tablepress_all_datatables_commands', array( __CLASS__, 'add_global_datatables_fixedheader_css' ) ) ) {
				add_filter( 'tablepress_all_datatables_commands', array( __CLASS__, 'add_global_datatables_fixedheader_css' ) );
			}
		}

		// Sanitization of these options happens in `process_table_render_options()`.
		$js_options['datatables_fixedcolumns'] = $render_options['datatables_fixedcolumns'];
		$js_options['datatables_fixedcolumns_left_columns'] = $render_options['datatables_fixedcolumns_left_columns'];
		$js_options['datatables_fixedcolumns_right_columns'] = $render_options['datatables_fixedcolumns_right_columns'];

		/*
		 * Convert shortcut parameter value to detailed parameter values.
		 * The conversion is necessary for BC reasons, as previous versions supported a value like "right,left".
		 */
		if ( '' !== $js_options['datatables_fixedcolumns'] && 0 === $js_options['datatables_fixedcolumns_left_columns'] && 0 === $js_options['datatables_fixedcolumns_right_columns'] ) {
			// Convert the "both" shortcude to "left" and "right".
			$js_options['datatables_fixedcolumns'] = str_replace( 'both', 'left,right', $js_options['datatables_fixedcolumns'] );
			$fixedcolumns = explode( ',', $js_options['datatables_fixedcolumns'] );
			$fixedcolumns = array_map( 'trim', $fixedcolumns );
			foreach ( $fixedcolumns as $column ) {
				if ( 'left' === $column ) {
					$js_options['datatables_fixedcolumns_left_columns'] = 1;
				} elseif ( 'right' === $column ) {
					$js_options['datatables_fixedcolumns_right_columns'] = 1;
				}
			}
		}

		// Change parameters and register files if at least one column is fixed.
		if ( $js_options['datatables_fixedcolumns_left_columns'] > 0 || $js_options['datatables_fixedcolumns_right_columns'] > 0 ) {
			// Horizontal Scrolling is mandatatory for the FixedColumns functionality.
			$js_options['datatables_scrollx'] = true;

			// Register the JS files.
			$js_url = plugins_url( 'modules/js/datatables.fixedcolumns.min.js', TABLEPRESS__FILE__ );
			wp_enqueue_script( 'tablepress-datatables-fixedcolumns', $js_url, array( 'tablepress-datatables' ), TablePress::version, true );

			// Add the common filter that adds JS for all calls on the page.
			if ( ! has_filter( 'tablepress_all_datatables_commands', array( __CLASS__, 'add_global_datatables_fixedcolumns_css' ) ) ) {
				add_filter( 'tablepress_all_datatables_commands', array( __CLASS__, 'add_global_datatables_fixedcolumns_css' ) );
			}
		}

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
		if ( '' !== $js_options['datatables_fixedheader'] ) {
			/*
			 * Construct the DataTables FixedHeader config parameter.
			 * We use strpos() instead of string comparison for BC reasons, as previous versions supported a value like "top,left,right,bottom".
			 */
			$parameters['fixedHeader'] = array();
			// The header only needs to be set if changing the default of true (i.e. if it's not in the Shortcode parameter).
			if ( false === strpos( $js_options['datatables_fixedheader'], 'top' ) ) {
				$parameters['fixedHeader'][] = '"header":false';
			}
			// The footer only needs to be set if changing the default of false (i.e. if it's in the Shortcode parameter).
			if ( false !== strpos( $js_options['datatables_fixedheader'], 'bottom' ) ) {
				$parameters['fixedHeader'][] = '"footer":true';
			}
			// Possibly add an offset to the header.
			if ( 0 !== $js_options['datatables_fixedheader_offsettop'] ) {
				$parameters['fixedHeader'][] = '"headerOffset":' . absint( $js_options['datatables_fixedheader_offsettop'] );
			}
			$parameters['fixedHeader'] = '"fixedHeader":{' . implode( ',', $parameters['fixedHeader'] ) . '}';
		}

		if ( 0 !== $js_options['datatables_fixedcolumns_left_columns'] || 0 !== $js_options['datatables_fixedcolumns_right_columns'] ) {
			// Construct the DataTables FixedColumns config parameter.
			$parameters['fixedColumns'] = array();
			// The number of fixed columns on the left only needs to be set if changing the default of 1.
			if ( 1 !== $js_options['datatables_fixedcolumns_left_columns'] ) {
				$parameters['fixedColumns'][] = '"leftColumns":' . absint( $js_options['datatables_fixedcolumns_left_columns'] );
			}
			// The number of fixed columns on the right only needs to be set if changing the default of 0.
			if ( 0 !== $js_options['datatables_fixedcolumns_right_columns'] ) {
				$parameters['fixedColumns'][] = '"rightColumns":' . absint( $js_options['datatables_fixedcolumns_right_columns'] );
			}
			$parameters['fixedColumns'] = '"fixedColumns":{' . implode( ',', $parameters['fixedColumns'] ) . '}';
		}

		return $parameters;
	}

	/**
	 * Adds JS code that adds the necessary CSS for the FixedHeader module, instead of loading that CSS from a file on all pages.
	 *
	 * @since 2.0.0
	 *
	 * @param string $commands The JS commands for the DataTables JS library.
	 * @return string Modified JS commands for the DataTables JS library.
	 */
	public static function add_global_datatables_fixedheader_css( $commands ) {
		$commands = 'document.head.insertAdjacentHTML("beforeend","<style>.tablepress.fixedHeader-floating{background-color:#fff;margin:0}.tablepress.fixedHeader-floating.no-footer{border-bottom-width:0}.tablepress.fixedHeader-locked{position:absolute !important;background-color:#fff}@media print{.tablepress.fixedHeader-floating{display:none}}.dtfh-floatingparent.dtfh-floatingparenthead{  z-index:999!important}</style>");' . "\n{$commands}";
		return $commands;
	}

	/**
	 * Adds JS code that adds the necessary CSS for the FixedColumns module, instead of loading that CSS from a file on all pages.
	 *
	 * @since 2.0.0
	 *
	 * @param string $commands The JS commands for the DataTables JS library.
	 * @return string Modified JS commands for the DataTables JS library.
	 */
	public static function add_global_datatables_fixedcolumns_css( $commands ) {
		$commands = 'document.head.insertAdjacentHTML("beforeend","<style>.tablepress.dataTable thead tr>.dtfc-fixed-left,.tablepress.dataTable thead tr>.dtfc-fixed-right,.tablepress.dataTable tfoot tr>.dtfc-fixed-left,.tablepress.dataTable tfoot tr>.dtfc-fixed-right{top:0;bottom:0;z-index:1}.tablepress.dataTable tbody tr:not(.odd,.even)>.dtfc-fixed-left,.tablepress.dataTable tbody tr:not(.odd,.even)>.dtfc-fixed-right{z-index:1;background-color:#fff}div.dtfc-left-top-blocker,div.dtfc-right-top-blocker{background-color:#fff}</style>");' . "\n{$commands}";
		return $commands;
	}

} // class TablePress_Module_DataTables_FixedHeader_FixedColumns
