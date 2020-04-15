
@extends("admin.layout.master")
@section("title","Edit Signup Package")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Signup Package</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('signuppackage/list')}}">Datatable </a></li>
              <li class="breadcrumb-item"><a href="{{url('signuppackage/create')}}">Create New </a></li>
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
            <h3 class="card-title">Edit / Modify Signup Package</h3>
            <div class="card-tools">
              <ul class="pagination pagination-sm float-right">
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('signuppackage/create')}}"> 
                        Create 
                        <i class="fas fa-plus"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('signuppackage/list')}}"> 
                        Data 
                        <i class="fas fa-table"></i>
                    </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('signuppackage/export/pdf')}}">
                    <i class="fas fa-file-pdf" data-toggle="tooltip" data-html="true"title="Pdf"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('signuppackage/export/excel')}}">
                    <i class="fas fa-file-excel" data-toggle="tooltip" data-html="true"title="Excel"></i>
                  </a>
                </li>
              </ul>
            </div>
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('signuppackage/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->name)){
                            ?>
                            value="{{$dataRow->name}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Name" id="name" name="name">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->company_name)){
                            ?>
                            value="{{$dataRow->company_name}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Company Name" id="company_name" name="company_name">
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
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->address)){
                            ?>
                            value="{{$dataRow->address}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Address" id="address" name="address">
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Choose Package</label>
                                  <select class="form-control select2" style="width: 100%;"  id="package" name="package">
                                    
                                        <option value="">Please Select</option>
                                        @if(count($dataRow_Package)>0)
                                            @foreach($dataRow_Package as $Package)
                                                <option 
                                        @if(isset($dataRow->id))
                                            @if($dataRow->id==$Package->id)
                                                selected="selected" 
                                            @endif
                                        @endif 
                                         value="{{$Package->id}}">{{$Package->title}}</option>
                                                
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
                        <label for="password">Password</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->password)){
                            ?>
                            value="{{$dataRow->password}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Password" id="password" name="password">
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Choose Payment Status</label>
                                  <select class="form-control select2" style="width: 100%;"  id="payment_status" name="payment_status">
                                    
        <option value="">Please select</option>
            <option 
                    <?php 
                    if($dataRow->payment_status=="Pending"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> 
            value="Pending">Pending</option>
            <option 
                    <?php 
                    if($dataRow->payment_status=="Paid"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> 
            value="Paid">Paid</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                    
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Choose Sync Status</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->sync_status=="On Progress"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="sync_status_0" name="sync_status" value="On Progress">
                          <label class="form-check-label">On Progress</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->sync_status=="Done"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="sync_status_1" name="sync_status" value="Done">
                          <label class="form-check-label">Done</label>
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
              <a class="btn btn-danger" href="{{url('signuppackage/edit/'.$dataRow->id)}}">
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
        