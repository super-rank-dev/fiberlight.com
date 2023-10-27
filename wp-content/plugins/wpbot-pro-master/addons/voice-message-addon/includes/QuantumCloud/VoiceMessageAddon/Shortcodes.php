<?php
namespace QuantumCloud\VoiceMessageAddon;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Class used to implement shortcodes.
 *
 * @since 1.0.0
 **/
final class Shortcodes {

	/**
	 * The one true Shortcodes.
	 *
	 * @var Shortcodes
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Sets up a new Shortcodes instance.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	private function __construct() {

		/** Initializes plugin shortcodes. */
		add_action( 'init', [$this, 'shortcodes_init'] );

	}

	/**
	 * Initializes shortcodes.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 **/
	public function shortcodes_init() {

		/** Add plugin shortcode [wpbotvoicemessage id=""]. Works everywhere on site. */
		add_shortcode( 'wpbotvoicemessage', [ $this, 'contacter_shortcode' ] );

		/** Add plugin shortcode [wpbotvoicemessage-click id=""]Your Content[/wpbotvoicemessage-click]. Works everywhere on site. */
		add_shortcode( 'wpbotvoicemessage-click', [ $this, 'contacter_click_shortcode' ] );


	}

	/**
	 * Add plugin shortcode [wpbotvoicemessage-click id=""]Your Content[/wpbotvoicemessage-click].
	 *
	 * @param array $atts - Shortcodes attributes.
	 *
	 * @param       $content
	 *
	 * @since  1.0.5
	 * @access public
	 * @return string
	 **/
	public function contacter_click_shortcode( $atts, $content ) {

		/** Filter shortcode attributes. */
		$atts = shortcode_atts( [
			'id' => '',
			'title' => ''
		], $atts );

		/** Nothing to show without any parameters. */
		if ( '' === $atts['id'] && '' === $atts['title'] ) { return ''; }

		/** We can't show anything without content. */
		if ( ! $content ) { return ''; }

		/** Unique id for current shortcode. */
		$id = $this->get_shortcode_id( $atts );

		/** Get VoiceMessageAddon form data. */
		$c_form = $this->get_cform( $atts );

		/** VoiceMessageAddon form not found. */
		if ( ! $c_form ) { return ''; }

		/** VoiceMessageAddon form not published. */
		if ( 'publish' !== $c_form->post_status) { return ''; }

		/** Enqueue styles and scripts only if shortcode used on this page. */
		$this->enqueue( $id, $c_form );

		/** Get align. */
		$vmwbmdp_align = get_post_meta( $c_form->ID, 'vmwbmdp_align', true );

		ob_start();

		?>

        <!-- Start VoiceMessageAddon WordPress Plugin -->
        <div id="<?php esc_attr_e( $id ); ?>"
             class="vmwbmdp-wpbotvoicemessage-form-box vmwbmdp-step-start vmwbmdp-align-<?php esc_attr_e( $vmwbmdp_align ); ?>"
             cform-name="<?php esc_attr_e( $c_form->post_title ); ?>"
             cform-id="<?php esc_attr_e( $c_form->ID ); ?>"
             max-duration="<?php esc_attr_e( Settings::get_instance()->options['max_duration'] ); ?>"
        >

	        <?php $this->render_custom_content_start_box( $c_form, $content ); // Start Recording Step with custom content. ?>

			<?php $this->render_allow_access_box(); // Allow access to microphone step. ?>

			<?php $this->render_mic_access_err_box( $c_form ); // Microphone access error step. ?>

			<?php $this->render_recording_box( $c_form ); // Speak Now Step. ?>

			<?php $this->render_reset_box( $c_form ); // Reset Step. ?>

			<?php $this->render_error_box(); // Error Step. ?>

			<?php $this->render_send_box( $c_form ); // Send Step. ?>

			<?php $this->render_thanks_box( $c_form ); // Thank You Step. ?>

        </div>
        <!-- End VoiceMessageAddon WordPress Plugin -->
		<?php

		return ob_get_clean();

	    return $content;
    }

	/**
	 * Add VoiceMessageAddon by shortcode [wpbotvoicemessage].
	 *
	 * @param array $atts - Shortcodes attributes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 **/
	public function contacter_shortcode( $atts = [] ) {

		/** Filter shortcode attributes. */
		$atts = shortcode_atts( [
			'id' => '',
			'title' => ''
		], $atts );

		/** Nothing to show without any parameters. */
		if ( '' === $atts['id'] && '' === $atts['title'] ) { return ''; }

		/** Unique id for current shortcode. */
		$id = $this->get_shortcode_id( $atts );

		/** Get VoiceMessageAddon form data. */
		$c_form = $this->get_cform( $atts );

		/** VoiceMessageAddon form not found. */
		if ( ! $c_form ) { return ''; }

		/** VoiceMessageAddon form not published. */
        if ( 'publish' !== $c_form->post_status) { return ''; }

		/** Enqueue styles and scripts only if shortcode used on this page. */
		$this->enqueue( $id, $c_form );

		/** Get align. */
		$vmwbmdp_align = get_post_meta( $c_form->ID, 'vmwbmdp_align', true );

		ob_start();

		?>

		<!-- Start VoiceMessageAddon WordPress Plugin -->
		<div id="<?php esc_attr_e( $id ); ?>"
             class="vmwbmdp-wpbotvoicemessage-form-box vmwbmdp-step-start vmwbmdp-align-<?php esc_attr_e( $vmwbmdp_align ); ?>"
             cform-name="<?php esc_attr_e( $c_form->post_title ); ?>"
             cform-id="<?php esc_attr_e( $c_form->ID ); ?>"
             max-duration="<?php esc_attr_e( Settings::get_instance()->options['max_duration'] ); ?>"
        >

            <?php $this->render_start_box( $c_form ); // Start Recording Step. ?>

			<?php $this->render_allow_access_box(); // Allow access to microphone step. ?>

			<?php $this->render_mic_access_err_box( $c_form ); // Microphone access error step. ?>

			<?php $this->render_recording_box( $c_form ); // Speak Now Step. ?>

			<?php $this->render_reset_box( $c_form ); // Reset Step. ?>

			<?php $this->render_error_box(); // Error Step. ?>

			<?php $this->render_send_box( $c_form ); // Send Step. ?>

			<?php $this->render_thanks_box( $c_form ); // Thank You Step. ?>

		</div>
		<!-- End VoiceMessageAddon WordPress Plugin -->
		<?php

		return ob_get_clean();

	}

	/**
	 * Render Thank You Step.
	 *
	 * @param object $c_form - current VoiceMessageAddon Form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 **/
	private function render_thanks_box( $c_form ) {

		$thanks_txt = get_post_meta( $c_form->ID, 'vmwbmdp_thanks_txt', true );
		?>
		<div class="vmwbmdp-wpbotvoicemessage-thanks-box">
			<?php echo wp_kses_post( $thanks_txt ); ?>
            <button class="vmwbmdp-restart"><span><?php esc_html_e( 'Start a New Message', 'wpbotvoicemessage' ); ?></span></button>
        </div>
		<?php
	}

	/**
	 * Render Send Step.
	 *
	 * @param object $c_form - current VoiceMessageAddon Form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 **/
	private function render_send_box( $c_form ) {

	    /** Get Additional fields. */
        $send_txt = get_post_meta( $c_form->ID, 'vmwbmdp_send_txt', true );
		$additional_fields = get_post_meta( $c_form->ID, 'vmwbmdp_additional_fields', true );
		$fields_res = get_post_meta( $c_form->ID, 'vmwbmdp_additional_fields_res', true );

		?>
		<div class="vmwbmdp-wpbotvoicemessage-send-box">
            <?php if ( 'on' === $additional_fields ) : ?><form novalidate=""><?php endif; ?>

                <?php echo wp_kses_post( $send_txt ); ?>
                <div class="vmwbmdp-wpbotvoicemessage-player-box"></div>

                <?php if ( 'on' === Settings::get_instance()->options['show_download_link'] ) : ?>
                    <p class="vmwbmdp-wpbotvoicemessage-download-link-box">
                        <a href="#"><?php esc_html_e( Settings::get_instance()->options['download_link_text'] ); ?></a>
                    </p>
                <?php endif; ?>

		        <?php if ( 'on' === $additional_fields ) : ?>
                    <div class="vmwbmdp-wpbotvoicemessage-additional-fields"
                         additional-fields="<?php esc_attr_e( $fields_res ); ?>"
                         user-login="<?php esc_attr_e( wp_get_current_user()->user_login ); ?>"
                         user-ip="<?php esc_attr_e( $this->get_real_ip() ); ?>"
                    ></div>
                <?php endif; ?>

                <div class="vmwbmdp-send-btns vmwbmdp-hover-<?php esc_attr_e( get_post_meta( $c_form->ID, 'vmwbmdp_btn_hover_animation', true ) ) ?>">
                    <button class="vmwbmdp-send-rec-btn"><span><?php esc_html_e( 'Send', 'wpbotvoicemessage' ); ?></span></button>
                    <button class="vmwbmdp-reset-rec-btn"><span><?php esc_html_e( 'Reset', 'wpbotvoicemessage' ); ?></span></button>
                </div>

			<?php if ( 'on' === $additional_fields ) : ?></form><?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Return real user IP.
	 *
	 * @since  1.0.5
	 * @access public
	 * @return string
	 **/
	private function get_real_ip() {

		/** Check ip from share internet. */
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {

			$ip = $_SERVER['HTTP_CLIENT_IP'];

        /** To check ip is pass from proxy. */
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

		} else {

			$ip = $_SERVER['REMOTE_ADDR'];

		}

		return $ip;

	}

	/**
	 * Render Error Step.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 **/
	private function render_error_box() {
		?>
		<div class="vmwbmdp-wpbotvoicemessage-error-box">
			<?php echo wp_kses_post( Settings::get_instance()->options['msg_sending_error'] ); ?>
		</div>
		<?php
	}

	/**
	 * Render Reset Step.
	 *
	 * @param object $c_form - current VoiceMessageAddon Form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 **/
	private function render_reset_box( $c_form ) {
		?>
		<div class="vmwbmdp-wpbotvoicemessage-reset-box vmwbmdp-hover-<?php esc_attr_e( get_post_meta( $c_form->ID, 'vmwbmdp_btn_hover_animation', true ) ) ?>">
			<?php echo wp_kses_post( Settings::get_instance()->options['msg_reset_recording'] ); ?>
			<div class="vmwbmdp-speak-now-btns">
				<button class="vmwbmdp-reset-rec-yes"><span><?php esc_html_e( 'Reset', 'wpbotvoicemessage' ); ?></span></button>
				<button class="vmwbmdp-reset-rec-no"><span><?php esc_html_e( 'Resume', 'wpbotvoicemessage' ); ?></span></button>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Speak Now Step.
	 *
	 * @param object $c_form - current VoiceMessageAddon Form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 **/
	private function render_recording_box( $c_form ) {
		?>
		<div class="vmwbmdp-wpbotvoicemessage-recording-box">
			<?php
			/** Get Speak Now content. */
			$vmwbmdp_speak_now_msg = get_post_meta( $c_form->ID, 'vmwbmdp_speak_now_txt', true );

			/** Replace {timer} {max-duration} {countdown} placeholders. */
			$vmwbmdp_speak_now_msg = $this->replace_placeholders( $vmwbmdp_speak_now_msg );

			/** Show Speak Now content. */
			echo wp_kses_post( $vmwbmdp_speak_now_msg );
			?>
            <div class="vmwbmdp-wpbotvoicemessage-recording-animation">
                <canvas width="384" height="60">
                    <div><?php esc_html_e( 'Canvas not available.', 'wpbotvoicemessage' ); ?></div>
                </canvas>
            </div>
			<div class="vmwbmdp-speak-now-btns vmwbmdp-hover-<?php esc_attr_e( get_post_meta( $c_form->ID, 'vmwbmdp_btn_hover_animation', true ) ) ?>">
				<button class="vmwbmdp-stop-rec-btn"><span><?php esc_html_e( 'Stop', 'wpbotvoicemessage' ); ?></span></button>
				<button class="vmwbmdp-reset-rec-btn"><span><?php esc_html_e( 'Pause', 'wpbotvoicemessage' ); ?></span></button>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Microphone access error Step.
	 *
	 * @param object $c_form - current VoiceMessageAddon Form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 **/
	private function render_mic_access_err_box( $c_form ) {
		?>
        <div class="vmwbmdp-wpbotvoicemessage-mic-access-err-box">
			<?php echo wp_kses_post( Settings::get_instance()->options['msg_mic_access_err'] ); ?>
            <div class="vmwbmdp-speak-now-btns vmwbmdp-hover-<?php esc_attr_e( get_post_meta( $c_form->ID, 'vmwbmdp_btn_hover_animation', true ) ) ?>">
                <button class="vmwbmdp-mic-access-err-reload-btn"><span><?php esc_html_e( 'Try again', 'wpbotvoicemessage' ); ?></span></button>
            </div>
        </div>
		<?php
	}

	/**
	 * Render Allow access to microphone Step.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 **/
	private function render_allow_access_box() {
        ?>
        <div class="vmwbmdp-wpbotvoicemessage-allow-access-box">
            <?php echo wp_kses_post( Settings::get_instance()->options['msg_allow_access'] ); ?>
        </div>
        <?php
    }

    private function render_custom_content_start_box( $c_form, $content ) {

	    /** Get Start Box Settings. */
	    $vmwbmdp_before_txt = get_post_meta( $c_form->ID, 'vmwbmdp_before_txt', true );
	    $vmwbmdp_after_txt = get_post_meta( $c_form->ID, 'vmwbmdp_after_txt', true );

	    ?>
        <div class="vmwbmdp-wpbotvoicemessage-start-box">
		    <?php if ( $vmwbmdp_before_txt ) : ?>
                <div class="vmwbmdp-wpbotvoicemessage-before-txt"><?php echo wp_kses_post( $vmwbmdp_before_txt ); ?></div>
		    <?php endif; ?>

            <div class="vmwbmdp-wpbotvoicemessage-start-btn-box">
                <div class="vmwbmdp-wpbotvoicemessage-start-btn vmwbmdp-wpbotvoicemessage-custom">
                    <?php echo wp_kses_post( $content ); ?>
                </div>
            </div>

		    <?php if ( $vmwbmdp_after_txt ) : ?>
                <div class="vmwbmdp-wpbotvoicemessage-after-txt"><?php echo wp_kses_post( $vmwbmdp_after_txt ); ?></div>
		    <?php endif; ?>
        </div>
	    <?php

    }

	/**
	 * Render Start Recording Step.
	 *
	 * @param object $c_form - current VoiceMessageAddon Form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 **/
	private function render_start_box( $c_form ) {

		/** Get Start Box Settings. */
		$vmwbmdp_before_txt = get_post_meta( $c_form->ID, 'vmwbmdp_before_txt', true );
		$vmwbmdp_after_txt = get_post_meta( $c_form->ID, 'vmwbmdp_after_txt', true );
		$vmwbmdp_btn_caption = get_post_meta( $c_form->ID, 'vmwbmdp_btn_caption', true );
		$vmwbmdp_btn_icon = get_post_meta( $c_form->ID, 'vmwbmdp_btn_icon', true );
		$vmwbmdp_btn_icon_position = get_post_meta( $c_form->ID, 'vmwbmdp_btn_icon_position', true );
		$vmwbmdp_btn_hover_animation = get_post_meta( $c_form->ID, 'vmwbmdp_btn_hover_animation', true );

		?>
		<div class="vmwbmdp-wpbotvoicemessage-start-box">
			<?php if ( $vmwbmdp_before_txt ) : ?>
				<div class="vmwbmdp-wpbotvoicemessage-before-txt"><?php echo wp_kses_post( $vmwbmdp_before_txt ); ?></div>
			<?php endif; ?>

			<div class="vmwbmdp-wpbotvoicemessage-start-btn-box vmwbmdp-hover-<?php esc_attr_e( $vmwbmdp_btn_hover_animation ); ?>">
				<button class="vmwbmdp-wpbotvoicemessage-start-btn vmwbmdp-icon-position-<?php esc_attr_e( $vmwbmdp_btn_icon_position ); ?>">

					<?php if ( $vmwbmdp_btn_icon_position !== 'none' ) : ?>
						<span class="vmwbmdp-wpbotvoicemessage-start-btn-icon"><?php Helper::get_instance()->inline_svg_e( $vmwbmdp_btn_icon ); ?></span>
					<?php endif; ?>

					<?php if ( $vmwbmdp_btn_caption ) : ?>
						<span class="vmwbmdp-wpbotvoicemessage-start-btn-caption"><?php echo wp_kses_post( $vmwbmdp_btn_caption ); ?></span>
					<?php endif; ?>

				</button>
			</div>

			<?php if ( $vmwbmdp_after_txt ) : ?>
				<div class="vmwbmdp-wpbotvoicemessage-after-txt"><?php echo wp_kses_post( $vmwbmdp_after_txt ); ?></div>
			<?php endif; ?>
		</div>
		<?php

	}

	/**
	 * Enqueue styles and scripts only if shortcode used on this page.
	 *
	 * @param string $id - current shortcode id.
	 * @param object $c_form - current VoiceMessageAddon Form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 **/
	private function enqueue( $id, $c_form ) {

		/** Enqueue styles only if shortcode used on this page. */
		wp_enqueue_style( 'vmwbmdp-wpbotvoicemessage' );

		/** Enqueue JavaScript only if shortcode used on this page. */
		wp_enqueue_script( 'vmwbmdp-wpbotvoicemessage-recorder' );
		wp_enqueue_script( 'vmwbmdp-wpbotvoicemessage' );

		/** Get inline CSS for current shortcode. */
		$css = $this->get_shortcode_inline_css( $id, $c_form );

		/** Add inline styles.. */
		wp_add_inline_style( 'vmwbmdp-wpbotvoicemessage', $css );

	}

	/**
	 * Return inline css styles for current shortcode.
	 *
	 * @param string $id - current shortcode id.
	 * @param object $c_form - current VoiceMessageAddon Form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string - inline css styles.
	 */
	private function get_shortcode_inline_css( $id, $c_form ) {

		/** Get VoiceMessageAddon Form params. */
		$btn_caption = get_post_meta( $c_form->ID, 'vmwbmdp_btn_caption', true );
		$btn_margin = get_post_meta( $c_form->ID, 'vmwbmdp_btn_margin', true );
		$btn_padding = get_post_meta( $c_form->ID, 'vmwbmdp_btn_padding', true );
		$btn_radius = get_post_meta( $c_form->ID, 'vmwbmdp_btn_radius', true );
		$btn_color = get_post_meta( $c_form->ID, 'vmwbmdp_btn_color', true );
		$btn_color_hover = get_post_meta( $c_form->ID, 'vmwbmdp_btn_color_hover', true );
		$btn_bg_color = get_post_meta( $c_form->ID, 'vmwbmdp_btn_bg_color', true );
		$btn_bg_color_hover = get_post_meta( $c_form->ID, 'vmwbmdp_btn_bg_color_hover', true );
		$btn_size = get_post_meta( $c_form->ID, 'vmwbmdp_btn_size', true );

		/** If button have caption make it rectangle. */
		if ( $btn_caption ) {
			$btn_padding = "calc({$btn_padding}px / 2) {$btn_padding}px";

		/** Else make it square. */
		} else {
			$btn_padding = "{$btn_padding}px";
		}

		// language=CSS
		/** @noinspection CssUnusedSymbol */
		/** @noinspection PhpUnnecessaryLocalVariableInspection */
		$css = "
		    #{$id} .vmwbmdp-wpbotvoicemessage-start-btn:not(.vmwbmdp-wpbotvoicemessage-custom),
		    #{$id} .vmwbmdp-speak-now-btns button,
		    #{$id} .vmwbmdp-wpbotvoicemessage-thanks-box button,
		    #{$id} .vmwbmdp-send-btns button {
		        margin: {$btn_margin}px;
		        padding: {$btn_padding};
                border-radius: {$btn_radius}px;
                color: {$btn_color};
                background: {$btn_bg_color}; 
		    }
		    
		    #{$id} .vmwbmdp-wpbotvoicemessage-start-btn:not(.vmwbmdp-wpbotvoicemessage-custom):hover,
		    #{$id} .vmwbmdp-wpbotvoicemessage-start-btn:not(.vmwbmdp-wpbotvoicemessage-custom):hover svg,
		    #{$id} .vmwbmdp-speak-now-btns button:hover,
		    #{$id} .vmwbmdp-wpbotvoicemessage-thanks-box button:hover,
		    #{$id} .vmwbmdp-send-btns button:hover {
                fill: {$btn_color_hover};
                color: {$btn_color_hover};
                background: {$btn_bg_color_hover}; 
		    }
		    
		    #{$id} .vmwbmdp-wpbotvoicemessage-start-btn.vmwbmdp-wpbotvoicemessage-custom { cursor: pointer; }
		    
		    #{$id} .vmwbmdp-wpbotvoicemessage-start-btn-icon svg {
		        width: {$btn_size}px;
                height: {$btn_size}px;
                fill: {$btn_color};
		    }
		    
		    #{$id} .vmwbmdp-wpbotvoicemessage-start-btn .vmwbmdp-wpbotvoicemessage-start-btn-caption {
		        font-size: {$btn_size}px;
		        line-height: 1.3;
		    }

		";

		return $css;
	}

	/**
	 * Return VoiceMessageAddon Form object.
	 *
	 * @param array $atts - Shortcodes attributes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object - VoiceMessageAddon Form
	 **/
	private function get_cform( $atts ) {

		/** Get VoiceMessageAddon form data. */
		if ( ! empty( $atts['id'] ) ) {
			$c_form = get_post( $atts['id'] );
		} else {
			$c_form = get_page_by_title( $atts['title'], 'OBJECT', VoiceForm::POST_TYPE );
		}

		return $c_form;
	}

	/**
	 * Return unique id for current shortcode.
	 *
	 * @param array $atts - Shortcodes attributes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 **/
	private function get_shortcode_id( $atts ) {

		/** $call_count will be initialized on the first time call. */
		static $call_count = 0;

		/** call_count will be incremented each time the method gets called. */
		$call_count ++;

		return 'vmwbmdp-wpbotvoicemessage-' . md5( json_encode( $atts ) ) . '-' . $call_count;

	}

	/**
	 * Replace {timer} {max-duration} {countdown} placeholders.
	 *
	 * @param string $message - Content for Speak Now step.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 **/
	private function replace_placeholders( $message ) {

		/** Replace {timer}. */
		$timer   = '<p class="vmwbmdp-wpbotvoicemessage-recording-timer">00:00</p>';
		$message = str_replace( '{timer}', $timer, $message );

		/** Replace {countdown}. */
		$countdown   = '<p class="vmwbmdp-wpbotvoicemessage-recording-countdown">00:00</p>';
		$message = str_replace( '{countdown}', $countdown, $message );

		/** Replace {max-duration}. */
		$max_duration = Settings::get_instance()->options['max_duration'];
        if ( '0' === $max_duration ) { $max_duration = '∞'; }
		$max_duration_msg =
			'<p class="vmwbmdp-wpbotvoicemessage-recording-max-duration">' .
                esc_html__( 'Max duration', 'wpbotvoicemessage' ) .
				' <strong>' . $max_duration . '</strong> '.
				esc_html__( 'seconds', 'wpbotvoicemessage' ) .
            '</p>';
		$message          = str_replace( '{max-duration}', $max_duration_msg, $message );

		return $message;
	}

	/**
	 * Main Shortcodes Instance.
	 *
	 * Insures that only one instance of Shortcodes exists in memory at any one time.
	 *
	 * @static
	 * @return Shortcodes
	 * @since 1.0.0
	 **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

} // End Class Shortcodes.
