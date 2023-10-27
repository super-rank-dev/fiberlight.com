/**
 * JavaScript code for the "Edit" screen integration of the DataTables SearchBuilder feature.
 *
 * @package TablePress
 * @subpackage DataTables SearchBuilder
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

add_action( 'tablepress.optionsCheckDependencies', 'tp/datatables-searchbuilder/handle-options-check-dependencies', () => {
	const searchbuilder_enabled = ( tp.table.options.use_datatables && tp.table.options.table_head && tp.table.options.datatables_filter );
	$( '#option-datatables_searchbuilder' ).disabled = ! searchbuilder_enabled;
	$( '#notice-datatables-searchbuilder-requirements' ).style.display = searchbuilder_enabled ? 'none' : 'block';
} );

add_filter( 'tablepress.optionsMetaBoxes', 'tp/datatables-searchbuilder/add-meta-box', options_meta_boxes => {
	options_meta_boxes.push( '#tablepress_edit-datatables-searchbuilder' );
	return options_meta_boxes;
} );
