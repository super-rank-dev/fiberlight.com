/**
 * JavaScript code for the "Edit" screen integration of the Cell Highlighting feature.
 *
 * @package TablePress
 * @subpackage Cell Highlighting
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

add_action( 'tablepress.optionsCheckDependencies', 'tp/cell-highlighting/handle-options-check-dependencies', () => {
	const highlight_parameters_disabled = ( '' === tp.table.options.highlight.trim() );
	$( '#option-highlight_full_cell_match' ).disabled = highlight_parameters_disabled;
	$( '#option-highlight_case_sensitive' ).disabled = highlight_parameters_disabled;
	$( '#option-highlight_columns' ).disabled = highlight_parameters_disabled;
} );

add_filter( 'tablepress.optionsMetaBoxes', 'tp/cell-highlighting/add-meta-box', options_meta_boxes => {
	options_meta_boxes.push( '#tablepress_edit-cell-highlighting' );
	return options_meta_boxes;
} );
