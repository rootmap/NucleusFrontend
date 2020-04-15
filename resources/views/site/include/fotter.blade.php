<script src="{{url('site/js/core.min.js')}}"></script>
<script src="{{url('site/js/script.js')}}"></script>
<!-- coded by jeremyluis-->
 <!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="{{url('site/fancybox/lib/jquery.mousewheel.pack.js')}}"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="{{url('site/fancybox/source/jquery.fancybox.css?v=2.1.7')}}" type="text/css" media="screen" />
<script type="text/javascript" src="{{url('site/fancybox/source/jquery.fancybox.pack.js?v=2.1.7')}}"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="{{url('site/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5')}}" type="text/css" media="screen" />
<script type="text/javascript" src="{{url('site/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5')}}"></script>
<script type="text/javascript" src="{{url('site/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6')}}"></script>

<link rel="stylesheet" href="{{url('site/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7')}}" type="text/css" media="screen" />
<script type="text/javascript" src="{{url('site/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7')}}"></script>
<!-- Wow Js -->
<script type="text/javascript" src="{{url('site/js/wow.min.js')}}"></script>

<script type="text/javascript">
  function backtoTop()
  {
    $("html, body").animate({scrollTop: 0}, 1200);
  }
  $(document).ready(function(){
    $('a.video').click(function() {
      
      $.fancybox.open({type: 'iframe', href: $(this).attr('href'), openEffect: 'none', closeEffect: 'none', padding: 0, height: 450, helpers: {media: {}}, afterShow: function() {
        setTimeout(function() {
          $('div.fancybox-close').animate({right: -42}, 500, 'easeOutBounce');
        }, 300);
      }});
      return false;
    });

  });
</script>