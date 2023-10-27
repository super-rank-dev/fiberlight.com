<?php
use QuantumCloud\wpbotvoicemessage;
use QuantumCloud\VoiceMessageAddon\Settings;
use QuantumCloud\VoiceMessageAddon\UI;
use QuantumCloud\VoiceMessageAddon\Helper;
use QuantumCloud\VoiceMessageAddon\CheckCompatibility;
use QuantumCloud\VoiceMessageAddon\SvgHelper;
use QuantumCloud\VoiceMessageAddon\CustomPost;
use QuantumCloud\VoiceMessageAddon\Shortcodes;
/*
//speech clients
use Google\ApiCore\ApiException;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;
*/
function qcld_wpbot_voice_send() {
    /** Verifies the Ajax request to prevent processing requests external of the blog. */
    check_ajax_referer( 'wpbotvoicemessage-nonce', 'nonce' );

    /** Exit if no data to process. */
    if ( empty( $_POST ) ) { wp_die(); }

    /** Get VoiceMessageAddon Form ID. */
    $cForm_id =  filter_input(INPUT_POST, 'cform-id', FILTER_SANITIZE_NUMBER_INT );

    /** Remove service variables. */
    unset( $_POST['action'], $_POST['nonce'], $_POST['cform-id'] );

    /** Save Audio file. */
    $audio_file_path = qcld_save_audio_file( $cForm_id );

    /** Create qcldwpbot_record record. */
    $post_id = qcld_voice_create_record( $cForm_id, $audio_file_path );

    /** Fire event to send email notification. */
    do_action( 'qcldwpbot_record_added', $post_id );

    echo 'ok';

    wp_die();
}

function qcld_remove_wp_copyrights() {
    /** Remove "Thank you for creating with WordPress" and WP version from plugin settings page. */
    $screen = get_current_screen(); // Get current screen.
    if ( null === $screen ) { return; }

    /** VoiceMessageAddon Settings Page. */
    if ( $screen->base === wpbotvoicemessage::$menu_base ) {
        add_filter( 'admin_footer_text', '__return_empty_string', 11 );
        add_filter( 'update_footer', '__return_empty_string', 11 );
    }
}

function qcld_remove_all_notices() {
    /** Work only on plugin settings page. */
    $screen = get_current_screen();
    if ( null === $screen ) { return; }

    if ( $screen->base !== wpbotvoicemessage::$menu_base ) { return; }

    /** Remove other notices. */
    remove_all_actions( 'admin_notices' );
    remove_all_actions( 'all_admin_notices' );

    /** Show admin warning, if we need API Key. */
    $speech_recognition = 'on' === Settings::get_instance()->options['speech_recognition'];
    $dnd_api_key = Settings::get_instance()->options['dnd-api-key'];
    if ( $speech_recognition && ! $dnd_api_key ) {
        add_action( 'admin_notices', 'qcld_api_key_notice' );
    }
}

function qcld_api_key_notice() {

    /** Get current screen. */
    $screen = get_current_screen();
    if ( null === $screen ) { return; }

    /** VoiceMessageAddon Settings Page. */
    if ( wpbotvoicemessage::$menu_base === $screen->base  ) {

        /** Render "Before you start" message. */
        UI::get_instance()->render_snackbar(
            esc_html__( 'This plugin uses the Google Cloud Speech-to-Text API Key File. Set up your Google Cloud Platform project before the start.', 'wpbotvoicemessage' ),
            'warning', // Type
            -1, // Timeout
            true, // Is Closable
            [ [ 'caption' => 'Get Key File', 'link' => '#' ] ] // Buttons
        );

    }

}

function qcld_save_audio_file( $cForm_id ) {

    if ( empty( $_FILES['vmwbmdp-wpbotvoicemessage-audio'] ) ) { return false; }

    /** Create file name for audio file. */
    $file_path = qcld_prepare_audio_name( $cForm_id );

    /** Check file mime type. */
    $mime = mime_content_type( $_FILES['vmwbmdp-wpbotvoicemessage-audio']['tmp_name'] );

    /** Looks like uploading some shit. */
    if ( ! in_array( $mime, [ 'audio/wav', 'audio/x-wav' ] ) ) {

        /** Remove temporary audio file. */
        wp_delete_file( $_FILES['vmwbmdp-wpbotvoicemessage-audio']['tmp_name'] );

        wp_die(); // Emergency exit.
    }

    /** Save audio file. */
    file_put_contents( $file_path, file_get_contents( $_FILES['vmwbmdp-wpbotvoicemessage-audio']['tmp_name'] ), FILE_APPEND );

    /** Remove temporary audio file. */
    wp_delete_file( $_FILES['vmwbmdp-wpbotvoicemessage-audio']['tmp_name'] );

    return $file_path;

}

