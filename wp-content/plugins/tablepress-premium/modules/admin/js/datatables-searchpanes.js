/**
 * JavaScript code for the "Edit" screen integration of the DataTables SearchPanes feature.
 *
 * @package TablePress
 * @subpackage DataTables SearchPanes
 * @author Tobias Bäthge
 * @since 2.0.0
 */

/* globals tp */

/**
 * WordPress dependencies.
 */
import { addAction as add_action, addFilter as add_filter } from '@wordpress/hooks';

/**
 * Internal dependencies.
 */
import { $ } from '../../../admin/js/_common-functions';

add_action( 'tablepress.optionsCheckDependencies', 'tp/datatables-searchpanes/handle-options-check-dependencies', () => {
	const searchpanes_enabled = ( tp.table.options.use_datatables && tp.table.options.table_head && tp.table.options.datatables_filter );
	$( '#option-datatables_searchpanes' ).disabled = ! searchpanes_enabled;
	$( '#notice-datatables-searchpanes-requirements' ).style.display = searchpanes_enabled ? 'none' : 'block';
} );

add_filter( 'tablepress.optionsMetaBoxes', 'tp/datatables-searchpanes/add-meta-box', options_meta_boxes => {
	options_meta_boxes.push( '#tablepress_edit-datatables-searchpanes' );
	return options_meta_boxes;
} );
