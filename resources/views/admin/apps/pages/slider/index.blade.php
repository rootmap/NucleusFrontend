@extends('admin.apps.layout.master')
@section('title','Slider')
@section('content')
<section id="file-exporaat">
		<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						@if(isset($edit))
						<i class="icon-user-plus"></i> Edit Slider
						@else
						<i class="icon-user-plus"></i> Add Slider
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
							action="{{url('admin-site/slider/modify/'.$edit->id)}}"
						@else
							action="{{url('admin-site/slider/save')}}"
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
									<label for="eventRegInput1">Image <span class="text-danger">*</span></label>
									
									<input type="file" id="eventRegInput1" class="form-control border-primary" name="image">
									@if(!empty($edit->image))
										<img style="margin-top: 10px;" width="150" src="{{url('upload/slider/'.$edit->image)}}"  />
										<input type="hidden" id="text" class="form-control border-primary" value="{{$edit->image}}" placeholder="site_logo" name="ex_image">
									@endif
								</div>

								<div class="form-group">
									<label for="eventRegInput1">Video Link <span class="text-danger">*</span></label>
									<input type="text" 
									@if(isset($edit))
										value="{{$edit->demo_link}}" 
									@endif 
									 id="eventRegInput1" class="form-control border-primary" placeholder="Video Link" name="demo_link">
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
				<h4 class="card-title"><i class="icon-users2"></i> Slider List</h4>
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
								<th>Video Link</th>
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
								<td>{{$row->demo_link}}</td>
								<td>
                                        <a href="{{url('admin-site/slider/edit/'.$row->id)}}" title="Edit" class="btn btn-sm btn-outline-info"><i class="icon-pencil22"></i></a>
                                        <a  href="{{url('admin-site/slider/delete/'.$row->id)}}" title="Delete" class="btn btn-sm btn-outline-info btn-darken-1"><i class="icon-cross"></i></a>
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


