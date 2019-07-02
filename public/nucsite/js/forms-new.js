console.log("############################");

theFormPage = window.location.href;

// Don't wait for the document ready - start getting webinars if there is the Webinar Select menu:
if($('#timeline-wrapper').length > 0) {
$('#timeline-wrapper').load("/wp-content/themes/Nucleus/includes/load-webinars.php");
}

$(document).ready(function(event) {
	if($('#theForm').length > 0) {
		lead.submission.setLeadSourceModifyForm();
		lead.submission.checkForCookies();
		lead.submission.checkForReferrer();
	}

	$( "#theForm" ).submit(function(event) {
  		lead.submission.validateForm(event);
 		if (event.preventDefault) {event.preventDefault();}
 		else {event.returnValue = false;}
	});

	if(  theFormPage.indexOf("/request-a-quote" ) > 0 || theFormPage.indexOf("/request-a-demo" ) > 0 ) {
		lead.submission.setupBusinessTypeSelect();
	}
});





$(document).ready(function(event) {
	if($('#promoForm').length > 0) {
	theForm = document.getElementById("promoForm");
	lead.submission.checkForCookies();
		$( "#promoForm" ).submit(function(event) {
  		promo.submission.validatePromoForm(event);
	});
	}
});






lead = {};

lead.submission = {

	checkForReferrer: function() {

		var theCookies = document.cookie;
		if ( theCookies.indexOf("referralPartner=" ) > -1) {
			var theCookie1 = theCookies.split("referralPartner=")[1];
			var theReferrer = theCookie1.split(";")[0];
			document.getElementById("referral_partner").value = decodeURI(theReferrer);
			//elem.value = decodeURI(theReferrer);

		}
		else {
			var theReferrer = "N/A";
		}

	},

	checkForCookies: function() {


		// Check to see if there is a cookie with Form Values:
		if (document.cookie.indexOf('NucleusFormData') > -1)
			{
				theCookie = JSON.parse($.cookie('NucleusFormData'));
				theForm.first_name.value = theCookie["firstName"];
				theForm.last_name.value = theCookie["lastName"];
				theForm.email.value = theCookie["email"];
				theForm.phone.value = theCookie["phone"];
				// If there is a Store/Company field and Cookie value:
				if (theCookie["store"] && $('#store').length > 0)
				{
					theForm.store.value = theCookie["store"];
				}
				if (theCookie["numberOfStores"] && $('#number_stores').length > 0)
				{
					theForm.number_stores.value = theCookie["numberOfStores"];
				}
				// If there is a Timeline field and Cookie value:
				if (theCookie["timeline"] && $('#timeline').length > 0)
				{
					theForm.timeline.value = theCookie["timeline"];
				}
				// If there is a Business Type field and Cookie value:
				if (theCookie["business"] && $('#business_type').length > 0)
				{
					$("#business_type option[value='" + theCookie["business"] +"']").prop('selected', true);
				}
			}

		else {
			console.log("No Cookie");
			}

		// Check for referralPartner cookie:
		if (document.cookie.indexOf('referralPartner') > -1)
		{
			referralPartnerCookie = document.cookie.split('referralPartner=')[1]
			theForm.referral_partner.value = referralPartnerCookie.split(';')[0];

		}
	},
	setCookie: function(event) {

		cookie_name = "NucleusForms";
		var formCookieConfig = {
			"leadSource": theForm.lead_source.value,
			"productSegment": theForm.product_segment.value,
			"firstName": theForm.first_name.value,
			"lastName": theForm.last_name.value,
			"email": theForm.email.value,
			"phone": theForm.phone.value,
		}
		// Not all forms have these fields - set or reset values depending on a few things:
		// If store/company name input is present:
		if ( $('#store').length > 0 )
			{
				formCookieConfig["store"] = theForm.store.value;
			}
		// If # of stores input is present:
		if ( $('#number_stores').length > 0 )
			{
				formCookieConfig["numberOfStores"] = theForm.number_stores.value;
			}
		// Or there is # of stores in the Cookie:
		else if ( document.cookie.indexOf('NucleusFormData') > -1 && theCookie["numberOfStores"] )
			{
				formCookieConfig["numberOfStores"] = theCookie["numberOfStores"];
			}

		// If Timeline input is present:
		if ( $('#timeline').length > 0 )
			{
				formCookieConfig["timeline"] = theForm.timeline.value;
			}
		// Or there is Timeline in the Cookie:
		else if ( document.cookie.indexOf('NucleusFormData') > -1 && theCookie["timeline"] )
			{
				formCookieConfig["timeline"] = theCookie["timeline"];
			}
		// If Business input is present:
		if ( $('#business_type').length > 0 )
			{
				formCookieConfig["business"] = theForm.business_type.value;
			}
		// Or there is Business Type in the Cookie:
		else if ( document.cookie.indexOf('NucleusFormData') > -1 && theCookie["business"] )
			{
				formCookieConfig["business"] = theCookie["business"];
			}



		$.cookie('NucleusFormData', JSON.stringify(formCookieConfig), { expires : 365 , path: "/"});


        if (event.preventDefault) {event.preventDefault();}
 		else {event.returnValue = false;}
	},

	setLeadSourceModifyForm: function() {

		

		// Pro Demo Download
		if ( theFormPage.indexOf("/demo") > -1 || theFormPage.indexOf("/Nucleus-pro/resellers") > -1)
		{
			thankYouPageURL = "/demo-thanks";
			theForm.lead_source.value = "Demo";
			theForm.product_segment.value = "Pro";
			marketoFormID = "1039";
			document.getElementById("formsubmitbutton").innerHTML = "Download Your Free Trial";

		}
		// Request a Demo
		else if ( theFormPage.indexOf("/request-a-demo") > -1)
		{
			thankYouPageURL = "/thank-you-request-a-demo";
			theForm.lead_source.value = "Request a Demo";
			marketoFormID = "1038";
			document.getElementById("formsubmitbutton").innerHTML = "Request a Demo";
		}
		// Request a Quote
		else if ( theFormPage.indexOf("/request-a-quote") > -1)
		{
			thankYouPageURL = "/thank-you-request-a-quote";
			theForm.lead_source.value = "Request a Quote";
			marketoFormID = "1037";
			document.getElementById("formsubmitbutton").innerHTML = "Request a Quote";
		}
		//Webinars - General
		else if ( theFormPage.indexOf("/signup-webinar") > -1)
		{

			theForm.lead_source.value = "webinar";
			document.getElementById("formsubmitbutton").innerHTML = "Register Now";
			skipGotoWebinar = false;

			// Webinars - Cloud
			if ( theFormPage.indexOf("/signup-webinar-cloud/") > -1)
			{
				thankYouPageURL = "thank-you-webinar-cloud";
				marketoFormID = "1088";
				theForm.product_segment.value = "Cloud";
			}
			// Webinars - Pro
			else if ( theFormPage.indexOf("/signup-webinar-pro") > -1)
			{
				thankYouPageURL = "thank-you-webinar-pro";
				marketoFormID = "1089";
				theForm.product_segment.value = "Pro";
			}
			// Webinars - Web Store
			else if ( theFormPage.indexOf("/signup-webinar-web-store") > -1)
			{
				thankYouPageURL = "thank-you-webinar-web-store";
				marketoFormID = "1091";
				this.setProductSegmentForRetail();
			}
			// Webinars - Brick and Mortar
			else if ( theFormPage.indexOf("/signup-webinar-brick-mortar") > -1)
			{
				thankYouPageURL = "thank-you-webinar-brick-mortar";
				marketoFormID = "1040";
				addDescriptionField = "Making Money with Mobile Retail";
				skipGotoWebinar = true;
				document.getElementById("formsubmitbutton").innerHTML = "Watch Now";
				this.setProductSegmentForRetail();
			}
			// Webinars - Making Money Mobile Retail
			else if ( theFormPage.indexOf("/signup-webinar-making-money-mobile-retail") > -1)
			{
				thankYouPageURL = "/thank-you-webinar-making-money-in-mobile-retail";
				marketoFormID = "1053";
				addDescriptionField = "Making Money with Mobile Retail";
				skipGotoWebinar = true;
				document.getElementById("formsubmitbutton").innerHTML = "Watch Now";
				this.setProductSegmentForRetail();
			}

			// Webinars - Finding Your Tribe **********
			else if ( theFormPage.indexOf("/signup-webinar-finding-your-tribe") > -1)
			{
				thankYouPageURL = "/thank-you-webinar-finding-your-tribe";
				marketoFormID = "1104";
				addDescriptionField = "Creating Your Retail Identity";
				skipGotoWebinar = true;
				document.getElementById("formsubmitbutton").innerHTML = "Watch Now";
				this.setProductSegmentForRetail();

			}
			// Webinars - What Cloud Means to Brick & Mortar **********
			else if ( theFormPage.indexOf("/signup-webinar-what-cloud-means-to-brick-mortar") > -1)
			{
				thankYouPageURL = "/thank-you-webinar-what-cloud-means-to-brick-mortar";
				marketoFormID = "1112";
				addDescriptionField = "What Cloud Mean to Brick and Mortar";
				skipGotoWebinar = true;
				document.getElementById("formsubmitbutton").innerHTML = "Watch Now";
				this.setProductSegmentForRetail();
			}
			// Webinars - Turning Browsers Into Buyers Online **********
			else if ( theFormPage.indexOf("/signup-webinar-converting-browsers-into-buyers") > -1)
			{
				thankYouPageURL = "/thank-you-webinar-converting-browsers-into-buyers";
				marketoFormID = "1139";
				addDescriptionField = "7 tips for selling more with a better online checkout";
				skipGotoWebinar = true;
				document.getElementById("formsubmitbutton").innerHTML = "Watch Now";
				this.setProductSegmentForRetail();
			}
			// Webinars - Restaurant
			else if ( theFormPage.indexOf("/signup-webinar-restaurant") > -1)
			{
				thankYouPageURL = "/thank-you-webinar-restaurant";
				marketoFormID = "1120";
				document.getElementById("formsubmitbutton").innerHTML = "Register Now";
				if ( theFormPage.indexOf("/nl/signup-webinar-restaurant") > -1)
				{
					document.getElementById("formsubmitbutton").innerHTML = "Registreer Nu";
				}
				if ( theFormPage.indexOf("/fr/signup-webinar-restaurant") > -1)
				{
					document.getElementById("formsubmitbutton").innerHTML = "S'inscrire maintenant";
				}
			}


			// Webinars - Make sure there is a thank you page:
			else
			{
				thankYouPageURL = "thank-you-webinar-cloud";
			}

		}
		// Whitepapers
		else if ( theFormPage.indexOf("white-papers/pos-buyers-guide") > -1)
		{
			theForm.lead_source.value = "White Paper";
			document.getElementById("formsubmitbutton").innerHTML = "Download Now";
			thankYouPageURL = "../thank-you-pos-buyers-guide";
			marketoFormID = "1041";
			addDescriptionField = "POS Buyer's Guide";
			this.setProductSegmentForRetail();

		}
		else if ( theFormPage.indexOf("white-papers/tech-forecast-2014") > -1)
		{
			theForm.lead_source.value = "White Paper";
			document.getElementById("formsubmitbutton").innerHTML = "Download Now";
			thankYouPageURL = "../thank-you-technology-forecast";
			marketoFormID = "1050";
			addDescriptionField = "Technology Forecast";
			this.setProductSegmentForRetail();
		}

		else if ( theFormPage.indexOf("white-papers/inventory-guide") > -1)
		{
			theForm.lead_source.value = "White Paper";
			document.getElementById("formsubmitbutton").innerHTML = "Download Now";
			thankYouPageURL = "../thank-you-inventory";
			marketoFormID = "1055";
			addDescriptionField = "Inventory Guide";
			this.setProductSegmentForRetail();
		}
		else if ( theFormPage.indexOf("white-papers/independent-retailers-guide-to-buying-inventory") > -1)
		{
			theForm.lead_source.value = "White Paper";
			document.getElementById("formsubmitbutton").innerHTML = "Download Now";
			thankYouPageURL = "../thank-you-independent-retailers-guide";
			marketoFormID = "1135";
			addDescriptionField = "Independent Retailer's Guide to Buying Inventory";	
			this.setProductSegmentForRetail();		
		}
		// Maintenance Plan Renewal (Pro)
		else if ( theFormPage.indexOf("maintenance-plan") > -1)
		{
			theForm.lead_source.value = "Maintenance Renewal Form";
			thankYouPageURL = "/thank-you-pro-maintenance-plan";
			marketoFormID = "1092";
		}

		// Payments Contact
		else if ( theFormPage.indexOf("payments") > -1)
		{

			theForm.lead_source.value = "Contact form";
			thankYouPageURL = "/thank-you-payments";
			marketoFormID = "1096";
			this.setProductSegmentForRetail();

		}

		// Restaurant Start for Free / Demo
		else if ( theFormPage.indexOf("start-for-free") > -1)
		{

			theForm.lead_source.value = "Restaurant Trial Request";
			thankYouPageURL = "/restaurant/thank-you-start-for-free";
			marketoFormID = "1137";
		}

		// Ambassador Program
		else if ( theFormPage.indexOf("ambassador-program") > -1)
		{
			thankYouPageURL = "/thank-you-ambassador-program";
			marketoFormID = "1136";
			document.getElementById("formsubmitbutton").innerHTML = "Register Now";
		}


		else
		{
			console.log("Form not specified");
			theForm.lead_source.value = "Demo";
		}

	},

	validateForm: function(event) {
		if ( theFormPage.indexOf("/signup-webinar") > -1)
		{
			required = ["first_name", "last_name", "store", "email", "phone", "business_type", "select-webinar"];
		}
		else if ( theFormPage.indexOf("/request-a-quote") > -1)
		{
			required = ["first_name", "last_name", "store", "email", "phone", "product_segment", "business_type"];
		}
		else if ( theFormPage.indexOf("/ambassador-program") > -1)
		{
			required = ["first_name", "last_name", "store", "email", "phone", "business_type", "ambassadorreferencesallowed"];
		}
		else
		{
			required = ["first_name", "last_name", "store", "email", "phone", "business_type"];
		}

		email = $("#email");
		for (i=0;i<required.length;i++) {
	        var input = $('#'+required[i]);
	        if ((input.val() == ""))
	        	{
				$(input).next().fadeIn();
				$("#form-left").fadeTo('slow',0.3);
				input.addClass("required");
				}
			else
				{
				input.removeClass("required");
				$(input).next().css('display', 'none');
				}
		}
		// Validate the e-mail.
		if (!/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email.val()))
			{
			email.addClass("required");
			$(".error-email").fadeIn();
			return false;
			}
		else {
			email.removeClass("required");
		}
		if ($(":input").hasClass("required"))
			{
			//event.preventDefault();
			//Use this for IE bug:
 			if (event.preventDefault) {event.preventDefault();}
 			else {event.returnValue = false;}
			}
		else
		{
			console.log("Validated");
			this.prepForSubmission(event);
			$('#formsubmitbutton').attr('disabled','disabled').css('opacity','0.5').html('Sending...');
			this.setCookie(event);
		}
	},



	setupBusinessTypeSelect: function(event) {
		// Set the Product Segment:
		if ( $.cookie('LSProductSegment' ) == "Retail" )
		{
			// Auto-select the product segment (leave hidden):
			$("#product_segment").val("Cloud");
		}
		else if ( $.cookie('LSProductSegment' ) == "OnSite" )
		{
			$("#product_segment").append('<option value="Pro">OnSite</option>');
			$("#product_segment").val("Pro");

		}

		//Populate Business type for Request a Quote and Request a Demo
		if ( $.cookie('LSProductSegment' ) == "Retail" || $.cookie('LSProductSegment') == "OnSite")
		{
			console.log("Bulding the form select options for RETAIL");
			// Show the appropriate business types:
			$(".retail-options").show();
			$(".restaurant-options").remove();
			
		}
		else if ( $.cookie('LSProductSegment' ) == "Restaurant")
		{	
			console.log("Bulding the form select options for RESTO");
			$("#product_segment").val("POSIOS");
			$(".restaurant-options").show();
			$(".retail-options").remove();
		}
		else 
		{
			console.log("Bulding the form select options for GENERIC");
			$(".retail-options").show();
			$(".restaurant-options").show();
			$("#product_segment_selector").show();
			
		}
	},

	setProductSegmentForRetail: function(event) {
		// For forms that are either Retail or OnSite, set the Product Segment if LSProductSegment is set:
		if ( $.cookie('LSProductSegment') == "OnSite" )
		{
			$("#product_segment").append('<option value="Pro">OnSite</option>');
			theForm.product_segment.value = "Pro";
		}
		else if ( $.cookie('LSProductSegment') == "Retail" )
		{
			theForm.product_segment.value = "Cloud";
		}
		else {
			theForm.product_segment.value = "Cloud";
		}
	},

	prepForSubmission: function(event) {
		
			// Add the formID to the form for Marketo:
			if ( typeof marketoFormID != "undefined" )
			{
				console.log("marketoFormID Defined: " + marketoFormID);
				$("<input>").attr({ type: "hidden", id: "formid", name: "formid", value: marketoFormID }).appendTo("#theForm");
			}
			else {
				console.log("marketoFormID undefined");
			}
			// Add the Description if exists in form:
			if ( typeof addDescriptionField != "undefined" )
			{
				console.log("addDescriptionField Defined: " + addDescriptionField);
				$("<input>").attr({ type: "hidden", id: "description", name: "description", value: addDescriptionField }).appendTo("#theForm");
			}
			else {
				console.log("addDescriptionField undefined");
			}

			// Sent to Marketo for submission:
			// First check if Automotive is selected if OnSite Demo:
			if (theForm.lead_source.value == "Demo" && theForm.business_type.value == "Automotive, Powersports, Marine, or RV" )
				{
					thankYouPageURL = "/adp";
					theForm.lead_source.value = "ADP";
					this.submitToMarketo(event);
				}
			// If no Automotive submit OnSite Demo or other forms to Marketo:
			else {
				console.log("formID is: " + theForm.formid.value );
				this.submitToMarketo(event);
				//alert("Boom. Submit to Marketo! " + $("#theForm").serialize());
			}
	},

	submitToSalesforce: function(event) {
		if ( theFormPage.indexOf("/Nucleus-pro/resellers") > -1 )
		{
			var url = "/wp-content/themes/Nucleus/includes/salesforce-resellers.php";
		}
		else
		{
			var url = "/wp-content/themes/Nucleus/includes/salesforce.php";
		}

			$.ajax({
				type: "POST",
				url: url,
				dataType: "json",
				data: $("#theForm").serialize(),
					success: function(data)
					    {

					        if ( thankYouPageURL == "/demo-thanks")
					        {
					        	window.location.href = "/demo-thanks/";
					        }
					        else if ( theForm.lead_source.value == "webinar" && theFormPage.indexOf("/signup-webinar-brick-mortar") <= -1)
					        {
					        	// use gotomeeting.php to submit webinar:
					        	console.log("Moving on to to GotoMeeting from SF....");
				   				lead.submission.submitToWebinar(event);

					        }
					        else
					        {
					        	window.location.href = thankYouPageURL;
					        }

						},


					error: function(data)
					    {
					     	alert("There may have been an error with your submission.");
					     	window.location.href = thankYouPageURL;
					    }
				});

		if (event.preventDefault) {event.preventDefault();}
 		else {event.returnValue = false;}

	},

	submitToMarketo: function(event) {

		var url = "/wp-content/themes/Nucleus/includes/marketo.php";
		if ( window.location.href.indexOf("?stagingtest") > -1)
		{
			var url = "/wp-content/themes/Nucleus/includes/marketo-staging.php";
			marketoFormID = "1007";
			$("#formid").val(marketoFormID).change();
			console.log("Submitting to: " + url + "FormID: " + $("#formid").val());
		}
		
			$.ajax({
				type: "POST",
				url: url,
				dataType: "json",
				data: $("#theForm").serialize(),
					success: function(data)
					    {
					    	// Send tracker to Optimizely:
					    	// Tracker for OnSite Demo Form
							if ( marketoFormID == "1039")
							{
								window['optimizely'] = window['optimizely'] || [];
								window.optimizely.push(["trackEvent", "successfulTrial"]);
							}
							// Tracker for all other Forms
							else {
								window['optimizely'] = window['optimizely'] || [];
								window.optimizely.push(["trackEvent", "successfulOtherConversion"]);
							}

					        if ( thankYouPageURL == "/demo-thanks")
					        {
					        	window.location.href = "/onsite/demo-thanks/";
					        }

					        else if ( theForm.lead_source.value == "webinar" && skipGotoWebinar != true )
					        {
					        	// use gotomeeting.php to submit webinar:
				   				lead.submission.submitToWebinar(event);
					        }
					        else if (theForm.lead_source.value == "Maintenance Renewal Form")
					        {

					        	_gaq.push(['_trackEvent', 'Forms', 'Submitted','Maintenance Renewal Form']);
					        	$("#theForm").fadeOut();
					        	$("#maintenance-form-thanks").fadeIn();
					        }
					        else
					        {
					        	window.location.href = thankYouPageURL;
					        }

						},


					error: function(data)
					    {
					     	alert("There may have been an error with your submission.");
					     	window.location.href = thankYouPageURL;
					    }
				});

		if (event.preventDefault) {event.preventDefault();}
 		else {event.returnValue = false;}

	},

	submitToWebinar: function(event) {


		console.log("submitting to GotoMeeting");
		var url = "/wp-content/themes/Nucleus/includes/gotomeeting.php";
			$.ajax({
				type: "POST",
				url: url,
				dataType: "json",
				data: $("#theForm").serialize(),
					success: function(data)
					    {
					        window.location.href = thankYouPageURL;
						},

					error: function(data)
					    {
					     	//alert("There was an error with your submission.");
					     	alert("Thank you. You will receive an email with your webinar information.");
					    }
				});

		if (event.preventDefault) {event.preventDefault();}
 		else {event.returnValue = false;}

	}

}




