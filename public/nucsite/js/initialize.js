

$(document).ready( function(){
	console.log($(document));
	console.log('hellohellohello');
	//Foundation.set_namespace = function() {};
	Foundation.global.namespace = '';
	//$(document).foundation();

	$(document).foundation({
	  offcanvas : {
	    // Sets method in which offcanvas opens.
	    // [ move | overlap_single | overlap ]
	    open_method: 'move', 
	    // Should the menu close when a menu link is clicked?
	    // [ true | false ]
	    close_on_click : false
	  }
	});

	window.clickCnt = 0;



	$( '.left-off-canvas-toggle' ).on('click', function(){

	  	 var windowWidth = document.documentElement.clientWidth;
	 	var windowHeight = document.documentElement.clientHeight;

	  	if ( window.clickCnt == 0 ) {

			$( '.inner-wrap' ).find('.exit-off-canvas').css( 'display', 'inherit' );
			$('.inner-wrap').css( {
				'position' : 'relative',
				'left' : '0',
				'top' : '0',
				'transform' : 'translate3d( 0, 0, 0 )',
				'-webkit-transform' : 'translate3d(  0, 0, 0 )',
			} );
			$( '#top-mobile-nav' ).css( {
				'width' : '15.625rem',
				//'width' : '100%',
				'height' : '0',
				'transform' : 'translate3d( -100.5%, 0, 0 )',
				'-webkit-transform' : 'translate3d( -100.5%, 0, 0 )',
				'position' : 'fixed',
				'top' : '0',
				'left' : '0',
				'right' : '0',
				'overflow-y' : 'scroll'
			} );

	  		$( '#top-mobile-nav' ).css(  'width', '0' );
	  		$( '#top-mobile-nav' ).css( {

	  			'transform' : 'translate3d( -100.5%, 0, 0 )',
	  			'-webkit-transform' : 'translate3d( -100.5%, 0, 0 )'

	  		} );
	  		$( '#top-mobile-nav' ).css( { 
	  			'transform' : 'translate3d( 0, 0, 0 )',
	  			'-webkit-transform' : 'translate3d(  0, 0, 0 )' 
	  		});
	  		// console.log( window.clickCnt );
	  		window.clickCnt++;
	  	} else {
	  		$( '#top-mobile-nav' ).css({
	  			'transform' : 'translate3d( 0, 0, 0 )',
	  			'-webkit-transform' : 'translate3d( 0, 0, 0 )' 
	  		});

	  		// console.log( window.clickCnt );
	 	}

	});

	$(document)
	.on('open.fndtn.offcanvas', '[data-offcanvas]', function() { // Open Mobile Menu
	 // $('html').css('overflow', 'hidden');
	  // var windowWidth = $(window).width();
	  // var windowHeight = $(window).height();

  	 var windowWidth = document.documentElement.clientWidth;
	 var windowHeight = document.documentElement.clientHeight;

	  $('.left-submenu').width( windowWidth );
	  $( '.inner-wrap' ).find('.exit-off-canvas').css( 'display', 'none' );
	  $('.inner-wrap').css( {
	  	'position' : 'fixed',
	  	'left' : '0',
	  	'top' : '0'
	  } );
	  $( '#top-mobile-nav' ).css(  'width', '0' );
	  $( '#top-mobile-nav' ).css( {
	  	'width' : windowWidth,
	  	'height' : windowHeight,
	  	'transform' : 'translate3d( 0, 0, 0 )',
	  	'-webkit-transform' : 'translate3d( 0, 0, 0 )',
	  	'position' : 'fixed',
	  	'top' : '0',
	  	'left' : '0',
	  	'right' : '0',
	  	'overflow-y' : 'scroll'
	  } );

	})
	.on('close.fndtn.offcanvas', '[data-offcanvas]', function() { // Close Mobile Menu
	// $('html').css('overflow', 'auto');
	 // var windowHeight = $(window).height();
	 // var windowWidth = $(window).width();

	 var windowWidth = document.documentElement.clientWidth;
	 var windowHeight = document.documentElement.clientHeight;

	})

	$('#exit-slideOver').on('click', function(){

		$( '.inner-wrap' ).find('.exit-off-canvas').css( 'display', 'inherit' );
		$('.inner-wrap').css( {
			'position' : 'relative',
			'left' : '0',
			'top' : '0',
			'transform' : 'translate3d( 0, 0, 0 )',
			'-webkit-transform' : 'translate3d(  0, 0, 0 )',
		} );
		$( '#top-mobile-nav' ).css( {
			'width' : '15.625rem',
			//'width' : '100%',
			'height' : '0',
			'transform' : 'translate3d( -100.5%, 0, 0 )',
			'-webkit-transform' : 'translate3d( -100.5%, 0, 0 )',
			'position' : 'fixed',
			'top' : '0',
			'left' : '0',
			'right' : '0',
			'overflow-y' : 'scroll'
		} );
		$( '.off-canvas-wrap' ).trigger('click');
		$( '.off-canvas-wrap' ).removeClass('move-right');
	});

});
