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
							action="{{url('admin-site/business-reports/modify/'.$edit->id)}}"
						@else
							action="{{url('admin-site/business-reports/save')}}"
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
									<label for="eventRegInput1">Background Image <span class="text-danger">*</span></label>
									<input type="file" id="eventRegInput1" class="form-control border-primary" placeholder="Background Image" name="background_image">
									@if(isset($edit))
										
											<img style="margin-top: 10px;" height="150" width="150" src="{{url('upload/business-reports/'.$edit->background_image)}}"  />
										
											<input type="hidden" id="text" class="form-control border-primary" value="{{$edit->background_image}}"  name="ex_image">
										
									@endif
								</div>
								<div class="form-group">
									<label for="eventRegInput3">Details <span class="text-danger">*</span></label>
									<textarea class="form-control border-primary" placeholder="Details" name="detail" rows="5">@if(isset($edit)){{$edit->detail}}@endif 	</textarea> 
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


</section>
@endsection

