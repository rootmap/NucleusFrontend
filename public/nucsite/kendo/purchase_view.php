<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    if (!isset($_GET['order_id'])) {
        $obj->Error("Invalid Request.", "purchase_list_order.php");
    }
}

$order_id=$_GET['order_id'];

$table="purchase";

if (isset($_GET['id'])) {
    extract($_GET);
    $upst=$obj->update("purchase_order_issue", array("id"=>$id, "received_id"=>$input_bys, "received_date"=>date('Y-m-d'), "status"=>2));
    if ($upst == 1) {
        $obj->Success("Successfully Received.", $obj->filename() . "?order_id=" . base64_encode($_GET['order_id']));
    }else {
        $obj->Error("Failed To Received, Please Try again.", $obj->filename() . "?order_id=" . base64_encode($_GET['order_id']));
    }
}



if (isset($_POST['editcreate'])) {
    extract($_POST);
    if (!empty($vendor) && !empty($expect_date) && !empty($ship_notes) && !empty($gener_notes)) {
        if ($obj->update($table, array("id"=>$id, "vendor"=>$vendor, "store_id"=>$input_by, "expec_date"=>$expect_date, "ship_notes"=>$ship_notes, "gene_notes"=>$gener_notes, "total"=>$total, "date"=>date('Y-m-d'), "status"=>$status)) == 1) {
            $obj->Success("Successfully Updated.", $obj->filename() . "?edit=" . $id);
        }else {
            $obj->Error("Something is wrong, Try again.", $obj->filename() . "?edit=" . $id);
        }
    }else {
        $obj->Error("Failed, Fill up required field", $obj->filename() . "?edit=" . $id);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
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
                            <h5><i class="font-cogs"></i> Purchase Order Detail </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');           ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <?php
                                $editst=FALSE;
                                if ($input_status == 1 || $input_status == 2 || $input_status == 5) {
                                    $editst=FALSE;
                                    ?>
                                    <a href="purchase.php" class="btn btn-success"> <i class="icon-plus-sign"></i> New Purchase Order  </a>
                                    <a href="purchase_list_order.php" class="btn btn-success"> <i class="icon-tasks"></i> List Purchase Order  </a>
                                    <?php
                                }else {
                                    $editst=TRUE;
                                    ?>
                                    <a href="purchase_list_order.php" style="margin-bottom: 10px;" class="btn btn-success"> <i class="icon-tasks"></i> Back To Purchase Order List  </a>
                                    <?php
                                }
                                ?>

                                <!-- Content Start from here customized -->


                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->

                                        <div class="row-fluid  span12 well">
                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">

                                                <div class="control-group">
                                                    <label class="span12"> Vendor : <?php echo $obj->SelectAllByVal($table, "order_id", $order_id, "vendor"); ?> </label>
                                                    <input class="span10" <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  value="<?php echo $order_id; ?>" type="hidden" name="id" />
                                                    <input class="span10" <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  value="<?php echo $order_id; ?>" type="hidden" name="edit" />
                                                </div>

                                                <div class="control-group">
                                                    <label class="span12"> Expected Date : <?php echo $obj->SelectAllByVal($table, "order_id", $order_id, "expec_date"); ?> </label>
                                                </div>


                                                <div class="control-group">
                                                    <label class="span12"> Shipping notes : <?php echo $obj->SelectAllByVal($table, "order_id", $order_id, "ship_notes"); ?> </label>
                                                </div>


                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">


                                                <div class="control-group">
                                                    <label class="span12"> General Notes : <?php echo $obj->SelectAllByVal($table, "order_id", $order_id, "gene_notes"); ?> </label>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span12"> Total Cost : <?php echo $obj->SelectAllByVal($table, "order_id", $order_id, "total"); ?></label>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span12"> Order Status

                                                        <?php $order_status=$obj->SelectAllByVal($table, "order_id", $order_id, "status"); ?>
                                                        <?php if ($order_status == 1) { ?> Pending <?php } ?>
                                                        <?php if ($order_status == 2) { ?> Partial <?php } ?>
                                                        <?php if ($order_status == 3) { ?> Completed <?php } ?></label>

                                                </div>

                                            </div>
                                            <!-- /selects, dropdowns -->



                                        </div>
                                        <!-- /general form elements -->


                                        <div class="row-fluid  span12 well">
                                            <!-- Selects, dropdowns -->

                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->

                                            <div class="clearfix"></div>

                                            <table class="table table-striped table-bordered"  id="productmore">
                                                <thead>
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Product</th>
                                                        <th style="text-align:right;">Quantity</th>
                                                        <th style="text-align:right;">Unite Price</th>
                                                        <th style="text-align:right;">Retail Price</th>
                                                        <?php if ($input_status == 3 || $input_status == 4) { ?>
                                                            <th style="text-align:center;">Add To Store<input type="hidden" id="currentId"></th>
                                                        <?php }else {
                                                            ?>
                                                            <th style="text-align:center;">Received By</th>
                                                            <th style="text-align:center;">Received Date</th>
                                                        <?php }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody id="POITable">
                                                    <?php
                                                    $sqlorderproduct=$obj->FlyQuery("SELECT a.*,p.name,s.name as sname FROM purchase_order_issue as a
LEFT JOIN product as p on p.id=a.pid
LEFT JOIN store as s on s.id=a.received_id WHERE a.order_id='" . $order_id . "'");
                                                    $products=0;
                                                    $sl=1;
                                                    $total_unit_price=0;
                                                    $total_retail_price=0;
                                                    $products_quantity=0;
                                                    if (!empty($sqlorderproduct)) {
                                                        foreach ($sqlorderproduct as $product):
                                                            ?>
                                                            <tr class="class0" id="0">
                                                                <td>
                                                                    <?php echo $sl; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $product->name; ?>
                                                                </td>
                                                                <td style="text-align:right;">
                                                                    <?php
                                                                    echo $product->quantity;
                                                                    $products_quantity+=$product->quantity;
                                                                    ?>
                                                                </td>
                                                                <td style="text-align:right;">
                                                                    <?php echo $product->unit_price; ?>
                                                                </td>
                                                                <td style="text-align:right;">
                                                                    <?php echo $product->retail_price; ?>
                                                                </td>
                                                                <?php if ($input_status == 3 || $input_status == 4) { ?>
                                                                    <td align="center"><label>
                                                                            <?php
                                                                            if ($product->status == 1) {
                                                                                ?>
                                                                                <a class="btn btn-info" href="<?php echo $obj->filename(); ?>?order_id=<?php echo $product->order_id; ?>&id=<?php echo $product->id; ?>"><i class="icon-plus-sign"></i></a>
                                                                                <?php
                                                                            }else {
                                                                                ?>
                                                                                <a class="btn btn-success" href="#"><i class="icon-check"></i></a>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </label></td>
                                                                <?php }else { ?>
                                                                    <td style="text-align:right;">
                                                                        <?php echo $product->sname; ?>
                                                                    </td>
                                                                    <td style="text-align:right;">
                                                                        <?php echo $product->received_date; ?>
                                                                    </td>
                                                                <?php } ?>
                                                            </tr>
                                                            <?php
                                                            $total_unit_price+=$product->unit_price;
                                                            $total_retail_price+=$product->retail_price;
                                                            $products+=1;
                                                            $sl++;
                                                        endforeach;
                                                    }
                                                    ?>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td align="left">
                                                            Total product : <?php echo $products; ?>
                                                        </td>
                                                        <td align="right">
                                                            Total product : <?php echo $products_quantity; ?>
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <input type="text" class="required equalTo small" style="font-weight:bolder; width:100px; background:none; border:0px; text-align:right;" readonly value="<?php echo number_format($total_unit_price, 2); ?>" name="totalunitprice" id="totalunitprice">
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <input type="text" class="required equalTo small" style="font-weight:bolder; width:100px; background:none; border:0px; text-align:right;" readonly value="<?php echo number_format($total_retail_price, 2); ?>" name="totalretailprice" id="totalretailprice">
                                                        </td>
                                                        <?php if ($input_status == 3 || $input_status == 4) { ?>
                                                            <td></td>
                                                        <?php }else { ?>
                                                            <td colspan="2"></td>
                                                        <?php } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /general form elements -->



                                        <div class="clearfix"></div>

                                        <!-- Default datatable -->

                                        <!-- /default datatable -->


                                    </fieldset>

                                </form>


                                <!-- Content End from here customized -->




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
            <?php //include('include/sidebar_right.php');              ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->
    </body>
</html>
