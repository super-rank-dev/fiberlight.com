/**
 * JavaScript code for the "Automatic Table Export" screen.
 *
 * @package TablePress
 * @subpackage Views JavaScript
 * @author Tobias Bäthge
 * @since 2.0.0
 */

/**
 * WordPress dependencies.
 */
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies.
 */
import { $ } from '../../../admin/js/_common-functions';
import { save_changes } from './_save-changes';

const auto_export_active_dropdown = $( '#auto-export-active' );
const auto_export_path_field = $( '#auto-export-path' );
const auto_export_csv_delimiter_dropdown = $( '#auto-export-csv-delimiter' );

/*
 * Register click callback for the "Save Automatic Export configuration" buttons.
 */
$( '#tablepress_auto_export_save_changes_button' ).addEventListener( 'click', ( event ) => {
	const auto_export_active = auto_export_active_dropdown.checked;
	const auto_export_path = auto_export_path_field.value.trim();

	// Don't submit the form if no path is given, while the export is active.
	if ( auto_export_active && '' === auto_export_path ) {
		window.alert( __( 'You must set a server path for the automatic table export.', 'tablepress' ) );
		auto_export_path_field.focus();
		return;
	}

	const selected_export_formats = [ ...document.querySelectorAll( '#auto-export-formats input:checked' ) ].map( ( checkbox ) => checkbox.value );

	// Don't submit the form if no export format was selected, while the export is active.
	if ( auto_export_active && 0 === selected_export_formats.length ) {
		window.alert( __( 'You must select at least one export format for the automatic table export.', 'tablepress' ) );
		return;
	}

	// Gather the Automatic Table Export configuration.
	const auto_export_configuration = {
		active: auto_export_active,
		path: auto_export_path,
		formats: selected_export_formats,
		csv_delimiter: auto_export_csv_delimiter_dropdown.value,
	};

	// Prepare the data for the AJAX request.
	const request_data = {
		action: 'tablepress_export',
		_ajax_nonce: $( '#_wpnonce' ).value,
		tablepress: JSON.stringify( auto_export_configuration ),
	};

	save_changes( event, request_data );
	return;
} );

/**
 * Disable the form fields if the auto export is inactive.
 */
const auto_export_active_dropdown_change_handler = () => {
	const form_fields_disabled = ! auto_export_active_dropdown.checked;
	auto_export_path_field.disabled = form_fields_disabled;
	document.querySelectorAll( '#auto-export-formats input' ).forEach( ( checkbox ) => ( checkbox.disabled = form_fields_disabled ) );
	auto_export_csv_delimiter_dropdown.disabled = form_fields_disabled;
};
auto_export_active_dropdown.addEventListener( 'change', auto_export_active_dropdown_change_handler );
auto_export_active_dropdown_change_handler();

/**
 * Disable the CSV delimiter dropdown if CSV is not selected in the formats.
 */
const auto_export_formats_checkbox_csv = $( '#auto-export-format-csv' );
const auto_export_formats_checkbox_csv_change_handler = () => {
	auto_export_csv_delimiter_dropdown.disabled = ! auto_export_formats_checkbox_csv.checked;
	$( '#auto-export-csv-delimiter-description' ).style.display = auto_export_formats_checkbox_csv.checked ? 'none' : 'inline';
};
auto_export_formats_checkbox_csv.addEventListener( 'change', auto_export_formats_checkbox_csv_change_handler );
auto_export_formats_checkbox_csv_change_handler();
