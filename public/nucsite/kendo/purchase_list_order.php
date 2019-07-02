<?php
include('class/auth.php');
$table = "purchase";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
}

function purchase_status($st) {
    if ($st == 1) {
        return "Pending";
    } elseif ($st == 2) {
        return "Partial";
    } elseif ($st == 3) {
        return "Complete";
    }
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
                            <h5><i class="icon-tasks"></i> Purchase Order List <?php if ($input_status == 1 || $input_status == 2 || $input_status == 5) { ?>| <a href="purchase.php"><i class="icon-plus-sign"></i> Place New Purchase Order</a><?php } ?></h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Content container -->
                            <div class="container">



                                <div class="block">
                                    
                                <!-- Content Start from here customized -->


                                    <div class="table-overflow">

                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;">

                                        </div>
                                        <script id="purchase_status" type="text/x-kendo-template">
                                            #if(status==1){# Pending #}
                                            else if(status==2){# Partial #}
                                            else{# Complete #}#
                                        </script>
                                        <script id="edit_client" type="text/x-kendo-template">
                                            <a href="purchase.php?edit=#=id#" class="hovertip"   onclick="javascript:return confirm('Are you absolutely sure to Edit This?')" title="Edit Detail"><i class="icon-edit"></i></a>
                                            <a href="javascript:void(0);" class="hovertip" title="Delete Product" onclick="deleteClick(#=id#)"><i class="icon-trash"></i></a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/purchase_inventory.php",
                                                        data: {id: id},
                                                        success: function (result) {
                                                            $(".k-i-refresh").click();
                                                        }
                                                    });
                                                }
                                            }

                                        </script>
                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>
                                        <script type="text/javascript">
                                            var gridElement = $("#grid");

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
                                                            url: "./controller/purchase_inventory.php<?php echo $cond; ?>",
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
                                                                order_id: {type: "string"},
                                                                vendor: {type: "string"},
                                                                expec_date: {type: "string"},
                                                                ship_notes: {type: "string"},
                                                                gene_notes: {type: "string"},
                                                                total: {type: "string"},
                                                                status: {type: "string"}
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
                                                        {field: "id", title: "P.ID", width: "60px"},
                                                        {field: "order_id", title: "Order ID", width: "90px",
                                                        template: kendo.template('<a href="./purchase_view.php?order_id=#=order_id#">#=order_id#</a>')
                                                        },
                                                        {field: "ship_notes", title: "Shipping Notes", width: "90px"},
                                                        {field: "gene_notes", title: "General Notes", width: "80px"},
                                                        {field: "status", title: "Status", width: "50px",template: kendo.template($("#purchase_status").html())},
                                                        {field: "vendor", title: "Vendor", width: "50px"},
                                                        {field: "expec_date", title: "Expected", width: "50px"},
                                                        {template: "<?php echo $currencyicon; ?>#=total#", title: "Total", width: "50px"},
                                                        {
                                                            title: "Action", width: "60px",
                                                            template: kendo.template($("#edit_client").html())
                                                        }
                                                    ],
                                                });
                                            });

                                        </script>













                                    </div>
                                </div>

                                <?php /*    <form class="form-horizontal" method="get" name="invoice" action="create_invoice.php">
                                  <fieldset>
                                  <!-- General form elements -->
                                  <div class="row-fluid  span12 well">
                                  <div class="table-overflow">
                                  <table class="table table-striped" id="data-table">
                                  <thead>
                                  <tr>
                                  <th>#</th>
                                  <th>Order ID</th>
                                  <th>Shipping Notes</th>
                                  <th>General Notes</th>
                                  <th>Status</th>
                                  <th>Vendor</th>
                                  <th>Expected</th>
                                  <th>Total</th>
                                  <th width="60">Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                  if ($input_status == 1) {
                                  $sqlpurchase_list=$obj->SelectAll($table);
                                  }elseif ($input_status == 5) {
                                  $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
                                  if (!empty($sqlchain_store_ids)) {
                                  $array_ch=array();
                                  foreach ($sqlchain_store_ids as $ch):
                                  array_push($array_ch, $ch->store_id);
                                  endforeach;

                                  include('class/report_chain_admin.php');
                                  $obj_report_chain=new chain_report();

                                  $sqlpurchase_list=$obj_report_chain->SelectAllByID_Multiple_Or($table, $array_ch, "store_id", "1");
                                  }
                                  else {
                                  //echo "Not Work";
                                  $sqlpurchase_list="";
                                  $record=0;
                                  $record_label="Total Record ( " . $record . " )";
                                  }
                                  }else {
                                  $sqlpurchase_list=$obj->SelectAllByID($table, array("store_id"=>$input_by));
                                  }
                                  $i=1;
                                  if (!empty($sqlpurchase_list))
                                  foreach ($sqlpurchase_list as $list):
                                  ?>
                                  <tr>
                                  <td><?php echo $i; ?></td>
                                  <td><a href="./purchase_view.php?order_id=<?php echo base64_encode($list->order_id); ?>"><?php echo $list->order_id; ?></a></td>
                                  <td><?php echo $list->ship_notes; ?></td>
                                  <td><?php echo $list->gene_notes; ?></td>
                                  <td><?php echo purchase_status($list->status); ?></td>
                                  <td><?php echo $list->vendor; ?></td>
                                  <td><?php echo $list->expec_date; ?></td>
                                  <td>$<?php echo @number_format($list->total, 2); ?></td>
                                  <td>
                                  <a href="purchase.php?edit=<?php echo $list->id; ?>" class="hovertip"   onclick="javascript:return confirm('Are you absolutely sure to Edit This?')" title="Edit Detail"><i class="icon-edit"></i></a>
                                  <a href="<?php echo $obj->filename(); ?>?del=<?php echo $list->id; ?>" class="hovertip"   onclick="javascript:return confirm('Are you absolutely sure to Delete This?')" title="Delete Detail"><i class="icon-trash"></i></a>
                                  </td>
                                  </tr>
                                  <?php
                                  $i++;
                                  endforeach;
                                  ?>
                                  </tbody>
                                  </table>
                                  </div>
                                  </div>
                                  <!-- /general form elements -->


                                  <div class="clearfix"></div>

                                  <!-- Default datatable -->

                                  <!-- /default datatable -->


                                  </fieldset>

                                  </form>
                                 */ ?>

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

        </div>
        <!-- /main wrapper -->

    </body>
</html>
