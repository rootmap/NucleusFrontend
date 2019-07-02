<?php

$emailsent = FALSE;

if (isset($_POST['lead_source'])) {


    extract($_POST);

    $EmailSubject = "Contact Query Regarding " . $_POST['about-contact'];

   



    $email_body = '';

    $email_body .='<!DOCTYPE HTML>

    <html lang="en">

        <head>

            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        </head>

        <body>

            <table cellspacing="0" cellpadding="0" width="100%" border="0">

                <tbody>

                    <tr>

                        <td valign="top" align="center">

                            <table cellspacing="0" cellpadding="10" width="800" border="0" bgcolor="#FFFFFF" style="border:1px solid #689F38;">

                                <tbody>

                                    <tr>

                                        <td valign="top" class="ecxfirst" style="text-align: center;">

                                            <a target="_blank" href="http://www.nucleuspos.com/" style="font-size:20px;color:#383838;text-decoration:none;" class="">

                                                <img border="0" style="width: 100px !important;" alt="" src="http://nucleuspos.com/nucleus/pos_image/nucleusfinal.png">

                                            </a>



                                        </td>

                                    </tr>

                                    <tr>

                                        <td valign="top" class="ecxfirst" style="text-align: center;">

                                            <h2 align="center">Contact Query From NucleusPos Contact Form | About - ' . $_POST['about-contact'] . '</h2>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td valign="top">

                                            <table align="center" width="100%">

                                                <tbody>

                                                    

                                                            <tr>

                                                                <td>Contact About </td><td>' . $_POST['about-contact'] . '</td>

                                                            </tr><tr>        

                                                                <td>First Name</td><td>' . $_POST ['first_name'] . '</td>

                                                            </tr><tr>        

                                                                <td>Last Name</td><td>' . $_POST ['last_name'] . '</td> 

                                                            </tr><tr>        

                                                                <td>Email</td><td>' . $_POST ['email'] . '</td>  

                                                            </tr><tr>        

                                                                <td>Phone Number</td><td>' . $_POST ['phone'] . '</td>   

                                                            </tr><tr>        

                                                                <td>Contact-Message</td><td>' . $_POST ['contact-message'] . '</td>    

                                                            </tr>

                                                            

                                                </tbody>

                                            </table>

                                        </td>

                                    </tr>

                                    <tr><td bgcolor="#FFFFFF" align="center" class="ecxlast"><center><p style="font-size:15px;">&copy; <?php echo date("Y"); ?> Nucleuspos.com Ltd. All Rights Reserved</p></center></td></tr>

                </tbody>

            </table>

        </td>

    </tr>



    </tbody>

    </table>

    </body>

    </html>';



//    echo $email_body;

//    exit();



    	$EmailBody = $email_body;

    	$my_name = $_POST ['first_name'];
        $my_mail = $_POST ['email'];
        $my_replyto = "support@neutrix.systems";    
        $my_message = $email_body;

        
        require './phpmail/class.phpmailer.php';
        $mail = new PHPMailer;
        $mail->SMTPDebug = 0;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->CharSet = "iso-8859-1";
        $mail->Host = 'mail.nucleuspos.com';                      // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'backup@nucleuspos.com';                    // SMTP username
        $mail->Password = 'asd123';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        $mail->From = $my_mail;
        $mail->FromName = $my_name;     // Add a recipient
        $mail->addReplyTo('support@neutrix.systems');
        $mail->addBCC('support@neutrix.systems');
        $mail->addBCC('f.bhuyian@gmail.com');
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject =$EmailSubject;
        $mail->Body = $my_message;
        $mail->AltBody = 'Customer Contact Query ';
        //$mail->AddAttachment($file_to_attach, $fileName);
        if (!$mail->send()) {
            $emailsent = FALSE;
        } else {
            $emailsent = TRUE;
        }

}

?>

