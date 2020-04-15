
@extends("admin.layout.master")
@section("title","Create New Page Setting")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Page Setting</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Create New Page Setting</li>
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
            <h3 class="card-title">Create New Page Setting</h3>            
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('pagesetting')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="home_feature_title">Home Feature Title</label>
                        <input type="text" class="form-control" placeholder="Enter Home Feature Title" id="home_feature_title" name="home_feature_title">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="home_intragted_solution">Home Intragted Solution</label>
                        <input type="text" class="form-control" placeholder="Enter Home Intragted Solution" id="home_intragted_solution" name="home_intragted_solution">
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Choose Default Package</label>
                                  <select class="form-control select2" style="width: 100%;"  id="default_package" name="default_package">
                                        <option value="">Please Select</option>
                                        @if(isset($dataRow_Package))    
                                            @if(count($dataRow_Package)>0)
                                                @foreach($dataRow_Package as $Package)
                                                    <option value="{{$Package->id}}">{{$Package->title}}</option>
                                                    
                                                @endforeach
                                            @endif
                                        @endif 
                                        
                                  </select>
                                </div>
                            </div>
                        </div>
                    
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="business_pos_core_software_title">Business POS Core Software Title</label>
                        <input type="text" class="form-control" placeholder="Enter Business POS Core Software Title" id="business_pos_core_software_title" name="business_pos_core_software_title">
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="business_pos_core_software_title">Business POS Core Software Detail</label>
                        <input type="text" class="form-control" placeholder="Enter Business POS Core Software Detail" id="business_pos_core_software_detail" name="business_pos_core_software_detail">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="business_pos_core_hardware_title">Business POS Core Hardware Title</label>
                        <input type="text" class="form-control" placeholder="Enter Business POS Core Hardware Title" id="business_pos_core_hardware_title" name="business_pos_core_hardware_title">
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="business_pos_core_hardware_title">Business POS Core Hardware Detail</label>
                        <input type="text" class="form-control" placeholder="Enter Business POS Core Hardware Detail" id="business_pos_core_hardware_detail" name="business_pos_core_hardware_detail">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="retail_store_key_feature_title">Retail Store Key Feature Title</label>
                        <input type="text" class="form-control" placeholder="Enter Retail Store Key Feature Title" id="retail_store_key_feature_title" name="retail_store_key_feature_title">
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="question_what_makes_better">Question : What Makes Better</label>
                        <input type="text" class="form-control" placeholder="Enter Question : What Makes Better" id="question_what_makes_better" name="question_what_makes_better">
                      </div>
                    </div>
                </div>
                       
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
              <a class="btn btn-danger" href="{{url('pagesetting/create')}}"><i class="far fa-times-circle"></i> Reset</a>
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
        