<?php
/**
 * Controls and settings for error messages.
 */

// Start of section.
$wp_customize->add_section(
	'gf_stla_form_id_error_message',
	array(
		'title' => 'Error Message',
		'panel' => 'gf_stla_panel',
	)
);

// label.
$wp_customize->add_control(
	new WP_Customize_Label_Only(
		$wp_customize, // WP_Customize_Manager.
		'gf_stla_form_id_' . $current_form_id . '[error-message][max-width-label-only]', // Setting id.
		array( // Args, including any custom ones.
			'label'    => __( 'Width' ),
			'section'  => 'gf_stla_form_id_error_message',
			'settings' => array(),
		)
	)
);

/* for pc */
$wp_customize->add_setting(
	'gf_stla_form_id_' . $current_form_id . '[error-message][max-width]',
	array(
		'default'   => '',
		'transport' => 'refresh',
		'type'      => 'option',
	)
);

$wp_customize->add_control(
	new Stla_Desktop_Text_Input_Option(
		$wp_customize,
		'gf_stla_form_id_' . $current_form_id . '[error-message][max-width]',
		array(
			'type'        => 'text',
			'priority'    => 10, // Within the section.
			'section'     => 'gf_stla_form_id_error_message', // Required, core or custom.
			'label'       => __( '' ),
			'input_attrs' => array(
				'placeholder' => 'Ex: 400px',
			),
		)
	)
);
	/* for tablet */
$wp_customize->add_setting(
	'gf_stla_form_id_' . $current_form_id . '[error-message][max-width-tab]',
	array(
		'default'   => '',
		'transport' => 'refresh',
		'type'      => 'option',
	)
);

$wp_customize->add_control(
	new Stla_Tab_Text_Input_Option(
		$wp_customize,
		'gf_stla_form_id_' . $current_form_id . '[error-message][max-width-tab]',
		array(
			'type'        => 'text',
			'priority'    => 10, // Within the section.
			'section'     => 'gf_stla_form_id_error_message', // Required, core or custom.
			'label'       => __( '' ),
			'input_attrs' => array(
				'placeholder' => 'Ex: 400px',
			),
		)
	)
);

	/* for mobile */
$wp_customize->add_setting(
	'gf_stla_form_id_' . $current_form_id . '[error-message][max-width-phone]',
	array(
		'default'   => '',
		'transport' => 'refresh',
		'type'      => 'option',
	)
);

$wp_customize->add_control(
	new Stla_Mobile_Text_Input_Option(
		$wp_customize,
		'gf_stla_form_id_' . $current_form_id . '[error-message][max-width-phone]',
		array(
			'type'        => 'text',
			'priority'    => 10, // Within the section.
			'section'     => 'gf_stla_form_id_error_message', // Required, core or custom.
			'label'       => __( '' ),
			'input_attrs' => array(
				'placeholder' => 'Ex: 400px',
			),
		)
	)
);

// Font style buttons.
$wp_customize->add_setting(
	'gf_stla_form_id_' . $current_form_id . '[error-message][font-style]',
	array(
		'default'   => 'bold',
		'transport' => 'postMessage',
		'type'      => 'option',
	)
);

$wp_customize->add_control(
	new Stla_Font_Style_Option(
		$wp_customize,
		'gf_stla_form_id_' . $current_form_id . '[error-message][font-style]',
		array(
			'label'   => 'Font Style',
			'section' => 'gf_stla_form_id_error_message',
			'type'    => 'font_style',
			'choices' => $font_style_choices,
		)
	)
);

// Font align style buttons.
$wp_customize->add_setting(
	'gf_stla_form_id_' . $current_form_id . '[error-message][text-align]',
	array(
		'default'   => '',
		'transport' => 'postMessage',
		'type'      => 'option',
	)
);

$wp_customize->add_control(
	new Stla_Text_Alignment_Option(
		$wp_customize,
		'gf_stla_form_id_' . $current_form_id . '[error-message][text-align]',
		array(
			'label'   => 'ERROR MESSAGE Font Alignment',
			'section' => 'gf_stla_form_id_error_message',
			'type'    => 'text_alignment',
			'choices' => $align_pos,
		)
	)
);

/*
Start of Section
*/
// label.
$wp_customize->add_control(
	new WP_Customize_Label_Only(
		$wp_customize, // WP_Customize_Manager.
		'gf_stla_form_id_' . $current_form_id . '[error-message][font-size-label-only]', // Setting id.
		array( // Args, including any custom ones.
			'label'    => __( 'Font Size' ),
			'section'  => 'gf_stla_form_id_error_message',
			'settings' => array(),
		)
	)
);

