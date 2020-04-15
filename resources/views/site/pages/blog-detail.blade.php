@extends('site.layout.index')
@section('title','Blog')
@section('content')

  
			<!--====| Shuffle Gallery Style Sta rt|====--> 
		<section class="blog">
			<div class="container">
				<div class="col-sm-6 col-md-8 col-lg-8">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="panel panel-default">
									<div class="panel-body" style="text-align: left !important;">
										<p style="font-weight: 600; font-size: 18px; text-align: left; margin-top:3px;">
										{{$Blogs->heading}}
										</p>
										<p class="" style="color: #323232; font-size: 12px; text-align: left; margin-top: 0px;"> <span class="fa fa-user" aria-hidden="true"></span> MD MAHAMUDUR | <span class="fa fa-eye" aria-hidden="true"></span> {{$Blogs->views}} | <span class="fa fa-calendar" aria-hidden="true"></span> {{formatDate($Blogs->created_at)}}</p>
										<p style="margin-top: 3px; text-align: left;">
											
											{!!$Blogs->detail!!}



										</p>

										<hr />

										<h3>Leave a Reply</h3>
										<p>Your email address will not be published. Required fields are marked *</p>

										<form action="{{url('save/blog/comment')}}" method="POST">
											{{csrf_field()}}
											<div class="row" style="margin-top: 0px;">
												<div class="col-md-12">
													<div class="form-group">
									                    <label for="exampleInputEmail1">Comment *</label>
									                    <textarea name="comment" class="form-control" id="exampleInputEmail1" placeholder="Enter Your Comment" rows="5"></textarea>
								                  	</div>
												</div>
											</div>

											<div class="row" style="margin-top: 0px;">
												<div class="col-md-4">
													<div class="form-group">
									                    <label for="exampleInputEmail1">Name *</label>
									                    <input type="text" name="name" class="form-control" id="exampleInputPassword1" placeholder="Name">
									                    <input type="hidden" name="blog_id" value="{{$Blogs->id}}">
								                  	</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
									                    <label for="exampleInputEmail1">Email *</label>
									                    <input type="text" name="email" class="form-control" id="exampleInputPassword1" placeholder="Email">
								                  	</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
									                    <label for="exampleInputEmail1">Website</label>
									                    <input type="text" name="website" class="form-control" id="exampleInputPassword1" placeholder="Website">
								                  	</div>
												</div>
											</div>
											<div class="row" style="margin-top: 0px;">
												<div class="col-md-12">
													<button type="submit" class="btn btn-primary pull-right">Post Comment</button>
												</div>
												
											</div>
										</form>

										@if(count($BlogComment)>0)
											<h4>Comments ({{count($BlogComment)}})</h4>
											<hr style="margin-bottom: 0px;" />
											@foreach($BlogComment as $row)
											<blockquote style="margin: 0 0 0px; border-right: 5px solid #eee;">
												<div class="row">
													<div class="col-md-6" style="font-weight: 700;">
														<span class="fa fa-user" aria-hidden="true"></span> {{$row->name}}
													</div>
													<div class="col-md-6" style="text-align: right; font-weight: 700;">
														<span class="fa fa-calendar" aria-hidden="true"></span> {{formatDate($row->created_at)}}
													</div>
													<div class="col-md-12">
														{{$row->comment}}
													</div>
												</div>
											</blockquote>
											<hr style="margin-top: 0px; margin-bottom: 0px;" />
											@endforeach
										@endif
										
									</div>
							</div>
						</div>
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

label {
    display: inline-block;
    margin-bottom: 5px;
    font-weight: 500;
}

.form-control
{
	border-radius: 0px !important;
}

</style>
@endsection

@section('js')
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
      @if(Session::has('success'))
        <script type="text/javascript">
          Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: '{{ Session::get('success') }}'
              });
              $(".swal2-container").css('z-index',99999);
        </script>
      @endif

      @if(Session::has('error'))
        <script type="text/javascript">
          Swal.fire({
                  icon: 'warning',
                  title: 'Warning',
                  text: '{{ Session::get('error') }}'
              });
              $(".swal2-container").css('z-index',99999);
        </script>
      @endif

      @if (count($errors) > 0)
         <?php $dataConeCat=''; ?>
           @foreach ($errors->all() as $error)
           <?php 
           if(!empty($dataConeCat))
           {
            $dataConeCat.=','; 
           }

           $dataConeCat.=$error; 

           ?>
          @endforeach
          <script type="text/javascript">
          Swal.fire({
                  icon: 'warning',
                  title: 'Warning',
                  text: '{{ $dataConeCat }}'
              });
              $(".swal2-container").css('z-index',99999);
        </script>
      @endif
@endsection