<?php
include('class/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>        
    </head>
    <body>
        <?php include('include/header.php'); ?>
        <!-- Main wrapper -->
        <div class="wrapper three-columns">
            <!-- Left sidebar -->
            <?php include('include/sidebar_left.php'); ?>
            <!-- /left sidebar -->
            <!-- Main content -->
            <div class="content">

                <!-- Info notice -->
                <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="font-film"></i> Help Desk Video - <?php echo $_GET['inc']; ?> </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
                                <!-- Content Start from here customized -->


                                <style type="text/css">
                                    .jp-jplayer{ min-width: 528px !important; }   
                                    #jp_video_0{ min-width: 528px !important; }
                                </style>


                                <!-- General form elements -->
                                <div class="row-fluid span12" style="padding-top: 5px;">     
                                    <div class="span8">
                                        <div id="jp_container_N" class="jp-video jp-video-270p" style="width: 528px;" role="application" aria-label="media player">
                                            <div class="jp-type-playlist">
                                                <div id="jquery_jplayer_N" class="jp-jplayer"></div>
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
                                                        <div class="jp-details">
                                                            <div class="jp-title" aria-label="title">&nbsp;</div>
                                                        </div>
                                                        <div class="jp-controls-holder">
                                                            <div class="jp-volume-controls">
                                                                <button class="jp-mute" role="button" tabindex="0">mute</button>
                                                                <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                                                <div class="jp-volume-bar">
                                                                    <div class="jp-volume-bar-value"></div>
                                                                </div>
                                                            </div>
                                                            <div class="jp-controls">
                                                                <button class="jp-previous" role="button" tabindex="0">previous</button>
                                                                <button class="jp-play" role="button" tabindex="0">play</button>
                                                                <button class="jp-stop" role="button" tabindex="0">stop</button>
                                                                <button class="jp-next" role="button" tabindex="0">next</button>
                                                            </div>
                                                            <div class="jp-toggles">
                                                                <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                                                <button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
                                                                <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="jp-playlist">
                                                    <ul>
                                                        <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                                                        <li></li>
                                                    </ul>
                                                </div>
                                                <div class="jp-no-solution">
                                                    <span>Update Required</span>
                                                    To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <div class="page-header"><!-- Page header -->
                                            <h5><i class="font-film"></i> Related Videos </h5>
                                            <ul class="icons">
                                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="well-white body">

                                            <ul class="check-list">
                                                <?php
                                                $sqlvideo = $obj->FlyQuery("SELECT * FROM tutorial_video WHERE title LIKE '%" . $_GET['inc'] . "%' OR title LIKE '%" . substr($_GET['inc'], 0, 5) . "%' ORDER BY id DESC");
                                                if (!empty($sqlvideo)) {
                                                    foreach ($sqlvideo as $video):
                                                        ?>
                                                        <li><a href="<?php echo $obj->filename(); ?>?embeded=<?php echo $video->id; ?>&view=<?php echo $video->name; ?>&inc=<?php echo $video->title; ?>"><?php echo $video->title; ?></a></li>
                                                        <?php
                                                    endforeach;
                                                }

                                                /*
                                                  create table video_comment
                                                  (
                                                  id int(20) AUTO_INCREMENT PRIMARY KEY,
                                                  video_id int(20),
                                                  user_id int(20),
                                                  `comment` text,
                                                  date_time timestamp,
                                                  date date,
                                                  status int(2)
                                                  )
                                                 */
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- /general form elements -->     


                                <div class="clearfix"></div>

                                <div class="block well">
                                    <div class="navbar">
                                        <div class="navbar-inner">
                                            <h5><i class="icon-comment"></i> Some question &AMP; answer regarding - <?php echo $_GET['inc']; ?> | You can place your question or answer too.</h5>
                                        </div>
                                    </div>
                                    <div class="body">
                                        <!-- Enter message input -->
                                        <div class="enter-message">
                                            <textarea name="enter-message"  onKeydown="Javascript: if (event.keyCode == 13)
                                                        SendVideoComment('<?php echo $_GET['embeded']; ?>', this.value);"   class="auto" rows="1" cols="1" placeholder="Please type your message and press enter."></textarea>
                                        </div>
                                        <!-- /enter message input -->    
                                        <div id="timeline-messages" class="timeline-messages" style="margin-top: 10px;">

                                            <?php
                                            $comments = '';
                                            $sqlcomments = $obj->FlyQuery("SELECT a.*,s.name,IFNULL(s.image,'avater.png') as image,s.status as user_type FROM video_comment as a
                                                                            LEFT JOIN store as s ON s.id=a.user_id
                                                                            WHERE a.video_id='" . $_GET['embeded'] . "' AND a.status='1' ORDER BY a.id DESC LIMIT 30");
                                            if (!empty($sqlcomments)) {

                                                foreach ($sqlcomments as $comm):

                                                    if ($comm->user_type == 1) {
                                                        $user_label = "System Admin";
                                                    } elseif ($comm->user_type == 2) {
                                                        $user_label = "Store Admin";
                                                    } elseif ($comm->user_type == 3) {
                                                        $user_label = "Store Cashier";
                                                    } elseif ($comm->user_type == 4) {
                                                        $user_label = "Store Manager";
                                                    } elseif ($comm->user_type == 5) {
                                                        $user_label = "Store Chain Admin";
                                                    }

                                                    $comments .='<div class="message">
                                                                    <a class="message-img" href="#"><img src="store/' . $comm->image . '" alt="" /></a>
                                                                    <div class="message-body">
                                                                        <div class="text"><p>' . $comm->comment . '</p></div>
                                                                        <p class="attribution">by <a href="javascript:void(0);">' . $comm->name . ' | '.$user_label.'</a> at ' . date_format(date_create($comm->date_time), 'H:i A, d M Y') . '</p>
                                                                    </div>
                                                                </div>';
                                                endforeach;
                                            }

                                            echo $comments;
                                            ?>

                                        </div>​



                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <!-- Default datatable -->

                                <!-- /default datatable -->





                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div> 



                            </div>
                            <!-- /content container -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
<?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
<?php //include('include/sidebar_right.php');     ?>
            <!-- /right sidebar -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php
if ($obj->SelectAllByVal("video_player", "status", "1", "id") == 1) {
    ?>
                <link href="jpv/dist/skin/blue.monday/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />
            <?php } else { ?>
                <link href="jpv/dist/skin/pink.flag/css/jplayer.pink.flag.min.css" rel="stylesheet" type="text/css" />
            <?php } ?>

            <script type="text/javascript" src="jpv/dist/jplayer/jquery.jplayer.min.js"></script>
            <script type="text/javascript" src="jpv/dist/add-on/jplayer.playlist.min.js"></script>
            <script type="text/javascript">
                                                //<![CDATA[
                                                function SendVideoComment(video, comment)
                                                {
                                                    if (comment != '')
                                                    {
                                                        $("textarea[name=enter-message]").val("");

                                                        $.ajax({
                                                            url: "ajax/video.php",
                                                            type: "POST",
                                                            data: {'st': 1, 'video_id': video, 'comment': comment},
                                                            dataType: "json",
                                                            success: function (result) {
                                                                if (result == 1)
                                                                {
                                                                    $.jGrowl('Post your comment. ', {sticky: false, theme: 'growl-success', header: 'Thank You. Successfully!'});
                                                                    $.jGrowl('Please Wait... ', {sticky: false, theme: 'growl-info', header: 'Loading your commnet.'});
                                                                    $.ajax({
                                                                        url: "ajax/video.php",
                                                                        type: "POST",
                                                                        data: {'st': 2, 'video_id': video},
                                                                        dataType: "json",
                                                                        success: function (resultd) {
                                                                            console.log(resultd);
                                                                            //var datacl=jQuery.parseJSON(resultd);
                                                                            $("#timeline-messages").html(resultd.content);
                                                                        },
                                                                        error: function (xhr, ajaxOptions, thrownError) {
                                                                            $.jGrowl('Failed to load your comments.', {sticky: false, theme: 'growl-error', header: 'Error!'});
                                                                        }
                                                                    });
                                                                }
                                                                else
                                                                {
                                                                    $.jGrowl('Failed,Please try again.', {sticky: false, theme: 'growl-error', header: 'Error!'});
                                                                }
                                                            },
                                                            error: function (xhr, ajaxOptions, thrownError) {
                                                                //alert(xhr.status);
                                                                //alert(thrownError);
                                                                $.jGrowl('Failed,Please try again.', {sticky: false, theme: 'growl-error', header: 'Error!'});
                                                            }
                                                        });
                                                    }
                                                }

                                                nucleus(document).ready(function () {
                                                    var myPlaylist = new jPlayerPlaylist({
                                                        jPlayer: "#jquery_jplayer_N",
                                                        cssSelectorAncestor: "#jp_container_N"
                                                    }, [{
                                                            title: "<?php echo $_GET['inc']; ?>",
                                                            artist: "Nucleuspos Tutorials",
                                                            m4v: "vd/server/php/files/<?php echo $_GET['view']; ?>",
                                                            poster: "images/thm.png"
                                                        }], {
                                                        playlistOptions: {
                                                            enableRemoveControls: true
                                                        },
                                                        swfPath: "jpv/dist/jplayer",
                                                        supplied: "webmv, ogv, m4v, oga, mp3",
                                                        useStateClassSkin: true,
                                                        autoBlur: true,
                                                        smoothPlayBar: true,
                                                        keyEnabled: true,
                                                        audioFullScreen: true
                                                    });

                                                    // Click handlers for jPlayerPlaylist method demo



                                                    // Video mix playlist

                                                    nucleus("#playlist-setPlaylist-video-mix").click(function () {
                                                        myPlaylist.setPlaylist([
                                                            {
                                                                title: "Big Buck Bunny Trailer",
                                                                artist: "Blender Foundation",
                                                                m4v: "http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer.m4v",
                                                                ogv: "http://www.jplayer.org/video/ogv/Big_Buck_Bunny_Trailer.ogv",
                                                                webmv: "http://www.jplayer.org/video/webm/Big_Buck_Bunny_Trailer.webm",
                                                                poster: "http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png"
                                                            },
                                                            {
                                                                title: "Finding Nemo Teaser",
                                                                artist: "Pixar",
                                                                m4v: "http://www.jplayer.org/video/m4v/Finding_Nemo_Teaser.m4v",
                                                                ogv: "http://www.jplayer.org/video/ogv/Finding_Nemo_Teaser.ogv",
                                                                webmv: "http://www.jplayer.org/video/webm/Finding_Nemo_Teaser.webm",
                                                                poster: "http://www.jplayer.org/video/poster/Finding_Nemo_Teaser_640x352.png"
                                                            }
                                                        ]);
                                                    });

                                                    // Videos

                                                    nucleus(".playlist-add-tutorials").click(function () {

                                                        myPlaylist.add({
                                                            title: "Big Buck Bunny Trailer",
                                                            artist: "Blender Foundation",
                                                            m4v: "http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer.m4v",
                                                            ogv: "http://www.jplayer.org/video/ogv/Big_Buck_Bunny_Trailer.ogv",
                                                            webmv: "http://www.jplayer.org/video/webm/Big_Buck_Bunny_Trailer.webm",
                                                            poster: "http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png"
                                                        });
                                                    });





                                                    // AVOID COMMANDS

                                                    nucleus("#playlist-avoid-1").click(function () {
                                                        myPlaylist.remove(2); // Removes the 3rd item
                                                        myPlaylist.remove(3); // Ignored unless removeTime=0: Where it removes the 4th item, which was originally the 5th item.
                                                    });


                                                });
                                                //]]>
            </script>
        </div>
        <!-- /main wrapper -->

    </body>
</html>
