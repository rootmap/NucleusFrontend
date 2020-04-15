var csrftLarVe = $('meta[name="csrf-token"]').attr("content"),
    AddPaypalLinkActionUrlPartial = $('meta[name="AddPaypalLinkActionUrlPartial"]').attr("content"),
    AddPOSContactSubmitUrl = $('meta[name="AddPOSContactSubmitUrl"]').attr("content"),
    AddInitiateSingupAcPOSUrl = $('meta[name="AddInitiateSingupAcPOSUrl"]').attr("content"),
    AddhardwarePurchase = $('meta[name="hardware"]').attr("content"),
    addAuthrizePaymentURL = $('meta[name="addAuthrizePaymentURL"]').attr("content");

function showSignupSuccess(e) {
    $("#showSignupConSMS").html(successMessage(e)), $("html, body").animate({
        scrollTop: $("#signup").offset().top
    }, 1e3)
}

function showSignupError(e) {
    $("#showSignupConSMS").html(warningMessage(e)), $("html, body").animate({
        scrollTop: $("#signup").offset().top
    }, 1e3)
}

function loadingOrProcessing(e) {
    var a = "";
    return a += '<div class="alert alert-light alert-dismissible fade show" role="alert">', a += "     <strong>Processing !</strong> " + e, a += '     <button type="button" class="close" data-dismiss="alert" aria-label="Close">', a += '        <span aria-hidden="true">&times;</span>', (a += "     </button>") + "</div>"
}

function warningMessage(e) {
    var a = "";
    return a += '<div class="alert alert-warning alert-dismissible fade show" role="alert">', a += "     <strong>Warning!</strong> " + e, a += '     <button type="button" class="close" data-dismiss="alert" aria-label="Close">', a += '        <span aria-hidden="true">&times;</span>', (a += "     </button>") + "</div>"
}

function successMessage(e) {
    var a = "";
    return a += '<div class="alert alert-success alert-dismissible fade show" role="alert">', a += "     <strong>Thank You!</strong> " + e, a += '     <button type="button" class="close" data-dismiss="alert" aria-label="Close">', a += '        <span aria-hidden="true">&times;</span>', (a += "     </button>") + "</div>"
}

function sendContactQueryByPrice(e) {
    $("select[name=package] option[value=" + e + "]").attr("selected", "selected");
    var a = " You Selected Package is " + $("select[name=package] option[value=" + e + "]").html();
    $("#showSignupConSMS").html(successMessage(a)), $("html, body").animate({
        scrollTop: $("#signup").offset().top
    }, 1e3)
}

function submitSignupQuery() {
    var e = $("#footer-signup-name").val(),
        a = $("#footer-signup-company_name").val(),
        n = $("#footer-signup-phone").val(),
        t = $("#footer-signup-address").val(),
        s = $("#footer-signup-email").val(),
        o = $("#footer-signup-password").val(),
        r = $("#footer-signup-package").val();
    if (0 == e.length) return $("#showSignupConSMS").html(warningMessage("Please enter your name.")), !1;
    if (0 == a.length) return $("#showSignupConSMS").html(warningMessage("Please enter your company name.")), !1;
    if (0 == n.length) return $("#showSignupConSMS").html(warningMessage("Please enter your phone.")), !1;
    if (0 == s.length) return $("#showSignupConSMS").html(warningMessage("Please enter your email address.")), !1;
    if (0 == o.length) return $("#showSignupConSMS").html(warningMessage("Please enter your Password.")), !1;
    if (0 == r.length) return $("#showSignupConSMS").html(warningMessage("Please select your package.")), !1;
    $("html, body").animate({
        scrollTop: $("#signup").offset().top
    }, 1e3), $("#showSignupConSMS").html(loadingOrProcessing("Processing, Please Wait...!!!!"));
    var l = 0;
    return $.ajax({
        async: !0,
        type: "POST",
        global: !0,
        dataType: "json",
        url: AddInitiateSingupAcPOSUrl,
        data: {
            name: e,
            company_name: a,
            phone: n,
            address: t,
            email: s,
            password: o,
            package: r,
            _token: csrftLarVe
        },
        success: function(e) {
            l += e
        }
    }), l
}

function loadToSignupFrame() {
    $("html, body").animate({
        scrollTop: $("#signup").offset().top
    }, 1e3)
}

