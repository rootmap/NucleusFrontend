@extends('admin.apps.layout.master')
@section('title','Plug And Play Image')
@section('content')
<section id="file-exporaat">
		<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						@if(isset($edit))
						<i class="icon-user-plus"></i> Edit Plug And Play Image
						@else
						<i class="icon-user-plus"></i> Add Plug And Play Image
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
							action="{{url('admin-site/plug-and-play-image/modify/'.$edit->id)}}"
						@else
							action="{{url('admin-site/plug-and-play-image/save')}}"
						@endif
						>
							<div class="form-body">
								{{ csrf_field() }}
								
								<div class="form-group">
									<label for="eventRegInput1">Image <span class="text-danger">*</span></label>
									<input type="file" id="eventRegInput1" class="form-control border-primary" placeholder="Customer Name" name="image">
									@if(isset($edit))
										
											<img style="margin-top: 10px;" height="150" width="150" src="{{url('upload/plug-and-play/'.$edit->image)}}"  />
										
											<input type="hidden" id="text" class="form-control border-primary" value="{{$edit->image}}"  name="ex_image">
										
									@endif
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
				<h4 class="card-title"><i class="icon-users2"></i>Plug And Play Image List</h4>
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
								<th>image</th>
								<th style="width: 100px;">Action</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($dataTable))
							@foreach($dataTable as $row)
							<tr>
								<td>{{$row->id}}</td>
								<td><img style="margin-top: 10px;" height="80" width="80" src="{{url('upload/plug-and-play/'.$row->image)}}"  /></td>
								<td>
                                        <a href="{{url('admin-site/plug-and-play-image/edit/'.$row->id)}}" title="Edit" class="btn btn-sm btn-outline-info"><i class="icon-pencil22"></i></a>
                                        <a  href="{{url('admin-site/plug-and-play-image/delete/'.$row->id)}}" title="Delete" class="btn btn-sm btn-outline-info btn-darken-1"><i class="icon-cross"></i></a>
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
