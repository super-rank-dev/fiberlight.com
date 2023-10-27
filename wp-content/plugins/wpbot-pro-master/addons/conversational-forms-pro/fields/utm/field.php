<?php
foreach ( Qcformbuilder_Forms_Field_Utm::tags() as $tag ){
	$utm_field_config = Qcformbuilder_Forms_Field_Utm::config( $field, $tag );
	echo Qcformbuilder_Forms_Field_Input::html( $utm_field_config, $field_structure, $form );
}

