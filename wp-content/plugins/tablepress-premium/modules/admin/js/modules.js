/**
 * JavaScript code for the "Modules" screen.
 *
 * @package TablePress
 * @subpackage Views JavaScript
 * @author Tobias Bäthge
 * @since 2.0.0
 */

/**
 * WordPress dependencies.
 */
import { __, _x, sprintf } from '@wordpress/i18n';

/**
 * Internal dependencies.
 */
import { $ } from '../../../admin/js/_common-functions';

/**
 * Event handler for the beforeunload event.
 *
 * @param {Event} event Browser's `beforeunload` event.
 */
const beforeunload_dialog = ( event ) => {
	event.preventDefault(); // Cancel the event as stated by the standard.
	event.returnValue = ''; // Chrome requires returnValue to be set.
};

const $form = document.querySelector( '#tablepress-page form' );

/**
 * On form submit: Enable disabled input fields, so that they are sent in the HTTP POST request.
 */
$form.addEventListener( 'submit', function () {
	this.querySelectorAll( ':scope input' ).forEach( ( field ) => ( field.disabled = false ) );
	window.removeEventListener( 'beforeunload', beforeunload_dialog );
} );

let have_unsaved_changes = false;

/**
 * On checkbox change: Register beforeunload handler to trigger a "Save changes" warning.
 */
$form.addEventListener( 'change', () => {
	// Bail early if this function was already called.
	if ( have_unsaved_changes ) {
		return;
	}

	have_unsaved_changes = true;
	window.addEventListener( 'beforeunload', beforeunload_dialog );
} );

// Add keyboard shortcut as title attribute to the "Save Changes" button, with correct modifier key for Mac/non-Mac.
const modifier_key = ( window?.navigator?.platform?.includes( 'Mac' ) ) ?
	_x( '⌘', 'keyboard shortcut modifier key on a Mac keyboard', 'tablepress' ) :
	_x( 'Ctrl+', 'keyboard shortcut modifier key on a non-Mac keyboard', 'tablepress' );
const $save_changes_button = $( '#tablepress-modules-save-changes' );
const shortcut = sprintf( $save_changes_button.dataset.shortcut, modifier_key ); // eslint-disable-line @wordpress/valid-sprintf
$save_changes_button.title = sprintf( __( 'Keyboard Shortcut: %s', 'tablepress' ), shortcut );

/**
 * Registers keyboard events and triggers corresponding actions by emulating button clicks.
 *
 * @since 2.1.2
 *
 * @param {Event} event Keyboard event.
 */
const keyboard_shortcuts = ( event ) => {
	let action = '';

	if ( event.ctrlKey || event.metaKey ) {
		if ( 83 === event.keyCode ) {
			// Save Changes: Ctrl/Cmd + S.
			action = 'save-changes';
		}
	}

	if ( 'save-changes' === action ) {
		// Blur the focussed element to make sure that all change events were triggered.
		document.activeElement.blur(); // eslint-disable-line @wordpress/no-global-active-element

		// Emulate a click on the button corresponding to the action.
		$save_changes_button.click();

		// Prevent the browser's native handling of the shortcut, i.e. showing the Save or Print dialogs.
		event.preventDefault();
	}
};
// Register keyboard shortcut handler.
window.addEventListener( 'keydown', keyboard_shortcuts, true );
