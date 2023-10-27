<?php
namespace QuantumCloud\VoiceMessageAddon;

use QuantumCloud\wpbotvoicemessage;
use WP_Query;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Class used to render plugin settings fields.
 *
 * @since 1.0.0
 **/
final class SettingsFields {

	/**
	 * The one true SettingsFields.
	 *
	 * @var SettingsFields
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Render Download Link Text field.
	 *
	 * @since 1.0.6
	 * @access public
	 **/
	public static function download_link_text() {

		/** Render Show Download Link switcher. */
		UI::get_instance()->render_input(
			Settings::get_instance()->options['download_link_text'],
			esc_html__('Download Link Text', 'wpbotvoicemessage' ),
			esc_html__( 'Text for download link.', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_settings[download_link_text]',
				'id' => 'vmwbmdp-wpbotvoicemessage-settings-download-link-text'
			]
		);

	}

	/**
	 * Render Show Download Link field.
	 *
	 * @since 1.0.5
	 * @access public
	 **/
	public static function show_download_link() {

		/** Render Show Download Link switcher. */
		UI::get_instance()->render_switches(
			Settings::get_instance()->options['show_download_link'],
			esc_html__('Show Download Link', 'wpbotvoicemessage' ),
			esc_html__( 'Show download link to audio on frontend.', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_settings[show_download_link]',
				'id' => 'vmwbmdp-wpbotvoicemessage-settings-show-download-link'
			]
		);

    }

