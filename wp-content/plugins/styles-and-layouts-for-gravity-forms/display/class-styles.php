<?php
$get_form_options = get_option( "gf_stla_form_id_".$css_form_id );
$get_general_settings = get_option('gf_stla_general_settings'.$css_form_id);
$important = isset($get_general_settings['force-style'] )?$get_general_settings['force-style']:'';
if ( $important ){
	$important = ' !important';
}
ob_start();
 ?>

<style type="text/css">
<?php
if ( isset( $get_form_options['form-wrapper']['font'] ) ) {
	$font_name = $get_form_options['form-wrapper']['font'];
	$font_name= str_replace( ' ', '+', $font_name );
	if ( $font_name !== 'Default' ) {
	echo "@import url('https://fonts.googleapis.com/css?family=$font_name' );";
	}
}

if ( isset( $get_form_options['form-wrapper'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> {
		<?php echo 'border-width: 0; border-style: solid;' ?>
		<?php
		/**
		* support for background type for v2.08 or older
		* if a user a set an image for background but the background type is not set then set it to 'image'
		*/

		if ( ! isset( $get_form_options['form-wrapper']['background-type'] ) ) {
			if ( ! empty( $get_form_options['form-wrapper']['background-image'] ) ) {
				$get_form_options['form-wrapper']['background-type'] = 'image';
			}
			else{
				$get_form_options['form-wrapper']['background-type'] = 'color';
			}
			update_option( "gf_stla_form_id_".$css_form_id, $get_form_options );
		}

		echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'form-wrapper',  $important );

		// Show Gradient background
		if ( isset( $get_form_options['form-wrapper']['background-type'] ) && ( $get_form_options['form-wrapper']['background-type']== 'gradient' ) ) {
			$background_opacity = isset( $get_form_options['form-wrapper']['background-opacity'] ) ? $get_form_options['form-wrapper']['background-opacity']: 1;
			
			$gradient_direction = isset( $get_form_options['form-wrapper']['gradient-direction'] ) ? $get_form_options['form-wrapper']['gradient-direction']: 'left';
			$gradient1 = ! empty( $get_form_options['form-wrapper']['gradient-color-1'] ) ?$get_form_options['form-wrapper']['gradient-color-1'] : '#ffffff' ;
			$gradient1 = $main_class_object->hex_rgba( $gradient1, $background_opacity );
			$gradient2 = ! empty( $get_form_options['form-wrapper']['gradient-color-2'] ) ? $get_form_options['form-wrapper']['gradient-color-2'] : '#ffffff';
			$gradient2 = $main_class_object->hex_rgba( $gradient2, $background_opacity );
			$gradient_css =  $main_class_object->set_gradient_properties( $gradient1,$gradient2,$gradient_direction ); 
			echo $gradient_css;
		}
		if ( isset( $get_form_options['form-wrapper']['background-type'] ) && ( $get_form_options['form-wrapper']['background-type'] == 'color' ) ) {
			if ( isset( $get_form_options['form-wrapper']['background-color'] ) ) {
				$background_opacity = isset( $get_form_options['form-wrapper']['background-opacity'] ) ? $get_form_options['form-wrapper']['background-opacity'] : 1;
				echo 'background-color:'.$main_class_object->hex_rgba( $get_form_options['form-wrapper']['background-color'], $background_opacity ).';';
			}
		}
		if ( $get_form_options['form-wrapper']['background-type'] == 'image' ) {
			echo empty( $get_form_options['form-wrapper']['background-image'] ) ? '' : 'background-image:url("'. $get_form_options['form-wrapper']['background-image'].'") ;' ;
			echo 'background-repeat: no-repeat;'; 
		}
		if ( ! empty( $get_form_options['form-wrapper']['font'] ) ) {
			if ( $get_form_options['form-wrapper']['font'] == 'Default' ) {
				echo 'font-family:inherit;' ;
			}
			else {
				echo 'font-family:"'. $get_form_options['form-wrapper']['font'].'";' ;
			}
		} ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['form-header'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_heading {
		<?php echo 'border-style: solid;'; ?>
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'form-header', $important ); ?>
		<?php
		if ( empty( $get_form_options['form-header']['border-size'] ) ) {
			echo 'border-width: 0px;';
		} ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['form-title'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_heading .gform_title {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'form-title', $important ); ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['form-description'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_heading .gform_description {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'form-description', $important ); ?>
		display:block;
	}
<?php } ?>

<?php if ( isset( $get_form_options['submit-button'] ) ) { ?>

	body #gform_wrapper_<?php echo $css_form_id ?> .gform_footer .gform_button,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_page_footer .gform_button,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_page_footer .gform_previous_button,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_page_footer .gform_next_button,
	body #gform_wrapper_<?php echo $css_form_id ?> .gfield#field_submit .gform-button
	{
		<?php echo 'border-style: solid;'; ?>
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'submit-button', $important ); ?>

		<?php
		if ( empty( $get_form_options['submit-button']['border-size'] ) ) {
			echo 'border-width: 0px;';
		} ?>
	}
	
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_footer .gform_button:hover,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_page_footer .gform_button:hover,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_page_footer .gform_previous_button:hover,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_page_footer .gform_next_button:hover,
	body #gform_wrapper_<?php echo $css_form_id ?> .gfield#field_submit .gform-button:hover {
		<?php echo ! empty( $get_form_options['submit-button']['hover-color'] ) ? 'background-color:'. $get_form_options['submit-button']['hover-color'].';' : ''; ?>
		<?php echo ! empty( $get_form_options['submit-button']['font-hover-color'] ) ? 'color:'. $get_form_options['submit-button']['font-hover-color'].';' : ''; ?>
		<?php echo ! empty( $get_form_options['submit-button']['border-type'] ) ? 'border-type:'. $get_form_options['submit-button']['border-type'].';' : 'border-style: solid;'; ?>
		<?php echo ! empty( $get_form_options['submit-button']['border-co'] ) ? 'border-type:'. $get_form_options['submit-button']['border-type'].';' : 'border-style: solid;'; ?>
	}


	body #gform_wrapper_<?php echo $css_form_id ?> .gform_footer button.mdc-button:hover {
		<?php echo isset( $get_form_options['submit-button']['hover-color'] ) ? 'background-color:'. $get_form_options['submit-button']['hover-color'].';' : ''; ?>
		<?php echo isset( $get_form_options['submit-button']['font-hover-color'] ) ? 'color:'. $get_form_options['submit-button']['font-hover-color'].';' : ''; ?>
	}
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_footer,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_page_footer,
	body #gform_wrapper_<?php echo $css_form_id ?> #field_submit.gfield {
		<?php echo isset( $get_form_options['submit-button']['button-align'] ) ? 'text-align:'. $get_form_options['submit-button']['button-align'].';' : ''; ?>
		<?php echo isset( $get_form_options['submit-button']['button-align'] ) ? 'justify-content:'. $get_form_options['submit-button']['button-align'].';' : ''; ?>
	}
	
	
<?php } ?>