function qcld_prepare_audio_name( $cForm_id ) {

    /** Prepare File name. */
    $upload_dir     = wp_get_upload_dir();
    $upload_basedir = $upload_dir['basedir'] . '/wpbotvoicemessage/'; // Path to upload folder.

    $unique_counter = 0;
    $file_name = qcld_build_file_name( $cForm_id, $unique_counter );

    /** We do not need collisions. */
    $f_path = $upload_basedir . $file_name;
    if ( file_exists( $f_path ) ) {

        do {
            $unique_counter++;
            $file_name = qcld_build_file_name( $cForm_id, $unique_counter );
            $f_path = $upload_basedir . $file_name;
        } while ( file_exists( $f_path ) );

    }

    $f_path = wp_normalize_path( $f_path );
    $f_path = str_replace( ['/', '\\'], DIRECTORY_SEPARATOR, $f_path );

    return $f_path;

}

function qcld_build_file_name( $cForm_id, $unique_counter ) {
    return 'wpbotvoicemessage-' . $cForm_id . '-' . gmdate( 'Y-m-d\TH:i:s\Z' ) . '-' . $unique_counter . '.wav';
}

function qcld_voice_create_record( $cForm_id, $audio_file_path ) {

    /** VoiceMessageAddon Form. */
    $cForm = get_post( $cForm_id );

    /** Create record. */
    $post_id = wp_insert_post( [
        'post_type'     => 'qcldwpbot_record',
        'post_title'    => 'Record: ' . $cForm->post_title,
        'post_status'   => 'pending',
    ] );

    /** Fill meta fields. */
    if ( $post_id ) {

        /** Save audio file. */
        update_post_meta( $post_id, 'qcld_wpvm_vmwbmdp_contacter_audio', wp_slash( $audio_file_path ) );

        /** Save audio sample rate. */
        $sample_rate = filter_input(INPUT_POST, 'vmwbmdp-wpbotvoicemessage-audio-sample-rate', FILTER_SANITIZE_STRING );
        update_post_meta( $post_id, 'qcld_wpvm_vmwbmdp_contacter_audio_sample_rate', $sample_rate );

        /** Save VoiceMessageAddon Form ID. */
        update_post_meta( $post_id, 'vmwbmdp_cform_id', $cForm_id );

        /** Prepare Additional fields. */
        $fields_fb = get_post_meta( $cForm_id, 'vmwbmdp_additional_fields_fb', true );
        $fields_fb = json_decode( $fields_fb, true ); // Array with fields params.

        $additional_fields = [];
        foreach ( $_POST as $key => $value ) {
            foreach ( $fields_fb as $field ) {
                if ( $key === $field['name'] ) {
                    $additional_fields[$key] = [
                        'label' => $field['label'],
                        'value' => $value
                    ];
                }
            }
        }

        $additional_fields = json_encode( $additional_fields );
        $additional_fields = wp_slash( $additional_fields );

        /** Save Additional fields. */
        update_post_meta( $post_id, 'vmwbmdp_additional_fields', $additional_fields );

    }

    return $post_id;

}