<html xmlns="http://www.w3.org/1999/xhtml"  xmlns:fb="https://www.facebook.com/2008/fbml"  xmlns:og="http://ogp.me/ns#" dir="ltr" lang="en-US" xml:lang="en-US">

    <head>

        <title>Contact Nucleus POS</title>

        <script src="js/145081786.js"></script>

        <script>

            thesection = "company";

            thecurrentlanguage = "en";

            thePage = "";

        </script>

        <!-- <meta name="viewport" content="initial-scale = 1,maximum-scale=1.0"> -->

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <meta name="language" content="en-us" />

        <meta name="google-site-verification" content="NtATRnLQWL3XVzQf2GNaGr7A9UgrIx6EFgxA_i7Zm7A" />

        <meta name="author" content="Nucleus" />

        <meta name="copyright" content="Copyright Nucleus 2005-2015" />

        <!-- Facebok Meta Tags -->

        <meta property="og:title" content="The Ultimate Retail &amp; Restaurant POS"/>

        <meta property="og:site_name" content="Nucleus" />

        <!-- <meta property="og:url" content="http://www.Nucleuspos.com/"/> -->

        <meta property="og:description" content="We believe that commerce belongs to everyone. To the entrepreneurs who realize their dreams of starting a business; to the storefronts and restaurants that project new perspectives onto our streets; to the communities that are shaped by those businesses." />

        <meta property="og:image" content="http://www.Nucleuspos.com/wp-content/themes/Nucleus/images/front-page/hero-image-homepage-retail.jpg" />

        <!-- Twitter Meta Tags -->

        <meta name="twitter:card" content="summary_large_image">

            <meta name="twitter:title" content="The Ultimate Retail &amp; Restaurant POS">

                <meta name="twitter:description" content="We believe that commerce belongs to everyone. To the entrepreneurs who realize their dreams of starting a business; to the storefronts and restaurants that project new perspectives onto our streets; to the communities that are shaped by those businesses.">

                    <meta name="twitter:creator" content="@Nucleuspos">

                        <meta name="twitter:site" content="@Nucleuspos">

                            <meta name="twitter:image" content="images/hero-image-homepage-retail.jpg">

                                <link rel="profile" href="http://gmpg.org/xfn/11" />

                                <link rel="index" title="Nucleus Retail Point of Sale (POS)" href="#" />

                                <link rel="pingback" href="#" />

                                <link rel="alternate" type="application/rss+xml" title="Nucleus Retail Point of Sale (POS)" href="#" />

                                <link rel="icon" type="image/x-icon" href="images/favicon.ico" />

                                <!-- wp_head Start -->

                                <link rel='stylesheet' id='aboutPage-css'  href='css/about-en.css?ver=1.1' type='text/css' media='screen' />

                                <link rel='stylesheet' id='companyProfile-css'  href='css/company-profile-en.css?ver=1.1' type='text/css' media='screen' />

                                <link rel='stylesheet' id='careersPage-css'  href='css/contact-en.css?ver=1.1' type='text/css' media='screen' />

                                <link rel='stylesheet' id='demo-form-css'  href='css/demo-form.css?ver=3.2' type='text/css' media='all' />

                                <link rel='stylesheet' id='demo-form-page-css'  href='css/demo-form-page.css?ver=3.2' type='text/css' media='all' />

                                <link rel='stylesheet' id='chzn-css'  href='css/chosen.css?ver=3.2' type='text/css' media='all' />

                                <link rel='stylesheet' id='style-css'  href='css/stylec.css?ver=20150106' type='text/css' media='all' />

                                <link rel='stylesheet' id='style-en-css'  href='css/style-en.css?ver=20140210' type='text/css' media='all' />

                                <link rel='stylesheet' id='navigation-css'  href='css/navigation.css?ver=20140506' type='text/css' media='all' />

                                <link rel='stylesheet' id='footer-responsive-css'  href='css/footer-responsive.css?ver=20140527' type='text/css' media='all' />

                                <link rel='stylesheet' id='contact-style-css'  href='css/contact-responsive.css?ver=20140625' type='text/css' media='all' />

                                <link rel='stylesheet' id='foundation-css'  href='css/foundation.css?ver=3.2' type='text/css' media='all' />

                                <link rel='stylesheet' id='googlefont-sspro-css'  href='http://fonts.googleapis.com/css?family=Source+Sans+Pro%3A300%2C400%2C700&#038;ver=3.2' type='text/css' media='all' />

                                <link rel='stylesheet' id='sharedmenu-css'  href='css/sharedmenuc.css?ver=3.2' type='text/css' media='all' />

                                <link rel='stylesheet' id='heroImage-css'  href='css/hero-image.css?ver=3.2' type='text/css' media='all' />

                                <link rel='stylesheet' id='responsify-rebrand-css'  href='css/responsify.rebrandc.css?ver=20141027' type='text/css' media='all' />

                                <link rel='index' title='Nucleus Retail Point of Sale (POS)' href='#' />

                                <meta http-equiv="Content-Language" content="en-US" />

                                <link hreflang="fr" href="#" rel="alternate" />

                                <link hreflang="de" href="#" rel="alternate" />

                                <link hreflang="es" href="#" rel="alternate" />

                                <link hreflang="nl" href="#" rel="alternate" />

                                <script type="text/javascript">

                                    //<![CDATA[

                                    var _wpcf7 = {cached: 1};

                                    //]]>

                                </script>

                                <meta name="description" content="Share your comments, suggestions, and questions about our point of sale systems. Contact us by phone, address, email, fax or web-based contact form today." />

                                <meta name='NextGEN' content='1.8.3' />

                                <link rel='canonical' href='#' />

                                <!-- wp_head End -->

                                <!-- Google Analytics -->

                                <script type='text/javascript'>

                                    var _gaq = _gaq || [];

                                    _gaq.push(['_setAccount', 'UA-3073346-1']);

                                    _gaq.push(['_setSiteSpeedSampleRate', 10]);

                                    _gaq.push(['_trackPageview']);

                                    (function () {

                                        var ga = document.createElement('script');

                                        ga.type = 'text/javascript';

                                        ga.async = true;

                                        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

                                        var s = document.getElementsByTagName('script')[0];

                                        s.parentNode.insertBefore(ga, s);

                                    })();

                                </script>

                                <!-- pingdom -->

                                <script>var _prum = [["id", "52682908abe53d1d3f000000"], ["mark", "firstbyte", (new Date).getTime()]];

                                    (function () {

                                        var s = document.getElementsByTagName("script")[0], p = document.createElement("script");

                                        p.async = "async";

                                        p.src = "//rum-static.pingdom.net/prum.min.js";

                                        s.parentNode.insertBefore(p, s)

                                    })();</script>

                                <!-- Bizible -->

                                <script async type="text/javascript" src="js/_biz-a.js" ></script>

                                <!--[if IE]>

                                        <link rel="stylesheet" media="all" type="text/css" id="ie-fix" href="http://www.Nucleuspos.com/wp-content/themes/Nucleus/css/ie-fix.css" />

                                        <link rel="stylesheet" media="all" type="text/css" id="ie" href="/css/ie.css" />

                                        <script type="text/javascript" src="/js/modernizr.custom.83283.js"></script>

                                <![endif]-->

                                <!--[if lt IE 8]>

                                        <script src="/js/ie/IE8.js"></script>

                                <![endif]-->

                                <!--[if lt IE 9]>

                                        <script src="/js/ie/IE9.js"></script>

                                <![endif]-->

                                <!--[if lt IE 7]>

                                        <script src="/js/ie/IE7.js"></script>

                                <![endif]-->

                                <!--[if lt IE 9]>

                                 <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

                                 <![endif]-->

                                <!--[if IE 7]>

                                <link rel="stylesheet" href="/css/fontello-ie7.css">

                                <![endif]-->

                                <style>

                                </style>

                                </head>

                                <body class="page page-id-9315 page-template page-template-page-company-contact-php page-company-contact" style="-webkit-overflow-scrolling: touch; overflow-y: scroll;">

                                    <div id='sharedmenu--' class=' position-static-top black-text row-full-width hide-for-small'><div class='menu-phone '><h6><span class='phone-icon'></span><span class='number'>248-480-7003</span></h6></div><nav class='clearfix'><ul><li class='main-logo'><a  href="index.php"><img  src='images/logo-red-bl.png' /></a></li><li><a class='active' href='http://nucleuspos.com/nucleus/login.php'>Login</a></li><li class='sharedmenu--langMenu--pushLeft'></div>

                                                    <!-- <div class="below-header-clearing"></div> -->

                                                    <div id="main" class="row-full-width off-canvas-wrap onsite-content" data-offcanvas>

                                                        <div class="inner-wrap hide-for-large-up" style="z-index:999999999999;"><nav class="tab-bar"><section class="left-small"><a class="left-off-canvas-toggle menu-icon" href="#top-mobile-nav"><span></span></a></section><section class="middle tab-bar-section"><h1 class="title"><img src="images/logo-red-wh.png"></h1></section></nav><aside class="left-off-canvas-menu" id="top-mobile-nav"><ul class="off-canvas-list"><li class="back"><a id="exit-slideOver" href="#"><span class="icon-font icon-cancel"></span>Exit Menu</a></li><li class="logo"><a href="/"><label><img src="images/logo-red-wh.png"></label></a></li><li class="has-submenu retail"><a href="#">Retail</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Retail</label></li><li><a href="/retail/">Overview</a></li><li><a href="/retail/pricing/">Pricing</a></li><li><a href=" /customers/">Customers</a></li><li class="has-submenu"><a href="#">Business Types</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Retail &ndash; Business Types</label></li><li><a href="/retail/retail-software/bike-shop-software/">Bike Shop</a></li><li><a href="/retail/retail-software/apparel-pos/">Apparel</a></li><li><a href="/retail/retail-software/pet-store-software/">Pet Store</a></li><li><a href="/retail/retail-software/jewelry-pos-software/">Jewelry Store</a></li><li><a href="/retail/retail-software/sporting-goods-pos/">Sporting Goods</a></li></ul></li><li class="has-submenu"><a href="#">More</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Retail &ndash; More</label></li><li><a href="/retail/pos-system-features/">Features</a></li><li><a href="/retail/reporting/">Reporting</a></li><li><a href="/pos-hardware/">Hardware</a></li><li><a href="/payments/">Payments</a></li><li><a href="/ecommerce-solutions/">Web Store</a></li><li><a href="http://nucleuspos.com/signup.php">Resources</a></li></ul></li><li class="level-two"><a href="/find-a-reseller/">Reseller</a></li><li class="level-two"><a href="/retail/help/">Support</a></li><li class="level-two"><a href="https://cloud.merchantos.com">Login</a></li></ul></li><li class="has-submenu onsite"><a href="#">Retail</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Retail</label></li><li><a href="/onsite/Nucleus-pro-pos-systems/">Overview</a></li><li><a href="/onsite/pricing/">Pricing</a></li><li><a href="/customers/?back">Customers</a></li><li class="has-submenu"><a href="#">More</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Retail &ndash; More</label></li><li><a href="/pos-hardware/">Hardware</a></li><li><a href="/payments/">Payments</a></li><li><a href="/onsite/reporting/">Reporting</a></li><li><a href="/ecommerce-solutions/">Web Store</a></li><li><a href="http://nucleuspos.com/signup.php">Resources</a></li></ul></li><li class="level-two"><a href="/find-a-reseller/">Reseller</a></li><li class="level-two"><a href="/support/">Support</a></li><li class="level-two"><a href="https://my.Nucleusretail.com/">Login</a></li></ul></li><li class="has-submenu resto"><a href="#">Restaurant</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Restaurant</label></li><li><a href="/restaurant/">Overview</a></li><li class="has-submenu"><a href="#">Business Types</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Restaurant &ndash; Business Types</label></li><li><a href="/restaurant/for-solo-business/">Solo Businesses</a></li><li><a href="/restaurant/for-restaurants-brasseries-bars/">Restaurants and Bars</a></li><li><a href="/restaurant/for-takeaway-delivery/">Takeaway Delivery</a></li><li><a href="/restaurant/for-chains-multi-site-businesses/">Chains</a></li><li><a href="/restaurant/for-event-catering/">Events</a></li></ul></li><li><a href="/restaurant/explore-all-features/">Features</a></li><li><a href="/restaurant/pricing/">Pricing</a></li><li><a href="/restaurant/customer-videos/">Customers</a></li><li><a href="/restaurant/integration-partners/">Integrations</a></li><li class="level-two"><a href="/restaurant/our-partners/">Reseller</a></li><li class="level-two"><a href="https://posios.zendesk.com/">Support</a></li><li class="level-two"><a href="/restaurant/login/">Login</a></li></ul></li><li class="has-submenu about-us"><a href="#">About Us</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>About Us</label></li><li><a href="/blog/" >Blog</a></li><li><a href="/press/" >Press</a></li><li><a href="/events/" >Events</a></li><li><a href="/careers/" >Careers</a></li><li><a href="/partners/" >Partners</a></li><li><a href="/contact/" >Contact</a></li></ul></li><li class="has-submenu walkthrough"><a href="#">Live Walkthrough</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Live Walkthrough</label></li><li><a class="retail-geo-link-for-mobile-nav_webinar" href="/webinars/">Retail</a></li><li><a href="/signup-webinar-restaurant/">Restaurant</a></li></ul></li><li><a href="/request-a-quote/">Request a Quote</a></li><li><a href="tel:+8669321801">Call Now &ndash; <span class="number">(248)480-7003</span></a></li><li class="cta has-submenu"><a href="#">Start For Free</a><ul class="left-submenu"><li class="back"><a href="#">Back</a></li><li><label>Start For Free</label></li><li><a class="retail-geo-link-for-mobile-nav_signup geo-link" href="#">Retail</a></li><li><a href="/restaurant/register/">Restaurant</a></li></ul></li></ul></aside><a class="exit-off-canvas"></a></div>

                                                        <div class='sticky'><div id='sharedmenu--subnav--' class='sharedmenu-aboutus top-bar' data-topbar role='navigation'><div class='logo-graphic-only'><a href="/en/" ></a></div><div class='sharedmenu--subnav--innerWrapper container_12'><ul class='sharedmenu--thirdLevel aboutUs-submenu'><li><a class='' href=about.php>About Us</a></li><li><a class='active' href=/contact/>Contact</a></li><li><a class='' href=http://nucleuspos.com>Home Page</a></li></ul></div></div></div>

                                                        <div id="content" class="container_12 form-page clearfix fix-responsive">

                                                            <div class="grid_12-inner clearfix">

                                                                <div class="grid_7" id="form-left">

                                                                    <div class="forms-left-col-content">

                                                                        <div class="grid_5 push_1 alpha omega">

                                                                            <h2>Contact Us</h2>

                                                                            <h4>Get in touch.</h4>

                                                                            <p><strong>Complete the form to get in touch with us</strong></p>

                                                                            <p>Questions, Concerns, Sales, Support.</p>

                                                                            <p class="normal">We are avaliable Monday-Saturday 10AM-7PM Eastern Standerd Time.

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <!-- Right Hand Column / Form -->

                                                                <div class="grid_5 demo-form">

                                                                    <!-- When placeholders do not work, populate with JS -->

                                                                    <!--[if IE]>

                                                                                    <script>

                                                                                    window.onload=function(){ document.getElementById('firstname').value = "First Name"; document.getElementById('lastname').value = "Last Name"; document.getElementById('company').value = "Store Name"; document.getElementById('email').value = "Your Email"; document.getElementById('phone').value = "Your Phone Number"; };

                                                                                    </script>

                                                                    <![endif]-->

                                                                    <!-- The Form -->



                                                                    <div id="demo-form" class="clearfix">

                                                                        <?php if ($emailsent == TRUE) { ?>

                                                                            <div class="alert alert-success alert-dismissible" role="alert">



                                                                                <span style="color: #008200;"><strong>Successfully Sent</strong> | Our Support Team Will Give You a Feedback / contact You Shortly.</span>

                                                                                <hr>

                                                                            </div>

                                                                        <?php } $emailsent = FALSE; ?>

                                                                        <form method="POST" id="theForm" onSubmit="checkTheFormContact()">

                                                                            <input type="hidden" name="lead_source" value="Contact form">

                                                                                <input type="hidden" name="00NG0000009buns" id="00NG0000009buns" value="NA">

                                                                                    <input type="hidden" name="00NG0000009cun5" id="00NG0000009cun5" value="NA">

                                                                                        <input type="hidden" name="00NG0000009bunx" id="00NG0000009bunx" value="NA">

                                                                                            <input type="hidden"  name="00NG000000Bd5gV" id="00NG000000Bd5gV" value="N/A"><!-- Referral Partner -->

                                                                                                <input type="hidden" name="company" value="NA">

                                                                                                    <input type="hidden"  name="oid" value="00DG0000000h9A1">

                                                                                                        <input type="hidden"  name="retURL" value="#">

                                                                                                            <input type="hidden" name="country" id="country" />

                                                                                                            <input type="hidden" name="country-code" id="country-code" />

                                                                                                            <input type="hidden" name="description" id="description" />



                                                                                                            <div id="first-step">

                                                                                                                <div class="form-items50">

                                                                                                                    <input class="form-textbox validate[required]" type="text" name="first_name" id="first_name" placeholder="First Name" />

                                                                                                                    <div class="error-message error-message-top">Please enter your First Name<div class="error-arrow"></div></div>

                                                                                                                </div>

                                                                                                                <div class="form-items50" style="float:right">

                                                                                                                    <input class="form-textbox validate[required]" type="text" name="last_name" id="last_name" placeholder="Last Name" />

                                                                                                                    <div class="error-message error-message-top">Please enter your Last Name<div class="error-arrow"></div></div>

                                                                                                                </div>

                                                                                                                <div class="form-items100">

                                                                                                                    <input type="email" class="form-textbox validate[required, Email]" id="email" name="email" placeholder="Email" />

                                                                                                                    <div class="error-message-left error-email">Please enter your Email<div class="error-arrow"></div></div>

                                                                                                                </div>

                                                                                                                <div class="form-items100">

                                                                                                                    <input class="form-textbox validate[required]" type="tel" name="phone" id="phone" placeholder="Your Phone Number" />

                                                                                                                    <div class="error-message-left">Please enter your Phone Number<div class="error-arrow"></div></div>

                                                                                                                </div>

                                                                                                                <div class="form-items100">

                                                                                                                    <select  id="about-contact" name="about-contact" title="My Message is About" class="form-dropdown">

                                                                                                                        <option value="">My Message is About</option>

                                                                                                                        <option value="Feedback">Feedback</option>

                                                                                                                        <option value="Sales">Sales</option>

                                                                                                                        <option value="Marketing">Marketing</option>

                                                                                                                        <option value="Support">Support</option>

                                                                                                                        <option value="Billing">Billing</option>

                                                                                                                    </select>

                                                                                                                    <div class="error-message-left">Please Choose What Your Message is About<div class="error-arrow"></div></div>

                                                                                                                </div>

                                                                                                                <div class="form-items100">

                                                                                                                    <textarea name="contact-message" id="contact-message" placeholder="Short message relating to your topic." class="textarea-contactform"></textarea>

                                                                                                                    <div class="error-message-left">Please Include a Message<div class="error-arrow"></div></div>

                                                                                                                </div>

                                                                                                                <div class="form-items100">

                                                                                                                    <button type="submit" class="get-started-button" id="formsubmitbutton">Send</button>

                                                                                                                </div>

                                                                                                            </div><!-- First Step -->

                                                                                                            </form>

                                                                                                            </div><!-- demo-form-front --------------------------------->

                                                                                                            <noscript>

                                                                                                                <p class="alert">This form requires Javascript to be enabled.</p>

                                                                                                            </noscript>

                                                                                                            </div><!-- grid_5 demo-form -->

                                                                                                            </div>

                                                                                                            <div style="height:60px"></div>

                                                                                                            <h2 class="tabs"><a class="current" href="#" id="montreal-link">DETROIT<span class="arrow"></span></a></h2>

                                                                                                            <div class="box-b clearfix" style="margin-top: 10px;">

                                                                                                                <!-- Montreal -->

                                                                                                                <div class="tab-1 tab-content">

                                                                                                                    <ul class="contact-info">

                                                                                                                        <li class="clock">Monday–Friday: 10AM-6PM - EST<br />

                                                                                                                            Saturday: 10AM-6PM</li>

                                                                                                                        <li class="phone">248-480-7003 <span>(International)</span><br />

                                                                                                                            248-480-7003 <span>(North America)</span></li>

                                                                                                                        <li class="email"><a href="mailto:justin@neutrix.systems">support@neutrix.systems</a></li>

                                                                                                                        <li class="marker last">1820 E. 11 Mile Rd.,<br />

                                                                                                                            MADISON HEIGHTS, MI 48071<br />

                                                                                                                            USA</li>

                                                                                                                    </ul>

                                                                                                                    <div class="map">

                                                                                                                        <iframe id="montreal-map" width="597" height="373" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2942.05534651506!2d-83.08789568453956!3d42.49037597917836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8824cffb4735417d%3A0xb4b687ad1e04650a!2s1820+E+11+Mile+Rd%2C+Madison+Heights%2C+MI+48071!5e0!3m2!1sen!2sus!4v1467312552807"></iframe>

                                                                                                                    </div>

                                                                                                                </div>

                                                                                                                <div style="height: 80px"></div>

                                                                                                                <!-- Demo Download Bar -->

                                                                                                                <div class="demo-download-strip" style="margin: 0">

                                                                                                                    <div class="small-12 columns small-centered clearfix">

                                                                                                                        <div class="small-12 medium-6 columns text-center">

                                                                                                                            <p>&nbsp;</p>

                                                                                                                        </div>

                                                                                                                        <div class="small-12 medium-4 columns text-center">

                                                                                                                            <a class="get-started-button" href="/select-a-product/" >Start for Free</a>

                                                                                                                        </div>

                                                                                                                    </div>

                                                                                                                </div>

                                                                                                                <!-- Demo Download Bar -->

                                                                                                            </div>

                                                                                                            <div id="sharedfooter">

                                                                                                                <div class="row clearfix">

                                                                                                                    <div class="small-12 medium-5 offset-1 medium-uncentered small-centered columns clearfix footer-section">

                                                                                                                        <div class="date-and-terms">

                                                                                                                            Copyright 2014-2017. Nucleus POS All Rights Reserved.

                                                                                                                            <br class="hide-for-large-up" />

                                                                                                                            <a class='footer-link' href='/privacy-policy/'>Privacy Policy.</a>			</div>

                                                                                                                    </div>

                                                                                                                    <div class="small-12 medium-6 medium-uncentered small-centered columns clearfix footer-section"> </div>

                                                                                                                </div>

                                                                                                            </div>

                                                                                                            <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>

                                                                                                            <script type='text/javascript' src='js/forms.min.js?ver=20131202'></script>

                                                                                                            <script type='text/javascript' src='js/sharedmenu.js?ver=4.5'></script>

                                                                                                            <script type='text/javascript' src='js/combined.js?ver=20150106'></script>

                                                                                                            <script type='text/javascript' src='js/geo.js?ver=20141212'></script>

                                                                                                            <script type='text/javascript' src='js/modernizr.js?ver=3.2'></script>

                                                                                                            <script type='text/javascript' src='js/fastclick.js?ver=3.2'></script>

                                                                                                            <script type='text/javascript' src='js/foundation.min.js?ver=3.2'></script>

                                                                                                            <script type='text/javascript' src='js/foundation.topbar.js?ver=3.2'></script>

                                                                                                            <script type='text/javascript' src='js/foundation.tooltip.js?ver=3.2'></script>

                                                                                                            <script type='text/javascript' src='js/foundation.offcanvas.js?ver=3.2'></script>

                                                                                                            <script type='text/javascript' src='js/initialize.js?ver=3.2'></script>

                                                                                                            <!-- Google Code for Remarketing Tag - Place on all pages-->

                                                                                                            <script type="text/javascript">

                                    /* <![CDATA[ */

                                    var google_conversion_id = 1034915149;

                                    var google_custom_params = window.google_tag_params;

                                    var google_remarketing_only = true;

                                    /* ]]> */

                                                                                                            </script>

                                                                                                            <script type="text/javascript" src="js/conversion.js">

                                                                                                            </script>

                                                                                                            <noscript>

                                                                                                                <div style="display:inline;">

                                                                                                                    <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1034915149/?value=0&amp;guid=ON&amp;script=0"/>

                                                                                                                </div>

                                                                                                            </noscript>

                                                                                                            <!-- End remarketing code -->

                                                                                                            <!-- AddRoll -->

                                                                                                            <script type="text/javascript">

                                                                                                                adroll_adv_id = "4TNTE4JYIJG23MCRRGQ7MM";

                                                                                                                adroll_pix_id = "RTCINKKEXNC5FFPEQIHEVT";

                                                                                                                (function () {

                                                                                                                    var oldonload = window.onload;

                                                                                                                    window.onload = function () {

                                                                                                                        __adroll_loaded = true;

                                                                                                                        var scr = document.createElement("script");

                                                                                                                        var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");

                                                                                                                        scr.setAttribute('async', 'true');

                                                                                                                        scr.type = "text/javascript";

                                                                                                                        scr.src = host + "/j/roundtrip.js";

                                                                                                                        ((document.getElementsByTagName('head') || [null])[0] ||

                                                                                                                                document.getElementsByTagName('script')[0].parentNode).appendChild(scr);

                                                                                                                        if (oldonload) {

                                                                                                                            oldonload()

                                                                                                                        }

                                                                                                                    };

                                                                                                                }());

                                                                                                            </script>

                                                                                                            <!-- Marketo Munchkin -->

                                                                                                            <script type="text/javascript">

                                                                                                                $.ajax({

                                                                                                                    url: '//munchkin.marketo.net/munchkin.js',

                                                                                                                    dataType: 'script',

                                                                                                                    cache: true,

                                                                                                                    success: function () {

                                                                                                                        Munchkin.init('470-XOQ-769');

                                                                                                                    }

                                                                                                                });

                                                                                                            </script>

                                                                                                            <!-- END Marketo Munchkin -->

                                                                                                            <!-- START Twitter code  ==========================   -->

                                                                                                            <script src="js/oct.js" type="text/javascript"></script>

                                                                                                            <script type="text/javascript">

                                                                                                                twttr.conversion.trackPid('l4hry');

                                                                                                            </script>

                                                                                                            <noscript>

                                                                                                                <img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=l4hry&p_id=Twitter" />

                                                                                                                <img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=l4hry&p_id=Twitter" />

                                                                                                            </noscript>

                                                                                                            <!-- END Twitter code  ==========================   -->

                                                                                                            <script type="text/javascript">

                                                                                                                var LANG = "en";

                                                                                                            </script>

                                                                                                            </body>

                                                                                                            </html>

                                                                                                            <script type="text/javascript">

                                                                                                                $(function () {

                                                                                                                    $('#message').keyup(function () {

                                                                                                                        if ($(this).val().length > 750) {

                                                                                                                            $(this).val($(this).val().substr(0, 750));

                                                                                                                        }

                                                                                                                    });

                                                                                                                });

                                                                                                            </script>

                                                                                                            <!-- Fix the Google Map Pin not being centered - refresh the src -->

                                                                                                            <script>

                                                                                                                $(document).ready(function () {

                                                                                                                    $("#ottawa-link").click(function () {

                                                                                                                        $('#ottawa-map').attr('src', function (i, val) {

                                                                                                                            return val;

                                                                                                                        });

                                                                                                                    });

                                                                                                                    $("#montreal-link").click(function () {

                                                                                                                        $('#montreal-map').attr('src', function (i, val) {

                                                                                                                            return val;

                                                                                                                        });

                                                                                                                    });

                                                                                                                    $("#nyc-link").click(function () {

                                                                                                                        $('#nyc-map').attr('src', function (i, val) {

                                                                                                                            return val;

                                                                                                                        });

                                                                                                                    });

                                                                                                                    $("#olympia-link").click(function () {

                                                                                                                        $('#olympia-map').attr('src', function (i, val) {

                                                                                                                            return val;

                                                                                                                        });

                                                                                                                    });

                                                                                                                    $("#silicon-valley-link").click(function () {

                                                                                                                        $('#silicon-valley-map').attr('src', function (i, val) {

                                                                                                                            return val;

                                                                                                                        });

                                                                                                                    });

                                                                                                                    $("#ghent-link").click(function () {

                                                                                                                        $('#ghent-map').attr('src', function (i, val) {

                                                                                                                            return val;

                                                                                                                        });

                                                                                                                    });

                                                                                                                });

                                                                                                            </script>