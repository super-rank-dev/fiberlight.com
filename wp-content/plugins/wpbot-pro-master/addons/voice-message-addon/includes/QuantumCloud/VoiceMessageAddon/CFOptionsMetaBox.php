<?php
namespace QuantumCloud\VoiceMessageAddon;

use QuantumCloud\wpbotvoicemessage;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Class used to add contacter_form post type.
 *
 * @since 1.0.0
 **/
final class CFOptionsMetaBox {

	/**
	 * The one true CFOptionsMetaBox.
	 *
	 * @var CFOptionsMetaBox
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Sets up a new instance.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	private function __construct() {

	}

	/**
	 * Render "Options" metabox with all fields.
	 *
	 * @param $contacter_form - Post Object.
	 *
	 * @since 1.0.0
	 **/
	public function render_metabox( $contacter_form ) {

		/** Render Nonce field to validate on save. */
		$this->render_nonce();

		?>
		<div class="vmwbmdp-options-box">
			<table class="form-table">
				<tbody>
				<?php

				/** Render Before text field. */
				$this->before_text( $contacter_form );

				/** Render "Start recording" Button. */
				$this->start_recording( $contacter_form );

				/** Render After text field. */
				$this->after_text( $contacter_form );

				/** Render Speak Now text field. */
				$this->speak_now_text( $contacter_form );

				/** Render Send recording text field. */
				$this->send_text( $contacter_form );

				/** Render Thank you text field. */
				$this->thanks_text( $contacter_form );

				/** Render Additional Fields. */
				$this->additional_fields( $contacter_form );


				?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Save "Options" metabox with all fields.
	 *
	 * @param $post_id - Post Object.
	 * @since 1.0.0
	 **/
	public function save_metabox( $post_id ) {

		/** Options fields keys. */
		$k = [
			'vmwbmdp_before_txt', // Before Text.
			'vmwbmdp_align', // Align.
			'vmwbmdp_btn_margin', // Margin.
			'vmwbmdp_btn_padding', // Padding.
            'vmwbmdp_btn_radius', // Radius.
			'vmwbmdp_btn_icon', // Icon.
			'vmwbmdp_btn_icon_position', // Icon Position.
            'vmwbmdp_btn_caption', // Caption
            'vmwbmdp_btn_size', // Size
            'vmwbmdp_btn_color', // Text/Icon color.
            'vmwbmdp_btn_color_hover', // Text/Icon Hover color.
            'vmwbmdp_btn_bg_color', // Background color.
            'vmwbmdp_btn_bg_color_hover', // Background Hover color.
			'vmwbmdp_btn_hover_animation', // Hover Animations.
            'vmwbmdp_after_txt', // After Text.
			'vmwbmdp_speak_now_txt', // Speak Now message.
            'vmwbmdp_send_txt', // Send Recording message.
            'vmwbmdp_thanks_txt', // Thank You message.
            'vmwbmdp_additional_fields', // Additional Fields.
			'vmwbmdp_additional_fields_fb', // Form Builder fields.
			'vmwbmdp_additional_fields_res',
        ];

		/** Save each field. */
		foreach ( $k as $field ) {
			$value = ( isset( $_POST[$field] ) ? wp_kses_post( $_POST[$field] ) : '' );

			if ( in_array( $field, ['vmwbmdp_before_txt', 'vmwbmdp_after_txt', 'vmwbmdp_speak_now_txt', 'vmwbmdp_send_txt', 'vmwbmdp_thanks_txt'] ) AND $value === '' ) {
				$value = ' ';
			}

			update_post_meta( $post_id, $field, $value );
        }

    }

	/**
	 * Render Before text field.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function before_text( $contacter_form ) {

		/** Get Before Text field value from meta if it's already been entered. */
		$before_txt = get_post_meta( $contacter_form->ID, 'vmwbmdp_before_txt', true );

		/** Default value. */
		if ( empty( $before_txt ) ) {
			$before_txt = Settings::get_instance()->options['msg_before_txt'];
		}

		/** Empty field. */
		if ( ' ' === $before_txt ) {
			$before_txt = '';
		}

		?>
		<tr>
			<th scope="row">
				<label for="vmwbmdpbeforetxt"><?php esc_html_e( 'Before Text:', 'wpbotvoicemessage' ); ?></label>
			</th>
			<td>
				<?php wp_editor( $before_txt, 'vmwbmdpbeforetxt', ['textarea_rows' => 5, 'textarea_name' => 'vmwbmdp_before_txt'] ); ?>
				<p class="description"><?php esc_html_e( 'Enter text before "Start recording" button or leave blank to do not use the field.', 'wpbotvoicemessage' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Render Start Recording button fieldset.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function start_recording( $contacter_form ) {
		?>
        <tr>
            <th scope="row">
                <label for="vmwbmdpaftertxt"><?php esc_html_e( 'Start recording button:', 'wpbotvoicemessage' ); ?></label>
            </th>
            <td>
               <fieldset class="vmwbmdp-wpbotvoicemessage-start-btn-box">
                    <?php

                    /** Render Align. */
                    $this->align( $contacter_form );

                    /** Render Margin. */
                    $this->btn_margin( $contacter_form );

                    /** Render Padding. */
                    $this->btn_padding( $contacter_form );

                    /** Border Radius Padding. */
                    $this->btn_radius( $contacter_form );

                    /** Button Icon. */
                    $this->btn_icon( $contacter_form );

                    /** Button Icon Position. */
                    $this->btn_icon_position( $contacter_form );

                    /** Button Caption. */
                    $this->btn_caption( $contacter_form );

                    /** Icon/Font size. */
                    $this->btn_size( $contacter_form );

                    /** Button Text Color. */
                    $this->btn_color( $contacter_form );

                    /** Button Background Color. */
                    $this->btn_bg_color( $contacter_form );

                    /** Button Text Hover Color. */
                    $this->btn_color_hover( $contacter_form );

                    /** Button Background Color. */
                    $this->btn_bg_color_hover( $contacter_form );

                    /** Button Hover Animations. */
                    $this->btn_hover_animation( $contacter_form );

                    ?>
               </fieldset>
                <p class="description"><?php esc_html_e( 'Customize the Look & Feel of the "Start recording" button.', 'wpbotvoicemessage' ); ?></p>
            </td>
        </tr>
		<?php
    }

	/**
	 * Render Margin slider for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_margin( $contacter_form ) {

		/** Get Margin value from meta if it's already been entered. */
		$vmwbmdp_btn_margin = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_margin', true );

		/** Default value. */
		if ( $vmwbmdp_btn_margin === '' ) {
			$vmwbmdp_btn_margin = '10';
		}

        ?>
        <div class="vmwbmdp-control-field">
            <?php
            /** Margin slider. */
            UI::get_instance()->render_slider(
	            $vmwbmdp_btn_margin,
	            0,
	            100,
	            1,
	            esc_html__( 'Button Margin', 'wpbotvoicemessage' ),
	            esc_html__( 'Button margin: ', 'wpbotvoicemessage' ) .
	            '<strong>' . $vmwbmdp_btn_margin . '</strong>' .
	            esc_html__( ' px', 'wpbotvoicemessage' ),
	            [
		            'name' => 'vmwbmdp_btn_margin',
		            'id' => 'vmwbmdp_btn_margin',
	            ]
            );
            ?>
        </div>
        <?php
    }

	/**
	 * Render Icon/Caption size for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_size( $contacter_form ) {

		/** Get size value from meta if it's already been entered. */
		$vmwbmdp_btn_size = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_size', true );

		/** Default value. */
		if ( $vmwbmdp_btn_size === '' ) {
			$vmwbmdp_btn_size = '18';
		}

		?>
        <div class="vmwbmdp-control-field">
			<?php
			/** Icon/Caption size slider. */
			UI::get_instance()->render_slider(
				$vmwbmdp_btn_size,
				10,
				100,
				1,
				esc_html__( 'Size', 'wpbotvoicemessage' ),
				esc_html__( 'Icon/Caption size: ', 'wpbotvoicemessage' ) .
				'<strong>' . $vmwbmdp_btn_size . '</strong>' .
				esc_html__( ' px', 'wpbotvoicemessage' ),
				[
					'name' => 'vmwbmdp_btn_size',
					'id' => 'vmwbmdp_btn_size',
				]
			);
			?>
        </div>
		<?php
	}

