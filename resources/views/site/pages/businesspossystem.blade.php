@extends('site.layout.index')
@section('title','Business POS System')
@section('content')
		
	<!-- Business POS System Start -->
	  @if($BusinessPOSSystem->module_status=="Active")
      <section class="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left" id="retail" data-type="anchor">
        <div class="container">
          <div class="row justify-content-md-center align-items-md-center row-55">
            <div class="col-md-6 wow fadeInLeft text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInLeft;">
              <h2>{{$BusinessPOSSystem->heading}}</h2>
              <p class="text-gray">{{$BusinessPOSSystem->detail}}</p>
            </div>
            <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInRight;">
              <figure class="figure-fullwidth"> <img src="{{url('upload/businesspossystem/'.$BusinessPOSSystem->content_image)}}" alt="simpleretailpos" width="620" height="465">
              </figure>
            </div>
          </div>
        </div>
      </section>
      @endif
      <!-- Business POS System ENd -->

      <section class="section wow fadeInUp" id="features" data-type="anchor" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-duration: 1s; animation-delay: 0s; animation-name: fadeInUp;">
        <div class="container w-container w-features">
          <div class="top-wrapper-margin">

            <h2 class="top-title-2">{{$PageSetting->business_pos_core_software_title}}</h2>
            <p class="text-gray">{{$PageSetting->business_pos_core_software_detail}}</p>
            <br>
          </div>
          <div>
            <div class="row">
              @if(count($CoreSoftwareComponents)>0)
                <?php $i=1; ?>
	              @foreach($CoreSoftwareComponents as $row)
                  <?php
                  $sty=''; 
                  if($i==1){ $sty='border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;'; }
                  elseif($i==2){ $sty='border-bottom: 1px solid #ccc;'; }
                  elseif($i==3){ $sty='border-right: 1px solid #ccc;'; }
                  ?>
		              <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="{{$sty}}padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
		                <div class="services-wrapper">
		                  <div>
		                    <img src="{{url('upload/coresoftwarecomponents/'.$row->content_image)}}" alt="simpleretailpos" class="features-icon" width="85">
		                    <div>
		                      <h4 class="features-title">{{$row->sub_title}}
		                        <br>
		                      </h4>
		                      <p class="text-gray">{{$row->content_detail}}</p>
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
      <section class="section bg-gray-light wow fadeInUp" id="features" data-type="anchor" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-duration: 1s; animation-delay: 0s; animation-name: fadeInUp;">
        <div class="container w-container w-features">
          <div class="top-wrapper-margin">

            <h2 class="top-title-2">{{$PageSetting->business_pos_core_hardware_title}}</h2>
            <p class="text-gray">{{$PageSetting->business_pos_core_hardware_detail}}</p>
            <br>
          </div>
          <div>
            <div class="row">
            @if(count($CoreHardwareComponents)>0)
	              @foreach($CoreHardwareComponents as $row)
		              <div class="col-md-6 col-lg-3 col-xl-3 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
		                <div class="services-wrapper">
		                  <div>
		                    <img src="{{url('upload/corehardwarecomponents/'.$row->hardware_image)}}" alt="simpleretailpos" class="features-icon" width="150">
		                    <div>
		                      <h4 class="features-title">{{$row->hardware_title}}
		                        <br>
		                      </h4>
		                      <p class="text-gray">{{$row->hardware_detail}}</p>
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

@endsection

@section('css')

@endsection