<?php if ( isset( $get_form_options['text-fields'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=text],
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=email],
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=tel],
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=url],
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=password],
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=number]
	{
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'text-fields', $important ); ?>
		max-width:100%;
		<?php
		if ( ! isset( $get_form_options['text-fields']['border-size'] ) ) {
			echo 'border-width: 1px;';
		} ?>
	}
<?php } ?>

<?php if ( ! empty( $get_form_options['text-fields']['max-width'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> div.ginput_complex.ginput_container.ginput_container_name,
	body #gform_wrapper_<?php echo $css_form_id ?> div.ginput_complex.ginput_container,
	body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container.ginput_container_list {
		width: <?php echo $get_form_options['text-fields']['max-width'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['text-fields']['max-width'] ) ?>;
		max-width:100%;
	}

	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container.ginput_container_name input[type=text],
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container.ginput_container_name select,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container input[type="text"],
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container input select,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_container.ginput_container_list input[type=text] {
		max-width:100%;
		width:100%
	}
	body #gform_wrapper_<?php echo $css_form_id ?>.gform_wrapper .gform_body .gform_fields .gfield_time_ampm select {
		width: calc( 3rem + 20px );
	}
	body #gform_wrapper_<?php echo $css_form_id ?>.gform_wrapper .gform_body .gform_fields .gfield_time_hour input,
	body #gform_wrapper_<?php echo $css_form_id ?>.gform_wrapper .gform_body .gform_fields .gfield_time_minute input {
		 width: calc( 3rem + 8px );
	}

<?php } ?>