	/**
	 * Render Speech Recognition field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function speech_recognition() {

		if ( defined('PHP_MAJOR_VERSION') && PHP_MAJOR_VERSION >= 7 ) {

			/** Render Speech Recognition switcher. */
			UI::get_instance()->render_switches(
				Settings::get_instance()->options['speech_recognition'],
				esc_html__('Enable Speech Recognition', 'wpbotvoicemessage' ),
				esc_html__( 'Convert audio to text by applying powerful neural network models.', 'wpbotvoicemessage' ),
				[
					'name' => 'qcld_wpvm_vmwbmdp_contacter_settings[speech_recognition]',
					'id' => 'qcld_wpvm_vmwbmdp_contacter_settings_speech_recognition'
				]
			);

		} else {
		    ?>
            <div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent"
                 xmlns="http://www.w3.org/1999/html">
                <?php esc_html_e( 'This functionality requires PHP 7 or higher.', 'wpbotvoicemessage' ); ?>
            </div>
            <?php
        }

	}

	/**
	 * Render Drag & Drop API Key field.
	 *
	 * @since 1.0.5
	 * @access public
	 **/
	public static function dnd_api_key() {

		$key_exist = false;
		if ( Settings::get_instance()->options['dnd-api-key'] ) { $key_exist = true; }

		?>
        <div class="vmwbmdp-dnd">
            <!--suppress HtmlFormInputWithoutLabel -->
            <div class="mdc-text-field mdc-input-width mdc-text-field--outlined mdc-hidden">
                <!--suppress HtmlFormInputWithoutLabel -->
                <input  type="text"
                        class="mdc-text-field__input"
                        name="qcld_wpvm_vmwbmdp_contacter_settings[dnd-api-key]"
                        id="vmwbmdp-wpbotvoicemessage-settings-dnd-api-key"
                        value="<?php esc_attr_e( Settings::get_instance()->options['dnd-api-key'] ); ?>"
                >
                <div class="mdc-notched-outline mdc-notched-outline--upgraded mdc-notched-outline--notched">
                    <div class="mdc-notched-outline__leading"></div>
                    <div class="mdc-notched-outline__notch">
                        <label for="vmwbmdp-wpbotvoicemessage-settings-dnd-api-key" class="mdc-floating-label mdc-floating-label--float-above"><?php esc_html_e( 'API Key', 'wpbotvoicemessage' ); ?></label>
                    </div>
                    <div class="mdc-notched-outline__trailing"></div>
                </div>
            </div>
            <div id="vmwbmdp-api-key-drop-zone" class="<?php if ( $key_exist ) : ?>vmwbmdp-key-uploaded<?php endif; ?>">
				<?php if ( $key_exist ) : ?>
                <span class="material-icons">check_circle_outline</span><?php esc_html_e( 'API Key file exist', 'wpbotvoicemessage' ); ?>
                <span class="vmwbmdp-drop-zone-hover"><?php esc_html_e( 'Drop Key file here or click to upload', 'wpbotvoicemessage' ); ?></span>
				<?php else : ?>
                    <span class="material-icons">cloud</span><?php esc_html_e( 'Drop Key file here or click to upload.', 'wpbotvoicemessage' ); ?>
				<?php endif; ?>
            </div>
            <?php if ( $key_exist ) : ?>
            <div class="vmwbmdp-messages mdc-text-field-helper-line mdc-text-field-helper-text mdc-text-field-helper-text--persistent">
                <?php esc_html_e( 'Drag and drop or click on the form to replace API key. |', 'wpbotvoicemessage' ); ?>
                <a href="#" class="vmwbmdp-wpbotvoicemessage-reset-key-btn"><?php esc_html_e( 'Reset API Key', 'wpbotvoicemessage' ); ?></a>
            </div>
            <?php else : ?>
            <div class="vmwbmdp-messages mdc-text-field-helper-line mdc-text-field-helper-text mdc-text-field-helper-text--persistent">
	            <?php esc_html_e( 'Drag and drop or click on the form to add API key.', 'wpbotvoicemessage' ); ?>
            </div>
            <?php endif; ?>
            <input id="vmwbmdp-dnd-file-input" type="file" name="name" class="mdc-hidden" />
        </div>
		<?php

	}

	/**
	 * Render Language field.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @noinspection SpellCheckingInspection
	 **/
	public static function language() {

		/** Prepare languages list. */
		$options = [
			'af-ZA'=> esc_html__( 'Afrikaans (Suid-Afrika)', 'wpbotvoicemessage' ),
			'am-ET'=> esc_html__( 'አማርኛ (ኢትዮጵያ)', 'wpbotvoicemessage' ),
			'hy-AM'=> esc_html__( 'Հայ (Հայաստան)', 'wpbotvoicemessage' ),
			'az-AZ'=> esc_html__( 'Azərbaycan (Azərbaycan)', 'wpbotvoicemessage' ),
			'id-ID'=> esc_html__( 'Bahasa Indonesia (Indonesia)', 'wpbotvoicemessage' ),
			'ms-MY'=> esc_html__( 'Bahasa Melayu (Malaysia)', 'wpbotvoicemessage' ),
			'bn-BD'=> esc_html__( 'বাংলা (বাংলাদেশ)', 'wpbotvoicemessage' ),
			'bn-IN'=> esc_html__( 'বাংলা (ভারত)', 'wpbotvoicemessage' ),
			'ca-ES'=> esc_html__( 'Català (Espanya)', 'wpbotvoicemessage' ),
			'cs-CZ'=> esc_html__( 'Čeština (Česká republika)', 'wpbotvoicemessage' ),
			'da-DK'=> esc_html__( 'Dansk (Danmark)', 'wpbotvoicemessage' ),
			'de-DE'=> esc_html__( 'Deutsch (Deutschland)', 'wpbotvoicemessage' ),
			'en-AU'=> esc_html__( 'English (Australia)', 'wpbotvoicemessage' ),
			'en-CA'=> esc_html__( 'English (Canada)', 'wpbotvoicemessage' ),
			'en-GH'=> esc_html__( 'English (Ghana)', 'wpbotvoicemessage' ),
			'en-GB'=> esc_html__( 'English (Great Britain)', 'wpbotvoicemessage' ),
			'en-IN'=> esc_html__( 'English (India)', 'wpbotvoicemessage' ),
			'en-IE'=> esc_html__( 'English (Ireland)', 'wpbotvoicemessage' ),
			'en-KE'=> esc_html__( 'English (Kenya)', 'wpbotvoicemessage' ),
			'en-NZ'=> esc_html__( 'English (New Zealand)', 'wpbotvoicemessage' ),
			'en-NG'=> esc_html__( 'English (Nigeria)', 'wpbotvoicemessage' ),
			'en-PH'=> esc_html__( 'English (Philippines)', 'wpbotvoicemessage' ),
			'en-SG'=> esc_html__( 'English (Singapore)', 'wpbotvoicemessage' ),
			'en-ZA'=> esc_html__( 'English (South Africa)', 'wpbotvoicemessage' ),
			'en-TZ'=> esc_html__( 'English (Tanzania)', 'wpbotvoicemessage' ),
			'en-US'=> esc_html__( 'English (United States)', 'wpbotvoicemessage' ),
			'es-AR'=> esc_html__( 'Español (Argentina)', 'wpbotvoicemessage' ),
			'es-BO'=> esc_html__( 'Español (Bolivia)', 'wpbotvoicemessage' ),
			'es-CL'=> esc_html__( 'Español (Chile)', 'wpbotvoicemessage' ),
			'es-CO'=> esc_html__( 'Español (Colombia)', 'wpbotvoicemessage' ),
			'es-CR'=> esc_html__( 'Español (Costa Rica)', 'wpbotvoicemessage' ),
			'es-EC'=> esc_html__( 'Español (Ecuador)', 'wpbotvoicemessage' ),
			'es-SV'=> esc_html__( 'Español (El Salvador)', 'wpbotvoicemessage' ),
			'es-ES'=> esc_html__( 'Español (España)', 'wpbotvoicemessage' ),
			'es-US'=> esc_html__( 'Español (Estados Unidos)', 'wpbotvoicemessage' ),
			'es-GT'=> esc_html__( 'Español (Guatemala)', 'wpbotvoicemessage' ),
			'es-HN'=> esc_html__( 'Español (Honduras)', 'wpbotvoicemessage' ),
			'es-MX'=> esc_html__( 'Español (México)', 'wpbotvoicemessage' ),
			'es-NI'=> esc_html__( 'Español (Nicaragua)', 'wpbotvoicemessage' ),
			'es-PA'=> esc_html__( 'Español (Panamá)', 'wpbotvoicemessage' ),
			'es-PY'=> esc_html__( 'Español (Paraguay)', 'wpbotvoicemessage' ),
			'es-PE'=> esc_html__( 'Español (Perú)', 'wpbotvoicemessage' ),
			'es-PR'=> esc_html__( 'Español (Puerto Rico)', 'wpbotvoicemessage' ),
			'es-DO'=> esc_html__( 'Español (República Dominicana)', 'wpbotvoicemessage' ),
			'es-UY'=> esc_html__( 'Español (Uruguay)', 'wpbotvoicemessage' ),
			'es-VE'=> esc_html__( 'Español (Venezuela)', 'wpbotvoicemessage' ),
			'eu-ES'=> esc_html__( 'Euskara (Espainia)', 'wpbotvoicemessage' ),
			'fil-PH'=> esc_html__( 'Filipino (Pilipinas)', 'wpbotvoicemessage' ),
			'fr-CA'=> esc_html__( 'Français (Canada)', 'wpbotvoicemessage' ),
			'fr-FR'=> esc_html__( 'Français (France)', 'wpbotvoicemessage' ),
			'gl-ES'=> esc_html__( 'Galego (España)', 'wpbotvoicemessage' ),
			'ka-GE'=> esc_html__( 'ქართული (საქართველო)', 'wpbotvoicemessage' ),
			'gu-IN'=> esc_html__( 'ગુજરાતી (ભારત)', 'wpbotvoicemessage' ),
			'hr-HR'=> esc_html__( 'Hrvatski (Hrvatska)', 'wpbotvoicemessage' ),
			'zu-ZA'=> esc_html__( 'IsiZulu (Ningizimu Afrika)', 'wpbotvoicemessage' ),
			'is-IS'=> esc_html__( 'Íslenska (Ísland)', 'wpbotvoicemessage' ),
			'it-IT'=> esc_html__( 'Italiano (Italia)', 'wpbotvoicemessage' ),
			'jv-ID'=> esc_html__( 'Jawa (Indonesia)', 'wpbotvoicemessage' ),
			'kn-IN'=> esc_html__( 'ಕನ್ನಡ (ಭಾರತ)', 'wpbotvoicemessage' ),
			'km-KH'=> esc_html__( 'ភាសាខ្មែរ (កម្ពុជា)', 'wpbotvoicemessage' ),
			'lo-LA'=> esc_html__( 'ລາວ (ລາວ)', 'wpbotvoicemessage' ),
			'lv-LV'=> esc_html__( 'Latviešu (latviešu)', 'wpbotvoicemessage' ),
			'lt-LT'=> esc_html__( 'Lietuvių (Lietuva)', 'wpbotvoicemessage' ),
			'hu-HU'=> esc_html__( 'Magyar (Magyarország)', 'wpbotvoicemessage' ),
			'ml-IN'=> esc_html__( 'മലയാളം (ഇന്ത്യ)', 'wpbotvoicemessage' ),
			'mr-IN'=> esc_html__( 'मराठी (भारत)', 'wpbotvoicemessage' ),
			'nl-NL'=> esc_html__( 'Nederlands (Nederland)', 'wpbotvoicemessage' ),
			'ne-NP'=> esc_html__( 'नेपाली (नेपाल)', 'wpbotvoicemessage' ),
			'nb-NO'=> esc_html__( 'Norsk bokmål (Norge)', 'wpbotvoicemessage' ),
			'pl-PL'=> esc_html__( 'Polski (Polska)', 'wpbotvoicemessage' ),
			'pt-BR'=> esc_html__( 'Português (Brasil)', 'wpbotvoicemessage' ),
			'pt-PT'=> esc_html__( 'Português (Portugal)', 'wpbotvoicemessage' ),
			'ro-RO'=> esc_html__( 'Română (România)', 'wpbotvoicemessage' ),
			'si-LK'=> esc_html__( 'සිංහල (ශ්රී ලංකාව)', 'wpbotvoicemessage' ),
			'sk-SK'=> esc_html__( 'Slovenčina (Slovensko)', 'wpbotvoicemessage' ),
			'sl-SI'=> esc_html__( 'Slovenščina (Slovenija)', 'wpbotvoicemessage' ),
			'su-ID'=> esc_html__( 'Urang (Indonesia)', 'wpbotvoicemessage' ),
			'sw-TZ'=> esc_html__( 'Swahili (Tanzania)', 'wpbotvoicemessage' ),
			'sw-KE'=> esc_html__( 'Swahili (Kenya)', 'wpbotvoicemessage' ),
			'fi-FI'=> esc_html__( 'Suomi (Suomi)', 'wpbotvoicemessage' ),
			'sv-SE'=> esc_html__( 'Svenska (Sverige)', 'wpbotvoicemessage' ),
			'ta-IN'=> esc_html__( 'தமிழ் (இந்தியா)', 'wpbotvoicemessage' ),
			'ta-SG'=> esc_html__( 'தமிழ் (சிங்கப்பூர்)', 'wpbotvoicemessage' ),
			'ta-LK'=> esc_html__( 'தமிழ் (இலங்கை)', 'wpbotvoicemessage' ),
			'ta-MY'=> esc_html__( 'தமிழ் (மலேசியா)', 'wpbotvoicemessage' ),
			'te-IN'=> esc_html__( 'తెలుగు (భారతదేశం)', 'wpbotvoicemessage' ),
			'vi-VN'=> esc_html__( 'Tiếng Việt (Việt Nam)', 'wpbotvoicemessage' ),
			'tr-TR'=> esc_html__( 'Türkçe (Türkiye)', 'wpbotvoicemessage' ),
			'ur-PK'=> esc_html__( 'اردو (پاکستان)', 'wpbotvoicemessage' ),
			'ur-IN'=> esc_html__( 'اردو (بھارت)', 'wpbotvoicemessage' ),
			'el-GR'=> esc_html__( 'Ελληνικά (Ελλάδα)', 'wpbotvoicemessage' ),
			'bg-BG'=> esc_html__( 'Български (България)', 'wpbotvoicemessage' ),
			'ru-RU'=> esc_html__( 'Русский (Россия)', 'wpbotvoicemessage' ),
			'sr-RS'=> esc_html__( 'Српски (Србија)', 'wpbotvoicemessage' ),
			'uk-UA'=> esc_html__( 'Українська (Україна)', 'wpbotvoicemessage' ),
			'he-IL'=> esc_html__( 'עברית (ישראל)', 'wpbotvoicemessage' ),
			'ar-IL'=> esc_html__( 'العربية (إسرائيل)', 'wpbotvoicemessage' ),
			'ar-JO'=> esc_html__( 'العربية (الأردن)', 'wpbotvoicemessage' ),
			'ar-AE'=> esc_html__( 'العربية (الإمارات)', 'wpbotvoicemessage' ),
			'ar-BH'=> esc_html__( 'العربية (البحرين)', 'wpbotvoicemessage' ),
			'ar-DZ'=> esc_html__( 'العربية (الجزائر)', 'wpbotvoicemessage' ),
			'ar-SA'=> esc_html__( 'العربية (السعودية)', 'wpbotvoicemessage' ),
			'ar-IQ'=> esc_html__( 'العربية (العراق)', 'wpbotvoicemessage' ),
			'ar-KW'=> esc_html__( 'العربية (الكويت)', 'wpbotvoicemessage' ),
			'ar-MA'=> esc_html__( 'العربية (المغرب)', 'wpbotvoicemessage' ),
			'ar-TN'=> esc_html__( 'العربية (تونس)', 'wpbotvoicemessage' ),
			'ar-OM'=> esc_html__( 'العربية (عُمان)', 'wpbotvoicemessage' ),
			'ar-PS'=> esc_html__( 'العربية (فلسطين)', 'wpbotvoicemessage' ),
			'ar-QA'=> esc_html__( 'العربية (قطر)', 'wpbotvoicemessage' ),
			'ar-LB'=> esc_html__( 'العربية (لبنان)', 'wpbotvoicemessage' ),
			'ar-EG'=> esc_html__( 'العربية (مصر)', 'wpbotvoicemessage' ),
			'fa-IR'=> esc_html__( 'فارسی (ایران)', 'wpbotvoicemessage' ),
			'hi-IN'=> esc_html__( 'हिन्दी (भारत)', 'wpbotvoicemessage' ),
			'th-TH'=> esc_html__( 'ไทย (ประเทศไทย)', 'wpbotvoicemessage' ),
			'ko-KR'=> esc_html__( '한국어 (대한민국)', 'wpbotvoicemessage' ),
			'zh-TW'=> esc_html__( '國語 (台灣)', 'wpbotvoicemessage' ),
			'yue-Hant-HK'=> esc_html__( '廣東話 (香港)', 'wpbotvoicemessage' ),
			'ja-JP'=> esc_html__( '日本語（日本）', 'wpbotvoicemessage' ),
			'zh-HK'=> esc_html__( '普通話 (香港)', 'wpbotvoicemessage' ),
			'zh'=> esc_html__( '普通话 (中国大陆)', 'wpbotvoicemessage' )
		];

		/** Render Language dropdown. */
		UI::get_instance()->render_select(
			$options,
			Settings::get_instance()->options['language'], // Selected option.
			esc_html__('Language', 'wpbotvoicemessage' ),
			esc_html__( 'Select Language to convert audio to text.', 'wpbotvoicemessage' ),
			['name' => 'qcld_wpvm_vmwbmdp_contacter_settings[language]']
		);

	}

	/**
	 * Render Punctuation field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function punctuation() {

		/** Render Punctuation switcher. */
		UI::get_instance()->render_switches(
			Settings::get_instance()->options['punctuation'],
			esc_html__('Punctuation', 'wpbotvoicemessage' ),
			esc_html__( 'Accurately punctuates transcriptions (e.g., commas, question marks) with machine learning.', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_settings[punctuation]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_settings_punctuation'
			]
		);

	}

	/**
	 * Render Accent Color field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function accent_color() {

		/** Render Accent Color colorpicker. */
		UI::get_instance()->render_colorpicker(
			Settings::get_instance()->options['accent_color'],
			esc_html__( 'Accent Color', 'wpbotvoicemessage' ),
			esc_html__( 'Select accent color', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_settings[accent_color]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_settings_accent_color',
				'readonly' => 'readonly'
			]
		);

	}

	/**
	 * Render Max duration field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function max_duration() {

		/** Max duration slider. */
		UI::get_instance()->render_slider(
			Settings::get_instance()->options['max_duration'],
			0,
			300,
			1,
			esc_html__( 'Border Radius', 'wpbotvoicemessage' ),
			esc_html__( 'Max recording duration: ', 'wpbotvoicemessage' ) .
			'<strong>' . Settings::get_instance()->options['max_duration'] . '</strong>' .
			esc_html__( ' seconds. Set 0 to unlimited record time.', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_settings[max_duration]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_settings_max_duration',
				'class' => 'mdc-slider-width'
			]
		);

	}

	/**
	 * Render Show Float Button field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function show_fbutton() {

		/** Render Show Float Button switcher. */
		UI::get_instance()->render_switches(
			Settings::get_instance()->options['show_fbutton'],
			esc_html__( 'Floating button for all pages', 'wpbotvoicemessage' ),
			'',
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[show_fbutton]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_show_fbutton'
			]
		);

	}

	/**
	 * Render VoiceMessageAddon Form field.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 **/
	public static function fbutton_c_form() {

		/** Prepare VoiceMessageAddon forms options. */
		$wp_query = new WP_Query;
		$query = [
			'post_type' => VoiceForm::POST_TYPE,
			'post_status' => ['publish']
		];
		$c_forms = $wp_query->query( $query );

		$options = [];
		foreach ( $c_forms as $c_form ) {
			$options['ID-' . $c_form->ID] = $c_form->post_title;
        }

		if ( count( $options ) ) {

			/** Render VoiceMessageAddon Form select. */
			UI::get_instance()->render_select(
				$options,
				'ID-' . Settings::get_instance()->options['fbutton_c_form'], // Selected option.
				esc_html__('VoiceMessageAddon Form', 'wpbotvoicemessage' ),
				esc_html__( 'Select VoiceMessageAddon Form to show by Floating Button click.', 'wpbotvoicemessage' ),
				[
					'name'  => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_c_form]',
					'id'    => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_c_form'
				]
			);

        } else {

			esc_html_e('No forms found. First create a ', 'wpbotvoicemessage' );
            ?> <a href="<?php esc_attr_e( admin_url( '/post-new.php?post_type=contacter_form_qcld' ) ); ?>"><?php
            esc_html_e('VoiceMessageAddon Form', 'wpbotvoicemessage' );
            ?></a> <?php
			esc_html_e('here.', 'wpbotvoicemessage' );

        }

	}

	/**
	 * Render Position field.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 **/
	public static function fbutton_position() {

		/** Position options. */
		$options = [
			'top-left'      => esc_html__( 'Top Left', 'wpbotvoicemessage' ),
			'top-right'     => esc_html__( 'Top Right', 'wpbotvoicemessage' ),
			'left-center'   => esc_html__( 'Left Center', 'wpbotvoicemessage' ),
			'right-center'  => esc_html__( 'Right Center', 'wpbotvoicemessage' ),
			'bottom-left'   => esc_html__( 'Bottom Left', 'wpbotvoicemessage' ),
			'bottom-center' => esc_html__( 'Bottom Center', 'wpbotvoicemessage' ),
			'bottom-right'  => esc_html__( 'Bottom Right', 'wpbotvoicemessage' ),
		];

		/** Render Position select. */
		UI::get_instance()->render_select(
			$options,
			Settings::get_instance()->options['fbutton_position'], // Selected option.
			esc_html__('Button Position', 'wpbotvoicemessage' ),
			esc_html__( 'Select a place on the page to display Floating Button.', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_position]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_position'
			]
		);

	}

	/**
	 * Render Margin field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_margin() {

		/** Margin slider. */
		UI::get_instance()->render_slider(
			Settings::get_instance()->options['fbutton_margin'],
			0,
			100,
			1,
			esc_html__( 'Button Margin', 'wpbotvoicemessage' ),
			esc_html__( 'Button margin: ', 'wpbotvoicemessage' ) .
			'<strong>' . Settings::get_instance()->options['fbutton_margin'] . '</strong>' .
			esc_html__( ' px', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_margin]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_margin',
				'class' => 'mdc-slider-width'
			]
		);

	}

	/**
	 * Render Padding field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_padding() {

		/** Padding slider. */
		UI::get_instance()->render_slider(
			Settings::get_instance()->options['fbutton_padding'],
			0,
			100,
			1,
			esc_html__( 'Button Padding', 'wpbotvoicemessage' ),
			esc_html__( 'Button padding: ', 'wpbotvoicemessage' ) .
			'<strong>' . Settings::get_instance()->options['fbutton_padding'] . '</strong>' .
			esc_html__( ' px', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_padding]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_padding',
				'class' => 'mdc-slider-width'
			]
		);

	}

	/**
	 * Render Button Border Radius field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_border_radius() {

		/** Button Border Radius slider. */
		UI::get_instance()->render_slider(
			Settings::get_instance()->options['fbutton_border_radius'],
			0,
			100,
			1,
			esc_html__( 'Border Radius', 'wpbotvoicemessage' ),
			esc_html__( 'Border radius: ', 'wpbotvoicemessage' ) .
			'<strong>' . Settings::get_instance()->options['fbutton_border_radius'] . '</strong>' .
			esc_html__( ' px', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_border_radius]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_border_radius',
				'class' => 'mdc-slider-width'
			]
		);

	}

	/**
	 * Render Icon field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_icon() {

		/** Button icon icon. */
		UI::get_instance()->render_icon(
			Settings::get_instance()->options['fbutton_icon'],
			'',
			esc_html__( 'Select icon for button', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_icon]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_icon'
			],
            [
	            '_contacter.json',
	            'font-awesome.json',
	            'material.json',
            ]
		);

	}

	/**
	 * Render Icon Position field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_icon_position() {

		/** Icon Position options. */
		$options = [
			'none'   => esc_html__( 'Hide', 'wpbotvoicemessage' ),
			'before' => esc_html__( 'Before', 'wpbotvoicemessage' ),
			'after'  => esc_html__( 'After', 'wpbotvoicemessage' ),
			'above' => esc_html__( 'Above', 'wpbotvoicemessage' ),
			'bellow'   => esc_html__( 'Bellow', 'wpbotvoicemessage' ),
		];

		/** Render Icon Position dropdown. */
		UI::get_instance()->render_select(
			$options,
			Settings::get_instance()->options['fbutton_icon_position'], // Selected option.
			esc_html__( 'Icon Position', 'wpbotvoicemessage' ),
			'',
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_icon_position]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_icon_position'
			]
		);

	}

	/**
	 * Render Button Caption field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_caption() {

		/** Render Button Caption input. */
		UI::get_instance()->render_input(
			Settings::get_instance()->options['fbutton_caption'],
			esc_html__( 'Button caption', 'wpbotvoicemessage' ),
			'',
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_caption]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_caption'
			]
		);

	}

	/**
	 * Render Icon/Caption size field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_size() {

		/** Icon/Caption size slider. */
		UI::get_instance()->render_slider(
			Settings::get_instance()->options['fbutton_size'],
			10,
			100,
			1,
			esc_html__( 'Size', 'wpbotvoicemessage' ),
			esc_html__( 'Icon/Caption size: ', 'wpbotvoicemessage' ) . '<strong>' . Settings::get_instance()->options['fbutton_size'] . '</strong>' . esc_html__( ' px', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_size]',
				'id' => 'vmwbmdp-wpbotvoicemessage-floatbutton-settings-fbutton-size',
				'class' => 'mdc-slider-width'
			]
		);

	}

	/**
	 * Render Button Text Color field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_color() {

		/** Render Button Text Color colorpicker. */
		UI::get_instance()->render_colorpicker(
			Settings::get_instance()->options['fbutton_color'],
			esc_html__( 'Text Color', 'wpbotvoicemessage' ),
			esc_html__( 'Select icon and text color', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_color]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_color',
				'readonly' => 'readonly'
			]
		);

	}

	/**
	 * Render Button Hover Text Color field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_color_hover() {

		/** Render Button Text Color colorpicker. */
		UI::get_instance()->render_colorpicker(
			Settings::get_instance()->options['fbutton_color_hover'],
			esc_html__( 'Text Hover Color', 'wpbotvoicemessage' ),
			esc_html__( 'Select icon and text hover color', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_color_hover]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_color_hover',
				'readonly' => 'readonly'
			]
		);

	}

	/**
	 * Render Button Background Color field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_bgcolor() {

		/** Render Button Background Color colorpicker. */
		UI::get_instance()->render_colorpicker(
			Settings::get_instance()->options['fbutton_bgcolor'],
			esc_html__( 'Background Color', 'wpbotvoicemessage' ),
			esc_html__( 'Select button background color', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_bgcolor]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_bgcolor',
				'readonly' => 'readonly'
			]
		);

	}

	/**
	 * Render Button Hover Background Color field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_bgcolor_hover() {

		/** Render Button Background Color colorpicker. */
		UI::get_instance()->render_colorpicker(
			Settings::get_instance()->options['fbutton_bgcolor_hover'],
			esc_html__( 'Background Hover Color', 'wpbotvoicemessage' ),
			esc_html__( 'Select button hover background color', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_bgcolor_hover]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_bgcolor_hover',
				'readonly' => 'readonly'
			]
		);

	}

	/**
	 * Render Entrance Timeout field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_entrance_timeout() {

		/** Entrance Timeout slider. */
		UI::get_instance()->render_slider(
			Settings::get_instance()->options['fbutton_entrance_timeout'],
			0,
			100,
			1,
			esc_html__( 'Entrance Timeout', 'wpbotvoicemessage' ),
			esc_html__( 'Entrance Timeout: ', 'wpbotvoicemessage' ) .
			'<strong>' . Settings::get_instance()->options['fbutton_entrance_timeout'] . '</strong>' .
			esc_html__( ' seconds', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_entrance_timeout]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_entrance_timeout',
				'class' => 'mdc-slider-width'
			]
		);

	}

	/**
	 * Render Initial animation field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_animation() {

		/** Style options. */
		$options = [
			'none'                  => esc_html__( 'None', 'wpbotvoicemessage' ),
			'bounce'                => esc_html__( 'Bounce', 'wpbotvoicemessage' ),
			'fade'                  => esc_html__( 'Fade', 'wpbotvoicemessage' ),
			'flip-x'                => esc_html__( 'Flip X', 'wpbotvoicemessage' ),
			'flip-y'                => esc_html__( 'Flip Y', 'wpbotvoicemessage' ),
			'scale'                 => esc_html__( 'Scale', 'wpbotvoicemessage' ),
			'wobble'                => esc_html__( 'Wobble', 'wpbotvoicemessage' ),
			'rotate'                => esc_html__( 'Rotate', 'wpbotvoicemessage' )
		];

		/** Render Style dropdown. */
		UI::get_instance()->render_select(
			$options,
			Settings::get_instance()->options['fbutton_animation'], // Selected option.
			esc_html__( 'Entrance animation', 'wpbotvoicemessage' ),
			esc_html__( 'Button Entrance animation', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_animation]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_animation'
			]
		);

	}

	/**
	 * Render Button Hover Animation field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function fbutton_hover_animation() {

		/** Hover options. */
		$options = [
			'none'                  => esc_html__( 'None', 'wpbotvoicemessage' ),
			'bounce'                => esc_html__( 'Bounce', 'wpbotvoicemessage' ),
			'fade'                  => esc_html__( 'Fade', 'wpbotvoicemessage' ),
			'flip-x'                => esc_html__( 'Flip X', 'wpbotvoicemessage' ),
			'flip-y'                => esc_html__( 'Flip Y', 'wpbotvoicemessage' ),
			'scale'                 => esc_html__( 'Scale', 'wpbotvoicemessage' ),
			'wobble'                => esc_html__( 'Wobble', 'wpbotvoicemessage' ),
			'rotate'                => esc_html__( 'Rotate', 'wpbotvoicemessage' )
		];

		/** Render Button Hover Animation dropdown. */
		UI::get_instance()->render_select(
			$options,
			Settings::get_instance()->options['fbutton_hover_animation'], // Selected option.
			esc_html__( 'Hover animation', 'wpbotvoicemessage' ),
			esc_html__( 'Button hover animation', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings[fbutton_hover_animation]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_hover_animation'
			]
		);

	}

	/**
	 * Render Overlay Color field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function modal_overlay_color() {

		/** Render Overlay Color colorpicker. */
		UI::get_instance()->render_colorpicker(
			Settings::get_instance()->options['modal_overlay_color'],
			esc_html__( 'Overlay Color', 'wpbotvoicemessage' ),
			esc_html__( 'Select modal overlay background-color', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_modalpopup_settings[modal_overlay_color]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_modalpopup_settings_modal_overlay_color',
				'readonly' => 'readonly'
			]
		);

	}

	/**
	 * Render Popup Background Color field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function modal_bg_color() {

		/** Render Background Color colorpicker. */
		UI::get_instance()->render_colorpicker(
			Settings::get_instance()->options['modal_bg_color'],
			esc_html__( 'Background Color', 'wpbotvoicemessage' ),
			esc_html__( 'Select modal background-color', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_modalpopup_settings[modal_bg_color]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_modalpopup_settings_modal_bg_color',
				'readonly' => 'readonly'
			]
		);

	}

	/**
	 * Render Modal Border Radius field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function modal_radius() {

		/** Modal Border Radius slider. */
		UI::get_instance()->render_slider(
			Settings::get_instance()->options['modal_radius'],
			0,
			100,
			1,
			esc_html__( 'Border Radius', 'wpbotvoicemessage' ),
			esc_html__( 'Border radius: ', 'wpbotvoicemessage' ) .
			'<strong>' . Settings::get_instance()->options['modal_radius'] . '</strong>' .
			esc_html__( ' px', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_modalpopup_settings[modal_radius]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_modalpopup_settings_modal_radius',
				'class' => 'mdc-slider-width'
			]
		);

	}

	/**
	 * Render Modal animation field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function modal_animation() {

		/** Style options. */
		$options = [
			'none'                  => esc_html__( 'None', 'wpbotvoicemessage' ),
			'bounce'                => esc_html__( 'Bounce', 'wpbotvoicemessage' ),
			'fade'                  => esc_html__( 'Fade', 'wpbotvoicemessage' ),
			'flip-x'                => esc_html__( 'Flip X', 'wpbotvoicemessage' ),
			'flip-y'                => esc_html__( 'Flip Y', 'wpbotvoicemessage' ),
			'scale'                 => esc_html__( 'Scale', 'wpbotvoicemessage' ),
			'slide-tr'              => esc_html__( 'Slide to right', 'wpbotvoicemessage' ),
			'slide-tl'              => esc_html__( 'Slide to left', 'wpbotvoicemessage' ),
			'slide-tt'              => esc_html__( 'Slide to top', 'wpbotvoicemessage' ),
			'slide-tb'              => esc_html__( 'Slide to bottom', 'wpbotvoicemessage' ),
			'rotate'                => esc_html__( 'Rotate', 'wpbotvoicemessage' ),
			'wobble'                => esc_html__( 'Wobble', 'wpbotvoicemessage' )
		];

		/** Render Style dropdown. */
		UI::get_instance()->render_select(
			$options,
			Settings::get_instance()->options['modal_animation'], // Selected option.
			esc_html__( 'Animation', 'wpbotvoicemessage' ),
			esc_html__( 'Modal entrance animation', 'wpbotvoicemessage' ),
			[
				'name' => 'qcld_wpvm_vmwbmdp_contacter_modalpopup_settings[modal_animation]',
				'id' => 'qcld_wpvm_vmwbmdp_contacter_modalpopup_settings_modal_animation'
			]
		);

	}

	/**
	 * Render Before text message field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function msg_before_txt() {

		/** @noinspection SpellCheckingInspection */
		wp_editor( Settings::get_instance()->options['msg_before_txt'], 'vmwbmdpcontactermessagessettingsmsgbeforetxt', [ 'textarea_rows' => 7, 'textarea_name' => 'qcld_wpvm_vmwbmdp_contacter_messages_settings[msg_before_txt]' ] );

	}

	/**
	 * Render After text message field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function msg_after_txt() {

		/** @noinspection SpellCheckingInspection */
		wp_editor( Settings::get_instance()->options['msg_after_txt'], 'vmwbmdpcontactermessagessettingsmsgaftertxt', [ 'textarea_rows' => 7, 'textarea_name' => 'qcld_wpvm_vmwbmdp_contacter_messages_settings[msg_after_txt]' ] );

	}

	/**
	 * Render Speak Now message field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function msg_speak_now() {

		/** @noinspection SpellCheckingInspection */
		wp_editor( Settings::get_instance()->options['msg_speak_now'], 'vmwbmdpcontactermessagessettingsmsgspeaknow', [ 'textarea_rows' => 7, 'textarea_name' => 'qcld_wpvm_vmwbmdp_contacter_messages_settings[msg_speak_now]' ] );
		?>
        <div class="mdc-select-helper-text mdc-select-helper-text--persistent">
            <?php esc_html_e( 'You can use special placeholders: {timer}, {max-duration}, {countdown}.', 'wpbotvoicemessage' ); ?>
        </div>
        <?php

	}

	/**
	 * Render Microphone access error message field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function msg_allow_access() {

		/** @noinspection SpellCheckingInspection */
		wp_editor( Settings::get_instance()->options['msg_allow_access'], 'vmwbmdpcontactermessagessettingsmsgallowaccess', [ 'textarea_rows' => 7, 'textarea_name' => 'qcld_wpvm_vmwbmdp_contacter_messages_settings[msg_allow_access]' ] );

	}

	/**
	 * Render Allow Access to microphone message field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function msg_mic_access_err() {

		/** @noinspection SpellCheckingInspection */
		wp_editor( Settings::get_instance()->options['msg_mic_access_err'], 'vmwbmdpcontactermessagessettingsmsgmicaccesserr', [ 'textarea_rows' => 7, 'textarea_name' => 'qcld_wpvm_vmwbmdp_contacter_messages_settings[msg_mic_access_err]' ] );

	}

	/**
	 * Render Sending Error message field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function msg_sending_error() {

		/** @noinspection SpellCheckingInspection */
		wp_editor( Settings::get_instance()->options['msg_sending_error'], 'vmwbmdpcontactermessagessettingsmsgsendingerror', [ 'textarea_rows' => 7, 'textarea_name' => 'qcld_wpvm_vmwbmdp_contacter_messages_settings[msg_sending_error]' ] );

	}

	/**
	 * Render Reset recording message field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function msg_reset_recording() {

		/** @noinspection SpellCheckingInspection */
		wp_editor( Settings::get_instance()->options['msg_reset_recording'], 'vmwbmdpcontactermessagessettingsmsgresetrecording', [ 'textarea_rows' => 7, 'textarea_name' => 'qcld_wpvm_vmwbmdp_contacter_messages_settings[msg_reset_recording]' ] );

	}

	/**
	 * Render Send recording message field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function msg_send() {

		/** @noinspection SpellCheckingInspection */
		wp_editor( Settings::get_instance()->options['msg_send'], 'vmwbmdpcontactermessagessettingsmsgsend', [ 'textarea_rows' => 7, 'textarea_name' => 'qcld_wpvm_vmwbmdp_contacter_messages_settings[msg_send]' ] );

	}

	/**
	 * Render "Thank You" message field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function msg_thank_you() {

		/** @noinspection SpellCheckingInspection */
		wp_editor( Settings::get_instance()->options['msg_thank_you'], 'vmwbmdpcontactermessagessettingsmsgthankyou', [ 'textarea_rows' => 7, 'textarea_name' => 'qcld_wpvm_vmwbmdp_contacter_messages_settings[msg_thank_you]' ] );

	}

	/**
	 * Render CSS field.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public static function custom_css() {
		?>
		<div>
            <label>
                <textarea
                    id="vmwbmdp_custom_css_fld"
					rows="5" cols="80"
                    name="qcld_wpvm_vmwbmdp_contacter_css_settings[custom_css]"
                    class="vmwbmdp_custom_css_fld"><?php echo esc_textarea( Settings::get_instance()->options['custom_css'] ); ?></textarea>
            </label>
			<p class="description"><?php esc_html_e( 'Add custom CSS here.', 'wpbotvoicemessage' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Render "SettingsFields Saved" nags.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 **/
	public static function render_nags() {

		/** Did we try to save settings? */
		if ( ! isset( $_GET['settings-updated'] ) ) { return; }

		/** Are the settings saved successfully? */
		if ( $_GET['settings-updated'] === 'true' ) {

			/** Render "SettingsFields Saved" message. */
			UI::get_instance()->render_snackbar( esc_html__( 'Settings saved!', 'wpbotvoicemessage' ) );
		}

		if ( ! isset( $_GET['tab'] ) ) { return; }

	}

	/**
	 * Main SettingsFields Instance.
	 *
	 * Insures that only one instance of SettingsFields exists in memory at any one time.
	 *
	 * @static
	 * @return SettingsFields
	 * @since 1.0.0
	 **/
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof SettingsFields ) ) {
			self::$instance = new SettingsFields;
		}

		return self::$instance;
	}
	
} // End Class SettingsFields.
