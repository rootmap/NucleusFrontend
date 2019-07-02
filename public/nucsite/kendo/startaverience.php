<?php
include('class/auth.php');
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
                <?php
                echo $obj->ShowMsg();

                $cashman=0;
                if ($input_status == 1 || $input_status == 2 || $input_status == 5) {
                    $cashman=1;
                }
                ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="font-cog"></i>Start a Variance  <?php
                                if ($cashman == 1) {
                                    ?>| See Report<?php } ?></h5>
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

                                <!-- Line chart -->

                                <div class="row-fluid">

                                    <div class="span12">
                                        <div class="semi-block">
                                            <div class="well-white body">

                                                <h2 class="subtitle align-center" style="padding-bottom:25px;"> Please select your next step to create variance
                                                    <div class="separator-doubled"></div>
                                                </h2>


                                                <div class="align-center">
                                                    <a href="checkin_inventory_list.php" class="btn btn-info" style="width:180px;">
                                                        <img src="images/icons/new_icons/assett.png" class="img-responsive"><br>
                                                        <h5>Checkin Inventory</h5>
                                                    </a>
                                                    <a href="phone_inventory_v_list.php" class="btn btn-primary" style="width:180px;">
                                                        <img src="images/icons/new_icons/sms_email-y.png" class="img-responsive"><br>
                                                        <h5>Phone Inventory</h5>
                                                    </a>
                                                    <a href="inventory_v_maintain_list.php" class="btn btn-primary" style="width:180px;">
                                                        <img src="images/icons/new_icons/f_stock_in.png" class="img-responsive"><br>
                                                        <h5>Maintain Stock Inventory</h5>
                                                    </a>
                                                    <a href="other_inventory_list.php" class="btn btn-success" style="width:180px;">
                                                        <img src="images/icons/new_icons/fieldlist.png" class="img-responsive"><br>
                                                        <h5>Other Inventory</h5>
                                                    </a>
                                                </div>
                                                <?php
                                                if ($cashman == 1) {
                                                    ?>

                                                    <br><br>

                                                    <h2 class="subtitle align-center" style="padding-bottom:25px;"> Please select your next step to see variance report
                                                        <div class="separator-doubled"></div>
                                                    </h2>

                                                    <div class="align-center" style="margin-top:20px; clear:both;">
                                                        <a href="checkin_verience.php" class="btn btn-info" style="width:180px; text-align:left;">
                                                            <h6><i class="icon-list"></i> Checkin Variance List</h6>
                                                        </a>
                                                        <a href="phone_verience.php" class="btn btn-primary" style="width:180px; text-align:left;">
                                                            <h6><i class="icon-list"></i> Phone Variance List</h6>
                                                        </a>
                                                        <a href="maintain_stock_varience.php" class="btn btn-primary" style="width:180px; text-align:left;">
                                                            <h6><i class="icon-list"></i> Maintain Stock Variance</h6>
                                                        </a>
                                                        <a href="other_inventory_verience.php" class="btn btn-success" style="width:180px; text-align:left;">
                                                            <h6><i class="icon-list"></i> Other Inventory Variance</h6>
                                                        </a>
                                                    </div>
                                                <?php } ?>


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
            <?php //include('include/sidebar_right.php');    ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
