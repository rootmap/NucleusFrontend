var csrftLarVe=$('meta[name="csrf-token"]').attr('content');
var AddPaypalLinkActionUrlPartial=$('meta[name="AddPaypalLinkActionUrlPartial"]').attr('content');
var AddPOSContactSubmitUrl=$('meta[name="AddPOSContactSubmitUrl"]').attr('content');
var AddInitiateSingupAcPOSUrl=$('meta[name="AddInitiateSingupAcPOSUrl"]').attr('content');
var addAuthrizePaymentURL=$('meta[name="addAuthrizePaymentURL"]').attr('content');

function showSignupSuccess(errMSG)
{
  $("#showSignupConSMS").html(successMessage(errMSG));

  $('html, body').animate({
      scrollTop: $("#signup").offset().top
  }, 1000);
}

function showSignupError(errMSG)
{
  $("#showSignupConSMS").html(warningMessage(errMSG));

  $('html, body').animate({
      scrollTop: $("#signup").offset().top
  }, 1000);
}



function loadingOrProcessing(sms)
{

var strHtml='';

    strHtml+='<div class="alert alert-light alert-dismissible fade show" role="alert">';
    strHtml+='     <strong>Processing !</strong> '+sms;
    strHtml+='     <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    strHtml+='        <span aria-hidden="true">&times;</span>';
    strHtml+='     </button>';
    strHtml+='</div>';

    return strHtml;

}

function warningMessage(sms)
{
  var strHtml='';

    strHtml+='<div class="alert alert-warning alert-dismissible fade show" role="alert">';
    strHtml+='     <strong>Warning!</strong> '+sms;
    strHtml+='     <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    strHtml+='        <span aria-hidden="true">&times;</span>';
    strHtml+='     </button>';
    strHtml+='</div>';

    return strHtml;
}

function successMessage(sms)
{
  var strHtml='';

    strHtml+='<div class="alert alert-success alert-dismissible fade show" role="alert">';
    strHtml+='     <strong>Thank You!</strong> '+sms;
    strHtml+='     <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    strHtml+='        <span aria-hidden="true">&times;</span>';
    strHtml+='     </button>';
    strHtml+='</div>';

    return strHtml;
}

function sendContactQueryByPrice(package)
{
  $("select[name=package] option[value="+package+"]").attr("selected","selected");
  var packageName=$("select[name=package] option[value="+package+"]").html();
  var packageDetail=" You Selected Package is "+packageName;
  $("#showSignupConSMS").html(successMessage(packageDetail));

  $('html, body').animate({
      scrollTop: $("#signup").offset().top
  }, 1000);
}



function submitSignupQuery()
{
    var name=$("#footer-signup-name").val();
    var company_name=$("#footer-signup-company_name").val();
    var phone=$("#footer-signup-phone").val();
    var address=$("#footer-signup-address").val();
    var email=$("#footer-signup-email").val();
    var password=$("#footer-signup-password").val();
    var package=$("#footer-signup-package").val();

    if(name.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your name.")); 
        return false;
    }

    if(company_name.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your company name.")); 
        return false;
    }

    if(phone.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your phone.")); 
        return false;
    }

    if(email.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your email address.")); 
        return false;
    }

    if(password.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your Password.")); 
        return false;
    }

    if(package.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please select your package.")); 
        return false;
    }

    $('html, body').animate({
        scrollTop: $("#signup").offset().top
    }, 1000);

    $("#showSignupConSMS").html(loadingOrProcessing("Processing, Please Wait...!!!!")); 

    var returnID=0;

    
    $.ajax({
        'async': true,
        'type': "POST",
        'global': true,
        'dataType': 'json',
        'url': AddInitiateSingupAcPOSUrl,
        'data': {
                 'name':name,
                 'company_name':company_name,
                 'phone':phone,
                 'address':address,
                 'email':email,
                 'password':password,
                 'package':package,
                 '_token':csrftLarVe},
        'success': function (data) {
            returnID+=data;
            
        }
    });

    return returnID;
}

function loadToSignupFrame()
{
  $('html, body').animate({
        scrollTop: $("#signup").offset().top
  }, 1000);
}


