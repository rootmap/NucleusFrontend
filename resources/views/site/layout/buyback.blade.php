<!DOCTYPE html>
<html>
   <head>
      <title>Device Buyback System - Nucleus POS</title>
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
      <meta name="description" content="POS Reporting & Analytics are included with Nucleus POS, including inventory tracking, employee performance, and more. Visit Nucleus POS today." />
      <meta name="keywords" content="" />
      <link href="{{asset('nucsite/css/style.css?1419368497')}}" media="screen" rel="stylesheet" type="text/css" />
      <link href="{{asset('nucsite/css/landing.css?1419022430')}}" media="screen" rel="stylesheet" type="text/css" />
      <script src="{{asset('nucsite/js/145081786.js')}}"></script> <!-- Replacing Font For Rebranding Andres R (October 2014)--> 
      <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' rel='stylesheet' type='text/css'>
      <!-- Foundation Styles --> 
      <link rel='stylesheet' id='foundation-css' href="{{asset('nucsite/css/foundation.css')}}" type='text/css' media='all' />
      <!-- pingdom --><script>var _prum = [['id', '52682908abe53d1d3f000000'], ['mark', 'firstbyte', (new Date()).getTime()]];(function() { var s = document.getElementsByTagName('script')[0] , p = document.createElement('script'); p.async = 'async'; p.src = '//rum-static.pingdom.net/prum.min.js'; s.parentNode.insertBefore(p, s);})();</script><!-- Bizible -->
      <script async type="text/javascript" src="{{asset('nucsite/js/_biz-a.js')}}" ></script> <!--[if IE]><script src="/js/ie.js"></script>
      <link rel="stylesheet" type="text/css" media="all" href="/retail/css/browsers/ie.css" />
      <![endif]-->
      <link rel="canonical" href="#" />
      <link rel="icon" type="image/x-icon" href="{{asset('nucsite/images/favicon.ico')}}" />
      <style type="text/css">section.information.waves {background:none !important;}#reporting.rebrand-hero { height: 150px; /*background: url('images/reporting-hero.jpg') no-repeat scroll center bottom / cover transparent;*/background:none; width: 100%; color: #FFF; text-align: center; font-weight: 300;}</style>
   </head>
   <body class="retail retail_reporting retail_reporting_index">
     
      <div id='sharedmenu--' class='position-absolute-top white-text'>
         <div class='menu-phone'>
            <h6><span class='phone-icon'></span><span class='number'>(248)480-7003</span></h6>
         </div>
         <nav class='clearfix'>
         	@include('site.include.quick_link')
         		
         	</nav>
      </div>
  

      <div class="content" role="main">


      <div id="reporting" class="rebrand-hero reporting-hero">
         <section class="main-hero-text clearfix">
            <div class="container wrapper-resources grid_6">
               <div class="half-width">
                  <h1></h1>
                  <p></p>
               </div>
               <!-- end half-width -->
            </div>
         </section>
         <!-- /main-retail-text -->
      </div>
      @include('site.include.menu2')
      <section class="information no-pad checklist">
         <div class="container detail">
            <article class="full tag">
               <h2>Keep track of all your Buybacks</h2>
            </article>
            <article class="more full checklist">
               <ul>
                  <li>Custom Buyback Templetes</li>
                  <li>Buyback List</li>
                  <li>Keep track of Buybacks</li>
               </ul>
               <ul>
                  <li>Buyback Estimate List</li>
                  <li>Manage Estimate List</li>
                  <li>Customized Prices</li>
               </ul>
               <ul>
                  <li>Intergated with POS</li>
                  <li>and more.</li>
               </ul>
            </article>
         </div>
      </section>
      <hr class="line">
      <!-- Features Slider -->
      <section class="information waves slider-container">
         <div class="container detail">
            <article class="full tag">
               <h2> <object data="http://www.youtube.com/embed/M74krkrTm" width="560" height="315"></object></h2>
               <h2>Some Buyback Examples:</h2>
            </article>
         </div>
         @include('site.include.menu')
         <div class="container detail">
            <article class="full">
               <ul class="tab-controls" id="tabcontrols">
                  <li id="performance"><i></i>Buyback Estimates</li>
                  <li id="end-of-day"><i></i>Buyback List</li>
                  <li id="reports"><i></i>Buyback Estimate List</li>
               </ul>
            </article>
         </div>
         <div id="slides" class="clearfix">
            <!-- Employee Performance Slide --> 
            <div id="employeeperformance" class="container detail slide">
               <article class="half"> 
               		<img alt="Real-time data" src="{{asset('nucsite/images/buyback1.png')}}" /> 
               </article>
               <article class="half">
                  <h3>Buyback List</h3>
                  <h4>Buyback list, is a listed generated from all the Buybacks you have submitted through Nucleus. Be able to go back days, weeks, or months, and see how much you paid for a device, who you purchased it from and so much more..</h4>
                  <ul>
                     <li>Manage Condition</li>
                     <li>Manage Carrier</li>
                     <li>& so much more!</li>
                  </ul>
               </article>
            </div>
            <!-- End of Employee Performance Slide --> <!-- End of Day Slide --> 
            <div id="endofday" class="container detail slide">
               <article class="half side-hide"> 
               		<img alt="Real-time data" src="{{asset('nucsite/images/buyback2.png')}}" /> 
               </article>
               <article class="half">
                  <h3>Buyback Estimates</h3>
                  <h4>Nucleus is integrated with a system, that pulls all the devices prices from 5 of the most major buyback providers in the nation, and created an algorithm that helps you know how much to pay for a device! It's genius made simple.</h4>
               </article>
            </div>
            <!-- End of End of Day Slide --> <!-- Product Reports Slide --> 
            <div id="productreports" class="container detail slide">
               <article class="half side-hide"> <img alt="Real-time data" src="{{asset('nucsite/images/buyback3.png')}}" /> </article>
               <article class="half">
                  <h3>Buyback Estimate List</h3>
                  <h4>We understand that most store owners or franchise owners, aren't always at their store. With the Buyback estimate list store owners can view how many buyback estimates were made, & how many were closed.</h4>
               </article>
            </div>
            <!-- End of Product Reports Slide -->
         </div>
      </section>
      <!-- End Features Slider --><!-- Page CTA<section class="information grey reporting-cta"> <div class="container"> <div class="container detail"> <article class="more two_third"><h2>Start a 14-day free trial and try Nucleus Retail’s built-in reports for yourself.</h2></article> <article class="more third"> <p class="button"><a href="/retail/signup" class="free_trial">Start Your Free Trial</a></p> </article> </div> </div></section> -->
      <section class="promo-widget row-full-width">
         <div class="small-12 columns medium-12 large-9 small-centered">
            <div class="small-12 medium-3 columns small-centered medium-uncentered promo-bg"></div>
            <div class="small-12 medium-5 columns small-centered medium-uncentered widget-left-content">
               <h4>Try us today!</h4>
               <p>We are so sure you will love Nucleus, we'll let you try it for free!</p>
            </div>
            <div class="small-12 medium-3 medium-offset-1 columns small-centered medium-uncentered cta-wrapper"> <a class="cta-promo-widget" href="{{asset('signup.php')}}">Start Today</a> </div>
         </div>
      </section>
      <section class="information advanced-reporting">
         <div class="container detail">
            <article class="full tag">
               <h2>Buyback System</h2>
               <h4>Make your life easier.</h4>
            </article>
         </div>
         <div class="container detail">
            <article id="second-item" class="half">
               <h2>Buyback List</h2>
               <h3>A generated list of all the devices you’re purchased from month, day, week, and year. Keep track of all your buybacks, with the option to export the list via adobe, or excel!</h3>
                
               <p>Manage your Money.</p>
               <p>Keep track of your devices.</p>
            </article>
            <article id="first-item" class="half"> <img alt="Real-time data" src="{{asset('nucsite/images/buybackpage1.png')}}" /> </article>
         </div>
         <div class="container detail">
            <article class="half"> <img alt="Real-time data" src="{{asset('nucsite/images/buybackpage2.png')}}" /> </article>
            <article class="half">
               <h2>Buyback Data</h2>
               <h3>Create all the data you want in the Buyback, save all the information for your records from Model, Carrier, IMEI, Type, Color, Memory, Condition, Price, & Payment Method.</h3>
                
               <p>Genius, and simplicity meet.</p>
            </article>
         </div>
         <div class="container detail">
            <article id="fourth-item" class="half" style="margin-top: 20px;">
               <h2>Buyback Estimates</h2>
               <h3>Neutrix has created a system inside of Nucleus that is integrated with 5 of the nation’s largest Device buyback websites. It generates a price estimate it thinks you should pay with making a wonderful profit margin. This makes it easy for your employees to have a general idea of how much to pay for a device.</h3>
                
               <p>Buyback Estimates saves you time, and annoying phone calls.</p>
               <p><em>Customize your buyback estimates with Nucleus intergrated system!</em></p>
            </article>
            <article id="third-item" class="half"> <img alt="Phones" src="{{asset('nucsite/images/buybackpage3.png')}}" /> </article>
         </div>
      </section>
      <div class="customers-wrapper">
         <section class="information customer-thumbs">
            <div class="small-12 medium-10 large-6 columns small-centered detail">
               <article class="more small-12 medium-6 columns">
                  <a class="fancybox-iframe vimeo-video dashboard" target="_blank" href="http://youtube.com/embed/qSGuOtrRno0?&autoplay=1&autohide=1"> <i></i> </a> 
                  <h4 class="quote">Check out this video, to see how easy it is the buyback system is!</h4>
                  <p class="quote-credit">Buyback Process<br> <span>Nucleus</span></p>
               </article>
            </div>
         </section>
         <section class="cta clearfix">
            <div class="small-12 columns clearfix">
               <article class="cta_text small-12 medium-6 columns">
                  <h3>I know it seems unreal, or unnecessary. But trust us, it's very real, and very necessary.</h3>
                  <p class="demo-download-strip-ctas"><a class="text-cta-links" href="#">Simple</a> <a style="margin-right: 0" class="text-cta-links" href="#">Smart</a></p>
               </article>
               <article class="button no-foundation small-12 medium-6 columns">
                  <div class="demo-download-button"><a href="{{asset('signup.php')}}" class="demo-button-iframe">Start for Free</a></div>
               </article>
            </div>
         </section>
      </div>
        
    @include('site.include.footer')
    @include('site.include.fotscript')
   
   </body>
</html>