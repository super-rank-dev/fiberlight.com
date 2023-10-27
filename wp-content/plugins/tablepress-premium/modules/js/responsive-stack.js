/**
 * JavaScript code for the "Stack" mode of the Responsive Tables module.
 *
 * @package TablePress
 * @subpackage Responsive Tables
 * @author Tobias Bäthge
 * @since 2.0.0
 */

const css_class = 'tablepress-responsive-stack-headers';
document.querySelectorAll( '.' + css_class ).forEach( ( $table ) => {
	if ( ! $table.tHead || ! $table.tBodies ) {
		$table.classList.remove( css_class );
		return;
	}

	for ( const $row of $table.tBodies[0].rows ) {
		for ( let col_idx = 0; col_idx < $row.cells.length; col_idx++ ) {
			$row.cells[ col_idx ].dataset.th = $table.tHead.rows[0].cells[ col_idx ].textContent;
		}
	}
} );
