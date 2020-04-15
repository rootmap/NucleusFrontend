@extends('site.layout.index')
@section('title','Simple Cash Register')
@section('content')

  
		
  @if(isset($SimpleCashRegister))  
    @foreach($SimpleCashRegister as $row)
      <?php
      //section page-footer-corporate wow fadeInUp
          $classNames="section novi-background bg-cover bg-image section-md bg-gray-light text-center text-md-left"; 
      if($row->section_foreground_color=="Ash")
      {   
        $classNames="section wow fadeInUp"; 
          
      }
      ?>
    	<section class="{{$classNames}}" id="retail" data-type="anchor">
          <div class="container">
            <div class="row justify-content-md-center align-items-md-center row-55">
              @if($row->image_position=="Left")
              <div class="col-md-6 wow fadeInLeft text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInLeft;">
                <h2>{{$row->heading}}</h2>
                <p class="text-gray">{{$row->detail}}</p>
              </div>
              <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.10s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInRight;">
                <figure class="figure-fullwidth"> <img src="{{url('upload/simplecashregister/'.$row->content_image)}}" alt="simpleretailpos" width="620" height="465">
                </figure>
              </div>
              @else
              <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
                <figure class="figure-fullwidth"> <img src="{{url('upload/simplecashregister/'.$row->content_image)}}" alt="simpleretailpos" width="620" height="465">
                </figure>
              </div>
              <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInDown text-left" data-wow-duration="1s" data-wow-delay="0.10s" style="padding:35px; visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInDown;">
                <h2>{{$row->heading}}</h2>
                <p class="text-gray">{{$row->detail}}</p>

              </div>
              @endif

            </div>
          </div>
      </section>
    @endforeach
  @endif


@endsection

@section('css')

@endsection