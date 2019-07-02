<?php
include('class/auth.php');
include('class/index.php');
$index = new index();
$dashboard_today = date('Y-m-d');
?>
<!DOCTYPE html>

<html lang="en">

    <head>		

        <?php //echo $obj->bodyhead(); ?>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo"));
        ?>
        <link  type="text/css"  href="animation-plugin/animate.min.css" rel="stylesheet" />
        <script type="text/javascript" src="animation-plugin/wow.min.js"></script>

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
                            <h5><i class="icon-th"></i>Dashboard</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>

                        </div><!-- /page header -->



                        <div class="body">



                            <!-- Middle navigation standard -->

                            <?php //include('include/quicklink.php'); ?>
                            <div class="container">
                                <!-- Span 6 -->
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="block well animated wow fadeInLeftBig" data-wow-duration="10s" data-wow-delay="0.10s">
                                            <div class="navbar"><div class="navbar-inner"><h5><i class="font-link"></i> Quick Report Links</h5></div></div>
                                            <div class="body">
                                                <!-- Middle navigation standard -->
                                                <ul class="midnav">
                                                    <li style="width:100px;"><a href="ticket_report.php"><img src="images/icons/color/order-149.png" alt="" /><span>Ticket</span></a></li>
                                                    <li style="width:100px;"><a href="checkin_list.php"><img src="images/icons/color/checkin2.png" alt="" /><span>Repair</span></a></li>
                                                    <li style="width:100px;"><a href="customer_list.php"><img src="images/icons/color/hire-me.png" alt="" /><span>Customer</span></a></li>
                                                    <li style="width:100px;"><a href="parts_list.php"><img src="images/icons/color/donate.png" alt="" /><span>Parts</span></a></li>
                                                    <li style="width:100px;"><a href="inventory_list.php"><img src="images/icons/color/inventory.png" alt="" /><span>Inventory</span></a></li>
                                                    <li style="width:100px;"><a href="sales_list.php"><img src="images/icons/color/pos.png" alt="" /><span>POS</span></a></li>
                                                    <li style="width:100px;"><a href="buyback_list.php"><img src="images/icons/color/buyback.png" alt="" /><span>Buyback</span></a></li>
<!--                                                    <li style="width:100px;"><a href="unlock_list.php"><img src="images/icons/color/unlock.png" alt="" /><span>Unlock</span></a></li>-->
                                                    <li style="width:100px;"><a href="allreport.php"><img src="images/icons/color/backup.png" alt="" /><span>Reports</span></a></li>
                                                </ul>
                                                <!-- /middle navigation standard -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="span6">
                                        <div class="block well animated wow fadeInRightBig" data-wow-duration="10s" data-wow-delay="0.10s">
                                            <div class="navbar"><div class="navbar-inner"><h5><i class="font-signal"></i> System Summary</h5></div></div>
                                            <div class="body">
                                                <!-- Font icons -->
                                                <ul class="midnav midnav-font">
                                                    <li style="width:100px;"><a href="sales_list.php">
                                                            <i class="font-shopping-cart"></i>
                                                            <span style="margin-top: 12px; background-color: #3F51B5 !important;" class="label label-info" id="a1">123</span>
                                                            <span style="margin-top: 12px;">Sales</span>
                                                        </a>
                                                    </li>
                                                    <li style="width:100px;"><a href="ticket_report.php">
                                                            <i class="font-list-alt"></i>
                                                            <span style="margin-top: 12px; background-color: #4CAF50 !important;" class="label label-info" id="a2">456</span>
                                                            <span style="margin-top: 12px;">Ticket</span>
                                                        </a>
                                                    </li>
                                                    <li style="width:100px;"><a href="checkin_list.php">
                                                            <i class="font-map-marker"></i>
                                                            <span style="margin-top: 12px; background-color: #FF9800 !important;" class="label label-info" id="a3">789</span>
                                                            <span style="margin-top: 12px;">Repair</span>
                                                        </a>
                                                    </li>
                                                    <li style="width:100px;"><a href="buyback_list.php">
                                                            <i class="font-retweet"></i>
                                                            <span style="margin-top: 12px; background-color: #2196F3 !important;" class="label label-info" id="a4">101112</span>
                                                            <span style="margin-top: 12px;">Buyback</span>
                                                        </a>
                                                    </li>
                                                    <li style="width:100px;"><a href="estimate_list.php">
                                                            <i class="font-tasks"></i>
                                                            <span style="margin-top: 12px; background-color: #f44336 !important;" class="label label-info" id="a5">131415</span>
                                                            <span style="margin-top: 12px;">Estimate</span>
                                                        </a>
                                                    </li>