function loadToCardFrame() {
    $("html, body").animate({
        scrollTop: $("#CardBoxCard").offset().top
    }, 1e3)
}

function submitContactQuery() {
    var e = $("#footer-contact-first-name").val(),
        a = $("#footer-contact-last-name").val(),
        n = $("#footer-contact-message").val(),
        t = $("#footer-contact-email").val();
    return 0 == e.length ? ($("#showConSMS").html(warningMessage("Please enter your name.")), !1) : 0 == a.length ? ($("#showConSMS").html(warningMessage("Please enter your phone.")), !1) : 0 == n.length ? ($("#showConSMS").html(warningMessage("Please enter your contact query detail.")), !1) : 0 == t.length ? ($("#showConSMS").html(warningMessage("Please enter your email address.")), !1) : ($("#showConSMS").html(loadingOrProcessing("Saving Contact Query, Please Wait...!!!!")), void $.ajax({
        async: !0,
        type: "POST",
        global: !0,
        dataType: "json",
        url: AddPOSContactSubmitUrl,
        data: {
            name: e,
            phone: a,
            message: n,
            email: t,
            _token: csrftLarVe
        },
        success: function(e) {
            1 == e ? ($("#footer-contact-first-name").val(""), $("#footer-contact-last-name").val(""), $("#footer-contact-message").val(""), $("#footer-contact-email").val(""), $("#showConSMS").html(successMessage("Your query has been submitted. Our Support admin will contact with you shortly."))) : $("#showConSMS").html(warningMessage("Failed, Please try again.."))
        }
    }))
}

function GetCardType(e) {
    var a = new RegExp("^4");
    return null != e.match(a) ? "Visa" : /^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/.test(e) ? "Mastercard" : (a = new RegExp("^3[47]"), null != e.match(a) ? "AMEX" : (a = new RegExp("^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)"), null != e.match(a) ? "Discover" : (a = new RegExp("^36"), null != e.match(a) ? "Diners" : (a = new RegExp("^30[0-5]"), null != e.match(a) ? "Diners - Carte Blanche" : (a = new RegExp("^35(2[89]|[3-8][0-9])"), null != e.match(a) ? "JCB" : (a = new RegExp("^(4026|417500|4508|4844|491(3|7))"), null != e.match(a) ? "Visa Electron" : (a = new RegExp("^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)"), null != e.match(a) ? "Maestro" : (a = new RegExp("^(6304|6706|6771|6709)"), null != e.match(a) ? "Laser" : (a = new RegExp("^(5019)"), null != e.match(a) ? "Dankort" : "Visa/AMEX/MasterCard/Discover")))))))))
}

function clearsignupEvr(){

            $("#footer-signup-name").val("");
            $("#footer-signup-company_name").val("");
            $("#footer-signup-phone").val("");
            $("#footer-signup-address").val("");
            $("#footer-signup-email").val("");
            $("#footer-signup-password").val("");
            $("#footer-signup-package").val("");

            $("#showCardConSMS").html("");

            $("#footer-card-no").val("");
            $("#footer-card-holdername").val("");
            $("#footer-card-month").val("");
            $("#footer-card-year").val("");
            $("#footer-card-pin").val("");

}

function loadToHardwareFrame() {
    $("html, body").animate({
        scrollTop: $("#purchaseArea").offset().top - 100
    }, 1e3)
}

