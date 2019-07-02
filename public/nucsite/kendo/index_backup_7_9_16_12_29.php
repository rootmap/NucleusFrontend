<?php
include('class/auth.php');
include('class/index.php');
$index = new index();
$dashboard_today = date('Y-m-d');
?>
<!DOCTYPE html>

<html lang="en">

    <head>		

        <?php echo $obj->bodyhead(); ?>		

        <script>
            function dashboard_system_summary()
            {
                $('#dashboard_system_summary').hide();
                var dfs = "<img src='images/loader-big.gif' />";



                $('#customer_total').html(dfs);

                $('#ticket_total').html(dfs);

                $('#checkin_total').html(dfs);

                $('#sales_total_quantity').html(dfs);

                $('#estimate_total').html(dfs);

                $('#buyback_total').html(dfs);
<?php if ($input_by != "1431472960") { ?>
                    $('#unlock_total').html(dfs);
<?php } ?>
                param1 = {'fetch': 1};
                $.post('shout.php', param1, function (res1) {
                    $('#customer_total').html(res1);
                });
                param2 = {'fetch': 2};
                $.post('shout.php', param2, function (res2) {
                    $('#ticket_total').html(res2);
                });
                param3 = {'fetch': 3};
                $.post('shout.php', param3, function (res3) {
                    $('#checkin_total').html(res3);
                });
<?php if ($input_status != "5") { ?>
                    param4 = {'fetch': 4};
                    $.post('shout.php', param4, function (res4) {
                        $('#sales_total_quantity').html(res4);
                    });
<?php } ?>
                param5 = {'fetch': 5};
                $.post('shout.php', param5, function (res5) {
                    $('#estimate_total').html(res5);
                });
                param6 = {'fetch': 6};
                $.post('shout.php', param6, function (res6) {
                    $('#buyback_total').html(res6);
                });
<?php if ($input_by != "1431472960") { ?>
                    param7 = {'fetch': 7};
                    $.post('shout.php', param7, function (res7) {
                        $('#unlock_total').html(res7);
                    });
<?php } ?>
            }

            function dashboard_tender_report()
            {
                $('#dashboard_tender_report').hide();
                var dfs = "<img src='images/loader-big.gif' />";
                $('#tender_report').html(dfs);

                param8 = {'fetch': 8};
                $.post('shout.php', param8, function (res8) {
                    $('#tender_report').html(res8);
                });
            }

            function dashboard_highest_sales_cashier_report()
            {
                $('#dashboard_highest_sales_cashier_report').hide();
                var dfs = "<img src='images/loader-big.gif' />";
                $('#highest_slaes_cs_total').html(dfs);

                param9 = {'fetch': 9};
                $.post('shout.php', param9, function (res9) {
                    $('#highest_slaes_cs_total').html(res9);
                });
            }

            function dashboard_other_history_report()
            {
                $('#dashboard_other_history_report').hide();
                var dfs = "<img src='images/loader-big.gif' />";
                $('#today_total_ticket').html(dfs);

                $('#today_buyback_total').html(dfs);
<?php if ($input_by != "1431472960") { ?>
                    $('#today_unlock_total').html(dfs);
<?php } ?>
                $('#today_checkin_total').html(dfs);

                param10 = {'fetch': 10};
                $.post('shout.php', param10, function (res10) {
                    $('#today_transaction_List_total').html(res10);
                });
                param11 = {'fetch': 11}; $.post('shout.php', param11, function (res11) {
                    $('#today_transaction_List_total_detail').html(res11);
                });
                param12 = {'fetch': 12};
                $.post('shout.php', param12, function (res12) {
                    $('#today_total_ticket').html(res12);
                });
                param13 = {'fetch': 13};
                $.post('shout.php', param13, function (res13) {
                    $('#today_total_ticket_detail').html(res13);
                });
                param14 = {'fetch': 14};
                $.post('shout.php', param14, function (res14) {
                    $('#today_buyback_total').html(res14);
                });
                param15 = {'fetch': 15};
                $.post('shout.php', param15, function (res15) {
                    $('#today_buyback_total_detail').html(res15);
                });
<?php if ($input_by != "1431472960") { ?>
                    param16 = {'fetch': 16};
                    $.post('shout.php', param16, function (res16) {
                        $('#today_unlock_total').html(res16);
                    });
                    param17 = {'fetch': 17};
                    $.post('shout.php', param17, function (res17) {
                        $('#today_unlock_total_detail').html(res17);
                    });
<?php } ?>
                param18 = {'fetch': 18};
                $.post('shout.php', param18, function (res18) {
                    $('#today_checkin_total').html(res18);
                });
                param19 = {'fetch': 19};
                $.post('shout.php', param19, function (res19) {
                    $('#today_checkin_total_detail').html(res19);
                });
            }
        </script>
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
                            <h5><i class="font-home"></i>Dashboard</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>

                        </div><!-- /page header -->



                        <div class="body">



                            <!-- Middle navigation standard -->

                            <?php include('include/quicklink.php'); ?>

                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <div class="separator-doubled"></div> 
                                <!-- Line chart -->
                                <ul class="midnav piechart">
                                    <?php
                                    if ($input_status == "1") {
                                        $inv4 = $index->FlyQuery("SELECT IFNULL(SUM(A.total_sales_today), 0) as today_sales_total FROM 
(SELECT (SELECT COUNT(id) FROM sales WHERE sales.sales_id=invoice.invoice_id) as total_sales_today FROM `invoice` WHERE date='" . $dashboard_today . "' AND doc_type='3' ORDER BY id DESC) AS A WHERE A.total_sales_today!=0;");
                                        ?>
                                        <li>

                                            <div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $inv4[0]->today_sales_total; ?>">

                                                <?php echo $inv4[0]->today_sales_total; ?>
                                                <canvas width="94" height="94"></canvas>
                                            </div>
                                            <span> Today Sales </span>
                                        </li>
                                        <?php
                                    } elseif ($input_status != "5") {
                                        $inv4 = $index->FlyQuery("SELECT IFNULL(SUM(A.total_sales_today), 0) as today_sales_total FROM 
(SELECT (SELECT COUNT(id) FROM sales WHERE sales.sales_id=invoice.invoice_id) as total_sales_today FROM `invoice` WHERE date='" . $dashboard_today . "' AND input_by='" . $input_by . "' AND doc_type='3' ORDER BY id DESC) AS A WHERE A.total_sales_today!=0;");
                                        ?>
                                        <li>

                                            <div style="width: 94px; height: 94px; line-height: 94px;" class="easyPieChart" data-percent="<?php echo $inv4[0]->today_sales_total; ?>">

    <?php echo $inv4[0]->today_sales_total; ?>
                                                <canvas width="94" height="94"></canvas>
                                            </div>
                                            <span> Today Sales </span>
                                        </li>
    <?php
}

include('include/dashboard_today_summary.php');
?>


                                </ul>
                                <div class="separator-doubled"></div> 
                                <div class="row-fluid block">
                                    <div class="span6">
                                        <div class="semi-block">
                                            <h3 class="subtitle align-center">Get Started</h3>
                                            <div class="well-white body">
                                                <div class="table-overflow">
                                                    <table>
                                                        <tbody>
                                                            <tr>

                                                                <td width="30%"> <button style="height:50px; width:60px;" type="button" class="btn"> <i class="icon-user"></i> </button> </td>

                                                                <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="customer.php" class="btn btn-success"><i class="icon-plus"></i> New Customer</a></td>

                                                            </tr>



                                                            <tr>

                                                                <td> <button type="button" class="btn"  style="height:50px; width:60px;"> <i class="icon-check"></i> </button> </td>

                                                                <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="ticket.php" class="btn btn-success"><i class="icon-plus"></i> New Ticket</a></td>

                                                            </tr>



                                                            <tr>

                                                                <td> <button type="button" class="btn"  style="height:50px; width:60px;"> <i class="icon-camera"></i> </button> </td>

                                                                <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="checkin.php" class="btn btn-success"><i class="icon-plus"></i> New Check In</a></td>

                                                            </tr>

                                                            <!--

                                                            <tr>

                                                                <td> <button type="button" class="btn"  style="height:50px; width:60px;"> <i class="icon-shopping-cart"></i> </button> </td>

                                                                <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="invoice.php" class="btn btn-success"><i class="icon-plus"></i> New Invoice</a></td>

                                                            </tr>

                                                            -->

                                                            <tr>

                                                                <td> <button type="button" class="btn"  style="height:50px; width:60px;"> <i class="font-money"></i> </button> </td>

                                                                <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="pos.php" class="btn btn-success"><i class="icon-plus"></i> New Sales</a></td>

                                                            </tr>



                                                            <tr>

                                                                <td> <button type="button" class="btn"  style="height:50px; width:60px;"> <i class="icon-time"></i> </button> </td>

                                                                <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="estimate.php" class="btn btn-success"><i class="icon-plus"></i> New Estimate</a></td>

                                                            </tr>



                                                            <tr>

                                                                <td> <button type="button" class="btn"  style="height:50px; width:60px;"> <i class="icon-repeat"></i> </button> </td>

                                                                <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="buyback.php" class="btn btn-success"><i class="icon-plus"></i> New BuyBack</a></td>

                                                            </tr>
<?php
if ($input_by != "1431472960") {
    if ($input_status == 1) {
        ?>
                                                                    <tr>

                                                                        <td> <button type="button" class="btn"  style="height:50px; width:60px;"> <i class="font-unlock"></i> </button> </td>

                                                                        <td><a  style="height:32px; width:180px; line-height:32px; font-size:18px;" href="unlock.php" class="btn btn-success"><i class="icon-plus"></i> New Unlock</a></td>

                                                                    </tr>
        <?php
    }
}
?>


                                                        </tbody>

                                                    </table>



                                                </div>

                                            </div>

                                        </div>

                                    </div>





                                    <div class="span6">



                                        <div class="semi-block">

                                            <h3 class="subtitle align-center" id="dashboard_system_summary_title">System Summary</h3>

                                            <div class="well-white body">

                                                <div class="table-overflow">
                                                                                                        <!--<table>
                                                        <tbody>
                                                            <tr>
                                                                <td><button onClick="dashboard_system_summary(1)" type="button" class="btn btn-success"><i class="icon-random"></i> Load System Summary</button></td>
                                                            </tr>
                                                                                                        <tr>
                                                        </tbody>
                                                    </table>-->
<?php include('include/dashboard_system_summary.php'); ?>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>  


<?php if ($input_status != 5) { ?>
                                    <div class="row-fluid block">  

                                        <div class="span6">



                                            <div class="semi-block">

                                                <div class="well-white body">

                                                    <div class="table-overflow">

    <?php include('include/dashboard_tender_report.php'); ?>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>



                                        <div class="span6">



                                            <div class="semi-block">

                                                <div class="well-white body">

                                                    <div class="table-overflow">

    <?php include('include/dashboard_highest_sales_cashier_report.php'); ?>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

<?php } ?>







                                <div class="block well">



                                    <div class="table-overflow">
                                        <button type="button" class="btn btn-success" id="dashboard_other_history_report" onclick="dashboard_other_history_report()" style="position:absolute; right:3px;"><i class="icon-refresh"></i> Load Data</button>
                                        <table class="table table-bordered">

                                            <thead>

                                                <tr>

                                                    <th colspan="10">Today Transaction List (<span id="today_transaction_List_total">0</span>)</th>

                                                </tr>

                                                <tr>

                                                    <th>#</th>

                                                    <th>Transaction</th>

                                                    <th>Shop</th>

                                                    <th>Date</th>

                                                    <th>Time</th>

                                                    <th>Cashier</th>

                                                    <th>Customer</th>

                                                    <th>Amount</th>

                                                    <th>Type</th>

                                                    <th>Tender</th>

                                                </tr>

                                            </thead>



                                            <tbody id="today_transaction_List_total_detail">

                                                <tr><td colspan="10">No Record Found</td></tr>

                                            </tbody>

                                        </table>

                                    </div>

                                    <div class="clear" style="margin-bottom:10px;"></div>

                                    <div class="table-overflow">

                                        <table class="table table-bordered">

                                            <thead>

                                                <tr>

                                                    <th colspan="7">Today Ticket List (<span id="today_total_ticket">0</span>)</th>



                                                </tr>

                                                <tr>

                                                    <th>#</th>

                                                    <th>Ticket ID</th>

                                                    <th>Subject</th>

                                                    <th>Created</th>



                                                    <th>Status</th>

                                                    <th>Problem type</th>

                                                    <th>Last Updated</th>

                                                </tr>

                                            </thead>

                                            <tbody id="today_total_ticket_detail">

                                                <tr><td colspan="7">No Record Found</td></tr>

                                            </tbody>

                                        </table>

                                    </div>

                                    <div class="clear" style="margin-bottom:10px;"></div>

                                    <div class="table-overflow">

                                        <table class="table table-bordered">

                                            <thead>

                                                <tr>

                                                    <th colspan="9">Today Buyback List (<span id="today_buyback_total">0</span>)</th>



                                                </tr>



                                                <tr>

                                                    <th>#</th>

                                                    <th>BuyBack ID</th>

                                                    <th>Customer</th>

                                                    <th>Model</th>

                                                    <th>Carrier</th>



                                                    <th>IMEI</th>

                                                    <th>Price</th>

                                                    <th>Payment Method</th>

                                                    <th>Date</th>

                                                </tr>

                                            </thead>

                                            <tbody id="today_buyback_total_detail">

                                                <tr><td colspan="9">No Record Found</td></tr>

                                            </tbody>

                                        </table>

                                    </div>

                                    <div class="clear" style="margin-bottom:10px;"></div>
<?php if ($input_by != "1431472960") { ?>
                                        <div class="table-overflow">

                                            <table class="table table-bordered">

                                                <thead>

                                                    <tr>

                                                        <th colspan="7">Today Unlocks List (<span id="today_unlock_total">0</span>)</th>



                                                    </tr>



                                                    <tr>

                                                        <th>#</th>

                                                        <th>Unlock ID</th>

                                                        <th>Sevice </th>

                                                        <th>Created</th>

                                                        <th>Status</th>

                                                        <th>Last Updated</th>

                                                        <th width="150">Send To POS</th>

                                                    </tr>

                                                </thead>

                                                <tbody id="today_unlock_total_detail">

                                                    <tr><td colspan="7">No Record Found</td></tr>

                                                </tbody>

                                            </table>

                                        </div>



                                        <div class="clear" style="margin-bottom:10px;"></div>
<?php } ?>
                                    <div class="table-overflow">

                                        <table class="table table-bordered">

                                            <thead>

                                                <tr>

                                                    <th colspan="10">Today Checkin List (<span id="today_checkin_total">0</span>)</th>



                                                </tr>



                                                <tr>

                                                    <th>#</th>

                                                    <th>Customer</th>

                                                    <th>Email</th>

                                                    <th>Problem</th>



                                                    <th>Device</th>

                                                    <th>Model</th>

                                                    <th>Color</th>

                                                    <th>Network</th>

                                                    <th>Problem</th>

                                                    <th>Created</th>

                                                </tr>

                                            </thead>

                                            <tbody id="today_checkin_total_detail">

                                                <tr><td colspan="10">No Record Found</td></tr>

                                            </tbody>

                                        </table>

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

<?php //include('include/sidebar_right.php');     ?>

            <!-- /right sidebar -->



        </div>

        <!-- /main wrapper -->



    </body>

</html>

