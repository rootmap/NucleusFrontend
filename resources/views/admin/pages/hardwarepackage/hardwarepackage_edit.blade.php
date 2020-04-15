
@extends("admin.layout.master")
@section("title","Edit Hardware Package")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Hardware Package</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('hardwarepackage/list')}}">Datatable </a></li>
              <li class="breadcrumb-item"><a href="{{url('hardwarepackage/create')}}">Create New </a></li>
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
            <h3 class="card-title">Edit / Modify Hardware Package</h3>
            <div class="card-tools">
              <ul class="pagination pagination-sm float-right">
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('hardwarepackage/create')}}"> 
                        Create 
                        <i class="fas fa-plus"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('hardwarepackage/list')}}"> 
                        Data 
                        <i class="fas fa-table"></i>
                    </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('hardwarepackage/export/pdf')}}">
                    <i class="fas fa-file-pdf" data-toggle="tooltip" data-html="true"title="Pdf"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('hardwarepackage/export/excel')}}">
                    <i class="fas fa-file-excel" data-toggle="tooltip" data-html="true"title="Excel"></i>
                  </a>
                </li>
              </ul>
            </div>
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('hardwarepackage/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->title)){
                            ?>
                            value="{{$dataRow->title}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Title" id="title" name="title">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->price)){
                            ?>
                            value="{{$dataRow->price}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Price" id="price" name="price">
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Hardware Image</label>
                                    <!-- <label for="customFile">Choose Hardware Image</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="hardware_image" name="hardware_image">
                                      <input type="hidden" value="{{$dataRow->hardware_image}}" name="ex_hardware_image" />
                                      <label class="custom-file-label" for="customFile">Choose Hardware Image</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($dataRow->hardware_image))
                                    @if(!empty($dataRow->hardware_image))
                                        <img class="img-thumbnail" src="{{url('upload/hardwarepackage/'.$dataRow->hardware_image)}}" width="150">
                                    @endif
                                @endif
                            </div>
                        </div>

                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->

                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th>SL</th>
                                  <th>Feature Detail</th>
                                  <th>Feature Status</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                             @if(isset($dataRow->hardware_detail))
                              <?php 
                              $feature_details=json_decode($dataRow->hardware_detail);
                              //dd($feature_details);
                              $i=1;
                              ?>
                              @foreach($feature_details as $row)
                              <tr class="crud-item" id="tr{{$i}}">
                                <td>{{$i}}</td>
                                <td><input type="text" class="form-control" placeholder="Enter Feature Detail" id="feature_detail" name="feature_detail[]" value="{{$row->name}}"></td>
                                <td>
                                  <select class="form-control" style="width: 100%;"  id="feature_status" name="feature_status[]">
                                    <option {{($row->status=="Active")?"selected=selected":''}} value="Active">Active</option>
                                    <option {{($row->status=='Inactive')?'selected=selected':''}}  value="Inactive">Inactive</option>
                                  </select>
                                </td>
                                <td>
                                  <button type="button" onclick="deleteRow('tr{{$i}}')" data-id="tr{{$i}}" class="btn btn-danger">&times;</button>
                                </td>
                              </tr>
                              <?php $i++; ?>
                              @endforeach
                            @endif
                          </tbody>
                      </table>

                    </div>
                </div>
                
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Choose Module Status</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->module_status=="Active"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="module_status_0" name="module_status" value="Active">
                          <label class="form-check-label">Active</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->module_status=="Inactive"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="module_status_1" name="module_status" value="Inactive">
                          <label class="form-check-label">Inactive</label>
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
              <a class="btn btn-danger" href="{{url('hardwarepackage/edit/'.$dataRow->id)}}">
                <i class="far fa-times-circle"></i> 
                Reset
              </a>
              <a class="btn btn-success" href="javascript:addmore();"><i class="fas fa-plus"></i> More Feature</a>
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

    function refreshSerial(){
        var r=1;
        $.each($(".crud-item"),function(key,row){
            $(this).attr("id","tr"+r);
            $(this).find("td:first").html(r);
            $(this).find("td:eq(3)").find("button:eq(1)").attr("onclick","deleteRow('tr"+r+"')");
            r++;
        });
    }

    function deleteRow(place){
        var item=$(".crud-item").length;
        if(item>1)
        {
            //var itemID=$(place).parent().parent().attr("id");
            $("#"+place).remove()
        }
        refreshSerial(); 
    }


    function addmore(){
            $("tr[class^='crud-item']:last").after($("tr[class^='crud-item']:last").clone());
            refreshSerial(); 
    }
    </script>

    <script src="{{url('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
    $(document).ready(function(){
        bsCustomFileInput.init();
    });
    </script>

@endsection
        