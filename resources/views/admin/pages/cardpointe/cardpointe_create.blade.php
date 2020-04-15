
@extends("admin.layout.master")
@section("title","Create New Card Pointe")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Card Pointe</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('cardpointe/list')}}">Card Pointe Data</a></li>
              <li class="breadcrumb-item active">Create New Card Pointe</li>
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
            <h3 class="card-title">Create New Card Pointe</h3>
            <div class="card-tools">
              <ul class="pagination pagination-sm float-right">
                <li class="page-item"><a class="page-link bg-primary" href="{{url('cardpointe/list')}}"> Data <i class="fas fa-table"></i></a></li>
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
          <form action="{{url('cardpointe')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="invoice_id">Invoice Id</label>
                        <input type="text" class="form-control" placeholder="Enter Invoice Id" id="invoice_id" name="invoice_id">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="responsejson">ResponseJson</label>
                        <textarea class="form-control" rows="3"  placeholder="Enter ResponseJson" id="responsejson" name="responsejson"></textarea>
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" class="form-control" placeholder="Enter Card Number" id="card_number" name="card_number">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_holder_name">Card Holder Name</label>
                        <input type="text" class="form-control" placeholder="Enter Card Holder Name" id="card_holder_name" name="card_holder_name">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_expire_month">Card Expire Month</label>
                        <input type="text" class="form-control" placeholder="Enter Card Expire Month" id="card_expire_month" name="card_expire_month">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_expire_year">Card Expire Year</label>
                        <input type="text" class="form-control" placeholder="Enter Card Expire Year" id="card_expire_year" name="card_expire_year">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="card_cvc">Card CVC</label>
                        <input type="text" class="form-control" placeholder="Enter Card CVC" id="card_cvc" name="card_cvc">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control" placeholder="Enter Amount" id="amount" name="amount">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="authcode">AuthCode</label>
                        <input type="text" class="form-control" placeholder="Enter AuthCode" id="authcode" name="authcode">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="token">Token</label>
                        <input type="text" class="form-control" placeholder="Enter Token" id="token" name="token">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="account">Account</label>
                        <input type="text" class="form-control" placeholder="Enter Account" id="account" name="account">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="retref">retref</label>
                        <input type="text" class="form-control" placeholder="Enter retref" id="retref" name="retref">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="resptext">Resptext</label>
                        <input type="text" class="form-control" placeholder="Enter Resptext" id="resptext" name="resptext">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="respstat">Respstat</label>
                        <input type="text" class="form-control" placeholder="Enter Respstat" id="respstat" name="respstat">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="respcode">Respcode</label>
                        <input type="text" class="form-control" placeholder="Enter Respcode" id="respcode" name="respcode">
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
                          id="refund_status_0" name="refund_status" value="1">
                          <label class="form-check-label">1</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio" 
                          id="refund_status_1" name="refund_status" value="0">
                          <label class="form-check-label">0</label>
                        </div>
                
                    </div>
                </div>
            </div>
                   
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
              <a class="btn btn-danger" href="{{url('cardpointe/create')}}"><i class="far fa-times-circle"></i> Reset</a>
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