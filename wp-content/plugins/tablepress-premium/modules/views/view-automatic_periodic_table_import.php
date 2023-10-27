<?php
/**
 * Automatic Periodic Table Import View.
 *
 * @package TablePress
 * @subpackage Views
 * @author Tobias Bäthge
 * @since 2.0.0
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Automatic Periodic Table Import View class.
 *
 * @package TablePress
 * @subpackage Views
 * @author Tobias Bäthge
 * @since 2.0.0
 */
class TablePress_Automatic_Periodic_Table_Import_View extends TablePress_Import_View {

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

		TablePress_Modules_Helper::enqueue_style( 'automatic-periodic-table-import' );
		TablePress_Modules_Helper::enqueue_script( 'automatic-periodic-table-import' );

		$this->add_meta_box( 'tables-auto-import', 'Automatic Periodic Import of Tables', array( $this, 'postbox_auto_import' ), 'additional' );
	}

	/**
	 * Prints the form for the Automatic Periodic Table Import list.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data Data for this screen.
	 * @param array $box  Information about the meta box.
	 */
	public function postbox_auto_import( array $data, array $box ) {
		?>
		<p><?php _e( 'To periodically import tables from files that were uploaded to a server, configure the desired interval and table source information below.', 'tablepress' ); ?></p>
		<p><?php _e( 'Perform Automatic Periodic Table Import:', 'tablepress' ); ?>
		<select id="auto-import-schedule">
		<?php
		foreach ( $data['cron_schedules'] as $name => $schedule ) {
			$selected = selected( $data['auto_import_schedule'], $name, false );
			echo "<option{$selected} value=\"{$name}\">{$schedule['display']}</option>";
		}
		?>
		</select>
		</p>
		<p class="submit">
		<input type="button" class="button button-secondary button-large button-save-changes" value="<?php esc_attr_e( 'Save Automatic Import configuration', 'tablepress' ); ?>" />
		</p>
		<table id="tablepress-automatic-periodic-import-tables" class="widefat striped">
		<thead>
			<tr>
				<th><?php _e( 'ID', 'tablepress' ); ?></th>
				<th><?php _e( 'Table Name', 'tablepress' ); ?></th>
				<th class="check-column"><?php _e( 'Periodic Import', 'tablepress' ); ?><br /><label><input type="checkbox" /> <?php _e( 'Select All', 'default' ); ?></label></th>
				<th><?php _e( 'Import Source', 'tablepress' ); ?></th>
				<th class="auto-import-location"><?php _e( 'Import File Location', 'tablepress' ); ?></th>
				<th><?php _e( 'Last Automatic Import', 'tablepress' ); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $data['table_ids'] as $table_id ) {
			$table = TablePress::$model_table->load( $table_id, false, false ); // Load table, without table data, options, and visibility settings.
			if ( isset( $data['auto_import_tables'][ $table['id'] ] ) ) {
				$auto_import_table = $data['auto_import_tables'][ $table['id'] ];
			} else {
				$auto_import_table = array( 'id' => $table['id'], 'active' => false, 'source' => 'url', 'location' => 'https://', 'last_import' => '-' );
			}
			echo "<tr data-table-id=\"{$table['id']}\">
			<td>{$table['id']}</td>
			<td><strong>{$table['name']}</strong></td>
			<td class=\"check-column\">
				<label><input type=\"checkbox\" class=\"cb_auto_import_active\"" . checked( $auto_import_table['active'], true, false ) . '/> ' . __( 'Active', 'tablepress' ) . '</label>
			</td>
			<td>
				<select class="select_auto_import_source">
					<option value="url"' . selected( $auto_import_table['source'], 'url', false ) . '>' . __( 'URL', 'tablepress' ) . '</option>
					<option value="server"' . selected( $auto_import_table['source'], 'server', false ) . '>' . __( 'File on server', 'tablepress' ) . "</option>
				</select>
			</td>
			<td>
				<input type=\"text\" class=\"input_auto_import_location large-text code\" value=\"{$auto_import_table['location']}\" />
			</td>
			<td>{$auto_import_table['last_import']}</td>
			</tr>\n";
		}
		?>
		</tbody>
		<tfoot>
			<tr>
				<th><?php _e( 'ID', 'tablepress' ); ?></th>
				<th><?php _e( 'Table Name', 'tablepress' ); ?></th>
				<th class="check-column"><label><input type="checkbox" /> <?php _e( 'Select All', 'default' ); ?></label><br /><?php _e( 'Periodic Import', 'tablepress' ); ?></th>
				<th><?php _e( 'Import Source', 'tablepress' ); ?></th>
				<th><?php _e( 'Import File Location', 'tablepress' ); ?></th>
				<th><?php _e( 'Last Automatic Import', 'tablepress' ); ?></th>
			</tr>
		</tfoot>
		</table>
		<p class="submit">
		<input type="button" class="button button-secondary button-large button-save-changes" value="<?php esc_attr_e( 'Save Automatic Import configuration', 'tablepress' ); ?>" />
		</p>
		<?php

		$abspath = ABSPATH;
		echo <<<JS
<script>
// Ensure the global `tp` object exists.
window.tp = window.tp || {};
tp.abspath = '{$abspath}';
</script>
JS;
	}

} // class TablePress_Automatic_Periodic_Table_Import_View
