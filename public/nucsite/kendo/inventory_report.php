<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "coustomer";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php //echo $obj->bodyhead(); ?>
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
                            <h5><i class="icon-hdd"></i>
                                <span style="border-right:2px #333 solid; padding-right:10px;">Inventory Report </span>
                                <span><i class="font-calendar"></i> <a data-toggle="modal" href="#myModal"> Generate Inventory Report</a></span> 
                            </h5>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Content Start from here customized -->

                                <!-- Dialog content -->
                                <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 id="myModalLabel"><i class="font-calendar"></i>  Generate Inventory Report <span id="mss"></span></h5>
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


                                <!-- General form elements -->
                                

                                    <div class="table-overflow">

                                        <div id="grid" style="margin-left: 10px; margin-right: 10px;"></div>
                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>
                                        <script id="profit" type="text/x-kendo-template">
                                            $#= kendo.toString(paid-our_cost, "n2")#
                                        </script>
                                        <script id="checkin_link" type="text/x-kendo-template">
                                            <a class="k-button" href="view_checkin.php?ticket_id=#=checkin_id#">#=checkin_id#</a>
                                        </script>
                                        <script type="text/javascript">
                                            jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                    transport: {
                                                        read: {
                                                            url: "./controller/inventory_report.php<?php echo $cond; ?>",
                                                            type: "GET",
                                                            datatype: "json",
                                                            complete: function (response) {
                                                                var page_countitem = 0;
                                                                var page_sold = 0;
                                                                var page_stock = 0;
                                                                jQuery.each(response, function (index, key) {
                                                                    if (index == 'responseJSON')
                                                                    {
                                                                        //console.log(key.data);
                                                                        jQuery.each(key.data, function (datagr, keyg) {
                                                                            //console.log(keyg.our_cost);
                                                                            page_countitem += (1 - 0);
                                                                            page_sold += (keyg.sold - 0);
                                                                            page_stock += (keyg.stock - 0);

                                                                        });
                                                                        //console.log(page_ourcost);
                                                                        jQuery("#a1").html(page_countitem + "  of  " + key.total);
                                                                        jQuery("#a2").html(page_sold);
                                                                        jQuery("#a3").html(page_stock);

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
                                                                id: {nullable: true},
                                                                barcode: {type: "string"},
                                                                name: {type: "string"},
                                                                price_cost: {type: "number"},
                                                                price_retail: {type: "number"},
                                                                sold: {type: "number"},
                                                                stock: {type: "number"},
                                                                date: {type: "string"}
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
                                                        pageSizes:[10, 20, 50, 100, 200, 400, 1000, 10000, 50000]
                                                    },
                                                    sortable: true,
                                                    groupable: true,
                                                    columns: [
                                                        {field: "id", title: "P.ID", width: "60px"},
                                                        {field: "barcode", title: "Barcode"},
                                                        {field: "name", title: "Name", width: "220px"},
                                                        {title: "Our Cost", template: "<?php echo $currencyicon; ?>#=price_cost#", filter: false},
                                                        {title: "Retail Price", template: "<?php echo $currencyicon; ?>#=price_retail#"},
                                                        {title: "Sold Quantity", template: "#=sold#"},
                                                        {title: "Stock Quantity", template: "#=stock#"},
                                                        {field: "date", title: "Date", width: "90px"}
                                                    ]
                                                });
                                            });

                                        </script>













                                    </div>

                                    <?php /*
                                      <div class="table-overflow">
                                      <table class="table table-striped" id="data-table">
                                      <thead>
                                      <tr>
                                      <th>#</th>
                                      <?php if ($input_status == 1 || $input_status == 5) { ?>
                                      <th>Store Name</th>
                                      <?php } ?>
                                      <th>UPC / Barcode</th>
                                      <th>Name</th>
                                      <th>Our Cost</th>
                                      <th>Retail Cost</th>
                                      <th>Stock</th>
                                      <th>Sold Quantity</th>
                                      <th>Re-Order</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <?php
                                      //                                                if ($input_status == 1) {
                                      //                                                    $sql_product=$obj->Product_report("product", "status", "1", "status", "3", "1");
                                      //                                                }elseif ($input_status == 5) {
                                      //
                                      //                                                    $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
                                      //                                                    if (!empty($sqlchain_store_ids)) {
                                      //                                                        $array_ch=array();
                                      //                                                        foreach ($sqlchain_store_ids as $ch):
                                      //                                                            array_push($array_ch, $ch->store_id);
                                      //                                                        endforeach;
                                      //                                                        include('class/report_chain_admin.php');
                                      //                                                        $obj_report_chain=new chain_report();
                                      //                                                        $sql_product=$obj_report_chain->SelectAllByID_Multiple_Or("product_checkin_inventory", $array_ch, "input_by", "1");
                                      //
                                      //                                                        //echo "Work";
                                      //                                                    }
                                      //                                                    else {
                                      //                                                        //echo "Not Work";
                                      //                                                        $sql_product="";
                                      //                                                    }
                                      //                                                }else {
                                      //                                                    $sql_product=$obj->Product_report_Store("product", "status", "1", "status", "3", "1", "input_by", $input_by);
                                      //                                                    //$sql_product=$obj->Product_report("product","status","1","status","3","1");
                                      //                                                }
                                      //                                                $i=1;
                                      if (!empty($sql_product))
                                      foreach ($sql_product as $product):
                                      ?>
                                      <tr>
                                      <td><?php echo $i; ?></td>
                                      <?php if ($input_status == 1 || $input_status == 5) { ?>
                                      <td><?php echo $obj->SelectAllByVal("store", "store_id", $product->input_by, "name"); ?></td>
                                      <?php } ?>
                                      <td><label class="btn"> <?php echo $product->barcode; ?> </label></td>
                                      <td><label class="label label-success"> <?php echo $product->name; ?> </label></td>
                                      <td><label class="label"> <?php echo $product->price_cost; ?> </label></td>
                                      <td><label class="label"> <?php echo $product->price_retail; ?> </label></td>
                                      <td><label class="btn">
                                      <?php
                                      $stock=$obj->escape_empty($obj->SelectAllByVal("product_report", "id", $product->id, "quantity"));
                                      $sold=$obj->escape_empty($obj->SelectAllByVal("product_report", "id", $product->id, "soldquantity"));
                                      $instock=$stock - $sold;
                                      echo $instock;
                                      ?> </label></td>
                                      <td><label class="btn"> <?php echo $obj->escape_empty($obj->SelectAllByVal("product_report", "id", $product->id, "soldquantity")); ?> </label></td>
                                      <td><label class="label label-primary"> <?php echo $obj->escape_empty($product->reorder); ?> </label></td>
                                      </tr>
                                      <?php
                                      $i++;
                                      endforeach;
                                      ?>
                                      </tbody>
                                      </table>
                                      </div>

                                     */ ?>


                                    <div style="margin-top:10px; margin-left: 10px;" class="table-overflow">

                                        <table class="table table-striped" style="width:250px;">
                                            <tbody>
                                                <tr>
                                                    <td>1. Total Item Showing </td>
                                                    <td id="a1"><?php //echo $a;     ?></td>
                                                </tr>
                                                <tr>
                                                    <td>2. Total Sold Quantity  </td>
                                                    <td id="a2">$<?php //echo $b;     ?></td>
                                                </tr>
                                                <tr>
                                                    <td>3. Total Stock Quantity  </td>
                                                    <td id="a3">$<?php //echo $c;     ?></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                
                                <!-- /general form elements -->
                                <!-- Default datatable -->

                                <!-- /default datatable -->


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
            <?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
