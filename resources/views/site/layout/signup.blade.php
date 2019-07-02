<!DOCTYPE html>
<html>
   <head>
      <title>Nucleus Retail Point of Sale (POS) Retail Point of Sale System - Nucleus POS Free Trial</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <!-- <meta name="viewport" content="width=device-width"> --> <!-- <meta name="viewport" content="width=320, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" /> --> 
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta name="google-site-verification" content="XQGhdONr-3HHTI1nwwqg24Z9_7QOOuENoFCzKx7tb4s" />
      <!-- Facebok Meta Tags --> 
      <meta property="og:title" content="The Ultimate Retail Point of Sale"/>
      <meta property="og:site_name" content="Nucleus"/>
      <meta property="og:url" content="#"/>
      <meta property="og:description" content="Nucleus Retail is more than just a cash register. It will let you run your business from any device." />
      <meta property="og:image" content="{{asset('nucsite/images/retail-hero-image.jpg')}}" />
      <!-- Twitter Meta Tags --> 
      <meta name="twitter:card" content="summary_large_image">
      <meta name="twitter:title" content="The Ultimate Retail Point of Sale">
      <meta name="twitter:description" content="Nucleus Retail is more than just a cash register. It will let you run your business from any device.">
      <meta name="twitter:creator" content="@Nucleuspos">
      <meta name="twitter:site" content="@Nucleuspos">
      <meta name="twitter:image" content="{{asset('nucsite/images/retail-hero-image.jpg')}}">
      <meta name="description" content="Our point of sale system signup is provided by Nucleus's Retail team. Schedule a 30 Minute Demo with a Nucleus Team Memember today and experience the most innovative POS retail system." />
      <meta name="keywords" content="" />
      <link href="{{asset('nucsite/css/style.css?1420645658')}}" media="screen" rel="stylesheet" type="text/css" />
      <link href="{{asset('nucsite/css/landing.css?1420645656')}}" media="screen" rel="stylesheet" type="text/css" />
      <script src="{{asset('nucsite/js/145081786.js')}}"></script> <!-- Replacing Font For Rebranding Andres R (October 2014)--> 
      <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' rel='stylesheet' type='text/css'>
      <!-- Foundation Styles --> 
      <link rel='stylesheet' id='foundation-css' href="{{asset('nucsite/css/foundation.css')}}" type='text/css' media='all' />
      <!-- pingdom --> <script> var _prum = [['id', '52682908abe53d1d3f000000'], ['mark', 'firstbyte', (new Date()).getTime()]]; (function () { var s = document.getElementsByTagName('script')[0] , p = document.createElement('script'); p.async = 'async'; p.src = '//rum-static.pingdom.net/prum.min.js'; s.parentNode.insertBefore(p, s); })(); </script> <!-- Bizible --> 
      <script async type="text/javascript" src="{{asset('nucsite/js/_biz-a.js')}}" ></script> <!--[if IE]> <script src="/js/ie.js"></script> 
      <link rel="stylesheet" type="text/css" media="all" href="/retail/css/browsers/ie.css" />
      <![endif]--> 
      <link rel="canonical" href="#" />
      <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
   </head>
   <body class="retail retail_signup retail_signup_index">
      <div id='sharedmenu--' class='position-static-top black-text'>
         <div class='menu-phone'>
            <h6><span class='phone-icon'></span><span class='number'>(248)480-7003</span></h6>
         </div>
         <nav class='clearfix'> 
            @include('site.include.quick_link')
         </nav>
      </div>
      
      @include('site.include.menu2') 

      <div class="content" role="main" id="">
         <header class="cloud">
            <h2>Nucleus Retail</h2>
            <h1>Get Started</h1>
         </header>
         <div class="sign-up-container">
            <section id="region_disclaimer" class="region_disclaimer">
               <div class="container">
                  <div class="warning">
                     <p><strong>Nucleus Retail</strong> is currently available only within the United States and Canada.<br />If you're not located in either of these countries, we welcome you to try <a href="/onsite/demo/">Nucleus OnSite</a> instead.</p>
                  </div>
               </div>
            </section>
            <section class="trial" style="padding-top: 10px !important;">
               <div class="container">


                     <style type="text/css">
            
                        .alert {
                          padding:10px 20px;
                          margin-bottom: 5px;
                          background-color: #f44336;
                          color: white;
                          display: block;
                          clear: both;
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
                           <strong>Thank You!</strong> {{ session('succmsg') }}
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

                  <aside class="signup">
                     <h2>Request a Demo Today!<span style="background:none; color:#70ae7f; display:block; text-indent:0;">Nucleus POS</span></h2>
                     <img src="{{asset('nucsite/images/signupmain.png')}}" width="480"> 
                  </aside>
                  <div class="signup">
                     <div class="form-no-cc-required">Contract Free! No Credit Required</div>
                     <div class="form-no-cc-required">NOTE: Please put correct contact info, for marketing team to contact you.</div>
                     <div class="form-no-cc-required">NOTE: Demo Request are responded within 24-48 hours after being submitted. Office is closed on Sundays.</div>
                     



                     <form id="signup" method="post" action="{{asset('request/demo')}}">

                        {{csrf_field()}}
                        
                        <dl>
                           <dt><label for="company">Store Name</label></dt>
                           <dd><input label="Store Name" placeholder="Store Name" name="store_name" type="text" required ></dd>
                           <dt><label for="firstName">Name</label></dt>
                           <dd class="split">
                              <div class="fn"> <input placeholder="First Name" name="first_name" type="text" required class="first" > </div>
                              <div class="ln"> <input placeholder="Last Name" name="last_name" type="text" required > </div>
                           </dd>
                           <dt><label for="phone">Phone</label></dt>
                           <dd><input name="phone" type="tel" required minlength="10" placeholder="Phone Number"></dd>
                           <dt><label for="email">Email Address</label></dt>
                           <dd><input placeholder="Email Address" name="email" class="email" type="email" required ></dd>
                           <dt><label for="password">Password</label></dt>
                           <dd>
                              <input name="password" type="password" autocomplete="off" required minlength="6" placeholder="Password" class="password"> 
                              <p class="hint invisible">6 characters minimum</p>
                           </dd>
                           <dt><label for="shops">Business Type</label></dt>
                           <dd>
                              <select name="business_type" class="business_type" required placeholder="Business Type">
                                 <option value="">Business Type</option>
                                 <?php if (!empty($businessType)) 
                                 foreach ($businessType as $rowsbt) { ?> 
                                 <option value="<?php echo $rowsbt->id; ?>"><?php echo $rowsbt->name; ?></option>
                                 <?php } ?> 
                              </select>
                           </dd>
                           <dt><label></label></dt>
                           <dd>
                              <div style="padding-bottom: 20px;"><strong>Terms & Conditions</strong></div>
                              <div style="border: 1px #ccc solid; height: 200px; overflow-y: scroll; padding:5px;"> <strong><u>Terms and Conditions</u></strong> <br /><br /> This Terms and Conditions is a legal document which controls the use of Nucleus’ accessible service. By participating in our site and service, the user must abide by all terms and conditions. <br /><br /> <strong><u>1.Licensing</u></strong> <br /><br /> Given limited access to our site to manage your own business, given the fact that you do not make it available to third parties that have no permission to use our site. NucleusPOSalso keeps all rights to any resources provided to you by us. <br /><br /> <strong><u>2.Restrictions</u></strong> <br /><br /> There will be no sell, resell, or distribution of any of our service to other third parties. Any and all sublicensing/distributing will be exploiting this legal document. There also will be no production of similar features or competitive software that has been seen and used on our system. <br /><br /> <strong><u>3.Availability of Site</u></strong> <br /><br /> NucleusPOS will use sensible efforts to give the service to you 24/7. However, you agree that from time to time there will be small periods that the site may be unreachable for use for several different reasons. These include maintenance protocols, malfunctions, or even causes beyond our control like heavy system congestion or no responses of telecommunications. <br /><br /> <strong><u>4.Payments</u></strong> <br /><br /> Payments of subscriptions are mandatory to be paid and result in quick termination. Payments must be paid in full depending on which subscription was applied for. Payment of any taxes are also required to be paid by you, the client. <br /><br /> <strong><u>5.Obligations</u></strong> <br /><br /> Any and all clients must be of 18 years of age to assure that they are legal to form a binding agreement. All information given to NucleusPOS must be true and as complete as possible. Any information given that is not true, gives NucleusPOS the right to terminate your account and refuse any future subscriptions. <br /><br /> <strong><u>6.You agree not to use the site to:</u></strong> <br /><br /> I.Make anything available through email or posts that is unlawful, threatening, or abusive. II.Make anything available through email or posts that oversteps any patent, copyright or other property. III.Make anything available through email or posts that is unauthorized advertising or spam. IV.Hurt communication between others through hateful or mean dialogue that hurts a user’s ability to participate in discussions. V.Harass or stalk individuals. VI.Contribute to anything that is illegal under any form of law. <br /><br /> <strong><u>7.We can disclose account information if necessary for:</u></strong> <br /><br /> I.Legal Process II.Enforcement of these terms III.Violating third parties IV.For safety of the common good, including NucleusPOS and its users. <br /><br /> <strong><u>8.Unauthorized Use</u></strong> <br /><br /> If any unauthorized use occurs, it is to be brought to our attention as soon as possible. Unauthorized use also gives NucleusPOS the right to terminate or limit the account if kept in secret or not. <br /><br /> <strong><u>9.Intellectual Property Ownership</u></strong> <br /><br /> All website information, logo and visuals along with any other content found on the site now and hereafter are property of NucleusPOS. These copyright laws allow our patents, designs, property, trademarks, and works all to be held to us. You agree that NucleusPOS will hold all rights titles and ownership. <br /><br /> <strong><u>10.Term and Termination</u></strong> <br /><br /> You agree that in any violations of this agreement, NucleusPOS can terminate your access to the service. Any breach of any obligations throughout the terms and conditions along with unauthorized use will be subject to termination. <br /><br /> <strong><u>11.Disclaimer of Warranties</u></strong> <br /><br /> You agree that using the system is of your own risk. In the event of any malfunctions or failures, transactions or data can be lost. NucleusPOS disclaim any and all warranties of any kind. We also make no promises that: The site will meet your company/business’necessities; The service will be on consistently; Results collected from the site will be precise; Failure to operate a secure server that stores personal information. <br /><br /> <strong><u>12.Limitation of Liability</u></strong> <br /><br /> NucleusPOS is not liable for any and all harmful, intangible damages that are done to your business, which includes, but is not restricted to, lost profits or data usage. <br /><br /> <strong><u>Information</u></strong> <br /><br /> 13.1 This agreement supersedes any prior agreements and acts of governor over your use of the site. 13.2 If any provision of this agreement is not followed, termination is a right held by NucleusPOS. 13.3 Any prior agreement assigned without our written approval shall be void. 13.4 There are no third party beneficiary rights. 13.5 Until you do not have an account, you cannot release yourself from receiving user-related emails from NucleusPOS. </div>
                           </dd>
                           <dt><label for="email">I Agree </label></dt>
                           <dd>
                              <div><input style="display: inline !important; width:30px; margin-right:0px;" name="terms" type="checkbox" required > I accept with terms & conditions.</div>
                           </dd>
                        </dl>
                        <p class="signup-xsmall">Once your application is submit, a Nucleus team member will contact you with more details <br /><a href="/#">Powerful</a> made <a href="/#">Simple</a>.</p>
                        <button type="submit" name="save" class="submit demo-download-button">Create Your Account</button> 
                        <p class="signup-small">Request a Demo Today.</p>
                     </form>
                  </div>
               </div>
            </section>
         </div>
         <section class="secondary"> </section>
      </div>
      
      <div id="sharedfooter">
         <div class="small-12 columns clearfix">
            <div class="small-12 columns large-6 clearfix">
               <div class="date-and-terms"> Copyright &copy; 2014-{{date('Y')}}. All Rights Reserved. 
                  <a class='footer-link' href='javascript:void(0);'>Privacy Policy.</a> 
               </div>
            </div>
            <div class="small-12 columns large-6 clearfix footer-list-wrap"> </div>
         </div>
      </div>
      <div id="fill-page" class="off" tabindex="-1"></div>


    @include('site.include.fotscript')
   
   </body>
</html>