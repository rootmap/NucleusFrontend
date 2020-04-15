
@extends("admin.layout.master")
@section("title","Edit Cardpointe Store Setting")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Cardpointe Store Setting</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Update Cardpointe Store Setting</li>
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
            <h3 class="card-title">Edit / Modify Cardpointe Store Setting</h3>
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('cardpointestoresetting/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="merchant_id">Merchant Id</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->merchant_id)){
                            ?>
                            value="{{$dataRow->merchant_id}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Merchant Id" id="merchant_id" name="merchant_id">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->username)){
                            ?>
                            value="{{$dataRow->username}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Username" id="username" name="username">
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
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Choose Module Status</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->module_status=="1"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="module_status_0" name="module_status" value="1">
                          <label class="form-check-label">1</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->module_status=="0"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="module_status_1" name="module_status" value="0">
                          <label class="form-check-label">0</label>
                        </div>
                
                    </div>
                </div>
            </div>
            
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="hsn">HSN</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->hsn)){
                            ?>
                            value="{{$dataRow->hsn}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter HSN" id="hsn" name="hsn">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="authkey">authkey</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->authkey)){
                            ?>
                            value="{{$dataRow->authkey}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter authkey" id="authkey" name="authkey">
                      </div>
                    </div>
                </div>
                
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Choose Bolt Status</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->bolt_status=="1"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="bolt_status_0" name="bolt_status" value="1">
                          <label class="form-check-label">1</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->bolt_status=="0"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="bolt_status_1" name="bolt_status" value="0">
                          <label class="form-check-label">0</label>
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
              <a class="btn btn-danger" href="{{url('cardpointestoresetting/edit/'.$dataRow->id)}}">
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