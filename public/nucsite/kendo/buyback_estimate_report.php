<?php
include('class/auth.php');
//if($input_status!=1)
//{
//	$obj->Error("Invalid Page Request.","index.php");
//}
include('class/report_customer.php');
$report = new report();
$table = "buyback_estimate";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo", "modal"));
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
                            <?php
                            echo $obj->ShowMsg();
//                            if (isset($_GET['from'])) {
//                                $from = $_GET['from'];
//                                $to = $_GET['to'];
//                                if ($input_status == 1) {
//                                    $sqlinvoice = $report->SelectAllDate($table, $from, $to, "1");
//                                    $record = $report->SelectAllDate($table, $from, $to, "2");
//                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//                                } elseif ($input_status == 5) {
//                                    $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
//                                    if (!empty($sqlchain_store_ids)) {
//                                        $array_ch = array();
//                                        foreach ($sqlchain_store_ids as $ch):
//                                            array_push($array_ch, $ch->store_id);
//                                        endforeach;
//
//                                        include('class/report_chain_admin.php');
//                                        $obj_report_chain = new chain_report();
//
//                                        $sqlinvoice = $obj_report_chain->ReportQuery_Datewise_Or($table, $array_ch, "store_id", $_GET['from'], $_GET['to'], "1");
//                                        $record = $obj_report_chain->ReportQuery_Datewise_Or($table, $array_ch, "store_id", $_GET['from'], $_GET['to'], "2");
//                                        $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//                                    }
//                                    else {
//                                        $sqlinvoice = "";
//                                        $record = 0;
//                                        $record_label = "Total record Found ( " . $record . " ).";
//                                    }
//                                } else {
//                                    $sqlinvoice = $report->ReportQuery_Datewise($table, array("store_id" => $input_by), $from, $to, "1");
//                                    $record = $report->ReportQuery_Datewise($table, array("store_id" => $input_by), $from, $to, "2");
//                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//                                }
//                            } else {
//                                if ($input_status == 1) {
//                                    $sqlinvoice = $obj->SelectAllByID($table, array("date" => date('Y-m-d')));
//                                    $record = $obj->exists_multiple($table, array("date" => date('Y-m-d')));
//                                    $record_label = "Total Record Found ( " . $record . " )";
//                                } elseif ($input_status == 5) {
//                                    $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
//                                    if (!empty($sqlchain_store_ids)) {
//                                        $array_ch = array();
//                                        foreach ($sqlchain_store_ids as $ch):
//                                            array_push($array_ch, $ch->store_id);
//                                        endforeach;
//
//                                        include('class/report_chain_admin.php');
//                                        $obj_report_chain = new chain_report();
//
//                                        $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple_Or($table, $array_ch, "store_id", "1");
//                                        $record = $obj_report_chain->SelectAllByID_Multiple_Or($table, $array_ch, "store_id", "2");
//                                        $record_label = "Total record Found ( " . $record . " )";
//                                    }
//                                    else {
//                                        $sqlinvoice = "";
//                                        $record = 0;
//                                        $record_label = "Total record Found ( " . $record . " ).";
//                                    }
//                                } else {
//                                    $sqlinvoice = $obj->SelectAllByID_Multiple($table, array("store_id" => $input_by, "date" => date('Y-m-d')));
//                                    $record = $obj->exists_multiple($table, array("store_id" => $input_by, "date" => date('Y-m-d')));
//                                    $record_label = "Total Record Found ( " . $record . " )";
//                                }
//                            }
                            ?>
                            <h5><i class="font-money"></i> Buyback Estimate Request Report  | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Content Start from here customized -->




                                <!-- General form elements -->
                                <div class="row-fluid block">

                                    <!-- Dialog content -->
                                    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h5 id="myModalLabel"><i class="font-calendar"></i> Generate BuyBack Estimate Report <span id="mss"></span></h5>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row-fluid">
                                                <form class="form-horizontal" method="get" action="">
                                                    <div class="control-group">
                                                        <label class="control-label"><strong>Date Search:</strong></label>
                                                        <div class="controls">
                                                            <ul class="dates-range">
                                                                <li><input type="text" id="fromDate" name="from" placeholder="From" /></li>
                                                                <li class="sep">-</li>
                                                                <li><input type="text" id="toDate" name="to" placeholder="To" /></li>
                                                                <li class="sep">&nbsp;</li>
                                                                <li><button class="btn btn-primary" type="submit">Search Report</button></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /dialog content --> 

                                    <div class="table-overflow">



                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/buyback_estimate_report.php",
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
                                                            url: "./controller/buyback_estimate_report.php",
                                                            type: "GET",
                                                            datatype: "json",
                                                            complete: function (response) {
                                                                var page_quantity = 0;
                                                                var page_amount = 0;
                                                                jQuery.each(response, function (index, key) {
                                                                    if (index == 'responseJSON')
                                                                    {
                                                                        //console.log(key.data);
                                                                        jQuery.each(key.data, function (datagr, keyg) {
                                                                            page_quantity += (1 - 0);
                                                                            page_amount += (keyg.amount - 0);


                                                                        });
                                                                        //console.log(page_ourcost);
                                                                        jQuery("#a1").html(page_quantity + "  of  " + key.total);
                                                                        jQuery("#a2").html("<?php echo $currencyicon; ?>" + page_amount);

                                                                    }
                                                                })
                                                            }

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
                                                                customer_name: {type: "string"},
                                                                carrier: {type: "string"},
                                                                device: {type: "string"},
                                                                d_condition: {type: "string"},
                                                                device_turn_on: {type: "string"},
                                                                water_damage: {type: "string"},
                                                                memory_size: {type: "string"},
                                                                amount: {type: "string"}
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
                                                        {field: "id", title: "#", width: "40px", filterable: false},
                                                        {field: "customer_name", title: "Customer Name ", width: "100px"},
                                                        {field: "carrier", title: "Carrier ", width: "70px"},
                                                        {field: "device", title: "Device ", width: "70px"},
                                                        {field: "d_condition", title: "Condition ", width: "80px"},
                                                        {field: "device_turn_on", title: "Device Turn On ", width: "100px"},
                                                        {field: "water_damage", title: "Water Damage ", width: "100px"},
                                                        {field: "memory_size", title: "Memory Size ", width: "80px"},
                                                        {template: "<?php echo $currencyicon; ?>#=amount#", title: "Amount ", width: "70px", }
                                                    ],
                                                });
                                            });

                                        </script>











                                        <?php /* <table class="table table-striped" id="data-table">
                                          <thead>
                                          <tr>
                                          <th>#</th>

                                          <th>Customer</th>
                                          <th>Carrier</th>
                                          <th>Device</th>
                                          <th>Condition</th>
                                          <th>Device Turn On</th>

                                          <th>Water Damage</th>
                                          <th>Memory Size</th>
                                          <th>Amount</th>

                                          <th></th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $i=1;
                                          $aa=0; $bb=0;  $cc=0;  $dd=0;
                                          if(!empty($sqlinvoice))
                                          foreach($sqlinvoice as $invoice):
                                          $aa+=1;
                                          $bb+=$invoice->amount;
                                          ?>
                                          <tr>
                                          <td><?php echo $i; ?></td>

                                          <td>
                                          <?php echo $obj->SelectAllByVal("customer_list","id",$invoice->customer_id,"fullname"); ?>
                                          </td>
                                          <td>
                                          <?php echo $obj->SelectAllByVal("buyback_network","id",$invoice->nid,"name"); ?>
                                          </td>
                                          <td>
                                          <?php echo $obj->SelectAllByVal("buyback_device_type","id",$invoice->dtid,"name"); ?> - <?php echo $obj->SelectAllByVal("buyback_model","id",$invoice->model,"name"); ?>
                                          </td>
                                          <td>
                                          <?php echo $obj->SelectAllByVal("buyback_device_condition","id",$invoice->cid,"name"); ?>
                                          </td>
                                          <td>
                                          <?php echo $obj->SelectAllByVal("buyback_device_turn_on","id",$invoice->dtoid,"name"); ?>
                                          </td>
                                          <td>
                                          <?php echo $obj->SelectAllByVal("buyback_water_damage","id",$invoice->wdid,"name"); ?>
                                          </td>
                                          <td>
                                          <?php echo $obj->SelectAllByVal("buyback_memory_size","id",$invoice->msid,"name"); ?>
                                          </td>
                                          <td>
                                          <?php if($invoice->amount==''){ ?>
                                          <label class="label label-warning"> Price Not Set Yet </label>
                                          <?php }else{ ?>
                                          <label class="label label-success"> $<?php echo $invoice->amount; ?> </label>                                                            <?php } ?>
                                          </td>

                                          <td>
                                          <?php if($input_status==1 || $input_status==2 || $input_status==5) { ?>
                                          <a href="<?php echo $obj->filename(); ?>?del=<?php echo $invoice->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
                                          <?php } ?>
                                          </td>
                                          </tr>
                                          <?php
                                          $i++;
                                          endforeach;
                                          ?>
                                          </tbody>
                                          </table> */ ?>




                                        <div class="block well span4" style="margin-left:10px; margin-top: 10px;">
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <h5> BuyBack Estimate Report</h5>
                                                </div>
                                            </div>
                                            <div class="table-overflow">
                                                <table class="table table-condensed">
                                                    <tbody>
                                                        <tr>
                                                            <td>1. Total Quantity = <strong id="a1"> <?php //echo //$aa;   ?></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>2. Total Amount = <strong id="a2"> $<?php //echo number_format($bb, 2);   ?></strong></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Table condensed -->

                                    <!-- /table condensed -->


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
            <?php //include('include/footer.php');  ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
