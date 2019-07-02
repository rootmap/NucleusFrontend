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
                            <h5><i class="font-film"></i> Help Desk </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
                                <!-- Content Start from here customized -->




                                <!-- General form elements -->

                                <?php
                                $sqlvideo = $obj->FlyQuery("SELECT * FROM tutorial_video WHERE status='1' ORDER BY id DESC");
                                if (!empty($sqlvideo)) {
                                    $f = 1;
                                    foreach ($sqlvideo as $video):
                                        if ($f == 1) {
                                            ?>
                                            <div class="row-fluid span12" style="padding-top: 5px;">  
                                                <?php
                                            }
                                            ?>
                                            <div class="span4 well-smoke" style="margin-bottom: 5px;">
                                                <div class="span12">    
                                                    <div class="page-header"><!-- Page header -->
                                                        <h5><i class="font-film"></i> <?php echo $video->title; ?> </h5>
                                                    </div>
                                                </div>
                                                <div class="span12" style="padding-left: 0px;  margin-left: 0px;">   
                                                    <img style="opacity:0.7;" src="images/thm.png" class="span12" />
                                                    <a href="helpdesk_view.php?embeded=<?php echo $video->id; ?>&view=<?php echo $video->name; ?>&inc=<?php echo $video->title; ?>" class="playlist-add-tutorials">
                                                        <img src="images/pl.png" class="span12" style="opacity:1; margin-left: 0px; padding-left: 0px; z-index: 1; position: absolute;" />
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                            if ($f == 3) {
                                                ?>
                                            </div>
                                                <?php
                                                $f = 0;
                                            } elseif ($f != 3 && $f == count($sqlvideo)) {
                                                ?>
                                        </div>
                                            <?php
                                            $f = 0;
                                        }
                                        $f++;
                                    endforeach;
                                } else {
                                    ?>
                            <code>Helpdesk info is currently unavailable.</code>
                                    <?php
                                }
                                ?>


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
<?php include('include/footer.php'); ?>
        <!-- Right sidebar -->
        <?php //include('include/sidebar_right.php');    ?>
        <!-- /right sidebar -->

    </div>
    <!-- /main wrapper -->

</body>
</html>
