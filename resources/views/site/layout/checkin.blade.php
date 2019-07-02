<!DOCTYPE html>
<html>
   <head>
      <title>Repairs &amp; Sales - Nucleus POS</title>
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
      <!-- pingdom -->
      <script>var _prum = [['id', '52682908abe53d1d3f000000'], ['mark', 'firstbyte', (new Date()).getTime()]];(function() { var s = document.getElementsByTagName('script')[0] , p = document.createElement('script'); p.async = 'async'; p.src = '//rum-static.pingdom.net/prum.min.js'; s.parentNode.insertBefore(p, s);})();</script><!-- Bizible -->
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
      <!-- /retail-hero -->
      @include('site.include.menu2')
      <section class="information no-pad checklist">
         <div class="container detail">
            <article class="full tag">
               <h2>Why the In-Store Repair Method is Superior </h2>
            </article>
            <article class="more full checklist">
               <ul>
                  <li>Quick Transactions</li>
                  <li>Customize In-Store Repair System</li>
                  <li>Premium System Intergration</li>
               </ul>
               <ul>
                  <li>Easy to Use</li>
                  <li>Inventory Management.</li>
                  <li>LCD Recycling</li>
               </ul>
               <ul>
                  <li>Multifunction Interface</li>
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
               <h2>Some In-Store Repair Examples:</h2>
            </article>
         </div>
         @include('site.include.menu')
         <div class="container detail">
            <article class="full">
               <ul class="tab-controls" id="tabcontrols">
                  <li id="performance"><i></i>iPhone Repairs</li>
                  <li id="end-of-day"><i></i> In-Store Repair Process</li>
                  <li id="reports"><i></i>Customize Settings</li>
               </ul>
            </article>
         </div>
         <div id="slides" class="clearfix">
            <!-- Employee Performance Slide --> 
            <div id="employeeperformance" class="container detail slide">
               <article class="half"> <img alt="Real-time data" src="{{asset('nucsite/images/checkin1.png')}}" /> </article>
               <article class="half">
                  <h3>iPhone Repair</h3>
                  <h4>iPhone Repairs are your most common repairs, make it easy for your customers transaction. With the In-Store Repair System you can have your customer invoice created in just moments. Feature packed with ways to follow up with your repairs. The In-Store Repair system was designed to make your complicated repair system simple. No need for papers or invoices anymore.</h4>
                  <ul>
                     <li>Keeps Progress</li>
                     <li>Management System</li>
                     <li>Easy setup</li>
                  </ul>
               </article>
            </div>
            <!-- End of Employee Performance Slide --> <!-- End of Day Slide --> 
            <div id="endofday" class="container detail slide">
               <article class="half side-hide"> <img alt="Real-time data" src="{{asset('nucsite/images/checkin1.png')}}" /> </article>
               <article class="half">
                  <h3> In-Store Repair Process</h3>
                  <h4>The In-Store Repair process is easy & convenient process for getting your customers in & out of your store. But most importantly it was designed to grow your business! The backend system of the In-Store Repair process keeps track of all your most popular repairs so you know what customers are getting fixed most. With so many other features, Nucleus will become your best employee.</h4>
               </article>
            </div>
            <!-- End of End of Day Slide --> <!-- Product Reports Slide --> 
            <div id="productreports" class="container detail slide">
               <article class="half side-hide"> <img alt="Real-time data" src="{{asset('nucsite/images/checkin2.png')}}" /> </article>
               <article class="half">
                  <h3>Customize Settings</h3>
                  <h4>Customize your In-Store Repair system to work best for your store. Nucleus comes preprogrammed with all the markets most popular repairs. Nucleus also allows you to add your own In-Store Repair, and customize your In-Store Repair system!</h4>
               </article>
            </div>
            <!-- End of Product Reports Slide -->
         </div>
      </section>
  
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
               <h2> In-Store Repair System</h2>
               <h4>Efficiency made simple.</h4>
            </article>
         </div>
         <div class="container detail">
            <article id="second-item" class="half">
               <h2> In-Store Repair Process</h2>
               <h3> In-Store Repair process was designed efficiently to make your job simple. Most repair centers still use a piece of paper and check off boxes. Well with Nucleus, we have designed a system that removes all the wasted paper & created a virtual checkin system.</h3>
                
               <p>Manage your most important repairs.</p>
               <p>Customize your In-Store Repair System!</p>
            </article>
            <article id="first-item" class="half"> <img alt="Real-time data" src="{{asset('nucsite/images/checkinpage1.png')}}" /> </article>
         </div>
         <div class="container detail">
            <article class="half"> <img alt="Real-time data" src="{{asset('nucsite/images/checkinpage2.png')}}" /> </article>
            <article class="half">
               <h2>Keep track of your customer data</h2>
               <h3>At the end of each In-Store Repair process, you have the option to enter your customer date that you need for records. Throughout the process you choose the carrier, color, gig, repair issue & more!</h3>
                
               <p>Genius, and simplicity meet.</p>
            </article>
         </div>
         <div class="container detail">
            <article id="fourth-item" class="half" style="margin-top: 20px;">
               <h2> In-Store Repair List</h2>
               <h3>View a virtual list of all your In-Store Repair, what’s paid, what’s done, and needs to be paid & so much more. & you have the option to report it to excel or adobe!</h3>
                
               <p> In-Store Repair list removes all the annoying papers, and makes your store more efficient.</p>
               <p><em>View if its been, diagnosed, completed, invoiced, and what the warranty status is.</em></p>
            </article>
            <article id="third-item" class="half"> <img alt="Phones" src="{{asset('nucsite/images/checkinpage3.png')}}" /> </article>
         </div>
      </section>
      <div class="customers-wrapper">
         <section class="information customer-thumbs">
            <div class="small-12 medium-10 large-6 columns small-centered detail">
               <article class="more small-12 medium-6 columns">
                  <a class="fancybox-iframe vimeo-video dashboard" target="_blank" href="http://youtube.com/embed/8DaxopagUEY?&autoplay=1&autohide=1"> <i></i> </a> 
                  <h4 class="quote">Check out this video, to see how easy it is to check a customer in!</h4>
                  <p class="quote-credit"> In-Store Repair Process<br> <span>Nucleus</span></p>
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