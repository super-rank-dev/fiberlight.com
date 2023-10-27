/**
 * JavaScript code for the "Edit" screen integration of the DataTables ColumnFilterWidgets feature.
 *
 * @package TablePress
 * @subpackage DataTables ColumnFilterWidgets
 * @author Tobias Bäthge
 * @since 2.0.0
 */

/* globals tp */

/**
 * WordPress dependencies.
 */
import { __, sprintf } from '@wordpress/i18n';
import { addAction as add_action, addFilter as add_filter } from '@wordpress/hooks';

/**
 * Internal dependencies.
 */
import { $ } from '../../../admin/js/_common-functions';

add_action( 'tablepress.optionsCheckDependencies', 'tp/datatables-columnfilterwidgets/handle-options-check-dependencies', () => {
	const columnfilterwidgets_enabled = ( tp.table.options.use_datatables && tp.table.options.table_head && tp.table.options.datatables_filter );
	$( '#option-datatables_columnfilterwidgets' ).disabled = ! columnfilterwidgets_enabled;
	$( '#option-datatables_columnfilterwidgets_exclude_columns' ).disabled = ! columnfilterwidgets_enabled || ! tp.table.options.datatables_columnfilterwidgets;
	$( '#option-datatables_columnfilterwidgets_separator' ).disabled = ! columnfilterwidgets_enabled || ! tp.table.options.datatables_columnfilterwidgets;
	$( '#option-datatables_columnfilterwidgets_max_selections' ).disabled = ! columnfilterwidgets_enabled || ! tp.table.options.datatables_columnfilterwidgets;
	$( '#option-datatables_columnfilterwidgets_group_terms' ).disabled = ! columnfilterwidgets_enabled || ! tp.table.options.datatables_columnfilterwidgets;
	$( '#notice-datatables-columnfilterwidgets-requirements' ).style.display = columnfilterwidgets_enabled ? 'none' : 'block';
} );

add_filter( 'tablepress.optionsMetaBoxes', 'tp/datatables-columnfilterwidgets/add-meta-box', options_meta_boxes => {
	options_meta_boxes.push( '#tablepress_edit-datatables-columnfilterwidgets' );
	return options_meta_boxes;
} );

add_filter( 'tablepress.optionsValidateFields', 'tp/datatables-columnfilterwidgets/validate-fields', form_valid => {
	// The "Column Filter Dropdowns" field must not contain invalid characters.
	if ( ( /[^a-z,]/ ).test( tp.table.options.datatables_columnfilterwidgets ) ) {
		window.alert( sprintf( __( 'The entered value in the “%1$s” field is invalid.', 'tablepress' ), __( 'Column Filter Dropdowns', 'tablepress' ) ) );
		const $field = $( '#option-datatables_columnfilterwidgets' );
		$field.focus();
		$field.select();
		form_valid = false;
	}

	return form_valid;
} );
