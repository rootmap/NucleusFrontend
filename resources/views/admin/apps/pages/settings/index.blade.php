@extends('admin.apps.layout.master')
@section('title','Site Setting')
@section('content')
<section id="file-exporaat">
		<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-card-center">
						@if(isset($editSetting))
						<i class="icon-user-plus"></i> Edit Site Setting
						@else
						<i class="icon-user-plus"></i> Add Site Setting
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
						<form class="form" enctype="multipart/form-data" method="post" 
						@if(isset($editSetting))
							action="{{url('admin-site/setting/modify/'.$editSetting->id)}}"
						@else
							action="{{url('admin-site/setting/save')}}"
						@endif
						>
							<div class="form-body">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="eventRegInput1">Site Name <span class="text-danger">*</span></label>
									<input type="text" 
									@if(isset($editSetting))
										value="{{$editSetting->site_name}}" 
									@endif 
									 id="eventRegInput1" class="form-control border-primary" placeholder="Site Name" name="site_name">
								</div>
								<div class="form-group">
									<label for="eventRegInput1">Site Logo <span class="text-danger">*</span></label>
									<input type="file" id="eventRegInput1" class="form-control border-primary" placeholder="Site Logo" name="site_logo">
									@if(isset($editSetting))
										@if(!empty($editSetting->site_logo))
											<img style="margin-top: 10px;" width="150" src="{{url('upload/site_logo/'.$editSetting->site_logo)}}"  />
										@endif
											<input type="hidden" id="text" class="form-control border-primary" value="{{$editSetting->site_logo}}" placeholder="site_logo" name="ex_site_logo">
										
									@endif
								</div>
								<div class="form-group">
									<label for="eventRegInput1">Powered By Logo <span class="text-danger">*</span></label>
									<input type="file" id="eventRegInput1" class="form-control border-primary" placeholder="Powered By Logo" name="powered_by_logo">
									@if(isset($editSetting))
										@if(!empty($editSetting->powered_by_logo))
											<img style="margin-top: 10px;"  width="150" src="{{url('upload/powered_by_logo/'.$editSetting->powered_by_logo)}}"  />
										@endif
											<input type="hidden" id="text" class="form-control border-primary" value="{{$editSetting->powered_by_logo}}" placeholder="powered_by_logo" name="ex_powered_by_logo">
									@endif
								</div>

									<div class="form-group">
										<label for="eventRegInput2">Address <span class="text-danger">*</span></label>
										<input type="text" id="text" class="form-control border-primary" 
										@if(isset($editSetting))
										value="{{$editSetting->address}}" 
										@endif 
										placeholder="address" name="address">
									</div>	

									<div class="form-group">
										<label for="eventRegInput3">Phone <span class="text-danger">*</span></label>
										<input type="tel" 
										@if(isset($editSetting))
										value="{{$editSetting->phone}}" 
										@endif 
										id="tel" class="form-control border-primary" placeholder="1-(555)-555-5555" name="phone">
									</div>
								
									<div class="form-group">
										<label for="eventRegInput3">E-mail <span class="text-danger">*</span></label>
										<input type="email" 
										@if(isset($editSetting))
										value="{{$editSetting->email}}" 
										@endif 										
										id="eventRegInput4" class="form-control border-primary" placeholder="Email Address" name="email">
									</div>
									<div class="form-group">
										<label for="eventRegInput3">Demo Link <span class="text-danger">*</span></label>
										<input type="text" 
										@if(isset($editSetting))
										value="{{$editSetting->demo_link}}" 
										@endif 										
										id="eventRegInput4" class="form-control border-primary" placeholder="Demo Link" name="demo_link">
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

