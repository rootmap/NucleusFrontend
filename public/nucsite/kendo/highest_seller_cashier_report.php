<?php
include('class/auth.php');
include('class/report_customer.php');
$report=new report();
$table="sales";

if ($input_status == 5) {
    include('class/report_chain_admin.php');
    $obj_report_chain=new chain_report();
    $array_ch=array();
    $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
    if (!empty($sqlchain_store_ids))
        foreach ($sqlchain_store_ids as $ch):
            array_push($array_ch, $ch->store_id);
        endforeach;
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
                            <h5><i class="font-money"></i> Highest Seller Report </h5>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Content Start from here customized -->




                                <!-- General form elements -->
                                <div class="row-fluid block">



                                    <div class="table-overflow">
                                        
                                        
                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <script type="text/javascript">
                                            jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                    transport: {
                                                        read: {
                                                            url: "./controller/highest_seller_cashier_report.php",
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
                                                                store_id: {type: "number"},
                                                                cashier_name: {type: "string"},
                                                                solditem: {type: "string"}
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
                                                        {field: "id", title: "#", width: "30px", filterable: false},
                                                        {field: "store_id", title: "Store ID", width: "50px"},
                                                        {field: "name", title: "Cashier Name", width: "50px"},
                                                        {field: "solditem", title: "Sold Quantity", width: "50px"}
                                                    ],
                                                });
                                            });

                                        </script>
                                        
                                        
                                        
                                        
                                        
                                       <?php /* <table class="table table-striped" id="data-table">
                                            <thead>
                                            <th>#</th>
                                            <th>Store</th>
                                            <th>Cashier Name</th>
                                            <?php if ($input_status == 1 || $input_status == 5) { ?>
                                                <th>Store Name</th>
                                            <?php } ?>
                                            <th>Sold Quantity</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($input_status == 1) {
                                                    $sqlhighestsales=$report->SelectAllOrder("highest_sales", "sales", "desc");
                                                }elseif ($input_status == 5) {

                                                    $sqlhighestsales=$obj_report_chain->SelectAllByID_Multiple_Or("highest_sales", $array_ch, "input_by", "1");
                                                }else {
                                                    $sqlhighestsales=$report->SelectAllOrderCond1("highest_sales", "sales", "desc", "input_by", $input_by);
                                                }
                                                $i=1;
                                                if (!empty($sqlhighestsales))
                                                    foreach ($sqlhighestsales as $highestsales):
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $highestsales->input_by; ?></td>
                                                            <td><?php echo $highestsales->cashier; ?></td>
                                                            <?php if ($input_status == 1 || $input_status == 5) { ?>
                                                                <td><?php echo $obj->SelectAllByVal("store", "store_id", $highestsales->input_by, "name"); ?></td>
                                                            <?php } ?>
                                                            <td><strong><?php echo $highestsales->sales; ?></strong> Item Sold</td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    endforeach;
                                                ?>
                                            </tbody>
                                        </table> */?>
                                    </div>


                                </div>
                                <!-- /general form elements -->



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
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
