@extends('admin.apps.layout.master')
@section('title','Price')
@section('content')
<section id="file-exporaat">
		<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						@if(isset($edit))
						<i class="icon-user-plus"></i> Edit Price
						@else
						<i class="icon-user-plus"></i> Add Price
						@endif
					</h4>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
							<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="card-body collapse in">
					<div class="card-block">
						<form class="form" method="post" 
						@if(isset($edit))
							action="{{url('admin-site/price/modify/'.$edit->id)}}"
						@else
							action="{{url('admin-site/price/save')}}"
						@endif
						>
							<div class="form-body">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="eventRegInput1">Title <span class="text-danger">*</span></label>
									<input type="text" 
									@if(isset($edit))
										value="{{$edit->title}}" 
									@endif 
									 id="eventRegInput1" class="form-control border-primary" placeholder="Title" name="title">
								</div>
								<div class="form-group">
									<label for="eventRegInput1">Sub Title </label>
									<input type="text" 
									@if(isset($edit))
										value="{{$edit->sub_title}}" 
									@endif 
									 id="eventRegInput1" class="form-control border-primary" placeholder="Sub Title" name="sub_title">
								</div>
								<div class="form-group">
									<label for="eventRegInput1">Price <span class="text-danger">*</span></label>
									<input type="text" 
									@if(isset($edit))
										value="{{$edit->price}}" 
									@endif 
									 id="eventRegInput1" class="form-control border-primary" placeholder="Price" name="price">
								</div>
								<div class="form-group">
									<label for="eventRegInput1">Sub Price </label>
									<input type="text" 
									@if(isset($edit))
										value="{{$edit->sub_price}}" 
									@else
										value="00" 
									@endif 
									 id="eventRegInput1" class="form-control border-primary" placeholder="Sub Price" name="sub_price">
								</div>

								
								
	                            <div class="form-group contact-repeater">
	                            	<label for="eventRegInput1">Features </label>

	                            	@if(isset($edit))
		                            	@foreach(json_decode($edit->features) as $row)
			                            	<div data-repeater-list="repeater-group" class="cloneRow">
			                                    <div class="input-group mb-1" data-repeater-item="">
			                                        <input type="text" placeholder="Features" class="form-control" id="example-tel-input" value="{{$row}}" name="features[]">
			                                        <span class="input-group-btn" id="button-addon2">
			                                            <button class="btn btn-danger removeFetRow" onclick="removeFetRow(this)" type="button">
			                                            	<i class="icon-cross2"></i>
			                                            </button>
			                                        </span>
			                                    </div>
			                                </div>
		                                @endforeach
	                                @else
	                                <div data-repeater-list="repeater-group" class="cloneRow">
	                                    <div class="input-group mb-1" data-repeater-item>
	                                        <input type="text" placeholder="Features" class="form-control" id="example-tel-input" name="features[]">
	                                        <span class="input-group-btn" id="button-addon2">
	                                            <button class="btn btn-danger removeFetRow" onclick="removeFetRow(this)" type="button">
	                                            	<i class="icon-cross2"></i>
	                                            </button>
	                                        </span>
	                                    </div>
	                                </div>
	                                @endif

	                            </div>

	                            <div class="form-group">
									<button id="createNewRow" type="button" data-repeater-create class="btn btn-info">
	                                    <i class="icon-plus4"></i> Add new Features
	                                </button>
								</div>

	                                
	                            
							</div>

							<div class="form-actions center">
								<button type="button" class="btn btn-info btn-darken-2 mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								@if(isset($edit))
								<button type="submit" class="btn btn-info btn-accent-2">
									<i class="icon-check2"></i> Update
								</button>
								@else
								<button type="submit" class="btn btn-info btn-accent-2">
									<i class="icon-check2"></i> Save
								</button>
								@endif
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- Both borders end-->
<div class="row">
	<div class="col-xs-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><i class="icon-users2"></i> Price List</h4>
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
								<th style="width: 100px;">ID</th>
								<th>Title</th>
								<th style="width: 100px;">Action</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($dataTable))
							@foreach($dataTable as $row)
							<tr>
								<td>{{$row->id}}</td>
								<td>{{$row->title}}</td>
								<td>
                                        <a href="{{url('admin-site/price/edit/'.$row->id)}}" title="Edit" class="btn btn-sm btn-outline-info"><i class="icon-pencil22"></i></a>
                                        <a  href="{{url('admin-site/price/delete/'.$row->id)}}" title="Delete" class="btn btn-sm btn-outline-info btn-darken-1"><i class="icon-cross"></i></a>
								</td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="6">No Record Found</td>
							</tr>
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


