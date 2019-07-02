<?php
include('class/auth.php');
include('class/index.php');
$index = new index();
//77d5d7b77bb86c84273f770a398a2e2f
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
        <script>
            jQuery(window).load(function() 
			{
                jQuery('#loading-image').hide();
            });
        </script>
        <script src="chart/Chart.js"></script>
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
                            <h5><i class="font-home"></i>Business Report</h5>
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
                                <?php 
								include('include/chart.php');
								?>
                               



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
