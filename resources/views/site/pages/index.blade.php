@extends('site.layout.index')
@section('title','Simple Retail POS')
@section('content')

<?php 
   $sdc = new CoreCustomController();
   $pageInfo=$sdc->SiteSetting();
?>

	<!-- Top Slider Start -->
	<style type="text/css">.videoPlayEnroll{background:url('{{url('play/def.png')}}');width:100px;height:98px;display:block}.videoPlayEnroll:hover{background:url('{{url('play/desf.png')}}');width:100px;height:98px;display:block}</style>
    <section class="section">
      <div class="swiper-bg-wrap swiper-style-2">
        <div class="swiper-container swiper-bg swiper-height-1" data-autoplay="6500" data-direction="vertical">
          <div class="swiper-wrapper">
            <div class="swiper-slide" style="background:url('{{url('upload/slider/'.$slider->slider_image)}}')">
              <div class="swiper-slide-caption">
                <div class="jumbotron-custom jumbotron-custom-variant-1 context-dark">
                  {{-- <h1 data-caption-animate="fxRotateInRight" data-caption-delay="150">{{$slider->title}}</h1>
                  <p class="subtitle-variant-3" data-caption-animate="fxRotateInLeft" data-caption-delay="350">{{$slider->sub_title}}</p> --}}
                  <a class="btn btn-square btn-round ir video videoPlayEnroll" data-caption-animate="fxRotateInRight" data-caption-delay="550" href="{{$slider->slider_video_link}}" style="border:0px;"><span class="" style="width:100px;height:98px"></span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </section>
	<!-- Top Slider Stop -->

	<!-- Feature Start -->
    <section class="section wow fadeInUp" id="features" data-type="anchor" data-wow-duration="1s" data-wow-delay="0s" style="visibility:visible;animation-duration:1s;animation-delay:0s;animation-name:fadeInUp;">
      <div class="container w-container w-features">
        <div class="top-wrapper-margin">
          <div class="top-wrapper">
            <h2 class="top-title-2">{{$PageSetting->home_feature_title}}</h2>
          </div>
        </div>
        <div>
          <div class="row">
            @if(count($feature))
            @foreach($feature as $sli)
            <div class="col-md-6 col-lg-3 col-xl-3 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility:visible;animation-duration:1s;animation-delay:.1s">
              <div class="services-wrapper">
                <div>
                  <img src="{{url('upload/features/'.$sli->feature_image)}}" width="85" alt="simpleretailpos" class="features-icon">
                  <div>
                    <h4 class="features-title">
                      {{$sli->feature_name}}
                      <br>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
            @endif
          </div>
        </div>
      </div>
    </section>
    <div class="clearfix"></div>
	<!-- Feature Stop -->

	<!-- Intregated Solutions Start-->
	<style type="text/css">.blog{padding-top:80px}.normal-post{-webkit-transition:all .25s ease-in-out 0s;-moz-transition:all .25s ease-in-out 0s;-o-transition:all .25s ease-in-out 0s;transition:all .25s ease-in-out 0s;margin-bottom:30px;overflow:hidden;background:#fff;-webkit-box-shadow:0 3px 25px rgba(2,3,3,0.15);-moz-box-shadow:0 3px 25px rgba(2,3,3,0.15);-o-box-shadow:0 3px 25px rgba(2,3,3,0.15);box-shadow:0 3px 25px rgba(2,3,3,0.15)}.normal-post .entry-header{position:relative}.normal-post .entry-header .post-image{position:relative}.normal-post .entry-content{padding:20px;position:relative}.normal-post .entry-content .entry-post-info{padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #EEE}.normal-post .entry-content .entry-post-info h4{margin:0}.normal-post .entry-content .entry-post-info h4 a{color:#333;text-decoration:none;font-size:16px;font-weight:700;-webkit-transition:all .25s ease-in-out 0s;-moz-transition:all .25s ease-in-out 0s;-o-transition:all .25s ease-in-out 0s;transition:all .25s ease-in-out 0s}.normal-post .entry-content .entry-post-info .posted-on{font-size:14px;margin-bottom:0;color:#FFF;position:absolute;right:25px;top:-50px;height:64px;width:64px;text-align:center;font-weight:bold;text-transform:uppercase;padding:14px 0;line-height:1;-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;-webkit-box-shadow:0 3px 15px rgba(2,3,3,0.25);-moz-box-shadow:0 3px 15px rgba(2,3,3,0.25);-o-box-shadow:0 3px 15px rgba(2,3,3,0.25);box-shadow:0 3px 15px rgba(2,3,3,0.25);background:rgba(139,195,74,0.75)!important;background:-webkit-linear-gradient(-45deg,rgba(139,195,74,1) 0,rgba(68,199,244,1) 100%)!important;background:-o-linear-gradient(-45deg,rgba(139,195,74,1) 0,rgba(68,199,244,1) 100%)!important;background:-moz-linear-gradient(-45deg,rgba(139,195,74,1) 0,rgba(68,199,244,1) 100%)!important;background:linear-gradient(-45deg,rgba(139,195,74,1) 0,rgba(68,199,244,1) 100%)!important}.normal-post .entry-content .entry-post-info .posted-on span{display:block;margin-bottom:7px}.normal-post .entry-content .entry-expert p{font-weight:400;margin-bottom:0;font-size:13px;line-height:24px;color:#777}.normal-post .entry-content .entry-expert .post-readMore{overflow:hidden;padding-top:15px}.normal-post .entry-content .entry-expert .post-readMore a{font-size:13px;text-decoration:none;font-weight:700;color:#999;text-transform:uppercase;-webkit-transition:all .2s ease-in-out 0s;-moz-transition:all .2s ease-in-out 0s;-o-transition:all .2s ease-in-out 0s;transition:all .2s ease-in-out 0s}.normal-post .entry-content .entry-expert .post-readMore a i{margin-left:5px}.normal-post .entry-footer{padding:15px 20px 5px;border-top:1px solid #EEE}.section-space-between-40{padding-bottom:40px!important;padding-top:60px!important}</style>
	    <section class="section report-header section-bg-img" id="intregtedSolutions" style="padding: 0px;">

	      <div class="row"  style="visibility:visible;animation-duration:1s;animation-delay:.1s;animation-name:fadeInRight;background-color:rgba(255,255,255,0.8);box-shadow:0 20px 50px -20px rgba(0,0,0,.5); margin-top: 0px; ">

	      <div class="container w-container w-features">
	        <div class="top-wrapper-margin">

	          <h2 class="top-title-2">{{$PageSetting->home_intragted_solution}}</h2>
	          <br>
	        </div>
	        <div>
	          <div class="row">

	          	@if(isset($IntragtedSolutions))
		          	@foreach($IntragtedSolutions as $row)
			            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
			              <div class="services-wrapper">
			                <div>
			                  <img src="{{url('upload/intragtedsolutions/'.$row->company_logo)}}" alt="{{ $row->company_logo }}" class="features-icon" width="120">
			                  <div>
			                    <h4 class="features-title"> {{ $row->sub_title }} 
			                      <br>
			                    </h4>
			                    <p class="text-gray">{{ $row->detail }} </p>
			                  </div>
			                </div>
			              </div>
			            </div>
		            @endforeach
	            @endif

	            
	          </div>
	        </div>
	      </div>

	    </div>

	<div class="clearfix"></div>
	</section>
	<div class="clearfix"></div>
	<!-- Inregated Solution End-->

	<!-- Videos Start -->
    <style type=text/css>
      .video-container {
      position: relative;
      padding-bottom: 56.25%;
      padding-top: 30px; height: 0; overflow: hidden;
      }
      
      .video-container iframe,
      .video-container object,
      .video-container embed {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      }
    </style>

    <div class="clearfix"></div>        

    <section class="section section-bg-img text-center text-md-left  bg-gray-dark" id="videos" data-type=anchor style>
      <div class="video-container"><iframe width="853" height="480" src="{{$videos->video_link}}" frameborder="0" allowfullscreen></iframe></div>
    </section>
	<!-- Videos End -->
	<!-- Videos Start -->
    <style type=text/css>.details{padding:25px;background:#FFF;min-height:300px;text-align:center;background-image:-webkit-radial-gradient(rgba(248,251,255,0.1) 0,rgba(89,147,255,0.1) 100%);background-image:radial-gradient(rgba(248,251,255,0.1) 0,rgba(89,147,255,0.1) 100%);display:block}@media(min-width:576px){.offset-sm-0{margin-left:0}}::-webkit-input-placeholder{color:white}:-ms-input-placeholder{color:white}::placeholder{color:white}</style>

    <div class="clearfix"></div>        

  {{--   <section class="section section-bg-img text-center text-md-left  bg-gray-dark" id="videos" data-type=anchor style>
      <div class="container" style="margin-top: 0px; padding-bottom:50px;  clear: both; display: block;">

                <div class="pricing-title col-md-12" style="color: #fff; font-size: 32px; text-align: center; padding-top:80px; padding-bottom:60px;">{{$videos->heading}}</div>
                <div class="row justify-content-md-center flex-md-row-reverse align-items-md-center row-55" style="margin-top: 0px;">

                  <div class="swiper-slide" style="background:url('{{url('upload/videos/'.$videos->video_image)}}'); background-size: cover;">
                      <div class="swiper-slide-caption">
                        <div class="jumbotron-custom jumbotron-custom-variant-1 context-dark"  style="min-height: 500px;">
                          <a class="btn btn-square btn-round ir video videoPlayEnroll" data-caption-animate="fxRotateInRight" data-caption-delay="550" href="{{$videos->video_link}}" style="border:0px;"><span class="" style="width:100px;height:98px"></span></a>
                        </div>
                      </div>
                      <div class="clearfix"></div>        
                  </div>
                </div>

        
        
      </div>
      <div class="clearfix"></div>        
    </section> --}}
	<!-- Videos End -->

	<!-- Join Simplicity Start -->
    @if(isset($JoinSimplicity) && !empty($JoinSimplicity))
    <div class="clearfix"></div>        
    <section class="section dummyproof-header section-bg-img text-center text-md-left" id="join" data-type=anchor style>
      <div class=container>
        <div class="row justify-content-md-center flex-md-row-reverse align-items-md-center row-55">
          <div class="col-md-5 testimonials-wrapper wow fadeInLeft" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s>
            <h4>{{$JoinSimplicity->heading}}</h4>
            <p class=text-gray style=padding-bottom:40px>{{$JoinSimplicity->detail}}</p>
          </div>
          <div class="col-md-7 wow fadeInRight" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s>
            <figure class=figure-fullwidth> <img src="{{url('upload/joinsimplicity/'.$JoinSimplicity->content_image)}}" alt=simpleretailpos width=620 height="465"/>
            </figure>
          </div>
        </div>
      </div>
    </section>
    @endif
	<!-- Join Simplicity End -->

	<!-- Signup Start -->
	<footer  class="section page-footer-corporate object-wrap object-wrap-md-left object-wrap-map bg-gray-dark" id=signup data-type="anchor" style="padding-bottom:20px;min-height:680px; border-bottom: 1px #ccc solid;">
      <div class="object-wrap-body details object-wrap-map sizing-1 wow fadeInLeft" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s;padding-bottom:20px>
        <div class="details col-md-12" style=padding-bottom:20px;padding-top:70px>
          <div class="active wow fadeInUp" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s>
            <div class=pricing-title><h3 style="color: #000;">{{$priceYearly->title}}</h3></div>
            <div class=price-wrap><span style="font-size: 16px;" class=price>{{$priceYearly->price}}/{{$priceYearly->subscription_type}}</span></div>
            <ul class="pricing-list-marked pricing-list-marked__mod-2">
              @if(strlen($priceYearly->feature_detail)>0)
              <?php

              $fet=json_decode($priceYearly->feature_detail);
              $fetCount=count($fet); 
              ?>
              @foreach($fet as $tt)
              <li><span>{{$tt->name}}</span></li>
              @endforeach
              @endif
            </ul><a class="btn btn-square btn-primary btn-lg" href="javascript:sendContactQueryByPrice('{{$priceYearly->id}}')">Buy now</a>
          </div>
        </div>
      </div>
      <div class=container>
        <div class="row justify-content-md-end wow fadeInRight" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s>
          <div class="col-lg-6 col-xl-7">
            <div class=page-footer-corporate-inner>
              <div class=page-footer-corporate-top style=padding-top:50px!important;padding-bottom:50px!important>
                <h4>Signup Now <br> &amp; <br> Get Your Store Up To Date</h4>
                <form class=rd-mailform method=post action=javascript:void(0);>
                  <div class="row align-items-md-end row-20">
                    <div class="col-md-12" id="showSignupConSMS">
                    </div>
                    <div class=col-md-6>
                      <div class=form-wrap>
                        <input class=form-input placeholder="Full Name" id=footer-signup-name type=text name=name data-constraints=@Required>
                      </div>
                    </div>
                    <div class=col-md-6>
                      <div class=form-wrap>
                        <input class=form-input placeholder="Company / Store Name" id=footer-signup-company_name type=text name=company_name data-constraints=@Required>
                      </div>
                    </div>
                    <div class=col-md-6>
                      <div class=form-wrap>
                        <input class=form-input placeholder="Email Address" id=footer-signup-email type=email name=email data-constraints="@Email @Required">
                      </div>
                    </div>
                    <div class=col-md-6>
                      <div class=form-wrap>
                        <input class=form-input placeholder=Password id=footer-signup-password type=password name=password data-constraints=@Required>
                      </div>
                    </div>
                    <div class=col-md-12>
                      <div class=form-wrap>
                        <input class=form-input placeholder=Address id=footer-signup-address type=text name=address data-constraints=@Required>
                      </div>
                    </div>
                    <div class="col-md-6" id="CardBoxCard">
                      <div class=form-wrap>
                        <input class=form-input placeholder=Phone id=footer-signup-phone type=text name=phone data-constraints=@Numeric>
                      </div>
                    </div>
                    <div class=col-md-6>
                      <div class=form-wrap>
                        <select class=form-input id=footer-signup-package name=package>
                          <option value=0>Please Select a Package</option>
                          @if(count($allPackage)>0)
                          @foreach($allPackage as $rr)
                          <option value="{{$rr->id}}">{{$rr->title}}-${{$rr->price}}</option>
                          @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12 cardprActive" style="display:none">
                      <h5>
                        Please provide Your Card Detail
                      </h5>
                    </div>
                    <div class="col-md-12 cardprActive" id="showCardConSMS"></div>
                    <div class="col-md-6 cardprActive" style="display:none">
                      <div class=form-wrap>
                        <input class=form-input placeholder="Card Number" id=footer-card-no type=text name=cardno data-constraints=@Required>
                      </div>
                    </div>
                    <div class="col-md-6 cardprActive" style=display:none>
                      <div class=form-wrap>
                        <code id=cardTypeHTML style="color:#09f;font-size:15px;line-height:49px;padding:13px 20px;font-family:monospace">Visa/AMEX/MasterCard/Discover</code>
                      </div>
                    </div>
                    <div class="col-md-12 cardprActive" style=display:none>
                      <div class=form-wrap>
                        <input class=form-input placeholder="Card Holder Name" id=footer-card-holdername type=text name=cardholdername data-constraints=@Required>
                      </div>
                    </div>

                    <div class="col-md-3 cardprActive" style="display:none">
                      <div class=form-wrap>
                        <select class="form-input" id="footer-card-month">
                            <option value="">Select Month</option>
                            @for($i=1; $i<=12; $i++)
                                <option value="{{strlen($i)==2?$i:'0'.$i}}">{{strlen($i)==2?$i:'0'.$i}}</option>
                            @endfor
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3 cardprActive" style="display:none">
                      <div class=form-wrap>
                        <select class="form-input" id="footer-card-year">
                            <option value="">Select Year</option>
                            @for($i=date('Y'); $i<=date('Y')+10; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                      </div>
                    </div>

                    <div class="col-md-6 cardprActive" style=display:none>
                      <div class=form-wrap>
                        <input class=form-input placeholder="Card Pin Number" id=footer-card-pin type=password name=cardpin data-constraints=@Required>
                      </div>
                    </div>
                    <div class="col-md-12 paypal_button">
                      <button class="btn btn-primary btn-block btn-effect-ujarak card_payment" type=button><i class="fa fa-credit-card"></i> Pay with Card</button>
                    </div>
                    <div class="col-md-6 cardprActive" style=display:none>
                      <button class="btn btn-danger btn-block btn-effect-ujarak exit_card_payment" type=button><i class="fa fa-times"></i> Exit Card Payment</button>
                    </div>
                    <div class="col-md-6 cardprActive" style=display:none>
                      <button class="btn btn-info btn-block btn-effect-ujarak proced_card_payment" type=button><i class="fa fa-credit-card"></i> Proced Card Payment</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
	<!-- Signup End -->

	<!-- Contactus Form Start -->
	<footer class="section page-footer-corporate object-wrap object-wrap-md-left object-wrap-map bg-gray-dark" id=contactus data-type=anchor>
      <div class=container>
        <div class="row justify-content-md-end wow fadeInRight" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s>
          <div class="col-lg-6 col-xl-6">
            <div class=page-footer-corporate-inner>
              <div class=page-footer-corporate-top>
                <h3>Contacts</h3>
                <div class=contacts-list style=margin-top:50px>

                  <dl class="terms-list-uppercase terms-list-uppercase-2">
                    <dt>Phone</dt>
                    <dd><a class="link link-md" href=tel:248-480-7003>{{$pageInfo->phone}}</a></dd>
                  </dl>
                  <dl class="terms-list-uppercase terms-list-uppercase-2">
                    <dt>e-mail</dt>
                    <dd><a class=link href="mailto:{{$pageInfo->email}}"><span>{{$pageInfo->email}}</span></a></dd>
                  </dl>
                </div>
                <hr class=gray>
                <div class=page-footer-corporate-bottom>
                  <ul class=inline-list-xxs style=margin-left:auto;margin-right:auto>
                    <li><a class="icon novi-icon icon-xs icon-circle icon-mako fa fa-instagram" target="_blank" href="{{$pageInfo->instagram_link}}"></a></li>
                    <li><a class="icon novi-icon icon-xs icon-circle icon-mako fa fa-facebook" target="_blank"  href="{{$pageInfo->facebook_link}}"></a></li>
                    <li><a class="icon novi-icon icon-xs icon-circle icon-mako fa fa-youtube" target="_blank"  href="{{$pageInfo->youtube_link}}"></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-6">
            <div class=page-footer-corporate-inner>
              <div class=page-footer-corporate-top>
                <h3>Get in Touch</h3>
                <form class="rd-mailform" method="post" onsubmit="submitContactQuery()">
                  <div class="row align-items-md-end row-20">
                    <div class=col-md-12 id=showConSMS>
                    </div>
                    <div class=col-md-6>
                      <div class=form-wrap>
                        <input class=form-input id=footer-contact-first-name type=text name=name data-constraints=@Required>
                        <label class=form-label for=footer-contact-first-name>Your Name</label>
                      </div>
                    </div>
                    <div class=col-md-6>
                      <div class=form-wrap>
                        <input class=form-input id=footer-contact-last-name type=text name=phone data-constraints=@Numeric>
                        <label class=form-label for=footer-contact-last-name>Phone</label>
                      </div>
                    </div>
                    <div class=col-sm-12>
                      <div class=form-wrap>
                        <textarea style="height: 50px;" class=form-input id=footer-contact-message name=message data-constraints=@Required></textarea>
                        <label class=form-label for=footer-contact-message>Your Message</label>
                      </div>
                    </div>
                    <div class=col-md-6>
                      <div class=form-wrap>
                        <input class=form-input id=footer-contact-email type=email name=email data-constraints="@Email @Required">
                        <label class=form-label for=footer-contact-email>E-mail</label>
                      </div>
                    </div>
                    <div class=col-md-6>
                      <button class="btn btn-primary btn-block btn-effect-ujarak" type=submit>send message</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
	<!-- Contactus Form End-->

@endsection

@section('js')
  @if(Session::has('package_id'))
  <script type="text/javascript">
      //alert('1');
      $('a[href=#signup]').click();
      <?php 
      $PackageID=Session::get('package_id');
      ?>
      sendContactQueryByPrice("{{$PackageID}}");
  </script>
  @endif
@endsection