$( document ).ready( function() {
	//console.log("GOGO SHARED MENU");
//// This is no longer being used.
	// Subnav element
	// var subnav = $('#sharedmenu--subnav--');
	// if ( subnav.length ) {
	// 	// Shared Menu Sticky
	// 	var stickyOffset = $(subnav).offset().top;
	// 	// console.log( stickyOffset );
	// 	var timerCnt = 0;
	// 	for ( var i=0; i<5; ++i  ){
	// 		$.wait( i+'000').then( function(){ 
	// 			stickyOffset = $('#sharedmenu--subnav--').offset().top;
	// 		});
	// 	}
	// 	$(window).scroll(function(){
	// 		var sticky = $( '#sharedmenu--subnav--' ), scroll = $( window ).scrollTop();
	// 		if ( scroll >= stickyOffset ) sticky.addClass('fixy');
	// 		else sticky.removeClass('fixy');
	// 	});
	// }
	var socialMediaHook = $('#socialMedia-prompt');
	if ( socialMediaHook.length ) {
		//console.log( 'EXISTS' );
		$( socialMediaHook ).find( '.fb-popup, .tw-popup' ).on( 'click', function (e){
			if ( $( this ).find( '.sharedfooter-popup' ).hasClass( 'open' ) ) {
				//console.log( 'open' );
				$( this ).find( '.sharedfooter-popup' ).removeClass('open');
			} else {
				$( this ).find( '.sharedfooter-popup' ).addClass('open');
				if ( $(this).hasClass('fb-popup') && !$('.tw-popup').hasClass('open') ) {
					$( socialMediaHook ).find( '.sharedfooter-twitter' ).removeClass( 'open' );
				} else if ( $(this).hasClass('tw-popup') && !$('.fb-popup').hasClass('open') ) {
					$( socialMediaHook ).find( '.sharedfooter-facebook' ).removeClass( 'open' );
				}
			}
		});
	}
}); // End Doc Ready

$.wait = function(ms) {
    var defer = $.Deferred();
    setTimeout(function() { defer.resolve(); }, ms);
    return defer;
};