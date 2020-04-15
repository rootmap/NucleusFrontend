@extends('site.layout.index')
@section('title','Subscription Pricing')
@section('content')

      <section class="pricing py-5">
        <div class="container">
          <div class="row">
            @if(isset($allPackage) && count($allPackage)>0)
            @foreach($allPackage as $row)
            <div class="col-lg-6">
              <div class="card mb-5 mb-lg-0">
                <div class="card-body">
                  <h5 class="card-title text-muted text-uppercase text-center">{{ $row->title }}</h5>
                  <h6 class="card-price text-center">${{ $row->price }}<span class="period">/{{ $row->subscription_type }}</span></h6>
                  <hr>
                  <?php 
                  $featureJson=json_decode($row->feature_detail);

                  ?>
                  @if(count($featureJson)>0)
                  <ul class="fa-ul">
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
                  <a href="{{url('purchase/package/'.$row->id)}}" class="btn btn-block btn-primary text-uppercase">Signup</a>
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
@endsection