$(document).ready(function(){

$(".card_payment").click(function(){

    var name=$("#footer-signup-name").val();
    var company_name=$("#footer-signup-company_name").val();
    var phone=$("#footer-signup-phone").val();
    var address=$("#footer-signup-address").val();
    var email=$("#footer-signup-email").val();
    var password=$("#footer-signup-password").val();
    var package=$("#footer-signup-package").val();

    if(name.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your name."));
        loadToSignupFrame(); 
        return false;
    }

    if(company_name.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your company name."));
        loadToSignupFrame(); 
        return false;
    }

    if(phone.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your phone.")); 
        loadToSignupFrame();
        return false;
    }

    if(email.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your email address.")); 
        loadToSignupFrame();
        return false;
    }

    if(password.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your Password.")); 
        loadToSignupFrame();
        return false;
    }

    if(package.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please select your package.")); 
        loadToSignupFrame();
        return false;
    }


    $(".cardprActive").fadeIn('slow');
    $(".paypal_button").fadeOut('slow');

    var cardNumber=$("#footer-card-no").val();
    var cardHoldername=$("#footer-card-holdername").val();
    var expiredate=$("#footer-card-expiredate").val();
    var cardPin=$("#footer-card-pin").val();

    if(cardNumber.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your card number.")); 
        loadToSignupFrame();
        return false;
    }

    if(cardHoldername.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your card holder name.")); 
        loadToSignupFrame();
        return false;
    }

    if(expiredate.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your card expire date.")); 
        loadToSignupFrame();
        return false;
    }

    if(cardPin.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your card pin.")); 
        loadToSignupFrame();
        return false;
    }



    $("#showSignupConSMS").html(loadingOrProcessing("Processing, Please Wait...!!!!")); 

    loadToSignupFrame();

    $.ajax({
        'async': true,
        'type': "POST",
        'global': true,
        'dataType': 'json',
        'url': AddInitiateSingupAcPOSUrl,
        'data': {
                 'name':name,
                 'company_name':company_name,
                 'phone':phone,
                 'address':address,
                 'email':email,
                 'password':password,
                 'package':package,
                 '_token':csrftLarVe},
        'success': function (data) {

            if(data>1)
            {
                $("#showSignupConSMS").html(loadingOrProcessing("Payment initiating, Please wait.."));
                loadToSignupFrame();
                var accProID='SPX'+data;
                var AddZnetLinkActionUrl=addAuthrizePaymentURL+"/"+accProID;
                $.ajax({
                        'async': true,
                        'type': "POST",
                        'global': false,
                        'dataType': 'json',
                        'url': AddZnetLinkActionUrl,
                        'data': {
                            'cardNumber':cardNumber,
                            'cardHName':cardHoldername,
                            'cardExpire':expiredate,
                            'cardcvc':cardPin,
                            '_token':csrftLarVe},
                        'success': function (data) {
                            console.log("Authrizenet Print Sales ID : "+data);
                            if(data==null)
                            {
                                $("#showSignupConSMS").html(warningMessage("Failed to authorize payment. Please try again."));
                            }
                            else
                            {
                                console.log(data.status);
                                if(data.status==1)
                                {
                                    
                                    $("#showSignupConSMS").html(successMessage(data.message));

                                }
                                else
                                {
                                    $("#showSignupConSMS").html(warningMessage(data.message));
                                }
                            }
   
                        }
                    });
            }
            else if(data==1)
            {
                $("#showSignupConSMS").html(warningMessage("Email account already exists, please try new email."));
                loadToSignupFrame();
                return false;
            }
            else
            {
                $("#showSignupConSMS").html(warningMessage("Failed, Please try again.."));
                loadToSignupFrame();
                return false;
            }
            
        }
    });


});




$(".exit_card_payment").click(function(){
    $(".cardprActive").fadeOut('slow');
    $(".paypal_button").fadeIn('slow');
});

$("#footer-card-no").keyup(function(){

    var cardNumber=$(this).val();
    if(cardNumber.length>0)
    {
        var crHT=GetCardType(cardNumber);
        $("#cardTypeHTML").html(crHT);
        $("#cardTypeHTML").fadeIn('slow');
    }
    else
    {
        $("#cardTypeHTML").fadeOut('slow');
        $("#cardTypeHTML").html("Visa/AMEX/MasterCard/Discover");
    }
});


$(".Paypal_Pay").click(function(){

    var name=$("#footer-signup-name").val();
    var company_name=$("#footer-signup-company_name").val();
    var phone=$("#footer-signup-phone").val();
    var address=$("#footer-signup-address").val();
    var email=$("#footer-signup-email").val();
    var password=$("#footer-signup-password").val();
    var package=$("#footer-signup-package").val();

    if(name.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your name.")); 
        return false;
    }

    if(company_name.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your company name.")); 
        return false;
    }

    if(phone.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your phone.")); 
        return false;
    }

    if(email.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your email address.")); 
        return false;
    }

    if(password.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please enter your Password.")); 
        return false;
    }

    if(package.length==0)
    {
        $("#showSignupConSMS").html(warningMessage("Please select your package.")); 
        return false;
    }

    $('html, body').animate({
        scrollTop: $("#signup").offset().top
    }, 1000);

    $("#showSignupConSMS").html(loadingOrProcessing("Processing, Please Wait...!!!!")); 

    var returnID=0;

    
    $.ajax({
        'async': true,
        'type': "POST",
        'global': true,
        'dataType': 'json',
        'url': AddInitiateSingupAcPOSUrl,
        'data': {
                 'name':name,
                 'company_name':company_name,
                 'phone':phone,
                 'address':address,
                 'email':email,
                 'password':password,
                 'package':package,
                 '_token':csrftLarVe},
        'success': function (data) {

            if(data>1)
            {
                $("#showSignupConSMS").html(loadingOrProcessing("Payment initiating, Please wait.."));
                var accProID='SPX'+data;
                var AddPaypalLinkActionUrl=AddPaypalLinkActionUrlPartial+"/"+accProID;
                window.location.href=AddPaypalLinkActionUrl;
            }
            else if(data==1)
            {
                $("#showSignupConSMS").html(warningMessage("Email account already exists, please try new email."));
                return false;
            }
            else
            {
                $("#showSignupConSMS").html(warningMessage("Failed, Please try again.."));
                return false;
            }
            
        }
    });

});

});



