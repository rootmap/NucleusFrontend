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
            <h2>Simple Cash Register</h2>
            <p class="text-gray">As its name signifies, our virtual cash register is a part of our Simple Retail POS system which is based on web. It lets businesses conduct sales transactions from a wide variety of point of sale terminals. With the help of these advanced cash registers you can administer and scrutinize your business activities literally from any part of the globe. All you need is a simple connection of internet at your location.</p>
            <p class="text-gray">With internet based simple cash register you can conduct the POS related transactions effortlessly, simplify the payments through credit card and operate numerous checkouts. The cutting edge technology employed to design these registers let businesspersons like you generate real time and updated sales reports that too with a few simple clicks. No additional software or servers are required for these features. Only log into your account and you are all set to overview all the transactions.</p>
          </div>
          <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInRight;">
            <figure class="figure-fullwidth"> <img src="{{url('upload/retail_image/simpleretailpos-cash-regist.png')}}" alt="simpleretailpos" width="620" height="465">
            </figure>
          </div>
        </div>
      </div>
    </section>
    <section class="section wow fadeInUp" id="features" data-type="anchor" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-duration: 1s; animation-delay: 0s; animation-name: fadeInUp;">
      <div class="container w-container w-features">

        <div>
          <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
              <figure class="figure-fullwidth"> <img src="{{url('upload/retail_image/backup-reports.png')}}" alt="simpleretailpos" width="620" height="465">
              </figure>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
              <h2>Are Any Backups Necessary?</h2>
              <p class="text-gray">While using our custom cash register software there is absolutely no need of backups. You do not have to be worried about anything at all since all the data is stored in the fail-safe cloud system. Our Simple Retail POS management system lets you continue your work wherever you stopped last time. It is 100% secure since all the backups as well as recoveries are done by it. </p>

            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left" id="retail" data-type="anchor">
      <div class="container">
        <div class="row justify-content-md-center align-items-md-center row-55">
          <div class="col-md-6 wow fadeInLeft text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInLeft;">
            <h2>How Does This Software Work?</h2>
            <p class="text-gray">State of the art technology which is available today has basically made it possible to transform devices like Android, iOS, tablet, MAC, and PC into online cash registers. It generally operates online. However, it can be used when you do not have access to internet as well. All the unfinished work can be continued by signing in. When you finally get connected to the internet, the virtual cash register begins to refresh all of your data in a matter of several seconds. </p>
            <p class="text-gray">Another great attribute which is associated with this software is that it is a very economical solution for businesses. In order to begin its utilization, you will not be forced to purchase special new software or POS hardware. Just create an account by following simple steps and you are ready to go. However if you want to integrate simple cash register with any of the optional POS equipment, such as card swipers, barcode scanners, cash drawers or receipt printers then it can also be done without much a do.</p>
          </div>
          <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInRight;">
            <figure class="figure-fullwidth"> <img src="{{url('upload/retail_image/tour-guide-simpleretailpos.png')}}" alt="simpleretailpos" width="620" height="465">
            </figure>
          </div>
        </div>
      </div>
    </section>
    <section class="section page-footer-corporate wow fadeInUp" id="features" data-type="anchor" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-duration: 1s; animation-delay: 0s; animation-name: fadeInUp;">
      <div class="container w-container w-features">

        <div>
          <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
              <figure class="figure-fullwidth"> <img src="{{url('upload/retail_image/simple-cash-register.png')}}" alt="simpleretailpos" width="620" height="465">
              </figure>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
              <h2 style=" color: #fff;">Why Should You Prefer Web Cash Register Offered by Simple Retail POS?</h2>
              <ul style="padding:20px 0px; color: #fff;">
                <li>Web-based cash registers can easily be integrated with multiple other virtual systems.</li>
                <li>Connecting any number of point of sale registers with it is no problem at all.</li>
                <li>Google Analytics can also be integrated with these virtual registers which lets track the financial position of your business.</li>
                <li>You can study the buying behavior of your clientele by storing all the receipts.</li>
                <li>Simple Retail POS lets your customers make use of their personal devices in order to browse various products, and then order or purchase them via this system.</li>
                <li>All of your workers can utilize their personal devices. All you have to do is give them the access to cash register software.</li>
                <li>It keeps on working even if there is no internet access.</li>
              </ul>
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