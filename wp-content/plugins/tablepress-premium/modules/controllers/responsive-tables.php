<?php
/**
 * TablePress Responsive Tables.
 *
 * @package TablePress
 * @subpackage Responsive Tables
 * @author Tobias Bäthge
 * @since 2.0.0
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Class that contains the logic for the Responsive Tables feature for TablePress.
 *
 * @author Tobias Bäthge
 * @since 2.0.0
 */
class TablePress_Module_Responsive_Tables {
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
		add_filter( 'tablepress_table_output', array( __CLASS__, 'modify_table_output' ), 10, 3 );

		if ( ! is_admin() ) {
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_css_files' ) );
		}
	}

	/**
	 * Adds options related to Responsive Tables to the table template.
	 *
	 * @since 2.0.0
	 *
	 * @param array $table Current table template.
	 * @return array Extended table template.
	 */
	public static function add_option_to_table_template( array $table ) {
		$table['options']['responsive'] = '';
		$table['options']['responsive_breakpoint'] = 'phone'; // 'phone', 'tablet', 'desktop', 'all'
		return $table;
	}

	/**
	 * Registers "Edit" screen elements for the "Responsive Tables" feature.
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
			add_meta_box( 'tablepress_edit-responsive-tables', __( 'Behavior on different screen sizes (Responsiveness)', 'tablepress' ), array( __CLASS__, 'postbox_responsive_tables' ), null, 'normal', 'low' );

			TablePress_Modules_Helper::enqueue_style( 'modules-common' );
			TablePress_Modules_Helper::enqueue_script( 'responsive-tables' );

			add_filter( 'tablepress_admin_page_script_dependencies', array( __CLASS__, 'add_script_dependencies' ), 10, 2 );
		}
		return $data;
	}

	/**
	 * Adds Responsive Tables script as a dependency for the "Edit" script, so that hooks are added before they are executed.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $dependencies List of the dependencies that the $name script relies on.
	 * @param string $name         Name of the JS script, without extension.
	 * @return array Modified list of the dependencies that the $name script relies on.
	 */
	public static function add_script_dependencies( array $dependencies, $name ) {
		if ( 'edit' === $name ) {
			$dependencies[] = 'tablepress-responsive-tables';
		}
		return $dependencies;
	}

	/**
	 * Prints the content of the "Responsive Tables" post meta box.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data Data for this screen.
	 * @param array $box  Information about the meta box.
	 */
	public static function postbox_responsive_tables( array $data, array $box ) {
		$help_box_content = '<p>' . __( 'Tables on websites can not always adjust to the available space on the screen automatically. The reason is that their content requires a certain minimum space, and that’s what defines the minimum width of the table. If that minimum table width is bigger than the width of the available content area, the table will not fit. Unfortunately, this can lead to ugly behavior on small screens, like on mobile phones and tablets, where some parts of a table might then be cut-off on the right side.', 'tablepress' ) . '</p>';
		$help_box_content .= '<p>' . __( 'The Responsive Tables module offers four approaches to get around this challenge:', 'tablepress' ) . '</p>';
		$help_box_content .= '<ul style="list-style:disc;margin-left:12px;">';
		$help_box_content .= '<li>' . __( '<em>Scroll</em>: This mode will make a table that is too wide to be fully displayed horizontally scrollable. With that, the user can still reach all table data. This is usually a good approach for tables with images, if they don’t automatically resize.', 'tablepress' ) . '</li>';
		$help_box_content .= '<li>' . __( '<em>Collapse</em>: The Collapse approach can add a hide/expand effect to a table. It will hide the data from those columns that would otherwise be cut-off and instead adds that data to a collapsable row that is inserted below each entry. That row can be shown and hidden with a “+” and “-” button. This mode is especially useful in tables that show additional information for some “main” columns, e.g. in a directory table', 'tablepress' ) . '</li>';
		$help_box_content .= '<li>' . __( '<em>Stack</em>: The Stack mode will show the cells of a row on top of each other, instead of next to each other. This makes the table more narrow, as it will appear to have only two columns: One for the header cells and one for the original row’s data cells.', 'tablepress' ) . '</li>';
		$help_box_content .= '<li>' . __( '<em>Flip</em>: This mode changes the layout of the table, by flipping it to the side (rows appear as columns and vice versa), and then makes the table horizontally scrollable. This mode is a good solution for plain data tables, but will usually not work nicely in tables with images, cells of different height, or with combined/merged cells.', 'tablepress' ) . '</li>';
		$help_box_content .= '</ul>';
		$help_box_content .= '<p>' . __( 'For all modes, filtering and pagination will continue to work. Sorting will be possible for all modes except the Stack mode.', 'tablepress' ) . '</p>';
		self::print_help_box_markup( $help_box_content, '620', '820' );
		?>
		<table class="tablepress-postbox-table fixed">
			<tr>
				<th class="column-1 top-align" scope="row"><?php _e( 'Mode', 'tablepress' ); ?>:</th>
				<td class="column-2">
					<div>
						<p class="description"><?php _e( 'Choose the desired behavior of the table on small screens:', 'tablepress' ); ?></p>
						<p id="notice-option-responsive-collapse-requirements"><em><?php printf( __( 'The “Collapse” mode is only available when the “%1$s” and the “%2$s” checkboxes in the “%3$s” and “%4$s” sections are checked.', 'tablepress' ), __( 'Table Head Row', 'tablepress' ), __( 'Enable Visitor Features', 'tablepress' ), __( 'Table Options', 'tablepress' ), __( 'Table Features for Site Visitors', 'tablepress' ) ); ?></em></p>
					</div>
					<div class="input-field-box">
						<input type="radio" name="responsive" value="" id="option-responsive-" class="control-input" />
						<label for="option-responsive-">
							<span class="box-title"><?php _e( 'None', 'tablepress' ); ?></span>
							<p class="description"><?php _e( 'The table won’t show special behavior. ', 'tablepress' ); ?></p>
						</label>
					</div><div class="input-field-box">
						<input type="radio" name="responsive" value="scroll" id="option-responsive-scroll" class="control-input" />
						<label for="option-responsive-scroll">
							<span class="box-title"><?php _e( 'Scroll', 'tablepress' ); ?></span>
							<p class="description"><?php _e( 'The table will scroll horizontally.', 'tablepress' ); ?></p>
						</label>
					</div><div class="input-field-box">
						<input type="radio" name="responsive" value="collapse" id="option-responsive-collapse" class="control-input" />
						<label for="option-responsive-collapse">
							<span class="box-title"><?php _e( 'Collapse', 'tablepress' ); ?></span>
							<p class="description"><?php _e( 'The table will have collapsable rows.', 'tablepress' ); ?></p>
						</label>
					</div><div class="input-field-box">
						<input type="radio" name="responsive" value="stack" id="option-responsive-stack" class="control-input" />
						<label for="option-responsive-stack">
							<span class="box-title"><?php _e( 'Stack', 'tablepress' ); ?></span>
							<p class="description"><?php _e( 'The table cells in a row will be stacked.', 'tablepress' ); ?></p>
						</label>
					</div><div class="input-field-box">
						<input type="radio" name="responsive" value="flip" id="option-responsive-flip" class="control-input" />
						<label for="option-responsive-flip">
							<span class="box-title"><?php _e( 'Flip', 'tablepress' ); ?></span>
							<p class="description"><?php _e( 'The table will flip to the side.', 'tablepress' ); ?></p>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<th class="column-1 top-align" scope="row"><?php _e( 'Breakpoint', 'tablepress' ); ?>:</th>
				<td class="column-2">
					<label for="option-responsive_breakpoint">
						<p class="description"><?php _e( 'Choose the largest screen size for which the chosen mode should be used:', 'tablepress' ); ?></p>
						<select id="option-responsive_breakpoint" name="responsive_breakpoint">
							<option value="phone"><?php _e( 'Phone', 'tablepress' ); ?></option>
							<option value="tablet"><?php _e( 'Tablet', 'tablepress' ); ?></option>
							<option value="desktop"><?php _e( 'Desktop', 'tablepress' ); ?></option>
							<option value="all"><?php _e( 'All', 'tablepress' ); ?></option>
						</select>
					</label>
					<p id="description-option-responsive_breakpoint" class="description"><?php _e( '(Only used by Flip and Stack modes.)', 'tablepress' ); ?></p>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Adds parameters for the Responsive Tables feature to the [table /] Shortcode.
	 *
	 * By using null as the default value, the table options's value will be used (if set).
	 *
	 * @since 2.0.0
	 *
	 * @param array $default_atts Default Shortcode attributes.
	 * @return array Extended Shortcode attributes.
	 */
	public static function add_shortcode_parameters( array $default_atts ) {
		$default_atts['responsive'] = null;
		$default_atts['responsive_breakpoint'] = null;
		return $default_atts;
	}

	/**
	 * Enqueues CSS files for the Responsive Tables module.
	 *
	 * @since 2.0.0
	 */
	public static function enqueue_css_files() {
		/** This filter is documented in modules/controllers/datatables-alphabetsearch.php */
		if ( ! apply_filters( 'tablepress_module_enqueue_css_files', true, self::$module['slug'] ) ) {
			return;
		}

		/**
		 * Filters whether the frontend CSS files for the Responsive Tables modules should be enqueued.
		 *
		 * @since Reponsive Tables Extension 1.4
		 * @deprecated 2.0.0 Use the {@see 'tablepress_module_enqueue_css_files'} filter instead.
		 *
		 * @param bool $enqueue Whether the CSS files for the module should be enqueued.
		 */
		if ( ! apply_filters( 'tablepress_responsive_tables_enqueue_css_file', true ) ) {
			return;
		}

		$css_url = plugins_url( 'modules/css/build/responsive-tables.css', TABLEPRESS__FILE__ );
		wp_enqueue_style( 'tablepress-responsive-tables', $css_url, array( 'tablepress-default' ), TablePress::version );
	}

	/**
	 * Evaluates the responsiveness mode and sets required parameters.
	 *
	 * @since 2.0.0
	 *
	 * @param array $render_options Render Options.
	 * @param array $table          Table.
	 * @return array Modified Render Options.
	 */
	public static function process_table_render_options( array $render_options, array $table ) {
		$render_options['responsive'] = strtolower( $render_options['responsive'] );
		$render_options['responsive_breakpoint'] = strtolower( $render_options['responsive_breakpoint'] );

		// Convert legacy parameter values to modern Shortcode parameters.
		if ( in_array( $render_options['responsive'], array( 'phone', 'tablet', 'desktop', 'all' ), true ) ) {
			$render_options['responsive_breakpoint'] = $render_options['responsive'];
			$render_options['responsive'] = 'flip';
		}

		// Add "Extra CSS class".
		if ( '' !== $render_options['extra_css_classes'] ) {
			$render_options['extra_css_classes'] .= ' ';
		}
		$render_options['extra_css_classes'] .= 'tablepress-responsive';

		// Scroll mode.
		if ( 'scroll' === $render_options['responsive'] ) {
			// Horizontal Scrolling from DataTables has to be turned off.
			$render_options['datatables_scrollx'] = false;
		}

		// Flip mode.
		if ( 'flip' === $render_options['responsive'] && in_array( $render_options['responsive_breakpoint'], array( 'phone', 'tablet', 'desktop', 'all' ), true ) ) {
			// Horizontal Scrolling from DataTables has to be turned off.
			$render_options['datatables_scrollx'] = false;
			// Add "Extra CSS class".
			$render_options['extra_css_classes'] .= " tablepress-responsive-{$render_options['responsive_breakpoint']}";
		}

		// Stack mode.
		if ( 'stack' === $render_options['responsive'] && in_array( $render_options['responsive_breakpoint'], array( 'phone', 'tablet', 'desktop', 'all' ), true ) ) {
			// Horizontal Scrolling from DataTables has to be turned off.
			$render_options['datatables_scrollx'] = false;
			// Add "Extra CSS class".
			$render_options['extra_css_classes'] .= " tablepress-responsive-stack-headers tablepress-responsive-stack-{$render_options['responsive_breakpoint']}";

			// Enqueue JS file for the stack mode.
			$js_url = plugins_url( 'modules/js/responsive-stack.min.js', TABLEPRESS__FILE__ );
			wp_enqueue_script( 'tablepress-responsive-stack', $js_url, array(), TablePress::version, true );
		}

		// DataTables Responsive Collapse/Row Details mode.
		if ( 'collapse' === $render_options['responsive'] ) {
			// DataTables and with that the Header row must be turned on for DataTables Responsive to be usable.
			$render_options['use_datatables'] = true;
			$render_options['table_head'] = true;
		}

		return $render_options;
	}

	/**
	 * Passes the Responsive Tables configuration from Shortcode parameters to JavaScript arguments.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $js_options     Current JS options.
	 * @param string $table_id       Table ID.
	 * @param array  $render_options Render Options.
	 * @return array Modified JS options.
	 */
	public static function pass_render_options_to_js_options( array $js_options, $table_id, array $render_options ) {
		$js_options['responsive'] = $render_options['responsive'];

		// Enqueue JS file for the collapse mode.
		if ( 'collapse' === $js_options['responsive'] ) {
			$js_url = plugins_url( 'modules/js/datatables.responsive.min.js', TABLEPRESS__FILE__ );
			wp_enqueue_script( 'tablepress-datatables-responsive', $js_url, array( 'tablepress-datatables' ), TablePress::version, true );
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
		// DataTables Responsive Collapse/Row Details mode.
		if ( 'collapse' === $js_options['responsive'] ) {
			$parameters['responsive'] = '"responsive":true';
		}

		return $parameters;
	}

	/**
	 * Possibly adds extra HTML code around the table element.
	 *
	 * @since 2.0.0
	 *
	 * @param string $output         Table HTML code.
	 * @param array  $table          The table.
	 * @param array  $render_options Render Options.
	 * @return string Modified/extended table HTML code.
	 */
	public static function modify_table_output( $output, array $table, array $render_options ) {
		// Horizontal Scrolling mode.
		if ( 'scroll' === $render_options['responsive'] ) {
			$output = "<div id=\"{$render_options['html_id']}-scroll-wrapper\" class=\"tablepress-scroll-wrapper\">\n{$output}\n</div>";
		}

		return $output;
	}

} // class TablePress_Module_Responsive_Tables
