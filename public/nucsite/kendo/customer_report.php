<?php
include('class/auth.php');
include('class/report_customer.php');
$report=new report();
$table="coustomer";
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
                <?php
                echo $obj->ShowMsg();

//                if ($input_status == 1) {
//                    $sqlticket=$obj->SelectAll($table);
//                    $record=$obj->totalrows($table);
//                    $record_label="";
//
//                    if (isset($_GET['from'])) {
//                        $status_data=1;
//                        $from=$_GET['from'];
//                        $to=$_GET['to'];
//                    }else {
//                        $status_data=0;
//                    }
//                }elseif ($input_status == 5) {
//
//                    $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
//                    if (!empty($sqlchain_store_ids)) {
//                        $array_ch=array();
//                        foreach ($sqlchain_store_ids as $ch):
//                            array_push($array_ch, $ch->store_id);
//                        endforeach;
//
//                        include('class/report_chain_admin.php');
//                        $obj_report_chain=new chain_report();
//                        $sqlticket=$obj_report_chain->SelectAllByID_Multiple2_Or($table, array("status"=>1), $array_ch, "input_by", "1");
//                        $record=$obj_report_chain->SelectAllByID_Multiple2_Or($table, array("status"=>1), $array_ch, "input_by", "2");
//                        ;
//                        $record_label="";
//                        //echo "Work";
//                        if (isset($_GET['from'])) {
//                            $status_data=1;
//                            $from=$_GET['from'];
//                            $to=$_GET['to'];
//                        }else {
//                            $status_data=0;
//                        }
//                    }else {
//                        //echo "Not Work";
//                        $sqlticket="";
//                        $record=0;
//                        $record_label="";
//                    }
//                }else {
//                    $sqlticket=$obj->FlyQuery("SELECT * FROM `" . $table . "` WHERE input_by='" . $input_by . "'");
//                    $record=$obj->exists_multiple($table, array("input_by"=>$input_by));
//                    $record_label="";
//                    if (isset($_GET['from'])) {
//                        $status_data=1;
//                        $from=$_GET['from'];
//                        $to=$_GET['to'];
//                    }else {
//                        $status_data=0;
//                    }
//                }
                ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="icon-th-large"></i>Customer Report Info  
                        </div><!-- /page header -->

                        <div class="body">
                            <!-- Dialog content -->
                            
                            <!-- /dialog content -->
                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Content Start from here customized -->




                                <!-- General form elements -->
                                <div class="row-fluid block">

                                    
                                
                                <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                

                                <script id="edit_client" type="text/x-kendo-template">
                                    <a class="k-button k-button-icontext k-grid-delete" href="customer_all_report.php?cid=#= id #"><span class="k-icon k-info"></span>View Detail Report</a> 
                                </script>
                                
                                <?php
                                $cond = $cms->FrontEndDateSearch('from', 'to');
                                ?>
                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        var dataSource = new kendo.data.DataSource({
                                            transport: {
                                                read: {
                                                    url: "./controller/customer_report.php<?php echo $cond; ?>",
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
                                                        full_name: {type: "string"},
                                                        total_invoice: {type: "string"},
                                                        total_estimate: {type: "string"},
                                                        total_checkin_ticket: {type: "string"},
                                                        total_parts_order: {type: "string"}
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
                                                {field: "id", title: "CID", width: "80px"},
                                                {field: "full_name", title: "Full Name"},
                                                {template: "#=total_invoice# Invoice", title: "Total Invoice"},
                                                {template: "#=total_estimate# Estimate", title: "Total Estimate"},
                                                {template: "#=total_checkin_ticket# Repair/Ticket", title: "Total Checkin/Ticket"},
                                                {template: "#=total_parts_order# Parts Order", title: "Total Parts Order"},
                                                {
                                                    title: "Action", width: "160px",
                                                    template: kendo.template($("#edit_client").html())
                                                }
                                            ],
                                        });
                                    });

                                </script>

                                    <?php /* <div class="table-overflow">
                                        <table class="table table-striped" id="data-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name/Business</th>
                                                    <?php if ($input_status == 1 || $input_status == 5) { ?>
                                                        <th>Store</th>
                                                    <?php } ?>
                                                    <th>Sales</th>
                                                    <th>Invoice</th>
                                                    <th>Estimate</th>
                                                    <th>Ticket</th>
                                                    <th>Parts Order</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $i=1;
                                                if (!empty($sqlticket))
                                                    foreach ($sqlticket as $customer):


                                                        if ($status_data == 1) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $customer->firstname; ?> <?php echo $customer->lastname; ?></td>
                                                                <?php if ($input_status == 1 || $input_status == 5) { ?>
                                                                    <td><?php echo $obj->SelectAllByVal("store", "store_id", $customer->input_by, "name"); ?></td>
                                                                <?php } ?>
                                                                <td><?php echo $report->count_invoice_report_date($customer->id, "invoice", 3, $from, $to); ?> Sales</td>
                                                                <td><?php echo $report->count_invoice_report_date($customer->id, "invoice", 3, $from, $to); ?> Invoice</td>
                                                                <td><?php echo $report->count_invoice_report_date($customer->id, "invoice", 2, $from, $to); ?> Estimate</td>
                                                                <td><?php echo $report->count_ticket_report_date($customer->id, "ticket", $from, $to); ?> Ticket</td>
                                                                <td><?php echo $report->count_parts_report_date($customer->id, "parts_order", $from, $to); ?> Parts</td>
                                                                <td><a href="customer_all_report.php?cid=<?php echo $customer->id; ?>" class="btn btn-success"><i class="icon-list"></i> View All Report</a></td>
                                                            </tr>
                                                            <?php
                                                        }else {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $customer->firstname; ?> <?php echo $customer->lastname; ?></td>
                                                                <?php if ($input_status == 1 || $input_status == 5) { ?>
                                                                    <td><?php echo $obj->SelectAllByVal("store", "store_id", $customer->input_by, "name"); ?></td>
                                                                <?php } ?>
                                                                <td><?php echo $report->count_invoice_report_single_date_sales($customer->id, "invoice", 3, date('Y-m-d')); ?> Sales</td>
                                                                <td><?php echo $report->count_invoice_report_single_date($customer->id, "invoice", 3, date('Y-m-d')); ?> Invoice</td>
                                                                <td><?php echo $report->count_invoice_report_single_date($customer->id, "invoice", 2, date('Y-m-d')); ?> Estimate</td>
                                                                <td><?php echo $report->count_ticket_report_single_date($customer->id, "ticket", date('Y-m-d')); ?> Ticket</td>
                                                                <td><?php echo $report->count_parts_report_single_date($customer->id, "parts_order", date('Y-m-d')); ?> Parts</td>
                                                                <td><a href="customer_all_report.php?cid=<?php echo $customer->id; ?>" class="btn btn-success"><i class="icon-list"></i> View All Report</a></td>
                                                            </tr>
                                                            <?php
                                                        }

                                                        $i++;
                                                    endforeach;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div> */ ?>



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
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
