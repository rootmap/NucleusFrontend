// Created bY Alfonso Rivas 2013


$(function(){
	$('#Grid').mixitup({
	    targetSelector: '.mix',
	    filterSelector: '.filter',
	    buttonEvent: 'click',
	    effects: ['scale'],
	    listEffects: null,
	    easing: 'smooth',
	    // layoutMode: 'grid',
	    transitionSpeed: 400,
	    showOnLoad: 'pro',
	    multiFilter: false,
	    filterLogic: 'or',
	    failClass: 'fail',
	});
});


// <!-- VIEW PRICING  -->

jQuery(document).ready(function() {
    jQuery(".toggle").next(".hidden_toggle").hide();
    jQuery(".toggle").click(function() {
    	$('.toggle hr').siblings().fadeTo('fast',0.5);
        $('.active').not(this).toggleClass('active').next('.hidden_toggle').slideToggle(300);
        $(this).toggleClass('active').next().slideToggle("fast");

    });
});



// <!-- SLIDER POS HARDWARE BIG PRODUCTS -->

	$(function() {

		$( '#mi-slider' ).catslider();

	});


// <!-- PRODUCT DISPLAY BY DEFAULT ARE HIDDING -->

	$('#open_products').toggle(
	 function(){
	     // $('.open_now').delay(800).show("slide", { direction: "up" }, 1500);
	     $('.hardware_products.first').hide("slide", { direction: "up" }, 900);
	     $('.open_now').delay(800).fadeIn( "slow" );
	     $('.demo-download-strip').delay(2000).fadeIn( "fast" );
		// setTimeout(function(){
		//        $('.hardware_products').addClass( "absolute" );
		//    }, 500);

	}
	,
	function(){
	    $('.open_now').hide("slide", { direction: "up" }, 1000);
	}
	);
