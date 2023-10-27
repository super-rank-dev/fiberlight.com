/** Run jQuery scripts */
( function ( $ ) {

    "use strict";

    /** Document Ready. */
    $( document ).ready( function () {

        // noinspection JSUnresolvedVariable
        /** Data from WordPress. */
        let vmwbmdpContacter = window.vmwbmdpContacter;

        /** Show Developer tab on multiple logo clicks. */
        $( '.mdc-list .mdc-list-item.vmwbmdp-plugin-title' ).on( 'click', function () {

            let count = $( this ).data( 'count' );

            if ( typeof count === 'undefined' ) {
                count = 0;

                setTimeout( function () {
                    $( '.mdc-list .mdc-list-item.vmwbmdp-plugin-title' ).removeData( 'count' );
                }, 2000 );
            }

            count++;
            $( this ).data( 'count', count );

            if ( count > 3 ) {

                $( '.mdc-list > .mdc-list-item.vmwbmdp-developer' ).removeClass( 'mdc-hidden' ).addClass( 'mdc-list-item--activated' );

                $( '.mdc-list .mdc-list-item.vmwbmdp-plugin-title' ).removeData( 'count' );

            }

        } );

        /** Developer Tab: Reset Settings */
        $( '#vmwbmdp-dev-reset-settings-btn' ).on( 'click', function ( e ) {

            e.preventDefault();

            /** Disable button and show process. */
            $( this ).attr( 'disabled', true ).addClass( 'vmwbmdp-spin' ).find( '.material-icons' ).text('refresh');

            /** Prepare data for AJAX request. */
            let data = {
                action: 'reset_settings',
                nonce: vmwbmdpContacter.nonce,
                doReset: true
            };

            /** Make POST AJAX request. */
            $.post( vmwbmdpContacter.ajaxURL, data, function( response ) {

                console.log( 'Settings Successfully Cleared.' );

            }, 'json' ).fail( function( response ) {

                /** Show Error message if returned some data. */
                console.log( response );
                alert( 'Looks like an Error has occurred. Please try again later.' );

            } ).always( function() {

                /** Enable button again. */
                $( '#vmwbmdp-dev-reset-settings-btn' )
                    .attr( 'disabled', false )
                    .removeClass( 'vmwbmdp-spin' )
                    .find( '.material-icons' )
                    .text('clear_all');

            } );

        } );

        /** Initialize CSS Code Editor. */
        let css_editor;
        if ( $( '#vmwbmdp_custom_css_fld' ).length ) {

            let editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
                    mode: 'css'
                }
            );

            css_editor = wp.codeEditor.initialize( 'vmwbmdp_custom_css_fld', editorSettings );

            css_editor.codemirror.on( 'change', function( cMirror ) {
                css_editor.codemirror.save(); // Save data from CodeEditor to textarea.
                $( '#vmwbmdp_custom_css_fld' ).change();
            } );
        }

        /** The "Select Key File" button. */
        $( '.vmwbmdp-select-key-file-btn' ).on( 'click', function( e ) {
            e.preventDefault();
            let button = $( this );
            let key_uploader = wp.media( {
                title: 'Select or Upload API Key File',
                button: {
                    text: 'Use this API Key'
                },
                library: {
                    type: [ 'application/json', 'text/plain', 'json', 'text' ]
                },
                multiple: false  // Select only one file.
            } )
            .on('select', function() {
                let attachment = key_uploader.state().get('selection').first().toJSON();
                $( button ).prev().val( attachment.id );
                $( button ).next().text( attachment.filename );

                $( '#submit' ).trigger( 'click' );
            } )
            .open();
        } );

        /**
         * Show/hide Download Link fields.
         **/
        let downloadLinkSwitcher = $( '#vmwbmdp-wpbotvoicemessage-settings-show-download-link' );
        function ShowDownloadLinkFields() {

            if ( downloadLinkSwitcher.prop( 'checked' ) === true ) {

                downloadLinkSwitcher.closest( 'tr' ).next().show( 300 );

            } else {

                downloadLinkSwitcher.closest( 'tr' ).next().hide( 300 );

            }

            /** To fix input label. */
            let index = $( '#vmwbmdp-wpbotvoicemessage-settings-download-link-text' ).parent().data( 'mdc-index' );
            // noinspection SillyAssignmentJS
            window.MerkulovMaterial[index].value = window.MerkulovMaterial[index].value;

        }

        if ( downloadLinkSwitcher.length ) {
            downloadLinkSwitcher.on( 'click', ShowDownloadLinkFields );
            ShowDownloadLinkFields();
        }

        /**
         * Show/hide Speech Recognition fields.
         **/
        let SpeechSwitcher = $( '#qcld_wpvm_vmwbmdp_contacter_settings_speech_recognition' );
        function ShowSpeechRecognitionFields() {

            if ( SpeechSwitcher.prop( 'checked' ) === true ) {

                SpeechSwitcher.closest( 'tr' ).next().show( 300 ).next().show( 300 ).next().show( 300 );

                if ( ! $( '#vmwbmdp-wpbotvoicemessage-settings-dnd-api-key' ).val() ) {
                    SpeechSwitcher.closest( 'tr' ).next().show().next().hide().next().hide();
                }

            } else {

                SpeechSwitcher.closest( 'tr' ).next().hide( 300 ).next().hide( 300 ).next().hide( 300 );

            }
        }

        if ( SpeechSwitcher.length ) {
            SpeechSwitcher.on( 'click', ShowSpeechRecognitionFields );
            ShowSpeechRecognitionFields();
        }

        /**
         * Show/hide Float Button fields.
         **/
        let FButtonSwitcher = $( '#qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_show_fbutton' );
        function ShowFButtonSwitcherFields() {

            if ( FButtonSwitcher.prop( 'checked' ) === true ) {
                FButtonSwitcher.closest( 'tr' )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 )
                    .next().show( 300 );
            } else {
                FButtonSwitcher.closest( 'tr' )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 )
                    .next().hide( 300 );
            }
        }

        if ( FButtonSwitcher.length ) {
            FButtonSwitcher.on( 'click', ShowFButtonSwitcherFields );
            ShowFButtonSwitcherFields();
        }

        /**
         * Show/Hide Icon picker for float button depends to the icon position select.
         */
        const fbuttonIcon = '#qcld_wpvm_vmwbmdp_contacter_floatbutton_settings_fbutton_icon';
        if ( $( fbuttonIcon + '_position' ).val() === 'none' ) {
            $( fbuttonIcon ).closest( 'tr' ).hide();
        }
        $( fbuttonIcon + '_position' ).change(function() {
            this.value === "none" ?
                $( fbuttonIcon ).closest( 'tr' ).hide( 300 ):
                $( fbuttonIcon ).closest( 'tr' ).show( 300 );
        });

        /** Drag & Drop JSON reader. */
        let $dropZone = $( '#vmwbmdp-api-key-drop-zone' );
        $dropZone.on( 'dragenter', function() {
            hideMessage();
            $( this ).addClass( 'vmwbmdp-hover' );
        } );

        $dropZone.on('dragleave', function() {
            $( this ).removeClass( 'vmwbmdp-hover' );
        } );

        /** Setup DnD listeners. */
        $dropZone.on( 'dragover', handleDragOver );

        /** Text Input to store key file. */
        let $key_input = $( '#vmwbmdp-wpbotvoicemessage-settings-dnd-api-key' );

        /**
         * Read dragged file by JS.
         **/
        $dropZone.on( 'drop', function ( e ) {

            e.stopPropagation();
            e.preventDefault();

            // Show busy spinner.
            $( this ).removeClass( 'vmwbmdp-hover' );
            $dropZone.addClass( 'vmwbmdp-busy' );

            let file = e.originalEvent.dataTransfer.files[0]; // FileList object.

            /** Check is one valid JSON file. */
            if ( ! checkKeyFile( file ) ) {
                $dropZone.removeClass( 'vmwbmdp-busy' );
                return;
            }

            /** Read key file to input. */
            readFile( file )

        } );

        /**
         * Read key file to input.
         **/
        function readFile( file ) {

            let reader = new FileReader();

            /** Closure to capture the file information. */
            reader.onload = ( function( theFile ) {

                return function( e ) {

                    let json_content = e.target.result;

                    /** Check if a string is a valid JSON string. */
                    if ( ! isJSON( json_content ) ) {

                        showErrorMessage( '<b>Error</b>: Uploaded file is empty or not a valid JSON file.' );

                        $dropZone.removeClass( 'vmwbmdp-busy' );
                        $( this ).addClass( 'vmwbmdp-error' );
                        return;

                    }

                    /** Check if the key has required field. */
                    let key = JSON.parse( json_content );
                    if ( typeof( key.private_key ) === 'undefined' ){

                        showErrorMessage( '<b>Error</b>: Your API key file looks like not valid. Please make sure you use the correct key.' );

                        $dropZone.removeClass( 'vmwbmdp-busy' );
                        $( this ).addClass( 'vmwbmdp-error' );
                        return;

                    }

                    /** Encode and Save to Input. */
                    $key_input.val( btoa( json_content ) );

                    /** Hide error messages. */
                    hideMessage();

                    /** If we have long valid key in input. */
                    if ( $key_input.val().length > 1000 ) {

                        $( '#submit' ).click(); // Save settings.

                    } else {

                        showErrorMessage( '<b>Error</b>: Your API key file looks like not valid. Please make sure you use the correct key.' );
                        $dropZone.removeClass( 'vmwbmdp-busy' );
                        $( this ).addClass( 'vmwbmdp-error' );

                    }

                };

            } )( file );

            /** Read file as text. */
            reader.readAsText( file );

        }

        /**
         * Show upload form on click.
         **/
        let $file_input = $( '#vmwbmdp-dnd-file-input' );
        $dropZone.on( 'click', function () {

            $file_input.click();

        } );

        $file_input.on( 'change', function ( e ) {

            $dropZone.addClass( 'vmwbmdp-busy' );

            let file = e.target.files[0];

            /** Check is one valid JSON file. */
            if ( ! checkKeyFile( file ) ) {
                $dropZone.removeClass( 'vmwbmdp-busy' );
                return;
            }

            /** Read key file to input. */
            readFile( file );

        } );

        /** Show Error message under drop zone. */
        function showErrorMessage( msg ) {

            let $msgBox = $dropZone.next();

            $msgBox.addClass( 'vmwbmdp-error' ).html( msg );

        }

        /** Hide message message under drop zone. */
        function hideMessage() {

            let $msgBox = $dropZone.next();

            $msgBox.removeClass( 'vmwbmdp-error' ).html( '' );

        }

        /**
         * Check if a string is a valid JSON string.
         *
         * @param str - JSON string to check.
         **/
        function isJSON( str ) {

            try {

                JSON.parse( str );

            } catch ( e ) {

                return false;

            }

            return true;

        }

        function handleDragOver( e ) {

            e.stopPropagation();
            e.preventDefault();

        }

        /**
         * Check file is a single valid JSON file.
         *
         * @param file - JSON file to check.
         **/
        function checkKeyFile( file ) {

            /** Select only one file. */
            if ( null == file ) {

                showErrorMessage( '<b>Error</b>: Failed to read file. Please try again.' );

                return false;

            }

            /** Process json file only. */
            if ( ! file.type.match( 'application/json' ) ) {

                showErrorMessage( '<b>Error</b>: API Key must be a valid JSON file.' );

                return false;

            }

            return true;
        }

        /** Reset Key File. */
        $( '.vmwbmdp-wpbotvoicemessage-reset-key-btn' ).on( 'click', function () {

            $key_input.val( '' );
            $( '#submit' ).trigger( 'click' );

        } );

        qcld_wpvm_vmwbmdp_contacter_unsaved = false;

    } );

} ( jQuery ) );

