<?php
/**
 * TablePress DataTables SearchHighlight.
 *
 * @package TablePress
 * @subpackage DataTables
 * @author Tobias Bäthge
 * @since 2.0.0
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Class that contains the logic for the DataTables SearchHighlight feature for TablePress.
 *
 * @author Tobias Bäthge
 * @since 2.0.0
 */
class TablePress_Module_DataTables_SearchHighlight {
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

		if ( ! is_admin() ) {
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_css_files' ) );
		}
	}

	/**
	 * Adds options related to DataTables SearchHighlight to the table template.
	 *
	 * @since 2.0.0
	 *
	 * @param array $table Current table template.
	 * @return array Extended table template.
	 */
	public static function add_option_to_table_template( array $table ) {
		$table['options']['datatables_searchhighlight'] = false;
		return $table;
	}

	/**
	 * Registers "Edit" screen elements for the "DataTables SearchHighlight" feature.
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
			add_meta_box( 'tablepress_edit-datatables-searchhighlight', __( 'Search Highlighting', 'tablepress' ), array( __CLASS__, 'postbox_datatables_searchhighlight' ), null, 'normal', 'low' );

			TablePress_Modules_Helper::enqueue_script( 'datatables-searchhighlight' );
			add_filter( 'tablepress_admin_page_script_dependencies', array( __CLASS__, 'add_script_dependencies' ), 10, 2 );
		}
		return $data;
	}

	/**
	 * Adds DataTables SearchHighlight script as a dependency for the "Edit" script, so that hooks are added before they are executed.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $dependencies List of the dependencies that the $name script relies on.
	 * @param string $name         Name of the JS script, without extension.
	 * @return array Modified list of the dependencies that the $name script relies on.
	 */
	public static function add_script_dependencies( array $dependencies, $name ) {
		if ( 'edit' === $name ) {
			$dependencies[] = 'tablepress-datatables-searchhighlight';
		}
		return $dependencies;
	}

	/**
	 * Prints the content of the "DataTables SearchHighlight" post meta box.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data Data for this screen.
	 * @param array $box  Information about the meta box.
	 */
	public static function postbox_datatables_searchhighlight( array $data, array $box ) {
		$help_box_content = '';
		self::print_help_box_markup( $help_box_content );
		?>
		<p id="notice-datatables-searchhighlight-requirements"><em><?php printf( __( 'This feature is only available when the “%1$s”, “%2$s”, and “%3$s” checkboxes in the “%4$s” and “%5$s” sections are checked.', 'tablepress' ), __( 'Table Head Row', 'tablepress' ), __( 'Enable Visitor Features', 'tablepress' ), __( 'Search/Filtering', 'tablepress' ), __( 'Table Options', 'tablepress' ), __( 'Table Features for Site Visitors', 'tablepress' ) ); ?></em></p>
		<p><label for="option-datatables_searchhighlight"><input type="checkbox" name="datatables_searchhighlight" id="option-datatables_searchhighlight" /> <?php _e( 'Highlight the current search term in the table.', 'tablepress' ); ?></label></p>
		<?php
	}

	/**
	 * Adds parameters for the DataTables SearchHighlight feature to the [table /] Shortcode.
	 *
	 * By using null as the default value, the table options's value will be used (if set).
	 *
	 * @since 2.0.0
	 *
	 * @param array $default_atts Default attributes for the TablePress [table /] Shortcode.
	 * @return array Extended attributes for the Shortcode.
	 */
	public static function add_shortcode_parameters( array $default_atts ) {
		$default_atts['datatables_searchhighlight'] = null;
		return $default_atts;
	}

	/**
	 * Passes the DataTables SearchHighlight configuration from Shortcode parameters to JavaScript arguments.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $js_options     Current JS options.
	 * @param string $table_id       Table ID.
	 * @param array  $render_options Render Options.
	 * @return array Modified JS options.
	 */
	public static function pass_render_options_to_js_options( array $js_options, $table_id, array $render_options ) {
		$js_options['datatables_searchhighlight'] = $render_options['datatables_searchhighlight'];

		if ( false !== $js_options['datatables_searchhighlight'] ) {
			$js_url = plugins_url( 'modules/js/datatables.searchhighlight.min.js', TABLEPRESS__FILE__ );
			wp_enqueue_script( 'tablepress-datatables-searchhighlight', $js_url, array( 'tablepress-datatables' ), TablePress::version, true );
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
		if ( ! empty( $js_options['datatables_searchhighlight'] ) ) {
			$parameters['searchHighlight'] = '"searchHighlight":true';
		}
		return $parameters;
	}

	/**
	 * Enqueues CSS files for the DataTables SearchHighlight module.
	 *
	 * @since 2.0.0
	 */
	public static function enqueue_css_files() {
		/** This filter is documented in modules/controllers/datatables-alphabetsearch.php */
		if ( ! apply_filters( 'tablepress_module_enqueue_css_files', true, self::$module['slug'] ) ) {
			return;
		}

		$css_url = plugins_url( 'modules/css/build/datatables.searchhighlight.css', TABLEPRESS__FILE__ );
		wp_enqueue_style( 'tablepress-datatables-searchhighlight', $css_url, array( 'tablepress-default' ), TablePress::version );
	}

} // class TablePress_Module_DataTables_SearchHighlight
