(function($){
 	
 	var qcformbuilderBackdrop = null,
 		qcformbuilderModals 	= {},
 		activeModals 	= [],
 		activeSticky	= [],
		pageHTML		= $('html'),
		pageBody		= $('body'),
 		mainWindow 		= $(window);

	var positionModals = function(){

		if( !activeModals.length && !activeSticky.length ){
			return;
		}
		var modalId	 = ( activeModals.length ? activeModals[ ( activeModals.length - 1 ) ] : activeSticky[ ( activeSticky.length - 1 ) ] ),
			windowWidth  = mainWindow.width(),
			windowHeight = mainWindow.height(),
			modalHeight  = qcformbuilderModals[ modalId ].config.height,
			modalOuterHeight  = modalHeight,
			modalWidth  = qcformbuilderModals[ modalId ].config.width,
			top 		 = 0,
			flickerBD	 = false,
			modalReduced = false;

		if( qcformbuilderBackdrop ){ pageHTML.addClass('has-qcformbuilder-modal'); }

		// top
		top = (windowHeight - qcformbuilderModals[ modalId ].config.height ) / 2.2;

		if( top < 0 ){
			top = 0;
		}
		if( modalHeight + ( qcformbuilderModals[ modalId ].config.padding * 2 ) > windowHeight && qcformbuilderBackdrop ){
			modalHeight = windowHeight - ( qcformbuilderModals[ modalId ].config.padding * 2 );
			modalOuterHeight = '100%';
			if( qcformbuilderBackdrop ){ 
				qcformbuilderBackdrop.css( {
					paddingTop: qcformbuilderModals[ modalId ].config.padding,
					paddingBottom: qcformbuilderModals[ modalId ].config.padding,
				});
			}
			modalReduced = true;
		}
		if( modalWidth + ( qcformbuilderModals[ modalId ].config.padding * 2 ) >= windowWidth ){
			modalWidth = '100%';
			if( qcformbuilderBackdrop ){ 
				qcformbuilderBackdrop.css( {
					paddingLeft: qcformbuilderModals[ modalId ].config.padding,
					paddingRight: qcformbuilderModals[ modalId ].config.padding,
				});
			}
			modalReduced = true;
		}

		if( true === modalReduced ){
			if( windowWidth <= 700 && windowWidth > 600 ){
				if( qcformbuilderBackdrop ){ modalHeight = windowHeight - ( qcformbuilderModals[ modalId ].config.padding * 2 ); }
				modalWidth = windowWidth;
				modalOuterHeight = modalHeight - ( qcformbuilderModals[ modalId ].config.padding * 2 );
				modalWidth = '100%';
				top = 0;
				if( qcformbuilderBackdrop ){ qcformbuilderBackdrop.css( { padding : qcformbuilderModals[ modalId ].config.padding } ); }
			}else if( windowWidth <= 600 ){
				if( qcformbuilderBackdrop ){ modalHeight = windowHeight; }
				modalWidth = windowWidth;
				modalOuterHeight = '100%';
				top = 0;
				if( qcformbuilderBackdrop ){ qcformbuilderBackdrop.css( { padding : 0 } ); }
			}
		}


		// set backdrop
		if( qcformbuilderBackdrop && qcformbuilderBackdrop.is(':hidden') ){
			flickerBD = true;
			qcformbuilderBackdrop.show();
		}
		// title?
		if( qcformbuilderModals[ modalId ].header ){
			if( qcformbuilderBackdrop ){ qcformbuilderBackdrop.show(); }
			modalHeight -= qcformbuilderModals[ modalId ].header.outerHeight();
			qcformbuilderModals[ modalId ].closer.css( { 
				padding		: ( qcformbuilderModals[ modalId ].header.outerHeight() / 2 ) - 0.5
			} );
			qcformbuilderModals[ modalId ].title.css({ paddingRight: qcformbuilderModals[ modalId ].closer.outerWidth() } );
		}
		// footer?
		if( qcformbuilderModals[ modalId ].footer ){
			if( qcformbuilderBackdrop ){ qcformbuilderBackdrop.show(); }
			modalHeight -= qcformbuilderModals[ modalId ].footer.outerHeight();			
		}

		if( qcformbuilderBackdrop && flickerBD === true ){
			qcformbuilderBackdrop.hide();
			flickerBD = false;
		}

		// set final height
		if( modalHeight != modalOuterHeight ){
			qcformbuilderModals[ modalId ].body.css( { 
				height		: modalHeight			
			} );
		}
		qcformbuilderModals[ modalId ].modal.css( {
			width		: modalWidth	
		} );
		
		if( qcformbuilderModals[ modalId ].config.sticky && qcformbuilderModals[ modalId ].config.minimized ){
			var toggle = {},
				minimizedPosition = qcformbuilderModals[ modalId ].title.outerHeight() - qcformbuilderModals[ modalId ].modal.outerHeight();
			if( qcformbuilderModals[ modalId ].config.sticky.indexOf( 'bottom' ) > -1 ){
				toggle['margin-bottom'] = minimizedPosition;
			}else if( qcformbuilderModals[ modalId ].config.sticky.indexOf( 'top' ) > -1 ){
				toggle['margin-top'] = minimizedPosition;
			}
			qcformbuilderModals[ modalId ].modal.css( toggle );
			if( qcformbuilderModals[ modalId ].config.sticky.length >= 3 ){
				pageBody.css( "margin-" + qcformbuilderModals[ modalId ].config.sticky[0] , qcformbuilderModals[ modalId ].title.outerHeight() );
				if( modalReduced ){
					qcformbuilderModals[ modalId ].modal.css( qcformbuilderModals[ modalId ].config.sticky[1] , 0 );
				}else{
					qcformbuilderModals[ modalId ].modal.css( qcformbuilderModals[ modalId ].config.sticky[1] , parseFloat( qcformbuilderModals[ modalId ].config.sticky[2] ) );
				}
			}
		}
		if( qcformbuilderBackdrop ){
			qcformbuilderModals[ modalId ].modal.css( {
				marginTop 	: top,
				height		: modalOuterHeight
			} );
			setTimeout( function(){
				qcformbuilderModals[ modalId ].modal.addClass( 'qcformbuilder-animate' );
			}, 10);

			qcformbuilderBackdrop.fadeIn( qcformbuilderModals[ modalId ].config.speed );
		}
		qcformbuilderModals[ modalId ].resize = positionModals;
		return qcformbuilderModals; 
	}

	var closeModal = function( obj ){	
		var modalId = $(obj).data('modal'),
			position = 0,
			toggle = {};

		if( obj && qcformbuilderModals[ modalId ].config.sticky ){

			if( qcformbuilderModals[ modalId ].config.minimized ){
				qcformbuilderModals[ modalId ].config.minimized = false
				position = 0;
			}else{
				qcformbuilderModals[ modalId ].config.minimized = true;
				position = qcformbuilderModals[ modalId ].title.outerHeight() - qcformbuilderModals[ modalId ].modal.outerHeight();
			}
			if( qcformbuilderModals[ modalId ].config.sticky.indexOf( 'bottom' ) > -1 ){
				toggle['margin-bottom'] = position;
			}else if( qcformbuilderModals[ modalId ].config.sticky.indexOf( 'top' ) > -1 ){
				toggle['margin-top'] = position;
			}
			qcformbuilderModals[ modalId ].modal.stop().animate( toggle , qcformbuilderModals[ modalId ].config.speed );
			return;
		}
		var lastModal;
		if( activeModals.length ){
			
			lastModal = activeModals.pop();
			if( qcformbuilderModals[ lastModal ].modal.hasClass( 'qcformbuilder-animate' ) && !activeModals.length ){
				qcformbuilderModals[ lastModal ].modal.removeClass( 'qcformbuilder-animate' );
				setTimeout( function(){
					qcformbuilderModals[ lastModal ].modal.remove();
					delete qcformbuilderModals[ lastModal ];
				}, 500 );
			}else{
				if( qcformbuilderBackdrop ){
					qcformbuilderModals[ lastModal ].modal.hide( 0 , function(){
						$( this ).remove();
						delete qcformbuilderModals[ lastModal ];
					});
				}
			}

		}

		if( !activeModals.length ){
			if( qcformbuilderBackdrop ){ 
				qcformbuilderBackdrop.fadeOut( 250 , function(){
					$( this ).remove();
					qcformbuilderBackdrop = null;
				});
			}
			pageHTML.removeClass('has-qcformbuilder-modal');
		}else{			
			qcformbuilderModals[ activeModals[ ( activeModals.length - 1 ) ] ].modal.show();
		}

	}
	$.qcformbuilderModal = function(opts){
		var defaults    = $.extend(true, {
			element				:	'div',
			height				:	550,
			width				:	620,
			padding				:	12,
			speed				:	250
		}, opts );
		if( !qcformbuilderBackdrop && ! defaults.sticky ){
			qcformbuilderBackdrop = $('<div>', {"class" : "qcformbuilder-backdrop"});
			if( ! defaults.focus ){
				qcformbuilderBackdrop.on('click', function( e ){
					if( e.target == this ){
						closeModal();
					}
				});
			}
			pageBody.append( qcformbuilderBackdrop );
			qcformbuilderBackdrop.hide();
		}



		// create modal element
		var modalElement = defaults.element,
			modalId = defaults.modal;

		if( activeModals.length ){

			if( activeModals[ ( activeModals.length - 1 ) ] !== modalId ){
				qcformbuilderModals[ activeModals[ ( activeModals.length - 1 ) ] ].modal.hide();
			}
		}

		if( typeof qcformbuilderModals[ modalId ] === 'undefined' ){
			if( defaults.sticky ){
				defaults.sticky = defaults.sticky.split(' ');
				if( defaults.sticky.length < 2 ){
					defaults.sticky = null;
				}
				activeSticky.push( modalId );
			}
			qcformbuilderModals[ modalId ] = {
				config	:	defaults,
				modal	:	$('<' + modalElement + '>', {
					id					: modalId + '_qcformbuilderModal',
					tabIndex			: -1,
					"ariaLabelled-by"	: modalId + '_qcformbuilderModalLable',
					"class"				: "qcformbuilder-modal-wrap" + ( defaults.sticky ? ' qcformbuilder-sticky-modal ' + defaults.sticky[0] + '-' + defaults.sticky[1] : '' )
				})
			};
			if( !defaults.sticky ){ activeModals.push( modalId ); }
		}else{
			qcformbuilderModals[ modalId ].config = defaults;
			qcformbuilderModals[ modalId ].modal.empty();
		}
		// add animate		
		if( defaults.animate && qcformbuilderBackdrop ){
			var animate 		= defaults.animate.split( ' ' ),
				animateSpeed 	= defaults.speed + 'ms',
				animateEase		= ( defaults.animateEase ? defaults.animateEase : 'ease' );

			if( animate.length === 1){
				animate[1] = 0;
			}

			qcformbuilderModals[ modalId ].modal.css( { 
				transform				: 'translate(' + animate[0] + ', ' + animate[1] + ')',
				'-web-kit-transition'	: 'transform ' + animateSpeed + ' ' + animateEase,
				'-moz-transition'		: 'transform ' + animateSpeed + ' ' + animateEase,
				transition				: 'transform ' + animateSpeed + ' ' + animateEase
			} );

		}
		qcformbuilderModals[ modalId ].body = $('<div>', {"class" : "qcformbuilder-modal-body",id: modalId + '_qcformbuilderModalBody'});
		qcformbuilderModals[ modalId ].content = $('<div>', {"class" : "qcformbuilder-modal-content",id: modalId + '_qcformbuilderModalContent'});


		// padd content		
		qcformbuilderModals[ modalId ].content.css( { 
			margin : defaults.padding
		} );
		qcformbuilderModals[ modalId ].body.append( qcformbuilderModals[ modalId ].content ).appendTo( qcformbuilderModals[ modalId ].modal );
		if( qcformbuilderBackdrop ){ qcformbuilderBackdrop.append( qcformbuilderModals[ modalId ].modal ); }else{
			qcformbuilderModals[ modalId ].modal . appendTo( $( 'body' ) );
		}


		if( defaults.footer ){
			qcformbuilderModals[ modalId ].footer = $('<div>', {"class" : "qcformbuilder-modal-footer",id: modalId + '_qcformbuilderModalFooter'});
			qcformbuilderModals[ modalId ].footer.css({ padding: defaults.padding });
			qcformbuilderModals[ modalId ].footer.appendTo( qcformbuilderModals[ modalId ].modal );
			// function?
			if( typeof window[defaults.footer] === 'function' ){
				qcformbuilderModals[ modalId ].footer.append( window[defaults.footer]( opts, this ) );
			}else if( typeof defaults.footer === 'string' ){
				// is jquery selector?
				  try {
				  	var footerElement = $( defaults.footer );
				  	qcformbuilderModals[ modalId ].footer.html( footerElement.html() );
				  } catch (err) {
				  	qcformbuilderModals[ modalId ].footer.html( defaults.footer );
				  }
			}
		}

		if( defaults.title ){
			var headerAppend = 'prependTo';
			qcformbuilderModals[ modalId ].header = $('<div>', {"class" : "qcformbuilder-modal-title", id : modalId + '_qcformbuilderModalTitle'});
			qcformbuilderModals[ modalId ].closer = $('<a>', { "href" : "#close", "class":"qcformbuilder-modal-closer", "data-dismiss":"modal", "aria-hidden":"true",id: modalId + '_qcformbuilderModalCloser'}).html('&times;');
			qcformbuilderModals[ modalId ].title = $('<h3>', {"class" : "modal-label", id : modalId + '_qcformbuilderModalLable'});
			
			qcformbuilderModals[ modalId ].title.html( defaults.title ).appendTo( qcformbuilderModals[ modalId ].header );
			qcformbuilderModals[ modalId ].title.css({ padding: defaults.padding });
			qcformbuilderModals[ modalId ].title.append( qcformbuilderModals[ modalId ].closer );
			if( qcformbuilderModals[ modalId ].config.sticky ){
				if( qcformbuilderModals[ modalId ].config.minimized && true !== qcformbuilderModals[ modalId ].config.minimized ){
					setTimeout( function(){
						qcformbuilderModals[ modalId ].title.trigger('click');
					}, parseInt( qcformbuilderModals[ modalId ].config.minimized ) );
					qcformbuilderModals[ modalId ].config.minimized = false;
				}
				qcformbuilderModals[ modalId ].closer.hide();
				qcformbuilderModals[ modalId ].title.addClass( 'qcformbuilder-modal-closer' ).data('modal', modalId).appendTo( qcformbuilderModals[ modalId ].header );
				if( qcformbuilderModals[ modalId ].config.sticky.indexOf( 'top' ) > -1 ){
					headerAppend = 'appendTo';
				}
			}else{
				qcformbuilderModals[ modalId ].closer.data('modal', modalId).appendTo( qcformbuilderModals[ modalId ].header );
			}
			qcformbuilderModals[ modalId ].header[headerAppend]( qcformbuilderModals[ modalId ].modal );
		}
		// hide modal
		qcformbuilderModals[ modalId ].modal.outerHeight( defaults.height );
		qcformbuilderModals[ modalId ].modal.outerWidth( defaults.width );

		if( defaults.content ){
			// function?
			if( typeof defaults.content === 'function' ){
				qcformbuilderModals[ modalId ].content.append( defaults.content( opts, qcformbuilderModals[ modalId ], this ) );
			}else if( typeof window[defaults.content] === 'function' ){
				qcformbuilderModals[ modalId ].content.append( window[defaults.content]( opts, qcformbuilderModals[ modalId ], this ) );
			}else if( typeof defaults.content === 'string' ){
				// is jquery selector?
				  try {
				  	var contentElement = $( defaults.content );
				  	if( contentElement.length ){
				  		qcformbuilderModals[ modalId ].content.append( contentElement.detach() );
						contentElement.show();
				  	}else{
				  		qcformbuilderModals[ modalId ].content.html( defaults.content );
				  	}
				  } catch (err) {
				  	qcformbuilderModals[ modalId ].content.html( defaults.content );
				  }
			}
		}

		// set position;
		positionModals();
		// return main object
		return qcformbuilderModals[ modalId ];
	}

	$.fn.qcformbuilderModal = function( opts ){
		if( !opts ){ opts = {}; }
		opts = $.extend( {}, this.data(), opts );
		return $.qcformbuilderModal( opts );
	}

	// setup resize positioning and keypresses
    if ( window.addEventListener ) {
        window.addEventListener( "resize", positionModals, false );
        window.addEventListener( "keypress", function(e){
        	if( e.keyCode === 27 && qcformbuilderBackdrop !== null ){
        		qcformbuilderBackdrop.trigger('click');
        	}
        }, false );

    } else if ( window.attachEvent ) {
        window.attachEvent( "onresize", positionModals );
    } else {
        window["onresize"] = positionModals;
    }



	$(document).on('click', '[data-modal]:not(.qcformbuilder-modal-closer)', function( e ){
		e.preventDefault();
		$(this).qcformbuilderModal();
	});
	$(window).load( function(){
		$('[data-modal][data-autoload]').each( function(){
			$( this ).qcformbuilderModal();
		});
	});

	$(document).on( 'click', '.qcformbuilder-modal-closer', function( e ) {
		e.preventDefault();
		closeModal( this );
	})


})(jQuery);
