@extends('site.layout.index')
@section('title','Hardware Pricing')
@section('content')
        <style type="text/css">
            .form-wrap-select::after
            {
                content: "▼";
                position: absolute;
                top: 28%;
                right: 13px;
            }
        </style>
      <section class="pricing py-5">
        <div class="container">
          <div class="row">

            <div id="purchaseArea" class="col-lg-12 col-md-12 mb-4" style="display: none;">
              <div class="card mb-5 mb-lg-0 " style="border: 1px #fff solid !important; background: none;">
                <div class="card-body">
                  <h3 style="font-size:2rem; color:#fff !important;" class="card-price text-center">Complete Your Payment</h3>
                  <h5 class="card-title text-muted text-uppercase text-center purchaseplaceitem" style=" color:#fff !important;">
                      <span data-id="0">Product Name</span>
                      <span> | </span>
                      <span>$</span>
                      <span data-id="0">200</span>
                  </h5>
                  <a href="javascript:void(0);" class="closePurchase" style="position: absolute; font-weight: bold; font-size:16px; color:#fff; top:2px; right:10px;">X</a>
                  <hr>
                  
                      <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-12 mb-2" >
                            <div class="col-md-12" id="showSignupConSMS"></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-md-12">
                                
                                <div class="row" style="margin-top:0px;">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-wrap">
                                            <input class="form-input" placeholder="Enter Full Name" type="text" name="hFullName" data-constraints="@Required">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-wrap">
                                            <input class="form-input" placeholder="Email Address" type="text" name="hEmailAddress" data-constraints="@Required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:0px;">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-wrap">
                                            <input class="form-input" placeholder="Enter Phone" type="text" name="hPhone" data-constraints="@Required">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-wrap form-wrap-select">
                                            <select class="form-input"  name="hCountry">
                                                <option value="">Select Country</option>
                                                @foreach($country as $row)
                                                    <option value="{{$row->country_name}}">{{$row->country_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:0px;">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-wrap">
                                            <input class="form-input" placeholder="Enter Your State" type="text" name="hState" data-constraints="@Required">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-wrap">
                                            <input class="form-input" placeholder="Enter Zip Code" type="text" name="hZipCode" data-constraints="@Required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:0px;">
                                    <div class="col-md-12 mb-2">
                                        <div class="form-wrap">
                                            <input class="form-input" placeholder="Enter Delivery Address" type="text" name="hDeliveryAddress" data-constraints="@Required">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-md-12">
                                <div class="row" style="margin-top:0px;">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-wrap">
                                            <input class="form-input" placeholder="Enter Card Number" type="text" name="hCardNumber" data-constraints="@Required">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-wrap">
                                            <input style="font-weight: bold;" class="form-input"  value="Visa/AMEX/MasterCard/Discover" disabled placeholder="Enter Card Number" type="text" name="hCardNumber" data-constraints="@Required">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:0px;">
                                    <div class="col-md-12 mb-2">
                                        <div class="form-wrap">
                                            <input class="form-input" placeholder="Enter Card Holder Name" type="text" name="hCardHolderName" data-constraints="@Required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:0px;">
                                    <div class="col-md-4 mb-2">
                                        <div class="form-wrap form-wrap-select">
                                            <select class="form-input"  name="hCardMonth">
                                                <option value="">Select Month</option>
                                                @for($i=1; $i<=12; $i++)
                                                    <option value="{{strlen($i)==2?$i:'0'.$i}}">{{strlen($i)==2?$i:'0'.$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-wrap form-wrap-select">
                                            <select class="form-input" name="hCardYear">
                                                <option value="">Select Year</option>
                                                @for($i=date('Y'); $i<=date('Y')+10; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-wrap">
                                            <input class="form-input" placeholder="Enter Card CVC/CVV2" type="password" name="hCardPin" data-constraints="@Required">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <button class="btn btn-block btn-danger text-uppercase processCreditCard" type="button"><i class="far fa-credit-card"></i> Signup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                
                      </div>
                </div>
              </div>
            </div>
            
            @if(isset($allPackage) && count($allPackage)>0)
            @foreach($allPackage as $row)
            <div class="col-lg-4 mb-4">
              <div class="card mb-5 mb-lg-0">
                <div class="card-body">
                  <h5 class="card-title text-muted text-uppercase text-center">{{ $row->title }}</h5>
                  <h6 class="card-price text-center">${{ $row->price }}</h6>
                  <hr>
                  <p style="text-align: center;">
                        <img class="img-responsive" style="height:150px; text-align: center; margin:0 auto;" src="{{asset('upload/hardwarepackage/'.$row->hardware_image)}}" />
                  </p>
                  <hr>
                  <?php 
                  $featureJson=json_decode($row->hardware_detail);

                  ?>
                  @if(count($featureJson)>0)
                  <ul class="fa-ul" style="min-height: 185px;">
                    @foreach($featureJson as $rows)
                      
                      @if($rows->status=="Inactive")
                        <li class="text-muted" style="color:#dee3e2 !important;">
                          <span class="fa-li">
                            <i class="fas fa-times"></i>
                          </span>
                          {{ $rows->name }}
                        </li>
                      @else
                        <li>
                          <span class="fa-li">
                            <i class="fas fa-check"></i>
                          </span>
                          <strong>{{ $rows->name }}</strong>
                        </li>
                      @endif
                    
                    @endforeach
                  </ul>
                  @endif
                <button class="btn btn-block btn-primary text-uppercase purchaseHardwareDFK" data-pro-til="{{$row->title}}" data-pro-price="{{$row->price}}" type="button" data-push="{{$row->id}}">Purchase</button>
                </div>
              </div>
            </div>
            @endforeach
            @endif

    
          </div>
        </div>
      </section>

@endsection

@section('css')
<!-- Latest compiled and minified CSS -->
<style>
  section.pricing {
  background:#078423;
  background: linear-gradient(to right, #078423,#078423);
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

@endsection