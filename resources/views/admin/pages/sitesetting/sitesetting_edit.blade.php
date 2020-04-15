
@extends("admin.layout.master")
@section("title","Edit Site Setting")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Site Setting</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Update Site Setting</li>
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
            <h3 class="card-title">Edit / Modify Site Setting</h3>
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('sitesetting/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="site_name">Site Name</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->site_name)){
                            ?>
                            value="{{$dataRow->site_name}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Site Name" id="site_name" name="site_name">
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Site Logo</label>
                                    <!-- <label for="customFile">Choose Site Logo</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="site_logo" name="site_logo">
                                      <input type="hidden" value="{{$dataRow->site_logo}}" name="ex_site_logo" />
                                      <label class="custom-file-label" for="customFile">Choose Site Logo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($dataRow->site_logo))
                                    @if(!empty($dataRow->site_logo))
                                        <img class="img-thumbnail" src="{{url('upload/sitesetting/'.$dataRow->site_logo)}}" width="150">
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Powered By Logo</label>
                                    <!-- <label for="customFile">Choose Powered By Logo</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="powered_by_logo" name="powered_by_logo">
                                      <input type="hidden" value="{{$dataRow->powered_by_logo}}" name="ex_powered_by_logo" />
                                      <label class="custom-file-label" for="customFile">Choose Powered By Logo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($dataRow->powered_by_logo))
                                    @if(!empty($dataRow->powered_by_logo))
                                        <img class="img-thumbnail" src="{{url('upload/sitesetting/'.$dataRow->powered_by_logo)}}" width="150">
                                    @endif
                                @endif
                            </div>
                        </div>
                <div class="row">
                    <div class="col-sm-4">
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

                    <div class="col-sm-4">
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
                        
                        class="form-control" placeholder="Enter Email Address" id="email" name="email">
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="email">Phone</label>
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
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="instagram_link">Instagram Link</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->instagram_link)){
                            ?>
                            value="{{$dataRow->instagram_link}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Instagram Link" id="instagram_link" name="instagram_link">
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="facebook_link">Facebook Link</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->facebook_link)){
                            ?>
                            value="{{$dataRow->facebook_link}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Facebook Link" id="facebook_link" name="facebook_link">
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="youtube_link">Youtube Link</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->youtube_link)){
                            ?>
                            value="{{$dataRow->youtube_link}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Youtube Link" id="youtube_link" name="youtube_link">
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
              <a class="btn btn-danger" href="{{url('sitesetting/edit/'.$dataRow->id)}}">
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
@section("js")

    <script src="{{url('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
    $(document).ready(function(){
        bsCustomFileInput.init();
    });
    </script>

@endsection
        