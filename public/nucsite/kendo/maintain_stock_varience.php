<?php
include('class/auth.php');
$table="product_verience";
$cashman=0;
if ($input_status == 1 || $input_status == 2 || $input_status == 5) {
    $cashman=1;
}

if ($cashman != 1) {
    $obj->Success("Access Denied, Your Access is Resticted.", "startaverience.php");
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
                            <h5><i class="icon-random"></i> Maintain Stock Variance Report <?php if (isset($_GET['lotno'])) { ?> Detail | <a href="<?php echo $obj->filename(); ?>">Back To Maintain Stock Variance Report List</a> <?php } ?></h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>?pid=<?php echo $_GET['pid']; ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->

                                <div class="block">
                                    <?php
                                    if (!isset($_GET['lotno'])) {
                                        ?>
                                        <div class="table-overflow">

                                            <div id="grid" style="margin-left: 10px;margin-right: 10px;">

                                            </div>
                                            <script id="veriance" type="text/x-kendo-template">
                                                <a class="btn btn-info" href="<?php echo $obj->filename(); ?>?lotno=#=lotno#"><i class="icon-file"></i> Variance </a>
                                            </script>
                                            <script id="edit_client" type="text/x-kendo-template">
                                                <a href="javascript:void(0);" class="btn btn-danger hovertip" title="Delete Product" onclick="deleteClick(#=id#)"><i class="icon-trash"></i> Delete</a>
                                            </script>
                                            <script type="text/javascript">
                                                function deleteClick(id) {
                                                    var c = confirm("Do you want to delete?");
                                                    if (c === true) {
                                                        $.ajax({
                                                            type: "POST",
                                                            dataType: "json",
                                                            url: "./controller/veriance_maintain_stock.php",
                                                            data: {'id': id,'table':'varience'},
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
                                                                url: "./controller/veriance_maintain_stock.php<?php echo $cond; ?>",
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
                                                                    lotno: {type: "string"},
                                                                    input_bys: {type: "string"},
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
                                                            {field: "id", title: "#", width: "80px"},
                                                            {field: "lotno", title: "Variance ID", width: "60px"},
                                                            {field: "input_bys", title: "Created By", width: "90px"},
                                                            {field: "date", title: "Date", width: "90px"},
                                                            {
                                                                title: "Report", width: "100px",
                                                                template: kendo.template($("#veriance").html())
                                                            },
                                                            {
                                                                title: "Action", width: "100px",
                                                                template: kendo.template($("#edit_client").html())
                                                            }
                                                        ],
                                                    });
                                                });

                                            </script>













                                        </div>
                                    <?php } else {
                                        $lotno = $_GET['lotno']; ?>

                                        <div class="table-overflow">

                                            <div id="grid" style="margin-left: 10px;margin-right: 10px;">

                                            </div>
                                            <script id="veriance" type="text/x-kendo-template">
                                                #if (varience > 0) {# <label class="label label-info">Over Inventory : #=varience# </button> #}
                                                else 
                                                {# <label  class="label label-warning">Missing Inventory : #=varience#</button> #}#
                                            </script>
                                            <script id="edit_client" type="text/x-kendo-template">
                                                <a href="javascript:void(0);" class="btn btn-danger hovertip" title="Delete Product" onclick="deleteClick(#=id#)"><i class="icon-trash"></i> Delete</a>
                                            </script>
                                            <script type="text/javascript">
                                                function deleteClick(id) {
                                                    var c = confirm("Do you want to delete?");
                                                    if (c === true) {
                                                        $.ajax({
                                                            type: "POST",
                                                            dataType: "json",
                                                            url: "./controller/veriance_maintain_stock.php",
                                                            data: {'id': id,'table':'product_verience'},
                                                            success: function (result) {
                                                                $(".k-i-refresh").click();
                                                            }
                                                        });
                                                    }
                                                }

                                            </script>
                                            <?php
                                            $cond = $cms->FrontEndDateSearch('from', 'to');
                                            if (!empty($cond)) {
                                                $newcond = $cond . "&lotno=" . $lotno;
                                            } else {
                                                $newcond = "?lotno=" . $lotno;
                                            }
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
                                                                url: "./controller/veriance_maintain_stock.php<?php echo $newcond; ?>",
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
                                                                    lotno: {type: "string"},
                                                                    pname: {type: "string"},
                                                                    white: {type: "string"},
                                                                    warranty: {type: "string"},
                                                                    system_quantity: {type: "string"},
                                                                    quantity: {type: "string"},
                                                                    varience: {type: "string"},
                                                                    varianceprice: {type: "string"},                                                                 
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
                                                            {field: "id", title: "#", width: "80px"},
                                                            {field: "lotno", title: "Variance ID", width: "100px"},
                                                            {field: "pname", title: "Name", width: "180px"},
                                                            {field: "white", title: "White", width: "60px"},
                                                            {field: "warranty", title: "Warranty", width: "80px"},
                                                            {field: "system_quantity", title: "Quantity IN System", width: "130px"},
                                                            {field: "quantity", title: "Quantity ON Hand", width: "130px"},
                                                            {field: "varience", title: "Quantity Variance", width: "130px",template: kendo.template($("#veriance").html())},
                                                            {field: "varianceprice", title: "Cost Variance", width: "120px"},
                                                            {
                                                                title: "Action", width: "100px",
                                                                template: kendo.template($("#edit_client").html())
                                                            }
                                                        ],
                                                    });
                                                });

                                            </script>













                                        </div>

                                <?php } ?>
                                </div>
                                <?php /*
                                <div class="table-overflow">

                                    <?php
                                    if (!isset($_GET['lotno'])) {
                                        ?>
                                        <table class="table table-striped" id="data-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Variance ID</th>
                                                    <th>Created By</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_product=$obj->FlyQuery("SELECT a.*,s.name as input_bys FROM varience as a LEFT JOIN store as s on s.id=a.input_by WHERE a.store_id='" . $input_by . "' AND a.status='4' ORDER BY a.id DESC");
                                                $i=1;
                                                if (!empty($sql_product))
                                                    foreach ($sql_product as $product):
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $product->lotno; ?></td>
                                                            <td><?php echo $product->input_bys; ?></td>
                                                            <td><label class="label label-success"> <?php echo $product->date; ?> </label></td>
                                                            <td>
                                                                <a class="btn btn-info" href="<?php echo $obj->filename(); ?>?lotno=<?php echo $product->lotno; ?>"><i class="icon-list"></i> View Variance </a>
                                                                <a class="btn btn-danger" href="#"><i class="icon-trash"></i> Delete</a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    endforeach;
                                            }else {
                                                ?>
                                            <table class="table table-striped" id="data-table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Variance ID</th>
                                                        <th>Name</th>
                                                        <th>White</th>
                                                        <th>Black</th>
                                                        <th>Warranty</th>
                                                        <th>Quantity IN System</th>
                                                        <th>Quantity ON Hand</th>
                                                        <th>Quantity Variance</th>
                                                        <th>Cost Variance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $lotno=$_GET['lotno'];
                                                    $sql_product=$obj->SelectAllByID_Multiple("product_verience", array("store_id"=>$input_by, "lotno"=>$lotno, "status"=>4));
                                                    $i=1;
                                                    if (!empty($sql_product))
                                                        foreach ($sql_product as $product):
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $lotno; ?></td>
                                                                <td><label class="label label-success"> <?php echo $obj->SelectAllByVal("product", "id", $product->pid, "name"); ?> </label></td>
                                                                <td><?php echo $product->white; ?></td>
                                                                <td><?php echo $product->black; ?></td>
                                                                <td><?php echo $product->warranty; ?></td>
                                                                <td><?php
                                                                    $pc=$obj->SelectAllByVal("product", "id", $product->pid, "price_cost");
                                                                    $actinstock=$product->system_quantity;
                                                                    if ($actinstock > 0) {
                                                                        $instock=$actinstock;
                                                                    }else {
                                                                        $instock=0;
                                                                    }
                                                                    $varience=$product->quantity - $instock;
                                                                    $varianceprice=$varience * $pc;
                                                                    if ($varience > 0) {
                                                                        $mess="<label class='label label-info'>Over Inventory : " . $varience . "</button>";
                                                                    }else {
                                                                        $mess="<label  class='label label-warning'>Missing Inventory : " . $varience . "</button>";
                                                                    }
                                                                    echo $actinstock
                                                                    ?></td>
                                                         <!--<td><label class="label label-primary"> <?php //echo $product->quantity;                        ?> </label></td>-->
                                                                <td>
                                                                    <?php echo $product->quantity; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $mess; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo number_format($varianceprice, 2); ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        endforeach;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                </div> */ ?>
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
