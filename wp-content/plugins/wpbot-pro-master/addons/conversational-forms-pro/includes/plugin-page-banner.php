<?php
add_action('admin_init', 'qcformbuilder_forms_notice_ignore');







/**
 * Track dismissals of Chatbot Form Builder plugin page banners
 *
 * @since 1.4.4
 * @uses "admin_init"
 */
function qcformbuilder_forms_notice_ignore() {
	$user_id = get_current_user_id();

	if ( isset($_GET['qcformbuilder_forms_notice_ignore']) && '0' == $_GET['qcformbuilder_forms_notice_ignore'] ) {
		add_user_meta($user_id, 'qcformbuilder_forms_activation_ignore_notice', 'true', true);
	}
}

