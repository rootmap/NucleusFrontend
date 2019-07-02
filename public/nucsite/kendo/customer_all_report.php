<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "coustomer";
$cid = $_GET['cid'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo", "modal"));
        ?>
        <script src="ajax/customer_ajax.js"></script>
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
                            <h5><i class="font-user"></i>Customer Report Info</h5>
                            <ul class="icons">
                                <li>
                                    <a data-toggle="modal" href="#myModal1" class="hovertip" title="Search Customer Report">
                                        <i class="icon-calendar"></i>
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /page header -->

                        <!-- Dialog content -->

                        <!-- /dialog content -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Content Start from here customized -->




                                <!-- General form elements -->



                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        jQuery.get("./controller/customer_all_report.php", {'report_cid':'<?php echo $_GET['cid']; ?>'}, function (datas) {
                                            jQuery.each(datas, function (index, key) {


                                                if (index == "data")
                                                {
                                                    console.log(key[0].id);
                                                    jQuery("#a1").html(key[0].id);
                                                    jQuery("#a2").html(key[0].full_name);
                                                    jQuery("#a3").html(key[0].email);
                                                    jQuery("#a4").html(key[0].phone);
                                                    jQuery("#a5").html(key[0].city);
                                                    jQuery("#a6").html(key[0].address1);

                                                    jQuery("#a7").html(key[0].total_invoice + " Invoices");
                                                    jQuery("#a8").html(key[0].total_estimate + " Estimates");
                                                    jQuery("#a9").html(key[0].total_checkin_ticket + " Checkin/Ticket");
                                                    jQuery("#a10").html(key[0].total_parts_order + " Parts Order");

                                                }

                                            })
                                        });
                                    });

                                </script>

                                <div class="row-fluid  span12 well" style="margin-top: 5px;">     
                                    <div class="navbar">
                                        <div class="navbar-inner">
                                            <h5><i class="font-money"></i> Customer Info  </h5>
                                        </div>
                                    </div>
                                    <!-- Selects, dropdowns -->
                                    <div class="span12" style="padding:0px; margin:0px;">
                                        <div class="table-overflow">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Customer ID</th>
                                                        <th>Full Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>

                                                        <th>City</th>
                                                        <th>Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td id="a1"></td>
                                                        <td id="a2"></td>
                                                        <td id="a3"></td>
                                                        <td id="a4"></td>
                                                        <td id="a5"></td>
                                                        <td id="a6"></td>                                            
                                                    </tr>

                                                </tbody>

                                                <thead>
                                                    <tr>
                                                        <th>Total Invoices</th>
                                                        <th>Total Estimate</th>
                                                        <th>Total Repair/Ticket</th>
                                                        <th>Total Parts Order</th>

                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td id="a7"></td>
                                                        <td id="a8"></td>
                                                        <td id="a9"></td>
                                                        <td id="a10"></td>
                                                        <td></td>

                                                        <td></td>                                            
                                                    </tr>

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <!-- /selects, dropdowns -->
                                </div>

                                <!-- Content End from here customized -->
                                <!-- Sales form elements -->
                                <div class="row-fluid  span12 well" style="margin-top: 5px;">     
                                    <div class="navbar">
                                        <div class="navbar-inner">
                                            <h5><i class="font-money"></i> Sales  </h5>
                                        </div>
                                    </div>
                                    <!-- Selects, dropdowns -->
                                    <div class="span12" style="padding:0px; margin:0px;">
                                        <div class="table-overflow">
                                            <div id="sales_grid"></div>

                                            <script type="text/javascript">
                                                jQuery(document).ready(function () {
                                                    var dataSource = new kendo.data.DataSource({
                                                        transport: {
                                                            read: {
                                                                url: "./controller/sales_report.php?report_cid=<?php echo $_GET['cid']; ?>",
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
                                                                    id: {nullable: true},
                                                                    invoice_id: {type: "string"},
                                                                    customer: {type: "string"},
                                                                    pty: {type: "string"},
                                                                    status: {type: "string"},
                                                                    paid_amount: {type: "string"},
                                                                    date: {type: "string"},
                                                                    quantity: {type: "number"},
                                                                    sales_amount: {type: "string"}
                                                                }
                                                            }
                                                        },
                                                        pageSize: 10,
                                                        serverPaging: true,
                                                        serverFiltering: true,
                                                        serverSorting: true
                                                    });
                                                    jQuery("#sales_grid").kendoGrid({
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
                                                            {field: "id", title: "S.ID", width: "60px"},
                                                            {field: "invoice_id", title: "Invoice-ID", width: "90px"},
                                                            {field: "customer", title: "Customer", width: "90px"},
                                                            {field: "pty", title: "Tender", width: "80px"},
                                                            {field: "status", title: "Status", width: "90px"},
                                                            {field: "date", title: "Date", width: "50px"},
                                                            {title: "Item", width: "50px", field: "quantity"},
                                                            {field: "sales_amount", title: "Total", width: "50px"}
                                                        ],
                                                    });
                                                });

                                            </script>

                                        </div>
                                    </div>
                                    <!-- /selects, dropdowns -->
                                </div>
                                <!-- /Sales form elements -->



                                <!-- Invoice form elements -->
                                <div class="row-fluid  span12 well" style="margin-top: 5px;">     
                                    <div class="navbar">
                                        <div class="navbar-inner">
                                            <h5><i class="font-money"></i> Invoices  </h5>
                                        </div>
                                    </div>
                                    <!-- Selects, dropdowns -->
                                    <div class="span12" style="padding:0px; margin:0px;">
                                        <div class="table-overflow">

                                            <div id="invoice_grid"></div>
                                            <script id="checkin_link" type="text/x-kendo-template">
                                                <a href="view_sales.php?invoice=#=invoice_id#">#=invoice_id#</a>
                                            </script>
                                            <script id="checkin_status" type="text/x-kendo-template">

                                            </script>
                                            <script id="status" type="text/x-kendo-template">
                                                #if(status==0){#
                                                <label class="label label-danger">Not Yet</label> 
                                                #}else if(status==1){#
                                                <label class="label label-success"> Paid </label> 
                                                #}else if(status==2){#
                                                <label class="label label-success"> Paid </label>
                                                #}else if(status==3){#
                                                <label class="label label-warning"> Partial </label>
                                                #}#
                                            </script>
                                            <script type="text/javascript">
                                                function deleteClick(id) {
                                                    var c = confirm("Do you want to delete?");
                                                    if (c === true) {
                                                        $.ajax({
                                                            type: "POST",
                                                            dataType: "json",
                                                            url: "./controller/sales_list.php",
                                                            data: {id: id},
                                                            success: function (result) {
                                                                $(".k-i-refresh").click();
                                                            }
                                                        });
                                                    }
                                                }

                                            </script>
                                            
                                            <script type="text/javascript">
                                                var gridElement = $("#invoice_grid");

                                                function showLoading(e) {
                                                    kendo.ui.progress(gridElement, true);
                                                }

                                                function restoreSelection(e) {
                                                    kendo.ui.progress(gridElement, false);
                                                }

                                                jQuery(document).ready(function () {

                                                    var dataSource = new kendo.data.DataSource({
                                                        requestStart: showLoading,
                                                        transport: {
                                                            read: {
                                                                url: "./controller/sales_list.php?report_cid=<?php echo $_GET['cid']; ?>",
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
                                                                    id: {nullable: true},
                                                                    invoice_id: {type: "string"},
                                                                    customer: {type: "string"},
                                                                    pty: {type: "string"},
                                                                    status: {type: "string"},
                                                                    paid_amount: {type: "string"},
                                                                    date: {type: "string"},
                                                                    quantity: {type: "number"},
                                                                    sales_amount: {type: "string"}
                                                                }
                                                            }



                                                        },
                                                        pageSize: 10,
                                                        serverPaging: true,
                                                        serverFiltering: true,
                                                        serverSorting: true
                                                    });



                                                    jQuery("#invoice_grid").kendoGrid({
                                                        dataSource: dataSource,
                                                        filterable: true,
                                                        dataBound: restoreSelection,
                                                        pageable: {
                                                            refresh: true,
                                                            input: true,
                                                            numeric: false,
                                                            pageSizes: true,
                                                            pageSizes:[10, 50, 200, 500, 1000, 5000, 10000]
                                                        },
                                                        sortable: true,
                                                        groupable: true,
                                                        columns: [
                                                            {field: "id", title: "S.ID", width: "60px"},
                                                            {title: "Invoice-ID", width: "90px", template: kendo.template($("#checkin_link").html())},
                                                            {field: "customer", title: "Customer", width: "90px"},
                                                            {field: "pty", title: "Tender", width: "80px"},
                                                            {title: "Status", width: "90px", template: kendo.template($("#status").html())},
                                                            {field: "date", title: "Date", width: "50px"},
                                                            {title: "Item", width: "50px", field: "quantity"},
                                                            {field: "sales_amount", title: "Total", width: "50px"}
                                                        ],
                                                    });
                                                });

                                            </script>













                                        </div>
                                    </div>
                                    <!-- /selects, dropdowns -->
                                </div>
                                <!-- /invoice form elements -->




                                <!-- Estimate form elements -->
                                <div class="row-fluid  span12 well" style="margin-top: 5px;">     
                                    <div class="navbar">
                                        <div class="navbar-inner">
                                            <h5><i class="font-money"></i> Estimate  </h5>
                                        </div>
                                    </div>
                                    <!-- Selects, dropdowns -->
                                    <div class="span12" style="padding:0px; margin:0px;">
                                        <div class="table-overflow">
                                        <div id="estimate_grid"></div>


                                    <script type="text/javascript">
                                        jQuery(document).ready(function () {
                                            var dataSource = new kendo.data.DataSource({
                                                transport: {
                                                    read: {
                                                        url: "./controller/estimate.php?report_cid=<?php echo $_GET['cid']; ?>",
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
                                                            id: {nullable: true},
                                                            invoice_id: {type: "string"},
                                                            businessname: {type: "string"},
                                                            quantity: {type: "number"},
                                                            row_total: {type: "number"},
                                                            tax_total: {type: "number"},
                                                            total: {type: "number"},
                                                            date: {type: "string"},
                                                            status: {type: "string"}
                                                        }
                                                    }
                                                },
                                                pageSize:10,
                                                serverPaging:true,
                                                serverFiltering:true,
                                                serverSorting:true
                                            });
                                            jQuery("#estimate_grid").kendoGrid({
                                                dataSource:dataSource,
                                                filterable:true,
                                                pageable: {
                                                    refresh:true,
                                                    input:true,
                                                    numeric:false,
                                                    pageSizes:true,
                                                    pageSizes:[10, 20, 50, 100, 200, 400]
                                                },
                                                sortable: true,
                                                groupable: true,
                                                columns: [
                                                    {field: "id", title: "#", width: "70px"},
                                                    {field: "invoice_id", 
                                                        title: "Estimate ID", 
                                                        
                                                        template: "<a target='_blank' href='view_estimate.php?estimate=#=invoice_id#'>#=invoice_id#</a>"
                                                    },
                                                    {field: "businessname", title: "Customer"},
                                                    {field: "quantity", title: "Quantity"},
                                                    {field: "row_total", title: "Sub Total"},
                                                    {field: "tax_total", title: "Tax"},
                                                    {field: "total", title: "Total"},
                                                    {field: "date", title: "Date"}
                                                ],
                                            });
                                        });

                                    </script>
                                        
                                    </div>
                                    </div>
                                    <!-- /selects, dropdowns -->
                                </div>
                                <!-- /Estimate form elements -->




                                <!-- Ticket form elements -->
                                <div class="row-fluid  span12 well" style="margin-top: 5px;">     
                                    <div class="navbar">
                                        <div class="navbar-inner">
                                            <h5><i class="font-money"></i> Ticket  </h5>
                                        </div>
                                    </div>
                                    <!-- Selects, dropdowns -->
                                    <div class="span12" style="padding:0px; margin:0px;">
                                        <div class="table-overflow">
                                        <div id="ticket_grid"></div>


                                        <script type="text/javascript">
                                            jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                    transport: {
                                                        read: {
                                                            url: "./controller/ticket_report_customer.php?report_cid=<?php echo $_GET['cid']; ?>",
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
                                                                ticket_id: {type: "number"},
                                                                date: {type: "string"},
                                                                status: {type: "string"},
                                                                problem_type: {type: "string"},
                                                                problem: {type: "string"},
                                                                price: {type: "string"},
                                                                invoice_id: {type: "number"},
                                                                pricee: {type: "string"},
                                                                paid: {type: "string"},
                                                                input_by: {type: "string"}
                                                            }
                                                        }
                                                    },
                                                    pageSize: 10,
                                                    serverPaging: true,
                                                    serverFiltering: true,
                                                    serverSorting: true
                                                });
                                                jQuery("#ticket_grid").kendoGrid({
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
                                                        {field: "id", title: "#", width: "40px", filterable: false},
                                                        {field: "ticket_id", title: "Ticket ID ", width: "100px"},
                                                        {field: "invoice_id", title: "invoice_id ", width: "100px"},
                                                        {field: "input_by", title: "Store ID ", width: "80px", filterable: false},
                                                        {field: "problem", title: "Problem ", width: "80px", filterable: false},
                                                        {field: "problem_type", title: "Problem Type ", width: "70px", filterable: false},
                                                        {field: "price", title: "Our Cost ", width: "50px"},
                                                        {field: "pricee", title: "Retail Cost ", width: "100px", filterable: false},
                                                        {field: "status", title: "Profit ", width: "70px", filterable: false},
                                                        {field: "paid", title: "Paid ", width: "70px", filterable: false},
                                                        {field: "date", title: "Date ", width: "80px", filterable: false}
                                                    ],
                                                });
                                            });

                                        </script>
                                        
                                    </div>
                                    </div>
                                    <!-- /selects, dropdowns -->
                                </div>
                                <!-- /Ticket form elements -->



                                <!-- Parts Order form elements -->
                                <div class="row-fluid  span12 well" style="margin-top: 5px;">     
                                    <div class="navbar">
                                        <div class="navbar-inner">
                                            <h5><i class="font-money"></i> Parts Order  </h5>
                                        </div>
                                    </div>
                                    <!-- Selects, dropdowns -->
                                    <div class="span12" style="padding:0px; margin:0px;">
                                        <div class="table-overflow">
                                            <div id="parts_grid"></div>


                                    
                                    <script type="text/javascript">
                                        jQuery(document).ready(function () {
                                            var dataSource = new kendo.data.DataSource({
                                                transport: {
                                                    read: {
                                                        url: "./controller/parts.php?report_cid=<?php echo $_GET['cid']; ?>",
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
                                                            id: {nullable: true},
                                                            ticket_id: {type: "string"},
                                                            cid: {type: "number"},
                                                            name: {type: "string"},
                                                            part_url: {type: "string"},
                                                            description: {type: "string"},
                                                            cost: {type: "string"},
                                                            ordered: {type: "string"},
                                                            trackingnum: {type: "string"},
                                                            received: {type: "string"}
                                                        }
                                                    }
                                                },
                                                pageSize:10,
                                                serverPaging:true,
                                                serverFiltering:true,
                                                serverSorting:true
                                            });
                                            jQuery("#parts_grid").kendoGrid({
                                                dataSource:dataSource,
                                                filterable:true,
                                                pageable: {
                                                    refresh:true,
                                                    input:true,
                                                    numeric:false,
                                                    pageSizes:true,
                                                    pageSizes:[10, 20, 50, 100, 200, 400]
                                                },
                                                sortable: true,
                                                groupable: true,
                                                columns: [
                                                    {field: "id", title: "PO.ID", width: "70px"},
                                                    {field: "ticket_id", 
                                                        title: "Ticket ID", 
                                                        width: "90px",
                                                        template: "<a target='_blank' href='view_ticket.php?ticket_id=#=ticket_id#'>#=ticket_id#</a>"
                                                    },
                                                    {field: "name", title: "Customer Name", width: "120px"},
                                                    {field: "cost", title: "Cost", width: "50px"},
                                                    {field: "ordered", title: "Ordered Date", width: "100px"},
                                                    {field: "trackingnum", 
                                                        title: "Trackingnum", 
                                                        width: "100px",
                                                        template: "<a target='_blank' href='http://www.google.com/search?&amp;q=#=trackingnum#'>#=trackingnum#</a>"
                                                    },
                                                    {field: "received", title: "Received Date", width: "100px"}
                                                    
                                                ],
                                            });
                                        });

                                    </script>
                                    
                                        </div>
                                    </div>
                                    <!-- /selects, dropdowns -->
                                </div>
                                <!-- /Parts Order form elements -->



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
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');    ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