function qcld_get_inline_css( $options ) {

    /** Extract variables. */
    $margin = $options['fbutton_margin'];
    $padding = $options['fbutton_padding'];
    $radius = $options['fbutton_border_radius'];
    $color = $options['fbutton_color'];
    $color_hover = $options['fbutton_color_hover'];
    $bg_color = $options['fbutton_bgcolor'];
    $bg_color_hover = $options['fbutton_bgcolor_hover'];
    $size = $options['fbutton_size'];
    $delay = $options['fbutton_entrance_timeout'];
    $overlay_bg = $options['modal_overlay_color'];
    $modal_bg = $options['modal_bg_color'];
    $modal_radius = $options['modal_radius'];

    // language=CSS
    /** @noinspection CssUnusedSymbol */
    return "
        .vmwbmdp-wpbotvoicemessage-fbutton-box {
            margin: {$margin}px;
        }
        
        .vmwbmdp-wpbotvoicemessage-fbutton-box button {		        
            padding: {$padding}px;
            border-radius: {$radius}px;
            color: {$color};
            background: {$bg_color};
            font-size: {$size}px;
        }
        
        .vmwbmdp-wpbotvoicemessage-fbutton-box:hover button {
            color: {$color_hover};
            background: {$bg_color_hover}; 
        }
        
        .vmwbmdp-wpbotvoicemessage-fbutton-box button .vmwbmdp-wpbotvoicemessage-fbutton-icon svg {
            fill: {$color};
            width: {$size}px;
            height: {$size}px;
        }
        
        .vmwbmdp-wpbotvoicemessage-fbutton-box:hover button .vmwbmdp-wpbotvoicemessage-fbutton-icon svg {
            fill: {$color_hover};
        }
        
        .vmwbmdp-wpbotvoicemessage-fbutton-box button#vmwbmdp-wpbotvoicemessage-fbutton span:nth-child(2), .vmwbmdp-wpbotvoicemessage-start-btn span:nth-child(2) {
            padding: calc({$padding}px / 2);
        }
        
        .vmwbmdp-wpbotvoicemessage-fbutton-box.vmwbmdp-entrance-bounce,
        .vmwbmdp-wpbotvoicemessage-fbutton-box.vmwbmdp-entrance-fade,
        .vmwbmdp-wpbotvoicemessage-fbutton-box.vmwbmdp-entrance-flip-x,
        .vmwbmdp-wpbotvoicemessage-fbutton-box.vmwbmdp-entrance-flip-y,
        .vmwbmdp-wpbotvoicemessage-fbutton-box.vmwbmdp-entrance-scale,
        .vmwbmdp-wpbotvoicemessage-fbutton-box.vmwbmdp-entrance-wobble,
        .vmwbmdp-wpbotvoicemessage-fbutton-box.vmwbmdp-entrance-rotate {
            animation-delay: {$delay}s
        }
        
        /* Modal Popup. */
        .vmwbmdp-wpbotvoicemessage-fbutton-overlay {
            background: {$overlay_bg};
        }
        
        .vmwbmdp-wpbotvoicemessage-fbutton-overlay .vmwbmdp-wpbotvoicemessage-fbutton-modal {
            background: {$modal_bg};
            border-radius: {$modal_radius}px;
        }
    ";

}

function qcld_missing_main_plugin(){
    $class="notice notice-error is-dismissible qc-notice-error";
    

    $message = "You need to install and activate the <a href='https://www.quantumcloud.com/products/chatbot-for-wordpress/' target='_blank'>WPBot</a> Plugin to use the <strong>Voice Message for WPBot</strong> AddOn";

    printf( '<div class="%1$s"><a href="'.esc_url('https://www.quantumcloud.com/products/chatbot-for-wordpress/').'" target="_blank"><img src="'.esc_url(plugin_dir_url( __FILE__ ).'plugin-upgrader/images/qc-logo.jpg').'" /></a><p>%2$s</p></div>', esc_attr( $class ), $message );
}