// This is currently used for the CQCD form:

promo = {};

promo.submission = {


	validatePromoForm: function(event) {
		//event.preventDefault;


		if (event.preventDefault) {event.preventDefault();}
 		else {event.returnValue = false;}

 		required = ["first_name", "last_name", "email", "phone"];

		for (i=0;i<required.length;i++) {
	        var input = $('#'+required[i]);
	        if ((input.val() == ""))
	        	{
				input.addClass("required");
				$(input).next().fadeIn();

				}
			else
				{
				input.removeClass("required");
				$(input).next().fadeOut();
				}
		}


		// Validate the e-mail.
		email = $("#email");
		if (!/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email.val()))
			{
			email.addClass("required");
			$("#error-email").fadeIn();
			return false;
			}
		else {
			email.removeClass("required");
			$("#error-email").fadeOut();
		}




		if ($(":input").hasClass("required"))
			{
			//event.preventDefault();
			//Use this for IE bug:
 			if (event.preventDefault) {event.preventDefault();}
 			else {event.returnValue = false;}
 			console.log("not valid");
			}
		else
		{
			lead.submission.setCookie(event);
			promo.submission.submitToMarketoPromo(event);
			$('#promo-submit').attr('disabled','disabled').css('opacity','0.5').html('Sending...');

		}


},
	submitToMarketoPromo: function(event) {
			var url = "/wp-content/themes/Nucleus/includes/marketo.php";
				$.ajax({
					type: "POST",
					url: url,
					dataType: "json",
					data: $("#promoForm").serialize(),
						success: function(data)
						    {

						        _gaq.push(['_trackEvent', 'Forms', 'Submitted','CQCD Promo']);
						        $("#success").fadeIn();
						        $("#promoForm").fadeOut();

							},


						error: function(data)
						    {
						     	$("#error").fadeIn();

						    }
					});

			if (event.preventDefault) {event.preventDefault();}
	 		else {event.returnValue = false;}

		}


}
