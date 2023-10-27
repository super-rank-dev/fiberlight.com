
/** Run jQuery scripts */
( function ( $ ) {

    "use strict";

    /** Document Ready. */
    $( document ).ready( function () {

        /** Prepare options for Form Builder. */
        let options = {
            i18n: {
                locale: window.vmwbmdpContacter.locale,
                location: window.vmwbmdpContacter.location,
                extension: '.lang'
            },

            // Disable useless controls.
            disableFields: [
                'autocomplete',
                'button',
                'file',
            ],

            // Control Order.
            controlOrder: [
                'text',
                'textarea',
                'select',
                'checkbox-group',
                'radio-group',
                'number',
                'date',
                'header',
                'paragraph',
                'hidden',
            ],

            // Disable unused actions.
            disabledActionButtons: [
                'data',
                'save'
            ],

            // Disable unused attributes.
            disabledAttrs: [
                'access',
                'value',
            ],

            // Custom Filed
            fields: [
                {
                    name: 'vmwbmdpCurrentURL',
                    className: 'vmwbmdpCurrentURL vmwbmdp-wpbotvoicemessage-hidden',
                    label: "Current URL",
                    type: "text",
                    description: "The address of the page from which the form was submitted.",
                    icon: ""
                }, {
                    name: 'vmwbmdpUserDetails',
                    className: 'vmwbmdpUserDetails vmwbmdp-wpbotvoicemessage-hidden',
                    label: "User Details",
                    type: "text",
                    description: "Information about the user.",
                    icon: ""
                }
            ],

        };

        let formBuilder = ''; // Form Builder.

        /**
         * Show/hide Additional fields (Form Builder).
         **/
        let AdditionalFieldsSwitcher = $( '#vmwbmdp_additional_fields' );
        function ShowAdditionalFields() {

            if ( AdditionalFieldsSwitcher.prop( 'checked' ) === true ) {

                AdditionalFieldsSwitcher.parent().parent().parent()
                                        .next().next().next().show( 300 );

                /** Initialise form builder on first show. */
                if ( '' === formBuilder ) {

                    formBuilder = $('#vmwbmdp-form-builder-editor').formBuilder( options );

                    /** Load previously saved fields. */
                    formBuilder.promise.then( function( fb ) {
                        fb.actions.setData( $( '#vmwbmdp_additional_fields_fb' ).val() );
                    } );

                }

            } else {

                AdditionalFieldsSwitcher.parent().parent().parent()
                                        .next().next().next().hide( 300 );

            }
        }
        AdditionalFieldsSwitcher.on( 'click', ShowAdditionalFields );
        ShowAdditionalFields();

        /**
         * Show/Hide Icon picker depends of the Icon Position field
         **/
        if ( document.getElementById( 'vmwbmdp_btn_icon_position' ).value === 'none') {
            $('.mdc-icon-field ').closest('.vmwbmdp-control-field').hide();
        }

        $( '#vmwbmdp_btn_icon_position' ).on( 'change', function () {
            if ( this.value === 'none' ) {
                $('.mdc-icon-field ').closest('.vmwbmdp-control-field').hide();
            } else {
                $('.mdc-icon-field ').closest('.vmwbmdp-control-field').show();
            }
        } );

        /** Save Form before update post record. */
        $( '#post' ).on( 'submit', function( e ) {

            if ( formBuilder ) {

                /** Save form in JSON format. */
                $( '#vmwbmdp_additional_fields_fb' ).val( formBuilder.actions.getData( 'json', true ) );

                /** Render and save form in HTML format. */
                let $formMarkup = jQuery( '<div/>' );
                $formMarkup.formRender( { formData: formBuilder.actions.getData( 'json', true ) } );

                /** Create Base64 Object. */
                let res_html = $formMarkup.formRender( 'html' );

                /** Encode the String. */
                let encodedRes = btoaUTF8( res_html );

                $( '#vmwbmdp_additional_fields_res' ).val( encodedRes );

            }

            /** If text fields are empty, set space. We use this to set default value if meta field empty. */
            tinyMCE.triggerSave();
            $( 'textarea.wp-editor-area' ).each( function( index ) {
                if ( '' === $( this ).val() ) {
                    $( this ).val( ' ' );
                }
            } );

        } );

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

        /**
         * We use this to detect empty icon and first time loading.
         **/
        $( '#post' ).submit( function( e ) {
            let val = $( '#vmwbmdp_btn_icon' ).val();
            if ( '' === val ) {
                $( '#vmwbmdp_btn_icon' ).val( ' ' );
            }
        } );

    } );

} ( jQuery ) );

