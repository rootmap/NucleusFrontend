<!DOCTYPE html>
<html>
   <head>
      <title> Checkin & Sales - Nucleus POS</title>
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
      <!-- <div id="header_hold"><header class="Nucleus"><nav><h3><a href="/">Nucleus - Point of Sale Software</a></h3><section class="smallscreen"><i class="menu">Menu</i></section><ul class="navigation"> <li class='has-sub'><a href='/overview'>Prodfducts</a> <ul class="products"> <li><a class="subnav-overview" href='/compare'>Compare</a></li> <li><a class="subnav-cloud" href='/retail/pos-system'>Cloud</a></li> <li><a class="subnav-ls" href='/Nucleus-pro'>Pro</a></li> <li><a class="subnav-plus line" href='/webstore'>Web Store</a></li> <li><a class="subnav-plus" href='/pos-hardware'>Hardware</a></li> <li><a class="subnav-plus" href='/payments'>Payments</a></li> </ul> </li> <li><a href='/customers'>Customers</a></li> <li class='has-sub'><a href='javascript:void()'>Support</a> <ul class="support"> <li><a class="subnav-ls" href='/support'>Nucleus Pro</a></li> <li><a class="subnav-cloud" href='/retail/help'>Nucleus Retail</a></li> </ul> </li> <li><a href='/find-a-reseller'>Resellers</a></li> <li><a href='/blog'>Blog</a></li> <li><a href='/about'>Company</a></li> <li class="try"><a href="/retail/signup">Start Your Free Trial</a></li></ul> </nav></header><header class="cloud_sub"><nav><ul><li><a href="/retail/pos-system" class="current ov">Cloud</a></li><li><a href="/retail/pos-system-features">Features</a></li><li><a href="/retail/reporting">Reporting</a></li><li><a href="/retail/pricing">Pricing</a></li><li><a href="/retail/apps">Apps</a></li><li><a href="/retail/addons">Add-ons</a></li><li><a href="/retail/help/developers">API</a></li><li class="login"><a href="https://cloud.merchantos.com/">Login</a></li></ul></nav></header></div> --><!-- positionables --><!-- position-absolute-top --><!-- or --><!-- position-static-top --><!-- text colors --><!-- white-text --><!-- or --><!-- black-text -->
      <div id='sharedmenu--' class='position-absolute-top white-text'>
         <div class='menu-phone'>
            <h6><span class='phone-icon'></span><span class='number'>(248)480-7003</span></h6>
         </div>
         <nav class='clearfix'>
            @include('site.include.quick_link')
               
            </nav>
      </div>
      <!-- <li class="has-submenu retail"><a href="#">Retail</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Retail</label></li><li><a href="/retail/">Overview</a></li><li><a href="/retail/pricing/">Pricing</a></li><li><a href="/customers/">Customers</a></li><li class="has-submenu"><a href="#">Business Types</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Retail &ndash; Business Types</label></li><li><a href="/retail/retail-software/bike-shop-software/">Bike Shop</a></li><li><a href="/retail/retail-software/apparel-pos/">Apparel</a></li><li><a href="/retail/retail-software/pet-store-software/">Pet Store</a></li><li><a href="/retail/retail-software/jewelry-pos-software/">Jewelry Store</a></li><li><a href="/retail/retail-software/sporting-goods-pos/">Sporting Goods</a></li></ul></li><li class="has-submenu"><a href="#">More</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Retail &ndash; More</label></li><li><a href="/retail/pos-system-features/">Features</a></li><li><a href="/retail/reporting/">Reporting</a></li><li><a href="/pos-hardware/">Hardware</a></li><li><a href="/payments/">Payments</a></li><li><a href="/ecommerce-solutions/">Web Store</a></li><li><a href="http://nucleuspos.com/signup.php">Resources</a></li></ul></li><li class="level-two"><a href="/find-a-reseller/">Reseller</a></li><li class="level-two"><a href="/retail/help/">Support</a></li><li class="level-two"><a href="https://cloud.merchantos.com">Login</a></li></ul></li> --> 
      <div class="content" role="main">
         <!-- <section class="information reporting-top"> <div class="container"> <article class="text"> <h2>Nucleus Retail Reporting</h2> <h3>Insights that help you grow your retail business.</h3> <p>A smart point of sale should make you smarter, too. That’s why Nucleus Retail comes with built-in<br> reporting that doesn’t just tell you what’s selling – it helps you sell more.</p> <div class="video-wrap"><img alt="Nucleus Retail Reporting" src="/retail/i/reporting/reporting-main.png?1417625550" /></div> </div></section> --><!-- retail-hero -->
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
                  <h2>POS System Intergration</h2>
               </article>
               <article class="more full checklist">
                  <ul>
                     <li>Payout Reports</li>
                     <li>Cashier Login</li>
                     <li>Manuelly Enter Custom Items</li>
                  </ul>
                  <ul>
                     <li>List of all Inventory</li>
                     <li>Barcode Scanning</li>
                     <li>Close Till, & Open Till Features</li>
                  </ul>
                  <ul>
                     <li>Time Clock</li>
                     <li>Custom Tenders.</li>
                     <li>Tender Reports</li>
                     <li>& more.</li>
                  </ul>
               </article>
            </div>
         </section>
         <hr class="line">
         <!-- Features Slider -->
         <section class="information waves slider-container">
            <div class="container detail">
               <article class="full tag">
                  <h2>Some POS Examples:</h2>
               </article>
            </div>
            @include('site.include.menu')
            <div class="container detail">
               <article class="full">
                  <ul class="tab-controls" id="tabcontrols">
                     <li id="performance"><i></i>Sales List</li>
                     <li id="end-of-day"><i></i>Payout/Drop</li>
                     <li id="reports"><i></i>Store Closing Reports</li>
                  </ul>
               </article>
            </div>
            <div id="slides" class="clearfix">
               <!-- Employee Performance Slide --> 
               <div id="employeeperformance" class="container detail slide">
                  <article class="half"> <img alt="Real-time data" src="{{asset('nucsite/images/posmain2.png')}}" /> </article>
                  <article class="half">
                     <h3>Sales List</h3>
                     <h4>Sales list is a detailed list of your stores sales for the day, or month, or week. You can choose a custom date search, and look up all of your sales. It provides you with the customer’s info, the tender type, status, date paid, and amount. You also have the option to click on the invoice number & it will take you to the checkin/ticket/ or buyback.</h4>
                     <ul>
                        <li>Reprint Receipts</li>
                        <li>Create Custom Invoices</li>
                        <li>Return Sales</li>
                     </ul>
                  </article>
               </div>
               <!-- End of Employee Performance Slide --> <!-- End of Day Slide --> 
               <div id="endofday" class="container detail slide">
                  <article class="half side-hide"> <img alt="Real-time data" src="{{asset('nucsite/images/posmain3.png')}}" /> </article>
                  <article class="half">
                     <h3>Payout/Drop Feature</h3>
                     <h4>The Payout/Drop Feature, was designed for to make simple transactions & money management easier. Example; your window washer, employee's pay, or anything paid out cash, just simply create a payout. Or you have receive cash into the store for a non-repair, or inventory item just create a payout positive and add cash to the store.</h4>
                  </article>
               </div>
               <!-- End of End of Day Slide --> <!-- Product Reports Slide --> 
               <div id="productreports" class="container detail slide">
                  <article class="half side-hide"> <img alt="Real-time data" src="{{asset('nucsite/images/posmain4.png')}}" /> </article>
                  <article class="half">
                     <h3>Store Closing Reports</h3>
                     <h4>Your full detailed store closing report, your way of seeing everything from that day in one simple view. Integrated & designed from the most basic cashier levels, to the highest. Store Closing Report, generates a daily report every day at the end of the day and merges and calculates all your data. Total Collection, Cash Collected, Credit Card Collected, Opening Cash, Opening Credit Card, Payout, BuyBack, Tax, Current Cash, Current Credit Card, Current Total.</h4>
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
                  <h2>POS System Intergration</h2>
                  <h4>Bringing back Simplicity.</h4>
               </article>
            </div>
            <div class="container detail">
               <article id="second-item" class="half">
                  <h2>Create Custom Items</h2>
                  <h3>Need to add an item but don't want to have it saved in your inventory? It’s simple, with the Add Manual Item option, Nucleus allows you to create a manual item to the POS. You have the option to enter the Description, Price, Cost, and Quantity!</h3>
                   
                  <p>Manage your Money.</p>
                  <p>Keep track of your Profit.</p>
               </article>
               <article id="first-item" class="half"> <img alt="Real-time data" src="{{asset('nucsite/images/posmain1.png')}}" /> </article>
            </div>
            <div class="container detail">
               <article class="half"> <img alt="Real-time data" src="{{asset('nucsite/images/posmain6.png')}}" /> </article>
               <article class="half">
                  <h2>Employee Time Clock</h2>
                  <h3>With the cashier punch log feature, your cashier has to punch in and out every day before opening or closing the store. This was created to fully manage your employee’s time. It shows you the Time in, Date in, Date out, & Time out, for every employee. You also see the exact Elapsed time that employee was logged in.</h3>
                   
                  <p>Genius, and simplicity meet.</p>
               </article>
            </div>
            <div class="container detail">
               <article id="fourth-item" class="half" style="margin-top: 20px;">
                  <h2>Tender Report</h2>
                  <h3>With the Tender Report functionality, you can see exactly how much tender was collected to better manage your money. You'll also be provided with the sales ID, so you know which employee collected the tender for each transaction.</h3>
                   
                  <p>Nucleus POS Intergration, is simplicity with power..</p>
                  <p><em>Start today, to see why repair centers Nationwide choose Nucleus!</em></p>
               </article>
               <article id="third-item" class="half"> <img alt="Phones" src="{{asset('nucsite/images/posmain5.png')}}" /> </article>
            </div>
         </section>
         <section class="cta clearfix">
            <div class="small-12 columns clearfix">
               <article class="cta_text small-12 medium-6 columns">
                  <h3>I know it seems unreal, or unnecessary. But trust us, its very real, and very necessary.</h3>
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