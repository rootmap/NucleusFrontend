
@extends("admin.layout.master")
@section("title","Create New Purchase Hardware")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Purchase Hardware</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('purchasehardware/list')}}">Purchase Hardware Data</a></li>
              <li class="breadcrumb-item active">Create New Purchase Hardware</li>
            </ol>
      </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include("admin.include.msg")
        </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-8 offset-2">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Create New Purchase Hardware</h3>
            <div class="card-tools">
              <ul class="pagination pagination-sm float-right">
                <li class="page-item"><a class="page-link bg-primary" href="{{url('purchasehardware/list')}}"> Data <i class="fas fa-table"></i></a></li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('purchasehardware/export/pdf')}}">
                    <i class="fas fa-file-pdf" data-toggle="tooltip" data-html="true"title="Pdf"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('purchasehardware/export/excel')}}">
                    <i class="fas fa-file-excel" data-toggle="tooltip" data-html="true"title="Excel"></i>
                  </a>
                </li>
              </ul>
            </div>            
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('purchasehardware')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" placeholder="Enter Full Name" id="full_name" name="full_name">
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" placeholder="Enter Email" id="email" name="email">
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" placeholder="Enter Phone" id="phone" name="phone">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Choose Country</label>
                          <select class="form-control select2" style="width: 100%;"  id="country" name="country">
                                <option value="">Please Select</option>
                                @if(isset($dataRow_Category))    
                                    @if(count($dataRow_Category)>0)
                                        @foreach($dataRow_Category as $Category)
                                            <option value="{{$Category->country_name}}">{{$Category->country_name}}</option>
                                            
                                        @endforeach
                                    @endif
                                @endif 
                                
                          </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" class="form-control" placeholder="Enter State" id="state" name="state">
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="zip_code">Zip Code</label>
                        <input type="text" class="form-control" placeholder="Enter Zip Code" id="zip_code" name="zip_code">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="delivery_address">Delivery Address</label>
                        <input type="text" class="form-control" placeholder="Enter Delivery Address" id="delivery_address" name="delivery_address">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" class="form-control" placeholder="Enter Card Number" id="card_number" name="card_number">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_holder_name">Card Holder Name</label>
                        <input type="text" class="form-control" placeholder="Enter Card Holder Name" id="card_holder_name" name="card_holder_name">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Choose Card Month</label>
                          <select class="form-control select2" style="width: 100%;"  id="card_month" name="card_month">
                            <option value="">Please select</option>
                            @for($i=1; $i<=12; $i++)
                                <option value="{{strlen($i)==2?$i:'0'.$i}}">{{strlen($i)==2?$i:'0'.$i}}</option>
                            @endfor
                          </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Choose Card Year</label>
                          <select class="form-control select2" style="width: 100%;"  id="card_year" name="card_year">                    
                              @for($i=date('Y'); $i<=date('Y')+10; $i++)
                                  <option value="{{$i}}">{{$i}}</option>
                              @endfor
                          </select>
                        </div>
                    </div>
 
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_pin">Card Pin</label>
                        <input type="text" class="form-control" placeholder="Enter Card Pin" id="card_pin" name="card_pin">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Choose Hardware</label>
                          <select class="form-control select2" style="width: 100%;"  id="hardware" name="hardware">
                                <option value="">Please Select</option>
                                @if(isset($dataRow_HardwarePackage))    
                                    @if(count($dataRow_HardwarePackage)>0)
                                        @foreach($dataRow_HardwarePackage as $HardwarePackage)
                                            <option value="{{$HardwarePackage->id}}">{{$HardwarePackage->title}}</option>
                                            
                                        @endforeach
                                    @endif
                                @endif 
                                
                          </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="hardware_price">Hardware Price</label>
                        <input type="text" class="form-control" placeholder="Enter Hardware Price" id="hardware_price" name="hardware_price">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                      <!-- radio -->
                      <div class="form-group">
                      <label>Choose Payment Status</label>
                
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" 
                                  id="payment_status_0" name="payment_status" value="Pending">
                                  <label class="form-check-label">Pending</label>
                                </div>
                        
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" 
                                  id="payment_status_1" name="payment_status" value="Partial">
                                  <label class="form-check-label">Partial</label>
                                </div>
                        
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" 
                                  id="payment_status_2" name="payment_status" value="Paid">
                                  <label class="form-check-label">Paid</label>
                                </div>
                        
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" 
                                  id="payment_status_3" name="payment_status" value="Canceled">
                                  <label class="form-check-label">Canceled</label>
                                </div>
                        
                            </div>
                        </div>

                        <div class="col-sm-6">
                          <!-- radio -->
                          <div class="form-group">
                          <label>Choose Hardware Delivery Status</label>
                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" 
                                      id="hardware_delivery_status_0" name="hardware_delivery_status" value="On Progress">
                                      <label class="form-check-label">On Progress</label>
                                    </div>
                            
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" 
                                      id="hardware_delivery_status_1" name="hardware_delivery_status" value="Delivered">
                                      <label class="form-check-label">Delivered</label>
                                    </div>
                            
                                </div>
                            </div>
                        </div>
                   
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
              <a class="btn btn-danger" href="{{url('purchasehardware/create')}}"><i class="far fa-times-circle"></i> Reset</a>
            </div>
          </form>
        </div>
        <!-- /.card -->

      </div>
      <!--/.col (left) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection
@section("css")
    
    <link rel="stylesheet" href="{{url('admin/plugins/select2/css/select2.min.css')}}">
    
@endsection
        
@section("js")

    <script src="{{url('admin/plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
    $(document).ready(function(){
        $(".select2").select2();
    });
    </script>

@endsection
        