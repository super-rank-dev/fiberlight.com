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
 * SINGLETON: Class used to implement plugin settings.
 *
 * @since 1.0.0
 **/
final class Settings {

	/**
	 * VoiceMessageAddon Plugin settings.
	 *
	 * @var array()
	 * @since 1.0.0
	 **/
	public $options = [];

	/**
	 * The one true Settings.
	 *
	 * @var Settings
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Sets up a new Settings instance.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	private function __construct() {

		/** Get plugin settings. */
		$this->get_options();

	}

	/**
	 * Render Tabs Headers.
	 *
	 * @param string $current - Selected tab key.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function print_tabs( $current = 'general' ) {

		/** Get available tabs. */
		$tabs = $this->get_tabs();

		/** Render Tabs. */
		?>
        <aside class="mdc-drawer">
            <div class="mdc-drawer__content">
                <nav class="mdc-list">
					<?php

					/** Render logo in plugin settings. */
					$this->render_logo();

					/** Render settings tabs. */
					$this->render_tabs( $tabs, $current );

					?>
                </nav>
            </div>
        </aside>
		<?php
	}

	/**
	 * Render logo and Save changes button in plugin settings.
	 *
	 * @access private
	 * @since 1.0.5
	 *
	 * @return void
	 **/
	private function render_logo() {

		?>
        <div class="mdc-drawer__header mdc-plugin-fixed">
            <!--suppress HtmlUnknownAnchorTarget -->
            <a class="mdc-list-item vmwbmdp-plugin-title" href="#wpwrap">
                <i class="mdc-list-item__graphic" aria-hidden="true">
                    <img src="<?php echo esc_attr( wpbotvoicemessage::$url . 'images/logo-color.svg' ); ?>" alt="<?php echo esc_html__( 'Voice Message for WPBot', 'wpbotvoicemessage' ) ?>">
                </i>
                <span class="mdc-list-item__text">
                    <?php echo esc_html__( 'Voice Message for WPBot', 'wpbotvoicemessage' ) ?>
                </span>
            </a>
            <button type="submit" name="submit" id="submit" class="mdc-button mdc-button--dense mdc-button--raised">
                <span class="mdc-button__label"><?php echo esc_html__( 'Save changes', 'wpbotvoicemessage' ) ?></span>
            </button>
        </div>
		<?php

	}

	/**
	 * Render settings tabs.
	 *
	 * @param array $tabs       - Array of available tabs.
	 * @param string $current   - Slug of active tab.
	 *
	 * @access private
	 * @since  1.0.5
	 *
	 * @return void
	 **/
	private function render_tabs( $tabs, $current ) {

		?>
        <hr class="mdc-plugin-menu">
        <!-- <hr class="mdc-list-divider"> -->
        <h6 class="mdc-list-group__subheader"><?php echo esc_html__( 'Plugin settings', 'wpbotvoicemessage' ) ?></h6>
		<?php

		/** Plugin settings tabs. */
		foreach ( $tabs as $tab => $value ) {

			/** Prepare CSS classes. */
			$classes = [];
			$classes[] = 'mdc-list-item';

			/** Mark Active Tab. */
			if ( $tab === $current ) {
				$classes[] = 'mdc-list-item--activated';
			}

			/** Hide Developer tab before multiple clicks on logo. */
			if ( 'developer' === $tab ) {
				$classes[] = 'vmwbmdp-developer';
				$classes[] = 'mdc-hidden';
				$classes[] = 'mdc-list-item--activated';
			}

			/** Prepare link. */
			$link = '?post_type=qcldwpbot_record&page=qcld_wpvm_vmwbmdp_contacter_settings&tab=' . $tab;

			?>
            <a class="<?php esc_attr_e( implode( ' ', $classes ) ); ?>" href="<?php esc_attr_e( $link ); ?>">
                <i class='material-icons mdc-list-item__graphic' aria-hidden='true'><?php esc_html_e( $value['icon'] ); ?></i>
                <span class='mdc-list-item__text'><?php esc_html_e( $value['name'] ); ?></span>
            </a>
			<?php
		}

	}

	/**
	 * Return an array of available tabs in plugin settings.
	 *
	 * @access private
	 * @since 1.0.5
	 *
	 * @return array
	 **/
	private function get_tabs() {

		/** Tabs array. */
		$tabs = [];
		$tabs['general'] = [
			'icon' => 'tune',
			'name' => esc_html__( 'General', 'wpbotvoicemessage' )
		];

		$tabs['messages'] = [
			'icon' => 'spellcheck',
			'name' => esc_html__( 'Default Messages', 'wpbotvoicemessage' )
		];

		$tabs['css'] = [
			'icon' => 'code',
			'name' => esc_html__( 'Custom CSS', 'wpbotvoicemessage' )
		];

		/** Adds a developer tab. */
		$tabs = $this->add_developer_tab( $tabs );

		return $tabs;

	}

	/**
	 * Adds a developer tab if all the necessary conditions are met.
	 *
	 * @param array $tabs - Array of tabs to show in plugin settings.
	 *
	 * @access private
	 * @since  1.0.5
	 *
	 * @return array - Array of tabs to show in plugin settings.
	 **/
	private function add_developer_tab( $tabs ) {

		/** Output Developer tab only if DEBUG mode enabled. */
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

			$tabs['developer'] = [
				'icon' => 'developer_board',
				'name' => esc_html__( 'Developer', 'wpbotvoicemessage' )
			];

		}

		return $tabs;

	}

	/**
	 * Displays useful links for an activated and non-activated plugin.
	 *
	 * @since 1.0.0
     *
     * @return void
	 **/
	public function support_link() { ?>

        <hr class="mdc-list-divider">
        <h6 class="mdc-list-group__subheader"><?php echo esc_html__( 'Helpful links', 'wpbotvoicemessage' ) ?></h6>

        <a class="mdc-list-item" href="#" target="_blank">
            <i class="material-icons mdc-list-item__graphic" aria-hidden="true"><?php echo esc_html__( 'collections_bookmark' ) ?></i>
            <span class="mdc-list-item__text"><?php echo esc_html__( 'Documentation', 'wpbotvoicemessage' ) ?></span>
        </a>


            <a class="mdc-list-item" href="https://quantumcloud.com/-support" target="_blank">
                <i class="material-icons mdc-list-item__graphic" aria-hidden="true">mail</i>
                <span class="mdc-list-item__text"><?php echo esc_html__( 'Get help', 'wpbotvoicemessage' ) ?></span>
            </a>
            <a class="mdc-list-item" href="https://1.envato.market/cc-downloads" target="_blank">
                <i class="material-icons mdc-list-item__graphic" aria-hidden="true">thumb_up</i>
                <span class="mdc-list-item__text"><?php echo esc_html__( 'Rate this plugin', 'wpbotvoicemessage' ) ?></span>
            </a>


        <a class="mdc-list-item" href="https://quantumcloud.com/" target="_blank">
            <i class="material-icons mdc-list-item__graphic" aria-hidden="true"><?php echo esc_html__( 'store' ) ?></i>
            <span class="mdc-list-item__text"><?php echo esc_html__( 'More plugins', 'wpbotvoicemessage' ) ?></span>
        </a>
		<?php

	}

	/**
	 * Add plugin settings page.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function add_settings_page() {

		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		add_action( 'admin_init', [ $this, 'settings_init' ] );

	}

	/**
	 * Create General Tab.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
    public function tab_general() {

	    /** General Tab. */
	    $group_name = 'ContacterOptionsGroup';
	    $section_id = 'qcld_wpvm_vmwbmdp_contacter_settings_page_general_section';
	    $option_name = 'qcld_wpvm_vmwbmdp_contacter_settings';

	    /** Create settings section. */
	    register_setting( $group_name, $option_name );
	    add_settings_section( $section_id, '', null, $group_name );

	    /** Render Settings fields. */
	    add_settings_field( 'max_duration', esc_html__( 'Max Duration:', 'wpbotvoicemessage' ),             [ SettingsFields::class, 'max_duration' ], $group_name, $section_id );
	    add_settings_field( 'accent_color', esc_html__( 'Accent Color:', 'wpbotvoicemessage' ),             [ SettingsFields::class, 'accent_color' ], $group_name, $section_id );
	    add_settings_field( 'show_download_link', esc_html__( 'Show Download Link:', 'wpbotvoicemessage' ), [ SettingsFields::class, 'show_download_link'], $group_name, $section_id );
	    add_settings_field( 'download_link_text', esc_html__( 'Download Link Text:', 'wpbotvoicemessage' ), [ SettingsFields::class, 'download_link_text'], $group_name, $section_id );

	    //add_settings_field( 'speech_recognition', esc_html__( 'Speech Recognition:', 'wpbotvoicemessage' ), [ SettingsFields::class, 'speech_recognition'], $group_name, $section_id );

	    /** This features require PHP 7+ */
	    if ( defined('PHP_MAJOR_VERSION') && PHP_MAJOR_VERSION >= 7 ) {

		    # API Key.
		    //add_settings_field( 'dnd_api_key', esc_html__( 'API Key File:', 'wpbotvoicemessage' ),            [SettingsFields::class, 'dnd_api_key'], $group_name, $section_id );

		    //add_settings_field( 'language', esc_html__( 'Language:', 'wpbotvoicemessage' ),                 [ SettingsFields::class, 'language' ], $group_name, $section_id );
		    //add_settings_field( 'punctuation', esc_html__( 'Punctuation:', 'wpbotvoicemessage' ),           [ SettingsFields::class, 'punctuation' ], $group_name, $section_id );

	    }

    }

	/**
	 * Create Messages Tab.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function tab_messages() {

		/** Messages Tab. */
		$group_name = 'ContacterMessagesOptionsGroup';
		$section_id = 'qcld_wpvm_vmwbmdp_contacter_messages_settings_page_general_section';
		$option_name = 'qcld_wpvm_vmwbmdp_contacter_messages_settings';

		/** Create settings section. */
		register_setting( $group_name, $option_name );
		add_settings_section( $section_id, '', null, $group_name );

		/** Render Settings fields. */
        add_settings_field( 'msg_before_txt', esc_html__( 'Before Text:', 'wpbotvoicemessage' ),          [ SettingsFields::class, 'msg_before_txt'], $group_name, $section_id );
		add_settings_field( 'msg_after_txt', esc_html__( 'After Text:', 'wpbotvoicemessage' ),            [ SettingsFields::class, 'msg_after_txt'], $group_name, $section_id );
		add_settings_field( 'msg_speak_now', esc_html__( 'Speak Now:', 'wpbotvoicemessage' ),             [ SettingsFields::class, 'msg_speak_now'], $group_name, $section_id );
		add_settings_field( 'msg_allow_access', esc_html__( 'Allow Access:', 'wpbotvoicemessage' ),       [ SettingsFields::class, 'msg_allow_access'], $group_name, $section_id );
		add_settings_field( 'msg_mic_access_err', esc_html__( 'Access error:', 'wpbotvoicemessage' ),     [ SettingsFields::class, 'msg_mic_access_err'], $group_name, $section_id );
		add_settings_field( 'msg_reset_recording', esc_html__( 'Reset recording:', 'wpbotvoicemessage' ), [ SettingsFields::class, 'msg_reset_recording'], $group_name, $section_id );
		add_settings_field( 'msg_send', esc_html__( 'Send recording:', 'wpbotvoicemessage' ),             [ SettingsFields::class, 'msg_send'], $group_name, $section_id );
		add_settings_field( 'msg_sending_error', esc_html__( 'Sending error:', 'wpbotvoicemessage' ),     [ SettingsFields::class, 'msg_sending_error'], $group_name, $section_id );
        add_settings_field( 'msg_thank_you', esc_html__( '"Thank you" message:', 'wpbotvoicemessage' ),   [ SettingsFields::class, 'msg_thank_you'], $group_name, $section_id );

    }

	/**
	 * Create Custom CSS Tab.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function tab_custom_css() {

		/** Custom CSS. */
		$group_name = 'ContacterCSSOptionsGroup';
		$section_id = 'qcld_wpvm_vmwbmdp_contacter_settings_page_css_section';

		/** Create settings section. */
		register_setting( $group_name, 'qcld_wpvm_vmwbmdp_contacter_css_settings' );
		add_settings_section( $section_id, '', null, $group_name );

    }

	/**
	 * Generate Settings Page.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function settings_init() {

		/** General Tab. */
	    $this->tab_general();

		/** Messages. */
		$this->tab_messages();

		/** Create Custom CSS Tab. */
		$this->tab_custom_css();

	}

	/**
	 * Add admin menu for plugin settings.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function add_admin_menu() {

		add_submenu_page(
			'edit.php?post_type=' . VoiceRecord::POST_TYPE,
			esc_html__( 'VoiceMessageAddon Settings', 'wpbotvoicemessage' ),
			esc_html__( 'Settings', 'wpbotvoicemessage' ),
			'manage_options',
			'qcld_wpvm_vmwbmdp_contacter_settings',
			[$this, 'options_page']
		);

	}

	/**
	 * Plugin Settings Page.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	public function options_page() {

		/** User rights check. */
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		} ?>
        <!--suppress HtmlUnknownTarget -->
        <form action='options.php' method='post'>
            <div class="wrap">

				<?php
				$tab = 'general';
				if ( isset ( $_GET['tab'] ) ) { $tab = $_GET['tab']; }

				/** Render "VoiceMessageAddon settings saved!" message. */
				SettingsFields::get_instance()->render_nags();

				/** Render Tabs Headers. */
				?><section class="vmwbmdp-aside"><?php $this->print_tabs( $tab ); ?></section><?php

				/** Render Tabs Body. */
				?><section class="vmwbmdp-tab-content vmwbmdp-tab-<?php echo esc_attr( $tab ) ?>"><?php

					/** General Tab. */
					if ( 'general' === $tab ) {
						echo '<h3>' . esc_html__( 'General Settings', 'wpbotvoicemessage' ) . '</h3>';
						settings_fields( 'ContacterOptionsGroup' );
						do_settings_sections( 'ContacterOptionsGroup' );
                    /** Messages Tab. */
					} elseif ( 'messages' === $tab ) {
						echo '<h3>' . esc_html__( 'Messages', 'wpbotvoicemessage' ) . '</h3>';
						echo '<p>' . esc_html__( 'These are default messages that will be used to create new forms. Changing the settings on this page will not change the settings for existing forms.', 'wpbotvoicemessage' ) . '</p>';
						settings_fields( 'ContacterMessagesOptionsGroup' );
						do_settings_sections( 'ContacterMessagesOptionsGroup' );

                    /** Custom CSS Tab. */
					} elseif ( 'css' === $tab ) {
						echo '<h3>' . esc_html__( 'Custom CSS', 'wpbotvoicemessage' ) . '</h3>';
						settings_fields( 'ContacterCSSOptionsGroup' );
						do_settings_sections( 'ContacterCSSOptionsGroup' );
						SettingsFields::get_instance()->custom_css();
					}

					?>
                </section>
            </div>
        </form>

		<?php
	}

	/**
	 * Get plugin settings with default values.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 **/
	public function get_options() {

		/** General Tab Options. */
		$options = get_option( 'qcld_wpvm_vmwbmdp_contacter_settings' );

		/** Default values. */
		$defaults = [
			// General Tab
			'speech_recognition'        => isset( $options[ 'speech_recognition' ] ) ? $options[ 'speech_recognition' ] : 'off',
			// TODO: Remove 'api_key' in 1.0.6
			'api_key'                   => '',
			'dnd-api-key'               => '',  // Encoded JSON API Key file.
			'language'                  => 'en-US',
			'punctuation'               => isset( $options[ 'punctuation' ] ) ? $options[ 'punctuation' ] : 'on',
            'max_duration'              => '60',
			'accent_color'              => '#0274e6',
            'show_download_link'        => isset( $options[ 'show_download_link' ] ) ? $options[ 'show_download_link' ] : 'off', // Show Download Link
			'download_link_text'        => esc_html__( 'Download record', 'wpbotvoicemessage' ), // Download Link Text

			// Float Button Tab
			'show_fbutton'              => isset( $options[ 'show_fbutton' ] ) ? $options[ 'show_fbutton' ] : 'on', // Show Float Button.
            'fbutton_c_form'            => '', // VoiceMessageAddon Form.
			'fbutton_position'          => 'bottom-right', // Button Position.
            'fbutton_margin'            => '10',
            'fbutton_padding'           => '20',
			'fbutton_border_radius'     => '50',
            'fbutton_icon'              => '_contacter/wpbotvoicemessage.svg',
            'fbutton_icon_position'     => 'before',
			'fbutton_caption'           => esc_html__( 'Start recording', 'wpbotvoicemessage' ),
			'fbutton_size'              => '24',
		    'fbutton_color'             => '#ffffff',
		    'fbutton_color_hover'       => '#0274e6',
		    'fbutton_bgcolor'           => '#0274e6',
		    'fbutton_bgcolor_hover'     => '#ffffff',
			'fbutton_entrance_timeout'  => '0',
		    'fbutton_animation'         => 'fade',
			'fbutton_hover_animation'   => 'none',

		    // Modal Popup Tab
			'modal_overlay_color'       => '#0253ee',
			'modal_bg_color'            => '#ffffff',
			'modal_radius'              => '10',
            'modal_animation'           => 'fade',

			// Messages Tab
			'msg_before_txt'            => '<h4>' . esc_html__( 'We would love to hear from you!', 'wpbotvoicemessage' ) . '</h4><p>' . esc_html__( 'Please record your message.', 'wpbotvoicemessage' ) . '</p>',
			'msg_after_txt'             => '<p>' . esc_html__( 'Record, Listen, Send', 'wpbotvoicemessage' ) . '</p>',
			'msg_speak_now'             => '<h4>' . esc_html__( 'Speak now', 'wpbotvoicemessage' ) . '</h4><div>{countdown}</div>',
			'msg_allow_access'          => '<h4>' . esc_html__( 'Allow access to your microphone', 'wpbotvoicemessage' ) . '</h4><p>' . esc_html__( 'Click "Allow" in the permission dialog. It usually appears under the address bar in the upper left side of the window. We respect your privacy.', 'wpbotvoicemessage' ) . '</p>',
            'msg_mic_access_err'        => '<h4>' . esc_html__( 'Microphone access error', 'wpbotvoicemessage' ) . '</h4><p>' . esc_html__( 'It seems your microphone is disabled in the browser settings. Please go to your browser settings and enable access to your microphone.', 'wpbotvoicemessage' ) . '</p>',
			'msg_reset_recording'       => '<h4>' . esc_html__( 'Reset recording', 'wpbotvoicemessage' ) . '</h4><p>' . esc_html__( 'Are you sure you want to start a new recording? Your current recording will be deleted.', 'wpbotvoicemessage' ) . '</p>',
			'msg_send'                  => '<h4>' . esc_html__( 'Send your recording', 'wpbotvoicemessage' ) . '</h4>',
			'msg_sending_error'         => '<h4>' . esc_html__( 'Oops, something went wrong', 'wpbotvoicemessage' ) . '</h4><p>' . esc_html__( 'Error occurred during uploading your audio. Please click the Retry button to try again.', 'wpbotvoicemessage' ) . '</p>',
            'msg_thank_you'             => '<h4>' . esc_html__( 'Thank you', 'wpbotvoicemessage' ) . '</h4>',

			// Custom CSS Tab
            'custom_css'                => '',
        ];

		/** Transcription work only with PHP 7+. */
		if ( defined('PHP_MAJOR_VERSION') && PHP_MAJOR_VERSION < 7 ) {
			$options['dnd-api-key'] = '';
        }

		$results = wp_parse_args( $options, $defaults );

		// TODO: Remove migrate_key_file_to_settings() in 1.0.6
		/** Moving from uploaded key file to stored in DB value. */
		$results = $this->migrate_key_file_to_settings( $results );

		/** Float Button Tab Options. */
		$float_button = get_option( 'qcld_wpvm_vmwbmdp_contacter_floatbutton_settings' );
		$results = wp_parse_args( $float_button, $results );

		/** Modal Popup Tab Options. */
		$modal_popup = get_option( 'qcld_wpvm_vmwbmdp_contacter_modalpopup_settings' );
		$results = wp_parse_args( $modal_popup, $results );

		/** Messages Tab Options. */
		$messages_tab = get_option( 'qcld_wpvm_vmwbmdp_contacter_messages_settings' );
		$results = wp_parse_args( $messages_tab, $results );

		/** Custom CSS tab Options. */
		$qcld_wpvm_vmwbmdp_contacter_css_settings = get_option( 'qcld_wpvm_vmwbmdp_contacter_css_settings' );
		$results = wp_parse_args( $qcld_wpvm_vmwbmdp_contacter_css_settings, $results );

		/** Material select need first letter in options value. And we don't. */
		$results['fbutton_c_form'] = str_replace( 'ID-', '', $results['fbutton_c_form'] );

		/** Set default VoiceMessageAddon Form. */
        if ( '' === $results['fbutton_c_form'] ) {
	        $results['fbutton_c_form'] = get_option( 'qcld_wpvm_vmwbmdp_contacter_default_form_id', '' );
        }

		$this->options = $results;
	}

	/**
	 * Moving from uploaded key file to stored in DB value.
	 *
	 * @param array $options - All plugin settings.
	 *
	 * @since  3.0.0
	 * @access public
	 * @return void|array
	 **/
	private function migrate_key_file_to_settings( $options ) {

		/** Do nothing if we already have dnd-api-key value. */
		if ( isset( $options['dnd-api-key'] ) && strlen( $options['dnd-api-key'] ) > 10 ) { return $options; }

		/** Do we have key file? */
		if ( ! isset( $options['api_key'] ) ) { return $options; }

		/** File ID is empty. */
		if ( ! trim( $options['api_key'] ) ) {  return $options; }

		/** Get path to file by attachments id. */
		$key_path = get_attached_file( $options['api_key'] );

		/** The WordPress filesystem. */
		global $wp_filesystem;

		/** Instantiate the WordPress filesystem. */
		Helper::init_filesystem();

		/** Read Key File Content. */
		$key_content = $wp_filesystem->get_contents( $key_path );

		/** Check if json is valid for the key. */
		if ( is_object( json_decode( $key_content, false ) ) ) {

			/** Convert old value to new format. */
			$options['dnd-api-key'] =  base64_encode( $key_content );

		} else {

			/** Clear dnd-api-key option. */
			$options['dnd-api-key'] = '';

		}

		/** Clear Old api_key option. */
		$options['api_key'] = '';

		/** Update new values in DB. */
		update_option( 'qcld_wpvm_vmwbmdp_contacter_settings', $options );

		return $options;

	}

	/**
	 * Main Settings Instance.
	 *
	 * Insures that only one instance of Settings exists in memory at any one time.
	 *
	 * @static
	 * @return Settings
	 * @since 1.0.0
	 **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

} // End Class Settings.
