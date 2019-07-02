<!DOCTYPE html>
<html>
   <head>
      <title> POS for iPhone Repair & Computer Repair - Nucleus POS</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <!-- <meta name="viewport" content="width=device-width"> --> <!-- <meta name="viewport" content="width=320, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" /> --> 
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta name="google-site-verification" content="XQGhdONr-3HHTI1nwwqg24Z9_7QOOuENoFCzKx7tb4s" />
      <!-- Facebok Meta Tags --> 
      <meta property="og:title" content="Computer Repair POS - iPhone Repair POS | Repair Tracking"/>
      <meta property="og:site_name" content="Nucleus"/>
      <meta property="og:url" content="#"/>
      <meta property="og:description" content="Repair Tracking & POS for iPhone Repair, and Computer Repair Centers. "/> 
      <meta property="og:image" content="{{asset('nucsite/images/retail-hero-image.jpg')}}" />
      <!-- Twitter Meta Tags --> 
      <meta name="twitter:card" content="summary_large_image">
      <meta name="twitter:title" content="Computer Repair POS - iPhone Repair POS | Repair Tracking">
      <meta name="twitter:description" content="Repair Tracking & POS for iPhone Repair, and Computer Repair Centers.">
      <meta name="twitter:creator" content="@Nucleuspos">
      <meta name="twitter:site" content="@Nucleuspos">
      <meta name="twitter:image" content="{{asset('nucsite/images/retail-hero-image.jpg')}}">
      <meta name="description" content="Nucleus POS offers the best competitive pricing on the market." />
      <meta name="keywords" content="iphone repair pos, computer repair pos, repair tracking, iphone parts" />
      <link href="{{asset('nucsite/css/style.css?1419368534')}}" media="screen" rel="stylesheet" type="text/css" />
      <script src="{{asset('nucsite/js/145081786.js')}}"></script> 
      <!-- Replacing Font For Rebranding Andres R (October 2014)--> 
      <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' rel='stylesheet' type='text/css'>
      <!-- Foundation Styles --> 
      <link rel='stylesheet' id='foundation-css' href="{{asset('nucsite/css/foundation.css')}}" type='text/css' media='all' />
      <!-- pingdom --> <script> var _prum = [['id', '52682908abe53d1d3f000000'], ['mark', 'firstbyte', (new Date()).getTime()]]; (function () { var s = document.getElementsByTagName('script')[0] , p = document.createElement('script'); p.async = 'async'; p.src = '//rum-static.pingdom.net/prum.min.js'; s.parentNode.insertBefore(p, s); })(); </script> <!-- Bizible --> 
      <script async type="text/javascript" src="{{asset('nucsite/js/_biz-a.js')}}" ></script> <!--[if IE]> <script src="/js/ie.js"></script> 
      <link rel="stylesheet" type="text/css" media="all" href="/retail/css/browsers/ie.css" />
      <![endif]--> 
      <link rel="canonical" href="#" />
      <link rel="icon" type="image/x-icon" href="{{asset('nucsite/images/favicon.ico')}}" />
   </head>
   <body class="retail retail_pricing retail_pricing_index"> 
      <div id='sharedmenu--' class='position-static-top black-text'>
         <div class='menu-phone'>
            <h6><span class='phone-icon'></span><span class='number'>(248)480-7003</span></h6>
         </div>
         <nav class='clearfix'>
         	@include('site.include.quick_link')
         </nav>
      </div>
      @include('site.include.menu')
      <div class="content" role="main" id="pricing">
      <section class="primary"> </section>
      @include('site.include.menu2')
      <section class="primary">

         <style type="text/css">
            
            .alert {
              padding:10px 20px;
              margin-bottom: 5px;
              background-color: #f44336;
              color: white;
            }

            .alert-success {
              padding: 20px;
              background-color: #4CAF50;
              color: white;
            }

            .closebtn {
              margin-left: 15px;
              color: white;
              font-weight: bold;
              float: right;
              font-size: 22px;
              line-height: 20px;
              cursor: pointer;
              transition: 0.3s;
            }

            .closebtn:hover {
              color: black;
            }
         </style>



         

         

         

         <!-- <a href="/"><img src="/retail/i/lscloud-black.png" class="logo"></a> --> 
         <section style="padding-top:60px;" class="plans">
            <center>
               <h3 class="type">Pricing Packages<br><font size=15><u>Summer Special</u></font></h3>
               </font> 
            </center>
            <div class="container detail"> 

          @if (session('stcerror'))
            <div class="alert successPlace">
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
              <strong>Danger!</strong> {{ session('stcerror') }}
            </div>

             <script type="text/javascript">
                 setTimeout(function(){
                     $('.successPlace').fadeOut('slow');
                 }, 15000);
             </script>
             <?php 
             Session::forget('stcerror');
             ?>
         @endif

         @if (session('succmsg'))
             <div class="alert-success successPlace">
               <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
               <strong>Well done!</strong> {{ session('succmsg') }}
             </div>

             <script type="text/javascript">
                 setTimeout(function(){
                     $('.successPlace').fadeOut('slow');
                 }, 15000);
             </script>
             <?php 
             Session::forget('succmsg');
             ?>
         @endif

         @if (count($errors) > 0)
              @foreach ($errors->all() as $error)

              <div class="alert successPlace">
                 <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                 <strong>Oh snap!</strong> {{ $error }}
               </div>

             @endforeach
             <script type="text/javascript">
                 setTimeout(function(){
                     $('.successPlace').fadeOut('slow');
                 }, 5000);
             </script>
         @endif

               <article class="more">
                  <p class="price">{{$priceYearly->sub_title}}</p>
                  <h3 class="type">{{$priceYearly->title}}</h3>
                  <p class="price"><span class="dollar">$</span>{{$priceYearly->price}}</p>
                  <p class="price" style="font-size:30px; text-transform: uppercase;">Per Year</p>
                  <p style="margin-top:10px; padding-top:10px; border-top: 1px solid #ccc;"> </p>
                  
                  @if(count(json_decode($priceYearly->features)))
                     @foreach(json_decode($priceYearly->features) as $row)
                        <p align="left" style="padding-left: 60px;"><strong><i class="icon-arrowright"></i> {{$row}}</strong></P>
                     @endforeach
                  @endif
                 {{--  <p style="margin-top:10px; padding-top:10px; border-top: 1px solid #ccc;"> </p> --}}

                  {{-- <button type="button" name="save" class="submit demo-download-button">Signup Now</button> --}}
                  
                  <p> 
               </article>
               <article class="more">

                  
                  <form id="p3" action="{{url('new/signup')}}" method="post" target="_top">
                     {{csrf_field()}}
                     <table>
                        <tr>
                           <td><input type="hidden" name="on1" value="Enter Phone Number">Enter Store Name</td>
                        </tr>
                        <tr>
                           <td><input type="text" name="store_name" maxlength="200"></td>
                        </tr>
                        <tr>
                           <td><input type="hidden" name="on1" value="Enter Phone Number">Enter Your Full Name</td>
                        </tr>
                        <tr>
                           <td><input type="text" name="user_name" maxlength="200"></td>
                        </tr>
                        <tr>
                           <td><input type="hidden" name="on2" value="Enter Email Address">Enter Email Address</td>
                        </tr>
                        <tr>
                           <td><input type="text" name="email" maxlength="200"></td>
                        </tr>
                        <tr>
                           <td><input type="hidden" name="on2" value="Enter Email Address">Enter New Password</td>
                        </tr>
                        <tr>
                           <td><input type="password" name="password" maxlength="200"></td>
                        </tr>
                        <tr>
                           <td><input type="hidden" name="on1" value="Enter Phone Number">Enter Phone Number</td>
                        </tr>
                        <tr>
                           <td><input type="text" name="phone" maxlength="200"></td>
                        </tr>
                        
                        <tr>
                           <td>Terms & Conditions</td>
                        </tr>
                        <tr>
                           <td>
                              <div style="border: 1px #ccc solid; padding-bottom: 10px; height: 200px; overflow-y: scroll; padding:5px;">
                                 <strong><u>Terms and Conditions</u></strong> <br /><br /> This Terms and Conditions is a legal document which controls the use of Nucleus’ accessible service. By participating in our site and service, the user must abide by all terms and conditions. <br /><br /> <strong><u>1.Licensing</u></strong> <br /><br /> Given limited access to our site to manage your own business, given the fact that you do not make it available to third parties that have no permission to use our site. NucleusPOSalso keeps all rights to any resources provided to you by us. <br /><br /> <strong><u>2.Restrictions</u></strong> <br /><br /> There will be no sell, resell, or distribution of any of our service to other third parties. Any and all sublicensing/distributing will be exploiting this legal document. There also will be no production of similar features or competitive software that has been seen and used on our system. <br /><br /> <strong><u>3.Availability of Site</u></strong> <br /><br /> NucleusPOS will use sensible efforts to give the service to you 24/7. However, you agree that from time to time there will be small periods that the site may be unreachable for use for several different reasons. These include maintenance protocols, malfunctions, or even causes beyond our control like heavy system congestion or no responses of telecommunications. <br /><br /> <strong><u>4.Payments</u></strong> <br /><br /> Payments of subscriptions are mandatory to be paid and result in quick termination. Payments must be paid in full depending on which subscription was applied for. Payment of any taxes are also required to be paid by you, the client. <br /><br /> <strong><u>5.Obligations</u></strong> <br /><br /> Any and all clients must be of 18 years of age to assure that they are legal to form a binding agreement. All information given to NucleusPOS must be true and as complete as possible. Any information given that is not true, gives NucleusPOS the right to terminate your account and refuse any future subscriptions. <br /><br /> <strong><u>6.You agree not to use the site to:</u></strong> <br /><br /> I.Make anything available through email or posts that is unlawful, threatening, or abusive. II.Make anything available through email or posts that oversteps any patent, copyright or other property. III.Make anything available through email or posts that is unauthorized advertising or spam. IV.Hurt communication between others through hateful or mean dialogue that hurts a user’s ability to participate in discussions. V.Harass or stalk individuals. VI.Contribute to anything that is illegal under any form of law. <br /><br /> <strong><u>7.We can disclose account information if necessary for:</u></strong> <br /><br /> I.Legal Process II.Enforcement of these terms III.Violating third parties IV.For safety of the common good, including NucleusPOS and its users. <br /><br /> <strong><u>8.Unauthorized Use</u></strong> <br /><br /> If any unauthorized use occurs, it is to be brought to our attention as soon as possible. Unauthorized use also gives NucleusPOS the right to terminate or limit the account if kept in secret or not. <br /><br /> <strong><u>9.Intellectual Property Ownership</u></strong> <br /><br /> All website information, logo and visuals along with any other content found on the site now and hereafter are property of NucleusPOS and Neutrix Incorporated. These copyright laws allow our patents, designs, property, trademarks, and works all to be held to us. You agree that NucleusPOS will hold all rights titles and ownership. Any infringement of any Intellectual Property will be handled accordingly. Nucleus POS & Neutrix Inc., hold the full rights to any legal litigation of stolen or infringe Intellectual Property. <br /><br /> <strong><u>10.Term and Termination</u></strong> <br /><br /> You agree that in any violations of this agreement, NucleusPOS can terminate your access to the service. Any breach of any obligations throughout the terms and conditions along with unauthorized use will be subject to termination. <br /><br /> <strong><u>11.Disclaimer of Warranties</u></strong> <br /><br /> You agree that using the system is of your own risk. In the event of any malfunctions or failures, transactions or data can be lost. NucleusPOS disclaim any and all warranties of any kind. We also make no promises that: The site will meet your company/business’necessities; The service will be on consistently; Results collected from the site will be precise; Failure to operate a secure server that stores personal information. <br /><br /> <strong><u>12.Limitation of Liability</u></strong> <br /><br /> NucleusPOS is not liable for any and all harmful, intangible damages that are done to your business, which includes, but is not restricted to, lost profits or data usage. <br /><br /><strong><u>13. Refunds and Returns </u></strong><br /><br />Under no circumstances will paid for services be refunded. Once the service has been paid for, no refunds will be issued. By signing up for the service, and agreeing to these terms and conditions, you understand fully that no money will be refunded in any case for services paid for. Any disputes placed against Neutrix Inc., for refunds for service will be voided via this document being sent to the clients and Neutrix Inc. merchant services.<br /><br /> <strong><u>Information</u></strong> <br /><br /> 14.1 This agreement supersedes any prior agreements and acts of governor over your use of the site. 14.2 If any provision of this agreement is not followed, termination is a right held by NucleusPOS. 14.3 Any prior agreement assigned without our written approval shall be void. 14.4 There are no third party beneficiary rights. 14.5 Until you do not have an account, you cannot release yourself from receiving user-related emails from NucleusPOS. </div>
                           </td>
                        </tr>
                        <tr>
                           <td> <input style="display: inline !important; width:30px; margin-right:0px;" id="tp3" type="checkbox" required > I accept terms & Condition. </td>
                        </tr>
                     </table>
                     
                     <button type="submit" name="save" class="submit demo-download-button"><img width="30" src="{{asset('play/paypal.png')}}" /> Subscribe & Get Access Now</button> 
                  </form>
                  <p> 
               </article>
            </div>
         </section>
         <section style="padding-top:60px;" class="plans">
            <center></center>
         </section>
         <br> 
         <section class="extras">
            <div class="container">
               <img src="{{asset('nucsite/images/comparechart.png')}}"></p> <br> 
               <hr class="fade">
               <section class="get_started">
                  <div class="container">
                     <h3>Request a Demo Today</h3>
                     <p>We're so sure you'll love it, well give it to you for free.</p>
                     <a href="{{asset('signup.php')}}" class="">Request a Demo Today</a>
                  </div>
               </section>
            </div>
         </section>
         <!-- Advanced Reporting --> 
         <hr class="fade">
         <section class="db_details">
            <div class="text">
               <h3>Best Competitive Pricing</h3>
               <p>Nucleus POS is the best priced POS software, with more features packed in than any of its other competitors. Use your POS from your iPhone, iPad, iPod, or other Android Devices. No contracts so you're not stuck to anything. Nucleus can also customize your POS system to better fit your needs!</p>
            </div>
            <article class="half_article">
               <div class="box_lg">
                  <h3 class="type">Customize Features</h3>
                  <p class="price"><span class="dollar">$</span><span class="total">79.95</span><span class="month"> fee</span></p>
                  <p>*Customize your POS to better fit you if needed! We can do it.</p>
               </div>
            </article>
            <article class="half_article screenshot last"> <img alt="Nucleus Dashboard" src="{{asset('nucsite/images/pricingimg.png')}}" /> </article>
            <br style="clear: both;"> 
         </section>
         <!-- Web Store --> 
         <div class="details">
         <hr class="fade">
         <section class="ws_details">
            <div>
         </section>
         <section class="ws_details"> <div class="container"> <p class="more">Need even more? Call (248) 480-7003</p> </div> </section> <hr class="fade"> </div><!-- Web Store --> 
      </section>
      <section class="secondary">
         <br><br> 
         <div class="details">
            <div class="columns small-12 small-centered">
               <div class="columns small-12 medium-6">
                  <h4>POS Demonstration</h4>
                  <p>Request a Demo Today, we know you will love it. No need to hassle through messes of invoice. Bring your store into the future with Nucleus, try it today!</p>
                  <h4>Free, unlimited support</h4>
                  <p>We're here to help – our support is available by phone, email or live chat during the week from 10AM-7PM Eastern Standard Time.</p>
               </div>
               <div class="columns small-12 medium-6">
                  <h4>No hidden fees</h4>
                  <p>Our price we offer is our flat price, they're no hidden fees, no surcharges, just one fee, one fair price, & one amazing POS System.</p>
                  <h4>Free Updates</h4>
                  <p>Free Software updates at all times with Nucleus, at no extra charge. Our competition will charge you to update their already flawed system. We charge nothing, & are happy to help!</p>
               </div>
            </div>
            <br><br> <br><br><br><br> 
            <hr class="fade">
      </section>
      </div> 
      <div align="center">
      <h3>Check out some example videos on Youtube</h3>
      <a href="https://www.youtube.com/channel/UC-fp06uZ6scPR-h6FzDwWEg"><img src="{{asset('nucsite/images/YouTubepic.jpg')}}"></a> <!-- <section class="pro_cta"><div class="container"> <article class="text"><h3>Also check out Nucleus OnSite</h3> <p>If you're looking for integrated tools for Mac and iOS, designed exclusively for Apple devices, Nucleus OnSite is as beautiful and powerful as the hardware it runs on.</p> <p><a class="signup" href="/onsite/demo/">Free Trial</a></p> <p><a class="learnmore" href="/onsite">Learn More</a></p> </article><article class="button"><a href="/demo/"><img src="/retail/i/pro_cta.png"></a></article></div></section> --> 
      <section class="cta clearfix">
         <div class="small-12 columns clearfix">
            <article class="cta_text small-12 medium-6 columns">
               <h3>Step your store into the future. Try Nucleus Today.</h3>
               <p class="demo-download-strip-ctas"><a class="text-cta-links" href="#">Innovation</a> <a style="margin-right: 0" class="text-cta-links" href="#">Creativity</a></p>
            </article>
            <article class="button no-foundation small-12 medium-6 columns">
               <div class="demo-download-button"> <a href="{{asset('signup.php')}}" class="demo-button-iframe">Schedule a Demo Today</a> </div>
            </article>
         </div>
      </section>
    @include('site.include.footer')
	@include('site.include.fotscript')
   </body>
</html>