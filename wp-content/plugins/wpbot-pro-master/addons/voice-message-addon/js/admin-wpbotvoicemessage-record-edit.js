
/** Run jQuery scripts */
( function ( $ ) {

    "use strict";

    /** Document Ready. */
    $( document ).ready( function () {

        /** Show warning if we try to leave with unsaved changes. */
        let unsaved = false;

        /** Triggers change in all input fields including text type. */
        $( ':input' ).on( 'change', function() { unsaved = true; } );

        $( '.vmwbmdp-generate-transcription-btn' ).on( 'click', function ( e ) {
            e.preventDefault();

            if ( $( this ).hasClass( 'is-busy' ) ) { return; }

            /** Disable Button. */
            $( this ).addClass( 'is-busy' ).attr( 'disabled', true );

            let data = {
                action: 'gtrans',
                security: vmwbmdpContacter.ajax_nonce,
                record_id: vmwbmdpContacter.record_id
            };

            $.post( ajaxurl, data, function ( response ) {

                /** Add transcription if it is ready. */
                if ( ( 'ok' === response.status ) ) {

                    /** Set Transcription to Editor. */
                    if ( $( '#wp-vmwbmdptranscriptiontxt-wrap' ).hasClass( 'html-active' ) ) { // We are in text mode
                        $( '#vmwbmdptranscriptiontxt' ).val( response.transcription ); // Update the textarea's content
                    } else { // We are in tinyMCE mode
                        let transcriptionEditor = tinyMCE.get( 'vmwbmdptranscriptiontxt' );
                        if( transcriptionEditor !== null ) { // Make sure we're not calling setContent on null
                            transcriptionEditor.setContent( response.transcription ); // Update tinyMCE's content
                        }
                    }

                    /** If empty transcription. */
                    if ( '' === response.transcription.trim() ) {
                        alert( 'Failed to recognize anything on this audio. Transcription is empty.' );
                    }

                    unsaved = true;

                } else {

                    /** Show Error message to user. */
                    show_err_msg( response );

                }

            }, 'json' )
            .fail( function( response ) {

                show_err_msg( response );

            } )
            .always( function() {
                /** Enable Button. */
                $( '.vmwbmdp-generate-transcription-btn' ).removeClass( 'is-busy' ).attr( 'disabled', false );
            } );

            /** Show Alert with Error. */
            function show_err_msg( err ) {

                console.log( err );

                if ( err.message ) {
                    alert( 'ERROR:\n ' + err.message );
                } else if ( err.responseText ) {
                    alert( 'ERROR:\n ' + err.responseText );
                } else {
                    alert( 'ERROR:\n ' + err );
                }

            }

        } );


        /** Show warning for Unsaved changes. */
        window.onbeforeunload = function() {
            if ( unsaved ) {
                return 'It looks like you made changes and did not save it. Continue anyway?';
            }
        };

        /** Click on update button. */
        $( '#publish' ).on( 'click', function () {
            unsaved = false;
        } );

    } );

} ( jQuery ) );