// For Desktop.
$wp_customize->add_setting(
	'gf_stla_form_id_' . $current_form_id . '[error-message][font-size]',
	array(
		'default'   => '',
		'transport' => 'refresh',
		'type'      => 'option',
	)
);

$wp_customize->add_control(
	new Stla_Desktop_Text_Input_Option(
		$wp_customize,
		'gf_stla_form_id_' . $current_form_id . '[error-message][font-size]',
		array(
			'type'        => 'text',
			'priority'    => 10, // Within the section.
			'section'     => 'gf_stla_form_id_error_message', // Required, core or custom.
			'label'       => __( '' ),
			'input_attrs' => array(
				'placeholder' => 'Ex: 40px',
			),
		)
	)
);

// For Tablets.
		$wp_customize->add_setting(
			'gf_stla_form_id_' . $current_form_id . '[error-message][font-size-tab]',
			array(
				'default'   => '',
				'transport' => 'refresh',
				'type'      => 'option',
			)
		);

		$wp_customize->add_control(
			new Stla_Tab_Text_Input_Option(
				$wp_customize,
				'gf_stla_form_id_' . $current_form_id . '[error-message][font-size-tab]',
				array(
					'type'        => 'text',
					'priority'    => 10, // Within the section.
					'section'     => 'gf_stla_form_id_error_message', // Required, core or custom.
					'label'       => __( '' ),
					'input_attrs' => array(
						'placeholder' => 'Ex: 40px',
					),
				)
			)
		);

		// For mobile.
		$wp_customize->add_setting(
			'gf_stla_form_id_' . $current_form_id . '[error-message][font-size-phone]',
			array(
				'default'   => '',
				'transport' => 'refresh',
				'type'      => 'option',
			)
		);

		$wp_customize->add_control(
			new Stla_Mobile_Text_Input_Option(
				$wp_customize,
				'gf_stla_form_id_' . $current_form_id . '[error-message][font-size-phone]',
				array(
					'type'        => 'text',
					'priority'    => 10, // Within the section.
					'section'     => 'gf_stla_form_id_error_message', // Required, core or custom.
					'label'       => __( '' ),
					'input_attrs' => array(
						'placeholder' => 'Ex: 40px',
					),
				)
			)
		);

		/*
		Start of Section
		*/
		// Line height label.
		$wp_customize->add_control(
			new WP_Customize_Label_Only(
				$wp_customize, // WP_Customize_Manager.
				'gf_stla_form_id_' . $current_form_id . '[error-message][line-height-label-only]', // Setting id.
				array( // Args, including any custom ones.
					'label'    => __( 'Line Height' ),
					'section'  => 'gf_stla_form_id_error_message',
					'settings' => array(),
				)
			)
		);
		// For PC.
		$wp_customize->add_setting(
			'gf_stla_form_id_' . $current_form_id . '[error-message][line-height]',
			array(
				'default'   => '',
				'transport' => 'refresh',
				'type'      => 'option',
			)
		);

		$wp_customize->add_control(
			new Stla_Desktop_Text_Input_Option(
				$wp_customize,
				'gf_stla_form_id_' . $current_form_id . '[error-message][line-height]',
				array(
					'type'        => 'text',
					'priority'    => 10, // Within the section.
					'section'     => 'gf_stla_form_id_error_message', // Required, core or custom.
					'label'       => __( '' ),
					'input_attrs' => array(
						'placeholder' => 'Ex: 40px',
					),
				)
			)
		);
		// For Tablet.
		$wp_customize->add_setting(
			'gf_stla_form_id_' . $current_form_id . '[error-message][line-height-tab]',
			array(
				'default'   => '',
				'transport' => 'refresh',
				'type'      => 'option',
			)
		);

		$wp_customize->add_control(
			new Stla_Tab_Text_Input_Option(
				$wp_customize,
				'gf_stla_form_id_' . $current_form_id . '[error-message][line-height-tab]',
				array(
					'type'        => 'text',
					'priority'    => 10, // Within the section.
					'section'     => 'gf_stla_form_id_error_message', // Required, core or custom.
					'label'       => __( '' ),
					'input_attrs' => array(
						'placeholder' => 'Ex: 40px',
					),
				)
			)
		);


		// Form Mobile.
		$wp_customize->add_setting(
			'gf_stla_form_id_' . $current_form_id . '[error-message][line-height-phone]',
			array(
				'default'   => '',
				'transport' => 'refresh',
				'type'      => 'option',
			)
		);

		$wp_customize->add_control(
			new Stla_Mobile_Text_Input_Option(
				$wp_customize,
				'gf_stla_form_id_' . $current_form_id . '[error-message][line-height-phone]',
				array(
					'type'        => 'text',
					'priority'    => 10, // Within the section.
					'section'     => 'gf_stla_form_id_error_message', // Required, core or custom.
					'label'       => __( '' ),
					'input_attrs' => array(
						'placeholder' => 'Ex: 40px',
					),
				)
			)
		);

		/* Start of Section */
		$wp_customize->add_setting( 'gf_stla_form_id_'.$current_form_id.'[error-message][font-color]' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'type' => 'option'
		) );
		
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, // WP_Customize_Manager
				'gf_stla_form_id_'.$current_form_id.'[error-message][font-color]', // Setting id
				array( // Args, including any custom ones.
					'label' => __( 'Font Color' ),
					'section' => 'gf_stla_form_id_error_message',
				)
			)
  		);

		/*
		Start of Section
		*/
		// Label.
		$wp_customize->add_control(
			new WP_Customize_Label_Only(
				$wp_customize, // WP_Customize_Manager.
				'gf_stla_form_id_' . $current_form_id . '[error-message][border-label-only]', // Setting id.
				array( // Args, including any custom ones.
					'label'    => __( 'Error Message Border' ),
					'section'  => 'gf_stla_form_id_error_message',
					'settings' => array(),
				)
			)
		);

		$wp_customize->add_setting(
			'gf_stla_form_id_' . $current_form_id . '[error-message][border-size]',
			array(
				'default'   => '1px',
				'transport' => 'postMessage',
				'type'      => 'option',
			)
		);

		$wp_customize->add_control(
			'gf_stla_form_id_' . $current_form_id . '[error-message][border-size]',
			array(
				'type'        => 'text',
				'priority'    => 10, // Within the section.
				'section'     => 'gf_stla_form_id_error_message', // Required, core or custom.
				'label'       => __( 'Size' ),
				'input_attrs' => array(
					'placeholder' => 'Example: 4px or 10%',
				),
			)
		);

		// Start of Section.
		$wp_customize->add_setting(
			'gf_stla_form_id_' . $current_form_id . '[error-message][border-type]',
			array(
				'default'   => 'solid',
				'transport' => 'postMessage',
				'type'      => 'option',
			)
		);

		$wp_customize->add_control(
			'gf_stla_form_id_' . $current_form_id . '[error-message][border-type]',
			array(
				'type'     => 'select',
				'priority' => 10, // Within the section.
				'section'  => 'gf_stla_form_id_error_message', // Required, core or custom.
				'label'    => __( 'Type' ),
				'choices'  => $border_types,
			)
		);

		/* Start of Section */
		$wp_customize->add_setting( 'gf_stla_form_id_'.$current_form_id.'[error-message][border-radius]',
			array(
				'default'     => '',
				'transport'   => 'postMessage',
				'type' => 'option'
			) 
		);
		
		$wp_customize->add_control('gf_stla_form_id_'.$current_form_id.'[error-message][border-radius]',
			array(
				'type' => 'text',
				'priority' => 10, // Within the section.
				'section' => 'gf_stla_form_id_error_message', // Required, core or custom.
				'label' => __( 'Radius' ),
				'input_attrs' => array(
					'placeholder' => 'Example: 4px or 10%'
				)
			)
		);

		/* Start of Section */
		$wp_customize->add_setting( 'gf_stla_form_id_'.$current_form_id.'[error-message][border-color]',
			array(
				'default'     => '',
				'transport'   => 'postMessage',
				'type' => 'option'
			) 
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, // WP_Customize_Manager
				'gf_stla_form_id_'.$current_form_id.'[error-message][border-color]', // Setting id
				array( // Args, including any custom ones.
					'label' => __( 'Border Color' ),
					'section' => 'gf_stla_form_id_error_message',
				)
			)
		);

		// Start of Section.
		$wp_customize->add_setting(
			'gf_stla_form_id_' . $current_form_id . '[error-message][background-color]',
			array(
				'default'   => '',
				'transport' => 'postMessage',
				'type'      => 'option',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, // WP_Customize_Manager.
				'gf_stla_form_id_' . $current_form_id . '[error-message][background-color]', // Setting id.
				array( // Args, including any custom ones.
					'label'   => __( 'Background Color' ),
					'section' => 'gf_stla_form_id_error_message',
				)
			)
		);

		// Start of Section.
		// Label.
		$wp_customize->add_control(
			new WP_Customize_Label_Only(
				$wp_customize, // WP_Customize_Manager.
				'gf_stla_form_id_' . $current_form_id . '[error-message][padding-label-only]', // Setting id.
				array( // Args, including any custom ones.
					'label'    => __( 'Error message Padding' ),
					'section'  => 'gf_stla_form_id_error_message',
					'settings' => array(),
				)
			)
		);
		stla_margin_padding_controls( $wp_customize, $current_form_id, 'gf_stla_form_id_error_message', 'error-message', 'padding' );
