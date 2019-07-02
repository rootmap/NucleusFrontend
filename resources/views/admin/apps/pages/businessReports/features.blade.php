@extends('admin.apps.layout.master')
@section('title','Business Reports')
@section('content')
<section id="file-exporaat">
		<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						@if(isset($edit))
						<i class="icon-user-plus"></i> Edit Business Reports
						@else
						<i class="icon-user-plus"></i> Add Business Reports
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
						<form class="form" method="post" enctype="multipart/form-data"
						@if(isset($edit))
							action="{{url('admin-site/business-reports-features/modify/'.$edit->id)}}"
						@else
							action="{{url('admin-site/business-reports-features/save')}}"
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
									<label for="eventRegInput1">Sub Title <span class="text-danger">*</span></label>
									<input type="text" 
									@if(isset($edit))
										value="{{$edit->sub_title}}" 
									@endif 
									 id="eventRegInput1" class="form-control border-primary" placeholder="Sub Title" name="sub_title">
								</div>
								<div class="form-group">
									<label for="eventRegInput1">Icon Image <span class="text-danger">*</span></label>
									<input type="file" id="eventRegInput1" class="form-control border-primary" placeholder="Customer Name" name="icon_image">
									@if(isset($edit))
										
											<img style="margin-top: 10px;" height="150" width="150" src="{{url('upload/business-reports/features/'.$edit->icon_image)}}"  />
										
											<input type="hidden" id="text" class="form-control border-primary" value="{{$edit->icon_image}}"  name="ex_image">
										
									@endif
								</div>
								<div class="form-group">
									<label for="eventRegInput3">Details <span class="text-danger">*</span></label>
									<textarea class="form-control border-primary" placeholder="Details" name="detail" rows="5">@if(isset($edit)){{$edit->detail}}@endif 	</textarea> 
								</div>
								<div class="form-group">
									<label for="eventRegInput3">Position <span class="text-danger">*</span></label>
									<select class="form-control border-primary" name="position" id="DefaultSelect">
		                                
			                            	<option >Select option</option>
				                            <option @if(isset($edit)){{ $edit->position === 'Position 1' ? 'selected' : '' }} @endif value="Position 1">Position 1</option>
			                                <option @if(isset($edit)){{ $edit->position === 'Position 2' ? 'selected' : '' }} @endif value="Position 2">Position 2</option>
			                                <option @if(isset($edit)){{ $edit->position === 'Position 3' ? 'selected' : '' }} @endif value="Position 3">Position 3</option>
			                                <option @if(isset($edit)){{ $edit->position === 'Position 4' ? 'selected' : '' }} @endif value="Position 4">Position 4</option>
			                                
		                                
		                            </select>
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
				<h4 class="card-title"><i class="icon-users2"></i>Business Report Features List</h4>
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
								<th>Sub Title</th>
								<th>Position </th>
								<th style="width: 100px;">Action</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($dataTable))
							@foreach($dataTable as $row)
							<tr>
								<td>{{$row->id}}</td>
								<td>{{$row->title}}</td>
								<td>{{$row->sub_title}}</td>
								<td>{{$row->position }}</td>
								<td>
                                        <a href="{{url('admin-site/business-reports-features/edit/'.$row->id)}}" title="Edit" class="btn btn-sm btn-outline-info"><i class="icon-pencil22"></i></a>
                                        <a  href="{{url('admin-site/business-reports-features/delete/'.$row->id)}}" title="Delete" class="btn btn-sm btn-outline-info btn-darken-1"><i class="icon-cross"></i></a>
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
