/**
 * JavaScript code for the "Automatic Periodic Table Import" screen.
 *
 * @package TablePress
 * @subpackage Views JavaScript
 * @author Tobias Bäthge
 * @since 2.0.0
 */

/* globals tp */

/**
 * Internal dependencies.
 */
import { $ } from '../../../admin/js/_common-functions';
import { save_changes } from './_save-changes';

/*
 * Register click callback for the "Save Automatic Import configuration" buttons.
 */
$( '#tablepress_import-tables-auto-import' ).addEventListener( 'click', ( event ) => {
	if ( ! event.target ) {
		return;
	}

	if ( event.target.matches( '.button-save-changes' ) ) {
		// Gather the Automatic Periodic Table Import configuration.
		const auto_import_configuration = {
			schedule: $( '#auto-import-schedule' ).value,
			tables: {},
		};
		document.querySelectorAll( '#tablepress-automatic-periodic-import-tables > tbody > tr' ).forEach( ( row ) => {
			const table_id = row.dataset.tableId;
			const active = row.querySelector( '.cb_auto_import_active' ).checked;
			const source = row.querySelector( '.select_auto_import_source' ).value;
			const location = row.querySelector( '.input_auto_import_location' ).value;

			// Only save things for tables that have changes and not just the default settings.
			if ( active || 'url' !== source || 'https://' !== location ) {
				auto_import_configuration.tables[ table_id ] = {
					active,
					source,
					location,
				};
			}
		} );

		// Prepare the data for the AJAX request.
		const request_data = {
			action: 'tablepress_import',
			_ajax_nonce: $( '#_wpnonce' ).value,
			tablepress: JSON.stringify( auto_import_configuration ),
		};

		save_changes( event, request_data );
		return;
	}
} );

$( '#tablepress-automatic-periodic-import-tables' ).addEventListener( 'change', ( event ) => {
	if ( ! event.target ) {
		return;
	}

	// Toggle dropdown and import source field if import is off for a table.
	if ( event.target instanceof HTMLInputElement && 'checkbox' === event.target.type  ) {
		updateAutoImportSourceFields();
	}

	// Adjust shown fields if import source is changed.
	if ( event.target.matches( '.select_auto_import_source' ) ) {
		const source_field = event.target.closest( 'tr' ).querySelector( '.input_auto_import_location' );
		const source = source_field.value;
		const type = event.target.value;

		if ( 'url' === type && tp.abspath === source ) {
			source_field.value = 'https://';
		} else if ( 'server' === type && 'https://' === source ) {
			source_field.value = tp.abspath;
		}
	}
} );

/*
 * Update table import source fields states.
 */
const updateAutoImportSourceFields = function () {
	document.querySelectorAll( '#tablepress-automatic-periodic-import-tables > tbody > tr' ).forEach( ( row ) => {
		const disabled = ! row.querySelector( '.cb_auto_import_active' ).checked;
		row.querySelectorAll( ':scope .select_auto_import_source, :scope .input_auto_import_location' ).forEach( ( field ) => ( field.disabled = disabled ) );
	} );
};
// Trigger the change handler on page load to initialize the form fields.
updateAutoImportSourceFields();

