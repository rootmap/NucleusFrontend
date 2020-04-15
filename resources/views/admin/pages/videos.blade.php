<?php 
function getYouTubeThumbnailImage($video_id) {
    return "http://i3.ytimg.com/vi/$video_id/hqdefault.jpg";
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery Lightbox</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <h3 class="text-center">My Video Gallery</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="thumbnail">
                    <a data-fancybox="video-gallery" href="https://www.youtube.com/watch?v=APaCwk77hCc&amp;autoplay=1"><img src="<?php echo getYouTubeThumbnailImage('APaCwk77hCc'); ?>"></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumbnail">
                    <a data-fancybox="video-gallery" href="https://www.youtube.com/watch?v=UfDYBuB_yuc&amp;autoplay=1"><img src="<?php echo getYouTubeThumbnailImage('UfDYBuB_yuc'); ?>"></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumbnail">
                    <a data-fancybox="video-gallery" href="https://www.youtube.com/watch?v=Ui1G2U58zYI&amp;autoplay=1"><img src="<?php echo getYouTubeThumbnailImage('Ui1G2U58zYI'); ?>"></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="thumbnail">
                    <a data-fancybox="video-gallery" href="https://www.youtube.com/watch?v=HaBEb-kib8M&amp;autoplay=1"><img src="<?php echo getYouTubeThumbnailImage('HaBEb-kib8M'); ?>"></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumbnail">
                    <a data-fancybox="video-gallery" href="https://www.youtube.com/watch?v=yR666xOvgd0&amp;autoplay=1"><img src="<?php echo getYouTubeThumbnailImage('yR666xOvgd0'); ?>"></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumbnail">
                    <a data-fancybox="video-gallery" href="https://www.youtube.com/watch?v=KeCkEiUynPc&amp;autoplay=1"><img src="<?php echo getYouTubeThumbnailImage('KeCkEiUynPc'); ?>"></a>
                </div>
            </div>
        </div>
    </div>
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>