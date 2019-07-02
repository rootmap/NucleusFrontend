@extends('admin.apps.layout.master')
@section('title','Retail Content')
@section('content')
<section id="file-exporaat">
		<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						@if(isset($editSetting))
						<i class="icon-user-plus"></i> Edit Retail
						@else
						<i class="icon-user-plus"></i> Add Retail
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
						<form class="form" enctype="multipart/form-data"  method="post" 
						@if(isset($editSetting))
							action="{{url('admin-site/retail/modify/'.$editSetting->id)}}"
						@else
							action="{{url('admin-site/retail/save')}}"
						@endif
						>
							<div class="form-body">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="eventRegInput1">Title <span class="text-danger">*</span></label>
									<input type="text" 
									@if(isset($editSetting))
										value="{{$editSetting->title}}" 
									@endif 
									 id="eventRegInput1" class="form-control border-primary" placeholder="Name" name="title">
								</div>
								<div class="form-group">
									<label for="eventRegInput1">Retail Image <span class="text-danger">*</span></label>
									<input type="file" id="eventRegInput1" class="form-control border-primary" placeholder="Customer Name" name="image">
									@if(isset($editSetting))
										@if(!empty($editSetting->image))
											<img style="margin-top: 10px;" width="150" src="{{url('upload/retail_image/'.$editSetting->image)}}"  />
										@endif
											<input type="hidden" id="text" class="form-control border-primary" value="{{$editSetting->image}}" placeholder="site_logo" name="ex_image">
										
									@endif
								</div>
								
								<div class="form-group">
									<label for="eventRegInput3">Details <span class="text-danger">*</span></label>
									<textarea class="form-control border-primary" placeholder="Details" name="details" rows="5">@if(isset($editSetting)){{$editSetting->details}}@endif</textarea> 
								</div>

							
							</div>

							<div class="form-actions center">
								<button type="button" class="btn btn-info btn-darken-2 mr-1">
									<i class="icon-cross2"></i> Cancel
								</button>
								@if(isset($editSetting))
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

