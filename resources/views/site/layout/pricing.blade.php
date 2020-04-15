<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <!-- Site Title-->
    <title>{{$siteInfo->site_name}} | simpleretailpos.com</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    @include('site.include.header')
    <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="https://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="js/html5shiv.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="page-loader">
      <div class="brand-name"><img src="{{url('upload/site_logo/'.$siteInfo->site_logo)}}" alt="" />
      </div>
      <div class="page-loader-body">
        <div class="cssload-jumping"><span></span><span></span><span></span><span></span><span></span></div>
      </div>
    </div>
    <!-- Page-->
    <div class="page">
      <!-- Page Header-->
      <header class="section page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap novi-background">
          <nav class="rd-navbar rd-navbar-top-panel-lightnav rd-navbar rd-navbar-top-panel-light" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-fullwidth" data-xl-device-layout="rd-navbar-fullwidth" data-xxl-layout="rd-navbar-fullwidth" data-xxl-device-layout="rd-navbar-fullwidth" data-lg-stick-up-offset="90px" data-xl-stick-up-offset="90px" data-xxl-stick-up-offset="90px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true" data-stick-up-clone="true">
            <div class="rd-navbar-inner">
              <!-- RD Navbar Nav-->
              <div class="rd-navbar-nav-wrap">
                <ul class="rd-navbar-nav">
                    <li><a href="#about-us">About Us</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#pricing">Our Prices</a></li>
                    <li><a href="#contactus">Contact us</a></li>
                </ul>
              </div>
              <!-- RD Navbar Panel-->
              <div class="rd-navbar-panel">
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                <!-- RD Navbar Brand-->
                <div class="rd-navbar-brand"><a class="brand-name" href="javascript:backtoTop();">
                	<img src="{{url('upload/site_logo/'.$siteInfo->site_logo)}}" alt="" /></a></div>
              </div>
              <!-- RD Navbar Top Panel-->
              <div class="rd-navbar-top-panel">
                <div class="rd-navbar-top-panel-toggle" data-rd-navbar-toggle=".rd-navbar-top-panel"><span></span></div>
                <div class="rd-navbar-top-panel-content">
                  <a class="btn btn-sm btn-primary btn-effect-ujarak" href="#contactus">REQUEST DEMO</a>
                  <a class="btn btn-sm btn-primary btn-effect-ujarak" target="_blank" href="http://simpleretailpos.com">LOGIN</a>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>
      <style type="text/css">
        .details{
          padding: 25px;
          margin-top: 50px;
          background: #FFF;
          min-height: 300px;
          text-align: center;
          background-image: -webkit-radial-gradient(rgba(248, 251, 255, 0.1) 0%, rgba(89, 147, 255, 0.1) 100%);
          background-image: radial-gradient(rgba(248, 251, 255, 0.1) 0%, rgba(89, 147, 255, 0.1) 100%);
          border: 1px solid #C4D8FF;
          display: block;
        }
        @media(min-width:576px) {
          .offset-sm-0 {
            margin-left: 0
          }
        }
      </style>
      <!-- Swiper-->
      <section class="section wow fadeInDown" id="features" data-type="anchor" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-duration: 1s; animation-delay: 0s; animation-name: fadeInUp;">
        <div class="container w-container w-features">
          <div class="row">
            <div class="col-md-6 offset-md-3 col-sm-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s;">
              <center>
                <h3>Pricing Packages<br><font size="15"><u>Summer Special</u></font></h3>
             </center>
             <div class="details">
               <h3 class="type">Repair Shop - SPECIAL</h3>
               <h3 class="type">Sinlge Repair Shops</h3>
               <p class="price"><span class="dollar">$</span>129</p>
               <p class="price">Per Year</p>
               <p><strong>∞</strong> Computers</p>
               <p><strong>10 </strong>Employees</p>
               <p><strong>Only $10.75 </strong>Montlhy</p>
               <p><strong>BUDGET FRIENDLY</strong></p>
               <p style="margin-top:10px; padding-top:10px; border-top: 1px solid #ccc;">
               </p>
               <p>per location</p>
               <small>*No contract.</small>
               <p></p>
               <p><small>Billed yearly $129 /year</small>
               </p>
               <p style="margin-top:10px; padding-top:10px; border-top: 1px solid #ccc;">
               </p>
               <p><strong>Personal Setup Tutorial</strong><br>
                  <strong>Virtual Support Desk<br>
                  Video Tutorials</strong>
                  <br>
                  <strong>Email Support 10AM-6PM EST Monday-Saturday</strong>
                  <br>
                  <strong>Scheduled Phone Support</strong> 
               </p>
               <form id="p2" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" __biza="WJ__">
                  <input type="hidden" name="cmd" value="_s-xclick">
                  <input type="hidden" name="hosted_button_id" value="JRJJHYWBU86J4">
                  <table>
                     <tbody>
                        <tr>
                           <td><input type="hidden" name="on0" value="Repair Shop - SPECIAL">Repair Shop - SPECIAL</td>
                        </tr>
                        <tr>
                           <td>
                              <select name="os0">
                                 <option value="Yearly Plan - SPECIAL">Yearly Plan - SPECIAL : $129.00 USD - yearly</option>
                              </select>
                           </td>
                        </tr>
                        <tr>
                           <td><input type="hidden" name="on1" value="Enter Phone Number">Enter Phone Number</td>
                        </tr>
                        <tr>
                           <td><input type="text" name="os1" maxlength="200"></td>
                        </tr>
                        <tr>
                           <td><input type="hidden" name="on2" value="Enter Email Address">Enter Email Address</td>
                        </tr>
                        <tr>
                           <td><input type="text" name="os2" maxlength="200"></td>
                        </tr>
                        <tr>
                           <td>Terms &amp; Conditions</td>
                        </tr>
                        <tr>
                           <td>
                              <div style="border: 1px #ccc solid; padding-bottom: 10px; height: 200px; overflow-y: scroll; padding:5px;">
                                 <strong><u>Terms and Conditions</u></strong>
                                 <br><br>
                                 This Terms and Conditions is a legal document which controls the use of Nucleus’ accessible service. By participating in our site and service, the user must abide by all terms and conditions.
                                 <br><br>
                                 <strong><u>1.  Licensing</u></strong>
                                 <br><br>
                                 Given limited access to our site to manage your own business, given the fact that you do not make it available to third parties that have no permission to use our site. NucleusPOS also keeps all rights to any resources provided to you by us.
                                 <br><br>
                                 <strong><u>2.  Restrictions</u></strong>
                                 <br><br>
                                 There will be no sell, resell, or distribution of any of our service to other third parties. Any and all sublicensing/distributing will be exploiting this legal document. There also will be no production of similar features or competitive software that has been seen and used on our system.
                                 <br><br>
                                 <strong><u>3.  Availability of Site</u></strong>
                                 <br><br>
                                 NucleusPOS will use sensible efforts to give the service to you 24/7. However, you agree that from time to time there will be small periods that the site may be unreachable for use for several different reasons. These include maintenance protocols, malfunctions, or even causes beyond our control like heavy system congestion or no responses of telecommunications.
                                 <br><br>
                                 <strong><u>4.  Payments</u></strong>
                                 <br><br>
                                 Payments of subscriptions are mandatory to be paid and result in quick termination. Payments must be paid in full depending on which subscription was applied for. Payment of any taxes are also required to be paid by you, the client.
                                 <br><br>
                                 <strong><u>5.  Obligations</u></strong>
                                 <br><br>
                                 Any and all clients must be of 18 years of age to assure that they are legal to form a binding agreement. All information given to NucleusPOS must be true and as complete as possible. Any information given that is not true, gives NucleusPOS the right to terminate your account and refuse any future subscriptions. 
                                 <br><br>
                                 <strong><u>6.  You agree not to use the site to:</u></strong>
                                 <br><br>
                                 I. Make anything available through email or posts that is unlawful, threatening, or abusive.
                                 II.  Make anything available through email or posts that oversteps any patent, copyright or other property.
                                 III. Make anything available through email or posts that is unauthorized advertising or spam.
                                 IV.  Hurt communication between others through hateful or mean dialogue that hurts a user’s ability to participate in discussions.
                                 V. Harass or stalk individuals.
                                 VI.  Contribute to anything that is illegal under any form of law.
                                 <br><br>
                                 <strong><u>7.  We can disclose account information if necessary for:</u></strong>
                                 <br><br>
                                 I. Legal Process
                                 II.  Enforcement of these terms
                                 III. Violating third parties
                                 IV.  For safety of the common good, including NucleusPOS and its users.
                                 <br><br>
                                 <strong><u>8.  Unauthorized Use</u></strong>
                                 <br><br>
                                 If any unauthorized use occurs, it is to be brought to our attention as soon as possible. Unauthorized use also gives NucleusPOS the right to terminate or limit the account if kept in secret or not.
                                 <br><br>
                                 <strong><u>9.  Intellectual Property Ownership</u></strong>
                                 <br><br>
                                 All website information, logo and visuals along with any other content found on the site now and hereafter are property of NucleusPOS and Neutrix Incorporated. These copyright laws allow our patents, designs, property, trademarks, and works all to be held to us. You agree that NucleusPOS will hold all rights titles and ownership. Any infringement of any Intellectual Property will be handled accordingly. Nucleus POS &amp; Neutrix Inc., hold the full rights to any legal litigation of stolen or infringe Intellectual Property. 
                                 <br><br>
                                 <strong><u>10. Term and Termination</u></strong>
                                 <br><br>
                                 You agree that in any violations of this agreement, NucleusPOS can terminate your access to the service. Any breach of any obligations throughout the terms and conditions along with unauthorized use will be subject to termination.
                                 <br><br>
                                 <strong><u>11. Disclaimer of Warranties</u></strong>
                                 <br><br>
                                 You agree that using the system is of your own risk. In the event of any malfunctions or failures, transactions or data can be lost. NucleusPOS disclaim any and all warranties of any kind. We also make no promises that: The site will meet your company/business’necessities; The service will be on consistently; Results collected from the site will be precise; Failure to operate a secure server that stores personal information.
                                 <br><br>
                                 <strong><u>12. Limitation of Liability</u></strong>
                                 <br><br>
                                 NucleusPOS is not liable for any and all harmful, intangible damages that are done to your business, which includes, but is not restricted to, lost profits or data usage.
                                 <br><br>
                                 <strong><u>13.  Refunds and Returns</u></strong>
                                 <br><br>
                                 Under no circumstances will paid for services be refunded. Once the service has been paid for, no refunds will be issued. By signing up for the service, and agreeing to these terms and conditions, you understand fully that no money will be refunded in any case for services paid for. Any disputes placed against Neutrix Inc., for refunds for service will be voided via this document being sent to the clients and Neutrix Inc. merchant services.
                                 <br><br>
                                 <strong><u>Information</u></strong>
                                 <br><br>
                                 14.1 This agreement supersedes any prior agreements and acts of governor over your use of the site.
                                 14.2 If any provision of this agreement is not followed, termination is a right held by NucleusPOS.
                                 14.3 Any prior agreement assigned without our written approval shall be void.
                                 14.4 There are no third party beneficiary rights.
                                 1.5 Until you do not have an account, you cannot release yourself from receiving user-related emails from NucleusPOS.
                              </div>
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <input style="display: inline !important; width:30px; margin-right:0px;" id="tp2" type="checkbox" required=""> I accept terms &amp; Condition.
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <input type="hidden" name="currency_code" value="USD">
                  <input type="image" onclick="p2()" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                  <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                  <script>
                     function p2()
                     {
                         if(document.getElementById('tp2').checked==true)
                         {
                             $('#p2').submit();
                         }
                         else
                         {
                             alert('Please accept our terms & condition');
                             return true;
                         }
                     }
                  </script>    
               </form>
             </div>
            </div>
          </div>
          
        </div>
      </section>

      <!-- Swiper-->
      
      
      <div class="footer" style="border-top: 1px solid #ddd;">
            <div class="container w-container">
               <div>
                  <div class="w-row">
                     <div class="w-col w-col-3 w-col-stack wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s;">
                        <div class="footer-column-2">
                           <a href="#" class="footer-logo-block w-inline-block"><img src="{{url('upload/site_logo/'.$siteInfo->site_logo)}}" width="150" alt="" class="image-117 w-hidden-medium w-hidden-small w-hidden-tiny"/></a>
                           <div class="top-margin half">
                              <p><strong>{{$siteInfo->site_name}}</strong></p>
                              <div>
                                 <p><span>{{$siteInfo->email}}</span></p>
                              </div>
                              <div>
                                 <p><span>{{$siteInfo->phone}}<br/></span></p>
                              </div>
                              <div>
                                 <p>
                                  <span>
                                    {{$siteInfo->address}}
                                  </span>
                                  </p>
                              </div>
                           </div><br>
                           <a href="#" class="footer-logo-block w-inline-block"><img src="{{url('site/images/nucleuspos.png')}}" width="150" alt="" class="image-117 w-hidden-medium w-hidden-small w-hidden-tiny"/></a>
                        </div>
                     </div>
                     <div class="w-col w-col-3 w-col-stack wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s;">
                        <div class="footer-title"></div>
                        <div class="">
                           <a href="javascript:backtoTop();" class="footer-block w-inline-block w--current">
                              <div class="footer-link normal">Home</div>
                           </a>
                           <a href="#about-us" class="footer-block w-inline-block">
                              <div class="footer-link normal">ABOUT US</div>
                           </a>
                           <a href="#features" class="footer-block w-inline-block">
                              <div class="footer-link normal">Features</div>
                           </a>
                           <a href="#dummyproof" class="footer-block w-inline-block">
                              <div class="footer-link normal">Dummy Proof</div>
                           </a>
                           <a href="#pricing" class="footer-block w-inline-block">
                              <div class="footer-link normal">Our Pricing</div>
                           </a>
                           <a href="#reports" class="footer-block w-inline-block">
                              <div class="footer-link normal">Business Reports</div>
                           </a>
                           <a href="#retail" class="footer-block w-inline-block">
                              <div class="footer-link normal">Retail</div>
                           </a>
                           <a href="#plugnplay" class="footer-block w-inline-block">
                              <div class="footer-link normal">PLUG-and-play</div>
                           </a>
                           <a href="#contactus" class="footer-block w-inline-block">
                              <div class="footer-link normal">Contact Us</div>
                           </a>
                        </div>
                     </div>
                     
                  </div>
                </div>
                  <div class="clearfix"></div>
                  <div class="top-margin">
                     <div>
                        <p class="copyright">Copyright © 2019 SimpleRetailpos.com<br/></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    @include('site.include.fotter')
    <script type="text/javascript">
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
        //alert('d');
          $("#footer-contact-message").focus();
          $("#footer-contact-message").val("I need to activate "+package);
          //$("#footer-contact-message").attr("readonly","readonly");
          //$("#pricing").animate({scrollTop: 0}, 1200);
          $('html, body').animate({
              scrollTop: $("#contactus").offset().top
          }, 1000);
      }

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
            //------------------------Ajax POS Start-------------------------//
            var AddPOSUrl="{{url('save/contact/query')}}";
            $.ajax({
                'async': true,
                'type': "POST",
                'global': true,
                'dataType': 'json',
                'url': AddPOSUrl,
                'data': {'name':name,'phone':phone,'message':message,'email':email,'_token':"{{csrf_token()}}"},
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
                    //console.log("Processing : "+data);
                }
            });
            //------------------------Ajax POS End---------------------------//
      }
    </script>
  </body><!-- Google Tag Manager -->
 

  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer');</script><!-- End Google Tag Manager -->
</html>