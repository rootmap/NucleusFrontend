<?php
include('class/auth.php');
if (isset($_GET['acid'])) {
    $obj->update("video_player", array("date" => "2016-06-20", "status" => 0));
    $obj->update("video_player", array("id" => $_GET['acid'], "status" => 1));
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo"));
        ?>
        <?php //echo $obj->bodyhead(); ?>        
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
                            <h5><i class="font-film"></i> Video Player Setting </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
                                <!-- Content Start from here customized -->
                                <!-- General form elements -->
                                <div class="row-fluid span12" style="padding-top: 5px;"> 
                                    
                                    
                                    
                                    
                                    <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
  
                                          
                                            <script id="image_template" type="text/x-kendo-template">
                                                #if(id==1){
                                                    #<img src="images/white.png" class="img-responsive" />#
                                                }else{
                                                    #<img src="images/pink.png" class="img-responsive" />#
                                                }#
                                            </script>
                                            <script id="action_template" type="text/x-kendo-template">                                             
                                                #if(status==0){
                                                    #<a class="k-button" href="<?php echo $obj->filename(); ?>?acid=#=id#">Inactive</a>#
                                                }else if(status==1){
                                                    #<a class="k-button" href="<?php echo $obj->filename(); ?>?acid=#=id#">Active</a>#
                                                }#
                                            </script>
                                            <script type="text/javascript">
                                                function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                        if (c === true) {
                                                $.ajax({
                                                type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/video_player_setting.php",
                                                        data: {id: id},
                                                        success: function (result) {
                                                        $(".k-i-refresh").click();
                                                        }
                                                });
                                                }
                                                }

                                            </script>
                                            <script type="text/javascript">
                                                jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                transport: {
                                                read: {
                                                url: "./controller/video_player_setting.php",
                                                        type: "GET",
                                                        datatype: "json"

                                                }
                                                },
                                                        autoSync: false,
                                                        schema: {
                                                        data: "data",
                                                                total: "total",
                                                                model: {
                                                                id: "id",
                                                                        fields: {
                                                                        id: {type: "number"},
                                                                        name: {type: "string"},
                                                                        status: {type: "string"}
                                                                        }
                                                                }
                                                        },
                                                        pageSize: 10,
                                                        serverPaging: true
                                                });
                                                        jQuery("#grid").kendoGrid({
                                                dataSource: dataSource,
                                                        filterable: true,
                                                        pageable: {
                                                        refresh: true,
                                                                input: true,
                                                                numeric: false,
                                                                pageSizes: true,
                                                                pageSizes:[10, 20, 50, 100, 200, 400]
                                                        },
                                                        sortable: true,
                                                        groupable: true,
                                                        columns: [
                                                        {field: "id", title: "#", width: "20px", filterable: false},
                                                        {field: "name", title: "Theme", width: "60px"},
                                                        {
                                                        title: "", width: "150px",
                                                                template: kendo.template($("#image_template").html())
                                                        },
                                                        
                                                        {
                                                        title: "Action", width: "40px",
                                                                template: kendo.template($("#action_template").html())
                                                        }
                                                        ],
                                                });
                                                });

                                            </script>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                 <?php /*   <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Theme</th>
                                                <th>Color </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlv = $obj->FlyQuery("SELECT * FROM video_player");
                                            if (!empty($sqlv)) {
                                                $i = 1;
                                                foreach ($sqlv as $vid):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $vid->name; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($vid->id == '1') {
                                                                ?>
                                                                <img src="images/white.png" class="img-responsive" />
                                                                <?php
                                                            } elseif ($vid->id == '2') {
                                                                ?>
                                                                <img src="images/pink.png" class="img-responsive" />
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($vid->status == 0) { ?>
                                                                <a class="btn btn-danger" href="<?php echo $obj->filename(); ?>?acid=<?php echo $vid->id; ?>">Inactive</a>
                                                            <?php } else {
                                                                ?>
                                                                <a class="btn btn-success" href="<?php echo $obj->filename(); ?>?acid=<?php echo $vid->id; ?>">Active</a>

                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                endforeach;
                                            }
                                            ?>
                                        </tbody>
                                    </table>*/?>
                                </div>
                                <!-- /general form elements -->     


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
            <?php
            include('include/footer.php');
            echo $cms->KendoFotter();
            ?>
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');      ?>
            <!-- /right sidebar -->
            <link href="jpv/dist/skin/pink.flag/css/jplayer.pink.flag.min.css" rel="stylesheet" type="text/css" />
            <script type="text/javascript" src="jpv/dist/jplayer/jquery.jplayer.min.js"></script>
            <script type="text/javascript" src="jpv/dist/add-on/jplayer.playlist.min.js"></script>
            <script type="text/javascript">
                //<![CDATA[
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
                        swfPath: "../../dist/jplayer",
                        supplied: "webmv, ogv, m4v, oga, mp3",
                        useStateClassSkin: true,
                        autoBlur: false,
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
