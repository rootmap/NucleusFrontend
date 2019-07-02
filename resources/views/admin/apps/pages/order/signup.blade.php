@extends('admin.apps.layout.master')
@section('title','Payment Report')
@section('content')
<section id="form-action-layouts">

	<!-- Both borders end-->
<div class="row">
	<div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><i class="icon-clear_all"></i> Online Signup  List</h4>
				<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        		<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
						<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="card-body collapse in">
				<div class="table-responsive">
					<table class="table table-striped table-bordered zero-configuration">
						<thead>
							<tr>
								<th>Order.Id</th>
								<th>Package</th>
								<th>Customer</th>
								<th>Company Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Tender</th>
								<th>Status</th>
								<th>Sync With App</th>
								<th>Create Date</th>
								
							</tr>
						</thead>
						<tbody>
							<?php 
							$invoice_total=0;
							$cost_total=0;
							$paid_amount=0;
							?>
							@if(isset($invoice))
								@foreach($invoice as $inv)
								<tr>
	                                <td>{{$inv->id}}</td>
	                                <td>{{$inv->package_name}}</td>
	                                <td>{{$inv->name}}</td>
	                                <td>{{$inv->company_name}}</td>
	                                <td>{{$inv->email}}</td>
	                                <td>{{$inv->phone}}</td>
	                                <td>
	                                	@if($inv->cardpayment==1)
	                                		Card Payment
	                                	@elseif($inv->paypalpayment==1)
	                                		Paypal
	                                	@endif
	                                </td>
	                                <td>{{$inv->payment_status}}</td>
	                                <td>{{$inv->sync_status}}</td>
	                                <td>{{date('m/d/Y H:i:s',strtotime($inv->created_at))}}</td>
	                            </tr>
	                            <?php 
								$paid_amount+=$inv->paid_amount;
								?>
	                            @endforeach
							@endif

						</tbody>
					</table>
				</div>
			</div>
		</div>







	</div>
</div>
<!-- Both borders end -->





</section>
@endsection

@include('admin.apps.include.datatable',['JDataTable'=>1])