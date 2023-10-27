/**
 * JavaScript code for the "Advanced Access Rights" screen.
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
 * Update checkbox state to match internal data state.
 */
const updateCheckBoxes = function () {
	Object.keys( tp.access_rights_map ).forEach( ( table_id ) => {
		Object.keys( tp.access_rights_map[ table_id ] ).forEach( ( user_id ) => {
			const access = tp.access_rights_map[ table_id ][ user_id ];
			$( `#tp-aar-${ table_id }-${ user_id }` ).checked = ( 1 === access );
		} );
	} );
};
updateCheckBoxes();

/*
 * Register click callback for the "Save Changes" buttons.
 */
$( '#tablepress-page' ).addEventListener( 'click', ( event ) => {
	if ( ! event.target ) {
		return;
	}

	if ( event.target.matches( '.button-save-changes' ) ) {
		// Prepare the data for the AJAX request.
		const request_data = {
			action: 'tablepress_advanced_access_rights',
			_ajax_nonce: $( '#_wpnonce' ).value,
			tablepress: JSON.stringify( tp.access_rights_map ),
		};

		save_changes( event, request_data );
		return;
	}
} );

/*
 * Store table ID and user ID indices of the last clicked checkbox.
 */
let last_checkbox_idx;

/*
 * Register change callbacks for the access rights checkboxes.
 */
$( '#tablepress-access-rights-map' ).addEventListener( 'click', function ( event ) {
	if ( ! event.target ) {
		return;
	}

	if ( event.target instanceof HTMLInputElement && 'checkbox' === event.target.type  ) {
		const table_ids = Object.keys( tp.access_rights_map );
		const user_ids = Object.keys( tp.access_rights_map[ table_ids[0] ] );

		// Find indices of current table ID and current user ID, as these are not in consecutive order.
		const current_checkbox_idx = {
			table_id: table_ids.indexOf( event.target.dataset.tableId ),
			user_id: user_ids.indexOf( event.target.dataset.userId ),
		};

		// If no checkbox had been pressed before, or if the Shift key was not held, only change the current checkbox.
		if ( ! last_checkbox_idx || 'undefined' === typeof event.shiftKey || ! event.shiftKey ) {
			last_checkbox_idx = current_checkbox_idx;
		}

		// Determine first and last table ID and user ID indices, as these determine the range of checkboxes.
		const first_idx = {
			table_id: ( last_checkbox_idx.table_id < current_checkbox_idx.table_id ) ? last_checkbox_idx.table_id : current_checkbox_idx.table_id,
			user_id: ( last_checkbox_idx.user_id < current_checkbox_idx.user_id ) ? last_checkbox_idx.user_id : current_checkbox_idx.user_id,
		};
		const last_idx = {
			table_id: ( current_checkbox_idx.table_id > last_checkbox_idx.table_id ) ? current_checkbox_idx.table_id : last_checkbox_idx.table_id,
			user_id: ( current_checkbox_idx.user_id > last_checkbox_idx.user_id ) ? current_checkbox_idx.user_id : last_checkbox_idx.user_id,
		};

		// Loop over the range and check/uncheck all checkboxes in that range.
		for ( let table_id_idx = first_idx.table_id; table_id_idx <= last_idx.table_id; table_id_idx++ ) {
			for ( let user_id_idx = first_idx.user_id; user_id_idx <= last_idx.user_id; user_id_idx++ ) {
				const table_id = table_ids[ table_id_idx ];
				const user_id = user_ids[ user_id_idx ];
				tp.access_rights_map[ table_id ][ user_id ] = event.target.checked ? 1 : 0;
			}
		}

		// After processing the clicks, the current checkbox is the last clicked checkbox.
		last_checkbox_idx = current_checkbox_idx;

		// Update visual states of the checkboxes.
		updateCheckBoxes();

		return;
	}
} );
