<?php include('class/auth.php'); 
$table="checkin";
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
                            <h5><i class="font-cog"></i>Start a repair</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Line chart -->

                                <div class="row-fluid">

                                    <div class="span12">
                                        <div class="semi-block">
                                            <div class="well-white body">
                                                    <h2 class="subtitle align-center" style="padding-bottom:25px;"> Please select your next step. 
                                                    <div class="separator-doubled"></div> 
                                                    </h2>
                                                    
                                                     
                                                    <div class="align-center">
                                                    <a href="checkin.php" class="btn btn-info" style="width:350px;">
                                                    <img src="images/icons/new_icons/branch.png" class="img-responsive"><br>
                                                    <h3>In-Store Repair</h3>
                                                    </a> 
                                                    <a href="ticket.php" class="btn btn-primary" style="width:350px;">
                                                    <img src="images/icons/new_icons/fieldlist.png" class="img-responsive"><br>
                                                    <h3>Special Order – Ticket Repair</h3>
                                                    </a>
                                                    </div>
                                                    
                                                    <div class="align-center" style="margin-top:20px; clear:both;">
                                                    <a href="checkin_list.php" class="btn btn-warning" style="width:350px; text-align:left;">
                                                    <h4><i class="icon-list"></i> In-Store Repair List</h4>
                                                    </a> 
                                                    <a href="ticket_list.php" class="btn btn-danger" style="width:350px; text-align:left;">
                                                    <h4><i class="icon-list"></i> Special Order – Ticket Repair List</h4>
                                                    </a>
                                                    </div>
                                                   
                                                    
                                                    
                                                    <div class="clearfix"></div>
                           						 </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /line chart -->
                                



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
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
