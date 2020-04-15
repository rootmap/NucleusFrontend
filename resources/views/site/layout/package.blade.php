<!DOCTYPE html>
<html class="wide wow-animation" lang=en>
<head>
  <title>Cash Register Software | {{$siteInfo->site_name}}</title>
  <meta name=format-detection content="telephone=no">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-145752783-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-145752783-1');
  </script>

  <script type=application/ld+json>
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
<meta name=google-site-verification content=rNbE4a4Pn8QZHopbu3nbtpcEr_bsNpbf1zXYG7KFdzk>
<meta name=viewport content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta http-equiv=X-UA-Compatible content="IE=edge">
<meta charset=utf-8>
<meta name=description content="Virtual Cash Registers are the heart of your business and we take pride in offering the best and simplest cash registers of them all for your retail needs.">
<meta name=csrf-token content="{{ csrf_token() }}">
<style>
  section.pricing {
  background: #007bff;
  background: linear-gradient(to right, #0062E6, #33AEFF);
}

.pricing .card {
  border: none;
  border-radius: 1rem;
  transition: all 0.2s;
  box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
}

.pricing hr {
  margin: 1.5rem 0;
}

.pricing .card-title {
  margin: 0.5rem 0;
  font-size: 0.9rem;
  letter-spacing: .1rem;
  font-weight: bold;
}

.pricing .card-price {
  font-size: 3rem;
  margin: 0;
}

.pricing .card-price .period {
  font-size: 0.8rem;
}

.pricing ul li {
  margin-bottom: 1rem;
  text-align: left;
}

.pricing .text-muted {
  opacity: 0.9;
  color: #000 !important;

}

.pricing .btn {
  font-size: 80%;
  border-radius: 5rem;
  letter-spacing: .1rem;
  font-weight: bold;
  padding: 1rem;
  opacity: 0.7;
  transition: all 0.2s;
}

/* Hover Effects on Card */

@media (min-width: 992px) {
  .pricing .card:hover {
    margin-top: -.25rem;
    margin-bottom: .25rem;
    box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.3);
  }
  .pricing .card:hover .btn {
    opacity: 1;
  }
}
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
    <style type=text/css>.videoPlayEnroll{background:url('{{url('play/def.png')}}');width:100px;height:98px;display:block}.videoPlayEnroll:hover{background:url('{{url('play/desf.png')}}');width:100px;height:98px;display:block}</style>

    <section class="pricing py-5">
  <div class="container">
    <div class="row">
      <!-- Free Tier -->
<!--       <div class="col-lg-6">
        <div class="card mb-5 mb-lg-0">
          <div class="card-body">
            <h5 class="card-title text-muted text-uppercase text-center">Free</h5>
            <h6 class="card-price text-center">$0<span class="period">/month</span></h6>
            <hr>
            <ul class="fa-ul">
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Single User</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>5GB Storage</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Unlimited Public Projects</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Community Access</li>
              <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Unlimited Private Projects</li>
              <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Dedicated Phone Support</li>
              <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Free Subdomain</li>
              <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Monthly Status Reports</li>
            </ul>
            <a href="#" class="btn btn-block btn-primary text-uppercase">Button</a>
          </div>
        </div>
      </div> -->
      <!-- Plus Tier -->
      <div class="col-lg-6">
        <div class="card mb-5 mb-lg-0">
          <div class="card-body">
            <h5 class="card-title text-muted text-uppercase text-center">Plus</h5>
            <h6 class="card-price text-center">$9<span class="period">/month</span></h6>
            <hr>
            <ul class="fa-ul">
              <li><span class="fa-li"><i class="fas fa-check"></i></span><strong>5 Users</strong></li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>50GB Storage</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Unlimited Public Projects</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Community Access</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Unlimited Private Projects</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Dedicated Phone Support</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Free Subdomain</li>
              <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Monthly Status Reports</li>
            </ul>
            <a href="#" class="btn btn-block btn-primary text-uppercase">Signup</a>
          </div>
        </div>
      </div>
      <!-- Pro Tier -->
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-muted text-uppercase text-center">Pro</h5>
            <h6 class="card-price text-center">$49<span class="period">/month</span></h6>
            <hr>
            <ul class="fa-ul">
              <li><span class="fa-li"><i class="fas fa-check"></i></span><strong>Unlimited Users</strong></li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>150GB Storage</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Unlimited Public Projects</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Community Access</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Unlimited Private Projects</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Dedicated Phone Support</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span><strong>Unlimited</strong> Free Subdomains</li>
              <li><span class="fa-li"><i class="fas fa-check"></i></span>Monthly Status Reports</li>
            </ul>
            <a href="#" class="btn btn-block btn-primary text-uppercase">Signup</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <div class=clearfix></div>



    @include('site.extra.fotter')
  </div>
</div>
<div class=snackbars id=form-output-global></div>
@include('site.include.fotter')

</body>
</html>