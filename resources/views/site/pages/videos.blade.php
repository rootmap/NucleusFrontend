@extends('site.layout.index')
@section('title','Videos')
@section('content')
<?php 
function getYouTubeThumbnailImage($video_id) {
    return "http://i3.ytimg.com/vi/$video_id/hqdefault.jpg";
}
?>
<div class="container">
        <div class="row">
            @if(count($video)>0)
                @foreach($video as $row)
                    <?php 
                        $imgID=$row->youtube_link_id;
                        $imgLink=getYouTubeThumbnailImage($imgID);
                    ?>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <a data-fancybox="video-gallery" class="video-gallery" href="https://www.youtube.com/watch?v={{$row->youtube_link_id}}&amp;autoplay=1"><img src="<?php echo $imgLink; ?>"></a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
    </div>

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
    .video-gallery::after{
        content: '';
        position: absolute;
        top: 33%;
        right: 36%;
        background: url('{{url('site/images/play.png')}}') no-repeat center;
        height:100px;
        width:100px;
    }

    .video-gallery:hover::after{
        content: '';
        position: absolute;
        top: 33%;
        right: 36%;
        background: url('{{url('site/images/play.png')}}') no-repeat center;
        opacity: 0.5;
        height:100px;
        width:100px;
    }
</style>
@endsection