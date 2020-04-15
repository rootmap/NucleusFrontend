
@extends("admin.layout.master")
@section("title","Edit Powerful Capabilities")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Powerful Capabilities</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Update Powerful Capabilities</li>
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
            <h3 class="card-title">Edit / Modify Powerful Capabilities</h3>
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('powerfulcapabilities/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="heading_detail">Heading Detail</label>
                        <textarea class="form-control" rows="3"  placeholder="Enter Heading Detail" id="heading_detail" name="heading_detail"><?php 
                                if(isset($dataRow->heading_detail)){
                                    
                                    echo $dataRow->heading_detail;
                                    
                                }
                                ?></textarea>
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="heading_title">Heading Title</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->heading_title)){
                            ?>
                            value="{{$dataRow->heading_title}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Heading Title" id="heading_title" name="heading_title">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th>SL</th>
                                  <th>Capability Item</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                            @if(isset($dataRow->capability_item))
                              <?php 
                              $feature_details=json_decode($dataRow->capability_item);
                              //dd($feature_details);
                              $i=1;
                              ?>
                              @foreach($feature_details as $row)
                              <tr class="crud-item" id="tr{{$i}}">
                                <td>{{$i}}</td>
                                <td><input type="text" class="form-control" placeholder="Enter Feature Detail" id="capability_item" name="capability_item[]" value="{{$row->name}}"></td>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Content Image</label>
                                    <!-- <label for="customFile">Choose Content Image</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="content_image" name="content_image">
                                      <input type="hidden" value="{{$dataRow->content_image}}" name="ex_content_image" />
                                      <label class="custom-file-label" for="customFile">Choose Content Image</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($dataRow->content_image))
                                    @if(!empty($dataRow->content_image))
                                        <img class="img-thumbnail" src="{{url('upload/powerfulcapabilities/'.$dataRow->content_image)}}" width="150">
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Choose Foreground</label>
                                  <select class="form-control select2" style="width: 100%;"  id="section_foreground_color" name="section_foreground_color">
                                    
        <option value="">Please select</option>
            <option 
                    <?php 
                    if($dataRow->section_foreground_color=="White"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> 
            value="White">White</option>
            <option 
                    <?php 
                    if($dataRow->section_foreground_color=="Ash"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> 
            value="Ash">Ash</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                    
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Choose Section Status</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->section_status=="Active"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="section_status_0" name="section_status" value="Active">
                          <label class="form-check-label">Active</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->section_status=="Inactive"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="section_status_1" name="section_status" value="Inactive">
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
              <a class="btn btn-danger" href="{{url('powerfulcapabilities/edit/'.$dataRow->id)}}">
                <i class="far fa-times-circle"></i> 
                Reset
              </a>
              <a class="btn btn-success" href="javascript:addmore();"><i class="fas fa-plus"></i> More Capability Item</a>
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

    <script src="{{url('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
    $(document).ready(function(){
        bsCustomFileInput.init();
    });
    </script>

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
            $(this).find("td:eq(2)").find("button:eq(1)").attr("onclick","deleteRow('tr"+r+"')");
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

@endsection
        