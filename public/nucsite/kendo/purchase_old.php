<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    if (!isset($_GET['edit'])) {
        $obj->Error("Invalid Request.", "purchase_list_order.php");
    }
}
$table="purchase";
if (isset($_POST['create'])) {
    extract($_POST);
    if (!empty($vendor) && !empty($expect_date) && !empty($ship_notes) && !empty($gener_notes)) {
        if ($obj->insert($table, array("vendor"=>$vendor, "store_id"=>$input_by, "expec_date"=>$expect_date, "ship_notes"=>$ship_notes, "gene_notes"=>$gener_notes, "total"=>$total, "date"=>date('Y-m-d'), "status"=>1)) == 1) {
            $obj->Success("Successfully Saved.", $obj->filename());
        }else {
            $obj->Error("Something is wrong, Try again.", $obj->filename());
        }
    }else {
        $obj->Error("Failed, Fill up required field", $obj->filename());
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
                            <h5><i class="font-cogs"></i> New Purchase Order </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');    ?>
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
                                        <?php if (isset($_GET['edit'])) { ?>
                                            <div class="row-fluid  span12 well">
                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px;">

                                                    <div class="control-group">
                                                        <label class="span12"> Vendor </label>
                                                        <input class="span10" <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?> value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "vendor"); ?>" type="text" name="vendor" />
                                                        <input class="span10" <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  value="<?php echo $_GET['edit']; ?>" type="hidden" name="id" />
                                                        <input class="span10" <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  value="<?php echo $_GET['edit']; ?>" type="hidden" name="edit" />
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="span12"> Expected date </label>
                                                        <input size="10"  <?php if ($editst == TRUE) { ?> readonly="readonly" <?php }else { ?>  class="datepicker"  <?php } ?>  value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "expec_date"); ?>" name="expect_date" type="text">
                                                    </div>


                                                    <div class="control-group">
                                                        <label class="span12"> Shipping notes </label>
                                                        <textarea rows="5"  <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  cols="5"  name="ship_notes" class="span10"><?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "ship_notes"); ?></textarea>
                                                    </div>


                                                </div>
                                                <!-- /selects, dropdowns -->



                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px; float:right;">


                                                    <div class="control-group">
                                                        <label class="span12"> General notes </label>
                                                        <textarea  <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  rows="5" cols="5" name="gener_notes" class="span10"><?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "gene_notes"); ?></textarea>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="span12"> Total Cost </label>
                                                        <input class="span10"  <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  type="text" name="total"   value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "total"); ?>"  />
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="span12"> Order Status </label>
                                                        <?php $order_status=$obj->SelectAllByVal($table, "id", $_GET['edit'], "status"); ?>
                                                        <select name="status">
                                                            <option <?php if ($order_status == 1) { ?> selected <?php } ?> value="1">Pending</option>
                                                            <option <?php if ($order_status == 2) { ?> selected <?php } ?> value="2">Partial</option>
                                                            <option <?php if ($order_status == 3) { ?> selected <?php } ?> value="3">Completed</option>
                                                        </select>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">&nbsp;</label>
                                                        <div class="controls"><button type="submit" name="editcreate" class="btn btn-success"><i class="icon-cog"></i> Update Changes </button></div>
                                                    </div>
                                                </div>
                                                <!-- /selects, dropdowns -->



                                            </div>
                                            <!-- /general form elements -->

                                        <?php }else { ?>
                                            <div class="row-fluid  span12 well">
                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px;">

                                                    <div class="control-group">
                                                        <label class="span12"> Vendor </label>
                                                        <input class="span10" type="text" name="vendor" />
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="span12"> Expected date </label>
                                                        <input size="10" class="datepicker" name="expect_date" type="text">
                                                    </div>


                                                    <div class="control-group">
                                                        <label class="span12"> Shipping notes </label>
                                                        <textarea rows="5" cols="5" name="ship_notes" class="span10"></textarea>
                                                    </div>


                                                </div>
                                                <!-- /selects, dropdowns -->



                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px; float:right;">


                                                    <div class="control-group">
                                                        <label class="span12"> General notes </label>
                                                        <textarea rows="5" cols="5" name="gener_notes" class="span10"></textarea>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="span12"> Total Cost </label>
                                                        <input class="span10" type="text" name="total" />
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">&nbsp;</label>
                                                        <div class="controls"><button type="submit" name="create" class="btn btn-success"><i class="icon-cog"></i> Save Changes </button></div>
                                                    </div>
                                                </div>
                                                <!-- /selects, dropdowns -->



                                            </div>
                                            <!-- /general form elements -->
                                        <?php } ?>


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
            <?php //include('include/sidebar_right.php');     ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
