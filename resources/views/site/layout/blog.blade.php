<!DOCTYPE html>
<html class="wide wow-animation" lang=en>
<head>
	<title>Buy POS System | {{$siteInfo->site_name}}</title>
	<meta name="format-detection" content="telephone=no">
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145752783-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-145752783-1');
	</script>

	<script type="application/ld+json">
		{
			"@context": "https://schema.org/",
			"@type": "WebSite",
			"name": "Simple Retail POS",
			"url": "http://simpleretailpos.com/",
			"potentialAction": {
			"@type": "SearchAction",
			"target": "{search_term_string}",
			"query-input": "required name=search_term_string"
		}
	}
</script>
<meta name="google-site-verification" content="rNbE4a4Pn8QZHopbu3nbtpcEr_bsNpbf1zXYG7KFdzk">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<meta name="description" content="Looking for a truly integrated POS solution for your business? Our Simple Retail POS offers a real-time dashboard with secure payments and other perks. Call us!">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<style>

</style>
@include('site.include.header')
<!--[if lt IE 10]>
<div style="background:#212121;padding:10px 0;box-shadow:3px 3px 5px 0 rgba(0,0,0,.3);clear:both;text-align:center;position:relative;z-index:1"><a href=https://windows.microsoft.com/en-US/internet-explorer/><img src=images/ie8-panel/warning_bar_0000_us.jpg border=0 height=42 width=820 alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
<script src=js/html5shiv.min.js></script>
<![endif]-->
</head>
<body>
	<div class=page>
		@include('site.extra.header')

		<div class=clearfix></div>

		<!-- Blog Start--->

		<!--===| Gallery Us Banner End|===-->

		<!--====| Shuffle Gallery Style Sta rt|====--> 
		<section class="blog">
			<div class="container">
				<div class="col-sm-6 col-md-8 col-lg-8">
					<div class="row">
						@for($i=1; $i<=6; $i++)
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<div class="panel panel-default">
								<div class="">
									<img  src="http://192.168.0.8/digimo/laravel/indian_garden_norrkoping/public/upload/blogs/1583959340.jpg" alt="" class="" style="height: 200px; width: 100%;">
									<div class="panel-body">
										<p class="" style="color: #323232; font-size: 12px; text-align: left;"> <span class="fa fa-user" aria-hidden="true"></span> MD MAHAMUDUR | <span class="fa fa-eye" aria-hidden="true"></span> 50 | <span class="fa fa-calendar" aria-hidden="true"></span> Mar/11/2020</p>
										<p style="font-weight: 600; font-size: 18px; text-align: left; margin-top:3px;">Cold brew coffee</p>
										<p style="margin-top: 3px; text-align: justify;">People, I am feeling it. I am feeling that excitement about spring and green things sprouting from the ground and sunshine warming my back in the mornings and bright a...</p>
										<a style="right: 27px;
    margin-top: -23px; position: absolute;" href="http://192.168.0.8/digimo/laravel/indian_garden_norrkoping/public/blog-details/3/Cold brew coffee" class="blog-clean-btn" style="">Read more...</a>
									</div>

								</div>
							</div>
						</div>
						@endfor

				
						</div>
					</div>

					<div class="col-sm-6 col-md-4 col-lg-4">
						<div class="panel panel-default">
							<div class="panel-body">





								<h4 class="text-center">Popular Posts!</h4>
								<hr  style="margin-top: 15px;" />
								@for($i=1; $i<=6; $i++)
									@if($i>1)
										<hr style="margin-top: 15px;">
									@endif
									<a class="row" style="margin-top: 15px; text-decoration: none; color: #323232;" href="#">
										<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
											<img src="http://192.168.0.8/digimo/laravel/indian_garden_norrkoping/public/upload/blogs/1583959340.jpg" alt="" class="img-thumbnail img-responsive">
										</div>
										<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
											<h5 style="text-align: left; padding-top: 0px;">Cold brew coffee</h5>
											<p style="margin-top: 3px; font-size:11px; text-align: justify;">People, I am feeling it. I am feeling that excitement  that excitement am feeling that</p>
											<p style="text-align: left; margin-top: 3px; "><span class="fa fa-calendar" aria-hidden="true"></span> Mar/11/2020</p>
										</div>
									</a>
								@endfor
								



							</div>
						</div>
					</div>
				</div>
			</section> 

			<!-- Blog ENd ---->


			@include('site.extra.fotter')
		</div>
		<div class=snackbars id=form-output-global></div>
		@include('site.include.fotter')
	</body>
	</html>