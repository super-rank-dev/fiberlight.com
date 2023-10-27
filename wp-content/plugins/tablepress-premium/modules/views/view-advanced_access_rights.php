<?php
/**
 * Advanced Access Rights View.
 *
 * @package TablePress
 * @subpackage Views
 * @author Tobias Bäthge
 * @since 2.0.0
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Advanced Access Rights View class.
 *
 * @package TablePress
 * @subpackage Views
 * @author Tobias Bäthge
 * @since 2.0.0
 */
class TablePress_Advanced_Access_Rights_View extends TablePress_View {

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

		TablePress_Modules_Helper::enqueue_style( 'advanced-access-rights' );
		TablePress_Modules_Helper::enqueue_script( 'advanced-access-rights' );

		$this->add_text_box( 'head', array( $this, 'textbox_head' ), 'normal' );
		$this->add_text_box( 'submit', array( $this, 'textbox_submit_button' ), 'normal' );
		$this->add_meta_box( 'access_rights_map', __( 'Table Access Rights', 'tablepress' ), array( $this, 'postbox_access_rights' ), 'normal' );
		$this->add_text_box( 'submit', array( $this, 'textbox_submit_button' ), 'submit' );
	}

	/**
	 * Prints the screen head text.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data Data for this screen.
	 * @param array $box  Information about the text box.
	 */
	public function textbox_head( array $data, array $box ) {
		?>
		<p>
			<?php _e( 'To restrict editing access to certain tables for certain users, use the table below.', 'tablepress' ); ?>
			<?php _e( 'You can also set the default access rights for newly added users and newly added tables.', 'tablepress' ); ?>
		</p>
		<p>
			<?php _e( 'If a user, including yourself, does not have access to a table (i.e., the user’s checkbox for that table is unchecked), he will not see that table on the TablePress admin screens.', 'tablepress' ); ?>
		</p>
		<p>
			<?php _e( 'Note that the user’s user role will also need access for a user to be granted access.', 'tablepress' ); ?>
		</p>
		<?php
	}

	/**
	 * Prints the content of the "Advanced Access Rights" post meta box.
	 *
	 * When generating the table, loop over the current available tables and users, to catch issues where entries in the access map are missing or no longer needed.
	 * This can for example happen, when some of the notifications/action hooks were not processed properly.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data Data for this screen.
	 * @param array $box  Information about the meta box.
	 */
	public function postbox_access_rights( array $data, array $box ) {
		echo "<script>\n";
		echo "window.tp = window.tp || {};\n";
		printf( "tp.access_rights_map = %s;\n", $this->admin_page->convert_to_json_parse_output( $data['access_rights_map'] ) );
		echo "</script>\n";

		echo '<table class="tablepress-access-rights-map striped" id="tablepress-access-rights-map"><thead><tr><th></th><th></th>';
		foreach ( $data['users'] as $user_id => $user ) {
			if ( '#new_users' === $user_id ) {
				echo '<th class="new-users-column">';
				echo __( 'New<br />users', 'tablepress' );
				echo '</th>';
			} else {
				echo '<th>';
				echo "{$user_id}:<br /><abbr title=\"" . esc_attr( $user->display_name ) . "\">{$user->user_login}</abbr>";
				echo '</th>';
			}
		}
		echo '</tr></thead><tbody>';
		foreach ( $data['table_ids'] as $table_id ) {
			if ( '#new_tables' === $table_id ) {
				echo '<tr class="new-tables-row">';
				echo '<th></th>';
				echo '<th>';
				echo __( 'New tables', 'tablepress' );
				echo '</th>';
			} else {
				echo '<tr>';
				echo "<th class=\"column-table-id\">{$table_id}:</th>";
				$table = TablePress::$model_table->load( $table_id, false, false ); // Don't load data, options, or visibility.
				if ( '' === trim( $table['name'] ) ) {
					$table['name'] = __( '(no name)', 'tablepress' );
				}
				echo "<th class=\"column-table-name\">{$table['name']}</th>";
			}
			foreach ( $data['users'] as $user_id => $user ) {
				$class = ( '#new_users' === $user_id ) ? ' class="new-users-column"' : '';
				echo "<td{$class}>";
				echo "<input type=\"checkbox\" id=\"tp-aar-{$table_id}-{$user_id}\" data-table-id=\"{$table_id}\" data-user-id=\"{$user_id}\" />";
				echo '</td>';
			}
			echo '</tr>';
		}
		echo '</tbody></table>';
	}

	/**
	 * Prints "Save Changes" button.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data Data for this screen.
	 * @param array $box  Information about the text box.
	 */
	public function textbox_submit_button( array $data, array $box ) {
		?>
			<p class="submit">
			<input type="button" class="button button-primary button-large button-save-changes" value="<?php esc_attr_e( 'Save Changes', 'tablepress' ); ?>" />
			</p>
		<?php
	}

} // class TablePress_Advanced_Access_Rights_View
