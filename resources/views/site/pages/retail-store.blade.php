@extends('site.layout.index')
@section('title','Retail Store')
@section('content')
  

	@if($RetailStore->module_status=="Active")
  	<section class="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left" id="retail" data-type="anchor">
      <div class="container">
        <div class="row justify-content-md-center align-items-md-center row-55">
          <div class="col-md-6 wow fadeInLeft text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInLeft;">
            <h2>{{$RetailStore->heading}}</h2>
            <p class="text-gray">{{$RetailStore->detail}}</p>
          </div>
          <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInRight;">
            <figure class="figure-fullwidth"> <img src="{{url('upload/retailstore/'.$RetailStore->content_image)}}" alt="simpleretailpos" width="620" height="465">
            </figure>
          </div>
        </div>
      </div>
    </section>
    @endif


    <section class="section wow fadeInUp" id="features" data-type="anchor" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-duration: 1s; animation-delay: 0s; animation-name: fadeInUp;">
      <div class="container w-container w-features">
        <div class="top-wrapper-margin">

          <h2 class="top-title-2">{{$PageSetting->retail_store_key_feature_title}}</h2>
          <br>
        </div>
        <div>
          <div class="row">
          	@if(count($KeyFeature)>0)
          		<?php $i=1; ?>
	          	@foreach($KeyFeature as $row)
	          		<?php
	          		$sty=''; 
	          		if($i==1){ $sty='border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;'; }
	          		elseif($i==2){ $sty='border-bottom: 1px solid #ccc;'; }
	          		elseif($i==3){ $sty='border-right: 1px solid #ccc;'; }
	          		?>
		            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="{{$sty}} padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
		              <div class="services-wrapper">
		                <div>
		                  <img src="{{url('upload/keyfeature/'.$row->content_image)}}" alt="simpleretailpos" class="features-icon" width="85">
		                  <div>
		                    <h4 class="features-title"> {{$row->content_title}}
		                      <br>
		                    </h4>
		                    <p class="text-gray">{{$row->content_detail}} </p>
		                  </div>
		                </div>
		              </div>
		            </div>
		            <?php $i++; ?>
	            @endforeach
            @endif
            
          </div>
        </div>
      </div>
    </section>


    @if(isset($OtherFeature))  
    @foreach($OtherFeature as $row)
      <?php
      //section page-footer-corporate wow fadeInUp
       $classNames="section wow fadeInUp";    
      if($row->section_foreground_color=="Ash")
      {   
      	$classNames="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left"; 
      }
      ?>
    	<section class="{{$classNames}}" id="retail" data-type="anchor">
          <div class="container">
            <div class="row justify-content-md-center align-items-md-center row-55">
              @if($row->image_position=="Left")
              <div class="col-md-6 wow fadeInLeft text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInLeft;">
                <h2>{{$row->heading}}</h2>
                <p class="text-gray">{{$row->details}}</p>
              </div>
              <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInRight;">
                <figure class="figure-fullwidth"> <img src="{{url('upload/otherfeature/'.$row->content_image)}}" alt="simpleretailpos" width="620" height="465">
                </figure>
              </div>
              @else
              <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
                <figure class="figure-fullwidth"> <img src="{{url('upload/otherfeature/'.$row->content_image)}}" alt="simpleretailpos" width="620" height="465">
                </figure>
              </div>
              <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
                <h2>{{$row->heading}}</h2>
                <p class="text-gray">{{$row->details}}</p>

              </div>
              @endif

            </div>
          </div>
      </section>
    @endforeach
  @endif
    <!-- <section class="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left" id="retail" data-type="anchor">
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
    </section> -->
		

@endsection

@section('css')

@endsection