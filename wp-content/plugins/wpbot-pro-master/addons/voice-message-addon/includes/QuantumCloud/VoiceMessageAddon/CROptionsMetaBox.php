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
final class CROptionsMetaBox {

	/**
	 * The one true CROptionsMetaBox.
	 *
	 * @var CROptionsMetaBox
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
	 * @param $qcldwpbot_record - Post Object.
	 *
	 * @since 1.0.0
	 **/
	public function render_metabox( $qcldwpbot_record ) {

		/** Render Nonce field to validate on save. */
		$this->render_nonce();

		?>
		<div class="vmwbmdp-options-box">
			<table class="form-table">
				<tbody>
				<?php

				/** Render Player field. */
				$this->render_player( $qcldwpbot_record );

				/** Render Transcription text field. */
				$speech_recognition = 'on' === Settings::get_instance()->options['speech_recognition'];
				$dnd_api_key = Settings::get_instance()->options['dnd-api-key'];
				if ( $speech_recognition && $dnd_api_key ) {
					//$this->render_transcription( $qcldwpbot_record );
				}

				/** Render Additional fields field. */
				$this->additional_fields( $qcldwpbot_record );

				?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Save all metabox with all fields.
	 *
	 * @param $post_id - Post Object.
	 * @since 1.0.0
	 **/
	public function save_metabox( $post_id ) {

		/** Options fields keys. */
		$k = [
			'vmwbmdp_transcription_txt', // Transcription.
			'vmwbmdp_notes_txt', // Notes Text.
        ];

		/** Save each field. */
		foreach ( $k as $field ) {
			$value = ( isset( $_POST[$field] ) ? wp_kses_post( $_POST[$field] ) : '' );
			update_post_meta( $post_id, $field, $value );
        }

    }

	/**
	 * Render Player field.
	 *
	 * @param $qcldwpbot_record - Current VoiceMessageAddon Record Object.
	 *
	 * @since 1.0.0
	 **/
	public function render_player( $qcldwpbot_record ) {

	    /** Get Audio path value from meta if it's exist. */
		$audio_path = get_post_meta( $qcldwpbot_record->ID, 'qcld_wpvm_vmwbmdp_contacter_audio', true );
		if ( empty( $audio_path ) ) { return; }

		?>
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Voice Message:', 'wpbotvoicemessage' ); ?></label>
            </th>
            <td>
                <div>
                    <?php $audio_url = $this->abs_path_to_url( $audio_path ); ?>
		            <?php echo do_shortcode( '[audio src="' . $audio_url . '"]' ); ?>
                    <div class="vmwbmdp-wpbotvoicemessage-audio-info">
                        <span class="dashicons dashicons-download" title="<?php esc_html_e( 'Download audio', 'wpbotvoicemessage' ); ?>"></span>
                        <a href="<?php echo esc_url( $audio_url ); ?>" download=""><?php esc_html_e( 'Download audio', 'wpbotvoicemessage' ); ?></a>
                    </div>
                </div>
            </td>
        </tr>
		<?php

    }

	/**
	 * Return wav file duration 00:00.
     * @todo: sometimes returns incorrect time.
	 *
	 * @param string $file - Full Path to file.
	 * @since 1.0.0
	 * @return string|null
	 **/
	public function get_wav_duration( $file ) {

		$fp = fopen( $file, 'r' );

		if ( fread( $fp, 4 ) == "RIFF" ) {

			fseek( $fp, 20 );
			$raw_header = fread( $fp, 16 );

			/** @noinspection SpellCheckingInspection */
			$header = unpack( 'vtype/vchannels/Vsamplerate/Vbytespersec/valignment/vbits', $raw_header );
			$pos = ftell( $fp );

			while ( fread( $fp, 4 ) != "data" && ! feof( $fp ) ) {
				$pos ++;
				fseek( $fp, $pos );
			}

			$raw_header = fread( $fp, 4 );

			/** @noinspection SpellCheckingInspection */
			$data = unpack( 'Vdatasize', $raw_header );

			/** @noinspection SpellCheckingInspection */
			$sec = $data[ 'datasize' ] / $header[ 'bytespersec' ];

			$minutes = (int) ( ( $sec / 60 ) % 60 );
			$seconds = (int) ( $sec % 60 );

			return str_pad( $minutes, 2, "0", STR_PAD_LEFT ) . ":" . str_pad( $seconds, 2, "0", STR_PAD_LEFT );

		}

		return null;

	}

	/**
	 * Convert the file path to URL of the same file.
	 *
	 * @param string $path - Full Path to file.
	 * @since 1.0.0
	 * @return string
	 **/
	public function abs_path_to_url( $path = '' ) {

		$url = str_replace(
			wp_normalize_path( untrailingslashit( ABSPATH ) ),
			site_url(),
			wp_normalize_path( $path )
		);

		return esc_url_raw( $url );
	}

	/**
	 * Render Transcription text field.
	 *
	 * @param $qcldwpbot_record - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function render_transcription( $qcldwpbot_record ) {

		/** Get Transcription Text field value from meta if it's already been entered. */
		$transcription = get_post_meta( $qcldwpbot_record->ID, 'vmwbmdp_transcription_txt', true );

		/** Default value. */
		if ( empty( $transcription ) ) { $transcription = ''; }
		?>
		<tr>
			<th scope="row">
				<label for="vmwbmdpbeforetxt"><?php esc_html_e( 'Transcription:', 'wpbotvoicemessage' ); ?></label>
			</th>
			<td>
                <button class="vmwbmdp-generate-transcription-btn"><?php esc_html_e( 'Generate Transcription', 'wpbotvoicemessage' ); ?></button>
				<?php wp_editor( $transcription, 'vmwbmdptranscriptiontxt', [
				        'media_buttons' => 0,
				        'teeny' => 1,
				        'textarea_rows' => 5,
                        'textarea_name' => 'vmwbmdp_transcription_txt'
                ] ); ?>
				<p class="description"><?php esc_html_e( 'Press "Generate Transcription" button to generate or refresh transcription.', 'wpbotvoicemessage' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Render Additional fields value.
	 *
	 * @param $qcldwpbot_record - Current VoiceMessageAddon Form Object.
	 *
	 * @since 1.0.0
	 **/
	private function additional_fields( $qcldwpbot_record ) {

		/** Get Additional fields switcher value from meta if it's already been entered. */
		$vmwbmdp_additional_fields = get_post_meta( $qcldwpbot_record->ID, 'vmwbmdp_additional_fields', true );

		/** Default value. Additional Fields switcher. */
		if ( '' === $vmwbmdp_additional_fields ) {
			$vmwbmdp_additional_fields = '';
		}

		$fields = json_decode( $vmwbmdp_additional_fields, true );
		if ( count( $fields ) === 0 ) { return; }
		?>
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Additional fields:', 'wpbotvoicemessage' ); ?></label>
            </th>
            <td>
                <div class="vmwbmdp-additional-fields-box">
                    <table>
                    <?php
                    foreach ( $fields as $key => $field  ) {
	                    ?>
                        <tr class="<?php esc_attr_e( $key ); ?>">
                            <td><strong><?php esc_html_e( $field['label'] ); ?>:</strong></td>
                            <td>
                                <?php if ( is_array( $field['value'] ) ) : ?>
                                    <ul>
                                    <?php foreach ( $field['value'] as $v ) : ?>
                                        <li><span><?php esc_html_e( $v ); ?></span></li>
                                    <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <span><?php esc_html_e( $field['value'] ); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </table>
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
	 * Main CROptionsMetaBox Instance.
	 *
	 * Insures that only one instance of CROptionsMetaBox exists in memory at any one time.
	 *
	 * @static
	 * @return CROptionsMetaBox
	 * @since 1.0.0
	 **/
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof CROptionsMetaBox ) ) {
			self::$instance = new CROptionsMetaBox;
		}

		return self::$instance;
	}
	
} // End Class CROptionsMetaBox.
