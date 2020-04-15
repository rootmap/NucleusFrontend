@extends('site.layout.index')
@section('title','Questions')
@section('content')
	<!-- Retail STart-->
	<div class="clearfix"></div>
    <section class="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left" id=retail data-type=anchor>
      <div class=container>
        <div class="row justify-content-md-center flex-md-row-reverse align-items-md-center row-55">
          <div class="col-md-5 wow fadeInLeft" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s;animation-name:fadeInLeft>
            <h2>{{$Retail->title}}</h2>
            <p class=text-gray>{{$Retail->detail}}</p>
          </div>
          <div class="col-md-7 wow fadeInRight" data-wow-duration=1s data-wow-delay=0.10s style=visibility:visible;animation-duration:1s;animation-delay:.1s;animation-name:fadeInRight>
            <figure class=figure-fullwidth> <img src="{{url('upload/retail/'.$Retail->retail_image)}}" alt=simpleretailpos width=620 height="465"/>
            </figure>
          </div>
        </div>
      </div>
    </section>
    <!-- Retail End-->

    <!-- Powerful Capabilities Start -->
    @if($PowerfulCapabilities->section_status=="Active")
    <section class="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left" id="retail" data-type="anchor" >
        <div class="container" style="margin-top: 4px;">
          <div class="top-wrapper-margin">

            <p class="text-gray">{{$PowerfulCapabilities->heading_detail}}</p>

          </div>
          <div class="row justify-content-md-center align-items-md-center row-55">
            <div class="col-md-6 wow fadeInLeft text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInLeft;">
              <h2>{{$PowerfulCapabilities->heading_title}} </h2>

              <?php 
              $capability_item=json_decode($PowerfulCapabilities->capability_item);
              ?>

              @if(count($capability_item)>0)
              <ul style="padding-top:20px;">
                @foreach($capability_item as $row)
                <li>•	{{$row->name}}</li>
                @endforeach
              </ul>
              @endif
            </div>
            <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInRight;">
              <figure class="figure-fullwidth"> <img src="{{url('upload/powerfulcapabilities/'.$PowerfulCapabilities->content_image)}}" alt="simpleretailpos" width="620" height="465">
              </figure>
            </div>
          </div>
        </div>
      </section>
      @endif  
        <!-- Powerful Capabilities End -->

        <!-- What Makes Better Start -->
        <section class="section wow fadeInUp" id="features" data-type="anchor" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-duration: 1s; animation-delay: 0s; animation-name: fadeInUp;">
          <div class="container w-container w-features">
            <div class="top-wrapper-margin">

              <h2 class="top-title-2">{{$PageSetting->question_what_makes_better}}</h2>
              <br>
            </div>
            <div>
              <div class="row">

                @if(count($WhatMakesBetter)>0)
                <?php $i=1; ?>
                @foreach($WhatMakesBetter as $row)
                <?php
                  $sty=''; 
                  if($i==1){ $sty='border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;'; }
                  elseif($i==2){ $sty='border-bottom: 1px solid #ccc;'; }
                  elseif($i==3){ $sty='border-right: 1px solid #ccc;'; }
                  ?>
                <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="{{$sty}} padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
                  <div class="services-wrapper">
                    <div>
                      <img src="{{url('upload/whatmakesbetter/'.$row->content_image)}}" alt="simpleretailpos" class="features-icon" width="85">
                      <div>
                        <h4 class="features-title"> {{$row->sub_heading}}
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
        <!-- What Makes Better End -->

        <!-- Could Boast Profitability Start -->
        @if($couldboostprofitability->module_status=="Active")
        <section class="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left" id="retail" data-type="anchor">
          <div class="container">
            <div class="row justify-content-md-center align-items-md-center row-55">
              <div class="col-md-6 wow fadeInLeft text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInLeft;">
                <h2>{{$couldboostprofitability->heading}}</h2>
                <p class="text-gray">{{$couldboostprofitability->detail}}</p>
              </div>
              <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInRight;">
                <figure class="figure-fullwidth"> <img src="{{url('upload/couldboostprofitability/'.$couldboostprofitability->content_image)}}" alt="simpleretailpos" width="620" height="465">
                </figure>
              </div>
            </div>
          </div>
        </section>
        @endif
        <!-- Could Boast Profitability End -->

        <!-- Easy To Use Start -->
        @if($SystemEasytoUse->module_status=="Active")
        <section class="section wow fadeInUp" id="features" data-type="anchor" data-wow-duration="1s" data-wow-delay="0s" style="visibility: visible; animation-duration: 1s; animation-delay: 0s; animation-name: fadeInUp;">
          <div class="container w-container w-features">

            <div>
              <div class="row">
                <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
                  <figure class="figure-fullwidth"> <img src="{{url('upload/systemeasytouse/'.$SystemEasytoUse->content_image)}}" alt="simpleretailpos" width="620" height="465">
                  </figure>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
                  <h2>{{$SystemEasytoUse->heading}}</h2>
                  <p class="text-gray">{{$SystemEasytoUse->detail}}</p>

                </div>
              </div>
            </div>
          </div>
        </section>
        @endif
        <!-- Easy To Use End-->

        <!--MultipleEmployeesAccess Start-->
        @if($MultipleEmployeesAccess->module_status=="Active")
        <section class="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left" id="retail" data-type="anchor">
          <div class="container">
            <div class="row justify-content-md-center align-items-md-center row-55">
              <div class="col-md-6 wow fadeInLeft text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInLeft;">
                <h2>{{$MultipleEmployeesAccess->heading}}</h2>
                <p class="text-gray">{{$MultipleEmployeesAccess->detail}}</p>
                <h2>{{$MultipleEmployeesAccess->title}}</h2>
                <p class="text-gray">{{$MultipleEmployeesAccess->content_detail}}</p>
              </div>
              <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInRight;">
                <figure class="figure-fullwidth"> <img src="{{url('upload/multipleemployeesaccess/'.$MultipleEmployeesAccess->content_image)}}" alt="simpleretailpos" width="620" height="465">
                </figure>
              </div>
            </div>
          </div>
        </section>
        @endif
        <!--MultipleEmployeesAccess End-->

      
@endsection

@section('css')

@endsection