/* GEOIP API - change URLs and some text depending on the Visitor's geo location: */


var geoConfig = $.cookie('geoConfig');

if(geoConfig !== undefined) {
	// We already have a cookie with the Geo settings
	geoPageSetup(JSON.parse(geoConfig));
		
} else {
	// We need to go look-up geo information
	$.getScript("//js.maxmind.com/js/apis/geoip2/v2.0/geoip2.js", function() {
	geoLookup();
	});
}


function geoPageSetup(geoConfig) {

	console.log( "Country: " + geoConfig['country'] );
	// Set default URLs
	var theRetailButtonURL = "/retail/";
	var theTrialButtonURL = "/retail/signup";
	var phoneNumber = "866-932-1801"; // America

	// Check if we are in the Onsite Help section
	if ( window.location.href.indexOf("/help/") > -1 )
		{
			thesection = "onsite";
		}

	// Check to see if thesection is undefined
	if (typeof thesection === 'undefined')
	{
		thesection = "";
	}
	// Set up the Links for DEMO and Webinar depending on geo location
	if(geoConfig['northamerica'] == false || thesection === "onsite") 
		{
			// Do International here
			console.log( 'i in here' );
			var theRetailButtonURL = "/onsite/";
			var theTrialButtonURL = "/onsite/demo/";
			$("#top-mobile-nav").find(".has-submenu.retail").hide();
		}
	else {
		$("#top-mobile-nav").find(".has-submenu.onsite").hide();
	}
	// Change the Links for the Trial (Demo) buttons
	$(".geo-link").attr("href", theTrialButtonURL);
	// Change the links for the Retail links
	$(".retail-geo-link").attr("href", theRetailButtonURL);

	//Populate the form country field if form exists
	if($('#theForm').length > 0)
	{
		document.getElementById("country").value = geoConfig['country'];
		document.getElementById("country-code").value = geoConfig['country_code'];
	}


}

var geoLookup = (function () {

    var setupGeoCookie = function (geoipResponse) {
		var geoConfig = { 
			"country": geoipResponse.country.names.en,
			"country_code": geoipResponse.country.iso_code,
			"northamerica": true
		}
			
		if (geoipResponse.country.iso_code != "US" && geoipResponse.country.iso_code != 'CA') {
			geoConfig['northamerica'] = false;
		}
		
		if(geoipResponse.city !== undefined) {
			geoConfig['city'] = geoipResponse.city.names.en;
		}
		
		$.cookie('geoConfig', JSON.stringify(geoConfig), { path:'/' });
		
		geoPageSetup(geoConfig);
    };

    var onSuccess = function (geoipResponse) {	
        setupGeoCookie(geoipResponse);
    };

    /* If we get an error we will */
    var onError = function (error) {
        return;
    };

    return function () {
        geoip2.country(onSuccess, onError, { w3cGeolocationDisabled: true })
    };
}());