<?php if ( isset( $get_form_options['text-fields'] ) || isset( $get_form_options['paragraph-textarea'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield textarea {
		<?php if ( isset( $get_form_options['paragraph-textarea'] ) ) {
			echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'paragraph-textarea', $important );
		} ?>
		<?php
		if ( ! isset( $get_form_options['text-fields']['border-size'] ) ) {
			echo 'border-width: 1px;';
		}
	
		?>

		<?php echo empty( $get_form_options['text-fields']['background-color'] ) ? '' : 'background:'. $get_form_options['text-fields']['background-color'].';'; ?>
		<?php echo ! isset( $get_form_options['text-fields']['border-size'] ) ? '' : 'border-width:'. $get_form_options['text-fields']['border-size'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['text-fields']['border-size'] ).';'; ?>
		<?php echo empty( $get_form_options['text-fields']['border-color'] ) ? '' : 'border-color:'. $get_form_options['text-fields']['border-color'].';'; ?>
		<?php echo empty( $get_form_options['text-fields']['border-type'] ) ? 'border-style: solid;' : 'border-style:'. $get_form_options['text-fields']['border-type'].';'; ?>
		<?php echo empty( $get_form_options['text-fields']['font-size'] ) ? '' : 'font-size:'. $get_form_options['text-fields']['font-size'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['text-fields']['font-size'] ).';'; ?>
		<?php echo empty( $get_form_options['text-fields']['font-color'] ) ? '' : 'color:'. $get_form_options['text-fields']['font-color'].';'; ?>
		<?php
		if ( isset( $get_form_options['text-fields']['border-radius'] ) ) {
			echo 'border-radius: '.$get_form_options['text-fields']['border-radius'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['text-fields']['border-radius'] ).';';
			echo '-web-border-radius: '.$get_form_options['text-fields']['border-radius'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['text-fields']['border-radius'] ).';';
			echo '-moz-border-radius: '.$get_form_options['text-fields']['border-radius'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['text-fields']['border-radius'] ).';';
		} ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['dropdown-fields'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield select {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'dropdown-fields', $important ); ?>
		max-width: 100%;
		<?php
		if ( ! isset( $get_form_options['dropdown-fields']['border-size'] ) ) {
			echo 'border-width: 1px;';
		} ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['radio-inputs'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gfield_radio label {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'radio-inputs', $important ); ?>
		width: auto;
	}
	<?php if ( ! empty( $get_form_options['radio-inputs']['max-width'] ) ) { ?>
		body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_radio .gfield_radio {
			width: <?php echo $get_form_options['radio-inputs']['max-width'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['radio-inputs']['max-width'] ) ?>; 
		}
	<?php } ?>
<?php } ?>

<?php if ( isset( $get_form_options['checkbox-inputs'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gfield_checkbox label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_consent label{
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'checkbox-inputs', $important ); ?>
	}
	<?php // compatible with legacy markup ?>
	body #gform_wrapper_<?php echo $css_form_id ?> li .gfield_checkbox label,
	body #gform_wrapper_<?php echo $css_form_id ?> li.gfield .ginput_container_consent label{
		width: 100%;
	}

	<?php if ( ! empty( $get_form_options['checkbox-inputs']['max-width'] ) ) { ?>
		body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_checkbox .gfield_checkbox,
		body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_consent {
			width: <?php echo $get_form_options['checkbox-inputs']['max-width'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['checkbox-inputs']['max-width'] ) ?>; 
		}
	<?php } ?>
<?php } ?>

<?php if ( isset( $get_form_options['field-labels'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_label {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'field-labels', $important ); ?>
	}

	<?php if ( ! empty( $get_form_options['field-labels']['asterisk-color'] ) ) { ?>

	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_label .gfield_required {

		color: <?php echo $get_form_options['field-labels']['asterisk-color'] ?>;
	}

<?php } } ?>


<?php if ( isset( $get_form_options['field-descriptions'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_description {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'field-descriptions', $important ); ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['section-break-title'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gsection .gsection_title {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'section-break-title', $important ); ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['section-break-description'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gsection .gsection_description {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'section-break-description', $important ); ?>
		padding: 0 16px 0 0 !important;
	}
<?php } ?>

<?php if ( ! empty( $get_form_options['section-break-description']['padding-top'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gsection {
		padding-top: <?php echo $get_form_options['section-break-description']['padding-top'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['section-break-description']['padding-top'] ).';'; ?>
	}
<?php	} ?>

<?php if ( ! empty( $get_form_options['section-break-description']['padding-left'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gsection {
		padding-left: <?php echo $get_form_options['section-break-description']['padding-left'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['section-break-description']['padding-left'] ).';'; ?>
	}
<?php } ?>

<?php if ( ! empty( $get_form_options['section-break-description']['padding-bottom'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gsection {
		padding-bottom: <?php echo $get_form_options['section-break-description']['padding-bottom'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['section-break-description']['padding-bottom'] ).';'; ?>
	}
	
<?php } ?>

<?php if ( ! empty( $get_form_options['section-break-description']['padding-right'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gsection {
		padding-right: <?php echo $get_form_options['section-break-description']['padding-right'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['section-break-description']['padding-right'] ).';'; ?>
	}

<?php } ?>


<?php if ( isset( $get_form_options['confirmation-message'] ) ) { ?>
	body #gform_confirmation_message_<?php echo $css_form_id ?>  {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'confirmation-message', $important ); ?>
		<?php
		if ( ! isset( $get_form_options['confirmation-message']['border-size'] ) ) {
			echo 'border-width: 1px;';
		} ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['error-message'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .validation_error,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_validation_errors {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'error-message', $important ); ?>
		<?php
		if ( ! isset( $get_form_options['error-message']['border-size'] ) ) {
			echo 'border-width: 1px;';
		} ?>
	}
	
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_validation_errors h2.gform_submission_error{
		<?php echo ! empty( $get_form_options['error-message']['font-color'] ) ? 'color:'.$get_form_options['error-message']['font-color'].';' : ''; ?>

		<?php echo ! empty( $get_form_options['error-message']['font-size'] ) ? 'font-size:'.$get_form_options['error-message']['font-size'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['error-message']['font-size']  ) .';' : ''; ?>

		<?php echo ! empty( $get_form_options['error-message']['line-height'] ) ? 'line-height:'.$get_form_options['error-message']['line-height'].';' : ''; ?>
	}

<?php } ?>

	





<?php if ( isset( $get_form_options['field-sub-labels'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_complex .ginput_full label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_complex .ginput_right label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_complex .ginput_left label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .name_first label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .name_prefix label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .name_middle label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .name_suffix label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .name_last label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_line_1 label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_line_2 label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_city label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_state label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_zip label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_country label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_time_hour label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_time_minute label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_date_month label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_date_day label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_date_year label {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'field-sub-labels', $important ); ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['list-field-table'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list {
    	<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'list-field-table', $important ); ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['list-field-heading'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list .gfield_list .gfield_header_item:not(:last-child),
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list .gfield_list thead th:not(:last-child){
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'list-field-heading', $important ); ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['list-field-cell'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list .gfield_list .gfield_list_cell input {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'list-field-cell', $important ); ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['list-field-cell-container'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list gfield_list .gfield_list_cell  {
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'list-field-cell-container', $important ); ?>
	}
<?php } ?>

<?php if ( isset( $get_form_options['placeholders'] ) ) { ?>
/* Option to style placeholder */
	body #gform_wrapper_<?php echo $css_form_id ?> ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'placeholders', $important ); ?>
	}
	body #gform_wrapper_<?php echo $css_form_id ?> ::-moz-placeholder { /* Firefox 19+ */
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'placeholders', $important ); ?>
	}
	body #gform_wrapper_<?php echo $css_form_id ?> :-ms-input-placeholder { /* IE 10+ */
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'placeholders', $important ); ?>
	}
	body #gform_wrapper_<?php echo $css_form_id ?> :-moz-placeholder { /* Firefox 18- */
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'placeholders', $important ); ?>
	}
<?php } ?>

/* Styling for Tablets */
@media only screen and ( max-width: 800px ) and ( min-width:481px ) {
	<?php if ( stla_isset_checker( $get_form_options, 'form-wrapper', array( 'max-width-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'form-wrapper', $important ); ?>
			}	
	<?php } ?>
	<?php if ( stla_isset_checker( $get_form_options, 'form-title', array( 'font-size-tab', 'line-height-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_heading .gform_title {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'form-title', $important ); ?>
			}
	<?php } ?>
	<?php if ( stla_isset_checker( $get_form_options, 'form-description', array( 'font-size-tab', 'line-height-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_heading .gform_description {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'form-description', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'submit-button', array( 'font-size-tab', 'max-width-tab', 'height-tab', 'line-height-tab' ) ) ) { ?>

		body #gform_wrapper_<?php echo $css_form_id ?> .gform_footer .gform_button,
		body #gform_wrapper_<?php echo $css_form_id ?> .gform_page_footer .gform_button,
		body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_page_footer .gform_next_button,
		body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_page_footer .gform_previous_button,
		body #gform_wrapper_<?php echo $css_form_id ?> .gfield#field_submit .gform-button {
			<?php echo 'border-style: solid;'; ?>
			<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'submit-button', $important ); ?>
			}
			
		body #gform_wrapper_<?php echo $css_form_id ?> .gform_footer button.mdc-button {
			<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'submit-button', $important ); ?>
		}

	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'text-fields', array( 'font-size-tab', 'max-width-tab', 'height-tab', 'line-height-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=text],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=email],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=tel],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=url],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=password],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=number] {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'text-fields', $important ); ?>
			}
	<?php } ?>

	<?php if ( ! empty( $get_form_options['text-fields']['max-width-tab'] ) ){ ?>
			body #gform_wrapper_<?php echo $css_form_id ?> div.ginput_complex.ginput_container.ginput_container_name,
			body #gform_wrapper_<?php echo $css_form_id ?> div.ginput_complex.ginput_container,
			body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container.ginput_container_list {
				width: <?php echo $get_form_options['text-fields']['max-width-tab'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['text-fields']['max-width-tab'] ) ?>;
				max-width:100%;
			}

			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container.ginput_container_name input[type=text],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container.ginput_container_name select,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container input[type="text"],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container input select,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_container.ginput_container_list input[type=text] {
				max-width:100%;
				width:100%;
			}

			body #gform_wrapper_<?php echo $css_form_id ?>.gform_wrapper .gform_body .gform_fields .gfield_time_ampm select {
				width: calc( 3rem + 20px );
			}
			body #gform_wrapper_<?php echo $css_form_id ?>.gform_wrapper .gform_body .gform_fields .gfield_time_hour input,
			body #gform_wrapper_<?php echo $css_form_id ?>.gform_wrapper .gform_body .gform_fields .gfield_time_minute input {
				width: calc( 3rem + 8px );
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'paragraph-textarea', array( 'max-width-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield textarea {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'paragraph-textarea', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'dropdown-fields', array( 'font-size-tab', 'max-width-tab', 'height-tab' ,'line-height-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield select {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'dropdown-fields', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'radio-inputs', array( 'font-size-tab', 'max-width-tab', 'line-height-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gfield_radio label {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'radio-inputs', $important ); ?>
				width: auto;
			}

			<?php if (! empty( $get_form_options['radio-inputs']['max-width-tab'] ) ) { ?>
				body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_radio .gfield_radio {
					width: <?php echo $get_form_options['radio-inputs']['max-width-tab'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['radio-inputs']['max-width-tab'] ) ?>;
				}
			<?php } ?>
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'checkbox-inputs', array( 'font-size-tab', 'max-width-tab', 'line-height-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gfield_checkbox label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_consent label {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'checkbox-inputs', $important ); ?>
				width: 100%;
			}

			<?php if ( ! empty( $get_form_options['checkbox-inputs']['max-width-tab'] ) ){ ?>
				body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_checkbox .gfield_checkbox,
				body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_consent {
					width: <?php echo $get_form_options['checkbox-inputs']['max-width-tab'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['checkbox-inputs']['max-width-tab'] ) ?>;
				}
			<?php } ?>
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'field-labels', array( 'font-size-tab', 'line-height-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_label {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'field-labels', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'field-descriptions', array( 'font-size-tab', 'line-height-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_description {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'field-descriptions', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options,'section-break-title' , array( 'font-size-tab', 'line-height-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gsection .gsection_title {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'section-break-title', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'section-break-description', array( 'font-size-tab', 'line-height-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gsection .gsection_description {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'section-break-description', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'confirmation-message', array( 'font-size-tab', 'max-width-tab', 'line-height-tab' ) ) ) { ?>
			body #gform_confirmation_message_<?php echo $css_form_id ?> {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'confirmation-message', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'error-message', array( 'font-size-tab', 'max-width-tab', 'line-height-tab' ) ) ) { ?>
		body #gform_wrapper_<?php echo $css_form_id ?> .validation_error,
		body #gform_wrapper_<?php echo $css_form_id ?> .gform_validation_errors{
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'error-message',$important ); ?>
			}

			body #gform_wrapper_<?php echo $css_form_id ?> .gform_validation_errors h2.gform_submission_error{

				<?php echo ! empty( $get_form_options['error-message']['font-size-tab'] ) ? 'font-size:'.$get_form_options['error-message']['font-size-tab'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['error-message']['font-size-tab']  ) .';' : ''; ?>

				<?php echo ! empty( $get_form_options['error-message']['line-height-tab'] ) ? 'line-height:'.$get_form_options['error-message']['line-height-tab'].';' : ''; ?>
			}
	<?php } ?>
	<?php if ( stla_isset_checker( $get_form_options, 'field-sub-labels', array( 'font-size-tab', 'line-height-tab' ) ) ) { ?>
		body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_complex .ginput_full label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_complex .ginput_right label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_complex .ginput_left label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .name_first label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .name_last label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_line_1 label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_line_2 label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_city label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_state label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_zip label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_country label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_time_hour label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_time_minute label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_date_month label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_date_day label,
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_date_year label{
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'field-sub-labels', $important ); ?>
			}
	<?php } ?>

	<?php if ( isset( $get_form_options['list-field-heading'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list .gfield_list .gfield_list_cell::after{
	<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'list-field-heading', $important ); ?>
	}
	<?php } ?>

	<?php if ( isset( $get_form_options['list-field-table'] ) ) { ?>
	body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list .gfield_list_groups .gfield_list_group{
		<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'list-field-table', $important ); ?>
	}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'list-field-cell', array( 'font-size-tab', 'line-height-tab' ) ) || stla_isset_checker( $get_form_options, 'list-field-heading', array( 'font-size-tab', 'line-height-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list .gfield_list .gfield_list_cell input {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'list-field-cell', $important ); ?>
			}
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list .gfield_list tbody .gfield_list_cell::after {
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'list-field-heading', $important ); ?>
			}
	<?php } ?> 

	<?php if ( stla_isset_checker( $get_form_options, 'placeholders', array( 'font-size-tab' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> ::-webkit-input-placeholder{   /* Chrome/Opera/Safari */
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'placeholders', $important ); ?>
			}  
			body #gform_wrapper_<?php echo $css_form_id ?> ::-moz-placeholder {  /* Firefox 19+ */
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'placeholders', $important ); ?>
			} 
			body #gform_wrapper_<?php echo $css_form_id ?> :-ms-input-placeholder {  /* IE 10+ */
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'placeholders', $important ); ?>
			} 
			body #gform_wrapper_<?php echo $css_form_id ?> :-moz-placeholder {   /* Firefox 18- */
				<?php echo $main_class_object->gf_sb_get_saved_styles_tab( $css_form_id, 'placeholders', $important ); ?>
			}
	<?php } ?>
}
/* Styling for phones */
@media only screen and ( max-width: 480px ) {
	<?php if ( stla_isset_checker( $get_form_options, 'form-wrapper', array( 'max-width-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> {
			<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'form-wrapper', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'form-title', array( 'font-size-phone', 'line-height-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_heading .gform_title {
			<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'form-title', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'form-description', array( 'font-size-phone', 'line-height-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_heading .gform_description {
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'form-description', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'submit-button', array( 'font-size-phone', 'max-width-phone', 'height-phone', 'line-height-phone' ) ) ) { ?>

			body #gform_wrapper_<?php echo $css_form_id ?> .gform_footer .gform_button,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_page_footer .gform_button,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_page_footer .gform_next_button,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_page_footer .gform_previous_button,
			body #gform_wrapper_<?php echo $css_form_id ?> .gfield#field_submit .gform-button{
				<?php echo 'border-style: solid;'; ?>
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'submit-button', $important ); ?>
			}

			body #gform_wrapper_<?php echo $css_form_id ?> .gform_footer button.mdc-button{
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'submit-button', $important ); ?>
			}
			
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'text-fields', array( 'font-size-phone', 'max-width-phone', 'height-phone','line-height-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=text],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=email],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=tel],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=url],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=password],
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield input[type=number] {
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'text-fields', $important ); ?>
			} 

			<?php if ( ! empty( $get_form_options['text-fields']['max-width-phone'] ) ) { ?>
					body #gform_wrapper_<?php echo $css_form_id ?> div.ginput_complex.ginput_container.ginput_container_name,
					body #gform_wrapper_<?php echo $css_form_id ?> div.ginput_complex.ginput_container,
					body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container.ginput_container_list {
						width: <?php echo $get_form_options['text-fields']['max-width-phone'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['text-fields']['max-width-phone'] ) ?>;
						max-width:100%;
					}

					body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container.ginput_container_name input[type=text],
					body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container.ginput_container_name select,
					body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container input[type="text"],
					body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields div.ginput_complex.ginput_container input select,
					body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_container.ginput_container_list input[type=text] {
						max-width:100%;
						width:100%
					}

					body #gform_wrapper_<?php echo $css_form_id ?>.gform_wrapper .gform_body .gform_fields .gfield_time_ampm select {
							width: calc( 3rem + 20px );
						}
						body #gform_wrapper_<?php echo $css_form_id ?>.gform_wrapper .gform_body .gform_fields .gfield_time_hour input,
						body #gform_wrapper_<?php echo $css_form_id ?>.gform_wrapper .gform_body .gform_fields .gfield_time_minute input {
								width: calc( 3rem + 8px );
						}
			<?php } ?>
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'paragraph-textarea', array( 'max-width-phone', 'line-height-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield textarea {
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'paragraph-textarea', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'dropdown-fields', array( 'font-size-phone', 'max-width-phone','height-phone', 'line-height-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield select {
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'dropdown-fields', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'radio-inputs', array( 'font-size-phone', 'max-width-phone' ), 'line-height-phone' ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gfield_radio label {
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'radio-inputs', $important ); ?>
				width: auto;
			}

			<?php if (! empty( $get_form_options['radio-inputs']['max-width-phone'] ) ) { ?>
					body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_radio .gfield_radio {
						width: <?php echo $get_form_options['radio-inputs']['max-width-phone'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['radio-inputs']['max-width-phone'] )?>; 
					}
			<?php } ?>
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'checkbox-inputs', array( 'font-size-phone', 'max-width-phone', 'line-height-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gfield_checkbox label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_consent label {
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'checkbox-inputs', $important ); ?>
			}
			<?php if ( ! empty( $get_form_options['checkbox-inputs']['max-width-phone'] ) ){ ?>
				body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_checkbox .gfield_checkbox,
				body #gform_wrapper_<?php echo $css_form_id ?> .gfield .ginput_container_consent {
					width: <?php echo $get_form_options['checkbox-inputs']['max-width-phone'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['checkbox-inputs']['max-width-phone'] )?>;
				}
			<?php } ?>
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'field-labels', array( 'font-size-phone', 'line-height-phone' ) ) ) { ?>
		body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_label {
			<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'field-labels', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'field-descriptions', array( 'font-size-phone', 'line-height-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_description {
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'field-descriptions', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'section-break-title', array( 'font-size-phone', 'line-height-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gsection .gsection_title {
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'section-break-title', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'section-break-description', array( 'font-size-phone', 'line-height-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gsection .gsection_description {
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'section-break-description', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'confirmation-message', array( 'font-size-phone','max-width-phone', 'line-height-phone' ) ) ) { ?>
		body #gform_confirmation_message_<?php echo $css_form_id ?> {
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'confirmation-message', $important ); ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'error-message', array( 'font-size-phone','max-width-phone', 'line-height-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .validation_error,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_validation_errors{
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'error-message', $important ); ?>
			}
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_validation_errors h2.gform_submission_error{

				<?php echo ! empty( $get_form_options['error-message']['font-size-phone'] ) ? 'font-size:'.$get_form_options['error-message']['font-size-phone'].$main_class_object->gf_stla_add_px_to_value( $get_form_options['error-message']['font-size-phone']  ) .';' : ''; ?>

				<?php echo ! empty( $get_form_options['error-message']['line-height-phone'] ) ? 'line-height:'.$get_form_options['error-message']['line-height-phone'].';' : ''; ?>
			}
	<?php } ?>

	<?php if ( stla_isset_checker( $get_form_options, 'field-sub-labels', array( 'font-size-phone', 'line-height-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_complex .ginput_full label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_complex .ginput_right label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_complex .ginput_left label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .name_first label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .name_last label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_line_1 label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_line_2 label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_city label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_state label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_zip label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .address_country label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_time_hour label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_time_minute label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_date_month label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_date_day label,
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .gfield_date_year label {
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'field-sub-labels', $important ); ?>
			}
	<?php } ?>

	<?php if ( isset( $get_form_options['list-field-heading'] ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list .gfield_list .gfield_list_cell::after {
				<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'list-field-heading', $important ); ?>
			}

			<?php if ( isset( $get_form_options['list-field-table'] ) ) { ?>
					body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list .gfield_list_group {
						<?php echo $main_class_object->gf_sb_get_saved_styles( $css_form_id, 'list-field-table', $important ); ?>
					}
			<?php } ?>

			<?php if ( stla_isset_checker( $get_form_options, 'list-field-cell', array( 'font-size-phone', 'line-height-phone' ) ) || stla_isset_checker( $get_form_options, 'list-field-heading', array( 'font-size-phone', 'line-height-phone' ) ) ) { ?>
					body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list table.gfield_list tbody tr td.gfield_list_cell input {
					<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'list-field-cell', $important ); ?>
				}

				body #gform_wrapper_<?php echo $css_form_id ?> .gform_body .gform_fields .gfield .ginput_list .gfield_list .gfield_list_cell::after {
					<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'list-field-heading', $important ); ?>
				}
			<?php } ?> 
	<?php } ?> 

	<?php if ( stla_isset_checker( $get_form_options, 'placeholders', array( 'font-size-phone' ) ) ) { ?>
			body #gform_wrapper_<?php echo $css_form_id ?> ::-webkit-input-placeholder {   /* Chrome/Opera/Safari */
					<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'placeholders', $important ); ?>
			}

			body #gform_wrapper_<?php echo $css_form_id ?> ::-moz-placeholder {  /* Firefox 19+ */
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'placeholders', $important ); ?>
			}

			body #gform_wrapper_<?php echo $css_form_id ?> :-ms-input-placeholder {  /* IE 10+ */
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'placeholders', $important ); ?>
			}

			body #gform_wrapper_<?php echo $css_form_id ?> :-moz-placeholder {   /* Firefox 18- */
				<?php echo $main_class_object->gf_sb_get_saved_styles_phone( $css_form_id, 'placeholders', $important ); ?>
			}
	<?php } ?>
}
<?php
	do_action( 'stla_add_custom_styles', $get_form_options, $main_class_object );
?>
/*Option to add custom CSS */
<?php
if ( stla_isset_checker( $get_form_options, 'general-settings', array( 'custom-css' ) ) ) {
    echo $get_form_options['general-settings']['custom-css'];
} ?>

</style>
<?php
$styles = ob_get_contents();
ob_end_clean();

// replacing empty spacing and line-breaks.
$styles = preg_replace('/\v(?:[\v\h]+)|(?:\t+)/', '', $styles);
echo $styles;


