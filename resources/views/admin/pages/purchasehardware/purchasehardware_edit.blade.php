
@extends("admin.layout.master")
@section("title","Edit Purchase Hardware")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Purchase Hardware</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('purchasehardware/list')}}">Datatable </a></li>
              <li class="breadcrumb-item"><a href="{{url('purchasehardware/create')}}">Create New </a></li>
              <li class="breadcrumb-item active">Edit / Modify</li>
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
            <h3 class="card-title">Edit / Modify Purchase Hardware</h3>
            <div class="card-tools">
              <ul class="pagination pagination-sm float-right">
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('purchasehardware/create')}}"> 
                        Create 
                        <i class="fas fa-plus"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('purchasehardware/list')}}"> 
                        Data 
                        <i class="fas fa-table"></i>
                    </a>
                </li>
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
          <form action="{{url('purchasehardware/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->full_name)){
                            ?>
                            value="{{$dataRow->full_name}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Full Name" id="full_name" name="full_name">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->email)){
                            ?>
                            value="{{$dataRow->email}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Email" id="email" name="email">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->phone)){
                            ?>
                            value="{{$dataRow->phone}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Phone" id="phone" name="phone">
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Choose Country</label>
                                  <select class="form-control select2" style="width: 100%;"  id="country" name="country">
                                    
                                        <option value="">Please Select</option>
                                        @if(count($dataRow_Category)>0)
                                            @foreach($dataRow_Category as $Category)
                                                <option 
                                        @if(isset($dataRow->id))
                                            @if($dataRow->id==$Category->id)
                                                selected="selected" 
                                            @endif
                                        @endif 
                                         value="{{$Category->id}}">{{$Category->name}}</option>
                                                
                                            @endforeach
                                        @endif
                                        
                                  </select>
                                </div>
                            </div>
                        </div>
                    
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->state)){
                            ?>
                            value="{{$dataRow->state}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter State" id="state" name="state">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="zip_code">Zip Code</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->zip_code)){
                            ?>
                            value="{{$dataRow->zip_code}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Zip Code" id="zip_code" name="zip_code">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="delivery_address">Delivery Address</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->delivery_address)){
                            ?>
                            value="{{$dataRow->delivery_address}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Delivery Address" id="delivery_address" name="delivery_address">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->card_number)){
                            ?>
                            value="{{$dataRow->card_number}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Card Number" id="card_number" name="card_number">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_holder_name">Card Holder Name</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->card_holder_name)){
                            ?>
                            value="{{$dataRow->card_holder_name}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Card Holder Name" id="card_holder_name" name="card_holder_name">
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Choose Card Month</label>
                                  <select class="form-control select2" style="width: 100%;"  id="card_month" name="card_month">
                                    
        <option value="">Please select</option>
            <option 
                    <?php 
                    if($dataRow->card_month=="01"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> 
            value="01">01</option>
            <option 
                    <?php 
                    if($dataRow->card_month=="02"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> 
            value="02">02</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Choose Card Year</label>
                                  <select class="form-control select2" style="width: 100%;"  id="card_year" name="card_year">
                                    
        <option value="">Please select</option>
            <option 
                    <?php 
                    if($dataRow->card_year=="01"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> 
            value="01">01</option>
            <option 
                    <?php 
                    if($dataRow->card_year=="02"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> 
            value="02">02</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                    
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_pin">Card Pin</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->card_pin)){
                            ?>
                            value="{{$dataRow->card_pin}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Card Pin" id="card_pin" name="card_pin">
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Choose Hardware</label>
                                  <select class="form-control select2" style="width: 100%;"  id="hardware" name="hardware">
                                    
                                        <option value="">Please Select</option>
                                        @if(count($dataRow_HardwarePackage)>0)
                                            @foreach($dataRow_HardwarePackage as $HardwarePackage)
                                                <option 
                                        @if(isset($dataRow->id))
                                            @if($dataRow->id==$HardwarePackage->id)
                                                selected="selected" 
                                            @endif
                                        @endif 
                                         value="{{$HardwarePackage->id}}">{{$HardwarePackage->title}}</option>
                                                
                                            @endforeach
                                        @endif
                                        
                                  </select>
                                </div>
                            </div>
                        </div>
                    
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="hardware_price">Hardware Price</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->hardware_price)){
                            ?>
                            value="{{$dataRow->hardware_price}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Hardware Price" id="hardware_price" name="hardware_price">
                      </div>
                    </div>
                </div>
                
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Choose Payment Status</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->payment_status=="Pending"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="payment_status_0" name="payment_status" value="Pending">
                          <label class="form-check-label">Pending</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->payment_status=="Partial"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="payment_status_1" name="payment_status" value="Partial">
                          <label class="form-check-label">Partial</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->payment_status=="Paid"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="payment_status_2" name="payment_status" value="Paid">
                          <label class="form-check-label">Paid</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->payment_status=="Canceled"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="payment_status_3" name="payment_status" value="Canceled">
                          <label class="form-check-label">Canceled</label>
                        </div>
                
                    </div>
                </div>
            </div>
            
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Choose Hardware Delivery Status</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->hardware_delivery_status=="On Progress"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="hardware_delivery_status_0" name="hardware_delivery_status" value="On Progress">
                          <label class="form-check-label">On Progress</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->hardware_delivery_status=="Delivered"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="hardware_delivery_status_1" name="hardware_delivery_status" value="Delivered">
                          <label class="form-check-label">Delivered</label>
                        </div>
                
                    </div>
                </div>
            </div>
                   
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 
                Update
              </button>
              <a class="btn btn-danger" href="{{url('purchasehardware/edit/'.$dataRow->id)}}">
                <i class="far fa-times-circle"></i> 
                Reset
              </a>
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
        