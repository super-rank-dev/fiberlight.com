<?php
/**
 * This file is used to create wfb-pro admin page WHEN CF PRO CAN NOT BE USED
 */
if( ! defined( 'ABSPATH' ) ){
	exit;
}

?>
<div class="qcformbuilder-editor-header">
	<ul class="qcformbuilder-editor-header-nav">
		<li class="qcformbuilder-editor-logo">
			<span class="qcformbuilder-forms-name">
				Chatbot Form Builder Pro
			</span>
		</li>
	</ul>
</div>

<div class="postbox" style="margin-top: 75px;padding: 8px;">
	<?php
        $message = __( 'Chatbot Form Builder Pro could not be loaded because your site\'s version of PHP is out of date. Chatbot Form Builder Pro requires PHP 5.6 or later.', 'qcformbuilder-forms' );
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( 'notice notice-error' ), esc_html( $message ) );
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( 'notice notice-warning' ), __( 'For more information, please see: ', 'wfb-pro' ) . ' <a href="https://quantumcloud.com/php?utm_source=wp-admin&utm_keyword=php_version">QcformbuilderForms.com/php</a>' );
    ?>
</div>
