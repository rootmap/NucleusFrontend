<!DOCTYPE html>
<html class="wide wow-animation" lang=en>
<head>
  <title>POS System for Retail Store | {{$siteInfo->site_name}}</title>
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
<meta name=description content="Simple Retail POS systems not only provide you the most iconic POS systems for your retail store but also keep track of your business with real-time management.">
<meta name=csrf-token content="{{ csrf_token() }}">
<style>
  @import url(https://fonts.googleapis.com/css?family=Roboto:400,100,300,500);

  .classfour { 
    background-color: #007aff; 
    color: #fff;
    font-size: 100%;
    line-height: 1.5;
    font-family: "Roboto", sans-serif;
    height:600px;
    padding-top:80px;
  }

  .classfour .button {
    font-weight: 300;
    color: #fff;
    font-size: 1.2em;
    text-decoration: none;
    border: 1px solid #efefef;
    padding: .5em;
    border-radius: 3px;
    float: left;
    margin: 6em 0 0 -155px;
    left: 50%;
    position: relative;
    transition: all .3s linear;
  }

  .classfour .button:hover {
    background-color: #007aff;
    color: #fff;
  }

  .classfour p {
    font-size: 2em;
    text-align: center;
    font-weight: 100;
  }

  .classfour h1 {
    text-align: center;
    font-size: 15em;
    font-weight: 100;
    text-shadow: #0062cc 1px 1px, #0062cc 2px 2px, #0062cc 3px 3px, #0062cd 4px 4px, #0062cd 5px 5px, #0062cd 6px 6px, #0062cd 7px 7px, #0062ce 8px 8px, #0063ce 9px 9px, #0063ce 10px 10px, #0063ce 11px 11px, #0063cf 12px 12px, #0063cf 13px 13px, #0063cf 14px 14px, #0063cf 15px 15px, #0063d0 16px 16px, #0064d0 17px 17px, #0064d0 18px 18px, #0064d0 19px 19px, #0064d1 20px 20px, #0064d1 21px 21px, #0064d1 22px 22px, #0064d1 23px 23px, #0064d2 24px 24px, #0065d2 25px 25px, #0065d2 26px 26px, #0065d2 27px 27px, #0065d3 28px 28px, #0065d3 29px 29px, #0065d3 30px 30px, #0065d3 31px 31px, #0065d4 32px 32px, #0065d4 33px 33px, #0066d4 34px 34px, #0066d4 35px 35px, #0066d5 36px 36px, #0066d5 37px 37px, #0066d5 38px 38px, #0066d5 39px 39px, #0066d6 40px 40px, #0066d6 41px 41px, #0067d6 42px 42px, #0067d6 43px 43px, #0067d7 44px 44px, #0067d7 45px 45px, #0067d7 46px 46px, #0067d7 47px 47px, #0067d8 48px 48px, #0067d8 49px 49px, #0068d8 50px 50px, #0068d9 51px 51px, #0068d9 52px 52px, #0068d9 53px 53px, #0068d9 54px 54px, #0068da 55px 55px, #0068da 56px 56px, #0068da 57px 57px, #0068da 58px 58px, #0069db 59px 59px, #0069db 60px 60px, #0069db 61px 61px, #0069db 62px 62px, #0069dc 63px 63px, #0069dc 64px 64px, #0069dc 65px 65px, #0069dc 66px 66px, #006add 67px 67px, #006add 68px 68px, #006add 69px 69px, #006add 70px 70px, #006ade 71px 71px, #006ade 72px 72px, #006ade 73px 73px, #006ade 74px 74px, #006bdf 75px 75px, #006bdf 76px 76px, #006bdf 77px 77px, #006bdf 78px 78px, #006be0 79px 79px, #006be0 80px 80px, #006be0 81px 81px, #006be0 82px 82px, #006be1 83px 83px, #006ce1 84px 84px, #006ce1 85px 85px, #006ce1 86px 86px, #006ce2 87px 87px, #006ce2 88px 88px, #006ce2 89px 89px, #006ce2 90px 90px, #006ce3 91px 91px, #006de3 92px 92px, #006de3 93px 93px, #006de3 94px 94px, #006de4 95px 95px, #006de4 96px 96px, #006de4 97px 97px, #006de4 98px 98px, #006de5 99px 99px, #006ee5 100px 100px, #006ee5 101px 101px, #006ee6 102px 102px, #006ee6 103px 103px, #006ee6 104px 104px, #006ee6 105px 105px, #006ee7 106px 106px, #006ee7 107px 107px, #006ee7 108px 108px, #006fe7 109px 109px, #006fe8 110px 110px, #006fe8 111px 111px, #006fe8 112px 112px, #006fe8 113px 113px, #006fe9 114px 114px, #006fe9 115px 115px, #006fe9 116px 116px, #0070e9 117px 117px, #0070ea 118px 118px, #0070ea 119px 119px, #0070ea 120px 120px, #0070ea 121px 121px, #0070eb 122px 122px, #0070eb 123px 123px, #0070eb 124px 124px, #0071eb 125px 125px, #0071ec 126px 126px, #0071ec 127px 127px, #0071ec 128px 128px, #0071ec 129px 129px, #0071ed 130px 130px, #0071ed 131px 131px, #0071ed 132px 132px, #0071ed 133px 133px, #0072ee 134px 134px, #0072ee 135px 135px, #0072ee 136px 136px, #0072ee 137px 137px, #0072ef 138px 138px, #0072ef 139px 139px, #0072ef 140px 140px, #0072ef 141px 141px, #0073f0 142px 142px, #0073f0 143px 143px, #0073f0 144px 144px, #0073f0 145px 145px, #0073f1 146px 146px, #0073f1 147px 147px, #0073f1 148px 148px, #0073f1 149px 149px, #0074f2 150px 150px, #0074f2 151px 151px, #0074f2 152px 152px, #0074f3 153px 153px, #0074f3 154px 154px, #0074f3 155px 155px, #0074f3 156px 156px, #0074f4 157px 157px, #0074f4 158px 158px, #0075f4 159px 159px, #0075f4 160px 160px, #0075f5 161px 161px, #0075f5 162px 162px, #0075f5 163px 163px, #0075f5 164px 164px, #0075f6 165px 165px, #0075f6 166px 166px, #0076f6 167px 167px, #0076f6 168px 168px, #0076f7 169px 169px, #0076f7 170px 170px, #0076f7 171px 171px, #0076f7 172px 172px, #0076f8 173px 173px, #0076f8 174px 174px, #0077f8 175px 175px, #0077f8 176px 176px, #0077f9 177px 177px, #0077f9 178px 178px, #0077f9 179px 179px, #0077f9 180px 180px, #0077fa 181px 181px, #0077fa 182px 182px, #0077fa 183px 183px, #0078fa 184px 184px, #0078fb 185px 185px, #0078fb 186px 186px, #0078fb 187px 187px, #0078fb 188px 188px, #0078fc 189px 189px, #0078fc 190px 190px, #0078fc 191px 191px, #0079fc 192px 192px, #0079fd 193px 193px, #0079fd 194px 194px, #0079fd 195px 195px, #0079fd 196px 196px, #0079fe 197px 197px, #0079fe 198px 198px, #0079fe 199px 199px, #007aff 200px 200px;
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


    <section class="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left" id="retail" data-type="anchor">
      <div class="container">
        <div class="row justify-content-md-center align-items-md-center row-55">
          <div class="col-md-6 wow fadeInLeft text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInLeft;">
            <h2>Retail Store</h2>
            <p class="text-gray">The employment of an all-inclusive POS system has become necessary these days for the growth of your business. If you are one of those business owners who is trying to hunt down the perfect POS System for your Retail Store, then you’re at the right place. With our Simple Retail POS system, we offer a plethora of features.</p>
          </div>
          <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInRight;">
            <figure class="figure-fullwidth"> <img src="{{url('upload/retail_image/retail-store.png')}}" alt="simpleretailpos" width="620" height="465">
            </figure>
          </div>
        </div>
      </div>
    </section>
    <section class="section wow fadeInUp" id="features" data-type="anchor" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-duration: 1s; animation-delay: 0s; animation-name: fadeInUp;">
      <div class="container w-container w-features">
        <div class="top-wrapper-margin">

          <h2 class="top-title-2">Here are just a few key features amongst many</h2>
          <br>
        </div>
        <div>
          <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
              <div class="services-wrapper">
                <div>
                  <img src="{{url('site/images/keyboard.png')}}" alt="simpleretailpos" class="features-icon" width="85">
                  <div>
                    <h4 class="features-title">Quick Keys
                      <br>
                    </h4>
                    <p class="text-gray">These are the shortcuts in our POS system. Quick keys let you and your employees hit a particular button which is set against a commonly sold or the most popular products. Meanwhile, remaining catalog of items is extremely easy to access. </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="border-bottom: 1px solid #ccc;padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
              <div class="services-wrapper">
                <div>
                  <img src="{{url('site/images/payment-method.png')}}" alt="simpleretailpos" class="features-icon" width="85">
                  <div>
                    <h4 class="features-title">Store Credit, Refunds and Returns Feature
                      <br>
                    </h4>
                    <p class="text-gray">The product return policies of a retail store can play a decisive role in the success of retail business. The biggest reason behind it is that customers have increasingly started to give preference to stores with customer friendly policies. The best thing about our POS system which is particularly developed by considering the necessities of retailers is fully capable of dealing with such challenges. You can devise an ideal policy for refunds and returns with the help of our POS for retail store.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="border-right: 1px solid #ccc;padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
              <div class="services-wrapper">
                <div>
                  <img src="{{url('site/images/debit-card.png')}}" alt="simpleretailpos" class="features-icon" width="85">
                  <div>
                    <h4 class="features-title">
                      We Offer Multiple Methods of Payments
                      <br>
                    </h4>
                    <p class="text-gray">Simple Retail POS is the management system which we have skillfully designed so that its users can go beyond conventional methods of payments, such as credit cards and cash. Our management system conveniently lets you accept mobile payments.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
              <div class="services-wrapper">
                <div>
                  <img src="{{url('site/images/group.png')}}" alt="simpleretailpos" class="features-icon" width="85">
                  <div>
                    <h4 class="features-title">Accessibility to Multiple Users
                      <br>
                    </h4>
                    <p class="text-gray">It is highly likely that you will have several employees who work with your registers, unless you follow a business model that supports a single person operation. In case you do have multiple workers then our POS System for Retail Store is the perfect choice for you since it allows you to make user accounts exclusively for all of your associates. Ultimately with the help of this amazing feature you can set different sales goals for your team since you can easily track all the sales made by each member. Furthermore each account is protected by passwords. It enhances the overall security of the system. </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left" id="retail" data-type="anchor">
      <div class="container">
        <div class="row justify-content-md-center align-items-md-center row-55">
          <div class="col-md-6 wow fadeInLeft text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInLeft;">
            <h2>We Offer 15 Comprehensive Business Management Reports</h2>
            <p class="text-gray">There are multiple reports which can be generated with the help of a management system, such as customer reports, employee reporting and product reports. Our POS for retail store allows you to make all these reports in an effortless way. These customer reports assist you in highlighting your loyal customers. You can further offer retail POS solutions to these customers. </p>
            <p class="text-gray">Similarly, employee reports provide insights regarding top performing workers. Last but not least, Simple Retail POS system formulates reports pertinent to your stocks. This feature helps a lot in exploring the worst and best selling products.</p>
          </div>
          <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInRight;">
            <figure class="figure-fullwidth"> <img src="{{url('upload/retail_image/comprensive-report.png')}}" alt="simpleretailpos" width="620" height="465">
            </figure>
          </div>
        </div>
      </div>
    </section>

    <section class="section  page-footer-corporate  wow fadeInUp" id="features" data-type="anchor" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-duration: 1s; animation-delay: 0s; animation-name: fadeInUp;">
      <div class="container w-container w-features">

        <div>
          <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
              <figure class="figure-fullwidth"> <img src="{{url('upload/retail_image/live-dashboard.png')}}" alt="simpleretailpos" width="620" height="465">
              </figure>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
              <h2 style=" color: #fff;">Live Dashboard </h2>
              <p  style=" color: #fff;">It is recognized as the heart of our POS System for Retail Store. Our Live Dashboard helps in providing a quick glance at overall operations of the store and how it is currently doing. All basic performance indicators are available on the dashboard which augments the overall convenience of the system.</p>

            </div>
          </div>
        </div>
      </div>
    </section>
    <style type=text/css>.details{padding:25px;background:#FFF;min-height:300px;text-align:center;background-image:-webkit-radial-gradient(rgba(248,251,255,0.1) 0,rgba(89,147,255,0.1) 100%);background-image:radial-gradient(rgba(248,251,255,0.1) 0,rgba(89,147,255,0.1) 100%);display:block}@media(min-width:576px){.offset-sm-0{margin-left:0}}::-webkit-input-placeholder{color:white}:-ms-input-placeholder{color:white}::placeholder{color:white}</style>

    <div class=clearfix></div>
    <style type=text/css>.blog{padding-top:80px}.normal-post{-webkit-transition:all .25s ease-in-out 0s;-moz-transition:all .25s ease-in-out 0s;-o-transition:all .25s ease-in-out 0s;transition:all .25s ease-in-out 0s;margin-bottom:30px;overflow:hidden;background:#fff;-webkit-box-shadow:0 3px 25px rgba(2,3,3,0.15);-moz-box-shadow:0 3px 25px rgba(2,3,3,0.15);-o-box-shadow:0 3px 25px rgba(2,3,3,0.15);box-shadow:0 3px 25px rgba(2,3,3,0.15)}.normal-post .entry-header{position:relative}.normal-post .entry-header .post-image{position:relative}.normal-post .entry-content{padding:20px;position:relative}.normal-post .entry-content .entry-post-info{padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #EEE}.normal-post .entry-content .entry-post-info h4{margin:0}.normal-post .entry-content .entry-post-info h4 a{color:#333;text-decoration:none;font-size:16px;font-weight:700;-webkit-transition:all .25s ease-in-out 0s;-moz-transition:all .25s ease-in-out 0s;-o-transition:all .25s ease-in-out 0s;transition:all .25s ease-in-out 0s}.normal-post .entry-content .entry-post-info .posted-on{font-size:14px;margin-bottom:0;color:#FFF;position:absolute;right:25px;top:-50px;height:64px;width:64px;text-align:center;font-weight:bold;text-transform:uppercase;padding:14px 0;line-height:1;-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;-webkit-box-shadow:0 3px 15px rgba(2,3,3,0.25);-moz-box-shadow:0 3px 15px rgba(2,3,3,0.25);-o-box-shadow:0 3px 15px rgba(2,3,3,0.25);box-shadow:0 3px 15px rgba(2,3,3,0.25);background:rgba(139,195,74,0.75)!important;background:-webkit-linear-gradient(-45deg,rgba(139,195,74,1) 0,rgba(68,199,244,1) 100%)!important;background:-o-linear-gradient(-45deg,rgba(139,195,74,1) 0,rgba(68,199,244,1) 100%)!important;background:-moz-linear-gradient(-45deg,rgba(139,195,74,1) 0,rgba(68,199,244,1) 100%)!important;background:linear-gradient(-45deg,rgba(139,195,74,1) 0,rgba(68,199,244,1) 100%)!important}.normal-post .entry-content .entry-post-info .posted-on span{display:block;margin-bottom:7px}.normal-post .entry-content .entry-expert p{font-weight:400;margin-bottom:0;font-size:13px;line-height:24px;color:#777}.normal-post .entry-content .entry-expert .post-readMore{overflow:hidden;padding-top:15px}.normal-post .entry-content .entry-expert .post-readMore a{font-size:13px;text-decoration:none;font-weight:700;color:#999;text-transform:uppercase;-webkit-transition:all .2s ease-in-out 0s;-moz-transition:all .2s ease-in-out 0s;-o-transition:all .2s ease-in-out 0s;transition:all .2s ease-in-out 0s}.normal-post .entry-content .entry-expert .post-readMore a i{margin-left:5px}.normal-post .entry-footer{padding:15px 20px 5px;border-top:1px solid #EEE}.section-space-between-40{padding-bottom:40px!important;padding-top:60px!important}</style>

    <div class=clearfix></div>



    @include('site.extra.fotter')
  </div>
</div>
<div class=snackbars id=form-output-global></div>
@include('site.include.fotter')
<script type=text/javascript src="{{url('site/js/srpac.js')}}"></script>
</body>
</html>