	/**
	 * Render Padding slider for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_padding( $contacter_form ) {

		/** Get Padding value from meta if it's already been entered. */
		$vmwbmdp_btn_padding = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_padding', true );

		/** Default value. */
		if ( $vmwbmdp_btn_padding === '' ) {
			$vmwbmdp_btn_padding = '20';
		}

		?>
        <div class="vmwbmdp-control-field">
			<?php
			/** Padding slider. */
			UI::get_instance()->render_slider(
				$vmwbmdp_btn_padding,
				0,
				100,
				1,
				esc_html__( 'Button Padding', 'wpbotvoicemessage' ),
				esc_html__( 'Button padding: ', 'wpbotvoicemessage' ) .
				'<strong>' . $vmwbmdp_btn_padding . '</strong>' .
				esc_html__( ' px', 'wpbotvoicemessage' ),
				[
					'name' => 'vmwbmdp_btn_padding',
					'id' => 'vmwbmdp_btn_padding',
				]
			);
			?>
        </div>
		<?php
	}

	/**
	 * Render Border Radius slider for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_radius( $contacter_form ) {

		/** Get Radius value from meta if it's already been entered. */
		$vmwbmdp_btn_radius = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_radius', true );

		/** Default value. */
		if ( $vmwbmdp_btn_radius === '' ) {
			$vmwbmdp_btn_radius = '50';
		}

		?>
        <div class="vmwbmdp-control-field">
			<?php
			/** Radius slider. */
			UI::get_instance()->render_slider(
				$vmwbmdp_btn_radius,
				0,
				100,
				1,
				esc_html__( 'Button Radius', 'wpbotvoicemessage' ),
				esc_html__( 'Button radius: ', 'wpbotvoicemessage' ) .
				'<strong>' . $vmwbmdp_btn_radius . '</strong>' .
				esc_html__( ' px', 'wpbotvoicemessage' ),
				[
					'name' => 'vmwbmdp_btn_radius',
					'id' => 'vmwbmdp_btn_radius',
				]
			);
			?>
        </div>
		<?php
	}

	/**
	 * Render Button Icon for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_icon( $contacter_form ) {

		/** Get icon value from meta if it's already been entered. */
		$vmwbmdp_btn_icon = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_icon', true );

		/** Default value. */
		if ( '' === $vmwbmdp_btn_icon ) {
			$vmwbmdp_btn_icon = '_contacter/waves.svg';
		}

		/** We use this to detect empty icon and first time loading. */
		if ( ' ' === $vmwbmdp_btn_icon ) {
			$vmwbmdp_btn_icon = '';
		}

		?>
        <div class="vmwbmdp-control-field">
			<?php
			/** Button icon icon. */
			UI::get_instance()->render_icon(
				$vmwbmdp_btn_icon,
				'',
				esc_html__( 'Select icon for button', 'wpbotvoicemessage' ),
				[
					'name' => 'vmwbmdp_btn_icon',
					'id' => 'vmwbmdp_btn_icon'
				],
				[
					'_contacter.json',
					'font-awesome.json',
					'material.json',
				]
			);
			?>
        </div>
		<?php
	}

	/**
	 * Render Align for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function align( $contacter_form ) {

		/** Get align value from meta if it's already been entered. */
		$vmwbmdp_align = get_post_meta( $contacter_form->ID, 'vmwbmdp_align', true );

		/** Default value. */
		if ( $vmwbmdp_align === '' ) {
			$vmwbmdp_align = 'left';
		}

		/** Align options. */
		$options = [
			'none'      => esc_html__( 'None', 'wpbotvoicemessage' ),
			'left'      => esc_html__( 'Left', 'wpbotvoicemessage' ),
			'center'    => esc_html__( 'Center', 'wpbotvoicemessage' ),
			'right'     => esc_html__( 'Right', 'wpbotvoicemessage' ),
		];

		?><div class="vmwbmdp-control-field"><?php

		/** Render Align dropdown. */
		UI::get_instance()->render_select(
			$options,
			$vmwbmdp_align, // Selected option.
			esc_html__( 'Align', 'wpbotvoicemessage' ),
			esc_html__( 'Choose how to align the button and other form elements.', 'wpbotvoicemessage' ),
			[
				'name' => 'vmwbmdp_align',
				'id' => 'vmwbmdp_align'
			]
		);

		?></div><?php

	}

	/**
	 * Render Button Icon Position for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_icon_position( $contacter_form ) {

		/** Get icon position value from meta if it's already been entered. */
		$vmwbmdp_btn_icon_position = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_icon_position', true );

		/** Default value. */
		if ( $vmwbmdp_btn_icon_position === '' ) {
			$vmwbmdp_btn_icon_position = 'before';
		}

		/** Icon Position options. */
		$options = [
			'none'   => esc_html__( 'Hide', 'wpbotvoicemessage' ),
			'before' => esc_html__( 'Before', 'wpbotvoicemessage' ),
			'after'  => esc_html__( 'After', 'wpbotvoicemessage' ),
			'above'  => esc_html__( 'Above', 'wpbotvoicemessage' ),
			'bellow' => esc_html__( 'Bellow', 'wpbotvoicemessage' ),
		];

		?><div class="vmwbmdp-control-field"><?php

		/** Render Icon Position dropdown. */
		UI::get_instance()->render_select(
			$options,
			$vmwbmdp_btn_icon_position, // Selected option.
			esc_html__( 'Icon Position', 'wpbotvoicemessage' ),
			esc_html__( 'Position of the icon inside the button', 'wpbotvoicemessage' ),
			[
				'name' => 'vmwbmdp_btn_icon_position',
				'id' => 'vmwbmdp_btn_icon_position'
			]
		);

        ?></div><?php

    }

	/**
	 * Render Hover Animations for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_hover_animation( $contacter_form ) {

		/** Get hover animation value from meta if it's already been entered. */
		$vmwbmdp_btn_hover_animation = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_hover_animation', true );

		/** Default value. */
		if ( $vmwbmdp_btn_hover_animation === '' ) {
			$vmwbmdp_btn_hover_animation = 'none';
		}

		/** Hover Animations options. */
		$options = [
			'none'                  => esc_html__( 'None', 'wpbotvoicemessage' ),
			'fade'                  => esc_html__( 'Fade', 'wpbotvoicemessage' ),
			'bounce'                => esc_html__( 'Bounce', 'wpbotvoicemessage' ),
			'flip-x'                => esc_html__( 'Flip X', 'wpbotvoicemessage' ),
			'flip-y'                => esc_html__( 'Flip Y', 'wpbotvoicemessage' ),
			'scale'                 => esc_html__( 'Scale', 'wpbotvoicemessage' ),
			'wobble'                => esc_html__( 'Wobble', 'wpbotvoicemessage' ),
			'rotate'                => esc_html__( 'Rotate', 'wpbotvoicemessage' )
		];

		?><div class="vmwbmdp-control-field"><?php

		/** Render Hover Animations dropdown. */
		UI::get_instance()->render_select(
			$options,
			$vmwbmdp_btn_hover_animation, // Selected option.
			esc_html__( 'Hover animation', 'wpbotvoicemessage' ),
			esc_html__( 'Button hover animation', 'wpbotvoicemessage' ),
			[
				'name' => 'vmwbmdp_btn_hover_animation',
				'id' => 'vmwbmdp_btn_hover_animation'
			]
		);

		?></div><?php

	}

	/**
	 * Render Caption filed for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_caption( $contacter_form ) {

		/** Get Caption value from meta if it's already been entered. */
		$vmwbmdp_btn_caption = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_caption', true );

		/** Default value. */
		if ( $vmwbmdp_btn_caption === '' ) {
			$vmwbmdp_btn_caption = esc_html__( 'Record', 'wpbotvoicemessage' );
		}

		?>
        <div class="vmwbmdp-control-field">
			<?php
			/** Caption input. */
			UI::get_instance()->render_input(
				$vmwbmdp_btn_caption,
				esc_html__( 'Caption', 'wpbotvoicemessage' ),
				esc_html__( 'Start record button caption', 'wpbotvoicemessage' ),
				[
					'name' => 'vmwbmdp_btn_caption',
					'id' => 'vmwbmdp_btn_caption'
				]
			);
			?>
        </div>
		<?php
	}

	/**
	 * Render Text/Icon color for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_color( $contacter_form ) {

		/** Get Caption value from meta if it's already been entered. */
		$vmwbmdp_btn_color = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_color', true );

		/** Default value. */
		if ( $vmwbmdp_btn_color === '' ) {
			$vmwbmdp_btn_color = '#fff';
		}

		?>
        <div class="vmwbmdp-control-field">
			<?php
			/** Text/Icon Color colorpicker. */
			UI::get_instance()->render_colorpicker(
				$vmwbmdp_btn_color,
				esc_html__( 'Text Color', 'wpbotvoicemessage' ),
				esc_html__( 'Select icon and text color', 'wpbotvoicemessage' ),
				[
					'name' => 'vmwbmdp_btn_color',
					'id' => 'vmwbmdp_btn_color',
					'readonly' => 'readonly'
				]
			);
			?>
        </div>
		<?php
	}

	/**
	 * Render Text/Icon Hover color for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_color_hover( $contacter_form ) {

		/** Get Caption value from meta if it's already been entered. */
		$vmwbmdp_btn_color_hover = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_color_hover', true );

		/** Default value. */
		if ( $vmwbmdp_btn_color_hover === '' ) {
			$vmwbmdp_btn_color_hover = '#0274e6';
		}

		?>
        <div class="vmwbmdp-control-field">
			<?php
			/** Text/Icon Color colorpicker. */
			UI::get_instance()->render_colorpicker(
				$vmwbmdp_btn_color_hover,
				esc_html__( 'Text Hover Color', 'wpbotvoicemessage' ),
				esc_html__( 'Select icon and text hover color', 'wpbotvoicemessage' ),
				[
					'name' => 'vmwbmdp_btn_color_hover',
					'id' => 'vmwbmdp_btn_color_hover',
					'readonly' => 'readonly'
				]
			);
			?>
        </div>
		<?php
	}

	/**
	 * Render Background color for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_bg_color( $contacter_form ) {

		/** Get Caption value from meta if it's already been entered. */
		$vmwbmdp_btn_bg_color = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_bg_color', true );

		/** Default value. */
		if ( $vmwbmdp_btn_bg_color === '' ) {
			$vmwbmdp_btn_bg_color = '#0274e6';
		}

		?>
        <div class="vmwbmdp-control-field">
			<?php
			/** Text/Icon Color colorpicker. */
			UI::get_instance()->render_colorpicker(
				$vmwbmdp_btn_bg_color,
				esc_html__( 'Background Color', 'wpbotvoicemessage' ),
				esc_html__( 'Select button background color', 'wpbotvoicemessage' ),
				[
					'name' => 'vmwbmdp_btn_bg_color',
					'id' => 'vmwbmdp_btn_bg_color',
					'readonly' => 'readonly'
				]
			);
			?>
        </div>
		<?php
	}

	/**
	 * Render Background Hover color for Start button.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function btn_bg_color_hover( $contacter_form ) {

		/** Get Caption value from meta if it's already been entered. */
		$vmwbmdp_btn_bg_color_hover = get_post_meta( $contacter_form->ID, 'vmwbmdp_btn_bg_color_hover', true );

		/** Default value. */
		if ( $vmwbmdp_btn_bg_color_hover === '' ) {
			$vmwbmdp_btn_bg_color_hover = '#fff';
		}

		?>
        <div class="vmwbmdp-control-field">
			<?php
			/** Text/Icon Color colorpicker. */
			UI::get_instance()->render_colorpicker(
				$vmwbmdp_btn_bg_color_hover,
				esc_html__( 'Background Hover Color', 'wpbotvoicemessage' ),
				esc_html__( 'Select button background hover color', 'wpbotvoicemessage' ),
				[
					'name' => 'vmwbmdp_btn_bg_color_hover',
					'id' => 'vmwbmdp_btn_bg_color_hover',
					'readonly' => 'readonly'
				]
			);
			?>
        </div>
		<?php
	}

	/**
	 * Render After text field.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function after_text( $contacter_form ) {

		/** Get After Text field value from meta if it's already been entered. */
		$after_txt = get_post_meta( $contacter_form->ID, 'vmwbmdp_after_txt', true );

		/** Default value. */
		if ( empty( $after_txt ) ) {
			$after_txt = Settings::get_instance()->options['msg_after_txt'];
		}

		/** Empty field. */
		if ( ' ' === $after_txt ) {
			$after_txt = '';
		}
		?>
        <tr>
            <th scope="row">
                <label for="vmwbmdpaftertxt"><?php esc_html_e( 'After Text:', 'wpbotvoicemessage' ); ?></label>
            </th>
            <td>
				<?php wp_editor( $after_txt, 'vmwbmdpaftertxt', ['textarea_rows' => 5, 'textarea_name' => 'vmwbmdp_after_txt'] ); ?>
                <p class="description"><?php esc_html_e( 'Enter text after "Start recording" button or leave blank to do not use the field.', 'wpbotvoicemessage' ); ?></p>
            </td>
        </tr>
		<?php
	}

	/**
	 * Render Thank You message field.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function thanks_text( $contacter_form ) {

		/** Get Thank you Text field value from meta if it's already been entered. */
		$thanks_txt = get_post_meta( $contacter_form->ID, 'vmwbmdp_thanks_txt', true );

		/** Default value. */
		if ( empty( $thanks_txt ) ) {
			$thanks_txt = Settings::get_instance()->options['msg_thank_you'];
		}
		?>
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Thank You Text:', 'wpbotvoicemessage' ); ?></label>
            </th>
            <td>
				<?php wp_editor( $thanks_txt, 'vmwbmdpthankstxt', ['textarea_rows' => 5, 'textarea_name' => 'vmwbmdp_thanks_txt'] ); ?>
            </td>
        </tr>
		<?php
	}

	/**
	 * Render Send recording field.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function send_text( $contacter_form ) {

		/** Get Send Text field value from meta if it's already been entered. */
		$send_txt = get_post_meta( $contacter_form->ID, 'vmwbmdp_send_txt', true );

		/** Default value. */
		if ( empty( $send_txt ) ) {
			$send_txt = Settings::get_instance()->options['msg_send'];
		}
		?>
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Send Recording Text:', 'wpbotvoicemessage' ); ?></label>
            </th>
            <td>
				<?php wp_editor( $send_txt, 'vmwbmdpsendtxt', ['textarea_rows' => 5, 'textarea_name' => 'vmwbmdp_send_txt'] ); ?>
            </td>
        </tr>
		<?php
	}

	/**
	 * Render Speak Now field.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function speak_now_text( $contacter_form ) {

		/** Get Speak Now Text field value from meta if it's already been entered. */
		$speak_now_txt = get_post_meta( $contacter_form->ID, 'vmwbmdp_speak_now_txt', true );

		/** Default value. */
		if ( empty( $speak_now_txt ) ) {
			$speak_now_txt = Settings::get_instance()->options['msg_speak_now'];
		}
		?>
        <tr>
            <th scope="row">
                <label for="vmwbmdpaftertxt"><?php esc_html_e( 'Speak Now Text:', 'wpbotvoicemessage' ); ?></label>
            </th>
            <td>
				<?php wp_editor( $speak_now_txt, 'vmwbmdpspeaknowtxt', ['textarea_rows' => 5, 'textarea_name' => 'vmwbmdp_speak_now_txt'] ); ?>
                <p class="description"><?php esc_html_e( 'You can use special placeholders: {timer}, {max-duration}, {countdown}.', 'wpbotvoicemessage' ); ?></p>
            </td>
        </tr>
		<?php
	}

	/**
	 * Render Additional fields switcher.
	 *
	 * @param $contacter_form - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function additional_fields( $contacter_form ) {

		/** Get Additional fields switcher value from meta if it's already been entered. */
		$vmwbmdp_additional_fields = get_post_meta( $contacter_form->ID, 'vmwbmdp_additional_fields', true );
		$vmwbmdp_additional_fields_fb = get_post_meta( $contacter_form->ID, 'vmwbmdp_additional_fields_fb', true );
		$vmwbmdp_additional_fields_res = get_post_meta( $contacter_form->ID, 'vmwbmdp_additional_fields_res', true );

		/** Default value. Additional Fields switcher. */
		if ( '' === $vmwbmdp_additional_fields ) {
			$vmwbmdp_additional_fields = 'off';
		}

		/** Default value. Form in JSON. */
		if ( '' === $vmwbmdp_additional_fields_fb ) {
			$vmwbmdp_additional_fields_fb = '[{"type":"text","label":"First Name","placeholder":"Enter your first name","className":"vmwbmdp-form-control vmwbmdp-form-control-name","name":"vmwbmdp-wpbotvoicemessage-first-name","subtype":"text"},{"type":"text","subtype":"email","required":true,"label":"E-mail","placeholder":"Enter your e-mail","className":"vmwbmdp-form-control vmwbmdp-form-control-email","name":"vmwbmdp-wpbotvoicemessage-e-mail"}]';
		}

		/** Default value. Form in HTML. */
		if ( '' === $vmwbmdp_additional_fields_res ) {
			$vmwbmdp_additional_fields_res = '<div class="rendered-form"><div class="fb-text form-group field-first-name"><label for="first-name" class="fb-text-label">First Name</label></div><div class="fb-text form-group field-e-mail"><label for="e-mail" class="fb-text-label">E-mail<span class="fb-required">*</span></label></div></div>';
		}

		?>
        <tr>
            <th scope="row">
                <label for="vmwbmdpaftertxt"><?php esc_html_e( 'Additional fields:', 'wpbotvoicemessage' ); ?></label>
            </th>
            <td>
                <?php
                /** Render Additional fields switcher. */
                UI::get_instance()->render_switches(
	                $vmwbmdp_additional_fields,
	                esc_html__('Additional Fields', 'wpbotvoicemessage' ),
	                '',
	                [
		                'name' => 'vmwbmdp_additional_fields',
		                'id' => 'vmwbmdp_additional_fields'
	                ]
                );
                ?>
                <p class="description"><?php esc_html_e( 'Show to user a small form after recording a voice message.', 'wpbotvoicemessage' ); ?></p>

                <div class="vmwbmdp-form-builder-box">

                    <!--suppress HtmlFormInputWithoutLabel -->
                    <input name="vmwbmdp_additional_fields_fb"
                           type="hidden"
                           id="vmwbmdp_additional_fields_fb"
	                       value="<?php echo esc_attr_e( $vmwbmdp_additional_fields_fb ); ?>"
                    >
                    <!--suppress HtmlFormInputWithoutLabel -->
	                <input name="vmwbmdp_additional_fields_res"
	                       type="hidden"
	                       id="vmwbmdp_additional_fields_res"
	                       value="<?php esc_attr_e( $vmwbmdp_additional_fields_res ); ?>"
	                >
                    <div id="vmwbmdp-form-builder-editor"></div>

                </div>

            </td>
        </tr>
		<?php
	}

	/**
	 * Render Nonce field to validate form request came from current site.
	 *
	 * @since 1.0.0
	 **/
	private function render_nonce() {

		wp_nonce_field( wpbotvoicemessage::$basename, 'options_metabox_fields_nonce' );

	}

	/**
	 * Main CFOptionsMetaBox Instance.
	 *
	 * Insures that only one instance of CFOptionsMetaBox exists in memory at any one time.
	 *
	 * @static
	 * @return CFOptionsMetaBox
	 * @since 1.0.0
	 **/
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof CFOptionsMetaBox ) ) {
			self::$instance = new CFOptionsMetaBox;
		}

		return self::$instance;
	}
	
} // End Class CFOptionsMetaBox.
