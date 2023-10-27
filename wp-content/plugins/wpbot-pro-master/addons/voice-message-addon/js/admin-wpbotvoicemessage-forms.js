

/** Run jQuery scripts */
( function ( $ ) {

    "use strict";

    /** Document Ready. */
    $( document ).ready( function () {

        /**
         * Copy Shortcode code to clipboard.
         **/
        new ClipboardJS( '.vmwbmdp-wpbotvoicemessage-form-shortcode' );
        $( '.vmwbmdp-wpbotvoicemessage-form-shortcode' ).on( 'click', function ( e ) {
            e.preventDefault();

            /** Set Copied label for 3 sec. */
            $( this ).html( $( this ).data( 'copied-text' ) );
            setTimeout( ( $target ) => {
                $target.html( $target.data( 'copy-text' ) );
            }, 3000, $( this ) );

        } );

    } );

} ( jQuery ) );
