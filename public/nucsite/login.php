<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

	<title>Sign In - Nucleus POS</title>

    <link href="css/login.css" rel="stylesheet" type="text/css" media="all" />

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Source+Sans+Pro:400,600&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <meta name="apple-mobile-web-app-capable" content="yes" />

	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

	<!-- Apple Touch Icons -->

	<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />

	<link rel="apple-touch-icon" sizes="57x57" href="images/apple-touch-icon-57x57.png" />

	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png" />

	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png" />

	<link rel="apple-touch-icon" sizes="144x144" href="images/apple-touch-icon-144x144.png" />

	<link rel="apple-touch-icon" sizes="57x57" href="images/apple-touch-icon-60x60.png" />

	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-120x120.png" />

	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-76x76.png" />

	<link rel="apple-touch-icon" sizes="144x144" href="images/apple-touch-icon-152x152.png" />

	<!-- Windows 8 Tile Icons -->

	<meta name="msapplication-square70x70logo" content="images/smalltile.png" />

	<meta name="msapplication-square150x150logo" content="images/mediumtile.png" />

	<meta name="msapplication-wide310x150logo" content="images/widetile.png" />

	<meta name="msapplication-square310x310logo" content="images/largetile.png" />

</head>

<body ontouchstart="">

    <div id="wrapper">

        <div id="content">

            <section id="login">

                <h1>Nucleus Retail</h1>



                <div class="block split">

                    <form method="post">

                        <dl>

                            <dt><label>Email <small>or Username</small></label></dt>

                            <dd><input type="text" name="login" tabindex="1" placeholder="Email or Username" autocorrect="off" autocapitalize="off" autofocus></dd>

                            <dt><label>Password</label></dt>

                        	<dd><input type="password" name="password" tabindex="2" placeholder="Password" autocomplete="off" autocorrect="off" autocapitalize="off"></dd>

                        </dl>



                        <div class="submit">

                            <input id="submitButton" type="submit" class="button large" value="Sign In" tabindex="3">

                            <a id="forgotPassword" href="reset_password.html">Forgot password?</a>

                            <input type="hidden" name="redirect_after_login">

                        </div>

                    </form>



                    <article id="alternates">

                        <p>Alternatively, try using a single sign-on service.</p>

						<button id="googleSignInButton" class="google small"><i class="icon-google-plus"></i> Sign in with Google</button>

                    </article>

                </div>

				<div class="advertising">

					<ol>

						<li class="ipad">

							<a id="lsCloudForIpad" href="http://Nucleusretail.com/cloudforipad" target="_blank">

							<i class="icon-tablet large"></i>

							<h4>Nucleus Retail for iPad</h4>

							<p>Better serve your customers with a streamlined sales experience.</p>

							</a>

						</li>

						<li class="reporting">

							<a id="lsCloudReporting" href="http://www.Nucleusretail.com/cloud/reporting" target="_blank">

							<i class="icon-bar-chart"></i>

							<h4>Nucleus Retail Reporting</h4>

							<p>Make smarter business decisions with new built-in reports.</p>

							</a>

						</li>

					</ol>

				</div>





            </section>



            <p class="explanations">

				<span class="help">Have a question? <a id="visitHelp" href="https://www.Nucleuspos.com/help" target="_blank">Visit Help</a></span>

				<span class="signup">Don't have an account? <a id="signUp" href="signup.php">Sign Up</a></span>

			</p>

        </div>

	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>window.jQuery || document.write('<script src="js/jquery-2.1.1.min.js"><\/script>')</script>



	<script type="text/javascript" src="js/login.js"></script>

	<script>

if(isCordova()) { 

	$.getScript("/dist/assets/js/cordova.js", function() {

		app.initialize();

		lsCloud.cordova.setup();

	});

}

</script>

	<script type="text/javascript">



	$(document).ready(function(){

		

	if(lsCloud.Config.__config['google_analytics_account'] === undefined) {

		lsCloud.Config.set('google_analytics_account', 'UA-215822-12');

		lsCloud.Config.set('google_analytics_account_ls', 'UA-3073346-1');

		lsCloud.Config.set('marketo_analytics_account', '470-XOQ-769');

	}

	

	var ga_account = lsCloud.Config.__config['google_analytics_account'];

	var ga_account_ls = lsCloud.Config.__config['google_analytics_account_ls'];



	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function()

	{ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');



	ga('create', ga_account, 'auto',

		{'cookieDomain' : 'none' });

	ga('create', ga_account_ls, 'auto',

	{'name': 'Nucleusretail'});



	lsCloud.analytics.record(lsCloud.Config.__config);

});



</script>



</body>

