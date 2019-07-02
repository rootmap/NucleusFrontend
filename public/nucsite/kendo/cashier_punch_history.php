<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], "store_punch_time");
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php
    include './plugin/plugin.php';
    $cms = new CmsRootPlugin();
    echo $cms->GeneralCss(array("kendo"));
    ?>
    <head><?php //echo $obj->bodyhead();  ?></head>
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
                if (isset($_GET['cashier'])) {
                    $sql_product = $obj->SelectAllByID_Multiple("store_punch_time", array("cashier_id" => $_GET['cashier'], "store_id" => $input_by));
                    $record = $obj->exists_multiple("store_punch_time", array("cashier_id" => $_GET['cashier'], "store_id" => $input_by));
                    $record_label = "| Record Found : " . $record . " | Report Generate For Cashier : " . $_GET['cashier'];
                } else {
                    $sql_product = $obj->SelectAllByID("store_punch_time", array("store_id" => $input_by));
                    $record = $obj->exists_multiple("store_punch_time", array("store_id" => $input_by));
                    $record_label = "| Record Found : " . $record;
                }
                ?>
                <!-- /info notice -->
                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="font-home"></i>Punch Log <?php echo $record_label; ?></h5><!-- | <a  data-toggle="modal" href="#myModal"> Search Cashier Wise </a>-->
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">


                            <!-- Dialog content -->
                            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <form action="" method="get">
                                    <div class="modal-header" style="height:25px;">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 id="myModalLabel"><i class="icon-calendar"></i> Search Datewise</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row-fluid">
                                            <div class="control-group">
                                                <label class="control-label">Select Cashier:</label>
                                                <div class="controls">
                                                    <select name="cashier" data-placeholder="Please Select Cashier..." class="select-search" tabindex="2">
                                                        <option value=""></option> 
                                                        <?php
                                                        if ($input_status == 1) {
                                                            $empdata = $obj->SelectAll("cashier_list");
                                                        } elseif ($input_status == 5) {
                                                            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
                                                            if (!empty($sqlchain_store_ids)) {
                                                                $array_ch = array();
                                                                foreach ($sqlchain_store_ids as $ch):
                                                                    array_push($array_ch, $ch->store_id);
                                                                endforeach;
                                                                include('class/report_chain_admin.php');
                                                                $obj_report_chain = new chain_report();
                                                                $sql_store = $obj_report_chain->SelectAllByID_Multiple_Or("cashier_list", $array_ch, "store_id", "1");
                                                            }
                                                            else {
                                                                $sql_store = "";
                                                            }
                                                        } else {
                                                            $empdata = $obj->SelectAllByID("cashier_list", array("store_id" => $input_by));
                                                        }
                                                        if (!empty($empdata))
                                                            foreach ($empdata as $emp):
                                                                ?>
                                                                <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option> 
                                                            <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary"  type="submit" name="search_date"><i class="icon-screenshot"></i> Search</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /dialog content -->
                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Content Start from here customized -->
                                <!-- Default datatable -->
                                <div class="block">
                                    <div class="table-overflow">
                                        
                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id #);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/cashier_punch_history.php",
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
                                                            url: "./controller/cashier_punch_history.php",
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
                                                                cashier_id: {type: "number"},
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
                                                        {field: "id", title: "#", width: "60px", filterable: false},
                                                        {field: "cashier_id", title: "Cashier ID"},
                                                        {field: "cashier", title: "Cashier"},
                                                        {field: "indate", title: "Date In", width: "120px"},
                                                        {field: "intime", title: "Time In", width: "120px"},
                                                        {field: "outdate", title: "Date Out", width: "120px"},
                                                        {field: "outtime", title: "Time Out", width: "120px"},
                                                        {field: "elapsed_time", title: "Elapsed Time(H:M:S)", filterable: false},
                                                        {
                                                            title: "Action", width: "80px",
                                                            template: kendo.template($("#action_template").html())
                                                        }
                                                    ],
                                                });
                                            });

                                        </script>




                                        <?php /* <table class="table table-striped" id="data-table">
                                          <thead>
                                          <tr>
                                          <th>#</th>
                                          <th>Cashier</th>
                                          <th>Date IN</th>
                                          <th>Time In</th>
                                          <th>Date Out</th>
                                          <th>Time Out</th>
                                          <th>Elapsed Time (HH:MM)</th>
                                          <th></th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $i=1;
                                          if(!empty($sql_product))
                                          foreach($sql_product as $product):
                                          ?>
                                          <tr>
                                          <td><?php echo $i; ?></td>
                                          <td><?php echo $obj->SelectAllByVal("cashier_list","id",$product->cashier_id,"name"); ?></td>
                                          <td><?php echo $product->indate; ?></td>
                                          <td><?php echo $product->intime; ?></td>
                                          <td><?php echo $product->outdate; ?></td>
                                          <td><?php echo $product->outtime; ?></td>
                                          <td>
                                          <?php
                                          if($product->outdate!='')
                                          {
                                          echo $obj->durations($product->indate." ".$product->intime,$product->outdate." ".$product->outtime);
                                          }
                                          ?>
                                          </td>
                                          <td>
                                          <a href="<?php echo $obj->filename(); ?>?del=<?php echo $product->id; ?>" class="btn btn-danger hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-remove"></i></a>

                                          </td>
                                          </tr>
                                          <?php
                                          $i++;
                                          endforeach; ?>
                                          </tbody>
                                          </table> */ ?>
                                    </div>
                                </div>
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
            <?php //include('include/footer.php');  ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');    ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
