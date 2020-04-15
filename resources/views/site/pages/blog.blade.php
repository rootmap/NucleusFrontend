@extends('site.layout.index')
@section('title','Blog')
@section('content')

  
			<!--====| Shuffle Gallery Style Sta rt|====--> 
		<section class="blog">
			<div class="container">
				<div class="col-sm-6 col-md-8 col-lg-8">
					<div class="row">
						@if(count($Blogs)>0)
							@foreach($Blogs as $row)
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="panel panel-default">
									<div class="">
										<img  src="{{url('upload/blogs/small/'.$row->blog_primary_image)}}" alt="" class="" style="height: 200px; width: 100%;">
										<div class="panel-body">
											<p class="" style="color: #323232; font-size: 12px; text-align: left;"> <span class="fa fa-user" aria-hidden="true"></span> {{$row->blog_creator_name}} | <span class="fa fa-eye" aria-hidden="true"></span> 50 | <span class="fa fa-calendar" aria-hidden="true"></span> {{formatDate($row->created_at)}}</p>
											<p style="font-weight: 600; font-size: 18px; text-align: left; margin-top:3px;">{{$row->heading}}</p>
											<p style="margin-top: 3px; text-align: justify;">{{$row->short_detail}}</p>
											<a style="right: 27px;
	    margin-top: -23px; position: absolute;" href="{{url('blog/'.$row->link)}}" class="blog-clean-btn" style=""><i class="fas fa-chevron-right"></i> Read more</a>
										</div>

									</div>
								</div>
							</div>
							@endforeach
						@endif

				
						</div>
					</div>

					<div class="col-sm-6 col-md-4 col-lg-4">
						<div class="panel panel-default">
							<div class="panel-body">





								<h4 class="text-center">Popular Posts!</h4>
								<hr  style="margin-top: 15px;" />
								@if(count($populer)>0)
									<?php $i=1; ?>
									@foreach($populer as $row)
										@if($i>1)
											<hr style="margin-top: 15px;">
										@endif
										<a class="row" style="margin-top: 15px; text-decoration: none; color: #323232;" 
										href="{{url('blog/'.$row->link)}}">
											<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
												<img src="{{url('upload/blogs/populer/'.$row->blog_primary_image)}}" alt="" class="img-thumbnail img-responsive">
											</div>
											<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
												<h5 style="text-align: left; padding-top: 0px; margin-top: 0px;">{{$row->heading}}</h5>
												<p style="margin-top: 3px; font-size:11px; text-align: justify;">
													{{substr($row->short_detail,0,100)}}
												</p>
												<p style="text-align: left; margin-top: 3px; "><span class="fa fa-calendar" aria-hidden="true"></span> {{formatDate($row->created_at)}}</p>
											</div>
										</a>
										<?php $i++; ?>
									@endforeach
								@endif
								



							</div>
						</div>
					</div>
				</div>
			</section> 


@endsection

@section('css')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<style type="text/css">
	.page-header {
    padding-bottom: 9px;
    margin: 0px 0 0px;
    border-bottom: 1px solid #eee;
}
</style>
@endsection