function qcld_gtrans() {

    /** Verifies the Ajax request to prevent processing requests external of the blog. */
    check_ajax_referer( 'admin-wpbotvoicemessage-nonce', 'security' );

    /** Exit if no data to process. */
    if ( empty( $_POST ) ) {
        echo json_encode([
            'status' => 'err',
            'message' => 'empty( $_POST ).'
        ]);
        wp_die();
    }

    /** Remove service variables. */
    unset( $_POST['action'], $_POST['nonce'] );

    /** Get VoiceMessageAddon Record ID. */
    $record_id =  filter_input(INPUT_POST, 'record_id', FILTER_SANITIZE_NUMBER_INT );
    if ( ! $record_id ) {
        echo json_encode([
            'status' => 'err',
            'message' => 'VoiceMessageAddon Record ID not found.'
        ]);
        wp_die();
    }

    /** Get Audio path value from meta if it's exist. */
    $audio_path = get_post_meta( $record_id, 'qcld_wpvm_vmwbmdp_contacter_audio', true );
    if ( empty( $audio_path ) ) {
        echo json_encode([
            'status' => 'err',
            'message' => 'Audio path is empty.'
        ]);
        wp_die();
    }

    /** Get contents of a file into a string. */
    $content = file_get_contents( $audio_path );

    /** Set string as audio content. */
    $audio = ( new RecognitionAudio() )->setContent( $content );

    /** Automatic punctuation. */
    $punctuation = false;
    if ( 'on' === Settings::get_instance()->options['punctuation'] ) {
        $punctuation = true;
    }

    /** Get Audio Sample Rate. */
    $sample_rate = get_post_meta( $record_id, 'qcld_wpvm_vmwbmdp_contacter_audio_sample_rate', true );
    if ( ! $sample_rate ) {
        $sample_rate = 44100;
    }

    /** The audio file's encoding, sample rate and language. */
    $config = new RecognitionConfig([
        'encoding' => AudioEncoding::LINEAR16,
        'sample_rate_hertz' => $sample_rate,
        'language_code' => Settings::get_instance()->options['language'],
        'enable_automatic_punctuation' => $punctuation,
    ]);

    /** Instantiates a client. */
    $client = new SpeechClient();

    /** Detects speech in the audio file. */
    $response = $client->recognize( $config, $audio );

    /** Print most likely transcription. */
    $transcript = '';
    foreach ( $response->getResults() as $result ) {
        $alternatives = $result->getAlternatives();
        $mostLikely = $alternatives[0];
        $transcript = $mostLikely->getTranscript();
    }

    if ( $transcript ) {
        echo json_encode([
            'status' => 'ok',
            'transcription' => qcld_mb_ucfirst( $transcript )
        ]);
    } else {
        echo json_encode([
            'status' => 'ok',
            'transcription' => ''
        ]);
    }

    $client->close();

    wp_die();
}

function qcld_mb_ucfirst( $string ) {

    return mb_strtoupper( mb_substr( $string, 0, 1 ) ).mb_strtolower( mb_substr( $string, 1 ) );

}

function wpbotvoicemessage_order_index_catalog_menu_page( $menu_ord ){
    global $submenu; 
    $arr = array();

    $arr[] = $submenu['edit.php?post_type=qcldwpbot_record'][5];
    $arr[] = $submenu['edit.php?post_type=qcldwpbot_record'][11];
    //$arr[] = $submenu['edit.php?post_type=qcldwpbot_record'][13];
    $arr[] = $submenu['edit.php?post_type=qcldwpbot_record'][12];
    
    
    $submenu['edit.php?post_type=qcldwpbot_record'] = $arr;

    return $submenu;
}

function qcld_remove_trash_filter( $views ) {
    $remove_views = [ 'trash' ];

    foreach( (array) $remove_views as $view )
    {
        if( isset( $views[$view] ) )
            unset( $views[$view] );
    }
    return $views;
}

function qcld_remove_row_actions_post( $actions, $post ) {
    if( $post->post_type === 'contacter_form_qcld' ) {
        unset( $actions['clone'] );
        unset( $actions['trash'] );
    }
    return $actions;
}

function qcld_restrict_post_deletion($post_id) {
    if( get_post_type($post_id) === 'contacter_form_qcld' ) {
      wp_die('The post you were trying to delete is protected.');
    }
}

function qcld_get_contacter_inline_css() {

    /** Get Plugin Settings. */
    $options = Settings::get_instance()->options;

    /** Accent Color. */
    $accent_color = $options['accent_color'];

    // language=CSS
    /** @noinspection CssUnusedSymbol */
    return "
        .vmwbmdp-wpbotvoicemessage-player-box.green-audio-player .slider .gap-progress,
        .vmwbmdp-wpbotvoicemessage-player-box.green-audio-player .slider .gap-progress .pin {
            background-color: {$accent_color};
        }
        
        .vmwbmdp-wpbotvoicemessage-player-box.green-audio-player .volume .volume__button.open path {
            fill: {$accent_color};
        } 
    ";

}

