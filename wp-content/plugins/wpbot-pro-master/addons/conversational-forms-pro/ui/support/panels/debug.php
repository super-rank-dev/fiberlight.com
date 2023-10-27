<?php
/**
 * Support page -- debug view
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */

?>
<div id="qcformbuilder-config-group-short">
	<h3><?php esc_html_e( 'Short Debug Information', 'qcformbuilder-forms' ); ?></h3>

	<?php echo Qcformbuilder_Forms_Support::short_debug_info(); ?>

</div>

<div id="qcformbuilder-config-group-full">
	<h3><?php esc_html_e( 'Full Debug Information', 'qcformbuilder-forms' ); ?></h3>

	<?php echo Qcformbuilder_Forms_Support::debug_info(); ?>

</div>
