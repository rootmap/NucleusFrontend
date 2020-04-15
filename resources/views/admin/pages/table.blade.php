@extends('admin.layout.master')
@section('title','Table')
@section('content')
		<section>
			<div class="content listing-content">
				<div class="in-content-wrapper">
					<div class="box">
						<div class="row no-gutters" style="border-bottom: 3px #fff solid;">
							<div class="col text-left">
								<div class="add-new">
									<a href="listing-hotel-create.html">Add New<i class="fas fa-plus"></i></a>
								</div><!-- End add-new-->
							</div><!-- End column-->
							<div class="col">
								<div class="heading-messages">
									<h3 class="text-center">Hotel Listing</h3>
								</div><!-- End heading-messages -->
							</div><!-- End column -->
							<div class="col text-right">
								<div class="tools-btns">
									<a href="#"><i class="fas fa-print" data-toggle="tooltip" data-html="true"
											title="Print"></i></a>
									<a href="#"><i class="fas fa-file-pdf" data-toggle="tooltip" data-html="true"
											title="Pdf"></i></a>
									<a href="#"><i class="fas fa-file-excel" data-toggle="tooltip" data-html="true"
											title="Excel"></i></a>
								</div><!-- End tool-btns-->
							</div><!-- End text-right-->

						</div><!-- end row -->
						<div class="row no-gutters">
							<div class="col">
								<table id="example" class="display table-hover table-responsive-xl listing">
									<thead>
										<tr>
											<th>Img</th>
											<th>#</th>
											<th>Type</th>
											<th>AC/Non AC</th>
											<th>Meal</th>
											<th>Capacity</th>
											<th>Status</th>
											<th>Phone</th>
											<th>Rent</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

										<tr>
											<td><img src="images/hotel3.jpg" alt="table-img"
													class="img-fluid rounded-circle" width="40px"></td>
											<td>209</td>
											<td><a href="#">Single</a></td>
											<td><a href="#">AC</a></td>
											<td>Free Dinner</td>
											<td>1</td>
											<td class="active"><a href="#">Active</a></td>
											<td>12312335</td>
											<td>30$</td>
											<td>
												<a href="#"><i class="fas fa-edit"></i></a>
												<a href="#"><i class="fas fa-trash-alt"></i></a>
											</td>
										</tr>
										<tr>
											<td><img src="images/hotel2.jpg" alt="table-img"
													class="img-fluid rounded-circle" width="40px"></td>
											<td>209</td>
											<td><a href="#">Double</a></td>
											<td><a href="#">AC</a></td>
											<td>Free Lunch</td>
											<td>4</td>
											<td class="expired"><a href="#">Expired</a></td>
											<td>12312335</td>
											<td>45$</td>
											<td>
												<a href="#"><i class="fas fa-edit"></i></a>
												<a href="#"><i class="fas fa-trash-alt"></i></a>
											</td>
										</tr>
										

									</tbody>
								</table>
							</div><!-- end column -->
						</div><!-- end row -->
					</div><!-- end box -->
				</div><!-- end in-content-wrapper -->
			</div><!-- end listing-content -->
		</section>
@endsection

@section('css')
	<!-- Data Tables Stylesheet -->
	<link rel="stylesheet" type="text/css" href="{{asset('theme/admin-core/vendors/datatables/datatables.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('theme/admin-core/css/custom.datatables.css')}}">
	<!-- Framework Stylesheets End-->
	<!-- Font Awsome Stylesheet -->
	<link rel="stylesheet" href="{{asset('theme/admin-core/vendors/fontawesome5.7.2/css/all.min.css')}}">
@endsection

@section('js')
	<script src="{{asset('theme/admin-core/vendors/datatables/datatables.min.js')}}"></script>
	<script>
		$(document).ready(function () {
			$('#example').DataTable();
		});
	</script>
@endsection