function qcld_voice_admin_styles() {

    /** Get current screen to add styles on specific pages. */
    $screen = get_current_screen();
    if ( null === $screen ) { return; }

    /** VoiceMessageAddon Settings Page. */
    if ( wpbotvoicemessage::$menu_base === $screen->base ) {
        wp_enqueue_style( 'qcldvoicebot-ui', wpbotvoicemessage::$url . 'css/qcldvoicebot-ui' . wpbotvoicemessage::$suffix . '.css', [], wpbotvoicemessage::$version );
        wp_enqueue_style( 'vmwbmdp-wpbotvoicemessage-admin', wpbotvoicemessage::$url . 'css/admin' . wpbotvoicemessage::$suffix . '.css', [], wpbotvoicemessage::$version );

    /** VoiceMessageAddon popup on update. */
    } elseif ( 'plugin-install' === $screen->base ) {

        /** Styles only for our plugin. */
        if ( isset( $_GET['plugin'] ) && $_GET['plugin'] === 'wpbotvoicemessage' ) {
            wp_enqueue_style( 'vmwbmdp-wpbotvoicemessage-plugin-install', wpbotvoicemessage::$url . 'css/plugin-install' . wpbotvoicemessage::$suffix . '.css', [], wpbotvoicemessage::$version );
        }

    /** VoiceMessageAddon Form edit screen. */
    } elseif ( 'post' === $screen->base && 'contacter_form_qcld' === $screen->post_type ) {

        /** Add class .mdc-disable to body. So we can use UI without overrides WP CSS, only for this page.  */
        add_action( 'admin_body_class', 'qcld_add_admin_class' );

        wp_enqueue_style( 'qcldvoicebot-ui', wpbotvoicemessage::$url . 'css/qcldvoicebot-ui' . wpbotvoicemessage::$suffix . '.css', [], wpbotvoicemessage::$version );
        wp_enqueue_style( 'vmwbmdp-admin-wpbotvoicemessage-form-edit', wpbotvoicemessage::$url . 'css/admin-wpbotvoicemessage-form-edit' . wpbotvoicemessage::$suffix . '.css', [], wpbotvoicemessage::$version );

    /** VoiceMessageAddon Record edit screen. */
    } elseif ( 'post' === $screen->base && 'qcldwpbot_record' === $screen->post_type ) {

        wp_enqueue_style( 'vmwbmdp-admin-wpbotvoicemessage-record-edit', wpbotvoicemessage::$url . 'css/admin-wpbotvoicemessage-record-edit' . wpbotvoicemessage::$suffix . '.css', [], wpbotvoicemessage::$version );

    /** VoiceMessageAddon Forms list. */
    } elseif ( 'edit' === $screen->base && 'contacter_form_qcld' === $screen->post_type ) {

        wp_enqueue_style( 'vmwbmdp-admin-wpbotvoicemessage-forms', wpbotvoicemessage::$url . 'css/admin-wpbotvoicemessage-forms' . wpbotvoicemessage::$suffix . '.css', [], wpbotvoicemessage::$version );
    }

}

function qcld_add_admin_class( $classes ) {
    return $classes . ' mdc-disable ';
}