/**
 * The most standard, most cross-browser, most compact,
 * and fastest possible btoa and atob solution for unicode strings with high code points.
 *
 * @see: https://github.com/anonyco/BestBase64EncoderDecoder
 **/
(function(window){
    "use strict";
    var log = Math.log;
    var LN2 = Math.LN2;
    var clz32 = Math.clz32 || function(x) {return 31 - log(x >>> 0) / LN2 | 0};
    var fromCharCode = String.fromCharCode;
    var originalAtob = atob;
    var originalBtoa = btoa;
    function btoaReplacer(nonAsciiChars){
        // make the UTF string into a binary UTF-8 encoded string
        var point = nonAsciiChars.charCodeAt(0);
        if (point >= 0xD800 && point <= 0xDBFF) {
            var nextcode = nonAsciiChars.charCodeAt(1);
            if (nextcode !== nextcode) // NaN because string is 1 code point long
                return fromCharCode(0xef/*11101111*/, 0xbf/*10111111*/, 0xbd/*10111101*/);
            // https://mathiasbynens.be/notes/javascript-encoding#surrogate-formulae
            if (nextcode >= 0xDC00 && nextcode <= 0xDFFF) {
                point = (point - 0xD800) * 0x400 + nextcode - 0xDC00 + 0x10000;
                if (point > 0xffff)
                    return fromCharCode(
                        (0x1e/*0b11110*/<<3) | (point>>>18),
                        (0x2/*0b10*/<<6) | ((point>>>12)&0x3f/*0b00111111*/),
                        (0x2/*0b10*/<<6) | ((point>>>6)&0x3f/*0b00111111*/),
                        (0x2/*0b10*/<<6) | (point&0x3f/*0b00111111*/)
                    );
            } else return fromCharCode(0xef, 0xbf, 0xbd);
        }
        if (point <= 0x007f) return nonAsciiChars;
        else if (point <= 0x07ff) {
            return fromCharCode((0x6<<5)|(point>>>6), (0x2<<6)|(point&0x3f));
        } else return fromCharCode(
            (0xe/*0b1110*/<<4) | (point>>>12),
            (0x2/*0b10*/<<6) | ((point>>>6)&0x3f/*0b00111111*/),
            (0x2/*0b10*/<<6) | (point&0x3f/*0b00111111*/)
        );
    }
    window["btoaUTF8"] = function(inputString, BOMit){
        return originalBtoa((BOMit ? "\xEF\xBB\xBF" : "") + inputString.replace(
            /[\x80-\uD7ff\uDC00-\uFFFF]|[\uD800-\uDBFF][\uDC00-\uDFFF]?/g, btoaReplacer
        ));
    }
    //////////////////////////////////////////////////////////////////////////////////////
    function atobReplacer(encoded){
        var codePoint = encoded.charCodeAt(0) << 24;
        var leadingOnes = clz32(~codePoint);
        var endPos = 0, stringLen = encoded.length;
        var result = "";
        if (leadingOnes < 5 && stringLen >= leadingOnes) {
            codePoint = (codePoint<<leadingOnes)>>>(24+leadingOnes);
            for (endPos = 1; endPos < leadingOnes; ++endPos)
                codePoint = (codePoint<<6) | (encoded.charCodeAt(endPos)&0x3f/*0b00111111*/);
            if (codePoint <= 0xFFFF) { // BMP code point
                result += fromCharCode(codePoint);
            } else if (codePoint <= 0x10FFFF) {
                // https://mathiasbynens.be/notes/javascript-encoding#surrogate-formulae
                codePoint -= 0x10000;
                result += fromCharCode(
                    (codePoint >> 10) + 0xD800,  // highSurrogate
                    (codePoint & 0x3ff) + 0xDC00 // lowSurrogate
                );
            } else endPos = 0; // to fill it in with INVALIDs
        }
        for (; endPos < stringLen; ++endPos) result += "\ufffd"; // replacement character
        return result;
    }
    window["atobUTF8"] = function(inputString, keepBOM){
        if (!keepBOM && inputString.substring(0,3) === "\xEF\xBB\xBF")
            inputString = inputString.substring(3); // eradicate UTF-8 BOM
        // 0xc0 => 0b11000000; 0xff => 0b11111111; 0xc0-0xff => 0b11xxxxxx
        // 0x80 => 0b10000000; 0xbf => 0b10111111; 0x80-0xbf => 0b10xxxxxx
        return originalAtob(inputString).replace(/[\xc0-\xff][\x80-\xbf]*/g, atobReplacer);
    };
})(typeof global == "" + void 0 ? typeof self == "" + void 0 ? this : self : global);