function submitContactQuery()
{

    var name=$("#footer-contact-first-name").val();
    var phone=$("#footer-contact-last-name").val();
    var message=$("#footer-contact-message").val();
    var email=$("#footer-contact-email").val();

    if(name.length==0)
    {
        $("#showConSMS").html(warningMessage("Please enter your name.")); 
        return false;
    }

    if(phone.length==0)
    {
        $("#showConSMS").html(warningMessage("Please enter your phone.")); 
        return false;
    }

    if(message.length==0)
    {
        $("#showConSMS").html(warningMessage("Please enter your contact query detail.")); 
        return false;
    }

    if(email.length==0)
    {
        $("#showConSMS").html(warningMessage("Please enter your email address.")); 
        return false;
    }

    $("#showConSMS").html(loadingOrProcessing("Saving Contact Query, Please Wait...!!!!")); 
    
    $.ajax({
        'async': true,
        'type': "POST",
        'global': true,
        'dataType': 'json',
        'url': AddPOSContactSubmitUrl,
        'data': {'name':name,'phone':phone,'message':message,'email':email,'_token':csrftLarVe},
        'success': function (data) {
            //tmp = data;
            if(data==1)
            {
                $("#footer-contact-first-name").val("");
                $("#footer-contact-last-name").val("");
                $("#footer-contact-message").val("");
                $("#footer-contact-email").val("");

                $("#showConSMS").html(successMessage("Your query has been submitted. Our Support admin will contact with you shortly."));
            }
            else
            {
                $("#showConSMS").html(warningMessage("Failed, Please try again.."));
            }
        }
    });
}

function GetCardType(number)
{
  var re = new RegExp("^4");
  if (number.match(re) != null)
      return "Visa";


   if (/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/.test(number)) 
      return "Mastercard";

  re = new RegExp("^3[47]");
  if (number.match(re) != null)
      return "AMEX";

  re = new RegExp("^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)");
  if (number.match(re) != null)
      return "Discover";

  re = new RegExp("^36");
  if (number.match(re) != null)
      return "Diners";

  re = new RegExp("^30[0-5]");
  if (number.match(re) != null)
      return "Diners - Carte Blanche";

  re = new RegExp("^35(2[89]|[3-8][0-9])");
  if (number.match(re) != null)
      return "JCB";

  re = new RegExp("^(4026|417500|4508|4844|491(3|7))");
  if (number.match(re) != null)
      return "Visa Electron";

  re = new RegExp("^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)");
  if (number.match(re) != null)
      return "Maestro";

  re = new RegExp("^(6304|6706|6771|6709)");
  if (number.match(re) != null)
      return "Laser";

  re = new RegExp("^(5019)");
  if (number.match(re) != null)
      return "Dankort";

  return "Visa/AMEX/MasterCard/Discover";
}