function qcld_voice_admin_scripts() {

    /** Get current screen to add scripts on specific pages. */
    $screen = get_current_screen();
    if ( null === $screen ) { return; }

    /** VoiceMessageAddon Settings Page. */
    if ( $screen->base === wpbotvoicemessage::$menu_base ) {
        wp_enqueue_script( 'qcldvoicebot-ui', wpbotvoicemessage::$url . 'js/qcldvoicebot-ui' . wpbotvoicemessage::$suffix . '.js', [], wpbotvoicemessage::$version, true );
        wp_enqueue_media(); // WordPress Image library for API Key File.
        wp_enqueue_script( 'vmwbmdp-wpbotvoicemessage-admin', wpbotvoicemessage::$url . 'js/admin' . wpbotvoicemessage::$suffix . '.js', ['jquery'], wpbotvoicemessage::$version, true );

        wp_localize_script('vmwbmdp-wpbotvoicemessage-admin', 'vmwbmdpContacter', [
            'ajaxURL' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'reset_settings' ),
            'contacter_nonce' => wp_create_nonce( 'wpbotvoicemessage-nonce' ), // Nonce for security.
        ] );

    /** VoiceMessageAddon Form edit screen. */
    } elseif ( 'post' === $screen->base && 'contacter_form_qcld' === $screen->post_type ) {

        /** Add class .mdc-disable to body. So we can use UI without overrides WP CSS, only for this page. */
        add_action( 'admin_body_class', 'qcld_add_admin_class' );

        wp_enqueue_script( 'qcldvoicebot-ui', wpbotvoicemessage::$url . 'js/qcldvoicebot-ui' . wpbotvoicemessage::$suffix . '.js', [], wpbotvoicemessage::$version, true );
        wp_enqueue_script( 'form-builder', wpbotvoicemessage::$url . 'js/form-builder.min.js', ['jquery', 'jquery-ui-sortable'], wpbotvoicemessage::$version, true );
        wp_enqueue_script( 'form-render', wpbotvoicemessage::$url . 'js/form-render.min.js', ['jquery', 'jquery-ui-sortable'], wpbotvoicemessage::$version, true );
        wp_enqueue_script( 'vmwbmdp-wpbotvoicemessage-clipboard', wpbotvoicemessage::$url . 'js/clipboard' . wpbotvoicemessage::$suffix . '.js', [], wpbotvoicemessage::$version, true );
        wp_enqueue_script( 'vmwbmdp-admin-wpbotvoicemessage-form-edit', wpbotvoicemessage::$url . 'js/admin-wpbotvoicemessage-form-edit' . wpbotvoicemessage::$suffix . '.js', ['jquery', 'form-builder', 'vmwbmdp-wpbotvoicemessage-clipboard'], wpbotvoicemessage::$version, true );
        wp_localize_script( 'vmwbmdp-admin-wpbotvoicemessage-form-edit', 'vmwbmdpContacter', [
            'locale' => qcld_get_fb_locale(),
            'location' => wpbotvoicemessage::$url . 'js/form-builder-languages/'
        ] );

    /** VoiceMessageAddon Record edit screen. */
    } elseif ( 'post' === $screen->base && 'qcldwpbot_record' === $screen->post_type ) {

        wp_enqueue_script( 'vmwbmdp-admin-wpbotvoicemessage-record-edit', wpbotvoicemessage::$url . 'js/admin-wpbotvoicemessage-record-edit' . wpbotvoicemessage::$suffix . '.js', [], wpbotvoicemessage::$version, true );

        /** Set Nonce. */
        $ajax_nonce = wp_create_nonce( 'admin-wpbotvoicemessage-nonce' );

        /** Current record ID. */
        $id = get_the_ID();

        wp_localize_script( 'vmwbmdp-admin-wpbotvoicemessage-record-edit', 'vmwbmdpContacter', [
            'record_id'  => $id,
            'ajax_nonce' => $ajax_nonce,
        ] );

    /** VoiceMessageAddon Forms list. */
    } elseif ( 'edit' === $screen->base && 'contacter_form_qcld' === $screen->post_type ) {

        wp_enqueue_script( 'vmwbmdp-wpbotvoicemessage-clipboard', wpbotvoicemessage::$url . 'js/clipboard' . wpbotvoicemessage::$suffix . '.js', [], wpbotvoicemessage::$version, true );
        wp_enqueue_script( 'vmwbmdp-admin-wpbotvoicemessage-forms', wpbotvoicemessage::$url . 'js/admin-wpbotvoicemessage-forms' . wpbotvoicemessage::$suffix . '.js', ['jquery', 'vmwbmdp-wpbotvoicemessage-clipboard'], wpbotvoicemessage::$version, true );

    }

}

function qcld_get_fb_locale() {

    /** Get current user Locale. */
    $locale = get_user_locale();

    /** Convert "en_US" to "en-US". */
    $locale = str_replace( '_', '-', $locale );

    /** Do we have translations file for this locale? */
    if ( file_exists( wpbotvoicemessage::$path . 'js/form-builder-languages/' . $locale . '.lang' ) ) {
        return $locale;
    }

    return 'en-US';

}

