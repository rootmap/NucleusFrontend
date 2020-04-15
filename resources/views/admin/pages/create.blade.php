@extends('admin.layout.master')
@section('title','Create')
@section('content')
<section>
			<div class="content add-details">
				<div class="in-content-wrapper">
					<div class="box">
						<div class="hotel-listing-form">
							<form class="text-left">
								<div class="form-row">
									<div class="col">
										<div class="details-text">
											<h4>Add Details</h4>
										</div><!-- end details-text -->
									</div><!-- End column -->
									<div class="col-md-6">
										<div class="breadcrumb">
											<div class="breadcrumb-item"><i class="fas fa-angle-right"></i><a href="#">Listing</a>
											</div>
											<div class="breadcrumb-item active"><i class="fas fa-angle-right"></i>All
											</div>
										</div><!-- end breadcrumb -->
									</div><!-- End column -->
								</div><!-- end row -->
							</form>
						</div>


						<div class="hotel-listing-form">
							<form class="text-center">
								<div class="form-row">
									<div class="col-md">
										<div class="form-group">
											<label for="inputGroupSelect07" class="">Room Number:</label>
											<input type="text" class="form-control" required id="inputGroupSelect07">
										</div><!-- end form-group -->
									</div><!-- end column -->
								</div><!-- end form-row -->
								<div class="form-row">
									<div class="col-md">
										<div class="form-group">
											<div class="input-group">
												<div class="input-group-prepend">
													<label class="input-group-text" for="inputGroupSelect01">AC/Non
														Ac:</label>
												</div>
												<select class="custom-select" id="inputGroupSelect01">
													<option selected>Choose...</option>
													<option value="1">AC</option>
													<option value="2" selected>Non Ac</option>
												</select>
												<i class="fas fa-angle-down"></i>
											</div>
										</div><!-- end form-group -->
									</div><!-- end column -->
									<div class="col-md">
										<div class="form-group">
											<div class="input-group">
												<div class="input-group-prepend">
													<label class="input-group-text"
														for="inputGroupSelect02">Meal:</label>
												</div>
												<select class="custom-select" id="inputGroupSelect02">
													<option selected>Choose...</option>
													<option value="1">Free Breakfast</option>
													<option value="2">Free Dinner</option>
													<option value="3">Free Breakfast & dinner</option>
													<option value="3">Free Welcome Drink</option>
													<option value="3">No Food</option>
												</select>
												<i class="fas fa-angle-down"></i>
											</div>
										</div><!-- end form-group -->
									</div><!-- end column -->
								</div><!-- end form-row -->
								<div class="form-row">
									<div class="col-md">
										<div class="form-group">
											<div class="input-group">
												<div class="input-group-prepend">
													<label class="input-group-text"
														for="inputGroupSelect03">Cancellation
														Charges:</label>
												</div>
												<select class="custom-select" id="inputGroupSelect03">
													<option selected>Choose...</option>
													<option value="1" selected>Free Cancellation</option>
													<option value="2">15% before 24 hours</option>
													<option value="2">Not Allowed</option>
												</select>
												<i class="fas fa-angle-down"></i>
											</div>
										</div><!-- end form-group -->
									</div><!-- end column -->
									<div class="col-md">
										<div class="form-group">
											<div class="input-group">
												<div class="input-group-prepend">
													<label class="input-group-text" for="inputGroupSelect04">Bed
														Capacity:</label>
												</div>
												<select class="custom-select" id="inputGroupSelect04">
													<option selected>Choose...</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="3">4</option>
													<option value="3">5</option>
													<option value="3">6</option>
													<option value="3">7</option>
													<option value="3">8</option>
													<option value="3">9</option>
												</select>
												<i class="fas fa-angle-down"></i>
											</div>
										</div><!-- end form-group -->
									</div><!-- end column -->
								</div><!-- end form-row -->
								<div class="form-row">
									<div class="col-md">
										<div class="form-group">
											<label for="inputGroupSelect05" class="">Telephone # :</label>
											<input type="text" class="form-control" required id="inputGroupSelect05">
										</div><!-- end form-group -->
									</div><!-- end column -->
									<div class="col-md">
										<div class="form-group">
											<div class="form-group">
												<label for="inputGroupSelect06" class="">Rent Per Night:</label>
												<input type="text" class="form-control" required id="inputGroupSelect06">
											</div>
										</div><!-- end form-group -->
									</div><!-- end column -->
								</div><!-- end form-row -->

								<div action="/upload" class="dropzone needsclick dz-clickable" id="demo-upload">
									<i class="fas fa-cloud-upload-alt"></i>
									<div class="dz-message needsclick">
										<p>
											Drop files here or click to upload.
										</p>
										<span class="note needsclick">(This is just a demo dropzone. Selected files are
											<strong>not</strong> actually uploaded.)</span>
									</div>

								</div><!-- end dropzone -->

								<div class="form-group">
									<textarea class="form-control textarea text-left p-3 h-100"
										id="exampleFormControlTextarea1" rows="5" placeholder="Room Details"></textarea>
								</div><!-- end form-group -->
								<ul class="list-inline">
									<li class="list-inline-item">
										<button type="submit" class="btn">Submit</button>
									</li>
									<li class="list-inline-item">
										<button type="submit" class="btn">Cancel</button>
									</li>
								</ul>

							</form>
						</div><!-- end hotel-listing-form -->
					</div><!-- end box -->
				</div><!-- end in-content-wrapper -->
			</div><!-- end add-details -->
		</section>
@endsection