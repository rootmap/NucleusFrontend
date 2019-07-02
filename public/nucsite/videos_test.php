<?php
include('./cms-admin/class/db_Class.php');
$obj = new db_class();
?>
<!DOCTYPE html>
<html>

    <head>
        <title>POS for iPhone Repair & Computer Repair - Nucleus POS</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="google-site-verification" content="XQGhdONr-3HHTI1nwwqg24Z9_7QOOuENoFCzKx7tb4s">
        <meta property="og:title" content="The Ultimate Retail Point of Sale">
        <meta property="og:site_name" content="Nucleus">
        <meta property="og:url" content="#">
        <meta property="og:description" content="Nucleus Retail is more than just a cash register. It will let you run your business from any device.">
        <meta property="og:image" content="images/retail-hero-image.jpg">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="The Ultimate Retail Point of Sale">
        <meta name="twitter:description" content="Nucleus Retail is more than just a cash register. It will let you run your business from any device.">
        <meta name="twitter:creator" content="@Nucleuspos">
        <meta name="twitter:site" content="@Nucleuspos">
        <meta name="twitter:image" content="images/retail-hero-image.jpg">
        <meta name="description" content="Choose a price that fits your budget. Nucleus offers three POS retail software subscription levels. Visit us today to see what we can do for you.">
        <meta name="keywords" content="pos subscription, point of sale software, pos prices, point of sale prices">
        <link href="css/style.css?1419368534" media="screen" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700" rel="stylesheet" type="text/css">
        <link rel="canonical" href="#">
        <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    </head>

    <body class="retail retail_pricing retail_pricing_index">
        <div id="sharedmenu--" class="position-static-top black-text">
            <div class="menu-phone">
                <h6><span class="phone-icon"></span><span class="number">(248)480-7003</span></h6></div>
            <nav class="clearfix">
                <?php include('include/quick_link.php'); ?>
            </nav>
        </div>
        <?php //include('include/menu.php'); ?>
        <div class="content" role="main" id="pricing">
            <section class="primary"></section>
            <?php include('include/menu2.php'); ?>
            <section class="primary">
                <section style="padding-top:20px" class="plans"></section>
                <br>
                
                <section class="secondary">
                    <br>
                    <br>
                    <h2 style="font-family: monospace; text-align: center;  font-style: italic;">Nucleus POS Tutorials</h2>
                    <hr class="fade">
                </section>
                
           

                <?php
                $sqlvideolist = $obj->FlyQuery("SELECT * FROM `tutorial_video`");
                if (!empty($sqlvideolist)) {
                    ?>

                    <div class="clearfix" style="clear: both; display: block; margin-top: -60px;">
                        <div style="width: 70%; float: left;">
                            











<link href="jplayer/skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jplayer/lib/jquery.min.js"></script>
<script type="text/javascript" src="jplayer/dist/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="jplayer/dist/add-on/jplayer.playlist.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){

	new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer_1",
		cssSelectorAncestor: "#jp_container_1"
	}, [
		{
			title:"Big Buck Bunny Trailer",
			artist:"Blender Foundation",
			free:true,
			m4v: "http://nucleuspos.com/cms-admin/vd/server/php/files/nuc1490910300.mp4",
			poster:"http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png"
		}
	], {
		swfPath: "jplayer/dist/jplayer",
		supplied: "webmv, ogv, m4v",
		size: {
        		width: "638px",
                height: "360px",
                cssClass: "jp-video-360p"
        },
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true
	});

});
//]]>
</script>


<div id="jp_container_1" class="jp-video jp-video-360p" role="application" aria-label="media player">
	<div class="jp-type-playlist">
		<div id="jquery_jplayer_1" class="jp-jplayer"></div>
		<div class="jp-gui">
			<div class="jp-video-play">
				<button class="jp-video-play-icon" role="button" tabindex="0">play</button>
			</div>
			<div class="jp-interface">
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
				<div class="jp-controls-holder">
					<div class="jp-controls">
						<button class="jp-previous" role="button" tabindex="0">previous</button>
						<button class="jp-play" role="button" tabindex="0">play</button>
						<button class="jp-next" role="button" tabindex="0">next</button>
						<button class="jp-stop" role="button" tabindex="0">stop</button>
					</div>
					<div class="jp-volume-controls">
						<button class="jp-mute" role="button" tabindex="0">mute</button>
						<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div>
					<div class="jp-toggles">
						<button class="jp-repeat" role="button" tabindex="0">repeat</button>
						<button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
						<button class="jp-full-screen" role="button" tabindex="0">full screen</button>
					</div>
				</div>
				<div class="jp-details">
					<div class="jp-title" aria-label="title">&nbsp;</div>
				</div>
			</div>
		</div>
		<div class="jp-playlist">
			<ul>
				<!-- The method Playlist.displayPlaylist() uses this unordered list -->
				<li>&nbsp;</li>
			</ul>
		</div>
		<div class="jp-no-solution">
			<span>Update Required</span>
			To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		</div>
	</div>
