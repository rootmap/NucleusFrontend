$(document).ready(function() {

	//===== Check all checbboxes =====//
	
	function printDiv(divID,amount,total_collection_cash_credit_card,cash_collected_plus,credit_card_collected_plus,opening_cash_plus,opening_credit_card_plus,payout_plus_min,buyback_min,tax_min,current_cash,current_credit_card)
	{
            var divElements = document.getElementById(divID).innerHTML;
            var oldPage = document.body.innerHTML;
            document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";
			window.open("pos.php?storecloseingmm="+amount+"&total_collection_cash_credit_card="+total_collection_cash_credit_card+"&cash_collected_plus="+cash_collected_plus+"&credit_card_collected_plus="+credit_card_collected_plus+"&opening_cash_plus="+opening_cash_plus+"&opening_credit_card_plus="+opening_credit_card_plus+"&payout_plus_min="+payout_plus_min+"&buyback_min="+buyback_min+"&tax_min="+tax_min+"&current_cash="+current_cash+"&current_credit_card="+current_credit_card);
            window.print();
        }
	
	$("#select-all thead tr th:first-child input:checkbox").click(function() {
		var checkedStatus = this.checked;
		$("#select-all tbody tr td:first-child input:checkbox").each(function() {
			this.checked = checkedStatus;
				if (checkedStatus == this.checked) {
					$(this).closest(".checker > span").removeClass("checked");
					$(this).closest("table tbody tr").removeClass("row-checked");
				}
				if (this.checked) {
					$(this).closest(".checker > span").addClass("checked");
					$(this).closest("table tbody tr").addClass("row-checked");
				}
		});
	});	
	
    $("#select-all tbody tr td:first-child input[type=checkbox]").change(function() {
        $(this).closest("tr").toggleClass("row-checked", this.checked);
	});


	//===== File uploader =====//
	
	



	//===== Fancybox =====//
	
	



	//===== Wizards =====//
	
	



	//===== File manager =====//	
	
		
	

		
	
	
	//===== WYSIWYG editor =====//
	
	


	 //===== Tabbed page layout tabs =====//

	$(".page-tabs a").click(function (e) {
	  e.preventDefault();
	  $(this).tab("show");
	  $("#editor").cleditor()[0].refresh(); // Refreshing Cleditor 
	})
	

	
	//===== Make code pretty =====//

    window.prettyPrint && prettyPrint();



    //===== Table checkboxes =====//

    $(".table-checks tbody tr td:first-child input[type=checkbox]").change(function() {
        $(this).closest("tr").toggleClass("row-checked", this.checked);
	});

	
	
	//===== Pie charts =====//

	
	

	
	//===== Datatable =====//

	
	


	//===== Autocomplete =====//
	
	
	

	//===== Date pickers =====//

	$( ".datepicker" ).datepicker({
				defaultDate: +7,
		showOtherMonths:true,
		autoSize: true,
		appendText: "(yyyy-mm-dd)",
		dateFormat: "yy-mm-dd",
		});
		
	$(".inlinepicker").datepicker({
        inline: true,
		showOtherMonths:true
    });

	var dates = $( "#fromDate, #toDate" ).datepicker({
		defaultDate: "+1w",
		changeMonth: false,
		showOtherMonths:true,
		numberOfMonths: 3,
		onSelect: function( selectedDate ) {
			var option = this.id == "fromDate" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	$( "#datepicker-icon" ).datepicker({
		showOn: "button",
		buttonImage: "images/icons/calendar.png",
		buttonImageOnly: true
	});

	

	//===== jQuery UI sliders =====//

	$( "#slider" ).slider();
	$( "#slider-range" ).slider({
            range: true,
            min: 0,
            max: 500,
            values: [ 75, 300 ],
            slide: function( event, ui ) {
                $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
            }
        });
        $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
            " - $" + $( "#slider-range" ).slider( "values", 1 ) );
			
	$( "#slider-range-min" ).slider({
            range: "min",
            value: 37,
            min: 1,
            max: 700,
            slide: function( event, ui ) {
                $( "#amount2" ).val( "$" + ui.value );
            }
        });
        $( "#amount2" ).val( "$" + $( "#slider-range-min" ).slider( "value" ) );
	
	$( "#slider-range-max" ).slider({
            range: "max",
            min: 1,
            max: 10,
            value: 2,
            slide: function( event, ui ) {
                $( "#amount3" ).val( ui.value );
            }
        });
        $( "#amount3" ).val( $( "#slider-range-max" ).slider( "value" ) );
		
	$( "#eq > span" ).each(function() {
		var value = parseInt( $( this ).text(), 10 );
		$( this ).empty().slider({
			value: value,
			range: "min",
			animate: true,
			orientation: "vertical"
		});
	});
		
		
		
	//===== Modals and dialogs =====//

	$("a.bs-alert").click(function(e) {
		e.preventDefault();
		bootbox.alert("Hello world!", function() {
			console.log("Alert Callback");
		});
	});
	
	$("a.confirm").click(function(e) {
		e.preventDefault();
		bootbox.confirm("Are you sure?", function(confirmed) {
			console.log("Confirmed: "+confirmed);
		});
	});
	
	$("a.bs-prompt").click(function(e) {
		e.preventDefault();
		bootbox.prompt("What is your name?", function(result) {
			console.log("Result: "+result);
		});
	});
	
	$("a.dialog").click(function(e) {
		e.preventDefault();
		bootbox.dialog("I am a custom dialog", [{
			"label" : "Success!",
			"class" : "btn-success",
			"callback": function() {
				console.log("great success");
			}
		}, {
			"label" : "Danger!",
			"class" : "btn-danger",
			"callback": function() {
				console.log("uh oh, look out!");
			}
		}, {
			"label" : "Click ME!",
			"class" : "btn-primary",
			"callback": function() {
				console.log("Primary button");
			}
		}, {
			"label" : "Just a button..."
		}, {
			"Condensed format": function() {
				console.log("condensed");
			}
		}]);
	});
	
	$("a.multiple-dialogs").click(function(e) {
		e.preventDefault();

		bootbox.alert("Prepare for multiboxes...", "Argh!");

		setTimeout(function() {
			bootbox.confirm("Are you having fun?", "No :(", "Yeah!", function(result) {
				if (result) {
					bootbox.alert("Glad to hear it!");
				} else {
					bootbox.alert("Aww boo. Click the button below to get rid of all these popups", function() {
						bootbox.hideAll();
					});
				}
			});
		}, 1000);
	});
	
	$("a.dialog-close").click(function(e) {
		e.preventDefault();
		var box = bootbox.alert("This dialog will close in two seconds");
		setTimeout(function() {
			box.modal("hide");
		}, 2000);
	});
	
	$("a.generic-modal").click(function(e) {
		e.preventDefault();
		bootbox.modal('<img src="http://dummyimage.com/600x400/000/fff" alt=""/>', 'Modal popup!');
	});
	
	$("a.dynamic").click(function(e) {
		e.preventDefault();
		var str = $("<p>This content is actually a jQuery object, which will change in 3 seconds...</p>");
		bootbox.alert(str);
		setTimeout(function() {
			str.html("See?");
		}, 3000);
	});
	
	$("a.prompt-default").click(function(e) {
		e.preventDefault();
		bootbox.prompt("What is your favourite JS library?", "Cancel", "OK", function(result) {
			console.log("Result: "+result);
		}, "Bootbox.js");
	});
	
	$("a.onescape").click(function(e) {
		e.preventDefault();
		bootbox.dialog("Dismiss this dialog with the escape key...", {
			"label" : "Press Escape!",
			"class" : "btn-danger",
			"callback": function() {
				console.log("Oi! Press escape!");
			}
		}, {
			"onEscape": function() {
				bootbox.alert("This alert was triggered by the onEscape callback of the previous dialog", "Dismiss");
			}
		});
	});

	$("a.nofade").click(function(e) {
		e.preventDefault();
		bootbox.dialog("This dialog does not fade in or out, and thus does not depend on <strong>bootstrap-transitions.js</strong>.",
		{
			"OK": function() {}
		}, {
			"animate": false
		});
	});

	$("a.nobackdrop").click(function(e) {
		e.preventDefault();
		bootbox.dialog("This dialog does not have a backdrop element",
		{
			"OK": function() {}
		}, {
			"backdrop": false
		});
	});

	$("a.icons-explicit").click(function(e) {
		e.preventDefault();
		bootbox.dialog("Custom dialog with icons being passed explicitly into <b>bootbox.dialog</b>.", [{
			"label" : "Success!",
			"class" : "btn-success",
			"icon"  : "icon-ok-sign icon-white"
		}, {
			"label" : "Danger!",
			"class" : "btn-danger",
			"icon"  : "icon-warning-sign icon-white"
		}, {
			"label" : "Click ME!",
			"class" : "btn-primary",
			"icon"  : "icon-ok icon-white"
		}, {
			"label" : "Just a button...",
			"icon"  : "icon-picture"
		}]);
	});

	$("a.icons-override").click(function(e) {
		e.preventDefault();
		bootbox.setIcons({
			"OK"      : "icon-ok icon-white",
			"CANCEL"  : "icon-ban-circle",
			"CONFIRM" : "icon-ok-sign icon-white"
		});

		bootbox.confirm("This dialog invokes <b>bootbox.setIcons()</b> to set icons for the standard three labels of OK, CANCEL and CONFIRM, before calling a normal <b>bootbox.confirm</b>", function(result) {
			bootbox.alert("This dialog is just a standard <b>bootbox.alert()</b>. <b>bootbox.setIcons()</b> only needs to be set once to affect all subsequent calls", function() {
				bootbox.setIcons(null);
			});
		});
	});

	$("a.no-close-button").click(function(e) {
		e.preventDefault();
		bootbox.dialog("If a button's handler now explicitly returns <b>false</b>, the dialog will not be closed. Note that if anything <b>!== false</b> - e.g. nothing, true, null etc - is returned, the dialog will close.", [{
			"I'll close on click": function() {
				console.log("close on click");
				return true;
			},
		}, {
			"I won't!": function() {
				console.log("returning false...");
				return false;
			}
		}]);
	});
	
	
	
	//===== Time pickers =====//

	

	
	
	//===== Autogrowing textarea =====//
	
	$('.auto').autosize();



	//===== Bootstrap functions =====//


	//===== Validation =====//

	



	//===== Append right sidebar to the left =====//

	$(window).resize(function () {
	  var width = $(this).width();
		if (width < 1367) {
			$('.three-columns .appendable').appendTo('#left-sidebar');
			$('.three-columns .content').css('marginRight', '0');
			$.sparkline_display_visible();
		}
		else { 
			$('.three-columns .appendable').appendTo('#right-sidebar');
			$('.three-columns .content').css('marginRight', '240px')
			$.sparkline_display_visible();
		 }
	}).resize();



	//===== Top nav and responsive functions =====//

	$('.topnav > li.search > a').click(function () {
		$('.top-search').fadeToggle(50);
	});

	$('.sidebar-button > a').toggle(function () {
		$('.sidebar').addClass('show-sidebar').removeClass('hide-sidebar');
	},
	function () {
		$('.sidebar').removeClass('show-sidebar').addClass('hide-sidebar');
	}
	);



	//===== Sparklines =====//
	
	$('#balance').sparkline(
		'html', {type: 'bar', barColor: '#db6464', height: '35px', barWidth: "5px", barSpacing: "2px", zeroAxis: "false"}
	);
	$('#clicks').sparkline(
		'html', {type: 'bar', barColor: '#a6c659', height: '35px', barWidth: "5px", barSpacing: "2px", zeroAxis: "false"}
	);
	$('#support').sparkline(
		'html', {type: 'bar', barColor: '#4fb9f0', height: '35px', barWidth: "5px", barSpacing: "2px", zeroAxis: "false"}
	);	



	//===== Tags =====//	
		
	



	//===== Dual select boxes =====//
	
	



	//===== Collapsible plugin for main nav =====//
	
	$('.expand').collapsible({
		defaultOpen: 'current',
		cookieName: 'navAct',
		cssOpen: 'subOpened',
		cssClose: 'subClosed',
		speed: 200
	});



	//===== Input limiter =====//
	
	
	
	

	//===== Masked input =====//
	
	






	//===== Select2 dropdowns =====//

	
		
		

	//===== iButtons =====//
	
	



	//===== Top notification bars =====//
	
	$(".notice .close").click(function() {
		$(this).parent().parent(".notice").fadeTo(200, 0.00, function(){ //fade
			$(this).slideUp(200, function() { //slide up
				$(this).remove(); //then remove from the DOM
			});
		});
	});	
	
	window.setTimeout(function() {
	    $(".closing").fadeTo(200, 0).slideUp(200, function(){
	        $(this).remove(); 
	    });
	}, 5000);

	
	
	//===== Color picker =====//

	




	//===== Spinner options =====//
	
	$( "#spinner-default" ).spinner();
	
	$( "#spinner-decimal" ).spinner({
		step: 0.01,
		numberFormat: "n"
	});
	
	$( "#culture" ).change(function() {
		var current = $( "#spinner-decimal" ).spinner( "value" );
		Globalize.culture( $(this).val() );
		$( "#spinner-decimal" ).spinner( "value", current );
	});
	
	$( "#currency" ).change(function() {
		$( "#spinner-currency" ).spinner( "option", "culture", $( this ).val() );
	});
	
	$( "#spinner-currency" ).spinner({
		min: 5,
		max: 2500,
		step: 25,
		start: 1000,
		numberFormat: "C"
	});
		
	$( "#spinner-overflow" ).spinner({
		spin: function( event, ui ) {
			if ( ui.value > 10 ) {
				$( this ).spinner( "value", -10 );
				return false;
			} else if ( ui.value < -10 ) {
				$( this ).spinner( "value", 10 );
				return false;
			}
		}
	});
	
	$.widget( "ui.timespinner", $.ui.spinner, {
		options: {
			// seconds
			step: 60 * 1000,
			// hours
			page: 60
		},

		_parse: function( value ) {
			if ( typeof value === "string" ) {
				// already a timestamp
				if ( Number( value ) == value ) {
					return Number( value );
				}
				return +Globalize.parseDate( value );
			}
			return value;
		},

		_format: function( value ) {
			return Globalize.format( new Date(value), "t" );
		}
	});

	$( "#spinner-time" ).timespinner();
	$( "#culture-time" ).change(function() {
		var current = $( "#spinner-time" ).timespinner( "value" );
		Globalize.culture( $(this).val() );
		$( "#spinner-time" ).timespinner( "value", current );
	});



	//===== Form elements styling =====//
	
	
		
});