$(document).ready(function() {

    /* swal({
        title: "Thank You.",
        text: "Purchase is complete and sales team will contact with your email soon.",
        type: "success",
        timer: 3000
    }); */

    /* Swal.fire({
        title: "Thank You.",
        text: "Purchase is complete and sales team will contact with your email soon.",
        type: "success",
        timer: 3000
        
    }); */

  /*   Swal.fire({
        icon: 'success',
        title: 'Thank You',
        text: "dd",
        timer: 3000
    }); */


    
    //purchaseArea
    //purchaseplaceitem

    $('.closePurchase').click(function(){
        $('#purchaseArea').hide();
    });

    $('.purchaseHardwareDFK').click(function(){
        var item = $(this).attr('data-pro-til');
        var item_id = $(this).attr('data-push');
        var item_price = $(this).attr('data-pro-price');

        $(".purchaseplaceitem").children('span:eq(0)').html(item);
        $(".purchaseplaceitem").children('span:eq(0)').attr('data-id', item_id);
        $(".purchaseplaceitem").children('span:eq(3)').html(item_price);
        $(".purchaseplaceitem").children('span:eq(3)').attr('data-id', item_price);

        $('#purchaseArea').show();
        loadToHardwareFrame();
    });

    $(".processCreditCard").click(function () {

        var messagePlace ="showSignupConSMS"; 

        

        var hFullName = $("input[name=hFullName]").val(),
            hEmailAddress = $("input[name=hEmailAddress]").val(),
            hPhone = $("input[name=hPhone]").val(),
            hCountry = $("select[name=hCountry]").val(),
            hState = $("input[name=hState]").val(),
            hZipCode = $("input[name=hZipCode]").val(),
            hDeliveryAddress = $("input[name=hDeliveryAddress]").val(),
            hCardNumber = $("input[name=hCardNumber]").val(),
            hCardHolderName = $("input[name=hCardHolderName]").val(),
            hCardMonth = $("select[name=hCardMonth]").val(),
            hCardYear = $("select[name=hCardYear]").val(),
            hCardPin = $("input[name=hCardPin]").val(),
            hardwarePrice = $(".purchaseplaceitem").children('span:eq(3)').attr('data-id'),
            hardware = $(".purchaseplaceitem").children('span:eq(0)').attr('data-id');

        if (hardware==0)
        {
            window.location.href = window.location.href;
        }

        if (hardwarePrice == 0) {
            window.location.href = window.location.href;
        }

        if (0 == hFullName.length) return $("#" + messagePlace).html(warningMessage("Please enter your full name.")), loadToHardwareFrame(), !1;
        if (0 == hEmailAddress.length) return $("#" + messagePlace).html(warningMessage("Please enter your email address.")), loadToHardwareFrame(), !1;
        if (0 == hPhone.length) return $("#" + messagePlace).html(warningMessage("Please enter your phone.")), loadToHardwareFrame(), !1;
        if (0 == hCountry.length) return $("#" + messagePlace).html(warningMessage("Please enter your country.")), loadToHardwareFrame(), !1;
        if (0 == hState.length) return $("#" + messagePlace).html(warningMessage("Please enter your state.")), loadToHardwareFrame(), !1;
        if (0 == hZipCode.length) return $("#" + messagePlace).html(warningMessage("Please enter your zip code.")), loadToHardwareFrame(), !1;
        if (0 == hDeliveryAddress.length) return $("#" + messagePlace).html(warningMessage("Please enter your delivery address.")), loadToHardwareFrame(), !1;
        if (0 == hCardNumber.length) return $("#" + messagePlace).html(warningMessage("Please enter your card number.")), loadToHardwareFrame(), !1;
        if (0 == hCardHolderName.length) return $("#" + messagePlace).html(warningMessage("Please enter your card holder name.")), loadToHardwareFrame(), !1;
        if (0 == hCardMonth.length) return $("#" + messagePlace).html(warningMessage("Please enter your card month.")), loadToHardwareFrame(), !1;
        if (0 == hCardYear.length) return $("#" + messagePlace).html(warningMessage("Please enter your card year.")), loadToHardwareFrame(), !1;
        if (0 == hCardPin.length) return $("#" + messagePlace).html(warningMessage("Please enter your card pin.")), loadToHardwareFrame(), !1;

        $("#" + messagePlace).html(loadingOrProcessing("Payment initiating, Please wait..")), loadToHardwareFrame(), !1;
        Swal.showLoading();
        $.ajax({
            async: true,
            type: "POST",
            global: true,
            dataType: "json",
            url: AddhardwarePurchase,
            data: {
                full_name: hFullName,
                email: hEmailAddress,
                phone: hPhone,
                country: hCountry,
                state: hState,
                zip_code: hZipCode,
                delivery_address: hDeliveryAddress,
                card_number: hCardNumber,
                card_holder_name: hCardHolderName,
                card_month: hCardMonth,
                card_year: hCardYear,
                card_pin: hCardPin,
                hardware: hardware,
                hardware_price: hardwarePrice,
                _token: csrftLarVe
            },
            success: function (res) {
                console.log('Success',res);
                Swal.hideLoading();
                if(res.status==1)
                {

                    
                   

                    $("#" + messagePlace).html(successMessage(res.message)), loadToSignupFrame(), !1;

                    $("input[name=hFullName]").val("");
                    $("input[name=hEmailAddress]").val("");
                    $("input[name=hPhone]").val("");
                    $("input[name=hState]").val("");
                    $("input[name=hZipCode]").val("");
                    $("input[name=hDeliveryAddress]").val("");
                    $("input[name=hCardNumber]").val('');
                    $("input[name=hCardHolderName]").val('');
                    $("input[name=hCardPin]").val('');

                    $(".purchaseplaceitem").children('span:eq(3)').attr('data-id','0'),
                    $(".purchaseplaceitem").children('span:eq(0)').attr('data-id','0');

                    Swal.fire({
                        icon: 'success',
                        title: 'Thank You',
                        text: res.message,
                        timer:10000
                    });

                    $('#purchaseArea').hide();

                }
                else
                {
                    $("#" + messagePlace).html(warningMessage(res.message)), loadToCardFrame(), !1;
                }

                /* if (res.status == 0) {
                    $("#showSignupConSMS").hide();
                    $(".cardprActive").fadeIn("slow");
                    $("#showCardConSMS").html(warningMessage(res.message)), loadToCardFrame(), !1;
                }
                else {
                    clearsignupEvr();
                    $(".paypal_button").fadeIn("slow");
                    $("#showSignupConSMS").show();
                    $(".cardprActive").fadeOut("fast");
                    $("#showSignupConSMS").html(successMessage(res.message)), loadToSignupFrame(), !1;
                } */

            },
            error: function (reject) {
                console.log('Error',reject.status);
                $("#" + messagePlace).html(warningMessage('Something went wrong, Please try again later.')), loadToCardFrame(), !1;
                window.location.href = window.location.href;
            }
        });
    });

	$(".proced_card_payment").click(function(){
		var e = $("#footer-signup-name").val(),
            a = $("#footer-signup-company_name").val(),
            n = $("#footer-signup-phone").val(),
            t = $("#footer-signup-address").val(),
            s = $("#footer-signup-email").val(),
            o = $("#footer-signup-password").val(),
            r = $("#footer-signup-package").val();
        if (0 == e.length) return $("#showSignupConSMS").html(warningMessage("Please enter your name.")), loadToSignupFrame(), !1;
        if (0 == a.length) return $("#showSignupConSMS").html(warningMessage("Please enter your company name.")), loadToSignupFrame(), !1;
        if (0 == n.length) return $("#showSignupConSMS").html(warningMessage("Please enter your phone.")), loadToSignupFrame(), !1;
        if (0 == s.length) return $("#showSignupConSMS").html(warningMessage("Please enter your email address.")), loadToSignupFrame(), !1;
        if (0 == o.length) return $("#showSignupConSMS").html(warningMessage("Please enter your Password.")), loadToSignupFrame(), !1;
        if (0 == r.length) return $("#showSignupConSMS").html(warningMessage("Please select your package.")), loadToSignupFrame(), !1;
        
         var l = $("#footer-card-no").val(),
            i = $("#footer-card-holdername").val(),
            g = $("#footer-card-month").val(),
            h = $("#footer-card-year").val(),
            u = $("#footer-card-pin").val();

                

        if(0 == l.length) return $("#showCardConSMS").html(warningMessage("Please enter your card number.")), loadToCardFrame(), !1;
        if(0 == i.length) return $("#showCardConSMS").html(warningMessage("Please enter your card holder name.")), loadToCardFrame(), !1;
        if(0 == g.length) return $("#showCardConSMS").html(warningMessage("Please enter your card expire month.")), loadToCardFrame(), !1;
        if(0 == h.length) return $("#showCardConSMS").html(warningMessage("Please enter your card expire year.")), loadToCardFrame(), !1;
        if(0 == u.length) return $("#showCardConSMS").html(warningMessage("Please enter your card pin.")), loadToCardFrame(), !1;
        $("#showSignupConSMS").show();
        $("#showSignupConSMS").html(loadingOrProcessing("Payment initiating, Please wait..")), loadToSignupFrame(), !1;

        $.ajax({
            async:true,
            type: "POST",
            global:true,
            dataType: "json",
            url: addAuthrizePaymentURL,
            data: {
                name: e,
                company_name: a,
                phone: n,
                address: t,
                email: s,
                password: o,
                package: r,
                l: l,
                i: i,
                g: g,
                h: h,
                u: u,
                _token: csrftLarVe
            },
            success: function(res) {
                //console.log(res);

                if(res.status==0)
                {
                    $("#showSignupConSMS").hide();
                    $(".cardprActive").fadeIn("slow");
                	$("#showCardConSMS").html(warningMessage(res.message)), loadToCardFrame(), !1;
                }
                else
                {
                    clearsignupEvr();
                    $(".paypal_button").fadeIn("slow");
                    $("#showSignupConSMS").show();
                    $(".cardprActive").fadeOut("fast");
                	$("#showSignupConSMS").html(successMessage(res.message)), loadToSignupFrame(), !1;
                }

            }
        })


	});

    $(".card_payment").click(function() {
        var e = $("#footer-signup-name").val(),
            a = $("#footer-signup-company_name").val(),
            n = $("#footer-signup-phone").val(),
            t = $("#footer-signup-address").val(),
            s = $("#footer-signup-email").val(),
            o = $("#footer-signup-password").val(),
            r = $("#footer-signup-package").val();
        if (0 == e.length) return $("#showSignupConSMS").html(warningMessage("Please enter your name.")), loadToSignupFrame(), !1;
        if (0 == a.length) return $("#showSignupConSMS").html(warningMessage("Please enter your company name.")), loadToSignupFrame(), !1;
        if (0 == n.length) return $("#showSignupConSMS").html(warningMessage("Please enter your phone.")), loadToSignupFrame(), !1;
        if (0 == s.length) return $("#showSignupConSMS").html(warningMessage("Please enter your email address.")), loadToSignupFrame(), !1;
        if (0 == o.length) return $("#showSignupConSMS").html(warningMessage("Please enter your Password.")), loadToSignupFrame(), !1;
        if (0 == r.length) return $("#showSignupConSMS").html(warningMessage("Please select your package.")), loadToSignupFrame(), !1;
        
        $(".cardprActive").fadeIn("slow"), $(".paypal_button").fadeOut("slow");
        
    }), $(".exit_card_payment").click(function() {
        $(".cardprActive").fadeOut("slow"), $(".paypal_button").fadeIn("slow")
    }), $("#footer-card-no").keyup(function() {
        var e = $(this).val();
        if (e.length > 0) {
            var a = GetCardType(e);
            $("#cardTypeHTML").html(a), $("#cardTypeHTML").fadeIn("slow")
        } else $("#cardTypeHTML").fadeOut("slow"), $("#cardTypeHTML").html("Visa/AMEX/MasterCard/Discover")
    }), $(".Paypal_Pay").click(function() {
        var e = $("#footer-signup-name").val(),
            a = $("#footer-signup-company_name").val(),
            n = $("#footer-signup-phone").val(),
            t = $("#footer-signup-address").val(),
            s = $("#footer-signup-email").val(),
            o = $("#footer-signup-password").val(),
            r = $("#footer-signup-package").val();
        return 0 == e.length ? ($("#showSignupConSMS").html(warningMessage("Please enter your name.")), !1) : 0 == a.length ? ($("#showSignupConSMS").html(warningMessage("Please enter your company name.")), !1) : 0 == n.length ? ($("#showSignupConSMS").html(warningMessage("Please enter your phone.")), !1) : 0 == s.length ? ($("#showSignupConSMS").html(warningMessage("Please enter your email address.")), !1) : 0 == o.length ? ($("#showSignupConSMS").html(warningMessage("Please enter your Password.")), !1) : 0 == r.length ? ($("#showSignupConSMS").html(warningMessage("Please select your package.")), !1) : ($("html, body").animate({
            scrollTop: $("#signup").offset().top
        }, 1e3), $("#showSignupConSMS").html(loadingOrProcessing("Processing, Please Wait...!!!!")), void $.ajax({
            async: !0,
            type: "POST",
            global: !0,
            dataType: "json",
            url: AddInitiateSingupAcPOSUrl,
            data: {
                name: e,
                company_name: a,
                phone: n,
                address: t,
                email: s,
                password: o,
                package: r,
                _token: csrftLarVe
            },
            success: function(e) {
                if (!(e > 1)) return 1 == e ? ($("#showSignupConSMS").html(warningMessage("Email account already exists, please try new email.")), !1) : ($("#showSignupConSMS").html(warningMessage("Failed, Please try again..")), !1);
                $("#showSignupConSMS").html(loadingOrProcessing("Payment initiating, Please wait.."));
                var a = AddPaypalLinkActionUrlPartial + "/SPX" + e;
                window.location.href = a
            }
        }))
    })
});