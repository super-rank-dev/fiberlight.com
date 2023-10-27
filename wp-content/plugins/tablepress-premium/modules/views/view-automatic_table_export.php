<?php
/**
 * Automatic Table Export View.
 *
 * @package TablePress
 * @subpackage Views
 * @author Tobias Bäthge
 * @since 2.0.0
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Automatic Table Export View class.
 *
 * @package TablePress
 * @subpackage Views
 * @author Tobias Bäthge
 * @since 2.0.0
 */
class TablePress_Automatic_Table_Export_View extends TablePress_Export_View {

	/**
	 * Sets up the view with data and do things that are specific for this view.
	 *
	 * @since 2.0.0
	 *
	 * @param string $action Action for this view.
	 * @param array  $data   Data for this view.
	 */
	public function setup( $action, array $data ) {
		parent::setup( $action, $data );

		TablePress_Modules_Helper::enqueue_style( 'automatic-table-export' );
		TablePress_Modules_Helper::enqueue_script( 'automatic-table-export' );

		$this->add_meta_box( 'tables-auto-export', 'Automatic Export of Tables', array( $this, 'postbox_auto_export' ), 'additional' );
	}

	/**
	 * Prints the form for the Automatic Table Export configuration.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data Data for this screen.
	 * @param array $box  Information about the meta box.
	 */
	public function postbox_auto_export( $data, $box ) {
		?>
		<p><?php _e( 'To automatically export a table to a file on your server after it has been edited, configure the desired path and export formats below.', 'tablepress' ); ?></p>
		<table class="tablepress-postbox-table fixed">
			<tr class="bottom-border">
				<th class="column-1" scope="row"></th>
				<td class="column-2">
					<label>
						<input type="checkbox" id="auto-export-active"<?php checked( $data['auto_export_active'] ); ?> /> <?php _e( 'Activate Automatic Table Export', 'tablepress' ); ?>
					</label>
				</td>
			</tr>
			<tr class="top-border">
				<th class="column-1" scope="row"><label for="auto-export-path"><?php _e( 'Server Path', 'tablepress' ); ?>:</label></th>
				<td class="column-2">
					<input type="text" id="auto-export-path" class="large-text code" value="<?php echo esc_attr( $data['auto_export_path'] ); ?>" />
				</td>
			</tr>
			<tr id="auto-export-formats" class="top-border">
				<th class="column-1 top-align" scope="row"><?php _e( 'Export Format', 'tablepress' ); ?>:</th>
				<td class="column-2">
					<?php
					foreach ( $data['export_formats'] as $format => $name ) {
						$checked = checked( in_array( $format, $data['auto_export_formats'], true ), true, false );
						echo "<label><input type=\"checkbox\" id=\"auto-export-format-{$format}\" {$checked} value=\"{$format}\" /> {$name}</label><br />";
					}
					?>
				</td>
			</tr>
			<tr class="top-border bottom-border">
				<th class="column-1" scope="row"><label for="auto-export-csv-delimiter"><?php _e( 'CSV Delimiter', 'tablepress' ); ?>:</label></th>
				<td class="column-2">
					<select id="auto-export-csv-delimiter">
					<?php
					foreach ( $data['csv_delimiters'] as $delimiter => $name ) {
						$selected = selected( $delimiter, $data['auto_export_csv_delimiter'], false );
						echo "<option{$selected} value=\"{$delimiter}\">{$name}</option>";
					}
					?>
					</select>
					<span id="auto-export-csv-delimiter-description" class="description hide-if-js"><?php _e( '(Only needed for CSV export.)', 'tablepress' ); ?></span>
				</td>
			</tr>
			<tr class="top-border">
				<td class="column-1"></td>
				<td class="column-2">
					<input type="button" id="tablepress_auto_export_save_changes_button" class="button button-secondary button-large button-save-changes" value="<?php esc_attr_e( 'Save Automatic Export configuration', 'tablepress' ); ?>" />
				</td>
			</tr>
		</table>
		<?php
	}

} // class TablePress_Automatic_Table_Export_View
