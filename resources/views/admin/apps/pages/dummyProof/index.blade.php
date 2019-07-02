@extends('admin.apps.layout.master')
@section('title','Dummy Proof')
@section('content')
<section id="file-exporaat">
		<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						@if(isset($editSetting))
						<i class="icon-user-plus"></i> Edit Dummy Proof
						@else
						<i class="icon-user-plus"></i> Add Dummy Proof
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
						<form enctype="multipart/form-data"  class="form" method="post" 
						@if(isset($editSetting))
							action="{{url('admin-site/dummy-proof/modify/'.$editSetting->id)}}"
						@else
							action="{{url('admin-site/dummy-proof/save')}}"
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
									<label for="eventRegInput1">Dummy Proof Image <span class="text-danger">*</span></label>
									<input type="file" id="eventRegInput1" class="form-control border-primary" placeholder="Customer Name" name="dummy_proof_image">
									@if(isset($editSetting))
										@if(!empty($editSetting->image))
											<img style="margin-top: 10px;" width="150" src="{{url('upload/dummy_proof_image/'.$editSetting->image)}}"  />
										@endif
											<input type="hidden" id="text" class="form-control border-primary" value="{{$editSetting->image}}" placeholder="site_logo" name="ex_dummy_proof_image">
										
									@endif
								</div>
								<div class="form-group">
									<label for="eventRegInput1">Background Image <span class="text-danger">*</span></label>
									<input type="file" id="eventRegInput1" class="form-control border-primary" placeholder="Customer Name" name="dummy_proof_background_image">
									@if(isset($editSetting))
										@if(!empty($editSetting->background_image))
											<img style="margin-top: 10px;"  width="150" src="{{url('upload/dummy_proof_background_image/'.$editSetting->background_image)}}"  />
										@endif
											<input type="hidden" id="text" class="form-control border-primary" value="{{$editSetting->background_image}}" placeholder="powered_by_logo" name="ex_dummy_proof_background_image">
									@endif
								</div>
								<div class="form-group">
									<label for="eventRegInput3">Details <span class="text-danger">*</span></label>
									<textarea class="form-control border-primary" placeholder="Details" name="short_details" rows="5">@if(isset($editSetting)){{$editSetting->short_details}}@endif 	</textarea> 
								</div>
								<div class="form-group" style="display: none;">
									<label for="eventRegInput3">Long Details <span class="text-danger">*</span></label>
									<textarea class="form-control border-primary" placeholder="Details" name="long_details" rows="5">@if(isset($editSetting)){{$editSetting->long_details}}@endif</textarea> 
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

