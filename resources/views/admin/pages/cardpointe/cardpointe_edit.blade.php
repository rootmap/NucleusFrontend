
@extends("admin.layout.master")
@section("title","Edit Card Pointe")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Card Pointe</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('cardpointe/list')}}">Datatable </a></li>
              <li class="breadcrumb-item"><a href="{{url('cardpointe/create')}}">Create New </a></li>
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
            <h3 class="card-title">Edit / Modify Card Pointe</h3>
            <div class="card-tools">
              <ul class="pagination pagination-sm float-right">
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('cardpointe/create')}}"> 
                        Create 
                        <i class="fas fa-plus"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('cardpointe/list')}}"> 
                        Data 
                        <i class="fas fa-table"></i>
                    </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('cardpointe/export/pdf')}}">
                    <i class="fas fa-file-pdf" data-toggle="tooltip" data-html="true"title="Pdf"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('cardpointe/export/excel')}}">
                    <i class="fas fa-file-excel" data-toggle="tooltip" data-html="true"title="Excel"></i>
                  </a>
                </li>
              </ul>
            </div>
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('cardpointe/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="invoice_id">Invoice Id</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->invoice_id)){
                            ?>
                            value="{{$dataRow->invoice_id}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Invoice Id" id="invoice_id" name="invoice_id">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="responsejson">ResponseJson</label>
                        <textarea class="form-control" rows="3"  placeholder="Enter ResponseJson" id="responsejson" name="responsejson"><?php 
                                if(isset($dataRow->responsejson)){
                                    
                                    echo $dataRow->responsejson;
                                    
                                }
                                ?></textarea>
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
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_expire_month">Card Expire Month</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->card_expire_month)){
                            ?>
                            value="{{$dataRow->card_expire_month}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Card Expire Month" id="card_expire_month" name="card_expire_month">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_expire_year">Card Expire Year</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->card_expire_year)){
                            ?>
                            value="{{$dataRow->card_expire_year}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Card Expire Year" id="card_expire_year" name="card_expire_year">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_cvc">Card CVC</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->card_cvc)){
                            ?>
                            value="{{$dataRow->card_cvc}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Card CVC" id="card_cvc" name="card_cvc">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->amount)){
                            ?>
                            value="{{$dataRow->amount}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Amount" id="amount" name="amount">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="authcode">AuthCode</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->authcode)){
                            ?>
                            value="{{$dataRow->authcode}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter AuthCode" id="authcode" name="authcode">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="token">Token</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->token)){
                            ?>
                            value="{{$dataRow->token}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Token" id="token" name="token">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="account">Account</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->account)){
                            ?>
                            value="{{$dataRow->account}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Account" id="account" name="account">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="retref">retref</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->retref)){
                            ?>
                            value="{{$dataRow->retref}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter retref" id="retref" name="retref">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="resptext">Resptext</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->resptext)){
                            ?>
                            value="{{$dataRow->resptext}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Resptext" id="resptext" name="resptext">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="respstat">Respstat</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->respstat)){
                            ?>
                            value="{{$dataRow->respstat}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Respstat" id="respstat" name="respstat">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="respcode">Respcode</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->respcode)){
                            ?>
                            value="{{$dataRow->respcode}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Respcode" id="respcode" name="respcode">
                      </div>
                    </div>
                </div>
                
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Enter Refund Status</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->refund_status=="1"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="refund_status_0" name="refund_status" value="1">
                          <label class="form-check-label">1</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->refund_status=="0"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="refund_status_1" name="refund_status" value="0">
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
              <a class="btn btn-danger" href="{{url('cardpointe/edit/'.$dataRow->id)}}">
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