<!--                                                    <li style="width:100px;"><a href="unlock_list.php">
                                                            <i class="font-unlock"></i>
                                                            <span style="margin-top: 12px; background-color: #9C27B0 !important;" class="label label-info" id="a6">161718</span>
                                                            <span style="margin-top: 12px;">Unlock</span>
                                                        </a>
                                                    </li>-->
                                                </ul>
                                                <!-- /font icons -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /span6 -->
                            </div>

                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <div class="separator-doubled"></div>
                                <div class="row-fluid block">
                                    <div class="span8">
                                        <div class="block well animated wow fadeInUpBig" data-wow-duration="10s" data-wow-delay="0.10s">
                                            <div class="navbar"><div class="navbar-inner"><h5><i class="font-screenshot"></i> Get Started</h5></div></div>
                                            <div class="body">

                                                <!-- Font icons -->
                                                <ul class="midnav midnav-font">
                                                    <li style="width:150px;"><a href="customer.php">
                                                            <i style="color: #f44336;" class="font-user"></i>
                                                            <span style="margin-top: 10px;">New Customer</span>
                                                        </a>
                                                    </li>
                                                    <li style="width:150px;"><a href="ticket.php">
                                                            <i style="color: #3F51B5;" class="font-check"></i>
                                                            <span style="margin-top: 10px;">New Ticket</span>
                                                        </a>
                                                    </li>
                                                    <li style="width:150px;"><a href="checkin.php">
                                                            <i style="color: #03A9F4;" class="font-map-marker"></i>
                                                            <span style="margin-top: 10px;">New Repair</span>
                                                        </a>
                                                    </li>
                                                    <li style="width:150px;"><a href="pos.php">
                                                            <i style="color: #4CAF50;" class="font-money"></i>
                                                            <span style="margin-top: 10px;">New Sales</span>
                                                        </a>
                                                    </li>
                                                    <li style="width:150px;"><a href="buyback.php">
                                                            <i style="color: #FF9800;" class="font-repeat"></i>
                                                            <span style="margin-top: 10px;">New BuyBack</span>
                                                        </a>
                                                    </li>
<!--                                                    <li style="width:150px;"><a href="unlock.php">
                                                            <i style="color: #9C27B0;" class="font-unlock"></i>
                                                            <span style="margin-top: 10px;">New Unlock</span>
                                                        </a>
                                                    </li>-->

                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="span4">
                                        <div class="block well animated wow fadeInDownBig" data-wow-duration="10s" data-wow-delay="0.10s">
                                            <div class="navbar"><div class="navbar-inner"><h5><i class="font-screenshot"></i> Other Reports</h5></div></div>
                                            <div class="body">

                                                <!-- Font icons -->
                                                <ul class="midnav midnav-font">
                                                    <li style="width:250px;"><a href="tender_report.php">
                                                            <i style="color: #f44336;" class="font-list"></i>
                                                            <span style="margin-top: 10px;">Tender Report</span>
                                                        </a>
                                                    </li>
                                                    <li style="width:250px;"><a href="highest_seller_cashier_report.php">
                                                            <i style="color: #3F51B5;" class="font-bar-chart"></i>
                                                            <span style="margin-top: 10px;">Highest Sales Cashier Report</span>
                                                        </a>
                                                    </li>

                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                </div>  
                                <div class="separator-doubled"></div>

                                <div class="row-fluid block">
                                    <div class="span12">
                                        <div class="block well animated wow fadeInUpBig" data-wow-duration="10s" data-wow-delay="0.10s">
                                            <div class="navbar"><div class="navbar-inner"><h5><i class="font-time"></i> Today Cashier Punch Log</h5></div></div>
                                            <div class="body">
                                                <div id="grid"></div>


                                                <script type="text/javascript">
                                                    jQuery(document).ready(function () {
                                                        var dataSource = new kendo.data.DataSource({
                                                            transport: {
                                                                read: {
                                                                    url: "./controller/cashier_punch_history.php?today",
                                                                    type: "GET",
                                                                    datatype: "json"

                                                                }
                                                            },
                                                            autoSync: true,
                                                            schema: {
                                                                data: "data",
                                                                total: "total",
                                                                model: {
                                                                    id: "id",
                                                                    fields: {
                                                                        cashier: {type: "string"},
                                                                        indate: {type: "string"},
                                                                        intime: {type: "string"},
                                                                        outdate: {type: "string"},
                                                                        outtime: {type: "string"},
                                                                        elapsed_time: {type: "string"}
                                                                    }
                                                                }
                                                            },
                                                            pageSize: 10,
                                                            serverPaging: true,
                                                            serverFiltering: true,
                                                            serverSorting: true
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
                                                                {field: "cashier", title: "Cashier"},
                                                                {field: "indate", title: "Date In", width: "120px", filterable: false},
                                                                {field: "intime", title: "Time In", width: "120px", filterable: false},
                                                                {field: "outdate", title: "Date Out", width: "120px", filterable: false},
                                                                {field: "outtime", title: "Time Out", width: "120px", filterable: false},
                                                                {field: "elapsed_time", title: "Elapsed Time(H:M:S)", filterable: false}
                                                            ],
                                                        });
                                                    });

                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            <script>
                nucleus(document).ready(function () {
                    
                    nucleus.getJSON("./controller/dashboard_report.php", {'id': 1}, function (data) {
                        jQuery.each(data, function (index, key) {
                            //console.log();
                            jQuery("#a1").html(key.total_sales);
                            jQuery("#a2").html(key.total_ticket);
                            jQuery("#a3").html(key.total_repair);
                            jQuery("#a4").html(key.total_buyback);
                            jQuery("#a5").html(key.total_estimate);
                            jQuery("#a6").html(key.total_unlock);
                        });
                    });
                });
            </script>    
            <?php //include('include/footer.php'); ?>

            <!-- Right sidebar -->

            <?php //include('include/sidebar_right.php');     ?>

            <!-- /right sidebar -->



        </div>

        <!-- /main wrapper -->



    </body>

</html>

