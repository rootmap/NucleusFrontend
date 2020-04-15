<?php 
   $sdc = new CoreCustomController();
   $pageInfo=$sdc->SiteSetting();
?>
<!DOCTYPE html>
<html class="wide wow-animation" lang=en>
<head>
  <title>@yield('title') | {{$pageInfo->site_name}}</title>
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
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="AddPaypalLinkActionUrlPartial" content="{{url('initiate/account/paypal')}}">
<meta name="AddPOSContactSubmitUrl" content="{{url('save/contact/query')}}">
<meta name="AddInitiateSingupAcPOSUrl" content="{{url('initiate/signup')}}">
<meta name="addAuthrizePaymentURL" content="{{url('initiate/account/cardpointee')}}">
<meta name="hardware" content="{{url('hardware')}}">
@yield('metatag')
@include('site.include.header')
@yield('css')
</head>
<body>
    @include('site.extra.page-loader')
    <div class="page">
        @include('site.extra.header')
        @yield('content')
        @include('site.extra.fotter')
      </div>
    </div>
    <div class="snackbars" id="form-output-global"></div>
    @include('site.include.fotter')
    
    <script type="text/javascript" src="{{url('site/js/srpac.js')}}"></script>
    @yield('js')
    <script type="text/javascript">
    @if(isset($success_msg))
        showSignupSuccess("{{$success_msg}}");
    @endif 

    @if(isset($error_msg))
        showSignupError("{{$error_msg}}"); 
    @endif
    </script>
    <script>
      $(document).ready(function(){
          $('.page-loader').hide();
      });
    </script>
</body>
</html>