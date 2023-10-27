<?php
global $field_config_panels;
?>
<div id="field_config_panels"><?php

if(!empty($field_config_panels)){
	echo implode("\r\n", $field_config_panels);
}

?></div>
<?php do_action( 'qcformbuilder_forms_layout_sidebar', $element ); ?>