</div>





















                        </div>
                        <div id="rounded-list"  style="width: 28.8%; height: 470px; overflow-y: scroll;  float: right;">

                            <div style="width: 98%;">
                                <ol class="rounded-list" style="margin-left: -5px;">
                                    <?php
                                    foreach ($sqlvideolist as $video):
                                        ?>    
                                    <li><a  href="<?php echo $obj->filename() . "?video=" .  str_replace(".mp4", "", $video->name) . "&video_title=" .$video->title; ?>"><span class="spalink"><?php echo $video->title; ?></span></a></li>
                                        <?php
                                    endforeach;
                                    ?>
                                </ol>
                            </div>
                            <style type="text/css">
                                ol {
                                    counter-reset:li; /* Initiate a counter */
                                    list-style:none; /* Remove default numbering */
                                    *list-style:decimal; /* Keep using default numbering for IE6/7 */
                                    font: 15px 'trebuchet MS', 'lucida sans';
                                    padding: 0;
                                    margin-bottom: 4em;
                                    text-shadow: 0 1px 0 rgba(255,255,255,.5);
                                }


                                .spalink{ line-height: 20px; display: block; height:40px; overflow: hidden; }

                                .rounded-list a{
                                    position: relative;
                                    display: block;
                                    padding: .4em .4em .4em 2em;

                                    *padding: .4em;
                                    margin: .5em 0;
                                    background: #ddd;
                                    color: #444;
                                    text-decoration: none;
                                    border-radius: .3em;
                                    transition: all .3s ease-out;   
                                }

                                .rounded-list a:hover{
                                    background: #eee;
                                }

                                .rounded-list a.active{
                                    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#eeeeee+0,cccccc+100;Gren+3D */
                                    background: #eeeeee; /* Old browsers */
                                    background: -moz-linear-gradient(top,  #eeeeee 0%, #cccccc 100%); /* FF3.6-15 */
                                    background: -webkit-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* Chrome10-25,Safari5.1-6 */
                                    background: linear-gradient(to bottom,  #eeeeee 0%,#cccccc 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                                    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#cccccc',GradientType=0 ); /* IE6-9 */
                                    font-weight: bolder;
                                }

                                .rounded-list a:hover:before{
                                    transform: rotate(360deg);  
                                }

                                .rounded-list a:before{
                                    content: counter(li);
                                    counter-increment: li;
                                    position: absolute; 
                                    left: -1.3em;
                                    top: 50%;
                                    margin-top: -1.5em;
                                    background: #87ceeb;
                                    height: 2em;
                                    width: 2em;
                                    line-height: 2em;
                                    border: .3em solid #fff;
                                    text-align: center;
                                    font-weight: bold;
                                    border-radius: 2em;
                                    transition: all .3s ease-out;
                                    
                                }

                            </style>    


                        </div>



                        


                    </div>
                <?php } ?>









            </section>
        </div>
        <div align="center">
            

            <style type="text/css">
                .videorandom{
                    overflow: hidden; width: 200px; height: 160px; display: inline-block; margin:10px; 
                    -webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);
                    -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);
                    box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);

                }
                .tuplay{ opacity: 0.3; position: absolute; top: 0; left:0; margin-left: 70px; margin-top:-85px;  }
                .videorandom a .tuimg
                {
                    opacity:1;
                }

                .videorandom:hover a .tuimg
                {
                    opacity:0.2;
                    -webkit-transition: opacity 1s ease-in-out;
                    -moz-transition: opacity 1s ease-in-out;
                    -ms-transition: opacity 1s ease-in-out;
                    -o-transition: opacity 1s ease-in-out;
                }

                .videorandom:hover a .tuplay
                {
                    opacity: 1;
                    -webkit-transition: opacity 1s ease-in-out;
                    -moz-transition: opacity 1s ease-in-out;
                    -ms-transition: opacity 1s ease-in-out;
                    -o-transition: opacity 1s ease-in-out;

                }

                .videorandom:hover a .videorandomtext
                {
                    font-weight: bold;
                    color: #70C0C4;
                }



            </style>    

            <section class="clearfix">

                <section class="secondary">
                    <br>
                    <br>
                    <h2 style="font-family: monospace; font-style: italic; font-weight: bolder;">Similar Tutorials</h2>
                    <hr class="fade">
                </section>
                <div style="margin-top: -40px;" class="small-12 columns clearfix">
                    <?php
                    $sqlandomvideo = $obj->FlyQuery("SELECT * FROM `tutorial_video` ORDER BY RAND() LIMIT 12");
                    if (!empty($sqlandomvideo)) {
                        foreach ($sqlandomvideo as $rv):
                            ?>
                            <article  style="" class="columns videorandom">
                                <a href="<?php echo $obj->filename() . "?video=" .  str_replace(".mp4", "", $rv->name) . "&video_title=" .$rv->title; ?>">
                                    <img class="tuimg" width="200" height="130" src="images/Checkin3.png">
                                    <img class="tuplay" width="70" src="images/video-play-3-512.png" style="">
                                    <div class="videorandomtext" style="display: block;"><?php echo $rv->title; ?></div>
                                </a>
                            </article>
                            <?php
                        endforeach;
                    }
                    ?>
                </div>
            </section>
            
            <section class="cta clearfix">
                <div class="small-12 columns clearfix">
                    <article class="cta_text small-12 medium-6 columns">
                        <h3>Step your store into the future. Try Nucleus Today.</h3>

                    </article>
                    <article class="button no-foundation small-12 medium-6 columns">
                        <div class="demo-download-button"><a href="http://nucleuspos.com/signup.php" class="demo-button-iframe">Start Your Free Trial</a></div>
                    </article>


                </div>
            </section>



            <?php include('include/footer.php'); ?>

        </div>
    </body>

</html>