add_action('qcldwpbot_record_added', 'qcldwpbot_record_added');
function qcldwpbot_record_added($post_id){
	$audio_path = get_post_meta( $post_id, 'qcld_wpvm_vmwbmdp_contacter_audio', true );
	$url = str_replace(
		wp_normalize_path( untrailingslashit( ABSPATH ) ),
		site_url(),
		wp_normalize_path( $audio_path )
	);

	$url = esc_url_raw( $url );
	
	/** Get Additional fields switcher value from meta if it's already been entered. */
	$vmwbmdp_additional_fields = get_post_meta( $post_id, 'vmwbmdp_additional_fields', true );

	/** Default value. Additional Fields switcher. */
	if ( '' === $vmwbmdp_additional_fields ) {
		$vmwbmdp_additional_fields = '';
	}

	$fields = json_decode( $vmwbmdp_additional_fields, true );
	$mail_content = "<table>";
	if ( count( $fields ) > 0 ) {
		$mail_content  = '<tr>';
	    $mail_content .= '<th scope="row">';
	    $mail_content .= '<label>'.esc_html_e( "Additional fields:", "wpbotvoicemessage" ) .'</label>';
	    $mail_content .= '</th>';
	    $mail_content .=  '<td>';
	    $mail_content .=  '<div class="vmwbmdp-additional-fields-box">';
	    $mail_content .=  '<table>';
	    
	    foreach ( $fields as $key => $field  ) {
	    
	        $mail_content .= '<tr class="'. esc_attr_e( $key ).'">';
	        $mail_content .= '<td><strong>'. esc_html_e( $field['label'] ) .':</strong></td>';
	        $mail_content .= '<td>';
			if ( is_array( $field['value'] ) ) :
	        	$mail_content .= '<ul>';
				foreach ( $field['value'] as $v ) :
	                $mail_content .= '<li><span>'. esc_html_e( $v ) .'</span></li>';
	            endforeach;
	            $mail_content .= '</ul>';
			else:
	        	$mail_content .= '<span>'. esc_html_e( $field['value'] ).'</span>';
			endif;
	            $mail_content .= '</td>';
				$mail_content .= '</tr>';
	    }
	    $mail_content .= '</table>';
	    $mail_content .= '</div>';
	    $mail_content .= '</td>';
	    $mail_content .= '</tr>';
	}
	$mail_content .= '<tr>';
	$mail_content .= '<th scope="row">Download Link</th>';
	$mail_content .= '<td>';
	$mail_content .= '<a href="'.$url.'">'.$url.'</a>';
	$mail_content .= '</td>';
	$mail_content .= '</tr>';
	$mail_content .= '</table>';

	 //Extract Domain
    $url = get_site_url();
    $url = parse_url($url);
    $domain = $url['host'];
    
    $admin_email = get_option('admin_email');
    $toEmail = get_option('qlcd_wp_chatbot_admin_email') != '' ? get_option('qlcd_wp_chatbot_admin_email') : $admin_email;
    $fromEmail = "wordpress@" . $domain;

    if(get_option('qlcd_wp_chatbot_from_email') && get_option('qlcd_wp_chatbot_from_email')!=''){
        $fromEmail = get_option('qlcd_wp_chatbot_from_email');
    }

    $replyto = $fromEmail;

    if(get_option('qlcd_wp_chatbot_reply_to_email') && get_option('qlcd_wp_chatbot_reply_to_email')!=''){
        $replyto = get_option('qlcd_wp_chatbot_reply_to_email');
    }
    $subject = __('WPBot Voice Message', 'wpbotvoicemessage');
	$headers = array();
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $result = wp_mail($toEmail, $subject, $mail_content, $headers);
}

function qcld_voice_render_fbutton() {

    /** Get Plugin Settings. */
    $options = Settings::get_instance()->options;

    /** Form not exist or not publish => exit. */
    if ( 'publish' !== get_post_status( $options['fbutton_c_form'] ) ) { return; }

    /** Add inline styles for float button. */
    $css = qcld_get_inline_css( $options );
    wp_add_inline_style( 'vmwbmdp-wpbotvoicemessage', $css );

    /** Prepare Classes. */
    $classes = ' vmwbmdp-wpbotvoicemessage-fbutton-box ';
    $classes .= ' ' . $options['fbutton_position'] . ' '; // Float Button Position.
    $classes .= ' vmwbmdp-entrance-' . $options['fbutton_animation'] . ' '; // Entrance Animation.
    $classes .= ' vmwbmdp-hover-' . $options['fbutton_hover_animation'] . ' '; // Float Button Hover Animation.
    $classes = trim( $classes );

    ?>
    <!-- Start VoiceMessageAddon WordPress Plugin -->
    <div class="<?php esc_attr_e( $classes ); ?>">
        <button id="vmwbmdp-wpbotvoicemessage-fbutton" class="vmwbmdp-icon-position-<?php esc_attr_e( $options['fbutton_icon_position'] ); ?>">
            <?php if ( $options['fbutton_icon_position'] !== 'none' ) : ?>
                <span class="vmwbmdp-wpbotvoicemessage-fbutton-icon"><?php Helper::get_instance()->inline_svg_e( $options['fbutton_icon'] ); ?></span>
            <?php endif; ?>

            <?php if ( $options['fbutton_caption'] ) : ?>
                <span class="vmwbmdp-wpbotvoicemessage-fbutton-caption"><?php echo wp_kses_post( $options['fbutton_caption'] ); ?></span>
            <?php endif; ?>
        </button>
    </div>
    <div class="vmwbmdp-wpbotvoicemessage-fbutton-overlay vmwbmdp-wpbotvoicemessage-modal-animation-<?php esc_attr_e( $options['modal_animation'] ); ?>">
        <div class="vmwbmdp-wpbotvoicemessage-modal-wrap">
        <div class="vmwbmdp-wpbotvoicemessage-fbutton-modal">
            <span class="vmwbmdp-wpbotvoicemessage-close"></span>
            <?php echo do_shortcode( '[wpbotvoicemessage id="' . $options['fbutton_c_form'] . '"]' ); ?>
        </div>
        </div>
    </div>
    <!-- End VoiceMessageAddon WordPress Plugin -->
    <?php

}

function qcld_check_compat() {
    /** Do critical initial checks. */
    if ( ! CheckCompatibility::get_instance()->do_initial_checks( true ) ) { return false; }
    if( ! class_exists( 'qcld_wb_Chatbot' ) ){
        add_action('admin_notices', 'qcld_missing_main_plugin');
        return false;
    }
    return true;
}

function qcld_fnc_hook_setup() {
    /** Initialize plugin settings. */
    Settings::get_instance();

    /** Load translation. */
    add_action( 'plugins_loaded', 'qcld_voice_load_textdomain' );

    /** Register contacter_form_qcld and qcldwpbot_record post types. */
    CustomPost::get_instance();

    /** Adds all the necessary shortcodes. */
    Shortcodes::get_instance();

    /** Allow svg uploading. */
    SvgHelper::get_instance();

    /** Add AJAX callback. */
    add_action( 'wp_ajax_wpbotvoicemessage_send', 'qcld_wpbot_voice_send' );
    add_action( 'wp_ajax_nopriv_wpbotvoicemessage_send', 'qcld_wpbot_voice_send' );
}

function qcld_voice_load_textdomain() {
    load_plugin_textdomain( 'wpbotvoicemessage', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

function qcld_load_backend_styles_scripts() {
    /** Load JS and CSS for Backend Area. */
    add_action( 'admin_enqueue_scripts', 'qcld_voice_admin_styles', 100 ); // CSS.
    add_action( 'admin_enqueue_scripts', 'qcld_voice_admin_scripts', 100 ); // JS.
    add_action( 'admin_enqueue_scripts', 'qcld_remove_wp_copyrights' );
    add_action( 'in_admin_header', 'qcld_remove_all_notices', 1000 );
    add_action( 'wp_ajax_gtrans', 'qcld_gtrans' );
    add_filter( 'custom_menu_order', 'wpbotvoicemessage_order_index_catalog_menu_page' );

    // Removes the "Trash" link on the individual post's "actions" row on the posts
    add_action('views_edit-contacter_form_qcld', 'qcld_remove_trash_filter');
    add_filter( 'post_row_actions', 'qcld_remove_row_actions_post', 10, 2 );
    add_action('wp_trash_post', 'qcld_restrict_post_deletion');
}